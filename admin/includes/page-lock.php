<?PHP
// to render layout correctly
\YAWK\backend::drawContentWrapper();
// check if vars are set
if (isset($_GET['id']) && (isset($_GET['locked']))) {
    if (!isset($page)) // if no page object is set
    {   // create new page object
        $page = new YAWK\page();
    }
    // escape vars
    $id = $db->quote($_GET['id']);
    $locked = $db->quote($_GET['locked']);

    if ($locked === '1') { $setLock = 0; }
    if ($locked === '0') { $setLock = 1; }
    else { $setLock = 0; }

    // execute page lock
    if ($page->toggleLock($db, $id, $setLock))
    {
        // successful, do instant redirect
        \YAWK\backend::setTimeout("index.php?page=pages", 0);
    }
    else
    {   // throw error msg
        \YAWK\alert::draw("danger", "Error", "Could not toggle page lock.","page=pages","4300");
    }
}
// to render layout correctly, include the footer
