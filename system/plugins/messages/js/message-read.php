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
{   // create db object if not exists...
    $db = new \YAWK\db();
}

$msg_id 	=	$_POST['msg_id'];

    if ($db->query("UPDATE {plugin_msg} SET msg_read='1' WHERE msg_id='".$msg_id."'"))
    {
        echo "message marked as unread";
    }
    else
    {
        die ("failed to mark as unread");
    }
