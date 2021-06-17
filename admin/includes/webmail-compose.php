<script src="../system/engines/jquery/dropzone/dropzone.js"></script>
<link href="../system/engines/jquery/dropzone/dropzone.css" rel="stylesheet">
<?php

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
$editorSettings['editorHeight'] = "360";
editor::loadJavascript($editorSettings);
editor::setEditorSettings($editorSettings);

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
use YAWK\webmail;

// get all webmail setting values into an array
$webmailSettings = settings::getValueSettingsArray($db, "webmail_");

// imap connection only made be made if webmail is set to active
// check if webmail is activated
if ($webmailSettings['webmail_active'] == true)
{   // webmail enabled, get mailbox settings

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
    // options (novalidate-cert)
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
            <a href="index.php?page=webmail" class="btn btn-success btn-large" style="width: 100%;"><i class="fa fa-reply-all"></i>&nbsp;&nbsp; Back to inbox</a><br><br>
            <div class="box box-default">
                <div class="box-header with-border">
                    <h3 class="box-title">Folders</h3>

                    <div class="box-tools">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="box-body no-padding animated fadeIn">
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
           <!-- <form enctype="multipart/form-data" class="dropzone" action="index.php?page=webmail-compose" method="POST"> -->
           <form id="my-dropzone" class="dropzone" enctype="multipart/form-data">
            <!-- right col -->
            <div class="box box-secondary">
                <div class="box-header with-border">
                    <h3 class="box-title">Compose New Message</h3>
                    <div class="pull-right">
                        <i id="addCCBtn" class="btn btn-default btn-sm">CC</i>&nbsp;&nbsp;
                        <i id="addBCCBtn" class="btn btn-default btn-sm">BCC</i>
                    </div>
                </div>
                <!-- /.box-header -->
                    <div class="box-body">
                        <div class="form-group">
                            <input class="form-control" name="to" placeholder="To:">
                            <input id="ccField" class="form-control hidden" name="ccField" placeholder="CC:">
                            <input id="bccField" class="form-control hidden" name="bccField" placeholder="BCC:">
                        </div>
                        <div class="form-group">
                            <input class="form-control" name="subject" placeholder="Subject:">
                        </div>
                        <div class="form-group">
                            <label for="summernote" class="hidden"></label>
                            <!-- summernote editor -->
                            <textarea id="summernote" name="body" class="form-control"></textarea>
                        </div>

                        <!-- start dropzone -->
                        <div id="actions">
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
                            </div>

                            <p class="help-block">Max. <?php echo filemanager::getPostMaxSize(); ?></p>
                        </div>
                        <!-- /. bootstrap dropzone -->

                    </div>
            </div>
                <!-- /.box-body -->
            <br><br>
       </form>
        </div>
    </div>
    <?php
    // close current imap connection
    $imap->close();
}
else
{   // webmail not enabled
    echo "<h4>".$lang['WEBMAIL_NOT_ENABLED']."</h4>";
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

</script>
