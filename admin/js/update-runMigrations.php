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

// prepare vars
if (isset($_POST['updateVersion'])) {
    $updateVersion = $_POST['updateVersion'];

    // generate new update object
    $update = new update();
    $update->updateVersion = $updateVersion;
    $update->runMigrations($db, $updateVersion, $lang);
}
else
{   // error
    echo "Update Version could not be read!";
}
