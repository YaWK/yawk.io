<?php
// check if db obj exits
if (!isset($db) || (empty($db)))
{   // if not, create new db obj
    $db = new \YAWK\db();
}
// check if booking obj is loaded
if(!isset($booking) || (empty($booking)))
{   // include booking widget class
    require_once ('classes/booking.php');
    // create booking widget object
    $bookingWidget = new \YAWK\WIDGETS\BOOKING\FORM\bookingWidget($db);
    // embed booking form
    $bookingWidget->init($db);
}
