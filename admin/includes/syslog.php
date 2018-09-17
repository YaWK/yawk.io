<script type="text/javascript">
    $(document).ready(function() {
        $('#table-sort').dataTable( {
            "bPaginate": false,
            "bLengthChange": false,
            "bFilter": true,
            "bSort": true,
            "bInfo": true,
            "bAutoWidth": true
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
echo \YAWK\backend::getTitle($lang['SYSLOG'], $lang['SYSLOG_SUBTEXT']);
echo"<ol class=\"breadcrumb\">
            <li><a href=\"index.php\" title=\"$lang[DASHBOARD]\"><i class=\"fa fa-dashboard\"></i> $lang[DASHBOARD]</a></li>
            <li><a href=\"index.php?page=syslog\" class=\"active\" title=\"$lang[SYSLOG]\"> $lang[SYSLOG]</a></li>
        </ol>
    </section>
    <!-- Main content -->
    <section class=\"content\">";
/* page content start here */

if (isset($_GET['clear']) && $_GET['clear'] === '1')
    {   // delete all syslog entries
        if ($sql = $db->query("TRUNCATE TABLE {syslog}"))
        {   // delete all user notifications
            if ($db->query("TRUNCATE TABLE {notifications}"))
            {   // success, reload page
                \YAWK\alert::draw("success", "$lang[SYSLOG_DATA_DEL]", "$lang[SYSLOG_DATA_DEL_SUBTEXT]","index.php?page=syslog",4200);
            }
        }
        else
        {   // q failed...
            \YAWK\alert::draw("warning", "$lang[WARNING]", "$lang[SYSLOG_DATA_DEL_SUBTEXT]", "",4200);
        }
    }
?>

<div class="box box-default">
    <div class="box-header with-border">
        <h3 class="box-title"><?php echo "$lang[SYSTEM_LOGFILES]"; ?></h3>
        </div>
        <div class="box-body">

            <!-- btn clear log -->
            <a class="btn btn-success pull-right" role="dialog" title="<?php echo $lang['SYSLOG_CLEAR'];?>" data-confirm="<?php echo $lang['SYSLOG_DEL_CONFIRM']; ?>" href="index.php?page=syslog&clear=1">
                <i class="fa fa-trash-o"></i> &nbsp;<?php print $lang['SYSLOG_CLEAR']; ?></a>

<table width="100%" cellpadding="4" cellspacing="0" border="0" class="table table-striped table-hover table-responsive" id="table-sort">
    <thead>
    <tr>
        <td width="3%"><strong><?php echo $lang['ID']; ?></strong></td>
        <td width="13%"><strong><?php echo $lang['TYPE']; ?></strong></td>
        <td width="8%"><strong><?php echo $lang['TIMESTAMP']; ?></strong></td>
        <td width="10%" class="text-center"><strong><?php echo $lang['USER']; ?></strong></td>
        <td width="54%"><strong><?php echo $lang['ACTION']; ?></strong></td>
        <td width="12%" class="text-center"><strong><?php echo $lang['AFFECTED']; ?></strong></td>
    </tr>
    </thead>
    <tbody>
    <?php
    /* load complete syslog, get all notifications */
    $syslog = \YAWK\sys::getSyslog($db);
    if (is_array($syslog))
    {
        foreach ($syslog AS $log)
        {   // get username for affected uid
            $affected_user = \YAWK\user::getUserNameFromID($db, $log['toUID']);
            // cpt. caps
            $log['property'] = strtoupper($log['property']);
            // calculate time ago view
            $time_ago = \YAWK\sys::time_ago($log['log_date'], $lang);
            // 1 tbl row per syslog line
            echo "<tr class=\"".$log['type']."\">
                    <td>".$log['log_id']."</td>
                    <td><b>".$log['property']."</b></td>
                    <td><small>$log[log_date]<br><small>".$time_ago."</small></td>
                    <td class=\"text-center\"><a href=\"index.php?page=user-edit&user=$log[username]\" title=\"$log[username] ($lang[IN_NEW_WINDOW])\" target=\"_blank\">".$log['username']."</a></td>
                    <td><i class=\"".$log['icon']."\"></i> &nbsp;&nbsp;".$log['message']."</td>
                    <td class=\"text-center\">".$affected_user."</td>
                  </tr>";
        }
    }
    ?>
    </tbody>
</table>
</div>
</div>