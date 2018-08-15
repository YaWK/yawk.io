<?php
// check if db obj exits
if (!isset($db) || (empty($db)))
{   // if not, create new db obj
    $db = new \YAWK\db();
}
// check if chaturbate obj is set
if(!isset($chaturbate) || (empty($chaturbate)))
{   // include chaturbate class
    require_once ('classes/chaturbate.php');
    // create chaturbate widget object
    $chaturbate = new \YAWK\WIDGETS\CHATURBATE\STREAM\chaturbate($db);
}
// embed chaturbate video stream
$chaturbate->init();
