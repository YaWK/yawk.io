<?php
// check if db obj exits
if (!isset($db) || (empty($db)))
{   // if not, create new db obj
    $db = new \YAWK\db();
}
// check if contentAnimator obj is loaded
if(!isset($contentAnimator) || (empty($contentAnimator)))
{
    // if not, include contentAnimator widget class
    require_once ('classes/contentAnimator.php');
    // create contentAnimator widget object
    $contentAnimator = new \YAWK\WIDGETS\CONTENTANIMATOR\ANIMATE\contentAnimator($db);
}
// init current contentAnimator
$contentAnimator->init();
