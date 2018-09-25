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
// prepare vars
$id = $_POST['id'];
$uid = $_POST['uid'];
$requestUsername = $_POST['requestUsername'];
$sessionUID = $_POST['sessionUID'];
$sessionUsername = \YAWK\user::getUserNameFromID($db, $sessionUID);
// SET friendship status to confirmed
if ($sql = $db->query("UPDATE {friends} SET aborted = '1' WHERE id='".$id."'"))
{   // success
    echo "friendship declined";
}
else
{   // q failed
    echo \YAWK\alert::draw("warning","Warning!", "Could not decline friendship status. Please try again.",'',4200);
}
// NOTIFY + SYSLOG ENTRY
// \YAWK\sys::setNotification($db, 3, "$sessionUsername declined your friendship request.", $sessionUID, $uid, 0, 0);
\YAWK\sys::setNotification($db, 3, 0, $sessionUID, $uid, 0, 0,0);
\YAWK\sys::setSyslog($db, 17, 0, "$sessionUsername declined friendship with $requestUsername", $uid, $sessionUID, 0, 0);
