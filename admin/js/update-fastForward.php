<?php
use YAWK\db;
use YAWK\update;
include '../../system/classes/db.php';
include '../../system/classes/language.php';
include '../../system/classes/settings.php';
include '../../system/classes/update.php';
/* set database object */
if (!isset($db))
{   // create new db object
    $db = new db();
}
if (!isset($lang))
{   // create new language object
    $language = new YAWK\language();
    // init language
    $language->init($db, "backend");
    // convert object param to array !important
    $lang = (array) $language->lang;
}


// generate new update object
$update = new update();
$updateVersion = '';
if (isset($_POST['updateVersion']))
{   // get update version from post xhr
    $updateVersion = $_POST['updateVersion'];
    // fast-forward to current version
    \YAWK\settings::setSetting($db, "yawkversion", $updateVersion, $lang);
}
// get yawkversion from settings and check, if it is the same as the update version
$yawkversion = \YAWK\settings::getSetting($db, "yawkversion");
if ($yawkversion == $updateVersion)
{   // fast-forward successful
    \YAWK\sys::setSyslog($db, 54, 0, "UPDATE FAST FORWARD to version ".$updateVersion." successful", 0, 0, 0, 0);
    echo "<h3 class=\"text-success\">Update fast-forward to version ".$updateVersion." successful</h3>";
}
else
{   // fast-forward failed
    \YAWK\sys::setSyslog($db, 55, 2, "UPDATE FAST FORWARD to version ".$updateVersion." failed", 0, 0, 0, 0);
    echo "<h3 class=\"text-danger\">fast-forward update to version ".$updateVersion." failed</h3>";
}

