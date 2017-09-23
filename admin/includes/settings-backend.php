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
    // load page again to show changes immediately
    \YAWK\sys::setTimeout("index.php?page=settings-backend", 0);
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
<form id="backend-edit-form" action="index.php?page=settings-backend" method="POST">
    <div class="box">
        <div class="box-body">
            <div class="col-md-10">
                <?php echo "<h4><i class=\"fa fa-sign-in\"></i> &nbsp;$lang[BACKEND_SUBTEXT]</h4>"; ?>
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
<script type="text/javascript">

    var backendFooter = $('#backendFooter');

    /* START CHECKBOX backend footer */
    // check backend footer checkbox STATUS ONLOAD
    if( $(backendFooter).prop('checked')){
        // box is checked, set input field to NOT disabled
        $("#backendFooterValueLeft").prop('disabled', false);
        $("#backendFooterValueRight").prop('disabled', false);
        $("#backendFooterCopyright").prop('disabled', false);
    }
    else {
        // box is not checked, set field to disabled
        $("#backendFooterValueLeft").prop('disabled', true);
        $("#backendFooterValueRight").prop('disabled', true);
        $("#backendFooterCopyright").prop('disabled', true);
    }
    // check wheter the footer checkbox IS CLICKED
    $(backendFooter).click(function(){ // if user clicked save
        if( $('#backendFooter').prop('checked')){
            // box is checked, set input field to NOT disabled
            $("#backendFooterValueLeft").prop('disabled', false);
            $("#backendFooterValueRight").prop('disabled', false);
            $("#backendFooterCopyright").prop('disabled', false);
        }
        else {
            // set footer value input field to disabled
            $("#backendFooterValueLeft").prop('disabled', true);
            $("#backendFooterValueRight").prop('disabled', true);
            $("#backendFooterCopyright").prop('disabled', true);
        }
    });
    // check wheter the footer copyright checkbox is clicked
    $('#backendFooterCopyright').click(function(){ // if user clicked save
        if( $('#backendFooterCopyright').prop('checked')){
            // box is checked, set input field to NOT disabled
            $("#backendFooterValueLeft").prop('disabled', true);
            $("#backendFooterValueRight").prop('disabled', true);
        }
        else {
            // set footer value input field to disabled
            $("#backendFooterValueLeft").prop('disabled', false);
            $("#backendFooterValueRight").prop('disabled', false);
        }
    });
    /* END CHECKBOX backend footer */

    /* START CHECKBOX backend logo */
    // check backend footer checkbox onload
    if( $('#backendLogoUrl').prop('checked')){
        // box is checked, set input field to NOT disabled
        $("#backendLogoText").prop('disabled', true);
        $("#backendLogoSubText").prop('disabled', true);
    }
    else {
        // box is not checked, set field to disabled
        $("#backendLogoText").prop('disabled', false);
        $("#backendLogoSubText").prop('disabled', false);
    }
    // check wheter the checkbox is clicked
    $('#backendLogoUrl').click(function(){ // if user clicked save
        if( $('#backendLogoUrl').prop('checked')){
            // box is checked, set input field to NOT disabled
            $("#backendLogoText").prop('disabled', true);
            $("#backendLogoSubText").prop('disabled', true);
        }
        else {
            // set footer value input field to disabled
            $("#backendLogoText").prop('disabled', false);
            $("#backendLogoSubText").prop('disabled', false);
        }
    });
    /* END CHECKBOX backend logo */

    /* START CHECKBOX backend fx */
    // check backend footer checkbox onload
    if( $('#backendFX').prop('checked')){
        // box is checked, set input field to NOT disabled
        $("#backendFXtype").prop('disabled', false);
        $("#backendFXtime").prop('disabled', false);
    }
    else {
        // box is not checked, set field to disabled
        $("#backendFXtype").prop('disabled', true);
        $("#backendFXtime").prop('disabled', true);
    }
    // check wheter the checkbox is clicked
    $('#backendFX').click(function(){ // if user clicked save
        if( $('#backendFX').prop('checked')){
            // box is checked, set input field to NOT disabled
            $("#backendFXtype").prop('disabled', false);
            $("#backendFXtime").prop('disabled', false);
        }
        else {
            // set footer value input field to disabled
            $("#backendFXtype").prop('disabled', true);
            $("#backendFXtime").prop('disabled', true);
        }
    });
    /* END CHECKBOX backend fx */
</script>