<?php
// check if language is set
if (!isset($language) || (!isset($lang)))
{   // inject (add) language tags to core $lang array
    $lang = \YAWK\language::inject(@$lang, "../system/plugins/tourdates/language/");
}

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
        print \YAWK\alert::draw("success", "Success!", "The event " . $_GET['id'] . " is deleted!","plugin=tourdates","2000");
    }
    else
    {   // delete failed
        print \YAWK\alert::draw("danger", "Error!", "The event " . $_GET['id'] . " could not be deleted!","plugin=tourdates","4200");
    }
}