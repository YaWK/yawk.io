<!-- TAB collapse -->
<script type="text/javascript" src="../system/engines/jquery/bootstrap-tabcollapse.js"></script>
<!-- data tables JS -->
<script type="text/javascript">
    $(document).ready(function() {
        $('#table-sort').dataTable( {
            "bPaginate": false,
            "bLengthChange": false,
            "bFilter": true,
            "bSort": true,
            "bInfo": true,
            "bAutoWidth": false
        });

        // make bootstrap tabs responsive to improve handheld experience
        $('#myTab').tabCollapse({
            tabsClass: 'hidden-sm hidden-xs',
            accordionClass: 'visible-sm visible-xs'
        });
    });
    // MAKE SURE THAT THE LAST USED TAB STAYS ACTIVE
    // thanks to http://stackoverflow.com/users/463906/ricsrock
    // http://stackoverflow.com/questions/10523433/how-do-i-keep-the-current-tab-active-with-twitter-bootstrap-after-a-page-reload
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

    $("#myTab").on("click", function(e) {
        if ($(this).hasClass("disabled"))
        {
            // e.removeAttr('data-toggle');
            e.preventDefault();
            return false;
        }
    });

    function disableTabs()
    {
        // placeholder
    }

    /**
     * If user switch a folder (tab), the upload folder select option automatically gets set to this folder
     * called by clicking on <li>TAB links</li> onclick(flipTheSwitch(folder));
     * @param folder string the folder to switch
     */
    function flipTheSwitch(folder)
    {   // get folder and set this option selected to all select fields on that page
        $('select option[value="'+folder+'"]').prop('selected', true);
    }

</script>
<?php
/* UPLOAD FILE PROCESSING */
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
                \YAWK\sys::setSyslog($db, 7, "$lang[UPLOADED] <b>$file</b>", 0, 0, 0, 0);
                // upload OK, throw alert msg
                print \YAWK\alert::draw("success", "$lang[SUCCESS]", "$lang[UPLOAD_SUCCESSFUL]: $lang[FILE] <strong>".$file."</strong>", "", 800);
            }
            else
            {   // could not upload file, throw error
                $file = basename( $_FILES['file']['name']);
                // failed - set syslog entry
                \YAWK\sys::setSyslog($db, 5, "$lang[UPLOAD_FAILED] <b>$file</b>", 0, 0, 0, 0);
                // throw error msg
                echo YAWK\alert::draw("danger", "$lang[ERROR]", "$lang[UPLOAD_FAILED]: ".$_FILES['file']['name']."", "", 5800);
            }
            break;
    }
}

/* DELETE ITEM PROCESSING */
if (isset($_GET['delete']))
{   // user clicked on delete
    if ($_GET['delete']==1 AND (isset($_GET['item'])))
    {   // prepare vars
        $path=$_GET['path'];
        $item=$_GET['item'];
        $file="$path"."/"."$item";
        // execute delete command
        if (YAWK\filemanager::deleteItem($file) === true)
        {   // DELETE SUCCESSFUL, set syslog entry
            \YAWK\sys::setSyslog($db, 8, "$lang[DELETED] $file", 0, 0, 0, 0);
            // throw success msg
            print \YAWK\alert::draw("success", "$lang[SUCCESS]", "$lang[FILE] $file $lang[DELETE_SUCCESSFUL]","","1200");
        }
        else
        {   // DELETE FAILED, set syslog entry
            \YAWK\sys::setSyslog($db, 5, "$lang[DELETE_FAILED] $file", 0, 0, 0, 0);
            // throw error msg
            print \YAWK\alert::draw("danger", "$lang[ERROR]", "$lang[FILE] $file $lang[DELETE_FAILED]","","2400");
        }
    }
}

/* NEW FOLDER PROCESSING */
if (isset($_POST['addFolder']) && ($_POST['addFolder'] === "true"))
{
    // check if new folder is set
    if (isset($_POST['newFolder']) && (!empty($_POST['newFolder'])))
    {
        // prepare newFolder variable
        // set var
        $newFolder = $_POST['newFolder'];
        // $string = 'V!e§r$s%c&h/i(e)d=e?n`e² S³o{n[d]e]r}z\e´i+c*h~e#n';
        // remove special chars
        $newFolder = preg_replace ('/[^a-z0-9- ]/i', '', $newFolder);
        // trim any whitespaces left or right
        $newFolder = trim($newFolder);
        // change any backslashes to regular slashes
        $newFolder = strtr($newFolder,"\\","/");
        // remove all leading slashes
        $newFolder = ltrim($newFolder, "/");
        // remove all trailing slashes
        $newFolder = rtrim($newFolder, "/");
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
        \YAWK\sys::setSyslog($db, 8, "$lang[CREATED] $newDirectory", 0, 0, 0, 0);
        // throw success msg
        print \YAWK\alert::draw("success", "$lang[SUCCESS]", "$lang[FOLDER] $newDirectory $lang[CREATED]","","1200");
    }
    else
        {   // CREATE DIR SUCCESSFUL, set syslog entry
            \YAWK\sys::setSyslog($db, 8, "$lang[ERROR] $newDirectory $lang[WAS_NOT_CREATED]", 0, 0, 0, 0);
            // throw success msg
            print \YAWK\alert::draw("success", "$lang[SUCCESS]", "$lang[FOLDER] $newDirectory $lang[CREATED]","","1200");
        }
}

if (isset($_GET['path']) && (!empty($_GET['path'])))
{
    $firstTabStatus = "class=\"active disabled\"";
    $disabledStatus = "class=\"disabled\"";
}
else
    {
        $firstTabStatus = "class=\"active\"";
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
        <?php echo \YAWK\backend::getTitle($lang['FILEMAN_TITLE'], $lang['FILEMAN_SUBTEXT']); ?>
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

<?php $maxFileSize = \YAWK\filemanager::getPhpMaxFileSize(); ?>
<!-- FILE UPLOAD MODAL DIALOG -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel"><?php print $lang['FILEMAN_UPLOAD']; ?> (max <?php print $maxFileSize; ?>B)</h4>
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
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">X</button>
                <h3 class="modal-title"><i class="fa fa-folder-open-o"></i> <?php print $lang['FILEMAN_ADD_FOLDER']; ?></h3>
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
                            \YAWK\filemanager::subdirToOptions("../media/");
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

<!-- START FILEMANAGER CONTENT  -->
<!-- Tabs -->
<ul id="myTab" class="nav nav-tabs">
    <li <?php echo $firstTabStatus; ?>><a href="#images" onclick="flipTheSwitch('images');" data-toggle="tab"><i class="fa fa-picture-o"></i> &nbsp;<?php echo $lang['FILEMAN_IMAGES']; ?></a></li>
    <li <?php echo $disabledStatus; ?>><a href="#audio" onclick="flipTheSwitch('audio');" aria-disabled="true" data-toggle="tab"><i class="fa fa-music"></i> &nbsp;<?php echo $lang['FILEMAN_AUDIO']; ?></a></li>
    <li <?php echo $disabledStatus; ?>><a href="#video" onclick="flipTheSwitch('video');" data-toggle="tab"><i class="fa fa-video-camera"></i> &nbsp;<?php echo $lang['FILEMAN_VIDEOS']; ?></a></li>
    <li <?php echo $disabledStatus; ?>><a href="#documents" onclick="flipTheSwitch('documents');" data-toggle="tab"><i class="fa fa-file-text-o"></i> &nbsp;<?php echo $lang['FILEMAN_DOCUMENTS']; ?></a></li>
    <li <?php echo $disabledStatus; ?>><a href="#downloads" onclick="flipTheSwitch('downloads');" data-toggle="tab"><i class="fa fa-download"></i> &nbsp;<?php echo $lang['FILEMAN_DOWNLOADS']; ?></a></li>
    <li <?php echo $disabledStatus; ?>><a href="#uploads" onclick="flipTheSwitch('uploads');" data-toggle="tab"><i class="fa fa-upload"></i> &nbsp;<?php echo $lang['FILEMAN_UPLOADS']; ?></a></li>
    <li <?php echo $disabledStatus; ?>><a href="#backup" onclick="flipTheSwitch('backup');" data-toggle="tab"><i class="fa fa-file-zip-o"></i> &nbsp;<?php echo $lang['FILEMAN_BACKUP']; ?></a></li>
</ul>

<!-- content start -->
<div id="myTabContent" class="tab-content">
    <!-- images folder -->
    <div class="tab-pane fade in active" id="images">
        <br>
        <?php YAWK\filemanager::drawTableHeader($lang, 5); ?>
        <?php YAWK\filemanager::getFilesFromFolder("../media/images", $path); ?>
        <?php YAWK\filemanager::drawTableFooter(); ?>
    </div>
    <!-- audio folder -->
    <div class="tab-pane fade in" id="audio">
        <br>
        <?php YAWK\filemanager::drawTableHeader($lang, 1); ?>
        <?php YAWK\filemanager::getFilesFromFolder("../media/audio", $path); ?>
        <?php YAWK\filemanager::drawTableFooter(); ?>
    </div>
    <!-- video folder -->
    <div class="tab-pane fade in" id="video">
        <br>
        <?php YAWK\filemanager::drawTableHeader($lang, 7); ?>
        <?php YAWK\filemanager::getFilesFromFolder("../media/video", $path); ?>
        <?php YAWK\filemanager::drawTableFooter(); ?>
    </div>
    <!-- documents folder -->
    <div class="tab-pane fade in" id="documents">
        <br>
        <?php YAWK\filemanager::drawTableHeader($lang, 3); ?>
        <?php YAWK\filemanager::getFilesFromFolder("../media/documents", $path); ?>
        <?php YAWK\filemanager::drawTableFooter(); ?>
    </div>
    <!-- downloads folder -->
    <div class="tab-pane fade in" id="downloads">
        <br>
        <?php YAWK\filemanager::drawTableHeader($lang, 4); ?>
        <?php YAWK\filemanager::getFilesFromFolder("../media/downloads", $path); ?>
        <?php YAWK\filemanager::drawTableFooter(); ?>
    </div>
    <!-- upload folder -->
    <div class="tab-pane fade in" id="uploads">
        <br>
        <?php YAWK\filemanager::drawTableHeader($lang, 6); ?>
        <?php YAWK\filemanager::getFilesFromFolder("../media/uploads", $path); ?>
        <?php YAWK\filemanager::drawTableFooter(); ?>
    </div>
    <!-- backup folder -->
    <div class="tab-pane fade in" id="backup">
        <br>
        <?php YAWK\filemanager::drawTableHeader($lang, 2); ?>
        <?php YAWK\filemanager::getFilesFromFolder("../media/backup", $path); ?>
        <?php YAWK\filemanager::drawTableFooter(); ?>
    </div>
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
                            \YAWK\filemanager::subdirToOptions("../media/");
                            ?>
                        </select>
                    </form>
                </div>
            </div>
        </div>
</div>