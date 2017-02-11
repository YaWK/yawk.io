<?php

/* page content start here */
// check if widget obj is set
if (!isset($widget))
{   // create new widget object
    $widget = new \YAWK\widget();
}
// check given widget var...
if (isset($_GET['widget']) && is_numeric($_GET['widget']))
{   // load widget properties
    $widget->loadProperties($db, $_GET['widget']);
}
else
{   // var not set or manipulated...
    \YAWK\alert::draw("danger","$lang[ERROR]", "$lang[VARS_MANIPULATED]","page=widgets","5000");
}

// USER CLICKED ON SAVE
  if(isset($_POST['save']))
  {     // escape form vars
        $widget->published = isset($_POST['publish']);
        $widget->pageID = $db->quote($_POST['pageID']);
        $widget->widgetType = $db->quote($_POST['widgetType']);
        $widget->sort = $db->quote($_POST['sort']);
        $widget->position = $db->quote($_POST['positions']);
        $widget->marginTop = $db->quote($_POST['marginTop']);
        $widget->marginBottom = $db->quote($_POST['marginBottom']);
        $widget->date_publish = $db->quote($_POST['date_publish']);
        $widget->date_unpublish = $db->quote($_POST['date_unpublish']);
        $widget->blocked = isset($_POST['mystatus']);
        // save widget state
  	    $widget->save($db);
      \YAWK\alert::draw("success", "$lang[SUCCESS]", "$lang[WIDGET] $lang[SETTINGS] $lang[SAVED]", "","1200");
  }
   	  foreach($_POST as $property=>$value)
      {
   		if($property != "save")
        {
            if (isset($_GET['widget']) && is_numeric($_GET['widget']))
            {   // save widget settings
                YAWK\settings::setWidgetSetting($db, $property, $value, $_GET['widget']);
            }
   	    }
 	  }


// TEMPLATE WRAPPER - HEADER & breadcrumbs
echo "
    <!-- Content Wrapper. Contains page content -->
    <div class=\"content-wrapper\" id=\"content-FX\">
    <!-- Content Header (Page header) -->
    <section class=\"content-header\">";
/* draw Title on top */
echo \YAWK\backend::getTitle($widget->name, $lang['WIDGET_EDIT_SUBTEXT']);
echo"<ol class=\"breadcrumb\">
            <li><a href=\"index.php\" title=\"$lang[DASHBOARD]\"><i class=\"fa fa-dashboard\"></i> $lang[DASHBOARD]</a></li>
            <li><a href=\"index.php?page=widgets\" title=\"$lang[WIDGETS]\"> $lang[WIDGETS]</a></li>
            <li class=\"active\"><a href=\"index.php?page=widget-edit&widget=$widget->id\" title=\"$lang[WIDGET_EDIT_SUBTEXT]\"> $lang[WIDGET_EDIT_SUBTEXT]</a></li>
         </ol>
    </section>
    <!-- Main content -->
    <section class=\"content\">";
?>

<!-- bootstrap date-timepicker -->
<link type="text/css" href="../system/engines/datetimepicker/css/datetimepicker.min.css" rel="stylesheet">
<script type="text/javascript" src="../system/engines/datetimepicker/js/bootstrap-datetimepicker.min.js"></script>

<script type="text/javascript" >
    $(document).ready(function() {
// load datetimepicker  (start time)
        $('#datetimepicker1').datetimepicker({
            format: 'yyyy-mm-dd hh:ii:ss'
        });
// load 2nd datetimepicker (end time)
        $('#datetimepicker2').datetimepicker({
            format: 'yyyy-mm-dd hh:ii:ss'
        });

    }); //]]>  /* END document.ready */
    /* ...end admin jQ controlls  */
</script>
<!-- FORM -->
<form name="form" role="form" action="index.php?page=widget-edit&widget=<?php echo $widget->id; ?>" method="post">

<!-- LEFT -->
<div class="col-md-6">
<!-- BASIC WIDGET SETTINGS -->
<div class="box box-default">
  <div class="box-header with-border">
    <h3 class="box-title"><?php echo $widget->name; echo $lang['WIDGET']; ?></h3>
  </div>
  <div class="box-body">
    <!-- WIDGET -->
    <label for="widgetType"><?php echo $lang['WIDGET']; ?>&nbsp;
     <select id="widgetType" name="widgetType" class="form-control">
     <option value="<?php echo $widget->widgetType; ?>"><?php echo $widget->name; ?></option>
     </select>
    </label>
    <br>
    <!-- PAGE -->
    <label for="pageID"><?php echo $lang['ON_PAGE']; ?> &nbsp;
        <select id="pageID" name="pageID" class="form-control">    
        <option value="<?php echo $widget->getWidgetId($db, $widget->id); ?>"><?php echo $widget->getWidget($db, $widget->id); ?></option>
        <option value="0"><?php echo $lang['ON_ALL_PAGES']; ?></option>
        <?php
            foreach(YAWK\sys::getPages($db) as $page)
            {
                echo "<option value=\"".$page['id']."\">".$page['title']."</option>";
            }
        ?>
      </select>
    </label>
    <br>
  <!-- POSITION -->
  <label for="positions"><?php echo $lang['AT_POSITION']; ?> &nbsp;
    <select id="positions" name="positions" class="form-control">
     <option value="<?php echo $widget->position; ?>"><?php echo $widget->position; ?></option>
     <option value="">-----</option>

    <?php /* get tpl positions */
      $i = 0;
      foreach(\YAWK\template::getTemplatePositions($db) as $position[]){
        echo "<option value=\"".$position[$i]."\">".$position[$i]."</option>";
        $i++;
      }
    ?>
   </select>
  </label>

  <br>
  <!-- DATE_PUBLISH -->
  <label for ="date_publish"><?php echo $lang['START_PUBLISH']; ?> &nbsp;
      <input id="datetimepicker1" name="date_publish" class="form-control" value="<?php echo $widget->date_publish; ?>">
  </label>
  <br>
  <!-- DATE_UNPUBLISH -->
  <label for ="date_unpublish"><?php echo $lang['END_PUBLISH']; ?> &nbsp;
    <input id="datetimepicker2" name="date_unpublish" class="form-control" value="<?php echo $widget->date_unpublish; ?>">
  </label>
  <br><br>
      <!-- MARGIN TOP -->
      <label><?php echo "$lang[MARGIN_TOP] <i><small>$lang[LEAVE_BLANK_FOR_NO_MARGIN]</small></i>"; ?> &nbsp;
          <input type="text" class="form-control" placeholder="" name="marginTop" id="marginTop" maxlength="11" value="<?php echo $widget->marginTop; ?>">
      </label><br>
      <!-- MARGIN BOTTOM -->
      <label><?php echo "$lang[MARGIN_BOTTOM] <i><small>$lang[LEAVE_BLANK_FOR_NO_MARGIN]</small></i>"; ?> &nbsp;
          <input type="text" class="form-control" name="marginBottom" placeholder="" id="marginBottom" maxlength="11" value="<?php echo $widget->marginBottom; ?>">
      </label><br><br>
  <!-- SORT -->
  <label><?php echo $lang['SORTATION']; ?> &nbsp;
  <input type="text" class="form-control" name="sort" maxlength="6" value="<?php echo $widget->sort; ?>">
  </label><br><br>

  <?php if ($widget->published == "1") { $checkedHtml="checked=\"checked\""; } else $checkedHtml = ''; ?>

  <label><?php echo "$lang[PUBLISHED]"; ?> &nbsp;<input name="publish" value="1" type="checkbox" <?php echo $checkedHtml ?>>&nbsp;
  </label>


  </div>
</div>
</div> <!-- end left col -->

<!-- RIGHT -->
  <div class="col-md-6">
    <div class="box box-default">
    <div class="box-header with-border">
    <h3 class="box-title"><?php echo "$lang[EXTENDED] $lang[WIDGET] $lang[SETTINGS]"; ?></h3>
  </div>
  <div class="box-body">
  <!-- MORE WIDGET SETTINGS -->
  <?php
    if ($res = $db->query("SELECT cws.property, cws.value, cwd.fieldClass, cwd.description, cw.widgetType as widget
    FROM {widgets} as cw
    JOIN {widget_settings} as cws ON cws.widgetID = cw.id
    JOIN {widget_defaults} as cwd ON cwd.widgetType = cws.widgetType AND cwd.property = cws.property
    WHERE cws.activated = 1 && cw.id = '".$widget->id."'"))
    {
        while($row = mysqli_fetch_assoc($res))
        {
            echo "<label for=\"".htmlentities($row['property'])."\">";
            echo $row['description'].":";
            echo "</label>";
            echo "<input type=\"text\" class=\""; echo $row['fieldClass']; echo"\" name=\"".htmlentities($row['property'])."\" value=\"".htmlentities($row['value'])."\">";
        }
    }
  ?>
  <br><input type="hidden" name="widgetID" value="<?php echo $widget->id; ?>">
  <br>
  <input name="save" id="savebutton" style="margin-top:10px;" type="submit" class="btn btn-danger" value="<?php echo $lang['WIDGETS_SAVE_BTN']; ?>">
  </div>
</div>

</div>

</form>