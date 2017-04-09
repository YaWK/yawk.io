<?php
$twitterTweetButtonText = "Yet another WebKit - spread the word out lout! Sharing is caring!";
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
                /* text */
                case 'twitterTweetButtonText';
                    $twitterTweetButtonText = $w_value;
                    break;

                /* heading */
                case 'twitterTweetButtonHeading';
                    $heading = $w_value;
                    break;

                /* subtext */
                case 'twitterTweetButtonSubtext';
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
$twitterTweetButtonText = rawurldecode($twitterTweetButtonText);
echo $headline;
?>

<a class="twitter-share-button"
   href="https://twitter.com/intent/tweet?text=<?php echo $twitterTweetButtonText; ?>"
   data-size="large">Tweet</a>






































