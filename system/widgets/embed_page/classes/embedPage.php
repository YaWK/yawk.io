<?php
namespace YAWK\WIDGETS\EMBED_PAGE\PAGE {
    /**
     * @details<b>Embed any static page in any widget position.</b>
     *
     * <p>Simply set the page you want to embed.</p>
     *
     *
     * @author     Daniel Retzl <danielretzl@gmail.com>
     * @copyright  2018 Daniel Retzl
     * @version    1.0.0
     * @brief Embed any static page in any widget position.
     */
    class embedPage
    {
        /** @param object global widget object data */
        public $widget = '';
        /** @param string The name of the page to embed */
        public $embedPageName = '';
        /** @param string File url, including path */
        public $file = '';

        /**
         * @brief Load all widget settings from database and fill object
         * @param object $db Database Object
         * @brief Load all widget settings on object init.
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
         * @brief Init and embed static page
         * @param object $db Database Object
         * @brief Init and include static page.
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