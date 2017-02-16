<?php
// TEMPLATE WRAPPER - HEADER & breadcrumbs
echo "
    <!-- Content Wrapper. Contains page content -->
    <div class=\"content-wrapper\" id=\"content-FX\">
    <!-- Content Header (Page header) -->
    <section class=\"content-header\">";
/* draw Title on top */
echo \YAWK\backend::getTitle($lang['SEARCH_RESULT'], $lang['SEARCH_SUBTEXT']);
echo"<ol class=\"breadcrumb\">
            <li><a href=\"index.php\" title=\"$lang[DASHBOARD]\"><i class=\"fa fa-dashboard\"></i> $lang[DASHBOARD]</a></li>
            <li class=\"active\"><a href=\"index.php?page=search\" title=\"$lang[SEARCH]\"> $lang[SEARCH]</a></li>
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
    <div class="col-md-8">
        <!-- box -->
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title"><?php echo $lang['RESULT'] ?> <small><?php echo $lang['ALL_ELEMENTS']; ?></small></h3>
            </div>
            <div class="box-body">
              ...
            </div>
        </div>
        <!-- / box -->
    </div>
    <div class="col-md-4">
        <!-- box -->
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title"><?php echo $lang['SETTINGS'] ?> <small><?php echo $lang['SEARCH_SETTINGS']; ?></small></h3>
            </div>
            <div class="box-body">
                ...
            </div>
        </div>
    </div>
</div>
