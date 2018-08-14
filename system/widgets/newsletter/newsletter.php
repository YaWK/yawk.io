<?php
// load newsletter class
require_once ('classes/newsletter.php');
// create new newsletter widget object
$newsletter = new \YAWK\WIDGETS\NEWSLETTER\newsletter($db);
$newsletter->init();
?>
