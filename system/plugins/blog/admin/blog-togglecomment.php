<?PHP
include '../system/plugins/blog/classes/blog.php';
$comment = new \YAWK\PLUGINS\BLOG\blog();
$comment->published = $_GET['published'];
$blogid = $_GET['blogid'];
$commentid = $_GET['id'];
$itemid = $_GET['itemid'];

// check status and toggle it
if ($comment->published === '1') {
    $comment->published = 0;
    $progress = "danger";
}
else
{
    $comment->published = 1;
    $progress = "success";
}

if ($comment->toggleCommentOffline($db, $_GET['id'], $comment->published))
{   // success, redirect to blog comments overview
    \YAWK\backend::setTimeout("index.php?plugin=blog&pluginpage=blog-comments&blogid=" . $blogid . "", 0);
}
else
{   // throw error
    print \YAWK\alert::draw("danger", "Error", "Could not toggle comment status.","?plugin=blog&pluginpage=blog-comments&blogid=" . $blogid . "","1200");
}