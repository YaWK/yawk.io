<?php
// check if db obj exits
if (!isset($db) || (empty($db)))
{   // if not, create new db obj
    $db = new \YAWK\db();
}
// check if embedPage obj is loaded
if(!isset($embedPage) || (empty($embedPage)))
{
    // if not, include embedPage widget class
    require_once ('classes/embedPage.php');
    // create embedPage widget object
    $embedPage = new \YAWK\WIDGETS\EMBED_PAGE\PAGE\embedPage($db);
}
// init current embedPage
$embedPage->init();