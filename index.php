<?php
/**
 * @details <b>Index.php - the main entry point (controller) of the website's frontend</b>
 *
 * First of all, the session gets started, error reporting is set, followed by
 * including all required classes (because its faster than SPLautoload).
 * Afterwards, a handful of objects will be created:
 * <ul>
 * <li>\YAWK\db</li>
 * <li>\YAWK\template</li>
 * <li>\YAWK\user</li>
 * <li>\YAWK\page</li>
 * <li>\YAWK\controller</li>
 * <li>\YAWK\stats</li>
 * </ul>
 * <p>Those objects are holding all data used by the frontend. Additional
 * you can use any of that many static methods from other classes. See class
 * overview for details about how YaWK is organized.</p>
 *
 * @author     Daniel Retzl <danielretzl@gmail.com>
 * @copyright  2016 Daniel Retzl http://yawk.website
 * @license    http://www.gnu.org/licenses/gpl-3.0  GNU/GPL 3.0
 * @version    1.0.0
 * @link       http://yawk.website
 * @since      File available since Release 1.0.0
 * @brief  Index.php - the main entry point (controller) of the website's frontend
 *
 */

use YAWK\controller;
use YAWK\db;
use YAWK\page;
use YAWK\PLUGINS\SIGNUP\signup;
use YAWK\settings;
use YAWK\stats;
use YAWK\sys;
use YAWK\template;
use YAWK\user;

session_start();
header('Cache-control: private');             // IE 6 FIX
error_reporting(E_ALL ^ E_STRICT);          // just for development purpose!!!
ini_set('display_errors', 1);            // DISPLAY ALL ERRORS - DEVELOPMENT ONLY!!!
error_reporting(1);                         // no error reporting
/* include core files */
require_once('system/classes/db.php');               // database connection
require_once('system/classes/settings.php');         // get/set settings from settings db
require_once 'system/classes/language.php';          // language class
require_once('system/classes/alert.php');            // draw fancy JS-notification alert class
require_once('system/classes/email.php');            // email functions
require_once('system/classes/user.php');             // all get/set/handle user functions
require_once('system/classes/page.php');             // all get/set/handle page functions
require_once('system/classes/menu.php');             // all get/set/handle menu functions
require_once('system/classes/widget.php');           // all get/set/handle widget functions
require_once('system/classes/template.php');         // all template functions, including get/set template settings
require_once('system/classes/sys.php');              // basic i/o and helper functions
require_once('system/classes/controller.php');       // frontEnd init and filename filter controller
require_once('system/classes/stats.php');            // statistics functions
/* set database object */
if (!isset($db)) {
    $db = new db();
}

/* language object */
if (empty($lang))
{   // create new language obj if none exists
    $language = new YAWK\language();
    // init language
    $language->init($db, "frontend");
    // convert object param to array !important
    $lang = (array) $language->lang;
}

/* set template object */
if (!isset($template)) {
    $template = new template();
}
/* set user object */
if (!isset($user)) {
    $user = new user($db);
}
/* set page object */
if (!isset($page)) {
    $page = new page();
    $currentpage = $page;
}
/* set controller object */
if (!isset($controller)) {
    $controller = new controller();
}
/* set stats object */
if (!isset($stats)) {
    $stats = new stats();
    $stats->setStats($db);
}
// lets go with the frontEnd...
// \YAWK\sys::outputObjects($template, $language, $controller, $page, $user, $stats);
// \YAWK\controller::frontEndInit($db, $currentpage, $user, $template);
if (sys::isOffline($db)) {   // backend-users (admins) can see the frontend,
    // while the site is still offline to guests & no-admins
    sys::drawOfflineMessage($db);
    exit;
}
// check if user wants to register (signUp)
if (isset($_GET['signup']) && ($_GET['signup']) == 1) {
    include('system/plugins/signup/classes/signup.php');
    $signup = new signup();
    echo $signup->sayHello($db, $lang);
}

// URL controller - this loads the properties of each page */
if (isset($_GET['include']) && (!empty($_GET['include'])))
{   // LOGOUT SENT VIA GET (yourdomain.com/logout)
    if ($_GET['include'] === "logout")
    {   // start logout procedure
        if ($user->logout($db) === true)
        {   // redirect user to index page
            sys::setTimeout("index.html", 0);
            exit;
        }
    }
    // user filled out login form
    if (isset($_POST['login']))
    {   // check given vars
        if (isset($_POST['user']) && (isset($_POST['password'])))
        {   // check if user login was successful
            if ($user->login($db, $_POST['user'], $_POST['password']) === true)
            {   // check if custom redirect url after login is requested
                if (isset($_POST['loginboxRedirect']) && (!empty($_POST['loginboxRedirect'])))
                {   // redirect to custom url
                    if (isset($_POST['loginboxRedirectTime'])
                        && (!empty($_POST['loginboxRedirectTime'])
                            && (is_numeric($_POST['loginboxRedirectTime']))))
                    {   // delay before redirect
                        sys::setTimeout($_POST['loginboxRedirect'], $_POST['loginboxRedirectTime']);
                    }
                    else
                    {   // redirect w/o delay
                        sys::setTimeout($_POST['loginboxRedirect'], 0);
                    }
                }
                else
                {   // redirect to index page (only in html mode)
                    $_GET['include'] = "index";
                }
            }
        }
    }

    // URL is set and not empty - lets go, load properties for given page
    $page->loadProperties($db, $db->quote($_GET['include']));

    // more different GET controller actions can be done here...
}
else
{   // if no page is given, set index as default page
    $_GET['include'] = "index";
    // and load properties for it
    $page->loadProperties($db, $db->quote($_GET['include']));
}
if (!empty($_GET['templateID'])){
    $template->id = $_GET['templateID'];
}
else {
// get global selected template ID
    $template->id = settings::getSetting($db, "selectedTemplate");
}

// set template
$template->selectedTemplate = $template->id;

// set template loading mechanism, depending on state and settings (user is logged in, allowed to override etc...)
if (user::isAnybodyThere($db))
{   // user seems to be logged in...
    // load template name from {users}
    $user->loadProperties($db, $_SESSION['username']);

    // check if user is allowed to overrule selectedTemplate
    if ($user->overrideTemplate == 1)
    {
        // frontendSwitch (dark / light mode)
        if (isset($_COOKIE["frontendSwitchID"])){
            $user->templateID = json_decode(stripslashes($_COOKIE['frontendSwitchID']));
        }

        // set user template ID to session
        $_SESSION['userTemplateID'] = $user->templateID;

        // get template by user templateID
        $template->name = template::getTemplateNameById($db, $user->templateID);
        // include page, based on user templateID
        $tplPath = 'system/templates/'.$template->name.'/index.php';

        // check if user template is loadable
        if (is_file($tplPath))
        {   // load properties for user overridden template
            $template->loadProperties($db, $user->templateID);
            // load user template
            include($tplPath);
        }
        else
        {   // user template is not loadable
            die("Unable to include user overriden template ID ".$user->templateID." (".$template->name.") from template path: ".$tplPath." <br>Either database config is faulty or Template ID: (".$user->templateID.") is not correctly installed.");
        }
    }
    else
    {   // DEFAULT (GLOBAL) TEMPLATE
        // user is not allowed to overrule template, show global default (selectedTemplate) instead.

        // frontendSwitch (dark / light mode)
        if (isset($_COOKIE["frontendSwitchID"]))
        {   // set user selected template from dark/light mode frontendSwitch
            $template->selectedTemplate = json_decode(stripslashes($_COOKIE['frontendSwitchID']));
        }
        // get template name and build path
        $template->name = template::getTemplateNameById($db, $template->selectedTemplate);
        $tplPath = "system/templates/".$template->name."/index.php";
        if (is_file($tplPath))
        {   // load properties for default template
            $template->loadProperties($db, $template->selectedTemplate);
            // load global default (admin selected template)
            include($tplPath);
        }
        else
        {   // user = logged in, default template not loadable
            die("Unable to include default template ID ".$user->templateID." (".$template->name.") for logged in user from path: ".$tplPath." <br>Either database config is faulty or selected Template ID: (".$user->templateID.") is not correctly installed.");
        }
    }
}
else
{   // user is NOT logged in, load default template (selectedTemplate) from settings db
    // frontendSwitch (dark / light mode)
    if (isset($_COOKIE["frontendSwitchID"]))
    {   // set user selected template from dark/light mode frontendSwitch
        $template->selectedTemplate = json_decode(stripslashes($_COOKIE['frontendSwitchID']));
    }

    $template->name = template::getTemplateNameById($db, $template->selectedTemplate);
    $tplPath = "system/templates/".$template->name."/index.php";

    if (is_file($tplPath))
    {   // load properties for default template
        $template->loadProperties($db, $template->selectedTemplate);
        include ($tplPath);
    }
    else
    {   // no user logged in, default template not loadable
        die("Unable to include default template ID ".$template->selectedTemplate." (".$template->name.") for guest user from path: ".$tplPath." <br>Either database config is faulty or selected Template ID: (".$user->templateID.") is not correctly installed.");
    }
}
