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
     * @license    http://www.gnu.org/licenses/gpl-2.0  GNU/GPL 2.0
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

                            // insert widget settings
                            if ($status = $db->query("INSERT INTO {widget_settings}
							      (widgetID, property, value, widgetType, activated)
	                        VALUES('" . $id . "',
	                        '" . $w_property . "',
	                        '" . $w_value . "',
	                        '" . $w_widgetType . "',
	                        '" . $w_activated . "')"))
                            {
                                // widget settings added
                            }
                            else
                                {   // insert widget settings failed
                                    return false;
                                }
                        } // ./ while
                    }
                    else
                        {   // could not get widget defaults
                            \YAWK\sys::setSyslog($db, 11, "failed to set widget defaults of widget id <b>#$id</b> .", 0, 0, 0, 0);
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
                    if ($atm > $row['date_publish'] || ($row['date_publish'] === "0000-00-00 00:00:00") || (empty($row['date_publish'])))
                    {
                        // if current date is bigger than unpublish date
                        if ($atm < $row['date_unpublish'] || ($row['date_unpublish'] === "0000-00-00 00:00:00") || (empty($row['date_unpublish'])))
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
                          WHERE id = '" . $id . "'")
            ) {   // toggle successful
                return true;
            } else {   // q failed
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
            if ($res = $db->query("SELECT cw.id, cw.published,cw.widgetType,cw.pageID,cw.sort,cw.position, cw.date_publish, cw.date_unpublish, cwt.name, cw.marginTop, cw.marginBottom
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
                                        date_unpublish = '" . $this->date_unpublish. "'
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
