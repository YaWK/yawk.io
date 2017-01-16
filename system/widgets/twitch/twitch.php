<?php
// default values
$twitchChannel="yourChannel";
$twitchChannelHeight="720";
$twitchChannelWidth="100%";
$twitchChat=1;
$twitchChatHeight="250";
$twitchChatWidth="100%";

// $_GET['widgetID'] will be generated in \YAWK\widget\loadWidgets($db, $position)
if (isset($_GET['widgetID']))
{
    // widget ID
    $widgetID = $_GET['widgetID'];


    // get settings from database
    $res = $db->query("SELECT * FROM {widget_settings}
	                        WHERE widgetID = '".$widgetID."'
	                        AND activated = '1'");
    while($row = mysqli_fetch_assoc($res)){
        $w_property = $row['property'];
        $w_value = $row['value'];
        $w_widgetType = $row['widgetType'];
        $w_activated = $row['activated'];
        /* end of get widget settings */

        /* LOAD PROPERTIES */
        if (isset($w_property)){
            switch($w_property)
            {
                case 'twitchChannel';
                    $twitchChannel = $w_value;
                    break;

                case 'twitchChannelWidth';
                    $twitchChannelWidth = $w_value;
                    break;

                case 'twitchChannelHeight';
                    $twitchChannelHeight = $w_value;
                    break;

                case 'twitchChat';
                    $twitchChat = $w_value;
                    break;

                case 'twitchChatWidth';
                    $twitchChatWidth = $w_value;
                    break;

                case 'twitchChatHeight';
                    $twitchChatHeight = $w_value;
                    break;
            }
        } /* END LOAD PROPERTIES */

    } // end while fetch row (fetch widget settings)
} // if no widget ID is given or settings could not be retrieved, use this as defaults:


// include twitch video stream
echo "<iframe
        src=\"http://player.twitch.tv/?channel=$twitchChannel\"
        height=\"$twitchChannelHeight\"
        width=\"$twitchChannelWidth\"
        frameborder=\"0\"
        scrolling=\"no\"
        allowfullscreen=\"true\">
      </iframe>";

if (isset($twitchChat) && ($twitchChat === "1"))
    {
        // include twitch chat for this channel
        echo "<iframe frameborder=\"0\"
        scrolling=\"no\"
        id=\"chat_embed\"
        src=\"http://www.twitch.tv/$twitchChannel/chat\"
        height=\"$twitchChatHeight\"
        width=\"$twitchChatWidth\">
        </iframe>";
    }
