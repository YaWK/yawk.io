<?php
/** @var $db \YAWK\db */
if (!isset($pinterestProfile))
{   // load pinterest widget class
    require_once 'classes/pinterest_profile.php';
    // create new gallery widget object
    $pinterestProfile = new \YAWK\WIDGETS\PINTEREST\PROFILE\pinterestProfile($db);
}
// init pinterest widget
$pinterestProfile->init();