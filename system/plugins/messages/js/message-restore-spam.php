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
if ($db->query("UPDATE {plugin_msg} SET msg_read='1', trash='0', spam='0' WHERE msg_id = '".$msg_id."'"))
{
    echo "message trashed";
}
else
{
    echo \YAWK\alert::draw("warning", "Ooops, Sorry!", "Could not restore message from spamfolder. Please try again.","",2000);
}