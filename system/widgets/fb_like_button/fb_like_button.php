<?php
/** @var $db \YAWK\db */
if (!isset($fbLikeButton))
{   // load facebook like button class
    require_once 'classes/fb_like_button.php';
    // create new facebook like button object
    $fbLikeButton = new \YAWK\WIDGETS\FACEBOOK\LIKEBUTTON\fbLikeButton($db);
}
// init facebook like button
$fbLikeButton->init();