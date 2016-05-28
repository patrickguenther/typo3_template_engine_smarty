<?php

namespace Pgu\View;
use Pgu\TemplateEngineSmarty\Engine\SmartyTemplateEngine;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Mvc\Controller\ControllerContext;
use TYPO3\CMS\Extbase\Mvc\View\ViewInterface;

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

class SmartyView implements ViewInterface {

	/**
	 * @var ControllerContext $controllerContext
	 */
	private $controllerContext;

	private $settings = array();

	/**
	 * @var SmartyTemplateEngine $smartyEngine;
	 */
	private $smartyEngine;

	public function __construct() {
		$this->smartyEngine = GeneralUtility::makeInstance(SmartyTemplateEngine::class);
	}

	/**
	 * Sets the current controller context
	 *
	 * @param ControllerContext $controllerContext
	 * @return void
	 */
	public function setControllerContext(ControllerContext $controllerContext)
	{
		$this->controllerContext = $controllerContext;
	}

	/**
	 * Add a variable to the view data collection.
	 * Can be chained, so $this->view->assign(..., ...)->assign(..., ...); is possible
	 *
	 * @param string $key Key of variable
	 * @param mixed $value Value of object
	 * @return \TYPO3\CMS\Extbase\Mvc\View\ViewInterface an instance of $this, to enable chaining
	 * @api
	 */
	public function assign($key, $value)
	{
		$this->smartyEngine->assign($key, $value);
	}

	/**
	 * Add multiple variables to the view data collection
	 *
	 * @param array $values array in the format array(key1 => value1, key2 => value2)
	 * @return \TYPO3\CMS\Extbase\Mvc\View\ViewInterface an instance of $this, to enable chaining
	 * @api
	 */
	public function assignMultiple(array $values)
	{
		foreach($values as $key => $value) {
			$this->smartyEngine->assign($key, $value);
		}
	}

	public function injectSettings(array $settings = null) {
		if($settings === null) return;
		$this->settings = $settings;
	}

	/**
	 * Tells if the view implementation can render the view for the given context.
	 *
	 * @param ControllerContext $controllerContext
	 * @return bool TRUE if the view has something useful to display, otherwise FALSE
	 * @api
	 */
	public function canRender(ControllerContext $controllerContext)
	{
		return true;
	}

	/**
	 * Renders the view
	 *
	 * @return string The rendered view
	 * @api
	 */
	public function render()
	{
		$controllerName = $this->controllerContext->getRequest()->getControllerName();
		$action = $this->controllerContext->getRequest()->getControllerActionName();
		$action = substr($action, -6);// Strips the 'Action' Part from the action name
		return $this->smartyEngine->fetch($controllerName . DS . $action . '.tpl');
	}

	/**
	 * Initializes this view.
	 *
	 * @return void
	 * @api
	 */
	public function initializeView()
	{
		$this->smartyEngine->setExtensionKey(
			$this->controllerContext->getRequest()->getControllerExtensionKey()
		);
	}
}