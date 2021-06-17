<?php

use YAWK\alert;
use YAWK\backend;
use YAWK\db;
use YAWK\language;
use YAWK\settings;
use YAWK\sys;

/** @var $db db */
/** @var $lang language */

if(isset($_POST))
{   // log checkboxes
    if (isset($_POST['active']))
    {
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
                sys::setSyslog($db, 3, 1, "Unable to update syslog configuration - unable to set state of field: $property to value: $value", "", 0, 0, 0);
            }
        }
    }
    // notification checkboxes
    if (isset($_POST['notify']))
    {
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
                sys::setSyslog($db, 3, 1, "Unable to update syslog configuration - unable to set state of field: $property to value: $value", "", 0, 0, 0);
            }
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
<script type="text/javascript">
    $(document).ready(function() {
        // TRY TO DISABLE CTRL-S browser hotkey
        function saveHotkey() {
            // simply disables save event for chrome
            $(window).keypress(function (event) {
                if (!(event.which === 115 && (navigator.platform.match("Mac") ? event.metaKey : event.ctrlKey)) && !(event.which === 19)) return true;
                event.preventDefault();
                formmodified=0; // do not warn user, just save.
                return false;
            });
            // used to process the cmd+s and ctrl+s events
            $(document).keydown(function (event) {
                if (event.which === 83 && (navigator.platform.match("Mac") ? event.metaKey : event.ctrlKey)) {
                    event.preventDefault();
                    $('#savebutton').click(); // SAVE FORM AFTER PRESSING STRG-S hotkey
                    formmodified=0; // do not warn user, just save.
                    // save(event);
                    return false;
                }
            });
        }
        saveHotkey();


        var savebutton = ('#savebutton');
        var savebuttonIcon = ('#savebuttonIcon');
        // ok, lets go...
        // we need to check if user clicked on save button
        $(savebutton).click(function() {
            $(savebutton).removeClass('btn btn-success').addClass('btn btn-warning disabled');
            $(savebuttonIcon).removeClass('fa fa-save').addClass('fa fa-spinner fa-spin fa-fw');
        });


        // automatically turn off notifications if loggin is turned of for this category
        // check if any checkbox has changed
        $(':checkbox').change(function()
        {   // $this is reference to the clicked checkbox
            var $this = $(this);
            // get ID attribute from this checkbox
            var id = $(this).attr('id');
            // the corresponding notify checkbox to the logging checkbox
            var notifyCheckbox = '#notify'+id;
            // check if clicked checkbox is currently checked
            if ($this.is(':checked'))
            {   // toggle corresponding notify checkbox ON
                $(notifyCheckbox).bootstrapToggle('enable');
                $(notifyCheckbox).bootstrapToggle('on');
                // alert('checkbox '+id+ ' is now ON');
            } else {
                // toggle corresponding notify checkbox OFF
                $(notifyCheckbox).bootstrapToggle('off');
                $(notifyCheckbox).bootstrapToggle('disable');
                // $(notifyCheckbox).bootstrapToggle.off;
            }
        });

        // Toggle all syslog categories on / off
        $('#toggleAllBtn').click(function(e)
        {
            // prevent page reload
            e.preventDefault();
            // select table
            var table = $("#table-sort");
            // select all checkboxes in this table
            var selected = $('td input:checkbox',table);
            // on each selected checkbox
            $(selected).each(function()
            {
                //  $this reference to the clicked checkbox
                var $this = $(this);
                // store current checkbox selector
                var currentCheckbox = '#'+this.id;
                // check if checkbox is checked
                if ($this.is(':checked'))
                {   // toggle current checkbox (all)
                    $(currentCheckbox).bootstrapToggle('toggle');
                    // console.log(this.id+' is checked');
                }
                else
                    {   // toggle not checked checkboxes
                        $(currentCheckbox).bootstrapToggle('toggle');
                        // console.log(this.name+' unchecked');
                    }
            });
        });

    }); // end document ready
</script>
<!-- Bootstrap toggle css -->
<link rel="stylesheet" href="../system/engines/bootstrap-toggle/css/bootstrap-toggle.css">
<!-- Bootstrap toggle js -->
<script type="text/javascript" src="../system/engines/bootstrap-toggle/js/bootstrap-toggle.min.js"></script>
<?php
// check if syslog is enabled
$syslogEnabled = settings::getSetting($db, "syslogEnable");
if ($syslogEnabled == false)
{   // if not, throw a warning message
    echo alert::draw("danger", $lang['SYSLOG_DISABLED'], $lang['SYSLOG_DISABLED_MSG'], "", 0);
}

// TEMPLATE WRAPPER - HEADER & breadcrumbs
echo "
    <!-- Content Wrapper. Contains page content -->
    <div class=\"content-wrapper\" id=\"content-FX\">
    <!-- Content Header (Page header) -->
    <section class=\"content-header\">";
/* draw Title on top */
echo backend::getTitle($lang['SYSLOG'], $lang['SYSLOG_CONFIG']);
echo"<ol class=\"breadcrumb\">
            <li><a href=\"index.php\" title=\"$lang[DASHBOARD]\"><i class=\"fa fa-dashboard\"></i> $lang[DASHBOARD]</a></li>
            <li><a href=\"index.php?page=syslog\" class=\"active\" title=\"$lang[SYSLOG]\"> $lang[SYSLOG]</a></li>
            <li><a href=\"index.php?page=syslog-config\" class=\"active\" title=\"$lang[CONFIGURATION]\"> $lang[CONFIGURATION]</a></li>
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
            alert::draw("success", "$lang[SYSLOG_DATA_DEL]", "$lang[SYSLOG_DATA_DEL_SUBTEXT]","",3600);
        }
    }
    else
    {   // q failed...
        alert::draw("warning", "$lang[WARNING]", "$lang[SYSLOG_DATA_DEL_SUBTEXT]", "",4200);
    }
}
?>

<div class="box box-default">
    <div class="box-header with-border">
        <h3 class="box-title"><?php echo "$lang[SETTINGS]"; ?></h3>
    </div>
    <div class="box-body">


        <form name="form" id="form" role="form" action="index.php?page=syslog-config" method="post">

        <!-- savebutton -->
        <button class="btn btn-success pull-right" type="submit" title="<?php echo $lang['SAVE'];?>" id="savebutton">
            <i class="fa fa-save" id="savebuttonIcon"></i> &nbsp;&nbsp;<?php print $lang['SAVE']; ?>
        </button>

        <!-- link to syslog -->
        <a href="index.php?page=syslog" class="btn btn-default pull-right">
            <i class="fa fa-angle-double-left"></i>&nbsp;&nbsp; <?php print $lang['SYSLOG']; ?>
        </a>
        <!-- toggle all -->
        <button class="btn btn-default pull-right" id="toggleAllBtn" href="#" title="<?php print $lang['TOGGLE_ALL']; ?>">
            <i class="fa fa-toggle-on"></i>
        </button>

        <table style="width:100%;" class="table table-striped table-hover table-responsive" id="table-sort">
            <thead>
            <tr>
                <td style="width:35%;" class="text-left"><strong><?php echo $lang['CATEGORY']; ?></strong></td>
                <td style="width:20%;" class="text-center"><i class="fa fa-code"></i> &nbsp;<strong><?php echo $lang['LOG']; ?></strong></td>
                <td style="width:25%;" class="text-center"><i class="fa fa-bell-o"></i> &nbsp;<strong><?php echo $lang['NOTIFY']; ?></strong></td>
                <td style="width:10%;" class="text-center">&nbsp;</td>
            </tr>
            </thead>
            <tbody>
            <?php
            /* load complete syslog, get all notifications */
            $syslogCategories = sys::getSyslogCategories($db);
            if (is_array($syslogCategories))
            {
                foreach ($syslogCategories AS $category)
                {
                    if (strstr($category['property'], "success"))
                    {
                        $color = " text-green";
                    }
                    elseif (strstr($category['property'], "warning"))
                    {
                        $color = " text-orange";
                    }
                    elseif (strstr($category['property'], "error"))
                    {
                        $color = " text-red";
                    }
                    else
                        {
                            $color = " text-gray";
                        }

                    if ($syslogEnabled == false)
                    {
                        $disabled = " disabled readonly";
                    }
                    else
                    {
                        $disabled = '';
                    }


                    if ($category['active'] == 1)
                    {
                        $log_active = " checked".$disabled;
                    }
                    else
                        {
                            $log_active = "";
                        }

                    if ($category['notify'] == 1)
                    {
                        $notify_active = " checked".$disabled;
                    }
                    else
                    {
                        $notify_active = "";
                    }
                    echo "<tr>
                    <td class=\"text-left\"><i class=\"".$category['icon']."$color\"></i>&nbsp;&nbsp;&nbsp;&nbsp; <b>".ucfirst($category['property'])."</b></td>
                    <td class=\"text-center\">
                        <input type=\"hidden\" name=\"active[".$category['id']."]\" id=\"hidden-".$category['id']."\" value=\"off\">
                        <input type=\"checkbox\" data-on=\"$lang[ON_]\" data-off=\"$lang[OFF_]\" data-toggle=\"toggle\" data-onstyle=\"success\" data-offstyle=\"danger\" class=\"checkbox\" data-activeID=\"".$category['id']."\" name=\"active[".$category['id']."]\" id=\"".$category['id']."\"$log_active>
                    </td>
                    <td class=\"text-center\">
                        <input type=\"hidden\" name=\"notify[".$category['id']."]\" id=\"hidden-".$category['id']."\" value=\"off\">
                        <input type=\"checkbox\" data-on=\"<i class='fa fa-bell-o'>\" data-off=\"<i class='fa fa-bell-slash-o'>\" data-toggle=\"toggle\" data-onstyle=\"success\" data-offstyle=\"danger\" data-notifyID=\"".$category['id']."\" class=\"checkbox\" name=\"notify[".$category['id']."]\" id=\"notify".$category['id']."\"$notify_active>
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

