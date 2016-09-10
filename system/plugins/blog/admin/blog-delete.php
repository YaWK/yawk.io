<?PHP
include '../system/plugins/blog/classes/blog.php';
$blog = new \YAWK\PLUGINS\BLOG\blog();
if (!isset($_GET['delete']))
{
    // build content of popup box

    // TEMPLATE WRAPPER - HEADER & breadcrumbs
    echo "
    <!-- Content Wrapper. Contains page content -->
    <div class=\"content-wrapper\" id=\"content-FX\">
    <!-- Content Header (Page header) -->
    <section class=\"content-header\">";
        /* draw Title on top */
        echo \YAWK\backend::getTitle($lang['BLOG'], $lang['BLOGS_SUBTEXT']);
        echo"<ol class=\"breadcrumb\">
            <li><a href=\"index.php\" title=\"Dashboard\"><i class=\"fa fa-dashboard\"></i> Dashboard</a></li>
            <li><a href=\"index.php?page=plugins\" title=\"Plugins\"> Plugins</a></li>
            <li><a href=\"index.php?plugin=blog\" title=\"Blog\"> Blog</a></li>
            <li><a href=\"index.php?plugin=blog\" title=\"Blog\"> Blog</a></li>
            <li class=\"active\"><a href=\"index.php?plugin=blog&pluginpage=blog-delete\" title=\"Blog\"> Delete Blog</a></li>
        </ol>
    </section>
    <!-- Main content -->
    <section class=\"content\">";
    /* page content start here */
?>
    <p>Soll das Blog <strong><?PHP echo $_GET['itemid']; ?></strong>
        unwideruflich gel&ouml;scht werden?</p>
    <a class="btn btn-default" href="index.php?plugin=blog">Abbrechen</a>
    <a class="btn btn-warning"
       href="index.php?plugin=blog&pluginpage=blog-delete&blog=<?PHP echo $_GET['blog']; ?>&delete=true">
        Seite l&ouml;schen
    </a>
    <?PHP
exit;
}
else
{   // delete blog entry/item
    if (isset($_GET['itemid']))
    {
        if (!$blog->deleteItem($db, $_GET['blogid'], $_GET['itemid'], $_GET['pageid']))
        {   // delete item failed, throw error
            \YAWK\alert::draw("warning", "Error: ", "Could not delete Blog Page: " . $_GET['itemid'] . " ","plugin=blog","2000");
            exit;
        }
    }
    // delete full blog including all content
    if (!$blog->delete($db, $_GET['blog']))
    {   // delete blog failed, throw error
        \YAWK\alert::draw("warning", "Error: ", "Could not delete Entry ID: " . $_GET['itemid'] . " ","plugin=blog","2000");
        exit;
    }
}
?>