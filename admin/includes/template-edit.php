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
        font-weight:normal;
        border-style: dotted; border-color: #ccc;
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
    }
</style>
<!-- Javascript for positions tab -->
<script type="text/javascript">
/* reminder: check if form has changed and warns the user that he needs to save. */
    $(document).ready(function() {
        // store settings position box id's in vars
        settings_pos_outerTop = "#settings_pos_outerTop";
        settings_pos_outerLeft = "#settings_pos_outerLeft";
        settings_pos_outerRight = "#settings_pos_outerRight";
        settings_pos_leftMenu = "#settings_pos_leftMenu";
        settings_pos_rightMenu = "#settings_pos_rightMenu";
        settings_pos_intro = "#settings_pos_intro";
        settings_pos_globalmenu = "#settings_pos_globalmenu";
        settings_pos_top = "#settings_pos_top";
        settings_pos_mainTop = "#settings_pos_mainTop";
        settings_pos_mainTopLeft = "#settings_pos_mainTopLeft";
        settings_pos_mainTopCenter = "#settings_pos_mainTopCenter";
        settings_pos_mainTopRight = "#settings_pos_mainTopRight";
        settings_pos_main = "#settings_pos_main";
        settings_pos_mainBottom = "#settings_pos_mainBottom";
        settings_pos_mainBottomLeft = "#settings_pos_mainBottomLeft";
        settings_pos_mainBottomCenter = "#settings_pos_mainBottomCenter";
        settings_pos_mainBottomRight = "#settings_pos_mainBottomRight";
        settings_pos_mainFooter = "#settings_pos_mainFooter";
        settings_pos_mainFooterLeft = "#settings_pos_mainFooterLeft";
        settings_pos_mainFooterCenter = "#settings_pos_mainFooterCenter";
        settings_pos_mainFooterRight = "#settings_pos_mainFooterRight";
        settings_pos_footer = "#settings_pos_footer";
        settings_pos_hiddenToolbar = "#settings_pos_hiddenToolbar";
        settings_pos_debug = "#settings_pos_debug";
        settings_pos_outerBottom = "#settings_pos_outerBottom";

        // store position selector in vars
        pos_outerTop = "#pos_outerTop";
        pos_outerLeft = "#pos_outerLeft";
        pos_outerRight = "#pos_outerRight";
        pos_leftMenu = "#pos_leftMenu";
        pos_rightMenu = "#pos_rightMenu";
        pos_intro = "#pos_intro";
        pos_globalmenu = "#pos_globalmenu";
        pos_top = "#pos_top";
        pos_mainTop = "#pos_mainTop";
        pos_mainTopLeft = "#pos_mainTopLeft";
        pos_mainTopCenter = "#pos_mainTopCenter";
        pos_mainTopRight = "#pos_mainTopRight";
        pos_main = "#pos_main";
        pos_mainBottom = "#pos_mainBottom";
        pos_mainBottomLeft = "#pos_mainBottomLeft";
        pos_mainBottomCenter = "#pos_mainBottomCenter";
        pos_mainBottomRight = "#pos_mainBottomRight";
        pos_mainFooter = "#pos_mainFooter";
        pos_mainFooterLeft = "#pos_mainFooterLeft";
        pos_mainFooterCenter = "#pos_mainFooterCenter";
        pos_mainFooterRight = "#pos_mainFooterRight";
        pos_footer = "#pos_footer";
        pos_hiddenToolbar = "#pos_hiddenToolbar";
        pos_debug = "#pos_debug";
        pos_outerBottom = "#pos_outerBottom";

        // hide all settings boxes on default
        // they will appear by clicking on a postion selector
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

        $(pos_outerTop).click(function () {
            $("#selectPositionRequestInfo").hide();
            $(settings_pos_outerTop).fadeToggle();
            $(pos_outerTop).toggleClass("posboxActive");
        });

        $(pos_outerLeft).click(function () {
            $("#selectPositionRequestInfo").hide();
            $(settings_pos_outerLeft).fadeToggle();
            $(pos_outerLeft).toggleClass("posboxActive");
        });
        $(pos_outerRight).click(function () {
            $("#selectPositionRequestInfo").hide();
            $(settings_pos_outerRight).fadeToggle();
            $(pos_outerRight).toggleClass("posboxActive");
        });
        $(pos_intro).click(function () {
            $("#selectPositionRequestInfo").hide();
            $(settings_pos_intro).fadeToggle();
            $(pos_intro).toggleClass("posboxActive");
        });
        $(pos_globalmenu).click(function () {
            $("#selectPositionRequestInfo").hide();
            $(settings_pos_globalmenu).fadeToggle();
            $(pos_globalmenu).toggleClass("posboxActive");
        });
        $(pos_top).click(function () {
            $("#selectPositionRequestInfo").hide();
            $(settings_pos_top).fadeToggle();
            $(pos_top).toggleClass("posboxActive");
        });
        $(pos_mainTop).click(function () {
            $("#selectPositionRequestInfo").hide();
            $(settings_pos_mainTop).fadeToggle();
            $(pos_mainTop).toggleClass("posboxActive");
        });
        $(pos_mainTopLeft).click(function () {
            $("#selectPositionRequestInfo").hide();
            $(settings_pos_mainTopLeft).fadeToggle();
            $(pos_mainTopLeft).toggleClass("posboxActive");
        });
        $(pos_mainTopCenter).click(function () {
            $("#selectPositionRequestInfo").hide();
            $(settings_pos_mainTopCenter).fadeToggle();
            $(pos_mainTopCenter).toggleClass("posboxActive");
        });
        $(pos_mainTopRight).click(function () {
            $("#selectPositionRequestInfo").hide();
            $(settings_pos_mainTopRight).fadeToggle();
            $(pos_mainTopRight).toggleClass("posboxActive");
        });
        $(pos_main).click(function () {
            $("#selectPositionRequestInfo").hide();
            $(settings_pos_main).fadeToggle();
            $(pos_main).toggleClass("posboxActive");
        });
        $(pos_mainBottom).click(function () {
            $("#selectPositionRequestInfo").hide();
            $(settings_pos_mainBottom).fadeToggle();
            $(pos_mainBottom).toggleClass("posboxActive");
        });
        $(pos_mainBottomLeft).click(function () {
            $("#selectPositionRequestInfo").hide();
            $(settings_pos_mainBottomLeft).fadeToggle();
            $(pos_mainBottomLeft).toggleClass("posboxActive");
        });
        $(pos_mainBottomCenter).click(function () {
            $("#selectPositionRequestInfo").hide();
            $(settings_pos_mainBottomCenter).fadeToggle();
            $(pos_mainBottomCenter).toggleClass("posboxActive");
        });
        $(pos_mainBottomRight).click(function () {
            $("#selectPositionRequestInfo").hide();
            $(settings_pos_mainBottomRight).fadeToggle();
            $(pos_mainBottomRight).toggleClass("posboxActive");
        });
        $(pos_mainFooter).click(function () {
            $("#selectPositionRequestInfo").hide();
            $(settings_pos_mainFooter).fadeToggle();
            $(pos_mainFooter).toggleClass("posboxActive");
        });
        $(pos_mainFooterLeft).click(function () {
            $("#selectPositionRequestInfo").hide();
            $(settings_pos_mainFooterLeft).fadeToggle();
            $(pos_mainFooterLeft).toggleClass("posboxActive");
        });
        $(pos_mainFooterCenter).click(function () {
            $("#selectPositionRequestInfo").hide();
            $(settings_pos_mainFooterCenter).fadeToggle();
            $(pos_mainFooterCenter).toggleClass("posboxActive");
        });
        $(pos_mainFooterRight).click(function () {
            $("#selectPositionRequestInfo").hide();
            $(settings_pos_mainFooterRight).fadeToggle();
            $(pos_mainFooterRight).toggleClass("posboxActive");
        });
        $(pos_footer).click(function () {
            $("#selectPositionRequestInfo").hide();
            $(settings_pos_footer).fadeToggle();
            $(pos_footer).toggleClass("posboxActive");
        });
        $(pos_hiddenToolbar).click(function () {
            $("#selectPositionRequestInfo").hide();
            $(settings_pos_hiddenToolbar).fadeToggle();
            $(pos_hiddenToolbar).toggleClass("posboxActive");
        });
        $(pos_debug).click(function () {
            $("#selectPositionRequestInfo").hide();
            $(settings_pos_debug).fadeToggle();
            $(pos_debug).toggleClass("posboxActive");
        });
        $(pos_outerBottom).click(function () {
            $("#selectPositionRequestInfo").hide();
            $(settings_pos_outerBottom).fadeToggle();
            $(pos_outerBottom).toggleClass("posboxActive");
        });
        $(pos_leftMenu).click(function () {
            $("#selectPositionRequestInfo").hide();
            $(settings_pos_leftMenu).fadeToggle();
            $(pos_leftMenu).toggleClass("posboxActive");
        });
        $(pos_rightMenu).click(function () {
            $("#selectPositionRequestInfo").hide();
            $(settings_pos_rightMenu).fadeToggle();
            $(pos_rightMenu).toggleClass("posboxActive");
        });

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
            if($property != "save" && $property != "customCSS")
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

    $tpl_settings = YAWK\template::getTemplateSettingsArray($db, $getID);

    // get HEADER FONT from db
    $headingFont = YAWK\template::getActivegfont($db, "", "heading-gfont");

    $content = "
    /* ATTENTION: THIS FILE IS AUTO-GENERATED. */
    /* DO NOT EDIT THIS FILE DIRECTLY. USE RE-DESIGN INSTEAD. */
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
    
    /* FORMS */
    .form-control {
      display: ".$tpl_settings['form-display'].";
      width: ".$tpl_settings['form-width'].";
      height: ".$tpl_settings['form-height'].";
      padding: ".$tpl_settings['form-padding'].";
      font-size: ".$tpl_settings['form-fontSize'].";
      line-height: ".$tpl_settings['form-lineHeight'].";
      color: #".$tpl_settings['form-textColor'].";
      background-color: #".$tpl_settings['form-bgcolor'].";
      background-image: none;
      border: ".$tpl_settings['form-border'].";
      border-radius: ".$tpl_settings['form-border-radius'].";
      -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075);
              box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075);
      -webkit-transition: border-color ease-in-out .15s, -webkit-box-shadow ease-in-out .15s;
           -o-transition: border-color ease-in-out .15s, box-shadow ease-in-out .15s;
              transition: border-color ease-in-out .15s, box-shadow ease-in-out .15s;
    }
    .form-control:focus {
      border-color: #".$tpl_settings['form-activeBorderColor'].";
      outline: 0;
      -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.075), 0 0 8px rgba(102, 175, 233, .6);
              box-shadow: inset 0 1px 1px rgba(0,0,0,.075), 0 0 8px rgba(102, 175, 233, .6);
    }
    .form-control::-moz-placeholder {
      color: #".$tpl_settings['form-placeholderColor'].";
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
    margin-top: ".$tpl_settings['navbar-marginTop'].";
    margin-bottom: ".$tpl_settings['navbar-marginBottom'].";
  }
   .navbar-default {
       text-shadow: 1px 0px #".$tpl_settings['fontshadow-menucolor'].";
       filter: dropshadow(color=#".$tpl_settings['fontshadow-menucolor'].", offx=1, offy=1);
       background-color: #".$tpl_settings['default-menubgcolor'].";
       border-color: #".$tpl_settings['border-menubgcolor'].";
       margin-bottom: ".$tpl_settings['navbar-marginBottom'].";
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
    
    .pos-outerTop
    {   
        -webkit-box-shadow: ".$tpl_settings['pos-outerTop-box-shadow-width']." #".$tpl_settings['pos-outerTop-box-shadow-color'].";
        -moz-box-shadow: ".$tpl_settings['pos-outerTop-box-shadow-width']." #".$tpl_settings['pos-outerTop-box-shadow-color'].";
        box-shadow: ".$tpl_settings['pos-outerTop-box-shadow-width']." #".$tpl_settings['pos-outerTop-box-shadow-color'].";
        border-width: ".$tpl_settings['pos-outerTop-border-width'].";
        border-color: #".$tpl_settings['pos-outerTop-border-color'].";
        border-style: ".$tpl_settings['pos-outerTop-border-style'].";
        border-radius: ".$tpl_settings['pos-outerTop-border-radius'].";
        padding: ".$tpl_settings['pos-outerTop-padding'].";
        overflow: ".$tpl_settings['pos-outerTop-overflow'].";
        visibility: ".$tpl_settings['pos-outerTop-visibility'].";
        text-align: ".$tpl_settings['pos-outerTop-text-align'].";
        vertical-align: ".$tpl_settings['pos-outerTop-vertical-align'].";
        margin-top: ".$tpl_settings['pos-outerTop-marginTop'].";
        margin-bottom: ".$tpl_settings['pos-outerTop-marginBottom'].";
        position: ".$tpl_settings['pos-outerTop-position'].";
        background-color: #".$tpl_settings['pos-outerTop-bgcolor'].";
        width: ".$tpl_settings['pos-outerTop-width'].";
        height: ".$tpl_settings['pos-outerTop-height'].";
        z-index: ".$tpl_settings['pos-outerTop-zindex'].";
        ".$tpl_settings['pos-outerTop-bg-gradient-longValue']."
        ".$tpl_settings['pos-outerTop-customCSS-longValue']."
        /* BACKGROUND IMAGE */
        background-image: url('".$tpl_settings['pos-outerTop-bg-image']."');
        background-repeat:".$tpl_settings['pos-outerTop-bg-repeat'].";
        background-position:".$tpl_settings['pos-outerTop-bg-position'].";
        background-attachment:".$tpl_settings['pos-outerTop-bg-attachment'].";
        background-size: ".$tpl_settings['pos-outerTop-bg-attachment'].";
    }
    .pos-intro
    {   
        -webkit-box-shadow: ".$tpl_settings['pos-intro-box-shadow-width']." #".$tpl_settings['pos-intro-box-shadow-color'].";
        -moz-box-shadow: ".$tpl_settings['pos-intro-box-shadow-width']." #".$tpl_settings['pos-intro-box-shadow-color'].";
        box-shadow: ".$tpl_settings['pos-intro-box-shadow-width']." #".$tpl_settings['pos-intro-box-shadow-color'].";
        border-width: ".$tpl_settings['pos-intro-border-width'].";
        border-color: #".$tpl_settings['pos-intro-border-color'].";
        border-style: ".$tpl_settings['pos-intro-border-style'].";
        border-radius: ".$tpl_settings['pos-intro-border-radius'].";
        padding: ".$tpl_settings['pos-intro-padding'].";
        overflow: ".$tpl_settings['pos-intro-overflow'].";
        visibility: ".$tpl_settings['pos-intro-visibility'].";
        text-align: ".$tpl_settings['pos-intro-text-align'].";
        vertical-align: ".$tpl_settings['pos-intro-vertical-align'].";
        margin-top: ".$tpl_settings['pos-intro-marginTop'].";
        margin-bottom: ".$tpl_settings['pos-intro-marginBottom'].";
        position: ".$tpl_settings['pos-intro-position'].";
        background-color: #".$tpl_settings['pos-intro-bgcolor'].";
        width: ".$tpl_settings['pos-intro-width'].";
        height: ".$tpl_settings['pos-intro-height'].";
        z-index: ".$tpl_settings['pos-intro-zindex'].";
        ".$tpl_settings['pos-intro-bg-gradient-longValue']."
        ".$tpl_settings['pos-intro-customCSS-longValue']."
        /* BACKGROUND IMAGE */
        background-image: url('".$tpl_settings['pos-intro-bg-image']."');
        background-repeat:".$tpl_settings['pos-intro-bg-repeat'].";
        background-position:".$tpl_settings['pos-intro-bg-position'].";
        background-attachment:".$tpl_settings['pos-intro-bg-attachment'].";
        background-size: ".$tpl_settings['pos-intro-bg-attachment'].";
    }
    .pos-globalmenu
    {   
        -webkit-box-shadow: ".$tpl_settings['pos-globalmenu-box-shadow-width']." #".$tpl_settings['pos-globalmenu-box-shadow-color'].";
        -moz-box-shadow: ".$tpl_settings['pos-globalmenu-box-shadow-width']." #".$tpl_settings['pos-globalmenu-box-shadow-color'].";
        box-shadow: ".$tpl_settings['pos-globalmenu-box-shadow-width']." #".$tpl_settings['pos-globalmenu-box-shadow-color'].";
        border-width: ".$tpl_settings['pos-globalmenu-border-width'].";
        border-color: #".$tpl_settings['pos-globalmenu-border-color'].";
        border-style: ".$tpl_settings['pos-globalmenu-border-style'].";
        border-radius: ".$tpl_settings['pos-globalmenu-border-radius'].";
        padding: ".$tpl_settings['pos-globalmenu-padding'].";
        overflow: ".$tpl_settings['pos-globalmenu-overflow'].";
        visibility: ".$tpl_settings['pos-globalmenu-visibility'].";
        text-align: ".$tpl_settings['pos-globalmenu-text-align'].";
        vertical-align: ".$tpl_settings['pos-globalmenu-vertical-align'].";
        margin-top: ".$tpl_settings['pos-globalmenu-marginTop'].";
        margin-bottom: ".$tpl_settings['pos-globalmenu-marginBottom'].";
        position: ".$tpl_settings['pos-globalmenu-position'].";
        background-color: #".$tpl_settings['pos-globalmenu-bgcolor'].";
        width: ".$tpl_settings['pos-globalmenu-width'].";
        height: ".$tpl_settings['pos-globalmenu-height'].";
        z-index: ".$tpl_settings['pos-globalmenu-zindex'].";
        ".$tpl_settings['pos-globalmenu-bg-gradient-longValue']."
        ".$tpl_settings['pos-globalmenu-customCSS-longValue']."
        /* BACKGROUND IMAGE */
        background-image: url('".$tpl_settings['pos-globalmenu-bg-image']."');
        background-repeat:".$tpl_settings['pos-globalmenu-bg-repeat'].";
        background-position:".$tpl_settings['pos-globalmenu-bg-position'].";
        background-attachment:".$tpl_settings['pos-globalmenu-bg-attachment'].";
        background-size: ".$tpl_settings['pos-globalmenu-attachment'].";
    }
    .pos-top
    {   
        -webkit-box-shadow: ".$tpl_settings['pos-top-box-shadow-width']." #".$tpl_settings['pos-top-box-shadow-color'].";
        -moz-box-shadow: ".$tpl_settings['pos-top-box-shadow-width']." #".$tpl_settings['pos-top-box-shadow-color'].";
        box-shadow: ".$tpl_settings['pos-top-box-shadow-width']." #".$tpl_settings['pos-top-box-shadow-color'].";
        border-width: ".$tpl_settings['pos-top-border-width'].";
        border-color: #".$tpl_settings['pos-top-border-color'].";
        border-style: ".$tpl_settings['pos-top-border-style'].";
        border-radius: ".$tpl_settings['pos-top-border-radius'].";
        padding: ".$tpl_settings['pos-top-padding'].";
        overflow: ".$tpl_settings['pos-top-overflow'].";
        visibility: ".$tpl_settings['pos-top-visibility'].";
        text-align: ".$tpl_settings['pos-top-text-align'].";
        vertical-align: ".$tpl_settings['pos-top-vertical-align'].";
        margin-top: ".$tpl_settings['pos-top-marginTop'].";
        margin-bottom: ".$tpl_settings['pos-top-marginBottom'].";
        position: ".$tpl_settings['pos-top-position'].";
        background-color: #".$tpl_settings['pos-top-bgcolor'].";
        width: ".$tpl_settings['pos-top-width'].";
        height: ".$tpl_settings['pos-top-height'].";
        z-index: ".$tpl_settings['pos-top-zindex'].";
        ".$tpl_settings['pos-top-bg-gradient-longValue']."
        ".$tpl_settings['pos-top-customCSS-longValue']."
        /* BACKGROUND IMAGE */
        background-image: url('".$tpl_settings['pos-top-bg-image']."');
        background-repeat:".$tpl_settings['pos-top-bg-repeat'].";
        background-position:".$tpl_settings['pos-top-bg-position'].";
        background-attachment:".$tpl_settings['pos-top-bg-attachment'].";
        background-size: ".$tpl_settings['pos-top-attachment'].";
    }
    .pos-outerLeft
    {   
        -webkit-box-shadow: ".$tpl_settings['pos-outerLeft-box-shadow-width']." #".$tpl_settings['pos-outerLeft-box-shadow-color'].";
        -moz-box-shadow: ".$tpl_settings['pos-outerLeft-box-shadow-width']." #".$tpl_settings['pos-outerLeft-box-shadow-color'].";
        box-shadow: ".$tpl_settings['pos-outerLeft-box-shadow-width']." #".$tpl_settings['pos-outerLeft-box-shadow-color'].";
        border-width: ".$tpl_settings['pos-outerLeft-border-width'].";
        border-color: #".$tpl_settings['pos-outerLeft-border-color'].";
        border-style: ".$tpl_settings['pos-outerLeft-border-style'].";
        border-radius: ".$tpl_settings['pos-outerLeft-border-radius'].";
        padding: ".$tpl_settings['pos-outerLeft-padding'].";
        overflow: ".$tpl_settings['pos-outerLeft-overflow'].";
        visibility: ".$tpl_settings['pos-outerLeft-visibility'].";
        text-align: ".$tpl_settings['pos-outerLeft-text-align'].";
        vertical-align: ".$tpl_settings['pos-outerLeft-vertical-align'].";
        margin-top: ".$tpl_settings['pos-outerLeft-marginTop'].";
        margin-bottom: ".$tpl_settings['pos-outerLeft-marginBottom'].";
        position: ".$tpl_settings['pos-outerLeft-position'].";
        background-color: #".$tpl_settings['pos-outerLeft-bgcolor'].";
        height: ".$tpl_settings['pos-outerLeft-height'].";
        z-index: ".$tpl_settings['pos-outerLeft-zindex'].";
        ".$tpl_settings['pos-outerLeft-bg-gradient-longValue']."
        ".$tpl_settings['pos-outerLeft-customCSS-longValue']."
        /* BACKGROUND IMAGE */
        background-image: url('".$tpl_settings['pos-outerLeft-bg-image']."');
        background-repeat:".$tpl_settings['pos-outerLeft-bg-repeat'].";
        background-position:".$tpl_settings['pos-outerLeft-bg-position'].";
        background-attachment:".$tpl_settings['pos-outerLeft-bg-attachment'].";
        background-size: ".$tpl_settings['pos-outerLeft-attachment'].";
    }
    .pos-outerRight
    {   
        -webkit-box-shadow: ".$tpl_settings['pos-outerRight-box-shadow-width']." #".$tpl_settings['pos-outerRight-box-shadow-color'].";
        -moz-box-shadow: ".$tpl_settings['pos-outerRight-box-shadow-width']." #".$tpl_settings['pos-outerRight-box-shadow-color'].";
        box-shadow: ".$tpl_settings['pos-outerRight-box-shadow-width']." #".$tpl_settings['pos-outerRight-box-shadow-color'].";
        border-width: ".$tpl_settings['pos-outerRight-border-width'].";
        border-color: #".$tpl_settings['pos-outerRight-border-color'].";
        border-style: ".$tpl_settings['pos-outerRight-border-style'].";
        border-radius: ".$tpl_settings['pos-outerRight-border-radius'].";
        padding: ".$tpl_settings['pos-outerRight-padding'].";
        overflow: ".$tpl_settings['pos-outerRight-overflow'].";
        visibility: ".$tpl_settings['pos-outerRight-visibility'].";
        text-align: ".$tpl_settings['pos-outerRight-text-align'].";
        vertical-align: ".$tpl_settings['pos-outerRight-vertical-align'].";
        margin-top: ".$tpl_settings['pos-outerRight-marginTop'].";
        margin-bottom: ".$tpl_settings['pos-outerRight-marginBottom'].";
        position: ".$tpl_settings['pos-outerRight-position'].";
        background-color: #".$tpl_settings['pos-outerRight-bgcolor'].";
        height: ".$tpl_settings['pos-outerRight-height'].";
        z-index: ".$tpl_settings['pos-outerRight-zindex'].";
        ".$tpl_settings['pos-outerRight-bg-gradient-longValue']."
        ".$tpl_settings['pos-outerRight-customCSS-longValue']."
        /* BACKGROUND IMAGE */
        background-image: url('".$tpl_settings['pos-outerRight-bg-image']."');
        background-repeat:".$tpl_settings['pos-outerRight-bg-repeat'].";
        background-position:".$tpl_settings['pos-outerRight-bg-position'].";
        background-attachment:".$tpl_settings['pos-outerRight-bg-attachment'].";
        background-size: ".$tpl_settings['pos-outerRight-attachment'].";
    }
    .pos-leftMenu
    {   
        -webkit-box-shadow: ".$tpl_settings['pos-leftMenu-box-shadow-width']." #".$tpl_settings['pos-leftMenu-box-shadow-color'].";
        -moz-box-shadow: ".$tpl_settings['pos-leftMenu-box-shadow-width']." #".$tpl_settings['pos-leftMenu-box-shadow-color'].";
        box-shadow: ".$tpl_settings['pos-leftMenu-box-shadow-width']." #".$tpl_settings['pos-leftMenu-box-shadow-color'].";
        border-width: ".$tpl_settings['pos-leftMenu-border-width'].";
        border-color: #".$tpl_settings['pos-leftMenu-border-color'].";
        border-style: ".$tpl_settings['pos-leftMenu-border-style'].";
        border-radius: ".$tpl_settings['pos-leftMenu-border-radius'].";
        padding: ".$tpl_settings['pos-leftMenu-padding'].";
        overflow: ".$tpl_settings['pos-leftMenu-overflow'].";
        visibility: ".$tpl_settings['pos-leftMenu-visibility'].";
        text-align: ".$tpl_settings['pos-leftMenu-text-align'].";
        vertical-align: ".$tpl_settings['pos-leftMenu-vertical-align'].";
        margin-top: ".$tpl_settings['pos-leftMenu-marginTop'].";
        margin-bottom: ".$tpl_settings['pos-leftMenu-marginBottom'].";
        position: ".$tpl_settings['pos-leftMenu-position'].";
        background-color: #".$tpl_settings['pos-leftMenu-bgcolor'].";
        height: ".$tpl_settings['pos-leftMenu-height'].";
        z-index: ".$tpl_settings['pos-leftMenu-zindex'].";
        ".$tpl_settings['pos-leftMenu-bg-gradient-longValue']."
        ".$tpl_settings['pos-leftMenu-customCSS-longValue']."
        /* BACKGROUND IMAGE */
        background-image: url('".$tpl_settings['pos-leftMenu-bg-image']."');
        background-repeat:".$tpl_settings['pos-leftMenu-bg-repeat'].";
        background-position:".$tpl_settings['pos-leftMenu-bg-position'].";
        background-attachment:".$tpl_settings['pos-leftMenu-bg-attachment'].";
        background-size: ".$tpl_settings['pos-leftMenu-attachment'].";
    }
    .pos-rightMenu
    {   
        -webkit-box-shadow: ".$tpl_settings['pos-rightMenu-box-shadow-width']." #".$tpl_settings['pos-rightMenu-box-shadow-color'].";
        -moz-box-shadow: ".$tpl_settings['pos-rightMenu-box-shadow-width']." #".$tpl_settings['pos-rightMenu-box-shadow-color'].";
        box-shadow: ".$tpl_settings['pos-rightMenu-box-shadow-width']." #".$tpl_settings['pos-rightMenu-box-shadow-color'].";
        border-width: ".$tpl_settings['pos-rightMenu-border-width'].";
        border-color: #".$tpl_settings['pos-rightMenu-border-color'].";
        border-style: ".$tpl_settings['pos-rightMenu-border-style'].";
        border-radius: ".$tpl_settings['pos-rightMenu-border-radius'].";
        padding: ".$tpl_settings['pos-rightMenu-padding'].";
        overflow: ".$tpl_settings['pos-rightMenu-overflow'].";
        visibility: ".$tpl_settings['pos-rightMenu-visibility'].";
        text-align: ".$tpl_settings['pos-rightMenu-text-align'].";
        vertical-align: ".$tpl_settings['pos-rightMenu-vertical-align'].";
        margin-top: ".$tpl_settings['pos-rightMenu-marginTop'].";
        margin-bottom: ".$tpl_settings['pos-rightMenu-marginBottom'].";
        position: ".$tpl_settings['pos-rightMenu-position'].";
        background-color: #".$tpl_settings['pos-rightMenu-bgcolor'].";
        height: ".$tpl_settings['pos-rightMenu-height'].";
        z-index: ".$tpl_settings['pos-rightMenu-zindex'].";
        ".$tpl_settings['pos-rightMenu-bg-gradient-longValue']."
        ".$tpl_settings['pos-rightMenu-customCSS-longValue']."
        /* BACKGROUND IMAGE */
        background-image: url('".$tpl_settings['pos-rightMenu-bg-image']."');
        background-repeat:".$tpl_settings['pos-rightMenu-bg-repeat'].";
        background-position:".$tpl_settings['pos-rightMenu-bg-position'].";
        background-attachment:".$tpl_settings['pos-rightMenu-bg-attachment'].";
        background-size: ".$tpl_settings['pos-rightMenu-attachment'].";
    }
    .pos-mainTop
    {   
        -webkit-box-shadow: ".$tpl_settings['pos-mainTop-box-shadow-width']." #".$tpl_settings['pos-mainTop-box-shadow-color'].";
        -moz-box-shadow: ".$tpl_settings['pos-mainTop-box-shadow-width']." #".$tpl_settings['pos-mainTop-box-shadow-color'].";
        box-shadow: ".$tpl_settings['pos-mainTop-box-shadow-width']." #".$tpl_settings['pos-mainTop-box-shadow-color'].";
        border-width: ".$tpl_settings['pos-mainTop-border-width'].";
        border-color: #".$tpl_settings['pos-mainTop-border-color'].";
        border-style: ".$tpl_settings['pos-mainTop-border-style'].";
        border-radius: ".$tpl_settings['pos-mainTop-border-radius'].";
        padding: ".$tpl_settings['pos-mainTop-padding'].";
        overflow: ".$tpl_settings['pos-mainTop-overflow'].";
        visibility: ".$tpl_settings['pos-mainTop-visibility'].";
        text-align: ".$tpl_settings['pos-mainTop-text-align'].";
        vertical-align: ".$tpl_settings['pos-mainTop-vertical-align'].";
        margin-top: ".$tpl_settings['pos-mainTop-marginTop'].";
        margin-bottom: ".$tpl_settings['pos-mainTop-marginBottom'].";
        position: ".$tpl_settings['pos-mainTop-position'].";
        background-color: #".$tpl_settings['pos-mainTop-bgcolor'].";
        width: ".$tpl_settings['pos-mainTop-width'].";
        height: ".$tpl_settings['pos-mainTop-height'].";
        z-index: ".$tpl_settings['pos-mainTop-zindex'].";
        ".$tpl_settings['pos-mainTop-bg-gradient-longValue']."
        ".$tpl_settings['pos-mainTop-customCSS-longValue']."
        /* BACKGROUND IMAGE */
        background-image: url('".$tpl_settings['pos-mainTop-bg-image']."');
        background-repeat:".$tpl_settings['pos-mainTop-bg-repeat'].";
        background-position:".$tpl_settings['pos-mainTop-bg-position'].";
        background-attachment:".$tpl_settings['pos-mainTop-bg-attachment'].";
        background-size: ".$tpl_settings['pos-mainTop-attachment'].";
    }
    .pos-mainTopLeft
    {   
        -webkit-box-shadow: ".$tpl_settings['pos-mainTopLeft-box-shadow-width']." #".$tpl_settings['pos-mainTopLeft-box-shadow-color'].";
        -moz-box-shadow: ".$tpl_settings['pos-mainTopLeft-box-shadow-width']." #".$tpl_settings['pos-mainTopLeft-box-shadow-color'].";
        box-shadow: ".$tpl_settings['pos-mainTopLeft-box-shadow-width']." #".$tpl_settings['pos-mainTopLeft-box-shadow-color'].";
        border-width: ".$tpl_settings['pos-mainTopLeft-border-width'].";
        border-color: #".$tpl_settings['pos-mainTopLeft-border-color'].";
        border-style: ".$tpl_settings['pos-mainTopLeft-border-style'].";
        border-radius: ".$tpl_settings['pos-mainTopLeft-border-radius'].";
        padding: ".$tpl_settings['pos-mainTopLeft-padding'].";
        overflow: ".$tpl_settings['pos-mainTopLeft-overflow'].";
        visibility: ".$tpl_settings['pos-mainTopLeft-visibility'].";
        text-align: ".$tpl_settings['pos-mainTopLeft-text-align'].";
        vertical-align: ".$tpl_settings['pos-mainTopLeft-vertical-align'].";
        margin-top: ".$tpl_settings['pos-mainTopLeft-marginTop'].";
        margin-bottom: ".$tpl_settings['pos-mainTopLeft-marginBottom'].";
        position: ".$tpl_settings['pos-mainTopLeft-position'].";
        background-color: #".$tpl_settings['pos-mainTopLeft-bgcolor'].";
        height: ".$tpl_settings['pos-mainTopLeft-height'].";
        z-index: ".$tpl_settings['pos-mainTopLeft-zindex'].";
        ".$tpl_settings['pos-mainTopLeft-bg-gradient-longValue']."
        ".$tpl_settings['pos-mainTopLeft-customCSS-longValue']."
        /* BACKGROUND IMAGE */
        background-image: url('".$tpl_settings['pos-mainTopLeft-bg-image']."');
        background-repeat:".$tpl_settings['pos-mainTopLeft-bg-repeat'].";
        background-position:".$tpl_settings['pos-mainTopLeft-bg-position'].";
        background-attachment:".$tpl_settings['pos-mainTopLeft-bg-attachment'].";
        background-size: ".$tpl_settings['pos-mainTopLeft-attachment'].";
    }
    .pos-mainTopCenter
    {   
        -webkit-box-shadow: ".$tpl_settings['pos-mainTopCenter-box-shadow-width']." #".$tpl_settings['pos-mainTopCenter-box-shadow-color'].";
        -moz-box-shadow: ".$tpl_settings['pos-mainTopCenter-box-shadow-width']." #".$tpl_settings['pos-mainTopCenter-box-shadow-color'].";
        box-shadow: ".$tpl_settings['pos-mainTopCenter-box-shadow-width']." #".$tpl_settings['pos-mainTopCenter-box-shadow-color'].";
        border-width: ".$tpl_settings['pos-mainTopCenter-border-width'].";
        border-color: #".$tpl_settings['pos-mainTopCenter-border-color'].";
        border-style: ".$tpl_settings['pos-mainTopCenter-border-style'].";
        border-radius: ".$tpl_settings['pos-mainTopCenter-border-radius'].";
        padding: ".$tpl_settings['pos-mainTopCenter-padding'].";
        overflow: ".$tpl_settings['pos-mainTopCenter-overflow'].";
        visibility: ".$tpl_settings['pos-mainTopCenter-visibility'].";
        text-align: ".$tpl_settings['pos-mainTopCenter-text-align'].";
        vertical-align: ".$tpl_settings['pos-mainTopCenter-vertical-align'].";
        margin-top: ".$tpl_settings['pos-mainTopCenter-marginTop'].";
        margin-bottom: ".$tpl_settings['pos-mainTopCenter-marginBottom'].";
        position: ".$tpl_settings['pos-mainTopCenter-position'].";
        background-color: #".$tpl_settings['pos-mainTopCenter-bgcolor'].";
        height: ".$tpl_settings['pos-mainTopCenter-height'].";
        z-index: ".$tpl_settings['pos-mainTopCenter-zindex'].";
        ".$tpl_settings['pos-mainTopCenter-bg-gradient-longValue']."
        ".$tpl_settings['pos-mainTopCenter-customCSS-longValue']."
        /* BACKGROUND IMAGE */
        background-image: url('".$tpl_settings['pos-mainTopCenter-bg-image']."');
        background-repeat:".$tpl_settings['pos-mainTopCenter-bg-repeat'].";
        background-position:".$tpl_settings['pos-mainTopCenter-bg-position'].";
        background-attachment:".$tpl_settings['pos-mainTopCenter-bg-attachment'].";
        background-size: ".$tpl_settings['pos-mainTopCenter-attachment'].";
    }
    .pos-mainTopRight
    {   
        -webkit-box-shadow: ".$tpl_settings['pos-mainTopRight-box-shadow-width']." #".$tpl_settings['pos-mainTopRight-box-shadow-color'].";
        -moz-box-shadow: ".$tpl_settings['pos-mainTopRight-box-shadow-width']." #".$tpl_settings['pos-mainTopRight-box-shadow-color'].";
        box-shadow: ".$tpl_settings['pos-mainTopRight-box-shadow-width']." #".$tpl_settings['pos-mainTopRight-box-shadow-color'].";
        border-width: ".$tpl_settings['pos-mainTopRight-border-width'].";
        border-color: #".$tpl_settings['pos-mainTopRight-border-color'].";
        border-style: ".$tpl_settings['pos-mainTopRight-border-style'].";
        border-radius: ".$tpl_settings['pos-mainTopRight-border-radius'].";
        padding: ".$tpl_settings['pos-mainTopRight-padding'].";
        overflow: ".$tpl_settings['pos-mainTopRight-overflow'].";
        visibility: ".$tpl_settings['pos-mainTopRight-visibility'].";
        text-align: ".$tpl_settings['pos-mainTopRight-text-align'].";
        vertical-align: ".$tpl_settings['pos-mainTopRight-vertical-align'].";
        margin-top: ".$tpl_settings['pos-mainTopRight-marginTop'].";
        margin-bottom: ".$tpl_settings['pos-mainTopRight-marginBottom'].";
        position: ".$tpl_settings['pos-mainTopRight-position'].";
        background-color: #".$tpl_settings['pos-mainTopRight-bgcolor'].";
        height: ".$tpl_settings['pos-mainTopRight-height'].";
        z-index: ".$tpl_settings['pos-mainTopRight-zindex'].";
        ".$tpl_settings['pos-mainTopRight-bg-gradient-longValue']."
        ".$tpl_settings['pos-mainTopRight-customCSS-longValue']."
        /* BACKGROUND IMAGE */
        background-image: url('".$tpl_settings['pos-mainTopRight-bg-image']."');
        background-repeat:".$tpl_settings['pos-mainTopRight-bg-repeat'].";
        background-position:".$tpl_settings['pos-mainTopRight-bg-position'].";
        background-attachment:".$tpl_settings['pos-mainTopRight-bg-attachment'].";
        background-size: ".$tpl_settings['pos-mainTopRight-attachment'].";
    }
    .pos-main
    {   
        -webkit-box-shadow: ".$tpl_settings['pos-main-box-shadow-width']." #".$tpl_settings['pos-main-box-shadow-color'].";
        -moz-box-shadow: ".$tpl_settings['pos-main-box-shadow-width']." #".$tpl_settings['pos-main-box-shadow-color'].";
        box-shadow: ".$tpl_settings['pos-main-box-shadow-width']." #".$tpl_settings['pos-main-box-shadow-color'].";
        border-width: ".$tpl_settings['pos-main-border-width'].";
        border-color: #".$tpl_settings['pos-main-border-color'].";
        border-style: ".$tpl_settings['pos-main-border-style'].";
        border-radius: ".$tpl_settings['pos-main-border-radius'].";
        padding: ".$tpl_settings['pos-main-padding'].";
        overflow: ".$tpl_settings['pos-main-overflow'].";
        visibility: ".$tpl_settings['pos-main-visibility'].";
        text-align: ".$tpl_settings['pos-main-text-align'].";
        vertical-align: ".$tpl_settings['pos-main-vertical-align'].";
        margin-top: ".$tpl_settings['pos-main-marginTop'].";
        margin-bottom: ".$tpl_settings['pos-main-marginBottom'].";
        position: ".$tpl_settings['pos-main-position'].";
        background-color: #".$tpl_settings['pos-main-bgcolor'].";
        width: ".$tpl_settings['pos-main-width'].";
        height: ".$tpl_settings['pos-main-height'].";
        z-index: ".$tpl_settings['pos-main-zindex'].";
        ".$tpl_settings['pos-main-bg-gradient-longValue']."
        ".$tpl_settings['pos-main-customCSS-longValue']."
        /* BACKGROUND IMAGE */
        background-image: url('".$tpl_settings['pos-main-bg-image']."');
        background-repeat:".$tpl_settings['pos-main-bg-repeat'].";
        background-position:".$tpl_settings['pos-main-bg-position'].";
        background-attachment:".$tpl_settings['pos-main-bg-attachment'].";
        background-size: ".$tpl_settings['pos-main-attachment'].";
    }
    .pos-mainBottom
    {   
        -webkit-box-shadow: ".$tpl_settings['pos-mainBottom-box-shadow-width']." #".$tpl_settings['pos-mainBottom-box-shadow-color'].";
        -moz-box-shadow: ".$tpl_settings['pos-mainBottom-box-shadow-width']." #".$tpl_settings['pos-mainBottom-box-shadow-color'].";
        box-shadow: ".$tpl_settings['pos-mainBottom-box-shadow-width']." #".$tpl_settings['pos-mainBottom-box-shadow-color'].";
        border-width: ".$tpl_settings['pos-mainBottom-border-width'].";
        border-color: #".$tpl_settings['pos-mainBottom-border-color'].";
        border-style: ".$tpl_settings['pos-mainBottom-border-style'].";
        border-radius: ".$tpl_settings['pos-mainBottom-border-radius'].";
        padding: ".$tpl_settings['pos-mainBottom-padding'].";
        overflow: ".$tpl_settings['pos-mainBottom-overflow'].";
        visibility: ".$tpl_settings['pos-mainBottom-visibility'].";
        text-align: ".$tpl_settings['pos-mainBottom-text-align'].";
        vertical-align: ".$tpl_settings['pos-mainBottom-vertical-align'].";
        margin-top: ".$tpl_settings['pos-mainBottom-marginTop'].";
        margin-bottom: ".$tpl_settings['pos-mainBottom-marginBottom'].";
        position: ".$tpl_settings['pos-mainBottom-position'].";
        background-color: #".$tpl_settings['pos-mainBottom-bgcolor'].";
        width: ".$tpl_settings['pos-mainBottom-width'].";
        height: ".$tpl_settings['pos-mainBottom-height'].";
        z-index: ".$tpl_settings['pos-mainBottom-zindex'].";
        ".$tpl_settings['pos-mainBottom-bg-gradient-longValue']."
        ".$tpl_settings['pos-mainBottom-customCSS-longValue']."
        /* BACKGROUND IMAGE */
        background-image: url('".$tpl_settings['pos-mainBottom-bg-image']."');
        background-repeat:".$tpl_settings['pos-mainBottom-bg-repeat'].";
        background-position:".$tpl_settings['pos-mainBottom-bg-position'].";
        background-attachment:".$tpl_settings['pos-mainBottom-bg-attachment'].";
        background-size: ".$tpl_settings['pos-mainBottom-attachment'].";
    }
    .pos-mainBottomLeft
    {   
        -webkit-box-shadow: ".$tpl_settings['pos-mainBottomLeft-box-shadow-width']." #".$tpl_settings['pos-mainBottomLeft-box-shadow-color'].";
        -moz-box-shadow: ".$tpl_settings['pos-mainBottomLeft-box-shadow-width']." #".$tpl_settings['pos-mainBottomLeft-box-shadow-color'].";
        box-shadow: ".$tpl_settings['pos-mainBottomLeft-box-shadow-width']." #".$tpl_settings['pos-mainBottomLeft-box-shadow-color'].";
        border-width: ".$tpl_settings['pos-mainBottomLeft-border-width'].";
        border-color: #".$tpl_settings['pos-mainBottomLeft-border-color'].";
        border-style: ".$tpl_settings['pos-mainBottomLeft-border-style'].";
        border-radius: ".$tpl_settings['pos-mainBottomLeft-border-radius'].";
        padding: ".$tpl_settings['pos-mainBottomLeft-padding'].";
        overflow: ".$tpl_settings['pos-mainBottomLeft-overflow'].";
        visibility: ".$tpl_settings['pos-mainBottomLeft-visibility'].";
        text-align: ".$tpl_settings['pos-mainBottomLeft-text-align'].";
        vertical-align: ".$tpl_settings['pos-mainBottomLeft-vertical-align'].";
        margin-top: ".$tpl_settings['pos-mainBottomLeft-marginTop'].";
        margin-bottom: ".$tpl_settings['pos-mainBottomLeft-marginBottom'].";
        position: ".$tpl_settings['pos-mainBottomLeft-position'].";
        background-color: #".$tpl_settings['pos-mainBottomLeft-bgcolor'].";
        height: ".$tpl_settings['pos-mainBottomLeft-height'].";
        z-index: ".$tpl_settings['pos-mainBottomLeft-zindex'].";
        ".$tpl_settings['pos-mainBottomLeft-bg-gradient-longValue']."
        ".$tpl_settings['pos-mainBottomLeft-customCSS-longValue']."
        /* BACKGROUND IMAGE */
        background-image: url('".$tpl_settings['pos-mainBottomLeft-bg-image']."');
        background-repeat:".$tpl_settings['pos-mainBottomLeft-bg-repeat'].";
        background-position:".$tpl_settings['pos-mainBottomLeft-bg-position'].";
        background-attachment:".$tpl_settings['pos-mainBottomLeft-bg-attachment'].";
        background-size: ".$tpl_settings['pos-mainBottomLeft-attachment'].";
    }
    .pos-mainBottomCenter
    {   
        -webkit-box-shadow: ".$tpl_settings['pos-mainBottomCenter-box-shadow-width']." #".$tpl_settings['pos-mainBottomCenter-box-shadow-color'].";
        -moz-box-shadow: ".$tpl_settings['pos-mainBottomCenter-box-shadow-width']." #".$tpl_settings['pos-mainBottomCenter-box-shadow-color'].";
        box-shadow: ".$tpl_settings['pos-mainBottomCenter-box-shadow-width']." #".$tpl_settings['pos-mainBottomCenter-box-shadow-color'].";
        border-width: ".$tpl_settings['pos-mainBottomCenter-border-width'].";
        border-color: #".$tpl_settings['pos-mainBottomCenter-border-color'].";
        border-style: ".$tpl_settings['pos-mainBottomCenter-border-style'].";
        border-radius: ".$tpl_settings['pos-mainBottomCenter-border-radius'].";
        padding: ".$tpl_settings['pos-mainBottomCenter-padding'].";
        overflow: ".$tpl_settings['pos-mainBottomCenter-overflow'].";
        visibility: ".$tpl_settings['pos-mainBottomCenter-visibility'].";
        text-align: ".$tpl_settings['pos-mainBottomCenter-text-align'].";
        vertical-align: ".$tpl_settings['pos-mainBottomCenter-vertical-align'].";
        margin-top: ".$tpl_settings['pos-mainBottomCenter-marginTop'].";
        margin-bottom: ".$tpl_settings['pos-mainBottomCenter-marginBottom'].";
        position: ".$tpl_settings['pos-mainBottomCenter-position'].";
        background-color: #".$tpl_settings['pos-mainBottomCenter-bgcolor'].";
        height: ".$tpl_settings['pos-mainBottomCenter-height'].";
        z-index: ".$tpl_settings['pos-mainBottomCenter-zindex'].";
        ".$tpl_settings['pos-mainBottomCenter-bg-gradient-longValue']."
        ".$tpl_settings['pos-mainBottomCenter-customCSS-longValue']."        
        /* BACKGROUND IMAGE */
        background-image: url('".$tpl_settings['pos-mainBottomCenter-bg-image']."');
        background-repeat:".$tpl_settings['pos-mainBottomCenter-bg-repeat'].";
        background-position:".$tpl_settings['pos-mainBottomCenter-bg-position'].";
        background-attachment:".$tpl_settings['pos-mainBottomCenter-bg-attachment'].";
        background-size: ".$tpl_settings['pos-mainBottomCenter-attachment'].";
    }
    .pos-mainBottomRight
    {   
        -webkit-box-shadow: ".$tpl_settings['pos-mainBottomRight-box-shadow-width']." #".$tpl_settings['pos-mainBottomRight-box-shadow-color'].";
        -moz-box-shadow: ".$tpl_settings['pos-mainBottomRight-box-shadow-width']." #".$tpl_settings['pos-mainBottomRight-box-shadow-color'].";
        box-shadow: ".$tpl_settings['pos-mainBottomRight-box-shadow-width']." #".$tpl_settings['pos-mainBottomRight-box-shadow-color'].";
        border-width: ".$tpl_settings['pos-mainBottomRight-border-width'].";
        border-color: #".$tpl_settings['pos-mainBottomRight-border-color'].";
        border-style: ".$tpl_settings['pos-mainBottomRight-border-style'].";
        border-radius: ".$tpl_settings['pos-mainBottomRight-border-radius'].";
        padding: ".$tpl_settings['pos-mainBottomRight-padding'].";
        overflow: ".$tpl_settings['pos-mainBottomRight-overflow'].";
        visibility: ".$tpl_settings['pos-mainBottomRight-visibility'].";
        text-align: ".$tpl_settings['pos-mainBottomRight-text-align'].";
        vertical-align: ".$tpl_settings['pos-mainBottomRight-vertical-align'].";
        margin-top: ".$tpl_settings['pos-mainBottomRight-marginTop'].";
        margin-bottom: ".$tpl_settings['pos-mainBottomRight-marginBottom'].";
        position: ".$tpl_settings['pos-mainBottomRight-position'].";
        background-color: #".$tpl_settings['pos-mainBottomRight-bgcolor'].";
        height: ".$tpl_settings['pos-mainBottomRight-height'].";
        z-index: ".$tpl_settings['pos-mainBottomRight-zindex'].";
        ".$tpl_settings['pos-mainBottomRight-bg-gradient-longValue']."
        ".$tpl_settings['pos-mainBottomRight-customCSS-longValue']."
        /* BACKGROUND IMAGE */
        background-image: url('".$tpl_settings['pos-mainBottomRight-bg-image']."');
        background-repeat:".$tpl_settings['pos-mainBottomRight-bg-repeat'].";
        background-position:".$tpl_settings['pos-mainBottomRight-bg-position'].";
        background-attachment:".$tpl_settings['pos-mainBottomRight-bg-attachment'].";
        background-size: ".$tpl_settings['pos-mainBottomRight-attachment'].";
    }
    .pos-mainFooter
    {   
        -webkit-box-shadow: ".$tpl_settings['pos-mainFooter-box-shadow-width']." #".$tpl_settings['pos-mainFooter-box-shadow-color'].";
        -moz-box-shadow: ".$tpl_settings['pos-mainFooter-box-shadow-width']." #".$tpl_settings['pos-mainFooter-box-shadow-color'].";
        box-shadow: ".$tpl_settings['pos-mainFooter-box-shadow-width']." #".$tpl_settings['pos-mainFooter-box-shadow-color'].";
        border-width: ".$tpl_settings['pos-mainFooter-border-width'].";
        border-color: #".$tpl_settings['pos-mainFooter-border-color'].";
        border-style: ".$tpl_settings['pos-mainFooter-border-style'].";
        border-radius: ".$tpl_settings['pos-mainFooter-border-radius'].";
        padding: ".$tpl_settings['pos-mainFooter-padding'].";
        overflow: ".$tpl_settings['pos-mainFooter-overflow'].";
        visibility: ".$tpl_settings['pos-mainFooter-visibility'].";
        text-align: ".$tpl_settings['pos-mainFooter-text-align'].";
        vertical-align: ".$tpl_settings['pos-mainFooter-vertical-align'].";
        margin-top: ".$tpl_settings['pos-mainFooter-marginTop'].";
        margin-bottom: ".$tpl_settings['pos-mainFooter-marginBottom'].";
        position: ".$tpl_settings['pos-mainFooter-position'].";
        background-color: #".$tpl_settings['pos-mainFooter-bgcolor'].";
        width: ".$tpl_settings['pos-mainFooter-width'].";
        height: ".$tpl_settings['pos-mainFooter-height'].";
        z-index: ".$tpl_settings['pos-mainFooter-zindex'].";
        ".$tpl_settings['pos-mainFooter-bg-gradient-longValue']."
        ".$tpl_settings['pos-mainFooter-customCSS-longValue']."
        /* BACKGROUND IMAGE */
        background-image: url('".$tpl_settings['pos-mainFooter-bg-image']."');
        background-repeat:".$tpl_settings['pos-mainFooter-bg-repeat'].";
        background-position:".$tpl_settings['pos-mainFooter-bg-position'].";
        background-attachment:".$tpl_settings['pos-mainFooter-bg-attachment'].";
        background-size: ".$tpl_settings['pos-mainFooter-attachment'].";
    }
    .pos-mainFooterLeft
    {   
        -webkit-box-shadow: ".$tpl_settings['pos-mainFooterLeft-box-shadow-width']." #".$tpl_settings['pos-mainFooterLeft-box-shadow-color'].";
        -moz-box-shadow: ".$tpl_settings['pos-mainFooterLeft-box-shadow-width']." #".$tpl_settings['pos-mainFooterLeft-box-shadow-color'].";
        box-shadow: ".$tpl_settings['pos-mainFooterLeft-box-shadow-width']." #".$tpl_settings['pos-mainFooterLeft-box-shadow-color'].";
        border-width: ".$tpl_settings['pos-mainFooterLeft-border-width'].";
        border-color: #".$tpl_settings['pos-mainFooterLeft-border-color'].";
        border-style: ".$tpl_settings['pos-mainFooterLeft-border-style'].";
        border-radius: ".$tpl_settings['pos-mainFooterLeft-border-radius'].";
        padding: ".$tpl_settings['pos-mainFooterLeft-padding'].";
        overflow: ".$tpl_settings['pos-mainFooterLeft-overflow'].";
        visibility: ".$tpl_settings['pos-mainFooterLeft-visibility'].";
        text-align: ".$tpl_settings['pos-mainFooterLeft-text-align'].";
        vertical-align: ".$tpl_settings['pos-mainFooterLeft-vertical-align'].";
        margin-top: ".$tpl_settings['pos-mainFooterLeft-marginTop'].";
        margin-bottom: ".$tpl_settings['pos-mainFooterLeft-marginBottom'].";
        position: ".$tpl_settings['pos-mainFooterLeft-position'].";
        background-color: #".$tpl_settings['pos-mainFooterLeft-bgcolor'].";
        height: ".$tpl_settings['pos-mainFooterLeft-height'].";
        z-index: ".$tpl_settings['pos-mainFooterLeft-zindex'].";
        ".$tpl_settings['pos-mainFooterLeft-bg-gradient-longValue']."
        ".$tpl_settings['pos-mainFooterLeft-customCSS-longValue']."
        /* BACKGROUND IMAGE */
        background-image: url('".$tpl_settings['pos-mainFooterLeft-bg-image']."');
        background-repeat:".$tpl_settings['pos-mainFooterLeft-bg-repeat'].";
        background-position:".$tpl_settings['pos-mainFooterLeft-bg-position'].";
        background-attachment:".$tpl_settings['pos-mainFooterLeft-bg-attachment'].";
        background-size: ".$tpl_settings['pos-mainFooterLeft-attachment'].";
    }
    .pos-mainFooterCenter
    {   
        -webkit-box-shadow: ".$tpl_settings['pos-mainFooterCenter-box-shadow-width']." #".$tpl_settings['pos-mainFooterCenter-box-shadow-color'].";
        -moz-box-shadow: ".$tpl_settings['pos-mainFooterCenter-box-shadow-width']." #".$tpl_settings['pos-mainFooterCenter-box-shadow-color'].";
        box-shadow: ".$tpl_settings['pos-mainFooterCenter-box-shadow-width']." #".$tpl_settings['pos-mainFooterCenter-box-shadow-color'].";
        border-width: ".$tpl_settings['pos-mainFooterCenter-border-width'].";
        border-color: #".$tpl_settings['pos-mainFooterCenter-border-color'].";
        border-style: ".$tpl_settings['pos-mainFooterCenter-border-style'].";
        border-radius: ".$tpl_settings['pos-mainFooterCenter-border-radius'].";
        padding: ".$tpl_settings['pos-mainFooterCenter-padding'].";
        overflow: ".$tpl_settings['pos-mainFooterCenter-overflow'].";
        visibility: ".$tpl_settings['pos-mainFooterCenter-visibility'].";
        text-align: ".$tpl_settings['pos-mainFooterCenter-text-align'].";
        vertical-align: ".$tpl_settings['pos-mainFooterCenter-vertical-align'].";
        margin-top: ".$tpl_settings['pos-mainFooterCenter-marginTop'].";
        margin-bottom: ".$tpl_settings['pos-mainFooterCenter-marginBottom'].";
        position: ".$tpl_settings['pos-mainFooterCenter-position'].";
        background-color: #".$tpl_settings['pos-mainFooterCenter-bgcolor'].";
        height: ".$tpl_settings['pos-mainFooterCenter-height'].";
        z-index: ".$tpl_settings['pos-mainFooterCenter-zindex'].";
        ".$tpl_settings['pos-mainFooterCenter-bg-gradient-longValue']."
        ".$tpl_settings['pos-mainFooterCenter-customCSS-longValue']."
        /* BACKGROUND IMAGE */
        background-image: url('".$tpl_settings['pos-mainFooterCenter-bg-image']."');
        background-repeat:".$tpl_settings['pos-mainFooterCenter-bg-repeat'].";
        background-position:".$tpl_settings['pos-mainFooterCenter-bg-position'].";
        background-attachment:".$tpl_settings['pos-mainFooterCenter-bg-attachment'].";
        background-size: ".$tpl_settings['pos-mainFooterCenter-attachment'].";
    }
    .pos-mainFooterRight
    {   
        -webkit-box-shadow: ".$tpl_settings['pos-mainFooterRight-box-shadow-width']." #".$tpl_settings['pos-mainFooterRight-box-shadow-color'].";
        -moz-box-shadow: ".$tpl_settings['pos-mainFooterRight-box-shadow-width']." #".$tpl_settings['pos-mainFooterRight-box-shadow-color'].";
        box-shadow: ".$tpl_settings['pos-mainFooterRight-box-shadow-width']." #".$tpl_settings['pos-mainFooterRight-box-shadow-color'].";
        border-width: ".$tpl_settings['pos-mainFooterRight-border-width'].";
        border-color: #".$tpl_settings['pos-mainFooterRight-border-color'].";
        border-style: ".$tpl_settings['pos-mainFooterRight-border-style'].";
        border-radius: ".$tpl_settings['pos-mainFooterRight-border-radius'].";
        padding: ".$tpl_settings['pos-mainFooterRight-padding'].";
        overflow: ".$tpl_settings['pos-mainFooterRight-overflow'].";
        visibility: ".$tpl_settings['pos-mainFooterRight-visibility'].";
        text-align: ".$tpl_settings['pos-mainFooterRight-text-align'].";
        vertical-align: ".$tpl_settings['pos-mainFooterRight-vertical-align'].";
        margin-top: ".$tpl_settings['pos-mainFooterRight-marginTop'].";
        margin-bottom: ".$tpl_settings['pos-mainFooterRight-marginBottom'].";
        position: ".$tpl_settings['pos-mainFooterRight-position'].";
        background-color: #".$tpl_settings['pos-mainFooterRight-bgcolor'].";
        height: ".$tpl_settings['pos-mainFooterRight-height'].";
        z-index: ".$tpl_settings['pos-mainFooterRight-zindex'].";
        ".$tpl_settings['pos-mainFooterRight-bg-gradient-longValue']."
        ".$tpl_settings['pos-mainFooterRight-customCSS-longValue']."
        /* BACKGROUND IMAGE */
        background-image: url('".$tpl_settings['pos-mainFooterRight-bg-image']."');
        background-repeat:".$tpl_settings['pos-mainFooterRight-bg-repeat'].";
        background-position:".$tpl_settings['pos-mainFooterRight-bg-position'].";
        background-attachment:".$tpl_settings['pos-mainFooterRight-bg-attachment'].";
        background-size: ".$tpl_settings['pos-mainFooterRight-attachment'].";
    }
    .pos-footer
    {   
        -webkit-box-shadow: ".$tpl_settings['pos-footer-box-shadow-width']." #".$tpl_settings['pos-footer-box-shadow-color'].";
        -moz-box-shadow: ".$tpl_settings['pos-footer-box-shadow-width']." #".$tpl_settings['pos-footer-box-shadow-color'].";
        box-shadow: ".$tpl_settings['pos-footer-box-shadow-width']." #".$tpl_settings['pos-footer-box-shadow-color'].";
        border-width: ".$tpl_settings['pos-footer-border-width'].";
        border-color: #".$tpl_settings['pos-footer-border-color'].";
        border-style: ".$tpl_settings['pos-footer-border-style'].";
        border-radius: ".$tpl_settings['pos-footer-border-radius'].";
        padding: ".$tpl_settings['pos-footer-padding'].";
        overflow: ".$tpl_settings['pos-footer-overflow'].";
        visibility: ".$tpl_settings['pos-footer-visibility'].";
        text-align: ".$tpl_settings['pos-footer-text-align'].";
        vertical-align: ".$tpl_settings['pos-footer-vertical-align'].";
        margin-top: ".$tpl_settings['pos-footer-marginTop'].";
        margin-bottom: ".$tpl_settings['pos-footer-marginBottom'].";
        position: ".$tpl_settings['pos-footer-position'].";
        background-color: #".$tpl_settings['pos-footer-bgcolor'].";
        width: ".$tpl_settings['pos-footer-width'].";
        height: ".$tpl_settings['pos-footer-height'].";
        z-index: ".$tpl_settings['pos-footer-zindex'].";
        ".$tpl_settings['pos-footer-bg-gradient-longValue']."
        ".$tpl_settings['pos-footer-customCSS-longValue']."
        /* BACKGROUND IMAGE */
        background-image: url('".$tpl_settings['pos-footer-bg-image']."');
        background-repeat:".$tpl_settings['pos-footer-bg-repeat'].";
        background-position:".$tpl_settings['pos-footer-bg-position'].";
        background-attachment:".$tpl_settings['pos-footer-bg-attachment'].";
        background-size: ".$tpl_settings['pos-footer-attachment'].";
    }
    .pos-hiddenToolbar
    {   
        -webkit-box-shadow: ".$tpl_settings['pos-hiddenToolbar-box-shadow-width']." #".$tpl_settings['pos-hiddenToolbar-box-shadow-color'].";
        -moz-box-shadow: ".$tpl_settings['pos-hiddenToolbar-box-shadow-width']." #".$tpl_settings['pos-hiddenToolbar-box-shadow-color'].";
        box-shadow: ".$tpl_settings['pos-hiddenToolbar-box-shadow-width']." #".$tpl_settings['pos-hiddenToolbar-box-shadow-color'].";
        border-width: ".$tpl_settings['pos-hiddenToolbar-border-width'].";
        border-color: #".$tpl_settings['pos-hiddenToolbar-border-color'].";
        border-style: ".$tpl_settings['pos-hiddenToolbar-border-style'].";
        border-radius: ".$tpl_settings['pos-hiddenToolbar-border-radius'].";
        padding: ".$tpl_settings['pos-hiddenToolbar-padding'].";
        overflow: ".$tpl_settings['pos-hiddenToolbar-overflow'].";
        visibility: ".$tpl_settings['pos-hiddenToolbar-visibility'].";
        text-align: ".$tpl_settings['pos-hiddenToolbar-text-align'].";
        vertical-align: ".$tpl_settings['pos-hiddenToolbar-vertical-align'].";
        margin-top: ".$tpl_settings['pos-hiddenToolbar-marginTop'].";
        margin-bottom: ".$tpl_settings['pos-hiddenToolbar-marginBottom'].";
        position: ".$tpl_settings['pos-hiddenToolbar-position'].";
        background-color: #".$tpl_settings['pos-hiddenToolbar-bgcolor'].";
        width: ".$tpl_settings['pos-hiddenToolbar-width'].";
        height: ".$tpl_settings['pos-hiddenToolbar-height'].";
        z-index: ".$tpl_settings['pos-hiddenToolbar-zindex'].";
        ".$tpl_settings['pos-hiddenToolbar-bg-gradient-longValue']."
        ".$tpl_settings['pos-hiddenToolbar-customCSS-longValue']."
        /* BACKGROUND IMAGE */
        background-image: url('".$tpl_settings['pos-hiddenToolbar-bg-image']."');
        background-repeat:".$tpl_settings['pos-hiddenToolbar-bg-repeat'].";
        background-position:".$tpl_settings['pos-hiddenToolbar-bg-position'].";
        background-attachment:".$tpl_settings['pos-hiddenToolbar-bg-attachment'].";
        background-size: ".$tpl_settings['pos-hiddenToolbar-attachment'].";
    }
    .pos-debug
    {   
        -webkit-box-shadow: ".$tpl_settings['pos-debug-box-shadow-width']." #".$tpl_settings['pos-debug-box-shadow-color'].";
        -moz-box-shadow: ".$tpl_settings['pos-debug-box-shadow-width']." #".$tpl_settings['pos-debug-box-shadow-color'].";
        box-shadow: ".$tpl_settings['pos-debug-box-shadow-width']." #".$tpl_settings['pos-debug-box-shadow-color'].";
        border-width: ".$tpl_settings['pos-debug-border-width'].";
        border-color: #".$tpl_settings['pos-debug-border-color'].";
        border-style: ".$tpl_settings['pos-debug-border-style'].";
        border-radius: ".$tpl_settings['pos-debug-border-radius'].";
        padding: ".$tpl_settings['pos-debug-padding'].";
        overflow: ".$tpl_settings['pos-debug-overflow'].";
        visibility: ".$tpl_settings['pos-debug-visibility'].";
        text-align: ".$tpl_settings['pos-debug-text-align'].";
        vertical-align: ".$tpl_settings['pos-debug-vertical-align'].";
        margin-top: ".$tpl_settings['pos-debug-marginTop'].";
        margin-bottom: ".$tpl_settings['pos-debug-marginBottom'].";
        position: ".$tpl_settings['pos-debug-position'].";
        background-color: #".$tpl_settings['pos-debug-bgcolor'].";
        width: ".$tpl_settings['pos-debug-width'].";
        height: ".$tpl_settings['pos-debug-height'].";
        z-index: ".$tpl_settings['pos-debug-zindex'].";
        ".$tpl_settings['pos-debug-bg-gradient-longValue']."
        ".$tpl_settings['pos-debug-customCSS-longValue']."
        /* BACKGROUND IMAGE */
        background-image: url('".$tpl_settings['pos-debug-bg-image']."');
        background-repeat:".$tpl_settings['pos-debug-bg-repeat'].";
        background-position:".$tpl_settings['pos-debug-bg-position'].";
        background-attachment:".$tpl_settings['pos-debug-bg-attachment'].";
        background-size: ".$tpl_settings['pos-debug-attachment'].";
    }
    .pos-outerBottom
    {   
        -webkit-box-shadow: ".$tpl_settings['pos-outerBottom-box-shadow-width']." #".$tpl_settings['pos-outerBottom-box-shadow-color'].";
        -moz-box-shadow: ".$tpl_settings['pos-outerBottom-box-shadow-width']." #".$tpl_settings['pos-outerBottom-box-shadow-color'].";
        box-shadow: ".$tpl_settings['pos-outerBottom-box-shadow-width']." #".$tpl_settings['pos-outerBottom-box-shadow-color'].";
        border-width: ".$tpl_settings['pos-outerBottom-border-width'].";
        border-color: #".$tpl_settings['pos-outerBottom-border-color'].";
        border-style: ".$tpl_settings['pos-outerBottom-border-style'].";
        border-radius: ".$tpl_settings['pos-outerBottom-border-radius'].";
        padding: ".$tpl_settings['pos-outerBottom-padding'].";
        overflow: ".$tpl_settings['pos-outerBottom-overflow'].";
        visibility: ".$tpl_settings['pos-outerBottom-visibility'].";
        text-align: ".$tpl_settings['pos-outerBottom-text-align'].";
        vertical-align: ".$tpl_settings['pos-outerBottom-vertical-align'].";
        margin-top: ".$tpl_settings['pos-outerBottom-marginTop'].";
        margin-bottom: ".$tpl_settings['pos-outerBottom-marginBottom'].";
        position: ".$tpl_settings['pos-outerBottom-position'].";
        background-color: #".$tpl_settings['pos-outerBottom-bgcolor'].";
        width: ".$tpl_settings['pos-outerBottom-width'].";
        height: ".$tpl_settings['pos-outerBottom-height'].";
        z-index: ".$tpl_settings['pos-outerBottom-zindex'].";
        ".$tpl_settings['pos-outerBottom-bg-gradient-longValue']."
        ".$tpl_settings['pos-outerBottom-customCSS-longValue']."
        /* BACKGROUND IMAGE */
        background-image: url('".$tpl_settings['pos-outerBottom-bg-image']."');
        background-repeat:".$tpl_settings['pos-outerBottom-bg-repeat'].";
        background-position:".$tpl_settings['pos-outerBottom-bg-position'].";
        background-attachment:".$tpl_settings['pos-outerBottom-bg-attachment'].";
        background-size: ".$tpl_settings['pos-outerBottom-attachment'].";
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
                    <!-- 16:9 aspect ratio -->
                    <div class="embed-responsive embed-responsive-4by3">
                        <iframe id="preview" class="embed-responsive-item" src="../index.php"></iframe>
                    </div>
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
            <!-- list POSITION SETTINGS -->
            <div class="row animated fadeIn">

                <div class="col-md-3">
                    <div class="box box-with-border" id="posboxSettings">
                        <div class="box-body">
                            <div id="selectPositionRequestInfo">
                                <h4 class="box-title"><?php echo "$lang[TPL_SELECT_POSITIONS_REQUEST]"; ?></h4>
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
                        if ($templateSettings['pos-outerTop-enabled']['value'] === "1")
                        {   $outerTopEnabled = $enabledBorder; }
                        else
                        {   $outerTopEnabled = ''; }

                        if ($templateSettings['pos-intro-enabled']['value'] === "1")
                        {   $introEnabled = $enabledBorder; }
                        else
                        {   $introEnabled = ''; }

                        if ($templateSettings['pos-outerLeft-enabled']['value'] === "1")
                        {   $outerLeftEnabled = $enabledBorder; }
                        else
                        {   $outerLeftEnabled = ''; }

                        if ($templateSettings['pos-globalmenu-enabled']['value'] === "1")
                        {   $globalmenuEnabled = $enabledBorder; }
                        else
                        {   $globalmenuEnabled = ''; }

                        if ($templateSettings['pos-top-enabled']['value'] === "1")
                        {   $topEnabled = $enabledBorder; }
                        else
                        {   $topEnabled = ''; }

                        if ($templateSettings['pos-leftMenu-enabled']['value'] === "1")
                        {   $leftMenuEnabled = $enabledBorder; }
                        else
                        {   $leftMenuEnabled = ''; }

                        if ($templateSettings['pos-mainTop-enabled']['value'] === "1")
                        {   $mainTopEnabled = $enabledBorder; }
                        else
                        {   $mainTopEnabled = ''; }

                        if ($templateSettings['pos-mainTopLeft-enabled']['value'] === "1")
                        {   $mainTopLeftEnabled = $enabledBorder; }
                        else
                        {   $mainTopLeftEnabled = ''; }

                        if ($templateSettings['pos-mainTopCenter-enabled']['value'] === "1")
                        {   $mainTopCenterEnabled = $enabledBorder; }
                        else
                        {   $mainTopCenterEnabled = ''; }

                        if ($templateSettings['pos-mainTopRight-enabled']['value'] === "1")
                        {   $mainTopRightEnabled = $enabledBorder; }
                        else
                        {   $mainTopRightEnabled = ''; }

                        if ($templateSettings['pos-main-enabled']['value'] === "1")
                        {   $mainEnabled = $enabledBorder; }
                        else
                        {   $mainEnabled = ''; }

                        if ($templateSettings['pos-mainBottom-enabled']['value'] === "1")
                        {   $mainBottomEnabled = $enabledBorder; }
                        else
                        {   $mainBottomEnabled = ''; }

                        if ($templateSettings['pos-mainBottomLeft-enabled']['value'] === "1")
                        {   $mainBottomLeftEnabled = $enabledBorder; }
                        else
                        {   $mainBottomLeftEnabled = ''; }

                        if ($templateSettings['pos-mainBottomCenter-enabled']['value'] === "1")
                        {   $mainBottomCenterEnabled = $enabledBorder; }
                        else
                        {   $mainBottomCenterEnabled = ''; }

                        if ($templateSettings['pos-mainBottomRight-enabled']['value'] === "1")
                        {   $mainBottomRightEnabled = $enabledBorder; }
                        else
                        {   $mainBottomRightEnabled = ''; }

                        if ($templateSettings['pos-mainFooter-enabled']['value'] === "1")
                        {   $mainFooterEnabled = $enabledBorder; }
                        else
                        {   $mainFooterEnabled = ''; }

                        if ($templateSettings['pos-mainFooterLeft-enabled']['value'] === "1")
                        {   $mainFooterLeftEnabled = $enabledBorder; }
                        else
                        {   $mainFooterLeftEnabled = ''; }

                        if ($templateSettings['pos-mainFooterCenter-enabled']['value'] === "1")
                        {   $mainFooterCenterEnabled = $enabledBorder; }
                        else
                        {   $mainFooterCenterEnabled = ''; }

                        if ($templateSettings['pos-mainFooterRight-enabled']['value'] === "1")
                        {   $mainFooterRightEnabled = $enabledBorder; }
                        else
                        {   $mainFooterRightEnabled = ''; }

                        if ($templateSettings['pos-rightMenu-enabled']['value'] === "1")
                        {   $rightMenuEnabled = $enabledBorder; }
                        else
                        {   $rightMenuEnabled = ''; }

                        if ($templateSettings['pos-footer-enabled']['value'] === "1")
                        {   $footerEnabled = $enabledBorder; }
                        else
                        {   $footerEnabled = ''; }

                        if ($templateSettings['pos-hiddenToolbar-enabled']['value'] === "1")
                        {   $hiddenToolbarEnabled = $enabledBorder; }
                        else
                        {   $hiddenToolbarEnabled = ''; }

                        if ($templateSettings['pos-debug-enabled']['value'] === "1")
                        {   $debugEnabled = $enabledBorder; }
                        else
                        {   $debugEnabled = ''; }

                        if ($templateSettings['pos-outerRight-enabled']['value'] === "1")
                        {   $outerRightEnabled = $enabledBorder; }
                        else
                        {   $outerRightEnabled = ''; }

                        if ($templateSettings['pos-outerBottom-enabled']['value'] === "1")
                        {   $outerBottomEnabled = $enabledBorder; }
                        else
                        {   $outerBottomEnabled = ''; }
                        ?>

                        <div class="box-body">
                            <div class="container-fluid">
                                <div class="row text-center">
                                    <div class="col-md-12 posbox" id="pos_outerTop" style="height: 30px; margin-bottom:5px; width: 100%; text-align: center; <?php echo $outerTopEnabled; ?>">&laquo;outerTop&raquo;</div>
                                </div>
                                <div class="row text-center">
                                    <div class="col-md-2 posbox" id="pos_outerLeft" style="height: 630px; margin-bottom:5px; text-align: center; <?php echo $outerLeftEnabled; ?>">&laquo;outerLeft&raquo;</div>
                                    <div class="col-md-8">
                                        <div class="row">
                                            <div class="col-md-12 posbox" id="pos_intro" style="height: 30px; margin-bottom:5px; width: 100%; text-align: center; <?php echo $introEnabled; ?>">&laquo;intro&raquo;</div>
                                            <div class="col-md-12 posbox" id="pos_globalmenu" style="height: 30px; margin-bottom:5px; width: 100%; text-align: center; <?php echo $globalmenuEnabled; ?>">&laquo;globalmenu&raquo;</div>
                                            <div class="col-md-12 posbox" id="pos_top" style="height: 30px; margin-bottom:5px; width: 100%; text-align: center; <?php echo $topEnabled; ?>">&laquo;top&raquo;</div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-2 posbox" id="pos_leftMenu" style="height: 410px; margin-bottom:5px; text-align: center; <?php echo $leftMenuEnabled; ?>">&laquo;leftMenu&raquo;</div>
                                            <div class="col-md-8" style="height: auto; margin-bottom:5px; text-align: center;">
                                                <div class="row">
                                                    <div class="col-md-12 posbox" id="pos_mainTop" style="height: 30px; margin-bottom:5px; text-align: center; <?php echo $mainTopEnabled; ?>">&laquo;mainTop&raquo;</div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4 posbox" id="pos_mainTopLeft" style="height: 30px; margin-bottom:5px; text-align: center; <?php echo $mainTopLeftEnabled; ?>">&laquo;mainTopLeft&raquo;</div>
                                                    <div class="col-md-4 posbox" id="pos_mainTopCenter" style="height: 30px; margin-bottom:5px; text-align: center; <?php echo $mainTopCenterEnabled; ?>">&laquo;mainTopCenter&raquo;</div>
                                                    <div class="col-md-4 posbox" id="pos_mainTopRight" style="height: 30px; margin-bottom:5px; text-align: center; <?php echo $mainTopRightEnabled; ?>">&laquo;mainTopRight&raquo;</div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-12 posbox" id="pos_main" style="height: 200px; margin-bottom:5px; text-align: center; <?php echo $mainEnabled; ?>">&laquo;main&raquo;</div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12 posbox" id="pos_mainBottom" style="height: 30px; margin-bottom:5px; text-align: center; <?php echo $mainBottomEnabled; ?>">&laquo;mainBottom&raquo;</div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4 posbox" id="pos_mainBottomLeft" style="height: 30px; margin-bottom:5px; text-align: center; <?php echo $mainBottomLeftEnabled; ?>">&laquo;mainBottomLeft&raquo;</div>
                                                    <div class="col-md-4 posbox" id="pos_mainBottomCenter" style="height: 30px; margin-bottom:5px; text-align: center; <?php echo $mainBottomCenterEnabled; ?>">&laquo;mainBottomCenter&raquo;</div>
                                                    <div class="col-md-4 posbox" id="pos_mainBottomRight" style="height: 30px; margin-bottom:5px; text-align: center; <?php echo $mainBottomRightEnabled; ?>">&laquo;mainBottomRight&raquo;</div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12 posbox" id="pos_mainFooter" style="height: 30px; margin-bottom:5px; text-align: center; <?php echo $mainFooterEnabled; ?>">&laquo;mainFooter&raquo;</div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4 posbox" id="pos_mainFooterLeft" style="height: 30px; margin-bottom:5px; text-align: center; <?php echo $mainFooterLeftEnabled; ?>">&laquo;mainFooterLeft&raquo;</div>
                                                    <div class="col-md-4 posbox" id="pos_mainFooterCenter" style="height: 30px; margin-bottom:5px; text-align: center; <?php echo $mainFooterCenterEnabled; ?>">&laquo;mainFooterCenter&raquo;</div>
                                                    <div class="col-md-4 posbox" id="pos_mainFooterRight" style="height: 30px; margin-bottom:5px; text-align: center; <?php echo $mainFooterRightEnabled; ?>">&laquo;mainFooterRight&raquo;</div>
                                                </div>
                                            </div>
                                            <div class="col-md-2 posbox" id="pos_rightMenu" style="height: 410px; margin-bottom:5px; text-align: center; <?php echo $rightMenuEnabled; ?>">&laquo;rightMenu&raquo;</div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-12 posbox" id="pos_footer" style="height: 30px; margin-bottom:5px; text-align: center; <?php echo $footerEnabled; ?>">&laquo;footer&raquo;</div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12 posbox" id="pos_hiddenToolbar" style="height: 30px; margin-bottom:5px; text-align: center; <?php echo $hiddenToolbarEnabled; ?>">&laquo;hiddenToolbar&raquo;</div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12 posbox" id="pos_debug" style="height: 30px; margin-bottom:5px; text-align: center; <?php echo $debugEnabled; ?>">&laquo;debug&raquo;</div>
                                        </div>
                                    </div>
                                    <div class="col-md-2 posbox" id="pos_outerRight" style="height: 630px; margin-bottom:5px; text-align: center; <?php echo $outerRightEnabled; ?>">&laquo;outerRight&raquo;</div>

                                </div>

                                <div class="row text-center">
                                    <div class="col-md-12 posbox" id="pos_outerBottom" style="height: 30px; margin-bottom:5px; width: 100%; text-align: center; <?php echo $outerBottomEnabled; ?>">&laquo;outerBottom&raquo;</div>
                                </div>
                            </div>
                        </div>
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
