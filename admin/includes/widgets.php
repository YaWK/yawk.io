 <?php

 use YAWK\alert;
 use YAWK\backend;
 use YAWK\db;
 use YAWK\language;
 use YAWK\sys;
 use YAWK\widget;

 /** @var $db db */
 /** @var $lang language */

// ADD WIDGET
if (isset($_GET['add']) && ($_GET['add'] === "1"))
{   // prepare vars
    $pageID = $db->quote($_POST['pageID']);
    $widgetType = $db->quote($_POST['widgetType']);
    $positions = $db->quote($_POST['positions']);
    $date_publish = sys::now();

    $newWidgetID = widget::create($db, $widgetType, $pageID, $positions);
    if (is_int($newWidgetID) || (is_numeric($newWidgetID)))
    {    // success
        print alert::draw("success", "$lang[SUCCESS]", "$lang[WIDGET_CREATE_OK]", "page=widget-edit&widget=$newWidgetID", 800);
    }
    else
    {   // throw error
        print alert::draw("danger", "$lang[ERROR]", "$lang[WIDGET_CREATE_FAILED]<br>Widget ID: $newWidgetID", "", 5800);
    }
}

 if (!isset($widget))
 {   // create new widget obj
     $widget = new YAWK\widget();
 }
// COPY WIDGET
if(isset($_GET['copy']) && ($_GET['copy'] === "true")) {
     if ($widget->copy($db, $_GET['widget']))
     {   // widget copied
         print alert::draw("success", "$lang[SUCCESS]", "$lang[WIDGET] $lang[ID]: ".$_GET['widget']." $lang[COPIED]","page=widgets","1800");
     }
     else
     {   // throw error
         print alert::draw("danger", "$lang[ERROR]", "$lang[WIDGET] ".$_GET['widget']." $lang[ID] <b>$lang[NOT] $lang[COPIED]</b>","page=widgets","4800");
     }
 }

// DELETE WIDGET
if (isset($_GET['del']) && ($_GET['del'] === "1"))
{
  if (isset($_GET['widget']) && (isset($_GET['delete']) && ($_GET['delete'] == "true")))
  {   // delete widget
    if($widget->delete($db, $_GET['widget']))
    {   // delete successful
      YAWK\alert::draw("success", "$lang[SUCCESS]", "$lang[WIDGET] $lang[ID]: ".$_GET['widget']." $lang[DELETED]","","800");
    }
    else
    {   // q failed, throw error
      alert::draw("danger", "$lang[ERROR]", "$lang[WIDGET_DEL_FAILED] $lang[WIDGET] $lang[ID]: ".$_GET['widget']."","","5800");
    }
  }
}
?>
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
<?php
// TEMPLATE WRAPPER - HEADER & breadcrumbs
echo "
    <!-- Content Wrapper. Contains page content -->
    <div class=\"content-wrapper\" id=\"content-FX\">
    <!-- Content Header (Page header) -->
    <section class=\"content-header\">";
/* draw Title on top */
echo backend::getTitle($lang['WIDGETS'], $lang['WIDGETS_SUBTEXT']);
echo"<ol class=\"breadcrumb\">
            <li><a href=\"index.php\" title=\"$lang[DASHBOARD]\"><i class=\"fa fa-dashboard\"></i> $lang[DASHBOARD]</a></li>
            <li class=\"active\"><a href=\"index.php?page=widgets\" title=\"$lang[WIDGETS]\"> $lang[WIDGETS]</a></li>
         </ol>
    </section>
    <!-- Main content -->
    <section class=\"content\">";
/* page content start here */
?>

<div class="box box-default">
    <div class="box-body">
<a class="btn btn-success pull-right" title="<?php echo $lang['WIDGET+']; ?>" href="index.php?page=widget-new">
<i class="glyphicon glyphicon-plus"></i> &nbsp;<?php print $lang['WIDGET']; ?></a>
<a class="btn btn-success pull-right" title="<?php echo $lang['WIDGET_MANAGER']; ?>" href="index.php?page=widgets-manage">
<i class="glyphicon glyphicon-folder-open"></i> &nbsp;&nbsp;<?php print $lang['WIDGET_MANAGER']; ?></a>

<table style="width: 100%;" class="table table-striped table-hover table-responsive" id="table-sort">
  <thead>
    <tr>
      <td style="width: 3%;"><strong>&nbsp;</strong></td>
      <td style="width: 5%;" class="text-center"><strong><?php echo "$lang[ID]"; ?></strong></td>
      <td style="width: 25%;"><strong><?php echo "$lang[WIDGET]"; ?></strong></td>
      <td style="width: 30%;"><strong><?php echo "$lang[PAGE]"; ?></strong></td>
      <td style="width: 7%;" class="text-center"><strong><?php echo "$lang[SORTATION]"; ?></strong></td>
      <td style="width: 20%;" class="text-center"><strong><?php echo "$lang[POSITION]"; ?></strong></td>
      <td style="width: 10%;" class="text-center"><strong><?php echo "$lang[ACTIONS]"; ?></strong></td>
    </tr>
  </thead>
  <tbody>
  <?php
  if ($res = $db->query("SELECT cw.*, cwt.name, CASE WHEN cp.title IS NULL THEN '$lang[ON_ALL_PAGES]'
                              ELSE cp.title END as title
      						  FROM {widgets} as cw
      						  JOIN {widget_types} as cwt on cw.widgetType = cwt.id
      						  LEFT JOIN {pages} as cp on cw.pageID = cp.id
      						  ORDER BY cw.pageID,cw.sort"))
  {
      while($row = mysqli_fetch_assoc($res)){
          if ($row['published']==1)
          {
              $pub = "success"; $pubtext="$lang[ONLINE]";
          } else {
              $pub = "danger"; $pubtext="$lang[OFFLINE]";}
          echo "<tr>
                <td class=\"text-center\">
                <a href=\"index.php?page=widget-toggle&widget=".$row['id']."&published=".$row['published']."\">
                <span class=\"label label-$pub\">$pubtext</span></a></td>
                <td class=\"text-center\">".$row['id']."</td>
                <td><a href=\"index.php?page=widget-edit&widget=".$row['id']."\"><div style=\"width:100%\">".$row['name']."</div></a>
                <small>".$row['widgetTitle']."</small></td>
                <td><a href=\"index.php?page=widget-edit&widget=".$row['id']."\" style=\"color: #7A7376;\"><div style=\"width:100%\">".$row['title']."</div></a></td>

                <td class=\"text-center\">".$row['sort']."</td>
                <td class=\"text-center\">".$row['position']."</td>
                <td class=\"text-center\">

                <a class=\"fa fa-copy\" title=\"".$lang['WIDGET_COPY']."\" href=\"index.php?page=widgets&copy=true&widget=".$row['id']."\"></a>&nbsp;
                <a class=\"fa fa-edit\" title=\"EDIT: ".$row['name']."\" href=\"index.php?page=widget-edit&widget=".$row['id']."\"></a>&nbsp;
                <a class=\"fa fa-trash-o\" role=\"dialog\" data-confirm=\"".$lang['WIDGET']." &laquo; # $row[id] &raquo; ".$lang['DELETE']."?\"
                   title=\"$lang[DELETE]\" href=\"index.php?page=widgets&del=1&widget=$row[id]&delete=true\">
                </a>
                </td>
              </tr>";
      }
  }
    ?>
  </tbody>
</table>
    </div>
</div>