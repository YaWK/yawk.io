<?php
namespace YAWK\WIDGETS\PINTEREST\PROFILE
{
    /**
     * <b>Pinterest Pin - embed a single pin on your page</b>
     *
     * <p>Use this widget to embed any single pin on your page. To get this widget to work,
     * enter any public pin url. Description can be shown or hidden, the size of your pin can
     * be changed and heading and subtext could be added as well. </p>
     *
     * @package    YAWK
     * @author     Daniel Retzl <danielretzl@gmail.com>
     * @copyright  2018 Daniel Retzl
     * @license    https://opensource.org/licenses/MIT
     * @version    1.0.0
     * @link       http://yawk.io
     * @annotation Pinterest Pin Widget
     */
    class pinterestProfile extends \YAWK\widget
    {
        /** @var object global widget object data */
        public $widget = '';
        /** @var string Title that will be shown above widget */
        public $pinterestProfileHeading = '';
        /** @var string Subtext will be displayed beside title */
        public $pinterestProfileSubtext = '';
        /** @var string The URL of your pinterest channel */
        public $pinterestProfileUrl="https://www.pinterest.com/pin/99360735500167749/";
        /** @var int Profile Width in pixels */
        public $pinterestProfileWidth = 900;
        /** @var int Profile Heightin pixels */
        public $pinterestProfileHeight = 500;

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
         * Init pinterest profile widget and call embed method
         * @author Daniel Retzl <danielretzl@gmail.com>
         * @version 1.0.0
         * @link http://yawk.io
         * @annotation Embed any public Pinterest Profile
         */
        public function init()
        {   // draw headline on screen
            echo $this->getHeading($this->pinterestProfileHeading, $this->pinterestProfileSubtext);
            $this->embedPinterestProfile();
        }

        /**
         * Embed Pinterest Profile
         * @author Daniel Retzl <danielretzl@gmail.com>
         * @version 1.0.0
         * @link http://yawk.io
         * @annotation Embed Pinterest Profile
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