<?php
// new template object if not exists
if (!isset($template)) { $template = new \YAWK\template(); }
// new user object if not exists
if (!isset($user)) { $user = new \YAWK\user(); }
// $_GET['id'] or $_POST['id'] holds the template ID to edit.
// If any one of these two is set, we're in "preview mode" - this means:
// The user database holds two extra cols: overrideTemplate(int|0,1) and templateID
// Any user who is allowed to override the Template, can edit a template and view it
// in the frontend. -Without affecting the current active theme for any other user.
// This is pretty cool when working on a new design: because you see changes, while others wont.
// In theory, thereby every user can have a different frontend template activated.

// get ID of current active template
$template->id = \YAWK\settings::getSetting($db, "selectedTemplate");
$template->name = \YAWK\template::getTemplateNameById($db, $template->id);
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
}

?>

<?php
if ($_GET['action'] === "template-setup")
{
    // admin requested to save current template settings as new theme
    if (isset($_POST['savenewtheme']) && (!empty($_POST['savenewtheme'])))
    {
        $newID = '';
        $getID = '';

        // SAVE AS new theme
        $template->name = $db->quote($_POST['newthemename']);
        // get new template id
        $oldTemplateId = $template->id;
        $newID = \YAWK\template::getMaxId($db);
        $newTplId = $newID++;
        $template->id = $newTplId;
        // set new theme active
        //$user->setUserTemplate($db, 1, $newID, $user->id);
        //$user->overrideTemplate = 1;
        //\YAWK\settings::setSetting($db, "selectedTemplate", $newID);

        if (isset($_POST['description']) && (!empty($_POST['description'])))
        {   // set new tpl description
            $template->description = $db->quote($_POST['description']);
        }
        else
        {   // new description not set, default value instead:
            $template->description = "Template Description";
        }
        if (isset($_POST['positions']) && (!empty($_POST['positions'])))
        {   // set new tpl positions
            $template->positions = $db->quote($_POST['positions']);
        }
        else
        {   // new positions not set, default value instead:
            $template->positions = "globalmenu:top:main:bottom:footer";
        }

        // save as new theme
        $template->saveAs($db, $newID, $template, $template->name, $template->positions, $template->description);
        // set the new theme active in template
        \YAWK\template::setTemplateActive($db, $newID);
        // copy the template settings into the new template
        \YAWK\template::copyTemplateSettings($db, $oldTemplateId, $newID);
    }

    // add new google font to database
    if (isset($_POST['addgfont']) && (!empty($_POST['addgfont'])))
    {
        $description = $_POST['gfontdescription'];
        $gfont = $_POST['gfont'];
        // add google font
        if($gfont != "addgfont")
        {
            if ($template->addgfont($db, $gfont,$description) === true)
            {   // successful, throw info
                \YAWK\alert::draw("success", "$lang[TPL_ADD_GFONT]", "$lang[ADD_SUCCESSFUL]", '', 2400);
            }
            else
                {   // add gfont failed - throw error
                    \YAWK\alert::draw("danger", "$lang[TPL_ADD_GFONT]", "$lang[ADD_FAILED]", '', 2400);
                }
        }
    }

    // update asset configuration
    if (isset($_POST['save']) && (!empty($_POST['save'])))
    {
        // process update of assets configuration in database
        echo "<h1>................................... update asset config!</h1>";
        exit;
    }
}

?>
<script type="text/javascript">
    $(document).ready(function() {
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
echo \YAWK\backend::getTitle($lang['TPL'], $lang['SETTINGS']);
echo \YAWK\backend::getTemplateBreadcrumbs($lang);
echo"</section><!-- Main content -->
    <section class=\"content\">";
/* page content start here */
?>
<form id="template-edit-form" action="index.php?page=template-setup&action=template-setup&id=<?php echo $template->id; ?>" method="POST">
    <!-- title header -->
    <!-- REDESIGN -->
    <div class="box">
        <div class="box-body">
            <div class="col-md-10">
                <?php echo "<h4><i class=\"fa fa-gears\"></i> &nbsp;$lang[SETTINGS] <small>$lang[TPL_SETTINGS_SUBTEXT]</small></h4>"; ?>
            </div>
            <div class="col-md-2">
                <button class="btn btn-success pull-right" type="submit" value="save" id="savebutton" name="save" style="margin-top:2px;"><i class="fa fa-check"></i>&nbsp;&nbsp;<?php echo $lang['DESIGN_SAVE']; ?></button>
            </div>
        </div>
    </div>
<!-- SETTINGS -->
<h3><?php echo "$lang[SETTINGS] <small>$lang[TPL_SETTINGS_SUBTEXT]</small>"; ?></h3>
<div class="row animated fadeIn">

    <div class="col-md-4">
        <div class="box box-default">
            <div class="box-header with-border">
                <h3 class="box-title">Required Assets Include Configuration</h3>
            </div>
            <div class="box-body">
                <label for="include-bootstrap">Bootstrap JS</label>
                <select id="include-bootstrap" name="include-bootstrap" class="form-control">
                    <option name="null">please select</option>
                    <optgroup label="internal">internal</optgroup>
                    <option name="internal">load from internal sources (system/engines/bootstrap)</option>
                    <optgroup label="external">external</optgroup>
                    <option name="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js">https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js</option>
                    <option name="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js">https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js</option>
                </select>
                <label for="include-bootstrap">Bootstrap CSS</label>
                <select id="include-bootstrap" name="include-bootstrap" class="form-control">
                    <option name="null">please select</option>
                    <optgroup label="internal">internal</optgroup>
                    <option name="internal">load from internal sources (system/engines/bootstrap)</option>
                    <optgroup label="external">external</optgroup>
                    <option name="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css</option>
                    <option name="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css">https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css</option>
                </select>
                <label for="include-jquery">jQuery</label>
                <select id="include-jquery" name="include-jquery" class="form-control">
                    <option name="null">please select</option>
                    <optgroup label="internal">internal</optgroup>
                    <option name="internal">load from internal sources (system/engines/jquery)</option>
                    <optgroup label="external">external</optgroup>
                    <option name="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js">https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js</option>
                </select>
                <label for="include-jquery">jQuery UI</label>
                <select id="include-jquery" name="include-jquery" class="form-control">
                    <option name="null">please select</option>
                    <optgroup label="internal">internal</optgroup>
                    <option name="internal">load from internal sources (system/engines/jquery)</option>
                    <optgroup label="external">external</optgroup>
                    <option name="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js">https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js</option>
                </select>
            </div>
        </div>
    </div>
    <div class="col-md-4">

        <div class="box box-default">
            <div class="box-header with-border">
                <h3 class="box-title">Optional Assets Configuration</h3>
            </div>
            <div class="box-body">
                <label for="include-animate">Animate.css</label>
                <select id="include-animate" name="include-animate" class="form-control">
                    <option name="null">please select</option>
                    <optgroup label="internal">internal</optgroup>
                    <option name="internal">load from internal sources (system/engines/animate)</option>
                    <optgroup label="external">external</optgroup>
                    <option name="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css">https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css</option>
                    <option name="https://fastcdn.org/Animate.css/3.4.0/animate.min.css">https://fastcdn.org/Animate.css/3.4.0/animate.min.css</option>
                </select>
                <label for="include-fontawesome">Font Awesome Icons</label>
                <select id="include-fontawesome" name="include-fontawesome" class="form-control">
                    <option name="null">please select</option>
                    <optgroup label="internal">internal</optgroup>
                    <option name="internal">load from internal sources (system/engines/fontawesome)</option>
                    <optgroup label="external">external</optgroup>
                    <option name="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css">https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css</option>
                </select>
                <label for="include-lightbox2">Lightbox 2</label>
                <select id="include-lightbox2" name="include-lightbox2" class="form-control">
                    <option name="null">please select</option>
                    <optgroup label="internal">internal</optgroup>
                    <option name="internal">load from internal sources (system/engines/lightbox)</option>
                    <optgroup label="external">external</optgroup>
                    <option name="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.9.0/js/lightbox.min.js">https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.9.0/js/lightbox.min.js</option>
                </select>
                <label for="include-ekkolightbox">Ekko Lightbox</label>
                <select id="include-ekkolightbox" name="include-ekkolightbox" class="form-control">
                    <option name="null">please select</option>
                    <optgroup label="internal">internal</optgroup>
                    <option name="internal">load from internal sources (system/engines/lightbox)</option>
                    <optgroup label="external">external</optgroup>
                    <option name="https://cdnjs.cloudflare.com/ajax/libs/ekko-lightbox/5.2.0/ekko-lightbox.min.js">https://cdnjs.cloudflare.com/ajax/libs/ekko-lightbox/5.2.0/ekko-lightbox.min.js</option>
                </select>
                <label for="include-bootstraplightbox">Bootstrap Lightbox</label>
                <select id="include-bootstraplightbox" name="include-bootstraplightbox" class="form-control">
                    <option name="null">please select</option>
                    <optgroup label="internal">internal</optgroup>
                    <option name="internal">load from internal sources (system/engines/...)</option>
                    <optgroup label="external">external</optgroup>
                    <option name="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-lightbox/0.7.0/bootstrap-lightbox.min.js">https://cdnjs.cloudflare.com/ajax/libs/bootstrap-lightbox/0.7.0/bootstrap-lightbox.min.js</option>
                </select>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="box box-default">
            <div class="box-header with-border">
                <h3 class="box-title">Inclusion Config</h3>
            </div>
            <div class="box-body">
                ...
            </div>
        </div>
    </div>
</div>

<div class="row animated fadeIn">
    <div class="col-md-6">
        <div class="box box-default">
            <div class="box-header with-border">
                <h3 class="box-title"><?php echo "$lang[SAVE_AS] <small>$lang[NEW_THEME]</small>"; ?></h3>
            </div>
            <div class="box-body">
                <label for="savetheme"><?php echo "$lang[SAVE_NEW_THEME_AS]"; ?></label>
                <input type="text" class="form-control" name="newthemename" value="<?php echo $template->name; ?>-copy" placeholder="<?php echo "$lang[NEW] $lang[TPL] $lang[NAME]"; ?>">
                <input type="text" class="form-control" name="description" placeholder="<?php echo "$lang[TPL] $lang[DESCRIPTION]"; ?>">
                <input type="text" class="form-control" name="positions" placeholder="<?php echo "$lang[POSITIONS] $lang[POS_DESCRIPTION]"; ?>">
                <br><input id="addbutton" type="submit" class="btn btn-danger" name="savenewtheme" value="<?php echo "$lang[SAVE_NEW_THEME_AS]"; ?>">
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="box box-default">
            <div class="box-header with-border">
                <h3 class="box-title"><?php echo "$lang[TPL_ADD_GFONT] <small>$lang[TPL_ADD_GFONT_SUBTEXT]</small>"; ?></h3>
            </div>
            <div class="box-body">
                <input type="text" class="form-control" id="gfont" name="gfont" placeholder="font eg. Ubuntu">
                <input type="text" class="form-control" name="gfontdescription" placeholder="description eg. Ubuntu, serif">
                <br><input id="savebutton" type="submit" class="btn btn-danger" name="addgfont" value="<?php echo "$lang[TPL_ADD_GFONT_BTN]"; ?>">
            </div>
        </div>
    </div>
</div>