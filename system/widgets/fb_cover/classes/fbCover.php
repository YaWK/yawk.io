<?php
namespace YAWK\WIDGETS\FACEBOOK\FBCOVER
{
    /**
     * <b>Use Facebook Graph API to get you latest cover image of your Facebook Page.
     * Require an App ID and a valid Access Token.</b>
     *
     * <p>This widget shows always your current (newest / latest) cover image of your Facebook page.
     * It is meant to be used as header on top of your template design - or wherever it makes sense.
     * </p>
     *
     * @package    YAWK
     * @author     Daniel Retzl <danielretzl@gmail.com>
     * @copyright  2018 Daniel Retzl
     * @license    https://opensource.org/licenses/MIT
     * @version    1.0.0
     * @link       http://yawk.io
     * @annotation Facebook Cover widget - Embed current cover image from your Facebook page.
     */
class fbCover
{
    /** @var string your app ID (from developers.facebook.com) */
    public $fbCoverAppId = '';
    /** @var string your access token (secret word from developers.facebook.com) */
    public $fbCoverAccessToken = '';
    /** @var string css class to be set on the cover image */
    public $fbCoverImageClass = '';
    /** @var string image width in px or % */
    public $fbCoverImageWidth = '';
    /** @var string image height in px or % */
    public $fbCoverImageHeight = '';
    /** @var string any title you like (important for SEO) */
    public $fbCoverImageTitle = '';
    /** @var string any image alt tag you like (for screenreaders) */
    public $fbCoverImageAlt = '';
    /** @var string custom css style attributes */
    public $fbCoverImageStyle = '';
    /** @var string true|false was the js SDK loaded? */
    public $jsSDKLoaded = 'false';
    /** @var array array: holds the current widget settings */
    public $settings;
    /** @var object api result (as object) */
    public $apiObject; // ☻

    public function __construct($db)
    {
        // load this widget settings from db
        $widget = new \YAWK\widget();
        $this->settings = $widget->getWidgetSettingsArray($db);
        foreach ($this->settings as $property => $value)
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
    }

    public function checkAppId()
    {
        if (isset($this->fbCoverAppId) && (!empty($this->fbCoverAppId)))
        {
            if (is_numeric($this->fbCoverAppId))
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
        if (isset($this->fbCoverAccessToken) && (!empty($this->fbCoverAccessToken)))
        {
            if (is_string($this->fbCoverAccessToken))
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
                    appId      : '" . $this->fbCoverAppId . "',
                    xfbml      : true,
                    version    : 'v3.0'
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
        // prepare API call
        $json_link = "https://graph.facebook.com/v3.0/me?fields=cover&access_token={$this->fbCoverAccessToken}";
        // get json string
        $json = file_get_contents($json_link);

        // convert json to object
        return $this->apiObject = json_decode($json, true, 512, JSON_BIGINT_AS_STRING);
    }


    public function drawCoverImage()
    {
        $this->loadJSSDK();
        $this->makeApiCall();

        if (isset($this->fbCoverImageClass) && (empty($this->fbCoverImageClass)))
        {
            $this->fbCoverImageClass = "img-responsive";
        }

        if (isset($this->fbCoverImageAlt) && (!empty($this->fbCoverImageAlt)))
        {
            $altMarkup = " alt=\"$this->fbCoverImageAlt\"";
        }
        else
            {
                $altMarkup = '';
            }

        if (isset($this->fbCoverImageTitle) && (!empty($this->fbCoverImageTitle)))
        {
            $titleMarkup = " title=\"$this->fbCoverImageTitle\"";
        }
        else
            {
                $titleMarkup = '';
            }

        if (isset($this->fbCoverImageHeight) && (!empty($this->fbCoverImageHeight)))
        {
            $heightMarkup = " height=\"$this->fbCoverImageHeight;\"";
        }
        else
            {
                $heightMarkup = '';
            }

        if (isset($this->fbCoverImageWidth) && (!empty($this->fbCoverImageWidth)))
        {
            if (isset($heightMarkup) && (!empty($heightMarkup)))
            {
                $widthMarkup = " width=\"$this->fbCoverImageWidth\"";
            }
            else
                {
                    $widthMarkup = "width=\"$this->fbCoverImageWidth\"";
                }
        }
        else
            {
                $widthMarkup = '';
            }

        if (isset($this->fbCoverImageStyle) && (!empty($this->fbCoverImageStyle)))
        {
            $styleMarkup = " style=\"$this->fbCoverImageStyle\"";
        }
        else
            {
                $styleMarkup = '';
            }

        echo "<img src=\"".$this->apiObject['cover']['source']."\" class=\"$this->fbCoverImageClass\"$styleMarkup"."$heightMarkup"."$widthMarkup"."$altMarkup"."$titleMarkup>";
    }

}   // end class events
} // end namespace