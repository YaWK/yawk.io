<?php
namespace YAWK\WIDGETS\TWITCH\EMBED
{
    /**
     * @details<b>Twitch Widget - embed any twitch channel</b>
     *
     * <p>Twitch is a gaming streaming platform. Use this widget to embed any
     * twitch channel. You can set your channel, width, height, either if the
     * chat should be displayed or not, allow fullscreen and more.</p>
     *
     *
     * @author     Daniel Retzl <danielretzl@gmail.com>
     * @copyright  2018 Daniel Retzl
     * @version    1.0.0
     * @brief Embed any Twitch channel
     */
    class twitch extends \YAWK\widget
    {
        /** @param object global widget object data */
        public $widget = '';
        /** @param string Title that will be shown above widget */
        public $twitchHeading = '';
        /** @param string Subtext will be displayed beside title */
        public $twitchSubtext = '';
        /** @param string Channel that will be included */
        public $twitchChannel = "yourChannel";
        /** @param string Height of your channel */
        public $twitchChannelHeight = "720";
        /** @param string Width of your channel */
        public $twitchChannelWidth = "100%";
        /** @param bool Allow fullscreen? */
        public $twitchChannelFullscreen = true;
        /** @param int Show chat window? */
        public $twitchChat = "1";
        /** @param int Chat window height */
        public $twitchChatHeight = "250";
        /** @param int Chat window width */
        public $twitchChatWidth = "100%";

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
         * @brief Init twitch widget
         * @brief Twitch Widget Init
         */
        public function init()
        {   // display heading
            echo $this->getHeading($this->twitchHeading, $this->twitchSubtext);
            // to output correct html
            if ($this->twitchChannelFullscreen === "true") {   // set fullscreen property
                $allowfullscreen = "allowfullscreen=\"true\"";
            } else {   // or leave empty if fullscreen should be false
                $allowfullscreen = '';
            }
// HTML output
            echo "
<!-- twitch video stream -->
<iframe
    src=\"http://player.twitch.tv/?channel=$this->twitchChannel\"
    height=\"$this->twitchChannelHeight\"
    width=\"$this->twitchChannelWidth\"
    frameborder=\"0\"
    scrolling=\"no\"
    $allowfullscreen\">
</iframe>";

// check if chat should be shown
            if (isset($this->twitchChat) && ($this->twitchChat === 1)) {   // ok, show chat html frame
                echo "

<!-- twitch chat -->
<iframe 
    frameborder=\"0\"
    scrolling=\"no\"
    src=\"http://www.twitch.tv/popout/$this->twitchChannel/chat\"
    height=\"$this->twitchChatHeight\"
    width=\"$this->twitchChatWidth\">
</iframe>";
            }
        }
    }
}
?>