<?php
// check if post data is set
if (isset($_POST))
{   // check if action is set
    if (isset($_POST['action']))
    {   // check which action is requested
        switch ($_POST['action'])
        {
            // start backup selected
            case "startBackup":
            {
                /** @var $db \YAWK\db */
                require_once '../system/classes/backup.php';        // backup methods and helpers
                // check if backup obj is set
                if (!isset($backup) || (empty($backup)))
                {   // create new backup obj
                    $backup = new \YAWK\BACKUP\backup();
                }
                // check if backup method is set
                if (isset($_POST['backupMethod']) && (!empty($_POST['backupMethod'])))
                {   // set backup method property depending on select field
                    $backup->backupMethod = $_POST['backupMethod'];
                }
                // initialize backup
                $backup->init();
            }
            break;

            // upload a backup archive
            case "upload":
            {
                // restore a backup from file
            }
            break;
        }
    }
}
?>
<script type="text/javascript">
    $(document).ready(function() {
        $("#backupMethod").on('change', function() {
            var backupMethod = this.value;

            if (backupMethod === "complete")
            {
                $("#databaseMethods").hide();
                $("#fileMethods").hide();
                $("#completeMethods").fadeIn().removeClass('hidden');
                // alert('BACKUP COMPLETE SELECTED: '+backupMethod);
            }

            if (backupMethod === "database")
            {
                $("#completeMethods").hide();
                $("#fileMethods").hide();
                $("#databaseMethods").fadeIn().removeClass('hidden');
                // alert('BACKUP DATABASE SELECTED: '+backupMethod);
            }

            if (backupMethod === "files")
            {
                $("#databaseMethods").hide();
                $("#completeMethods").hide();
                $("#fileMethods").fadeIn().removeClass('hidden');
                // alert('BACKUP FILES SELECTED: '+backupMethod);
            }
        });
    });
</script>
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


?>
<div class="row">
<div class="col-md-6">
    <div class="box">
        <div class="box-header">
            <h3 class="box-title">
                <?php echo $lang['BACKUP_CREATE']; ?>
            </h3>
        </div>
        <div class="box-body">
            <form name="backup" action="index.php?page=settings-backup&action=startBackup" method="POST">
                <input type="hidden" name="action" value="startBackup">
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
                &nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" data-on="<?php echo $lang['YES']; ?>" data-off="<?php echo $lang['NO']; ?>" data-toggle="toggle" data-onstyle="success" data-offstyle="danger" class="checkbox" name="removeAfterZip" id="removeAfterZip" checked>
                &nbsp;&nbsp;<label for="removeAfterZip"><?php echo $lang['BACKUP_REMOVE_AFTER_ZIP']; ?>&nbsp;&nbsp;</label>
                <br><br>

                <div id="completeMethods" class="hidden">
                    <h3>Complete Backup</h3>
                    <label id="someSetting2Label" for="someSetting2">Some additional setting 2...</label>
                    <input type="checkbox" id="someSetting2" name="someSetting2">
                </div>

                <div id="databaseMethods" class="hidden">
                    <h3>Database Settings </h3>
                    <label id="someSettingLabel" for="someSetting">Some additional setting...</label>
                    <input type="checkbox" id="someSetting" name="someSetting">
                </div>

                <div id="fileMethods" class="hidden">
                    <h3>Files Backup</h3>
                    <label id="someSetting3Label" for="someSetting3">Some additional setting 3...</label>
                    <input type="checkbox" id="someSetting3" name="someSetting3">
                </div>
            </form>
            <?php
            // $backup->init();
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
                <input type="hidden" name="action" value="upload">
                <br>
                <button class="btn btn-success" type="submit"><i class="fa fa-upload"></i>&nbsp;&nbsp;&nbsp;<?php echo $lang['UPLOAD']; ?></button>
            </form>
            <span class="pull-right">asdasd</span>
            <br><br>
        </div>
    </div>

    <div class="box">
        <div class="box-header">
            <h1 class="box-title"><?php echo $lang['BACKUP_LATEST']; ?> <small><?php echo $lang['TO_DOWNLOAD']; ?></small></h1>
        </div>
        <div class="box-body">
            <b>system/backup/current/</b>
            <h3>&nbsp;&nbsp;&nbsp;<i class="fa fa-file-zip-o text-green"></i>&nbsp;&nbsp; <small><?php // .... ?></small></h3>
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
</div>