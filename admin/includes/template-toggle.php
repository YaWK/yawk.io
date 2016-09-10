<?php
if (!isset($page))
{   // create new page object
    $page = new YAWK\page();
}
if (isset($_GET['site']))
{   // escape chars
    $_GET['site'] = $db->quote($_GET['site']);
}
// load page properties
$page->loadProperties($db, $_GET['site']);

// check status and toggle it
if ($page->published === '1') {
    $page->published = 0;
    $progress = "danger";
}
else {
    $page->published = 1;
    $progress = "success";
}

if($page->toggleOffline($page->id, $page->published, $page->title)){
    print \YAWK\backend::setTimeout("index.php?page=pages",0);
}
else {
    print \YAWK\alert::draw("danger", "Error", "Could not toggle site status.");
}

?>
<br><br>
<div class="progress progress-striped active"> &nbsp; ...please wait...
    <div class="progress-bar progress-bar-<?php print $progress; ?>"  role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width: 45%">
        <span class="sr-only">45% Complete</span>
    </div>
</div>