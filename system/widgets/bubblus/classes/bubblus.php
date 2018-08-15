<?php
namespace YAWK\WIDGETS\BUBBLUS\MINDMAP
{
    /**
     * <b>Embed any bubbl.us mindmap on your page.</b>
     *
     * <p>Bubbl.us is a service, where you can create mindmaps and share them with your friends and the web.
     * With this widget, you are able to embed any public Bubbl.us mindmaps. Simply enter the URL of your
     * mindmap and a view settings. Embedding and sharing mindmaps has never been easier.</p>
     *
     * @package    YAWK
     * @author     Daniel Retzl <danielretzl@gmail.com>
     * @copyright  2018 Daniel Retzl
     * @license    https://opensource.org/licenses/MIT
     * @version    1.0.0
     * @link       http://yawk.io
     * @annotation Embed Bubbl.us Presentations on your pages.
     */
    class bubblus
    {
        /** @var object global widget object data */
        public $widget = '';
        /** @var string URL of your bubblus presentation */
        public $bubblusUrl = '';
        /** @var string Width in percent */
        public $bubblusWidth = '100%';
        /** @var string Height in px */
        public $bubblusHeight = '370';
        /** @var string Heading */
        public $bubblusHeading = '';
        /** @var string Subtext */
        public $bubblusSubtext = '';
        /** @var string Headline HTML Markup */
        public $bubblusHeadline = '';

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
         * Print all object data
         * @author Daniel Retzl <danielretzl@gmail.com>
         * @version 1.0.0
         * @link http://yawk.io
         * @annotation (for development and testing purpose)
         */
        public function printObject()
        {
            echo "<pre>";
            print_r($this);
            echo "</pre>";
        }

        /**
         * Set widget properties from database and fill object params
         * @author Daniel Retzl <danielretzl@gmail.com>
         * @version 1.0.0
         * @link http://yawk.io
         * @annotation Load all widget settings.
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
         * Embed any BubblUs mindmaps
         * @author Daniel Retzl <danielretzl@gmail.com>
         * @version 1.0.0
         * @link http://yawk.io
         * @annotation This method does the setup and embed job
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
