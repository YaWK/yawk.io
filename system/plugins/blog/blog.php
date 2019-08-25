<script type="text/javascript" src="system/plugins/blog/js/comments.js"></script>
<script type="text/javascript" src="system/plugins/blog/js/voting.js"></script>
<?php
include 'classes/blog.php';
/*
 * FRONTEND PAGE
 */
$blog = new \YAWK\PLUGINS\BLOG\blog();
/* get templateID */
$templateID = YAWK\template::getCurrentTemplateId($db);
/* a blog can be called by GET variable or via page include */
if (!isset($_GET['blogid']))
{ // if no blog is given
    if (!isset($blog_id))
    {   // if its not included by $_GET param
        $blog->blogid = 1;  // set default blog
    }
    else
    {   // called from default page
        $blog->blogid = $blog_id;
    }
}
else { $blog->blogid = $_GET['blogid']; } // set the blog ID via $_GET param

    // get published status (is it online or offline?)
    $published = $blog->getBlogProperty($db, $blog->blogid, "published");
    // get group id of this blog
    $gid = $blog->getBlogProperty($db, $blog->blogid, "gid");
    // get limit entries (number of items to display)
    $blog->limitEntries = $blog->getBlogProperty($db, $blog->blogid, "limitEntries");

// if blog is not offline, get entries from db + draw it on screen.
if ($published != 0)
{
    if (!isset($item_id)){ $item_id = 0; }
        // check group id, only load title if own gid is bigger
        // if (isset($_SESSION['gid']) && $_SESSION['gid'] >= $blog->gid)

        // load title
        $blog->getTitle($db, $blog->blogid);

    // load the blog entries into blog object
    if (!isset($full_view)) { $full_view = 0; }
    if (!isset($blog->limitEntries)) { $blog->limitEntries = 0; }
    $blog->getFrontendEntries($db, $blog->blogid, $item_id, $full_view, $blog->limitEntries);
    // check footer setting and load it on demand
    if ($blog->getBlogProperty($db, $blog->blogid, "footer")){
        $blog->getFooter($db);
    }
    // finally: draw the blog
    print $blog->draw();
    print "</div>";
}
else
{   // blog is not published, draw message
	echo \YAWK\alert::draw("warning", "Entschuldigung!", "Dieser Bereich ist im Moment offline, da gerade daran gearbeitet wird. Bitte komm sp&auml;ter wieder.","","4800");
}
?>