<?php
// check if language is set
if (!isset($language) || (!isset($lang)))
{   // inject (add) language tags to core $lang array
    $lang = \YAWK\language::inject(@$lang, "../system/plugins/messages/language/");
}
// TEMPLATE WRAPPER - HEADER & breadcrumbs
echo "
    <!-- Content Wrapper. Contains page content -->
    <div class=\"content-wrapper\" id=\"content-FX\">
    <!-- Content Header (Page header) -->
    <section class=\"content-header\">";
/* draw Title on top */
echo \YAWK\backend::getTitle($lang['MSG_MAILBOX'], $lang['MSG_INBOX_SUBTITLE']);
echo"<ol class=\"breadcrumb\">
            <li><a href=\"index.php\" title=\"$lang[DASHBOARD]\"><i class=\"fa fa-dashboard\"></i> $lang[DASHBOARD]</a></li>
            <li><a href=\"index.php?page=plugins\" title=\"$lang[PLUGINS]\"> $lang[PLUGINS]</a></li>
            <li><a href=\"index.php?plugin=messages\" title=\"$lang[MESSAGING]\"> $lang[MESSAGING]</a></li>
            <li class=\"active\"><a href=\"index.php?plugin=messages&pluginpage=mailbox\" title=\"Mailbox\"> $lang[MAILBOX]</a></li>
         </ol>
    </section>
    <!-- Main content -->
    <section class=\"content\">";
?>
<a class="btn btn-default pull-right" title="<?php echo $lang['REFRESH'];?>" href="index.php?plugin=messages&pluginpage=mailbox">
<i class="fa fa-refresh"></i></a>

<a class="btn btn-success pull-right" title="<?php echo $lang['MSG_COMPOSE'];?>" href="index.php?plugin=messages&pluginpage=mailbox&active=compose">
<i class="fa fa-plus"></i> &nbsp;<?php print $lang['MSG_COMPOSE']; ?></a>


<?php
/* page content start here */
include '../system/plugins/messages/classes/messages.php';
$messages = new \YAWK\PLUGINS\MESSAGES\messages($db, "backend");

// check if a msg ID is sent via GET
if (isset($_GET['msg_id']) && is_numeric($_GET['msg_id']))
{   // single message view
    echo $messages->MessageView($db, $_GET['msg_id'], $lang);
}
else
// no message to display
{   // therefor init mailbox
    echo $messages->init($db, $lang);
}