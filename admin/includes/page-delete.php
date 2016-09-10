<?php
// check if vars are set
if (!isset($_GET['delete'])) {
    // modal dialog content
    // to render layout correctly
    \YAWK\backend::drawContentWrapper();
    echo "
        <div class=\"text-center\">
          <p>Soll die Seite <strong> $_GET[alias].html</strong> unwideruflich gel&ouml;scht werden?</p>
          <a class=\"btn btn-default\" href=\"index.php?page=pages\">Abbrechen</a>
          <a class=\"btn btn-warning\" href=\"index.php?page=page-delete&alias=$_GET[alias]&delete=true\">
            <i class=\"fa fa-trash-o\"></i>&nbsp; Seite l&ouml;schen
          </a>
        </div>";

}
else // dialog is set to delete
{
    if (isset($_GET['delete']) && ($_GET['delete'] == "true")){
        // if page obj != set
        if (!isset($page))
        {   // create new page object
            $page = new YAWK\page();
            $_GET['alias'] = $db->quote($_GET['alias']);
            $page->loadProperties($db, $_GET['alias']);
        }
        // ok, delete page
        if ($page->delete($db))
        {   // success
            \YAWK\alert::draw("success", "Erfolg!", "Die Seite " . $_GET['alias'] . " wurde gel&ouml;scht!","","420");
            \YAWK\backend::setTimeout("index.php?page=pages",1260);
        }
        else
        {   // failed
            \YAWK\alert::draw("danger", "Error!", "Die Seite " . $_GET['alias'] . " konnte nicht gel&ouml;scht werden!", "page=pages","4800");
        }
    }
}