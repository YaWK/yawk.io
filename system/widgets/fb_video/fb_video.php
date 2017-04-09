<?php
// set default values
$fbVideoEmbedCode='<iframe src="https://www.facebook.com/plugins/video.php?href=https%3A%2F%2Fwww.facebook.com%2Ffacebook%2Fvideos%2F10155656407651729%2F&show_text=0&width=560" width="560" height="315" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowTransparency="true" allowFullScreen="true"></iframe>';
$fbVideoWidth="560";
$fbVideoHeight="315";
$heading = '';
$subtext = '';

// $_GET['widgetID'] will be generated in \YAWK\widget\loadWidgets($db, $position)
if (isset($_GET['widgetID']))
{
    // widget ID
    $widgetID = $_GET['widgetID'];

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
                case 'fbVideoEmbedCode';
                    $fbVideoEmbedCode = $w_value;
                    break;

                /* spotify width in px or & */
                case 'fbVideoWidth';
                    $fbVideoWidth = $w_value;
                    break;

                /* spotify height */
                case 'fbVideoHeight';
                    $fbVideoHeight = $w_value;
                    break;

                /* heading */
                case 'fbVideoHeading';
                    $heading = $w_value;
                    break;

                /* subtext */
                case 'fbVideoSubtext';
                    $subtext = $w_value;
                    break;
            }
        } /* END LOAD PROPERTIES */
    } // end while fetch row (fetch widget settings)
}

// if a heading is set and not empty
if (isset($heading) && (!empty($heading)))
{   // add a h1 tag to heading string
    $heading = "$heading";

    // if subtext is set, add <small> subtext to string
    if (isset($subtext) && (!empty($subtext)))
    {   // build a headline with heading and subtext
        $subtext = "<small>$subtext</small>";
        $headline = "<h1>$heading&nbsp;"."$subtext</h1>";
    }
    else
    {   // build just a headline - without subtext
        $headline = "<h1>$heading</h1>";    // draw just the heading
    }
}
else
{   // leave empty if it's not set
    $headline = '';
}

// switch plain youtube url to correct embed url string
$fbVideoEmbedCode = str_replace("width=\"560\"", "width=\"$fbVideoWidth\"", $fbVideoEmbedCode);
$fbVideoEmbedCode = str_replace("height=\"315\"", "height=\"$fbVideoHeight\"", $fbVideoEmbedCode);

echo $headline;
echo $fbVideoEmbedCode;
?>