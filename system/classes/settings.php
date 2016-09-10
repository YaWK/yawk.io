<?php
namespace YAWK {
    /**
     * <b>methods to get and set yawk system settings</b>
     * @package YAWK
     */
    class settings
    {
        /**
         * @param $property
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
         * @param $property
         * @return mixed
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
         * @param $property
         * @param $value
         */
        public static function setSetting($db, $property, $value)
        {
            /* @var $db \YAWK\db */
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
         * @param $property
         * @return mixed
         */
        public static function getLongSetting($db, $property)
        { /* @var $db \YAWK\db */
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
     * @param $property
     * @param $value
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
         * @param $property
         * @return mixed
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
         * @param $property
         * @return mixed
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
         * @param $property
         * @param $value
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
         * @param $property
         * @param $new_status
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