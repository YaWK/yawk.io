<?php
include ('classes/events.php');
if (!isset($fbEvents) || (empty($fbEvents)))
{
    $fbEvents = new \YAWK\WIDGETS\FACEBOOK\events();
}
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
                    $fbEvents->appId = $w_value;
                    break;

                /* fb events page ID  */
                case 'fbEventsPageId';
                    $fbEvents->pageId = $w_value;
                    break;

                /* fb Events Access Token */
                case 'fbEventsAccessToken';
                    $fbEvents->accessToken = $w_value;
                    break;

                /* events year range */
                case 'fbEventsYearRange';
                    $fbEvents->yearRange = $w_value;
                    break;

                /* event type (future, past, all) */
                case 'fbEventsType';
                    $fbEvents->type = $w_value;
                    break;

                /* show cover if possible */
                case 'fbEventsShowCover';
                    $fbEvents->showCover = $w_value;
                    break;

                /* show cover if possible */
                case 'fbEventsCoverClass';
                    $fbEvents->coverClass = $w_value;
                    break;

                /* show user counter */
                case 'fbEventsShowCounter';
                    $fbEvents->showPeopleCounter = $w_value;
                    break;

                /* events layout (left, top, right, bottom, minimal or table) */
                case 'fbEventsLayout';
                    $fbEvents->layout = $w_value;
                    break;

                /* sortation order (asc or desc) */
                case 'fbEventsSortation';
                    $fbEvents->sortation = $w_value;
                    break;

                /* fixed start date */
                case 'fbEventsStartDate';
                    $fbEvents->startDate = $w_value;
                    break;

                /* fixed end date */
                case 'fbEventsEndDate';
                    $fbEvents->endDate = $w_value;
                    break;

                /* heading */
                case 'fbEventsHeading';
                    $fbEvents->heading = $w_value;
                    break;

                /* subtext */
                case 'fbEventsSubtext';
                    $fbEvents->subtext = $w_value;
                    break;

                /* font title */
                case 'fbEventsFontEventName';
                    $fbEvents->fontEventName = $w_value;
                    break;

                /* font title css */
                case 'fbEventsFontEventNameCss';
                    $fbEvents->fontEventNameCss = $w_value;
                    break;

                /* font date */
                case 'fbEventsFontDate';
                    $fbEvents->fontEventDate = $w_value;
                    break;

                /* font date css */
                case 'fbEventsFontDateCss';
                    $fbEvents->fontEventDateCss = $w_value;
                    break;

                /* font dateword */
                case 'fbEventsFontDateword';
                    $fbEvents->fontEventDateword = $w_value;
                    break;

                /* font dateword css */
                case 'fbEventsDatewordCss';
                    $fbEvents->fontEventDatewordCss = $w_value;
                    break;

                /* font location */
                case 'fbEventsFontLocation';
                    $fbEvents->fontEventLocation = $w_value;
                    break;

                /* font location css */
                case 'fbEventsFontLocationCss';
                    $fbEvents->fontEventLocationCss = $w_value;
                    break;

                /* font address */
                case 'fbEventsFontAddress';
                    $fbEvents->fontEventAddress = $w_value;
                    break;

                /* font address css */
                case 'fbEventsFontAddressCss';
                    $fbEvents->fontEventAddressCss = $w_value;
                    break;

                /* font desc */
                case 'fbEventsFontDescription';
                    $fbEvents->fontEventDescription = $w_value;
                    break;

                /* font desc css */
                case 'fbEventsFontDescriptionCss';
                    $fbEvents->fontEventDescriptionCss = $w_value;
                    break;

                /* font people */
                case 'fbEventsFontPeople';
                    $fbEvents->fontEventPeople = $w_value;
                    break;

                /* font people css */
                case 'fbEventsFontPeopleCss';
                    $fbEvents->fontEventPeopleCss = $w_value;
                    break;

                /* font canceled */
                case 'fbEventsFontCanceled';
                    $fbEvents->fontEventCanceled = $w_value;
                    break;

                /* font canceled css */
                case 'fbEventsFontCanceledCss';
                    $fbEvents->fontEventCanceledCss = $w_value;
                    break;

                /* bgcolor */
                case 'fbEventsBgColor';
                    $fbEvents->bgColor = $w_value;
                    break;

                /* text color */
                case 'fbEventsTextColor';
                    $fbEvents->textColor = $w_value;
                    break;

                /* canceled events */
                case 'fbEventsCanceledOn';
                    $fbEvents->canceledOn = $w_value;
                    break;

                /* canceled events */
                case 'fbEventsHrClass';
                    $fbEvents->hrClass = $w_value;
                    break;
            }
        } /* END LOAD PROPERTIES */
    } // end while fetch row (fetch widget settings)
}

// if a heading is set and not empty
if (isset($fbEvents->heading) && (!empty($fbEvents->heading)))
{   // add a h1 tag to heading string
    $fbEvents->heading = "$fbEvents->heading";

    // if subtext is set, add <small> subtext to string
    if (isset($fbEvents->subtext) && (!empty($fbEvents->subtext)))
    {   // build a headline with heading and subtext
        $fbEvents->subtext = "<small>$fbEvents->subtext</small>";
        $fbEvents->headline = "<h1>$fbEvents->heading&nbsp;"."$fbEvents->subtext</h1>";
    }
    else
    {   // build just a headline - without subtext
        $fbEvents->headline = "<h1>$fbEvents->heading</h1>";    // draw just the heading
    }
}
else
{   // leave empty if it's not set
    $fbEvents->headline = '';
}

echo $fbEvents->headline;
$fbEvents->display();


?>