<?php
/** @var $db \YAWK\db */
if (!isset($loginbox))
{   // load loginbox widget class
    require_once 'classes/loginbox.php';
    // create new loginbox widget object
    $loginbox = new \YAWK\WIDGETS\LOGINBOX\LOGIN\loginbox($db);
}
// init example widget
$loginbox->init($db);
