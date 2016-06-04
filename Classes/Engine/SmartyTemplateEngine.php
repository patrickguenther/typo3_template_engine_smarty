<?php

namespace Pgu\TemplateEngineSmarty\Engine;

/**
 * This file is part of the TYPO3 CMS project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

use Pgu\TemplateEngineSmarty\ResourceHandler\DefaultTemplateHandler;
use Pgu\TemplateEngineSmarty\SmartyPlugins\AbstractSmartyModifier;
use Pgu\TemplateEngineSmarty\Utility\PguUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class SmartyTemplateEngine extends \Smarty {
	private $extensionKey = null;
	private $pluginsInitialized = false;
	private $config = array();
	
	public function __construct()
	{
		parent::__construct();

		$this->config = $GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['template_engine_smarty'];
		$this->default_template_handler_func = array(
			GeneralUtility::makeInstance(DefaultTemplateHandler::class, 'template_engine_smarty'),
			'handle'
		);
	}

	private function registerResourceHandler()
	{
		foreach($this->config['resourceHandler'] as $name => $handlerClass) {
			/** @var \Smarty_Resource $resourceHandler */
			$resourceHandler = GeneralUtility::makeInstance($handlerClass);
			$this->registerResource(
				$name,
				$resourceHandler
			);
		}
	}
	
	private function initPlugins()
	{
		foreach($this->config['modifier'] as $pluginName => $pluginClass) {
			/** @var AbstractSmartyModifier $plugin */
			$plugin = GeneralUtility::makeInstance($pluginClass, $this);
			$this->registerPlugin(
				'modifier',
				$pluginName,
				array($plugin, $plugin->getMethodName())
			);
		}
	}
	
	private function registerFunctions()
	{
		foreach($this->config['functions'] as $functionName => $functionClass) {
			$functor = GeneralUtility::makeInstance($functionClass, $this);
			$this->registerPlugin(
				'function',
				$functionName,
				array($functor, 'execute')
			);
		}
	}

	private function initBlocks() {
		foreach($this->config['blocks'] as $blockName => $blockClass) {
			$block = GeneralUtility::makeInstance($blockClass, $this);
			$this->registerPlugin('block', $blockName, array($block, 'evalBlock'));
		}
	}
	
	public function setExtensionKey($extKey)
	{
		$this->extensionKey = $extKey;
		$templateDir = GeneralUtility::getFileAbsFileName('EXT:' . $extKey . '/Resources/Private/Templates/');
		$tmpPath = PATH_site . 'typo3temp/smarty/';
		$cacheDir = $tmpPath . 'cache/' . $extKey;
		$compileDir = $tmpPath . 'compile/' . $extKey;
		foreach(array($cacheDir, $compileDir) as $dir) {
			if(!file_exists($dir)) {
				$old = umask(0);
				mkdir($dir, 0775, true);
				umask($old);
			}
			elseif(!is_dir($dir)) {
				throw new \SmartyException('There is a file blocking one of the directories smarty wants to create');
			}
		}

		$this->setCompileDir($compileDir);
		$this->setCacheDir($cacheDir);
		$this->setTemplateDir($templateDir);

		$this->registerResourceHandler();
		$this->initPlugins();
		$this->registerFunctions();
		$this->initBlocks();
		$this->pluginsInitialized = true;
	}

	public function getExtensionKey()
	{
		return $this->extensionKey;
	}

	private function checkInitialization()
	{
		if($this->extensionKey !== null) {
			return;
		}
		$this->setExtensionKey('template_engine_smarty');
	}

	public function fetch($template = null, $cache_id = null, $compile_id = null, $parent = null)
	{
		$this->checkInitialization();
		return parent::fetch($template, $cache_id, $compile_id, $parent);
	}

	public function display($template = null, $cache_id = null, $compile_id = null, $parent = null)
	{
		$this->checkInitialization();
		parent::display($template, $cache_id, $compile_id, $parent);
	}
}