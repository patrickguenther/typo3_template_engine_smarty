.. include:: ../Includes.rst

Content Object
--------------

You can use the smarty template engine in TypoScript setup for rendering definitions of content objects or for the page
layout.

.. container:: table-row
    Property
        templateFile

    Data type
        string

    Description
        Path to the template file. Can be a reference. The following example will try to load the template at
        typo3conf/ext/my_extension/Resources/Private/mysc/part.tpl

        ::

            EXT:my_extension:mysc/part.tpl


.. container:: table-row
    Property
        variables

    Data type
        array

    Description
        Each of the array keys will be accessible as a template variable. The variable's value will be the rendered
        Content object.

::

    page = PAGE
    page.10 = SMARTYTEMPLATE
    page.10 {
      templateFile=templates/layout/default.tpl
      variables {
        content=CONTENT
        content {
          table=tt_content
          select {
            where=colPos=0
            orderBy=sorting
          }
        }
      }
    }

With that definition of your page object, you can use :smarty:`{$content}` to display the page content.