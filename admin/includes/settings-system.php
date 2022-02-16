<?php

use YAWK\alert;
use YAWK\backend;
use YAWK\db;
use YAWK\language;
use YAWK\settings;
use YAWK\template;

/** @var $db db */
/** @var $lang language */

// SAVE tpl settings
if(isset($_POST['save']))
{
    // loop through $_POST items
    foreach ($_POST as $property => $value)
    {
        if ($property != "save")
        {
            // check setting and call corresponding function
            if (substr($property, -5, 5) == '-long')
            {   // LONG VALUE SETTINGS
                if (!settings::setLongSetting($db, $property, $value))
                {   // throw error
                    alert::draw("warning", "Error", "Long Settings: Could not set long value <b>$value</b> of property <b>$property</b>","plugin=signup","4800");
                }
            }
            else
            {
                if ($property === "selectedTemplate")
                {
                    template::setTemplateActive($db, $value);
                }

                // save value of property to database
                settings::setSetting($db, $property, $value, $lang);
            }
        }
    }
    // force page reload to show changes immediately
    // \YAWK\sys::setTimeout("index.php?page=settings-frontend", 0);
}
?>
<?php
// get all template settings into array
$settings = settings::getAllSettingsIntoArray($db);
// TEMPLATE WRAPPER - HEADER & breadcrumbs
echo "
    <!-- Content Wrapper. Contains page content -->
    <div class=\"content-wrapper\" id=\"content-FX\">
    <!-- Content Header (Page header) -->
    <section class=\"content-header\">";
// draw Title on top
echo backend::getTitle($lang['SETTINGS'], $lang['SYSTEM']);
echo backend::getSettingsBreadcrumbs($lang);
echo"</section><!-- Main content -->
    <section class=\"content\">";
/* page content start here */
?>
<form id="frontend-edit-form" action="index.php?page=settings-system" method="POST">
    <div class="box">
        <div class="box-body">
            <div class="col-md-10">
                <?php echo "<h4><i class=\"fa fa-cogs\"></i> &nbsp;".$lang['SYSTEM_SUBTEXT']."</h4>"; ?>
            </div>
            <div class="col-md-2">
                <button class="btn btn-success pull-right" id="savebutton" name="save" style="margin-top:2px;"><i class="fa fa-check" id="savebuttonIcon"></i>&nbsp;&nbsp;<?php echo $lang['SAVE_SETTINGS']; ?></button>
            </div>
        </div>
    </div>
    <!-- SYSTEM TAB -->
    <!-- system settings -->
    <div class="row animated fadeIn">
        <div class="col-md-4">
            <!-- server settings -->
            <div class="box">
                <div class="box-body">
                    <h3><?php echo $lang['SERVER']; ?> <small> <?php echo $lang['SERVER_SUBTEXT']; ?></small></h3>
                    <?php settings::getFormElements($db, $settings, 9, $lang); ?>
                    <?php settings::getFormElements($db, $settings, 16, $lang); ?>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <!-- database settings -->
            <div class="box">
                <div class="box-body">
                    <?php settings::getFormElements($db, $settings, 13, $lang); ?>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <!-- syslog settings -->
            <div class="box">
                <div class="box-body">
                    <h3><i class="fa fa-code"></i> <?php echo $lang['EDITOR']; ?> <small> <?php echo $lang['EDITOR_SUBTEXT']; ?></small></h3>
                    <?php settings::getFormElements($db, $settings, 14, $lang); ?>
                </div>
            </div>
        </div>
    </div>
</form>
<script type="text/javascript">
    /* START CHECKBOX timediff */
    $(document).ready(function() {
        function saveHotkey() {
            // simply disables save event for chrome
            $(window).keypress(function (event) {
                if (!(event.which === 115 && (navigator.platform.match("Mac") ? event.metaKey : event.ctrlKey)) && !(event.which === 19)) return true;
                event.preventDefault();
                formmodified = 0; // do not warn user, just save.
                return false;
            });
            // used to process the cmd+s and ctrl+s events
            $(document).keydown(function (event) {
                if (event.which === 83 && (navigator.platform.match("Mac") ? event.metaKey : event.ctrlKey)) {
                    event.preventDefault();
                    $('#savebutton').click(); // SAVE FORM AFTER PRESSING STRG-S hotkey
                    formmodified = 0; // do not warn user, just save.
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
        $(savebutton).click(function () {
            $(savebutton).removeClass('btn btn-success').addClass('btn btn-warning disabled');
            $(savebuttonIcon).removeClass('fa fa-check').addClass('fa fa-spinner fa-spin fa-fw');
        });
    });
    /* END CHECKBOX backend fx */
</script>