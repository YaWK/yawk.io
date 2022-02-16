<?php
/** @var $db \YAWK\db */
if (!isset($submenu))
{   // load submenu widget class
    require_once 'classes/submenu.php';
    // create new submenu widget object
    $submenu = new \YAWK\WIDGETS\SUBMENU\EMBED\submenu($db);
}
// init submenu widget
$submenu->init($db);
