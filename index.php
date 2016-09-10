<?php
session_start();
/* Error Reporting - this is for DEVELOPMENT PURPOSE ONLY! */
error_reporting(E_ALL ^ E_STRICT);
ini_set('display_errors', 1);
//error_reporting(0);
/* include core files */
include('system/classes/db.php');               // database connection
include('system/classes/settings.php');         // get/set settings from settings db
include('system/classes/alert.php');            // draw fancy JS-notification alert class
include('system/classes/email.php');            // email functions
include('system/classes/user.php');             // all get/set/handle user functions
include('system/classes/page.php');             // all get/set/handle page functions
include('system/classes/menu.php');             // all get/set/handle menu functions
include('system/classes/widget.php');           // all get/set/handle widget functions
include('system/classes/template.php');         // all template functions, including get/set template settings
include('system/classes/sys.php');              // basic i/o and helper functions
include('system/classes/controller.php');       // frontEnd init and filename filter controller

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
    $signup = new \YAWK\PLUGINS\SIGNUP\signup();
    echo $signup->sayHello($db);
}

// URL controller - this loads the properties of each page */
if (isset($_GET['include']) && (!empty($_GET['include']))) {
    // URL is set and not empty - lets go, load properties for given page
    $currentpage->loadProperties($db, $db->quote($_GET['include']));

    // different GET controller actions can be done here...
    // LOGOUT SENT VIA GET (yourdomain.com/logout)
    if ($_GET['include'] === "logout") {   // start logout procedure
        if ($user->logout($db))
        {
            // say goodbye
            \YAWK\alert::draw("success", "Goodbye $_SESSION[username]", "See you next time!", "index.html", 4200);
            // redirect to index page
            // \YAWK\sys::setTimeout("index.html","0");
            exit;
        }
    }
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
