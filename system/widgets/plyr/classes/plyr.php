<?php
namespace YAWK\WIDGETS\PLYR\PLAYER
{
    /**
     * <b>Plyr Widget - html5 based video player</b>
     *
     * <p>Plyr is a a simple, accessible and customisable and wide-known media player for
     * HTML 5 Video, Audio, YouTube, and Vimeo. All you need is the url to your media file.
     * As you wish, you can set some settings like width, height, poster image, media control
     * functions, autoplay and much more. </p>
     *
     * @package    YAWK
     * @author     Daniel Retzl <danielretzl@gmail.com>
     * @copyright  2018 Daniel Retzl
     * @license    https://opensource.org/licenses/MIT
     * @version    1.0.0
     * @link       http://yawk.io
     * @annotation Plyr HTML5 Media Player Widget
     */
    class plyr extends \YAWK\widget
    {
        /** @var object global widget object data */
        public $widget = '';
        /** @var string Title that will be shown above widget */
        public $plyrHeading = '';
        /** @var string Subtext will be displayed beside title */
        public $plyrSubtext = '';
        /** @var string URL of the media file to play */
        public $plyrMediaFile = '';
        /** @var string The media file type */
        public $plyrFiletype = '';
        /** @var string Player width in pixel or % */
        public $plyrWidth = '100%';
        /** @var string Poster Image */
        public $plyrPoster = '';
        /** @var string Poster Html Markup */
        public $plyrPosterHtml = '';
        /** @var string Text Track File */
        public $plyrTextTrackFile = '';
        /** @var string Text Track Html Markup */
        public $plyrTextTrackFileHtmlOutput = '';
        /** @var string Text Track Label */
        public $plyrTextTrackLabel = '';
        /** @var string Text Track Src Language */
        public $plyrTextTrackSrcLang = '';
        /** @var bool Autoplay true|false */
        public $plyrAutoplay = false;
        /** @var bool Click to play true|false */
        public $plyrClickToPlay = true;
        /** @var bool Context Menus enabled? */
        public $plyrDisableContextMenu = true;
        /** @var bool Hide player controls true|false */
        public $plyrHideControls = true;
        /** @var bool Display poster on video end true|false */
        public $plyrShowPosterOnEnd = false;

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
        {   // call any functions or methods you have previously defined in this class
            echo $this->showHeading();
            // check and set media file type
            $this->checkMediaFileType();
            // check and set poster image
            $this->setPoster();
            // check and set text track
            $this->checkTextTrack();
            // finally: embed plyr media player
            $this->embedPlyr();
        }

        public function checkMediaFileType()
        {
            if (isset($this->plyrMediaFile) && (!empty($this->plyrMediaFile)))
            {
                if (strpos($this->plyrMediaFile, '.mp4') !== false)
                {
                    $this->plyrFiletype = "video/mp4";
                }
                if (strpos($this->plyrMediaFile, '.webm') !== false)
                {
                    $this->plyrFiletype = "video/webm";
                }
            }
            else
                {
                    echo "Plyr Error: unable to detect media file type - no file was set!";
                }
        }

        public function setPoster()
        {
            if (isset($this->plyrPoster) && (!empty($this->plyrPoster)))
            {   // poster is set...
                $this->plyrPosterHtml = "poster=\"$this->plyrPoster\"";
            }
            else
            {   // no poster set, leave output empty
                $this->plyrPosterHtml = "poster=\"\"";
            }
        }

        public function checkTextTrack()
        {
            // check if text track file, language and label are set
            if (isset($this->plyrTextTrackFile) && (!empty($this->plyrTextTrackFile)))
            {   // language not found
                if (!isset($this->plyrTextTrackSrcLang) || (empty($this->plyrTextTrackSrcLang)))
                {   // set default language:
                    $this->plyrTextTrackSrcLang = "en";
                }
                // label is not set
                if (!isset($this->plyrTextTrackLabel) || (empty($this->plyrTextTrackLabel)))
                {   // set default label:
                    $this->plyrTextTrackLabel = "English";
                }
                // output text track html...
                $this->plyrTextTrackFileHtmlOutput = "<track kind=\"captions\" label=\"$this->plyrTextTrackLabel\" srclang=\"$this->plyrTextTrackSrcLang\" src=\"$this->plyrTextTrackFile\" default>";
            }
            else
            {   // no text track is set, output nothing
                $this->plyrTextTrackFileHtmlOutput = '';
            }
        }

        public function embedPlyr()
        {
            echo '
            <!-- output plyr html player -->
            <section>
                <video '.$this->plyrPosterHtml.' controls style="width: '.$this->plyrWidth.'">
                    <source src="'.$this->plyrMediaFile.'" type="'.$this->plyrFiletype.'">
                    <!-- Text track file -->
                    '.$this->plyrTextTrackFileHtmlOutput.'
                    <!-- Fallback for browsers that dont support the <video> element -->
                    <a href="'.$this->plyrMediaFile.'" download>Download</a>
                </video>
            </section>
            
            <!-- plyr js -->
            <script src="system/widgets/plyr/js/plyr.js"></script>
            <!-- run plyr -->
            <script>plyr.setup({ 
                "autoplay":'.$this->plyrAutoplay.', 
                "disableContextMenu": '.$this->plyrDisableContextMenu.', 
                "hideControls": '.$this->plyrHideControls.', 
                "showPosterOnEnd": '.$this->plyrShowPosterOnEnd.', 
                "clickToPlay": '.$this->plyrClickToPlay.' });
            </script>
            <!-- plyr css -->
            <link type="text/css" rel="stylesheet" href="system/widgets/plyr/js/plyr.css">
            
            <!-- Rangetouch to fix <input type="range"> on touch devices (see https://rangetouch.com) -->
            <script src="system/widgets/plyr/js/rangetouch.js" async></script>';
        }

        public function showHeading()
        {
            // draw headline on screen
            return $this->getHeading($this->plyrHeading, $this->plyrSubtext);
        }

    }
}
?>