<?php
// check if language is set
if (!isset($language) || (!isset($lang)))
{   // inject (add) language tags to core $lang array
    $lang = \YAWK\language::inject(@$lang, "../system/plugins/faq/language/");
}
include '../system/plugins/faq/classes/faq-backend.php';
if (!isset($faq))
{   // crate object
    $faq = new \YAWK\PLUGINS\FAQ\faq();
}
if (isset($_GET['delete']))
{   // delete faq entry/item
    if (isset($_GET['id']))
    {   //
        if ($faq->delete($db, $_GET['id']))
        {   // success
            print \YAWK\alert::draw("success", "$lang[SUCCESS]", "$lang[ENTRY] " . $_GET['id'] . " $lang[DELETED]", "plugin=faq","2000");
        }
        else
        {   // delete item failed, throw error
            print \YAWK\alert::draw("danger", "$lang[ERROR]", "$lang[ENTRY] ".$_GET['id']." $lang[NOT_DELETED]", "plugin=faq","3800");
        }
    }
}