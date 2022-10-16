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

// new database object if not exists
if (!isset($db)) { $db = new db(); }
// new template object if not exists
if (!isset($template)) { $template = new template(); }
// new user object if not exists
if (!isset($user)) { $user = new user($db); }

// get ID of current active template
$getID = settings::getSetting($db, "selectedTemplate");

// switch postion borders
if (isset($_GET['positionIndicatorStatus']))
{
    if ($template->switchPositionIndicators($db, $getID, $_GET['positionIndicatorStatus']))
    {
        alert::draw("success", $lang['OK'], $lang['SWITCHED_POS_INDICATOR_SUCCESS'], '', 1800);
    }
    else
    {
        alert::draw("danger", $lang['ERROR'], $lang['SWITCHED_POS_INDICATOR_FAILED'], '', 5000);
    }
}
// get current template settings as array
$templateSettings = template::getAllSettingsIntoArray($db, $user);

?>

<!-- color picker -->
<script type="text/javascript" src="../system/engines/jquery/jscolor/jscolor.js"></script>
<!-- Bootstrap toggle css -->
<link rel="stylesheet" href="../system/engines/bootstrap-toggle/css/bootstrap-toggle.css">
<!-- Bootstrap toggle js -->
<script type="text/javascript" src="../system/engines/bootstrap-toggle/js/bootstrap-toggle.min.js"></script>

<!-- CSS for positions tab -->
<style>
    .posbox
    {
        /* background-color: #fff; */
        font-weight:normal;
        border-style: dotted; border-color: #ccc;
        cursor:pointer;
        overflow: hidden;
    }

    .posbox:hover
    {
        border: dotted #888888;
        font-weight: bold;
        cursor:pointer;
        overflow: hidden;
    }
    .posboxActive
    {
        /* background-color: #E3E3E3; */
        background-color: #e8e8e8;
        border: 2px solid #888888;
        font-weight: bold;
        cursor:pointer;
        overflow: hidden;
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
        overflow: hidden;
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
            if (formmodified === 1) {         // if form has changed
                return "<?php echo $lang['LEAVE_REQUEST']; ?>";
            }
        }

        $('[data-toggle="tooltip"]').tooltip();

    });
</script>
<?php
// TEMPLATE WRAPPER - HEADER & breadcrumbs
echo "
    <!-- Content Wrapper. Contains page content -->
    <div class=\"content-wrapper\" id=\"content-FX\">
    <!-- Content Header (Page header) -->
    <section class=\"content-header\">";
// draw Title on top
echo backend::getTitle($lang['TPL'], $lang['POSITIONS']);
echo backend::getTemplateBreadcrumbs($lang);
echo"</section><!-- Main content -->
    <section class=\"content\">";
/* page content start here */
?>
<form id="template-edit-form" action="index.php?page=template-save&action=template-positions&id=<?php echo $getID; ?>" method="POST">
    <!-- title header -->
    <div class="box">
        <div class="box-body">
            <div class="col-md-10">
                <?php echo "<h4><i class=\"fa fa-cube\"></i> &nbsp;$lang[POSITIONS]  <small>$lang[TPL_POSITION_SETTINGS]</small></h4>"; ?>
            </div>
            <div class="col-md-2">
                <button class="btn btn-success pull-right" id="savebutton" name="save" style="margin-top:2px;"><i class="fa fa-check" id="savebuttonIcon"></i>&nbsp;&nbsp;<?php echo $lang['DESIGN_SAVE']; ?></button>
            </div>
        </div>
    </div>
    <!-- list POSITION SETTINGS -->
    <div class="row animated fadeIn">

        <div class="col-md-3">
            <div class="box box-with-border" id="posboxSettings">
                <div class="box-body">
                    <div id="selectPositionRequestInfo">
                        <h4 class="box-title"><?php echo "$lang[TPL_SELECT_POSITIONS_REQUEST]"; ?></h4>
                    </div>

                    <!-- settings body -->
                    <div id="settings_pos_body">
                        <?php $template->getFormElements($db, $templateSettings, 54, $lang, $user); ?>
                    </div>
                    <!-- settings outerTop -->
                    <div id="settings_pos_outerTop">
                        <?php $template->getFormElements($db, $templateSettings, 26, $lang, $user); ?>
                    </div>
                    <!-- settings intro -->
                    <div id="settings_pos_intro">
                        <?php $template->getFormElements($db, $templateSettings, 27, $lang, $user); ?>
                    </div>
                    <!-- settings globalmenu -->
                    <div id="settings_pos_globalmenu">
                        <?php $template->getFormElements($db, $templateSettings, 28, $lang, $user); ?>
                    </div>
                    <!-- settings top -->
                    <div id="settings_pos_top">
                        <?php $template->getFormElements($db, $templateSettings, 29, $lang, $user); ?>
                    </div>
                    <!-- settings outerLeft -->
                    <div id="settings_pos_outerLeft">
                        <?php $template->getFormElements($db, $templateSettings, 30, $lang, $user); ?>
                    </div>
                    <!-- settings outerRight -->
                    <div id="settings_pos_outerRight">
                        <?php $template->getFormElements($db, $templateSettings, 31, $lang, $user); ?>
                    </div>
                    <!-- settings leftMenu -->
                    <div id="settings_pos_leftMenu">
                        <?php $template->getFormElements($db, $templateSettings, 32, $lang, $user); ?>
                    </div>
                    <!-- settings rightMenu -->
                    <div id="settings_pos_rightMenu">
                        <?php $template->getFormElements($db, $templateSettings, 33, $lang, $user); ?>
                    </div>
                    <!-- settings mainTop -->
                    <div id="settings_pos_mainTop">
                        <?php $template->getFormElements($db, $templateSettings, 34, $lang, $user); ?>
                    </div>
                    <!-- settings mainTopLeft -->
                    <div id="settings_pos_mainTopLeft">
                        <?php $template->getFormElements($db, $templateSettings, 35, $lang, $user); ?>
                    </div>
                    <!-- settings mainTopCenter -->
                    <div id="settings_pos_mainTopCenter">
                        <?php $template->getFormElements($db, $templateSettings, 36, $lang, $user); ?>
                    </div>
                    <!-- settings mainTopRight -->
                    <div id="settings_pos_mainTopRight">
                        <?php $template->getFormElements($db, $templateSettings, 37, $lang, $user); ?>
                    </div>
                    <!-- settings main -->
                    <div id="settings_pos_mainLeft">
                        <?php $template->getFormElements($db, $templateSettings, 56, $lang, $user); ?>
                    </div>
                    <!-- settings main -->
                    <div id="settings_pos_main">
                        <?php $template->getFormElements($db, $templateSettings, 38, $lang, $user); ?>
                    </div>
                    <!-- settings main -->
                    <div id="settings_pos_mainRight">
                        <?php $template->getFormElements($db, $templateSettings, 57, $lang, $user); ?>
                    </div>
                    <!-- settings mainBottom -->
                    <div id="settings_pos_mainBottom">
                        <?php $template->getFormElements($db, $templateSettings, 39, $lang, $user); ?>
                    </div>
                    <!-- settings mainBottomLeft -->
                    <div id="settings_pos_mainBottomLeft">
                        <?php $template->getFormElements($db, $templateSettings, 40, $lang, $user); ?>
                    </div>
                    <!-- settings mainBottomCenter -->
                    <div id="settings_pos_mainBottomCenter">
                        <?php $template->getFormElements($db, $templateSettings, 41, $lang, $user); ?>
                    </div>
                    <!-- settings mainBottomRight -->
                    <div id="settings_pos_mainBottomRight">
                        <?php $template->getFormElements($db, $templateSettings, 42, $lang, $user); ?>
                    </div>
                    <!-- settings mainFooter -->
                    <div id="settings_pos_mainFooter">
                        <?php $template->getFormElements($db, $templateSettings, 43, $lang, $user); ?>
                    </div>
                    <!-- settings mainFooterLeft -->
                    <div id="settings_pos_mainFooterLeft">
                        <?php $template->getFormElements($db, $templateSettings, 44, $lang, $user); ?>
                    </div>
                    <!-- settings mainFooterCenter -->
                    <div id="settings_pos_mainFooterCenter">
                        <?php $template->getFormElements($db, $templateSettings, 45, $lang, $user); ?>
                    </div>
                    <!-- settings mainFooterRight -->
                    <div id="settings_pos_mainFooterRight">
                        <?php $template->getFormElements($db, $templateSettings, 46, $lang, $user); ?>
                    </div>
                    <!-- settings footer -->
                    <div id="settings_pos_footer">
                        <?php $template->getFormElements($db, $templateSettings, 47, $lang, $user); ?>
                    </div>
                    <!-- settings hiddenToolbar -->
                    <div id="settings_pos_hiddenToolbar">
                        <?php $template->getFormElements($db, $templateSettings, 48, $lang, $user); ?>
                    </div>
                    <!-- settings debug -->
                    <div id="settings_pos_debug">
                        <?php $template->getFormElements($db, $templateSettings, 49, $lang, $user); ?>
                    </div>
                    <!-- settings outerBottom  -->
                    <div id="settings_pos_outerBottom">
                        <?php $template->getFormElements($db, $templateSettings, 50, $lang, $user); ?>
                    </div>
                </div>
                <br>
            </div>
        </div>

        <div class="col-md-9">
            <div class="box box-default">
                <div class="box-header with-border">
                    <h3 class="box-title"><?php echo "$lang[POSITIONS] <small>$lang[SETTINGS]</small>"; ?></h3>
                    <div id="toolbar" class="text-right">
                        <a href="index.php?page=template-positions&positionIndicatorStatus=1"><i class="fa fa-check-square-o" title="<?php echo $lang['ENABLE_POS_INDICATOR']; ?>"></i></a>
                        | <a href="index.php?page=template-positions&positionIndicatorStatus=0"><i class="fa fa-square-o" title="<?php echo $lang['DISABLE_POS_INDICATOR']; ?>"></i></a>
                    </div>
                </div>
                <?php
                $enabledBorder = "border: 1px solid #4CAE4C;";
                $disabledBorder = "border: 1px dashed #ccc;";

                if (isset($templateSettings['pos-outerTop-enabled']['value'])
                    && ($templateSettings['pos-outerTop-enabled']['value']) === "1")
                {   $outerTopEnabled = $enabledBorder; }
                else
                {   $outerTopEnabled = $disabledBorder; }

                if (isset($templateSettings['pos-intro-enabled']['value'])
                    && ($templateSettings['pos-intro-enabled']['value']) === "1")
                {   $introEnabled = $enabledBorder; }
                else
                {   $introEnabled = $disabledBorder; }

                if (isset($templateSettings['pos-outerLeft-enabled']['value'])
                    && ($templateSettings['pos-outerLeft-enabled']['value']) === "1")
                {   $outerLeftEnabled = $enabledBorder; }
                else
                {   $outerLeftEnabled = $disabledBorder; }

                if (isset($templateSettings['pos-globalmenu-enabled']['value'])
                    && ($templateSettings['pos-globalmenu-enabled']['value']) === "1")
                {   $globalmenuEnabled = $enabledBorder; }
                else
                {   $globalmenuEnabled = $disabledBorder; }

                if (isset($templateSettings['pos-top-enabled']['value'])
                    && ($templateSettings['pos-top-enabled']['value']) === "1")
                {   $topEnabled = $enabledBorder; }
                else
                {   $topEnabled = $disabledBorder; }

                if (isset($templateSettings['pos-leftMenu-enabled']['value'])
                    && ($templateSettings['pos-leftMenu-enabled']['value']) === "1")
                {   $leftMenuEnabled = $enabledBorder; }
                else
                {   $leftMenuEnabled = $disabledBorder; }

                if (isset($templateSettings['pos-mainTop-enabled']['value'])
                    && ($templateSettings['pos-mainTop-enabled']['value']) === "1")
                {   $mainTopEnabled = $enabledBorder; }
                else
                {   $mainTopEnabled = $disabledBorder; }

                if (isset($templateSettings['pos-mainTopLeft-enabled']['value'])
                    && ($templateSettings['pos-mainTopLeft-enabled']['value']) === "1")
                {   $mainTopLeftEnabled = $enabledBorder; }
                else
                {   $mainTopLeftEnabled = $disabledBorder; }

                if (isset($templateSettings['pos-mainTopCenter-enabled']['value'])
                    && ($templateSettings['pos-mainTopCenter-enabled']['value']) === "1")
                {   $mainTopCenterEnabled = $enabledBorder; }
                else
                {   $mainTopCenterEnabled = $disabledBorder; }

                if (isset($templateSettings['pos-mainTopRight-enabled']['value'])
                    && ($templateSettings['pos-mainTopRight-enabled']['value']) === "1")
                {   $mainTopRightEnabled = $enabledBorder; }
                else
                {   $mainTopRightEnabled = $disabledBorder; }

                if (isset($templateSettings['pos-mainLeft-enabled']['value'])
                    && ($templateSettings['pos-mainLeft-enabled']['value']) === "1")
                {   $mainLeftEnabled = $enabledBorder; }
                else
                {   $mainLeftEnabled = $disabledBorder; }

                if (isset($templateSettings['pos-main-enabled']['value'])
                    && ($templateSettings['pos-main-enabled']['value']) === "1")
                {   $mainEnabled = $enabledBorder; }
                else
                {   $mainEnabled = $disabledBorder; }

                if (isset($templateSettings['pos-mainRight-enabled']['value'])
                    && ($templateSettings['pos-mainRight-enabled']['value']) === "1")
                {   $mainRightEnabled = $enabledBorder; }
                else
                {   $mainRightEnabled = $disabledBorder; }

                if (isset($templateSettings['pos-mainBottom-enabled']['value'])
                    && ($templateSettings['pos-mainBottom-enabled']['value']) === "1")
                {   $mainBottomEnabled = $enabledBorder; }
                else
                {   $mainBottomEnabled = $disabledBorder; }

                if (isset($templateSettings['pos-mainBottomLeft-enabled']['value'])
                    && ($templateSettings['pos-mainBottomLeft-enabled']['value']) === "1")
                {   $mainBottomLeftEnabled = $enabledBorder; }
                else
                {   $mainBottomLeftEnabled = $disabledBorder; }

                if (isset($templateSettings['pos-mainBottomCenter-enabled']['value'])
                    && ($templateSettings['pos-mainBottomCenter-enabled']['value']) === "1")
                {   $mainBottomCenterEnabled = $enabledBorder; }
                else
                {   $mainBottomCenterEnabled = $disabledBorder; }

                if (isset($templateSettings['pos-mainBottomRight-enabled']['value'])
                    && ($templateSettings['pos-mainBottomRight-enabled']['value']) === "1")
                {   $mainBottomRightEnabled = $enabledBorder; }
                else
                {   $mainBottomRightEnabled = $disabledBorder; }

                if (isset($templateSettings['pos-mainFooter-enabled']['value'])
                    && ($templateSettings['pos-mainFooter-enabled']['value']) === "1")
                {   $mainFooterEnabled = $enabledBorder; }
                else
                {   $mainFooterEnabled = $disabledBorder; }

                if (isset($templateSettings['pos-mainFooterLeft-enabled']['value'])
                    && ($templateSettings['pos-mainFooterLeft-enabled']['value']) === "1")
                {   $mainFooterLeftEnabled = $enabledBorder; }
                else
                {   $mainFooterLeftEnabled = $disabledBorder; }

                if (isset($templateSettings['pos-mainFooterCenter-enabled']['value'])
                    && ($templateSettings['pos-mainFooterCenter-enabled']['value']) === "1")
                {   $mainFooterCenterEnabled = $enabledBorder; }
                else
                {   $mainFooterCenterEnabled = $disabledBorder; }

                if (isset($templateSettings['pos-mainFooterRight-enabled']['value'])
                    && ($templateSettings['pos-mainFooterRight-enabled']['value'])=== "1")
                {   $mainFooterRightEnabled = $enabledBorder; }
                else
                {   $mainFooterRightEnabled = $disabledBorder; }

                if (isset($templateSettings['pos-rightMenu-enabled']['value'])
                    && ($templateSettings['pos-rightMenu-enabled']['value']) === "1")
                {   $rightMenuEnabled = $enabledBorder; }
                else
                {   $rightMenuEnabled = $disabledBorder; }

                if (isset($templateSettings['pos-footer-enabled']['value'])
                    && ($templateSettings['pos-footer-enabled']['value']) === "1")
                {   $footerEnabled = $enabledBorder; }
                else
                {   $footerEnabled = $disabledBorder; }

                if (isset($templateSettings['pos-hiddenToolbar-enabled']['value'])
                    && ($templateSettings['pos-hiddenToolbar-enabled']['value']) === "1")
                {   $hiddenToolbarEnabled = $enabledBorder; }
                else
                {   $hiddenToolbarEnabled = $disabledBorder; }

                if (isset($templateSettings['pos-debug-enabled']['value'])
                    && ($templateSettings['pos-debug-enabled']['value']) === "1")
                {   $debugEnabled = $enabledBorder; }
                else
                {   $debugEnabled = $disabledBorder; }

                if (isset($templateSettings['pos-outerRight-enabled']['value'])
                    && ($templateSettings['pos-outerRight-enabled']['value']) === "1")
                {   $outerRightEnabled = $enabledBorder; }
                else
                {   $outerRightEnabled = $disabledBorder; }

                if (isset($templateSettings['pos-outerBottom-enabled']['value'])
                    && ($templateSettings['pos-outerBottom-enabled']['value']) === "1")
                {   $outerBottomEnabled = $enabledBorder; }
                else
                {   $outerBottomEnabled = $disabledBorder; }
                ?>

                <script type="text/javascript">
                    function resetPositionBoxes()
                    {
                        $(pos_body).removeClass("bodyBoxActive").toggleClass("bodyBox");
                        $(pos_outerTop).removeClass("posboxActive").toggleClass("posbox");
                        $(pos_outerLeft).removeClass("posboxActive").toggleClass("posbox");
                        $(pos_outerRight).removeClass("posboxActive").toggleClass("posbox");
                        $(pos_leftMenu).removeClass("posboxActive").toggleClass("posbox");
                        $(pos_rightMenu).removeClass("posboxActive").toggleClass("posbox");
                        $(pos_intro).removeClass("posboxActive").toggleClass("posbox");
                        $(pos_globalmenu).removeClass("posboxActive").toggleClass("posbox");
                        $(pos_top).removeClass("posboxActive").toggleClass("posbox");
                        $(pos_mainTop).removeClass("posboxActive").toggleClass("posbox");
                        $(pos_mainTopLeft).removeClass("posboxActive").toggleClass("posbox");
                        $(pos_mainTopCenter).removeClass("posboxActive").toggleClass("posbox");
                        $(pos_mainTopRight).removeClass("posboxActive").toggleClass("posbox");
                        $(pos_mainLeft).removeClass("posboxActive").toggleClass("posbox");
                        $(pos_main).removeClass("posboxActive").toggleClass("posbox");
                        $(pos_mainRight).removeClass("posboxActive").toggleClass("posbox");
                        $(pos_mainBottom).removeClass("posboxActive").toggleClass("posbox");
                        $(pos_mainBottomLeft).removeClass("posboxActive").toggleClass("posbox");
                        $(pos_mainBottomCenter).removeClass("posboxActive").toggleClass("posbox");
                        $(pos_mainBottomRight).removeClass("posboxActive").toggleClass("posbox");
                        $(pos_mainFooter).removeClass("posboxActive").toggleClass("posbox");
                        $(pos_mainFooterLeft).removeClass("posboxActive").toggleClass("posbox");
                        $(pos_mainFooterCenter).removeClass("posboxActive").toggleClass("posbox");
                        $(pos_mainFooterRight).removeClass("posboxActive").toggleClass("posbox");
                        $(pos_footer).removeClass("posboxActive").toggleClass("posbox");
                        $(pos_hiddenToolbar).removeClass("posboxActive").toggleClass("posbox");
                        $(pos_debug).removeClass("posboxActive").toggleClass("posbox");
                        $(pos_outerBottom).removeClass("posboxActive").toggleClass("posbox");
                    }
                    function hideAllPositionSettings()
                    {
                        $(settings_pos_body).hide();
                        $(settings_pos_outerTop).hide();
                        $(settings_pos_outerLeft).hide();
                        $(settings_pos_outerRight).hide();
                        $(settings_pos_leftMenu).hide();
                        $(settings_pos_rightMenu).hide();
                        $(settings_pos_intro).hide();
                        $(settings_pos_globalmenu).hide();
                        $(settings_pos_top).hide();
                        $(settings_pos_mainTop).hide();
                        $(settings_pos_mainTopLeft).hide();
                        $(settings_pos_mainTopCenter).hide();
                        $(settings_pos_mainTopRight).hide();
                        $(settings_pos_mainLeft).hide();
                        $(settings_pos_main).hide();
                        $(settings_pos_mainRight).hide();
                        $(settings_pos_mainBottom).hide();
                        $(settings_pos_mainBottomLeft).hide();
                        $(settings_pos_mainBottomCenter).hide();
                        $(settings_pos_mainBottomRight).hide();
                        $(settings_pos_mainFooter).hide();
                        $(settings_pos_mainFooterLeft).hide();
                        $(settings_pos_mainFooterCenter).hide();
                        $(settings_pos_mainFooterRight).hide();
                        $(settings_pos_footer).hide();
                        $(settings_pos_hiddenToolbar).hide();
                        $(settings_pos_debug).hide();
                        $(settings_pos_outerBottom).hide();
                    }

                    // hide settings on load for better visual clarity
                    hideAllPositionSettings();

                    // onclick any position, this function will display all settings of this clicked position
                    function switchPosition(pos)
                    {
                        // contains the name of settings div box from current selected position
                        var settingsPosition = '#settings_'+pos;
                        // contains the name of div box from current selected position
                        var currentPosition = '#'+pos;

                        // hide info text (select any position...)
                        $("#selectPositionRequestInfo").hide();
                        // to make sure just to display settings for selected position
                        hideAllPositionSettings();
                        // simulate a position toggle feel
                        resetPositionBoxes();
                        // display settings for current clicked position
                        $(settingsPosition).fadeToggle();
                        if (pos !== "pos_body")
                        {   // toggle css class to display which position is selected
                            $(currentPosition).toggleClass("posboxActive");
                            $(pos_bodyWrapper).removeClass("bodyBoxActive").addClass("bodyBox");
                        }
                        else
                        {
                            // toggle css class to display, if body is selected
                            $(pos_bodyWrapper).toggleClass("bodyBoxActive");
                        }
                    }
                </script>

                <div class="box-body bodyBox" id="pos_bodyWrapper">
                    <div class="text-center">
                        <div class="col-md-12 bodyBoxHover" onclick="switchPosition('pos_body')" id="pos_body" style="height: 50px; border-width: 0 0 0 0; margin-bottom:5px; width: 100%; text-align: center">
                            &laquo;body&raquo;
                        </div>
                    </div>

                    <div class="text-center">
                        <div class="col-md-12 posbox" onclick="switchPosition('pos_outerTop')" id="pos_outerTop" style="height: 30px; margin-bottom:5px; width: 100%; text-align: center; <?php echo $outerTopEnabled; ?>">&laquo;outerTop&raquo;</div>
                    </div>
                    <div class="text-center">
                        <div class="col-md-2 posbox" onclick="switchPosition('pos_outerLeft')" id="pos_outerLeft" style="height: 630px; margin-bottom:5px; text-align: center; <?php echo $outerLeftEnabled; ?>">&laquo;outerLeft&raquo;</div>
                        <div class="col-md-8">
                            <div class="row">
                                <div onclick="switchPosition('pos_intro')" class="col-md-12 posbox" id="pos_intro" style="height: 30px; margin-bottom:5px; width: 100%; text-align: center; <?php echo $introEnabled; ?>">&laquo;intro&raquo;</div>
                                <div onclick="switchPosition('pos_globalmenu')" class="col-md-12 posbox" id="pos_globalmenu" style="height: 30px; margin-bottom:5px; width: 100%; text-align: center; <?php echo $globalmenuEnabled; ?>">&laquo;globalmenu&raquo;</div>
                                <div onclick="switchPosition('pos_top')" class="col-md-12 posbox" id="pos_top" style="height: 30px; margin-bottom:5px; width: 100%; text-align: center; <?php echo $topEnabled; ?>">&laquo;top&raquo;</div>
                            </div>
                            <div class="row">
                                <div onclick="switchPosition('pos_leftMenu')" class="col-md-2 posbox" id="pos_leftMenu" style="height: 410px; margin-bottom:5px; text-align: center; <?php echo $leftMenuEnabled; ?>">&laquo;leftMenu&raquo;</div>
                                <div class="col-md-8" style="height: auto; margin-bottom:5px; text-align: center;">
                                    <div class="row">
                                        <div onclick="switchPosition('pos_mainTop')" class="col-md-12 posbox" id="pos_mainTop" style="height: 30px; margin-bottom:5px; text-align: center; <?php echo $mainTopEnabled; ?>">&laquo;mainTop&raquo;</div>
                                    </div>
                                    <div class="row">
                                        <div onclick="switchPosition('pos_mainTopLeft')" class="col-md-4 posbox" id="pos_mainTopLeft" style="height: 30px; margin-bottom:5px; text-align: center; <?php echo $mainTopLeftEnabled; ?>">&laquo;mainTopLeft&raquo;</div>
                                        <div onclick="switchPosition('pos_mainTopCenter')" class="col-md-4 posbox" id="pos_mainTopCenter" style="height: 30px; margin-bottom:5px; text-align: center; <?php echo $mainTopCenterEnabled; ?>">&laquo;mainTopCenter&raquo;</div>
                                        <div onclick="switchPosition('pos_mainTopRight')" class="col-md-4 posbox" id="pos_mainTopRight" style="height: 30px; margin-bottom:5px; text-align: center; <?php echo $mainTopRightEnabled; ?>">&laquo;mainTopRight&raquo;</div>
                                    </div>

                                    <div class="row">
                                        <div onclick="switchPosition('pos_mainLeft')" class="col-md-2 posbox" id="pos_mainLeft" style="height: 200px; margin-bottom:5px; text-align: center; <?php echo $mainLeftEnabled; ?>">&laquo;mainLeft&raquo;</div>
                                        <div onclick="switchPosition('pos_main')" class="col-md-8 posbox" id="pos_main" style="height: 200px; margin-bottom:5px; text-align: center; <?php echo $mainEnabled; ?>">&laquo;main&raquo;</div>
                                        <div onclick="switchPosition('pos_mainRight')" class="col-md-2 posbox" id="pos_mainRight" style="height: 200px; margin-bottom:5px; text-align: center; <?php echo $mainRightEnabled; ?>">&laquo;mainRight&raquo;</div>
                                    </div>
                                    <div class="row">
                                        <div onclick="switchPosition('pos_mainBottom')" class="col-md-12 posbox" id="pos_mainBottom" style="height: 30px; margin-bottom:5px; text-align: center; <?php echo $mainBottomEnabled; ?>">&laquo;mainBottom&raquo;</div>
                                    </div>
                                    <div class="row">
                                        <div onclick="switchPosition('pos_mainBottomLeft')" class="col-md-4 posbox" id="pos_mainBottomLeft" style="height: 30px; margin-bottom:5px; text-align: center; <?php echo $mainBottomLeftEnabled; ?>">&laquo;mainBottomLeft&raquo;</div>
                                        <div onclick="switchPosition('pos_mainBottomCenter')" class="col-md-4 posbox" id="pos_mainBottomCenter" style="height: 30px; margin-bottom:5px; text-align: center; <?php echo $mainBottomCenterEnabled; ?>">&laquo;mainBottomCenter&raquo;</div>
                                        <div onclick="switchPosition('pos_mainBottomRight')" class="col-md-4 posbox" id="pos_mainBottomRight" style="height: 30px; margin-bottom:5px; text-align: center; <?php echo $mainBottomRightEnabled; ?>">&laquo;mainBottomRight&raquo;</div>
                                    </div>
                                    <div class="row">
                                        <div onclick="switchPosition('pos_mainFooter')" class="col-md-12 posbox" id="pos_mainFooter" style="height: 30px; margin-bottom:5px; text-align: center; <?php echo $mainFooterEnabled; ?>">&laquo;mainFooter&raquo;</div>
                                    </div>
                                    <div class="row">
                                        <div onclick="switchPosition('pos_mainFooterLeft')" class="col-md-4 posbox" id="pos_mainFooterLeft" style="height: 30px; margin-bottom:5px; text-align: center; <?php echo $mainFooterLeftEnabled; ?>">&laquo;mainFooterLeft&raquo;</div>
                                        <div onclick="switchPosition('pos_mainFooterCenter')" class="col-md-4 posbox" id="pos_mainFooterCenter" style="height: 30px; margin-bottom:5px; text-align: center; <?php echo $mainFooterCenterEnabled; ?>">&laquo;mainFooterCenter&raquo;</div>
                                        <div onclick="switchPosition('pos_mainFooterRight')" class="col-md-4 posbox" id="pos_mainFooterRight" style="height: 30px; margin-bottom:5px; text-align: center; <?php echo $mainFooterRightEnabled; ?>">&laquo;mainFooterRight&raquo;</div>
                                    </div>
                                </div>
                                <div onclick="switchPosition('pos_rightMenu')" class="col-md-2 posbox" id="pos_rightMenu" style="height: 410px; margin-bottom:5px; text-align: center; <?php echo $rightMenuEnabled; ?>">&laquo;rightMenu&raquo;</div>
                            </div>

                            <div class="row">
                                <div onclick="switchPosition('pos_footer')" class="col-md-12 posbox" id="pos_footer" style="height: 30px; margin-bottom:5px; text-align: center; <?php echo $footerEnabled; ?>">&laquo;footer&raquo;</div>
                            </div>
                            <div class="row">
                                <div onclick="switchPosition('pos_hiddenToolbar')" class="col-md-12 posbox" id="pos_hiddenToolbar" style="height: 30px; margin-bottom:5px; text-align: center; <?php echo $hiddenToolbarEnabled; ?>">&laquo;hiddenToolbar&raquo;</div>
                            </div>
                            <div class="row">
                                <div onclick="switchPosition('pos_debug')" class="col-md-12 posbox" id="pos_debug" style="height: 30px; margin-bottom:5px; text-align: center; <?php echo $debugEnabled; ?>">&laquo;debug&raquo;</div>
                            </div>
                        </div>
                        <div onclick="switchPosition('pos_outerRight')" class="col-md-2 posbox" id="pos_outerRight" style="height: 630px; margin-bottom:5px; text-align: center; <?php echo $outerRightEnabled; ?>">&laquo;outerRight&raquo;</div>

                    </div>

                    <div class="text-center">
                        <div onclick="switchPosition('pos_outerBottom')" class="col-md-12 posbox" id="pos_outerBottom" style="height: 30px; margin-bottom:5px; width: 100%; text-align: center; <?php echo $outerBottomEnabled; ?>">&laquo;outerBottom&raquo;</div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</form>