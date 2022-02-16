<?php
namespace YAWK\BACKUP\DATABASE
{

    use Exception;

    /**
     * @details <b>YaWK Backup Component: Database Class</b>
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
     * @brief This class serves methods to store and retrieve mysql database.
     */
    class mysqlBackup extends \YAWK\BACKUP\backup
    {
        /** @param object mysqldump object */
        public $mysqldump;
        /** @param object zip object */
        public $zip;
        /** @param array mysql config array */
        private $config;
        /** @param string mysql server hostname */
        private $host;
        /** @param string mysql database name */
        private $dbname;
        /** @param string mysql user */
        private $user;
        /** @param string mysql pass */
        private $pass;
        /** @param string mysql prefix */
        private $prefix;
        /** @param string mysql port */
        private $port;
        /** @param string backup mode (include|exclude|all) */
        public $backupMode = 'include';
        /** @param array exclude tables */
        public $excludeTablesArray = array();
        /** @param array include tables */
        public $includeTablesArray = array();
        /** @param array mysqldump settings */
        public $dumpSettings = array();
        /** @param string path, where the backup will be stored */
        public $sqlPath = '../system/backup/current/';
        /** @param string default filename of mysqldump .sql file */
        public $backupSqlFile = 'database-backup.sql';
        /** @param string name of the backup .sql file */
        public $sqlBackup = '';
        /** @param string hash value of .sql file */
        public $hashValue = '';


        /**
         * @brief Initialize this database backup class
         * @param       object $db database object
         * @param       string $overwriteBackup if overwrite backup is allowed or not "true" | "false"
         * @param       string $zipBackup if backup should be zipped or not "true" | "false"
         * @param       string $storeSqlTmp if backup should be stored in tmp/database "true" | "false"
         * @return      bool
         */
        public function initMysqlBackup($db, $overwriteBackup, $zipBackup, $storeSqlTmp)
        {
            // if overwrite backup is true
            $this->overwriteBackup = $overwriteBackup;
            // zip true|false
            $this->zipBackup = $zipBackup;
            // store .sql in tmp folder true|false
            $this->storeSqlTmp = $storeSqlTmp;

            // check if .sql file should be stored in tmp folder
            if (isset($this->storeSqlTmp) && ($this->storeSqlTmp == "true"))
            {   // if so, do not zip
                $this->zipBackup = "false";
            }

            // start database backup
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
         * @brief Set mysqldump settings
         * @return      array $this->dumpSettings
         * @details  mysqldump settings eg. include or exclude tables from database
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
         * @brief Exclude tables from backup
         * @param       array $excludeTables array
         * @return      array $this->dumpSettings
         * @details     awaits an array with all tables that should be excluded
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
         * @brief Include only this tables into backup
         * @param       array $includeTables array
         * @return      array $this->dumpSettings
         * @details     awaits an array with all tables that should be included
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
         * @brief Get current database config
         * @details  Get mysql configuration and set settings as private properties
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
         * @brief Include mysqldump-php and create new dump object
         * @return      bool true|false
         * @throws      Exception
         * @link        http://yawk.io
         * @details     create new $this->mysqldump object
         * @author      Daniel Retzl <danielretzl@gmail.com>
         * @version     1.0.0
         */
        public function includeMysqldumpClass($db)
        {
            // check if mysqldump class is there
            if (is_file('../system/engines/mysqldump/Mysqldump.php'))
            {
                // ok, include class
                require_once('../system/engines/mysqldump/Mysqldump.php');

                // check if database tables form is set
                if (isset($_POST['database']) && (!empty($_POST['database'])))
                {
                    // walk through database tables array
                    foreach ($_POST['database'] as $table)
                    {
                        // store table in array
                        $this->includeTablesArray[] = $table;
                    }

                    // set tables to include
                    $this->dumpSettings = $this->includeTables($this->includeTablesArray);
                }
                else
                    {   // set default settings (dump all)
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
         * @brief Check if .sql backup file exists
         * @details     return bool if $this->sqlBackup exists
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
         * @brief Write backup.ini file (used by backup restore methods)
         * @details     write all relevant backup information into this file
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
            $this->backupSettings['TABLES'] = '';
            foreach ($this->dumpSettings['include-tables'] as $table)
            {
                $this->backupSettings['TABLES'] .= $table.",";
            }
            return $this->backupSettings;
        }

        /**
         * @brief get hash value from .sql backup file
         * @param $db
         * @return bool|string
         */
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
         * @brief Start mysqldump and check if .sql file exists. Zip it afterwards if enabled.
         * @details     return bool if $this->sqlBackup exists
         * @return      bool true|false
         */
        public function doSqlBackup($db)
        {

            // check if .sql file should be stored in tmp folder...
            if (isset($this->storeSqlTmp) && ($this->storeSqlTmp == "true"))
            {   // check if subdir database exists
                if (is_writeable($this->tmpFolder))
                {   // check if tmp subdir (database) exists...
                    if (!is_dir($this->tmpFolder."database"))
                    {   // if not, create it
                        mkdir($this->tmpFolder."database");
                    }
                    // set sql path to temp folder
                    $this->sqlPath = $this->tmpFolder."database/";
                    // set whole sql backup file path + filename
                    $this->sqlBackup = $this->sqlPath.$this->backupSqlFile;
                }
                else
                    {
                        \YAWK\sys::setSyslog($db, 51, 1, "failed to create database backup: $this->tmpFolder is not writeable", 0, 0, 0, 0);
                        return false;
                    }
            }

            // check if .sql path is writeable
            if (is_writeable($this->sqlPath))
            {
                // ok then...
                try
                {   // try to start backup
                    $this->mysqldump->start($this->sqlBackup, $this->dumpSettings);
                }
                // on fail: catch error
                catch (Exception $e)
                {
                    // output mysqldump error
                    \YAWK\sys::setSyslog($db, 52, 2, "".$e->getMessage()."", 0, 0, 0, 0);
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
                            \YAWK\sys::setSyslog($db, 49, 0, "created database backup $this->sqlBackup", 0, 0, 0, 0);
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
         * @brief ZIP Archive method generates a zip archive from .sql file
         * @param       string $sqlBackup relative path + filename to the .sql backup file
         * @details     zip the .sql file and return bool if zip archive exists
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
         * @brief  Start and manage mysql backup routine.
         * <p>First of all, mysqldump class will be included. Then, a check runs if a .sql backup file exists.
         * if so, check if overwrite backup is allowed. If this is true, doSqlBackup method will be called.
         * (This function does the real job).</p>
         * @details     return bool if zip archive exists
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

                    // SET PATH WHERE .SQL FILE SHOULD BE STORED
                    $this->sqlPath = $this->archiveBackupSubFolder;
                    // set archive backup subfolder
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
                    // \YAWK\sys::setSyslog($db, 50, 3, "created database backup", 0, 0, 0, 0);
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