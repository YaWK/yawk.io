<?php
// check if db obj exits
if (!isset($db) || (empty($db)))
{   // if not, create new db obj
    $db = new \YAWK\db();
}
// check if bubbleus obj is loaded
if(!isset($bubblus) || (empty($bubblus)))
{   // include bubblUS widget class
    require_once ('classes/bubblus.php');
    // create bubblUs widget object
    $bubblus = new \YAWK\WIDGETS\BUBBLUS\MINDMAP\bubblus($db);
}
// embed bubblUs mindmap
$bubblus->init();
