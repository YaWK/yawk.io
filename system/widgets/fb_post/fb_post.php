<?php
// set default values
$fbPostEmbedCode='<iframe src="https://www.facebook.com/plugins/post.php?href=https%3A%2F%2Fwww.facebook.com%2Fzuck%2Fposts%2F10103625699665601&width=500" width="500" height="625" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowTransparency="true"></iframe>';
$fbPostWidth="500";
$fbPostHeight="625";
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
                case 'fbPostEmbedCode';
                    $fbPostEmbedCode = $w_value;
                    break;

                /* spotify width in px or & */
                case 'fbPostWidth';
                    $fbPostWidth = $w_value;
                    break;

                /* spotify height */
                case 'fbPostHeight';
                    $fbPostHeight = $w_value;
                    break;

                /* heading */
                case 'fbPostHeading';
                    $heading = $w_value;
                    break;

                /* subtext */
                case 'fbPostSubtext';
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
$fbPostEmbedCode = str_replace("width=\"500\"", "width=\"$fbPostWidth\"", $fbPostEmbedCode);
$fbPostEmbedCode = str_replace("height=\"625\"", "height=\"$fbPostHeight\"", $fbPostEmbedCode);

echo $headline;
echo $fbPostEmbedCode;
?>