<?php
if (!isset($_POST['token'])) {
    die ('no direct access allowed.');
}
else if ($_POST['token'] != "U3E44ERG0H0M3") {
    die ('no direct access allowed!');
}

include '../../../classes/db.php';
include '../../../classes/sys.php';
include '../../../classes/user.php';
include '../../../classes/alert.php';

/* set database object */
if (!isset($db)) {
    $db = new \YAWK\db();
}
$msg_date	= 	date("Y-m-d H:i:s");
$msg_to		=	$_POST['msg_to'];
$msg_body	=	$_POST['msg_body'];
$fromUID    =   $_POST['fromUID'];

$toUID = \YAWK\user::getUserIdFromName($db, $msg_to);

// remove HTML tags for security reasons
// $msg_body = str_replace("\n", "<br>", $msg_body);
// remove special chars
$msg_body = \YAWK\sys::encodeChars($msg_body);
$msg_body = nl2br($msg_body);
$msg_body = utf8_encode($msg_body);

$sql = "INSERT INTO {plugin_msg} (msg_date, fromUID, toUID, msg_body)
					 VALUES('$msg_date', '$fromUID', '$toUID', '$msg_body')";
if ($db->query($sql)){

    echo"<div id=\"msg_success\" class=\"animated lightSpeedIn\">
                    <h2><i class=\"fa fa-check\"></i> &nbsp;Nachricht erfolgreich zugestellt!</h2>
                      </div>";

}
else {
    echo \YAWK\alert::draw("danger", "Fehler!", "Es tut uns leid, die Nachricht konnte leider nicht abgeschickt werden.","",4200);
}