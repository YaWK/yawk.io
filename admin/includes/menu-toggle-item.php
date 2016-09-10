<?PHP
if (isset($_GET['published']) && (isset($_GET['menu']) && ($_GET['id'])))
{
    if (is_numeric($_GET['published'])
    && (is_numeric($_GET['menu'])
    && (is_numeric($_GET['id']))))
    {
        // data is set, types seem to be correct, go ahead...
        if (!isset($menu))
        {   // create new menu object
            $menu = new YAWK\menu();
        }
        $menu->parent = $db->quote($_GET['menu']);
        $menu->id = $db->quote($_GET['id']);
        $menu->published = $db->quote($_GET['published']);

        // check status and toggle it
        if ($menu->published === '1') {
            $menu->published = 0;
        }
        else {
            $menu->published = 1;
        }
        // all ok, now toggle that menu entry
        if($menu->toggleItemOffline($db, $menu->id, $menu->published)){
            print \YAWK\backend::setTimeout("index.php?page=menu-edit&menu=$menu->parent",0);
        }
        else {
            print \YAWK\alert::draw("danger", "Error", "Could not toggle menu item status.");
            exit;
        }

    }
}
