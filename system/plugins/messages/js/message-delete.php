<?php
/*
if (!isset($_POST['token'])) {
    die ('no direct access allowed.');
}
else if ($_POST['token'] != "U3E44ERG0H0M3") {
    die ('no direct access allowed!');
}
*/
include '../../../classes/db.php';
include '../../../classes/alert.php';
include '../classes/messages.php';

/* set database object */
if (!isset($db))
{   // create new db object
    $db = new \YAWK\db();
}

$msg_id = $_POST['msg_id'];

// UPDATE STATEMENT
if ($db->query("DELETE FROM {plugin_msg} WHERE msg_id = '".$msg_id."'"))
{
    echo "message deleted";
}
else
{
    echo \YAWK\alert::draw("danger", "Ooops, Sorry!", "Could not delete message, please try again.","",2000);
}