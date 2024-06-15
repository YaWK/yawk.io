<?php

use YAWK\alert;
use YAWK\backend;
use YAWK\sys;
use YAWK\settings;

session_start();
header('Cache-control: private');             // OLD IE (6+) FIX
error_reporting(E_ALL ^ E_STRICT);         // just for development purpose!!!
ini_set('display_errors', 1);           // DISPLAY ALL ERRORS - DEVELOPMENT ONLY!!!
// error_reporting(0);                              // no error reporting
$loadingTime = microtime(true);              // scripting start time (var gets used for benchmark, if enabled)

/* include controller classes */
require_once '../system/classes/db.php';            // database
require_once '../system/classes/AdminLTE.php';      // admin LTE backend
require_once '../system/classes/alert.php';         // custom alert and info boxes
require_once '../system/classes/settings.php';      // (system) settings class
require_once '../system/classes/language.php';      // language class
require_once '../system/classes/backend.php';       // backend methods and helpers
require_once '../system/classes/dashboard.php';     // dashboard methods
require_once '../system/classes/user.php';          // user class: methods to add, edit, modify users
require_once '../system/classes/page.php';          // pages class: methods to add edit, modify pages
require_once '../system/classes/menu.php';          // menu class: methods to add, edit, display menus
require_once '../system/classes/email.php';         // simple email helper class
require_once '../system/classes/plugin.php';        // plugin class: methods to handle and interact w plugins
require_once '../system/classes/widget.php';        // widget class: methods to handle and interact w widgets
require_once '../system/classes/template.php';      // template class: methods to add, edit and handle templates
require_once '../system/classes/controller.php';    // basic controller class
require_once '../system/classes/filemanager.php';   // filemanager class: methods to add, edit, upload and handle files
require_once '../system/classes/sys.php';           // system class: methods and helpers for overall system use
require_once '../system/classes/update.php';        // update class: functions used to update the system
// PREPARE OBJECTS
// database object
if (!isset($db))
{   // create new db obj if none exists
    $db = new \YAWK\db();
}
// language object
if (!isset($lang) || (empty($lang)))
{   // create new language obj if none exists
    $language = new YAWK\language();
    // init language
    $language->init($db, "backend");
    // convert object param to array !important
    $lang = (array) $language->lang;
}

// user object
if (!isset($user))
{   // create new user obj if none exists
    $user = new \YAWK\user($db);
}

// page object
if (!isset($page))
{   // create new page obj if none exists
    $page = new \YAWK\page();
}

// Admin LTE Backend
if (!isset($AdminLTE))
{
    // create AdminLTE object
    $AdminLTE = new \YAWK\BACKEND\AdminLTE($db);
    // html head (html start, js includes asf...)
    echo $AdminLTE->drawHtmlHead();

    // only show this, if session login is set and true
    if (isset($_SESSION['logged_in']) && ($_SESSION['logged_in'] === true))
    {
        // check if username, session and user id are set
        if (isset($_SESSION['username']) && (isset($_SESSION['gid']) && (isset($_SESSION['uid']))))
        {
            // get user properties
            $user->loadProperties($db, $_SESSION['username']);

            // draw AdminLTE Template from top to bottom
            // body markup
            echo $AdminLTE->drawHtmlBody();
            // logo markup
            echo $AdminLTE->drawHtmlLogo($db, $lang);
            // navbar start
            echo $AdminLTE->drawHtmlNavbar();
            // navbar right menu start
            echo $AdminLTE->drawHtmlNavbarRightMenu();

            // navbar: draw preview icon
            echo $AdminLTE->drawHtmlNavbarBackupIcon($lang);

            // navbar: draw preview icon
            echo $AdminLTE->drawHtmlNavbarPreviewIcon($lang);

            // check if messaging is enabled
            if (\YAWK\settings::getSetting($db, "backendMessagesMenu") == 1)
            {   // ok, draw msg icon and message navbar in upper right corner
                echo $AdminLTE->drawHtmlNavbarMessagesMenu($db, $lang);
            }

            // check if webmail is enabled
            if (\YAWK\settings::getSetting($db, "webmail_active") == 1)
            {   // ok, draw msg icon and message navbar in upper right corner
                echo $AdminLTE->drawHtmlNavbarWebmailMenu($db, $lang);
            }

            // check, if backend notification is enabled
            if (\YAWK\settings::getSetting($db, "backendNotificationMenu") == 1)
            {   // draw notification menu, in upper right corner
                echo $AdminLTE->drawHtmlNavbarNotificationsMenu($db, $user, $lang);
            }

            // user account menu
            echo $AdminLTE->drawHtmlNavbarUserAccountMenu($db, $user);
            // end navbar header
            echo $AdminLTE->drawHtmlNavbarHeaderEnd();
            // left sidebar (main menu)
            echo $AdminLTE->drawHtmlLeftSidebar($db, $user, $lang);
            // content header
            echo $AdminLTE->drawHtmlContentHeader($lang);
            // content breadcrumbs
            echo $AdminLTE->drawHtmlContentBreadcrumbs();
            // html content (main page)
            echo $AdminLTE->drawHtmlContent($db, $lang, $user);

            // check, if footer should be displayed
            if (\YAWK\settings::getSetting($db, "backendFooter") == 1)
            {   // draw footer at bottom of page
                echo $AdminLTE->drawHtmlFooter($db);
            }

            // right sidebar
            echo $AdminLTE->drawHtmlRightSidebar($lang);
            // additional js includes at the bottom
            echo $AdminLTE->drawHtmlJSIncludes();
            // html end
            echo $AdminLTE->drawHtmlEnd($db);
        }
        else
        {
            // session username, gid and / or user is is not set - throw alert and draw login box
            alert::draw("warning", "Warning :", "It seems that you are not logged in correctly. Please try to re-login!","","8000");
        }
    }
    else
    {
      // user is not logged in - set a basic body markup and display login box
      // body markup
      $backendSkin = settings::getSetting($db, 'backendSkin');
      // check if skin is available
        if (!file_exists("../system/engines/AdminLTE/css/skins/$backendSkin.min.css"))
        {   // if not, check if no minified version is available
            if (!file_exists("../system/engines/AdminLTE/css/skins/$backendSkin.css"))
            {   // if not, set default skin
                $backendSkin = "skin-wp-style.min.css";
            }
        }

        echo "<body>
";
        // apply correct skin
        echo '<link rel="stylesheet" href="../system/engines/AdminLTE/css/skins/'.$backendSkin.'.min.css">';

        // reset password email request
        if (isset($_POST['resetPasswordRequest']))
        {
            if (!empty($_POST['number1'] && (!empty($_POST['number2']) && (!empty($_POST['captcha'])))))
            {
                $number1 = $_POST['number1'];
                $number2 = $_POST['number2'];
                $captcha = $_POST['captcha'];
                if ($captcha != ($number1 + $number2))
                {   // error: captcha failed
                    alert::draw("danger", $lang['ERROR'], $lang['CAPTCHA_FAILED'], "", 3800);
                }
                else
                {   // captcha solved, send reset email
                    if ($user::sendResetEmail($db, $_POST['username'], $_POST['email'], $lang) == true)
                    {   // email sent
                        alert::draw("success", "$lang[EMAIL_SENT]", "$lang[PLEASE_CHECK_YOUR_INBOX]", "", 2400);
                    }
                    else
                    {   // error: sending reset email failed
                        alert::draw("danger", $lang['ERROR'], $lang['PASSWORD_RESET_FAILED'], "", 3800);
                    }
                }
            }
        }

        // reset password requested (from email link)
        if (isset($_GET['resetPassword'])) {
            // check if reset token is set
            if (!empty($_GET['token']) && (is_string($_GET['token']))) {
                // check if sent token is equal to saved token
                if ($user::checkResetToken($db, $_GET['token']) === true) {
                    // draw reset password form
                    echo $_GET['token'];
                    // echo \YAWK\backend::drawPasswordResetForm($db, $lang);
                    // end section markup
                    echo "<br><br></section></div>";
                    // output js includes at bottom of page
                    echo $AdminLTE->drawHtmlJSIncludes();
                    // html output end
                    echo $AdminLTE->drawHtmlEnd($db);
                    exit;
                }
                else {   // ERROR: token does not match with database - throw error
                    alert::draw("danger", $lang['ERROR'], $lang['PASSWORD_RESET_TOKEN_INVALID'], "", 3800);
                }
            }
        }

            // check if the current user is logged in
            if (backend::checkLogin($db) === false)
            {
                // USER BAN (client side)
                // if the user has failed to login more than 5 times, ban them for 60 minutes
                if (!isset($_SESSION['failed']))
                {   // prepare session var
                    $_SESSION['failed'] = 0;
                }
                if (!isset($_SESSION['lockout_until']))
                {   // reset lockout time
                    $_SESSION['lockout_until'] = 0;
                }

                if (isset($_POST['user']) && (!empty($_POST['user']))){
                    $user->currentuser = $_POST['user'];
                }

                // do not allow login attempts if the user is currently banned
                if (time() < $_SESSION['lockout_until'])
                {   // inform the user that he is banned
                    alert::draw("danger", "ACCESS DENIED", "You have reached the maximum number of login attempts. You have been banned for 60 minutes.<br>Your IP ".$_SERVER['REMOTE_ADDR']." / ".$_SERVER['REMOTE_HOST']." has been logged.", "", 0);
                    // add syslog entry
                    sys::setSyslog($db, 12, 2, "Possible brute force client ".$_SERVER['REMOTE_ADDR']." ".$_SERVER['REMOTE_HOST']." banned.", 0, 0, 0, 0);
                }
                else
                {   // draw login box
                    echo backend::drawLoginBox($db, $lang);
                }
                // end section markup
                echo "<br><br></section></div>";

                // output js includes at bottom of page
                echo $AdminLTE->drawHtmlJSIncludes();

                // html output end
                echo $AdminLTE->drawHtmlEnd($db);
                exit;
            }
            else {
                // add syslog entry for successful login
                alert::draw("success", $lang['SUCCESS'], $lang['LOGIN']." ".$lang['SUCCESSFUL'], "index.php", 1200);
            }
    }




        // draw login box
       // echo \YAWK\backend::drawLoginBox($db, $lang);
// end section markup
//    echo "<br><br></section></div>";
//
//// output js includes at bottom of page
//    echo $AdminLTE->drawHtmlJSIncludes();
//
//// html output end
//    echo $AdminLTE->drawHtmlEnd($db);
//    exit;

}
/* END /admin index controller */
