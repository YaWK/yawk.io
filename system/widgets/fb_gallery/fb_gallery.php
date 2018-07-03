<?php
if (!isset($db) || (empty($db)))
{   // if not, create new db obj
    $db = new \YAWK\db();
}

// check if gallery obj is set
if (!isset($fbGallery) || (empty($fbGallery)))
{
    // if not, load fb gallery class
    require_once ('classes/fbGallery.php');
    // create fb gallery object
    $fbGallery = new \YAWK\WIDGETS\FACEBOOK\GALLERY\fbGallery($db);
    // ok, load gallery
    $fbGallery->drawGallery();
}
?>