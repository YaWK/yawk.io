<!-- color picker -->
<script type="text/javascript" src="../system/engines/jquery/jscolor/jscolor.js"></script>
<!-- Bootstrap toggle css -->
<link rel="stylesheet" href="../system/engines/bootstrap-toggle/css/bootstrap-toggle.css">
<!-- Bootstrap toggle js -->
<script type="text/javascript" src="../system/engines/bootstrap-toggle/js/bootstrap-toggle.min.js"></script>
<!-- TAB collapse -->
<script type="text/javascript" src="../system/engines/jquery/bootstrap-tabcollapse.js"></script>
<!-- CSS for positions tab -->
<style>
    .posbox
    {
        /* background-color: #fff; */
        font-weight:normal;
        border-style: dotted; border-color: #ccc;
        cursor:pointer;
    }

    .posbox:hover
    {
        border: dotted #888888;
        font-weight: bold;
        cursor:pointer;
    }
    .posboxActive
    {
        background-color: #E3E3E3;
        border: 2px solid #888888;
        font-weight: bold;
        cursor:pointer;
    }
    .bodyBox
    {
        /* background-color: #fff; */
        font-weight:normal;
        border: 1px solid #444;
        cursor:pointer;
    }
    .bodyBoxHover:hover
    {
        font-weight:bold;
    }

    .bodyBox:hover
    {
        cursor:pointer;
    }
    .bodyBoxActive
    {
        /* background-color: #E3E3E3; */
        border: 2px solid #888888;
        /* font-weight: bold; */
        cursor:pointer;
    }
</style>
<!-- Javascript for positions tab -->
<script type="text/javascript">
    /* reminder: check if form has changed and warns the user that he needs to save. */
    $(document).ready(function () {

        // re-init js color to fix dynamic loading
        jscolor.init();

        // TRY TO DISABLE CTRL-S browser hotkey
        function saveHotkey() {
            // simply disables save event for chrome
            $(window).keypress(function (event) {
                if (!(event.which == 115 && (navigator.platform.match("Mac") ? event.metaKey : event.ctrlKey)) && !(event.which == 19)) return true;
                event.preventDefault();
                formmodified=0; // do not warn user, just save.
                return false;
            });
            // used to process the cmd+s and ctrl+s events
            $(document).keydown(function (event) {
                if (event.which == 83 && (navigator.platform.match("Mac") ? event.metaKey : event.ctrlKey)) {
                    event.preventDefault();
                    $('#savebutton').click(); // SAVE FORM AFTER PRESSING STRG-S hotkey
                    formmodified=0; // do not warn user, just save.
                    // save(event);
                    return false;
                }
            });
        }
        saveHotkey();

        formmodified=0; // status
        $('form *').change(function(){ // if form has changed
            formmodified=1; // set status
            $('#savebutton').click(function(){ // if user clicked save
                formmodified=0; // do not warn user, just save.
            });
            $('#addbutton').click(function(){ // if user clicked add new theme
                formmodified=0; // do not warn user, just save the new theme.
            });
        });
        // now the function:
        window.onbeforeunload = confirmExit; // before close
        function confirmExit() {             // dialog
            if (formmodified == 1) {         // if form has changed
                return "<?php echo $lang['LEAVE_REQUEST']; ?>";
            }
        }
        // call tabCollapse: make the default bootstrap tabs responsive for handheld devices
        $('#tabs').tabCollapse({
            tabsClass: 'hidden-sm hidden-xs',
            accordionClass: 'visible-sm visible-xs'
        });

        $('[data-toggle="tooltip"]').tooltip();

    });
</script>

<?php
// new template object if not exists
if (!isset($template)) { $template = new \YAWK\template(); }
// new user object if not exists
if (!isset($user)) { $user = new \YAWK\user(); }

// check, if a session is already running
if (!isset($_SESSION) || (empty($_SESSION)))
{   // if not...
    session_start();
    $_SESSION['template'] = $template;
}

// get ID of current active template
$getID = \YAWK\settings::getSetting($db, "selectedTemplate");
// load properties of current active template
$template->loadProperties($db, $getID);
// previewButton is an empty string - why? this should be checked
$previewButton = "";

// load all template settings into array
$templateSettings = \YAWK\template::getAllSettingsIntoArray($db, $user);

// check template wrapper
\YAWK\template::checkWrapper($lang, $lang['POSITIONS'], $lang['POSITIONS']);
?>

<!-- POSITIONS -->
<h3><?php echo "$lang[DESIGN]"; ?> <small><?php echo "$lang[DESIGN_DETAILS]"; ?></small></h3>
<!-- list POSITION SETTINGS -->
<!-- MENU -->
<!-- Nav tabs -->
<ul class="nav nav-tabs" id="tabs" role="tablist">
    <li role="presentation">
        <a href="#fonts" aria-controls="fonts" role="tab" data-toggle="tab"><i class="fa fa-font"></i>
            &nbsp; <?php echo $lang['TYPOGRAPHY']; ?></a>
    </li>

    <li role="presentation">
        <a href="#menu" aria-controls="menu" role="tab" data-toggle="tab"><i class="fa fa-bars"></i>
            &nbsp; <?php echo $lang['MENU']; ?></a>
    </li>
    <li role="presentation">
        <a href="#bootstrap" aria-controls="bootstrap" role="tab" data-toggle="tab"><i class="fa fa-sticky-note-o"></i>
            &nbsp; <?php echo $lang['BOOTSTRAP3']; ?></a>
    </li>
    <li role="presentation">
        <a href="#buttons" aria-controls="buttons" role="tab" data-toggle="tab"><i class="fa fa-toggle-on"></i>
            &nbsp; <?php echo $lang['FORMS']; ?></a>
    </li>
    <li role="presentation">
        <a href="#images" aria-controls="images" role="tab" data-toggle="tab"><i class="fa fa-picture-o"></i>
            &nbsp; <?php echo $lang['IMAGES']; ?></a>
    </li>
    <!-- effects - disabled for now
        <li role="presentation">
            <a href="#effects" aria-controls="effects" role="tab" data-toggle="tab"><i class="fa fa-paper-plane-o"></i>
                &nbsp; <?php // echo $lang['EFFECTS']; ?></a>
        </li>
        -->
    <li role="presentation">
        <a href="#custom" aria-controls="custom" role="tab" data-toggle="tab"><i class="fa fa-css3"></i>
            &nbsp; <?php echo $lang['CUSTOM_CSS']; ?></a>
    </li>
    <li role="presentation">
        <a href="#settings" aria-controls="settings" role="tab" data-toggle="tab"><i class="fa fa-wrench"></i>
            &nbsp; <?php echo $lang['SETTINGS']; ?></a>
    </li>
</ul>
<div role="tabpanel" class="tab-pane" id="menu">
    <h3><?php echo "$lang[GLOBAL_MENU] <small>$lang[NAVBAR]"; ?></small></h3>
    <div class="row animated fadeIn">
        <div class="col-md-3">
            <div class="box box-default">
                <div class="box-header">
                    <h3 class="box-title"><?php echo "$lang[MENU] $lang[FONT] <small>$lang[COLORS]"; ?></small></h3>
                </div>
                <div class="box-body">
                    <!-- menu font colors -menucolor -->
                    <?php $template->getFormElements($db, $templateSettings, 10, $lang, $user); ?>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="box box-default">
                <div class="box-header">
                    <h3 class="box-title"><?php echo "$lang[MENU] $lang[BG] <small>$lang[COLORS]</small>"; ?></h3>
                </div>
                <div class="box-body">
                    <!-- menu background color -menubgcolor -->
                    <?php $template->getFormElements($db, $templateSettings, 11, $lang, $user); ?>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="box box-default">
                <div class="box-header">
                    <h3 class="box-title"><?php echo "$lang[MENU] $lang[DROPDOWN] <small>$lang[COLORS]</small>"; ?></h3>
                </div>
                <div class="box-body">
                    <!-- menu background color -menudropdowncolor -->
                    <?php $template->getFormElements($db, $templateSettings, 12, $lang, $user); ?>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="box box-default">
                <div class="box-header">
                    <h3 class="box-title"><?php echo "$lang[MENU] $lang[NAVBAR] <small>$lang[POSITIONING]</small>"; ?></h3>
                </div>
                <div class="box-body">
                    <!-- menu navbar margin top -navbar-marginTop -->
                    <?php $template->getFormElements($db, $templateSettings, 13, $lang, $user); ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- WELL,LISTGROUP, JUMBOTRON -->
<div role="tabpanel" class="tab-pane" id="bootstrap">
    <h3><?php echo "$lang[BOOTSTRAP3] <small>$lang[SETTINGS]</small>"; ?></h3>
    <div class="row animated fadeIn">
        <div class="col-md-3">
            <div class="box box-default">
                <div class="box-header">
                    <h3 class="box-title"><?php echo "$lang[WELL] $lang[BOX] <small>$lang[DESIGN]</small>"; ?></h3>
                </div>
                <div class="box-body">
                    <!-- well box design  well- -->
                    <?php $template->getFormElements($db, $templateSettings, 14, $lang, $user); ?>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="box box-default">
                <div class="box-header">
                    <h3 class="box-title"><?php echo "$lang[LIST_GROUP] <small>$lang[DESIGN]</small>"; ?></h3>
                </div>
                <div class="box-body">
                    <!-- listgroup design  listgroup-  -->
                    <?php $template->getFormElements($db, $templateSettings, 15, $lang, $user); ?>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="box box-default">
                <div class="box-header">
                    <h3 class="box-title"><?php echo "$lang[JUMBOTRON] <small>$lang[BOX] $lang[DESIGN]</small>"; ?></h3>
                </div>
                <div class="box-body">
                    <!-- jumbotron design  jumbotron-  -->
                    <?php $template->getFormElements($db, $templateSettings, 16, $lang, $user); ?>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="box box-default">
                <div class="box-header">
                    <h3 class="box-title">... <small>...</small></h3>
                </div>
                <div class="box-body">
                    <?php // $template->getSetting($db, "%-menudropdowncolor", "", ""); ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- BUTTONS -->
<div role="tabpanel" class="tab-pane" id="buttons">
    <h3><?php echo "$lang[FORMS] <small>$lang[AND] $lang[BUTTONS] </small>"; ?></h3>
    <div class="row animated fadeIn">

        <div class="col-md-4">
            <!-- btn basic settings -->
            <div class="box box-default">
                <div class="box-header">
                    <h3 class="box-title"><?php echo "$lang[BUTTON] <small>$lang[FONT] $lang[AND] $lang[BORDER] $lang[SETTINGS]</small>"; ?></h3>
                </div>
                <div class="box-body">
                    <!-- btn settings    btn-   -->
                    <?php $template->getFormElements($db, $templateSettings, 17, $lang, $user); ?>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="box box-default">
                <div class="box-header">
                    <h3 class="box-title"><?php echo "$lang[FORM] <small>$lang[SETTINGS]</small>"; ?></h3>
                </div>
                <div class="box-body">
                    <!-- form settings    form-   -->
                    <?php $template->getFormElements($db, $templateSettings, 25, $lang, $user); ?>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="box box-default">
                <div class="box-header">
                    <h3 class="box-title"><?php echo "$lang[FORM] <small>$lang[SETTINGS]</small>"; ?></h3>
                </div>
                <div class="box-body">
                    <!-- form settings    form-   -->
                    <?php $template->getFormElements($db, $templateSettings, 51, $lang, $user); ?>
                </div>
            </div>
        </div>
    </div>

    <div class="row animated fadeIn">
        <div class="col-md-2">
            <div class="box box-default">
                <div class="box-header">
                    <h3 class="box-title">Default <small>Button</small></h3>
                </div>
                <div class="box-body">
                    <!-- btn default    btn-default   -->
                    <?php $template->getFormElements($db, $templateSettings, 18, $lang, $user); ?>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="box box-default">
                <div class="box-header">
                    <h3 class="box-title">Primary <small>Button</small></h3>
                </div>
                <div class="box-body">
                    <!-- btn primary    btn-primary   -->
                    <?php $template->getFormElements($db, $templateSettings, 19, $lang, $user); ?>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="box box-default">
                <div class="box-header">
                    <h3 class="box-title">Success <small>Button</small></h3>
                </div>
                <div class="box-body">
                    <!-- btn success   btn-success   -->
                    <?php $template->getFormElements($db, $templateSettings, 20, $lang, $user); ?>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="box box-default">
                <div class="box-header">
                    <h3 class="box-title">Warning <small>Button</small></h3>
                </div>
                <div class="box-body">
                    <!-- btn warning   btn-warning   -->
                    <?php $template->getFormElements($db, $templateSettings, 21, $lang, $user); ?>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="box box-default">
                <div class="box-header">
                    <h3 class="box-title">Danger <small>Button</small></h3>
                </div>
                <div class="box-body">
                    <!-- btn danger   btn-danger   -->
                    <?php $template->getFormElements($db, $templateSettings, 22, $lang, $user); ?>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="box box-default">
                <div class="box-header">
                    <h3 class="box-title">Info <small>Button</small></h3>
                </div>
                <div class="box-body">
                    <!-- btn info   btn-info   -->
                    <?php $template->getFormElements($db, $templateSettings, 23, $lang, $user); ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- IMAGES -->
<div role="tabpanel" class="tab-pane" id="images">
    <h3><?php echo "$lang[IMAGE] <small>$lang[SETTINGS]</small>"; ?></h3>
    <div class="row animated fadeIn">
        <div class="col-md-3">
            <div class="box box-default">
                <div class="box-header">
                    <h3 class="box-title"><?php echo "$lang[IMAGE] <small>$lang[EFFECTS]</small>"; ?></h3>
                </div>
                <div class="box-body">
                    <!-- image settings   img-   -->
                    <?php $template->getFormElements($db, $templateSettings, 24, $lang, $user); ?>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="box box-default">
                <div class="box-header">
                    <h3 class="box-title">Any other thing <small>here...</small></h3>
                </div>
                <div class="box-body">
                    <?php // $template->getSetting($db, "%-menubgcolor", "", ""); ?>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="box box-default">
                <div class="box-header">
                    <h3 class="box-title">Any other thing <small>here...</small></h3>
                </div>
                <div class="box-body">
                    <?php // $template->getSetting($db, "%-menudropdowncolor", "", ""); ?>
                </div>
            </div>
        </div>
    </div>
</div>