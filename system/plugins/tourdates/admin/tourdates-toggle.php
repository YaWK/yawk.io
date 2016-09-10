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
// check status and toggle it
if ($tourdates->published === '1')
{   // published, toggle to OFF
    $tourdates->published = 0;
}
else
{   // not published, toggle to ON
    $tourdates->published = 1;
}

if ($tourdates->toggleOffline($db, $tourdates->id, $tourdates->published))
{
    \YAWK\backend::setTimeout("index.php?plugin=tourdates", 0);
}
else
{   // toggle failed, throw error
    print \YAWK\alert::draw("danger", "Error", "Could not toggle tourdate status.","plugin-tourdates","4200");
}