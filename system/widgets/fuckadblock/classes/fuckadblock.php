<?php
namespace YAWK\WIDGETS\FUCKADBLOCK\BLOCK
{
    /**
     * @details<b>AdBlock Blocker Widget</b>
     *
     * <p>If your website relay on advertising, this widget may be helpful. It can detect, if
     * user has an AdBlocker installed. You can set different levels (low or high) - which means
     * that you can say please disable your adblocker or force the user to disable, otherwise he
     * dont see any content. Messages, title and buttons can get customized.</p>
     *
     *
     * @author     Daniel Retzl <danielretzl@gmail.com>
     * @copyright  2018 Daniel Retzl
     * @version    1.0.0
     * @brief Detect and react to user's installed AdBlocker.
     */
    class fuckadblock
    {
        /** @param object global widget object data */
        public $widget = '';
        /** @param string Text that will be shown as title */
        public $fuckAdBlockTitle = '';
        /** @param string AdBlock custom text */
        public $fuckAdBlockText = '';
        /** @param string Level of strongness */
        public $fuckAdBlockLevel = '';
        /** @param string Low level  button text */
        public $fuckAdBlockLowBtnText = '';
        /** @param string High level  button text */
        public $fuckAdBlockHighBtnText = '';
        /** @param string Button class */
        public $fuckAdBlockBtnClass = '';
        /** @param string Loading Type (on page load or every x seconds) */
        public $fuckAdBlockLoadingType = '';
        /** @param string footer html markup */
        public $footerBtnCode = '';
        /** @param string header html markup */
        public $headerBtnCode = '';
        /** @param string Ablock JavaScript */
        public $adBlockJS = '';

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
         * @brief The main function to init fuckAdBlock
         * @brief Prepare properties and init fuckAdBlock
         */
        public function init()
        {
            echo "<script src=\"system/engines/fuckAdBlock/fuckAdBlock.js\"></script>";

            // check priority levels -
            // high means that the user needs to disable his adblocker to see the content
            if ($this->fuckAdBlockLevel === "high")
            {   // current url, this will be the url that will be loaded if user click on footerBtn
                $link = $_SERVER['REQUEST_URI'];
                $this->footerBtnCode = '<a href="'.$link.'" class="'.$this->fuckAdBlockBtnClass.'" style="color:#fff; text-shadow: none;">'.$this->fuckAdBlockHighBtnText.'</a>';
                // strong toughness: no ability to close window, so no header button.
                $this->headerBtnCode = '';
                // force loadingType on every pageLoad
                $this->fuckAdBlockLoadingType = "onPageLoad";
            }
            // low generates a more fair-use user-friendy de-clickable info message box.
            if ($this->fuckAdBlockLevel === "low")
            {   // the 'ok, f*ck off and dismiss button'
                $this->footerBtnCode = '<button type="button" class="'.$this->fuckAdBlockBtnClass.'" data-dismiss="modal">'.$this->fuckAdBlockLowBtnText.'</button>';
                // the close button
                $this->headerBtnCode = '<button type="button" class="close" data-dismiss="modal">&times;</button>';
            }
            // if loadingType = string (onPageLoad) the adBlock warning gets thrown on every page load.
            if (is_string($this->fuckAdBlockLoadingType) && ($this->fuckAdBlockLoadingType === "onPageLoad"))
            {
                $this->adBlockJS = "
        <script type=\"text/javascript\">
        $( document ).ready(function() {
            // Function called if AdBlock is not detected
            function adBlockNotDetected() {
            // alert('AdBlock is not enabled');
            }
    
            // Function called if AdBlock is detected
            function adBlockDetected() {
            // alert('AdBlock is enabled');
            // $('#myModal').modal('show');
            $('#myModal').modal({backdrop: 'static', keyboard: false})
            }
    
            // Recommended audit because AdBlock lock the file 'fuckadblock.js'
            // If the file is not called, the variable does not exist 'fuckAdBlock'
            // This means that AdBlock is present
            if(typeof fuckAdBlock === 'undefined') {
                adBlockDetected();
            }
            else {
                    fuckAdBlock.onDetected(adBlockDetected);
                    fuckAdBlock.onNotDetected(adBlockNotDetected);
                    // and|or
                    fuckAdBlock.on(true, adBlockDetected);
                    fuckAdBlock.on(false, adBlockNotDetected);
                    // and|or
                    fuckAdBlock.on(true, adBlockDetected).onNotDetected(adBlockNotDetected);
                }
        });
        </script>";
            }
            else
            {   // check if loadingType is numeric or integer to show adblock every x seconds
                if (is_numeric($this->fuckAdBlockLoadingType) || (is_int($this->fuckAdBlockLoadingType)))
                {
                    // wrap a setInterval function around adblock to show up every x seconds
                    $this->adBlockJS = "
                <script type=\"text/javascript\">
                $( document ).ready(function() {
                var timerID = setInterval(function() {
        
                    // Function called if AdBlock is not detected
                    function adBlockNotDetected() {
                        // alert('AdBlock is not enabled');
                    }
                    // Function called if AdBlock is detected
                    function adBlockDetected() {
                        // alert('AdBlock is enabled');
                        // $('#myModal').modal('show');
                        $('#myModal').modal({backdrop: 'static', keyboard: false})
                    }
                    // Recommended audit because AdBlock lock the file 'fuckadblock.js'
                    // If the file is not called, the variable does not exist 'fuckAdBlock'
                    // This means that AdBlock is present
                    if(typeof fuckAdBlock === 'undefined') {
                        adBlockDetected();
                    } else {
                        fuckAdBlock.onDetected(adBlockDetected);
                        fuckAdBlock.onNotDetected(adBlockNotDetected);
                        // and|or
                        fuckAdBlock.on(true, adBlockDetected);
                        fuckAdBlock.on(false, adBlockNotDetected);
                        // and|or
                        fuckAdBlock.on(true, adBlockDetected).onNotDetected(adBlockNotDetected);
                        }
                    }, $this->fuckAdBlockLoadingType * 1000);
                    // clearInterval(timerID); // The setInterval it cleared and doesn't run anymore.
                });</script>";
                }
            }

// $_GET['widgetID'] will be generated in \YAWK\widget\loadWidgets($db, $position)

echo"            <!-- Modal -->
            <div id=\"myModal\" class=\"modal fade\" role=\"dialog\">
                <div class=\"modal-dialog\">

                    <!-- Modal content-->
                    <div class=\"modal-content\">
                        <div class=\"modal-header\">
                            $this->headerBtnCode
                            <h4>$this->fuckAdBlockTitle</h4>
                        </div>
                        <div class=\"modal-body\">
                            $this->fuckAdBlockText
                        </div>
                        <div class=\"modal-footer\">
                            $this->footerBtnCode
                        </div>
                    </div>
                </div>
            </div>";

        // output fuckAdBlock JS code
        echo $this->adBlockJS;
        }
    }
}