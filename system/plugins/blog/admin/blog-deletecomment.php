<?PHP
include '../system/plugins/blog/classes/blog.php';
$blog = new \YAWK\PLUGINS\BLOG\blog();
if (isset($_GET['delete']) && ($_GET['delete'] === "true")) {
    // delete comment
    if (isset($_GET['commentid']) && (isset($_GET['itemid']) && (isset($_GET['blogid'])))) {
        if ($blog->deleteComment($db, $_GET['blogid'], $_GET['itemid'], $_GET['commentid'])) {
            \YAWK\alert::draw("success", "Success! ", "Comment ID " . $_GET['id'] . " deleted.", "","1200");
        }
        else
        {
            \YAWK\alert::draw("danger", "Error: ", "Could not delete comment ID: " . $_GET['id'] . " ", "","3800");
        }
    }
}