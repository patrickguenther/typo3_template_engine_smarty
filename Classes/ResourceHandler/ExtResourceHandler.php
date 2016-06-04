<?php
namespace Pgu\TemplateEngineSmarty\ResourceHandler;

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
use Smarty_Internal_Template;
use Smarty_Template_Source;
use SmartyException;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class ExtResourceHandler extends \Smarty_Resource {

	/**
	 * Load template's source into current template object
	 *
	 * @param  Smarty_Template_Source $source source object
	 *
	 * @return string                 template source
	 * @throws SmartyException        if source cannot be loaded
	 */
	public function getContent(Smarty_Template_Source $source)
	{
		return file_get_contents($source->filepath);
	}

	/**
	 * populate Source Object with meta data from Resource
	 *
	 * @param Smarty_Template_Source $source source object
	 * @param Smarty_Internal_Template $_template template object
	 */
	public function populate(Smarty_Template_Source $source, Smarty_Internal_Template $_template = null)
	{
		$target = $source->name;
		$exTarget = explode(':', $target, 2);
		if(count($exTarget) !== 2) {
			throw new \SmartyException();
		}

		$templatePath = GeneralUtility::getFileAbsFileName(
			'EXT:' . $exTarget[0] . '/Resources/Private/Templates/' . $exTarget[1]
		);
		
		if(!file_exists($templatePath)) {
			throw new \SmartyException();
		}
		$source->filepath = $templatePath;
		$source->timestamp = filemtime($templatePath);
		$source->exists = true;
	}
}