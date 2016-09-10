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
<?php
// TEMPLATE WRAPPER - HEADER & breadcrumbs
echo "
    <!-- Content Wrapper. Contains page content -->
    <div class=\"content-wrapper\" id=\"content-FX\">
    <!-- Content Header (Page header) -->
    <section class=\"content-header\">";
/* draw Title on top */
echo \YAWK\backend::getTitle($lang['DESIGN'], $lang['TEMPLATES_SUBTEXT']);
echo"<ol class=\"breadcrumb\">
            <li><a href=\"index.php\" title=\"Dashboard\"><i class=\"fa fa-dashboard\"></i> Dashboard</a></li>
            <li><a href=\"index.php?page=settings-template\" class=\"active\" title=\"Users\"> Themes</a></li>
        </ol>
    </section>
    <!-- Main content -->
    <section class=\"content\">";
/* page content start here */
?>

<a class="btn btn-success" href="index.php?page=page-new" style="float:right;">
<i class="glyphicon glyphicon-plus"></i> &nbsp;<?php print $lang['TEMPLATE']; ?></a>

<table width="100%" cellpadding="4" cellspacing="0" border="0" class="table table-hover" id="table-sort">
    <thead>
    <tr>
        <td width="3%"><strong>&nbsp;</strong></td>
        <td width="3%"><strong>ID</strong></td>
        <td width="20%"><strong><i class="fa fa-caret-down"></i> <?PHP print $lang['TEMPLATE']; ?></strong></td>
        <td width="40%"><strong><i class="fa fa-caret-down"></i> <?PHP print $lang['DESCRIPTION']; ?></strong></td>
        <td width="24%"><strong><?PHP print $lang['SCREENSHOT']; ?></strong></td>
        <td width="10%" style="text-align:center;"><strong><?PHP print $lang['ACTIONS']; ?></strong></td>
    </tr>
    </thead>
    <tbody>

    <?PHP

    $i_pages = 0;
    $i_pages_published = 0;
    $i_pages_unpublished = 0;
    // get active tpl name
    $activeTemplate = \YAWK\template::getCurrentTemplateName($db, "admin");
    if ($res = $db->query("SELECT * FROM {templates} ORDER BY name DESC"))
    {
        // fetch templates and draw a tbl row in a while loop
        while($row = mysqli_fetch_assoc($res))
        {   // get active template id
            $activeTemplateId = \YAWK\settings::getSetting($db, "selectedTemplate");

            if ($row['id'] === $activeTemplateId)
            {   // set published online
                $pub = "success"; $pubtext="On";
                $i_pages_published = $i_pages_published + 1;
            }
            else
            {   // set published offline
                $pub = "danger"; $pubtext = "Off";
                $i_pages_unpublished = $i_pages_unpublished +1;
            }

            // set template image (screen shot)
            $screenshot = "../system/templates/".$activeTemplate."/img/screenshot.jpg";
            if (!file_exists($screenshot))
            {   // sorry, no screenshot available
                $screenshot = "sorry, no screenshot available";
            }
            else
            {   // screenshot found, display
                $screenshot = "<img src=\"../system/templates/".$activeTemplate."/img/screenshot.jpg\" width=\"200\" class=\"img-rounded\">";
            }

            echo "<tr>
          <td style=\"text-align:center;\">
            <a title=\"toggle&nbsp;status\" href=\"index.php?page=template-toggle&template=".$row['id']."\">
            <span class=\"label label-$pub\">$pubtext</span></a>&nbsp;</td>
          <td>".$row['id']."</td>
          <td><a href=\"index.php?page=template-edit&id=".$row['id']."\"><div style=\"width:100%\">".$row['name']."</div></a></td>
          <td><a href=\"index.php?page=template-edit&id=".$row['id']."\" style=\"color: #7A7376;\"><div style=\"width:100%\">".$row['description']."<br><small>".$row['positions']."</small></div></a></td>

          <td><a href=\"index.php?page=template-edit&id=".$row['id']."\" title=\"edit ".$row['name']."\">".$screenshot."</a></td>
          <td style=\"text-align:center;\">

            <a class=\"fa fa-edit\"title=\"".$lang['EDIT']."\" href=\"index.php?page=template-edit&id=".$row['id']."\"></a>&nbsp;
            <a class=\"fa fa-trash-o\" role=\"dialog\" data-confirm=\"Das Template &laquo;".$row['name']." / ".$row['id']."&raquo; wirklich l&ouml;schen?\"
            title=\"".$lang['DELETE']."\" href=\"index.php?page=template-delete&template=".$row['id']."\">
            </a>
          </td>
        </tr>";
        }
    }
    ?>
    </tbody>
</table>