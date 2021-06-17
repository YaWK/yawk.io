<?php
use YAWK\alert;
use YAWK\backend;
use YAWK\db;
use YAWK\language;
use YAWK\settings;
use YAWK\sys;
/** @var $db db */
/** @var $lang language */

// SAVE tpl settings
if(isset($_POST['save']))
{
    if (isset($_POST['robotsText-long']) && (!empty($_POST['robotsText-long'])))
    {
        if (settings::setLongSetting($db, "robotsText-long", $_POST['robotsText-long']))
        {
          //  \YAWK\alert::draw("success", $lang['SUCCESS'], "$lang[ROBOTS_TXT] $lang[DATABASE] $lang[SAVED]", "", 2400);
        }
        else
            {
                alert::draw("danger", $lang['ERROR'], "$lang[ROBOTS_TXT] $lang[DATABASE] $lang[NOT_SAVED]", "", 2400);
            }

        if (sys::setRobotsText("../", $_POST['robotsText-long']))
        {
            alert::draw("success", $lang['SUCCESS'], "$lang[ROBOTS_TXT] $lang[SAVED]", "", 2400);
        }
        else
        {
            alert::draw("danger", $lang['ERROR'], "$lang[ROBOTS_TXT] $lang[NOT_SAVED]", "", 3400);
        }
    }

// force page reload to show changes immediately
// \YAWK\sys::setTimeout("index.php?page=settings-frontend", 0);
}

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
<script type="text/javascript">
    $(document).ready(function() {
        // textarea that will be transformed into editor
        var editor = ('textarea#summernote');
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

            toolbar:
                {
                    // no toolbar
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
            }
        }); // end summernote
    }); // end document ready
</script>

<?php
// TEMPLATE WRAPPER - HEADER & breadcrumbs
echo "
    <!-- Content Wrapper. Contains page content -->
    <div class=\"content-wrapper\" id=\"content-FX\">
    <!-- Content Header (Page header) -->
    <section class=\"content-header\">";
// draw Title on top
echo backend::getTitle($lang['SETTINGS'], $lang['ROBOTS_TXT']);
echo backend::getSettingsBreadcrumbs($lang);
echo"</section><!-- Main content -->
    <section class=\"content\">";
/* page content start here */
?>
<form id="frontend-edit-form" action="index.php?page=settings-robots" method="POST">
    <div class="box">
        <div class="box-body">
            <div class="col-md-10">
                <?php echo "<h4><i class=\"fa fa-android\"></i> &nbsp;$lang[ROBOTS_TXT]&nbsp;<small>$lang[CONFIGURE]</small></h4>"; ?>
            </div>
            <div class="col-md-2">
                <button class="btn btn-success pull-right" id="save" name="save" style="margin-top:2px;"><i id="savebuttonIcon" class="fa fa-check"></i>&nbsp;&nbsp;<?php echo $lang['SAVE_SETTINGS']; ?></button>
            </div>
        </div>
    </div>

    <!-- ROBOTS.TXT -->
    <div class="row">
            <div class="col-md-8">
                <div class="box">
                    <div class="box-body">
                        <label for="summernote"><?php echo $lang['DATA_PRIVACY']."&nbsp;&amp;&nbsp;".$lang['PRIVACY']; ?>  - <small><?php echo $lang['ROBOTS_SUBTEXT']; ?> </small></label>
                        <?php $content = sys::getRobotsText($db, "../"); ?>
                        <textarea name="robotsText-long" cols="64" rows="28" id="summernote"><?php echo $content; ?></textarea>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title"><?php echo $lang['ROBOTS_TXT']; ?> <small> <?php echo $lang['HELP']; ?></small></h3>
                    </div>
                    <div class="box-body">
                        <?php // \YAWK\settings::getFormElements($db, $settings, 0, $lang); ?>
                    </div>
                </div>
            </div>
    </div>
</form>
<script type="text/javascript">
$(document).ready(function() {
        function saveHotkey() {
            // simply disables save event for chrome
            $(window).keypress(function (event) {
                if (!(event.which === 115 && (navigator.platform.match("Mac") ? event.metaKey : event.ctrlKey)) && !(event.which === 19)) return true;
                event.preventDefault();
                $('#save').click(); // SAVE FORM AFTER PRESSING STRG-S hotkey
                formmodified = 0; // do not warn user, just save.
                return false;
            });
            // used to process the cmd+s and ctrl+s events
            $(document).keydown(function (event) {
                if (event.which === 83 && (navigator.platform.match("Mac") ? event.metaKey : event.ctrlKey)) {
                    event.preventDefault();
                    $('#save').click(); // SAVE FORM AFTER PRESSING STRG-S hotkey
                    formmodified = 0; // do not warn user, just save.
                    // save(event);
                    return false;
                }
            });
        }
        saveHotkey();

    // textarea that will be transformed into editor
    var savebutton = ('#save');
    var savebuttonIcon = ('#savebuttonIcon');
    // textarea that will be transformed into editor
    var editor = ('textarea#summernote');
    // ok, lets go...
    // we need to check if user clicked on save button
    $(savebutton).click(function () {
        $(savebutton).removeClass('btn btn-success').addClass('btn btn-warning disabled');
        $(savebuttonIcon).removeClass('fa fa-check').addClass('fa fa-spinner fa-spin fa-fw');

        if ($(editor).summernote('codeview.isActivated')) {
            // if so, turn it off.
            $(editor).summernote('codeview.deactivate');
        }
    });
});
</script>