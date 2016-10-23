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
            $target_path = $upload_folder . basename( $_FILES['uploadedfile']['name']);
            // move file
            if(move_uploaded_file($_FILES['uploadedfile']['tmp_name'], $target_path))
            {   // store uploaded file
                $file = basename( $_FILES['uploadedfile']['name']);
                print \YAWK\alert::draw("success", "Erfolg!", "Datei <strong>".$file."</strong> erfolgreich hochgeladen!", "", 800);
            }
            else
            {   // could not upload file, throw error
                echo YAWK\alert::draw("danger", "Error!", "There was an error uploading your file, please try again.", "", 5800);
            }
            break;
    }
}
// DELETE ITEM 
if (isset($_GET['delete']))
{   // user clicked on delete
    if ($_GET['delete']==1 AND (isset($_GET['item'])))
    {
        $path=$_GET['path'];
        $item=$_GET['item'];
        $file="$path"."/"."$item";
        YAWK\filemanager::deleteItem($file, $_GET['folder']);
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
        } );
    } );
</script>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper" id="content-FX">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <!-- draw title on top-->
        <?php echo \YAWK\backend::getTitle($lang['FILEMAN_TITLE'], $lang['FILEMAN_SUBTEXT']); ?>
        <ol class="breadcrumb">
            <li><a href="index.php?page=menus" title="Menus"><i class="fa fa-dashboard"></i> Menus</a></li>
            <li class="active"><a href="index.php?page=menus" title="Overview"> Overview</a></li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <!-- START CONTENT HERE -->
<div class="box box-default">
    <div class="box-body">

<!-- upload btn -->
<a class="btn btn-success" data-toggle="modal" data-target="#myModal" href="#myModal" style="float:right;">
<i class="glyphicon glyphicon-plus"></i> &nbsp;<?php print $lang['FILEMAN_UPLOAD']; ?></a>

<!-- FILE UPLOAD MODAL DIALOG -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel"><?php print $lang['FILEMAN_UPLOAD']; ?> (max <?php print \YAWK\filemanager::getPhpMaxFileSize(); ?>)</h4>
            </div>
            <div class="modal-body">
                <form enctype="multipart/form-data" class="form-inline" action="index.php?page=filemanager" method="POST">

                            <input type="hidden" name="MAX_FILE_SIZE" value="<?php print $max_file_size; ?>" />
                            <input type="hidden" name="upload" value="sent" />
                            <label for="uploadedfile"></label>
                            <input class="btn btn-default btn-file" id="uploadedfile" name="uploadedfile" type="file" /><br>

                    <label for="folderselect">to folder: </label>
                    <select id="folderselect" name="folderselect" class="form-control">
                        <option value="audio">Audio</option>
                        <option value="backup">Backup</option>
                        <option value="documents">Documents</option>
                        <option value="downloads">Downloads</option>
                        <option value="images" selected>Images</option>
                        <option value="uploads">Uploads</option>
                        <option value="video">Videos</option>
                    </select>
                    <br>
                    <div class="modal-footer">
                        <input class="btn btn-large btn-success" style="float:right;" type="submit" value="Datei&nbsp;hochladen" />
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal --MOVE DIALOG -- -->
<div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModal2Label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">X</button>
                <h3 class="modal-title" id="move2Label"><?php print $lang['FILEMAN_MOVE']; ?></h3>
            </div>
            <div class="modal-body">
                <form enctype="multipart/form-data" action="index.php?page=filemanager&move=1" method="POST">
                    <h3>Folder ausw&auml;hlen: <small>wohin soll die Datei <?php print $_GET['item']; echo $_GET['$file_value'];  ?> verschoben werden?</small></h3>
                    <select id="folderselect" class="form-control" name="folderselect">
                        <option value="audio"> Audio </option>
                        <option value="documents"> Backup </option>
                        <option value="documents"> Documents </option>
                        <option value="downloads"> Downloads </option>
                        <option value="images" selected> Images </option>
                        <option value="uploads"> Uploads </option>
                        <option value="video"> Video </option>
                    </select>
                </form>
            </div>
            <div class="modal-footer">
                <input type="hidden" name="move" value="sent" />
                <input class="btn btn-large btn-success" type="submit" value="Datei&nbsp;verschieben"/>
            </div>
        </div> <!-- modal content -->
  </div> <!-- modal dialog -->
 </div>

<!-- Tabs -->
<ul id="myTab" class="nav nav-tabs">
    <li><a href="#audio" data-toggle="tab"><i class="fa fa-music"></i> &nbsp;Audio</a></li>
    <li><a href="#backup" data-toggle="tab"><i class="fa fa-file-zip-o"></i> &nbsp;Backup</a></li>
    <li><a href="#documents" data-toggle="tab"><i class="fa fa-file-text-o"></i> &nbsp;Documents</a></li>
    <li><a href="#downloads" data-toggle="tab"><i class="fa fa-download"></i> &nbsp;Downloads</a></li>
    <li class="active"><a href="#images" data-toggle="tab"><i class="fa fa-picture-o"></i> &nbsp;Images</a></li>
    <li><a href="#uploads" data-toggle="tab"><i class="fa fa-upload"></i> &nbsp;Uploads</a></li>
    <li><a href="#video" data-toggle="tab"><i class="fa fa-video-camera"></i> &nbsp;Video</a></li>
</ul>

<!-- content start -->
<div id="myTabContent" class="tab-content">
    <div class="tab-pane fade in" id="audio">
        <br>
        <?php YAWK\filemanager::drawTableHeader($lang, 1); ?>
        <?php YAWK\filemanager::getFilesFromFolder("audio");  ?>
        <?php YAWK\filemanager::drawTableFooter(); ?>
    </div>

    <div class="tab-pane fade in" id="backup">
        <br>
        <?php YAWK\filemanager::drawTableHeader($lang, 2); ?>
        <?php YAWK\filemanager::getFilesFromFolder("backup");  ?>
        <?php YAWK\filemanager::drawTableFooter(); ?>
    </div>

    <div class="tab-pane fade in" id="documents">
        <br>
        <?php YAWK\filemanager::drawTableHeader($lang, 3); ?>
        <?php YAWK\filemanager::getFilesFromFolder("documents");	?>
        <?php YAWK\filemanager::drawTableFooter(); ?>
    </div>

    <div class="tab-pane fade in" id="downloads">
        <br>
        <?php YAWK\filemanager::drawTableHeader($lang, 4); ?>
        <?php YAWK\filemanager::getFilesFromFolder("downloads");  ?>
        <?php YAWK\filemanager::drawTableFooter(); ?>
    </div>

    <div class="tab-pane fade in active" id="images">
        <br>
        <?php YAWK\filemanager::drawTableHeader($lang, 5); ?>
        <?php YAWK\filemanager::getFilesFromFolder("images");  ?>
        <?php YAWK\filemanager::drawTableFooter(); ?>
    </div>

    <div class="tab-pane fade in" id="uploads">
        <br>
        <?php YAWK\filemanager::drawTableHeader($lang, 6); ?>
        <?php YAWK\filemanager::getFilesFromFolder("uploads");  ?>
        <?php YAWK\filemanager::drawTableFooter(); ?>
    </div>

    <div class="tab-pane fade in" id="video">
        <br>
        <?php YAWK\filemanager::drawTableHeader($lang, 7); ?>
        <?php YAWK\filemanager::getFilesFromFolder("video");  ?>
        <?php YAWK\filemanager::drawTableFooter(); ?>
    </div>
</div>

    </div>
</div>