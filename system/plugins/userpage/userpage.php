<?php
/** SIGNUP PLUGIN */
include 'system/plugins/userpage/classes/userpage.php';
if (!isset($user) || (empty($user)))
{
    $user = new \YAWK\user($db);
}
if (!isset($lang) || (empty($lang)))
{
    $lang = new \YAWK\language();
}
$userpage = new \YAWK\PLUGINS\USERPAGE\userpage($db, $user);
$userpage->init($db, $user, $lang);