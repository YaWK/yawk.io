<?php
use YAWK\alert;
use YAWK\backend;
use YAWK\db;
use YAWK\language;
use YAWK\menu;
use YAWK\settings;

/** @var $lang language */
/** @var $db db */

// CHECK MENU OBJECT
if (!isset($menu))
{   // create new menu object if its not set
    $menu = new menu();
}
// TOGGLE MENU
if (isset($_GET['toggle']) && ($_GET['toggle'] === "1"))
{   // prepare vars
    $menu->id = ($db->quote($_GET['menuid']));
    $menu->published = $menu->getMenuStatus($db, $menu->id);

    // check status and toggle it
    if ($menu->published === '1')
    {   // set status to NOT published
        $menu->published = 0;
        $status = "$lang[OFFLINE]";
        $color = "danger";
    }
    else
    {   // set status to PUBLISHED
        $menu->published = 1;
        $status = "$lang[ONLINE]";
        $color = "success";
    }

    if($menu->toggleOffline($db, $menu->id, $menu->published, $lang))
    {
        alert::draw("$color", "$lang[MENU_IS_NOW] $status", "$lang[MENU_STATUS_TOGGLE_OK] $status.", "", 800);
    }
    else
    {
        print alert::draw("danger", "$lang[ERROR]", "$lang[MENU_STATUS_TOGGLE_FAILED] $status.","page=menus","5800");
    }
}

// ADD MENU
/* if user clicked create menu */
if(isset($_GET['add']) && ($_GET['add'] === "1"))
{
    if (YAWK\menu::createMenu($db, $db->quote($_POST['name']), $lang))
    {   // menu created, do syslog + draw notify
        print alert::draw("success", "$lang[SUCCESS]", "$lang[THE_MENU] <strong>".$_POST['name']."</strong> $lang[WAS_CREATED]!", "","2000");
    }
    else
    {   // throw error
        print alert::draw("danger", "$lang[ERROR]", "$lang[THE_MENU] <strong>".$_POST['name']."</strong> $lang[WAS_NOT_CREATED]!", "","5800");
    }
}

// DELETE MENU
if (isset($_GET['del']) && ($_GET['del'] === "1"))
{   // check if delete is true
    if (isset($_GET['delete']) && ($_GET['delete'] == 'true'))
    {   // delete whole menu
        $menuName = menu::getMenuNameByID($db, $_GET['menu']);
        if(menu::delete($db, $db->quote($_GET['menu']), $lang))
        {   // all good...
            print alert::draw("success", "$lang[SUCCESS]", "$lang[MENU_DEL_OK]","","800");
        }
        else
        {   // throw error
            print alert::draw("danger", "$lang[ERROR]", "$lang[MENU_DEL_FAILED]","","5800");
        }
    }
}
?>
<!-- data tables JS -->
<script type="text/javascript">
    $(document).ready(function() {
        $('#table-sort').dataTable( {
            "bPaginate": false,
            "bLengthChange": false,
            "bFilter": true,
            "bSort": false,
            "bInfo": true,
            "bAutoWidth": false
        } );
    } );
</script>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper" id="content-FX">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <!-- draw title on top-->
        <?php echo backend::getTitle($lang['MENUS'], $lang['MENUS_SUBTEXT']); ?>
        <ol class="breadcrumb">
            <li><a href="./" title="<?php echo $lang['DASHBOARD']; ?>"><i class="fa fa-dashboard"></i> <?php echo $lang['DASHBOARD']; ?></a></li>
            <li class="active"><a href="index.php?page=menus" title="<?php echo $lang['MENUS']; ?>"> <?php echo $lang['MENUS']; ?></a></li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
<!-- START CONTENT HERE -->
<div class="box box-default">
    <div class="box-body">

<a href="index.php?page=menu-new" class="btn btn-success pull-right"><b class="glyphicon glyphicon-plus"></b> <?php print $lang['MENU+']; ?></a>
<table class="table table-striped table-hover table-responsive" id="table-sort">
  <thead>
    <tr>
      <td style="width:5%;">&nbsp;</td>
      <td style="width:5%;"><strong><?php echo $lang['ID']; ?></strong></td>
      <td style="width:10%;"><strong><?php echo $lang['STATUS']; ?></strong></td>
      <td style="width:30%;"><strong><?php echo $lang['NAME']; ?></strong></td>
      <td style="width:30%;"><strong><?php echo $lang['ENTRIES']; ?></strong></td>
      <td style="width:20%;" class="text-center"><strong><?php echo $lang['ACTIONS']; ?></strong></td>
    </tr>
  </thead>
  <tbody>

    <?php
    /* get all menus */
    $globalMenuID = settings::getSetting($db, "globalmenuid");

    $rows = backend::getMenusArray($db);
        foreach ($rows AS $row) {
            $res[] = $row;
            $pageName = '';
            if ($sql = $db->query("SELECT menu, alias FROM {pages} WHERE menu = $row[id]"))
            {
                $result = mysqli_fetch_row($sql);
                if (isset($result[0]) && ($result[0] == $row['id']))
                {
                    $subMenuLabel = "<i class=\"label label-default\">$lang[SUBMENU]</i>";
                    $pageName = "<small><small>@</small> $result[1].html</small>";
                }
                else
                {
                    $subMenuLabel = '';
                    $pageName = '';
                }
            }

            if ($row['published'] === '1')
            {   // set label to online
                $pub = "success";
                $pubtext = $lang['ON_'];
                // if menu is set as globalmenu
                if ($row['id'] === $globalMenuID)
                {   // set colors and label text
                    $globalMenuLabel = "<i class=\"label label-success\">$lang[GLOBAL_MENU]</i>";
                }
                else
                    {   // leave empty, because its not set as globalmenu
                        $globalMenuLabel = '';
                    }
            }
            else    // menu is offline
                {   // set colors and label
                    $pub = "danger";
                    $pubtext = $lang['OFF_'];
                    // if menu is set as globalmenu
                    if ($row['id'] === $globalMenuID)
                    {   // set colors and label text
                        $globalMenuLabel = "<i class=\"label label-success\">$lang[GLOBAL_MENU]</i>";
                    }
                    else
                    {   // leave empty, because its not set as globalmenu
                        $globalMenuLabel = '';
                    }
                }

            echo "<tr>
    <td><a title=\"$lang[TOGGLE_STATUS]\" href=\"index.php?page=menus&toggle=1&menuid=" . $row['id'] . "\">
            <span class=\"label label-$pub\">" . $pubtext . "</span></a></td>
    <td>" . $row['id'] . "</td>
    <td>$globalMenuLabel $subMenuLabel</td>
    <td><a title=\"$lang[EDIT]\" href=\"index.php?page=menu-edit&menu=" . $row['id'] . "\">
            <div style=\"width:100%\"><b>" . $row['name'] . "</b><br>".$pageName."</div></a></td>

    <td><a title=\"$lang[EDIT]\" href=\"index.php?page=menu-edit&menu=" . $row['id'] . "\">
            <div style=\"width:100%\">" . $row['count'] . "</div></a></td>
    <td class=\"text-center\">
    <a class=\"fa fa-edit\" title=\"$lang[EDIT]\" href=\"index.php?page=menu-edit&menu=" . $row['id'] . "\">
    </a>
    &nbsp;
    <a class=\"fa fa-trash-o\" role=\"dialog\" data-confirm=\"$lang[MENU_DEL_CONFIRM] &laquo;$row[name]&raquo;?\"
       title=\"$lang[DELETE]\" href=\"index.php?page=menus&del=1&menu=$row[id]&delete=true\">
    </a>
    </td>
</tr>";
        }

    ?>
  </tbody>
</table>

    </div>
</div>