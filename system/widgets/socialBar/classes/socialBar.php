<?php
namespace YAWK\WIDGETS\SOCIALBAR\DISPLAY
{
    /**
     * <b>Social Bar - display icons with links to your social network accounts</b>
     *
     * <p>Embed Links to Twitter, Facebook, Instagram, Pinterest, YouTube</p>
     *
     * @package    YAWK
     * @author     Daniel Retzl <danielretzl@gmail.com>
     * @copyright  2018 Daniel Retzl
     * @license    https://opensource.org/licenses/MIT
     * @version    1.0.0
     * @link       http://yawk.io
     * @annotation Social Bar display icons with links to your social network accounts
     */
    class socialBar extends \YAWK\widget
    {
        /** @var object global widget object data */
        public $widget = '';
        /** @var string Title that will be shown above widget */
        public $socialBarHeading = '';
        /** @var string Subtext will be displayed beside title */
        public $socialBarSubtext = '';

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
         * Init example widget and call a function for demo purpose
         * @author Daniel Retzl <danielretzl@gmail.com>
         * @version 1.0.0
         * @link http://yawk.io
         * @annotation Example Widget Init
         */
        public function init()
        {   // call any function or method you have previously defined in this class
            echo $this->getHeading($this->exampleHeading, $this->exampleSubtext);

        }

        public function displaySocialBar()
        {
            // draw headline on screen
            // ...
        }

    }
}
?>