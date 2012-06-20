<?php

    // namespace
    namespace Plugin;

    // check to ensure the Template library is included
    if (!class_exists('Template')) {

        // specify requirement
        $msg = 'The library *PHP-Template*, available at ' .
            '*https://github.com/onassar/PHP-Template* must be included. If ' .
            'it has been checked out, ensure you have included both ' .
            '*Template.class.php* and *TemplateTag.class.php* classes.';
        throw new \Exception($msg);
    }

    /**
     * Template
     * 
     * TurtlePHP Template Plugin runs your buffer/body through the PHP-Template
     * library. It uses tags that were defined using that library to update and
     * replace your markup with the respective tag's values.
     * 
     * For example, it can replace the tags `<hw />` with the string
     * `Hello World!` after that page has been rendered programatically, but
     * before it's been flushed to the output stream.
     * 
     * @todo     Add benchmarking (execution time for templating)
     * @see      https://github.com/onassar/PHP-Template
     * @author   Oliver Nassar <onassar@gmail.com>
     * @abstract
     */
    abstract class Template
    {
        /**
         * init
         * 
         * Initializes the template plugin by registering a callback method for
         * converting tags.
         * 
         * @access public
         * @static
         * @return void
         */
        public static function init()
        {
            // templating callback
            \Turtle\Request::addCallback(function($buffer) {

                // render the markup through the templating engine
                return \Template::render($buffer);
            });
        }
    }
