<?php
namespace YAWK\WIDGETS\FACEBOOK\FEED
{
    /**
     * @details <b>Use Facebook Graph API to get feed data from a Facebook Page. Require App ID and Access Token.</b>
     * <p>This is just an empty example widget for development and demo purpose!</p>
     *
     * <p>This Widget gets the latest (limit) posts of your facebook page feed.</p>
     *
     * @author     Daniel Retzl <danielretzl@gmail.com>
     * @copyright  2019 Daniel Retzl
     * @version    1.0.0
     * @brief Facebook Page Feed
     */
class fbFeed
{
    /** @param string your app ID (from developers.facebook.com) */
    public $fbFeedAppId = '';
    /** @param string your page ID (http://facebook.com/{YOURPAGEID} */
    public $fbFeedPageId = '';
    /** @param string your access token (secret word from developers.facebook.com) */
    public $fbFeedAccessToken = '';
    /** @param string your graph request */
    public $fbFeedGraphRequest = '/me/feed/';
    /** @param string fields that should be selected from facebook graph */
    public $fbFeedFields = 'picture,message,place,created_time,full_picture,coordinates';
    /** @param string show events of this time range */
    public $fbFeedLimit = '1';
    /** @param object api result (as object) */
    public $apiObject;
    /** @param string the json link */
    public $jsonLink;
    /** @param string date of the posting */
    public $eventDate;
    /** @param string posting date */
    public $dateString;
    /** @param string date (time ago) helper */
    public $fbEventsDatewordCss;
    /** @param string posting message */
    public $message;
    /** @param string photo src */
    public $picture;
    /** @param string place */
    public $place;

    public function __construct($db)
    {
        // load this widget settings from db
        $widget = new \YAWK\widget();
        $settings = $widget->getWidgetSettingsArray($db);
        foreach ($settings as $property => $value)
        {
            $this->$property = $value;
        }
        // check if required settings are set
        $this->checkRequirements();
    }

    public function checkRequirements()
    {
        $this->checkAppId();
        $this->checkAccessToken();
        $this->checkPageId();
    }

    public function checkAppId()
    {
        if (isset($this->fbFeedAppId) && (!empty($this->fbFeedAppId)))
        {
            if (is_numeric($this->fbFeedAppId))
            {
                return true;
            }
            else
                {
                    die ("app ID is set, but not a numeric value! Please check your app ID - it should contain numbers only.");
                }
        }
        else
            {
                die ("app ID is not set. Please add your app ID. You can obtain it from http://developers.facebook.com");
            }
    }

    public function checkAccessToken()
    {
        if (isset($this->fbFeedAccessToken) && (!empty($this->fbFeedAccessToken)))
        {
            if (is_string($this->fbFeedAccessToken))
            {
                return true;
            }
            else
            {
                die ("Access token is set, but not a string value! Please check your access token.");
            }
        }
        else
        {
            die ("Access token is not set. Please add your access token. You can obtain it from http://developers.facebook.com");
        }
    }
    public function checkPageId()
    {
        if (isset($this->fbFeedPageId) && (!empty($this->fbFeedPageId)))
        {
            if (is_string($this->fbFeedPageId))
            {
                return true;
            }
            else
            {
                die ("Page ID is set, but not a string value! Please check your page ID.");
            }
        }
        else
        {
            die ("Page ID is not set. Please add your page ID. The Page ID is: https://www.facebook.com/{YOURPAGEID}");
        }
    }

    public function makeApiCall()
    {
        // check if pageID is set
        if (isset($this->fbFeedPageId) && (!empty($this->fbFeedPageId)))
        {
            // set markup for pageID string
            $this->fbFeedAppId = $this->fbFeedPageId;
        }
        else
            {   // leave empty if no page id is given (to build custom graph string)
                $this->fbFeedPageId = '';
            }

        // check if fields are set
        if (isset($this->fbFeedFields) && (!empty($this->fbFeedFields)))
        {   // set markup for api query string
            if (empty($this->fbFeedPageId))
            {
                $this->fbFeedFields = "?fields={$this->fbFeedFields}";
            }
        }
        else
            {   // no fields wanted, leave markup empty
                $this->fbFeedFields = '';
            }

        // prepare API call
        // $json_link = "https://graph.facebook.com/v3.3/me/events/?fields={$this->fields}&access_token={$this->fbEventsAccessToken}&since={$since_unix_timestamp}&until={$until_unix_timestamp}";
        $this->jsonLink = "https://graph.facebook.com/v3.3/{$this->fbFeedGraphRequest}?fields={$this->fbFeedFields}&access_token={$this->fbFeedAccessToken}&limit={$this->fbFeedLimit}";
        // get json string
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $this->jsonLink);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        // decode json and create object
        $this->apiObject = json_decode(curl_exec($curl), true, 512, JSON_BIGINT_AS_STRING);
        curl_close($curl);


        // if object is set, but array got not data...
        if (isset($this->apiObject) && (is_array($this->apiObject['data']))) {   // no upcoming data found
            return $this->apiObject;
        }
        else
            {
                echo "<pre>";
                print_r($this->apiObject);
                echo "</pre><hr>";
                die('There was an error during the curl process. Please check your facebook connection data.');
        }
    }

    public function checkApiObjectData()
    {
        if (isset($this->apiObject['data']) && (!empty($this->apiObject['data'])))
        {
            return true;
        }
        else
            {
                return false;
            }
    }

    public function printApiObject()
    {
        $this->makeApiCall();
        if ($this->checkApiObjectData() === true)
        {
            echo "<pre>";
            print_r($this);
            echo "</pre>";
        }
        else
            {
                echo "<pre>";
                echo "Could not retrieve any data from Facebook. Please check your PageID, API request, field and date settings";
                echo "</pre>";
                exit;
            }
    }
    
    public function basicOutput()
    {
        // get data
        $this->makeApiCall();

        // set limit
        $i = $this->fbFeedLimit;
        // remove 1, to loop correctly trough array
        // because $this->apiObject['data'] starts with zero
        $i--;

        // newest items first
        $this->apiObject['data'] = array_reverse($this->apiObject['data']);

        // starting row
        echo '<div class="row" style="margin:10px;">';

        if ($i === 0)
        {
            die('Oops, something went wrong here: NEWS data could not be retrieved.');
        }

        $loopCount = 0;
        // loop, while there is array data
        while ($i >= 0)
        {
            // create date obj
            $this->eventDate = new \DateTime($this->apiObject['data'][$i]['created_time']);
            // format as mysql date
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

            if (!empty($this->apiObject['data'][$i]['message']))
            {
                $this->message = $this->apiObject['data'][$i]['message'];
            }
            else
                {
                    $this->message = '';
                }

            if (!empty($this->apiObject['data'][$i]['full_picture']))
            {
                $this->picture = '<img src="'.$this->apiObject['data'][$i]['full_picture'].'" class="card-img-top protected">';
            }
            else
                {
                    $this->picture = '';
                }

            if (isset($this->apiObject['data'][$i]['place']['name']))
            {
                $this->place = "@ ".$this->apiObject['data'][$i]['place']['name'];
            }
            else
                {
                    $this->place = '';
                }

                /*
            if ($loopCount < 3)
            {
                $animation = "animated fadeIn";
            }
            else
                {
                    $animation = "animate";
                }
                */

                echo '<div class="col-lg-4 animate" data-fx="fadeIn">';
                echo '<div class="card">
                        <div class="card-header"><h5 class="card-title">'.$this->apiObject['data'][$i]['from']['name'].'
                         <small class="text-muted">'.$this->place.'</small></h5>
                            <h5 class="card-subtitle mb-2 text-muted"><small>'.$this->dateString.'</small></h5>
                        </div>
                        '.$this->picture.'
                      <div class="card-body">
                        <p class="card-text">'.$this->message.'</p>
                      </div>
                    </div>';


                echo '<br><br></div>';
            $i--;
            $loopCount++;
        }
        echo'</div>';

    }

    }   // end class events
} // end namespace