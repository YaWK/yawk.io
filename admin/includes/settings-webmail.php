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
                if ($property === "selectedTemplate")
                {
                    \YAWK\template::setTemplateActive($db, $value);
                }

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
<form id="backend-edit-form" action="index.php?page=settings-webmail" method="POST">
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
        <!-- backend settings -->
        <div class="col-md-4">
            <div class="box">
                <div class="box-body">
                    <?php // \YAWK\settings::getFormElements($db, $settings, 19, $lang); ?>
                    <?php \YAWK\settings::getFormElements($db, $settings, 23, $lang); ?>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="box">
                <div class="box-body">
                    <!-- footer settings -->
                    <?php \YAWK\settings::getFormElements($db, $settings, 22, $lang); ?>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="box">
                <div class="box-body">

                    <h3><i class="fa fa-inbox"></i> <?php echo $lang['MAILBOX_STATUS']; ?></h3>
                    <hr>
                    <?php
                    if (\YAWK\settings::getSetting($db, "webmail_active") == true)
                    {
                        $mailbox = \YAWK\settings::getSetting($db, "webmail_imap_server");
                        $username = \YAWK\settings::getSetting($db, "webmail_imap_username");
                        $password = \YAWK\settings::getSetting($db, "webmail_imap_password");
                        $encryption = "/".\YAWK\settings::getSetting($db, "webmail_imap_encrypt");
                        $port = ":".\YAWK\settings::getSetting($db, "webmail_imap_port")."";

                        if ($imap = @imap_open("{".$mailbox."".$port."".$encryption."}", $username, $password, OP_HALFOPEN))
                        {
                            echo "<h4 class=\"text-success\"><b>".$lang["CONNECTION_SUCCESSFUL"]."</b><br>
                                  <small><i><b>Server: </b></i>".$mailbox."".$port."".$encryption."<br><i><b>Mailbox: </b></i>".$username."</small></h4>";

                            echo "<br><a href=\"index.php?page=webmail\" class=\"btn btn-success\" target=\"_self\" style=\"color:#fff; width: 100%;\">
                                  <i class=\"fa fa-envelope-o\"></i>&nbsp; ".$lang["WEBMAIL_SHOW"]."</a><br><br><hr>";

                            echo "<h4>".$lang["MAILBOX_DETAILS"]."</h4>";

                            $status = imap_status($imap, "{".$mailbox."}INBOX", SA_ALL);
                            if ($status) {
                                echo "Messages:   " . $status->messages    . "<br />\n";
                                echo "Unseen:     " . $status->unseen      . "<br />\n";
                                echo "Recent:     " . $status->recent      . "<br />\n";
                                echo "UIDnext:    " . $status->uidnext     . "<br />\n";
                                echo "UIDvalidity:" . $status->uidvalidity . "<br />\n";
                            } else {
                                echo "".$lang["IMAP_STATUS_FAILED"]." : " . imap_last_error() . "\n";
                            }

                            $check = imap_mailboxmsginfo($imap);

                            if ($check) {
                                echo "Date: "     . $check->Date    . "<br />\n" ;
                                echo "Driver: "   . $check->Driver  . "<br />\n" ;
                                echo "Mailbox: "  . $check->Mailbox . "<br />\n" ;
                            } else {
                                echo "".$lang["IMAP_STATUS_FAILED"]." :  " . imap_last_error() . "<br />\n";
                            }

                            imap_close($imap);
                        }
                        else
                            {
                                echo "<h4 class=\"text-danger\"><b>".$lang["CONNECTION_FAILED"]."</b><br>
                                <br><small>".$lang["IMAP_DEBUG"]."</small><br>
                                ".imap_last_error()."";
                            }
                    }
                    else
                        {
                            echo "<div id=\"mailboxStatusInfo\">".$lang["WEBMAIL_NOT_ACTIVATED"]."</div>";
                        }
                    ?>
                </div>
            </div>
        </div>
    </div>
</form>
<script type="text/javascript">
    $(document).ready(function()
    {
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
        saveHotkey();


        var savebutton = ('#savebutton');
        var savebuttonIcon = ('#savebuttonIcon');
        // ok, lets go...
        // we need to check if user clicked on save button
        $(savebutton).click(function() {
            $(savebutton).removeClass('btn btn-success').addClass('btn btn-warning disabled');
            $(savebuttonIcon).removeClass('fa fa-check').addClass('fa fa-spinner fa-spin fa-fw');
        });


        /* END CHECKBOX backend footer */
    });
    /* END CHECKBOX backend fx */
</script>