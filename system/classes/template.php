<?php
namespace YAWK {
    /**
     * <b>Template controller - get and set template settings.</b>
     *
     * Templates itself are located in /system/templates/ - if you want to modify them, start there.
     * <p><i>Class covers both, backend & frontend functionality.
     * See Methods Summary for Details!</i></p>
     *
     * @category   CMS
     * @package    Plugins
     * @author     Daniel Retzl <danielretzl@gmail.com>
     * @copyright  2009-2015 Daniel Retzl yawk.goodconnect.net
     * @license    http://www.gnu.org/licenses/gpl-2.0  GNU/GPL 2.0
     * @version    1.1.3
     * @link       http://yawk.goodconnect.net/
     * @since      File available since Release 1.1.2
     * @annotation The template controller - get and set template settings.
     */
    class template
    {
        public $id;
        public $active;
        public $name;
        public $positions;
        public $description;
        public $releaseDate;
        public $author;
        public $authorUrl;
        public $weblink;
        public $subAuthor;
        public $subAuthorUrl;
        public $modifyDate;
        public $version;
        public $license;
        public $selectedTemplate;


        /**
         * returns the ID of the current (active) template
         * @param object $db
         * @return int
         */
        static function getCurrentTemplateId($db)
        {   // return value of property selectedTemplate from settings db
            return \YAWK\settings::getSetting($db, "selectedTemplate");
        }

        /**
         * fetch positions of current (active) template, explode string and return positions array
         * @param object $db
         * @return array|bool|mixed|string
         */
        static function getTemplatePositions($db)
        {   /** @var $db \YAWK\db */
            $res = '';
            // fetch template id
            $tpl_id = settings::getSetting($db, "selectedTemplate");
            // fetch template positions
            if ($res = $db->query("SELECT positions
	                              FROM {templates}
	                              WHERE id = '" . $tpl_id . "'"))
            {   // fetch data
                $posArray = array();
                while ($row = $res->fetch_assoc())
                {
                    $posArray[] = $row;
                }
                $pos = $posArray[0]['positions'];
                // explode string into array + return
                $positions = explode(':', $pos);
                // return tpl positions
                return $positions;
            }
            else
            {
                // q failed
                return false;
            }
        }

        /**
         * This saves a template as new. It copies the tpl folder and all settings into a new one.
         * @param object $db
         * @param object $template
         * @param string $new_template
         * @param string $positions
         * @param string $description
         * @return bool
         */
        public function saveAs($db, $template, $new_template, $positions, $description)
        {   /** @var \YAWK\db $db */
            // save theme as new template

            $replace = array("/ä/", "/ü/", "/ö/", "/Ä/", "/Ü/", "/Ö/", "/ß/"); // array of special chars
            $chars = array("ae", "ue", "oe", "Ae", "Ue", "Oe", "ss"); // array of replacement chars
            $new_template = preg_replace($replace, $chars, $new_template);      // replace with preg
            // final check: just numbers and chars are allowed
            $new_template = preg_replace("/[^a-z0-9\-\/]/i", "", $new_template);
            // same goes on for $template->name
            $template->name = preg_replace($replace, $chars, $template->name);      // replace with preg
            // final check: just numbers and chars are allowed
            $template->name = preg_replace("/[^a-z0-9\-\/]/i", "", $template->name);

            // check if new tpl folder already exists
            if (file_exists("../system/templates/$new_template/"))
            {   // overwrite data
                \YAWK\sys::full_copy("../system/templates/yawk-bootstrap3", "../system/templates/$new_template");
            }
            else
            {   // copy data into new template directory
                \YAWK\sys::full_copy("../system/templates/yawk-bootstrap3", "../system/templates/$new_template");
            }

            if ($res = $db->query("INSERT INTO {templates} (name, positions, description)
  	                               VALUES('" . $new_template . "', '" . $positions . "', '" . $description . "')"))
            {   // success
                // do something
                // store each setting with new tpl id in database
            }
            else
            {   // q failed, throw error
                \YAWK\alert::draw("warning", "Warning!", "Could not insert your template $new_template into database.", "", 6200);
                return false;
            }
            // all good.
            return true;
        }

        /**
         * Load properties into template object
         * @author      Daniel Retzl <danielretzl@gmail.com>
         * @version     1.0.0
         * @link        http://yawk.website/
         * @param object $db database object
         * @param int $id template id to load
         * @return bool true or false
         */
        public function loadProperties($db, $id)
        {
            /** @var $db \YAWK\db $res */
            $res = $db->query("SELECT * FROM {templates} WHERE id = '".$id."'");
            if ($row = mysqli_fetch_assoc($res)) {
                $this->id = $row['id'];
                $this->active = $row['active'];
                $this->name = $row['name'];
                $this->positions = $row['positions'];
                $this->description = $row['description'];
                $this->releaseDate = $row['releaseDate'];
                $this->author = $row['author'];
                $this->authorUrl = $row['authorUrl'];
                $this->weblink = $row['weblink'];
                $this->subAuthor = $row['subAuthor'];
                $this->subAuthorUrl = $row['subAuthorUrl'];
                $this->modifyDate = $row['modifyDate'];
                $this->version = $row['version'];
                $this->license = $row['license'];
                $this->selectedTemplate = \YAWK\settings::getSetting($db, "selectedTemplate");
                return true;
            }
            else
            {   // could not fetch tpl properties, throw error...
                \YAWK\alert::draw("danger", "Warning!", "Could not fetch template properties. Expect a buggy view.", "", 3000);
                return false;
            }
        }

        /**
         * Returns an array with all template id's + names.
         * @param object $db
         * @return array|bool
         */
        static function getTemplateIds($db)
        {   /** @var \YAWK\db $db */
            // returns an array with all template IDs
            $mysqlRes = $db->query("SELECT id, name
	                              FROM {templates}
	                              ORDER by name ASC");
            while ($row = mysqli_fetch_assoc($mysqlRes)) {
                $res[] = $row;
            }
            if (!empty($res))
            {   // yey, return array
                return $res;
            }
            else
            {   // could not fetch array
                return false;
            }
        }

        static function countTemplateSettings($db, $templateID)
        {   /** @var $db \YAWK\db */
            // count + return settings from given tpl ID
            $res = $db->query("SELECT id FROM {template_settings}
                                        WHERE templateID = '" . $templateID . "'");
            $i_tplsettings = mysqli_num_rows($res);
            return $i_tplsettings;
        }

        public static function getTemplateNameById($db, $templateID)
        {   /** @var $db \YAWK\db */
            if (!isset($templateID) || (empty($templateID)))
            {   // template id is not set, try to get current template
                $templateID = \YAWK\settings::getSetting($db, "selectedTemplate");
            }
                // query template name
                if ($res = $db->query("SELECT name from {templates} WHERE id = $templateID"))
                {   // fetch data
                    if ($row = mysqli_fetch_row($res))
                    {   // return current name
                        return $row[0];
                    }
                }
                else
                {   // exit and throw error
                    die ("could not get template name");
                }
                return null;
        }

        public static function getCurrentTemplateName($db, $location, $templateID)
        {   /** @var $db \YAWK\db */
            if (!isset($location) || (empty($location)))
            {   // if location is empty, set frontend as default
                $location = "frontend";
                $prefix = "";
            }
            else
            {   // check location to set path correctly
                if ($location == "frontend")
                {   // call from frontend
                    $prefix = "";
                }
                else
                {   // call from backend
                    $prefix = "../";
                }
            }
            // NO TEMPLATE ID IS SET...
            if (!isset($templateID) || (empty($templateID)))
            {
                // check if user has its own template
                // $userTemplateID = \YAWK\user::getUserTemplateID($db, )
                // no templateID sent via param, set current selected template ID
                $templateID = \YAWK\settings::getSetting($db, "selectedTemplate");
            }
            // get current template name from database
            $tpldir = $prefix."system/templates/";
            if ($res = $db->query("SELECT name FROM {templates}
                       WHERE id = $templateID"))
            {   // fetch data
                if ($row = mysqli_fetch_row($res))
                {   // check if selected tpl exists
                    if (!$dir = @opendir("$tpldir" . $row[0]))
                    {   // if directory could not be opened: throw error
                        return "<b>Oh-oh! There was a big error. . .</b> <u>you shall not see this!</u><br><br>Unable to load template ".$row[0].".&nbsp; I am deeply sorry.<br> I am sure my administrator is hurry to fix that problem.<br> yours,<br>YaWK <i><small>(Yet another Web Kit)</i></small>";
                    }
                    else
                    {   // return template name
                        return $row[0];
                    }
                }
                else
                {   // could not fetch template -
                    // - in that case set default template
                   // print alert::draw("warning", "Warning: ", "Template kann nicht gelesen werden, default template gesetzt. (yawk-bootstrap3)","page=settings-system","4800");
                    return "template ID $templateID not in database...?";
                }
            }
            // something else has happened
            return false;
        }

        public function setTemplateCssFile($db, $tplId, $content, $minify)
        {   /** @var $db \YAWK\db */
            // check whether templateID is not set or empty
            if (!isset($tplId) || (empty($tplId)))
            {   // set default value: template 1
                $tplId = 1;
            }
            // prepare vars
            // $content = $property." = ".$value.";"."\r\n";
            $filename = self::getSettingsCSSFilename($db, "backend", $tplId);
            // check if file need to be minified
            if (isset($minify) && (!empty($minify)))
            {   // minify is set
                if ($minify === 1)
                {   // create a minified version: template/css/custom.min.css (for production include)
                    $filename = substr($filename, 0, -4);
                    $filename = "$filename.min.css";
                    $content = \YAWK\sys::minify($content);
                }
            }
            // do all the file stuff, open, write, close and chmod to set permissions.
            $handle = fopen($filename, "wb");

            if (!fwrite($handle, $content))
            {   // write failed, throw error
                \YAWK\alert::draw("danger", "Error!", "Could not write $filename<br>Please check your file / owner or group permissions.", "", 4200);
            }
            if (!fclose($handle))
            {   // close failed, throw error
                \YAWK\alert::draw("warning", "Warning!", "Failed to close $filename<br>Please try again and / or expect some errors.", "", 4200);
            }
            if (!chmod($filename, 0775))
            {   // chmod failed, throw error
                \YAWK\alert::draw("warning", "Warning!", "Failed to chmod(775) $filename<br>Please check file / folder / owner / group permissions!", "", 4200);
            }
            // after all....
            return true;
        }

        public function setCustomCssFile($db, $content, $minify, $templateID)
        {   /** @var $db \YAWK\db */
            // create template/css/custom.css (for development purpose in backend)
            // prepare vars
            $filename = self::getCustomCSSFilename($db, "backend", $templateID);
            // check if file need to be minified
            if (isset($minify) && (!empty($minify)))
            {   // minify is set
                if ($minify === 1)
                {   // create a minified version: template/css/custom.min.css (for production include)
                    $filename = substr($filename, 0, -4);
                    $filename = "$filename.min.css";
                    $content = \YAWK\sys::minify($content);
                }
            }
            // do all the file stuff, open, write, close and chmod to set permissions.
            $handle = fopen($filename, "wb");
            //$content = \YAWK\sys::replaceCarriageReturns("\n\r", $content);
            $content = \YAWK\sys::replacePreTags("\n\r", $content);
            if (!fwrite($handle, $content))
            {   // write failed, throw error
                \YAWK\alert::draw("danger", "Error!", "Could not write $filename<br>Please check your file / owner or group permissions.", "", 4200);
            }
            if (!fclose($handle))
            {   // close failed, throw error
                \YAWK\alert::draw("warning", "Warning!", "Failed to close $filename<br>Please try again and / or expect some errors.", "", 4200);
            }
            if (!chmod($filename, 0775))
            {   // chmod failed, throw error
                \YAWK\alert::draw("warning", "Warning!", "Failed to chmod(775) $filename<br>Please check file / folder / owner / group permissions!", "", 4200);
            }
            // after all....
            return true;
        }

        public function getCustomCSSFile($db, $templateID)
        {   // get the content from custom.css
            $filename = self::getCustomCSSFilename($db, "backend", $templateID);
            $content = file_get_contents($filename);
            return $content;
        }

        public function getSettingsCSSFilename($db, $location, $templateID)
        {   /** @var $db \YAWK\db */
            // prepare vars... path + filename
            $tplName = self::getCurrentTemplateName($db, $location, $templateID); // tpl name
            $alias = "settings"; // set CSS file name
            $filename = "../system/templates/$tplName/css/" . $alias . ".css";
            return $filename;
        }

        public function getCustomCSSFilename($db, $location, $templateID)
        {   /** @var $db \YAWK\db */
            // prepare vars... path + filename
            $tplName = self::getCurrentTemplateName($db, $location, $templateID); // tpl name
            $alias = "custom"; // set CSS file name
            $filename = "../system/templates/$tplName/css/" . $alias . ".css";
            return $filename;
        }

        public static function getMaxId($db)
        {   /* @var $db \YAWK\db */
            if ($res = $db->query("SELECT MAX(id) from {templates}"))
            {   // fetch id
                if ($row = mysqli_fetch_row($res))
                {
                    return $row[0];
                }
                else
                    {
                        return false;
                    }
            }
            else
                {
                    return false;
                }
        }

        function deleteSettingsCSSFile($db, $filename)
        {   // if no filename is given
            if (!isset($filename) || (empty($filename)))
            {   // set default filename
                $filename = self::getSettingsCSSFilename($db);
            }
            // we want the settings.css file to be overridden, so check if file exists and delete it if needed.
            if (file_exists($filename))
            {   // if there is a file, delete it.
                if (!unlink($filename))
                {   // delete failed, throw error
                    \YAWK\alert::draw("danger", "Error!", "Failed to unlink $filename<br>Please delete this file and check file / folder / owner or group permissions!", "",6200);
                    return false;
                }
                else
                {   // delete worked
                    return true;
                }
            }
            else
            {   // file does not exist
                return true;
            }
        }

        function setTemplateSetting($db, $id, $property, $value)
        {   /** @var $db \YAWK\db */
            $property = $db->quote($property);
            $value = $db->quote($value);
            if ($res = $db->query("UPDATE {template_settings}
                                   SET value = '" . $value . "'
                                   WHERE property = '" . $property . "'
                                   AND templateID = '".$id."'"))
            {   // success
                return true;
            }
            else
            {   // q failed
                return false;
            }
        }

        /* outdated?? */
        public static function setTemplateActive($db, $templateID)
        {   /** @var $db \YAWK\db */
            if (!isset($templateID) && (empty($templateID)))
            {   // if template id is not set, get it from database
                $templateID = \YAWK\settings::getSetting($db, "selectedTemplate");
            }
            // null active template in table
            if (!$res = $db->query("UPDATE {templates} SET active = 0 WHERE active != 0"))
            {   // error: abort.
                return false;
            }
            if ($res = $db->query("UPDATE {templates}
                                   SET active = 1
                                   WHERE id = $templateID"))
            {   // success
                return true;
            }
            else
            {   // q failed
                return false;
            }

        }

        public static function copyTemplateSettings($db, $templateID, $newID)
        {   /** @var $db \YAWK\db */

        $res = $db->query("INSERT INTO {template_settings} (templateID, property, value, valueDefault, description, activated, sort, fieldClass, placeholder)
                           SELECT NULL, property, value, valueDefault, description, activated, sort, fieldClass, placeholder FROM {template_settings}
                           WHERE templateID = '".$templateID."'");
            if (!$res)
            {
                \YAWK\alert::draw("danger", "Could not copy settings", "please try again.", "", 5000);
            }
            else
            {
                \YAWK\alert::draw("success", "Settings copied", "successful", "", 5000);
                // alter IDs
                $update = $db->query("UPDATE {template_settings} SET templateID='".$newID."' WHERE templateID=0");
                if ($update)
                {
                    \YAWK\alert::draw("success", "Settings are set-up", "successful", "", 5000);
                }
                else
                {
                    \YAWK\alert::draw("warning", "Could not set new template settings", "unable to alter IDs.", "", 5000);
                }
            }
        }

        /**
         * Add a new template setting to the database.
         * @param object $db
         * @param string $property
         * @param string $value
         * @param string $valueDefault
         * @param string $description
         * @param string $fieldclass
         * @param string $placeholder
         * @return bool
         */
        function addTemplateSetting($db, $property, $value, $valueDefault, $description, $fieldclass, $placeholder)
        {   /** @var $db \YAWK\db  */
            $active = 1;
            $sort = 0;
            $templateID = \YAWK\settings::getSetting($db, "selectedTemplate"); // self::getCurrentTemplateId($db);
            $property = $db->quote($property);
            $value = $db->quote($value);
            $valueDefault = $db->quote($valueDefault);
            $description = $db->quote($description);
            $fieldclass = $db->quote($fieldclass);
            $placeholder = $db->quote($placeholder);
            if ($res = $db->query("INSERT INTO {template_settings} (templateID, property, value, valueDefault, description, activated, sort, fieldClass, placeholder)
                                   VALUES('" . $templateID . "','" . $property . "', '" . $value . "', '" . $valueDefault . "', '" . $description . "', '" . $active . "', '" . $sort . "', '" . $fieldclass . "', '" . $placeholder . "')"))
            {   // success
                return true;
            }
            else
            {   // q failed
                return false;
            }
        }

        public function setTemplateDetails($db, $description = "", $author = "", $authorUrl ="", $id)
        {    /** @var $db \YAWK\db  */
            if ($res = $db->query("UPDATE {templates} SET description = '$description', subAuthor = '$author', subAuthorUrl = '$authorUrl' WHERE id = $id"))
            {   // template details updated...
                return true;
            }
            else
                {   // could not save template details
                    return false;
                }
        }

        static function deleteTemplate($db, $templateID)
        {   /** @var $db \YAWK\db  */
            if (!isset($templateID) && (empty($templateID)))
            {   // no templateID is set...
                return false;
            }
            else
                {   // quote var, just to be sure its clean
                    $templateID = $db->quote($templateID);

                    // to delete the files, we need to get the template folder's name
                    // this function checks if template exits in database + if folder physically in on disk
                    $templateFolder = \YAWK\template::getCurrentTemplateName($db, "backend", $templateID);

                    // delete template folder from disk
                    if (!\YAWK\sys::recurseRmdir("../system/templates/$templateFolder"))
                    {   // booh, deleting recurse did not work
                        return false;
                    }

                    // delete template from database {templates}
                    if (!$res = $db->query("DELETE FROM {templates} WHERE id = $templateID"))
                    {   // if failed
                        return false;
                    }
                    else
                        {   // ALTER table and set auto_increment value to prevent errors when deleting + adding new tpl
                            if ($res = $db->query("SELECT MAX(id) FROM {templates}"))
                            {   // get MAX ID
                                $row = mysqli_fetch_row($res);
                                if (!$res = $db->query("ALTER TABLE {templates} AUTO_INCREMENT $row[0]"))
                                {   // could not select auto encrement
                                    return false;
                                }
                            }
                        }

                    // delete template settings for requested templateID
                    if (!$res = $db->query("DELETE FROM {template_settings} WHERE templateID = $templateID"))
                    {   // delete settings failed...
                        return false;
                    }
                    else
                        {   // all good so far.
                            return true;
                        }
                }
        }

        function getSetting($db, $filter, $special, $readonly, $user)
        {   /** @var $db \YAWK\db  */
            // build sql query string
            // to build the template-settings page correct within one function
            // the query string will be manipulated like
            if ($filter != '%-color')
            {   // don't fetch -color settings
                $sql = "&& ts.property NOT RLIKE '.*-color'";
            }
            if ($filter != '%-bgcolor')
            {   // don't fetch -bgcolor settings
                $sql = "&& ts.property NOT RLIKE '.*-bgcolor'";
            }
            else
            {
                $sql = '';
            }

            if (isset($readonly))
            {   // if any field should be readonly
                switch ($readonly)
                {   // set html code
                    case "readonly":
                        $readonly = "readonly=\"readonly\"";
                        break;
                    default:
                        $readonly = '';
                        break;
                }
            }
            // OVERRIDE SETTINGS
            if (isset($user))
            {
                if ($user->overrideTemplate == 1)
                {
                    $sql = "SELECT ts.property, ts.value, ts.valueDefault, ts.description, ts.fieldClass, ts.placeholder
                                       FROM {template_settings} ts
                                       JOIN {users} u on u.templateID = ts.templateID
                                       WHERE ts.activated = 1 && u.id = $user->id && ts.property
                                       LIKE '$filter' && ts.property NOT RLIKE '.*-pos' $sql ORDER BY ts.sort";
                }
                else
                    {
                        $sql = "SELECT ts.property, ts.value, ts.valueDefault, ts.description, ts.fieldClass, ts.placeholder
                                       FROM {template_settings} ts
                                       JOIN {settings} s on s.value = ts.templateID
                                       WHERE ts.activated = 1 && s.property = 'selectedTemplate' && ts.property
                                       LIKE '$filter' && ts.property NOT RLIKE '.*-pos' $sql ORDER BY ts.sort";
                    }
            }
            else
                {
                    return false;
                }

            if ($res = $db->query($sql))
            {
                $x = 1; // <h> tags count var
                // draw input fields / template-settings.php
                while ($row = mysqli_fetch_assoc($res))
                {   // fetch template settings in loop
                    $property = $row['property'];
                    $value = $row['value'];
                    // $property = substr("$property", 0, -4);
                    // echo  "<label for=\"".$row['property']."\">" . $row['description'] . "</label><br>";

                    if ($filter == "h%-fontsize")
                    {   // case <h> fontsize
                        // draw a textfield
                        echo "<div style=\"display:inline-block;\"><label for=\"" . htmlentities($row['property']) . "\">";
                        echo "<legend>";
                        echo "<input type=\"text\" id=\"h" . $x . "-fontsize\" class=\"form-control\" name=\"" . htmlentities($row['property']) . "\" value=\"" . htmlentities($row['value']) . "\" />";
                        echo "<div id=\"slider$x\"></legend></div>";
                        $x++;
                    }
                    else
                    {   // draw a textfield
                        echo "<br><label for=\"".$row['property']."\"><small>" . $row['description'] . " <i class=\"h6 small\">default: ".$row['valueDefault']."</i></small></label><br>";
                        echo "<div style=\"display:inline-block; \">";
                        echo "<input id=\"";
                        echo $row['property'];
                        echo "\" placeholder=\"";
                        echo $row['placeholder'];
                        echo "\" class=\"form-control ";
                        echo $row['fieldClass'];
                        echo "\" type=\"text\" size=\"64\" maxlength=\"255\"";
                        echo $readonly;
                        echo "name=\"" . htmlentities($row['property']) . "\" value=\"" . htmlentities($row['value']) . "\" /><br>";
                    }

                    if ($special == "slider")
                    {   // set slider html
                        // if method is called with slider parameter, draw one with given property name
                        echo " <div id=\"slider-";
                        echo $row['property'];
                        echo "\"></div>";
                    }
                    echo "</div></label>";
                }
            }
            else
            {   // q failed
                return false;
            }
            // all good, fin
            return true;
        }
        /* END FUNCTION YAWK\settings::getSetting */

        /* Returns a radio list of Google fonts : BACKEND function */
        function getgFonts($db, $item)
        {   /** @var $db \YAWK\db */
            $nc = '';
            $gfontID = '';
            // query fonts
            if ($res = $db->query("SELECT ts.property, ts.value, ts.description
                                              FROM {template_settings} ts
                                              JOIN {settings} s on s.value = ts.templateID
                                              WHERE ts.activated = 1 && s.property = 'selectedTemplate' && ts.property = '$item'
                                              ORDER BY sort"))
            {
                // draw radio buttons in loop...
                while ($row = mysqli_fetch_assoc($res)) {
                    $gfontID = $row['value'];
                    if ($gfontID === '0')
                    {   // checked
                        $nc = "checked=\"checked\"";
                    }
                    else
                    {   // not checked
                        $nc = "";
                    }
                }
            echo "<div id=\"nogooglefont\"><input type=\"radio\" name=\"global-gfont\" value=\"0\" $nc> | Use system default fonts </div><br>";
            echo "<div id=\"googlefontcontainer\">";

            if ($res = $db->query("SELECT id, font, description, activated
    							FROM {gfonts}
    							WHERE activated = 1
    							AND id != 0
    							ORDER BY font"))
                {
                    while ($row = mysqli_fetch_array($res)) {
                        //	test output:
                        $id = $row[0];
                        $value = $row[1];
                        $description = $row[2];
                        if ($gfontID === "$id") {
                            $checked = "checked=\"checked\"";
                        } else {
                            $checked = "";
                        }

                        echo "<link href=\"http://fonts.googleapis.com/css?family=$row[1]\" rel=\"stylesheet\" type=\"text/css\">";
                        echo "<div id=\"googlefont\">
<a class=\"pull-right\" data-confirm=\"Google Font &laquo;$value&raquo; wirklich l&ouml;schen?\" href='index.php?page=template-edit&deletegfont=1&gfontid=$id'><i style=\"margin-bottom:5px;\" class=\"fa fa-trash-o\"></i></a>
<input type=\"radio\" $checked name=\"".$item."\" value=\"$id\">
| <span style=\"font-family:$row[1]; font-size:18px;\">$description</span>
<hr></div>";
                    } // ./ end while
                }
                else
                {   // fetch loop failed
                    return false;
                }
            echo "</div>";
            }
            else
            {   // q failed;
                return false;
            }
            // fin
            return true;
        } // ./ function getgFonts


        /* delete a gfont */
        function deleteGfont($db, $gfontid)
        {   /** @var $db \YAWK\db */
            if ($res = $db->query("DELETE from {gfonts}
                     			   WHERE id = '" . $gfontid . "'"))
            {   // success
                return true;
            }
            else
            {   // q failed
                return false;
            }
        }

        function addgfont($db, $gfont, $description)
        {   /** @var $db \YAWK\db */
            $gfont = $db->quote($gfont);
            $description = $db->quote($description);
            // ## select max ID from gfonts
            if ($res = $db->query("SELECT MAX(id) FROM {gfonts}"))
            {   // fetch data
                $row = mysqli_fetch_row($res);
                $id = $row[0] + 1;
                if ($res = $db->query("INSERT INTO {gfonts} (id, font, description)
  	                                   VALUES('" . $id . "', '" . $gfont . "', '" . $description . "')"))
                {   // success
                    return true;
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

        static function getActivegfont($db, $status, $property)
        {   /* @var \YAWK\db $db */
            $res = $db->query("SELECT id, font
                     FROM {gfonts}
                     WHERE activated = 1
                      AND id = (SELECT ts.value
                      FROM {template_settings} ts
                      JOIN {settings} s on s.value = ts.templateID
                      WHERE ts.activated = 1 && s.property = 'selectedTemplate' && ts.property = '$property')");
            while ($row = mysqli_fetch_array($res)) {
                // if no google font is selected
                if ($row[1] === "0") {
                    return "font-family: Arial";
                }
                // css include output for index.php
                if ($status == "url") {
                    return "
<link rel=\"stylesheet\" href=\"http://fonts.googleapis.com/css?family=$row[1]\" type=\"text/css\" media=\"all\">";
                } else {
                    return "font-family: $row[1];";
                }
            }
            return null;
        }

        static function outputActivegFont($db)
        {
            // set Google Font for Heading, Menu & paragraph Text
            $gHeading = self::getTemplateSetting($db, "value", "heading-gfont");
            $gMenu = self::getTemplateSetting($db, "value", "menu-gfont");
            $gText = self::getTemplateSetting($db, "value", "text-gfont");
            // make sure that we are loading just the google font we are really need
            if ($gHeading == $gMenu && $gHeading == $gText)
            {
                echo self::getActivegfont($db, "url", "heading-gfont");
            }
            elseif ($gHeading == $gMenu)
            {
                echo self::getActivegfont($db, "url", "heading-gfont");
                echo self::getActivegfont($db, "url", "text-gfont");
            }
            elseif ($gHeading == $gText)
            {
                echo self::getActivegfont($db, "url", "heading-gfont");
                echo self::getActivegfont($db, "url", "menu-gfont");
            }
            else
            {
                echo self::getActivegfont($db, "url", "heading-gfont");
                echo self::getActivegfont($db, "url", "menu-gfont");
                echo self::getActivegfont($db, "url", "text-gfont");
            }
        }

        static function getTemplateSetting($db, $field, $property)
        {   /** @var $db \YAWK\db */
            $tpl_id = settings::getSetting($db, "selectedTemplate");
            if ($res = $db->query("SELECT $field
                        	FROM {template_settings}
                            WHERE property = '" . $property . "'
                            AND templateID = '" . $tpl_id . "'"))
            {   // fetch data
                $row = mysqli_fetch_row($res);
                return $row[0];
            }
            else
            {   // q failed
                return false;
            }
        }

        static function includeHeader($db)
        {   /** @var \YAWK\db $db */
            global $currentpage;
            $i = 1;
            $host = \YAWK\settings::getSetting($db, "host");
            echo "<title>" . $currentpage->title . "</title>
      <meta http-equiv=\"Content-Type\" content=\"text/html; charset=\"utf-8\">
      <link rel=\"shortcut icon\" href=\"favicon.ico\" type=\"image/x-icon\">
      <base href=\"".$host."/\">";
            $get_localtags = $db->query("SELECT name, content
                    FROM {meta_local}
                    WHERE page = '" . $currentpage->id . "'");
            while ($row = mysqli_fetch_row($get_localtags)) {
                if (isset($row['1']) && !empty($row['1'])) {
                    echo "<meta name=\"" . $row[0] . "\" content=\"" . $row[1] . "\" />";
                }
                else
                {
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

        static function setPosition($db, $position)
        {
            global $currentpage;
            $main_set = 0;
            $globalmenu_set = 0;
            // get template setting for given pos
            $setting = self::getTemplateSetting($db, $position, "");
            if (empty($setting)) {
                // substr, because css definitions are without -pos (changefix?!)
                $position = substr("$position", 0, -4);
                // if main, we need to include the content page
                if ($position == "main") {
                    // if user is given to index.php, load userpage
                    if (isset($_GET['user'])){
                        // if var is set, but empty, show all users
                        if (empty($_GET['user'])){
                            echo "<h2>Alle User anzeigen</h2>";
                            echo \YAWK\user::getUserList($db);
                        }
                        else {
                            // show userpage
                            echo "<h2>Das Profil von $_GET[user] anzeigen...</h2>";
                        }
                    }
                    // if a blog is requested, load blog by given id
                    elseif (isset($_GET['blogid'])) {
                        $blog = new \YAWK\PLUGINS\BLOG\blog();
                        $blog->getFrontendEntries($db, $_GET['blogid'], ''. '', '','');
                        $blog->getFooter($db);
                        $blog->draw();
                        // in any other case, get content for requested static page
                    } else {
                        echo "<div id=\"$position\">";
                        $currentpage->getContent($db);
                        echo "</div>";
                        $main_set = 1;
                    }
                }

                // if position is globalmenu
                if ($position == "globalmenu") {
                    \YAWK\sys::displayGlobalMenu($db);
                    $globalmenu_set = 1;
                }
                // in any other case, simply load a div box onto given position
                if (!$globalmenu_set == 1) {
                    echo "<div id=\"$position\">";
                    echo \YAWK\widget::loadWidgets($db, $position);
                    echo "</div>";
                }
            }
        }

        static function getTemplateSettingsArray($db, $templateID)
        {   /* @var \YAWK\db $db */
            if (!isset($templateID) || (empty($templateID)))
            {   // if no templateID is set, take current template ID from settings db
                $templateID = settings::getSetting($db, "selectedTemplate");
            }
            $array = '';
            $res = $db->query("SELECT property, value
                        	FROM {template_settings}
                            WHERE templateID = $templateID");

            while ($row = mysqli_fetch_assoc($res)){
                $prop = $row['property'];
                $array[$prop] = $row['value'];
            }
            return $array;
        }


    } // ./class template
} // ./namespace