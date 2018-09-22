<?php
if(isset($_POST))
{   // log checkboxes
    foreach ($_POST['active'] as $property => $value)
    {   // check checkbox value
        if ($value == "on")
        {   // set to numeric value
            $value = 1;
        }
        else
            {   // checkbox off
                $value = 0;
            }
        // update syslog_categories log (active) values
        if (!$db->query("UPDATE {syslog_categories} SET active = '".$value."' WHERE id = '".$property."' "))
        {   // make syslog entry on error
            \YAWK\sys::setSyslog($db, 1, 1, "Unable to update syslog configuration - unable to set state of field: $property to value: $value", "", 0, 0, 0);
        }
    }
    // notification checkboxes
    foreach ($_POST['notify'] as $property => $value)
    {   // check checkbox values
        if ($value == "on")
        {   // set to numeric value
            $value = 1;
        }
        else
        {   // checkbox off
            $value = 0;
        }
        // update syslog_categories notify values
        if (!$db->query("UPDATE {syslog_categories} SET notify = '".$value."' WHERE id = '".$property."' "))
        {   // make syslog entry on error
            \YAWK\sys::setSyslog($db, 1, 1, "Unable to update syslog configuration - unable to set state of field: $property to value: $value", "", 0, 0, 0);
        }
    }
}
?>
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
</script>
<?php
// TEMPLATE WRAPPER - HEADER & breadcrumbs
echo "
    <!-- Content Wrapper. Contains page content -->
    <div class=\"content-wrapper\" id=\"content-FX\">
    <!-- Content Header (Page header) -->
    <section class=\"content-header\">";
/* draw Title on top */
echo \YAWK\backend::getTitle($lang['SYSLOG'], $lang['SYSLOG_CONFIG']);
echo"<ol class=\"breadcrumb\">
            <li><a href=\"index.php\" title=\"$lang[DASHBOARD]\"><i class=\"fa fa-dashboard\"></i> $lang[DASHBOARD]</a></li>
            <li><a href=\"index.php?page=syslog\" class=\"active\" title=\"$lang[SYSLOG]\"> $lang[SYSLOG]</a></li>
            <li><a href=\"index.php?page=syslog\" class=\"active\" title=\"$lang[CONFIGURATION]\"> $lang[CONFIGURATION]</a></li>
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
        <h3 class="box-title"><?php echo "$lang[SETTINGS]"; ?></h3>
    </div>
    <div class="box-body">


        <form name="form" role="form" action="index.php?page=syslog-config" method="post">

        <!-- savebutton -->
        <button class="btn btn-success pull-right" type="submit" title="<?php echo $lang['SAVE'];?>" id="savebutton">
            <i class="fa fa-save"></i> &nbsp;&nbsp;<?php print $lang['SAVE']; ?>
        </button>

        <!-- link to syslog -->
        <a href="index.php?page=syslog" class="btn btn-default pull-right">
            <i class="fa fa-angle-double-left"></i>&nbsp;&nbsp; <?php print $lang['SYSLOG']; ?>
        </a>

        <table width="100%" cellpadding="4" cellspacing="0" border="0" class="table table-striped table-hover table-responsive" id="table-sort">
            <thead>
            <tr>
                <td><strong><?php echo $lang['ID']; ?></strong></td>
                <td width="20%" class="text-right"><strong><?php echo $lang['CATEGORY']; ?></strong></td>
                <td width="10%" class="text-left"><i class="fa fa-code"></i> &nbsp;<strong><?php echo $lang['LOG']; ?></strong></td>
                <td width="10%" class="text-left"><i class="fa fa-bell-o"></i> &nbsp;<strong><?php echo $lang['NOTIFY']; ?></strong></td>
                <td width="60%" class="text-center">&nbsp;</td>
            </tr>
            </thead>
            <tbody>
            <?php
            /* load complete syslog, get all notifications */
            $syslogCategories = \YAWK\sys::getSyslogCategories($db);
            if (is_array($syslogCategories))
            {
                foreach ($syslogCategories AS $category)
                {
                    if ($category['active'] == 1)
                    {
                        $log_active = " checked";
                    }
                    else
                        {
                            $log_active = "";
                        }

                    if ($category['notify'] == 1)
                    {
                        $notify_active = " checked";
                    }
                    else
                    {
                        $notify_active = "";
                    }
                    echo "<tr>
                    <td>".$category['id']."</td>
                    <td class=\"text-right\">".$category['property']."&nbsp;&nbsp;<i class=\"".$category['icon']."\"></i></td>
                    <td class=\"text-left\">
                        <input type=\"hidden\" class=\"checkbox\" name=\"active[".$category['id']."]\" id=\"hidden-".$category['id']."\" value=\"off\">
                        <input type=\"checkbox\" class=\"checkbox\" name=\"active[".$category['id']."]\" id=\"".$category['id']."\"$log_active>
                    </td>
                    <td class=\"text-left\">
                        <input type=\"hidden\" class=\"checkbox\" name=\"notify[".$category['id']."]\" id=\"hidden-".$category['id']."\" value=\"off\">
                        <input type=\"checkbox\" class=\"checkbox\" name=\"notify[".$category['id']."]\"$notify_active>
                    </td>
                    <td class=\"text-center\">&nbsp;</td>
                  </tr>";
                }
            }
            ?>
            </tbody>
        </table>
        </form>
    </div>
</div>