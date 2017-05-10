<?php
// set default values
$twitchChannel="yourChannel";
$twitchChannelHeight="720";
$twitchChannelWidth="100%";
$twitchChannelFullscreen="true";
$twitchChat=1;
$twitchChatHeight="250";
$twitchChatWidth="100%";

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
                /* name of the channel to stream */
                case 'twitchChannel';
                    $twitchChannel = $w_value;
                    break;

                /* width of video stream frame in pixels */
                case 'twitchChannelWidth';
                    $twitchChannelWidth = $w_value;
                    break;

                /* height of video stream frame in pixels */
                case 'twitchChannelHeight';
                    $twitchChannelHeight = $w_value;
                    break;

                /* chat frame enabled or disabled int 0|1 */
                case 'twitchChat';
                    $twitchChat = $w_value;
                    break;

                /* width of chat frame in pixels */
                case 'twitchChatWidth';
                    $twitchChatWidth = $w_value;
                    break;

                /* height of chat frame in pixels */
                case 'twitchChatHeight';
                    $twitchChatHeight = $w_value;
                    break;

                /* fullscreen allowed? 0|1 */
                case 'twitchChannelFullscreen';
                    $twitchChannelFullscreen = $w_value;
                    break;

                /* heading */
                case 'twitchHeading';
                    $heading = $w_value;
                    break;

                /* subtext */
                case 'twitchSubtext';
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

// to output correct html
if ($twitchChannelFullscreen === "true")
{   // set fullscreen property
    $allowfullscreen = "allowfullscreen=\"true\"";
}
else
    {   // or leave empty if fullscreen should be false
        $allowfullscreen = '';
    }
echo $headline;
// HTML output
echo "
<!-- twitch video stream -->
<iframe
    src=\"http://player.twitch.tv/?channel=$twitchChannel\"
    height=\"$twitchChannelHeight\"
    width=\"$twitchChannelWidth\"
    frameborder=\"0\"
    scrolling=\"no\"
    $allowfullscreen\">
</iframe>";

// check if chat should be shown
if (isset($twitchChat) && ($twitchChat === "1"))
{   // ok, show chat html frame
    echo "

<!-- twitch chat -->
<iframe frameborder=\"0\"
    scrolling=\"no\"
    id=\"chat_embed\"
    src=\"http://www.twitch.tv/$twitchChannel/chat\"
    height=\"$twitchChatHeight\"
    width=\"$twitchChatWidth\">
</iframe>";
    }
