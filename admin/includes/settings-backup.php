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

                // check if zip is enabled
                if (isset($_POST['zipBackup']) && (!empty($_POST['zipBackup'])))
                {   // zip backup to true (checkbox is checked)
                    $backup->zipBackup = $_POST['zipBackup'];
                }
                else
                    {   // zip backup disabled - checkbox not checked
                        $backup->zipBackup = false;
                    }

                // should files be removed after backup (save .zip file only)
                if (isset($_POST['removeAfterZip']) && (!empty($_POST['removeAfterZip'])))
                {   // set backup method property depending on select field
                    $backup->removeAfterZip = $_POST['removeAfterZip'];
                }
                else
                {   // remove files after zip disabled
                    $backup->removeAfterZip = false;
                }

                // check if overwrite backup is allowed
                if (isset($_POST['overwriteBackup']) && (!empty($_POST['overwriteBackup'])))
                {   // set backup method property depending on select field
                    $backup->overwriteBackup = $_POST['overwriteBackup'];
                }
                else
                {   // do not allow to overwrite backup
                    $backup->overwriteBackup = false;
                }

                // initialize backup
                if ($backup->init($db) === true)
                {
                    \YAWK\alert::draw("success", $lang['BACKUP_SUCCESSFUL'], $lang['BACKUP_SUCCESSFUL_TEXT'], "", 3400);
                }
                else
                    {
                        \YAWK\alert::draw("danger", $lang['BACKUP_FAILED'], $lang['BACKUP_FAILED_TEXT'], "", 6400);
                    }
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
    $(document).ready(function()
    {
        // check overwrite backup switch
        $('#overwriteBackup').on('change', function()
        {   // set switch + label vars
            var overwriteBackupSwitch = $('#overwriteBackup');
            var overwriteBackupLabel = $('#overwriteBackupLabel');
            var overwriteLabelTextOn = $(overwriteBackupSwitch).attr("data-overwriteOn");
            var overwriteLabelTextOff = $(overwriteBackupSwitch).attr("data-overwriteOff");

            // check if overwrite switch is on
            if ($(overwriteBackupSwitch).is(':checked'))
            {   // set ON label text (overwrite current backup)
                $(overwriteBackupLabel).text(overwriteLabelTextOn);
            }
            else
                {   // set OFF label text (save to archive)
                    $(overwriteBackupLabel).text(overwriteLabelTextOff);
                }
        });

        // if zip is not allowed, remove after zip should be disabled
        $('#zipBackup').change(function() {
            // var remove after zip switch
            var removeAfterZipSwitch = $('#removeAfterZip');

            // check if zip is enabled or disabled
            if ($('#zipBackup').is(':checked'))
            {   // disable remove after zip switch
                $(removeAfterZipSwitch).bootstrapToggle('on');
                $(removeAfterZipSwitch).prop('disabled', false);
            }
            else
                {   // toggle + enable switch again
                    $(removeAfterZipSwitch).bootstrapToggle('off');
                    $(removeAfterZipSwitch).prop('disabled', true);
                }
        });

        // check if pulldown (select field) has changed (any item has been selected)
        // and display additional according backup settings
        $("#backupMethod").on('change', function() {
            // store backup method value as var
            var backupMethod = this.value;

            // user selected complete backup method
            if (backupMethod === "complete")
            {   // hide all other methods
                $("#customSettings").hide();
                $("#databaseMethods").hide();
                $("#fileMethods").hide();
                // display 'complete backup' settings
                $("#completeMethods").fadeIn().removeClass('hidden');
            }

            // user selected database backup method
            if (backupMethod === "database")
            {   // hide all other methods
                $("#customSettings").hide();
                $("#completeMethods").hide();
                $("#fileMethods").hide();
                // display 'database backup' settings
                $("#databaseMethods").fadeIn().removeClass('hidden');
            }

            // user selected file backup method
            if (backupMethod === "files")
            {
                // hide all other methods
                $("#customSettings").hide();
                $("#databaseMethods").hide();
                $("#completeMethods").hide();
                // display 'file backup' settings
                $("#fileMethods").fadeIn().removeClass('hidden');
            }

            // user selected file backup method
            if (backupMethod === "custom")
            {
                // hide all other methods
                $("#databaseMethods").hide();
                $("#completeMethods").hide();
                // display 'file backup' settings
                $("#customSettings").fadeIn().removeClass('hidden');
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
    <form name="backup" action="index.php?page=settings-backup&action=startBackup" method="POST">
    <div class="box">
        <div class="box-header">
            <h3 class="box-title">
                <?php echo $lang['BACKUP_CREATE']; ?>
            </h3>
        </div>
        <div class="box-body">
                <input type="hidden" name="action" value="startBackup">
                <button type="submit" class="btn btn-success pull-right" id="savebutton"><i class="fa fa-check" id="savebuttonIcon"></i> &nbsp;<?php echo $lang['BACKUP_CREATE']; ?></button>
                <br><br>
                <label for="backupMethod"><?php echo $lang['BACKUP_WHAT_TO_BACKUP']; ?></label>
                <select name="backupMethod" id="backupMethod" class="form-control">
                  <optgroup label="Standard"></optgroup>
                    <option name="complete" value="complete">&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $lang['BACKUP_FULL']; ?></option>
                    <option name="database" value="database">&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $lang['BACKUP_DB_ONLY']; ?></option>
                    <option name="files" value="files">&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $lang['BACKUP_FILES_ONLY']; ?></option>
                  <optgroup label="Benutzerdefniert"></optgroup>
                    <option name="custom" value="custom">&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $lang['BACKUP_CUSTOM']; ?></option>

                </select>

                <br>
                <input type="checkbox" data-on="<?php echo $lang['BACKUP_OVERWRITE_THIS']; ?>" data-off="<?php echo $lang['BACKUP_ARCHIVE_THIS']; ?>" data-overwriteOff="<?php echo $lang['BACKUP_OVERWRITE_OFF']; ?>" data-overwriteOn="<?php echo $lang['BACKUP_OVERWRITE_ON']; ?>" data-toggle="toggle" data-onstyle="success" data-offstyle="info" class="checkbox" name="overwriteBackup" id="overwriteBackup" value="true" checked>
                &nbsp;&nbsp;<label for="overwriteBackup" id="overwriteBackupLabel"><?php echo $lang['BACKUP_OVERWRITE']; ?>&nbsp;&nbsp;</label>
                <br><br>
                <input type="checkbox" data-on="<?php echo $lang['YES']; ?>" data-off="<?php echo $lang['NO']; ?>" data-toggle="toggle" data-onstyle="success" data-offstyle="danger" class="checkbox" name="zipBackup" id="zipBackup" value="true" checked>
                &nbsp;&nbsp;<label for="zipBackup"><?php echo $lang['BACKUP_ZIP_ALLOWED']; ?>&nbsp;&nbsp;</label>
                &nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" data-on="<?php echo $lang['YES']; ?>" data-off="<?php echo $lang['NO']; ?>" data-toggle="toggle" data-onstyle="success" data-offstyle="danger" class="checkbox" name="removeAfterZip" id="removeAfterZip" value="true" checked>
                &nbsp;&nbsp;<label for="removeAfterZip"><?php echo $lang['BACKUP_REMOVE_AFTER_ZIP']; ?>&nbsp;&nbsp;</label>
                <br><br>

                <!--
                <div id="completeMethods">
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
                -->
        </div>
    </div>
        <div class="box hidden" id="customSettings">
            <div class="box-header">
                <h3 class="box-title">
                    <?php echo $lang['EXTENDED_SETTINGS']; ?>
                </h3>
            </div>
            <div class="box-body">
                <div>
                    <h3><?php echo $lang['BACKUP_DATABASE_SETTINGS']; ?></h3>
                    <label id="example1Label" for="example1Checkbox">Some additional Database Setting</label>
                    <input type="checkbox" id="example1Checkbox" name="example1Checkbox"><br>
                    <label id="example2Label" for="example2Checkbox">Some additional Database Setting</label>
                    <input type="checkbox" id="example2Checkbox" name="example2Checkbox"><br>
                    <label id="example3Label" for="example3Checkbox">Some additional Database Setting</label>
                    <input type="checkbox" id="example3Checkbox" name="example3Checkbox"><br>

                    <h3><?php echo $lang['BACKUP_FILES_SETTINGS']; ?></h3>
                    <label id="example4Label" for="example4Checkbox">Some additional Database Setting</label>
                    <input type="checkbox" id="example4Checkbox" name="example4Checkbox">
                </div>
            </div>
        </div>
    </form>
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
            <h1 class="box-title"><?php echo $lang['BACKUP_ONGOING']; ?> <small><?php echo $lang['MANAGE']; ?></small></h1>
        </div>
        <div class="box-body">
            <b>system/backup/current/</b>
            <h3>&nbsp;&nbsp;&nbsp;<i class="fa fa-file-zip-o text-green"></i>&nbsp;&nbsp; <small><?php // .... ?></small></h3>
        </div>
    </div>

    <div class="box">
        <div class="box-header">
            <h1 class="box-title"><?php echo $lang['BACKUP_ARCHIVE']; ?> <small><?php echo $lang['MANAGE']; ?></small></h1>
        </div>
        <div class="box-body">
            <b>system/backup/archive/</b>
            <br><br>
        </div>
    </div>
</div>
</div>