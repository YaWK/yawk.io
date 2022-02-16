<?php
namespace YAWK\BACKUP\FILES
{
    /**
     * @details <b>YaWK Backup Component: File Backup Class</b>
     * <p>Methods to backup folders and files</p>
     *
     * @package    YAWK
     * @author     Daniel Retzl <danielretzl@gmail.com>
     * @copyright  2018 Daniel Retzl
     * @license    https://opensource.org/licenses/MIT
     * @version    1.0.0
     * @brief This class serves methods to create backup from files.
     */
    class fileBackup extends \YAWK\BACKUP\backup
    {
        /** @param object zip object */
        public $zip;
        /** @param string source folder to backup */
        public $sourceFolder = '';
        /** @param string path, where the backup will be stored */
        public $targetFolder = '../system/backup/current/';
        /** @param string default filename of .zip file */
        public $backupZipFile = 'backup-custom.zip';
        /** @param string hash value of .zip file */
        public $hashValue = '';
        /** @param string content folder */
        public $contentFolder = '../content/';
        /** @param string media folder */
        public $mediaFolder = '../media/';
        /** @param string system folder */
        public $systemFolder = '../system/';
        /** @param string current processing folder */
        public $currentFolder = '';
        /** @param string final filename*/
        public $finalFilename = '';


        /**
         * @brief Initialize and start file backup
         * @param       object $db database object
         * @param       string $overwriteBackup if overwrite backup is allowed or not "true" | "false"
         * @param       string $zipBackup if backup should be zipped or not "true" | "false"
         * @return      bool
         * @version     1.0.0
         * @link        http://yawk.io
         * @author      Daniel Retzl <danielretzl@gmail.com>
         */
        public function initFolderBackup(object $db, string $overwriteBackup, string $zipBackup): bool
        {
            // start file backup
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
         * @brief Check if .zip backup file exists
         * @brief  return bool if $this->backupZipFile exists
         * @return      bool true|false
         */
        public function zipFileExists(): bool
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
         * @brief Write backup.ini file (used by backup restore methods)
         * @brief       write all relevant backup information into this file
         * @return      array $this->backupSettings
         */
        public function setBackupSettings()
        {
            // set some backup info variables
            $this->backupSettings['DATE'] = \YAWK\sys::now();
            $this->backupSettings['METHOD'] = $this->backupMethod;
            $this->backupSettings['FILE'] = $this->finalFilename;
            $this->backupSettings['PATH'] = $this->targetFolder;
            $this->backupSettings['USER_ID'] = $_SESSION['uid'];
            return $this->backupSettings;
        }

        /**
         * @brief Get and return hash value of $file
         * @brief  return hashed string or false
         * @return      string|bool
         */
        public function getHashValue($db, $file)
        {
            // check if file is set
            if (!isset($file) || (empty($file)))
            {   // file not set
                return false;
            }

            // check if sql backup file is accessable
            if (is_file($file))
            {   // generate hash value
                return $this->hashValue = hash_file('md5', $file);
            }
            else
            {   // file not found: unable to generate hash value
                \YAWK\sys::setSyslog($db, 52, 2, "failed to generate hash value - $file is not accessable", 0, 0, 0, 0);
                return false;
            }
        }

        /**
         * @brief Copy files to tmp folder, zip it and move it to the place
         * where this backup should be stored (current or archive...)
         * @brief  return bool if $this->backupZipFile exists
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

            // PREPARE FINAL FILENAME
            // set filename of backup .zip archive (including path to tmp folder)
            // check, which filename the backup should have:
            if (isset($_POST['backupMethod']) && (!empty($_POST['backupMethod'])))
            {
                switch ($_POST['backupMethod'])
                {
                    case "complete" :
                    {
                        $this->finalFilename = "complete-backup.zip";
                        $this->backupMethod = "complete";
                    }
                    break;

                    case "mediaFolder" :
                    {
                        $this->finalFilename = "mediafolder-backup.zip";
                        $this->backupMethod = "mediaFolder";
                    }
                    break;

                    case "custom" :
                    {
                        $this->finalFilename = "custom-backup.zip";
                        $this->backupMethod = "custom";
                    }
                    break;

                    default:
                    {
                        $this->finalFilename = "backup.zip";
                        $this->backupMethod = "unknown";
                    }

                }
            }

            // set backup settings
            $this->backupSettings = $this->setBackupSettings();

            // check if ini file was written
            if (\YAWK\sys::writeIniFile($this->backupSettings, $this->tmpFolder.$this->configFilename) === true)
            {
                // check if config file is there
                if (!is_file($this->tmpFolder.$this->configFilename))
                {   // config file not found
                    \YAWK\sys::setSyslog($db, 51, 1, "backup ini file written, but not found - please check: $this->configFilename", 0, 0, 0, 0);
                    return false;
                }
            }

            // ZIP FOLDER + COPY TO FINAL DESTINATION
            // try to zip the whole tmp/ folder
            if ($this->zipFolder($db, $this->tmpFolder, $this->tmpFolder."$this->finalFilename") == true)
            {
                // check if POST data is sent
                if (isset($_POST))
                {
                    // check if backup overwrite is allowed
                    if (isset($_POST['overwriteBackup']) && ($_POST['overwriteBackup'] == "false"))
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
                                    \YAWK\sys::setSyslog($db, 49, 0, "archive directory created: $this->archiveBackupSubFolder", 0, 0, 0, 0);
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

                        // STORE TO ARCHIVE FOLDER
                        // move final *****-backup .zip to archive backup folder
                        if (rename($this->tmpFolder.$this->finalFilename, $this->archiveBackupSubFolder.$this->finalFilename))
                        {   // check if final filename exists
                            if (is_file($this->archiveBackupSubFolder.$this->finalFilename))
                            {
                                // ok, delete tmp folder recursive
                                \YAWK\sys::recurseRmdir($this->tmpFolder);
                                // set positive syslog entry
                                \YAWK\sys::setSyslog($db, 49, 3, "created ".$this->archiveBackupSubFolder."$this->finalFilename", 0, 0, 0, 0);
                                return true;
                            }
                            else
                                {   // failed to create backup
                                    \YAWK\sys::setSyslog($db, 52, 0, "failed to create ".$this->archiveBackupSubFolder."$this->finalFilename", 0, 0, 0, 0);
                                    return false;
                                }
                        }
                        else
                            {   // failed to move final backup file
                                \YAWK\sys::setSyslog($db, 52, 0, "failed to move ".$this->archiveBackupSubFolder."$this->finalFilename", 0, 0, 0, 0);
                                return false;
                            }
                    }
                    else
                    {   // STORE TO CURRENT FOLDER
                        // move final *****-backup .zip to current backup folder
                        if (rename($this->tmpFolder.$this->finalFilename, $this->currentBackupFolder.$this->finalFilename))
                        {
                            // check if final backup file is available in current folder
                            if (is_file($this->currentBackupFolder.$this->finalFilename))
                            {   // ok, remove tmp dir recursivly
                                \YAWK\sys::recurseRmdir($this->tmpFolder);
                                // set positive syslog entry
                                \YAWK\sys::setSyslog($db, 49, 3, "created ".$this->currentBackupFolder."$this->finalFilename", 0, 0, 0, 0);
                                return true;
                            }
                            else
                            {   // failed to create current backup
                                \YAWK\sys::setSyslog($db, 52, 0, "failed to create ".$this->currentBackupFolder."$this->finalFilename", 0, 0, 0, 0);
                                return false;
                            }
                        }
                        else
                        {   // failed to move backup archive to current folder
                            \YAWK\sys::setSyslog($db, 52, 0, "failed to move ".$this->currentBackupFolder."$this->finalFilename", 0, 0, 0, 0);
                            return false;
                        }
                    }
                }
                else
                    {   // post data not sent
                        \YAWK\sys::setSyslog($db, 52, 0, "failed to backup: POST data not sent", 0, 0, 0, 0);
                        return true;
                    }
            }
            else
                {   // failed to zip final backup file
                    \YAWK\sys::setSyslog($db, 52, 0, "unable to zip ".$this->finalFilename."", 0, 0, 0, 0);
                    return false;
                }
        }


        /**
         * @brief Copy a folder from source to target, including all subdirectories
         * @param $db
         * @param $folder
         * @param $targetFolder
         * @return bool
         */
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
                {   // copy folder successful
                    return true;
                }
        }

        /**
         * @brief Check settings and start file backup
         * @brief       return bool if zip archive exists
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
                        {   // try to create archive subfolder
                            if (mkdir($this->archiveBackupSubFolder))
                            {   // all good, new archive subfolder created
                                // set syslog entry: dir created
                                \YAWK\sys::setSyslog($db, 49, 0, "archive directory created: $this->archiveBackupSubFolder", 0, 0, 0, 0);
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
                    {   // set archive sub folder path
                        $this->archiveBackupSubFolder = $this->archiveBackupFolder.$_POST['selectFolder']."/";
                    }

                    // set backup target folder
                    $this->targetFolder = $this->archiveBackupSubFolder;
                }
            }

            // check if a backup exists
            if ($this->zipFileExists() === true)
            {
                // do folder backup
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
            {   // file does not exist - do file backup
                if ($this->doFolderBackup($db) === true)
                {   // ok, backup done!
                    // \YAWK\sys::setSyslog($db, 50, 3, "created file backup", 0, 0, 0, 0);
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