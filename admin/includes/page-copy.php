<?PHP
// to render layout correctly, include the footer
\YAWK\backend::drawContentWrapper();
// check if vars are set
if (isset($_GET['alias'])){
    // if page object is not set
    if (!isset($page)){
        // generate new page object
        $page = new YAWK\page();
    }
    // escape vars
    $_GET['alias'] = $db->quote($_GET['alias']);
    $page->loadProperties($db, $_GET['alias']);
}
// $_GET['copy'] comes from modal dialog
if($_GET['copy'] === "true") {
  if($page->copy($db)){ // ok, do it
    print \YAWK\alert::draw("success", "Erfolg!", "Die Seite ".$_GET['alias']." wurde kopiert!", "page=pages", "2000");
  }
}

