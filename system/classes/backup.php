<?php
namespace YAWK\BACKUP
{
    /**
     * <b>Backup Class</b>
     * <p>Methods to backup and restore complete project data including: pages,
     * menus, widgets, media folder and so on. This is a work in progress file!</p>
     *
     * @package    YAWK
     * @author     Daniel Retzl <danielretzl@gmail.com>
     * @copyright  2018 Daniel Retzl
     * @license    https://opensource.org/licenses/MIT
     * @version    1.0.0
     * @link       http://yawk.io
     * @annotation WORK IN PROGRESS!
     */
    class backup
    {
        /** @var object mysql backup object */
        public $mysqlBackup;
        /** @var object files backup object */
        public $filesBackup;
        /** @var string path, where the backup will be stored */
        public $targetFolder = '../system/backup/current/';
        /** @var string current backup folder path */
        public $currentBackupFolder = '../system/backup/current/';
        /** @var array files in current backup folder */
        public $currentBackupFiles = array();
        /** @var string archive backup folder path */
        public $archiveBackupFolder = '../system/backup/archive/';
        /** @var array all sub folders in archiveBackupFolder */
        public $archiveBackupSubFolders = array();
        /** @var string archive working subfolder */
        public $archiveBackupSubFolder = '';
        /** @var array files in archive backup folder */
        public $archiveBackupFiles = array();
        /** @var string name of the backup .sql file */
        public $targetFilename = 'backup.zip';
        /** @var string files|database|complete */
        public $backupMethod = "database";
        /** @var string filename of the config file (default: backup.ini) */
        public $configFilename = "backup.ini";
        /** @var string config file, including path */
        public $configFile = '';
        /** @var array backup settings */
        public $backupSettings = array();
        /** @var string overwrite backup files? */
        public $overwriteBackup = "true";
        /** @var string zip backup if possible */
        public $zipBackup = "true";
        /** @var string remove files after zip is complete */
        public $removeAfterZip = "true";


        /**
         * Init Backup Class (start backup)
         * @author      Daniel Retzl <danielretzl@gmail.com>
         * @version     1.0.0
         * @link        http://yawk.io
         */
        public function init($db)
        {   // run backup system

            if ($this->run($db) === true)
            {
                return true;
            }
            else
                {
                    return false;
                }
        }

        /**
         * Run a new backup, depending on chosen backup method
         * @author      Daniel Retzl <danielretzl@gmail.com>
         * @version     1.0.0
         * @link        http://yawk.io
         * @return      bool
         */
        public function run($db)
        {   /** @var $db \YAWK\db */
            // check if backup method is set
            if (isset($this->backupMethod) && (!empty($this->backupMethod)))
            {   // which backup method should be executed?
                switch ($this->backupMethod)
                {
                    // backup complete system (templates, files, folder, database)
                    case "complete":
                    {
                        // make a full backup of everything
                    }
                    break;

                    // backup database only
                    case "database":
                    {   // check if database backup has made

                        if ($this->runDatabaseBackup($db) === true)
                        {   // ok...
                            return true;
                        }
                        else
                            {   // failed to run database backup
                                return false;
                            }
                    }
                    break;

                    // backup files only
                    case "files":
                    {
                        // files + folder only
                    }
                    break;

                    // custom backup selected
                    case "custom":
                    {
                        // do custom backup stuff...
                    }
                    break;
                }
            }
            else
                {
                    // what if no backup method is set?
                    // add default behavior
                }
        }

        /**
         * Set backup information file (backup.ini)
         * @param string $targetFolder folder where the ini file should be stored
         * @author      Daniel Retzl <danielretzl@gmail.com>
         * @version     1.0.0
         * @link        http://yawk.io
         * @return bool
         */
        public function setIniFile($db)
        {   // check if target folder is set

            // check if target folder is writeable
            if (is_writeable($this->targetFolder))
            {   // set configfile (string that includes path + filename)
                $this->configFile = $this->targetFolder.$this->configFilename;
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
                        \YAWK\sys::setSyslog($db, 51, 1, "failed to write backup config file $this->configFile", 0, 0, 0, 0);
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
         * Parse backup ini file
         * @author      Daniel Retzl <danielretzl@gmail.com>
         * @version     1.0.0
         * @link        http://yawk.io
         * @param $iniFile
         * @return bool
         */
        public function parseIniFile($db, $iniFile)
        {   // set config file property
            $this->configFile = $iniFile;
            // check if ini file is there
            if (is_file($this->configFile))
            {
                // update backup settings from ini file
                $this->backupSettings = parse_ini_file($this->configFile);
               //  echo "ini file parse successful!";
                return true;
            }
            else
                {   // no ini file found!
                    // set syslog entry
                    \YAWK\sys::setSyslog($db, 51, 1, "failed to parse ini file - $this->configFile not found", 0, 0, 0, 0);
                    return false;
                }
        }

        /**
         * get all files from current backup folder into array
         * @author      Daniel Retzl <danielretzl@gmail.com>
         * @version     1.0.0
         * @link        http://yawk.io
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
         * get all files from archive backup folder into array
         * @author      Daniel Retzl <danielretzl@gmail.com>
         * @version     1.0.0
         * @link        http://yawk.io
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

        public function runDatabaseBackup($db)
        {
            // include backup-database class
            require_once 'backup-mysqlBackup.php';
            // create new database backup object
            $this->mysqlBackup = new \YAWK\BACKUP\DATABASE\mysqlBackup($this->backupSettings);
            // initialize database backup

            if ($this->mysqlBackup->initMysqlBackup($db, $this->overwriteBackup, $this->zipBackup) === true)
            {   // database backup successful
                \YAWK\sys::setSyslog($db, 50, 3, "database backup created successfully", 0, 0, 0, 0);
                return true;
            }
            else
            {   // database backup failed
                \YAWK\sys::setSyslog($db, 52, 2, "failed to create database backup", 0, 0, 0, 0);
                return false;
            }
        }

    }
}