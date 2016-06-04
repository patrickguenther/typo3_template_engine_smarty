.. include::../includes.rst

Templating
==========

One powerful aspect of Smarty is, that it is easily extensible with modifier, function and blockfunction plugins and
resource handlers.

Feel free to add your own Smarty plugins to the TYPO3_CONF_VARS-Array to either of the following array keys in your
localconf.php:

.. code-block:: php

    $GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['template_engine_smarty']['modifier']
    $GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['template_engine_smarty']['functions']
    $GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['template_engine_smarty']['blocks']
    $GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['template_engine_smarty']['resourceHandler']

This extension already provides some smarty plugins for each these categories.



Modifiers
---------

The i18n-modifier exposes typo3's powerful translation-API to your smarty templates. By default the locallang.xlf files
of your extension are loaded and can be used in the your templates like so:

.. code-block:: smarty

{'your.index'|i18n}

Functions
---------

Use the typoImage function to render images:

Examples:

.. code-block:: smarty

    {* the file will be fetched from your fileadmin directory fileadmin/imgs/example.png *}
    {typoImage file="imgs/example.png"}

    {* You can also use the EXT: prefix to fetch images from your extension directories. *}
    {typoImage file="EXT:my_extension/Resources/Public/images/example.png" maxW="100" maxH="80"}

    {* or ROOT: to get them by any filepath relative to the typo3 directory *}
    {typoImage file="ROOT:header.jpg" params='class="img-responsive"'}

Block Functions
---------------

Like the IMAGE content object, the typoLink function can also be used in your templates

.. code-block:: smarty

    {typoLink href=$someUrl attr='class="btn btn-primary"'}
        Link label or some other smarty rendered content
    {/typoLink}

Since the href-Parameter is directly fed into the typoLink function you can also use page ids and email addresses.


Resource handler
----------------

Any smarty function argument that expects the path to a template also recognizes the EXT: prefix. The syntax however
in those cases is slightly different than what you might expect. You have to omit the Resources/Private/Templates-part
of those filepaths.

.. code-block:: smarty

    {* This will include the template located at EXT:my_extension/Resources/Private/Templates/misc/part.tpl *}
    {include file="EXT:my_extension_key:misc/part.tpl"}