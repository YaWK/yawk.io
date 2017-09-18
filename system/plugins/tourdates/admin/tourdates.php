<?php
// check if language is set
if (!isset($language) || (!isset($lang)))
{   // inject (add) language tags to core $lang array
    $lang = \YAWK\language::inject(@$lang, "../system/plugins/tourdates/language/");
}
/* draw Title on top */
\YAWK\backend::getTitle($lang['TOUR_DATES'], $lang['TOUR_DATES_SUBTEXT']);
if (isset($_GET['addpage']))
{   // add HTML page for that plugin
    if ($_GET['addpage']==='1'){
        if (\YAWK\plugin::createPluginPage($db, "tourdates", "tourdates") === true)
        {
            \YAWK\alert::draw("success", "Success!", "Pluginpage created successfully!", "", 5000);
        }
        else
            {
                \YAWK\alert::draw("danger", "ERROR!", "Could not create plugin page!", "", 5000);
            }
    }
}
?>
<script type="text/javascript">
    $(document).ready(function () {
        $('#table-sort').dataTable({
            "bPaginate": false,
            "bLengthChange": false,
            "bFilter": true,
            "bSort": true,
            "bInfo": true,
            "bAutoWidth": false
        });
    });
</script>
<?php
// TEMPLATE WRAPPER - HEADER & breadcrumbs
echo "
    <!-- Content Wrapper. Contains page content -->
    <div class=\"content-wrapper\" id=\"content-FX\">
    <!-- Content Header (Page header) -->
    <section class=\"content-header\">";
/* draw Title on top */
echo \YAWK\backend::getTitle($lang['TOUR_DATES'], $lang['TOUR_DATES_SUBTEXT']);
echo"<ol class=\"breadcrumb\">
            <li><a href=\"index.php\" title=\"$lang[DASHBOARD]\"><i class=\"fa fa-dashboard\"></i> $lang[DASHBOARD]</a></li>
            <li><a href=\"index.php?page=plugins\" title=\"$lang[PLUGINS]\"> $lang[PLUGINS]</a></li>
            <li class=\"active\"><a href=\"index.php?plugin=tourdates\" title=\"$lang[TOUR_DATES]\"> $lang[TOUR_DATES]</a></li>
         </ol>
    </section>
    <!-- Main content -->
    <section class=\"content\">";
/* page content start here */
?>
<div class="box box-default">
    <div class="box-body">

<!-- btn -->
<a class="btn btn-default pull-right" href="index.php?plugin=tourdates&addpage=1">
    <i class="glyphicon glyphicon-wrench"></i> &nbsp;<?php print $lang['PAGE_ADD_BTN']; ?></a>
<!-- btn -->
<a class="btn btn-success" href="index.php?plugin=tourdates&pluginpage=tourdates-new" style="float:right;">
    <i class="glyphicon glyphicon-plus"></i> &nbsp;<?php print $lang['TOUR+']; ?></a>

<table width="100%" cellpadding="4" cellspacing="0" border="0" class="table table-hover" id="table-sort">
    <thead>
    <tr>
        <td width="6%"><strong>&nbsp;</strong></td>
        <td width="10%"><strong><i class="fa fa-caret-down"></i> <?php print $lang['TOUR_DATE']; ?></strong></td>
        <td width="36%" class="text-left"><strong><i class="fa fa-caret-down"></i> <?php print $lang['TOUR_BAND']; ?></strong></td>
        <td width="5%" class="text-left"><strong><?php print $lang['TOUR_TIME']; ?></strong></td>
        <td width="24%" class="text-left"><strong><?php print $lang['TOUR_VENUE']; ?></strong></td>
        <td width="4%" class="text-center"><strong><?php print $lang['FACEBOOK']; ?></strong></td>
        <td width="10%" class="text-center"><strong><?php print $lang['ACTIONS']; ?></strong></td>
    </tr>
    </thead>
    <tbody>

    <?php
    include '../system/plugins/tourdates/classes/tourdates.php';
    $tourdates = new \YAWK\PLUGINS\TOURDATES\tourdates();
    print $tourdates->getBackendTable($db, $lang);
    ?>
    </tbody>
</table>

    </div>
</div>