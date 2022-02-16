<?php
namespace YAWK\WIDGETS\FACEBOOK\POSTING
{
    /**
     * @details<b>Facebook Posting - embed any public facebook posting on your page</b>
     *
     * <p>Use this widget if you want to embed a facebook posting on your page.
     * You can embed any posting, as long as it is public. </p>
     *
     *
     * @author     Daniel Retzl <danielretzl@gmail.com>
     * @copyright  2018 Daniel Retzl
     * @version    1.0.0
     * @brief Facebook Like Page - embed like my facebook page
     */
    class fbPosting extends \YAWK\widget
    {
        /** @param object global widget object data */
        public $widget = '';
        /** @param string Html code that you get from facebook */
        public $fbPostEmbedCode = "";
        /** @param string Width of the posting in px or percent */
        public $fbPostWidth = "450";
        /** @param string Height of the posting in px or percent */
        public $fbPostHeight = "265";
        /** @param object string Heading above the facebook posting */
        public $fbPostHeading = "";
        /** @param object string Subtext beside the heading */
        public $fbPostSubtext = "";

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
         * @brief Init facebook posting
         * @brief Facebook Posting Widget
         */
        public function init()
        {
            // embed heading
            echo $this->getHeading($this->fbPostHeading, $this->fbPostSubtext);
            // embed like Page
            $this->embedPosting();
        }

        /**
         * @brief Embed any public facebook posting on your page
         * @brief Embed any public facebook posting on your page
         */
        public function embedPosting()
        {   // check if url is set
            if (isset($this->fbPostEmbedCode) && (!empty($this->fbPostEmbedCode)))
            {   // encode url string
                $this->fbPostEmbedCode = str_replace("width=\"500\"", "width=\"$this->fbPostWidth\"", $this->fbPostEmbedCode);
                $this->fbPostEmbedCode = str_replace("height=\"625\"", "height=\"$this->fbPostHeight\"", $this->fbPostEmbedCode);
                // embed facebook posting
                // REMEMBER: this could be blocked by AdBlock Browser Plugins
                echo $this->fbPostEmbedCode;
            }
            else
                {   // html embed code is not set - throw msg
                    echo "Unable to load Facebook Posting: Embed html code is not set or empty.";
                }
        }
    }
}
?>