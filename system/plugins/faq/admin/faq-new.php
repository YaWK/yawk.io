<?php
include '../system/plugins/faq/classes/faq-backend.php';
if (isset($_POST['create']))
{   // if faq object is not set
    if (!isset($faq))
    {   // create new faq object
        $faq = new \YAWK\PLUGINS\FAQ\faq();
    }
    if (!empty($_POST['question']))
    {   // escape post vars
        $faq->question = $db->quote($_POST['question']);
    }
    else
    {   // question is empty
        $faq->question = '';
    }
    if (!empty($_POST['answer']))
    {   // escape post var
        $faq->answer = $db->quote($_POST['answer']);
    }
    else
    {   // question is empty
        $faq->answer = '';
    }

    if ($faq->create($db, $faq->question, $faq->answer))
    {   // success
        print \YAWK\alert::draw("success", "Erfolg!", "FAQ Eintrag wurde erfolgreich angelegt.","plugin=faq","2000");
        exit;
    }
    else
    {   // create faq failed, throw error
        \YAWK\alert::draw("danger", "Fehler!", "Faq Eintrag konnte nicht angelegt werden.", "plugin=faq&pluginpage=faq-new","2400");
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
            <li class=\"active\"><a href=\"index.php?plugin=faq&pluginpage=faq-new\" title=\"Add Question\"> Add Question</a></li>
         </ol>
    </section>
    <!-- Main content -->
    <section class=\"content\">";
    /* page content start here */

?>
<form action="index.php?plugin=faq&pluginpage=faq-new" role="form" method="POST"
      xmlns="http://www.w3.org/1999/html" xmlns="http://www.w3.org/1999/html">
<div class="box box-default">
    <div class="box-body">
        <div class="box-header with-border">
            <h3 class="box-title"><?php echo $lang['FAQ_ADD']; ?></h3>
        </div>
        <div class="box-body">
    <input name="create" value="faq-create" type="hidden"/>
    <textarea class="form-control" cols="55" rows="1" name="question"><?PHP echo $lang['FAQ_QUESTION']; ?></textarea><br>
    <textarea class="form-control" cols="55" rows="4" name="answer"><?PHP echo $lang['FAQ_ANSWER']; ?></textarea><br>
    <input id="savebutton" class="btn btn-success" type="submit" name="create" value="FAQ&nbsp;Eintrag&nbsp;anlegen"/>&nbsp;


        </div>
    </div>
</div>
</form>