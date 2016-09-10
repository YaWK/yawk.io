<?PHP
include '../system/plugins/faq/classes/faq-backend.php';
if (!isset($faq))
{   // crate object
    $faq = new \YAWK\PLUGINS\FAQ\faq();
}
if (isset($_GET['delete']))
{   // delete faq entry/item
    if (isset($_GET['id']))
    {   //
        if ($faq->delete($db, $_GET['id']))
        {   // success
            print \YAWK\alert::draw("success", "Erfolg!", "Der Eintrag " . $_GET['id'] . " wurde gel&ouml;scht!", "plugin=faq","2000");
        }
        else
        {   // delete item failed, throw error
            print \YAWK\alert::draw("danger", "Fehler!", "Der Eintrag ".$_GET['id']." konnte nicht gel&ouml;scht werden.", "plugin=faq","3800");
        }
    }
}