<?php require_once '../system/classes/stats.php';
$stats = new \YAWK\stats();
?>
<!-- JS includes -->
<!-- jvectormap -->
<link rel="stylesheet" href="../system/engines/AdminLTE/plugins/jvectormap/jquery-jvectormap-1.2.2.css">
<!-- jvectormap -->
<script src="../system/engines/AdminLTE/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="../system/engines/AdminLTE/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
<!-- SlimScroll 1.3.0 -->
<script src="../system/engines/AdminLTE/plugins/slimScroll/jquery.slimscroll.min.js"></script>
<!-- ChartJS 1.0.1 -->
<script src="../system/engines/AdminLTE/plugins/chartjs/Chart.min.js"></script>
<?php
// TEMPLATE WRAPPER - HEADER & breadcrumbs
echo "
    <!-- Content Wrapper. Contains page content -->
    <div class=\"content-wrapper\" id=\"content-FX\">
    <!-- Content Header (Page header) -->
    <section class=\"content-header\">";
/* draw Title on top */
echo \YAWK\backend::getTitle($lang['STATS'], $lang['STATS_SUBTEXT']);
echo"<ol class=\"breadcrumb\">
            <li><a href=\"index.php\" title=\"Dashboard\"><i class=\"fa fa-dashboard\"></i> Dashboard</a></li>
            <li class=\"active\"><a href=\"index.php?page=yawk-stats\" title=\"Pages\"> Statistics</a></li>
         </ol>
    </section>
    <!-- Main content -->
    <section class=\"content\">";
/* page content start here */
?>

<div class="row">
    <div class="col-md-8"><?php $stats->calculateStats($db); ?></div>
    <div class="col-md-4">...</div>
</div>

<div class="row">
    <div class="col-md-4">spalte 1</div>
    <div class="col-md-4">spalte 2</div>
    <div class="col-md-4">spalte 3</div>
</div>

