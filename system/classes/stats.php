<?php
namespace YAWK
{
    class stats
    {
        public $id;
        public $uid;
        public $gid;
        public $logged_in;
        public $remoteAddr;
        public $userAgent;
        public $device;
        public $deviceType;
        public $OS;
        public $browser;
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

            $this->deviceType = ($detect->isMobile() ? ($detect->isTablet() ? 'Tablet' : 'Phone') : 'Computer');

            // Any mobile device (phones or tablets).
            if ( $detect->isMobile() ) {
                // $this->deviceType = "Mobile";
            }

            // Any tablet device.
            if( $detect->isTablet() ){
                // $this->deviceType = "Tablet";
            }

            // No Mobile, no tablet - must be a computer
            if( !$detect->isMobile() && !$detect->isTablet() ){
                // $this->deviceType = "Computer";
                $browser = array();
                $browser = \YAWK\sys::getBrowser($this->userAgent);
                $this->browser = $browser['name'];
                $this->OS = ucfirst($browser['platform']);
            }

            // check OS for iOS
            if( $detect->isiOS() ){
                $this->OS = "iOS";

                if ( $detect->isIphone() ) {
                    $this->device = "iPhone";
                    $this->OS .= " ".$detect->version('iPhone');
                }
                if ( $detect->isIpad() ) {
                    $this->device = "iPad";
                    $this->OS .= " ".$detect->version('iPad');
                }
            }
            else
                {   // check OS for android
                    if( $detect->isAndroidOS() ){
                        $this->OS = "Android";
                        $this->OS .= " ".$detect->version('Android');
                        if ( $detect->isSamsung() ) { $this->device = "Samsung"; }
                        elseif ( $detect->isLG() ) { $this->device = "LG"; }
                        else { $this->device = "Unknown"; }
                    }
                }

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

        function insertData($db)
        {   /* @var $db \YAWK\db */
            if ($db->query("INSERT INTO {stats} 
                                    (uid, 
                                     gid, 
                                     logged_in, 
                                     remoteAddr, 
                                     userAgent, 
                                     device, 
                                     deviceType, 
                                     OS,
                                     browser, 
                                     date_created, 
                                     referer, 
                                     page)
                            VALUES ('".$this->uid."', 
                                   '".$this->gid."', 
                                   '".$this->logged_in."', 
                                   '".$this->remoteAddr."',
                                   '".$this->userAgent."', 
                                   '".$this->device."', 
                                   '".$this->deviceType."', 
                                   '".$this->OS."', 
                                   '".$this->browser."', 
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