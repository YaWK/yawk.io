<?php
// check if db obj exits
if (!isset($db) || (empty($db)))
{   // if not, create new db obj
    $db = new \YAWK\db();
}
// check if soundcloud player obj is loaded
if(!isset($soundcloud) || (empty($soundcloud)))
{
    // if not, include soundcloud widget class
    require_once ('classes/soundcloud.php');
    // create soundcloud player widget object
    $soundcloud = new \YAWK\WIDGETS\SOUNDCLOUD\PLAYER\soundcloud($db);
}
// init current soundcloud player
$soundcloud->init();
