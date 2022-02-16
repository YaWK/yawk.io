<?php
/** @var $db \YAWK\db */
if (!isset($socialBar))
{   // load gallery widget class
    require_once 'classes/socialBar.php';
    // create new gallery widget object
    $socialBar = new \YAWK\WIDGETS\SOCIALBAR\DISPLAY\socialBar($db);
}
// init example widget
$socialBar->init();