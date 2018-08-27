<?php
/** @var $db \YAWK\db */
// check if GoogleMaps object is set
if (!isset($googleMaps))
{   // load gallery widget class
    require_once 'classes/googleMaps.php';
    // create new google maps widget object
    $googleMaps = new \YAWK\WIDGETS\GOOGLE\MAPS\googleMaps($db);
}
// embed google maps
$googleMaps->init();