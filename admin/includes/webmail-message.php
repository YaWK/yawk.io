<?php
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

    // get all webmail setting values into an array
    $webmailSettings = \YAWK\settings::getValueSettingsArray($db, "webmail_");

if ($webmailSettings['webmail_active'] == true)
{
    // mailbox server (imap.server.com)
    $server = $webmailSettings['webmail_imap_server'];
    // mailbox user (email@server.com)
    $username = $webmailSettings['webmail_imap_username'];
    // mailbox password
    $password = $webmailSettings['webmail_imap_password'];
    // encryption type (ssl, tsl, null)
    $encryption = "/" . $webmailSettings['webmail_imap_encrypt'];
    // port (default: 993)
    $port = ":" . $webmailSettings['webmail_imap_port'];

    // include webmail class
    require_once "../system/classes/webmail.php";
    // create new webmail object
    $webmail = new \YAWK\webmail();

    try // open connection to imap server
    {   // create new imap object
        $imap = new Imap($server.$port.$encryption, $username, $password, $encryption);
        // store the connection
        $imap->connection = $imap->getImapConnection();

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
    {   // no errors in production
        $webmail->connectionInfo = $error->getMessage() . PHP_EOL;
        // exit with error
        die('oh no! verbindung mit ' . $server . ' als ' . $username . ' nicht moeglich!');
    }

    $msgno = (int)$_GET['msgno'];
    // retrieve message
    $email = $imap->getMessage($msgno);

    // MARK AS UNREAD: set unseen message
    if (isset($_GET['markAsUnread']) && ($_GET['markAsUnread'] == true))
    {
        // mark as unseen
        if ($imap->setUnseenMessage($msgno) == true)
        {   // email marked as unseen
            \YAWK\alert::draw("success", "Marked as unread", "The email was marked as unseen", "", 1200);
        }
        else
        {   // set unseen failed
            \YAWK\alert::draw("warning", "ERROR:", "Unable to mark email as read", "", 2800);
        }
    }
    else    // mark email as seen
    {   // check if mail has been seen
        if ($imap->incomingMessage->header->seen == 0)
        {   // if not, set seen (mark as read)
            $imap->setSeenMessage($msgno);
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
}

?>
<script type="text/javascript">
    $(document).ready(function() {
        $('#table-sort').dataTable({
            "bPaginate": true,
            "bLengthChange": false,
            "bFilter": true,
            "bSort": true,
            "bInfo": true,
            "bAutoWidth": false
        });

        // fa fa-envelope-open-o
        // $('#icon-markAsUnseen').hover.removeClass().addClass('fa fa-envelope-open-o');

        $("#btn-markAsUnseen").hover(
            function() {
                $( "#icon-markAsUnseen" ).removeClass("fa fa-envelope-open-o");
                $( "#icon-markAsUnseen" ).addClass("fa fa-envelope");
            }, function() {
                $("#icon-markAsUnseen").removeClass("fa fa-envelope");
                $("#icon-markAsUnseen").addClass("fa fa-envelope-open-o");
            }
        );
        $("#printButton").click(
            function () {
                $("#emailMessageContent").printThis();
        });
        $("#icon-print").click(
            function () {
                $("#emailMessageContent").printThis();
            });
    });
</script>
<script src="../system/engines/jquery/printThis/printThis.js" type="text/javascript"></script>
<?php
// TEMPLATE WRAPPER - HEADER & breadcrumbs
echo "
    <!-- Content Wrapper. Contains page content -->
    <div class=\"content-wrapper\" id=\"content-FX\">
    <!-- Content Header (Page header) -->
    <section class=\"content-header\">";
/* draw Title on top */
echo \YAWK\backend::getTitle($lang['WEBMAIL'], $lang['WEBMAIL_SUBTEXT']);
echo"<ol class=\"breadcrumb\">
            <li><a href=\"index.php\" title=\"$lang[DASHBOARD]\"><i class=\"fa fa-dashboard\"></i> $lang[DASHBOARD]</a></li>
            <li class=\"active\"><a href=\"index.php?page=widgets\" title=\"$lang[WEBMAIL]\"> $lang[WEBMAIL]</a></li>
         </ol>
    </section>
    <!-- Main content -->
    <section class=\"content\">";
/* page content start here */

// check if webmail is enabled
if ($webmailSettings['webmail_active'] == true) {
    ?>
    <div class="row">
        <div class="col-md-3">
            <!-- left col -->
            <a href="index.php?page=webmail" class="btn btn-success btn-large" style="width: 100%;">Back to
                Inbox</a><br><br>
            <div class="box box-default">
                <div class="box-header with-border">
                    <h3 class="box-title">Folders</h3>

                    <div class="box-tools">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                    class="fa fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="box-body no-padding" style="">
                    <ul class="nav nav-pills nav-stacked">
                        <?php
                        $webmail->drawFolders($imap, $imap->getFolders());
                        ?>

                    </ul>
                </div>
                <!-- /.box-body -->
            </div>

        </div>
        <div class="col-md-9">
            <!-- right col -->
            <div class="box box-secondary" id="emailMessageContent">
                <div class="box-header with-border">
                    <h3><?php echo $imap->incomingMessage->header->subject; ?></h3>

                    <h4>From: <?php echo $imap->incomingMessage->header->details->from[0]->mailbox . "@" . $imap->incomingMessage->header->details->from[0]->host ?>
                    <span class="mailbox-read-time pull-right"><?php echo $imap->incomingMessage->header->date; ?>
                    <br>
                    <span class="pull-right">
                        <?php echo \YAWK\sys::time_ago($imap->incomingMessage->header->date, $lang); ?></span>
                    </span></h4>
                    
                    <?php $webmail->drawMailboxControls($imap, "message", $imap->incomingMessage->header->uid, $imap->currentFolder, $lang); ?>

                    <div class="box-tools pull-right">
                        <a href="#" class="btn btn-box-tool" data-toggle="tooltip" title=""
                           data-original-title="Previous"><i class="fa fa-chevron-left"></i></a>
                        <a href="#" class="btn btn-box-tool" data-toggle="tooltip" title=""
                           data-original-title="Next"><i class="fa fa-chevron-right"></i></a>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body no-padding">
                    <!--
                    <div class="mailbox-read-info">
                        ...
                    </div> -->
                    <!-- /.mailbox-read-info -->
                    <!-- <div class="mailbox-controls with-border text-center"> -->
                    <!-- </div> -->
                    <!-- /.mailbox-controls -->
                    <div class="mailbox-read-message">

                        <?php
                        echo  $imap->incomingMessage->message->html;

                        foreach ($imap->incomingMessage->attachments as $key => $attachment) {
                            echo "<a href=\"#\">" . $attachment->name . "</a><br>";
                            // base64_decode($attachment->body);
                            // echo "<img src=\"$attachment->body\">";
                        }

                        if (isset($email->attachments[0])) {
                            foreach ($email->attachments as $attachment => $value) {
                                echo "<pre>";
                                echo "<img src=\"" . $value->body . "\">";
                                echo "</pre>";
                            }
                        }

                        //////////////////// cut -- here
                        /*
                                                $email = $imap->getMessage($msgno);

                                                echo $email->message->text."<br>";


                                                foreach ($imap->incomingMessage->attachments as $key => $attachment)
                                                {
                                                    echo $attachment->name."<br>";
                                                    // echo "<img src=\"$attachment->body\">";
                                                    // echo base64_decode($attachment->body);
                                                }

                                                echo "<pre>";
                                                print_r($email);
                                                echo "</pre>";

                        */
                        //////////////////////////////// cut-- here
                        ?>
                        <p>
                            <?php // echo $message; ?>
                        </p>
                    </div>
                    <!-- /.mailbox-read-message -->
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    <!--
                    <ul class="mailbox-attachments clearfix">
                        <li>
                            <span class="mailbox-attachment-icon"><i class="fa fa-file-pdf-o"></i></span>

                            <div class="mailbox-attachment-info">
                                <a href="#" class="mailbox-attachment-name"><i class="fa fa-paperclip"></i> Sep2014-report.pdf</a>
                                <span class="mailbox-attachment-size">
                          1,245 KB
                          <a href="#" class="btn btn-default btn-xs pull-right"><i class="fa fa-cloud-download"></i></a>
                        </span>
                            </div>
                        </li>
                        <li>
                            <span class="mailbox-attachment-icon"><i class="fa fa-file-word-o"></i></span>

                            <div class="mailbox-attachment-info">
                                <a href="#" class="mailbox-attachment-name"><i class="fa fa-paperclip"></i> App Description.docx</a>
                                <span class="mailbox-attachment-size">
                          1,245 KB
                          <a href="#" class="btn btn-default btn-xs pull-right"><i class="fa fa-cloud-download"></i></a>
                        </span>
                            </div>
                        </li>
                        <li>
                            <span class="mailbox-attachment-icon has-img"><img src="../../dist/img/photo1.png" alt="Attachment"></span>

                            <div class="mailbox-attachment-info">
                                <a href="#" class="mailbox-attachment-name"><i class="fa fa-camera"></i> photo1.png</a>
                                <span class="mailbox-attachment-size">
                          2.67 MB
                          <a href="#" class="btn btn-default btn-xs pull-right"><i class="fa fa-cloud-download"></i></a>
                        </span>
                            </div>
                        </li>
                        <li>
                            <span class="mailbox-attachment-icon has-img"><img src="../../dist/img/photo2.png" alt="Attachment"></span>

                            <div class="mailbox-attachment-info">
                                <a href="#" class="mailbox-attachment-name"><i class="fa fa-camera"></i> photo2.png</a>
                                <span class="mailbox-attachment-size">
                          1.9 MB
                          <a href="#" class="btn btn-default btn-xs pull-right"><i class="fa fa-cloud-download"></i></a>
                        </span>
                            </div>
                        </li>
                    </ul>
                    -->
                </div>
            </div>
                <!-- /.box-footer -->
                <div class="box-footer hidden-print">
                    <div class="pull-right hidden-print">
                        <a href="#" class="btn btn-default hidden-print"><i class="fa fa-reply"></i> <?php echo $lang['REPLY']; ?></a>
                        <a href="#" class="btn btn-default hidden-print"><i class="fa fa-mail-forward"></i> <?php echo $lang['FORWARD']; ?></a>
                    </div>
                    <a href="http://raspi/web/clone/admin/index.php?page=webmail&moveMessage=true&folder=INBOX&targetFolder=Trash&uid=<?php echo $imap->incomingMessage->header->uid; ?>" class="btn btn-default hidden-print"><i class="fa fa-trash-o"></i> <?php echo $lang['DELETE']; ?></a>
                    <button type="button" id="printButton" class="btn btn-default hidden-print"><i class="fa fa-print"></i> <?php echo $lang['PRINT']; ?></button>
                </div>
                <!-- /.box-footer -->

            <?php
                // echo "<pre>";
                // print_r($header);
                // echo "</pre>";
            ?>

        </div>
    </div>
    <?php
    $imap->close();
}
else
{
    echo "<h4>Webmail is not enabled! Go to <a href=\"index.php?page=settings-webmail\">Settings / Webmail</a> and enable it.</a></h4>";
}
?>