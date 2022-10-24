<?php
// IMPORT REQUIRED CLASSES
use YAWK\alert;
use YAWK\backend;
use YAWK\db;
use YAWK\language;
use YAWK\menu;
use YAWK\sys;

// CHECK REQUIRED OBJECTS
if (!isset($page)) // if no page object is set
{   // create new page object
    $page = new YAWK\page();
}
if (!isset($db))
{   // create database object
    $db = new db();
}
if (!isset($lang))
{   // create language object
    $lang = new language();
}
// TOGGLE MENU ITEM
if (isset($_GET['toggleItem']))
{
    if (isset($_GET['published']) && (isset($_GET['menu']) && ($_GET['id'])))
    {
        if (is_numeric($_GET['published'])
            && (is_numeric($_GET['menu'])
                && (is_numeric($_GET['id']))))
        {
            // data is set, types seem to be correct, go ahead...
            if (!isset($menu))
            {   // create new menu object
                $menu = new YAWK\menu();
            }
            $menu->parent = $db->quote($_GET['menu']);
            $menu->id = $db->quote($_GET['id']);
            $menu->published = $db->quote($_GET['published']);

            // check status and toggle it
            if ($menu->published === '1') {
                $menu->published = 0;
                $status = $lang['OFFLINE'];
                $color = "warning";
            }
            else {
                $menu->published = 1;
                $status = $lang['ONLINE'];
                $color = "success";
            }
            // all ok, now toggle that menu entry
            if($menu->toggleItemOffline($db, $menu->id, $menu->published, $menu->parent))
            {   // throw notification
                alert::draw("$color", "$lang[MENU_ITEM] $lang[IS_NOW] $status", "$lang[MENU_ITEM] $lang[TOGGLED_TO] $status.", "", 800);
            }
            else
            {   // throw error
                alert::draw("danger", "$lang[ERROR]", "$lang[FAILED] $lang[TOGGLE] $lang[MENU_ITEM] $status.", "",5800);
            }

        }
    }
}

// DELETE MENU ENTRY
if (isset($_GET['del']) && ($_GET['del'] === "1")) {
    switch ($_GET['deleteitem'])
    {
        case 1:
            $menuID = $_GET['menu'];
            $entry = $_GET['entry'];
            if (YAWK\menu::deleteEntry($db, $menuID, $entry) === true)
            {   // delete successful
                alert::draw("success", "$lang[ITEM] $lang[DELETED].", "$lang[MENU_ITEM] $lang[DELETED]", "", 800);
            }
            else
                {   // could not delete - throw error
                    alert::draw("danger", "$lang[MENU_ITEM] $lang[DELETE] $lang[FAILED].", "$lang[DATABASE] $lang[ERROR].", "", 5800);
                }
         break;
    }
}
/* CHANGE MENU TITLE */
if(isset($_POST['changetitle'])) {
    if (!$res = menu::changeTitle($db, $db->quote($_GET['menu']),$db->quote($_POST['menutitle'])))
    {   // throw error
        alert::draw("warning", "$lang[WARNING]!", "$lang[MENU_CHANGE_FAILED]", "page=menu-edit&menu=$_GET[menu]","4200");
        exit;
    }
}
/* CHANGE MENU LANGUAGE */
if(isset($_POST['changeLanguage'])) {
    if (!$res = menu::changeLanguage($db, $db->quote($_GET['menu']),$db->quote($_POST['menuLanguage'])))
    {   // throw error
        alert::draw("warning", "$lang[WARNING]!", "$lang[MENU_CHANGE_FAILED]", "page=menu-edit&menu=$_GET[menu]","4200");
        exit;
    }
}
/* ADD MENU ENTRY */
if(isset($_POST['add'])) {
  $_POST['newtitle'] = trim($_POST['newtitle']);
  $_POST['newurl'] = trim($_POST['newurl']);
  if (!$res = YAWK\menu::addEntry($db, $db->quote($_GET['menu']),$db->quote($_POST['newtitle']),$db->quote($_POST['newurl'])))
  {
      alert::draw("danger", "$lang[ERROR]", "$lang[MENU_ADD_FAILED].","page=menu-edit&menu=$_GET[menu]","2200");
      exit;
  }
}
  else if(isset($_POST['save'])) {
    $entries = array();
    foreach($_POST as $param=>$value){

    if(substr($param,-4,4) === "_gid"){
            $entries[substr($param,0,-4)]['gid'] = $value;
        }
      if(strlen($param) >= 6){
        if(substr($param,-5,5) === "_href"){
          $entries[substr($param,0,-5)]['href'] = $value;
        }
        else if(substr($param,-7,7) === "_target"){
            $entries[substr($param,0,-7)]['target'] = $value;
        }
        else if(strlen($param) >= 5 && substr($param,-5,5) === "_text"){
            $entries[substr($param,0,-5)]['text'] = $value;
        }
        else if(strlen($param) >= 7 && substr($param,-6,6) === "_title"){
         $entries[substr($param,0,-6)]['title'] = $value;
        }
        else if(substr($param,-5,5) === "_sort"){
          $entries[substr($param,0,-5)]['sort'] = $value;
        }
        else if(substr($param,-10,10) === "_published"){
          $entries[substr($param,0,-10)]['published'] = $value;
        }
        else if(substr($param,-9,9) === "_parentID"){
          $entries[substr($param,0,-9)]['parentID'] = $value;
        }
        else if(substr($param,-8,8) === "_divider"){
          $entries[substr($param,0,-8)]['divider'] = $value;
        }
      }
    }

    foreach($entries as $id=>$params){
    // echo "<br>".$params['gid']; exit;
      $_GET['menu'] = $db->quote($_GET['menu']);
      $id = $db->quote($id);
      $params['text'] = $db->quote($params['text']);
      $params['title'] = $db->quote($params['title']);
      $params['href'] = $db->quote($params['href']);
      $params['sort'] = $db->quote($params['sort']);
      $params['gid'] = $db->quote($params['gid']);
      $params['published'] = $db->quote($params['published']);
      if (isset($params['parentID']) && (!empty($params['parentID'])))
      { $params['parentID'] = $db->quote($params['parentID']); }
      $params['target'] = $db->quote($params['target']);
      YAWK\menu::editEntry($db,
          $_GET['menu'],
          $id,
          $params['text'],
          $params['title'],
          $params['href'],
          $params['sort'],
          $params['gid'],
          $params['published'],
          $params['parentID'],
          $params['target']);
    }
  }
  else {
    foreach($_POST as $param=>$value){
      if(strlen($param) >= 8){
        if(substr($param,-7,7) === "_delete"){
          YAWK\menu::deleteEntry($db, $_GET['menu'], substr($param,0,-7));
        }
      }
    }
  }
?>

<!-- data tables JS -->
<script type="text/javascript">
    $(document).ready(function() {
        $('#table-sort').dataTable( {
            "bPaginate": false,
            "bLengthChange": false,
            "bFilter": true,
            "bSort": true,
            "bInfo": true,
            "bAutoWidth": false
        });

        // TRY TO DISABLE CTRL-S browser hotkey
        function saveHotkey() {
            // simply disables save event for chrome
            $(window).keypress(function (event) {
                if (!(event.which === 115 && (navigator.platform.match("Mac") ? event.metaKey : event.ctrlKey)) && !(event.which === 19)) return true;
                event.preventDefault();
                formmodified=0; // do not warn user, just save.
                return false;
            });
            // used to process the cmd+s and ctrl+s events
            $(document).keydown(function (event) {
                if (event.which === 83 && (navigator.platform.match("Mac") ? event.metaKey : event.ctrlKey)) {
                    event.preventDefault();
                    $('#savebutton').click(); // SAVE FORM AFTER PRESSING STRG-S hotkey
                    formmodified=0; // do not warn user, just save.
                    // save(event);
                    return false;
                }
            });
        }
        saveHotkey();
    });
</script>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper" id="content-FX">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <!-- draw title on top-->
        <?php
            /* MENU Title */
            $menuName = YAWK\sys::getMenuName($db, $_GET['menu']);
            echo backend::getTitle($menuName, $lang['EDIT']);
        ?>
        <ol class="breadcrumb">
            <li><a href="./" title="<?php echo $lang['DASHBOARD']; ?>"><i class="fa fa-dashboard"></i> <?php echo $lang['DASHBOARD']; ?></a></li>
            <li><a href="index.php?page=menus" title="<?php echo $lang['MENUS']; ?>"> <?php echo $lang['MENUS']; ?></a></li>
            <li class="active"><a href="index.php?page=menu-edit&menu=<?php echo $_GET['menu']; ?>" title="<?php echo $lang['EDIT_MENU']; ?>"> <?php echo $lang['EDIT_MENU']; ?></a></li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
    <!-- START CONTENT HERE -->
<form role="form" action="index.php?page=menu-edit&menu=<?php echo $_GET['menu']; ?>" method="POST">
<div class="box box-default">
    <div class="box-body">
        <!-- save btn -->
        <button name="save"
                id="savebutton"
                class="btn btn-success pull-right"
                type="submit"><i class="fa fa-save"></i>&nbsp; <?php echo $lang['MENU_SAVE']; ?>
        </button>
        <!-- back btn -->
        <a class="btn btn-default pull-right" href="index.php?page=menus">
        <i class="glyphicon glyphicon-backward"></i> &nbsp;<?php print $lang['BACK']; ?></a>
      <?php
      // DISPLAY EDITABLE MENU ENTRIES
      menu::displayEditable($db, $db->quote($_GET['menu']), $lang);
      ?>

    <br><br>

    </div>
</div>

    <div class="row">
        <div class="col-md-6">
            <div class="box default">
                <div class="box-header with border">
                    <h3 class="box-title"><?php echo $lang['ENTRY_ADD']; ?></h3>
                </div>
                <div class="box-body">
                    <label for="newtitle"><?php echo $lang['TITLE']; ?></label><input type="text"
                                                         id="newtitle"
                                                         class="form-control"
                                                         name="newtitle"
                                                         maxlength="128"
                                                         placeholder="<?php echo $lang['TITLE']; ?>">
                    <label for="newurl"><?php echo $lang['LINK_OR_FILENAME']; ?></label><input type="text"
                                                       id="newurl"
                                                       class="form-control"
                                                       name="newurl"
                                                       maxlength="128"
                                                       placeholder="<?php echo $lang['LINK_OR_FILENAME']; ?>">
                    <input name="add"
                           id="savebutton3"
                           style="margin-top:5px;"
                           class="btn btn-default pull-right"
                           type="submit"
                           value="<?php echo $lang['ADD']; ?>">
                </div>
            </div>
         </div>
        <!-- 2nd col -->
        <div class="col-md-6">
            <div class="box default">
                <div class="box-header with border">
                    <h3 class="box-title"><?php echo $lang['MENU_TITLE_CHANGE']; ?></h3>
                </div>
                <div class="box-body">
                    <label for="menutitle"><?php echo $lang['TITLE']; ?></label>
                        <input type="text"
                               id = "menutitle"
                               class="form-control"
                               name="menutitle"
                               maxlength="128"
                               value="<?php echo $menuName; ?>">

                    <input name="changetitle"
                           style="margin-top:5px;"
                           id="savebutton2"
                           class="btn btn-default pull-right"
                           type="submit"
                           value="<?php echo $lang['SAVE']; ?>">
                    </div>
            </div>
            <div class="box default">
                <div class="box-header with border">
                    <h3 class="box-title"><?php echo $lang['MENU_LANGUAGE_CHANGE']; ?></h3>
                </div>
                <div class="box-body">
                    <label for="menuLanguage"><?php echo $lang['LANGUAGE']; ?></label>
                    <select id="menuLanguage" name="menuLanguage" class="form-control">
                        <?php $menuLanguage = sys::getMenuLanguage($db, $_GET['menu']); ?>

                        <?php
                        if (isset($menuLanguage) && (!empty($menuLanguage)))
                        {
                            echo "<option value=".$menuLanguage." selected>$menuLanguage</option>";
                        }
                            echo language::drawLanguageSelectOptions();
                        ?>
                    </select>
                    <input name="changeLanguage"
                           style="margin-top:5px;"
                           id="savebutton2"
                           class="btn btn-default pull-right"
                           type="submit"
                           value="<?php echo $lang['SAVE']; ?>">
                </div>
            </div>
        </div>
    </div>
</form>