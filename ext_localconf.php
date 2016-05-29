<?php
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

/**
 * Created by PhpStorm.
 * User: patrick
 * Date: 5/26/16
 * Time: 8:17 PM
 */

$GLOBALS['TYPO3_CONF_VARS']['FE']['ContentObjects']['SMARTYTEMPLATE'] =
	'Pgu\\TemplateEngineSmarty\\ContentObjects\\SmartyTemplateContentObject';

$GLOBALS['TYPO3_CONF_VARS']['EXTCONF'][$_EXTKEY] = array();

$GLOBALS['TYPO3_CONF_VARS']['EXTCONF'][$_EXTKEY]['modifier'] = array(
	'i18n' => \Pgu\TemplateEngineSmarty\Plugins\SmartyTranslationModifier::class
);

$GLOBALS['TYPO3_CONF_VARS']['EXTCONF'][$_EXTKEY]['resourceHandler'] = array(
	'EXT' => \Pgu\TemplateEngineSmarty\ResourceHandler\ExtResourceHandler::class
);

$GLOBALS['TYPO3_CONF_VARS']['EXTCONF'][$_EXTKEY]['functions'] = array(
	'typoImage' => \Pgu\SmartyTemplateEngine\Functions\TypoImageFunction::class
);

$GLOBALS['TYPO3_CONF_VARS']['EXTCONF'][$_EXTKEY]['blocks'] = array(
	'typoLink' => \Pgu\TemplateEngineSmarty\Blocks\TypoLink::class
);

