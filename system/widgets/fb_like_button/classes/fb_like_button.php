<?php
namespace YAWK\WIDGETS\FACEBOOK\LIKEBUTTON
{
    /**
     * @details<b>Facebook Like Button - embed a like button on your page</b>
     *
     * <p>If you want to bring attention to your facebook page, you might want to add
     * a 'like me on facebook' button to your page. With this widget, you can do that
     * very easily. You can configure some settings, like width, height, layout, color
     * scheme and much more.</p>
     *
     *
     * @author     Daniel Retzl <danielretzl@gmail.com>
     * @copyright  2018 Daniel Retzl
     * @version    1.0.0
     * @brief Facebook Like Button - embed a like button on your page
     */
    class fbLikeButton extends \YAWK\widget
    {
        /** @param object global widget object data */
        public $widget = '';
        public $fbLikeButtonWidth = "450";
        public $fbLikeButtonHeight = "35";
        public $fbLikeButtonUrl = "http%3A%2F%2Fwww.facebook.com%2Fplatform";
        public $fbLikeButtonAppID = "";	// "100710516666226";
        public $fbLikeButtonColorscheme = "light";
        public $fbLikeButtonLayout = "standard";
        public $fbLikeButtonAction = "like";
        public $fbLikeButtonSize = "small";
        public $fbLikeButtonShowFaces = "false";
        public $fbLikeButtonShare = "false";

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
         * @brief Init facebook like button
         * @brief Facebook Like Button
         */
        public function init()
        {   // embed like Button
            $this->embedLikeButton();
        }

        public function embedLikeButton()
        {   // check if url is set
            if (isset($this->fbLikeButtonUrl) && (!empty($this->fbLikeButtonUrl)))
            {   // encode url string
                $this->fbLikeButtonUrl = rawurlencode($this->fbLikeButtonUrl);
            }
            // embed facebook like button
            // REMEMBER: this could be blocked by AdBlock Browser Plugins
            echo '<iframe src="https://www.facebook.com/plugins/like.php?href='.$this->fbLikeButtonUrl.'&width='.$this->fbLikeButtonWidth.'&layout='.$this->fbLikeButtonLayout.'&action='.$this->fbLikeButtonAction.'&size='.$this->fbLikeButtonSize.'&show_faces='.$this->fbLikeButtonShowFaces.'&share='.$this->fbLikeButtonShare.'&height='.$this->fbLikeButtonHeight.'&appId='.$this->fbLikeButtonAppID.'" width="'.$this->fbLikeButtonWidth.'" height="'.$this->fbLikeButtonHeight.'" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowTransparency="true"></iframe>';
        }
    }
}
?>