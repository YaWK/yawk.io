<?php
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
            <li><a href=\"index.php\" title=\"Dashboard\"><i class=\"fa fa-dashboard\"></i> Dashboard</a></li>
            <li><a href=\"index.php?page=plugins\" title=\"Pages\"> Plugins</a></li>
            <li class=\"active\"><a href=\"index.php?plugin=booking\" title=\"Booking\"> Booking</a></li>
         </ol>
    </section>
    <!-- Main content -->
    <section class=\"content\">";
/* page content start here */
?>
<div class="box box-default">
    <div class="box-body">

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
        <td width="3%" style="text-align: center;"><strong>Fix?</strong></td>
        <td width="14%"><strong><?PHP print $lang['DATE_CREATED']; ?></strong></td>
        <td width="10%"><strong><?PHP print $lang['NAME']; ?></strong></td>
        <td width="5%" class=\"text-center\"><strong><?PHP print $lang['BOOKING_DATEWISH']; ?></strong></td>
        <td width="5%" class=\"text-center\"><strong><?PHP print $lang['BOOKING_TODO']; ?></strong></td>
        <td width="39%"><strong><?PHP print $lang['MESSAGE']; ?></strong></td>
        <td width="5%" class=\"text-center\"><strong><?PHP print $lang['BOOKING_VISITS']; ?></strong></td>
        <td width="5%" class=\"text-center\"><strong><?PHP print $lang['IP']; ?></strong></td>
        <td width="14%" class=\"text-center\"><strong><?PHP print $lang['ACTIONS']; ?></strong></td>
    </tr>
    </thead>
    <tbody>
    <?PHP print $booking->getBackendTable($db, $i, $field, $value); ?>
    </tbody>
</table>

    </div>
</div>