<?php
namespace YAWK\WIDGETS\PREZI\EMBED
{
    /**
     * @details<b>Prezi Widget - embed a prezi presentation on your page.</b>
     *
     * <p>Prezi is a modern presentation tool. With this widget, you can
     * embed any prezi on your page. </p>
     *
     *
     * @author     Daniel Retzl <danielretzl@gmail.com>
     * @copyright  2018 Daniel Retzl
     * @version    1.0.0
     * @brief Prezi Widget - embed any prezi presentation on your page
     */
    class prezi extends \YAWK\widget
    {
        /** @param object global widget object data */
        public $widget = '';
        /** @param string Prezi HTML Markup */
        public $preziHtml = '';
        /** @param string Title that will be shown above widget */
        public $preziHeading = '';
        /** @param string Subtext will be displayed beside title */
        public $preziSubtext = '';

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
         * @brief Init and embed prezi widget
         * @brief Example Widget Init
         */
        public function init()
        {   // display heading
            echo $this->getHeading($this->preziHeading, $this->preziSubtext);
            // output prezi html code
            $this->embedPrezi();
        }

        /**
         * @brief embed prezi
         * @brief Html Markup to embed the prezi presentation
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