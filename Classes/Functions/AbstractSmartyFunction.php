<?php

namespace Pgu\TemplateEngineSmarty\Functions;

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

abstract class AbstractSmartyFunction {
	/**
	 * @var SmartyTemplateEngine $smarty
	 */
	protected $smarty;

	public function __construct(SmartyTemplateEngine $smarty)
	{
		$this->smarty = $smarty;
	}

	abstract public function execute($params, \Smarty_Internal_Template $template);
}