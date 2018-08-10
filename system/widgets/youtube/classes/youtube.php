<?php
namespace YAWK\WIDGETS\YOUTUBE\VIDEO
{
    /**
     * <b>Embed any Facebook Video on your page.</b>
     *
     * <p>With this widget, you are able to embed any public YouTube Video that you like. Simply enter the
     * Video URL, set a few settings and you're good to go. You do not need to play around with html or
     * any YouTube embed code. This widget does all the work for you!</p>
     *
     * @package    YAWK
     * @author     Daniel Retzl <danielretzl@gmail.com>
     * @copyright  2018 Daniel Retzl
     * @license    https://opensource.org/licenses/MIT
     * @version    1.0.0
     * @link       http://yawk.io
     * @annotation Embed any YouTube Video on your pages.
     */
    class youtube
    {
        /** @var object global widget object data */
        public $widget = '';
        /** @var string YouTube Video URL */
        public $youtubeVideoUrl = '';
        /** @var bool true|false Allow embeded full screen mode? */
        public $youtubeFullscreen = true;
        /** @var bool string html markup for fullscreen mode */
        public $youtubeFullscreenMarkup = '';
        /** @var bool true|false Should the video automatically start on page load? */
        public $youtubeAutoplay = true;
        /** @var bool string autoplay html markup */
        public $youtubeAutoplayMarkup = '';
        /** @var string Video Height */
        public $youtubeHeight = '720';
        /** @var string Video Width */
        public $youtubeWidth = '100%';
        /** @var string Heading above video */
        public $youtubeHeading = '';
        /** @var string Subtext beside heading */
        public $youtubeSubtext = '';
        /** @var string Description below heading */
        public $youtubeDescription = '';
        /** @var string CSS Class */
        public $youtubeCssClass = '';
        /** @var string heading markup above video */
        public $headlineMarkup = '';
        /** @var string description markup below video */
        public $descriptionMarkup = '';
        /** @var string css markup */
        public $cssMarkup = '';

        /**
         * Load all widget settings from database and fill object params
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
         * Print all object data
         * @author Daniel Retzl <danielretzl@gmail.com>
         * @version 1.0.0
         * @link http://yawk.io
         * @annotation (for development and testing purpose)
         */
        public function printObject()
        {
            echo "<pre>";
            print_r($this);
            echo "</pre>";
        }

        /**
         * Check settings and embed the YouTube Video
         * @author Daniel Retzl <danielretzl@gmail.com>
         * @version 1.0.0
         * @link http://yawk.io
         * @annotation This method does the setup and embed job
         */
        public function embedVideo()
        {
            // check if full screen is allowed
            if ($this->youtubeFullscreen == "true")
            {   // set full screen html markup
                $this->youtubeFullscreenMarkup = "allowfullscreen=\"true\"";
            }
            else
            {   // no full screen, no markup
                $this->youtubeFullscreenMarkup = '';
            }

            // check if autoplay is allowed
            if ($this->youtubeAutoplay == "true")
            {   // set autoplay markup
                $this->youtubeAutoplayMarkup = "?autoplay=1";
            }
            else
            {   // no autoplay, no markup
                $this->youtubeAutoplayMarkup = '';
            }

            // check if a class is set
            if (isset($this->youtubeCssClass) && (!empty($this->youtubeCssClass)))
            {
                $this->cssMarkup = " class=\"$this->youtubeCssClass\"";
            }
            else
                {
                    $this->cssMarkup = '';
                }

            // if a heading is set and not empty
            if (isset($this->youtubeHeading) && (!empty($this->youtubeHeading)))
            {
                // check if subtext is set, add <small> subtext to string
                if (isset($this->youtubeSubtext) && (!empty($this->youtubeSubtext)))
                {   // build a headline with heading and subtext
                    $this->youtubeSubtext = "<small>$this->youtubeSubtext</small>";
                    $this->headlineMarkup = "<h1>$this->youtubeHeading&nbsp;$this->youtubeSubtext</h1>";
                }
                else
                {   // build headline - without subtext
                    $this->headlineMarkup = "<h1>$this->youtubeHeading</h1>";    // draw just the heading
                }
            }
            else
            {   // leave empty if it's not set
                $this->headlineMarkup = '';
            }

            // if description is set, add <p> to string
            if (isset($this->youtubeDescription) && (!empty($this->youtubeDescription)))
            {   // set description string
                $this->descriptionMarkup = "<p>$this->youtubeDescription</p>";
            }
            else
            {   // no description is set
                $this->descriptionMarkup = '';
            }

            // switch plain youtube url to correct embed url string
            $this->youtubeVideoUrl = str_replace("watch?v=","embed/",$this->youtubeVideoUrl.$this->youtubeAutoplayMarkup);

            // HTML output
            echo "
<!-- youtube video iframe -->
<style>
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
}
</style>
<div class=\"videoWrapper\">
$this->headlineMarkup
<iframe width=\"$this->youtubeWidth\" 
        height=\"$this->youtubeHeight\" 
        src=\"$this->youtubeVideoUrl\" 
        frameborder=\"0\"
        scrolling=\"no\"
        $this->youtubeFullscreenMarkup
        $this->cssMarkup>
</iframe>
$this->descriptionMarkup
</div>";
        }
    }
}
