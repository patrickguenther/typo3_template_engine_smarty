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

abstract class AbstractSmartyModifier {
	/**
	 * @var SmartyTemplateEngine
	 */
	protected $smarty = null;

	protected $methodName = 'modify';

	public function __construct(SmartyTemplateEngine $smarty) {
		$this->smarty = $smarty;
	}

	public function getMethodName() {
		if(!method_exists($this, $this->methodName)) {
			throw new \SmartyException('Method ' . $this->methodName . ' does not exist.');
		}
		return $this->methodName;
	}
}