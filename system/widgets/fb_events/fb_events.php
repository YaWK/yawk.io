<?php
// check if db obj exits
if (!isset($db) || (empty($db)))
{   // if not, create new db obj
    $db = new \YAWK\db();
}
// if fb object not exists...
if (!isset($fbEvents) || (empty($fbEvents)))
{
    // include widget class: facebook events
    include ('classes/fbEvents.php');
    // create fb event object
    $fbEvents = new \YAWK\WIDGETS\FACEBOOK\EVENTS\fbEvents($db);
}
// display facebook events
$fbEvents->display();
?>