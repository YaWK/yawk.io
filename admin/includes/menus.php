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
        <?php echo \YAWK\backend::getTitle($lang['MENUS'], $lang['MENUS_SUBTEXT']); ?>
        <ol class="breadcrumb">
            <li><a href="./" title="Dashboard"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active"><a href="index.php?page=menus" title="Menus"> Menus</a></li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
<!-- START CONTENT HERE -->

<a href="index.php?page=menu-new" class="btn btn-success pull-right"><b class="glyphicon glyphicon-plus"></b> <?php print $lang['MENU+']; ?></a>
<table class="table table-hover" id="table-sort">
  <thead>
    <tr>
      <td width="5%">&nbsp;</td>
      <td width="5%"><strong>ID</strong></td>
      <td width="10%"><strong>Status</strong></td>
      <td width="30%"><strong>Name</strong></td>
      <td width="30%"><strong>Eintr&auml;ge</strong></td>
      <td width="20%" class="text-center"><strong>Aktionen</strong></td>
    </tr>
  </thead>
  <tbody>

    <?php

    /* get all menus */
    $globalMenuID = \YAWK\settings::getSetting($db, "globalmenuid");

    $rows = \YAWK\backend::getMenusArray($db);
        foreach ($rows AS $row) {
            $res[] = $row;
            $pageName = '';
            if ($sql = $db->query("SELECT menu, alias FROM {pages} WHERE menu = $row[id]"))
            {
                $result = mysqli_fetch_row($sql);
                if ($result[0] == $row['id'])
                {
                    $subMenuLabel = "<i class=\"label label-default\">SubMenu</i>";
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
                $pubtext = "On";
                // if menu is set as globalmenu
                if ($row['id'] === $globalMenuID)
                {   // set colors and label text
                    $globalMenuLabel = "<i class=\"label label-success\">Global Menu</i>";
                }
                else
                    {   // leave empty, because its not set as globalmenu
                        $globalMenuLabel = '';
                    }
            }
            else    // menu is offline
                {   // set colors and label
                    $pub = "danger";
                    $pubtext = "Off";
                    // if menu is set as globalmenu
                    if ($row['id'] === $globalMenuID)
                    {   // set colors and label text
                        $globalMenuLabel = "<i class=\"label label-success\">Global Menu</i>";
                    }
                    else
                    {   // leave empty, because its not set as globalmenu
                        $globalMenuLabel = '';
                    }
                }

            echo "<tr>
    <td><a title=\"toggle&nbsp;status\" href=\"index.php?page=menu-toggle&menuid=" . $row['id'] . "\">
            <span class=\"label label-$pub\">" . $pubtext . "</span></a></td>
    <td>" . $row['id'] . "</td>
    <td>$globalMenuLabel $subMenuLabel</td>
    <td><a title=\"Bearbeiten\" href=\"index.php?page=menu-edit&menu=" . $row['id'] . "\">
            <div style=\"width:100%\"><b>" . $row['name'] . "</b><br>".$pageName."</div></a></td>

    <td><a title=\"Bearbeiten\" href=\"index.php?page=menu-edit&menu=" . $row['id'] . "\">
            <div style=\"width:100%\">" . $row['count'] . "</div></a></td>
    <td class=\"text-center\">
    <a class=\"fa fa-edit\" title=\"Bearbeiten\" href=\"index.php?page=menu-edit&menu=" . $row['id'] . "\">
    </a>
    &nbsp;
    <a class=\"fa fa-trash-o\" title=\"L&ouml;schen\" href=\"index.php?page=menu-delete&menu=" . $row['id'] . "\">
    </a>
    </td>
</tr>";
        }

    ?>
  </tbody>
</table>