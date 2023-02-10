<?php
namespace YAWK\BACKEND {

    use YAWK\alert;
    use YAWK\controller;
    use YAWK\settings;
    /**
     * @details <b>Admin LTE Template Class</b>
     *
     * This class serves a few methods that build the Admin LTE view in the backend.<br>
     *
     * <p><i>Class covers backend template functionality.
     * See Methods Summary for Details!</i></p>
     *
     * @author     Daniel Retzl <danielretzl@gmail.com>
     * @copyright  2009-2016 Daniel Retzl
     * @license    https://opensource.org/licenses/MIT
     * @version    1.0.0/
     * @since      File available since Release 1.0.0
     * @brief Backend class serves a few useful functions for the admin backend.
     */
    class AdminLTE
    {
        /**
         * @brief Admin LTE Template Class
         * @param string contains the backend skin (eg. skin-blue)*/
        public $backendSkin;
        /** * @param string the desired layout (eg. sidebar-mini ) */
        public $backendLayout;
        /** * @paceLoader string pace loader on top of page - true or false */
        public $paceLoader;

        /**
         * @brief AdminLTE constructor.
         * @param object $db Database object
         */
        public function __construct($db){
            // get skin setting
            $this->backendSkin = settings::getSetting($db, "backendSkin");
            if (empty($this->backendSkin)){
                $this->backendSkin = "skin-blue"; // default
            }
            // get layout setting
            $this->backendLayout = settings::getSetting($db, "backendLayout");
            if (empty($this->backendLayout)){
                $this->backendSkin = "sidebar-mini"; // default
            }
            // get pace loading setting
            if (settings::getSetting($db, "paceLoader") == "enabled")
            {
                $this->paceLoader = "
                    <!-- PACE JS -->
                    <script src=\"../system/engines/pace/pace.min.js\"></script>
                    <!-- PACE.css-->
                    <link rel=\"stylesheet\" href=\"../system/engines/pace/pace-minimal.css\">";

                $paceLoaderColor = "background: #". settings::getSetting($db, "paceLoaderColor").";";
                $paceLoaderHeight = "height: ". settings::getSetting($db, "paceLoaderHeight");
                $this->paceLoader .= "
                <style>
                    .pace .pace-progress {
                    ".$paceLoaderColor."";
                    $this->paceLoader .= "
                            ".$paceLoaderHeight."
                            }
                            </style>";
            }
            else
            {
                $this->paceLoader = '';
            }
        }

        /**
         * @brief Draw the HTML Header. Loads all .css and .js files
         * @return null
         */
        function drawHtmlHead(){
            echo "<!DOCTYPE html>
<html>
  <head>
    <meta charset=\"utf-8\">
    <meta http-equiv=\"content-type\" content=\"text/html; charset=utf-8\">
    <meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge\">
    <title>YaWK CMS AdminLTE 2 | Startseite</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content=\"width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no\" name=\"viewport\">
    <!-- favicon -->
    <link rel=\"shortcut icon\" type=\"image/x-icon\" href=\"favicon.ico\">
    <!-- apple touch icon -->
    <link rel=\"apple-touch-icon\" sizes=\"180x180\" href=\"apple-touch-icon.png\">
    <!-- windows tiles -->
    <meta name=\"msapplication-TileColor\" content=\"#ff6600\">
    <meta name=\"msapplication-TileImage\" content=\"mstile-144x144.png\">
    
    ".$this->paceLoader."
        
    <!-- Bootstrap 3.3.5 -->
    <link rel=\"stylesheet\" href=\"../system/engines/bootstrap3/dist/css/bootstrap.min.css\">
    <!-- Animate CSS -->
    <link rel=\"stylesheet\" href=\"../system/engines/animateCSS/animate.min.css\">
    <!-- Font Awesome -->
    <link rel=\"stylesheet\" href=\"../system/engines/font-awesome/css/font-awesome.min.css\">
    <!-- Theme style -->
    <link rel=\"stylesheet\" href=\"../system/engines/AdminLTE/css/AdminLTE.min.css\">
    <!-- AdminLTE Skins. We have chosen the skin-blue for this starter
          page. However, you can choose any other skin. Make sure you
          apply the skin class to the body tag so the changes take effect.
    -->
    <!-- AdminLTE custom backend skin -->
    <link rel=\"stylesheet\" href=\"../system/engines/AdminLTE/css/skins/$this->backendSkin.min.css\">

    <!-- include custom css -->
    <link rel=\"stylesheet\" href=\"../system/engines/AdminLTE/css/skins/custom.css\">

    <!-- jQuery 2.1.4 -->
    <script type=\"text/javascript\" src=\"../system/engines/jquery/jquery-2.2.3.min.js\"></script>
    
    <!-- moment.js (used by datetimepicker) --> 
    <script type=\"text/javascript\" src=\"../system/engines/jquery/moment.min.js\"></script>

    <!-- jQuery 3.0.0 -->
    <!-- <script type=\"text/javascript\" src=\"../system/engines/jquery/jquery-3.0.0.min.js\"></script> -->

    <!-- Notify JS -->
    <script src=\"../system/engines/jquery/notify/bootstrap-notify.min.js\"></script>
    
    <!-- YaWK Backend JS Functions -->
    <script type=\"text/javascript\" src=\"js/yawk-backend.js\"></script>
    
    <!-- favicons -->
    <link rel=\"apple-touch-icon\" sizes=\"180x180\" href=\"apple-touch-icon.png\">
    <link rel=\"icon\" type=\"image/png\" sizes=\"32x32\" href=\"favicon-32x32.png\">
    <link rel=\"icon\" type=\"image/png\" sizes=\"16x16\" href=\"favicon-16x16.png\">
    <link rel=\"manifest\" href=\"site.webmanifest\">
    <link rel=\"mask-icon\" href=\"safari-pinned-tab.svg\" color=\"#000000\">
    <meta name=\"msapplication-TileColor\" content=\"#000000\">
    <meta name=\"theme-color\" content=\"#ffffff\">

    <!-- inject bootstrap 4 light + dark buttons -->
    <style>
        .btn-light {
          color: #212529;
          background-color: #f8f9fa;
          border-color: #f8f9fa;
        }
        
        .btn-light:hover {
          color: #212529;
          background-color: #e2e6ea;
          border-color: #dae0e5;
        }
        
        .btn-light:focus, .btn-light.focus {
          box-shadow: 0 0 0 0.2rem rgba(248, 249, 250, 0.5);
        }
        
        .btn-light.disabled, .btn-light:disabled {
          color: #212529;
          background-color: #f8f9fa;
          border-color: #f8f9fa;
        }
        
        .btn-light:not(:disabled):not(.disabled):active, .btn-light:not(:disabled):not(.disabled).active,
        .show > .btn-light.dropdown-toggle {
          color: #212529;
          background-color: #dae0e5;
          border-color: #d3d9df;
        }
        
        .btn-light:not(:disabled):not(.disabled):active:focus, .btn-light:not(:disabled):not(.disabled).active:focus,
        .show > .btn-light.dropdown-toggle:focus {
          box-shadow: 0 0 0 0.2rem rgba(248, 249, 250, 0.5);
        }
        
        .btn-dark {
          color: #fff;
          background-color: #343a40;
          border-color: #343a40;
        }
        
        .btn-dark:hover {
          color: #fff;
          background-color: #23272b;
          border-color: #1d2124;
        }
        
        .btn-dark:focus, .btn-dark.focus {
          color:#fff;
          box-shadow: 0 0 0 0.2rem rgba(52, 58, 64, 0.5);
        }
        
        .btn-dark.disabled, .btn-dark:disabled {
          color: #fff;
          background-color: #343a40;
          border-color: #343a40;
        }
        
        .btn-dark:not(:disabled):not(.disabled):active, .btn-dark:not(:disabled):not(.disabled).active,
        .show > .btn-dark.dropdown-toggle {
          color: #fff;
          background-color: #1d2124;
          border-color: #171a1d;
        }
        
        .btn-dark:not(:disabled):not(.disabled):active:focus, .btn-dark:not(:disabled):not(.disabled).active:focus,
        .show > .btn-dark.dropdown-toggle:focus {
          box-shadow: 0 0 0 0.2rem rgba(52, 58, 64, 0.5);
        }
    </style>
    
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src=\"https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js\"></script>
        <script src=\"https://oss.maxcdn.com/respond/1.4.2/respond.min.js\"></script>
    <![endif]-->
  </head>
  <!--
    BODY TAG OPTIONS:
    =================
    Apply one or more of the following classes to get the
    desired effect
    |---------------------------------------------------------|
    | SKINS         | skin-blue                               |
    |               | skin-black                              |
    |               | skin-purple                             |
    |               | skin-yellow                             |
    |               | skin-red                                |
    |               | skin-green                              |
    |---------------------------------------------------------|
    |LAYOUT OPTIONS | fixed                                   |
    |               | layout-boxed                            |
    |               | layout-top-nav                          |
    |               | sidebar-collapse                        |
    |               | sidebar-mini                            |
    |---------------------------------------------------------|
    -->";
            return null;
        } // ./ drawHtmlHeader

        /**
         * @brief Draw body and header Tag
         * @return null
         */
        function drawHtmlBody(){
            echo "
    <body class=\"hold-transition $this->backendSkin $this->backendLayout\">
        <div class=\"wrapper\">
        <!-- Main Header -->
        <header class=\"main-header\">";
            return null;
        }

        /**
         * @brief Draw logo in the top left corner
         * @param object $db database object
         * @param object $lang language array
         * @return null
         */
        function drawHtmlLogo($db, $lang)
        {   // check, if URL or personal text should be displayed...
            if ($this->backendLayout == "layout-top-nav"){
                return null;
            }
            if (settings::getSetting($db, "backendLogoUrl") == "1")
            {   // URL is requested, -> get hostname (project URL)
                $host = settings::getSetting($db, "host");
                $chars = (strlen($host));
                if ($chars <= 24)
                {
                    $logoText = "<small class=\"h4\">$host</small>";
                }
                else if ($chars >= 25)
                {
                    $logoText = "<small class=\"h5\">$host</small>";
                }
            }
            else
            {   // personal text requested, -> get logo text + subtext
                $logoText = "<b>". settings::getSetting($db, "backendLogoText")."</b>";
                $logoText .= settings::getSetting($db, "backendLogoSubText");
            }
            echo "<!-- Logo -->
            <a href=\"../index.html\" class=\"logo\" title=\"$lang[GOTO_WEBSITE]\" target=\"_blank\">
              <!-- mini logo for sidebar mini 50x50 pixels -->
              <span class=\"logo-mini\"><b class=\"fa fa-globe\"></b></span>
              <!-- logo for regular state and mobile devices -->
              <span class=\"logo-lg\">$logoText</span>
            </a>";
            return null;
        }

        /**
         * @brief Draw the navbar (top)
         * @return null
         */
        function drawHtmlNavbar(){
            if ($this->backendLayout == "layout-top-nav"){
                echo "
    <nav class=\"navbar navbar-static-top\" role=\"navigation\">
      <div class=\"container\">
        <div class=\"navbar-header\">
          <a href=\"../../index2.html\" class=\"navbar-brand\"><b>Admin</b>LTE</a>
          <button type=\"button\" class=\"navbar-toggle collapsed\" data-toggle=\"collapse\" data-target=\"#navbar-collapse\">
            <i class=\"fa fa-bars\"></i>
          </button>
        </div>";
            }
            else {
                echo "<!-- Header Navbar -->
            <nav class=\"navbar navbar-static-top\" role=\"navigation\">
              <!-- Sidebar toggle button-->
              <a href=\"#\" id=\"sidebarToggle\" class=\"sidebar-toggle\" data-toggle=\"offcanvas\" role=\"button\">
                <span class=\"sr-only\">Toggle navigation</span>
              </a>";

            }
            return null;
        }

        /**
         * @brief Draw right navbar
         * @return null
         */
        function drawHtmlNavbarRightMenu(){
            echo "<!-- Navbar Right Menu -->
              <div class=\"navbar-custom-menu\">
                <ul class=\"nav navbar-nav\">";
            return null;
        }

        /**
         * @brief Draw backup icon on navbar top beside preview icon
         * @param array $lang Language Array
         * @return null
         */
        function drawHtmlNavbarBackupIcon($lang)
        {
            // set menu to active if user clicked on preview icon
            if (isset($_GET['page']) && (!empty($_GET['page']) && ($_GET['page'] === "settings-backup")))
            {
                $selected = ' class="active"';
            }
            else { $selected = ''; }
            echo  "<li $selected>
                <!-- preview eye icon -->
                <a href=\"index.php?page=settings-backup\" title=\"$lang[BACKUP]\">
                  <i class=\"fa fa-hdd-o\"></i>
                </a>
                </li>";
            return null;
        }

        /**
         * @brief Draw preview page icon on navbar top beside other notification icons
         * @param array $lang Language Array
         * @return null
         */
        function drawHtmlNavbarPreviewIcon($lang)
        {
            // admin edit a page
            if (isset($_GET['alias']) && (!empty($_GET['alias'])))
            {   // show this page as preview
                $history = "&alias=$_GET[alias]";
            }
            // admin is configuring the userpage
            else if (isset($_GET['plugin']) && (!empty($_GET['plugin']) && ($_GET['plugin'] === "userpage")))
            {   // load frontend user page as preview
                $history = "&alias=welcome";
            }
            // admin is on plugin configuration page
            else if (isset($_GET['plugin']) && (!empty($_GET['plugin'])))
            {   // try to load the plugin page as preview
                $history = "&alias=$_GET[plugin]";
            }
            else
            {   // default: index.html
                $history = '';
            }

            // set menu to active if user clicked on preview icon
            if (isset($_GET['page']) && (!empty($_GET['page']) && ($_GET['page'] === "frontend-preview")))
            {
                $selected = ' class="active"';
            }
            else { $selected = ''; }
            echo  "<li $selected>
                <!-- preview eye icon -->
                <a href=\"index.php?page=frontend-preview".$history."\" title=\"$lang[QUICK_PREVIEW]\">
                  <i class=\"fa fa-eye\"></i>
                </a>
                </li>";
            return null;
        }

        /**
         * @brief Messages Menu: the small icon in the right corner of top navigation. This is a facebook-like messaging preview.
         * @param object $db Database object
         * @param array $lang Language array
         * @return null
         */
        function drawHtmlNavbarMessagesMenu($db, $lang){
            // count + return unread messages
            $i = \YAWK\user::countNewMessages($db, $_SESSION['uid']);
            if ($i === 1)
            {   // set singular
                $msg = $lang['CHAT'];
                $unread = $lang['UNREAD_SINGULAR'];
                $label = "<span id=\"messaging-label\" class=\"label label-primary animated swing\">$i</span>";
                $animated = "animated tada";
            }
            else
            {   // set plural correctly
                $msg = $lang['CHATS'];
                $unread = $lang['UNREAD_PLURAL'];
                $label = "<span id=\"messaging-label\" class=\"label label-primary animated swing\">$i</span>";
                $animated = "animated tada";
            }
            if ($i === 0)
            {
                // if notification available, ring bell and show label...
                $envelope = "tada";
                $label = '';
                $animated = '';
            }
            // get all unread message data
            $newMessages = \YAWK\user::getNewMessages($db, $_SESSION['uid']);

            echo "
              <!-- Messages: style can be found in dropdown.less-->
              <li class=\"dropdown messages-menu\">
                <!-- Menu toggle button -->
                <a href=\"#\" class=\"dropdown-toggle\" data-toggle=\"dropdown\">
                  <i class=\"fa fa-comment-o $animated\"></i>
                  $label
                </a>
                <ul class=\"dropdown-menu\">
                  <li class=\"header\">$lang[SYSLOG_YOU_HAVE] <span id=\"messagesCounterMenu\">$i</span> $unread $msg</li>
                  <li>
                    <!-- inner menu: contains the messages -->
                    <ul class=\"menu\">";
            // loop new messages data
            foreach ($newMessages as $message)
            {   // get sender username from ID

                $from = \YAWK\user::getUserNameFromID($db, $message['fromUID']);
                $picture = \YAWK\user::getUserImage("backend", $from, "img-circle", 20,20);
                $timeago = \YAWK\sys::time_ago($message['msg_date'], $lang);
                $msg_id = $message['msg_id'];
                // get 32 chars message preview
                $preview = $message['msg_body'];
                $preview = substr($preview, -80);
                $message = substr($message['msg_body'], -30);
                // $preview = substr($message['msg_body'], -10);
                // $preview = $message['msg_body'];

                echo"<li><!-- start message -->
                           <a href=\"index.php?plugin=messages&pluginpage=mailbox&msg_id=".$msg_id."\" title=\"$preview\">
                          <div class=\"pull-left\">
                            <!-- User Image -->
                            $picture
                            <!-- <img src=\"../media/images/users/admin.jpg\" class=\"img-circle\" alt=\"User Image\"> -->
                          </div>
                          <!-- Message title and timestamp -->
                          <h4>
                            $from
                            <small><i class=\"fa fa-clock-o\"></i> $timeago </small>
                          </h4>
                          <!-- The message -->
                          <p>$message</p>
                        </a>
                      </li><!-- end message -->";
            }
            // ./ end foreach new messages

            echo "</ul><!-- /.menu -->
                  </li>
                  <li class=\"footer\"><a href=\"index.php?plugin=messages&pluginpage=mailbox\">See All Messages</a></li>
                </ul>
              </li><!-- /.messages-menu -->";
            return null;
        }


        /**
         * @brief Webmail Menu: small envelope icon in the right corner of top navigation. This is a preview of your emails (if you use webmail)
         * @param object $db Database object
         * @param array $lang Language array
         * @return null
         */
        function drawHtmlNavbarWebmailMenu($db, $lang)
        {
            // count + return unread messages
            // get imap settings
            $webmailSettings = settings::getValueSettingsArray($db, "webmail_imap_");
            $server = $webmailSettings['webmail_imap_server'];
            $port = $webmailSettings['webmail_imap_port'];
            $encrypt = $webmailSettings['webmail_imap_encrypt'];
            $username = $webmailSettings['webmail_imap_username'];
            $password = $webmailSettings['webmail_imap_password'];
            $novalidate = $webmailSettings['webmail_imap_novalidate'];
            if (!empty($novalidate)){ $novalidate = "/".$novalidate; } else { $novalidate = ''; }

            // connect to mailbox:
            // prepare imap mailbox string
            $mailbox = '{'.$server.':'.$port.'/imap/'.$encrypt.''.$novalidate.'}INBOX';

            // check if imap extension is available
            if (function_exists('imap_open'))
            {   // open new imap connection
                $imap = @imap_open($mailbox, $username, $password);
                // get all unseen messages
                $emails = @imap_search($imap, 'UNSEEN');
            }
            else
            {   //($db, $log_category, $log_type, $message, $fromUID, $toUID, $toGID, $seen)
                \YAWK\sys::setSyslog($db, 4, 2, "Imap Extension not activated. Try apt-get install php[x]-imap or ask your server admin.", 0, 0, 0, 0);
            }

            // check, if any unseen emails are there
            if (empty($emails))
            {   // nope, no unseen emails
                $i = 0;
            }
            else
            {   // yep: count emails
                $i = count ($emails);
            }

            // one email only
            if ($i == 1)
            {   // set singular
                $msg = $lang['EMAIL'];
                $unread = $lang['UNREAD_SINGULAR'];
                $label = "<span id=\"envelope-label\" class=\"label label-success animated swing\">$i</span>";
                $animated = "animated tada";
            }
            else
            {   // set plural correctly
                $msg = $lang['EMAILS'];
                $unread = $lang['UNREAD_PLURAL'];
                $label = "<span id=\"envelope-label\" class=\"label label-success animated swing\">$i</span>";
                $animated = "animated tada";
            }
            // no email available...
            if ($i === 0)
            {
                // if notification available, ring bell and show label...
                $envelope = "tada";
                $label = '';
                $animated = '';
            }

            // get all unread message data

            echo "
              <!-- Messages: style can be found in dropdown.less-->
              <li class=\"dropdown messages-menu\">
                <!-- Menu toggle button -->
                <a href=\"#\" class=\"dropdown-toggle\" data-toggle=\"dropdown\">
                  <i class=\"fa fa-envelope-o $animated\"></i>
                  $label
                </a>
                <ul class=\"dropdown-menu\">
                  <li class=\"header\">$lang[SYSLOG_YOU_HAVE] <span id=\"emailCounterMenu\">$i</span> $unread $msg</li>
                  <li>
                    <!-- inner menu: contains the messages -->
                    <ul class=\"menu\">";
            if(isset($emails))
            {
                // newest first
                rsort($emails);

                // for every email...
                foreach($emails as $email_number) {
                    /* get information specific to this email */
                    $overview = @imap_fetch_overview($imap,$email_number,0);
                    // $message = utf8_decode(imap_fetchbody($imap,$email_number, 1));

                    // current email number
                    $email_number;
                    // get email header params
                    $overview[0]->subject;
                    $overview[0]->from;
                    $overview[0]->date;
                    $overview[0]->size;
                    $overview[0]->uid;

                    // calculate huma-friendly time
                    $timeAgo = \YAWK\sys::time_ago($overview[0]->date, $lang);

                    // output every email as single line
                    echo "<li>
                        <a href=\"index.php?page=webmail-message&folder=inbox&msgno=".$email_number."\">
                        <b><small>".utf8_decode(imap_utf8($overview[0]->from))."</small></b><br>
                        ".$overview[0]->subject."<br>";
                    // <small>".substr($message, 0, 64)."</small><br>
                    echo"<small><i class=\"fa fa-clock-o\"></i> ".$timeAgo."</small>
                        </a>    
                    </li>";
                }
            }
            // ./ end foreach new messages

            echo "</ul><!-- /.menu -->
                  </li>
                  <li class=\"footer\"><a href=\"index.php?page=webmail\">$lang[WEBMAIL_SHOW]</a></li>
                </ul>
              </li><!-- /.messages-menu -->";
            return null;
        }

        /**
         * @brief Draw navbar notification. This tells you whats going on in your project.
         * @param object $db Database object
         * @param object $lang Language object
         * @param $user
         * @return null
         */
        function drawHtmlNavbarNotificationsMenu($db, $user, $lang)
        {
            echo "";

            $i_syslog = \YAWK\user::countNotifications($db);
            $i_notifications = \YAWK\user::countMyNotifications($db, $_SESSION['uid']);
            $i_total = $i_syslog + $i_notifications;
            $notifications = \YAWK\user::getAllNotifications($db);
            $my_notifications = \YAWK\user::getMyNotifications($db, $_SESSION['uid']);

            if ($i_total !== 0)
            {   // if notification available, ring bell and show label...
                $bell = "swing";
                $label = "<span id=\"bell-label\" class=\"label label-warning animated tada\">$i_total</span>";
                // set singular
                $notification = $lang['SYSLOG_NOTIFICATIONS'];
            }
            else
            {   // no notification available
                $bell = '';
                $label = '';
                // set plural
                $notification = $lang['SYSLOG_NOTIFICATIONS'];
            }
            if ($i_total === '1')
            {   // set singular correctly
                $notification = $lang['SYSLOG_NOTIFICATION'];
            }
            echo "<script type=\"text/javascript\">
            
            
            </script>
              <!-- Notifications Menu -->
              <li id=\"notification-dropdown\" class=\"dropdown notifications-menu\">
                <!-- Menu toggle button -->
                <a href=\"#\" class=\"dropdown-toggle\" data-toggle=\"dropdown\">
                  <i class=\"fa fa-bell-o animated $bell\"></i>
                  $label
                  </a>
                <ul id=\"notification-dropdownlink\" class=\"dropdown-menu\">
                  <li id=\"notification-header\" class=\"header\">$lang[SYSLOG_YOU_HAVE] <span id=\"notificationsMenuCounter\">$i_total</span> $notification <small><small>(<a href=\"#\" id=\"dismiss\" data-uid=\"$_SESSION[uid]\" title=\"$lang[SYSLOG_DISMISS_ALL]\">$lang[SYSLOG_MARK_AS_READ]</a>)</small></small></li>
                  <li>
                    <!-- Inner Menu: contains the notifications -->
                    <ul id=\"notification-menu\" class=\"menu\">";
            if (isset($my_notifications) && is_array($my_notifications))
            {   // if personal notifications are available
                $i = 0;
                foreach ($my_notifications as $my_note)
                {
                    $getUsername = 0;
                    $UID = 0;

                    // calculate datetime pretty
                    $timeAgo = \YAWK\sys::time_ago($my_note['log_date'], $lang);

                    // PREPARE VARS FOR PERSONAL NOTIFICATIONS
                    // #user# wants to be your friend
                    if ($my_note['msg_id'] == 1)
                    {   // who (from)
                        $UID = $my_note['fromUID'];
                        $getUsername = 1;
                    }
                    // #user# accepted / declined your friendship
                    if ($my_note['msg_id'] == 2 || $my_note['msg_id'] == 3)
                    {   //
                        $UID = $my_note['fromUID'];
                        $getUsername = 1;
                    }
                    // #user# disconnected your friendship
                    if ($my_note['msg_id'] == 4)
                    {   // find out correct user who sent the original request
                        if ($my_note['toUID'] == $_SESSION['uid'])
                        {
                            $UID = $my_note['fromUID'];
                            $getUsername = 1;
                        }
                        elseif ($my_note['fromUID'] == $_SESSION['uid'])
                        {
                            $UID = $my_note['toUID'];
                            $getUsername = 1;
                        }
                    }
                    // #users# follows you
                    if ($my_note['msg_id'] == 5 || $my_note['msg_id'] == 6)
                    {
                        $UID = $my_note['fromUID'];
                        $getUsername = 1;
                    }

                    if ($getUsername == '1')
                    {   // replace #username# with proper username
                        $username = \YAWK\user::getUserNameFromID($db, $UID);
                        $my_msg = str_replace('#username#', $username,$my_note['message']);
                    }
                    else
                    {   // just output the plain notifiy msg from db
                        $my_msg = $my_note['message'];
                    }
                    $i++;

                    echo "<li><!-- start notification -->
                            <a href=\"index.php?page=friendslist\" id=\"labelNotification\" title=\"\">
                              <div class=\"pull-left\">
                                <i id=\"label-".$i."\" class=\"$my_note[icon] $my_note[type]\"></i>&nbsp; <small><i>$my_msg</i><br>
                              </div>
                              <h4>
                                <small class=\"pull-right\"><br><i class=\"fa fa-clock-o\"></i> $timeAgo </small></small>
                              </h4>
                            </a>

                          </li><!-- end notification -->";
                }
            }

            if (isset($notifications) && is_array($notifications))
            {   // if notifications are available
                foreach ($notifications as $note)
                {   // loop data
                    $timeAgo = \YAWK\sys::time_ago($note['log_date'], $lang);

                    echo "<li id=\"note-$note[log_id]\"><a href=\"index.php?page=syslog#$note[log_id]\" title=\"\">
                            <div class=\"pull-left\">
                            <!-- User Image -->
                                <i class=\"$note[icon] $note[type]\"></i>&nbsp; <small>$note[message]<br>
                            </div>
                          <h4>
                            <small class=\"pull-right\"><br><br><i class=\"fa fa-clock-o\"></i> $timeAgo</small></small>
                          </h4>
                          <!-- Message title and timestamp -->
                          <!-- The message -->

                        </a></li>";
                }
            }
            echo "</ul>
                  </li>
                  <li class=\"footer\"><a id=\"syslogLink\" data-uid=\"$_SESSION[uid]\" href=\"index.php?page=syslog\">$lang[SYSLOG_VIEW]</a></li>
                </ul>
              </li>";
            return null;
        }

        /**
         * @brief Show your user account details. Counts your friends and connections, let you log out.
         * @param object $db Database object
         * @param object $user User object
         * @return null
         */
        function drawHtmlNavbarUserAccountMenu($db, $user){
            $currentuser = \YAWK\backend::getFullUsername($user);
            $currentuser_image = \YAWK\user::getUserImage("backend", $user->username, "img-circle", 140, 140);
            $currentuser_navbar_image = \YAWK\user::getUserImage("backend", $user->username, "user-image", '', '');
            if (isset($user->job) && (!empty($user->job)))
            {
                $currentuser_job = "<i>$user->job</i>";
            }
            else
            {
                $currentuser_job = '';
            }
            if (isset($user->date_created) && (!empty($user->date_created)))
            {
                $member_since = \YAWK\sys::splitDate($user->date_created);
                // print_r($member_since);
                $currentuser_created = "Member since $member_since[month] $member_since[year]";
            }
            else
            {
                $currentuser_created = '';
            }
            if (isset($user->gid) && (!empty($user->gid)))
            {
                $currentuser_group = \YAWK\user::getGroupNameFromID($db, $user->gid);
            }
            else
            {
                $currentuser_group = '';
            }
            echo "
              <!-- User Account Menu -->
              <li class=\"dropdown user user-menu\">
                <!-- Menu Toggle Button -->
                <a href=\"#\" class=\"dropdown-toggle\" data-toggle=\"dropdown\">
                  <!-- The user image in the navbar-->
                  $currentuser_navbar_image
                  <!-- <img src=\"../media/images/users/admin.jpg\" class=\"user-image\" alt=\"User Image\"> -->
                  <!-- hidden-xs hides the username on small devices so only the image appears. -->
                  <span class=\"hidden-xs\">$currentuser</span>
                </a>
                <ul class=\"dropdown-menu\">
                  <!-- The user image in the menu -->
                  <li class=\"user-header\">
                  $currentuser_image
                    <p>
                      <b><a class=\"menuLink\" href=\"index.php?page=user-edit&user=$user->username\">$currentuser</a></b>
                      <small>$currentuser_job</small>
                      <small>$currentuser_group $currentuser_created</small>
                    </p>
                  </li>
                  <!-- Menu Body -->
                  <li class=\"user-body\">
                    <div class=\"col-xs-4 text-center\">
                      <a href=\"index.php?page=list-follower\" style=\"display: block;\">"; echo \YAWK\user::countMyFollowers($db, $user->id); echo " Followers</a>
                    </div>
                    <div class=\"col-xs-4 text-center\">
                      <a href=\"#\" style=\"display: block;\">"; echo $user->likes; echo "<br>Likes</a>
                    </div>
                    <div class=\"col-xs-4 text-center\">
                      <a href=\"index.php?page=friendslist\" style=\"display: block;\">"; echo \YAWK\user::countMyFriends($db, $user->id); echo " Friends</a>
                    </div>
                  </li>
                  <!-- Menu Footer-->
                  <li class=\"user-footer\">
                    <div class=\"pull-left\">
                      <a href=\"index.php?page=user-edit&user=$user->username\" class=\"btn btn-light\" title=\"edit $user->username profile\">Profile</a>
                    </div>
                    <div class=\"pull-right\">
                      <a href=\"index.php?page=logout\" class=\"btn btn-danger\"><i class=\"fa fa-power-off\"></i> &nbsp;Sign out</a>
                    </div>
                  </li>
                </ul>
              </li>";
            return null;
        }

        /**
         * @brief End Navbar
         * @return null
         */
        function drawHtmlNavbarHeaderEnd(){
            echo "
                  <!-- Control Sidebar Toggle Button -->
                  <li>
                    <a href=\"#\" data-toggle=\"control-sidebar\"><i class=\"fa fa-gears\"></i></a>
                    </li>
                </ul>
              </div>
            </nav>
          </header>";
            return null;
        }

        /**
         * @brief Left sidebar navigation
         * @param object $db Database object
         * @param object $user User object
         * @param object $lang Language object
         * @return null
         */
        function drawHtmlLeftSidebar($db, $user, $lang){

            $currentuser = \YAWK\backend::getFullUsername($user);
            $currentuser_image = \YAWK\user::getUserImage("backend", $user->username, "img-circle sidebar-toggle", 64, 64);
            echo "<!-- Left side column. contains the logo and sidebar -->
          <aside class=\"main-sidebar\">

            <!-- sidebar: style can be found in sidebar.less -->
            <section class=\"sidebar\">

              <!-- Sidebar user panel (optional) -->
              <div class=\"user-panel\">
                <div class=\"pull-left image\">
                  $currentuser_image
                </div>
                <div class=\"pull-left info\">
                  <p><a href=\"index.php?page=user-edit&user=$user->username\" class=\"menuLink\">$currentuser</a></p>
                  <!-- Status -->
                  <a href=\"index.php?page=userlist\"><i class=\"fa fa-circle text-success\"></i> Online</a>
                </div>
              </div>

              <!-- search form (Optional) -->
              <form action=\"index.php?page=search\" method=\"post\" class=\"sidebar-form\">
                <div class=\"input-group\">
                  <input type=\"text\" name=\"searchString\" class=\"form-control\" placeholder=\"$lang[SEARCH_DOTDOTDOT]\">
                  <input type=\"hidden\" name=\"all\" value=\"true\">
                  <span class=\"input-group-btn\">
                    <button type=\"submit\" name=\"search\" id=\"search-btn\" class=\"btn btn-flat\"><i class=\"fa fa-search\"></i></button>
                  </span>
                </div>
              </form>
              <!-- /.search form -->

              <!-- Sidebar Menu -->
              <ul class=\"sidebar-menu\" data-widget=\"tree\">
                <li class=\"header\">$lang[MAIN_NAVIGATION]</li>
                <!-- Optionally, you can add icons to the links -->
                <li ";echo (!isset($_GET['page'])) && (!isset($_GET['plugin'])) ? "class='active'" : ""; echo">
                    <a href=\"index.php\"><i class=\"fa fa-dashboard\"></i> <span>$lang[DASHBOARD]</span></a>
                </li>";

            // PAGES TREEVIEW MENU
            if (isset($_GET['page']) && (strpos($_GET['page'], 'page') !== false))
            { $activeClass = " class=\"active\""; }
            else { $activeClass = ''; }
            echo "<li$activeClass>
                  <a href=\"#\">
                    <i class=\"fa fa-file-word-o\"></i>
                    <span>$lang[PAGES]</span>
                    <span class=\"pull-right-container\">
                      <i class=\"fa fa-angle-left pull-right\"></i>
                    </span>
                  </a>
                <ul class=\"treeview-menu\">
                    <li ";echo (isset($_GET['page']) && $_GET['page'] == 'pages') ? "class=\"active\"" : ""; echo">
                        <a href=\"index.php?page=pages\" title=\"add or edit a static .html page\"><i class=\"fa fa-file-word-o\"></i> <span>$lang[OVERVIEW]</span></a>
                    </li>
                    <li ";echo (isset($_GET['page']) && $_GET['page'] == 'page-new') ? "class='active'" : ""; echo">
                        <a href=\"index.php?page=page-new\" title=\"add or edit a static .html page\"><i class=\"fa fa-plus\"></i> <span>$lang[PAGE_ADD]</span></a>
                    </li>
                </ul>";

            // MENU TREEVIEW MENU
            if (isset($_GET['page']) && (strpos($_GET['page'], 'menu') !== false))
            { $activeClass = " class=\"active\""; }
            else { $activeClass = ''; }
            echo "<li$activeClass>
                      <a href=\"#\">
                        <i class=\"fa fa-bars\"></i>
                        <span>$lang[MENUS]</span>
                        <span class=\"pull-right-container\">
                          <i class=\"fa fa-angle-left pull-right\"></i>
                        </span>
                      </a>
                    <ul class=\"treeview-menu\">
                        <li ";echo (isset($_GET['page']) && $_GET['page'] == 'menus') ? "class=\"active\"" : ""; echo">
                            <a href=\"index.php?page=menus\" title=\"view menus and entries\"><i class=\"fa fa-bars\"></i> <span>$lang[OVERVIEW]</span></a>
                        </li>
                        <li ";echo (isset($_GET['page']) && $_GET['page'] == 'menu-new') ? "class='active'" : ""; echo">
                            <a href=\"index.php?page=menu-new\" title=\"add or edit menu entries\"><i class=\"fa fa-plus\"></i> <span>$lang[MENU_ADD]</span></a>
                        </li>
                    </ul>";

            // USER TREEVIEW MENU
            if (isset($_GET['page']) && (strpos($_GET['page'], 'user') !== false))
            { $activeClass = " class=\"active\""; }
            else { $activeClass = ''; }
            echo "<li$activeClass>
                      <a href=\"#\">
                      <i class=\"fa fa-user\"></i>
                        <span>$lang[USERS]</span>
                        <span class=\"pull-right-container\">
                        <i class=\"fa fa-angle-left pull-right\"></i></span>
                      </a>
                      <ul class=\"treeview-menu\">
                        <li ";echo (isset($_GET['page']) && $_GET['page'] == 'users') ? "class=\"active\"" : ""; echo">
                            <a href=\"index.php?page=users\" title=\"show all users\"><i class=\"fa fa-user\"></i> <span>$lang[USERS]</span></a>
                        </li>
                        <li ";echo (isset($_GET['page']) && $_GET['page'] == 'user-new') ? "class='active'" : ""; echo">
                            <a href=\"index.php?page=user-new\" title=\"add a new user\"><i class=\"fa fa-plus\"></i> <span>$lang[USER_ADD]</span></a>
                        </li>
                      </ul>";

            // PLUGINS TREEVIEW MENU
            if (isset($_GET['page']) && (strpos($_GET['page'], 'plugin') !== false))
            { $activeClass = " class=\"active\""; }
            else { $activeClass = ''; }
            echo "<li$activeClass>
                      <a href=\"#\">
                        <i class=\"fa fa-plug\"></i>
                        <span>$lang[PLUGINS]</span>
                        <span class=\"pull-right-container\">
                        <i class=\"fa fa-angle-left pull-right\"></i>
                        </span>
                      </a>
                      <ul class=\"treeview-menu\">
                        <li ";echo (isset($_GET['page']) && $_GET['page'] == 'plugins') ? "class=\"active\"" : ""; echo">
                            <a href=\"index.php?page=plugins\" title=\"show plugins\"><i class=\"fa fa-plug\"></i> <span>$lang[PLUGINS]</span></a>
                        </li>
                        <li ";echo (isset($_GET['page']) && $_GET['page'] == 'plugins-manage') ? "class='active'" : ""; echo">
                            <a href=\"index.php?page=plugins-manage\" title=\"manage plugins\"><i class=\"fa fa-wrench\"></i> <span>$lang[PLUGINS_MANAGE]</span></a>
                        </li>
                      </ul>";

            // WIDGETS TREEVIEW MENU
            if (isset($_GET['page']) && (strpos($_GET['page'], 'widget') !== false))
            { $activeClass = " class=\"active\""; }
            else { $activeClass = ''; }
            echo "<li$activeClass>
                      <a href=\"#\">
                        <i class=\"fa fa-tags\"></i>
                        <span>$lang[WIDGETS]</span>
                        <span class=\"pull-right-container\">
                        <i class=\"fa fa-angle-left pull-right\"></i>
                        </span>
                      </a>
                      <ul class=\"treeview-menu\">
                        <li ";echo (isset($_GET['page']) && $_GET['page'] == 'widgets') ? "class=\"active\"" : ""; echo">
                            <a href=\"index.php?page=widgets\" title=\"show widgets\"><i class=\"fa fa-tags\"></i> <span>$lang[WIDGETS]</span></a>
                        </li>
                        <li ";echo (isset($_GET['page']) && $_GET['page'] == 'widget-new') ? "class='active'" : ""; echo">
                            <a href=\"index.php?page=widget-new\" title=\"add widget\"><i class=\"fa fa-plus\"></i> <span>$lang[WIDGET_ADD]</span></a>
                        </li>
                      </ul>";

            // FILEMANAGER TREEVIEW MENU
            if (isset($_GET['page']) && (strpos($_GET['page'], 'filemanager') !== false))
            { $activeClass = " class=\"active\""; }
            else { $activeClass = ''; }
            echo "<li$activeClass>
                        <a href=\"#\">
                        <i class=\"fa fa-folder-open\"></i>
                        <span>$lang[FILEMANAGER]</span>
                        <span class=\"pull-right-container\">
                        <i class=\"fa fa-angle-left pull-right\"></i>
                        </span>
                        </a>
                      <ul class=\"treeview-menu\">
                        <li ";echo (isset($_GET['page']) && $_GET['page'] == 'filemanager') ? "class=\"active\"" : ""; echo">
                            <a href=\"index.php?page=filemanager\" title=\"show files\"><i class=\"fa fa-folder-open-o\"></i> <span>$lang[FILEMANAGER]</span></a>
                        </li>
                        <li ";echo (isset($_GET['page']) && $_GET['page'] == 'filemanager-upload') ? "class='active'" : ""; echo">
                            <a href=\"index.php?page=filemanager-upload\" title=\"upload files\"><i class=\"fa fa-plus\"></i> <span>$lang[UPLOAD]</span></a>
                        </li>
                      </ul>";

            // TEMPLATE TREEVIEW MENU
            if (isset($_GET['page']) && (strpos($_GET['page'], 'template') !== false))
            {   $activeClass = " class=\"active\""; }
            else { $activeClass = ''; }

            echo "<li$activeClass>
                  <a href=\"#\">
                    <i class=\"fa fa-paint-brush\"></i>
                    <span>$lang[DESIGN]</span>
                    <span class=\"pull-right-container\">
                      <i class=\"fa fa-angle-left pull-right\"></i>
                    </span>
                  </a>
                    <ul class=\"treeview-menu\">
                        <li ";echo (isset($_GET['page']) && $_GET['page'] == 'template-overview') ? "class=\"active\"" : ""; echo">
                            <a href=\"index.php?page=template-overview\"><i class=\"fa fa-cube\"></i> $lang[TPL]</a>
                        </li>
                        <li ";echo (isset($_GET['page']) && $_GET['page'] == 'template-positions') ? "class=\"active\"" : ""; echo">
                            <a href=\"index.php?page=template-positions\"><i class=\"fa fa-sitemap\"></i> $lang[POSITIONS]</a>
                        </li>
                        <li ";echo (isset($_GET['page']) && $_GET['page'] == 'template-redesign') ? "class=\"active\"" : ""; echo">
                            <a href=\"index.php?page=template-redesign\"><i class=\"fa fa-paint-brush\"></i>$lang[DESIGN]</a>
                        </li>
                        <li ";echo (isset($_GET['page']) && $_GET['page'] == 'template-typography') ? "class=\"active\"" : ""; echo">
                            <a href=\"index.php?page=template-typography\"><i class=\"fa fa-text-height\"></i> $lang[TYPOGRAPHY]</a>
                        </li>
                        <li ";echo (isset($_GET['page']) && $_GET['page'] == 'template-customcss') ? "class=\"active\"" : ""; echo">
                            <a href=\"index.php?page=template-customcss\"><i class=\"fa fa-css3\"></i> $lang[CUSTOM_CSS]</a>
                        </li>
                        <li ";echo (isset($_GET['page']) && $_GET['page'] == 'template-customjs') ? "class=\"active\"" : ""; echo">
                            <a href=\"index.php?page=template-customjs\"><i class=\"fa fa-code\"></i> $lang[CUSTOM_JS]</a>
                        </li>
                        <li ";echo (isset($_GET['page']) && $_GET['page'] == 'template-preview') ? "class=\"active\"" : ""; echo">
                            <a href=\"index.php?page=template-preview\"><i class=\"fa fa-eye\"></i> $lang[PREVIEW]</a>
                        </li>
                        <li ";echo (isset($_GET['page']) && $_GET['page'] == 'template-assets') ? "class=\"active\"" : ""; echo">
                            <a href=\"index.php?page=template-assets\"><i class=\"fa fa-puzzle-piece\"></i> $lang[ASSETS]</a>
                        </li>
                    </ul>
                   </li>";

            // STATS TREEVIEW MENU
            if (isset($_GET['page']) && (strpos($_GET['page'], 'stats') !== false))
            { $activeClass = " class=\"active\""; }
            else { $activeClass = ''; }
            echo "<li$activeClass>
                        <a href=\"#\">
                        <i class=\"fa fa-line-chart\"></i>
                        <span>$lang[STATS]</span>
                        <span class=\"pull-right-container\">
                        <i class=\"fa fa-angle-left pull-right\"></i>
                        </span>
                        </a>
                      <ul class=\"treeview-menu\">
                        <li ";echo (isset($_GET['page']) && $_GET['page'] == 'stats') ? "class=\"active\"" : ""; echo">
                            <a href=\"index.php?page=stats\" title=\"statistics\"><i class=\"fa fa-line-chart\"></i> <span>$lang[STATS]</span></a>
                        </li>
                        <li ";echo (isset($_GET['page']) && $_GET['page'] == 'stats-24h') ? "class='active'" : ""; echo">
                            <a href=\"index.php?page=stats&interval=24&period=HOUR\" title=\"last 24 hours\"><i class=\"fa fa-clock-o\"></i> <span>$lang[LAST24H]</span></a>
                        </li>
                      </ul>";

            // HELP / SUPPORT TREEVIEW MENU
            if (isset($_GET['page']) && (strpos($_GET['page'], 'help') !== false))
            { $activeClass = " class=\"active\""; }
            else { $activeClass = ''; }
            echo "<li$activeClass>
                        <a href=\"#\">
                        <i class=\"fa fa-question-circle\"></i>
                        <span>$lang[HELP]</span>
                        <span class=\"pull-right-container\">
                        <i class=\"fa fa-angle-left pull-right\"></i>
                        </span>
                        </a>
                      <ul class=\"treeview-menu\">
                        <li ";echo (isset($_GET['page']) && $_GET['page'] == 'help') ? "class='active'" : ""; echo">
                            <a href=\"index.php?page=help\" title=\"help\"><i class=\"fa fa-question-circle-o\"></i> <span>$lang[HELP_USER_MANUAL]</span></a>
                        </li>
                        <li ";echo (isset($_GET['page']) && $_GET['page'] == 'help-apigen') ? "class=\"active\"" : ""; echo">
                            <a href=\"index.php?page=help-apigen\" title=\"API Documentation\"><i class=\"fa fa-question-circle-o\"></i> <span>$lang[HELP_APIGEN]</span></a>
                        </li>
                        <li ";echo (isset($_GET['page']) && $_GET['page'] == 'help-support') ? "class=\"active\"" : ""; echo">
                            <a href=\"index.php?page=help-support\" title=\"Support\"><i class=\"fa fa-life-saver\"></i> <span>$lang[HELP_SUPPORT]</span></a>
                        </li>
                      </ul>";

            // SETTINGS TREEVIEW MENU
            if (isset($_GET['page']) && (strpos($_GET['page'], 'settings') !== false))
            { $activeClass = " class=\"active\""; }
            else { $activeClass = ''; }

            echo"
        <li$activeClass>
          <a href=\"#\">
            <i class=\"fa fa-gear\"></i>
            <span>$lang[SETTINGS]</span>
            <span class=\"pull-right-container\">
              <i class=\"fa fa-angle-left pull-right\"></i>
            </span>
          </a>
          <ul class=\"treeview-menu\">
            <li ";echo (isset($_GET['page']) && $_GET['page'] == 'settings-frontend') ? "class=\"active\"" : ""; echo">
                <a href=\"index.php?page=settings-frontend\"><i class=\"fa fa-globe\"></i> $lang[FRONTEND]</a>
            </li>
            <li ";echo (isset($_GET['page']) && $_GET['page'] == 'settings-backend') ? "class=\"active\"" : ""; echo">
                <a href=\"index.php?page=settings-backend\"><i class=\"fa fa-sign-in\"></i> $lang[BACKEND]</a>
            </li>
            <li ";echo (isset($_GET['page']) && $_GET['page'] == 'settings-system') ? "class=\"active\"" : ""; echo">
                <a href=\"index.php?page=settings-system\"><i class=\"fa fa-gears\"></i> $lang[SYSTEM]</a>
            </li>
            <li ";echo (isset($_GET['page']) && $_GET['page'] == 'settings-webmail') ? "class=\"active\"" : ""; echo">
                <a href=\"index.php?page=settings-webmail\"><i class=\"fa fa-envelope-o\"></i> $lang[WEBMAIL]</a>
            </li>
            <li ";echo (isset($_GET['page']) && $_GET['page'] == 'settings-robots') ? "class=\"active\"" : ""; echo">
                <a href=\"index.php?page=settings-robots\"><i class=\"fa fa-android\"></i> $lang[ROBOTS_TXT]</a></li>
                
            <li ";echo (isset($_GET['page']) && $_GET['page'] == 'settings-language') ? "class=\"active\"" : ""; echo">
                <a href=\"index.php?page=settings-language\"><i class=\"fa fa-language\"></i> $lang[LANGUAGES]</a>
            </li>
            <li ";echo (isset($_GET['page']) && $_GET['page'] == 'settings-assets') ? "class=\"active\"" : ""; echo">
                <a href=\"index.php?page=settings-assets\"><i class=\"fa fa-puzzle-piece\"></i> $lang[ASSETS]</a>
            </li>
            <li ";echo (isset($_GET['page']) && $_GET['page'] == 'settings-fonts') ? "class=\"active\"" : ""; echo">
                <a href=\"index.php?page=settings-fonts\"><i class=\"fa fa-font\"></i> $lang[FONTS]</a>
            </li>
            <li ";echo (isset($_GET['page']) && $_GET['page'] == 'settings-database') ? "class=\"active\"" : ""; echo">
                <a href=\"index.php?page=settings-database\"><i class=\"fa fa-database\"></i> $lang[DATABASE]</a>
            </li>
            <li ";echo (isset($_GET['page']) && $_GET['page'] == 'settings-backup') ? "class=\"active\"" : ""; echo">
                <a href=\"index.php?page=settings-backup\"><i class=\"fa fa-hdd-o\"></i> $lang[BACKUP]</a>
            </li>
            <li ";echo (isset($_GET['page']) && $_GET['page'] == 'settings-systeminfo') ? "class=\"active\"" : ""; echo">
            <a href=\"index.php?page=settings-systeminfo\"><i class=\"fa fa-info-circle\"></i> $lang[SYSTEM]&nbsp;$lang[INFO]</a></li>
          </ul>
        </li>
        <br><br><br><br>
              </ul><!-- /.sidebar-menu -->
            </section>
            <!-- /.sidebar -->
          </aside>";
            return null;
        }

        /**
         * @brief HTML Content Header (manually written in \includes)
         * @param object $lang Language object
         * @return null
         */
        function drawHtmlContentHeader($lang){
            echo "";
            return null;
        }

        /**
         * @brief HTML Content Header Breadcrumbs (manually written in \includes)
         * @return null
         */
        function drawHtmlContentBreadcrumbs(){
            echo "";
            return null;
        }

        /**
         * @brief output the html content - depending on whether it's a plugin or a static admin page
         * @param object $db Database object
         * @param object $lang Language object
         * @param object $user User object - not in use atm, check this!
         * @return null
         */
        function drawHtmlContent($db, $lang, $user)
        {
            /* check if a search q is set */
            if (isset($_GET['q']) && (!empty($_GET['q'])))
            {
                alert::draw("success", "Suchfeld", "Begriff: $_GET[q]", "", 2000);
            }

            if(isset($_GET['page']))
            {   // load given page
                $node = "includes/".$_GET['page']."";
                $filename = "includes/".$_GET['page'].".php";

                if (is_file($filename))
                {   // ok, include this backend filge
                    include(controller::filterfilename($db, $lang, $node));
                    self::drawHtmlContentClose();
                }
                else
                {   // backend page not found, throw error msg
                    \YAWK\alert::draw("danger", $lang['ERROR'], $lang['FILE_NOT_FOUND'].": <b>".$filename."</b> <br><i>".$lang['REDIRECT_INFO']." ".$lang['TO'].": ".$lang['BACKEND']." ".$lang['HOME_PAGE']."</i>", "index.php?page=dashboard", "8400");
                }
            }

            else if(isset($_GET['plugin']) && (!isset($_GET['pluginpage'])))
            {   // load given plugin
                $plugin = $_GET['plugin'];
                $plugin_name = "../system/plugins/$plugin/admin/$plugin";
                include(controller::filterfilename($db, $lang, $plugin_name));
                self::drawHtmlContentClose();
            }
            else if (isset($_GET['plugin']) && (isset($_GET['pluginpage'])))
            {   // load given pluginpage
                $plugin = $_GET['plugin'];
                $pluginPage = $_GET['pluginpage'];
                $plugin_name = "../system/plugins/$plugin/admin/$pluginPage";
                include(controller::filterfilename($db, $lang, $plugin_name));
                self::drawHtmlContentClose();
            }
            else if (isset($_GET['pluginid']))
            {   // get plugin name for given id from db
                $plugin = \YAWK\plugin::getNameById($db, $_GET['pluginid']);
                $plugin_name = "../system/plugins/$plugin/admin/$plugin";
                include(controller::filterfilename($db, $lang, $plugin_name));
                self::drawHtmlContentClose();
            }
            else if (!isset($_GET['page']))
            {   // no page is given, load default: dashboard
                echo "
                <!-- Content Wrapper. Contains page content -->
                <div class=\"content-wrapper\" id=\"content-FX\">
                <!-- Content Header (Page header) -->
                <section class=\"content-header\">";
                /* Title on top */
                $dashboard_subtext = $lang['DASHBOARD_SUBTEXT']."&nbsp;".\YAWK\user::getCurrentUserName($lang)."!";
                echo \YAWK\backend::getTitle($lang['DASHBOARD'], $dashboard_subtext);
                /* breadcrumbs */
                echo"<ol class=\"breadcrumb\">
                <li><a href=\"index.php\" title=\"$lang[DASHBOARD]\"><i class=\"fa fa-dashboard\"></i> $lang[DASHBOARD]</a></li>
                <li class=\"active\"><a href=\"index.php\"> $lang[OVERVIEW]</a></li>
              </ol>
            </section>";
                echo"
            <!-- Main content -->
              <section class=\"content\">";
                include(controller::filterfilename($db, $lang, "includes/dashboard"));
                self::drawHtmlContentClose();
                \YAWK\BACKEND\AdminLTE::drawHtmlFooter($db);
            }
            return null;
        }

        /**
         * @brief End Content
         * @return null
         */
        function drawHtmlContentClose()
        {
            echo "</div>";
            echo "</section><!-- /.content -->";
            return null;
        }

        /**
         * @brief Draw a Footer on every backend page.
         * @return null
         */
        function drawHtmlFooter($db)
        {   /* @param $db \YAWK\db */
            $copyright = settings::getSetting($db, "backendFooterCopyright");
            $valueLeft = settings::getSetting($db, "backendFooterValueLeft");
            $valueRight = settings::getSetting($db, "backendFooterValueRight");

            if (isset($valueLeft) && (!empty($valueLeft)))
            {   // left value
                $leftValue = $valueLeft;
            }
            else { $leftValue = ''; }

            if (isset($valueRight) && (!empty($valueRight)))
            {   // right value
                $rightValue = $valueRight;
            }
            else { $rightValue = ''; }

            // check if copyright is enabled
            if ($copyright === "1")
            {   // get host and display copyright information
                $host = settings::getSetting($db, "host");
                $leftValue = "<strong>Copyright &copy; ".date("Y")." <a href=\"https://github.com/YaWK/yawk-cms\" target=\"_blank\">YaWK CMS</a> </strong><small> All rights reserved. </small>";
                $rightValue = "Yet another Web Kit v". settings::getSetting($db, "yawkversion")."";
            }

            // output footer data
            echo "
            <!-- Main Footer -->
            <footer class=\"main-footer\">
              <!-- To the right -->
                <div class=\"pull-right hidden-xs\">
                  <small>$rightValue</small>
                </div>
                <!-- Default to the left -->
                $leftValue
            </footer>";
            return null;
        }


        /**
         * @brief Draw right, collapsable sidebar
         * @return null
         */
        function drawHtmlRightSidebar($lang){
            echo "
          <!-- Control Sidebar -->
          <aside class=\"control-sidebar control-sidebar-dark\">
            <!-- Create the tabs -->
            <ul class=\"nav nav-tabs nav-justified control-sidebar-tabs\">
              <li class=\"active\"><a href=\"#control-sidebar-home-tab\" data-toggle=\"tab\"><i class=\"fa fa-hdd-o\"></i></a></li>
              <li><a href=\"#control-sidebar-settings-tab\" data-toggle=\"tab\"><i class=\"fa fa-gears\"></i></a></li>
            </ul>
            <!-- Tab panes -->
            <div class=\"tab-content\">
              <!-- Home tab content -->
              <div class=\"tab-pane active\" id=\"control-sidebar-home-tab\">
              <!--
                <h3 class=\"control-sidebar-heading\">$ lang[BACKUP]</h3>
                <ul class=\"control-sidebar-menu\">
                  <li>
                    <a href=\"#\">
                      <i class=\"menu-icon fa fa-hdd-o\"></i>
                      <div class=\"menu-info\">
                        <h4 class=\"control-sidebar-subheading\">Quick Backup</h4>
                        <p>&nbsp;Refresh database backup</p>
                      </div>
                    </a>
                  </li>
                  <li>
                    <a href=\"#\">
                      <i class=\"menu-icon fa fa-hdd-o\"></i>
                      <div class=\"menu-info\">
                        <h4 class=\"control-sidebar-subheading\">Complete Backup</h4>
                        <p>&nbsp;Including media folder</p>
                      </div>
                    </a>
                  </li>
                </ul><!-- /.control-sidebar-menu -->
               <!-- 
                <h3 class=\"control-sidebar-heading\">Zeiterfassung</h3>
                <ul class=\"control-sidebar-menu\">
                  <li>
                    <a href=\"javascript::;\">
                      <h4 class=\"control-sidebar-subheading\">
                        Custom Template Design
                        <span class=\"label label-danger pull-right\">70%</span>
                      </h4>
                      <div class=\"progress progress-xxs\">
                        <div class=\"progress-bar progress-bar-danger\" style=\"width: 20%\"></div>
                      </div>
                    </a>
                  </li>
                </ul><!-- /.control-sidebar-menu -->

              </div><!-- /.tab-pane -->
              <!-- Stats tab content -->
              <div class=\"tab-pane\" id=\"control-sidebar-stats-tab\">Stats Tab Content</div><!-- /.tab-pane -->
              <!-- Settings tab content -->
              <div class=\"tab-pane\" id=\"control-sidebar-settings-tab\">
              <!--
                <form method=\"post\">
                  <h3 class=\"control-sidebar-heading\">General Settings</h3>
                  <div class=\"form-group\">
                    <label class=\"control-sidebar-subheading\">
                      Report panel usage
                      <input type=\"checkbox\" class=\"pull-right\" checked>
                    </label>
                    <p>
                      Some information about this general settings option
                    </p>
                  </div><!-- /.form-group -- >
                </form>
              </div><!-- /.tab-pane -->
            </div>
          </aside><!-- /.control-sidebar -->
          <!-- Add the sidebar's background. This div must be placed
               immediately after the control sidebar -->
          <div class=\"control-sidebar-bg\"></div>
        </div><!-- ./wrapper -->";
            return null;
        }

        /**
         * @brief Include needed JS files
         * @return null
         */
        function drawHtmlJSIncludes(){
            echo "
        <!-- REQUIRED JS SCRIPTS -->
        <!-- color picker -->
	    <script type=\"text/javascript\" src=\"../system/engines/jquery/jscolor/jscolor.js\"></script>
        <!-- jQuery 1.11.3
        <script type=\"text/javascript\" src=\"../system/engines/jquery/jquery-1.11.3.min.js\"></script> -->
        <!-- Bootstrap 3.3.5 -->
        <script type=\"text/javascript\" src=\"../system/engines/bootstrap3/dist/js/bootstrap.min.js\"></script>
        <!-- data table -->
        <script type=\"text/javascript\" src=\"../system/engines/jquery/jquery.dataTables.min.js\"></script>
        <!-- AdminLTE App -->
        <script type=\"text/javascript\" src=\"../system/engines/AdminLTE/js/app.min.js\"></script>";
            return null;
        }

        /**
         * @brief SetUp Backend FX and end html body
         * @param object $db Database
         * @return null
         */
        function drawHtmlEnd($db){
            global $loadingTime;
            /* SetUp backend effects */
            if(settings::getSetting($db, "backendFX") >= 1) { /* set time & type */
                \YAWK\backend::getFX($db, settings::getSetting($db, "backendFXtime"), settings::getSetting($db, "backendFXtype"));
            }
            /* display script running time */
            if (settings::getSetting($db, "loadingTime") === '1') {
                echo \YAWK\sys::getLoadingTime($loadingTime);
            }

            echo "
            </body>
            </html>";
            return null;
        }

        /**
         * @brief draw a simple collapse box
         * @param string $header
         * @param string $content
         */
        static function drawCollapsableBox($header, $content)
        {
            return "
          <div class=\"box box-default\">
            <div class=\"box-header with-border\">
              <h3 class=\"box-title\">$header</h3>

              <div class=\"box-tools pull-right\">
                <button type=\"button\" class=\"btn btn-box-tool\" data-widget=\"collapse\"><i class=\"fa fa-minus\"></i>
                </button>
              </div>
              <!-- /.box-tools -->
            </div>
            <!-- /.box-header -->
            <div class=\"box-body\" style=\"display: block;\">
              $content
            </div>
            <!-- /.box-body -->
          </div>";
        }

    } // ./ class backend
} // ./ namespace