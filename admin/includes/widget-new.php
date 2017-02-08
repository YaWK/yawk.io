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
            <li><a href=\"index.php\" title=\"$lang[DASHBOARD]\"><i class=\"fa fa-dashboard\"></i> $lang[DASHBOARD]</a></li>
            <li><a href=\"index.php?page=widgets\" title=\"$lang[WIDGETS]\"> $lang[WIDGETS]</a></li>
            <li class=\"active\"><a href=\"index.php?page=widget-new\" title=\"".$lang['WIDGET+']."\"> ".$lang['WIDGET+']."</a></li>
         </ol>
    </section>
    <!-- Main content -->
    <section class=\"content\">";
/* page content start here */


if(!isset($_POST['widgetType'])){
?>
<div class="box box-default">
    <div class="box-body">
        <div class="box-header with-border"><h3 class="box-title"><?php echo $lang['WIDGET+']; ?></h3></div>
        <br>
  <form action="index.php?page=widgets&add=1" role="form" method="post">
      <dl class="dl-horizontal">
          <dt><label for="widgetType"><?php echo $lang['CREATE']; ?>:</label> </dt>
          <dd><select id="widgetType" name="widgetType" class="btn btn-default">
                  <?php
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
          <dt><label for="pageID"><?php echo $lang['ON_PAGE']; ?>:</label> </dt>
          <dd>
              <select id="pageID" name="pageID" class="btn btn-default">
                  <option value="0"><?php echo $lang['ON_ALL_PAGES']; ?></option>
                  <?php
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
          <dt><label for="position"><?php echo $lang['AT_POSITION']; ?></label> </dt>
          <dd>
              <select id="position" name="positions" class="btn btn-default">
                  <option value=""></option>
                  <?php
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
              <input type="submit" class="btn btn-success" value="<?php echo $lang['CREATE']; ?>">
          </dd>
      </dl>
  </form>

    </div>
</div>
<?php
  }
  else
  {

  }
?>