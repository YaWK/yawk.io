<?php
namespace YAWK {

    /**
     * Class installer
     * @package YAWK
     */
    class installer
    {
        /** * @var int $step */
        public $step;
        /** * @var bool $phpVersionStatus */
        public $phpVersionStatus;
        /** * @var string $phpCheckIcon */
        public $phpCheckIcon;
        /** * @var $apacheVersionStatus */
        public $apacheVersionStatus;
        /** * @var bool $apacheCheckIcon */
        public $apacheCheckIcon;
        /** * @var $zlib */
        public $zlib;
        /** * @var $zlibCheckIcon */
        public $zlibCheckIcon;
        /** * @var $modRewrite */
        public $modRewrite;
        /** * @var $modRewriteCheckIcon */
        public $modRewriteCheckIcon;
        /** * @var $serverRequirements */
        public $serverRequirements;


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
        <link rel=\"stylesheet\" href=\"system/engines/bootstrap/dist/css/bootstrap.min.css\">
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
    <body>
    <form method=\"POST\">
    ";
        }

        public function init()
        {
            /* INSTALLER SCRIPT */
            if (file_exists("system/setup/install.ini"))
            {
                /* CHECK + SET LANGUAGE */
                // include language class
                require_once ('system/classes/language.php');
                /* check if language object is set*/
                if (!isset($lang) || (empty($lang)))
                {   // set new language object
                    $language = new \YAWK\language();
                    // set the path to the language file
                    $language->pathToFile = "admin/language/";

                    // try to get the client language
                    if ($language->currentLanguage = $language->getClientLanguage())
                    {   // currentLanguageGlobal is set due call of getClientLanguage
                        if ($language->isSupported($language->currentLanguageGlobal))
                        {
                            // client language is supported, set it
                            $language->setLanguage($language->currentLanguageGlobal);
                        }
                        else
                            {
                                // language not supported - set default
                                $language->setDefault("en-EN");
                            }
                    }
                    // if current language is sent via form (POST data)
                    if (isset($_POST['currentLanguage']) && (!empty($_POST['currentLanguage'])))
                    {   // check if POST language is supported
                        if ($language->isSupported($_POST['currentLanguage']))
                        {
                            // POST language is supported - set as default
                            $language->currentLanguage = $_POST['currentLanguage'];
                            $language->setLanguage($language->currentLanguage);
                        }
                        else
                            {
                                // POST language NOT supported - set default
                                $language->setDefault("en-EN");
                            }
                    }

                    // convert language object param to array $lang[] that contains all the data
                    $lang = (array) $language->lang;
                    /* LOAD INSTALLER */
                    $this->setup($language, $lang);
                }
            }
            else
                {   // init() failed - INSTALL.INI is not found or not readable
                    require_once('system/classes/alert.php');
                    \YAWK\alert::draw("danger", "Installer seems to be broken.", "Please check if <b><i>system/setup/install.ini</i></b> is readable. If file is not here, there could be a problem with the package due unzip or uploading. In that case try to download, unzip and upload again.", "","");
                    exit;
                }
        }   // ./ end installer init()

        /**
         * Check if installation is needed
         *
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
            if ($setup = parse_ini_file("system/setup/install.ini", FALSE))
            {   // if INSTALL is set to true
                if ($setup['INSTALL'] === "true")
                {   // if no step variable is set, setup run for the first time
                    if (!isset($_POST['step']) || (empty($_POST['step'])))
                    {   // STEP 1 -- LANGUAGE SELECTION
                        $_POST['step'] = 1;
                        // STEP 1 - language selector
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
                        $this->step5($lang);
                    }
                }
            }
                else
                    {
                        \YAWK\alert::draw("danger", "Installation Error", "Install.ini is not readable. It seems that the package is corrupt. Please try to delete, re-download and re-install the whole package.", "","");
                        exit;
                    }
                    // prevent display anything else
                    exit;
        }


        public function step1($language, $lang)
        {
            echo "
                  <div class=\"container-fluid animated fadeIn\">
                    <div class=\"row\">
                        <div class=\"jumbotron\" style=\"background-color: #fff; height: 100%;\">
                            <div class=\"col-md-4 text-justify\">
                                &nbsp;
                            </div>
                            <div class=\"col-md-4\">
                                <h2>YaWK <small>$lang[INSTALLATION]</small></h2>
                                <h4>$lang[STEP] $_POST[step]/5 <small>$lang[PREPARATION]</small></h4>
                                <hr>
                                <label for=\"currentLanguage\">$lang[LANG_LABEL]</label>
                                    <select class=\"form-control\" id=\"currentLanguage\" name=\"currentLanguage\">
                                        ".$this->getLanguageSelectOptions($language)."
                                    </select>
                                <br>
                                <button class=\"btn btn-success pull-right\" type=\"submit\"><small>$_POST[step]/5</small> &nbsp;$lang[NEXT_STEP] &nbsp;<i class=\"fa fa-arrow-right\"></i></button>
                                <input type=\"hidden\" name=\"step\" value=\"2\">
                            </div>
                            <div class=\"col-md-4 text-justify\">
                                &nbsp;
                            </div>
                        </div>
                    </div>
                  </div>";
        }

        public function step2($setup, $language, $lang)
        {
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
                  <div class=\"container-fluid animated fadeIn\">
                    <div class=\"row\">
                        <div class=\"jumbotron\" style=\"background-color: #fff; height: 100%;\">
                            <div class=\"col-md-8\">
                                <h2>YaWK <small>$lang[INSTALLATION]</small></h2>
                                <h4>$lang[STEP] $_POST[step]/5 <small>$lang[DATABASE]</small></h4>
                                <hr>
                                <h4>$lang[MYSQL_DATA]</h4>
                                <label for=\"DB_HOST\">$lang[DB_HOST] <small><i>$lang[DB_HOST_SUBTEXT]</i></small></label>
                                <input type=\"text\" class=\"form-control\" name=\"DB_HOST\" id=\"DB_HOST\" value=\"$setup[DB_HOST]\">
                                
                                <label for=\"DB_NAME\">$lang[DB_NAME] <small><i>$lang[DB_NAME_SUBTEXT]</i></small></label>
                                <input type=\"text\" class=\"form-control\" name=\"DB_NAME\" id=\"DB_NAME\" value=\"$setup[DB_NAME]\">
                                    
                                <label for=\"DB_USER\">$lang[DB_USER] <small><i>$lang[DB_USER_SUBTEXT]</i></small></label>
                                <input type=\"text\" class=\"form-control\" name=\"DB_USER\" id=\"DB_USER\" value=\"$setup[DB_USER]\">
                                    
                                <label for=\"DB_PASS\">$lang[DB_PASS] <small><i>$lang[DB_PASS_SUBTEXT]</i></small></label>
                                <input type=\"text\" class=\"form-control\" name=\"DB_PASS\" id=\"DB_PASS\" value=\"$setup[DB_PASS]\"><br>";


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
                                <input type=\"text\" class=\"form-control\" name=\"DB_PREFIX\" id=\"DB_PREFIX\" value=\"$setup[DB_PREFIX]\">
                                    
                                <label for=\"DB_PORT\">$lang[DB_PORT] <small><i>$lang[DB_PORT_SUBTEXT]</i></small></label>
                                <input type=\"text\" class=\"form-control\" name=\"DB_PORT\" id=\"DB_PORT\" value=\"$setup[DB_PORT]\">
                                    
                                <br>
                                <!-- <button type=\"button\" class=\"btn btn-default\" onClick=\"history.go(-1);return true;\"><i class=\"fa fa-arrow-left\"></i> &nbsp;back</button> -->
                                ";

            echo"<input type=\"hidden\" name=\"step\" value=\"3\">
                                <input type=\"hidden\" name=\"currentLanguage\" value=\"$language->currentLanguage\">
                                </div>
                                
                                <div class=\"col-md-4 text-justify\">
                                <br><br>
                                <br><br><hr>
                                <b>$lang[INSTALL_NOTICE_HEADING]</b><br>
                                $lang[INSTALL_NOTICE]
                                <br><br><br>
                                <b>$lang[SYS_REQ]</b><br>
                                <ul class=\"list-unstyled\">
                                    <li>$this->phpCheckIcon PHP 5.x <small><i><small>($lang[USES]: ".phpversion().")</small></i></small></li>
                                    <li>$this->apacheCheckIcon Apache 2.x <small><i><small>($lang[USES]: ".apache_get_version().")</small></i></small></li>
                                        <ul class=\"list-unstyled small\">
                                            <li>&nbsp;&nbsp;&nbsp;&nbsp;$this->zlibCheckIcon +mod_gzip <small><i>($lang[AVAILABLE]: ".$this->zlib.") </i></small></li>
                                            <li>&nbsp;&nbsp;&nbsp;&nbsp;$this->modRewriteCheckIcon +mod_rewrite <small><i>($lang[AVAILABLE]: ".$this->modRewrite.") </i></small></li>
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
            echo"<br><br><b>$lang[DATA_PACKAGES]</b><br>
                                     <input type=\"checkbox\" id=\"installCoreData\" name=\"installCoreData\" checked disabled>
                                     <label for=\"installCoreData\" style=\"font-weight: normal;\">$lang[YAWK_INSTALLATION_FILES] <small>($setup[VERSION])</small></label>
                                     <br>
                                     <input type=\"checkbox\" id=\"installSampleData\" name=\"installSampleData\" checked disabled>
                                     <label for=\"installSampleData\" style=\"font-weight: normal;\">$lang[YAWK_EXAMPLE_FILES] <small><small><i>$lang[USERS_PAGES_MENUS]</i></small></small></label>
                                     <br><br><b>$lang[DB_CHECK]</b></div> <!-- end col -->
                            </div> <!-- end jumbotron -->
                          </div> <!-- end row -->
                          </div> <!-- end container -->
                          ";
        }

        public function step3($setup, $language, $lang)
        {

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
            if (file_put_contents("system/classes/dbconfig.php", $data))
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
                    if ($status = $db->import("yawk_database.sql"))
                    {   // delete filepointer, because it is not needed anymore
                        unlink("yawk_database.sql_filepointer");
                        \YAWK\alert::draw("success", "$lang[DB_IMPORT_OK]", "$status", "", 2000);
                    }
                }
                else
                {
                    if (isset($_POST['step']) && (!empty($_POST['step']))) { $_POST['step']--; }
                    $this->step2($setup, $language, $lang);
                    \YAWK\alert::draw("warning", "$lang[DB_ERROR]", "$lang[DB_ERROR_SUBTEXT]", "", 5000);
                    exit;
                }

                echo"<div class=\"container-fluid animated fadeIn\">
                          <div class=\"row\">
                            <div class=\"jumbotron\" style=\"height: 100%;\">
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
                                   
                                </div>
                                <div class=\"col-md-4 text-justify\">
                                    <br><br><br><br>
                                    <b>$lang[BASE_INFO]</b><br>
                                    $lang[INSTALL_NOTICE_BASE_INFO]
                                    <br><br><br>
                                    <b>$lang[STEP4]</b><br>
                                </div>
                            </div>
                          </div>
                          </div>";
            }
            else
            {   // if not - draw error
                echo "Could not write file: dbconfig.php - please check folder permissions and try again or setup the file manually.";
                exit;
            }
        }

        public function step4($setup, $language, $lang)
        {

            // include database and settings class
            if (!isset($db))
            {   // include database class
                require_once('system/classes/db.php');
                $db = new \YAWK\db();
            }

            if (isset($_POST['URL']) && (!empty($_POST['URL'])))
            {
                \YAWK\settings::setSetting($db, "host", $_POST['URL'], $lang);
            }
            if (isset($_POST['TITLE']) && (!empty($_POST['TITLE'])))
            {
                \YAWK\settings::setSetting($db, "title", $_POST['TITLE'], $lang);
            }
            if (isset($_POST['DESC']) && (!empty($_POST['DESC'])))
            {
                \YAWK\settings::setSetting($db, "globalmetatext", $_POST['DESC'], $lang);
            }
            echo"<div class=\"container-fluid animated fadeIn\">
                          <div class=\"row\">
                            <div class=\"jumbotron\" style=\"height: 100%;\">
                                <div class=\"col-md-8 text-justify\">
                                    <h2>YaWK <small>$lang[INSTALLATION]</small></h2>
                                    <h4>$lang[STEP] $_POST[step]/5 <small>$lang[ACCOUNT_SETTINGS]</small></h4>
                                    <hr><h4>$lang[USER] $lang[SETTINGS]</h4>
                                    <label for=\"EMAIL\">$lang[EMAIL] <small><i>$lang[EMAIL_SUBTEXT]</i></small></label>
                                    <input type=\"text\" class=\"form-control\" name=\"EMAIL\" id=\"EMAIL\" placeholder=\"$setup[ADMIN_EMAIL]\">
                                    <label for=\"USERNAME\">$lang[USERNAME] <small><i>$lang[USERNAME]</i></small></label>
                                    <input type=\"text\" class=\"form-control\" name=\"USERNAME\" id=\"USERNAME\" placeholder=\"$setup[ADMIN_USER]\" value=\"admin\">
                                    <label for=\"PASSWORD\">$lang[PASSWORD] <small><i>$lang[PASSWORD]</i></small></label>
                                    <input type=\"text\" class=\"form-control\" name=\"PASSWORD\" id=\"PASSWORD\" placeholder=\"$setup[ADMIN_PASS]\">
                                    <label for=\"PASSWORD2\">$lang[PASSWORD] <small><i>($lang[REPEAT])</i></small></label>
                                    <input type=\"text\" class=\"form-control\" name=\"PASSWORD2\" id=\"PASSWORD2\" placeholder=\"$setup[ADMIN_PASS]\">
                                    <br>
                                    <input type=\"hidden\" name=\"step\" value=\"5\">
                                    <input type=\"hidden\" name=\"currentLanguage\" value=\"$language->currentLanguage\">
                                    <button type=\"submit\" class=\"btn btn-success pull-right\"><small>$_POST[step]/5</small> &nbsp;$lang[NEXT_STEP] &nbsp;<i class=\"fa fa-arrow-right\"></i></button>
                                   
                                </div>
                                <div class=\"col-md-4 text-justify\">
                                    <br><br><br><br>
                                    <b>$lang[ACCOUNT_NOTICE]</b><br>
                                    $lang[ACCOUNT_NOTICE_INFO]
                                    <br><br><br>
                                    <b>$lang[STEP5]</b><br>
                                </div>
                            </div>
                          </div>
                          </div>";
        }

        public function step5($lang)
        {
            // include database and settings class
            if (!isset($db)) {
                require_once('system/classes/db.php');
                $db = new \YAWK\db();
            }

            if (isset($_POST['EMAIL']) && (!empty($_POST['EMAIL'])))
            {
                \YAWK\settings::setSetting($db, "admin_email", $_POST['EMAIL'], $lang);
            }
            if (isset($_POST['USERNAME']) && (!empty($_POST['USERNAME'])))
            {
                if (\YAWK\user::create($db, $_POST['USERNAME'], $_POST['PASSWORD'], $_POST['PASSWORD2'], $_POST['EMAIL'], "", "", "", "", "", "", "", "", "", 0, 1, "Administrator", 5) === "false")
                {
                    \YAWK\alert::draw("danger", "Failed to add user to database", "Please go back and try again.", "", "");
                }
                else
                {
                    \YAWK\alert::draw("success", "User $_POST[USERNAME] added.", "Now you are able to login. Welcome o'board Captain!", "", "");
                }
            }
            echo "Installation fertig!";
        }


        /* GET + CHECK functions */


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
            if ($this->apacheVersionStatus === "true")
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
            if ($this->modRewrite === "true")
            {   // ok
                $this->modRewriteCheckIcon = "<i class=\"fa fa-check text-success\"></i>";
                $i++;
            }
            else
            {   // failed
                $this->modRewriteCheckIcon = "<i class=\"fa fa-times text-danger\"></i>";
            }

            // check if
            if ($i < 3)
            {
                $this->serverRequirements = "false";
            }
            else
            {
                $this->serverRequirements = "true";
            }
        }

        public function getLanguageSelectOptions($language)
        {
            $selectOptions = '';
            foreach ($language->supportedLanguages AS $supported)
            {
                if ($language->currentLanguage === "$supported")
                {
                    $selectOptions .= "<option value=\"$supported\" selected>$supported</option>
                                        ";
                }
                else
                    {
                        $selectOptions .= "<option value=\"$supported\">$supported</option>
                        ";
                    }
            }
                return $selectOptions;
        }

        public function checkPhpVersion()
        {
            if (version_compare(phpversion(), '5.0.0', '<')) {
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

        public function checkApacheVersion()
        {
            if ($this->apacheVersion = apache_get_version())
            {
                // ok, apache is set
                $this->apacheVersionStatus = "true";
                return true;
            }
            else
            {   // could not detect apache
                $this->apacheVersionStatus = "false";
                return true;
            }
        }

        /**
         * Check if zlib is available
         * @author      Daniel Retzl <danielretzl@gmail.com>
         * @version     1.0.0
         * @link        http://yawk.io
         * @return bool
         */
        public function checkZlib()
        {   // check if zlib is installed
            if(extension_loaded('zlib'))
            {   // installed
                $this->zlib = "true";
                return true;
            }
            else
            {   // not installed
                $this->zlib = "false";
                return false;
            }
        }

        /**
         * Check if mod_rewrite is available
         * @author      Daniel Retzl <danielretzl@gmail.com>
         * @version     1.0.0
         * @link        http://yawk.io
         * @return bool
         */
        public function checkModRewrite()
        {   // check if zlib is installed
            if(in_array('mod_rewrite', apache_get_modules()))
            {   // installed
                $this->modRewrite = "true";
                return true;
            }
            else
            {   // not installed
                $this->modRewrite = "false";
                return false;
            }
        }

        public function footer()
        {
            echo "<div class=\"container-fluid\">
                    <div class=\"row\">
                    <div class=\"col-md-4\"></div>
                    <div class=\"col-md-4 text-center\"><i class=\"text-center\">(C) ".date('Y')." yawk.io</i></div>
                    <div class=\"col-md-4\"></div>
                    </div>
                  </div>";
        }

        function __destruct() {
            echo "
                </body>
                </html>";
        }
    } // end class installer
} // end namespace
