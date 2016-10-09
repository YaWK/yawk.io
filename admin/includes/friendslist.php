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

echo "<script type=\"text/javascript\">

        function acceptFriend(id, uid, requestUsername, sessionUID) {
            // var uid = $('#acceptBtn').attr('data-requestUsername');//Attribut auslesen und in variable speichern
            $.ajax({    // do ajax request
            url:'js/accept-friend.php',
            type:'post',
            data:'uid='+uid+'&requestUsername='+requestUsername+'&sessionUID='+sessionUID,
            success:function(data){
                if(! data ){
                    alert('Something went wrong!');
                    return false;
                }
                else {
                    $(data).hide().prependTo('#btnRow');
                    requestRow = '#requestRow'+id;
                    disconnectBtn = '#disconnectBtn'+id;
                    declineBtn = '#declineBtn'+id;
                    acceptBtn = '#acceptBtn'+id;
                        $(acceptBtn).fadeOut(320);
                        $(declineBtn).fadeOut(320);
                        $(disconnectBtn).fadeIn(820);
                }
            }
        });
        }

        function declineFriend(id, uid, requestUsername, sessionUID) {
            // var uid = $('#acceptBtn').attr('data-requestUsername');//Attribut auslesen und in variable speichern
            $.ajax({    // do ajax request
            url:'js/decline-friend.php',
            type:'post',
            data:'id='+id+'&uid='+uid+'&requestUsername='+requestUsername+'&sessionUID='+sessionUID,
            success:function(data){
                if(! data ){
                    alert('Something went wrong!');
                    return false;
                }
                else {
                    $(data).hide().prependTo('#btnRow');
                    requestRow = '#requestRow'+id;
                    disconnectBtn = '#disconnectBtn'+id;
                    declineBtn = '#declineBtn'+id;
                    acceptBtn = '#acceptBtn'+id;
                        $('#acceptBtn').fadeOut(320);
                        $('#declineBtn').fadeOut(320);
                        $('#disconnectBtn').fadeIn(820);
                        $(requestRow).fadeOut(420);
                }
            }
        });
        }

            function disconnectFriend(id, friendUID, requestUsername, sessionUID)
            {
                $.ajax({    // do ajax request
                url:'js/disconnect-friend.php',
                type:'post',
                //    data:'name='+name+'&comment='+comment+'&id='+id,
                data:'id='+id+'&friendUID='+friendUID+'&requestUsername='+requestUsername+'&sessionUID='+sessionUID,
                success:function(data){
                    if(! data ){
                        alert('Something went wrong!');
                        return false;
                    }
                    else {
                        $(data).hide().prependTo('#friendBtn');
                        $('#unfriendBtn').hide(800);
                        $('#friendBtn').show();
                    }
                }
                });
                $('#friendsRow'+friendUID).fadeOut(420);
            }

            </script>";
?>
<?php
// TEMPLATE WRAPPER - HEADER & breadcrumbs
echo "
    <!-- Content Wrapper. Contains page content -->
    <div class=\"content-wrapper\" id=\"content-FX\">
    <!-- Content Header (Page header) -->
    <section class=\"content-header\">";
/* draw Title on top */
echo \YAWK\backend::getTitle($lang['FRIENDS'], $lang['FRIENDS_SUBTEXT']);
echo"<ol class=\"breadcrumb\">
            <li><a href=\"index.php\" title=\"Dashboard\"><i class=\"fa fa-dashboard\"></i> Dashboard</a></li>
            <li><a href=\"index.php?page=users\" title=\"Users\"> Users</a></li>
            <li><a href=\"index.php?page=friendslist\" class=\"active\" title=\"Friendslist\"> Friends</a></li>
        </ol>
    </section>
    <!-- Main content -->
    <section class=\"content\">";
/* page content start here */

// check if parameter UID is set
if (isset($_GET['uid']))
{   // if it's set load friends for given user id
    $my_friends = \YAWK\user::getMyFriends($db, $_GET['uid'], 1);
    $param_uid = 1;
    $user = \YAWK\user::getUserNameFromID($db, $_GET['uid']);
    $friends_title = "Friends of $user";
}
else
{   // otherwise, load friendlist for logged-in user
    $my_friends = \YAWK\user::getMyFriends($db, $_SESSION['uid'], 1);
    $param_uid = 0;
    $friends_title = "Your friends";
}
?>
<!-- btn clear log -->
<a class="btn btn-success pull-right" href="index.php?page=syslog&clear=1">
    <i class="fa fa-trash-o"></i> &nbsp;<?php print $lang['SYSLOG_CLEAR']; ?></a>

<div class="box box-default">
    <div class="box-header with-border">
        <h3 class="box-title"><?php echo $friends_title; ?></h3>
    </div>
    <div class="box-body">
        <table width="100%" cellpadding="4" cellspacing="0" border="0" class="table table-hover" id="table-sort">
            <thead>
            <tr>
                <td width="5%" class="text-right">&nbsp;</td>
                <td width="20%"><strong>My Friend</strong></td>
                <td width="5%" class="text-center"><strong>Friendship</strong></td>
                <td id="since" width="10%" class="text-center"><strong>since</strong></td>
            </tr>
            </thead>
            <tbody>
            <?PHP

            // select friend requests
            $request_friends = \YAWK\user::getMyFriends($db, $_SESSION['uid'], 0);
            // prepare vars
            $friend = '';
            $friendB = '';
            $friendUID = '';

            // SHOW REQUESTS
            // loop through friendship requests array
            foreach ($request_friends AS $request)
            {   // format datetime
                $time_ago = \YAWK\sys::time_ago($request['requestDate']);
                if ($request['friendA'] !== $_SESSION['uid'])
                {
                    $friendUID = $request['friendA'];
                }
                if ($request['friendB'] !== $_SESSION['uid'])
                {
                    $friendUID = $request['friendB'];
                }
                $friend_username = \YAWK\user::getUserNameFromID($db, $friendUID);

                // prepare social buttons (accept, decline, disconnect)
                if ($request['confirmed'] === '0')
                {
                    $acceptBtn = "<button id=\"acceptBtn$request[id]\" onclick=\"acceptFriend('$request[id]','$friendUID', '$friend_username', '$_SESSION[uid]')\" class=\"btn btn-success\" title=\"accept\"><i class=\"fa fa-check\"></i> </button>";
                    $declineBtn = "<button id=\"declineBtn$request[id]\" onclick=\"declineFriend('$request[id]', '$friendUID', '$friend_username', '$_SESSION[uid]')\" class=\"btn btn-warning\" title=\"decline\"><i class=\"fa fa-ban\"></i> </button>";
                    $disconnectBtn = "<button id=\"disconnectBtn$request[id]\" data-requestUID=\"$friendUID\" style=\"display: none;\" class=\"btn btn-danger\" title=\"disconnect friendship\"><i class=\"fa fa-times-circle\"></i> </button>";

                    if ($_SESSION['uid'] == $request['friendA'])
                    {   // request sent info btn
                        $acceptBtn = "<button id=\"acceptBtn$request[id]\" class=\"btn btn-default\" disabled aria-disabled='true'>request sent...</button>";
                        // $declineBtn = '';
                    }
                }
                else
                {
                    $friendBtn = '';
                }

                if ($request['aborted'] != '1')
                {
                    echo "<tr id=\"requestRow$request[id]\">
                    <td style=\"display:block; text-align: right\"><a href=\"index.php?page=user-edit&user=$friend_username\">"; echo \YAWK\user::getUserImage("backend", $friend_username, "img-circle", 50, 50); echo "</a></td>
                    <td style=\"display:block;\"><b><a href=\"index.php?page=user-edit&user=$friend_username\">".$friend_username."</a></b></td>
                    <td id=\"btnRow\" class=\"text-center\">".$acceptBtn."&nbsp;".$disconnectBtn."&nbsp;".$declineBtn."</td>
                    <td id=\"since\" class=\"text-center\">".$time_ago."</td>
                    </tr>";
                }
            }

            // SHOW FRIENDS
            // loop through friends array
            foreach ($my_friends AS $friend)
            {   // calculate time ago view
                $time_ago = \YAWK\sys::time_ago($friend['confirmDate']);
                // PREPARE FRIENDS FOR LIST
                if (isset($param_uid) && $param_uid === 1)
                {   // prepare friendslist for given UID
                    if ($friend['friendA'] !== $_GET['uid'])
                    {
                        $friendUID = $friend['friendA'];
                    }
                    if ($friend['friendB'] !== $_GET['uid'])
                    {
                        $friendUID = $friend['friendB'];
                    }
                }
                else
                {   // preprare friendslist for logged in user (session uid)
                    if ($friend['friendA'] !== $_SESSION['uid'])
                    {
                        $friendUID = $friend['friendA'];
                    }
                    if ($friend['friendB'] !== $_SESSION['uid'])
                    {
                        $friendUID = $friend['friendB'];
                    }
                }

                $friend_username = \YAWK\user::getUserNameFromID($db, $friendUID);

                if ($friend['confirmed'] === '1')
                {   // check if this is YOUR friendslist (logged in user)
                    // hide control button if its NOT your list
                    if (isset($_GET['uid']) && (!empty($_GET['uid'])))
                    {   // GET UID is sent, that means this is NOT logged in users friendslist
                        $disconnectBtn = ''; // display no button
                    }
                    else if ($friendUID != $_SESSION['uid'])
                    {   // otherwise: disconnect control button
                        $disconnectBtn = "<button id=\"disconnectFriendBtn$friend[id]\" onclick=\"disconnectFriend('$friend[id]', '$friendUID', '$friend_username', '$_SESSION[uid]')\" class=\"btn btn-danger\" title=\"disconnect friendship\"><i class=\"fa fa-times-circle\"></i> </button>";
                    }
                    else
                    {   // in any other case, no controls.
                        $disconnectBtn = '';
                    }
                }
                else
                {
                    $disconnectBtn = '';
                }

                echo "<tr id=\"friendsRow$friendUID\">
                <td class=\"text-right\"><a href=\"index.php?page=user-edit&user=$friend_username\"><div style=\"width:100%\"> "; echo \YAWK\user::getUserImage("backend", $friend_username, "img-circle", 50, 50); echo "</a></div></td>
                <td><b><a href=\"index.php?page=user-edit&user=$friend_username\"><div style=\"width:100%\">".$friend_username."</div></a></b></td>
                <td class=\"text-center\">".$disconnectBtn."</td>
                <td id=\"since\" class=\"text-center\">".$time_ago."</td>
              </tr>";
            }
            ?>
            </tbody>
        </table>
    </div></div>