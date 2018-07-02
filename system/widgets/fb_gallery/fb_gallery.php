<?php
if (!isset($db) || (empty($db)))
{   // if not, create new db obj
    $db = new \YAWK\db();
}
// include fb example widget class
include ('classes/fbGallery.php');
// create fb event object
$example = new \YAWK\WIDGETS\FACEBOOK\GALLERY\fbGallery($db);
// basic data output
 // $example->basicOutput();
// example->drawGallery();
$example->drawGallery();
// $example->printApiObject();
?>