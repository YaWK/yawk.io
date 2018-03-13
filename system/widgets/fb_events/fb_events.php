<?php
$fbEventsAppId = '';
$fbEventsPageId = '';
$fbEventsAccessToken = '';
$fbEventsLayout = '';
$fbEventsShowCounter = 'true';
$fbEventsShowCover = 'true';
$fbEventsType = 'future';
$fbEventsYearRange = '1';
$fbEventsSortation = 'asc';
$fbEventsStartDate = '';
$fbEventsEndDate = '';

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
                /* fb app ID */
                case 'fbEventsAppId';
                    $fbEventsAppId = $w_value;
                    break;

                /* fb events page ID  */
                case 'fbEventsPageId';
                    $fbEventsPageId = $w_value;
                    break;

                /* fb Events Access Token */
                case 'fbEventsAccessToken';
                    $fbEventsAccessToken = $w_value;
                    break;

                /* events year range */
                case 'fbEventsYearRange';
                    $fbEventsYearRange = $w_value;
                    break;

                /* event type (future, past, all) */
                case 'fbEventsType';
                    $fbEventsType = $w_value;
                    break;

                /* show cover if possible */
                case 'fbEventsShowCover';
                    $fbEventsShowCover = $w_value;
                    break;

                /* show user counter */
                case 'fbEventsShowCounter';
                    $fbEventsShowCounter = $w_value;
                    break;

                /* events layout (left, top, right, bottom, minimal or table) */
                case 'fbEventsLayout';
                    $fbEventsLayout = $w_value;
                    break;

                /* sortation order (asc or desc) */
                case 'fbEventsSortation';
                    $fbEventsSortation = $w_value;
                    break;

                /* fixed start date */
                case 'fbEventsStartDate';
                    $fbEventsStartDate = $w_value;
                    break;

                /* fixed end date */
                case 'fbEventsEndDate';
                    $fbEventsEndDate = $w_value;
                    break;

                /* heading */
                case 'fbEventsHeading';
                    $heading = $w_value;
                    break;

                /* subtext */
                case 'fbEventsSubtext';
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
if (isset($fbEventsAppId) && (!empty($fbEventsAppId)
&& (isset($fbEventsAccessToken) && (!empty($fbEventsAccessToken)
&& (isset($fbEventsPageId) && (!empty($fbEventsPageId)))))))
{
    // include facebook SDK JS
    echo "<script>
    window.fbAsyncInit = function() {
        FB.init({
            appId      : '".$fbEventsAppId."',
            xfbml      : true,
            version    : 'v2.7'
        });
        FB.AppEvents.logPageView();
    };

    (function(d, s, id){
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) {return;}
        js = d.createElement(s); js.id = id;
        js.src = \"https://connect.facebook.net/en_US/sdk.js\";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));
</script>";

    // WHICH EVENTS TO DISPLAY?
    // evaluation of event type select field
    if ($fbEventsType === "all")
    {
        // ALL EVENTS (FUTURE + PAST)
        $since_date = date('Y-01-01', strtotime('-' . $fbEventsYearRange . ' years'));
        $until_date = date('Y-01-01', strtotime('+' . $fbEventsYearRange . ' years'));
    }
    elseif ($fbEventsType == "future")
    {
        // UPCOMING EVENTS
        $since_date = date('Y-m-d');
        $until_date = date('Y-12-31', strtotime('+' . $fbEventsYearRange . ' years'));
    }
    elseif ($fbEventsType === "past")
    {
        // PAST EVENTS
        $since_date = date('Y-01-01', strtotime('-' . $fbEventsYearRange . ' years'));
        $until_date = date('Y-m-d');
    }
    else
        {   // IF NOT SET - use default:
            // UPCOMING EVENTS
            $since_date = date('Y-m-d');
            $until_date = date('Y-12-31', strtotime('+' . $fbEventsYearRange . ' years'));
        }

    // IF START + END DATE IS SET
    if (isset($fbEventsStartDate) && (!empty($fbEventsStartDate))
    && (isset($fbEventsEndDate) && (!empty($fbEventsEndDate))))
    {
        $since_date = date($fbEventsStartDate);
        $until_date = date($fbEventsEndDate);
    }

    // unix timestamp years
    $since_unix_timestamp = strtotime($since_date);
    $until_unix_timestamp = strtotime($until_date);

    // prepare fields
    $fields="id,name,description,place,start_time,cover,maybe_count,attending_count,is_canceled";

    // prepare API call
    $json_link = "https://graph.facebook.com/v2.7/{$fbEventsPageId}/events/attending/?fields={$fields}&access_token={$fbEventsAccessToken}&since={$since_unix_timestamp}&until={$until_unix_timestamp}";

    // get json string
    $json = file_get_contents($json_link);

    // convert json to object
    $obj = json_decode($json, true, 512, JSON_BIGINT_AS_STRING);

    // sortation
    if ($fbEventsSortation === "asc")
    {   // reverse array data to display upcoming event first
        $obj['data'] = array_reverse($obj['data']);
    }

    echo $headline;
    echo "<pre>";
    print_r($obj);
    echo "</pre>";

}
else
    {
        die ("Unable to load Facebook Events. Your app ID, access token or page id is not set correctly!");
    }


?>