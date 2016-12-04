<?php

namespace YAWK
{

    /**
     * Class stats
     * @package YAWK
     *
     */
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


        // stats variables
        public $i_hits = 0;
        public $i_loggedUsers = 0;
        public $i_loggedUsersPercentage = 0;
        public $i_publicUsers = 0;
        public $i_publicUsersPercentage = 0;

        // os types
        public $i_osWindows = 0;
        public $i_osMac = 0;
        public $i_osLinux = 0;
        public $i_osAndroid = 0;
        public $i_iOS = 0;
        public $i_osUnknown = 0;

        // os versions
        public $i_windows8 = 0;
        public $i_windows7 = 0;
        public $i_windowsVista = 0;
        public $i_windowsServer = 0;
        public $i_windowsXP = 0;
        public $i_windows2000 = 0;
        public $i_windowsME = 0;
        public $i_windows98 = 0;
        public $i_windows95 = 0;
        public $i_windows311 = 0;
        public $i_macosX = 0;
        public $i_macos9 = 0;
        public $i_linux = 0;
        public $i_ubuntu = 0;
        public $i_iPhone = 0;
        public $i_iPod = 0;
        public $i_iPad = 0;
        public $i_android = 0;
        public $i_blackberry = 0;
        public $i_mobile = 0;
        public $i_others = 0;

        // devices
        public $i_desktop = 0;
        public $i_tablet = 0;
        public $i_phone = 0;

        // logins
        public $i_totalLogins = 0;
        public $i_loginSuccessful = 0;
        public $i_loginFailed = 0;
        public $i_loginFrontend = 0;
        public $i_loginBackend = 0;
        public $i_loginBackendSuccess = 0;
        public $i_loginBackendFailed = 0;
        public $i_loginFrontendSuccess = 0;
        public $i_loginFrontendFailed = 0;
        public $i_loginSuccessPercentage = 0;
        public $i_loginFailedPercentage = 0;

        // date + time
        public $i_morning = 0;
        public $i_afternoon = 0;
        public $i_evening = 0;
        public $i_night = 0;
        public $i_morningPercent = 0;
        public $i_afternoonPercent = 0;
        public $i_eveningPercent = 0;
        public $i_nightPercent = 0;

        // weekdays
        public $i_monday = 0;
        public $i_tuesday = 0;
        public $i_wednesday = 0;
        public $i_thursday = 0;
        public $i_friday = 0;
        public $i_saturday = 0;
        public $i_sunday = 0;
        public $i_totalDays = 0;

        public $i_mondayPercent = 0;
        public $i_tuesdayPercent = 0;
        public $i_wednesdayPercent = 0;
        public $i_thursdayPercent = 0;
        public $i_fridayPercent = 0;
        public $i_saturdayPercent = 0;
        public $i_sundayPercent = 0;

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

        public function countLogins($db, $limit)
        {   /* @var $db \YAWK\db */
            if (!isset($limit) || (empty($limit)))
            {
                $limit = 100;
            }
            if ($res = $db->query("SELECT * FROM {logins} LIMIT $limit"))
            {   // fetch and return how many messages have been sent
                $loginDataArray = array();
                // count login data
                while ($row = mysqli_fetch_assoc($res))
                {
                    // GET AN ARRAY CONTAINING ALL DATA FROM LOGIN DB
                    // $loginDataArray[] = $row;

                    // count +1 to all logins
                    $this->i_totalLogins++;

                    // count frontend logins
                    if ($row['location'] === "frontend")
                    {
                        // add total frontendlogins +1
                        $this->i_loginFrontend++;
                        if ($row['failed'] === "1")
                        {   // frontend login failed +1
                            $this->i_loginFrontendFailed++;
                        }
                        else
                            {   // frontend login success +1
                                $this->i_loginFrontendSuccess++;
                            }
                    }
                    // count backend logins
                    if ($row['location'] === "backend")
                    {   // add total backend login +1
                        $this->i_loginBackend++;
                        if ($row['failed'] === "1")
                        {   // backend login failed +1
                            $this->i_loginBackendFailed++;
                        }
                        else
                            {   // backend login success +1
                                $this->i_loginBackendSuccess++;
                            }
                    }
                    // total success logins +1
                    if ($row['failed'] === "0")
                    {   // success +1
                        $this->i_loginSuccessful++;
                    }
                    // total failed logins +1
                    if ($row['failed'] === "1")
                    {   // failed +1
                        $this->i_loginFailed++;
                    }
                }
                // calculate percentage
                $total = $this->i_totalLogins;
                $failed = $this->i_loginFailed;
                $success = $this->i_loginSuccessful;
                $total = 100 / $total;
                $this->i_loginFailedPercentage = round($total * $failed);
                $this->i_loginSuccessPercentage = round($total * $success);


                // build an array, cointaining the failed and successful logins
                $loginDataArray = array(
                    "Failed" => $this->i_loginFailed,
                    "Successful" => $this->i_loginSuccessful,
                    "BackendSuccess" => $this->i_loginBackendSuccess,
                    "BackendFailed" => $this->i_loginBackendFailed,
                    "FrontendSuccess" => $this->i_loginFrontendSuccess,
                    "FrontendFailed" => $this->i_loginFrontendFailed,
                    "FailedPercentage" => $this->i_loginFailedPercentage,
                    "SuccessPercentage" => $this->i_loginSuccessPercentage,
               //     "Frontend" => $this->i_loginFrontend,
               //     "Backend" => $this->i_loginBackend,
                    "Total" => $this->i_totalLogins
                );
                return $loginDataArray;
            }
            else
            {
                \YAWK\alert::draw("warning", "Could not get login data array.", "error getting data into array", "", 5200);
                return false;
            }
        }


        static function getJsonLogins($db, $logins)
        {   /* @var $db \YAWK\db */
            // check if logins are set
            if (!isset($logins) || (empty($logins)))
            {   // nope, get them from db
                $logins = self::countLogins($db, 200);
            }
            $jsonData = "[";
            foreach ($logins AS $login => $value)
            {
                // init textcolor
                $textcolor = '';
                // set different colors for each status
                if ($login === "Failed") { $textcolor = "#f56954"; }
                if ($login === "Successful") { $textcolor = "#00a65a"; }
               //  if ($login === "Backend") { $textcolor = "#f39c12"; }
               //  if ($login === "Frontend") { $textcolor = "#00c0ef"; }

                // only failed + successful logins, exclude all other values
                if ($login !== ("Total") && ($login === ("Failed") || ($login === ("Successful"))))
                {
                    $jsonData .= "
                            {
                                value: $value,
                                color: \"$textcolor\",
                                highlight: \"$textcolor\",
                                label: \"$login\"
                            },";
                }
            }

            $jsonData .= "]";
            echo $jsonData;
        }


        static function getJsonDaytimePieChart($db, $daytimes)
        {   /* @var $db \YAWK\db */
            // check if logins are set
            if (!isset($daytimes) || (empty($daytimes)))
            {   // nope, get them from db
                $daytimes = self::countDaytime($db, '', 200);
            }
            $jsonData = "[";
            foreach ($daytimes AS $daytime => $value)
            {
                // init textcolor
                $textcolor = '';
                // set different colors for each status
                if ($daytime === "Morning") { $textcolor = "#f39c12"; }
                if ($daytime === "Afternoon") { $textcolor = "#00a65a"; }
                if ($daytime === "Evening") { $textcolor = "#00c0ef"; }
                if ($daytime === "Night") { $textcolor = "#003D4C"; }

                // only failed + successful logins, exclude all other values
                if ($daytime !== ("Total") &&
                    ($daytime === ("Morning") ||
                    ($daytime === ("Afternoon") ||
                    ($daytime === ("Evening") ||
                    ($daytime === ("Night"))))))
                {
                    $jsonData .= "
                            {
                                value: $value,
                                color: \"$textcolor\",
                                highlight: \"$textcolor\",
                                label: \"$daytime\"
                            },";
                }
            }

            $jsonData .= "]";
            echo $jsonData;
        }

        public function getJsonDaytimeLineChart($db, $daytimes)
        {   /* @var $db \YAWK\db */
            // check if device types are set
            if (!isset($daytimes) || (empty($daytimes)))
            {   // nope, get them from db
                $daytimes = $this->countDaytime($db, '', 200);
            }

            $jsonData = "labels: ['Morning', 'Afternoon', 'Evening', 'Night'],
            datasets: [
                {
                  label: 'Hits',
                  fillColor: ['#f39c12', '#00a65a', '#00c0ef', '#003D4C'],
                  strokeColor: 'rgba(210, 214, 222, 1)',
                  pointColor: 'rgba(210, 214, 222, 1)',
                  pointStrokeColor: '#c1c7d1',
                  pointHighlightFill: '#fff',
                  pointHighlightStroke: 'rgba(220,220,220,1)',  
                  data: [$this->i_morning, $this->i_afternoon, $this->i_evening, $this->i_night]
                }
            ]";
            echo $jsonData;
        }


        public function getJsonDaytimeBarChart($db, $daytimes)
        {   /* @var $db \YAWK\db */
            // check if device types are set
            if (!isset($daytimes) || (empty($daytimes)))
            {   // nope, get them from db
                $daytimes = $this->countDaytime($db, '', 200);
            }

            $jsonData = "labels: ['Morning', 'Afternoon', 'Evening', 'Night'],
            datasets: [
                {
                  label: 'Hits',
                  fillColor: ['#f39c12', '#00a65a', '#00c0ef', '#003D4C'],
                  strokeColor: 'rgba(210, 214, 222, 1)',
                  pointColor: 'rgba(210, 214, 222, 1)',
                  pointStrokeColor: '#c1c7d1',
                  pointHighlightFill: '#fff',
                  pointHighlightStroke: 'rgba(220,220,220,1)',  
                  data: [$this->i_morning, $this->i_afternoon, $this->i_evening, $this->i_night]
                }
            ]";
            echo $jsonData;
        }

        public function getJsonWeekdayBarChart()
        {   /* @var $db \YAWK\db */
             $jsonData = "labels: ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'],
            datasets: [
                {
                  label: 'Hits',
                  fillColor: ['#ebebeb', '#ebebeb', '#ebebeb', '#ebebeb', '#ebebeb', '#ebebeb', '#ebebeb'],
                  strokeColor: 'rgba(210, 214, 222, 1)',
                  pointColor: 'rgba(210, 214, 222, 1)',
                  pointStrokeColor: '#c1c7d1',
                  pointHighlightFill: '#fff',
                  pointHighlightStroke: 'rgba(220,220,220,1)',  
                  data: [$this->i_monday, $this->i_tuesday, $this->i_wednesday, $this->i_thursday, $this->i_friday, $this->i_saturday, $this->i_sunday]
                }
            ]";
            echo $jsonData;
        }

        static function getJsonBrowsers($db, $browsers)
        {   /* @var $db \YAWK\db */
            // check if browsers are set
            if (!isset($browsers) || (empty($browsers)))
            {   // nope, get them from db
                $browsers = self::countBrowsers($db, '', 200);
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


        static function getJsonOS($db, $oss)
        {   /* @var $db \YAWK\db */
            // check if browsers are set
            if (!isset($oss) || (empty($oss)))
            {   // nope, get them from db
                $oss = self::countOS($db, '', 200);
            }
            $jsonData = "[";
            foreach ($oss AS $os => $value)
            {
                // init textcolor
                $textcolor = '';
                // set different colors for each browser
                if ($os === "Windows") { $textcolor = "#00c0ef"; }
                if ($os === "Linux") { $textcolor = "#f56954"; }
                if ($os === "Mac") { $textcolor = "#f39c12"; }
                if ($os === "Android") { $textcolor = "#00a65a"; }
                if ($os === "iOS") { $textcolor = "#000000"; }
                if ($os === "Unknown") { $textcolor = "#cccccc"; }

                // only browsers, not the total value
                if ($os !== ("Total"))
                {
                    $jsonData .= "
                            {
                                value: $value,
                                color: \"$textcolor\",
                                highlight: \"$textcolor\",
                                label: \"$os\"
                            },";
                }
            }

            $jsonData .= "]";
            echo $jsonData;
        }

        static function getJsonOSVersions($db, $osVersions)
        {   /* @var $db \YAWK\db */
            // check if browsers are set
            if (!isset($osVersions) || (empty($osVersions)))
            {   // nope, get them from db
                $osVersions = self::countOSVersions($db, '', 200);
            }
            $jsonData = "[";
            foreach ($osVersions AS $osVersion => $value)
            {
                // init textcolor
                $textcolor = '';
                // set different colors for each OS version
                if ($osVersion === "Windows 8") { $textcolor = "#00c0ef"; }
                if ($osVersion === "Windows 7") { $textcolor = "#00A0C7"; }
                if ($osVersion === "Windows Vista") { $textcolor = "#00B5E1"; }
                if ($osVersion === "Windows Server") { $textcolor = "#004E61"; }
                if ($osVersion === "Windows 2000") { $textcolor = "#005A7F"; }
                if ($osVersion === "Windows XP") { $textcolor = "#00B5FF"; }
                if ($osVersion === "Windows ME") { $textcolor = "#0090C9"; }
                if ($osVersion === "Windows 98") { $textcolor = "#00A5E5"; }
                if ($osVersion === "Windows 95") { $textcolor = "#0089BF"; }
                if ($osVersion === "Windows 3.11") { $textcolor = "#00ACBF"; }
                if ($osVersion === "Mac OS X") { $textcolor = "#f39c12"; }
                if ($osVersion === "Mac OS 9") { $textcolor = "#BD7A0E"; }
                if ($osVersion === "Linux") { $textcolor = "#f56954"; }
                if ($osVersion === "Ubuntu") { $textcolor = "#BF5242"; }
                if ($osVersion === "iPhone") { $textcolor = "#212121"; }
                if ($osVersion === "iPad") { $textcolor = "#131313"; }
                if ($osVersion === "iPod") { $textcolor = "#212121"; }
                if ($osVersion === "Android") { $textcolor = "#6FF576"; }
                if ($osVersion === "Blackberry") { $textcolor = "#187521"; }
                if ($osVersion === "Mobile") { $textcolor = "#437540"; }
                if ($osVersion === "Unknown") { $textcolor = "#6B756D"; }

                // only browsers, not the total value
                if ($osVersion !== ("Total"))
                {
                    $jsonData .= "
                            {
                                value: $value,
                                color: \"$textcolor\",
                                highlight: \"$textcolor\",
                                label: \"$osVersion\"
                            },";
                }
            }

            $jsonData .= "]";
            echo $jsonData;
        }


        public function getJsonDeviceTypes($db, $deviceTypes)
        {   /* @var $db \YAWK\db */
            // check if device types are set
            if (!isset($deviceTypes) || (empty($deviceTypes)))
            {   // nope, get them from db
                $deviceTypes = self::countDeviceTypes($db, '', 200);
            }

            $jsonData = "labels: ['Desktop', 'Phone', 'Tablet'],
            datasets: [
                {
                  label: 'Hits',
                  fillColor: ['#f39c12', '#00a65a', '#00c0ef'],
                  strokeColor: 'rgba(210, 214, 222, 1)',
                  pointColor: 'rgba(210, 214, 222, 1)',
                  pointStrokeColor: '#c1c7d1',
                  pointHighlightFill: '#fff',
                  pointHighlightStroke: 'rgba(220,220,220,1)',
                  data: [$this->i_desktop, $this->i_phone, $this->i_tablet]
                }
            ]";
            echo $jsonData;
        }




        static function getBrowserColors($browser)
        {
            switch ($browser) {
                case "Chrome":
                    $textcolor = "text-red";
                    break;
                case "Google Chrome":
                    $textcolor = "text-red";
                    break;
                case "IE":
                    $textcolor = "text-green";
                    break;
                case "Internet Explorer":
                    $textcolor = "text-green";
                    break;
                case "Firefox":
                    $textcolor = "text-yellow";
                    break;
                case "Mozilla Firefox":
                    $textcolor = "text-yellow";
                    break;
                case "Safari":
                    $textcolor = "text-aqua";
                    break;
                case "Apple Safari":
                    $textcolor = "text-aqua";
                    break;
                case "Opera":
                    $textcolor = "text-light-blue";
                    break;
                case "Netscape":
                    $textcolor = "text-grey";
                    break;
                case "Navigator":
                    $textcolor = "text-grey";
                    break;
                default:
                    $textcolor = "text-black";
            }
            return $textcolor;
        }


        static function getOsColors($os)
        {
            switch ($os) {
                case "Windows":
                    $textcolor = "text-blue";
                    break;
                case "Linux":
                    $textcolor = "text-red";
                    break;
                case "Mac":
                    $textcolor = "text-orange";
                    break;
                case "Android":
                    $textcolor = "text-green";
                    break;
                case "Unknown":
                    $textcolor = "text-grey";
                    break;
                default:
                    $textcolor = "text-black";
            }
            return $textcolor;
        }


        static function getDeviceTypeColors($deviceType)
        {
            switch ($deviceType) {
                case "Desktop":
                    $textcolor = "text-orange";
                    break;
                case "Phone":
                    $textcolor = "text-green";
                    break;
                case "Tablet":
                    $textcolor = "text-blue";
                    break;
                default:
                    $textcolor = "text-black";
            }
            return $textcolor;
        }

        static function getDaytimeColors($daytime)
        {
            switch ($daytime) {
                case "Morning":
                    $textcolor = "text-orange";
                    break;
                case "Afternoon":
                    $textcolor = "text-green";
                    break;
                case "Evening":
                    $textcolor = "text-blue";
                    break;
                case "Night":
                    $textcolor = "text-navy";
                    break;
                default:
                    $textcolor = "text-black";
            }
            return $textcolor;
        }

        static function getLoginColors($login)
        {
            switch ($login) {
                case "Failed":
                    $textcolor = "text-red";
                    break;
                case "FailedPercentage":
                    $textcolor = "text-red";
                    break;
                case "SuccessPercentage":
                    $textcolor = "text-green";
                    break;
                case "Successful":
                    $textcolor = "text-green";
                    break;
                case "Frontend":
                    $textcolor = "text-blue";
                    break;
                case "Backend":
                    $textcolor = "text-orange";
                    break;
                default:
                    $textcolor = "text-black";
            }
            return $textcolor;
        }


        static function getOsVersionsColors($osVersions)
        {
            switch ($osVersions) {
                case "Windows 8":
                    $textcolor = "text-blue";
                    break;
                case "Windows 7":
                    $textcolor = "text-blue";
                    break;
                case "Windows Vista":
                    $textcolor = "text-blue";
                    break;
                case "Windows Server":
                    $textcolor = "text-blue";
                    break;
                case "Windows 2000":
                    $textcolor = "text-blue";
                    break;
                case "Windows XP":
                    $textcolor = "text-blue";
                    break;
                case "Windows ME":
                    $textcolor = "text-blue";
                    break;
                case "Windows 98":
                    $textcolor = "text-blue";
                    break;
                case "Windows 95":
                    $textcolor = "text-blue";
                    break;
                case "Windows 3.11":
                    $textcolor = "text-blue";
                    break;
                case "Windows 311":
                    $textcolor = "text-blue";
                    break;
                case "Mac OS X":
                    $textcolor = "text-orange";
                    break;
                case "Mac OS 9":
                    $textcolor = "text-orange";
                    break;
                case "Linux":
                    $textcolor = "text-red";
                    break;
                case "Ubuntu":
                    $textcolor = "text-red";
                    break;
                case "iPhone":
                    $textcolor = "text-black";
                    break;
                case "iPad":
                    $textcolor = "text-black";
                    break;
                case "iPod":
                    $textcolor = "text-black";
                    break;
                case "Android":
                    $textcolor = "text-green";
                    break;
                case "Blackberry":
                    $textcolor = "text-green";
                    break;
                case "Mobile":
                    $textcolor = "text-green";
                    break;
                case "Unknown":
                    $textcolor = "text-grey";
                    break;
                default:
                    $textcolor = "text-black";
            }
            return $textcolor;
        }


        public function countWeekdays($db, $data, $limit)
        {   /* @var $db \YAWK\db */

            // check if limit (i) is set
            if (!isset($limit) || (empty($limit)))
            {   // set default value
                $limit = 100;
            }

            // check if data array is set, if not load data from db
            if (!isset($data) || (empty($data) || (!is_array($data))))
            {   // data is not set or in false format, try to get it from database
                if ($res = $db->query("SELECT date_created FROM {stats} ORDER BY id DESC LIMIT $limit"))
                {   // create array
                    $data = array();
                    while ($row = mysqli_fetch_assoc($res))
                    {   // add data to array
                        $data[] = $row;
                    }
                }
                else
                {   // data array not set and unable to get data from db
                    return false;
                }
            }

            // LIMIT the data to x entries
            if (isset($limit) && (!empty($limit)))
            {   // if limit is set, cut array to limited range
                $data = array_slice($data, 0, $limit, true);
            }

            // break up the date & extract the hour to calculate
            foreach ($data as $date => $value)
            {
                $weekday = \YAWK\sys::getWeekday($value['date_created']);

                // identify days
                if ($weekday === "Monday" ||
                    ($weekday === "Montag"))
                {
                    $this->i_monday++;
                }
                elseif ($weekday === "Tuesday" ||
                    ($weekday === "Dienstag"))
                {
                    $this->i_tuesday++;
                }
                elseif ($weekday === "Wednesday" ||
                    ($weekday === "Mittwoch"))
                {
                    $this->i_wednesday++;
                }
                elseif ($weekday === "Thursday" ||
                    ($weekday === "Donnerstag"))
                {
                    $this->i_thursday++;
                }
                elseif ($weekday === "Friday" ||
                    ($weekday === "Freitag"))
                {
                    $this->i_friday++;
                }
                elseif ($weekday === "Saturday" ||
                    ($weekday === "Samstag"))
                {
                    $this->i_saturday++;
                }
                elseif ($weekday === "Sunday" ||
                    ($weekday === "Sonntag"))
                {
                    $this->i_sunday++;
                }
            }

            // count daytimes
            $this->i_totalDays = $this->i_monday
                    +$this->i_tuesday
                    +$this->i_wednesday
                    +$this->i_thursday
                    +$this->i_friday
                    +$this->i_saturday
                    +$this->i_sunday;

            // build an array, cointaining the daytimes
            $weekdays = array(
                "Monday" => $this->i_monday,
                "Tuesday" => $this->i_tuesday,
                "Wednesday" => $this->i_wednesday,
                "Thursday" => $this->i_thursday,
                "Friday" => $this->i_friday,
                "Saturday" => $this->i_saturday,
                "Sunday" => $this->i_sunday,
                "Total" => $this->i_totalDays
            );

            // return OS data array
            return $weekdays;
        }

        public function getWeekdaysPercent()
        {
            // calculate percentage
            $a = 100 / $this->i_totalDays;
            $this->i_mondayPercent = round($a * $this->i_monday);
            $this->i_tuesdayPercent = round($a * $this->i_tuesday);
            $this->i_wednesdayPercent = round($a * $this->i_wednesday);
            $this->i_thursdayPercent = round($a * $this->i_thursday);
            $this->i_fridayPercent = round($a * $this->i_friday);
            $this->i_saturdayPercent = round($a * $this->i_saturday);
            $this->i_sundayPercent = round($a * $this->i_sunday);

            // build an array, cointaining the device types and the number how often it's been found
            $weekdaysPercent = array(
                "Monday" => $this->i_mondayPercent,
                "Tuesday" => $this->i_tuesdayPercent,
                "Wednesday" => $this->i_wednesdayPercent,
                "Thursday" => $this->i_thursdayPercent,
                "Friday" => $this->i_fridayPercent,
                "Saturday" => $this->i_saturdayPercent,
                "Sunday" => $this->i_sundayPercent
            );
            arsort($weekdaysPercent);
            return $weekdaysPercent;
        }

        public function countDaytime($db, $data, $limit)
        {   /* @var $db \YAWK\db */

            // check if limit (i) is set
            if (!isset($limit) || (empty($limit)))
            {   // set default value
                $limit = 100;
            }

            // check if data array is set, if not load data from db
            if (!isset($data) || (empty($data) || (!is_array($data))))
            {   // data is not set or in false format, try to get it from database
                if ($res = $db->query("SELECT date_created FROM {stats} ORDER BY id DESC LIMIT $limit"))
                {   // create array
                    $data = array();
                    while ($row = mysqli_fetch_assoc($res))
                    {   // add data to array
                        $data[] = $row;
                    }
                }
                else
                {   // data array not set and unable to get data from db
                    return false;
                }
            }

            // LIMIT the data to x entries
            if (isset($limit) && (!empty($limit)))
            {   // if limit is set, cut array to limited range
                $data = array_slice($data, 0, $limit, true);
            }

            // break up the date & extract the hour to calculate
            foreach ($data as $date => $value)
            {
                // get only the hour in a new array
                $hour = substr($value['date_created'], 11, -6);

                // identify morning, afternoon, evening + night
                if ($hour === "06" ||
                    ($hour === "07") ||
                    ($hour === "08") ||
                    ($hour === "09") ||
                    ($hour === "10") ||
                    ($hour === "11"))
                {
                    $this->i_morning++;
                }
                if ($hour === "12" ||
                    ($hour === "13") ||
                    ($hour === "14") ||
                    ($hour === "15") ||
                    ($hour === "16") ||
                    ($hour === "17"))
                {
                    $this->i_afternoon++;
                }
                if ($hour === "18" ||
                    ($hour === "19") ||
                    ($hour === "20") ||
                    ($hour === "21") ||
                    ($hour === "22") ||
                    ($hour === "23"))
                {
                    $this->i_evening++;
                }
                if ($hour === "00" ||
                    ($hour === "01") ||
                    ($hour === "02") ||
                    ($hour === "03") ||
                    ($hour === "04") ||
                    ($hour === "05"))
                {
                    $this->i_night++;
                }
            }

            // count daytimes
            $total = $this->i_morning+$this->i_afternoon+$this->i_evening+$this->i_night;

            // build an array, cointaining the daytimes
            $dayTimes = array(
                "Morning" => $this->i_morning,
                "Afternoon" => $this->i_afternoon,
                "Evening" => $this->i_evening,
                "Night" => $this->i_night,
                "Total" => $total
            );

            // return OS data array
            return $dayTimes;
        }

        public function getDayTimesPercent()
        {
            // count daytimes
            $total = $this->i_morning+$this->i_afternoon+$this->i_evening+$this->i_night;

            // calculate percentage
            $a = 100 / $total;
            $this->i_morningPercent = round($a * $this->i_morning);
            $this->i_afternoonPercent = round($a * $this->i_afternoon);
            $this->i_eveningPercent = round($a * $this->i_evening);
            $this->i_nightPercent = round($a * $this->i_night);


            // build an array, cointaining the device types and the number how often it's been found
            $dayTimesPercent = array(
                "Morning" => $this->i_morningPercent,
                "Afternoon" => $this->i_afternoonPercent,
                "Evening" => $this->i_eveningPercent,
                "Night" => $this->i_nightPercent
            );
            arsort($dayTimesPercent);
            return $dayTimesPercent;
        }


        static function countBrowsers($db, $data, $limit)
        {   /* @var $db \YAWK\db */

            // check if limit (i) is set
            if (!isset($limit) || (empty($limit)))
            {   // set default value
                $limit = 100;
            }

            // this vars stores the counting for each browser
            $n_msie = 0;
            $n_chrome = 0;
            $n_firefox = 0;
            $n_opera = 0;
            $n_safari = 0;
            $n_netscape = 0;
            $n_others = 0;
            $total = 0;


            // check if data array is set, if not load data from db
            if (!isset($data) || (empty($data) || (!is_array($data))))
            {   // data is not set or in false format, try to get it from database
                \YAWK\alert::draw("warning", "database needed", "need to get browser data - array not set, empty or not an array.", "", 0);
                if ($res = $db->query("SELECT browser FROM {stats} ORDER BY id DESC LIMIT $limit"))
                {   // create array
                    $data = array();
                    while ($row = mysqli_fetch_assoc($res))
                    {   // add data to array
                        $data[] = $row;
                        $total++;
                    }
                }
                else
                    {   // data array not set and unable to get data from db
                        return false;
                    }
            }

            // LIMIT the data to x entries
            if (isset($limit) && (!empty($limit)))
            {   // if limit is set, cut array to limited range
                $data = array_slice($data, 0, $limit, true);
            }

            // count browsers
            foreach ($data AS $item => $browser) {   // add +1 for each found
                switch ($browser['browser']) {
                    case "Google Chrome":
                        $n_chrome++;
                        break;
                    case "Internet Explorer":
                        $n_msie++;
                        break;
                    case "Mozilla Firefox":
                        $n_firefox++;
                        break;
                    case "Apple Safari":
                        $n_safari++;
                        break;
                    case "Opera":
                        $n_opera++;
                        break;
                    case "Netscape":
                        $n_netscape++;
                        break;
                    default:
                    $n_others++;
                    }
            }
            // get the sum of all detected browsers
            $total = $n_chrome+$n_msie+$n_firefox+$n_safari+$n_opera+$n_netscape+$n_others;

            // build an array, cointaining the browsers and the number how often it's been found
            $browsers = array(
                "Chrome" => $n_chrome,
                "IE" => $n_msie,
                "Firefox" => $n_firefox,
                "Safari" => $n_safari,
                "Opera" => $n_opera,
                "Netscape" => $n_netscape,
                "Others" => $n_others,
                "Total" => $total
            );

            // return browser data array
            return $browsers;
        }


        public function countDeviceTypes($db, $data, $limit)
        {   /* @var $db \YAWK\db */

            // check if limit (i) is set
            if (!isset($limit) || (empty($limit)))
            {   // set default value
                $limit = 100;
            }

            // check if data array is set, if not load data from db
            if (!isset($data) || (empty($data) || (!is_array($data))))
            {   // data is not set or in false format, try to get it from database
                if ($res = $db->query("SELECT deviceType FROM {stats} ORDER BY id DESC LIMIT $limit"))
                {   // create array
                    $data = array();
                    while ($row = mysqli_fetch_assoc($res))
                    {   // add data to array
                        $data[] = $row;
                    }
                }
                else
                {   // data array not set and unable to get data from db
                    return false;
                }
            }

            // LIMIT the data to x entries
            if (isset($limit) && (!empty($limit)))
            {   // if limit is set, cut array to limited range
                $data = array_slice($data, 0, $limit, true);
            }
            foreach ($data as $deviceType => $value)
            {
                // count device types
                switch ($value['deviceType'])
                {
                    case "Desktop":
                        $this->i_desktop++;
                        break;
                    case "Tablet":
                        $this->i_tablet++;
                        break;
                    case "Phone":
                        $this->i_phone++;
                        break;
                }
            }

            // count device types
            $total = $this->i_desktop+$this->i_tablet+$this->i_phone;
            // build an array, cointaining the device types and the number how often it's been found
            $deviceTypes = array(
                "Desktop" => $this->i_desktop,
                "Tablet" => $this->i_tablet,
                "Phone" => $this->i_phone,
                "Total" => $total
            );

            // return OS data array
            return $deviceTypes;
        }


        public function countOS($db, $data, $limit)
        {   /* @var $db \YAWK\db */

            // check if limit (i) is set
            if (!isset($limit) || (empty($limit)))
            {   // set default value
                $limit = 100;
            }

            // check if data array is set, if not load data from db
            if (!isset($data) || (empty($data) || (!is_array($data))))
            {   // data is not set or in false format, try to get it from database
                \YAWK\alert::draw("warning", "database needed", "need to get browser data - array not set, empty or not an array.", "", 0);
                if ($res = $db->query("SELECT os FROM {stats} ORDER BY id DESC LIMIT $limit"))
                {   // create array
                    $data = array();
                    while ($row = mysqli_fetch_assoc($res))
                    {   // add data to array
                        $data[] = $row;
                    }
                }
                else
                {   // data array not set and unable to get data from db
                    return false;
                }
            }

            // LIMIT the data to x entries
            if (isset($limit) && (!empty($limit)))
            {   // if limit is set, cut array to limited range
                $data = array_slice($data, 0, $limit, true);
            }
            foreach ($data as $os => $value)
            {
                // count Operating Systems
                switch ($value['os'])
                {
                    case "Windows";
                        $this->i_osWindows++;
                        break;
                    case "Linux";
                        $this->i_osLinux++;
                        break;
                    case "Mac";
                        $this->i_osMac++;
                        break;
                    case "Android";
                        $this->i_osAndroid++;
                        break;
                    case "iOS";
                        $this->i_iOS++;
                        break;
                    default: $this->i_osUnknown++;
                }
            }

            // count Operating Systems
            $total = $this->i_osWindows+$this->i_osLinux+$this->i_osMac+$this->i_osAndroid+$this->i_iOS+$this->i_osUnknown;
            // build an array, cointaining the browsers and the number how often it's been found
            $os = array(
                "Windows" => $this->i_osWindows,
                "Linux" => $this->i_osLinux,
                "Mac" => $this->i_osMac,
                "Android" => $this->i_osAndroid,
                "iOS" => $this->i_iOS,
                "Unknown" => $this->i_osUnknown,
                "Total" => $total
            );

            // return OS data array
            return $os;
        }


        public function countOSVersions($db, $data, $limit)
        {   /* @var $db \YAWK\db */

            // check if limit (i) is set
            if (!isset($limit) || (empty($limit)))
            {   // set default value
                $limit = 100;
            }

            // check if data array is set, if not load data from db
            if (!isset($data) || (empty($data) || (!is_array($data))))
            {   // data is not set or in false format, try to get it from database
                \YAWK\alert::draw("warning", "database needed", "need to get browser data - array not set, empty or not an array.", "", 0);
                if ($res = $db->query("SELECT osVersion FROM {stats} ORDER BY id DESC LIMIT $limit"))
                {   // create array
                    $data = array();
                    while ($row = mysqli_fetch_assoc($res))
                    {   // add data to array
                        $data[] = $row;
                    }
                }
                else
                {   // data array not set and unable to get data from db
                    return false;
                }
            }

            // LIMIT the data to x entries
            if (isset($limit) && (!empty($limit)))
            {   // if limit is set, cut array to limited range
                $data = array_slice($data, 0, $limit, true);
            }

            // count browsers
            foreach ($data AS $item => $osVersion) {   // add +1 for each found
                // count Operating Systems Versions
                if ($osVersion['os'] === "Android")
                {
                    $osVersion['osVersion'] .= "Android ".$osVersion['osVersion'];
                }
                switch ($osVersion['osVersion'])
                {
                    case "Windows 8";
                        $this->i_windows8++;
                        break;
                    case "Windows 7";
                        $this->i_windows7++;
                        break;
                    case "Windows Vista";
                        $this->i_windowsVista++;
                        break;
                    case "Windows Server 2003/XP x64";
                        $this->i_windowsServer++;
                        break;
                    case "Windows XP";
                        $this->i_windowsXP++;
                        break;
                    case "Windows 2000";
                        $this->i_windows2000++;
                        break;
                    case "Windows ME";
                        $this->i_windowsME++;
                        break;
                    case "Windows 98";
                        $this->i_windows98++;
                        break;
                    case "Windows 95";
                        $this->i_windows95++;
                        break;
                    case "Windows 3.11";
                        $this->i_windows311++;
                        break;
                    case "Max OS X";
                        $this->i_macosX++;
                        break;
                    case "Max OS 9";
                        $this->i_macos9++;
                        break;
                    case "Linux";
                        $this->i_linux++;
                        break;
                    case "Ubuntu";
                        $this->i_ubuntu++;
                        break;
                    case "iPhone";
                        $this->i_iPhone++;
                        break;
                    case "iPad";
                        $this->i_iPad++;
                        break;
                    case "iPod";
                        $this->i_iPod++;
                        break;
                    case "Android":
                        $this->i_android++;
                        break;
                    case "BlackBerry";
                        $this->i_blackberry++;
                        break;
                    case "Mobile";
                        $this->i_mobile++;
                        break;

                    // could not detect OS Version
                    default:
                        $this->i_others++;
                }
            }

            // count OS Versions
            $total = $this->i_windows8
                    +$this->i_windows7
                    +$this->i_windowsVista
                    +$this->i_windowsServer
                    +$this->i_windows2000
                    +$this->i_windowsXP
                    +$this->i_windowsME
                    +$this->i_windows98
                    +$this->i_windows95
                    +$this->i_windows311
                    +$this->i_macosX
                    +$this->i_macos9
                    +$this->i_linux
                    +$this->i_ubuntu
                    +$this->i_iPhone
                    +$this->i_iPad
                    +$this->i_iPod
                    +$this->i_android
                    +$this->i_blackberry
                    +$this->i_mobile
                    +$this->i_others;
            // build an array, cointaining the counted OS Versions and the sum overall
            $osVersions = array(
                "Windows 8" => $this->i_windows8,
                "Windows 7" => $this->i_windows7,
                "Windows Vista" => $this->i_windowsVista,
                "Windows Server" => $this->i_windowsServer,
                "Windows 2000" => $this->i_windows2000,
                "Windows XP" => $this->i_windowsXP,
                "Windows ME" => $this->i_windowsME,
                "Windows 98" => $this->i_windows98,
                "Windows 95" => $this->i_windows95,
                "Windows 3.11" => $this->i_windows311,
                "Mac OS X" => $this->i_macosX,
                "Mac OS 9" => $this->i_macos9,
                "Linux" => $this->i_linux,
                "Ubuntu" => $this->i_ubuntu,
                "iPhone" => $this->i_iPhone,
                "iPad" => $this->i_iPad,
                "iPod" => $this->i_iPod,
                "Android" => $this->i_android,
                "Blackberry" => $this->i_blackberry,
                "Mobile" => $this->i_mobile,
                "Unknown" => $this->i_others,
                "Total" => $total
            );

            // return OS data array
            return $osVersions;
        }

        /**
         * Returns an array with all stats, ordered by date_created.
         * @author Daniel Retzl <danielretzl@gmail.com>
         * @version 1.0.0
         * @link http://yawk.io
         * @param object $db Database Object
         * @param string $property
         * @return mixed
         */
        public function getStatsArray($db) // get all settings from db like property
        {
            /* @var $db \YAWK\db */
            if ($res = $db->query("SELECT * FROM {stats} ORDER BY date_created DESC"))
            {
                $statsArray = array();
                while ($row = $res->fetch_assoc())
                {   // fill array
                    $statsArray[] = $row;
                }
            }
            else
            {   // q failed, throw error
                \YAWK\sys::setSyslog($db, 5, "failed to get stats from database.", 0, 0, 0, 0);
                \YAWK\alert::draw("warning", "Warning!", "Fetch database error: getStatsArray failed.","","4800");
                return false;
            }

            $this->calculateStatsFromArray($db, $statsArray);
            return $statsArray;
        }

        public function calculateStatsFromArray($db, $data)
        {   // get stats data
            if (!isset($data) || (empty($data)))
            {
                // get statistics into array
                $data = \YAWK\stats::getStatsArray($db);
            }
            // count and analyze the stats data in a loop
            foreach ($data as $value => $item)
            {
                // count hits
                $this->i_hits++;

                // count how many users were logged in
                if ($item['logged_in'] === "1")
                {
                    $this->i_loggedUsers++;
                }

                // count how many users were guests (or not logged in)
                if ($item['logged_in'] === "0")
                {
                    $this->i_publicUsers++;
                }

                // calculate percentage of guests vs logged in users
                $percentage = 100 / $this->i_hits;
                $this->i_loggedUsersPercentage = $this->i_loggedUsers * $percentage;
                $this->i_publicUsersPercentage = $this->i_publicUsers * $percentage;
                $this->i_loggedUsersPercentage = round($this->i_loggedUsersPercentage, 1, PHP_ROUND_HALF_UP);
                $this->i_publicUsersPercentage = round($this->i_publicUsersPercentage, 1, PHP_ROUND_HALF_UP);

            }

            /*
            echo "Total hits: ".$this->i_hits."<br>";
            echo "davon Phone: ".$this->i_phone."<br>";
            echo "davon Tablet: ".$this->i_tablet."<br>";
            echo "davon Desktop: ".$this->i_desktop." Win: $this->i_osWindows Mac: $this->i_osMac Linux: $this->i_osLinux<br>";
            echo "<pre>";
            print_r($data);
            echo "</pre>";
            */
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


        function drawBrowserBox($db, $data, $limit)
        {   /** @var $db \YAWK\db */
            // get data for this box
            $browsers = \YAWK\stats::countBrowsers($db, $data, $limit);

            echo "<!-- donut box:  -->
        <div class=\"box box-default\">
            <div class=\"box-header with-border\">
                <h3 class=\"box-title\">Browser Usage</h3>

                <div class=\"box-tools pull-right\">
                    <button type=\"button\" class=\"btn btn-box-tool\" data-widget=\"collapse\"><i class=\"fa fa-minus\"></i>
                    </button>
                    <button type=\"button\" class=\"btn btn-box-tool\" data-widget=\"remove\"><i class=\"fa fa-times\"></i></button>
                </div>
            </div>
            <!-- /.box-header -->
            <div class=\"box-body\">
                <div class=\"row\">
                    <div class=\"col-md-8\">
                        <div class=\"chart-responsive\">
                            <canvas id=\"pieChartBrowser\" height=\"150\"></canvas>
                        </div>
                        <!-- ./chart-responsive -->
                    </div>
                    <!-- /.col -->
                    <div class=\"col-md-4\">
                        <ul class=\"chart-legend clearfix\">

                            <script> //-------------
                                //- PIE CHART -
                                //-------------

                                // Get context with jQuery - using jQuery's .get() method.
                                var pieChartCanvas = $('#pieChartBrowser').get(0).getContext('2d');
                                var pieChart = new Chart(pieChartCanvas);
                                // get browsers array
                                // output js data with php function getJsonBrowsers
                                var PieData = "; self::getJsonBrowsers($db, $browsers);
                                echo"
                                var pieOptions = {
                                    //Boolean - Whether we should show a stroke on each segment
                                    segmentShowStroke: true,
                                    //String - The colour of each segment stroke
                                    segmentStrokeColor: '#fff',
                                    //Number - The width of each segment stroke
                                    segmentStrokeWidth: 1,
                                    //Number - The percentage of the chart that we cut out of the middle
                                    percentageInnerCutout: 50, // This is 0 for Pie charts
                                    //Number - Amount of animation steps
                                    animationSteps: 100,
                                    //String - Animation easing effect
                                    animationEasing: 'easeOutBounce',
                                    //Boolean - Whether we animate the rotation of the Doughnut
                                    animateRotate: true,
                                    //Boolean - Whether we animate scaling the Doughnut from the centre
                                    animateScale: false,
                                    //Boolean - whether to make the chart responsive to window resizing
                                    responsive: true,
                                    // Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
                                    maintainAspectRatio: false,
                                    //String - A legend template
                                    legendTemplate: '<ul class=\"<%=name.toLowerCase() %>-legend\"><% for (var i=0; i<segments.length; i++){%><li><span style=\"background-color:<%=segments[i].fillColor %>\"></span><%if(segments[i].label){%><%=segments[i].label%><%}%></li><%}%></ul>',
                                    //String - A tooltip template
                                    tooltipTemplate: '<%=value %> <%=label%> users'
                                };
                                //Create pie or douhnut chart
                                // You can switch between pie and douhnut using the method below.
                                pieChart.Doughnut(PieData, pieOptions);
                                //-----------------
                                //- END PIE CHART -
                                //-----------------</script>";

            // walk through array and draw data beneath pie chart
            foreach ($browsers AS $browser => $value)
            {   // get text colors
                $textcolor = self::getBrowserColors($browser);
                // show browsers their value is greater than zero and exclude totals
                if ($value > 0 && ($browser !== "Total"))
                {   // 1 line for every browser
                    echo "<li><i class=\"fa fa-circle-o $textcolor\"></i> <b>$value</b> $browser</li>";
                }
                // show totals
                if ($browser === "Total")
                {   // of how many visits
                    echo "<li class=\"small\">latest $value visitors</li>";
                }
            }
            echo"
                        </ul>
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.box-body -->
            <div class=\"box-footer no-padding\">
                <ul class=\"nav nav-pills nav-stacked\">";

            // sort array by value high to low to display most browsers first
            $browsers[] = arsort($browsers);
            // walk through array and display browsers as nav pills
            foreach ($browsers as $browser => $value)
            {   // show only items where browser got a value
                if ($value !== 0 && $browser !== 0)
                {   // get different textcolors
                    $textcolor = self::getBrowserColors($browser);
                    echo "<li><a href=\"#\" class=\"$textcolor\">$browser
        <span class=\"pull-right $textcolor\" ><i class=\"fa fa-angle-down\"></i>$value</span></a></li>";
                }
            }

            echo "</ul>
            </div>
            <!-- /.footer -->
        </div>
        <!-- /.box -->";
        }



        public function drawOsBox($db, $data, $limit)
        {   /** @var $db \YAWK\db */
            // get data for this box
            $oss = \YAWK\stats::countOS($db, $data, $limit);

            echo "<!-- donut box:  -->
        <div class=\"box box-default\">
            <div class=\"box-header with-border\">
                <h3 class=\"box-title\">Operating Systems <small>(experimental)</small></h3>

                <div class=\"box-tools pull-right\">
                    <button type=\"button\" class=\"btn btn-box-tool\" data-widget=\"collapse\"><i class=\"fa fa-minus\"></i>
                    </button>
                    <button type=\"button\" class=\"btn btn-box-tool\" data-widget=\"remove\"><i class=\"fa fa-times\"></i></button>
                </div>
            </div>
            <!-- /.box-header -->
            <div class=\"box-body\">
                <div class=\"row\">
                    <div class=\"col-md-8\">
                        <div class=\"chart-responsive\">
                            <canvas id=\"pieChartOS\" height=\"150\"></canvas>
                        </div>
                        <!-- ./chart-responsive -->
                    </div>
                    <!-- /.col -->
                    <div class=\"col-md-4\">
                        <ul class=\"chart-legend clearfix\">

                            <script> //-------------
                                //- PIE CHART -
                                //-------------

                                // Get context with jQuery - using jQuery's .get() method.
                                var pieChartCanvas = $('#pieChartOS').get(0).getContext('2d');
                                var pieChart = new Chart(pieChartCanvas);
                                // get browsers array
                                // output js data with php function getJsonBrowsers
                                var PieData = "; self::getJsonOS($db, $oss);
                                echo"
                                var pieOptions = {
                                    //Boolean - Whether we should show a stroke on each segment
                                    segmentShowStroke: true,
                                    //String - The colour of each segment stroke
                                    segmentStrokeColor: '#fff',
                                    //Number - The width of each segment stroke
                                    segmentStrokeWidth: 1,
                                    //Number - The percentage of the chart that we cut out of the middle
                                    percentageInnerCutout: 50, // This is 0 for Pie charts
                                    //Number - Amount of animation steps
                                    animationSteps: 100,
                                    //String - Animation easing effect
                                    animationEasing: 'easeOutBounce',
                                    //Boolean - Whether we animate the rotation of the Doughnut
                                    animateRotate: true,
                                    //Boolean - Whether we animate scaling the Doughnut from the centre
                                    animateScale: false,
                                    //Boolean - whether to make the chart responsive to window resizing
                                    responsive: true,
                                    // Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
                                    maintainAspectRatio: false,
                                    //String - A legend template
                                    legendTemplate: '<ul class=\"<%=name.toLowerCase() %>-legend\"><% for (var i=0; i<segments.length; i++){%><li><span style=\"background-color:<%=segments[i].fillColor %>\"></span><%if(segments[i].label){%><%=segments[i].label%><%}%></li><%}%></ul>',
                                    //String - A tooltip template
                                    tooltipTemplate: '<%=value %> <%=label%>'
                                };
                                //Create pie or douhnut chart
                                // You can switch between pie and douhnut using the method below.
                                pieChart.Doughnut(PieData, pieOptions);
                                //-----------------
                                //- END PIE CHART -
                                //-----------------</script>";

            // walk through array and draw data beneath pie chart
            foreach ($oss AS $os => $value)
            {   // get text colors
                $textcolor = self::getOsColors($os);
                // show browsers their value is greater than zero and exclude totals
                if ($value > 0 && ($os !== "Total"))
                {   // 1 line for every browser
                    echo "<li><i class=\"fa fa-circle-o $textcolor\"></i> <b>$value</b> $os</li>";
                }
                // show totals
                if ($os === "Total")
                {   // of how many visits
                    echo "<li class=\"small\">latest $value users</li>";
                }
            }
            echo"
                        </ul>
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.box-body -->
            <div class=\"box-footer no-padding\">
                <ul class=\"nav nav-pills nav-stacked\">";

            // sort array by value high to low to display most browsers first
            $oss[] = arsort($oss);
            // walk through array and display browsers as nav pills
            foreach ($oss as $os => $value)
            {   // show only items where browser got a value
                if ($value !== 0 && $os !== 0)
                {   // get different textcolors
                    $textcolor = self::getOsColors($os);
                    echo "<li><a href=\"#\" class=\"$textcolor\">$os
                          <span class=\"pull-right $textcolor\" ><i class=\"fa fa-angle-down\"></i>$value</span></a></li>";
                }
            }

            echo "</ul>
            </div>
            <!-- /.footer -->
        </div>
        <!-- /.box -->";
        }


        public function drawOsVersionBox($db, $data, $limit)
        {   /** @var $db \YAWK\db */
            // get data for this box
            $osVersions = \YAWK\stats::countOSVersions($db, $data, $limit);

            echo "<!-- donut box:  -->
        <div class=\"box box-default\">
            <div class=\"box-header with-border\">
                <h3 class=\"box-title\">OS Versions <small>(experimental)</small></h3>

                <div class=\"box-tools pull-right\">
                    <button type=\"button\" class=\"btn btn-box-tool\" data-widget=\"collapse\"><i class=\"fa fa-minus\"></i>
                    </button>
                    <button type=\"button\" class=\"btn btn-box-tool\" data-widget=\"remove\"><i class=\"fa fa-times\"></i></button>
                </div>
            </div>
            <!-- /.box-header -->
            <div class=\"box-body\">
                <div class=\"row\">
                    <div class=\"col-md-8\">
                        <div class=\"chart-responsive\">
                            <canvas id=\"pieChartOSVersion\" height=\"150\"></canvas>
                        </div>
                        <!-- ./chart-responsive -->
                    </div>
                    <!-- /.col -->
                    <div class=\"col-md-4\">
                        <ul class=\"chart-legend clearfix\">

                            <script> //-------------
                                //- PIE CHART -
                                //-------------

                                // Get context with jQuery - using jQuery's .get() method.
                                var pieChartCanvas = $('#pieChartOSVersion').get(0).getContext('2d');
                                var pieChart = new Chart(pieChartCanvas);
                                // get browsers array
                                // output js data with php function getJsonBrowsers
                                var PieData = "; self::getJsonOSVersions($db, $osVersions);
                                echo"
                                var pieOptions = {
                                    //Boolean - Whether we should show a stroke on each segment
                                    segmentShowStroke: true,
                                    //String - The colour of each segment stroke
                                    segmentStrokeColor: '#fff',
                                    //Number - The width of each segment stroke
                                    segmentStrokeWidth: 1,
                                    //Number - The percentage of the chart that we cut out of the middle
                                    percentageInnerCutout: 50, // This is 0 for Pie charts
                                    //Number - Amount of animation steps
                                    animationSteps: 100,
                                    //String - Animation easing effect
                                    animationEasing: 'easeOutBounce',
                                    //Boolean - Whether we animate the rotation of the Doughnut
                                    animateRotate: true,
                                    //Boolean - Whether we animate scaling the Doughnut from the centre
                                    animateScale: false,
                                    //Boolean - whether to make the chart responsive to window resizing
                                    responsive: true,
                                    // Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
                                    maintainAspectRatio: false,
                                    //String - A legend template
                                    legendTemplate: '<ul class=\"<%=name.toLowerCase() %>-legend\"><% for (var i=0; i<segments.length; i++){%><li><span style=\"background-color:<%=segments[i].fillColor %>\"></span><%if(segments[i].label){%><%=segments[i].label%><%}%></li><%}%></ul>',
                                    //String - A tooltip template
                                    tooltipTemplate: '<%=value %> <%=label%>'
                                };
                                //Create pie or douhnut chart
                                // You can switch between pie and douhnut using the method below.
                                pieChart.Doughnut(PieData, pieOptions);
                                //-----------------
                                //- END PIE CHART -
                                //-----------------</script>";

            // walk through array and draw data beneath pie chart
            foreach ($osVersions AS $osVersion => $value)
            {   // get text colors
                $textcolor = self::getOsVersionsColors($osVersion);
                // show browsers their value is greater than zero and exclude totals
                if ($value > 0 && ($osVersion !== "Total"))
                {   // 1 line for every browser
                    echo "<li><i class=\"fa fa-circle-o $textcolor\"></i> <b>$value</b> $osVersion</li>";
                }
                // show totals
                if ($osVersion === "Total")
                {   // of how many visits
                    echo "<li class=\"small\">latest $value OSes</li>";
                }
            }
            echo"
                        </ul>
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.box-body -->
            <div class=\"box-footer no-padding\">
                <ul class=\"nav nav-pills nav-stacked\">";

            // sort array by value high to low to display most browsers first
            $osVersions[] = arsort($osVersions);
            // walk through array and display browsers as nav pills
            foreach ($osVersions as $osVersion => $value)
            {   // show only items where browser got a value
                if ($value !== 0 && $osVersion !== 0)
                {   // get different textcolors
                    $textcolor = self::getOsVersionsColors($osVersion);
                    echo "<li><a href=\"#\" class=\"$textcolor\">$osVersion
                          <span class=\"pull-right $textcolor\" ><i class=\"fa fa-angle-down\"></i>$value</span></a></li>";
                }
            }

            echo "</ul>
            </div>
            <!-- /.footer -->
        </div>
        <!-- /.box -->";
        }

        public function drawDeviceTypeBox($db, $data, $limit)
        {   /** @var $db \YAWK\db */
            // get data for this box
            $deviceTypes = \YAWK\stats::countDeviceTypes($db, $data, $limit);

            echo "<!-- donut box:  -->
        <div class=\"box box-default\">
            <div class=\"box-header with-border\">
                <h3 class=\"box-title\">Device Type <small>(desktop, mobile or tablet)</small></h3>

                <div class=\"box-tools pull-right\">
                    <button type=\"button\" class=\"btn btn-box-tool\" data-widget=\"collapse\"><i class=\"fa fa-minus\"></i>
                    </button>
                    <button type=\"button\" class=\"btn btn-box-tool\" data-widget=\"remove\"><i class=\"fa fa-times\"></i></button>
                </div>
            </div>
            <!-- /.box-header -->
            <div class=\"box-body\">
                <div class=\"row\">
                    <div class=\"col-md-8\">
                        <div class=\"chart-responsive\">
                            <canvas id=\"barChartDeviceType\" height=\"150\"></canvas>
                        </div>
                        <!-- ./chart-responsive -->
                    </div>
                    <!-- /.col -->
                    <div class=\"col-md-4\">
                        <ul class=\"chart-legend clearfix\">

                        <script>    
                            //-------------
                            //- BAR CHART -
                            //-------------
                            
                            var barChartData = {
                              ";
                                    $this->getJsonDeviceTypes($db, $deviceTypes);
                            echo "};
                        
                            var barChartCanvas = $('#barChartDeviceType').get(0).getContext('2d');
                            var barChart = new Chart(barChartCanvas);
                            barChartData.datasets.fillColor = '#00a65a';
                            barChartData.datasets.strokeColor = '#00a65a';
                            barChartData.datasets.pointColor = '#00a65a';
                            var barChartOptions = {
                              //Boolean - Whether the scale should start at zero, or an order of magnitude down from the lowest value
                              scaleBeginAtZero: true,
                              //Boolean - Whether grid lines are shown across the chart
                              scaleShowGridLines: true,
                              //String - Colour of the grid lines
                              scaleGridLineColor: 'rgba(0,0,0,.05)',
                              //Number - Width of the grid lines
                              scaleGridLineWidth: 1,
                              //Boolean - Whether to show horizontal lines (except X axis)
                              scaleShowHorizontalLines: true,
                              //Boolean - Whether to show vertical lines (except Y axis)
                              scaleShowVerticalLines: true,
                              //Boolean - If there is a stroke on each bar
                              barShowStroke: true,
                              //Number - Pixel width of the bar stroke
                              barStrokeWidth: 2,
                              //Number - Spacing between each of the X value sets
                              barValueSpacing: 5,
                              //Number - Spacing between data sets within X values
                              barDatasetSpacing: 1,
                              //String - A legend template
                              legendTemplate: '<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<datasets.length; i++){%><li><span style=\"background-color:<%=datasets.fillColor %>\"></span><%if(datasets[i].label){%><%=datasets.label%><%}%></li><%}%></ul>',
                              //Boolean - whether to make the chart responsive
                              responsive: true,
                              maintainAspectRatio: true
                            };
                        
                            barChartOptions.datasetFill = false;
                            barChart.Bar(barChartData, barChartOptions);
                        </script>";

            // walk through array and draw data beneath pie chart
            foreach ($deviceTypes AS $deviceType => $value)
            {   // get text colors
                $textcolor = self::getDeviceTypeColors($deviceType);
                // show browsers their value is greater than zero and exclude totals
                if ($value > 0 && ($deviceType !== "Total"))
                {   // 1 line for every browser
                    echo "<li><i class=\"fa fa-circle-o $textcolor\"></i> <b>$value</b> $deviceType</li>";
                }
                // show totals
                if ($deviceType === "Total")
                {   // of how many visits
                    echo "<li class=\"small\">latest $value Users</li>";
                }
            }
            echo"
                        </ul>
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.box-body -->
            <div class=\"box-footer no-padding\">
                <ul class=\"nav nav-pills nav-stacked\">";

            // sort array by value high to low to display most browsers first
            $deviceTypes[] = arsort($deviceTypes);
            // walk through array and display browsers as nav pills
            foreach ($deviceTypes as $deviceType => $value)
            {   // show only items where browser got a value
                if ($value !== 0 && $deviceType !== 0)
                {   // get different textcolors
                    $textcolor = self::getDeviceTypeColors($deviceType);
                    echo "<li><a href=\"#\" class=\"$textcolor\">$deviceType
                          <span class=\"pull-right $textcolor\" ><i class=\"fa fa-angle-down\"></i>$value</span></a></li>";
                }
            }

            echo "</ul>
            </div>
            <!-- /.footer -->
        </div>
        <!-- /.box -->";
        }


        public function drawLoginBox($db, $limit)
        {   /** @var $db \YAWK\db */
            // get data for this box
            $logins = $this->countLogins($db, $limit);

            echo "<!-- donut box:  -->
        <div class=\"box box-default\">
            <div class=\"box-header with-border\">
                <h3 class=\"box-title\">Logins <small>overview user logins</small></h3>

                <div class=\"box-tools pull-right\">
                    <button type=\"button\" class=\"btn btn-box-tool\" data-widget=\"collapse\"><i class=\"fa fa-minus\"></i>
                    </button>
                    <button type=\"button\" class=\"btn btn-box-tool\" data-widget=\"remove\"><i class=\"fa fa-times\"></i></button>
                </div>
            </div>
            <!-- /.box-header -->
            <div class=\"box-body\">
                <div class=\"row\">
                    <div class=\"col-md-8\">
                        <div class=\"chart-responsive\">
                            <canvas id=\"pieChartLogins\" height=\"150\"></canvas>
                        </div>
                        <!-- ./chart-responsive -->
                    </div>
                    <!-- /.col -->
                    <div class=\"col-md-4\">
                        <ul class=\"chart-legend clearfix\">

                            <script> //-------------
                                //- PIE CHART -
                                //-------------

                                // Get context with jQuery - using jQuery's .get() method.
                                var pieChartCanvas = $('#pieChartLogins').get(0).getContext('2d');
                                var pieChart = new Chart(pieChartCanvas);
                                // get browsers array
                                // output js data with php function getJsonBrowsers
                                var PieData = ";self::getJsonLogins($db, $logins);
            echo"
                                var pieOptions = {
                                    //Boolean - Whether we should show a stroke on each segment
                                    segmentShowStroke: true,
                                    //String - The colour of each segment stroke
                                    segmentStrokeColor: '#fff',
                                    //Number - The width of each segment stroke
                                    segmentStrokeWidth: 1,
                                    //Number - The percentage of the chart that we cut out of the middle
                                    percentageInnerCutout: 50, // This is 0 for Pie charts
                                    //Number - Amount of animation steps
                                    animationSteps: 100,
                                    //String - Animation easing effect
                                    animationEasing: 'easeOutBounce',
                                    //Boolean - Whether we animate the rotation of the Doughnut
                                    animateRotate: true,
                                    //Boolean - Whether we animate scaling the Doughnut from the centre
                                    animateScale: false,
                                    //Boolean - whether to make the chart responsive to window resizing
                                    responsive: true,
                                    // Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
                                    maintainAspectRatio: false,
                                    //String - A legend template
                                    legendTemplate: '<ul class=\"<%=name.toLowerCase() %>-legend\"><% for (var i=0; i<segments.length; i++){%><li><span style=\"background-color:<%=segments[i].fillColor %>\"></span><%if(segments[i].label){%><%=segments[i].label%><%}%></li><%}%></ul>',
                                    //String - A tooltip template
                                    tooltipTemplate: '<%=value %> <%=label%>'
                                };
                                //Create pie or douhnut chart
                                // You can switch between pie and douhnut using the method below.
                                pieChart.Doughnut(PieData, pieOptions);
                                //-----------------
                                //- END PIE CHART -
                                //-----------------</script>";

            // walk through array and draw data beneath pie chart
            foreach ($logins AS $login => $value)
            {   // get text colors
                $textcolor = self::getLoginColors($login);
                // show browsers their value is greater than zero and exclude totals
                if ($value > 0 && ($login !== "Total") && ($login === "FailedPercentage") || ($login === "SuccessPercentage"))
                {   // 1 line for every browser
                    if ($login === "FailedPercentage") { $login = "Failed"; }
                    if ($login === "SuccessPercentage") { $login = "Success"; }
                    echo "<li><i class=\"fa fa-circle-o $textcolor\"></i> <b>$value%</b> $login</li>";
                }
                // show totals
                if ($login === "Total")
                {   // of how many visits
                    echo "<li class=\"small\">latest $value Logins</li>";
                }
            }
            echo"
                        </ul>
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.box-body -->
            <div class=\"box-footer no-padding\">
                <ul class=\"nav nav-pills nav-stacked\">";

            // sort array by value high to low to display most browsers first
            $logins[] = arsort($logins);
            // walk through array and display browsers as nav pills
            foreach ($logins as $login => $value)
            {   // show only items where browser got a value
                if ($value !== 0 && $login !== 0)
                {   // get different textcolors
                    $textcolor = self::getLoginColors($login);
                    if ($login !== "Failed"
                        && ($login !== "Successful")
                        && ($login !== "Total"))
                    {
                        $spacer = "&nbsp;&nbsp;&nbsp;&nbsp;<small>";
                        $spacerEnd ="</small>";
                    }
                    else
                        {
                            $spacer = '';
                            $spacerEnd = '';
                        }
                        if ($login !== "FailedPercentage" && ($login !== "SuccessPercentage"))
                        {
                            echo "<li><a href=\"#\" class=\"$textcolor\">$spacer$login$spacerEnd
                            <span class=\"pull-right $textcolor\" ><i class=\"fa fa-angle-down\"></i>$value</span></a></li>";

                        }
                }
            }

            echo "</ul>
            </div>
            <!-- /.footer -->
        </div>
        <!-- /.box -->";
        }


        public function drawDaytimeBox($db, $data, $limit)
        {   /** @var $db \YAWK\db */
            // get data for this box
            $dayTimes = \YAWK\stats::countDaytime($db, $data, $limit);
            $dayTimesPercent = $this->getDayTimesPercent();


            echo "<!-- donut box:  -->
        <div class=\"box box-default\">
            <div class=\"box-header with-border\">
                <h3 class=\"box-title\">Daytime <small>when is your prime time?</small></h3>

                <div class=\"box-tools pull-right\">
                    <button type=\"button\" class=\"btn btn-box-tool\" data-widget=\"collapse\"><i class=\"fa fa-minus\"></i>
                    </button>
                    <button type=\"button\" class=\"btn btn-box-tool\" data-widget=\"remove\"><i class=\"fa fa-times\"></i></button>
                </div>
            </div>
            <!-- /.box-header -->
            <div class=\"box-body\">
                <div class=\"row\">
                    <div class=\"col-md-8\">
                        <div class=\"chart-responsive\">
                            <canvas id=\"pieChartDaytime\" height=\"150\"></canvas>
                        </div><!-- ./chart-responsive -->
                        
                        <div class=\"chart-responsive\">
                            <canvas id=\"barChartDaytime\" height=\"150\"></canvas>
                        </div><!-- ./chart-responsive -->
                        
                        <!--
                        <div class=\"chart-responsive\">
                            <canvas id=\"lineChartDaytime\" height=\"150\"></canvas>
                        </div><!-- ./chart-responsive 
                        -->
                    </div>
                    <!-- /.col -->
                    <div class=\"col-md-4\">
                        <ul class=\"chart-legend clearfix\">

                            <script> 
                                //-------------
                                //- PIE CHART -
                                //-------------

                                // Get context with jQuery - using jQuery's .get() method.
                                var pieChartCanvas = $('#pieChartDaytime').get(0).getContext('2d');
                                var pieChart = new Chart(pieChartCanvas);
                                // get browsers array
                                // output js data with php function getJsonBrowsers
                                var PieData = ";$this->getJsonDaytimePieChart($db, $dayTimes);
                                echo "
                                var pieOptions = {
                                    //Boolean - Whether we should show a stroke on each segment
                                    segmentShowStroke: true,
                                    //String - The colour of each segment stroke
                                    segmentStrokeColor: '#fff',
                                    //Number - The width of each segment stroke
                                    segmentStrokeWidth: 1,
                                    //Number - The percentage of the chart that we cut out of the middle
                                    percentageInnerCutout: 0, // This is 0 for Pie charts
                                    //Number - Amount of animation steps
                                    animationSteps: 100,
                                    //String - Animation easing effect
                                    animationEasing: 'easeOutBounce',
                                    //Boolean - Whether we animate the rotation of the Doughnut
                                    animateRotate: true,
                                    //Boolean - Whether we animate scaling the Doughnut from the centre
                                    animateScale: false,
                                    //Boolean - whether to make the chart responsive to window resizing
                                    responsive: true,
                                    // Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
                                    maintainAspectRatio: false,
                                    //String - A legend template
                                    legendTemplate: '<ul class=\" <%=name.toLowerCase() %>-legend\"><% for (var i=0; i<segments.length; i++){%><li><span style=\"background-color:<%=segments[i].fillColor %>\"></span><%if(segments[i].label){%><%=segments[i].label%><%}%></li><%}%></ul>',
                                    //String - A tooltip template
                                    tooltipTemplate: '<%=value %> <%=label%>'
                                };
                                //Create pie or douhnut chart
                                // You can switch between pie and douhnut using the method below.
                                pieChart.Doughnut(PieData, pieOptions);
                                //-----------------
                                //- END PIE CHART -
                                //-----------------
                                </script>";


                        echo"<script>
                            //-------------
                            //- BAR CHART -
                            //-------------
                            
                            var barChartData = {";$this->getJsonDaytimeBarChart($db, $dayTimes);echo "};
                            var barChartCanvas = $('#barChartDaytime').get(0).getContext('2d');
                            var barChart = new Chart(barChartCanvas);
                            barChartData.datasets.fillColor = '#00a65a';
                            barChartData.datasets.strokeColor = '#00a65a';
                            barChartData.datasets.pointColor = '#00a65a';
                            var barChartOptions = {
                            //Boolean - Whether the scale should start at zero, or an order of magnitude down from the lowest value
                            scaleBeginAtZero: true,
                              //Boolean - Whether grid lines are shown across the chart
                              scaleShowGridLines: true,
                              //String - Colour of the grid lines
                              scaleGridLineColor: 'rgba(0,0,0,.05)',
                              //Number - Width of the grid lines
                              scaleGridLineWidth: 1,
                              //Boolean - Whether to show horizontal lines (except X axis)
                              scaleShowHorizontalLines: true,
                              //Boolean - Whether to show vertical lines (except Y axis)
                              scaleShowVerticalLines: true,
                              //Boolean - If there is a stroke on each bar
                              barShowStroke: true,
                              //Number - Pixel width of the bar stroke
                              barStrokeWidth: 2,
                              //Number - Spacing between each of the X value sets
                              barValueSpacing: 5,
                              //Number - Spacing between data sets within X values
                              barDatasetSpacing: 1,
                              //String - A legend template
                              legendTemplate: '<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<datasets.length; i++){%><li><span style=\"background-color:<%=datasets.fillColor %>\"></span><%if(datasets[i].label){%><%=datasets.label%><%}%></li><%}%></ul>',
                              //Boolean - whether to make the chart responsive
                              responsive: true,
                              maintainAspectRatio: true
                            };
                        
                            barChartOptions.datasetFill = false;
                            barChart.Bar(barChartData, barChartOptions);
                        </script>";


                            echo "<script> 
                                //------------------
                                // LINE CHART
                                //------------------
                               var lineChartData = {";$this->getJsonDaytimeLineChart($db, $dayTimes);echo "
                               var lineChartOptions = {
                                  //Boolean - If we should show the scale at all
                                  showScale: true,
                                  //Boolean - Whether grid lines are shown across the chart
                                  scaleShowGridLines: false,
                                  //String - Colour of the grid lines
                                  scaleGridLineColor: 'rgba(0, 0, 0, .05)',
                                  //Number - Width of the grid lines
                                  scaleGridLineWidth: 1,
                                  //Boolean - Whether to show horizontal lines (except X axis)
                                  scaleShowHorizontalLines: true,
                                  //Boolean - Whether to show vertical lines (except Y axis)
                                  scaleShowVerticalLines: true,
                                  //Boolean - Whether the line is curved between points
                                  bezierCurve: true,
                                  //Number - Tension of the bezier curve between points
                                  bezierCurveTension: 0.3,
                                  //Boolean - Whether to show a dot for each point
                                  pointDot: false,
                                  //Number - Radius of each point dot in pixels
                                  pointDotRadius: 4,
                                  //Number - Pixel width of point dot stroke
                                  pointDotStrokeWidth: 1,
                                  //Number - amount extra to add to the radius to cater for hit detection outside the drawn point
                                  pointHitDetectionRadius: 20,
                                  //Boolean - Whether to show a stroke for datasets
                                  datasetStroke: true,
                                  //Number - Pixel width of dataset stroke
                                  datasetStrokeWidth: 2,
                                  //Boolean - Whether to fill the dataset with a color
                                  datasetFill: true,
                                  //String - A legend template
                                  legendTemplate: '<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<datasets.length; i++){%><li><span style=\"background-color:<%=datasets[i].lineColor %>\"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>',
                                  //Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
                                  maintainAspectRatio: true,
                                  //Boolean - whether to make the chart responsive to window resizing
                                  responsive: true
                                };
                                
                            // Create the line chart
                            lineChart.Line(lineChartData, lineChartOptions);
                            var lineChartCanvas = $('#lineChartDaytime').get(0).getContext('2d');
                            var lineChart = new Chart(lineChartCanvas);
                            lineChartOptions.datasetFill = false;
                            lineChart.Line(lineChartData, lineChartOptions);
                            
                               </script>";

            // walk through array and draw data beneath pie chart
            foreach ($dayTimesPercent AS $daytime => $value)
            {   // get text colors
                $textcolor = self::getDaytimeColors($daytime);
                // show browsers their value is greater than zero and exclude totals
                if ($value > 0 && ($daytime !== "Total"))
                {   // 1 line for every browser
                    $spacer = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                    if ($daytime === "Morning")
                    { $legend = "$spacer<small>06:00 - 11:00</small>"; }
                    elseif ($daytime === "Afternoon")
                    { $legend = "$spacer<small>12:00 - 17:00</small>"; }
                    elseif ($daytime === "Evening")
                    { $legend = "$spacer<small>18:00 - 23:00</small>"; }
                    elseif ($daytime === "Night")
                    { $legend = "$spacer<small>00:00 - 05:00</small>"; }
                    else { $legend = ''; }
                    echo "<li><i class=\"fa fa-circle-o $textcolor\"></i> <b>$value%</b> $daytime <br><small>$legend</small></li>";
                }
                // show totals
                if ($daytime === "Total")
                {   // of how many visits
                    echo "<li class=\"small\">latest $value hits</li>";
                }
            }
            echo"
                        </ul>
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.box-body -->
            <div class=\"box-footer no-padding\">
                <ul class=\"nav nav-pills nav-stacked\">";

            // sort array by value high to low to display most browsers first
            $dayTimes[] = arsort($dayTimes);
            // walk through array and display browsers as nav pills
            foreach ($dayTimes as $dayTime => $value)
            {   // show only items where browser got a value
                if ($value !== 0 && $dayTime !== 0)
                {   // get different textcolors
                    $textcolor = self::getDaytimeColors($dayTime);
                    echo "<li><a href=\"#\" class=\"$textcolor\">$dayTime
                          <span class=\"pull-right $textcolor\" ><i class=\"fa fa-angle-down\"></i>$value</span></a></li>";
                }
            }

            echo "</ul>
            </div>
            <!-- /.footer -->
        </div>
        <!-- /.box -->";
        }


        public function drawWeekdayBox($db, $data, $limit)
        {   /** @var $db \YAWK\db */
            // get data for this box
            $weekdays = $this->countWeekdays($db, $data, $limit);
            $weekdaysPercent = $this->getWeekdaysPercent();

            echo "<!-- donut box:  -->
        <div class=\"box box-default\">
            <div class=\"box-header with-border\">
                <h3 class=\"box-title\">Weekdays <small>overview best days</small></h3>

                <div class=\"box-tools pull-right\">
                    <button type=\"button\" class=\"btn btn-box-tool\" data-widget=\"collapse\"><i class=\"fa fa-minus\"></i>
                    </button>
                    <button type=\"button\" class=\"btn btn-box-tool\" data-widget=\"remove\"><i class=\"fa fa-times\"></i></button>
                </div>
            </div>
            <!-- /.box-header -->
            <div class=\"box-body\">
                <div class=\"row\">
                    <div class=\"col-md-8\">
                        <div class=\"chart-responsive\">
                            <canvas id=\"barChartWeekdays\" height=\"150\"></canvas>
                        </div>
                        <!-- ./chart-responsive -->
                    </div>
                    <!-- /.col -->
                    <div class=\"col-md-4\">
                        <ul class=\"chart-legend clearfix\">

                        <script>    
                            //-------------
                            //- BAR CHART -
                            //-------------
                            
                            var barChartData = {";$this->getJsonWeekdayBarChart();echo "};
                            var barChartCanvas = $('#barChartWeekdays').get(0).getContext('2d');
                            var barChart = new Chart(barChartCanvas);
                            barChartData.datasets.fillColor = '#00a65a';
                            barChartData.datasets.strokeColor = '#00a65a';
                            barChartData.datasets.pointColor = '#00a65a';
                            var barChartOptions = {
                              //Boolean - Whether the scale should start at zero, or an order of magnitude down from the lowest value
                              scaleBeginAtZero: true,
                              //Boolean - Whether grid lines are shown across the chart
                              scaleShowGridLines: true,
                              //String - Colour of the grid lines
                              scaleGridLineColor: 'rgba(0,0,0,.05)',
                              //Number - Width of the grid lines
                              scaleGridLineWidth: 1,
                              //Boolean - Whether to show horizontal lines (except X axis)
                              scaleShowHorizontalLines: true,
                              //Boolean - Whether to show vertical lines (except Y axis)
                              scaleShowVerticalLines: true,
                              //Boolean - If there is a stroke on each bar
                              barShowStroke: true,
                              //Number - Pixel width of the bar stroke
                              barStrokeWidth: 2,
                              //Number - Spacing between each of the X value sets
                              barValueSpacing: 5,
                              //Number - Spacing between data sets within X values
                              barDatasetSpacing: 1,
                              //String - A legend template
                              legendTemplate: '<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<datasets.length; i++){%><li><span style=\"background-color:<%=datasets.fillColor %>\"></span><%if(datasets[i].label){%><%=datasets.label%><%}%></li><%}%></ul>',
                              //Boolean - whether to make the chart responsive
                              responsive: true,
                              maintainAspectRatio: true
                            };
                        
                            barChartOptions.datasetFill = false;
                            barChart.Bar(barChartData, barChartOptions);
                        </script>";
            // walk through array and draw data beneath pie chart
            foreach ($weekdaysPercent AS $weekday => $value)
            {   // get text colors
                // show browsers their value is greater than zero and exclude totals
                if ($value > 0 && ($weekday !== "Total"))
                {   // 1 line for every browser
                    if (strlen($value) === 1) { $spacer = "&nbsp;&nbsp;"; } else { $spacer = ''; }
                    echo "<li><b>$spacer$value%</b> $weekday</li>";
                }
                // show totals
                if ($weekday === "Total")
                {   // of how many visits
                    echo "<li class=\"small\">latest $value hits</li>";
                }
            }

                        echo"</ul>
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->";
        }

    }
}