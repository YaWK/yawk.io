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
        public function init()
        {
            // run server checks and save status variables
            self::checkServerRequirements();

            // get install data into array
            if ($setup = parse_ini_file("install.ini", FALSE))
            {   // if INSTALL is set to true
                if ($setup['INSTALL'] === "true")
                {   // if no step variable is set, setup run for the first time
                    if (!isset($_POST['step']) || (empty($_POST['step'])))
                    {   // STEP 1
                        // display language selector
                        echo "";
                    }

                    if (isset($_POST['step']) && $_POST['step'] === "1")
                    {

                    }
                    echo "
                          <div class=\"container-fluid animated fadeIn\">
                          <div class=\"row\">
                            <div class=\"jumbotron\" style=\"height: 100%;\">
                                <div class=\"col-md-4 text-justify\">
                                    &nbsp;
                                </div>
                                
                                <div class=\"col-md-4\">
                                    <h2>YaWK <small>Installation</small></h2>
                                    <h4>Schritt 1/3 <small>Vorbereitung</small></h4>
                                    <hr>
                                    <label for=\"language\">Sprache w&auml;hlen</label>
                                    <select class=\"form-control\" id=\"language\" name=\"language\">
                                        <option value=\"\" selected disabled aria-disabled=\"true\">Sprache w&auml;hlen</option>
                                        <option value=\"en-EN\">English (en-EN)</option>
                                        <option value=\"de-DE\">German (de-DE)</option>
                                    </select>
                                    <br><br>
                                    <h4>MySQL Zugangsdaten</h4>
                                    <label for=\"DB_HOST\">Hostname <small><i>(sehr oft http://localhost)</i></small></label>
                                    <input type=\"text\" class=\"form-control\" name=\"DB_HOST\" id=\"DB_HOST\" value=\"$setup[DB_HOST]\">
                                    
                                    <label for=\"DB_NAME\">Datenbank <small><i>(mysql database name)</i></small></label>
                                    <input type=\"text\" class=\"form-control\" name=\"DB_NAME\" id=\"DB_NAME\" value=\"$setup[DB_NAME]\">
                                    
                                    <label for=\"DB_USER\">Benutzername <small><i>(mysql username)</i></small></label>
                                    <input type=\"text\" class=\"form-control\" name=\"DB_USER\" id=\"DB_USER\" value=\"$setup[DB_USER]\">
                                    
                                    <label for=\"DB_PASS\">Passwort <small><i>(mysql password)</i></small></label>
                                    <input type=\"password\" class=\"form-control\" name=\"DB_PASS\" id=\"DB_PASS\" value=\"$setup[DB_PASS]\">
                                    
                                    <label for=\"DB_PREFIX\">Prefix <small><i>(mysql prefix)</i></small></label>
                                    <input type=\"text\" class=\"form-control\" name=\"DB_PREFIX\" id=\"DB_PREFIX\" value=\"$setup[DB_PREFIX]\">
                                    
                                    <br>";
                                    if ($this->serverRequirements === "true")
                                    {
                                        echo "<button type=\"submit\" class=\"btn btn-success pull-right\">Next step &nbsp;<i class=\"fa fa-arrow-right\"></i></button>";
                                    }
                                    else
                                    {
                                        echo "<button type=\"submit\" class=\"btn btn-warning pull-right\" disabled aria-disabled=\"true\">Next step &nbsp;<i class=\"fa fa-arrow-right\"></i></button>";
                                    }
                                    
                                echo"</div>
                                
                                <div class=\"col-md-4 text-justify\">
                                
                                <br><br><br><br>
                                <b>Installationshinweise</b><br>
                                Es sind nur wenige Schritte n&ouml;tig um die Installation erfolgreich abzuschliessen. 
                                Du ben&ouml;tigst Zugangsdaten f&uuml;r Deine MySQL Datenbank. Wenn Du keine Zugangsdaten
                                hast, pr&uuml;fe Deine Emails oder befrage Deinen Webhoster.
                                
                                <br><br><br>
                                <b>Systemanforderungen</b><br>
                                <ul class=\"list-unstyled\">
                                    <li>$this->phpCheckIcon PHP 5.x <small><i><small>(verwendet: ".phpversion().")</small></i></small></li>
                                    <li>$this->apacheCheckIcon Apache 2.x <small><i><small>(verwendet: ".apache_get_version().")</small></i></small></li>
                                        <ul class=\"list-unstyled small\">
                                            <li>&nbsp;&nbsp;&nbsp;&nbsp;$this->zlibCheckIcon +mod_gzip <small><i>(verf&uuml;gbar: ".$this->zlib.") </i></small></li>
                                            <li>&nbsp;&nbsp;&nbsp;&nbsp;$this->modRewriteCheckIcon +mod_rewrite <small><i>(verf&uuml;gbar: ".$this->modRewrite.") </i></small></li>
                                        </ul>
                                </ul><br>";
                                
                                if ($this->serverRequirements === "true")
                                {
                                    echo "<h4 class=\"text-success\">Der Server erf&uuml;llt alle Anforderungen.</h4>";
                                }
                                else
                                    {
                                        echo "<h4 class=\"text-danger\">Der Server erf&uuml;llt leider nicht alle Anforderungen.</h4>";
                                    }
                                echo"</div> <!-- end col -->
                            </div> <!-- end jumbotron -->
                          </div> <!-- end row -->
                          </div> <!-- end container -->
                          </form>";
                }
            }
                else
                    {
                        echo "Install failed: Status of install.ini is not true";
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
