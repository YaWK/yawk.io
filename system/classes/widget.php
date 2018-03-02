<?php
namespace YAWK {
    /**
     * <b>Widgets are small, useful tools that you can include everywhere on your website.</b>
     *
     * YaWK comes with a lot of widgets for different purposes. As an example, you can add SocialMedia buttons, Facebook
     * Boxes, Likebuttons or other things like a simple contant and many other small utilities for typical daily needs
     * of nearly every web project. Check out the files in system/widgets to get a clue about how widget's file
     * structure is organized. You miss a widget? Dont worry. It is easy to create your own - or copy and modify
     * an existing one to make it fit your needs. If you want to get deeper into the widget system of YaWK, read
     * the following docs.
     * <p><i>Class covers both, backend & frontend functionality.
     * See Methods Summary for Details!</i></p>
     *
     * @package    YAWK
     * @author     Daniel Retzl <danielretzl@gmail.com>
     * @copyright  2009-2016 Daniel Retzl
     * @license    https://opensource.org/licenses/MIT
     * @version    1.0.0
     * @link       http://yawk.io
     * @annotation Widgets are small, useful tools that you can include everywhere in your website.
     */
    class widget
    {
        /** * @var int 0|1 published or not */
        public $published;
        /** * @var int widget ID */
        public $id;
        /** * @var string widget name */
        public $name;
        /** * @var int order sortation number */
        public $sort;
        /** * @var string template position to appear */
        public $position;
        /** * @var int widget type number */
        public $widgetType;
        /** * @var int margin from top in px */
        public $marginTop;
        /** * @var int margin from bottom in px */
        public $marginBottom;
        /** * @var int ID of the page where this widget should appear */
        public $pageID;
        /** * @var string date when widget publishing starts */
        public $date_publish;
        /** * @var string date when widget publishing ends */
        public $date_unpublish;
        /** * @var string title to identify the widget */
        public $widgetTitle;
        /** * @var string foldername of this widget */
        public $folder;




        /**
         * return current widget path
         * @author Daniel Retzl <danielretzl@gmail.com>
         * @version 1.0.0
         * @link http://yawk.io
         * @param object $db database
         * @return string full path to widgets folder
         */
        static function getCurrentWidgetPath($db)
        {
            return "" . \YAWK\sys::getDirPrefix($db) . "/system/widgets/";
        }


        // TODO: IMPLEMENT GET WIDGET SETTINGS ARRRAY for issue #61
        /**
         * Returns an array with all widget settings data.
         * @author Daniel Retzl <danielretzl@gmail.com>
         * @version 1.0.0
         * @link http://yawk.io
         * @param object $db Database Object
         * @return array|bool
         */
        public static function getAllSettingsIntoArray($db, $widgetID) // get all settings from db like property
        {
            /* @var $db \YAWK\db */
            if ($res = $db->query("SELECT * FROM {widget_settings} WHERE widgetID = '".$widgetID."' ORDER by sortation"))
            {
                $settingsArray = array();
                while ($row = $res->fetch_assoc())
                {   // fill array
                    $settingsArray[] = $row;
                }
            }
            else
            {   // q failed, throw error
                \YAWK\sys::setSyslog($db, 5, "could not get widget settings from database ", 0, 0, 0, 0);
                // \YAWK\alert::draw("warning", "Warning!", "Fetch database error: getSettingsArray failed.","","4800");
                return false;
            }
            return $settingsArray;
        }


        // TODO: IMPLEMENT GET FORM ELEMENTS for issue #61
        /**
         * Return settings as form elements corresponding to given widget ID.
         * @author Daniel Retzl <danielretzl@gmail.com>
         * @version 1.0.0
         * @link http://yawk.io
         * @param object $db Database Object
         * @param array  $settings Settings: property|value|type|sortation|activated|label|icon|heading|subtext|fieldClass|fieldType|placeholder|description|options
         * @param int    $widgetID
         */
        public static function getWidgetFormElements($db, $settings, $widgetID, $widgetFolder, $lang)
        {	// loop trough array
            $i_settings = 0;


            if(!isset($widgetID) && (empty($widgetID)))
            {	// if param 'type' is missing, show all settings
                die ("Could not get widget settings because widget ID is missing.");
            }

            if(!isset($settings) || (empty($settings)) || (!is_array($settings)))
            {	// if settings are not set, try to get them...
                $settings = self::getAllSettingsIntoArray($db, $widgetID);
            }

            if (is_array($settings))
            {
                // echo "<pre>";
                // print_r($settings);
                // echo "</pre>";
                /*
                foreach ($settings as $type => $setting)
                {
                    if (!isset($setting['fieldType']) || (empty($setting['fieldType'])))
                    {
                        $setting['fieldType'] = "input";
                    }

                    echo $setting['fieldType']."<br>";

                }
                */
            }

            // check if language is set
            if (!isset($language) || (!isset($lang)))
            {   // inject (add) language tags to core $lang array
                $lang = \YAWK\language::inject($lang, "../system/widgets/$widgetFolder/language/");
            }

            foreach ($settings as $type => $setting)
            {	// field type not set or empty
                if (!isset($setting['fieldType']) || (empty($setting['fieldType'])))
                {   // set input field as common default
                    $setting['fieldType'] = "input";
                }  // settings type must be equal to param $type
                    // equals settings category
                    if ($setting['widgetID'] === "$widgetID" && ($setting['activated'] === "1"))
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
                            $setting['label'] = "$setting[property]";
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

                        // CHECKBOX
                        if ($setting['fieldType'] === "checkbox")
                        {    // build a checkbox
                            if ($setting['value'] === "1" or ($setting['value'] === "true"))
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
                              <label for=\"$setting[property]\">&nbsp; $setting[label]&nbsp;$setting[description]</label><br>";
                        }

                        /* RADIO BUTTTONS */
                        if ($setting['fieldType'] === "radio")
                        {
                            echo "<label for=\"$setting[property]\">$setting[label]&nbsp;$setting[description]</label>
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
                        }

                        /* SELECT FIELD */
                        if ($setting['fieldType'] === "select")
                        {   // display icon, heading and subtext, if its set
                            if (!empty($setting['icon']) || (!empty($setting['heading']) || (!empty($setting['subtext']))))
                            {
                                echo "<h3>$setting[icon]&nbsp;$setting[heading]&nbsp;<small>$setting[subtext]</small></h3>";
                            }
                            // begin draw select
                                echo "<label for=\"$setting[property]\">$setting[label]&nbsp;$setting[description]</label>
                                          <select class=\"form-control\" id=\"$setting[property]\" name=\"$setting[property]\">";
                                echo "<option value=\"$setting[value]\">$lang[SETTING_CURRENT] $setting[value]</option>";
                                // explode option string into array
                                $optionValues = explode(":", $setting['options']);
                                foreach ($optionValues as $value)
                                {
                                    // extract description from option setting
                                    $optionDesc = preg_replace('/.*,(.*)/','$1', $value);
                                    // extract value from option setting string
                                    $optionValue = preg_split("/,[a-zA-Z0-9]*/", $value);

                                    echo "<option value=\"$optionValue[0]\">$optionDesc</option>";
                                }
                                echo "</select>";
                        }

                        /* TEXTAREA */
                        if ($setting['fieldType'] === "textarea")
                        {    // if a long value is set
                            if (!empty($setting['icon']) || (!empty($setting['heading']) || (!empty($setting['subtext']))))
                            {
                                echo "<h3>$setting[icon]&nbsp;$setting[heading]&nbsp;$setting[subtext]</h3>";
                            }
                            $placeholder = $setting['placeholder'];     // store placeholder from array in var to use it at language array
                            if (isset($setting['longValue']) && (!empty($setting['longValue'])))
                            {   // build a longValue tagged textarea and fill with longValue
                                $setting['longValue'] = nl2br($setting['longValue']);
                                echo "<label for=\"$setting[property]-long\">$setting[label]&nbsp;$setting[description]</label>
                                      <textarea cols=\"64\" rows=\"10\" placeholder=\"$lang[$placeholder]\" class=\"$setting[fieldClass]\" id=\"$setting[property]-long\" name=\"$setting[property]-long\">$setting[longValue]</textarea>";
                            }
                            else
                            {   // draw default textarea
                                $placeholder = $setting['placeholder'];     // store placeholder from array in var to use it at language array
                                $setting['value'] = nl2br($setting['value']);
                                echo "<label for=\"$setting[property]\">$setting[label]&nbsp;$setting[description]</label>
                                      <textarea cols=\"64\" rows=\"10\" placeholder=\"$lang[$placeholder]\" class=\"$setting[fieldClass]\" id=\"$setting[property]\" name=\"$setting[property]\">$setting[value]</textarea>";
                            }
                        }

                        /* INPUT PASSWORD FIELD */
                        if ($setting['fieldType'] === "password")
                        {    // draw an input field
                            $placeholder = $setting['placeholder'];     // store placeholder from array in var to use it at language array
                            if (!empty($setting['icon']) || (!empty($setting['heading']) || (!empty($setting['subtext']))))
                            {
                                echo "<h3>$setting[icon]&nbsp;$setting[heading]&nbsp;<small>$setting[subtext]</small></h3>";
                            }
                            echo "<label for=\"$setting[property]\">$setting[label]&nbsp;$setting[description]</label>
                                  <input type=\"password\" class=\"$setting[fieldClass]\" id=\"$setting[property]\" name=\"$setting[property]\" 
										 value=\"$setting[value]\" placeholder=\"$lang[$placeholder]\"><p>$setting[description]</p>";
                        }

                        /* INPUT TEXT FIELD */
                        if ($setting['fieldType'] === "input")
                        {    // draw an input field
                            $placeholder = $setting['placeholder'];     // store placeholder from array in var to use it at language array
                            if (!empty($setting['icon']) || (!empty($setting['heading']) || (!empty($setting['subtext']))))
                            {
                                echo "<h3>$setting[icon]&nbsp;$setting[heading]&nbsp;<small>$setting[subtext]</small></h3>";
                            }
                            echo "<label for=\"$setting[property]\">$setting[label]&nbsp;$setting[description]</label>
                                  <input type=\"text\" class=\"$setting[fieldClass]\" id=\"$setting[property]\" name=\"$setting[property]\" 
										 value=\"$setting[value]\" placeholder=\"$lang[$placeholder]\">";
                        }

                        /* COLORPICKER TEXT FIELD */
                        if ($setting['fieldType'] === "color")
                        {    // draw an input field
                            $placeholder = $setting['placeholder'];     // store placeholder from array in var to use it at language array
                            if (!empty($setting['icon']) || (!empty($setting['heading']) || (!empty($setting['subtext']))))
                            {
                                echo "<h3>$setting[icon]&nbsp;$setting[heading]&nbsp;$setting[subtext]</h3>";
                            }
                            echo "<label for=\"$setting[property]\">$setting[label] $setting[description]</label>
                                  <input type=\"text\" class=\"$setting[fieldClass]\" id=\"$setting[property]\" name=\"$setting[property]\" 
										 value=\"$setting[value]\" placeholder=\"$lang[$placeholder]\">";
                        }
                    }
                }
            }


        /**
         * create new widget
         * @author Daniel Retzl <danielretzl@gmail.com>
         * @version 1.0.0
         * @link http://yawk.io
         * @param object $db database
         * @param int $widgetType widget type
         * @param int $pageID page ID
         * @param string $positions widget / template positions
         * @return bool
         */
        static function create($db, $widgetType, $pageID, $positions, $date_publish)
        {
            /** @var $db \YAWK\db */
            global $status;
            if ($res_widgets = $db->query("SELECT MAX(id), MAX(sort) FROM {widgets}")) {
                // generate ID
                if ($row = mysqli_fetch_row($res_widgets))
                {
                    $id = $row[0] + 1;
                    $sort = $row[1] + 1;
                    $published = 1;
                }
                else
                    {
                        // could not get MAX id
                        \YAWK\sys::setSyslog($db, 11, "could not get max ID.", 0, 0, 0, 0);
                        return false;
                    }

                // add new widget to db
                if ($res_widgets = $db->query("INSERT INTO {widgets}
                                (id, published, widgetType, pageID, sort, position, date_publish)
	                        VALUES('" . $id . "',
	                        '" . $published . "',
	                        '" . $widgetType . "',
	                        '" . $pageID . "',
	                        '" . $sort . "',
	                        '" . $positions . "',
	                        '" . $date_publish . "')"))
                {
                    // get default settings for this widget
                    if ($res_defaults = $db->query("SELECT * FROM {widget_defaults}
	                        WHERE widgetType = '" . $widgetType . "'
	                        AND activated = '1'"))
                    {   // get widget settings
                        while ($row = mysqli_fetch_assoc($res_defaults))
                        {   // widget properties
                            $w_property = $row['property'];
                            $w_value = $row['value'];
                            $w_widgetType = $row['widgetType'];
                            $w_activated = $row['activated'];
                            $w_sortation = $row['sortation'];
                            $w_label = $row['label'];
                            $w_icon = $row['icon'];
                            $w_heading = $row['heading'];
                            $w_subtext = $row['subtext'];
                            $w_fieldClass = $row['fieldClass'];
                            $w_fieldType = $row['fieldType'];
                            $w_placeholder = $row['placeholder'];
                            $w_options = $row['options'];
                            $w_description = $row['description'];

                            // insert widget settings
                            if ($db->query("INSERT INTO {widget_settings}
							      (widgetID, property, value, widgetType, activated, sortation, label, icon, heading, subtext, fieldClass, fieldType, placeholder, options, description)
	                        VALUES('" . $id . "',
	                        '" . $w_property . "',
	                        '" . $w_value . "',
	                        '" . $w_widgetType . "',
	                        '" . $w_activated . "',
	                        '" . $w_sortation . "',
	                        '" . $w_label . "',
	                        '" . $w_icon . "',
	                        '" . $w_heading . "',
	                        '" . $w_subtext . "',
	                        '" . $w_fieldClass . "',
	                        '" . $w_fieldType . "',
	                        '" . $w_placeholder . "',
	                        '" . $w_options . "',
	                        '" . $w_description . "')"))
                            {
                                // widget settings added
                            }
                            else
                                {   // insert widget settings failed
                                    \YAWK\sys::setSyslog($db, 11, "insert widget settings failed. id:$id property:$w_property value: $w_value type: $w_widgetType active: $w_activated", 0, 0, 0, 0);
                                    return false;
                                }
                        } // ./ while
                    }
                    else
                        {   // could not get widget defaults
                            \YAWK\sys::setSyslog($db, 11, "failed to set widget defaults of widget id <b>#$id</b>.", 0, 0, 0, 0);
                            return false;
                        }
                }
                else
                    {   // could not add new widget
                        \YAWK\sys::setSyslog($db, 11, "failed to add new widget .", 0, 0, 0, 0);
                        return false;
                    }
            }
            else
                {   // could not get maxID
                    \YAWK\sys::setSyslog($db, 11, "failed to get MAX(id) of widgets db .", 0, 0, 0, 0);
                    return false;
                }
            // something else has happened
            // \YAWK\sys::setSyslog($db, 11, "return $id in case of widget create.", 0, 0, 0, 0);
            return $id;
        }


        /**
         * load a widget into given position
         * @author Daniel Retzl <danielretzl@gmail.com>
         * @version 1.0.0
         * @link http://yawk.io
         * @param object $db database
         * @param string $position template position where widget should appear
         * @return null|bool include widget and return null or false
         */
        static function loadWidgets($db, $position)
        {
            // current date + time
            $atm = date("Y-m-d G:i:s");

            /** @var $db \YAWK\db */
            global $currentpage;
            if ($res = $db->query("SELECT cw.id,cw.published,cw.widgetType,cw.pageID,cw.sort,cw.position, cw.date_publish, cw.date_unpublish, cwt.name, cwt.folder
    							FROM {widgets} as cw
    							JOIN {widget_types} as cwt on cw.widgetType = cwt.id
    							WHERE (cw.pageID = '" . $currentpage->id . "' OR cw.pageID = '0')
    							AND cw.position = '" . $position . "' AND published = '1'
    							ORDER BY cw.sort"))
            {   // fetch widget data
                while ($row = mysqli_fetch_assoc($res))
                {
                    $_GET['widgetID'] = $row['id'];

                    // check publish date and show entry
                    if ($atm > $row['date_publish'] || ($row['date_publish'] <=> NULL) || (empty($row['date_publish'])))
                    {
                        // if current date is bigger than unpublish date
                        if ($atm < $row['date_unpublish'] || ($row['date_unpublish'] <=> NULL) || (empty($row['date_unpublish'])))
                        {
                            $widgetFile = "system/widgets/".$row['folder']."/".$row['folder'].".php";
                            include $widgetFile;
                        }
                    }
                    else
                        {   //
                            return null;
                        }
                    return null;
                }
            }
            else
            {
                \YAWK\sys::setSyslog($db, 11, "failed to get widgets for position <b>$position</b> .", 0, 0, 0, 0);
                return false;
            }
            return null;
        }

        /**
         * return widget ID
         * @author Daniel Retzl <danielretzl@gmail.com>
         * @version 1.0.0
         * @link http://yawk.io
         * @param object $db database
         * @param int $id the ID
         * @return bool
         */
        static function getWidgetId($db, $id)
        {
            /** @var $db \YAWK\db */
            if ($res = $db->query("SELECT cp.id
                    FROM {pages} as cp
                    JOIN {widgets} as cw on cp.id = cw.pageID
                    WHERE cw.id = $id"))
            {   // fetch data
                while ($row = mysqli_fetch_row($res))
                {   // return ID
                    return $row[0];
                }
            }
            else
                {   // q failed
                    \YAWK\sys::setSyslog($db, 11, "failed to get widget id <b>#$id</b> .", 0, 0, 0, 0);
                    return false;
                }
            // something else has happened
            return false;
        }

        /**
         * get widget title and page ID and output select option
         * @author Daniel Retzl <danielretzl@gmail.com>
         * @version 1.0.0
         * @link http://yawk.io
         * @param object $db database
         * @param int $id affected widget ID
         * @return string|bool
         */
        static function getWidget($db, $id)
        {
            /** @var $db \YAWK\db */
            global $allpagescode;
            if ($res = $db->query("SELECT cw.pageID, cp.title
                    FROM {widgets} as cw
                    LEFT JOIN {pages} as cp on cp.id = cw.pageID
                    WHERE cw.id = '" . $id . "'"))
            {
                while ($row = mysqli_fetch_array($res))
                {
                    // if no result is given, prepare dropdown for all pages
                    if (!isset($row[1]))
                    {
                        $row[1] = "--all pages--";
                        $allpagescode = "";
                        // delete last entry from array?
                    }
                    else
                        {
                            $allpagescode = "<option value=\"0\">-- all pages--</option>";
                        }
                    echo $row[1];
                }
                return $row[0];
            }
            // something else has happened
            \YAWK\sys::setSyslog($db, 11, "failed to get widget id <b>#$id</b> .", 0, 0, 0, 0);
            return false;
        }

        /**
         * get widgets into array
         * @author Daniel Retzl <danielretzl@gmail.com>
         * @version 1.0.0
         * @link http://yawk.io
         * @param object $db database
         * @return bool|mixed
         */
        static function getWidgetsArray($db)
        {   /** @var $db \YAWK\db */
            if ($res = $db->query("SELECT id, name, (
                             SELECT COUNT( * )
                             FROM {widgets}
                             WHERE widgetType = {widget_types}.id)
                             count
                             FROM {widget_types}
                             ORDER BY name"))
            {   // fetch data
                $WidgetsArray = array();
                while ($row = $res->fetch_assoc())
                {
                    $WidgetsArray[] = $row;
                }
                return $res;
            }
            else
            {
                \YAWK\sys::setSyslog($db, 11, "failed to get widgets .", 0, 0, 0, 0);
                return false;
            }
        }

        /**
         * TODO: OUTDATED??
         * @author Daniel Retzl <danielretzl@gmail.com>
         * @version 1.0.0
         * @link http://yawk.io
         * load content widget
         * @param object $db database
         * @param int $id widget ID
         * @return bool|mixed
         */
        static function getContentWidget($db, $id)
        {
            /** @var $db \YAWK\db */
            if ($res = $db->query("SELECT cw.id,cw.published,cw.widgetType,cw.pageID,cw.sort,cw.position, cwt.name, cwt.folder
    							FROM {widgets} as cw
    							JOIN {widget_types} as cwt on cw.widgetType = cwt.id
    							WHERE cw.id = '" . $id . "' AND published = '1'
    							ORDER BY cw.sort"))
            {   // fetch data
                while ($row = mysqli_fetch_array($res)) {
                    $wID = $row[0];
                    $widgetFile = "system/widgets/$row[7]/$row[7].php";
                    return include $widgetFile;
                }

            } else {   // \YAWK\alert::draw("danger", "Error", "Could not fetch widget ID: $id", "","");
                \YAWK\sys::setSyslog($db, 11, "failed to get content widget id <b>#$id</b> .", 0, 0, 0, 0);
                return false;
            }
            // something strange has happened
            return false;
        }

        /**
         * TODO: OUTDATED??
         * @author Daniel Retzl <danielretzl@gmail.com>
         * @version 1.0.0
         * @link http://yawk.io
         * load widget
         * @param object $db database
         * @param int $id widget ID
         * @return bool|mixed
         */
        static function loadWidget($db, $id)
        {
            /** @var $db \YAWK\db */
            if ($res = $db->query("SELECT cw.id,cw.published,cw.widgetType, cwt.name, cwt.folder
    							FROM {widgets} as cw
    							JOIN {widget_types} as cwt on cw.widgetType = cwt.id
    							WHERE cw.id = '" . $id . "'
    							AND published = '1'
    							ORDER BY cw.sort")
            ) {   // fetch data
                while ($row = mysqli_fetch_array($res)) {   // load widget file
                    return include("system/widgets/$row[4]/$row[4].php?widgetID=$id");
                }
            } else {   // q failed
                \YAWK\sys::setSyslog($db, 11, "failed to load widget <b>#$id</b> .", 0, 0, 0, 0);
                echo "failed to load widget!";
                return false;
            }
            // something strange has happened
            return false;
        }

        /**
         * return the user login box widget
         */
        static function getLoginBox()
        {
            return include 'system/widgets/loginbox/loginbox.php';
        }

        /**
         * return the facebook likebox widget
         */
        static function getFacebookLikeBox()
        {
            include 'system/widgets/fb_like/fb_like.php';
        }

        /**
         * toggle widget online / offline
         * @author Daniel Retzl <danielretzl@gmail.com>
         * @version 1.0.0
         * @link http://yawk.io
         * @param object $db database
         * @param int $id widget ID
         * @param int $published 0|1 1 is online, zero is offline
         * @return bool
         */
        function toggleOffline($db, $id, $published)
        {
            /** @var $db \YAWK\db */
            // TOGGLE WIDGET STATUS
            if ($res = $db->query("UPDATE {widgets}
                          SET published = '" . $published . "'
                          WHERE id = '" . $id . "'"))
            {   // toggle successful
                return true;
            }
            else
            {   // q failed
                $status = \YAWK\sys::iStatusToString($published, "online", "offline");
                \YAWK\sys::setSyslog($db, 11, "failed to toggle widget id <b>#$id</b> to $status .", 0, 0, 0, 0);
                return false;
            }
        }

        /**
         * copy a widget
         * @author Daniel Retzl <danielretzl@gmail.com>
         * @version 1.0.0
         * @link http://yawk.io
         * @param object $db database
         * @param int $id widget ID to copy
         * @return bool
         */
        function copy($db, $id)
        {
            $originalWidgetID = $id;
            /** @var $db \YAWK\db */
            if ($res_widgets = $db->query("SELECT * FROM {widgets} WHERE id = '" . $id . "'"))
            {
                // get MAX id from widgets db
                if ($res_id = $db->query("SELECT MAX(id), MAX(sort) FROM {widgets}"))
                {   // set ID + sort var
                    $row = mysqli_fetch_row($res_id);
                    $id = $row[0] + 1;
                    $sort = $row[1] + 1;
                }
                else
                {   // error getting new ID
                    return false;
                }

                // get data from given widget id
                $row = mysqli_fetch_assoc($res_widgets);
                $published = $row['published'];
                $widgetType = $row['widgetType'];
                $pageID = $row['pageID'];
                $positions = $row['position'];
                $date_publish = $row['date_publish'];
                $date_unpublish = $row['date_unpublish'];

                // all good so far... now: copy widget
                if ($res = $db->query("INSERT INTO {widgets}
                    (id, published, widgetType, pageID, sort, position, date_publish, date_unpublish)
                    VALUES('" . $id . "',
                          '" . $published . "',
                          '" . $widgetType . "',
                          '" . $pageID . "',
                          '" . $sort . "',
                          '" . $positions . "',
                          '" . $date_publish . "',
                          '" . $date_unpublish . "')"))
                {   // copy widget successful// now we need to copy all settings of that widget into the new one
                    // first, we gonna get the settings of oldWidgetID
                    if ($settings = $db->query("SELECT * FROM {widget_settings} WHERE widgetID = '".$originalWidgetID."'"))
                    {
                        while ($settingsResult = mysqli_fetch_assoc($settings))
                        {
                            $widgetID = $settingsResult['widgetID'];
                            $property = $settingsResult['property'];
                            $value = $settingsResult['value'];
                            $widgetType = $settingsResult['widgetType'];
                            $activated = $settingsResult['activated'];

                            // copy the widget's settings
                            $db->query("INSERT INTO {widget_settings} (widgetID, property, value, widgetType, activated)
	                        VALUES('" . $id . "',
	                        '" . $property . "',
	                        '" . $value . "',
	                        '" . $widgetType . "',
	                        '" . $activated . "')");
                        }
                    // all finished
                    return true;
                    }

                    else
                    {
                        // copy widget failed
                        \YAWK\sys::setSyslog($db, 11, "failed to copy settings of widget ID <b>#$id</b> .", 0, 0, 0, 0);
                        return false;
                    }
                }
                    else
                    {
                        // copy widget failed
                        \YAWK\sys::setSyslog($db, 11, "failed to copy widget id <b>#$id</b> .", 0, 0, 0, 0);
                        return false;
                    }
            }
            else
                {   // could not get widget settings
                    \YAWK\sys::setSyslog($db, 11, "failed to get widget id <b>#$id</b> .", 0, 0, 0, 0);
                    return false;
                }
        }

        /**
         * delete a widget
         * @author Daniel Retzl <danielretzl@gmail.com>
         * @version 1.0.0
         * @link http://yawk.io
         * @param object $db database
         * @param int $widget widget ID
         * @return bool
         */
        function delete($db, $widget)
        {
            /** @var $db \YAWK\db */
            if ($res = $db->query("DELETE FROM {widgets} WHERE id = '" . $widget . "'")) {
                // delete corresponding widget settings
                if (!$res_settings = $db->query("DELETE FROM {widget_settings} WHERE widgetID = '" . $widget . "'")) {
                    // q failed
                    \YAWK\sys::setSyslog($db, 11, "failed to delete settings of widget id <b>#$widget</b> .", 0, 0, 0, 0);
                    return false;
                }
                return true;
            } else {
                \YAWK\sys::setSyslog($db, 11, "failed to delete widget id <b>#$widget</b> .", 0, 0, 0, 0);
                return false;
            }
        }

        /**
         * load widget properties into widget object
         * @author Daniel Retzl <danielretzl@gmail.com>
         * @version 1.0.0
         * @link http://yawk.io
         * @param object $db database
         * @param int $id widget ID
         * @return bool
         */
        function loadProperties($db, $id)
        {   /** @var $db \YAWK\db */
            if (isset($id))
            {   // escape string
                $id = $db->quote($id);
            }
            /** @var $db \YAWK\db $res */
            if ($res = $db->query("SELECT cw.id, cw.published,cw.widgetType,cw.pageID,cw.sort,cw.position, cw.date_publish, cw.date_unpublish, cw.widgetTitle, cwt.name, cw.marginTop, cw.marginBottom, cwt.folder
    							FROM {widgets} as cw
    							JOIN {widget_types} as cwt on cw.widgetType = cwt.id
                                WHERE cw.id = '" . $id . "'"))
            {
                if ($row = mysqli_fetch_assoc($res))
                {   // set properties
                    $this->id = $row['id'];
                    $this->published = $row['published'];
                    $this->widgetType = $row['widgetType'];
                    $this->pageID = $row['pageID'];
                    $this->sort = $row['sort'];
                    $this->position = $row['position'];
                    $this->name = $row['name'];
                    $this->marginTop = $row['marginTop'];
                    $this->marginBottom = $row['marginBottom'];
                    $this->date_publish = $row['date_publish'];
                    $this->date_unpublish = $row['date_unpublish'];
                    $this->widgetTitle = $row['widgetTitle'];
                    $this->folder = $row['folder'];
                    return true;
                }
                else
                {   // fetch failed
                    \YAWK\sys::setSyslog($db, 11, "failed to fetch widget properties of id <b>#$id</b> .", 0, 0, 0, 0);
                    return false;
                }
            }
            else
            {   // q failed
                \YAWK\sys::setSyslog($db, 11, "failed to query widget properties of id <b>#$id</b> .", 0, 0, 0, 0);
                return false;
            }
        }

        /**
         * save (update) widget settings
         * @author Daniel Retzl <danielretzl@gmail.com>
         * @version 1.0.0
         * @link http://yawk.io
         * @param object $db database
         * @return bool
         */
        function save($db)
        {
            /** @var $db \YAWK\db */
            $this->position = mb_strtolower($this->position);
            if ($res = $db->query("UPDATE {widgets} SET
                                        published = '" . $this->published . "',
                                        widgetType = '" . $this->widgetType . "',
                                        pageID = '" . $this->pageID . "',
                                        sort = '" . $this->sort . "',
                                        position = '" . $this->position . "',
                                        date_publish = '" . $this->date_publish. "',
                                        date_unpublish = '" . $this->date_unpublish. "',
                                        widgetTitle = '" . $this->widgetTitle. "'
                      WHERE id = '" . $this->id . "'"))
            {   // save successful
                return true;
            }
            else
            {   // q failed
                \YAWK\sys::setSyslog($db, 11, "failed to save widget settings of id<b>#$this->id</b> .", 0, 0, 0, 0);
                return false;
            }
        }

    } // end class Widget
}
