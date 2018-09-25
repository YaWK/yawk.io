<script type="text/javascript">
    $(document).ready(function() {
        $('#table-sort').dataTable( {
            "bPaginate": false,
            "bLengthChange": false,
            "bFilter": true,
            "bSort": false,
            "bInfo": true,
            "bAutoWidth": true
        } );
    } );

    // dismiss a single notification
    // this function will be called by click on the envelope icon in the syslog table
    function dismissNotification(id) {
        $.ajax({    // do ajax request
            url: 'js/dismiss-singleNotification.php',
            type: 'POST',
            data: {
                "id": id
            },
            success: function (data) {
                if (!data) {
                    alert('Something went wrong!');
                    return false;
                }
                else    // dismiss notification(id) successful
                {   // ajax post-processing: update icons + bell label
                    // get current icon with this id
                    var currentIcon = '#envelope-'+id;
                    // get current with this id
                    var currentLink = '#link'+id;
                    // store bell label (the yellow flag on the notification box)
                    var bellLabel = '#bell-label';
                    // remove closed envelope icon
                    $(currentIcon).removeClass('fa fa-envelope-o');
                    // add open envelope icon
                    $(currentIcon).addClass('fa fa-envelope-open-o text-gray');
                    // change onclick function call to reopen
                    $(currentLink).attr("onclick","reopenNotification("+id+")");
                    // get number of bell label notification counter
                    var notificationCounter = $(bellLabel).text();
                    // subtract -1 from counter
                    notificationCounter--;
                    // if notification counter is null
                    if (!notificationCounter)
                    {   // fade away the orange label on top
                        $(bellLabel).fadeOut();
                    }
                    else
                    {   // update bell label notification counter
                        $(bellLabel).text(notificationCounter);
                    }
                }
            }
        });
    }

    // re-open a single notification
    // this function will be called by click on the envelope icon in the syslog table
    function reopenNotification(id) {
        $.ajax({    // do ajax request
            url: 'js/reopen-singleNotification.php',
            type: 'POST',
            data: {
                "id": id
            },
            success: function (data) {
                if (!data) {
                    alert('Something went wrong!');
                    return false;
                }
                else
                {   // re-open notification(id) successful
                    // ajax post-processing: update icons + bell label
                    // get current icon with this id
                    var currentIcon = '#envelope-'+id;
                    // get current link with this id
                    var currentLink = '#link'+id;
                    // get current icon with this id
                    var bellLabel = '#bell-label';
                    // update envelope class: remove open envelope
                    $(currentIcon).removeClass('fa fa-envelope-open-o text-gray');
                    // update envelope class to closed envelope
                    $(currentIcon).addClass('fa fa-envelope-o');
                    // change onclick function call to reopen
                    $(currentLink).attr("onclick","dismissNotification("+id+")");
                    // uget bell label notification number
                    var notificationCounter = $(bellLabel).text();
                    // add +1 to notification counter
                    notificationCounter++;
                    // update bell label notification counter
                    $(bellLabel).text(notificationCounter);
                }
            }
        });
    }
</script>
<?php
// check if syslog is enabled
if (\YAWK\settings::getSetting($db, "syslogEnable") == false)
{   // if not, throw a warning message
    echo \YAWK\alert::draw("danger", $lang['SYSLOG_DISABLED'], $lang['SYSLOG_DISABLED_MSG'], "", 0);
}

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
                \YAWK\alert::draw("success", "$lang[SYSLOG_DATA_DEL]", "$lang[SYSLOG_DATA_DEL_SUBTEXT]","",3600);
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
            <a class="btn btn-danger pull-right" role="dialog" title="<?php echo $lang['SYSLOG_CLEAR'];?>" data-confirm="<?php echo $lang['SYSLOG_DEL_CONFIRM']; ?>" href="index.php?page=syslog&clear=1">
                <i class="fa fa-trash-o"></i> &nbsp;<?php print $lang['SYSLOG_CLEAR']; ?>
            </a>
            <!-- btn syslog settings -->
            <a class="btn btn-default pull-right" title="<?php echo $lang['SETTINGS'];?>" href="index.php?page=syslog-config">
                <i class="fa fa-cog"></i> &nbsp;<?php print $lang['SETTINGS']; ?>
            </a>

<table width="100%" cellpadding="4" cellspacing="0" border="0" class="table table-striped table-hover table-responsive" id="table-sort">
    <thead>
    <tr>
        <td width="3%" class="text-center"><strong><small><i class="fa fa-bell-o"></i></small></strong></td>
        <td width="8%" class="text-center"><strong><?php echo $lang['TYPE']; ?></strong></td>
        <td width="10%" class="text-center"><strong><?php echo $lang['TIMESTAMP']; ?></strong></td>
        <td width="12%" class="text-center"><strong><?php echo $lang['USER']; ?></strong></td>
        <td width="61%"><strong><?php echo $lang['ENTRY']; ?></strong></td>
        <td width="10%" class="text-center"><strong><?php // echo $lang['AFFECTED']; ?></strong></td>
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
            // improve view of category title (cpt. caps + remove post tags -warning -success and -error)
            $log['property'] = strtoupper(substr($log['property'], 0, strpos($log['property'], '-')));
            // calculate time ago view
            $time_ago = \YAWK\sys::time_ago($log['log_date'], $lang);
            // 1 tbl row per syslog line
            if ($log['log_type'] == 1)
            {
                $textMarkup = "";
                $category = "<b>".$log['property']."</b><br><span class=\"label label-warning\">Warning</span>";
            }
            elseif ($log['log_type'] == 2)
            {
                $textMarkup = " class=\"text-red\"";
                $category = "<b>".$log['property']."</b><br><span class=\"label label-danger\">ERROR</span>";

            }
            else
                {
                    $textMarkup = "";
                    $category = "<b>".$log['property']."</b><br><span class=\"label label-default\">Info</span>";

                }
            if ($log['seen'] == 0)
            {
                $labelMarkup = "<a href=\"#\" onclick=\"dismissNotification('".$log['log_id']."')\" id=\"link".$log['log_id']."\" data-id=\"$log[log_id]\"><i class=\"fa fa-envelope-o\" id=\"envelope-$log[log_id]\" title=\"$lang[ID]: $log[log_id]\"></i></a>";
            }
            else
                {
                    $labelMarkup = "<a href=\"#\" onclick=\"reopenNotification('".$log['log_id']."')\" id=\"link".$log['log_id']."\" data-id=\"$log[log_id]\"><i class=\"fa fa-envelope-open-o text-gray\" id=\"envelope-$log[log_id]\" title=\"$lang[ID]: $log[log_id]\"></i></a>";
                }

            echo "<tr class=\"".$log['type']."\">
                    <td class=\"text-center\">$labelMarkup</td>
                    <td class=\"text-center\">".$category."</td>
                    <td class=\"text-center\"><small>$log[log_date]<br><small>".$time_ago."</small></td>
                    <td class=\"text-center\"><a href=\"index.php?page=user-edit&user=$log[username]\" title=\"$log[username] ($lang[IN_NEW_WINDOW])\" target=\"_blank\"$textMarkup>".$log['username']."</a></td>
                    <td$textMarkup><i class=\"".$log['icon']."\"></i> &nbsp;&nbsp;".$log['message']."</td>
                    <td class=\"text-center\"><span$textMarkup>".$affected_user."</span></td>
                  </tr>";
        }
    }
    ?>
    </tbody>
</table>
</div>
</div>