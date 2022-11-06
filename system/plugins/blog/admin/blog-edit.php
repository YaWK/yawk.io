<?php

use YAWK\BACKEND\AdminLTE;
use YAWK\db;
use YAWK\PLUGINS\BLOG\blog;
use YAWK\settings;

include '../system/plugins/blog/classes/blog.php';
// check if blog object is set
if (!isset($blog)) { $blog = new blog(); }
// check if page object is set
if (!isset($page)) { $page = new \YAWK\page(); }
// check if language is set
if (!isset($language) || (!isset($lang)))
{   // inject (add) language tags to core $lang array
    $lang = \YAWK\language::inject(@$lang, "../system/plugins/blog/language/");
}
if (!isset($db)){
    $db = new db();
}
// SAVE BLOG ENTRY
if (isset($_POST['save'])) {
    // check if blogtitle is set
    if ((empty($_POST['blogtitle'])))
    {   // blogtitle is empty, set unnamed as default value
        $_POST['blogtitle'] = "unnamed";
    }
    // check if filename is set
    if ((empty($_POST['filename'])))
    {   // user entered no filename, take blogtitle as filename (processing will be done in save function)
        $_POST['filename'] = $_POST['blogtitle'];
    }
    // check if meta description is set
    if ((empty($_POST['meta_local'])))
    {   // if not, take blogtitle as description
        $_POST['meta_local'] = $_POST['blogtitle'];
    }
    // check if meta keywords are set
    if ((empty($_POST['meta_keywords'])))
    {   // if not, take blogtitle as description
        $_POST['meta_keywords'] = "";
    }
    // check if a teasertext is set
    if ((empty($_POST['teasertext'])))
    {   // if not, leave old teasertext (hidden post field)
        $_POST['teasertext'] = $_POST['oldteasertext'];
    }

    // quote post vars
    $blog->blogtitle = $db->quote($_POST['blogtitle']);
    $blog->filename = $db->quote($_POST['filename']);
    $blog->subtitle = $db->quote($_POST['subtitle']);
    $blog->published = $db->quote($_POST['published']);
    $blog->itemid = $db->quote($_POST['itemid']);
    $blog->itemgid = $db->quote($_POST['itemgid']);
    $blog->teaser = $db->quote($_POST['teaser']);
    $blog->date_publish = $db->quote($_POST['date_publish']);
    $blog->date_unpublish = $db->quote($_POST['date_unpublish']);
    $blog->blogid = $db->quote($_POST['blogid']);
    $blog->teasertext = $db->quote($_POST['teasertext']);
    $blog->blogtext = $db->quote($_POST['blogtext']);
    $blog->pageid = $db->quote($_POST['pageid']);
    $blog->thumbnail = $db->quote($_POST['thumbnail']);
    $blog->youtubeUrl = $db->quote($_POST['youtubeUrl']);
    $blog->meta_local = $db->quote($_POST['meta_local']);
    $blog->meta_keywords = $db->quote($_POST['meta_keywords']);
    $blog->itemlayout = $db->quote($_POST['itemlayout']);
    $blog->itemcomments = $db->quote($_POST['itemcomments']);

    // Summernote Editor \r\n removal

    // $blog->blogtext = stripslashes(str_replace('\r\n','&#x000D;', ($blog->blogtext)));
    // $blog->teasertext = stripslashes(str_replace('\r\n','&#x000D;', ($blog->teasertext)));

    if ($blog->save($db))
    {   // throw success notify
        YAWK\alert::draw("success", "$lang[SUCCESS]", "$lang[ENTRY] $lang[SAVED]", "", "800");
    }
    else
    {   // saving failed, throw error
        YAWK\alert::draw("danger", "$lang[ERROR]", "$lang[BLOG] " . $_GET['blogid'] . " " . $_POST['blogtitle'] . " - " . $_POST['subtitle'] . " $lang[NOT] $lang[SAVED]","","3800");
    }
}


// load blog properties
$blog->loadItemProperties($db, $_GET['blogid'], $_GET['itemid']);

// path to cms
$dirprefix = YAWK\sys::getDirPrefix($db);
// get host URL
$host = YAWK\sys::getHost($db);

// TEMPLATE WRAPPER - HEADER & breadcrumbs
echo "
    <!-- Content Wrapper. Contains page content -->
    <div class=\"content-wrapper\" id=\"content-FX\">
    <!-- Content Header (Page header) -->
    <section class=\"content-header\">";
/* draw Title on top */
blog::getBlogTitle($blog->blogtitle, $lang['EDIT'], $blog->icon);
echo"<ol class=\"breadcrumb\">
            <li><a href=\"index.php\" title=\"$lang[DASHBOARD]\"><i class=\"fa fa-dashboard\"></i> $lang[DASHBOARD]</a></li>
            <li><a href=\"index.php?page=plugins\" title=\"$lang[PLUGINS]\"> $lang[PLUGINS]</a></li>
            <li class=\"active\"><a href=\"index.php?plugin=blog\" title=\"$lang[BLOG]\"> $lang[BLOG]</a></li>
         </ol>
    </section>
    <!-- Main content -->
    <section class=\"content\">";
/* page content start here */
?>
<script type="text/javascript">
    function saveHotkey() {
        // simply disables save event for chrome
        $(window).keypress(function (event) {
            if (!(event.which === 115 && (navigator.platform.match("Mac") ? event.metaKey : event.ctrlKey)) && !(event.which == 19)) return true;
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
</script>
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
    $(document).ready(function() {
// textarea that will be transformed into editor
        var editor = ('textarea#summernote');
        var editor2 = ('textarea#summernote2');
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

            if ($(editor2).summernote('codeview.isActivated')) {
// if so, turn it off.
                $(editor2).summernote('codeview.deactivate');
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

            if ( $(editor2).length) {    // check if element exists in dom to load editor correctly
                // do the same thing for the 2nd textarea:
                var text2 = $(editor2).val();
                // search for <img> tags and revert src ../ to set correct path for frontend
                var frontend2 = text2.replace(/<img src=\x22..\/media/g, "<img src=\x22media");
                // put the new string back into <textarea>
                $(editor2).val(frontend2); // to make sure that saving works
            }
        });

        // BEFORE SUMMERNOTE loads: 3 important lines of code!
        // to display images in backend correctly, we need to change the path of every image.
        // procedure is the same as above (see #savebutton.click)
        // get the value of summernote textarea

        if ( $(editor).length) {    // check if element exists in dom to load editor correctly
            var text = $(editor).val();
            // search for <img> tags and update src ../ to get images viewed in summernote
            var backend = text.replace(/<img src=\"media/g, "<img src=\"../media");
            // put the new string back into <textarea>
            $(editor).val(backend); // set new value into textarea
        }

        if ( $(editor2).length) {    // check if element exists in dom to load editor correctly
            // do the same thing for the 2nd textarea:
            var text2 = $(editor2).val();
            // search for <img> tags and update src ../ to get images viewed in summernote
            var backend2 = text2.replace(/<img src=\"media/g, "<img src=\"../media");
            // put the new string back into <textarea>
            $(editor2).val(backend2); // set new value into textarea

        }
        <?php
        // check if codeview is enabled on default
        if ($editorSettings['editorAutoCodeview'] === "true")
        {
            // summernote.init -
            // LOAD SUMMERNOTE IN CODEVIEW ON STARTUP
            echo "$(editor).on('summernote.init', function() {
                // toggle editor to codeview
                $(editor).summernote('codeview.toggle');
            });";
            echo "$(editor2).on('summernote.init', function() {
                // toggle editor to codeview
                $(editor2).summernote('codeview.toggle');
            });";
        }
        ?>

        // INIT SUMMERNOTE EDITOR
        $('#summernote').summernote({    // set editor itself
            height: <?php echo $editorSettings['editorTeaserHeight']; ?>,                 // set editor height
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


        // INIT SUMMERNOTE 2 EDITOR
        $('#summernote2').summernote({    // set editor itself
            height: <?php echo $editorSettings['editorHeight']; ?>,                 // set editor height
            minHeight: null,             // set minimum height of editor
            maxHeight: null,             // set maximum height of editor
            focus: false,                 // set focus to editable area after initializing summernote

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

<!-- bootstrap date-timepicker -->
<link type="text/css" href="../system/engines/datetimepicker/css/datetimepicker.min.css" rel="stylesheet"/>
<script type="text/javascript" src="../system/engines/datetimepicker/js/bootstrap-datetimepicker.min.js"></script>
<script type="text/javascript">
    /* start own JS bootstrap function
     ...on document ready... letsego! */
    $(document).ready(function () {
        $('#datetimepicker1').datetimepicker({
            format: 'YYYY-MM-DD HH:mm:ss'
        });
        $('#datetimepicker2').datetimepicker({
            format: 'YYYY-MM-DD HH:mm:ss'
        });
    });//]]>  /* END document.ready */
    /* ...end admin jQ controlls  */
</script>
<!-- end datetimepicker -->

<?php
$blog->icon = $blog->getBlogProperty($db, $blog->blogid, "icon");
$blog->name = $blog->getBlogProperty($db, $blog->blogid, "name");
$blog->layout = $blog->getBlogProperty($db, $blog->blogid, "layout");
/* draw Title on top */

?>

<form name="form" role="form"
      action="index.php?plugin=blog&pluginpage=blog-edit&blogid=<?php print $blog->blogid; ?>&itemid=<?php print $blog->itemid; ?>"
      method="post">

    <div class="row">
        <div class="col-md-9">
            <label for="blogtitle"><?php print $lang['TITLE']; ?></label>
            <input type="text"
                   class="form-control input-lg"
                   id="blogtitle"
                   name="blogtitle"
                   value="<?php print $blog->blogtitle; ?>">
            <br>
            <?php
            if ($blog->teaser !== "0")
            {
                echo "
        <!-- EDITOR -->
        <label for=\"summernote\">$lang[TEASER_TEXT]</label>
        <textarea
            id=\"summernote\"
            class=\"form-control\"
            style=\"margin-top:10px;\"
            name=\"teasertext\">".$blog->teasertext."</textarea>";
            }
            ?>
            <!-- EDITOR -->
            <label for="summernote2"><?php echo $lang['BLOG_TEXT']; ?></label>

            <textarea
                    id="summernote2"
                    class="form-control"
                    style="margin-top:10px;"
                    name="blogtext"
                    cols="50"
                    rows="18"><?php print $blog->blogtext; ?></textarea>
        </div> <!-- end left col -->

        <div class="col-md-3">
            <!-- right col -->
            <!-- SAVE BUTTON -->
            <button type="submit"
                    id="savebutton"
                    name="save"
                    class="btn btn-success pull-right">
                <i id="savebuttonIcon" class="fa fa-check"></i> &nbsp;<?php print $lang['SAVE_CHANGES']; ?>
            </button>

            <!-- CANCEL BUTTON -->
            <a class="btn btn-default pull-right" href="index.php?plugin=blog&pluginpage=blog-entries&blogid=<?php echo $_GET['blogid']; ?>">
                <i id="cancelbuttonIcon" class="fa fa-backward"></i> &nbsp;<?php print $lang['BACK']; ?>
            </a>

            <br><br><br>

            <?php
            // SETTINGS: filename + subtitle
            $header = "<i class=\"fa fa-file-text-o\"></i>&nbsp; $lang[SETTINGS] <small>$lang[TITLE] &amp; $lang[FILENAME]</small>";
            $content = "<label for=\"filename\">$lang[FILENAME]</label><br>
                    <input type=\"text\"
                               class=\"form-control\"
                               name=\"filename\"
                               id=\"filename\"
                               size=\"64\"
                               maxlength=\"255\"
                               value=\"$blog->filename\">
                    <label for=\"subtitle\">$lang[SUBTITLE]</label><br>
                    <input type=\"text\"
                               class=\"form-control\"
                               name=\"subtitle\"
                               id=\"subtitle\"
                               size=\"64\"
                               maxlength=\"255\"
                               value=\"$blog->subtitle\">";
            echo AdminLTE::drawCollapsableBox($header, $content);
            ?>

            <!-- PUBLISHING -->
            <div class="box box-default">
                <div class="box-header with-border">
                    <h3 class="box-title"><i class="fa fa-clock-o"></i>
                        &nbsp;<?php echo "$lang[PUBLISHING] <small>$lang[EFFECTIVE_TIME] &amp; $lang[PRIVACY]</small>"; ?>
                    </h3>
                    <!-- box-tools -->
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                        </button>
                    </div>
                    <!-- /.box-tools -->
                </div>
                <!-- /.box-header -->
                <div class="box-body" style="display: block;">

                    <!-- start publish datetimepicker -->
                    <label for="datetimepicker1"><i class="fa fa-calendar"></i> <?php print $lang['START_PUBLISH']; ?></label><br>
                    <input
                            class="form-control"
                            id="datetimepicker1"
                            type="text"
                            name="date_publish"
                            maxlength="19"
                            value="<?php print $blog->date_publish; ?>">

                    <!-- end publish datetimepicker -->
                    <label for="datetimepicker2"><i class="fa fa-ban"></i> <?php print $lang['END_PUBLISH']; ?></label><br>
                    <input
                            type="text"
                            class="form-control"
                            id="datetimepicker2"
                            name="date_unpublish"
                            maxlength="19"
                            value="<?php print $blog->date_unpublish; ?>">

                    <!-- group id selector -->
                    <label for="gidselect"><i class="fa fa-users"></i> <?php print $lang['PAGE_VISIBLE']; ?></label>
                    <select id="gidselect" name="itemgid" class="form-control">
                        <option value="<?php print \YAWK\sys::getGroupId($db, $blog->pageid, "pages"); ?>" selected><?php print \YAWK\user::getGroupNameFromID($db, $blog->itemgid); ?></option>
                        <?php
                        foreach(YAWK\sys::getGroups($db, "pages") as $role) {
                            print "<option value=\"".$role['id']."\"";
                            if (isset($_POST['gid'])) {
                                if($_POST['gid'] === $role['id']) {
                                    print " selected=\"selected\"";
                                }
                                else if($blog->itemgid === $role['id'] && !$_POST['itemgid']) {
                                    print " selected=\"selected\"";
                                }
                            }
                            print ">".$role['value']."</option>";
                        }
                        ?>
                    </select>

                    <!-- PAGE ON / OFF STATUS -->
                    <label for="published"><i class="fa fa-eye"></i> <?php print $lang['ENTRY'];print"&nbsp;";print $lang['ONLINE']; ?></label><br>
                    <?php if($blog->published == 1){
                        $publishedHtml = "<option value=\"1\" selected=\"selected\">$lang[ONLINE]</option>";
                        $publishedHtml .= "<option value=\"0\" >$lang[OFFLINE]</option>";
                    } else {
                        $publishedHtml = "<option value=\"0\" selected=\"selected\">$lang[OFFLINE]</option>";
                        $publishedHtml .= "<option value=\"1\" >$lang[ONLINE]</option>";
                    } ?>
                    <select id="published" name="published" class="form-control">
                        <?php echo $publishedHtml; ?>
                    </select>
                </div>
                <!-- /.box-body -->
            </div>

            <!-- META TAGS -->
            <div class="box box-default">
                <div class="box-header with-border">
                    <h3 class="box-title"><i class="fa fa-google"></i>&nbsp;&nbsp;<?php echo "$lang[META_TAGS] <small>$lang[SEO]"; ?></h3>
                    <!-- box-tools -->
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                        </button>
                    </div>
                    <!-- /.box-tools -->
                </div>
                <!-- /.box-header -->
                <div class="box-body" style="display: block;">
                    <!-- LOCAL META SITE DESCRIPTION -->
                    <label for="meta_local"><?php echo "$lang[META_DESC]"; ?></label><br>
                    <textarea cols="64"
                              rows="2"
                              id="meta_local"
                              class="form-control"
                              maxlength="255"
                              placeholder="<?php echo "$lang[PAGE_DESC_PLACEHOLDER]"; ?>"
                              name="meta_local"><?php print $blog->meta_local ?>
                    </textarea>
                    <!-- LOCAL META SITE KEYWORDS -->
                    <label for="meta_keywords"><?php echo "$lang[META_KEYWORDS]"; ?></label>
                    <input type="text"
                           size="64"
                           id="meta_keywords"
                           class="form-control"
                           placeholder="<?php echo "$lang[KEYWORD] 1, $lang[KEYWORD] 2, $lang[KEYWORD] 3..."; ?>"
                           name="meta_keywords"
                           value="<?php print $blog->meta_keywords;  ?>">
                </div>
                <!-- /.box-body -->
            </div>

            <!-- blog thumbnail -->
            <div class="box box-default">
                <div class="box-header with-border">
                    <h3 class="box-title"><i class="fa fa-photo"></i>&nbsp;&nbsp;<?php echo "$lang[TEASER] <small>$lang[TEASER_IMG]</small>"; ?></h3>
                    <!-- box-tools -->
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                        </button>
                    </div>
                    <!-- /.box-tools -->
                </div>
                <!-- /.box-header -->
                <div class="box-body" style="display: block;">
                    <!-- THUMBNAIL IMAGE -->
                    <label for="thumbnail"><?php print $lang['THUMBNAIL']; ?>&nbsp;</label><br>
                    <input
                            type="text"
                            class="form-control"
                            id="thumbnail"
                            name="thumbnail"
                            size="64"
                            maxlength="255"
                            placeholder="media/images/anyfile.jpg"
                            value="<?php print $blog->thumbnail; ?>">
                    <label for="thumbnail"><i class="fa fa-youtube"></i> &nbsp;<?php print $lang['YOUTUBEURL']; ?>&nbsp;</label><br>
                    <!-- YouTube Link -->
                    <input
                            type="text"
                            class="form-control"
                            id="youtubeUrl"
                            name="youtubeUrl"
                            size="64"
                            maxlength="255"
                            placeholder="https://www.youtube.com/embed/1A2B3C4D5E6F"
                            value="<?php print $blog->youtubeUrl; ?>">
                </div>
                <!-- /.box-body -->
            </div>

            <!-- blog thumbnail -->
            <div class="box box-default">
                <div class="box-header with-border">
                    <h3 class="box-title"><i class="fa fa-bars"></i>&nbsp;&nbsp;<?php echo "$lang[SUBMENU] <small>$lang[SUBMENU_SUBTEXT]</small>"; ?></h3>
                    <!-- box-tools -->
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                        </button>
                    </div>
                    <!-- /.box-tools -->
                </div>
                <!-- /.box-header -->
                <div class="box-body" style="display: block;">
                    <!-- SUB MENU SELECTOR -->
                    <label for="menu"><?php echo $lang['SUBMENU']; ?></label>
                    <select name="menu" class="form-control">
                        <option value="<?php print \YAWK\sys::getSubMenu($db, $page->id); ?>"><?php print \YAWK\sys::getMenuItem($db, $page->id); ?></option>
                        <option value="0"><?php echo $lang['NO_MENU_SELECTED']; ?></option>
                        <?php
                        foreach(YAWK\sys::getMenus($db) as $menue){
                            print "<option value=\"".$menue['id']."\"";
                            if (isset($_POST['menu'])) {
                                if($_POST['menu'] === $menue['id']){
                                    print " selected=\"selected\"";
                                }
                                else if($page->menu === $menue['id'] && !$_POST['menu']){
                                    print " selected=\"selected\"";
                                }
                            }
                            print ">".$menue['name']."</option>";
                        }
                        ?>
                    </select>
                </div>
                <!-- /.box-body -->
            </div>


            <!-- blog thumbnail -->
            <div class="box box-default">
                <div class="box-header with-border">
                    <h3 class="box-title"><i class="fa fa-object-ungroup"></i>&nbsp;&nbsp;<?php echo "$lang[LAYOUT] <small>$lang[AND] $lang[COMMENTS]</small>"; ?></h3>
                    <!-- box-tools -->
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                        </button>
                    </div>
                    <!-- /.box-tools -->
                </div>
                <!-- /.box-header -->
                <div class="box-body" style="display: block;">
                    <!-- LAYOUT -->
                    <label for="itemlayout"><?php print $lang['LAYOUT']; ?>&nbsp;</label><br>
                    <select name="itemlayout" id="itemlayout" class="form-control"><?php
                        $layoutOptions = '';
                        $currentLayout = '';
                        $layouts = array(
                            "-1" => "$lang[BLOG_SETTING]",
                            "0" => "$lang[BLOG_LAYOUT_1COL_TEXTBLOG]",
                            "1" => "$lang[BLOG_LAYOUT_2COL_TEASER_L]",
                            "2" => "$lang[BLOG_LAYOUT_2COL_TEASER_R]",
                            "3" => "$lang[BLOG_LAYOUT_3COL_NEWSPAPER]",
                            "4" => "$lang[BLOG_LAYOUT_1COL_YOUTUBE]");
                        foreach ($layouts as $id => $layout)
                        {
                            if ($blog->itemlayout == $id)
                            {
                                $currentLayout = "
                    <option value=\"$blog->layout\">$layout</option>";
                            }
                            else
                            {
                                $layoutOptions .= "
                    <option value=\"$id\">$layout</option>";
                            }
                        }
                        // load option w current value
                        echo $currentLayout.$layoutOptions;
                        ?>

                    </select>
                    <label for="itemcomments"><i class="fa fa-comment-o"></i> &nbsp;<?php print $lang['COMMENTS']; ?>&nbsp;</label><br>
                    <!-- Comment Settings -->
                    <select name="itemcomments" id="itemcomments" class="form-control">
                        <option value="-1"><?php echo $lang['BLOG_SETTING']; ?></option>
                        <option value="1"><?php echo $lang['COMMENTS_ALLOWED']; ?></option>
                        <option value="0"><?php echo $lang['COMMENTS_FORBIDDEN']; ?></option>
                    </select>
                    <label for="teaser"><i class="fa fa-newspaper-o"></i> &nbsp;<?php print $lang['TEASER']."&nbsp;".$lang['TEXT']; ?>&nbsp;</label><br>
                    <!-- Teaser Settings -->
                    <select name="teaser" id="teaser" class="form-control">
                        <?php
                        if ($blog->teaser === '1')
                        {
                            echo '<option value="1" selected aria-selected="true">'.$lang['ENABLED'].'</option>';
                            echo '<option value="0">'.$lang['DISABLED'].'</option>';
                        }
                        else
                        {
                            echo '<option value="0" selected aria-selected="true">'.$lang['DISABLED'].'</option>';
                            echo '<option value="1">'.$lang['ENABLED'].'</option>';
                        }
                        ?>
                    </select>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /. ADDITIONAL BOXES-->

            <!-- HIDDEN FIELDS -->
            <input type="hidden" name="blogid" value="<?php print $blog->blogid; ?>">
            <input type="hidden" name="itemid" value="<?php print $blog->itemid; ?>">
            <input type="hidden" name="pageid" value="<?php print $blog->pageid; ?>">
            <input type="hidden" name="oldteasertext" value="<?php print $blog->teasertext; ?>">

        </div>
    </div>
</form>