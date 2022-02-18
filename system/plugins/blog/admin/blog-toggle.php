<?php

use YAWK\db;

include '../system/plugins/blog/classes/blog.php';
// check if blog object is set
if (!isset($blog)) { $blog = new \YAWK\PLUGINS\BLOG\blog(); }
// check if language is set
if (!isset($language) || (!isset($lang)))
{   // inject (add) language tags to core $lang array
    $lang = \YAWK\language::inject(@$lang, "../system/plugins/blog/language/");
}
if (!isset($db)){
    $db = new db();
}

$blog->published = $_GET['published'];

// check status and toggle it
if ($blog->published === '1') {
    $blog->published = 0;
    $progress = "danger";
} else {
    $blog->published = 1;
    $progress = "success";
}

if ($blog->toggleOffline($db, $_GET['blog'], $blog->published))
{   // success, redirect user to blog overview
    \YAWK\backend::setTimeout("index.php?plugin=blog", 0);
}
else
{   // failed, throw error
    print \YAWK\alert::draw("danger", "$lang[ERROR]", "$lang[TOGGLE_BLOG_FAILED].","plugin=blog","3800");
}