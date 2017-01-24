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
    \YAWK\alert::draw("danger","Error!", "Doh! You shall not manipulate vars, yoda says...","page=widgets","5000");
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
        $widget->blocked = isset($_POST['mystatus']);
        // save widget state
  	    $widget->save($db);
      \YAWK\alert::draw("success", "Success!", "Widget Settings saved.", "","1200");
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
            <li><a href=\"index.php\" title=\"Dashboard\"><i class=\"fa fa-dashboard\"></i> Dashboard</a></li>
            <li><a href=\"index.php?page=widgets\" title=\"Widgets\"> Widgets</a></li>
            <li class=\"active\"><a href=\"index.php?page=widget-edit&widget=$widget->id\" title=\"Edit Widget\"> Edit Widget</a></li>
         </ol>
    </section>
    <!-- Main content -->
    <section class=\"content\">";
?>
<!-- FORM -->
<form name="form" role="form" action="index.php?page=widget-edit&widget=<?PHP echo $widget->id; ?>" method="post">

<!-- LEFT -->
<div class="col-md-6">
<!-- BASIC WIDGET SETTINGS -->
<div class="box box-default">
  <div class="box-header with-border">
    <h3 class="box-title"><?PHP echo $widget->name; ?> Widget</h3>
  </div>
  <div class="box-body">
    <!-- WIDGET -->
    <label for="widgetType">Widget:&nbsp;
     <select id="widgetType" name="widgetType" class="form-control">
     <option value="<?PHP echo $widget->widgetType; ?>"><?PHP echo $widget->name; ?></option>
     </select>
    </label>
    <br>
    <!-- PAGE -->
    <label for="pageID">on Page: &nbsp;
        <select id="pageID" name="pageID" class="form-control">    
        <option value="<?PHP echo $widget->getWidgetId($db, $widget->id); ?>"><?PHP echo $widget->getWidget($db, $widget->id); ?></option>
        <option value="0">--all pages--</option>
        <?PHP
            foreach(YAWK\sys::getPages($db) as $page)
            {
                echo "<option value=\"".$page['id']."\">".$page['title']."</option>";
            }
        ?>
      </select>
    </label>
    <br>
  <!-- POSITION -->
  <label for="positions">at Position: &nbsp;
    <select id="positions" name="positions" class="form-control">
     <option value="<?PHP echo $widget->position; ?>"><?PHP echo $widget->position; ?></option>
     <option value="">---</option>

    <?PHP /* get tpl positions */
      $i = 0;
      foreach(\YAWK\template::getTemplatePositions($db) as $position[]){
        echo "<option value=\"".$position[$i]."\">".$position[$i]."</option>";
        $i++;
      }
    ?>
   </select>
  </label>
  <br><br>
      <!-- MARGIN TOP -->
      <label>Margin from top in px <i><small>(leave blank for no margin)</small></i> &nbsp;
          <input type="text" class="form-control" placeholder="" name="marginTop" id="marginTop" maxlength="11" value="<?PHP echo $widget->marginTop; ?>">
      </label><br>
      <!-- MARGIN BOTTOM -->
      <label>Margin from bottom in px <i><small>(leave blank for no margin)</small></i>  &nbsp;
          <input type="text" class="form-control" name="marginBottom" placeholder="" id="marginBottom" maxlength="11" value="<?PHP echo $widget->marginBottom; ?>">
      </label><br><br>
  <!-- SORT -->
  <label>Sort: &nbsp;
  <input type="text" class="form-control" name="sort" maxlength="6" value="<?PHP echo $widget->sort; ?>">
  </label><br><br>

  <?PHP if ($widget->published == "1") { $checkedHtml="checked=\"checked\""; } else $checkedHtml = ''; ?>

  <label>Publish? &nbsp;<input name="publish" value="1" type="checkbox" <?PHP echo $checkedHtml ?>>&nbsp;
  </label>


  </div>
</div>
</div> <!-- end left col -->

<!-- RIGHT -->
  <div class="col-md-6">
    <div class="box box-default">
    <div class="box-header with-border">
    <h3 class="box-title">Extended Widget Settings</h3>
  </div>
  <div class="box-body">
  <!-- MORE WIDGET SETTINGS -->
  <?PHP
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
  <br><input type="hidden" name="widgetID" value="<?PHP echo $widget->id; ?>">
  <br>
  <input name="save" id="savebutton" style="margin-top:10px;" type="submit" class="btn btn-danger" value="Widget&nbsp;Settings&nbsp;speichern">
  </div>
</div>

</div>

</form>