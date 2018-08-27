<?php
namespace YAWK\WIDGETS\GOOGLE\ANALYTICS
{
    /**
     * <b>Google Analytics Widget - Embed Google Analytics on your page</b>
     *
     * <p>If you need to track your users with google analytics, you can use this widget.
     * It requires a tracking ID and allows a few settings. In order to work properly, it
     * is required to embed this widget on 'all pages' in any position that is not used
     * by anything else. A recommended position would be debug or any other empty position.</p>
     *
     * @package    YAWK
     * @author     Daniel Retzl <danielretzl@gmail.com>
     * @copyright  2018 Daniel Retzl
     * @license    https://opensource.org/licenses/MIT
     * @version    1.0.0
     * @link       http://yawk.io
     * @annotation Embed Google Analytics on your page.
     */
    class googleAnalytics extends \YAWK\widget
    {
        /** @var object global widget object data */
        public $widget = '';
        /** @var string Tracking Code */
        public $gaTrackingCode = '';

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
         * Init and embed Google Analytics
         * @author Daniel Retzl <danielretzl@gmail.com>
         * @version 1.0.0
         * @link http://yawk.io
         * @annotation Embed Google Analytics
         */
        public function init()
        {   // embed GoogleAnalytics
            $this->embed();
        }

        public function embed()
        {
            if (isset($this->gaTrackingCode)
                && (!empty($this->gaTrackingCode))
                && (is_string($this->gaTrackingCode)))
            {
                // make sure that the string contains no html
                $this->gaTrackingCode = strip_tags($this->gaTrackingCode);

                // tracking code seems to be valid -
                // embed Google Analytics
                echo"<!-- google analytics -->
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src=\"https://www.googletagmanager.com/gtag/js?id=$this->gaTrackingCode\"></script>
<script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', '$this->gaTrackingCode');
</script>";
            }
            else
                {   // tracking code not set, empty or wrong data type
                    echo "Google Analytics could not be loaded - tracking code not set, empty or wrong data type.";
                }
        }
    }
}
?>