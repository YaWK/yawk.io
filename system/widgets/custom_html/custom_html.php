<?php
// check if db obj exits
if (!isset($db) || (empty($db)))
{   // if not, create new db obj
    $db = new \YAWK\db();
}
// check if customHtmlCode obj is loaded
if(!isset($customHtml) || (empty($customHtml)))
{
    // if not, include customHtmlCode widget class
    require_once ('classes/custom_html.php');
    // create customHtmlCode widget object
    $customHtml = new \YAWK\WIDGETS\CUSTOM_HTML\CODE\customHtml($db);
}
// init current customHtmlCode
$customHtml->init();
