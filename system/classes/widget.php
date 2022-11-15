<?php
namespace YAWK {
    /**
     * @details <b>Widgets are small, useful tools that you can include everywhere on your website.</b>
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
     * @author     Daniel Retzl <danielretzl@gmail.com>
     * @copyright  2009-2016 Daniel Retzl
     * @license    https://opensource.org/licenses/MIT
     * @version    1.0.0
     * @brief Widgets are small, useful tools that you can include everywhere in your website.
     */
    class widget
    {
        /** * @param int 0|1 published or not */
        public $published;
        /** * @param int widget ID */
        public $id;
        /** * @param string widget name */
        public $name;
        /** * @param int order sortation number */
        public $sort;
        /** * @param string template position to appear */
        public $position;
        /** * @param int widget type number */
        public $widgetType;
        /** * @param int margin from top in px */
        public $marginTop;
        /** * @param int margin from bottom in px */
        public $marginBottom;
        /** * @param int ID of the page where this widget should appear */
        public $pageID;
        /** * @param string date when widget publishing starts */
        public $date_publish;
        /** * @param string date when widget publishing ends */
        public $date_unpublish;
        /** * @param string title to identify the widget */
        public $widgetTitle;
        /** * @param string foldername of this widget */
        public $folder;
        /** * @param array widget settings data array placeholder */
        public $data;


        /**
         * @brief Print all object data
         * @details  (for development and testing purpose)
         */
        public function printObject()
        {   // output data to screen
            echo "<pre>";
            print_r($this);
            echo "</pre>";
        }

        /**
         * @brief Get widget settings and return it as array
         * @param object $db database
         * @return array|bool returns array with widget settings or null
         */
        public function getWidgetSettingsArray($db)
        {
            // $_GET['widgetID'] will be generated in \YAWK\widget\loadWidgets($db, $position)
            if (isset($_GET['widgetID']))
            {
                // widget ID
                $this->id = $_GET['widgetID'];
                // data array
                $this->data = array();

                // get widget settings from db
                $res = $db->query("SELECT property, value FROM {widget_settings}
	                   WHERE widgetID = '".$this->id."'
	                   AND activated = '1'");
                // get data in loop
                while($row = mysqli_fetch_assoc($res))
                {   // set widget properties and values into this data array
                    $this->data[$row['property']] = $row['value'];
                } // end while fetch row (fetch widget settings)

                // check if data array is set
                if (is_array($this->data))
                {   // ok, return widget settings array
                    return ($this->data);
                }
                else
                {   // widget settings could not be retrieved
                    echo "Error: this data object is empty - unable to load widget settings of widget ID: ".$this->id."";
                    echo "<pre>";
                    print_r($this);
                    echo "</pre>";
                }
            }
            else
            {   // no widget ID requested - do nothing.
                return null;
            }
            return null;
        }


        /**
         * @brief return current widget path
         * @param object $db database
         * @return string full path to widgets folder
         */
        static function getCurrentWidgetPath($db)
        {
            return "" . \YAWK\sys::getDirPrefix($db) . "/system/widgets/";
        }


        /**
         * @brief Returns an array with all widget settings data.
         * @param object $db Database Object
         * @return array|bool
         * @details TODO: IMPLEMENT GET WIDGET SETTINGS ARRRAY for issue #61
         */
        public static function getAllSettingsIntoArray($db, $widgetID) // get all settings from db like property
        {
            /* @param $db \YAWK\db */
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
                \YAWK\sys::setSyslog($db, 39, 1, "failed to get widget settings array of widget ID $widgetID", 0, 0, 0, 0);
                // \YAWK\alert::draw("warning", "Warning!", "Fetch database error: getSettingsArray failed.","","4800");
                return false;
            }
            return $settingsArray;
        }

        /**
         * @brief Return settings as form elements corresponding to given widget ID.
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

            // check if language is set
            if (!isset($language) || (!isset($lang)))
            {
                // check widget contains language files
                if (is_dir('../system/widgets/'.$widgetFolder.'/language/'))
                {   // inject (add) language tags to core $lang array
                    $lang = \YAWK\language::inject($lang, "../system/widgets/$widgetFolder/language/");
                }
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
                        // check if placeholder is set in language array
                        if (isset($lang[$placeholder]))
                        {   // if so, set placeholder
                            $placeholder = $lang[$placeholder];
                        }
                        else
                        {   // leave empty if placeholder does not exist in language array
                            $placeholder = '';
                        }
                        // set icon, heading and subtext markup
                        if (!empty($setting['icon']) || (!empty($setting['heading']) || (!empty($setting['subtext']))))
                        {
                            echo "<h3>$setting[icon]&nbsp;$setting[heading]&nbsp;<small>$setting[subtext]</small></h3>";
                        }
                        // output input text field
                        echo "<label for=\"$setting[property]\">$setting[label]&nbsp;$setting[description]</label>
                                  <input type=\"text\" class=\"$setting[fieldClass]\" id=\"$setting[property]\" 
                                  name=\"$setting[property]\" value=\"$setting[value]\" placeholder=\"$placeholder\">";
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
                                  <input type=\"text\" class=\"form-control $setting[fieldType]\" id=\"$setting[property]\" name=\"$setting[property]\" 
										 value=\"$setting[value]\" placeholder=\"$lang[$placeholder]\">";
                    }

                    /* CODE EDITOR TEXTAREA */
                    if ($setting['fieldType'] === "editor")
                    {
                        require_once ('editor.php');
                        $editorSettings = \YAWK\settings::getEditorSettings($db, 14);
                        \YAWK\editor::loadJavascript($editorSettings);
                        \YAWK\editor::setEditorSettingsForCustomHtmlWidget($editorSettings);

                        if (!empty($setting['icon']) || (!empty($setting['heading']) || (!empty($setting['subtext']))))
                        {
                            echo "<h3>$setting[icon]&nbsp;$setting[heading]&nbsp;$setting[subtext]</h3>";
                        }

                        if (isset($setting['longValue']) && (!empty($setting['longValue'])))
                        {   // build a longValue tagged textarea and fill with longValue
                            echo "<label for=\"$setting[property]-long\">$setting[label]&nbsp;$setting[description]</label>
                                      <textarea cols=\"64\" rows=\"10\" class=\"$setting[fieldClass]\" id=\"$setting[property]-long\" name=\"$setting[property]-long\">$setting[longValue]</textarea>";
                        }
                        else
                        {   // draw default textarea
                            echo "<label for=\"$setting[property]\">$setting[label]&nbsp;$setting[description]</label>
                                      <textarea cols=\"64\" rows=\"10\" class=\"$setting[fieldClass]\" id=\"$setting[property]\" name=\"$setting[property]\">$setting[value]</textarea>";
                        }
                    }

                    /* SELECT FIELD */
                    /* GALLERY SELECTOR */
                    /** @var $db \YAWK\db */
                    if ($setting['fieldType'] === "selectGallery")
                    {
                        // set required assets
                        $requiredAssets = array('Lightbox 2 JS' => 'js', 'Lightbox 2 CSS' => 'css');
                        // check if they are active in current template, if not, set them
                        \YAWK\sys::checkIfAssetsAreLoaded($db, $requiredAssets, true);

                        // display icon, heading and subtext, if its set
                        if (!empty($setting['icon']) || (!empty($setting['heading']) || (!empty($setting['subtext']))))
                        {   // output heading
                            echo "<h3>$setting[icon]&nbsp;$setting[heading]&nbsp;<small>$setting[subtext]</small></h3>";
                        }
                        // begin draw select
                        echo "<label for=\"$setting[property]\">$setting[label]&nbsp;$setting[description]</label>
                                  <select class=\"form-control\" id=\"$setting[property]\" name=\"$setting[property]\">";
                        echo "<option value=\"$setting[value]\">$lang[SETTING_CURRENT] $setting[value]</option>";

                        // select galleries from database
                        if ($res = $db->query("SELECT id, title FROM {plugin_gallery}"))
                        {   // fetch data
                            while ($row = mysqli_fetch_array($res))
                            {   // set current default value
                                if ($setting['value'] === $row[0])
                                {   // selected default value
                                    $selected = "selected";
                                }
                                else
                                {   // option not selected
                                    $selected = '';
                                }
                                // draw option
                                echo "<option value=\"$row[0]\"$selected>$row[1]</option>";
                            }
                            echo "<option value=\"\">$lang[NONE_SELECTED]</option>";
                        }
                        echo "</select>";
                    }


                    /* FACEBOOK SELECT FIELD */
                    if ($setting['fieldType'] === "fbGallerySelect")
                    {   // display icon, heading and subtext, if its set
                        if (!empty($setting['icon']) || (!empty($setting['heading']) || (!empty($setting['subtext']))))
                        {
                            echo "<h3>$setting[icon]&nbsp;$setting[heading]&nbsp;<small>$setting[subtext]</small></h3>";
                        }
                        // IMPORT FACEBOOK DATA, depending on APP ID and TOKEN
                        // get APP ID from settings array
                        $appId = $settings[0]['value'];
                        // get TOKEN from settings array
                        $token = $settings[1]['value'];
                        if (isset($appId) && (is_string($appId) && (!empty($appId)
                                    && (isset($token) && (is_string($token) && (!empty($token)))))))
                        {
                            // facebook data is set - try to get album list
                            // prepare API call - get albums for this app id and token
                            $json_link = "https://graph.facebook.com/v3.3/me/albums?access_token={$token}";

                            // get json string
                            // $json = file_get_contents($json_link);

                            // use curl to get json string / apiObject
                            $curl = curl_init();
                            curl_setopt($curl, CURLOPT_URL, $json_link);
                            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
                            $apiObject = json_decode(curl_exec($curl), true, 512, JSON_BIGINT_AS_STRING);
                            curl_close($curl);

                            // convert json to object
                            // $apiObject = json_decode($json, true, 512, JSON_BIGINT_AS_STRING);

                            // stores all the field html markup
                            $fbGallerySelectMarkup = '';
                            // check if api object is set
                            if (isset($apiObject) && (is_array($apiObject['data']) && (!empty($apiObject['data']))))
                            {
                                // build the select field
                                $fbGallerySelectMarkup = "<label for=\"$setting[property]\">$setting[label]&nbsp;$setting[description]</label>";
                                $fbGallerySelectMarkup .= "<select class=\"form-control\" id=\"$setting[property]\" name=\"$setting[property]\">";

                                // walk trough data array
                                foreach ($apiObject['data'] as $data => $field)
                                {   // and add select options
                                    if ($field['id'] == $settings[2]['value'])
                                    {
                                        $selected = " selected";
                                    }
                                    else { $selected = ''; }

                                    $fbGallerySelectMarkup .= "<option value=\"$field[id]\"$selected>$field[name]</option>";
                                }
                                // close select field
                                $fbGallerySelectMarkup .= "</select>";
                            }
                            else
                            {   // could not determine facebook albums, let user enter the album ID manually
                                $fbGallerySelectMarkup = "<label for=\"$setting[property]\">$setting[label]&nbsp;$setting[description]</label>";
                                $fbGallerySelectMarkup .= "<input type=\"text\" class=\"form-control\" placeholder=\"$lang[PH_FB_GALLERY_ALBUMID]\" name=\"$setting[property]\" value=\"$setting[value]\">";
                            }
                        }
                        else
                        {   // if appID and/or token are not set correctly,
                            // draw a simple input field where the album id can be entered manually
                            $fbGallerySelectMarkup = "<label for=\"$setting[property]\">$setting[label]&nbsp;$setting[description]</label>";
                            $fbGallerySelectMarkup .= "<input type=\"text\" class=\"form-control\" placeholder=\"$lang[PH_FB_GALLERY_ALBUMID]\"  name=\"$setting[property]\" value=\"$setting[value]\">";
                        }

                        // output select field / input field depending on code above
                        echo $fbGallerySelectMarkup;
                    }
                }
            }
        }


        /**
         * @brief create new widget
         * @param object $db database
         * @param int $widgetType widget type
         * @param int $pageID page ID
         * @param string $positions widget / template positions
         * @return bool
         */
        static function create($db, $widgetType, $pageID, $positions)
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
                    \YAWK\sys::setSyslog($db, 39, 1, "could not get max ID.", 0, 0, 0, 0);
                    return false;
                }

                // add new widget to db
                if ($res_widgets = $db->query("INSERT INTO {widgets}
                                (id, published, widgetType, pageID, sort, position)
	                        VALUES('" . $id . "',
	                        '" . $published . "',
	                        '" . $widgetType . "',
	                        '" . $pageID . "',
	                        '" . $sort . "',
	                        '" . $positions . "')"))
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
                                \YAWK\sys::setSyslog($db, 39, 1, "failed to insert settings of widget :$id property:$w_property value: $w_value type: $w_widgetType active: $w_activated", 0, 0, 0, 0);
                                return false;
                            }
                        } // ./ while
                    }
                    else
                    {   // could not get widget defaults
                        \YAWK\sys::setSyslog($db, 39, 1, "failed to set widget defaults of widget ID <b>$id</b>.", 0, 0, 0, 0);
                        return false;
                    }
                }
                else
                {   // could not add new widget
                    \YAWK\sys::setSyslog($db, 39, 1, "failed to add new widget", 0, 0, 0, 0);
                    return false;
                }
            }
            else
            {   // could not get maxID
                \YAWK\sys::setSyslog($db, 39, 1, "failed to get MAX(id) of widgets db", 0, 0, 0, 0);
                return false;
            }
            // something else has happened
            // \YAWK\sys::setSyslog($db, 11, "return $id in case of widget create.", 0, 0, 0, 0);
            return $id;
        }

        /**
         * @brief Get widget heading and subtext, return headline
         * @param string $heading The Heading
         * @param string $subtext The Subtext
         * @return string|bool return the correct headline
         */
        public function getHeading($heading, $subtext)
        {
            // if a heading is set and not empty
            if (isset($heading) && (!empty($heading)))
            {
                // if subtext is set, add <small> subtext to string
                if (isset($subtext) && (!empty($subtext)))
                {   // build a headline with heading and subtext
                    $subtext = "<small>$subtext</small>";
                    return "<h2>$heading&nbsp;" . "$subtext</h2>";
                }
                else
                {   // build just a headline - without subtext
                    return  "<h2>$heading</h2>";    // draw just the heading
                }
            }
            else
            {   // leave empty if it's not set
                return null;
            }
        }


        /**
         * @brief load a widget into given position
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
                    if ($atm > $row['date_publish'] || ($row['date_publish'] === NULL) || (empty($row['date_publish'])))
                    {
                        // if current date is bigger than unpublish date
                        if ($atm < $row['date_unpublish'] || ($row['date_unpublish'] === NULL) || (empty($row['date_unpublish'])))
                        {
                            $widgetFile = "system/widgets/".$row['folder']."/".$row['folder'].".php";
                            include $widgetFile;
                        }
                    }
                    else
                    {   //
                        return null;
                    }
                }
            }
            else
            {
                \YAWK\sys::setSyslog($db, 39, 1, "failed to get widgets of position <b>$position</b>", 0, 0, 0, 0);
                return false;
            }
            return null;
        }

        /**
         * @brief return widget ID
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
                    if (isset($row[0]))
                    {
                        return $row[0];
                    }
                    else {
                        return false;
                    }
                }
            }
            else
            {   // q failed
                \YAWK\sys::setSyslog($db, 39, 1, "failed to get widget ID <b>$id</b> $row", 0, 0, 0, 0);
                return false;
            }
            // something else has happened
            return false;
        }

        /**
         * @brief get widget title and page ID and output select option
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
            }
            // something else has happened
            \YAWK\sys::setSyslog($db, 39, 1, "failed to get widget ID <b>$id</b>", 0, 0, 0, 0);
            return false;
        }

        /**
         * @brief get widgets into array
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
                \YAWK\sys::setSyslog($db, 39, 1, "failed to get widgets from db", 0, 0, 0, 0);
                return false;
            }
        }

        /**
         * @brief TODO: OUTDATED??
         * @details load content widget
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
                \YAWK\sys::setSyslog($db, 39, 1, "failed to get content widget ID <b>$id</b>", 0, 0, 0, 0);
                return false;
            }
            // something strange has happened
            return false;
        }

        /**
         * @brief TODO: OUTDATED??
         * @details load widget
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
                \YAWK\sys::setSyslog($db, 39, 1, "failed to load widget ID <b>$id</b>", 0, 0, 0, 0);
                echo "failed to load widget!";
                return false;
            }
            // something strange has happened
            return false;
        }

        /**
         * @brief return the user login box widget
         */
        static function getLoginBox()
        {
            return include 'system/widgets/loginbox/loginbox.php';
        }

        /**
         * @brief return the facebook likebox widget
         */
        static function getFacebookLikeBox()
        {
            include 'system/widgets/fb_like/fb_like.php';
        }

        /**
         * @brief toggle widget online / offline
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
                $status = \YAWK\sys::iStatusToString($published, "online", "offline");
                \YAWK\sys::setSyslog($db, 37, 0, "toggled widget ID <b>$id</b> to $status", 0, 0, 0, 0);
                return true;
            }
            else
            {   // q failed
                $status = \YAWK\sys::iStatusToString($published, "online", "offline");
                \YAWK\sys::setSyslog($db, 39, 1, "failed to toggle widget ID <b>$id</b> to $status", 0, 0, 0, 0);
                return false;
            }
        }

        /**
         * @brief copy a widget
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
                        \YAWK\sys::setSyslog($db, 39, 1, "failed to copy settings of widget ID <b>$id</b>", 0, 0, 0, 0);
                        return false;
                    }
                }
                else
                {
                    // copy widget failed
                    \YAWK\sys::setSyslog($db, 39, 1, "failed to copy widget ID <b>$id</b>", 0, 0, 0, 0);
                    return false;
                }
            }
            else
            {   // could not get widget settings
                \YAWK\sys::setSyslog($db, 39, 1, "failed to get widget ID <b>$id</b>", 0, 0, 0, 0);
                return false;
            }
        }

        /**
         * @brief delete a widget
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
                    \YAWK\sys::setSyslog($db, 39, 1, "failed to delete settings of widget ID <b>$widget</b>", 0, 0, 0, 0);
                    return false;
                }
                return true;
            } else {
                \YAWK\sys::setSyslog($db, 39, 1, "failed to delete widget ID <b>$widget</b>", 0, 0, 0, 0);
                return false;
            }
        }

        /**
         * @brief load widget properties into widget object
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
            /** @param $db \YAWK\db $res */
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
                    \YAWK\sys::setSyslog($db, 39, 1, "failed to fetch widget properties of ID <b>$id</b>", 0, 0, 0, 0);
                    return false;
                }
            }
            else
            {   // q failed
                \YAWK\sys::setSyslog($db, 39, 1, "failed to query widget properties of ID <b>$id</b>", 0, 0, 0, 0);
                return false;
            }
        }

        /**
         * @brief save (update) widget settings
         * @param object $db database
         * @return bool
         */
        function save($db)
        {
            /** @var $db \YAWK\db */
            $this->position = mb_strtolower($this->position);
            // if widget should be displayed on all pages, pageID should be zero
            if (empty($this->pageID || (!isset($this->pageID)))) { $this->pageID = 0; }

            if ($this->date_unpublish === "0000-00-00 00:00:00" || (empty($this->date_unpublish)))
            {
                // sql code when date_unpublish is a zero date (NULL)
                if ($db->query("UPDATE {widgets} SET
                                        published = '" . $this->published . "',
                                        widgetType = '" . $this->widgetType . "',
                                        pageID = '" . $this->pageID . "',
                                        sort = '" . $this->sort . "',
                                        position = '" . $this->position . "',
                                        date_publish = '" . $this->date_publish. "',
                                        date_unpublish = NULL,
                                        widgetTitle = '" . $this->widgetTitle. "'
                      WHERE id = '" . $this->id . "'"))
                {   // save successful
                    return true;
                }
                else
                {   // q failed
                    \YAWK\sys::setSyslog($db, 39, 1, "failed to save widget settings of ID: <b>$this->id</b> (unpublish not set)", 0, 0, 0, 0);
                    return false;
                }

            }
            else
            {
                // sql code with qualified, user selected unpublish date
                if ($db->query("UPDATE {widgets} SET
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
                    \YAWK\sys::setSyslog($db, 39, 1, "failed to save widget settings of ID: <b>$this->id</b> (unpublish set)", 0, 0, 0, 0);
                    return false;
                }
            }
        }

        /**
         * @brief Returns an array of all widgets that are linked with given page->id
         * @param object $db database
         * @param object $page the current page object
         * @return array return all widgets that are connected with this page
         */
        static function loadWidgetsOfPage($db, $page)
        {
            if (isset($page->id) && (is_numeric($page->id)))
            {
                $row = $db->query("SELECT cw.id,cw.published,cw.widgetType,cw.pageID,cw.sort,cw.position, cw.date_publish, cw.date_unpublish, cwt.name, cwt.folder
                                FROM {widgets} as cw
                                JOIN {widget_types} as cwt on cw.widgetType = cwt.id
                                WHERE (cw.pageID = '" . $page->id . "' OR cw.pageID = '0')
                                ORDER BY cw.sort");

                // create list of widgets as associative array and return it
                while ($result = mysqli_fetch_assoc($row)){
                    $list[] = $result;
                }
                if (isset($list) && (is_array($list))){
                    return $list;
                }
                else {
                    return false;
                }
            }
        }


        /**
         * @brief Return all widget types as associative array
         * @param object $db database
         * @return array return all widgets types from database
         */
        public static function getAllWidgetTypes($db)
        {
            $row = $db->query("SELECT * FROM {widget_types} ORDER BY name");
            while ($res = mysqli_fetch_assoc($row))
            {
                $widgetTypes[] = $res;
            }
            if (is_array($widgetTypes) && (!empty($widgetTypes))){
                return $widgetTypes;
            }
            else
            {
                \YAWK\sys::setSyslog($db, 39, 1, "failed to get list of widget types. $widgetTypes is empty or not set.", 0, 0, 0, 0);
                return false;
            }
        }

    } // end class Widget
}
