<?PHP
include '../system/plugins/blog/classes/blog.php';
    if (isset($_GET['blogid']) && (isset($_GET['itemid']))){
        // new blog object
        $page = new \YAWK\page();
        $blog = new \YAWK\PLUGINS\BLOG\blog();
        $blog->id = $db->quote($_GET['blogid']);
        $blog->itemid = $db->quote($_GET['itemid']);
        $blog->itemgid = $db->quote($_GET['itemgid']);
        $blog->loadItemProperties($db, $blog->id, $blog->itemid);
        $blog->sort++;
        $blog->alias = $page->getProperty($db, $blog->pageid, "alias");
        // call copy method

        if($_GET['copy'] === "true")
        {
            if($blog->copyItem($db, $blog))
            {   // success
                \YAWK\alert::draw("success", "Erfolg!", "Der Blogeintrag ".$_GET['itemid']." wurde kopiert!","","2000");
            }
            else
            {   // copy failed, throw error
                \YAWK\alert::draw("danger", "Fehler!", "Der Blogeintrag konnte nicht kopiert werden.", "plugin=blog&pluginpage=blog-entries&blogid=$blog->id","3800");
            }
        }
    }