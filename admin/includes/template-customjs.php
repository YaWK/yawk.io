<?php

use YAWK\backend;
use YAWK\db;
use YAWK\language;
use YAWK\settings;
use YAWK\template;
use YAWK\user;

/** @var $db db */
/** @var $lang language */

// new template object if not exists
if (!isset($template)) { $template = new template(); }

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
            if ($_GET['action'] === "template-customjs")
            {
                if (isset($_POST['customJS']) && (!empty($_POST['customJS'])))
                {
                    // save the content to /system/template/$NAME/css/custom.css
                    $template->setCustomJsFile($db, $_POST['customJS'], 0, $_GET['id']);
                    // save a minified version to /system/template/$NAME/css/custom.min.css
                    $template->setCustomJsFile($db, $_POST['customJS'], 1, $_GET['id']);
                }
            }
        }
    }
}
?>
<?php
// get settings for editor
$editorSettings = settings::getEditorSettings($db, 14);
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

<script type="text/javascript">
    $(document).ready(function() {
        // TRY TO DISABLE CTRL-S browser hotkey
        function saveHotkey() {
            // simply disables save event for chrome
            $(window).keypress(function (event) {
                if (!(event.which === 115 && (navigator.platform.match("Mac") ? event.metaKey : event.ctrlKey)) && !(event.which === 19)) return true;
                $('#savebutton').click(); // SAVE FORM AFTER PRESSING STRG-S hotkey
                event.preventDefault();
                formmodified=0; // do not warn user, just save.
                return false;
            });
            // used to process the cmd+s and ctrl+s events
            $(document).keydown(function (event) {
                if (event.which === 83 && (navigator.platform.match("Mac") ? event.metaKey : event.ctrlKey)) {
                    event.preventDefault();
                    $('#savebutton').click(); // SAVE FORM AFTER PRESSING STRG-S hotkey
                    formmodified=0; // do not warn user, just save.
                    // save(event);
                    return false;
                }
            });
        }
        saveHotkey();

        // textarea that will be transformed into editor
        const editor = ('textarea#summernote');
        const savebutton = ('#savebutton');
        const savebuttonIcon = ('#savebuttonIcon');
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
            const text = $(editor).val();
            // search for <img> tags and revert src ../ to set correct path for frontend
            const frontend = text.replace(/<img src=\"..\/media/g,"<img src=\"media");
            // put the new string back into <textarea>
            $(editor).val(frontend); // to make sure that saving works
        });

        // BEFORE SUMMERNOTE loads: 3 important lines of code!
        // to display images in backend correctly, we need to change the path of every image.
        // procedure is the same as above (see #savebutton.click)
        // get the value of summernote textarea
        const text = $(editor).val();
        // search for <img> tags and update src ../ to get images viewed in summernote
        const backend = text.replace(/<img src=\"media/g,"<img src=\"../media");
        // put the new string back into <textarea>
        $(editor).val(backend); // set new value into textarea

        // summernote.init -
        // LOAD SUMMERNOTE IN CODEVIEW ON STARTUP
        $(editor).on('summernote.init', function() {
            // toggle editor to codeview
            $(editor).summernote('codeview.toggle');
        });

        // INIT SUMMERNOTE EDITOR
        $(editor).summernote({           // set editor itself
            height: <?php echo $editorSettings['editorHeight']; ?>,                 // set editor height
            minHeight: null,             // set minimum height of editor
            maxHeight: null,             // set maximum height of editor
            focus: true,                 // set focus to editable area after initializing summernote
            toolbar: [
                // load an empty toolbar.
                // in that case: just a plain code editor. no mice cinema.
            ],
            // language for plugin image-attributes.js
            lang: '<?php echo $lang['CURRENT_LANGUAGE']; ?>',

            // powerup the codeview with codemirror theme
            codemirror: { // codemirror options
                theme: '<?php echo $editorSettings['editorTheme']; ?>',                       // codeview theme
                lineNumbers: true,                                                            // display lineNumbers true|false
                undoDepth: <?php echo $editorSettings['editorUndoDepth']; ?>,                 // how many undo steps should be saved? (default: 200)
                smartIndent: <?php echo $editorSettings['editorSmartIndent']; ?>,             // better indent
                indentUnit: <?php echo $editorSettings['editorIndentUnit']; ?>,               // how many spaces auto indent? (default: 2)
                scrollbarStyle: null,                                                         // styling of the scrollbars
                matchBrackets: <?php echo $editorSettings['editorMatchBrackets']; ?>,         // highlight corresponding brackets
                autoCloseBrackets: <?php echo $editorSettings['editorCloseBrackets'];?>,      // auto insert close brackets
                autoCloseTags: <?php echo $editorSettings['editorCloseTags']; ?>,             // auto insert close tags after opening
                value: "<html>\n  " + document.documentElement.innerHTML + "\n</html>",       // all html
                mode: "javascript",                                                      // editor mode
                matchTags: {bothTags: <?php echo $editorSettings['editorMatchTags']; ?>},     // hightlight matching tags: both
                extraKeys: {
                    "Ctrl-J": "toMatchingTag",                                                // CTRL-J to jump to next matching tab
                    "Ctrl-Space": "autocomplete"                                              // CTRL-SPACE to open autocomplete window
                },
                styleActiveLine: <?php echo $editorSettings['editorActiveLine']; ?>,          // highlight the active line (where the cursor is)
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
if (!isset($template)) { $template = new template(); }
// new user object if not exists
if (!isset($user)) { $user = new user($db); }

// load properties of current active template
// get ID of current active template
$getID = settings::getSetting($db, "selectedTemplate");
// load properties of current active template
$template->loadProperties($db, $getID);
?>

<?php
// TEMPLATE WRAPPER - HEADER & breadcrumbs
echo "
    <!-- Content Wrapper. Contains page content -->
    <div class=\"content-wrapper\" id=\"content-FX\">
    <!-- Content Header (Page header) -->
    <section class=\"content-header\">";
// draw Title on top
echo backend::getTitle($lang['TPL'], "custom.js");
echo backend::getTemplateBreadcrumbs($lang);
echo"</section><!-- Main content -->
    <section class=\"content\">";
/* page content start here */
?>
<form id="template-edit-form" action="index.php?page=template-customjs&action=template-customjs&id=<?php echo $getID; ?>" method="POST">
    <!-- title header -->
    <!-- REDESIGN -->
    <div class="box">
        <div class="box-body">
            <div class="col-md-10">
                <?php echo "<h4><i class=\"fa fa-code\"></i> &nbsp;$lang[CUSTOM_JS] <small>$lang[TPL_CUSTOMJS_SUBTEXT]</small></h4>"; ?>
            </div>
            <div class="col-md-2">
                <button class="btn btn-success pull-right" id="savebutton" name="save" style="margin-top:2px;"><i class="fa fa-check" id="savebuttonIcon"></i>&nbsp;&nbsp;<?php echo $lang['CUSTOM_JS_SAVE']; ?></button>
            </div>
        </div>
    </div>

    <!-- CUSTOM JS -->
    <div class="row">
        <div class="col-md-8 animated fadeIn">
            <?php $customJS = $template->getCustomJSFile($db, $template->id); ?>
            <textarea name="customJS" cols="64" rows="28" id="summernote"><?php echo $customJS; ?></textarea>
            <label for="summernote"><small><?php echo $lang['YOU_EDIT']; ?>:</small> &nbsp;system/templates/<?php echo $template->name; ?>/js/custom.js</label>
        </div>
        <div class="col-md-4">
            <div class="box box-default">
                <div class="box-header with-border">
                    <h3 class="box-title"><?php echo $template->name; ?>/js/custom.js</h3>
                </div>
                <div class="box-body">
                    <?php echo $lang['CUSTOM_JS_DESC']; ?>
                    <br><br>
                    <i><?php echo $lang['CUSTOM_JS_HELP']; ?></i><br>
                    &raquo; <a href="http://www.w3schools.com/js/" title="open JS overview in new TAB" target="_blank">w3schools.com/js/</a>

                    <hr>
                    <b><i class="fa fa-lightbulb-o"></i> <?php echo $lang['DID_YOU_KNOW']; ?></b><br>
                    <i><?php echo $lang['TIP_STRG_S']; ?></i>
                </div>

            </div>
        </div>
    </div>
</form>