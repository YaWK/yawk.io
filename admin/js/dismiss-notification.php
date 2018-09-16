<?php
require_once '../../system/classes/db.php';
require_once '../../system/classes/sys.php';
$db = new \YAWK\db();
$uid = $_POST['uid'];
// SET NOTIFICATION STATUS TO SEEN
if ($db->query("UPDATE {syslog} SET seen = '1' WHERE seen = '0'"))
{   // success
    \YAWK\sys::setSyslog($db, 3, "DB ENTRY MADE!", 0, 0, 0, 0);
    echo "true";
}
else
{   // q failed
    \YAWK\sys::setSyslog($db, 3, "DB ENTRY NOT!! MADE!", 0, 0, 0, 0);
    echo "false";
    // echo \YAWK\alert::draw("warning","Warning!", "Could not set notification status. Please try again.",'',4200);
}
