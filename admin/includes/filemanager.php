<!-- TAB collapse -->
<script type="text/javascript" src="../system/engines/jquery/bootstrap-tabcollapse.js"></script>
<!-- data tables JS -->
<script type="text/javascript">
    $(document).ready(function() {
        /*
        $('#table-sort').dataTable( {
            "bPaginate": false,
            "bLengthChange": false,
            "bFilter": true,
            "bSort": true,
            "bInfo": true,
            "bAutoWidth": false
        });
        */

        // make bootstrap tabs responsive to improve handheld experience
        $('#myTab').tabCollapse({
            tabsClass: 'hidden-sm hidden-xs',
            accordionClass: 'visible-sm visible-xs'
        });

    });
    /** MAKE SURE THAT THE LAST USED TAB STAYS ACTIVE
     * thanks to http://stackoverflow.com/users/463906/ricsrock
     * http://stackoverflow.com/questions/10523433/how-do-i-keep-the-current-tab-active-with-twitter-bootstrap-after-a-page-reload
     */
    $(function() {
        // for bootstrap 3 use 'shown.bs.tab', for bootstrap 2 use 'shown' in the next line
        $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
            // save the latest tab; use cookies if you like 'em better:
            localStorage.setItem('lastTab', $(this).attr('href'));
        });
        // go to the latest tab, if it exists:
        var lastTab = localStorage.getItem('lastTab');
        if (lastTab) {
            $('[href="' + lastTab + '"]').tab('show');
            // to work correctly, we need to lowercase
            var activeTab = lastTab.toLowerCase();
            // and remove the first char (#)
            var activeFolder = activeTab.slice(1);
            // all done: set select default selected option
            $('select option[value="'+activeFolder+'"]').prop('selected', true);
        }
    });


    /**
     * setRenameFieldState(path, itemName)
     * Update the rename input text field with current content (file or folder)
     * Set focus on input text field and select all it's content for better usability.
     * path string contains the current working path
     * itemName string contains the current item name to be processed (renamed)
     * itemType string contains the current item type (folder or file)
     * */
    function setRenameFieldState(path, itemName, itemType)
    {
        // store input field
        inputField = $("#newItemName");
        // when rename modal is shown
        $('#renameModal').on('shown.bs.modal', function () {
            // set focus on input field and select it
            $(inputField).focus().select();
        });
        // add the current itemName to var
        inputField.val(itemName);
        // set path hidden field with value from php function getFilesFromFolder();
        $("#path").val(path);
        // set old item name hidden field with value from php
        $("#oldItemName").val(itemName);
        // set item type (folder or file) with value from php
        $("#itemType").val(itemType);
        // set text of heading div (folder or file) w. value from php
        $("#fileTypeHeading").text(itemType);
        // set text of label (folder or file) w. value from php
        $("#newItemNameLabel").text(itemType);
    }


    /**
     * setChmodFieldState(path, chmodCode)
     * Update the chmod input text field with current content (eg 0755)
     * Set focus on the custom input text field and select all it's content for better usability.
     * path string contains the current working path
     * chmodCode string contains the current chmod octal number to be processed
     * */
    function setChmodCode(item, chmodCode)
    {
        // store input field
        inputField = $("#customChmodCode");
        // when rename modal is shown
        $('#chmodModal').on('shown.bs.modal', function () {
            // set focus on input field and select it
            $(inputField).focus().select();
        });
        // add the folderName to input field
        inputField.val(chmodCode);
        $("#item").val(item);
    }

    /**
     * If user switch a folder (tab), the upload folder select option automatically gets set to this folder
     * called by clicking on <li>TAB links</li> onclick(flipTheSwitch(folder));
     * @param folder string the folder to switch
     */
    function flipTheSwitch(folder)
    {
        // get folder and set this option selected to all select fields on that page
        $('select option[value="'+folder+'"]').prop('selected', true);
    }
// EOF JAVASCRIPT
</script>

<?php
/**
 * THE PHP PART
 * cares about all the logic handling. Stuff like
 *  - upload
 *  - delete
 *  - rename
 *  - chmod
 *
 */

/* UPLOAD FILE PROCESSING */

use YAWK\alert;
use YAWK\backend;
use YAWK\db;
use YAWK\filemanager;
use YAWK\language;
use YAWK\settings;
use YAWK\sys;

/** @var $db db */
/** @var $lang language */

if (isset($_POST['upload']))
{   // folder was selected
    if (isset($_POST['folderselect']))
    {   // prepare upload folder vars
        $upload_folder = $_POST['folderselect'];
        $upload_folder = "../media/$upload_folder/";
    }
    else
    {   // no folder selected - set default upload folder
        $upload_folder = "../media/uploads/";
    }
    // check if upload was sent...
    switch ($_POST['upload'])
    {   // upload is sent
        case "sent":
            // set full target path including filename
            $target_path = $upload_folder . basename( $_FILES['file']['name']);
            // move file to target path
            if(move_uploaded_file($_FILES['file']['tmp_name'], $target_path))
            {   // store uploaded file
                $file = basename( $_FILES['file']['name']);
                // ok, set syslog entry
                sys::setSyslog($db, 25, 0, "uploaded <b>$file</b>", 0, 0, 0, 0);
                // upload OK, throw alert msg
                print alert::draw("success", "$lang[SUCCESS]", "$lang[UPLOAD_SUCCESSFUL]: $lang[FILE] <strong>".$file."</strong>", "", 800);
            }
            else
            {   // could not upload file, throw error
                $file = basename( $_FILES['file']['name']);
                // failed - set syslog entry
                sys::setSyslog($db, 28, 1, "failed to upload <b>$file</b>", 0, 0, 0, 0);
                // throw error msg
                print alert::draw("danger", "$lang[ERROR]", "$lang[UPLOAD_FAILED]: ".$_FILES['file']['name']."", "", 5800);
            }
            break;
    }
}

/* DELETE ITEM PROCESSING */
if (isset($_GET['delete']))
{   // user clicked on delete
    if ($_GET['delete']==1 AND (isset($_GET['item'])))
    {   // prepare vars
        if (isset($_GET['path']))
        {
            $path = $_GET['path'];
        }
        else
            {
                $path = '';
            }
        $path=$_GET['path'];
        $item=$_GET['item'];
        $file="$path"."/"."$item";
        // execute delete command
        if (YAWK\filemanager::deleteItem($file) === true)
        {   // DELETE SUCCESSFUL, set syslog entry
            sys::setSyslog($db, 25, 0, "deleted $file", 0, 0, 0, 0);
            // throw success msg
            print alert::draw("success", "$lang[SUCCESS]", "$lang[FILE] $file $lang[DELETE_SUCCESSFUL]","","1200");
        }
        else
        {   // DELETE FAILED, set syslog entry
            sys::setSyslog($db, 28, 1, "failed to delete $file", 0, 0, 0, 0);
            // throw error msg
            print alert::draw("danger", "$lang[ERROR]", "$lang[FILE] $file $lang[DELETE_FAILED]","","2400");
        }
    }
}

/* RENAME ITEM PROCESSING */
if (isset($_POST['renameItem']) && ($_POST['renameItem'] === "true"))
{
    // check if new item name is set...
    if (isset($_POST['newItemName']) && (!empty($_POST['newItemName'])))
    {
        if (isset($_POST['path']) && (!empty($_POST['path'])))
        {
            // remove special chars from folder name
            $newItemName = filemanager::removeSpecialChars($_POST['newItemName']);
            // rename from
            $from = "$_POST[path]/$_POST[oldItemName]";
            // rename to
            $to = "$_POST[path]/$newItemName";
        }
        // check if item type is set
        if (isset($_POST['itemType']) && (!empty($_POST['itemType'])))
        {   // set item type var for output in syslog and alert message
            $itemType = $_POST['itemType'];
        }
        else
        {   // item type unknown - leave empty
            $itemType = 'ITEM';
        }

        // rename folder
        if (rename($from, $to))
        {
            sys::setSyslog($db, 25, 0,"folder renamed: $_POST[oldItemName] file to $_POST[newItemName]", 0, 0, 0, 0);
            echo alert::draw("success", "$lang[SUCCESS]", "$lang[$itemType] $lang[RENAMED]: <i>$_POST[oldItemName]</i> $lang[FILEMAN_TO] <b>$_POST[newItemName]</b>","","1200");

        }
        else
            {
                sys::setSyslog($db, 28, 0, "failed to rename $_POST[oldItemName] file to $_POST[newItemName]", 0, 0, 0, 0);
                echo alert::draw("danger", "$lang[ERROR]", "$lang[$itemType] $lang[RENAMED] $_POST[oldFolderName] $lang[FILEMAN_TO] $_POST[newFolderName] $lang[FAILED]","","4800");
            }
    }
}
/* CHMOD ITEM PROCESSING */
// check if user clicked on chmod icon
if (isset($_POST['chmod']) && ($_POST['chmod'] === "true"))
{   // check if item  is set
    if (isset($_POST['item']) && (!empty($_POST['item'])))
    {   // check if chmod code is set
        if (isset($_POST['chmodCode']) && (!empty($_POST['chmodCode'])))
        {   // check if chmod code is selected or not
            if ($_POST['chmodCode'] === "false")
            {   // check if a custom chmod code is set
                if (isset($_POST['customChmodCode']))
                {   // overwrite chmodcode with custom code
                    $_POST['chmodCode'] = $_POST['customChmodCode'];
                }
            }
            // do chmod on item...
            if (chmod($_POST['item'], octdec($_POST['chmodCode'])))
            {   // chmod successful
                print alert::draw("success", "$lang[SUCCESS]", "$lang[FILEMAN_CHANGED_CHMOD] $lang[TO] $_POST[chmodCode]","","1200");
            }
            else
                {   // chmod failed, throw error
                    print alert::draw("success", "$lang[DANGER]", "$lang[FILEMAN_CHANGED_CHMOD] $_POST[item] $lang[TO] $_POST[chmodCode] $_POST[FAILED]","","1200");
                }
        }
    }
}

/* NEW FOLDER PROCESSING */
if (isset($_POST['addFolder']) && ($_POST['addFolder'] === "true"))
{
    // check if new folder is set
    if (isset($_POST['newFolder']) && (!empty($_POST['newFolder'])))
    {   // remove special chars from new folder
        $newFolder = filemanager::removeSpecialChars($_POST['newFolder']);
    }
    else
        {
            $newFolder = '';
        }

    if (isset($_POST['folderselect']))
    {   // prepare upload folder vars
        $selectedFolder = $_POST['folderselect'];
        $selectedFolder = "../media/$selectedFolder/";
    }
    else
    {   // no folder selected - set default upload folder
        $selectedFolder = "../media/uploads/";
    }

    // ok... newFolder is set + checked, store folder is selected...
    // now merge selectedFolder and newFolder to path used by mkdir
    $newDirectory = "$selectedFolder$newFolder";
    // create new folder...
    if (mkdir($newDirectory))
    {   // CREATE DIR SUCCESSFUL, set syslog entry
        sys::setSyslog($db, 25, 0, "created new folder: $newDirectory", 0, 0, 0, 0);
        // throw success msg
        print alert::draw("success", "$lang[SUCCESS]", "$lang[FOLDER] $newDirectory $lang[CREATED]","","1200");
    }
    else
        {   // failed to create directory, set syslog entry
            sys::setSyslog($db, 28, 1,"failed to create new folder: $newDirectory", 0, 0, 0, 0);
            // throw success msg
            print alert::draw("success", "$lang[SUCCESS]", "$lang[FOLDER] $newDirectory $lang[CREATED]","","1200");
        }
}

/* when a path is set, user is in a subdirectory.
   disable all other tabs in that case... */
if (isset($_GET['path']) && (!empty($_GET['path'])))
{
    // check, if user is in allowed path
    if ($_GET['path'] = strstr($_GET['path'], "../media"))
    {   // prepare vars with html content for tabs
        $firstTabStatus = "class=\"active disabled\"";
        $disabledStatus = "class=\"disabled\"";
        $dataToggle = '';
    }
    else
        {   // if not - user maybe manipulated $path variable, to see files above ../media - throw error
            alert::draw("danger", "$lang[ERROR]", "$lang[ACTION_FORBIDDEN]", 0, 6000);
        }
}
else
    {   // prepare vars with html content for tabs
        $firstTabStatus = "class=\"active\"";
        $dataToggle = " data-toggle=\"tab\"";
        $disabledStatus = '';
    }
?>
<script src="../system/engines/jquery/dropzone/dropzone.js"></script>
<link href="../system/engines/jquery/dropzone/dropzone.css" rel="stylesheet">
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper" id="content-FX">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <!-- draw title on top-->
        <?php echo backend::getTitle($lang['FILEMAN_TITLE'], $lang['FILEMAN_SUBTEXT']); ?>
        <ol class="breadcrumb">
            <li><a href="index.php?page=dashboard" title="<?php echo $lang['DASHBOARD']; ?>"><i class="fa fa-dashboard"></i> <?php echo $lang['DASHBOARD']; ?></a></li>
            <li class="active"><a href="index.php?page=filemanager" title="<?php echo $lang['FILEMANAGER']; ?>"> <?php echo $lang['FILEMANAGER']; ?></a></li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
        <div class="col-md-8">
    <!-- START CONTENT HERE -->
<div class="box box-default">
    <div class="box-body">

<?php $maxFileSize = filemanager::getPhpMaxUploadSize(); ?>
<!-- FILE UPLOAD MODAL DIALOG -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <br>
                <div class="col-md-1"><h3 class="modal-title"><i class="fa fa-folder-open-o"></i></h3></div>
                <div class="col-md-11"><h3 class="modal-title"><?php print $lang['FILEMAN_UPLOAD']; ?> (max <?php print $maxFileSize; ?>B)</h3></div>
            </div>
            <div class="modal-body">
                <form enctype="multipart/form-data" class="dropzone" action="index.php?page=filemanager" method="POST">
                    <input type="hidden" name="MAX_FILE_SIZE" value="">
                    <input type="hidden" name="upload" value="sent">
                    <!--  <label for="uploadedfile"></label>
                    <input class="btn btn-default btn-file" id="uploadedfile" name="uploadedfile" type="file" multiple><br> !-->

                    <label for="folderselect"><?php echo $lang['UPLOAD_TO']; ?>: </label>
                    <select id="folderselect" name="folderselect" class="form-control">
                        <option value="audio"><?php echo $lang['FILEMAN_AUDIO']; ?></option>
                        <option value="backup"><?php echo $lang['FILEMAN_BACKUP']; ?></option>
                        <option value="documents"><?php echo $lang['FILEMAN_DOCUMENTS']; ?></option>
                        <option value="downloads"><?php echo $lang['FILEMAN_DOWNLOADS']; ?></option>
                        <option value="images" selected><?php echo $lang['FILEMAN_IMAGES']; ?></option>
                        <option value="uploads"><?php echo $lang['FILEMAN_UPLOADS']; ?></option>
                        <option value="video"><?php echo $lang['FILEMAN_VIDEOS']; ?></option>
                    </select>
                    <br>
                    <div class="modal-footer">
                        <input class="btn btn-large btn-success pull-right" type="submit" value="Datei&nbsp;hochladen" />
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal --ADD FOLDER  -- -->
<div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModal2Label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form enctype="multipart/form-data" action="index.php?page=filemanager" method="POST">
            <div class="modal-header">
                <!-- modal header with close controls -->
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
                <br>
                <div class="col-md-1"><h3 class="modal-title"><i class="fa fa-folder-open-o"></i></h3></div>
                <div class="col-md-11"><h3 class="modal-title"><?php print $lang['FILEMAN_ADD_FOLDER']; ?></h3></div>
            </div>
            <div class="modal-body">
                <input type="hidden" name="addFolder" value="true">
                <!-- save to... folder select options -->
                <label for="folderselect"><?php echo $lang['SAVE_TO']; ?> </label>
                <select id="folderselect" name="folderselect" class="form-control">
                    <optgroup label="Media Folder">
                        <option value="audio"><?php echo $lang['FILEMAN_AUDIO']; ?></option>
                        <option value="backup"><?php echo $lang['FILEMAN_BACKUP']; ?></option>
                        <option value="documents"><?php echo $lang['FILEMAN_DOCUMENTS']; ?></option>
                        <option value="downloads"><?php echo $lang['FILEMAN_DOWNLOADS']; ?></option>
                        <option value="images" selected><?php echo $lang['FILEMAN_IMAGES']; ?></option>
                        <option value="uploads"><?php echo $lang['FILEMAN_UPLOADS']; ?></option>
                        <option value="video"><?php echo $lang['FILEMAN_VIDEOS']; ?></option>
                        <?php
                            // if all subdirectories should be drawn, uncomment the following line
                            filemanager::subdirToOptions("../media/");
                        ?>
                </select>
                <!-- new folder -->
                <label for="newFolder"><?php print $lang['FILEMAN_ADD_FOLDER_LABEL']; ?></label>
                <input id="newFolder" name="newFolder" class="form-control" placeholder="<?php print $lang['FILEMAN_ADD_FOLDER_PLACEHOLDER']; ?>">
            </div>
            <!-- modal footer /w submit btn -->
            <div class="modal-footer">
                <input type="hidden" name="move" value="sent">
                <input class="btn btn-large btn-success" type="submit" value="<?php echo $lang['FILEMAN_ADD_FOLDER_BTN']; ?>">
                <br><br>
            </div>
            </form>
        </div> <!-- modal content -->
  </div> <!-- modal dialog -->
 </div>


<!-- Modal --RENAME FOLDER  -- -->
<div class="modal fade" id="renameModal" tabindex="-1" role="dialog" aria-labelledby="myModal2Label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form enctype="multipart/form-data" action="index.php?page=filemanager" method="POST">
            <div class="modal-header">
            <!-- modal header with close controls -->
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i> </button>
                <br>
                <div class="col-md-1"><h3 class="modal-title"><i class="fa fa-pencil"></i></h3></div>
                <div class="col-md-11"><h3 class="modal-title"><div id="fileTypeHeading"> <!-- gets filled via JS setRenameFieldState--></div></h3></div>
            </div>

            <!-- modal body -->
            <div class="modal-body">
                <input type="hidden" id="renameItem" name="renameItem" value="true">
                <input type="hidden" id="oldItemName" name="oldItemName">
                <input type="hidden" id="itemType" name="itemType">
                <input type="hidden" id="path" name="path">
                <!-- save to... folder select options -->
                <label id="newItemNameLabel" for="newItemName"><!-- gets filled via JS setRenameFieldState --> </label>
                <input id="newItemName" class="form-control" name="newItemName" value="" autofocus>
            </div>

            <!-- modal footer /w submit btn -->
            <div class="modal-footer">
                <input class="btn btn-large btn-success" type="submit" value="<?php echo $lang['RENAME']; ?>">
                <br><br>
            </div>
            </form>
        </div> <!-- modal content -->
    </div> <!-- modal dialog -->
</div>

<!-- Modal --CHMOD WINDOW-- -->
<div class="modal fade" id="chmodModal" tabindex="-1" role="dialog" aria-labelledby="myModal2Label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form enctype="multipart/form-data" action="index.php?page=filemanager" method="POST">
            <div class="modal-header">
                <!-- modal header with close controls -->
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
                <br>
                <div class="col-md-1"><h3 class="modal-title"><i class="fa fa-edit"></i></h3></div>
                <div class="col-md-11"><h3 class="modal-title"><?php echo $lang['FILEMAN_CHMOD']; ?></h3></div>
            </div>
            <!-- modal body -->
            <div class="modal-body">
                <input type="hidden" id="chmod" name="chmod" value="true">
                <input type="hidden" id="item" name="item">
                <input type="hidden" id="path" name="path">

                <!-- chmod select field -->
                <label for="chmodCode"><?php echo $lang['FILEMAN_CHMOD']; ?></label>
                <select id="chmodCode" name="chmodCode" class="form-control">
                    <option value="false"><?php echo $lang['FILEMAN_CHMOD_SELECT']; ?></option>
                    <optgroup label="<?php echo $lang['FILEMAN_HIGH_SEC_LVL']; ?>"></optgroup>
                    <option value="0600"><?php echo $lang['FILEMAN_0600']; ?></option>
                    <option value="0644"><?php echo $lang['FILEMAN_0644']; ?></option>
                    <optgroup label="<?php echo $lang['FILEMAN_CASUAL_SEC_LVL']; ?>"></optgroup>
                    <option value="0750"><?php echo $lang['FILEMAN_0750']; ?></option>
                    <option value="0755"><?php echo $lang['FILEMAN_0755']; ?></option>
                    <optgroup label="<?php echo $lang['FILEMAN_LOW_SEC_LVL']; ?>"></optgroup>
                    <option value="0777"><?php echo $lang['FILEMAN_0777']; ?></option>
                </select>

                <!-- chmod custom field -->
                <label for="customChmodCode"><?php echo $lang['FILEMAN_CHMOD_CUSTOM']; ?> </label>
                <input id="customChmodCode" class="form-control" name="customChmodCode" value="">
            </div>

            <!-- modal footer /w submit btn -->
            <div class="modal-footer">
                <input type="hidden" name="move" value="sent">
                <input class="btn btn-large btn-success" type="submit" value="<?php echo $lang['FILEMAN_CHMOD']; ?>">
                <br><br>
            </div>
            </form>
        </div> <!-- modal content -->
    </div> <!-- modal dialog -->
</div>
<!-- START FILEMANAGER CONTENT  -->
<!-- Tabs -->
<ul id="myTab" class="nav nav-tabs">
    <li <?php echo $firstTabStatus; ?>><a href="#images" onclick="flipTheSwitch('images');"<?php echo $dataToggle; ?>><i class="fa fa-picture-o"></i> &nbsp;<?php echo $lang['FILEMAN_IMAGES']; ?></a></li>
    <li <?php echo $disabledStatus; ?>><a href="#audio" onclick="flipTheSwitch('audio');"<?php echo $dataToggle; ?>><i class="fa fa-music"></i> &nbsp;<?php echo $lang['FILEMAN_AUDIO']; ?></a></li>
    <li <?php echo $disabledStatus; ?>><a href="#video" onclick="flipTheSwitch('video');"<?php echo $dataToggle; ?>><i class="fa fa-video-camera"></i> &nbsp;<?php echo $lang['FILEMAN_VIDEOS']; ?></a></li>
    <li <?php echo $disabledStatus; ?>><a href="#documents" onclick="flipTheSwitch('documents');"<?php echo $dataToggle; ?>><i class="fa fa-file-text-o"></i> &nbsp;<?php echo $lang['FILEMAN_DOCUMENTS']; ?></a></li>
    <li <?php echo $disabledStatus; ?>><a href="#downloads" onclick="flipTheSwitch('downloads');"<?php echo $dataToggle; ?>><i class="fa fa-download"></i> &nbsp;<?php echo $lang['FILEMAN_DOWNLOADS']; ?></a></li>
    <li <?php echo $disabledStatus; ?>><a href="#uploads" onclick="flipTheSwitch('uploads');"<?php echo $dataToggle; ?>><i class="fa fa-upload"></i> &nbsp;<?php echo $lang['FILEMAN_UPLOADS']; ?></a></li>
    <li <?php echo $disabledStatus; ?>><a href="#backup" onclick="flipTheSwitch('backup');"<?php echo $dataToggle; ?>><i class="fa fa-file-zip-o"></i> &nbsp;<?php echo $lang['FILEMAN_BACKUP']; ?></a></li>
   <?php
        $webmail_active = settings::getSetting($db, "webmail_active");
        if ($webmail_active == true)
        {
            echo '<li '.$disabledStatus.'><a href="#mailbox" '.$dataToggle.'><i class="fa fa-envelope-o"></i> &nbsp;'.$lang["WEBMAIL"].'</a></li>';
        }
    ?>
</ul>

<!-- content start -->
<div id="myTabContent" class="tab-content">
    <!-- images folder -->
    <div class="tab-pane fade in active" id="images">
        <br>
        <?php YAWK\filemanager::drawTableHeader($lang, 5); ?>
        <?php YAWK\filemanager::getFilesFromFolder("../media/images", $lang); ?>
        <?php YAWK\filemanager::drawTableFooter(); ?>
    </div>
    <!-- audio folder -->
    <div class="tab-pane fade in" id="audio">
        <br>
        <?php YAWK\filemanager::drawTableHeader($lang, 1); ?>
        <?php YAWK\filemanager::getFilesFromFolder("../media/audio", $lang); ?>
        <?php YAWK\filemanager::drawTableFooter(); ?>
    </div>
    <!-- video folder -->
    <div class="tab-pane fade in" id="video">
        <br>
        <?php YAWK\filemanager::drawTableHeader($lang, 7); ?>
        <?php YAWK\filemanager::getFilesFromFolder("../media/video", $lang); ?>
        <?php YAWK\filemanager::drawTableFooter(); ?>
    </div>
    <!-- documents folder -->
    <div class="tab-pane fade in" id="documents">
        <br>
        <?php YAWK\filemanager::drawTableHeader($lang, 3); ?>
        <?php YAWK\filemanager::getFilesFromFolder("../media/documents", $lang); ?>
        <?php YAWK\filemanager::drawTableFooter(); ?>
    </div>
    <!-- downloads folder -->
    <div class="tab-pane fade in" id="downloads">
        <br>
        <?php YAWK\filemanager::drawTableHeader($lang, 4); ?>
        <?php YAWK\filemanager::getFilesFromFolder("../media/downloads", $lang); ?>
        <?php YAWK\filemanager::drawTableFooter(); ?>
    </div>
    <!-- upload folder -->
    <div class="tab-pane fade in" id="uploads">
        <br>
        <?php YAWK\filemanager::drawTableHeader($lang, 6); ?>
        <?php YAWK\filemanager::getFilesFromFolder("../media/uploads", $lang); ?>
        <?php YAWK\filemanager::drawTableFooter(); ?>
    </div>
    <!-- backup folder -->
    <div class="tab-pane fade in" id="backup">
        <br>
        <?php YAWK\filemanager::drawTableHeader($lang, 2); ?>
        <?php YAWK\filemanager::getFilesFromFolder("../media/backup", $lang); ?>
        <?php YAWK\filemanager::drawTableFooter(); ?>
    </div>
    <!-- webmail folder (mailbox attachments) -->
    <?php
        if ($webmail_active == true)
        {
            echo "
            <div class=\"tab-pane fade in\" id=\"mailbox\">
            <br>";
                YAWK\filemanager::drawTableHeader($lang, 2);
                YAWK\filemanager::getFilesFromFolder("../media/mailbox", $lang);
                YAWK\filemanager::drawTableFooter();
            echo"</div>";
        }
    ?>
</div>

    </div>
</div>
        </div>
        <div class="col-md-4">
            <div class="box box-default">
                <div class="box-header">
                    <h3 class="box-title"><?php print $lang['FILEMAN_UPLOADS']; ?></h3>
                    <!-- add folder btn -->
                    <a class="btn btn-success" data-toggle="modal" data-target="#myModal2" href="#myModal" style="float:right;">
                    <i class="fa fa-folder-open-o"></i> &nbsp;<?php print $lang['FILEMAN_NEW_FOLDER']; ?></a>
                </div>
                <div class="box-body">
                    <form action="index.php?page=filemanager" method="POST" class="dropzone" enctype="multipart/form-data">
                        <input type="hidden" name="MAX_FILE_SIZE" value="">
                        <input type="hidden" name="upload" value="sent">
                        <!-- <label for="uploadedfile"></label>
                         <input class="btn btn-default btn-file" id="uploadedfile" name="uploadedfile" type="file" multiple> -->

                        <label for="folderselect"><?php echo $lang['UPLOAD_TO']; ?> </label>
                        <select id="folderselect" name="folderselect" class="form-control">
                            <optgroup label="Media Folder">
                            <option value="audio"><?php echo $lang['FILEMAN_AUDIO']; ?></option>
                            <option value="backup"><?php echo $lang['FILEMAN_BACKUP']; ?></option>
                            <option value="documents"><?php echo $lang['FILEMAN_DOCUMENTS']; ?></option>
                            <option value="downloads"><?php echo $lang['FILEMAN_DOWNLOADS']; ?></option>
                            <option value="images" selected><?php echo $lang['FILEMAN_IMAGES']; ?></option>
                            <option value="uploads"><?php echo $lang['FILEMAN_UPLOADS']; ?></option>
                            <option value="video"><?php echo $lang['FILEMAN_VIDEOS']; ?></option>
                            <?php
                            filemanager::subdirToOptions("../media/");
                            ?>
                        </select>
                    </form>
                </div>
            </div>
        </div>
</div>