<?php

namespace Pgu\TemplateEngineSmarty\Blocks;

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
use Pgu\TemplateEngineSmarty\Utility\PguUtility;
use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;

/**
 * Created by PhpStorm.
 * User: patrick
 * Date: 5/29/16
 * Time: 5:11 PM
 */

class TypoLink extends AbstractSmartyBlock {
	/**
	 * @var ContentObjectRenderer $cObj
	 */
	private $cObj = null;

	public function __construct(SmartyTemplateEngine $smarty) {
		parent::__construct($smarty);
		$this->cObj = PguUtility::getTypoScriptFrontendController()->cObj;
	}

	public function evalBlock($params, $content, \Smarty_Internal_Template &$smarty, &$repeat)
	{
		if(!$repeat) {
			return $content . '</a>';
		}

		if(!isset($params['href'])) {
			throw new \SmartyException('Required parameter "parameter" missing.');
		}

		$url = $this->cObj->getTypoLink_URL($params['href']);

		$link = '<a href="' . $url . '"';
		if(isset($params['attr'])) {
			$link .= ' ' . $params['attr'];
		}
		$link .= '>';

		return $link;
	}
}