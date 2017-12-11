<?php
// set default values
$youtubeVideoUrl="http://www.youtube.com/";
$youtubeVideo='';
$heading='';
$subtext='';
$youtubeDescription='';
$youtubeFullscreen="true";
$youtubeAutoplay="false";
$youtubeHeight="720";
$youtubeWidth="100%";

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
                case 'youtubeVideoUrl';
                    $youtubeVideoUrl = $w_value;
                    break;

                /* allow fullscreen */
                case 'youtubeFullscreen';
                    $youtubeFullscreen = $w_value;
                    break;

                /* autplay */
                case 'youtubeAutoplay';
                    $youtubeAutoplay = $w_value;
                    break;

                /* height of video frame in pixels */
                case 'youtubeHeight';
                    $youtubeHeight = $w_value;
                    break;

                /* fullscreen allowed? 0|1 */
                case 'youtubeWidth';
                    $youtubeWidth = $w_value;
                    break;

                /* heading */
                case 'youtubeHeading';
                    $heading = $w_value;
                    break;

                /* subtext */
                case 'youtubeSubtext';
                    $subtext = $w_value;
                    break;

                /* description */
                case 'youtubeDescription';
                    $youtubeDescription = $w_value;
                    break;
            }
        } /* END LOAD PROPERTIES */
    } // end while fetch row (fetch widget settings)
}

// to output correct html
if ($youtubeFullscreen === "true")
{   // set fullscreen property
    $allowfullscreen = "allowfullscreen=\"true\"";
}
else
{   // or leave empty if fullscreen should be false
    $allowfullscreen = '';
}

// to output correct html
if ($youtubeAutoplay === "true")
{   // set fullscreen property
    $autoplay = "?autoplay=1";
}
else
{   // or leave empty if fullscreen should be false
    $autoplay = '';
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

// if description is set, add <p> to string
if (isset($youtubeDescription) && (!empty($youtubeDescription)))
{   // set description string
    $description = "<p>$youtubeDescription</p>";
}
else
    {   // no description is set
        $description = '';
    }

// switch plain youtube url to correct embed url string
$youtubeVideoUrl = str_replace("watch?v=","embed/",$youtubeVideoUrl.$autoplay);

// HTML output
echo "
<!-- youtube video iframe -->
$headline
<iframe width=\"$youtubeWidth\" 
        height=\"$youtubeHeight\" 
        src=\"$youtubeVideoUrl\" 
        frameborder=\"0\"
        scrolling=\"no\"
        $allowfullscreen>
</iframe>
$description";

