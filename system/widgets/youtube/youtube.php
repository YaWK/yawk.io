<?php
// create new db conn if none is set
if (!isset($db) || (empty($db)))
{   // establish new db connection
    $db = new \YAWK\db();
}
// include youtube widget class
require_once ('classes/youtube.php');
// create youtube widget object
$youtube = new \YAWK\WIDGETS\YOUTUBE\VIDEO\youtube($db);
// draw obj data on screen
$youtube->embedVideo();
