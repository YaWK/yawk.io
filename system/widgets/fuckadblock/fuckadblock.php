<?php
// check if db obj exits
if (!isset($db) || (empty($db)))
{   // if not, create new db obj
    $db = new \YAWK\db();
}
// check if fuckAdBlock obj is loaded
if(!isset($fuckAdBlock) || (empty($fuckAdBlock)))
{
    // if not, include fuckAdBlock widget class
    require_once ('classes/fuckadblock.php');
    // create fuckAdBlock widget object
    $fuckAdBlock = new \YAWK\WIDGETS\FUCKADBLOCK\BLOCK\fuckAdBlock($db);
    $fuckAdBlock->init();
}
