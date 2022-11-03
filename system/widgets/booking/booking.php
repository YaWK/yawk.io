<?php
// check if db obj exits
use YAWK\db;
use YAWK\language;
use YAWK\WIDGETS\BOOKING\FORM\bookingWidget;

if (!isset($db))
{   // if not, create new db obj
    $db = new db();
}
// language object
if ((empty($lang)))
{   // load required language class
    require_once 'system/classes/language.php';
    // create new language obj
    $language = new language();
    // init language
    $language->init($db, "frontend");
    // convert object param to array !important
    $lang = (array) $language->lang;
    // inject widget language tags
    $lang = language::inject($lang, 'system/widgets/booking/language/');
}

// check if booking obj is loaded
if((empty($booking)))
{   // include booking widget class
    require_once ('classes/booking.php');
    // create booking widget object
    $bookingWidget = new bookingWidget($db);
    // embed booking form
    $bookingWidget->init($db, $lang);
}
