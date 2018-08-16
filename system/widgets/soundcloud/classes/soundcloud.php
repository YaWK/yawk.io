<?php
namespace YAWK\WIDGETS\SOUNDCLOUD\PLAYER
{
    /**
     * <b>Embed any soundcloud track or playlist.</b>
     *
     * <p>If you want to embed a SoundCloud player on your website, this is the widget to do it.
     * All you need is any public SoundCloud URL. The Widget comes with a few settings like: autoplay
     * on or off, show comments, related music, and much more is customizable within the backend. </p>
     *
     * @package    YAWK
     * @author     Daniel Retzl <danielretzl@gmail.com>
     * @copyright  2018 Daniel Retzl
     * @license    https://opensource.org/licenses/MIT
     * @version    1.0.0
     * @link       http://yawk.io
     * @annotation Embed a SoundCloud audio player.
     */
    class soundcloud
    {
        /** @var object global widget object data */
        public $widget = '';
        /** @var string The URL of your soundcloud track or playlist */
        public $soundcloudUrl = '';
        /** @var string Title above the player */
        public $soundcloudTitle = '';
        /** @var string Subtext gets drawn as small tag beside the title */
        public $soundcloudSubtext = '';
        /** @var bool true|false - Autoplay enabled? */
        public $soundcloudAutoplay = false;
        /** @var bool true|false - Hide related? */
        public $soundcloudHideRelated = false;
        /** @var bool true|false - Show Comments? */
        public $soundcloudShowComments = false;
        /** @var bool true|false - Show User? */
        public $soundcloudShowUser = false;
        /** @var bool true|false - Show Reposts? */
        public $soundcloudShowReposts = false;
        /** @var bool true|false - Show Teaser? */
        public $soundcloudShowTeaser = false;
        /** @var bool true|false - Visual? */
        public $soundcloudVisual = false;
        /** @var string Player Width (100%) */
        public $soundcloudWidth = '100%';
        /** @var string Player Height (300) */
        public $soundcloudHeight = '300';

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
         * Initialize: Set properties and embed SoundCloud player
         * @author Daniel Retzl <danielretzl@gmail.com>
         * @version 1.0.0
         * @link http://yawk.io
         * @annotation use this method to run the clock
         */
        public function init()
        {
            $this->setProperties();
            $this->embedPlayer();
        }

        /**
         * Prepare SoundCloud Player Properties
         * @author Daniel Retzl <danielretzl@gmail.com>
         * @version 1.0.0
         * @link http://yawk.io
         * @annotation Set Player Properties and HTML Markup Code
         */
        public function setProperties()
        {
            if (isset($this->soundcloudUrl) && (!empty($this->soundcloudUrl)
            && (is_string($this->soundcloudUrl))))
            {
                
            }

        }

        /**
         * Embed SoundCloud Player
         * @author Daniel Retzl <danielretzl@gmail.com>
         * @version 1.0.0
         * @link http://yawk.io
         * @annotation Load SoundCloud Iframe
         */
        public function embedPlayer()
        {
            echo "<iframe 
                    width=\"$this->soundcloudWidth\" 
                    height=\"$this->soundcloudHeight\" 
                    scrolling=\"no\" 
                    frameborder=\"no\" 
                    allow=\"autoplay\" 
                    src=\"https://w.soundcloud.com/player/?url=https%3A//soundcloud.com/nasir44moudy/sets/motivation-within&color=%23ff5500&auto_play=$this->soundcloudAutoplay&hide_related=$this->soundcloudHideRelated&show_comments=$this->soundcloudShowComments&show_user=$this->soundcloudShowUser&show_reposts=$this->soundcloudShowReposts&show_teaser=$this->soundcloudShowTeaser&visual=$this->soundcloudVisual</iframe>\">
                  </iframe>";
        }
    }
}
