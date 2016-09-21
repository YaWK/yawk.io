<?php
namespace YAWK {
    /**
     * <b>methods to get and set yawk system settings</b>
     * @author Daniel Retzl <danielretzl@gmail.com>
     * @version 1.0.0
     * @website http://yawk.website
     */
    class settings
    {
        /**
         * Returns an array with all setings where property is like $property.
         * @author Daniel Retzl <danielretzl@gmail.com>
         * @version 1.0.0
         * @website http://yawk.website
         * @param object $db Database Object
         * @param string $property
         * @return mixed
         */
        public static function getSettingsArray($db, $property) // get all settings from db like property
        {
            /* @var $db \YAWK\db */
            if ($res= $db->query("SELECT * FROM {settings} WHERE property LIKE '".$property."'")) {
                $settingsArray = array();
                while ($row = $res->fetch_assoc())
                {   // fill array
                    $settingsArray[] = $row;
                }
            }
            else
            {   // q failed, throw error
                \YAWK\alert::draw("warning", "Warning!", "Fetch database error: getSettingsArray failed.","","4800");
                return false;
            }
            return $settingsArray;
        }

        /**
         * Return corresponding form elements for given settings.
         * @author Daniel Retzl <danielretzl@gmail.com>
         * @version 1.0.0
         * @website http://yawk.website
         * @param object $db
         * @param array $settings
         * @param int $type
         */
        public static function getFormElements($db, $settings, $type)
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
            {	// check if field type is not set or empty
                if (!isset($setting['fieldType']) && (empty($fieldType)))
                {   // set input field as default
                    $setting['fieldType'] = "input";
                }
                else
                {   // settings type must be equal to param $type
                    if ($setting['type'] === "$type")
                    {
                      //  $i_settings++;
                        if ($setting['property'] === "selectedTemplate")
                        {   // TEMPLATE / THEME SELECTOR
                            \YAWK\backend::drawTemplateSelectField($db);
                            echo "<br>";
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
                        echo "
                        <input type=\"checkbox\" id=\"$setting[property]\" name=\"$setting[property]\" value=\"$setting[value]\" $checked>
                        <label for=\"$setting[property]\">$setting[description]</label><br>";
                        }

                        /* TEXTAREA */
                        else if ($setting['fieldType'] === "textarea")
                        {    // if a long value is set
                            if (isset($setting['longValue']) && (!empty($setting['longValue'])))
                            {   // build a longValue tagged textarea and fill with longValue
                                $setting['longValue'] = nl2br($setting['longValue']);
                                echo "<label for=\"$setting[property]-long\">$setting[description]</label>
                                      <textarea class=\"$setting[fieldClass]\" id=\"$setting[property]-long\" name=\"$setting[property]-long\">$setting[longValue]</textarea>";
                            }
                            else
                            {   // draw default textarea
                                $setting['value'] = nl2br($setting['value']);
                                echo "<label for=\"$setting[property]-long\">$setting[description]</label>
                                      <textarea class=\"$setting[fieldClass]\" id=\"$setting[property]\" name=\"$setting[property]\">$setting[value]</textarea>";
                            }
                        }
                        /* INPUT FIELD */
                        else if ($setting['fieldType'] === "input")
                        {    // draw an input field
                            echo "<input class=\"$setting[fieldClass]\" id=\"$setting[property]\" name=\"$setting[property]\" 
												 value=\"$setting[value]\" placeholder=\"$setting[placeholder]\"><br>
												 <label for=\"$setting[property]\">$setting[description]</label>";
                        }
                        /*
                        else
                        {   // draw an input field
                            echo "<label for=\"$setting[property]\">$setting[description]</label>
                                  <input class=\"$setting[fieldClass]\" id=\"$setting[property]\" name=\"$setting[property]\" 
							             value=\"$setting[value]\" placeholder=\"$setting[placeholder]\"><br>";
                        }
                        */
                    }
                }

                if (isset($setting['longValue']) && (!empty($setting['longValue'])))
                {

                }
            }
           // echo "<p>Total: $i_settings settings</p>";
        }

        /**
         * Returns an array with all settings data.
         * @author Daniel Retzl <danielretzl@gmail.com>
         * @version 1.0.0
         * @website http://yawk.website
         * @param object $db Database Object
         * @return array|bool
         */
        public static function getAllSettingsIntoArray($db) // get all settings from db like property
        {
            /* @var $db \YAWK\db */
            if ($res= $db->query("SELECT * FROM {settings} ORDER by sortation")) {
                $settingsArray = array();
                while ($row = $res->fetch_assoc())
                {   // fill array
                    $settingsArray[] = $row;
                }
            }
            else
            {   // q failed, throw error
                \YAWK\alert::draw("warning", "Warning!", "Fetch database error: getSettingsArray failed.","","4800");
                return false;
            }
            return $settingsArray;
        }

        /**
         * Get and return value for property from settings database.
         * @version 1.0.0
         * @author Daniel Retzl <danielretzl@gmail.com>
         * @website http://yawk.website
         * @param object $db Database object
         * @param string $property Property to select from database
         * @return bool
         */
        public static function getSetting($db, $property) // get a single setting from db
        {    /* @var $db \YAWK\db */
            if ($res = $db->query("SELECT value FROM {settings} WHERE property = '".$property."'"))
            {   // fetch data
                $row = mysqli_fetch_row($res);
                return $row[0];
            }
            else
            {   // q failed, throw error
                \YAWK\alert::draw("warning", "Warning!", "Fetch database error: getSetting failed.","","4800");
                return false;
            }
        }

        /**
         * Set value for property into settings database.
         * @version 1.0.0
         * @author Daniel Retzl <danielretzl@gmail.com>
         * @website http://yawk.website
         * @param object $db Database object
         * @param string $property Property to set into database
         * @param string $value Value to set into database
         * @return bool
         */
        public static function setSetting($db, $property, $value)
        {   /* @var $db \YAWK\db */
            $property = $db->quote($property);
            $value = $db->quote($value);
            if ($res = $db->query("UPDATE {settings} SET value = '".$value."' WHERE property = '".$property."'")) {
                // success
                \YAWK\alert::draw("success", "Success!","Setting $property saved.","","120");
                return true;
            }
            else
            {   // q failed
                \YAWK\alert::draw("warning", "Warning!", "Setting $property could not be saved.", "","4800");
                return false;
            }
        }

        /**
         * Get and return longValue for property from settings database.
         * @version 1.0.0
         * @author Daniel Retzl <danielretzl@gmail.com>
         * @website http://yawk.website
         * @param object $db Database object
         * @param string $property Property to get longValue from database.
         * @return mixed
         */
        public static function getLongSetting($db, $property)
        {   /* @var $db \YAWK\db */
            if ($res = $db->query("SELECT longValue FROM {settings} WHERE property = '".$property."'")) {
                $row = mysqli_fetch_row($res);
                $res->close();
                return $row[0];
            }
            else
            {   // q failed, throw error
                \YAWK\alert::draw("warning", "Warning!", "Fetch database error: getLongSetting failed.","","4800");
                return false;
            }
        }

        /**
         * Set (update) template setting value for property.
         * @version 1.0.0
         * @author Daniel Retzl <danielretzl@gmail.com>
         * @website http://yawk.website
         * @param object $db Database object
         * @param string $property Template property to set
         * @param string $value Template value to set
         * @return bool
         */
        public static function setTemplateSetting($db, $property, $value)
        {
            /* @var $db \YAWK\db */
            $property = $db->quote($property);
            $value = $db->quote($value);
            if ($res = $db->query("UPDATE {template_settings} SET value = '".$value."' WHERE property = '".$property."'"))
            {   // success
                \YAWK\alert::draw("success", "Success!","Template setting $property saved.","","120");
                return true;
            }
            else
            {   // q failed, throw error
                \YAWK\alert::draw("danger", "Error!", "Sorry, could not save template setting $property.","","4800");
                return false;
            }
        }

        /**
         * Set (update) long setting value for property.
         * @version 1.0.0
         * @author Daniel Retzl <danielretzl@gmail.com>
         * @website http://yawk.website
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
            /* @var $db \YAWK\db */
            $property = $db->quote($property);
            $value = $db->quote($value);
            if ($res = $db->query("UPDATE {settings} SET longValue = '".$value."' WHERE property = '".$property."'"))
            {   // success
                \YAWK\alert::draw("success", "Success!","Setting $property saved.","","120");
                return true;
            }
            else
            {   // q failed, throw error
                \YAWK\alert::draw("danger", "Error!", "Sorry, update database error: could not set LongValue: ".$value." - setLongSetting failed.", "","4800");
                return false;
                // echo \YAWK\backend::setTimeout($referer,"4800");
            }
        }

        /**
         * Get setting description from requested property.
         * @version 1.0.0
         * @author Daniel Retzl <danielretzl@gmail.com>
         * @website http://yawk.website
         * @param object $db Database object
         * @param string $property Property to get description from.
         * @return bool
         */
        public static function getSettingDescription($db, $property)
        { /* @var $db \YAWK\db */
            if ($res = $db->query("SELECT description FROM {settings} WHERE property = '".$property."'")) {
                $row = mysqli_fetch_row($res);
                return $row[0];
            }
            else
            {   // q failed, throw error
                \YAWK\alert::draw("warning", "Warning!", "Error loading setting description of property $property", "","4800");
                return false;
            }
        }

        /**
         * Get widget setting value from widgets_settings.
         * @version 1.0.0
         * @author Daniel Retzl <danielretzl@gmail.com>
         * @website http://yawk.website
         * @param object $db Database object
         * @param string $property Property to get value from.
         * @return bool
         */
        public static function getWidgetSetting($db, $property)
        {
            /* @var $db \YAWK\db */
            if ($res = $db->query("SELECT value FROM {widget_settings}
                                   WHERE property = '".$property."' AND widgetID = '".$widgetID."'")) {
                $row = mysqli_fetch_row($res);
                $res->close();
                return $row[0];
            }
            else
            {   // q failed, throw error
                \YAWK\alert::draw("warning", "Warning!", "Error loading Widget Setting $property","","4800");
                return false;
            }
        }

        /**
         * Set widget setting value into widgets_settings.
         * @version 1.0.0
         * @author Daniel Retzl <danielretzl@gmail.com>
         * @website http://yawk.website
         * @param object $db Database object
         * @param string $property Property to get value from.
         * @param string $value Value of requested property
         * @param int $widgetID WidgetID to get value from.
         * @return bool
         */
        public static function setWidgetSetting($db, $property, $value, $widgetID)
        {
            /* @var $db \YAWK\db */
            $property = $db->quote($property);
            $value = $db->quote($value);
            if ($res = $db->query("UPDATE {widget_settings} SET value = '".$value."'
                                   WHERE property = '".$property."' AND widgetID = '".$widgetID."'"))
            {   // q successful
                \YAWK\alert::draw("success", "Success!", "Widget Setting $property saved.", "","1200");
                return true;
            }
            else
            {
                // q failed
                \YAWK\alert::draw("danger", "Error!", "Sorry, update database error: could not set Widget Setting $value of property $property.", "","4800");
                return false;
                // echo \YAWK\backend::setTimeout($referer,"4800");
            }
        }

        /**
         * Toggle setting offline where requested property.
         * @version 1.0.0
         * @author Daniel Retzl <danielretzl@gmail.com>
         * @website http://yawk.website
         * @param object $db Database object
         * @param string $property Property to get value from.
         * @param string $new_status
         * @return bool
         */
        public static function toggleOffline($db, $property, $new_status)
        {
            /* @var $db \YAWK\db */
            $property = $db->quote($property);
            $new_status = $db->quote($new_status);
            if ($res = $db->query("UPDATE {settings} SET activated = '" . $new_status . "'
                                   WHERE property = '" . $property . "'"))
            {   // success
                return true;
            }
            else
            {   // q failed, throw error
                \YAWK\alert::draw("danger", "Error!", "Could not toggle $property to status $new_status", "","4800");
                return false;
            }
        }
    } // ./ settings class
} // ./ namespace