<?php
namespace YAWK\WIDGETS\PREZI\EMBED
{
    /**
     * <b>Prezi Widget - embed a prezi presentation on your page.</b>
     *
     * <p>Prezi is a modern presentation tool. With this widget, you can
     * embed any prezi on your page. </p>
     *
     * @package    YAWK
     * @author     Daniel Retzl <danielretzl@gmail.com>
     * @copyright  2018 Daniel Retzl
     * @license    https://opensource.org/licenses/MIT
     * @version    1.0.0
     * @link       http://yawk.io
     * @annotation Prezi Widget - embed any prezi presentation on your page
     */
    class prezi extends \YAWK\widget
    {
        /** @var object global widget object data */
        public $widget = '';
        /** @var string Prezi HTML Markup */
        public $preziHtml = '';
        /** @var string Title that will be shown above widget */
        public $preziHeading = '';
        /** @var string Subtext will be displayed beside title */
        public $preziSubtext = '';

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
         * Init and embed prezi widget
         * @author Daniel Retzl <danielretzl@gmail.com>
         * @version 1.0.0
         * @link http://yawk.io
         * @annotation Example Widget Init
         */
        public function init()
        {   // display heading
            echo $this->getHeading($this->preziHeading, $this->preziSubtext);
            // output prezi html code
            $this->embedPrezi();
        }

        /**
         * embed prezi
         * @author Daniel Retzl <danielretzl@gmail.com>
         * @version 1.0.0
         * @link http://yawk.io
         * @annotation Html Markup to embed the prezi presentation
         */
        public function embedPrezi()
        {   // check if html markup is set and valid
            if (isset($this->preziHtml)
                && (!empty($this->preziHtml))
                && (is_string($this->preziHtml)))
            {   // output html markup
                echo $this->preziHtml;
            }
        }

        public function markup()
        {
            /*
            echo '<iframe 
                    id="iframe_container" 
                    frameborder="0" 
                    webkitallowfullscreen="" 
                    mozallowfullscreen="" 
                    allowfullscreen="" 
                    allow="autoplay; fullscreen" 
                    width="550" 
                    height="400" 
                    src="https://prezi.com/embed/dcjy1eieemjl/?bgcolor=ffffff&lock_to_path=0&autoplay=0&autohide_ctrls=0&landing_data=bHVZZmNaNDBIWnNjdEVENDRhZDFNZGNIUE43MHdLNWpsdFJLb2ZHanI0a2R3cmd5QVhqMWtLTUV3TGZnN0pNcGRnPT0&landing_sign=Z8VjbmSXPfIR-zdmkFLgkDRZEu-EjHRhVugJALWgv6M">
                  </iframe>';
            */
        }

    }
}
?>