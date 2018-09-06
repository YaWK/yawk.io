<?php
/** @var $db \YAWK\db */
if (!isset($prezi))
{   // load plyr widget class
    require_once 'classes/prezi.php';
    // create new plyr player object
    $prezi = new \YAWK\WIDGETS\PREZI\EMBED\prezi($db);
}
// init prezi widget
$prezi->init();