<?php
/* logout.php
 * call logout method and tell em goodbye 
 */
if (!isset($user))
{
  $user = new \YAWK\user();
}
  $user->logout($db);
  \YAWK\backend::drawContentWrapper();
  \YAWK\alert::draw("success", "$lang[THANK_YOU]&nbsp;&nbsp;$_SESSION[username]! ","$lang[LOGOUT_MSG]", "","8000");
  \YAWK\backend::setTimeout("index.php","1600");