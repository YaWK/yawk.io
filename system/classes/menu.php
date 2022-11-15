<?php
namespace YAWK {
    /**
     * @details <b>The default menu class. Serves all the menu functions.</b>
     *
     * This class serves all functions to create, edit, delete and modify menus and menu entries.
     * <p><i>Class covers both, backend & frontend functionality.
     * See Methods Summary for Details!</i></p>
     *
     * @author     Daniel Retzl <danielretzl@gmail.com>
     * @copyright  2009-2021 Daniel Retzl
     * @license    https://opensource.org/licenses/MIT
     * @version    1.0.0
     * @brief The default menu class. Serves all the menu functions.
     */
    class menu
    {
        /**
         * @param int the menu id
         */
        public $id;
        /**
         * @param string the menu name
         */
        public $name;
        /**
         * @param int the menu ID
         */
        public $menuID;
        /**
         * @param int 0|1 published - yes or no
         */
        public $published;
        /**
         * @param int the parent menu ID
         */
        public $parent;

        /**
         * @brief display any subMenu (used by widgets to get any menu in any position)
         * @copyright  2009-2016 Daniel Retzl
         * @license    https://opensource.org/licenses/MIT
         * @version    1.0.0
         * @param object $db database
         * @param int $menuID the menuID to get data
         */
        public function displaySubMenu($db, $menuID)
        {   /** @param db $db */
            // get menu entries and draw navbar
            $res = $db->query("SELECT * FROM {menu}
                               WHERE published = 1 
                               AND menuID = '".$menuID."' 
                               ORDER by sort, title");
            echo "
                    <ul class=\"list-group\">";
            while ($row = mysqli_fetch_assoc($res))
            {
                echo "<li class=\"list-group-item\"><a href=\"".$row['href']."\" target=\"".$row['target']."\">".$row['text']."</a></li>";
            }
            echo "    </ul>";
        }


        /**
         * @brief return true if menu is published, false if not. expects db object and menu ID to get the status from
         * @copyright  2009-2016 Daniel Retzl
         * @license    https://opensource.org/licenses/MIT
         * @version    1.0.0
         * @param object $db database
         * @param int $menuID the menuID to get data
         */
        public function isPublished($db, $menuID)
        {   /** @param db $db */
            $res = $db->query("SELECT published FROM {menu_names}
                               WHERE published = 1 
                               AND id = '".$menuID."'");
            $status = mysqli_fetch_row($res);
            if ($status['0'] == '1')
            {   // this menu ID is published
                return true;
            }
            else
            {   // menu ID is not published
                return false;
            }
        }


        /**
         * @brief display the global menu
         * @copyright  2009-2016 Daniel Retzl
         * @license    https://opensource.org/licenses/MIT
         * @version    1.0.0
         * @param object $db database
         * @param object $user current user object
         * @param object $template template object
         */
        static function displayGlobalMenu($db, $user, $template)
        {   /** @param db $db */
            $res = $db->query("SELECT value FROM {settings}
                               WHERE property = 'globalmenuid'");
            if ($row = mysqli_fetch_row($res)) {
                if ($published = self::getMenuStatus($db, $row[0]) != '0') {
                    self::display($db, $row[0], $user, $template);
                }
            }
        }

        /**
         * @brief create a new menu
         * @copyright  2009-2016 Daniel Retzl
         * @license    https://opensource.org/licenses/MIT
         * @version    1.0.0
         * @param object $db the database object
         * @param object $lang language
         * @param string $name the name of the new menu
         * @return bool
         */
        static function createMenu($db, $name, $lang)
        {   /** @param $db db */
            // menu name not given
            if (!$name) {
                return false;
            }
            else
            {   // menu name is set, go ahead
                if ($res = $db->query("SELECT MAX(id) FROM {menu_names}"))
                {   // get MAXid
                    $row = mysqli_fetch_row($res);
                    $menuID = $row[0] + 1;
                    $name = \YAWK\sys::encodeChars($name);
                    if ($res = $db->query("INSERT INTO {menu_names} (id, name) VALUES ('" . $menuID . "', '" . $name . "')"))
                    {   // data inserted
                        \YAWK\sys::setSyslog($db, 21, 0, "created menu $lang[ID]: $menuID <b>$name</b>", 0, 0, 0, 0);
                        return true;
                    }
                    else {
                        // q insert failed
                        \YAWK\sys::setSyslog($db, 24, 1, "failed to create menu: <b>$name</b>", 0, 0, 0, 0);
                        return false;
                    }
                }
                else {
                    // q get maxID failed
                    \YAWK\sys::setSyslog($db, 24, 1, "unable to retrieve max ID of menu <b>$name</b>", 0, 0, 0, 0);
                    return false;
                }
            }
        }

        /**
         * @brief Change the menu title
         * @copyright  2009-2016 Daniel Retzl
         * @license    https://opensource.org/licenses/MIT
         * @version    1.0.0
         * @param object $db the database oject
         * @param int $menu affected menu ID
         * @param string $menutitle new menu title
         * @return bool
         */
        static function changeTitle($db, $menu, $menutitle)
        {
            /** @param $db db $res */
            if ($res = $db->query("UPDATE {menu_names} SET
                                        name = '" . $menutitle . "'
                                        WHERE id = '" . $menu . "'"))
            {
                \YAWK\sys::setSyslog($db, 21, 0,"updated menu title <b>$menutitle</b>", 0, 0, 0, 0);
                return true;
            }
            else
            {
                \YAWK\sys::setSyslog($db, 24, 1,"failed to update menu title <b>$menutitle</b>", 0, 0, 0, 0);
                return false;
            }
        }

        /**
         * @brief Change the menu language
         * @copyright  2009-2021 Daniel Retzl
         * @license    https://opensource.org/licenses/MIT
         * @version    1.0.0
         * @param object $db the database oject
         * @param int $menu affected menu ID
         * @param string $menuLanguage new menu language
         * @return bool
         */
        static function changeLanguage($db, $menu, $menuLanguage)
        {
            $menuLanguage = mb_substr($menuLanguage, 0, 2);
            if (empty($menuLanguage))
            {
                $menuLanguage = NULL;
            }
            /** @param $db db $res */
            if ($res = $db->query("UPDATE {menu_names} SET
                                        menuLanguage = '" . $menuLanguage . "'
                                        WHERE id = '" . $menu . "'") &&
                ($res = $db->query("UPDATE {menu} SET
                                        menuLanguage = '" . $menuLanguage . "'
                                        WHERE menuID = '" . $menu . "'")))

            {
                \YAWK\sys::setSyslog($db, 21, 0,"updated menu language of menu ID $menu to <b>$menuLanguage</b>", 0, 0, 0, 0);
                return true;
            }
            else
            {
                \YAWK\sys::setSyslog($db, 24, 1,"failed to update menu language of menu ID $menu to <b>$menuLanguage</b>", 0, 0, 0, 0);
                return false;
            }
        }

        /**
         * @brief Get menu ID by language
         * @copyright  2009-2021 Daniel Retzl
         * @license    https://opensource.org/licenses/MIT
         * @version    1.0.0
         * @param object $db the database object
         * @param string $menuLanguage menu language
         * @return int|false $id return ID of the menu with given language or false if no ID was found
         */
        static function getMenuIdFromLanguage ($db, $menuLanguage)
        {
            /** @param $db db $res */
            if ($res = $db->query("SELECT id FROM {menu} WHERE menuLanguage='".$menuLanguage."'"))
            {
                $id = mysqli_fetch_row($res);
                if (isset($id[0]) && (!empty($id[0])))
                {
                    return $id[0];
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

        /**
         * @brief add new entry to an existing menu
         * @param $db object database object
         * @copyright  2009-2016 Daniel Retzl
         * @license    https://opensource.org/licenses/MIT
         * @version    1.0.0
         * @param $menu int affected menu ID
         * @param $text string new menu entry title
         * @param $href string new menu link
         * @return bool
         */
        static function addEntry($db, $menu, $text, $href)
        {   /** @param $db db */

            // get menu name
            $menuName = \YAWK\menu::getMenuNameByID($db, $menu);

            // ## select max ID from menu + add menu entry
            $res = $db->query("SELECT MAX(sort) FROM {menu}
                               WHERE menuID = '".$menu."'");

            $row = mysqli_fetch_row($res);
            if (isset($row[0]))
            {   // add sort
                $sort = $row[0] + 1;
            }
            else
            {   // sort
                $sort = 1;
            }

            // make sure that sort var is set
            if (!isset($sort)) {
                $sort = 1;
            }

            // add menu entry
            if ($res = $db->query("INSERT INTO {menu} 
                                        (sort, text, href)
                                        VALUES (
                                        '" . $sort . "',
                                        '" . $text . "',
                                        '" . $href . "')"))
            {   // menu entry added
                \YAWK\sys::setSyslog($db, 21, 0, "added menu entry <b>$text</b> to <b>$menuName</b>", 0, 0, 0, 0);
                return true;
            }
            else
            {
                // add menu entry failed
                \YAWK\sys::setSyslog($db, 23, 1, "failed to add menu entry <b>$text</b> to <b>$menuName</b>", 0, 0, 0, 0);
                return false;
            }
        }

        /**
         * @brief check if a whole menu is published or not
         * @copyright  2009-2016 Daniel Retzl
         * @license    https://opensource.org/licenses/MIT
         * @version    1.0.0
         * @param object $db database object
         * @param object $lang language object
         * @param int $menuid affected menu ID
         * @return bool
         */
        public static function getMenuStatus($db, $menuid)
        {
            /** @param $db db */
            // get status from menu db
            if ($res = $db->query("SELECT published FROM {menu_names} WHERE id = '" . $menuid . "'"))
            {   // fetch data
                $row = mysqli_fetch_row($res);
                return $row[0];
            }
            else
            {   // q failed
                \YAWK\sys::setSyslog($db, 23, 1, "failed to get menu status of menu <b>ID: $menuid</b> (menu::getMenuStatus)", 0, 0, 0, 0);
                return false;
            }
        }

        /**
         * @brief check if a single menu entry is published or not
         * @copyright  2009-2016 Daniel Retzl
         * @license    https://opensource.org/licenses/MIT
         * @version    1.0.0
         * @param $db object database object
         * @param $menuid int affected menu id
         * @return bool
         */
        public static function getMenuEntryStatus($db, $menuid)
        {
            /** @param $db db */
            if ($res = $db->query("SELECT published FROM {menu} WHERE id = '" . $menuid . "'"))
            {
                $row = mysqli_fetch_row($res);
                return $row[0];
            }
            else
            {
                \YAWK\sys::setSyslog($db, 23, 1, "failed to get status of menu entry <b>ID: $menuid</b> (menu::getMenuEntryStatus)", 0, 0, 0, 0);
                return false;
            }
        }

        /**
         * @brief toggle a whole menu offline
         * @copyright  2009-2016 Daniel Retzl
         * @license    https://opensource.org/licenses/MIT
         * @version    1.0.0
         * @param object $db database
         * @param object $lang language
         * @param int $id affected menu id
         * @param int $published menu status
         * @return bool
         */
        function toggleOffline($db, $id, $published, $lang)
        {
            /** @param $db db */

            // get name and status string
            $menuName = \YAWK\menu::getMenuNameByID($db, $id);
            $status = \YAWK\sys::iStatusToString($published, "online", "offline");

            // TOGGLE PAGE STATUS
            if ($res = $db->query("UPDATE {menu_names}
              SET published = '" . $published . "'
              WHERE id = '" . $id . "'"))
            {
                \YAWK\sys::setSyslog($db, 21, 0, "toggled <b>$menuName</b> to <b>$status</b>", 0, 0, 0, 0);
                return true;
            }
            else
            {
                \YAWK\sys::setSyslog($db, 23, 1, "failed toggle <b>$menuName</b> to <b>$status</b>", 0, 0, 0, 0);
                return false;
            }
        }

        /**
         * @brief toggle a menu entry offline
         * @copyright  2009-2016 Daniel Retzl
         * @license    https://opensource.org/licenses/MIT
         * @version    1.0.0
         * @param $db object database
         * @param $id int affected menu entry id
         * @param $published int menu status
         * @param $menuID int affected menu id
         * @return bool
         */
        function toggleItemOffline($db, $id, $published, $menuID)
        {
            /** @param $db db */

            // get name and status string
            $menuItem = \YAWK\menu::getMenuItemTitleByID($db, $id, $menuID);
            $status = \YAWK\sys::iStatusToString($published, "online", "offline");

            // TOGGLE PAGE STATUS
            if (!$res = $db->query("UPDATE {menu}
                                    SET published = '" . $published . "'
                                    WHERE id = '" . $id . "'"))
            {   // throw error
                \YAWK\sys::setSyslog($db, 23, 1, "failed to toggle <b>$menuItem</b> to <b>$status</b>", 0, 0, 0, 0);
                \YAWK\alert::draw("warning", "Warning!", "Menu status could not be toggled.", "","4200");
                return false;
            }
            else {
                // all ok
                \YAWK\sys::setSyslog($db, 21, 0, "toggled menu <b>$menuItem</b> to <b>$status</b>", 0, 0, 0, 0);
                return true;
            }
        }

        /**
         * @brief edit a single menu entry
         * @copyright  2009-2016 Daniel Retzl
         * @license    https://opensource.org/licenses/MIT
         * @version    1.0.0
         * @param object $db database
         * @param int $menu affected menu ID
         * @param int $id affected menu entry ID
         * @param string $title menu title
         * @param string $href menu link
         * @param int $sort sortation order
         * @param int $gid group id
         * @param int $published int 0|1 published status
         * @param int $parentID int id of the parent menu entry
         * @param string $target string link target (eg. _blank)
         * @return bool
         */
        static function editEntry($db, $menu, $id, $text, $title, $href, $sort, $gid, $published, $parentID, $target)
        {   /** @param $db db */
            $menuName = \YAWK\menu::getMenuNameByID($db, $menu);
            $date_changed = date("Y-m-d G:i:s");
            if ($res = $db->query("UPDATE {menu} SET
                                  sort = '" . $sort . "',
                                  href = '" . $href . "',
                                  text = '" . $text . "',
                                  title = '" . $title . "',
                                  gid = '" . $gid . "',
                                  published = '" . $published . "',
                                  date_changed = '" . $date_changed . "',
                                  parentID = '" . $parentID . "',
                                  target = '" . $target . "'
                                  WHERE id = '" . $id . "'
                                  AND menuID = '" . $menu . "'"))
            {
                \YAWK\sys::setSyslog($db, 21, 0, "edited <b>$title</b> in <b>$menuName</b>", 0, 0, 0, 0);
                return true;
            }
            else
            {   // q failed
                \YAWK\sys::setSyslog($db, 23, 1, "failed to edit <b>$title</b> in <b>$menuName</b>", 0, 0, 0, 0);
                return false;
            }
        }

        /**
         * @brief delete a single menu entry
         * @copyright  2009-2016 Daniel Retzl
         * @license    https://opensource.org/licenses/MIT
         * @version    1.0.0
         * @param object $db database
         * @param int $menu affected menu ID
         * @param int $id affected menu entry ID
         * @return bool
         */
        static function deleteEntry($db, $menu, $id)
        {   /** @param $db db */
            $menuName = \YAWK\menu::getMenuNameByID($db, $menu);
            $menuItem = \YAWK\menu::getMenuItemTitleByID($db, $id, $menu);
            if (!$res = $db->query("DELETE FROM {menu} WHERE menuID = '" . $menu . "' AND id = '" . $id . "'"))
            {   // throw error
                \YAWK\sys::setSyslog($db, 24, 1, "failed to delete <b>$menuItem</b> in <b>$menuName</b>", 0, 0, 0, 0);
                return false;
            }
            else
            {   // menu deleted
                if (!$res = $db->query("UPDATE {menu} SET id = id -1 WHERE id > '" . $id . "'"))
                {   // menu del not worked
                    \YAWK\sys::setSyslog($db, 23, 1, "failed to reset ID of menu <b>$menuName</b>", 0, 0, 0, 0);
                    return false;
                }
                else {
                    // all good, menu entry deleted
                    \YAWK\sys::setSyslog($db, 21, 0, "deleted <b>$menuItem</b> in <b>$menuName</b>", 0, 0, 0, 0);
                    return true;
                }
            }
        }

        /**
         * @brief delete a whole menu
         * @copyright  2009-2016 Daniel Retzl
         * @license    https://opensource.org/licenses/MIT
         * @version    1.0.0
         * @param object $db database
         * @param object $lang language
         * @param int $id affected menu ID
         * @return bool
         */
        static function delete($db, $id, $lang)
        {
            /** @param $db db */
            $menuName = \YAWK\menu::getMenuNameByID($db, $id);
            // delete menu itself
            if ($res = $db->query("DELETE FROM {menu_names} WHERE id = '" . $id . "'"))
            {   // delete according menu entries
                if ($res = $db->query("DELETE FROM {menu} WHERE menuID = '" . $id . "'"))
                {
                    // \YAWK\sys::setSyslog($db, 7, 0, "$lang[SYSLOG_MENU_DEL_ALLENTRIES_OK] <b>$menuName</b>", 0, 0, 0, 0);
                    \YAWK\sys::setSyslog($db, 21, 0, "deleted <b>$menuName</b> and all corresponding menu entries", 0, 0, 0, 0);
                    return true;
                }
                else
                {
                    // q failed
                    \YAWK\sys::setSyslog($db, 24, 1, "failed to delete menu <b>$menuName</b>", 0, 0, 0, 0);
                    return false;
                }
            }
            else
            {
                \YAWK\sys::setSyslog($db, 24, 1, "failed to delete menu <b>$menuName</b>", 0, 0, 0, 0);
            }
            return false;
        }


        /**
         * @brief display menu entries for editing in backend
         * @param object $db database
         * @param int $id affected menuID
         * @param array $lang language array
         */
        static function displayEditable($db, $id, $lang) /* SHOW EDITABLEN MENU ENTRIES IN BACKEND */
        {
            /** UPDATE: OPTIMIZATION NEEDED
             *  HERE SHOULD BE A SELECT JOIN user_groups + parent items
             *  instead of 3 different SELECTs - can anybody help here? */
            /** @param $db db */
            echo "
<table class=\"table table-striped table-hover table-responsive\" id=\"table-sort\">
  <thead>
    <tr>
      <td><strong>&nbsp;</strong></td>
      <td><strong>$lang[ID]</strong></td>
      <td><strong>$lang[TEXT]</strong></td>
      <td><strong>$lang[LINK]</strong></td>
      <td><strong>$lang[TITLE]</strong></td>
      <td><strong>$lang[GROUP]</strong></td>
      <td><strong>$lang[TARGET]</strong></td>
      <td><strong>$lang[SORTATION]</strong></td>
      <td><strong>$lang[PARENT_ELEMENT]</strong></td>
      <td><strong>&nbsp;</td>
    </tr>
  </thead>
  <tbody>";
            // get menu entries from database
            if ($res = $db->query("SELECT id, text, title, href, gid, target, sort, parentID, published
                             FROM {menu}
                             WHERE menuID = '".$id."'
                             ORDER BY sort, parentID, title"))
            {
                while ($row = mysqli_fetch_assoc($res))
                {
                    // get published status
                    if ($row['published'] === '1') {
                        $pub = "success";
                        // $pubtext = "On";
                        $pubtext = $lang['ON_'];
                    } else {
                        $pub = "danger";
                        // $pubtext = "Off";
                        $pubtext = $lang['OFF_'];
                    }
                    // get user groups
                    if ($group_res = $db->query("SELECT id, value FROM {user_groups} ORDER BY id")){
                        $groupArray = array();
                        $gidSelect = '';
                        while ($group_row = $group_res->fetch_assoc()){
                            $groupArray[] = $group_row;
                        }
                        foreach ($groupArray AS $group){
                            $gidSelect .= "
                            <option value=\"$group[id]\">$group[value]</option>";
                        }
                    }
                    // get name for group id
                    if (isset($row['gid'])){
                        $gid2name = $db->query("SELECT id, value FROM {user_groups} WHERE id = '".$row['gid']."'");
                        $groupName = mysqli_fetch_row($gid2name);
                    }

                    // prepare parentID select field
                    // get menu entry name for <option....> from menuID
                    if($entries_res = $db->query("SELECT id, text, title, parentID FROM {menu} WHERE menuID = $id ORDER BY sort, parentID, title"))
                    {
                        $menuSelect = '';
                        $menuSelected = '';
                        $menuSelectAddon = '';
                        while ($entries_row = mysqli_fetch_assoc($entries_res))
                        {   // only show data for
                            if ($row['id'] !== $entries_row['id']){
                                $menuSelect .= "
                                    <option value=\"" . $entries_row['id'] . "\">" . $entries_row['text'] . "</option>";
                                $menuSelectAddon = "<option value=\"0\">$lang[NO_PARENT]</option>";

                                if ($row['parentID'] === '0')
                                {
                                    $menuSelected = "<option value=\"0\" selected>$lang[NO_PARENT]</option>";
                                }
                                else {
                                    $parentID2name = $db->query("SELECT text FROM {menu} WHERE menuID = $id AND id=$row[parentID]");
                                    $parentName = mysqli_fetch_row($parentID2name);
                                    $menuSelected = "<option value=\"" . isset($row['parentID']) . "\" selected>" . isset($parentName[0]) . "</option>";
                                }
                            }
                        }
                    }


                    echo "
    <tr>
      <td><a href=\"index.php?page=menu-edit&toggleItem=1&menu=$id&id=$row[id]&published=$row[published]\">
          <span class=\"label label-$pub\">$pubtext</span></a></td>
      <td>
          <input type=\"text\" class=\"form-control pull-left\" name=\"" . $row['id'] . "_id\" readonly value=\"" . $row['id'] . "\" size=\"1\">
     </td>

      <td>
          <input type=\"text\" class=\"form-control pull-left\" name=\"" . $row['id'] . "_text\" value=\"" . $row['text'] . "\" size=\"12\">
      </td>
      <td>
          <input type=\"text\" class=\"form-control pull-left\" name=\"" . $row['id'] . "_href\" value=\"" . $row['href'] . "\" size=\"45\">
      </td>
      <td>
          <input type=\"text\" class=\"form-control pull-left\" name=\"" . $row['id'] . "_title\" value=\"" . $row['title'] . "\" size=\"12\">
      </td>

      <td>
      <select class=\"form-control\" name=\"" . $row['id'] . "_gid\">
        <option value=\"$groupName[0]\">$groupName[1]</option>
        $gidSelect
      </select>
      </td>
 
      <td>
      <select class=\"form-control\" name=\"" . $row['id'] . "_target\">
      <option value=\"" . $row['target'] . "\" selected>" . $row['target'] . "</option>
      <option value=\"_self\">$lang[SELF]</option>
      <option value=\"_blank\">$lang[BLANK]</option>
      <option value=\"_parent\">$lang[PARENT]</option>
      <option value=\"_top\">$lang[TOP]</option>
      </select>
       </td>
      
      <td>
        <input type=\"text\" class=\"form-control pull-left\" name=\"" . $row['id'] . "_sort\" value=\"" . $row['sort'] . "\" size=\"1\" maxlength=\"3\">
      </td>
      
      <td>
      <select class=\"form-control\" name=\"" . $row['id'] . "_parentID\">
      ".$menuSelected."
      ".$menuSelect."
      ".$menuSelectAddon."
      </select>
      </td>

      <td>
       <!-- <a href=\"index.php?page=menu-edit&menu=" . $id . "&entry=" . $row['id'] . "&deleteitem=1\"><i class=\"fa fa-trash-o\" alt=\"delete\"></i></a> -->
        
       <a class=\"fa fa-trash-o\" role=\"dialog\" data-confirm=\"$lang[DELETE] $lang[ENTRY] &laquo; $row[text] / $row[href] &raquo; $lang[FOR_SURE]?\" 
        title=\"$lang[DELETE]\" href=\"index.php?page=menu-edit&menu=" . $id . "&entry=" . $row['id'] . "&del=1&deleteitem=1delete=true\">
       </a>

        <input type=\"hidden\" name=\"" . $row['id'] ."_published\" value=\"".$row['published']."\">
      </td>
    </tr>";
                }
                echo "</tbody>
</table>";
            }
        }

        /**
         * @brief get menu from database, build and draw it
         * @copyright  2009-2016 Daniel Retzl
         * @license    https://opensource.org/licenses/MIT
         * @version    1.0.0
         * @param object $db database obj
         * @param int $id affected menu ID
         * @param object $user current user obj
         * @param object $template template obj
         */
        static function display($db, $id, $user, $template)
        {   /** @param db $db */
            $divider = '';
            if (isset($_SESSION['gid'])) {
                $currentRole = $_SESSION['gid'];
            } else $currentRole = 2;

            // Language Stuff
            // Check, if user has selected a language
            if (isset($_COOKIE['userSelectedLanguage']) && (!empty($_COOKIE['userSelectedLanguage'])))
            {   // get this language from menu db - TODO: language need to be checked - what happens, if lang is not there?
                $searchstring = "WHERE menuLanguage = '".$_COOKIE['userSelectedLanguage']."'";
            }
            else
            {   // if no cookie was set (no language selected) load the defined global menu
                $searchstring = "WHERE menuID = '" . $id . "'";
            }

            // Select entries from the menu table
            $res = $db->query("SELECT id, text, title, href, target, parentID, divider
                            FROM {menu}
                            ".$searchstring."
                            and gid <= '" . $currentRole . "'
                            AND published = 1
                            AND (date_publish <= NOW() or date_publish <=> NULL)
                            AND (date_unpublish >= NOW() or date_unpublish <=> NULL)
                            ORDER BY parentid, sort, title");

            // Create a multidimensional array to conatin a list of items and parents
            $menu = array(
                'items' => array(),
                'parents' => array()
            );
            // Builds the array lists with data from the menu table
            while ($items = mysqli_fetch_assoc($res)) {
                // Creates entry into items array with current menu item id ie. $menu['items'][1]
                $menu['items'][$items['id']] = $items;
                // Creates entry into parents array. Parents array contains a list of all items with children
                $menu['parents'][$items['parentID']][] = $items['id'];
            }

            // Menu builder function, parentId 0 is the root

            function buildMenu($db, $parent, $menu, $id, $currentRole, $divider, $user, $template)
            {   /** @param db $db */

                // check if template ID is set
                if (isset($template) && (!empty($template)))
                {
                    if (isset($template->id) && (!empty($template->id)))
                    {
                        $bootstrapVersion = \YAWK\template::returnCurrentBootstrapVersion($db, $template->id);
                    }
                    else
                    {   // get tpl ID
                        $template->id = \YAWK\template::getCurrentTemplateId($db);
                        $bootstrapVersion = \YAWK\template::returnCurrentBootstrapVersion($db, $template->id);
                    }
                }
                else
                {
                    $templateID = \YAWK\template::getCurrentTemplateId($db);
                    $bootstrapVersion = \YAWK\template::returnCurrentBootstrapVersion($db, $templateID);
                }

                // echo "<pre>";print_r($menu);echo"</pre>"; exit;
                $navBarBrand = '';
                $navbar_center = template::getTemplateSetting($db, "value", "navbar-center", $user, $template);
                $navbar_brand = template::getTemplateSetting($db, "value", "navbar-brand", $user, $template);
                $frontendSwitch = template::getTemplateSetting($db, "value", "frontendSwitch", $user, $template);

                if ($navbar_center == "1") { $navbar_center = " w-100 justify-content-center"; }
                else { $navbar_center = ""; }

                if (!empty($navbar_brand) && ($navbar_brand == 1))
                {
                    // get menu title
                    $res = $db->query("SELECT name FROM {menu_names} WHERE id='" . $id . "'");
                    $row = mysqli_fetch_row($res);
                    $menuName = $row[0];
                    if (!empty($menuName))
                    {
                        $navBarBrand = "<a class=\"navbar-brand\" id=\"navbar-brand\" href=\"index.html\">" . $menuName . "</a>";
                    }
                    else
                    {
                        $navBarBrand = "";
                    }
                }
                else
                {
                    $navBarBrand = "";
                }

                // User is able to switch template from frontend (typically to use a dark/lightmode).
                if (!empty($frontendSwitch) && ($frontendSwitch == 1))
                {
                    // get template IDs for light/dark theme (will be set on admin/template-redesign)
                    $darkThemeID = template::getTemplateSetting($db, "value", "darkThemeID", $user, $template);
                    $lightThemeID = template::getTemplateSetting($db, "value", "lightThemeID", $user, $template);
                    if (!empty($darkThemeID) && !empty($lightThemeID))
                    {   // html markup that draws our darkmode switch
                        $templateSwitchMarkup = "<div id=\"frontendSwitch\" class=\"pull-right\">
                        <a href=\"index.php?templateID=".$darkThemeID."\" class=\"text-muted\"><i id=\"darkMode\" data-id=\"".$darkThemeID."\" class=\"fa fa-moon-o\"></i></a> 
                            <span style=\"color:#ccc; margin-left:5px; margin-right:5px;\">|</span> 
                        <a href=\"index.php?templateID=".$lightThemeID."\" class=\"text-muted\"><i id=\"lightMode\" data-id=\"".$lightThemeID."\" class=\"fa fa-sun-o\"></i></a></div>";
                    }
                }

                // DRAW BOOTSTRAP 4 MENU
                if ($bootstrapVersion == "4")
                {
                    $html = "";
                    $html .= "

<nav id=\"navbar\" class=\"navbar navbar-expand-lg navbar-light navbar-bg-custom\" style=\"z-index: 9999;\">
".$navBarBrand."
  <button class=\"navbar-toggler custom-toggler\" type=\"button\" data-toggle=\"collapse\" data-target=\"#navbarSupportedContent\" aria-controls=\"navbarSupportedContent\" aria-expanded=\"false\" aria-label=\"Toggle navigation\">
    <span class=\"navbar-toggler-icon\"></span>
  </button>

  <div class=\"collapse navbar-collapse\" id=\"navbarSupportedContent\">";
                    // echo "<pre>"; print_r($menu); echo "</pre>";
                    // todo center:  w-100 justify-content-center
                    $html .="
    <ul class=\"navbar-nav ".$navbar_center."\">";
                    foreach ($menu['parents'][$parent] as $itemId) {
                        // set parent w/o child items
                        if (!isset($menu['parents'][$itemId])) {

                            if (!isset($menu['items'][$itemId]['title']) || (empty($menu['items'][$itemId]['title']))) {
                                $title = "";
                            } else {
                                $title = "title=\"" . $menu['items'][$itemId]['title'] . "\"";
                            }
                            $html .= "
        <li class=\"nav-item\">
            <a class=\"nav-link\" href=\"" . $menu['items'][$itemId]['href'] . "\" target=\"" . $menu['items'][$itemId]['target'] . "\" $title>" . $menu['items'][$itemId]['text'] . "</a>
        </li>";
                        }

                        // menu item got at least 1 child item and should react as dropdown toggle
                        else
                        {
                            $html .= "
        <li class=\"nav-item dropdown\">
            <a class=\"nav-link dropdown-toggle\" href=\"" . $menu['items'][$itemId]['href'] . "\" id=\"" . $menu['items'][$itemId]['text'] . "\" role=\"button\" data-toggle=\"dropdown\" aria-haspopup=\"true\" aria-expanded=\"false\">" . $menu['items'][$itemId]['text'] . "</a>
";
                        }

                        // set parents w child items (dropdown lists)
                        if (isset($menu['parents'][$itemId])) {
                            $html .= "
              <div class=\"dropdown-menu\" aria-labelledby=\"navbarDropdown\">";

                            // select child items from db
                            foreach ($menu['parents'][$itemId] as $child) {
                                if (!isset($menu['items'][$itemId]['title']) || (empty($menu['items'][$itemId]['title'])))
                                {
                                    $title = "";
                                }
                                else
                                {
                                    $title = "title=\"$menu[items][$itemId][title]\"";
                                }
                                $html .= "
                <a class=\"dropdown-item\" href=\"" . $menu['items'][$child]['href']."\" target=\"".$menu['items'][$itemId]['target']."\" $title>".$menu['items'][$child]['text']."</a>";
                            }
                            // dropdown navi ends here
                            $html .= "
            </div>
        </li>";

                        }
                    }

                    $html.="

    </ul>";

                    // logout menu link - display only if user is logged in
                    if (isset($_SESSION['username']) && isset($_SESSION['logged_in'])){
                        if ($_SESSION['logged_in'] == true){
                            // display only if logoutmenu is enabled
                            if (\YAWK\settings::getSetting($db, 'userpage_logoutmenu') === '1'){
                                $html .= \YAWK\menu::drawLogoutMenu($db);
                            }
                        }
                    }
                    else {$html .= "</ul>
                            <ul class=\"nav navbar-nav navbar-collapse navbar-right\">
                             <li>";
                        // check if userlogin is allowed
                        if (\YAWK\settings::getSetting($db, 'userlogin') === '1')
                        {   // load loginbox into navbar
                            $html .= \YAWK\user::drawMenuLoginBox("","", "light");
                        }
                        $html .= "</li></ul>";
                    }

                    $html .= "                    
</div>
".$templateSwitchMarkup."
</nav>

<script>
window.onscroll = function() {myFunction()};
var navbar = document.getElementById('navbar');
var sticky = navbar.offsetTop;
console.log(sticky);
function myFunction() {
  if (window.pageYOffset >= sticky) {
    navbar.classList.add('sticky')
  } else {
    navbar.classList.remove('sticky');
  }
}
</script>";

                    return $html;
                }

                // DRAW BOOTSTRAP 3 MENU
                else if ($bootstrapVersion == "3")
                {
                    $html = "";
                    $html .= "
             <nav class=\"navbar navbar-default\" role=\"navigation\" id=\"topnavbar\">
             <!-- <nav class=\"navbar navbar-default\" role=\"navigation\" id=\"topnavbar\"> -->
             <div class=\"container\">
             <div class=\"navbar-header\">
             <button type=\"button\" class=\"navbar-toggle\" data-toggle=\"collapse\" data-target=\".navbar-collapse\">
                <span class=\"sr-only\">Toggle navigation</span>
                <span class=\"icon-bar\"></span>
                <span class=\"icon-bar\"></span>
                <span class=\"icon-bar\"></span>
              </button>
              $navBarBrand
              </div> <!-- end nav header -->
            <div id=\"navbar\" class=\"navbar-collapse collapse\">";
                    if (isset($menu['parents'][$parent])) {
                        // Start Bootstrap menu markup
                        $html .= "<ul class=\"nav navbar-nav\">";
                        // repeat foreach menu entry
                        foreach ($menu['parents'][$parent] as $itemId)
                        {
                            // set parent w/o child items
                            if (!isset($menu['parents'][$itemId])) {
                                if (!isset($menu['items'][$itemId]['title']) || (empty($menu['items'][$itemId]['title'])))
                                {
                                    $title = "";
                                }
                                else
                                {
                                    $title = "title=\"".$menu['items'][$itemId]['title']."\"";
                                }
                                $html .= "<li><a href=\"".$menu['items'][$itemId]['href']."\" target=\"".$menu['items'][$itemId]['target']."\" $title>" . $menu['items'][$itemId]['text'] . "</a></li>";
                                // vertical spacer
                                // $html .= "".$divider_html."";

                            }

                            // set parents w child items (dropdown lists)
                            if (isset($menu['parents'][$itemId])) {
                                $html .= "<li class=\"dropdown\">
                            <a href=\"#\" class=\"dropdown-toggle\" data-toggle=\"dropdown\">" . $menu['items'][$itemId]['text'] . " <b class=\"caret\"></b></a>
                            <ul class=\"dropdown-menu\">";

                                // select child items from db
                                foreach ($menu['parents'][$itemId] as $child) {
                                    if (!isset($menu['items'][$itemId]['title']) || (empty($menu['items'][$itemId]['title'])))
                                    {
                                        $title = "";
                                    }
                                    else
                                    {
                                        $title = "title=\"$menu[items][$itemId][title]\"";
                                    }
                                    $html .= "<li><a href=\"" . $menu['items'][$child]['href']."\" target=\"".$menu['items'][$itemId]['target']."\" $title>".$menu['items'][$child]['text']."</a></li>\n";
                                }
                                // boostrap navi ends here
                                $html .= "</ul>
                  </li>";

                            }
                        } // end html markup of nav area
                        // logout menu link - display only if user is logged in
                        if (isset($_SESSION['username']) && isset($_SESSION['logged_in'])){
                            if ($_SESSION['logged_in'] == true){
                                // display only if logoutmenu is enabled
                                if (\YAWK\settings::getSetting($db, 'userpage_logoutmenu') === '1'){
                                    $html .= \YAWK\menu::drawLogoutMenu($db);
                                }
                            }
                        }
                        else {$html .= "</ul>
                            <ul class=\"nav navbar-nav navbar-collapse navbar-right\">
                             <li>";
                            // check if userlogin is allowed
                            if (\YAWK\settings::getSetting($db, 'userlogin') === '1')
                            {   // load loginbox into navbar
                                $html .= \YAWK\user::drawMenuLoginBox("","", "light");
                            }
                            $html .= "</li></ul>";
                        }
                        $html .= "<!-- /.nav-collapse -->
  </div><!-- /navbar-inn -->
 </div> <!-- /container -->
</nav><!-- navbar -->
";

                    }
                    return $html;
                }
                else
                {
                    "Unable to load Bootstrap Menu";
                }
                return null;
            }

            echo buildMenu($db, 0, $menu, $id, $currentRole, $divider, $user, $template);
        }

        /**
         * @brief draw the logout menu (if user is logged in...)
         * @copyright  2009-2016 Daniel Retzl
         * @license    https://opensource.org/licenses/MIT
         * @version    1.0.0
         * @param object $db database
         * @return bool|string
         */
        static function drawLogoutMenu($db){
            if (isset($_SESSION['username']) && $_SESSION['logged_in']) {
                if ($_SESSION['logged_in'] == true) {
                    $html = "</ul>
                            <ul id=\"logoutMenu\" class=\"nav navbar-nav navbar-collapse navbar-expand float-right pull-right\">
                             <li class=\"dropdown\">&nbsp;&nbsp;
                                <a id=\"logoutLink\" href=\"#\" class=\"dropdown-toggle\" data-toggle=\"dropdown\">";
                    $html .= \YAWK\user::getUserImage($db, "frontend", \YAWK\sys::getCurrentUserName(), 22, 22);
                    $html .= "</a>&nbsp;&nbsp;
                                <ul id=\"dropdown-menu\" class=\"dropdown-menu\">
                                    <li><a href=\"logout.html\"><i class=\"glyphicon glyphicon-log-out\"></i> &nbsp;Logout</a></li></li>
                            </ul>";
                    return $html;
                }
            }
            return false;
        }

        /**
         * @brief get menu name for given id
         * @copyright  2009-2016 Daniel Retzl
         * @license    https://opensource.org/licenses/MIT
         * @version    1.0.0
         * @param object $db database
         * @param array $lang language
         * @param int $id affected menu id
         * @return string
         */
        static function getMenuNameByID($db, $id)
        {   /* @param $db db */
            $menu = '';
            if ($res = $db->query("SELECT name from {menu_names} WHERE id = $id"))
            {
                if ($row = mysqli_fetch_row($res))
                {
                    $menu = $row[0];
                }
            }
            else
            {
                $menu = "MENU SELECT ID: $id failed";
            }
            return $menu;
        }

        /**
         * @brief returns the item title for given item and menu ID
         * @param object $db database
         * @param int $itemID the menu entry ID
         * @param int $menuID the menu ID
         * @return string title of the menu entry
         */
        static function getMenuItemTitleByID($db, $itemID, $menuID)
        {   /* @param $db db */
            $menu = '';
            if ($res = $db->query("SELECT title from {menu} WHERE id = $itemID AND menuID = $menuID"))
            {
                if ($row = mysqli_fetch_row($res))
                {
                    $menu = $row[0];
                }
            }
            else
            {
                $menu = "could not select menu item";
            }
            return $menu;
        }

    } // ./ class
} // ./ namespace
