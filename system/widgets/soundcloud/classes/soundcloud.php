<?php
namespace YAWK\WIDGETS\SOUNDCLOUD\PLAYER
{
    /**
     * @details<b>Embed any soundcloud track or playlist.</b>
     *
     * <p>If you want to embed a SoundCloud player on your website, this is the widget to do it.
     * All you need is any public SoundCloud URL. The Widget comes with a few settings like: autoplay
     * on or off, show comments, related music, and much more is customizable within the backend. </p>
     *
     *
     * @author     Daniel Retzl <danielretzl@gmail.com>
     * @copyright  2018 Daniel Retzl
     * @version    1.0.0
     * @brief Embed a SoundCloud audio player.
     */
    class soundcloud
    {
        /** @param object global widget object data */
        public $widget = '';
        /** @param string The URL of your soundcloud track or playlist */
        public $soundcloudUrl = '';
        /** @param string Title above the player */
        public $soundcloudTitle = '';
        /** @param string Subtext gets drawn as small tag beside the title */
        public $soundcloudSubtext = '';
        /** @param bool true|false - Autoplay enabled? */
        public $soundcloudAutoplay = false;
        /** @param bool true|false - Hide related? */
        public $soundcloudHideRelated = false;
        /** @param bool true|false - Show Comments? */
        public $soundcloudShowComments = false;
        /** @param bool true|false - Show User? */
        public $soundcloudShowUser = false;
        /** @param bool true|false - Show Reposts? */
        public $soundcloudShowReposts = false;
        /** @param bool true|false - Show Teaser? */
        public $soundcloudShowTeaser = false;
        /** @param bool true|false - Visual? */
        public $soundcloudVisual = false;
        /** @param string Player Width (100%) */
        public $soundcloudWidth = '100%';
        /** @param string Player Height (300) */
        public $soundcloudHeight = '300';
        /** @param string Headline HTML Markup */
        public $headline = '';
        /** @param string Store an error msg, if one occurs */
        public $errorMsg = '';

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
            // output all obj data
            echo "<pre>";
            print_r($this);
            echo "</pre>";
            exit;
        }

        /**
         * @brief Initialize: Set properties and embed SoundCloud player
         * @brief use this method to run the clock
         */
        public function init()
        {
            // set object properties
            $this->setProperties();
            // $this->printObject();
            // embed the SoundCloud Player
            $this->embedPlayer();
        }

        /**
         * @brief Prepare SoundCloud Player Properties
         * @brief Set Player Properties and HTML Markup Code
         */
        public function setProperties()
        {
            // check if soundcloud URL is set, not empty and a valid type (string)
            if (isset($this->soundcloudUrl) && (!empty($this->soundcloudUrl)
            && (is_string($this->soundcloudUrl))))
            {   // select everything AFTER the soundcloud.com/ part
                $this->soundcloudUrl = strstr($this->soundcloudUrl, 'soundcloud.com/');
            }
            else
                {   // throw error msg
                    $this->errorMsg = "Here should be a SoundCloud music player, but no SoundCloud URL was set.";
                }

            // if a heading is set and not empty
            if (isset($this->soundcloudTitle) && (!empty($this->soundcloudTitle)))
            {
                // if subtext is set, add <small> subtext to string
                if (isset($this->soundcloudSubtext) && (!empty($this->soundcloudSubtext)))
                {   // build a headline with heading and subtext
                    $this->soundcloudSubtext = "<small>$this->soundcloudSubtext</small>";
                    $this->headline = "<h1>$this->soundcloudTitle&nbsp;" . "$this->soundcloudSubtext</h1>";
                }
                else
                {   // build just a headline - without subtext
                    $this->headline = "<h1>$this->soundcloudTitle</h1>";    // draw just the heading
                }
            }
            else
            {   // leave empty if it's not set
                $this->headline = '';
            }

        }

        /**
         * @brief Embed SoundCloud Player
         * @brief Load SoundCloud Iframe
         */
        public function embedPlayer()
        {
            // output headline
            echo $this->headline;
            // throw error (if one occurs)
            echo $this->errorMsg;
            // embed SoundCloud player
            echo "<iframe 
                    width=\"$this->soundcloudWidth\" 
                    height=\"$this->soundcloudHeight\" 
                    scrolling=\"no\" 
                    frameborder=\"no\" 
                    allow=\"autoplay\" 
                    src=\"https://w.soundcloud.com/player/?url=https%3A//$this->soundcloudUrl&color=%23ff5500&auto_play=$this->soundcloudAutoplay&hide_related=$this->soundcloudHideRelated&show_comments=$this->soundcloudShowComments&show_user=$this->soundcloudShowUser&show_reposts=$this->soundcloudShowReposts&show_teaser=$this->soundcloudShowTeaser&visual=$this->soundcloudVisual\">
                  </iframe>";
        }
    }
}
