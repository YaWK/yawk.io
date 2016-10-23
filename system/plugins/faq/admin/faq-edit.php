<?php
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
        echo YAWK\alert::draw("success", "Hooray!", "Der FAQ-Eintrag wurde erfolgreich aktualisiert!","plugin=faq","2000");
        exit;
    }
    else
    {   // save faq item failed, throw error
        echo YAWK\alert::draw("danger", "Fehler", "Der FAQ Eintrag " . $faq->question . " konnte nicht aktualisiertwerden.", "","4200");
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
            <li><a href=\"index.php\" title=\"Dashboard\"><i class=\"fa fa-dashboard\"></i> Dashboard</a></li>
            <li><a href=\"index.php?page=plugins\" title=\"Plugins\"> Plugins</a></li>
            <li><a href=\"index.php?plugin=faq\" title=\"Faq\"> Faq</a></li>
            <li class=\"active\"><a href=\"index.php?plugin=faq&pluginpage=faq-edit\" title=\"Edit Question\"> Edit Question</a></li>
        </ol>
    </section>
    <!-- Main content -->
    <section class=\"content\">";
?>

<form action="index.php?plugin=faq&pluginpage=faq-edit&id=<?PHP echo $_GET['id']; ?>" role="form" method="POST"
      xmlns="http://www.w3.org/1999/html" xmlns="http://www.w3.org/1999/html">
    <div class="box box-default">
    <div class="box-header with-border">
        <h3 class="box-title"><?PHP echo "$lang[FAQ] <small>$lang[EDIT]"; ?></h3>
    </div>
        <div class="box-body">
            <input name="create" value="faq-create" type="hidden">
            <input type="text" name="sort" class="form-control" value="<?PHP echo $faq->sort; ?>"><br>
            <textarea class="form-control" cols="55" rows="1" name="question"><?PHP echo $faq->question; ?></textarea><br>
            <textarea class="form-control" cols="55" rows="4" name="answer"><?PHP echo $faq->answer; ?></textarea><br>
            <input id="savebutton" class="btn btn-success" type="submit" name="save" value="FAQ&nbsp;Eintrag&nbsp;bearbeiten">&nbsp;
        <br><br>
        </div>
    </div>
</form>