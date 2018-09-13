<?php
/** @var $db \YAWK\db */
if (!isset($twitterTweet))
{   // load twitter Tweet widget class
    require_once 'classes/twitterTweet.php';
    // create new twitter Tweet widget object
    $twitterTweet = new \YAWK\WIDGETS\TWITTER\TWEET\twitterTweet($db);
}
// init twitter Tweet widget
$twitterTweet->init();
