<?PHP
include '../system/plugins/blog/classes/blog.php';
$blog = new \YAWK\PLUGINS\BLOG\blog();

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
    print \YAWK\alert::draw("danger", "Error", "Could not toggle blog status.","plugin=blog","3800");
}