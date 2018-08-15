<?php
namespace YAWK\WIDGETS\EMBED_PAGE\PAGE {
    /**
     * <b>Embed any static page in any widget position.</b>
     *
     * <p>Simply set the page you want to embed.</p>
     *
     * @package    YAWK
     * @author     Daniel Retzl <danielretzl@gmail.com>
     * @copyright  2018 Daniel Retzl
     * @license    https://opensource.org/licenses/MIT
     * @version    1.0.0
     * @link       http://yawk.io
     * @annotation Embed any static page in any widget position.
     */
    class embedPage
    {
        /** @var object global widget object data */
        public $widget = '';
        /** @var string The name of the page to embed */
        public $embedPageName = '';
        /** @var string File url, including path */
        public $file = '';

        /**
         * Load all widget settings from database and fill object
         * @author Daniel Retzl <danielretzl@gmail.com>
         * @version 1.0.0
         * @link http://yawk.io
         * @param object $db Database Object
         * @annotation Load all widget settings on object init.
         */
        public function __construct($db)
        {
            // load this widget settings from db
            $this->widget = new \YAWK\widget();
            $settings = $this->widget->getWidgetSettingsArray($db);
            foreach ($settings as $property => $value) {
                $this->$property = $value;
            }
        }

        /**
         * Init and embed static page
         * @author Daniel Retzl <danielretzl@gmail.com>
         * @version 1.0.0
         * @link http://yawk.io
         * @param object $db Database Object
         * @annotation Init and include static page.
         */
        public function init()
        {   // check if embed page name is set
            if (isset($this->embedPageName) && (!empty($this->embedPageName)))
            {
                // generate file name including path
                $this->file = "content/pages/$this->embedPageName";
                // check file extension
                if (substr($this->file, -5) == ".html")
                {   // remove last 5 chars and add .php to include correct file
                    $this->file = substr($this->file, 0, -5);
                    $this->file = $this->file.".php";
                }
                // check if file can be loaded
                if (is_file($this->file))
                {   // ok, include it
                    include ($this->file);
                }
                // if not, check if embedPageName can be loaded
                else if (is_file($this->embedPageName))
                {   // ok, include it
                    include ($this->embedPageName);
                }
                else
                {   // file not found
                    echo "Embed: $this->file not found!";
                }
            }
            else
            {   // no file was set...
                echo "Embed page name $this->embedPageName not set";
            }
        }
    }
}