<?php
namespace YAWK\WIDGETS\GOOGLE\MAPS {
    /**
     * <b>Google Maps Widget - Embed a Google Map on your page</b>
     *
     * <p>This Widget serves all methods to draw any Google Map on your website.
     * To do this: go to Google Maps, click on embed and you will get a piece of html code.
     * Simply copy/paste the code into the textarea, click save and your google map
     * will be displayed in your chosen widget position.</p>
     *
     * @package    YAWK
     * @author     Daniel Retzl <danielretzl@gmail.com>
     * @copyright  2018 Daniel Retzl
     * @license    https://opensource.org/licenses/MIT
     * @version    1.0.0
     * @link       http://yawk.io
     * @annotation Embed Google Maps on your page.
     */
    class googleMaps extends \YAWK\widget
    {
        /** @var object global widget object data */
        public $widget = '';
        /** @var string the html code you'll get from google <iframe...> */
        public $googleMapsEmbedHtmlCode = '';
        /** @var string Heading above Google Map */
        public $googleMapsHeading = '';
        /** @var string Subtext beside heading */
        public $googleMapsSubtext = '';

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
        {   // output data to screen
            echo "<pre>";
            print_r($this);
            echo "</pre>";
        }

        /**
         * Init and embed Google Maps
         * @author Daniel Retzl <danielretzl@gmail.com>
         * @version 1.0.0
         * @link http://yawk.io
         * @annotation Embed Google Maps
         */
        public function init()
        {   // embed Google Maps
            $this->embed();
        }

        public function embed()
        {
            // draw heading above google map
            echo $this->getHeading($this->googleMapsHeading, $this->googleMapsSubtext);

            // check if embed html code is set and correct data type
            if (isset($this->googleMapsEmbedHtmlCode)
                && (!empty($this->googleMapsEmbedHtmlCode))
                && (is_string($this->googleMapsEmbedHtmlCode)))
            {
                // embed code seems to be valid -
                // draw Google Map...
                echo $this->googleMapsEmbedHtmlCode;
            }
            else
                {
                    echo "Here should be a Google Map, but the required embed code was not set.";
                }
        }
    }
}