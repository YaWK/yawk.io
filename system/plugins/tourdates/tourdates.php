<?php
include 'classes/tourdates.php';
/* 
 * FRONTEND PAGE
 */
$tourdates = new \YAWK\PLUGINS\TOURDATES\tourdates();
print $tourdates->getFrontendTable($db);
