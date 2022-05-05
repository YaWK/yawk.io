<?php
session_start();
use YAWK\installer;
// error_reporting(E_ALL ^ E_STRICT);                // show all errors - use this for development purpose only!
// ALL ERRORS OFF - DEFAULT FOR PRODUCTION USE!
error_reporting(0);
// if installer is not set
require_once('system/classes/installer.php');
// create new object
$installer = new installer();
// initialize
$installer->init();
