<?php
session_start();
/* Error Reporting - this is for DEVELOPMENT PURPOSE ONLY! */
error_reporting(E_ALL ^ E_STRICT);
ini_set('display_errors', 1);
//error_reporting(0);
/* include core files */
require_once('system/classes/db.php');               // database connection
require_once('system/classes/settings.php');         // get/set settings from settings db
require_once('system/classes/alert.php');            // draw fancy JS-notification alert class
require_once('system/classes/email.php');            // email functions
require_once('system/classes/user.php');             // all get/set/handle user functions
require_once('system/classes/page.php');             // all get/set/handle page functions
require_once('system/classes/menu.php');             // all get/set/handle menu functions
require_once('system/classes/widget.php');           // all get/set/handle widget functions
require_once('system/classes/template.php');         // all template functions, including get/set template settings
require_once('system/classes/sys.php');              // basic i/o and helper functions
require_once('system/classes/controller.php');       // frontEnd init and filename filter controller
/* set database object */
if (!isset($db)) {
    $db = new \YAWK\db();
}
/* set template object */
if (!isset($template)) {
    $template = new \YAWK\template();
}
/* set user object */
if (!isset($user)) {
    $user = new \YAWK\user();
}
/* set page object */
if (!isset($page)) {
    $currentpage = new \YAWK\page();
}
/* set controller object */
if (!isset($controller)) {
    $controller = new \YAWK\controller();
}
// lets go with the frontEnd...
// \YAWK\controller::frontEndInit($db, $currentpage, $user, $template);
if (\YAWK\sys::isOffline($db)) {   // backend-users (admins) can see the frontend,
    // while the site is still offline to guests & no-admins
    \YAWK\sys::drawOfflineMessage($db);
    exit;
}
// check if user wants to register (signUp)
if (isset($_GET['signup']) && ($_GET['signup']) == 1) {
    include('system/plugins/signup/classes/signup.php');
    $signup = new \YAWK\PLUGINS\SIGNUP\signup();
    echo $signup->sayHello($db);
}
// URL controller - this loads the properties of each page */
if (isset($_GET['include']) && (!empty($_GET['include'])))
{
    // LOGOUT SENT VIA GET (yourdomain.com/logout)
    if ($_GET['include'] === "logout")
    {   // start logout procedure
        if ($user->logout($db) === true)
        {   // redirect user to index page
            \YAWK\sys::setTimeout("index.html", 0);
            exit;
        }
    }
    // user filled out login form
    if (isset($_POST['login']))
    {   // check given vars
        if (isset($_POST['user']) && (isset($_POST['password'])))
        {
            if ($user->login($db, $_POST['user'], $_POST['password']) === true)
            {
                $_GET['include'] = "index";
            }
        }
    }
    // URL is set and not empty - lets go, load properties for given page
    $currentpage->loadProperties($db, $db->quote($_GET['include']));

    // different GET controller actions can be done here...
}
else
{   // if no page is given, set index as default page
    $_GET['include'] = "index";
    // and load properties for it
    $currentpage->loadProperties($db, $db->quote($_GET['include']));
}
// call template controller
$template = $template->getCurrentTemplateName($db, "frontend");
include("system/templates/$template/index.php");