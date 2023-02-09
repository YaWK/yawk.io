<script>
    function setCopyTplSettings(newTplName)
    {
        // store input field
        inputField = $("#newTplName");
        // when rename modal is shown
        $('#myModal').on('shown.bs.modal', function () {
            // set focus on input field and select it
            $(inputField).focus().select();
        });
        // add the current itemName to var
        inputField.val(newTplName+'-copy');
        // set text of heading span
        // $("#tplHeading").text(newTplName);
    }

    $(document).ready(function() {

        // store all elements in vars
        uploadModal = $("#uploadModal");
        savebutton = $("#savebutton");
        savebuttonIcon = $("#savebuttonIcon");
        savebuttonText = $("#savebuttonText");
        cancelButton = $("#cancelButton");
        dismissButton = $("#dismissButton");
        loadingText = $(savebutton).attr("data-loadingText");

        // following code will be executed when modal upload window is shown
        $(uploadModal).on('shown.bs.modal', function () {

            // indicate loading state by click on upload button
            $(savebutton).click(function() {

                // disable close on outer click
                $(uploadModal).attr('data-backdrop', 'static');
                // disable close on keyboard (ESC key)
                $(uploadModal).attr('data-keyboard', 'false');

                // change color of button
                $(savebutton).removeClass('btn btn-success').addClass('btn btn-warning');
                // add loading indicator (spinning icon)
                $(savebuttonIcon).removeClass('fa fa-check').addClass('fa fa-spinner fa-spin fa-fw');
                // hide times icon in upper right corner
                $(dismissButton).fadeOut();
                // load add loading indicator text to upload btn
                $(savebuttonText).html(loadingText);

                // disable buttons to avoid interrupt by user
                $(cancelButton).prop("disabled", true);
                $(savebutton).attr("disabled", true);
                // submit the form - upload template
                $('form#uploadForm').submit();
            });
        });

        // make template table sortable
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
// check if param is requested
if (isset($_GET) && (!empty($_GET)))
{
    // ACTION: download
    if (isset($_GET['action']) && ($_GET['action']) === "download")
    {   // check if template folder is set
        if (isset($_GET['folder']) && (!empty($_GET['folder'])))
        {
            // strip html and js tags from folder
            $templateFolder = strip_tags($_GET['folder']);
            // strip html and js tags from folder
            $templateID = strip_tags($_GET['id']);
            // create new tpl object
            $template = new \YAWK\template();
            // call download template method
            if ($template->downloadTemplate($db, $templateFolder, $templateID, $user) === true)
            {   // success
                \YAWK\alert::draw("success", $lang['TPL_ZIP_CREATED_TITLE'], $lang['TPL_ZIP_CREATED_MSG'], "", 2400);
            }
            else
            {   // ERROR: generating download package failed
                \YAWK\alert::draw("danger", $lang['TPL_ZIP_FAILED_TITLE'], $lang['TPL_ZIP_FAILED_MSG'], "", 8600);
            }
        }
        else
        {   // no template folder set
            die ('no folder sent');
        }
    }
    // ACTION: upload
    if (isset($_GET['action']) && ($_GET['action']) === "upload")
    {   // check if post data is set
        if (isset($_POST) && (!empty($_POST)))
        {
            // create new template object
            $template = new \YAWK\template();
            // call download template method
            if ($template->uploadTemplate($db, $_POST, $_FILES, $lang) === true)
            {   // success
                \YAWK\alert::draw("success", $lang['TPL_UPLOAD_SUCCESS_TITLE'], $lang['TPL_UPLOAD_SUCCESS_MSG'], "", 2400);
            }
            else
            {   // ERROR: generating download package failed
                \YAWK\alert::draw("danger", $lang['TPL_UPLOAD_FAILED_TITLE'], $lang['TPL_UPLOAD_FAILED_MSG'], "", 8600);
            }
        }
        else
        {   // no post data set - throw error
            \YAWK\alert::draw("danger", $lang['ERROR'], $lang['UPLOAD_FAILED'], "", 8600);
        }
    }
}
?>

<?php
// check if template obj is set and create if not exists
if (!isset($template)) { $template = new \YAWK\template(); }
// new user obj if not exists
if (!isset($user)) { $user = new \YAWK\user($db); }


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

            // load properties to make sure to view the latest active template properties
            $template->loadProperties($db, $_GET['templateID']);
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
        {   // delete success msg
            \YAWK\alert::draw("success", "<i class=\"fa fa-trash-o\"></i> $lang[TPL] $lang[DELETED]", "$lang[SUCCESS]", "", 3000);
        }
        else
        {   // failed to delete template
            \YAWK\alert::draw("danger", "$lang[TPL_FAILED_TO_DELETE] $_GET[templateID]", "$lang[PLEASE_TRY_AGAIN]", "", 3000);
        }
    }
}

// COPY TEMPLATE
if (isset($_POST['savenewtheme']) && (!empty($_POST['savenewtheme']))
    || (isset($_GET['savenewtheme']) && (!empty($_GET['savenewtheme']))))
{
    if (isset($_POST['id']) && (!empty($_POST['id'])))
    {
        $template->id = $db->quote($_POST['id']);
    }

    if (isset($_POST['name']) && (!empty($_POST['name'])))
    {
        $template->name = $db->quote($_POST['name']);
    }

    if (isset($_POST['newTplName']) && (!empty($_POST['newTplName'])))
    {
        $template->newTplName = $db->quote($_POST['newTplName']);
    }
    else if (isset($_GET['newthemename']) && (!empty($_GET['newthemename'])))
    {
        $template->newTplName = $db->quote($_GET['newthemename']);
    }

    if (isset($_POST['newTplDescription']) && (!empty($_POST['newTplDescription'])))
    {   // set new tpl description
        $template->description = $db->quote($_POST['newTplDescription']);
    }
    else if (isset($_GET['description']) && (!empty($_GET['description'])))
    {   // set new tpl description
        $template->description = $db->quote($_GET['description']);
    }
    else
    {   // new description not set, default value instead:
        $template->description = "Template Description";
    }

    if (isset($_POST['newTplAuthor']) && (!empty($_POST['newTplAuthor'])))
    {   // set new tpl author
        $template->author = $db->quote($_POST['newTplAuthor']);
    }
    else { $template->author = ''; }

    if (isset($_POST['newTplAuthorUrl']) && (!empty($_POST['newTplAuthorUrl'])))
    {   // set new tpl author URL
        $template->authorUrl = $db->quote($_POST['newTplAuthorUrl']);
    }
    else { $template->authorUrl = ''; }

    if (isset($_POST['newTplWeblink']) && (!empty($_POST['newTplWeblink'])))
    {   // set new tpl weblink
        $template->weblink = $db->quote($_POST['newTplWeblink']);
    }
    else { $template->weblink = ''; }

    if (isset($_POST['newTplVersion']) && (!empty($_POST['newTplVersion'])))
    {   // set new tpl weblink
        $template->version = $db->quote($_POST['newTplVersion']);
    }
    else { $template->version = "1.0"; }

    if (isset($_POST['newTplFramework']) && (!empty($_POST['newTplFramework'])))
    {   // set new tpl weblink
        $template->framework = $db->quote($_POST['newTplFramework']);
    }
    else { $template->version = "1.0"; }

    if (isset($_POST['newTplLicense']) && (!empty($_POST['newTplLicense'])))
    {   // set new tpl license
        $template->license = $db->quote($_POST['newTplLicense']);
    }
    else { $template->license = ''; }

    // get new template id
    $template->newId = \YAWK\template::getMaxId($db);
    $template->newId++;

    // SAVE AS new theme
    $template->saveAs($db);
    // set the new theme active in template
    \YAWK\template::setTemplateActive($db, $template->newId);
    // copy the template settings into the new template
    \YAWK\template::copyTemplateSettings($db, $template->id, $template->newId);
    // copy assets
    \YAWK\template::copyAssets($db, $template->id, $template->newId);
}

// OVERRIDE TEMPLATE
// check if call comes from template-manage or template-edit form
if (isset($_GET['id']) && (is_numeric($_GET['id']) || (isset($_POST['id']) && (is_numeric($_POST['id'])))))
{
    $getID = '';
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
        $infoBadge = "<span class=\"label label-success\"><i class=\"fa fa-eye\"></i>&nbsp;&nbsp;$lang[TPL_PREVIEW_VISIBLE_TO_YOU]</span>";
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

// get ID of current active template
$getID = \YAWK\settings::getSetting($db, "selectedTemplate");
// load properties of current active template
$template->loadProperties($db, $getID);
// previewButton is an empty string - why? this should be checked
$previewButton = "";

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
            <div class="box-body">
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
                    if (isset($template->modifyDate) && ($template->modifyDate !== NULL))
                    {   // set modifyDate
                        $modifyDate = "<dt>$lang[MODIFIED]</dt><dd>$template->modifyDate</dd>";
                    }
                    else { $modifyDate = ''; }

                    // releaseDate
                    if (isset($template->releaseDate) && ($template->releaseDate !== NULL))
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

                    // required framework
                    if (isset($template->framework) && (!empty($template->framework)))
                    {   // set required framework markup
                        $framework = "<dt>$lang[FRAMEWORK]</dt><dd>$template->framework</dd>";
                    }
                    else { $framework = ""; }

                    // license
                    if (isset($template->license) && (!empty($template->license)))
                    {   // set license markup
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

                    <?php echo $description.$author.$weblink.$framework.$license.$version.$releaseDate.$settings."<br>".$subauthor.$modifyDate; ?>

                    <dt>&nbsp;</dt>
                    <dd>&nbsp;</dd>

                    <dt><?php echo $lang['ASSETS']; ?></dt>
                    <dd>
                        <?php echo $lang['ASSETS_USED']; ?><br>
                        <?php \YAWK\template::drawAssetsTitles($db, $template->id, $lang); ?>
                    </dd>
                    <dt>&nbsp;</dt>
                    <dd>&nbsp;</dd>
                </dl>
            </div>
        </div>
    </div>
    <div class="col-md-7">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title"><?php echo $lang['TPL_MANAGE']; ?></h3>
            </div>
            <div class="box-body">

                <a href="#" data-toggle="modal" data-target="#uploadModal" class="btn btn-success pull-right"><?php echo $lang['TPL_UPLOAD']; ?></a>
                <table style="width:100%;" id="table-sort" class="table table-striped table-hover table-responsive">
                    <thead>
                    <tr>
                        <td class="text-center"><strong><?php echo $lang['STATUS']; ?></strong></td>
                        <td><strong><?php echo $lang['PREVIEW']; ?></strong></td>
                        <td><strong><?php echo $lang['ID']; ?></strong></td>
                        <td><strong><i class="fa fa-caret-down"></i> <?php print $lang['TEMPLATE']; ?></strong></td>
                        <td><strong><?php print $lang['SCREENSHOT']; ?></strong></td>
                        <td class="text-center"><strong><?php print $lang['ACTIONS']; ?></strong></td>
                    </tr>
                    </thead>
                    <tbody>

                    <?php
                    $activeBoldStart = '';  // indicate active template (make it bold)
                    $activeBoldEnd = ''; // indicate active template (end bold)
                    $statusText = ''; // online/offline tooltip
                    // get active tpl name
                    $activeTemplate = \YAWK\template::getCurrentTemplateName($db, "backend", 0);
                    $userTemplateID = \YAWK\user::getUserTemplateID($db, $user->id);
                    if ($res = $db->query("SELECT * FROM {templates} ORDER BY active DESC"))
                    {
                        // fetch templates and draw a tbl row in a while loop
                        while($row = mysqli_fetch_assoc($res))
                        {   // get active template id
                            $activeTemplateId = \YAWK\settings::getSetting($db, "selectedTemplate");

                            // set copy icon
                            $tplCopyName = $row['name']."-copy";
                            $tplName = $row['name'];

                            if ($row['id'] === $activeTemplateId)
                            {   // set published online
                                $pub = "success"; $pubtext="$lang[ONLINE]";
                                $statusText = "$lang[TPL_ON]";
                                // do not allow to delete current active template
                                $deleteIcon = "<i class=\"fa fa-ban\" title=\"$lang[TPL_DEL_FAILED_DUE_ACTIVE]\"></i>";
                                $copyIcon = "<a title=\"$lang[COPY]\" onclick=\"setCopyTplSettings('$tplName');\" href=\"#\" data-toggle=\"modal\" data-target=\"#myModal\" data-tplName=\"$row[name]\"><i class=\"fa fa-copy\"></i></a>";
                            }
                            else if ($row['id'] === "1" && ($activeTemplateId !== $row['id']))
                            {   // do not allow to delete default template
                                $pub = "danger"; $pubtext = "$lang[OFFLINE]";
                                $statusText = "$lang[TPL_OFF]";
                                $deleteIcon = "<i class=\"fa fa-ban\" title=\"$lang[TPL_DEL_DEFAULT_FAILED]\"></i>";
                                $copyIcon = "<span title=\"$lang[COPY_ONLY_ACTIVE_TPL]\" href=\"#\"<i class=\"fa fa-copy text-muted\"></i></span>";
                            }
                            else
                            {   // set published offline
                                $pub = "danger"; $pubtext = "$lang[OFFLINE]";
                                $statusText = "$lang[TPL_OFF]";
                                // delete template button
                                $deleteIcon = "<a class=\"fa fa-trash-o\" role=\"dialog\" data-confirm=\"$lang[TPL_DEL_CONFIRM] &laquo;".$row['name']." ID: ".$row['id']."&raquo;\"
                                title=\"".$lang['TEMPLATE']."&nbsp;".$lang['DELETE']."\" href=\"index.php?page=template-overview&delete=1&templateID=".$row['id']."\"></a>";
                                $previewLabel = '';
                                $copyIcon = "<span title=\"$lang[COPY_ONLY_ACTIVE_TPL]\" href=\"#\"<i class=\"fa fa-copy text-muted\"></i></span>";
                            }
                            if ($row['id'] == ($userTemplateID) && ($row['id'] == $activeTemplateId))
                            {
                                $previewLabel = "<a href=\"index.php?page=template-overview&overrideTemplate=1&id=".$row['id']."\" data-toggle=\"tooltip\" title=\"$lang[TPL_CURRENTLY_ACTIVE]\">
                                <span class=\"label label-success\"><i class=\"fa fa-eye\"></i> &nbsp;&nbsp;$lang[ACTIVE]</span></a>";
                                $activeBoldStart = "<b>";
                                $activeBoldEnd = "</b>";
                            }
                            else if ($row['id'] == ($userTemplateID))
                            {
                                $previewLabel = "<a href=\"index.php?page=template-overview&overrideTemplate=1&id=".$row['id']."\" data-toggle=\"tooltip\" title=\"$lang[TPL_ENABLE_PREVIEW]\">
                                <span class=\"label label-success\"><i class=\"fa fa-eye-slash\"></i> &nbsp;&nbsp;$lang[PREVIEW] $lang[ACTIVE]</span></a>";
                                $activeBoldStart = "<b>";
                                $activeBoldEnd = "</b>";
                            }
                            else
                            {
                                $previewLabel = "<a href=\"index.php?page=template-overview&overrideTemplate=1&id=".$row['id']."\" data-toggle=\"tooltip\" title=\"$lang[TPL_ENABLE_PREVIEW]\">
                                <span class=\"label label-default\"><i class=\"fa fa-eye-slash\"></i> &nbsp;&nbsp;$lang[PREVIEW]</span></a>";
                                $activeBoldStart = "";
                                $activeBoldEnd = "";
                            }

                            // set template image (screenshot)
                            $screenshot = "../system/templates/".$row['name']."/images/screenshot.jpg";
                            if (!file_exists($screenshot))
                            {   // sorry, no screenshot available
                                $screenshot = "$lang[NO_SCREENSHOT]";
                                // $screenshot = "<img src=\"http://placehold.it/220x150\" class=\"img-responsive img-rounded\">";
                            }
                            else
                            {   // screenshot found, display
                                $screenshot = "<img src=\"../system/templates/".$row['name']."/images/screenshot.jpg\" width=\"200\" class=\"img-rounded\">";
                            }

                            $description = "copy of: ".$row['name']."";
                            $downloadIcon = "<a id=\"downloadTemplateLink-$row[id]\" title=\"$lang[TPL_DOWNLOAD]\" href=\"index.php?page=template-overview&action=download&folder=$tplName&id=$row[id]\" data-tplName=\"$tplName\"><i id=\"downloadTemplateIcon-$row[id]\" class=\"fa fa-file-zip-o\"></i></a>";

                            echo "<tr>
          <td class=\"text-center\">
            <a data-toggle=\"tooltip\" title=\"$statusText\" href=\"index.php?page=template-overview&toggle=1&templateID=".$row['id']."\">
            <span class=\"label label-$pub\">$pubtext</span></a>&nbsp;</td>
          <td>".$previewLabel."</td>
          <td>".$row['id']."</td>
          <td>".$activeBoldStart."<a href=\"index.php?page=template-positions&id=".$row['id']."\"><div style=\"width:100%\">".$row['name']."</div></a>".$row['description']."".$activeBoldEnd."</td>
          <td><a href=\"index.php?page=template-positions&id=".$row['id']."\" title=\"$lang[EDIT]: ".$row['name']."\">".$screenshot."</a></td>
          <td class=\"text-center\">
            $downloadIcon &nbsp;            
            $copyIcon &nbsp;
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

<!-- Modal ==COPY TEMPLATE== -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModal2Label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form enctype="multipart/form-data" action="index.php?page=template-overview&savenewtheme=true" method="POST">
                <div class="modal-header">
                    <!-- modal header with close controls -->
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i> </button>
                    <br>
                    <div class="col-md-1"><h3 class="modal-title"><i class="fa fa-copy"></i></h3></div>
                    <div class="col-md-11"><h3 class="modal-title"><?php echo $lang['SAVE_NEW_THEME_AS']; ?> <!-- gets filled via JS setRenameFieldState--></h3></div>
                </div>

                <!-- modal body -->
                <div class="modal-body">
                    <!-- save to... folder select options -->
                    <label id="newTplNameLabel" for="newTplName"><?php echo $lang['TPL_NEW_NAME']; ?></label>
                    <input id="newTplName" class="form-control" name="newTplName">
                    <input id="name" type="hidden" name="name" value="<?php echo $template->name; ?>">
                    <input id="id" type="hidden" name="id" value="<?php echo $template->id; ?>">
                    <label for="newTplDescription"><?php echo $lang['DESCRIPTION']; ?></label>
                    <textarea id="newTplDescription" class="form-control" name="newTplDescription" placeholder="<?php echo $lang['SHORT_DESCRIPTION_PH']; ?>"></textarea>
                    <label id="newTplAuthorLAbel" for="newTplAuthor"><?php echo $lang['AUTHOR']; ?></label>
                    <input id="newTplAuthor" class="form-control" name="newTplAuthor" placeholder="<?php echo $lang['AUTHOR_PH']; ?>">
                    <label id="newTplAuthorUrlLabel" for="newTplAuthorUrl"><?php echo $lang['AUTHOR']."&nbsp;".$lang['URL']; ?></label>
                    <input id="newTplAuthorUrl" class="form-control" name="newTplAuthorUrl" placeholder="https://">
                    <label id="newTplWeblinkLabel" for="newTplWeblink"><?php echo $lang['WEBLINK']; ?></label>
                    <input id="newTplWeblink" class="form-control" name="newTplWeblink" placeholder="https://">
                    <label id="newTplVersionLabel" for="newTplVersion"><?php echo $lang['VERSION']; ?></label>
                    <input id="newTplVersion" class="form-control" name="newTplVersion" placeholder="1.0">
                    <label id="newTplFrameworkLabel" for="newTplFramework"><?php echo $lang['FRAMEWORK']; ?></label>
                    <select id="newTplFramework" class="form-control" name="newTplFramework">
                        <?php if ($template->framework == "bootstrap4") { $bs4Selected = " selected"; } else { $bs4Selected = ''; } ?>
                        <?php if ($template->framework == "bootstrap3") { $bs3Selected = " selected"; } else { $bs3Selected = ''; } ?>
                        <option value="bootstrap4"<?php echo $bs4Selected;?>>Bootstrap 4</option>
                        <option value="bootstrap3"<?php echo $bs3Selected;?>>Bootstrap 3</option>
                    </select>
                    <label id="newTplLicenseLabel" for="newTplLicense"><?php echo $lang['LICENSE']; ?></label>
                    <select id="newTplLicense" class="form-control" name="newTplLicense">
                        <option value=""><?php echo $lang['PLEASE_SELECT']; ?></option>
                        <option value="MIT">MIT License</option>
                        <option value="GPL-2.0">GPL 2.0 License</option>
                        <option value="GPL-3.0">GPL 3.0 License</option>
                        <option value="LGPL-2.0">Lesser GPL 2.0</option>
                        <option value="LGPL-2.1">Lesser GPL 2.1</option>
                    </select>
                </div>

                <!-- modal footer /w submit btn -->
                <div class="modal-footer">
                    <input class="btn btn-large btn-success" type="submit" value="<?php echo $lang['SAVE_NEW_THEME_AS']; ?>">
                    <br><br>
                </div>
            </form>
        </div> <!-- modal content -->
    </div> <!-- modal dialog -->
</div>


<!-- Modal ==UPLOAD MODAL== -->
<div class="modal fade" id="uploadModal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="uploadModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form enctype="multipart/form-data" id="uploadForm" action="index.php?page=template-overview&action=upload" method="POST">
                <div class="modal-header">
                    <!-- modal header with close controls -->
                    <button id="dismissButton" type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i> </button>
                    <br>
                    <div class="col-md-1"><h3 class="modal-title"><i class="fa fa-download"></i></h3></div>
                    <div class="col-md-11"><h3 class="modal-title"><?php echo $lang['TPL_INSTALL']; ?> <!-- gets filled via JS setRenameFieldState--></h3></div>
                </div>

                <!-- modal body -->
                <div class="modal-body">
                    <!-- template upload field -->
                    <input type="hidden" name="MAX_FILE_SIZE" value="67108864">
                    <input type="file" name="templateFile" id="templateFile" title="<?php echo $lang['TPL_SELECT_FILE']; ?>" class="btn btn-lg btn-default" style="width: 100%;">
                    <label for="templateFile"><?php echo $lang['POST_MAX_SIZE']; echo \YAWK\filemanager::getPostMaxSize();
                        echo " &nbsp; / &nbsp; ".$lang['UPLOAD_MAX_SIZE']; echo \YAWK\filemanager::getUploadMaxFilesize(); ?>
                        &nbsp;<i class="fa fa-question-circle-o text-info" data-placement="auto right" data-toggle="tooltip" title="" data-original-title="<?php echo $lang['UPLOAD_MAX_PHP']; ?>"></i>
                    </label>
                    <hr>
                    <i class="fa fa-exclamation-triangle animated tada"></i> &nbsp;<?php echo $lang['TPL_UPLOAD_HELP']; ?>
                    <?php echo $lang['TPL_UPLOAD_TIP']; ?>

                </div>

                <!-- modal footer /w submit btn -->
                <div class="modal-footer">
                    <input id="cancelButton" class="btn btn-large btn-default" data-dismiss="modal" aria-hidden="true" type="submit" value="<?php echo $lang['CANCEL']; ?>">
                    <button id="savebutton" data-loadingText="<?php echo $lang['TPL_LOADING']; ?>" class="btn btn-success" type="submit"><i id="savebuttonIcon" class="fa fa-check"></i> &nbsp;&nbsp;<span id="savebuttonText"><?php echo $lang['TPL_UPLOAD']; ?></span></button>
                    <br><br>
                </div>
            </form>
        </div> <!-- modal content -->
    </div> <!-- modal dialog -->
</div>