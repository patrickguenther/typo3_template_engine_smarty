.. include::../includes.rst

The SmartyView class
====================

The extension provides the SmartyView class, which implements extbase's ViewInterface and can therefore be used in
extbase plugins. Simply set the protected property :php:`$defaultViewObjectName` of your ActionController to
:php:`Pgu\View\SmartyView\SmartyView::class`. The default template name of the current action should be located here:

::

    <extensionDirectory>/Resources/Private/Templates/<controllerName>/<actionName>.tpl
