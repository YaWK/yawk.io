<!-- TAB collapse -->
<script type="text/javascript" src="../system/engines/jquery/bootstrap-tabcollapse.js"></script>
<script>
    // MAKE SURE THAT THE LAST USED TAB STAYS ACTIVE
    // thanks to http://stackoverflow.com/users/463906/ricsrock
    // http://stackoverflow.com/questions/10523433/how-do-i-keep-the-current-tab-active-with-twitter-bootstrap-after-a-page-reload
    $(function( ) {
        // for bootstrap 3 use 'shown.bs.tab', for bootstrap 2 use 'shown' in the next line
        $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
            // save the latest tab; use cookies if you like 'em better:
            localStorage.setItem('lastTab', $(this).attr('href'));

        });

        // go to the latest tab, if it exists:
        var lastTab = localStorage.getItem('lastTab');
        if (lastTab) {
            $('[href="' + lastTab + '"]').tab('show');

            // set select default option
            var activeTab = lastTab.toLowerCase();
            var activeFolder = activeTab.slice(1);
            $('select option[value="'+activeFolder+'"]').prop('selected', true);
        }

    });

    function flipTheSwitch(folder)
    {
        $('select option[value="'+folder+'"]').prop('selected', true);
    }
</script>
<?php

if (isset($_POST['upload']))
{
    if (isset($_POST['folderselect']))
    {   // prepare upload folder vars
        $upload_folder = $_POST['folderselect'];
        $upload_folder = "../media/$upload_folder/";
    }
    else
    {   // default upload folder
        $upload_folder = "../media/uploads/";
    }

    switch ($_POST['upload'])
    {   // upload is sent
        case "sent":
            // set full target path including filename
            $target_path = $upload_folder . basename( $_FILES['file']['name']);
            // move file

            if(move_uploaded_file($_FILES['file']['tmp_name'], $target_path))
            {   // store uploaded file
                $file = basename( $_FILES['file']['name']);
                \YAWK\sys::setSyslog($db, 7, "$lang[UPLOADED] <b>$file</b>", 0, 0, 0, 0);
                print \YAWK\alert::draw("success", "$lang[SUCCESS]", "$lang[UPLOAD_SUCCESSFUL]: $lang[FILE] <strong>".$file."</strong>", "", 800);
            }
            else
            {   // could not upload file, throw error
                $file = basename( $_FILES['file']['name']);
                \YAWK\sys::setSyslog($db, 5, "$lang[UPLOAD_FAILED] <b>$file</b>", 0, 0, 0, 0);
                echo YAWK\alert::draw("danger", "$lang[ERROR]", "$lang[UPLOAD_FAILED]: ".$_FILES['file']['name']."", "", 5800);
            }
            break;
    }
}

// DELETE ITEM
if (isset($_GET['delete']))
{   // user clicked on delete
    if ($_GET['delete']==1 AND (isset($_GET['item'])))
    {   // prepare vars
        $path=$_GET['path'];
        $item=$_GET['item'];
        $file="$path"."/"."$item";
        // execute delete command
        if (YAWK\filemanager::deleteItem($file) === true)
        {   // DELETE SUCCESSFUL, set syslog + throw success msg
            print \YAWK\alert::draw("success", "$lang[SUCCESS]", "$lang[FILE] $file $lang[DELETE_SUCCESSFUL]","","1200");
            \YAWK\sys::setSyslog($db, 8, "$lang[DELETED] $file", 0, 0, 0, 0);
        }
        else
        {   // DELETE FAILED, set syslog + throw error msg
            print \YAWK\alert::draw("danger", "$lang[ERROR]", "$lang[FILE] $file $lang[DELETE_FAILED]","","2400");
            \YAWK\sys::setSyslog($db, 5, "$lang[DELETE_FAILED] $file", 0, 0, 0, 0);
        }
    }
}

// MOVE ITEM
if (isset($_GET['move']))
{   // user clicked on move
    if ($_GET['move']==1 AND (isset($_GET['file'])))
    {
        $path=$_GET['path'];
        $item=$_GET['file'];
        $file="$path"."/"."$item";

        echo "<br><br><br>";
        echo $file; exit;

        // YAWK\filemanager::deleteItem($file, $_GET['folder']);
    }
}
?>
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

        // call tabCollapse: make the default bootstrap tabs responsive for handheld devices
        $('#myTab').tabCollapse({
            tabsClass: 'hidden-sm hidden-xs',
            accordionClass: 'visible-sm visible-xs'
        });

    } );
</script>
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
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">X</button>
                <h3 class="modal-title"><i class="fa fa-folder-open-o"></i> <?php print $lang['FILEMAN_ADD_FOLDER']; ?></h3>
            </div>
            <div class="modal-body">
                <form enctype="multipart/form-data" action="index.php?page=filemanager&move=1" method="POST">

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
                            // dirToOptions("../media/");
                            ?>
                    </select>

                    <label for="newFolder"><?php print $lang['FILEMAN_ADD_FOLDER_LABEL']; ?></label>
                    <input id="newFolder" name="newFolder" class="form-control" placeholder="<?php print $lang['FILEMAN_ADD_FOLDER_PLACEHOLDER']; ?>">
                </form>
            </div>
            <div class="modal-footer">
                <input type="hidden" name="move" value="sent">
                <input class="btn btn-large btn-success" type="submit" value="<?php echo $lang['FILEMAN_MOVE']; ?>">
            </div>
        </div> <!-- modal content -->
  </div> <!-- modal dialog -->
 </div>


<!-- Tabs -->
<ul id="myTab" class="nav nav-tabs">
    <li><a href="#audio" onclick="flipTheSwitch('audio');" data-toggle="tab"><i class="fa fa-music"></i> &nbsp;<?php echo $lang['FILEMAN_AUDIO']; ?></a></li>
    <li><a href="#backup" onclick="flipTheSwitch('backup');" data-toggle="tab"><i class="fa fa-file-zip-o"></i> &nbsp;<?php echo $lang['FILEMAN_BACKUP']; ?></a></li>
    <li><a href="#documents" onclick="flipTheSwitch('documents');" data-toggle="tab"><i class="fa fa-file-text-o"></i> &nbsp;<?php echo $lang['FILEMAN_DOCUMENTS']; ?></a></li>
    <li><a href="#downloads" onclick="flipTheSwitch('downloads');" data-toggle="tab"><i class="fa fa-download"></i> &nbsp;<?php echo $lang['FILEMAN_DOWNLOADS']; ?></a></li>
    <li class="active"><a href="#images" onclick="flipTheSwitch('images');" data-toggle="tab"><i class="fa fa-picture-o"></i> &nbsp;<?php echo $lang['FILEMAN_IMAGES']; ?></a></li>
    <li><a href="#uploads" onclick="flipTheSwitch('uploads');" data-toggle="tab"><i class="fa fa-upload"></i> &nbsp;<?php echo $lang['FILEMAN_UPLOADS']; ?></a></li>
    <li><a href="#video" onclick="flipTheSwitch('video');" data-toggle="tab"><i class="fa fa-video-camera"></i> &nbsp;<?php echo $lang['FILEMAN_VIDEOS']; ?></a></li>
</ul>

<!-- content start -->
<div id="myTabContent" class="tab-content">
    <div class="tab-pane fade in" id="audio">
        <a href="#" class="btn btn-success pull-right"><i class="fa fa-folder-open-o"></i> </a>
        <?php YAWK\filemanager::drawTableHeader($lang, 1); ?>
        <?php YAWK\filemanager::getFilesFromFolder("../media/audio"); ?>
        <?php YAWK\filemanager::drawTableFooter(); ?>
    </div>

    <div class="tab-pane fade in" id="backup">
        <br>
        <?php YAWK\filemanager::drawTableHeader($lang, 2); ?>
        <?php YAWK\filemanager::getFilesFromFolder("../media/backup"); ?>
        <?php YAWK\filemanager::drawTableFooter(); ?>
    </div>

    <div class="tab-pane fade in" id="documents">
        <br>
        <?php YAWK\filemanager::drawTableHeader($lang, 3); ?>
        <?php YAWK\filemanager::getFilesFromFolder("../media/documents"); ?>
        <?php YAWK\filemanager::drawTableFooter(); ?>
    </div>

    <div class="tab-pane fade in" id="downloads">
        <br>
        <?php YAWK\filemanager::drawTableHeader($lang, 4); ?>
        <?php YAWK\filemanager::getFilesFromFolder("../media/downloads"); ?>
        <?php YAWK\filemanager::drawTableFooter(); ?>
    </div>

    <div class="tab-pane fade in active" id="images">
        <br>
        <?php YAWK\filemanager::drawTableHeader($lang, 5); ?>
        <?php YAWK\filemanager::getFilesFromFolder("../media/images"); ?>
        <?php YAWK\filemanager::drawTableFooter(); ?>
    </div>

    <div class="tab-pane fade in" id="uploads">
        <br>
        <?php YAWK\filemanager::drawTableHeader($lang, 6); ?>
        <?php YAWK\filemanager::getFilesFromFolder("../media/uploads"); ?>
        <?php YAWK\filemanager::drawTableFooter(); ?>
    </div>

    <div class="tab-pane fade in" id="video">
        <br>
        <?php YAWK\filemanager::drawTableHeader($lang, 7); ?>
        <?php YAWK\filemanager::getFilesFromFolder("../media/video"); ?>
        <?php YAWK\filemanager::drawTableFooter(); ?>
    </div>
</div>

    </div>
</div>
        </div>
        <div class="col-md-4">
            <div class="box box-default">
                <div class="box-header">
                    <!-- add directory btn -->
                    <a class="btn btn-success" data-toggle="modal" data-target="#myModal2" href="#myModal" style="float:right;">
                    <i class="glyphicon glyphicon-plus"></i> &nbsp;<?php print $lang['FOLDER']; ?></a>
                </div>
                <div class="box-body">
                    <form action="index.php?page=filemanager" method="POST" class="dropzone" enctype="multipart/form-data">
                        <input type="hidden" name="MAX_FILE_SIZE" value="">
                        <input type="hidden" name="upload" value="sent">
                        <!-- <label for="uploadedfile"></label>
                         <input class="btn btn-default btn-file" id="uploadedfile" name="uploadedfile" type="file" multiple> -->
                        <?php

                        function dirToOptions($path)
                        {
                            if (isset($path) && (!empty($path) && (is_dir($path))))
                            {
                                // init new iterator object
                                $iter = new RecursiveIteratorIterator(
                                    new RecursiveDirectoryIterator($path, RecursiveDirectoryIterator::SKIP_DOTS),
                                    RecursiveIteratorIterator::SELF_FIRST,
                                    RecursiveIteratorIterator::CATCH_GET_CHILD // Ignore "Permission denied"
                                );

                                // if you wish to return an array, uncomment following line:
                                // $paths = array($root);
                                echo "<optgroup label=\"Subfolder\">";
                                foreach ($iter as $path => $dir) {

                                    if($dir->getFilename() === "audio") continue;
                                    if($dir->getFilename() === "backup") continue;
                                    if($dir->getFilename() === "documents") continue;
                                    if($dir->getFilename() === "downloads") continue;
                                    if($dir->getFilename() === "images") continue;
                                    if($dir->getFilename() === "uploads") continue;
                                    if($dir->getFilename() === "video") continue;
                                    if ($dir->isDir()) {
                                        // if you wish to return an array, uncomment following line:
                                        //  $paths[] = $path;

                                        // build label
                                       // $label = ltrim($dir, "../media/");
                                        // build folder
                                      //  $folder = ltrim($dir, "../media/");
                                        // if its running on windows:
                                    //    $label = ltrim($label, "\\");
                                    //    $folder = ltrim($folder, "\\");
                                        // $folder = strtr($dir,"../media/","");
                                        // $folder = ltrim($dir, "../media/");
                                        //$folder = strtr($folder,"\\","/");
                                       // $label = ucfirst($label);
                                        $subdir = $dir->getFilename();
                                        $subpath = ltrim($path, "..");
                                        $subpath = ltrim($subpath, "/");
                                        $subpath = ltrim($subpath, "media");
                                        $subpath = ltrim($subpath, "/");
                                        $subpath = strtr($subpath,"\\","/");
                                        $label = ucfirst($subpath);
                                        echo "<option value=\"$subpath\">&nbsp;&nbsp;$label</option>";
                                    }
                                }

                                // if you wish to return an array, uncomment following code block:
                                /*
                                if (isset($paths) && (is_array($paths)))
                                {
                                    return $paths;
                                }
                                else
                                    {
                                        return null;
                                    }
                                */
                            }
                            else
                            {
                                die ("no path was set or path is wrong - aborting.");
                            }
                        }

                        ?>
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
                            dirToOptions("../media/");
                            ?>
                        </select>
                    <?php /*
                        echo "<select id=\"folderselect2\" name=\"folderselect2\" class=\"form-control\">";
                        echo "<option selected>Subfolder...</option>";
                            dirToOptions("../media/");
                        echo "</select>";
 */
                    ?>
                    </form>
                </div>
            </div>
        </div>
</div>