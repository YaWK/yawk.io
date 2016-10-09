
<?php
// TEMPLATE WRAPPER - HEADER & breadcrumbs
echo "
    <!-- Content Wrapper. Contains page content -->
    <div class=\"content-wrapper\" id=\"content-FX\">
    <!-- Content Header (Page header) -->
    <section class=\"content-header\">";
/* draw Title on top */
echo \YAWK\backend::getTitle($lang['GROUPS'], $lang['GROUPS_SETUP']);
echo"<ol class=\"breadcrumb\">
            <li><a href=\"index.php\" title=\"Dashboard\"><i class=\"fa fa-dashboard\"></i> Dashboard</a></li>
            <li><a href=\"index.php?page=users\" class=\"active\" title=\"Users\"> Users</a></li>
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
                    echo \YAWK\alert::draw("danger", "Error!", "group names could not be saved.","page=user-groups","4800");
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
            echo \YAWK\alert::draw("danger", "Error!", "group status of group ID $gid could not be set","page=user-groups","4800");
            exit;
        }
    }
    else
    {   // signup allowed
        $gid = $_GET['gid'];
        if (!$db->query("UPDATE {user_groups} SET signup_allowed='1' WHERE id = '".$gid."'"))
        {
            echo \YAWK\alert::draw("danger", "Error!", "group status of group ID $gid could not be set","page=user-groups","4800");
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
            echo \YAWK\alert::draw("danger", "Error!", "group status of group ID $gid could not be set","page=user-groups","4800");
            exit;
        }
    }
    else
    {   // backend login allowed for this group (gid)
        $gid = $_GET['gid'];
        if (!$db->query("UPDATE {user_groups} SET backend_allowed='1' WHERE id = '".$gid."'"))
        {
            echo \YAWK\alert::draw("danger", "Error!", "group status of group ID $gid could not be set", "page=user-groups","4800");
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
<i class="fa fa-plug"></i> &nbsp;<?php print $lang['SIGNUP']; ?></a>
<table width="100%" cellpadding="4" cellspacing="0" border="0" class="table table-hover" id="table-sort">
    <thead>
    <tr>
        <td width="5%"><strong>ID</strong></td>
        <td width="20%"><strong>Gruppe umbenennen</strong></td>
        <td width="30%"><strong>Access to /admin </strong> <small>(be careful...!)</small></td>
        <td width="30%"><strong>FrontEnd-SignUp allowed? </strong><small>(for this group)</small></td>
        <td width="15%" class="text-center";><strong>Farbe</strong></td>
    </tr>
    </thead>
    <tbody>
    <?PHP
    if ($res = $db->query("SELECT * FROM {user_groups} ORDER BY id"))
    {
        while($row = mysqli_fetch_assoc($res)){

            if ($row['backend_allowed'] === '1')
            {
                $backendhtml = "success";
                $backend_allowedtext ="<i class=\"fa fa-unlock\"></i>&nbsp;&nbsp;BACKEND Login allowed";
            }
            else {
                $backendhtml = "danger";
                $backend_allowedtext = "<i class=\"fa fa-exclamation-triangle\"></i>&nbsp;&nbsp;Backend Login forbidden";
            }

            if ($row['signup_allowed'] === '1')
            {
                $signuphtml = "success";
                $signuptext="<i class=\"fa fa-check\"></i>&nbsp;&nbsp;allowed";
            }
            else {
                $signuphtml = "danger";
                $signuptext = "<i class=\"fa fa-times\"></i>&nbsp;&nbsp;forbidden";
            }

            echo "<tr>
                <td><input type=\"text\" name=\"placeholder\" value=\"".$row['id']."\" class=\"form-control\" disabled>
                    <input type=\"hidden\" name=\"id[]\" value=\"".$row['id']."\">
                </td>
                <td><input type=\"text\" name=\"groupname[]\" value=\"".$row['value']."\" class=\"form-control\"></a></td>
                <td>
                  <a title=\"toggle&nbsp;status\" href=\"index.php?page=user-groups&backend=".$row['backend_allowed']."&gid=".$row['id']."\">
                  <span class=\"label label-$backendhtml\">$backend_allowedtext</span></a>&nbsp;
                </td>

                <td>
                  <a title=\"toggle&nbsp;status\" href=\"index.php?page=user-groups&signup=".$row['signup_allowed']."&gid=".$row['id']."\">
                  <span class=\"label label-$signuphtml\">$signuptext</span></a>&nbsp;</td>

                <td style=\"text-align:center;\"><p class=\"text-$row[color]\">$row[color]</p></td>

              </tr>";
        }
    }

    ?>
    </tbody>
</table>
    <input type="hidden" name="update" value="1">
</form>