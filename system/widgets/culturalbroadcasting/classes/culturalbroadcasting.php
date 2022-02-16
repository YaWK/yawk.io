<?php
namespace YAWK\WIDGETS\CULTURALBROADCASTING\STREAM
{
    /**
     * @details<b>Embed audio player from cultural broadcasting archive.</b>
     *
     * <p>Cultural Broadcasting Archive is an austrian podcast archive.
     * You can embed any public broadcast and set a few settings like
     * player details, waveform display, social media links and much more.
     * All you need to embed a player, is the URL to the cba podcast.</p>
     *
     *
     * @author     Daniel Retzl <danielretzl@gmail.com>
     * @copyright  2018 Daniel Retzl
     * @version    1.0.0
     * @brief Embed CBA (Cultural Broadcasting Archive) Podcast Player.
     */
    class culturalBroadcastingArchive
    {
        /** @param object global widget object data */
        public $widget = '';
        /** @param string cba podcast URL */
        public $cbaUrl = '';
        /** @param string Headline */
        public $cbaHeadline = '';
        /** @param string Heading */
        public $cbaHeading = '';
        /** @param string Subtext */
        public $cbaSubtext = '';
        /** @param string Height */
        public $cbaHeight = '';
        /** @param string Width */
        public $cbaWidth = '';
        /** @param string Display waveform? */
        public $cbaWaveform = '';
        /** @param string CBA Title */
        public $cbaTitle = '';
        /** @param string Socialmedia Links */
        public $cbaSocialmedia = '';
        /** @param string Podcast */
        public $cbaPodcast = '';
        /** @param string Series  */
        public $cbaSeries = '';
        /** @param string Description */
        public $cbaDescription = '';
        /** @param string Meta Tags */
        public $cbaMeta = '';
        /** @param string Embed Code */
        public $cbaEmbedCode = '';
        /** @param string Source URL */
        public $cbaSource = '';

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

        /**
         * @brief Initialize: prepare proerties and load javascript
         * @brief use this method to run the clock
         */
        public function init()
        {
            $this->setProperties();
            $this->embed();
        }

        public function setProperties()
        {
            // if a heading is set and not empty
            if (isset($this->cbaHeading) && (!empty($this->cbaHeading)))
            {   // add a h1 tag to heading string
                $this->cbaHeading = "$this->cbaHeading";

                // if subtext is set, add <small> subtext to string
                if (isset($this->cbaSubtext) && (!empty($this->cbaSubtext)))
                {   // build a headline with heading and subtext
                    $this->cbaSubtext = "<small>$this->cbaSubtext</small>";
                    $this->headline = "<h1>$this->cbaHeading&nbsp;"."$this->cbaSubtext</h1>";
                }
                else
                {   // build just a headline - without subtext
                    $this->headline = "<h1>$this->cbaHeading</h1>";    // draw just the heading
                }
            }
            else
            {   // leave empty if it's not set
                $this->headline = '';
            }

            /* check if waveform is set to true or false */
            if ($this->cbaWaveform === "1")
            {
                $this->cbaWaveform = "&waveform=true";
            }
            else
            {   /* waveform false: adjust height correctly */
                $this->cbaWaveform = "&waveform=false";
            }

            /* is a title set? */
            if ($this->cbaTitle === "1")
            {
                $this->cbaTitle = "&title=true";
            }
            else
            {
                $this->cbaTitle = "&title=false";
            }

            /* is socialmedia set? */
            if ($this->cbaSocialmedia === "1")
            {
                $this->cbaSocialmedia = "&socialmedia=true";
            }
            else
            {
                $this->cbaSocialmedia = "&socialmedia=false";
            }

            /* is series set? */
            if ($this->cbaSeries === "1")
            {
                $this->cbaSeries = "&series_link=true";
            }
            else
            {
                $this->cbaSeries = "&series_link=false";
            }

            /* is podcast set? */
            if ($this->cbaPodcast === "1")
            {
                $this->cbaPodcast = "&subscribe=true";
            }
            else
            {
                $this->cbaSeries = "&subscribe=false";
            }

            /* is description set? */
            if ($this->cbaDescription === "1")
            {
                $this->cbaDescription = "&description=true";
            }
            else
            {
                $this->cbaDescription = "&description=false";
            }

            /* is meta set? */
            if ($this->cbaMeta === "1")
            {
                $this->cbaMeta = "&meta=true";
            }
            else
            {
                $this->cbaMeta = "&meta=false";
            }
        }

        public function embed()
        {

            if (isset($cbaEmbedCode) && (!empty($cbaEmbedCode)))
            {
                echo $this->cbaHeadline;
                echo $cbaEmbedCode;
            }
            else
            {
                $this->cbaSource = $this->cbaUrl."/embed?".$this->cbaWaveform.$this->cbaTitle.$this->cbaSocialmedia.$this->cbaPodcast.$this->cbaSeries.$this->cbaDescription.$this->cbaMeta;
                // HTML output
                echo "
                <!-- cba stream iframe -->
                $this->cbaHeadline
                <iframe width=\"$this->cbaWidth\" 
                        height=\"$this->cbaHeight\" 
                        src=\"$this->cbaSource\" 
                        frameborder=\"0\"
                        scrolling=\"no\"
                        style=\"border:none; width:$this->cbaWidth; height:$this->cbaHeight;\">
                </iframe>";
            }
        }
    }
}
