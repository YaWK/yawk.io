<?PHP
if ($_GET['set'] === '1') {
    $activated = 0;
}
else {
    $activated = 1;
}

if(YAWK\settings::toggleOffline($db, $_GET['property'], $activated)){
    YAWK\backend::setTimeout("index.php?page=settings-manage", "0");
}
else {
    print \YAWK\alert::draw("danger", "Error", "Could not toggle settings status.", "", 3500);
    YAWK\backend::setTimeout("index.php?page=settings-manage", "0");
}
