<?php
// include required imap classes
require_once "../../system/engines/imapClient/ImapClient.php";
require_once "../../system/engines/imapClient/ImapClientException.php";
require_once "../../system/engines/imapClient/ImapConnect.php";
// include required yawk classes
require_once '../../system/classes/settings.php';
require_once '../../system/classes/db.php';
// create db object
$db = new \YAWK\db();

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
    {   // if email should be toggled to state unseen
        if ($_POST['state'] === "setUnseen")
        {   // flag message as UNSEEN
            if ($imap->setUnseenMessage($_POST['msgno']) == true)
            {   // set unseen successful
                echo "true";
            }
            else
            {   // set unseen failed
                echo "false";
            }
        }
        else
            {   // flag message as SEEN
                if ($imap->setSeenMessage($_POST['msgno']) == true)
                {   // set seen successful
                    echo "true";
                }
                else
                {   // set seen failed
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