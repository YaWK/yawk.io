<?php
namespace YAWK {
    /**
     * <b>Template controller - get and set template settings.</b>
     *
     * Templates itself are located in /system/templates/ - if you want to modify them, start there.
     * <p><i>Class covers both, backend & frontend functionality.
     * See Methods Summary for Details!</i></p>
     *
     * @package    YAWK
     * @author     Daniel Retzl <danielretzl@gmail.com>
     * @copyright  2009-2015 Daniel Retzl
     * @license    http://www.gnu.org/licenses/gpl-2.0  GNU/GPL 2.0
     * @link       http://yawk.io
     * @annotation The template controller - get and set template settings.
     */
    class template
    {
        /** * @var int template ID */
        public $id;
        /** * @var int 0|1 is this template active? */
        public $active;
        /** * @var string template name */
        public $name;
        /** * @var string positions as string */
        public $positions;
        /** * @var string template description */
        public $description;
        /** * @var string datetime when this template was released */
        public $releaseDate;
        /** * @var string author of this template */
        public $author;
        /** * @var string author's url */
        public $authorUrl;
        /** * @var string weblink to this template */
        public $weblink;
        /** * @var string sub-author who has modified the template */
        public $subAuthor;
        /** * @var string sub-author's url*/
        public $subAuthorUrl;
        /** * @var string datetime when this template was modified */
        public $modifyDate;
        /** * @var string template's version number */
        public $version;
        /** * @var string template's license */
        public $license;
        /** * @var int which template is currently set to active? */
        public $selectedTemplate;
        /** * @var string path to own true type fonts  */
        public $ttfPath = "../system/fonts";


        /**
         * return ID of current (active) template
         * @author Daniel Retzl <danielretzl@gmail.com>
         * @version 1.0.0
         * @link http://yawk.io
         * @param object $db
         * @return int the ID of the currently selected template
         */
        static function getCurrentTemplateId($db)
        {   // return value of property selectedTemplate from settings db
            return \YAWK\settings::getSetting($db, "selectedTemplate");
        }

        /**
         * switch all positions indicators on or off
         * @author Daniel Retzl <danielretzl@gmail.com>
         * @version 1.0.0
         * @link http://yawk.io
         * @param int $templateID ID of the affected template
         * @param int $status value to set (0|1)
         * @param object $db
         * @return bool true|false
         */
        public function switchPositionIndicators($db, $templateID, $status)
        {
            // if template param is not set
            if (!isset($templateID) || (!is_numeric($templateID)))
            {   // get current active template ID
                $templateID = self::getCurrentTemplateId($db);
            }

            // if status parameter is not set
            if (!isset($status) || (!is_numeric($status)))
            {   // turn off is default behaviour
                $status = 0;
            }

            // update position indicator status
            if ($db->query("UPDATE {template_settings} 
                                   SET value = '".$status."'
                                   WHERE property 
                                   LIKE '%indicator%'
                                   AND templateID = '".$templateID."'"))
            {   // all good,
                return true;
            }
            else
                {   // update position indicators failed
                    return false;
                }
        }

        /**
         * fetch positions of current (active) template, explode string and return positions array
         * @author Daniel Retzl <danielretzl@gmail.com>
         * @version 1.0.0
         * @link http://yawk.io
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
                \YAWK\sys::setSyslog($db, 5, "failed to get template positions of template id: <b>$tpl_id</b> ", 0, 0, 0, 0);
                return false;
            }
        }

        /**
         * save a template as new. It copies the tpl folder and all settings into a new one.
         * @author Daniel Retzl <danielretzl@gmail.com>
         * @version 1.0.0
         * @link http://yawk.io
         * @param object $db
         * @param object $template
         * @param string $new_template
         * @param string $description
         * @param string $author
         * @param string $authorUrl
         * @param string $weblink
         * @param string $version
         * @param string $license
         * @return bool
         */
        public function saveAs($db, $newID, $template, $new_template, $description, $author, $authorUrl, $weblink, $version, $license)
        {   /** @var \YAWK\db $db */
            // save theme as new template

            if (!isset($newID) || (empty($newID)))
            {
                $newID = \YAWK\template::getMaxId($db);
            }

            $replace = array("/ä/", "/ü/", "/ö/", "/Ä/", "/Ü/", "/Ö/", "/ß/"); // array of special chars
            $chars = array("ae", "ue", "oe", "Ae", "Ue", "Oe", "ss"); // array of replacement chars
            $new_template = preg_replace($replace, $chars, $new_template);      // replace with preg
            // final check: just numbers and chars are allowed
            $new_template = preg_replace("/[^a-z0-9\-\/]/i", "", $new_template);
            // same goes on for $template->name
            $template->name = preg_replace($replace, $chars, $template->name);  // replace with preg
            // final check: just numbers and chars are allowed
            $template->name = preg_replace("/[^a-z0-9\-\/]/i", "", $template->name);

            $now = \YAWK\sys::now();

            // check if new tpl folder already exists
            if (file_exists("../system/templates/$new_template/"))
            {   // overwrite data
                \YAWK\sys::full_copy("../system/templates/yawk-bootstrap3", "../system/templates/$new_template");
            }
            else
            {   // copy data into new template directory
                \YAWK\sys::full_copy("../system/templates/yawk-bootstrap3", "../system/templates/$new_template");
            }

            if ($res = $db->query("INSERT INTO {templates} (id, name, description, releaseDate, author, authorUrl, weblink, modifyDate, version, license)
  	                               VALUES('" . $newID . "', 
  	                                      '" . $new_template . "', 
  	                                      '" . $description . "',
  	                                      '" . $now . "',
  	                                      '" . $author . "',
  	                                      '" . $authorUrl . "',
  	                                      '" . $weblink . "',
  	                                      '" . $now . "',
  	                                      '" . $version . "',
  	                                      '" . $license . "')"))
            {   // success
                // do something
                // store each setting with new tpl id in database
            }
            else
            {   // q failed, throw error
                \YAWK\sys::setSyslog($db, 5, "failed to save <b>$new_template</b> as new template ", 0, 0, 0, 0);
                \YAWK\alert::draw("warning", "Warning!", "Could not insert your template $new_template into database.", "", 6200);
                return false;
            }
            // all good.
            return true;
        }

        /**
         * load properties into template object
         * @author Daniel Retzl <danielretzl@gmail.com>
         * @version 1.0.0
         * @link http://yawk.io
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
                \YAWK\sys::setSyslog($db, 5, "failed to load properties of template id: <b>$id</b> ", 0, 0, 0, 0);
                \YAWK\alert::draw("danger", "Warning!", "Could not fetch template properties. Expect a buggy view.", "", 3000);
                return false;
            }
        }

        /**
         * save new template properties into database
         * @author Daniel Retzl <danielretzl@gmail.com>
         * @version 1.0.0
         * @link http://yawk.io
         * @param object $db database object
         * @param int $id template id to save
         * @param array $data post data from form (new settings)
         * @return bool true or false
         */
        public function saveProperties($db, $id, $data)
        {
            // check if data is set set
            if (!isset($data) || (!isset($id)))
            {   // if not, abort
                return false;
            }

            // walk through all post data settings
            foreach($data as $property => $value)
            {
                // check, if settings is a long value
                if (fnmatch('*-longValue', $property))
                {   // it is, set long value indicator to true
                    $longValue = 1;
                }
                else
                {   // not a long value
                    $longValue = 0;
                }

                // save this property only if its NOT save or customcss
                if ($property != "save" && $property != "customCSS")
                {
                    // save theme settings to database
                    $this->setTemplateSetting($db, $id, $property, $value, $longValue);
                }
                /*
                // if save property is customCSS
                elseif ($property == "customCSS")
                {   // save the content to /system/template/$NAME/css/custom.css
                    $this->setCustomCssFile($db, $value, 0, $id);
                    // save a minified version to /system/template/$NAME/css/custom.min.css
                    $this->setCustomCssFile($db, $value, 1, $id);
                }
                */
            }
            return true;
        }

        /**
         * return array with all template id's + names.
         * @author Daniel Retzl <danielretzl@gmail.com>
         * @version 1.0.0
         * @link http://yawk.io
         * @param object $db database
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
                \YAWK\sys::setSyslog($db, 5, "failed get template id and name ", 0, 0, 0, 0);
                return false;
            }
        }

        /**
         * count and return how many settings got this: template ID
         * @author Daniel Retzl <danielretzl@gmail.com>
         * @version 1.0.0
         * @link http://yawk.io
         * @param object $db database
         * @param int $templateID affected template ID
         * @return int the number of settings for this template
         */
        static function countTemplateSettings($db, $templateID)
        {   /** @var $db \YAWK\db */
            // count + return settings from given tpl ID
            $res = $db->query("SELECT id FROM {template_settings}
                                        WHERE templateID = '" . $templateID . "'");
            $i_tplsettings = mysqli_num_rows($res);
            return $i_tplsettings;
        }

        /**
         * return template name for given ID
         * @author Daniel Retzl <danielretzl@gmail.com>
         * @version 1.0.0
         * @link http://yawk.io
         * @param object $db database
         * @param int $templateID affected template ID
         * @return string|null
         */
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
                    \YAWK\sys::setSyslog($db, 5, "failed to get template name by id <b>$templateID</b> ", 0, 0, 0, 0);
                    // die ("Please check database connection.");
                }
            return null;
        }

        /**
         * return current active template name
         * @author Daniel Retzl <danielretzl@gmail.com>
         * @version 1.0.0
         * @link http://yawk.io
         * @param object $db database
         * @param string $location frontend or backend
         * @param int $templateID affected template ID
         * @return bool|string
         */
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
                        \YAWK\sys::setSyslog($db, 5, "failed to load template directory of template id: <b>$templateID</b>", 0, 0, 0, 0);
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

        /**
         * get, set and minify template css file
         * @author Daniel Retzl <danielretzl@gmail.com>
         * @version 1.0.0
         * @link http://yawk.io
         * @param object $db database
         * @param int $tplId affected template ID
         * @param string $content contains the css file content
         * @param int $minify 0|1 if 1, file gets minified before saving.
         * @return bool
         */
        public function writeTemplateCssFile($db, $tplId, $content, $minify)
        {   /** @var $db \YAWK\db */
            // check whether templateID is not set or empty
            if (!isset($tplId) || (empty($tplId)))
            {   // set default value: template 1
                $tplId = 1;
            }
            // prepare vars
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
                else
                    {   // failed to minify, insert syslog
                        \YAWK\sys::setSyslog($db, 5, "failed to minify template css <b>$filename</b>", 0, 0, 0, 0);
                    }
            }
            // do all the file stuff, open, write, close and chmod to set permissions.
            $handle = fopen($filename, "wb");

            if (!fwrite($handle, $content))
            {   // write failed, throw error
                \YAWK\sys::setSyslog($db, 5, "failed to write <b>$filename</b>", 0, 0, 0, 0);
                \YAWK\alert::draw("danger", "Error!", "Could not template CSS file $filename<br>Please check your file / owner or group permissions.", "", 4200);
            }
            if (!fclose($handle))
            {   // close failed, throw error
                \YAWK\sys::setSyslog($db, 5, "failed to close <b>$filename</b>", 0, 0, 0, 0);
                \YAWK\alert::draw("warning", "Warning!", "Failed to template CSS file close $filename<br>Please try again and / or expect some errors.", "", 4200);
            }
            if (!chmod($filename, 0775))
            {   // chmod failed, throw error
                \YAWK\sys::setSyslog($db, 5, "failed to chmod 775 to template CSS file <b>$filename</b>", 0, 0, 0, 0);
                \YAWK\alert::draw("warning", "Warning!", "Failed to chmod(775) $filename<br>Please check file / folder / owner / group permissions!", "", 4200);
            }
            // after all....
            return true;
        }

        /**
         * get, set and minify custom.css file
         * @author Daniel Retzl <danielretzl@gmail.com>
         * @version 1.0.0
         * @link http://yawk.io
         * @param object $db database
         * @param string $content contains the css file content
         * @param int $minify 0|1 if 1, the file gets minified before saving.
         * @param int $templateID affected template ID
         * @return bool
         */
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
                else
                    {
                        \YAWK\sys::setSyslog($db, 5, "failed to minify custom css <b>$filename</b>", 0, 0, 0, 0);
                    }
            }
            // do all the file stuff, open, write, close and chmod to set permissions.
            $handle = fopen($filename, "wb");
            //$content = \YAWK\sys::replaceCarriageReturns("\n\r", $content);
            $content = \YAWK\sys::replacePreTags("\n\r", $content);
            if (!fwrite($handle, $content))
            {   // write failed, throw error
                \YAWK\alert::draw("danger", "Error!", "Could not write custom css $filename<br>Please check your file / owner or group permissions.", "", 4200);
            }
            if (!fclose($handle))
            {   // close failed, throw error
                \YAWK\alert::draw("warning", "Warning!", "Failed to close custom css $filename<br>Please try again and / or expect some errors.", "", 4200);
            }
            if (!chmod($filename, 0775))
            {   // chmod failed, throw error
                \YAWK\alert::draw("warning", "Warning!", "Failed to chmod(775) custom css $filename<br>Please check file / folder / owner / group permissions!", "", 4200);
            }
            // after all....
            return true;
        }

        /**
         * return the content of custom.css
         * @author Daniel Retzl <danielretzl@gmail.com>
         * @version 1.0.0
         * @link http://yawk.io
         * @param object $db database
         * @param int $templateID affected template ID
         * @return string the content of custom.css
         */
        public function getCustomCSSFile($db, $templateID)
        {   // get the content from custom.css
            $filename = self::getCustomCSSFilename($db, "backend", $templateID);
            $content = file_get_contents($filename);
            return $content;
        }

        /**
         * return filename of template css file
         * @author Daniel Retzl <danielretzl@gmail.com>
         * @version 1.0.0
         * @link http://yawk.io
         * @param object $db database
         * @param string $location frontend or backend
         * @param int $templateID affected template ID
         * @return string the template's css filename, including path
         */
        public function getSettingsCSSFilename($db, $location, $templateID)
        {   /** @var $db \YAWK\db */
            // prepare vars... path + filename
            if (!isset($templateID) || (empty($templateID)))
            {
                $templateID = self::getCurrentTemplateId($db);
            }
            if (!isset($location) || (empty($location)))
            {
                $location = "Backend";
            }
            $tplName = self::getCurrentTemplateName($db, $location, $templateID); // tpl name
            $alias = "settings"; // set CSS file name
            $filename = "../system/templates/$tplName/css/" . $alias . ".css";
            return $filename;
        }

        /**
         * return filename of custom css file
         * @author Daniel Retzl <danielretzl@gmail.com>
         * @version 1.0.0
         * @link http://yawk.io
         * @param object $db database
         * @param string $location frontend or backend
         * @param int $templateID affected template ID
         * @return string the template's custom css filename, including path
         */
        public function getCustomCSSFilename($db, $location, $templateID)
        {   /** @var $db \YAWK\db */
            // prepare vars... path + filename
            $tplName = self::getCurrentTemplateName($db, $location, $templateID); // tpl name
            $alias = "custom"; // set CSS file name
            $filename = "../system/templates/$tplName/css/" . $alias . ".css";
            return $filename;
        }

        /**
         * return biggest ID from template database
         * @author Daniel Retzl <danielretzl@gmail.com>
         * @version 1.0.0
         * @link http://yawk.io
         * @param object $db database
         * @return int|bool
         */
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
                        \YAWK\sys::setSyslog($db, 5, "failed to get MAX(id) from template db", 0, 0, 0, 0);
                        return false;
                    }
            }
            else
                {
                    return false;
                }
        }

        /** delete template settings css file
         * @author Daniel Retzl <danielretzl@gmail.com>
         * @version 1.0.0
         * @link http://yawk.io
         * @param object $db database
         * @param string $filename the filename (including path) you wish to delete
         * @return bool
         */
        function deleteSettingsCSSFile($db, $filename)
        {   // if no filename is given
            if (!isset($filename) || (empty($filename)))
            {   // set default filename
                $filename = self::getSettingsCSSFilename($db, '', '');
            }
            // we want the settings.css file to be overridden, so check if file exists and delete it if needed.
            if (file_exists($filename))
            {   // if there is a file, delete it.
                if (!unlink($filename))
                {   // delete failed, throw error
                    \YAWK\sys::setSyslog($db, 5, "failed to delete settings css file <b>$filename</b>", 0, 0, 0, 0);
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
                \YAWK\sys::setSyslog($db, 5, "could not delete settings css file because it does not exist.", 0, 0, 0, 0);
                return true;
            }
        }

        /**
         * update (save) template settings
         * @author Daniel Retzl <danielretzl@gmail.com>
         * @version 1.0.0
         * @link http://yawk.io
         * @param object $db database
         * @param int $id affected template ID
         * @param string $property template settings property
         * @param string $value template settings value
         * @return bool
         */
        function setTemplateSetting($db, $id, $property, $value, $longValue)
        {   /** @var $db \YAWK\db */
            $property = $db->quote($property);
            $value = $db->quote($value);
            $longValue = $db->quote($longValue);
            $value = strip_tags($value);
            $longValue = strip_tags($longValue);
            if ($longValue === "1")
            {
                $sql ="SET longValue = '".$value."'";
            }
            else
                {
                    $sql = "SET value = '".$value."'";
                }

            if ($res = $db->query("UPDATE {template_settings}
                                   $sql
                                   WHERE property = '" . $property . "'
                                   AND templateID = '".$id."'"))
            {   // success
                return true;
            }
            else
            {   // q failed
                \YAWK\sys::setSyslog($db, 5, "failed to set template #$id setting <b>$value</b> of <b>$property</b> ", 0, 0, 0, 0);
                return false;
            }
        }


        /**
         * set template active
         * @author Daniel Retzl <danielretzl@gmail.com>
         * @version 1.0.0
         * @link http://yawk.io
         * @param object $db database
         * @param int $templateID affected template ID
         * @return bool
         */
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
                \YAWK\sys::setSyslog($db, 5, "failed to set template #$templateID active ", 0, 0, 0, 0);
                return false;
            }

        }

        /**
         * copy template settings into a new template
         * @author Daniel Retzl <danielretzl@gmail.com>
         * @version 1.0.0
         * @link http://yawk.io
         * @param object $db database
         * @param int $templateID template ID
         * @param int $newID template ID
         */
        public static function copyTemplateSettings($db, $templateID, $newID)
        {   /** @var $db \YAWK\db */

        $res = $db->query("INSERT INTO {template_settings} 
        (templateID, property, value, valueDefault, longValue, type, activated, sort, label, fieldClass, fieldType, 
        options, placeholder, description, icon, heading, subtext)
        SELECT '".$newID."', property, value, valueDefault, longValue, type, activated, sort, label, fieldClass, fieldType, 
        options, placeholder, description, icon, heading, subtext 
        FROM {template_settings} 
        WHERE templateID = '".$templateID."'");

            if (!$res)
            {
                \YAWK\sys::setSyslog($db, 5, "failed to copy template settings of template #$templateID ", 0, 0, 0, 0);
                \YAWK\alert::draw("danger", "Could not copy settings", "please try again.", "", 5000);
            }
            else
            {
                \YAWK\alert::draw("success", "Settings copied", "successful", "", 5000);

                 $update = $db->query("UPDATE {template_settings} SET templateID='".$newID."' WHERE templateID=0");
                 if ($update)
                 {
                     \YAWK\alert::draw("success", "Settings are set-up", "successful", "", 5000);
                 }
                 else
                 {
                     \YAWK\sys::setSyslog($db, 5, "failed to set new template settings of template #$templateID ", 0, 0, 0, 0);
                     \YAWK\alert::draw("warning", "Could not set new template settings", "unable to alter IDs.", "", 5000);
                 }
             }
         }

         /**
          * Add a new template setting to the database.
          * @author Daniel Retzl <danielretzl@gmail.com>
          * @version 1.0.0
          * @link http://yawk.io
          * @param object $db database
          * @param string $property template property
          * @param string $value template value
          * @param string $valueDefault default value
          * @param string $label setting label
          * @param string $fieldclass class for the input field (eg. color or form-control)
          * @param string $placeholder placeholder for the input field
          * @return bool
          */
                // alter IDs
        function addTemplateSetting($db, $property, $value, $valueDefault, $label, $fieldclass, $placeholder)
        {   /** @var $db \YAWK\db  */
            $active = 1;
            $sort = 0;
            $templateID = \YAWK\settings::getSetting($db, "selectedTemplate"); // self::getCurrentTemplateId($db);

            $property = $db->quote($property);
            $value = $db->quote($value);
            $valueDefault = $db->quote($valueDefault);
            $label = $db->quote($label);
            $fieldclass = $db->quote($fieldclass);
            $placeholder = $db->quote($placeholder);
            if ($res = $db->query("INSERT INTO {template_settings} (templateID, property, value, valueDefault, label, activated, sort, fieldClass, placeholder)
                                   VALUES('" . $templateID . "','" . $property . "', '" . $value . "', '" . $valueDefault . "', '" . $label . "', '" . $active . "', '" . $sort . "', '" . $fieldclass . "', '" . $placeholder . "')"))
            {   // success
                return true;
            }
            else
            {   // q failed
                \YAWK\sys::setSyslog($db, 5, "failed to add template setting ", 0, 0, 0, 0);
                return false;
            }
        }

        /**
         * set template details
         * @author Daniel Retzl <danielretzl@gmail.com>
         * @version 1.0.0
         * @link http://yawk.io
         * @param object $db object database
         * @param string $description template description
         * @param string $author author name
         * @param string $authorUrl author URL
         * @param int    $id affected template ID
         * @return bool
         */
        public function setTemplateDetails($db, $description, $author, $authorUrl, $id)
        {    /** @var $db \YAWK\db  */
            if ($res = $db->query("UPDATE {templates} SET description = '".$description."', subAuthor = '".$author."', subAuthorUrl = '".$authorUrl."' WHERE id = '".$id."'"))
            {   // template details updated...
                return true;
            }
            else
                {   // could not save template details
                    \YAWK\sys::setSyslog($db, 5, "failed to set template details", 0, 0, 0, 0);
                    return false;
                }
        }

        /**
         * delete template
         * @author Daniel Retzl <danielretzl@gmail.com>
         * @version 1.0.0
         * @link http://yawk.io
         * @param object $db database
         * @param int $templateID template ID of the template you wish to delete
         * @return bool
         */
        static function deleteTemplate($db, $templateID)
        {   /** @var $db \YAWK\db  */
            if (!isset($templateID) && (empty($templateID)))
            {   // no templateID is set...
                \YAWK\sys::setSyslog($db, 5, "failed to delete template because templateID was missing.", 0, 0, 0, 0);
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
                        \YAWK\sys::setSyslog($db, 5, "failed to delete recursive ../system/templates/$templateFolder", 0, 0, 0, 0);
                        return false;
                    }

                    // delete template from database {templates}
                    if (!$res = $db->query("DELETE FROM {templates} WHERE id = $templateID"))
                    {   // if failed
                        \YAWK\sys::setSyslog($db, 5, "failed to delete template from database ", 0, 0, 0, 0);
                        return false;
                    }
                    else
                        {   // ALTER table and set auto_increment value to prevent errors when deleting + adding new tpl
                            if ($res = $db->query("SELECT MAX(id) FROM {templates}"))
                            {   // get MAX ID
                                $row = mysqli_fetch_row($res);
                                if (!$res = $db->query("ALTER TABLE {templates} AUTO_INCREMENT $row[0]"))
                                {   // could not select auto encrement
                                    \YAWK\sys::setSyslog($db, 5, "failed alter auto increment templates table ", 0, 0, 0, 0);
                                    return false;
                                }
                            }
                        }

                    // delete template settings for requested templateID
                    if (!$res = $db->query("DELETE FROM {template_settings} WHERE templateID = $templateID"))
                    {   // delete settings failed...
                        \YAWK\sys::setSyslog($db, 5, "delete template settings failed ", 0, 0, 0, 0);
                        return false;
                    }
                    else
                        {   // all good so far.
                            return true;
                        }
                }
        }


        /**
         * Returns an array with all template settings.
         * @author Daniel Retzl <danielretzl@gmail.com>
         * @version 1.0.0
         * @link http://yawk.io
         * @param object $db Database Object
         * @return array|bool
         */
        public static function getAllSettingsIntoArray($db, $user) // get all settings from db like property
        {
            // get template settings
            if (isset($user))
            {   // get template settings for this user
                if ($user->overrideTemplate == 1)
                {
                    $sql = "SELECT ts.property, ts.value, ts.longValue, ts.valueDefault, ts.type, ts.label, ts.sort, ts.fieldClass, ts.fieldType, ts.placeholder, ts.description, ts.options, ts.activated, ts.icon, ts.heading, ts.subtext
                                       FROM {template_settings} ts
                                       JOIN {users} u on u.templateID = ts.templateID
                                       WHERE ts.activated = 1 && u.id = $user->id
                                       ORDER BY ts.sort";
                }
                else
                {
                    $sql = "SELECT ts.property, ts.value, ts.longValue, ts.valueDefault, ts.type, ts.label, ts.sort, ts.fieldClass, ts.fieldType, ts.placeholder, ts.description, ts.options, ts.activated, ts.icon, ts.heading, ts.subtext
                                       FROM {template_settings} ts
                                       JOIN {settings} s on s.value = ts.templateID
                                       WHERE ts.activated = 1 && s.property = 'selectedTemplate'
                                       ORDER BY ts.sort";
                }
            }
            else
            {
                \YAWK\sys::setSyslog($db, 5, "BACKEND: failed to get template setting - user is not set or empty.", 0, 0, 0, 0);
                return false;
            }

            /* @var $db \YAWK\db */
           // if ($res= $db->query("SELECT * FROM {template_settings} ORDER by property"))
            if ($res = $db->query($sql))
            {
                $settingsArray = array();
                while ($row = $res->fetch_assoc())
                {   // fill array
                    $settingsArray[$row['property']] = $row;
                }
            }
            else
            {   // q failed, throw error
                \YAWK\sys::setSyslog($db, 5, "get template settings failed.", 0, 0, 0, 0);
                // \YAWK\alert::draw("warning", "Warning!", "Fetch database error: getSettingsArray failed.","","4800");
                return false;
            }

            // check if array has been generated
            if (is_array($settingsArray) && (!empty($settingsArray)))
            {   // all good -
                return $settingsArray;
            }
            else
                {   // error generating settings array -
                    return false;
                }
        }

        /**
         * return div box with postition settings
         * @author Daniel Retzl <danielretzl@gmail.com>
         * @version 1.0.0
         * @link http://yawk.io
         * @param object $db Database object
         * @param string $position The position to load
         * @param array $positions Positions [enabled] status array
         * @param array $indicators Positions [indicator] status array
         */
        public static function getPositionDivBox($db, $position, $row, $bootstrapGrid, $positions, $indicators)
        {
            if (isset($row) && (!empty($row)))
            {
                if ($row === "1")
                {
                    $startRow = "<div class=\"row\">";
                    $endRow = "</div>";
                }
                else
                    {
                        $startRow = '';
                        $endRow = '';
                    }
            }
            else
                {
                    $startRow = '';
                    $endRow = '';
                }
            // check if position is enabled
            if ($positions["pos-$position-enabled"] === "1")
            {   // check if position indicator is enabled
                if ($indicators["pos-$position-indicator"] === "1")
                {   // display position indicator
                    $indicatorStyle = "style=\"border: 2px solid red;\"";
                    $indicatorText = "<i><b>$position</b></i>";
                }
                else
                {   // no position indicator set
                    $indicatorStyle = '';
                    $indicatorText = '';
                }
                // output position div box
                echo "$startRow";
                echo "<div class=\"$bootstrapGrid pos-$position\" id=\"$position\" $indicatorStyle>$indicatorText";
                      \YAWK\template::setPosition($db, "$position-pos");
                echo "</div>";
                echo "$endRow";
            }
        }


        /**
         * return html form field, depending on fieldClass
         * @author Daniel Retzl <danielretzl@gmail.com>
         * @version 1.0.0
         * @link http://yawk.io
         * @param object $db Database Object
         */
        public function getFormElements($db, $settings, $type, $lang, $user)
        {   // loop trough array
            // removed not needed checkup
            if(!isset($type) && (empty($type)))
            {	// if param 'type' is missing, set type 1 as default
                $type = 1;
            }
            // loop trough settings array
            foreach ($settings as $setting)
            {
                // field type not set or empty
                if (!isset($setting['fieldType']) && (empty($fieldType)))
                {   // set input field as common default
                    $setting['fieldType'] = "input";
                }
                else
                {   // settings type must be equal to param $type
                    // equals settings category
                    if ($setting['type'] === "$type" && ($setting['activated'] === "1"))
                    {
                        // check if ICON is set
                        // if an icon is set, it will be drawn before the heading, to the left.
                        if (isset($setting['icon']) && (!empty($setting['icon'])))
                        {   // fill it w icon
                            $setting['icon'] = "<i class=\"$setting[icon]\"></i>";
                        }
                        else
                        {   // leave empty - no icon available
                            $setting['icon'] = '';
                        }

                        // check if LABEL is set
                        // The label sits directly above, relative to the setting form element
                        if (isset($setting['label']) && (!empty($setting['label'])))
                        {   // if its set, put it into $lang array for L11n
                            $setting['label'] = $lang[$setting['label']];
                        }
                        else
                        {   // otherwise throw error
                            $setting['label'] = 'sorry, there is not label set. meh!';
                        }

                        // check if HEADING is set
                        // if set, a <H3>Heading</H3> will be shown above the setting
                        if (isset($setting['heading']) && (!empty($setting['heading'])))
                        {   // L11n
                            $setting['heading'] = $lang[$setting['heading']];
                        }
                        else
                        {   // leave empty - no heading for that setting
                            $setting['heading'] = '';
                        }

                        // check if SUBTEXT is set
                        // this is shown in <small>tags</small> beneath the heading
                        if (isset($setting['subtext']) && (!empty($setting['subtext'])))
                        {   // L11n
                            $setting['subtext'] = $lang[$setting['subtext']];
                        }
                        else
                        {   // leave empty - no subtext beneath the heading
                            $setting['subtext'] = '';
                        }

                        // check if description is set
                        // the description will be shown underneath the form element
                        if (isset($setting['description']) && (!empty($setting['description'])))
                        {   // L11n
                            $setting['description'] = $lang[$setting['description']];
                        }
                        else
                        {   // leave empty - no description available
                            $setting['description'] = '';
                        }

                        /* SELECT FIELD */
                        if ($setting['fieldType'] === "select")
                        {   // display icon, heading and subtext, if its set
                            if (!empty($setting['icon']) || (!empty($setting['heading']) || (!empty($setting['subtext']))))
                            {
                                echo "<br><h4 class=\"box-title\">$setting[icon]&nbsp;$setting[heading]&nbsp;<small>$setting[subtext]</small></h4>";
                            }
                            // begin draw select
                            echo "<label for=\"$setting[property]\">$setting[label]
                                  <small><i class=\"small\" style=\"font-weight:normal\">$lang[DEFAULT]: $setting[valueDefault]</i></small></label>
                                  <select class=\"form-control\" id=\"$setting[property]\" name=\"$setting[property]\">";
                                echo "<option value=\"$setting[value]\">$lang[SETTING_CURRENT] $setting[value]</option>";
                                // explode option string into array
                                $optionValues = explode(":", $setting['options']);
                                foreach ($optionValues as $value)
                                {
                                    // extract value from option setting string
                                    // $optionValue = preg_replace("/,[a-zA-Z0-9]*/", "", $value);
                                    // extract description from option setting
                                    $optionDesc = preg_replace('/.*,(.*)/','$1', $value);
                                    $optionValue = preg_split("/,[a-zA-Z0-9]*/", $value);

                                    echo "<option value=\"$optionValue[0]\">$optionDesc</option>";
                                }
                                echo "</select>";
                                echo "<p>$setting[description]</p>";
                        }

                        /* RADIO BUTTTONS */
                        else if ($setting['fieldType'] === "radio")
                        {
                            if (!empty($setting['icon']) || (!empty($setting['heading']) || (!empty($setting['subtext']))))
                            {
                                echo "<br><h4 class=\"box-title\">$setting[icon]&nbsp;$setting[heading]&nbsp;<small>$setting[subtext]</small></h4>";
                            }
                            echo "<label for=\"$setting[property]\">$setting[label]</label>
                                  <input type=\"radio\" id=\"$setting[property]\" name=\"$setting[property]\">";
                            echo "<input type=\"radio\" value=\"$setting[value]\">$lang[SETTING_CURRENT] $setting[value]</option>";
                            // explode option string into array
                            $optionValues = explode(":", $setting['options']);
                            foreach ($optionValues as $value)
                            {
                                // extract value from option setting string
                                $optionValue = preg_replace("/,[a-zA-Z0-9]*/", "", $value);
                                // extract description from option setting
                                $optionDesc = preg_replace('/.*,(.*)/','$1',$value);

                                echo "<option value=\"$optionValue\">$optionDesc</option>";
                            }
                            echo "</select>";
                            echo "<p>$setting[description]</p>";
                        }

                        // CHECKBOX
                        else if ($setting['fieldType'] === "checkbox")
                        {    // build a checkbox
                            if ($setting['value'] === "1")
                            {   // set checkbox to checked
                                $checked = "checked";
                            }
                            else
                            {   // checkbox not checked
                                $checked = "";
                            }
                            if (!empty($setting['icon']) || (!empty($setting['heading']) || (!empty($setting['subtext']))))
                            {
                                echo "<br><h4 class=\"box-title\">$setting[icon]&nbsp;$setting[heading]&nbsp;<small>$setting[subtext]</small></h4>";
                            }
                            echo "<input type=\"hidden\" name=\"$setting[property]\" value=\"0\">
                              <input type=\"checkbox\" id=\"$setting[property]\" name=\"$setting[property]\" value=\"1\" $checked>
                              <label for=\"$setting[property]\">&nbsp; $setting[label]</label><p>$setting[description]</p>";
                        }

                        // CHECKBOX as toggle switch
                        else if ($setting['fieldType'] === "checkbox toggle")
                        {    // build a checkbox
                            if ($setting['value'] === "1")
                            {   // set checkbox to checked
                                $checked = "checked";
                            }
                            else
                            {   // checkbox not checked
                                $checked = "";
                            }
                            if (!empty($setting['icon']) || (!empty($setting['heading']) || (!empty($setting['subtext']))))
                            {
                                echo "<br><h4 class=\"box-title\">$setting[icon]&nbsp;$setting[heading]&nbsp;<small>$setting[subtext]</small></h4>";
                            }
                            echo "<input type=\"hidden\" name=\"$setting[property]\" value=\"0\">
                              <input type=\"checkbox\" data-on=\"$lang[ON_]\" data-off=\"$lang[OFF_]\" data-toggle=\"toggle\" data-onstyle=\"success\" data-offstyle=\"danger\" id=\"$setting[property]\" name=\"$setting[property]\" value=\"1\" $checked>
                              <label for=\"$setting[property]\">&nbsp; $setting[label]</label><p>$setting[description]</p>";
                        }

                        /* TEXTAREA */
                        else if ($setting['fieldType'] === "textarea")
                        {    // if a long value is set
                            $placeholder = $setting['placeholder'];     // store placeholder from array in var to use it at language array
                            if (isset($setting['longValue']) && (!empty($setting['longValue'])))
                            {   // build a longValue tagged textarea and fill with longValue
                                $setting['longValue'] = nl2br($setting['longValue']);
                                if (!empty($setting['icon']) || (!empty($setting['heading']) || (!empty($setting['subtext']))))
                                {
                                    echo "<h4 class=\"box-title\">$setting[icon]&nbsp;$setting[heading]&nbsp;<small>$setting[subtext]</small></h4>";
                                }
                                echo "<label for=\"$setting[property]\">$setting[label]</label>
                                      <textarea cols=\"64\" rows=\"4\" class=\"$setting[fieldClass]\" placeholder=\"$lang[$placeholder]\" id=\"$setting[property]\" name=\"$setting[property]\">$setting[longValue]</textarea>";
                                echo "<p>$setting[description]</p>";
                            }
                            else
                            {   // draw default textarea
                                $setting['value'] = nl2br($setting['value']);
                                if (!empty($setting['icon']) || (!empty($setting['heading']) || (!empty($setting['subtext']))))
                                {
                                    echo "<br><h4 class=\"box-title\">$setting[icon]&nbsp;$setting[heading]&nbsp;<small>$setting[subtext]</small></h4>";
                                }
                                echo "<label for=\"$setting[property]-long\">$setting[label]</label>
                                      <textarea cols=\"64\" rows=\"4\" class=\"$setting[fieldClass]\" placeholder=\"$lang[$placeholder]\" id=\"$setting[property]\" name=\"$setting[property]\">$setting[value]</textarea>";
                                echo "<p>$setting[description]</p>";
                            }
                        }

                        /* INPUT PASSWORD FIELD */
                        else if ($setting['fieldType'] === "password")
                        {    // draw an input field
                            $placeholder = $setting['placeholder'];     // store placeholder from array in var to use it at language array
                            if (!empty($setting['icon']) || (!empty($setting['heading']) || (!empty($setting['subtext']))))
                            {
                                echo "<br><h4 class=\"box-title\">$setting[icon]&nbsp;$setting[heading]&nbsp;<small>$setting[subtext]</small></h4>";
                            }
                            echo "<label for=\"$setting[property]\">$setting[label]</label>
                                  <input type=\"password\" class=\"$setting[fieldClass]\" id=\"$setting[property]\" name=\"$setting[property]\" 
										 value=\"$setting[value]\" placeholder=\"$lang[$placeholder]\"><p>$setting[description]</p>";
                        }

                        /* INPUT TEXT FIELD */
                        else if ($setting['fieldType'] === "input")
                        {   // draw an input field
                            $placeholder = $setting['placeholder'];     // store placeholder from array in var to use it at language array
                            if (!empty($setting['icon']) || (!empty($setting['heading']) || (!empty($setting['subtext']))))
                            {
                                echo "<br><h4 class=\"box-title\">$setting[icon]&nbsp;$setting[heading]&nbsp;<small>$setting[subtext]</small></h4>";
                            }
                            echo "<label for=\"$setting[property]\">$setting[label]
                                  <small><i class=\"small\" style=\"font-weight:normal\">$lang[DEFAULT]: $setting[valueDefault]</i></small></label>
                                  <input type=\"text\" class=\"$setting[fieldClass]\" id=\"$setting[property]\" name=\"$setting[property]\" 
										 value=\"$setting[value]\" placeholder=\"$lang[$placeholder]\"><p>$setting[description]</p>";
                        }

                        /* COLOR TEXT FIELD */
                        else if ($setting['fieldType'] === "color")
                        {    // draw a color input field
                            $placeholder = $setting['placeholder'];     // store placeholder from array in var to use it at language array
                            if (!empty($setting['icon']) || (!empty($setting['heading']) || (!empty($setting['subtext']))))
                            {
                                echo "<br><h4 class=\"box-title\">$setting[icon]&nbsp;$setting[heading]&nbsp;<small>$setting[subtext]</small></h4>";
                            }
                            echo "<label for=\"$setting[property]\">$setting[label]
                                  <small><i class=\"small\" style=\"font-weight:normal\">$lang[DEFAULT]: $setting[valueDefault]</i></small></label>
                                  <input type=\"text\" class=\"$setting[fieldClass]\" id=\"$setting[property]\" name=\"$setting[property]\" 
										 value=\"$setting[value]\" placeholder=\"$lang[$placeholder]\"><p>$setting[description]</p>";
                        }
                        else
                        {    // draw an input field
                            $placeholder = $setting['placeholder'];     // store placeholder from array in var to use it at language array
                            if (!empty($setting['icon']) || (!empty($setting['heading']) || (!empty($setting['subtext']))))
                            {
                                echo "<br><h4 class=\"box-title\">$setting[icon]&nbsp;$setting[heading]&nbsp;<small>$setting[subtext]</small></h4>";
                            }
                            echo "<label for=\"$setting[property]\">$setting[label]
                                  <small><i class=\"small\" style=\"font-weight:normal\">$lang[DEFAULT]: $setting[valueDefault]</i></small></label>
                                  <input type=\"text\" class=\"$setting[fieldClass]\" id=\"$setting[property]\" name=\"$setting[property]\" 
										 value=\"$setting[value]\" placeholder=\"$lang[$placeholder]\"><p>$setting[description]</p>";

                         }

                        }
                    }
                }
            }


        /**
         * return font edit row including preview
         *
         * @param string $fontRow name and id properties of the font row eg. h1
         * @author Daniel Retzl <danielretzl@gmail.com>
         * @version 1.0.0
         * @link http://yawk.io
         * @param object $db database
         * @param array  $lang language array
         * @param string $fontRow the prefix of the font group to edit (eg. h1, h2, h3, globaltext...)
         * @param string $previewClass css class you want to use on the preview
         * @param array  $templateSettings all template settings as an array
         *
         */
        public function getFontRow($db, $lang, $fontRow, $previewClass, $templateSettings)
        {
            // prepare vars
            $fontRowSize = "$fontRow-size";
            $fontRowColor = "$fontRow-fontcolor";
            $fontRowFontfamily = "$fontRow-fontfamily";
            $fontRowFontShadowSize = "$fontRow-fontshadowsize";
            $fontRowFontShadowColor = "$fontRow-fontshadowcolor";
            $fontRowFontWeight = "$fontRow-fontweight";
            $fontRowFontStyle = "$fontRow-fontstyle";
            $fontRowTextdecoration = "$fontRow-textdecoration";
            $fontRowALinkColor = "$fontRow-alink";
            $fontRowAHoverColor = "$fontRow-ahover";
            $fontRowAVisitedColor = "$fontRow-avisited";
            $fontRowLinkFontWeight = "$fontRow-linkfontweight";
            $fontRowLinkFontStyle = "$fontRow-linkfontstyle";
            $fontRowLinkTextDecoration = "$fontRow-linktextdecoration";
            $fontRowHoverTextDecoration = "$fontRow-hovertextdecoration";
            $fontRowSmallColor = "$fontRow-smallcolor";
            $fontRowSmallShadowSize = "$fontRow-smallshadowsize";
            $fontRowSmallShadowColor = "$fontRow-smallshadowcolor";

            if ($fontRow === "globaltext" xor ($fontRow === "menufont"))
            {
                $col = 4;
            }
            else { $col = 2; }

            $FONT_ROW = strtoupper($fontRow);
            $labelFontSize = "TPL_".$FONT_ROW."_SIZE";
            $labelFontColor = "TPL_".$FONT_ROW."_COLOR";
            $labelSmallColor = "TPL_".$FONT_ROW."_SMALLCOLOR";


            // check if description is set
            // the description will be shown right beside the label as small info icon
            if (isset($templateSettings[$fontRowFontfamily]['description']) && (!empty($templateSettings[$fontRowFontfamily]['description'])))
            {   // L11n
                $fontRowFamilyDesc = $lang[$templateSettings[$fontRowFontfamily]['description']];
                $fontRowFamilyInfoBtn = "&nbsp;<small><i class=\"fa fa-question-circle-o text-info\" data-placement=\"auto right\" data-toggle=\"tooltip\" title=\"$fontRowFamilyDesc\"></i></small>";
            }
            else
                {
                    $fontRowFamilyInfoBtn = '';
                }
            // check if font family default value is set
            if (isset($templateSettings[$fontRowFontfamily]['valueDefault']) && (!empty($templateSettings[$fontRowFontfamily]['valueDefault'])))
            {   // default values:
                $fontRowFamilyDefault = "<i class=\"h6 small\">default: ".$templateSettings[$fontRowFontfamily]['valueDefault']."</i>";
            }
            else
                {
                    $fontRowFamilyDefault = '';
                }

            // check if font size is set
            if (isset($templateSettings[$fontRowSize]['valueDefault']) && (!empty($templateSettings[$fontRowSize]['valueDefault'])))
            {   // default values:
                $fontRowSizeDefault = "<i class=\"h6 small\">(".$templateSettings[$fontRowSize]['valueDefault'].")</i>";
            }
            else
            {
                $fontRowSizeDefault = '';
            }

            $html = "
                <div class=\"col-md-$col\">
                    <div class=\"$previewClass\" id=\"$fontRow-preview\" style=\"height: auto; overflow:hidden; font-size: ".$templateSettings[$fontRowSize]['value']."; color: #".$templateSettings[$fontRowColor]['value'].";\">$fontRow Heading</div>
               
                    <label for=\"$fontRowFontfamily\">$FONT_ROW $lang[TPL_FONTFAMILY] $fontRowFamilyInfoBtn</label>";
            $html .= $this->drawFontFamilySelectField($db, $lang, "$fontRowFontfamily", $templateSettings[$fontRowFontfamily]['value']);
            $html .= "
                
                    <label for=\"$fontRowSize\">$lang[$labelFontSize] $fontRowSizeDefault</label>
                    <input id=\"$fontRowSize\" name=\"$fontRowSize\" value=\"".$templateSettings[$fontRowSize]['value']."\" class=\"form-control\">
                
                    <label for=\"$fontRowColor\">$lang[$labelFontColor]</label>
                    <input id=\"$fontRowColor\" name=\"$fontRowColor\" class=\"form-control color\" value=\"".$templateSettings[$fontRowColor]['value']."\">
               
                    <label for=\"$fontRowFontShadowSize\">$lang[TPL_FONTSHADOWSIZE]</label>
                    <input id=\"$fontRowFontShadowSize\" name=\"$fontRowFontShadowSize\" class=\"form-control\" value=\"".$templateSettings[$fontRowFontShadowSize]['value']."\" placeholder=\"2px 2px\">
                
                    <label for=\"$fontRowFontShadowColor\">$lang[TPL_FONTSHADOWCOLOR]</label>
                    <input id=\"$fontRowFontShadowColor\" name=\"$fontRowFontShadowColor\" value=\"".$templateSettings[$fontRowFontShadowColor]['value']."\" class=\"form-control color\">
                
                    <label for=\"$fontRowFontWeight\">$lang[TPL_FONTWEIGHT]</label>
                    <select id=\"$fontRowFontWeight\" name=\"$fontRowFontWeight\" class=\"form-control\">";

            $fontweightStyles = array("normal", "bold", "bolder", "lighter", "100", "200", "300", "400 [normal]", "500", "600", "700 [bold]", "800", "900", "initial", "inherit");
            foreach ($fontweightStyles as $weight)
            {
                $currentFontWeight = "$fontRow-fontweight";
                if ($weight === $templateSettings[$currentFontWeight]['value'])
                {
                    $selected = "selected aria-selected=\"true\"";
                }
                else
                {
                    $selected = '';
                }
                $html .= "<option value=\"$weight\" $selected>$weight</option>";
            }
            $html .= "</select>
                
                    <label for=\"$fontRowFontStyle\">$lang[TPL_FONTSTYLE]</label>
                    <select id=\"$fontRowFontStyle\" name=\"$fontRowFontStyle\" class=\"form-control\">";

            $fontStyles = array("normal", "italic", "oblique", "initial", "inherit");
            foreach ($fontStyles as $style)
            {
                $currentFontStyle = "$fontRow-fontstyle";
                if ($style === $templateSettings[$currentFontStyle]['value'])
                {
                    $selected = "selected aria-selected=\"true\"";
                }
                else
                {
                    $selected = '';
                }
                $html .= "<option value=\"$style\" $selected>$style</option>";
            }

            $html .="</select>
                
                    <label for=\"$fontRowTextdecoration\">$lang[TPL_TEXTDECORATION]</label>
                    <select id=\"$fontRowTextdecoration\" name=\"$fontRowTextdecoration\" class=\"form-control\">";

            $textdecorationTypes = array("none", "underline", "overline", "line-through", "intial", "inherit");
            foreach ($textdecorationTypes as $decoration)
            {
                $currentFontDecoration = "$fontRow-textdecoration";
                if ($decoration === $templateSettings[$currentFontDecoration]['value'])
                {
                    $selected = "selected aria-selected=\"true\"";
                }
                else
                {
                    $selected = '';
                }
                $html .= "<option value=\"$decoration\" $selected>$decoration</option>";
            }
            $html .= "</select>";

            // LINK SETTINGS START HERE
              $html .= "

                    <label for=\"$fontRowLinkTextDecoration\">$lang[TPL_LINK_TEXTDECORATION]</label>
                    <select id=\"$fontRowLinkTextDecoration\" name=\"$fontRowLinkTextDecoration\" class=\"form-control\">";

            foreach ($textdecorationTypes as $decoration)
            {
                $currentLinkTextDecoration = "$fontRow-linktextdecoration";
                if ($decoration === $templateSettings[$currentLinkTextDecoration]['value'])
                {
                    $selected = "selected aria-selected=\"true\"";
                }
                else
                {
                    $selected = '';
                }
                $html .= "<option value=\"$decoration\" $selected>$decoration</option>";
            }
            $html .= "</select>
                        <label for=\"$fontRow-alink\">$lang[TPL_LINK_COLOR]</label>
                        <input id=\"$fontRow-alink\" name=\"$fontRow-alink\" value=\"".$templateSettings[$fontRowALinkColor]['value']."\" class=\"form-control color\">
                   
                        <label for=\"$fontRow-avisited\">$lang[TPL_LINK_VISITED_COLOR]</label>
                        <input id=\"$fontRow-avisited\" name=\"$fontRow-avisited\" value=\"".$templateSettings[$fontRowAVisitedColor]['value']."\" class=\"form-control color\"> 
                    
                        <label for=\"$fontRow-ahover\">$lang[TPL_LINK_HOVER_COLOR]</label>
                        <input id=\"$fontRow-ahover\" name=\"$fontRow-ahover\" value=\"".$templateSettings[$fontRowAHoverColor]['value']."\" class=\"form-control color\"> 
                   
                    <label for=\"$fontRowLinkFontWeight\">$lang[TPL_LINK_TEXTDECORATION]</label>
                        <select id=\"$fontRowLinkFontWeight\" name=\"$fontRowLinkFontWeight\" class=\"form-control\">";

            foreach ($fontweightStyles as $weight)
            {
                $currentLinkFontWeight = "$fontRow-linkfontweight";
                if ($weight === $templateSettings[$currentLinkFontWeight]['value'])
                {
                    $selected = "selected aria-selected=\"true\"";
                }
                else
                {
                    $selected = '';
                }
                $html .= "<option value=\"$weight\" $selected>$weight</option>";
            }
            $html .= "</select>
               
                    <label for=\"$fontRowLinkFontStyle\">$lang[TPL_LINK_FONTSTYLE]</label>
                    <select id=\"$fontRowLinkFontStyle\" name=\"$fontRowLinkFontStyle\" class=\"form-control\">";

            foreach ($fontStyles as $style)
            {
                $currentLinkFontStyle = "$fontRow-linkfontstyle";
                if ($style === $templateSettings[$currentLinkFontStyle]['value'])
                {
                    $selected = "selected aria-selected=\"true\"";
                }
                else
                {
                    $selected = '';
                }
                $html .= "<option value=\"$style\" $selected>$style</option>";
            }

            $html .="</select>
                    <label for=\"$fontRowHoverTextDecoration\">$lang[TPL_HOVER_TEXTDECORATION]</label>
                    <select id=\"$fontRowHoverTextDecoration\" name=\"$fontRowHoverTextDecoration\" class=\"form-control\">";

            foreach ($textdecorationTypes as $decoration)
            {
                $currentFontDecoration = "$fontRow-hovertextdecoration";
                if ($decoration === $templateSettings[$currentFontDecoration]['value'])
                {
                    $selected = "selected aria-selected=\"true\"";
                }
                else
                {
                    $selected = '';
                }
                $html .= "<option value=\"$decoration\" $selected>$decoration</option>";
            }
            $html .= "</select>";


            // SMALL TAG COLOR
            $html .= "<label for=\"$fontRowSmallColor\">$lang[TPL_SMALLCOLOR]</label>
                    <input id=\"$fontRowSmallColor\" name=\"$fontRowSmallColor\" class=\"form-control color\" value=\"".$templateSettings[$fontRowSmallColor]['value']."\">";

            // SMALL TAG SHADOW SIZE
            $html .= "<label for=\"$fontRowSmallShadowSize\">$lang[TPL_SMALLSHADOWSIZE]</label>
                    <input id=\"$fontRowSmallShadowSize\" name=\"$fontRowSmallShadowSize\" class=\"form-control\" value=\"".$templateSettings[$fontRowSmallShadowSize]['value']."\" placeholder=\"2px 2px\">";
            // SMALL TAG SHADOW COLOR
            $html .= "<label for=\"$fontRowSmallShadowColor\">$lang[TPL_SMALLSHADOWCOLOR]</label>
                    <input id=\"$fontRowSmallShadowColor\" name=\"$fontRowSmallShadowColor\" value=\"".$templateSettings[$fontRowSmallShadowColor]['value']."\" class=\"form-control color\">";

            // end font div box
            $html .="
            </div>";

            echo $html;

        }
        /**
         * get setting from database and draw input field
         * @author Daniel Retzl <danielretzl@gmail.com>
         * @version 1.0.0
         * @link http://yawk.io
         * @param object $db database
         * @param string $filter filter the search result (eg. all field w %-color)
         * @param string $special could be a slider *OUTDATED
         * @param string $readonly "readonly" if the field should be this way
         * @param object $user the current user object
         * @return bool
         */
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
                    $sql = "SELECT ts.property, ts.value, ts.longValue, ts.valueDefault, ts.label, ts.fieldClass, ts.placeholder
                                       FROM {template_settings} ts
                                       JOIN {users} u on u.templateID = ts.templateID
                                       WHERE ts.activated = 1 && u.id = $user->id && ts.property
                                       LIKE '$filter' && ts.property NOT RLIKE '.*-pos' $sql ORDER BY ts.sort";
                }
                else
                    {
                        $sql = "SELECT ts.property, ts.value, ts.longValue, ts.valueDefault, ts.label, ts.fieldClass, ts.placeholder
                                       FROM {template_settings} ts
                                       JOIN {settings} s on s.value = ts.templateID
                                       WHERE ts.activated = 1 && s.property = 'selectedTemplate' && ts.property
                                       LIKE '$filter' && ts.property NOT RLIKE '.*-pos' $sql ORDER BY ts.sort";
                    }
            }
            else
                {
                    \YAWK\sys::setSyslog($db, 5, "BACKEND: failed to get template setting - user is not set or empty.", 0, 0, 0, 0);
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
                    if (fnmatch('*-longValue', $filter)) {
                        // draw a textfield
                        echo "<label for=\"".$row['property']."\"><small>" . $row['label'] . " <i class=\"h6 small\">default: ".$row['valueDefault']."</i></small></label><br>";
                        echo "<div style=\"display:inline-block; width:90%;\"><label for=\"" . htmlentities($row['property']) . "\">";
                        echo "<input type=\"hidden\" name=\"$row[property]-long\" id=\"longValue\" value=\"1\">";
                        echo "<textarea cols=\"85\" rows=\"12\" id=\"".$row['property']."\" $readonly class=\"form-control\" style=\"font-weight:normal;\" name=\"" . htmlentities($row['property']) . "\">".$row['longValue']."</textarea>";
                    }
                    else
                    {   // draw a textfield
                        echo "<label for=\"".$row['property']."\"><small>" . $row['label'] . " <i class=\"h6 small\">default: ".$row['valueDefault']."</i></small></label><br>";
                        echo "<div style=\"display:inline-block; \">";
                        echo "<input id=\"";
                        echo $row['property'];
                        echo "\" placeholder=\"";
                        echo $row['placeholder'];
                        echo "\" class=\"form-control ";
                        echo $row['fieldClass'];
                        echo "\" type=\"text\" size=\"88\" maxlength=\"255\"";
                        echo $readonly;
                        echo "name=\"" . htmlentities($row['property']) . "\" value=\"" . htmlentities($row['value']) . "\" /><br>";
                    }

                    if ($special == "slider")
                    {   // set slider html
                        // if method is called with slider parameter, draw one with given property name
                        echo "<div id=\"slider-";
                        echo $row['property'];
                        echo "\"></div>";
                    }
                    echo "</div></label>";
                }
            }
            else
            {   // q failed
                \YAWK\sys::setSyslog($db, 5, "failed to get template setting ", 0, 0, 0, 0);
                return false;
            }
            // all good, fin
            return true;
        }

        /* END FUNCTION YAWK\settings::getSetting */

        /**
         * return a select option list with all fonts:
         * <ul>
         * <li>system default fonts</li>
         * <li>own true type fonts from system/fonts</li>
         * <li>google fonts from database: gfonts</li>
         * </ul>
         * @author Daniel Retzl <danielretzl@gmail.com>
         * @version 1.0.0
         * @link http://yawk.io
         * @param object $db database
         * @param string $selectName selectName
         * @param array $lang language array
         */
        public function drawFontFamilySelectField($db, $lang, $selectName, $defaultValue)
        {
            if (isset($defaultValue) && (!empty($defaultValue)))
            {
                $defaultValueOption = "<option value=\"$defaultValue\" selected aria-selected=\"true\">$defaultValue</option>";
            }
            else
                {
                    $defaultValueOption = '';
                }
            $selectField = ''; // init var to hold select field html code
            $selectField =
                "
                        <select id=\"$selectName\" name=\"$selectName\" class=\"form-control\">
                            $defaultValueOption;
                            <optgroup label=\"System Sans-Serif Fonts\"></optgroup>
                                <option value=\"Arial, Helvetica, sans-serif\">&nbsp;&nbsp;Arial, Helvetica, sans-serif</option>
                                <option value=\"Arial Black\">&nbsp;&nbsp;Arial Black</option>
                                <option value=\"Comic Sans MS, cursive, sans-serif\">&nbsp;&nbsp;Comic Sans</option>
                                <option value=\"Impact, Charcoal, sans-serif\">&nbsp;&nbsp;Impact, Charcoal, sans-serif</option>
                                <option value=\"Lucida Sans Unicode, Lucida Grande, sans-serif\">&nbsp;&nbsp;Lucida Sans Unicode, Lucida Grande, sans-serif</option>
                                <option value=\"Tahoma, Geneva, sans-serif\">&nbsp;&nbsp;Tahoma, Geneva, sans-serif</option>
                                <option value=\"Trebuchet MS, Helvetica, sans-serif\">&nbsp;&nbsp;Trebuchet MS, Helvetica, sans-serif</option>
                                <option value=\"Verdana, Geneava, sans-serif\">&nbsp;&nbsp;Verdana, Geneava, sans-serif</option>
                            <optgroup label=\"System Serif Fonts\"></optgroup>
                                <option value=\"Georgia, serif\">&nbsp;&nbsp;Georgia, serif</option>
                                <option value=\"Palatino Linotype, Book Antiqua, Palatino, serif\">&nbsp;&nbsp;Palatino Linotype, Book Antiqua, Palatino, serif</option>
                                <option value=\"Times New Roman, Times, serif\">&nbsp;&nbsp;Times New Roman, Times, serif</option>
                            <optgroup label=\"System Monospace Fonts\"></optgroup>
                                <option value=\"Courier New, Courier, monospace\">&nbsp;&nbsp;Courier New, Courier, monospace</option>
                                <option value=\"Lucida Console, Monaco, monospace\">&nbsp;&nbsp;Lucida Console, Monaco, monospace</option>";

            // directory iterator walks trough system/fonts
            // and build up 3 arrays: ttf fonts, otf fonts and woff fonts
            // afterwards they get processed and drawn
            $dir = new \DirectoryIterator($this->ttfPath);
            $ttfFonts = array();    // all .ttf files
            $otfFonts = array();    // all .otf files
            $woffFonts = array();   // all .woff files

            foreach ($dir as $item)
            {
                if (!$item->isDot()
                    && (!$item->isDir()))
                {
                    // workaround: todo what about filenames with spaces?
                    // check if it is a true type file
                    if (strtolower(substr($item, -3)) === "ttf")
                    {
                        // workaround: if dots are in there, the form does not work.
                        // so lets change the dots to '-' and let option pass trough
                        $item = str_replace(".", "-", $item);
                        // add ttf font to array
                        $ttfFonts[] = "<option value=\"$item\">&nbsp;&nbsp;$item</option>";
                    }
                    // check if it is a otf file
                    if (strtolower(substr($item, -3)) === "otf")
                    {
                        $item = str_replace(".", "-", $item);
                        // add option to select field
                        $otfFonts[] = "<option value=\"$item\">&nbsp;&nbsp;$item</option>";
                    }
                    // check if it is a woff file
                    if (strtolower(substr($item, -3)) === "woff")
                    {
                        // workaround: change dots to '-' to let option pass trough
                        $item = str_replace(".", "-", $item);
                        // add option to select field
                        $woffFonts[] = "<option value=\"$item\">&nbsp;&nbsp;$item</option>";
                    }
                }
            }

            // add .ttf fonts to select option
            $selectField .="<optgroup label=\"True Type Fonts (system/fonts/*.ttf)\"></optgroup>";
            foreach ($ttfFonts as $ttfFont)
            {   // add ttf option to select field
                $selectField .= $ttfFont;
            }
            // add .otf fonts to select option
            $selectField .="<optgroup label=\"Open Type Fonts (system/fonts/*.otf)\"></optgroup>";
            foreach ($otfFonts as $otfFont)
            {   // add ttf option to select field
                $selectField .= $otfFont;
            }
            // add .woff fonts to select option
            $selectField .="<optgroup label=\"Web Open Font Format (system/fonts/*.woff)\"></optgroup>";
            foreach ($woffFonts as $woffFont)
            {   // add ttf option to select field
                $selectField .= $woffFont;
            }


            // fill google fonts array
            $googleFonts = $this->getGoogleFontsArray($db);
            // add google fonts to select option
            $selectField .="<optgroup label=\"Google Fonts\"></optgroup>";
            foreach ($googleFonts as $gFont)
            {
                // add google font option to select field
                // add option to select field
                $selectField .= "<option value=\"$gFont-gfont\">&nbsp;&nbsp;$gFont (Google Font)</option>";
            }
            // close select option
            $selectField .="</select>";

            // finally: output the html code of this select field
            return $selectField;
        }

        /**
         * get all google fonts into an array and return array
         * @author Daniel Retzl <danielretzl@gmail.com>
         * @version 1.0.0
         * @link http://yawk.io
         * @param object $db database
         * @return mixed
         *
         */
        function getGoogleFontsArray($db)
        {
            // array that holds the data
            $googleFonts = array();
            // select google fonts from database
            if ($sql = $db->query("SELECT font FROM {gfonts} ORDER BY font"))
            {   // for every single row...
                while ($row = mysqli_fetch_array($sql))
                {   // add font to array
                    $googleFonts[] = $row['0'];
                }
            }
            // check if googleFont is set and an array and not empty
            if (isset($googleFonts) && (is_array($googleFonts) && (!empty($googleFonts))))
            {   // return array containing all google fonts
                return $googleFonts;
            }
            else
                {   // no google font in database...
                    return null;
                }
        }

        /**
         * return a radio list of all registered google fonts
         * @author Daniel Retzl <danielretzl@gmail.com>
         * @version 1.0.0
         * @link http://yawk.io
         * @param object $db database
         * @param string $item the font
         * @param array $lang language array
         * @return bool
         */
        function getgFonts($db, $item, $lang)
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
            echo "<div id=\"nogooglefont\">
                       <label for=\"fontType\">$lang[FONT_TYPE_SELECTOR]</label>
                       <select id=\"fontType\" name=\"fontType\" class=\"form-control\">
                            <optgroup label=\"System Fonts\">
                            <option value=\"helvetica\">Helvetica</option>
                            <option value=\"arial\">Arial</option>
                            <option value=\"verdana\">Verdana</option>
                            <optgroup label=\"Own TrueType Font (system/fonts)\">

                       </select>
                  </div><br>";

                  // <input type=\"radio\" name=\"global-gfont\" value=\"0\" $nc> | Use system default fonts

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
                \YAWK\sys::setSyslog($db, 5, "failed to get google fonts from database ", 0, 0, 0, 0);
                return false;
            }
            // fin
            return true;
        } // ./ function getgFonts


        /**
         * delete google font with requested ID
         * @author Daniel Retzl <danielretzl@gmail.com>
         * @version 1.0.0
         * @link http://yawk.io
         * @param object $db database
         * @param int $gfontid google font ID you wish to delete
         * @return bool
         */
        function deleteGfont($db, $gfontid)
        {   /** @var $db \YAWK\db */
            if ($res = $db->query("DELETE from {gfonts}
                     			   WHERE id = '" . $gfontid . "'"))
            {   // success
                return true;
            }
            else
            {   // q failed
                \YAWK\sys::setSyslog($db, 5, "failed to delete google font id: $gfontid ", 0, 0, 0, 0);
                return false;
            }
        }

        /**
         * add google font to database
         * @author Daniel Retzl <danielretzl@gmail.com>
         * @version 1.0.0
         * @link http://yawk.io
         * @param object $db database
         * @param string $gfont name of the google font you wish to add
         * @param string $description any description for the font (eg. YourFont, cursive)
         * @return bool
         */
        function addgfont($db, $gfont, $description)
        {   /** @var $db \YAWK\db */
            if (empty($gfont))
            {   // no font was sent
                return false;
            }
            if (empty($description))
            {   // no description was sent
                return false;
            }
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
                    \YAWK\sys::setSyslog($db, 5, "failed to insert new google font to database ", 0, 0, 0, 0);
                    return false;
                }
            }
            else
            {   // q failed
                \YAWK\sys::setSyslog($db, 5, "failed to get MAX(id) from google fonts database ", 0, 0, 0, 0);
                return false;
            }
        }

        static function setCssBodyFontFace($cssTagName, $tplSettings)
        {
            $bodyFontFaceCSS = '';
            $fontFamily = $tplSettings["$cssTagName-fontfamily"];
            // get font type by cutting off file extension
            $fontType = substr($fontFamily, -4);
            // check file types
            if ($fontType === "-ttf")
            {
                $filename = str_replace("-ttf", ".ttf", $fontFamily);
                $bodyFontFaceCSS = "@font-face {
                font-family: $fontFamily;
                src: url('../../../fonts/$filename');
                }";
            }
            elseif ($fontType === "-otf")
            {
                $filename = str_replace("-otf", ".otf", $fontFamily);
                $bodyFontFaceCSS = "@font-face {
                font-family: $fontFamily;
                src: url('../../../fonts/$filename');
                }";
            }
            elseif ($fontType === "woff")
            {
                $filename = str_replace("-woff", ".woff", $fontFamily);
                $bodyFontFaceCSS = "@font-face {
                font-family: $fontFamily;
                src: url('../../../fonts/$filename') !important;
                }";
            }
            return $bodyFontFaceCSS;
        }

        static function setCssBodyLinkTags($cssTagName, $tplSettings)
        {
            $aLink = $tplSettings["$cssTagName-alink"];
            $aVisited = $tplSettings["$cssTagName-avisited"];
            $aHover = $tplSettings["$cssTagName-ahover"];
            $aWeight = $tplSettings["$cssTagName-linkfontweight"];
            $aStyle = $tplSettings["$cssTagName-linkfontstyle"];
            $aDecoration = $tplSettings["$cssTagName-linktextdecoration"];
            $hoverDecoration = $tplSettings["$cssTagName-hovertextdecoration"];
            $bodyLinkTags = "
                /* TODO: must be out of body */ 
                a:link { 
                        color: #$aLink;
                        font-weight: $aWeight;
                        font-style: $aStyle;
                        text-decoration: $aDecoration;
                        }
                a:visited {
                        color: #$aVisited;
                    }
                a:hover {   
                        color: #$aHover;
                        text-decoration: $hoverDecoration;
                    }
            ";
            return $bodyLinkTags;
        }

        static function setCssBodySmallFontSettings($cssTagName, $tplSettings)
        {
            $smallColor = $tplSettings["$cssTagName-smallcolor"];
            $smallShadowSize = $tplSettings["$cssTagName-smallshadowsize"];
            $smallShadowColor = $tplSettings["$cssTagName-smallshadowcolor"];

            $bodySmallTags = "small,
                    .small
                    {
                        font-weight: normal;
                        line-height: 1;
                        color: #$smallColor;
                        text-shadow: $smallShadowSize #$smallShadowColor;
                    }
                    ";
            return $bodySmallTags;
        }

        static function setCssBodyFontSettings($cssTagName, $tplSettings)
        {
            $fontFamily = $tplSettings["$cssTagName-fontfamily"];
            $fontSize = $tplSettings["$cssTagName-size"];
            $fontColor = $tplSettings["$cssTagName-fontcolor"];
            $fontShadowSize = $tplSettings["$cssTagName-fontshadowsize"];
            $fontShadowColor = $tplSettings["$cssTagName-fontshadowcolor"];
            $fontWeight = $tplSettings["$cssTagName-fontweight"];
            $fontStyle = $tplSettings["$cssTagName-fontstyle"];
            $fontTextDecoration = $tplSettings["$cssTagName-textdecoration"];
            // check, if it's a google font
            if (substr($fontFamily, -6) === "-gfont")
            {
                $googleFont = substr($fontFamily, 0, -6);
                $bodyFontCSS = "
                    font-family: $googleFont !important;
                    font-size: $fontSize;
                    color: #$fontColor;
                    text-shadow: $fontShadowSize #$fontShadowColor;
                    font-weight: $fontWeight;
                    font-style: $fontStyle;
                    text-decoration: $fontTextDecoration;
                ";
            }
            else
            {
                $bodyFontCSS = "
                    font-family: $fontFamily;
                    font-size: $fontSize;
                    color: #$fontColor;
                    text-shadow: $fontShadowSize #$fontShadowColor;
                    font-weight: $fontWeight;
                    font-style: $fontStyle;
                    text-decoration: $fontTextDecoration;
                ";
            }
            return $bodyFontCSS;
        }

        static function setCssFontSettings($cssTagName, $tplSettings)
        {
            $fontFamily = $tplSettings["$cssTagName-fontfamily"];
            $fontSize = $tplSettings["$cssTagName-size"];
            $fontColor = $tplSettings["$cssTagName-fontcolor"];
            $fontShadowSize = $tplSettings["$cssTagName-fontshadowsize"];
            $fontShadowColor = $tplSettings["$cssTagName-fontshadowcolor"];
            $fontWeight = $tplSettings["$cssTagName-fontweight"];
            $fontStyle = $tplSettings["$cssTagName-fontstyle"];
            $fontTextDecoration = $tplSettings["$cssTagName-textdecoration"];
            $aLink = $tplSettings["$cssTagName-alink"];
            $aVisited = $tplSettings["$cssTagName-avisited"];
            $aHover = $tplSettings["$cssTagName-ahover"];
            $aWeight = $tplSettings["$cssTagName-linkfontweight"];
            $aStyle = $tplSettings["$cssTagName-linkfontstyle"];
            $aDecoration = $tplSettings["$cssTagName-linktextdecoration"];
            $hoverDecoration = $tplSettings["$cssTagName-hovertextdecoration"];
            $smallColor = $tplSettings["$cssTagName-smallcolor"];
            $smallShadowSize = $tplSettings["$cssTagName-smallshadowsize"];
            $smallShadowColor = $tplSettings["$cssTagName-smallshadowcolor"];

            // get font type by cutting off file extension
            $fontType = substr($fontFamily, -4);
            // check file types
            if ($fontType === "-ttf")
            {
                $filename = str_replace("-ttf", ".ttf", $fontFamily);
                $fontCSS = "@font-face {
                font-family: $fontFamily;
                src: url('../../../fonts/$filename');
                }
                $cssTagName 
                {
                    font-family: $fontFamily !important;
                    font-size: $fontSize;
                    color: #$fontColor;
                    text-shadow: $fontShadowSize #$fontShadowColor;
                    font-weight: $fontWeight;
                    font-style: $fontStyle;
                    text-decoration: $fontTextDecoration;
                }
                $cssTagName a:link { /* LINK SETTINGS */
                        color: #$aLink;
                        font-weight: $aWeight;
                        font-style: $aStyle;
                        text-decoration: $aDecoration;
                }
                $cssTagName a:visited {
                        color: #$aVisited;
                }
                $cssTagName a:hover {   
                        color: #$aHover;
                        text-decoration: $hoverDecoration;
                }
                $cssTagName small,
                .$cssTagName small
                {
                    font-weight: normal;
                    line-height: 1;
                    color: #$smallColor;
                    text-shadow: $smallShadowSize #$smallShadowColor;
                }
                ";
            }
            elseif ($fontType === "-otf")
            {
                $filename = str_replace("-otf", ".otf", $fontFamily);
                $fontCSS = "@font-face {
                font-family: $fontFamily;
                src: url('../../../fonts/$filename');
                }
                $cssTagName 
                {                
                    font-family: $fontFamily !important;
                    font-size: $fontSize;
                    color: #$fontColor;
                    text-shadow: $fontShadowSize #$fontShadowColor;
                    font-weight: $fontWeight;
                    font-style: $fontStyle;
                    text-decoration: $fontTextDecoration;
                }
                    $cssTagName a:link { /* LINK SETTINGS */
                        color: #$aLink;
                        font-weight: $aWeight;
                        font-style: $aStyle;
                        text-decoration: $aDecoration;
                    }
                    $cssTagName a:visited {
                        color: #$aVisited;
                    }
                    $cssTagName a:hover {   
                        color: #$aHover;
                        text-decoration: $hoverDecoration;
                    }
                    $cssTagName small,
                    .$cssTagName small
                    {
                        font-weight: normal;
                        line-height: 1;
                        color: #$smallColor;
                        text-shadow: $smallShadowSize #$smallShadowColor;
                    }
                ";
            }
            elseif ($fontType === "woff")
            {
                $filename = str_replace("-woff", ".woff", $fontFamily);
                $fontCSS = "@font-face {
                font-family: $fontFamily;
                src: url('../../../fonts/$filename') !important;
                }
                $cssTagName 
                {
                    font-family: $fontFamily !important;
                    font-size: $fontSize;
                    color: #$fontColor;
                    text-shadow: $fontShadowSize #$fontShadowColor;
                    font-weight: $fontWeight;
                    font-style: $fontStyle;
                    text-decoration: $fontTextDecoration;
                }
                    $cssTagName a:link { /* LINK SETTINGS */
                        color: #$aLink;
                        font-weight: $aWeight;
                        font-style: $aStyle;
                        text-decoration: $aDecoration;
                    }
                    $cssTagName a:visited {
                        color: #$aVisited;
                    }
                    $cssTagName a:hover {   
                        color: #$aHover;
                        text-decoration: $hoverDecoration;
                    }
                    $cssTagName small,
                    .$cssTagName small
                    {
                        font-weight: normal;
                        line-height: 1;
                        color: #$smallColor;
                        text-shadow: $smallShadowSize #$smallShadowColor;
                    }
                ";
            }
            // check, if it's a google font
            elseif (substr($fontFamily, -6) === "-gfont")
            {
                $googleFont = substr($fontFamily, 0, -6);
                $fontCSS = "
                $cssTagName
                {
                    font-family: $googleFont !important;
                    font-size: $fontSize;
                    color: #$fontColor;
                    text-shadow: $fontShadowSize #$fontShadowColor;
                    font-weight: $fontWeight;
                    font-style: $fontStyle;
                    text-decoration: $fontTextDecoration;
                }
                
                $cssTagName a:link { /* LINK SETTINGS */
                        color: #$aLink;
                        font-weight: $aWeight;
                        font-style: $aStyle;
                        text-decoration: $aDecoration;
                    }
                $cssTagName a:visited {
                        color: #$aVisited;
                    }
                $cssTagName a:hover {   
                        color: #$aHover;
                        text-decoration: $hoverDecoration;
                    }
                    $cssTagName small,
                    .$cssTagName small
                    {
                        font-weight: normal;
                        line-height: 1;
                        color: #$smallColor;
                        text-shadow: $smallShadowSize #$smallShadowColor;
                    }
                ";
            }
            else
                {
                    $fontCSS = "
                    $cssTagName 
                    {
                        font-family: $fontFamily;
                        font-size: $fontSize;
                        color: #$fontColor;
                        text-shadow: $fontShadowSize #$fontShadowColor;
                        font-weight: $fontWeight;
                        font-style: $fontStyle;
                        text-decoration: $fontTextDecoration;
                    }
                
                    $cssTagName a:link { /* LINK SETTINGS */
                        color: #$aLink;
                        font-weight: $aWeight;
                        font-style: $aStyle;
                        text-decoration: $aDecoration;
                    }
                    $cssTagName a:visited {
                        color: #$aVisited;
                    }
                    $cssTagName a:hover {   
                        color: #$aHover;
                        text-decoration: $hoverDecoration;
                    }
                    $cssTagName small,
                    .$cssTagName small
                    {
                        font-weight: normal;
                        line-height: 1;
                        color: #$smallColor;
                        text-shadow: $smallShadowSize #$smallShadowColor;
                    }
                    ";
                }
            return $fontCSS;
        }

        static function getActiveBodyFont($db)
        {   /* @var \YAWK\db $db */
            $bodyFont = \YAWK\template::getTemplateSetting($db, "value", "globaltext-fontfamily");
            $bodyFontFamily = "font-family: $bodyFont";
            return $bodyFontFamily;
        }

        /**
         * return currently active google font
         * @author Daniel Retzl <danielretzl@gmail.com>
         * @version 1.0.0
         * @link http://yawk.io
         * @param object $db database
         * @param string $status the url or font name
         * @param string $property affected settings property
         * @return null|string
         */
        static function getActivegfont($db, $status, $property)
        {   /* @var \YAWK\db $db */
            if ($res = $db->query("SELECT id, font, setting
                     FROM {gfonts}
                     WHERE activated = 1
                      AND id = (SELECT ts.value
                      FROM {template_settings} ts
                      JOIN {settings} s on s.value = ts.templateID
                      WHERE ts.activated = 1 && s.property = 'selectedTemplate' && ts.property = '$property')"))
            {
                while ($row = mysqli_fetch_array($res)) {
                    // if no google font is selected
                    if ($row[1] === "0") {
                        return "font-family: Arial";
                    }
                    // css include output for index.php
                    if ($status == "url")
                    {//
                        if (isset($row[2]) || (!empty($row[2])))
                        {
                            return "
<link rel=\"stylesheet\" href=\"http://fonts.googleapis.com/css?family=$row[1]:$row[2]\" type=\"text/css\" media=\"all\">";
                        }
                        else
                            {
                                return "
<link rel=\"stylesheet\" href=\"http://fonts.googleapis.com/css?family=$row[1]\" type=\"text/css\" media=\"all\">";
                            }
                    }
                    else
                        {
                            return "font-family: $row[1];";
                        }
                }
            }
            else
                {   // could not get active google font
                    return "could not get active google font";
                }
            return null;
        }

        /**
         * get settings for heading, menu and text font and output html to load font
         * @author Daniel Retzl <danielretzl@gmail.com>
         * @version 1.0.0
         * @link http://yawk.io
         * @param object $db database
         */
        // TODO: OUTDATED AFTER REFACTORING...
        static function loadGoogleFonts($db)
        {
            $fonts = array(); // hold all fonts
            $googleFontFamilyString = ''; // the string the contains all google font families to minimize requests
            if ($sql = $db->query("SELECT value FROM {template_settings} WHERE property LIKE '%-fontfamily'"))
            {
                while ($row = mysqli_fetch_row($sql))
                {
                    $fonts[] = $row[0];
                }
            }
            foreach ($fonts as $googleFont)
            {
                if (substr($googleFont, -6) === "-gfont")
                {
                    // remove font indicator
                    $googleFont = rtrim($googleFont, "gfont");
                    $googleFont = rtrim($googleFont, "-");
                    // build google font loading string
                    $googleFontFamilyString .= $googleFont;
                    // add | to allow loading more than one font
                    $googleFontFamilyString .= "|";
                }
            }
            if (!empty($googleFontFamilyString))
            {
                // remove last | because its not needed
                $googleFontFamilyString = rtrim ($googleFontFamilyString, "|");
                echo "<link href=\"https://fonts.googleapis.com/css?family=$googleFontFamilyString\" rel=\"stylesheet\">";
            }

        }

        /**
         * get any template setting from database
         * @author Daniel Retzl <danielretzl@gmail.com>
         * @version 1.0.0
         * @link http://yawk.io
         * @param object $db database
         * @param string $field the setting (field) to get
         * @param string $property the property to get
         * @return bool
         */
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

        /**
         * include header for html page *outdated? *moved to sys?
         * @author Daniel Retzl <danielretzl@gmail.com>
         * @version 1.0.0
         * @link http://yawk.io
         * @param object $db database
         */
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

        /**
         * get the position states of all templates. This is used on index.php to render only templates that are enabled (1)
         * @author Daniel Retzl <danielretzl@gmail.com>
         * @version 1.0.0
         * @link http://yawk.io
         * @param object $db database
         * @param int $templateID ID of the current selected template
         * @return array|bool $array template positions 0|1
         */
        static function getPositionStatesArray($db, $templateID)
        {
            $array = '';
            $sql = $db->query("SELECT property, value 
                               FROM {template_settings} 
                               WHERE property LIKE 'pos-%-enabled' AND 
                               templateID = '".$templateID."'");
            while ($row = mysqli_fetch_assoc($sql))
            {
                $prop = $row['property'];
                $array[$prop] = $row['value'];
            }
            if (is_array($array))
            {
                return $array;
            }
            else
                {
                    return false;
                }
        }

        /**
         * get the position indicators. This is used on index.php to mark indicated positions
         * @author Daniel Retzl <danielretzl@gmail.com>
         * @version 1.0.0
         * @link http://yawk.io
         * @param object $db database
         * @param int $templateID ID of the current template
         * @return array|bool $array position indicator 0|1
         */
        static function getPositionIndicatorStatusArray($db, $templateID)
        {
            $array = '';
            $sql = $db->query("SELECT property, value 
                               FROM {template_settings} 
                               WHERE property 
                               LIKE 'pos-%-indicator'
                               AND templateID = '".$templateID."'");
            while ($row = mysqli_fetch_assoc($sql))
            {
                $prop = $row['property'];
                $array[$prop] = $row['value'];
            }
            if (is_array($array))
            {
                return $array;
            }
            else
            {
                return false;
            }
        }

        /**
         * set template position and output the correct data depending on position
         * @author Daniel Retzl <danielretzl@gmail.com>
         * @version 1.0.0
         * @link http://yawk.io
         * @param object $db database
         * @param string $position the template position
         */
        static function setPosition($db, $position)
        {
            global $currentpage;
            $main_set = 0;
            $globalmenu_set = 0;
            // get template setting for given pos
            // $setting = self::getTemplateSetting($db, $position, "");
            if (empty($setting)) {
                // no property
                // substr, because css definitions are without -pos (changefix?!)
                $position = substr("$position", 0, -4);
                // if main, we need to include the content page
                if ($position == "main")
                {
                    // if user is given to index.php, load userpage
                    if (isset($_GET['user'])){
                        // if var is set, but empty, show all users
                        if (empty($_GET['user'])){
                            echo "<h2>Show all users</h2>";
                            \YAWK\user::getUserList($db);
                        }
                        else {
                            // show userpage
                            echo "<h2>Show Profile of user $_GET[user]</h2>";
                        }
                    }
                    // if a blog is requested, load blog by given id
                    elseif (isset($_GET['blogid'])) {
                        $blog = new \YAWK\PLUGINS\BLOG\blog();
                        $blog->getFrontendEntries($db, $_GET['blogid'], ''. '', '','');
                        $blog->getFooter($db);
                        $blog->draw();
                        // in any other case, get content for requested static page
                    }
                    else
                        {
                            echo "<div id=\"$position\">";
                            $currentpage->getContent($db);
                            echo "</div>";
                            $main_set = 1;
                        }
                }

                // if position is globalmenu
                if ($position == "globalmenu") {
                    \YAWK\menu::displayGlobalMenu($db);
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

        /**
         * get all template settings into an array and return it
         * @author Daniel Retzl <danielretzl@gmail.com>
         * @version 1.0.0
         * @link http://yawk.io
         * @param object $db database
         * @param int $templateID affected template ID
         * @return array
         */
        static function getTemplateSettingsArray($db, $templateID)
        {   /* @var \YAWK\db $db */
            if (!isset($templateID) || (empty($templateID)))
            {   // if no templateID is set, take current template ID from settings db
                $templateID = settings::getSetting($db, "selectedTemplate");
            }
            $array = array();
            $res = $db->query("SELECT property, value, longValue
                        	FROM {template_settings}
                            WHERE templateID = $templateID");

            while ($row = mysqli_fetch_assoc($res)){
                $prop = $row['property'];
                $array[$prop] = $row['value'];
                $array[$prop] .= $row['longValue'];
            }
            return $array;
        }

        /**
         * check if an admin LTE wrapper should be loaded around the backend content.
         * This function must be called at the top of every backend page (admin/includes/xyz.php)
         * @author Daniel Retzl <danielretzl@gmail.com>
         * @version 1.0.0
         * @link http://yawk.io
         * @param array $lang language array
         * @return array
         */
        static function checkWrapper($lang, $title, $subtitle)
        {   /* @var \YAWK\db $db */
            if (!isset($_GET['hideWrapper']))
            {
                // draw the admin lte wrapper around content to include breadcrumbs and start content section
                // TEMPLATE WRAPPER - HEADER & breadcrumbs
                echo "
                        <!-- Content Wrapper. Contains page content -->
                        <div class=\"content-wrapper\" id=\"content-FX\">
                        <!-- Content Header (Page header) -->
                        <section class=\"content-header\">";
                /* draw Title on top */
                echo \YAWK\backend::getTitle($lang[$title], $lang[$subtitle]);
                echo"<ol class=\"breadcrumb\">
                                <li><a href=\"index.php\" title=\"$lang[DASHBOARD]\"><i class=\"fa fa-dashboard\"></i> $lang[DASHBOARD]</a></li>
                                <li><a href=\"index.php?page=users\" class=\"active\" title=\"$lang[USERS]\"> $lang[USERS]</a></li>
                            </ol>
                        </section>
                        <!-- Main content -->
                        <section class=\"content\">";
                /* page content start here */
                return null;
            }
            else    // if wrapper is set
                {   // check if hide status is 1
                    if ($_GET['hideWrapper'] === 1)
                    {
                        // no wrapper needed - do nothing
                    }
                }
            return null;
        }

        /**
         * Return a multidimensional array with all assets by requested type.
         * If no type is set, or type == 0, all assets will be returned.
         * @author Daniel Retzl <danielretzl@gmail.com>
         * @version 1.0.0
         * @link http://yawk.io
         * @param object $db database object
         * @param int $type 0 = all, 1 = required, 2 = optional, 3 = additional
         * @return array
         */
        public static function getAssetsByType($db, $type)
        {   /* @var \YAWK\db $db */
            // check if type is set
            if (!isset($type) || (empty($type)))
            {   // if its not set, get all assets from db, no matter which type they are
                $typeSQLCode = ''; // terminate db query
            }
            else
            {   // check if type is a number
                if (is_numeric($type) || (is_int($type)))
                {   // and build additional sql string
                    $typeSQLCode = "AND type = '$type'";

                    // if type is zero, fetch all data
                    if ($type === 0)
                    {   // terminate db query
                        $typeSQLCode = '';
                    }
                }
                else
                {   // type is not a number, get all data
                    $typeSQLCode = ''; // terminate db query
                }
            }

            // init a new empty array
            $assets = array();
            // get assets from database
            $res = $db->query("SELECT * 
                            FROM {assets_types}
                            WHERE published = '1' 
                            $typeSQLCode ORDER by sortation, asset");
            // fetch data in loop
            while ($row = mysqli_fetch_assoc($res))
            {   // build assets array
                $prop = $row['asset'];
                $assets[$prop]["asset"] = $prop;
                $assets[$prop]["property"] = $row['property'];
                $assets[$prop]["internal"] = $row['internal'];
                $assets[$prop]["url1"] = $row['url1'];
                $assets[$prop]["url2"] = $row['url2'];
                $assets[$prop]["url3"] = $row['url3'];
            }
            // check if assets is an array
            if (is_array($assets))
            {   // all good
                return $assets;
            }
            else
                {   // error: exit with msg
                    die ('unable to return assets array - maybe database is corrupt or missing.');
                }
        }

        /**
         * Draw a list with all assets that are used in this template
         * @author Daniel Retzl <danielretzl@gmail.com>
         * @version 1.0.0
         * @link http://yawk.io
         * @param object $db database object
         * @param int $templateID ID of the affectd template
         * @param array $lang language array
         * @return null
         */
        public static function drawAssetsTitles($db, $templateID, $lang)
        {
            /* @var \YAWK\db $db */
            // if no template ID is set
            if (!isset($templateID) || (empty($templateID)))
            {   // get current ID from database
                $templateID = \YAWK\settings::getSetting($db, "selectedTemplate");
            }
            if ($res = $db->query("SELECT asset, link FROM {assets} 
                                          WHERE templateID = '".$templateID."' 
                                          ORDER BY asset"))
            {
                while ($row = mysqli_fetch_assoc($res))
                {
                    // check, if link is external
                    if (strpos($row['link'], 'http://') !== false || (strpos($row['link'], 'https://') !== false)) {
                        $icon = "fa fa-globe";
                        $title = "$lang[EXTERNAL]";
                    }
                    else
                        {
                            $icon = "fa fa-server";
                            $title = "$lang[INTERNAL]";
                        }
                    $qString = rawurlencode($row['asset']);

                    echo "<small><a href=\"index.php?page=template-assets\" data-toggle=\"tooltip\" title=\"$title\"><i class=\"$icon text-info\"></i></a></small> &nbsp;$row[asset] &nbsp;<small><a href=\"https://www.google.at/search?q=$qString\" target=\"_blank\" data-toggle=\"tooltip\" title=\"$row[asset] $lang[GOOGLE_THIS]\"><i class=\"fa fa-question-circle-o\"></i></a></small><br>";
                }
            }
            return null;
        }


        /**
         * Draw asset select fields
         * This method is used in the backend to generate asset select fields in template-assets view
         * @author Daniel Retzl <danielretzl@gmail.com>
         * @version 1.0.0
         * @link http://yawk.io
         * @param object $db database object
         * @param int $type 0 = all, 1 = required, 2 = optional, 3 = additional
         * @param int $templateID id of the affected template
         * @param array $lang language array
         * @return null
         */
        public static function drawAssetsSelectFields($db, $type, $templateID, $lang)
        {   /* @var \YAWK\db $db */

            // check type and load assets data
            // if type is not set
            if (!isset($type) || (empty($type)))
            {   // set to zero -this will get all assets in array
                $type = 0;
            }

            // check if templateID is set
            if (!isset($templateID) || (empty($templateID)))
            {
                // get current template ID
                $templateID = \YAWK\settings::getSetting($db, "selectedTemplate");
            }

            // get assets, depending on type from database
            $assets = \YAWK\template::getAssetsByType($db, $type);

            foreach ($assets as $asset => $property)
            {
                $resInternal = $db->query("SELECT link from {assets} 
                                         WHERE templateID = '".$templateID."'
                                         AND link = '".$property['internal']."'");

                $resUrl1 = $db->query("SELECT link from {assets} 
                                         WHERE templateID = '".$templateID."'
                                         AND link = '".$property['url1']."'");

                $resUrl2 = $db->query("SELECT link from {assets} 
                                         WHERE templateID = '".$templateID."'
                                         AND link = '".$property['url2']."'");

                $resUrl3 = $db->query("SELECT link from {assets} 
                                         WHERE templateID = '".$templateID."'
                                         AND link = '".$property['url3']."'");

                $row = mysqli_fetch_assoc($resInternal);
               // print_r($res);
                if ($row['link'] === $property['internal'])
                { $selectedInternal = " selected"; }
                else { $selectedInternal = ''; }

                $row = mysqli_fetch_assoc($resUrl1);
                if ($row['link'] === $property['url1'])
                { $selectedUrl1 = " selected"; }
                else { $selectedUrl1 = ''; }

                $row = mysqli_fetch_assoc($resUrl2);
                if ($row['link'] === $property['url2'])
                { $selectedUrl2 = " selected"; }
                else { $selectedUrl2 = ''; }

                $row = mysqli_fetch_assoc($resUrl3);
                if ($row['link'] === $property['url3'])
                { $selectedUrl3 = " selected"; }
                else { $selectedUrl3 = ''; }

                echo "<label for=\"include-$property[property]\">$property[asset]</label>
                      <input name=\"title-$property[property]\" value=\"$property[asset]\" type=\"hidden\">
                      
                        <select id=\"include-$property[property]\" name=\"include-$property[property]\" class=\"form-control\">
                            <option name=\"null\" value=\"\">inactive</option>
                            <optgroup label=\"internal\">internal</optgroup>
                            <option name=\"value\"$selectedInternal>$property[internal]</option>
                            <optgroup label=\"external\">external</optgroup>
                            <option name=\"value\"$selectedUrl1>$property[url1]</option>";
                            if (!empty($property['url2']))
                            {   // display 2nd external asset link
                                echo "
                            <option name=\"value\"$selectedUrl2>$property[url2]</option>";
                            }
                            if (!empty($property['url3']))
                            {
                                echo "
                            <option name=\"value\"$selectedUrl3>$property[url3]</option>";
                            }
                        echo "
                            </select>";
            }
            return null;
        }

        public function loadActiveAssets($db, $templateID)
        {   /* @var \YAWK\db $db */

            // create empty array
            $assetArray = array();

            if (isset($templateID) && (!empty($templateID)))
            {
                echo "
<!-- ASSETS -->";
                if ($res = $db->query("SELECT type, asset, link FROM {assets} WHERE templateID = '".$templateID."' ORDER BY type"))
                {
                    while ($row = mysqli_fetch_assoc($res))
                    {
                        // CSS
                        if ($row['type'] === "css")
                        {   // load css asset
                            echo "
 <!-- load CSS: $row[asset] -->
 <link rel=\"stylesheet\" href=\"".$row['link']."\" type=\"text/css\" media=\"all\">";
                        }
                        // JS
                        if ($row['type'] === "js")
                        {   // load js asset
                            echo "
 <!-- load JS: $row[asset] -->
 <script src=\"".$row['link']."\"></script>";
                        }
                    }
                }
            }
        }


        /**
         * copy template settings into a new template
         * @author Daniel Retzl <danielretzl@gmail.com>
         * @version 1.0.0
         * @link http://yawk.io
         * @param object $db database
         * @param int $templateID template ID
         * @param int $newID template ID
         */
        public static function copyAssets($db, $templateID, $newID)
        {   /** @var $db \YAWK\db */

            $res = $db->query("INSERT INTO {assets} (templateID, type, asset, link)
                                      SELECT '".$newID."', type, asset, link
                                      FROM {assets} 
                                      WHERE templateID = '".$templateID."'");

            if (!$res)
            {
                \YAWK\sys::setSyslog($db, 5, "failed to copy assets of template #$templateID ", 0, 0, 0, 0);
                \YAWK\alert::draw("danger", "Could not copy assets", "please try again.", "", 5000);
            }
            else
            {
                \YAWK\alert::draw("success", "Assets copied", "successful", "", 5000);


                $update = $db->query("UPDATE {assets} SET templateID='".$newID."' WHERE templateID=0");
                if ($update)
                {
                    \YAWK\alert::draw("success", "Assets are set-up", "successful", "", 5000);
                }
                else
                {
                    \YAWK\sys::setSyslog($db, 5, "failed to copy assets of template #$templateID ", 0, 0, 0, 0);
                    \YAWK\alert::draw("warning", "Could not copy template assets", "unable to alter IDs.", "", 5000);
                }

            }
        }




    } // ./class template
} // ./namespace