<?php

namespace YAWK\WIDGETS\FACEBOOK;
class events
{
    /** @var string your app ID (from developers.facebook.com) */
    public $appId = '';
    /** @var string your page ID (http://facebook.com/{YOURPAGEID} */
    public $pageId = '';
    /** @var string your access token (secret word from developers.facebook.com) */
    public $accessToken = '';
    /** @var string user defined layout */
    public $layout = 'left';
    /** @var string show user counter? true|false */
    public $showCounter = 'true';
    /** @var string show cover image? true|false */
    public $showCover = 'true';
    /** @var string any css class for the cover image */
    public $coverClass = '';
    /** @var string which events should be shown? future|past|all */
    public $type = 'future';
    /** @var string show events of this time range */
    public $yearRange = '1';
    /** @var string how events should be sorted: ascending|descending */
    public $sortation = 'asc';
    /** @var string user defined start date */
    public $startDate = '';
    /** @var string user defined end date */
    public $endDate = '';
    /** @var string events since this date (used for calc) */
    public $sinceDate = '';
    /** @var string events until this date (used for calc) */
    public $untilDate = '';
    /** @var string headline before the widget (heading + subtext, if set) */
    public $headline = '';
    /** @var string heading before widget */
    public $heading = '';
    /** @var string subtext before widget */
    public $subtext = '';
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
    public $showPeopleCounter = '1';
    /** @var int how many people are interested or attending - used for calculations */
    public $iPeopleCount = '';
    /** @var string how many people are interested - will be used in frontend view */
    public $showPeople = '';
    /** @var string font size of the event title */
    public $fontEventName = 'h4';
    /** @var string internal placeholder variable */
    public $fontEventNameH = '';
    /** @var string custom css of the event title */
    public $fontEventNameCss = '';
    /** @var string font size of the event date */
    public $fontEventDate = 'h4';
    /** @var string internal placeholder variable */
    public $fontEventDateH = '';
    /** @var string custom css of the event date */
    public $fontEventDateCss = '';
    /** @var string dateword (dateString) as small tag? true|false */
    public $fontEventDateword = 'true';
    /** @var string custom css of the dateword (dateString) */
    public $fontEventDatewordCss = '';
    /** @var string font size of the event location */
    public $fontEventLocation = 'globaltext';
    /** @var string custom css of the event location */
    public $fontEventLocationCss = '';
    /** @var string internal placeholder var */
    public $fontEventLocationH = '';
    /** @var string font size of the event address */
    public $fontEventAddress = 'globaltext';
    /** @var string internal placeholder var */
    public $fontEventAddressH = '';
    /** @var string custom css of the event address */
    public $fontEventAddressCss = '';
    /** @var string font size of the event description */
    public $fontEventDescription= 'globaltext';
    /** @var string internal placeholder var */
    public $fontEventDescriptionH = '';
    /** @var string custom css of the event description */
    public $fontEventDescriptionCss = '';
    /** @var string font size of the event people (interested / attending) */
    public $fontEventPeople = 'globaltext';
    /** @var string internal placeholder var */
    public $fontEventPeopleH = '';
    /** @var string custom css of the event people (interested / attending) */
    public $fontEventPeopleCss = 'text-muted';
    /** @var string font size of canceled event */
    public $fontEventCanceled = 'h3';
    /** @var string custom css of canceled event */
    public $fontEventCanceledCss = 'text-danger';
    /** @var string font title html markup start */
    public $fontTitleStart = '';
    /** @var string font title html markup end */
    public $fontTitleEnd = '';
    /** @var string display <hr> between address and description */
    public $displaySpacer = 'true';
    /** @var string background color of the event jumbotron box */
    public $bgColor = '222222';
    /** @var string text color of the event jumbotron box */
    public $textColor = 'CCCCCC';
    /** @var string address string */
    public $address = '';

    public function __construct()
    {
        // get data from widget...
    }


    public function display()
    {
        if (isset($this->appId) && (!empty($this->appId)
        && (isset($this->accessToken) && (!empty($this->accessToken)
        && (isset($this->pageId) && (!empty($this->pageId)))))))
        {
            // include facebook SDK JS
            echo "<script>
            window.fbAsyncInit = function() {
                FB.init({
                    appId      : '" . $this->appId . "',
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
            if ($this->type === "all")
            {
                // ALL EVENTS (FUTURE + PAST)
                $this->sinceDate = date('Y-01-01', strtotime('-' . $this->yearRange . ' years'));
                $this->untilDate = date('Y-01-01', strtotime('+' . $this->yearRange . ' years'));
            }
            elseif ($this->type == "future")
            {
                // UPCOMING EVENTS
                $this->sinceDate = date('Y-m-d');
                $this->untilDate = date('Y-12-31', strtotime('+' . $this->yearRange . ' years'));
            }
            elseif ($this->type === "past")
            {
                // PAST EVENTS
                $this->sinceDate = date('Y-01-01', strtotime('-' . $this->yearRange . ' years'));
                $this->untilDate = date('Y-m-d');
            }
            else
            {   // IF NOT SET - use default:
                // UPCOMING EVENTS
                $this->sinceDate = date('Y-m-d');
                $this->untilDate = date('Y-12-31', strtotime('+' . $this->yearRange . ' years'));
            }

            // IF START + END DATE IS SET
            if (isset($this->startDate) && (!empty($this->startDate))
            && (isset($this->endDate) && (!empty($this->endDate))))
            {
                $this->sinceDate = date($this->startDate);
                $this->untilDate = date($this->endDate);
            }

            // unix timestamp years
            $since_unix_timestamp = strtotime($this->sinceDate);
            $until_unix_timestamp = strtotime($this->untilDate);

            // prepare fields
            // $this->fields="id,name,description,place,start_time,cover,maybe_count,attending_count,is_canceled";

            // prepare API call
            $json_link = "https://graph.facebook.com/v2.7/{$this->pageId}/events/attending/?fields={$this->fields}&access_token={$this->accessToken}&since={$since_unix_timestamp}&until={$until_unix_timestamp}";

            // get json string
            $json = file_get_contents($json_link);

            // convert json to object
            $obj = json_decode($json, true, 512, JSON_BIGINT_AS_STRING);

            /*
            echo "<pre>";
            print_r($this);
            echo "<hr>";
            print_r($obj);
            echo "</pre>";
            exit;
            */
            if (isset($obj) && (is_array($obj) && (is_array($obj['data']) && (empty($obj['data'])))))
            {
                $now = new \DateTime();
                if (isset($this->type) && (!empty($this->type) && $this->type == "future"))
                {
                    die ("Sorry, no upcoming events were found.");
                }
                else if (isset($this->type) && (!empty($this->type) && $this->type == "past"))
                {
                    die ("Sorry, no past events were found.");
                }
                else
                    {
                        die ("Sorry, no events were found.");
                    }
            }

            // sortation
            if ($this->sortation === "asc")
            {   // reverse array data to display upcoming event first
                $obj['data'] = array_reverse($obj['data']);
            }


            $i = 0;

            // walk through object data */
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
                else if ($until->days > 365)
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
                {   // in exactly two weeks
                    $this->dateString = "in zwei Wochen";
                }
                else if ($until->days >= 8 && ($until->days <= 13))
                {   // nearly two weeks
                    $this->dateString = "in knapp zwei Wochen";
                }
                else if ($until->days === 7)
                {   // in exactly one week
                    $this->dateString = "in einer Woche";
                }
                else if ($until->days === 2)
                {   // in two days
                    $this->dateString = "&uuml;bermorgen";
                }
                else if ($until->days === 1)
                {   // tomorrow
                    $this->dateString = "<span class=\"".$this->fontEventDatewordCss."\">morgen</span>";
                }
                else if ($until->days === 0)
                {   // maybe tomorrow
                    $this->dateString = "<span class=\"".$this->fontEventDatewordCss."\">morgen</span>";
                }   // 0 days remaining, eventDate and currentDate are the same -
                else if ($until->days === 0 && ($eventDateSimple === $currentDateSimple))
                {   // it must be today
                    $this->dateString = "<span class=\"".$this->fontEventDatewordCss."\">HEUTE !</span>";
                }
                else
                {   // any other amount of days
                    $this->dateString = "$prepend $until->d Tagen";
                }

                // check if event is canceled
                if (isset($this->event['is_canceled']) && $this->event['is_canceled'] === true)
                {   // set markup for canceled events
                    $canceled = "<span class=\"".$this->fontEventCanceledCss."\">ACHTUNG! ABGESAGT!</span><br>";
                    $delStart = "<del>";
                    $delEnd = "</del>";
                }
                else
                {   // event is not canceled - no markup needed
                    $canceled = '';
                    $delStart = '';
                    $delEnd = '';
                }

                // check if people counter is enabled or disabled
                if (isset($this->showPeopleCounter) && ($this->showPeopleCounter == "true"))
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
                            $this->showPeople = "<br><br><i class=\"$this->fontEventPeopleCss\">" . $this->iPeopleCount . " Personen sind daran interessiert oder werden dieses Konzert besuchen.</i>";
                        }
                        else
                            {   // past events
                                $this->showPeople = "<br><br><i class=\"$this->fontEventPeopleCss\">" . $this->iPeopleCount . " Personen waren daran interessiert oder haben dieses Konzert besucht.</i>";
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
            if (isset($this->fontEventName) && (!empty($this->fontEventName)))
            {
                $smallTagStart = '';
                $smallTagEnd = '';

                if ($this->fontEventName == "H1 SMALL")
                {
                    $this->fontEventNameH = "H1";
                    $smallTagStart = "<small>";
                    $smallTagEnd = "</small>";
                }
                else if ($this->fontEventName == "H2 SMALL")
                {
                    $this->fontEventNameH = "H2";
                    $smallTagStart = "<small>";
                    $smallTagEnd = "</small>";
                }
                else if ($this->fontEventName == "H3 SMALL")
                {
                    $this->fontEventNameH = "H3";
                    $smallTagStart = "<small>";
                    $smallTagEnd = "</small>";
                }
                else if ($this->fontEventName == "H4 SMALL")
                {
                    $this->fontEventNameH = "H4";
                    $smallTagStart = "<small>";
                    $smallTagEnd = "</small>";
                }
                else if ($this->fontEventName == "H5 SMALL")
                {
                    $this->fontEventNameH = "H5";
                    $smallTagStart = "<small>";
                    $smallTagEnd = "</small>";
                }
                else if ($this->fontEventName == "H6 SMALL")
                {
                    $this->fontEventNameH = "H6";
                    $smallTagStart = "<small>";
                    $smallTagEnd = "</small>";
                }
                else
                    {
                        $this->fontEventNameH = $this->fontEventName;
                    }

                if (isset($this->fontEventNameCss) && (!empty($this->fontEventNameCss)))
                {
                    $fontTitleCss = " class=\"".$this->fontEventNameCss."\"";
                }
                else
                {
                    $fontTitleCss = '';
                }
                $fontTitleStart = "<".$this->fontEventNameH."".$fontTitleCss.">".$smallTagStart."";
                $fontTitleEnd = "".$smallTagEnd."</".$this->fontEventNameH.">";
            }
            else
            {
                $fontTitleStart = "<h4>";
                $fontTitleEnd = "</h4>";
            }

            /** FONT EVENT DATE SETTINGS  */
            if (isset($this->fontEventDate) && (!empty($this->fontEventDate)))
                {
                    $smallTagStartDate = '';
                    $smallTagEndDate = '';

                    if ($this->fontEventDate == "H1 SMALL")
                    {
                        $this->fontEventDateH = "H1";
                        $smallTagStartDate = "<small>";
                        $smallTagEndDate = "</small>";
                    }
                    else if ($this->fontEventDate == "H2 SMALL")
                    {
                        $this->fontEventDateH = "H2";
                        $smallTagStartDate = "<small>";
                        $smallTagEndDate = "</small>";
                    }
                    else if ($this->fontEventDate == "H3 SMALL")
                    {
                        $this->fontEventDateH = "H3";
                        $smallTagStartDate = "<small>";
                        $smallTagEndDate = "</small>";
                    }
                    else if ($this->fontEventDate == "H4 SMALL")
                    {
                        $this->fontEventDateH = "H4";
                        $smallTagStartDate = "<small>";
                        $smallTagEndDate = "</small>";
                    }
                    else if ($this->fontEventDate == "H5 SMALL")
                    {
                        $this->fontEventDateH = "H5";
                        $smallTagStartDate = "<small>";
                        $smallTagEndDate = "</small>";
                    }
                    else if ($this->fontEventDate == "H6 SMALL")
                    {
                        $this->fontEventDateH = "H6";
                        $smallTagStartDate = "<small>";
                        $smallTagEndDate = "</small>";
                    }
                    else
                        {
                            $this->fontEventDateH = $this->fontEventDate;
                        }

                    if (isset($this->fontEventDateCss) && (!empty($this->fontEventDateCss)))
                    {
                        $fontDateCss = " class=\"".$this->fontEventDateCss."\"";
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
                if (isset($this->fontEventDateword) && (!empty($this->fontEventDateword)))
                {

                    if ($this->fontEventDateword == "true")
                    {
                        $smallTagStartDateword = "<small>";
                        $smallTagEndDateword = "</small>";
                    }
                    else
                    {
                        $smallTagStartDateword = "";
                        $smallTagEndDateword = "";
                    }

                    if (isset($this->fontEventDatewordCss) && (!empty($this->fontEventDatewordCss)))
                    {
                        $fontDatewordCssStart = "<span class=\"".$this->fontEventDatewordCss."\">";
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
                if (isset($this->fontEventLocation) && (!empty($this->fontEventLocation)))
                {
                    $smallTagStartLocation = '';
                    $smallTagEndLocation = '';

                    if ($this->fontEventLocation == "H1 SMALL")
                    {
                        $this->fontEventLocationH = "H1";
                        $smallTagStartLocation = "<small>";
                        $smallTagEndLocation = "</small>";
                    }
                    else if ($this->fontEventLocation == "H2 SMALL")
                    {
                        $this->fontEventLocationH = "H2";
                        $smallTagStartLocation = "<small>";
                        $smallTagEndLocation = "</small>";
                    }
                    else if ($this->fontEventLocation == "H3 SMALL")
                    {
                        $this->fontEventLocationH = "H3";
                        $smallTagStartLocation = "<small>";
                        $smallTagEndLocation = "</small>";
                    }
                    else if ($this->fontEventLocation == "H4 SMALL")
                    {
                        $this->fontEventLocationH = "H4";
                        $smallTagStartLocation = "<small>";
                        $smallTagEndLocation = "</small>";
                    }
                    else if ($this->fontEventLocation == "H5 SMALL")
                    {
                        $this->fontEventLocationH = "H5";
                        $smallTagStartLocation = "<small>";
                        $smallTagEndLocation = "</small>";
                    }
                    else if ($this->fontEventLocation == "H6 SMALL")
                    {
                        $this->fontEventLocationH = "H6";
                        $smallTagStartLocation = "<small>";
                        $smallTagEndLocation = "</small>";
                    }
                    else
                    {
                        $this->fontEventLocationH = $this->fontEventLocation;
                    }

                    if (isset($this->fontEventLocationCss) && (!empty($this->fontEventLocationCss)))
                    {
                        $fontLocationCss = " class=\"".$this->fontEventLocationCss."\"";
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
                    if (isset($this->fontEventAddress) && (!empty($this->fontEventAddress)))
                    {
                        $smallTagStartAddress = '';
                        $smallTagEndAddress = '';

                        if ($this->fontEventAddress == "H1 SMALL")
                        {
                            $this->fontEventAddressH = "H1";
                            $smallTagStartAddress = "<small>";
                            $smallTagEndAddress = "</small>";
                        }
                        else if ($this->fontEventAddress == "H2 SMALL")
                        {
                            $this->fontEventAddressH = "H2";
                            $smallTagStartAddress = "<small>";
                            $smallTagEndAddress = "</small>";
                        }
                        else if ($this->fontEventAddress == "H3 SMALL")
                        {
                            $this->fontEventAddressH = "H3";
                            $smallTagStartAddress = "<small>";
                            $smallTagEndAddress = "</small>";
                        }
                        else if ($this->fontEventAddress == "H4 SMALL")
                        {
                            $this->fontEventAddressH = "H4";
                            $smallTagStartAddress = "<small>";
                            $smallTagEndAddress = "</small>";
                        }
                        else if ($this->fontEventAddress == "H5 SMALL")
                        {
                            $this->fontEventAddressH = "H5";
                            $smallTagStartAddress = "<small>";
                            $smallTagEndAddress = "</small>";
                        }
                        else if ($this->fontEventAddress == "H6 SMALL")
                        {
                            $this->fontEventAddressH = "H6";
                            $smallTagStartAddress = "<small>";
                            $smallTagEndAddress = "</small>";
                        }
                        else
                        {
                            $this->fontEventAddressH = $this->fontEventAddress;
                        }

                        if (isset($this->fontEventAddressCss) && (!empty($this->fontEventAddressCss)))
                        {
                            $fontAddressCss = " class=\"".$this->fontEventAddressCss."\"";
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
                if (isset($this->fontEventDescription) && (!empty($this->fontEventDescription)))
                {
                    $smallTagStartDescription = '';
                    $smallTagEndDescription = '';

                    if ($this->fontEventDescription == "H1 SMALL")
                    {
                        $this->fontEventDescriptionH = "H1";
                        $smallTagStartDescription = "<small>";
                        $smallTagEndDescription = "</small>";
                    }
                    else if ($this->fontEventDescription == "H2 SMALL")
                    {
                        $this->fontEventDescriptionH = "H2";
                        $smallTagStartDescription = "<small>";
                        $smallTagEndDescription = "</small>";
                    }
                    else if ($this->fontEventDescription == "H3 SMALL")
                    {
                        $this->fontEventDescriptionH = "H3";
                        $smallTagStartDescription = "<small>";
                        $smallTagEndDescription = "</small>";
                    }
                    else if ($this->fontEventDescription == "H4 SMALL")
                    {
                        $this->fontEventDescriptionH = "H4";
                        $smallTagStartDescription = "<small>";
                        $smallTagEndDescription = "</small>";
                    }
                    else if ($this->fontEventDescription == "H5 SMALL")
                    {
                        $this->fontEventDescriptionH = "H5";
                        $smallTagStartDescription = "<small>";
                        $smallTagEndDescription = "</small>";
                    }
                    else if ($this->fontEventDescription == "H6 SMALL")
                    {
                        $this->fontEventDescriptionH = "H6";
                        $smallTagStartDescription = "<small>";
                        $smallTagEndDescription = "</small>";
                    }
                    else
                    {
                        $this->fontEventDescriptionH = $this->fontEventDescription;
                    }

                    if (isset($this->fontEventDescriptionCss) && (!empty($this->fontEventDescriptionCss)))
                    {
                        $fontDescriptionCss = " class=\"".$this->fontEventDescriptionCss."\"";
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
                if (isset($this->fontEventPeople) && (!empty($this->fontEventPeople)))
                {
                    $smallTagStartPeople = '';
                    $smallTagEndPeople = '';

                    if ($this->fontEventPeople == "H1 SMALL")
                    {
                        $this->fontEventPeopleH = "H1";
                        $smallTagStartPeople = "<small>";
                        $smallTagEndPeople = "</small>";
                    }
                    else if ($this->fontEventPeople == "H2 SMALL")
                    {
                        $this->fontEventPeopleH = "H2";
                        $smallTagStartPeople = "<small>";
                        $smallTagEndPeople = "</small>";
                    }
                    else if ($this->fontEventPeople == "H3 SMALL")
                    {
                        $this->fontEventPeopleH = "H3";
                        $smallTagStartPeople = "<small>";
                        $smallTagEndPeople = "</small>";
                    }
                    else if ($this->fontEventPeople == "H4 SMALL")
                    {
                        $this->fontEventPeopleH = "H4";
                        $smallTagStartPeople = "<small>";
                        $smallTagEndPeople = "</small>";
                    }
                    else if ($this->fontEventPeople == "H5 SMALL")
                    {
                        $this->fontEventPeopleH = "H5";
                        $smallTagStartPeople = "<small>";
                        $smallTagEndPeople = "</small>";
                    }
                    else if ($this->fontEventPeople == "H6 SMALL")
                    {
                        $this->fontEventPeopleH = "H6";
                        $smallTagStartPeople = "<small>";
                        $smallTagEndPeople = "</small>";
                    }
                    else if ($this->fontEventPeople == "globaltext small")
                    {
                        $this->fontEventPeopleH = "span";
                        $smallTagStartPeople = "<small>";
                        $smallTagEndPeople = "</small>";
                    }
                    else
                    {
                        $this->fontEventPeopleH = $this->fontEventPeople;
                    }

                    if (isset($this->fontEventPeopleCss) && (!empty($this->fontEventPeopleCss)))
                    {
                        $fontPeopleCss = " class=\"".$this->fontEventPeopleCss."\"";
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
                if (isset($this->showCover) && ($this->showCover == "true"))
                {   // if cover image source is set
                    if (isset($this->event['cover']['source']) && (!empty($this->event['cover']['source'])))
                    {
                        // img html markup
                        // check if custom cover class is set
                        if (isset($this->coverClass) && (!empty($this->coverClass)))
                        {   // yep, display it with custom class
                            $coverImage = "<br><img width=\"300\" src=\"" . $this->event['cover']['source'] . "\" title=\"" . $this->event['name'] . "\" class=\"".$this->coverClass."\">";
                        }
                        else
                            {   // default: img-thumbnail responsive
                                $coverImage = "<br><img width=\"300\" src=\"" . $this->event['cover']['source'] . "\" title=\"" . $this->event['name'] . "\" class=\"img-thumbnail responsive\">";
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

                /* TODO ANIMATE  - */
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

                // layouts start
                if (isset($this->layout) && ($this->layout == "table"))
                {
                    echo "<table border=\"0\" class=\"table table-responsive\">";
                        echo "<tr>";
                            echo "<td>";
                            echo "" . $delStart. "<small>" . $this->prettyDate . " Uhr<br><small>(" . $this->dateString . ")</small></small>" . $delEnd . "";
                            echo "</td>";
                            echo "<td>";
                            echo "<b>" . $this->event['name'] . "</b><br>" . $this->event['place']['name'] . "<br><small>(" . $this->event['place']['location']['street'] . ", " . $this->event['place']['location']['zip'] . " " . $this->event['place']['location']['city'] . ", " . $this->event['place']['location']['country'] . ")</small><hr>";
                            echo "".$this->event['description']."</td>";
                        echo "</tr>";
                    echo "</table>";
                    $i++;
                }

                if (isset($this->layout) && ($this->layout == "left"))
                {
                    // jumbotron output
                    echo "<div class=\"jumbotron".$animate."\" style=\"background-color:#".$this->bgColor."; color:#".$this->textColor.";\">";
                    echo "<div class=\"row\">";
                    echo "<div class=\"col-md-4 text-center align-middle\">";
                    echo "".$coverImage."";
                    echo "<br></div>";
                    echo "<div class=\"col-md-8\">";
                    echo "".$fontTitleStart."".$canceled."".$delStart."".$this->event['name']."".$fontTitleEnd."";
                    echo "".$fontDateStart."".$delStart."".$this->prettyDate." Uhr ".$fontDatewordStart."(".$this->dateString.")".$fontDatewordEnd."".$delEnd."".$fontDateEnd."<br>";
                    echo "".$delStart."".$fontLocationStart."".$this->event['place']['name']."".$fontLocationEnd."<br>".$fontAddressStart."".$this->address."".$fontAddressEnd."".$delEnd."<hr>";
                    echo "".$fontDescriptionStart."".$this->event['description']."".$fontDescriptionEnd."";
                    echo "".$fontPeopleStart."".$this->showPeople."".$fontPeopleEnd."";
                    echo "</div>";
                    echo "</div>";
                    echo "</div><br><br>";
                    $i++;
                }

                if (isset($this->layout) && ($this->layout == "top"))
                {
                    // jumbotron output
                    echo "<div class=\"jumbotron".$animate."\" style=\"background-color:#".$this->bgColor."; color:#".$this->textColor.";\">";
                    echo "<div class=\"row\">";
                    echo "<div class=\"col-md-12 text-center align-middle\">";
                    echo "".$coverImage."<br>";
                    echo "".$fontTitleStart."".$canceled."".$delStart."".$this->event['name']."".$fontTitleEnd."";
                    echo "".$fontDateStart."".$delStart."".$this->prettyDate." Uhr ".$fontDatewordStart."(".$this->dateString.")".$fontDatewordEnd."".$delEnd."".$fontDateEnd."<br>";
                    echo "".$delStart."".$fontLocationStart."".$this->event['place']['name']."".$fontLocationEnd."<br>".$fontAddressStart."".$this->address."".$fontAddressEnd."".$delEnd."<hr>";
                    echo "".$fontDescriptionStart."".$this->event['description']."".$fontDescriptionEnd."";
                    echo "".$fontPeopleStart."".$this->showPeople."".$fontPeopleEnd."";
                    echo "</div>";
                    echo "</div>";
                    echo "</div><br><br>";
                    $i++;
                }


                if (isset($this->layout) && ($this->layout == "middle"))
                {
                    // jumbotron output
                    echo "<div class=\"".$animate."\" style=\"background-color:#".$this->bgColor."; color:#".$this->textColor.";\">";
                    echo "<div class=\"row\">";
                    echo "<div class=\"col-md-12 text-center align-middle\">";
                    echo "".$fontTitleStart."".$canceled."".$delStart."".$this->event['name']."".$fontTitleEnd."";
                    echo "".$coverImage."<br>";
                    echo "".$fontDateStart."".$delStart."".$this->prettyDate." Uhr ".$fontDatewordStart."(".$this->dateString.")".$fontDatewordEnd."".$delEnd."".$fontDateEnd."<br>";
                    echo "".$delStart."".$fontLocationStart."".$this->event['place']['name']."".$fontLocationEnd."<br>".$fontAddressStart."".$this->address."".$fontAddressEnd."".$delEnd."<hr>";
                    echo "".$fontDescriptionStart."".$this->event['description']."".$fontDescriptionEnd."";
                    echo "".$fontPeopleStart."".$this->showPeople."".$fontPeopleEnd."<br>";
                    echo "</div>";
                    echo "</div>";
                    echo "</div><br><br>";
                    $i++;
                }

                if (isset($this->layout) && ($this->layout == "middle2"))
                {
                    // jumbotron output
                    echo "<div class=\"jumbotron".$animate."\" style=\"background-color:#".$this->bgColor."; color:#".$this->textColor.";\">";
                    echo "<div class=\"row\">";
                    echo "<div class=\"col-md-12 text-center align-middle\">";
                    echo "".$fontTitleStart."".$canceled."".$delStart."".$this->event['name']."".$fontTitleEnd."";
                    echo "".$fontDateStart."".$delStart."".$this->prettyDate." Uhr ".$fontDatewordStart."(".$this->dateString.")".$fontDatewordEnd."".$delEnd."".$fontDateEnd."";
                    echo "".$coverImage."<br><br>";
                    echo "".$delStart."".$fontLocationStart."".$this->event['place']['name']."".$fontLocationEnd."<br>".$fontAddressStart."".$this->address."".$fontAddressEnd."".$delEnd."<hr>";
                    echo "".$fontDescriptionStart."".$this->event['description']."".$fontDescriptionEnd."";
                    echo "".$fontPeopleStart."".$this->showPeople."".$fontPeopleEnd."<br>";
                    echo "</div>";
                    echo "</div>";
                    echo "</div><br><br>";
                    $i++;
                }

                if (isset($this->layout) && ($this->layout == "middle3"))
                {
                    // jumbotron output
                    echo "<div class=\"jumbotron".$animate."\" style=\"background-color:#".$this->bgColor."; color:#".$this->textColor.";\">";
                    echo "<div class=\"row\">";
                    echo "<div class=\"col-md-12 text-center align-middle\">";
                    echo "".$fontTitleStart."".$canceled."".$delStart."".$this->event['name']."".$fontTitleEnd."";
                    echo "".$fontDateStart."".$delStart."".$this->prettyDate." Uhr ".$fontDatewordStart."(".$this->dateString.")".$fontDatewordEnd."".$delEnd."".$fontDateEnd."";
                    echo "".$delStart."".$fontLocationStart."".$this->event['place']['name']."".$fontLocationEnd."<br>".$fontAddressStart."".$this->address."".$fontAddressEnd."".$delEnd."";
                    echo "<br>".$coverImage."<br><hr>";
                    echo "".$fontDescriptionStart."".$this->event['description']."".$fontDescriptionEnd."";
                    echo "".$fontPeopleStart."".$this->showPeople."".$fontPeopleEnd."<br>";
                    echo "</div>";
                    echo "</div>";
                    echo "</div><br><br>";
                    $i++;
                }

                if (isset($this->layout) && ($this->layout == "right"))
                {
                    // jumbotron output
                    echo "<div class=\"jumbotron".$animate."\" style=\"background-color:#".$this->bgColor."; color:#".$this->textColor.";\">";
                    echo "<div class=\"row\">";
                    echo "<div class=\"col-md-8\">";
                    echo "".$fontTitleStart."".$canceled."".$delStart."".$this->event['name']."".$fontTitleEnd."";
                    echo "".$fontDateStart."".$delStart."".$this->prettyDate." Uhr ".$fontDatewordStart."(".$this->dateString.")".$fontDatewordEnd."".$delEnd."".$fontDateEnd."<br>";
                    echo "".$delStart."".$fontLocationStart."".$this->event['place']['name']."".$fontLocationEnd."<br>".$fontAddressStart."".$this->address."".$fontAddressEnd."".$delEnd."<hr>";
                    echo "".$fontDescriptionStart."".$this->event['description']."".$fontDescriptionEnd."";
                    echo "".$fontPeopleStart."".$this->showPeople."".$fontPeopleEnd."";
                    echo "</div>";
                    echo "<div class=\"col-md-4 text-center align-middle\">";
                    echo "".$coverImage."";
                    echo "<br></div>";
                    echo "</div>";
                    echo "</div><br><br>";
                    $i++;
                }

                if (isset($this->layout) && ($this->layout == "bottom"))
                {
                    // jumbotron output
                    echo "<div class=\"jumbotron".$animate."\" style=\"background-color:#".$this->bgColor."; color:#".$this->textColor.";\">";
                    echo "<div class=\"row\">";
                    echo "<div class=\"col-md-12 text-center align-middle\">";
                    echo "".$fontTitleStart."".$canceled."".$delStart."".$this->event['name']."".$fontTitleEnd."";
                    echo "".$fontDateStart."".$delStart."".$this->prettyDate." Uhr ".$fontDatewordStart."(".$this->dateString.")".$fontDatewordEnd."".$delEnd."".$fontDateEnd."<br>";
                    echo "".$delStart."".$fontLocationStart."".$this->event['place']['name']."".$fontLocationEnd."<br>".$fontAddressStart."".$this->address."".$fontAddressEnd."".$delEnd."<hr>";
                    echo "".$fontDescriptionStart."".$this->event['description']."".$fontDescriptionEnd."";
                    echo "".$fontPeopleStart."".$this->showPeople."".$fontPeopleEnd."<br>";
                    echo "".$coverImage."<br>";
                    echo "</div>";
                    echo "</div>";
                    echo "</div><br><br>";
                    $i++;
                }
            }
        }
        else
            {
                die ("Unable to load data. AppID, Access Token or PageID is not set! Don't know what to do? Visit: <a href=\"http://developers.facebook.com\" target=\"_blank\">http://developers.facebook.com</a>");
            }
    }
}