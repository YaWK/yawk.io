<?php
/** @var $db \YAWK\db */
/** GALLERY PLUGIN  */
if (!isset($gallery))
{   // load gallery widget class
    require_once 'classes/gallery.php';
    // create new gallery widget object
    $gallery = new \YAWK\WIDGETS\GALLERY\IMAGES\gallery($db);
}
// embed image gallery
$gallery->init($db);