<?php
// set default values
$instagramUrl="https://www.instagram.com/p/BSqEReEgW4d/";
$instagramWidth="100%";
$instagramTarget="_blank";
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
                case 'instagramUrl';
                    $instagramUrl = $w_value;
                    break;

                /* instagram width in px or & */
                case 'instagramWidth';
                    $instagramWidth = $w_value;
                    break;

                /* link target */
                case 'instagramTarget';
                    $instagramTarget = $w_value;
                    break;

                /* heading */
                case 'instagramHeading';
                    $heading = $w_value;
                    break;

                /* subtext */
                case 'instagramSubtext';
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

echo $headline;
?>
<blockquote class="instagram-media"
            data-instgrm-captioned data-instgrm-version="7"
            style="background:#fff;
                   border:0;
                   border-radius:3px;
                   box-shadow:0 0 1px 0 rgba(0,0,0,0.5),0 1px 10px 0 rgba(0,0,0,0.15);
                   margin: 1px;
                   max-width:<?php echo $instagramWidth; ?>;
                   padding:0;
                   width:99.375%;
                   width:-webkit-calc(100% - 2px);
                   width:calc(100% - 2px);">

    <p style="margin:8px 0 0 0; padding:0 4px;">
        <a href="<?php echo $instagramUrl; ?>"
           style="color:#000;
                  font-family:Arial,sans-serif;
                  font-size:14px;
                  font-style:normal;
                  font-weight:normal;
                  line-height:17px;
                  text-decoration:none;
                  word-wrap:break-word;"
           target="<?php echo $instagramTarget; ?>"></a>
    </p>
</blockquote>
<script async defer src="//platform.instagram.com/en_US/embeds.js"></script>