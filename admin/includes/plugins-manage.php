<script type="text/javascript">
    $(document).ready(function() {
        $('#table-sort').dataTable( {
            "bPaginate": false,
            "bLengthChange": false,
            "bFilter": true,
            "bSort": true,
            "bInfo": true,
            "bAutoWidth": false
        } );
    } );
</script>
<?php
// TEMPLATE WRAPPER - HEADER & breadcrumbs
echo "
    <!-- Content Wrapper. Contains page content -->
    <div class=\"content-wrapper\" id=\"content-FX\">
    <!-- Content Header (Page header) -->
    <section class=\"content-header\">";
/* draw Title on top */
echo \YAWK\backend::getTitle($lang['PLUGINS_MANAGE'], $lang['PLUGINS_MANAGE_SUBTEXT']);
echo"<ol class=\"breadcrumb\">
            <li><a href=\"index.php\" title=\"Dashboard\"><i class=\"fa fa-dashboard\"></i> Dashboard</a></li>
            <li><a href=\"index.php?page=plugins\" itle=\"Users\"> Plugins</a></li>
            <li><a href=\"index.php?page=plugins-manage\" class=\"active\" title=\"Users\"> Manage Plugins</a></li>
        </ol>
    </section>
    <!-- Main content -->
    <section class=\"content\">";
/* page content start here */
?>


<a class="btn btn-success" href="index.php?plugins-manage" style="float:right;">
    <i class="glyphicon glyphicon-cog"></i> &nbsp;<?php print $lang['PLUGIN_MANAGE']; ?></a>

<table width="100%" cellpadding="4" cellspacing="0" border="0" class="table table-hover" id="table-sort">
    <thead>
    <tr>
        <td width="10%">&nbsp;</td>
        <td width="20%"><strong><i class="fa fa-caret-down"></i> <?PHP print $lang['PLUGIN']; ?></strong></td>
        <td width="60%"><strong><?PHP print $lang['DESCRIPTION']; ?></strong></td>
        <td width="10%" style="text-align: center;"><strong><?PHP print $lang['ACTIONS']; ?></strong></td>
    </tr>
    </thead>
    <tbody>
    <?PHP
    $plugin = new \YAWK\plugin();
    if (!isset($db))
    {
        include '../system/classes/db.php';
    }
    print $plugin->getPlugins($db, $lang, 0);
    ?>
    </tbody>
</table>
