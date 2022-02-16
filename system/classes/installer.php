<?php
namespace YAWK {

    /**
     * @details <b>installer Class</b>
     * @brief This class handles the setup / installation process
     */
    class installer
    {
        /** * @param int $step holds the installation step variable */
        public $step;
        /** * @param string $url URL of that website */
        public $url;
        /** * @param string $rootPath the root path where yawk is installed*/
        public $rootPath;
        /** * @param string $configFile the path and filename to install.ini which helds the setup configuration */
        public $configFile = "system/setup/install.ini";
        /** * @param string $dbConfigPhp the path and filename to dbconfig.php which helds the mysql configuration */
        public $dbConfigPhp = "system/classes/dbconfig.php";
        /** * @param string $sqlFile the path and filename to yawk's core sql database file */
        public $sqlFile = "system/setup/yawk_database.sql";
        /** * @param string $filePointer the path and filename to the sql file's filepointer */
        public $filePointer = "system/setup/yawk_database.sql_filepointer";
        /** * @param string $yawkVersion detected from install.ini */
        public $yawkVersion;
        /** * @param string $version Installer version */
        public $version = "1.0";
        /** * @param bool $phpVersionStatus PHP Version */
        public $phpVersionStatus;
        /** * @param string $phpVersionRequired required PHP version */
        public $phpVersionRequired = "5.1.0";
        /** * @param string $phpCheckIcon php version icon: depending on true or false, check or times */
        public $phpCheckIcon;
        /** * @param string $apacheStatus Apache Version */
        public $apacheStatus;
        /** * @param string $apacheCheckIcon apache version icon: depending on true or false, check or times */
        public $apacheCheckIcon;
        /** * @param string $zlib zlib enalbed? string: true or false */
        public $zlib;
        /** * @param string $zlibCheckIcon zlib icon: depending on true or false, check or times */
        public $zlibCheckIcon;
        /** * @param string $modRewriteStatus is mod_rewrite available? */
        public $modRewriteStatus;
        /** * @param string $modRewriteCheckIcon mod_rewrite icon depending on true or false, check or times */
        public $modRewriteCheckIcon;
        /** * @param string $serverRequirements does the server fulfil requirements? true or false */
        public $serverRequirements;

        /**
         * @brief installer constructor.
         * build and return the html head
         * @author Daniel Retzl <danielretzl@gmail.com>
         * @copyright 2017 Daniel Retzl
         * @license    https://opensource.org/licenses/MIT
         */
        function __construct()
        {
            echo "
<html>
    <head>
        <meta charset=\"utf-8\">
        <meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge\">
        <title>SETUP YaWK | Yet another Web Kit</title>
        <!-- Tell the browser to be responsive to screen width -->
        <meta content=\"width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no\" name=\"viewport\">
        <!-- favicon -->
        <link rel=\"shortcut icon\" type=\"image/x-icon\" href=\"favicon.ico\">
        <!-- Bootstrap 3.3.5 -->
        <link rel=\"stylesheet\" href=\"system/engines/bootstrap3/dist/css/bootstrap.min.css\">
        <!-- Animate CSS -->
        <link rel=\"stylesheet\" href=\"system/engines/animateCSS/animate.min.css\">
        <!-- Font Awesome -->
        <link rel=\"stylesheet\" href=\"system/engines/font-awesome/css/font-awesome.min.css\">
        <!-- Admin LTE -->
        <link rel=\"stylesheet\" href=\"system/engines/AdminLTE/css/AdminLTE.min.css\">
        
        <!-- jQuery 2.1.4 -->
        <script type=\"text/javascript\" src=\"system/engines/jquery/jquery-2.2.3.min.js\"></script>
        
        <!-- jQuery validation plugin -->
        <script type=\"text/javascript\" src=\"system/engines/jquery/jquery.validate.min.js\"></script>
    
        <!-- Notify JS -->
        <script src=\"system/engines/jquery/notify/bootstrap-notify.min.js\"></script>
        
        <!-- pace JS -->
        <script src=\"system/engines/pace/pace.min.js\"></script>
        <link rel=\"stylesheet\" href=\"system/engines/pace/pace-minimal-installer.css\">
                
    </head>
    <body style=\"background-color: #ebebeb;\">
    <div class=\"container-fluid animated fadeIn\">
    <form method=\"POST\">
    ";
        }

        /**
         * @brief Initialize the installer.
         * @details check and set the current / supported language, check if install.ini exists and start setup process
         * @author Daniel Retzl <danielretzl@gmail.com>
         * @copyright 2017 Daniel Retzl
         * @license    https://opensource.org/licenses/MIT
         */
        public function init()
        {
            $_SESSION['SETUP'] = TRUE;
            /* CHECK + SET LANGUAGE */
            // include language class
            $language = '';
            require_once ('system/classes/language.php');
            /* check if language object is set*/
            if (!isset($lang) || (empty($lang)))
            {   // set new language object
                $language = new \YAWK\language();
                // default language if detection not works
                $language->defaultLanguage = "en-EN";
                // set the path to the language file
                $language->pathToFile = "admin/language/";

                // try to get the client language
                if ($language->detectedLanguage = $language->getClientLanguage())
                {   // currentLanguageGlobal is set due call of getClientLanguage
                    if ($language->isSupported($language->currentLanguageGlobal))
                    {
                        // client language is supported, set it
                        $language->currentLanguage = $language->currentLanguageGlobal;
                        $language->setLanguage($language->currentLanguageGlobal);
                    }
                    else
                    {
                        // client language is not supported - set default (eg. en-EN)
                        $language->setDefault($language->defaultLanguage);
                    }
                }
                // if current language is sent via form (POST data)
                if (isset($_POST['currentLanguage']) && (!empty($_POST['currentLanguage'])))
                {   // check if POST language is supported
                    if ($language->isSupported($_POST['currentLanguage']))
                    {
                        // POST language is supported
                        $language->detectedLanguage = $_POST['currentLanguage'];
                        $language->setLanguage($language->detectedLanguage);
                    }
                    else
                    {
                        // POST language is NOT supported - set default (eg. en-EN)
                        $language->currentLanguage = $language->defaultLanguage;
                        $language->setDefault($language->defaultLanguage);
                    }
                }
                // convert language object param to array $lang[] that contains all the language data
                $lang = (array) $language->lang;
            }

            /* INSTALLER SCRIPT */
            // check if system/setup/install.ini file is available
            if (file_exists($this->configFile))
            {
                /* LOAD INSTALLER */
                $this->setup($language, $lang);
            }
            else
                {   // init() failed - INSTALL.INI is not found or not readable
                    require_once('system/classes/alert.php');
                    \YAWK\alert::draw("danger", "$lang[INSTALLER_BROKEN]", "$lang[INSTALLER_BROKEN_SUBTEXT]", "","");
                    die ("$lang[INSTALLER_BROKEN] $lang[INSTALLER_BROKEN_SUBTEXT]");
                }
        }   // ./ end installer init()


        /**
         * @brief Start the setup process.
         * @details include core functions and check server requirements. handles the installation steps
         * @param object $language language object
         * @param array $lang language data array
         * @author Daniel Retzl <danielretzl@gmail.com>
         * @copyright 2017 Daniel Retzl
         * @license    https://opensource.org/licenses/MIT
         */
        public function setup($language, $lang)
        {   /* CHECK + SET LANGUAGE */

            // include other core classes
            require_once('system/classes/settings.php');
            require_once('system/classes/alert.php');
            require_once('system/classes/sys.php');
            require_once('system/classes/user.php');

            // run server checks and save status variables
            self::checkServerRequirements();

            // get install data into array
            if ($setup = parse_ini_file($this->configFile, FALSE))
            {
                $this->yawkVersion = $setup['VERSION']; // get the yawk version
                // if INSTALL is set to true
                if ($setup['INSTALL'] === "true")
                {   // if no step variable is set, setup run for the first time
                    if (!isset($_POST['step']) || (empty($_POST['step'])))
                    {   // STEP 1 -- LANGUAGE SELECTION
                        $_POST['step'] = 1;
                        // STEP 1 - language selector
                        $this->step1($language, $lang);
                    }
                    // STEP 1 - Language Data
                    if (isset($_POST['step']) && $_POST['step'] === "1")
                    {   // in this step, the user sets the language
                        $this->step1($language, $lang);
                    }

                    // STEP 2 - MySQL data
                    if (isset($_POST['step']) && $_POST['step'] === "2")
                    {   // in this step, the user set the mysql configuration
                        $this->step2($setup, $language, $lang);
                    }

                    // STEP 3 - common website and project data
                    if (isset($_POST['step']) && $_POST['step'] === "3")
                    {   // common project data like url, title and description
                        $this->step3($setup, $language, $lang);
                    }

                    // STEP 4 - admin user data
                    if (isset($_POST['step']) && ($_POST['step'] === "4"))
                    {   // set admin user data
                        $this->step4($setup, $language, $lang);
                    }

                    // STEP 5 - finish & login
                    if (isset($_POST['step']) && ($_POST['step'] === "5"))
                    {   // finish and login
                        $this->step5($setup, $language, $lang);
                    }
                }
            }
                else
                    {
                        \YAWK\alert::draw("danger", "$lang[INSTALLER_BROKEN]", "$lang[INSTALLER_BROKEN_SUBTEXT]", "","");
                        die ("$lang[INSTALLER_BROKEN] $lang[INSTALLER_BROKEN_SUBTEXT]");
                    }
                    // prevent display anything else than the single steps
                    exit;
        }


        /** @brief step 1 - SELECT LANGUAGE
         * @param object $language language object
         * @param array $lang language data array
         * @author Daniel Retzl <danielretzl@gmail.com>
         * @license    https://opensource.org/licenses/MIT
         */
        public function step1($language, $lang)
        {
            $this->step = 1;
            echo "<div class=\"row\">
                        <div class=\"jumbotron\">
                            <div class=\"col-md-4 text-justify\">
                            
                            </div>
                            <div class=\"col-md-4\">
                                <h2>YaWK <small>$lang[INSTALLATION]</small></h2>
                                <h4>$lang[STEP] $_POST[step]/5 <small>$lang[PREPARATION]</small></h4>
                                <hr>
                                <label for=\"currentLanguage\">$lang[LANG_LABEL]</label>
                                    <select class=\"form-control\" id=\"currentLanguage\" name=\"currentLanguage\">
                                        ".$this->getLanguageSelectOptions($language, $lang)."
                                    </select>
                                <br>
                                <button class=\"btn btn-success pull-right\" type=\"submit\"><small>$_POST[step]/5</small> &nbsp;$lang[NEXT_STEP] &nbsp;<i class=\"fa fa-arrow-right\"></i></button>
                                <input type=\"hidden\" name=\"step\" value=\"2\">
                            </div>
                            <div class=\"col-md-4 text-justify\">
                            
                            </div>
                        </div>
                  </div>";
        }

        /** @brief step 2 - DB DATA + SERVER REQUIREMENTS
         * @param array $setup installation settings
         * @param object $language language object
         * @param array $lang language data array
         * @author Daniel Retzl <danielretzl@gmail.com>
         * @license    https://opensource.org/licenses/MIT
         */
        public function step2($setup, $language, $lang)
        {
            $this->step = 2;
            echo "
            <!-- JS to ensure loading state on save button -->
            <script type=\"text/javascript\">
                $(document).ready(function() {
                    // store savebutton in var
                    var savebutton = ('#savebutton');
                    // check if user clicked on save button
                    $(savebutton).click(function() {
                        $(savebutton).removeClass('btn btn-success').html('<small>2/5</small> $lang[IMPORTING_DB] &nbsp;<i class=\"fa fa-spinner fa-spin fa-fw\"></i>').addClass('btn btn-warning disabled');
                    });
                });
            </script>";
            echo "
                    <div class=\"row\">
                        <div class=\"jumbotron\">
                            <div class=\"col-md-8\">
                                <h2>YaWK <small>$lang[INSTALLATION]</small></h2>
                                <h4>$lang[STEP] $_POST[step]/5 <small>$lang[DATABASE]</small></h4>
                                <hr>
                                <h4>$lang[MYSQL_DATA]</h4>
                                <label for=\"DB_HOST\">$lang[DB_HOST] <small><i>$lang[DB_HOST_SUBTEXT]</i></small></label>
                                <input type=\"text\" class=\"form-control\" name=\"DB_HOST\" id=\"DB_HOST\" placeholder=\"$setup[DB_HOST]\">
                                
                                <label for=\"DB_NAME\">$lang[DB_NAME] <small><i>$lang[DB_NAME_SUBTEXT]</i></small></label>
                                <input type=\"text\" class=\"form-control\" name=\"DB_NAME\" id=\"DB_NAME\" placeholder=\"$setup[DB_NAME]\">
                                    
                                <label for=\"DB_USER\">$lang[DB_USER] <small><i>$lang[DB_USER_SUBTEXT]</i></small></label>
                                <input type=\"text\" class=\"form-control\" name=\"DB_USER\" id=\"DB_USER\" placeholder=\"$setup[DB_USER]\">
                                    
                                <label for=\"DB_PASS\">$lang[DB_PASS] <small><i>$lang[DB_PASS_SUBTEXT]</i></small></label>
                                <input type=\"password\" class=\"form-control\" name=\"DB_PASS\" id=\"DB_PASS\" placeholder=\"$setup[DB_PASS]\"><br>";


            if ($this->serverRequirements === "true")
            {
                echo "<button type=\"submit\" name=\"save\" id=\"savebutton\" class=\"btn btn-success pull-right\"><small>$_POST[step]/5</small> &nbsp;$lang[NEXT_STEP] &nbsp;<i id=\"savebuttonIcon\" class=\"fa fa-arrow-right\"></i></button>";
            }
            else
            {
                echo "<button type=\"submit\" class=\"btn btn-warning pull-right\" disabled aria-disabled=\"true\"><small>$_POST[step]/5</small> &nbsp;$lang[NEXT_STEP] &nbsp;<i class=\"fa fa-arrow-right\"></i></button>";
            }
                                
                                echo "<br><h4>$lang[MYSQL_DATA_EXT]</h4>
                                    
                                <label for=\"DB_PREFIX\">$lang[DB_PREFIX] <small><i>$lang[DB_PREFIX_SUBTEXT]</i></small></label>
                                <input type=\"text\" class=\"form-control\" name=\"DB_PREFIX\" id=\"DB_PREFIX\" placeholder=\"$setup[DB_PREFIX]\" value=\"$setup[DB_PREFIX]\">
                                    
                                <label for=\"DB_PORT\">$lang[DB_PORT] <small><i>$lang[DB_PORT_SUBTEXT]</i></small></label>
                                <input type=\"text\" class=\"form-control\" name=\"DB_PORT\" id=\"DB_PORT\" placeholder=\"$setup[DB_PORT]\" value=\"$setup[DB_PORT]\">
                                    
                                <!-- <button type=\"button\" class=\"btn btn-default\" onClick=\"history.go(-1);return true;\"><i class=\"fa fa-arrow-left\"></i> &nbsp;back</button> -->
                                ";

            echo"<input type=\"hidden\" name=\"step\" value=\"3\">
                                <input type=\"hidden\" name=\"currentLanguage\" value=\"$language->currentLanguage\">
                                </div>
                                
                                <div class=\"col-md-4 text-justify\">
                                <br><br>
                                <br><br><hr>
                                <h4>$lang[INSTALL_NOTICE_HEADING]</h4>
                                $lang[INSTALL_NOTICE]
                                <br><br><br>
                                <h4>$lang[SYS_REQ]</h4>
                                <ul class=\"list-unstyled\">
                                    <li>$this->phpCheckIcon PHP $this->phpVersionRequired <small><i><small>($lang[USES]: ".phpversion().")</small></i></small></li>
                                    <li>$this->apacheCheckIcon Apache 2.x <small><i><small>($lang[AVAILABLE]: ".$this->apacheStatus.")</small></i></small></li>
                                        <ul class=\"list-unstyled small\">
                                            <li>&nbsp;&nbsp;&nbsp;&nbsp;$this->zlibCheckIcon +mod_gzip <small><i>($lang[AVAILABLE]: ".$this->zlib.") </i></small></li>
                                            <li>&nbsp;&nbsp;&nbsp;&nbsp;$this->modRewriteCheckIcon +mod_rewrite <small><i>($lang[AVAILABLE]: ".$this->modRewriteStatus.") </i></small></li>
                                        </ul>
                                </ul><br>";

            if ($this->serverRequirements === "true")
            {   // server requirements met
                echo "<h4 class=\"text-success\">$lang[SERVER_REQ_TRUE]</h4>";
            }
            else
            {   // server does not fulfill requirements, draw error
                \YAWK\alert::draw("danger", "$lang[SYS_REQ]", "$lang[SERVER_REQ_FALSE]", '', '');
                echo "<h4 class=\"text-danger\">$lang[SERVER_REQ_FALSE]</h4>";
            }
            echo"<br><h4>$lang[DATA_PACKAGES]</h4>
                                     <input type=\"checkbox\" id=\"installCoreData\" name=\"installCoreData\" checked disabled>
                                     <label for=\"installCoreData\" style=\"font-weight: normal;\">$lang[YAWK_INSTALLATION_FILES] <small>($setup[VERSION])</small></label>
                                     <br>
                                     <input type=\"checkbox\" id=\"installSampleData\" name=\"installSampleData\" disabled>
                                     <label for=\"installSampleData\" style=\"font-weight: normal;\">$lang[YAWK_EXAMPLE_FILES] <small><small><i>$lang[USERS_PAGES_MENUS]</i></small></small></label>
                                     <br><br><b>$lang[DB_CHECK]</b><br><br><br><br><br><br></div> <!-- end col -->
                            </div> <!-- end jumbotron -->
                          </div> <!-- end row -->
                          ";
        }

        /** @brief step 3 - write db-config, check + import db connection If all went good, a form with project settings gets drawn.
         * @param array $setup installation settings
         * @param object $language language object
         * @param array $lang language data array
         * @author Daniel Retzl <danielretzl@gmail.com>
         * @license    https://opensource.org/licenses/MIT
         */
        public function step3($setup, $language, $lang)
        {
            // server-side check if user has filled out all required fields of step 2
            if (!isset($_POST['DB_HOST']) || empty($_POST['DB_HOST'])
            || (!isset($_POST['DB_USER']) || empty($_POST['DB_USER'])
            || (!isset($_POST['DB_NAME']) || empty($_POST['DB_NAME'])
            || (!isset($_POST['DB_PREFIX']) || empty($_POST['DB_PREFIX'])
            || (!isset($_POST['DB_PORT']) || empty($_POST['DB_PORT'])
            )))))
            {   // kick user back to step 2, due missing or empty settings
                if (isset($_POST['step']) && (!empty($_POST['step']))) { $_POST['step']--; }
                $this->step2($setup, $language, $lang);
                \YAWK\alert::draw("danger", "$lang[DB_ERROR]", "$lang[DB_ERROR_MISSING_FIELDS]", "", 5000);
                exit;
            }
            else
                {   // data from step 2 seem to be OK...
                    $this->step = 3;
                    // get root base path
                    $this->rootPath = \YAWK\sys::getBaseDir();

                    // write DB connection into db-config.php
                    $data = "
<?php
    \$this->config['server'] = \"".$_POST['DB_HOST']."\";
    \$this->config['username'] = \"".$_POST['DB_USER']."\";
    \$this->config['password'] = \"".$_POST['DB_PASS']."\";
    \$this->config['dbname'] = \"".$_POST['DB_NAME']."\";
    \$this->config['prefix'] = \"".$_POST['DB_PREFIX']."\";
    \$this->config['port'] = \"".$_POST['DB_PORT']."\";
?>";
                    // check if dbconfig file was successfully written...
                    if (file_put_contents($this->dbConfigPhp, $data))
                    {
                        // include database and settings class
                        if (!isset($db)) {
                            require_once('system/classes/db.php');
                            $db = new \YAWK\db();
                        }

                        // ok, lets test the database connection...
                        if ($db->connect())
                        {
                            // import .sql data
                            if ($status = $db->import($this->sqlFile, $lang))
                            {   // delete filepointer, because it is not needed anymore
                                unlink($this->filePointer);
                                \YAWK\alert::draw("success", "$lang[DB_IMPORT]", "$lang[DB_IMPORT_OK]", "", 2000);
                            }
                            else
                                {   // delete filepointer, start again at next try
                                    unlink($this->filePointer);
                                    $this->step2($setup, $language, $lang);
                                    \YAWK\alert::draw("danger", "$lang[DB_IMPORT]", "$lang[DB_IMPORT_FAILED]", "", 6000);
                                    exit;
                                }
                        }
                        else
                        {   // kick user back to step 2, due missing or empty settings
                            if (isset($_POST['step']) && (!empty($_POST['step']))) { $_POST['step']--; }
                            $this->step2($setup, $language, $lang);
                            \YAWK\alert::draw("danger", "$lang[DB_ERROR]", "$lang[DB_ERROR_SUBTEXT]", "", 5000);
                            exit;
                        }

                        echo"
                          <div class=\"row\">
                            <div class=\"jumbotron\">
                                <div class=\"col-md-8 text-justify\">
                                    <h2>YaWK <small>$lang[INSTALLATION]</small></h2>
                                    <h4>$lang[STEP] $_POST[step]/5 <small>$lang[PROJECT_SETTINGS]</small></h4>
                                    <hr><h4>$lang[COMMON_PROJECT_SETTINGS]</h4>
                                    <label for=\"URL\">$lang[URL] <small><i>$lang[URL_SUBTEXT]</i></small></label>
                                    <input type=\"text\" class=\"form-control\" name=\"URL\" id=\"URL\" placeholder=\"$setup[URL]\">
                                    <label for=\"TITLE\">$lang[TITLE] <small><i>$lang[INSTALLER_TITLE_SUBTEXT]</i></small></label>
                                    <input type=\"text\" class=\"form-control\" name=\"TITLE\" id=\"TITLE\" placeholder=\"$lang[INSTALLER_TITLE]\">
                                    <label for=\"DESC\">$lang[INSTALLER_DESC] <small><i>$lang[INSTALLER_DESC_SUBTEXT]</i></small></label>
                                    <input type=\"text\" class=\"form-control\" name=\"DESC\" id=\"DESC\" placeholder=\"$lang[INSTALLER_DESC_PLACEHOLDER]\">
                                    <br>
                                    <input type=\"hidden\" name=\"step\" value=\"4\">
                                    <input type=\"hidden\" name=\"currentLanguage\" value=\"$language->currentLanguage\">
                                    <button type=\"submit\" class=\"btn btn-success pull-right\"><small>$_POST[step]/5</small> &nbsp;$lang[NEXT_STEP] &nbsp;<i class=\"fa fa-arrow-right\"></i></button>
                                   <hr>
                                    <label for=\"ROOT_PATH\">$lang[ROOT_PATH] <small><i>$lang[ROOT_PATH_SUBTEXT]</i></small></label>
                                    <input type=\"text\" class=\"form-control\" name=\"ROOT_PATH\" id=\"ROOT_PATH\" value=\"$this->rootPath\" placeholder=\"$setup[ROOT_PATH]\">
                                </div>
                                <div class=\"col-md-4 text-justify\">
                                    <br><br>
                                    <br><br><hr>
                                    <h4>$lang[BASE_INFO]</h4>
                                    $lang[INSTALL_NOTICE_BASE_INFO]
                                    <br><br><br>
                                    <b>$lang[STEP4]</b><br>
                                </div>
                            </div>
                          </div>";
                    }
                    else
                    {   // if not - draw error
                        \YAWK\alert::draw("danger", "$lang[DBCONFIG_WRITE_FAILED]", "$lang[DBCONFIG_WRITE_FAILED]", "","");
                        $this->step2($setup, $language, $lang);
                        exit;
                    }
                }
        }

        /** @brief step 4 - save project settings and draw a form to enter user data (email, name, password...)
         * @param array $setup installation settings
         * @param object $language language object
         * @param array $lang language data array
         * @author Daniel Retzl <danielretzl@gmail.com>
         * @license    https://opensource.org/licenses/MIT
         */
        public function step4($setup, $language, $lang)
        {
            $this->step = 4;
            // include database and settings class
            if (!isset($db))
            {   // include database class
                require_once('system/classes/db.php');
                $db = new \YAWK\db();
            }

            if (isset($_POST['ROOT_PATH']) && (!empty($_POST['ROOT_PATH'])))
            {
                // set dirprefix from form POST
                $this->rootPath = trim($_POST['ROOT_PATH']);
                // save dirprefix to db
                \YAWK\settings::setSetting($db, "dirprefix", $this->rootPath, $lang);
            }
            else
                {
                    $this->rootPath = \YAWK\sys::getBaseDir();
                }

            if (isset($_POST['URL']) && (!empty($_POST['URL'])))
            {
                // check if user sent a proper URL
                if(filter_var($_POST['URL'], FILTER_VALIDATE_URL))
                {   // remove spaces around the string
                    $this->url = trim($_POST['URL']);
                    // ensure that there is no trailing slash at the end
                    $this->url = rtrim($this->url, '/') . '';
                    // save website host (URL) setting to database
                    \YAWK\settings::setSetting($db, "host", $this->url, $lang);
                    \YAWK\settings::setSetting($db, "backendLogoText", $this->url, $lang);
                }
                else
                    {   // FILTER FAILED - process anway, but throw warning afterwards.
                        // remove spaces around the string
                        $this->url = trim($_POST['URL']);
                        // ensure that there is no trailing slash at the end
                        $this->url = rtrim($this->url, '/') . '';
                        \YAWK\settings::setSetting($db, "host", $this->url, $lang);
                        \YAWK\settings::setSetting($db, "backendLogoText", $this->url, $lang);
                        \YAWK\alert::draw("warning", "$lang[FAULTY_URL]", "$lang[FAULTY_URL_SUBTEXT]", "", 5000);
                    }
            }

            if (isset($_POST['TITLE']) && (!empty($_POST['TITLE'])))
            {
                \YAWK\settings::setSetting($db, "title", $_POST['TITLE'], $lang);
            }

            if (isset($_POST['DESC']) && (!empty($_POST['DESC'])))
            {
                \YAWK\settings::setSetting($db, "globalmetatext", $_POST['DESC'], $lang);
            }

            if (isset($language->currentLanguage))
            {
                \YAWK\settings::setSetting($db, "backendLanguage", $language->currentLanguage, $lang);
            }

            echo"
                          <div class=\"row\">
                            <div class=\"jumbotron\">
                                <div class=\"col-md-8 text-justify\">
                                    <h2>YaWK <small>$lang[INSTALLATION]</small></h2>
                                    <h4>$lang[STEP] $_POST[step]/5 <small>$lang[ACCOUNT_SETTINGS]</small></h4>
                                    <hr><h4>$lang[USER] $lang[SETTINGS]</h4>
                                    <label for=\"EMAIL\">$lang[EMAIL] <small><i>$lang[EMAIL_SUBTEXT]</i></small></label>
                                    <input type=\"text\" class=\"form-control\" name=\"EMAIL\" id=\"EMAIL\" placeholder=\"$setup[ADMIN_EMAIL]\">
                                    <label for=\"USERNAME\">$lang[USERNAME] <small><i>$lang[USERNAME]</i></small></label>
                                    <input type=\"text\" class=\"form-control\" name=\"USERNAME\" id=\"USERNAME\" placeholder=\"$setup[ADMIN_USER]\" value=\"admin\">
                                    <label for=\"PASSWORD\">$lang[PASSWORD] <small><i>$lang[PASSWORD]</i></small></label>
                                    <input type=\"password\" class=\"form-control\" name=\"PASSWORD\" id=\"PASSWORD\" placeholder=\"$setup[ADMIN_PASS]\">
                                    <label for=\"PASSWORD2\">$lang[PASSWORD] <small><i>($lang[REPEAT])</i></small></label>
                                    <input type=\"password\" class=\"form-control\" name=\"PASSWORD2\" id=\"PASSWORD2\" placeholder=\"$setup[ADMIN_PASS]\">
                                    <br>
                                    <input type=\"hidden\" name=\"url\" value=\"$this->url\">
                                    <input type=\"hidden\" name=\"rootPath\" value=\"$this->rootPath\">
                                    <input type=\"hidden\" name=\"step\" value=\"5\">
                                    <input type=\"hidden\" name=\"currentLanguage\" value=\"$language->currentLanguage\">
                                    <button type=\"submit\" class=\"btn btn-success pull-right\"><small>$_POST[step]/5</small> &nbsp;$lang[NEXT_STEP] &nbsp;<i class=\"fa fa-arrow-right\"></i></button>
                                   
                                </div>
                                <div class=\"col-md-4 text-justify\">
                                    <br><br>
                                    <br><br><hr>
                                    <h4>$lang[ACCOUNT_NOTICE]</h4>
                                    $lang[ACCOUNT_NOTICE_INFO]
                                    <br><br><br>
                                    <b>$lang[STEP5]</b><br>
                                </div>
                            </div>
                          </div>";
        }

        /** @brief step 5 - save data, write .htaccess files and redirect to backend login - FIN
         * @param array $setup installation settings
         * @param object $language language object
         * @param array $lang array language data array
         * @author Daniel Retzl <danielretzl@gmail.com>
         * @license    https://opensource.org/licenses/MIT
         */
        public function step5($setup, $language, $lang)
        {
            $this->step = 5;
            // include database and settings class
            if (!isset($db))
            {
                require_once('system/classes/db.php');
                $db = new \YAWK\db();
            }
            if (isset($_POST['url']) && (!empty($_POST['url'])))
            {
                $this->url = $_POST['url'];
            }
            if (isset($_POST['rootPath']) && (!empty($_POST['rootPath'])))
            {
                $this->rootPath = $_POST['rootPath'];
            }

            if (isset($_POST['EMAIL']) && (!empty($_POST['EMAIL'])))
            {
                \YAWK\settings::setSetting($db, "admin_email", $_POST['EMAIL'], $lang);
            }
            if (isset($_POST['USERNAME']) && (!empty($_POST['USERNAME'])))
            {
                if (\YAWK\user::create($db, $_POST['USERNAME'], $_POST['PASSWORD'], $_POST['PASSWORD2'], $_POST['EMAIL'], "", "", "", "", "", "", "", "", "", 0, 1, "Administrator", 5) === true)
                {
                    // user successfully created
                    // final step: create .htaccess files
                    // write .htaccess file to /admin folder
                    if ($this->writeHtaccessFileToAdminFolder() === false)
                    {
                        $htaccessAdminStatus = 0;
                        // failed to write /admin/.htaccess - throw warning
                        \YAWK\alert::draw("warning", "$lang[HTACCESS_WRITE_FAILED_ADMIN]", "$lang[HTACCESS_WRITE_FAILED_ADMIN_SUBTEXT]", "", "");
                    }
                    else { $htaccessAdminStatus = 1; }

                    // write .htaccess file to / root folder
                    if ($this->writeHtaccessFileToRootFolder() === false)
                    {   $htaccessRootStatus = 0;
                        // failed to write .htaccess - throw warning
                        \YAWK\alert::draw("warning", "$lang[HTACCESS_WRITE_FAILED_ROOT]", "$lang[HTACCESS_WRITE_FAILED_ROOT_SUBTEXT]", "", "");
                    }
                    else { $htaccessRootStatus = 1; }

                    $htStatus = $htaccessAdminStatus+$htaccessRootStatus;
                    if ($htStatus === 2)
                    {
                        if (unlink('setup.php'))
                        {
                            \YAWK\alert::draw("success", "$lang[INSTALL_COMPLETE]", "$lang[INSTALL_COMPLETE_SUBTEXT]", "", 3000);
                            \YAWK\sys::setTimeout("admin/index.php", 3000);
                            exit;
                        }
                        else
                            {
                                \YAWK\alert::draw("warning", "$lang[INSTALL_COMPLETE]", "$lang[SETUP_UNLINK_FAILED]", "", 5000);
                                \YAWK\sys::setTimeout("admin/index.php", 5000);
                                exit;
                            }
                    }
                    else
                        {   // check which .htaccess file could not be written
                            if ($htaccessAdminStatus === 0)
                            {   // admin file could not be written, throw error
                                \YAWK\alert::draw("warning", "$lang[HTACCESS_WRITE_FAILED_ADMIN]", "$lang[HTACCESS_WRITE_FAILED_ADMIN_SUBTEXT]", "", "");
                                exit;
                            }
                            if ($htaccessRootStatus === 0)
                            {
                                \YAWK\alert::draw("warning", "$lang[HTACCESS_WRITE_FAILED_ROOT]", "$lang[HTACCESS_WRITE_FAILED_ROOT_SUBTEXT]", "", "");
                                exit;
                            }
                        }
                }
                else
                {
                    if (isset($_POST['step']) && (!empty($_POST['step']))) { $_POST['step']--; }
                    \YAWK\alert::draw("warning", "$lang[INSTALL_USERNAME_FAILED]", "$lang[INSTALL_USERNAME_FAILED_SUBTEXT]", "", 5000);
                    $this->step4($setup, $language, $lang);
                    exit;
                }
            }
        }


        /* GET + CHECK functions */

        /** @brief this function writes the .htaccess file to the admin/ folder
         * @author Daniel Retzl <danielretzl@gmail.com>
         * @license    https://opensource.org/licenses/MIT
         */
        public function  writeHtaccessFileToAdminFolder()
        {
            $file = 'admin/.htaccess';
            $host = $this->url;
            $data = "
#Options +FollowSymlinks
Order allow,deny
Allow from all

# custom error page
ErrorDocument 404 $host/content/errors/404.html

RewriteEngine on
RewriteCond %{REQUEST_URI} /(.*).html
RewriteRule ^(.*).html$ \\index.php?include=$1
# Rewrite .html - no extension needed e.g. you can use http://www.yoursite/gallery instead of /gallery.html
RewriteRule ^([^\\.]+)$ \\index.php?page=$1 [NC,L]

# off for tinymce
#RewriteRule ^(.*).htm$ \\index.php?include=$1
";
            if (file_put_contents($file, $data, LOCK_EX))
            {
                return true;
            }
            else
            {
                return false;
            }
        }

        /**
         * @return bool
         */
        public function writeHtaccessFileToRootFolder()
        {
            $host = $this->url;
            // filename
            $file = '.htaccess';
            $data = "
# SEO settings
# to work correctly, you need +FollowSymLinks or at least +SymLinksIfOwnerMatch enabled.
# if you get an ERROR 500, try ifownermatch (slower) and/or ask you webhoster to enable mod_rewrite + symlinks

#Options +FollowSymlinks
#Options +SymlinksIfOwnerMatch
DirectoryIndex index.php
Order allow,deny
Allow from all

# custom error page
ErrorDocument 404 $host/content/errors/404.html

# SEO settings
RewriteEngine On
RewriteBase $this->rootPath
RewriteCond %{REQUEST_URI} /(.*).html
# rewrite all .html files to index.php?include={filename}
RewriteRule ^(.*).html$ \index.php?include=$1 [NC,L]
# rewrite all .htm files to index.php?include={filename}
# if you wish to use tinymce, you need put a # in front of the next line
RewriteRule ^(.*).htm$ \index.php?include=$1 [NC,L]
# Allow Robots.txt to pass through
RewriteRule ^robots.txt - [L]
# Userpage Rewrite Rule
RewriteRule ^welcome/([^/]*)$ \index.php?signup=1 [NC,L]
RewriteRule ^users/([^/]*)$ \index.php?user=$1 [NC,L]
RewriteRule ^users([^/]*)$ \index.php?user=$1 [NC,L]
# Rewrite .html - no extension needed e.g. you can use http://www.yoursite/gallery instead of /gallery.html
RewriteRule ^([^\.]+)$ $1.html [NC,L]
# any other plugin...
# RewriteRule ^plugin([^/]*)$ \index.php?plugin=$1 [L]

# CACHE + THREAD SETTINGS
 <ifModule mod_headers.c>
    Header set Connection keep-alive
 </ifModule>

# CACHE - STATIC CONTENT CACHING starts here
# required modules:
#   mod_expires.so
#   mod.gzip.c
#   mod.deflate.c
# if caching does not work, or you get 500 - server error, check if the required module are loaded.
# in your httpd.conf look for the following line:
# #LoadModule expires_module modules/mod_expires.so -- uncomment it & restart server.
# if you cannot load the modules, comment out all lines til #END CACHING -- and it will work (w/o caching)
 <IfModule mod_expires.c>
    # Add correct content-type for fonts
    AddType application/vnd.ms-fontobject .eot
    AddType application/x-font-ttf .ttf
    AddType application/x-font-opentype .otf
    AddType application/x-font-woff .woff
    AddType image/svg+xml .svg
    
    # enable cache
    ExpiresActive On
    
    # default expire: 1 day
    ExpiresDefault A86400
    
    # set cacheable items
    ExpiresByType image/x-icon A2592000
    ExpiresByType application/x-javascript A1209600
    ExpiresByType text/css A1209600
    ExpiresByType image/gif A1209600
    ExpiresByType image/png A1209600
    ExpiresByType image/jpeg A1209600
    ExpiresByType text/plain A86400
    ExpiresByType application/x-shockwave-flash A2592000
    ExpiresByType video/x-flv A2592000
    ExpiresByType application/pdf A2592000
    ExpiresByType text/html A86400
    # Add a far future Expires header for fonts
    ExpiresByType application/vnd.ms-fontobject \"access plus 1 year\"
    ExpiresByType application/x-font-ttf \"access plus 1 year\"
    ExpiresByType application/x-font-opentype \"access plus 1 year\"
    ExpiresByType application/x-font-woff \"access plus 1 year\"
    ExpiresByType image/svg+xml \"access plus 1 year\"

## Set up caching on media files for 1 month
<FilesMatch \"\.(flv|ico|pdf|avi|mov|ppt|doc|mp3|wmv|wav|swf)$\">
  ExpiresDefault A2592000
  Header append Cache-Control \"public\"
</FilesMatch>

## Set up caching on images css and js files for 2 weeks
<FilesMatch \"\.(gif|jpg|jpeg|png|js|css)$\">
  ExpiresDefault A1209600
  Header append Cache-Control \"public\"
</FilesMatch>

## Set up 1 day caching on commonly updated files
<FilesMatch \"\.(xml|txt|htm|html)$\">
  ExpiresDefault A86400
  Header append Cache-Control \"private, must-revalidate\"
</FilesMatch>

## Force no caching for dynamic files
<FilesMatch \"\.(php|cgi|pl)$\">
  ExpiresDefault A0
  Header set Cache-Control \"no-store, no-cache, must-revalidate, max-age=0\"
  Header set Pragma \"no-cache\"
</FilesMatch>
</IfModule>

# BEGIN GZIP
# compress the output of html, xml, txt, css and js files
# mod_gzip compression (legacy, Apache 1.3)
<IfModule mod_gzip.c>
 mod_gzip_on Yes
 mod_gzip_dechunk Yes
 mod_gzip_item_include file \.(html?|xml|txt|css|js)$
 mod_gzip_item_include handler ^cgi-script$
 mod_gzip_item_include mime ^text/.*
 mod_gzip_item_include mime ^application/x-javascript.*
 mod_gzip_item_exclude mime ^image/.*
 mod_gzip_item_exclude rspheader ^Content-Encoding:.*gzip.*
</IfModule>
 # END GZIP

 # DEFLATE compression
 # this deflates all zipped files
 <IfModule mod_deflate.so>
 # Set compression for: html,txt,xml,js,css,svg and otf, ttf and woff fonts
 AddOutputFilterByType DEFLATE text/html text/plain text/xml text/css text/javascript application/xml application/xhtml+xml application/x-javascript application/x-font-ttf application/x-font-opentype image/svg+xml
 # Deactivate compression for buggy browsers
 BrowserMatch ^Mozilla/4 gzip-only-text/html
 BrowserMatch ^Mozilla/4.0[678] no-gzip
 BrowserMatch bMSIE !no-gzip !gzip-only-text/html
 # Set header information for proxies
 Header append Vary User-Agent
</IfModule>
 # END DEFLATE
# END CACHING ############################################

# override max post size
# php_value post_max_size 32M

# override max upload file size
# php_value upload_max_filesize 32M

            ";
            // write to file
            // using the flag LOCK_EX, to ensure safe writing on file
            if (file_put_contents($file, $data, LOCK_EX))
            {   // all good
                return true;
            }
            else
                {   // could not write file
                    return false;
                }

        }


        /** @brief check server requirements and set object params
         * @author Daniel Retzl <danielretzl@gmail.com>
         * @license    https://opensource.org/licenses/MIT
         */
        public function checkServerRequirements()
        {
            $i = 0;
            self::checkPhpVersion();
            self::checkApacheVersion();
            self::checkZlib();
            self::checkModRewrite();

            // check PHP status
            if ($this->phpVersionStatus === "true")
            {   // ok
                $i++;
                $this->phpCheckIcon = "<i class=\"fa fa-check text-success\"></i>";
            }
            else
            {   // PHP failed
                $this->phpCheckIcon = "<i class=\"fa fa-times text-danger\"></i>";
            }

            // check APACHE status
            if ($this->apacheStatus === "true")
            {   // ok
                $i++;
                $this->apacheCheckIcon = "<i class=\"fa fa-check text-success\"></i>";
            }
            else
            {   // apache failed
                $this->apacheCheckIcon = "<i class=\"fa fa-times text-danger\"></i>";
            }

            // check zlib status
            if ($this->zlib === "true")
            {   // ok
                $this->zlibCheckIcon = "<i class=\"fa fa-check text-success\"></i>";
            }
            else
            {   // zlib failed
                $this->zlibCheckIcon = "<i class=\"fa fa-times text-danger\"></i>";
            }

            // check modRewrite status
            if ($this->modRewriteStatus === "true")
            {   // ok
                $this->modRewriteCheckIcon = "<i class=\"fa fa-check text-success\"></i>";
            }
            else
            {   // failed
                $this->modRewriteCheckIcon = "<i class=\"fa fa-times text-danger\"></i>";
            }

            // check if
            if ($i < 2)
            {
                $this->serverRequirements = "false";
            }
            else
            {
                $this->serverRequirements = "true";
            }
        }

        /** Check supported languages and build options for select field
         * @author Daniel Retzl <danielretzl@gmail.com>
         * @license    https://opensource.org/licenses/MIT
         */
        public function getLanguageSelectOptions($language, $lang)
        {
            $selectOptions = '';

            $selectOptions .= "<option disabled selected>$lang[SELECT_LANGUAGE]</option>";
            foreach ($language->supportedLanguages AS $supported)
            {
                $supportedLanguage = substr($supported, 0, 2);
                if ($language->currentLanguage === "$supportedLanguage")
                {
                    // $selectOptions .= "<option value=\"$supportedLanguage\" selected>$supported</option>
                    $selectOptions .= "<option value=\"$supported\" selected>$supported</option>
                                        ";
                }
                else
                    {
                        // $selectOptions .= "<option value=\"$supportedLanguage\">$supported</option>
                        $selectOptions .= "<option value=\"$supported\">$supported</option>
                        ";
                    }
            }
                return $selectOptions;
        }

        /** @brief Check if php version is bigger than required
         * @author Daniel Retzl <danielretzl@gmail.com>
         * @license    https://opensource.org/licenses/MIT
         * @return bool
         */
        public function checkPhpVersion()
        {
            if (version_compare(phpversion(), $this->phpVersionRequired, '<')) {
                // php version isn't high enough
                $this->phpVersionStatus = "false";
                return false;
            }
            else
            {   // ok, PHP fits.
                $this->phpVersionStatus = "true";
                return true;
            }
        }

        /** @brief Check if the weberver is running on apache
         * @author Daniel Retzl <danielretzl@gmail.com>
         * @license    https://opensource.org/licenses/MIT
         * @return bool
         */
        public function checkApacheVersion()
        {   // check if server software info is readable and set
            if (isset($_SERVER['SERVER_SOFTWARE']) && (!empty($_SERVER['SERVER_SOFTWARE'])))
            {   // test server software
                if ($_SERVER['SERVER_SOFTWARE'] === "Apache")
                {   // apache seems to be running
                    $this->apacheStatus = "true";
                    return true;
                }
                else
                    {   //
                        if ($this->apacheStatus = apache_get_version())
                        {
                            $this->apacheStatus = "true";
                            return true;
                        }
                        else
                            {
                                // no apache detected...
                                $this->apacheStatus = "false";
                                return false;
                            }
                    }
            }
            else
                {
                    if ($this->apacheStatus = apache_get_version())
                    {
                        $this->apacheStatus = "true";
                        return true;
                    }
                    else
                    {
                        // server software var not set or readable
                        $this->apacheStatus = "unable to detect";
                        return true; // let user try to install anyway
                    }
                }
        }

        /**
         * @brief Check if zlib is available
         * @return bool
         */
        public function checkZlib()
        {   // check if zlib is installed
            if(extension_loaded('zlib'))
            {   // zlin loaded
                $this->zlib = "true";
                return true;
            }
            else
            {   // zlib not loaded
                $this->zlib = "false";
                return false;
            }
        }

        /**
         * @brief Check if mod_rewrite is available
         * @details <p>Note: this does not work on some restricted configured shared hosting providers.</p>
         * @return bool
         */
        public function checkModRewrite()
        {   // check if mod_rewrite is in module list
            // note: this does not work on some restricted configured shared hosting providers.
            // even when mod_rewrite works, sometimes the identification fails due configuration restrictions.
            if(function_exists('apache_get_modules') && in_array('mod_rewrite',apache_get_modules()))
            {   // apache!
                $this->modRewriteStatus = "true";
                return true;
            }
            // IIS ?
            else if (isset($_SERVER['IIS_UrlRewriteModule']))
            {   // IIS. meh.
                $this->modRewriteStatus = "true";
                return true;
            }
            else
            {   // anyway - check if mod_rewrite is loaded
                if (extension_loaded('mod_rewrite'))
                {   // mod_rewrite loaded
                    $this->modRewriteStatus = "true";
                    return true;
                }
                else
                {   // mod_rewrite not loaded
                    $this->modRewriteStatus = "false";
                    return false;
                }
            }
        }

        /**
         * @brief Draw the installer's footer with links to yawk.io and github
         */
        public function footer()
        {
            echo "<footer class=\"animated fadeIn\" style=\"position: relative; bottom: -8em; width: 100%; height: auto; background-color: #ebebeb;\">
                        <div class=\"container-fluid\">
                        <div class=\"row\">
                            <div class=\"col-md-12 text-center small\">
                                <h5 class=\"text-muted\"><small><a href=\"http://yawk.io\" title=\"Official YaWK Website\" target=\"_blank\"><b>Y</b>et <b>a</b>nother <b>W</b>eb<b>K</b>it</a> on <b>
                                <a href=\"https://github.com/YaWK/yawk.io\" title=\"visit, fork or star YaWK on GitHub\" target=\"_blank\">GitHub</a></b></small>
                                - <small>v $this->yawkVersion
                                </h5>
                            </div>
                        </div>
                        </div>
                  </footer>";
        }

        /**
         * @brief Call the footer and end the html body and file
         */
        function __destruct()
        {
                $this->footer();
                echo"
                </form>
                </body>
                </html>";
        }
    } // end class installer
} // end namespace
