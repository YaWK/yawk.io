<?php
session_start();
header('Cache-control: private'); // IE 6 FIX
error_reporting(E_ALL ^ E_STRICT); // just for development purpose!!!
ini_set('display_errors', 1); // DISPLAY ALL ERRORS - DEVELOPMENT ONLY!!!
$loadingTime = microtime(true); // script running start time

/* include controller classes */
include '../system/classes/db.php';
include '../system/classes/AdminLTE.php';
include '../system/classes/alert.php';
include '../system/classes/settings.php';
include '../system/classes/language.php';
include '../system/classes/backend.php';
include '../system/classes/user.php';
include '../system/classes/page.php';
include '../system/classes/menu.php';
include '../system/classes/email.php';
include '../system/classes/plugin.php';
include '../system/classes/widget.php';
include '../system/classes/template.php';
include '../system/classes/controller.php';
include '../system/classes/filemanager.php';
include '../system/classes/sys.php';

/* set language object */
if (!isset($lang)) {
  $lang = new YAWK\language();
  $lang->init();
}
/* set database object */
if (!isset($db)) {
  $db = new \YAWK\db();
}
/* set user object */
if (!isset($user)) {
  $user = new \YAWK\user();
}
/* set user object */
if (!isset($page)) {
  $page = new \YAWK\page();
}

/* set AdminLTE object */
if (!isset($AdminLTE)) {
  $AdminLTE = new \YAWK\AdminLTE($db);
  echo $AdminLTE->drawHtmlHead();

  \YAWK\backend::checkLogin($db);

  if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true)
  {
    if (isset($_SESSION['username']) && (isset($_SESSION['gid']) && (isset($_SESSION['uid']))))
    {
      // get user properties
      $user->loadProperties($db, $_SESSION['username']);
      echo $AdminLTE->drawHtmlBody();
      echo $AdminLTE->drawHtmlLogo($db);
      echo $AdminLTE->drawHtmlNavbar();
      echo $AdminLTE->drawHtmlNavbarRightMenu();
      if (\YAWK\settings::getSetting($db, "backendMessagesMenu") == 1)
      {   // draw messages menu, if enabled
          echo $AdminLTE->drawHtmlNavbarMessagesMenu($db);
      }
      if (\YAWK\settings::getSetting($db, "backendNotificationMenu") == 1)
      {   // draw notification menu, if enabled
          echo $AdminLTE->drawHtmlNavbarNotificationsMenu($db, $user);
      }
      echo $AdminLTE->drawHtmlNavbarUserAccountMenu($db, $user);
      echo $AdminLTE->drawHtmlNavbarHeaderEnd();
      echo $AdminLTE->drawHtmlLeftSidebar($db, $user);
      echo $AdminLTE->drawHtmlContentHeader($lang);
      echo $AdminLTE->drawHtmlContentBreadcrumbs();
      echo $AdminLTE->drawHtmlContent($db, $lang, $user);
      if (\YAWK\settings::getSetting($db, "backendFooter") == 1)
      {   // draw footer, if enabled
          echo $AdminLTE->drawHtmlFooter();
      }
      echo $AdminLTE->drawHtmlRightSidebar();
      echo $AdminLTE->drawHtmlJSIncludes();
      echo $AdminLTE->drawHtmlEnd($db);
    }
    else
    { // throw error
      \YAWK\alert::draw("warning", "Warning :", "It seems that you are not logged in correctly. Please try to re-login!","","3800");
    }
  }
  else
  {   // user is not logged in -> throw login page
    // include 'includes/login.php';
    echo "<body style=\"background-color: #ecf0f5\">";
    echo \YAWK\backend::drawLoginBox($db, "YaWK LTE", "", "");
    echo "<br><br></section></div>";
    echo $AdminLTE->drawHtmlJSIncludes();

    if (\YAWK\backend::checkLogin($db)){

    }
    echo $AdminLTE->drawHtmlEnd($db);
    exit;
  }
}

/* END index controller */