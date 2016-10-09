<!-- color picker -->
<script type="text/javascript" src="../system/engines/jquery/jscolor/jscolor.js"></script>
<!-- --><script type="text/javascript" src="../system/engines/jquery/bootstrap-tabcollapse.js"></script>
<!-- JS GO -->
<script type="text/javascript">
/* reminder: check if form has changed and warns the user that he needs to save. */
    $(document).ready(function() {
    // TRY TP DISABLE CTRL-S browser hotkey
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
        // ok, lets go...
        // we need to check if user clicked on save button
        $( "#savebutton" ).click(function() {
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
            $infoBadge = "<span class=\"label label-success\"><i class=\"fa fa-check\"></i>&nbsp;&nbsp;Visible to everyone</span>";
            // info button on top
            $previewButton = "";
        }
        else
            {   // show preview button and set template active for this user
                $user->setUserTemplate($db, 1, $getID, $user->id);
                $user->overrideTemplate = 1;
                // info badge to inform user that this is HIS preview
                $infoBadge = "<span class=\"label label-danger\"><i class=\"fa fa-eye\"></i>&nbsp;&nbsp;Preview</span>";
                // close preview button on top
                $previewButton = "<a class=\"btn btn-danger\" href=\"index.php?page=template-manage&overrideTemplate=0&id=$getID\"><i class=\"fa fa-times\"></i>&nbsp;&nbsp;Close Preview</a>";
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

    if (isset($_POST['Tdescription']) || isset($_POST['Tsubauthor']) || isset($_POST['Tsubauthorurl']))
    {   // save template details
        $template->setTemplateDetails($db, $_POST['Tdescription'], $_POST['Tsubauthor'], $_POST['Tsubauthorurl'], $template->id);
    }

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
                $template->setCustomCssFile($db, $value, 0, $getID);
                // save a minified version to /system/template/$NAME/css/custom.min.css
                $template->setCustomCssFile($db, $value, 1, $getID);
            }
        }
        else
        {
            if($property != "save" && $property != "customCSS")
            {
                // PREVIEW VAR
                if (isset($_POST['getID']))
                {
                    $template->id = $_POST['getID'];
                }
                // save theme settings to database
                $template->setTemplateSetting($db, $template->id, $property, $value);
                // to file
                // $template->setTemplateCssFile($db, $template->id, $property, $value);
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

    $tpl_settings = YAWK\template::getTemplateSettingsArray($db, $getID);

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

    if (isset($_POST['getID']))
    {
        $template->id = $_POST['getID'];
    }
    if (isset($_GET['id']))
    {   // if id is set
    $template->id = $_GET['id'];
    }
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
            <li><a href=\"index.php\" title=\"Dashboard\"><i class=\"fa fa-dashboard\"></i> Dashboard</a></li>
            <li><a href=\"index.php?page=template-manage\" title=\"Themes\"> Theme Manager</a></li>
            <li><a href=\"index.php?page=template-edit&id=$template->id\" class=\"active\" title=\"Edit Theme\"> Edit Theme</a></li>
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
<form id="template-edit-form" action="index.php?page=template-edit&<?php echo $overrideTemplate; ?>id=<?php echo $template->id; // echo $id; ?>" method="POST">
    <input type="hidden" name="getID" value="<?php echo $getID; ?>">
    <!-- <div class="nav-tabs-custom"> <!-- admin LTE tab style -->
    <div id="btn-wrapper" class="text-right">
    <?php echo $previewButton; ?>
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
                            // PREPARE TEMPLATE DETAILS VARS
                            // author URL
                            if (isset($template->authorUrl) && (!empty($template->authorUrl)))
                            {   // set author's link
                                $authorUrl = "<small>&nbsp;<a href=\"$template->authorUrl\" target=\"_blank\" title=\"Author's weblink [in new tab]\"
                                <i class=\"fa fa-external-link\"></i></a></small>";
                            }
                            else { $authorUrl = ""; }

                            // author
                            if (isset($template->author) && (!empty($template->author)))
                            {   // set author
                                $author = "<dt>Author</dt><dd>$template->author&nbsp;$authorUrl</dd>";
                            }
                            else { $author = ""; }

                            // weblink
                            if (isset($template->weblink) && (!empty($template->weblink)))
                            {   // set author's link
                                $weblink = "<dt>Weblink</dt><dd><a href=\"$template->weblink\" target=\"_blank\" title=\"Project's weblink [in new tab]\">$template->weblink</a></dd>";
                            }
                            else { $weblink= ""; }

                            // modifyDate
                            if (isset($template->modifyDate) && ($template->modifyDate !== "0000-00-00 00:00:00"))
                            {   // set modifyDate
                                $modifyDate = "<dt>modified</dt><dd>$template->modifyDate</dd>";
                            }
                            else { $modifyDate = ''; }

                            // releaseDate
                            if (isset($template->releaseDate) && ($template->releaseDate !== "0000-00-00 00:00:00"))
                            {   // set release date
                                $releaseDate = "<dt>Release</dt><dd>$template->releaseDate</dd>";
                            }
                            else { $releaseDate = ''; }

                            // description
                            if (isset($template->description) && (!empty($template->description)))
                            {   // set author
                                $description = "<dt>Description</dt><dd>$template->description</dd>";
                            }
                            else { $description = ""; }

                            // version
                            if (isset($template->version) && (!empty($template->version)))
                            {   // set author
                                $version = "<dt>Version</dt><dd>$template->version</dd>";
                            }
                            else { $version = ""; }

                            if (isset($template->subAuthorUrl) && (!empty($template->subAuthorUrl)))
                            {   // set author's link
                                $subauthorurl = "<small>&nbsp;<a href=\"$template->subAuthorUrl\" target=\"_blanl\" title=\"Modified by weblink [in new tab]\"
                                <i class=\"fa fa-external-link\"></i></a></small>";
                            }
                            else { $subauthorurl = ""; }

                            // subAuthor
                            if (isset($template->subAuthor) && (!empty($template->subAuthor)))
                            {   // set subAuthor
                                $subauthor = "<dt>Modified by</dt><dd>$template->subAuthor&nbsp;$subauthorurl</dd>";
                            }
                            else { $subauthor = ""; }

                            // subAuthor
                            if (isset($template->license) && (!empty($template->license)))
                            {   // set subAuthor
                                $license = "<dt>License</dt><dd>$template->license</dd>";
                            }
                            else { $license = ""; }

                            $settings = "<dt>Settings</dt>
                            <dd>".$template->countTemplateSettings($db,    $template->id)."</dd>";

                            ?>
                            <dt>Template Name</dt>
                            <dd><b><?php echo $template->name; ?></b></dd>
                            <dt>Status</dt>
                            <dd><b><?php echo $infoBadge; ?></b></dd>

                            <?php echo $description.$author.$weblink.$license.$version.$releaseDate.$settings."<br>".$subauthor.$modifyDate; ?>

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
                    <?PHP  $template->getSetting($db, "body-text-size", "", "", $user); ?>
                    <?PHP  $template->getSetting($db, "body-text-shadow", "", "", $user); ?>
                    <?PHP  $template->getSetting($db, "body-text-shadow-color", "", "", $user); ?>

                    <h3>Link <small>Colors </small></h3>
                    <?PHP $template->getSetting($db, "%-link", "", "", $user); ?>
                </div>
                <div class="col-md-4">
                    <h3>Heading <small>Font Size</small></h3>
                    <?PHP $template->getSetting($db, "h1-size", "", "", $user); ?>
                    <?PHP $template->getSetting($db, "h2-size", "", "", $user); ?>
                    <?PHP $template->getSetting($db, "h3-size", "", "", $user); ?>
                    <?PHP $template->getSetting($db, "h4-size", "", "", $user); ?>
                    <?PHP $template->getSetting($db, "h5-size", "", "", $user); ?>
                    <?PHP $template->getSetting($db, "h6-size", "", "", $user); ?>
                </div>
                <div class="col-md-4">
                    <h3>Heading <small>Colors </small></h3>
                    <?PHP $template->getSetting($db, "%-fontcolor", "", "", $user); ?>
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
                    $template->getSetting($db, "body-bg-color", "", "", $user); ?>
                    <h3>Body <small>Positioning</small></h3>
                    <?PHP $template->getSetting($db, "body-margin-%", "", "", $user); ?>
                </div>
                <div class="col-md-4">
                    <h3>Main Shadow <small>around all positions</small></h3>
                    <?PHP
                    $template->getSetting($db, "main-box-shadow", "", "", $user);
                    $template->getSetting($db, "main-box-shadow-color", "", "", $user); ?>
                    <h3>List Group <small>Colors</small></h3>
                    <?PHP $template->getSetting($db, "%-listgroup", "", "", $user); ?>
                </div>
                <div class="col-md-4">
                    <h3>Background <small>Image</small></h3>
                    <?PHP
                    $template->getSetting($db, "body-bg-image", "", "", $user);
                    $template->getSetting($db, "body-bg-repeat", "", "", $user);
                    $template->getSetting($db, "body-bg-position", "", "", $user);
                    $template->getSetting($db, "body-bg-attachment", "", "", $user);
                    $template->getSetting($db, "body-bg-size", "", "", $user);
                    ?>
                </div>
            </div>
        </div>

        <!-- MENU -->
        <div role="tabpanel" class="tab-pane" id="menu">
            <div class="row animated fadeIn">
                <div class="col-md-3">
                    <h3>Menu Font <small>Colors </small></h3>
                    <?PHP $template->getSetting($db, "%-menucolor", "", "", $user); ?>
                </div>

                <div class="col-md-3">
                    <h3>Menu Background <small>Colors</small></h3>
                    <?PHP $template->getSetting($db, "%-menubgcolor", "", "", $user); ?>
                </div>

                <div class="col-md-3">
                    <h3>Dropdown <small>Colors</small></h3>
                    <?PHP $template->getSetting($db, "%-menudropdowncolor", "", "", $user); ?>
                </div>
                <div class="col-md-3">...additional content here...</div>
            </div>
        </div>

        <!-- WELL, JUMBOTRON -->
        <div role="tabpanel" class="tab-pane" id="well">
            <div class="row animated fadeIn">
                <div class="col-md-3">
                    <h3>Well <small>Box Design</small></h3>
                    <?PHP $template->getSetting($db, "well-%", "", "", $user); ?>
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
                    $template->getSetting($db, "btn-fontsize", "", "", $user);
                    $template->getSetting($db, "btn-font-weight", "", "", $user);
                    $template->getSetting($db, "btn-border", "", "", $user);
                    $template->getSetting($db, "btn-border-style", "", "", $user);
                    $template->getSetting($db, "btn-border-radius", "", "", $user);

                    ?>
                </div>
                <div class="col-md-4">2</div>
                <div class="col-md-4">3</div>
            </div>

            <div class="row animated fadeIn">
                <div class="col-md-2">
                    <h3>Default <small>Button</small></h3>
                    <?PHP
                    $template->getSetting($db, "btn-default-%", "", "", $user);
                    ?>
                </div>

                <div class="col-md-2">
                    <h3>Primary <small>Button</small></h3>
                    <?PHP
                    $template->getSetting($db, "btn-primary-%", "", "", $user);
                    ?>
                </div>
                <div class="col-md-2">
                    <h3>Success <small>Button</small></h3>
                    <?PHP
                    $template->getSetting($db, "btn-success-%", "", "", $user);
                    ?>
                </div>
                <div class="col-md-2">
                    <h3>Warning <small>Button</small></h3>
                    <?PHP
                    $template->getSetting($db, "btn-warning-%", "", "", $user);
                    ?>
                </div>
                <div class="col-md-2">
                    <h3>Danger <small>Button</small></h3>
                    <?PHP
                    $template->getSetting($db, "btn-danger-%", "", "", $user);
                    ?>
                </div>
                <div class="col-md-2">
                    <h3>Info <small>Button</small></h3>
                    <?PHP
                    $template->getSetting($db, "btn-info-%", "", "", $user);
                    ?>
                </div>
            </div>
        </div>

        <!-- IMAGES -->
        <div role="tabpanel" class="tab-pane" id="images">
            <div class="row animated fadeIn">
                <div class="col-md-3">
                    <h3>Image <small>Effects</small></h3>
                    <?PHP $template->getSetting($db, "img-%", "", "", $user); ?>
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
                    <textarea name="customCSS" cols="64" rows="28" id="summernote"><?php
                        $customCSS = $template->getCustomCSSFile($db, $template->id);
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
                    <h4>Update Details <small>of this template</small></h4>
                    <label for="Tname">Template Name</label>
                    <input type="text" class="form-control" id="Tname" name="Tname" value="<?php echo $template->name; ?>" placeholder="Template Name" disabled>
                    <label for="Tauthor">Template Author</label>
                    <input type="text" class="form-control" id="Tauthor" name="Tauthor" value="<?php echo $template->author; ?>" placeholder="Template Author" disabled>
                    <label for="Tversion">Template Version</label>
                    <input type="text" class="form-control" id="Tversion" name="Tversion" value="<?php echo $template->version; ?>" placeholder="Template Version" disabled>
                    <label for="Tname">Template Release Date</label>
                    <input type="text" class="form-control" id="Treleasedate" name="Treleasedate" value="<?php echo $template->releaseDate; ?>" placeholder="Template Release Date" disabled>
                    <label for="Tlicenese">Template License</label>
                    <select name="Tlicense" class="form-control" id="Tlicenese" disabled>
                        <option value="GNU General Public License (GPL)">GNU General Public License (GPL) </option>
                        <option value="GNU Lesser Public License (LGPL)">GNU Lesser Public License (LGPL)</option>
                        <option value="MIT License">MIT License</option>
                        <option value="Mozilla Public License 2.0">Mozilla Public License 2.0</option>
                        <option value="Apache License 2.0">Apache License 2.0</option>
                    </select>
                    <label for="Tdescription">Template Description</label>
                    <textarea class="form-control" id="Tdescription" rows="5" cols="64" name="Tdescription"><?php echo $template->description; ?></textarea>
                    <label for="Tname">Modified by</label>
                    <input type="text" class="form-control" id="Tsubauthor" name="Tsubauthor" value="<?php echo $template->subAuthor; ?>" placeholder="Sub Author">
                    <label for="Tname">Sub Author URL</label>
                    <input type="text" class="form-control" id="Tsubauthorurl" name="Tsubauthorurl" value="<?php echo $template->subAuthorUrl; ?>" placeholder="Co Author Url">
                </div>
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
                    <br><input id="addbutton" type="submit" class="btn btn-danger" name="savenewtheme" value="Add&nbsp;as new Theme" />
                </div>
            </div>
        </div>

    </div>

    <br><br><br><br><br><br><br><br>
      <!-- </div> <!-- ./ nav-tabs-custom -->
     </form>