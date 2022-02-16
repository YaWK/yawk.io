<?php
namespace YAWK\WIDGETS\CUSTOM_HTML\CODE
{
    /**
     * @details<b>Embed a custom html code snippet.</b>
     *
     * <p>Sometimes you would like to embed (more or less) small piece of code in any position.
     * This widget helps you to achieve this. You can enter any valid html code. Even if it is not
     * recommended, you are able to add a piece of javascript here too. This Widget features the
     * combination of summernote and codemirror to give you the best code editing experience.</p>
     *
     *
     * @author     Daniel Retzl <danielretzl@gmail.com>
     * @copyright  2018 Daniel Retzl
     * @version    1.0.0
     * @brief Embed a html/javascript code snippet.
    */
    class customHtml
    {
        /** @param object global widget object data */
        public $widget = '';
        /** @param string Custom HTML Code */
        public $customHtmlCode = '';

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
         * @brief Init and load custom html code
         * @brief use this method to run the clock
        */
        public function init()
        {
            // check if customHtmlCode is set, not empty and a string
            if (isset($this->customHtmlCode) && (!empty($this->customHtmlCode)
            && (is_string($this->customHtmlCode))))
            {   // output custom html code
                echo $this->customHtmlCode;
            }
            else
                {   // custom html code is not valid, leave empty
                    $this->customHtmlCode = '';
                }
        }
    }
}
