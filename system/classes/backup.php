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
        /** @var bool overwrite backup files? */
        public $overwriteBackup = true;
        /** @var bool zip backup if possible */
        public $zipBackup = true;
        /** @var bool remove files after zip is complete */
        public $removeAfterZip = true;


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
                    {
                        // include backup-database class
                        require_once 'backup-database.php';
                        // create new database backup object
                        $this->mysqlBackup = new \YAWK\BACKUP\MYSQL\database($this->backupSettings);
                        // initialize database backup
                        if ($this->mysqlBackup->init($db) === true)
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
                    break;

                    // backup files only
                    case "files":
                    {
                        // files + folder only
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
        public function setIniFile($targetFolder)
        {   // check if target folder is set
            if (isset($targetFolder) && (!empty($targetFolder)))
            {   // set target folder property
                $this->targetFolder = $targetFolder;
            }
            else
                {   // target folder param not sent, set default value:
                    $this->targetFolder = '../system/backup/current/';
                }

            // check if target folder is writeable
            if (is_writeable($this->targetFolder))
            {   // set configfile (string that includes path + filename)
                $this->configFile = $this->targetFolder.$this->configFilename;
                // check if ini file was written
                if (\YAWK\sys::writeIniFile($this->backupSettings, $this->configFile) === true)
                {   // set syslog: config file written successfully
                    echo "$this->configFile written!<br>";
                    // check if config file is there
                    if (is_file($this->configFile))
                    {   // config file found!
                        return true;
                    }
                    else
                        {   // config file not found
                            return false;
                        }
                }
                else
                    {   // unable to write config file
                        echo "$this->configFile not written!<br>";
                        return false;
                    }
            }
            else
                {   // target folder not writeable
                    echo "$this->targetFolder is not writeable!";
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
        public function parseIniFile($iniFile)
        {   // set config file property
            $this->configFile = $iniFile;
            // check if ini file is there
            if (is_file($this->configFile))
            {
                // update backup settings from ini file
                $this->backupSettings = parse_ini_file($this->configFile);
                echo "ini file parse successful!";
                return true;
            }
            else
                {   // no ini file found!
                    // set syslog entry
                    echo "no ini file found!";
                    return false;
                }
        }

    }
}