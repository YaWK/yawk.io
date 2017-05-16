<?php
// set default values
$mediafile = '';
$filetype = '';
$heading = '';
$subtext = '';
$width = '100%';
$poster = '';
$posterHtml = '';
$textTrackFileHtmlOutput = '';
$autoplay = 'false';
$clicktoplay = 'true';
$disableContextMenu = 'true';
$hideControls = 'true';
$showPosterOnEnd = 'false';

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
                    if (strpos($mediafile, '.mp4') !== false)
                    {
                        $filetype = "video/mp4";
                    }
                    if (strpos($mediafile, '.webm') !== false)
                    {
                        $filetype = "video/webm";
                    }
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

                /* poster */
                case 'plyrPoster';
                    $poster = $w_value;
                    if (isset($poster) && (!empty($poster)))
                    {   // poster is set...
                        $posterHtml="poster=\"$poster\"";
                    }
                    else
                        {   // no poster set, leave output empty
                            $posterHtml = "poster=\"\"";
                        }
                    break;

                /* text track file */
                case 'plyrTextTrackFile';
                    $textTrackFile = $w_value;
                    break;

                /* text track label */
                case 'plyrTextTrackLabel';
                    $textTrackLabel = $w_value;
                    break;

                /* text track srclang */
                case 'plyrTextTrackSrcLang';
                    $textTrackSrcLang = $w_value;
                    break;

                /* autoplay */
                case 'plyrAutoplay';
                    $autoplay = $w_value;
                    break;

                /* click2play */
                case 'plyrClickToPlay';
                    $clicktoplay = $w_value;
                    break;

                /* disable context menu */
                case 'plyrDisableContextMenu';
                    $disableContextMenu = $w_value;
                    break;

                /* hide controls  */
                case 'plyrHideControls';
                    $hideControls = $w_value;
                    break;

                /* show poster on end */
                case 'plyrShowPosterOnEnd';
                    $showPosterOnEnd = $w_value;
                    break;
            }

            // check if text track file, language and label are set
            if (isset($textTrackFile) && (!empty($textTrackFile)))
            {   // language found
                if (isset($textTrackSrcLang) && (!empty($textTrackSrcLang)))
                {   // store var src language
                    $srcLang = $textTrackSrcLang;
                }
                else
                    {   // not set - default language:
                        $srcLang = "en";
                    }
                // label is set
                if (isset($textTrackLabel) && (!empty($textTrackLabel)))
                {   // store label var
                    $label = $textTrackLabel;
                }
                else
                    {   // not set - default label:
                        $label = "English";
                    }
            // output text track html...
            $textTrackFileHtmlOutput = "<track kind=\"captions\" label=\"$label\" srclang=\"$srcLang\" src=\"$textTrackFile\" default>";
            }
            else
                {   // no text track is set, output nothing
                    $textTrackFileHtmlOutput = '';
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
    <!-- output plyr html player -->
<section>
    <video <?php echo $posterHtml; ?> controls style="width: <?php echo $width; ?>">
        <source src="<?php echo $mediafile; ?>" type="<?php echo $filetype; ?>">
        <!-- Text track file -->
        <?php echo $textTrackFileHtmlOutput; ?>
        <!-- Fallback for browsers that don't support the <video> element -->
        <a href="<?php echo $mediafile; ?>" download>Download</a>
    </video>
</section>

<!-- plyr js -->
<script src="system/widgets/plyr/js/plyr.js"></script>
<!-- run plyr -->
<script>plyr.setup({ "autoplay":<?php echo $autoplay; ?>, "disableContextMenu":<?php echo $disableContextMenu; ?>, "hideControls":<?php echo $hideControls; ?>, "showPosterOnEnd":<?php echo $showPosterOnEnd; ?>, "clickToPlay":<?php echo $clicktoplay; ?> });</script>
<!-- plyr css -->
<link type="text/css" rel="stylesheet" href="system/widgets/plyr/js/plyr.css">

<!-- Rangetouch to fix <input type="range"> on touch devices (see https://rangetouch.com) -->
<script src="system/widgets/plyr/js/rangetouch.js" async></script>