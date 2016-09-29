<!-- color picker -->
<script type="text/javascript" src="../system/engines/jquery/jscolor/jscolor.js"></script>
<!-- --><script type="text/javascript" src="../system/engines/jquery/bootstrap-tabcollapse.js"></script>
<!-- JS GO -->
<script type="text/javascript">
/* reminder: check if form has changed and warns the user that he needs to save. */
    $(document).ready(function() {
        formmodified=0; // status
        $('form *').change(function(){ // if form has changed
            formmodified=1; // set status
            $('#savebutton').click(function(){ // if user clicked save
                formmodified=0; // do not warn user, just save.
            });
        });
        // now the function:
        window.onbeforeunload = confirmExit; // before close
        function confirmExit() {             // dialog
            if (formmodified == 1) {         // if form has changed
                return "Your changes may not be saved. Do you wish to leave the page?";
            }
        }
      // call tabCollapse: make the default bootstrap tabs responsive for handheld devices
        $('#tabs').tabCollapse({
            tabsClass: 'hidden-sm hidden-xs',
            accordionClass: 'visible-sm visible-xs'
        });
    });
</script>

<?php
// create new template object
if (!isset($template)) { $template = new \YAWK\template(); }

if (isset($_GET['id']) && (is_numeric($_GET['id'])))
{   // get template properties for requested template ID
    $template->loadProperties($db, $_GET['id']);
}
else
    {   // get template properties for current active template ID
        $template->loadProperties($db, YAWK\settings::getSetting($db, "selectedTemplate"));
    }

// get current template properties


// SAVE AS new theme
if(isset($_POST['savenewtheme']) && isset($_POST['newthemename']))
{   // prepare vars
    $template->name = $db->quote($_POST['newthemename']);
    // get new template id
    $oldTemplateId = $template->id;
    $newID = \YAWK\template::getMaxId($db);
    $newTplId = $newID++;
    $template->id = $newTplId;
    // set new theme active
    \YAWK\settings::setSetting($db, "selectedTemplate", $newID);

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
    $template->saveAs($db, $template, $template->name, $template->positions, $template->description);
    // set the new theme active in template
    \YAWK\template::setTemplateActive($db, $newID);
    // copy the template settings into the new template
    \YAWK\template::copyTemplateSettings($db, $oldTemplateId, $newID);
}

// SAVE tpl settings
if(isset($_POST['save']) || isset($_POST['savenewtheme']))
{   // check and delete settings file if needed
    // $template->deleteSettingsCSSFile($db, "");
    // loop trough settings and save to database + settings.css file

    // get max ID from template db
    foreach($_POST as $property=>$value){
        if (isset($_POST['savenewtheme']))
        {
            if($property != "save" && $property != "customCSS")
            {   // save new theme settings to database
                $template->setTemplateSetting($db, $newID, $property, $value);
            }
            // if save property is customCSS
            elseif ($property === "customCSS")
            {   // save the content to /system/template/$NAME/css/custom.css
                $template->setCustomCssFile($db, $value, 0);
                // save a minified version to /system/template/$NAME/css/custom.min.css
                $template->setCustomCssFile($db, $value, 1);
            }
        }
        else
        {
            if($property != "save" && $property != "customCSS")
            {   // save theme settings to database
                $template->setTemplateSetting($db, $template->id, $property, $value);
                // to file
                $template->setTemplateCssFile($db, $template->id, $property, $value);
            }
            // if save property is customCSS
            elseif ($property == "customCSS")
            {   // save the content to /system/template/$NAME/css/custom.css
                $template->setCustomCssFile($db, $value, 0);
                // save a minified version to /system/template/$NAME/css/custom.min.css
                $template->setCustomCssFile($db, $value, 1);
            }
        }
    }
    ////////////////////////////////////////////////////////////////////////////////////////
    // get all settings for active template
    $tpl_settings = YAWK\template::getTemplateSettingsArray($db, "");
    // get HEADER FONT from db
    $headingFont = YAWK\template::getActivegfont($db, "", "heading-gfont");

    $content = "/* auto generated */
    body {   /* BODY SETTINGS */
        color: #".$tpl_settings['text-fontcolor'].";
        background-color: #".$tpl_settings['body-bg-color'].";
        text-shadow: ".$tpl_settings['body-text-shadow']." #".$tpl_settings['body-text-shadow-color'].";
        font-size: ".$tpl_settings['body-text-size'].";
        filter: dropshadow(color=#".$tpl_settings['body-text-shadow-color'].", offx=1, offy=1);
        margin-top: ".$tpl_settings['body-margin-top'].";
        margin-bottom: ".$tpl_settings['body-margin-bottom'].";
        margin-left: ".$tpl_settings['body-margin-left'].";
        margin-right: ".$tpl_settings['body-margin-right'].";

        /* BACKGROUND IMAGE */
        background-image: url('".$tpl_settings['body-bg-image']."');
        background-repeat:".$tpl_settings['body-bg-repeat'].";
        background-position:".$tpl_settings['body-bg-position'].";
        background-attachment:".$tpl_settings['body-bg-attachment'].";
        background-size: ".$tpl_settings['body-bg-attachment'].";
    }
    a { /* LINK SETTINGS */
        color: #".$tpl_settings['a-link'].";
        font-weight: bold;
        text-decoration: ".$tpl_settings['decoration-link'].";
    }
    a:visited {
        color: #".$tpl_settings['visited-link'].";
    }
    a:hover {   color: #".$tpl_settings['hover-link'].";
        text-decoration: ".$tpl_settings['hoverdecoration-link'].";
    }

        /* TYPOGRAPHY SETTINGS */
    h1 {
	   ".$headingFont."
        color: #".$tpl_settings['h1-fontcolor'].";
        font-size: ".$tpl_settings['h1-size'].";

    }
       h2 {
           ".$headingFont."
           color: #".$tpl_settings['h2-fontcolor'].";
           font-size: ".$tpl_settings['h2-size'].";
       }
       h3 {
           ".$headingFont.";
           color: #".$tpl_settings['h3-fontcolor'].";
           font-size: ".$tpl_settings['h3-size'].";
       }
       h4 {
           ".$headingFont."
           color: #".$tpl_settings['h4-fontcolor'].";
           font-size: ".$tpl_settings['h4-size'].";
       }
       h5 {
           ".$headingFont."
           color: #".$tpl_settings['h5-fontcolor'].";
           font-size: ".$tpl_settings['h5-size'].";
       }
       h6 {
           ".$headingFont."
           color: #".$tpl_settings['h6-fontcolor'].";
           font-size: ".$tpl_settings['h6-size'].";
       }
       h1 small,
       h2 small,
       h3 small,
       h4 small,
       h5 small,
       h6 small,
       .h1 small,
       .h2 small,
       .h3 small,
       .h4 small,
       .h5 small,
       .h6 small,
       h1 .small,
       h2 .small,
       h3 .small,
       h4 .small,
       h5 .small,
       h6 .small,
       .h1 .small,
       .h2 .small,
       .h3 .small,
       .h4 .small,
       .h5 .small,
       .h6 .small {
           font-weight: normal;
           line-height: 1;
           color: #".$tpl_settings['smalltag-fontcolor'].";
       }
    /* MAIN BOX SHADOW SETTINGS */
    #main-pos {
        box-shadow: ".$tpl_settings['main-box-shadow']." #".$tpl_settings['main-box-shadow-color'].";
    }
    #footer {
        box-shadow: ".$tpl_settings['main-box-shadow']." #".$tpl_settings['main-box-shadow-color'].";
    }
    #footer-copyright {
        box-shadow: ".$tpl_settings['main-box-shadow']." #".$tpl_settings['main-box-shadow-color'].";
    }

    /* WELL */
    .well {
        min-height: ".$tpl_settings['well-min-height'].";
        padding: ".$tpl_settings['well-padding'].";
        margin-bottom: ".$tpl_settings['well-margin-bottom'].";
        margin-top: ".$tpl_settings['well-margin-top'].";
        background-color: #".$tpl_settings['well-bg-color'].";
        border: ".$tpl_settings['well-border']." #".$tpl_settings['well-border-color'].";
        border-radius: ".$tpl_settings['well-border-radius'].";
        -webkit-box-shadow: ".$tpl_settings['well-shadow']." #".$tpl_settings['well-shadow-color'].";
        box-shadow: ".$tpl_settings['well-shadow']." #".$tpl_settings['well-shadow-color'].";
    }
    /* LIST GROUP */
   .list-group-item {
       color: #".$tpl_settings['fontcolor-listgroup'].";
       background-color: #".$tpl_settings['background-listgroup'].";
   }
   /* BUTTONS */
    .btn {
      color: #".$tpl_settings['btn-default-color'].";
      display: inline-block;
      padding: 6px 12px;
      margin-bottom: 0;
      font-size: ".$tpl_settings['btn-fontsize'].";
      font-weight: ".$tpl_settings['btn-font-weight'].";
      line-height: 1.42857143;
      text-align: center;
      white-space: nowrap;
      vertical-align: middle;
      -ms-touch-action: manipulation;
          touch-action: manipulation;
      cursor: pointer;
      -webkit-user-select: none;
         -moz-user-select: none;
          -ms-user-select: none;
              user-select: none;
      background-image: none;
      border: ".$tpl_settings['btn-border']." ".$tpl_settings['btn-border-style']." transparent;
      border-radius: ".$tpl_settings['btn-border-radius'].";
    }

    .btn-default {
        color: #".$tpl_settings['btn-default-color'].";
        background-color: #".$tpl_settings['btn-default-background-color'].";
        border-color: #".$tpl_settings['btn-default-border-color'].";
    }
    .btn-default:focus,
    .btn-default.focus {
        color: #".$tpl_settings['btn-default-color'].";
        background-color: #".$tpl_settings['btn-default-focus-background-color'].";
        border-color: #".$tpl_settings['btn-default-focus-background-color'].";
    }
    .btn-default:hover {
      color: #".$tpl_settings['btn-default-hover-color'].";
      background-color: #".$tpl_settings['btn-default-hover-background-color'].";
      border-color: #".$tpl_settings['btn-default-hover-border-color'].";
    }
    .btn-default:active,
    .btn-default.active,
    .open > .dropdown-toggle.btn-default {
      color: #".$tpl_settings['btn-default-color'].";
      background-color: #".$tpl_settings['btn-default-focus-background-color'].";
      border-color: #".$tpl_settings['btn-default-hover-border-color'].";
    }
    .btn-default:active:hover,
    .btn-default.active:hover,
    .open > .dropdown-toggle.btn-default:hover,
    .btn-default:active:focus,
    .btn-default.active:focus,
    .open > .dropdown-toggle.btn-default:focus,
    .btn-default:active.focus,
    .btn-default.active.focus,
    .open > .dropdown-toggle.btn-default.focus {
      color: #".$tpl_settings['btn-default-color'].";
      background-color: #".$tpl_settings['btn-default-focus-background-color'].";
      border-color: #".$tpl_settings['btn-default-hover-border-color'].";
    }
    .btn-default:active,
    .btn-default.active,
    .open > .dropdown-toggle.btn-default {
      background-image: none;
    }
    .btn-default.disabled:hover,
    .btn-default[disabled]:hover,
    fieldset[disabled] .btn-default:hover,
    .btn-default.disabled:focus,
    .btn-default[disabled]:focus,
    fieldset[disabled] .btn-default:focus,
    .btn-default.disabled.focus,
    .btn-default[disabled].focus,
    fieldset[disabled] .btn-default.focus {
      background-color: #".$tpl_settings['btn-default-background-color'].";
      border-color: #".$tpl_settings['btn-default-border-color'].";
    }
    .btn-default .badge {
      color: #".$tpl_settings['btn-default-background-color'].";
      background-color: #".$tpl_settings['btn-default-color'].";
    }

    .btn-primary {
      color: #".$tpl_settings['btn-primary-color'].";
      background-color: #".$tpl_settings['btn-primary-background-color'].";
      border-color: #".$tpl_settings['btn-primary-border-color'].";
    }
    .btn-primary:focus,
    .btn-primary.focus {
      color: #".$tpl_settings['btn-primary-color'].";
      background-color: #".$tpl_settings['btn-primary-focus-background-color'].";
      border-color: #".$tpl_settings['btn-primary-focus-border-color'].";
    }
    .btn-primary:hover {
      color: #".$tpl_settings['btn-primary-color'].";
      background-color: #".$tpl_settings['btn-primary-hover-background-color'].";
      border-color: #".$tpl_settings['btn-primary-hover-border-color'].";
    }
    .btn-primary:active,
    .btn-primary.active,
    .open > .dropdown-toggle.btn-primary {
      color: #".$tpl_settings['btn-primary-color'].";
      background-color: #".$tpl_settings['btn-primary-focus-background-color'].";
      border-color: #".$tpl_settings['btn-primary-hover-border-color'].";
    }
    .btn-primary:active:hover,
    .btn-primary.active:hover,
    .open > .dropdown-toggle.btn-primary:hover,
    .btn-primary:active:focus,
    .btn-primary.active:focus,
    .open > .dropdown-toggle.btn-primary:focus,
    .btn-primary:active.focus,
    .btn-primary.active.focus,
    .open > .dropdown-toggle.btn-primary.focus {
      color: #".$tpl_settings['btn-primary-color'].";
      background-color: #".$tpl_settings['btn-primary-focus-background-color'].";
      border-color: #".$tpl_settings['btn-primary-hover-border-color'].";
    }
    .btn-primary:active,
    .btn-primary.active,
    .open > .dropdown-toggle.btn-primary {
      background-image: none;
    }
    .btn-primary.disabled:hover,
    .btn-primary[disabled]:hover,
    fieldset[disabled] .btn-primary:hover,
    .btn-primary.disabled:focus,
    .btn-primary[disabled]:focus,
    fieldset[disabled] .btn-primary:focus,
    .btn-primary.disabled.focus,
    .btn-primary[disabled].focus,
    fieldset[disabled] .btn-primary.focus {
      background-color: #".$tpl_settings['btn-primary-background-color'].";
      border-color: #".$tpl_settings['btn-primary-border-color'].";
    }
    .btn-primary .badge {
      color: #".$tpl_settings['btn-primary-background-color'].";
      background-color: #".$tpl_settings['btn-primary-color'].";
    }

    .btn-success {
      color: #".$tpl_settings['btn-success-color'].";
      background-color: #".$tpl_settings['btn-success-background-color'].";
      border-color: #".$tpl_settings['btn-success-background-color'].";
    }
    .btn-success:focus,
    .btn-success.focus {
      color: #".$tpl_settings['btn-success-color'].";
      background-color: #".$tpl_settings['btn-success-focus-background-color'].";
      border-color: #".$tpl_settings['btn-success-focus-border-color'].";
    }
    .btn-success:hover {
      color: #".$tpl_settings['btn-success-hover-color'].";
      background-color: #".$tpl_settings['btn-success-hover-background-color'].";
      border-color: #".$tpl_settings['btn-success-hover-border-color'].";
    }
    .btn-success:active,
    .btn-success.active,
    .open > .dropdown-toggle.btn-success {
      color: #".$tpl_settings['btn-success-color'].";
      background-color: #".$tpl_settings['btn-success-focus-background-color'].";
      border-color: #".$tpl_settings['btn-success-hover-border-color'].";
    }
    .btn-success:active:hover,
    .btn-success.active:hover,
    .open > .dropdown-toggle.btn-success:hover,
    .btn-success:active:focus,
    .btn-success.active:focus,
    .open > .dropdown-toggle.btn-success:focus,
    .btn-success:active.focus,
    .btn-success.active.focus,
    .open > .dropdown-toggle.btn-success.focus {
      color: #".$tpl_settings['btn-success-color'].";
      background-color: #".$tpl_settings['btn-success-hover-border-color'].";
      border-color: #".$tpl_settings['btn-success-focus-border-color'].";
    }
    .btn-success:active,
    .btn-success.active,
    .open > .dropdown-toggle.btn-success {
      background-image: none;
    }
    .btn-success.disabled:hover,
    .btn-success[disabled]:hover,
    fieldset[disabled] .btn-success:hover,
    .btn-success.disabled:focus,
    .btn-success[disabled]:focus,
    fieldset[disabled] .btn-success:focus,
    .btn-success.disabled.focus,
    .btn-success[disabled].focus,
    fieldset[disabled] .btn-success.focus {
      background-color: #5cb85c;
      border-color: #4cae4c;
    }
    .btn-success .badge {
      color: #".$tpl_settings['btn-success-background-color'].";
      background-color: #".$tpl_settings['btn-success-color'].";
    }

    .btn-info {
      color: #".$tpl_settings['btn-info-color'].";
      background-color: #".$tpl_settings['btn-info-background-color'].";
      border-color: #".$tpl_settings['btn-info-border-color'].";
    }
    .btn-info:focus,
    .btn-info.focus {
      color: #".$tpl_settings['btn-info-color'].";
      background-color: #".$tpl_settings['btn-info-focus-background-color'].";
      border-color: #".$tpl_settings['btn-info-focus-border-color'].";
    }
    .btn-info:hover {
      color: #".$tpl_settings['btn-info-hover-color'].";
      background-color: #".$tpl_settings['btn-info-hover-background-color'].";
      border-color: #".$tpl_settings['btn-info-hover-border-color'].";
    }
    .btn-info:active,
    .btn-info.active,
    .open > .dropdown-toggle.btn-info {
      color: #".$tpl_settings['btn-info-color'].";
      background-color: #".$tpl_settings['btn-info-focus-background-color'].";
      border-color: #".$tpl_settings['btn-info-hover-border-color'].";
    }
    .btn-info:active:hover,
    .btn-info.active:hover,
    .open > .dropdown-toggle.btn-info:hover,
    .btn-info:active:focus,
    .btn-info.active:focus,
    .open > .dropdown-toggle.btn-info:focus,
    .btn-info:active.focus,
    .btn-info.active.focus,
    .open > .dropdown-toggle.btn-info.focus {
      color: #".$tpl_settings['btn-info-color'].";
      background-color: #".$tpl_settings['btn-info-hover-border-color'].";
      border-color: #".$tpl_settings['btn-info-focus-border-color'].";
    }
    .btn-info:active,
    .btn-info.active,
    .open > .dropdown-toggle.btn-info {
      background-image: none;
    }
    .btn-info.disabled:hover,
    .btn-info[disabled]:hover,
    fieldset[disabled] .btn-info:hover,
    .btn-info.disabled:focus,
    .btn-info[disabled]:focus,
    fieldset[disabled] .btn-info:focus,
    .btn-info.disabled.focus,
    .btn-info[disabled].focus,
    fieldset[disabled] .btn-info.focus {
      background-color: #5bc0de;
      border-color: #46b8da;
    }
    .btn-info .badge {
      color: #".$tpl_settings['btn-info-background-color'].";
      background-color: #".$tpl_settings['btn-info-color'].";
    }

    .btn-warning {
      color: #".$tpl_settings['btn-warning-color'].";
      background-color: #".$tpl_settings['btn-warning-background-color'].";
      border-color: #".$tpl_settings['btn-warning-border-color'].";
    }
    .btn-warning:focus,
    .btn-warning.focus {
      color: #".$tpl_settings['btn-warning-color'].";
      background-color: #".$tpl_settings['btn-warning-focus-background-color'].";
      border-color: #".$tpl_settings['btn-warning-focus-border-color'].";
    }
    .btn-warning:hover {
      color: #".$tpl_settings['btn-warning-hover-color'].";
      background-color: #".$tpl_settings['btn-warning-hover-background-color'].";
      border-color: #".$tpl_settings['btn-warning-hover-border-color'].";
    }
    .btn-warning:active,
    .btn-warning.active,
    .open > .dropdown-toggle.btn-warning {
      color: #".$tpl_settings['btn-warning-color'].";
      background-color: #".$tpl_settings['btn-warning-focus-background-color'].";
      border-color: #".$tpl_settings['btn-warning-hover-border-color'].";
    }
    .btn-warning:active:hover,
    .btn-warning.active:hover,
    .open > .dropdown-toggle.btn-warning:hover,
    .btn-warning:active:focus,
    .btn-warning.active:focus,
    .open > .dropdown-toggle.btn-warning:focus,
    .btn-warning:active.focus,
    .btn-warning.active.focus,
    .open > .dropdown-toggle.btn-warning.focus {
      color: #".$tpl_settings['btn-warning-color'].";
      background-color: #".$tpl_settings['btn-warning-hover-border-color'].";
      border-color: #".$tpl_settings['btn-warning-focus-border-color'].";
    }
    .btn-warning:active,
    .btn-warning.active,
    .open > .dropdown-toggle.btn-warning {
      background-image: none;
    }
    .btn-warning.disabled:hover,
    .btn-warning[disabled]:hover,
    fieldset[disabled] .btn-warning:hover,
    .btn-warning.disabled:focus,
    .btn-warning[disabled]:focus,
    fieldset[disabled] .btn-warning:focus,
    .btn-warning.disabled.focus,
    .btn-warning[disabled].focus,
    fieldset[disabled] .btn-warning.focus {
      background-color: #f0ad4e;
      border-color: #eea236;
    }
    .btn-warning .badge {
      color: #".$tpl_settings['btn-warning-background-color'].";
      background-color: #".$tpl_settings['btn-warning-color'].";
    }

    .btn-danger {
      color: #".$tpl_settings['btn-danger-color'].";
      background-color: #".$tpl_settings['btn-danger-background-color'].";
      border-color: #".$tpl_settings['btn-danger-border-color'].";
    }
    .btn-danger:focus,
    .btn-danger.focus {
      color: #".$tpl_settings['btn-danger-color'].";
      background-color: #".$tpl_settings['btn-danger-focus-background-color'].";
      border-color: #".$tpl_settings['btn-danger-focus-border-color'].";
    }
    .btn-danger:hover {
      color: #".$tpl_settings['btn-danger-hover-color'].";
      background-color: #".$tpl_settings['btn-danger-hover-background-color'].";
      border-color: #".$tpl_settings['btn-danger-hover-border-color'].";
    }
    .btn-danger:active,
    .btn-danger.active,
    .open > .dropdown-toggle.btn-danger {
      color: #".$tpl_settings['btn-danger-color'].";
      background-color: #".$tpl_settings['btn-danger-focus-background-color'].";
      border-color: #".$tpl_settings['btn-danger-hover-border-color'].";
    }
    .btn-danger:active:hover,
    .btn-danger.active:hover,
    .open > .dropdown-toggle.btn-danger:hover,
    .btn-danger:active:focus,
    .btn-danger.active:focus,
    .open > .dropdown-toggle.btn-danger:focus,
    .btn-danger:active.focus,
    .btn-danger.active.focus,
    .open > .dropdown-toggle.btn-danger.focus {
      color: #".$tpl_settings['btn-danger-color'].";
      background-color: #".$tpl_settings['btn-danger-hover-border-color'].";
      border-color: #".$tpl_settings['btn-danger-focus-border-color'].";
    }
    .btn-danger:active,
    .btn-danger.active,
    .open > .dropdown-toggle.btn-danger {
      background-image: none;
    }
    .btn-danger.disabled:hover,
    .btn-danger[disabled]:hover,
    fieldset[disabled] .btn-danger:hover,
    .btn-danger.disabled:focus,
    .btn-danger[disabled]:focus,
    fieldset[disabled] .btn-danger:focus,
    .btn-danger.disabled.focus,
    .btn-danger[disabled].focus,
    fieldset[disabled] .btn-danger.focus {
      background-color: #d9534f;
      border-color: #d43f3a;
    }
    .btn-danger .badge {
      color: #".$tpl_settings['btn-danger-background-color'].";
      background-color: #".$tpl_settings['btn-danger-color'].";
    }




   /* NAVBAR */
   .navbar-default {
       text-shadow: 1px 0px #".$tpl_settings['fontshadow-menucolor'].";
       filter: dropshadow(color=#".$tpl_settings['fontshadow-menucolor'].", offx=1, offy=1);
       background-color: #".$tpl_settings['default-menubgcolor'].";
       border-color: #".$tpl_settings['border-menubgcolor'].";
   }
   .navbar-default .navbar-brand {
       color: #".$tpl_settings['brand-menucolor'].";
   }
   .navbar-default .navbar-brand:hover,
   .navbar-default .navbar-brand:focus {
       color: #".$tpl_settings['brandhover-menucolor'].";
       background-color: transparent;
   }
   .navbar-default .navbar-text {
       color: #".$tpl_settings['font-menucolor'].";
   }
   .navbar-default .navbar-nav > li > a {
       color: #".$tpl_settings['font-menucolor'].";
   }
   .navbar-default .navbar-nav > li > a:hover,
   .navbar-default .navbar-nav > li > a:focus {
       color: #".$tpl_settings['fonthover-menucolor'].";
       background-color: transparent;
   }
   .navbar-default .navbar-nav > .active > a,
   .navbar-default .navbar-nav > .active > a:hover,
   .navbar-default .navbar-nav > .active > a:focus {
       color: #".$tpl_settings['fontactive-menucolor'].";
       background-color: #".$tpl_settings['active-menubgcolor'].";
   }
   .navbar-default .navbar-nav > .disabled > a,
   .navbar-default .navbar-nav > .disabled > a:hover,
   .navbar-default .navbar-nav > .disabled > a:focus {
       color: #".$tpl_settings['fontdisabled-menucolor'].";
       background-color: transparent;
   }
   .navbar-default .navbar-toggle {
       border-color: #".$tpl_settings['toggle-menubgcolor'].";
   }
   .navbar-default .navbar-toggle:hover,
   .navbar-default .navbar-toggle:focus {
       border-color:#".$tpl_settings['toggle-menubgcolor'].";
   }
   .navbar-default .navbar-toggle .icon-bar {
       background-color:#".$tpl_settings['iconbar-menubgcolor'].";
   }
   .navbar-default .navbar-collapse,
   .navbar-default .navbar-form {
       border-color: #".$tpl_settings['border-menubgcolor'].";
   }
   .navbar-default .navbar-nav > .open > a,
   .navbar-default .navbar-nav > .open > a:hover,
   .navbar-default .navbar-nav > .open > a:focus {
       background-color: #".$tpl_settings['active-menubgcolor'].";
       color: #".$tpl_settings['fontactive-menucolor'].";
   }
   @media (max-width: 767px) {
       .navbar-default .navbar-nav .open .dropdown-menu > li > a {
           color: #".$tpl_settings['font-menucolor'].";
       }
       .navbar-default .navbar-nav .open .dropdown-menu > li > a:hover,
       .navbar-default .navbar-nav .open .dropdown-menu > li > a:focus {
           color: #".$tpl_settings['fonthover-menucolor'].";
           background-color: transparent;
       }
       .navbar-default .navbar-nav .open .dropdown-menu > .active > a,
       .navbar-default .navbar-nav .open .dropdown-menu > .active > a:hover,
       .navbar-default .navbar-nav .open .dropdown-menu > .active > a:focus {
           color: #".$tpl_settings['fontactive-menucolor'].";
           background-color: #".$tpl_settings['active-menubgcolor'].";
       }
       .navbar-default .navbar-nav .open .dropdown-menu > .disabled > a,
       .navbar-default .navbar-nav .open .dropdown-menu > .disabled > a:hover,
       .navbar-default .navbar-nav .open .dropdown-menu > .disabled > a:focus {
           color: #".$tpl_settings['fontdisabled-menucolor'].";
           background-color: transparent;
       }
   }
   .navbar-default .navbar-link {
       color: #".$tpl_settings['font-menucolor'].";
   }
   .navbar-default .navbar-link:hover {
       color: #".$tpl_settings['fonthover-menucolor'].";
   }
   .navbar-default .btn-link {
       color: #".$tpl_settings['font-menucolor'].";
   }
   .navbar-default .btn-link:hover,
   .navbar-default .btn-link:focus {
       color: #".$tpl_settings['fonthover-menucolor'].";
   }
   .navbar-default .btn-link[disabled]:hover,
   fieldset[disabled] .navbar-default .btn-link:hover,
   .navbar-default .btn-link[disabled]:focus,
   fieldset[disabled] .navbar-default .btn-link:focus {
       color: #".$tpl_settings['fontdisabled-menucolor'].";
   }

   .dropdown-menu {
       position: absolute;
       top: 100%;
       left: 0;
       z-index: 1000;
       display: none;
       float: left;
       min-width: 160px;
       padding: 5px 0;
       margin: 2px 0 0;
       list-style: none;
       font-size: 14px;
       text-align: left;
       background-color: #".$tpl_settings['background-menudropdowncolor'].";
       border: 1px solid #".$tpl_settings['border-menudropdowncolor'].";
       border-radius: 4px;
       -webkit-box-shadow: 0 6px 12px rgba(0, 0, 0, 0.175);
       box-shadow: 0 6px 12px rgba(0, 0, 0, 0.175);
       -webkit-background-clip: padding-box;
       background-clip: padding-box;
   }
   .dropdown-menu.pull-right {
       right: 0;
       left: auto;
   }
   .dropdown-menu > li > a {
       display: block;
       padding: 3px 20px;
       clear: both;
       font-weight: normal;
       line-height: 1.42857143;
       color: #".$tpl_settings['border-menudropdowncolor'].";
       white-space: nowrap;
   }
   .dropdown-menu > li > a:hover,
   .dropdown-menu > li > a:focus {
       text-decoration: none;
       color: #".$tpl_settings['fonthover-menudropdowncolor'].";
       background-color: #".$tpl_settings['hoverbg-menudropdowncolor'].";
   }
   .dropdown-menu > .active > a,
   .dropdown-menu > .active > a:hover,
   .dropdown-menu > .active > a:focus {
       color: #".$tpl_settings['fontactive-menudropdowncolor'].";
       text-decoration: none;
       outline: 0;
       background-color: #".$tpl_settings['activebg-menudropdowncolor'].";
   }
   .dropdown-menu > .disabled > a,
   .dropdown-menu > .disabled > a:hover,
   .dropdown-menu > .disabled > a:focus {
       color: #".$tpl_settings['disabled-menudropdowncolor'].";
   }
   /* jQUERY form validate error mesage text color */
    .error {
        color: #".$tpl_settings['form-error'].";
        font-weight: bold;
    }
    .valid {
        color: #".$tpl_settings['form-valid'].";
        font-weight: bold;
    }

    /* YaWK ADDITIONAL CSS IMAGE SETTINGS */
     .img-shadow {
       -webkit-box-shadow: ".$tpl_settings['img-shadow']." #".$tpl_settings['img-shadow-color'].";
       box-shadow: ".$tpl_settings['img-shadow']." #".$tpl_settings['img-shadow-color'].";
       }

     .img-righty {
        -ms-transform: rotate(".$tpl_settings['img-righty']."); /* IE 9 */
        -webkit-transform: rotate(".$tpl_settings['img-righty']."); /* Chrome, Safari, Opera */
        transform: rotate(".$tpl_settings['img-righty'].");
        -webkit-filter: brightness(100%);
        -webkit-box-shadow: ".$tpl_settings['img-shadow']." #".$tpl_settings['img-shadow-color'].";
        box-shadow: ".$tpl_settings['img-shadow']." #".$tpl_settings['img-shadow-color'].";
     }

     .img-lefty {
        -ms-transform: rotate(".$tpl_settings['img-lefty']."); /* IE 9 */
        -webkit-transform: rotate(".$tpl_settings['img-lefty']."); /* Chrome, Safari, Opera */
        transform: rotate(".$tpl_settings['img-lefty'].");
        -webkit-filter: brightness(100%);
        -webkit-box-shadow: ".$tpl_settings['img-shadow']." #".$tpl_settings['img-shadow-color'].";
        box-shadow: ".$tpl_settings['img-shadow']." #".$tpl_settings['img-shadow-color'].";
     }

     .img-lefty-less {
        -ms-transform: rotate(".$tpl_settings['img-lefty-less']."); /* IE 9 */
        -webkit-transform: rotate(".$tpl_settings['img-lefty-less']."); /* Chrome, Safari, Opera */
        transform: rotate(".$tpl_settings['img-lefty-less'].");
        -webkit-filter: brightness(100%);
        -webkit-box-shadow: ".$tpl_settings['img-shadow']." #".$tpl_settings['img-shadow-color'].";
        box-shadow: ".$tpl_settings['img-shadow']." #".$tpl_settings['img-shadow-color'].";
     }

     .img-righty-less {
        -ms-transform: rotate(".$tpl_settings['img-righty-less']."); /* IE 9 */
        -webkit-transform: rotate(".$tpl_settings['img-righty-less']."); /* Chrome, Safari, Opera */
        transform: rotate(".$tpl_settings['img-righty-less'].");
        -webkit-filter: brightness(100%);
        -webkit-box-shadow: ".$tpl_settings['img-shadow']." #".$tpl_settings['img-shadow-color'].";
        box-shadow: ".$tpl_settings['img-shadow']." #".$tpl_settings['img-shadow-color'].";
     }

     .img-lefty:hover {
        -webkit-filter: brightness(".$tpl_settings['img-brightness'].");
     }
     .img-righty:hover {
        -webkit-filter: brightness(".$tpl_settings['img-brightness'].");
     }
     .img-thumbnail {
        -webkit-filter: brightness(100%);
     }
     .img-thumbnail:hover {
        -webkit-filter: brightness(".$tpl_settings['img-brightness'].");
     }
    ";
    // minify content
    // $content = \YAWK\sys::minify($content);
    // create settings.css for development purpose (css/settings.css)
    $template->setTemplateCssFile($db, $template->id, $content, 0);
    // create minified version for production environments (css/settings.min.css)
    $template->setTemplateCssFile($db, $template->id, $content, 1);

    //////////////////////////////////////////////////////////////////////////////////////
}

// ADD tpl setting
if(isset($_POST['addsetting'])){
    $property=$_POST['property'];
    $value=$_POST['value'];
    $valueDefault=$_POST['valueDefault'];
    $description=$_POST['description'];
    $fieldclass=$_POST['fieldclass'];
    $placeholder=$_POST['placeholder'];
    if($property != "addsetting"){
        $template->addTemplateSetting($db, $property, $value, $valueDefault, $description, $fieldclass, $placeholder);
    }
}
// ADD google font
if(isset($_POST['addgfont'])){
    $gfont=$_POST['gfont'];
    $description=$_POST['gfontdescription'];
    if($gfont != "addgfont"){
        $template->addgfont($db, $gfont,$description);
    }
}
// DELETE google font
if(isset($_GET['deletegfont'])){
    $gfontid=$_GET['gfontid'];
    if($gfontid != '0'){
        $template->deletegfont($db, $gfontid);
    }
}

// INIT template ID
if (isset($_GET['id']) && (is_numeric($_GET['id'])))
{   // if id is set
    $template->id = $_GET['id'];
}
else
{   // load current template id
    $template->id = \YAWK\template::getCurrentTemplateId($db);
}

// TEMPLATE WRAPPER - HEADER & breadcrumbs
echo "
    <!-- Content Wrapper. Contains page content -->
    <div class=\"content-wrapper\" id=\"content-FX\">
    <!-- Content Header (Page header) -->
    <section class=\"content-header\">";
/* draw Title on top */
echo \YAWK\backend::getTitle("ReDesign", $lang['DESIGN_DETAILS']);
echo"<ol class=\"breadcrumb\">
            <li><a href=\"index.php\" title=\"Dashboard\"><i class=\"fa fa-dashboard\"></i> Dashboard</a></li>
            <li><a href=\"index.php?page=settings-template\" title=\"Themes\"> Themes</a></li>
            <li><a href=\"index.php?page=template-edit&id=$template->id\" class=\"active\" title=\"Edit Theme\"> Edit Theme</a></li>
        </ol></section>
    <!-- Main content -->
    <section class=\"content\">";
/* page content start here */
?>
<form id="template-edit-form" action="index.php?page=template-edit" method="POST">
    <!-- <div class="nav-tabs-custom"> <!-- admin LTE tab style -->
    <div id="btn-wrapper" class="text-right">
    <input id="savebutton" type="submit" class="btn btn-success" name="save" value="<?php echo $lang['DESIGN_SAVE']; ?>">
    </div>
    <!-- FORM -->
    <!-- Nav tabs -->
    <ul class="nav nav-tabs" id="tabs" role="tablist">
        <li role="presentation" class="active"><a href="#overview" aria-controls="overview" role="tab" data-toggle="tab"><i class="fa fa-home"></i>&nbsp; <?php echo $template->name; ?></a></li>
        <li role="presentation"><a href="#fonts" aria-controls="fonts" role="tab" data-toggle="tab"><i class="fa fa-font"></i>&nbsp; Fonts</a></li>
        <li role="presentation"><a href="#typo" aria-controls="typo" role="tab" data-toggle="tab"><i class="fa fa-text-width"></i>&nbsp; Typography</a></li>
        <li role="presentation"><a href="#body" aria-controls="layout" role="tab" data-toggle="tab"><i class="fa fa-object-group"></i>&nbsp; Body</a></li>
      <!--  <li role="presentation"><a href="#colors" aria-controls="colors" role="tab" data-toggle="tab"><i class="fa fa-paint-brush"></i>&nbsp; Colors</a></li> -->
        <li role="presentation"><a href="#menu" aria-controls="menu" role="tab" data-toggle="tab"><i class="fa fa-bars"></i>&nbsp; Menu</a></li>
        <li role="presentation"><a href="#well" aria-controls="menu" role="tab" data-toggle="tab"><i class="fa fa-sticky-note-o"></i>&nbsp; Well</a></li>
        <li role="presentation"><a href="#buttons" aria-controls="menu" role="tab" data-toggle="tab"><i class="fa fa-toggle-on"></i>&nbsp; Buttons</a></li>
        <li role="presentation"><a href="#images" aria-controls="menu" role="tab" data-toggle="tab"><i class="fa fa-picture-o"></i>&nbsp; Images</a></li>
        <li role="presentation"><a href="#effects" aria-controls="effects" role="tab" data-toggle="tab"><i class="fa fa-paper-plane-o"></i>&nbsp; Effects</a></li>
        <li role="presentation"><a href="#custom" aria-controls="menu" role="tab" data-toggle="tab"><i class="fa fa-css3"></i>&nbsp; Custom CSS</a></li>
        <li role="presentation"><a href="#themes" aria-controls="themes" role="tab" data-toggle="tab"><i class="fa fa-adjust"></i>&nbsp; Themes</a></li>
        <li role="presentation"><a href="#settings" aria-controls="settings" role="tab" data-toggle="tab"><i class="fa fa-database"></i>&nbsp; Settings</a></li>
    </ul>

    <!-- Tab panes -->
    <div class="tab-content">
        <!-- OVERVIEW -->
        <div role="tabpanel" class="tab-pane active" id="overview">
            <h3>Overview <small>Template Statistics</small></h3>
            <!-- list GOOGLE FONTS -->
            <div class="row animated fadeIn">
                <div class="col-md-6">
                    <div class="box">
                        <div class="box-header with-border">
                            <h3 class="box-title">Template Details <small>of the current active theme</small></h3>
                        </div>
                        <dl class="dl-horizontal">
                            <?php
                            if (isset($template->url) && (!empty($template->url)))
                            {   // set external link html code
                                $authorUrl = "<small>&nbsp;<a href=\"$template->url\" title=\"Author's weblink [in new tab]\"
                                <i class=\"fa fa-external-link\"></i></a></small>";
                            }
                            else { $authorUrl = ''; }
                            ?>
                            <dt>Template Name</dt>
                            <dd><b><?php echo $template->name; ?></b></dd>
                            <dt>Author</dt>
                            <dd><?php echo $template->author; ?>&nbsp;<?php echo $authorUrl; ?> </dd>
                            <dt>Release Date</dt>
                            <dd><?php echo $template->releaseDate; ?></dd>
                            <dt>Version</dt>
                            <dd><?php echo $template->version; ?></dd>
                            <dt>Settings</dt>
                            <dd><?php echo $template->countTemplateSettings($db,    $template->id); ?></dd>
                            <dt>&nbsp;</dt>
                            <dd>&nbsp;</dd>
                            <dt>Description</dt>
                            <dd><?php echo $template->description; ?></dd>
                            <dt>&nbsp;</dt>
                            <dd>&nbsp;</dd>
                            <dt>Engines</dt>
                            <dd>
                                <b>Brings together what belongs together: </b><small>the best tools of our open source world.</small><br>
                                <i class="fa fa-check text-light-blue"></i> YaWK 16.9 <small>
                                <a href="http://www.getbootstrap.com/" target="_blank" title="Official Bootstrap Website [in new tab]">
                                <i class="fa fa-external-link"></i></a></small><br>

                                <i class="fa fa-check text-light-blue"></i> Boostrap 3.3.7<small>
                                <a href="http://www.getbootstrap.com/" target="_blank" title="Official Bootstrap Website [in new tab]">
                                <i class="fa fa-external-link"></i></a></small><br>

                                <i class="fa fa-check text-light-blue"></i> jQuery 1.11.3<small>
                                <a href="http://www.jquery.com/" target="_blank" title="Official jQuery Website [in new tab]">
                                <i class="fa fa-external-link"></i></a></small><br>

                                <i class="fa fa-check text-light-blue"></i> FontAwesome 4.6.3<small>
                                <a href="http://www.fontawesome.io/" target="_blank" title="Official FontAwesome Website [in new tab]">
                                <i class="fa fa-external-link"></i></a></small><br>

                                <i class="fa fa-check text-light-blue"></i> Animate CSS 3.5.2<small>
                                <a href="http://www.fontawesome.io/" target="_blank" title="Official FontAwesome Website [in new tab]">
                                <i class="fa fa-external-link"></i></a></small><br>
                            </dd>
                            <dt>&nbsp;</dt>
                            <dd>&nbsp;</dd>
                        </dl>
                    </div>
                </div>
                <div class="col-md-6">
                    <!-- 16:9 aspect ratio -->
                    <div class="embed-responsive embed-responsive-4by3">
                        <iframe id="preview" class="embed-responsive-item" src="../index.php"></iframe>
                    </div>
                    <?php
                    // $tpl = \YAWK\template::getTemplateSettingsArray($db);
                    // echo "<pre title=\"Template Settings of $template->name\"><h3>Template Settings of $template->name</h3>";print_r($tpl);echo"</pre>";
                          /* foreach (\YAWK\template::getTemplateSettingsArray($db) as $tpl) {
                              echo "$tpl<br>";
                          }*/
                    ?>
                </div>
            </div>
        </div>

        <!-- FONTS -->
        <div role="tabpanel" class="tab-pane" id="fonts">
            <h3>Fonts <small>set heading, menu and text fonts</small></h3>
            <!-- list GOOGLE FONTS -->
            <div class="row animated fadeIn">
                <div class="col-md-4">
                    <h3>H1-H6 <small>Font</small></h3>
                    <?PHP $template->getgFonts($db, "heading-gfont"); ?>
                </div>
                <div class="col-md-4">
                    <h3>Menu <small>Font</small></h3>
                    <?PHP $template->getgFonts($db, "menu-gfont"); ?>
                </div>
                <div class="col-md-4">
                    <h3>Text <small>Font</small></h3>
                    <?PHP $template->getgFonts($db, "text-gfont"); ?>
                </div>
            </div>
        </div>

        <!-- TYPO -->
        <div role="tabpanel" class="tab-pane" id="typo">
            <!-- typography styles -->
            <div class="row animated fadeIn">
                <div class="col-md-4">
                    <h3>Text <small>Settings</small></h3>
                    <?PHP  $template->getSetting($db, "body-text-size", "", ""); ?>
                    <?PHP  $template->getSetting($db, "body-text-shadow", "", ""); ?>
                    <?PHP  $template->getSetting($db, "body-text-shadow-color", "", ""); ?>

                    <h3>Link <small>Colors </small></h3>
                    <?PHP $template->getSetting($db, "%-link", "", ""); ?>
                </div>
                <div class="col-md-4">
                    <h3>Heading <small>Font Size</small></h3>
                    <?PHP $template->getSetting($db, "h1-size", "", ""); ?>
                    <?PHP $template->getSetting($db, "h2-size", "", ""); ?>
                    <?PHP $template->getSetting($db, "h3-size", "", ""); ?>
                    <?PHP $template->getSetting($db, "h4-size", "", ""); ?>
                    <?PHP $template->getSetting($db, "h5-size", "", ""); ?>
                    <?PHP $template->getSetting($db, "h6-size", "", ""); ?>
                </div>
                <div class="col-md-4">
                    <h3>Heading <small>Colors </small></h3>
                    <?PHP $template->getSetting($db, "%-fontcolor", "", ""); ?>
                </div>
            </div>
        </div>

        <!-- BODY-->
        <div role="tabpanel" class="tab-pane" id="body">
            <!-- typography styles -->
            <div class="row animated fadeIn">
                <div class="col-md-4">
                    <h3>Body <small>Settings</small></h3>
                    <?PHP
                    $template->getSetting($db, "body-bg-color", "", ""); ?>
                    <h3>Body <small>Positioning</small></h3>
                    <?PHP $template->getSetting($db, "body-margin-%", "", ""); ?>
                </div>
                <div class="col-md-4">
                    <h3>Main Shadow <small>around all positions</small></h3>
                    <?PHP
                    $template->getSetting($db, "main-box-shadow", "", "");
                    $template->getSetting($db, "main-box-shadow-color", "", ""); ?>
                    <h3>List Group <small>Colors</small></h3>
                    <?PHP $template->getSetting($db, "%-listgroup", "", ""); ?>
                </div>
                <div class="col-md-4">
                    <h3>Background <small>Image</small></h3>
                    <?PHP
                    $template->getSetting($db, "body-bg-image", "", "");
                    $template->getSetting($db, "body-bg-repeat", "", "");
                    $template->getSetting($db, "body-bg-position", "", "");
                    $template->getSetting($db, "body-bg-attachment", "", "");
                    $template->getSetting($db, "body-bg-size", "", "");
                    ?>
                </div>
            </div>
        </div>

        <!-- MENU -->
        <div role="tabpanel" class="tab-pane" id="menu">
            <div class="row animated fadeIn">
                <div class="col-md-3">
                    <h3>Menu Font <small>Colors </small></h3>
                    <?PHP $template->getSetting($db, "%-menucolor", "", ""); ?>
                </div>

                <div class="col-md-3">
                    <h3>Menu Background <small>Colors</small></h3>
                    <?PHP $template->getSetting($db, "%-menubgcolor", "", ""); ?>
                </div>

                <div class="col-md-3">
                    <h3>Dropdown <small>Colors</small></h3>
                    <?PHP $template->getSetting($db, "%-menudropdowncolor", "", ""); ?>
                </div>
                <div class="col-md-3">...additional content here...</div>
            </div>
        </div>

        <!-- WELL, JUMBOTRON -->
        <div role="tabpanel" class="tab-pane" id="well">
            <div class="row animated fadeIn">
                <div class="col-md-3">
                    <h3>Well <small>Box Design</small></h3>
                    <?PHP $template->getSetting($db, "well-%", "", ""); ?>
                </div>

                <div class="col-md-3">
                    <h3>Jumbotron <small>Box Design</small></h3>
                    <?PHP // $template->getSetting($db, "%-menubgcolor", "", ""); ?>
                </div>

                <div class="col-md-3">
                    <h3>Any <small>Other Thing</small></h3>
                    <?PHP // $template->getSetting($db, "%-menudropdowncolor", "", ""); ?>
                </div>
                <div class="col-md-3">...additional content here...</div>
            </div>
        </div>

        <!-- BUTTONS -->
        <div role="tabpanel" class="tab-pane" id="buttons">
            <div class="row animated fadeIn">
                <div class="col-md-4">
                    <h3>Button <small>Basic Settings</small></h3>
                    <?PHP
                    $template->getSetting($db, "btn-fontsize", "", "");
                    $template->getSetting($db, "btn-font-weight", "", "");
                    $template->getSetting($db, "btn-border", "", "");
                    $template->getSetting($db, "btn-border-style", "", "");
                    $template->getSetting($db, "btn-border-radius", "", "");

                    ?>
                </div>
                <div class="col-md-4">2</div>
                <div class="col-md-4">3</div>
            </div>

            <div class="row animated fadeIn">
                <div class="col-md-2">
                    <h3>Default <small>Button</small></h3>
                    <?PHP
                    $template->getSetting($db, "btn-default-%", "", "");
                    ?>
                </div>

                <div class="col-md-2">
                    <h3>Primary <small>Button</small></h3>
                    <?PHP
                    $template->getSetting($db, "btn-primary-%", "", "");
                    ?>
                </div>
                <div class="col-md-2">
                    <h3>Success <small>Button</small></h3>
                    <?PHP
                    $template->getSetting($db, "btn-success-%", "", "");
                    ?>
                </div>
                <div class="col-md-2">
                    <h3>Warning <small>Button</small></h3>
                    <?PHP
                    $template->getSetting($db, "btn-warning-%", "", "");
                    ?>
                </div>
                <div class="col-md-2">
                    <h3>Danger <small>Button</small></h3>
                    <?PHP
                    $template->getSetting($db, "btn-danger-%", "", "");
                    ?>
                </div>
                <div class="col-md-2">
                    <h3>Info <small>Button</small></h3>
                    <?PHP
                    $template->getSetting($db, "btn-info-%", "", "");
                    ?>
                </div>
            </div>
        </div>

        <!-- IMAGES -->
        <div role="tabpanel" class="tab-pane" id="images">
            <div class="row animated fadeIn">
                <div class="col-md-3">
                    <h3>Image <small>Effects</small></h3>
                    <?PHP $template->getSetting($db, "img-%", "", ""); ?>
                </div>

                <div class="col-md-3">
                    <h3>Image <small>Effects</small></h3>
                    <?PHP // $template->getSetting($db, "%-menubgcolor", "", ""); ?>
                </div>

                <div class="col-md-3">
                    <h3>Any <small>Other Thing</small></h3>
                    <?PHP // $template->getSetting($db, "%-menudropdowncolor", "", ""); ?>
                </div>
                <div class="col-md-3">...additional content here...</div>
            </div>
        </div>

        <!-- FX -->
        <div role="tabpanel" class="tab-pane" id="effects">Kommen dann hier rein...

        </div>

        <!-- CUSTOM CSS -->
        <div role="tabpanel" class="tab-pane animated fadeIn" id="custom">
            <div class="row">
                <div class="col-md-8">
                    <label class="h3" for="summernote">Custom.CSS
                        <small>Override settings and add your own definitions to extend this template</small></label>
                    <textarea name="customCSS" cols="64" rows="28" id="summernote" class="form-control dark"><?php
                        $customCSS = $template->getCustomCSSFile($db);
                        echo $customCSS; ?></textarea>
                </div>
                <div class="col-md-4">
                    <h3>
                            <br><?PHP echo $template->name; ?>/css/custom.css<br>
                            <small><b>This file is loaded after any other css file.</b> The last link in the chain. This means
                            you can override any CSS setting. (Even those you set here in the backend in the tabs before).
                            Use this to dump any css definitions you need to fit the style to your corporate design.
                            <br><br>
                            If you need help w CSS take a look here:<br>
                            &raquo; <a href="http://www.w3schools.com/css/" title="open CSS overview in new TAB" target="_blank">w3schools.com/css/</a>
                            </small>

                    </h3>
                </div>
            </div>
        </div>

        <!-- SETTINGS -->
        <div role="tabpanel" class="tab-pane  animated fadeIn" id="settings">
            <h3>Settings <small>add settings or fonts to database</small></h3>
            <div class="row animated fadeIn">
                <div class="col-md-4">
                    <label for="property">add Setting <small>to active template</small></label>
                    <input type="text" class="form-control" id="property" name="property" placeholder="property">
                    <input type="text" class="form-control" name="value" placeholder="value">
                    <input type="text" class="form-control" name="valueDefault" placeholder="default value">
                    <input type="text" class="form-control" name="description" placeholder="description">
                    <input type="text" class="form-control" name="fieldclass" placeholder="fieldClass e.g. input-xlarge">
                    <input type="text" class="form-control" name="placeholder" placeholder="placeholder">
                    <br /><input id="savebutton" type="submit" class="btn btn-danger" name="addsetting" value="Add&nbsp;Template&nbsp;Setting" />
                </div>
                <div class="col-md-4">
                    <label for="gfont">add GoogleFont to database</label>
                    <input type="text" class="form-control" id="gfont" name="gfont" placeholder="font eg. Ubuntu">
                    <input type="text" class="form-control" name="gfontdescription" placeholder="description eg. Ubuntu, serif">
                    <br /><input id="savebutton" type="submit" class="btn btn-danger" name="addgfont" value="Add&nbsp;GoogleFont" />
                </div>
                <div class="col-md-4">
                    ...
                </div>
            </div>
        </div>

        <!-- THEMES -->
        <div role="tabpanel" class="tab-pane" id="themes">
            <!-- list availalbe THEMES -->
            <div class="row animated fadeIn">
                <div class="col-md-4">
                    <h3>Load <small>Theme</small></h3>
                    ...
                </div>
                <div class="col-md-4">
                    <h3>Save <small>Theme</small></h3>
                    ...
                </div>
                <div class="col-md-4">
                    <h3>Save as <small>new Theme</small></h3>
                    <label for="savetheme">or save new theme as... </label>
                    <input type="text" class="form-control" name="newthemename" value="<?php echo $template->name; ?>-copy" placeholder="New Theme Name">
                    <input type="text" class="form-control" name="description" placeholder="Template Description">
                    <input type="text" class="form-control" name="positions" placeholder="Positions eg. top:main:footer">
                    <br><input id="savebutton" type="submit" class="btn btn-danger" name="savenewtheme" value="Add&nbsp;as new Theme" />
                </div>
            </div>
        </div>

    </div>

    <br><br><br><br><br><br><br><br>
      <!-- </div> <!-- ./ nav-tabs-custom -->
     </form>