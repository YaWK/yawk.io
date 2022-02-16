<?php
/** @var $db \YAWK\db */
/** BLOG PLUGIN  */
if (!isset($blogWidget))
{   // load blog widget class
    require_once 'classes/blogWidget.php';
    // create new blog widget object
    $blogWidget = new \YAWK\WIDGETS\BLOG\WIDGET\blogWidget($db);
}
// embed blog
$blogWidget->init($db);