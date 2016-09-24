<?php
namespace YAWK {
    /**
     * <b>handles many of yawk's system core functions.</b>
     *
     * Most of them are static functions, like get and set paths, get ids, roles and so on.
     * <p><i>Class covers both, backend & frontend functionality.
     * See Methods Summary for Details!</i></p>
     *
     * @category   CMS
     * @package    Plugins
     * @global     $connection
     * @global     $dbprefix
     * @author     Daniel Retzl <danielretzl@gmail.com>
     * @copyright  2009-2016 Daniel Retzl yawk.goodconnect.net
     * @license    http://www.gnu.org/licenses/gpl-2.0  GNU/GPL 2.0
     * @version    1.0.0
     * @link       http://yawk.goodconnect.net/
     * @since      File available since Release 0.0.2
     * @annotation The sys class - handles yawk's system core functions.
     */
    class sys {

        static function displayGlobalMenu($db)
        {   /** @var \YAWK\db  $db */
            $res = $db->query("SELECT value FROM {settings}
                    WHERE property = 'globalmenuid'");
            if ($row = mysqli_fetch_row($res)) {
                if ($published = \YAWK\menu::getMenuStatus($db, $row[0]) != '0') {
                    menu::display($db, $row[0]);
                }
            }
        }

        /**
         * Read a directory recursively
         * @author      Daniel Retzl <danielretzl@gmail.com>
         * @version     1.0.0
         * @link        http://yawk.website/
         * @param string $path full path e.g. /xampp/htdocs/yawk-LTE/
         * @return array
         */
        public static function read_recursive($path) {
            global $files_count;
            $result = array();
            $handle = opendir($path);
            if ($handle) {

                while (false !== ($file = readdir($handle))) {
                    if ($file != "." && $file != "..") {
                        if (is_file($file)) {
                            $files_count = $files_count + 1;
                        }
                        $name = $path . "/" . $file;

                        if (is_dir($name)) {
                            $ar = self::read_recursive($name);
                            foreach ($ar as $value) {
                                $result[] = $value;
                            }
                        } else {
                            $result[] = $name;
                            $files_count = $files_count + 1;
                        }
                    }
                }
            }
            closedir($handle);
            return $result;
        }

        /**
         * Count code lines and output a small overview
         * @author      Daniel Retzl <danielretzl@gmail.com>
         * @version     1.0.0
         * @link        http://yawk.website/
         * @param object $db database object
         * @param string $path the full path (including base path)
         * @param string $fileType file type with leading dot, for example: '.php'
         * @return mixed array
         */
        public static function countCodeLines($path, $fileType)
        {
            $data = \YAWK\sys::read_recursive($path);
            $linesCount = 0;
            $filesCount = 0;
            foreach($data as $value) {
                // count lines of files with given type
                if (substr($value, -4) === "$fileType") {
                    $lines = file($value);
                    $i_lines = count($lines);
                    $linesCount += $i_lines;
                    unset($lines, $i_lines);
                    $filesCount++;
                }
            }
            return $array = [
                "type" => $fileType,
                "files" => $filesCount,
                "lines" => $linesCount,
            ];
        }

        /**
         * Check if zlib is available
         * @author      Daniel Retzl <danielretzl@gmail.com>
         * @version     1.0.0
         * @link        http://yawk.website/
         * @return bool
         */
        public static function checkZlib()
        {   // check if zlib is installed
            if(extension_loaded('zlib'))
            {   // installed
                return true;
            }
            else
            {   // not installed
                return false;
            }
        }

        /**
         * Copy a file, or recursively copy a folder and its contents
         * @author      Aidan Lister <aidan@php.net>
         * @version     1.0.1
         * @link        http://aidanlister.com/2004/04/recursively-copying-directories-in-php/
         * @param       string   $source    Source path
         * @param       string   $dest      Destination path
         * @param       int      $permissions New folder creation permissions
         * @return      bool     Returns true on success, false on failure
         */
        static function xcopy($source, $dest, $permissions = 0755)
        {   // Check for symlinks
            if (is_link($source)) {
                return symlink(readlink($source), $dest);
            }
            // Simple copy for a file
            if (is_file($source)) {
                return copy($source, $dest);
            }
            // Make destination directory
            if (!is_dir($dest)) {
                mkdir($dest, $permissions);
            }
            // Loop through the folder
            $dir = dir($source);
            while (false !== $entry = $dir->read()) {
                // Skip pointers
                if ($entry == '.' || $entry == '..') {
                    continue;
                }
                // Deep copy directories
                self::xcopy("$source/$entry", "$dest/$entry", $permissions);
            }
            // Clean up
            $dir->close();
            return true;
        }

        /**
         * Minify any string: removes spaces, tabs and linebreaks.
         * @author      Daniel Retzl <danielretzl@gmail.com>
         * @version     1.0.0
         * @link        http://yawk.website/
         * @param       string      $content
         * @return      mixed
         */
        static function  minify($content)
        {   /** minify data */
            // remove comments
            $content = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $content);
            // remove space after colons
            $content = str_replace(': ', ':', $content);
            // remove whitespaces
            $content = str_replace(array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $content);
            return $content;
        }

        static function full_copy( $source, $target )
        {   /** copy an entire folder into another location */
            if ( is_dir( $source ) ) {
                @mkdir( $target );
                $d = dir( $source );
                while ( FALSE !== ( $entry = $d->read() ) ) {
                    if ( $entry == '.' || $entry == '..' ) {
                        continue;
                    }
                    $Entry = $source . '/' . $entry;
                    if ( is_dir( $Entry ) ) {
                        self::full_copy( $Entry, $target . '/' . $entry );
                        continue;
                    }
                    copy( $Entry, $target . '/' . $entry );
                }

                $d->close();
            }else {
                copy( $source, $target );
            }
        }

        static function replaceCarriageReturns($replace, $string)
        {
            return str_replace(array("\n\r", "\n", "\r"), $replace, $string);
        }

        static function addPreTags($customCSS)
        {
            // this function wraps a <pre> tag around the CSS file
            // so that the editor (tinyMCE) can get along with the CSS
            // after submitting the form, <pre> tags will be replaced,
            // so that any browser can interpret the custom.css file proper.
            $preOpen = "<pre style=\"word-wrap: break-word; white-space: pre-wrap;\">";
            $preClose = "</pre>";
            $customCSS = $preOpen .$customCSS;
            $customCSS = $customCSS .$preClose;
            return $customCSS;
        }

        static function replacePreTags($replace, $customCSS)
        {   // this function removes all unnecessary HTML tags from custom.css
            return str_replace(array("<p>", "</p>", "<br />", "</pre>", "<pre style=\"word-wrap: break-word; white-space: pre-wrap;\">"), "", $customCSS);
        }

        static function isOffline($db)
        {   /** @var $db \YAWK\db */
            /* check global site status online / offline */
            if (\YAWK\settings::getSetting($db, "offline") == 1)
            {   // website is in maintaince mode: set offline
                if (\YAWK\user::isAdmin($db) == false)
                {   // site is offline
                    return true;
                }
                else
                {   // website is offline, but display the page to admin
                    return false;
                }
            }
            else
            {   // website is online, display the page for everybody
                return false;
            }
        }

        static function drawOfflineMessage($db)
        {   /** @var $db \YAWK\db */
            /* get offline message + image */
            $offlinemsg = \YAWK\settings::getSetting($db, "offlinemsg");
            $offlineimg = \YAWK\settings::getSetting($db, "offlineimage");
            // draw offline message
            echo "<div style=\"text-align:center;\">
                    <img src=\"".$offlineimg."\"><br><br>
                    ".$offlinemsg."<br><br>
                  </div>";
            exit;
        }

        static function setTimeout($location, $wait)
        {
            /**
             * setTimeout force page reload via JS
             */
            print"<script type=\"text/javascript\">
            setTimeout(\"self.location.href='" . $location . "'\"," . $wait . ");
            </script>
            <noscript>
		 	 <h1>Im Browser muss javascript aktiviert sein, um die Seite richtig nutzen zu k&ouml;nnen.</h1>
			</noscript>";
            return true;
        }

        static function isBrowscapSet($useragent)
        {
            // check if a browscap file is set...
            if (ini_get('browscap'))
            {	// got it, output file path
                $browscapFile = ini_get('browscap');
                // print browser info:
                echo "<pre>"; print_r(get_browser($useragent)); echo "</pre>";
            }
            else
            {	// browscap file not set
                \YAWK\alert::draw("info", "Warning!", "Browscap file not set in your php.ini", "", 7500);
                // try to enable via ini_set
                if (ini_set('browscap', 'browscap.ini'))
                {	// worked, show browser info...
                    echo "<pre>"; print_r(get_browser($useragent)); echo "</pre>";
                }
                else
                {	// enable failed, exit with error
                    return false;
                    // \YAWK\alert::draw("danger", "Error: ", "Browscap file not set in php.ini Tried to enable via ini_set. Did not work... aborting!", "", 15000);
                }
            }
            return null;
        }

        static function getBrowser()
        {
            $u_agent = $_SERVER['HTTP_USER_AGENT'];
            $bname = 'Unknown';
            $platform = 'Unknown';
            $version= "";

            //First get the platform?
            if (preg_match('/linux/i', $u_agent)) {
                $platform = 'linux';
            }
            elseif (preg_match('/macintosh|mac os x/i', $u_agent)) {
                $platform = 'mac';
            }
            elseif (preg_match('/windows|win32/i', $u_agent)) {
                $platform = 'windows';
            }

            // Next get the name of the useragent yes seperately and for good reason
            if(preg_match('/MSIE/i',$u_agent) && !preg_match('/Opera/i',$u_agent))
            {
                $bname = 'Internet Explorer';
                $ub = "MSIE";
            }
            elseif(preg_match('/Trident/i',$u_agent))
            { // this condition is for IE11
                $bname = 'Internet Explorer';
                $ub = "rv";
            }
            elseif(preg_match('/Firefox/i',$u_agent))
            {
                $bname = 'Mozilla Firefox';
                $ub = "Firefox";
            }
            elseif(preg_match('/Chrome/i',$u_agent))
            {
                $bname = 'Google Chrome';
                $ub = "Chrome";
            }
            elseif(preg_match('/Safari/i',$u_agent))
            {
                $bname = 'Apple Safari';
                $ub = "Safari";
            }
            elseif(preg_match('/Opera/i',$u_agent))
            {
                $bname = 'Opera';
                $ub = "Opera";
            }
            elseif(preg_match('/Netscape/i',$u_agent))
            {
                $bname = 'Netscape';
                $ub = "Netscape";
            }

            // finally get the correct version number
            // Added "|:"
            $known = array('Version', $ub, 'other');
            $pattern = '#(?<browser>' . join('|', $known) .
                ')[/|: ]+(?<version>[0-9.|a-zA-Z.]*)#';
            if (!preg_match_all($pattern, $u_agent, $matches)) {
                // we have no matching number just continue
            }

            // see how many we have
            $i = count($matches['browser']);
            if ($i != 1) {
                //we will have two since we are not using 'other' argument yet
                //see if version is before or after the name
                if (strripos($u_agent,"Version") < strripos($u_agent,$ub)){
                    $version= $matches['version'][0];
                }
                else {
                    $version= $matches['version'][1];
                }
            }
            else {
                $version= $matches['version'][0];
            }

            // check if we have a number
            if ($version==null || $version=="") {$version="?";}

            return array(
                'userAgent' => $u_agent,
                'name'      => $bname,
                'version'   => $version,
                'platform'  => $platform,
                'pattern'    => $pattern
            );
        }

        static function getLoadingTime($debugTime)
        {
            // debugTime to measure script time
            $debugTime = microtime(true) - $debugTime;
            $debugTime = number_format($debugTime, 3);
            return "<small>&nbsp; script execution time: $debugTime Sek.</small>";
        }

        static function encodeChars($string)
        {   // requires string. encodes german vowels
            $string = utf8_decode($string);
            $chars = array("�" => "&ouml;", "�" => "&auml;", "�" => "&uuml;",
                "�" => "&Ouml;", "�" => "&Auml;", "�" => "&Uuml;",
                "�" => "&szlig;",
                "�" => "&euro;");
            return strtr($string, $chars);
        }

        static function getDirPrefix($db)
        {   // returns directory prefix from settings
            $dirprefix = settings::getSetting($db, "dirprefix");
            return $dirprefix;
        }

        static function getHost($db)
        {   // get host from settings db
            $hostname = settings::getSetting($db, "host");
            $hostname = self::addTrailingSlash($hostname);
            return $hostname;
        }

        static function addTrailingSlash($url)
        {   // check if url contains a trailing slash at the end
            if (substr($url, -1, 1) !== "/")
            {   // if not, it will be added
                $url = $url."/";
            }
            // return url with trailing slash
            return $url;
        }

        static function getProperty($db, $property, $table, $id)
        {   /** @var $db \YAWK\db $res */
            if ($res = $db->query("SELECT " . $property . " FROM {$table}
                                   WHERE id = '" . $id . "'"))
            {   // fetch data
                if ($row = mysqli_fetch_row($res))
                {   // return property
                    return $row[0];
                }
                else
                {   // fetch failed
                    return false;
                }
            }
            else
            {   // q failed
                return false;
            }
        }

        static function getGroupId($db, $id, $table)
        {   /** @var $db \YAWK\db $res */
            if ($res = $db->query("SELECT cg.id
                              FROM {".$table."} as cp
                              JOIN {user_groups} as cg on cg.id = cp.gid
                              WHERE cp.id = $id"))
            {   // get GroupId (gid) from given table
                $row = mysqli_fetch_row($res);
                return $row[0];
            }
            else
            {
                \YAWK\alert::draw("warning", "Warning", "Could not fetch Group ID from $table", "","2000");
            }
            return false;
        }


        static function getGroupFromId($db, $id, $table)
        {
            /** @var $db \YAWK\db $res */
            if ($res = $db->query("SELECT cp.gid, cg.value
                    FROM {".$table."} as cp
                    JOIN {user_groups} as cg on cg.id = cp.gid
                    WHERE cp.id = $id"))
            {
                while ($row = mysqli_fetch_row($res))
                {
                    echo $row[1];
                }
                return $row[0];
            }
            else {
                \YAWK\alert::draw("warning", "Warning", "Could not fetch Group from page ID $id", "","2000");
                // q failed
                return false;
            }
        }

        static function getGroups($db, $table)
        {
            /** @var $db \YAWK\db $res */
            $groupsArray = '';
            if ($res = $db->query("SELECT id, value, (
	                              SELECT COUNT( * )
	                              FROM {".$table."}
	                              WHERE gid = {user_groups.id}
	                             )count
	                             FROM {user_groups} ORDER by id ASC"))
            {
                while ($row = $res->fetch_assoc())
                {
                    $groupsArray[] = $row;
                }
            return $groupsArray;
            }
            // q failed
            return false;
        }

        static function includeHeader($db)
        {   /** @var $db \YAWK\db */
            global $currentpage;
            $i = 1;
            $host = \YAWK\settings::getSetting($db, "host");
            echo "<title>" . $currentpage->title . "</title>
<meta http-equiv=\"Content-Type\" content=\"text/html; charset=\"utf-8\" />
<link rel=\"shortcut icon\" href=\"favicon.ico\" type=\"image/x-icon\">
<base href=\"".$host."/\">
";
            $get_localtags = $db->query("SELECT name, content
                    FROM {meta_local}
                    WHERE page = '" . $currentpage->id . "'");
            while ($row = mysqli_fetch_row($get_localtags)) {
                if (isset($row['1']) && !empty($row['1'])) {
                    echo "<meta name=\"" . $row[0] . "\" content=\"" . $row[1] . "\" />";
                } else {
                    $get_globaltags = $db->query("SELECT content
		                        FROM {meta_global}
		                        WHERE name = 'description'");
                    $row = mysqli_fetch_row($get_globaltags);
                    while ($i > 0) {
                        echo "<meta name=\"description\" content=\"" . $row[0] . "\" />";
                        $i--;
                    }
                }
            }
        }

        /*
        static function getGroupNameFromID($db, $table)
        {
            /** @var $db \YAWK\db $res
            $groupsArray = '';
            if ($res = $db->query("SELECT id, value, (
	                              SELECT COUNT( * )
	                              FROM {".$table."}
	                              WHERE gid = {user_groups.id}
	                             )count
	                             FROM {user_groups} ORDER by id ASC"))
            {
                $row = $res->fetch_row();
                return $row[1];
            }
            // q failed
            return false;
        }
        */
        static function getCurrentUserName()
        {
            if (isset($_SESSION['username'])) {
                return $_SESSION['username'];
            }
            else {
                return "Gast";
            }
        }

        static function getSubMenu($db, $id)
        {
            /** @var $db \YAWK\db $res */
            if ($res = $db->query("SELECT cm.id
	                           FROM {pages} as cp
	                           JOIN {menu_names} as cm on cm.id = cp.menu
	                           WHERE cp.id = $id")){
                $row = mysqli_fetch_row($res);
                return $row;
            }
            else
            {
                \YAWK\alert::draw("warning", "Warning", "Could not fetch submenu for page ID: $id", "","2000");
                return false;
            }
        }
        static function getMenuItem($db, $id)
        {
            /** @var $db \YAWK\db $res */
            if ($res = $db->query("SELECT cp.menu, cm.name
	                              FROM {pages} as cp
	                              JOIN {menu_names} as cm on cm.id = cp.menu
	                              WHERE cp.id = ".$id.""))
            {
                $row = mysqli_fetch_row($res);
                return $row[0];
            }
            else {
                \YAWK\alert::draw("warning", "Warning!", "Could not fetch menu items for page ID: $id","","2000");
                return false;
            }
        }

        static function getMenus($db)
        {
            /** @var $db \YAWK\db */
            $menusArray = '';
            if ($res = $db->query("SELECT id, name, published, (
                             SELECT COUNT( * )
                             FROM {menu}
                             WHERE menuID = {menu_names.id}
                             ) count FROM {menu_names}"))
            {
                while ($row = $res->fetch_assoc())
                {
                    $menusArray[] = $row;
                }
                return $menusArray;
            }
            else
            {   // q failed
                return false;
            }
        }

        static function getMenuName($db, $id)
        {   /** @var $db \YAWK\db $res */
            if ($res = $db->query("SELECT name
	                              FROM {menu_names}
	                              WHERE id = $id"))
            {   // return menu name
                $row = mysqli_fetch_row($res);
                return $row[0];
            }
            else
            {   // q failed
                return false;
            }
        }

        static function getPages($db)
        {   /** @var $db \YAWK\db */
            if ($res = $db->query("SELECT id, title
                                  FROM {pages} ORDER BY title"))
            {
                $PagesArray = array();
                while ($row = $res->fetch_assoc())
                {
                    $PagesArray[] = $row;
                }
                return $res;
            }
            else
            {
                return false;
            }
        }


        static function getRole($db, $id, $table)
        {   /** @var $db \YAWK\db */
            $mysqlRes = $db->query("SELECT cp.gid, cg.value
                    FROM {".$table."} as cp
                    JOIN {user_groups} as cg on cg.id = cp.gid
                    WHERE cp.id = $id");
            // fetch data
            while ($row = mysqli_fetch_row($mysqlRes)) {
                echo $row[1];
            }
            return $row[0];
        }

        static function getRoleId($db, $id, $table)
        {   /** @var $db \YAWK\db */
            $mysqlRes = $db->query("SELECT cg.id
                              FROM {".$table."} as cp
                              JOIN {user_groups} as cg on cg.id = cp.gid
                              WHERE cp.id = $id");

            if ($row = mysqli_fetch_row($mysqlRes))
            {
                return $row[0];
            }
            else
            {
                return false;
            }
        }

        static function now()
        {   // return current datetime in mysql format
            return date("Y-m-d H:i:s");
        }

        static function splitDate($date)
        {
            $year = substr($date, 0, 4);
            $day = substr($date, 8, 2);
            $month = substr($date, 5, 2);
            $time = substr($date, 11, 5);

            /* f�hrende null entfernen */
            $day = 1 * $day; // Typ�nderung von String auf Integer
            $i = strlen($day);
            // if ($i <= 1) { $day = "".$day; }

            /* monate umrechnen */
            switch ($month) {
                case "01":
                    $month = "J&auml;nner";
                    break;
                case "02":
                    $month = "Februar";
                    break;
                case "03":
                    $month = "M&auml;rz";
                    break;
                case "04":
                    $month = "April";
                    break;
                case "05":
                    $month = "Mai";
                    break;
                case "06":
                    $month = "Juni";
                    break;
                case "07":
                    $month = "Juli";
                    break;
                case "08":
                    $month = "August";
                    break;
                case "09":
                    $month = "September";
                    break;
                case "10":
                    $month = "Oktober";
                    break;
                case "11":
                    $month = "November";
                    break;
                case "12":
                    $month = "Dezember";
                    break;
            }
            return $splitDate = array("year" => "$year", "day" => "$day", "month" => "$month", "time" => "$time");
        }

        static function splitDateShort($date)
        {
            $year = substr($date, 0, 4);
            $day = substr($date, 8, 2);
            $month = substr($date, 5, 2);
            $time = substr($date, 11, 5);

            /* f�hrende null entfernen */
            $day = 1 * $day; // Typ�nderung von String auf Integer
            $i = strlen($day);
            // if ($i <= 1) { $day = "".$day; }

            /* monate umrechnen */
            switch ($month) {
                case "01":
                    $month = "Jan";
                    break;
                case "02":
                    $month = "Feb";
                    break;
                case "03":
                    $month = "Mar";
                    break;
                case "04":
                    $month = "Apr";
                    break;
                case "05":
                    $month = "May";
                    break;
                case "06":
                    $month = "Jun";
                    break;
                case "07":
                    $month = "Jul";
                    break;
                case "08":
                    $month = "Aug";
                    break;
                case "09":
                    $month = "Sep";
                    break;
                case "10":
                    $month = "Okt";
                    break;
                case "11":
                    $month = "Nov";
                    break;
                case "12":
                    $month = "Dez";
                    break;
            }
            return $splitDate = array("year" => "$year", "day" => "$day", "month" => "$month", "time" => "$time");
        }

        static function time_ago($userdate)
        {
            $time_ago = '';

            $date = new \DateTime($userdate);
            $diff = $date->diff(new \DateTime('now'));

            if (($t = $diff->format("%m")) > 0)
                $time_ago = (int)$t . ' months';
            else if (($t = $diff->format("%d")) > 0)
                $time_ago = (int)$t . ' days';
            else if (($t = $diff->format("%H")) > 0)
                $time_ago = (int)$t . ' hours';
            else if (($t = $diff->format("%i")) > 0)
                $time_ago = (int)$t . ' minutes';
            else if (($t = $diff->format("%s")) > 0)
                $time_ago = (int)$t . ' seconds';
            // else
            //    $time_ago = 'minutes';

           // return $time_ago . ' ago (' . $date->format('M j, Y') . ')';
            return $time_ago . ' ago';
        }

        static function setSyslog($db, $log_type, $message, $fromUID, $toUID, $toGID, $seen)
        {   /** @var $db \YAWK\db */
            // THIS DB STORES ALL THE SYSLOG FOR ADMINISTRATOR REASONS
            // insert admin-friendly message of all data into syslog db
            if ($db->query("INSERT INTO {syslog} (log_type,message,fromUID,toUID,toGID,seen)
                                        VALUES ('".$log_type."',
                                                '".$message."',
                                                '".$fromUID."',
                                                '".$toUID."',
                                                '".$toGID."',
                                                '".$seen."')"))
            {   // set a notification into syslog
                return true;
            }
            else
            {   // q failed
                return false;
            }
        }

        static function setNotification($db, $log_type, $msg_id, $fromUID, $toUID, $toGID, $seen)
        {   /** @var $db \YAWK\db */
            // THIS ARE THE MESSAGES FOR END-USERS
            // (a copy of syslog) DUE PERFORMANCE REASONS
            // (only user-messages, no system messages...)
            // insert user-friendly message into notifications db
            if ($db->query("INSERT INTO {notifications} (log_type,msg_id,fromUID,toUID,toGID,seen)
                                        VALUES ('".$log_type."',
                                                '".$msg_id."',
                                                '".$fromUID."',
                                                '".$toUID."',
                                                '".$toGID."',
                                                '".$seen."')"))
            {   // set a notification into syslog
                return true;
            }
            else
            {   // q failed
                return false;
            }
        }

        static function markNotification($db, $id, $seen)
        {   /** @var $db \YAWK\db */
            if (!isset($seen))
            {   // default value
                $seen = 0;
            }
            if ($db->query("UPDATE {notifications} SET seen = '".$seen."' WHERE log_id = '".$id."'"))
            {   // set a notification into syslog
                return true;
            }
            else
            {   // q failed
                return false;
            }
        }

    } // ./class widget
} // ./ namespace