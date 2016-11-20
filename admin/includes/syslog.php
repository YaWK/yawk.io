<script type="text/javascript">
    $(document).ready(function() {
        $('#table-sort').dataTable( {
            "bPaginate": false,
            "bLengthChange": false,
            "bFilter": true,
            "bSort": false,
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
echo \YAWK\backend::getTitle($lang['SYSLOG'], $lang['SYSLOG_SUBTEXT']);
echo"<ol class=\"breadcrumb\">
            <li><a href=\"index.php\" title=\"Dashboard\"><i class=\"fa fa-dashboard\"></i> Dashboard</a></li>
            <li><a href=\"index.php?page=syslog\" class=\"active\" title=\"Users\"> Syslog</a></li>
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
                \YAWK\alert::draw("success", "Log data deleted!!", "All syslog entries and user notifications are deleted.","index.php?page=syslog",4200);
//                \YAWK\backend::setTimeout("index.php?page=syslog",250);
            }
        }
        else
        {   // q failed...
            \YAWK\alert::draw("warning", "Warning!", "Error deleting syslog data. Please try again.", "",4200);
        }
    }
?>

<div class="box box-default">
    <div class="box-header with-border">
        <h3 class="box-title">System Logfiles</h3>
        </div>
        <div class="box-body">

            <!-- btn clear log -->
            <a class="btn btn-success pull-right" role="dialog" data-confirm="Do you want to delete all syslog entries?" href="index.php?page=syslog&clear=1">
                <i class="fa fa-trash-o"></i> &nbsp;<?php print $lang['SYSLOG_CLEAR']; ?></a>

<table width="100%" cellpadding="4" cellspacing="0" border="0" class="table table-hover" id="table-sort">
    <thead>
    <tr>
        <td width="3%"><strong>ID</strong></td>
        <td width="13%"><strong>Type</strong></td>
        <td width="8%"><strong>Timestamp</strong></td>
        <td width="10%" class="text-center"><strong>User</strong></td>
        <td width="54%"><strong>Action</strong></td>
        <td width="12%" class="text-center"><strong>Affected</strong></td>
    </tr>
    </thead>
    <tbody>
    <?PHP
    /* load complete syslog, get all notifications */
    $syslog = \YAWK\user::getAllNotifications($db);
    if (is_array($syslog))
    {
        foreach ($syslog AS $log)
        {   // get username for affected uid
            $affected_user = \YAWK\user::getUserNameFromID($db, $log['toUID']);
            // cpt. caps
            $log['property'] = strtoupper($log['property']);
            // calculate time ago view
            $time_ago = \YAWK\sys::time_ago($log['log_date']);

            echo "<tr class=\"".$log['type']."\">
                    <td>".$log['log_id']."</td>
                    <td><b>".$log['property']."</b></td>
                    <td><small>$log[log_date]<br><small>".$time_ago."</small></td>
                    <td class=\"text-center\"><a href=\"index.php?page=user-edit&user=$log[username]\" title=\"$log[username] (in new window)\" target=\"_blank\">".$log['username']."</a></td>
                    <td><i class=\"".$log['icon']."\"></i> &nbsp;&nbsp;".$log['message']."</td>
                    <td class=\"text-center\">".$affected_user."</td>
                  </tr>";
        }
    }
    ?>
    </tbody>
</table>
        </div></div>