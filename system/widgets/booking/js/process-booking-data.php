<?php
require_once '../../../classes/db.php';
require_once '../../../classes/sys.php';
require_once '../../../classes/settings.php';
require_once '../../../classes/email.php';
$db = new \YAWK\db();

//
if (isset($_POST))
{
    // check if email is sent
    if (!isset($_POST['email']) || (empty($_POST['email'])))
    {
        echo "false";
    }

    // check if admin email is set (email address where bookings will be sent to)
    if (!isset($_POST['adminEmail']) || (empty($_POST['adminEmail'])))
    {
        // adminEmail not set - try to get it from YaWK's system settings
        $_POST['adminEmail'] = \YAWK\settings::getSetting($db, "admin_email");
        // if system adminEmail address is also not set
        if (!isset($_POST['adminEmail']) || (empty($_POST['adminEmail'])))
        {
            $systemAdminEmail = "false";
            echo "false";
            // todo: if no email addresses are set:
            // todo: solution would be to insert (add) $_POST data into the plugin / booking database...
        }
    }

    $subject = "Booking Anfrage von ".$_POST['name']."";

    $message = "
    <html>
    <head>
        <title>Booking Anfrage</title>
        <style type=\"text/css\">
        body{

              font-family: \"Trebuchet MS\", Arial, Helvetica, sans-serif;
        }
            #bookingtable {
              font-family: \"Trebuchet MS\", Arial, Helvetica, sans-serif;
              border-collapse: collapse;
              width: 100%;
            }

            #bookingtable td, #bookingtable th {
              border: 1px solid #ddd;
              padding: 8px;
            }

            #bookingtable tr:nth-child(even){background-color: #f2f2f2;}

            #bookingtable tr:hover {background-color: #ddd;}

            #bookingtable th {
              padding-top: 12px;
              padding-bottom: 12px;
              text-align: left;
              background-color: #4CAF50;
              color: white;
            }
            .bold {
                font-weight: bold;
            }
        </style>
    </head>
    <body>
    <h2>Booking Anfrage <small>funkyfingers.at</small></h2>
        <table width=\"100%\" cellspacing=\"2\" cellpadding=\"2\" border=\"1\" id=\"bookingTable\">
            <tr>
                <th>Abfrage</th>
                <th>Eingabe</th>
            </tr>
            <tr>
                <td width=\"25%\" align=\"right\" class=\"bold\">Name</td>
                <td width=\"75%\">&nbsp;&nbsp;".$_POST['name']."</td>
            </tr>
            <tr>
                <td width=\"25%\" align=\"right\" class=\"bold\">Telefon</td>
                <td width=\"75%\">&nbsp;&nbsp;<a href=\"tel:".$_POST['phone']."\">".$_POST['phone']."</a></td>
            </tr>
            <tr>
                <td width=\"25%\" align=\"right\" class=\"bold\">Email</td>
                <td width=\"75%\">&nbsp;&nbsp;".$_POST['email']."</td>
            </tr>
            <tr>
                <td width=\"25%\" align=\"right\" class=\"bold\">Anmerkungen</td>
                <td width=\"75%\">&nbsp;&nbsp;".$_POST['message']."</td>
            </tr>
            <tr>
                <td width=\"25%\" align=\"right\">&nbsp;</td>
                <td width=\"75%\">&nbsp;</td>
            </tr>
            <tr>
                <td width=\"25%\" align=\"right\" class=\"bold\">Band</td>
                <td width=\"75%\">&nbsp;&nbsp;".$_POST['band']."</td>
            </tr>
            <tr>
                <td width=\"25%\" align=\"right\" class=\"bold\">Veranstaltungsdatum</td>
                <td width=\"75%\">&nbsp;&nbsp;".$_POST['eventDateTime']."</td>
            </tr>
            <tr>
                <td width=\"25%\" align=\"right\" class=\"bold\">Art der Veranstaltung</td>
                <td width=\"75%\">&nbsp;&nbsp;".$_POST['locationType']."</td>
            </tr>
            <tr>
                <td width=\"25%\" align=\"right\">Location</td>
                <td width=\"75%\">&nbsp;&nbsp;".$_POST['location']."</td>
            </tr>
            <tr>
                <td width=\"25%\" align=\"right\">Gr&ouml;&szlig;e</td>
                <td width=\"75%\">&nbsp;&nbsp;".$_POST['crowdAmount']."</td>
            </tr>
            <tr>
                <td width=\"25%\" align=\"right\">Soundcheck Uhrzeit</td>
                <td width=\"75%\">&nbsp;&nbsp;".$_POST['eventSoundcheck']."</td>
            </tr>
            <tr>
                <td width=\"25%\" align=\"right\">Soundcheck Dauer</td>
                <td width=\"75%\">&nbsp;&nbsp;".$_POST['soundcheckDuration']."</td>
            </tr>
            <tr>
                <td width=\"25%\" align=\"right\">Showtime</td>
                <td width=\"75%\">&nbsp;&nbsp;".$_POST['eventShowtime']."</td>
            </tr>
            <tr>
                <td width=\"25%\" align=\"right\">Showtime Dauer</td>
                <td width=\"75%\">&nbsp;&nbsp;".$_POST['showtimeDuration']."</td>
            </tr>
            <tr>
                <td width=\"25%\" align=\"right\">Anzahl Sets</td>
                <td width=\"75%\">&nbsp;&nbsp;".$_POST['setAmount']."</td>
            </tr>
            <tr>
                <td width=\"25%\" align=\"right\">PA / Anlage</td>
                <td width=\"75%\">&nbsp;&nbsp;".$_POST['paAvailable']."</td>
            </tr>
            <tr>
                <td width=\"25%\" align=\"right\">Techniker vor Ort</td>
                <td width=\"75%\">&nbsp;&nbsp;".$_POST['techAvailable']."</td>
            </tr>
            <tr>
                <td width=\"25%\" align=\"right\">Overnight / Hotel</td>
                <td width=\"75%\">&nbsp;&nbsp;".$_POST['hotelAvailable']."</td>
            </tr>
        </table>
    </body>
    </html>";
/*
    $message = "
        Neue Booking Anfrage:
        =====================
        NAME                ".$_POST['name']."
        TELEFON             ".$_POST['phone']."
        EMAIL               ".$_POST['email']."
        ANMERKUNGEN         ".$_POST['message']."
        ----------------------------------------------------
        BAND                ".$_POST['band']."
        DATUM / ZEIT        ".$_POST['eventDateTime']."
        VERANSTALTUNG       ".$_POST['locationType']."
        LOCATION            ".$_POST['location']."
        GROESSE             ".$_POST['crowdAmount']."
        SOUNDCHECK          ".$_POST['eventSoundcheck']."
        SOUNDCHECK DAUER    ".$_POST['soundcheckDuration']."
        SHOWTIME            ".$_POST['eventShowtime']."
        SHOWTIME DAUER      ".$_POST['showtimeDuration']."
        ANZAHL SETS         ".$_POST['setAmount']."
        PA / ANLAGE         ".$_POST['paAvailable']."
        TECHNIKER           ".$_POST['techAvailable']."
        OVERNIGHT           ".$_POST['hotelAvailable']."
        ====================================================
    ";
*/
    $emailFrom = "assistant@funkyfingers.at";

    // build email header
    $header = "";
    $header .= "From: ".$emailFrom."\r\n";
    $header .= "'Reply-To: ".$_POST['email']."\r\n";
    $header  = "MIME-Version: 1.0\r\n";
    $header .= "Content-type: text/html; charset=utf-8\r\n";
    // $header .= "X-Mailer: PHP ".phpversion()."";

    // send booking email to recipient
    $sent = mail($_POST['adminEmail'], $subject, $message, $header);

    // check if copy should be sent
    if (isset($_POST['mailCopy']) && (!empty($_POST['mailCopy'])) && ($_POST['mailCopy'] == "true"))
    {   // send copy to sender
        $sent = mail($_POST['email'], $subject, $message, $header);
    }

    echo "true";

}