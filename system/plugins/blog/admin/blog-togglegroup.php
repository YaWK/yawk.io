<?php
include '../system/plugins/blog/classes/blog.php';
// check if language is set
if (!isset($language) || (!isset($lang)))
{   // inject (add) language tags to core $lang array
    $lang = \YAWK\language::inject(@$lang, "../system/plugins/blog/language/");
}
// create new blog item obj
$item = new \YAWK\PLUGINS\BLOG\blog();
// check if db is set
if (!isset($db))
{   // load db obj
    $db = new \YAWK\db();
}
// prepare vars
$item->gid = $_GET['itemgid'];
$item->blogid = $_GET['blogid'];
$item->id = $_GET['itemid'];

// logic role badge
switch ($item->gid) {
    case "1":
        $rcolor = "success";
        $item->gid = 5;
        break;
    case "2":
        $rcolor = "warning";
        $item->gid--;
        break;
    case "3":
        $rcolor = "danger";
        $item->gid--;
        break;
    case "4":
        $rcolor = "danger";
        $item->gid--;
        break;
    case "5":
        $rcolor = "danger";
        $item->gid--;
        break;
}

$progress = "success";

// toggle role
if ($item->toggleRole($db, $item->gid, $item->id))
{   // success, redirect to blog entries overview
    \YAWK\backend::setTimeout("index.php?plugin=blog&pluginpage=blog-entries&blogid=" . $item->blogid . "",0);
}
else
{   // failed, throw error
    print \YAWK\alert::draw("danger", "$lang[ERROR]", "$lang[GROUPS] $lang[TOGGLE_FAILED]","plugin=blog&pluginpage=blog-entries&blogid=" . $item->blogid . "","3800");
}