<?php

use YAWK\alert;
use YAWK\backend;
use YAWK\db;
use YAWK\language;
use YAWK\user;

/** @var $db db */
/** @var $lang language */

if (!isset($user))
{   // generate new user object
    $user = new user($db);
}
// TOGGLE USER
if (isset($_GET['toggle']) && $_GET['toggle'] === "1")
{
    if (isset($_GET['blocked']))
    {   // set user obj property
        $user->blocked = $_GET['blocked'];
    }
    if (isset($_GET['uid']))
    {   // set user id
        $user->id = $_GET['uid'];
    }
    if ($user->blocked === '1')
    {   // user is not blocked
        $user->blocked = 0;
        $color = "success";
        $status = "$lang[ACTIVE]";
    }
    else
    {   // set user status to blocked
        $user->blocked = 1;
        $color = "danger";
        $status = "$lang[BLOCKED]";
    }
    $user->username = user::getUserNameFromID($db, $user->id);

    // now toggle user status
    if($user->toggleOffline($db, $user->id, $user->blocked))
    {   // successful
        print alert::draw("$color", "$user->username $status", "$lang[USER] <b>$user->username</b> $lang[IS] $lang[NOW] $status", "", 1800);
    }
    else
    {   // throw error
        print alert::draw("danger", "$lang[ERROR]", "$lang[USER] $lang[TOGGLE_FAILED]", "page=users", 5800);
    }
}

// DELETE USER
if (isset($_GET['delete']))
{
    if($_GET['delete'] === "true")
    {   // check if user is set
        if (isset($_GET['user']))
        {   // username is set, check forbidden names
            if ($_GET['user'] === 'admin' OR $_GET['user'] === 'root' OR $_GET['user'] === 'administrator')
            {   // throw forbidden user deletion warning
                print alert::draw("danger", "$lang[WARNING]", "$lang[NOT_DELETEABLE]", "", 10000);
            }
            // delete user
            if($user->delete($db, $_GET['user']))
            {   // success
                print alert::draw("success", "$lang[SUCCESS]", "$lang[USER] <strong>".$_GET['user']."</strong> $lang[DELETED]", "", 800);
            }
            else
            {   // throw error
                print alert::draw("danger", "$lang[ERROR]", "$lang[USER] <strong>".$_GET['user']."</strong> $lang[NOT] $lang[DELETED]", "", 5800);
            }
        }
        // draw success or error message
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
<?php

// TEMPLATE WRAPPER - HEADER & breadcrumbs
echo "
    <!-- Content Wrapper. Contains page content -->
    <div class=\"content-wrapper\" id=\"content-FX\">
    <!-- Content Header (Page header) -->
    <section class=\"content-header\">";
// draw Title on top
echo backend::getTitle($lang['USERS'], $lang['USERS_SUBTEXT']);
echo"<ol class=\"breadcrumb\">
            <li><a href=\"index.php\" title=\"$lang[DASHBOARD]\"><i class=\"fa fa-dashboard\"></i> $lang[DASHBOARD]</a></li>
            <li><a href=\"index.php?page=users\" class=\"active\" title=\"$lang[USERS]\"> $lang[USERS]</a></li>
        </ol>
    </section>
    <!-- Main content -->
    <section class=\"content\">";
/* page content start here */
// \YAWK\template::checkWrapper($lang, "USERS", "USERS_SUBTEXT");
?>
<div class="box box-default">
    <div class="box-body">

<!-- btn add user -->
<a class="btn btn-success pull-right" href="index.php?page=user-new">
<i class="glyphicon glyphicon-plus"></i> &nbsp;<?php print $lang['USER+']; ?></a>
<!-- btn group settings -->
<a class="btn btn-default pull-right" href="index.php?page=user-groups">
<i class="fa fa-users"></i> &nbsp;<?php print $lang['GROUPS_SETUP']; ?></a>
<!-- btn signup plugin -->
<a class="btn btn-default pull-right" href="index.php?plugin=signup">
<i class="fa fa-plug"></i> &nbsp;<?php print $lang['SIGNUP_PLUGIN']; ?></a>

<table style="width: 100%;" cellpadding="4" cellspacing="0" border="0" class="table table-striped table-hover table-responsive" id="table-sort">
  <thead>
    <tr>
      <td style="width: 3%;"><strong>&nbsp;</strong></td>
      <td style="width: 5%;" class="text-center"><strong><?php echo $lang['ID']; ?></strong></td>
      <td style="width: 3%;"><strong>&nbsp;</strong></td>
      <td style="width: 29%;"><strong><?php echo $lang['NAME']; ?></strong></td>
      <td style="width: 10%;"><strong><?php echo $lang['GROUP']; ?></strong></td>
      <td style="width: 25%;"><strong><?php echo $lang['EMAIL']; ?></strong></td>
      <td style="width: 10%;"><strong><?php echo $lang['LAST_ONLINE']; ?></strong></td>
      <td style="width: 5%;" class="text-center"><strong><?php echo $lang['LOGINS']; ?></strong></td>
      <td style="width: 10%;" class="text-center"><strong><?php echo $lang['ACTIONS']; ?></strong></td>
    </tr>
  </thead>
  <tbody>
    <?php
    /* get all users */
    $rows = $user->getUserArray($db);
    foreach ($rows AS $row) {

      if ($row['blocked'] === '0')
        { 
          $pub = "success"; $pubtext="$lang[ACTIVE]";
         } 
        else { 
        $pub = "danger"; $pubtext = "$lang[BLOCKED]";
             }

        $userpic = user::getUserImage("backend", $row['username'], "img-circle", 25, 25);

        echo "<tr>
                <td class=\"text-center\">
                  <a title=\"toggle&nbsp;status\" href=\"index.php?page=users&toggle=1&blocked=".$row['blocked']."&uid=".$row['id']."&user=".$row['username']."\">
                    <span class=\"label label-$pub\">$pubtext</span></a>&nbsp;
                </td>
                <td class=\"text-center\">".$row['id']."</td>
                <td>$userpic</td>
                <td><a title=\"".$row['username']."\" href=\"index.php?page=user-edit&user=".$row['username']."\">
                <div style=\"width: 100%\">".$row['username']."</div></a></td>
                <td>".$row['gid']."</td>
                <td><a title=\"send Email\" href=\"index.php?page=email-new&user=".$row['username']."\">".$row['email']."</a></td>
                <td>".$row['date_lastlogin']."</td>
                <td class=\"text-center\"><a href=\"index.php?page=logins&user=".$row['username']."\" target=\"_self\" title=\"$lang[SHOW_LOGINS_OF]".$row['username']."\">".$row['login_count']."</a></td>
                
                <td class=\"text-center\">
                   <a class=\"fa fa-envelope-o\" title=\"send Email\" href=\"index.php?page=email-new&user=".$row['username']."\"></a>
                   </a>&nbsp;
                  <a class=\"fa fa-edit\" title=\"edit: ".$row['username']."\" href=\"index.php?page=user-edit&user=".$row['username']."\"></a>&nbsp;
                   
                <a class=\"fa fa-trash-o\" role=\"dialog\" data-confirm=\"Den User &laquo;$row[username]&raquo; wirklich l&ouml;schen?\"
                   title=\"$lang[DELETE]\" href=\"index.php?page=users&del=1&user=$row[username]&gid=$row[gid]&uid=$row[id]&delete=true\">
                </a>
                </td>
              </tr>";
      }
    ?>
  </tbody>
</table>

    </div>
</div>