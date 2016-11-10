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

$id = $_POST['id'];
// SET NOTIFICATION STATUS TO SEEN
if ($sql = $db->query("UPDATE {syslog} SET seen = '1' WHERE id = '".$id."'"))
{   // success
    echo "notification status set";
}
else
{   // q failed
    echo \YAWK\alert::draw("warning","Warning!", "Could not set notification status. Please try again.",'',4200);
}
