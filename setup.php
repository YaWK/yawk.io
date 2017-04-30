<?php
session_start();
// error_reporting(E_ALL ^ E_STRICT);                // show all erros - for development purpose only
//error_reporting(0);                                  // ALL ERRORS OFF - DEFAULT FOR PRODUCTION USE!
                                                     // HIDE ALL NOTICES, ERRORS AND WARNINGS

// if installer is not set
require_once('system/classes/installer.php');
// create new object
$installer = new \YAWK\installer();
// initialize
$installer->init();
