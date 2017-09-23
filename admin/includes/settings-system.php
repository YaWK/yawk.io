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
    // force page reload to show changes immediately
    // \YAWK\sys::setTimeout("index.php?page=settings-frontend", 0);
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
echo \YAWK\backend::getTitle($lang['SETTINGS'], $lang['SYSTEM']);
echo \YAWK\backend::getSettingsBreadcrumbs($lang);
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
                <button class="btn btn-success pull-right" id="save" name="save" style="margin-top:2px;"><i class="fa fa-check"></i>&nbsp;&nbsp;<?php echo $lang['SAVE_SETTINGS']; ?></button>
            </div>
        </div>
    </div>
    <!-- SYSTEM TAB -->
    <!-- system settings -->
    <div class="row animated fadeIn">
        <div class="col-md-4">
            <!-- server seettings -->
            <div class="box">
                <div class="box-body">
                    <h3><?php echo $lang['SERVER']; ?> <small> <?php echo $lang['SERVER_SUBTEXT']; ?></small></h3>
                    <?php \YAWK\settings::getFormElements($db, $settings, 9, $lang); ?>
                    <?php \YAWK\settings::getFormElements($db, $settings, 16, $lang); ?>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <!-- database settings -->
            <div class="box">
                <div class="box-body">
                    <?php \YAWK\settings::getFormElements($db, $settings, 13, $lang); ?>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <!-- syslog settings -->
            <div class="box">
                <div class="box-body">
                    <h3><i class="fa fa-code"></i> <?php echo $lang['EDITOR']; ?> <small> <?php echo $lang['EDITOR_SUBTEXT']; ?></small></h3>
                    <?php \YAWK\settings::getFormElements($db, $settings, 14, $lang); ?>
                </div>
            </div>
        </div>
    </div>
</form>
<script type="text/javascript">
    /* START CHECKBOX timediff */

    /* END CHECKBOX backend fx */
</script>