<?php
session_start();
error_reporting(E_ALL ^ E_STRICT);                      // show all erros - use for development ONLY
// error_reporting(0);                                  // turn all errors OFF - DEFAULT FOR PRODUCTION USE!

// include installer class
require_once('system/classes/installer.php');
// generate new installer object
$installer = new \YAWK\installer();
// start installation process
$installer->init();