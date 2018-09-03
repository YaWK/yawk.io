<?php
/** @var $db \YAWK\db */
if (!isset($pinterestFollow))
{   // load pinterest widget class
    require_once 'classes/pinterest_follow.php';
    // create new gallery widget object
    $pinterestFollow = new \YAWK\WIDGETS\PINTEREST\FOLLOW\pinterestFollow($db);
}
// init pinterest widget
$pinterestFollow->init();