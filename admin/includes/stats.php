<!-- JS includes -->
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
            <li><a href=\"index.php\" title=\"$lang[DASHBOARD]\"><i class=\"fa fa-dashboard\"></i> $lang[DASHBOARD]</a></li>
            <li class=\"active\"><a href=\"index.php?page=yawk-stats\" title=\"$lang[STATS]\"> $lang[STATS]</a></li>
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
    $data = $stats->getStatsArray($db, '', '');

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
                <h3 class="box-title"><?php echo $lang['STATS']; ?> <small><?php echo $lang['HITS_AND_USER_BEHAVIOR']; ?></small></h3>
            </div>
            <div class="box-body">
                <?php
                if ($stats->i_hits !== $limit) { $current = "<small><i>(view: $limit)</i></small>"; } else { $current = ''; }
                $stats->i_hits = number_format($stats->i_hits, 0, '.', '.');
                ?>
                <?php echo "$lang[ACTIVE_SESSIONS]: <b>".$stats->getActiveSessions()."</b> "; ?> <br>
                <?php echo "$lang[HITS] $lang[OVERALL]:<b> $stats->i_hits</b>"; ?> <?php echo $current; ?> <br>
                <?php echo "$lang[GUESTS]: <b> $stats->i_publicUsersPercentage</b>"; ?>% <small>(<?php echo $stats->i_publicUsers; ?>)</small><br>
                <?php echo "$lang[MEMBERS]: <b> $stats->i_loggedUsersPercentage</b>"; ?>% <small>(<?php echo $stats->i_loggedUsers; ?>)</small><br>

            </div>
        </div>
        <!-- / box -->
    </div>
    <div class="col-md-4"><?php $stats->drawWeekdayBox($db, $data, $limit, $lang); ?></div>
    <div class="col-md-4">

        <!-- stats settings box -->
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title"><?php echo "$lang[SETTINGS] <small>$lang[FILTER_YOUR_VIEW]</small>"; ?></h3>
            </div>
            <div class="box-body">
                <form action="index.php?page=stats" method="post">
                    <label for="limit"><?php echo "$lang[VIEW_LATEST] <small><i>n</i></small> $lang[HITS], $lang[LEAVE_BLANK_FOR_ALL]"; ?></label>
                    <input id="limit" name="limit" value="<?php echo $limit; ?>" type="text" placeholder="<?php echo $limit; ?>" class="form-control">
                    <br>
                    <button type="submit" class="btn btn-success pull-right"><i class="glyphicon glyphicon-refresh"></i>&nbsp; <?php echo "$lang[REFRESH_STATS]"; ?></button>
                </form>
            </div>
        </div>
        <!-- / stats settings box -->

        <!-- user settings box -->
        <?php $stats->drawUserStats($db, $lang); ?>
        <!-- / user settings box -->
        
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <!-- device type box -->
        <?php
        $daysOfMonth = date("t",mktime(0, 0, 0, 9, 1, 2017));
        $daysOfMonth++; // Zähler bei 1
        for($i = 1; $i < $daysOfMonth; $i++){
        echo $i."\n";
        }
        ?>

        <?php
        $currentMonth = date("m");
        $lastMonth  = date("m")-1;
        echo "<hr>";
        echo $lastMonth."<br>";
        $date = new DateTime("2017-$currentMonth-01");
        $dates = array();

        foreach ( range(1, $date->format("t")) as $day ) {
            $dates[] = $date->format("d.m.Y");
            $date->modify("+1 day");
        }

        echo join('<br />', $dates);
        ?>
        <?php $stats->drawDeviceTypeBox($db, $data, $limit, $lang); ?>
        <!-- /device type box -->

        <!-- OS box -->
        <div class="row">
        <div class="col-md-6"><?php $stats->drawOsBox($db, $data, $limit, $lang); ?></div>
        <div class="col-md-6"><?php $stats->drawOsVersionBox($db, $data, $limit, $lang); ?></div>
        </div>
        <!-- /OS box -->

        <!-- browser box -->
        <?php $stats->drawBrowserBox($db, $data, $limit, $lang); ?>
        <!-- /browser box -->

    </div>
    <div class="col-md-4">

        <!-- box -->
        <?php $stats->drawDaytimeBox($db, $data, $limit, $lang); ?>
        <!-- / box -->

        <!-- box -->
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title"><?php echo "$lang[PAGE_VIEWS] <small> $lang[HITS_FROM_MOST_TO_LEAST]</small>"; ?></h3>
            </div>
                <?php
                    $erg = array();
                    if (is_array($data))
                    {
                        $data = array_slice($data, 0, $limit, true);
                        foreach ($data AS $page => $value)
                        {
                            $erg[] = $value['page'];
                        }
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
     $stats->drawLoginBox($db, $limit, $lang);
    ?>
    <!-- / login box -->

    </div>
