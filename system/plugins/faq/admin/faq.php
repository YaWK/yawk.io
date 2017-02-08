<?php
// check if language is set
if (!isset($language) || (!isset($lang)))
{   // inject (add) language tags to core $lang array
    $lang = \YAWK\language::inject(@$lang, "../system/plugins/faq/language/");
}
include '../system/plugins/faq/classes/faq-backend.php';
if (isset($_GET['addpage'])){
    if ($_GET['addpage']==='1')
    {   // user clicked on add
        \YAWK\plugin::createPluginPage($db, "faq", "faq");
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
echo \YAWK\backend::getTitle($lang['FAQ'], $lang['FAQ_SUBTEXT']);
echo"<ol class=\"breadcrumb\">
            <li><a href=\"index.php\" title=\"$lang[DASHBOARD]\"><i class=\"fa fa-dashboard\"></i> $lang[DASHBOARD]</a></li>
            <li><a href=\"index.php?page=plugins\" title=\"$lang[PLUGINS]\"> $lang[PLUGINS]</a></li>
            <li class=\"active\"><a href=\"index.php?plugin=faq\" title=\"$lang[FAQ]\"> $lang[FAQ]</a></li>
         </ol>
    </section>
    <!-- Main content -->
    <section class=\"content\">";
/* page content start here */
?>
<div class="box box-default">
    <div class="box-header">

<!-- btn -->
<a class="btn btn-default pull-right" href="index.php?plugin=faq&addpage=1">
    <i class="glyphicon glyphicon-wrench"></i> &nbsp;<?php print $lang['PAGE_ADD_BTN']; ?></a>
<!-- btn -->
<a class="btn btn-success pull-right" href="index.php?plugin=faq&pluginpage=faq-new">
<i class="glyphicon glyphicon-plus"></i> &nbsp;<?php print $lang['FAQ_ADD']; ?></a>
<!-- tbl -->
<table width="100%" cellpadding="4" cellspacing="0" border="0" class="table table-hover" id="table-sort">
    <thead>
    <tr>
        <td width="3%"><strong>&nbsp;</strong></td>
        <td width="5%" class=\"text-center\"><strong><?php echo $lang['ID']; ?></strong></td>
        <td width="5%" class=\"text-center\"><strong><?php echo $lang['SORTATION']; ?></strong></td>
        <td width="70%"><strong><?php echo $lang['FAQ_QUESTION']; ?></strong></td>
        <td width="7%" class=\"text-center\"><strong><?php echo $lang['CATEGORY']; ?></strong></td>
        <td width="10%" class=\"text-center\"><strong><?php echo $lang['ACTIONS']; ?></strong></td>
    </tr>
    </thead>
    <tbody>
<?php
$faq = new \YAWK\PLUGINS\FAQ\faq();
$faq->drawBackEndTableBody($db);
?>
    </tbody>
    </table>
    </div>
</div>
