<?php
/* Widget: facebook like button
 * Folder: system/widgets/fb_like_button
 * Version: 1.2
 */

// default settings
$customHtmlCode="";

if (isset($_GET['widgetID']))
{
    // widget ID
    $widgetID = $_GET['widgetID'];

    /* get widget settings from db */
    $res = $db->query("SELECT * FROM {widget_settings}
	                        WHERE widgetID = '".$widgetID."'
	                        AND activated = '1'");
    while ($row = mysqli_fetch_assoc($res))
    {
        $w_property = $row['property'];
        $w_value = $row['value'];
        $w_widgetType = $row['widgetType'];
        $w_activated = $row['activated'];

        /* LOAD PROPERTIES */
        if (isset($w_property)) {
            switch ($w_property) {
                case 'customHtmlCode';
                    $customHtmlCode = $w_value;
                    break;
            }
        } /* END LOAD PROPERTIES */

    } // end while fetch row (end get widget settings)
}
// output Custom HTML Code
echo $customHtmlCode;
?>
