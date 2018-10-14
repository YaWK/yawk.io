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
        public $fileBackup;
        /** @var string path, where the backup will be stored */
        public $targetFolder = '../system/backup/current/';
        /** @var string source folder to backup */
        public $sourceFolder = '';
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
        /** @var string archive backup file */
        public $archiveBackupFile = '';
        /** @var string new archive file */
        public $archiveBackupNewFile = '';
        /** @var string upload folder */
        public $downloadFolder = '../system/backup/download/';
        /** @var string tmp folder */
        public $tmpFolder = '../system/backup/tmp/';
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
        /** @var string should .sql backup be stored in tmp folder? */
        public $storeSqlTmp = "false";

        public function __construct()
        {
            if (!is_dir($this->tmpFolder))
            {
                if (!mkdir($this->tmpFolder))
                {
                    return false;
                }
                else
                    {
                        // set writeable to owner + group
                        if (chmod($this->tmpFolder, 0775))
                        {
                            return true;
                        }
                        else
                            {   // unable to set folder properties
                                return false;
                            }
                    }
            }
            else
                {   // all good - do nothing
                    return null;
                }
        }

        /**
         * Init Backup Class (start backup)
         * @author      Daniel Retzl <danielretzl@gmail.com>
         * @version     1.0.0
         * @link        http://yawk.io
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
         * Run a new backup, depending on chosen backup method
         * @author      Daniel Retzl <danielretzl@gmail.com>
         * @version     1.0.0
         * @link        http://yawk.io
         * @param       object $db database object
         * @return      bool true: backup successful | false: backup failed
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

                    // backup database only
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

                    // backup media folder only
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
         * Set backup information file (backup.ini)
         * @param string $targetFolder folder where the ini file should be stored
         * @author      Daniel Retzl <danielretzl@gmail.com>
         * @version     1.0.0
         * @link        http://yawk.io
         * @return bool
         * @annotation  will be added to every .zip file to identify what to do during restore process
         */
        public function setIniFile($db)
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
                // check backup settings array is set
                if (is_array($this->backupSettings))
                {   // ok...
                    return true;
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

        /**
         * Include mysql backup class and run mysqldump backup
         * @author      Daniel Retzl <danielretzl@gmail.com>
         * @version     1.0.0
         * @link        http://yawk.io
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
         * Run File Backup from $sourceFolder
         * @author      Daniel Retzl <danielretzl@gmail.com>
         * @version     1.0.0
         * @link        http://yawk.io
         * @return      bool
         */
        public function runFileBackup($db)
        {
            // include fileBackup class
            require_once 'backup-fileBackup.php';
            // create new file backup object
            $this->fileBackup = new \YAWK\BACKUP\FILES\fileBackup();

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
         * Check if ZipArchive function exists
         * @author      Daniel Retzl <danielretzl@gmail.com>
         * @version     1.0.0
         * @link        http://yawk.io
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
         * Zip a whole folder from $source to $destination.zip
         * @author      Daniel Retzl <danielretzl@gmail.com>
         * @version     1.0.0
         * @link        http://yawk.io
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

                // this 'hack' may not work in all browsers (untested in safari)

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
    }
}