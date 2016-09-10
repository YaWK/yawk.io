<?PHP
include '../system/plugins/booking/classes/booking.php';
global $lang;
$booking = new YAWK\PLUGINS\BOOKING\booking();
?>

<?php
// TEMPLATE WRAPPER - HEADER & breadcrumbs
echo "
    <!-- Content Wrapper. Contains page content -->
    <div class=\"content-wrapper\" id=\"content-FX\">
    <!-- Content Header (Page header) -->
    <section class=\"content-header\">";
/* draw Title on top */
echo \YAWK\backend::getTitle("Booking Statistik", "Zahlen &amp Fakten");
echo"<ol class=\"breadcrumb\">
            <li><a href=\"index.php\" title=\"Dashboard\"><i class=\"fa fa-dashboard\"></i> Dashboard</a></li>
            <li><a href=\"index.php?page=plugins\" title=\"Pages\"> Plugins</a></li>
            <li><a href=\"index.php?plugin=booking\" title=\"Booking\"> Booking</a></li>
            <li class=\"active\"><a href=\"index.php?plugin=booking&pluginpage=booking-stats\" title=\"Booking Stats\"> Statistics</a></li>
         </ol>
    </section>
    <!-- Main content -->
    <section class=\"content\">";
/* page content start here */
?>
<!-- backward btn -->
<a class="btn btn-default" href="index.php?plugin=booking" style="float:right;">
<i class="glyphicon glyphicon-backward"></i> &nbsp;<?php print $lang['BACK']; ?></a>
<br><br>
<?php
$booking->getStats($db);
?>
