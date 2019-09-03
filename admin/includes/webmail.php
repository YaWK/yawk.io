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
use SSilence\ImapClient\AdapterForOutgoingMessage;
use SSilence\ImapClient\Helper;
use SSilence\ImapClient\ImapClientException;
use SSilence\ImapClient\ImapConnect;
use SSilence\ImapClient\IncomingMessage;
use SSilence\ImapClient\IncomingMessageAttachment;
use SSilence\ImapClient\OutgoingMessage;
use SSilence\ImapClient\Section;
use SSilence\ImapClient\SubtypeBody;
use SSilence\ImapClient\TypeAttachments;
use SSilence\ImapClient\ImapClient as Imap;

// Next, we need to declare out variables:
// $mailbox = 'imap.world4you.com';
// $username = 'management@mashiko.at';
// $password = 'austriamagna123';

$mailbox = 'imap.world4you.com';
$username = 'development@mashiko.at';
$password = 'test1234';
$encryption = Imap::ENCRYPT_SSL; // TLS OR NULL accepted

require_once "../system/classes/webmail.php";
$webmail = new \YAWK\webmail();


// Open connection
try
{
    // create new imap handle
    $imap = new Imap($mailbox, $username, $password, $encryption);
    // set connection info var
    $webmail->connectionInfo = "<i>$username</i>";

    // check if user requested a different folder
    if (isset($_GET['folder']) && (!empty($_GET['folder']) && (is_string($_GET['folder']))))
    {	// select requested folder
        $imap->selectFolder($_GET['folder']);
        // set current folder string
        $imap->currentFolder = $_GET['folder'];
    }
    else    // page webmail called w/o any parameters
        {   // select default folder
            $imap->selectFolder('INBOX');
            $imap->currentFolder = "INBOX";
        }
}
// on error...
catch (ImapClientException $error)
{   // No errors in production...
    $webmail->connectionInfo = $error->getMessage().PHP_EOL;
    // Oh no :( we failed
    die('oh no! verbindung mit $mailbox als $username nicht moeglich!');
}


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
                <h3 class="box-title"><?php echo $imap->currentFolder; ?> </h3>
                <?php
                // if ($imap->currentFolder === "INBOX")
                // {
                    echo "<small>".$webmail->connectionInfo."</small>";
                // }

                ?>

                <div class="box-tools pull-right">
                    <div class="has-feedback">
                        <input type="text" class="form-control input-sm" placeholder="Search Mail">
                        <span class="glyphicon glyphicon-search form-control-feedback"></span>
                    </div>
                </div>
                <!-- /.box-tools -->
            </div>
            <!-- /.box-header -->
            <div class="box-body no-padding">
                <div class="mailbox-controls">
                    <!-- Check all button -->
                    <button type="button" class="btn btn-default btn-sm checkbox-toggle"><i class="fa fa-square-o"></i>
                    </button>
                    <div class="btn-group">
                        <button type="button" class="btn btn-default btn-sm"><i class="fa fa-trash-o"></i></button>
                        <button type="button" class="btn btn-default btn-sm"><i class="fa fa-reply"></i></button>
                        <button type="button" class="btn btn-default btn-sm"><i class="fa fa-share"></i></button>
                    </div>
                    <!-- /.btn-group -->
                    <button type="button" class="btn btn-default btn-sm"><a href="index.php?page=webmail&folder=<?php echo $imap->currentFolder; ?>"><i class="fa fa-refresh"></i></a></button>
                    <div class="pull-right">
                        <button type="button" class="btn btn-default btn-sm" title="Webmail Settings"><i class="fa fa-gear"></i></button>
                        <button type="button" class="btn btn-default btn-sm"><i class="fa fa-plus"></i></button>
                        <!-- /.btn-group -->
                    </div>
                    <!-- /.pull-right -->
                </div>
                <div class="table-responsive mailbox-messages">
                    <table cellpadding="0" cellspacing="0" class="table table-striped table-hover table-responsive" id="table-sort">
                        <thead>
                        <tr>
                            <td><div class="icheckbox_flat-blue" aria-checked="false" aria-disabled="false" style="position: relative;"><input type="checkbox" style="position: absolute; opacity: 0;"><ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins></div></td>
                            <td class="mailbox-star"></td>
                            <td class="mailbox-name">from</td>
                            <td class="mailbox-subject">subject</td>
                            <td class="mailbox-attachment"></td>
                            <td class="mailbox-date"></td>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                            $emails = array();
                            $imap->selectFolder($imap->currentFolder);
                            $emails = $imap->getMessages();
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
                <div class="mailbox-controls">
                    <!-- Check all button -->
                    <button type="button" class="btn btn-default btn-sm checkbox-toggle"><i class="fa fa-square-o"></i>
                    </button>
                    <div class="btn-group">
                        <button type="button" class="btn btn-default btn-sm"><i class="fa fa-trash-o"></i></button>
                        <button type="button" class="btn btn-default btn-sm"><i class="fa fa-reply"></i></button>
                        <button type="button" class="btn btn-default btn-sm"><i class="fa fa-share"></i></button>
                    </div>
                    <!-- /.btn-group -->
                    <button type="button" class="btn btn-default btn-sm"><i class="fa fa-refresh"></i></button>
                    <div class="pull-right">
                        1-50/200
                        <div class="btn-group">
                            <button type="button" class="btn btn-default btn-sm"><i class="fa fa-chevron-left"></i></button>
                            <button type="button" class="btn btn-default btn-sm"><i class="fa fa-chevron-right"></i></button>
                        </div>
                        <!-- /.btn-group -->
                    </div>
                    <!-- /.pull-right -->
                </div>
            </div>
        </div>

        <?php
            echo "<pre>";
            print_r($emails);
            echo "</pre>";
        ?>

    </div>
</div>
<?php
$imap->close();
?>