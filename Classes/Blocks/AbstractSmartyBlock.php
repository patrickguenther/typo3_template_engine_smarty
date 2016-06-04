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

abstract class AbstractSmartyBlock {
	/**
	 * @var null|SmartyTemplateEngine
	 */
	protected $smarty = null;

	public function __construct(SmartyTemplateEngine $smarty) {
		$this->smarty = $smarty;
	}
	
	abstract public function evalBlock($params, $content, \Smarty_Internal_Template &$smarty, &$repeat);
}