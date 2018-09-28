<?php

/*
// check status and do what you need to do
if(isset($_GET['check']) && ($_GET['check']==1)) {
	backup::getPackages();
	}

if (isset($_GET['start']) && ($_GET['start']==1)) {
	backup::start();
	}

if (isset($_GET['delete_all']) && ($_GET['delete_all']==1)) {
	backup::deleteTarGzPackages();
	backup::deleteMediaPackages();
	backup::deleteSqlPackages();
	}
if (isset($_GET['download_all']) && ($_GET['download_all']==1)) {
	backup::downloadAllPackages();
	}

if (isset($_GET['delete_item'])) {
	$package = $_GET['delete_item'];
	backup::deletePackage($package);
	}
*/
?>
<!-- Bootstrap toggle css -->
<link rel="stylesheet" href="../system/engines/bootstrap-toggle/css/bootstrap-toggle.css">
<!-- Bootstrap toggle js -->
<script type="text/javascript" src="../system/engines/bootstrap-toggle/js/bootstrap-toggle.min.js"></script>
<!-- DROPZONE JS -->
<script src="../system/engines/jquery/dropzone/dropzone.js"></script>
<!-- DROPZONE CSS -->
<link href="../system/engines/jquery/dropzone/dropzone.css" rel="stylesheet">
<?php
// TEMPLATE WRAPPER - HEADER & breadcrumbs
echo "
    <!-- Content Wrapper. Contains page content -->
    <div class=\"content-wrapper\" id=\"content-FX\">
    <!-- Content Header (Page header) -->
    <section class=\"content-header\">";
/* draw Title on top */
echo \YAWK\backend::getTitle($lang['BACKUP'], $lang['BACKUP_SUBTEXT']);
echo"<ol class=\"breadcrumb\">
            <li><a href=\"index.php\" title=\"$lang[DASHBOARD]\"><i class=\"fa fa-dashboard\"></i> $lang[DASHBOARD]</a></li>
            <li class=\"active\"><a href=\"index.php?page=backup\" title=\"$lang[BACKUP]\"> $lang[BACKUP]</a></li>
         </ol>
    </section>
    <!-- Main content -->
    <section class=\"content\">";
/* page content start here */

/** @var $db \YAWK\db */
require_once '../system/classes/backup.php';        // backup methods and helpers
// check if backup obj is set
if (!isset($backup) || (empty($backup)))
{   // create new backup obj
    $backup = new \YAWK\BACKUP\backup();
}
?>
<div class="col-md-6">
    <div class="box">
        <div class="box-header">
            <h3 class="box-title">
                <?php echo $lang['BACKUP_CREATE']; ?>
            </h3>
        </div>
        <div class="box-body">
            <form name="backup" action="index.php?page=settings-backup" method="POST">
                <button type="submit" class="btn btn-success pull-right" id="savebutton"><i class="fa fa-check" id="savebuttonIcon"></i> &nbsp;<?php echo $lang['BACKUP_CREATE']; ?></button>
                <br><br>
                <label for="backupMethod"><?php echo $lang['BACKUP_WHAT_TO_BACKUP']; ?></label>
                <select name="backupMethod" id="backupMethod" class="form-control">
                    <option name="complete" value="complete"><?php echo $lang['BACKUP_FULL']; ?></option>
                    <option name="database" value="database"><?php echo $lang['BACKUP_DB_ONLY']; ?></option>
                    <option name="files" value="files"><?php echo $lang['BACKUP_FILES_ONLY']; ?></option>
                </select>

                <br>
                <input type="checkbox" data-on="<?php echo $lang['YES']; ?>" data-off="<?php echo $lang['NO']; ?>" data-toggle="toggle" data-onstyle="success" data-offstyle="danger" class="checkbox" name="overwriteBackup" id="overwriteBackup" checked>
                &nbsp;&nbsp;<label for="overwriteBackup"><?php echo $lang['BACKUP_OVERWRITE']; ?>&nbsp;&nbsp;</label>
                <br><br>
                <input type="checkbox" data-on="<?php echo $lang['YES']; ?>" data-off="<?php echo $lang['NO']; ?>" data-toggle="toggle" data-onstyle="success" data-offstyle="danger" class="checkbox" name="zipBackup" id="zipBackup" checked>
                &nbsp;&nbsp;<label for="zipBackup"><?php echo $lang['BACKUP_ZIP_ALLOWED']; ?>&nbsp;&nbsp;</label>
                <br><br>
            </form>
            <?php
            $backup->init();
            // \YAWK\backup::getPackages();	?>
        </div>
    </div>
</div>
<div class="col-md-6">
    <div class="box">
        <div class="box-header">
            <h3 class="box-title">
                <?php echo $lang['BACKUP_RESTORE']." <small>".$lang['TO_UPLOAD']."</small>"; ?>
            </h3>
        </div>
        <div class="box-body">
            <form enctype="multipart/form-data" class="dropzone text-center" action="index.php?page=settings-backup&action=upload" method="POST">
                <input type="hidden" name="MAX_FILE_SIZE" value="">
                <input type="hidden" name="upload" value="sent">
                <br>
                <button class="btn btn-success" type="submit"><i class="fa fa-upload"></i>&nbsp;&nbsp;&nbsp;<?php echo $lang['UPLOAD']; ?></button>
            </form>
            <br><br>
        </div>
    </div>
</div>


 <div class="col-md-6">
     <div class="box">
         <div class="box-header">
             <h1 class="box-title"><?php echo $lang['BACKUP_LATEST']; ?> <small><?php echo $lang['TO_DOWNLOAD']; ?></small></h1>
         </div>
         <div class="box-body">
             <b>system/backup/current/</b>
             <h3>&nbsp;&nbsp;&nbsp;<i class="fa fa-file-zip-o text-success"></i>&nbsp;&nbsp; <small><?php // .... ?></small></h3>
         </div>
     </div>

     <div class="box">
         <div class="box-header">
             <h1 class="box-title"><?php echo $lang['BACKUP_ARCHIVE']; ?> <small><?php echo $lang['TO_DOWNLOAD']; ?></small></h1>
         </div>
         <div class="box-body">
             <b>system/backup/archive/</b>
             <br><br>
         </div>
     </div>
 </div>

