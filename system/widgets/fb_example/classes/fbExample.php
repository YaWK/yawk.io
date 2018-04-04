<?php
namespace YAWK\WIDGETS\FACEBOOK\EXAMPLE
{
    /**
     * <b>Use Facebook Graph API to get any data from a Facebook Page. Require App ID and Access Token.</b>
     * <p>This is just an empty example widget for development and demo purpose!</p>
     *
     * <p>It is recommended to play around with the facebook graph explorer.
     * You can set any api call and fields you like to play around and explore the resulting array.
     * You can use this widget as base for your own facebook api projects.</p>
     *
     * @package    YAWK
     * @author     Daniel Retzl <danielretzl@gmail.com>
     * @copyright  2018 Daniel Retzl
     * @license    https://opensource.org/licenses/MIT
     * @version    1.0.0
     * @link       http://yawk.io
     * @annotation Facebook Graph API explorer widget - for demo and development purpose only!
     */
class fbExample
{
    /** @var string your app ID (from developers.facebook.com) */
    public $fbExampleAppId = '';
    /** @var string your page ID (http://facebook.com/{YOURPAGEID} */
    public $fbExamplePageId = '';
    /** @var string your access token (secret word from developers.facebook.com) */
    public $fbExampleAccessToken = '';
    /** @var string your graph request */
    public $fbExampleGraphRequest = '/feed/';
    /** @var string fields that should be selected from facebook graph */
    public $fbExampleFields = 'id,name,description,place,start_time,cover,maybe_count,attending_count,is_canceled';
    /** @var object api result (as object) */
    public $apiObject;
    /** @var string true|false was the js SDK loaded? */
    public $jsSDKLoaded = 'false';
    /** @var string show events of this time range */
    public $fbEventsYearRange = '1';
    /** @var string user defined start date */
    public $fbEventsStartDate = '';
    /** @var string user defined end date */
    public $fbEventsEndDate = '';
    /** @var string which events should be shown? future|past|all */
    public $fbEventsType = 'future';


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
        // check if fields are set
        if (isset($this->fbExampleFields) && (!empty($this->fbExampleFields)))
        {   // set markup for api query string
            $fieldsMarkup = "&fields={$this->fbExampleFields}";
        }
        else
            {   // no fields wanted, leave markup empty
                $fieldsMarkup = '';
            }

        // prepare API call
        // $json_link = "https://graph.facebook.com/v2.7/{$this->fbExamplePageId}{$this->fbExampleGraphRequest}?fields={$this->fields}&access_token={$this->fbExampleAccessToken}";
        $json_link = "https://graph.facebook.com/v2.7/{$this->fbExamplePageId}{$this->fbExampleGraphRequest}?access_token={$this->fbExampleAccessToken}" . $fieldsMarkup . "";

        // get json string
        $json = file_get_contents($json_link);

        // convert json to object
        return $this->apiObject = json_decode($json, true, 512, JSON_BIGINT_AS_STRING);
    }

    public function printApiObject()
    {
        $this->makeApiCall();
        if (isset($this->apiObject) && (!empty($this->apiObject)))
        {
            echo "<pre>";
            print_r($this);
            echo "</pre>";
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

            if (isset($this->apiObject['data']) && (!empty($this->apiObject)))
            {
                foreach ($this->apiObject['data'] as $property => $value)
                {
                    echo "<br><br>$property : $value<br>";
                    if (is_array($value))
                    {
                        foreach ($value as $entry => $key)
                        {
                            echo "$entry : $key <br>";
                            if (is_array($key))
                            {
                                foreach ($key as $image)
                                {
                                    echo "$key : $image<br>";
                                    if (is_array($key) || (is_array($image)))
                                    {
                                        foreach ($key as $arrayKey => $arrayValue)
                                        {
                                            echo "&nbsp;&nbsp;$arrayKey : $arrayValue<br>";
                                            if (is_array($arrayValue))
                                            {
                                                foreach ($arrayValue as $p => $v)
                                                {
                                                    echo "&nbsp;&nbsp;$p : $v<br>";
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }


}   // end class events
} // end namespace