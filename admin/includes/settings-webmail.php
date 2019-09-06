<?php
// SAVE tpl settings
if(isset($_POST['save']))
{
    // loop through $_POST items
    foreach ($_POST as $property => $value)
    {
        if ($property != "save")
        {
            // check setting and call corresponding function
            if (substr($property, -5, 5) == '-long')
            {   // LONG VALUE SETTINGS
                if (!\YAWK\settings::setLongSetting($db, $property, $value))
                {   // throw error
                    \YAWK\alert::draw("warning", "Error", "Long Settings: Could not set long value <b>$value</b> of property <b>$property</b>","plugin=signup","4800");
                }
            }
            else
            {
                // save value of property to database
                \YAWK\settings::setSetting($db, $property, $value, $lang);
            }
        }
    }
    // load page again to show changes immediately
    \YAWK\sys::setTimeout("index.php?page=settings-webmail", 0);
}
?>
<?php
// get all template settings into array
$settings = \YAWK\settings::getAllSettingsIntoArray($db);

// TEMPLATE WRAPPER - HEADER & breadcrumbs
echo "
    <!-- Content Wrapper. Contains page content -->
    <div class=\"content-wrapper\" id=\"content-FX\">
    <!-- Content Header (Page header) -->
    <section class=\"content-header\">";
// draw Title on top
echo \YAWK\backend::getTitle($lang['SETTINGS'], $lang['WEBMAIL']);
echo \YAWK\backend::getSettingsBreadcrumbs($lang);
echo"</section><!-- Main content -->
    <section class=\"content\">";
/* page content start here */
?>
<form id="settings-webmail" action="index.php?page=settings-webmail" method="POST">
    <div class="box">
        <div class="box-body">
            <div class="col-md-10">
                <?php echo "<h4><i class=\"fa fa-envelope-o\"></i> $lang[WEBMAIL]&nbsp;$lang[WEBMAIL_SUBTEXT]</h4>"; ?>
            </div>
            <div class="col-md-2">
                <button class="btn btn-success pull-right" id="savebutton" name="save" style="margin-top:2px;"><i class="fa fa-check" id="savebuttonIcon"></i>&nbsp;&nbsp;<?php echo $lang['SAVE_SETTINGS']; ?></button>
            </div>
        </div>
    </div>
    <div class="row">
        <!-- email account and imap server settings -->
        <div class="col-md-4">
            <div class="box">
                <div class="box-body">
                    <!-- email account settings -->
                    <?php \YAWK\settings::getFormElements($db, $settings, 23, $lang); ?>

                </div>
            </div>
            <div class="box">
                <div class="box-body">
                    <!-- email server seettings -->
                    <?php \YAWK\settings::getFormElements($db, $settings, 22, $lang); ?>

                </div>
            </div>
        </div>
        <!-- webmail / mailbox settings box -->
        <div class="col-md-4">
            <div class="box">
                <div class="box-body">
                    <!-- webmail settings -->
                    <?php \YAWK\settings::getFormElements($db, $settings, 24, $lang); ?>

                </div>
            </div>
        </div>

        <!-- mailbox status box -->
        <div class="col-md-4">
            <div class="box">
                <div class="box-body">
                    <h3><i class="fa fa-inbox"></i> <?php echo $lang['MAILBOX_STATUS']; ?></h3>
                    <hr>
                    <?php
                    // connect to mailserver only if webmail is set to active
                    if (\YAWK\settings::getSetting($db, "webmail_active") == true)
                    {   // get mailbox settings
                        $server = \YAWK\settings::getSetting($db, "webmail_imap_server");
                        $username = \YAWK\settings::getSetting($db, "webmail_imap_username");
                        $password = \YAWK\settings::getSetting($db, "webmail_imap_password");
                        $encryption = "/".\YAWK\settings::getSetting($db, "webmail_imap_encrypt");
                        $port = ":".\YAWK\settings::getSetting($db, "webmail_imap_port")."";

                        // open connection to mailserver
                        if ($imap = @imap_open("{".$server."".$port."".$encryption."}", $username, $password, OP_HALFOPEN))
                        {
                            // draw connection status
                            echo "<h4 class=\"text-success\"><b>".$lang["CONNECTION_SUCCESSFUL"]."</b><br>
                                  <small><i><b>Server: </b></i>".$server."".$port."".$encryption."<br><i><b>Mailbox: </b></i>".$username."</small></h4>";

                            // draw webmail button
                            echo "<br><a href=\"index.php?page=webmail\" class=\"btn btn-success\" target=\"_self\" style=\"color:#fff; width: 100%;\">
                                  <i class=\"fa fa-envelope-o\"></i>&nbsp; ".$lang["WEBMAIL_SHOW"]."</a><br><br><hr>";

                            // mailbox details
                            echo "<h4>".$lang["MAILBOX_DETAILS"]."</h4>";

                            // get status of this inbox
                            $status = imap_status($imap, "{".$server."}INBOX", SA_ALL);
                            // if status could be detected...
                            if ($status)
                            {   // output data
                                echo "Messages:   " . $status->messages    . "<br />\n";
                                echo "Unseen:     " . $status->unseen      . "<br />\n";
                                echo "Recent:     " . $status->recent      . "<br />\n";
                                echo "UIDnext:    " . $status->uidnext     . "<br />\n";
                                echo "UIDvalidity:" . $status->uidvalidity . "<br />\n";
                            }
                            else
                                {   // no status information - draw error
                                    echo "".$lang["IMAP_STATUS_FAILED"]." : " . imap_last_error() . "\n";
                                }

                            // get more mailbox information
                            $check = imap_mailboxmsginfo($imap);

                            // if msginfo was successful
                            if ($check)
                            {   // show more information
                                echo "Date: "     . $check->Date    . "<br />\n" ;
                                echo "Driver: "   . $check->Driver  . "<br />\n" ;
                                echo "Mailbox: "  . $check->Mailbox . "<br />\n" ;
                            }
                            else
                                {   // no mailbox message info - draw error
                                    echo "".$lang["IMAP_STATUS_FAILED"]." :  " . imap_last_error() . "<br />\n";
                                }

                            // close imap connection
                            imap_close($imap);
                        }
                        else
                            {   // error: imap: unable to connect
                                echo "<h4 class=\"text-danger\"><b>".$lang["CONNECTION_FAILED"]."</b><br>
                                <br><small>".$lang["IMAP_DEBUG"]."</small><br>
                                ".imap_last_error()."";
                            }
                    }
                    else
                        {   // webmail not active: set info text
                            echo "<div id=\"mailboxStatusInfo\">".$lang["WEBMAIL_NOT_ACTIVATED"]."</div>";
                        }
                    ?>
                </div>
            </div>
        </div>
    </div>
</form>

<!-- include JS -->
<script type="text/javascript">
    $(document).ready(function()
    {   // set hotkey (STRG-S) function
        function saveHotkey() {
            // simply disables save event for chrome
            $(window).keypress(function (event) {
                if (!(event.which === 115 && (navigator.platform.match("Mac") ? event.metaKey : event.ctrlKey)) && !(event.which === 19)) return true;
                event.preventDefault();
                formmodified=0; // do not warn user, just save.
                return false;
            });
            // used to process the cmd+s and ctrl+s events
            $(document).keydown(function (event) {
                if (event.which === 83 && (navigator.platform.match("Mac") ? event.metaKey : event.ctrlKey)) {
                    event.preventDefault();
                    $('#savebutton').click(); // SAVE FORM AFTER PRESSING STRG-S hotkey
                    formmodified=0; // do not warn user, just save.
                    // save(event);
                    return false;
                }
            });
        }
        // call hotkey function
        saveHotkey();

        // set savebutton vars
        var savebutton = ('#savebutton');
        var savebuttonIcon = ('#savebuttonIcon');

        // check if user clicked on save button
        $(savebutton).click(function()
        {   // add loading info
            $(savebutton).removeClass('btn btn-success').addClass('btn btn-warning disabled');
            $(savebuttonIcon).removeClass('fa fa-check').addClass('fa fa-spinner fa-spin fa-fw');
        });
    });
</script>