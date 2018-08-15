<?php
// check if db obj exits
if (!isset($db) || (empty($db)))
{   // if not, create new db obj
    $db = new \YAWK\db();
}
// check if clock obj is loaded
if(!isset($clock) || (empty($clock)))
{
    // if not, include clock widget class
    require_once ('classes/clock.php');
    // create clock widget object
    $clock = new \YAWK\WIDGETS\CLOCK\CURRENT\clock($db);
}
// init current clock
$clock->init();
