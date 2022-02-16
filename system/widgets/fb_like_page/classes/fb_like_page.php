<?php
namespace YAWK\WIDGETS\FACEBOOK\LIKEPAGE
{
    /**
     * @details<b>Facebook Like Page - embed a like my facebook page button</b>
     *
     * <p>If you want to bring attention to your facebook page, you might want to add
     * a 'like my facebook page' button to your page. With this widget, you can do that
     * very easily. You can configure some settings, like width, height, layout, and
     * much more.</p>
     *
     *
     * @author     Daniel Retzl <danielretzl@gmail.com>
     * @copyright  2018 Daniel Retzl
     * @version    1.0.0
     * @brief Facebook Like Page - embed like my facebook page
     */
    class fbLikePage extends \YAWK\widget
    {
        /** @param object global widget object data */
        public $widget = '';
        public $fbPageWidth = "450";
        public $fbPageHeight = "265";
        public $fbPageUrl = "http%3A%2F%2Fwww.facebook.com%2Fplatform";
        public $fbPageAppID = "";
        public $fbPageTabs = "timeline";
        public $fbPageSmallHeader = "false";
        public $fbPageAdaptContainerWidth = "true";
        public $fbPageHideCover = "false";
        public $fbShowFacepile = "true";
        public $fbPageHeading = "";
        public $fbPageSubtext = "";

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
         * @brief Init facebook like page
         * @brief Facebook Like Page
         */
        public function init()
        {
            // embed heading
            echo $this->getHeading($this->fbPageHeading, $this->fbPageSubtext);
            // embed like Page
            $this->embedLikePage();
        }

        public function embedLikePage()
        {   // check if url is set
            if (isset($this->fbPageUrl) && (!empty($this->fbPageUrl)))
            {   // encode url string
                $this->fbPageUrl = rawurlencode($this->fbPageUrl);
            }
            // embed facebook like button
            // REMEMBER: this could be blocked by AdBlock Browser Plugins
            echo '<iframe src="https://www.facebook.com/plugins/page.php?href='.$this->fbPageUrl.'&tabs='.$this->fbPageTabs.'&width='.$this->fbPageWidth.'&height='.$this->fbPageHeight.'&small_header='.$this->fbPageSmallHeader.'&adapt_container_width='.$this->fbPageAdaptContainerWidth.'&hide_cover='.$this->fbPageHideCover.'&show_facepile='.$this->fbShowFacepile.'&appId='.$this->fbPageAppID.'" width="'.$this->fbPageWidth.'" height="'.$this->fbPageHeight.'" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowTransparency="true"></iframe>';
        }
    }
}
?>