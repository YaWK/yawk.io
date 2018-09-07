<?php
/** @var $db \YAWK\db */
if (!isset($fbLikePosting))
{   // load facebook posting class
    require_once 'classes/fb_post.php';
    // create new facebook posting object
    $fbLikePosting = new \YAWK\WIDGETS\FACEBOOK\POSTING\fbPosting($db);
}
// init facebook posting button
$fbLikePosting->init();