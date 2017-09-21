<?php
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
                if (!\YAWK\settings::setLongSetting($db, $property, $value))
                {   // throw error
                    \YAWK\alert::draw("warning", "Error", "Long Settings: Could not set long value <b>$value</b> of property <b>$property</b>","plugin=signup","4800");
                }
            }
            else
            {
                if ($property === "selectedTemplate")
                {
                    \YAWK\template::setTemplateActive($db, $value);
                }

                // save value of property to database
                \YAWK\settings::setSetting($db, $property, $value, $lang);
            }
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
// draw Title on top
echo \YAWK\backend::getTitle($lang['SETTINGS'], $lang['FRONTEND']);
echo"<ol class=\"breadcrumb\">
            <li><a href=\"index.php?page=settings-system\" title=\"$lang[SETTINGS]\"><i class=\"fa fa-cog\"></i> $lang[SETTINGS]</a></li>
            <li><i class=\"fa fa-globe\"></i> &nbsp;<a href=\"index.php?page=settings-frontend\" title=\"$lang[EDIT]\"> $lang[FRONTEND]</a></li>
            <li class=\"active\"><i class=\"fa fa-sign-in\"></i> &nbsp;<a href=\"index.php?page=settings-backend\" title=\"$lang[EDIT]\"> $lang[BACKEND]</a></li>
            <li><i class=\"fa fa-language\"></i> &nbsp;<a href=\"index.php?page=settings-language\" title=\"$lang[EDIT]\"> $lang[LANGUAGES]</a></li>
            <li><i class=\"fa fa-cogs\"></i> &nbsp;<a href=\"index.php?page=settings-system\" title=\"$lang[EDIT]\"> $lang[SYSTEM]</a></li>
            <li><i class=\"fa fa-android\"></i> &nbsp;<a href=\"index.php?page=settings-robots\" title=\"$lang[EDIT]\"> $lang[ROBOTS_TXT]</a></li>
            <li><i class=\"fa fa-database\"></i> &nbsp;<a href=\"index.php?page=settings-database\" title=\"$lang[EDIT]\"> $lang[DATABASE]</a></li>
            <li><i class=\"fa fa-info-circle\"></i> &nbsp;<a href=\"index.php?page=settings-systeminfo\" title=\"$lang[EDIT]\"> $lang[SYSTEM] $lang[INFO]</a></li>
        </ol></section>
    <!-- Main content -->
    <section class=\"content\">";
/* page content start here */
?>
<form id="backend-edit-form" action="index.php?page=settings-backend" method="POST">
    <div class="box">
        <div class="box-body">
            <div class="col-md-10">
                <?php echo "<h4><i class=\"fa fa-sign-in\"></i> $lang[BACKEND_SUBTEXT]</h4>"; ?>
            </div>
            <div class="col-md-2">
                <button class="btn btn-success pull-right" id="save" name="save" style="margin-top:2px;"><i class="fa fa-check"></i>&nbsp;&nbsp;<?php echo $lang['SAVE_SETTINGS']; ?></button>
            </div>
        </div>
    </div>
    <div class="row">
        <!-- backend settings -->
            <div class="col-md-4">
                <div class="box">
                    <div class="box-body">
                        <!-- backend settings -->
                        <?php \YAWK\settings::getFormElements($db, $settings, 2, $lang); ?>
                    </div>
                </div>
                <div class="box">
                    <div class="box-body">
                        <?php // \YAWK\settings::getFormElements($db, $settings, 19, $lang); ?>
                        <?php \YAWK\settings::getFormElements($db, $settings, 20, $lang); ?>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="box">
                    <div class="box-body">
                <!-- footer settings -->
                <?php \YAWK\settings::getFormElements($db, $settings, 11, $lang); ?>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="box">
                    <div class="box-body">
                <?php \YAWK\settings::getFormElements($db, $settings, 12, $lang); ?>
                    </div>
                </div>
            </div>
    </div>
</form>
