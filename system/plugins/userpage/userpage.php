<?php
/** SIGNUP PLUGIN */
include 'system/plugins/userpage/classes/userpage.php';
if (!isset($user) || (empty($user)))
{
    $user = new \YAWK\user();
}
$userpage = new \YAWK\PLUGINS\USERPAGE\userpage($db, $user);
$userpage->init($db, $user);