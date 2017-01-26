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
echo \YAWK\backend::getTitle($lang['FOLLOWERS'], $lang['FOLLOWERS_SUBTEXT']);
echo"<ol class=\"breadcrumb\">
            <li><a href=\"index.php\" title=\"$lang[DASHBOARD]\"><i class=\"fa fa-dashboard\"></i> $lang[DASHBOARD]</a></li>
            <li><a href=\"index.php?page=users\" title=\"$lang[USERS]\"> $lang[USERS]</a></li>
            <li><a href=\"index.php?page=list-follower\" class=\"active\" title=\"$lang[FOLLOWER]\"> $lang[FOLLOWER]</a></li>
        </ol>
    </section>
    <!-- Main content -->
    <section class=\"content\">";
/* page content start here */

// check if parameter UID is set
if (isset($_GET['uid']))
{   // if it's set load friends for given user id
    $my_follower = \YAWK\user::getMyFollower($db, $_GET['uid']);
    $user = \YAWK\user::getUserNameFromID($db, $_GET['uid']);
    $follower_title = "$lang[FOLLOWERS_OF] $user";
}
else
{   // otherwise, load friendlist for logged-in user
    $my_follower = \YAWK\user::getMyFollower($db, 0);
    $follower_title = $lang['YOUR_FOLLOWERS'];
}
?>
<!-- btn clear log -->
<a class="btn btn-success pull-right" href="index.php?page=friendslist">
    <i class="fa fa-users-o"></i> &nbsp;<?php print $lang['FRIENDS']; ?></a>

<div class="box box-default">
    <div class="box-header with-border">
        <h3 class="box-title"><?php echo $follower_title; ?></h3>
    </div>
    <div class="box-body">
        <table width="100%" cellpadding="4" cellspacing="0" border="0" class="table table-hover" id="table-sort">
            <thead>
            <tr>
                <td width="15%">&nbsp;</td>
                <td width="65%"><strong><?php echo $lang['MY_FOLLOWERS']; ?></strong></td>
                <td id="since" width="20%" class="text-center"><strong><?php echo $lang['SINCE']; ?></strong></td>
            </tr>
            </thead>
            <tbody>
            <?php
            foreach ($my_follower AS $follower)
            {
                $time_ago = \YAWK\sys::time_ago($follower['requestDate'], $lang);
                echo "<tr>
                        <td class=\"text-right\">"; echo \YAWK\user::getUserImage("backend", $follower['username'], "img-circle", 25, 25); echo "</a></td>
                        <td><b><a style=\"display: block;\" href=\"index.php?page=user-edit&user=$follower[username]\">$follower[username]</a></b></td>
                        <td class=\"text-center\">$time_ago</td>
                      </tr>";
            }
            ?>
            </tbody>
        </table>
    </div></div>