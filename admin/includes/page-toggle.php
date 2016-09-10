<?PHP
// check if vars are set
if (isset($_GET['id']) && isset($_GET['published']) && isset($_GET['title']))
{   // check if page object exists,
    if (!isset($page))
    {   // if not, create new object
        $page = new \YAWK\page();
    }
    // finally: toggle that damn page
    if($page->toggleOffline($db, $_GET['id'], $_GET['published'], $_GET['title']))
    {   // all good, redirect to admin/pages w/o any msg
        print \YAWK\backend::setTimeout("index.php?page=pages",0);
    }
}