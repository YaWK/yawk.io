<?php

use YAWK\BACKEND\dashboard;
use YAWK\db;
use YAWK\language;
use YAWK\page;
use YAWK\settings;
use YAWK\stats;
use YAWK\tipOfDay;
use YAWK\user;

if (!isset($lang))
{   // create language object
    $lang = new language();
}

echo "<!-- Optionally, you can add Slimscroll and FastClick plugins.
Both of these plugins are recommended to enhance the
             user experience. Slimscroll is required when using the
             fixed layout. -->";
            echo "
    <!-- Ionicons -->
    <link rel=\"stylesheet\" href=\"https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css\">
        <!-- SlimScroll 1.3.0 -->
        <script src=\"../system/engines/AdminLTE/plugins/slimScroll/jquery.slimscroll.min.js\"></script>
        <!-- ChartJS 1.0.1 -->
        <script src=\"../system/engines/AdminLTE/plugins/chartjs/Chart.min.js\"></script>";

// check if stats object is here...
if (!isset($stats) || (empty($stats)))
{
    /* @var $db db */
    // include stats class
    @require_once '../system/classes/stats.php';
    // and create new stats object
    $stats = new stats();
    $defaultInterval = 10;
    $defaultPeriod = "MINUTE";
    $data = $stats->getStatsArray($db, $defaultInterval, $defaultPeriod);
    $limit = $stats->i_hits;
}
else
    {
        $data = '';
    }

// check if tip of day is enabled
if (settings::getSetting($db, "backendTipOfDay") == true)
{   // include tip of day class
    @require_once '../system/classes/tipOfDay.php';
    // create new tip of day object
    $tipOfDay = new tipOfDay();
    $tipOfDay->drawTip($db, $lang);
}
?>

<!-- Info boxes -->
<div class="row">
    <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box">
            <!-- facebook icon <span class="info-box-icon bg-blue"><i class="fa fa-facebook-official"></i></span> -->
            <span class="info-box-icon bg-blue"><i class="fa fa-line-chart"></i></span>

            <div class="info-box-content">
                <span class="info-box-text"><?php echo "$lang[IN_LAST24H]"; ?></span>
                <span class="info-box-number"><?php echo number_format($stats->i_hits, 0, '.', '.'); ?> <small> <?php echo $lang['HITS']; ?></small></span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
    <!-- /.col -->
    <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box">
            <!-- twitter icon <span class="info-box-icon bg-aqua"><i class="ion-social-twitter-outline"></i></span> -->
            <span class="info-box-icon bg-aqua"><i class="fa fa-mobile-phone"></i></span>

            <div class="info-box-content">
                <span class="info-box-text"><?php echo $lang['DEVICES']; ?></span>
                <span class="info-box-number"><?php $stats->countDeviceTypes($db, $data); echo round($stats->i_desktopPercent, 1); ?>% <small> Desktop</small></span>
                <span class="info-box-number"><?php echo round($stats->i_phonePercent, 1); ?>% <small> Phone</small> / <?php echo round($stats->i_tabletPercent, 1); ?>% <small> Tablet</small></span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
    <!-- /.col -->

    <!-- fix for small devices only -->
    <div class="clearfix visible-sm-block"></div>

    <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box">
            <span class="info-box-icon bg-green"><i class="ion-ios-paper-outline"></i></span>

            <div class="info-box-content">
                <span class="info-box-text"><?php echo $lang['PAGES']; ?></span>
                <span class="info-box-number"><?php echo page::countPages($db); ?></span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
    <!-- /.col -->
    <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box">
            <span class="info-box-icon bg-yellow"><i class="ion ion-ios-people-outline"></i></span>

            <div class="info-box-content">
                <span class="info-box-text"><?php echo $lang['USERS']; ?></span>
                <span class="info-box-number"><?php echo user::countUsers($db); ?></span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
    <!-- /.col -->
</div>
<!-- /.row -->



<!-- Main row -->
<div class="row">
    <!-- Left col -->
    <div class="col-md-8">
        <div class="row">
            <div class="col-md-12">
                <!-- DIRECT CHAT -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div>
    <!-- /.col -->

    <div class="col-md-4">
        <!-- weekday stats -->
        <?php $stats->drawWeekdayBox($db, $data, $lang, 0); ?>
        <!-- latest users -->
        <?php dashboard::drawLatestUsers($db, 8, $lang); ?>
        <!-- daytime stats -->
        <?php $stats->drawDaytimeBox($db, $data, $lang); ?>
        <!-- latest pages stats-->
        <?php dashboard::drawLatestPagesBox($db, 5, $lang); ?>
    </div>
    <!-- /.col -->
</div>
<!-- /.row -->
