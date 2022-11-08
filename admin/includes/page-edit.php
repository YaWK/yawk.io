<?php
// IMPORT REQUIRED CLASSES
use YAWK\backend;
use YAWK\db;
use YAWK\language;
use YAWK\settings;
use YAWK\sys;
use YAWK\user;
use YAWK\widget;

// CHECK REQUIRED OBJECTS
if (!isset($page)) // if no page object is set
{   // create new page object
    $page = new YAWK\page();
}
if (!isset($db))
{   // create database object
    $db = new db();
}
if (!isset($lang))
{   // create language object
    $lang = new language();
}

if (isset($_GET['id'])){
    $id = $db->quote($_GET['id']);
    $page->loadPropertiesByID($db,$id);
}
if(isset($_POST['save'])){
    $page->deleteContent("../");
    $page->id = $db->quote($_POST['id']);
    $page->gid = $db->quote($_POST['gid']);
    $page->title = $db->quote($_POST['title']);
    $page->alias = $db->quote($_POST['alias']);
    $page->searchstring = $db->quote($_POST['searchstring']);
    $page->published = $db->quote($_POST['published']);
    $page->date_publish = $db->quote($_POST['date_publish']);
    $page->date_unpublish = $db->quote($_POST['date_unpublish']);
    $page->bgimage = $db->quote($_POST['bgimage']);
    $page->language = $db->quote($_POST['language']);
    $page->meta_local = $db->quote($_POST['meta_local']);
    $page->meta_keywords = $db->quote($_POST['meta_keywords']);
    // after preparing the vars, update db + write content
    if($page->save($db)) {
        // encode chars
        //  $_POST['content'] = \YAWK\sys::encodeChars($_POST['content']);
        $_POST['content'] = utf8_encode($_POST['content']);
        $_POST['content'] = utf8_decode($_POST['content']);
        // write content to file
        if ($page->writeContent(stripslashes(str_replace('\r\n', '', ($_POST['content']))))) {
            print YAWK\alert::draw("success", "$lang[SUCCESS]", "$lang[PAGE_SAVED]","", 800);
        }
        else {
            print YAWK\alert::draw("warning", "$lang[ERROR]", "$lang[FILE] $page->alias $lang[NOT_SAVED]. $lang[CHECK_CHMOD]", "", "8200");

        }
    }
    else {
        print YAWK\alert::draw("warning", "$lang[ERROR]", "$lang[PAGE_DB_FAILED] $page->alias $lang[DB_WRITE_FAILED]", "", "8200");
    }
}
// path to cms
$dirprefix = YAWK\sys::getDirPrefix($db);
// path to cms
$host = YAWK\sys::getHost($db);

/* alias string manipulation */
$page->alias = mb_strtolower($page->alias); // lowercase
$page->alias = str_replace(" ", "-", $page->alias); // replace all ' ' with -
// special chars
$specialChars = array("/ä/", "/ü/", "/ö/", "/Ä/", "/Ü/", "/Ö/", "/ß/"); // array of special chars
$replacedChars = array("ae", "ue", "oe", "ae", "ue", "oe", "ss"); // array of replacement chars
$page->alias = preg_replace($specialChars, $replacedChars, $page->alias);        // replace with preg
$page->alias = preg_replace("/[^a-z0-9\-\/]/i", "", $page->alias); // final check: just numbers and chars are allowed

// make sure that user cannot change index' article name (index.php/html)
if ($page->alias === "index") { $readonly = "readonly"; }
?>

<!-- bootstrap date-timepicker -->
<link type="text/css" href="../system/engines/datetimepicker/css/datetimepicker.min.css" rel="stylesheet">
<script type="text/javascript" src="../system/engines/datetimepicker/js/bootstrap-datetimepicker.min.js"></script>


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
<script src="../system/engines/summernote/dist/summernote-image-attributes.js"></script>
<script src="../system/engines/summernote/dist/summernote-floats-bs.js"></script>

<script type="text/javascript">
    function saveHotkey() {
        // simply disables save event for chrome
        $(window).keypress(function (event) {
            if (!(event.which === 115 && (navigator.platform.match("Mac") ? event.metaKey : event.ctrlKey)) && !(event.which === 19)) return true;
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
            if ( $(editor).length) {    // check if element exists in dom to load editor correctly
                var text = $(editor).val();
                // search for <img> tags and revert src ../ to set correct path for frontend
                var frontend = text.replace(/<img src=\x22..\/media/g,"<img src=\x22media");
                // put the new string back into <textarea>
                $(editor).val(frontend); // to make sure that saving works
            }

        });

        // BEFORE SUMMERNOTE loads: 3 important lines of code!
        // to display images in backend correctly, we need to change the path of every image.
        // procedure is the same as above (see #savebutton.click)
        // get the value of summernote textarea

        if ( $(editor).length) {    // check if element exists in dom to load editor correctly
            var text = $(editor).val();
            // search for <img> tags and update src ../ to get images viewed in summernote
            var backend = text.replace(/<img src=\x22media/g, "<img src=\x22../media");
            // put the new string back into <textarea>
            $(editor).val(backend); // set new value into textarea
        }

        <?php
        if ($editorSettings['editorAutoCodeview'] === "true")
        {
            // summernote.init -
            // LOAD SUMMERNOTE IN CODEVIEW ON STARTUP
            echo "$(editor).on('summernote.init', function() {
                // toggle editor to codeview
                $(editor).summernote('codeview.toggle');
            });";
        }
        ?>

        // INIT SUMMERNOTE EDITOR
        $("#summernote").summernote({    // set editor itself
            height: <?php echo $editorSettings['editorHeight']; ?>,                 // set editor height
            minHeight: null,             // set minimum height of editor
            maxHeight: null,             // set maximum height of editor
            focus: true,                 // set focus to editable area after initializing summernote

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
                lineNumbers: <?php echo $editorSettings['editorLineNumbers']; ?>,             // display lineNumbers true|false
                undoDepth: <?php echo $editorSettings['editorUndoDepth']; ?>,                 // how many undo steps should be saved? (default: 200)
                smartIndent: <?php echo $editorSettings['editorSmartIndent']; ?>,             // better indent
                indentUnit: <?php echo $editorSettings['editorIndentUnit']; ?>,               // how many spaces auto indent? (default: 2)
                scrollbarStyle: null,                                                         // styling of the scrollbars
                matchBrackets: <?php echo $editorSettings['editorMatchBrackets']; ?>,         // highlight corresponding brackets
                autoCloseBrackets: <?php echo $editorSettings['editorCloseBrackets'];?>,      // auto insert close brackets
                autoCloseTags: <?php echo $editorSettings['editorCloseTags']; ?>,             // auto insert close tags after opening
                value: "<html>\n  " + document.documentElement.innerHTML + "\n</html>",       // all html
                mode: "htmlmixed",                                                            // editor mode
                matchTags: {bothTags: <?php echo $editorSettings['editorMatchTags']; ?>},     // hightlight matching tags: both
                extraKeys: {"Ctrl-J": "toMatchingTag", "Ctrl-Space": "autocomplete"},         // press ctrl-j to jump to next matching tab
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

<script type="text/javascript" >
    $(document).ready(function() {
// load datetimepicker  (start time)
        $('#datetimepicker1').datetimepicker({
            format: 'YYYY-MM-DD HH:mm:ss'
        });
// load 2nd datetimepicker (end time)
        $('#datetimepicker2').datetimepicker({
            format: 'YYYY-MM-DD HH:mm:ss'

        });

    }); //]]>  /* END document.ready */
    /* ...end admin jQ controlls  */
</script>

<?php
// TEMPLATE WRAPPER - HEADER & breadcrumbs
echo "
<!-- Content Wrapper. Contains page content -->
<div class=\"content-wrapper\" id=\"content-FX\">
    <!-- Content Header (Page header) -->
    <section class=\"content-header\">";
/* draw Title on top */
echo backend::getTitle($page->title, $lang['PAGE_EDIT']);
echo"<ol class=\"breadcrumb\">
            <li><a href=\"index.php\" title=\"$lang[DASHBOARD]\"><i class=\"fa fa-dashboard\"></i> $lang[DASHBOARD]</a></li>
            <li><a href=\"index.php?page=pages\" title=\"$lang[PAGES]\"> $lang[PAGES]</a></li>
            <li class=\"active\"><a href=\"index.php?page=page-edit\" title=\"$lang[PAGE_EDIT]\"> $lang[PAGE_EDIT]</a></li>
        </ol>
    </section>
    <!-- Main content -->
    <section class=\"content\">";
?>

<!-- FORM -->
<form name="form" role="form" action="index.php?page=page-edit&site=<?php print $page->alias; ?>&id=<?php echo $page->id; ?>" method="post">
    <div class="row">
        <div class="col-md-8">
            <!-- EDITOR -->
            <label for="summernote"></label>
            <textarea id="summernote" name="content"><?php print $page->readContent("../"); ?> </textarea>

            <!-- SAVE BUTTON -->
            <div class="text-right">
                <button type="submit" id="savebutton" name="save" class="btn btn-success">
                    <i id="savebuttonIcon" class="fa fa-check"></i> &nbsp;<?php print $lang['SAVE_CHANGES']; ?>
                </button>
            </div>

            <input type="hidden" name="searchstring" value="<?php print $page->alias; ?>.html" >
            <input type="hidden" name="id" value="<?php print $_GET['id']; ?>" >

            <br><br>

        </div>
        <div class="col-md-4">
            <!-- 2nd col -->
            <!-- TITLE and FILENAME -->
            <div class="box box-default">
                <div class="box-header with-border">
                    <h3 class="box-title"><i class="fa fa-file-text-o"></i>&nbsp;&nbsp;<?php echo $lang['SETTINGS']; ?> <small> <?php echo "$lang[TITLE] $lang[AND] $lang[FILENAME]"; ?></small></h3>
                    <!-- box-tools -->
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                        </button>
                    </div>
                    <!-- /.box-tools -->
                </div>
                <div class="box-body" style="display: block;">
                    <label for="title"><?php print $lang['TITLE']; ?>
                        <?php echo backend::printTooltip($lang['TT_PAGE_TITLE']); ?>
                    </label>
                    <input id="title" class="form-control" name="title" maxlength="255" value="<?php print $page->title; ?>">

                    <label for="alias"><?php echo $lang['FILENAME']; ?>
                        <?php echo backend::printTooltip($lang['TT_PAGE_FILENAME']); ?>
                    </label>
                    <input id="alias" class="form-control" name="alias" maxlength="255"
                        <?php if (isset($readonly)) { print $readonly; } ?> value="<?php print $page->alias; ?>">

                    <label for="language"><?php print $lang['LANGUAGE']; ?>
                        <?php echo backend::printTooltip($lang['TT_PAGE_LANGUAGE']); ?>
                    </label>
                    <select id="language" name="language" class="form-control">
                        <?php
                        if (isset($page->language) && (!empty($page->language)))
                        {
                            echo "<option value=".$page->language." selected>$page->language</option>";
                        }
                        echo \YAWK\language::drawLanguageSelectOptions();
                        ?>
                    </select>
                </div>
            </div>

            <?php // draw a box containing widgets of this current page
            YAWK\backend::drawWidgetsOnPageBox($db, $page, $lang);
            ?>

            <!-- PUBLISHING -->
            <div class="box box-default">
                <div class="box-header with-border">
                    <h3 class="box-title"><i class="fa fa-clock-o"></i>&nbsp;&nbsp;<?php echo $lang['PUBLISHING']; ?> <small><?php echo "$lang[EFFECTIVE_TIME] $lang[AND] $lang[PRIVACY]"; ?></small></h3>
                    <!-- box-tools -->
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                        </button>
                    </div>
                    <!-- /.box-tools -->
                </div>
                <div class="box-body">
                    <label for="datetimepicker1"><?php print $lang['START_PUBLISH']; ?>
                        <?php echo backend::printTooltip($lang['TT_PAGE_PUBLISH_DATE']); ?>
                    </label>
                    <input class="form-control" id="datetimepicker1" name="date_publish" maxlength="19" value="<?php print $page->date_publish; ?>">

                    <!-- END PUBLISH DATE -->
                    <label for="datetimepicker2"><?php print $lang['END_PUBLISH']; ?>
                        <?php echo backend::printTooltip($lang['TT_PAGE_UNPUBLISH_DATE']); ?>
                    </label>
                    <input type="text" class="form-control" id="datetimepicker2" name="date_unpublish" maxlength="19" value="<?php print $page->date_unpublish; ?>">

                    <label for="gidselect"> <?php print $lang['PAGE_VISIBLE']; ?>
                        <?php echo backend::printTooltip($lang['TT_PAGE_USERGROUP']); ?>
                    </label>
                    <select id="gidselect" name="gid" class="form-control">
                        <option value="<?php print sys::getGroupId($db, $page->id, "pages"); ?>" selected><?php print user::getGroupNameFromID($db, $page->gid); ?></option>
                        <?php
                        foreach(YAWK\sys::getGroups($db, "pages") as $role) {
                            print "<option value=\"".$role['id']."\"";
                            if (isset($_POST['gid'])) {
                                if($_POST['gid'] === $role['id']) {
                                    print " selected=\"selected\"";
                                }
                                else if($page->gid === $role['id'] && !$_POST['gid']) {
                                    print " selected=\"selected\"";
                                }
                            }
                            print ">".$role['value']."</option>";
                        }
                        ?>
                    </select>

                    <!-- PAGE ON / OFF STATUS -->
                    <label for="published"><?php print $lang['PAGE_STATUS']; ?>
                        <?php echo backend::printTooltip($lang['TT_PAGE_PUBLISH']); ?>
                    </label>
                    <?php if($page->published === '1')
                    {
                        $publishedHtml = "<option value=\"1\" selected=\"selected\">$lang[ONLINE]</option>";
                        $publishedHtml .= "<option value=\"0\" >offline</option>";
                    }
                    else
                    {
                        $publishedHtml = "<option value=\"0\" selected=\"selected\">$lang[OFFLINE]</option>";
                        $publishedHtml .= "<option value=\"1\" >online</option>";
                    }
                    ?>
                    <select id="published" name="published" class="form-control">
                        <?php echo $publishedHtml; ?>
                    </select>
                </div>
            </div>

            <!-- META TAGS -->
            <div class="box box-default">
                <div class="box-header with-border">
                    <h3 class="box-title"><i class="fa fa-google"></i>&nbsp;&nbsp;<?php echo $lang['META_TAGS']; ?> <small><?php echo $lang['PAGE_SEO']; ?></small></h3>
                    <!-- box-tools -->
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                        </button>
                    </div>
                    <!-- /.box-tools -->
                </div>
                <div class="box-body" style="display: block;">
                    <!-- LOCAL META SITE DESCRIPTION -->
                    <label for="meta_local"><?php echo $lang['META_DESC']; ?>
                        <?php echo backend::printTooltip($lang['TT_PAGE_METALOCAL']); ?>
                    </label>
                    <input type="text" size="64" id="meta_local" class="form-control" maxlength="255" placeholder="<?php echo $lang['META_DESC_PLACEHOLDER']; ?>" name="meta_local" value="<?php print $page->meta_local; ?>">
                    <!-- LOCAL META SITE KEYWORDS -->
                    <label for="meta_keywords"><?php echo $lang['META_KEYWORDS']; ?>
                        <?php echo backend::printTooltip($lang['TT_PAGE_KEYWORDS']); ?>
                    </label>
                    <input type="text" size="64" id="meta_keywords" class="form-control" placeholder="<?php echo $lang['META_KEYWORDS_PLACEHOLDER']; ?>" name="meta_keywords" value="<?php print $page->meta_keywords; ?>">
                </div>
            </div>

            <!-- BG IMAGE -->
            <div class="box box-default">
                <div class="box-header with-border">
                    <h3 class="box-title"><i class="fa fa-photo"></i>&nbsp;&nbsp;<?php echo $lang['BG_IMAGE']; ?> <small><?php echo $lang['SPECIFIC_PAGE']; ?></small></h3>
                    <!-- box-tools -->
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                        </button>
                    </div>
                    <!-- /.box-tools -->
                </div>
                <div class="box-body" style="display: block;">
                    <!-- PAGE BG IMAGE -->
                    <label for="bgimage"><?php echo $lang['BG_IMAGE']; ?></label>
                    <input id="bgimage" type="text" size="64" class="form-control" placeholder="media/images/background.jpg" name="bgimage" value="<?php print $page->bgimage;  ?>">
                </div>
            </div>
</form>