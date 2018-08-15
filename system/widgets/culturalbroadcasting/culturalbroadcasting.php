<?php
// check if db obj exits
if (!isset($db) || (empty($db)))
{   // if not, create new db obj
    $db = new \YAWK\db();
}
// check if cba obj is loaded
if(!isset($culturalBroadcastingArchive) || (empty($culturalBroadcastingArchive)))
{
    // if not, include cba widget class
    require_once ('classes/culturalbroadcasting.php');
    // create cba widget object
    $culturalBroadcastingArchive = new \YAWK\WIDGETS\CULTURALBROADCASTING\STREAM\culturalBroadcastingArchive($db);
}
// init cba podcast player
$culturalBroadcastingArchive->init();
