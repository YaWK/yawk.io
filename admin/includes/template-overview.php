<?php
// check if template obj is set and create if not exists
if (!isset($template)) { $template = new \YAWK\template(); }
// new user obj if not exists
if (!isset($user)) { $user = new \YAWK\user(); }
// get ID of current active template
$getID = \YAWK\settings::getSetting($db, "selectedTemplate");
// load properties of current active template
$template->loadProperties($db, $getID);
// previewButton is an empty string - why? this should be checked
$previewButton = "";

// TOGGLE TEMPLATE
// set selectedTemplate online/offline (visible for everybody)
if (isset($_GET['toggle']) && ($_GET['toggle'] === "1"))
{
    if (isset($_GET['templateID']) && (is_numeric($_GET['templateID'])))
    {   // escape chars
        $_GET['templateID'] = $db->quote($_GET['templateID']);
        if (\YAWK\settings::setSetting($db, "selectedTemplate", $_GET['templateID'], $lang))
        {   // additional: set this template as active in template database
            \YAWK\template::setTemplateActive($db, $_GET['templateID']);
            $user->setUserTemplate($db, 0, $_GET['templateID'], $user->id);
            $user->overrideTemplate = 0;
        }
        else
        {
            \YAWK\alert::draw("warning", "$lang[TPL_SWITCH_FAILED]", "$lang[TPL_SWITCH_FAILED_SUBTEXT]", "page=template-manage", 3000);
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
            \YAWK\alert::draw("success", "<i class=\"fa fa-trash-o\"></i> $lang[TPL] $lang[DELETED]", "$lang[SUCCESS]", "", 3000);
        }
        else
        {
            \YAWK\alert::draw("danger", "$lang[TPL_FAILED_TO_DELETE] $_GET[templateID]", "$lang[PLEASE_TRY_AGAIN]", "", 3000);
        }
    }
}

// OVERRIDE TEMPLATE
// check if call comes from template-manage or template-edit form
if (isset($_GET['id']) && (is_numeric($_GET['id']) || (isset($_POST['id']) && (is_numeric($_POST['id'])))))
{
    if (empty($_GET['id']) || (!empty($_POST['id']))) { $getID = $_POST['id']; }
    else if (!empty($_GET['id']) || (empty($_POST['id']))) { $getID = $_GET['id']; }
    else { $getID = \YAWK\settings::getSetting($db, "selectedTemplate");  }

    if ($user->isTemplateEqual($db, $getID))
    {   // user template equals selectedTemplate
        // update template in user table row
        $user->setUserTemplate($db, 0, $getID, $user->id);
        $user->overrideTemplate = 0;
        // info badge to inform user that this is visible to everyone
        $infoBadge = "<span class=\"label label-success\"><i class=\"fa fa-check\"></i>&nbsp;&nbsp;$lang[VISIBLE_TO_EVERYONE]</span>";
        // info button on top
        $previewButton = "";
    }
    else
    {   // show preview button and set template active for this user
        $user->setUserTemplate($db, 1, $getID, $user->id);
        $user->overrideTemplate = 1;
        // info badge to inform user that this is HIS preview
        $infoBadge = "<span class=\"label label-danger\"><i class=\"fa fa-eye\"></i>&nbsp;&nbsp;$lang[PREVIEW]</span>";
        // close preview button on top
        $previewButton = "<a class=\"btn btn-danger\" href=\"index.php?page=template-manage&overrideTemplate=0&id=$getID\"><i class=\"fa fa-times\"></i>&nbsp;&nbsp;$lang[CLOSE_PREVIEW]</a>";
    }

    // check if user/admin is allowed to override the template
    if ($user->isAllowedToOverrideTemplate($db, $user->id) === true)
    {   // ok, user is allowed to override: set tpl from user database
        if (isset($_GET['overrideTemplate']) && ($_GET['overrideTemplate'] === "1"))
        {
            $user->setUserTemplate($db, 1, $getID, $user->id);
            $user->overrideTemplate = 1;
            $template->loadProperties($db, $getID);
        }
        else
        {
            $user->setUserTemplate($db, 0, $getID, $user->id);
            $user->overrideTemplate = 0;
            $template->loadProperties($db, $getID);
        }

        // $userTemplateID = \YAWK\user::getUserTemplateID($db, $user->id);
        // load template properties for userTemplateID
        // $template->loadProperties($db, $getID);
    }
    else
    {   // user is not allowed to override, so we load the default (global) selectedTemplate settings
        // $template->loadProperties($db, YAWK\settings::getSetting($db, "selectedTemplate"));
        $template->loadProperties($db, $getID);
    }
}
else {
    $previewButton = "";
    $infoBadge = "<span class=\"label label-success\"><i class=\"fa fa-check\"></i>&nbsp;&nbsp;$lang[VISIBLE_TO_EVERYONE]</span>";
}

// load all template settings into array
// $templateSettings = \YAWK\template::getAllSettingsIntoArray($db, $user);

// check template wrapper
// \YAWK\template::checkWrapper($lang, $lang['TPL'], $lang['OVERVIEW']);
?>
<?php
// TEMPLATE WRAPPER - HEADER & breadcrumbs
echo "
    <!-- Content Wrapper. Contains page content -->
    <div class=\"content-wrapper\" id=\"content-FX\">
    <!-- Content Header (Page header) -->
    <section class=\"content-header\">";
// draw Title on top
echo \YAWK\backend::getTitle($lang['TPL'], $lang['OVERVIEW']);
echo \YAWK\backend::getTemplateBreadcrumbs($lang);
echo"</section><!-- Main content -->
    <section class=\"content\">";
/* page content start here */
?>
<!-- title header -->
<div class="box">
    <div class="box-body">
        <div class="col-md-12">
            <?php echo "<h4><i class=\"fa fa-home\"></i> &nbsp;$lang[OVERVIEW] <small>$template->name</small></h4>"; ?>
        </div>
    </div>
</div>

<!-- OVERVIEW -->
<!-- list TEMPLATE HOME PAGE (DETAILS) -->
<div class="row animated fadeIn">
    <div class="col-md-5">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title"><?php echo "$lang[DETAILS] <small>$lang[OF_CURRENT_ACTIVE_THEME]"; ?></small></h3>
            </div>
            <dl class="dl-horizontal">
                <?php
                // PREPARE TEMPLATE DETAILS VARS
                // author URL
                if (isset($template->authorUrl) && (!empty($template->authorUrl)))
                {   // set author's link
                    $authorUrl = "<small>&nbsp;<a href=\"$template->authorUrl\" target=\"_blank\" title=\"$lang[AUTHORS_WEBLINK_DESC]\"
                                <i class=\"fa fa-external-link\"></i></a></small>";
                }
                else { $authorUrl = ""; }

                // author
                if (isset($template->author) && (!empty($template->author)))
                {   // set author
                    $author = "<dt>$lang[AUTHOR]</dt><dd>$template->author&nbsp;$authorUrl</dd>";
                }
                else { $author = ""; }

                // weblink
                if (isset($template->weblink) && (!empty($template->weblink)))
                {   // set author's link
                    $weblink = "<dt>$lang[WEBLINK]</dt><dd><a href=\"$template->weblink\" target=\"_blank\" title=\"$lang[PROJECT_WEBLINK_DESC]\">$template->weblink</a></dd>";
                }
                else { $weblink= ""; }

                // modifyDate
                if (isset($template->modifyDate) && ($template->modifyDate !== "0000-00-00 00:00:00"))
                {   // set modifyDate
                    $modifyDate = "<dt>$lang[MODIFIED]</dt><dd>$template->modifyDate</dd>";
                }
                else { $modifyDate = ''; }

                // releaseDate
                if (isset($template->releaseDate) && ($template->releaseDate !== "0000-00-00 00:00:00"))
                {   // set release date
                    $releaseDate = "<dt>$lang[RELEASED]</dt><dd>$template->releaseDate</dd>";
                }
                else { $releaseDate = ''; }

                // description
                if (isset($template->description) && (!empty($template->description)))
                {   // set author
                    $description = "<dt>$lang[DESCRIPTION]</dt><dd>$template->description</dd>";
                }
                else { $description = ""; }

                // version
                if (isset($template->version) && (!empty($template->version)))
                {   // set author
                    $version = "<dt>$lang[VERSION]</dt><dd>$template->version</dd>";
                }
                else { $version = ""; }

                if (isset($template->subAuthorUrl) && (!empty($template->subAuthorUrl)))
                {   // set author's link
                    $subauthorurl = "<small>&nbsp;<a href=\"$template->subAuthorUrl\" target=\"_blank\" title=\"$lang[MODIFIED_BY_LINKDESC]\"
                                <i class=\"fa fa-external-link\"></i></a></small>";
                }
                else { $subauthorurl = ""; }

                // subAuthor
                if (isset($template->subAuthor) && (!empty($template->subAuthor)))
                {   // set subAuthor
                    $subauthor = "<dt>$lang[MODIFIED_BY]</dt><dd>$template->subAuthor&nbsp;$subauthorurl</dd>";
                }
                else { $subauthor = ""; }

                // subAuthor
                if (isset($template->license) && (!empty($template->license)))
                {   // set subAuthor
                    $license = "<dt>$lang[LICENSE]</dt><dd>$template->license</dd>";
                }
                else { $license = ""; }

                $settings = "<dt>$lang[SETTINGS]</dt>
                            <dd>".$template->countTemplateSettings($db, $template->id)."</dd>";

                ?>
                <dt><?php echo "$lang[TEMPLATE] $lang[NAME]"; ?></dt>
                <dd><b><?php echo $template->name; ?></b></dd>
                <dt><?php echo $lang['STATUS']; ?></dt>
                <dd><b><?php echo $infoBadge; ?></b></dd>

                <?php echo $description.$author.$weblink.$license.$version.$releaseDate.$settings."<br>".$subauthor.$modifyDate; ?>

                <dt>&nbsp;</dt>
                <dd>&nbsp;</dd>

                <dt><?php echo $lang['TOOLS']; ?></dt>
                <dd>
                    <b><?php echo $lang['YAWK_SLOGAN_TOGETHER']; ?><br>
                        <?php \YAWK\template::drawAssetsTitles($db, $template->id, $lang); ?>
                </dd>
                <dt>&nbsp;</dt>
                <dd>&nbsp;</dd>
            </dl>
        </div>
    </div>
    <div class="col-md-7">
        <div class="box">
            <div class="box-header"><h3 class="box-title">Template Manager</h3></div>
            <div class="box-body">
                <table width="100%" cellpadding="4" cellspacing="0" border="0" class="table table-striped table-hover table-responsive" id="table-sort">
                    <thead>
                    <tr>
                        <td><strong>&nbsp;</strong></td>
                        <td><strong><?php echo $lang['PREVIEW']; ?></strong></td>
                        <td><strong><?php echo $lang['ID']; ?></strong></td>
                        <td><strong><i class="fa fa-caret-down"></i> <?php print $lang['TEMPLATE']; ?></strong></td>
                        <td><strong><i class="fa fa-caret-down"></i> <?php print $lang['DESCRIPTION']; ?></strong></td>
                        <td><strong><?php print $lang['SCREENSHOT']; ?></strong></td>
                        <td class="text-center"><strong><?php print $lang['ACTIONS']; ?></strong></td>
                    </tr>
                    </thead>
                    <tbody>

                    <?php
                    $i_pages = 0;
                    $i_pages_published = 0;
                    $i_pages_unpublished = 0;
                    // get active tpl name
                    $activeTemplate = \YAWK\template::getCurrentTemplateName($db, "backend", "");
                    $userTemplateID = \YAWK\user::getUserTemplateID($db, $user->id);
                    if ($res = $db->query("SELECT * FROM {templates} ORDER BY active DESC"))
                    {
                        // fetch templates and draw a tbl row in a while loop
                        while($row = mysqli_fetch_assoc($res))
                        {   // get active template id
                            $activeTemplateId = \YAWK\settings::getSetting($db, "selectedTemplate");

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
                                title=\"".$lang['DELETE']."\" href=\"index.php?page=template-overview&delete=1&templateID=".$row['id']."\"></a>";
                                $previewLabel = '';
                            }
                            if ($row['id'] == ($userTemplateID) && ($row['id'] == $activeTemplateId))
                            {
                                $previewLabel = "<a href=\"index.php?page=template-overview&overrideTemplate=1&id=".$row['id']."\">
                                <span class=\"label label-success\"><i class=\"fa fa-eye\"></i> $lang[ACTIVE]</span></a>";
                            }
                            else if ($row['id'] == ($userTemplateID))
                            {
                                $previewLabel = "<a href=\"index.php?page=template-overview&overrideTemplate=1&id=".$row['id']."\">
                                <span class=\"label label-success\"><i class=\"fa fa-eye\"></i> $lang[PREVIEW] $lang[ACTIVE]</span></a>";
                            }
                            else
                            {
                                $previewLabel = "<a href=\"index.php?page=template-overview&overrideTemplate=1&id=".$row['id']."\">
                                <span class=\"label label-default\"><i class=\"fa fa-eye\"></i> $lang[PREVIEW]</span></a>";
                            }

                            // set template image (screen shot)
                            $screenshot = "../system/templates/".$activeTemplate."/img/screenshot.jpg";
                            if (!file_exists($screenshot))
                            {   // sorry, no screenshot available
                                $screenshot = "$lang[NO_SCREENSHOT]";
                                $screenshot = "<img src=\"http://placehold.it/220x150\" class=\"img-responsive img-rounded\">";
                            }
                            else
                            {   // screenshot found, display
                                $screenshot = "<img src=\"../system/templates/".$activeTemplate."/img/screenshot.jpg\" width=\"200\" class=\"img-rounded\">";
                            }

        // <td>".$row['id']."</td>

                            $row['positions'] = str_replace(':', '<br>',$row['positions']); //wordwrap($row['positions'], 20, "<br>\n");
                            echo "<tr>
          <td class=\"text-center\">
            <a title=\"toggle&nbsp;status\" href=\"index.php?page=template-overview&toggle=1&templateID=".$row['id']."\">
            <span class=\"label label-$pub\">$pubtext</span></a>&nbsp;</td>
          <td>".$previewLabel."</td>
          <td>".$row['id']."</td>
          <td><a href=\"index.php?page=template-overview&overrideTemplate=1&id=".$row['id']."\"><div style=\"width:100%\">".$row['name']."</div></a></td>
          <td><a href=\"index.php?page=template-overview&id=".$row['id']."\" style=\"color: #7A7376;\"><div style=\"width:100%\">".$row['description']."</div></a></td>
          <td><a href=\"index.php?page=template-overview&id=".$row['id']."\" title=\"$lang[EDIT]: ".$row['name']."\">".$screenshot."</a></td>
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
    </div>
</div>