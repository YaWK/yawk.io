<!-- color picker -->
<script type="text/javascript" src="../system/engines/jquery/jscolor/jscolor.js"></script>
<!-- TAB collapse -->
<script type="text/javascript" src="../system/engines/jquery/bootstrap-tabcollapse.js"></script>
<!-- Bootstrap toggle css -->
<link rel="stylesheet" href="../system/engines/bootstrap-toggle/css/bootstrap-toggle.css">
<!-- Bootstrap toggle js -->
<script type="text/javascript" src="../system/engines/bootstrap-toggle/js/bootstrap-toggle.min.js"></script>
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
                return "<?php echo $lang['LEAVE_REQUEST']; ?>";
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
        var savebutton = ('#savebutton');
        var savebuttonIcon = ('#savebuttonIcon');
        // ok, lets go...
        // we need to check if user clicked on save button
        $(savebutton).click(function() {
            $(savebutton).removeClass('btn btn-success').addClass('btn btn-warning');
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
            if($property != "save" && $property != "customCSS")
            {
                // PREVIEW VAR
                if (isset($_POST['getID']))
                {
                    $template->id = $_POST['getID'];
                }

                // save theme settings to database
                $template->setTemplateSetting($db, $template->id, $property, $value, $longValue);
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
   .navbar-fixed-top {
    margin-top: ".$tpl_settings['navbar-marginTop'].";
  }
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
     .list-group {
        padding-left: ".$tpl_settings['listgroup-paddingLeft'].";
        margin-bottom: ".$tpl_settings['listgroup-marginBottom'].";
     }
     .list-group-item {
        position: ".$tpl_settings['listgroup-itemPosition'].";
        display: ".$tpl_settings['listgroup-itemDisplay'].";
        padding: ".$tpl_settings['listgroup-itemPadding'].";
        margin-bottom: -1px;
        background-color: #".$tpl_settings['listgroup-itemBackgroundColor'].";
        border: ".$tpl_settings['listgroup-itemBorder'].";
        color: #".$tpl_settings['listgroup-fontColor'].";
        font-size: ".$tpl_settings['listgroup-fontSize'].";
        ".$tpl_settings['listgroup-bg-gradient-longValue'].";
    }
    
     .list-group-item:first-child {
        border-top-left-radius: ".$tpl_settings['listgroup-firstChild-topLeft-radius'].";
        border-top-right-radius: ".$tpl_settings['listgroup-firstChild-topRight-radius'].";
     }
     .list-group-item:last-child {
        margin-bottom: 0;
        border-bottom-right-radius: ".$tpl_settings['listgroup-lastChild-bottomRight-radius'].";
        border-bottom-left-radius: ".$tpl_settings['listgroup-lastChild-bottomLeft-radius'].";
     }

     .jumbotron {
        padding-top: ".$tpl_settings['jumbotron-paddingTop'].";
        padding-bottom: ".$tpl_settings['jumbotron-paddingBottom'].";
        margin-bottom: ".$tpl_settings['jumbotron-marginBottom'].";
        color: #".$tpl_settings['jumbotron-fontColor'].";
        background-color: #".$tpl_settings['jumbotron-backgroundColor'].";
        padding-right: ".$tpl_settings['jumbotron-containerPaddingRight'].";
        padding-left: ".$tpl_settings['jumbotron-containerPaddingLeft'].";
        border-radius: ".$tpl_settings['jumbotron-borderRadius'].";
    }
    .jumbotron h1,
    .jumbotron .h1 {
        color: #".$tpl_settings['jumbotron-h1Color'].";
    }
    .jumbotron p {
        margin-bottom: ".$tpl_settings['jumbotron-pMarginBottom'].";
        font-size: ".$tpl_settings['jumbotron-pFontSize'].";
        font-weight: ".$tpl_settings['jumbotron-pFontWeight'].";
    }
    .jumbotron > hr {
        border-top-color: #".$tpl_settings['jumbotron-hrColor'].";
    }
    .container .jumbotron,
    .container-fluid .jumbotron {
        padding-right: ".$tpl_settings['jumbotron-containerPaddingRight'].";
        padding-left: ".$tpl_settings['jumbotron-containerPaddingLeft'].";
        border-radius: ".$tpl_settings['jumbotron-borderRadius'].";
    }
    .jumbotron .container {
        max-width: ".$tpl_settings['jumbotron-containerMaxWidth'].";
    }
    @media screen and (min-width: 768px) {
      .jumbotron {
        padding-top: 48px;
        padding-bottom: 48px;
      }
      .container .jumbotron,
      .container-fluid .jumbotron {
        padding-right: ".$tpl_settings['jumbotron-fluidPaddingRight'].";
        padding-left: ".$tpl_settings['jumbotron-fluidPaddingLeft'].";
      }
      .jumbotron h1,
      .jumbotron .h1 {
        font-size: ".$tpl_settings['jumbotron-h1FontSize'].";
      }
    }
    
    .pos-intro
    {
        top: ".$tpl_settings['pos-intro-top'].";
        margin-bottom: ".$tpl_settings['pos-intro-marginBottom'].";
        position: ".$tpl_settings['pos-intro-position'].";
        background-color: #".$tpl_settings['pos-intro-bg-color'].";
        width: ".$tpl_settings['pos-intro-width'].";
        height: ".$tpl_settings['pos-intro-height'].";
        z-index: ".$tpl_settings['pos-intro-zindex'].";
        ".$tpl_settings['pos-intro-bg-gradient-longValue'].";
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

<form id="template-edit-form" action="index.php?page=template-edit&<?php echo $overrideTemplate; ?>id=<?php echo $template->id; // echo $id; ?>" method="POST">
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
                &nbsp; <?php echo $lang['FONTS_TYPES']; ?></a>
        </li>
        <li role="presentation">
            <a href="#typo" aria-controls="typo" role="tab" data-toggle="tab"><i class="fa fa-text-width"></i>
                &nbsp; <?php echo $lang['TYPOGRAPHY']; ?></a>
        </li>
        <li role="presentation">
            <a href="#body" aria-controls="body" role="tab" data-toggle="tab"><i class="fa fa-object-group"></i>
                &nbsp; <?php echo $lang['BODY']; ?></a>
        </li>
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
                &nbsp; <?php echo $lang['BUTTONS']; ?></a>
        </li>
        <li role="presentation">
            <a href="#images" aria-controls="images" role="tab" data-toggle="tab"><i class="fa fa-picture-o"></i>
                &nbsp; <?php echo $lang['IMAGES']; ?></a>
        </li>
        <li role="presentation">
            <a href="#effects" aria-controls="effects" role="tab" data-toggle="tab"><i class="fa fa-paper-plane-o"></i>
                &nbsp; <?php echo $lang['EFFECTS']; ?></a>
        </li>
        <li role="presentation">
            <a href="#custom" aria-controls="custom" role="tab" data-toggle="tab"><i class="fa fa-css3"></i>
                &nbsp; <?php echo $lang['CUSTOM_CSS']; ?></a>
        </li>
        <li role="presentation">
            <a href="#themes" aria-controls="themes" role="tab" data-toggle="tab"><i class="fa fa-adjust"></i>
                &nbsp; <?php echo $lang['THEME']; ?></a>
        </li>
        <li role="presentation">
            <a href="#settings" aria-controls="settings" role="tab" data-toggle="tab"><i class="fa fa-database"></i>
                &nbsp; <?php echo $lang['SETTINGS']; ?></a>
        </li>
    </ul>

    <!-- Tab panes -->
    <div class="tab-content">
        <!-- OVERVIEW -->
        <div role="tabpanel" class="tab-pane active" id="overview">
            <h3><?php echo "$lang[OVERVIEW] <small>$lang[TPL] $lang[SUMMARY]</small>"; ?></h3>
            <!-- list GOOGLE FONTS -->
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

        <?php
            // GET ALL TEMPLATE SETTINGS INTO ARRAY
            $templateSettings = \YAWK\template::getAllSettingsIntoArray($db, $user);
        ?>

        <!-- POSITIONS -->
        <div role="tabpanel" class="tab-pane" id="positions">
            <h3><? echo "$lang[POSITIONS]"; ?> <small><?php echo "$lang[TPL_POSITION_SETTINGS]"; ?></small></h3>
            <!-- list GOOGLE FONTS -->
            <div class="row animated fadeIn">

                <div class="col-md-3">
                    <div class="box box-with-border">
                        <div class="box-header with-border">
                            <h3 class="box-title"><?php echo "$lang[TPL_POS_INTRO] <small>$lang[TPL_POS_ACTIVE]</small>"; ?></h3>
                        </div>
                        <div class="box-body">
                            <?php $template->getFormElements($db, $templateSettings, 1, $lang, $user); ?>
                        </div>
                        <br>
                    </div>
                </div>

                <div class="col-md-9">
                    <div class="box box-default">
                        <div class="box-header">
                            <h3 class="box-title"><?php echo "$lang[POSITIONS] <small>$lang[SETTINGS]</small>"; ?></h3>
                        </div>

                        <div class="box-body">
                            <div class="container-fluid">
                                <div class="row text-center">
                                    <div class="col-md-12" style="height: 30px; margin-bottom:5px; width: 100%; text-align: center; border-style: dotted; border-color: #ccc;">&laquo;outerTop&raquo;</div>
                                </div>
                                <div class="row text-center">
                                    <div class="col-md-2" style="height: 630px; margin-bottom:5px; text-align: center; border-style: dotted; border-color: #ccc">&laquo;outerLeft&raquo;</div>
                                    <div class="col-md-8">
                                        <div class="row">
                                            <div class="col-md-12 text-bold" style="height: 30px; margin-bottom:5px; width: 100%; text-align: center; border: 2px solid #888; display: block;">&laquo;intro&raquo;</div>
                                            <div class="col-md-12" style="height: 30px; margin-bottom:5px; width: 100%; text-align: center; border-style: dotted; border-color: #ccc">&laquo;globalmenu&raquo;</div>
                                            <div class="col-md-12" style="height: 30px; margin-bottom:5px; width: 100%; text-align: center; border-style: dotted; border-color: #ccc">&laquo;top&raquo;</div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-2" style="height: 410px; margin-bottom:5px; text-align: center; border-style: dotted; border-color: #ccc">&laquo;leftMenu&raquo;</div>
                                            <div class="col-md-8" style="height: auto; margin-bottom:5px; text-align: center; border-style: dotted; border-color: #ccc">
                                                <div class="row">
                                                    <div class="col-md-12" style="height: auto; margin-bottom:5px; text-align: center; border-style: dotted; border-color: #ccc">&laquo;MainTop&raquo;</div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4" style="height: 30px; margin-bottom:5px; text-align: center; border-style: dotted; border-color: #ccc">&laquo;mainTopLeft&raquo;</div>
                                                    <div class="col-md-4" style="height: 30px; margin-bottom:5px; text-align: center; border-style: dotted; border-color: #ccc">&laquo;mainTopCenter&raquo;</div>
                                                    <div class="col-md-4" style="height: 30px; margin-bottom:5px; text-align: center; border-style: dotted; border-color: #ccc">&laquo;mainTopRight&raquo;</div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-12" style="height: 200px; margin-bottom:5px; text-align: center; border-style: dotted; border-color: #ccc">&laquo;Main&raquo;</div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12" style="height: 30px; margin-bottom:5px; text-align: center; border-style: dotted; border-color: #ccc">&laquo;MainBottom&raquo;</div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4" style="height: 30px; margin-bottom:5px; text-align: center; border-style: dotted; border-color: #ccc">&laquo;mainBottomLeft&raquo;</div>
                                                    <div class="col-md-4" style="height: 30px; margin-bottom:5px; text-align: center; border-style: dotted; border-color: #ccc">&laquo;mainBottomCenter&raquo;</div>
                                                    <div class="col-md-4" style="height: 30px; margin-bottom:5px; text-align: center; border-style: dotted; border-color: #ccc">&laquo;mainBottomRight&raquo;</div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12" style="height: 30px; margin-bottom:5px; text-align: center; border-style: dotted; border-color: #ccc">&laquo;MainFooter&raquo;</div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4" style="height: 30px; margin-bottom:5px; text-align: center; border-style: dotted; border-color: #ccc">&laquo;mainFooterLeft&raquo;</div>
                                                    <div class="col-md-4" style="height: 30px; margin-bottom:5px; text-align: center; border-style: dotted; border-color: #ccc">&laquo;mainFooterCenter&raquo;</div>
                                                    <div class="col-md-4" style="height: 30px; margin-bottom:5px; text-align: center; border-style: dotted; border-color: #ccc">&laquo;mainFooterRight&raquo;</div>
                                                </div>
                                            </div>
                                            <div class="col-md-2" style="height: 410px; margin-bottom:5px; text-align: center; border-style: dotted; border-color: #ccc">&laquo;rightMenu&raquo;</div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-12" style="height: 30px; margin-bottom:5px; text-align: center; border-style: dotted; border-color: #ccc">&laquo;Footer&raquo;</div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12" style="height: 30px; margin-bottom:5px; text-align: center; border-style: dotted; border-color: #ccc">&laquo;HiddenToolbar&raquo;</div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12" style="height: 30px; margin-bottom:5px; text-align: center; border-style: dotted; border-color: #ccc">&laquo;Debug&raquo;</div>
                                        </div>
                                    </div>
                                    <div class="col-md-2" style="height: 630px; margin-bottom:5px; text-align: center; border-style: dotted; border-color: #ccc">&laquo;outerRight&raquo;</div>

                                </div>

                                <div class="row text-center">
                                    <div class="col-md-12" style="height: 30px; margin-bottom:5px; width: 100%; text-align: center; border-style: dotted; border-color: #ccc">&laquo;outerBottom&raquo;</div>
                                </div>
                            </div>
                        </div>
                        <!--
                        <div class="box-body">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-md-12" style="height: 30px; margin-bottom:5px; width: 100%; text-align: center; border-style: dotted; border-color: #ccc">&laquo;intro&raquo;</div>
                                    <div class="col-md-12" style="height: 30px; margin-bottom:5px; width: 100%; text-align: center; border-style: dotted; border-color: #ccc">&laquo;globalmenu&raquo;</div>
                                    <div class="col-md-12" style="height: 30px; margin-bottom:5px; width: 100%; text-align: center; border-style: dotted; border-color: #ccc">&laquo;top&raquo;</div>
                                    <div class="col-md-2" style="height: 190px; margin-bottom:5px; text-align: center; border-style: dotted; border-color: #ccc">leftMenu</div>
                                    <div class="col-md-8" style="height: 30px; margin-bottom:5px; text-align: center;">
                                        <div class="row">
                                            <div class="col-md-4" style="height: 30px; text-align: center; border-style: dotted; border-color: #ccc">mainTopLeft</div>
                                            <div class="col-md-4" style="height: 30px; text-align: center; border-style: dotted; border-color: #ccc">mainTopCenter</div>
                                            <div class="col-md-4" style="height: 30px; text-align: center; border-style: dotted; border-color: #ccc">mainTopRight</div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12" style="height: 160px; text-align: center; border-style: dotted; border-color: #ccc">main</div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12" style="height: 30px; text-align: center; border-style: dotted; border-color: #ccc">mainFooter</div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4" style="height: 30px; text-align: center; border-style: dotted; border-color: #ccc">mainFooterLeft</div>
                                            <div class="col-md-4" style="height: 30px; text-align: center; border-style: dotted; border-color: #ccc">mainFooterCenter</div>
                                            <div class="col-md-4" style="height: 30px; text-align: center; border-style: dotted; border-color: #ccc">mainFooterRight</div>
                                        </div>
                                    </div>
                                    <div class="col-md-2" style="height: 190px; margin-bottom:5px; text-align: center; border-style: dotted; border-color: #ccc">rightMenu</div>

                                </div>
                            </div>
                        </div>
                        -->

                    </div>
                </div>
            </div>
        </div>

        <!-- FONTS -->
        <div role="tabpanel" class="tab-pane" id="fonts">
            <h3><?php echo "$lang[FONTS_TYPES] <small>$lang[TPL_FONTS_SUBTEXT]"; ?></small></h3>
            <!-- list GOOGLE FONTS -->
            <div class="row animated fadeIn">
                <div class="col-md-4">
                    <div class="box box-default">
                        <div class="box-header">
                            <h3 class="box-title"><?php echo "$lang[H1_H6] <small>$lang[FONT_TYPE]"; ?></small></h3>
                        </div>
                        <div class="box-body">
                            <?php $template->getgFonts($db, "heading-gfont"); ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="box box-default">
                        <div class="box-header">
                            <h3 class="box-title"><?php echo "$lang[MENU] <small>$lang[FONT_TYPE]</small>"; ?></h3>
                        </div>
                        <div class="box-body">
                            <?php $template->getgFonts($db, "menu-gfont"); ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="box box-default">
                        <div class="box-header">
                            <h3 class="box-title"><?php echo "$lang[TEXT] <small>$lang[FONT_TYPE]</small>"; ?></h3>
                        </div>
                        <div class="box-body">
                            <?php $template->getgFonts($db, "text-gfont"); ?>
                        </div>
                    </div>
                </div>
                </div>
        </div>

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
                            <?php $template->getFormElements($db, $templateSettings, 4, $lang, $user); ?>
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
                            <?php $template->getFormElements($db, $templateSettings, 5, $lang, $user); ?>
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
            <h3><?php echo "$lang[BUTTON] <small>$lang[SETTINGS]</small>"; ?></h3>
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
                            <h3 class="box-title">Any other thing <small>here ...</small></h3>
                        </div>
                        <div class="box-body">
                            ...fill this empty space with love...
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="box box-default">
                        <div class="box-header">
                            <h3 class="box-title">Any other thing <small>here ...</small></h3>
                        </div>
                        <div class="box-body">
                            ...fill this empty space with love...
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
        <div role="tabpanel" class="tab-pane" id="effects">Kommen dann hier rein...

        </div>

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
                            <h3 class="box-title"><?php echo "$lang[TPL_UPDATE_DETAILS] <small>$lang[TPL_UPDATE_SUBTEXT]</small>"; ?></h3>
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
                            <textarea class="form-control" id="Tdescription" rows="5" cols="64" name="Tdescription"><?php echo $template->description; ?></textarea>
                            <label for="Tsubauthor"><?php echo "$lang[MODIFIED] $lang[BY]"; ?></label>
                            <input type="text" class="form-control" id="Tsubauthor" name="Tsubauthor" value="<?php echo $template->subAuthor; ?>" placeholder="<?php echo "$lang[MODIFIED] $lang[BY]"; ?>">
                            <label for="Tsubauthorurl"><?php echo "$lang[SUB_AUTHOR_URL]"; ?></label>
                            <input type="text" class="form-control" id="Tsubauthorurl" name="Tsubauthorurl" value="<?php echo $template->subAuthorUrl; ?>" placeholder="<?php echo "$lang[SUB_AUTHOR_URL]"; ?>">
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
                <div class="col-md-4">
                    <div class="box box-default">
                        <div class="box-header with-border">
                            <h3 class="box-title">Any thing <small>could be here...</small></h3>
                        </div>
                        <div class="box-body">
                            ...
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="box box-default">
                        <div class="box-header with-border">
                            <h3 class="box-title"><?php echo "$lang[TPL_ADD_SETTING] <small>$lang[TO_ACTIVE_TPL]</small>"; ?></h3>
                        </div>
                        <div class="box-body">
                            <input type="text" class="form-control" id="property" name="property" placeholder="property">
                            <input type="text" class="form-control" name="value" placeholder="value">
                            <input type="text" class="form-control" name="valueDefault" placeholder="default value">
                            <input type="text" class="form-control" name="description" placeholder="description">
                            <input type="text" class="form-control" name="fieldclass" placeholder="fieldClass e.g. input-xlarge">
                            <input type="text" class="form-control" name="placeholder" placeholder="placeholder">
                            <br><input id="savebutton" type="submit" class="btn btn-danger" name="addsetting" value="<?php echo "$lang[ADD_TPL_SETTINGS]";?>">
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
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
