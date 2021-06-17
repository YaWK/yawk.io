<?php

use YAWK\alert;
use YAWK\backend;
use YAWK\db;
use YAWK\language;

/** @var $db db */
/** @var $lang language */
// TEMPLATE WRAPPER - HEADER & breadcrumbs

echo "
    <!-- Content Wrapper. Contains page content -->
    <div class=\"content-wrapper\" id=\"content-FX\">
    <!-- Content Header (Page header) -->
    <section class=\"content-header\">";
/* draw Title on top */
echo backend::getTitle($lang['GROUPS'], $lang['GROUPS_SETUP']);
echo"<ol class=\"breadcrumb\">
            <li><a href=\"index.php\" title=\"$lang[DASHBOARD]\"><i class=\"fa fa-dashboard\"></i> $lang[DASHBOARD]</a></li>
            <li><a href=\"index.php?page=users\" title=\"$lang[USERS]\"> $lang[USERS]</a></li>
            <li><a href=\"index.php?page=user-groups\" class=\"active\" title=\"$lang[GROUPS_SETUP]\"> $lang[GROUPS_SETUP]</a></li>
        </ol>
    </section>
    <!-- Main content -->
    <section class=\"content\">";
/* page content start here */


if(isset($_POST['update']))
{
    if (isset($_POST['groupname']))
    {   // groups sent from form
        $data = array_combine($_POST['id'], $_POST['groupname']);
            foreach ($data as $gid => $group)
            {   // update user groups
                if (!$db->query("UPDATE {user_groups} SET value='".$group."' WHERE id = '".$gid."'"))
                {   // q failed, throw error
                    echo alert::draw("danger", "$lang[ERROR]", " $lang[GROUP_NAMES_SAVE_FAILED]","page=user-groups","4800");
                    exit;
                }
            }
    }
}
if(isset($_GET['signup']) && (isset($_GET['gid'])))
{   // signup group settings
    if ($_GET['signup'] === '1')
    {   // signup not allowed
        $gid = $_GET['gid'];
        if (!$db->query("UPDATE {user_groups} SET signup_allowed='0' WHERE id = '".$gid."'"))
        {
            echo alert::draw("danger", "$lang[ERROR]", "$lang[GID_SET_FAILED] $gid","page=user-groups","4800");
            exit;
        }
    }
    else
    {   // signup allowed
        $gid = $_GET['gid'];
        if (!$db->query("UPDATE {user_groups} SET signup_allowed='1' WHERE id = '".$gid."'"))
        {
            echo alert::draw("danger", "$lang[ERROR]", "$lang[GID_SET_FAILED] $gid","page=user-groups","4800");
            exit;
        }
    }
}
if(isset($_GET['backend']) && (isset($_GET['gid'])))
{   // backend not allowed for this group (gid)
    if ($_GET['backend'] === '1')
    {
        $gid = $_GET['gid'];
        if (!$db->query("UPDATE {user_groups} SET backend_allowed='0' WHERE id = '".$gid."'"))
        {
            echo alert::draw("danger", "$lang[ERROR]", "$lang[GID_SET_FAILED] $gid","page=user-groups","4800");
            exit;
        }
    }
    else
    {   // backend login allowed for this group (gid)
        $gid = $_GET['gid'];
        if (!$db->query("UPDATE {user_groups} SET backend_allowed='1' WHERE id = '".$gid."'"))
        {
            echo alert::draw("danger", "$lang[ERROR]", "$lang[GID_SET_FAILED] $gid", "page=user-groups","4800");
            exit;
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
            "bSort": true,
            "bInfo": true,
            "bAutoWidth": false
        } );
    } );
</script>

<div class="box box-default">
    <div class="box-body">
<form role="form" method="POST" action="index.php?page=user-groups">
    <!-- save btn -->
    <button type="submit" class="btn btn-success pull-right">
        <i class="fa fa-save"></i> &nbsp;<?php print $lang['SETTINGS_SAVE']; ?>
    </button>
<!-- users btn -->
<a class="btn btn-default pull-right" href="index.php?page=users">
<i class="fa fa-user"></i> &nbsp;<?php print $lang['USERS_SETUP']; ?></a>
<!-- signup plg btn -->
<a class="btn btn-default pull-right" href="index.php?plugin=signup">
<i class="fa fa-plug"></i> &nbsp;<?php print $lang['SIGNUP_PLUGIN']; ?></a>
<table style="width:100%;" class="table table-striped table-hover table-responsive" id="table-sort">
    <thead>
    <tr>
        <td style="width: 5%;"><strong><?php echo $lang['ID']; ?></strong></td>
        <td style="width: 20%;"><strong><?php echo $lang['GROUP_RENAME']; ?></strong></td>
        <td style="width: 30%;"><strong><?php echo $lang['ADMIN_ACCESS']; ?></strong> <small><?php echo $lang['BE_CAREFUL']; ?></small></td>
        <td style="width: 30%;"><strong><?php echo $lang['FRONTEND_SIGNUP_ALLOWED']; ?></strong> <small><?php echo $lang['THIS_GROUP']; ?></small></td>
        <td style="width: 15%;" class="text-center"><strong><?php echo $lang['COLOR']; ?></strong></td>
    </tr>
    </thead>
    <tbody>
    <?php
    if ($res = $db->query("SELECT * FROM {user_groups} ORDER BY id"))
    {
        while($row = mysqli_fetch_assoc($res)){

            if ($row['backend_allowed'] === '1')
            {
                $backendhtml = "success";
                $backend_allowedtext ="<i class=\"fa fa-unlock\"></i>&nbsp;&nbsp;$lang[BACKEND] $lang[LOGIN] $lang[ALLOWED]";
            }
            else {
                $backendhtml = "danger";
                $backend_allowedtext = "<i class=\"fa fa-exclamation-triangle\"></i>&nbsp;&nbsp;$lang[BACKEND] $lang[LOGIN] $lang[FORBIDDEN]";
            }

            if ($row['signup_allowed'] === '1')
            {
                $signuphtml = "success";
                $signuptext="<i class=\"fa fa-check\"></i>&nbsp;&nbsp;$lang[ALLOWED]";
            }
            else {
                $signuphtml = "danger";
                $signuptext = "<i class=\"fa fa-times\"></i>&nbsp;&nbsp;$lang[FORBIDDEN]";
            }

            echo "<tr>
                <td><input type=\"text\" name=\"placeholder\" value=\"".$row['id']."\" class=\"form-control\" disabled>
                    <input type=\"hidden\" name=\"id[]\" value=\"".$row['id']."\">
                </td>
                <td><input type=\"text\" name=\"groupname[]\" value=\"".$row['value']."\" class=\"form-control\"></a></td>
                <td>
                  <a title=\"$lang[TOGGLE_STATUS]\" href=\"index.php?page=user-groups&backend=".$row['backend_allowed']."&gid=".$row['id']."\">
                  <span class=\"label label-$backendhtml\">$backend_allowedtext</span></a>&nbsp;
                </td>

                <td>
                  <a title=\"$lang[TOGGLE_STATUS]\" href=\"index.php?page=user-groups&signup=".$row['signup_allowed']."&gid=".$row['id']."\">
                  <span class=\"label label-$signuphtml\">$signuptext</span></a>&nbsp;</td>

                <td class=\"text-center\"><p class=\"text-$row[color]\">$row[color]</p></td>

              </tr>";
        }
    }

    ?>
    </tbody>
</table>
    <input type="hidden" name="update" value="1">
</form>
    </div>
</div>