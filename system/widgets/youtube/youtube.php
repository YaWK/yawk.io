<?php
// check if db obj exits
if (!isset($db) || (empty($db)))
{   // if not, create new db obj
    $db = new \YAWK\db();
}
// check if youtube obj is loaded
if(!isset($youtube) || (empty($youtube)))
{
    // if not, include yt widget class
    require_once ('classes/youtube.php');
    // create yt widget object
    $youtube = new \YAWK\WIDGETS\YOUTUBE\VIDEO\youtube($db);
}
// embed yt Video
$youtube->embedVideo();
