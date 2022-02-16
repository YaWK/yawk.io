<?php
/** @var $db \YAWK\db */
if (!isset($pinterestPin))
{   // load pinterest widget class
    require_once 'classes/pinterest_pin.php';
    // create new gallery widget object
    $pinterestPin = new \YAWK\WIDGETS\PINTEREST\PIN\pinterestPin($db);
}
// init pinterest widget
$pinterestPin->init();