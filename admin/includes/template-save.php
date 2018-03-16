<script>
    $(document).ready(function() {

        /* MAKE SURE THAT THE LAST USED TAB STAYS ACTIVE */
        $(function() {
            // for bootstrap 3 use 'shown.bs.tab', for bootstrap 2 use 'shown' in the next line
            $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
                // save the latest tab; we use brower's localStorage, but cookies would also be possible
                localStorage.setItem('lastTab', $(this).attr('href'));
                // save the latest tabcontent id
                localStorage.setItem('lastTabContent', $(this).attr('id'));
                // remove first char (#) to get correct filename
                var file = $(this).attr('href').slice(1);
                // store filename from last tab
                localStorage.setItem('lastFile', file);
            });

            // go to the latest tab, if it exists:
            var lastTab = localStorage.getItem('lastTab');
            // get latest filename
            var lastFile = localStorage.getItem('lastFile');
            // get latest tab content id
            var lastTabContent = localStorage.getItem('lastTabContent');
            // remove first 4 chars from tabcontent id str
            var tab = lastTabContent.substr(4);
            // and build correct tabcontent id str
            var tabContent = '#tabcontent-'+tab;
            // build latest url
            var lastPage = baseDir+'index.php?page='+lastFile+'&hideWrapper=1';

            // if a last tab exists...
            if (lastTab) {
                // show it up
                $('[href="' + lastTab + '"]').tab('show');
                // load latest page into last opened content tab
                $(tabContent).load(lastPage);
            }
            else
            {   // no last tab found, trigger a click on overview to display default tab
                home.trigger("click");
            }
        });

    });// end document ready
</script>
<?php
// check if template obj is set and create if not exists
if (!isset($template)) { $template = new \YAWK\template(); }
// new user obj if not exists
if (!isset($user)) { $user = new \YAWK\user(); }
// get ID of current active template
$getID = \YAWK\settings::getSetting($db, "selectedTemplate");
// load properties of current active template
$template->loadProperties($db, $getID);

// TEMPLATE WRAPPER - HEADER & breadcrumbs
echo "
    <!-- Content Wrapper. Contains page content -->
    <div class=\"content-wrapper\" id=\"content-FX\">
    <!-- Content Header (Page header) -->
    <section class=\"content-header\">";
/* draw Title on top */
$t = "$lang[TEMPLATE] $lang[SET_AND_EDIT]";
echo \YAWK\backend::getTitle($lang['TPL_MANAGER'], $t);
echo"<ol class=\"breadcrumb\">
            <li><a href=\"index.php\" title=\"$lang[DASHBOARD]\"><i class=\"fa fa-dashboard\"></i> $lang[DASHBOARD]</a></li>
            <li><a href=\"index.php?page=template-manage\" title=\"$lang[TPL_MANAGER]\"> $lang[TPL_MANAGER]</a></li>
            <li><b><a href=\"index.php?page=template-edit&id=$template->id\" class=\"active\" title=\"$lang[TPL_EDIT]\">$template->name</a></b></li>
        </ol></section>
    <!-- Main content -->
    <section class=\"content\">";
/* page content start here */
// check if any action is requested

if (isset($_POST['save']) && (isset($_GET['action']) && (isset($_GET['id']))))
{
    if (isset($_POST) && (!empty($_POST)))
    {
        if (isset($_GET['action']))
        {
            // process only if $_POST data is set and not empty
            // walk through save requests
            // position properties
            if ($_GET['action'] === "template-positions")
            {
                $redirect = "template-positions";
                if ($template->saveProperties($db, $_GET['id'], $_POST))
                {
                    \YAWK\alert::draw("success", $lang['SUCCESS'], $lang['POSITIONS'] . "&nbsp;" . $lang['SAVED'], "", 2400);
                }
                else
                {
                    \YAWK\alert::draw("danger", $lang['ERROR'], $lang['POSITIONS'] . "&nbsp;" . $lang['NOT_SAVED'], "", 5000);
                }
            }
            // redesign properties
            if ($_GET['action'] === "template-redesign")
            {
                $redirect = "template-redesign";
                if ($template->saveProperties($db, $_GET['id'], $_POST))
                {
                    \YAWK\alert::draw("success", $lang['SUCCESS'], $lang['DESIGN_DETAILS'] . "&nbsp;" . $lang['SAVED'], "", 2400);
                }
                else
                {
                    \YAWK\alert::draw("danger", $lang['ERROR'], $lang['DESIGN_DETAILS'] . "&nbsp;" . $lang['NOT_SAVED'], "", 5000);
                }
            }
            // if save property is customCSS
            if ($_GET['action'] === "template-customcss")
            {
                if (isset($_POST['customCSS']) && (!empty($_POST['customCSS'])))
                {
                    // save the content to /system/template/$NAME/css/custom.css
                    $template->setCustomCssFile($db, $_POST['customCSS'], 0, $_GET['id']);
                    // save a minified version to /system/template/$NAME/css/custom.min.css
                    $template->setCustomCssFile($db, $_POST['customCSS'], 1, $_GET['id']);
                }
            }


        } // end if isset $_GET['action']

        // get all template settings fresh form database into array
        $tplSettings = YAWK\template::getTemplateSettingsArray($db, $getID);

        // get fonts from database
        // $headingFont = YAWK\template::getActivegfont($db, "", "heading-gfont");
        $h1Font = \YAWK\template::setCssFontSettings("h1", $tplSettings);
        $h2Font = \YAWK\template::setCssFontSettings("h2", $tplSettings);
        $h3Font = \YAWK\template::setCssFontSettings("h3", $tplSettings);
        $h4Font = \YAWK\template::setCssFontSettings("h4", $tplSettings);
        $h5Font = \YAWK\template::setCssFontSettings("h5", $tplSettings);
        $h6Font = \YAWK\template::setCssFontSettings("h6", $tplSettings);
        $bodyFontFaceSettings = \YAWK\template::setCssBodyFontFace("globaltext", $tplSettings);
        $bodyLinkSettings = \YAWK\template::setCssBodyLinkTags("globaltext", $tplSettings);
        $bodyFontSettings = \YAWK\template::setCssBodyFontSettings("globaltext", $tplSettings);
        $bodySmallFontSettings = \YAWK\template::setCssBodySmallFontSettings("globaltext", $tplSettings);

        // PREPARE SETTINGS.CSS
        $content = "
    /* ATTENTION: THIS FILE IS AUTO-GENERATED. */
    /* DO NOT EDIT THIS FILE DIRECTLY. USE RE-DESIGN INSTEAD. */
    
        /* BODY TYPOGRAPHY */
        ".$bodyFontFaceSettings."
    body 
    {           
        /* BODY SETTINGS */
        background-color: #".$tplSettings['body-bg-color'].";
        margin-top: ".$tplSettings['body-margin-top'].";
        margin-bottom: ".$tplSettings['body-margin-bottom'].";
        margin-left: ".$tplSettings['body-margin-left'].";
        margin-right: ".$tplSettings['body-margin-right'].";
        text-align: ".$tplSettings['pos-body-text-align'].";
        
        /* BODY BACKGROUND IMAGE */
        background-image: url('".$tplSettings['body-bg-image']."');
        background-repeat:".$tplSettings['body-bg-repeat'].";
        background-position:".$tplSettings['body-bg-position'].";
        background-attachment:".$tplSettings['body-bg-attachment'].";
        background-size: ".$tplSettings['body-bg-size'].";
        
        /* BODY BACKGROUND GRADIENT */
        ".$tplSettings['pos-body-bg-gradient-longValue']."
        ".$tplSettings['pos-body-customCSS-longValue']."
                   
        /* BODY TYPOGRAPHY */
        ".$bodyFontSettings." 
    }    
        /* H1 - H6 TYPOGRAPHY SETTINGS */   
          ".$h1Font."
          ".$h2Font."
          ".$h3Font."
          ".$h4Font."
          ".$h5Font."
          ".$h6Font."
          
        /* BODY LINKS */
        ".$bodyLinkSettings."
        
        /* GLOBALTEXT SMALL */
        ".$bodySmallFontSettings."
        

    /* WELL */
    .well {
        min-height: ".$tplSettings['well-min-height'].";
        padding: ".$tplSettings['well-padding'].";
        margin-bottom: ".$tplSettings['well-margin-bottom'].";
        margin-top: ".$tplSettings['well-margin-top'].";
        background-color: #".$tplSettings['well-bg-color'].";
        border: ".$tplSettings['well-border']." #".$tplSettings['well-border-color'].";
        border-radius: ".$tplSettings['well-border-radius'].";
        -webkit-box-shadow: ".$tplSettings['well-shadow']." #".$tplSettings['well-shadow-color'].";
        box-shadow: ".$tplSettings['well-shadow']." #".$tplSettings['well-shadow-color'].";
    }
    /* LIST GROUP */
   .list-group-item {
       color: #".$tplSettings['fontcolor-listgroup'].";
       background-color: #".$tplSettings['background-listgroup'].";
   }
   /* BUTTONS */
    .btn {
      color: #".$tplSettings['btn-default-color'].";
      display: inline-block;
      padding: 6px 12px;
      margin-bottom: 0;
      font-size: ".$tplSettings['btn-fontsize'].";
      font-weight: ".$tplSettings['btn-font-weight'].";
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
      border: ".$tplSettings['btn-border']." ".$tplSettings['btn-border-style']." transparent;
      border-radius: ".$tplSettings['btn-border-radius'].";
    }

    .btn-default {
        color: #".$tplSettings['btn-default-color'].";
        background-color: #".$tplSettings['btn-default-background-color'].";
        border-color: #".$tplSettings['btn-default-border-color'].";
    }
    .btn-default:focus,
    .btn-default.focus {
        color: #".$tplSettings['btn-default-color'].";
        background-color: #".$tplSettings['btn-default-focus-background-color'].";
        border-color: #".$tplSettings['btn-default-focus-background-color'].";
    }
    .btn-default:hover {
      color: #".$tplSettings['btn-default-hover-color'].";
      background-color: #".$tplSettings['btn-default-hover-background-color'].";
      border-color: #".$tplSettings['btn-default-hover-border-color'].";
    }
    .btn-default:active,
    .btn-default.active,
    .open > .dropdown-toggle.btn-default {
      color: #".$tplSettings['btn-default-color'].";
      background-color: #".$tplSettings['btn-default-focus-background-color'].";
      border-color: #".$tplSettings['btn-default-hover-border-color'].";
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
      color: #".$tplSettings['btn-default-color'].";
      background-color: #".$tplSettings['btn-default-focus-background-color'].";
      border-color: #".$tplSettings['btn-default-hover-border-color'].";
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
      background-color: #".$tplSettings['btn-default-background-color'].";
      border-color: #".$tplSettings['btn-default-border-color'].";
    }
    .btn-default .badge {
      color: #".$tplSettings['btn-default-background-color'].";
      background-color: #".$tplSettings['btn-default-color'].";
    }

    .btn-primary {
      color: #".$tplSettings['btn-primary-color'].";
      background-color: #".$tplSettings['btn-primary-background-color'].";
      border-color: #".$tplSettings['btn-primary-border-color'].";
    }
    .btn-primary:focus,
    .btn-primary.focus {
      color: #".$tplSettings['btn-primary-color'].";
      background-color: #".$tplSettings['btn-primary-focus-background-color'].";
      border-color: #".$tplSettings['btn-primary-focus-border-color'].";
    }
    .btn-primary:hover {
      color: #".$tplSettings['btn-primary-color'].";
      background-color: #".$tplSettings['btn-primary-hover-background-color'].";
      border-color: #".$tplSettings['btn-primary-hover-border-color'].";
    }
    .btn-primary:active,
    .btn-primary.active,
    .open > .dropdown-toggle.btn-primary {
      color: #".$tplSettings['btn-primary-color'].";
      background-color: #".$tplSettings['btn-primary-focus-background-color'].";
      border-color: #".$tplSettings['btn-primary-hover-border-color'].";
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
      color: #".$tplSettings['btn-primary-color'].";
      background-color: #".$tplSettings['btn-primary-focus-background-color'].";
      border-color: #".$tplSettings['btn-primary-hover-border-color'].";
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
      background-color: #".$tplSettings['btn-primary-background-color'].";
      border-color: #".$tplSettings['btn-primary-border-color'].";
    }
    .btn-primary .badge {
      color: #".$tplSettings['btn-primary-background-color'].";
      background-color: #".$tplSettings['btn-primary-color'].";
    }

    .btn-success {
      color: #".$tplSettings['btn-success-color'].";
      background-color: #".$tplSettings['btn-success-background-color'].";
      border-color: #".$tplSettings['btn-success-background-color'].";
    }
    .btn-success:focus,
    .btn-success.focus {
      color: #".$tplSettings['btn-success-color'].";
      background-color: #".$tplSettings['btn-success-focus-background-color'].";
      border-color: #".$tplSettings['btn-success-focus-border-color'].";
    }
    .btn-success:hover {
      color: #".$tplSettings['btn-success-hover-color'].";
      background-color: #".$tplSettings['btn-success-hover-background-color'].";
      border-color: #".$tplSettings['btn-success-hover-border-color'].";
    }
    .btn-success:active,
    .btn-success.active,
    .open > .dropdown-toggle.btn-success {
      color: #".$tplSettings['btn-success-color'].";
      background-color: #".$tplSettings['btn-success-focus-background-color'].";
      border-color: #".$tplSettings['btn-success-hover-border-color'].";
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
      color: #".$tplSettings['btn-success-color'].";
      background-color: #".$tplSettings['btn-success-hover-border-color'].";
      border-color: #".$tplSettings['btn-success-focus-border-color'].";
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
      color: #".$tplSettings['btn-success-background-color'].";
      background-color: #".$tplSettings['btn-success-color'].";
    }

    .btn-info {
      color: #".$tplSettings['btn-info-color'].";
      background-color: #".$tplSettings['btn-info-background-color'].";
      border-color: #".$tplSettings['btn-info-border-color'].";
    }
    .btn-info:focus,
    .btn-info.focus {
      color: #".$tplSettings['btn-info-color'].";
      background-color: #".$tplSettings['btn-info-focus-background-color'].";
      border-color: #".$tplSettings['btn-info-focus-border-color'].";
    }
    .btn-info:hover {
      color: #".$tplSettings['btn-info-hover-color'].";
      background-color: #".$tplSettings['btn-info-hover-background-color'].";
      border-color: #".$tplSettings['btn-info-hover-border-color'].";
    }
    .btn-info:active,
    .btn-info.active,
    .open > .dropdown-toggle.btn-info {
      color: #".$tplSettings['btn-info-color'].";
      background-color: #".$tplSettings['btn-info-focus-background-color'].";
      border-color: #".$tplSettings['btn-info-hover-border-color'].";
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
      color: #".$tplSettings['btn-info-color'].";
      background-color: #".$tplSettings['btn-info-hover-border-color'].";
      border-color: #".$tplSettings['btn-info-focus-border-color'].";
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
      color: #".$tplSettings['btn-info-background-color'].";
      background-color: #".$tplSettings['btn-info-color'].";
    }

    .btn-warning {
      color: #".$tplSettings['btn-warning-color'].";
      background-color: #".$tplSettings['btn-warning-background-color'].";
      border-color: #".$tplSettings['btn-warning-border-color'].";
    }
    .btn-warning:focus,
    .btn-warning.focus {
      color: #".$tplSettings['btn-warning-color'].";
      background-color: #".$tplSettings['btn-warning-focus-background-color'].";
      border-color: #".$tplSettings['btn-warning-focus-border-color'].";
    }
    .btn-warning:hover {
      color: #".$tplSettings['btn-warning-hover-color'].";
      background-color: #".$tplSettings['btn-warning-hover-background-color'].";
      border-color: #".$tplSettings['btn-warning-hover-border-color'].";
    }
    .btn-warning:active,
    .btn-warning.active,
    .open > .dropdown-toggle.btn-warning {
      color: #".$tplSettings['btn-warning-color'].";
      background-color: #".$tplSettings['btn-warning-focus-background-color'].";
      border-color: #".$tplSettings['btn-warning-hover-border-color'].";
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
      color: #".$tplSettings['btn-warning-color'].";
      background-color: #".$tplSettings['btn-warning-hover-border-color'].";
      border-color: #".$tplSettings['btn-warning-focus-border-color'].";
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
      color: #".$tplSettings['btn-warning-background-color'].";
      background-color: #".$tplSettings['btn-warning-color'].";
    }

    .btn-danger {
      color: #".$tplSettings['btn-danger-color'].";
      background-color: #".$tplSettings['btn-danger-background-color'].";
      border-color: #".$tplSettings['btn-danger-border-color'].";
    }
    .btn-danger:focus,
    .btn-danger.focus {
      color: #".$tplSettings['btn-danger-color'].";
      background-color: #".$tplSettings['btn-danger-focus-background-color'].";
      border-color: #".$tplSettings['btn-danger-focus-border-color'].";
    }
    .btn-danger:hover {
      color: #".$tplSettings['btn-danger-hover-color'].";
      background-color: #".$tplSettings['btn-danger-hover-background-color'].";
      border-color: #".$tplSettings['btn-danger-hover-border-color'].";
    }
    .btn-danger:active,
    .btn-danger.active,
    .open > .dropdown-toggle.btn-danger {
      color: #".$tplSettings['btn-danger-color'].";
      background-color: #".$tplSettings['btn-danger-focus-background-color'].";
      border-color: #".$tplSettings['btn-danger-hover-border-color'].";
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
      color: #".$tplSettings['btn-danger-color'].";
      background-color: #".$tplSettings['btn-danger-hover-border-color'].";
      border-color: #".$tplSettings['btn-danger-focus-border-color'].";
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
      color: #".$tplSettings['btn-danger-background-color'].";
      background-color: #".$tplSettings['btn-danger-color'].";
    }
    
    /* FORMS */
    .form-control {
      display: ".$tplSettings['form-display'].";
      width: ".$tplSettings['form-width'].";
      height: ".$tplSettings['form-height'].";
      padding: ".$tplSettings['form-padding'].";
      font-size: ".$tplSettings['form-textSize'].";
      line-height: ".$tplSettings['form-lineHeight'].";
      color: #".$tplSettings['form-textColor'].";
      background-color: #".$tplSettings['form-bgcolor'].";
      background-image: none;
      border: ".$tplSettings['form-border'].";
      border-radius: ".$tplSettings['form-border-radius'].";
      -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075);
              box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075);
      -webkit-transition: border-color ease-in-out .15s, -webkit-box-shadow ease-in-out .15s;
           -o-transition: border-color ease-in-out .15s, box-shadow ease-in-out .15s;
              transition: border-color ease-in-out .15s, box-shadow ease-in-out .15s;
    }
    .form-control:focus {
      border-color: #".$tplSettings['form-activeBorderColor'].";
      outline: 0;
      -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.075), 0 0 8px rgba(102, 175, 233, .6);
              box-shadow: inset 0 1px 1px rgba(0,0,0,.075), 0 0 8px rgba(102, 175, 233, .6);
    }
    .form-control::-moz-placeholder {
      color: #".$tplSettings['form-placeholderColor'].";
      opacity: 1;
    }
    .form-control:-ms-input-placeholder {
      color: #999;
    }
    .form-control::-webkit-input-placeholder {
      color: #999;
    }

   /* NAVBAR */
   .navbar-fixed-top {
    margin-top: ".$tplSettings['navbar-marginTop'].";
    margin-bottom: ".$tplSettings['navbar-marginBottom'].";
  }
   .navbar-default {
       text-shadow: 1px 0px #".$tplSettings['fontshadow-menucolor'].";
       filter: dropshadow(color=#".$tplSettings['fontshadow-menucolor'].", offx=1, offy=1);
       background-color: #".$tplSettings['default-menubgcolor'].";
       border-color: #".$tplSettings['border-menubgcolor'].";
       margin-bottom: ".$tplSettings['navbar-marginBottom'].";
   }
   .navbar-default .navbar-brand {
       color: #".$tplSettings['brand-menucolor'].";
   }
   .navbar-default .navbar-brand:hover,
   .navbar-default .navbar-brand:focus {
       color: #".$tplSettings['brandhover-menucolor'].";
       background-color: transparent;
   }
   .navbar-default .navbar-text {
       color: #".$tplSettings['font-menucolor'].";
   }
   .navbar-default .navbar-nav > li > a {
       color: #".$tplSettings['font-menucolor'].";
   }
   .navbar-default .navbar-nav > li > a:hover,
   .navbar-default .navbar-nav > li > a:focus {
       color: #".$tplSettings['fonthover-menucolor'].";
       background-color: transparent;
   }
   .navbar-default .navbar-nav > .active > a,
   .navbar-default .navbar-nav > .active > a:hover,
   .navbar-default .navbar-nav > .active > a:focus {
       color: #".$tplSettings['fontactive-menucolor'].";
       background-color: #".$tplSettings['active-menubgcolor'].";
   }
   .navbar-default .navbar-nav > .disabled > a,
   .navbar-default .navbar-nav > .disabled > a:hover,
   .navbar-default .navbar-nav > .disabled > a:focus {
       color: #".$tplSettings['fontdisabled-menucolor'].";
       background-color: transparent;
   }
   .navbar-default .navbar-toggle {
       border-color: #".$tplSettings['toggle-menubgcolor'].";
   }
   .navbar-default .navbar-toggle:hover,
   .navbar-default .navbar-toggle:focus {
       border-color:#".$tplSettings['toggle-menubgcolor'].";
   }
   .navbar-default .navbar-toggle .icon-bar {
       background-color:#".$tplSettings['iconbar-menubgcolor'].";
   }
   .navbar-default .navbar-collapse,
   .navbar-default .navbar-form {
       border-color: #".$tplSettings['border-menubgcolor'].";
   }
   .navbar-default .navbar-nav > .open > a,
   .navbar-default .navbar-nav > .open > a:hover,
   .navbar-default .navbar-nav > .open > a:focus {
       background-color: #".$tplSettings['active-menubgcolor'].";
       color: #".$tplSettings['fontactive-menucolor'].";
   }
   @media (max-width: 767px) {
       .navbar-default .navbar-nav .open .dropdown-menu > li > a {
           color: #".$tplSettings['font-menucolor'].";
       }
       .navbar-default .navbar-nav .open .dropdown-menu > li > a:hover,
       .navbar-default .navbar-nav .open .dropdown-menu > li > a:focus {
           color: #".$tplSettings['fonthover-menucolor'].";
           background-color: transparent;
       }
       .navbar-default .navbar-nav .open .dropdown-menu > .active > a,
       .navbar-default .navbar-nav .open .dropdown-menu > .active > a:hover,
       .navbar-default .navbar-nav .open .dropdown-menu > .active > a:focus {
           color: #".$tplSettings['fontactive-menucolor'].";
           background-color: #".$tplSettings['active-menubgcolor'].";
       }
       .navbar-default .navbar-nav .open .dropdown-menu > .disabled > a,
       .navbar-default .navbar-nav .open .dropdown-menu > .disabled > a:hover,
       .navbar-default .navbar-nav .open .dropdown-menu > .disabled > a:focus {
           color: #".$tplSettings['fontdisabled-menucolor'].";
           background-color: transparent;
       }
   }
   .navbar-default .navbar-link {
       color: #".$tplSettings['font-menucolor'].";
   }
   .navbar-default .navbar-link:hover {
       color: #".$tplSettings['fonthover-menucolor'].";
   }
   .navbar-default .btn-link {
       color: #".$tplSettings['font-menucolor'].";
   }
   .navbar-default .btn-link:hover,
   .navbar-default .btn-link:focus {
       color: #".$tplSettings['fonthover-menucolor'].";
   }
   .navbar-default .btn-link[disabled]:hover,
   fieldset[disabled] .navbar-default .btn-link:hover,
   .navbar-default .btn-link[disabled]:focus,
   fieldset[disabled] .navbar-default .btn-link:focus {
       color: #".$tplSettings['fontdisabled-menucolor'].";
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
       background-color: #".$tplSettings['background-menudropdowncolor'].";
       border: 1px solid #".$tplSettings['border-menudropdowncolor'].";
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
       color: #".$tplSettings['border-menudropdowncolor'].";
       white-space: nowrap;
   }
   .dropdown-menu > li > a:hover,
   .dropdown-menu > li > a:focus {
       text-decoration: none;
       color: #".$tplSettings['fonthover-menudropdowncolor'].";
       background-color: #".$tplSettings['hoverbg-menudropdowncolor'].";
   }
   .dropdown-menu > .active > a,
   .dropdown-menu > .active > a:hover,
   .dropdown-menu > .active > a:focus {
       color: #".$tplSettings['fontactive-menudropdowncolor'].";
       text-decoration: none;
       outline: 0;
       background-color: #".$tplSettings['activebg-menudropdowncolor'].";
   }
   .dropdown-menu > .disabled > a,
   .dropdown-menu > .disabled > a:hover,
   .dropdown-menu > .disabled > a:focus {
       color: #".$tplSettings['disabled-menudropdowncolor'].";
   }
   /* jQUERY form validate error mesage text color */
    .error {
        color: #".$tplSettings['form-error'].";
        font-weight: bold;
    }
    .valid {
        color: #".$tplSettings['form-valid'].";
        font-weight: bold;
    }

    /* YaWK ADDITIONAL CSS IMAGE SETTINGS */
     .img-shadow {
       -webkit-box-shadow: ".$tplSettings['img-shadow']." #".$tplSettings['img-shadow-color'].";
       box-shadow: ".$tplSettings['img-shadow']." #".$tplSettings['img-shadow-color'].";
       }

     .img-righty {
        -ms-transform: rotate(".$tplSettings['img-righty']."); /* IE 9 */
        -webkit-transform: rotate(".$tplSettings['img-righty']."); /* Chrome, Safari, Opera */
        transform: rotate(".$tplSettings['img-righty'].");
        -webkit-filter: brightness(100%);
        -webkit-box-shadow: ".$tplSettings['img-shadow']." #".$tplSettings['img-shadow-color'].";
        box-shadow: ".$tplSettings['img-shadow']." #".$tplSettings['img-shadow-color'].";
     }

     .img-lefty {
        -ms-transform: rotate(".$tplSettings['img-lefty']."); /* IE 9 */
        -webkit-transform: rotate(".$tplSettings['img-lefty']."); /* Chrome, Safari, Opera */
        transform: rotate(".$tplSettings['img-lefty'].");
        -webkit-filter: brightness(100%);
        -webkit-box-shadow: ".$tplSettings['img-shadow']." #".$tplSettings['img-shadow-color'].";
        box-shadow: ".$tplSettings['img-shadow']." #".$tplSettings['img-shadow-color'].";
     }

     .img-lefty-less {
        -ms-transform: rotate(".$tplSettings['img-lefty-less']."); /* IE 9 */
        -webkit-transform: rotate(".$tplSettings['img-lefty-less']."); /* Chrome, Safari, Opera */
        transform: rotate(".$tplSettings['img-lefty-less'].");
        -webkit-filter: brightness(100%);
        -webkit-box-shadow: ".$tplSettings['img-shadow']." #".$tplSettings['img-shadow-color'].";
        box-shadow: ".$tplSettings['img-shadow']." #".$tplSettings['img-shadow-color'].";
     }

     .img-righty-less {
        -ms-transform: rotate(".$tplSettings['img-righty-less']."); /* IE 9 */
        -webkit-transform: rotate(".$tplSettings['img-righty-less']."); /* Chrome, Safari, Opera */
        transform: rotate(".$tplSettings['img-righty-less'].");
        -webkit-filter: brightness(100%);
        -webkit-box-shadow: ".$tplSettings['img-shadow']." #".$tplSettings['img-shadow-color'].";
        box-shadow: ".$tplSettings['img-shadow']." #".$tplSettings['img-shadow-color'].";
     }

     .img-lefty:hover {
        -webkit-filter: brightness(".$tplSettings['img-brightness'].");
     }
     .img-righty:hover {
        -webkit-filter: brightness(".$tplSettings['img-brightness'].");
     }
     .img-thumbnail {
        -webkit-filter: brightness(100%);
     }
     .img-thumbnail:hover {
        -webkit-filter: brightness(".$tplSettings['img-brightness'].");
     }
     .list-group {
        padding-left: ".$tplSettings['listgroup-paddingLeft'].";
        margin-bottom: ".$tplSettings['listgroup-marginBottom'].";
     }
     .list-group-item {
        position: ".$tplSettings['listgroup-itemPosition'].";
        display: ".$tplSettings['listgroup-itemDisplay'].";
        padding: ".$tplSettings['listgroup-itemPadding'].";
        margin-bottom: -1px;
        background-color: #".$tplSettings['listgroup-itemBackgroundColor'].";
        border: ".$tplSettings['listgroup-itemBorder'].";
        color: #".$tplSettings['listgroup-fontColor'].";
        font-size: ".$tplSettings['listgroup-fontSize'].";
        ".$tplSettings['listgroup-bg-gradient-longValue'].";
    }
    
     .list-group-item:first-child {
        border-top-left-radius: ".$tplSettings['listgroup-firstChild-topLeft-radius'].";
        border-top-right-radius: ".$tplSettings['listgroup-firstChild-topRight-radius'].";
     }
     .list-group-item:last-child {
        margin-bottom: 0;
        border-bottom-right-radius: ".$tplSettings['listgroup-lastChild-bottomRight-radius'].";
        border-bottom-left-radius: ".$tplSettings['listgroup-lastChild-bottomLeft-radius'].";
     }

     .jumbotron {
        padding-top: ".$tplSettings['jumbotron-paddingTop'].";
        padding-bottom: ".$tplSettings['jumbotron-paddingBottom'].";
        margin-bottom: ".$tplSettings['jumbotron-marginBottom'].";
        color: #".$tplSettings['jumbotron-fontColor'].";
        background-color: #".$tplSettings['jumbotron-backgroundColor'].";
        padding-right: ".$tplSettings['jumbotron-containerPaddingRight'].";
        padding-left: ".$tplSettings['jumbotron-containerPaddingLeft'].";
        border-radius: ".$tplSettings['jumbotron-borderRadius'].";
    }
    .jumbotron h1,
    .jumbotron .h1 {
        color: #".$tplSettings['jumbotron-h1Color'].";
    }
    .jumbotron p {
        margin-bottom: ".$tplSettings['jumbotron-pMarginBottom'].";
        font-size: ".$tplSettings['jumbotron-pFontSize'].";
        font-weight: ".$tplSettings['jumbotron-pFontWeight'].";
    }
    .jumbotron > hr {
        border-top-color: #".$tplSettings['jumbotron-hrColor'].";
    }
    .container .jumbotron,
    .container-fluid .jumbotron {
        padding-right: ".$tplSettings['jumbotron-containerPaddingRight'].";
        padding-left: ".$tplSettings['jumbotron-containerPaddingLeft'].";
        border-radius: ".$tplSettings['jumbotron-borderRadius'].";
    }
    .jumbotron .container {
        max-width: ".$tplSettings['jumbotron-containerMaxWidth'].";
    }
    @media screen and (min-width: 768px) {
      .jumbotron {
        padding-top: 48px;
        padding-bottom: 48px;
      }
      .container .jumbotron,
      .container-fluid .jumbotron {
        padding-right: ".$tplSettings['jumbotron-fluidPaddingRight'].";
        padding-left: ".$tplSettings['jumbotron-fluidPaddingLeft'].";
      }
      .jumbotron h1,
      .jumbotron .h1 {
        font-size: ".$tplSettings['jumbotron-h1FontSize'].";
      }
    }
    
    .pos-outerTop
    {   
        -webkit-box-shadow: ".$tplSettings['pos-outerTop-box-shadow-width']." #".$tplSettings['pos-outerTop-box-shadow-color'].";
        -moz-box-shadow: ".$tplSettings['pos-outerTop-box-shadow-width']." #".$tplSettings['pos-outerTop-box-shadow-color'].";
        box-shadow: ".$tplSettings['pos-outerTop-box-shadow-width']." #".$tplSettings['pos-outerTop-box-shadow-color'].";
        border-width: ".$tplSettings['pos-outerTop-border-width'].";
        border-color: #".$tplSettings['pos-outerTop-border-color'].";
        border-style: ".$tplSettings['pos-outerTop-border-style'].";
        border-radius: ".$tplSettings['pos-outerTop-border-radius'].";
        padding: ".$tplSettings['pos-outerTop-padding'].";
        overflow: ".$tplSettings['pos-outerTop-overflow'].";
        visibility: ".$tplSettings['pos-outerTop-visibility'].";
        text-align: ".$tplSettings['pos-outerTop-text-align'].";
        vertical-align: ".$tplSettings['pos-outerTop-vertical-align'].";
        margin-top: ".$tplSettings['pos-outerTop-marginTop'].";
        margin-bottom: ".$tplSettings['pos-outerTop-marginBottom'].";
        position: ".$tplSettings['pos-outerTop-position'].";
        background-color: #".$tplSettings['pos-outerTop-bgcolor'].";
        width: ".$tplSettings['pos-outerTop-width'].";
        height: ".$tplSettings['pos-outerTop-height'].";
        z-index: ".$tplSettings['pos-outerTop-zindex'].";
        /* BACKGROUND IMAGE */
        background-image: url('".$tplSettings['pos-outerTop-bg-image']."');
        background-repeat:".$tplSettings['pos-outerTop-bg-repeat'].";
        background-position:".$tplSettings['pos-outerTop-bg-position'].";
        background-attachment:".$tplSettings['pos-outerTop-bg-attachment'].";
        background-size: ".$tplSettings['pos-outerTop-bg-size'].";
        ".$tplSettings['pos-outerTop-bg-gradient-longValue']."
        ".$tplSettings['pos-outerTop-customCSS-longValue']."
        background: ".$tplSettings['pos-outerTop-bgnone'].";
    }
    .pos-intro
    {   
        -webkit-box-shadow: ".$tplSettings['pos-intro-box-shadow-width']." #".$tplSettings['pos-intro-box-shadow-color'].";
        -moz-box-shadow: ".$tplSettings['pos-intro-box-shadow-width']." #".$tplSettings['pos-intro-box-shadow-color'].";
        box-shadow: ".$tplSettings['pos-intro-box-shadow-width']." #".$tplSettings['pos-intro-box-shadow-color'].";
        border-width: ".$tplSettings['pos-intro-border-width'].";
        border-color: #".$tplSettings['pos-intro-border-color'].";
        border-style: ".$tplSettings['pos-intro-border-style'].";
        border-radius: ".$tplSettings['pos-intro-border-radius'].";
        padding: ".$tplSettings['pos-intro-padding'].";
        overflow: ".$tplSettings['pos-intro-overflow'].";
        visibility: ".$tplSettings['pos-intro-visibility'].";
        text-align: ".$tplSettings['pos-intro-text-align'].";
        vertical-align: ".$tplSettings['pos-intro-vertical-align'].";
        margin-top: ".$tplSettings['pos-intro-marginTop'].";
        margin-bottom: ".$tplSettings['pos-intro-marginBottom'].";
        position: ".$tplSettings['pos-intro-position'].";
        background-color: #".$tplSettings['pos-intro-bgcolor'].";
        width: ".$tplSettings['pos-intro-width'].";
        height: ".$tplSettings['pos-intro-height'].";
        z-index: ".$tplSettings['pos-intro-zindex'].";
        /* BACKGROUND IMAGE */
        background-image: url('".$tplSettings['pos-intro-bg-image']."');
        background-repeat:".$tplSettings['pos-intro-bg-repeat'].";
        background-position:".$tplSettings['pos-intro-bg-position'].";
        background-attachment:".$tplSettings['pos-intro-bg-attachment'].";
        background-size: ".$tplSettings['pos-intro-bg-size'].";
        ".$tplSettings['pos-intro-bg-gradient-longValue']."
        ".$tplSettings['pos-intro-customCSS-longValue']."
        background: ".$tplSettings['pos-intro-bgnone'].";
    }
    .pos-globalmenu
    {   
        -webkit-box-shadow: ".$tplSettings['pos-globalmenu-box-shadow-width']." #".$tplSettings['pos-globalmenu-box-shadow-color'].";
        -moz-box-shadow: ".$tplSettings['pos-globalmenu-box-shadow-width']." #".$tplSettings['pos-globalmenu-box-shadow-color'].";
        box-shadow: ".$tplSettings['pos-globalmenu-box-shadow-width']." #".$tplSettings['pos-globalmenu-box-shadow-color'].";
        border-width: ".$tplSettings['pos-globalmenu-border-width'].";
        border-color: #".$tplSettings['pos-globalmenu-border-color'].";
        border-style: ".$tplSettings['pos-globalmenu-border-style'].";
        border-radius: ".$tplSettings['pos-globalmenu-border-radius'].";
        padding: ".$tplSettings['pos-globalmenu-padding'].";
        overflow: ".$tplSettings['pos-globalmenu-overflow'].";
        visibility: ".$tplSettings['pos-globalmenu-visibility'].";
        text-align: ".$tplSettings['pos-globalmenu-text-align'].";
        vertical-align: ".$tplSettings['pos-globalmenu-vertical-align'].";
        margin-top: ".$tplSettings['pos-globalmenu-marginTop'].";
        margin-bottom: ".$tplSettings['pos-globalmenu-marginBottom'].";
        position: ".$tplSettings['pos-globalmenu-position'].";
        background-color: #".$tplSettings['pos-globalmenu-bgcolor'].";
        width: ".$tplSettings['pos-globalmenu-width'].";
        height: ".$tplSettings['pos-globalmenu-height'].";
        z-index: ".$tplSettings['pos-globalmenu-zindex'].";
        /* BACKGROUND IMAGE */
        background-image: url('".$tplSettings['pos-globalmenu-bg-image']."');
        background-repeat:".$tplSettings['pos-globalmenu-bg-repeat'].";
        background-position:".$tplSettings['pos-globalmenu-bg-position'].";
        background-attachment:".$tplSettings['pos-globalmenu-bg-attachment'].";
        background-size: ".$tplSettings['pos-globalmenu-bg-size'].";
        ".$tplSettings['pos-globalmenu-bg-gradient-longValue']."
        ".$tplSettings['pos-globalmenu-customCSS-longValue']."
        background: ".$tplSettings['pos-globalmenu-bgnone'].";
    }
    .pos-top
    {   
        -webkit-box-shadow: ".$tplSettings['pos-top-box-shadow-width']." #".$tplSettings['pos-top-box-shadow-color'].";
        -moz-box-shadow: ".$tplSettings['pos-top-box-shadow-width']." #".$tplSettings['pos-top-box-shadow-color'].";
        box-shadow: ".$tplSettings['pos-top-box-shadow-width']." #".$tplSettings['pos-top-box-shadow-color'].";
        border-width: ".$tplSettings['pos-top-border-width'].";
        border-color: #".$tplSettings['pos-top-border-color'].";
        border-style: ".$tplSettings['pos-top-border-style'].";
        border-radius: ".$tplSettings['pos-top-border-radius'].";
        padding: ".$tplSettings['pos-top-padding'].";
        overflow: ".$tplSettings['pos-top-overflow'].";
        visibility: ".$tplSettings['pos-top-visibility'].";
        text-align: ".$tplSettings['pos-top-text-align'].";
        vertical-align: ".$tplSettings['pos-top-vertical-align'].";
        margin-top: ".$tplSettings['pos-top-marginTop'].";
        margin-bottom: ".$tplSettings['pos-top-marginBottom'].";
        position: ".$tplSettings['pos-top-position'].";
        background-color: #".$tplSettings['pos-top-bgcolor'].";
        width: ".$tplSettings['pos-top-width'].";
        height: ".$tplSettings['pos-top-height'].";
        z-index: ".$tplSettings['pos-top-zindex'].";
        /* BACKGROUND IMAGE */
        background-image: url('".$tplSettings['pos-top-bg-image']."');
        background-repeat:".$tplSettings['pos-top-bg-repeat'].";
        background-position:".$tplSettings['pos-top-bg-position'].";
        background-attachment:".$tplSettings['pos-top-bg-attachment'].";
        background-size: ".$tplSettings['pos-top-bg-size'].";
        ".$tplSettings['pos-top-bg-gradient-longValue']."
        ".$tplSettings['pos-top-customCSS-longValue']."
        background: ".$tplSettings['pos-top-bgnone'].";
    }
    .pos-outerLeft
    {   
        -webkit-box-shadow: ".$tplSettings['pos-outerLeft-box-shadow-width']." #".$tplSettings['pos-outerLeft-box-shadow-color'].";
        -moz-box-shadow: ".$tplSettings['pos-outerLeft-box-shadow-width']." #".$tplSettings['pos-outerLeft-box-shadow-color'].";
        box-shadow: ".$tplSettings['pos-outerLeft-box-shadow-width']." #".$tplSettings['pos-outerLeft-box-shadow-color'].";
        border-width: ".$tplSettings['pos-outerLeft-border-width'].";
        border-color: #".$tplSettings['pos-outerLeft-border-color'].";
        border-style: ".$tplSettings['pos-outerLeft-border-style'].";
        border-radius: ".$tplSettings['pos-outerLeft-border-radius'].";
        padding: ".$tplSettings['pos-outerLeft-padding'].";
        overflow: ".$tplSettings['pos-outerLeft-overflow'].";
        visibility: ".$tplSettings['pos-outerLeft-visibility'].";
        text-align: ".$tplSettings['pos-outerLeft-text-align'].";
        vertical-align: ".$tplSettings['pos-outerLeft-vertical-align'].";
        margin-top: ".$tplSettings['pos-outerLeft-marginTop'].";
        margin-bottom: ".$tplSettings['pos-outerLeft-marginBottom'].";
        position: ".$tplSettings['pos-outerLeft-position'].";
        background-color: #".$tplSettings['pos-outerLeft-bgcolor'].";
        height: ".$tplSettings['pos-outerLeft-height'].";
        z-index: ".$tplSettings['pos-outerLeft-zindex'].";
        /* BACKGROUND IMAGE */
        background-image: url('".$tplSettings['pos-outerLeft-bg-image']."');
        background-repeat:".$tplSettings['pos-outerLeft-bg-repeat'].";
        background-position:".$tplSettings['pos-outerLeft-bg-position'].";
        background-attachment:".$tplSettings['pos-outerLeft-bg-attachment'].";
        background-size: ".$tplSettings['pos-outerLeft-bg-size'].";
        ".$tplSettings['pos-outerLeft-bg-gradient-longValue']."
        ".$tplSettings['pos-outerLeft-customCSS-longValue']."
        background: ".$tplSettings['pos-outerLeft-bgnone'].";
    }
    .pos-outerRight
    {   
        -webkit-box-shadow: ".$tplSettings['pos-outerRight-box-shadow-width']." #".$tplSettings['pos-outerRight-box-shadow-color'].";
        -moz-box-shadow: ".$tplSettings['pos-outerRight-box-shadow-width']." #".$tplSettings['pos-outerRight-box-shadow-color'].";
        box-shadow: ".$tplSettings['pos-outerRight-box-shadow-width']." #".$tplSettings['pos-outerRight-box-shadow-color'].";
        border-width: ".$tplSettings['pos-outerRight-border-width'].";
        border-color: #".$tplSettings['pos-outerRight-border-color'].";
        border-style: ".$tplSettings['pos-outerRight-border-style'].";
        border-radius: ".$tplSettings['pos-outerRight-border-radius'].";
        padding: ".$tplSettings['pos-outerRight-padding'].";
        overflow: ".$tplSettings['pos-outerRight-overflow'].";
        visibility: ".$tplSettings['pos-outerRight-visibility'].";
        text-align: ".$tplSettings['pos-outerRight-text-align'].";
        vertical-align: ".$tplSettings['pos-outerRight-vertical-align'].";
        margin-top: ".$tplSettings['pos-outerRight-marginTop'].";
        margin-bottom: ".$tplSettings['pos-outerRight-marginBottom'].";
        position: ".$tplSettings['pos-outerRight-position'].";
        background-color: #".$tplSettings['pos-outerRight-bgcolor'].";
        height: ".$tplSettings['pos-outerRight-height'].";
        z-index: ".$tplSettings['pos-outerRight-zindex'].";
        /* BACKGROUND IMAGE */
        background-image: url('".$tplSettings['pos-outerRight-bg-image']."');
        background-repeat:".$tplSettings['pos-outerRight-bg-repeat'].";
        background-position:".$tplSettings['pos-outerRight-bg-position'].";
        background-attachment:".$tplSettings['pos-outerRight-bg-attachment'].";
        background-size: ".$tplSettings['pos-outerRight-bg-size'].";
        ".$tplSettings['pos-outerRight-bg-gradient-longValue']."
        ".$tplSettings['pos-outerRight-customCSS-longValue']."
        background: ".$tplSettings['pos-outerRight-bgnone'].";
    }
    .pos-leftMenu
    {   
        -webkit-box-shadow: ".$tplSettings['pos-leftMenu-box-shadow-width']." #".$tplSettings['pos-leftMenu-box-shadow-color'].";
        -moz-box-shadow: ".$tplSettings['pos-leftMenu-box-shadow-width']." #".$tplSettings['pos-leftMenu-box-shadow-color'].";
        box-shadow: ".$tplSettings['pos-leftMenu-box-shadow-width']." #".$tplSettings['pos-leftMenu-box-shadow-color'].";
        border-width: ".$tplSettings['pos-leftMenu-border-width'].";
        border-color: #".$tplSettings['pos-leftMenu-border-color'].";
        border-style: ".$tplSettings['pos-leftMenu-border-style'].";
        border-radius: ".$tplSettings['pos-leftMenu-border-radius'].";
        padding: ".$tplSettings['pos-leftMenu-padding'].";
        overflow: ".$tplSettings['pos-leftMenu-overflow'].";
        visibility: ".$tplSettings['pos-leftMenu-visibility'].";
        text-align: ".$tplSettings['pos-leftMenu-text-align'].";
        vertical-align: ".$tplSettings['pos-leftMenu-vertical-align'].";
        margin-top: ".$tplSettings['pos-leftMenu-marginTop'].";
        margin-bottom: ".$tplSettings['pos-leftMenu-marginBottom'].";
        position: ".$tplSettings['pos-leftMenu-position'].";
        background-color: #".$tplSettings['pos-leftMenu-bgcolor'].";
        height: ".$tplSettings['pos-leftMenu-height'].";
        z-index: ".$tplSettings['pos-leftMenu-zindex'].";
        /* BACKGROUND IMAGE */
        background-image: url('".$tplSettings['pos-leftMenu-bg-image']."');
        background-repeat:".$tplSettings['pos-leftMenu-bg-repeat'].";
        background-position:".$tplSettings['pos-leftMenu-bg-position'].";
        background-attachment:".$tplSettings['pos-leftMenu-bg-attachment'].";
        background-size: ".$tplSettings['pos-leftMenu-bg-size'].";
        ".$tplSettings['pos-leftMenu-bg-gradient-longValue']."
        ".$tplSettings['pos-leftMenu-customCSS-longValue']."
        background: ".$tplSettings['pos-leftMenu-bgnone'].";
    }
    .pos-rightMenu
    {   
        -webkit-box-shadow: ".$tplSettings['pos-rightMenu-box-shadow-width']." #".$tplSettings['pos-rightMenu-box-shadow-color'].";
        -moz-box-shadow: ".$tplSettings['pos-rightMenu-box-shadow-width']." #".$tplSettings['pos-rightMenu-box-shadow-color'].";
        box-shadow: ".$tplSettings['pos-rightMenu-box-shadow-width']." #".$tplSettings['pos-rightMenu-box-shadow-color'].";
        border-width: ".$tplSettings['pos-rightMenu-border-width'].";
        border-color: #".$tplSettings['pos-rightMenu-border-color'].";
        border-style: ".$tplSettings['pos-rightMenu-border-style'].";
        border-radius: ".$tplSettings['pos-rightMenu-border-radius'].";
        padding: ".$tplSettings['pos-rightMenu-padding'].";
        overflow: ".$tplSettings['pos-rightMenu-overflow'].";
        visibility: ".$tplSettings['pos-rightMenu-visibility'].";
        text-align: ".$tplSettings['pos-rightMenu-text-align'].";
        vertical-align: ".$tplSettings['pos-rightMenu-vertical-align'].";
        margin-top: ".$tplSettings['pos-rightMenu-marginTop'].";
        margin-bottom: ".$tplSettings['pos-rightMenu-marginBottom'].";
        position: ".$tplSettings['pos-rightMenu-position'].";
        background-color: #".$tplSettings['pos-rightMenu-bgcolor'].";
        height: ".$tplSettings['pos-rightMenu-height'].";
        z-index: ".$tplSettings['pos-rightMenu-zindex'].";
        /* BACKGROUND IMAGE */
        background-image: url('".$tplSettings['pos-rightMenu-bg-image']."');
        background-repeat:".$tplSettings['pos-rightMenu-bg-repeat'].";
        background-position:".$tplSettings['pos-rightMenu-bg-position'].";
        background-attachment:".$tplSettings['pos-rightMenu-bg-attachment'].";
        background-size: ".$tplSettings['pos-rightMenu-bg-size'].";
        ".$tplSettings['pos-rightMenu-bg-gradient-longValue']."
        ".$tplSettings['pos-rightMenu-customCSS-longValue']."
        background: ".$tplSettings['pos-rightMenu-bgnone'].";
    }
    .pos-mainTop
    {   
        -webkit-box-shadow: ".$tplSettings['pos-mainTop-box-shadow-width']." #".$tplSettings['pos-mainTop-box-shadow-color'].";
        -moz-box-shadow: ".$tplSettings['pos-mainTop-box-shadow-width']." #".$tplSettings['pos-mainTop-box-shadow-color'].";
        box-shadow: ".$tplSettings['pos-mainTop-box-shadow-width']." #".$tplSettings['pos-mainTop-box-shadow-color'].";
        border-width: ".$tplSettings['pos-mainTop-border-width'].";
        border-color: #".$tplSettings['pos-mainTop-border-color'].";
        border-style: ".$tplSettings['pos-mainTop-border-style'].";
        border-radius: ".$tplSettings['pos-mainTop-border-radius'].";
        padding: ".$tplSettings['pos-mainTop-padding'].";
        overflow: ".$tplSettings['pos-mainTop-overflow'].";
        visibility: ".$tplSettings['pos-mainTop-visibility'].";
        text-align: ".$tplSettings['pos-mainTop-text-align'].";
        vertical-align: ".$tplSettings['pos-mainTop-vertical-align'].";
        margin-top: ".$tplSettings['pos-mainTop-marginTop'].";
        margin-bottom: ".$tplSettings['pos-mainTop-marginBottom'].";
        position: ".$tplSettings['pos-mainTop-position'].";
        background-color: #".$tplSettings['pos-mainTop-bgcolor'].";
        width: ".$tplSettings['pos-mainTop-width'].";
        height: ".$tplSettings['pos-mainTop-height'].";
        z-index: ".$tplSettings['pos-mainTop-zindex'].";
        /* BACKGROUND IMAGE */
        background-image: url('".$tplSettings['pos-mainTop-bg-image']."');
        background-repeat:".$tplSettings['pos-mainTop-bg-repeat'].";
        background-position:".$tplSettings['pos-mainTop-bg-position'].";
        background-attachment:".$tplSettings['pos-mainTop-bg-attachment'].";
        background-size: ".$tplSettings['pos-mainTop-bg-size'].";
        ".$tplSettings['pos-mainTop-bg-gradient-longValue']."
        ".$tplSettings['pos-mainTop-customCSS-longValue']."
        background: ".$tplSettings['pos-mainTop-bgnone'].";
    }
    .pos-mainTopLeft
    {   
        -webkit-box-shadow: ".$tplSettings['pos-mainTopLeft-box-shadow-width']." #".$tplSettings['pos-mainTopLeft-box-shadow-color'].";
        -moz-box-shadow: ".$tplSettings['pos-mainTopLeft-box-shadow-width']." #".$tplSettings['pos-mainTopLeft-box-shadow-color'].";
        box-shadow: ".$tplSettings['pos-mainTopLeft-box-shadow-width']." #".$tplSettings['pos-mainTopLeft-box-shadow-color'].";
        border-width: ".$tplSettings['pos-mainTopLeft-border-width'].";
        border-color: #".$tplSettings['pos-mainTopLeft-border-color'].";
        border-style: ".$tplSettings['pos-mainTopLeft-border-style'].";
        border-radius: ".$tplSettings['pos-mainTopLeft-border-radius'].";
        padding: ".$tplSettings['pos-mainTopLeft-padding'].";
        overflow: ".$tplSettings['pos-mainTopLeft-overflow'].";
        visibility: ".$tplSettings['pos-mainTopLeft-visibility'].";
        text-align: ".$tplSettings['pos-mainTopLeft-text-align'].";
        vertical-align: ".$tplSettings['pos-mainTopLeft-vertical-align'].";
        margin-top: ".$tplSettings['pos-mainTopLeft-marginTop'].";
        margin-bottom: ".$tplSettings['pos-mainTopLeft-marginBottom'].";
        position: ".$tplSettings['pos-mainTopLeft-position'].";
        background-color: #".$tplSettings['pos-mainTopLeft-bgcolor'].";
        height: ".$tplSettings['pos-mainTopLeft-height'].";
        z-index: ".$tplSettings['pos-mainTopLeft-zindex'].";
        /* BACKGROUND IMAGE */
        background-image: url('".$tplSettings['pos-mainTopLeft-bg-image']."');
        background-repeat:".$tplSettings['pos-mainTopLeft-bg-repeat'].";
        background-position:".$tplSettings['pos-mainTopLeft-bg-position'].";
        background-attachment:".$tplSettings['pos-mainTopLeft-bg-attachment'].";
        background-size: ".$tplSettings['pos-mainTopLeft-bg-size'].";
        ".$tplSettings['pos-mainTopLeft-bg-gradient-longValue']."
        ".$tplSettings['pos-mainTopLeft-customCSS-longValue']."
        background: ".$tplSettings['pos-mainTopLeft-bgnone'].";
    }
    .pos-mainTopCenter
    {   
        -webkit-box-shadow: ".$tplSettings['pos-mainTopCenter-box-shadow-width']." #".$tplSettings['pos-mainTopCenter-box-shadow-color'].";
        -moz-box-shadow: ".$tplSettings['pos-mainTopCenter-box-shadow-width']." #".$tplSettings['pos-mainTopCenter-box-shadow-color'].";
        box-shadow: ".$tplSettings['pos-mainTopCenter-box-shadow-width']." #".$tplSettings['pos-mainTopCenter-box-shadow-color'].";
        border-width: ".$tplSettings['pos-mainTopCenter-border-width'].";
        border-color: #".$tplSettings['pos-mainTopCenter-border-color'].";
        border-style: ".$tplSettings['pos-mainTopCenter-border-style'].";
        border-radius: ".$tplSettings['pos-mainTopCenter-border-radius'].";
        padding: ".$tplSettings['pos-mainTopCenter-padding'].";
        overflow: ".$tplSettings['pos-mainTopCenter-overflow'].";
        visibility: ".$tplSettings['pos-mainTopCenter-visibility'].";
        text-align: ".$tplSettings['pos-mainTopCenter-text-align'].";
        vertical-align: ".$tplSettings['pos-mainTopCenter-vertical-align'].";
        margin-top: ".$tplSettings['pos-mainTopCenter-marginTop'].";
        margin-bottom: ".$tplSettings['pos-mainTopCenter-marginBottom'].";
        position: ".$tplSettings['pos-mainTopCenter-position'].";
        background-color: #".$tplSettings['pos-mainTopCenter-bgcolor'].";
        height: ".$tplSettings['pos-mainTopCenter-height'].";
        z-index: ".$tplSettings['pos-mainTopCenter-zindex'].";
        /* BACKGROUND IMAGE */
        background-image: url('".$tplSettings['pos-mainTopCenter-bg-image']."');
        background-repeat:".$tplSettings['pos-mainTopCenter-bg-repeat'].";
        background-position:".$tplSettings['pos-mainTopCenter-bg-position'].";
        background-attachment:".$tplSettings['pos-mainTopCenter-bg-attachment'].";
        background-size: ".$tplSettings['pos-mainTopCenter-bg-size'].";
        ".$tplSettings['pos-mainTopCenter-bg-gradient-longValue']."
        ".$tplSettings['pos-mainTopCenter-customCSS-longValue']."
        background: ".$tplSettings['pos-mainTopCenter-bgnone'].";
    }
    .pos-mainTopRight
    {   
        -webkit-box-shadow: ".$tplSettings['pos-mainTopRight-box-shadow-width']." #".$tplSettings['pos-mainTopRight-box-shadow-color'].";
        -moz-box-shadow: ".$tplSettings['pos-mainTopRight-box-shadow-width']." #".$tplSettings['pos-mainTopRight-box-shadow-color'].";
        box-shadow: ".$tplSettings['pos-mainTopRight-box-shadow-width']." #".$tplSettings['pos-mainTopRight-box-shadow-color'].";
        border-width: ".$tplSettings['pos-mainTopRight-border-width'].";
        border-color: #".$tplSettings['pos-mainTopRight-border-color'].";
        border-style: ".$tplSettings['pos-mainTopRight-border-style'].";
        border-radius: ".$tplSettings['pos-mainTopRight-border-radius'].";
        padding: ".$tplSettings['pos-mainTopRight-padding'].";
        overflow: ".$tplSettings['pos-mainTopRight-overflow'].";
        visibility: ".$tplSettings['pos-mainTopRight-visibility'].";
        text-align: ".$tplSettings['pos-mainTopRight-text-align'].";
        vertical-align: ".$tplSettings['pos-mainTopRight-vertical-align'].";
        margin-top: ".$tplSettings['pos-mainTopRight-marginTop'].";
        margin-bottom: ".$tplSettings['pos-mainTopRight-marginBottom'].";
        position: ".$tplSettings['pos-mainTopRight-position'].";
        background-color: #".$tplSettings['pos-mainTopRight-bgcolor'].";
        height: ".$tplSettings['pos-mainTopRight-height'].";
        z-index: ".$tplSettings['pos-mainTopRight-zindex'].";
        /* BACKGROUND IMAGE */
        background-image: url('".$tplSettings['pos-mainTopRight-bg-image']."');
        background-repeat:".$tplSettings['pos-mainTopRight-bg-repeat'].";
        background-position:".$tplSettings['pos-mainTopRight-bg-position'].";
        background-attachment:".$tplSettings['pos-mainTopRight-bg-attachment'].";
        background-size: ".$tplSettings['pos-mainTopRight-bg-size'].";
        ".$tplSettings['pos-mainTopRight-bg-gradient-longValue']."
        ".$tplSettings['pos-mainTopRight-customCSS-longValue']."
        background: ".$tplSettings['pos-mainTopRight-bgnone'].";
    }
    .pos-mainLeft
    {   
        -webkit-box-shadow: ".$tplSettings['pos-mainLeft-box-shadow-width']." #".$tplSettings['pos-mainLeft-box-shadow-color'].";
        -moz-box-shadow: ".$tplSettings['pos-mainLeft-box-shadow-width']." #".$tplSettings['pos-mainLeft-box-shadow-color'].";
        box-shadow: ".$tplSettings['pos-mainLeft-box-shadow-width']." #".$tplSettings['pos-mainLeft-box-shadow-color'].";
        border-width: ".$tplSettings['pos-mainLeft-border-width'].";
        border-color: #".$tplSettings['pos-mainLeft-border-color'].";
        border-style: ".$tplSettings['pos-mainLeft-border-style'].";
        border-radius: ".$tplSettings['pos-mainLeft-border-radius'].";
        padding: ".$tplSettings['pos-mainLeft-padding'].";
        overflow: ".$tplSettings['pos-mainLeft-overflow'].";
        visibility: ".$tplSettings['pos-mainLeft-visibility'].";
        text-align: ".$tplSettings['pos-mainLeft-text-align'].";
        vertical-align: ".$tplSettings['pos-mainLeft-vertical-align'].";
        margin-top: ".$tplSettings['pos-mainLeft-marginTop'].";
        margin-bottom: ".$tplSettings['pos-mainLeft-marginBottom'].";
        position: ".$tplSettings['pos-mainLeft-position'].";
        background-color: #".$tplSettings['pos-mainLeft-bgcolor'].";
        height: ".$tplSettings['pos-mainLeft-height'].";
        z-index: ".$tplSettings['pos-mainLeft-zindex'].";
        /* BACKGROUND IMAGE */
        background-image: url('".$tplSettings['pos-mainLeft-bg-image']."');
        background-repeat:".$tplSettings['pos-mainLeft-bg-repeat'].";
        background-position:".$tplSettings['pos-mainLeft-bg-position'].";
        background-attachment:".$tplSettings['pos-mainLeft-bg-attachment'].";
        background-size: ".$tplSettings['pos-mainLeft-bg-size'].";
        ".$tplSettings['pos-mainLeft-bg-gradient-longValue']."
        ".$tplSettings['pos-mainLeft-customCSS-longValue']."
        background: ".$tplSettings['pos-mainLeft-bgnone'].";
    }
    .pos-main
    {   
        -webkit-box-shadow: ".$tplSettings['pos-main-box-shadow-width']." #".$tplSettings['pos-main-box-shadow-color'].";
        -moz-box-shadow: ".$tplSettings['pos-main-box-shadow-width']." #".$tplSettings['pos-main-box-shadow-color'].";
        box-shadow: ".$tplSettings['pos-main-box-shadow-width']." #".$tplSettings['pos-main-box-shadow-color'].";
        border-width: ".$tplSettings['pos-main-border-width'].";
        border-color: #".$tplSettings['pos-main-border-color'].";
        border-style: ".$tplSettings['pos-main-border-style'].";
        border-radius: ".$tplSettings['pos-main-border-radius'].";
        padding: ".$tplSettings['pos-main-padding'].";
        overflow: ".$tplSettings['pos-main-overflow'].";
        visibility: ".$tplSettings['pos-main-visibility'].";
        text-align: ".$tplSettings['pos-main-text-align'].";
        vertical-align: ".$tplSettings['pos-main-vertical-align'].";
        margin-top: ".$tplSettings['pos-main-marginTop'].";
        margin-bottom: ".$tplSettings['pos-main-marginBottom'].";
        position: ".$tplSettings['pos-main-position'].";
        background-color: #".$tplSettings['pos-main-bgcolor'].";
        height: ".$tplSettings['pos-main-height'].";
        z-index: ".$tplSettings['pos-main-zindex'].";
        /* BACKGROUND IMAGE */
        background-image: url('".$tplSettings['pos-main-bg-image']."');
        background-repeat:".$tplSettings['pos-main-bg-repeat'].";
        background-position:".$tplSettings['pos-main-bg-position'].";
        background-attachment:".$tplSettings['pos-main-bg-attachment'].";
        background-size: ".$tplSettings['pos-main-bg-size'].";
        ".$tplSettings['pos-main-bg-gradient-longValue']."
        ".$tplSettings['pos-main-customCSS-longValue']."
        background: ".$tplSettings['pos-main-bgnone'].";
    }
    .pos-mainRight
    {   
        -webkit-box-shadow: ".$tplSettings['pos-mainRight-box-shadow-width']." #".$tplSettings['pos-mainRight-box-shadow-color'].";
        -moz-box-shadow: ".$tplSettings['pos-mainRight-box-shadow-width']." #".$tplSettings['pos-mainRight-box-shadow-color'].";
        box-shadow: ".$tplSettings['pos-mainRight-box-shadow-width']." #".$tplSettings['pos-mainRight-box-shadow-color'].";
        border-width: ".$tplSettings['pos-mainRight-border-width'].";
        border-color: #".$tplSettings['pos-mainRight-border-color'].";
        border-style: ".$tplSettings['pos-mainRight-border-style'].";
        border-radius: ".$tplSettings['pos-mainRight-border-radius'].";
        padding: ".$tplSettings['pos-mainRight-padding'].";
        overflow: ".$tplSettings['pos-mainRight-overflow'].";
        visibility: ".$tplSettings['pos-mainRight-visibility'].";
        text-align: ".$tplSettings['pos-mainRight-text-align'].";
        vertical-align: ".$tplSettings['pos-mainRight-vertical-align'].";
        margin-top: ".$tplSettings['pos-mainRight-marginTop'].";
        margin-bottom: ".$tplSettings['pos-mainRight-marginBottom'].";
        position: ".$tplSettings['pos-mainRight-position'].";
        background-color: #".$tplSettings['pos-mainRight-bgcolor'].";
        height: ".$tplSettings['pos-mainRight-height'].";
        z-index: ".$tplSettings['pos-mainRight-zindex'].";
        /* BACKGROUND IMAGE */
        background-image: url('".$tplSettings['pos-mainRight-bg-image']."');
        background-repeat:".$tplSettings['pos-mainRight-bg-repeat'].";
        background-position:".$tplSettings['pos-mainRight-bg-position'].";
        background-attachment:".$tplSettings['pos-mainRight-bg-attachment'].";
        background-size: ".$tplSettings['pos-mainRight-bg-size'].";
        ".$tplSettings['pos-mainRight-bg-gradient-longValue']."
        ".$tplSettings['pos-mainRight-customCSS-longValue']."
        background: ".$tplSettings['pos-mainRight-bgnone'].";
    }
    .pos-mainBottom
    {   
        -webkit-box-shadow: ".$tplSettings['pos-mainBottom-box-shadow-width']." #".$tplSettings['pos-mainBottom-box-shadow-color'].";
        -moz-box-shadow: ".$tplSettings['pos-mainBottom-box-shadow-width']." #".$tplSettings['pos-mainBottom-box-shadow-color'].";
        box-shadow: ".$tplSettings['pos-mainBottom-box-shadow-width']." #".$tplSettings['pos-mainBottom-box-shadow-color'].";
        border-width: ".$tplSettings['pos-mainBottom-border-width'].";
        border-color: #".$tplSettings['pos-mainBottom-border-color'].";
        border-style: ".$tplSettings['pos-mainBottom-border-style'].";
        border-radius: ".$tplSettings['pos-mainBottom-border-radius'].";
        padding: ".$tplSettings['pos-mainBottom-padding'].";
        overflow: ".$tplSettings['pos-mainBottom-overflow'].";
        visibility: ".$tplSettings['pos-mainBottom-visibility'].";
        text-align: ".$tplSettings['pos-mainBottom-text-align'].";
        vertical-align: ".$tplSettings['pos-mainBottom-vertical-align'].";
        margin-top: ".$tplSettings['pos-mainBottom-marginTop'].";
        margin-bottom: ".$tplSettings['pos-mainBottom-marginBottom'].";
        position: ".$tplSettings['pos-mainBottom-position'].";
        background-color: #".$tplSettings['pos-mainBottom-bgcolor'].";
        width: ".$tplSettings['pos-mainBottom-width'].";
        height: ".$tplSettings['pos-mainBottom-height'].";
        z-index: ".$tplSettings['pos-mainBottom-zindex'].";
        /* BACKGROUND IMAGE */
        background-image: url('".$tplSettings['pos-mainBottom-bg-image']."');
        background-repeat:".$tplSettings['pos-mainBottom-bg-repeat'].";
        background-position:".$tplSettings['pos-mainBottom-bg-position'].";
        background-attachment:".$tplSettings['pos-mainBottom-bg-attachment'].";
        background-size: ".$tplSettings['pos-mainBottom-bg-size'].";
        ".$tplSettings['pos-mainBottom-bg-gradient-longValue']."
        ".$tplSettings['pos-mainBottom-customCSS-longValue']."
        background: ".$tplSettings['pos-mainBottom-bgnone'].";
    }
    .pos-mainBottomLeft
    {   
        -webkit-box-shadow: ".$tplSettings['pos-mainBottomLeft-box-shadow-width']." #".$tplSettings['pos-mainBottomLeft-box-shadow-color'].";
        -moz-box-shadow: ".$tplSettings['pos-mainBottomLeft-box-shadow-width']." #".$tplSettings['pos-mainBottomLeft-box-shadow-color'].";
        box-shadow: ".$tplSettings['pos-mainBottomLeft-box-shadow-width']." #".$tplSettings['pos-mainBottomLeft-box-shadow-color'].";
        border-width: ".$tplSettings['pos-mainBottomLeft-border-width'].";
        border-color: #".$tplSettings['pos-mainBottomLeft-border-color'].";
        border-style: ".$tplSettings['pos-mainBottomLeft-border-style'].";
        border-radius: ".$tplSettings['pos-mainBottomLeft-border-radius'].";
        padding: ".$tplSettings['pos-mainBottomLeft-padding'].";
        overflow: ".$tplSettings['pos-mainBottomLeft-overflow'].";
        visibility: ".$tplSettings['pos-mainBottomLeft-visibility'].";
        text-align: ".$tplSettings['pos-mainBottomLeft-text-align'].";
        vertical-align: ".$tplSettings['pos-mainBottomLeft-vertical-align'].";
        margin-top: ".$tplSettings['pos-mainBottomLeft-marginTop'].";
        margin-bottom: ".$tplSettings['pos-mainBottomLeft-marginBottom'].";
        position: ".$tplSettings['pos-mainBottomLeft-position'].";
        background-color: #".$tplSettings['pos-mainBottomLeft-bgcolor'].";
        height: ".$tplSettings['pos-mainBottomLeft-height'].";
        z-index: ".$tplSettings['pos-mainBottomLeft-zindex'].";
        /* BACKGROUND IMAGE */
        background-image: url('".$tplSettings['pos-mainBottomLeft-bg-image']."');
        background-repeat:".$tplSettings['pos-mainBottomLeft-bg-repeat'].";
        background-position:".$tplSettings['pos-mainBottomLeft-bg-position'].";
        background-attachment:".$tplSettings['pos-mainBottomLeft-bg-attachment'].";
        background-size: ".$tplSettings['pos-mainBottomLeft-bg-size'].";
        ".$tplSettings['pos-mainBottomLeft-bg-gradient-longValue']."
        ".$tplSettings['pos-mainBottomLeft-customCSS-longValue']."
        background: ".$tplSettings['pos-mainBottomLeft-bgnone'].";
    }
    .pos-mainBottomCenter
    {   
        -webkit-box-shadow: ".$tplSettings['pos-mainBottomCenter-box-shadow-width']." #".$tplSettings['pos-mainBottomCenter-box-shadow-color'].";
        -moz-box-shadow: ".$tplSettings['pos-mainBottomCenter-box-shadow-width']." #".$tplSettings['pos-mainBottomCenter-box-shadow-color'].";
        box-shadow: ".$tplSettings['pos-mainBottomCenter-box-shadow-width']." #".$tplSettings['pos-mainBottomCenter-box-shadow-color'].";
        border-width: ".$tplSettings['pos-mainBottomCenter-border-width'].";
        border-color: #".$tplSettings['pos-mainBottomCenter-border-color'].";
        border-style: ".$tplSettings['pos-mainBottomCenter-border-style'].";
        border-radius: ".$tplSettings['pos-mainBottomCenter-border-radius'].";
        padding: ".$tplSettings['pos-mainBottomCenter-padding'].";
        overflow: ".$tplSettings['pos-mainBottomCenter-overflow'].";
        visibility: ".$tplSettings['pos-mainBottomCenter-visibility'].";
        text-align: ".$tplSettings['pos-mainBottomCenter-text-align'].";
        vertical-align: ".$tplSettings['pos-mainBottomCenter-vertical-align'].";
        margin-top: ".$tplSettings['pos-mainBottomCenter-marginTop'].";
        margin-bottom: ".$tplSettings['pos-mainBottomCenter-marginBottom'].";
        position: ".$tplSettings['pos-mainBottomCenter-position'].";
        background-color: #".$tplSettings['pos-mainBottomCenter-bgcolor'].";
        height: ".$tplSettings['pos-mainBottomCenter-height'].";
        z-index: ".$tplSettings['pos-mainBottomCenter-zindex'].";    
        /* BACKGROUND IMAGE */
        background-image: url('".$tplSettings['pos-mainBottomCenter-bg-image']."');
        background-repeat:".$tplSettings['pos-mainBottomCenter-bg-repeat'].";
        background-position:".$tplSettings['pos-mainBottomCenter-bg-position'].";
        background-attachment:".$tplSettings['pos-mainBottomCenter-bg-attachment'].";
        background-size: ".$tplSettings['pos-mainBottomCenter-bg-size'].";
        ".$tplSettings['pos-mainBottomCenter-bg-gradient-longValue']."
        ".$tplSettings['pos-mainBottomCenter-customCSS-longValue']."
        background: ".$tplSettings['pos-mainBottomCenter-bgnone'].";    
    }
    .pos-mainBottomRight
    {   
        -webkit-box-shadow: ".$tplSettings['pos-mainBottomRight-box-shadow-width']." #".$tplSettings['pos-mainBottomRight-box-shadow-color'].";
        -moz-box-shadow: ".$tplSettings['pos-mainBottomRight-box-shadow-width']." #".$tplSettings['pos-mainBottomRight-box-shadow-color'].";
        box-shadow: ".$tplSettings['pos-mainBottomRight-box-shadow-width']." #".$tplSettings['pos-mainBottomRight-box-shadow-color'].";
        border-width: ".$tplSettings['pos-mainBottomRight-border-width'].";
        border-color: #".$tplSettings['pos-mainBottomRight-border-color'].";
        border-style: ".$tplSettings['pos-mainBottomRight-border-style'].";
        border-radius: ".$tplSettings['pos-mainBottomRight-border-radius'].";
        padding: ".$tplSettings['pos-mainBottomRight-padding'].";
        overflow: ".$tplSettings['pos-mainBottomRight-overflow'].";
        visibility: ".$tplSettings['pos-mainBottomRight-visibility'].";
        text-align: ".$tplSettings['pos-mainBottomRight-text-align'].";
        vertical-align: ".$tplSettings['pos-mainBottomRight-vertical-align'].";
        margin-top: ".$tplSettings['pos-mainBottomRight-marginTop'].";
        margin-bottom: ".$tplSettings['pos-mainBottomRight-marginBottom'].";
        position: ".$tplSettings['pos-mainBottomRight-position'].";
        background-color: #".$tplSettings['pos-mainBottomRight-bgcolor'].";
        height: ".$tplSettings['pos-mainBottomRight-height'].";
        z-index: ".$tplSettings['pos-mainBottomRight-zindex'].";
        /* BACKGROUND IMAGE */
        background-image: url('".$tplSettings['pos-mainBottomRight-bg-image']."');
        background-repeat:".$tplSettings['pos-mainBottomRight-bg-repeat'].";
        background-position:".$tplSettings['pos-mainBottomRight-bg-position'].";
        background-attachment:".$tplSettings['pos-mainBottomRight-bg-attachment'].";
        background-size: ".$tplSettings['pos-mainBottomRight-bg-size'].";
        ".$tplSettings['pos-mainBottomRight-bg-gradient-longValue']."
        ".$tplSettings['pos-mainBottomRight-customCSS-longValue']."
        background: ".$tplSettings['pos-mainBottomRight-bgnone'].";
    }
    .pos-mainFooter
    {   
        -webkit-box-shadow: ".$tplSettings['pos-mainFooter-box-shadow-width']." #".$tplSettings['pos-mainFooter-box-shadow-color'].";
        -moz-box-shadow: ".$tplSettings['pos-mainFooter-box-shadow-width']." #".$tplSettings['pos-mainFooter-box-shadow-color'].";
        box-shadow: ".$tplSettings['pos-mainFooter-box-shadow-width']." #".$tplSettings['pos-mainFooter-box-shadow-color'].";
        border-width: ".$tplSettings['pos-mainFooter-border-width'].";
        border-color: #".$tplSettings['pos-mainFooter-border-color'].";
        border-style: ".$tplSettings['pos-mainFooter-border-style'].";
        border-radius: ".$tplSettings['pos-mainFooter-border-radius'].";
        padding: ".$tplSettings['pos-mainFooter-padding'].";
        overflow: ".$tplSettings['pos-mainFooter-overflow'].";
        visibility: ".$tplSettings['pos-mainFooter-visibility'].";
        text-align: ".$tplSettings['pos-mainFooter-text-align'].";
        vertical-align: ".$tplSettings['pos-mainFooter-vertical-align'].";
        margin-top: ".$tplSettings['pos-mainFooter-marginTop'].";
        margin-bottom: ".$tplSettings['pos-mainFooter-marginBottom'].";
        position: ".$tplSettings['pos-mainFooter-position'].";
        background-color: #".$tplSettings['pos-mainFooter-bgcolor'].";
        width: ".$tplSettings['pos-mainFooter-width'].";
        height: ".$tplSettings['pos-mainFooter-height'].";
        z-index: ".$tplSettings['pos-mainFooter-zindex'].";
        /* BACKGROUND IMAGE */
        background-image: url('".$tplSettings['pos-mainFooter-bg-image']."');
        background-repeat:".$tplSettings['pos-mainFooter-bg-repeat'].";
        background-position:".$tplSettings['pos-mainFooter-bg-position'].";
        background-attachment:".$tplSettings['pos-mainFooter-bg-attachment'].";
        background-size: ".$tplSettings['pos-mainFooter-bg-size'].";
        ".$tplSettings['pos-mainFooter-bg-gradient-longValue']."
        ".$tplSettings['pos-mainFooter-customCSS-longValue']."
        background: ".$tplSettings['pos-mainFooter-bgnone'].";
    }
    .pos-mainFooterLeft
    {   
        -webkit-box-shadow: ".$tplSettings['pos-mainFooterLeft-box-shadow-width']." #".$tplSettings['pos-mainFooterLeft-box-shadow-color'].";
        -moz-box-shadow: ".$tplSettings['pos-mainFooterLeft-box-shadow-width']." #".$tplSettings['pos-mainFooterLeft-box-shadow-color'].";
        box-shadow: ".$tplSettings['pos-mainFooterLeft-box-shadow-width']." #".$tplSettings['pos-mainFooterLeft-box-shadow-color'].";
        border-width: ".$tplSettings['pos-mainFooterLeft-border-width'].";
        border-color: #".$tplSettings['pos-mainFooterLeft-border-color'].";
        border-style: ".$tplSettings['pos-mainFooterLeft-border-style'].";
        border-radius: ".$tplSettings['pos-mainFooterLeft-border-radius'].";
        padding: ".$tplSettings['pos-mainFooterLeft-padding'].";
        overflow: ".$tplSettings['pos-mainFooterLeft-overflow'].";
        visibility: ".$tplSettings['pos-mainFooterLeft-visibility'].";
        text-align: ".$tplSettings['pos-mainFooterLeft-text-align'].";
        vertical-align: ".$tplSettings['pos-mainFooterLeft-vertical-align'].";
        margin-top: ".$tplSettings['pos-mainFooterLeft-marginTop'].";
        margin-bottom: ".$tplSettings['pos-mainFooterLeft-marginBottom'].";
        position: ".$tplSettings['pos-mainFooterLeft-position'].";
        background-color: #".$tplSettings['pos-mainFooterLeft-bgcolor'].";
        height: ".$tplSettings['pos-mainFooterLeft-height'].";
        z-index: ".$tplSettings['pos-mainFooterLeft-zindex'].";
        /* BACKGROUND IMAGE */
        background-image: url('".$tplSettings['pos-mainFooterLeft-bg-image']."');
        background-repeat:".$tplSettings['pos-mainFooterLeft-bg-repeat'].";
        background-position:".$tplSettings['pos-mainFooterLeft-bg-position'].";
        background-attachment:".$tplSettings['pos-mainFooterLeft-bg-attachment'].";
        background-size: ".$tplSettings['pos-mainFooterLeft-bg-size'].";
        ".$tplSettings['pos-mainFooterLeft-bg-gradient-longValue']."
        ".$tplSettings['pos-mainFooterLeft-customCSS-longValue']."
        background: ".$tplSettings['pos-mainFooterLeft-bgnone'].";
    }
    .pos-mainFooterCenter
    {   
        -webkit-box-shadow: ".$tplSettings['pos-mainFooterCenter-box-shadow-width']." #".$tplSettings['pos-mainFooterCenter-box-shadow-color'].";
        -moz-box-shadow: ".$tplSettings['pos-mainFooterCenter-box-shadow-width']." #".$tplSettings['pos-mainFooterCenter-box-shadow-color'].";
        box-shadow: ".$tplSettings['pos-mainFooterCenter-box-shadow-width']." #".$tplSettings['pos-mainFooterCenter-box-shadow-color'].";
        border-width: ".$tplSettings['pos-mainFooterCenter-border-width'].";
        border-color: #".$tplSettings['pos-mainFooterCenter-border-color'].";
        border-style: ".$tplSettings['pos-mainFooterCenter-border-style'].";
        border-radius: ".$tplSettings['pos-mainFooterCenter-border-radius'].";
        padding: ".$tplSettings['pos-mainFooterCenter-padding'].";
        overflow: ".$tplSettings['pos-mainFooterCenter-overflow'].";
        visibility: ".$tplSettings['pos-mainFooterCenter-visibility'].";
        text-align: ".$tplSettings['pos-mainFooterCenter-text-align'].";
        vertical-align: ".$tplSettings['pos-mainFooterCenter-vertical-align'].";
        margin-top: ".$tplSettings['pos-mainFooterCenter-marginTop'].";
        margin-bottom: ".$tplSettings['pos-mainFooterCenter-marginBottom'].";
        position: ".$tplSettings['pos-mainFooterCenter-position'].";
        background-color: #".$tplSettings['pos-mainFooterCenter-bgcolor'].";
        height: ".$tplSettings['pos-mainFooterCenter-height'].";
        z-index: ".$tplSettings['pos-mainFooterCenter-zindex'].";
        /* BACKGROUND IMAGE */
        background-image: url('".$tplSettings['pos-mainFooterCenter-bg-image']."');
        background-repeat:".$tplSettings['pos-mainFooterCenter-bg-repeat'].";
        background-position:".$tplSettings['pos-mainFooterCenter-bg-position'].";
        background-attachment:".$tplSettings['pos-mainFooterCenter-bg-attachment'].";
        background-size: ".$tplSettings['pos-mainFooterCenter-bg-size'].";
        ".$tplSettings['pos-mainFooterCenter-bg-gradient-longValue']."
        ".$tplSettings['pos-mainFooterCenter-customCSS-longValue']."
        background: ".$tplSettings['pos-mainFooterCenter-bgnone'].";
    }
    .pos-mainFooterRight
    {   
        -webkit-box-shadow: ".$tplSettings['pos-mainFooterRight-box-shadow-width']." #".$tplSettings['pos-mainFooterRight-box-shadow-color'].";
        -moz-box-shadow: ".$tplSettings['pos-mainFooterRight-box-shadow-width']." #".$tplSettings['pos-mainFooterRight-box-shadow-color'].";
        box-shadow: ".$tplSettings['pos-mainFooterRight-box-shadow-width']." #".$tplSettings['pos-mainFooterRight-box-shadow-color'].";
        border-width: ".$tplSettings['pos-mainFooterRight-border-width'].";
        border-color: #".$tplSettings['pos-mainFooterRight-border-color'].";
        border-style: ".$tplSettings['pos-mainFooterRight-border-style'].";
        border-radius: ".$tplSettings['pos-mainFooterRight-border-radius'].";
        padding: ".$tplSettings['pos-mainFooterRight-padding'].";
        overflow: ".$tplSettings['pos-mainFooterRight-overflow'].";
        visibility: ".$tplSettings['pos-mainFooterRight-visibility'].";
        text-align: ".$tplSettings['pos-mainFooterRight-text-align'].";
        vertical-align: ".$tplSettings['pos-mainFooterRight-vertical-align'].";
        margin-top: ".$tplSettings['pos-mainFooterRight-marginTop'].";
        margin-bottom: ".$tplSettings['pos-mainFooterRight-marginBottom'].";
        position: ".$tplSettings['pos-mainFooterRight-position'].";
        background-color: #".$tplSettings['pos-mainFooterRight-bgcolor'].";
        height: ".$tplSettings['pos-mainFooterRight-height'].";
        z-index: ".$tplSettings['pos-mainFooterRight-zindex'].";
        /* BACKGROUND IMAGE */
        background-image: url('".$tplSettings['pos-mainFooterRight-bg-image']."');
        background-repeat:".$tplSettings['pos-mainFooterRight-bg-repeat'].";
        background-position:".$tplSettings['pos-mainFooterRight-bg-position'].";
        background-attachment:".$tplSettings['pos-mainFooterRight-bg-attachment'].";
        background-size: ".$tplSettings['pos-mainFooterRight-bg-size'].";
        ".$tplSettings['pos-mainFooterRight-bg-gradient-longValue']."
        ".$tplSettings['pos-mainFooterRight-customCSS-longValue']."
        background: ".$tplSettings['pos-mainFooterRight-bgnone'].";
    }
    .pos-footer
    {   
        -webkit-box-shadow: ".$tplSettings['pos-footer-box-shadow-width']." #".$tplSettings['pos-footer-box-shadow-color'].";
        -moz-box-shadow: ".$tplSettings['pos-footer-box-shadow-width']." #".$tplSettings['pos-footer-box-shadow-color'].";
        box-shadow: ".$tplSettings['pos-footer-box-shadow-width']." #".$tplSettings['pos-footer-box-shadow-color'].";
        border-width: ".$tplSettings['pos-footer-border-width'].";
        border-color: #".$tplSettings['pos-footer-border-color'].";
        border-style: ".$tplSettings['pos-footer-border-style'].";
        border-radius: ".$tplSettings['pos-footer-border-radius'].";
        padding: ".$tplSettings['pos-footer-padding'].";
        overflow: ".$tplSettings['pos-footer-overflow'].";
        visibility: ".$tplSettings['pos-footer-visibility'].";
        text-align: ".$tplSettings['pos-footer-text-align'].";
        vertical-align: ".$tplSettings['pos-footer-vertical-align'].";
        margin-top: ".$tplSettings['pos-footer-marginTop'].";
        margin-bottom: ".$tplSettings['pos-footer-marginBottom'].";
        position: ".$tplSettings['pos-footer-position'].";
        background-color: #".$tplSettings['pos-footer-bgcolor'].";
        width: ".$tplSettings['pos-footer-width'].";
        height: ".$tplSettings['pos-footer-height'].";
        z-index: ".$tplSettings['pos-footer-zindex'].";
        /* BACKGROUND IMAGE */
        background-image: url('".$tplSettings['pos-footer-bg-image']."');
        background-repeat:".$tplSettings['pos-footer-bg-repeat'].";
        background-position:".$tplSettings['pos-footer-bg-position'].";
        background-attachment:".$tplSettings['pos-footer-bg-attachment'].";
        background-size: ".$tplSettings['pos-footer-bg-size'].";
        ".$tplSettings['pos-footer-bg-gradient-longValue']."
        ".$tplSettings['pos-footer-customCSS-longValue']."
        background: ".$tplSettings['pos-footer-bgnone'].";
    }
    .pos-hiddenToolbar
    {   
        -webkit-box-shadow: ".$tplSettings['pos-hiddenToolbar-box-shadow-width']." #".$tplSettings['pos-hiddenToolbar-box-shadow-color'].";
        -moz-box-shadow: ".$tplSettings['pos-hiddenToolbar-box-shadow-width']." #".$tplSettings['pos-hiddenToolbar-box-shadow-color'].";
        box-shadow: ".$tplSettings['pos-hiddenToolbar-box-shadow-width']." #".$tplSettings['pos-hiddenToolbar-box-shadow-color'].";
        border-width: ".$tplSettings['pos-hiddenToolbar-border-width'].";
        border-color: #".$tplSettings['pos-hiddenToolbar-border-color'].";
        border-style: ".$tplSettings['pos-hiddenToolbar-border-style'].";
        border-radius: ".$tplSettings['pos-hiddenToolbar-border-radius'].";
        padding: ".$tplSettings['pos-hiddenToolbar-padding'].";
        overflow: ".$tplSettings['pos-hiddenToolbar-overflow'].";
        visibility: ".$tplSettings['pos-hiddenToolbar-visibility'].";
        text-align: ".$tplSettings['pos-hiddenToolbar-text-align'].";
        vertical-align: ".$tplSettings['pos-hiddenToolbar-vertical-align'].";
        margin-top: ".$tplSettings['pos-hiddenToolbar-marginTop'].";
        margin-bottom: ".$tplSettings['pos-hiddenToolbar-marginBottom'].";
        position: ".$tplSettings['pos-hiddenToolbar-position'].";
        background-color: #".$tplSettings['pos-hiddenToolbar-bgcolor'].";
        width: ".$tplSettings['pos-hiddenToolbar-width'].";
        height: ".$tplSettings['pos-hiddenToolbar-height'].";
        z-index: ".$tplSettings['pos-hiddenToolbar-zindex'].";
        /* BACKGROUND IMAGE */
        background-image: url('".$tplSettings['pos-hiddenToolbar-bg-image']."');
        background-repeat:".$tplSettings['pos-hiddenToolbar-bg-repeat'].";
        background-position:".$tplSettings['pos-hiddenToolbar-bg-position'].";
        background-attachment:".$tplSettings['pos-hiddenToolbar-bg-attachment'].";
        background-size: ".$tplSettings['pos-hiddenToolbar-bg-size'].";
        ".$tplSettings['pos-hiddenToolbar-bg-gradient-longValue']."
        ".$tplSettings['pos-hiddenToolbar-customCSS-longValue']."
        background: ".$tplSettings['pos-hiddenToolbar-bgnone'].";
    }
    .pos-debug
    {   
        -webkit-box-shadow: ".$tplSettings['pos-debug-box-shadow-width']." #".$tplSettings['pos-debug-box-shadow-color'].";
        -moz-box-shadow: ".$tplSettings['pos-debug-box-shadow-width']." #".$tplSettings['pos-debug-box-shadow-color'].";
        box-shadow: ".$tplSettings['pos-debug-box-shadow-width']." #".$tplSettings['pos-debug-box-shadow-color'].";
        border-width: ".$tplSettings['pos-debug-border-width'].";
        border-color: #".$tplSettings['pos-debug-border-color'].";
        border-style: ".$tplSettings['pos-debug-border-style'].";
        border-radius: ".$tplSettings['pos-debug-border-radius'].";
        padding: ".$tplSettings['pos-debug-padding'].";
        overflow: ".$tplSettings['pos-debug-overflow'].";
        visibility: ".$tplSettings['pos-debug-visibility'].";
        text-align: ".$tplSettings['pos-debug-text-align'].";
        vertical-align: ".$tplSettings['pos-debug-vertical-align'].";
        margin-top: ".$tplSettings['pos-debug-marginTop'].";
        margin-bottom: ".$tplSettings['pos-debug-marginBottom'].";
        position: ".$tplSettings['pos-debug-position'].";
        background-color: #".$tplSettings['pos-debug-bgcolor'].";
        width: ".$tplSettings['pos-debug-width'].";
        height: ".$tplSettings['pos-debug-height'].";
        z-index: ".$tplSettings['pos-debug-zindex'].";
        /* BACKGROUND IMAGE */
        background-image: url('".$tplSettings['pos-debug-bg-image']."');
        background-repeat:".$tplSettings['pos-debug-bg-repeat'].";
        background-position:".$tplSettings['pos-debug-bg-position'].";
        background-attachment:".$tplSettings['pos-debug-bg-attachment'].";
        background-size: ".$tplSettings['pos-debug-bg-size'].";
        ".$tplSettings['pos-debug-bg-gradient-longValue']."
        ".$tplSettings['pos-debug-customCSS-longValue']."
        background: ".$tplSettings['pos-debug-bgnone'].";
    }
    .pos-outerBottom
    {   
        -webkit-box-shadow: ".$tplSettings['pos-outerBottom-box-shadow-width']." #".$tplSettings['pos-outerBottom-box-shadow-color'].";
        -moz-box-shadow: ".$tplSettings['pos-outerBottom-box-shadow-width']." #".$tplSettings['pos-outerBottom-box-shadow-color'].";
        box-shadow: ".$tplSettings['pos-outerBottom-box-shadow-width']." #".$tplSettings['pos-outerBottom-box-shadow-color'].";
        border-width: ".$tplSettings['pos-outerBottom-border-width'].";
        border-color: #".$tplSettings['pos-outerBottom-border-color'].";
        border-style: ".$tplSettings['pos-outerBottom-border-style'].";
        border-radius: ".$tplSettings['pos-outerBottom-border-radius'].";
        padding: ".$tplSettings['pos-outerBottom-padding'].";
        overflow: ".$tplSettings['pos-outerBottom-overflow'].";
        visibility: ".$tplSettings['pos-outerBottom-visibility'].";
        text-align: ".$tplSettings['pos-outerBottom-text-align'].";
        vertical-align: ".$tplSettings['pos-outerBottom-vertical-align'].";
        margin-top: ".$tplSettings['pos-outerBottom-marginTop'].";
        margin-bottom: ".$tplSettings['pos-outerBottom-marginBottom'].";
        position: ".$tplSettings['pos-outerBottom-position'].";
        background-color: #".$tplSettings['pos-outerBottom-bgcolor'].";
        width: ".$tplSettings['pos-outerBottom-width'].";
        height: ".$tplSettings['pos-outerBottom-height'].";
        z-index: ".$tplSettings['pos-outerBottom-zindex'].";
        /* BACKGROUND IMAGE */
        background-image: url('".$tplSettings['pos-outerBottom-bg-image']."');
        background-repeat:".$tplSettings['pos-outerBottom-bg-repeat'].";
        background-position:".$tplSettings['pos-outerBottom-bg-position'].";
        background-attachment:".$tplSettings['pos-outerBottom-bg-attachment'].";
        background-size: ".$tplSettings['pos-outerBottom-bg-size'].";
        ".$tplSettings['pos-outerBottom-bg-gradient-longValue']."
        ".$tplSettings['pos-outerBottom-customCSS-longValue']."
        background: ".$tplSettings['pos-outerBottom-bgnone'].";
    }
    ";

        if (isset($_POST['getID']))
        {
            $template->id = $_POST['getID'];
        }
        if (isset($_GET['id']))
        {   // if id is set
            $template->id = $_GET['id'];
        }
        // WRITE CSS FILES
        // create settings.css for development purpose (css/settings.css)
        $template->writeTemplateCssFile($db, $template->id, $content, 0); // 0 = do no minify
        // create minified version for production environments (css/settings.min.css)
        $template->writeTemplateCssFile($db, $template->id, $content, 1); // 1 = minify

        //////////////////////////////////////////////////////////////////////////////////////
        \YAWK\sys::setTimeout("index.php?page=$redirect", 0);
    }
}

?>