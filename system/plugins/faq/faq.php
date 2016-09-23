<?php
include 'classes/faq-backend.php';
include 'classes/faq-frontend.php';
/*
 * FRONTEND PAGE
 */
$faq = new \YAWK\PLUGINS\FAQ\frontend();
$faq->draw_faq($db);
