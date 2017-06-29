<!-- color picker -->
<script type="text/javascript" src="../system/engines/jquery/jscolor/jscolor.js"></script>
<!-- TAB collapse -->
<script type="text/javascript" src="../system/engines/jquery/bootstrap-tabcollapse.js"></script>
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
// get settings for editor
$editorSettings = \YAWK\settings::getEditorSettings($db, 14);
?>
<!-- include summernote css/js-->
<!-- include codemirror (codemirror.css, codemirror.js, xml.js) -->
<link rel="stylesheet" type="text/css" href="../system/engines/codemirror/codemirror.min.css">
<link rel="stylesheet" type="text/css" href="../system/engines/codemirror/themes/<?php echo $editorSettings['editorTheme']; ?>.css">
<link rel="stylesheet" type="text/css" href="../system/engines/codemirror/show-hint.min.css">
<script type="text/javascript" src="../system/engines/codemirror/codemirror-compressed.js"></script>
<script type="text/javascript" src="../system/engines/codemirror/auto-refresh.js"></script>

<!-- SUMMERNOTE -->
<link href="../system/engines/summernote/dist/summernote.css" rel="stylesheet">
<script src="../system/engines/summernote/dist/summernote.min.js"></script>
<script src="../system/engines/summernote/dist/summernote-cleaner.js"></script>
<script src="../system/engines/summernote/dist/summernote-image-attributes.js"></script>
<script src="../system/engines/summernote/dist/summernote-floats-bs.js"></script>

<script type="text/javascript">
    $(document).ready(function() {
        // textarea that will be transformed into editor
        var editor = ('textarea#summernote');
        var savebutton = ('#savebutton');
        var savebuttonIcon = ('#savebuttonIcon');
        // ok, lets go...
        // we need to check if user clicked on save button
        $(savebutton).click(function() {
            $(savebutton).removeClass('btn btn-success').addClass('btn btn-warning disabled');
            $(savebuttonIcon).removeClass('fa fa-check').addClass('fa fa-spinner fa-spin fa-fw');
            // to save, even if the editor is currently opened in code view
            // we need to check if codeview is currently active:
            if ($(editor).summernote('codeview.isActivated')) {
                // if so, turn it off.
                $(editor).summernote('codeview.deactivate');
            }
            // to display images in frontend correctly, we need to change the path of every image.
            // to do that, the current value of textarea will be read into var text and search/replaced
            // and written back into the textarea. utf-8 encoding/decoding happens in php, before saving into db.
            // get the value of summernote textarea
            var text = $(editor).val();
            // search for <img> tags and revert src ../ to set correct path for frontend
            var frontend = text.replace(/<img src=\"..\/media/g,"<img src=\"media");
            // put the new string back into <textarea>
            $(editor).val(frontend); // to make sure that saving works
        });

        // BEFORE SUMMERNOTE loads: 3 important lines of code!
        // to display images in backend correctly, we need to change the path of every image.
        // procedure is the same as above (see #savebutton.click)
        // get the value of summernote textarea
        var text = $(editor).val();
        // search for <img> tags and update src ../ to get images viewed in summernote
        var backend = text.replace(/<img src=\"media/g,"<img src=\"../media");
        // put the new string back into <textarea>
        $(editor).val(backend); // set new value into textarea

        // summernote.init -
        // LOAD SUMMERNOTE IN CODEVIEW ON STARTUP
        $(editor).on('summernote.init', function() {
            // toggle editor to codeview
            $(editor).summernote('codeview.toggle');
        });

        // INIT SUMMERNOTE EDITOR
        $(editor).summernote({    // set editor itself
            height: <?php echo $editorSettings['editorHeight']; ?>,                 // set editor height
            minHeight: null,             // set minimum height of editor
            maxHeight: null,             // set maximum height of editor
            focus: true,                 // set focus to editable area after initializing summernote
            toolbar: [
                // load an empty toolbar.
                // in that case: just a plain code editor. no mice cinema.
            ],
            // popover tooltips
            popover: {
                image: [
                    ['imagesize', ['imageSize100', 'imageSize50', 'imageSize25']],
                    /* ['float', ['floatLeft', 'floatRight', 'floatNone']], // those are the old regular float buttons */
                    ['floatBS', ['floatBSLeft', 'floatBSNone', 'floatBSRight']],    // bootstrap class buttons (float/pull)
                    ['custom', ['imageAttributes', 'imageShape']], // forked plugin: image-attributes.js
                    ['remove', ['removeMedia']]
                ]
            },
            // language for plugin image-attributes.js
            lang: '<?php echo $lang['CURRENT_LANGUAGE']; ?>',

            // powerup the codeview with codemirror theme
            codemirror: { // codemirror options
                theme: '<?php echo $editorSettings['editorTheme']; ?>',                       // codeview theme
                lineNumbers: true,             // display lineNumbers true|false
                undoDepth: <?php echo $editorSettings['editorUndoDepth']; ?>,                 // how many undo steps should be saved? (default: 200)
                smartIndent: <?php echo $editorSettings['editorSmartIndent']; ?>,             // better indent
                indentUnit: <?php echo $editorSettings['editorIndentUnit']; ?>,               // how many spaces auto indent? (default: 2)
                scrollbarStyle: null,                                                         // styling of the scrollbars
                matchBrackets: <?php echo $editorSettings['editorMatchBrackets']; ?>,         // highlight corresponding brackets
                autoCloseBrackets: <?php echo $editorSettings['editorCloseBrackets'];?>,      // auto insert close brackets
                autoCloseTags: <?php echo $editorSettings['editorCloseTags']; ?>,             // auto insert close tags after opening
                value: "<html>\n  " + document.documentElement.innerHTML + "\n</html>",       // all html
                mode: "css",                                                            // editor mode
                matchTags: {bothTags: <?php echo $editorSettings['editorMatchTags']; ?>},     // hightlight matching tags: both
                extraKeys: {
                        "Ctrl-J": "toMatchingTag",                  // CTRL-J to jump to next matching tab
                        "Ctrl-Space": "autocomplete"               // CTRL-SPACE to open autocomplete window
                },
                styleActiveLine: <?php echo $editorSettings['editorActiveLine']; ?>,           // highlight the active line (where the cursor is)
                autoRefresh: true
            },



            // plugin: summernote-cleaner.js
            // this allows to copy/paste from word, browsers etc.
            cleaner: { // does the job well: no messy code anymore!
                action: 'both', // both|button|paste 'button' only cleans via toolbar button, 'paste' only clean when pasting content, both does both options.
                newline: '<br>' // Summernote's default is to use '<p><br></p>'

                // silent mode:
                // from my pov it is not necessary to notify the user about the code cleaning process.
                // it throws just a useless, annoying bubble everytime you hit the save button.
                // BUT: if you need this notification, you can enable it by uncommenting the following 3 lines
                // notTime:2400,                                            // Time to display notifications.
                // notStyle:'position:absolute;bottom:0;left:2px',          // Position of notification
                // icon:'<i class="note-icon">[Your Button]</i>'            // Display an icon
            }
        }); // end summernote

    }); // end document ready
</script>
<?php
    // new template object if not exists
    if (!isset($template)) { $template = new \YAWK\template(); }
    // new user object if not exists
    if (!isset($user)) { $user = new \YAWK\user(); }
    // $_GET['id'] or $_POST['id'] holds the template ID to edit.
    // If any one of these two is set, we're in "preview mode" - this means:
    // The user database holds two extra cols: overrideTemplate(int|0,1) and templateID
    // Any user who is allowed to override the Template, can edit a template and view it
    // in the frontend. -Without affecting the current active theme for any other user.
    // This is pretty cool when working on a new design: because you see changes, while others wont.
    // In theory, thereby every user can have a different frontend template activated.


    // OVERRIDE TEMPLATE
    // check if call comes from template-manage or template-edit form
    if (isset($_GET['id']) && (is_numeric($_GET['id']) || (isset($_POST['id']) && (is_numeric($_POST['id'])))))
    {
        if (empty($_GET['id']) || (!empty($_POST['id']))) { $getID = $_POST['id']; }
        else if (!empty($_GET['id']) || (empty($_POST['id']))) { $getID = $_GET['id']; }
        else { $getID = \YAWK\settings::getSetting($db, "selectedTemplate");  }

        if ($user->isTemplateEqual($db, $getID))
        {   // user template equals selectedTemplate
            // update template in user table row
            $user->setUserTemplate($db, 0, $getID, $user->id);
            $user->overrideTemplate = 0;
            // info badge to inform user that this is HIS preview
            $infoBadge = "<span class=\"label label-success\"><i class=\"fa fa-check\"></i>&nbsp;&nbsp;$lang[VISIBLE_TO_EVERYONE]</span>";
            // info button on top
            $previewButton = "";
        }
        else
            {   // show preview button and set template active for this user
                $user->setUserTemplate($db, 1, $getID, $user->id);
                $user->overrideTemplate = 1;
                // info badge to inform user that this is HIS preview
                $infoBadge = "<span class=\"label label-danger\"><i class=\"fa fa-eye\"></i>&nbsp;&nbsp;$lang[PREVIEW]</span>";
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
    }


$newID = '';
$getID = '';
// SAVE AS new theme
if(isset($_POST['savenewtheme']) && isset($_POST['newthemename']))
{   // prepare vars
    $template->name = $db->quote($_POST['newthemename']);
    // get new template id
    $oldTemplateId = $template->id;
    $newID = \YAWK\template::getMaxId($db);
   //  \YAWK\alert::draw("warning", "error", "old ID: $oldTemplateId new ID: $newID", "", 50000);
   //  exit;
    $newTplId = $newID++;
    $template->id = $newTplId;
    // set new theme active
    $user->setUserTemplate($db, 1, $newID, $user->id);
    $user->overrideTemplate = 1;
    //\YAWK\settings::setSetting($db, "selectedTemplate", $newID);

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
        $template->positions = "outerTop:outerLeft:outerRight:intro:globalmenu:top:leftMenu:mainTop:mainTopLeft:mainTopCenter:mainTopRight:main:mainBottom:mainBottomLeft:mainBottomCenter:mainBottomRight:mainFooter:mainFooterLeft:mainFooterCenter:mainFooterRight:rightMenu:bottom:footer:hiddentoolbar:debug:outerBottom";
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

    if (isset($_POST['Tdescription']) || isset($_POST['Tsubauthor']) || isset($_POST['Tsubauthorurl']))
    {   // save template details
        // $template->setTemplateDetails($db, $_POST['Tdescription'], $_POST['Tsubauthor'], $_POST['Tsubauthorurl'], $template->id);
    }

    // get max ID from template db
    // SAVE DATA
    foreach($_POST as $property=>$value)
    {
        if (fnmatch('*-longValue', $property)) {
            $longValue = 1;
        }
        else
        {
            $longValue = 0;
        }

        if (isset($_POST['savenewtheme']))
        {
            if($property != "save" && $property != "customCSS")
            {   // save new theme settings to database
                $template->setTemplateSetting($db, $newID, $property, $value, $longValue);
            }
            // if save property is customCSS
            elseif ($property === "customCSS")
            {   // save the content to /system/template/$NAME/css/custom.css
                $template->setCustomCssFile($db, $value, 0, $getID);
                // save a minified version to /system/template/$NAME/css/custom.min.css
                $template->setCustomCssFile($db, $value, 1, $getID);
            }
        }
        else
        {
            if ($property != "save" && $property != "customCSS")
            {
                // PREVIEW VAR
                if (isset($_POST['getID']))
                {
                    $template->id = $_POST['getID'];
                }

                // save theme settings to database
                $template->setTemplateSetting($db, $template->id, $property, $value, $longValue);
            }
            // if save property is customCSS
            elseif ($property == "customCSS")
            {   // save the content to /system/template/$NAME/css/custom.css
                $template->setCustomCssFile($db, $value, 0, $getID);
                // save a minified version to /system/template/$NAME/css/custom.min.css
                $template->setCustomCssFile($db, $value, 1, $getID);
            }
        }
    }
    ////////////////////////////////////////////////////////////////////////////////////////

    $tplSettings = YAWK\template::getTemplateSettingsArray($db, $getID);

    // get HEADER FONT from db
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
        background-size: ".$tplSettings['body-bg-attachment'].";
        
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
      font-size: ".$tplSettings['form-fontSize'].";
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
        background-size: ".$tplSettings['pos-outerTop-bg-attachment'].";
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
        background-size: ".$tplSettings['pos-intro-bg-attachment'].";
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
        background-size: ".$tplSettings['pos-globalmenu-attachment'].";
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
        background-size: ".$tplSettings['pos-top-attachment'].";
        ".$tplSettings['pos-top-bg-gradient-longValue']."
        ".$tplSettings['pos-top-customCSS-longValue']."
        background: ".$tplSettings['pos-customCSS-bgnone'].";
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
        background-size: ".$tplSettings['pos-outerLeft-attachment'].";
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
        background-size: ".$tplSettings['pos-outerRight-attachment'].";
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
        background-size: ".$tplSettings['pos-leftMenu-attachment'].";
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
        background-size: ".$tplSettings['pos-rightMenu-attachment'].";
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
        background-size: ".$tplSettings['pos-mainTop-attachment'].";
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
        background-size: ".$tplSettings['pos-mainTopLeft-attachment'].";
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
        background-size: ".$tplSettings['pos-mainTopCenter-attachment'].";
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
        background-size: ".$tplSettings['pos-mainTopRight-attachment'].";
        ".$tplSettings['pos-mainTopRight-bg-gradient-longValue']."
        ".$tplSettings['pos-mainTopRight-customCSS-longValue']."
        background: ".$tplSettings['pos-mainTopRight-bgnone'].";
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
        width: ".$tplSettings['pos-main-width'].";
        height: ".$tplSettings['pos-main-height'].";
        z-index: ".$tplSettings['pos-main-zindex'].";
        /* BACKGROUND IMAGE */
        background-image: url('".$tplSettings['pos-main-bg-image']."');
        background-repeat:".$tplSettings['pos-main-bg-repeat'].";
        background-position:".$tplSettings['pos-main-bg-position'].";
        background-attachment:".$tplSettings['pos-main-bg-attachment'].";
        background-size: ".$tplSettings['pos-main-attachment'].";
        ".$tplSettings['pos-main-bg-gradient-longValue']."
        ".$tplSettings['pos-main-customCSS-longValue']."
        background: ".$tplSettings['pos-main-bgnone'].";
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
        background-size: ".$tplSettings['pos-mainBottom-attachment'].";
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
        background-size: ".$tplSettings['pos-mainBottomLeft-attachment'].";
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
        background-size: ".$tplSettings['pos-mainBottomCenter-attachment'].";
        ".$tplSettings['pos-mainBottomCenter-bg-gradient-longValue']."
        ".$tplSettings['pos-mainBottomCenter-customCSS-longValue']."
        background: ".$tplSettings['pos-customCSS-bgnone'].";    
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
        background-size: ".$tplSettings['pos-mainBottomRight-attachment'].";
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
        background-size: ".$tplSettings['pos-mainFooter-attachment'].";
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
        background-size: ".$tplSettings['pos-mainFooterLeft-attachment'].";
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
        background-size: ".$tplSettings['pos-mainFooterCenter-attachment'].";
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
        background-size: ".$tplSettings['pos-mainFooterRight-attachment'].";
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
        background-size: ".$tplSettings['pos-footer-attachment'].";
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
        background-size: ".$tplSettings['pos-hiddenToolbar-attachment'].";
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
        background-size: ".$tplSettings['pos-debug-attachment'].";
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
        background-size: ".$tplSettings['pos-outerBottom-attachment'].";
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
        $template->deleteGfont($db, $gfontid);
    }
}

if (isset($_POST['savenewtheme']))
{
    \YAWK\sys::setTimeout("index.php?page=template-manage", 0);
}

// INIT template ID
if (isset($_GET['id']) && (is_numeric($_GET['id'])))
{   // if id is set
    $template->id = $_GET['id'];
}
else
{
    if (isset($_POST['getID']))
    {
        $template->id = $_POST['getID'];
    }
    // load current template id
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
            <li><a href=\"index.php\" title=\"$lang[DASHBOARD]\"><i class=\"fa fa-dashboard\"></i> $lang[DASHBOARD]</a></li>
            <li><a href=\"index.php?page=template-manage\" title=\"$lang[TPL_MANAGER]\"> $lang[TPL_MANAGER]</a></li>
            <li><a href=\"index.php?page=template-edit&id=$template->id\" class=\"active\" title=\"$lang[TPL_EDIT]\">$template->name</a></li>
        </ol></section>
    <!-- Main content -->
    <section class=\"content\">";
/* page content start here */
?>

<?php
    if (isset($_GET['id']))
    {
        $getID = $_GET['id'];
    }
    else
        {
            $getID = "";
        }
?>

<?php
if (isset($_GET['overrideTemplate']) && ($_GET['overrideTemplate']) === "1")
{
    if (!isset($newID))
    {
        if (!isset($newTplId))
        {
            $id = $_GET['id'];
        }
        else
            {
                $id = $newTplId;
            }
    }
    else
        {
            $id = $newID;
        }
    $overrideTemplate = "overrideTemplate=1";
}
else
    {
        $overrideTemplate = "";
        $id = $template->id;
    }

?>
<div class="box box-default">
    <div class="box-body">

<form id="template-edit-form" action="index.php?page=template-edit&<?php echo $overrideTemplate; ?>id=<?php echo $template->id; ?>" method="POST">
    <input type="hidden" name="getID" value="<?php echo $getID; ?>">
    <!-- <div class="nav-tabs-custom"> <!-- admin LTE tab style -->
    <div id="btn-wrapper" class="text-right">
    <?php echo $previewButton; ?>

        <button type="submit" id="savebutton" name="save" class="btn btn-success">
            <i id="savebuttonIcon" class="fa fa-check"></i> &nbsp;<?php print $lang['DESIGN_SAVE']; ?>
        </button>
       <!-- <input id="savebutton" type="submit" class="btn btn-success" name="save" value="<?php // echo $lang['DESIGN_SAVE']; ?>"> -->
    </div>
    <!-- FORM -->
    <!-- Nav tabs -->
    <ul class="nav nav-tabs" id="tabs" role="tablist">
        <li role="presentation" class="active">
            <a href="#overview" aria-controls="overview" role="tab" data-toggle="tab"><i class="fa fa-home"></i>
                &nbsp;<?php echo $template->name; ?></a>
        </li>
        <li role="presentation">
            <a href="#positions" aria-controls="positions" role="tab" data-toggle="tab"><i class="fa fa-code"></i>
                &nbsp; <?php echo $lang['POSITIONS']; ?></a>
        </li>
        <li role="presentation">
            <a href="#fonts" aria-controls="fonts" role="tab" data-toggle="tab"><i class="fa fa-font"></i>
                &nbsp; <?php echo $lang['TYPOGRAPHY']; ?></a>
        </li>
        <!--
        <li role="presentation">
            <a href="#typo" aria-controls="typo" role="tab" data-toggle="tab"><i class="fa fa-text-width"></i>
                &nbsp; <?php // echo $lang['TYPOGRAPHY']; ?></a>
        </li>
        <li role="presentation">
            <a href="#body" aria-controls="body" role="tab" data-toggle="tab"><i class="fa fa-object-group"></i>
                &nbsp; <?php // echo $lang['BODY']; ?></a>
        </li>

        -->
      <!--  <li role="presentation"><a href="#colors" aria-controls="colors" role="tab" data-toggle="tab"><i class="fa fa-paint-brush"></i>&nbsp; Colors</a></li> -->
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
                &nbsp; <?php echo $lang['FORM']; ?></a>
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
            <a href="#themes" aria-controls="themes" role="tab" data-toggle="tab"><i class="fa fa-adjust"></i>
                &nbsp; <?php echo $lang['THEME']; ?></a>
        </li>
        <li role="presentation">
            <a href="#settings" aria-controls="settings" role="tab" data-toggle="tab"><i class="fa fa-wrench"></i>
                &nbsp; <?php echo $lang['SETTINGS']; ?></a>
        </li>
    </ul>

    <!-- Tab panes -->
    <div class="tab-content">
        <!-- OVERVIEW -->
        <div role="tabpanel" class="tab-pane active" id="overview">
            <h3><?php echo "$lang[OVERVIEW] <small>$lang[TPL] $lang[SUMMARY]</small>"; ?></h3>
            <!-- list TEMPLATE HOME PAGE (DETAILS) -->
            <div class="row animated fadeIn">
                <div class="col-md-6">
                    <div class="box">
                        <div class="box-header with-border">
                            <h3 class="box-title"><?php echo "$lang[DETAILS] <small>$lang[OF_CURRENT_ACTIVE_THEME]"; ?></small></h3>
                        </div>
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
                            if (isset($template->modifyDate) && ($template->modifyDate !== "0000-00-00 00:00:00"))
                            {   // set modifyDate
                                $modifyDate = "<dt>$lang[MODIFIED]</dt><dd>$template->modifyDate</dd>";
                            }
                            else { $modifyDate = ''; }

                            // releaseDate
                            if (isset($template->releaseDate) && ($template->releaseDate !== "0000-00-00 00:00:00"))
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

                            // subAuthor
                            if (isset($template->license) && (!empty($template->license)))
                            {   // set subAuthor
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

                            <?php echo $description.$author.$weblink.$license.$version.$releaseDate.$settings."<br>".$subauthor.$modifyDate; ?>

                            <dt>&nbsp;</dt>
                            <dd>&nbsp;</dd>
                            <dt><?php echo $lang['TOOLS']; ?></dt>
                            <dd>
                                <b><?php echo $lang['YAWK_SLOGAN_TOGETHER']; ?><br>
                                <i class="fa fa-check text-light-blue"></i> YaWK 16.9 <small>
                                <a href="http://www.yawk.io/" target="_blank" title="Official YaWK Website [in new tab]">
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

                    <!-- website preview iframe
                    <div class="embed-responsive embed-responsive-4by3">
                        <iframe id="preview" class="embed-responsive-item" src="../index.php"></iframe>
                    </div>
 -->
                </div>
            </div>
        </div>
        <?php
            // GET ALL TEMPLATE SETTINGS INTO ARRAY
            $templateSettings = \YAWK\template::getAllSettingsIntoArray($db, $user);
        ?>

        <!-- POSITIONS -->
        <div role="tabpanel" class="tab-pane" id="positions">
            <h3><?php echo "$lang[POSITIONS]"; ?> <small><?php echo "$lang[TPL_POSITION_SETTINGS]"; ?></small></h3>
            <!-- list POSITION SETTINGS -->
            <div class="row animated fadeIn">

                <div class="col-md-3">
                    <div class="box box-with-border" id="posboxSettings">
                        <div class="box-body">
                            <div id="selectPositionRequestInfo">
                                <h4 class="box-title"><?php echo "$lang[TPL_SELECT_POSITIONS_REQUEST]"; ?></h4>
                            </div>
                            <!-- settings outerTop -->
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
                            <div id="settings_pos_main">
                                <?php $template->getFormElements($db, $templateSettings, 38, $lang, $user); ?>
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
                        <div class="box-header">
                            <h3 class="box-title"><?php echo "$lang[POSITIONS] <small>$lang[SETTINGS]</small>"; ?></h3>
                        </div>

                        <?php
                        $enabledBorder = "border: 1px solid #4CAE4C;";
                        $disabledBorder = "border: 1px dashed #ccc;";

                        if ($templateSettings['pos-outerTop-enabled']['value'] === "1")
                        {   $outerTopEnabled = $enabledBorder; }
                        else
                        {   $outerTopEnabled = $disabledBorder; }

                        if ($templateSettings['pos-intro-enabled']['value'] === "1")
                        {   $introEnabled = $enabledBorder; }
                        else
                        {   $introEnabled = $disabledBorder; }

                        if ($templateSettings['pos-outerLeft-enabled']['value'] === "1")
                        {   $outerLeftEnabled = $enabledBorder; }
                        else
                        {   $outerLeftEnabled = $disabledBorder; }

                        if ($templateSettings['pos-globalmenu-enabled']['value'] === "1")
                        {   $globalmenuEnabled = $enabledBorder; }
                        else
                        {   $globalmenuEnabled = $disabledBorder; }

                        if ($templateSettings['pos-top-enabled']['value'] === "1")
                        {   $topEnabled = $enabledBorder; }
                        else
                        {   $topEnabled = $disabledBorder; }

                        if ($templateSettings['pos-leftMenu-enabled']['value'] === "1")
                        {   $leftMenuEnabled = $enabledBorder; }
                        else
                        {   $leftMenuEnabled = $disabledBorder; }

                        if ($templateSettings['pos-mainTop-enabled']['value'] === "1")
                        {   $mainTopEnabled = $enabledBorder; }
                        else
                        {   $mainTopEnabled = $disabledBorder; }

                        if ($templateSettings['pos-mainTopLeft-enabled']['value'] === "1")
                        {   $mainTopLeftEnabled = $enabledBorder; }
                        else
                        {   $mainTopLeftEnabled = $disabledBorder; }

                        if ($templateSettings['pos-mainTopCenter-enabled']['value'] === "1")
                        {   $mainTopCenterEnabled = $enabledBorder; }
                        else
                        {   $mainTopCenterEnabled = $disabledBorder; }

                        if ($templateSettings['pos-mainTopRight-enabled']['value'] === "1")
                        {   $mainTopRightEnabled = $enabledBorder; }
                        else
                        {   $mainTopRightEnabled = $disabledBorder; }

                        if ($templateSettings['pos-main-enabled']['value'] === "1")
                        {   $mainEnabled = $enabledBorder; }
                        else
                        {   $mainEnabled = $disabledBorder; }

                        if ($templateSettings['pos-mainBottom-enabled']['value'] === "1")
                        {   $mainBottomEnabled = $enabledBorder; }
                        else
                        {   $mainBottomEnabled = $disabledBorder; }

                        if ($templateSettings['pos-mainBottomLeft-enabled']['value'] === "1")
                        {   $mainBottomLeftEnabled = $enabledBorder; }
                        else
                        {   $mainBottomLeftEnabled = $disabledBorder; }

                        if ($templateSettings['pos-mainBottomCenter-enabled']['value'] === "1")
                        {   $mainBottomCenterEnabled = $enabledBorder; }
                        else
                        {   $mainBottomCenterEnabled = $disabledBorder; }

                        if ($templateSettings['pos-mainBottomRight-enabled']['value'] === "1")
                        {   $mainBottomRightEnabled = $enabledBorder; }
                        else
                        {   $mainBottomRightEnabled = $disabledBorder; }

                        if ($templateSettings['pos-mainFooter-enabled']['value'] === "1")
                        {   $mainFooterEnabled = $enabledBorder; }
                        else
                        {   $mainFooterEnabled = $disabledBorder; }

                        if ($templateSettings['pos-mainFooterLeft-enabled']['value'] === "1")
                        {   $mainFooterLeftEnabled = $enabledBorder; }
                        else
                        {   $mainFooterLeftEnabled = $disabledBorder; }

                        if ($templateSettings['pos-mainFooterCenter-enabled']['value'] === "1")
                        {   $mainFooterCenterEnabled = $enabledBorder; }
                        else
                        {   $mainFooterCenterEnabled = $disabledBorder; }

                        if ($templateSettings['pos-mainFooterRight-enabled']['value'] === "1")
                        {   $mainFooterRightEnabled = $enabledBorder; }
                        else
                        {   $mainFooterRightEnabled = $disabledBorder; }

                        if ($templateSettings['pos-rightMenu-enabled']['value'] === "1")
                        {   $rightMenuEnabled = $enabledBorder; }
                        else
                        {   $rightMenuEnabled = $disabledBorder; }

                        if ($templateSettings['pos-footer-enabled']['value'] === "1")
                        {   $footerEnabled = $enabledBorder; }
                        else
                        {   $footerEnabled = $disabledBorder; }

                        if ($templateSettings['pos-hiddenToolbar-enabled']['value'] === "1")
                        {   $hiddenToolbarEnabled = $enabledBorder; }
                        else
                        {   $hiddenToolbarEnabled = $disabledBorder; }

                        if ($templateSettings['pos-debug-enabled']['value'] === "1")
                        {   $debugEnabled = $enabledBorder; }
                        else
                        {   $debugEnabled = $disabledBorder; }

                        if ($templateSettings['pos-outerRight-enabled']['value'] === "1")
                        {   $outerRightEnabled = $enabledBorder; }
                        else
                        {   $outerRightEnabled = $disabledBorder; }

                        if ($templateSettings['pos-outerBottom-enabled']['value'] === "1")
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
                                $(pos_main).removeClass("posboxActive").toggleClass("posbox");
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
                                $(settings_pos_main).hide();
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
                                                    <div onclick="switchPosition('pos_main')" class="col-md-12 posbox" id="pos_main" style="height: 200px; margin-bottom:5px; text-align: center; <?php echo $mainEnabled; ?>">&laquo;main&raquo;</div>
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
        </div>

        <!-- FONTS -->
        <div role="tabpanel" class="tab-pane" id="fonts">
            <h3><?php echo "$lang[FONTS_TYPES] <small>$lang[TPL_FONTS_SUBTEXT]"; ?></small></h3>
            <div class="row">
                <div class="col-md-6">

                    <label for="testText"><?php echo $lang['TPL_FORM_TESTFIELD']; ?></label>
                    <div class="input-group">
                        <!-- <div class="input-group-addon" id="switchPreview" style="cursor: pointer;"><i class="fa fa-link" title="switch preview"></i></div> -->
                        <input id="testText" name="testText" placeholder="<?php echo $lang['TPL_FORM_TESTFIELD_PLACEHOLDER']; ?>" maxlength="84" class="form-control">
                        <span class="input-group-btn">
                        <button type="button" disabled id="resetTestText" class="btn btn-default" title="<?php echo $lang['RESET']; ?>"><i class="fa fa-refresh"></i></button>
                        </span>
                 </div>
                    <!-- common text settings (size, shadow, color...) -->
                    <?php // $template->getFormElements($db, $templateSettings, 2, $lang, $user); ?>
                    <?php // $template->getFormElements($db, $templateSettings, 3, $lang, $user); ?>
                </div>
                <div class="col-md-6">
                    <!-- ... -->
                </div>
            </div>
            <hr>
            <div class="row animated fadeIn">
            <?php
                $template->getFontRow($db, $lang, "h1", "h1", $templateSettings);
                $template->getFontRow($db, $lang, "h2", "h2", $templateSettings);
                $template->getFontRow($db, $lang, "h3", "h3", $templateSettings);
                $template->getFontRow($db, $lang, "h4", "h4", $templateSettings);
                $template->getFontRow($db, $lang, "h5", "h5", $templateSettings);
                $template->getFontRow($db, $lang, "h6", "h6", $templateSettings);
            ?>
            </div>
            <hr>
            <div class="row">
                <?php
                $template->getFontRow($db, $lang, "globaltext", "globaltext", $templateSettings);
               // $template->getFontRow($db, $lang, "menufont", "menufont", $templateSettings);
                ?>
            </div>
            
            <script>
                $(document).ready(function () {

                    // TODO: THIS IS WAAAAYYYY NOT READY...!!
                    // switch preview from text to link
/*
                    $("#switchPreview").click(function() {
                        // alert('you flipped the switch!');
                        $("#h1-preview").replaceWith( "<div class=\"h1\" id=\"h1-preview\"><a href=\"#\">H1 Heading (link)</div>");
                        // $("#h1-preview").css("text-decoration", "underline");
                    });
*/
                    // call set default values and preview font function
                    previewFont($("#h1-fontfamily"), 'H1 Heading', 'h1-preview', $("#h1-preview"), $("#h1-size"), $("#h1-fontcolor"), $("#h1-fontshadowsize"), $("#h1-fontshadowcolor"), $("#h1-fontweight"), $("#h1-fontstyle"), $("#h1-textdecoration"));
                    previewFont($("#h2-fontfamily"), 'H2 Heading', 'h2-preview', $("#h2-preview"), $("#h2-size"), $("#h2-fontcolor"), $("#h2-fontshadowsize"), $("#h2-fontshadowcolor"), $("#h2-fontweight"), $("#h2-fontstyle"), $("#h2-textdecoration"));
                    previewFont($("#h3-fontfamily"), 'H3 Heading', 'h3-preview', $("#h3-preview"), $("#h3-size"), $("#h3-fontcolor"), $("#h3-fontshadowsize"), $("#h3-fontshadowcolor"), $("#h3-fontweight"), $("#h3-fontstyle"), $("#h3-textdecoration"));
                    previewFont($("#h4-fontfamily"), 'H4 Heading', 'h4-preview', $("#h4-preview"), $("#h4-size"), $("#h4-fontcolor"), $("#h4-fontshadowsize"), $("#h4-fontshadowcolor"), $("#h4-fontweight"), $("#h4-fontstyle"), $("#h4-textdecoration"));
                    previewFont($("#h5-fontfamily"), 'H5 Heading', 'h5-preview', $("#h5-preview"), $("#h5-size"), $("#h5-fontcolor"), $("#h5-fontshadowsize"), $("#h5-fontshadowcolor"), $("#h5-fontweight"), $("#h5-fontstyle"), $("#h5-textdecoration"));
                    previewFont($("#h6-fontfamily"), 'H6 Heading', 'h6-preview', $("#h6-preview"), $("#h6-size"), $("#h6-fontcolor"), $("#h6-fontshadowsize"), $("#h6-fontshadowcolor"), $("#h6-fontweight"), $("#h6-fontstyle"), $("#h6-textdecoration"));
                    previewFont($("#globaltext-fontfamily"), 'Default Text', 'globaltext-preview', $("#globaltext-preview"), $("#globaltext-size"), $("#globaltext-fontcolor"), $("#globaltext-fontshadowsize"), $("#globaltext-fontshadowcolor"), $("#globaltext-fontweight"), $("#globaltext-fontstyle"), $("#globaltext-textdecoration"));

                    /*
                     * obj font-family select field
                     * string heading
                     * string preview field as string
                     * obj h1-preview
                     * obj h1-size
                     * obj h1-color
                     * obj h1-fontshadowsize
                     * obj h1-fontshadowcolor
                     */
                    function previewFont(font, heading, previewString, previewField, fontsize, fontcolor, fontshadowsize, fontshadowcolor, fontweight, fontstyle, textdecoration)
                    {
                        // what to do if click on reset text button
                        $("#resetTestText").click(function()
                        {   // reset preview: set default value
                            $(previewField).html(heading);
                            // empty the input field also
                            $("#testText").val('');
                            // and disable button
                            $('#resetTestText').prop('disabled', true); // enable reset btn if key up on testText field
                        });

                        // if test text changes due input via keyup
                        $('#testText').keyup(function(){
                            // enable reset text button
                            $('#resetTestText').prop('disabled', false);
                            // update text preview with values from testText field
                            $(previewField).html($(this).val());
                        });

                        // LOAD DEFAULT (CURRENT) PREVIEW
                        // SET DEFAULT VALUES
                        var selectedFont = $(font).val();
                        var pathAndFont = '../system/fonts/'+selectedFont;

                        // check if font is a custom font (from system/fonts)
                        // check if fontfamily contains the string ttf
                        if ($(font).val().toLowerCase().indexOf("-ttf") >= 0)
                        {
                            // workaround: remove the last 4 chars (-ttf)
                            var fn = pathAndFont.slice(0,-4);
                            // workaround: add file extension
                            fn += '.ttf';

                            // append external font to head
                            $("head").append("<style type=\"text/css\">" +
                                "@font-face {\n" +
                                "\tfont-family: '"+selectedFont+"';\n" +
                                "\tsrc: url("+fn+");\n" +
                                "}\n" +
                                "\t."+previewString+" {\n" +
                                "\tfont-family: '"+selectedFont+"' !important;\n" +
                                "}\n" +
                                "</style>");
                            // set preview to selected true type font
                            $(previewField).css("font-family", selectedFont);
                        }
                        // check if fontfamily contains the string otf
                        else if ($(font).val().toLowerCase().indexOf("-otf") >= 0)
                        {
                            // workaround: remove the last 4 chars (-otf)
                            fn = pathAndFont.slice(0,-4);
                            // workaround: add file extension
                            fn += '.otf';

                            // append external font to head
                            $("head").append("<style type=\"text/css\">" +
                                "@font-face {\n" +
                                "\tfont-family: '"+selectedFont+"';\n" +
                                "\tsrc: url("+fn+");\n" +
                                "}\n" +
                                "\t."+previewString+" {\n" +
                                "\tfont-family: '"+selectedFont+"' !important;\n" +
                                "}\n" +
                                "</style>");
                            // set preview to selected true type font
                            $(previewField).css("font-family", selectedFont);
                        }
                        // check if fontfamily contains the string otf
                        else if ($(font).val().toLowerCase().indexOf("-woff") >= 0)
                        {
                            // workaround: remove the last 5 chars (-woff)
                            fn = pathAndFont.slice(0,-5);
                            // workaround: add file extension
                            fn += '.woff';

                            // append external font to head
                            $("head").append("<style type=\"text/css\">" +
                                "@font-face {\n" +
                                "\tfont-family: '"+selectedFont+"';\n" +
                                "\tsrc: url("+fn+");\n" +
                                "}\n" +
                                "\t."+previewString+" {\n" +
                                "\tfont-family: '"+selectedFont+"' !important;\n" +
                                "}\n" +
                                "</style>");
                            // set preview to selected true type font
                            $(previewField).css("font-family", selectedFont);
                        }
                        // check if fontfamily contains the string -gfon
                        else if ($(font).val().toLowerCase().indexOf("-gfont") >= 0)
                        {
                            // workaround: remove the last 6 chars (-gfont)
                            fn = selectedFont.slice(0,-6);

                            var HtmlDocumentHead = $("head");
                            // append google font include to head
                            HtmlDocumentHead.append("<link href=\"https://fonts.googleapis.com/css?family="+fn+"\" rel=\"stylesheet\">");
                            // append external font to head
                            HtmlDocumentHead.append("<style type=\"text/css\">" +
                                "\t."+previewString+" {\n" +
                                "\tfont-family: '"+fn+"';\n" +
                                "}\n" +
                                "</style>");
                            // set preview to selected true type font
                            $(previewField).css("font-family", fn);
                        }
                        else
                        {    //alert('no ttf');
                            $(previewField).css("font-family", $(font).val());
                        }
                        $(previewField).css("font-size", $(fontsize).val());
                        $(previewField).css("color", '#'+$(fontcolor).val());
                        $(previewField).css("text-shadow", $(fontshadowsize).val()+' #'+$(fontshadowcolor).val());
                        $(previewField).css("font-weight", $(fontweight).val());
                        $(previewField).css("font-style", $(fontstyle).val());
                        $(previewField).css("text-decoration", $(textdecoration).val());

                        // SET SELECTED FONT STYLES ON CHANGE...
                        // check if a font is selected, on change of select field...
                        $(font).change(function()
                        {
                            var selectedFont = $(font).val();
                            var pathAndFont = '../system/fonts/'+selectedFont;
                            var fn = '';

                            // check if font is a custom font (from system/fonts)
                            // check if fontfamily contains the string ttf
                            if ($(font).val().toLowerCase().indexOf("-ttf") >= 0)
                            {
                                // workaround: remove the last 4 chars (-ttf)
                                fn = pathAndFont.slice(0,-4);
                                // workaround: add file extension
                                fn += '.ttf';

                                // append external font to head
                                $("head").append("<style type=\"text/css\">" +
                                    "@font-face {\n" +
                                    "\tfont-family: '"+selectedFont+"';\n" +
                                    "\tsrc: url("+fn+");\n" +
                                    "}\n" +
                                    "\t."+previewString+" {\n" +
                                    "\tfont-family: '"+selectedFont+"' !important;\n" +
                                    "}\n" +
                                    "</style>");
                                // set preview to selected true type font
                                $(previewField).css("font-family", selectedFont);
                            }
                            // check if fontfamily contains the string otf
                            else if ($(font).val().toLowerCase().indexOf("-otf") >= 0)
                            {
                                // workaround: remove the last 4 chars (-otf)
                                fn = pathAndFont.slice(0,-4);
                                // workaround: add file extension
                                fn += '.otf';

                                // append external font to head
                                $("head").append("<style type=\"text/css\">" +
                                    "@font-face {\n" +
                                    "\tfont-family: '"+selectedFont+"';\n" +
                                    "\tsrc: url("+fn+");\n" +
                                    "}\n" +
                                    "\t."+previewString+" {\n" +
                                    "\tfont-family: '"+selectedFont+"' !important;\n" +
                                    "}\n" +
                                    "</style>");
                                // set preview to selected true type font
                                $(previewField).css("font-family", selectedFont);
                            }
                            // check if fontfamily contains the string otf
                            else if ($(font).val().toLowerCase().indexOf("-woff") >= 0)
                            {
                                // workaround: remove the last 5 chars (-otf)
                                fn = pathAndFont.slice(0,-5);
                                // workaround: add file extension
                                fn += '.woff';

                                // append external font to head
                                $("head").append("<style type=\"text/css\">" +
                                    "@font-face {\n" +
                                    "\tfont-family: '"+selectedFont+"';\n" +
                                    "\tsrc: url("+fn+");\n" +
                                    "}\n" +
                                    "\t."+previewString+" {\n" +
                                    "\tfont-family: '"+selectedFont+"' !important;\n" +
                                    "}\n" +
                                    "</style>");
                                // set preview to selected true type font
                                $(previewField).css("font-family", selectedFont);
                            }
                            // check if fontfamily contains the string -gfon
                            else if ($(font).val().toLowerCase().indexOf("-gfont") >= 0)
                            {
                                // workaround: remove the last 5 chars (-gfon)
                                fn = selectedFont.slice(0,-6);
                                googlePath = "https://fonts.googleapis.com/css?family="+fn;

                                var HtmlDocumentHead = $("head");
                                // append google font include to head
                                HtmlDocumentHead.append("<link href=\"https://fonts.googleapis.com/css?family="+fn+"\" rel=\"stylesheet\">");
                                // append external font to head
                                HtmlDocumentHead.append("<style type=\"text/css\">" +
                                    "\t."+previewString+" {\n" +
                                    "\tfont-family: '"+fn+"';\n" +
                                    "}\n" +
                                    "</style>");
                                // set preview to selected true type font
                                $(previewField).css("font-family", fn);
                            }
                            else
                            {    //alert('no ttf');
                                $(previewField).css("font-family", $(font).val());
                            }
                        });

                        // do the rest of the font preview stuff: size, colors, shadow...
                        // switch font size
                        $(fontsize).keyup(function() {
                            $(previewField).css("font-size", $(fontsize).val());
                        });
                        // switch font color
                        $(fontcolor).change(function() {
                            $(previewField).css("color", '#'+$(fontcolor).val());
                        });
                        // switch shadow size
                        $(fontshadowsize).keyup(function() {
                            $(previewField).css("text-shadow", $(fontshadowsize).val()+' #'+$(fontshadowcolor).val());
                        });
                        // switch shadow color
                        $(fontshadowcolor).change(function() {
                            $(previewField).css("text-shadow", $(fontshadowsize).val()+' #'+$(fontshadowcolor).val());
                        });
                        // switch font weight
                        $(fontweight).change(function() {
                            $(previewField).css("font-weight", $(fontweight).val());
                        });
                        // switch font style
                        $(fontstyle).change(function() {
                            $(previewField).css("font-style", $(fontstyle).val());

                        });
                        // switch text decoration
                        $(textdecoration).change(function() {
                            $(previewField).css("text-decoration", $(textdecoration).val());

                        });
                    }

                });
            </script>
            <?php
            /*
            <!-- list GOOGLE FONTS -->
                <div class="row animated fadeIn">

                <div class="col-md-4">
                    <div class="box box-default">
                        <div class="box-header">
                            <h3 class="box-title"><?php echo "$lang[H1_H6] <small>$lang[FONT_TYPE]"; ?></small></h3>
                        </div>
                        <div class="box-body">
                            <?php $template->getgFonts($db, "heading-gfont", $lang); ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="box box-default">
                        <div class="box-header">
                            <h3 class="box-title"><?php echo "$lang[MENU] <small>$lang[FONT_TYPE]</small>"; ?></h3>
                        </div>
                        <div class="box-body">
                            <?php $template->getgFonts($db, "menu-gfont", $lang); ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="box box-default">
                        <div class="box-header">
                            <h3 class="box-title"><?php echo "$lang[TEXT] <small>$lang[FONT_TYPE]</small>"; ?></h3>
                        </div>
                        <div class="box-body">
                            <?php $template->getgFonts($db, "text-gfont", $lang); ?>
                        </div>
                    </div>
                </div>

            </div>
            */
            ?>

        </div>
        <?php
        /*
        <!-- TYPO -->
        <div role="tabpanel" class="tab-pane" id="typo">
            <h3><?php echo "$lang[TYPOGRAPHY] <small>$lang[SETTINGS]</small>"; ?></h3>
            <!-- typography styles -->
            <div class="row animated fadeIn">
                <div class="col-md-4">
                    <div class="box box-default">
                        <div class="box-header with-border">
                            <h3 class="box-title"><?php echo "$lang[TPL_GLOBALTEXT] <small>$lang[TPL_GLOBALTEXT_SUBTEXT]"; ?></small></h3>
                        </div>
                        <div class="box-body">
                            <!-- common text settings (size, shadow, color...) -->
                            <?php $template->getFormElements($db, $templateSettings, 2, $lang, $user); ?>
                        </div>
                    </div>

                    <div class="box box-default">
                        <div class="box-header with-border">
                            <h3 class="box-title"><?php echo "$lang[LINK] <small>$lang[COLORS]</small>"; ?></h3>
                        </div>
                        <div class="box-body">
                            <!-- link colors and settings (color, decoration, hover, btn text color...) -->
                            <?php $template->getFormElements($db, $templateSettings, 3, $lang, $user); ?>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="box box-default">
                        <div class="box-header with-border">
                            <h3 class="box-title"><?php echo "$lang[HEADINGS] <small>$lang[H1_H6_FONT_SIZE]</small>"; ?></h3>
                        </div>
                        <div class="box-body">
                            <!-- H1-H6 Text sizes (font size of headings in px or em) -->
                            <?php // $template->getFormElements($db, $templateSettings, 4, $lang, $user); ?>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="box box-default">
                        <div class="box-header">
                            <h3 class="box-title"><?php echo "$lang[HEADING] <small>$lang[COLORS]"; ?></small></h3>
                        </div>
                        <div class="box-body">
                            <!-- Font Colors (h1-h6 colors, smalltag, font, jumbotron + listgroup fontcolor) -->
                            <?php // $template->getFormElements($db, $templateSettings, 5, $lang, $user); ?>
                        </div>
                    </div>
                </div>
            </div>
         </div>

        <!-- BODY-->
        <div role="tabpanel" class="tab-pane" id="body">
            <h3><?php echo "$lang[BODY] <small>$lang[SETTINGS]</small>"; ?></h3>
            <!-- typography styles -->
            <div class="row animated fadeIn">
                <div class="col-md-4">
                    <div class="box box-default">
                        <div class="box-header">
                            <h3 class="box-title"><?php echo "$lang[BODY] <small>$lang[SETTINGS]</small>"; ?></h3>
                        </div>
                        <div class="box-body">
                            <!-- body bg color -->
                            <?php $template->getFormElements($db, $templateSettings, 6, $lang, $user); ?>
                        </div>
                    </div>

                    <div class="box box-default">
                        <div class="box-header">
                            <h3 class="box-title"><?php echo "$lang[BODY] <small>$lang[POSITIONING]</small>"; ?></h3>
                        </div>
                        <div class="box-body">
                            <!-- body margin -->
                            <?php $template->getFormElements($db, $templateSettings, 7, $lang, $user); ?>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="box box-default">
                        <div class="box-header">
                            <h3 class="box-title"><?php echo "$lang[BG_IMAGE] <small>$lang[SETTINGS]</small>"; ?></h3>
                        </div>
                        <div class="box-body">
                            <!-- body background image -->
                            <?php $template->getFormElements($db, $templateSettings, 8, $lang, $user); ?>
                        </div>
                    </div>

                    <div class="box box-default">
                        <div class="box-header">
                            <h3 class="box-title"><?php echo "$lang[TPL_MAIN_POS_SHADOW] <small>$lang[TPL_AROUND_POSITION]</small>"; ?></h3>
                        </div>
                        <div class="box-body">
                            <!-- main box shadow -->
                            <?php $template->getFormElements($db, $templateSettings, 9, $lang, $user); ?>
                        </div>
                    </div>


                </div>



                <div class="col-md-4">
                    <div class="box box-default">
                        <div class="box-header">
                            <h3 class="box-title">...<?php // echo "$lang[LIST_GROUP] <small>$lang[COLORS]</small>"; ?></h3>
                        </div>
                        <div class="box-body">
                            <?php // $template->getSetting($db, "%-listgroup", "", "", $user); ?>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        */
        ?>

        <!-- MENU -->
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
            <h3><?php echo "$lang[FORM] <small>$lang[AND] $lang[BUTTONS] </small>"; ?></h3>
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

        <!-- FX -->
        <!--
            <div role="tabpanel" class="tab-pane" id="effects">Kommen dann hier rein...
            </div>
        -->

        <!-- CUSTOM CSS -->
        <div role="tabpanel" class="tab-pane animated fadeIn" id="custom">
            <h3>Custom.CSS <small><?php echo $lang['TPL_CUSTOMCSS_SUBTEXT']; ?></small></h3>
            <div class="row">

                <div class="col-md-8">
                    <?php $customCSS = $template->getCustomCSSFile($db, $template->id); ?>
                    <textarea name="customCSS" cols="64" rows="28" id="summernote"><?php echo $customCSS; ?></textarea>

                    <label for="summernote"><small><?php echo $lang['YOU_EDIT']; ?>:</small> &nbsp;system/templates/<?php echo $template->name; ?>/css/custom.css</label>
                </div>
                <div class="col-md-4">
                    <div class="box box-default">
                        <div class="box-header with-border">
                            <h3 class="box-title"><?php echo $template->name; ?>/css/custom.css</h3>
                        </div>
                        <div class="box-body">
                            <?php echo $lang['CUSTOM_CSS_DESC']; ?>
                            <br><br>
                            <i><?php echo $lang['CUSTOM_CSS_HELP']; ?></i><br>
                            &raquo; <a href="http://www.w3schools.com/css/" title="open CSS overview in new TAB" target="_blank">w3schools.com/css/</a>

                            <hr>
                            <b><i class="fa fa-lightbulb-o"></i> <?php echo $lang['DID_YOU_KNOW']; ?></b><br>
                            <i><?php echo $lang['TIP_STRG_S']; ?></i>
                </div>

                    </div>
                </div>
            </div>
        </div>

        <!-- THEMES -->
        <div role="tabpanel" class="tab-pane" id="themes">
            <h3><?php echo "$lang[TPL] <small>$lang[SETTINGS]</small>"; ?></h3>
            <!-- list availalbe THEMES -->
            <div class="row animated fadeIn">
                <div class="col-md-4">
                    <div class="box box-default">
                        <div class="box-header with-border">
                            <h3 class="box-title"><?php echo "$lang[LOAD]"; ?> <small>Theme</small></h3>
                        </div>
                        <div class="box-body">
                            ...
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="box box-default">
                        <div class="box-header with-border">
                            <h3 class="box-title"><?php echo "$lang[TPL] $lang[DETAILS] <small>$lang[TPL_UPDATE_SUBTEXT]</small>"; ?></h3>
                        </div>
                        <div class="box-body">
                            <label for="Tname"><?php echo "$lang[TPL] $lang[NAME]"; ?></label>
                            <input type="text" class="form-control" id="Tname" name="Tname" value="<?php echo $template->name; ?>" placeholder="<?php echo "$lang[TEMPLATE] $lang[NAME]"; ?>" disabled>
                            <label for="Tauthor"><?php echo "$lang[TPL] $lang[AUTHOR]"; ?></label>
                            <input type="text" class="form-control" id="Tauthor" name="Tauthor" value="<?php echo $template->author; ?>" placeholder="<?php echo "$lang[TEMPLATE] $lang[AUTHOR]"; ?>" disabled>
                            <label for="Tversion"><?php echo "$lang[TPL] $lang[VERSION]"; ?></label>
                            <input type="text" class="form-control" id="Tversion" name="Tversion" value="<?php echo $template->version; ?>" placeholder="<?php echo "$lang[TEMPLATE] $lang[VERSION]"; ?>" disabled>
                            <label for="Treleasedate"><?php echo "$lang[TPL] $lang[RELEASE] $lang[DATE]"; ?></label>
                            <input type="text" class="form-control" id="Treleasedate" name="Treleasedate" value="<?php echo $template->releaseDate; ?>" placeholder="<?php echo "$lang[TEMPLATE] $lang[RELEASE] $lang[DATE]"; ?>" disabled>
                            <label for="Tlicenese"><?php echo "$lang[TPL] $lang[LICENSE]"; ?></label>
                            <select name="Tlicense" class="form-control" id="Tlicenese" disabled>
                                <option value="GNU General Public License (GPL)">GNU General Public License (GPL) </option>
                                <option value="GNU Lesser Public License (LGPL)">GNU Lesser Public License (LGPL)</option>
                                <option value="MIT License">MIT License</option>
                                <option value="Mozilla Public License 2.0">Mozilla Public License 2.0</option>
                                <option value="Apache License 2.0">Apache License 2.0</option>
                            </select>
                            <label for="Tdescription"><?php echo "$lang[TPL] $lang[DESCRIPTION]"; ?></label>
                            <textarea class="form-control" id="Tdescription" rows="5" cols="64" name="Tdescription" disabled aria-disabled="true"><?php echo $template->description; ?></textarea>
                            <label for="Tsubauthor"><?php echo "$lang[MODIFIED] $lang[BY]"; ?></label>
                            <input type="text" class="form-control" id="Tsubauthor" name="Tsubauthor" value="<?php echo $template->subAuthor; ?>" placeholder="<?php echo "$lang[MODIFIED] $lang[BY]"; ?>" disabled aria-disabled="true">
                            <label for="Tsubauthorurl"><?php echo "$lang[SUB_AUTHOR_URL]"; ?></label>
                            <input type="text" class="form-control" id="Tsubauthorurl" name="Tsubauthorurl" value="<?php echo $template->subAuthorUrl; ?>" placeholder="<?php echo "$lang[SUB_AUTHOR_URL]"; ?>" disabled aria-disabled="true">
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="box box-default">
                        <div class="box-header with-border">
                            <h3 class="box-title"><?php echo "$lang[SAVE_AS] <small>$lang[NEW_THEME]</small>"; ?></h3>
                        </div>
                        <div class="box-body">
                            <label for="savetheme"><?php echo "$lang[SAVE_NEW_THEME_AS]"; ?></label>
                            <input type="text" class="form-control" name="newthemename" value="<?php echo $template->name; ?>-copy" placeholder="<?php echo "$lang[NEW] $lang[TPL] $lang[NAME]"; ?>">
                            <input type="text" class="form-control" name="description" placeholder="<?php echo "$lang[TPL] $lang[DESCRIPTION]"; ?>">
                            <input type="text" class="form-control" name="positions" placeholder="<?php echo "$lang[POSITIONS] $lang[POS_DESCRIPTION]"; ?>">
                            <br><input id="addbutton" type="submit" class="btn btn-danger" name="savenewtheme" value="<?php echo "$lang[SAVE_NEW_THEME_AS]"; ?>">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- SETTINGS -->
        <div role="tabpanel" class="tab-pane  animated fadeIn" id="settings">
            <h3><?php echo "$lang[SETTINGS] <small>$lang[TPL_SETTINGS_SUBTEXT]</small>"; ?></h3>
            <div class="row animated fadeIn">
                <div class="col-md-6">
                    <div class="box box-default">
                        <div class="box-header with-border">
                            <h3 class="box-title">Any thing <small>could be here...</small></h3>
                        </div>
                        <div class="box-body">
                            ...
                        </div>
                    </div>
                </div>
                <!--
                <div class="col-md-4">
                    <div class="box box-default">
                        <div class="box-header with-border">
                            <h3 class="box-title"><?php // echo "$lang[TPL_ADD_SETTING] <small>$lang[TO_ACTIVE_TPL]</small>"; ?></h3>
                        </div>
                        <div class="box-body">
                            <input type="text" class="form-control" id="property" name="property" placeholder="property">
                            <input type="text" class="form-control" name="value" placeholder="value">
                            <input type="text" class="form-control" name="valueDefault" placeholder="default value">
                            <input type="text" class="form-control" name="description" placeholder="description">
                            <input type="text" class="form-control" name="fieldclass" placeholder="fieldClass e.g. input-xlarge">
                            <input type="text" class="form-control" name="placeholder" placeholder="placeholder">
                            <br><input id="savebutton" type="submit" class="btn btn-danger" name="addsetting" value="<?php //echo "$lang[ADD_TPL_SETTINGS]";?>">
                        </div>
                    </div>
                </div>
                -->
                <div class="col-md-6">
                    <div class="box box-default">
                        <div class="box-header with-border">
                            <h3 class="box-title"><?php echo "$lang[TPL_ADD_GFONT] <small>$lang[TPL_ADD_GFONT_SUBTEXT]</small>"; ?></h3>
                        </div>
                        <div class="box-body">
                            <input type="text" class="form-control" id="gfont" name="gfont" placeholder="font eg. Ubuntu">
                            <input type="text" class="form-control" name="gfontdescription" placeholder="description eg. Ubuntu, serif">
                            <br><input id="savebutton" type="submit" class="btn btn-danger" name="addgfont" value="<?php echo "$lang[TPL_ADD_GFONT_BTN]"; ?>">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br><br><br><br><br><br><br><br>
      <!-- </div> <!-- ./ nav-tabs-custom -->
     </form>
    </div>
</div>
