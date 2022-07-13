<?php
namespace YAWK\WIDGETS\FACEBOOK\EVENTS
{
    /**
     * <b>Use Facebook Graph API to get Events from a Facebook Page. Require App ID and Access Token.</b>
     *
     * <p>With this widget, you are able to embed events from your facebook page onto your website.
     * It helps you to keep your website up to date. Have you ever been bored of adding the same content twice?
     * Previously it was like that: Add a event on facebook, invite your friends, add this date to your website.
     * This plugin makes it easy for you to keep focused on your social activities. If you change your facebook
     * event, the data on your website will be updated automatically. No matter if it's the event date, time
     * title, cover image or something else.</p>
     *
     * <p>You need an APP ID, as well as an access token for the facebook page you want to embed events from.
     * For reasons, you (respectively the app id / access token) needs administrative access rights to the facebook
     * page you want to grab events from. Create a new fb event widget in the backend, enter app id, access token
     * and your page id (facebook.com/YOURPAGE) and you're good to go. Experiment with the settings to fit your needs.
     *
     * This class only got 2 important methods: the constructor, which loads the settings for this widget,
     * as well as the display() method. It connects to facebook, gets the data, walk through the array
     * and manage the output of your events. This method could surely be more abstract. Code Improvement
     * and abstraction will implemented due future updates on this class. A pragmatical approach - for now.
     * </p>
     *
     * @package    YAWK
     * @author     Daniel Retzl <danielretzl@gmail.com>
     * @copyright  2018 Daniel Retzl
     * @license    https://opensource.org/licenses/MIT
     * @version    1.0.0
     * @link       http://yawk.io
     * @annotation Use Facebook Graph API to get Events from a facebook page and embed this data with your own design.
     */
    class fbEvents
    {
        /** @var object global widget object data */
        public $widget = '';
        /** @var string your app ID (from developers.facebook.com) */
        public $fbEventsAppId = '';
        /** @var string your page ID (http://facebook.com/{YOURPAGEID} */
        public $fbEventsPageId = '';
        /** @var string your access token (secret word from developers.facebook.com) */
        public $fbEventsAccessToken = '';
        /** @var string user defined layout */
        public $fbEventsLayout = 'left';
        /** @var string show cover image? true|false */
        public $fbEventsShowCover = 'true';
        /** @var string any css class for the cover image */
        public $fbEventsCoverClass = '';
        /** @var string which events should be shown? future|past|all */
        public $fbEventsType = 'future';
        /** @var string show events of this time range */
        public $fbEventsYearRange = '1';
        /** @var string how events should be sorted: ascending|descending */
        public $fbEventsSortation = 'asc';
        /** @var string user defined start date */
        public $fbEventsStartDate = '';
        /** @var string user defined end date */
        public $fbEventsEndDate = '';
        /** @var string events since this date (used for calc) */
        public $sinceDate = '';
        /** @var string events until this date (used for calc) */
        public $untilDate = '';
        /** @var string headline before the widget (heading + subtext, if set) */
        public $headline = '';
        /** @var string heading before widget */
        public $fbEventsHeading = '';
        /** @var string subtext before widget */
        public $fbEventsSubtext = '';
        /** @var string fields that should be selected from facebook graph */
        public $fields = 'id,name,description,place,start_time,cover,maybe_count,attending_count,is_canceled';
        /** @var object api result (as object) */
        public $apiObject;
        /** @var array all api result data (multidimensional array) */
        public $data = array();
        /** @var array current event (multidimensional array) */
        public $event = array();
        /** @var object datetime of current event */
        public $eventDate;
        /** @var string pretty formatted date - will be used in frontend view */
        public $prettyDate = '';
        /** @var string calculated date will be used in frontend view */
        public $dateString = '';
        /** @var string should interested people be shown? 0|1 */
        public $fbEventsShowCounter = '1';
        /** @var int how many people are interested or attending - used for calculations */
        public $iPeopleCount = '';
        /** @var string how many people are interested - will be used in frontend view */
        public $showPeople = '';
        /** @var string font size of the event title */
        public $fbEventsFontEventName = 'h2';
        /** @var string internal placeholder variable */
        public $fontEventNameH = '';
        /** @var string custom css of the event title */
        public $fbEventsFontEventNameCss = '';
        /** @var string font size of the event date */
        public $fbEventsFontDate = 'h4';
        /** @var string internal placeholder variable */
        public $fontEventDateH = '';
        /** @var string custom css of the event date */
        public $fbEventsFontDateCss = '';
        /** @var string dateword (dateString) as small tag? true|false */
        public $fbEventsFontDateword = 'true';
        /** @var string custom css of the dateword (dateString) */
        public $fbEventsDatewordCss = '';
        /** @var string font size of the event location */
        public $fbEventsFontLocation = 'globaltext';
        /** @var string custom css of the event location */
        public $fbEventsFontLocationCss = '';
        /** @var string internal placeholder var */
        public $fontEventLocationH = '';
        /** @var string font size of the event address */
        public $fbEventsFontAddress = 'globaltext';
        /** @var string internal placeholder var */
        public $fontEventAddressH = '';
        /** @var string custom css of the event address */
        public $fbEventsFontAddressCss = '';
        /** @var string font size of the event description */
        public $fbEventsFontDescription = 'globaltext';
        /** @var string internal placeholder var */
        public $fontEventDescriptionH = '';
        /** @var string custom css of the event description */
        public $fbEventsFontDescriptionCss = '';
        /** @var string font size of the event people (interested / attending) */
        public $fbEventsFontPeople = 'globaltext';
        /** @var string internal placeholder var */
        public $fontEventPeopleH = '';
        /** @var string custom css of the event people (interested / attending) */
        public $fbEventsFontPeopleCss = 'text-muted';
        /** @var string font size of canceled event */
        public $fbEventsFontCanceled = 'h3';
        /** @var string custom css of canceled event */
        public $fbEventsFontCanceledCss = 'text-danger';
        /** @var string font title html markup start */
        public $fontTitleStart = '';
        /** @var string font title html markup end */
        public $fontTitleEnd = '';
        /** @var string display <hr> between address and description */
        public $fbEventsDisplaySpacer = 'true';
        /** @var string background color of the event jumbotron box */
        public $fbEventsBgColor = '222222';
        /** @var string text color of the event jumbotron box */
        public $fbEventsTextColor = 'CCCCCC';
        /** @var string address string */
        public $address = '';
        /** @var string canceled events strike-trough? true|false */
        public $fbEventsCanceledOn = 'true';
        /** @var string css class of seperator line  */
        public $fbEventsHrClass = '';
        /** @var string facebook link? true|false */
        public $fbEventsFbLink = 'true';
        /** @var string display google map? true|false */
        public $fbEventsGoogleMap = 'true';
        /** @var int limit event to (x) */
        public $fbEventsLimit = 0;
        /** @var string limit markup */
        public $limit = '';
        /** @var string contains error message, if any */
        public $errorMsg = '';

        public function __construct($db)
        {
            // load this widget settings from db
            $this->widget = new \YAWK\widget();
            $settings = $this->widget->getWidgetSettingsArray($db);
            foreach ($settings as $property => $value)
            {
                $this->$property = $value;
            }
        }

        public function display()
        {
            if (isset($this->fbEventsAppId) && (!empty($this->fbEventsAppId)
                    && (isset($this->fbEventsAccessToken) && (!empty($this->fbEventsAccessToken)
                            && (isset($this->fbEventsPageId) && (!empty($this->fbEventsPageId)))))))
            {
                /*
                // include facebook SDK JS
                echo "<script>
                window.fbAsyncInit = function() {
                    FB.init({
                        appId      : '" . $this->fbEventsAppId . "',
                        xfbml      : true,
                        version    : 'v3.1'
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
                */

                // WHICH EVENTS TO DISPLAY?
                // evaluation of event type select field
                if ($this->fbEventsType === "all")
                {
                    // ALL EVENTS (FUTURE + PAST)
                    $this->sinceDate = date('Y-01-01', strtotime('-' . $this->fbEventsYearRange . ' years'));
                    $this->untilDate = date('Y-01-01', strtotime('+' . $this->fbEventsYearRange . ' years'));
                }
                elseif ($this->fbEventsType == "future")
                {
                    // UPCOMING EVENTS
                    $this->sinceDate = date('Y-m-d');
                    $this->untilDate = date('Y-12-31', strtotime('+' . $this->fbEventsYearRange . ' years'));
                }
                elseif ($this->fbEventsType === "past")
                {
                    // PAST EVENTS
                    $this->sinceDate = date('Y-01-01', strtotime('-' . $this->fbEventsYearRange . ' years'));
                    $this->untilDate = date('Y-m-d');
                }
                else
                {   // IF NOT SET - use default:
                    // UPCOMING EVENTS
                    $this->sinceDate = date('Y-m-d');
                    $this->untilDate = date('Y-12-31', strtotime('+' . $this->fbEventsYearRange . ' years'));
                }

                // IF START + END DATE IS SET
                if (isset($this->fbEventsStartDate) && (!empty($this->fbEventsStartDate))
                    && (isset($this->fbEventsEndDate) && (!empty($this->fbEventsEndDate))))
                {
                    $this->sinceDate = date($this->fbEventsStartDate);
                    $this->untilDate = date($this->fbEventsEndDate);
                }

                // unix timestamp years
                $since_unix_timestamp = strtotime($this->sinceDate);
                $until_unix_timestamp = strtotime($this->untilDate);

                // prepare fields
                // $this->fields="id,name,description,place,start_time,cover,maybe_count,attending_count,is_canceled";

                // prepare API call
                // $json_link = "https://graph.facebook.com/v3.1/{$this->fbEventsPageId}/events/attending/?fields={$this->fields}&access_token={$this->fbEventsAccessToken}&since={$since_unix_timestamp}&until={$until_unix_timestamp}";
                // $json_link = "https://graph.facebook.com/v2.7/{$this->fbEventsPageId}/events/attending/?fields={$this->fields}&access_token={$this->fbEventsAccessToken}&since={$since_unix_timestamp}&until={$until_unix_timestamp}";
                // $json_link = "https://graph.facebook.com/v3.1/me/events/?fields={$this->fields}&access_token={$this->fbEventsAccessToken}&since={$since_unix_timestamp}&until={$until_unix_timestamp}";
                // $json_link = "https://graph.facebook.com/v3.3/me/events/?fields={$this->fields}&access_token={$this->fbEventsAccessToken}&since={$since_unix_timestamp}&until={$until_unix_timestamp}";

                // $json_link = "https://graph.facebook.com/v14.0/me/events?access_token={$this->fbEventsAccessToken}&fields={$this->fields}&created_time={$since_unix_timestamp}";
                $json_link = "https://graph.facebook.com/v14.0/me/events?access_token={$this->fbEventsAccessToken}&fields={$this->fields}&created_time={$this->since_unix_timestamp}";
                // get json string
                // $json = file_get_contents($json_link);
                // convert json to object
                // $obj = json_decode($json, true, 512, JSON_BIGINT_AS_STRING);

                $curl = curl_init();
                curl_setopt($curl, CURLOPT_URL, $json_link);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
                // decode json and create object
                $obj = json_decode(curl_exec($curl), true, 512, JSON_BIGINT_AS_STRING);
                curl_close($curl);

                /*
                echo "<pre>";
                print_r($this);
                echo "<hr>";
                print_r($obj);
                echo "</pre>";
                exit;
                */

                // if object is set, but array got not data...
                if (isset($obj) && (is_array($obj) && (is_array($obj['data']) && (empty($obj['data'])))))
                {   // no upcoming data found
                    if (isset($this->fbEventsType) && (!empty($this->fbEventsType) && $this->fbEventsType == "future"))
                    {
                        // echo "Sorry, no upcoming events were found.";
                        $this->errorMsg = "Im Moment sind keine Termine geplant.";
                    }
                    // no past data found
                    else if (isset($this->fbEventsType) && (!empty($this->fbEventsType) && $this->fbEventsType == "past"))
                    {
                        // echo "Sorry, no past events were found.";
                        $this->errorMsg = "Sorry, es wurden keine vergangenen Konzerte gefunden.";
                    }
                    else
                    {   // in any other empty array case
                        // echo "Sorry, no events were found.";
                        $this->errorMsg = "Im Moment gibt es keine Termine.";
                    }
                }

                // sort data
                if ($this->fbEventsSortation === "asc")
                {   // reverse array data to display upcoming event first
                    $obj['data'] = array_reverse($obj['data']);
                }

                // CHECK, if a limit should be set
                if (isset($this->fbEventsLimit) && (!empty($this->fbEventsLimit)))
                {
                    $obj['data'] = array_slice($obj['data'], 0 -$this->fbEventsLimit);
                }

                // $i will be used for counting elements and to help animate content
                $i = 0;

                /* HEADING */
                // if a heading is set and not empty
                if (isset($this->fbEventsHeading) && (!empty($this->fbEventsHeading)))
                {   // add a h1 tag to heading string
                    $this->fbEventsHeading = "$this->fbEventsHeading";

                    // if subtext is set, add <small> subtext to string
                    if (isset($this->fbEventsSubtext) && (!empty($this->fbEventsSubtext)))
                    {   // build a headline with heading and subtext
                        $this->fbEventsSubtext = "<small>$this->fbEventsSubtext</small>";
                        $this->headline = "<h1>$this->fbEventsHeading&nbsp;"."$this->fbEventsSubtext</h1>";
                    }
                    else
                    {   // build just a headline - without subtext
                        $this->headline = "<h1>$this->fbEventsHeading</h1>";    // draw just the heading
                    }
                }
                else
                {   // leave empty if it's not set
                    $this->headline = '';
                }

                // check, if there are any errors
                if (isset($this->errorMsg) && (!empty($this->errorMsg)))
                {
                    // OUTPUT ERROR MSG (workaround)
                    // echo "<br>".$this->errorMsg;
                }
                else
                {
                    // OUTPUT HEADING (title)
                    echo $this->headline;
                }


                // DATA PROCESSING START HERE
                // walk through object data
                foreach ($obj['data'] as $this->data => $this->event)
                {
                    // the event date as obj
                    $this->eventDate = new \DateTime($this->event['start_time']);
                    // the event date formatted as pretty date
                    $this->prettyDate = $this->eventDate->format('d.m.Y H:i');
                    // current time as obj
                    $now = new \DateTime();

                    // difference (object) between now and event date
                    $until = $now->diff($this->eventDate, true);

                    // the event date as string in format:
                    $eventDateSimple = $this->eventDate->format('Y-m-d');
                    // current date as string in format:
                    $currentDateSimple = $now->format('Y-m-d');

                    // some german stuff
                    if ($this->eventDate > $now)
                    {   // future prepend text
                        $prepend = "in";
                    }
                    else
                    {   // past prepend text
                        $prepend = "vor";
                    }

                    // calculate how many days, weeks, months or years the event is away
                    // MONTHS: time between more than one month and under one year
                    if ($until->days >= 31 && ($until->days < 365))
                    {   // less than two months
                        if ($until->m < 2)
                        {   // singular
                            $duration = "Monat";
                        }
                        else
                        {   // plural
                            $duration = "Monaten";
                        }
                        // set wordy date string
                        $this->dateString = "$prepend $until->m $duration";
                    }
                    // not within a year
                    else if ($until->days >= 365)
                    {   // less than two years
                        if ($until->y < 2)
                        {   // singular
                            $duration = "Jahr";
                        }
                        else
                        {   // plural
                            $duration = "Jahren";
                        }
                        // set wordy date string
                        $this->dateString = "$prepend $until->y $duration";
                    }

                    // split month into smaller bits
                    else if ($until->days === 14)
                    {
                        if ($this->eventDate > $now)
                        {
                            // in exactly two weeks
                            $this->dateString = "in zwei Wochen";
                        }
                        else
                        {
                            // two weeks ago
                            $this->dateString = "vor zwei Wochen";
                        }
                    }
                    else if ($until->days >= 8 && ($until->days <= 13))
                    {   if ($this->eventDate > $now)
                    {
                        // nearly two weeks
                        $this->dateString = "in knapp zwei Wochen";
                    }
                    else
                    {
                        // nearly two weeks ago
                        $this->dateString = "vor knapp zwei Wochen";
                    }
                    }
                    else if ($until->days === 7)
                    {   if ($this->eventDate > $now)
                    {
                        // in exactly one week
                        $this->dateString = "in einer Woche";
                    }
                    else
                    {
                        // exactly one week ago
                        $this->dateString = "vor einer Woche";
                    }
                    }
                    else if ($until->days === 2)
                    {
                        if ($this->eventDate > $now)
                        {
                            // in two days
                            $this->dateString = "&uuml;bermorgen";
                        }
                        else
                        {
                            // two days ago
                            $this->dateString = "vorgestern";
                        }
                    }
                    else if ($until->days === 1)
                    {
                        if ($this->eventDate > $now)
                        {
                            // tomorrow
                            $this->dateString = "<span class=\"".$this->fbEventsDatewordCss."\">morgen</span>";
                        }
                        else
                        {
                            // yesterday
                            $this->dateString = "<span class=\"".$this->fbEventsDatewordCss."\">gestern</span>";
                        }
                    }
                    // 0 days remaining, eventDate and currentDate are the same -
                    else if ($eventDateSimple == $currentDateSimple)
                    {   // it must be today
                        $this->dateString = "<span class=\"".$this->fbEventsDatewordCss."\">HEUTE !</span>";
                    }
                    else
                    {   if ($this->eventDate > $now)
                    {
                        // any other amount of days
                        $this->dateString = "$prepend $until->d Tagen";
                    }
                    else
                    {
                        // must be yesterday
                        if ($until->d === 0 && ($until->m === 0))
                        {
                            $this->dateString = "gestern";
                        }
                        else
                        {   // x days ago
                            // less than two months
                            if ($until->m < 2)
                            {   // singular
                                $duration = "Monat";
                            }
                            else
                            {   // plural
                                $duration = "Monaten";
                            }
                            if ($until->m >= 1)
                            {
                                $this->dateString = "$prepend $until->m $duration";
                            }
                            else
                            {
                                $this->dateString = "$prepend $until->d Tagen";
                            }
                        }
                    }
                    }

                    // check if event is canceled
                    if (isset($this->fbEventsCanceledOn) && ($this->fbEventsCanceledOn == true))
                    {
                        if (isset($this->event['is_canceled']) && $this->event['is_canceled'] === true)
                        {   // set markup for canceled events
                            $canceled = "<span class=\"".$this->fbEventsFontCanceledCss."\">ACHTUNG! ABGESAGT!</span><br>";
                            $delStart = "<del>";
                            $delEnd = "</del>";
                        }
                        else
                        {   // event is not canceled - no markup needed
                            $canceled = '';
                            $delStart = '';
                            $delEnd = '';
                        }
                    }
                    else
                    {   // event is not canceled - no markup needed
                        $canceled = '';
                        $delStart = '';
                        $delEnd = '';
                    }

                    // check if people counter is enabled or disabled
                    if (isset($this->fbEventsShowCounter) && ($this->fbEventsShowCounter == "true"))
                    {   // do it only, if maybe_count and attending_count are set and valid
                        if (isset($this->event['maybe_count']) && (!empty($this->event['maybe_count']))
                            && (isset($this->event['attending_count'])))
                        {   // add maybe people and attending people to get a more attractive number
                            $this->iPeopleCount = $this->event['maybe_count'] + $this->event['attending_count'];
                        }
                        // if there are more than 0 people interested
                        if (isset($this->iPeopleCount) && ($this->iPeopleCount != 0))
                        {   // generate string that will be displayed in the frontend
                            if ($this->eventDate > $now)
                            {   // future events
                                $this->showPeople = "<br><br><i class=\"$this->fbEventsFontPeopleCss\">" . $this->iPeopleCount . " Personen sind daran interessiert oder werden dieses Konzert besuchen.</i>";
                            }
                            else
                            {   // past events
                                $this->showPeople = "<br><br><i class=\"$this->fbEventsFontPeopleCss\">" . $this->iPeopleCount . " Personen waren daran interessiert oder haben dieses Konzert besucht.</i>";
                            }
                        }
                        else
                        {   // no people are interested or attending, leave string empty
                            $this->showPeople = '';
                        }
                    }
                    else
                    {   // people counter is disabled, leave string empty
                        $this->showPeople = '';
                    }

                    /** FONT EVENT NAME SETTINGS */
                    if (isset($this->fbEventsFontEventName) && (!empty($this->fbEventsFontEventName)))
                    {
                        $smallTagStart = '';
                        $smallTagEnd = '';

                        if ($this->fbEventsFontEventName == "H1 SMALL")
                        {
                            $this->fontEventNameH = "H1";
                            $smallTagStart = "<small>";
                            $smallTagEnd = "</small>";
                        }
                        else if ($this->fbEventsFontEventName == "H2 SMALL")
                        {
                            $this->fontEventNameH = "H2";
                            $smallTagStart = "<small>";
                            $smallTagEnd = "</small>";
                        }
                        else if ($this->fbEventsFontEventName == "H3 SMALL")
                        {
                            $this->fontEventNameH = "H3";
                            $smallTagStart = "<small>";
                            $smallTagEnd = "</small>";
                        }
                        else if ($this->fbEventsFontEventName == "H4 SMALL")
                        {
                            $this->fontEventNameH = "H4";
                            $smallTagStart = "<small>";
                            $smallTagEnd = "</small>";
                        }
                        else if ($this->fbEventsFontEventName == "H5 SMALL")
                        {
                            $this->fontEventNameH = "H5";
                            $smallTagStart = "<small>";
                            $smallTagEnd = "</small>";
                        }
                        else if ($this->fbEventsFontEventName == "H6 SMALL")
                        {
                            $this->fontEventNameH = "H6";
                            $smallTagStart = "<small>";
                            $smallTagEnd = "</small>";
                        }
                        else
                        {
                            $this->fontEventNameH = $this->fbEventsFontEventName;
                        }

                        if (isset($this->fbEventsFontEventNameCss) && (!empty($this->fbEventsFontEventNameCss)))
                        {
                            $fontTitleCss = " class=\"".$this->fbEventsFontEventNameCss."\"";
                        }
                        else
                        {
                            $fontTitleCss = '';
                        }
                        // check if facebook link is enabled
                        if (isset($this->fbEventsFbLink) && ($this->fbEventsFbLink === "true"))
                        {   // facebook link
                            $fbLinkStart = "<a href=\"https://www.facebook.com/events/".$this->event['id']."\" title=\"auf Facebook &ouml;ffnen: ".$this->event['name']."\" target=\"_blank\">";
                            $fbLinkEnd = "</a>";
                        }
                        else
                        {   // facebook link disabled
                            $fbLinkStart = '';
                            $fbLinkEnd = '';
                        }
                        $fontTitleStart = "".$fbLinkStart."<".$this->fontEventNameH."".$fontTitleCss.">".$smallTagStart."";
                        $fontTitleEnd = "".$smallTagEnd."</".$this->fontEventNameH.">".$fbLinkEnd."";
                    }
                    else
                    {
                        $fontTitleStart = "<h4>";
                        $fontTitleEnd = "</h4>";
                    }

                    /** FONT EVENT DATE SETTINGS  */
                    if (isset($this->fbEventsFontDate) && (!empty($this->fbEventsFontDate)))
                    {
                        $smallTagStartDate = '';
                        $smallTagEndDate = '';

                        if ($this->fbEventsFontDate == "H1 SMALL")
                        {
                            $this->fontEventDateH = "H1";
                            $smallTagStartDate = "<small>";
                            $smallTagEndDate = "</small>";
                        }
                        else if ($this->fbEventsFontDate == "H2 SMALL")
                        {
                            $this->fontEventDateH = "H2";
                            $smallTagStartDate = "<small>";
                            $smallTagEndDate = "</small>";
                        }
                        else if ($this->fbEventsFontDate == "H3 SMALL")
                        {
                            $this->fontEventDateH = "H3";
                            $smallTagStartDate = "<small>";
                            $smallTagEndDate = "</small>";
                        }
                        else if ($this->fbEventsFontDate == "H4 SMALL")
                        {
                            $this->fontEventDateH = "H4";
                            $smallTagStartDate = "<small>";
                            $smallTagEndDate = "</small>";
                        }
                        else if ($this->fbEventsFontDate == "H5 SMALL")
                        {
                            $this->fontEventDateH = "H5";
                            $smallTagStartDate = "<small>";
                            $smallTagEndDate = "</small>";
                        }
                        else if ($this->fbEventsFontDate == "H6 SMALL")
                        {
                            $this->fontEventDateH = "H6";
                            $smallTagStartDate = "<small>";
                            $smallTagEndDate = "</small>";
                        }
                        else
                        {
                            $this->fontEventDateH = $this->fbEventsFontDate;
                        }

                        if (isset($this->fbEventsFontDateCss) && (!empty($this->fbEventsFontDateCss)))
                        {
                            $fontDateCss = " class=\"".$this->fbEventsFontDateCss."\"";
                        }
                        else
                        {
                            $fontDateCss = '';
                        }
                        $fontDateStart = "<".$this->fontEventDateH."".$fontDateCss.">".$smallTagStartDate."";
                        $fontDateEnd = "".$smallTagEndDate."</".$this->fontEventDateH.">";
                    }
                    else
                    {
                        $fontDateStart = "<h4><small>";
                        $fontDateEnd = "</h4></small>";
                    }

                    /** FONT EVENT DATEWORD SETTINGS  */
                    if (isset($this->fbEventsFontDateword) && (!empty($this->fbEventsFontDateword)))
                    {

                        if ($this->fbEventsFontDateword == "true")
                        {
                            $smallTagStartDateword = "<small>";
                            $smallTagEndDateword = "</small>";
                        }
                        else
                        {
                            $smallTagStartDateword = "";
                            $smallTagEndDateword = "";
                        }

                        if (isset($this->fbEventsDatewordCss) && (!empty($this->fbEventsDatewordCss)))
                        {
                            $fontDatewordCssStart = "<span class=\"".$this->fbEventsDatewordCss."\">";
                            $fontDatewordCssEnd = "</span>";
                        }
                        else
                        {
                            $fontDatewordCssStart = '';
                            $fontDatewordCssEnd = '';
                        }
                        $fontDatewordStart = "$smallTagStartDateword".$fontDatewordCssStart."";
                        $fontDatewordEnd = "$fontDatewordCssEnd".$smallTagEndDateword."";
                    }
                    else
                    {
                        $fontDatewordStart = "<small>";
                        $fontDatewordEnd = "</small>";
                    }


                    /** FONT EVENT Location SETTINGS  */
                    if (isset($this->fbEventsFontLocation) && (!empty($this->fbEventsFontLocation)))
                    {
                        $smallTagStartLocation = '';
                        $smallTagEndLocation = '';

                        if ($this->fbEventsFontLocation == "H1 SMALL")
                        {
                            $this->fontEventLocationH = "H1";
                            $smallTagStartLocation = "<small>";
                            $smallTagEndLocation = "</small>";
                        }
                        else if ($this->fbEventsFontLocation == "H2 SMALL")
                        {
                            $this->fontEventLocationH = "H2";
                            $smallTagStartLocation = "<small>";
                            $smallTagEndLocation = "</small>";
                        }
                        else if ($this->fbEventsFontLocation == "H3 SMALL")
                        {
                            $this->fontEventLocationH = "H3";
                            $smallTagStartLocation = "<small>";
                            $smallTagEndLocation = "</small>";
                        }
                        else if ($this->fbEventsFontLocation == "H4 SMALL")
                        {
                            $this->fontEventLocationH = "H4";
                            $smallTagStartLocation = "<small>";
                            $smallTagEndLocation = "</small>";
                        }
                        else if ($this->fbEventsFontLocation == "H5 SMALL")
                        {
                            $this->fontEventLocationH = "H5";
                            $smallTagStartLocation = "<small>";
                            $smallTagEndLocation = "</small>";
                        }
                        else if ($this->fbEventsFontLocation == "H6 SMALL")
                        {
                            $this->fontEventLocationH = "H6";
                            $smallTagStartLocation = "<small>";
                            $smallTagEndLocation = "</small>";
                        }
                        else
                        {
                            $this->fontEventLocationH = $this->fbEventsFontLocation;
                        }

                        if (isset($this->fbEventsFontLocationCss) && (!empty($this->fbEventsFontLocationCss)))
                        {
                            $fontLocationCss = " class=\"".$this->fbEventsFontLocationCss."\"";
                        }
                        else
                        {
                            $fontLocationCss = '';
                        }
                        $fontLocationStart = "<".$this->fontEventLocationH."".$fontLocationCss.">".$smallTagStartLocation."";
                        $fontLocationEnd = "".$smallTagEndLocation."</".$this->fontEventLocationH.">";
                    }
                    else
                    {
                        $fontLocationStart = "<h4><small>";
                        $fontLocationEnd = "</h4></small>";
                    }


                    /** FONT EVENT Address SETTINGS  */
                    if (isset($this->fbEventsFontAddress) && (!empty($this->fbEventsFontAddress)))
                    {
                        $smallTagStartAddress = '';
                        $smallTagEndAddress = '';

                        if ($this->fbEventsFontAddress == "H1 SMALL")
                        {
                            $this->fontEventAddressH = "H1";
                            $smallTagStartAddress = "<small>";
                            $smallTagEndAddress = "</small>";
                        }
                        else if ($this->fbEventsFontAddress == "H2 SMALL")
                        {
                            $this->fontEventAddressH = "H2";
                            $smallTagStartAddress = "<small>";
                            $smallTagEndAddress = "</small>";
                        }
                        else if ($this->fbEventsFontAddress == "H3 SMALL")
                        {
                            $this->fontEventAddressH = "H3";
                            $smallTagStartAddress = "<small>";
                            $smallTagEndAddress = "</small>";
                        }
                        else if ($this->fbEventsFontAddress == "H4 SMALL")
                        {
                            $this->fontEventAddressH = "H4";
                            $smallTagStartAddress = "<small>";
                            $smallTagEndAddress = "</small>";
                        }
                        else if ($this->fbEventsFontAddress == "H5 SMALL")
                        {
                            $this->fontEventAddressH = "H5";
                            $smallTagStartAddress = "<small>";
                            $smallTagEndAddress = "</small>";
                        }
                        else if ($this->fbEventsFontAddress == "H6 SMALL")
                        {
                            $this->fontEventAddressH = "H6";
                            $smallTagStartAddress = "<small>";
                            $smallTagEndAddress = "</small>";
                        }
                        else
                        {
                            $this->fontEventAddressH = $this->fbEventsFontAddress;
                        }

                        if (isset($this->fbEventsFontAddressCss) && (!empty($this->fbEventsFontAddressCss)))
                        {
                            $fontAddressCss = " class=\"".$this->fbEventsFontAddressCss."\"";
                        }
                        else
                        {
                            $fontAddressCss = '';
                        }
                        $fontAddressStart = "<".$this->fontEventAddressH."".$fontAddressCss.">".$smallTagStartAddress."";
                        $fontAddressEnd = "".$smallTagEndAddress."</".$this->fontEventAddressH.">";
                    }
                    else
                    {
                        $fontAddressStart = "";
                        $fontAddressEnd = "";
                    }


                    /** FONT EVENT Description SETTINGS  */
                    if (isset($this->fbEventsFontDescription) && (!empty($this->fbEventsFontDescription)))
                    {
                        $smallTagStartDescription = '';
                        $smallTagEndDescription = '';

                        if ($this->fbEventsFontDescription == "H1 SMALL")
                        {
                            $this->fontEventDescriptionH = "H1";
                            $smallTagStartDescription = "<small>";
                            $smallTagEndDescription = "</small>";
                        }
                        else if ($this->fbEventsFontDescription == "H2 SMALL")
                        {
                            $this->fontEventDescriptionH = "H2";
                            $smallTagStartDescription = "<small>";
                            $smallTagEndDescription = "</small>";
                        }
                        else if ($this->fbEventsFontDescription == "H3 SMALL")
                        {
                            $this->fontEventDescriptionH = "H3";
                            $smallTagStartDescription = "<small>";
                            $smallTagEndDescription = "</small>";
                        }
                        else if ($this->fbEventsFontDescription == "H4 SMALL")
                        {
                            $this->fontEventDescriptionH = "H4";
                            $smallTagStartDescription = "<small>";
                            $smallTagEndDescription = "</small>";
                        }
                        else if ($this->fbEventsFontDescription == "H5 SMALL")
                        {
                            $this->fontEventDescriptionH = "H5";
                            $smallTagStartDescription = "<small>";
                            $smallTagEndDescription = "</small>";
                        }
                        else if ($this->fbEventsFontDescription == "H6 SMALL")
                        {
                            $this->fontEventDescriptionH = "H6";
                            $smallTagStartDescription = "<small>";
                            $smallTagEndDescription = "</small>";
                        }
                        else
                        {
                            $this->fontEventDescriptionH = $this->fbEventsFontDescription;
                        }

                        if (isset($this->fbEventsFontDescriptionCss) && (!empty($this->fbEventsFontDescriptionCss)))
                        {
                            $fontDescriptionCss = " class=\"".$this->fbEventsFontDescriptionCss."\"";
                        }
                        else
                        {
                            $fontDescriptionCss = '';
                        }
                        $fontDescriptionStart = "<".$this->fontEventDescriptionH."".$fontDescriptionCss.">".$smallTagStartDescription."";
                        $fontDescriptionEnd = "".$smallTagEndDescription."</".$this->fontEventDescriptionH.">";
                    }
                    else
                    {
                        $fontDescriptionStart = "";
                        $fontDescriptionEnd = "";
                    }


                    /** FONT EVENT People SETTINGS  */
                    if (isset($this->fbEventsFontPeople) && (!empty($this->fbEventsFontPeople)))
                    {
                        $smallTagStartPeople = '';
                        $smallTagEndPeople = '';

                        if ($this->fbEventsFontPeople == "H1 SMALL")
                        {
                            $this->fontEventPeopleH = "H1";
                            $smallTagStartPeople = "<small>";
                            $smallTagEndPeople = "</small>";
                        }
                        else if ($this->fbEventsFontPeople == "H2 SMALL")
                        {
                            $this->fontEventPeopleH = "H2";
                            $smallTagStartPeople = "<small>";
                            $smallTagEndPeople = "</small>";
                        }
                        else if ($this->fbEventsFontPeople == "H3 SMALL")
                        {
                            $this->fontEventPeopleH = "H3";
                            $smallTagStartPeople = "<small>";
                            $smallTagEndPeople = "</small>";
                        }
                        else if ($this->fbEventsFontPeople == "H4 SMALL")
                        {
                            $this->fontEventPeopleH = "H4";
                            $smallTagStartPeople = "<small>";
                            $smallTagEndPeople = "</small>";
                        }
                        else if ($this->fbEventsFontPeople == "H5 SMALL")
                        {
                            $this->fontEventPeopleH = "H5";
                            $smallTagStartPeople = "<small>";
                            $smallTagEndPeople = "</small>";
                        }
                        else if ($this->fbEventsFontPeople == "H6 SMALL")
                        {
                            $this->fontEventPeopleH = "H6";
                            $smallTagStartPeople = "<small>";
                            $smallTagEndPeople = "</small>";
                        }
                        else if ($this->fbEventsFontPeople == "globaltext small")
                        {
                            $this->fontEventPeopleH = "span";
                            $smallTagStartPeople = "<small>";
                            $smallTagEndPeople = "</small>";
                        }
                        else
                        {
                            $this->fontEventPeopleH = $this->fbEventsFontPeople;
                        }

                        if (isset($this->fbEventsFontPeopleCss) && (!empty($this->fbEventsFontPeopleCss)))
                        {
                            $fontPeopleCss = " class=\"".$this->fbEventsFontPeopleCss."\"";
                        }
                        else
                        {
                            $fontPeopleCss = '';
                        }
                        $fontPeopleStart = "<".$this->fontEventPeopleH."".$fontPeopleCss.">".$smallTagStartPeople."";
                        $fontPeopleEnd = "".$smallTagEndPeople."</".$this->fontEventPeopleH.">";
                    }
                    else
                    {
                        $fontPeopleStart = "<span class=\"text-muted\">";
                        $fontPeopleEnd = "</span>";
                    }


                    // is cover image enabled by widget settings?
                    if (isset($this->fbEventsShowCover) && ($this->fbEventsShowCover == "true"))
                    {   // if cover image source is set
                        if (isset($this->event['cover']['source']) && (!empty($this->event['cover']['source'])))
                        {
                            // img html markup
                            // check if custom cover class is set
                            if (isset($this->fbEventsCoverClass) && (!empty($this->fbEventsCoverClass)))
                            {   // yep, display it with custom class
                                // check if facebook link is enabled

                                // check if facebook link is enabled
                                if (isset($this->fbEventsFbLink) && ($this->fbEventsFbLink === "true"))
                                {   // facebook link
                                    $fbLinkStart = "<a href=\"https://www.facebook.com/events/".$this->event['id']."\" title=\"auf Facebook &ouml;ffnen: ".$this->event['name']."\" target=\"_blank\">";
                                    $fbLinkEnd = "</a>";
                                }
                                else
                                {   // facebook link disabled
                                    $fbLinkStart = '';
                                    $fbLinkEnd = '';
                                }
                                $coverImage = "<br>".$fbLinkStart."<img src=\"" . $this->event['cover']['source'] . "\" title=\"" . $this->event['name'] . "\" class=\"img-center ".$this->fbEventsCoverClass."\">".$fbLinkEnd."";
                            }
                            else
                            {   // default: img-thumbnail responsive
                                $coverImage = "<br><img src=\"" . $this->event['cover']['source'] . "\" title=\"" . $this->event['name'] . "\" class=\"img-thumbnail img-fluid\">";
                            }
                        }
                        else
                        {   // no image - no source, leave empty
                            $coverImage = '';
                        }
                    }
                    else
                    {   // cover image disabled by widget settings, leave empty
                        $coverImage = '';
                    }

                    if ($i < 1)
                    {
                        $animate = " animated fadeIn";
                    }
                    else
                    {
                        $animate = " animate";
                    }

                    // check address street var
                    if (isset($this->event['place']['location']['street']) && (!empty($this->event['place']['location']['street'])))
                    {
                        $this->address = $this->event['place']['location']['street'].", ";
                    }
                    else
                    {
                        $this->address = '';
                    }
                    // check address zip var
                    if (isset($this->event['place']['location']['zip']) && (!empty($this->event['place']['location']['zip'])))
                    {
                        $this->address .= $this->event['place']['location']['zip'].", ";
                    }
                    else
                    {
                        $this->address = '';
                    }
                    // check address city var
                    if (isset($this->event['place']['location']['city']) && (!empty($this->event['place']['location']['city'])))
                    {
                        $this->address .= $this->event['place']['location']['city'].", ";
                    }
                    else
                    {
                        $this->address = '';
                    }
                    // check address country var
                    if (isset($this->event['place']['location']['country']) && (!empty($this->event['place']['location']['country'])))
                    {
                        $this->address .= $this->event['place']['location']['country'];
                    }
                    else
                    {
                        $this->address = '';
                    }

                    // check google map setting
                    //$latitude = $this->event['place']['location']['latitute'];
                    //$longitude = $this->event['place']['location']['longitute'];
                    if (isset($this->fbEventsGoogleMap) && ($this->fbEventsGoogleMap == "true"))
                    {
                        $googleMapMarkup = "<a class=\"hvr-grow\" target=\"_blank\" title=\"auf Google Maps ansehen\" href=\"http://maps.google.de/maps/dir/".$this->event['place']['location']['latitude'].",".$this->event['place']['location']['longitude']."\"><i class=\"fa fa-map-marker\"></i></a>";
                        $address = $this->address;
                        $this->address = "".$address."&nbsp;&nbsp;".$googleMapMarkup."";
                    }

                    // check if hr class is set
                    if (isset($this->fbEventsHrClass) && (!empty($this->fbEventsHrClass)))
                    {
                        $hrClass = " class=\"".$this->fbEventsHrClass."".$animate."\"";
                    }
                    else
                    {
                        $hrClass = '';
                    }

                    // search for links in event description and set html markup to link them
                    if (isset($this->event['description']) && (!empty($this->event['description'])))
                    {
                        // regex filter
                        $reg_exUrl = "/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/";

                        // check if there is a URL in the string
                        if(preg_match($reg_exUrl, $this->event['description'], $url))
                        {
                            // change urls to true hyperlinks
                            $this->event['description'] = preg_replace($reg_exUrl, '<a href="'.$url[0].'" target="_blank">'.$url[0].'</a> ', $this->event['description']);
                        }
                    }

                    if (isset($this->fbEventsCanceledOn) && ($this->fbEventsCanceledOn == true))
                    {

                        /* LAYOUTS */
                        // All Events will be displayed within one of the following layouts:

                        // MINIMAL
                        if (isset($this->fbEventsLayout) && ($this->fbEventsLayout == "minimal"))
                        {
                            echo "<div class=\"container-fluid\">";
                            echo "<div class=\"row".$animate."\">";
                            echo "<div class=\"col-md-12\">";
                            echo "".$fontTitleStart."".$canceled."".$delStart."".$this->event['name']."".$fontTitleEnd."";
                            echo "".$fontDateStart."".$delStart."".$this->prettyDate." Uhr ".$fontDatewordStart."(".$this->dateString.")".$fontDatewordEnd."".$delEnd."".$fontDateEnd."<br>";
                            echo "".$delStart."".$fontLocationStart."".$this->event['place']['name']."".$fontLocationEnd."<br>".$fontAddressStart."".$this->address."".$fontAddressEnd."".$delEnd."";
                            echo "".$fontPeopleStart."".$this->showPeople."".$fontPeopleEnd."";
                            echo "</div></div></div><br><br><br><br><br>";
                            $i++;
                        }

                        // TABLE
                        // draw events within a classical table view
                        if (isset($this->fbEventsLayout) && ($this->fbEventsLayout == "table"))
                        {   // if cover should be displayed
                            if (isset($this->fbEventsShowCover) && ($this->fbEventsShowCover === "true"))
                            {   // if cover source is found (if event got a picture)
                                if (isset($this->event['cover']['source']))
                                {   // display facebook event picture
                                    $coverImage = " style=\"background-image:url(".$this->event['cover']['source'].");background-repeat:no-repeat;background-size:250px; width: 250px; height: 180px;\"";
                                }
                                else
                                {   // no source found, leave empty
                                    $coverImage = '';
                                }
                            }
                            else
                            {   // cover image set to false - do not show cover image
                                $coverImage = '';
                            }
                            echo "<div class=\"container-fluid\" style=\"background-color:#".$this->fbEventsBgColor."; color:#".$this->fbEventsTextColor.";\">";
                            echo "<table border=\"1\" cellpadding=\"1\" cellspacing=\"1\" class=\"table table-responsive".$animate."\">";
                            echo "<tr>";
                            echo "<td width=\"14%\"".$coverImage.">";
                            echo "</td>";
                            echo "<td>";
                            echo "".$fontTitleStart."".$canceled."".$delStart."" . $this->event['name'] . "</b><br>" . $this->event['place']['name'] . "<br><small>" . $this->prettyDate . " Uhr <small>(" . $this->dateString . ")</small></small><br><small>(" . $this->event['place']['location']['street'] . ", " . $this->event['place']['location']['zip'] . " " . $this->event['place']['location']['city'] . ", " . $this->event['place']['location']['country'] . ")</small>".$fontTitleEnd."" . $delEnd . "<br>".$this->event['description']."";
                            echo "</td>";
                            echo "</tr>";
                            echo "</table>";
                            echo "</div>";
                            $i++;
                        }

                        if (isset($this->fbEventsLayout) && ($this->fbEventsLayout == "left"))
                        {
                            // jumbotron output
                            echo "<div class=\"jumbotron".$animate."\" style=\"background-color:#".$this->fbEventsBgColor."; color:#".$this->fbEventsTextColor.";\">";
                            echo "<div class=\"row\">";
                            echo "<div class=\"col-md-4 text-center align-middle\">";
                            echo "".$coverImage."";
                            echo "<br></div>";
                            echo "<div class=\"col-md-8\">";
                            echo "".$fontTitleStart."".$canceled."".$delStart."".$this->event['name']."".$fontTitleEnd."";
                            echo "".$fontDateStart."".$delStart."".$this->prettyDate." Uhr ".$fontDatewordStart."(".$this->dateString.")".$fontDatewordEnd."".$delEnd."".$fontDateEnd."<br>";
                            echo "".$delStart."".$fontLocationStart."".$this->event['place']['name']."".$fontLocationEnd."<br>".$fontAddressStart."".$this->address."".$fontAddressEnd."".$delEnd."<hr".$hrClass.">";
                            echo "".$fontDescriptionStart."".$this->event['description']."".$fontDescriptionEnd."";
                            echo "".$fontPeopleStart."".$this->showPeople."".$fontPeopleEnd."";
                            echo "</div>";
                            echo "</div>";
                            echo "</div><br><br><br>";
                            $i++;
                        }

                        if (isset($this->fbEventsLayout) && ($this->fbEventsLayout == "top"))
                        {
                            // jumbotron output
                            echo "<div class=\"jumbotron".$animate."\" style=\"background-color:#".$this->fbEventsBgColor."; color:#".$this->fbEventsTextColor.";\">";
                            echo "<div class=\"row\">";
                            echo "<div class=\"col-md-12 text-center align-middle\">";
                            echo "".$coverImage."<br>";
                            echo "".$fontTitleStart."".$canceled."".$delStart."".$this->event['name']."".$fontTitleEnd."";
                            echo "".$fontDateStart."".$delStart."".$this->prettyDate." Uhr ".$fontDatewordStart."(".$this->dateString.")".$fontDatewordEnd."".$delEnd."".$fontDateEnd."<br>";
                            echo "".$delStart."".$fontLocationStart."".$this->event['place']['name']."".$fontLocationEnd."<br>".$fontAddressStart."".$this->address."".$fontAddressEnd."".$delEnd."<hr".$hrClass.">";
                            echo "".$fontDescriptionStart."".$this->event['description']."".$fontDescriptionEnd."";
                            echo "".$fontPeopleStart."".$this->showPeople."".$fontPeopleEnd."";
                            echo "</div>";
                            echo "</div>";
                            echo "</div><br><br><br>";
                            $i++;
                        }


                        if (isset($this->fbEventsLayout) && ($this->fbEventsLayout == "middle"))
                        {
                            // jumbotron output
                            echo "<div class=\"container-fluid\">";
                            echo "<div class=\"".$animate."\" style=\"background-color:#".$this->fbEventsBgColor."; color:#".$this->fbEventsTextColor.";\">";
                            echo "<div class=\"row\">";
                            echo "<div class=\"col-md-12 text-center align-middle\"><br>";
                            echo "".$fontTitleStart."".$canceled."".$delStart."".$this->event['name']."".$fontTitleEnd."";
                            echo "".$coverImage."<br>";
                            echo "".$fontDateStart."".$delStart."".$this->prettyDate." Uhr ".$fontDatewordStart."(".$this->dateString.")".$fontDatewordEnd."".$delEnd."".$fontDateEnd."<br>";
                            echo "".$delStart."".$fontLocationStart."".$this->event['place']['name']."".$fontLocationEnd."<br>".$fontAddressStart."".$this->address."".$fontAddressEnd."".$delEnd."<hr".$hrClass.">";
                            echo "".$fontDescriptionStart."".$this->event['description']."".$fontDescriptionEnd."";
                            echo "".$fontPeopleStart."".$this->showPeople."".$fontPeopleEnd."<br><br><br>";
                            echo "</div>";
                            echo "</div>";
                            echo "</div><br><br><br>";
                            $i++;
                        }

                        if (isset($this->fbEventsLayout) && ($this->fbEventsLayout == "middle2"))
                        {
                            // jumbotron output
                            echo "<div class=\"jumbotron".$animate."\" style=\"background-color:#".$this->fbEventsBgColor."; color:#".$this->fbEventsTextColor.";\">";
                            echo "<div class=\"row\">";
                            echo "<div class=\"col-md-12 text-center align-middle\">";
                            echo "".$fontTitleStart."".$canceled."".$delStart."".$this->event['name']."".$fontTitleEnd."";
                            echo "".$fontDateStart."".$delStart."".$this->prettyDate." Uhr ".$fontDatewordStart."(".$this->dateString.")".$fontDatewordEnd."".$delEnd."".$fontDateEnd."";
                            echo "".$coverImage."<br><br>";
                            echo "".$delStart."".$fontLocationStart."".$this->event['place']['name']."".$fontLocationEnd."<br>".$fontAddressStart."".$this->address."".$fontAddressEnd."".$delEnd."<hr".$hrClass.">";
                            echo "".$fontDescriptionStart."".$this->event['description']."".$fontDescriptionEnd."";
                            echo "".$fontPeopleStart."".$this->showPeople."".$fontPeopleEnd."<br>";
                            echo "</div>";
                            echo "</div>";
                            echo "</div><br><br><br>";
                            $i++;
                        }

                        if (isset($this->fbEventsLayout) && ($this->fbEventsLayout == "middle3"))
                        {
                            // jumbotron output
                            echo "<div class=\"jumbotron".$animate."\" style=\"background-color:#".$this->fbEventsBgColor."; color:#".$this->fbEventsTextColor.";\">";
                            echo "<div class=\"row\">";
                            echo "<div class=\"col-md-12 text-center align-middle\">";
                            echo "".$fontTitleStart."".$canceled."".$delStart."".$this->event['name']."".$fontTitleEnd."";
                            echo "".$fontDateStart."".$delStart."".$this->prettyDate." Uhr ".$fontDatewordStart."(".$this->dateString.")".$fontDatewordEnd."".$delEnd."".$fontDateEnd."";
                            echo "".$delStart."".$fontLocationStart."".$this->event['place']['name']."".$fontLocationEnd."<br>".$fontAddressStart."".$this->address."".$fontAddressEnd."".$delEnd."";
                            echo "<br>".$coverImage."<br><hr".$hrClass.">";
                            echo "".$fontDescriptionStart."".$this->event['description']."".$fontDescriptionEnd."";
                            echo "".$fontPeopleStart."".$this->showPeople."".$fontPeopleEnd."<br>";
                            echo "</div>";
                            echo "</div>";
                            echo "</div><br><br><br>";
                            $i++;
                        }

                        if (isset($this->fbEventsLayout) && ($this->fbEventsLayout == "right"))
                        {
                            // jumbotron output
                            echo "<div class=\"jumbotron".$animate."\" style=\"background-color:#".$this->fbEventsBgColor."; color:#".$this->fbEventsTextColor.";\">";
                            echo "<div class=\"row\">";
                            echo "<div class=\"col-md-8\">";
                            echo "".$fontTitleStart."".$canceled."".$delStart."".$this->event['name']."".$fontTitleEnd."";
                            echo "".$fontDateStart."".$delStart."".$this->prettyDate." Uhr ".$fontDatewordStart."(".$this->dateString.")".$fontDatewordEnd."".$delEnd."".$fontDateEnd."<br>";
                            echo "".$delStart."".$fontLocationStart."".$this->event['place']['name']."".$fontLocationEnd."<br>".$fontAddressStart."".$this->address."".$fontAddressEnd."".$delEnd."<hr".$hrClass.">";
                            echo "".$fontDescriptionStart."".$this->event['description']."".$fontDescriptionEnd."";
                            echo "".$fontPeopleStart."".$this->showPeople."".$fontPeopleEnd."";
                            echo "</div>";
                            echo "<div class=\"col-md-4 text-center align-middle\">";
                            echo "".$coverImage."";
                            echo "<br></div>";
                            echo "</div>";
                            echo "</div><br><br><br>";
                            $i++;
                        }

                        if (isset($this->fbEventsLayout) && ($this->fbEventsLayout == "bottom"))
                        {
                            // jumbotron output
                            echo "<div class=\"jumbotron".$animate."\" style=\"background-color:#".$this->fbEventsBgColor."; color:#".$this->fbEventsTextColor.";\">";
                            echo "<div class=\"row\">";
                            echo "<div class=\"col-md-12 text-center align-middle\">";
                            echo "".$fontTitleStart."".$canceled."".$delStart."".$this->event['name']."".$fontTitleEnd."";
                            echo "".$fontDateStart."".$delStart."".$this->prettyDate." Uhr ".$fontDatewordStart."(".$this->dateString.")".$fontDatewordEnd."".$delEnd."".$fontDateEnd."<br>";
                            echo "".$delStart."".$fontLocationStart."".$this->event['place']['name']."".$fontLocationEnd."<br>".$fontAddressStart."".$this->address."".$fontAddressEnd."".$delEnd."<hr".$hrClass.">";
                            echo "".$fontDescriptionStart."".$this->event['description']."".$fontDescriptionEnd."";
                            echo "".$fontPeopleStart."".$this->showPeople."".$fontPeopleEnd."<br>";
                            echo "".$coverImage."<br>";
                            echo "</div>";
                            echo "</div>";
                            echo "</div><br><br><br>";
                            $i++;
                        }
                    }
                }
            }
            else
            {
                die ("Unable to load data. AppID, Access Token or PageID is not set! Don't know what to do? Visit: <a href=\"http://developers.facebook.com\" target=\"_blank\">http://developers.facebook.com</a>");
            }
        } // end function display()
    }   // end class events
} // end namespace