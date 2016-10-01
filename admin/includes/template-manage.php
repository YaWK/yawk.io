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
<?php
if (isset($_GET['toggle']) && ($_GET['toggle'] === "1"))
{
    if (isset($_GET['templateID']) && (is_numeric($_GET['templateID'])))
    {   // escape chars
        $_GET['templateID'] = $db->quote($_GET['templateID']);
        if (\YAWK\settings::setSetting($db, "selectedTemplate", $_GET['templateID']))
        {   // additional: set this template as active in template database
            \YAWK\template::setTemplateActive($db, $_GET['templateID']);
            $user->setUserTemplate($db, 0, $_GET['templateID'], $user->id);
        }
        else
        {
            \YAWK\alert::draw("warning", "Could not switch template.", "Please try it again or go to settings page.", "page=template-manage", 3000);
        }
    }
}

// DELETE TEMPLATE
if (isset($_GET['delete']) && ($_GET['delete'] === "1"))
{   // check, if the given ID is correct
    if (isset($_GET['templateID']) && (is_numeric($_GET['templateID'])))
    {   // escape chars
        $_GET['templateID'] = $db->quote($_GET['templateID']);
        if (\YAWK\template::deleteTemplate($db, $_GET['templateID']))
        {   // throw success msg
            \YAWK\alert::draw("success", "<i class=\"fa fa-trash-o\"></i> Template deleted.", "...all good things come to an end.", "", 3000);
        }
        else
        {
            \YAWK\alert::draw("danger", "Could not delete template ID $_GET[templateID]", "Please try it again.", "", 3000);
        }
    }
}

?>
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
            <li><a href=\"index.php?page=template-manage\" class=\"active\" title=\"Users\"> Themes</a></li>
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
    $activeTemplate = \YAWK\template::getCurrentTemplateName($db, "backend", "");
    if ($res = $db->query("SELECT * FROM {templates} ORDER BY active DESC"))
    {
        // fetch templates and draw a tbl row in a while loop
        while($row = mysqli_fetch_assoc($res))
        {   // get active template id
            $activeTemplateId = \YAWK\settings::getSetting($db, "selectedTemplate");

            if ($row['id'] === $activeTemplateId)
            {   // set published online
                $pub = "success"; $pubtext="On";
                $i_pages_published = $i_pages_published + 1;
                // do not allow to delete current active template
                $deleteIcon = "<i class=\"fa fa-ban\" title=\"Delete not possible, because template is set to active.\"></i>";
            }
            else if ($row['id'] === "1" && ($activeTemplateId !== $row['id']))
            {   // do not allow to delete default template
                $pub = "danger"; $pubtext = "Off";
                $deleteIcon = "<i class=\"fa fa-ban\" title=\"Cannot delete the default template.\"></i>";
            }
            else
            {   // set published offline
                $pub = "danger"; $pubtext = "Off";
                $i_pages_unpublished = $i_pages_unpublished +1;
                // delete template button
                $deleteIcon = "<a class=\"fa fa-trash-o\" role=\"dialog\" data-confirm=\"Das Template &laquo;".$row['name']." / ".$row['id']."&raquo; wirklich l&ouml;schen?\"
                title=\"".$lang['DELETE']."\" href=\"index.php?page=template-manage&delete=1&templateID=".$row['id']."\">
                </a>";
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
            <a title=\"toggle&nbsp;status\" href=\"index.php?page=template-manage&toggle=1&templateID=".$row['id']."\">
            <span class=\"label label-$pub\">$pubtext</span></a>&nbsp;</td>
          <td>".$row['id']."</td>
          <td><a href=\"index.php?page=template-edit&overrideTemplate=1&id=".$row['id']."\"><div style=\"width:100%\">".$row['name']."</div></a></td>
          <td><a href=\"index.php?page=template-edit&id=".$row['id']."\" style=\"color: #7A7376;\"><div style=\"width:100%\">".$row['description']."<br><small>".$row['positions']."</small></div></a></td>
          <td><a href=\"index.php?page=template-edit&id=".$row['id']."\" title=\"edit ".$row['name']."\">".$screenshot."</a></td>
          <td class=\"text-center\">
            $deleteIcon
          </td>
        </tr>";
        }
    }
    ?>
    </tbody>
</table>