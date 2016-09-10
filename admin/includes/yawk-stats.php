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
    { year: '2015', value: 3220 },
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
// SET VARS - FULL PATH 
 $FILE_PATH = "/xampp/htdocs/yawk-LTE/";
 
function read_recursiv($path) { 
 global $files_count;

     $result = array(); 
     $handle = opendir($path); 
     if ($handle) { 

         while (false !== ($file = readdir($handle))) { 
             if ($file != "." && $file != "..") {
                 if (is_file($file)) {
                     $files_count = $files_count + 1;
                 }
                 $name = $path . "/" . $file; 

                 if (is_dir($name)) { 
                     $ar = read_recursiv($name); 
                     foreach ($ar as $value) {
                         $result[] = $value; 
                     }
                 } else { 
                     $result[] = $name; 
                     $files_count = $files_count + 1;
                 }
             }
         }
     }
     closedir($handle); 
     return $result; 
}

 // load php data
 $FILE_TYPE = ".php";
 $data = read_recursiv("$FILE_PATH", "$FILE_TYPE");
 $anz_lines = 0;
 foreach($data as $value) {
     // count lines of files with given type
     if (substr($value, -4) === "$FILE_TYPE") {
         $lines = file($value);
         $_anz_lines = count($lines);
         $anz_lines += $_anz_lines;
         unset($lines, $_anz_lines);
         $files_count++;
     }
 }
 // $files_count = $files_count / 2;
 echo "<strong>YaWK Statistik f&uuml;r Version</strong> "; print \YAWK\settings::getSetting($db, "yawkversion"); print " <small>";print \YAWK\settings::getSettingDescription($db, "yawkversion");
 echo"</b></small><br><br> $FILE_PATH <br><br>umfasst insgesamt <b>$files_count</b> files mit exakt <b>$anz_lines</b> Zeilen .php-";
 $anz_lines1 = $anz_lines;

 // load htm data
 $FILE_TYPE = ".htm";
 $data = read_recursiv("$FILE_PATH", "$FILE_TYPE");
 $anz_lines = 0;
 foreach($data as $value) {
     // count lines of files with given type
     if (substr($value, -4) === "$FILE_TYPE") {
         $lines = file($value);
         $_anz_lines = count($lines);
         $anz_lines += $_anz_lines;
         unset($lines, $_anz_lines);
     }
 }
 $total=$anz_lines + $anz_lines1;

 $total = number_format($total);
 
 echo "und <b>$anz_lines</b> Zeilen .html-Code.</b><br> Insgesamt z&auml;hlt das Projekt: <b>$total</b> Zeilen Quellcode."; 
 
 echo"<br><br><br>";

// check if zlib is installed
if(extension_loaded('zlib')) {
    echo "...........zlib found";
} else {
    echo "..........zlib missing";
}
 
 ?>
<br><br>
 
<pre>Text in einem {pre} block, default bootstrap style</pre>
<button class="btn btn-default" name="testbutton" id="testbutton">test</button>


