<?PHP
/* DELETE MENU ENTRY */
if (isset($_GET['del']) && ($_GET['del'] === "1")) {
    switch ($_GET['deleteitem'])
    {
        case 1:
            $menuID = $_GET['menu'];
            $entry = $_GET['entry'];
            if (YAWK\menu::deleteEntry($db, $menuID, $entry) === true)
            {   // delete successful
                \YAWK\alert::draw("success", "Item deleted.", "Its all good...", "", 800);
            }
            else
                {   // could not delete - throw error
                    \YAWK\alert::draw("danger", "Menu entry could not be deleted.", "Database Error. Something strange has happened. Please try again.", "", 5800);
                }
         break;
    }
}
/* CHANGE MENU TITLE */
if(isset($_POST['changetitle'])) {
    if (!$res = \YAWK\menu::changeTitle($db, $db->quote($_GET['menu']),$db->quote($_POST['menutitle'])))
    {   // throw error
        \YAWK\alert::draw("warning", "Warning!", "Could not change menu title!", "page=menu-edit&menu=$_GET[menu]","4200");
        exit;
    }
}
/* ADD MENU ENTRY */
if(isset($_POST['add'])) {
  trim($_POST['newtitle']);
  trim($_POST['newurl']);
  if (!$res = YAWK\menu::addEntry($db, $db->quote($_GET['menu']),$db->quote($_POST['newtitle']),$db->quote($_POST['newurl'])))
  {
      \YAWK\alert::draw("danger", "Fehler", "Datensatz konnte nicht hinzugef&uuml;gt werden.","page=menu-edit&menu=$_GET[menu]","2200");
      exit;
  }
}
  else if(isset($_POST['save'])) {
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
//      echo "<br>".$params['gid']; exit;
      $_GET['menu'] = $db->quote($_GET['menu']);
      $id = $db->quote($id);
      $params['title'] = $db->quote($params['title']);
      $params['href'] = $db->quote($params['href']);
      $params['sort'] = $db->quote($params['sort']);
      $params['gid'] = $db->quote($params['gid']);
      $params['published'] = $db->quote($params['published']);
      $params['parentID'] = $db->quote($params['parentID']);
      $params['target'] = $db->quote($params['target']);
      YAWK\menu::editEntry($db,
          $_GET['menu'],
          $id,
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
        } );
    } );
</script>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper" id="content-FX">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <!-- draw title on top-->
        <?php
            /* MENU Title */
            $menuName = YAWK\sys::getMenuName($db, $_GET['menu']);
            echo \YAWK\backend::getTitle($menuName, $lang['EDIT']);
        ?>
        <ol class="breadcrumb">
            <li><a href="./" title="Dashboard"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="index.php?page=menus" title="Menus"> Menus</a></li>
            <li class="active"><a href="index.php?page=menu-edit" title="edit Menu"> Edit Menu</a></li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <!-- START CONTENT HERE -->

  <form role="form" action="index.php?page=menu-edit&menu=<?php echo $_GET['menu']; ?>" method="POST">
  <?php
  // DISPLAY EDITABLE MENU ENTRIES
  \YAWK\menu::displayEditable($db, $db->quote($_GET['menu']), $lang);
  ?>
  <input name="save" id="savebutton" class="btn btn-danger pull-right" type="submit" value="Speichern"/>
  
<br><br>

<div class="col-md-6">
      <h4>Eintrag in Men&uuml; <?php print \YAWK\sys::getMenuName($db, $_GET['menu']); ?> hinzuf&uuml;gen</h4>
      <input type="text" class="form-control" name="newtitle" maxlength="128" placeholder="Title" />
      <input type="text" class="form-control" name="newurl" maxlength="128" placeholder="http://link or filename e.g. index.html" />
      <input name="add" id="savebutton3" style="margin-top:5px;" class="btn btn-default pull-right" type="submit" value="Hinzuf&uuml;gen"/>
 </div>
<!-- 2nd col -->
<div class="col-md-6">
      <h4>Men&uuml; Titel &auml;ndern</h4>
      <input type="text" class="form-control" name="menutitle" maxlength="128" value="<?php print \YAWK\sys::getMenuName($db, $_GET['menu']); ?>">
      <input name="changetitle" style="margin-top:5px;" id="savebutton2" class="btn btn-default pull-right" type="submit" value="Speichern"/>
</div>
<br><br>
</form>
</div>