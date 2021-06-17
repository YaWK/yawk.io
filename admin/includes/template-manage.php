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

use YAWK\alert;
use YAWK\backend;
use YAWK\db;
use YAWK\language;
use YAWK\settings;
use YAWK\template;
use YAWK\user;
/** @var $db db */
/** @var $lang language */

// check user obj
if (!isset($user))
{   // create new user obj
    $user = new user($db);
}
// disable preview (overrideTemplate)
$user->setUserTemplate($db, 0, settings::getSetting($db, "selectedTemplate"), $user->id);
$user->overrideTemplate = 0;

if (isset($_GET['toggle']) && ($_GET['toggle'] === "1"))
{
    if (isset($_GET['templateID']) && (is_numeric($_GET['templateID'])))
    {   // escape chars
        $_GET['templateID'] = $db->quote($_GET['templateID']);
        if (settings::setSetting($db, "selectedTemplate", $_GET['templateID'], $lang))
        {   // additional: set this template as active in template database
            template::setTemplateActive($db, $_GET['templateID']);
            $user->setUserTemplate($db, 0, $_GET['templateID'], $user->id);
            $user->overrideTemplate = 0;
        }
        else
        {
            alert::draw("warning", "$lang[TPL_SWITCH_FAILED]", "$lang[TPL_SWITCH_FAILED_SUBTEXT]", "page=template-manage", 3000);
        }
    }
}

// DELETE TEMPLATE
if (isset($_GET['delete']) && ($_GET['delete'] === "1"))
{   // check, if the given ID is correct
    if (isset($_GET['templateID']) && (is_numeric($_GET['templateID'])))
    {   // escape chars
        $_GET['templateID'] = $db->quote($_GET['templateID']);
        if (template::deleteTemplate($db, $_GET['templateID']))
        {   // throw success msg
            alert::draw("success", "<i class=\"fa fa-trash-o\"></i> $lang[TPL] $lang[DELETED]", "$lang[SUCCESS]", "", 3000);
        }
        else
        {
            alert::draw("danger", "$lang[TPL_FAILED_TO_DELETE] $_GET[templateID]", "$lang[PLEASE_TRY_AGAIN]", "", 3000);
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
echo backend::getTitle($lang['TPL_MANAGER'], $lang['TEMPLATES_SUBTEXT']);
echo"<ol class=\"breadcrumb\">
            <li><a href=\"index.php\" title=\"$lang[DASHBOARD]\"><i class=\"fa fa-dashboard\"></i> $lang[DASHBOARD]</a></li>
            <li><a href=\"index.php?page=template-manage\" class=\"active\" title=\"$lang[TPL_MANAGER]\"> $lang[TPL_MANAGER]</a></li>
        </ol>
    </section>
    <!-- Main content -->
    <section class=\"content\">";
/* page content start here */
?>
<div class="box box-default">
    <div class="box-body">

<a class="btn btn-success" href="#" style="float:right;">
<i class="glyphicon glyphicon-plus"></i> &nbsp;<?php print $lang['TEMPLATE']; ?></a>

<table style="width:100%;" class="table table-striped table-hover table-responsive" id="table-sort">
    <thead>
    <tr>
        <td style="width:3%;"><strong>&nbsp;</strong></td>
        <td style="width:3%;"><strong><?php echo $lang['ID']; ?></strong></td>
        <td style="width:20%;"><strong><i class="fa fa-caret-down"></i> <?php print $lang['TEMPLATE']; ?></strong></td>
        <td style="width:40%;"><strong><i class="fa fa-caret-down"></i> <?php print $lang['DESCRIPTION']; ?></strong></td>
        <td style="width:24%;"><strong><?php print $lang['SCREENSHOT']; ?></strong></td>
        <td style="width: 10%;" class="text-center"><strong><?php print $lang['ACTIONS']; ?></strong></td>
    </tr>
    </thead>
    <tbody>

    <?php
    $i_pages = 0;
    $i_pages_published = 0;
    $i_pages_unpublished = 0;
    // get active tpl name
    $activeTemplate = template::getCurrentTemplateName($db, "backend", "");
    if ($res = $db->query("SELECT * FROM {templates} ORDER BY active DESC"))
    {
        // fetch templates and draw a tbl row in a while loop
        while($row = mysqli_fetch_assoc($res))
        {   // get active template id
            $activeTemplateId = settings::getSetting($db, "selectedTemplate");

            if ($row['id'] === $activeTemplateId)
            {   // set published online
                $pub = "success"; $pubtext="$lang[ONLINE]";
                $i_pages_published = $i_pages_published + 1;
                // do not allow to delete current active template
                $deleteIcon = "<i class=\"fa fa-ban\" title=\"$lang[TPL_DEL_FAILED_DUE_ACTIVE]\"></i>";
            }
            else if ($row['id'] === "1" && ($activeTemplateId !== $row['id']))
            {   // do not allow to delete default template
                $pub = "danger"; $pubtext = "$lang[OFFLINE]";
                $deleteIcon = "<i class=\"fa fa-ban\" title=\"$lang[TPL_DEL_DEFAULT_FAILED]\"></i>";
            }
            else
            {   // set published offline
                $pub = "danger"; $pubtext = "$lang[OFFLINE]";
                $i_pages_unpublished = $i_pages_unpublished +1;
                // delete template button
                $deleteIcon = "<a class=\"fa fa-trash-o\" role=\"dialog\" data-confirm=\"$lang[TPL_DEL_CONFIRM] &laquo;".$row['name']." / ".$row['id']."&raquo;\"
                title=\"".$lang['DELETE']."\" href=\"index.php?page=template-manage&delete=1&templateID=".$row['id']."\">
                </a>";
            }

            // set template image (screen shot)
            $screenshot = "../system/templates/".$activeTemplate."/img/screenshot.jpg";
            if (!file_exists($screenshot))
            {   // sorry, no screenshot available
                $screenshot = "$lang[NO_SCREENSHOT]";
            }
            else
            {   // screenshot found, display
                $screenshot = "<img src=\"../system/templates/".$activeTemplate."/img/screenshot.jpg\" width=\"200\" class=\"img-rounded\">";
            }

            $row['positions'] = str_replace(':', '<br>',$row['positions']); //wordwrap($row['positions'], 20, "<br>\n");
            echo "<tr>
          <td class=\"text-center\">
            <a title=\"toggle&nbsp;status\" href=\"index.php?page=template-manage&toggle=1&templateID=".$row['id']."\">
            <span class=\"label label-$pub\">$pubtext</span></a>&nbsp;</td>
          <td>".$row['id']."</td>
          <td><a href=\"index.php?page=template-edit&overrideTemplate=1&id=".$row['id']."\"><div style=\"width:100%\">".$row['name']."</div></a></td>
          <td><a href=\"index.php?page=template-edit&id=".$row['id']."\" style=\"color: #7A7376;\"><div style=\"width:100%\">".$row['description']."<br><small>".$row['positions']."</small></div></a></td>
          <td><a href=\"index.php?page=template-edit&id=".$row['id']."\" title=\"$lang[EDIT]: ".$row['name']."\">".$screenshot."</a></td>
          <td class=\"text-center\">
            $deleteIcon
          </td>
        </tr>";
        }
    }
    ?>
    </tbody>
</table>

    </div>
</div>