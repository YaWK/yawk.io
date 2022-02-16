<?php
/** @var $db \YAWK\db */
if (!isset($fbVideo))
{   // load facebook video class
    require_once 'classes/fb_video.php';
    // create new facebook video object
    $fbVideo = new \YAWK\WIDGETS\FACEBOOK\VIDEO\fbVideo($db);
}
// init facebook video button
$fbVideo->init();