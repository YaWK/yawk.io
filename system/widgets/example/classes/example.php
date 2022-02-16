<?php
namespace YAWK\WIDGETS\EXAMPLE\DEMO
{
    /**
     * @details<b>Empty Example Widget - for development and demo purpose</b>
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
     * @brief Example Widget (empty) for DEMO and development purpose!
     */
    class example extends \YAWK\widget
    {
        /** @param object global widget object data */
        public $widget = '';
        /** @param string Title that will be shown above widget */
        public $exampleHeading = '';
        /** @param string Subtext will be displayed beside title */
        public $exampleSubtext = '';

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
         * @brief Init example widget and call a function for demo purpose
         * @brief Example Widget Init
         */
        public function init()
        {   // call any function or method you have previously defined in this class
            echo $this->showHeading();

            // e.g. if you want to output all data of this widget object, you can do this:
            // (remove comments // of next line to see it in action)
            // $this->printObject();

            // It is also possible, to call any other YaWK methods.
            // In that case, make sure, you load the proper class before
            // or use spl_autoload to achieve this automatically.
        }

        public function showHeading()
        {
            // draw headline on screen
            return $this->getHeading($this->exampleHeading, $this->exampleSubtext);
        }

    }
}
?>