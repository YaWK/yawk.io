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

<?php
// include stats class
    require_once '../system/classes/stats.php';
// check if stats object is set...
    if (!isset($stats))
    {   // if not, create new
        $stats = new \YAWK\stats();
    }
// load stats data into an array that every box will use, this saves performance
    $data = $stats->getStatsArray($db);

if (isset($_POST['limit']) && (!empty($_POST['limit'])))
{
    $limit = strip_tags($_POST['limit']);
}
else
    {
        $limit = $stats->i_hits;
    }
?>
<div class="row">
    <div class="col-md-4">
        <!-- box -->
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Statistics <small>hits and user behavior</small></h3>
            </div>
            <div class="box-body h3">
                <?php
                if ($stats->i_hits !== $limit) { $current = "<small><i>(view: $limit)</i></small>"; } else { $current = ''; }
                $stats->i_hits = number_format($stats->i_hits, 0, '.', '.');
                ?>
                Hits overall: <b><?php echo $stats->i_hits; ?></b> <?php echo $current; ?> <br>
                Guests: <b><?php echo $stats->i_publicUsersPercentage; ?>% </b> <small>(<?php echo $stats->i_publicUsers; ?>)</small><br>
                Members: <b><?php echo $stats->i_loggedUsersPercentage; ?>%</b> <small>(<?php echo $stats->i_loggedUsers; ?>)</small><br>
            </div>
        </div>
        <!-- / box -->
    </div>
    <div class="col-md-4"><?php $stats->drawWeekdayBox($db, $data, $limit); ?></div>
    <div class="col-md-4">

        <!-- stats settings box -->
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Settings <small>filter your view</small></h3>
            </div>
            <div class="box-body">
                <form action="index.php?page=stats" method="post">
                    <label for="limit">view latest <small><i>n</i></small> hits, leave blank for all</label>
                    <input id="limit" name="limit" value="<?php echo $limit; ?>" type="text" placeholder="<?php echo $limit; ?>" class="form-control">
                    <br>
                    <button type="submit" class="btn btn-success pull-right"><i class="glyphicon glyphicon-refresh"></i>&nbsp; Refresh Stats</button>
                </form>
            </div>
        </div>
        <!-- / stats settings box -->

    </div>
</div>

<div class="row">
    <div class="col-md-8">

        <!-- DEVICE TYPE box -->
        <?php $stats->drawDeviceTypeBox($db, $data, $limit); ?>
        <!-- / box -->

        <!-- OS box -->
        <div class="row">
        <div class="col-md-6"><?php $stats->drawOsBox($db, $data, $limit); ?></div>
        <div class="col-md-6"><?php $stats->drawOsVersionBox($db, $data, $limit); ?></div>
        </div>

        <!-- / box -->

        <!-- box -->
        <?php $stats->drawBrowserBox($db, $data, $limit); ?>

        <!-- box -->
        <div class="box">
            <div class="box-header with-border">
                Languages
            </div>
            <div class="box-body">
                all users languages
            </div>
        </div>
        <!-- / box -->

    </div>
    <div class="col-md-4">

        <!-- box -->
        <?php $stats->drawDaytimeBox($db, $data, $limit); ?>
        <!-- / box -->

        <!-- box -->
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Pages <small>hits from most to least</small></h3>
            </div>
                <?php
                    $erg = array();
                    $data = array_slice($data, 0, $limit, true);
                    foreach ($data AS $page => $value)
                    {
                        $erg[] = $value['page'];
                    }

                    $erg = (array_count_values($erg));
                    arsort($erg);
                echo "<div class=\"box-footer no-padding\">
                <ul class=\"nav nav-pills nav-stacked\">";

                // walk through array and display pages as nav pills
            foreach ($erg as $page => $value)
            {   // show only items where browser got a value
                if ($value !== 0 && $page !== 0)
                {   // get different textcolors
                    echo "<li><a href=\"../$page\" target=\"_blank\"><b>$value</b> &nbsp;<span class=\"text-blue\">$page</span></a></li>";
                }
            }

            echo "</ul>";
              ?>
                <!-- /.footer -->
            </div>
        </div>
        <!-- / box -->

    <!-- login box -->
    <?php
     $stats->drawLoginBox($db, $limit);
    ?>
    <!-- / login box -->

    </div>
</div>
