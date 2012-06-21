TurtlePHP-TemplatePlugin
========================
TurtlePHP Template Plugin parses the buffer and replaces tags that were defined
through the [PHP-Template](https://github.com/onassar/PHP-Template) library with
their respective programmatic response.

It has the PHP-Template library is a requirement. It fails if it hasn't been
included.

This library acts primarily as a wrapper. When looking at the
[source](https://github.com/onassar/TurtlePHP-TemplatePlugin/blob/master/Template.class.php),
there isn't really much to it. A `Request` callback is defined which accepts the
buffer contents as a parameter, and runs it through the `Template::render`
method.

The only other action of this plugin is recording the performance. The
performance (in seconds) is passed as the `TurtlePHP-Templating` header.

### Sample Usage
```php
<?php

    // template
    require_once APP . '/vendors/PHP-Template/Template.class.php';
    require_once APP . '/vendors/PHP-Template/TemplateTag.class.php';
    require_once APP . '/vendors/PHP-Template/HelloWorldTag.class.php';
    \Template::addTag('HelloWorld');

    // plugin
    require_once APP . '/vendors/TurtlePHP-TemplatePlugin/Template.class.php';
    \Plugin\Template::init();

```

This will simply include the required classes, setup the `HelloWorld` tag to be
converted programmatically (through the `HelloWorldTag.class.php` file), and
initiate the `Template` plugin (as can be seen through the `Plugin` namespace).

Everything else is done automatically. If you want any other custom-tags to be
programtically replaced, check out the PHP-Template library, and remember to add
that tag through the `Template::addTag` method.

### Sample Templating Performance Header
The following header will be sent along with the response by the framework:

```bash
TurtlePHP-Templating: 0.0001
```

They can easily be viewed by the document through your browser&#039;s
debug/inspector tool.
