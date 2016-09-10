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

$type 	=	$_POST['type'];

echo "HUHU!!! $type";
exit;

// FETCH DATA
if ($type === "all"){
    $sql = mysqli_query($connection, "SELECT * FROM"." ".$dbprefix."plugin_msg WHERE msg_to = '".$username."' AND trash ='0' AND spam ='0' ORDER BY msg_read,msg_date DESC");
}
elseif ($type === "trash"){
    $sql = mysqli_query($connection, "SELECT * FROM"." ".$dbprefix."plugin_msg WHERE msg_to = '".$username."' AND trash ='1' AND spam ='0' ORDER BY msg_read,msg_date DESC");
}
elseif ($type === "spam"){
    $sql = mysqli_query($connection, "SELECT * FROM"." ".$dbprefix."plugin_msg WHERE msg_to = '".$username."' AND trash ='0' AND spam ='1' ORDER BY msg_read,msg_date DESC");
}
$messages = array();
while ($row = mysqli_fetch_assoc($sql)){
    $messages[] = $row;
}
return $messages;
}
else {
    return "Something strange has happened. Are you logged in? Please re-login.";
}