<?PHP
global $connection;
if ($_GET['set'] === '1') {
    $activated = 0;
}
else {
    $activated = 1;
}

if(YAWK\settings::toggleOffline($_GET['property'], $activated)){
    YAWK\backend::setTimeout("index.php?page=settings-backend", "0");
}
else {
    print \YAWK\alert::draw("danger", "Error", "Could not toggle settings status.");
    YAWK\backend::setTimeout("index.php?page=settings-backend", "0");
}
