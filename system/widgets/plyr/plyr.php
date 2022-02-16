<?php
/** @var $db \YAWK\db */
if (!isset($plyrPlayer))
{   // load plyr widget class
    require_once 'classes/plyr.php';
    // create new plyr player object
    $plyrPlayer = new \YAWK\WIDGETS\PLYR\PLAYER\plyr($db);
}
// init plyr player widget
$plyrPlayer->init();