<?php
// include required imap classes
require_once "../../system/engines/imapClient/ImapClient.php";
require_once "../../system/engines/imapClient/ImapClientException.php";
require_once "../../system/engines/imapClient/ImapConnect.php";
// include required yawk classes
require_once '../../system/classes/db.php';
require_once '../../system/classes/settings.php';
require_once '../../system/classes/webmail.php';
// create db object
$db = new \YAWK\db();
// create webmail object
$webmail = new \YAWK\webmail();

// let php know we need these classes:
use SSilence\ImapClient\ImapClientException;
use SSilence\ImapClient\ImapClient as Imap;

// get all webmail setting values into an array
$webmailSettings = \YAWK\settings::getValueSettingsArray($db, "webmail_");
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
// novalidate-cert
$novalidate = $webmailSettings['webmail_imap_novalidate'];
// create options array
$options = array($novalidate);

// lets go: open imap connection, check state and toggle required
try
{   // open connection to imap server
    $imap = new Imap($server.$port.$encryption, $username, $password, $encryption, 0, 0, $options);
    // connection successful, error = false
    $error = false;

    // @var $_POST['state'] string (seen|unseen) : check which state should be toggled
    if (isset($_POST['state']))
    {   // if email should be toggled to state 'not flagged'
        if ($_POST['state'] === "setUnFlagged")
        {   // remove flag from message
            if ($webmail->removeFlags($imap->getImap(), $_POST['uid']) == true)
            {   // remove flag successful
                echo "true";
            }
            else
            {   // remove flag failed
                echo "false";
            }
        }
        else
        {   // set message as flagged
            if ($webmail->markAsFlagged($imap->getImap(), $_POST['uid']) == true)
            {   // set flag successful
                echo "true";
            }
            else
            {   // set flag failed
                echo "false";
            }
        }
    }
}
    // open imap connection failed...
catch (ImapClientException $error)
{   // no errors in production...
    echo "false";
    echo "<script>console.log('.$error.');</script>";
}
?>