<?php
session_start();
include '../../../classes/db.php';
include '../../../classes/alert.php';
include '../../../classes/sys.php';
 if (!isset($db) || (empty($db)))
 {
     $db = new \YAWK\db();
 }
$email		=	$_POST['email'];
if (!isset($_POST['email']) || (empty($_POST['email'])))
{
    $email = "unknown";
}
$now		= 	date("Y-m-d H:i:s");

// $name = strip_tags($name);
$email = strip_tags($email);
// $name = mysqli_real_escape_string($db, $name);
$email = $db->quote($email);

        if ($db->query("INSERT INTO {newsletter} (date_created, email) VALUES('".$now."', '".$email."')"))
        {
            echo "true";
        }
