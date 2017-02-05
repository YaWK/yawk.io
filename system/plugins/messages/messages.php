<?php
if (!isset($db) || (empty($db)))
{
    include 'system/plugins/messages/classes/db.php';
    $db = new \YAWK\db();
}
// check if language is set
if (!isset($language) || (!isset($lang)))
{   // inject (add) language tags to core $lang array
    $lang = \YAWK\language::inject(@$lang, "../system/plugins/gallery/language/");
}

include 'system/plugins/messages/classes/messages.php';
$messages = new \YAWK\PLUGINS\MESSAGES\messages($db, "frontend");
echo $messages->init($db, $lang);
