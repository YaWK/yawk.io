<?php
// include imap client classes
require_once "../system/engines/imapClient/AdapterForOutgoingMessage.php";
require_once "../system/engines/imapClient/Helper.php";
require_once "../system/engines/imapClient/ImapClient.php";
require_once "../system/engines/imapClient/ImapClientException.php";
require_once "../system/engines/imapClient/ImapConnect.php";
require_once "../system/engines/imapClient/IncomingMessage.php";
require_once "../system/engines/imapClient/IncomingMessageAttachment.php";
require_once "../system/engines/imapClient/OutgoingMessage.php";
require_once "../system/engines/imapClient/Section.php";
require_once "../system/engines/imapClient/SubtypeBody.php";
require_once "../system/engines/imapClient/TypeAttachments.php";
require_once "../system/engines/imapClient/TypeBody.php";

// let php know we need these classes:
use SSilence\ImapClient\ImapClientException;
use SSilence\ImapClient\ImapClient as Imap;

use YAWK\alert;
use YAWK\backend;
use YAWK\db;
use YAWK\language;
use YAWK\settings;
use YAWK\webmail;

/** @var $db db */
/** @var $lang language */

// get all webmail setting values into an array
$webmailSettings = settings::getValueSettingsArray($db, "webmail_");

// imap connection only made be made if webmail is set to active
// check if webmail is activated
if ($webmailSettings['webmail_active'] == true)
{   // webmail enabled, get mailbox settings

    // mailbox server (imap.server.tld)
    $server = $webmailSettings['webmail_imap_server'];
    // mailbox user (email@server.tld)
    $username = $webmailSettings['webmail_imap_username'];
    // mailbox password
    $password = $webmailSettings['webmail_imap_password'];
    // encryption type (ssl, tsl, null)
    $encryption = "/" . $webmailSettings['webmail_imap_encrypt'];
    // port (default: 993)
    $port = ":" . $webmailSettings['webmail_imap_port'];
    // start at email no
    $imapStart = $webmailSettings['webmail_imap_start'];
    // amount of emails to be retrieved
    $imapAmount = $webmailSettings['webmail_imap_amount'];
    // amount of emails to be retrieved
    $imapMsgTypes = $webmailSettings['webmail_imap_msgtypes'];
    // sortation asc | desc
    $imapSortation = $webmailSettings['webmail_imap_sortation'];
    // novalidate-cert
    $novalidate = $webmailSettings['webmail_imap_novalidate'];

    // include webmail class
    require_once "../system/classes/webmail.php";
    // create new webmail object
    $webmail = new webmail();
    // set connection info var
    $webmail->connectionInfo = "<i>$username</i>";

    $options = array($novalidate);

    try // open connection to imap server
    {
        // create new imap handle
        $imap = new Imap($server.$port.$encryption, $username, $password, $encryption, 0, 0, $options);
        // connection successful, error = false
        $error = false;
        $errorMsg = '';

        // webmail page called with parameter - user requested a folder
        if (isset($_GET['folder']) && (!empty($_GET['folder']) && (is_string($_GET['folder']))))
        {    // select requested folder
            $imap->selectFolder($_GET['folder']);
            // set current folder string
            $imap->currentFolder = $_GET['folder'];
        }
        else // webmail page called w/o any parameters
        {   // select default folder
            $imap->selectFolder('INBOX');
            $imap->currentFolder = "INBOX";
        }
    }
    // open imap connection failed...
    catch (ImapClientException $error)
    {   // no errors in production...
        $webmail->connectionInfo = $error->getMessage() . PHP_EOL;
        // exit with error
        $error = true;
        $errorMsg = 'Oh no! Verbindung mit server: '.$server.' als user: '.$username.' nicht moeglich!';
        $imap = NULL;
    }


    // DELETE ACTION: delete single message
    if (isset($_GET['deleteMessage']) && ($_GET['deleteMessage'] == true))
    {   // delete message
        if ($webmail->deleteMessage($imap, $_GET['folder'], $_GET['uid']))
        {   // email deleted
            alert::draw("success", "Email deleted", "The email was deleted", "", 1200);
        }
        else
            {   // failed to delete email
                alert::draw("danger", "ERROR:", "Unable to delete email", "", 2800);
            }
    }

    // PURGE FOLDER: delete all messages in this folder
    if (isset($_GET['purgeTrash']) && ($_GET['purgeTrash'] == true))
    {   // purge folder
        $imap->selectFolder("Trash");
        if ($webmail->purgeTrash($imap))
        {   // email deleted
            alert::draw("success", "Mailbox cleaned", "The trash and spam folders were cleaned up", "", 1200);
        }
        else
        {   // failed to delete email
            alert::draw("danger", "ERROR:", "Unable to purge trash and spam folder", "", 2800);
        }
    }
}
else    // webmail is not activated...
    {   // leave vars empty
        $webmail = "";
        $imap = "";
        $imapStart = "";
        $imapSortation = "";
        $imapAmount = "";
        $imapMsgTypes = "";
        $error = "";
        $errorMsg = "";
    }
?>
<!-- JS: load data tables -->
<script type="text/javascript">
    $(document).ready(function() {
        $('#table-sort').dataTable({
            "bPaginate": false,
            "bLengthChange": false,
            "bFilter": true,
            "bSort": true,
            "bInfo": true,
            "bAutoWidth": false
        });

    });

    // make whole table row clickable
    $('#table-sort tr').click(function() {
        var href = $(this).find("a").attr("href");
        if(href) {
            window.location = href;
        }
    });


    /**
     * Mark specific email as seen / unseen.
     * @param msgno the affected message number
     * @param state setSeen|setUnseen
     */
    function markAsSeen(msgno, state){
        $.ajax({
            type: "POST",
            url: 'js/webmail-markAsSeen.php',
            data: {msgno: msgno, state:state},
            success: function(data){
                // alert(data);

                // envelope icon element
                let seenIcon = $('#seenIcon_'+msgno);
                let seenIconLink = $('#seenIconLink_'+msgno);
                let mailboxName = $('#mailboxName_'+msgno);
                let mailboxSubject = $('#mailboxSubject_'+msgno);
                let newMessagesLabel = $('#newMessagesLabel');
                // get value from new message label, remove first 2 chars (+&nbsp;)
                let labelCount = $(newMessagesLabel).text().slice(2);

                // the email icon in the top navbar
                let envelopeLabel = $('#envelope-label');

                // remove icon class
                $(seenIcon).removeClass();

                // state setSeen requested
                if (state === 'setSeen')
                {   // set html markup for seen message (light text)
                    $(seenIcon).addClass('fa fa-envelope-open-o text-muted');
                    $(mailboxName).removeClass().addClass('mailbox-name');
                    $(mailboxSubject).removeClass().addClass('mailbox-subject');
                    // change function call to make it toggle correctly
                    $(seenIconLink).attr("onclick",'markAsSeen('+msgno+', \'setUnseen\')');

                    // update new messages label value
                    // if there are more mails than 0
                    if (labelCount > 1)
                    {
                        // subtract 1 from label counter
                        labelCount--;
                        // update new mails label counter
                        $(newMessagesLabel).text('+ '+labelCount);
                        // set navbar icon
                        $(envelopeLabel).text(labelCount);
                    }
                    else
                        {   // no more new mails - fade out label
                            $(newMessagesLabel).text('+ 0');
                            $(newMessagesLabel).fadeOut();
                            $(envelopeLabel).fadeOut();
                        }
                }
                else
                    {   // set html markup for unseen message (bold text)
                        $(seenIcon).addClass('fa fa-envelope text-muted');
                        $(mailboxName).removeClass().addClass('mailbox-name text-bold');
                        $(mailboxSubject).removeClass().addClass('mailbox-subject text-bold');
                        // change function call to make it toggle correctly
                        $(seenIconLink).attr("onclick",'markAsSeen('+msgno+', \'setSeen\')');

                        // if there are more mails than 0
                        if (labelCount > 0)
                        {   // subtract 1 from label counter
                            labelCount++;
                            // update new mails label counter
                            $(newMessagesLabel).text('+ '+labelCount);
                            $(envelopeLabel).text(labelCount);
                            console.log('LABEL COUNTER:' +labelCount);
                        }
                        else
                        {   // no more new mails - fade out label
                            $(newMessagesLabel).text('+ 1');
                            $(envelopeLabel).fadeIn();
                            $(newMessagesLabel).fadeIn();
                        }
                    }
            }
        });
    }

    /**
     * Mark specific email as flagged (mark as important with star)
     * @param uid the affected mail uid
     * @param state setSeen|setUnseen
     */
    function markAsFlagged(uid, state){
        // alert('mark as unread clicked for uid '+uid+'');
        $.ajax({
            type: "POST",
            url: 'js/webmail-setFlagged.php',
            data: {uid: uid, state:state},
            success: function(data){
                // alert(data);

                // envelope icon element
                let starIcon = $('#starIcon_'+uid);
                let starIconLink = $('#starIconLink_'+uid);

                // remove icon class
                $(starIcon).removeClass();

                // state setFlagged
                if (state === 'setFlagged')
                {   // set html markup for flagged message (light text)
                    $(starIcon).addClass('fa fa-star text-orange');
                    // change function call to make it toggle correctly
                    $(starIconLink).attr("onclick",'markAsFlagged('+uid+', \'setUnFlagged\')');
                }

                // state setFlagged
                else if (state === 'setUnFlagged')
                {   // set html markup for flagged message (light text)
                    $(starIcon).addClass('fa fa-star-o text-orange');
                    // change function call to make it toggle correctly
                    $(starIconLink).attr("onclick",'markAsFlagged('+uid+', \'setFlagged\')');
                }
            }
        });
    }

    /**
     * Move a specific email (uid) from folder to targetFolder
     * @param uid the affected mail uid
     * @param folder source folder
     * @param targetFolder target folder
     */
    function moveMessage(uid, folder, targetFolder){
        $.ajax({
            type: "POST",
            url: 'js/webmail-moveMessage.php',
            data: {uid: uid, folder:folder, targetFolder:targetFolder},
            success: function(data){
                // alert(data);

                // set html element vars
                let emailRow = $('#emailRow_'+uid);
                // update message count (beside folder overview)
                let messageCountSourceElement = $('#messageCount_'+folder+' small');
                let messageCountSource = $(messageCountSourceElement).text().slice(1,-1);
                let messageCountTargetElement = $('#messageCount_'+targetFolder+' small');
                let messageCountTarget = $(messageCountTargetElement).text().slice(1,-1);
                // subtract -1 from message count source folder
                messageCountSource--;
                // add +1 to message count target folder
                messageCountTarget++;
                // re-write message source count to element
                $(messageCountSourceElement).text('('+messageCountSource+')');
                // re-write message target count to element
                $(messageCountTargetElement).text('('+messageCountTarget+')');

                // fadeOut table row that contains moved email
                $(emailRow).removeClass().addClass('animated fadeOutRight');
                $(emailRow).fadeOut();
            }
        });
    }

    /**
     * Delete a specific message (finally)
     * @param uid the affected message uid number
     * @param folder the current folder
     */
    function deleteMessage(uid, folder){
        $.ajax({
            type: "POST",
            url: 'js/webmail-deleteMessage.php',
            data: {uid:uid, folder:folder},
            success: function(data){
               // alert(data);
                // envelope icon element
                var newMessagesLabel = $('#newMessagesLabel');
                // get value from new message label, remove first 2 chars (+&nbsp;)
                var labelCount = $(newMessagesLabel).text().slice(2);
                // the email icon in the top navbar
                var envelopeLabel = $('#envelope-label');
                // the current email row
                var emailRow = $('#emailRow_'+uid);

                // update message count (beside folder overview)
                var messageCountElement = $('#messageCount_'+folder+' small');
                var messageCount = $(messageCountElement).text().slice(1,-1);
                // subtract -1 from message count
                messageCount--;
                // re-write message count to element
                $(messageCountElement).text('('+messageCount+')');

                // slide + fadeOut affected email table row
                $(emailRow).removeClass().addClass('animated fadeOutRight');
                $(emailRow).fadeOut();

                // update new messages label value
                // if there are more mails than 0
                if (labelCount > 1)
                {
                    // subtract 1 from label counter
                    labelCount--;
                    // update new mails label counter
                    $(newMessagesLabel).text('+ '+labelCount);
                    // set navbar icon
                    $(envelopeLabel).text(labelCount);
                }
                else
                {   // no more new mails - fade out label
                    $(newMessagesLabel).text('+ 0');
                    $(newMessagesLabel).fadeOut();
                    $(envelopeLabel).fadeOut();
                }
            }
        });
    }
</script>

<?php
// TEMPLATE WRAPPER - HEADER & breadcrumbs
echo "
    <!-- Content Wrapper. Contains page content -->
    <div class=\"content-wrapper\" id=\"content-FX\">
    <!-- Content Header (Page header) -->
    <section class=\"content-header\">";
/* draw Title on top */
echo backend::getTitle($lang['WEBMAIL'], $lang['WEBMAIL_SUBTEXT']);
echo"<ol class=\"breadcrumb\">
            <li><a href=\"index.php\" title=\"$lang[DASHBOARD]\"><i class=\"fa fa-dashboard\"></i> $lang[DASHBOARD]</a></li>
            <li class=\"active\"><a href=\"index.php?page=webmail\" title=\"$lang[WEBMAIL]\"> $lang[WEBMAIL]</a></li>
         </ol>
    </section>
    <!-- Main content -->
    <section class=\"content\">";
/* page content start here */
// check if there was a connection error
if (isset($error) && ($error == true))
{   // output error message
    echo $errorMsg;
}
// draw webmail only, of webmal is set to active...
if ($webmailSettings['webmail_active'] == true && ($error == false))
{
?>
<div class="row">
    <div class="col-md-3">
        <!-- left col -->
        <a href="index.php?page=webmail-compose" class="btn btn-success btn-large" style="width: 100%;">Write a message</a><br><br>
        <div class="box box-default animated fadeIn">
            <div class="box-header with-border">
                <h3 class="box-title">Folders</h3>

                <div class="box-tools">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="box-body no-padding" style="">
                <ul class="nav nav-pills nav-stacked">
                    <?php
                        /** @var $imap \SSilence\ImapClient\ImapClient */
                        $webmail->drawFolders($imap, $imap->getFolders());
                    ?>
                </ul>
            </div>
            <!-- /.box-body -->
        </div>
    </div> <!-- /. left col -->

    <div class="col-md-9 animated fadeIn">
        <!-- right col -->
        <div class="box box-secondary">
            <div class="box-header with-border">
                <h3 class="box-title"><?php echo $imap->currentFolder; ?> </h3>
                <?php echo "<small>".$webmail->connectionInfo."</small>"; ?>
                <!-- search box -->
                <div class="box-tools pull-right">
                    <div class="has-feedback">
                        <input type="text" class="form-control input-sm" placeholder="Deep Search">
                        <span class="glyphicon glyphicon-search form-control-feedback"></span>
                    </div>
                </div>
                <!-- /.box-tools -->
            </div>
            <!-- /.box-header -->
            <div class="box-body no-padding">
                <div class="mailbox-controls">
                    <?php $webmail->drawMailboxControls($imap, "inbox", 0, $imap->currentFolder, $lang); ?>
                </div>
                <div class="table-responsive mailbox-messages">
                    <table class="table table-striped table-hover table-responsive" id="table-sort">
                        <thead>
                        <tr>
                            <td><div class="icheckbox_flat-blue" aria-checked="false" aria-disabled="false" style="position: relative; width: 100%"><input type="checkbox" style="position: absolute; opacity: 0;"><ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins></div></td>
                            <td class="mailbox-star"></td>
                            <td class="mailbox-star"></td>
                            <td class="mailbox-name"><?php echo $lang['SENDER_FROM']; ?></td>
                            <td class="mailbox-subject"><?php echo $lang['SUBJECT']; ?></td>
                            <td class="mailbox-attachment"></td>
                            <td class="mailbox-date"><?php echo $lang['DATE']; ?></td>
                            <td class="mailbox-star"></td>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                            $emails = array();
                            // CURRENT:
                            $imap->selectFolder($imap->currentFolder);
                            $emails = $imap->getMessages($imapAmount, $imapStart, $imapSortation, $imapMsgTypes);
                            $webmail->drawHeaders($emails, $imap->currentFolder, $lang);
                        ?>
                        </tbody>
                    </table>
                    <!-- /.table -->
                </div>
                <!-- /.mail-box-messages -->
            </div>
            <!-- /.box-body -->
            <div class="box-footer no-padding">
                <?php $webmail->drawMailboxControls($imap, "inbox", 0, $imap->currentFolder, $lang); ?>
            </div>
        </div> <!-- /. box secondary -->
    </div> <!-- /. right col -->
</div> <!-- /. row -->
<?php
    // close current imap connection
    $imap->close();
}
else
    {   // webmail not enabled
        echo "<h4>".$lang['WEBMAIL_NOT_ENABLED']."</h4>";
    }
?>