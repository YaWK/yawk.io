<?php
// set default values
$pinterestProfileUrl="https://de.pinterest.com/danielretzl/vienna/";
$pinterestProfileWidth="900";
$pinterestProfileHeight="500";
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
                case 'pinterestProfileUrl';
                    $pinterestProfileUrl = $w_value;
                    break;

                /* spotify width in px or & */
                case 'pinterestProfileWidth';
                    $pinterestProfileWidth = $w_value;
                    break;

                /* spotify height */
                case 'pinterestProfileHeight';
                    $pinterestProfileHeight = $w_value;
                    break;

                /* heading */
                case 'pinterestProfileHeading';
                    $heading = $w_value;
                    break;

                /* subtext */
                case 'pinterestProfileSubtext';
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

echo $headline;
?>
<a data-pin-do="embedUser" data-pin-board-width="<?php echo $pinterestProfileWidth;?>" data-pin-scale-height="<?php echo $pinterestProfileHeight;?>" data-pin-scale-width="115" href="<?php echo $pinterestProfileUrl;?>"></a>
<script async defer src="//assets.pinterest.com/js/pinit.js"></script>