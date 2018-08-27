<?php
/** @var $db \YAWK\db */
/** EXAMPLE PLUGIN  */
if (!isset($example))
{   // load gallery widget class
    require_once 'classes/example.php';
    // create new gallery widget object
    $example = new \YAWK\WIDGETS\EXAMPLE\DEMO\example($db);
}
// init example widget
$example->init();