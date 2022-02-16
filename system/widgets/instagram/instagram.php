<?php
/** @var $db \YAWK\db */
// check if Instagram object is set
if (!isset($instagram))
{   // load instagram widget class
    require_once 'classes/instagram.php';
    // create new instagram widget object
    $instagram = new \YAWK\WIDGETS\INSTAGRAM\POSTING\instagram($db);
}
// embed instagram posting
$instagram->init();