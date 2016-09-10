<?PHP
include '../system/plugins/blog/classes/blog.php';
$item = new \YAWK\PLUGINS\BLOG\blog();
$item->gid = $_GET['itemgid'];
$item->blogid = $_GET['blogid'];
$item->id = $_GET['itemid'];

// logic role badge
switch ($item->gid) {
    case 1:
        $rcolor = "success";
        $item->gid = 5;
        break;
    case 2:
        $rcolor = "warning";
        $item->gid--;
        break;
    default:
    case 3:
        $rcolor = "danger";
        $item->gid--;
        break;
    default:
    case 4:
        $rcolor = "danger";
        $item->gid--;
        break;
    default:
    case 5:
        $rcolor = "danger";
        $item->gid--;
        break;
}

$progress = "success";

if ($item->toggleRole($db, $item->gid, $item->id, $item->blogid))
{   // success, redirect to blog entries overview
    \YAWK\backend::setTimeout("index.php?plugin=blog&pluginpage=blog-entries&blogid=" . $item->blogid . "",0);
}
else
{   // failed, throw error
    print \YAWK\alert::draw("danger", "Error", "Could not toggle blog status.","plugin=blog&pluginpage=blog-entries&blogid=" . $item->blogid . "","3800");
}