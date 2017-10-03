<!-- JS includes -->
<!-- SlimScroll 1.3.0 -->
<script src="../system/engines/AdminLTE/plugins/slimScroll/jquery.slimscroll.min.js"></script>
<!-- ChartJS 1.0.1 -->
<script src="../system/engines/AdminLTE/plugins/chartjs/Chart.min.js"></script>

<style>
    .tab-content>.tab-pane {
        display: block;
        height: 0;
        overflow: hidden;
    }
    .tab-content>.tab-pane.active {
        height: auto;
    }
</style>

<?php
// check if stats object is here...
if (!isset($stats) || (empty($stats)))
{   // include stats class
    @require_once '../system/classes/stats.php';
    // and create new stats object
    $stats = new \YAWK\stats();
}
if (isset($_GET['interval']))
{
    $defaultInterval = $_GET['interval'];
}
    else if (isset($_POST['interval']))
    {
        $defaultInterval = $_POST['interval'];
    }
    else
        {
            $defaultInterval = 1;
        }

if (isset($_GET['period']))
{
    $defaultPeriod = $_GET['period'];
}
    else if (isset($_POST['period']))
    {
        $defaultPeriod = $_POST['period'];
    }
    else
        {
            $defaultPeriod = "DAY";
        }

// $defaultInterval = 1;
// $defaultPeriod = "DAY";
$data = $stats->getStatsArray($db, $defaultInterval, $defaultPeriod);

?>



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
/*
echo " Hits total: ";
echo number_format($stats->i_hits, 0, '.', '.');
echo "<pre>";
print_r($data);
echo "</pre>";
*/
?>

<div class="box">
    <div class="box-body">
        <form action="index.php?page=stats" method="post" class="form-inline">
        <div class="col-md-4">
            <?php echo "<h4><i class=\"fa fa-line-chart\"></i> &nbsp;$lang[STATS]&nbsp;<small>$lang[STATS_]</small></h4>"; ?>
        </div>
        <div class="col-md-8">
                <?php echo $lang['SHOW_DATA_OF']; ?>
                <label for="interval"><?php echo $lang['interval']; ?></label>
                <select id="interval" name="interval" class="form-control">
                    <?php
                    if (isset($_POST['interval']))
                    {
                        echo "<option value=\"$_POST[interval]\" selected aria-selected=\"true\">$_POST[interval]</option>";
                    }
                    ?>
                    <option value="0">---</option>
                    <?php
                    for ($i = 1; $i <= 365; $i++) {
                        echo "<option value=\"$i\">$i</option>";
                    }
                    ?>
                </select>
                <label for="period"><?php echo $lang['PERIOD']; ?></label>
                <select id="period" name="period" class="form-control">
                    <?php
                    if (isset($_POST['period']) && (isset($_POST['period'])))
                    {
                        $description = '';

                        switch ($_POST['period']) {
                            case "SECONDS":
                                if ($_POST['interval'] > 1)
                                {
                                    $description = $lang['SECONDS'];
                                }
                                else
                                {
                                    $description = $lang['SECOND'];
                                }
                                break;
                            case "MINUTE":
                                if ($_POST['interval'] > 1)
                                {
                                    $description = $lang['MINUTES'];
                                }
                                else
                                {
                                    $description = $lang['MINUTE'];
                                }
                                break;
                            case "HOUR":
                                if ($_POST['interval'] > 1)
                                {
                                    $description = $lang['HOURS'];
                                }
                                else
                                {
                                    $description = $lang['HOUR'];
                                }
                                break;
                            case "DAY":
                                if ($_POST['interval'] > 1)
                                {
                                    $description = $lang['DAYS'];
                                }
                                else
                                {
                                    $description = $lang['DAY'];
                                }
                                break;
                            case "WEEK":
                                if ($_POST['interval'] > 1)
                                {
                                    $description = $lang['WEEKS'];
                                }
                                else
                                {
                                    $description = $lang['WEEK'];
                                }
                                break;
                            case "MONTH":
                                if ($_POST['interval'] > 1)
                                {
                                    $description = $lang['MONTHS'];
                                }
                                else
                                {
                                    $description = $lang['MONTH'];
                                }
                                break;
                            case "YEAR":
                                if ($_POST['interval'] > 1)
                                {
                                    $description = $lang['YEARS'];
                                }
                                else
                                {
                                    $description = $lang['YEAR'];
                                }
                                break;
                        }

                        echo "<option value=\"$_POST[period]\" selected aria-selected=\"true\">$description</option>";

                    }
                    ?>

                    <option value="ALL">---</option>
                    <option value="SECONDS"><?php echo $lang['SECONDS']; ?></option>
                    <option value="MINUTE"><?php echo $lang['MINUTES']; ?></option>
                    <option value="HOUR"><?php echo $lang['HOURS']; ?></option>
                    <option value="DAY"><?php echo $lang['DAYS']; ?></option>
                    <option value="WEEK"><?php echo $lang['WEEKS']; ?></option>
                    <option value="MONTH"><?php echo $lang['MONTHS']; ?></option>
                    <option value="YEAR"><?php echo $lang['YEARS']; ?></option>
                </select>
                <!--
                <br><br>
                <label for="limit"><?php //echo "$lang[VIEW_LATEST] <small><i>n</i></small> $lang[HITS], $lang[LEAVE_BLANK_FOR_ALL]"; ?></label>
                <br>
                <input id="limit" name="limit" value="<?php // echo $limit; ?>" type="text" placeholder="<?php // echo $limit; ?>" class="form-control">
                <br>
                -->
                <button type="submit" id="refresh" name="refresh" class="btn btn-success" title="<?php echo $lang['REFRESH_STATS']; ?>"><i class="glyphicon glyphicon-refresh"></i>&nbsp; <?php echo "$lang[STATS]"; ?></button>
        </div>
    </form>
</div>
</div>

<div class="box">
    <div class="box-body">

<ul class="nav nav-tabs">
    <li class="active"><a data-toggle="tab" href="#home"><?php echo $lang['OVERVIEW']; ?></a></li>
    <li><a data-toggle="tab" href="#devices"><?php echo $lang['DEVICES']; ?></a></li>
    <li><a data-toggle="tab" href="#browser"><?php echo $lang['BROWSER']; ?></a></li>
    <li><a data-toggle="tab" href="#users"><?php echo $lang['USERS']; ?></a></li>
    <li><a data-toggle="tab" href="#os"><?php echo $lang['OPERATING_SYSTEMS']; ?></a></li>
    <li><a data-toggle="tab" href="#pages"><?php echo $lang['PAGES']; ?></a></li>
</ul>

    <div class="tab-content">
        <div id="home" class="tab-pane fade in active">
            <h3><?php echo $lang['OVERVIEW']; ?></h3>
            <div class="col-md-8">
                <!-- box -->
                <?php $stats->drawOverviewBox($lang); ?>
                <!-- / box -->
                <br>
                <?php $stats->drawWeekdayBox($db, $data, $lang); ?>
                <br>
                <?php $stats->getDaysOfMonthBox($lang); ?>
            </div>
            <div class="col-md-4">
                <!-- box -->
                <?php $stats->drawDaytimeBox($db, $data, $lang); ?>
                <!-- / box -->
            </div>
        </div>
        <div id="devices" class="tab-pane">
            <h3><?php echo $lang['DEVICES']; ?></h3>
            <div class="col-md-8">
                <!-- device type box -->
                <?php $stats->drawDeviceTypeBox($db, $data, $lang); ?>
                <!-- /device type box -->
            </div>
            <div class="col-md-4">
                <!-- device type box -->
                <?php $stats->drawOsBox($db, $data, $lang); ?>
                <!-- /device type box -->
            </div>
        </div>
        <div id="browser" class="tab-pane fade in">
            <h3><?php echo $lang['BROWSER']; ?></h3>
            <div class="col-md-6">
                <!-- browser box -->
                <?php $stats->drawBrowserBox($db, $data, $lang); ?>
                <!-- /browser box -->
            </div>
            <div class="col-md-6">
                ...
            </div>
        </div>
        <div id="users" class="tab-pane fade in">
            <h3><?php echo $lang['USERS']; ?></h3>
            <div class="col-md-6">
                <!-- login box -->
                <?php $stats->drawLoginBox($db, $lang); ?>
                <!-- / login box -->
            </div>
            <div class="col-md-6">
                <!-- latest users box -->
                <?php \YAWK\dashboard::drawLatestUsers($db, 8, $lang); ?>
                <!-- / latest users box -->
            </div>
        </div>
        <div id="os" class="tab-pane fade in">
            <h3><?php echo $lang['OPERATING_SYSTEMS']; ?></h3>
            <div class="col-md-12">
                <!-- device type box -->
                <?php $stats->drawOsVersionBox($db, $data, $lang); ?>
                <!-- /device type box -->
            </div>
        </div>
        <div id="pages" class="tab-pane fade in">
            <h3><?php echo $lang['PAGES']; ?></h3>
            <?php $stats->drawPagesBox($data, $lang); ?>
        </div>
    </div>
    </div>
</div>


<br>
<?php // $stats->drawTestBox(); ?>

<canvas id="myChart" width="400" height="400"></canvas>
<script>
    var ctx = document.getElementById("myChart").getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ["Red", "Blue", "Yellow", "Green", "Purple", "Orange"],
            datasets: [{
                label: '# of Votes',
                data: [12, 19, 3, 5, 2, 3],
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(255, 159, 64, 0.2)'
                ],
                borderColor: [
                    'rgba(255,99,132,1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero:true
                    }
                }]
            }
        }
    });
</script>

<script type="text/javascript">
    // some jquery magic to remember select option status
    $(document).ready(function() {
        var getUrlParameter = function getUrlParameter(sParam) {
            var sPageURL = decodeURIComponent(window.location.search.substring(1)),
                sURLVariables = sPageURL.split('&'),
                sParameterName,
                i;

            for (i = 0; i < sURLVariables.length; i++) {
                sParameterName = sURLVariables[i].split('=');

                if (sParameterName[0] === sParam) {
                    return sParameterName[1] === undefined ? true : sParameterName[1];
                }
            }
        };

        // period select field
        var periodSelect = $( "#period" );
        // interval select field
        var intervalSelect = $( "#interval" );
        // submit btn
        var submitBtn = $( "#refresh" );

        // on change of interval select option
        $(intervalSelect).on('change', function() {
            // current selected value
            intervalSelectValue = this.value;
            // save current intervalSelectValue to localStorage
            localStorage.setItem('intervalSelect', intervalSelectValue);
        });

        // on change of period select option
        $(periodSelect).on('change', function() {
            // current selected value
            periodSelectValue = this.value;
            // save current periodSelectValue to localStorage
            localStorage.setItem('periodSelect', periodSelectValue);
        });

        /*
        // on change of period select option
        $(submitBtn).on('click', function() {
            // current periodValue
            var currentPeriodSelectValue = $( "#period option:selected" ).val();
            // current intervalValue
            var currentIntervalSelectValue = $( "#interval option:selected" ).val();
            // save current periodSelectValue to localStorage
            localStorage.setItem('periodSelect', currentPeriodSelectValue);
            localStorage.setItem('intervalSelect', currentIntervalSelectValue);
        });
        */

        // get data from localStorage
        lastPeriodSelectValue = localStorage.getItem('periodSelect');
        lastIntervalSelectValue = localStorage.getItem('intervalSelect');

        $(periodSelect).val(lastPeriodSelectValue); // change value
        $(intervalSelect).val(lastIntervalSelectValue); // change value


        // check if there are GET params...
        var getPeriod = getUrlParameter('period');
        var getInterval = getUrlParameter('interval');

        // $( submitBtn ).trigger( "click" );

        /*
        // if getPeriod param is not set
        if(getPeriod !== "")
        {   // otherwise change value of period with GET param data
            $(periodSelect).val(getPeriod); // change value
        }

        // if getInterval param is not set
        if (getInterval !== "")
        {   // update interval select field with GET param data
            $(intervalSelect).val(getInterval); // change value
        }
        */
    });
</script>