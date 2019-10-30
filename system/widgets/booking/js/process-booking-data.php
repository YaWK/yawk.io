<?php
require_once '../../../classes/db.php';
require_once '../../../classes/sys.php';
require_once '../../../classes/settings.php';
require_once '../../../classes/email.php';
$db = new \YAWK\db();

// language object
if (!isset($lang) || (empty($lang)))
{   // load required language class
    require_once '../../../classes/language.php';
    // create new language obj
    $language = new \YAWK\language();
    // init language
    $language->init($db, "frontend");
    // convert object param to array !important
    $lang = (array) $language->lang;
    // inject widget language tags
    $lang = \YAWK\language::inject($lang, '../../../widgets/booking/language/');
}
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

    $subject = "".$lang['BOOKING_MAIL_BOOKING_REQUEST']." ".$lang['BOOKING_MAIL_FROM']." ".$_POST['name']."";

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
    <h2>".$lang['BOOKING_MAIL_BOOKING_REQUEST']." <small>".\YAWK\settings::getSetting($db, 'host')."</small></h2>
        <table width=\"100%\" cellspacing=\"2\" cellpadding=\"2\" border=\"1\" id=\"bookingTable\">
            <tr>
                <th>".$lang['BOOKING_MAIL_QUERY']."</th>
                <th>".$lang['BOOKING_MAIL_INPUT']."</th>
            </tr>
            <tr>
                <td width=\"25%\" align=\"right\" class=\"bold\">".$lang['LABEL_BOOKING_CONTACT_NAME']."</td>
                <td width=\"75%\">&nbsp;&nbsp;".$_POST['name']."</td>
            </tr>
            <tr>
                <td width=\"25%\" align=\"right\" class=\"bold\">".$lang['LABEL_BOOKING_PHONE']."</td>
                <td width=\"75%\">&nbsp;&nbsp;<a href=\"tel:".$_POST['phone']."\">".$_POST['phone']."</a></td>
            </tr>
            <tr>
                <td width=\"25%\" align=\"right\" class=\"bold\">".$lang['LABEL_BOOKING_EMAIL']."</td>
                <td width=\"75%\">&nbsp;&nbsp;".$_POST['email']."</td>
            </tr>
            <tr>
                <td width=\"25%\" align=\"right\" class=\"bold\">".$lang['BOOKING_MAIL_REMARKS']."</td>
                <td width=\"75%\">&nbsp;&nbsp;".$_POST['message']."</td>
            </tr>
            <tr>
                <td width=\"25%\" align=\"right\">&nbsp;</td>
                <td width=\"75%\">&nbsp;</td>
            </tr>
            <tr>
                <td width=\"25%\" align=\"right\" class=\"bold\">".$lang['LABEL_BOOKING_BAND']."</td>
                <td width=\"75%\">&nbsp;&nbsp;".$_POST['band']."</td>
            </tr>
            <tr>
                <td width=\"25%\" align=\"right\" class=\"bold\">".$lang['LABEL_BOOKING_EVENTDATETIME']."</td>
                <td width=\"75%\">&nbsp;&nbsp;".$_POST['eventDateTime']."</td>
            </tr>
            <tr>
                <td width=\"25%\" align=\"right\" class=\"bold\">".$lang['LABEL_BOOKING_LOCATION_TYPE']."</td>
                <td width=\"75%\">&nbsp;&nbsp;".$_POST['locationType']."</td>
            </tr>
            <tr>
                <td width=\"25%\" align=\"right\">".$lang['LABEL_BOOKING_LOCATION']."</td>
                <td width=\"75%\">&nbsp;&nbsp;".$_POST['location']."</td>
            </tr>
            <tr>
                <td width=\"25%\" align=\"right\">".$lang['LABEL_BOOKING_CROWD_AMOUNT']."</td>
                <td width=\"75%\">&nbsp;&nbsp;".$_POST['crowdAmount']."</td>
            </tr>
            <tr>
                <td width=\"25%\" align=\"right\">".$lang['LABEL_BOOKING_SOUNDCHECK']."</td>
                <td width=\"75%\">&nbsp;&nbsp;".$_POST['eventSoundcheck']."</td>
            </tr>
            <tr>
                <td width=\"25%\" align=\"right\">".$lang['LABEL_BOOKING_SOUNDCHECK_DURATION']."</td>
                <td width=\"75%\">&nbsp;&nbsp;".$_POST['soundcheckDuration']."</td>
            </tr>
            <tr>
                <td width=\"25%\" align=\"right\">".$lang['LABEL_BOOKING_SHOWTIME']."</td>
                <td width=\"75%\">&nbsp;&nbsp;".$_POST['eventShowtime']."</td>
            </tr>
            <tr>
                <td width=\"25%\" align=\"right\">".$lang['LABEL_BOOKING_SHOWTIME_DURATION']."</td>
                <td width=\"75%\">&nbsp;&nbsp;".$_POST['showtimeDuration']."</td>
            </tr>
            <tr>
                <td width=\"25%\" align=\"right\">".$lang['LABEL_BOOKING_SET_AMOUNT']."</td>
                <td width=\"75%\">&nbsp;&nbsp;".$_POST['setAmount']."</td>
            </tr>
            <tr>
                <td width=\"25%\" align=\"right\">".$lang['LABEL_BOOKING_PA_AVAILABLE']."</td>
                <td width=\"75%\">&nbsp;&nbsp;".$_POST['paAvailable']."</td>
            </tr>
            <tr>
                <td width=\"25%\" align=\"right\">".$lang['LABEL_BOOKING_TECH_AVAILABLE']."</td>
                <td width=\"75%\">&nbsp;&nbsp;".$_POST['techAvailable']."</td>
            </tr>
            <tr>
                <td width=\"25%\" align=\"right\">".$lang['LABEL_BOOKING_HOTEL_AVAILABLE']."</td>
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

    // build email header
    $header = "";
    $header .= "From: ".$_POST['adminEmail']."\r\n";
    $header .= "'Reply-To: ".$_POST['adminEmail']."\r\n";
    $header  = "MIME-Version: 1.0\r\n";
    $header .= "Content-type: text/html; charset=utf-8\r\n";
    // $header .= "X-Mailer: PHP ".phpversion()."";

    // send booking email to recipient
    $sent = mail($_POST['bookingAdminEmail'], $subject, $message, $header);

    // check if CC should be sent
    if (isset($_POST['adminCCEmail']) && (!empty($_POST['adminCCEmail'])))
    {   //
        $sent = mail($_POST['adminCCEmail'], $subject, $message, $header);
    }

    // check if copy should be sent
    if (isset($_POST['mailCopy']) && (!empty($_POST['mailCopy'])) && ($_POST['mailCopy'] == "true"))
    {   // send copy to sender
        $sent = mail($_POST['email'], $subject, $message, $header);
    }

    echo "true";

}