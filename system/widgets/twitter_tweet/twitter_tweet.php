<?php
// twitter single tweet default settings
$twitterUrl = "";      // single tweet URL
$twitterHideDataCards = "0";            // data-cards: hidden
$twitterDataConversation = "0";         // data-conversation: none

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
                /* single tweet URL */
                case 'twitterSingleTweetUrl';
                    $twitterUrl = $w_value;
                    break;

                /* show or hide image media? */
                case 'twitterSingleTweetHideDataCards';
                    $twitterHideDataCards = $w_value;
                    break;

                /* show or hide conversation in tweet */
                case 'twitterSingleTweetDataConversation';
                    $twitterDataConversation = $w_value;
                    break;

                /* heading */
                case 'twitterSingleTweetHeading';
                    $heading = $w_value;
                    break;

                /* subtext */
                case 'twitterSingleTweetSubtext';
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

    /* CHECK SETTINGS AND SET THEM CORRECTLY */
    /* DATA CONVERSATION */
    // if data conversation is set to 1, conversation will be shown in this tweet
    if ($twitterDataConversation === "1")
    {
        $twitterDataConversation = '';
    }
    else
    {   // conversation will be hidden from this tweet
        $twitterDataConversation = 'data-conversation="none"';
    }

    /* HIDE MEDIA */
    // if data-cards is set to 1, media files will be shown
    if ($twitterHideDataCards === "1")
    {
        $twitterHideDataCards = 'data-cards="hidden"';
    }
    else
    {   // otherwise, media will be hidden from this tweet
        $twitterHideDataCards = '';
    }

echo $headline;
?>
<blockquote class="twitter-tweet" <?php echo $twitterHideDataCards." ".$twitterDataConversation; ?>><a href="<?php echo $twitterUrl; ?>"></a></blockquote>
<script async src="//platform.twitter.com/widgets.js" charset="utf-8"></script>
