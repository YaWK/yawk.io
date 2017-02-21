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
            echo "<html>
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
    </head>
    <body>
    <form method=\"POST\" action=\"index.php\">
    ";
        }

        /**
         * Check if installation is needed
         *
        */
        public function init($lang)
        {   /* CHECK + SET LANGUAGE */
            // include language class
            /* check if language object is set*/
            if (!isset($language) || (empty($language)))
            {   // set new language object
                $language = new \YAWK\language();
                // try tp get the client language
                if (isset($_POST['currentLanguage']))
                {
                    $language->currentLanguage = $_POST['currentLanguage'];
                }
                else
                    {
                        $language->currentLanguage = $language->getClientLanguage();
                    }
                // set the path to the language file
                $language->pathToFile = "admin/language/";
                // set current active language
                $language->setLanguage($language->currentLanguage);
                // convert language object param to array $lang[] that contains all the data
                $lang = (array)$language->lang;
            }

            // run server checks and save status variables
            self::checkServerRequirements();

            // get install data into array
            if ($setup = parse_ini_file("install.ini", FALSE))
            {   // if INSTALL is set to true
                if ($setup['INSTALL'] === "true")
                {   // if no step variable is set, setup run for the first time
                    if (!isset($_POST['step']) || (empty($_POST['step'])))
                    {   // STEP 1 -- LANGUAGE SELECTION
                        // display language selector
                        $_POST['step'] = 1;
                        echo "
                                <div class=\"container-fluid animated fadeIn\">
                                <div class=\"row\">
                                    <div class=\"jumbotron\" style=\"height: 100%;\">
                                        <div class=\"col-md-4 text-justify\">
                                            &nbsp;
                                        </div>
                                        <div class=\"col-md-4\">
                                            <h2>YaWK <small>$lang[INSTALLATION]</small></h2>
                                            <h4>$lang[STEP] $_POST[step]/5 <small>$lang[PREPARATION]</small></h4>
                                            <hr>
                                            <label for=\"currentLanguage\">$lang[LANG_LABEL]</label>
                                            <select class=\"form-control\" id=\"currentLanguage\" name=\"currentLanguage\">
                                                <option value=\"\" selected disabled aria-disabled=\"true\">$lang[SELECT_LANGUAGE]</option>
                                                <option value=\"en-EN\">English (en-EN)</option>
                                                <option value=\"de-DE\">German (de-DE)</option>
                                            </select>
                                            <br>
                                            <button class=\"btn btn-success pull-right\" type=\"submit\"><small>$_POST[step]/5</small> &nbsp;$lang[NEXT_STEP] &nbsp;<i class=\"fa fa-arrow-right\"></i></button>
                                            <input type=\"hidden\" name=\"step\" value=\"2\">
                                        </div>
                                    </div>
                                </div>
                                </div>";
                        exit;
                    }

                    // STEP 2 -- MySQL DATA
                    if (isset($_POST['step']) && $_POST['step'] === "2")
                    {
                    echo "
                          <div class=\"container-fluid animated fadeIn\">
                          <div class=\"row jumbotron\">
                            <div class=\"jumbotron\" style=\"height: 100%;\">
                                <div class=\"col-md-4 text-justify\">
                                    &nbsp;
                                </div>
                                
                                <div class=\"col-md-4\">
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
                                    <input type=\"text\" class=\"form-control\" name=\"DB_PASS\" id=\"DB_PASS\" value=\"$setup[DB_PASS]\">
                                    
                                    <label for=\"DB_PREFIX\">$lang[DB_PREFIX] <small><i>$lang[DB_PREFIX_SUBTEXT]</i></small></label>
                                    <input type=\"text\" class=\"form-control\" name=\"DB_PREFIX\" id=\"DB_PREFIX\" value=\"$setup[DB_PREFIX]\">
                                    
                                    <label for=\"DB_PORT\">$lang[DB_PORT] <small><i>$lang[DB_PORT_SUBTEXT]</i></small></label>
                                    <input type=\"text\" class=\"form-control\" name=\"DB_PORT\" id=\"DB_PORT\" value=\"$setup[DB_PORT]\">
                                    
                                    <br>
                                    <button type=\"button\" class=\"btn btn-default\" onClick=\"history.go(-1);return true;\"><i class=\"fa fa-arrow-left\"></i> &nbsp;$lang[BACK]</button>
                                    ";
                                    if ($this->serverRequirements === "true")
                                    {
                                        echo "<button type=\"submit\" class=\"btn btn-success pull-right\"><small>$_POST[step]/5</small> &nbsp;$lang[NEXT_STEP] &nbsp;<i class=\"fa fa-arrow-right\"></i></button>";
                                    }
                                    else
                                    {
                                        echo "<button type=\"submit\" class=\"btn btn-warning pull-right\" disabled aria-disabled=\"true\"><small>$_POST[step]/5</small> &nbsp;$lang[NEXT_STEP] &nbsp;<i class=\"fa fa-arrow-right\"></i></button>";
                                    }
                                    
                                echo"<input type=\"hidden\" name=\"step\" value=\"3\">
                                     <input type=\"hidden\" name=\"currentLanguage\" value=\"$language->currentLanguage\">
                                     </div>
                                
                                <div class=\"col-md-4 text-justify\">
                                
                                <br><br><br><br>
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
                                {
                                    echo "<h4 class=\"text-success\">$lang[SERVER_REQ_TRUE]</h4>";
                                }
                                else
                                    {
                                        echo "<h4 class=\"text-danger\">$lang[SERVER_REQ_FALSE]</h4>";
                                    }
                                echo"<b>$lang[DB_CHECK]</b></div> <!-- end col -->
                            </div> <!-- end jumbotron -->
                          </div> <!-- end row -->
                          </div> <!-- end container -->
                          </form>";
                    } // end STEP 2

                    // STEP 3 - WEBSITE & PROJECT DATA
                    if (isset($_POST['step']) && $_POST['step'] === "3")
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
                            require_once('system/classes/settings.php');
                            require_once('system/classes/alert.php');
                            require_once('system/classes/email.php');

                            // ok, lets test the database connection...
                            if ($db->connect())
                            {
                                echo "Datenbank $_POST[DB_NAME] ist erreichbar.";
                            }


                            exit;


                            echo"<div class=\"container-fluid animated fadeIn\">
                          <div class=\"row\">
                            <div class=\"jumbotron\" style=\"height: 100%;\">
                                <div class=\"col-md-4 text-justify\">
                                    &nbsp;
                                </div>
                                <div class=\"col-md-4 text-justify\">
                                    <h2>YaWK <small>$lang[INSTALLATION]</small></h2>
                                    <h4>$lang[STEP] $_POST[step]/5 <small>$lang[PROJECT_SETTINGS]</small></h4>
                                    <hr>
                                    <h4>$lang[COMMON_PROJECT_SETTINGS]</h4>
                                    <label for=\"DB_HOST\">$lang[DB_HOST] <small><i>(sehr oft http://localhost)</i></small></label>
                                    <input type=\"text\" class=\"form-control\" name=\"DB_HOST\" id=\"DB_HOST\" value=\"$setup[DB_HOST]\">
                                    <br>
                                    <input type=\"hidden\" name=\"currentLanguage\" value=\"$language->currentLanguage\">
                                    <button type=\"button\" class=\"btn btn-success pull-right\"><small>$_POST[step]/5</small> &nbsp;$lang[NEXT_STEP] &nbsp;<i class=\"fa fa-arrow-right\"></i></button>
                                   
                                </div>
                                <div class=\"col-md-4 text-justify\">
                                    <br><br><br><br>
                                    <b>$lang[PROJECT_SETTINGS]</b><br>
                                    $lang[INSTALL_NOTICE]
                                    <br><br><br>
                                    <b>$lang[SYS_REQ]</b><br>
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

                        // more of step 3...
                    }
                }
            }
                else
                    {
                        echo "Install failed: Status of install.ini is not true. You modified something or the package was corrupt. Please try to delete, re-download and re-install the whole package.";
                        exit;
                    }
                    // prevent display anything else
                    exit;
        }


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

        function __destruct() {
            echo "
                </body>
                </html>";
        }
    } // end class installer
} // end namespace
