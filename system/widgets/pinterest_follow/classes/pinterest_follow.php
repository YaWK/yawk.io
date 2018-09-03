<?php
namespace YAWK\WIDGETS\PINTEREST\FOLLOW
{
    /**
     * <b>Pinterest Follow Widget - add a follow me on pinterest button to your page.</b>
     *
     * <p>If you want to pay attention to your pinterest channel, embed this widget.
     * All you need to enter is any pinterest url to follow. Like any other widget,
     * you can add a heading and a subtext that will be displayed above this widget.</p>
     *
     * @package    YAWK
     * @author     Daniel Retzl <danielretzl@gmail.com>
     * @copyright  2018 Daniel Retzl
     * @license    https://opensource.org/licenses/MIT
     * @version    1.0.0
     * @link       http://yawk.io
     * @annotation Pinterest Follow Widget
     */
    class pinterestFollow extends \YAWK\widget
    {
        /** @var object global widget object data */
        public $widget = '';
        /** @var string Title that will be shown above widget */
        public $pinterestFollowHeading = '';
        /** @var string Subtext will be displayed beside title */
        public $pinterestFollowSubtext = '';
        /** @var string The URL of your pinterest channel */
        public $pinterestFollowUrl = '';

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
         * Init example widget and call a function for demo purpose
         * @author Daniel Retzl <danielretzl@gmail.com>
         * @version 1.0.0
         * @link http://yawk.io
         * @annotation Example Widget Init
         */
        public function init()
        {   // draw headline on screen
            echo $this->getHeading($this->pinterestFollowHeading, $this->pinterestFollowSubtext);
            $this->embedPinterestFollow();
        }

        /**
         * Embed Pinterest Follow Button
         * @author Daniel Retzl <danielretzl@gmail.com>
         * @version 1.0.0
         * @link http://yawk.io
         * @annotation Embed Pinterest Follow Button
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