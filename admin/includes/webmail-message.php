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

// After this, we need to let php we need these classes:
use SSilence\ImapClient\ImapClientException;
use SSilence\ImapClient\ImapClient as Imap;

// mailbox user data
$mailbox = 'imap.world4you.com';
$username = 'development@mashiko.at';
$password = 'test1234';

$encryption = Imap::ENCRYPT_SSL; // TLS OR NULL accepted

require_once "../system/classes/webmail.php";
$webmail = new \YAWK\webmail();


// Open connection
try
{
    $imap = new Imap($mailbox, $username, $password, $encryption);
    $imap->connection = $imap->getImapConnection();
    if (isset($_GET['folder']))
    {
        $imap->currentFolder = $_GET['folder'];
        $imap->selectFolder($imap->currentFolder);
    }


    // $body = imap_body($imap->getImap(), $_GET['msgno']);
    // $body = imap_fetchstructure($imap->getImap(), $_GET['msgno']);

    // $header = imap_header($imap->connection, $_GET['msgno']);
   // $body = imap_fetchbody($imap->connection, $_GET['msgno'], 2);

    // Setting flag from un-seen email to seen on emails ID.
   // imap_setflag_full($imap->connection, $_GET['msgno'], "\\Seen \\Flagged"); //IMPORTANT


}
catch (ImapClientException $error){
    // You know the rule, no errors in production ...
    $webmail->connectionInfo = $error->getMessage().PHP_EOL;
    // Oh no :( we failed
    die('oh no! verbindung mit '.$mailbox.' als '.$username.' nicht moeglich!');
}

// check user actions
// move to trash
if (isset($_GET['action']) && ($_GET['action'] === "move"))
{
    if (isset($_GET['msgno']) && (!empty($_GET['msgno'])))
    {
        $imap->moveMessage((int)$_GET['msgno'], "Trash");
        $imap->selectFolder("Trash");
    }
}
else
    {
        $msgno = (int)$_GET['msgno'];
        // retrieve message
        $email = $imap->getMessage($msgno);
    }



// check out with if....
// $imap->setSeenMessage($msgno);

?>
<script type="text/javascript">
    $(document).ready(function() {
        $('#table-sort').dataTable( {
            "bPaginate": true,
            "bLengthChange": false,
            "bFilter": true,
            "bSort": true,
            "bInfo": true,
            "bAutoWidth": false
        } );
    } );
</script>
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
?>
    <div class="row">
        <div class="col-md-3">
            <!-- left col -->
            <a href="index.php?page=webmail" class="btn btn-success btn-large" style="width: 100%;">Back to Inbox</a><br><br>
            <div class="box box-default">
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
                        $webmail->drawFolders($imap, $imap->getFolders());
                        ?>

                    </ul>
                </div>
                <!-- /.box-body -->
            </div>

        </div>
        <div class="col-md-9">
            <!-- right col -->
            <div class="box box-secondary">
                <div class="box-header with-border">
                    <h3 class="box-title">Read Mail</h3>

                    <div class="box-tools pull-right">
                        <a href="#" class="btn btn-box-tool" data-toggle="tooltip" title="" data-original-title="Previous"><i class="fa fa-chevron-left"></i></a>
                        <a href="#" class="btn btn-box-tool" data-toggle="tooltip" title="" data-original-title="Next"><i class="fa fa-chevron-right"></i></a>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body no-padding">
                    <div class="mailbox-read-info">
                        <h3><?php echo $imap->incomingMessage->header->subject; ?></h3>
                        <h5>From: <?php echo $imap->incomingMessage->header->details->from[0]->mailbox."@".$imap->incomingMessage->header->details->from[0]->host ?>
                            <span class="mailbox-read-time pull-right"><?php echo $imap->incomingMessage->header->date; ?></span></h5>
                    </div>
                    <!-- /.mailbox-read-info -->
                    <div class="mailbox-controls with-border text-center">
                        <div class="btn-group">
                            <button type="button" class="btn btn-default btn-sm" data-toggle="tooltip" data-container="body" title="" data-original-title="Delete">
                                <a href="index.php?page=webmail-message&folder=<?php echo $imap->currentFolder; ?>&action=move&msgno=<?php echo $imap->incomingMessage->header->uid; ?>"><i class="fa fa-trash-o"></i></a></button>
                            <button type="button" class="btn btn-default btn-sm" data-toggle="tooltip" data-container="body" title="" data-original-title="Reply">
                                <i class="fa fa-reply"></i></button>
                            <button type="button" class="btn btn-default btn-sm" data-toggle="tooltip" data-container="body" title="" data-original-title="Forward">
                                <i class="fa fa-share"></i></button>
                        </div>
                        <!-- /.btn-group -->
                        <button type="button" class="btn btn-default btn-sm" data-toggle="tooltip" title="" data-original-title="Print">
                            <i class="fa fa-print"></i></button>
                    </div>
                    <!-- /.mailbox-controls -->
                    <div class="mailbox-read-message">

                        <?php

                        echo $imap->incomingMessage->message->html;

                        foreach ($imap->incomingMessage->attachments as $key => $attachment)
                        {
                            echo "<a href=\"#\">".$attachment->name."</a><br>";
                            // base64_decode($attachment->body);
                            // echo "<img src=\"$attachment->body\">";
                        }

                        if (isset($email->attachments[0]))
                        {
                            foreach ($email->attachments as $attachment => $value)
                            {
                                echo "<pre>";
                                echo "<img src=\"".$value->body."\">";
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
                <!-- /.box-footer -->
                <div class="box-footer">
                    <div class="pull-right">
                        <button type="button" class="btn btn-default"><i class="fa fa-reply"></i> Reply</button>
                        <button type="button" class="btn btn-default"><i class="fa fa-share"></i> Forward</button>
                    </div>
                    <button type="button" class="btn btn-default"><i class="fa fa-trash-o"></i> Delete</button>
                    <button type="button" class="btn btn-default"><i class="fa fa-print"></i> Print</button>
                </div>
                <!-- /.box-footer -->
            </div>


            <?php
            echo "<pre>";
            echo "<h2>info messages";
            // print_r($imap->getMessageOverview($_GET['msgno']));
            echo "</pre>";


            echo "<pre>";
            // print_r($header);
            echo "</pre>";
            ?>

        </div>
    </div>
<?php
$imap->close();
?>