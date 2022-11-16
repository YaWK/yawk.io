<?php
namespace YAWK {
    /**
     * @brief Settings class: get and set YaWK system settings
     * @author Daniel Retzl <danielretzl@gmail.com>
     * @version 1.0.0
     */
    class settings
    {
        /**
         * @brief Returns an array with all setings where property is like $property.
         * @param object $db Database Object
         * @param string $property
         * @return mixed
         */
        public static function getAllSettingsArray($db, $property) // get all settings from db like property
        {
            /* @param $db \YAWK\db */
            if ($res= $db->query("SELECT * FROM {settings} WHERE property LIKE '".$property."%'")) {
                $settingsArray = array();
                while ($row = $res->fetch_assoc())
                {   // fill array
                    $settingsArray[$row['property']] = $row;
                }
            }
            else
            {   // q failed, throw error
                \YAWK\sys::setSyslog($db, 35, 1, "failed to get settings from database ", 0, 0, 0, 0);
                \YAWK\alert::draw("warning", "Warning!", "Fetch database error: getSettingsArray failed.","","4800");
                return false;
            }
            return $settingsArray;
        }

        /**
         * @brief Returns an array containing property as key and values corresponding to this property where p like $property%.
         * @param object $db Database Object
         * @param string $property
         * @return mixed
         */
        public static function getValueSettingsArray($db, $property) // get all settings from db like property
        {
            /* @param $db \YAWK\db */
            if ($res= $db->query("SELECT property, value FROM {settings} WHERE property LIKE '".$property."%'")) {
                $settingsArray = array();
                while ($row = $res->fetch_assoc())
                {   // fill array
                    $settingsArray[$row['property']] = $row['value'];
                }
            }
            else
            {   // q failed, throw error
                \YAWK\sys::setSyslog($db, 35, 1, "failed to get settings from database ", 0, 0, 0, 0);
                \YAWK\alert::draw("warning", "Warning!", "Fetch database error: getSettingsArray failed.","","4800");
                return false;
            }
            return $settingsArray;
        }

        /**
         * @brief Return corresponding form elements for given settings.
         * @param object $db Database Object
         * @param array $settings Settings: property|value|type|sortation|activated|label|icon|heading|subtext|fieldClass|fieldType|placeholder|description|options
         * @param int $type
         */
        public static function getFormElements($db, $settings, $type, $lang)
        {	// loop trough array
            $i_settings = 0;
            if(!isset($settings) || (empty($settings)) || (!is_array($settings)))
            {	// if settings are not set, try to get them...
                $settings = \YAWK\settings::getAllSettingsIntoArray($db);
            }
            if(!isset($type) && (empty($type)))
            {	// if param 'type' is missing, show all settings
                $type = 1;
            }
            // loop trough settings array
            foreach ($settings as $setting)
            {	// field type not set or empty
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

                        // check if description is set
                        // the description will be shown right beside the label
                        if (isset($setting['description']) && (!empty($setting['description'])))
                        {   // L11n
                            $setting['description'] = $lang[$setting['description']];
                            $setting['description'] = "&nbsp;<small><i class=\"fa fa-question-circle-o text-info\" data-placement=\"auto right\" data-toggle=\"tooltip\" title=\"$setting[description]\"></i></small>";
                        }
                        else
                        {   // leave empty - no description available
                            $setting['description'] = '';
                        }

                        // check if readonly option is set
                        if ($setting['options'] === "readonly")
                        {
                            $readonly = " readonly";
                            $disabled = " disabled";
                        }
                        else
                        {
                            $readonly = '';
                            $disabled = '';
                        }

                        // check if placeholder is set and not empty
                        if (isset($setting['placeholder']) && (!empty($setting['placeholder'])))
                        {
                            $ph = $setting['placeholder'];
                            $placeholder = $lang[$ph];
                        }
                        else
                        {
                            $placeholder = '';
                        }

                        // CHECKBOX
                        if ($setting['fieldType'] === "checkbox")
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
                                echo "<h3>$setting[icon]&nbsp;$setting[heading]&nbsp;<small>$setting[subtext]</small></h3>";
                            }
                            echo "<input type=\"hidden\" name=\"$setting[property]\" value=\"0\">
                              <input type=\"checkbox\" id=\"$setting[property]\" name=\"$setting[property]\" value=\"1\" $checked>
                              <label for=\"$setting[property]\">&nbsp; $setting[label] $setting[description]</label><br>";
                        }

                        /* RADIO BUTTTONS */
                        if ($setting['fieldType'] === "radio")
                        {
                            echo "<label for=\"$setting[property]\">$setting[label] $setting[description]</label>
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

                        /* SELECT FIELD */
                        else if ($setting['fieldType'] === "select")
                        {   // display icon, heading and subtext, if its set
                            if (!empty($setting['icon']) || (!empty($setting['heading']) || (!empty($setting['subtext']))))
                            {
                                echo "<h3>$setting[icon]&nbsp;$setting[heading]&nbsp;<small>$setting[subtext]</small></h3>";
                            }
                            // TEMPLATE SELECTOR
                            if ($setting['property'] === "selectedTemplate")
                            {   // if property is selected template...
                                echo "<b>".$setting['label']." ".$setting['description']."</b>";
                                \YAWK\backend::drawTemplateSelectField($db, $setting['description']);
                            }
                            // GLOBALMENU ID SELECTOR
                            else if ($setting['property'] === "globalmenuid")
                            {
                                $currentMenu = \YAWK\menu::getMenuNameByID($db, $setting['value'], $lang);
                                echo "<label for=\"$setting[property]\">$setting[label] $setting[description]</label>
                                      <select name=\"$setting[property]\" class=\"form-control\" id=\"$setting[property]\">";
                                echo "<option value=\"$setting[value]\">$currentMenu</option>";
                                foreach (\YAWK\backend::getMenuNamesArray($db) as $property=>$row)
                                {
                                    if ($row['id'] !== $setting['value']){
                                        echo "<option value=\"$row[id]\">$row[name]</option>";
                                    }

                                }
                                echo "<option value=\"0\">$lang[NO_ENTRY]</option>";
                                echo "</select>";
                            }
                            else
                            {   // begin draw select
                                echo "<label for=\"$setting[property]\">$setting[label] $setting[description]</label>
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
                                    // echo "<option value=\"$optionValue[0]\">$optionDesc</option>";
                                    // echo "<option value=\"$value\">$value</option>";
                                }
                                echo "</select>";
                            }
                        }

                        /* TEXTAREA */
                        else if ($setting['fieldType'] === "textarea")
                        {    // if a long value is set
                            if (!empty($setting['icon']) || (!empty($setting['heading']) || (!empty($setting['subtext']))))
                            {
                                echo "<h3>$setting[icon]&nbsp;$setting[heading]&nbsp;<small>$setting[subtext]</small></h3>";
                            }
                            $placeholder = $setting['placeholder'];     // store placeholder from array in var to use it at language array
                            if (isset($setting['longValue']) && (!empty($setting['longValue'])))
                            {   // build a longValue tagged textarea and fill with longValue
                                $setting['longValue'] = nl2br($setting['longValue']);
                                echo "<label for=\"$setting[property]-long\">$setting[label] $setting[description]</label>
                                      <textarea cols=\"64\" rows=\"4\" placeholder=\"$placeholder\" class=\"$setting[fieldClass]\" id=\"$setting[property]-long\" name=\"$setting[property]-long\"$disabled>$setting[longValue]</textarea>";
                            }
                            else
                            {   // draw default textarea
                                $placeholder = $setting['placeholder'];     // store placeholder from array in var to use it at language array
                                $setting['value'] = nl2br($setting['value']);
                                echo "<label for=\"$setting[property]-long\">$setting[label] $setting[description]</label>
                                      <textarea cols=\"64\" rows=\"4\" placeholder=\"$placeholder\" class=\"$setting[fieldClass]\" id=\"$setting[property]\" name=\"$setting[property]\"$disabled>$setting[value]</textarea>";
                            }
                        }

                        /* INPUT PASSWORD FIELD */
                        else if ($setting['fieldType'] === "password")
                        {    // draw an input field
                            $placeholder = $setting['placeholder'];     // store placeholder from array in var to use it at language array
                            if (!empty($setting['icon']) || (!empty($setting['heading']) || (!empty($setting['subtext']))))
                            {
                                echo "<h3>$setting[icon]&nbsp;$setting[heading]&nbsp;<small>$setting[subtext]</small></h3>";
                            }
                            echo "<label for=\"$setting[property]\">$setting[label] $setting[description]</label>
                                  <input type=\"password\" class=\"$setting[fieldClass]\" id=\"$setting[property]\" name=\"$setting[property]\" 
										 value=\"$setting[value]\" placeholder=\"$placeholder\"$readonly$disabled>";
                        }

                        /* INPUT TEXT FIELD */
                        else if ($setting['fieldType'] === "input")
                        {    // draw an input field

                            if (!empty($setting['icon']) || (!empty($setting['heading']) || (!empty($setting['subtext']))))
                            {
                                echo "<h3>$setting[icon]&nbsp;$setting[heading]&nbsp;<small>$setting[subtext]</small></h3>";
                            }
                            echo "<label for=\"$setting[property]\">$setting[label] $setting[description]</label>
                                  <input type=\"text\" class=\"$setting[fieldClass]\" id=\"$setting[property]\" name=\"$setting[property]\" 
										 value=\"$setting[value]\" placeholder=\"$placeholder\"$readonly$disabled>";
                        }

                        /* INPUT TEXT FIELD */
                        else if ($setting['fieldType'] === "color")
                        {    // draw an input field
                            $placeholder = $setting['placeholder'];     // store placeholder from array in var to use it at language array
                            if (!empty($setting['icon']) || (!empty($setting['heading']) || (!empty($setting['subtext']))))
                            {
                                echo "<h3>$setting[icon]&nbsp;$setting[heading]&nbsp;<small>$setting[subtext]</small></h3>";
                            }
                            echo "<label for=\"$setting[property]\">$setting[label] $setting[description]</label>
                                  <input type=\"text\" class=\"$setting[fieldClass]\" id=\"$setting[property]\" name=\"$setting[property]\" 
										 value=\"$setting[value]\">";
                        }
                    }
                }
            }
        }

        /**
         * @brief override the current language
         * @param array $lang language array
         */
        static function getCurrentLanguageFormElements($lang)
        {
            echo "<h2>Language <small>override the selected language</small></h2>";
            $i = 0;
            foreach ($lang as $property=>$tag)
            {
                $i++;
                echo "<label for=\"$property\">$property</label>
					  <input type=\"text\" id=\"$property\" class=\"form-control\" name=\"$property\" value=\"$tag\"><br>";
            }
            echo "Total: ".$i." language tags found.";
        }

        /**
         * @brief get all settings by typeID
         * @param object $db database
         * @param int $typeID settings type to get settings for
         * @return array|bool returns an array with requested settings or false
         */
        public static function getSettingsByType($db, $typeID)
        {   /* @param $db \YAWK\db */
            if ($res = $db->query("SELECT * FROM {settings} WHERE type = $typeID"))
            {
                $settingsArray = array();
                while ($row = $res->fetch_assoc())
                {   // fill array with settings by type
                    $settingsArray[] = $row;
                }
            }
            else
            {   // query failed...
                \YAWK\sys::setSyslog($db, 35, 1, "could not get settings for typeID $typeID ", 0, 0, 0, 0);
                return false;
            }
            return $settingsArray;
        }

        /**
         * @brief Returns an associative array containing the editor settings
         * @param object $db Database object
         * @param int $typeID The ID of settings type to get.
         * @return array|bool
         */
        public static function getEditorSettings($db, $typeID=0)
        {   /* @param $db \YAWK\db */
            // check if type is set, if not, try to fetch it
            if (!isset($typeID) || ($typeID == 0))
            {   // if type is not set, try to query db to get the ID of editor settings
                if ($res = $db->query("SELECT id FROM {settings_types} WHERE value = 'editor'"))
                {   // fetch data
                    if ($row = mysqli_fetch_row($res))
                    {
                        $typeID = $row[0];
                    }
                }
                else
                {   // no type was set, try to fetch editor type failed.
                    \YAWK\sys::setSyslog($db, 35, 1, "failed to get editor settings from database ", 0, 0, 0, 0);
                    \YAWK\alert::draw("danger", "Could not fetch editor settings.", "Settings type not set. Tried to fetch, but it seems that there is no setting type called editor.", "", 6500);
                }
            }
            // ok, now we got the type, lets go: fetch editor settings
            if ($res = $db->query("SELECT * FROM {settings} WHERE type = $typeID"))
            {   // build an array
                $editorSettingsArray = array();
                while ($row = $res->fetch_assoc())
                {   // fill it with settings
                    if ($row['property'] === "editorLineNumbers") {
                        if ($row['value'] == "1") { $row['value'] = "true"; } else { $row['value'] = "false"; }
                    }
                    if ($row['property'] === "editorSmartIndent") {
                        if ($row['value'] == "1") { $row['value'] = "true"; } else { $row['value'] = "false"; }
                    }
                    if ($row['property'] === "editorActiveLine") {
                        if ($row['value'] == "1") { $row['value'] = "true"; } else { $row['value'] = "false"; }
                    }
                    if ($row['property'] === "editorCloseBrackets") {
                        if ($row['value'] == "1") { $row['value'] = "true"; } else { $row['value'] = "false"; }
                    }
                    if ($row['property'] === "editorCloseTags") {
                        if ($row['value'] == "1") { $row['value'] = "true"; } else { $row['value'] = "false"; }
                    }
                    if ($row['property'] === "editorMatchBrackets") {
                        if ($row['value'] == "1") { $row['value'] = "true"; } else { $row['value'] = "false"; }
                    }
                    if ($row['property'] === "editorMatchTags") {
                        if ($row['value'] == "1") { $row['value'] = "true"; } else { $row['value'] = "false"; }
                    }
                    if ($row['property'] === "editorAutoCodeview") {
                        if ($row['value'] == "1") { $row['value'] = "true"; } else { $row['value'] = "false"; }
                    }
                    $editorSettingsArray[$row['property']] = $row['value'];
                }
            }
            else
            {   // query failed...
                return false;
            }
            return $editorSettingsArray;
        }


        /**
         * @brief Returns an array with all settings data.
         * @param object $db Database Object
         * @return array|bool
         */
        public static function getAllSettingsIntoArray($db) // get all settings from db like property
        {
            /* @param $db \YAWK\db */
            if ($res= $db->query("SELECT * FROM {settings} ORDER by sortation"))
            {
                $settingsArray = array();
                while ($row = $res->fetch_assoc())
                {   // fill array
                    $settingsArray[] = $row;
                }
            }
            else
            {   // q failed, throw error
                \YAWK\sys::setSyslog($db, 35, 1, "failed to get settings from database ", 0, 0, 0, 0);
                // \YAWK\alert::draw("warning", "Warning!", "Fetch database error: getSettingsArray failed.","","4800");
                return false;
            }
            return $settingsArray;
        }

        /**
         * @brief Get and return value for property from settings database.
         * @version 1.0.0
         * @author Daniel Retzl <danielretzl@gmail.com>
         * @param object $db Database object
         * @param object $lang language array
         * @param string $property Property to select from database
         * @return bool
         */
        public static function getSetting($db, $property) // get a single setting from db
        {    /* @param $db \YAWK\db */
            $sql = $db->query("SELECT value FROM {settings} WHERE property = '".$property."'");

            // fetch data from db
            if ($row = mysqli_fetch_row($sql))
            {   // return settings of property
                if (isset($row[0]) && (!empty($row[0])))
                {
                    return $row[0];
                }
                else
                {
                    return false;
                }
            }
            else
            {   // q failed, throw error
                return false;
            }
        }

        /**
         * @brief Set value for property into settings database.
         * @version 1.0.0
         * @author Daniel Retzl <danielretzl@gmail.com>
         * @param object $db Database object
         * @param object $db language
         * @param string $property Property to set into database
         * @param string $value Value to set into database
         * @return bool
         */
        public static function setSetting($db, $property, $value, $lang)
        {   /* @param $db \YAWK\db */
            $property = $db->quote($property);
            $value = $db->quote($value);
            if ($res = $db->query("UPDATE {settings} SET value = '".$value."' WHERE property = '".$property."'")) {
                // success
                // \YAWK\alert::draw("success", "$lang[SUCCESS]","$lang[SETTING] $property $lang[SAVED]","","120");
                return true;
            }
            else
            {   // q failed
                \YAWK\sys::setSyslog($db, 35, 1, "failed to set <b>$value</b> to <b>$property</b> ", 0, 0, 0, 0);
                \YAWK\alert::draw("warning", "$lang[WARNING]", "$lang[SETTING] $property $lang[NOT_SAVED]", "","4800");
                return false;
            }
        }

        /**
         * @brief Get and return longValue for property from settings database.
         * @version 1.0.0
         * @author Daniel Retzl <danielretzl@gmail.com>
         * @param object $db Database object
         * @param string $property Property to get longValue from database.
         * @return mixed
         */
        public static function getLongSetting($db, $property)
        {   /* @param $db \YAWK\db */
            if ($res = $db->query("SELECT longValue FROM {settings} WHERE property = '".$property."'")) {
                $row = mysqli_fetch_row($res);
                $res->close();
                return $row[0];
            }
            else
            {   // q failed, throw error
                \YAWK\sys::setSyslog($db, 35, 1, "failed to get settings longValue from property <b>$property</b> ", 0, 0, 0, 0);
                \YAWK\alert::draw("warning", "Warning!", "Fetch database error: getLongSetting failed.","","4800");
                return false;
            }
        }

        /**
         * @brief Set (update) template setting value for property.
         * @version 1.0.0
         * @author Daniel Retzl <danielretzl@gmail.com>
         * @param object $db Database object
         * @param string $property Template property to set
         * @param string $value Template value to set
         * @return bool
         */
        public static function setTemplateSetting($db, $property, $value)
        {
            /* @param $db \YAWK\db */
            $property = $db->quote($property);
            $value = $db->quote($value);
            if ($res = $db->query("UPDATE {template_settings} SET value = '".$value."' WHERE property = '".$property."'"))
            {   // success
                \YAWK\alert::draw("success", "Success!","Template setting $property saved.","","120");
                return true;
            }
            else
            {   // q failed, throw error
                \YAWK\sys::setSyslog($db, 35, 1, "failed to set templateSetting <b>$value</b> to <b>$property</b> ", 0, 0, 0, 0);
                \YAWK\alert::draw("danger", "Error!", "Sorry, could not save template setting $property.","","4800");
                return false;
            }
        }

        /**
         * @brief Set (update) long setting value for property.
         * @version 1.0.0
         * @author Daniel Retzl <danielretzl@gmail.com>
         * @param object $db Database object
         * @param string $property Property to set
         * @param string $value Long value to set
         * @return bool
         */
        public static function setLongSetting($db, $property, $value)
        {
            /* solution for redirect after db update
            if (!empty($_SERVER['HTTP_REFERER'])){
                $referer = $_SERVER['HTTP_REFERER'];
            } else {
                $referer = "index.php";
            }
            */
            /* @param $db \YAWK\db */
            $property = $db->quote($property);
            $value = $db->quote($value);
            if ($res = $db->query("UPDATE {settings} SET longValue = '".$value."' WHERE property = '".$property."'"))
            {   // success
                // \YAWK\alert::draw("success", "Success!","Setting $property saved.","","120");
                return true;
            }
            else
            {   // q failed, throw error
                \YAWK\sys::setSyslog($db, 35, 1, "failed to set settings longValue <b>$value</b> to <b>$property</b> ", 0, 0, 0, 0);
                \YAWK\alert::draw("danger", "Error!", "Sorry, update database error: could not set LongValue: ".$value." - setLongSetting failed.", "","4800");
                return false;
                // echo \YAWK\backend::setTimeout($referer,"4800");
            }
        }

        /**
         * @brief Get setting description from requested property.
         * @version 1.0.0
         * @author Daniel Retzl <danielretzl@gmail.com>
         * @param object $db Database object
         * @param string $property Property to get description from.
         * @return bool
         */
        public static function getSettingDescription($db, $property)
        { /* @param $db \YAWK\db */
            if ($res = $db->query("SELECT description FROM {settings} WHERE property = '".$property."'")) {
                $row = mysqli_fetch_row($res);
                return $row[0];
            }
            else
            {   // q failed, throw error
                \YAWK\sys::setSyslog($db, 35, 1, "failed to set settings description of <b>$property</b> ", 0, 0, 0, 0);
                \YAWK\alert::draw("warning", "Warning!", "Error loading setting description of property $property", "","4800");
                return false;
            }
        }

        /**
         * @brief Get widget setting value from widgets_settings.
         * @version 1.0.0
         * @author Daniel Retzl <danielretzl@gmail.com>
         * @param object $db Database object
         * @param string $property Property to get value from.
         * @return bool
         */
        public static function getWidgetSetting($db, $property)
        {
            /* @param $db \YAWK\db */
            if ($res = $db->query("SELECT value FROM {widget_settings}
                                   WHERE property = '".$property."' AND widgetID = '".$widgetID."'")) {
                $row = mysqli_fetch_row($res);
                $res->close();
                return $row[0];
            }
            else
            {   // q failed, throw error
                \YAWK\sys::setSyslog($db, 35, 1, "failed to get widget setting of <b>$property</b> ", 0, 0, 0, 0);
                \YAWK\alert::draw("warning", "Warning!", "Error loading Widget Setting $property","","4800");
                return false;
            }
        }

        /**
         * @brief Set widget setting value into widgets_settings.
         * @version 1.0.0
         * @author Daniel Retzl <danielretzl@gmail.com>
         * @param object $db Database object
         * @param string $property Property to get value from.
         * @param string $value Value of requested property
         * @param int $widgetID WidgetID to get value from.
         * @return bool
         */
        public static function setWidgetSetting($db, $property, $value, $widgetID)
        {
            /* @param $db \YAWK\db */
            $property = $db->quote($property);
            $value = $db->quote($value);
            $value = nl2br($value);
            $value = preg_replace('/\<br (\s*)?\/?\>/i', "", $value); // to make sure html code gets stored properly
            if ($res = $db->query("UPDATE {widget_settings} SET value = '".$value."'
                                   WHERE property = '".$property."' AND widgetID = '".$widgetID."'"))
            {   // q successful
                // uncomment following line, if you wish detailed save messages
                // \YAWK\alert::draw("success", "Success!", "Widget Setting $property saved.", "","1200");
                return true;
            }
            else
            {
                // q failed
                \YAWK\sys::setSyslog($db, 35, 1, "failed to set widget value <b>$value</b> of <b>$property</b> ", 0, 0, 0, 0);
                \YAWK\alert::draw("danger", "Error!", "Sorry, update database error: could not set Widget Setting $value of property $property.", "","4800");
                return false;
                // echo \YAWK\backend::setTimeout($referer,"4800");
            }
        }

        /**
         * @brief Toggle setting offline where requested property.
         * @version 1.0.0
         * @author Daniel Retzl <danielretzl@gmail.com>
         * @param object $db Database object
         * @param object $lang language
         * @param string $property Property to get value from.
         * @param string $new_status
         * @return bool
         */
        public static function toggleOffline($db, $property, $new_status, $lang)
        {
            /* @param $db \YAWK\db */
            $property = $db->quote($property);
            $new_status = $db->quote($new_status);
            if ($res = $db->query("UPDATE {settings} SET activated = '" . $new_status . "'
                                   WHERE property = '" . $property . "'"))
            {   // success
                return true;
            }
            else
            {   // q failed, throw error
                \YAWK\sys::setSyslog($db, 35, 1, "failed to toggle <b>$new_status</b> of <b>$property</b> ", 0, 0, 0, 0);
                \YAWK\alert::draw("danger", "Error!", "$lang[TOGGLE_FAILED] $property $lang[TO] $new_status", "","4800");
                return false;
            }
        }
    } // ./ settings class
} // ./ namespace