<!-- data tables JS -->
<script type="text/javascript">
    $(document).ready(function() {
        $('#table-sort').dataTable( {
            "bPaginate": false,
            "bLengthChange": false,
            "bFilter": true,
            "bSort": true,
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
      <td width="30%"><strong>Name</strong></td>
      <td width="40%"><strong>Eintr&auml;ge</strong></td>
      <td width="20%" style="text-align: center;"><strong>Aktionen</strong></td>
    </tr>
  </thead>
  <tbody>

    <?php

    /* get all menus */
    $rows = \YAWK\backend::getMenusArray($db);
        foreach ($rows AS $row) {
            $res[] = $row;
            if ($row['published'] === '1') {
                $pub = "success";
                $pubtext = "On";
            } else {
                $pub = "danger";
                $pubtext = "Off";
            }

            echo "<tr>
    <td><a title=\"toggle&nbsp;status\" href=\"index.php?page=menu-toggle&menuid=" . $row['id'] . "\">
            <span class=\"label label-$pub\">" . $pubtext . "</span></a></td>
    <td>" . $row['id'] . "</td>
    <td><a title=\"Bearbeiten\" href=\"index.php?page=menu-edit&menu=" . $row['id'] . "\">
            <div style=\"width:100%\">" . $row['name'] . "</div></a></td>

    <td><a title=\"Bearbeiten\" href=\"index.php?page=menu-edit&menu=" . $row['id'] . "\">
            <div style=\"width:100%\">" . $row['count'] . "</div></a></td>
    <td style=\"text-align: center;\">
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