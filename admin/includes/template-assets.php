<?php

use YAWK\backend;
use YAWK\db;
use YAWK\language;
use YAWK\settings;
use YAWK\template;
use YAWK\user;

/** @var $db db */
/** @var $lang language */
// new template object if not exists
if (!isset($template)) { $template = new template(); }
// new user object if not exists
if (!isset($user)) { $user = new user($db); }
// $_GET['id'] or $_POST['id'] holds the template ID to edit.
// If any one of these two is set, we're in "preview mode" - this means:
// The user database holds two extra cols: overrideTemplate(int|0,1) and templateID
// Any user who is allowed to override the Template, can edit a template and view it
// in the frontend. -Without affecting the current active theme for any other user.
// This is pretty cool when working on a new design: because you see changes, while others wont.
// In theory, thereby every user can have a different frontend template activated.

// get ID of current active template
$template->id = settings::getSetting($db, "selectedTemplate");
$template->name = template::getTemplateNameById($db, $template->id);
?>

<?php
/**
 *
 */


// OVERRIDE TEMPLATE
// check if call comes from template-manage or template-edit form
if (isset($_GET['id']) && (is_numeric($_GET['id']) || (isset($_POST['id']) && (is_numeric($_POST['id'])))))
{
    if (empty($_GET['id']) || (!empty($_POST['id']))) { $getID = $_POST['id']; }
    else if (!empty($_GET['id']) || (empty($_POST['id']))) { $getID = $_GET['id']; }
    else { $getID = settings::getSetting($db, "selectedTemplate");  }

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
}

?>

<?php
if (isset($_GET['action']) && ($_GET['action'] === "setup"))
{
    // update asset configuration
    if (isset($_POST['save']) && (!empty($_POST['save'])))
    {
        $title = '';
        $sortation = '';
        // first of all: delete all assets of this templateID to avoid duplicates
        if ($db->query("DELETE FROM {assets} WHERE templateID = '".$template->id."'"))
        {
            // walk through post data
            foreach ($_POST as $param => $value)
            {
                // check file types
                // .js file
                if (substr($value, -3) == ".js")
                {   // type 1 = javascript file
                    $type = "js";
                }
                // .css file
                if (substr($value, -4) == ".css") {
                    // type 2 = css file
                    $type = "css";
                }
                // title
                if (substr($param, 0, 6) == "title-") {
                    $title = $value;
                    $value = '';
                }
                // sortation
                if (substr($param, 0, 10) == "sortation-") {
                    $sortation = $value;
                    $value = '';
                }

                // if value is not empty
                if (!empty($value) && ($value != "save"))
                {   // add asset to database
                    $db->query("INSERT INTO {assets} (templateID, type, sortation, asset, link) VALUES ('" . $template->id . "', '" . $type . "', '" . $sortation . "','" . $title . "', '" . $value . "')");
                }
            }
        }
    }
}

?>
<script type="text/javascript">
    $(document).ready(function() {
        // TRY TO DISABLE CTRL-S browser hotkey
        function saveHotkey() {
            // simply disables save event for chrome
            $(window).keypress(function (event) {
                if (!(event.which === 115 && (navigator.platform.match("Mac") ? event.metaKey : event.ctrlKey)) && !(event.which === 19)) return true;
                event.preventDefault();
                formmodified=0; // do not warn user, just save.
                return false;
            });
            // used to process the cmd+s and ctrl+s events
            $(document).keydown(function (event) {
                if (event.which === 83 && (navigator.platform.match("Mac") ? event.metaKey : event.ctrlKey)) {
                    event.preventDefault();
                    $('#savebutton').click(); // SAVE FORM AFTER PRESSING STRG-S hotkey
                    formmodified=0; // do not warn user, just save.
                    // save(event);
                    return false;
                }
            });
        }
        saveHotkey();


        var savebutton = ('#savebutton');
        var savebuttonIcon = ('#savebuttonIcon');
        // ok, lets go...
        // we need to check if user clicked on save button
        $(savebutton).click(function() {
            $(savebutton).removeClass('btn btn-success').addClass('btn btn-warning disabled');
            $(savebuttonIcon).removeClass('fa fa-check').addClass('fa fa-spinner fa-spin fa-fw');
        });
    }); // end document ready
</script>


<?php
// TEMPLATE WRAPPER - HEADER & breadcrumbs
echo "
    <!-- Content Wrapper. Contains page content -->
    <div class=\"content-wrapper\" id=\"content-FX\">
    <!-- Content Header (Page header) -->
    <section class=\"content-header\">";
// draw Title on top
echo backend::getTitle($lang['TPL'], $lang['TPL_ASSETS_SETTINGS']);
echo backend::getTemplateBreadcrumbs($lang);
echo"</section><!-- Main content -->
    <section class=\"content\">";
/* page content start here */
?>
<form id="template-edit-form" action="index.php?page=template-assets&action=setup&id=<?php echo $template->id; ?>" method="POST">
    <!-- title header -->
    <!-- REDESIGN -->
    <div class="box">
        <div class="box-body">
            <div class="col-md-10">
                <?php echo "<h4><i class=\"fa fa-puzzle-piece\"></i> &nbsp;$lang[ASSETS] <small>$lang[TPL_ASSETS_SUBTEXT]</small></h4>"; ?>
            </div>
            <div class="col-md-2">
                <button class="btn btn-success pull-right" type="submit" value="save" id="savebutton" name="save" style="margin-top:2px;"><i class="fa fa-check" id="savebuttonIcon"></i>&nbsp;&nbsp;<?php echo $lang['DESIGN_SAVE']; ?></button>
            </div>
        </div>
    </div>
<!-- SETTINGS -->
<div class="row animated fadeIn">

    <div class="col-md-4">
        <div class="box box-default">
            <div class="box-header with-border">
                <h3 class="box-title"><?php echo $lang['SYSTEM_ASSETS']; ?></h3>
            </div>
            <div class="box-body">
                <?php template::drawAssetsSelectFields($db, 1, $template->id, $lang); ?>
            </div>
        </div>
    </div>
    <div class="col-md-4">

        <div class="box box-default">
            <div class="box-header with-border">
                <h3 class="box-title"><?php echo $lang['OPTIONAL_ASSETS']; ?></h3>
            </div>
            <div class="box-body">
                <?php template::drawAssetsSelectFields($db, 2, $template->id, $lang); ?>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="box box-default">
            <div class="box-header with-border">
                <h3 class="box-title"><?php echo $lang['USER_DEFINED_ASSETS']; ?></h3>
            </div>
            <div class="box-body">
                <?php template::drawAssetsSelectFields($db, 3, $template->id, $lang); ?>
            </div>
        </div>
    </div>
</div>
</form>
