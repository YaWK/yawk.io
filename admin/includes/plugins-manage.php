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
            <li><a href=\"index.php\" title=\"$lang[DASHBOARD]\"><i class=\"fa fa-dashboard\"></i> $lang[DASHBOARD]</a></li>
            <li><a href=\"index.php?page=plugins\" title=\"$lang[PLUGINS]\"> $lang[PLUGINS]</a></li>
            <li><a href=\"index.php?page=plugins-manage\" class=\"active\" title=\"$lang[PLUGINS_MANAGE]\"> $lang[PLUGINS_MANAGE]</a></li>
        </ol>
    </section>
    <!-- Main content -->
    <section class=\"content\">";
/* page content start here */
?>

<a class="btn btn-success pull-right" href="index.php?plugins-manage">
    <i class="glyphicon glyphicon-cog"></i> &nbsp;<?php print $lang['PLUGIN_MANAGE']; ?></a>

<table width="100%" cellpadding="4" cellspacing="0" border="0" class="table table-hover" id="table-sort">
    <thead>
    <tr>
        <td width="10%">&nbsp;</td>
        <td width="20%"><strong><i class="fa fa-caret-down"></i> <?php print $lang['PLUGIN']; ?></strong></td>
        <td width="60%"><strong><?php print $lang['DESCRIPTION']; ?></strong></td>
        <td width="10%" class="text-center"><strong><?php print $lang['ACTIONS']; ?></strong></td>
    </tr>
    </thead>
    <tbody>
    <?php
    $plugin = new \YAWK\plugin();
    if (!isset($db))
    {
        include '../system/classes/db.php';
        $db = new \YAWK\db();
    }
    print $plugin->getPlugins($db, $lang, 0);
    ?>
    </tbody>
</table>
