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
     * @todo   Add benchmarking (execution time for templating)
     * @see    https://github.com/onassar/PHP-Template
     * @author Oliver Nassar <onassar@gmail.com>
     */
    class Template
    {
        /**
         * _hash
         * 
         * @var    array
         * @access protected
         */
        protected $_hash;

        /**
         * init
         * 
         * Initializes the template-plugin by registering a callback method for
         * converting tags.
         * 
         * Passes a <header> to the buffer, recording the duration for the
         * templating process.
         * 
         * @access public
         * @param  Request $request
         * @return void
         */
        public function __construct(\Turtle\Request $request)
        {
            // instance reference
            $self = $this;

            // templating callback
            $request->addCallback(function($buffer) use ($request, $self) {

                // request-path header
                $self->setPathHeader($request);

                // start time
                $start = microtime(true);

                // render the markup through the templating engine
                $rendered = \Template::render($buffer);

                // end time
                $end = microtime(true);

                // pass as header
                $duration = round($end - $start, 4);
                header(
                    'TurtlePHP-' . ($self->getHash()) . '-Templating: ' .
                    ($duration)
                );

                // return rendered
                return $rendered;
            });
        }

        /**
         * getHash
         * 
         * @access public
         * @return String
         */
        public function getHash()
        {
            return $this->_hash;
        }

        /**
         * setPathHeader
         * 
         * @access public
         * @param  Request $request
         * @return void
         */
        public function setPathHeader(\Turtle\Request $request)
        {
            // set path (for header passing)
            $route = $request->getRoute();
            $path = $route['path'];

            // grab md5 and truncate it
            $md5 = md5($path);
            $md5 = substr($md5, 0, 6);

            // set instance md5
            $this->_hash = $md5;

            // set path header
            header('TurtlePHP-' . ($md5) . ': ' . ($path));
        }
    }
