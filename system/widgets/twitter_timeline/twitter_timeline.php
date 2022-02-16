<?php
/** @var $db \YAWK\db */
if (!isset($twitterTimeline))
{   // load twitterGrid widget class
    require_once 'classes/twitterTimeline.php';
    // create new twitterGrid widget object
    $twitterTimeline = new \YAWK\WIDGETS\TWITTER\TIMELINE\twitterTimeline($db);
}
// init twitterGrid widget
$twitterTimeline->init();
