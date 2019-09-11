<!-- load JS: Lightbox 2 JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.10.0/js/lightbox.min.js"></script>
<!-- load CSS: Lightbox 2 CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.10.0/css/lightbox.min.css" type="text/css" media="all">
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
                        // output message body
                        echo  $imap->incomingMessage->message->html;

                        // TODO: BETTER ATTACHMENT HANDLING

                        // set download path
                        $downloadPath = "../media/mailbox";

                        // set attachment options
                        $attachmentOptions = array('dir' => $downloadPath, 'incomingMessage' => $imap->incomingMessage);

                        // if there are any attachments...
                        if (count($imap->incomingMessage->attachments) > 0)
                        {
                            // set markup for attachments - start list
                            echo "<ul class=\"mailbox-attachments clearfix\">";

                            // walk through each attachment
                            foreach ($imap->incomingMessage->attachments as $key => $attachment)
                            {
                                // save attachments to media/mailbox folder
                                $imap->saveAttachments($attachmentOptions);
                                // set download path
                                $downloadPath = \YAWK\sys::addTrailingSlash($downloadPath);
                                // set current file
                                $attachment->currentFile = $downloadPath.$attachment->name;

                                // check if attachment of this email was saved and is there
                                if (is_file($attachment->currentFile))
                                {   // get filesize of current attachment
                                    $attachment->size = filesize($attachment->currentFile);
                                    // round filesize to make it more human-friendly readable
                                    $attachment->size = \YAWK\filemanager::sizeFilter($attachment->size, 0);

                                    // check if attachment filename is too long for the box
                                    if (strlen($attachment->name) >= 20)
                                    {   // limit preview filename to 20 chars
                                        $attachment->namePreview = substr($attachment->name, 0, 20);
                                        // add dots to improve visibility that filename was cutted
                                        $attachment->namePreview = $attachment->namePreview."...";
                                    }
                                    else
                                        {   // filename is short enough - display full filename
                                            $attachment->namePreview = $attachment->name;
                                        }

                                    // set current attachment mime type
                                    $attachment->currentMimeType = mime_content_type($attachment->currentFile);

                                    // CHECK MIME TYPES AND SET MARKUP
                                    // :IMAGE
                                    if(strpos($attachment->currentMimeType, "image") !== false)
                                    {   // image markup
                                        // echo "Attachment must be an image";
                                    }

                                    // :ZIP
                                    else if(strpos($attachment->currentMimeType, "zip") !== false)
                                    {   // seems to be a zip file";
                                        $attachmentIcon = "fa fa-file-archive-o";
                                    }

                                    // :PDF
                                    else if(strpos($attachment->currentMimeType, "pdf") !== false)
                                    {   // seems to be a pdf file";
                                        $attachmentIcon = "fa fa-file-pdf-o";
                                    }

                                    // :TEXT
                                    else if(strpos($attachment->currentMimeType, "text") !== false)
                                    {   // seems to be an text file";
                                        $attachmentIcon = "fa fa-file-text-o";
                                    }

                                    // :AUDIO
                                    else if(strpos($attachment->currentMimeType, "audio") !== false)
                                    {   // seems to be a audio file";
                                        $attachmentIcon = "fa fa-file-audio-o";
                                    }

                                    // :VIDEO
                                    else if(strpos($attachment->currentMimeType, "video") !== false)
                                    {   // seems to be a video file
                                        echo "Attachment must be a video";
                                        $attachmentIcon = "fa fa-file-video-o";
                                    }

                                    // :WORD
                                    else if(strpos($attachment->currentMimeType, "word") !== false)
                                    {   // seems to be a word file
                                        $attachmentIcon = "fa fa-file-word-o";
                                    }

                                    // :EXCEL
                                    else if(strpos($attachment->currentMimeType, "excel") !== false)
                                    {   // seems to be a excel file
                                        $attachmentIcon = "fa fa-file-excel-o";
                                    }

                                    // :EXCEL
                                    else if(strpos($attachment->currentMimeType, "powerpoint") !== false)
                                    {   // seems to be a powerpoint file
                                        $attachmentIcon = "fa fa-file-powerpoint-o";
                                    }

                                    // unknown mime type
                                    else
                                        {   // cannot determine mime type
                                            // block? or set default icon!
                                            $attachmentIcon = "fa fa-file-o";
                                        }

                                    // check file extension to create proper markup
                                    // $attachment->ext = pathinfo($downloadPath.$attachment->name, PATHINFO_EXTENSION);
                                    if (pathinfo($downloadPath.$attachment->name, PATHINFO_EXTENSION) == "jpg")
                                    {
                                        // attachment is an image
                                        echo "
                                
                                        <li>
                                           <!-- <span class=\"mailbox-attachment-icon\"><i class=\"fa fa-file-image-o\"></i></span> -->
                
                                            <div class=\"mailbox-attachment-info\" style=\"min-height:180px; overflow: hidden;\">
                                                <a href=\"".$downloadPath.$attachment->name."\" data-lightbox=\"attachment-set\" data-title=\"".$attachment->name."\" class=\"mailbox-attachment-name\"><img src=\"".$downloadPath.$attachment->name."\" class=\"img-responsive\"> ".$attachment->namePreview."</a>
                                                <span class=\"mailbox-attachment-size\">
                                          ".$attachment->size."
                                          <a href=\"".$downloadPath.$attachment->name."\" class=\"btn btn-default btn-xs pull-right\"><i class=\"fa fa-cloud-download\"></i></a>
                                        </span>
                                            </div>
                                        </li>";
                                    }
                                    else
                                    {   // attachment is not an image
                                        echo "
                                        <li>
                                            <span class=\"mailbox-attachment-icon\"><a href=\"".$attachment->currentFile."\" target=\"_blank\"><i class=\"".$attachmentIcon."\"></i></a></span>
                
                                            <div class=\"mailbox-attachment-info\">
                                                <i class=\"fa fa-paperclip\"></i>&nbsp;&nbsp;<a href=\"".$downloadPath.$attachment->name."\">".$attachment->namePreview."</a>
                                                <span class=\"mailbox-attachment-size\">
                                                ".$attachment->size."
                                          <a href=\"".$downloadPath.$attachment->name."\" class=\"btn btn-default btn-xs pull-right\"><i class=\"fa fa-cloud-download\"></i></a>
                                        </span>
                                            </div>
                                        </li>";
                                        // echo "<br><p><b><i class=\"fa fa-paperclip\"></i>&nbsp;&nbsp;<a href=\"../media/mailbox/".$attachment->name."\">" . $attachment->name . "</a></b></p>";
                                    }
                                }
                                else
                                {
                                    echo "The email got attachments, but no files were found. <a href=\"#\">Try to download</a>";
                                }
                            }
                            echo "</ul>";
                        }

                        ?>
                    <!-- /.mailbox-read-message -->
                </div>

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