<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.4.1/css/bootstrap.min.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.4.1/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
<?php
// include smtp mailer classes
require_once('../../system/engines/phpMailer/class.phpmailer.php');
require_once('../../system/engines/phpMailer/class.smtp.php');
require_once('../../system/classes/db.php');
require_once('../../system/classes/settings.php');
/* set database object */
if (!isset($db))
{   // create new db object
    $db = new \YAWK\db();
}
// get all webmail settings into array
$webmailSettings = \YAWK\settings::getValueSettingsArray($db, "webmail_");

// create new smtp mail object
$mail = new PHPMailer(true);
// set smtp config
try
{
    // Enable verbose debug output
    $mail->SMTPDebug = 0;
    // Set mailer to use SMTP
    $mail->isSMTP();
    //SMTP Host name
    $mail->Host       = $webmailSettings['webmail_smtp_server'];
    // Auth required
    $mail->SMTPAuth   = true;
    // SMTP Login
    $mail->Username   = $webmailSettings['webmail_smtp_username'];
    // SMTP Password
    $mail->Password   = $webmailSettings['webmail_smtp_pwd'];
    // Enable TLS encryption, `ssl` also accepted
    $mail->SMTPSecure = $webmailSettings['webmail_smtp_encrypt'];
    // TCP port to connect to
    $mail->Port       = $webmailSettings['webmail_smtp_port'];

    // from
    $mail->SetFrom($webmailSettings['webmail_smtp_username'], $webmailSettings['webmail_smtp_username']);
    // to
    $mail->addAddress($_POST['to'], $_POST['to']);     // Add a recipient

    // Attachments
    // NO ATTACHMENT
    if (!empty($_FILES))
    {
        if ($_FILES['files']['error'] == 4)
        {
            // files empty or upload error

            echo "<div class=\"row\">";
            echo "<div class=\"col-md-2\"></div>";
            echo "<div class=\"col-md-8 text-center\"><br><br><br><h2><i>...sending...</i><br><br><br><i class=\"fa fa-spinner fa-spin\"></i></h2></div>";
            echo "<div class=\"col-md-2\"></div>";
            echo "</div>";
        }
        else
        {
            $uploadDir = "../../media/mailbox/sent";
            // PROCESS w/ attachments
            foreach ($_FILES["files"]["tmp_name"] as $key => $error)
            {
                // echo "attachment $key<br>";
                if ($error == UPLOAD_ERR_OK)
                {
                    // temp upload filename
                    $tmp_name = $_FILES["files"]["tmp_name"][$key];
                    // original filename
                    $name = basename($_FILES["files"]["name"][$key]);
                    $newName = utf8_decode($name);
                    // add attachment
                    $mail->addAttachment($tmp_name, $newName);

                    /*
                    if (move_uploaded_file(, "$uploadDir/$name") == true)
                    {
                        // echo "YEP!";
                    }
                    else
                    {
                        // "NOPE";
                    }
                    // echo "processed: ".$_FILES["files"]["name"]["$key"]."<br>";
                    */
                }
                else
                {
                    // echo "Unable to upload - errocode: ".$error;

                }
            }
        }
    }

    // Content
    // Set email format to HTML
    $mail->isHTML(true);
    // set subject
    $mail->Subject = $_POST['subject'];
    // set message body
    $mail->Body    = $_POST['body'];
    // This is the body in plain text for non-HTML mail clients
    $mail->AltBody = $_POST['body'];
    // send email
    $mail->send();

    $server = "{".$webmailSettings['webmail_imap_server'].":".$webmailSettings['webmail_imap_port']."/imap/".$webmailSettings['webmail_imap_encrypt']."}";
    // $server = "{imap.world4you.com:993/imap/ssl}";
    //Tell your server to open an IMAP connection using the same username and password as you used for SMTP
    $imapStream = imap_open($server, $mail->Username, $mail->Password);
    // store email in folder + mark as seen
    $result = imap_append($imapStream, $server.'Sent', $mail->getSentMIMEMessage(), "\\Seen");
    // close imap connection
    imap_close($imapStream);
    // Message has been sent
    echo "<script>window.location.replace('../index.php?page=webmail');</script>";
}
catch (Exception $e)
    {
        // Message could not be sent. Mailer Error: {$mail->ErrorInfo}
    }


?>