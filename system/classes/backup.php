<?php
namespace YAWK\BACKUP
{

    use YAWK\db;

    /**
     * @details <b>Backup Class</b>
     * <p>Methods to backup and restore complete or partial project data including:
     * pages folder, media folder, system folder and database. The Backup can be
     * stored and overwritten in current Folder. Otherwise it is possible to archive
     * any backup. To do this, you can create a new folder to store the backup within.</p>
     *
     * @package    YAWK
     * @author     Daniel Retzl <danielretzl@gmail.com>
     * @copyright  2018 Daniel Retzl
     * @license    https://opensource.org/licenses/MIT
     * @version    1.0.0
     * @brief Backup Main Class
     */
    class backup
    {
        /** @param object mysql backup object */
        public $mysqlBackup;
        /** @param object files backup object */
        public $fileBackup;
        /** @param string path, where the backup will be stored */
        public $targetFolder = '../system/backup/current/';
        /** @param string source folder to backup */
        public $sourceFolder = '';
        /** @param string current backup folder path */
        public $currentBackupFolder = '../system/backup/current/';
        /** @param array files in current backup folder */
        public $currentBackupFiles = array();
        /** @param string archive backup folder path */
        public $archiveBackupFolder = '../system/backup/archive/';
        /** @param array all sub folders in archiveBackupFolder */
        public $archiveBackupSubFolders = array();
        /** @param string archive working subfolder */
        public $archiveBackupSubFolder = '';
        /** @param array files in archive backup folder */
        public $archiveBackupFiles = array();
        /** @param string archive backup file */
        public $archiveBackupFile = '';
        /** @param string new archive file */
        public $archiveBackupNewFile = '';
        /** @param string upload folder */
        public $downloadFolder = '../system/backup/download/';
        /** @param string tmp folder */
        public $tmpFolder = '../system/backup/tmp/';
        /** @param string files|database|complete */
        public $backupMethod = "database";
        /** @param string filename of the config file (default: backup.ini) */
        public $configFilename = "backup.ini";
        /** @param string config file, including path */
        public $configFile = '';
        /** @param array backup settings */
        public $backupSettings = array();
        /** @param string overwrite backup files? */
        public $overwriteBackup = "true";
        /** @param string zip backup if possible */
        public $zipBackup = "true";
        /** @param string remove files after zip is complete */
        public $removeAfterZip = "true";
        /** @param string should .sql backup be stored in tmp folder? */
        public $storeSqlTmp = "false";
        /** @param string restore file (zip file) */
        public $restoreFile = '';
        /** @param array restorable files (files from tmp folder) */
        public $restoreFiles = array();
        /** @param array restore folders (content, media, system) */
        public $restoreFolders = array();
        /** @param string restore from folder */
        public $restoreFolder = '';
        /** @param string restore mode (database, mediafolder, complete, custom) */
        public $restoreMode = '';
        /** @param array holds information about the restore process states */
        public $restoreStatus = array();


        /**
         * @brief backup constructor. prepare temp folder on class instantiation
         * @param $db
         */
        public function __construct($db)
        {   // prepare temp folder on class instantiation
            // check and create required folders
            $requiredFolders = array($this->tmpFolder, $this->currentBackupFolder, $this->archiveBackupFolder);

            foreach ($requiredFolders as $folder)
            {
                // if tmp folder does not exist
                if (!is_dir($folder))
                {   // create tmp folder
                    if (!mkdir($folder))
                    {   // unable to create tmp folder
                        \YAWK\sys::setSyslog($db, 52, 2, "failed to create " . $folder . "", 0, 0, 0, 0);
                        // return false;
                    }
                    else
                    {   // tmp folder created - try to set owner + group writeable
                        if (chmod($folder, 0775))
                        {   // ok...
                            // return true;
                        }
                        else
                        {   // unable to set folder properties
                            \YAWK\sys::setSyslog($db, 52, 2, "failed to set permissions of folder " . $folder . "", 0, 0, 0, 0);
                            // return false;
                        }
                    }
                }
            }
        }

        /**
         * @brief Init Backup Class (run backup)
         * @param       object $db database object
         * @return      bool true: backup init success | false: backup init failed
         */
        public function init($db)
        {
            // run backup system
            if ($this->run($db) === true)
            {   // init successful
                return true;
            }
            else
                {   // backup init failed
                    return false;
                }
        }

        /**
         * @brief Run a new backup, depending on chosen backup method
         * @param       object $db database object
         * @return      bool true: backup successful | false: backup failed
         */
        public function run($db)
        {   /** @param $db db */
            // check if backup method is set
            if (isset($this->backupMethod) && (!empty($this->backupMethod)))
            {   // which backup method should be executed?
                switch ($this->backupMethod)
                {
                    // do a complete backup
                    case "complete":
                    {
                        $this->storeSqlTmp = "true";

                        // run database backup
                        if ($this->runDatabaseBackup($db, $this->storeSqlTmp) === true)
                        {   // db backup was successful
                            // return true;
                        }
                        else
                        {   // failed to run db backup
                            // set syslog entry: db backup could not be made
                        }

                        // run backup of complete system (including database)
                        if ($this->runFileBackup($db) === true)
                        {   // success
                            return true;
                        }
                        else
                        {   // media folder backup failed
                            return false;
                        }
                    }
                    break;

                    // database only
                    case "database":
                    {
                        $this->storeSqlTmp = "false";
                        // run database backup
                        if ($this->runDatabaseBackup($db, $this->storeSqlTmp) === true)
                        {   // db backup was successful
                            return true;
                        }
                        else
                            {   // failed to run db backup
                                return false;
                            }
                    }
                    break;

                    // media folder only
                    case "mediaFolder":
                    {   // run backup of media folder
                        if ($this->runFileBackup($db) === true)
                        {   // success
                            return true;
                        }
                        else
                            {   // media folder backup failed
                                return false;
                            }
                    }
                    break;

                    // custom backup selected
                    case "custom":
                    {
                        // store .sql file in tmp folder (because we're doing a file package)
                        $this->storeSqlTmp = "true";

                        // check if database backup is requested by form
                        if (isset($_POST['database']) && (!empty($_POST['database'])))
                        {
                            // run database backup
                            if ($this->runDatabaseBackup($db, $this->storeSqlTmp) === true)
                            {
                                // db backup successful
                            }
                            else
                            {   // db backup FAILED
                                // return false;
                            }
                        }

                        // run backup of custom folder
                        if($this->runFileBackup($db) === true)
                        {   // success
                            return true;
                        }
                        else
                        {   // custom folder backup failed
                            return false;
                        }
                    }
                    break;
                }
                // unknown backup method -
                return false;
            }
            else
                {
                    // what if no backup method is set?
                    // add default behavior
                    return false;
                }
        }

        /**
         * @brief Set backup information file (backup.ini)
         * @param object $db database handle
         * @return bool
         * @details   will be added to every .zip file to identify what to do during restore process
         * @version     1.0.0
         * @link        http://yawk.io
         * @author      Daniel Retzl <danielretzl@gmail.com>
         */
        public function setIniFile(object $db): bool
        {   // check if target folder is set

            // check if target folder is writeable
            if (is_writeable($this->targetFolder))
            {   // set configfile (string that includes path + filename)
                $this->configFile = $this->targetFolder.$this->configFilename;

                if (isset($this->storeSqlTmp) && ($this->storeSqlTmp == "true"))
                {
                    if (!is_dir($this->tmpFolder."database"))
                    {
                        mkdir($this->tmpFolder."database");
                    }
                    $this->configFile = $this->tmpFolder."database/".$this->configFilename;
                }

                // check if ini file was written
                if (\YAWK\sys::writeIniFile($this->backupSettings, $this->configFile) === true)
                {
                    // check if config file is there
                    if (is_file($this->configFile))
                    {   // config file found!
                        return true;
                    }
                    else
                        {   // config file not found
                            \YAWK\sys::setSyslog($db, 51, 1, "backup ini file written, but not found - please check: $this->configFile", 0, 0, 0, 0);
                            return false;
                        }
                }
                else
                    {   // unable to write config file
                        \YAWK\sys::setSyslog($db, 52, 2, "failed to write backup config file $this->configFile", 0, 0, 0, 0);
                        return false;
                    }
            }
            else
                {   // target folder not writeable
                    \YAWK\sys::setSyslog($db, 51, 1, "failed to write backup config file: $this->configFile - target folder not writeable", 0, 0, 0, 0);
                    return false;
                }
        }

        /**
         * @brief Parse backup ini file
         * @param $db
         * @param $iniFile
         * @return array|false
         */
        public function parseIniFile($db, $iniFile)
        {   // set config file property
            $this->configFile = $iniFile;
            // check if ini file is there
            if (is_file($this->configFile))
            {
                // update backup settings from ini file
                $this->backupSettings = parse_ini_file($this->configFile);
                // check backup settings array is set
                if (is_array($this->backupSettings))
                {   // array is set, return backup settings
                    return $this->backupSettings;
                }
                else
                    {   // failed parse ini file: but array is not set
                        \YAWK\sys::setSyslog($db, 52, 1, "failed to parse ini file: $this->configFile is there, but backupSettings array is not set", 0, 0, 0, 0);
                        return false;
                    }
            }
            else
                {   // no ini file found!
                    // set syslog entry
                    \YAWK\sys::setSyslog($db, 51, 1, "failed to parse ini file: $this->configFile not found", 0, 0, 0, 0);
                    return false;
                }
        }

        /**
         * @brief get all files from current backup folder into array
         * @return array|false
         */
        public function getCurrentBackupFilesArray()
        {
            // get current backup files into array
            $this->currentBackupFiles = \YAWK\filemanager::getFilesFromFolderToArray($this->currentBackupFolder);
            // check if backup files are set
            if (is_array($this->currentBackupFiles))
            {   // ok, return files
                return $this->currentBackupFiles;
            }
            else
                {   // array is not set
                    return false;
                }
        }

        /**
         * @brief get all files from archive backup folder into array
         * @return array|false
         */
        public function getArchiveBackupFilesArray()
        {
            // get current backup files into array
            $this->archiveBackupFiles = \YAWK\filemanager::getFilesFromFolderToArray($this->archiveBackupSubFolder);
            // check if backup files are set
            if (is_array($this->archiveBackupFiles))
            {   // ok, return files
                return $this->archiveBackupFiles;
            }
            else
            {   // array is not set
                return false;
            }
        }

        /**
         * @brief Include mysql backup class and run mysqldump backup
         * @return      bool
         */
        public function runDatabaseBackup($db, $storeSqlTmp)
        {
            if (isset($storeSqlTmp) && (!empty($storeSqlTmp)))
            {
                $this->storeSqlTmp = $storeSqlTmp;
            }
            // include backup-database class
            require_once 'backup-mysqlBackup.php';
            // create new database backup object
            $this->mysqlBackup = new \YAWK\BACKUP\DATABASE\mysqlBackup($this->backupSettings);

            // initialize database backup (this will run mysqldump-php)
            if ($this->mysqlBackup->initMysqlBackup($db, $this->overwriteBackup, $this->zipBackup, $this->storeSqlTmp) === true)
            {   // database backup successful
                return true;
            }
            else
            {   // database backup failed
                return false;
            }
        }


        /**
         * @brief Run File Backup from $sourceFolder
         * @return      bool
         */
        public function runFileBackup($db)
        {
            // include fileBackup class
            require_once 'backup-fileBackup.php';
            // create new file backup object
            $this->fileBackup = new \YAWK\BACKUP\FILES\fileBackup($db);

            // initialize database backup (this will run mysqldump-php)
            if ($this->fileBackup->initFolderBackup($db, $this->overwriteBackup, $this->zipBackup) === true)
            {   // file backup successful
                return true;
            }
            else
            {   // file backup failed
                return false;
            }
        }


        /**
         * @brief Check if ZipArchive function exists
         * @return      bool
         */
        public function checkZipFunction()
        {
            // check if zip extension is loaded
            if (extension_loaded('zip'))
            {   // ok...
                return true;
            }
            else
                {   // zip extension is not loaded
                    return false;
                }
        }

        /**
         * @brief Zip a whole folder from $source to $destination.zip
         * @return      bool
         */
        function zipFolder($db, $source, $destination)
        {
            // check if zip extension is available
            if ($this->checkZipFunction() === false)
            {   // if not
                return false;
            }

            // make sure $source file/folder exists
            if (!file_exists($source))
            {   // if not
                return false;
            }

            // create new zip object
            $zip = new \ZipArchive();

            // make sure to create and open new zip archive
            if (!$zip->open($destination, \ZIPARCHIVE::CREATE))
            {   // if not
                return false;
            }

            // set path slashes correctly
            $source = str_replace('\\', '/', realpath($source));

            // check if $source is a directoy
            if (is_dir($source) === true)
            {
                // run recusrive iterators to store files in array
                $elements = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($source), \RecursiveIteratorIterator::SELF_FIRST);

                // walk through folder
                foreach ($elements as $file)
                {
                    // set path slashes correctly
                    $file = str_replace('\\', '/', $file);

                    // ignore dot folders (. and ..)
                    if( in_array(substr($file, strrpos($file, '/')+1), array('.', '..')) )
                    continue;

                    // set file including path
                    $file = realpath($file);

                    // check if current element is a directory
                    if (is_dir($file) === true)
                    {   // add folder to zip file
                        $zip->addEmptyDir(str_replace($source . '/', '', $file . '/'));
                    }
                    // check if current element is a file
                    else if (is_file($file) === true)
                    {   // add file to zip archive
                        $zip->addFromString(str_replace($source . '/', '', $file), file_get_contents($file));
                    }
                }
            }
            // if $source is a file
            else if (is_file($source) === true)
            {   // add file to zip archive
                $zip->addFromString(basename($source), file_get_contents($source));
            }

            // all done, close (and write) zip archive
            $zip->close();

            // check if .zip file is there
            if (is_file($destination))
            {
                // INSTANT-DOWNLOAD WORKAROUND -
                // to improve usability, the file will be served as direct downloaded.
                // this piece of JS code changes the link (from generating .zip to download/zipfile.zip)
                // due this method its not needed to send location headers (which is not possible at this stage)

                // this 'hack' should work in most browsers, but may not work in some. (eg: untested in safari)

                // check if archive ID is set
                if (isset($_GET['archiveID']) && (!empty($_GET['archiveID'])))
                {   // set var for JS: downloadArchiveLink (selector)
                    $downloadArchiveLink = "#archive-".$_GET['archiveID'];
                    // set var for JS: link to the file to download
                    $downloadFile = $this->downloadFolder.$_GET['folder'].".zip";
                    // dirty lil piece of JS code to emulate the user's click
                    // (this avoids that he have to click twice to 1)generate + 2)download)
                    echo "
                            <script type='text/javascript'>
                                $(document).ready(function()
                                {   // change href attribute for this archive to direct donwload file
                                    $('$downloadArchiveLink').attr('href', '$downloadFile')
                                    // emulate a users click to force direct download
                                    $('$downloadArchiveLink')[0].click();
                                    // if this is not working, the user have to click on that link.
                                });
                            </script>";
                }
                // ZIP file created, force download js fired.
                return true;
            }
            else
                {   // failed to create download archive
                    \YAWK\sys::setSyslog($db, 52, 3, "failed to create download archive: $destination", 0, 0, 0, 0);
                    return false;
                }
        }

        /**
         * @brief Manage how a backup will be restored from backup folder
         * @param $db
         * @param $file
         * @param $folder
         * @return array|false
         */
        public function restore($db, $file, $folder)
        {
            if (isset($file) && (!empty($file)
            && (isset($folder) && (!empty($folder)))))
            {
                // set restore file property
                $this->restoreFile = $file;
                $this->restoreFolder = $folder;

                // check which backup should be made
                if (is_writeable($this->tmpFolder))
                {
                    $source = $this->restoreFolder.$this->restoreFile;
                    $target = $this->tmpFolder.$this->restoreFile;

                    // copy file to tmp folder
                    copy($source, $target);

                    // check if backup file was copied...
                    if (is_file($target))
                    {   // file exists...
                        if ($this->checkZipFunction() === true)
                        {   // ok, create new zip object
                            $zip = new \ZipArchive;
                            // open zip archive
                            $res = $zip->open($target);
                            // if zip open was successful
                            if ($res === TRUE)
                            {   // extract zip file
                                $zip->extractTo($this->tmpFolder);
                                // close zip file
                                $zip->close();
                                // zip extraction successful

                                // check if backup.ini file is there...
                                if (is_file($this->tmpFolder.$this->configFilename))
                                {
                                    // ok, backup.ini found, parse data from file into array
                                    $this->backupSettings = $this->parseIniFile($db, $this->tmpFolder.$this->configFilename);

                                    // check if backup settings array is set and not empty
                                    if (is_array($this->backupSettings) && (!empty($this->backupSettings)))
                                    {
                                        // PROCESS RESTORE METHODS
                                        switch ($this->backupSettings['METHOD'])
                                        {
                                            // COMPLETE PROCESSING
                                            case "complete":
                                            {
                                                // set folders for complete restore
                                                $this->restoreFolders = \YAWK\filemanager::getSubfoldersToArray($this->tmpFolder);
                                                $this->restoreStatus = $this->doRestore($db, $this->restoreFolders);
                                                {
                                                    return $this->restoreStatus;
                                                }
                                            }
                                            break;

                                            case "database":
                                            {   // restore database
                                                $this->restoreFolders = array('database');
                                                $this->restoreStatus = $this->doRestore($db, $this->restoreFolders);
                                                {
                                                    return $this->restoreStatus;
                                                }
                                            }
                                            break;

                                            case "mediaFolder":
                                            {   // set media folder restore
                                                // $this->restoreFolders = \YAWK\filemanager::getSubfoldersToArray($this->tmpFolder);
                                                $this->restoreFolders = array('media/');
                                                $this->restoreStatus = $this->doRestore($db, $this->restoreFolders);
                                                {
                                                    return $this->restoreStatus;
                                                }
                                            }
                                            break;

                                            case "custom":
                                            {   // get custom restore folders
                                                $this->restoreFolders = \YAWK\filemanager::getSubfoldersToArray($this->tmpFolder);
                                                $this->restoreStatus = $this->doRestore($db, $this->restoreFolders);
                                                {
                                                    return $this->restoreStatus;
                                                }
                                            }
                                            break;
                                        }
//                                        return true;
                                    }
                                    else
                                    {
                                        // backup settings not set or empty
                                        \YAWK\sys::setSyslog($db, 52, 1, "failed to restore backup: restore settings array is not set", 0, 0, 0, 0);
                                        return false;
                                    }
                                }
                                else
                                    {
                                        // backup.ini file not found - abort
                                        \YAWK\sys::setSyslog($db, 52, 1, "failed to restore backup: ini file not found - $this->tmpFolder.$this->configFilename", 0, 0, 0, 0);
                                        return false;
                                    }
                            }
                            else
                            {   // unable to open zip file
                                \YAWK\sys::setSyslog($db, 52, 1, "failed to restore: unable to open ZIP file", 0, 0, 0, 0);
                                return false;
                            }
                        }
                        else
                            {   // zip extension not loaded
                                \YAWK\sys::setSyslog($db, 52, 1, "failed to restore: unable to unzip backup package - ZIP extension not loaded.", 0, 0, 0, 0);
                                return false;
                            }
                    }
                    else
                        {   // target file not found - no backup file copied to tmp folder
                            \YAWK\sys::setSyslog($db, 52, 1, "failed to copy backup package: $source not copied to $target", 0, 0, 0, 0);
                            return false;
                        }
                }
                else
                    {
                        // tmp folder is not writeable
                        \YAWK\sys::setSyslog($db, 52, 1, "failed to restore backup: tmp folder ($this->tmpFolder) is not writeable", 0, 0, 0, 0);
                        return false;
                    }
            }
            else
                {   // no file set
                    \YAWK\sys::setSyslog($db, 52, 1, "failed to restore backup: file not set", 0, 0, 0, 0);
                    return false;
                }
        }

        /**
         * @brief Restore Data physically to folder, restore .sql file to database if needed.
         * @param $db
         * @param $restoreFolders
         * @return array
         */
        public function doRestore($db, $restoreFolders)
        {
            /** @param db $db */
            // check if restore folders are set
            if (isset($restoreFolders) && (!empty($restoreFolders)))
            {   // restore folders not set or empty
                $this->restoreFolders = $restoreFolders;
            }

            // restore each required folder
            foreach ($this->restoreFolders as $folder)
            {
                // check if content, database, media and system folder exists...
                if (is_dir(dirname($this->tmpFolder.$folder)))
                {
                    // copy all folders except database
                    if ($folder !== "database")
                    {
                        // restore folder
                        if (\YAWK\sys::xcopy($this->tmpFolder . $folder, "../$folder") === true)
                        {
                            $this->restoreStatus[][$folder]['success'] = "true";
                        }
                        else
                        {
                            // failed to restore folder
                            $this->restoreStatus[][$folder]['success'] = "false";
                            $this->restoreStatus[][$folder]['error'] = "failed to copy " . $this->tmpFolder . "$folder check permissions of ../$folder";
                        }
                    }

                    // IF DATABASE RESTORE IS REQUESTED
                    else
                        {

                            if (is_file($this->tmpFolder."database-backup.sql_error"))
                            {
                                unlink($this->tmpFolder."database-backup.sql_error");
                            }

                            if (is_file($this->tmpFolder."database-backup.sql_filepointer"))
                            {
                                unlink($this->tmpFolder."database-backup.sql_filepointer");
                            }


                            // check if database file is in tmp/
                            if (file_exists($this->tmpFolder."database-backup.sql"))
                            {
                                // check if backup.ini exists in tmp/database folder
                                if (is_file($this->tmpFolder.$this->configFilename))
                                {
                                    // ok, database folder found, parse data from database/folder
                                    $this->backupSettings = $this->parseIniFile($db, $this->tmpFolder.$this->configFilename);
                                    // get array with all tables that should be updated
                                    $activeTables = explode(',', $this->backupSettings['TABLES']);
                                    // delete not needed last item of array
                                    array_pop($activeTables);
                                    // drop all tables that should be updated
                                    $db->dropTables($activeTables);
                                }

                                if ($db->import($this->tmpFolder."database-backup.sql", '') === true)
                                {
                                    $this->restoreStatus[]['database']['success'] = "true";
                                    //return $this->restoreStatus;
                                }
                                else
                                    {
                                        $this->restoreStatus[]['database']['success'] = "true";
                                        $this->restoreStatus[]['database']['error'] = "failed to restore database backup.";
                                        //return $this->restoreStatus;
                                    }
                            }
                            // check if database dir exists: tmp/database
                            else if (is_dir(dirname($this->tmpFolder."database/")))
                            {
                                // check if backup.ini exists in tmp/database folder
                                if (is_file($this->tmpFolder."database/".$this->configFilename))
                                {
                                    // ok, database folder found, parse data from database/folder
                                    $this->backupSettings = $this->parseIniFile($db, $this->tmpFolder."database/".$this->configFilename);
                                    // get array with all tables that should be updated
                                    $activeTables = explode(',', $this->backupSettings['TABLES']);
                                    // delete not needed last item of array
                                    array_pop($activeTables);
                                    // drop all tables that should be updated
                                    $db->dropTables($activeTables);
                                }

                                // check if database file exists in tmp/database
                                if (file_exists($this->tmpFolder."database/database-backup.sql"))
                                {
                                    if ($db->import($this->tmpFolder."database/database-backup.sql", '') === true)
                                    {
                                        $this->restoreStatus[]['database']['success'] = "true";
                                        //return $this->restoreStatus;
                                    }
                                    else
                                    {
                                        $this->restoreStatus[]['database']['success'] = "true";
                                        $this->restoreStatus[]['database']['error'] = "failed to restore database backup.";
                                        //return $this->restoreStatus;
                                    }
                                }
                            }

                        }
                }
                else
                {   // failed to restore - folder does not exist or not writeable
                    $this->restoreStatus[][$folder]['error'] = "failed to restore ../$folder : folder is not there or not writeable";
                }
            }

            // restore fin - delete tmp folder
            \YAWK\sys::recurseRmdir($this->tmpFolder);
            // and return restore status
            return $this->restoreStatus;
        }

        /**
         * @brief check restore folders, check + set permissions of restore folders
         * @param $restoreFolders
         * @return bool
         */
        public function checkFolders($restoreFolders)
        {
            if (!isset($restoreFolders) || (empty($restoreFolders)))
            {
                return false;
            }
            // set folders to process
            // $restoreFolders = array('../content/', '../media/', '../system/fonts/', '../system/widgets/');
            // set filemode
            $filemode = 0755;

            // walk through folders
            foreach ($restoreFolders as $folder)
            {   // check if permissions are high enough
                if ($this->checkPermissions($folder) !== 0775
                || ($this->checkPermissions($folder) !== 0777))
                {
                    $folder = "../".$folder;
                    // if not:
                    // iterate folder recursive
                    $iterator = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($folder));
                    // walk through items...
                    foreach($iterator as $item)
                    {   // try to set folder permissions
                        if ($this->setPermissions($item, $filemode) === false)
                        {   // unable to set permissions
                            return false;
                        }
                    }
                }
            }
            return true;
        }

        /**
         * @brief set folder permissions and do some chmod stuff to with given $filemode to $folder
         * @param $folder
         * @param $filemode
         * @return bool
         */
        public function setPermissions($folder, $filemode): bool
        {   // check if filemode is set
            if (!isset($filemode) || (empty($filemode)))
            {   // nope -
                return false;
            }

            // check if folder is set, not empty and correct type
            if (isset($folder) && (!empty($folder) && (is_string($folder))))
            {
                // set path
                $folder = "../".$folder;

                // check if folder exists...
                if (is_dir(dirname($folder)))
                {
                    // try to set folder to writeable for owner + group
                    if (chmod($folder, $filemode))
                    {
                        return true;
                    }
                    else
                        {   // failed to chmod
                            // PERMISSION PROBLEM - user have to edit chmod settings via FTP manually
                            return false;
                        }
                }
                else
                    {   // directory not exists
                        return false;
                    }
            }
            else
                {   // folder not set, empty or wrong type
                    return false;
                }
        }


        /**
         * @brief check folder permissions and return permissions as string (eg 0755)
         * @param $folder
         * @return false|string|null
         */
        public function checkPermissions($folder)
        {
            // check if folder is set, not empty and correct type
            if (isset($folder) && (!empty($folder) && (is_string($folder))))
            {
                // set path
                $folder = "../".$folder;
                // check if folder exists...
                if (is_dir(dirname($folder)))
                {   // return permissions as string eg '0755'
                    return substr(sprintf('%o', fileperms($folder)), -4);
                }
                else
                {   // folder does not exist
                    return null;
                }
            }
            else
            {   // folder not set, empty or wrong type
                return null;
            }
        }
    }
}