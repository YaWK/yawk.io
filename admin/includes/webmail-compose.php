<script src="../system/engines/jquery/dropzone/dropzone.js"></script>
<link href="../system/engines/jquery/dropzone/dropzone.css" rel="stylesheet">
<style>
    #actions {
        margin: 2em 0;
    }

    /* Mimic table appearance */
    div.table {
        display: table;
    }
    div.table .file-row {
        display: table-row;
    }
    div.table .file-row > div {
        display: table-cell;
        vertical-align: top;
        border-top: 1px solid #ddd;
        padding: 8px;
    }
    div.table .file-row:nth-child(odd) {
        background: #f9f9f9;
    }

    /* The total progress gets shown by event listeners */
    #total-progress {
        opacity: 0;
        transition: opacity 0.3s linear;
    }

    /* Hide the progress bar when finished */
    #previews .file-row.dz-success .progress {
        opacity: 0;
        transition: opacity 0.3s linear;
    }

    /* Hide the delete button initially */
    #previews .file-row .delete {
        display: none;
    }

    /* Hide the start and cancel buttons and show the delete button */

    #previews .file-row.dz-success .start,
    #previews .file-row.dz-success .cancel {
        display: none;
    }
    #previews .file-row.dz-success .delete {
        display: block;
    }


</style>
<?php
require_once '../system/classes/editor.php';
$editorSettings = \YAWK\settings::getEditorSettings($db, 14);
$editorSettings['editorHeight'] = "360";
\YAWK\editor::loadJavascript($editorSettings);
\YAWK\editor::setEditorSettings($editorSettings);

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

// get all webmail setting values into an array
$webmailSettings = \YAWK\settings::getValueSettingsArray($db, "webmail_");

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

    // include webmail class
    require_once "../system/classes/webmail.php";
    // create new webmail object
    $webmail = new \YAWK\webmail();
    // set connection info var
    $webmail->connectionInfo = "<i>$username</i>";

    try // open connection to imap server
    {
        // create new imap handle
        $imap = new Imap($server.$port.$encryption, $username, $password, $encryption);
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

    // SEND ACTION: email is requested to be sent
    if (isset($_POST['sendEmail']) && ($_POST['sendEmail'] == true))
    {   // send email

        if (isset($_POST))
        {
            echo "<div class=\"row\"><div class=\"col-md-3\">left</div>
<div class=\"col-md-6\">";
            echo "<pre><h1>";

            print_r($_FILES);

            print_r($_POST);
            echo "</pre></h1>";
            echo "<hr></div>";
            echo "<div class=\"col-md-3\">right</div></div>";

        }

        /*
        if ($webmail->deleteMessage($imap, $_GET['folder'], $_GET['uid']))
        {   // email deleted
            \YAWK\alert::draw("success", "Email deleted", "The email was deleted", "", 1200);
        }
        else
        {   // failed to delete email
            \YAWK\alert::draw("danger", "ERROR:", "Unable to delete email", "", 2800);
        }
        */
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
            <a href="webmail-compose" class="btn btn-success btn-large" style="width: 100%;">Write a message</a><br><br>
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
                        /** @var $imap \SSilence\ImapClient\ImapClient */
                        $webmail->drawFolders($imap, $imap->getFolders());
                        ?>
                    </ul>
                </div>
                <!-- /.box-body -->
            </div>
        </div> <!-- /. left col -->

        <div class="col-md-9">
            <form enctype="multipart/form-data" class="dropzone" action="index.php?page=webmail-compose" method="POST">
            <!-- <form enctype="multipart/form-data" method="POST"> -->
            <!-- right col -->
            <div class="box box-secondary">
                <div class="box-header with-border">
                    <h3 class="box-title">Compose New Message</h3>
                </div>
                <!-- /.box-header -->
                    <div class="box-body">
                        <div class="form-group">
                            <input class="form-control" name="to" placeholder="To:">
                        </div>
                        <div class="form-group">
                            <input class="form-control" name="subject" placeholder="Subject:">
                        </div>
                        <div class="form-group">
                            <label for="summernote" class="hidden"></label>
                            <!-- summernote editor -->
                            <textarea id="summernote" name="body" class="form-control"></textarea>
                        </div>


                        <!-- bootstrap dropzone -->
                        <!-- HTML heavily inspired by http://blueimp.github.io/jQuery-File-Upload/ -->
                        <!-- The fileinput-button span is used to style the file input field as button -->
                        <div id="actions">
                        <input style="width: 100%;" type="file" name="files[]" class="btn btn-success start" multiple>
                            <i class="fa fa-plus"></i>
                            <span>Add files...</span>
                         </span>

                            <span class="btn btn-success fileinput-button start">
                            <i class="fa fa-plus"></i>
                            <span>Add files...</span>
                         </span> 

                                <button type="reset" class="btn btn-warning cancel">
                                    <i class="fa fa-ban"></i>&nbsp;
                                    <span>Cancel upload</span>
                                </button>

                                        <!-- The global file processing state -->
                              <span class="fileupload-process">
                              <div id="total-progress" class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0">
                                <div class="progress-bar progress-bar-default" style="width:0%;" data-dz-uploadprogress></div>
                              </div>
                            </span>

                            <p class="help-block">Max. <?php echo \YAWK\filemanager::getPostMaxSize(); ?></p>
                        </div>
                        <!-- /. bootstrap dropzone -->

                        <!-- dropzone preview -->
                        <!-- HTML heavily inspired by http://blueimp.github.io/jQuery-File-Upload/ -->
                        <div class="table table-striped files" id="previews">

                            <div id="template" class="file-row">
                                <!-- This is used as the file preview template -->
                                <div>
                                    <span class="preview"><img data-dz-thumbnail /></span>
                                </div>
                                <div>
                                    <p class="name" data-dz-name></p>
                                    <strong class="error text-danger" data-dz-errormessage></strong>
                                </div>
                                <div>
                                    <p class="size" data-dz-size></p>
                                    <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0">
                                        <div class="progress-bar progress-bar-success" style="width:0%;" data-dz-uploadprogress></div>
                                    </div>
                                </div>
                                <div>
                                    <button class="btn btn-primary start">
                                        <i class="glyphicon glyphicon-upload"></i>
                                        <span>Start</span>
                                    </button>
                                    <button data-dz-remove class="btn btn-warning cancel">
                                        <i class="glyphicon glyphicon-ban-circle"></i>
                                        <span>Cancel</span>
                                    </button>
                                    <button data-dz-remove class="btn btn-danger delete">
                                        <i class="glyphicon glyphicon-trash"></i>
                                        <span>Delete</span>
                                    </button>
                                </div>
                            </div>

                        </div>

                        <!-- end dropzone preview -->

                    </div>
            </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    <div class="pull-right">
                        <a href="index.php?page=webmail-compose&draft=1" type="button" class="btn btn-default"><i class="fa fa-pencil"></i>&nbsp; Draft</a>
                        <button type="submit" id="submitBtn" class="btn btn-success"><i class="fa fa-paper-plane-o"></i>&nbsp; Send</button>
                        <input type="hidden" name="sendEmail" value="true">
                    </div>
                    <a href="#" onclick="window.history.back();" title="discard and go back" type="button" class="btn btn-default"><i class="fa fa-times"></i> Discard</a>
                </div>
                <!-- /.box-footer -->

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

    $(document).ready(function() {
        Dropzone.autoDiscover = false;
// Get the template HTML and remove it from the doumenthe template HTML and remove it from the doument
        var previewNode = document.querySelector("#template");
        previewNode.id = "";
        var previewTemplate = previewNode.parentNode.innerHTML;
        previewNode.parentNode.removeChild(previewNode);

        var myDropzone = new Dropzone(document.body, { // Make the whole body a dropzone
            url: "index.php?page=webmail-compose", // Set the url
            paramName: 'files',
            uploadMultiple: true,
            thumbnailWidth: 180,
            thumbnailHeight: 180,
            parallelUploads: 20,
            acceptedFiles: ".jpg, .jpeg, .png, .gif, .pdf",
            previewTemplate: previewTemplate,
            autoProcessQueue: false,
            autoQueue: true, // Make sure the files aren't queued until manually added
            previewsContainer: "#previews", // Define the container to display the previews
            clickable: ".fileinput-button", // Define the element that should be used as click trigger to select files.

            // Language Strings
            dictFileTooBig: "File is to big ({{filesize}}mb). Max allowed file size is {{maxFilesize}}mb",
            dictInvalidFileType: "Invalid File Type",
            dictCancelUpload: "Cancel",
            dictRemoveFile: "Remove",
            dictMaxFilesExceeded: "Only {{maxFiles}} files are allowed",
            dictDefaultMessage: "Drop files here to upload"
        });

            myDropzone.on("addedfile", function(file) {
            // Hookup the start button
            file.previewElement.querySelector(".start").onclick = function() { myDropzone.enqueueFile(file); };
        });

            // Update the total progress bar
            myDropzone.on("totaluploadprogress", function(progress) {
            document.querySelector("#total-progress .progress-bar").style.width = progress + "%";
        });

            myDropzone.on("sending", function(file) {
            // Show the total progress bar when upload starts
            document.querySelector("#total-progress").style.opacity = "1";
            // And disable the start button
            file.previewElement.querySelector(".start").setAttribute("disabled", "disabled");
        });

            // Hide the total progress bar when nothing's uploading anymore
            myDropzone.on("queuecomplete", function(progress) {
            document.querySelector("#total-progress").style.opacity = "0";
        });

            // Setup the buttons for all transfers
            // The "add files" button doesn't need to be setup because the config
            // `clickable` has already been specified.
            document.querySelector("#actions .start").onclick = function() {
            myDropzone.enqueueFiles(myDropzone.getFilesWithStatus(Dropzone.ADDED));
        };
            document.querySelector("#actions .cancel").onclick = function() {
            myDropzone.removeAllFiles(true);
        };

        $('#submitBtn').click(function() {
            myDropzone.processQueue();
        });
    });

</script>
