<?PHP
include '../system/plugins/tourdates/classes/tourdates.php';
if (!isset($tourdates))
{   // create new obj
    $tourdates = new YAWK\PLUGINS\TOURDATES\tourdates();
    if (isset($_GET['id']))
    {   // escape var
        $id = $db->quote($_GET['id']);
        $tourdates->loadProperties($db, $id);
    }
}
if ($_GET['delete'] === '1')
{   // delete entry
    if ($tourdates->delete($db))
    {   // success
        print \YAWK\alert::draw("success", "Erfolg!", "Der Gig " . $_GET['id'] . " wurde gel&ouml;scht!","plugin=tourdates","2000");
    }
    else
    {   // delete failed
        print \YAWK\alert::draw("danger", "Fehler!", "Der Gig " . $_GET['id'] . " konnte nicht gel&ouml;scht werden!","plugin=tourdates","4200");
    }
}