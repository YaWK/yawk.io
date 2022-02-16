<?php
namespace YAWK\WIDGETS\PLYR\PLAYER
{
    /**
     * @details<b>Plyr Widget - html5 based video player</b>
     *
     * <p>Plyr is a a simple, accessible and customisable and wide-known media player for
     * HTML 5 Video, Audio, YouTube, and Vimeo. All you need is the url to your media file.
     * As you wish, you can set some settings like width, height, poster image, media control
     * functions, autoplay and much more. </p>
     *
     *
     * @author     Daniel Retzl <danielretzl@gmail.com>
     * @copyright  2018 Daniel Retzl
     * @version    1.0.0
     * @brief Plyr HTML5 Media Player Widget
     */
    class plyr extends \YAWK\widget
    {
        /** @param object global widget object data */
        public $widget = '';
        /** @param string Title that will be shown above widget */
        public $plyrHeading = '';
        /** @param string Subtext will be displayed beside title */
        public $plyrSubtext = '';
        /** @param string URL of the media file to play */
        public $plyrMediaFile = '';
        /** @param string The media file type */
        public $plyrFiletype = '';
        /** @param string Player width in pixel or % */
        public $plyrWidth = '100%';
        /** @param string Poster Image */
        public $plyrPoster = '';
        /** @param string Poster Html Markup */
        public $plyrPosterHtml = '';
        /** @param string Text Track File */
        public $plyrTextTrackFile = '';
        /** @param string Text Track Html Markup */
        public $plyrTextTrackFileHtmlOutput = '';
        /** @param string Text Track Label */
        public $plyrTextTrackLabel = '';
        /** @param string Text Track Src Language */
        public $plyrTextTrackSrcLang = '';
        /** @param bool Autoplay true|false */
        public $plyrAutoplay = false;
        /** @param bool Click to play true|false */
        public $plyrClickToPlay = true;
        /** @param bool Context Menus enabled? */
        public $plyrDisableContextMenu = true;
        /** @param bool Hide player controls true|false */
        public $plyrHideControls = true;
        /** @param bool Display poster on video end true|false */
        public $plyrShowPosterOnEnd = false;

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
         * @brief Init example widget and call a function for demo purpose
         * @brief Example Widget Init
         */
        public function init()
        {   // call any functions or methods you have previously defined in this class
            echo $this->getHeading($this->plyrHeading, $this->plyrSubtext);
            // check and set media file type
            $this->checkMediaFileType();
            // check and set poster image
            $this->setPoster();
            // check and set text track
            $this->checkTextTrack();
            // finally: embed plyr media player
            $this->embedPlyr();
        }

        /**
         * @brief Check and set media file type
         * @brief check and set media file type
        */
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
            <script>
            plyr.setup({ 
                "autoplay":'.$this->plyrAutoplay.', 
                "disableContextMenu": '.$this->plyrDisableContextMenu.', 
                "hideControls": '.$this->plyrHideControls.', 
                "showPosterOnEnd": '.$this->plyrShowPosterOnEnd.', 
                "clickToPlay": '.$this->plyrClickToPlay.'
            });
            </script>
            <!-- plyr css -->
            <link type="text/css" rel="stylesheet" href="system/widgets/plyr/js/plyr.css">
            
            <!-- Rangetouch to fix <input type="range"> on touch devices (see https://rangetouch.com) -->
            <script src="system/widgets/plyr/js/rangetouch.js" async></script>';
        }
    }
}
?>