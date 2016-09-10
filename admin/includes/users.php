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
echo \YAWK\backend::getTitle($lang['USERS'], $lang['USERS_SUBTEXT']);
echo"<ol class=\"breadcrumb\">
            <li><a href=\"index.php\" title=\"Dashboard\"><i class=\"fa fa-dashboard\"></i> Dashboard</a></li>
            <li><a href=\"index.php?page=users\" class=\"active\" title=\"Users\"> Users</a></li>
        </ol>
    </section>
    <!-- Main content -->
    <section class=\"content\">";
/* page content start here */
?>

<!-- btn add user -->
<a class="btn btn-success pull-right" href="index.php?page=user-new">
<i class="glyphicon glyphicon-plus"></i> &nbsp;<?php print $lang['USER+']; ?></a>
<!-- btn group settings -->
<a class="btn btn-default pull-right" href="index.php?page=user-groups">
<i class="fa fa-users"></i> &nbsp;<?php print $lang['GROUPS_SETUP']; ?></a>
<!-- btn signup plugin -->
<a class="btn btn-default pull-right" href="index.php?plugin=signup">
<i class="fa fa-plug"></i> &nbsp;<?php print $lang['SIGNUP']; ?></a>

<table width="100%" cellpadding="4" cellspacing="0" border="0" class="table table-hover" id="table-sort">
  <thead>
    <tr>
      <td width="3%"><strong>&nbsp;</strong></td>
      <td width="5%" class="text-center"><strong>ID</strong></td>
      <td width="3%"><strong>&nbsp;</strong></td>
      <td width="29%"><strong>Name</strong></td>
      <td width="10%"><strong>Gruppe</strong></td>
      <td width="25%"><strong>Email</strong></td>
      <td width="10%"><strong>zuletzt online</strong></td>
      <td width="5%" class="text-center"><strong>Logins</strong></td>
      <td width="10%" class="text-center"><strong>Aktionen</strong></td>
    </tr>
  </thead>
  <tbody>
    <?PHP
    /* get all users */
    $rows = $user->getUserArray($db);
    foreach ($rows AS $row) {

      if ($row['blocked'] === '0')
        { 
          $pub = "success"; $pubtext="On";
         } 
        else { 
        $pub = "danger"; $pubtext = "Off";
             }

        $userpic = \YAWK\user::getUserImage("backend", $row['username'], "img-circle", 25, 25);

        echo "<tr>
                <td class=\"text-center\">
                  <a title=\"toggle&nbsp;status\" href=\"index.php?page=user-toggle&blocked=".$row['blocked']."&uid=".$row['id']."&user=".$row['username']."\">
                    <span class=\"label label-$pub\">$pubtext</span></a>&nbsp;
                </td>
                <td class=\"text-center\">".$row['id']."</td>
                <td>$userpic</td>
                <td><a title=\"".$row['username']."\" href=\"index.php?page=user-edit&user=".$row['username']."\">
                <div style=\100%\">".$row['username']."</div></a></td>
                <td>".$row['gid']."</td>
                <td><a title=\"send Email\" href=\"index.php?page=email-new&user=".$row['username']."\">".$row['email']."</a></td>
                <td>".$row['date_lastlogin']."</td>
                <td class=\"text-center\">".$row['login_count']."</td>
                
                <td class=\"text-center\">
                   <a class=\"fa fa-envelope-o\" title=\"send Email\" href=\"index.php?page=email-new&user=".$row['username']."\"></a>
                   </a>&nbsp;
                  <a class=\"fa fa-edit\" title=\"edit: ".$row['username']."\" href=\"index.php?page=user-edit&user=".$row['username']."\"></a>&nbsp;
                   
                  <a class=\"fa fa-trash-o\" data-confirm=\"Den User &laquo;".$row['username']." wirklich l&ouml;schen?\" 
                     href=\"index.php?page=user-delete&user=".$row['username']."&gid=".$row['gid']."&uid=".$row['id']."\">
                   </a>
                </td>
              </tr>";
      }
    ?>
  </tbody>
</table>