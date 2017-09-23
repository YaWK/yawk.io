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
echo \YAWK\backend::getTitle($lang['SETTINGS'], $lang['FRONTEND']);
echo \YAWK\backend::getSettingsBreadcrumbs($lang);
echo"</section><!-- Main content -->
    <section class=\"content\">";
/* page content start here */
?>
<form id="frontend-edit-form" action="index.php?page=settings-frontend" method="POST">
    <div class="box">
        <div class="box-body">
            <div class="col-md-10">
                <?php echo "<h4><i class=\"fa fa-globe\"></i> &nbsp;".$lang['FRONTEND_SUBTEXT']."</h4>"; ?>
            </div>
            <div class="col-md-2">
                <button class="btn btn-success pull-right" id="save" name="save" style="margin-top:2px;"><i class="fa fa-check"></i>&nbsp;&nbsp;<?php echo $lang['SAVE_SETTINGS']; ?></button>
            </div>
        </div>
    </div>
    <div class="row">
                <!-- frontend settings -->
                <div class="col-md-4">
                    <!-- theme selector -->
                    <div class="box">
                        <div class="box-body">
                            <?php \YAWK\settings::getFormElements($db, $settings, 3, $lang); ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="box">
                        <div class="box-body">
                    <!-- publish settings -->
                    <?php \YAWK\settings::getFormElements($db, $settings, 7, $lang); ?>
                    <!-- user login settings -->
                    <?php \YAWK\settings::getFormElements($db, $settings, 17, $lang); ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="box">
                        <div class="box-body">
                    <!-- maintenance mode -->
                    <?php \YAWK\settings::getFormElements($db, $settings, 8, $lang); ?>
                        </div>
                    </div>
                </div>
    </div>
</form>
<script type="text/javascript">
    /* START CHECKBOX timediff */
    // check backend footer checkbox onload
    if( $('#timediff').prop('checked')){
        // box is checked, set input field to NOT disabled
        $("#timedifftext").prop('disabled', false);
    }
    else {
        // box is not checked, set field to disabled
        $("#timedifftext").prop('disabled', true);
    }
    // check wheter the checkbox is clicked
    $('#timediff').click(function(){ // if user clicked save
        if( $('#timediff').prop('checked')){
            // box is checked, set input field to NOT disabled
            $("#timedifftext").prop('disabled', false);
        }
        else {
            // set footer value input field to disabled
            $("#timedifftext").prop('disabled', true);
        }
    });
    /* END CHECKBOX backend footer */

    /* START CHECKBOX offline mode */
    // check backend footer checkbox onload
    if( $('#offline').prop('checked')){
        // box is checked, set input field to NOT disabled
        $("#offlinemsg").prop('disabled', false);
        $("#offlineimage").prop('disabled', false);
    }
    else {
        // box is not checked, set field to disabled
        $("#offlinemsg").prop('disabled', true);
        $("#offlineimage").prop('disabled', true);
    }
    // check wheter the checkbox is clicked
    $('#offline').click(function(){ // if user clicked save
        if( $('#offline').prop('checked')){
            // box is checked, set input field to NOT disabled
            $("#offlinemsg").prop('disabled', false);
            $("#offlineimage").prop('disabled', false);
        }
        else {
            // set footer value input field to disabled
            $("#offlinemsg").prop('disabled', true);
            $("#offlineimage").prop('disabled', true);
        }
    });
    /* END CHECKBOX backend fx */
</script>