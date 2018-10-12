<?php
namespace YAWK\BACKUP\FILES
{
    /**
     * <b>YaWK Backup Component: File Backup Class</b>
     *
     * <p>Methods to backup and restore any folder </p>
     *
     * @package    YAWK
     * @author     Daniel Retzl <danielretzl@gmail.com>
     * @copyright  2018 Daniel Retzl
     * @license    https://opensource.org/licenses/MIT
     * @version    1.0.0
     * @link       http://yawk.io
     * @annotation This class serves methods to store files.
     */
    class fileBackup extends \YAWK\BACKUP\backup
    {
        /** @var object zip object */
        public $zip;
        /** @var string source folder to backup */
        public $sourceFolder = '';
        /** @var string path, where the backup will be stored */
        public $targetFolder = '../system/backup/current/';
        /** @var string default filename of .zip file */
        public $backupZipFile = 'backup-custom.zip';
        /** @var string hash value of .zip file */
        public $hashValue = '';
        /** @var string content folder */
        public $contentFolder = '../content/';
        /** @var string media folder */
        public $mediaFolder = '../media/';
        /** @var string system folder */
        public $systemFolder = '../system/';
        /** @var string current processing folder */
        public $currentFolder = '';


        /**
         * Initialize and start file backup
         * @author      Daniel Retzl <danielretzl@gmail.com>
         * @version     1.0.0
         * @link        http://yawk.io
         * @param       object $db database object
         * @param       string $overwriteBackup if overwrite backup is allowed or not "true" | "false"
         * @param       string $zipBackup if backup should be zipped or not "true" | "false"
         * @return      bool
         */
        public function initFolderBackup($db, $overwriteBackup, $zipBackup)
        {
            // start filebackup
            $this->overwriteBackup = $overwriteBackup;
            $this->zipBackup = $zipBackup;

            if ($this->startFileBackup($db) === true)
            {   // file backup done
                return true;
            }
            else
            {   // file backup failed
                return false;
            }
        }


        /**
         * Check if .zip backup file exists
         * @author      Daniel Retzl <danielretzl@gmail.com>
         * @version     1.0.0
         * @link        http://yawk.io
         * @annotation  return bool if $this->backupZipFile exists
         * @return      bool true|false
         */
        public function zipFileExists()
        {
            // set path + filename (store as string in $this->backupZipFile)
            $this->backupZipFile = $this->targetFolder.$this->backupZipFile;// .sql backup file exists
            // check if .zip file is already there
            if (is_file($this->backupZipFile))
            {
                // .zip file exists
                return true;
            }
            else
            {
                // .zip file does not exist
                return false;
            }
        }

        /**
         * Write backup.ini file (used by backup restore methods)
         * @author      Daniel Retzl <danielretzl@gmail.com>
         * @version     1.0.0
         * @link        http://yawk.io
         * @annotation  write all relevant backup information into this file
         * @return      array $this->backupSettings
         */
        public function setBackupSettings($db)
        {
            /** @var $db \YAWK\db */
            // set some backup info variables
            $this->backupSettings['DATE'] = \YAWK\sys::now();
            $this->backupSettings['METHOD'] = $this->backupMethod;
            $this->backupSettings['FILE'] = $this->backupZipFile;
            $this->backupSettings['HASH'] = $this->getHashValue($db);
            $this->backupSettings['PATH'] = $this->targetFolder;
            $this->backupSettings['SOURCE_FOLDER'] = $this->backupZipFile;
            $this->backupSettings['OVERWRITE_ALLOWED'] = $this->overwriteBackup;
            $this->backupSettings['USER_ID'] = $_SESSION['uid'];
            return $this->backupSettings;
        }

        public function getHashValue($db)
        {
            // check if sql backup file is accessable
            if (is_file($this->backupZipFile))
            {   // generate hash value
                return $this->hashValue = hash_file('md5', $this->backupZipFile);
            }
            else
            {   // sql backup file not found
                // unable to generate hash value
                \YAWK\sys::setSyslog($db, 52, 2, "failed to generate hash value - $this->backupZipFile not accessable", 0, 0, 0, 0);
                return false;
            }
        }

        /**
         * Start mysqldump and check if .sql file exists. Zip it afterwards if enabled.
         * @author      Daniel Retzl <danielretzl@gmail.com>
         * @version     1.0.0
         * @link        http://yawk.io
         * @annotation  return bool if $this->backupZipFile exists
         * @return      bool true|false
         */
        public function doFolderBackup($db)
        {
            // check if temp folder is writeable
            if (!is_writeable($this->tmpFolder) && (!empty($this->tmpFolder)))
            {   // tmp folder not writeable...
                return false;
            }

            // CONTENT FOLDER PROCESSING
            if (isset($_POST['contentFolder']) && (!empty($_POST['contentFolder'])))
            {   // create content folder
                if (!is_dir($this->tmpFolder.'content'))
                {
                    if (!mkdir($this->tmpFolder . 'content'))
                    {
                        // return false
                        \YAWK\sys::setSyslog($db, 51, 2, "failed to create " . $this->tmpFolder . "content", 0, 0, 0, 0);
                    }
                }

                // walk through content folder subdirectories
                foreach ($_POST['contentFolder'] as $folder)
                {
                    // set current content folder property
                    $this->currentFolder = $this->contentFolder;
                    $this->targetFolder = $this->tmpFolder.'content/';
                    // check if parent dir exists
                    if (is_dir($this->currentFolder.$folder))
                    {
                        // check if subdir NOT exists
                        if (!is_dir($this->targetFolder.$folder))
                        {
                            // create subdir
                            mkdir($this->targetFolder.$folder);
                            $this->targetFolder = $this->tmpFolder.'content/'.$folder;
                        }
                        else
                            {   // subdir exists, set target path
                                $this->targetFolder = $this->tmpFolder.'content/'.$folder;
                            }
                    }
                    // copy content subfolder
                    if ($this->copyFolder($db, $folder, $this->targetFolder) !== true)
                    {
                        \YAWK\sys::setSyslog($db, 51, 2, "failed to create ".$this->contentFolder."$folder", 0, 0, 0, 0);
                    }
                }
            }


            // MEDIA FOLDER PROCESSING
            if (isset($_POST['mediaFolder']) && (!empty($_POST['mediaFolder'])))
            {   // create content folder
                if (!is_dir($this->tmpFolder.'media'))
                {
                    if (!mkdir($this->tmpFolder . 'media'))
                    {
                        // return false
                        \YAWK\sys::setSyslog($db, 51, 2, "failed to create " . $this->tmpFolder . "media", 0, 0, 0, 0);
                    }
                }

                // walk through content folder subdirectories
                foreach ($_POST['mediaFolder'] as $folder)
                {
                    // set current content folder property
                    $this->currentFolder = $this->mediaFolder;
                    $this->targetFolder = $this->tmpFolder.'media/';
                    // check if parent dir exists
                    if (is_dir($this->currentFolder.$folder))
                    {
                        // check if subdir NOT exists
                        if (!is_dir($this->targetFolder.$folder))
                        {
                            // create subdir
                            mkdir($this->targetFolder.$folder);
                            $this->targetFolder = $this->tmpFolder.'media/'.$folder;
                        }
                        else
                        {   // subdir exists, set target path
                            $this->targetFolder = $this->tmpFolder.'media/'.$folder;
                        }
                    }
                    // copy media subfolder
                    if ($this->copyFolder($db, $folder, $this->targetFolder) !== true)
                    {
                        \YAWK\sys::setSyslog($db, 51, 2, "failed to create ".$this->mediaFolder."$folder", 0, 0, 0, 0);
                    }
                }
            }

            // SYSTEM FOLDER PROCESSING
            if (isset($_POST['systemFolder']) && (!empty($_POST['systemFolder'])))
            {   // create content folder
                if (!is_dir($this->tmpFolder.'system'))
                {
                    if (!mkdir($this->tmpFolder . 'system'))
                    {
                        // return false
                        \YAWK\sys::setSyslog($db, 51, 2, "failed to create " . $this->tmpFolder . "system", 0, 0, 0, 0);
                    }
                }

                // walk through system folder subdirectories
                foreach ($_POST['systemFolder'] as $folder)
                {
                    // set current content folder property
                    $this->currentFolder = $this->systemFolder;
                    $this->targetFolder = $this->tmpFolder.'system/';
                    // check if parent dir exists
                    if (is_dir($this->currentFolder.$folder))
                    {
                        // check if subdir NOT exists
                        if (!is_dir($this->targetFolder.$folder))
                        {
                            // create subdir
                            mkdir($this->targetFolder.$folder);
                            $this->targetFolder = $this->tmpFolder.'system/'.$folder;
                        }
                        else
                        {   // subdir exists, set target path
                            $this->targetFolder = $this->tmpFolder.'system/'.$folder;
                        }
                    }
                    // copy system subfolder
                    if ($this->copyFolder($db, $folder, $this->targetFolder) !== true)
                    {
                        \YAWK\sys::setSyslog($db, 51, 2, "failed to create ".$this->systemFolder."$folder", 0, 0, 0, 0);
                    }
                }
            }

            $source = $this->tmpFolder;
            $customBackupFile = $this->tmpFolder."custom-backup.zip";
            if ($this->zipFolder($db, $source, $customBackupFile) == true)
            {
        // TEST AREA
                // check if backup overwrite is allowed
                if ($this->overwriteBackup == "false")
                {
                    if (isset($_POST))
                    {
                        // check if new folder was entered by user
                        if (isset($_POST['newFolder']) && (!empty($_POST['newFolder'])))
                        {
                            // create new archive sub folder path
                            $this->archiveBackupSubFolder = $this->archiveBackupFolder.$_POST['newFolder']."/";

                            // create new directory in archive
                            if (!is_dir($this->archiveBackupSubFolder))
                            {
                                if (mkdir($this->archiveBackupSubFolder))
                                {   // all good, new archive subfolder created
                                    // set syslog entry: dir created
                                    \YAWK\sys::setSyslog($db, 50, 0, "archive directory created: $this->archiveBackupSubFolder", 0, 0, 0, 0);
                                }
                                else
                                {   // failed to create new archive subfolder
                                    // set syslog entry: failed
                                    \YAWK\sys::setSyslog($db, 52, 0, "failed to create archive directory: $this->archiveBackupSubFolder", 0, 0, 0, 0);
                                }
                            }
                        }
                        // check if existing folder was selected by user
                        else if (isset($_POST['selectFolder']) && (!empty($_POST['selectFolder'])))
                        {   // set archive sub foder path
                            $this->archiveBackupSubFolder = $this->archiveBackupFolder.$_POST['selectFolder']."/";
                        }

                        // SET PATH WHERE .SQL FILE SHOULD BE STORED
                        if (rename($customBackupFile, $this->archiveBackupSubFolder))
                        {
                            if (is_file($this->archiveBackupSubFolder."custom-backup.zip"))
                            {
                                \YAWK\sys::setSyslog($db, 49, 0, "created ".$this->archiveBackupSubFolder."custom-backup.zip", 0, 0, 0, 0);
                                return true;
                            }
                            else
                                {
                                    \YAWK\sys::setSyslog($db, 52, 0, "failed to create ".$this->archiveBackupSubFolder."custom-backup.zip", 0, 0, 0, 0);
                                    return false;
                                }
                        }
                        else
                            {
                                \YAWK\sys::setSyslog($db, 52, 0, "failed to move ".$this->archiveBackupSubFolder."custom-backup.zip", 0, 0, 0, 0);
                                return false;
                            }
                    }
                    else
                        {
                            \YAWK\sys::setSyslog($db, 52, 0, "$_POST not set: unable to process ".$this->archiveBackupSubFolder."custom-backup.zip", 0, 0, 0, 0);
                        }
                }
                else
                    {
                        \YAWK\sys::setSyslog($db, 52, 0, "overwrite backup false: ".$this->overwriteBackup."", 0, 0, 0, 0);
                    }
        // END TESTING AREA

                return true;
            }
            else
                {
                    return false;
                }

        }


        public function copyFolder($db, $folder, $targetFolder)
        {
            // set source folder
            $this->sourceFolder = $this->currentFolder.$folder;
            // set target folder
            $this->targetFolder = $targetFolder;

            // copy source folder to target folder
            if (\YAWK\sys::xcopy($this->sourceFolder, $this->targetFolder) === false)
            {   // failed to copy content folder
                \YAWK\sys::setSyslog($db, 52, 2, "failed to copy $this->sourceFolder to $this->targetFolder", 0, 0, 0, 0);
                return false;
            }
            else
                {
                    return true;
                }
        }

        /**
         * Start and manage mysql backup routine.
         * <p>First of all, mysqldump class will be included. Then, a check runs if a .sql backup file exists.
         * if so, check if overwrite backup is allowed. If this is true, doSqlBackup method will be called.
         * (This function does the real job).</p>
         * @author      Daniel Retzl <danielretzl@gmail.com>
         * @version     1.0.0
         * @link        http://yawk.io
         * @annotation  return bool if zip archive exists
         * @return      bool true|false
         */
        public function startFileBackup($db)
        {
            // check if backup overwrite is allowed
            if ($this->overwriteBackup == "false")
            {   // check if POST array is set (form was sent)
                if (isset($_POST))
                {
                    // check if new folder was entered by user
                    if (isset($_POST['newFolder']) && (!empty($_POST['newFolder'])))
                    {
                        // create new archive sub folder path
                        $this->archiveBackupSubFolder = $this->archiveBackupFolder.$_POST['newFolder']."/";

                        // create new directory in archive
                        if (!is_dir($this->archiveBackupSubFolder))
                        {
                            if (mkdir($this->archiveBackupSubFolder))
                            {   // all good, new archive subfolder created
                                // set syslog entry: dir created
                                \YAWK\sys::setSyslog($db, 50, 0, "archive directory created: $this->targetFolder", 0, 0, 0, 0);
                            }
                            else
                            {   // failed to create new archive subfolder
                                // set syslog entry: failed
                                \YAWK\sys::setSyslog($db, 52, 0, "failed to create archive directory: $this->targetFolder", 0, 0, 0, 0);
                            }
                        }
                    }
                    // check if existing folder was selected by user
                    else if (isset($_POST['selectFolder']) && (!empty($_POST['selectFolder'])))
                    {   // set archive sub folder path
                        $this->archiveBackupSubFolder = $this->archiveBackupFolder.$_POST['selectFolder']."/";
                    }

                    $this->targetFolder = $this->archiveBackupSubFolder;
                    $this->targetFolder = $this->archiveBackupSubFolder;
                }
            }

            // check if a backup exists
            if ($this->zipFileExists() === true)
            {
                // do database backup
                if ($this->doFolderBackup($db) === true)
                {   // ok, backup done
                    \YAWK\sys::setSyslog($db, 50, 3, "file backup overwritten", 0, 0, 0, 0);
                    return true;
                }
                else
                {   // backup failed - unable to overwrite - check chmod settings!
                    \YAWK\sys::setSyslog($db, 52, 2, "failed to overwrite file backup", 0, 0, 0, 0);
                    return false;
                }
            }
            else
            {   // .sql file does not exist - do database backup
                if ($this->doFolderBackup($db) === true)
                {   // ok, backup done!
                    \YAWK\sys::setSyslog($db, 50, 3, "created file backup", 0, 0, 0, 0);
                    return true;
                }
                else
                {   // backup failed!
                    \YAWK\sys::setSyslog($db, 52, 2, "failed to write file backup", 0, 0, 0, 0);
                    return false;
                }
            }
        }
    }
}