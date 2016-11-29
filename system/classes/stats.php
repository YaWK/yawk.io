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


        // stats variables
        public $i_hits = 0;
        public $i_loggedUsers = 0;
        public $i_publicUsers = 0;

        // os types
        public $i_osWindows = 0;
        public $i_osMac = 0;
        public $i_osLinux = 0;
        public $i_osAndroid = 0;
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

        /**
         * Returns an array with all stats, ordered by date_created.
         * @author Daniel Retzl <danielretzl@gmail.com>
         * @version 1.0.0
         * @link http://yawk.io
         * @param object $db Database Object
         * @param string $property
         * @return mixed
         */
        public static function getStatsArray($db) // get all settings from db like property
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
            return $statsArray;
        }

        public function calculateStats($db)
        {   // get stats data
            $data = \YAWK\stats::getStatsArray($db);
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

                // count Operating Systems
                switch ($item['os'])
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
                    default: $this->i_osUnknown++;
                }

                // count Operating Systems Versions
                switch ($item['osVersion'])
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
                    case "Android";
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

                // count device types
                switch ($item['deviceType'])
                {
                    case "Desktop";
                        $this->i_desktop++;
                        break;
                    case "Tablet";
                        $this->i_tablet++;
                        break;
                    case "Phone";
                        $this->i_phone++;
                        break;
                }


            }

            echo "Total hits: ".$this->i_hits."<br>";
            echo "davon Phone: ".$this->i_phone."<br>";
            echo "davon Tablet: ".$this->i_tablet."<br>";
            echo "davon Desktop: ".$this->i_desktop." Win: $this->i_osWindows Mac: $this->i_osMac Linux: $this->i_osLinux<br>";
            echo "<pre>";
            // print_r($data);
            echo "</pre>";
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


        static function drawBrowserBox($db, $data, $limit)
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
                                    legendTemplate: '<ul class=\"<%=name . toLowerCase() %>-legend\"><% for (var i=0; i<segments.length; i++){%><li><span style=\"background - color:<%=segments[i] . fillColor %>\"></span><%if(segments[i].label){%><%=segments[i].label%><%}%></li><%}%></ul>',
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
    }
}