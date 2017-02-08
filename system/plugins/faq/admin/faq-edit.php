<?php
// check if language is set
if (!isset($language) || (!isset($lang)))
{   // inject (add) language tags to core $lang array
    $lang = \YAWK\language::inject(@$lang, "../system/plugins/faq/language/");
}
include '../system/plugins/faq/classes/faq-backend.php';
/* page content start here */
if (!isset($faq))
{   // create object, if its not set
    $faq = new \YAWK\PLUGINS\FAQ\faq();
}
if (!isset($db))
{   // include database
    include '../system/classes/db.php';
}
// load faq properties
$faq->loadItemProperties($db, $_GET['id']);

// if user clicked on save
if (isset($_POST['save']))
{   // escape post vars
    $faq->id = $db->quote($_GET['id']);
    $faq->sort = $db->quote($_POST['sort']);
    $faq->question = $db->quote($_POST['question']);
    $faq->answer = $db->quote($_POST['answer']);

    if ($faq->save($db))
    {   // success
        echo YAWK\alert::draw("success", "$lang[SUCCESS]", "$lang[FAQ_SAVE_OK]","plugin=faq","2000");
        exit;
    }
    else
    {   // save faq item failed, throw error
        echo YAWK\alert::draw("danger", "$lang[ERROR]", "$lang[FAQ_SAVE_FAILED] : " . $faq->question . " ", "","4200");
        exit;
    }
}

// TEMPLATE WRAPPER - HEADER & breadcrumbs
echo "
<!-- Content Wrapper. Contains page content -->
<div class=\"content-wrapper\" id=\"content-FX\">
    <!-- Content Header (Page header) -->
    <section class=\"content-header\">";
        /* draw Title on top */
        echo \YAWK\backend::getTitle($lang['FAQ'], $lang['FAQ_SUBTEXT']);
        echo"<ol class=\"breadcrumb\">
            <li><a href=\"index.php\" title=\"$lang[DASHBOARD]\"><i class=\"fa fa-dashboard\"></i> $lang[DASHBOARD]</a></li>
            <li><a href=\"index.php?page=plugins\" title=\"$lang[PLUGINS]\"> $lang[PLUGINS]</a></li>
            <li><a href=\"index.php?plugin=faq\" title=\"$lang[FAQ]\"> $lang[FAQ]</a></li>
            <li class=\"active\"><a href=\"index.php?plugin=faq&pluginpage=faq-edit\" title=\"$lang[EDIT_QUESTION]\"> $lang[EDIT_QUESTION]</a></li>
        </ol>
    </section>
    <!-- Main content -->
    <section class=\"content\">";
?>

<form action="index.php?plugin=faq&pluginpage=faq-edit&id=<?php echo $_GET['id']; ?>" role="form" method="POST"
      xmlns="http://www.w3.org/1999/html" xmlns="http://www.w3.org/1999/html">
    <div class="box box-default">
    <div class="box-header with-border">
        <h3 class="box-title"><?php echo "$lang[FAQ] <small>$lang[EDIT]"; ?></h3>
    </div>
        <div class="box-body">
            <input name="create" value="faq-create" type="hidden">
            <input type="text" name="sort" class="form-control" value="<?php echo $faq->sort; ?>"><br>
            <textarea class="form-control" cols="55" rows="1" name="question"><?php echo $faq->question; ?></textarea><br>
            <textarea class="form-control" cols="55" rows="4" name="answer"><?php echo $faq->answer; ?></textarea><br>
            <input id="savebutton" class="btn btn-success" type="submit" name="save" value="<?php echo $lang['FAQ_EDIT_BTN']; ?>">&nbsp;
        <br><br>
        </div>
    </div>
</form>