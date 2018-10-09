<?php
namespace YAWK\BACKUP\DATABASE
{
    /**
     * <b>YaWK Backup Component: Database Class</b>
     *
     * <p>Methods to backup and restore all or partial data from mysql database.
     * This class makes use of ifsnop\mysqldump-php by diego torres. His work make
     * possible to ensure that this backup component works with all typical webhosting
     * configurations. (Especially those who do not allow shell or forbid the use of
     * mysqldump.) This class should work in mostly any situation.
     * Thank you, Diego Torres!</p>
     *
     * @package    YAWK
     * @author     Daniel Retzl <danielretzl@gmail.com>
     * @copyright  2018 Daniel Retzl
     * @license    https://opensource.org/licenses/MIT
     * @version    1.0.0
     * @link       http://yawk.io
     * @annotation This class serves methods to store and retrieve mysql database.
     */
    class mysqlBackup extends \YAWK\BACKUP\backup
    {
        /** @var object mysqldump object */
        public $mysqldump;
        /** @var object zip object */
        public $zip;
        /** @var array mysql config array */
        private $config;
        /** @var string mysql server hostname */
        private $host;
        /** @var string mysql database name */
        private $dbname;
        /** @var string mysql user */
        private $user;
        /** @var string mysql pass */
        private $pass;
        /** @var string mysql prefix */
        private $prefix;
        /** @var string mysql port */
        private $port;
        /** @var string backup mode (include|exclude|all) */
        public $backupMode = 'all';
        /** @var array exclude tables */
        public $excludeTablesArray = array();
        /** @var array include tables */
        public $includeTablesArray = array();
        /** @var array mysqldump settings */
        public $dumpSettings = array();
        /** @var string path, where the backup will be stored */
        public $sqlPath = '../system/backup/current/';
        /** @var string default filename of mysqldump .sql file */
        public $backupSqlFile = 'backup-database.sql';
        /** @var string name of the backup .sql file */
        public $sqlBackup = '';
        /** @var string hash value of .sql file */
        public $hashValue = '';


        /**
         * Initialize this database backup class
         * @author      Daniel Retzl <danielretzl@gmail.com>
         * @version     1.0.0
         * @link        http://yawk.io
         * @param       object $db database object
         * @param       string $overwriteBackup if overwrite backup is allowed or not "true" | "false"
         * @param       string $zipBackup if backup should be zipped or not "true" | "false"
         * @return      bool
         */
        public function initMysqlBackup($db, $overwriteBackup, $zipBackup)
        {
            // start mysqlbackup
            $this->overwriteBackup = $overwriteBackup;
            $this->zipBackup = $zipBackup;

            if ($this->startMysqlBackup($db) === true)
            {   // mysql backup done
                return true;
            }
            else
            {   // mysql backup failed
                return false;
            }
        }

        /**
         * Set mysqldump settings
         * @author      Daniel Retzl <danielretzl@gmail.com>
         * @version     1.0.0
         * @link        http://yawk.io
         * @return      array $this->dumpSettings
         * @annotation mysqldump settings eg. include or exclude tables from database
         */
        public function setDumpSettings()
        {
            // generate dump settings array
            $this->dumpSettings = array(
                'include-tables'
                => array(),
                'exclude-tables'
                => array());
            return $this->dumpSettings;
        }

        /**
         * Exclude tables from backup
         * @author      Daniel Retzl <danielretzl@gmail.com>
         * @version     1.0.0
         * @link        http://yawk.io
         * @param       array $excludeTables array
         * @return      array $this->dumpSettings
         * @annotation  awaits an array with all tables that should be excluded
         */
        public function excludeTables($excludeTables)
        {   // check if exclude tables are set
            if (isset($excludeTables) && (is_array($excludeTables) && (!empty($excludeTables))))
            {
                // set excludeTables array
                $this->excludeTablesArray = $excludeTables;

                // walk through exclude tables array
                foreach ($this->excludeTablesArray AS $exclude => $table)
                {   // add exclude table to array
                    $this->dumpSettings['exclude-tables'][] = $table;
                }
            }

            // check if dump settings array is set and not empty
            if (isset($this->dumpSettings['exclude-tables']) && (is_array($this->dumpSettings['exclude-tables']) && (!empty($this->dumpSettings['exclude-tables']))))
            {   // return dump settings array
                return $this->dumpSettings;
            }
            else
                {   // no tables set for inclusion - return empty array
                    return $this->dumpSettings['exclude-tables'] = array();
                }
        }

        /**
         * Include only this tables into backup
         * @author      Daniel Retzl <danielretzl@gmail.com>
         * @version     1.0.0
         * @link        http://yawk.io
         * @param       array $includeTables array
         * @return      array $this->dumpSettings
         * @annotation  awaits an array with all tables that should be included
         */
        public function includeTables($includeTables)
        {   // check if include tables are set
            if (isset($includeTables) && (is_array($includeTables) && (!empty($includeTables))))
            {
                // set includeTables array
                $this->includeTablesArray = $includeTables;

                // walk through include tables array
                foreach ($this->includeTablesArray AS $include => $table)
                {   // add include table to array
                    $this->dumpSettings['include-tables'][] = $table;
                }
            }

            // check if dump settings array is set and not empty
            if (isset($this->dumpSettings['include-tables']) && (is_array($this->dumpSettings['include-tables']) && (!empty($this->dumpSettings['include-tables']))))
            {   // return dump settings array
                return $this->dumpSettings;
            }
            else
            {   // no tables set for inclusion - return empty array
                return $this->dumpSettings['include-tables'] = array();
            }
        }

        /**
         * Get current database config
         * @author      Daniel Retzl <danielretzl@gmail.com>
         * @version     1.0.0
         * @link        http://yawk.io
         * @annotation Get mysql configuration and set settings as private properties
         */
        public function getDatabaseConfig()
        {
            // get database configuration
            require ("../system/classes/dbconfig.php");
            // set configuration vars for mysqldump-php
            $this->host = $this->config['server'];
            $this->user = $this->config['username'];
            $this->pass = $this->config['password'];
            $this->dbname = $this->config['dbname'];
            $this->prefix = $this->config['prefix'];
            $this->port = $this->config['port'];
        }

        /**
         * Include mysqldump-php and create new dump object
         * @author      Daniel Retzl <danielretzl@gmail.com>
         * @version     1.0.0
         * @link        http://yawk.io
         * @annotation  create new $this->mysqldump object
         * @return      bool true|false
         */
        public function includeMysqldumpClass($db)
        {
            // check if mysqldump class is there
            if (is_file('../system/engines/mysqldump/Mysqldump.php'))
            {
                // ok, include class
                require_once('../system/engines/mysqldump/Mysqldump.php');

                // backup mode sets if tables should be included or excluded (otherwise backup the whole database).
                if (isset($this->backupMode))
                {   // check and react to selected backup mode
                    switch ($this->backupMode)
                    {   // if only some tables should be included
                        case "include":
                        {
                            // set include tables array
                            $this->includeTablesArray = array('cms_assets', 'cms_assets_types');
                            // set tables for inclusion
                            $this->dumpSettings = $this->includeTables($this->includeTablesArray);
                        }
                        break;

                        // if some tables should be excluded
                        case "exclude":
                        {
                            // set exclude tables array
                            $this->excludeTablesArray = array('cms_syslog', 'cms_template_settings', 'cms_stats', 'cms_widget_defaults', 'cms_assets', 'cms_assets_types');
                            // set tables for exclusion
                            $this->dumpSettings = $this->excludeTables($this->excludeTablesArray);
                        }
                        break;

                        // all tables should be backuped
                        case "all":
                        {   // set empty dump settings - (dump all)
                            $this->setDumpSettings();
                        }
                        break;

                        // on any other value
                        default:
                        {   // set default dump settings - (dump all)
                            $this->setDumpSettings();
                        }
                        break;
                    }
                }
                else
                    {
                        // set empty dump settings - (dump all)
                        $this->setDumpSettings();
                    }

                // load database config into this object
                $this->getDatabaseConfig();

                // create new mysqldump object
                $this->mysqldump = new \Ifsnop\Mysqldump\Mysqldump("mysql:host=$this->host;dbname=$this->dbname", $this->user, $this->pass, $this->dumpSettings);
                return true;
            }
            else
            {   // unable to include class
                \YAWK\sys::setSyslog($db, 52, 2, "unable to backup: failed to include mysqldump class", 0, 0, 0, 0);
                return false;
            }
        }

        /**
         * Check if .sql backup file exists
         * @author      Daniel Retzl <danielretzl@gmail.com>
         * @version     1.0.0
         * @link        http://yawk.io
         * @annotation  return bool if $this->sqlBackup exists
         * @return      bool true|false
         */
        public function sqlFileExists()
        {
            // set path + filename (store as string in $this->sqlBackup)
            $this->sqlBackup = $this->sqlPath.$this->backupSqlFile;// .sql backup file exists
            // check if .sql backup file is already there
            if (is_file($this->sqlBackup))
            {
                // build sqlBackup string
                return true;
            }
            else
            {
                // .sql backup file does not exist
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
            $this->backupSettings['FILE'] = $this->backupSqlFile;
            $this->backupSettings['HASH'] = $this->getHashValue($db);
            $this->backupSettings['PATH'] = $this->sqlPath;
            $this->backupSettings['SOURCE_FOLDER'] = $this->sqlBackup;
            $this->backupSettings['OVERWRITE_ALLOWED'] = $this->overwriteBackup;
            $this->backupSettings['USER_ID'] = $_SESSION['uid'];
            return $this->backupSettings;
        }

        public function getHashValue($db)
        {
            // check if sql backup file is accessable
            if (is_file($this->sqlBackup))
            {   // generate hash value
                return $this->hashValue = hash_file('md5', $this->sqlBackup);
            }
            else
                {   // sql backup file not found
                    // unable to generate hash value
                    \YAWK\sys::setSyslog($db, 52, 2, "failed to generate hash value - $this->sqlBackup not accessable", 0, 0, 0, 0);
                    return false;
                }
        }

        /**
         * Start mysqldump and check if .sql file exists. Zip it afterwards if enabled.
         * @author      Daniel Retzl <danielretzl@gmail.com>
         * @version     1.0.0
         * @link        http://yawk.io
         * @annotation  return bool if $this->sqlBackup exists
         * @return      bool true|false
         */
        public function doSqlBackup($db)
        {
            if (is_writeable($this->sqlPath))
            {
                // try database backup
                try
                {   // try to start backup
                    $this->mysqldump->start($this->sqlBackup, $this->dumpSettings);
                }
                // catch error
                catch (\Exception $e)
                {
                    // output mysqldump error
                    \YAWK\sys::setSyslog($db, 52, 2, "failed to create database backup - mysqldump failed with error: ".$e->getMessage()."", 0, 0, 0, 0);
                    // echo 'mysqldump-php error: ' . $e->getMessage();
                }
                // check if file exists
                if ($this->sqlFileExists())
                {
                    // ok, backup done
                    // add ini file
                    $this->backupSettings = $this->setBackupSettings($db);
                    if ($this->setIniFile($db) === true)
                    {
                        // backup ini file written
                    }
                    else
                        {
                            // set syslog entry: ini file not written
                            \YAWK\sys::setSyslog($db, 51, 1, "failed to write $this->configFile", 0, 0, 0, 0);
                        }

                    // check if .sql file should be zipped
                    if ($this->zipBackup == "true")
                    {
                        // generate zip archive
                        if ($this->generateZipArchive($db, $this->sqlBackup) === true)
                        {
                            // zip archive created
                            \YAWK\sys::setSyslog($db, 50, 0, "database .zip archive created", 0, 0, 0, 0);
                            return true;
                        }
                        else
                            {   // failed to create zip archive
                                \YAWK\sys::setSyslog($db, 51, 1, "failed to create database zip archive", 0, 0, 0, 0);
                                return false;
                            }
                    }
                    else
                        {   // zip backup diabled, no zip needed
                            return true;
                        }
                }
                else
                {   // .sql file does not exist - backup failed?
                    return false;
                }
            }
            else
                {
                    \YAWK\sys::setSyslog($db, 51, 1, "failed to create database backup: $this->sqlPath is not writeable", 0, 0, 0, 0);
                    return false;
                }
        }

        /**
         * ZIP Archive method generates a zip archive from .sql file
         * @author      Daniel Retzl <danielretzl@gmail.com>
         * @version     1.0.0
         * @link        http://yawk.io
         * @param       string $sqlBackup relative path + filename to the .sql backup file
         * @annotation  zip the .sql file and return bool if zip archive exists
         * @return      bool true|false
         */
        public function generateZipArchive($db, $sqlBackup)
        {
            if ($this->zipBackup == "true")
            {   // check if ZipArchive class is available
                if ($this->checkZipFunction() == true)
                {
                    // ok, create new zip object
                    $zip = new \ZipArchive();

                    // get sql backup filename
                    if (isset($sqlBackup) && (!empty($sqlBackup) && (is_string($sqlBackup))))
                    {   // set this obj property
                        $this->sqlBackup = $sqlBackup;
                    }

                    // generate zip filename
                    $filename = $this->sqlBackup.".zip";

                    // open new zip archive
                    if ($zip->open($filename, \ZipArchive::CREATE) !== TRUE)
                    {   // failed to create new zip archive
                        \YAWK\sys::setSyslog($db, 51, 2, "failed to create new zip archive $filename", 0, 0, 0, 0);
                        return false;
                    }

                    // add .sql file to zip archive
                    $zip->addFile($this->sqlBackup,$this->backupSqlFile);

                    // check if there is a backup.ini / config file
                    if (is_file($this->sqlPath.$this->configFilename))
                    {   // add backup.ini config file to zip archive
                        $zip->addFile($this->sqlPath.$this->configFilename, $this->configFilename);
                    }
                    else
                        {   // backup config ini file not found
                            \YAWK\sys::setSyslog($db, 51, 2, "failed to add $this->configFilename to archive $filename", 0, 0, 0, 0);
                        }
                    // echo "numfiles: " . $zip->numFiles . "\n";
                    // echo "status:" . $zip->status . "\n";
                    // ok, close zip file
                    $zip->close();

                    // check if zip file exists
                    if (is_file($filename))
                    {
                        // zip file created
                        if ($this->removeAfterZip == "true")
                        {   // remove files
                            if (unlink ($this->sqlPath.$this->backupSqlFile)
                            && (unlink ($this->sqlPath.$this->configFilename)))
                            {
                                return true;
                            }
                            else
                                {   // unable to delete backup files after zipping
                                    \YAWK\sys::setSyslog($db, 51, 1, "failed to delete backup files after adding .zip archive $filename", 0, 0, 0, 0);
                                    return true;
                                }
                        }
                        return true;
                    }
                    else
                    {   // zip file not created
                        \YAWK\sys::setSyslog($db, 51, 1, "failed to create .zip file: $filename", 0, 0, 0, 0);
                        return false;
                    }
                }
                else
                {   // ZipArchive class not available
                    \YAWK\sys::setSyslog($db, 51, 1, "failed create .zip archive - PHP ZIP class not available. Ask your web hosting provider about that", 0, 0, 0, 0);
                    return false;
                }
            }
            else
                {   // zip not enabled due settings
                    return false;
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
        public function startMysqlBackup($db)
        {
            // include mysqldump class
            $this->includeMysqldumpClass($db);

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
                        if (mkdir($this->archiveBackupSubFolder))
                        {   // all good, new archive subfolder created
                            // set syslog entry: dir created
                            \YAWK\sys::setSyslog($db, 50, 0, "archive directory created: $this->sqlPath", 0, 0, 0, 0);
                        }
                        else
                        {   // failed to create new archive subfolder
                            // set syslog entry: failed
                            \YAWK\sys::setSyslog($db, 52, 0, "failed to create archive directory: $this->sqlPath", 0, 0, 0, 0);
                        }
                    }
                    // check if existing folder was selected by user
                    else if (isset($_POST['selectFolder']) && (!empty($_POST['selectFolder'])))
                    {   // set archive sub foder path
                        $this->archiveBackupSubFolder = $this->archiveBackupFolder.$_POST['selectFolder']."/";
                    }

                    $this->sqlPath = $this->archiveBackupSubFolder;
                    $this->targetFolder = $this->archiveBackupSubFolder;
                }
            }

            // check if a backup exists
            if ($this->sqlFileExists() === true)
            {
                // do database backup
                if ($this->doSqlBackup($db) === true)
                {   // ok, backup done
                    \YAWK\sys::setSyslog($db, 50, 3, "database backup overwritten", 0, 0, 0, 0);
                    return true;
                }
                else
                {   // backup failed - unable to overwrite - check chmod settings!
                    \YAWK\sys::setSyslog($db, 52, 2, "failed to overwrite database backup", 0, 0, 0, 0);
                    return false;
                }
            }
            else
            {   // .sql file does not exist - do database backup
                if ($this->doSqlBackup($db) === true)
                {   // ok, backup done!
                    \YAWK\sys::setSyslog($db, 50, 3, "created database backup", 0, 0, 0, 0);
                    return true;
                }
                else
                {   // backup failed!
                    \YAWK\sys::setSyslog($db, 52, 2, "failed to write database backup", 0, 0, 0, 0);
                    return false;
                }
            }
        }
    }
}