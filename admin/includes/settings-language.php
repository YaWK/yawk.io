<?php
if (isset($_POST['save']))
{
    // store backend language
    if (\YAWK\settings::setSetting($db, "backendLanguage", $_POST['backendLanguage'], $lang) === true)
    {   $backendStatus = 1; }
    else
    {   $backendStatus = 0; }

    // store frontend language
    if (\YAWK\settings::setSetting($db, "frontendLanguage", $_POST['frontendLanguage'], $lang) === true)
    {   $frontendStatus = 1; }
    else
    {   $frontendStatus = 0; }

    // calc status vars
    $status = $backendStatus + $frontendStatus;
    // check status to throw only 1 notification
    switch ($status)
    {
        // ok, all good success msg
        case 2:
            // ensure, that new backend language gets stored as cookie
            if (isset($_POST['backendLanguage']) && (!empty($_POST['backendLanguage'])))
            {   // we use a small line of JS to achieve this
                echo "<script>document.cookie = 'lang=$_POST[backendLanguage]';</script>";
                // to ensure that language switching works correctly, reload page with given POST language
                \YAWK\sys::setTimeout("index.php?page=settings-language&lang=$_POST[backendLanguage]&saved=1&frontendLanguage=$_POST[frontendLanguage]", 0);
            }
            break;
        // false, throw error msg
        case 0:
            // to ensure that language switching works correctly, reload page with given POST language
            \YAWK\alert::draw("danger", "$lang[LANGUAGES] $lang[NOT_SAVED]", "$lang[BACKEND] ($_GET[backendLanguage]) $lang[AND] $lang[FRONTEND] ($_GET[frontendLanguage]) $lang[LANGUAGE] $lang[NOT_SAVED].",'', 3400);
            // \YAWK\sys::setTimeout("index.php?page=settings-language&saved=0&backendLanguage=$_POST[backendLanguage]&frontendLanguage=$_POST[frontendLanguage]", 0);
            break;
    }
}
if (isset($_GET['saved']) && ($_GET['saved'] == 1))
{
    \YAWK\alert::draw("success", "$lang[LANGUAGES] $lang[SAVED]", "$lang[BACKEND] ($_GET[lang]) $lang[AND] $lang[FRONTEND] ($_GET[frontendLanguage]) $lang[LANGUAGE] $lang[SAVED].",'', 2400);
}

// save new language file
if (isset($_POST['editLanguageBtn']))
{
    if (isset($_POST['editLanguageSelect']))
    {   // no language selected
        if ($_POST['editLanguageSelect'] === "null")
        {   // throw error
            \YAWK\alert::draw("danger", $lang['ERROR'], $lang['LANGUAGE_SELECT_NEEDED'], "", 3400);
        }
        else
            {   // language selected
                $file = $_POST['editLanguageSelect'];
                if (file_put_contents($file, $_POST['languageContent']))
                {   // write ok, throw msg
                    \YAWK\alert::draw("success", $lang['TRANSLATION'], "$lang[FILE] <b>$file</b> $lang[SAVED]", "", 2400);
                }
                else
                {   // error, throw alert
                    \YAWK\alert::draw("danger", $lang['TRANSLATION'], "$lang[FILE] <b>$file</b> $lang[NOT_SAVED]", "", 3400);
                }
            }
    }
}
if (isset($_GET['restore']) && ($_GET['restore'] == 1) && ($_GET['action'] == true))
{
    $i = 0;
    $total = 0;
    $files = glob("../system/backup/languages/*.ini");
    $src = "../system/backup/languages";
    $dst = "language";
    foreach($files as $file){
        $i++;
        $file2go = str_replace($src,$dst,$file);
        if (copy($file, $file2go))
        {
            $total++;
        }
    }
    if ($i === $total)
    {
        \YAWK\alert::draw("success", "$lang[LANGUAGES] $lang[RESTORED]", "$lang[LANGUAGE] $lang[FILES] $lang[RESTORED]", "", 2400);
    }
    else
        {   // not all files could be copied
            \YAWK\alert::draw("danger", "$lang[LANGUAGES] $lang[NOT_RESTORED]", "$lang[LANGUAGE] $lang[FILES] $lang[NOT_RESTORED]", "", 3400);
        }
}
?>

<?php
// get settings for editor
$editorSettings = \YAWK\settings::getEditorSettings($db, 14);
?>
<!-- include summernote css/js-->
<!-- include codemirror (codemirror.css, codemirror.js, xml.js) -->
<link rel="stylesheet" type="text/css" href="../system/engines/codemirror/codemirror.min.css">
<link rel="stylesheet" type="text/css" href="../system/engines/codemirror/themes/<?php echo $editorSettings['editorTheme']; ?>.css">
<script type="text/javascript" src="../system/engines/codemirror/codemirror-compressed.js"></script>


<?php
// TEMPLATE WRAPPER - HEADER & breadcrumbs
echo "
    <!-- Content Wrapper. Contains page content -->
    <div class=\"content-wrapper\" id=\"content-FX\">
    <!-- Content Header (Page header) -->
    <section class=\"content-header\">";
/* draw Title on top */
echo \YAWK\backend::getTitle($lang['LANGUAGES'], $lang['TRANSLATION']);
echo"<ol class=\"breadcrumb\">
            <li><a href=\"index.php?page=settings-system\" title=\"$lang[SETTINGS]\"><i class=\"fa fa-gear\"></i> $lang[SETTINGS]</a></li>
            <li class=\"active\"><a href=\"index.php?page=settings-language\" title=\"$lang[LANGUAGES]\"> $lang[LANGUAGES]</a></li>
         </ol>
    </section>
    <!-- Main content -->
    <section class=\"content\">";
/* page content start here */
?>
<form id="template-edit-form" action="index.php?page=settings-language" method="POST">
    <div class="row animated fadeIn">
        <div class="col-md-8">
            <div class="box">
                <div class="box-body">
                    <label for="languageContent">Language File Content</label>
                    <textarea id="languageContent" name="languageContent" rows="30" class="form-control"></textarea>
                    <div id="textbox"></div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Sprache <small>festlegen</small></h3>
                </div>
                <div class="box-body">
                    <?php \YAWK\settings::getFormElements($db, $settings, 19, $lang) ?>
                    <button type="submit" id="savebutton" name="save" class="btn btn-success pull-right">
                        <i id="savebuttonIcon" class="fa fa-check"></i> &nbsp;<?php print $lang['SAVE_SETTINGS']; ?>
                    </button>
                </div>
            </div>
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">&Uuml;bersetzung <small>bearbeiten</small></h3>
                </div>
                <div class="box-body">
                    <label id="editLanguageSelectLabel" for="editLanguageSelect">welche Sprache möchtest Du bearbeiten?</label>
                    <select id="editLanguageSelect" name="editLanguageSelect" class="form-control">
                        <option value="null">bitte auswählen</option>
                        <option value="language/lang-de-DE.ini">de-DE</option>
                        <option value="language/lang-en-EN.ini">en-EN</option>
                    </select>
                    <div id="editLanguageFooter">
                        <button id="editLanguageBtn" name="editLanguageBtn" class="btn btn-success pull-right" style="margin-top:10px;"><i class="fa fa-check"></i> &nbsp;
                            <?php echo $lang['TRANSLATION']."&nbsp;".$lang['SAVE']; ?></button>
                        <!-- <a href="#" id="cancelLanguageBtn" class="btn btn-danger pull-right hidden" style="margin-top:10px; margin-right:2px;"><i class="fa fa-times"></i> &nbsp;abbrechen</a> -->
                    </div>
                </div>
            </div>
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title"><?php echo $lang['LANGUAGES']; ?> <small>zurücksetzen</small></h3>
                </div>
                <div class="box-body">
                    <i class="fa fa-exclamation-triangle text-danger"></i>&nbsp;&nbsp;Setzt alle Sprachen auf Werkseinstellung zur&uuml;ck.
                    <a class="btn btn-default pull-right" id="resetLanguageBtn" name="resetLanguageBtn" role="dialog" data-confirm="<?php echo $lang['ARE_YOU_SURE'];?>" title="<?php echo $lang['RESTORE_LANGUAGE']; ?>" href="index.php?page=settings-language&restore=1&action=true"><i class="fa fa-language text-danger"></i>&nbsp;&nbsp;Backup laden</a>
                </div>
            </div>
        </div>
    </div>
</form>
<style type="text/css">
    html, body {height: 100%;}
    .CodeMirror {height:50em;}
    .CodeMirror-scroll {height: 100%;}
</style>

<script type="text/javascript" language="javascript">
    $(document).ready(function() {

        languageContent = $("#languageContent");
        editlanguageSelectLabel = $("#editLanguageSelectLabel");
        editLanguageSelect = $("#editLanguageSelect");
        cancelLanguageBtn = $("#cancelLanguageBtn");
        editLanguageBtn = $("#editLanguageBtn");

       $(editLanguageSelect).on('change', function()
        {
            // prepare vars
            fn = this.value;    // language file

            var config, editor;
            config = {
                theme: '<?php echo $editorSettings['editorTheme']; ?>',                       // codeview theme
                lineNumbers: true,             // display lineNumbers true|false
                undoDepth: <?php echo $editorSettings['editorUndoDepth']; ?>,                 // how many undo steps should be saved? (default: 200)
                smartIndent: <?php echo $editorSettings['editorSmartIndent']; ?>,             // better indent
                indentUnit: <?php echo $editorSettings['editorIndentUnit']; ?>,               // how many spaces auto indent? (default: 2)
                mode: "text/css",
                styleActiveLine: <?php echo $editorSettings['editorActiveLine']; ?>           // highlight the active line (where the cursor is)
                // autoRefresh: true
            };

            // prevent caching
            $.ajaxSetup({ cache: false });
            $.get(fn, function (response) {
                language = response;
                //  alert(language);
                editor = CodeMirror.fromTextArea(document.getElementById("languageContent"), config).setValue(language);
            });

            // if save language btn is clicked
            $(editLanguageBtn).click(function() {
                // release (enable) select options field
                $(editLanguageSelect).prop('disabled', false);
                // hide cancel button
                $(cancelLanguageBtn).removeClass('btn btn-danger pull-right').addClass('btn btn-danger pull-right hidden');
            });

            // change label to tell user which file he is editing
            $(editlanguageSelectLabel).empty().append('<?php // echo $lang['EDIT'].":"; ?> admin/'+fn);
            // turn off editLangue Select field
            $(editLanguageSelect).prop('disabled', true);
            // change class (color) of savebutton
            $(editLanguageBtn).removeClass('btn btn-success pull-right').addClass('btn btn-warning pull-right');
        });
    }); // end document ready
</script>