<?php
namespace YAWK\WIDGETS\FACEBOOK\FBCOVER
{
    /**
     * @details<b>Use Facebook Graph API to get you latest cover image of your Facebook Page.
     * Require an App ID and a valid Access Token.</b>
     *
     * <p>This widget shows always your current (newest / latest) cover image of your Facebook page.
     * It is meant to be used as header on top of your template design - or wherever it makes sense.
     * </p>
     *
     *
     * @author     Daniel Retzl <danielretzl@gmail.com>
     * @copyright  2018 Daniel Retzl
     * @version    1.0.0
     * @brief Facebook Cover widget - Embed current cover image from your Facebook page.
     */
class fbCover
{
    /** @param string your app ID (from developers.facebook.com) */
    public $fbCoverAppId = '';
    /** @param string your access token (secret word from developers.facebook.com) */
    public $fbCoverAccessToken = '';
    /** @param string css class to be set on the cover image */
    public $fbCoverImageClass = '';
    /** @param string image width in px or % */
    public $fbCoverImageWidth = '';
    /** @param string image height in px or % */
    public $fbCoverImageHeight = '';
    /** @param string any title you like (important for SEO) */
    public $fbCoverImageTitle = '';
    /** @param string any image alt tag you like (for screenreaders) */
    public $fbCoverImageAlt = '';
    /** @param string custom css style attributes */
    public $fbCoverImageStyle = '';
    /** @param string true|false was the js SDK loaded? */
    public $jsSDKLoaded = 'false';
    /** @param array array: holds the current widget settings */
    public $settings;
    /** @param object api result (as object) */
    public $apiObject;

    /**
     * fbCover constructor. Loads all widget settings
     * @param $db
     */
    public function __construct($db)
    {
        // create new widget object
        $widget = new \YAWK\widget();
        // load this widget settings from db into array
        $this->settings = $widget->getWidgetSettingsArray($db);
        // add settings to object property
        foreach ($this->settings as $property => $value)
        {
            $this->$property = $value;
        }
        // check if required settings are set
        $this->checkRequirements();
    }

    /**
     * call check app id and access token
     *
     */
    public function checkRequirements()
    {
        $this->checkAppId();
        $this->checkAccessToken();
    }

    /**
     * check if app id is set
     * @return bool return true or die with error message
     */
    public function checkAppId()
    {   // check of app id is set and not empty
        if (isset($this->fbCoverAppId) && (!empty($this->fbCoverAppId)))
        {   // app id is set - check if its a number
            if (is_numeric($this->fbCoverAppId))
            {   // ok, seems good
                return true;
            }
            else
                {   // not a number - abort with error msg
                    die ("app ID is set, but not a numeric value! Please check your app ID - it should contain numbers only.");
                }
        }
        else
            {   // app id not set or empty - abort with error msg
                die ("app ID is not set. Please add your app ID. You can obtain it from http://developers.facebook.com");
            }
    }

    /**
     * check if access token is set
     * @return bool return true or die with error message
     */
    public function checkAccessToken()
    {   // check if access token is set and not empty
        if (isset($this->fbCoverAccessToken) && (!empty($this->fbCoverAccessToken)))
        {   // check if access token is a string
            if (is_string($this->fbCoverAccessToken))
            {   // ok...
                return true;
            }
            else
            {   // access token is not a string - abort with error msg
                die ("Access token is set, but not a string value! Please check your access token.");
            }
        }
        else
        {   // access token is not set or empty - abort with error msg
            die ("Access token is not set. Please add your access token. You can obtain it from http://developers.facebook.com");
        }
    }

    /**
     * Load Facebook JS Code
     */
    public function loadJSSDK()
    {   // check if fb JS SDK was loaded before
        if ($this->jsSDKLoaded == 'false')
        {   // check if app ID is set
            if ($this->checkAppId() == true)
            {
                /*
                // include facebook SDK JS
                echo "<script>
                window.fbAsyncInit = function() {
                    FB.init({
                    appId      : '" . $this->fbCoverAppId . "',
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
                */
            }
            else
                {
                    die ("unable to include facebook js SDK - checkAppId failed. Please check your app ID in the widget settings!");
                }
        }
    }

    /**
     * Prepare and make the API call and decode the json into the apiObject property
     * @return mixed Returns an array as obj property, containing the data
     */
    public function makeApiCall()
    {
        // prepare API call
        $json_link = "https://graph.facebook.com/v3.3/me?fields=cover&access_token={$this->fbCoverAccessToken}";

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $json_link);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        // decode json and create object
        $this->apiObject = json_decode(curl_exec($curl), true, 512, JSON_BIGINT_AS_STRING);
        curl_close($curl);

        return $this->apiObject;

        // OUTDATED:
        // get json string
        // $json = file_get_contents($json_link);
        // convert json to object
        // return $this->apiObject = json_decode($json, true, 512, JSON_BIGINT_AS_STRING);
    }


    /**
     * Draws the cover image onto screen.
     *
     */
    public function drawCoverImage()
    {
        $this->loadJSSDK();
        $this->makeApiCall();

        // check if image class is set
        if (isset($this->fbCoverImageClass) && (empty($this->fbCoverImageClass)))
        {   // if not, use this as default value:
            $this->fbCoverImageClass = "img-responsive";
        }

        // check if alt tag was set
        if (isset($this->fbCoverImageAlt) && (!empty($this->fbCoverImageAlt)))
        {   // it is, generate markup
            $altMarkup = " alt=\"$this->fbCoverImageAlt\"";
        }
        else
            {   // not set, leave empty
                $altMarkup = '';
            }

        // check if cover image title is set
        if (isset($this->fbCoverImageTitle) && (!empty($this->fbCoverImageTitle)))
        {   // it is, generate markup
            $titleMarkup = " title=\"$this->fbCoverImageTitle\"";
        }
        else
            {   // not set, leave empty
                $titleMarkup = '';
            }

        // check if image height is set
        if (isset($this->fbCoverImageHeight) && (!empty($this->fbCoverImageHeight)))
        {   // it is, set markup
            $heightMarkup = " height=\"$this->fbCoverImageHeight;\"";
        }
        else
            {   // leave empty
                $heightMarkup = '';
            }

        // check if image width is set
        if (isset($this->fbCoverImageWidth) && (!empty($this->fbCoverImageWidth)))
        {   // if height is set
            if (isset($heightMarkup) && (!empty($heightMarkup)))
            {   // leave a space between tags
                $widthMarkup = " width=\"$this->fbCoverImageWidth\"";
            }
            else
                {   // height is not set - no space needed
                    $widthMarkup = "width=\"$this->fbCoverImageWidth\"";
                }
        }
        else
            {   // width not set - leave markup empty
                $widthMarkup = '';
            }

        // check if css style is set
        if (isset($this->fbCoverImageStyle) && (!empty($this->fbCoverImageStyle)))
        {   // add style markup
            $styleMarkup = " style=\"$this->fbCoverImageStyle\"";
        }
        else
            {   // no style markup needed
                $styleMarkup = '';
            }

        // finally: output the cover image
        echo "<img src=\"".$this->apiObject['cover']['source']."\" class=\"$this->fbCoverImageClass\"$styleMarkup"."$heightMarkup"."$widthMarkup"."$altMarkup"."$titleMarkup>";
    }

}   // end class events
} // end namespace