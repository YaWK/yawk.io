<?php
namespace YAWK\WIDGETS\SPOTIFY\EMBED
{
    /**
     * <b>Empty spotify Widget - for development and demo purpose</b>
     *
     * <p>This widget is (nearly) empty. It can be used to understand the logic behind YaWK's
     * widget system and/or is a great base to start and create your very own widget! Simply
     * add the properties your application needs, add the database, build your own functions
     * and your widget is ready to run the code as you need it.</p>
     *
     * @package    YAWK
     * @author     Daniel Retzl <danielretzl@gmail.com>
     * @copyright  2018 Daniel Retzl
     * @license    https://opensource.org/licenses/MIT
     * @version    1.0.0
     * @link       http://yawk.io
     * @annotation spotify Widget (empty) for DEMO and development purpose!
     */
    class spotify extends \YAWK\widget
    {
        /** @var object global widget object data */
        public $widget = '';
        /** @var string Title that will be shown above widget */
        public $spotifyHeading = '';
        /** @var string Subtext will be displayed beside title */
        public $spotifySubtext = '';
        /* @var string Spotify embed code */
        public $spotifyEmbedCode='';
        /* @var string widget width */
        public $spotifyWidth='';
        /* @var string widget height */
        public $spotifyHeight='';

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
         * Init spotify widget
         * @author Daniel Retzl <danielretzl@gmail.com>
         * @version 1.0.0
         * @link http://yawk.io
         * @annotation spotify Widget Init
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