<?php
use YAWK\alert;
use YAWK\backend;
use YAWK\db;
use YAWK\language;
use YAWK\settings;
/** @var $db db */
/** @var $lang language */

if (isset($_GET['save']) AND $_GET['save'] === 'true') {

    foreach ($_POST as $property => $value) {
        if ($property != "save") {
            settings::setSetting($db, $property, $value, $lang);
        }
    }
}

if (isset($_GET['toggle']) AND $_GET['toggle'] === 'true')
{   /** toggle set to ON */
    if ($_GET['set'] === '1')
    {   // de-activate
        $activated = 0;
    }
    else
        {   // set to active
            $activated = 1;
        }
    if(!YAWK\settings::toggleOffline($db, $_GET['property'], $activated, $lang))
    {
        alert::draw("danger", "$lang[ERROR]", "Could not toggle page $_GET[property]", "", 2000);
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
echo backend::getTitle($lang['SETTINGS_EXPERT'], $lang['SETTINGS_EXPERT_SUBTEXT']);
echo"<ol class=\"breadcrumb\">
            <li><a href=\"index.php\" title=\"$lang[DASHBOARD]\"><i class=\"fa fa-dashboard\"></i> $lang[DASHBOARD]</a></li>
            <li><a href=\"index.php?page=settings-backend\" class=\"active\" title=\"$lang[BACKEND_SETTINGS] $lang[BACKEND_SETTINGS_SUBTEXT]\"> $lang[BACKEND_SETTINGS] $lang[BACKEND_SETTINGS_SUBTEXT]</a></li>
        </ol>
    </section>
    <!-- Main content -->
    <section class=\"content\">";
/* page content start here */
?>

<form name="settings" action="index.php?page=settings-manage&save=true" method="post">
<input type="submit" name="save" class="btn btn-success pull-right" value="<?php print $lang['SETTINGS_SAVE'];?>">

<table style="width:100%;" class="table table-striped table-hover table-responsive" id="table-sort">
  <thead>
    <tr>
      <td style="width:3%;"><strong>&nbsp;</strong></td>
      <td style="width:20%;"><strong><i class="fa fa-caret-down"></i> <?php print $lang['SETTING']; ?></strong></td>
      <td style="width:27%;"><strong><i class="fa fa-caret-down"></i> <?php print $lang['SETTING_VALUE']; ?></strong></td>
      <td style="width:25%;"><strong><?php print $lang['LABEL']; ?></strong></td>
      <td style="width:25%;"><strong><?php print $lang['DESCRIPTION']; ?></strong></td>
    </tr>
  </thead>
  <tbody>
<?php
if (isset($_GET['type']) && (is_numeric($_GET['type'])))
{
    $type = $_GET['type'];
}
  /* query database and select settings */
    if ($res = $db->query("SELECT * FROM {settings}"))
    {   // fetch loop
        while($row = mysqli_fetch_assoc($res)){
            /* check if settings is published and set badge-button text */
            if ($row['activated']==1)
            { $pub = "success"; $pubtext="$lang[ON_]"; }
            else { $pub = "danger"; $pubtext="$lang[OFF_]"; }

            echo"<tr>
 <td><a title=\"toggle&nbsp;status\" href=\"index.php?page=settings-manage&toggle=true&property=".$row['property']."&set=".$row['activated']."\">
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