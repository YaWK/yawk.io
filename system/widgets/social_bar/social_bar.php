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
            }
        } /* END LOAD PROPERTIES */
    } // end while fetch row (fetch widget settings)
}


// HTML output
echo "      <div class=\"white small pull-right\">
          <ul class=\"list-inline small\">
            <li><i class=\"fa fa-facebook-f\" style=\"color:#ccc;\"></i>acebook</li>
            <li><i class=\"fa fa-twitter\" style=\"color:#ccc;\"></i> twitter</li>
            <li><i class=\"fa fa-youtube-play\" style=\"color:#ccc;\"></i> YouTube&nbsp;</li>
          </ul>
      </div>";