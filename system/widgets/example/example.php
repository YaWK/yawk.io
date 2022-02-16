<?php
/** @var $db \YAWK\db */
if (!isset($example))
{   // load example widget class
    require_once 'classes/example.php';
    // create new example widget object
    $example = new \YAWK\WIDGETS\EXAMPLE\DEMO\example($db);
}
// init example widget
$example->init();