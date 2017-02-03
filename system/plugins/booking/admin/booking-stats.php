<?php
// if no database is set
if (!isset($db) || (empty($db)))
{   // create new db obj
    $db = new \YAWK\db();
}
// check if language is set
if (!isset($language) || (!isset($lang)))
{   // inject (add) language tags to core $lang array
    $lang = \YAWK\language::inject(@$lang, "../system/plugins/booking/language/");
}
include '../system/plugins/booking/classes/booking.php';
$booking = new YAWK\PLUGINS\BOOKING\booking();

// TEMPLATE WRAPPER - HEADER & breadcrumbs
echo "
    <!-- Content Wrapper. Contains page content -->
    <div class=\"content-wrapper\" id=\"content-FX\">
    <!-- Content Header (Page header) -->
    <section class=\"content-header\">";
/* draw Title on top */
echo \YAWK\backend::getTitle("$lang[BOOKING] $lang[STATS]", "$lang[NUMBERS] &amp $lang[FACTS]");
echo"<ol class=\"breadcrumb\">
            <li><a href=\"index.php\" title=\"$lang[DASHBOARD]\"><i class=\"fa fa-dashboard\"></i> $lang[DASHBOARD]</a></li>
            <li><a href=\"index.php?page=plugins\" title=\"$lang[PLUGINS]\"> $lang[PLUGINS]</a></li>
            <li><a href=\"index.php?plugin=booking\" title=\"$lang[BOOKING]\"> $lang[BOOKING]</a></li>
            <li class=\"active\"><a href=\"index.php?plugin=booking&pluginpage=booking-stats\" title=\"$lang[STATS]\"> $lang[STATS]</a></li>
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
$booking->getStats($db, $lang);
?>
