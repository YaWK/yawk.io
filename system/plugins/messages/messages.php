<?php
include 'system/plugins/messages/classes/messages.php';
$messages = new \YAWK\PLUGINS\MESSAGES\messages();
echo $messages->init($db);
