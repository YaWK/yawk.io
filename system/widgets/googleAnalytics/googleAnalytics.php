<?php
/** @var $db \YAWK\db */
// check if google analytics widget is set
if (!isset($googleAnalytics))
{   // load gallery widget class
    require_once 'classes/googleAnalytics.php';
    // create new google analytics widget object
    $googleAnalytics = new \YAWK\WIDGETS\GOOGLE\ANALYTICS\googleAnalytics($db);
}
// embed google analytics
$googleAnalytics->init();