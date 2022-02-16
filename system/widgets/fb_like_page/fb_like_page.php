<?php
/** @var $db \YAWK\db */
if (!isset($fbLikePage))
{   // load facebook like button class
    require_once 'classes/fb_like_page.php';
    // create new facebook like button object
    $fbLikePage = new \YAWK\WIDGETS\FACEBOOK\LIKEPAGE\fbLikePage($db);
}
// init facebook like button
$fbLikePage->init();