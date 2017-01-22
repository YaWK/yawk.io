<?php
namespace YAWK {
    /**
     * <b>The default menu class. Serves all the menu functions.</b>
     *
     * This class serves all functions to create, edit, delete and modify menus and menu entries.
     * <p><i>Class covers both, backend & frontend functionality.
     * See Methods Summary for Details!</i></p>
     *
     * @author     Daniel Retzl <danielretzl@gmail.com>
     * @copyright  2009-2016 Daniel Retzl
     * @license    http://www.gnu.org/licenses/gpl-2.0  GNU/GPL 2.0
     * @version    1.0.0
     * @link       http://yawk.io
     * @annotation The default menu class. Serves all the menu functions.
     */
    class menu
    {
        /**
         * @var int the menu id
         */
        public $id;
        /**
         * @var string the menu name
         */
        public $name;
        /**
         * @var int the menu ID
         */
        public $menuID;
        /**
         * @var int 0|1 published - yes or no
         */
        public $published;
        /**
         * @var int the parent menu ID
         */
        public $parent;

        /**
         * display any subMenu (used by widgets to get any menu in any position)
         * @copyright  2009-2016 Daniel Retzl
         * @license    http://www.gnu.org/licenses/gpl-2.0  GNU/GPL 2.0
         * @version    1.0.0
         * @link       http://yawk.io
         * @param object $db database
         * @param int $menuID the menuID to get data
         */
        public function displaySubMenu($db, $menuID)
        {   /** @var \YAWK\db  $db */
            $res = $db->query("SELECT * FROM {menu}
                               WHERE menuID = '".$menuID."' 
                               AND published = '1' 
                               ORDER by sort, title");
            echo "<ul class=\"hideLeft list-group\" id=\"leftMenu\">";
            while ($row = mysqli_fetch_assoc($res))
            {
                echo "<li class=\"list-group-item\"><b><a href=\"".$row['href']."\" target=\"".$row['target']."\">".$row['text']."</a></b></li>";
            }
            echo "</ul>";
        }

        /**
         * display the global menu
         * @copyright  2009-2016 Daniel Retzl
         * @license    http://www.gnu.org/licenses/gpl-2.0  GNU/GPL 2.0
         * @version    1.0.0
         * @link       http://yawk.io
         * @param object $db database
         */
        static function displayGlobalMenu($db)
        {   /** @var \YAWK\db  $db */
            $res = $db->query("SELECT value FROM {settings}
                               WHERE property = 'globalmenuid'");
            if ($row = mysqli_fetch_row($res)) {
                if ($published = self::getMenuStatus($db, $row[0]) != '0') {
                    self::display($db, $row[0]);
                }
            }
        }

        /**
         * create a new menu
         * @copyright  2009-2016 Daniel Retzl
         * @license    http://www.gnu.org/licenses/gpl-2.0  GNU/GPL 2.0
         * @version    1.0.0
         * @link       http://yawk.io
         * @param object $db the database object
         * @param string $name the name of the new menu
         * @return bool
         */
        static function createMenu($db, $name)
        {   /** @var $db \YAWK\db */
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
                        \YAWK\sys::setSyslog($db, 7, "created menu id: $menuID <b>$name</b>", 0, 0, 0, 0);
                        return true;
                    }
                    else {
                        // q insert failed
                        \YAWK\sys::setSyslog($db, 5, "failed to create menu <b>$name</b>", 0, 0, 0, 0);
                        return false;
                    }
                }
                else {
                    // q get maxID failed
                    \YAWK\sys::setSyslog($db, 5, "failed to create menu - could not get MAX(id) from menu_names", 0, 0, 0, 0);
                    return false;
                }
            }
        }

        /**
         * Change the menu title
         * @copyright  2009-2016 Daniel Retzl
         * @license    http://www.gnu.org/licenses/gpl-2.0  GNU/GPL 2.0
         * @version    1.0.0
         * @link       http://yawk.io
         * @param object $db the database oject
         * @param int $menu affected menu ID
         * @param string $menutitle new menu title
         * @return bool
         */
        static function changeTitle($db, $menu, $menutitle)
        {
            /** @var $db \YAWK\db $res */
            if ($res = $db->query("UPDATE {menu_names} SET
    							  		name = '" . $menutitle . "'
    							        WHERE id = '" . $menu . "'"))
            {
                \YAWK\sys::setSyslog($db, 7, "updated menu title <b>$menutitle</b>", 0, 0, 0, 0);
                return true;
            }
            else
            {
                \YAWK\sys::setSyslog($db, 5, "failed to updated menu title <b>$menutitle</b>", 0, 0, 0, 0);
                return false;
            }
        }

        /**
         * add new entry to an existing menu
         * @param $db object database object
         * @copyright  2009-2016 Daniel Retzl
         * @license    http://www.gnu.org/licenses/gpl-2.0  GNU/GPL 2.0
         * @version    1.0.0
         * @link       http://yawk.io
         * @param $menu int affected menu ID
         * @param $text string new menu entry title
         * @param $href string new menu link
         * @return bool
         */
        static function addEntry($db, $menu, $text, $href)
        {
            $menuName = \YAWK\menu::getMenuNameByID($db, $menu);
            /** @var $db \YAWK\db */
            $date_created = date("Y-m-d G:i:s");
            $parentID = 0; // default parent = 0

            // ## select max ID from menu + add menu entry
            $res = $db->query("SELECT MAX(id), MAX(sort) FROM {menu}
                               WHERE menuID = '".$menu."'");

            $row = mysqli_fetch_row($res);
            if (isset($row[0]) && $row[1]) { // set id to 1
                $id = $row[0] + 1;
                $sort = $row[1] + 1;
            } else {
                $id = 1;
                $sort = 1;
            }

            if (!isset($id)) {
                $id = 1;
            }
            if (!isset($sort)) {
                $sort = 1;
            }
            // echo "<br><br>$id $sort $title $href"; exit;

            /* do query */
            if ($res = $db->query("INSERT INTO {menu}
               (id, sort, menuID, text, href, date_created, parentID)
               VALUES ('" . $id . "','" . $sort . "','" . $menu . "','" . $text . "','" . $href . "','" . $date_created . "','" . $parentID . "')"))
            {
                // entry added
                \YAWK\sys::setSyslog($db, 7, "added menu entry <b>$text</b> to <b>$menuName</b>", 0, 0, 0, 0);
                return true;
            }
            else {
                // failed
                \YAWK\sys::setSyslog($db, 5, "failed to add menu entry <b>$text</b> to <b>$menuName</b>", 0, 0, 0, 0);
                return false;
            }
        }

        /**
         * check if a whole menu is published or not
         * @copyright  2009-2016 Daniel Retzl
         * @license    http://www.gnu.org/licenses/gpl-2.0  GNU/GPL 2.0
         * @version    1.0.0
         * @link       http://yawk.io
         * @param object $db database object
         * @param int $menuid affected menu ID
         * @return bool
         */
        public static function getMenuStatus($db, $menuid)
        {
            /** @var $db \YAWK\db */
            // get status from menu db
            if ($res = $db->query("SELECT published FROM {menu_names} WHERE id = '" . $menuid . "'"))
            {   // fetch data
                $row = mysqli_fetch_row($res);
                return $row[0];
            }
            else
            {   // q failed
                \YAWK\sys::setSyslog($db, 5, "failed to get status of menu <b>id: $menuid</b> (menu::getMenuStatus)", 0, 0, 0, 0);
                return false;
            }
        }

        /**
         * check if a single menu entry is published or not
         * @copyright  2009-2016 Daniel Retzl
         * @license    http://www.gnu.org/licenses/gpl-2.0  GNU/GPL 2.0
         * @version    1.0.0
         * @link       http://yawk.io
         * @param $db object database object
         * @param $menuid int affected menu id
         * @return bool
         */
        public static function getMenuEntryStatus($db, $menuid)
        {
            /** @var $db \YAWK\db */
            if ($res = $db->query("SELECT published FROM {menu} WHERE id = '" . $menuid . "'"))
            {
                $row = mysqli_fetch_row($res);
                return $row[0];
            }
            else
            {
                \YAWK\sys::setSyslog($db, 5, "failed to get status of menu entry <b>id: $menuid</b> (menu::getMenuEntryStatus)", 0, 0, 0, 0);
                return false;
            }
        }

        /**
         * toggle a whole menu offline
         * @copyright  2009-2016 Daniel Retzl
         * @license    http://www.gnu.org/licenses/gpl-2.0  GNU/GPL 2.0
         * @version    1.0.0
         * @link       http://yawk.io
         * @param object $db database
         * @param int $id affected menu id
         * @param int $published menu status
         * @return bool
         */
        function toggleOffline($db, $id, $published)
        {
            /** @var $db \YAWK\db */

            // get name and status string
            $menuName = \YAWK\menu::getMenuNameByID($db, $id);
            $status = \YAWK\sys::iStatusToString($published, "online", "offline");

            // TOGGLE PAGE STATUS
            if ($res = $db->query("UPDATE {menu_names}
              SET published = '" . $published . "'
              WHERE id = '" . $id . "'"))
            {
                \YAWK\sys::setSyslog($db, 7, "toggled menu <b>$menuName</b> to <b>$status</b>", 0, 0, 0, 0);
                return true;
            }
            else
            {
                \YAWK\sys::setSyslog($db, 5, "failed to get toggle <b>$menuName</b> to <b>$status</b>", 0, 0, 0, 0);
                return false;
            }
        }

        /**
         * toggle a menu entry offline
         * @copyright  2009-2016 Daniel Retzl
         * @license    http://www.gnu.org/licenses/gpl-2.0  GNU/GPL 2.0
         * @version    1.0.0
         * @link       http://yawk.io
         * @param $db object database
         * @param $id int affected menu entry id
         * @param $published int menu status
         * @param $menuID int affected menu id
         * @return bool
         */
        function toggleItemOffline($db, $id, $published, $menuID)
        {
            /** @var $db \YAWK\db */

            // get name and status string
            $menuItem = \YAWK\menu::getMenuItemTitleByID($db, $id, $menuID);
            $status = \YAWK\sys::iStatusToString($published, "online", "offline");

            // TOGGLE PAGE STATUS
            if (!$res = $db->query("UPDATE {menu}
                                    SET published = '" . $published . "'
                                    WHERE id = '" . $id . "'"))
            {   // throw error
                \YAWK\sys::setSyslog($db, 5, "failed to toggle <b>$menuItem</b> to <b>$status</b>", 0, 0, 0, 0);
                \YAWK\alert::draw("warning", "Warning!", "Menu status could not be toggled.", "","4200");
                return false;
            }
            else {
                // all ok
                \YAWK\sys::setSyslog($db, 7, "toggled menu <b>$menuItem</b> to <b>$status</b>", 0, 0, 0, 0);
                return true;
            }
        }

        /**
         * edit a single menu entry
         * @copyright  2009-2016 Daniel Retzl
         * @license    http://www.gnu.org/licenses/gpl-2.0  GNU/GPL 2.0
         * @version    1.0.0
         * @link       http://yawk.io
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
        {   /** @var $db \YAWK\db */
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
                \YAWK\sys::setSyslog($db, 7, "edited <b>$title</b> in <b>$menuName</b>", 0, 0, 0, 0);
                return true;
            }
            else
            {   // q failed
                \YAWK\sys::setSyslog($db, 5, "failed to edit <b>$title</b> in <b>$menuName</b>", 0, 0, 0, 0);
                return false;
            }
       }

        /**
         * delete a single menu entry
         * @copyright  2009-2016 Daniel Retzl
         * @license    http://www.gnu.org/licenses/gpl-2.0  GNU/GPL 2.0
         * @version    1.0.0
         * @link       http://yawk.io
         * @param object $db database
         * @param int $menu affected menu ID
         * @param int $id affected menu entry ID
         * @return bool
         */
        static function deleteEntry($db, $menu, $id)
        {   /** @var $db \YAWK\db */
            $menuName = \YAWK\menu::getMenuNameByID($db, $menu);
            $menuItem = \YAWK\menu::getMenuItemTitleByID($db, $id, $menu);
            if (!$res = $db->query("DELETE FROM {menu} WHERE menuID = '" . $menu . "' AND id = '" . $id . "'"))
            {   // throw error
                \YAWK\sys::setSyslog($db, 5, "failed to delete <b>$menuItem</b> in <b>$menuName</b>", 0, 0, 0, 0);
                return false;
            }
            else
            {   // menu deleted
                if (!$res = $db->query("UPDATE {menu} SET id = id -1 WHERE id > '" . $id . "'"))
                {   // menu del not worked
                    \YAWK\sys::setSyslog($db, 5, "failed to reset ID of menu <b>$menuName</b>", 0, 0, 0, 0);
                    return false;
                }
                else {
                    // all good, menu entry deleted
                    \YAWK\sys::setSyslog($db, 7, "deleted <b>$menuItem</b> in <b>$menuName</b>", 0, 0, 0, 0);
                    return true;
                }
            }
        }

        /**
         * delete a whole menu
         * @copyright  2009-2016 Daniel Retzl
         * @license    http://www.gnu.org/licenses/gpl-2.0  GNU/GPL 2.0
         * @version    1.0.0
         * @link       http://yawk.io
         * @param object $db database
         * @param int $id affected menu ID
         * @return bool
         */
        static function delete($db, $id)
        {
            /** @var $db \YAWK\db */
            $menuName = \YAWK\menu::getMenuNameByID($db, $id);
            // delete menu itself
            if ($res = $db->query("DELETE FROM {menu_names} WHERE id = '" . $id . "'"))
            {   // delete according menu entries
                if ($res = $db->query("DELETE FROM {menu} WHERE menuID = '" . $id . "'"))
                {
                    \YAWK\sys::setSyslog($db, 7, "deleted all entries of <b>$menuName</b>", 0, 0, 0, 0);
                    \YAWK\sys::setSyslog($db, 7, "deleted menu <b>$menuName</b>", 0, 0, 0, 0);
                    return true;
                }
                else
                {
                    // q failed
                    \YAWK\sys::setSyslog($db, 5, "failed to delete menu entries of <b>$menuName</b>", 0, 0, 0, 0);
                    \YAWK\alert::draw("warning", "Warning!", "Could not delete menu entry id $id.","","2200");
                    return false;
                }
            }
            else
            {
                \YAWK\sys::setSyslog($db, 5, "failed to delete menu <b>$menuName</b>", 0, 0, 0, 0);
                \YAWK\alert::draw("warning", "Warning!", "Could not delete menu_name id $id.","","2200");
            }
            return false;
        }


        /**
         * display menu entries for editing in backend
         * @param object $db database
         * @param int $id affected menuID
         * @param array $lang language array
         */
        static function displayEditable($db, $id, $lang) /* SHOW EDITABLEN MENU ENTRIES IN BACKEND */
        {
            /** UPDATE: OPTIMIZATION NEEDED
             *  HERE SHOULD BE A SELECT JOIN user_groups + parent items
             *  instead of 3 different SELECTs - can anybody help here? */
            /** @var $db \YAWK\db */
            echo "
<table class=\"table table-striped table-hover\" id=\"table-sort\">
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
                                        $menuSelected = "<option value=\"" . $row['parentID'] . "\" selected>" . $parentName[0] . "</option>";
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
         * get menu from database, build and draw it
         * @copyright  2009-2016 Daniel Retzl
         * @license    http://www.gnu.org/licenses/gpl-2.0  GNU/GPL 2.0
         * @version    1.0.0
         * @link       http://yawk.io
         * @param object $db database obj
         * @param int $id affected menu ID
         */
        static function display($db, $id)
        {   /** @var \YAWK\db $db */
            $divider = '';
            if (isset($_SESSION['gid'])) {
                $currentRole = $_SESSION['gid'];
            } else $currentRole = 2;

            // Select entries from the menu table
            $res = $db->query("SELECT id, text, title, href, target, parentID, divider
                            FROM {menu}
                            WHERE menuID = '" . $id . "'
                            and gid <= '" . $currentRole . "'
                            AND published = 1
                            AND (date_publish <= NOW() or date_publish = '0000-00-00 00:00:00')
                            AND (date_unpublish >= NOW() or date_unpublish = '0000-00-00 00:00:00')
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

            function buildMenu($db, $parent, $menu, $id, $currentRole, $divider)
            {   /** @var \YAWK\db $db */
           // echo "<pre>";print_r($menu);echo"</pre>"; exit;
                $titleCode = '';
                /*
                    if ($menu['items']['divider'] === '1')
                        {
                         $divider_html = "<li class=\"divider-vertical\"></li>";
                        }
                */
                $title_status = template::getTemplateSetting($db, "value", "globalmenu-title");
                if ($title_status != '0') {
                    // get menu title
                    $res = $db->query("SELECT name FROM {menu_names} WHERE id='" . $id . "'");
                    $row = mysqli_fetch_row($res);
                    $menuName = $row[0];
                    if (!empty($menuName)) {
                        $titleCode = "<a class=\"navbar-brand\" href=\"index.html\">" . $menuName . "</a>";
                    } else {
                        $titleCode = "";
                    }
                }

                $html = "";
                $html .= "
             <nav class=\"navbar navbar-default navbar-fixed-top\" role=\"navigation\" id=\"topnavbar\">
             <div class=\"container\">
             <div class=\"navbar-header\">
             <button type=\"button\" class=\"navbar-toggle\" data-toggle=\"collapse\" data-target=\".navbar-collapse\">
                <span class=\"sr-only\">Toggle navigation</span>
                <span class=\"icon-bar\"></span>
                <span class=\"icon-bar\"></span>
                <span class=\"icon-bar\"></span>
              </button>
              $titleCode
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
                            $html .= "<li>\n  <a href=\"".$menu['items'][$itemId]['href']."\" target=\"".$menu['items'][$itemId]['target']."\" $title>" . $menu['items'][$itemId]['text'] . "</a>\n</li> \n";
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
  </div><!-- /container -->
</nav><!-- navbar --> \n";
                }
                return $html;
            }

            echo buildMenu($db, 0, $menu, $id, $currentRole, $divider);

        }

        /**
         * draw the logout menu (if user is logged in...)
         * @copyright  2009-2016 Daniel Retzl
         * @license    http://www.gnu.org/licenses/gpl-2.0  GNU/GPL 2.0
         * @version    1.0.0
         * @link       http://yawk.io
         * @param object $db database
         * @return bool|string
         */
        static function drawLogoutMenu($db){
            if (isset($_SESSION['username']) && $_SESSION['logged_in']) {
                if ($_SESSION['logged_in'] == true) {
                    $html = "</ul>
                            <ul id=\"logoutMenu\" class=\"nav navbar-nav navbar-collapse navbar-right\">
                             <li class=\"dropdown\">
                                <a id=\"logoutLink\" href=\"#\" class=\"dropdown-toggle\" data-toggle=\"dropdown\">";
                    $html .= "<i id=\"trophy\" class=\"fa fa-trophy\"></i></small>&nbsp;";
                    $html .= "<i id=\"cog\" class=\"fa fa-cog\"></i></small>&nbsp;";
                    $html .= \YAWK\user::getUserImage($db, "frontend", \YAWK\sys::getCurrentUserName(), 22, 22);
                    $html .= "</a>
                                <ul id=\"dropdown-menu\" class=\"dropdown-menu\">
                                    <li><a href=\"welcome.html\" title=\"VIP Club Startseite\"><i class=\"fa fa-trophy\"></i> &nbsp;VIP Club</a></li>
                                    <li class=\"divider\"></li>
                                    <li><a href=\"logout.html\"><i class=\"glyphicon glyphicon-log-out\"></i> &nbsp;Logout</a></li></li>
                            </ul>";
                    return $html;
                }
            }
            return false;
        }

        /**
         * get menu name for given id
         * @copyright  2009-2016 Daniel Retzl
         * @license    http://www.gnu.org/licenses/gpl-2.0  GNU/GPL 2.0
         * @version    1.0.0
         * @link       http://yawk.io
         * @param object $db database
         * @param int $id affected menu id
         * @return string
         */
        static function getMenuNameByID($db, $id)
        {   /* @var $db \YAWK\db */
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
                    $menu = "could not select menu";
                }
                return $menu;
        }

        /**
         * returns the item title for given item and menu ID
         * @param object $db database
         * @param int $itemID the menu entry ID
         * @param int $menuID the menu ID
         * @return string title of the menu entry
         */
        static function getMenuItemTitleByID($db, $itemID, $menuID)
        {   /* @var $db \YAWK\db */
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
