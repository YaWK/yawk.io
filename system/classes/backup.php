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
        /** @var string filename of the config file (default: config.nfo) */
        public $configFilename = "backup.ini";
        /** @var string config file, including path */
        public $configFile = '';
        /** @var array backup settings */
        public $backupSettings = array();
        /** @var bool overwrite backup files? */
        public $backupOverwrite = true;


        /**
         * Init Backup Class (start backup)
         * @author      Daniel Retzl <danielretzl@gmail.com>
         * @version     1.0.0
         * @link        http://yawk.io
         */
        public function init()
        {   // run backup system
            $this->run();
        }

        /**
         * this class starts a new backup, depending on chosen backup method
         * @author      Daniel Retzl <danielretzl@gmail.com>
         * @version     1.0.0
         * @link        http://yawk.io
         */
        public function run()
        {
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
                        if ($this->mysqlBackup->init() === true)
                        {   // database backup successful
                            echo "<b class=\"text-success\">Database Backup success</b>";
                        }
                        else
                            {   // database backup failed
                                echo "<b class=\"text-danger\">Database Backup failed</b>";
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

        public function setIniFile($targetFolder)
        {
            if (isset($targetFolder) && (!empty($targetFolder)))
            {
                $this->targetFolder = $targetFolder;
            }
            else
                {
                    $this->targetFolder = '../system/backup/current/';
                }

            if (is_writeable($this->targetFolder))
            {
                $this->configFile = $this->targetFolder.$this->configFilename;
                if (\YAWK\sys::writeIniFile($this->backupSettings, $this->configFile) === true)
                {
                    echo "$this->configFile written!<br>";

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
                    {   //
                        echo "$this->configFile not written!<br>";
                        return false;
                    }
            }
            else
                {
                    echo "$this->targetFolder is not writeable!";
                    return false;
                }
        }

        public function getIniFile($iniFile)
        {
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
                    echo "no ini file found!";
                    return false;
                }
        }

    }
}