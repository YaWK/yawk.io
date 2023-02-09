<?php
namespace YAWK {
    /**
     * @details Template controller - get and set template settings.
     *
     * Templates itself are located in /system/templates/ - if you want to modify them, start there.
     * <p><i>Class covers both, backend & frontend functionality.
     * See Methods Summary for Details!</i></p>
     *
     * @author     Daniel Retzl <danielretzl@gmail.com>
     * @copyright  2009-2022 Daniel Retzl
     * @license    https://opensource.org/licenses/MIT
     * @brief The template controller - get and set template settings.
     */
    class template
    {
        /** * @param int template ID */
        public $id;
        /** * @param int new TPL ID (latest template) */
        public $newId;
        /** * @param int 0|1 is this template active? */
        public $active;
        /** * @param string template name */
        public $name;
        /** * @param string new template name */
        public $newTplName;
        /** * @param array db config array */
        public $config;
        /** * @param string template folder (root path of all templates) */
        public $folder = '../system/templates/';
        /** * @param string template tmp folder (where uploads will be unpacked) */
        public $tmpFolder = '../system/templates/tmp/';
        /** * @param string upload file (including complete path) */
        public $uploadFile = '';
        /** * @param string template sub folder (template name, eg. ../system/templates/SUBFOLDER */
        public $subFolder;
        /** * @param string positions as string */
        public $positions;
        /** * @param string template description */
        public $description;
        /** * @param string datetime when this template was released */
        public $releaseDate;
        /** * @param string author of this template */
        public $author;
        /** * @param string author's url */
        public $authorUrl;
        /** * @param string weblink to this template */
        public $weblink;
        /** * @param string sub-author who has modified the template */
        public $subAuthor = '';
        /** * @param string sub-author's url */
        public $subAuthorUrl = '';
        /** * @param string datetime when this template was modified */
        public $modifyDate;
        /** * @param string template's version number */
        public $version;
        /** * @param string the current loaded Bootstrap version */
        public $bootstrapVersion;
        /** * @param string required framework for this template */
        public $framework = 'bootstrap4';
        /** * @param string template's license */
        public $license;
        /** * @param int which template is currently set to active? */
        public $selectedTemplate;
        /** * @param string path to own true type fonts */
        public $ttfPath = '../system/fonts';


        /**
         * @brief return ID of current (active) template
         * @param object $db database object
         * @return int the ID of the currently selected template
         */
        static function getCurrentTemplateId(object $db): int
        {   // return value of property selectedTemplate from settings db
            // outdated: return \YAWK\settings::getSetting($db, "selectedTemplate");

            if (!isset($user)){
                $user = new user($db);
            }
            if (!isset($template)){
                $template = new template();
            }

            // since user can override his template, there are more specific checks needed,
            // which template is currently active and which ID we will return. To do that:
            return template::getValidTemplateID($db, $user, $template);
        }

        /**
         * @brief Check if a template with given name already exists, return true or false
         * @param object $db
         * @param string $name
         * @return bool true|false
         */
        public function checkIfTemplateAlreadyExists(object $db, string $name): bool
        {
            // check if name is set, not empty and valid type
            if (isset($name) && (!empty($name) && (is_string($name))))
            {
                // strip unwanted code
                $name = strip_tags($name);

                // check if template is already in database
                $result = $db->query("SELECT name FROM {templates} WHERE name = '".$name."'");
                // if there are no rows
                if($result->num_rows == 0)
                {   // template not found in database...
                    sys::setSyslog($db, 45, 0, "template $name not found in database", 0, 0, 0, 0);
                    return false;
                }
                else
                {   // template exists in database
                    sys::setSyslog($db, 45, 0, "template $name updated", 0, 0, 0, 0);
                    return true;
                }
            }
            else
            {   // template param not set, empty or wrong type
                sys::setSyslog($db, 45, 0, "template param $name not set or wrong type", 0, 0, 0, 0);
                return false;
            }
        }

        /**
         * @brief switch all positions indicators on or off
         * @param int $templateID ID of the affected template
         * @param int $status value to set (0|1)
         * @param object $db
         * @return bool true|false
         */
        public function switchPositionIndicators(object $db, int $templateID, int $status): bool
        {
            // if template param is not set
            if (!isset($templateID) || (!is_numeric($templateID))) {   // get current active template ID
                $templateID = self::getCurrentTemplateId($db);
            }

            // if status parameter is not set
            if (!isset($status) || (!is_numeric($status))) {   // turn off is default behaviour
                $status = 0;
            }

            // update position indicator status
            if ($db->query("UPDATE {template_settings} 
                                   SET value = '" . $status . "'
                                   WHERE property 
                                   LIKE '%indicator%'
                                   AND templateID = '" . $templateID . "'")
            ) {   // all good,
                return true;
            } else {   // update position indicators failed
                return false;
            }
        }

        /**
         * @brief fetch positions of current (active) template, explode string and return positions array
         * @param object $db
         * @return array|bool
         */
        static function getTemplatePositions(object $db)
        {
            /** @var $db \YAWK\db */
            $res = '';
            // fetch template id
            $tpl_id = settings::getSetting($db, "selectedTemplate");
            // fetch template positions
            if ($res = $db->query("SELECT positions
                                FROM {templates}
                                WHERE id = '" . $tpl_id . "'")
            ) {   // fetch data
                $posArray = array();
                while ($row = $res->fetch_assoc()) {
                    $posArray[] = $row;
                }
                $pos = $posArray[0]['positions'];
                // explode string into array + return
                $positions = explode(':', $pos);
                // return tpl positions
                return $positions;
            } else {
                // q failed
                sys::setSyslog($db, 47, 1, "failed to get template positions of template id: <b>$tpl_id</b> ", 0, 0, 0, 0);
                return false;
            }
        }

        /**
         * @brief save a template as new. It copies the tpl folder and all settings into a new one.
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
        public function saveAs(object $db): bool
        {
            /** @param \YAWK\db $db */
            // prepare vars
            $replace = array("/ä/", "/ü/", "/ö/", "/Ä/", "/Ü/", "/Ö/", "/ß/"); // array of special chars
            $chars = array("ae", "ue", "oe", "Ae", "Ue", "Oe", "ss"); // array of replacement chars
            $this->newTplName = preg_replace($replace, $chars, $this->newTplName);      // replace with preg
            // final check: just numbers and chars are allowed
            $this->newTplName = preg_replace("/[^a-z0-9\-\/]/i", "", $this->newTplName);
            // same goes on for $template->name
            $this->name = preg_replace($replace, $chars, $this->name);  // replace with preg
            // final check: just numbers and chars are allowed
            $this->name = preg_replace("/[^a-z0-9\-\/]/i", "", $this->name);
            // get current timestamp
            $now = sys::now();

            // copy new template into database
            if ($res = $db->query("INSERT INTO {templates} (name, positions, description, releaseDate, author, authorUrl, weblink, subAuthor, subAuthorUrl, modifyDate, version, framework, license)
                                   VALUES('" . $this->newTplName . "', 
                                          '" . $this->positions . "',
                                          '" . $this->description . "',
                                          '" . $now . "',
                                          '" . $this->author . "',
                                          '" . $this->authorUrl . "',
                                          '" . $this->weblink . "',
                                          '" . $this->subAuthor ."',
                                          '" . $this->subAuthorUrl ."',
                                          '" . $now . "',
                                          '" . $this->version . "',
                                          '" . $this->framework . "',
                                          '" . $this->license . "')"))
            {

            }
            else
            {   // q failed, throw error
                sys::setSyslog($db, 47, 1, "failed to save <b>$this->newTplName</b> as new template", 0, 0, 0, 0);
                // \YAWK\alert::draw("warning", "Warning!", "Could not insert your template $new_template into database.", "", 6200);
                return false;
            }
            // tpl added to database successful
            // check if template folder exists
            if (is_dir(dirname("../system/templates/$this->name")))
            {
                // ok, start to copy template from source to new destination
                sys::xcopy("../system/templates/$this->name", "../system/templates/$this->newTplName");
                sys::setSyslog($db, 47, 1, "copy template folder from ../system/templates/$this->name to ../system/templates/$this->newTplName", 0, 0, 0, 0);
                return true;
            }
            else
            {   // template folder does not exist
                // what should we copy if nothing exists?
                sys::setSyslog($db, 47, 1, "failed to copy template - template name $this->name does not exist", 0, 0, 0, 0);
                return false;
            }
        }

        /**
         * @brief load properties into template object
         * @param object $db database object
         * @param int    $id template id to load
         * @return bool true or false
         */
        public function loadProperties($db, $id)
        {
            /** @param $db \YAWK\db $res */
            $res = $db->query("SELECT * FROM {templates} WHERE id = '" . $id . "'");
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
                $this->framework = $row['framework'];
                $this->license = $row['license'];
                $this->selectedTemplate = settings::getSetting($db, "selectedTemplate");
                return true;
            } else {   // could not fetch tpl properties, throw error...
                sys::setSyslog($db, 47, 1, "failed to load properties of template <b>$this->name</b> (id: <b>$id</b>)", 0, 0, 0, 0);
                // \YAWK\alert::draw("danger", "Warning!", "Could not fetch template properties. Expect a buggy view.", "", 3000);
                return false;
            }
        }


        /**
         * @brief load template properties and return as array
         * @param object $db database object
         * @param int $id template id to load
         * @return bool|array true or false
         */
        public function loadPropertiesIntoArray(object $db, int $id)
        {
            /** @param $db \YAWK\db $res */
            $res = $db->query("SELECT * FROM {templates} WHERE id = '" . $id . "'");
            if ($row = mysqli_fetch_assoc($res))
            {
                if (!is_array($row) || (empty($row)))
                {   // not an array or empty...
                    return false;
                }
                else
                {   // return array
                    return $row;
                }
            }
            else
            {   // could not fetch tpl properties, throw error...
                sys::setSyslog($db, 47, 1, "failed to load properties of template id <b>$id</b> into array", 0, 0, 0, 0);
                return false;
            }
        }

        /**
         * @brief load template settings of ID and return as array
         * @param object $db database object
         * @param int $id template id to load
         * @return array|false
         */
        public function loadAllSettingsIntoArray(object $db, int $id)
        {
            /** @param $db \YAWK\db $res */
            $res = $db->query("SELECT * FROM {template_settings} WHERE templateID = '" . $id . "'");
            while ($row = mysqli_fetch_assoc($res))
            {
                $templateSettings[] = $row;
            }

            if (isset($templateSettings) && (is_array($templateSettings) && (!empty($templateSettings))))
            {   // not an array or empty...
                return $templateSettings;
            }
            else
            {   // could not fetch tpl properties, throw error...
                sys::setSyslog($db, 47, 1, "failed to load template_settings of template id <b>$id</b> into array", 0, 0, 0, 0);
                return false;
            }
        }

        /**
         * @brief save new template properties into database
         * @param object $db database object
         * @param int $id template id to save
         * @param array $data post data from form (new settings)
         * @param array $oldTplSettings template settings array (old settings)
         * @return bool true or false
         */
        public function saveProperties(object $db, int $id, array $data, array $oldTplSettings): bool
        {
            // check if data is set set
            if (!isset($data) || (!isset($id))) {   // if not, abort
                return false;
            }
            if (empty($oldTplSettings))
            {
                $oldTplSettings = array();
            }

            // walk through all post data settings
            foreach ($data as $property => $value)
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
                if ($property != "save" && ($property != "customCSS") && ($property != "testText")) {
                    if (isset($oldTplSettings[$property]) && ($oldTplSettings[$property]) === $value)
                    {   // if old settings and new settings are the same
                        // do nothing
                    }
                    else
                    {   // update template setting
                        $this->setTemplateSetting($db, $id, $property, $value, $longValue);
                    }
                }
            }
            return true;
        }


        /**
         * @brief load template_settings_types and return as array
         * @param object $db database object
         * @return array|false
         */
        public function loadSettingsTypesIntoArray(object $db)
        {
            /** @param $db \YAWK\db $res */
            $res = $db->query("SELECT * FROM {template_settings_types}");
            while ($row = mysqli_fetch_assoc($res))
            {
                $settingsTypes[] = $row;
            }
            if (isset($settingsTypes) && (is_array($settingsTypes) && (!empty($settingsTypes))))
            {   // all good,
                return $settingsTypes;
            }
            else
            {   // could not fetch tpl properties, throw error...
                sys::setSyslog($db, 47, 1, "failed to load template_settings_types into array", 0, 0, 0, 0);
                return false;
            }
        }


        /**
         * @brief return array with all template id's + names.
         * @param object $db database
         * @return array|bool
         */
        static function getTemplateIds(object $db)
        {
            /** @param \YAWK\db $db */
            // returns an array with all template IDs
            $mysqlRes = $db->query("SELECT id, name
                                FROM {templates}
                                ORDER by name ASC");
            while ($row = mysqli_fetch_assoc($mysqlRes)) {
                $res[] = $row;
            }
            if (!empty($res)) {   // yey, return array
                return $res;
            } else {   // could not fetch array
                sys::setSyslog($db, 47, 1, "failed get template id and name ", 0, 0, 0, 0);
                return false;
            }
        }

        /**
         * @brief count and return how many settings got this: template ID
         * @param object $db database
         * @param int $templateID affected template ID
         * @return int the number of settings for this template
         */
        static function countTemplateSettings(object $db, int $templateID): int
        {
            /** @var $db \YAWK\db */
            // count + return settings from given tpl ID
            $res = $db->query("SELECT id FROM {template_settings}
                                        WHERE templateID = '" . $templateID . "'");
            return mysqli_num_rows($res);
        }

        /**
         * @brief return template name for given ID
         * @param object $db database
         * @param int $templateID affected template ID
         * @return string|null
         */
        public static function getTemplateNameById(object $db, int $templateID): ?string
        {
            /** @var $db \YAWK\db */
            if (!isset($templateID) || (empty($templateID))) {   // template id is not set, try to get current template
                $templateID = settings::getSetting($db, "selectedTemplate");
            }
            // query template name
            if ($res = $db->query("SELECT name from {templates} WHERE id = $templateID")) {   // fetch data
                if ($row = mysqli_fetch_row($res)) {   // return current name
                    return $row[0];
                }
            } else {   // exit and throw error
                sys::setSyslog($db, 47, 1, "failed to get template name by id <b>$templateID</b> ", 0, 0, 0, 0);
                // die ("Please check database connection.");
            }
            return null;
        }


        /**
         * @brief return template ID for given name
         * @param object $db database
         * @param string $name affected template name
         * @return int|null
         */
        public static function getTemplateIdByName(object $db, string $name): ?int
        {
            /** @var $db \YAWK\db */
            if (!isset($name) || (empty($name)))
            {   // template name is not set
                return null;
            }
            // query template name
            if ($res = $db->query("SELECT id from {templates} WHERE name = '$name'"))
            {   // fetch data
                if ($row = mysqli_fetch_row($res))
                {   // return ID
                    return $row[0];
                }
            }
            else
            {
                // exit and throw error
                sys::setSyslog($db, 47, 1, "failed to get template ID by name <b>$name</b> ", 0, 0, 0, 0);
                return null;
            }
            // any other case is an error
            return null;
        }

        /**
         * @brief return current active template name
         * @param object $db database
         * @param string $location frontend or backend
         * @param int $templateID affected template ID
         * @return bool|string
         */
        public static function getCurrentTemplateName(object $db, string $location, int $templateID)
        {
            /** @var $db \YAWK\db */
            if (!isset($location) || (empty($location))) {   // if location is empty, set frontend as default
                $location = "frontend";
                $prefix = "";
            } else {   // check location to set path correctly
                if ($location == "frontend") {   // call from frontend
                    $prefix = "";
                } else {   // call from backend
                    $prefix = "../";
                }
            }
            // NO TEMPLATE ID IS SET...
            if (empty($templateID) || ($templateID == 0)) {
                // check if user has its own template
                // $userTemplateID = \YAWK\user::getUserTemplateID($db, )
                // no templateID sent via param, set current selected template ID
                $templateID = settings::getSetting($db, "selectedTemplate");
            }
            // get current template name from database
            $tpldir = $prefix . "system/templates/";
            if ($res = $db->query("SELECT name FROM {templates}
                       WHERE id = $templateID")
            ) {   // fetch data
                if ($row = mysqli_fetch_row($res)) {   // check if selected tpl exists
                    if (!$dir = @opendir("$tpldir" . $row[0])) {   // if directory could not be opened: throw error
                        sys::setSyslog($db, 47, 1, "failed to load template directory of template id: <b>$templateID</b>", 0, 0, 0, 0);
                        return "<b>Oh-oh! There was a big error. . .</b> <u>you shall not see this!</u><br><br>Unable to load template " . $row[0] . ".&nbsp; I am deeply sorry.<br> I am sure my administrator is hurry to fix that problem.<br> yours,<br>YaWK <i><small>(Yet another Web Kit)</i></small>";
                    } else {   // return template name
                        return $row[0];
                    }
                } else {   // could not fetch template -
                    // - in that case set default template
                    // print alert::draw("warning", "Warning: ", "Template kann nicht gelesen werden, default template gesetzt. (YaWK-bootstrap3)","page=settings-system","4800");
                    return "template ID $templateID not in database...?";
                }
            }
            // something else has happened
            return false;
        }

        /**
         * @brief get, set and minify template css file
         * @param object $db database
         * @param int $tplId affected template ID
         * @param string $content contains the css file content
         * @param int $minify 0|1 if 1, file gets minified before saving.
         * @return bool
         */
        public function writeTemplateCssFile(object $db, int $tplId, string $content, int $minify): bool
        {
            /** @var $db \YAWK\db */
            // check whether templateID is not set or empty
            if (!isset($tplId) || (empty($tplId))) {   // set default value: template 1
                $tplId = 1;
            }
            // prepare vars
            $filename = self::getSettingsCSSFilename($db, "backend", $tplId);
            // check if file need to be minified
            if (isset($minify) && (!empty($minify))) {   // minify is set
                if ($minify === 1) {   // create a minified version: template/css/custom.min.css (for production include)
                    $filename = substr($filename, 0, -4);
                    $filename = "$filename.min.css";
                    $content = sys::minifyCSS($content);
                } else {   // failed to minify, insert syslog
                    sys::setSyslog($db, 47, 1, "failed to minify template css <b>$filename</b>", 0, 0, 0, 0);
                }
            }
            // do all the file stuff, open, write, close and chmod to set permissions.
            $handle = fopen($filename, "wb");

            if (!fwrite($handle, $content)) {   // write failed, throw error
                sys::setSyslog($db, 48, 2, "failed to write <b>$filename</b> Please check file / folder owner or group permissions", 0, 0, 0, 0);
                alert::draw("danger", "Error!", "Could not template CSS file $filename<br>Please check your file / owner or group permissions.", "", 4200);
            }
            if (!fclose($handle)) {   // close failed, throw error
                sys::setSyslog($db, 47, 1, "failed to close <b>$filename</b>", 0, 0, 0, 0);
                alert::draw("warning", "Warning!", "Failed to template CSS file close $filename<br>Please try again and / or expect some errors.", "", 4200);
            }
            if (!chmod($filename, 0775)) {   // chmod failed, throw error
                sys::setSyslog($db, 47, 1, "failed to chmod 775 to template CSS file <b>$filename</b>", 0, 0, 0, 0);
                alert::draw("warning", "Warning!", "Failed to chmod(775) $filename<br>Please check file / folder / owner / group permissions!", "", 4200);
            }
            // after all....
            return true;
        }

        /**
         * @brief get, set and minify custom.css file
         * @param object $db database
         * @param string $content contains the css file content
         * @param int $minify 0|1 if 1, the file gets minified before saving.
         * @param int $templateID affected template ID
         * @return bool
         */
        public function setCustomCssFile(object $db, string $content, int $minify, int $templateID): bool
        {
            /** @var $db \YAWK\db */
            // create template/css/custom.css (for development purpose in backend)
            // prepare vars
            $filename = self::getCustomCSSFilename($db, "backend", $templateID);
            // check if file need to be minified
            if (isset($minify) && (!empty($minify))) {   // minify is set
                if ($minify === 1) {   // create a minified version: template/css/custom.min.css (for production include)
                    $filename = substr($filename, 0, -4);
                    $filename = "$filename.min.css";
                    $content = sys::minifyCSS($content);
                } else {
                    sys::setSyslog($db, 47, 1, "failed to minify file <b>$filename</b>", 0, 0, 0, 0);
                }
            }
            // do all the file stuff, open, write, close and chmod to set permissions.
            $handle = fopen($filename, "wb");
            //$content = \YAWK\sys::replaceCarriageReturns("\n\r", $content);
            $content = sys::replacePreTags("\n\r", $content);
            if (!fwrite($handle, $content)) {   // write failed, throw error
                alert::draw("danger", "Error!", "Could not write custom css $filename<br>Please check your file / owner or group permissions.", "", 4200);
            }
            if (!fclose($handle)) {   // close failed, throw error
                alert::draw("warning", "Warning!", "Failed to close custom css $filename<br>Please try again and / or expect some errors.", "", 4200);
            }
            if (!chmod($filename, 0775)) {   // chmod failed, throw error
                alert::draw("warning", "Warning!", "Failed to chmod(775) custom css $filename<br>Please check file / folder / owner / group permissions!", "", 4200);
            }
            // after all....
            return true;
        }

        /**
         * @brief get, set and minify custom.js file
         * @param object $db database
         * @param string $content contains the js file content
         * @param int $minify 0|1 if 1, the file gets minified before saving.
         * @param int $templateID affected template ID
         * @return bool
         */
        public function setCustomJsFile(object $db, string $content, int $minify, int $templateID): bool
        {
            /** @var $db \YAWK\db */
            // create template/css/custom.css (for development purpose in backend)
            // prepare vars
            $filename = self::getCustomJSFilename($db, "backend", $templateID);
            // check if file need to be minified
            if (isset($minify) && (!empty($minify))) {   // minify is set
                if ($minify === 1) {   // create a minified version: template/js/custom.min.js (for production include)
                    $filename = substr($filename, 0, -3);
                    $filename = "$filename.min.js";
                    $content = sys::minifyJs($content);
                } else {
                    sys::setSyslog($db, 47, 1, "failed to minify file <b>$filename</b>", 0, 0, 0, 0);
                }
            }
            // do all the file stuff, open, write, close and chmod to set permissions.
            $handle = fopen($filename, "wb");
            //$content = \YAWK\sys::replaceCarriageReturns("\n\r", $content);
            $content = sys::replacePreTags("\n\r", $content);
            if (!fwrite($handle, $content)) {   // write failed, throw error
                alert::draw("danger", "Error!", "failed to write file $filename<br>Please check your file / owner or group permissions.", "", 4200);
            }
            if (!fclose($handle)) {   // close failed, throw error
                alert::draw("warning", "Warning!", "Failed to close custom js $filename<br>Please try again and / or expect some errors.", "", 4200);
            }
            if (!chmod($filename, 0775)) {   // chmod failed, throw error
                alert::draw("warning", "Warning!", "Failed to chmod(775) custom js $filename<br>Please check file / folder / owner / group permissions!", "", 4200);
            }
            // after all....
            return true;
        }

        /**
         * @brief return the content of custom.css
         * @param object $db database
         * @param int $templateID affected template ID
         * @return string the content of custom.css
         */
        public function getCustomCSSFile(object $db, int $templateID): string
        {   // get the content from custom.css
            $filename = self::getCustomCSSFilename($db, "backend", $templateID);
            return file_get_contents($filename);
        }

        /**
         * @brief return the content of custom.js
         * @param object $db database
         * @param int $templateID affected template ID
         * @return string the content of custom.css
         */
        public function getCustomJSFile(object $db, int $templateID): string
        {   // get the content from custom.css
            $filename = self::getCustomJSFilename($db, "backend", $templateID);
            return file_get_contents($filename);
        }

        /**
         * @brief return filename of template css file
         * @param object $db database
         * @param string $location frontend or backend
         * @param int $templateID affected template ID
         * @return string the template's css filename, including path
         */
        public function getSettingsCSSFilename(object $db, string $location, int $templateID): string
        {
            /** @var $db \YAWK\db */
            // prepare vars... path + filename
            if (!isset($templateID) || (empty($templateID))) {
                $templateID = self::getCurrentTemplateId($db);
            }
            if (!isset($location) || (empty($location))) {
                $location = "Backend";
            }
            $tplName = self::getCurrentTemplateName($db, $location, $templateID); // tpl name
            $alias = "settings"; // set CSS file name
            $filename = "../system/templates/$tplName/css/" . $alias . ".css";
            return $filename;
        }

        /**
         * @brief return filename of custom css file
         * @param object $db database
         * @param string $location frontend or backend
         * @param int $templateID affected template ID
         * @return string the template's custom css filename, including path
         */
        public function getCustomCSSFilename(object $db, string $location, int $templateID): string
        {
            /** @var $db \YAWK\db */
            // prepare vars... path + filename
            $tplName = self::getCurrentTemplateName($db, $location, $templateID); // tpl name
            $alias = "custom"; // set CSS file name
            $filename = "../system/templates/$tplName/css/" . $alias . ".css";
            return $filename;
        }

        /**
         * @brief return filename of custom js file
         * @param object $db database
         * @param string $location frontend or backend
         * @param int    $templateID affected template ID
         * @return string the template's custom css filename, including path
         */
        public function getCustomJSFilename($db, $location, $templateID)
        {
            /** @var $db \YAWK\db */
            // prepare vars... path + filename
            $tplName = self::getCurrentTemplateName($db, $location, $templateID); // tpl name
            $alias = "custom"; // set JS file name
            $filename = "../system/templates/$tplName/js/" . $alias . ".js";
            return $filename;
        }


        /**
         * @brief return biggest ID from template database
         * @param object $db database
         * @return int|bool
         */
        public static function getMaxId($db)
        {
            /* @param $db \YAWK\db */
            if ($res = $db->query("SELECT MAX(id) from {templates}")) {   // fetch id
                if ($row = mysqli_fetch_row($res)) {
                    return $row[0];
                } else {
                    sys::setSyslog($db, 47, 1, "failed to get MAX(id) from template db", 0, 0, 0, 0);
                    return false;
                }
            } else {
                return false;
            }
        }

        /** delete template settings css file
         * @param object $db database
         * @param string $filename the filename (including path) you wish to delete
         * @return bool
         */
        function deleteSettingsCSSFile($db, $filename)
        {   // if no filename is given
            if (!isset($filename) || (empty($filename))) {   // set default filename
                $filename = self::getSettingsCSSFilename($db, '', '');
            }
            // we want the settings.css file to be overridden, so check if file exists and delete it if needed.
            if (file_exists($filename)) {   // if there is a file, delete it.
                if (!unlink($filename)) {   // delete failed, throw error
                    sys::setSyslog($db, 47, 1, "failed to delete file <b>$filename</b>", 0, 0, 0, 0);
                    alert::draw("danger", "Error!", "Failed to unlink $filename<br>Please delete this file and check file / folder / owner or group permissions!", "", 6200);
                    return false;
                } else {   // delete worked
                    return true;
                }
            } else {   // file does not exist
                sys::setSyslog($db, 47, 1, "failed to delete settings css file because it does not exist.", 0, 0, 0, 0);
                return true;
            }
        }

        /**
         * @brief update (save) template settings
         * @param object $db database
         * @param int    $id affected template ID
         * @param string $property template settings property
         * @param string $value template settings value
         * @return bool
         */
        function setTemplateSetting($db, $id, $property, $value, $longValue)
        {
            /** @var $db \YAWK\db */
            $property = $db->quote($property);
            $value = $db->quote($value);
            $longValue = $db->quote($longValue);
            $value = strip_tags($value);
            $longValue = strip_tags($longValue);
            if ($longValue === "1") {
                $sql = "SET longValue = '" . $value . "'";
            } else {
                $sql = "SET value = '" . $value . "'";
            }

            if ($res = $db->query("UPDATE {template_settings}
                                   $sql
                                   WHERE property = '" . $property . "'
                                   AND templateID = '" . $id . "'")
            ) {   // success
                return true;
            } else {   // q failed
                sys::setSyslog($db, 47, 1, "failed to set template #$id setting <b>$value</b> of <b>$property</b> ", 0, 0, 0, 0);
                return false;
            }
        }


        /**
         * @brief set template active
         * @param object $db database
         * @param int    $templateID affected template ID
         * @return bool
         */
        public static function setTemplateActive($db, $templateID)
        {
            /** @var $db \YAWK\db */
            if (!isset($templateID) && (empty($templateID))) {   // if template id is not set, get it from database
                $templateID = settings::getSetting($db, "selectedTemplate");
            }
            // null active template in table
            if (!$res = $db->query("UPDATE {templates} SET active = 0 WHERE active != 0")) {   // error: abort.
                return false;
            }
            if ($res = $db->query("UPDATE {templates}
                                   SET active = 1
                                   WHERE id = $templateID")
            ) {   // success
                return true;
            } else {   // q failed
                sys::setSyslog($db, 47, 1, "failed to set template #$templateID active ", 0, 0, 0, 0);
                return false;
            }

        }

        /**
         * @brief copy template settings into a new template
         * @param object $db database
         * @param int    $templateID template ID
         * @param int    $newID template ID
         */
        public static function copyTemplateSettings($db, $templateID, $newID)
        {
            /** @var $db \YAWK\db */

            $res = $db->query("INSERT INTO {template_settings} 
        (templateID, property, value, valueDefault, longValue, type, activated, sort, label, fieldClass, fieldType, 
        options, placeholder, description, icon, heading, subtext)
        SELECT '" . $newID . "', property, value, valueDefault, longValue, type, activated, sort, label, fieldClass, fieldType, 
        options, placeholder, description, icon, heading, subtext 
        FROM {template_settings} 
        WHERE templateID = '" . $templateID . "'");

            if (!$res) {
                sys::setSyslog($db, 47, 1, "failed to copy template settings of template #$templateID ", 0, 0, 0, 0);
                alert::draw("danger", "Could not copy settings", "please try again.", "", 5000);
            } else {
                alert::draw("success", "Settings copied", "successful", "", 5000);

                $update = $db->query("UPDATE {template_settings} SET templateID='" . $newID . "' WHERE templateID=0");
                if ($update) {
                    alert::draw("success", "Settings are set-up", "successful", "", 5000);
                } else {
                    sys::setSyslog($db, 47, 1, "failed to set new template settings of template #$templateID ", 0, 0, 0, 0);
                    alert::draw("warning", "Could not set new template settings", "unable to alter IDs.", "", 5000);
                }
            }
        }

        /**
         * @brief Add a new template setting to the database.
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
        /**
         * @param object $db
         * @param string $property
         * @param string $value
         * @param string $valueDefault
         * @param string $label
         * @param string $fieldclass
         * @param string $placeholder
         * @return bool
         */
        function addTemplateSetting($db, $property, $value, $valueDefault, $label, $fieldclass, $placeholder)
        {
            /** @var $db \YAWK\db */
            $active = 1;
            $sort = 0;
            $templateID = settings::getSetting($db, "selectedTemplate"); // self::getCurrentTemplateId($db);

            $property = $db->quote($property);
            $value = $db->quote($value);
            $valueDefault = $db->quote($valueDefault);
            $label = $db->quote($label);
            $fieldclass = $db->quote($fieldclass);
            $placeholder = $db->quote($placeholder);
            if ($res = $db->query("INSERT INTO {template_settings} (templateID, property, value, valueDefault, label, activated, sort, fieldClass, placeholder)
                                   VALUES('" . $templateID . "','" . $property . "', '" . $value . "', '" . $valueDefault . "', '" . $label . "', '" . $active . "', '" . $sort . "', '" . $fieldclass . "', '" . $placeholder . "')")
            ) {   // success
                return true;
            } else {   // q failed
                sys::setSyslog($db, 47, 1, "failed to add template setting $property:$value ", 0, 0, 0, 0);
                return false;
            }
        }

        /**
         * @brief set template details
         * @param object $db object database
         * @param string $description template description
         * @param string $author author name
         * @param string $authorUrl author URL
         * @param int    $id affected template ID
         * @return bool
         */
        public function setTemplateDetails($db, $description, $author, $authorUrl, $id)
        {
            /** @var $db \YAWK\db */
            if ($res = $db->query("UPDATE {templates} SET description = '" . $description . "', subAuthor = '" . $author . "', subAuthorUrl = '" . $authorUrl . "' WHERE id = '" . $id . "'")) {   // template details updated...
                return true;
            } else {   // could not save template details
                sys::setSyslog($db, 47, 1, "failed to set template details", 0, 0, 0, 0);
                return false;
            }
        }

        /**
         * @brief delete template
         * @param object $db database
         * @param int    $templateID template ID of the template you wish to delete
         * @return bool
         */
        static function deleteTemplate($db, $templateID)
        {
            /** @var $db \YAWK\db */
            if (!isset($templateID) && (empty($templateID)))
            {   // no templateID is set...
                sys::setSyslog($db, 47, 1, "failed to delete template because templateID was missing.", 0, 0, 0, 0);
                return false;
            }

            // quote var, just to be sure its clean
            $templateID = $db->quote($templateID);

            // to delete the files, we need to get the template folder's name
            // this function checks if template exits in database + if folder physically exists on disk
            $templateFolder = template::getCurrentTemplateName($db, "backend", $templateID);

            // check if template folder exists...
            if (is_dir(dirname(__dir__."../system/templates/".$templateFolder."")))
            {
                // delete template folder from disk
                if (!sys::recurseRmdir(__dir__."../system/templates/$templateFolder"))
                {   // booh, deleting recurse did not work
                    sys::setSyslog($db, 47, 1, "failed to delete recursive ../system/templates/$templateFolder", 0, 0, 0, 0);
                    return false;
                }
            }


            // delete template settings of requested templateID
            if (!$res = $db->query("DELETE FROM {template_settings} WHERE templateID = $templateID"))
            {   // delete settings failed...
                sys::setSyslog($db, 47, 1, "failed to delete template settings of ID: $templateID", 0, 0, 0, 0);
                return false;
            }

            // delete assets of requested templateID
            if (!$res = $db->query("DELETE FROM {assets} WHERE templateID = $templateID"))
            {   // delete settings failed...
                sys::setSyslog($db, 47, 1, "failed to delete template assets of ID: $templateID", 0, 0, 0, 0);
                return false;
            }

            // delete template from database {templates}
            if (!$res = $db->query("DELETE FROM {templates} WHERE id = $templateID"))
            {   // failed to delete from database
                sys::setSyslog($db, 47, 1, "failed to delete template ID: $templateID from database", 0, 0, 0, 0);
                return false;
            }
            else
            {
                // ALTER table and set auto_increment value to prevent errors when deleting + adding new tpl
                if ($res = $db->query("SELECT MAX(id) FROM {templates}"))
                {   // get MAX ID
                    $row = mysqli_fetch_row($res);
                    if (!$res = $db->query("ALTER TABLE {templates} AUTO_INCREMENT $row[0]"))
                    {   // could not select auto increment
                        sys::setSyslog($db, 47, 1, "failed alter auto increment templates table ", 0, 0, 0, 0);
                        return false;
                    }
                }
            }


            // all good - no false = template should be deleted
            return true;
        }


        /**
         * @brief Returns an array with all template settings.
         * @param object $db Database Object
         * @param object $user User Object
         * @return array|bool
         */
        public static function getAllSettingsIntoArray($db, $user) // get all settings from db like property
        {
            if (!isset($user) || empty($user))
            {
                $user = new user($db);
            }
            // get template settings
            if (isset($user))
            {   // get template settings for this user
                if ($user->overrideTemplate == 1) {
                    $sql = "SELECT ts.property, ts.value, ts.longValue, ts.valueDefault, ts.type, ts.label, ts.sort, ts.fieldClass, ts.fieldType, ts.placeholder, ts.description, ts.options, ts.activated, ts.icon, ts.heading, ts.subtext
                                       FROM {template_settings} ts
                                       JOIN {users} u on u.templateID = ts.templateID
                                       WHERE ts.activated = 1 && u.id = $user->id
                                       ORDER BY ts.sort";
                } else {
                    $sql = "SELECT ts.property, ts.value, ts.longValue, ts.valueDefault, ts.type, ts.label, ts.sort, ts.fieldClass, ts.fieldType, ts.placeholder, ts.description, ts.options, ts.activated, ts.icon, ts.heading, ts.subtext
                                       FROM {template_settings} ts
                                       JOIN {settings} s on s.value = ts.templateID
                                       WHERE ts.activated = 1 && s.property = 'selectedTemplate'
                                       ORDER BY ts.sort";
                }
            } else {
                sys::setSyslog($db, 47, 1, "failed to get template settings array - user is not set or empty", 0, 0, 0, 0);
                return false;
            }

            /* @param $db \YAWK\db */
            // if ($res= $db->query("SELECT * FROM {template_settings} ORDER by property"))
            if ($res = $db->query($sql)) {
                $settingsArray = array();
                while ($row = $res->fetch_assoc()) {   // fill array
                    $settingsArray[$row['property']] = $row;
                }
            } else {   // q failed, throw error
                sys::setSyslog($db, 5, 1, "failed to query template settings", 0, 0, 0, 0);
                // \YAWK\alert::draw("warning", "Warning!", "Fetch database error: getSettingsArray failed.","","4800");
                return false;
            }

            // check if array has been generated
            if (is_array($settingsArray) && (!empty($settingsArray))) {   // all good -
                return $settingsArray;
            } else {   // error generating settings array -
                return false;
            }
        }

        /**
         * @brief return div box with postition settings
         * @param object $db Database object
         * @param string $position The position to load
         * @param array  $positions Positions [enabled] status array
         * @param array  $indicators Positions [indicator] status array
         * @param object $user the current user object
         * @param object $template Template object
         */
        public static function getPositionDivBox($db, $lang, $position, $row, $bootstrapGrid, $positions, $indicators, $user, $template)
        {
            global $currentpage;
            if (isset($row) && (!empty($row))) {
                if ($row === "1") {
                    $startRow = "<div class=\"row\">";
                    $endRow = "</div>";
                } else {
                    $startRow = '';
                    $endRow = '';
                }
            } else {
                $startRow = '';
                $endRow = '';
            }

            // check if position indicator is enabled
            if ($positions["pos-$position-enabled"] === "1")
            {   // check if position indicator is enabled
                if ($indicators["pos-$position-indicator"] === "1")
                {   // display position indicator
                    $indicatorStyle = "style=\"border: 1px solid red;\"";
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
                template::setPosition($db, $lang, "$position-pos", $currentpage, $user, $template);
                echo "
                      </div>";
                echo "$endRow";
            }
        }


        /**
         * @brief return html form field, depending on fieldClass
         * @param object $db Database Object
         */
        public function getFormElements($db, $settings, $type, $lang, $user)
        {   // loop trough array
            // removed not needed checkup
            if (!isset($type) && (empty($type)))
            {    // if param 'type' is missing, set type 1 as default
                $type = 1;
            }
            if (!isset($settings) || (is_array($settings) === false))
            {
                echo 'Template settings are missing. Please re-install template.';
            }
            else
            {
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
                            // the description will be shown right beside the label
                            if (isset($setting['description']) && (!empty($setting['description'])))
                            {   // L11n
                                $setting['description'] = $lang[$setting['description']];
                                $setting['description'] = "&nbsp;<small><i class=\"fa fa-question-circle-o text-info\" data-placement=\"auto right\" data-toggle=\"tooltip\" title=\"$setting[description]\"></i></small>";
                            }

                            /* SELECT FIELD */
                            if ($setting['fieldType'] === "select")
                            {   // display icon, heading and subtext, if its set
                                if (!empty($setting['icon']) || (!empty($setting['heading']) || (!empty($setting['subtext']))))
                                {
                                    echo "<br><h4 class=\"box-title\">$setting[icon]&nbsp;$setting[heading]&nbsp;<small>$setting[subtext]</small></h4>";
                                }
                                // begin draw select
                                echo "<label for=\"$setting[property]\">$setting[label]&nbsp;$setting[description]&nbsp;
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
                                    $optionDesc = preg_replace('/.*,(.*)/', '$1', $value);
                                    $optionValue = preg_split("/,[a-zA-Z0-9]*/", $value);

                                    echo "<option value=\"$optionValue[0]\">$optionDesc</option>";
                                }
                                echo "</select>";
                            }

                            /* RADIO BUTTTONS */
                            else if ($setting['fieldType'] === "radio")
                            {
                                if (!empty($setting['icon']) || (!empty($setting['heading']) || (!empty($setting['subtext']))))
                                {
                                    echo "<br><h4 class=\"box-title\">$setting[icon]&nbsp;$setting[heading]&nbsp;<small>$setting[subtext]</small></h4>";
                                }
                                echo "<label for=\"$setting[property]\">$setting[label]&nbsp;$setting[description]&nbsp;</label>
                                  <input type=\"radio\" id=\"$setting[property]\" name=\"$setting[property]\">";
                                echo "<input type=\"radio\" value=\"$setting[value]\">$lang[SETTING_CURRENT] $setting[value]</option>";

                                // explode option string into array
                                $optionValues = explode(":", $setting['options']);
                                foreach ($optionValues as $value)
                                {
                                    // extract value from option setting string
                                    $optionValue = preg_replace("/,[a-zA-Z0-9]*/", "", $value);
                                    // extract description from option setting
                                    $optionDesc = preg_replace('/.*,(.*)/', '$1', $value);

                                    echo "<option value=\"$optionValue\">$optionDesc</option>";
                                }
                                echo "</select>";
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
                              <label for=\"$setting[property]\">&nbsp; $setting[label]&nbsp;$setting[description]&nbsp;</label>";
                            }

                            // CHECKBOX as toggle switch
                            else if ($setting['fieldType'] === "checkbox toggle")
                            {
                                // build a checkbox
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
                              <label for=\"$setting[property]\">&nbsp; $setting[label]&nbsp;$setting[description]&nbsp;</label><hr>";
                            }

                            /* TEXTAREA */
                            else if ($setting['fieldType'] === "textarea")
                            {    // if a long value is set
                                $placeholder = $setting['placeholder'];
                                // store placeholder from array in var to use it at language array
                                if (isset($setting['longValue']) && (!empty($setting['longValue'])))
                                {   // build a longValue tagged textarea and fill with longValue
                                    $setting['longValue'] = nl2br($setting['longValue']);
                                    if (!empty($setting['icon']) || (!empty($setting['heading']) || (!empty($setting['subtext']))))
                                    {
                                        echo "<h4 class=\"box-title\">$setting[icon]&nbsp;$setting[heading]&nbsp;<small>$setting[subtext]</small></h4>";
                                    }
                                    echo "<label for=\"$setting[property]\">$setting[label]&nbsp;$setting[description]&nbsp;</label>
                                      <textarea cols=\"64\" rows=\"4\" class=\"$setting[fieldClass]\" placeholder=\"$lang[$placeholder]\" id=\"$setting[property]\" name=\"$setting[property]\">$setting[longValue]</textarea>";
                                }
                                else
                                {   // draw default textarea
                                    $setting['value'] = nl2br($setting['value']);
                                    if (!empty($setting['icon']) || (!empty($setting['heading']) || (!empty($setting['subtext']))))
                                    {
                                        echo "<br><h4 class=\"box-title\">$setting[icon]&nbsp;$setting[heading]&nbsp;<small>$setting[subtext]</small></h4>";
                                    }
                                    echo "<label for=\"$setting[property]-long\">$setting[label]&nbsp;$setting[description]&nbsp;</label>
                                          <textarea cols=\"64\" rows=\"4\" class=\"$setting[fieldClass]\" placeholder=\"$lang[$placeholder]\" id=\"$setting[property]\" name=\"$setting[property]\">$setting[value]</textarea>";
                                }
                            }

                            /* INPUT PASSWORD FIELD */
                            else if ($setting['fieldType'] === "password")
                            {    // draw an input field
                                $placeholder = $setting['placeholder'];
                                // store placeholder from array in var to use it at language array
                                if (!empty($setting['icon']) || (!empty($setting['heading']) || (!empty($setting['subtext']))))
                                {
                                    echo "<br><h4 class=\"box-title\">$setting[icon]&nbsp;$setting[heading]&nbsp;<small>$setting[subtext]</small></h4>";
                                }
                                echo "<label for=\"$setting[property]\">$setting[label]</label>&nbsp;$setting[description]&nbsp;
                                  <input type=\"password\" class=\"$setting[fieldClass]\" id=\"$setting[property]\" name=\"$setting[property]\" 
                                  value=\"$setting[value]\" placeholder=\"$lang[$placeholder]\">";
                            }
                            /* INPUT TEXT FIELD */
                            else if ($setting['fieldType'] === "input")
                            {   // draw an input field
                                $placeholder = $setting['placeholder'];
                                // store placeholder from array in var to use it at language array
                                if (!empty($setting['icon']) || (!empty($setting['heading']) || (!empty($setting['subtext']))))
                                {
                                    echo "<br><h4 class=\"box-title\">$setting[icon]&nbsp;$setting[heading]&nbsp;<small>$setting[subtext]</small></h4>";
                                }
                                echo "<label for=\"$setting[property]\">$setting[label]&nbsp;$setting[description]&nbsp;
                                  <small><i class=\"small\" style=\"font-weight:normal\">$lang[DEFAULT]: $setting[valueDefault]</i></small></label>
                                  <input type=\"text\" class=\"$setting[fieldClass]\" id=\"$setting[property]\" name=\"$setting[property]\" 
                                  value=\"$setting[value]\" placeholder=\"$lang[$placeholder]\">";
                            }

                            /* COLOR TEXT FIELD */
                            else if ($setting['fieldType'] === "color")
                            {    // draw a color input field
                                $placeholder = $setting['placeholder'];     // store placeholder from array in var to use it at language array
                                if (!empty($setting['icon']) || (!empty($setting['heading']) || (!empty($setting['subtext']))))
                                {
                                    echo "<br><h4 class=\"box-title\">$setting[icon]&nbsp;$setting[heading]&nbsp;<small>$setting[subtext]</small></h4>";
                                }
                                echo "<label for=\"$setting[property]\">$setting[label]&nbsp;$setting[description]&nbsp;
                                  <small><i class=\"small\" style=\"font-weight:normal\">$lang[DEFAULT]: $setting[valueDefault]</i></small></label>
                                  <input type=\"text\" class=\"$setting[fieldClass]\" id=\"$setting[property]\" name=\"$setting[property]\" 
                                  value=\"$setting[value]\" placeholder=\"$lang[$placeholder]\">";
                            }

                            /* TEMPLATE SELECT FIELD */
                            else if ($setting['fieldType'] === "select template")
                            {   // display icon, heading and subtext, if its set

                                $templateArray = \YAWK\template::getTemplateIds($db);
                                if (!empty($setting['icon']) || (!empty($setting['heading']) || (!empty($setting['subtext']))))
                                {
                                    echo "<br><h4 class=\"box-title\">$setting[icon]&nbsp;$setting[heading]&nbsp;<small>$setting[subtext]</small></h4>";
                                }
                                // begin draw select
                                echo "<label for=\"$setting[property]\">$setting[label]&nbsp;$setting[description]&nbsp;
                                  <small><i class=\"small\" style=\"font-weight:normal\">$lang[DEFAULT]: $setting[valueDefault]</i></small></label>
                                  <select class=\"form-control\" id=\"$setting[property]\" name=\"$setting[property]\">";
                                $activeTemplateName = \YAWK\template::getTemplateNameById($db, $setting['value']);
                                echo "<option value=\"$setting[value]\">$lang[SETTING_CURRENT] $activeTemplateName</option>";
                                // explode option string into array
                                $optionValues = explode(":", $setting['options']);
                                foreach ($templateArray as $template)
                                {
                                    if ($setting['value'] != $template['id']) {
                                        echo "<option value=\"".$template['id']."\"".$markup.">".$template['name']."</option>";
                                    }
                                }
                                echo "</select>";
                            }
                            else
                            {
                                // draw an input field
                                $placeholder = $setting['placeholder'];
                                // store placeholder from array in var to use it at language array
                                if (!empty($setting['icon']) || (!empty($setting['heading']) || (!empty($setting['subtext']))))
                                {
                                    echo "<br><h4 class=\"box-title\">$setting[icon]&nbsp;$setting[heading]&nbsp;<small>$setting[subtext]</small></h4>";
                                }
                                if (!isset($lang[$placeholder]) ||(empty($lang[$placeholder]))){ $phMarkup = ""; } else { $phMarkup = " placeholder=\"$lang[$placeholder]\""; }
                                echo "<label for=\"$setting[property]\">$setting[label]&nbsp;$setting[description]&nbsp;
                                      <small><i class=\"small\" style=\"font-weight:normal\">$lang[DEFAULT]: $setting[valueDefault]</i></small></label>
                                      <input type=\"text\" class=\"$setting[fieldClass]\" id=\"$setting[property]\" name=\"$setting[property]\" 
                                             value=\"$setting[value]\"$phMarkup\">";
                            }
                        }
                    }
                }
            }
        }


        /**
         * @brief return font edit row including preview
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

            if ($fontRow === "globaltext" xor ($fontRow === "menufont")) {
                $col = 4;
            } else {
                $col = 2;
            }

            $FONT_ROW = strtoupper($fontRow);
            $labelFontSize = "TPL_" . $FONT_ROW . "_SIZE";
            $labelFontColor = "TPL_" . $FONT_ROW . "_COLOR";
            $labelSmallColor = "TPL_" . $FONT_ROW . "_SMALLCOLOR";


            // check if description is set
            // the description will be shown right beside the label as small info icon
            if (isset($templateSettings[$fontRowFontfamily]['description']) && (!empty($templateSettings[$fontRowFontfamily]['description']))) {   // L11n
                $fontRowFamilyDesc = $lang[$templateSettings[$fontRowFontfamily]['description']];
                $fontRowFamilyInfoBtn = "&nbsp;<small><i class=\"fa fa-question-circle-o text-info\" data-placement=\"auto right\" data-toggle=\"tooltip\" title=\"$fontRowFamilyDesc\"></i></small>";
            } else {
                $fontRowFamilyInfoBtn = '';
            }
            // check if font family default value is set
            if (isset($templateSettings[$fontRowFontfamily]['valueDefault']) && (!empty($templateSettings[$fontRowFontfamily]['valueDefault']))) {   // default values:
                $fontRowFamilyDefault = "<i class=\"h6 small\">default: " . $templateSettings[$fontRowFontfamily]['valueDefault'] . "</i>";
            } else {
                $fontRowFamilyDefault = '';
            }

            // check if font size is set
            if (isset($templateSettings[$fontRowSize]['valueDefault']) && (!empty($templateSettings[$fontRowSize]['valueDefault']))) {   // default values:
                $fontRowSizeDefault = "<i class=\"h6 small\">(" . $templateSettings[$fontRowSize]['valueDefault'] . ")</i>";
            } else {
                $fontRowSizeDefault = '';
            }

            $html = "
                <div class=\"col-md-$col\">
                    <div class=\"$previewClass\" id=\"$fontRow-preview\" style=\"height: auto; overflow:hidden; font-size: " . $templateSettings[$fontRowSize]['value'] . "; color: #" . $templateSettings[$fontRowColor]['value'] . ";\">$fontRow Heading</div>
               
                    <label for=\"$fontRowFontfamily\">$FONT_ROW $lang[TPL_FONTFAMILY] $fontRowFamilyInfoBtn</label>";
            $html .= $this->drawFontFamilySelectField($db, $lang, "$fontRowFontfamily", $templateSettings[$fontRowFontfamily]['value']);
            $html .= "
                
                    <label for=\"$fontRowSize\">$lang[$labelFontSize] $fontRowSizeDefault</label>
                    <input id=\"$fontRowSize\" name=\"$fontRowSize\" value=\"" . $templateSettings[$fontRowSize]['value'] . "\" class=\"form-control\">
                
                    <label for=\"$fontRowColor\">$lang[$labelFontColor]</label>
                    <input id=\"$fontRowColor\" name=\"$fontRowColor\" class=\"form-control color\" value=\"" . $templateSettings[$fontRowColor]['value'] . "\">
               
                    <label for=\"$fontRowFontShadowSize\">$lang[TPL_FONTSHADOWSIZE]</label>
                    <input id=\"$fontRowFontShadowSize\" name=\"$fontRowFontShadowSize\" class=\"form-control\" value=\"" . $templateSettings[$fontRowFontShadowSize]['value'] . "\" placeholder=\"2px 2px\">
                
                    <label for=\"$fontRowFontShadowColor\">$lang[TPL_FONTSHADOWCOLOR]</label>
                    <input id=\"$fontRowFontShadowColor\" name=\"$fontRowFontShadowColor\" value=\"" . $templateSettings[$fontRowFontShadowColor]['value'] . "\" class=\"form-control color\">
                
                    <label for=\"$fontRowFontWeight\">$lang[TPL_FONTWEIGHT]</label>
                    <select id=\"$fontRowFontWeight\" name=\"$fontRowFontWeight\" class=\"form-control\">";

            $fontweightStyles = array("normal", "bold", "bolder", "lighter", "100", "200", "300", "400 [normal]", "500", "600", "700 [bold]", "800", "900", "initial", "inherit");
            foreach ($fontweightStyles as $weight) {
                $currentFontWeight = "$fontRow-fontweight";
                if ($weight === $templateSettings[$currentFontWeight]['value']) {
                    $selected = "selected aria-selected=\"true\"";
                } else {
                    $selected = '';
                }
                $html .= "<option value=\"$weight\" $selected>$weight</option>";
            }
            $html .= "</select>
                
                    <label for=\"$fontRowFontStyle\">$lang[TPL_FONTSTYLE]</label>
                    <select id=\"$fontRowFontStyle\" name=\"$fontRowFontStyle\" class=\"form-control\">";

            $fontStyles = array("normal", "italic", "oblique", "initial", "inherit");
            foreach ($fontStyles as $style) {
                $currentFontStyle = "$fontRow-fontstyle";
                if ($style === $templateSettings[$currentFontStyle]['value']) {
                    $selected = "selected aria-selected=\"true\"";
                } else {
                    $selected = '';
                }
                $html .= "<option value=\"$style\" $selected>$style</option>";
            }

            $html .= "</select>
                
                    <label for=\"$fontRowTextdecoration\">$lang[TPL_TEXTDECORATION]</label>
                    <select id=\"$fontRowTextdecoration\" name=\"$fontRowTextdecoration\" class=\"form-control\">";

            $textdecorationTypes = array("none", "underline", "overline", "line-through", "intial", "inherit");
            foreach ($textdecorationTypes as $decoration) {
                $currentFontDecoration = "$fontRow-textdecoration";
                if ($decoration === $templateSettings[$currentFontDecoration]['value']) {
                    $selected = "selected aria-selected=\"true\"";
                } else {
                    $selected = '';
                }
                $html .= "<option value=\"$decoration\" $selected>$decoration</option>";
            }
            $html .= "</select>";

            // LINK SETTINGS START HERE
            $html .= "

                    <label for=\"$fontRowLinkTextDecoration\">$lang[TPL_LINK_TEXTDECORATION]</label>
                    <select id=\"$fontRowLinkTextDecoration\" name=\"$fontRowLinkTextDecoration\" class=\"form-control\">";

            foreach ($textdecorationTypes as $decoration) {
                $currentLinkTextDecoration = "$fontRow-linktextdecoration";
                if ($decoration === $templateSettings[$currentLinkTextDecoration]['value']) {
                    $selected = "selected aria-selected=\"true\"";
                } else {
                    $selected = '';
                }
                $html .= "<option value=\"$decoration\" $selected>$decoration</option>";
            }
            $html .= "</select>
                        <label for=\"$fontRow-alink\">$lang[TPL_LINK_COLOR]</label>
                        <input id=\"$fontRow-alink\" name=\"$fontRow-alink\" value=\"" . $templateSettings[$fontRowALinkColor]['value'] . "\" class=\"form-control color\">
                   
                        <label for=\"$fontRow-avisited\">$lang[TPL_LINK_VISITED_COLOR]</label>
                        <input id=\"$fontRow-avisited\" name=\"$fontRow-avisited\" value=\"" . $templateSettings[$fontRowAVisitedColor]['value'] . "\" class=\"form-control color\"> 
                    
                        <label for=\"$fontRow-ahover\">$lang[TPL_LINK_HOVER_COLOR]</label>
                        <input id=\"$fontRow-ahover\" name=\"$fontRow-ahover\" value=\"" . $templateSettings[$fontRowAHoverColor]['value'] . "\" class=\"form-control color\"> 
                   
                    <label for=\"$fontRowLinkFontWeight\">$lang[TPL_LINK_TEXTDECORATION]</label>
                        <select id=\"$fontRowLinkFontWeight\" name=\"$fontRowLinkFontWeight\" class=\"form-control\">";

            foreach ($fontweightStyles as $weight) {
                $currentLinkFontWeight = "$fontRow-linkfontweight";
                if ($weight === $templateSettings[$currentLinkFontWeight]['value']) {
                    $selected = "selected aria-selected=\"true\"";
                } else {
                    $selected = '';
                }
                $html .= "<option value=\"$weight\" $selected>$weight</option>";
            }
            $html .= "</select>
               
                    <label for=\"$fontRowLinkFontStyle\">$lang[TPL_LINK_FONTSTYLE]</label>
                    <select id=\"$fontRowLinkFontStyle\" name=\"$fontRowLinkFontStyle\" class=\"form-control\">";

            foreach ($fontStyles as $style) {
                $currentLinkFontStyle = "$fontRow-linkfontstyle";
                if ($style === $templateSettings[$currentLinkFontStyle]['value']) {
                    $selected = "selected aria-selected=\"true\"";
                } else {
                    $selected = '';
                }
                $html .= "<option value=\"$style\" $selected>$style</option>";
            }

            $html .= "</select>
                    <label for=\"$fontRowHoverTextDecoration\">$lang[TPL_HOVER_TEXTDECORATION]</label>
                    <select id=\"$fontRowHoverTextDecoration\" name=\"$fontRowHoverTextDecoration\" class=\"form-control\">";

            foreach ($textdecorationTypes as $decoration) {
                $currentFontDecoration = "$fontRow-hovertextdecoration";
                if ($decoration === $templateSettings[$currentFontDecoration]['value']) {
                    $selected = "selected aria-selected=\"true\"";
                } else {
                    $selected = '';
                }
                $html .= "<option value=\"$decoration\" $selected>$decoration</option>";
            }
            $html .= "</select>";


            // SMALL TAG COLOR
            $html .= "<label for=\"$fontRowSmallColor\">$lang[TPL_SMALLCOLOR]</label>
                    <input id=\"$fontRowSmallColor\" name=\"$fontRowSmallColor\" class=\"form-control color\" value=\"" . $templateSettings[$fontRowSmallColor]['value'] . "\">";

            // SMALL TAG SHADOW SIZE
            $html .= "<label for=\"$fontRowSmallShadowSize\">$lang[TPL_SMALLSHADOWSIZE]</label>
                    <input id=\"$fontRowSmallShadowSize\" name=\"$fontRowSmallShadowSize\" class=\"form-control\" value=\"" . $templateSettings[$fontRowSmallShadowSize]['value'] . "\" placeholder=\"2px 2px\">";
            // SMALL TAG SHADOW COLOR
            $html .= "<label for=\"$fontRowSmallShadowColor\">$lang[TPL_SMALLSHADOWCOLOR]</label>
                    <input id=\"$fontRowSmallShadowColor\" name=\"$fontRowSmallShadowColor\" value=\"" . $templateSettings[$fontRowSmallShadowColor]['value'] . "\" class=\"form-control color\">";

            // end font div box
            $html .= "
            </div>";

            echo $html;

        }

        /**
         * @brief get fonts from folder and return as array
         * @param string $folder folder that helds all fonts (usually ../system/fonts/)
         * @return string | array
         */
        static public function getFontsFromFolder($folder)
        {
            // if no folder is given
            if (!isset($folder) || (empty($folder))) {   // set default folder
                $folder = '../system/fonts/';
            } else {
                // make sure that there is a slash at the end
                $folder = rtrim($folder, '/') . '/';
                // check if folder is a directory
                if (!is_dir($folder)) {   // if not, abort
                    return "Folder <b>$folder</b> is not a valid folder";
                }
            }

            // create new font array
            $fontArray = array();
            // create new directory iterator
            $iterator = new \DirectoryIterator($folder);
            // walk through folder
            foreach ($iterator as $file) {
                // exclude dots
                if (!$file->isDot()) {   // check filetype
                    if ($file->getExtension() === "ttf") {   // add ttf fonts to array
                        $fontArray['ttf'][] = $file->getFilename();
                    }
                    // check filetype
                    if ($file->getExtension() === "otf") {   // add otf fonts to array
                        $fontArray['otf'][] = $file->getFilename();
                    }
                    // check filetype
                    if ($file->getExtension() === "woff") {   // add woff fonts to array
                        $fontArray['woff'][] = $file->getFilename();
                    }
                    // check filetype
                    if ($file->getExtension() === "WOFF") {   // add woff fonts to array
                        $fontArray['woff'][] = $file->getFilename();
                    }
                }
            }
            // check if font array is set and not empty
            if (is_array($fontArray) && (!empty($fontArray))) {   // all good
                return $fontArray;
            } else {   // array not set or empty, throw message
                return "No fonts found in $folder";
            }
        }

        /**
         * @brief get setting from database and draw input field
         * @param object $db database
         * @param string $filter filter the search result (eg. all field w %-color)
         * @param string $special could be a slider *OUTDATED
         * @param string $readonly "readonly" if the field should be this way
         * @param object $user the current user object
         * @return bool
         */
        function getSetting($db, $filter, $special, $readonly, $user)
        {
            /** @var $db \YAWK\db */
            // build sql query string
            // to build the template-settings page correct within one function
            // the query string will be manipulated like
            if ($filter != '%-color') {   // don't fetch -color settings
                $sql = "&& ts.property NOT RLIKE '.*-color'";
            }
            if ($filter != '%-bgcolor') {   // don't fetch -bgcolor settings
                $sql = "&& ts.property NOT RLIKE '.*-bgcolor'";
            } else {
                $sql = '';
            }

            if (isset($readonly)) {   // if any field should be readonly
                switch ($readonly) {   // set html code
                    case "readonly":
                        $readonly = "readonly=\"readonly\"";
                        break;
                    default:
                        $readonly = '';
                        break;
                }
            }
            // OVERRIDE SETTINGS
            if (isset($user)) {
                if ($user->overrideTemplate == 1) {
                    $sql = "SELECT ts.property, ts.value, ts.longValue, ts.valueDefault, ts.label, ts.fieldClass, ts.placeholder
                                       FROM {template_settings} ts
                                       JOIN {users} u on u.templateID = ts.templateID
                                       WHERE ts.activated = 1 && u.id = $user->id && ts.property
                                       LIKE '$filter' && ts.property NOT RLIKE '.*-pos' $sql ORDER BY ts.sort";
                } else {
                    $sql = "SELECT ts.property, ts.value, ts.longValue, ts.valueDefault, ts.label, ts.fieldClass, ts.placeholder
                                       FROM {template_settings} ts
                                       JOIN {settings} s on s.value = ts.templateID
                                       WHERE ts.activated = 1 && s.property = 'selectedTemplate' && ts.property
                                       LIKE '$filter' && ts.property NOT RLIKE '.*-pos' $sql ORDER BY ts.sort";
                }
            } else {
                sys::setSyslog($db, 47, 1, "failed to get template setting - user is not set or empty.", 0, 0, 0, 0);
                return false;
            }

            if ($res = $db->query($sql)) {
                $x = 1; // <h> tags count var
                // draw input fields / template-settings.php
                while ($row = mysqli_fetch_assoc($res)) {   // fetch template settings in loop
                    $property = $row['property'];
                    $value = $row['value'];
                    // $property = substr("$property", 0, -4);
                    // echo  "<label for=\"".$row['property']."\">" . $row['description'] . "</label><br>";

                    if ($filter == "h%-fontsize") {   // case <h> fontsize
                        // draw a textfield
                        echo "<div style=\"display:inline-block;\"><label for=\"" . htmlentities($row['property']) . "\">";
                        echo "<legend>";
                        echo "<input type=\"text\" id=\"h" . $x . "-fontsize\" class=\"form-control\" name=\"" . htmlentities($row['property']) . "\" value=\"" . htmlentities($row['value']) . "\" />";
                        echo "<div id=\"slider$x\"></legend></div>";
                        $x++;
                    }
                    if (fnmatch('*-longValue', $filter)) {
                        // draw a textfield
                        echo "<label for=\"" . $row['property'] . "\"><small>" . $row['label'] . " <i class=\"h6 small\">default: " . $row['valueDefault'] . "</i></small></label><br>";
                        echo "<div style=\"display:inline-block; width:90%;\"><label for=\"" . htmlentities($row['property']) . "\">";
                        echo "<input type=\"hidden\" name=\"$row[property]-long\" id=\"longValue\" value=\"1\">";
                        echo "<textarea cols=\"85\" rows=\"12\" id=\"" . $row['property'] . "\" $readonly class=\"form-control\" style=\"font-weight:normal;\" name=\"" . htmlentities($row['property']) . "\">" . $row['longValue'] . "</textarea>";
                    } else {   // draw a textfield
                        echo "<label for=\"" . $row['property'] . "\"><small>" . $row['label'] . " <i class=\"h6 small\">default: " . $row['valueDefault'] . "</i></small></label><br>";
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

                    if ($special == "slider") {   // set slider html
                        // if method is called with slider parameter, draw one with given property name
                        echo "<div id=\"slider-";
                        echo $row['property'];
                        echo "\"></div>";
                    }
                    echo "</div></label>";
                }
            } else {   // q failed
                sys::setSyslog($db, 47, 1, "failed to query template setting ", 0, 0, 0, 0);
                return false;
            }
            // all good, fin
            return true;
        }

        /* END FUNCTION YAWK\settings::getSetting */

        /**
         * @brief return a select option list with all fonts:
         * @details <ul>
         * <li>system default fonts</li>
         * <li>own true type fonts from system/fonts</li>
         * <li>google fonts from database: gfonts</li>
         * </ul>
         * @param object $db database
         * @param string $selectName selectName
         * @param array  $lang language array
         */
        public function drawFontFamilySelectField($db, $lang, $selectName, $defaultValue)
        {
            if (isset($defaultValue) && (!empty($defaultValue))) {
                $defaultValueOption = "<option value=\"$defaultValue\" selected aria-selected=\"true\">$defaultValue</option>";
            } else {
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

            foreach ($dir as $item) {
                if (!$item->isDot()
                    && (!$item->isDir())
                ) {
                    // workaround: todo what about filenames with spaces?
                    // check if it is a true type file
                    if (strtolower(substr($item, -3)) === "ttf") {
                        // workaround: if dots are in there, the form does not work.
                        // so lets change the dots to '-' and let option pass trough
                        $item = str_replace(".", "-", $item);
                        // add ttf font to array
                        $ttfFonts[] = "<option value=\"$item\">&nbsp;&nbsp;$item</option>";
                    }
                    // check if it is a otf file
                    if (strtolower(substr($item, -3)) === "otf") {
                        $item = str_replace(".", "-", $item);
                        // add option to select field
                        $otfFonts[] = "<option value=\"$item\">&nbsp;&nbsp;$item</option>";
                    }
                    // check if it is a woff file
                    if (strtolower(substr($item, -4)) === "woff") {
                        // workaround: change dots to '-' to let option pass trough
                        $item = str_replace(".", "-", $item);
                        // add option to select field
                        $woffFonts[] = "<option value=\"$item\">&nbsp;&nbsp;$item</option>";
                    }
                }
            }

            // add .ttf fonts to select option
            $selectField .= "<optgroup label=\"True Type Fonts (system/fonts/*.ttf)\"></optgroup>";
            foreach ($ttfFonts as $ttfFont) {   // add ttf option to select field
                $selectField .= $ttfFont;
            }
            // add .otf fonts to select option
            $selectField .= "<optgroup label=\"Open Type Fonts (system/fonts/*.otf)\"></optgroup>";
            foreach ($otfFonts as $otfFont) {   // add ttf option to select field
                $selectField .= $otfFont;
            }
            // add .woff fonts to select option
            $selectField .= "<optgroup label=\"Web Open Font Format (system/fonts/*.woff)\"></optgroup>";
            foreach ($woffFonts as $woffFont) {   // add ttf option to select field
                $selectField .= $woffFont;
            }


            // fill google fonts array
            $googleFonts = $this->getGoogleFontsArray($db);
            // add google fonts to select option
            $selectField .= "<optgroup label=\"Google Fonts\"></optgroup>";
            foreach ($googleFonts as $gFont) {
                // add google font option to select field
                // add option to select field
                $selectField .= "<option value=\"$gFont-gfont\">&nbsp;&nbsp;$gFont (Google Font)</option>";
            }
            // close select option
            $selectField .= "</select>";

            // finally: output the html code of this select field
            return $selectField;
        }

        /**
         * @brief get all google fonts into an array and return array
         * @param object $db database
         * @return array | null
         *
         */
        public static function getGoogleFontsArray($db)
        {
            // array that holds the data
            $googleFonts = array();
            // select google fonts from database
            if ($sql = $db->query("SELECT font FROM {gfonts} ORDER BY font")) {   // for every single row...
                while ($row = mysqli_fetch_array($sql)) {   // add font to array
                    $googleFonts[] = $row['0'];
                }
            }
            // check if googleFont is set and an array and not empty
            if (isset($googleFonts) && (is_array($googleFonts) && (!empty($googleFonts)))) {   // return array containing all google fonts
                return $googleFonts;
            } else {   // no google font in database...
                return null;
            }
        }

        /**
         * @brief return a radio list of all registered google fonts
         * @param object $db database
         * @param string $item the font
         * @param array  $lang language array
         * @return bool
         */
        function getgFonts($db, $item, $lang)
        {
            /** @var $db \YAWK\db */
            $nc = '';
            $gfontID = '';
            // query fonts
            if ($res = $db->query("SELECT ts.property, ts.value, ts.description
                                              FROM {template_settings} ts
                                              JOIN {settings} s on s.value = ts.templateID
                                              WHERE ts.activated = 1 && s.property = 'selectedTemplate' && ts.property = '$item'
                                              ORDER BY sort")
            ) {
                // draw radio buttons in loop...
                while ($row = mysqli_fetch_assoc($res)) {
                    $gfontID = $row['value'];
                    if ($gfontID === '0') {   // checked
                        $nc = "checked=\"checked\"";
                    } else {   // not checked
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
                  ORDER BY font")
                ) {
                    while ($row = mysqli_fetch_array($res)) {
                        //  test output:
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
<input type=\"radio\" $checked name=\"" . $item . "\" value=\"$id\">
| <span style=\"font-family:$row[1]; font-size:18px;\">$description</span>
<hr></div>";
                    } // ./ end while
                } else {   // fetch loop failed
                    return false;
                }
                echo "</div>";
            } else {   // q failed;
                sys::setSyslog($db, 47, 1, "failed to get google fonts from database ", 0, 0, 0, 0);
                return false;
            }
            // fin
            return true;
        } // ./ function getgFonts


        /**
         * @brief delete google font with requested ID
         * @param object $db database
         * @param int    $gfontid google font ID you wish to delete
         * @param string $gfont google font (name) you wish to delete
         * @return bool
         */
        public static function deleteGfont($db, $gfontid, $gfont)
        {
            /** @var $db \YAWK\db */

            // no google font ID was sent
            if (!isset($gfontid) || (empty($gfontid))) {   // check if google font name was sent
                if (isset($gfont) && (!empty($gfont))) {
                    // try to delete google font by name
                    if ($res = $db->query("DELETE from {gfonts}
                             WHERE font LIKE '%" . $gfont . "%'")
                    ) {   // success
                        return true;
                    } else {   // q failed
                        sys::setSyslog($db, 47, 1, "failed to delete google font ID: $gfontid ", 0, 0, 0, 0);
                        return false;
                    }
                }
            } else {   // delete google font by ID
                if ($res = $db->query("DELETE from {gfonts}
                             WHERE id = '" . $gfontid . "'")
                ) {   // success
                    return true;
                } else {   // q failed
                    sys::setSyslog($db, 47, 1, "failed to delete google font ID: $gfontid ", 0, 0, 0, 0);
                    return false;
                }
            }
            return false;
        }

        /**
         * @brief add google font to database
         * @param object $db database
         * @param string $gfont name of the google font you wish to add
         * @param string $description any description for the font (eg. YourFont, cursive)
         * @return bool
         */
        public static function addgfont($db, $gfont, $description)
        {
            /** @var $db \YAWK\db */
            if (empty($gfont)) {   // no font was sent
                return false;
            }
            if (empty($description)) {   // no description was sent
                return false;
            }
            $gfont = $db->quote($gfont);
            $description = $db->quote($description);
            // ## select max ID from gfonts
            if ($res = $db->query("SELECT MAX(id) FROM {gfonts}")) {   // fetch data
                $row = mysqli_fetch_row($res);
                $id = $row[0] + 1;
                if ($res = $db->query("INSERT INTO {gfonts} (id, font, description)
                                       VALUES('" . $id . "', '" . $gfont . "', '" . $description . "')")
                ) {   // success
                    return true;
                } else {   // fetch failed
                    sys::setSyslog($db, 47, 1, "failed to insert new google font to database", 0, 0, 0, 0);
                    return false;
                }
            } else {   // q failed
                sys::setSyslog($db, 47, 1, "failed to get MAX(id) from google fonts database", 0, 0, 0, 0);
                return false;
            }
        }

        /**
         * @brief set css code for custom fonts (ttf / otf / woff)
         * @param $cssTagName
         * @param $tplSettings
         * @return string
         */
        static function setCssBodyFontFace($cssTagName, $tplSettings)
        {
            $bodyFontFaceCSS = '';
            $fontFamily = $tplSettings["$cssTagName-fontfamily"];
            // get font type by cutting off file extension
            $fontType = substr($fontFamily, -4);
            // check file types
            if ($fontType === "-ttf") {
                $filename = str_replace("-ttf", ".ttf", $fontFamily);
                $bodyFontFaceCSS = "@font-face {
                font-family: $fontFamily;
                src: url('../../../fonts/$filename');
                }";
            } elseif ($fontType === "-otf") {
                $filename = str_replace("-otf", ".otf", $fontFamily);
                $bodyFontFaceCSS = "@font-face {
                font-family: $fontFamily;
                src: url('../../../fonts/$filename');
                }";
            } elseif ($fontType === "woff") {
                $filename = str_replace("-woff", ".woff", $fontFamily);
                $bodyFontFaceCSS = "@font-face {
                font-family: $fontFamily;
                src: url('../../../fonts/$filename') !important;
                }";
            }
            return $bodyFontFaceCSS;
        }

        /**
         * @brief  set css code for body link styling
         * @param $cssTagName
         * @param $tplSettings
         * @return string
         */
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

        /**
         * @brief set small font settings css code
         * @param $cssTagName
         * @param $tplSettings
         * @return string
         */
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

        /**
         * @brief set body font settings css code
         * @param $cssTagName
         * @param $tplSettings
         * @return string
         */
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
            if (substr($fontFamily, -6) === "-gfont") {
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
            } else {
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

        /**
         * @brief set font settings css code
         * @param $cssTagName
         * @param $tplSettings
         * @return string
         */
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
            if ($fontType === "-ttf") {
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
            } elseif ($fontType === "-otf") {
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
            } elseif ($fontType === "woff") {
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
            } // check, if it's a google font
            elseif (substr($fontFamily, -6) === "-gfont") {
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
            } else {
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

        /**
         * @brief Get and return current active google font
         * @param $db
         * @return string
         */
        static function getActiveBodyFont($db, $user, $template)
        {
            /* @var \YAWK\db $db */
            $bodyFont = template::getTemplateSetting($db, "value", "globaltext-fontfamily", $user, $template);
            $bodyFontFamily = "font-family: $bodyFont";
            return $bodyFontFamily;
        }

        /**
         * @brief return currently active google font
         * @param object $db database
         * @param string $status the url or font name
         * @param string $property affected settings property
         * @return null|string
         */
        static function getActivegfont($db, $status, $property)
        {
            /* @var \YAWK\db $db */
            if ($res = $db->query("SELECT id, font, setting
                     FROM {gfonts}
                     WHERE activated = 1
                      AND id = (SELECT ts.value
                      FROM {template_settings} ts
                      JOIN {settings} s on s.value = ts.templateID
                      WHERE ts.activated = 1 && s.property = 'selectedTemplate' && ts.property = '$property')")
            ) {
                while ($row = mysqli_fetch_array($res)) {
                    // if no google font is selected
                    if ($row[1] === "0") {
                        return "font-family: Arial";
                    }
                    // css include output for index.php
                    if ($status == "url") {//
                        if (isset($row[2]) || (!empty($row[2]))) {
                            return "
<link rel=\"stylesheet\" href=\"http://fonts.googleapis.com/css?family=$row[1]:$row[2]\" type=\"text/css\" media=\"all\">";
                        } else {
                            return "
<link rel=\"stylesheet\" href=\"http://fonts.googleapis.com/css?family=$row[1]\" type=\"text/css\" media=\"all\">";
                        }
                    } else {
                        return "font-family: $row[1];";
                    }
                }
            } else {   // could not get active google font
                return "could not get active google font";
            }
            return null;
        }

        /**
         * @brief get settings for heading, menu and text font and output html to load font
         * @param object $db database
         */
        // TODO: OUTDATED AFTER REFACTORING...
        static function loadGoogleFonts($db)
        {
            $fonts = array(); // hold all fonts
            $googleFontFamilyString = ''; // the string the contains all google font families to minimize requests
            if ($sql = $db->query("SELECT value FROM {template_settings} WHERE property LIKE '%-fontfamily'")) {
                while ($row = mysqli_fetch_row($sql)) {
                    $fonts[] = $row[0];
                }
            }
            foreach ($fonts as $googleFont) {
                if (substr($googleFont, -6) === "-gfont") {
                    // remove font indicator
                    $googleFont = rtrim($googleFont, "gfont");
                    $googleFont = rtrim($googleFont, "-");
                    // build google font loading string
                    $googleFontFamilyString .= $googleFont;
                    // add | to allow loading more than one font
                    $googleFontFamilyString .= "|";
                }
            }
            if (!empty($googleFontFamilyString)) {
                // remove last | because its not needed
                $googleFontFamilyString = rtrim($googleFontFamilyString, "|");
                echo "<link href=\"https://fonts.googleapis.com/css?family=$googleFontFamilyString\" rel=\"stylesheet\">";
            }

        }

        /**
         * @brief get any template setting from database
         * @param object $db database
         * @param string $field the setting (field) to get
         * @param string $property the property to get
         * @return bool
         */
        static function getTemplateSetting($db, $field, $property, $user, $template)
        {   /** @var $db \YAWK\db */

            // to ensure, we get the setting of the correct template get a valid template ID
            $validTemplateID = template::getValidTemplateID($db, $user, $template);

            // query the template setting
            if ($row = $db->query("SELECT $field
                          FROM {template_settings}
                            WHERE property = '" . $property . "'
                            AND templateID = '" . $validTemplateID . "'"))
            {   // fetch data
                $res = mysqli_fetch_row($row);
                if (!empty($res))
                {   // return valid template ID
                    return $res[0];
                }
                else
                {
                    return false;
                }
            }
        }

        /**
         * @brief check the current template ID, considering if user is logged in, allowed to override template and so on
         * @param object $db database
         * @param object $user the current user object
         * @param object $template the current page object
         * @return int
         */
        static function getValidTemplateID($db, $user, $template)
        {
            // it is important to do some checks to determine the correct template id
            // to do that, we need data from 2 objects;

            // check if template and user obj are there and not empty
            if (isset($user) && (isset($template)))
            {   // check, if user is allowed to override template

                if ($user->overrideTemplate == 1)
                {   // ok, get user templateID
                    if (!empty($user->templateID))
                    {   // set templateID for following query
                        $validTemplateID = $user->templateID;
                    }
                    else
                    {   // user->TemplateID not set, instead use default template
                        if (!empty($template->selectedTemplate))
                        {   // set global defined (current active), default template ID
                            $validTemplateID = $template->selectedTemplate;
                        }
                    }
                }
                else
                {   // user is not allowed to override template, use default template
                    if (!empty($template->selectedTemplate))
                    {   // set global defined (current active), default template ID
                        $validTemplateID = $template->selectedTemplate;
                    }
                }
            }
            else
            {   // unable to determine template from objects, load active (global) template instead
                $validTemplateID = settings::getSetting($db, "selectedTemplate");
            }
            // for any reasons, that valid template ID could not be set
            if (!isset($validTemplateID) || (empty($validTemplateID)))
            {   // set current (active / selected) template as templateID
                $validTemplateID = settings::getSetting($db, "selectedTemplate");
            }
            // must be set
            return $validTemplateID;
        }

        /**
         * @brief include header for html page *outdated? *moved to sys?
         * @param object $db database
         */
        static function includeHeader($db)
        {
            /** @param \YAWK\db $db */
            global $currentpage;
            $i = 1;
            $host = settings::getSetting($db, "host");
            echo "<title>" . $currentpage->title . "</title>
      <meta http-equiv=\"Content-Type\" content=\"text/html; charset=\"utf-8\">
      <link rel=\"shortcut icon\" href=\"favicon.ico\" type=\"image/x-icon\">
      <base href=\"" . $host . "/\">";
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
         * @brief get the position states of all templates. This is used on index.php to render only templates that are enabled (1)
         * @param object $db database
         * @param int    $templateID ID of the current selected template
         * @return array|bool $array template positions 0|1
         */
        static function getPositionStatesArray($db, $templateID)
        {
            $array = array();
            $sql = $db->query("SELECT property, value 
                               FROM {template_settings} 
                               WHERE property LIKE 'pos-%-enabled' AND 
                               templateID = '" . $templateID . "'");
            while ($row = mysqli_fetch_assoc($sql)) {
                $prop = $row['property'];
                $array[$prop] = $row['value'];
            }
            if (is_array($array) && (!empty($array))) {
                return $array;
            } else {
                die("Positions array not set");
            }
        }

        /**
         * @brief get the position indicators. This is used on index.php to mark indicated positions
         * @param object $db database
         * @param int    $templateID ID of the current template
         * @return array|bool $array position indicator 0|1
         */
        static function getPositionIndicatorStatusArray($db, $templateID)
        {
            $markedPositions = array();
            $sql = $db->query("SELECT property, value 
                               FROM {template_settings} 
                               WHERE property 
                               LIKE 'pos-%-indicator'
                               AND templateID = '" . $templateID . "'");
            while ($row = mysqli_fetch_assoc($sql)) {
                $prop = $row['property'];
                $markedPositions[$prop] = $row['value'];
            }
            if (!empty($markedPositions)) {
                return $markedPositions;
            } else {
                return false;
            }
        }

        /**
         * @brief set template position and output the correct data depending on position
         * @param object $db database
         * @param object $user the current user object
         * @param string $position the template position
         * @param object $template template object
         */
        static function setPosition($db, $lang, $position, $currentpage, $user, $template)
        {
            $main_set = 0;
            $globalmenu_set = 0;
            // get template setting for given pos
            // $setting = self::getTemplateSetting($db, $position, "");
            if (empty($setting)) {
                // no property
                // substr, because css definitions are without -pos (changefix?!)
                $position = substr("$position", 0, -4);
                // if main, we need to include the content page
                if ($position == "main") {
                    // if user is given to index.php, load userpage
                    if (isset($_GET['user'])) {
                        // if var is set, but empty, show all users
                        if (empty($_GET['user'])) {
                            echo "<h2>Show all users</h2>";
                            user::getUserList($db);
                        } else {
                            // show userpage
                            echo "<h2>Show Profile of user $_GET[user]</h2>";
                        }
                    } // if a blog is requested, load blog by given id
                    elseif (isset($_GET['blogid'])) {
                        $blog = new \YAWK\PLUGINS\BLOG\blog();
                        $blog->limitEntries = $blog->getBlogProperty($db, $_GET['blogid'], "limitEntries");
                        $blog->getFrontendEntries($db, $_GET['blogid'], '', '', $blog->limitEntries);
                        $blog->getFooter($db);
                        $blog->draw();
                        // in any other case, get content for requested static page
                    } else {
                        echo "<div id=\"$position\">";
                        $currentpage->getContent($db, $lang);
                        echo "</div>";
                        $main_set = 1;
                    }
                }

                // if position is globalmenu
                if ($position == "globalmenu") {
                    \YAWK\menu::displayGlobalMenu($db, $user, $template);
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
         * @brief get all template settings into an array and return it
         * @param object $db database
         * @param int    $templateID affected template ID
         * @return array
         */
        static function getTemplateSettingsArray($db, $templateID)
        {
            /* @var \YAWK\db $db */
            if (!isset($templateID) || (empty($templateID))) {   // if no templateID is set, take current template ID from settings db
                $templateID = settings::getSetting($db, "selectedTemplate");
            }
            $array = array();
            $res = $db->query("SELECT property, value, longValue
                          FROM {template_settings}
                            WHERE templateID = $templateID");

            while ($row = mysqli_fetch_assoc($res)) {
                $prop = $row['property'];
                $array[$prop] = $row['value'];
                $array[$prop] .= $row['longValue'];
            }
            return $array;
        }

        /**
         * @brief check if an admin LTE wrapper should be loaded around the backend content.
         * This function must be called at the top of every backend page (admin/includes/xyz.php)
         * @param array $lang language array
         * @return null
         */
        static function checkWrapper($lang, $title, $subtitle)
        {
            /* @var \YAWK\db $db */
            if (!isset($_GET['hideWrapper'])) {
                // draw the admin lte wrapper around content to include breadcrumbs and start content section
                // TEMPLATE WRAPPER - HEADER & breadcrumbs
                echo "
                        <!-- Content Wrapper. Contains page content -->
                        <div class=\"content-wrapper\" id=\"content-FX\">
                        <!-- Content Header (Page header) -->
                        <section class=\"content-header\">";
                /* draw Title on top */
                echo \YAWK\backend::getTitle($lang[$title], $lang[$subtitle]);
                echo "<ol class=\"breadcrumb\">
                                <li><a href=\"index.php\" title=\"$lang[DASHBOARD]\"><i class=\"fa fa-dashboard\"></i> $lang[DASHBOARD]</a></li>
                                <li><a href=\"index.php?page=users\" class=\"active\" title=\"$lang[USERS]\"> $lang[USERS]</a></li>
                            </ol>
                        </section>
                        <!-- Main content -->
                        <section class=\"content\">";
                /* page content start here */
                return null;
            } else    // if wrapper is set
            {   // check if hide status is 1
                if ($_GET['hideWrapper'] === 1) {
                    // no wrapper needed - do nothing
                }
            }
            return null;
        }

        /**
         * @brief Return a multidimensional array with all assets by requested type.
         * @details If no type is set, or type == 0, all assets will be returned.
         * @param object $db database object
         * @param int    $type 0 = all, 1 = required, 2 = optional, 3 = additional
         * @return array
         */
        public static function getAssetsByType($db, $type)
        {
            /* @var \YAWK\db $db */
            // check if type is set
            if (!isset($type) || (empty($type))) {   // if its not set, get all assets from db, no matter which type they are
                $typeSQLCode = ''; // terminate db query
            } else {   // check if type is a number
                if (is_numeric($type) || (is_int($type))) {   // and build additional sql string
                    $typeSQLCode = "AND type = '$type'";

                    // if type is zero, fetch all data
                    if ($type === 0) {   // terminate db query
                        $typeSQLCode = '';
                    }
                } else {   // type is not a number, get all data
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
            while ($row = mysqli_fetch_assoc($res)) {   // build assets array
                $prop = $row['asset'];
                $assets[$prop]["asset"] = $prop;
                $assets[$prop]["property"] = $row['property'];
                $assets[$prop]["internal"] = $row['internal'];
                $assets[$prop]["url1"] = $row['url1'];
                $assets[$prop]["url2"] = $row['url2'];
                $assets[$prop]["url3"] = $row['url3'];
                $assets[$prop]["sortation"] = $row['sortation'];
            }
            // check if assets is an array
            if (is_array($assets)) {   // all good
                return $assets;
            } else {   // error: exit with msg
                die ('unable to return assets array - maybe database is corrupt or missing.');
            }
        }

        /**
         * @brief Draw a list with all assets that are used in this template
         * @param object $db database object
         * @param int    $templateID ID of the affectd template
         * @param array  $lang language array
         * @return null
         */
        public static function drawAssetsTitles($db, $templateID, $lang)
        {
            /* @var \YAWK\db $db */
            // if no template ID is set
            if (!isset($templateID) || (empty($templateID))) {   // get current ID from database
                $templateID = settings::getSetting($db, "selectedTemplate");
            }
            if ($res = $db->query("SELECT asset, link FROM {assets} 
                                          WHERE templateID = '" . $templateID . "' 
                                          ORDER BY asset")
            ) {
                while ($row = mysqli_fetch_assoc($res)) {
                    // check, if link is external
                    if (strpos($row['link'], 'http://') !== false || (strpos($row['link'], 'https://') !== false)) {
                        $icon = "fa fa-cloud";
                        $title = "$lang[EXTERNAL]";
                    } else {
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
         * @brief Draw asset select fields
         * @details This method is used in the backend to generate asset select fields in template-assets view
         * @param object $db database object
         * @param int    $type 0 = all, 1 = required, 2 = optional, 3 = additional
         * @param int    $templateID id of the affected template
         * @param array  $lang language array
         * @return null
         */
        public static function drawAssetsSelectFields($db, $type, $templateID, $lang)
        {
            /* @var \YAWK\db $db */

            // check type and load assets data
            // if type is not set
            if (!isset($type) || (empty($type))) {   // set to zero -this will get all assets in array
                $type = 0;
            }

            // check if templateID is set
            if (!isset($templateID) || (empty($templateID))) {
                // get current template ID
                $templateID = settings::getSetting($db, "selectedTemplate");
            }

            // get assets, depending on type from database
            $assets = template::getAssetsByType($db, $type);

            foreach ($assets as $asset => $property) {
                $resInternal = $db->query("SELECT link from {assets} 
                                         WHERE templateID = '" . $templateID . "'
                                         AND link = '" . $property['internal'] . "'");

                $resUrl1 = $db->query("SELECT link from {assets} 
                                         WHERE templateID = '" . $templateID . "'
                                         AND link = '" . $property['url1'] . "'");

                $resUrl2 = $db->query("SELECT link from {assets} 
                                         WHERE templateID = '" . $templateID . "'
                                         AND link = '" . $property['url2'] . "'");

                $resUrl3 = $db->query("SELECT link from {assets} 
                                         WHERE templateID = '" . $templateID . "'
                                         AND link = '" . $property['url3'] . "'");

                $row = mysqli_fetch_assoc($resInternal);
                if (isset($property['internal']) && isset($row['link']) && $row['link'] === $property['internal']) {
                    $selectedInternal = " selected";
                } else {
                    $selectedInternal = '';
                }

                $row = mysqli_fetch_assoc($resUrl1);
                if (isset($property['url1']) && isset($row['link']) && $row['link'] === $property['url1']) {
                    $selectedUrl1 = " selected";
                } else {
                    $selectedUrl1 = '';
                }

                $row = mysqli_fetch_assoc($resUrl2);
                // echo "<br>VAR : "; // print_r($property);
                if (isset($property['url2']) && isset($row['link']) && $row['link'] === $property['url2']) {
                    $selectedUrl2 = " selected";
                } else {
                    $selectedUrl2 = '';
                }

                $row = mysqli_fetch_assoc($resUrl3);
                if (isset($property['url3']) && isset($row['link']) && $row['link'] === $property['url3']) {
                    $selectedUrl3 = " selected";
                } else {
                    $selectedUrl3 = '';
                }

                echo "<label for=\"include-$property[property]\">$property[asset]</label>
                      <input name=\"title-$property[property]\" value=\"$property[asset]\" type=\"hidden\">
                      <input name=\"sortation-$property[property]\" value=\"$property[sortation]\" type=\"hidden\">
                      
                        <select id=\"include-$property[property]\" name=\"include-$property[property]\" class=\"form-control\">
                            <option name=\"null\" value=\"\">inactive</option>
                            <optgroup label=\"internal\">internal</optgroup>
                            <option name=\"value\"$selectedInternal>$property[internal]</option>
                            <optgroup label=\"external\">external</optgroup>
                            <option name=\"value\"$selectedUrl1>$property[url1]</option>";
                if (!empty($property['url2'])) {   // display 2nd external asset link
                    echo "
                            <option name=\"value\"$selectedUrl2>$property[url2]</option>";
                }
                if (!empty($property['url3'])) {
                    echo "
                            <option name=\"value\"$selectedUrl3>$property[url3]</option>";
                }
                echo "
                            </select>";
            }
            return null;
        }

        /**
         * @brief Load Active Assets
         * @details Load HTML markup for each active asset of current template
         * @param $db object db connection
         * @param $templateID int the current template ID
         * @param $host string host URL will be used by internal assets to avoid relative paths
         * @return null
         */
        public function loadActiveAssets($db, $templateID, $host)
        {
            /* @var \YAWK\db $db */

            if (isset($templateID) && (!empty($templateID))) {
                echo "
<!-- ASSETS -->";
                if ($res = $db->query("SELECT type, asset, link FROM {assets} WHERE templateID = '" . $templateID . "' ORDER BY sortation ASC"))
                {
                    while ($row = mysqli_fetch_assoc($res))
                    {
                        // make sure, host will only be added for relative url assets
                        if(stristr($row['link'], 'http://') || (stristr($row['link'], 'https://')) === FALSE)
                        {
                            // echo "".$row['link']." internal:";
                            $url = $host.$row['link'];
                            // do nothing
                        }
                        else
                        {   // external URL, do not prepend host string to link
                            // echo "".$row['link']." ext:";
                            $url = $row['link'];
                        }

                        // JS
                        if ($row['type'] === "js") {   // load js asset
                            echo "
 <!-- load JS: $row[asset] -->
 <script src=\"".$url."\"></script>";
                        }

                        // CSS
                        if ($row['type'] === "css") {   // load css asset
                            echo "
 <!-- load CSS: $row[asset] -->
 <link rel=\"stylesheet\" href=\"".$url."\" type=\"text/css\" media=\"all\">";
                        }
                    }
                }
            }
            return null;
        }

        public function loadActiveAssetsIntoArray($db, $templateID)
        {
            /* @var \YAWK\db $db */

            if (isset($templateID) && (!empty($templateID)))
            {
                if ($sql = $db->query("SELECT * FROM {assets} WHERE templateID = '" . $templateID . "'"))
                {   // fetch data
                    while ($row = mysqli_fetch_assoc($sql)) {   // store data as array
                        $assets[] = $row;
                    }
                }
                if (isset($assets) && (is_array($assets) && (!empty($assets))))
                {
                    return $assets;
                }
                else
                {
                    return false;
                }
            }
            else
            {   // template ID is not set
                return false;
            }
        }


        /**
         * @brief copy template settings into a new template
         * @param object $db database
         * @param int    $templateID template ID
         * @param int    $newID template ID
         */
        public static function copyAssets($db, $templateID, $newID)
        {
            /** @var $db \YAWK\db */

            $res = $db->query("INSERT INTO {assets} (templateID, type, sortation, asset, link)
                                      SELECT '" . $newID . "', type, sortation, asset, link
                                      FROM {assets} 
                                      WHERE templateID = '" . $templateID . "'");

            if (!$res)
            {
                sys::setSyslog($db, 48, 2, "failed to copy assets of template #$templateID", 0, 0, 0, 0);
                alert::draw("danger", "Could not copy assets", "please try again.", "", 5000);
            }
            else
            {
                alert::draw("success", "Assets copied", "successful", "", 5000);


                $update = $db->query("UPDATE {assets} SET templateID='" . $newID . "' WHERE templateID=0");

                if ($update) {
                    alert::draw("success", "Assets are set-up", "successful", "", 5000);
                } else {
                    sys::setSyslog($db, 48, 2, "failed to copy assets of template #$templateID", 0, 0, 0, 0);
                    alert::draw("warning", "Could not copy template assets", "unable to alter IDs.", "", 5000);
                }

            }
        }

        /**
         * @brief Return which Bootstrap version is currently loaded in given template
         * @param object $db database
         * @return string Which Bootstrap v is setup in given template ID
         */
        public static function returnCurrentBootstrapVersion($db, $templateID)
        {
            // query database
            if ($sql = $db->query("SELECT asset FROM {assets} WHERE templateID = '" . $templateID . "' AND asset LIKE '%Bootstrap%CSS'")) {   // fetch data
                while ($row = mysqli_fetch_row($sql)) {   // store data as array
                    $asset[] = $row;
                }
            }

            // check if asset array is set and not empty
            if (isset($asset) && (is_array($asset) && (!empty($asset[0][0]))))
            {
                if ($asset[0][0] === "Bootstrap 4 CSS")
                {   // v4
                    return "4";
                }

                else if ($asset[0][0] === "Bootstrap 3 CSS")
                {   // v3
                    return "3";
                }
                else
                {   // unable to detect bootstrap version, maybe this template ID does not load bootstrap
                    return "0";
                }
            }
            return null;
        }

        /**
         * @brief Check which Bootstrap version is currently loaded in active template
         * @param object $db database
         * @return string 0|3|4|X
         * @details  return values: 0 = not loaded, 3 = bootstrap 3, 4 = bootstrap 4, X = multiple (false!)
         */
        public function checkBootstrapVersion($db, $templateID, $lang)
        {
            /** @var $db \YAWK\db */

            // query database
            if ($sql = $db->query("SELECT asset FROM {assets} WHERE templateID = '" . $templateID . "' AND asset LIKE '%Bootstrap%CSS'")) {   // fetch data
                while ($row = mysqli_fetch_row($sql)) {   // store data as array
                    $asset[] = $row;
                }
            }

            // check if there is more than 1 entry
            /*
            if (isset($asset[1]) && (!empty($asset[1]))) {   // bootstrap seem to be loaded twice
                \YAWK\sys::setSyslog($db, 48, 2, "bootstrap loaded multiple times - template <b>$this->name</b> requires only <b>$this->framework</b>", $_SESSION['uid'], 0, 0, 0);
                return "X";
            }
            */

            // check if asset array is set and not empty
            if (isset($asset) && (is_array($asset) && (!empty($asset[0][0]))))
            {
                // check if framework requirement match current loaded bootstrap version
                // if boostrap 3 is required
                if ($this->framework == "bootstrap3") {
                    // check if str contains 3 (must be when 'Bootstrap 3 CSS' is loaded, see sql query)
                    if (strstr($asset[0][0], "3")) {   // Bootstrap 3 (is required and loaded)
                        return "3";
                    } else {   // wrong framework loaded - set syslog entry
                        sys::setSyslog($db, 48, 2, "wrong Bootstrap version loaded - template <b>$this->name</b> requires <b>$this->framework</b>", $_SESSION['uid'], 0, 0, 0);
                        return null;
                    }
                } // if boostrap 4 is required
                elseif ($this->framework == "bootstrap4") {
                    // check if str contains 4 (must be when 'Bootstrap 4 CSS' is loaded, see sql query)
                    if (strstr($asset[0][0], "4")) {   // Bootstrap 4 (is required and loaded)
                        return "4";
                    } else {   // wrong framework loaded - set syslog entry
                        sys::setSyslog($db, 48, 2, "wrong Bootstrap version loaded - template <b>$this->name</b> requires <b>$this->framework</b>", $_SESSION['uid'], 0, 0, 0);
                        return null;
                    }
                } else {   // unknown framework
                    sys::setSyslog($db, 48, 2, "template <b>$this->name</b> requires framework: [<b>$this->framework</b>] - UNABLE TO DETECT CURRENT FRAMEWORK.", $_SESSION['uid'], 0, 0, 0);
                    return "0";
                }
            } // asset not set, no array or empty
            else {   // it seems that no Bootstrap css is loaded
                sys::setSyslog($db, 48, 2, "template <b>$this->name</b> requires <b>$this->framework</b>, but no corresponding asset is loaded.", $_SESSION['uid'], 0, 0, 0);
                return "0";
            }
        }

        public function emptyTmpFolder()
        {
            foreach(glob($this->tmpFolder."*") as $file)
            {
                if(!is_dir($file))
                {
                    unlink($file);
                }
                else
                {
                    \YAWK\filemanager::recursiveRemoveDirectory($file);
                }
            }
        }

        /**
         * @brief Upload a template (install / update)
         * @param object $db database object
         * @param array $postData data that has been sent by upload form
         * @param array $postFiles uploaded file that has been sent by upload form
         * @return bool true|false
         * @details  upload .zip file, unpack to tmp folder,
         */
        public function uploadTemplate($db, $postData, $postFiles, $lang)
        {
            // check if params are set and valid...
            if (!isset($postData)
                || (empty($postData)
                    || (!is_array($postData))))
            {   // post data wrong
                return false;
            }
            if (!isset($postFiles['templateFile'])
                || (empty($postFiles['templateFile'])
                    || (!is_array($postFiles['templateFile']))))
            {   // post file data wrong
                return false;
            }

            // prepare (empty) temp directory
            $this->emptyTmpFolder();

            // check if tmp folder exists...
            if (!is_dir(dirname($this->tmpFolder)))
            {
                // try to create tmp folder
                if (!mkdir($this->tmpFolder))
                {
                    // add syslog: failed to create $this->tmpFolder
                    return false;
                }
            }

            // check if template folder is writeable
            if (is_writeable(dirname($this->folder)))
            {
                // check if tmp folder exits
                if (is_dir(dirname($this->tmpFolder)))
                {
                    $this->uploadFile = $this->tmpFolder.$postFiles['templateFile']['name'];

                    // check for errors
                    if ($postFiles['templateFile']['error'] !== 0)
                    {   // unknown error - upload failed
                        sys::setSyslog($db, 48, 2, "failed to upload file - unknown error (".$postFiles['templateFile']['error'].") processing file ".$postFiles['templateFile']['name']."", 0, 0, 0, 0);
                        // echo \YAWK\alert::draw("warning", $lang['ERROR'], $lang['FILE_UPLOAD_FAILED'], "", 4800);
                    }
                    else
                    {   // try to move uploaded file
                        if (!move_uploaded_file($postFiles['templateFile']['tmp_name'], $this->uploadFile))
                        {   // throw error msg
                            sys::setSyslog($db, 48, 2, "failed to move upload file $this->uploadFile to folder ".$postFiles['templateFile']['tmp_name']."", 0, 0, 0, 0);
                            // echo \YAWK\alert::draw("danger", "$lang[ERROR]", "$this->uploadFile - $lang[FILE_UPLOAD_ERROR]","","4800");
                        }
                        else
                        {   // file upload seem to be successful...
                            // check if uploaded file is there
                            if (is_file($this->uploadFile))
                            {
                                // here we could check more things - eg latest file timestamp
                                // create zip object + extract to tmp folder
                                $zip = new \ZipArchive;
                                // open zip archive
                                $res = $zip->open($this->uploadFile);
                                // if zip open was successful
                                if ($res === TRUE)
                                {   // extract zip file
                                    $zip->extractTo($this->tmpFolder);
                                    // close zip file
                                    $zip->close();
                                }

                                // check and read template.ini file - stores all information about the template
                                if (is_file($this->tmpFolder.'template.ini'))
                                {
                                    // try to parse ini file into array
                                    if (!$iniFile = parse_ini_file($this->tmpFolder."template.ini"))
                                    {   // error: unable to parse ini file
                                        sys::setSyslog($db, 48, 2, "failed to parse ini file ".$this->tmpFolder."template.ini ", 0, 0, 0, 0);
                                        return false;
                                    }
                                }
                                else
                                {   // error: ini file not there
                                    sys::setSyslog($db, 48, 2, "failed to parse ini file ".$this->tmpFolder."template.ini - file not found", 0, 0, 0, 0);
                                    return false;
                                }

                                // set target path
                                $this->targetPath = $iniFile['TARGET_PATH'];
                                // set subfolder
                                $this->subFolder = $iniFile['SUBFOLDER']."/";

                                // read assets.json into array
                                if (is_file($this->tmpFolder.$this->subFolder.'assets.json'))
                                {   // read and decode json file into array
                                    $assets = json_decode(file_get_contents($this->tmpFolder.$this->subFolder.'assets.json'), true);
                                }
                                else
                                {   // assets.json not found
                                    $assets = '';
                                    sys::setSyslog($db, 48, 1, "failed to get ".$this->tmpFolder.$this->subFolder."assets.json - file not found", 0, 0, 0, 0);
                                }

                                // read template settings into array
                                if (is_file($this->tmpFolder.$this->subFolder.'template_settings.json'))
                                {   // read and decode json file into array
                                    $templateSettings = json_decode(file_get_contents($this->tmpFolder.$this->subFolder.'template_settings.json'), true);
                                }
                                else
                                {   // template_settings.json not found
                                    $templateSettings = '';
                                    sys::setSyslog($db, 48, 1, "failed to get ".$this->tmpFolder.$this->subFolder."template_settings.json - file not found", 0, 0, 0, 0);
                                }

                                // read template_settings_types into array
                                if (is_file($this->tmpFolder.$this->subFolder.'template_settings_types.json'))
                                {   // read and decode json into array
                                    $templateSettingsTypes = json_decode(file_get_contents($this->tmpFolder.$this->subFolder.'template_settings_types.json'), true);
                                }
                                else
                                {   // template_settings_types json file not found
                                    $templateSettingsTypes = '';
                                    sys::setSyslog($db, 48, 1, "failed to get ".$this->tmpFolder.$this->subFolder."template_settings_types.json - file not found", 0, 0, 0, 0);
                                }

                                // read templates.json into array
                                if (is_file($this->tmpFolder.$this->subFolder.'templates.json'))
                                {   // read and decode json into array
                                    $templates = json_decode(file_get_contents($this->tmpFolder.$this->subFolder.'templates.json'), true);
                                }
                                else
                                {   // templates.json file not found
                                    $templates = '';
                                    sys::setSyslog($db, 48, 1, "failed to get ".$this->tmpFolder.$this->subFolder."templates.json - file not found", 0, 0, 0, 0);
                                }

                                // check if template with same name exists
                                if ($this->checkIfTemplateAlreadyExists($db, $iniFile['NAME']) === true)
                                {
                                    // die('template already exists');

                                    // TEMPLATE ALREADY EXISTS - OVERWRITE IT!
                                    //  .) check, which ID got this template?
                                    //  .) manipulate assets + template_settings arrays
                                    //     (means: change template ID to the one of the existing template that was found)
                                    //  .) UPDATE data of these arrays into related db tables
                                    //  .) delete json files from tmp folder (unwanted in target)
                                    //  .) xcopy files and overwrite template folder
                                    //  .) empty tmp directory
                                    //  -fin- template updated - if all went good

                                    // get ID of installed template
                                    $this->id = self::getTemplateIdByName($db, $iniFile['NAME']);

                                    // update ID in templates array
                                    $templates['id'] = $this->id;

                                    // update ID in assets array
                                    foreach ($assets as &$asset)
                                    {
                                        $asset['templateID'] = $this->id;
                                    }

                                    // update ID in template_settings array
                                    foreach ($templateSettings as &$templateSetting)
                                    {
                                        $templateSetting['templateID'] = $this->id;
                                    }

                                    if ($db->query("UPDATE {templates} 
                                                    SET id = '".$this->id."',
                                                        active = 1,
                                                        name = '".$iniFile['NAME']."',
                                                        positions ='outerTop:outerLeft:outerRight:intro:globalmenu:top:leftMenu:mainTop:mainTopLeft:mainTopCenter:mainTopRight:main:mainBottom:mainBottomLeft:mainBottomCenter:mainBottomRight:mainFooter:mainFooterLeft:mainFooterCenter:mainFooterRight:rightMenu:bottom:footer:hiddentoolbar:debug:outerBottom',
                                                        description = '".$iniFile['DESCRIPTION']."',
                                                        modifyDate = '".$iniFile['DATE']."',
                                                        author = '".$iniFile['AUTHOR']."',
                                                        authorUrl = '".$iniFile['AUTHOR_URL']."',
                                                        weblink = '".$iniFile['WEBLINK']."',
                                                        subAuthor = '".$iniFile['SUB_AUTHOR']."',
                                                        subAuthorUrl = '".$iniFile['SUB_AUTHOR_URL']."',
                                                        version = '".$iniFile['VERSION']."',
                                                        framework = '".$iniFile['FRAMEWORK']."',
                                                        license = '".$iniFile['LICENSE']."'
                                    WHERE name = '".$iniFile['NAME']."'"))
                                    {
                                        // success: updated templates database
                                        // \YAWK\sys::setSyslog($db, 45, 0, "template $iniFile[NAME] - templates db updated", 0, 0, 0, 0);
                                    }
                                    else
                                    {   // error: failed to update templates db
                                        sys::setSyslog($db, 47, 0, "failed to update template $iniFile[NAME] - templates db NOT updated", 0, 0, 0, 0);
                                    }

                                    // update assets database
                                    foreach ($assets as $asset)
                                    {
                                        if ($db->query("UPDATE {assets} 
                                                    SET templateID = '".$this->id."',
                                                        type = '".$asset['type']."',
                                                        sortation = '".$asset['sortation']."',
                                                        asset = '".$asset['asset']."',
                                                        link = '".$asset['link']."'
                                                    WHERE link = '".$asset['link']."' AND templateID = '".$iniFile['ID']."'"))
                                        {
                                            // success: updated templates database
                                            // \YAWK\sys::setSyslog($db, 45, 0, "template $iniFile[NAME] - assets db updated", 0, 0, 0, 0);
                                        }
                                        else
                                        {   // error: failed to update templates db
                                            sys::setSyslog($db, 47, 0, "failed to update template $iniFile[NAME] - assets db NOT updated", 0, 0, 0, 0);
                                        }
                                        // process asset data
                                    }

                                    // update template_settings database

                                    foreach ($templateSettings as $templateSetting)
                                    {
                                        if ($db->query("UPDATE {template_settings} 
                                        SET templateID = '".$this->id."',
                                            property = '".$templateSetting['property']."',
                                            value = '".$templateSetting['value']."',
                                            valueDefault = '".$templateSetting['valueDefault']."',
                                            longValue = '".$templateSetting['longValue']."',
                                            type = '".$templateSetting['type']."',
                                            activated = '".$templateSetting['activated']."',
                                            sort = '".$templateSetting['sort']."',
                                            label = '".$templateSetting['label']."',
                                            fieldClass = '".$templateSetting['fieldClass']."',
                                            fieldType = '".$templateSetting['fieldType']."',
                                            options = '".$templateSetting['options']."',
                                            placeholder = '".$templateSetting['placeholder']."',
                                            description = '".$templateSetting['description']."',
                                            icon = '".$templateSetting['icon']."',
                                            heading = '".$templateSetting['heading']."',
                                            subtext = '".$templateSetting['subtext']."'
                                        WHERE property = '".$templateSetting['property']."' AND templateID = '".$iniFile['ID']."'"))
                                        {
                                            // success: updated templates database
                                            // \YAWK\sys::setSyslog($db, 45, 0, "template $iniFile[NAME] - template_settings db updated", 0, 0, 0, 0);
                                        }
                                        else
                                        {   // error: failed to update templates db
                                            sys::setSyslog($db, 47, 0, "failed to update property $templateSetting[property] of template $iniFile[NAME] - template_settings db NOT updated", 0, 0, 0, 0);
                                        }
                                    }

                                    // update template settings types
                                    foreach ($templateSettingsTypes as $templateSettingsType)
                                    {
                                        if ($db->query("UPDATE {template_settings_types} 
                                        SET type = '".$templateSettingsType['type']."'
                                        WHERE type = '".$templateSettingsType['type']."'"))
                                        {
                                            // success: updated templates database
                                            // \YAWK\sys::setSyslog($db, 45, 0, "template $iniFile[NAME] - template_settings db updated", 0, 0, 0, 0);
                                        }
                                        else
                                        {   // error: failed to update templates db
                                            sys::setSyslog($db, 47, 0, "failed to update type $templateSettingsType[type] - template_settings_types db NOT updated", 0, 0, 0, 0);
                                        }
                                    }

                                    // delete unwanted json files - they are not needed anymore
                                    if (!unlink ($this->tmpFolder.$this->subFolder."assets.json"))
                                    {
                                        sys::setSyslog($db, 47, 0, "failed to delete ".$this->tmpFolder.$this->subFolder."assets.json", 0, 0, 0, 0);
                                    }
                                    if (!unlink ($this->tmpFolder.$this->subFolder."template_settings.json"))
                                    {
                                        sys::setSyslog($db, 47, 0, "failed to delete ".$this->tmpFolder.$this->subFolder."template_settings.json", 0, 0, 0, 0);
                                    }
                                    if (!unlink ($this->tmpFolder.$this->subFolder."template_settings_types.json"))
                                    {
                                        sys::setSyslog($db, 47, 0, "failed to delete ".$this->tmpFolder.$this->subFolder."template_settings_types.json", 0, 0, 0, 0);
                                    }
                                    if (!unlink ($this->tmpFolder.$this->subFolder."templates.json"))
                                    {
                                        sys::setSyslog($db, 47, 0, "failed to delete ".$this->tmpFolder.$this->subFolder."templates.json", 0, 0, 0, 0);
                                    }

                                    // copy template folder
                                    sys::xcopy($this->tmpFolder.$this->subFolder, $this->folder.$this->subFolder);

                                    // remove tmp folder
                                    if (!\YAWK\filemanager::recursiveRemoveDirectory($this->tmpFolder))
                                    {   // failed to remove tmp folder
                                        sys::setSyslog($db, 47, 0, "failed to remove tmp folder $this->tmpFolder", 0, 0, 0, 0);
                                    }

                                    // create a fresh, empty tmp folder
                                    mkdir($this->tmpFolder);
                                    return true;
                                }
                                else
                                {
                                    // TEMPLATE DOES NOT EXIST YET - INSTALL IT!
                                    //  1.) add template to templates database
                                    //  2.) retrieve ID of this new added template
                                    //  3.) manipulate assets + template_settings arrays
                                    //      (means: change template ID to the new created one)
                                    //
                                    //  4.) INSERT data of these arrays into related db tables
                                    //  5.) delete json files from tmp folder (unwanted in target)
                                    //  6.) delete ini file (unwanted in target)
                                    //  7.) next step - xcopy files
                                    //  -fin- template installed - if all went good
                                    // die('template does not exist');

                                    // step 1.) add template to templates database
                                    if ($res = $db->query("INSERT INTO {templates} (active, name, positions, description, releaseDate, modifyDate, author, authorUrl, weblink, subAuthor, subAuthorUrl, version, framework, license)
                                    VALUES ('1', 
                                            '".$iniFile['NAME']."', 
                                            'outerTop:outerLeft:outerRight:intro:globalmenu:top:leftMenu:mainTop:mainTopLeft:mainTopCenter:mainTopRight:main:mainBottom:mainBottomLeft:mainBottomCenter:mainBottomRight:mainFooter:mainFooterLeft:mainFooterCenter:mainFooterRight:rightMenu:bottom:footer:hiddentoolbar:debug:outerBottom', 
                                            '".$iniFile['DESCRIPTION']."', 
                                            '".$iniFile['DATE']."', 
                                            '".$iniFile['DATE']."', 
                                            '".$iniFile['AUTHOR']."', 
                                            '".$iniFile['AUTHOR_URL']."', 
                                            '".$iniFile['WEBLINK']."', 
                                            '".$iniFile['SUB_AUTHOR']."', 
                                            '".$iniFile['SUB_AUTHOR_URL']."', 
                                            '".$iniFile['VERSION']."', 
                                            '".$iniFile['FRAMEWORK']."', 
                                            '".$iniFile['LICENSE']."')"))
                                    {

                                        //  2.) retrieve ID of this new added template
                                        $this->id = self::getTemplateIdByName($db, $iniFile['NAME']);

                                        // add assets to database
                                        foreach ($assets as $asset)
                                        {
                                            $db->query("INSERT INTO {assets} (templateID, type, sortation, asset, link)
                                                        VALUES (
                                                        '".$this->id."',
                                                        '".$asset['type']."',
                                                        '".$asset['sortation']."',
                                                        '".$asset['asset']."',
                                                        '".$asset['link']."'
                                                        )");
                                        }

                                        // add template settings to database
                                        foreach ($templateSettings as $templateSetting)
                                        {
                                            $db->query("INSERT INTO {template_settings} 
                                            (templateID, property, value, valueDefault, longValue, type, activated, sort, label, fieldClass, fieldType, options, placeholder, description, icon, heading, subtext)
                                            VALUES ('".$this->id."',
                                                    '".$templateSetting['property']."',
                                                    '".$templateSetting['value']."',
                                                    '".$templateSetting['valueDefault']."',
                                                    '".$templateSetting['longValue']."',
                                                    '".$templateSetting['type']."',
                                                    '".$templateSetting['activated']."',
                                                    '".$templateSetting['sort']."',
                                                    '".$templateSetting['label']."',
                                                    '".$templateSetting['fieldClass']."',
                                                    '".$templateSetting['fieldType']."',
                                                    '".$templateSetting['options']."',
                                                    '".$templateSetting['placeholder']."',
                                                    '".$templateSetting['description']."',
                                                    '".$templateSetting['icon']."',
                                                    '".$templateSetting['heading']."',
                                                    '".$templateSetting['subtext']."')");
                                        }

                                        // delete unwanted json files - they are not needed anymore
                                        if (!unlink ($this->tmpFolder.$this->subFolder."assets.json"))
                                        {
                                            sys::setSyslog($db, 47, 0, "failed to delete ".$this->tmpFolder.$this->subFolder."assets.json", 0, 0, 0, 0);
                                        }
                                        if (!unlink ($this->tmpFolder.$this->subFolder."template_settings.json"))
                                        {
                                            sys::setSyslog($db, 47, 0, "failed to delete ".$this->tmpFolder.$this->subFolder."template_settings.json", 0, 0, 0, 0);
                                        }
                                        if (!unlink ($this->tmpFolder.$this->subFolder."template_settings_types.json"))
                                        {
                                            sys::setSyslog($db, 47, 0, "failed to delete ".$this->tmpFolder.$this->subFolder."template_settings_types.json", 0, 0, 0, 0);
                                        }
                                        if (!unlink ($this->tmpFolder.$this->subFolder."templates.json"))
                                        {
                                            sys::setSyslog($db, 47, 0, "failed to delete ".$this->tmpFolder.$this->subFolder."templates.json", 0, 0, 0, 0);
                                        }

                                        // copy template folder
                                        sys::xcopy($this->tmpFolder.$this->subFolder, $this->folder.$this->subFolder);

                                        // remove tmp folder
                                        if (!\YAWK\filemanager::recursiveRemoveDirectory($this->tmpFolder))
                                        {   // failed to remove tmp folder
                                            sys::setSyslog($db, 47, 0, "failed to remove tmp folder $this->tmpFolder", 0, 0, 0, 0);
                                        }

                                        // create a fresh, empty tmp folder
                                        mkdir($this->tmpFolder);

                                        // success: updated templates database
                                        sys::setSyslog($db, 45, 0, "added template <b>$iniFile[NAME] ID: ".$this->id."</b> to templates db", 0, 0, 0, 0);
                                        return true;

                                    }
                                    else
                                    {   // error: failed to insert new template into db
                                        sys::setSyslog($db, 47, 0, "failed to insert new template: $iniFile[NAME] - templates db NOT updated", 0, 0, 0, 0);
                                    }

                                }

                                //  xcopy files
                                //  recursive delete tmp folder

                                // throw success message
                                sys::setSyslog($db, 46, 3, "uploaded template package $this->uploadFile successfully", 0, 0, 0, 0);
                            }
                            else
                            {   // failed to check uploaded file - file not found
                                sys::setSyslog($db, 48, 1, "failed to check uploaded file upload file: $this->uploadFile not found", 0, 0, 0, 0);
                            }
                        }
                    }
                }
                else
                {   // tmp folder does not exist
                    sys::setSyslog($db, 48, 1, "failed to uploaded tempalte: ../system/templates/tmp/ does not exist or is not accessable", 0, 0, 0, 0);
                    return false;
                }
            }
            else
            {   // tmp folder is not writeable
                sys::setSyslog($db, 48, 1, "failed to uploaded template: $this->folder is not writeable", 0, 0, 0, 0);
                return false;
            }

            // if something else went wrong
            return false;
        }

        /**
         * @brief Create a zip file from template and force direct download
         * @param object $db database
         * @param string $templateFolder the template folder to zip + download
         * @param int $templateID ID of the template to process
         * @param object $user user object
         * @return bool true|false
         * @details  dump database settings into .json files, write template.ini and license file, zip the whole template folder and serve .zip for direct download
         */
        public function downloadTemplate($db, $templateFolder, $templateID, $user)
        {
            // check if template folder is set and valid
            if (!isset($templateFolder) || (empty($templateFolder) || (!is_string($templateFolder))))
            {   // required param not set
                return false;
            }
            else
            {   // set template folder property
                $this->subFolder = $templateFolder;
                $this->name = $templateFolder;
            }
            // check if template ID is set and valid
            if (!isset($templateID) || (empty($templateID) || (!is_numeric($templateID))))
            {   // required param not set
                return false;
            }
            else
            {   // set template ID property
                $this->id = $templateID;
            }

            if (!is_dir(dirname($this->tmpFolder)))
            {
                // check if tmp directory exists...
                if (!mkdir(dirname($this->tmpFolder)))
                {   // failed to create tmp folder
                    // todo: add syslog entry
                    return false;
                }
            }

            // params are set, next step:
            // check if tmp directory exists and is empty
            if (is_writeable(dirname($this->tmpFolder)))
            {
                // check if subfolder exists...
                if (!is_dir(dirname($this->tmpFolder.$this->subFolder)))
                {
                    // check if tmp directory exists...
                    if (!mkdir(dirname($this->tmpFolder.$this->subFolder)))
                    {   // failed to create tmp sub folder
                        sys::setSyslog($db, 47, 0, "failed to create ".$this->tmpFolder.$this->subFolder."", 0, 0, 0, 0);
                        return false;
                    }
                }

                // next step is to copy the whole template folder into tmp folder
                if (sys::xcopy($this->folder.$this->subFolder."/", $this->tmpFolder.$this->subFolder) === false)
                {   // failed to copy template into tmp folder
                    sys::setSyslog($db, 47, 0, "failed to copy template into tmp folder: ".$this->tmpFolder.$this->subFolder."", 0, 0, 0, 0);
                    return false;
                }

                // check if template folder is writeable
                if (is_writeable($this->tmpFolder.$this->subFolder))
                {
                    // GET TEMPLATE DEPENDING DATABASE DATA
                    // get current template data
                    $templateData = self::loadPropertiesIntoArray($db, $this->id);
                    $templateAssets = self::loadActiveAssetsIntoArray($db, $this->id);
                    $templateSettings = self::loadAllSettingsIntoArray($db, $this->id);
                    $templateSettingsTypes = self::loadSettingsTypesIntoArray($db);

                    // encode arrays to JSON format
                    $templateData = json_encode($templateData);
                    $templateAssets = json_encode($templateAssets);
                    $templateSettings = json_encode($templateSettings);
                    $templateSettingsTypes = json_encode($templateSettingsTypes);

                    // write json arrays into files
                    // write templates.json
                    if (!file_put_contents($this->tmpFolder.$this->subFolder."/"."templates.json", $templateData))
                    {   // error writing templates.json
                        sys::setSyslog($db, 48, 0, "failed to write ".$this->tmpFolder.$this->subFolder."templates.json", 0, 0, 0, 0);
                    }
                    // write assets.json
                    if (!file_put_contents($this->tmpFolder.$this->name."/"."assets.json", $templateAssets))
                    {   // error writing assets.json
                        sys::setSyslog($db, 48, 0, "failed to write ".$this->tmpFolder.$this->subFolder."assets.json", 0, 0, 0, 0);
                    }
                    // write template_settings.json
                    if (!file_put_contents($this->tmpFolder.$this->name."/"."template_settings.json", $templateSettings))
                    {   // error writing template_settings.json
                        sys::setSyslog($db, 48, 0, "failed to write ".$this->tmpFolder.$this->subFolder."template_settings.json", 0, 0, 0, 0);
                    }
                    // write template_settings_types.json
                    if (!file_put_contents($this->tmpFolder.$this->name."/"."template_settings_types.json", $templateSettingsTypes))
                    {   // error writing template_settings_types.json
                        sys::setSyslog($db, 48, 0, "failed to write ".$this->tmpFolder.$this->subFolder."template_settings_types.json", 0, 0, 0, 0);
                    }

                    // get template properties
                    $this->loadProperties($db, $this->id);
                    // get year only from release date
                    $year = (substr($this->releaseDate, 0, 4));
                    // include class
                    require_once('../system/classes/licenses.php');
                    // create license object
                    $license = new \YAWK\licenses($this->license, $this->description, $year, $this->author, $this->tmpFolder.$this->name."/");
                    // write license file
                    if ($license->writeLicenseFile() === false)
                    {   // failed to write license file
                        sys::setSyslog($db, 47, 0, "failed to write license file ($this->license license) to ".$this->tmpFolder.$this->subFolder."", 0, 0, 0, 0);
                    }
                }

                // check if .json files have been written...
                if (is_file($this->tmpFolder.$this->subFolder.'/assets.json')
                    && (is_file($this->tmpFolder.$this->subFolder.'/templates.json')
                        && (is_file($this->tmpFolder.$this->subFolder.'/template_settings.json')
                            && (is_file($this->tmpFolder.$this->subFolder.'/template_settings_types.json')))))
                {
                    // ok, all files seem to be processed successfully

                    // set source (path to the affected template)
                    $source = $this->tmpFolder;
                    // set target (path to the zip file that will be generated)
                    $destination = $this->tmpFolder.$this->name.'.zip';

                    // set data for ini file
                    $iniData['DATE'] = sys::now();
                    $iniData['NAME'] = $this->name;
                    $iniData['FOLDER'] = $this->folder;
                    $iniData['SUBFOLDER'] = $this->subFolder;
                    $iniData['TARGET_PATH'] = $this->folder.$this->subFolder."/";
                    $iniData['ID'] = $this->id;
                    $iniData['FRAMEWORK'] = $this->framework;
                    $iniData['DESCRIPTION'] = $this->description;
                    $iniData['AUTHOR'] = $this->author;
                    $iniData['AUTHOR_URL'] = $this->authorUrl;
                    $iniData['SUB_AUTHOR'] = $this->subAuthor;
                    $iniData['SUB_AUTHOR_URL'] = $this->subAuthorUrl;
                    $iniData['WEBLINK'] = $this->weblink;
                    $iniData['VERSION'] = $this->version;
                    $iniData['LICENSE'] = $this->license;

                    // write ini file
                    if (sys::writeIniFile($iniData, $this->tmpFolder."template.ini") === false)
                    {
                        // failed to write ini file:
                        sys::setSyslog($db, 47, 0, "failed to write ".$this->tmpFolder."template.ini ", 0, 0, 0, 0);
                        return false;
                    }

                    // next step is to zip the whole template folder, containing all files

                    // check if zip extension is loaded
                    if (extension_loaded('zip'))
                    {
                        // make sure $source (template folder) exists
                        if (!is_dir(dirname($source)))
                        {   // if folder does not exist
                            return false;
                        }

                        // create new zip object
                        $zip = new \ZipArchive();

                        // make sure to create and open new zip archive
                        if (!$zip->open($destination, \ZIPARCHIVE::CREATE))
                        {   // if not
                            return false;
                        }

                        // set path slashes correctly
                        $source = str_replace('\\', '/', realpath($source));

                        // check if $source is a directoy
                        if (is_dir($source) === true)
                        {
                            // run recursive iterators to store files in array
                            $elements = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($source), \RecursiveIteratorIterator::SELF_FIRST);

                            // walk through folder
                            foreach ($elements as $file)
                            {
                                // set path slashes correctly
                                $file = str_replace('\\', '/', $file);

                                // ignore dot folders (. and ..)
                                if( in_array(substr($file, strrpos($file, '/')+1), array('.', '..')) )
                                    continue;

                                // set file including path
                                $file = realpath($file);

                                // check if current element is a directory
                                if (is_dir($file) === true)
                                {   // add folder to zip file
                                    $zip->addEmptyDir(str_replace($source . '/', '', $file . '/'));
                                }
                                // check if current element is a file
                                else if (is_file($file) === true)
                                {   // add file to zip archive
                                    $zip->addFromString(str_replace($source . '/', '', $file), file_get_contents($file));
                                }
                            }
                        }
                        // if $source is a file
                        else if (is_file($source) === true)
                        {   // add file to zip archive
                            $zip->addFromString(basename($source), file_get_contents($source));
                        }

                        // all done, close (and write) zip archive
                        $zip->close();

                        if (is_file($destination))
                        {   // destination zip file is there.

                            // delete all files from tmp folder - except the created zipfile
                            if (\YAWK\filemanager::recursiveRemoveDirectory($this->tmpFolder.$this->subFolder) === false)
                            {   // warning: failed to delete tmp files
                                sys::setSyslog($db, 47, 0, "failed to delete tmp folder ".$this->tmpFolder.$this->subFolder."", 0, 0, 0, 0);
                                // return false;
                            }

                            // check if template ID is set
                            if (isset($_GET['id']) && (!empty($_GET['id'])))
                            {   // set var for JS: downloadArchiveLink (selector)
                                $downloadTemplateLink = "#downloadTemplateLink-".$_GET['id'];
                                // set var for JS: link to the file to download
                                $downloadFile = $destination;
                                // dirty lil piece of JS code to emulate the user's click
                                // (this avoids that he have to click twice - 1st click to generate + 2nd click to download)
                                echo "
                                    <script type='text/javascript'>
                                        $(document).ready(function()
                                        {   // change href attribute for this archive to direct donwload file
                                            var oldLink = $('$downloadTemplateLink').attr('href');
                                            $('$downloadTemplateLink').attr('href', '$downloadFile')
                                            // emulate a users click to force direct download
                                            $('$downloadTemplateLink')[0].click();
                                            // if this is not working, the user have to click on that link.
                                        });
                                    </script>";
                            }
                            // download file generated, direct download forced...
                            return true;
                        }
                        else
                        {   // zip not generated
                            sys::setSyslog($db, 52, 2, "failed to create template $this->name.zip package - zip file not there", 0, 0, 0, 0);
                            return false;
                        }
                    }
                    else
                    {   // zip extension is not loaded
                        sys::setSyslog($db, 52, 2, "failed to create template .zip package: PHP zip extension not loaded.", 0, 0, 0, 0);
                        return false;
                    }
                }
                else
                {   // .sql files not written
                    sys::setSyslog($db, 52, 2, ".json files missing: $this->folder$this->subFolder/*.json not found", 0, 0, 0, 0);
                    return false;
                }
            }
            else
            {   // unable to include class
                sys::setSyslog($db, 52, 2, "create template .zip package failed: folder $this->folder is not writeable. Please check folder group permissions", 0, 0, 0, 0);
                return false;
            }
        }
    } // ./class template
} // ./namespace
