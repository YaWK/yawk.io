<?php
if (!isset($db))
{   // get db object
    require_once 'system/classes/db.php';
    $db = new \YAWK\db();
}
/** GALLERY PLUGIN  */
if (!isset($gallery))
{   // load plugin gallery class
    require_once 'classes/gallery.php';
    // create new gallery obj
    $gallery = new \YAWK\WIDGETS\GALLERY\IMAGES\gallery($db);
}
// embed image gallery
$gallery->init($db);
?>