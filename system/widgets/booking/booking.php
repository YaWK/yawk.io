<?php
// check if db obj exits
if (!isset($db) || (empty($db)))
{   // if not, create new db obj
    $db = new \YAWK\db();
}
// language object
if (!isset($lang) || (empty($lang)))
{   // load required language class
    require_once 'system/classes/language.php';
    // create new language obj
    $language = new \YAWK\language();
    // init language
    $language->init($db, "frontend");
    // convert object param to array !important
    $lang = (array) $language->lang;
    // inject widget language tags
    $lang = \YAWK\language::inject($lang, 'system/widgets/booking/language/');
}

// check if booking obj is loaded
if(!isset($booking) || (empty($booking)))
{   // include booking widget class
    require_once ('classes/booking.php');
    // create booking widget object
    $bookingWidget = new \YAWK\WIDGETS\BOOKING\FORM\bookingWidget($db);
    // embed booking form
    $bookingWidget->init($db, $lang);
}
