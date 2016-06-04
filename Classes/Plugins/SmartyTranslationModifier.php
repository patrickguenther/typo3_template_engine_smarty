<?php
namespace Pgu\TemplateEngineSmarty\Plugins;

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
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Lang\LanguageService;

class SmartyTranslationModifier extends AbstractSmartyModifier {
	protected $methodName = 'translate';

	/**
	 * @var LanguageService $languageService
	 */
	private $languageService = null;
	
	public function __construct(SmartyTemplateEngine $smarty) {
		parent::__construct($smarty);
		$extKey = $smarty->getExtensionKey();
		$langFile = GeneralUtility::getFileAbsFileName('EXT:' . $extKey . '/Resources/Private/Language/locallang.xlf');
		$this->languageService = PguUtility::getLanguageService();
		if(file_exists($langFile)) {
			$this->languageService->includeLLFile($langFile, true);
		}
	}

	public function translate($value) {
		return $this->languageService->getLL($value);
	}
}