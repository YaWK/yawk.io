<?php
/* logout.php
 * call logout method and tell em goodbye 
 */

use YAWK\alert;
use YAWK\backend;
use YAWK\db;
use YAWK\language;
use YAWK\user;

/** @var $db db */
/** @var $lang language */
if (!isset($user))
{
  $user = new user($db);
}
  $user->logout($db);
  backend::drawContentWrapper();
  alert::draw("success", "$lang[THANK_YOU]&nbsp;&nbsp;$_SESSION[username]! ","$lang[LOGOUT_MSG]", "","8000");
  backend::setTimeout("index.php","1600");