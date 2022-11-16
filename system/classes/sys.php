<?php
namespace YAWK {
    /**
     * @details handles many of yawk's system core functions.
     *
     * Most of them are static functions, like get and set paths, get ids, roles and so on.
     * <p><i>Class covers both, backend & frontend functionality.
     * See Methods Summary for Details!</i></p>
     *
     * @author     Daniel Retzl <danielretzl@gmail.com>
     * @copyright  2009-2016 Daniel Retzl
     * @license    https://opensource.org/licenses/MIT
     * @version    1.0.0
     * @brief      The sys class - handles yawk's system core functions.
     */
    class sys
    {
        /**
         * @brief Check if assets are loaded, load if switch is true
         * @param $db object Database object
         * @param $assets array Required assets as array
         * @param $switch bool true|false If true, required assset gets loaded if not
         * @return mixed
         * @details  This methods checks if given assets are loaded and load them on demand
         */
        static function checkIfAssetsAreLoaded($db, $assets, $switch)
        {
            // check if any assets are sent
            if (isset($assets) && (!empty($assets) && (is_array($assets))))
            {
                // get current template ID
                $templateID = \YAWK\template::getCurrentTemplateId($db);

                // get the number of assets
                $assetItems = count($assets);

                // loop counter
                $successful = 0;

                // check if templateID is valid
                if (!isset($templateID) || (empty($templateID) || (!is_numeric($templateID))))
                {   // unable to get current template ID
                    return false;
                }
                else    // valid template ID, go ahead and...
                {   // walk through required assets array
                    foreach ($assets as $asset => $type)
                    {
                        // check if asset is loaded
                        if ($res = $db->query(("SELECT asset FROM {assets}
                            WHERE asset = '" . $asset . "' 
                            AND templateID = '".$templateID."'")))
                        {
                            if ($row = (mysqli_fetch_row($res)))
                            {
                                if (count($row) > 0)
                                {
                                    // asset found, set loop counter +1
                                    $successful++;
                                }
                            }
                            else    // asset not found
                            {   // check if switch is true and asset should be loaded...
                                if (isset($switch) && ($switch == 'true'))
                                {   // select data from asset types db
                                    if ($res = $db->query("SELECT * FROM {assets_types} WHERE asset = '".$asset."'"))
                                    {   // foreach result
                                        while ($row = (mysqli_fetch_assoc($res)))
                                        {
                                            // check link (internal or external)
                                            if (isset($row['internal']) && (!empty($row['internal'])))
                                            {   // internal link
                                                $row['link'] = $row['internal'];
                                            }
                                            elseif (isset($row['url1']) && (!empty($row['url1'])))
                                            {   // external link
                                                $row['link'] = $row['url1'];
                                            }

                                            // load required asset into database
                                            if ($db->query("INSERT INTO {assets} (templateID, type, sortation, asset, link) VALUES ('" . $templateID . "', '" . $type . "', '" . $row['sortation']. "','" . $row['asset'] . "', '" . $row['link'] . "')"))
                                            {   // asset successfully loaded
                                                $successful++;
                                            }
                                            else
                                            {   // no success - do nothing
                                                return \YAWK\alert::draw("danger", "ERROR", "Unable to insert Asset into Assets database. Please add this asset $asset manually.", "", 12000);
                                            }
                                        }
                                    }
                                    else
                                    {
                                        // required asset not found in database - add manually!
                                        // die ('required asset is not in database - add manually!');
                                        return \YAWK\alert::draw("danger", "ERROR", "Required Asset is not in the database! Please check, if this asset is registered!", "", 12000);
                                    }
                                    // select data of this asset
                                }
                                else
                                {   // switch is false, means enable asset is not requested
                                    return \YAWK\alert::draw("warning", "Warning - please check this!", "Unable to load asset! $asset Please check required template assets manually!", "", 12000);
                                }
                            }
                        }
                        else
                        {   // error selecting asset from database
                            return \YAWK\alert::draw("warning", "Warning - this widget requires an additional asset!", "Asset $asset not loaded! Please load this asset within system/asset settings.", "", 12000);
                        }
                    }

                    // check if count and assetItems match to see if everything worked like expected
                    if ($assetItems === $successful)
                    {   // all assets loaded
                        // die ('Required assset was not loaded');
                        return \YAWK\alert::draw("success", "Asset System Information", "I have found out that the required asset was not loaded. I've successfully fixed this for you.", "", 6200);
                    }
                    else
                    {   // not all asset items could get loaded...
                        // die ('Unable to load all assets');
                        return \YAWK\alert::draw("warning", "Warning - please check this!", "Unable to load asset! $asset Please check required template assets manually!", "", 12000);
                    }
                }
            }
            else
            {   // no assets are set
                return false;
            }
        }

        /**
         * @brief Display a multidimensional array line per line. Expects an array and property
         * @author      Daniel Retzl <danielretzl@gmail.com>
         * @version     1.0.0
         */
        static function array2lines($array, $property)
        {
            if (!isset($array) || (!isset($property)))
            {
                echo 'array or property not set';
            }

            if (isset($array) && (isset($array[$property]) && (isset($property))))
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
        }

        /**
         * @brief Display a complete PHPinfo()
         * @param $lang
         */
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
    
                    // Loop through all list items, hide those who don't match the search query
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
         * @brief Display a multidimensional array line per line. Expects an array and property
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
         * @brief Read phpinfo() into multidimensional array and return it
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
         * @brief Return current base directory
         * @return string
         */
        public static function getBaseDir()
        {
            return substr($_SERVER['SCRIPT_NAME'], 0, strpos($_SERVER['SCRIPT_NAME'],basename($_SERVER['SCRIPT_NAME'])));
        }

        /**
         * @brief Generate a random password with given length
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
         * @brief Return the content of /robots.txt
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
         * @brief Set the content of /robots.txt (overwrite)
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
         * @brief Read a directory recursively
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
         * @brief Count code lines and output a small overview
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
         * @brief Check if zlib is available
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
         * @brief Copy a file, or recursively copy a folder and its contents
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
                if (copy($source, $dest) === false)
                {
                    return false;
                }
            }
            // Make destination directory
            if (!is_dir($dest))
            {
                if (!@mkdir($dest, $permissions)) {
                    // $error = error_get_last();
                    return false;
                }

            }
            // Loop through the folder
            if(!is_dir($source))
            {
                return false;
            }
            else
            {
                $dir = dir($source);
                while (false !== $entry = $dir->read())
                {
                    // Skip pointers
                    if ($entry == '.' || $entry == '..')
                    {
                        continue;
                    }
                    // Deep copy directories
                    if (self::xcopy("$source/$entry", "$dest/$entry", $permissions))
                    {
                        // return false;
                    }
                }
                // Clean up
                $dir->close();
                return true;
            }
        }

        /**
         * @brief Minify any string: removes spaces, tabs and linebreaks.
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
         * @brief HTML Minifier - minify any string: removes spaces, tabstops and linebreaks.
         * @author      Rodrigo54
         * @version     1.0.0
         * @link        https://gist.github.com/Rodrigo54/93169db48194d470188f
         * @param       string $input the CSS string to minify
         * @return      mixed
         * @details  Based on `https://github.com/mecha-cms/mecha-cms/blob/master/system/kernel/converter.php`
         */
        static function minifyHTML($input) {
            if(trim($input) === "") return $input;
            // Remove extra white-space(s) between HTML attribute(s)
            $input = preg_replace_callback('#<([^\/\s<>!]+)(?:\s+([^<>]*?)\s*|\s*)(\/?)>#s', function($matches) {
                return '<' . $matches[1] . preg_replace('#([^\s=]+)(\=([\'"]?)(.*?)\3)?(\s+|$)#s', ' $1$2', $matches[2]) . $matches[3] . '>';
            }, str_replace("\r", "", $input));
            // Minify inline CSS declaration(s)
            if(strpos($input, ' style=') !== false) {
                $input = preg_replace_callback('#<([^<]+?)\s+style=([\'"])(.*?)\2(?=[\/\s>])#s', function($matches) {
                    return '<' . $matches[1] . ' style=' . $matches[2] . self::minifyCSS($matches[3]) . $matches[2];
                }, $input);
            }
            if(strpos($input, '</style>') !== false) {
                $input = preg_replace_callback('#<style(.*?)>(.*?)</style>#is', function($matches) {
                    return '<style' . $matches[1] .'>'. self::minifyCSS($matches[2]) . '</style>';
                }, $input);
            }
            if(strpos($input, '</script>') !== false) {
                $input = preg_replace_callback('#<script(.*?)>(.*?)</script>#is', function($matches) {
                    return '<script' . $matches[1] .'>'. self::minifyJs($matches[2]) . '</script>';
                }, $input);
            }
            return preg_replace(
                array(
                    // t = text
                    // o = tag open
                    // c = tag close
                    // Keep important white-space(s) after self-closing HTML tag(s)
                    '#<(img|input)(>| .*?>)#s',
                    // Remove a line break and two or more white-space(s) between tag(s)
                    '#(<!--.*?-->)|(>)(?:\n*|\s{2,})(<)|^\s*|\s*$#s',
                    '#(<!--.*?-->)|(?<!\>)\s+(<\/.*?>)|(<[^\/]*?>)\s+(?!\<)#s', // t+c || o+t
                    '#(<!--.*?-->)|(<[^\/]*?>)\s+(<[^\/]*?>)|(<\/.*?>)\s+(<\/.*?>)#s', // o+o || c+c
                    '#(<!--.*?-->)|(<\/.*?>)\s+(\s)(?!\<)|(?<!\>)\s+(\s)(<[^\/]*?\/?>)|(<[^\/]*?\/?>)\s+(\s)(?!\<)#s', // c+t || t+o || o+t -- separated by long white-space(s)
                    '#(<!--.*?-->)|(<[^\/]*?>)\s+(<\/.*?>)#s', // empty tag
                    '#<(img|input)(>| .*?>)<\/\1>#s', // reset previous fix
                    '#(&nbsp;)&nbsp;(?![<\s])#', // clean up ...
                    '#(?<=\>)(&nbsp;)(?=\<)#', // --ibid
                    // Remove HTML comment(s) except IE comment(s)
                    '#\s*<!--(?!\[if\s).*?-->\s*|(?<!\>)\n+(?=\<[^!])#s'
                ),
                array(
                    '<$1$2</$1>',
                    '$1$2$3',
                    '$1$2$3',
                    '$1$2$3$4$5',
                    '$1$2$3$4$5$6$7',
                    '$1$2$3',
                    '<$1$2',
                    '$1 ',
                    '$1',
                    ""
                ),
                $input);
        }

        /**
         * @brief Minify any string: removes spaces, tabs and linebreaks.
         * @author      Rodrigo54
         * @version     1.0.0
         * @link        https://gist.github.com/Rodrigo54/93169db48194d470188f
         * @param       string $input the CSS string to minify
         * @return      mixed
         * @details   CSS Minifier => http://ideone.com/Q5USEF + improvement(s)
         */
        static
        function minifyCSS($input) {
            if(trim($input) === "") return $input;
            return preg_replace(
                array(
                    // Remove comment(s)
                    '#("(?:[^"\\\]++|\\\.)*+"|\'(?:[^\'\\\\]++|\\\.)*+\')|\/\*(?!\!)(?>.*?\*\/)|^\s*|\s*$#s',
                    // Remove unused white-space(s)
                    '#("(?:[^"\\\]++|\\\.)*+"|\'(?:[^\'\\\\]++|\\\.)*+\'|\/\*(?>.*?\*\/))|\s*+;\s*+(})\s*+|\s*+([*$~^|]?+=|[{};,>~+]|\s*+-(?![0-9\.])|!important\b)\s*+|([[(:])\s++|\s++([])])|\s++(:)\s*+(?!(?>[^{}"\']++|"(?:[^"\\\]++|\\\.)*+"|\'(?:[^\'\\\\]++|\\\.)*+\')*+{)|^\s++|\s++\z|(\s)\s+#si',
                    // Replace `0(cm|em|ex|in|mm|pc|pt|px|vh|vw|%)` with `0`
                    '#(?<=[\s:])(0)(cm|em|ex|in|mm|pc|pt|px|vh|vw|%)#si',
                    // Replace `:0 0 0 0` with `:0`
                    '#:(0\s+0|0\s+0\s+0\s+0)(?=[;\}]|\!important)#i',
                    // Replace `background-position:0` with `background-position:0 0`
                    '#(background-position):0(?=[;\}])#si',
                    // Replace `0.6` with `.6`, but only when preceded by `:`, `,`, `-` or a white-space
                    '#(?<=[\s:,\-])0+\.(\d+)#s',
                    // Minify string value
                    '#(\/\*(?>.*?\*\/))|(?<!content\:)([\'"])([a-z_][a-z0-9\-_]*?)\2(?=[\s\{\}\];,])#si',
                    '#(\/\*(?>.*?\*\/))|(\burl\()([\'"])([^\s]+?)\3(\))#si',
                    // Minify HEX color code
                    '#(?<=[\s:,\-]\#)([a-f0-6]+)\1([a-f0-6]+)\2([a-f0-6]+)\3#i',
                    // Replace `(border|outline):none` with `(border|outline):0`
                    '#(?<=[\{;])(border|outline):none(?=[;\}\!])#',
                    // Remove empty selector(s)
                    '#(\/\*(?>.*?\*\/))|(^|[\{\}])(?:[^\s\{\}]+)\{\}#s'
                ),
                array(
                    '$1',
                    '$1$2$3$4$5$6$7',
                    '$1',
                    ':0',
                    '$1:0 0',
                    '.$1',
                    '$1$3',
                    '$1$2$4$5',
                    '$1$2$3',
                    '$1:0',
                    '$1$2'
                ),
                $input);
        }

        /**
         * @brief Minify any string: removes spaces, tabs and linebreaks.
         * @author      Rodrigo54
         * @version     1.0.0
         * @link        https://gist.github.com/Rodrigo54/93169db48194d470188f
         * @param       string $input the JS string to minify
         * @return      mixed
         */
        static function minifyJs($input) {
            if(trim($input) === "") return $input;
            return preg_replace(
                array(
                    // Remove comment(s)
                    '#\s*("(?:[^"\\\]++|\\\.)*+"|\'(?:[^\'\\\\]++|\\\.)*+\')\s*|\s*\/\*(?!\!|@cc_on)(?>[\s\S]*?\*\/)\s*|\s*(?<![\:\=])\/\/.*(?=[\n\r]|$)|^\s*|\s*$#',
                    // Remove white-space(s) outside the string and regex
                    '#("(?:[^"\\\]++|\\\.)*+"|\'(?:[^\'\\\\]++|\\\.)*+\'|\/\*(?>.*?\*\/)|\/(?!\/)[^\n\r]*?\/(?=[\s.,;]|[gimuy]|$))|\s*([!%&*\(\)\-=+\[\]\{\}|;:,.<>?\/])\s*#s',
                    // Remove the last semicolon
                    '#;+\}#',
                    // Minify object attribute(s) except JSON attribute(s). From `{'foo':'bar'}` to `{foo:'bar'}`
                    '#([\{,])([\'])(\d+|[a-z_][a-z0-9_]*)\2(?=\:)#i',
                    // --ibid. From `foo['bar']` to `foo.bar`
                    '#([a-z0-9_\)\]])\[([\'"])([a-z_][a-z0-9_]*)\2\]#i'
                ),
                array(
                    '$1',
                    '$1$2',
                    '}',
                    '$1$3',
                    '$1.$3'
                ),
                $input);
        }

        /**
         * @brief copy an entire folder including subdirectories
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
         * @brief convert a integer status to string variable (0|1) to online / offline
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
         * @brief replace all carriage returns with linebreaks
         * @param string $replace searchstring
         * @param string $string replacestring
         * @return string
         */
        static function replaceCarriageReturns($replace, $string)
        {
            return str_replace(array("\n\r", "\n", "\r"), $replace, $string);
        }

        /**
         * @brief THIS SEEMS OUTDATED - obviously not needed anymore....
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
         * @brief removes all unnecessary HTML tags from custom.css
         * @param string $replace
         * @param string $customCSS
         * @return string
         */
        static function replacePreTags($replace, $customCSS)
        {   // this function removes all unnecessary HTML tags from custom.css
            return str_replace(array("<p>", "</p>", "<br />", "</pre>", "<pre style=\"word-wrap: break-word; white-space: pre-wrap;\">"), "", $customCSS);
        }

        /**
         * @brief check global page status: returns 0|1 if page is offline / online
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
         * @brief output html div with offline message
         * @param object $db database
         */
        static function drawOfflineMessage($db)
        {   /** @var $db \YAWK\db */
            /* get offline message + image */
            $offlinemsg = \YAWK\settings::getSetting($db, "offlinemsg");
            $offlineimg = \YAWK\settings::getSetting($db, "offlineimage");

            // include bootstrap js
            echo "<script src=\"https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/js/bootstrap.min.js\"></script>";
            // include bootstrap css
            echo "<link rel=\"stylesheet\" href=\"https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/css/bootstrap.min.css\">";
            // include jquery
            echo "<script src=\"https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js\"></script>";
            // include animate.css
            echo "<link rel=\"stylesheet\" href=\"https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.0/animate.min.css\" />";

            // draw offline message
            echo "<div class=\"container-fluid\">";
            echo "<div class=\"row\">";
            echo "<div class=\"col-md-2\"></div>";
            echo "<div class=\"col-md-8 text-center\">
                        <br><br>
                        <img src=\"".$offlineimg."\" class=\"img-responsive mx-auto d-block animated flipInX\" title=\"This website is under construction. Come back again later.\">
                        <br><br>
                        <div class=\"animated fadeIn\">".$offlinemsg."</div>
                      </div>";
            echo "<div class=\"col-md-2\"></div>";
            echo "</div>";
            echo "</div>";
            exit;
        }

        /**
         * @brief set a timeout and force page reload via JS
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
         * @brief check if browscap file is set
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
         * @brief extract browser from useragent
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
            $ub = '';
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
            if(preg_match('/Edge/i',$u_agent) && !preg_match('/Opera/i',$u_agent))
            {
                $bname = 'Edge';
                $ub = "Edge";
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
         * @brief get operating system from useragent string
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
            // $os_platform    =   "Unknown OS Platform";
            $os_array       =   array(
                '/Sec-CH-UA-Platform/i' =>  'Windows 11',
                '/Windows NT 10.0/i'    =>  'Windows 10',
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
         * @brief measure script loading time
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
         * @brief convert german special chars and vowels into legal html
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
         * @brief if yawk is installed into a subdirectory, use this to get this prefix directory
         * @param object $db database
         * @return string return the directory prefix
         */
        static function getDirPrefix($db)
        {   // returns directory prefix from settings
            $dirprefix = settings::getSetting($db, "dirprefix");
            return $dirprefix;
        }

        /**
         * @brief get hostname (url where yawk is installed) from database
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
         * @brief remove a directory recurse
         * @param string $dir the directory to delete
         * @return bool
         */
        static function recurseRmdir($dir) {
            if (is_dir(dirname($dir)))
            {
                $files = array_diff(scandir($dir), array('.','..'));
                foreach ($files as $file) {
                    (is_dir("$dir/$file")) ? self::recurseRmdir("$dir/$file") : unlink("$dir/$file");
                }
                return rmdir($dir);
            }
            else
            {
                return false;
            }
        }

        /**
         * @brief sometimes it is necessary to add a slash to a url.
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
         * @brief get any property from any table where id is given ID
         * @param object $db database
         * @param string $property what to select (field)
         * @param string $table from wich (table)
         * @param string $id where id = (id)
         * @return bool
         */
        static function getProperty($db, $property, $table, $id)
        {   /** @param $db \YAWK\db $res */
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
         * @brief get requested group ID for given page ID (used in page-edit)
         * @param object $db database
         * @param string $id page ID
         * @param string $table the table to select from
         * @return string|bool return the group ID or false
         */
        static function getGroupId($db, $id, $table)
        {   /** @param $db \YAWK\db $res */
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
         * @brief get requested group ID for given page ID
         * @param object $db database
         * @param string $id page ID
         * @param string $table the table to select from
         * @return string|bool return the group ID or false
         */
        static function getGroupFromId($db, $id, $table)
        {
            /** @param $db \YAWK\db $res */
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
         * @brief get all user groups from database
         * @param object $db database
         * @param string $table the table to select from
         * @return array|bool|string
         */
        static function getGroups($db, $table)
        {
            /** @param $db \YAWK\db $res */
            $groupsArray = array();
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
         * @brief include page header and metadata
         * @param object $db database
         * @param string $host host URL
         */
        static function includeHeader($db, $host)
        {   /** @var $db \YAWK\db */
            global $currentpage;
            $i = 1;
            echo "<title>" . $currentpage->title . "</title>
<base href=\"".$host."\">
<meta http-equiv=\"Content-Type\" content=\"text/html\">
<link rel=\"shortcut icon\" href=\"favicon.ico\" type=\"image/x-icon\">";
        }

        /**
         * @brief returns the current user name, if set
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
         * @brief get submenu ID for given page ID
         * @param object $db database
         * @param string $id page ID
         * @return mixed string|int
         */
        static function getSubMenu($db, $id)
        {
            /** @param $db \YAWK\db $res */
            if ($res = $db->query("SELECT m.id
	                           FROM {pages} as p
	                           JOIN {menu_names} as m on m.id = p.menu
	                           WHERE p.id = $id")){
                $row = mysqli_fetch_row($res);
                if (!isset($row[0]) ||(empty($row[0])))
                {
                    return "0";
                }
                else
                {
                    return $row[0];
                }
            }
            else
            {
                return "0";
            }
        }

        /**
         * @brief get menu item for given page ID
         * @param object $db database
         * @param int $id page ID
         * @return bool
         */
        static function getMenuItem($db, $id)
        {
            /** @param $db \YAWK\db $res */
            if ($row = $db->query("SELECT p.menu, m.name
	                              FROM {pages} as p
	                              JOIN {menu_names} as m on m.id = p.menu
	                              WHERE p.id = $id"))
            {
                $res = mysqli_fetch_row($row);
                if (isset($res[1])){
                    return $res[1];
                }
                else {
                    return null;
                }
            }
            else
            {
                return null;
            }
        }

        /**
         * @brief get menu names from database
         * @param object $db database
         * @return array|bool
         */
        static function getMenus($db)
        {
            /** @var $db \YAWK\db */
            $menusArray = array();
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
         * @brief returns menu name for given menu ID
         * @param object $db database
         * @param int $id menu ID
         * @return bool
         */
        static function getMenuName($db, $id)
        {   /** @param $db \YAWK\db $res */
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
         * @brief returns menu language for given menu ID
         * @param object $db database
         * @param int $id menu ID
         * @return bool
         */
        static function getMenuLanguage($db, $id)
        {   /** @param $db \YAWK\db $res */
            if ($res = $db->query("SELECT menuLanguage
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
         * @brief get pages from database
         * @param object $db database
         * @return bool|mixed
         */
        static function getPages($db)
        {   /** @var $db \YAWK\db */
            if ($row = $db->query("SELECT id, title
                                  FROM {pages} ORDER BY title"))
            {
                $PagesArray = array();
                while ($res = $row->fetch_assoc())
                {
                    $pagesArray[] = $res;
                }
                return $pagesArray;
            }
            else
            {
                return false;
            }
        }


        /**
         * @brief get user groups (roles) for given page
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
         * @brief get group ID (role) for given page ID
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
         * @brief returns the current datetime
         * @return string datetime Y-m-d H:i:s
         */
        static function now()
        {   // return current datetime in mysql format
            return date("Y-m-d H:i:s");
        }

        /**
         * @brief split a date to month, day, year and time
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
                    $month = "January";
                    // $month = $lang['FEBRUARY'];
                    break;
                case "02":
                    $month = "February";
                    // $month = $lang['FEBRUARY'];
                    break;
                case "03":
                    $month = "March";
                    // $month = $lang['MARCH'];
                    break;
                case "04":
                    $month = "April";
                    // $month = $lang['APRIL'];
                    break;
                case "05":
                    $month = "May";
                    // $month = $lang['MAY'];
                    break;
                case "06":
                    $month = "June";
                    // $month = $lang['JUNE'];
                    break;
                case "07":
                    $month = "July";
                    // $month = $lang['JULY'];
                    break;
                case "08":
                    $month = "August";
                    // $month = $lang['AUGUST'];
                    break;
                case "09":
                    $month = "September";
                    // $month = $lang['SEPTEMBER'];
                    break;
                case "10":
                    $month = "October";
                    // $month = $lang['OCTOBER'];
                    break;
                case "11":
                    $month = "November";
                    // $month = $lang['NOVEMBER'];
                    break;
                case "12":
                    $month = "December";
                    // $month = $lang['DECEMBER'];
                    break;
            }
            return $splitDate = array("year" => "$year", "day" => "$day", "month" => "$month", "time" => "$time");
        }


        /**
         * @brief split a date to month, day, year and time this is the same as splitDate() but keep the months short
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
         * @brief how many time is been gone since given date
         * @param string $userdate date to calculate
         * @param array $lang language array
         * @return string return how many time has gone since $userdate
         */
        static function time_ago($userdate, $lang)
        {
            $time_ago = '';

            $date = new \DateTime($userdate);
            $diff = $date->diff(new \DateTime('now'));

            if ($t = $diff->format("%y"))
            {
                if ($t > 1)
                {
                    $time_ago = (int)$t . ' '.$lang['YEARS'].'';
                }
                else if ($t < 2)
                {
                    $time_ago = (int)$t . ' '.$lang['YEAR'].'';
                }
            }

            elseif ($t = $diff->format("%m"))
            {
                if ($t > 1)
                {
                    $time_ago = (int)$t . ' '.$lang['MONTHS'].'';
                }
                else if ($t < 2)
                {
                    $time_ago = (int)$t . ' '.$lang['MONTH'].'';
                }
            }
            elseif ($t = $diff->format("%d"))
            {

                if ($t >= 7 && $t < 13)
                {
                    $time_ago = $lang['A_WEEK_AGO'];
                }
                elseif ($t >= 14 && $t < 20)
                {
                    $time_ago = $lang['TWO_WEEKS_AGO'];
                }
                elseif ($t >= 21 && $t < 27)
                {
                    $time_ago = $lang['THREE_WEEKS_AGO'];
                }
                elseif ($t >= 28 && $t < 31)
                {
                    $time_ago = $lang['FOUR_WEEKS_AGO'];
                }
                else if ($t > 1)
                {
                    $time_ago = (int)$t . ' '.$lang['DAYS_P'].'';
                }
                else if ($t < 2)
                {
                    $time_ago = (int)$t . ' '.$lang['DAY'].'';
                }
            }

            elseif ($t = $diff->format("%h"))
            {
                if ($t > 1)
                {
                    $time_ago = (int)$t . ' '.$lang['HOURS'].'';
                }
                else if ($t < 2)
                {
                    $time_ago = (int)$t . ' '.$lang['HOUR'].'';
                }
            }

            elseif ($t = $diff->format("%i"))
            {
                if ($t > 1)
                {
                    $time_ago = (int)$t . ' '.$lang['MINUTES'].'';
                }
                else if ($t < 2)
                {
                    $time_ago = (int)$t . ' '.$lang['MINUTE'].'';
                }
            }

            elseif ($t = $diff->format("%s"))
            {
                if ($t < 60)
                {
                    $time_ago = $lang['LESS_THAN_A_MINUTE'];
                }
            }

            // if language is german, turn around the 'ago' term
            if (\YAWK\language::getCurrentLanguageStatic() === "de-DE")
            {   // return reverse for germans
                return $lang['AGO'] . ' '.$time_ago.'';
            }
            // default return string
            return $time_ago . ' '.$lang['AGO'].'';
        }

        /**
         * @brief return weekday from given date
         * @param string $date the date to calculate
         * @return bool|false|string
         */
        static function getWeekday($date, $lang)
        {
            global $lang;
            if (isset($date)){
                // get weekday
                $weekday = date("l",strtotime($date));
                if (isset($lang) && (!empty($lang) && (is_array($lang))))
                {
                    // translate, if language is set
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
                }
                return $weekday;
            }
            else {
                return false;
            }
        }

        /**
         * @brief Returns, if given syslog category ID is active or not
         * @param object $db database object
         * @param string $syslogCategoryID ID of the requested syslog category
         * @return array
         */
        static function isSysLogCategoryActive($db, $syslogCategoryID)
        {   /** @var $db \YAWK\db */
            $syslogSettings = arraY();
            if(isset($syslogCategoryID) && (!empty($syslogCategoryID)))
            {   // query db
                if ($sql = ($db->query("SELECT active, notify from {syslog_categories} WHERE id = '".$syslogCategoryID."'")))
                {
                    // fetch db
                    while ($row = mysqli_fetch_assoc($sql))
                    {
                        $syslogSettings[] = $row;
                    }
                    // check if category should be logged (is active)
                    if (isset($syslogSettings['active']) && (!empty($active['active']) && ($active['active'] === "1")))
                    {   // category active
                        $syslogSettings['active'] = 1;
                    }
                    else
                    {   // category not active
                        $syslogSettings['active'] = 0;
                    }
                    // check if category should be notyfied (is enabled)
                    if (isset($syslogSettings['notify']) && (!empty($active['notify']) && ($active['notify'] === "1")))
                    {   // notify active
                        $syslogSettings['notify'] = 1;
                    }
                    else
                    {   // notify not active
                        $syslogSettings['notify'] = 0;
                    }
                }
                else
                {   // unable to query database, set notification ON default
                    $syslogSettings['active'] = 1;
                    $syslogSettings['notify'] = 1;
                    return $syslogSettings;
                }
                return $syslogSettings;
            }
            else
            {   // no category ID was sent, set notification ON default
                $syslogSettings['active'] = 1;
                $syslogSettings['notify'] = 1;
                return $syslogSettings;
            }
        }

        /**
         * @brief set a syslog entry to database
         * @param object $db database
         * @param int    $log_category log category
         * @param int    $log_type log type (info = 0 , warning = 1, error = 2)
         * @param string $message logging message
         * @param int    $fromUID affected from UID
         * @param int    $toUID affected to UID
         * @param int    $toGID affected GID
         * @param int    $seen 0|1 status if this entry has been overviewed
         * @return bool|null
         */
        static function setSyslog($db, $log_category, $log_type, $message, $fromUID, $toUID, $toGID, $seen)
        {   /** @var $db \YAWK\db */
            // THIS DB STORES ALL THE SYSLOG FOR ADMINISTRATOR REASONS
            // insert admin-friendly message of all data into syslog db

            // get current log date
            $log_date = sys::now();

            // check if syslog is enabled
            if (\YAWK\settings::getSetting($db, "syslogEnable") == "1")
            {
                // check if log_category is empty
                if (!isset($log_category) || (empty($log_category) || ($log_category === "0")))
                {   // default value: system settings (type 1)
                    $log_category = 1;
                }
                // check if message is empty
                if (!isset($message) || (empty($message) || ($message === "0")))
                {   // default value
                    if (isset($_GET['page'])) { $page = $_GET['page']; } else { $page = 'no page set.'; }
                    $message = "something happened, but no text was set for logging. $page";
                }

                // check if log type is set
                if (!isset($log_type) ||(empty($log_type)))
                {
                    $log_type = 0;
                }

                // check, if fromUID (user that affected the event) is set
                if (!isset($fromUID) || (empty($fromUID) || ($fromUID == "0")))
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


                // get syslog settings (which category is active and should be notified)
                $syslogSettings = self::isSysLogCategoryActive($db, $log_category);
                // check if notification should be enabled for this category
                if ($syslogSettings[0]['notify'] == 1)
                {   // set syslog entry to state !seen (not seen)
                    $seen = 0;  // means notification WILL be drawn
                }
                else
                {   // set syslog entry to state 'seen'
                    $seen = 1;  // means notification will NOT be drawn
                }

                // only add syslog entry if category is enabled for logging (active)
                if ($syslogSettings[0]['active'] == 1)
                {
                    // insert syslog entry into db
                    if ($db->query("INSERT INTO {syslog} (log_date, log_category, log_type, message, fromUID, toUID, toGID, seen)
                                            VALUES ('".$log_date."',
                                                    '".$log_category."',
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
                {   // syslog disabled for this category
                    return null;
                }
            }
            else
            {   // syslog is disabled
                return null;
            }
        }

        /**
         * @brief get all syslog entries
         * @param object $db database
         * @return array|bool $syslogResults
         */
        static function getSyslog($db)
        {   /** @var $db \YAWK\db */
            // get syslog data from db
            $syslogResults = array();
            if ($res = $db->query("SELECT * FROM {syslog} AS log
                                       LEFT JOIN {syslog_categories} AS category ON log.log_category=category.id
                                       LEFT JOIN {users} AS u ON log.fromUID=u.id
                                       GROUP BY log.log_id
                                       ORDER BY log.log_date DESC"))
            {   // syslog entry set
                while ($row = mysqli_fetch_assoc($res))
                    // check if array is set and not empty
                {   // build syslog results array
                    $syslogResults[] = $row;
                }
                // check if syslog array is set and not empty
                if (is_array($syslogResults) && (!empty($syslogResults)))
                {   // all good...
                    return $syslogResults;
                }
                else
                {   // array is not set or empty
                    return false;
                }
            }
            else
            {   // failed to query syslog data from db
                return false;
            }
        }

        /**
         * @brief get all syslog categories
         * @param object $db database
         * @return array|bool $syslogResults
         */
        static function getSyslogCategories($db)
        {   /** @var $db \YAWK\db */
            // get syslog data from db
            $syslogCategories = array();
            if ($res = $db->query("SELECT * FROM {syslog_categories} ORDER BY property"))
            {   // syslog entry set
                while ($row = mysqli_fetch_assoc($res))
                    // check if array is set and not empty
                {   // build syslog results array
                    $syslogCategories[] = $row;
                }
                // check if syslog array is set and not empty
                if (is_array($syslogCategories) && (!empty($syslogCategories)))
                {   // all good...
                    return $syslogCategories;
                }
                else
                {   // array is not set or empty
                    return false;
                }
            }
            else
            {   // failed to query syslog data from db
                return false;
            }
        }

        /**
         * @brief set a system notification for any user or admin
         * @param object $db database
         * @param int    $log_category log category
         * @param int    $log_type log type
         * @param int    $msg_id message id
         * @param int    $fromUID affected from user ID
         * @param int    $toUID affected to user ID
         * @param int    $toGID affected to group ID
         * @param int    $seen 0|1 status if notification has been seen
         * @return bool
         */
        static function setNotification($db, $log_category, $log_type, $msg_id, $fromUID, $toUID, $toGID, $seen)
        {   /** @var $db \YAWK\db */
            // THIS ARE THE MESSAGES FOR END-USERS
            // (a copy of syslog) DUE PERFORMANCE REASONS
            // (only user-messages, no system messages...)
            // insert user-friendly message into notifications db
            if ($db->query("INSERT INTO {notifications} (log_type,msg_id,fromUID,toUID,toGID,seen)
                                        VALUES ('".$log_category."',
                                                '".$log_type."',
                                                '".$msg_id."',
                                                '".$fromUID."',
                                                '".$toUID."',
                                                '".$toGID."',
                                                '".$seen."')"))
            {   // set a notification into user notifications db
                return true;
            }
            else
            {   // q failed
                return false;
            }
        }

        /**
         * @brief mark a notification as seen / unseen
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

        /**
         * @brief check if objects exists and display their data
         */
        static function outputObjects($template, $lang, $controller, $page, $user, $stats)
        {
            $objects = get_defined_vars();
            if (isset($objects) && (is_array($objects)))
            {
                echo "ALL DECLARED OBJECTS IN THIS SCOPE:<hr>";
                echo "<pre>";print_r($objects);echo"</pre><hr>";
            }
            exit;
        }

        /**
         * @brief write ini file
         * @param $array
         * @param $file
         * @return bool
         */
        static function writeIniFile($array, $file)
        {
            $res = array();
            foreach($array as $key => $val)
            {
                if(is_array($val))
                {
                    $res[] = "[$key]";
                    foreach($val as $skey => $sval) $res[] = "$skey = ".(is_numeric($sval) ? $sval : '"'.$sval.'"');
                }
                else $res[] = "$key = ".(is_numeric($val) ? $val : '"'.$val.'"');
            }
            if (self::safeFileReWrite($file, implode("\r\n", $res)))
            {   // ini file written
                return true;
            }
            else
            {   // failed to return ini file
                return false;
            }
        }

        /**
         * @brief Safe way to open a file and update data
         * @param $fileName
         * @param $dataToSave
         * @return bool
         */
        static function safeFileReWrite($fileName, $dataToSave)
        {
            if ($fp = fopen($fileName, 'w'))
            {
                $startTime = microtime(TRUE);
                do
                {
                    $canWrite = flock($fp, LOCK_EX);
                    // If lock not obtained sleep for 0 - 100 milliseconds, to avoid collision and CPU load
                    if(!$canWrite) usleep(round(rand(0, 100)*1000));
                }
                while ((!$canWrite)and((microtime(TRUE)-$startTime) < 5));

                //file was locked so now we can store information
                if ($canWrite)
                {
                    fwrite($fp, $dataToSave);
                    flock($fp, LOCK_UN);
                }
                fclose($fp);
            }
            if (is_file($fileName))
            {
                return true;
            }
            else
            {
                return false;
            }
        }

    } // ./class widget
} // ./ namespace