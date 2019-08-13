<?php
// check if language is set
if (!isset($language) || (!isset($lang)))
{   // inject (add) language tags to core $lang array
    $lang = \YAWK\language::inject(@$lang, "../system/plugins/booking/language/");
}
include '../system/plugins/booking/classes/booking.php';
$booking = new \YAWK\PLUGINS\BOOKING\booking();
$field = '';
$value = '';
if (!isset($_GET['entries'])){
    $i = "LIMIT 50";
} else {
    $i = "";
}
if (isset($_GET['ip']))
{
    $field = "ip";
    $value = $_GET['ip'];
}
if (isset($_GET['email']))
{
    $field = "email";
    $value = $_GET['email'];
}
if (isset($_GET['phone']))
{
    $field = "phone";
    $value = $_GET['phone'];
}
if (isset($_GET['delete']) && ($_GET['delete'] === '1')) {
    if (isset($_GET['id']) && (!empty($_GET['id'])))
    {
        $id = $_GET['id'];
    }
    else
        {
            $id = 0;
        }
    if ($booking->delete($db, $id)) {
        print \YAWK\alert::draw("success", "$lang[SUCCESS]", "$lang[BOOKING] $lang[ID] #'".$_GET['id']."' $lang[DELETED]\"","",4200);
    }
    else
        {
            print \YAWK\alert::draw("danger", "$lang[ERROR]", "$lang[BOOKING_DEL_FAILED].","",3800);
        }
}
?>
<script type="text/javascript">
    $(document).ready(function () {
        $('#table-sort').dataTable({
            "bPaginate": false,
            "bLengthChange": false,
            "bFilter": true,
            "bSort": true,
            "bInfo": true,
            "bAutoWidth": false
        });
    });
</script>
<?php
// TEMPLATE WRAPPER - HEADER & breadcrumbs
echo "
    <!-- Content Wrapper. Contains page content -->
    <div class=\"content-wrapper\" id=\"content-FX\">
    <!-- Content Header (Page header) -->
    <section class=\"content-header\">";
/* draw Title on top */
echo \YAWK\backend::getTitle($lang['BOOKINGS'], $lang['BOOKING_SUBTEXT']);
echo"<ol class=\"breadcrumb\">
            <li><a href=\"index.php\" title=\"$lang[DASHBOARD]\"><i class=\"fa fa-dashboard\"></i> $lang[DASHBOARD]</a></li>
            <li><a href=\"index.php?page=plugins\" title=\"$lang[PLUGINS]\"> $lang[PLUGINS]</a></li>
            <li class=\"active\"><a href=\"index.php?plugin=booking\" title=\"$lang[BOOKING]\"> $lang[BOOKING]</a></li>
            <li><a href=\"index.php?plugin=booking-setup\" title=\"$lang[SETUP]\"> $lang[SETUP]</a></li>
         </ol>
    </section>
    <!-- Main content -->
    <section class=\"content\">";
/* page content start here */
?>
<div class="box box-default">
    <div class="box-body">

<!-- backward btn -->
<a class="btn btn-default" href="index.php?plugin=booking&pluginpage=booking-setup" style="float:right;">
<i class="fa fa-wrench"></i> &nbsp;<?php print $lang['SETUP']; ?></a>
<!-- backward btn -->
<a class="btn btn-default" href="index.php?page=plugins" style="float:right;">
<i class="glyphicon glyphicon-backward"></i> &nbsp;<?php print $lang['BACK']; ?></a>
<!-- backward btn -->
<a class="btn btn-default" href="index.php?plugin=booking&pluginpage=booking-stats" style="float:right;">
<i class="fa fa-bar-chart"></i> &nbsp;<?php print $lang['STATS']; ?></a>
<!-- reload btn -->
<a class="btn btn-default" href="index.php?plugin=booking&entries=all" style="float:right;">
<i class="glyphicon glyphicon-search"></i> &nbsp;<?php print $lang['SHOW_ALL']; ?></a>
<!-- reload btn -->
<a class="btn btn-default" href="index.php?plugin=booking" style="float:right;">
    <i class="glyphicon glyphicon-refresh"></i> &nbsp;<?php print $lang['REFRESH']; ?></a>
<!-- --BACKEND -- table header -->
<table width="100%" cellpadding="4" cellspacing="0" border="0" class="table table-hover" id="table-sort">
    <thead>
    <tr>
        <td width="8%" style="text-align: center;"><strong><?php echo $lang['FIXATED']; ?></strong></td>
        <td width="14%"><strong><?php print $lang['DATE_CREATED']; ?></strong></td>
        <td width="10%"><strong><?php print $lang['NAME']; ?></strong></td>
        <td width="5%" class=\"text-center\"><strong><?php print $lang['BOOKING_DATEWISH']; ?></strong></td>
        <td width="39%"><strong><?php print $lang['MESSAGE']; ?></strong></td>
        <td width="5%" class=\"text-center\"><strong><?php print $lang['BOOKING_VISITS']; ?></strong></td>
        <td width="5%" class=\"text-center\"><strong><?php print $lang['IP']; ?></strong></td>
        <td width="14%" class=\"text-center\"><strong><?php print $lang['ACTIONS']; ?></strong></td>
    </tr>
    </thead>
    <tbody>
    <?php print $booking->getBackendTable($db, $i, $field, $value); ?>
    </tbody>
</table>

    </div>
</div>