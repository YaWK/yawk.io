<?php
namespace YAWK\WIDGETS\SPOTIFY\EMBED
{
    /**
     * @details<b>Empty spotify Widget - for development and demo purpose</b>
     *
     * <p>This widget is (nearly) empty. It can be used to understand the logic behind YaWK's
     * widget system and/or is a great base to start and create your very own widget! Simply
     * add the properties your application needs, add the database, build your own functions
     * and your widget is ready to run the code as you need it.</p>
     *
     *
     * @author     Daniel Retzl <danielretzl@gmail.com>
     * @copyright  2018 Daniel Retzl
     * @version    1.0.0
     * @brief spotify Widget (empty) for DEMO and development purpose!
     */
    class spotify extends \YAWK\widget
    {
        /** @param object global widget object data */
        public $widget = '';
        /** @param string Title that will be shown above widget */
        public $spotifyHeading = '';
        /** @param string Subtext will be displayed beside title */
        public $spotifySubtext = '';
        /* @param string Spotify embed code */
        public $spotifyEmbedCode='';
        /* @param string widget width */
        public $spotifyWidth='';
        /* @param string widget height */
        public $spotifyHeight='';

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
         * @brief Init spotify widget
         * @brief spotify Widget Init
         */
        public function init()
        {   // display heading
            echo $this->getHeading($this->spotifyHeading, $this->spotifySubtext);
            // switch plain youtube url to correct embed url string
            $this->spotifyEmbedCode = str_replace("width=\"300\"","width=\"$this->spotifyWidth\"",$this->spotifyEmbedCode);
            $this->spotifyEmbedCode = str_replace("height=\"380\"","height=\"$this->spotifyHeight\"",$this->spotifyEmbedCode);
            echo $this->spotifyEmbedCode;
        }
    }
}
?>