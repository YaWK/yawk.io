<?php
// set default values
$chaturbateRoom = "yourRoom";
$disableSound = "1";
$embedVideoOnly = "0";
$width = "523";
$height = "850";
$heading='';
$subtext='';

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
                case 'chaturbateRoom';
                    $chaturbateRoom = $w_value;
                    break;

                /* disable sound 0|1 default: 1 */
                case 'chaturbateDisableSound';
                    $disableSound = $w_value;
                    break;

                /* video only? 0|1 default: 0 */
                case 'chaturbateVideoOnly';
                    $embedVideoOnly = $w_value;
                    break;

                /* iframe height in px */
                case 'chaturbateHeight';
                    $height = $w_value;
                    break;

                /* iframe width in px */
                case 'chaturbateWidth';
                    $width = $w_value;
                    break;

                /* heading */
                case 'chaturbateHeading';
                    $heading = $w_value;
                    break;

                /* subtext */
                case 'chaturbateSubtext';
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
        $headline = "<h1>$heading&nbsp;"."&nbsp;$subtext</h1>";
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

// build video url
$chaturbateVideoURL = "https://chaturbate.com/affiliates/in/?tour=Jrvi&campaign=APohb&track=embed&room=$chaturbateRoom&bgcolor=transparent&disable_sound=$disableSound&embed_video_only=$embedVideoOnly&target=_parent";

// HTML output
echo "
<!-- chaturbate room stream iframe -->
$headline
<iframe src=\"$chaturbateVideoURL\" 
        width=\"$width\" 
        height=\"$height\" 
        frameborder=\"0\"
        scrolling=\"no\">
</iframe>";