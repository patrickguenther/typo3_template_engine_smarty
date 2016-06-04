<?php

namespace Pgu\TemplateEngineSmarty\ContentObjects;

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
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Frontend\ContentObject\AbstractContentObject;
use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;

class SmartyTemplateContentObject extends AbstractContentObject {

	/**
	 * @var SmartyTemplateEngine $smarty
	 */
	private $smarty;

	public function __construct(ContentObjectRenderer $cObj) {
		parent::__construct($cObj);
		$this->smarty = GeneralUtility::makeInstance(SmartyTemplateEngine::class);
	}

	public function render($conf = array())
	{
		if(!isset($conf['templateFile'])) {
			throw new \Exception('RequiredParameter templateFile missing.');
		}
		foreach($conf['variables.'] as $key => $value) {
			if(substr($key, -1) === '.') {
				continue;
			}
			$subObjectConf = array();
			if(isset($conf['variables.'][$key . '.'])) {
				$subObjectConf = $conf['variables.'][$key . '.'];
			}
			$contentObject = $this->cObj->getContentObject($value);
			$this->smarty->assign(
				$key,
				$contentObject->render($subObjectConf)
			);
		}

		return $this->smarty->fetch($conf['templateFile']);
	}
}