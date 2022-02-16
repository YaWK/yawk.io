<?php
/** @var $db \YAWK\db */
if (!isset($twitterTweetButton))
{   // load twitter tweet button widget class
    require_once 'classes/twitterTweetButton.php';
    // create new twitter tweet button widget object
    $twitterTweetButton = new \YAWK\WIDGETS\TWITTER\BUTTON\twitterTweetButton($db);
}
// init twitter tweet button widget
$twitterTweetButton->init();
