<script src="../system/engines/jquery/dropzone/dropzone.js"></script>
<link href="../system/engines/jquery/dropzone/dropzone.css" rel="stylesheet">
<?php

use YAWK\alert;
use YAWK\backend;
use YAWK\db;
use YAWK\filemanager;
use YAWK\language;
use YAWK\settings;
use YAWK\sys;

/** @var $db db */
/** @var $lang language */

// user clicked on save
if (isset($_POST['save']))
{
    // store backend language
    if (settings::setSetting($db, "backendLanguage", $_POST['backendLanguage'], $lang) === true)
    {   $backendStatus = 1; }
    else
    {   $backendStatus = 0; }

    // store frontend language
    if (settings::setSetting($db, "frontendLanguage", $_POST['frontendLanguage'], $lang) === true)
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
                sys::setTimeout("index.php?page=settings-language&lang=$_POST[backendLanguage]&saved=1&frontendLanguage=$_POST[frontendLanguage]", 0);
            }
            break;
        case 0:
            // false, throw error msg
            alert::draw("danger", "$lang[LANGUAGES] $lang[NOT_SAVED]", "$lang[BACKEND] ($_GET[backendLanguage]) $lang[AND] $lang[FRONTEND] ($_GET[frontendLanguage]) $lang[LANGUAGE] $lang[NOT_SAVED].",'', 3400);
            break;
    }
}
// confirmed: switch language has been successful
if (isset($_GET['saved']) && ($_GET['saved'] == 1))
{   // throw success msg
    alert::draw("success", "$lang[LANGUAGES] $lang[SAVED]", "$lang[BACKEND] ($_GET[lang]) $lang[AND] $lang[FRONTEND] ($_GET[frontendLanguage]) $lang[LANGUAGE] $lang[SAVED].",'', 2400);
}

// user wants to override (edit and save) one of the existing language files
if (isset($_POST['editLanguageBtn']))
{   // check, which option the user have selected
    if (isset($_POST['editLanguageSelect']))
    {   // no language selected
        if ($_POST['editLanguageSelect'] === "null")
        {   // throw error
            alert::draw("warning", $lang['ERROR'], $lang['LANGUAGE_SELECT_NEEDED'], "", 3400);
        }
        else
            {   // user selected a language, store filename
                $file = $_POST['editLanguageSelect'];
                // try to override the existing language file
                if (file_put_contents($file, $_POST['languageContent']))
                {   // write ok, throw msg
                    alert::draw("success", $lang['TRANSLATION'], "$lang[FILE] <b>$file</b> $lang[SAVED]", "", 2400);
                }
                else
                {   // write error, throw alert
                    alert::draw("danger", $lang['TRANSLATION'], "$lang[FILE] <b>$file</b> $lang[NOT_SAVED]", "", 3400);
                }
            }
    }
}

// UPLOAD FRONTEND OR BACKEND LANGUAGE FILE
if (isset($_POST['upload']) && ($_POST['upload'] == 1) && ($_POST['action'] == true))
{   // backend language file upload requested
    if ($_POST['uploadFolder'] === 'frontend')
    {   // frontend settings
        $targetPath = '../system/language/';
        $totalLines = count(file('../system/language/lang-en-EN.ini'));
    }
    // backend language file upload requested
    else if ($_POST['uploadFolder'] === 'backend')
    {   // backend settings
        $targetPath = 'language/';
        $totalLines = count(file('language/lang-en-EN.ini'));
    }
    else { $targetPath = 'language/'; $totalLines = 0; }

    // check if file array is set and not empty
    if (isset($_FILES['file']) && (!empty($_FILES['file'])))
    {   // check file extension
        if (substr($_FILES['file']['name'], -4) === '.ini')
        {
            // move file to proper target folder
            move_uploaded_file($_FILES['file']['tmp_name'], $targetPath.$_FILES['file']['name']);
            // check if uploaded file is there
            if (is_file($targetPath.$_FILES['file']['name']))
            {   // uploaded file: count number of lines
                $i = count(file($targetPath.$_FILES['file']['name']));
                // if number of lines does not match with lang-en-EN.ini
                if ($i !== $totalLines)
                {
                    // throw warning
                    alert::draw("warning", "$lang[LANGUAGE] $lang[UPLOADED]", "$lang[LANGUAGE_UPLOAD_DIFFER]", "", 2400);
                }
                else
                    {
                        // upload complete, number of lines are consistent, all good.
                        alert::draw("success", "$lang[LANGUAGE] $lang[UPLOADED]", "$lang[LANGUAGE_UPLOAD_OK]", "", 2400);
                    }
            }
            else
                {
                    // uploaded file is not here - throw error message
                    alert::draw("danger", "$lang[LANGUAGE] $lang[ERROR]", "$lang[LANGUAGE_UPLOAD_FAILED]", "", 2400);
                }
        }
        else
            {
                // uploaded file got the wrong file extension (not an ini file)
                alert::draw("danger", "$lang[LANGUAGE] $lang[ERROR]", "$lang[LANGUAGE_UPLOAD_EXT_ERROR]", "", 2400);
            }
    }
    else
        {
            // no files sent - array not set or empty
            alert::draw("danger", "$lang[LANGUAGE] $lang[ERROR]", "$lang[LANGUAGE_UPLOAD_ERROR]", "", 2400);
        }
}

// user requested to restore the language files from backup folder
if (isset($_GET['restore']) && ($_GET['restore'] == 1) && ($_GET['action'] == true))
{
    // total amount of language files
    $frontendFileCount = 0;
    $backendFileCount = 0;
    //  total amount of files copied
    $frontendCopiedTotal = 0;
    $backendCopiedTotal = 0;
    $copiedTotal = 0;
    // source directory to copy from
    $backendSource = "../system/backup/languages/backend";
    // destination directory to copy to
    $backendDestination = "language";
    // build array with all language files from backup folder
    $backendFiles = glob("../system/backup/languages/backend/*.ini");
    // frontend settings
    $frontendFileCount = 0;
    $frontendSource = "../system/backup/languages/frontend";
    $frontendDestination = "../system/language";
    $frontendFiles = glob("../system/backup/languages/frontend/*.ini");

    // copy backend language files from backup folder
    foreach($backendFiles as $file){
        // add +1 to file counter
        $backendFileCount++;
        // prepare current file
        $current = str_replace($backendSource,$backendDestination,$file);
        // process file
        if (copy($file, $current))
        {   // add +1 to total counter
            $backendCopiedTotal++;
        }
    }

    // copy frontend language files from backup folder
    foreach($frontendFiles as $file){
        // add +1 to file counter
        $frontendFileCount++;
        // prepare current file
        $current = str_replace($frontendSource,$frontendDestination,$file);
        // process file
        if (copy($file, $current))
        {   // add +1 to total counter
            $frontendCopiedTotal++;
        }
    }
    $totalToCopy = $backendFileCount + $frontendFileCount;
    $copiedTotal = $frontendCopiedTotal + $backendCopiedTotal;

    // if all items are processed
    if ($totalToCopy === $copiedTotal)
    {   // throw success msg
        alert::draw("success", "$lang[LANGUAGES] $lang[RESTORED]", "$lang[LANGUAGE] $lang[FILES] $lang[RESTORED]", "", 2400);
    }
    else
        {   // throw error
            alert::draw("danger", "$lang[LANGUAGES] $lang[NOT_RESTORED]", "$lang[LANGUAGE] $lang[FILES] $lang[NOT_RESTORED]", "", 3400);
        }
}   // end save routine and processing
// get editor settings from database
$editorSettings = settings::getEditorSettings($db, 14);
?>
<!-- include codemirror -->
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
echo backend::getTitle($lang['LANGUAGES'], $lang['TRANSLATION']);
echo backend::getSettingsBreadcrumbs($lang);
echo"</section>
    <!-- Main content -->
    <section class=\"content\">";
/* page content start here */
?>
<form id="template-edit-form" action="index.php?page=settings-language" method="POST">
    <div class="box">
        <div class="box-body">
            <div class="col-md-10">
                <?php echo "<h4><i class=\"fa fa-language\"></i> &nbsp;$lang[LANGUAGES]&nbsp;<small>$lang[LANGUAGES_SUBTEXT]</small></h4>"; ?>
            </div>
            <div class="col-md-2">
                <button class="btn btn-success pull-right" id="savebutton" name="save" style="margin-top:2px;"><i id="savebuttonIcon" class="fa fa-check"></i>&nbsp;&nbsp;<?php echo $lang['SAVE_SETTINGS']; ?></button>
            </div>
        </div>
    </div>

    <div class="row animated fadeIn">
        <div class="col-md-8">
            <div class="box">
                <div class="box-body">
                    <label for="languageContent"><?php echo $lang['LANGUAGE_FILE_CONTENT']; ?> &nbsp;<small><i id="sign" class="fa fa-exclamation-triangle text-danger hidden"></i></small> &nbsp;<i id="additionalLabelInfo" class="small text-danger hidden"><?php echo $lang['LANGUAGE_FILE_WARNING']; ?></i></label>
                        <textarea id="languageContent" name="languageContent" rows="30" class="form-control"></textarea>
                    <div id="textbox"></div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title"><?php echo $lang['LANGUAGE']; ?> <small><?php echo $lang['DETERMINE']; ?></small></h3>
                </div>
                <div class="box-body">
                    <?php // \YAWK\settings::getFormElements($db, $settings, 19, $lang) ?>
                    <!-- backend language -->
                    <h3><i class="fa fa-language"></i>&nbsp;<?php echo $lang['BACKENDLANGUAGE_HEADING']."&nbsp;<small>$lang[BACKENDLANGUAGE_SUBTEXT]</small>";  ?></h3>
                    <label id="backendLanguge" for="backendLanguge"><?php echo $lang['BACKENDLANGUAGE_LABEL']; ?></label>
                    <select id="backendLanguge" name="backendLanguage" class="form-control">
                    <?php
                    $dbLanguage = settings::getSetting($db, "backendLanguage");
                    echo "<option value=\"$dbLanguage\">$lang[CURRENT] $dbLanguage</option>";
                    // get all language files from folder to array
                    $backendLanguageFiles = filemanager::getFilesFromFolderToArray('language');
                    // walk through array
                    foreach ($backendLanguageFiles AS $file)
                    {   // exclude .htaccess
                        if ($file != ".htaccess")
                        {   // extract language tag from filename
                            $languageTag = substr($file, -9, 5); // returns eg "en-EN"
                            // create option for each language file
                            echo "<option value=\"$languageTag\">$languageTag</option>";
                        }
                    }
                    ?>
                    </select>
                    <br>
                    <!-- frontend Language selection -->
                    <h3><i class="fa fa-language"></i>&nbsp;<?php echo $lang['FRONTENDLANGUAGE_HEADING']."&nbsp;<small>$lang[FRONTENDLANGUAGE_SUBTEXT]</small>";  ?></h3>
                    <label id="frontendLanguge" for="frontendLanguge"><?php echo $lang['FRONTENDLANGUAGE_LABEL']; ?></label>
                    <select id="frontendLanguge" name="frontendLanguage" class="form-control">
                        <?php
                        $dbLanguage = settings::getSetting($db, "frontendLanguage");
                        echo "<option value=\"$dbLanguage\">$lang[CURRENT] $dbLanguage</option>";
                        // get all language files from folder to array
                        // this has been declared before - no need to get it twice from database.
                        // $languageFiles = \YAWK\filemanager::getFilesFromFolderToArray('language'); // declared before
                        // walk through array
                        foreach ($backendLanguageFiles AS $file)
                        {   // exclude .htaccess
                            if ($file != ".htaccess")
                            {   // extract language tag from filename
                                $languageTag = substr($file, -9, 5); // returns eg "en-EN"
                                // create option for each language file
                                echo "<option value=\"$languageTag\">$languageTag</option>";
                            }
                        }
                        ?>
                    </select>
                    <br><br>
                </div>
            </div>
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title"><?php echo $lang['TRANSLATION']; ?> <small><?php echo $lang['EDIT']; ?></small></h3>
                </div>
                <div class="box-body">
                    <label id="editLanguageSelectLabel" for="editLanguageSelect"><?php echo $lang['LANGUAGE_WHICH_EDIT']; ?></label>
                    <select id="editLanguageSelect" name="editLanguageSelect" class="form-control">
                        <option value="null"><?php echo $lang['PLEASE_SELECT']; ?></option>
                        <?php
                            // get all language files from folder to array
                            $backendLanguageFiles = filemanager::getFilesFromFolderToArray('language');
                            $frontendLanguageFiles = filemanager::getFilesFromFolderToArray('../system/language');
                            // walk through array
                            foreach ($backendLanguageFiles AS $file)
                            {   // exclude .htaccess
                                if ($file != ".htaccess")
                                {   // create option for each language file
                                    echo "<option value=\"language/$file\">backend/$file</option>";
                                }
                            }
                            foreach ($frontendLanguageFiles AS $file)
                            {   // exclude .htaccess
                                if ($file != ".htaccess")
                                {   // create option for each language file
                                    echo "<option value=\"../system/language/$file\">frontend/$file</option>";
                                }
                            }
                        ?>
                    </select>
                    <div id="editLanguageFooter">
                        <button id="editLanguageBtn" name="editLanguageBtn" class="btn btn-success pull-right hidden" style="margin-top:10px;"><i class="fa fa-check"></i> &nbsp;
                            <?php echo $lang['SAVE_TRANSLATION']; ?></button>
                        <a href="index.php?page=settings-language" id="cancelLanguageBtn" class="btn btn-danger pull-right hidden" style="margin-top:10px; margin-right:2px;"><i class="fa fa-times"></i> &nbsp;<?php echo $lang['CANCEL']; ?></a>
                    </div>
                </div>
            </div>
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title"><?php echo $lang['LANGUAGES']; ?> <small><?php echo $lang['RESTORE']; ?></small></h3>
                </div>
                <div class="box-body">
                    <i class="fa fa-exclamation-triangle text-danger"></i>&nbsp;&nbsp;<?php echo $lang['LANGUAGE_RESET']; ?>
                    <a class="btn btn-default pull-right" id="resetLanguageBtn" role="dialog" data-confirm="<?php echo $lang['ARE_YOU_SURE'];?>" title="<?php echo $lang['RESTORE_LANGUAGE']; ?>" href="index.php?page=settings-language&restore=1&action=true"><i class="fa fa-language text-danger"></i>&nbsp;&nbsp;Backup laden</a>
                </div>
            </div>
</form>

                <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title"><?php echo $lang['LANGUAGES']; ?> <small><?php echo $lang['UPLOAD']; ?></small></h3>
                </div>
                <div class="box-body">
                    <form id="template-edit-form" enctype= "multipart/form-data" action="index.php?page=settings-language" method="POST">
                    <label for="folder"><?php echo $lang['SELECT_FOLDER']; ?></label>
                        <select name="uploadFolder" class="form-control" id="folder">
                            <option value=""><?php echo $lang['PLEASE_SELECT']; ?></option>
                            <option value="frontend">FrontEnd (system/language)</option>
                            <option value="backend">BackEnd (admin/language)</option>
                        </select>
                        <label for="file"><?php echo $lang['SELECT_FILE']; ?></label>
                        <input id="file" name="file" type="file" class="form-control">
                        <small><?php echo $lang['LANGUAGE_UPLOAD_INFO']; ?></small>
                        <button type="submit" style="margin-top:10px;" class="btn btn-default pull-right" id="uploadLanguageBtn" name="uploadLanguageBtn" role="dialog" data-confirm="<?php echo $lang['ARE_YOU_SURE'];?>" title="<?php echo $lang['LANGUAGE_UPLOAD']; ?>"><i class="fa fa-upload"></i>&nbsp;&nbsp;<?php echo $lang['LANGUAGE_UPLOAD']; ?></button>
                        <input type="hidden" name="upload" value="1">
                        <input type="hidden" name="action" value="true">
                    </form>
                </div>
            </div>
        </div>
    </div>
<style>
    html, body {height: 100%;}
    .CodeMirror {height:50em;}
    .CodeMirror-scroll {height: 100%;}
</style>

<script type="text/javascript">


    $(document).ready(function() {
        function saveHotkey() {
                // simply disables save event for chrome
                $(window).keypress(function (event) {
                    if (!(event.which === 115 && (navigator.platform.match("Mac") ? event.metaKey : event.ctrlKey)) && !(event.which === 19)) return true;
                    event.preventDefault();
                    formmodified = 0; // do not warn user, just save.
                    return false;
                });
                // used to process the cmd+s and ctrl+s events
                $(document).keydown(function (event) {
                    if (event.which === 83 && (navigator.platform.match("Mac") ? event.metaKey : event.ctrlKey)) {
                        event.preventDefault();
                        $('#savebutton').click(); // SAVE FORM AFTER PRESSING STRG-S hotkey
                        formmodified = 0; // do not warn user, just save.
                        // save(event);
                        return false;
                    }
                });
            }

            saveHotkey();

        const savebutton = ('#savebutton');
        const savebuttonIcon = ('#savebuttonIcon');
            // ok, lets go...
            // we need to check if user clicked on save button
            $(savebutton).click(function () {
                $(savebutton).removeClass('btn btn-success').addClass('btn btn-warning disabled');
                $(savebuttonIcon).removeClass('fa fa-check').addClass('fa fa-spinner fa-spin fa-fw');
        });

        // init vars
        const languageContent = $("#languageContent");
        const editlanguageSelectLabel = $("#editLanguageSelectLabel");
        const editLanguageSelect = $("#editLanguageSelect");
        const cancelLanguageBtn = $("#cancelLanguageBtn");
        const editLanguageBtn = $("#editLanguageBtn");
        const additionalLabel = $("#additionalLabelInfo");
        const sign = $("#sign");

        // user select a language to edit from select option
        $(editLanguageSelect).on('change', function()
        {
            // get filename from select option value
            fn = this.value;    // language file

            // codemirror configuration
            let config, editor;
            config = {
                theme: '<?php echo $editorSettings['editorTheme']; ?>',                       // codeview theme
                lineNumbers: true,                                                            // display lineNumbers true|false
                undoDepth: <?php echo $editorSettings['editorUndoDepth']; ?>,                 // how many undo steps should be saved? (default: 200)
                smartIndent: <?php echo $editorSettings['editorSmartIndent']; ?>,             // better indent
                indentUnit: <?php echo $editorSettings['editorIndentUnit']; ?>,               // how many spaces auto indent? (default: 2)
                mode: "css",
                styleActiveLine: <?php echo $editorSettings['editorActiveLine']; ?>           // highlight the active line (where the cursor is)
            };

            // prevent caching
            $.ajaxSetup({ cache: false });
            // get language from filename
            $.get(fn, function (response) {
                language = response;
                // launch codemirror and load language file (value) into it
                editor = CodeMirror.fromTextArea(document.getElementById("languageContent"), config).setValue(language);
            });

            // show save button
            $(editLanguageBtn).removeClass('btn btn-success pull-right hidden').addClass('btn btn-success pull-right');
            // show exclamation sign
            $(sign).removeClass('fa fa-exclamation-triangle text-danger hidden').addClass('fa fa-exclamation-triangle text-danger');
            // show file edit warning
            $(additionalLabel).removeClass('small hidden').addClass('small');
            // make cancel button visible
            $(cancelLanguageBtn).removeClass('btn btn-danger pull-right hidden').addClass('btn btn-danger pull-right');

            // if save language btn is clicked
            $(editLanguageBtn).click(function() {
                // release (enable) select options field
                $(editLanguageSelect).prop('disabled', false);
                // hide cancel button
                $(cancelLanguageBtn).removeClass('btn btn-danger pull-right').addClass('btn btn-danger pull-right hidden');
                // hide additional info
                $(additionalLabel).removeClass('small').addClass('small hidden');
                // hide exclamation sign
                $(sign).removeClass('fa fa-exclamation-triangle text-danger').addClass('fa fa-exclamation-triangle text-danger hidden');
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