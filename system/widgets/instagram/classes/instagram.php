<?php
namespace YAWK\WIDGETS\INSTAGRAM\POSTING {
    /**
     * @details<b>Instagram Widget - embed any single instagram posting</b>
     *
     * <p>If you want to embed instagram on your page, this is the widget to do it.
     * All you need is a valid instagram url and (optional) some settings, like width
     * or link target. Of course you can set a custom heading and subtext above posting.</p>
     *
     *
     * @author     Daniel Retzl <danielretzl@gmail.com>
     * @copyright  2018 Daniel Retzl
     * @version    1.0.0
     * @brief Embed Instagram on your page.
     */
    class instagram extends \YAWK\widget
    {
        /** @param object global widget object data */
        public $widget = '';
        /** @param string Any valid instagram url */
        public $instagramUrl = '';
        /** @param string Width of your posting */
        public $instagramWidth = '';
        /** @param string Link target (_blank, _parent, _self) */
        public $instagramTarget = '';
        /** @param string Heading above widget */
        public $instagramHeading = '';
        /** @param string Subtext beside heading */
        public $instagramSubtext = '';

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
        {   // output data to screen
            echo "<pre>";
            print_r($this);
            echo "</pre>";
        }

        /**
         * @brief Init and embed Instagram
         * @brief Embed Google Maps
         */
        public function init()
        {   // embed Instagram
            $this->embed();
        }

        public function embed()
        {
            // draw heading above google map
            echo $this->getHeading($this->instagramHeading, $this->instagramSubtext);

            // check if embed html code is set and correct data type
            if (isset($this->instagramUrl)
                && (!empty($this->instagramUrl))
                && (is_string($this->instagramUrl)))
            {
                // url seems to be valid...
                echo '
<blockquote class="instagram-media"
            data-instgrm-captioned data-instgrm-version="7"
            style="background:#fff;
                   border:0;
                   border-radius:3px;
                   box-shadow:0 0 1px 0 rgba(0,0,0,0.5),0 1px 10px 0 rgba(0,0,0,0.15);
                   margin: 1px;
                   max-width:'.$this->instagramWidth.';
                   padding:0;
                   width:'.$this->instagramWidth.';">

    <p style="margin:8px 0 0 0; padding:0 4px;">
        <a href="'.$this->instagramUrl.'"
           style="color:#000;
                  font-family:Arial,sans-serif;
                  font-size:14px;
                  font-style:normal;
                  font-weight:normal;
                  line-height:17px;
                  text-decoration:none;
                  word-wrap:break-word;"
           target="'.$this->instagramTarget.'"></a>
    </p>
</blockquote>
<script async defer src="//platform.instagram.com/en_US/embeds.js"></script>';
            }
            else
                {   // url not valid, throw error msg
                    echo "Here should be an Instagram posting, but the required url was not set.";
                }
        }
    }
}