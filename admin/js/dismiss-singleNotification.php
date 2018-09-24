<?php
require_once '../../system/classes/db.php';
require_once '../../system/classes/sys.php';
$db = new \YAWK\db();
$id = $_POST['id'];
// SET NOTIFICATION STATUS TO SEEN
if ($db->query("UPDATE {syslog} SET seen = '1' WHERE log_id = '$id'"))
{   // success
    echo "true";
}
else
{   // q failed
    echo "false";
    // echo \YAWK\alert::draw("warning","Warning!", "Could not set notification status. Please try again.",'',4200);
}
