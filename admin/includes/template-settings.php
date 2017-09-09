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
?>

<!-- SETTINGS -->
<h3><?php echo "$lang[SETTINGS] <small>$lang[TPL_SETTINGS_SUBTEXT]</small>"; ?></h3>
<div class="row animated fadeIn">
    <div class="col-md-4">
        <div class="box box-default">
            <div class="box-header with-border">
                <h3 class="box-title">Required Assets Include Configuration</h3>
            </div>
            <div class="box-body">
                <label for="include-bootstrap">Bootstrap JS</label>
                <select id="include-bootstrap" name="include-bootstrap" class="form-control">
                    <option name="null">please select</option>
                    <optgroup label="internal">internal</optgroup>
                    <option name="internal">load from internal sources (system/engines/bootstrap)</option>
                    <optgroup label="external">external</optgroup>
                    <option name="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js">https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js</option>
                    <option name="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js">https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js</option>
                </select>
                <label for="include-bootstrap">Bootstrap CSS</label>
                <select id="include-bootstrap" name="include-bootstrap" class="form-control">
                    <option name="null">please select</option>
                    <optgroup label="internal">internal</optgroup>
                    <option name="internal">load from internal sources (system/engines/bootstrap)</option>
                    <optgroup label="external">external</optgroup>
                    <option name="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css</option>
                    <option name="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css">https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css</option>
                </select>
                <label for="include-jquery">jQuery</label>
                <select id="include-jquery" name="include-jquery" class="form-control">
                    <option name="null">please select</option>
                    <optgroup label="internal">internal</optgroup>
                    <option name="internal">load from internal sources (system/engines/jquery)</option>
                    <optgroup label="external">external</optgroup>
                    <option name="cdn-google">use google CDN (http://.....)</option>
                    <option name="cdn-xyz">use jquery CDN (http://.....)</option>
                </select>
                <label for="include-jquery">jQuery UI</label>
                <select id="include-jquery" name="include-jquery" class="form-control">
                    <option name="null">please select</option>
                    <optgroup label="internal">internal</optgroup>
                    <option name="internal">load from internal sources (system/engines/jquery)</option>
                    <optgroup label="external">external</optgroup>
                    <option name="cdn-google">use google CDN (http://.....)</option>
                    <option name="cdn-xyz">use jquery CDN (http://.....)</option>
                </select>
            </div>
        </div>
    </div>
    <div class="col-md-4">

        <div class="box box-default">
            <div class="box-header with-border">
                <h3 class="box-title">Optional Assets Configuration</h3>
            </div>
            <div class="box-body">
                <label for="include-animate">Animate.css</label>
                <select id="include-animate" name="include-animate" class="form-control">
                    <option name="null">please select</option>
                    <optgroup label="internal">internal</optgroup>
                    <option name="internal">load from internal sources (system/engines/animate)</option>
                    <optgroup label="external">external</optgroup>
                    <option name="cdn-google">use google CDN (http://.....)</option>
                    <option name="cdn-xyz">use jquery CDN (http://.....)</option>
                </select>
                <label for="include-fontawesome">Font Awesome Icons</label>
                <select id="include-fontawesome" name="include-fontawesome" class="form-control">
                    <option name="null">please select</option>
                    <optgroup label="internal">internal</optgroup>
                    <option name="internal">load from internal sources (system/engines/fontawesome)</option>
                    <optgroup label="external">external</optgroup>
                    <option name="cdn-google">use google CDN (http://.....)</option>
                </select>
                <label for="include-lightbox2">Lightbox 2</label>
                <select id="include-lightbox2" name="include-lightbox2" class="form-control">
                    <option name="null">please select</option>
                    <optgroup label="internal">internal</optgroup>
                    <option name="internal">load from internal sources (system/engines/lightbox)</option>
                    <optgroup label="external">external</optgroup>
                    <option name="cdn-google">use google CDN (http://.....)</option>
                    <option name="cdn-xyz">use jquery CDN (http://.....)</option>
                </select>
                <label for="include-pace">Pace Loading Bar</label>
                <select id="include-pace" name="include-pace" class="form-control">
                    <option name="null">please select</option>
                    <optgroup label="internal">internal</optgroup>
                    <option name="internal">load from internal sources (system/engines/pace)</option>
                    <optgroup label="external">external</optgroup>
                    <option name="cdn-google">use google CDN (http://.....)</option>
                    <option name="cdn-xyz">use jquery CDN (http://.....)</option>
                </select>
            </div>
        </div>
    </div>
    <div class="col-md-4">4</div>
</div>

<div class="row animated fadeIn">
    <div class="col-md-6">
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