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
if ($_GET['copy'] === "true")
{   // copy entry
    if ($tourdates->copy($db, $tourdates->id))
    {   // success
        print \YAWK\alert::draw("success", "Success!", "The event " . $_GET['id'] . " was copied !","plugin=tourdates","2600");
    }
    else
    {   // error
        print \YAWK\alert::draw("danger", "Error!", "The event " . $_GET['id'] . " could not be copied!","plugin=tourdates","4800");
    }
}