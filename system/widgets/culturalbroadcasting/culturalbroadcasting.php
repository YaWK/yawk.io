<?php
// set default values
$cbaUrl = "https://cba.fro.at/331756";
$cbaHeading = '';
$cbaSubtext = '';
$cbaHeight = "188";
$cbaWidth = "100%";
$cbaWaveform = "0";
$cbaTitle = "0";
$cbaSocialmedia = "1";
$cbaPodcast = "0";
$cbaSeries = "0";
$cbaDescription = "0";
$cbaMeta = "0";
$cbaEmbedCode = '<iframe src="https://cba.fro.at/331756/embed?&waveform=false" width="100%" height="88" style="border:none; width:100%; height:88px;"></iframe>';

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
                /* url of the stream */
                case 'cbaUrl';
                    $cbaUrl = $w_value;
                    break;

                /* heading */
                case 'cbaHeading';
                    $cbaHeading = $w_value;
                    break;

                /* subtext */
                case 'cbaSubtext';
                    $cbaSubtext = $w_value;
                    break;

                /* height in px */
                case 'cbaHeight';
                    $cbaHeight = $w_value;
                    break;

                /* width in px */
                case 'cbaWidth';
                    $cbaWidth = $w_value;
                    break;

                /* display waveform? */
                case 'cbaWaveform';
                    $cbaWaveform = $w_value;
                    break;

                /* display title? */
                case 'cbaTitle';
                    $cbaTitle = $w_value;
                    break;

                /* display title? */
                case 'cbaSocialmedia';
                    $cbaSocialmedia = $w_value;
                    break;

                /* display podcast link? */
                case 'cbaPodcast';
                    $cbaPodcast = $w_value;
                    break;

                /* display description? */
                case 'cbaSeries';
                    $cbaSeries = $w_value;
                    break;

                /* display description? */
                case 'cbaDescription';
                    $cbaTitle = $w_value;
                    break;

                /* display meta? */
                case 'cbaMeta';
                    $cbaMeta = $w_value;
                    break;

                /* use embed code instead? */
                case 'cbaEmbedCode';
                    $cbaEmbedCode = $w_value;
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

    /* check if waveform is set to true or false */
    if ($cbaWaveform === "1")
    {
        $cbaWaveform = "&waveform=true";
    }
    else
        {   /* waveform false: adjust height correctly */
            $cbaWaveform = "&waveform=false";
        }

    /* is a title set? */
    if ($cbaTitle === "1")
    {
        $cbaTitle = "&title=true";
    }
    else
        {
            $cbaTitle = "&title=false";
        }

    /* is socialmedia set? */
    if ($cbaSocialmedia === "1")
    {
        $cbaSocialmedia = "&socialmedia=true";
    }
    else
        {
            $cbaSocialmedia = "&socialmedia=false";
        }

    /* is series set? */
    if ($cbaSeries === "1")
    {
        $cbaSeries = "&series_link=true";
    }
    else
        {
            $cbaSeries = "&series_link=false";
        }

    /* is podcast set? */
    if ($cbaPodcast === "1")
    {
        $cbaPodcast = "&subscribe=true";
    }
    else
        {
            $cbaSeries = "&subscribe=false";
        }

    /* is description set? */
    if ($cbaDescription === "1")
    {
        $cbaDescription = "&description=true";
    }
    else
        {
            $cbaDescription = "&description=false";
        }

    /* is meta set? */
    if ($cbaMeta === "1")
    {
        $cbaMeta = "&meta=true";
    }
    else
        {
            $cbaMeta = "&meta=false";
        }


    if (isset($cbaEmbedCode) && (!empty($cbaEmbedCode)))
    {
        echo $headline;
        echo $cbaEmbedCode;
    }
    else
        {
            $cbaSource = $cbaUrl."/embed?".$cbaWaveform.$cbaTitle.$cbaSocialmedia.$cbaPodcast.$cbaSeries.$cbaDescription.$cbaMeta;
            // HTML output
            echo "
            <!-- cba stream iframe -->
            $headline
            <iframe width=\"$cbaWidth\" 
                    height=\"$cbaHeight\" 
                    src=\"$cbaSource\" 
                    frameborder=\"0\"
                    scrolling=\"no\"
                    style=\"border:none; width:$cbaWidth; height:$cbaHeight;\">
            </iframe>";
        }