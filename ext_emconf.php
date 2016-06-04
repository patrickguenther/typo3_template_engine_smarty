<?php
$EM_CONF[$_EXTKEY] = array(
	'title' => 'Smarty Template Engine',
	'description' => 'Wrapper for the smarty template engine.',
	'category' => 'misc',
	'constraints' => array(
		'depends' => array(
			'typo3' => '7.5.0-7.8.99',
			'php' => '5.3.0-7.9.99'
		)
	),
	'state' => 'alpha',
	'author' => 'Patrick Günther',
	'author_email' => 'p.guenther86@googlemail.com',
	'author_company' => '',
	'version' => '0.9.1',
	'autoload' => array(
		'classmap' => array('vendor/smarty/smarty/', 'Classes')
	)
);