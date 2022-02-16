<?php
namespace YAWK\WIDGETS\CHATURBATE\STREAM
{
    /**
     * @details<b>Embed any chaturbate channel or stream on your page.</b>
     *
     * <p>Chaturbate.com is an adult webcam streaming service. With this widget, you can embed any public
     * channel or stream from chaturbate onto your website. All you need is any chaturbate username you
     * wish to embed. But there are a few things to setup. If you like to, you are able to set width,
     * height sound settings and more. By using this widget, embedding a stream from chaturbate is very easy.</p>
     *
     *
     * @author     Daniel Retzl <danielretzl@gmail.com>
     * @copyright  2018 Daniel Retzl
     * @version    1.0.0
     * @brief Embed chaturbate room (or stream) on your website.
     */
    class chaturbate
    {
        /** @param object global widget object data */
        public $widget = '';
        /** @param string Chaturbate room name (username) */
        public $chaturbateRoom = '';
        /** @param string URL of your chaturbate stream */
        public $chaturbateVideoUrl = '';
        /** @param string Width in percent */
        public $chaturbateWidth = '100%';
        /** @param string Height in px */
        public $chaturbateHeight = '370';
        /** @param string Disable Sound */
        public $chaturbateDisableSound = '';
        /** @param string Disable Sound */
        public $chaturbateVideoOnly = '0';
        /** @param string Heading */
        public $chaturbateHeading = '';
        /** @param string Subtext */
        public $chaturbateSubtext = '';
        /** @param string Headline HTML Markup */
        public $chaturbateHeadline = '';

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
         * @brief Print all object data
         * @brief (for development and testing purpose)
         */
        public function printObject()
        {
            echo "<pre>";
            print_r($this);
            echo "</pre>";
        }

        public function init()
        {
            $this->setProperties();
            $this->embed();
        }

        /**
         * @brief Set widget properties from database and fill object params
         * @brief Load all widget settings.
         */
        public function setProperties()
        {
            // if a heading is set and not empty
            if (isset($this->chaturbateHeading) && (!empty($this->chaturbateHeading)))
            {   // add h1 tag to heading string
                $this->chaturbateHeading = "$this->chaturbateHeading";

                // if subtext is set, add <small> subtext to string
                if (isset($this->chaturbateSubtext) && (!empty($this->chaturbateSubtext)))
                {   // build a headline with heading and subtext
                    $this->chaturbateSubtext = "<small>$this->chaturbateSubtext</small>";
                    $this->chaturbateHeadline = "<h1>$this->chaturbateHeading&nbsp;"."$this->chaturbateSubtext</h1>";
                }
                else
                {   // build just a headline - without subtext
                    $this->chaturbateHeadline = "<h1>$this->chaturbateHeading</h1>";    // draw just the heading
                }
            }
            else
            {   // leave empty if it's not set
                $this->chaturbateHeadline = '';
            }

            if (substr($this->chaturbateWidth, -1) !== "%")
            {
                $this->chaturbateWidth = $this->chaturbateWidth."%";
            }

            // build video url
            $this->chaturbateVideoUrl = "https://chaturbate.com/embed/$this->chaturbateRoom?bgcolor=transparent&disable_sound=$this->chaturbateDisableSound&fullscreen=true&embed_video_only=$this->chaturbateVideoOnly&target=_blank";
        }

        /**
         * @brief Embed any chaturbate room on your website
         * @brief This method embeds the chaturbate stream
         */
        public function embed()
        {

echo"<style>
.videoWrapper {
            position: relative;
            padding-bottom: 56.25%; /* 16:9 */
            padding-top: 25px;
            height: 0;
}
.videoWrapper iframe {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            border: none;
        }
</style>";
            // HTML output
            echo "
<!-- chaturbate room stream iframe -->
$this->chaturbateHeadline
<div class=\"videoWrapper\">
<iframe src=\"$this->chaturbateVideoUrl\" 
        width=\"$this->chaturbateWidth\" 
        height=\"$this->chaturbateHeight\" 
        frameborder=\"0\"
        scrolling=\"no\">
</iframe></div>";
        }
    }
}
