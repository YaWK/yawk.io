<?php
namespace YAWK\WIDGETS\CUSTOM_HTML\CODE
{
    /**
     * <b>Embed a custom html code snippet.</b>
     *
     * <p>Sometimes you would like to embed (more or less) small piece of code in any position.
     * This widget helps you to achieve this. You can enter any valid html code. Even if it is not
     * recommended, you are able to add a piece of javascript here too. This Widget features the
     * combination of summernote and codemirror to give you the best code editing experience.</p>
     *
     * @package    YAWK
     * @author     Daniel Retzl <danielretzl@gmail.com>
     * @copyright  2018 Daniel Retzl
     * @license    https://opensource.org/licenses/MIT
     * @version    1.0.0
     * @link       http://yawk.io
     * @annotation Embed a html/javascript code snippet.
     */
    class customHtml
    {
        /** @var object global widget object data */
        public $widget = '';
        /** @var string Custom HTML Code */
        public $customHtmlCode = '';

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
         * Initialize: prepare JS and start the clock
         * @author Daniel Retzl <danielretzl@gmail.com>
         * @version 1.0.0
         * @link http://yawk.io
         * @annotation use this method to run the clock
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
