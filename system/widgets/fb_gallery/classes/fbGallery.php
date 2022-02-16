<?php
namespace YAWK\WIDGETS\FACEBOOK\GALLERY
{
    /**
     * @details<b>Use Facebook Graph API to get album photos from a Facebook Page. Requires an App ID and a valid access token.</b>
     *
     * <p>With this widget, you are able to embed photos from your facebook page onto your website.
     * It helps you to keep your website up to date. Have you ever been bored of adding the same content twice?
     * If you change your facebook photo album the data on your website will be updated automatically. </p>
     *
     * <p>You need an APP ID, as well as a valid access token for the facebook page you want to embed photos from.
     * For reasons, you (respectively the app id / access token) needs administrative access rights to the facebook
     * page you want to grab photos from. Create a new fb gallery widget in the backend, enter app id, access token
     * and press save widget settings. The page reloads and your albums will get loaded into a select field.
     *
     * </p>
     *
     *
     * @author     Daniel Retzl <danielretzl@gmail.com>
     * @copyright  2018 Daniel Retzl
     * @version    1.0.0
     * @brief Facebook Gallery Widget - grab photos from your Facebook albums.
     */
    class fbGallery
    {
        /** @param string your app ID (from developers.facebook.com) */
        public $fbGalleryAppId = '';
        /** @param string your page ID (http://facebook.com/{YOURPAGEID} */
        public $fbGalleryAlbumId = '';
        /** @param string your access token (secret word from developers.facebook.com) */
        public $fbGalleryAccessToken = '';
        /** @param string your graph request (the Album ID) */
        public $fbGalleryGraphRequest = '/albums/';
        /** @param string fields that should be selected from facebook graph */
        public $fbGalleryFields = 'images,source,name,id';
        /** @param string show ITEMS of this time range */
        public $fbGalleryYearRange = '10';
        /** @param string user defined start date */
        public $fbGalleryStartDate = '';
        /** @param string user defined end date */
        public $fbGalleryEndDate = '';
        /** @param string which items should be shown? future|past|all */
        public $fbGalleryType = 'past';
        /** @param string gallery heading */
        public $fbGalleryHeading = '';
        /** @param string gallery small subtext beside heading */
        public $fbGallerySubtext = '';
        /** @param string ITEMS since this date (used for calc) */
        public $sinceDate = '';
        /** @param int limit entries to (n) */
        public $fbGalleryLimit = 0;
        /** @param string sortation */
        public $fbGallerySortation = 'desc';
        /** @param int layout */
        public $fbGalleryLayout = 6;
        /** @param int show info under the gallery? 0|1  */
        public $fbGalleryImageInfo = 1;
        /** @param string fixed image height in pixels or auto (select field) */
        public $fbGalleryFixedImageHeight = 'auto';
        /** @param int shuffle 0|1 if true, images get shuffled on page load */
        public $shuffle = 0;
        /** @param string ITEMS until this date (used for calc) */
        public $untilDate = '';
        /** @param string true|false was the js SDK loaded? */
        public $jsSDKLoaded = 'false';
        /** @param object api result (as object) */
        public $apiObject;
        /** @param array temporary settings array */
        public $settings;


        /**
         * @brief fbGallery constructor.
         * Get widget settings into this->settings array and call checkRequirements
         * @param $db
         */
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

        /**
         * @brief Check if all requirements are fulfilled to perform api call.
         */
        public function checkRequirements()
        {
            $this->checkAppId();
            $this->checkAccessToken();
            $this->checkAlbumId();
        }

        /**
         * @brief Check if App ID is set, not empty and numeric. Returns true if app ID is ok or abort with an error message.
         * @return bool
         */
        public function checkAppId()
        {   // check if App ID is set and not empty
            if (isset($this->fbGalleryAppId) && (!empty($this->fbGalleryAppId)))
            {   // is app ID a number for sure?
                if (is_numeric($this->fbGalleryAppId))
                {   // app id seems legit
                    return true;
                }
                else
                {   // app id not numeric, abort with error message
                    die ("app ID is set, but not a numeric value! Please check your app ID - it should contain numbers only.");
                }
            }
            else
            {   // app id not set or empty, abort with error message
                die ("app ID is not set. Please add your app ID. You can obtain it from http://developers.facebook.com");
            }
        }

        /**
         * @brief Check if access token is correctly set. Returns true or abort with an error message
         * @return bool
         */
        public function checkAccessToken()
        {   // check if access token is set and not empty
            if (isset($this->fbGalleryAccessToken) && (!empty($this->fbGalleryAccessToken)))
            {   // check if access token is a string
                if (is_string($this->fbGalleryAccessToken))
                {   // access token seems legit
                    return true;
                }
                else
                {   // access token is not a string, abort with error message
                    die ("Access token is set, but not a string value! Please check your access token.");
                }
            }
            else
            {   // access token is not set or empty, abort with error message
                die ("Access token is not set. Please add your access token. You can obtain it from http://developers.facebook.com/apps");
            }
        }

        /**
         * @brief Check if album id is correctly set. Returns true or abort with an error message
         * @return bool
         */
        public function checkAlbumId()
        {   // check if Album ID is set and not empty
            if (isset($this->fbGalleryAlbumId) && (!empty($this->fbGalleryAlbumId)))
            {   // check if album ID is a string
                if (is_string($this->fbGalleryAlbumId))
                {   // seems legit
                    return true;
                }
                else
                {   // album id is not a string, abort with error msg
                    die ("Album ID is set, but not a string value! Please check your photo album ID.");
                }
            }
            else
            {   // album id is not set or empty, abort with error msg
                die ("Album ID is not set. Please add your photo album ID.");
            }
        }

        /**
         * @brief Load Facebook JS Code.
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
                    appId      : '" . $this->fbGalleryAppId . "',
                    xfbml      : true,
                    version    : 'v3.3'
                    });
                FB.AppITEMS.logPageView();
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
                /*
                else
                {   // check app ID failed, abort with error msg (app id not set correctly)
                    die ("unable to include facebook js SDK - checkAppId failed. Please check your app ID in the widget settings!");
                }
                */
            }
        }

        /**
         * @brief Prepare object data, set json link, make API call and return apiObject
         * @return object
         */
        public function makeApiCall()
        {
            // WHICH ITEMS TO DISPLAY?
            // evaluation of event type select field
            if ($this->fbGalleryType == "all")
            {
                // ALL ITEMS (FUTURE + PAST)
                $this->sinceDate = date('Y-01-01', strtotime('-' . $this->fbGalleryYearRange . ' years'));
                $this->untilDate = date('Y-01-01', strtotime('+' . $this->fbGalleryYearRange . ' years'));
            }
            elseif ($this->fbGalleryType == "future")
            {
                // UPCOMING ITEMS
                $this->sinceDate = date('Y-m-d');
                $this->untilDate = date('Y-12-31', strtotime('+' . $this->fbGalleryYearRange . ' years'));
            }
            elseif ($this->fbGalleryType == "past")
            {
                // PAST ITEMS
                $this->sinceDate = date('Y-01-01', strtotime('-' . $this->fbGalleryYearRange . ' years'));
                $this->untilDate = date('Y-m-d');
            }
            else
            {   // IF NOT SET - use default:
                // UPCOMING ITEMS
                $this->sinceDate = date('Y-m-d');
                $this->untilDate = date('Y-12-31', strtotime('+' . $this->fbGalleryYearRange . ' years'));
            }

            // IF START + END DATE IS SET
            if (isset($this->fbGalleryStartDate) && (!empty($this->fbGalleryStartDate))
                && (isset($this->fbGalleryEndDate) && (!empty($this->fbGalleryEndDate))))
            {
                $this->sinceDate = date($this->fbGalleryStartDate);
                $this->untilDate = date($this->fbGalleryEndDate);
            }

            // unix timestamp years
            $since_unix_timestamp = strtotime($this->sinceDate);
            $until_unix_timestamp = strtotime($this->untilDate);

            // check if fields are set
            if (isset($this->fbGalleryFields) && (!empty($this->fbGalleryFields)))
            {   // set markup for api query string
                $fieldsMarkup = "?fields={$this->fbGalleryFields}";
            }
            else
            {   // no fields wanted, leave markup empty
                $fieldsMarkup = '';
            }

            // prepare API call - get photos
            $json_link = "https://graph.facebook.com/v3.3/{$this->fbGalleryAlbumId}/photos$fieldsMarkup&access_token={$this->fbGalleryAccessToken}";

            // get json string
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, $json_link);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            $this->apiObject = json_decode(curl_exec($curl), true, 512, JSON_BIGINT_AS_STRING);
            curl_close($curl);

            // $json = file_get_contents($json_link);
            // convert json to object
            return $this->apiObject;
        }

        /**
         * @brief Check if api object is set and not empty
         * @return bool returns true or false
         */
        public function checkApiObjectData()
        {   // check if object data is set and not empty
            if (isset($this->apiObject['data']) && (!empty($this->apiObject['data'])))
            {   // seems legit
                return true;
            }
            else
            {   // object not set or empty
                return false;
            }
        }

        /**
         * @brief The heart of this widget: this method draws the gallery.
         */
        public function drawGallery()
        {
            // load facebook JS
            $this->loadJSSDK();
            // make facebook api call
            $this->makeApiCall();

            /* ALBUM DETAILED VIEW */
            if (isset($this->apiObject['data']) && (!empty($this->apiObject))) {

                // check if array needs to be sorted
                if (is_string($this->fbGallerySortation) && ($this->fbGallerySortation == "desc"))
                {
                    // sort array ascending / descending
                    $this->apiObject['data'] = array_reverse($this->apiObject['data']);
                }

                // check if images needs to be shuffled
                elseif ($this->fbGallerySortation == "shuffle")
                {   // shuffle images on page load
                    shuffle($this->apiObject['data']);
                }

                // check if limit is set
                if ($this->fbGalleryLimit > 0 && ($this->fbGalleryLimit != 25))
                {   // limit images to x entries
                    $this->apiObject['data'] = array_slice($this->apiObject['data'], 0, $this->fbGalleryLimit);
                }

                // check gallery layout
                if (!isset($this->fbGalleryLayout) || (empty($this->fbGalleryLayout)))
                {   // if no layout is set, use this as default value
                    $this->fbGalleryLayout = 6;
                }

                // check heading
                if (isset($this->fbGalleryHeading) && (!empty($this->fbGalleryHeading)))
                {
                    // if heading is set, build markup
                    $this->fbGalleryHeading = "$this->fbGalleryHeading";
                }
                else
                    {   // no heading was set, leave empty
                        $this->fbGalleryHeading = '';
                    }

                // check subtext
                if (isset($this->fbGallerySubtext) && (!empty($this->fbGallerySubtext)))
                {
                    // if subtext is set, build markup
                    $this->fbGallerySubtext = "<small>$this->fbGallerySubtext</small>";
                }
                else
                {   // no subtext was set, leave empty
                    $this->fbGallerySubtext = '';
                }

                // draw heading + subtext
                echo "<div class=\"row padding\"><div class=\"col-md-12\"><h1>$this->fbGalleryHeading&nbsp;$this->fbGallerySubtext</h1></div></div>";


                $i = 0; // loop indicator
                // walk through data array to help animation (first items fadeIn on load)
                echo "<div class=\"row padding\">";
                foreach ($this->apiObject['data'] as $property => $value)
                {
                    // if loop runs for the first time
                    if (isset($i) && ($i <= 3))
                    {   // first element get this css class
                        $animateMarkup = 'animated fadeIn';
                    }
                    else
                        {   // all other items - set animate class on them
                            $animateMarkup = "animate";
                        }

                    $i++; // raise loop indicator

                    // check if image info is set
                    if (isset($this->fbGalleryImageInfo) && (!empty($this->fbGalleryImageInfo)))
                    {
                        // if image info is on
                        $this->fbGalleryImageInfo = $value['name'];
                    }
                    else
                        {   // leave image info empty
                            $this->fbGalleryImageInfo = '';
                        }

                    // random align images
                    $randomInt = rand(1,4);
                    if ($randomInt == 1)
                    {
                        $imgClass = "img-lefty";
                    }
                    elseif ($randomInt == 2)
                    {
                        $imgClass = "img-lefty-less";
                    }
                    elseif ($randomInt == 3)
                    {
                        $imgClass = "img-righty";
                    }
                    elseif ($randomInt == 4)
                    {
                        $imgClass = "img-righty-less";
                    }
                    /*
                    elseif ($randomInt == 5)
                    {
                        $imgClass = "img-thumbnail";
                    }
                    else
                        {   // default value:
                            $imgClass = "img-thumbnail";
                        }
                    */

                    // set filename to biggest image source
                    $fn = $value['images'][0]['source'];
                    // set layout div box, containing every single image
                    echo "<div class=\"col-md-$this->fbGalleryLayout text-center $animateMarkup\">
                          <a href=\"$fn\" data-lightbox=\"example-set\" data-title=\"$value[name]\">
                          <img src=\"$fn\" alt=\"$value[name]\" style=\"width:auto; height:$this->fbGalleryFixedImageHeight;\" class=\"img-thumbnail img-fluid ".$imgClass." hvr-grow\">
                          </a><br><br><small>$this->fbGalleryImageInfo</small><br><br><hr></div>";
                } // end foreach
                 echo "</div>";
            }
            else
                {   // api object not set or empty - abort with error
                    die("Unable to load Images from Facebook API because the apiObject is not set or empty.");
                }
        }

    }   // end class fbGallery
} // end namespace