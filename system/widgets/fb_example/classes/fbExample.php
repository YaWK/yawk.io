<?php
namespace YAWK\WIDGETS\FACEBOOK
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
    /** @var array all api result data (multidimensional array) */
    public $data = array();


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
        // $this->checkRequirements();
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
    {
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
        }
    }

    public function makeApiCall()
    {

    }
    
    public function basicOutput()
    {
        $this->loadJSSDK();

        // prepare fields
        // $this->fields="id,name,description,place,start_time,cover,maybe_count,attending_count,is_canceled";

        if (isset($this->fbExampleFields) && (!empty($this->fbExampleFields)))
        {
            $fieldsMarkup = "&fields={$this->fbExampleFields}";
        }
        else
            {
                $fieldsMarkup = '';
            }

        // prepare API call
        // $json_link = "https://graph.facebook.com/v2.7/{$this->fbExamplePageId}{$this->fbExampleGraphRequest}?fields={$this->fields}&access_token={$this->fbExampleAccessToken}";
        $json_link = "https://graph.facebook.com/v2.7/{$this->fbExamplePageId}{$this->fbExampleGraphRequest}?access_token={$this->fbExampleAccessToken}".$fieldsMarkup."";

        // get json string
        $json = file_get_contents($json_link);

        // convert json to object
        $this->apiObject = json_decode($json, true, 512, JSON_BIGINT_AS_STRING);

        echo "<pre>";
        echo "<h1>Settings</h1>";
        print_r($this);
        echo "</pre>";

        foreach ($this->apiObject['data'] as $property => $value)
        {
            echo "<b>$property </b>: $value<br>";

            foreach ($value as $entry => $key)
            {

                echo "$entry : $key<br>";

                if (is_array($key))
                {
                    foreach ($key as $p => $v)
                    {
                        echo "&nbsp;&nbsp;&nbsp;&nbsp;$p : $v<br>";
                        if (is_array($v))
                        {
                            foreach ($v as $a => $b)
                            {
                                echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$a : $b<br>";
                            }
                        }
                    }
                }
            }
            echo "<br>";
        }

    } // end basic output

}   // end class events
} // end namespace