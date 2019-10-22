<?php
if (!isset($db) || (empty($db)))
{   // if not, create new db obj
    $db = new \YAWK\db();
}
// include fb example widget class
include ('classes/fbFeed.php');
// create fb event object
$fbFeed = new \YAWK\WIDGETS\FACEBOOK\FEED\fbFeed($db);

// print_r($fbFeed);
// basic data output
$fbFeed->basicOutput();
// $fbFeed->printApiObject();
?>