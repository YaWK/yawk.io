<?php
/** @var $db \YAWK\db */
if (!isset($twitch))
{   // load twitch widget class
    require_once 'classes/twitch.php';
    // create new twitch widget object
    $twitch = new \YAWK\WIDGETS\TWITCH\EMBED\twitch($db);
}
// init twitch widget
$twitch->init();
