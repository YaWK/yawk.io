<?php
/*
if (!isset($_POST['token'])) {
    die ('no direct access allowed.');
}
else if ($_POST['token'] != "U3E44ERG0H0M3") {
    die ('no direct access allowed!');
}
*/
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
if ($sql = $db->query("SELECT id FROM {follower} WHERE follower = '".$uid."' AND hunted = '".$hunted."'"))
{   // if user is already following each other...
    if ($res = mysqli_fetch_row($sql))
    {   // already exists
        if ($sql = $db->query("DELETE FROM {follower} WHERE follower = '".$uid."' AND hunted = '".$hunted."'"))
        {   // un-followd with user
            \YAWK\sys::setSyslog($db, 17, 0, "$userA un-followed $userB.", $uid, $hunted, 0, 0);
            // \YAWK\sys::setNotification($db, 3, "$userA do not follow you anymore.", $uid, $hunted, 0, 0);
            \YAWK\sys::setNotification($db, 3, 0, $uid, $hunted, 0, 0,0);
            \YAWK\alert::draw("warning","Disconnected with $userB", "You are not following $userB anymore.","",4200);
        }
    }
    else
    {   // user is not in db, follow now:
        if ($db->query("INSERT INTO {follower} (follower, hunted) VALUES ('$uid', '$hunted')"))
        {   // follow successful
            \YAWK\sys::setSyslog($db, 17, 0, "$userA follows $userB.", $uid, $hunted, 0, 0);
            // \YAWK\sys::setNotification($db, 3, "$userA follows you.", $uid, $hunted, 0, 0);
            \YAWK\sys::setNotification($db, 3, 0, $uid, $hunted, 0, 0,0);
            echo \YAWK\alert::draw("success", "You follow $userB from now.", "Good to keep your network up :)","",4200);
        }
        else
        {   // follow not successful
            echo \YAWK\alert::draw("warning", "Error!", "A database error occured, your request could not be done. Please try again.","",4200);
        }
    }
}
else
    {   // follow not successful
        echo \YAWK\alert::draw("danger", "Error!", "Some kind of error happened to the database. Please try again.","",4200);
    }
