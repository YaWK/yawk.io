<?php
namespace YAWK\WIDGETS\PINTEREST\PROFILE
{
    /**
     * @details<b>Pinterest Pin - embed a single pin on your page</b>
     *
     * <p>Use this widget to embed any single pin on your page. To get this widget to work,
     * enter any public pin url. Description can be shown or hidden, the size of your pin can
     * be changed and heading and subtext could be added as well. </p>
     *
     *
     * @author     Daniel Retzl <danielretzl@gmail.com>
     * @copyright  2018 Daniel Retzl
     * @version    1.0.0
     * @brief Pinterest Pin Widget
     */
    class pinterestProfile extends \YAWK\widget
    {
        /** @param object global widget object data */
        public $widget = '';
        /** @param string Title that will be shown above widget */
        public $pinterestProfileHeading = '';
        /** @param string Subtext will be displayed beside title */
        public $pinterestProfileSubtext = '';
        /** @param string The URL of your pinterest channel */
        public $pinterestProfileUrl="https://www.pinterest.com/pin/99360735500167749/";
        /** @param int Profile Width in pixels */
        public $pinterestProfileWidth = 900;
        /** @param int Profile Heightin pixels */
        public $pinterestProfileHeight = 500;

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
         * @brief Init pinterest profile widget and call embed method
         * @brief Embed any public Pinterest Profile
         */
        public function init()
        {   // draw headline on screen
            echo $this->getHeading($this->pinterestProfileHeading, $this->pinterestProfileSubtext);
            $this->embedPinterestProfile();
        }

        /**
         * @brief Embed Pinterest Profile
         * @brief Embed Pinterest Profile
         */
        public function embedPinterestProfile()
        {   // check if url is set
            if (isset($this->pinterestProfileUrl)
                && (!empty($this->pinterestProfileUrl)
                && (is_string($this->pinterestProfileUrl))))
            {   // embed pinterest follow button markup
                echo '
                <a data-pin-do="embedUser" data-pin-board-width="'.$this->pinterestProfileWidth.'" data-pin-scale-height="'.$this->pinterestProfileHeight.'" data-pin-scale-width="115" href="'.$this->pinterestProfileUrl.'"></a>
                <script async defer src="//assets.pinterest.com/js/pinit.js"></script>';
            }
            else
                {
                    echo "Here should be a pinterest profile, but no URL is set. Please enter your pinterest profile URL.";
                }
        }

    }
}
?>