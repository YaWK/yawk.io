<?php
namespace YAWK\WIDGETS\PINTEREST\FOLLOW
{
    /**
     * @details<b>Pinterest Follow Widget - add a follow me on pinterest button to your page.</b>
     *
     * <p>If you want to pay attention to your pinterest channel, embed this widget.
     * All you need to enter is any pinterest url to follow. Like any other widget,
     * you can add a heading and a subtext that will be displayed above this widget.</p>
     *
     *
     * @author     Daniel Retzl <danielretzl@gmail.com>
     * @copyright  2018 Daniel Retzl
     * @version    1.0.0
     * @brief Pinterest Follow Widget
     */
    class pinterestFollow extends \YAWK\widget
    {
        /** @param object global widget object data */
        public $widget = '';
        /** @param string Title that will be shown above widget */
        public $pinterestFollowHeading = '';
        /** @param string Subtext will be displayed beside title */
        public $pinterestFollowSubtext = '';
        /** @param string The URL of your pinterest channel */
        public $pinterestFollowUrl = '';

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
         * @brief Init example widget and call a function for demo purpose
         * @brief Example Widget Init
         */
        public function init()
        {   // draw headline on screen
            echo $this->getHeading($this->pinterestFollowHeading, $this->pinterestFollowSubtext);
            $this->embedPinterestFollow();
        }

        /**
         * @brief Embed Pinterest Follow Button
         * @brief Embed Pinterest Follow Button
         */
        public function embedPinterestFollow()
        {   // check if url is set
            if (isset($this->pinterestFollowUrl)
                && (!empty($this->pinterestFollowUrl)
                && (is_string($this->pinterestFollowUrl))))
            {   // embed pinterest follow button markup
                echo '
                    <a data-pin-do="buttonFollow" href="'.$this->pinterestFollowUrl.'">Pinterest</a>
                    <script async defer src="//assets.pinterest.com/js/pinit.js"></script>';
            }
            else
                {
                    echo "Here should be a pinterest follow button, but no URL is set. Please add your pinterest url.";
                }
        }

    }
}
?>