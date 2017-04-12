<?php
// set default values
$pinterestPinUrl="https://www.pinterest.com/pin/99360735500167749/";
$pinterestPinSize="large";
$pinterestPinHideDescription = 'data-pin-terse="true"';
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
                case 'pinterestPinUrl';
                    $pinterestPinUrl = $w_value;
                    break;

                /* small, medium, large */
                case 'pinterestPinSize';
                    $pinterestPinSize = $w_value;
                    break;

                /* hide description true|false */
                case 'pinterestPinHideDescription';
                    $pinterestPinHideDescription = $w_value;
                    break;

                /* heading */
                case 'pinterestPinHeading';
                    $heading = $w_value;
                    break;

                /* subtext */
                case 'pinterestPinSubtext';
                    $subtext = $w_value;
                    break;
            }
        } /* END LOAD PROPERTIES */
    } // end while fetch row (fetch widget settings)
}
if ($pinterestPinHideDescription === "1")
{   // hide description
    $pinterestPinHideDescription = 'data-pin-terse="true"';
}
else
    {
        $pinterestPinHideDescription = 'data-pin-terse="false"';
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
<a data-pin-do="embedPin" data-pin-width="<?php echo $pinterestPinSize;?>" data-pin-terse="<?php echo $pinterestPinHideDescription;?>" href="<?php echo $pinterestPinUrl;?>"></a>
<script async defer src="//assets.pinterest.com/js/pinit.js"></script>