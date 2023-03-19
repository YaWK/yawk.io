<?php
use YAWK\update;
include '../../system/classes/update.php';
// prepare vars
$update = new update();
$updateFilebase = $update->readUpdateFilebaseFromServer();
echo "<pre>";
print_r($updateFilebase);
echo "</pre>";
