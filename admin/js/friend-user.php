<?php
include '../../system/classes/db.php';
include '../../system/classes/sys.php';
include '../../system/classes/user.php';
include '../../system/classes/alert.php';
include '../../system/classes/settings.php';

/* set database object */
if (!isset($db))
{   // create new db object
    $db = new \YAWK\db();
}

$uid = $_POST['uid'];
$hunted = $_POST['hunted'];
$userB = $_POST['user'];
$userA = \YAWK\user::getUserNameFromID($db, $uid);

// check if uid follows hunted already
if ($sql = $db->query("SELECT id FROM {friends}
                       WHERE friendA = '".$uid."' AND friendB = '".$hunted."'
                       OR friendA = '".$hunted."' AND friendB = '".$uid."'
                       AND confirmed = '1'
                       AND aborted NOT LIKE '1'"))
{   // if users are friends...
    $res = mysqli_fetch_row($sql);
    if ($res[0] === true )
    {   // already friends
        if ($sql = $db->query("DELETE FROM {friends}
                       WHERE confirmed = '1' AND friendA = '".$uid."' AND friendB = '".$hunted."'
                       OR confirmed = '1' AND friendA = '".$hunted."' AND friendB = '".$uid."'"))
        {   // un-followd with user
            \YAWK\sys::setSyslog($db, 17, 0, "$userA un-friended $userB.", $uid, $hunted, 0, 0);
            // \YAWK\sys::setNotification($db, 3, "$userA un-friended you.", $uid, $hunted, 0, 0);
            \YAWK\sys::setNotification($db, 3, 0, "$userA un-friended you.", $uid, $hunted, 0, 0);
            \YAWK\alert::draw("danger","Disconnected with $userB", "You are not friend with $userB anymore.","",4200);
        }
    }
    else
    {   // user is not in db, follow now:
        if ($sql = $db->query("INSERT INTO {friends} (friendA, friendB) VALUES ('$uid', '$hunted')"))
        {   // put data into logfile
            \YAWK\sys::setSyslog($db, 17, 0,"$userA asked $userB for friendship", $uid, $hunted, 0, 0);
            /*
            \YAWK\sys::setNotification($db, 3, "<b>$userA</b> wants to be your friend<br>
                                            <b><i class=\"fa fa-check-circle-o text-green\"> </i>&nbsp;&nbsp;
                                            <i class=\"fa fa-times-circle-o text-red\"> </i></b>", $uid, $hunted, 0, 0);
             */
            \YAWK\sys::setNotification($db, 3, 0, $uid, $hunted, 0, 0, 0);

            // throw success alert
            echo \YAWK\alert::draw("success", "You sent a friend request to $userB.", "Now you can take a cup of tea and... wait until $userB responds.","",4200);
        }
        else
        {   // follow not successful, throw alert
            echo \YAWK\alert::draw("warning", "Error!", "A database error occured, your request could not be sent. Please try again.","",4200);
        }
    }
}
else
{   // follow not successful
    echo \YAWK\alert::draw("danger", "Error!", "Some kind of error happened to the database. Please try again.","",4200);
}
