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

// imap connection only made be made if webmail is set to active
// get + store webmail_active setting
$webmail_active = \YAWK\settings::getSetting($db, "webmail_active");
// check if webmail is activated
if ($webmail_active == true)
{   // webmail enabled, get mailbox settings

    // mailbox server (imap.server.com)
    $server = \YAWK\settings::getSetting($db, "webmail_imap_server");
    // mailbox user (email@server.com)
    $username = \YAWK\settings::getSetting($db, "webmail_imap_username");
    // mailbox password
    $password = \YAWK\settings::getSetting($db, "webmail_imap_password");
    // encryption type (ssl, tsl, null)
    $encryption = "/" . \YAWK\settings::getSetting($db, "webmail_imap_encrypt");
    // port (default: 993)
    $port = ":" . \YAWK\settings::getSetting($db, "webmail_imap_port") . "";


    try // open connection to imap server
    {
        // create new imap handle
        $imap = new Imap($server.$port.$encryption, $username, $password, $encryption);

        // page webmail called with parameter - user requested a folder
        if (isset($_GET['folder']) && (!empty($_GET['folder']) && (is_string($_GET['folder']))))
        {    // select requested folder
            $imap->selectFolder($_GET['folder']);
            // set current folder string
            $imap->currentFolder = $_GET['folder'];
        }
        else
            // page webmail called w/o any parameters
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
        die('Oh no! Verbindung mit $mailbox als $username nicht moeglich!');
    }

    // include webmail class
    require_once "../system/classes/webmail.php";

    // create new webmail object
    $webmail = new \YAWK\webmail();

    // set connection info var
    $webmail->connectionInfo = "<i>$username</i>";
}
?>
<!-- JS: load data tables -->
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

if ($webmail_active == true)
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
                        <?php $webmail->drawMailboxControls("inbox", $lang); ?>
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
                            $emails = $imap->getMessages(5, $start = 0, 'DESC', 'ALL');
                                // $header = $imap->getBriefInfoMessages();
                                // print_r($header);
                                // $header = $imap->getMailboxStatistics();
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
                <?php $webmail->drawMailboxControls("inbox", $lang); ?>
            </div>
        </div>

        <?php
            echo "<pre>";
            // print_r($emails);
            // print_r($header);
            echo "</pre>";
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