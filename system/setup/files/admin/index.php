<?php
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

    // check if the current user is logged in
    \YAWK\backend::checkLogin($db);

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
            \YAWK\alert::draw("warning", "Warning :", "It seems that you are not logged in correctly. Please try to re-login!","","8000");
        }
    }
    else
    {
        // user is not logged in - set a basic body markup and display login box
        // body markup
        echo "<body style=\"background-color: #ecf0f5\">";

        // reset password email request
        if (isset($_POST['resetPasswordRequest']) && ($_POST['resetPasswordRequest'] == "true"))
        {   // send reset email
            if ($user::sendResetEmail($db, $_POST['username'], $_POST['email'], $lang) == true)
            {   // email sent
                \YAWK\alert::draw("success", "$lang[EMAIL_SENT]", "$lang[PLEASE_CHECK_YOUR_INBOX]", "", 2400);
            }
            else
            {   // error: sending reset email failed
                \YAWK\alert::draw("danger", $lang['ERROR'], $lang['PASSWORD_RESET_FAILED'], "", 3800);
            }
        }

        // reset password requested
        if (isset($_GET['resetPassword']) && (!empty($_GET['resetPassword']) && ($_GET['resetPassword'] === true)))
        {
            // check if reset token is set
            if (isset($_GET['token']) && (!empty($_GET['token']) && (is_string($_GET['token']))))
            {
                // check if sent token is equal to saved token
                if ($user::checkResetToken($db, $_GET['token']) === true)
                {
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
                else
                {   // ERROR: token does not match with database - throw error
                    \YAWK\alert::draw("danger", $lang['ERROR'], $lang['PASSWORD_RESET_TOKEN_INVALID'], "", 3800);
                }
            }
        }

        // draw login box
        echo \YAWK\backend::drawLoginBox($db, $lang);
        // end section markup
        echo "<br><br></section></div>";

        // output js includes at bottom of page
        echo $AdminLTE->drawHtmlJSIncludes();

        // html output end
        echo $AdminLTE->drawHtmlEnd($db);
        exit;
    }
}
/* END /admin index controller */
