<?PHP
if (isset($_GET['save']) AND $_GET['save'] === 'true') {

    foreach ($_POST as $property => $value) {
        if ($property != "save") {
            \YAWK\settings::setSetting($db, $property, $value);
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
echo \YAWK\backend::getTitle($lang['SETTINGS_EXPERT'], $lang['SETTINGS_EXPERT_SUBTEXT']);
echo"<ol class=\"breadcrumb\">
            <li><a href=\"index.php\" title=\"Dashboard\"><i class=\"fa fa-dashboard\"></i> Dashboard</a></li>
            <li><a href=\"index.php?page=settings-backend\" class=\"active\" title=\"Backend Settings\"> Backend Settings</a></li>
        </ol>
    </section>
    <!-- Main content -->
    <section class=\"content\">";
/* page content start here */
?>

<form name="settings" action="index.php?page=settings-manage&save=true" method="post">
<input type="submit" name="save" class="btn btn-success pull-right" value="<?php print $lang['SETTINGS_SAVE'];?>">

<table width="100%" cellpadding="4" cellspacing="0" border="0" class="table table-hover" id="table-sort">
  <thead>
    <tr>
      <td width="3%"><strong>&nbsp;</strong></td>
      <td width="20%"><strong><i class="fa fa-caret-down"></i> <?PHP print $lang['SETTING']; ?></strong></td>
      <td width="27%"><strong><i class="fa fa-caret-down"></i> <?PHP print $lang['SETTING_VALUE']; ?></strong></td>
      <td width="25%"><strong><?PHP print $lang['LABEL']; ?></strong></td>
      <td width="25%"><strong><?PHP print $lang['DESCRIPTION']; ?></strong></td>
    </tr>
  </thead>
  <tbody>
<?php
if (isset($_GET['type']) && (is_numeric($_GET['type'])))
{
    $type = $_GET['type'];
}
else
{

}
  /* query database and select settings */
    if ($res = $db->query("SELECT * FROM {settings}"))
    {   // fetch loop
        while($row = mysqli_fetch_assoc($res)){
            /* check if settings is published and set badge-button text */
            if ($row['activated']==1)
            { $pub = "success"; $pubtext="On"; }
            else { $pub = "danger"; $pubtext="Off"; }

            echo"<tr>
 <td><a title=\"toggle&nbsp;status\" href=\"index.php?page=settings-toggle&property=".$row['property']."&set=".$row['activated']."\">
     <span class=\"label label-$pub\">$pubtext</span></a></td>
 <td>".$row['property']."</td>
 <td><input type=\"text\" name=\"".$row['property']."\" class=\"form-control\" value=\"".$row['value']."\"></td>
 <td>".$row['label']."</td>
 <td>".$row['description']."</td>
</tr>";
        }
    }
?>

  </tbody>
</table>
</form>
<br><br>