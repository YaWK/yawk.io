<?php
namespace YAWK\WIDGETS\GOOGLE\ANALYTICS
{
    /**
     * @details<b>Google Analytics Widget - Embed Google Analytics on your page</b>
     *
     * <p>If you need to track your users with google analytics, you can use this widget.
     * It requires a tracking ID and allows a few settings. In order to work properly, it
     * is required to embed this widget on 'all pages' in any position that is not used
     * by anything else. A recommended position would be debug or any other empty position.</p>
     *
     *
     * @author     Daniel Retzl <danielretzl@gmail.com>
     * @copyright  2018 Daniel Retzl
     * @version    1.0.0
     * @brief Embed Google Analytics on your page.
     */
    class googleAnalytics extends \YAWK\widget
    {
        /** @param object global widget object data */
        public $widget = '';
        /** @param string Tracking ID */
        public $gaTrackingID = '';
        /** @param string Tracking Code */
        public $gaTrackingCode = '';

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
                $this->gaTrackingID = $this->gaTrackingCode;
            }
        }

        /**
         * @brief Print all object data
         * @brief (for development and testing purpose)
         */
        public function printObject()
        {   // output data to screen
            echo "<pre>";
            print_r($this);
            echo "</pre>";
        }

        /**
         * @brief Init and embed Google Analytics
         * @brief Embed Google Analytics
         */
        public function init()
        {   // embed GoogleAnalytics
            $this->embed();
        }

        public function embed()
        {
            if (isset($this->gaTrackingID)
            && (!empty($this->gaTrackingID)))
            {
                // make sure that the string contains no html
                $this->gaTrackingID = strip_tags($this->gaTrackingID);

                // tracking code seems to be valid -
                // embed Google Analytics
                echo'<!-- google analytics -->
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id='.$this->gaTrackingID.'"></script>
<script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag(\'js\', new Date());
    gtag(\'config\', \''.$this->gaTrackingCode.'\');
</script>';
            }
            else
                {   // tracking code not set, empty or wrong data type
                    echo "Google Analytics could not be loaded - tracking code not set, empty or wrong data type.";
                }
        }
    }
}
?>