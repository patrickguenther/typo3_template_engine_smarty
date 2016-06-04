.. include::../includes.rst

Content Object
--------------

You can use the smarty template engine in TypoScript setup for rendering definitions of content objects or for the page
layout.

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