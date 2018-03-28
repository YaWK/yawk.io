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
    // create new fb event object
    $fbEvents = new \YAWK\WIDGETS\FACEBOOK\fbEvents($db);
}

$fbEvents->display();
?>