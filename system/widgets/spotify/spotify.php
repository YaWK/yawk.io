<?php
/** @var $db \YAWK\db */
if (!isset($spotify))
{   // load spotify widget class
    require_once 'classes/spotify.php';
    // create new spotify widget object
    $spotify = new \YAWK\WIDGETS\SPOTIFY\EMBED\spotify($db);
}
// init spotify widget
$spotify->init();