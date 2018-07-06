<?php
if (!isset($db) || (empty($db)))
{   // if not, create new db obj
    $db = new \YAWK\db();
}
// include fb example widget class
include ('classes/fbCover.php');
// create fb event object
$cover = new \YAWK\WIDGETS\FACEBOOK\FBCOVER\fbCover($db);
// basic data output
$cover->drawCoverImage();
?>