<?php
namespace YAWK\WIDGETS\FACEBOOK\VIDEO
{
    /**
     * <b>Facebook video - embed any public facebook video on your page</b>
     *
     * <p>Use this widget if you want to embed a facebook video on your page.
     * You can embed any video, as long as it is public. </p>
     *
     * @package    YAWK
     * @author     Daniel Retzl <danielretzl@gmail.com>
     * @copyright  2018 Daniel Retzl
     * @license    https://opensource.org/licenses/MIT
     * @version    1.0.0
     * @link       http://yawk.io
     * @annotation Facebook Like Page - embed like my facebook page
     */
    class fbVideo extends \YAWK\widget
    {
        /** @var object global widget object data */
        public $widget = '';
        /** @var string Html code that you get from facebook */
        public $fbVideoEmbedCode = "";
        /** @var string Width of the video in px or percent */
        public $fbVideoWidth = "450";
        /** @var string Height of the video in px or percent */
        public $fbVideoHeight = "265";
        /** @var object string Heading above the facebook video */
        public $fbVideoHeading = "";
        /** @var object string Subtext beside the heading */
        public $fbVideoSubtext = "";

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
         * Init facebook video
         * @author Daniel Retzl <danielretzl@gmail.com>
         * @version 1.0.0
         * @link http://yawk.io
         * @annotation Facebook video Widget
         */
        public function init()
        {
            // embed heading
            echo $this->getHeading($this->fbVideoHeading, $this->fbVideoSubtext);
            // embed like Page
            $this->embedvideo();
        }

        /**
         * Embed any public facebook video on your page
         * @author Daniel Retzl <danielretzl@gmail.com>
         * @version 1.0.0
         * @link http://yawk.io
         * @annotation Embed any public facebook video on your page
         */
        public function embedVideo()
        {   // check if url is set
            if (isset($this->fbVideoEmbedCode) && (!empty($this->fbVideoEmbedCode)))
            {   // encode url string
                $this->fbVideoEmbedCode = str_replace("width=\"500\"", "width=\"$this->fbVideoWidth\"", $this->fbVideoEmbedCode);
                $this->fbVideoEmbedCode = str_replace("height=\"625\"", "height=\"$this->fbVideoHeight\"", $this->fbVideoEmbedCode);
                // embed facebook video
                // REMEMBER: this could be blocked by AdBlock Browser Plugins
                echo $this->fbVideoEmbedCode;
            }
            else
                {   // html embed code is not set - throw msg
                    echo "Unable to load Facebook video: Embed html code is not set or empty.";
                }
        }
    }
}
?>