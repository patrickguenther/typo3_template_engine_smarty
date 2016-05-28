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
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Created by PhpStorm.
 * User: patrick
 * Date: 5/27/16
 * Time: 6:32 PM
 */

class DefaultTemplateHandler {
	private $extKey = '';

	public function __construct($extKey) {
		$this->extKey = $extKey;
	}

	public function handle($type, $name, &$content, &$modified, \Smarty $smarty) {
		switch($type) {
			case 'file':
				break;
			default:
				throw new \SmartyException('Cannot handle type: ' . $type);
		}

		$supposedSource = GeneralUtility::getFileAbsFileName(
			'EXT:' . $this->extKey . 'Resources/Private/Templates/' . $name
		);
		if(!file_exists($supposedSource)) {
			return false;
		}

		$content = file_get_contents($supposedSource);
		$modified = filemtime($supposedSource);
		return true;
	}
}