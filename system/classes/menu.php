<?php
namespace YAWK {
    /**
     * <b>The default menu class. Serves all the menu functions.</b>
     *
     * This class serves all functions to create, edit, delete and modify menus and menu entries.
     * <p><i>Class covers both, backend & frontend functionality.
     * See Methods Summary for Details!</i></p>
     *
     * @category   CMS
     * @package    System
     * @global     $connection
     * @global     $dbprefix
     * @author     Daniel Retzl <danielretzl@gmail.com>
     * @copyright  2009-2015 Daniel Retzl yawk.goodconnect.net
     * @license    http://www.gnu.org/licenses/gpl-2.0  GNU/GPL 2.0
     * @version    1.1.3
     * @link       http://yawk.io
     * @since      File available since Release 0.0.9
     * @annotation The default menu class. Serves all the menu functions.
     */
    class menu
    {
        public $id;
        public $published;
        public $parent;

        /* CREATE A NEW MENU */
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
                        return true;
                    }
                    else {
                        // q insert failed
                        return false;
                    }
                }
                else {
                    // q get maxID failed
                    return false;
                }
            }
        }

        /* CHANGE TITLE */
        static function changeTitle($db, $menu, $menutitle)
        {
            /** @var $db \YAWK\db $res */
            if ($res = $db->query("UPDATE {menu_names} SET
    							  		name = '" . $menutitle . "'
    							        WHERE id = '" . $menu . "'"))
            {
                return true;
            }
            else
            {
                return false;
            }
        }

        /* ADD MENU ENTRY */
        static function addEntry($db, $menu, $title, $href)
        {
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
            if (!$res = $db->query("INSERT INTO {menu}
               (id, sort, menuID, title, href, date_created, parentID)
               VALUES ('" . $id . "','" . $sort . "','" . $menu . "','" . $title . "','" . $href . "','" . $date_created . "','" . $parentID . "')"))
            {
                // q failed, throw error
                return false;
            }
            else {
                // q true
                return true;
            }
        }

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
                return false;
            }
        }

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
                return false;
            }
        }

        function toggleOffline($db, $id, $published)
        {
            /** @var $db \YAWK\db */
            // TOGGLE PAGE STATUS
            if ($res = $db->query("UPDATE {menu_names}
              SET published = '" . $published . "'
              WHERE id = '" . $id . "'"))
            {
                return true;
            }
            else
            {
                return false;
            }
        }

        function toggleItemOffline($db, $id, $published)
        {
            /** @var $db \YAWK\db */
            // TOGGLE PAGE STATUS
            if (!$res = $db->query("UPDATE {menu}
              SET published = '" . $published . "'
              WHERE id = '" . $id . "'"))
            {   // throw error
                \YAWK\alert::draw("warning", "Warning!", "Menu status could not be toggled.", "","4200");
            }
            else {
                // all ok
                return true;
            }
            // q failed
            return false;
        }

        /* EDIT MENU ENTRY */
        static function editEntry($db, $menu, $id, $title, $href, $sort, $gid, $published, $parentID, $target)
        {   /** @var $db \YAWK\db */
            $date_changed = date("Y-m-d G:i:s");
            if ($res = $db->query("UPDATE {menu} SET
    							  sort = '" . $sort . "',
    							  href = '" . $href . "',
                                  title = '" . $title . "',
                                  gid = '" . $gid . "',
                                  published = '" . $published . "',
                                  date_changed = '" . $date_changed . "',
                                  parentID = '" . $parentID . "',
                                  target = '" . $target . "'
                                  WHERE id = '" . $id . "'
                                  AND menuID = '" . $menu . "'"))
            {
                return true;
            }
            else
            {   // q failed
                return false;
            }
       }

        /* DELETE MENU ENTRY */
        static function deleteEntry($db, $menu, $id)
        {   /** @var $db \YAWK\db */
            if (!$res = $db->query("DELETE FROM {menu} WHERE menuID = '" . $menu . "' AND id = '" . $id . "'"))
            {   // throw error
                return false;
            }
            else
            {   // menu deleted
                if (!$res = $db->query("UPDATE {menu} SET id = id -1 WHERE id > '" . $id . "'"))
                {   // menu del not worked
                    return false;
                }
                else {
                    // all good, menu entry deleted
                    return true;
                }
            }
        }

        /* DELETE MENU */
        static function delete($db, $id)
        {
            /** @var $db \YAWK\db */
            // delete menu itself
            if ($res = $db->query("DELETE FROM {menu_names} WHERE id = '" . $id . "'"))
            {   // delete according menu entries
                if ($res = $db->query("DELETE FROM {menu} WHERE menuID = '" . $id . "'"))
                {
                    return true;
                }
                else
                {
                    // q failed
                    \YAWK\alert::draw("warning", "Warning!", "Could not delete menu entry id $id.","","2200");
                    return false;
                }
            }
            else
            {
                \YAWK\alert::draw("warning", "Warning!", "Could not delete menu_name id $id.","","2200");
            }
            return false;
        }


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
      <td><strong>ID</strong></td>
      <td><strong>Titel</strong></td>
      <td><strong>Link</strong></td>
      <td><strong>Group</strong></td>
      <td><strong>Target</strong></td>
      <td><strong>Order</strong></td>
      <td><strong>ParentID</strong></td>
      <td><strong>&nbsp;</td>
    </tr>
  </thead>
  <tbody>";
            // get menu entries from database
            if ($res = $db->query("SELECT id, title, href, gid, target, sort, parentID, published
  							 FROM {menu}
  							 WHERE menuID = '".$id."'
  							 ORDER BY sort, parentID, title"))
            {
                while ($row = mysqli_fetch_assoc($res))
                {
                    // get published status
                    if ($row['published'] === '1') {
                        $pub = "success";
                        $pubtext = "On";
                    } else {
                        $pub = "danger";
                        $pubtext = "Off";
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
                        if($entries_res = $db->query("SELECT id, title, parentID FROM {menu} ORDER BY sort, parentID, title"))
                        {
                            $menuSelect = '';
                            $menuSelected = '';
                            $menuSelectAddon = '';
                            while ($entries_row = mysqli_fetch_assoc($entries_res))
                            {   // only show data for
                                if ($row['id'] !== $entries_row['id']){
                                    $menuSelect .= "
                                    <option value=\"" . $entries_row['id'] . "\">" . $entries_row['title'] . "</option>";
                                    $menuSelectAddon = "<option value=\"0\">--no parent item--</option>";

                                    if ($row['parentID'] === '0')
                                    {
                                        $menuSelected = "<option value=\"0\" selected>--no parent item--</option>";
                                    }
                                    else {
                                        $parentID2name = $db->query("SELECT title FROM {menu} WHERE id=$row[parentID]");
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
          <input type=\"text\" class=\"form-control\" name=\"" . $row['id'] . "_id\" readonly value=\"" . $row['id'] . "\" size=\"1\" style=\"float:left;\" />
     </td>

      <td>
          <input type=\"text\" class=\"form-control\" name=\"" . $row['id'] . "_title\" value=\"" . $row['title'] . "\" size=\"12\" style=\"float:left;\" />
      </td>

      <td>
          <input type=\"text\" class=\"form-control\" name=\"" . $row['id'] . "_href\" value=\"" . $row['href'] . "\" size=\"45\" style=\"float:left;\" />
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
      <option value=\"_self\">_self</option>
      <option value=\"_blank\">_blank</option>
      <option value=\"_parent\">_parent</option>
      <option value=\"_top\">_top</option>
      </select>
       </td>
      
      <td>
        <input type=\"text\" class=\"form-control\" name=\"" . $row['id'] . "_sort\" value=\"" . $row['sort'] . "\" size=\"1\" maxlength=\"3\" style=\"float:left;\" />
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
        
       <a class=\"fa fa-trash-o\" role=\"dialog\" data-confirm=\"Den Eintrag &laquo; $row[title] / $row[href] &raquo; wirklich l&ouml;schen?\" 
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

        /* DRAW MENU { init call from class::displayGlobalMenu }  */
        static function display($db, $id)
        {   /** @var \YAWK\db $db */
            $divider = '';
            if (isset($_SESSION['gid'])) {
                $currentRole = $_SESSION['gid'];
            } else $currentRole = 2;

            // Select entries from the menu table
            $res = $db->query("SELECT id, title, href, parentID, divider
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
                    foreach ($menu['parents'][$parent] as $itemId) {
                        // set parent w/o child items
                        if (!isset($menu['parents'][$itemId])) {
                            $html .= "<li>\n  <a href='" . $menu['items'][$itemId]['href'] . "'>" . $menu['items'][$itemId]['title'] . "</a>\n</li> \n";
                            // vertical spacer
                            // $html .= "".$divider_html."";

                        }
                        // set parents w child items (dropdown lists)
                        if (isset($menu['parents'][$itemId])) {
                            $html .= "<li class=\"dropdown\">
            				<a href=\"#\" class=\"dropdown-toggle\" data-toggle=\"dropdown\">" . $menu['items'][$itemId]['title'] . " <b class=\"caret\"></b></a>
            				<ul class=\"dropdown-menu\">";

                            // select child items from db
                            foreach ($menu['parents'][$itemId] as $child) {
                                $html .= "<li>\n  <a href='" . $menu['items'][$child]['href'] . "'>" . $menu['items'][$child]['title'] . "</a>\n</li> \n";
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
                        $html .= \YAWK\user::drawMenuLoginBox("","", "light");
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


        /* call function for global menu */
        function displayGlobalMenu($db)
        {   /** @var $db \YAWK\db */
            $globalMenuId = \YAWK\settings::getSetting($db, "globalmenuid");
            \YAWK\menu::display($globalMenuId);
        }

        /* call function for local menu */

        function displayLocalMenu($globalstart, $globalend, $elementstart, $elementend, $class)
        {
            global $currentpage;
            if ($currentpage->menu > -1) {
               //  \YAWK\menu::display($currentpage->menu, $globalstart, $globalend, $elementstart, $elementend, $class);
                \YAWK\menu::display($currentpage->menu);
            }
        }

    }

// end class::menu


}
