<link rel="stylesheet" href="../system/engines/jquery/morris/morris.css">
<script src="../system/engines/jquery/morris/raphael-min.js"></script>
<script src="../system/engines/jquery/morris/morris.min.js"></script>
<script src="../system/engines/jquery/notify/bootstrap-notify.min.js"></script>
<script src="../system/engines/jquery/notify/package.js"></script>
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

<h3>Seitenaufrufe</h3>
<div id="myfirstchart" class="container-fluid" style="height: 250px;"></div>
<script type="text/javascript">
new Morris.Line({
  // ID of the element in which to draw the chart.
  element: 'myfirstchart',
  // Chart data records -- each entry in this array corresponds to a point on
  // the chart.
  data: [
    { year: '2012', value: 0 },
    { year: '2013', value: 1228 },
    { year: '2014', value: 2256 },
    { year: '2015', value: 3220 }
  ],
  // The name of the data record attribute that contains x-values.
  xkey: 'year',
  // A list of names of data record attributes that contain y-values.
  ykeys: ['value'],
  // Labels for the ykeys -- will be displayed when you hover over the
  // chart.
  labels: ['Seitenaufrufe']
});
</script>


<!-- ################################################# -->

<?PHP
/*
if (\YAWK\sys::isBrowscapSet($_SERVER['HTTP_USER_AGENT']) === false)
{
  echo "Your Browser: <b>".\YAWK\sys::getBrowserName($_SERVER['HTTP_USER_AGENT'])."</b>";
}
*/
$useragent = \YAWK\sys::getBrowser('');
echo "<h4>Browser Statistik </h4>Your browser: "."<b>". $useragent['name'] . " " . $useragent['version'] . " on " .$useragent['platform'] ."</b><br><br>";

echo "<h4>User Statistik</h4>Referer: ".$_SERVER['HTTP_REFERER']."<br>";
echo "Current: ".$_SERVER['REQUEST_URI']."<br>";
echo "accept language: ".$_SERVER['HTTP_ACCEPT_LANGUAGE']."<br><br>";

echo "<h4>Quellcode Statistik</h4>";
echo "YaWK Version: ".\YAWK\settings::getSetting($db, "yawkversion");
echo " <small>";echo \YAWK\settings::getSettingDescription($db, "yawkversion");echo"</small>";

    // SET VARS
    $FILE_PATH = "/xampp/htdocs/yawk-LTE/"; // full path
    $data = \YAWK\sys::countCodeLines($FILE_PATH, '.php');

echo"<p>$FILE_PATH <br>umfasst insgesamt <b>$data[files]</b> $data[type] files mit exakt <b>$data[lines]</b> Zeilen $data[type] Code</p><br>";

echo "<h4>Server Statistik</h4>";
    if (\YAWK\sys::checkZlib() === true)
    {   // output
        echo "<p>...zlib found!</p>";
    }
    else
    {   // output
        echo "<p class=\"text-danger\">...zlib not found!</p>";
    }


/*
 $total=$anz_lines + $anz_lines1;
 $total = number_format($total);
 echo "und <b>$anz_lines</b> Zeilen .html-Code.</b><br> Insgesamt z&auml;hlt das Projekt: <b>$total</b> Zeilen Quellcode.";
 */
