<?php
require_once '../../../classes/db.php';
require_once '../../../classes/sys.php';
$db = new \YAWK\db();
echo "<pre>";
print_r($_POST);
echo "</pre>";
echo "<script>console.log('php file called!');</script>";


echo "true";
// PROCESS FORM DATA
// check required fields for valid data
// check email + email copy field
// email this booking request
// optional: check for database flag
//           + add entry to db if requested

// log booking process to syslog

// $uid = $_POST['uid'];
// SET NOTIFICATION STATUS TO SEEN
/*
if ($db->query("UPDATE {syslog} SET seen = '1' WHERE seen = '0'"))
{   // success
    echo "true";
}
else
{   // q failed
    echo "false";
    // echo \YAWK\alert::draw("warning","Warning!", "Could not set notification status. Please try again.",'',4200);
}
*/