<?php
namespace Pgu\SmartyTemplateEngine\Functions;

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

use Pgu\TemplateEngineSmarty\Engine\SmartyTemplateEngine;
use Pgu\TemplateEngineSmarty\Functions\AbstractSmartyFunction;
use Pgu\TemplateEngineSmarty\Utility\PguUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;
use TYPO3\CMS\Frontend\ContentObject\ImageContentObject;

class TypoImageFunction extends AbstractSmartyFunction {
	/** @var  ContentObjectRenderer */
	private $cObj;

	private $imgResourceParameters = array(
		'maxW' => true,
		'maxH' => true,
		'minW' => true,
		'minH' => true,
		'height' => true,
		'width' => true
	);

	public function __construct(SmartyTemplateEngine $smarty) {
		parent::__construct($smarty);
		$this->cObj = PguUtility::getTypoScriptFrontendController()->cObj;
	}

	public function execute($params, \Smarty_Internal_Template $template)
	{
		if(!isset($params['src'])) {
			throw new \SmartyException('src is required for typoImage-Function');
		}

		$imageConf = array(
			'file' => '',
			'file.' => array()
		);

		foreach($params as $name => $value) {
			switch($name) {
				case 'src':
					$imageConf['file'] = $this->getImageLink($value);
					break;
				case 'params':
					$imageConf['params'] = $value;
					break;
				default:
					if(isset($this->imgResourceParameters[$name])) {
						$imageConf['file.'][$name] = $value;
					}
					break;
			}
		}

		/** @var ImageContentObject $image */
		$image = $this->cObj->getContentObject('IMAGE');
		return $image->render($imageConf);
	}

	public function getImageLink($src) {
		$exSrc = GeneralUtility::trimExplode(':', $src, false, 2);
		if(count($exSrc) === 2) {
			switch($exSrc[0]) {
				case 'EXT':
					$src = GeneralUtility::getFileAbsFileName($exSrc[1]);
					break;
				case 'ROOT':
					$src = '/' . $exSrc[1];
					break;
				default:
					$src = 'fileadmin' . DS . $exSrc[1];
			}
		}
		else {
			$src = 'fileadmin' . DS . $src;
		}

		return $src;
	}
}