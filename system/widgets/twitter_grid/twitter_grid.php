<?php
/** @var $db \YAWK\db */
if (!isset($twitterGrid))
{   // load twitterGrid widget class
    require_once 'classes/twitterGrid.php';
    // create new twitterGrid widget object
    $twitterGrid = new \YAWK\WIDGETS\TWITTER\GRID\twitterGrid($db);
}
// init twitterGrid widget
$twitterGrid->init();
