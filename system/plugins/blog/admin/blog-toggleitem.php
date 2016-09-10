<?PHP
include '../system/plugins/blog/classes/blog.php';
$item = new \YAWK\PLUGINS\BLOG\blog();
$item->published = $_GET['published'];
$blogid = $_GET['blogid'];

// check status and toggle it
if ($item->published === '1') {
    $item->published = 0;
    $progress = "danger";
} else {
    $item->published = 1;
    $progress = "success";
}

if ($item->toggleItemOffline($db, $_GET['id'], $item->published))
{   //
    \YAWK\backend::setTimeout("plugin=blog&pluginpage=blog-entries&blogid=" . $blogid . "",0);
}
else
{
    print \YAWK\alert::draw("danger", "Error", "Could not toggle blog status.");
}

?>
<br><br>
<div class="progress progress-striped active"> &nbsp; ...please wait...
    <div class="progress-bar progress-bar-<?php print $progress; ?>" role="progressbar" aria-valuenow="45"
         aria-valuemin="0" aria-valuemax="100" style="width: 45%">
        <span class="sr-only">45% Complete</span>
    </div>
</div>