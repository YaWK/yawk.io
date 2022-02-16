<?php
namespace YAWK\WIDGETS\CLOCK\CURRENT
{
    /**
     * @details<b>Embed a digital clock on your website.</b>
     *
     * <p>The clock shows the current time. (wonder, oh wonder...) You can set the clock's font color,
     * alignment (left, center or right) as well as a custom css class to design it and put some FX on
     * if you need to. If you need an analog clock anywhere on your website, this widget does the job.</p>
     *
     *
     * @author     Daniel Retzl <danielretzl@gmail.com>
     * @copyright  2018 Daniel Retzl
     * @version    1.0.0
     * @brief Embed a digital real-time clock on your website.
     */
    class clock
    {
        /** @param object global widget object data */
        public $widget = '';
        /** @param string Clock color */
        public $clockColor = '#f5f5f5';
        /** @param string Clock alignment */
        public $clockAlign = 'text-center';
        /** @param string Clock class */
        public $clockClass = 'h1';

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
         * @brief Initialize: prepare JS and start the clock
         * @brief use this method to run the clock
         */
        public function init()
        {
            $this->loadJavascript();
            $this->drawClock();
        }

        /**
         * @brief Load required javascript
         * @brief The engine behind this clock
         */
        public function loadJavascript()
        {
            echo"<body onload=\"clock();\">
            <script type=\"text/javascript\">
            function clock() {
                var now = new Date();
                var minute = now.getMinutes();
                var second= now.getSeconds();
                var hour = now.getHours();
                if(minute<10) minute = \"0\" + minute;
                if(second<10) second= \"0\" + second;
                if(hour<10) hour=\"0\" + hour;
                var outStr = hour+':'+minute+':'+second;
                /*   output string without leading zero int
                 *   var outStr = now.getHours()+':'+now.getMinutes()+':'+now.getSeconds(); */
                document.getElementById('clockDiv').innerHTML=outStr;
                setTimeout('clock()',1000);
            }
            clock();
            </script>";
        }

        /**
         * @brief Draw the clock on screen
         * @brief This method draws the clock on screen
         */
        public function drawClock()
        {
            echo"
            <div class=\"$this->clockAlign\">
                <div id=\"clockDiv\" class=\"$this->clockClass\" style=\"color:#$this->clockColor\"></div>
            </div>";
        }
    }
}
