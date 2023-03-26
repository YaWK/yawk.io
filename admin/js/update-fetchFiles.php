<?php
use YAWK\update;
include '../../system/classes/update.php';
// prepare vars
// generate new update object
$update = new update();
$update->fetchFiles();