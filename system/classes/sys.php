<?php
namespace YAWK {
    /**
     * <b>handles many of yawk's system core functions.</b>
     *
     * Most of them are static functions, like get and set paths, get ids, roles and so on.
     * <p><i>Class covers both, backend & frontend functionality.
     * See Methods Summary for Details!</i></p>
     *
     * @package    YAWK
     * @author     Daniel Retzl <danielretzl@gmail.com>
     * @copyright  2009-2016 Daniel Retzl
     * @license    http://www.gnu.org/licenses/gpl-2.0  GNU/GPL 2.0
     * @version    1.0.0
     * @link       http://yawk.io
     * @annotation The sys class - handles yawk's system core functions.
     */
    class sys
    {

        /**
         * Display a multidimensional array line per line. Expects an array and property
         * @author      Daniel Retzl <danielretzl@gmail.com>
         * @version     1.0.0
         * @link        https://gist.github.com/sbmzhcn/6255314
         */
        static function array2lines($array, $property)
        {

            echo "<h2 class=\"myClass\">$property</h2>";
            foreach ($array[$property] as $item => $key)
            {
                $linkProperty = str_replace(" ", "+", $item);
                if (is_array($key))
                {
                    echo "<li class=\"list-group-item\"><a href=\"https://www.google.at/search?q=php.net+$linkProperty\" title=\"google this: $item setting\" target=\"_blank\"><b>$item</b> = $key[0]</a></li>";
                }
                else
                {
                    echo "<li class=\"list-group-item\"><a href=\"https://www.google.at/search?q=php.net+$linkProperty\" title=\"google this: $item setting\" target=\"_blank\"><b>$item</b> = $key</a></li>";
                }
            }
        }

        static function drawPhpInfo($lang)
        {
            // get data from php info into array
            $data = \YAWK\sys::parse_phpinfo();

            // JS filter script
            echo "
            <script>
                function myFunction() {
                    // Declare variables
                    var input, filter, ul, li, a, i;
                    input = document.getElementById('myInput');
                    filter = input.value.toUpperCase();
                    ul = document.getElementById(\"phpinfoList\");
                    li = ul.getElementsByTagName('li');
    
                    // Loop through all list items, and hide those who don't match the search query
                    for (i = 0; i < li.length; i++) {
                        a = li[i].getElementsByTagName(\"a\")[0];
                        if (a.innerHTML.toUpperCase().indexOf(filter) > -1) {
                            li[i].style.display = \"\";
                            $('.myClass').show();
                        } else {
                            li[i].style.display = \"none\";
                            $('.myClass').hide();
    
                        }
                    }
                }
            </script>";

            echo "<input type=\"text\" id=\"myInput\" class=\"form-control\" onkeyup=\"myFunction()\" placeholder=\"$lang[SEARCH_DOTDOTDOT]\">";
            echo "<ul id=\"phpinfoList\" class=\"list-group\">";
            \YAWK\sys::array2lines($data, "apache2handler");
            \YAWK\sys::array2lines($data, "Apache Environment");
            \YAWK\sys::array2lines($data, "HTTP Headers Information");
            \YAWK\sys::array2lines($data, "bcmath");
            \YAWK\sys::array2lines($data, "bz2");
            \YAWK\sys::array2lines($data, "calendar");
            \YAWK\sys::array2lines($data, "Core");
            \YAWK\sys::array2lines($data, "ctype");
            \YAWK\sys::array2lines($data, "curl");
            \YAWK\sys::array2lines($data, "date");
            \YAWK\sys::array2lines($data, "dom");
            \YAWK\sys::array2lines($data, "ereg");
            \YAWK\sys::array2lines($data, "exif");
            \YAWK\sys::array2lines($data, "fileinfo");
            \YAWK\sys::array2lines($data, "filter");
            \YAWK\sys::array2lines($data, "ftp");
            \YAWK\sys::array2lines($data, "gd");
            \YAWK\sys::array2lines($data, "gettext");
            \YAWK\sys::array2lines($data, "hash");
            \YAWK\sys::array2lines($data, "iconv");
            \YAWK\sys::array2lines($data, "imagick");
            \YAWK\sys::array2lines($data, "json");
            \YAWK\sys::array2lines($data, "libxml");
            \YAWK\sys::array2lines($data, "mbstring");
            \YAWK\sys::array2lines($data, "mcrypt");
            \YAWK\sys::array2lines($data, "mhash");
            \YAWK\sys::array2lines($data, "mysqli");
            \YAWK\sys::array2lines($data, "mysqlnd");
            \YAWK\sys::array2lines($data, "odbc");
            \YAWK\sys::array2lines($data, "openssl");
            \YAWK\sys::array2lines($data, "pcre");
            \YAWK\sys::array2lines($data, "PDO");
            \YAWK\sys::array2lines($data, "pdo_mysql");
            \YAWK\sys::array2lines($data, "pdo_sqlite");
            \YAWK\sys::array2lines($data, "Phar");
            \YAWK\sys::array2lines($data, "Reflection");
            \YAWK\sys::array2lines($data, "session");
            \YAWK\sys::array2lines($data, "SimpleXML");
            \YAWK\sys::array2lines($data, "SPL");
            \YAWK\sys::array2lines($data, "standard");
            \YAWK\sys::array2lines($data, "tokenizer");
            \YAWK\sys::array2lines($data, "wddx");
            \YAWK\sys::array2lines($data, "xml");
            \YAWK\sys::array2lines($data, "xmlreader");
            \YAWK\sys::array2lines($data, "xmlwriter");
            \YAWK\sys::array2lines($data, "zip");
            \YAWK\sys::array2lines($data, "zlib");
            echo "</ul>";
            /*
            echo "</tbody></table>";
            */
        }

        /**
         * Display a multidimensional array line per line. Expects an array and property
         * @author      Daniel Retzl <danielretzl@gmail.com>
         * @version     1.0.0
         * @link        https://gist.github.com/sbmzhcn/6255314
         * @return bool
         */
        static function multiarray2lines($array, $property)
        {
            echo "<h2><small>".strtoupper($property)."</small></h2>";
            foreach ($array[$property] as $item => $key)
            {
                echo "<b>$item</b> = $key[0]<br>";
            }
            return true;
        }

        /**
         * Read phpinfo() into multidimensional array and return it
         * @author      Ray Chang
         * @version     1.0.0
         * @link        https://gist.github.com/sbmzhcn/6255314
         * @return array phpinfo() data as multidimensional array
         */
        public static function parse_phpinfo() {
            ob_start(); phpinfo(INFO_MODULES); $s = ob_get_contents(); ob_end_clean();
            $s = strip_tags($s, '<h2><th><td>');
            $s = preg_replace('/<th[^>]*>([^<]+)<\/th>/', '<info>\1</info>', $s);
            $s = preg_replace('/<td[^>]*>([^<]+)<\/td>/', '<info>\1</info>', $s);
            $t = preg_split('/(<h2[^>]*>[^<]+<\/h2>)/', $s, -1, PREG_SPLIT_DELIM_CAPTURE);
            $r = array(); $count = count($t);
            $p1 = '<info>([^<]+)<\/info>';
            $p2 = '/'.$p1.'\s*'.$p1.'\s*'.$p1.'/';
            $p3 = '/'.$p1.'\s*'.$p1.'/';
            for ($i = 1; $i < $count; $i++) {
                if (preg_match('/<h2[^>]*>([^<]+)<\/h2>/', $t[$i], $matchs)) {
                    $name = trim($matchs[1]);
                    $vals = explode("\n", $t[$i + 1]);
                    foreach ($vals AS $val) {
                        if (preg_match($p2, $val, $matchs)) { // 3cols
                            $r[$name][trim($matchs[1])] = array(trim($matchs[2]), trim($matchs[3]));
                        } elseif (preg_match($p3, $val, $matchs)) { // 2cols
                            $r[$name][trim($matchs[1])] = trim($matchs[2]);
                        }
                    }
                }
            }
            return $r;
        }

        /**
         * Return current base directory
         * @author      Daniel Retzl <danielretzl@gmail.com>
         * @version     1.0.0
         * @link        http://yawk.io
         * @return string
         */
        public static function getBaseDir()
        {
            return substr($_SERVER['SCRIPT_NAME'], 0, strpos($_SERVER['SCRIPT_NAME'],basename($_SERVER['SCRIPT_NAME'])));
        }

        /**
         * Generate a random password with given length
         * @author      Daniel Retzl <danielretzl@gmail.com>
         * @version     1.0.0
         * @link        http://yawk.io
         * @param int $length length of the password you wish to return
         * @return string
         */
        public static function generateRandomPassword($length)
        {
            // if length is not set or wrong type
            if (!isset($length) || (empty($length) || (!is_int($length))))
            {   // generate password with default length (8 chars)
                $length = 8;
            }
            // string with allowed chars - these can appear in the generated password
            $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_-=+;:,.?";
            // generate password
            $password = substr(str_shuffle($chars), 0, $length);
            return $password;
        }


        /**
         * Return the content of /robots.txt
         * @author      Daniel Retzl <danielretzl@gmail.com>
         * @version     1.0.0
         * @link        http://yawk.io
         * @param string $path absolute path to the robots.txt file
         * @return string|bool
         */
        public static function getRobotsText($db, $path)
        {
            $robotsText = "$path/robots.txt";
                $file = file_get_contents($robotsText);
                if (!empty($file))
                {
                    return $file;
                }
                else
                    {   // try to get robots.txt from database
                        if ($file = \YAWK\settings::getLongSetting($db, "robotsText-long"))
                        {
                            return $file;
                        }
                        else
                        {   // db setting robotsText-long is empty
                            return false;
                        }
                    }
        }

        /**
         * Set the content of /robots.txt (overwrite)
         * @author      Daniel Retzl <danielretzl@gmail.com>
         * @version     1.0.0
         * @link        http://yawk.io
         * @param string $path absolute path to the robots.txt file
         * @param string $content file content to write in robots.txt
         * @return bool
         */
        public static function setRobotsText($path, $content)
        {
            // check if file content is set...
            // set robots.txt path + filename
            $filename = "$path"."robots.txt";
            if (file_put_contents("$filename", "$content"))
            {
                return true;
            }
            else
                {
                    return false;
                }
        }

        /**
         * Read a directory recursively
         * @author      Daniel Retzl <danielretzl@gmail.com>
         * @version     1.0.0
         * @link        http://yawk.io
         * @param string $path full path e.g. /xampp/htdocs/yawk-LTE/
         * @return array
         */
        public static function read_recursive($path)
        {
            global $files_count;
            $result = array();
            $handle = opendir($path);
            if ($handle)
            {
                while (false !== ($file = readdir($handle)))
                {
                    if ($file != "." && $file != "..")
                    {
                        if (is_file($file))
                        {
                            $files_count = $files_count + 1;
                        }
                        $name = $path . "/" . $file;

                        if (is_dir($name))
                        {
                            $ar = self::read_recursive($name);
                            foreach ($ar as $value)
                            {
                                $result[] = $value;
                            }
                        }
                        else
                            {
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
         * @link        http://yawk.io
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
         * @link        http://yawk.io
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
            if (is_link($source))
            {
                return symlink(readlink($source), $dest);
            }
            // Simple copy for a file
            if (is_file($source))
            {
                return copy($source, $dest);
            }
            // Make destination directory
            if (!is_dir($dest))
            {
                mkdir($dest, $permissions);
            }
            // Loop through the folder
            $dir = dir($source);
            while (false !== $entry = $dir->read())
            {
                // Skip pointers
                if ($entry == '.' || $entry == '..')
                {
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
         * @link        http://yawk.io
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

        /**
         * copy an entire folder including subdirectories
         * @author      Daniel Retzl <danielretzl@gmail.com>
         * @version     1.0.0
         * @link        http://yawk.io
         * @param string $source source directory
         * @param string $target target directory
         */
        static function full_copy($source, $target )
        {   /** copy an entire folder into another location */
            if (is_dir($source))
            {
                @mkdir($target);
                $d = dir($source);
                while (FALSE !== ($entry = $d->read()))
                {
                    if ($entry == '.' || $entry == '..')
                    {
                        continue;
                    }
                    $Entry = $source.'/'.$entry;
                    if (is_dir($Entry))
                    {
                        self::full_copy($Entry, $target.'/'.$entry);
                        continue;
                    }
                    copy($Entry, $target.'/'.$entry);
                }
                $d->close();
            }
            else
                {
                    copy( $source, $target );
                }
        }

        /**
         * convert a integer status to string variable (0|1) to online / offline
         * @author      Daniel Retzl <danielretzl@gmail.com>
         * @version     1.0.0
         * @link        http://yawk.io
         * @param int $i the status var
         * @param string $on string for status 1 (online, published...)
         * @param string $off string for status 0 (offline, not published...)
         * @return bool|string return the converted string or false
         */
        static function iStatusToString($i, $on, $off)
        {   // check if $i is set and from correct type
            $status = '';
            if (isset($i))
            {
                // check online string
                if (!isset($on) || (empty($on)))
                {
                    $on = "online";
                }
                // check offline string
                if (!isset($off) || (empty($off)))
                {
                    $off = "offline";
                }
                if ($i == "1")
                {   // return word online
                    $status = $on;
                }
                elseif ($i == "0")
                {   // return word online
                    $status = $off;
                }
                else
                    {
                        $status = "error: \$i status undefined";
                    }
            }
            else
            {   // ID not set or not a number
                return false;
            }
            return $status;
        }

        /**
         * replace all carriage returns with linebreaks
         * @author      Daniel Retzl <danielretzl@gmail.com>
         * @version     1.0.0
         * @link        http://yawk.io
         * @param string $replace searchstring
         * @param string $string replacestring
         * @return string
         */
        static function replaceCarriageReturns($replace, $string)
        {
            return str_replace(array("\n\r", "\n", "\r"), $replace, $string);
        }

        /**
         * THIS SEEMS OUTDATED - obviously not needed anymore....
         * @author      Daniel Retzl <danielretzl@gmail.com>
         * @version     1.0.0
         * @link        http://yawk.io
         * @param string $customCSS
         * @return string
         */
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

        /**
         * removes all unnecessary HTML tags from custom.css
         * @param string $replace
         * @param string $customCSS
         * @return string
         */
        static function replacePreTags($replace, $customCSS)
        {   // this function removes all unnecessary HTML tags from custom.css
            return str_replace(array("<p>", "</p>", "<br />", "</pre>", "<pre style=\"word-wrap: break-word; white-space: pre-wrap;\">"), "", $customCSS);
        }

        /**
         * check global page status: returns 0|1 if page is offline / online
         * @author      Daniel Retzl <danielretzl@gmail.com>
         * @version     1.0.0
         * @link        http://yawk.io
         * @param object $db database
         * @return bool
         */
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

        /**
         * output html div with offline message
         * @author      Daniel Retzl <danielretzl@gmail.com>
         * @version     1.0.0
         * @link        http://yawk.io
         * @param object $db database
         */
        static function drawOfflineMessage($db)
        {   /** @var $db \YAWK\db */
            /* get offline message + image */
            $offlinemsg = \YAWK\settings::getSetting($db, "offlinemsg");
            $offlineimg = \YAWK\settings::getSetting($db, "offlineimage");
            // draw offline message
            echo "<div class=\"text-center\">
                    <img src=\"".$offlineimg."\"><br><br>
                    ".$offlinemsg."<br><br>
                  </div>";
            exit;
        }

        /**
         * set a timeout and force page reload via JS
         * @author      Daniel Retzl <danielretzl@gmail.com>
         * @version     1.0.0
         * @link        http://yawk.io
         * @param string $location the url to redirect
         * @param int $wait the time in ms to wait before redirect
         * @return bool
         */
        static function setTimeout($location, $wait)
        {
            print"<script type=\"text/javascript\">
            setTimeout(\"self.location.href='" . $location . "'\"," . $wait . ");
            </script>
            <noscript>
		 	 <h1>Im Browser muss javascript aktiviert sein, um die Seite richtig nutzen zu k&ouml;nnen.</h1>
			</noscript>";
            return true;
        }

        /**
         * check if browscap file is set
         * @author      Daniel Retzl <danielretzl@gmail.com>
         * @version     1.0.0
         * @link        http://yawk.io
         * @param string $useragent full useragent
         * @return bool|null
         */
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

        /**
         * extract browser from useragent
         * @author      Daniel Retzl <danielretzl@gmail.com>
         * @version     1.0.0
         * @link        http://yawk.io
         * @param string $useragent the full useragent
         * @return array array with useragent, browser, version and platform
         */
        static function getBrowser($useragent)
        {
            if (isset($useragent) && (!empty($useragent)))
            {
                $u_agent = $useragent;
            }
            else
                {
                    $u_agent = $_SERVER['HTTP_USER_AGENT'];
                }
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
            elseif(preg_match('/linux|android/i',$u_agent))
            {
                $bname = 'Android';
                $ub = "Android";
                $platform = "Android";
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

        /**
         * get operating system from useragent string
         * @author      Daniel Retzl <danielretzl@gmail.com>
         * @version     1.0.0
         * @link        http://yawk.io
         * @param string $useragent full useragent string
         * @return mixed|string return string containing the OS (platform)
         */
        static function getOS($useragent) {
            if (isset($useragent) && (!empty($useragent)))
            {
                $u_agent = $useragent;
            }
            else
            {
                $u_agent = $_SERVER['HTTP_USER_AGENT'];
            }

            $os_platform    =   "Unknown OS Platform";
            $os_array       =   array(
                '/windows nt 6.2/i'     =>  'Windows 8',
                '/windows nt 6.1/i'     =>  'Windows 7',
                '/windows nt 6.0/i'     =>  'Windows Vista',
                '/windows nt 5.2/i'     =>  'Windows Server 2003/XP x64',
                '/windows nt 5.1/i'     =>  'Windows XP',
                '/windows xp/i'         =>  'Windows XP',
                '/windows nt 5.0/i'     =>  'Windows 2000',
                '/windows me/i'         =>  'Windows ME',
                '/win98/i'              =>  'Windows 98',
                '/win95/i'              =>  'Windows 95',
                '/win16/i'              =>  'Windows 3.11',
                '/macintosh|mac os x/i' =>  'Mac OS X',
                '/mac_powerpc/i'        =>  'Mac OS 9',
                '/linux/i'              =>  'Linux',
                '/ubuntu/i'             =>  'Ubuntu',
                '/iphone/i'             =>  'iPhone',
                '/ipod/i'               =>  'iPod',
                '/ipad/i'               =>  'iPad',
                '/android/i'            =>  'Android',
                '/blackberry/i'         =>  'BlackBerry',
                '/webos/i'              =>  'Mobile'
            );

            foreach ($os_array as $regex => $value) {
                if (preg_match($regex, $u_agent)) {
                    $os_platform    =   $value;
                }
            }
            return $os_platform;
        }

        /**
         * measure script loading time
         * @author      Daniel Retzl <danielretzl@gmail.com>
         * @version     1.0.0
         * @link        http://yawk.io
         * @param string $debugTime starting time
         * @return string return formated time in milliseconds
         */
        static function getLoadingTime($debugTime)
        {
            // debugTime to measure script time
            $debugTime = microtime(true) - $debugTime;
            $debugTime = number_format($debugTime, 3);
            return "<small>&nbsp; script execution time: $debugTime Sek.</small>";
        }

        /**
         * convert german special chars and vowels into legal html
         * @author      Daniel Retzl <danielretzl@gmail.com>
         * @version     1.0.0
         * @link        http://yawk.io
         * @param string $string to encode
         * @return string return encoded string
         */
        static function encodeChars($string)
        {   // requires string. encodes german vowels
            // $string = utf8_decode($string);
            $chars = array("ö" => "&ouml;", "ä" => "&auml;", "ü" => "&uuml;",
                "Ö" => "&Ouml;", "Ä" => "&Auml;", "Ü" => "&Uuml;",
                "ß" => "&szlig;",
                "€" => "&euro;");
            return strtr($string, $chars);
        }

        /**
         * if yawk is installed into a subdirectory, use this to get this prefix directory
         * @author      Daniel Retzl <danielretzl@gmail.com>
         * @version     1.0.0
         * @link        http://yawk.io
         * @param object $db database
         * @return string return the directory prefix
         */
        static function getDirPrefix($db)
        {   // returns directory prefix from settings
            $dirprefix = settings::getSetting($db, "dirprefix");
            return $dirprefix;
        }

        /**
         * get hostname (url where yawk is installed) from database
         * @author      Daniel Retzl <danielretzl@gmail.com>
         * @version     1.0.0
         * @link        http://yawk.io
         * @param object $db database
         * @return bool|string
         */
        static function getHost($db)
        {   // get host from settings db
            $hostname = settings::getSetting($db, "host");
            $hostname = self::addTrailingSlash($hostname);
            return $hostname;
        }

        /**
         * remove a directory recurse
         * @author      Daniel Retzl <danielretzl@gmail.com>
         * @version     1.0.0
         * @link        http://yawk.io
         * @param string $dir the directory to delete
         * @return bool
         */
        static function recurseRmdir($dir) {
            $files = array_diff(scandir($dir), array('.','..'));
            foreach ($files as $file) {
                (is_dir("$dir/$file")) ? self::recurseRmdir("$dir/$file") : unlink("$dir/$file");
            }
            return rmdir($dir);
        }

        /**
         * sometimes it is necessary to add a slash to a url.
         * @author      Daniel Retzl <danielretzl@gmail.com>
         * @version     1.0.0
         * @link        http://yawk.io
         * @param string $url the url were the slash needs to be added
         * @return string return url containing the slash
         */
        static function addTrailingSlash($url)
        {   // check if url contains a trailing slash at the end
            if (substr($url, -1, 1) !== "/")
            {   // if not, it will be added
                $url = $url."/";
            }
            // return url with trailing slash
            return $url;
        }

        /**
         * get any property from any table where id is given ID
         * @author      Daniel Retzl <danielretzl@gmail.com>
         * @version     1.0.0
         * @link        http://yawk.io
         * @param object $db database
         * @param string $property what to select (field)
         * @param string $table from wich (table)
         * @param string $id where id = (id)
         * @return bool
         */
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

        /**
         * get requested group ID for given page ID (used in page-edit)
         * @author      Daniel Retzl <danielretzl@gmail.com>
         * @version     1.0.0
         * @link        http://yawk.io
         * @param object $db database
         * @param string $id page ID
         * @param string $table the table to select from
         * @return string|bool return the group ID or false
         */
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


        /**
         * get requested group ID for given page ID
         * @author      Daniel Retzl <danielretzl@gmail.com>
         * @version     1.0.0
         * @link        http://yawk.io
         * @param object $db database
         * @param string $id page ID
         * @param string $table the table to select from
         * @return string|bool return the group ID or false
         */
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

        /**
         * get all user groups from database
         * @author      Daniel Retzl <danielretzl@gmail.com>
         * @version     1.0.0
         * @link        http://yawk.io
         * @param object $db database
         * @param string $table the table to select from
         * @return array|bool|string
         */
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

        /**
         * include page header and metadata
         * @author      Daniel Retzl <danielretzl@gmail.com>
         * @version     1.0.0
         * @link        http://yawk.io
         * @param object $db database
         */
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

        /**
         * returns the current user name, if set
         * @author      Daniel Retzl <danielretzl@gmail.com>
         * @version     1.0.0
         * @link        http://yawk.io
         * @return string
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

        /**
         * get submenu ID for given page ID
         * @author      Daniel Retzl <danielretzl@gmail.com>
         * @version     1.0.0
         * @link        http://yawk.io
         * @param object $db database
         * @param string $id page ID
         * @return bool
         */
        static function getSubMenu($db, $id)
        {
            /** @var $db \YAWK\db $res */
            if ($res = $db->query("SELECT m.id
	                           FROM {pages} as p
	                           JOIN {menu_names} as m on m.id = p.menu
	                           WHERE p.id = $id")){
                $row = mysqli_fetch_row($res);
                return $row[0];
            }
            else
                {
                    return false;
                }
        }

        /**
         * get menu item for given page ID
         * @author      Daniel Retzl <danielretzl@gmail.com>
         * @version     1.0.0
         * @link        http://yawk.io
         * @param object $db database
         * @param int $id page ID
         * @return bool
         */
        static function getMenuItem($db, $id)
        {
            /** @var $db \YAWK\db $res */
            if ($res = $db->query("SELECT p.menu, m.name
	                              FROM {pages} as p
	                              JOIN {menu_names} as m on m.id = p.menu
	                              WHERE p.id = $id"))
            {
                $row = mysqli_fetch_row($res);
                return $row[1];
            }
            else
                {
                    return false;
                }
        }

        /**
         * get menu names from database
         * @author      Daniel Retzl <danielretzl@gmail.com>
         * @version     1.0.0
         * @link        http://yawk.io
         * @param object $db database
         * @return array|bool
         */
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

        /**
         * returns menu name for given menu ID
         * @author      Daniel Retzl <danielretzl@gmail.com>
         * @version     1.0.0
         * @link        http://yawk.io
         * @param object $db database
         * @param int $id menu ID
         * @return bool
         */
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

        /**
         * get pages from database
         * @author      Daniel Retzl <danielretzl@gmail.com>
         * @version     1.0.0
         * @link        http://yawk.io
         * @param object $db database
         * @return bool|mixed
         */
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


        /**
         * get user groups (roles) for given page
         * @author      Daniel Retzl <danielretzl@gmail.com>
         * @version     1.0.0
         * @link        http://yawk.io
         * @param object $db database
         * @param int $id page ID
         * @param string $table from table
         * @return mixed
         */
        static function getRole($db, $id, $table)
        {   /** @var $db \YAWK\db */
            $mysqlRes = $db->query("SELECT cp.gid, cg.value
                    FROM {".$table."} as cp
                    JOIN {user_groups} as cg on cg.id = cp.gid
                    WHERE cp.id = '".$id."'");
            // fetch data
            while ($row = mysqli_fetch_row($mysqlRes)) {
                echo $row[1];
            }
            return $row[0];
        }

        /**
         * get group ID (role) for given page ID
         * @author      Daniel Retzl <danielretzl@gmail.com>
         * @version     1.0.0
         * @link        http://yawk.io
         * @param object $db database
         * @param int $id affected page ID
         * @param string $table from table
         * @return string|bool
         */
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

        /**
         * returns the current datetime
         * @return string datetime Y-m-d H:i:s
         */
        static function now()
        {   // return current datetime in mysql format
            return date("Y-m-d H:i:s");
        }

        /**
         * split a date to month, day, year and time
         * @author      Daniel Retzl <danielretzl@gmail.com>
         * @version     1.0.0
         * @link        http://yawk.io
         * @param string $date the date to split
         * @return array return an array w single items
         */
        static function splitDate($date)
        {
            $year = substr($date, 0, 4);
            $day = substr($date, 8, 2);
            $month = substr($date, 5, 2);
            $time = substr($date, 11, 5);

            /* remove leading null */
            $day = 1 * $day; // to do that, change type from string to integer

            /* calculate months */
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


        /**
         * split a date to month, day, year and time this is the same as splitDate() but keep the months short
         * @author      Daniel Retzl <danielretzl@gmail.com>
         * @version     1.0.0
         * @link        http://yawk.io
         * @param string $date the date to split
         * @return array return an array w single items
         */
        static function splitDateShort($date)
        {
            $year = substr($date, 0, 4);
            $day = substr($date, 8, 2);
            $month = substr($date, 5, 2);
            $time = substr($date, 11, 5);

            /* remove leading null */
            $day = 1 * $day; // to do that, we change type from string to integer

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

        /**
         * how many time is been gone since given date
         * @author      Daniel Retzl <danielretzl@gmail.com>
         * @version     1.0.0
         * @link        http://yawk.io
         * @param string $userdate date to calculate
         * @param object $lang language array
         * @return string return how many time has gone since $userdate
         */
        static function time_ago($userdate, $lang)
        {
            $time_ago = '';

            $date = new \DateTime($userdate);
            $diff = $date->diff(new \DateTime('now'));

            if (($t = $diff->format("%m")) > 0)
                $time_ago = (int)$t . ' '.$lang['MONTHS'].'';
            else if (($t = $diff->format("%d")) > 0)
                $time_ago = (int)$t . ' '.$lang['DAYS'].'';
            else if (($t = $diff->format("%H")) > 0)
                $time_ago = (int)$t . ' '.$lang['HOURS'].'';
            else if (($t = $diff->format("%i")) > 0)
                $time_ago = (int)$t . ' '.$lang['MINUTES'].'';
            else if (($t = $diff->format("%s")) > 0)
                $time_ago = (int)$t . ' '.$lang['SECONDS'].'';
            // else
            //    $time_ago = 'minutes';

            // if language is german, turn around the 'ago' term
            if (\YAWK\language::getCurrentLanguage() === "de-DE")
            {   // return reverse for germans
                return $lang['AGO'] . ' '.$time_ago.'';
            }
            // default return string
            return $time_ago . ' '.$lang['AGO'].'';
        }

        /**
         * return weekday from given date
         * @author      Daniel Retzl <danielretzl@gmail.com>
         * @version     1.0.0
         * @link        http://yawk.io
         * @param string $date the date to calculate
         * @return bool|false|string
         */
        static function getWeekday($date, $lang){
            if (isset($date)){
                // get weekday
                $weekday = date("l",strtotime($date));
                switch($weekday){
                    case "$lang[MONDAY]":
                        $weekday = "$lang[MONDAY]";
                        break;
                    case "$lang[TUESDAY]":
                        $weekday = "$lang[TUESDAY]";
                        break;
                    case "$lang[WEDNESDAY]":
                        $weekday = "$lang[WEDNESDAY]";
                        break;
                    case "$lang[THURSDAY]":
                        $weekday = "$lang[THURSDAY]";
                        break;
                    case "$lang[FRIDAY]":
                        $weekday = "$lang[FRIDAY]";
                        break;
                    case "$lang[SATURDAY]":
                        $weekday = "$lang[SATURDAY]";
                        break;
                    case "$lang[SUNDAY]":
                        $weekday = "$lang[SUNDAY]";
                        break;
                }
                return $weekday;
            }
            else {
                return false;
            }
        }

        /**
         * set a syslog entry to database
         * @author      Daniel Retzl <danielretzl@gmail.com>
         * @version     1.0.0
         * @link        http://yawk.io
         * @param object $db database
         * @param int $log_type type to log?
         * @param string $message logging message
         * @param int $fromUID affected from UID
         * @param int $toUID affected to UID
         * @param int $toGID affected GID
         * @param int $seen 0|1 status if this entry has been overviewed
         * @return bool|null
         */
        static function setSyslog($db, $log_type, $message, $fromUID, $toUID, $toGID, $seen)
        {   /** @var $db \YAWK\db */
            // THIS DB STORES ALL THE SYSLOG FOR ADMINISTRATOR REASONS
            // insert admin-friendly message of all data into syslog db

            // get current log date
            $log_date = sys::now();

            // check if log_type is empty
            if (!isset($log_type) || (empty($log_type) || ($log_type === "0")))
            {   // default value: system settings (type 1)
                $log_type = 1;
            }
            // check if message is empty
            if (!isset($message) || (empty($message) || ($message === "0")))
            {   // default value
                if (isset($_GET['page'])) { $page = $_GET['page']; } else { $page = 'no page set.'; }
                $message = "something happened, but no text was set for logging. $page";
            }

            // check if syslog is enabled
            if (\YAWK\settings::getSetting($db, "syslogEnable") === "1")
            {   // check, if fromUID (user that affected the event) is set
                if (!isset($fromUID) || (empty($fromUID) || ($fromUID === "0")))
                {   // check if session uid is set
                    if (isset($_SESSION['uid']))
                    {   // ok, set var
                        $fromUID = $_SESSION['uid'];
                    }
                    else
                    {   // set zero
                        $fromUID = 0;
                    }
                }
                // insert syslog entry into db
                if ($db->query("INSERT INTO {syslog} (log_date, log_type,message,fromUID,toUID,toGID,seen)
                                        VALUES ('".$log_date."',
                                                '".$log_type."',
                                                '".$message."',
                                                '".$fromUID."',
                                                '".$toUID."',
                                                '".$toGID."',
                                                '".$seen."')"))
                {   // syslog entry set
                    return true;
                }
                else
                {   // insert q failed
                    return false;
                }
            }
            else
                {   // syslog is disabled
                    return null;
                }
        }

        /**
         * set a system notification for any user or admin
         * @param object $db database
         * @param int $log_type type to log
         * @param int $msg_id message id
         * @param int $fromUID affected from user ID
         * @param int $toUID affected to user ID
         * @param int $toGID affected to group ID
         * @param int $seen 0|1 status if notification has been seen
         * @return bool
         */
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

        /**
         * mark a notification as seen / unseen
         * @param object $db database
         * @param int $id the affected notification log_id
         * @param int $seen 0|1 status if notification has been seen
         * @return bool
         */
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