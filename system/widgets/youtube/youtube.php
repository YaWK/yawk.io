<?php
/** @var $db \YAWK\db */
// check if youtube obj is loaded
if(!isset($youtube) || (empty($youtube)))
{   // not set, include yt widget class
    require_once ('classes/youtube.php');
    // create yt widget object
    $youtube = new \YAWK\WIDGETS\YOUTUBE\VIDEO\youtube($db);
}
// embed yt video
$youtube->embedVideo();
