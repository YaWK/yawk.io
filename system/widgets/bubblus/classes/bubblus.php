<?php
namespace YAWK\WIDGETS\BUBBLUS\MINDMAP
{
    /**
     * @details<b>Embed any bubbl.us mindmap on your page.</b>
     *
     * <p>Bubbl.us is a service, where you can create mindmaps and share them with your friends and the web.
     * With this widget, you are able to embed any public Bubbl.us mindmaps. Simply enter the URL of your
     * mindmap and a view settings. Embedding and sharing mindmaps has never been easier.</p>
     *
     *
     * @author     Daniel Retzl <danielretzl@gmail.com>
     * @copyright  2018 Daniel Retzl
     * @version    1.0.0
     * @brief Embed Bubbl.us Presentations on your pages.
     */
    class bubblus
    {
        /** @param object global widget object data */
        public $widget = '';
        /** @param string URL of your bubblus presentation */
        public $bubblusUrl = '';
        /** @param string Width in percent */
        public $bubblusWidth = '100%';
        /** @param string Height in px */
        public $bubblusHeight = '370';
        /** @param string Heading */
        public $bubblusHeading = '';
        /** @param string Subtext */
        public $bubblusSubtext = '';
        /** @param string Headline HTML Markup */
        public $bubblusHeadline = '';

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
         * @brief Print all object data
         * @brief (for development and testing purpose)
         */
        public function printObject()
        {
            echo "<pre>";
            print_r($this);
            echo "</pre>";
        }

        /**
         * @brief Set widget properties from database and fill object params
         * @brief Load all widget settings.
         */
        public function setProperties()
        {
            // if a heading is set and not empty
            if (isset($this->bubblusHeading) && (!empty($this->bubblusHeading)))
            {
                // if subtext is set, add <small> subtext to string
                if (isset($this->bubblusSubtext) && (!empty($this->bubblusSubtext)))
                {   // build a headline with heading and subtext
                    $this->bubblusSubtext = "<small>$this->bubblusSubtext</small>";
                    $this->bubblusHeadline = "<div id=\"bubblusHeading\"><h1>$this->bubblusHeading&nbsp;"."$this->bubblusSubtext</h1></div>";
                }
                else
                {   // build just a headline - without subtext
                    $this->bubblusHeadline = "<h1>$this->bubblusHeading</h1>";    // draw just the heading
                }
            }
            else
            {   // leave empty if it's not set
                $this->bubblusHeadline = '';
            }

            // prepare url
            if (isset($this->bubblusUrl) && (!empty($this->bubblusUrl)))
            {   // remove trailing slash
                $this->bubbleusUrl = rtrim("/", $this->bubblusUrl);
            }
        }

        /**
         * @brief Embed any BubblUs mindmaps
         * @brief This method does the setup and embed job
         */
        public function init()
        {
            // set widget obj properties
            $this->setProperties();
            // draw headline, if set
            echo "$this->bubblusHeadline";
            // embed mindmap via iframe...
            echo "<iframe width=\"$this->bubblusWidth\" height=\"$this->bubblusHeight\" allowfullscreen frameborder=\"0\" src=\"$this->bubblusUrl\"></iframe>";
        }
    }
}
