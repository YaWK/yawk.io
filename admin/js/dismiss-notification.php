<?php
include '../../system/classes/db.php';
include '../../system/classes/sys.php';
include '../../system/classes/user.php';
include '../../system/classes/alert.php';

/* set database object */
if (!isset($db))
{   // create new db object
    $db = new \YAWK\db();
}

$uid = $_POST['uid'];
// SET NOTIFICATION STATUS TO SEEN
if ($sql = $db->query("UPDATE {notifications} SET seen = '1' WHERE toUID = '".$uid."'"))
{   // success
    echo "notification status set";
}
else
{   // q failed
    echo \YAWK\alert::draw("warning","Warning!", "Could not set notification status. Please try again.",'',4200);
}
// SET SYSLOG STATUS TO SEEN
if ($sql = $db->query("UPDATE {syslog} SET seen = '1'"))
{   // success
    echo "syslog status set";
}
else
{   // q failed
    echo \YAWK\alert::draw("warning","Warning!", "Could not set syslog status. Please try again.",'',4200);
}
