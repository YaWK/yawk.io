<?php
namespace YAWK\WIDGETS\FACEBOOK\EXAMPLE
{
    /**
     * @details<b>Use Facebook Graph API to get any data from a Facebook Page. Require App ID and Access Token.</b>
     * <p>This is just an empty example widget for development and demo purpose!</p>
     *
     * <p>It is recommended to play around with the facebook graph explorer.
     * You can set any api call and fields you like to play around and explore the resulting array.
     * You can use this widget as base for your own facebook api projects.</p>
     *
     *
     * @author     Daniel Retzl <danielretzl@gmail.com>
     * @copyright  2018 Daniel Retzl
     * @version    1.0.0
     * @brief Facebook Graph API explorer widget - for demo and development purpose only!
     */
class fbExample
{
    /** @param string your app ID (from developers.facebook.com) */
    public $fbExampleAppId = '';
    /** @param string your page ID (http://facebook.com/{YOURPAGEID} */
    public $fbExamplePageId = '';
    /** @param string your access token (secret word from developers.facebook.com) */
    public $fbExampleAccessToken = '';
    /** @param string your graph request */
    public $fbExampleGraphRequest = '/events/';
    /** @param string fields that should be selected from facebook graph */
    public $fbExampleFields = 'id,name,description,place,start_time,cover,maybe_count,attending_count,is_canceled';
    /** @param string show events of this time range */
    public $fbExampleYearRange = '1';
    /** @param string user defined start date */
    public $fbExampleStartDate = '';
    /** @param string user defined end date */
    public $fbExampleEndDate = '';
    /** @param string which events should be shown? future|past|all */
    public $fbExampleType = 'future';
    /** @param string events since this date (used for calc) */
    public $sinceDate = '';
    /** @param string events until this date (used for calc) */
    public $untilDate = '';
    /** @param string true|false was the js SDK loaded? */
    public $jsSDKLoaded = 'false';
    /** @param object api result (as object) */
    public $apiObject;


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
        if (isset($this->fbExampleAppId) && (!empty($this->fbExampleAppId)))
        {
            if (is_numeric($this->fbExampleAppId))
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
        if (isset($this->fbExampleAccessToken) && (!empty($this->fbExampleAccessToken)))
        {
            if (is_string($this->fbExampleAccessToken))
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
        if (isset($this->fbExamplePageId) && (!empty($this->fbExamplePageId)))
        {
            if (is_string($this->fbExamplePageId))
            {
                return true;
            }
            /* to allow custom url requests, this is uncommented.
            else
            {
                die ("Page ID is set, but not a string value! Please check your page ID.");
            }
            */
        }
        /* to allow custom url requests, this is uncommented.
        else
        {
            die ("Page ID is not set. Please add your page ID. The Page ID is: https://www.facebook.com/{YOURPAGEID}");
        }
        */
    }

    public function loadJSSDK()
    {   // check if fb JS SDK was loaded before
        if ($this->jsSDKLoaded == 'false')
        {   // check if app ID is set
            if ($this->checkAppId() == true)
            {
                // include facebook SDK JS
                echo "<script>
                window.fbAsyncInit = function() {
                    FB.init({
                    appId      : '" . $this->fbExampleAppId . "',
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
                $this->jsSDKLoaded = 'true';
            }
            else
                {
                    die ("unable to include facebook js SDK - checkAppId failed. Please check your app ID in the widget settings!");
                }
        }
    }

    public function makeApiCall()
    {
        // WHICH EVENTS TO DISPLAY?
        // evaluation of event type select field
        if ($this->fbExampleType == "all")
        {
            // ALL EVENTS (FUTURE + PAST)
            $this->sinceDate = date('Y-01-01', strtotime('-' . $this->fbExampleYearRange . ' years'));
            $this->untilDate = date('Y-01-01', strtotime('+' . $this->fbExampleYearRange . ' years'));
        }
        elseif ($this->fbExampleType == "future")
        {
            // UPCOMING EVENTS
            $this->sinceDate = date('Y-m-d');
            $this->untilDate = date('Y-12-31', strtotime('+' . $this->fbExampleYearRange . ' years'));
        }
        elseif ($this->fbExampleType == "past")
        {
            // PAST EVENTS
            $this->sinceDate = date('Y-01-01', strtotime('-' . $this->fbExampleYearRange . ' years'));
            $this->untilDate = date('Y-m-d');
        }
        else
        {   // IF NOT SET - use default:
            // UPCOMING EVENTS
            $this->sinceDate = date('Y-m-d');
            $this->untilDate = date('Y-12-31', strtotime('+' . $this->fbExampleYearRange . ' years'));
        }

        // IF START + END DATE IS SET
        if (isset($this->fbExampleStartDate) && (!empty($this->fbExampleStartDate))
            && (isset($this->fbExampleEndDate) && (!empty($this->fbExampleEndDate))))
        {
            $this->sinceDate = date($this->fbExampleStartDate);
            $this->untilDate = date($this->fbExampleEndDate);
        }

        // unix timestamp years
        $since_unix_timestamp = strtotime($this->sinceDate);
        $until_unix_timestamp = strtotime($this->untilDate);
        // check if pageID is set
        if (isset($this->fbExamplePageId) && (!empty($this->fbExamplePageId)))
        {
            // set markup for pageID string
            $pageIdMarkup = "{$this->fbExamplePageId}";
        }
        else
            {   // leave empty if no page id is given (to build custom graph string)
                $this->fbExamplePageId = '';
            }
        // check if fields are set
        if (isset($this->fbExampleFields) && (!empty($this->fbExampleFields)))
        {   // set markup for api query string
            $fieldsMarkup = "&fields={$this->fbExampleFields}";
            if (empty($this->fbExamplePageId))
            {
                $fieldsMarkup = "?fields={$this->fbExampleFields}";
            }
        }
        else
            {   // no fields wanted, leave markup empty
                $fieldsMarkup = '';
            }

        // prepare API call
        // $json_link = "https://graph.facebook.com/v2.7/{$this->fbExamplePageId}{$this->fbExampleGraphRequest}?fields={$this->fields}&access_token={$this->fbExampleAccessToken}";
        $json_link = "https://graph.facebook.com/v3.1/{$this->fbExamplePageId}{$this->fbExampleGraphRequest}?access_token={$this->fbExampleAccessToken}&since={$since_unix_timestamp}&until={$until_unix_timestamp}" . $fieldsMarkup . "";
        // get json string
        $json = file_get_contents($json_link);

        // convert json to object
        return $this->apiObject = json_decode($json, true, 512, JSON_BIGINT_AS_STRING);
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
        $this->loadJSSDK();
        $this->makeApiCall();

        foreach ($this->apiObject['data'] as $property => $value) {
            echo "<b>$property </b>: $value<br>";

            foreach ($value as $entry => $key) {

                echo "$entry : $key<br>";

                if (is_array($key)) {
                    foreach ($key as $p => $v) {
                        echo "&nbsp;&nbsp;&nbsp;&nbsp;$p : $v<br>";
                        if (is_array($v)) {
                            foreach ($v as $a => $b) {
                                echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$a : $b<br>";
                            }
                        }
                    }
                }
            }
            echo "<br>";
        }
    }

        public function drawGallery()
        {
            $this->loadJSSDK();
            $this->makeApiCall();
            if (isset($this->apiObject['data']) && (!empty($this->apiObject))) {
                echo "<h1>Facebook Photo Albums</h1>";

                foreach ($this->apiObject['data'] as $property => $value)
                {
                    if ($value['name'] != "//Profile Pictures"
                    && ($value['name'] !=
                        != "//Cover Photos")
                    {
                    $fn = $value['picture']['data']['url'];
                    echo "<div class=\"col-md-2 text-center\">
                <img src=\"$fn\" style=\"width:200px;\" class=\"img-responsive hvr-grow\"><h3>$value[name] 
                <small><i>($value[count])</i></small></h3><br>
                </div>";


                    }

                    /*
                    foreach ($value['images'] as $photo)
                    {
                        echo "<pre>";
                        echo "<img src=\"".$photo['source']."\" class=\"img-responsive\">";
                        echo "</pre>";
                    }
                    */
/*
                    echo "<br><br>$property : $value<br>";

                    if (is_array($value)) {

                        foreach ($value as $entry => $key) {
                            echo "$entry : $key <br>";
                            if (is_array($key)) {
                                foreach ($key as $image) {
                                    echo "$key : $image<br>";
                                    if (is_array($key) || (is_array($image))) {
                                        foreach ($key as $arrayKey => $arrayValue) {
                                            echo "&nbsp;&nbsp;$arrayKey : $arrayValue<br>";
                                            if (is_array($arrayValue)) {
                                                foreach ($arrayValue as $p => $v) {
                                                    echo "&nbsp;&nbsp;$p : $v<br>";
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
*/
                }
            }
        }
}   // end class events
} // end namespace