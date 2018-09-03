<?php
/** @var $db \YAWK\db */
// load newsletter class
require_once ('classes/newsletter.php');
// create new newsletter widget object
$newsletter = new \YAWK\WIDGETS\NEWSLETTER\SUBSCRIBE\newsletter($db);
$newsletter->init();
?>
