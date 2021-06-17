<script src="../system/engines/jquery/dropzone/dropzone.js"></script>
<link href="../system/engines/jquery/dropzone/dropzone.css" rel="stylesheet">
<script src="../system/engines/jquery/lightbox2/js/lightbox.min.js"></script>
<link rel="stylesheet" href="../system/engines/jquery/lightbox2/css/lightbox.min.css" type="text/css" media="all">
<?php

use YAWK\alert;
use YAWK\backend;
use YAWK\db;
use YAWK\editor;
use YAWK\filemanager;
use YAWK\language;
use YAWK\settings;

/** @var $db db */
/** @var $lang language */

// import editor class + load editor settings
require_once '../system/classes/editor.php';
$editorSettings = settings::getEditorSettings($db, 14);
$editorSettings['editorHeight'] = "180";
editor::loadJavascript($editorSettings);
editor::setEditorSettings($editorSettings);

    // require_once "../system/engines/imapClient/AdapterForOutgoingMessage.php";
    // require_once "../system/engines/imapClient/Helper.php";
    require_once "../system/engines/imapClient/ImapClient.php";
    require_once "../system/engines/imapClient/ImapClientException.php";
    require_once "../system/engines/imapClient/ImapConnect.php";
    require_once "../system/engines/imapClient/IncomingMessage.php";
    require_once "../system/engines/imapClient/IncomingMessageAttachment.php";
    // require_once "../system/engines/imapClient/OutgoingMessage.php";
    require_once "../system/engines/imapClient/Section.php";
    require_once "../system/engines/imapClient/SubtypeBody.php";
    require_once "../system/engines/imapClient/TypeAttachments.php";
    require_once "../system/engines/imapClient/TypeBody.php";

    // let php know we need these classes:
    use SSilence\ImapClient\ImapClientException;
    use SSilence\ImapClient\ImapClient as Imap;
use YAWK\sys;
use YAWK\webmail;

// get all webmail setting values into an array
    $webmailSettings = settings::getValueSettingsArray($db, "webmail_");

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
    $webmail = new webmail();

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
            alert::draw("success", "Marked as unread", "The email was marked as unseen", "", 1200);
        }
        else
        {   // set unseen failed
            alert::draw("warning", "ERROR:", "Unable to mark email as read", "", 2800);
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
    // DROPZONE
    Dropzone.options.myDropzone = { // The camelized version of the ID of the form element
        // ajax form action
        url: "js/email-send.php",
        // dropzone options
        autoProcessQueue: false,
        uploadMultiple: true,
        parallelUploads: 100,
        maxFilesize: 64, // MB
        maxFiles: 100,
        addRemoveLinks: true,
        paramName: "files",
        acceptedFiles: ".jpg, .jpeg, .png, .gif, .pdf, .doc, .xls, .wav, .mp3, .mp4, .mpg",
        clickable: ".fileinput-button", // Define the element that should be used as click trigger to select files.
        // Language Strings
        dictFileTooBig: "File is to big ({{filesize}}mb). Max allowed file size is {{maxFilesize}}mb",
        dictInvalidFileType: "Invalid File Type",
        dictCancelUpload: "Cancel",
        dictRemoveFile: "Remove",
        dictMaxFilesExceeded: "Only {{maxFiles}} files are allowed",
        dictDefaultMessage: "Drop files here to upload",

        // The setting up of the dropzone
        init: function() {
            var myDropzone = this;
            var dropzoneFormElement = $('#my-dropzone');

            $(".dz-message").hide();
            // First change the button to actually tell Dropzone to process the queue.
            this.element.querySelector("button[type=submit]").addEventListener("click", function(e) {
                // Make sure that the form isn't actually being sent.
                e.preventDefault();
                e.stopPropagation();

                // process only, if there are any attachments
                if (myDropzone.getQueuedFiles().length > 0) {
                    myDropzone.processQueue();
                }
                else
                {   // process w/o attachments
                    // add form action & methods, call submit event
                    $(dropzoneFormElement).attr('action', 'js/email-send.php');
                    $(dropzoneFormElement).attr('method', 'post');
                    $(dropzoneFormElement).submit();
                }
            });

            // Listen to the sendingmultiple event. In this case, it's the sendingmultiple event instead
            // of the sending event because uploadMultiple is set to true.
            this.on("sendingmultiple", function(file) {
                // Gets triggered when the form is actually being sent.
                // Indicate loading button
                $("#submitIcon").removeClass().addClass("fa fa-spinner fa-spin");
                $("#submitBtn").removeClass().addClass("btn btn-danger disabled pull-right");
                $("#draftBtn").removeClass().addClass("btn btn-default disabled");
                $("#addBtn").removeClass().addClass("btn btn-success disabled");
            });

            this.on("successmultiple", function(files, response) {
                // Gets triggered when files + form have successfully been sent.
                // redirect to webmail start page
                window.location.replace("index.php?page=webmail");
            });
            this.on("errormultiple", function(files, response) {
                // Gets triggered when there was an error sending the files.
                // Maybe show form again, and notify user of error
            });
        }
    };

    $(document).ready(function() {
        $('#table-sort').dataTable({
            "bPaginate": true,
            "bLengthChange": false,
            "bFilter": true,
            "bSort": true,
            "bInfo": true,
            "bAutoWidth": false
        });

        // vars that will be used outside of functions
        let markAsUnseenIcon = $('#icon-markAsUnseen');
        let replyBtn = $('#replyBtn');
        let replyIcon = $('#icon-reply');
        let forwardIcon = $('#icon-forward');
        let replyTextArea = $('#summernote');
        let form = $('#my-dropzone');
        let toFormGroup = $('#toFormGroup');
        let boxFooter = $('#box-footer');
        let replyTo = $('#replyTo');

        // OPEN REPLY BOX toggled by footer button
        $(replyBtn).click(function() {
            openReplyBox();
            boxFooter.hide();
            toFormGroup.removeClass();
            $('.note-editable').focus();
        });

        // OPEN REPLY BOX toggled by reply icon
        $(replyIcon).click(function() {
            openReplyBox();
            boxFooter.hide();
            toFormGroup.removeClass();
            $('.note-editable').focus();
        });

        // forward: OPEN REPLY BOX and add forward email
        $(forwardIcon).click(function() {
            let toField = $('#toField');
            openReplyBox();
            boxFooter.hide();
            toFormGroup.removeClass();
            $('.note-editable').focus();
            // $(toField).fadeIn();
        });

        // SEEN / UNSEEN icon
        $("#btn-markAsUnseen").hover(
            function() {
                $(markAsUnseenIcon).removeClass("fa fa-envelope-open-o");
                $(markAsUnseenIcon).addClass("fa fa-envelope");
            }, function() {
                $(markAsUnseenIcon).removeClass("fa fa-envelope");
                $(markAsUnseenIcon).addClass("fa fa-envelope-open-o");
            }
        );

        // PRINT BUTTON
        $("#printButton").click(
            function () {
                $("#emailMessageContent").printThis();
        });

        // PRINT ICON
        $("#icon-print").click(
            function () {
                $("#emailMessageContent").printThis();
            });

        // CC button handling (toggle fadeIn/out on demand)
        $( "#addCCBtn" ).click(function() {
            // alert( "Add CC Field Btn clicked!" );
            var ccField = $('#ccField');
            var ccFieldClass = $(ccField).attr('class');
            if (ccFieldClass === 'form-control hidden')
            {
                $(ccField).removeClass().addClass('form-control animated fadeIn');
            }
            else if (ccFieldClass === 'form-control animated fadeIn')
            {
                $(ccField).removeClass().addClass('form-control animated fadeOut hidden');
            }
            else if (ccFieldClass === 'form-control animated fadeOut hidden')
            {
                $(ccField).removeClass().addClass('form-control animated fadeIn');
            }
        });

        // BCC button handling (toggle fadeIn/out on demand)
        $( "#addBCCBtn" ).click(function() {
            // alert( "Add BCC Field Btn clicked!" );
            var bccField = $('#bccField');
            var bccFieldClass = $(bccField).attr('class');
            if (bccFieldClass === 'form-control hidden')
            {
                $(bccField).removeClass().addClass('form-control animated fadeIn');
            }
            else if (bccFieldClass === 'form-control animated fadeIn')
            {
                $(bccField).removeClass().addClass('form-control animated fadeOut hidden');
            }
            else if (bccFieldClass === 'form-control animated fadeOut hidden')
            {
                $(bccField).removeClass().addClass('form-control animated fadeIn');
            }
        });
    });

    /**
     *  Reaction to click on reply button: add html markup to open the reply box
     *
     */
        function openReplyBox()
        {
            // html elements
            let replyBox = $('#replyBox');
            let sendBtn = $('#sendBtn');
            let submitBtn = $('#submitBtn');
            let replyBtn = $('#replyBtn');
            let deleteBtn = $('#deleteBtn');
            let printBtn = $('#printBtn');
            let forwardBtn = $('#forwardBtn');
            let actions = $('#actions');
            // open reply box
            $(actions).removeClass().addClass('animated fadeIn');
            $(replyBox).removeClass().addClass('box-footer hidden-print animated fadeIn');
            $(replyBtn).hide();
            $(forwardBtn).hide();
            $(deleteBtn).hide();
            $(printBtn).hide();
            $(submitBtn).removeClass().addClass('btn btn-success hidden-print animated flipInX');
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
                // var messageBox = $('#messageBox');
                // fadeOut message box
                // $(messageBox).removeClass().addClass('animated fadeOut');
                window.location.replace('index.php?page=webmail');

            }
        });
    }
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
echo backend::getTitle($lang['WEBMAIL'], $lang['WEBMAIL_SUBTEXT']);
echo"<ol class=\"breadcrumb\">
            <li><a href=\"index.php\" title=\"$lang[DASHBOARD]\"><i class=\"fa fa-dashboard\"></i> $lang[DASHBOARD]</a></li>
            <li class=\"active\"><a href=\"index.php?page=webmail\" title=\"$lang[WEBMAIL]\"> $lang[WEBMAIL]</a></li>
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
            <a href="index.php?page=webmail" class="btn btn-success btn-large" style="width: 100%;"><i class="fa fa-reply-all"></i> &nbsp;Back to
                Inbox</a><br><br>
            <div class="box box-default">
                <div class="box-header with-border">
                    <h3 class="box-title">Folders</h3>

                    <div class="box-tools">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse">
                            <i class="fa fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="box-body no-padding animated fadeIn" style="">
                    <ul class="nav nav-pills nav-stacked">
                        <?php
                            $webmail->drawFolders($imap, $imap->getFolders());
                        ?>
                    </ul>
                </div>
                <!-- /.box-body -->
            </div>

        </div>

        <div id="messageBox" class="col-md-9 animated fadeIn">

            <form id="my-dropzone" class="dropzone" enctype="multipart/form-data">
            <!-- right col -->
            <div class="box box-secondary" id="emailMessageContent">
                <div class="box-header with-border">

                    <?php
                        // check if this message is a reply and adapt subject
                        // count replies
                        $replies = substr_count($imap->incomingMessage->header->subject , 'Re:');
                        // message must got a reply
                        if ($replies > 0)
                        {   // adapt subject for better readability
                            $subject = str_replace("Re:","",$imap->incomingMessage->header->subject);
                            $subject = "Re:(".$replies.") ".$subject;
                        }
                        else
                            {   // no reply, leave subject as it is
                                $subject = $imap->incomingMessage->header->subject;
                            }
                    ?>
                    <h3><?php echo $subject; ?></h3>

                    <h4>From: <?php echo $imap->incomingMessage->header->details->from[0]->mailbox . "@" . $imap->incomingMessage->header->details->from[0]->host ?></h4>
                    <h4 style="margin-top:-10px;"><small>To: <?php echo $imap->incomingMessage->header->details->to[0]->mailbox . "@" . $imap->incomingMessage->header->details->to[0]->host ?></small>
                    <span style="margin-top:-15px;" class="mailbox-read-time pull-right"><?php echo substr($imap->incomingMessage->header->date, 0, -6); ?>
                    <br>
                    <span class="pull-right">
                        <?php echo sys::time_ago($imap->incomingMessage->header->date, $lang); ?></span>
                    </span></h4>
                    
                    <?php $webmail->drawMailboxControls($imap, "message", $imap->incomingMessage->header->uid, $imap->currentFolder, $lang); ?>

                    <div class="box-tools pull-right">
                        <a href="index.php?page=webmail&folder=INBOX" class="btn btn-box-tool" data-toggle="tooltip" title="<?php echo $lang['CLOSE'];?>"
                           data-original-title="<?php echo $lang['CLOSE'];?>"><i class="fa fa-close text-light"></i>
                        </a>
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
                        // set message body
                        echo $imap->incomingMessage->message->html;

                        // if there are any attachments...
                        if (count($imap->incomingMessage->attachments) > 0)
                        {
                            // set download path
                            $downloadPath = "../media/mailbox";

                            // check if download path is writeable
                            if (is_writeable($downloadPath) === false)
                            {   // it is not - throw error msg
                                alert::draw("warning", $lang['ERROR'], $lang['ATTACH_DIR_NOT_WRITEABLE'], "", 3800);
                            }

                            // set attachment options
                            $attachmentOptions = array('dir' => $downloadPath, 'incomingMessage' => $imap->incomingMessage);

                            // set markup for attachments - start list
                            echo "<ul class=\"mailbox-attachments clearfix\">";

                            // walk through each attachment
                            foreach ($imap->incomingMessage->attachments as $key => $attachment)
                            {
                                // save attachments to media/mailbox folder
                                $imap->saveAttachments($attachmentOptions);
                                // set download path
                                $downloadPath = sys::addTrailingSlash($downloadPath);
                                // set current file
                                $attachment->currentFile = $downloadPath.$attachment->name;
                                // will be set to true, if attachment is an image (used by attachment preview)
                                $attachment->isImage = '';

                                // check if attachment of this email was saved and is there
                                if (is_file($attachment->currentFile))
                                {   // get filesize of current attachment
                                    $attachment->size = filesize($attachment->currentFile);
                                    // round filesize to make it more human-friendly readable
                                    $attachment->size = filemanager::sizeFilter($attachment->size, 0);

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
                                        $attachment->isImage = true;
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
                                    if ($attachment->isImage === true)
                                    {
                                        // attachment is an image
                                        echo "
                                
                                        <li>
                                           <!-- <span class=\"mailbox-attachment-icon\"><i class=\"fa fa-file-image-o\"></i></span> -->
                
                                            <div class=\"mailbox-attachment-info\" style=\"min-height:180px; overflow: hidden;\">
                                                <a href=\"".$downloadPath.$attachment->name."\" data-lightbox=\"attachment-set\" data-title=\"".$attachment->name."\" class=\"mailbox-attachment-name\">
                                                    <img src=\"".$downloadPath.$attachment->name."\" class=\"img-responsive\" alt=\"attachment\"> ".$attachment->namePreview."
                                                </a>
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

                <div id="toFormGroup" class="form-group hidden">
                    <input id="toField" class="form-control hidden" name="to" placeholder="<?php echo $imap->incomingMessage->header->details->from[0]->mailbox . "@" . $imap->incomingMessage->header->details->from[0]->host ?>" value="<?php echo $imap->incomingMessage->header->details->from[0]->mailbox . "@" . $imap->incomingMessage->header->details->from[0]->host ?>">
                    <input id="ccField" class="form-control hidden" name="ccField" placeholder="CC:">
                    <input id="bccField" class="form-control hidden" name="bccField" placeholder="BCC:">
                </div>
                <div id="subjectFormGroup" class="form-group hidden">
                    <input class="form-control" name="subject" placeholder="Subject:" value="<?php "Re: ".$imap->incomingMessage->header->subject; ?>">
                </div>
                <div id="replyBox" class="form-group hidden">
                    <small class="text-muted"><?php echo $lang['REPLY']." ".$lang['TO'].": ".$imap->incomingMessage->header->details->from[0]->mailbox . "@" . $imap->incomingMessage->header->details->from[0]->host; ?>
                        <span id="addBCCBtn" class="pull-right" style="cursor:pointer;">&nbsp;BCC</span>
                        <span id="addCCBtn" class="pull-right" style="cursor: pointer;">CC&nbsp;</span>
                    </small>
                    <label for="summernote" class="hidden"></label>
                    <!-- summernote editor -->
                    <textarea id="summernote" name="body" class="form-control">
                        <?php echo "
                        <br><br>
                        <h4>".$lang['SENT'].": ".substr($imap->incomingMessage->header->date, 0, -6)." ".$lang['FROM']." ".$imap->incomingMessage->header->details->from[0]->mailbox . "@" . $imap->incomingMessage->header->details->from[0]->host."</h4>";
                        echo "<br>".$imap->incomingMessage->message->html; ?>
                    </textarea>
                </div>

                <!-- start dropzone -->
                <div id="actions" class="hidden">
                    <!-- this is were the previews should be shown. -->
                    <div class="dropzone-previews"></div>
                    <!-- The fileinput-button span is used to style the file input field as button -->
                    <span id="addBtn" class="btn btn-success fileinput-button">
                            <i class="fa fa-plus"></i>
                            <span>Add files...</span>
                        </span>

                    <div class="pull-right">
                        <a id="draftBtn" href="index.php?page=webmail-compose&draft=1" type="button" class="btn btn-default"><i class="fa fa-pencil"></i>&nbsp; Draft</a>
                        &nbsp;
                        <button id="submitBtn" type="submit" class="btn btn-success pull-right"><i id="submitIcon" class="fa fa-paper-plane-o"></i> &nbsp;&nbsp;Send Email</button>
                        <!-- <button type="submit" id="submitBtn" class="btn btn-success start"><i class="fa fa-paper-plane-o"></i>&nbsp; Send</button> -->
                        <input type="hidden" name="sendEmail" value="true">
                        <input type="hidden" name="subject" value="<?php echo "Re: ".$imap->incomingMessage->header->subject;?>">
                    </div>

                    <p class="help-block">Max. <?php echo filemanager::getPostMaxSize(); ?></p>
                </div>
                <!-- /. bootstrap dropzone -->
            </div>

                <!-- /.box-footer -->
                <div id="box-footer" class="box-footer hidden-print">
                    <div class="pull-right hidden-print">
                        <!-- <a href="http://raspi/web/clone/admin/index.php?page=webmail&moveMessage=true&folder=INBOX&targetFolder=Trash&uid=<?php echo $imap->incomingMessage->header->uid; ?>" class="btn btn-default hidden-print"><i class="fa fa-trash-o"></i> <?php // echo $lang['DELETE']; ?></a> -->
                        <button type="button" id="deleteBtn" class="btn btn-default hidden-print"><i class="fa fa-trash-o"></i> <?php echo $lang['DELETE']; ?></button>
                        <button type="button" id="printBtn" class="btn btn-default hidden-print"><i class="fa fa-print"></i> <?php echo $lang['PRINT']; ?></button>
                    </div>

                    <button id="sendBtn" class="btn btn-default hidden-print hidden"><i class="fa fa-send"></i> &nbsp;<?php echo $lang['SUBMIT']; ?></button>
                    <a id="replyBtn" href="#summernote" class="btn btn-default hidden-print"><i class="fa fa-reply"></i> &nbsp;<?php echo $lang['REPLY']; ?></a>
                    <!-- <button id="forwardBtn" class="btn btn-default hidden-print"><i class="fa fa-mail-forward"></i> &nbsp;<?php // echo $lang['FORWARD']; ?></button> -->

                </div>

            </form>
                <!-- /.box-footer -->
            <?php
              //  echo "<pre>";
              //  print_r($imap->incomingMessage);
              //  echo "</pre>";
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