<?php
namespace Pgu\TemplateEngineSmarty\Utility;

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

use TYPO3\CMS\Backend\Utility\BackendUtility;
use TYPO3\CMS\Core\TimeTracker\TimeTracker;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;
use TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController;
use TYPO3\CMS\Lang\LanguageService;

/**
 * Created by PhpStorm.
 * User: patrick
 * Date: 5/27/16
 * Time: 6:58 PM
 */

class PguUtility {
	/**
	 * @return TypoScriptFrontendController $tsfe
	 * @throws \TYPO3\CMS\Core\Error\Http\ServiceUnavailableException
	 */
	public static function getTypoScriptFrontendController() {
		$cntrl = $GLOBALS['TSFE'];
		if($cntrl === null) {
			if(!is_object($GLOBALS['TT'])) {
				/** @var TimeTracker $tt */
				$tt = GeneralUtility::makeInstance(TimeTracker::class);
				$tt->start();
				$GLOBALS['TT'] = $tt;
			}
			
			/** @var TypoScriptFrontendController $cntrl */
			$cntrl = $GLOBALS['TSFE'] = GeneralUtility::makeInstance(
				TypoScriptFrontendController::class,
				$GLOBALS['TYPO3_CONF_VARS'],
				1,
				0
			);
			$cntrl->connectToDB();
			$cntrl->initFEuser();
			$cntrl->determineId();
			$cntrl->initTemplate();
			$cntrl->getConfigArray();
			$cntrl->cObj = GeneralUtility::makeInstance(ContentObjectRenderer::class, $cntrl);
			if (ExtensionManagementUtility::isLoaded('realurl')) {
				$rootline = BackendUtility::BEgetRootLine(1);
				$host = BackendUtility::firstDomainRecord($rootline);
				$_SERVER['HTTP_HOST'] = $host;
			}
		}

		return $GLOBALS['TSFE'];
	}

	public static function getLanguageService() {
		$res = $GLOBALS['LANG'];
		if($res === null) {
			/** @var LanguageService $res */
			$res = $GLOBALS['LANG'] = GeneralUtility::makeInstance(LanguageService::class);
			$lang = self::getTypoScriptFrontendController()->sys_language_isocode;
			$res->init($lang);
		}
		$lang = self::getTypoScriptFrontendController()->sys_language_isocode;
		$res->init($lang);
		return $res;
	}
}