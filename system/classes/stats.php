<?php
namespace YAWK
{
    /**
     * @brief Statistics - get and set user and page stats
     * @author Daniel Retzl <danielretzl@gmail.com>
     * @version 1.0.0
     *
     */
    class stats
    {
        /** * @param int id for every entry */
        public $id;
        /** * @param int uid (user id) who affected this entry */
        public $uid = 0;
        /** * @param int gid (group id) who affected this entry */
        public $gid = 0;
        /** * @param int phpSessionID current php session ID */
        public $phpSessionID;
        /** * @param string currentTimeStamp current time stamp */
        public $currentTimeStamp;
        /** * @param int currentOnline how many users are currently online */
        public $currentOnline = 0;
        /** * @param int 0|1 was the user logged in? */
        public $logged_in = 0;
        /** * @param string detected user language */
        public $acceptLanguage;
        /** * @param string IP address who affected this entry */
        public $remoteAddr;
        /** * @param string complete useragent info*/
        public $userAgent;
        /** * @param string detected device (eg. iPhone, iPad, iPod) */
        public $device;
        /** * @param string detected device type (desktop, phone, tablet) */
        public $deviceType;
        /** * @param string detected users operating system */
        public $os;
        /** * @param string detected users operating system version */
        public $osVersion;
        /** * @param string detected users browser */
        public $browser;
        /** * @param string detected users browser version */
        public $browserVersion;
        /** * @param string datetime when entry was created */
        public $date_created;
        /** * @param string users url referer string */
        public $referer;
        /** * @param string page that the user requested */
        public $page;
        /** * @param string the currently open sessions (active users) */
        public $activeSessions;

        // stats variables
        /** * @param int total hits overall */
        public $i_hits = 0;
        /** * @param int how many logins were successful? */
        public $i_loggedUsers = 0;
        /** * @param int how many logins were successful? (in percent) */
        public $i_loggedUsersPercentage = 0;
        /** * @param int how many users did not log in and visited as public guest? */
        public $i_publicUsers = 0;
        /** * @param int how many users did not log in and visited as public guest? (in percent) */
        public $i_publicUsersPercentage = 0;

        // user stats
        /** *@param int total users overall */
        public $i_users = 0;
        /** *@param int total logged in users */
        public $i_loggedInUsers = 0;
        /** *@param int total blocked users */
        public $i_blockedUsers = 0;

        // os types
        /** * @param int how many users came with windows? */
        public $i_osWindows = 0;
        /** * @param int how many users came with macOS? */
        public $i_osMac = 0;
        /** * @param int how many users came with linux? */
        public $i_osLinux = 0;
        /** * @param int how many users came with android? */
        public $i_osAndroid = 0;
        /** * @param int how many users came with iOS? */
        public $i_iOS = 0;
        /** * @param int how many operating systems were unable to detect? */
        public $i_osUnknown = 0;

        // os versions
        /** * @param int how many users came with windows11? */
        public $i_windows11 = 0;
        /** * @param int how many users came with windows10? */
        public $i_windows10 = 0;
        /** * @param int how many users came with windows8? */
        public $i_windows8 = 0;
        /** * @param int how many users came with windows7? */
        public $i_windows7 = 0;
        /** * @param int how many users came with windows vista? */
        public $i_windowsVista = 0;
        /** * @param int how many users came with windows server? */
        public $i_windowsServer = 0;
        /** * @param int how many users came with windows xp? */
        public $i_windowsXP = 0;
        /** * @param int how many users came with windows 2000? */
        public $i_windows2000 = 0;
        /** * @param int how many users came with windows me? */
        public $i_windowsME = 0;
        /** * @param int how many users came with windows 98? */
        public $i_windows98 = 0;
        /** * @param int how many users came with windows 95? */
        public $i_windows95 = 0;
        /** * @param int how many users came with windows 3.11? */
        public $i_windows311 = 0;
        /** * @param int how many users came with mac os x? */
        public $i_macosX = 0;
        /** * @param int how many users came with mac os 9? */
        public $i_macos9 = 0;
        /** * @param int how many users came with linux? */
        public $i_linux = 0;
        /** * @param int how many users came with ubuntu? */
        public $i_ubuntu = 0;
        /** * @param int how many users came with iPhone? */
        public $i_iPhone = 0;
        /** * @param int how many users came with iPod? */
        public $i_iPod = 0;
        /** * @param int how many users came with iPad? */
        public $i_iPad = 0;
        /** * @param int how many users came with android? */
        public $i_android = 0;
        /** * @param int how many users came with blackberry? */
        public $i_blackberry = 0;
        /** * @param int how many users came with unknown mobile system? */
        public $i_mobile = 0;
        /** * @param int how many users came with other systems? */
        public $i_others = 0;

        // devices
        /** * @param int how many users came with desktop systems? */
        public $i_desktop = 0;
        /** * @param int how many users came with desktopdevices (in percent) ? */
        public $i_desktopPercent = 0;
        /** * @param int how many users came with tablet devices? */
        public $i_tablet = 0;
        /** * @param int how many users came with tablet devices (in percent) ? */
        public $i_tabletPercent = 0;
        /** * @param int how many users came with mobile devices? */
        public $i_phone = 0;
        /** * @param int how many users came with mobile devices (in percent) ? */
        public $i_phonePercent = 0;

        // logins
        /** * @param int how logins were totally made? */
        public $i_totalLogins = 0;
        /** * @param int how many logins were successful? */
        public $i_loginSuccessful = 0;
        /** * @param int how many logins failed? */
        public $i_loginFailed = 0;
        /** * @param int how many logins were made to frontend? */
        public $i_loginFrontend = 0;
        /** * @param int how many logins were made to backend? */
        public $i_loginBackend = 0;
        /** * @param int how many backend logins were successful? */
        public $i_loginBackendSuccess = 0;
        /** * @param int how many backend logins failed? */
        public $i_loginBackendFailed = 0;
        /** * @param int how many frontend logins were successful? */
        public $i_loginFrontendSuccess = 0;
        /** * @param int how many frontend logins failed? */
        public $i_loginFrontendFailed = 0;
        /** * @param int how many logins were successful? (in percent) */
        public $i_loginSuccessPercentage = 0;
        /** * @param int how many logins failed? (in percent) */
        public $i_loginFailedPercentage = 0;

        // date + time
        /** * @param int number of hits in the morningtime */
        public $i_morning = 0;
        /** * @param int number of hits in the afternoon */
        public $i_afternoon = 0;
        /** * @param int number of hits in the evening */
        public $i_evening = 0;
        /** * @param int number of hits in the night */
        public $i_night = 0;
        /** * @param int number of hits in the morningtime (in percent) */
        public $i_morningPercent = 0;
        /** * @param int number of hits in the afternoon (in percent) */
        public $i_afternoonPercent = 0;
        /** * @param int number of hits in the evening (in percent) */
        public $i_eveningPercent = 0;
        /** * @param int number of hits in the night (in percent) */
        public $i_nightPercent = 0;

        // weekdays
        /** * @param int number of hits on monday */
        public $i_monday = 0;
        /** * @param int number of hits on tuesday */
        public $i_tuesday = 0;
        /** * @param int number of hits on wednesday */
        public $i_wednesday = 0;
        /** * @param int number of hits on thursday */
        public $i_thursday = 0;
        /** * @param int number of hits on friday */
        public $i_friday = 0;
        /** * @param int number of hits on saturday */
        public $i_saturday = 0;
        /** * @param int number of hits on sunday */
        public $i_sunday = 0;
        /** * @param int number of hits on all days (sum) */
        public $i_totalDays = 0;

        /** * @param int number of hits on monday (in percent) */
        public $i_mondayPercent = 0;
        /** * @param int number of hits on tuesday (in percent) */
        public $i_tuesdayPercent = 0;
        /** * @param int number of hits on wednesday (in percent) */
        public $i_wednesdayPercent = 0;
        /** * @param int number of hits on thursday (in percent) */
        public $i_thursdayPercent = 0;
        /** * @param int number of hits on friday (in percent) */
        public $i_fridayPercent = 0;
        /** * @param int number of hits on saturday (in percent) */
        public $i_saturdayPercent = 0;
        /** * @param int number of hits on sunday (in percent) */
        public $i_sundayPercent = 0;

        public function construct()
        {

        }


        /**
         * @brief Return the number of all currently online users
         * @param object $db Database Object
         * @return int|null
         */
        public function getOnlineUsers($db)
        {   /* @param $db \YAWK\db */
            // first of all: delete all outdated sessions
            $this->deleteOutdatedSessions($db);
            // init count var
            $i = 0;
            // get online users from database
            if ($res = $db->query("SELECT phpSessionID FROM {users_online}"))
            {   // gogo
                while ($row = $res->fetch_assoc())
                {   // count entries
                    $i++;
                }
                $this->currentOnline = $i;
                return $i;
            }
            else
            {
                return null;
            }
        }

        /**
         * @brief Check and delete outdated sessions if they are expired
         * @param object $db Database Object
         * @param int $expireAfter Time in seconds after a session will be deleted
         * @return bool
         */
        public function deleteOutdatedSessions($db)
        {   /* @param $db \YAWK\db */
            // set default expire to 60 seconds
            $sessionExpire = time()-60;
            // DELETE OUTDATED SESSIONS
            if ($db->query("DELETE FROM {users_online} WHERE currentTimeStamp < $sessionExpire"))
            {
                return true;
            }
            else
            {
                // could not delete outdated sessions
                // todo: add syslog entry
                return false;
            }
        }

        /**
         * @brief Set users online in database (stores and check sessions and timestamps)
         * @param object $db Database Object
         * @return null
         */
        public function setOnlineUsers($db)
        {   /* @param $db \YAWK\db */

            // how long
            $this->phpSessionID = session_id();
            $this->currentTimeStamp = time();
            if (!isset($_SESSION['uid']) || (empty($_SESSION['uid'])))
            { $this->uid = 0; }
            else
            { $this->uid = $_SESSION['uid']; }

            // check, if phpSessionID and currentTimeStamp is set
            if (isset($this->phpSessionID) && (isset($this->currentTimeStamp)))
            {
                // check, if this phpSessionID is already in database
                if ($row = $db->query("SELECT * from {users_online} 
                                                WHERE phpSessionID = '$this->phpSessionID'"))
                {
                    // fetch data from users_online
                    if ($res = $row->fetch_assoc())
                    {
                        // create currentTimeStamp
                        $this->currentTimeStamp = time();
                        // user is still online, update currentTimeStamp for this phpSessionID
                        if ($row = $db->query("UPDATE {users_online}
                                                        SET currentTimeStamp = '$this->currentTimeStamp' 
                                                        WHERE phpSessionID = '$this->phpSessionID'"))
                        {
                            // user updated
                        }
                        else
                        {
                            // could not update user status
                            // todo: add syslog entry
                        }
                    }
                    else
                    {   // failed to fetch data, add new phpSessionID and currentTimeStamp
                        if ($db->query("INSERT INTO {users_online} 
                                    (phpSessionID,
                                     uid,
                                     currentTimeStamp)
                            VALUES ('".$this->phpSessionID."',
                                    '".$this->uid."',
                                   '".$this->currentTimeStamp."')"))
                        {
                            // all good
                        }
                        else
                        {   // insert failed
                            // todo: add syslog entry
                        }
                    }
                }
                else
                {   // failed to fetch data, add new phpSessionID and currentTimeStamp
                    if ($db->query("INSERT INTO {users_online} 
                                    (phpSessionID,
                                     currentTimeStamp)
                            VALUES ('".$this->phpSessionID."',
                                   '".$this->currentTimeStamp."')"))
                    {
                        // all good
                    }
                    else
                    {   // insert failed
                        // todo: add syslog entry
                    }
                }
            }
            else
            {
                // session ID or currentTimeStamp are not set
                // todo: add syslog entry
            }

            return true;
        }

        /**
         * @brief Insert statistics data into database
         * @param object $db Database Object
         * @return null
         */
        public function setStats($db)
        {   /* @param $db \YAWK\db */
            // check if stats are enabled
            if (\YAWK\settings::getSetting($db, "statsEnable") == 1)
            {   // prepare user information that we can easily collect
                $this->prepareData();
                // set online users
                $this->setOnlineUsers($db);
                // insert statistics into database
                if ($this->insertData($db) === false)
                {   // insert stats failed, add syslog entry
                    \YAWK\sys::setSyslog($db, 43, 1, "could not insert stats into database.", "", "", "","");
                }
            }
            return null;
        }


        /**
         * @brief Prepare data: get and collect, detect OS and device type
         * @return null
         */
        public function prepareData()
        {
            // check if a session is set
            if (isset($_SESSION) && (!empty($_SESSION)))
            {
                // store current session ID
                $this->phpSessionID = session_id();
                // store current timestamp (will be used for users online counter)
                $this->currentTimeStamp=time();

                // prepare all session user data
                if (isset($_SESSION['uid']) && (!empty($_SESSION['uid'])))
                {   // user id (if logged in)
                    $this->uid = $_SESSION['uid'];
                }
                if (isset($_SESSION['gid']) && (!empty($_SESSION['gid'])))
                {   // user group id (if logged in)
                    $this->gid = $_SESSION['gid'];
                }
                if (isset($_SESSION['logged_in']) && (!empty($_SESSION['logged_in'])))
                {   // user group id (if logged in)
                    $this->logged_in = $_SESSION['logged_in'];
                }
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
            $detect = new \YAWK\Mobile_Detect();

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

            // detect wheter its a phone, pad or pod
            if ( $detect->version('iPhone') ) {
                $this->device = "iPhone";
                $this->os = "iOS";
                $this->osVersion = $detect->version('iPhone');
            }
            if ( $detect->version('iPad') ) {
                $this->device = "iPad";
                $this->os = "iOS";
                $this->osVersion = $detect->version('iPad');
            }
            if ( $detect->version('iPod') ) {
                $this->device = "iPod";
                $this->os = "iOS";
                $this->osVersion = $detect->version('iPod');
            }
            if( $detect->version('Android') ){
                $this->os = "Android";
                $this->osVersion = $detect->version('Android');
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
            return null;
        }


        /**
         * @brief Count all messages that are stored in the database
         * @param object $db Database Object
         * @return mixed
         */
        public function countMessages($db)
        {   /* @param $db \YAWK\db */
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

        /**
         * @brief Count and set user stats like, how many users are registered, currently online or blocked
         * @param object $db Database Object
         * @return bool
         */
        public function getUserStats($db)
        {   /* @param $db \YAWK\db */
            // count all users
            if ($res = $db->query("SELECT id, blocked, online, logged_in  FROM {users}"))
            {
                while ($user = mysqli_fetch_assoc($res))
                {
                    // add user
                    $this->i_users++;

                    // add blocked users
                    if ($user['blocked'] === "1")
                    {
                        $this->i_blockedUsers++;
                    }

                    // add current online users
                    if ($user['online'] === "1")
                    {
                        $this->i_loggedInUsers++;
                    }
                }
                return true;
            }
            else
            {
                return false;
            }
        }


        /**
         * @brief Count system logins
         * @param object $db Database Object
         * @param int $limit Contains an i number to limit the sql request
         * @return array|bool
         */
        public function countLogins($db)
        {   /* @param $db \YAWK\db */
            /*
            if (!isset($limit) || (empty($limit)))
            {
                $limit = 100;
            }
            */
            if ($res = $db->query("SELECT * FROM {logins}"))
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
                if ($this->i_totalLogins > 0)
                {
                    // calculate percentage
                    $total = $this->i_totalLogins;
                    $failed = $this->i_loginFailed;
                    $success = $this->i_loginSuccessful;
                    $total = 100 / $total;
                    $this->i_loginFailedPercentage = round($total * $failed);
                    $this->i_loginSuccessPercentage = round($total * $success);
                }


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


        /**
         * @brief Output JS: PIE CHART login data
         * @param object $db Database Object
         * @param object $lang language
         * @param array $logins data array
         * @return string output the javascript data
         */
        public function getJsonLogins($db, $logins, $lang)
        {   /* @param $db \YAWK\db */
            // check if logins are set
            if (!isset($logins) || (empty($logins)))
            {   // nope, get them from db
                $logins = $this->countLogins($db);
            }
            $jsonData = "[";
            foreach ($logins AS $login => $value)
            {
                // init textcolor
                $textcolor = '';
                // set different colors for each status
                if ($login === "Failed") { $textcolor = "#f56954"; }
                if ($login === "Successful") { $textcolor = "#00a65a"; }

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
            return $jsonData;
        }



        /**
         * @brief Output JS: PIE CHART daytime data
         * @param object $db Database Object
         * @param array $daytime data array
         * @param array language array
         * @return string return the javascript data
         */
        public function getJsonDaytimePieChart($db, $daytimes, $lang)
        {   /* @param $db \YAWK\db */
            // check if logins are set
            if (!isset($daytimes) || (empty($daytimes)))
            {   // nope, get them from db
                $daytimes = $this->countDaytime($db, '', $lang);
            }
            $jsonData = "[";
            foreach ($daytimes AS $daytime => $value)
            {
                // init textcolor
                $textcolor = '';
                // set different colors for each status
                if ($daytime === "$lang[MORNING]") { $textcolor = "#f39c12"; }
                if ($daytime === "$lang[AFTERNOON]") { $textcolor = "#00a65a"; }
                if ($daytime === "$lang[EVENING]") { $textcolor = "#00c0ef"; }
                if ($daytime === "$lang[NIGHT]") { $textcolor = "#003D4C"; }

                // only failed + successful logins, exclude all other values
                if ($daytime !== ("$lang[TOTAL]") &&
                    ($daytime === ("$lang[MORNING]") ||
                        ($daytime === ("$lang[AFTERNOON]") ||
                            ($daytime === ("$lang[EVENING]") ||
                                ($daytime === ("$lang[NIGHT]"))))))
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
            return $jsonData;
        }


        /**
         * @brief Output JS: LINE CHART daytime data
         * @param object $db Database Object
         * @param array $daytimes data array
         * @param array $lang language array
         * @return string output the javascript data
         */
        public function getJsonDaytimeLineChart($db, $daytimes, $lang)
        {   /* @param $db \YAWK\db */
            // check if device types are set
            if (!isset($daytimes) || (empty($daytimes)))
            {   // nope, get them from db
                $daytimes = $this->countDaytime($db, '', $lang);
            }

            $jsonData = "labels: ['$lang[MORNING]', '$lang[AFTERNOON]', '$lang[EVENING]', '$lang[NIGHT]'],
            datasets: [
                {
                  label: '$lang[HITS]',
                  fillColor: ['#f39c12', '#00a65a', '#00c0ef', '#003D4C'],
                  strokeColor: 'rgba(210, 214, 222, 1)',
                  pointColor: 'rgba(210, 214, 222, 1)',
                  pointStrokeColor: '#c1c7d1',
                  pointHighlightFill: '#fff',
                  pointHighlightStroke: 'rgba(220,220,220,1)',  
                  data: [$this->i_morning, $this->i_afternoon, $this->i_evening, $this->i_night]
                }
            ]";
            return $jsonData;
        }


        /**
         * @brief Output JS: BAR CHART daytime data
         * @param object $db Database Object
         * @param array $daytimes data array
         * @return string output the javascript data
         */
        public function getJsonDaytimeBarChart($db, $daytimes, $lang)
        {   /* @param $db \YAWK\db */
            // check if device types are set
            if (!isset($daytimes) || (empty($daytimes)))
            {   // nope, get them from db
                $daytimes = $this->countDaytime($db, '', $lang);
            }

            $jsonData = "labels: ['$lang[MORNING]', '$lang[AFTERNOON]', '$lang[EVENING]', '$lang[NIGHT]'],
            datasets: [
                {
                  label: '$lang[HITS]',
                  fillColor: ['#f39c12', '#00a65a', '#00c0ef', '#003D4C'],
                  strokeColor: 'rgba(210, 214, 222, 1)',
                  pointColor: 'rgba(210, 214, 222, 1)',
                  pointStrokeColor: '#c1c7d1',
                  pointHighlightFill: '#fff',
                  pointHighlightStroke: 'rgba(220,220,220,1)',  
                  data: [$this->i_morning, $this->i_afternoon, $this->i_evening, $this->i_night]
                }
            ]";
            return $jsonData;
        }


        /**
         * @brief Output JS: WEEKDAY BAR CHART
         * @return string output the javascript data
         */
        public function getJsonWeekdayBarChart($lang)
        {   /* @param $db \YAWK\db */
            $jsonData = "labels: ['$lang[MONDAY]', '$lang[TUESDAY]', '$lang[WEDNESDAY]', '$lang[THURSDAY]', '$lang[FRIDAY]', '$lang[SATURDAY]', '$lang[SUNDAY]'],
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
            return $jsonData;
        }


        /**
         * @brief Output JS: PIE CHART browser data
         * @param object $db Database Object
         * @param array $browsers data array
         * @return string output the javascript data
         */
        public function getJsonBrowsers($db, $browsers)
        {   /* @param $db \YAWK\db */
            // check if browsers are set
            if (!isset($browsers) || (empty($browsers)))
            {   // nope, get them from db
                $browsers = $this->countBrowsers($db, '');
            }
            $jsonData = "[";
            foreach ($browsers AS $browser => $value)
            {
                // init textcolor
                $textcolor = '';
                // set different colors for each browser
                if ($browser === "Chrome") { $textcolor = "#f56954"; }
                if ($browser === "IE") { $textcolor = "#00a65a"; }
                if ($browser === "Edge") { $textcolor = "#00a65a"; }
                if ($browser === "Kindle") { $textcolor = "#239330"; }
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
            return $jsonData;
        }


        /**
         * @brief Output JS: PIE CHART OS data
         * @param object $db Database Object
         * @param array $oss data array
         * @return string output the javascript data
         */
        public function getJsonOS($db, $oss)
        {   /* @param $db \YAWK\db */
            // check if browsers are set
            if (!isset($oss) || (empty($oss)))
            {   // nope, get them from db
                $oss = $this->countOS($db, '');
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
            return $jsonData;
        }


        /**
         * @brief Output JS: BAR CHART OS versions
         * @param object $db Database Object
         * @param array $osVersions data array
         * @return string output the javascript data
         */
        public function getJsonOSVersions($db, $osVersions)
        {   /* @param $db \YAWK\db */
            // check if browsers are set
            if (!isset($osVersions) || (empty($osVersions)))
            {   // nope, get them from db
                $osVersions = $this->countOSVersions($db, '');
            }
            $jsonData = "[";
            foreach ($osVersions AS $osVersion => $value)
            {
                // init textcolor
                $textcolor = '';
                // set different colors for each OS version
                if ($osVersion === "Windows 11") { $textcolor = "#00c0ef"; }
                if ($osVersion === "Windows 10") { $textcolor = "#00c0ef"; }
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
            return $jsonData;
        }


        /**
         * @brief Output JS: BAR CHART device types
         * @param object $db Database Object
         * @param object $lang language
         * @param array $deviceTypes data array
         * @return string output the javascript
         */
        public function getJsonDeviceTypes($db, $deviceTypes, $lang)
        {   /* @param $db \YAWK\db */
            // check if device types are set
            if (!isset($deviceTypes) || (empty($deviceTypes)))
            {   // device types are note set - get them from db
                $deviceTypes = $this->countDeviceTypes($db, '');
            }

            $jsonData = "labels: ['$lang[DESKTOP]', '$lang[PHONE]', '$lang[TABLET]'],
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
            return $jsonData;
        }


        /**
         * @brief Set and return the legend textcolor for each browser
         * @param object $db Database Object
         * @param string $browser contains the browser as string
         * @return string returns the textcolor for this browser as string
         */
        public function getBrowserColors($browser)
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


        /**
         * @brief Set and return the legend textcolor for each operating system
         * @param string $os contains the operating system as string
         * @return string returns the textcolor for this OS as string
         */
        public function getOsColors($os)
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


        /**
         * @brief Set and return the legend textcolor for each device type
         * @param string $deviceType contains the type (desktop, phone, tablet) as string
         * @return string returns the textcolor for this device type as string
         */
        public function getDeviceTypeColors($deviceType)
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

        /**
         * @brief Set and return the legend textcolor for each daytime
         * @param string $daytime contains the daytime (morning, afternoon, evening, night) as string
         * @return string returns the textcolor for this daytime as string
         */
        public function getDaytimeColors($daytime, $lang)
        {
            switch ($daytime) {
                case "$lang[MORNING]":
                    $textcolor = "text-orange";
                    break;
                case "$lang[AFTERNOON]":
                    $textcolor = "text-green";
                    break;
                case "$lang[EVENING]":
                    $textcolor = "text-blue";
                    break;
                case "$lang[NIGHT]":
                    $textcolor = "text-navy";
                    break;
                default:
                    $textcolor = "text-black";
            }
            return $textcolor;
        }

        /**
         * @brief Set and return the legend textcolor for logins (failed | success)
         * @param string $login contains the status (Failes, Successful...) as string
         * @return string returns the textcolor for this login status as string
         */
        public function getLoginColors($login)
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


        /**
         * @brief Set and return the legend textcolor for each OS Version
         * @param string $osVersions contains the operating system as string
         * @return string returns the textcolor for this os as string
         */
        public function getOsVersionsColors($osVersions)
        {
            switch ($osVersions) {
                case "Windows 10":
                    $textcolor = "text-blue";
                    break;
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


        /**
         * @brief Count and set the number of hits for each weekday
         * @param object $db the database object
         * @param string $data array containing all the stats data
         * @param string $limit contains i number for sql limitation
         * @param object $lang language array
         * @return array|bool containing weekdays and number of hits
         */
        public function countWeekdays($db, $data, $lang, $limit)
        {   /* @param $db \YAWK\db */

            // check if limit (i) is set
            if (!isset($limit) || (empty($limit)))
            {   // set default value
                $limitSql = '';
            }
            else
            {
                $limitSql = ' LIMIT '.$limit;
            }
            // check if data array is set, if not load data from db
            if (!isset($data) || (empty($data) || (!is_array($data))))
            {   // data is not set or in false format, try to get it from database
                if ($res = $db->query("SELECT date_created FROM {stats} ORDER BY id DESC$limitSql"))
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

            /*
            // LIMIT the data to x entries
            if (isset($limit) && (!empty($limit)))
            {   // if limit is set, cut array to limited range
                $data = array_slice($data, 0, $limit, true);
            }
            */

            // break up the date & extract the hour to calculate
            foreach ($data as $date => $value)
            {
                $weekday = \YAWK\sys::getWeekday($value['date_created'], $lang);

                // identify days
                if ($weekday === "Monday" ||
                    ($weekday === "$lang[MONDAY]"))
                {
                    $this->i_monday++;
                }
                elseif ($weekday === "Tuesday" ||
                    ($weekday === "$lang[TUESDAY]"))
                {
                    $this->i_tuesday++;
                }
                elseif ($weekday === "Wednesday" ||
                    ($weekday === "$lang[WEDNESDAY]"))
                {
                    $this->i_wednesday++;
                }
                elseif ($weekday === "Thursday" ||
                    ($weekday === "$lang[THURSDAY]"))
                {
                    $this->i_thursday++;
                }
                elseif ($weekday === "Friday" ||
                    ($weekday === "$lang[FRIDAY]"))
                {
                    $this->i_friday++;
                }
                elseif ($weekday === "Saturday" ||
                    ($weekday === "$lang[SATURDAY]"))
                {
                    $this->i_saturday++;
                }
                elseif ($weekday === "Sunday" ||
                    ($weekday === "$lang[SUNDAY]"))
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
                "$lang[MONDAY]" => $this->i_monday,
                "$lang[TUESDAY]" => $this->i_tuesday,
                "$lang[WEDNESDAY]" => $this->i_wednesday,
                "$lang[THURSDAY]" => $this->i_thursday,
                "$lang[FRIDAY]" => $this->i_friday,
                "$lang[SATURDAY]" => $this->i_saturday,
                "$lang[SUNDAY]" => $this->i_sunday,
                "$lang[TOTAL]" => $this->i_totalDays
            );

            // return OS data array
            return $weekdays;
        }


        /**
         * @brief Calculate hits in percent for each weekday
         * @return array|bool containing weekdays and number of hits in percent
         */
        public function getWeekdaysPercent($lang)
        {
            if ($this->i_totalDays > 0)
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
                    "$lang[MONDAY]" => $this->i_mondayPercent,
                    "$lang[TUESDAY]" => $this->i_tuesdayPercent,
                    "$lang[WEDNESDAY]" => $this->i_wednesdayPercent,
                    "$lang[THURSDAY]" => $this->i_thursdayPercent,
                    "$lang[FRIDAY]" => $this->i_fridayPercent,
                    "$lang[SATURDAY]" => $this->i_saturdayPercent,
                    "$lang[SUNDAY]" => $this->i_sundayPercent
                );
                arsort($weekdaysPercent);
                return $weekdaysPercent;
            }
            else
            {
                return null;
            }
        }


        /**
         * @brief Count and set the number of hits for each daytime
         * @param object $db the database object
         * @param string $data array containing all the stats data
         * @param string $limit contains i number for sql limitation
         * @return array|bool containing daytimes (and number of hits
         */
        public function countDaytime($db, $data, $lang)
        {   /* @param $db \YAWK\db */

            /*
                // check if limit (i) is set
                if (!isset($limit) || (empty($limit)))
                {   // set default value
                    $limit = 100;
                }
            */

            // check if data array is set, if not load data from db
            if (!isset($data) || (empty($data) || (!is_array($data))))
            {   // data is not set or in false format, try to get it from database
                if ($res = $db->query("SELECT date_created FROM {stats} ORDER BY id DESC"))
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

            /*
            // LIMIT the data to x entries
            if (isset($limit) && (!empty($limit)))
            {   // if limit is set, cut array to limited range
                $data = array_slice($data, 0, $limit, true);
            }
            */

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
                "$lang[MORNING]" => $this->i_morning,
                "$lang[AFTERNOON]" => $this->i_afternoon,
                "$lang[EVENING]" => $this->i_evening,
                "$lang[NIGHT]" => $this->i_night,
                "$lang[TOTAL]" => $total
            );

            // return OS data array
            return $dayTimes;
        }



        /**
         * @brief Calculate hits per daytime and return data in percent
         * @param object $db the database object
         * @return array containing daytimes and number of hits in percent
         */
        public function getDayTimesPercent($lang)
        {
            // count daytimes
            $total = $this->i_morning+$this->i_afternoon+$this->i_evening+$this->i_night;

            if ($total > 0)
            {
                // calculate percentage
                $a = 100 / $total;
                $this->i_morningPercent = round($a * $this->i_morning);
                $this->i_afternoonPercent = round($a * $this->i_afternoon);
                $this->i_eveningPercent = round($a * $this->i_evening);
                $this->i_nightPercent = round($a * $this->i_night);


                // build an array, cointaining the device types and the number how often it's been found
                $dayTimesPercent = array(
                    "$lang[MORNING]" => $this->i_morningPercent,
                    "$lang[AFTERNOON]" => $this->i_afternoonPercent,
                    "$lang[EVENING]" => $this->i_eveningPercent,
                    "$lang[NIGHT]" => $this->i_nightPercent
                );
                arsort($dayTimesPercent);
                return $dayTimesPercent;
            }
            else
            {
                return null;
            }
        }


        /**
         * @brief Count and return browsers
         * @param object $db the database object
         * @param string $data array containing all the stats data
         * @param string $limit contains i number for sql limitation
         * @return array|bool returning array containing the browsers and their hits
         */
        public function countBrowsers($db, $data)
        {   /* @param $db \YAWK\db */

            /*
                // check if limit (i) is set
                if (!isset($limit) || (empty($limit)))
                {   // set default value
                    $limit = 100;
                }
            */

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
                // \YAWK\alert::draw("warning", "database needed", "need to get browser data - array not set, empty or not an array.", "", 0);
                if ($res = $db->query("SELECT browser FROM {stats} ORDER BY id DESC"))
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

            /*
            // LIMIT the data to x entries
            if (isset($limit) && (!empty($limit)))
            {   // if limit is set, cut array to limited range
                $data = array_slice($data, 0, $limit, true);
            }
            */

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


        /**
         * @brief Count device types (desktop, phone or tablet)
         * @param object $db the database object
         * @param string $data array containing all the stats data
         * @param string $limit contains i number for sql limitation
         * @return array|bool returning array containing device types and their hits
         */
        public function countDeviceTypes($db, $data)
        {   /* @param $db \YAWK\db */

            /*
            // check if limit (i) is set
            if (!isset($limit) || (empty($limit)))
            {   // set default value
                $limit = 100;
            }
            */

            // check if data array is set, if not load data from db
            if (!isset($data) || (empty($data) || (!is_array($data))))
            {   // data is not set or in false format, try to get it from database
                $intervalQuery = "WHERE {stats}.date_created > DATE_SUB(CURDATE(), INTERVAL 1 DAY)";
                if ($res = $db->query("SELECT deviceType FROM {stats} $intervalQuery ORDER BY id DESC"))
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

            /*
            // LIMIT the data to x entries
            if (isset($limit) && (!empty($limit)))
            {   // if limit is set, cut array to limited range
                $data = array_slice($data, 0, $limit, true);
            }
            */
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
            // calculate percentage of device types
            if ($total > 0)
            {
                $a = 100 / $total;
                $this->i_desktopPercent = $a * $this->i_desktop;
                $this->i_tabletPercent = $a * $this->i_tablet;
                $this->i_phonePercent = $a * $this->i_phone;
                // build an array, cointaining the device types and the number how often it's been found
                $deviceTypes = array(
                    "Desktop" => $this->i_desktop,
                    "Tablet" => $this->i_tablet,
                    "Phone" => $this->i_phone,
                    "Total" => $total
                );
                // return device type array
                return $deviceTypes;
            }
            else
            {   // no result,
                return null;
            }
        }


        /**
         * @brief Count operating systems
         * @param object $db the database object
         * @param string $data array containing all the stats data
         * @param string $limit contains i number for sql limitation
         * @return array|bool returning array containing all detected operating systems and their hits
         */
        public function countOS($db, $data)
        {   /* @param $db \YAWK\db */

            /*
                // check if limit (i) is set
                if (!isset($limit) || (empty($limit)))
                {   // set default value
                    $limit = 100;
                }
            */
            // check if data array is set, if not load data from db
            if (!isset($data) || (empty($data) || (!is_array($data))))
            {   // data is not set or in false format, try to get it from database
                // \YAWK\alert::draw("warning", "database needed", "need to get browser data - array not set, empty or not an array.", "", 0);
                if ($res = $db->query("SELECT os FROM {stats} ORDER BY id DESC"))
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

            /*
            // LIMIT the data to x entries
            if (isset($limit) && (!empty($limit)))
            {   // if limit is set, cut array to limited range
                $data = array_slice($data, 0, $limit, true);
            }
            */
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


        /**
         * @brief Count operating systems versions
         * @param object $db the database object
         * @param string $data array containing all the stats data
         * @return array|bool returning array containing all detected OS versions and their hits
         */
        public function countOSVersions($db, $data)
        {   /* @param $db \YAWK\db */

            /*
                // check if limit (i) is set
                if (!isset($limit) || (empty($limit)))
                {   // set default value
                    $limit = 100;
                }
            */
            // check if data array is set, if not load data from db
            if (!isset($data) || (empty($data) || (!is_array($data))))
            {   // data is not set or in false format, try to get it from database
                // \YAWK\alert::draw("warning", "database needed", "need to get browser data - array not set, empty or not an array.", "", 0);
                if ($res = $db->query("SELECT osVersion FROM {stats} ORDER BY id DESC"))
                {   // create array
                    $data = array();
                    while ($row = mysqli_fetch_assoc($res))
                    {   // add data to array
                        $data[] = $row;
                    }
                    return $data;
                }
                else
                {   // data array not set and unable to get data from db
                    return false;
                }
            }

            /*
            // LIMIT the data to x entries
            if (isset($limit) && (!empty($limit)))
            {   // if limit is set, cut array to limited range
                $data = array_slice($data, 0, $limit, true);
            }
            */

            // count browsers
            foreach ($data AS $item => $osVersion) {   // add +1 for each found
                // count Operating Systems Versions
                if ($osVersion['os'] === "Android")
                {
                    $osVersion['osVersion'] .= "Android ".$osVersion['osVersion'];
                }
                switch ($osVersion['osVersion'])
                {
                    case "Windows 11";
                        $this->i_windows11++;
                        break;
                    case "Windows 10";
                        $this->i_windows10++;
                        break;
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
            $total = $this->i_windows11
                +$this->i_windows10
                +$this->i_windows8
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
                "Windows 11" => $this->i_windows11,
                "Windows 10" => $this->i_windows10,
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
         * @brief Returns an array with all stats, ordered by date_created.
         * @param object $db Database Object
         * @param string $interval The interval to get data
         * @param string $period The time period (YEAR, MONTH, DAY, HOUR, MINUTE or SECOND)
         * @return bool|array containing all stats from database
         */
        public function getStatsArray($db, $interval, $period) // get all settings from db like property
        {
            /* @param $db \YAWK\db */
            // get online users
            $this->currentOnline = $this->getOnlineUsers($db);

            // check if period is set
            if (!isset($period) || (empty($period)))
            {   // set default to show data of the last day (last 24 hours)
                $period = "DAY";
            }
            // check if interval is set, empty and be sure that it is an integer
            if (!isset($interval) || (empty($interval)))
            {   // if no interval is given or wrong datatype, show all data
                $intervalQuery = '';    // leave empty in this case
            }
            // check if interval is correct int data type
            if (isset($interval) && (isset($period)))
            {   // ok. lets check it
                switch ($interval)
                {   // if zero
                    case 0:
                        // no additional query, leave empty
                        $intervalQuery = '';
                        break;

                    // if any other value than zero
                    default:
                        // extend the query to get data for given time period
                        $intervalQuery = "WHERE {stats}.date_created > DATE_SUB(NOW(), INTERVAL $interval $period)";
                }
            }
            else
            {   // in any other case leave empty and get all data
                $intervalQuery = '';
            }

            // get stats data from database feat. prepared string
            if ($res = $db->query("SELECT * FROM {stats} $intervalQuery ORDER BY date_created DESC"))
            {   // this array helds all stats data
                $statsArray = array();
                // gogo
                while ($row = $res->fetch_assoc())
                {   // fill array
                    $statsArray[] = $row;
                }
            }
            else
            {   // q failed, set syslog and throw error
                \YAWK\sys::setSyslog($db, 43, 1, "failed to get stats from database.", 0, 0, 0, 0);
                \YAWK\alert::draw("warning", "Warning!", "Fetch database error: getStatsArray failed.","","4800");
                return false;
            }
            // check if there is a stats array
            if (is_array($statsArray) && (!empty($statsArray)))
            {   // ok, go ahead with the data
                $this->calculateStatsFromArray($db, $statsArray);
                // and finally...
                return $statsArray;
            }
            else
            {   // stats array is not an array or empty - in this case
                return null;
            }
        }


        /**
         * @brief Calculate some basic stats (almost outdated)
         * @param object $db Database Object
         * @param array $data Stats Data Array
         */
        public function calculateStatsFromArray($db, $data)
        {   // get stats data
            if (!isset($data) || (empty($data)))
            {
                // get statistics into array
                $data = $this->getStatsArray($db, '', '');
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


        /**
         * @brief Insert data into database
         * @param object $db Database Object
         * @return bool
         */
        public function insertData($db)
        {   /* @param $db \YAWK\db */
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


        /**
         * @brief Draw a default box containing user statistics
         * @param object $db Database Object
         * @param object $lang language object
         */
        public function drawUserStats($db, $lang)
        {
            if (self::getUserStats($db))
            {
                echo "<!-- user settings box -->
        <div class=\"box\">
            <div class=\"box-header with-border\">
                <h3 class=\"box-title\">$lang[USER] $lang[STATS] <small>$lang[TOTAL_LOGGED_BLOCKED]</small></h3>
            </div>
            <div class=\"box-body\">
                $lang[USERS]: <b>$this->i_users</b><br>
                $lang[BLOCKED]: <b>$this->i_blockedUsers</b><br>
                $lang[LOGGED_IN]: <b>$this->i_loggedInUsers</b>
            </div>
        </div>
        <!-- / stats settings box -->";

            }
        }


        /**
         * @brief Draw default box containing OS Statistics
         * @param object $db Database Object
         * @param object $lang language
         * @param string $data array containing all the stats data
         * @param string $limit contains i number for sql limitation
         */
        public function drawOsBox($db, $data, $lang)
        {   /** @var $db \YAWK\db */
            // get data for this box
            $oss = $this->countOS($db, $data);

            echo "<!-- donut box:  -->
        <div class=\"box box-default\">
            <div class=\"box-header with-border\">
                <h3 class=\"box-title\">$lang[OPERATING_SYSTEMS] <small>($lang[BETA])</small></h3>

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
                                var PieData = "; echo $this->getJsonOS($db, $oss);
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
                $textcolor = $this->getOsColors($os);
                // show browsers their value is greater than zero and exclude totals
                if ($value > 0 && ($os !== "Total"))
                {   // 1 line for every browser
                    echo "<li><i class=\"fa fa-circle-o $textcolor\"></i> <b>$value</b> $os</li>";
                }
                // show totals
                if ($os === "Total")
                {   // of how many visits
                    echo "<li class=\"small\">$lang[LATEST] $value $lang[USERS]</li>";
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
                    $textcolor = $this->getOsColors($os);
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



        /**
         * @brief Draw default box containing browser statistics
         * @param object $db Database Object
         * @param object $db language
         * @param string $data array containing all the stats data
         * @param string $limit contains i number for sql limitation
         */
        public function drawBrowserBox($db, $data, $lang)
        {   /** @var $db \YAWK\db */
            // get data for this box
            $browsers = $this->countBrowsers($db, $data);

            echo "<!-- donut box:  -->
        <div class=\"box box-default\">
            <div class=\"box-header with-border\">
                <h3 class=\"box-title\">$lang[BROWSER] <small>$lang[USAGE]</small></h3>

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
                                var PieData = "; echo $this->getJsonBrowsers($db, $browsers);
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
                $textcolor = $this->getBrowserColors($browser);
                // show browsers their value is greater than zero and exclude totals
                if ($value > 0 && ($browser !== "Total"))
                {   // 1 line for every browser
                    echo "<li><i class=\"fa fa-circle-o $textcolor\"></i> <b>$value</b> $browser</li>";
                }
                // show totals
                if ($browser === "Total")
                {   // of how many visits
                    echo "<li class=\"small\">$lang[LATEST] $value $lang[VISITORS]</li>";
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
                    $textcolor = $this->getBrowserColors($browser);
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


        /**
         * @brief Draw default box containing OS versions statistics
         * @param object $db Database Object
         * @param object $lang language
         * @param string $data array containing all the stats data
         * @param string $limit contains i number for sql limitation
         */
        public function drawOsVersionBox($db, $data, $lang)
        {   /** @var $db \YAWK\db */
            // get data for this box

            $osVersions = $this->countOSVersions($db, $data);

            echo "<!-- donut box:  -->
        <div class=\"box box-default\">
            <div class=\"box-header with-border\">
                <h3 class=\"box-title\">$lang[OPERATING_SYSTEM] $lang[VERSIONS] <small>($lang[BETA])</small></h3>

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
                                var PieData = "; echo $this->getJsonOSVersions($db, $osVersions);
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
                $textcolor = $this->getOsVersionsColors($osVersion);
                // show browsers their value is greater than zero and exclude totals
                if ($value > 0 && ($osVersion !== "Total"))
                {   // 1 line for every browser
                    echo "<li><i class=\"fa fa-circle-o $textcolor\"></i> <b>$value</b> $osVersion</li>";
                }
                // show totals
                if ($osVersion === "Total")
                {   // of how many visits
                    echo "<li class=\"small\">$lang[LATEST] $value $lang[HITS]</li>";
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
                    $textcolor = $this->getOsVersionsColors($osVersion);
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

        /**
         * @brief Draw default box containing device types
         * @param object $db Database Object
         * @param object $lang language
         * @param string $data array containing all the stats data
         * @param string $limit contains i number for sql limitation
         */
        public function drawDeviceTypeBox($db, $data, $lang)
        {   /** @var $db \YAWK\db */
            // get data for this box
            $deviceTypes = $this->countDeviceTypes($db, $data);

            echo "<!-- donut box:  -->
        <div class=\"box box-default\">
            <div class=\"box-header with-border\">
                <h3 class=\"box-title\">$lang[DEVICE_TYPE] <small>($lang[DESKTOP_MOBILE_TABLET])</small></h3>

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
                            
                            var barChartData = {";echo $this->getJsonDeviceTypes($db, $deviceTypes, $lang); echo "};
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
            if ($deviceTypes)
            {
                foreach ($deviceTypes AS $deviceType => $value)
                {   // get text colors
                    $textcolor = $this->getDeviceTypeColors($deviceType);
                    // show browsers their value is greater than zero and exclude totals
                    if ($value > 0 && ($deviceType !== "Total"))
                    {   // 1 line for every browser
                        echo "<li><i class=\"fa fa-circle-o $textcolor\"></i> <b>$value</b> $deviceType</li>";
                    }
                    // show totals
                    if ($deviceType === "Total")
                    {   // of how many visits
                        echo "<li class=\"small\">$lang[LATEST] $value $lang[USERS]</li>";
                    }
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
            if (is_array($deviceTypes) && (!empty($deviceTypes)))
            {
                $deviceTypes[] = arsort($deviceTypes);
                // walk through array and display browsers as nav pills
                foreach ($deviceTypes as $deviceType => $value)
                {   // show only items where browser got a value
                    if ($value !== 0 && $deviceType !== 0)
                    {   // get different textcolors
                        $textcolor = $this->getDeviceTypeColors($deviceType);
                        echo "<li><a href=\"#\" class=\"$textcolor\">$deviceType
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


        /**
         * @brief Draw default box containing login statistics
         * @param object $db Database Object
         * @param object $lang language
         * @param string $data array containing all the stats data
         * @param string $limit contains i number for sql limitation
         */
        public function drawLoginBox($db, $lang)
        {   /** @var $db \YAWK\db */
            // get data for this box
            $logins = $this->countLogins($db);

            echo "<!-- donut box:  -->
        <div class=\"box box-default\">
            <div class=\"box-header with-border\">
                <h3 class=\"box-title\">$lang[LOGINS] <small>$lang[OVERVIEW_LOGINS]</small></h3>

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
                                var PieData = ";echo $this->getJsonLogins($db, $logins, $lang);
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
                $textcolor = $this->getLoginColors($login);
                // show browsers their value is greater than zero and exclude totals
                if ($value > 0 && ($login !== "Total") && ($login === "FailedPercentage") || ($login === "SuccessPercentage"))
                {   // 1 line for every browser
                    if ($login === "FailedPercentage") { $login = $lang['FAILED']; }
                    if ($login === "SuccessPercentage") { $login = $lang['SUCCESSFUL']; }
                    echo "<li><i class=\"fa fa-circle-o $textcolor\"></i> <b>$value%</b> $login</li>";
                }
                // show totals
                if ($login === "Total")
                {   // of how many visits
                    echo "<li class=\"small\">$lang[LATEST] $value $lang[LOGINS]</li>";
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
                    $textcolor = $this->getLoginColors($login);
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


        /**
         * @brief Draw default box containing daytime statistics
         * @param object $db Database Object
         * @param string $data array containing all the stats data
         * @param string $limit contains i number for sql limitation
         * @param object $lang language object
         */
        public function drawDaytimeBox($db, $data, $lang)
        {   /** @var $db \YAWK\db */
            // get data for this box
            $dayTimes = $this->countDaytime($db, $data, $lang);
            $dayTimesPercent = $this->getDayTimesPercent($lang);

            echo "<!-- donut box:  -->
        <div class=\"box box-default\">
            <div class=\"box-header with-border\">
                <h3 class=\"box-title\">$lang[DAYTIME] <small>$lang[PRIMETIME_QUESTION]</small></h3>

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
                                var PieData = ";echo $this->getJsonDaytimePieChart($db, $dayTimes, $lang);
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
                            
                            var barChartData = {";echo $this->getJsonDaytimeBarChart($db, $dayTimes, $lang);echo "};
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
                               var lineChartData = {";print $this->getJsonDaytimeLineChart($db, $dayTimes, $lang);echo "};
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
            if ($dayTimesPercent)
            {
                foreach ($dayTimesPercent AS $daytime => $value)
                {   // get text colors
                    $textcolor = $this->getDaytimeColors($daytime, $lang);
                    // show browsers their value is greater than zero and exclude totals
                    if ($value > 0 && ($daytime !== "$lang[TOTAL]"))
                    {   // 1 line for every browser
                        $spacer = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                        if ($daytime === "$lang[MORNING]")
                        { $legend = "$spacer<small>06:00 - 11:00</small>"; }
                        elseif ($daytime === "$lang[AFTERNOON]")
                        { $legend = "$spacer<small>12:00 - 17:00</small>"; }
                        elseif ($daytime === "$lang[EVENING]")
                        { $legend = "$spacer<small>18:00 - 23:00</small>"; }
                        elseif ($daytime === "$lang[NIGHT]")
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
                    $textcolor = $this->getDaytimeColors($dayTime, $lang);
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


        /**
         * @brief Draw default box containing weekday statistics
         * @param object $db Database Object
         * @param string $data array containing all the stats data
         * @param string $limit contains i number for sql limitation
         * @param object $lang language array
         */
        public function drawWeekdayBox($db, $data, $lang, $limit)
        {   /** @var $db \YAWK\db */
            // get data for this box
            $weekdays = $this->countWeekdays($db, $data, $lang, $limit);
            $weekdaysPercent = $this->getWeekdaysPercent($lang);

            if ($limit == 0)
            {
                $heading = $lang['WHOLE_PERIOD'];
            }
            else
            {
                $heading = "$lang[THE_LATEST] $limit $lang[DAYS]";
            }

            echo "<!-- donut box:  -->
        <div class=\"box box-default\">
            <div class=\"box-header with-border\">
                <h3 class=\"box-title\">$lang[WEEKDAYS] <small>$lang[WEEKDAY_OVERVIEW] $heading</small></h3>

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
                            
                            var barChartData = {";echo $this->getJsonWeekdayBarChart($lang);echo "};
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
            if ($weekdaysPercent)
            {
                // walk through array and draw data beneath pie chart
                foreach ($weekdaysPercent AS $weekday => $value)
                {   // get text colors
                    // show browsers their value is greater than zero and exclude totals
                    if ($value > 0 && ($weekday !== "$lang[TOTAL]"))
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

        /**
         * @brief Draw default box containing overview statistics
         * @param array $lang language array
         */
        public function drawOverviewBox($lang)
        {
            echo "
<div class=\"row\">
    <div class=\"col-md-12\">
        <!-- box -->
        <div class=\"box\">
            <div class=\"box-header with-border\">
                <h3 class=\"box-title\">$lang[STATS] <small>$lang[HITS_AND_USER_BEHAVIOR] </small></h3>
            </div>
            <div class=\"box-body\">";
            $this->i_hits = number_format($this->i_hits, 0, '.', '.');

            echo "$lang[ACTIVE_SESSIONS]: <b>$this->currentOnline</b><br>
                $lang[HITS] $lang[OVERALL]:<b> $this->i_hits</b><br>
                $lang[GUESTS]: <b> $this->i_publicUsersPercentage</b> % <small>($this->i_publicUsers)</small><br>
                $lang[MEMBERS]: <b> $this->i_loggedUsersPercentage</b> % <small>($this->i_loggedUsers)</small><br>
            </div>
        </div>
        <!-- / box -->
    </div>
</div>";
        }

        /**
         * @brief Draw default box containing pages statistics
         * @param array $data stats data array
         * @param array $lang language array
         */
        public function drawPagesBox($data, $lang)
        {
            echo "
        <!-- box -->
        <div class=\"box\">
            <div class=\"box-header with-border\">
                <h3 class=\"box-title\">$lang[PAGE_VIEWS] <small> $lang[HITS_FROM_MOST_TO_LEAST]</small></h3>
            </div>";
            $res = array();
            if (is_array($data))
            {
                // $data = array_slice($data, 0, $limit, true);
                foreach ($data AS $page => $value)
                {
                    $res[] = $value['page'];
                }
            }

            $res = (array_count_values($res));
            arsort($res);
            echo "<div class=\"box-footer no-padding\">
                <ul class=\"nav nav-pills nav-stacked\">";

            // walk through array and display pages as nav pills
            foreach ($res as $page => $value)
            {   // show only items where browser got a value
                if ($value !== 0 && $page !== 0)
                {   // get different textcolors
                    echo "<li><a href=\"../$page\" target=\"_blank\"><b>$value</b> &nbsp;<span class=\"text-blue\">$page</span></a></li>";
                }
            }

            echo "</ul>
            </div>";
        }

        /**
         * @brief Draw default box containing days of month statistics
         * @param array $lang language array
         */
        public function getDaysOfMonthBox($lang)
        {
            echo "<div class=\"box\">";
            echo "<div class=\"box-header\"><h3 class=\"box-title\">$lang[DAYS_OF_MONTH]</h3></div>";
            echo "<div class=\"box-body\">";

            $daysOfMonth = date("t",mktime(0, 0, 0, 9, 1, 2017));
            $daysOfMonth++; // Zähler bei 1
            for($i = 1; $i < $daysOfMonth; $i++){
                echo $i."\n";
            }
            echo "</div>";
            echo "</div>"; // end box
        }

    }
}
