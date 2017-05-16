<?php
/*
if (!isset($jPlayerVideo) || (empty($jPlayerVideo)))
{   // include player class
    require_once ("system/widgets/jplayer_video/classes/jplayer_video.class.php");
    // create new player object
    $jPlayerVideo = new \YAWK\WIDGETS\jPlayerVideo();
}
*/
?>
<?php
// set default values
$mediafile = '';
$heading = '';
$subtext = '';
$width = '100%';

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
                case 'plyrMediaFile';
                    $mediafile = $w_value;
                    break;

                /* heading */
                case 'plyrHeading';
                    $heading = $w_value;
                    break;

                /* subtext */
                case 'plyrSubtext';
                    $subtext = $w_value;
                    break;

                /* width */
                case 'plyrWidth';
                    $width = $w_value;
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
    <!-- plyr -->
    <script src="system/widgets/plyr/js/plyr.js"></script>
    <script>plyr.setup();</script>
    <link type="text/css" rel="stylesheet" href="system/widgets/plyr/js/plyr.css">

    <video poster="/path/to/poster.jpg" controls style="width: <?php echo $width; ?>">
        <source src=" <?php echo $mediafile; ?>" type="video/mp4">
        <!-- <source src="/path/to/video.webm" type="video/webm"> -->
        <!-- Captions are optional -->
        <track kind="captions" label="English captions" src="/path/to/captions.vtt" srclang="en" default>
    </video>

<?php
// }   // end namespace
?>