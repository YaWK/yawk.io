<?php
// set default values
$responsiveAudioJS = '';

// $_GET['widgetID'] will be generated in \YAWK\widget\loadWidgets($db, $position)
if (isset($_GET['widgetID']))
{
    // widget ID
    $widgetID = $_GET['widgetID'];

    // make sure, the player got it's own instance ID
    $jPlayerInstance = $_GET['widgetID'];

    // get widget settings from db
    $res = $db->query("SELECT * FROM {widget_settings}
    WHERE widgetID = '".$widgetID."'
    AND activated = '1'");
    while($row = mysqli_fetch_assoc($res))
    {   // set widget properties and values into vars
        $w_property = $row['property'];
        $w_value = $row['value'];
        $w_widgetType = $row['widgetType'];
        $w_activated = $row['activated'];
        /* end of get widget properties */

        /* filter and load those widget properties */
        if (isset($w_property)){
            switch($w_property)
            {
                /* url of the video to stream */
                case 'responsiveAudioJS';
                    $responsiveAudioJS = $w_value;
                    break;
            }
        } /* END LOAD PROPERTIES */
    } // end while fetch row (fetch widget settings)
}
// output responsive JS code
echo "<script src='$responsiveAudioJS'></script>";
