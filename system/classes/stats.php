<?php
namespace YAWK
{

    use YAWK\PLUGINS\MESSAGES\messages;

    class stats
    {
        public $id;
        public $uid;
        public $gid;
        public $logged_in;
        public $acceptLanguage;
        public $remoteAddr;
        public $userAgent;
        public $device;
        public $deviceType;
        public $os;
        public $osVersion;
        public $browser;
        public $browserVersion;
        public $date_created;
        public $referer;
        public $page;

        function construct()
        {
            // ...
        }
        function setStats($db)
        {   /* @var $db \YAWK\db */
            // check if stats are enabled
            if (\YAWK\settings::getSetting($db, "statsEnable") === "1")
            {   // prepare user information that we can easily collect
                $this->prepareData();
                // insert statistics into database
                if ($this->insertData($db) === false)
                {   // insert stats failed, add syslog entry
                    \YAWK\sys::setSyslog($db, 12, "could not insert stats into database.", "", "", "","");
                }
            }
        }

        function prepareData()
        {
            // check if a session is set
            if (isset($_SESSION) && (!empty($_SESSION)))
            {   // prepare all session user data
                // user id (if logged in)
                $this->uid = $_SESSION['uid'];
                // user group id (if logged in)
                $this->gid = $_SESSION['gid'];
                // user logged in status (0|1)
                $this->logged_in = $_SESSION['logged_in'];
            }
            else
                {   // no session is set
                    // user is a guest - or obviously not logged in
                    $this->uid = 0;
                    $this->gid = 0;
                    $this->logged_in = 0;
                }
            // user IP address
            $this->remoteAddr = $_SERVER['REMOTE_ADDR'];
            // user client username
            // $this->remoteUser = $_SERVER['REMOTE_HOST'];
            // user agent information
            $this->userAgent = $_SERVER['HTTP_USER_AGENT'];
            // user browser

            // Include and instantiate the class.
            require_once 'system/engines/mobiledetect/Mobile_Detect.php';
            $detect = new \Mobile_Detect;

            $this->deviceType = ($detect->isMobile() ? ($detect->isTablet() ? 'Tablet' : 'Phone') : 'Desktop');

            // Any mobile device (phones or tablets).
            if ( $detect->isMobile() ) {
                // $this->deviceType = "Mobile";
                $browser = array();
                $browser = \YAWK\sys::getBrowser($this->userAgent);
                $this->browser = $browser['name'];
                $this->browserVersion = $browser['version'];
            }

            // Any tablet device.
            if( $detect->isTablet() ){
                // $this->deviceType = "Tablet";
                $browser = array();
                $browser = \YAWK\sys::getBrowser($this->userAgent);
                $this->browser = $browser['name'];
                $this->browserVersion = $browser['version'];
            }

            // No Mobile, no tablet - must be a computer
            if( !$detect->isMobile() && !$detect->isTablet() ){
                // $this->deviceType = "Computer";
                $browser = array();
                $browser = \YAWK\sys::getBrowser($this->userAgent);
                $this->browser = $browser['name'];
                $this->browserVersion = $browser['version'];
                $this->os = ucfirst($browser['platform']);
                $this->osVersion = \YAWK\sys::getOS($this->userAgent);
            }

            // check OS for iOS
            if( $detect->isiOS() ){
                $this->os = "iOS";
                // detect wheter its a phone, pad or pod
                if ( $detect->version('iPhone') ) {
                    $this->device = "iPhone";
                    $this->osVersion = $detect->version('iPhone');
                }
                if ( $detect->version('iPad') ) {
                    $this->device = "iPad";
                    $this->osVersion = $detect->version('iPad');
                }
                if ( $detect->version('iPod') ) {
                    $this->device = "iPod";
                    $this->osVersion = $detect->version('iPod');
                }
            }
            else
                {   // check OS for android
                    if( $detect->isAndroidOS() ){
                        $this->os = "Android";
                        $this->osVersion = $detect->version('Android');
                    }
                }

            // set remote user
            $this->acceptLanguage = $_SERVER['HTTP_ACCEPT_LANGUAGE'];

            // the referer page from which the user came
            if (!isset($_SERVER['HTTP_REFERER']) || (empty($_SERVER['HTTP_REFERER'])))
            {   // empty referer
                $this->referer = '';
            }
            else
                {   // set referer
                    $this->referer = $_SERVER['HTTP_REFERER'];
                }
            // check if include (page request) is set
            if (!isset($_GET['include']) || (empty($_GET['include'])))
            {   // if no page is set, take server variable
                $this->page = $_SERVER['REQUEST_URI'];
            }
            else
                {   // set requested page
                    $this->page = $_GET['include'];
                }

            // current datetime
            $this->date_created = \YAWK\sys::now();
        }


        static function countMessages($db)
        {   /* @var $db \YAWK\db */
            if ($res = $db->query("SELECT COUNT(*) FROM {plugin_msg}"))
            {   // fetch and return how many messages have been sent
                $messageCount = mysqli_fetch_row($res);
                return $messageCount[0];
            }
            else
                {
                    $messageCount = "db error: could not count messages";
                    return $messageCount;
                }
        }


        static function getJsonBrowsers($db, $browsers)
        {   /* @var $db \YAWK\db */
            // check if browsers are set
            if (!isset($browsers) || (empty($browsers)))
            {   // nope, get them from db
                $browsers = self::countBrowsers($db, 200);
            }
            $jsonData = "[";
            foreach ($browsers AS $browser => $value)
            {
                // init textcolor
                $textcolor = '';
                // set different colors for each browser
                if ($browser === "Chrome") { $textcolor = "#f56954"; }
                if ($browser === "IE") { $textcolor = "#00a65a"; }
                if ($browser === "Firefox") { $textcolor = "#f39c12"; }
                if ($browser === "Safari") { $textcolor = "#00c0ef"; }
                if ($browser === "Opera") { $textcolor = "#3c8dbc"; }
                if ($browser === "Netscape") { $textcolor = "#d2d6de"; }
                if ($browser === "Others") { $textcolor = "#cccccc"; }

                // only browsers, not the total value
                if ($browser !== ("Total"))
                {
                    $jsonData .= "
                            {
                                value: $value,
                                color: \"$textcolor\",
                                highlight: \"$textcolor\",
                                label: \"$browser\"
                            },";
                }
            }

            $jsonData .= "]";
            echo $jsonData;
        }

        static function getBrowserColors($browser)
        {
            switch ($browser) {
                case "Chrome":
                    $textcolor = "text-red";
                    break;
                case "IE":
                    $textcolor = "text-green";
                    break;
                case "Firefox":
                    $textcolor = "text-yellow";
                    break;
                case "Safari":
                    $textcolor = "text-aqua";
                    break;
                case "Opera":
                    $textcolor = "text-light-blue";
                    break;
                case "Netscape":
                    $textcolor = "text-grey";
                    break;
                default:
                    $textcolor = "text-grey";
            }
            return $textcolor;
        }


        static function countBrowsers($db, $limit)
        {   /* @var $db \YAWK\db */

            // check if limit (i) is set
            if (!isset($limit) || (empty($limit)))
            {   // set default value
                $limit = 100;
            }

            // this vars stores the counting for each browser
            $msie = 0;
            $chrome = 0;
            $firefox = 0;
            $opera = 0;
            $safari = 0;
            $netscape = 0;
            $others = 0;
            $total = 0;

            // get browsers from db
            if ($res = $db->query("SELECT browser FROM {stats} ORDER BY id DESC LIMIT $limit"))
            {   // create array
                $browserlist = array();
                while ($row = mysqli_fetch_assoc($res))
                {   // add to array
                    $browserlist[] = $row;
                    $total++;
                }

                // count browsers
                foreach ($browserlist AS $browser) {   // add +1 for each found
                    switch ($browser['browser']) {
                        case "Google Chrome":
                            $chrome++;
                            break;
                        case "Internet Explorer":
                            $msie++;
                            break;
                        case "Mozilla Firefox":
                            $firefox++;
                            break;
                        case "Apple Safari":
                            $safari++;
                            break;
                        case "Opera":
                            $opera++;
                            break;
                        case "Netscape":
                            $netscape++;
                            break;
                        default:
                            $others++;
                    }
                }
                // build an array, cointaining the browsers and the number how often it's been found
                $browsers = array(
                    "Chrome" => $chrome,
                    "IE" => $msie,
                    "Firefox" => $firefox,
                    "Safari" => $safari,
                    "Opera" => $opera,
                    "Netscape" => $netscape,
                    "Others" => $others,
                    "Total" => $total
                );
                return $browsers;
            }
            else
                {
                    return false;
                }
        }

        function insertData($db)
        {   /* @var $db \YAWK\db */
            if ($db->query("INSERT INTO {stats} 
                                    (uid, 
                                     gid, 
                                     logged_in, 
                                     acceptLanguage, 
                                     remoteAddr, 
                                     userAgent, 
                                     device,  
                                     deviceType, 
                                     os,
                                     osVersion,
                                     browser, 
                                     browserVersion, 
                                     date_created, 
                                     referer, 
                                     page)
                            VALUES ('".$this->uid."', 
                                   '".$this->gid."', 
                                   '".$this->logged_in."', 
                                   '".$this->acceptLanguage."', 
                                   '".$this->remoteAddr."',
                                   '".$this->userAgent."', 
                                   '".$this->device."', 
                                   '".$this->deviceType."', 
                                   '".$this->os."', 
                                   '".$this->osVersion."', 
                                   '".$this->browser."', 
                                   '".$this->browserVersion."', 
                                   '".$this->date_created."', 
                                   '".$this->referer."', 
                                   '".$this->page."')"))
            {
                return true;
            }
            else
                {
                    return false;
                }
        }
    }
}