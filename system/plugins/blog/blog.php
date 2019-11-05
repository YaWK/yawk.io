<script src="system/plugins/blog/js/comments.js"></script>
<script src="system/plugins/blog/js/voting.js"></script>
<?php
// include blog class
include 'classes/blog.php';
// create new blog object
$blog = new \YAWK\PLUGINS\BLOG\blog();
// current templateID
$templateID = YAWK\template::getCurrentTemplateId($db);

// a blog can be called by GET variable or via page include
// set default blog (1), if no blog ID was set
if (!isset($_GET['blogid']))
{   // if no blog ID is set
    if (!isset($blog_id))
    {   // if its not included by $_GET param
        $blog->blogid = 1;  // set default blog
    }
    else
    {   // called from default page
        $blog->blogid = $blog_id;
    }
}
// set the blog ID via $_GET param
else
    {   // blogID was set via GET param
        $blog->blogid = $_GET['blogid'];
    }

    // load global blog properties
    if ($blog->loadBlogProperties($db, $blog->blogid) === false)
    {   // failed to load...
        echo "Unable to load Blog settings";
    }

// if blog is not offline, get entries from db + draw it on screen.
if ($blog->published != 0)
{
    // check, if there is an item ID set
    if (!isset($item_id))
    {   // zero, because no ID was set
        $item_id = 0;
    }
        // check group id, only load title if own gid is bigger
        // if (isset($_SESSION['gid']) && $_SESSION['gid'] >= $blog->gid)

    // load blog title
    $blog->getTitle($db, $blog->blogid);

    // load the blog entries into blog object
    if (!isset($full_view))
    {   //
        $full_view = 0;
    }

    // check entries should be limited to (x)
    if (!isset($blog->limitEntries))
    {   // zero means no limitation wanted
        $blog->limitEntries = 0;
    }

    // load all entries of this blog
    $blog->getFrontendEntries($db, $blog->blogid, $item_id, $full_view, $blog->limitEntries);

    // check footer setting and load it on demand
    //if ($blog->getBlogProperty($db, $blog->blogid, "footer")){
    //    $blog->getFooter($db);
    //}
    // finally: draw the blog
    print $blog->draw();
    print "</div>";
}
else
{   // blog is not published, draw message
	echo \YAWK\alert::draw("warning", "Entschuldigung!", "Dieser Bereich ist im Moment offline, da gerade daran gearbeitet wird. Bitte komm sp&auml;ter wieder.","","4800");
}
?>