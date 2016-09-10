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
if ($_GET['copy'] === "true")
{   // copy entry
    if ($tourdates->copy($db, $tourdates->id))
    {   // success
        print \YAWK\alert::draw("success", "Erfolg!", "Der Gig " . $_GET['id'] . " wurde kopiert!","plugin=tourdates","2600");
    }
    else
    {   // error
        print \YAWK\alert::draw("danger", "Fehler!", "Der Gig " . $_GET['id'] . " konnte nicht kopiert werden!","plugin=tourdates","4800");
    }
}