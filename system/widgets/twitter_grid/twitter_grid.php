<?php
// twitter default settings
$twitterGridUrl = "https://twitter.com/TwitterDev/timelines/539487832448843776";
$twitterGridTweetLimit = "5";           // latest n tweets

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
                /* twitter user url */
                case 'twitterGridUrl';
                    $twitterGridUrl = $w_value;
                    break;

                /* tweet limit */
                case 'twitterGridTweetLimit';
                    $twitterGridTweetLimit = $w_value;
                    break;

                /* heading */
                case 'twitterGridHeading';
                    $heading = $w_value;
                    break;

                /* subtext */
                case 'twitterGridSubtext';
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
// remove trailing slash from url
$twitterGridUrl = rtrim($twitterGridUrl,"/");
// explode user from URL
$twitterUserArray = explode("/", $twitterGridUrl);
$twitterUser = $twitterUserArray['3'];
echo $headline;
?>

<a class="twitter-grid" data-limit="<?php echo $twitterGridTweetLimit; ?>" href="<?php echo $twitterGridUrl; ?>"><?php echo $twitterUser; ?> Tweets</a>
<script async src="//platform.twitter.com/widgets.js" charset="utf-8"></script>







































