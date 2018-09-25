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
$uid = $_POST['uid'];
$requestUsername = $_POST['requestUsername'];
$sessionUID = $_POST['sessionUID'];
$sessionUsername = \YAWK\user::getUserNameFromID($db, $sessionUID);
// SET friendship status to confirmed
$now = \YAWK\sys::now();
if ($sql = $db->query("UPDATE {friends} SET confirmed = '1', confirmDate = '".$now."'
                       WHERE confirmed='0' AND friendB = '".$uid."' AND friendA = '".$sessionUID."'
                       OR confirmed = '0' AND friendA = '".$uid."' AND friendB = '".$sessionUID."'"))
{   // success
    echo "friendship confirmed";
}
else
{   // q failed
    echo \YAWK\alert::draw("warning","Warning!", "Could not confirm friendship status. Please try again.",'',4200);
}
// NOTIFY + SYSLOG ENTRY
// \YAWK\sys::setNotification($db, 3, "$sessionUsername accepted your friendship request.", $sessionUID, $uid, 0, 0);
\YAWK\sys::setNotification($db, 3, 0, $sessionUID, $uid, 0, 0,0);
\YAWK\sys::setSyslog($db, 17, 0, "$sessionUsername is now friend with $requestUsername", $uid, $sessionUID, 0, 0);
