<!-- fuckAdBlock -->
<script src="system/engines/fuckAdBlock/fuckAdBlock.js"></script>

<?php
$loadingType = 'onPageLoad';
$title = '';
$text = '';
$level = 'low';
$lowLevelBtnText = 'OK, I got it';
$highLevelBtnText = 'Please disable your AdBlocker and click here.';
$footerBtnCode = '<button type="button" class="btn btn-danger" data-dismiss="modal">'.$lowLevelBtnText.'</button>';
$headerBtnCode = '<button type="button" class="close" data-dismiss="modal">&times;</button>';
$btnClass = 'btn btn-danger';
$adBlockJS = '';

// $_GET['widgetID'] will be generated in \YAWK\widget\loadWidgets($db, $position)
if (isset($_GET['widgetID'])) {
    $widgetID = $_GET['widgetID'];
    $res = $db->query("SELECT * FROM {widget_settings}
								WHERE widgetID = '" . $widgetID . "'
	                        	AND activated = '1'");
    while ($row = mysqli_fetch_assoc($res)) {   // set widget properties and values into vars
        $w_property = $row['property'];
        $w_value = $row['value'];
        $w_widgetType = $row['widgetType'];
        $w_activated = $row['activated'];
        /* end of get widget properties */

        /* filter and load those widget properties */
        if (isset($w_property)) {
            switch ($w_property) {
                /* title */
                case 'fuckAdBlockTitle';
                    $title = $w_value;
                    break;

                /* text */
                case 'fuckAdBlockText';
                    $text = $w_value;
                    break;

                /* level */
                case 'fuckAdBlockLevel';
                    $level = $w_value;
                    break;

                /* lowLevelBtnText */
                case 'fuckAdBlockLowBtnText';
                    $lowLevelBtnText = $w_value;
                    break;

                /* highLevelBtnText */
                case 'fuckAdBlockHighBtnText';
                    $highLevelBtnText = $w_value;
                    break;

                /* BtnClass */
                case 'fuckAdBlockBtnClass';
                    $btnClass = $w_value;
                    break;

                /* loadingType */
                case 'fuckAdBlockLoadingType';
                    $loadingType = $w_value;
                    break;
            }
        } /* END LOAD PROPERTIES */
    } // end while fetch row (fetch widget settings)

    // check priority levels -
    // high means that the user needs to disable his adblocker to see the content
    if ($level === "high")
    {   // current url, this will be the url that will be loaded if user click on footerBtn
        $link = $_SERVER['REQUEST_URI'];
        $footerBtnCode = '<a href="'.$link.'" class="'.$btnClass.'" style="color:#fff; text-shadow: none;">'.$highLevelBtnText.'</a>';
        // strong toughness: no ability to close window, so no header button.
        $headerBtnCode = '';
    }
    // low generates a more fair-use user-friendy de-clickable info message box.
    if ($level === "low")
    {   // the 'ok, f*ck off and dismiss button'
        $footerBtnCode = '<button type="button" class="'.$btnClass.'" data-dismiss="modal">'.$lowLevelBtnText.'</button>';
        // the close button
        $headerBtnCode = '<button type="button" class="close" data-dismiss="modal">&times;</button>';
    }
    // if loadingType = string (onPageLoad) the adBlock warning gets thrown on every page load.
    if (is_string($loadingType) && ($loadingType === "onPageLoad"))
    {
        $adBlockJS = "
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
            if (is_numeric($loadingType) || (is_int($loadingType)))
            {
                // wrap a setInterval function around adblock to show up every x seconds
                $adBlockJS = "
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
                    }, $loadingType * 1000);
                    // clearInterval(timerID); // The setInterval it cleared and doesn't run anymore.
                });</script>";
            }
        }
}
?>
<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <?php echo $headerBtnCode; ?>
                <h4><?php echo $title; ?></h4>
            </div>
            <div class="modal-body">
                <?php echo $text; ?>
            </div>
            <div class="modal-footer">
                <?php echo $footerBtnCode; ?>
            </div>
        </div>

    </div>
</div>

<?php
// output fuckAdBlock JS code
echo $adBlockJS;
?>