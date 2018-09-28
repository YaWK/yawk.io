<?php
namespace YAWK\BACKUP\MYSQL
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
    class database extends \YAWK\BACKUP\backup
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
        public $backupMode = 'exclude';
        /** @var array exclude tables */
        public $excludeTablesArray = array();
        /** @var array include tables */
        public $includeTablesArray = array();
        /** @var array mysqldump settings */
        public $dumpSettings = array();
        /** @var string path, where the backup will be stored */
        public $sqlPath = '../system/backup/database/';
        /** @var string default filename of backup.sql file */
        public $backupSqlFile = 'backup.sql';
        /** @var string name of the backup .sql file */
        public $sqlBackup = '';
        /** @var bool zip backup if possible */
        public $zipBackup = true;


        /**
         * Initialize this database backup class
         * @author      Daniel Retzl <danielretzl@gmail.com>
         * @version     1.0.0
         * @link        http://yawk.io
         */
        public function init()
        {
            // start mysqlbackup
            if ($this->startMysqlBackup() === true)
            {   // syslog: backup done
                echo "startMysqlBackup done!<br>";
                return true;
            }
            else
            {   // syslog: backup failed
                echo "startMysqlBackup failed!<br>";
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
        {   // generate dump settings array
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
            // set single vars (because mysqldump requires it that way)
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
        public function includeMysqldumpClass()
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
                return false;
            }
        }


        /**
         * Check if overwrite backup is allowed
         * @author      Daniel Retzl <danielretzl@gmail.com>
         * @version     1.0.0
         * @link        http://yawk.io
         * @annotation  return if $this->backupOverwrite is true or false
         * @return      bool true|false
         */
        public function isOverwriteAllowed()
        {
            // check if overwrite is allowed
            if ($this->backupOverwrite === true)
            {
                // overwrite allowed
                return true;
            }
            else
            {
                // overwrite not allowed
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
         * Start mysqldump and check if .sql file exists. Zip it afterwards if enabled.
         * @author      Daniel Retzl <danielretzl@gmail.com>
         * @version     1.0.0
         * @link        http://yawk.io
         * @annotation  return bool if $this->sqlBackup exists
         * @return      bool true|false
         */
        public function doSqlBackup()
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
                echo 'mysqldump-php error: ' . $e->getMessage();
            }
            // check if file exists
            if ($this->sqlFileExists())
            {
                // ok, backup done
                // check if .sql file should be zipped
                if ($this->zipBackup === true)
                {
                    // generate zip archive
                    if ($this->generateZipArchive($this->sqlBackup) === true)
                    {
                        // zip archive created
                        return true;
                    }
                    else
                        {   // failed to create zip archive
                            return false;
                        }
                }
                else
                    {   // .sql file exists, no zip needed
                        return true;
                    }
            }
            else
            {   // .sql file does not exist - backup failed?
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
        public function generateZipArchive($sqlBackup)
        {
            if ($this->zipBackup === true)
            {   // check if ZipArchive class is available
                if (class_exists('ZipArchive'))
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

                    // open a new zip archive
                    if ($zip->open($filename, \ZipArchive::CREATE)!== TRUE)
                    {   // unable to open new zip archive
                        exit("cannot open $filename\n");
                    }

                    // add file to zip archive
                    $zip->addFile($this->sqlBackup,'backup.sql');
                    // output some stats...
                    // echo "numfiles: " . $zip->numFiles . "\n";
                    // echo "status:" . $zip->status . "\n";
                    // ok, close zip file
                    $zip->close();

                    // check if zip file exists
                    if (is_file($filename))
                    {   // zip file created
                        echo "ZIP file erstellt!<br>";
                        return true;
                    }
                    else
                    {   // zip file not created
                        echo "ZIP file nicht erstellt<br>";
                        return false;
                    }
                }
                else
                {   // ZipArchive class not available
                    echo "ZIP class not found!<br>";
                    return false;
                }
            }
            else
                {   // zip not enabled due settings
                    echo "ZIP not enabled! (zip: $this->zipBackup)";
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
        public function startMysqlBackup()
        {
            // include mysqldump class
            $this->includeMysqldumpClass();
            // create folder and file string
            if ($this->sqlFileExists() === true)
            {   // check if backup overwrite is allowed
                if ($this->isOverwriteAllowed() === true)
                {   // do database backup
                    if ($this->doSqlBackup() === true)
                    {   // ok, backup done
                        echo "backup overwritten<br>";
                        return true;
                    }
                    else
                    {   // backup failed - unable to overwrite - check chmod settings!
                        echo "backup error on overwrite<br>";
                        return false;
                    }
                }
                else
                {   // overwrite not allowed!
                    echo "backup not written because overwrite is false<br>";
                    return false;
                    // return false;
                }
            }
            else
            {   // .sql file does not exist - do database backup
                if ($this->doSqlBackup() === true)
                {   // ok, backup done!
                    return true;
                }
                else
                {   // backup failed!
                    return false;
                }
            }
        }
    }
}