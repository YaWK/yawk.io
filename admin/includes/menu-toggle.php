<?PHP
$menu = new YAWK\menu();
$menu->id = ($db->quote($_GET['menuid']));
$menu->published = $menu->getMenuStatus($db, $_GET['menuid']);

// check status and toggle it
if ($menu->published === '1') {
    $menu->published = 0;
}
else {
    $menu->published = 1;
}

if($menu->toggleOffline($db, $menu->id, $menu->published)){
    print \YAWK\backend::setTimeout("index.php?page=menus",0);
}
else {
    print \YAWK\alert::draw("danger", "Error", "Could not toggle menu status.","page=menus","4800");
    exit;
}