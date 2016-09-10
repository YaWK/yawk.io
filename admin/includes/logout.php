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
  \YAWK\alert::draw("success", "Thank you $_SESSION[username]! ","See you next time - check back soon!", "","8000");
  \YAWK\backend::setTimeout("index.php","1600");