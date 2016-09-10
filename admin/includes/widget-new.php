<?php
// TEMPLATE WRAPPER - HEADER & breadcrumbs
echo "
    <!-- Content Wrapper. Contains page content -->
    <div class=\"content-wrapper\" id=\"content-FX\">
    <!-- Content Header (Page header) -->
    <section class=\"content-header\">";
/* draw Title on top */
echo \YAWK\backend::getTitle($lang['WIDGET+'], $lang['WIDGETS+_SUBTEXT']);
echo"<ol class=\"breadcrumb\">
            <li><a href=\"index.php\" title=\"Dashboard\"><i class=\"fa fa-dashboard\"></i> Dashboard</a></li>
            <li><a href=\"index.php?page=widgets\" title=\"Widgets\"> Widgets</a></li>
            <li class=\"active\"><a href=\"index.php?page=widget-new\" title=\"Add Widget\"> Add Widget</a></li>
         </ol>
    </section>
    <!-- Main content -->
    <section class=\"content\">";
/* page content start here */


if(!isset($_POST['widgetType'])){
  // 	$cmspath = YAWK\settings::getSetting("cmspath");
?>

  <form action="index.php?page=widget-new" role="form" method="post">
      <dl class="dl-horizontal">
          <dt><label for="widgetType">Erzeuge:</label> </dt>
          <dd><select id="widgetType" name="widgetType" class="btn btn-default">
                  <?PHP
                  foreach(YAWK\widget::getWidgets($db) as $widget){
                      echo "<option value=\"".$widget['id']."\"";

                      if (isset($_POST['widget'])) {
                          if($_POST['widget'] === $page['id']){
                              echo " selected=\"selected\"";
                          }
                          else if($widget->widget === $widget['id'] && !$_POST['widget']){
                              echo " selected=\"selected\"";
                          }
                      }
                      echo ">".$widget['name']."</option>";
                  }
                  ?>
              </select>
          </dd>
          <dt><label for="pageID">in Seite:</label> </dt>
          <dd>
              <select id="pageID" name="pageID" class="btn btn-default">
                  <option value="0">-- all pages --</option>
                  <?PHP
                  foreach(YAWK\sys::getPages($db) as $page){
                      echo "<option value=\"".$page['id']."\"";

                      if (isset($_POST['pageID'])) {
                          if($_POST['pageID'] === $page['id']){
                              echo " selected=\"selected\"";
                          }
                          else if($page->page === $page['id'] && !$_POST['page']){
                              echo " selected=\"selected\"";
                          }
                      }
                      echo ">".$page['title']."</option>";
                  }
                  ?>
              </select>
          </dd>
          <dt><label for="position">auf Position</label> </dt>
          <dd>
              <select id="position" name="positions" class="btn btn-default">
                  <option value=""></option>
                  <?PHP
                  $i = 0;
                  foreach(YAWK\template::getTemplatePositions($db) as $position[]){
                      echo "<option value=\"".$position[$i]."\"";

                      if (isset($_POST['positions'])) {
                          if($_POST['0'] === $position['positions']){
                              echo " selected=\"selected\"";
                          }
                          else if($position->positions === $position['positions'] && !$_POST['positions']){
                              echo " selected=\"selected\"";
                          }
                      }
                      echo ">".$position[$i]."</option>";
                      $i++;
                  }
                  ?>
              </select>
          </dd>
          <dt>&nbsp;</dt>
          <dd>
              <input type="submit" class="btn btn-success" value="Erstellen">
          </dd>
      </dl>
  </form>
<?PHP
  }
  else
  {
       $pageID = $db->quote($_POST['pageID']);
       $widgetType = $db->quote($_POST['widgetType']);
       $positions = $db->quote($_POST['positions']);

       if (YAWK\widget::create($db, $widgetType, $pageID, $positions))
       {    // success
            print \YAWK\alert::draw("success", "Erfolg", "Das Widget wurde erfolgreich erstellt.","page=widgets","2000");
       }
       else
       {
          print \YAWK\alert::draw("danger", "Fehler", "Das Widget konnte nicht erstellt werden.","page=widgets","4200");
       }
  }
?>