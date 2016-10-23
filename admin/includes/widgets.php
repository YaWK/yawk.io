<?php
// ADD WIDGET
if (isset($_GET['add']) && ($_GET['add'] === "1"))
{   // prepare vars
    $pageID = $db->quote($_POST['pageID']);
    $widgetType = $db->quote($_POST['widgetType']);
    $positions = $db->quote($_POST['positions']);

    if (YAWK\widget::create($db, $widgetType, $pageID, $positions))
    {    // success
        print \YAWK\alert::draw("success", "Erfolg", "Das Widget wurde erfolgreich erstellt.", "", 800);
    }
    else
    {   // throw error
        print \YAWK\alert::draw("danger", "Fehler", "Das Widget konnte nicht erstellt werden.", "", 5800);
    }
}

// DELETE WIDGET
if (isset($_GET['del']) && ($_GET['del'] === "1"))
{
  if (!isset($widget))
  {   // create new widget obj
      $widget = new YAWK\widget();
  }
  if (isset($_GET['widget']) && (isset($_GET['delete']) && ($_GET['delete'] == "true")))
  {   // delete widget
    if($widget->delete($db, $_GET['widget']))
    {   // delete successful
      YAWK\alert::draw("success", "Erfolg", "Das Widget ".$_GET['widget']." wurde gel&ouml;scht!","","800");
    }
    else
    {   // q failed, throw error
      \YAWK\alert::draw("danger", "Error!", "Could not delete widget ".$_GET['widget']."!","","5800");
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
echo \YAWK\backend::getTitle($lang['WIDGETS'], $lang['WIDGETS_SUBTEXT']);
echo"<ol class=\"breadcrumb\">
            <li><a href=\"index.php\" title=\"Dashboard\"><i class=\"fa fa-dashboard\"></i> Dashboard</a></li>
            <li class=\"active\"><a href=\"index.php?page=widgets\" title=\"Widgets\"> Widgets</a></li>
         </ol>
    </section>
    <!-- Main content -->
    <section class=\"content\">";
/* page content start here */
?>

<div class="box box-default">
    <div class="box-body">
<a class="btn btn-success pull-right" title="<?php $lang['WIDGET+']; ?>" href="index.php?page=widget-new">
<i class="glyphicon glyphicon-plus"></i> &nbsp;<?php print $lang['WIDGET']; ?></a>

<table width="100%" cellpadding="4" cellspacing="0" border="0" class="table table-hover" id="table-sort">
  <thead>
    <tr>
      <td width="3%"><strong>&nbsp;</strong></td>
      <td width="5%" class="text-center"><strong>ID</strong></td>
      <td width="25%"><strong>Widget</strong></td>
      <td width="30%"><strong>on page</strong></td>
      <td width="7%" class="text-center"><strong>Sort</strong></td>
      <td width="20%" class="text-center"><strong>Position</strong></td>
      <td width="10%" class="text-center"><strong>Aktionen</strong></td>
    </tr>
  </thead>
  <tbody>
  <?PHP
  if ($res = $db->query("SELECT cw.*, cwt.name, CASE WHEN cp.title IS NULL THEN '-- all pages --'
                                                              ELSE cp.title END as title
      						  FROM {widgets} as cw
      						  JOIN {widget_types} as cwt on cw.widgetType = cwt.id
      						  LEFT JOIN {pages} as cp on cw.pageID = cp.id
      						  ORDER BY cw.pageID,cw.sort LIMIT 0,30"))
  {
      while($row = mysqli_fetch_assoc($res)){
          if ($row['published']==1)
          {
              $pub = "success"; $pubtext="On";
          } else {
              $pub = "danger"; $pubtext="Off";}
          echo "<tr>
                <td class=\"text-center\">
                <a href=\"index.php?page=widget-toggle&widget=".$row['id']."&published=".$row['published']."\">
                <span class=\"label label-$pub\">$pubtext</span></a></td>
                <td class=\"text-center\">".$row['id']."</td>
                <td><a href=\"index.php?page=widget-edit&widget=".$row['id']."\"><div style=\"width:100%\">".$row['name']."</div></a></td>
                <td><a href=\"index.php?page=widget-edit&widget=".$row['id']."\" style=\"color: #7A7376;\"><div style=\"width:100%\">".$row['title']."</div></a></td>

                <td class=\"text-center\">".$row['sort']."</td>
                <td class=\"text-center\">".$row['position']."</td>
                <td class=\"text-center\">

                <a class=\"fa fa-copy\" title=\"".$lang['WIDGET_COPY']."\" href=\"index.php?page=widget-copy&copy=true&widget=".$row['id']."\"></a>&nbsp;
                <a class=\"fa fa-edit\" title=\"EDIT: ".$row['name']."\" href=\"index.php?page=widget-edit&widget=".$row['id']."\"></a>&nbsp;
                <a class=\"fa fa-trash-o\" role=\"dialog\" data-confirm=\"Das Widget &laquo; # $row[id] &raquo; wirklich l&ouml;schen?\"
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