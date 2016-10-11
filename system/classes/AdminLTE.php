<?php
namespace YAWK {
    /**
     * <b>Admin LTE Template Class</b>
     *
     * This class serves a few methods that build the Admin LTE view in the backend.<br>
     *
     * <p><i>Class covers backend template functionality.
     * See Methods Summary for Details!</i></p>
     *
     * @category   CMS
     * @package    System
     * @author     Daniel Retzl <danielretzl@gmail.com>
     * @copyright  2009-2016 Daniel Retzl http://yawk.website
     * @license    http://www.gnu.org/licenses/gpl-2.0  GNU/GPL 2.0
     * @version    1.0.0
     * @link       http://yawk.website/
     * @since      File available since Release 1.0.0
     * @annotation Backend class serves a few useful functions for the admin backend.
     */
    class AdminLTE
    {
        /**
         * @var string
         */
        public $backendSkin;
        public $backendLayout;

        /**
         * AdminLTE constructor.
         * @param object $db Database object
         */
        public function __construct($db){
            // get skin setting
            $this->backendSkin = \YAWK\settings::getSetting($db, "backendSkin");
            if (empty($this->backendSkin)){
                $this->backendSkin = "skin-blue"; // default
            }
            // get layout setting
            $this->backendLayout = \YAWK\settings::getSetting($db, "backendLayout");
            if (empty($this->backendLayout)){
                $this->backendSkin = "sidebar-mini"; // default
            }
        }

        /**
         * Draw the HTML Header. Loads all .css and .js files
         * @return null
         */
        function drawHtmlHead(){
            echo "<!DOCTYPE html>
<html>
  <head>
    <meta charset=\"utf-8\">
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
    <!-- Bootstrap 3.3.5 -->
    <link rel=\"stylesheet\" href=\"../system/engines/bootstrap/dist/css/bootstrap.min.css\">
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
    <!-- <link rel=\"stylesheet\" href=\"../system/engines/AdminLTE/css/skins/____this->backendSkin.min.css\"> -->
    <link rel=\"stylesheet\" href=\"../system/engines/AdminLTE/css/skins/$this->backendSkin.css\">

    <!-- include custom css -->
    <link rel=\"stylesheet\" href=\"../system/engines/AdminLTE/css/skins/custom.css\">

    <!-- jQuery 2.1.4 -->
    <script type=\"text/javascript\" src=\"../system/engines/jquery/jquery-2.2.3.min.js\"></script>

    <!-- jQuery 3.0.0 -->
    <!-- <script type=\"text/javascript\" src=\"../system/engines/jquery/jquery-3.0.0.min.js\"></script> -->

    <!-- Notify JS -->
    <script src=\"../system/engines/jquery/notify/bootstrap-notify.min.js\"></script>

    <!-- YaWK Backend JS Functions -->
    <script type=\"text/javascript\" src=\"js/yawk-backend.js\"></script>

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
         * Draw body and header Tag
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
         * Draw logo in the top left corner
         * @param object $db Database object
         * @return null
         */
        function drawHtmlLogo($db)
        {   // check, if URL or personal text should be displayed...
            if ($this->backendLayout === "layout-top-nav"){
                return null;
            }
            if (\YAWK\settings::getSetting($db, "backendLogoUrl") === "1")
            {   // URL is requested, -> get hostname (project URL)
                $host = \YAWK\settings::getSetting($db, "host");
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
                {   // personal text requestet, -> get logo text + subtext
                    $logoText = "<b>".\YAWK\settings::getSetting($db, "backendLogoText")."</b>&nbsp;";
                    $logoText .= \YAWK\settings::getSetting($db, "backendLogoSubText");
                }
            echo "<!-- Logo -->
            <a href=\"../index.html\" class=\"logo\" target=\"_blank\">
              <!-- mini logo for sidebar mini 50x50 pixels -->
              <span class=\"logo-mini\"><b class=\"fa fa-globe\"></b></span>
              <!-- logo for regular state and mobile devices -->
              <span class=\"logo-lg\">$logoText</span>
            </a>";
            return null;
        }

        /**
         * Draw the navbar (top)
         * @return null
         */
        function drawHtmlNavbar(){
            if ($this->backendLayout === "layout-top-nav"){
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
              <a href=\"#\" class=\"sidebar-toggle\" data-toggle=\"offcanvas\" role=\"button\">
                <span class=\"sr-only\">Toggle navigation</span>
              </a>";

            }
            return null;
        }

        /**
         * Draw right navbar
         * @return null
         */
        function drawHtmlNavbarRightMenu(){
            echo "<!-- Navbar Right Menu -->
              <div class=\"navbar-custom-menu\">
                <ul class=\"nav navbar-nav\">";
            return null;
        }

        /**
         * Messages Menu: the small icon in the right corner of top navigation
         * This is a facebook-ike messaging preview.
         * @param object $db Database object
         * @return null
         */
        function drawHtmlNavbarMessagesMenu($db){
            // count + return unread messages
            $i = \YAWK\user::countNewMessages($db, $_SESSION['uid']);
            if ($i === 1)
            {   // set singular
                $msg = "message";
                $label = "<span id=\"envelope-label\" class=\"label label-success animated swing\">$i</span>";
                $animated = "animated tada";
            }
            else
            {   // set plural correctly
                $msg = "messages";
                $label = "<span id=\"envelope-label\" class=\"label label-success animated swing\">$i</span>";
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
                  <i class=\"fa fa-envelope-o $animated\"></i>
                  $label
                </a>
                <ul class=\"dropdown-menu\">
                  <li class=\"header\">You have $i unread $msg</li>
                  <li>
                    <!-- inner menu: contains the messages -->
                    <ul class=\"menu\">";
                    // loop new messages data
                    foreach ($newMessages as $message)
                    {   // get sender username from ID

                        $from = \YAWK\user::getUserNameFromID($db, $message['fromUID']);
                        $picture = \YAWK\user::getUserImage("backend", $from, "img-circle", 20,20);
                        $timeago = \YAWK\sys::time_ago($message['msg_date']);
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
         * Draw navbar notification. This tells you whats going on in your project.
         * @param object $db Database object
         * @param $user
         * @return null
         */
        function drawHtmlNavbarNotificationsMenu($db, $user)
        {

            echo "<script type='text/javascript'>
            function dismissNotifications(uid) {
                // alert(uid);
                $.ajax({    // do ajax request
                url:'js/dismiss-notification.php',
                type:'post',
                data:'uid='+uid,
                success:function(data){
                    if(! data ){
                        alert('Something went wrong!');
                        return false;
                    }
                    else {
                        $(data).hide().prependTo('#notificationDropdown');
                        $('#notification-header').html('You have 0 notifications');
                        $('#notification-menu').fadeOut();
                    }
                }
            });
            }
            </script>";

            $i_syslog = \YAWK\user::countNotifications($db);
            $i_notifications = \YAWK\user::countMyNotifications($db, $_SESSION['uid']);
            $i_total = $i_syslog + $i_notifications;
            $notifications = \YAWK\user::getAllNotifications($db);
            $my_notifications = \YAWK\user::getMyNotifications($db, $_SESSION['uid']);
            if ($i_total !== 0)
            {   // if notification available, ring bell and show label...
                $bell = "swing";
                $label = "<span id=\"bell-label\" class=\"label label-warning animated tada\">$i_total</span>";
                $notification = "notifications";    // set plural
            }
            else
            {   // no notification available
                $bell = '';
                $label = '';
                $notification = 'notifications';
            }
            if ($i_total === '1')
            {   // set singular correctly
                $notification = "notification";
            }
            echo "
              <!-- Notifications Menu -->
              <li id=\"notification-dropdown\" class=\"dropdown notifications-menu\">
                <!-- Menu toggle button -->
                <a href=\"#\" class=\"dropdown-toggle\" data-toggle=\"dropdown\">
                  <i class=\"fa fa-bell-o animated $bell\"></i>
                  $label
                  </a>
                <ul id=\"notification-dropdownlink\" class=\"dropdown-menu\">
                  <li id=\"notification-header\" class=\"header\">You have $i_total $notification <small><small>(<a href=\"#\" id=\"dismiss\" onclick=\"dismissNotifications($_SESSION[uid]);\" title=\"dismiss all\">mark as read</a>)</small></small></li>
                  <li>
                    <!-- Inner Menu: contains the notifications -->
                    <ul id=\"notification-menu\" class=\"menu\">";
                    if (isset($my_notifications) && is_array($my_notifications))
                    {   // if personal notifications are available
                        foreach ($my_notifications as $my_note)
                        {
                            $getUsername = 0;
                            $UID = 0;

                            // calculate datetime pretty
                            $timeAgo = \YAWK\sys::time_ago($my_note['log_date']);

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

                            echo "<li><!-- start notification -->
                            <a href=\"index.php?page=friendslist\" id=\"labelNotification\" title=\"\">
                              <div class=\"pull-left\">
                                <i id=\"labelNotification1\" class=\"$my_note[icon] $my_note[type]\"></i>&nbsp; <small><i>$my_msg</i><br>
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
                            $timeAgo = \YAWK\sys::time_ago($note['log_date']);

                            echo "<li><a href=\"#\" title=\"\">
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
                  <li class=\"footer\"><a href=\"index.php?page=syslog\">View all</a></li>
                </ul>
              </li>";
            return null;
        }

        /**
         * Show your user account details. Counts your friends and connections, let you log out.
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
                      <b><a href=\"index.php?page=user-edit&user=$user->username\" style=\"color:#fff;\">$currentuser</a></b>
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
                      <a href=\"index.php?page=user-edit&user=$user->username\" class=\"btn btn-default btn-flat\" title=\"edit $user->username profile\">Profile</a>
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
         * End Navbar
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
         * Left sidebar navigation
         * @param object $db Database object
         * @param object $user User object
         * @param array $lang Language array
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
                  <p><a href=\"index.php?page=user-edit&user=$user->username\" style=\"color: #fff;\">$currentuser</a></p>
                  <!-- Status -->
                  <a href=\"index.php?page=userlist\"><i class=\"fa fa-circle text-success\"></i> Online</a>
                </div>
              </div>

              <!-- search form (Optional) -->
              <form action=\"#\" method=\"get\" class=\"sidebar-form\">
                <div class=\"input-group\">
                  <input type=\"text\" name=\"q\" class=\"form-control\" placeholder=\"Search...\">
                  <span class=\"input-group-btn\">
                    <button type=\"submit\" name=\"search\" id=\"search-btn\" class=\"btn btn-flat\"><i class=\"fa fa-search\"></i></button>
                  </span>
                </div>
              </form>
              <!-- /.search form -->

              <!-- Sidebar Menu -->
              <ul class=\"sidebar-menu\">
                <li class=\"header\">MAIN NAVIGATION</li>
                <!-- Optionally, you can add icons to the links -->
                <li ";echo (!isset($_GET['page'])) && (!isset($_GET['plugin'])) ? "class='active'" : ""; echo">
                    <a href=\"index.php\"><i class=\"fa fa-dashboard\"></i> <span>Dashboard</span></a>
                </li>
                <li ";echo (isset($_GET['page']) && $_GET['page'] == 'pages') || (isset($_GET['page']) && ($_GET['page'] == 'page-edit')) ? "class='active'" : ""; echo">
                    <a href=\"index.php?page=pages\" title=\"add or edit a static .html page\"><i class=\"fa fa-file-word-o\"></i> <span>$lang[PAGES]</span></a>
                </li>
                <li ";echo (isset($_GET['page']) && $_GET['page'] == 'menus') || (isset($_GET['page']) && ($_GET['page'] == 'menu-edit')) ? "class='active'" : ""; echo">
                    <a href=\"index.php?page=menus\" title=\"add or edit menu entries\"><i class=\"fa fa-bars\"></i> <span>$lang[MENUS]</span></a>
                </li>
                <li ";echo (isset($_GET['page']) && $_GET['page'] == 'users') || (isset($_GET['page']) && ($_GET['page'] == 'user-edit')) ? "class='active'" : ""; echo">
                    <a href=\"index.php?page=users\" title=\"add or modify users\"><i class=\"fa fa-user\"></i> <span>$lang[USERS]</span></a>
                </li>
                <!-- plugins -->
                <li ";echo (isset($_GET['page']) && $_GET['page'] == 'plugins') || (isset($_GET['plugin'])) || (isset($_GET['page']) && ($_GET['page'] == 'plugins-manage')) ? "class='active'" : ""; echo">
                    <a href=\"index.php?page=plugins\" title=\"Plugins\"><i class=\"fa fa-plug\"></i> <span>$lang[PLUGINS]</span> </a>
                </li>
                <!-- widgets -->
                <li ";echo (isset($_GET['page']) && $_GET['page'] == 'widgets') || (isset($_GET['page']) && ($_GET['page'] == 'widget-edit')) ? "class='active'" : ""; echo">
                    <a href=\"index.php?page=widgets\"><i class=\"fa fa-tags\"></i> <span>$lang[WIDGETS]</span> </a>
                </li>
                <!-- files -->
                <li ";echo (isset($_GET['page']) && $_GET['page'] == 'filemanager') ? "class='active'" : ""; echo">
                    <a href=\"index.php?page=filemanager\" title=\"Filemanager\"><i class=\"fa fa-folder\"></i> <span>$lang[FILEMANAGER]</span></a>
                </li>
                <!-- design -->
                <li ";echo (isset($_GET['page']) && $_GET['page'] == 'template-edit') ? "class='active'" : ""; echo">
                    <a href=\"index.php?page=template-edit&id=";echo \YAWK\settings::getSetting($db, "selectedTemplate"); echo"\"><i class=\"fa fa-paint-brush\"></i> <span>$lang[REDESIGN]</span></a>
                </li>
                <!-- themes -->
                <li ";echo (isset($_GET['page']) && $_GET['page'] == 'template-manage') ? "class='active'" : ""; echo">
                    <a href=\"index.php?page=template-manage\"><i class=\"fa fa-photo\"></i> <span>$lang[THEMES]</span></a>
                </li>
                <!-- seo -->
                <li ";echo (isset($_GET['page']) && $_GET['page'] == 'yawk-stats') ? "class='active'" : ""; echo">
                    <a href=\"index.php?page=yawk-stats\"><i class=\"fa fa-line-chart\"></i> <span>$lang[STATS]</span></a>
                </li>
                <!-- system -->
                <li ";echo (isset($_GET['page']) && $_GET['page'] == 'settings-system') ? "class='active'" : ""; echo">
                    <a href=\"index.php?page=settings-system\"> <i class=\"fa fa-cog\"></i> <span>$lang[SETTINGS]</span></a>
                </li>
              </ul><!-- /.sidebar-menu -->
            </section>
            <!-- /.sidebar -->
          </aside>";
            return null;
        }

        /**
         * HTML Content Header (manually written in \includes)
         * @param array $lang Language Array
         * @return null
         */
        function drawHtmlContentHeader($lang){
            echo "";
            return null;
        }

        /**
         * HTML Content Header Breadcrumbs (manually written in \includes)
         * @return null
         */
        function drawHtmlContentBreadcrumbs(){
            echo "";
            return null;
        }

        /**
         * @param object $db Database object
         * @param array $lang Language array
         * @param object $user User object - not in use atm, check this!
         * @return null
         */
        function drawHtmlContent($db, $lang, $user){
            if(isset($_GET['page']))
            {   // load given page
                include(\YAWK\controller::filterfilename("includes/".$_GET['page']));
                self::drawHtmlContentClose();
            }
            else if(isset($_GET['plugin']) && (!isset($_GET['pluginpage'])))
            {   // load given plugin
                $plugin = $_GET['plugin'];
                $plugin_name = "../system/plugins/$plugin/admin/$plugin";
                include(\YAWK\controller::filterfilename($plugin_name));
                self::drawHtmlContentClose();
            }
            else if (isset($_GET['plugin']) && (isset($_GET['pluginpage'])))
            {   // load given pluginpage
                $plugin = $_GET['plugin'];
                $pluginPage = $_GET['pluginpage'];
                $plugin_name = "../system/plugins/$plugin/admin/$pluginPage";
                include(\YAWK\controller::filterfilename($plugin_name));
                self::drawHtmlContentClose();
            }
            else if (isset($_GET['pluginid']))
            {   // get plugin name for given id from db
                $plugin = \YAWK\plugin::getNameById($db, $_GET['pluginid']);
                $plugin_name = "../system/plugins/$plugin/admin/$plugin";
                include(\YAWK\controller::filterfilename($plugin_name));
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
                $dashboard_subtext = $lang['DASHBOARD_SUBTEXT']."&nbsp;".\YAWK\user::getCurrentUserName()."!";
                echo \YAWK\backend::getTitle($lang['DASHBOARD'], $dashboard_subtext);
                /* breadcrumbs */
                echo"<ol class=\"breadcrumb\">
                <li><a href=\"index.php?page=dashboard\" title=\"Pages\"><i class=\"fa fa-dashboard\"></i> Dashboard</a></li>
                <li class=\"active\"><a href=\"index.php?page=dashboard\"> Overview</a></li>
              </ol>
            </section>";
                echo"
            <!-- Main content -->
              <section class=\"content\">";
                include(\YAWK\controller::filterfilename("includes/dashboard"));
                self::drawHtmlContentClose();
                \YAWK\backend::drawHtmlFooter();
            }
            return null;
        }

        /**
         * End Content
         * @return null
         */
        function drawHtmlContentClose()
        {
            echo "</div>";
            echo "</section><!-- /.content -->";
            return null;
        }

        /**
         * Draw a Footer on every backend page.
         * @return null
         */
        function drawHtmlFooter($db)
        {   /* @var $db \YAWK\db */
            $copyright = \YAWK\settings::getSetting($db, "backendFooterCopyright");
            $valueLeft = \YAWK\settings::getSetting($db, "backendFooterValueLeft");
            $valueRight = \YAWK\settings::getSetting($db, "backendFooterValueRight");

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
                $host = \YAWK\settings::getSetting($db, "host");
                $leftValue = "<strong>Copyright &copy; ".date("Y")." <a href=\"https://github.com/YaWK/yawk-cms\" target=\"_blank\">YaWK CMS</a> </strong><small> All rights reserved. </small>";
                $rightValue = "Yet another Web Kit v".\YAWK\settings::getSetting($db, "yawkversion")."";
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
         * Draw right, collapsable sidebar
         * @return null
         */
        function drawHtmlRightSidebar(){
            echo "
          <!-- Control Sidebar -->
          <aside class=\"control-sidebar control-sidebar-dark\">
            <!-- Create the tabs -->
            <ul class=\"nav nav-tabs nav-justified control-sidebar-tabs\">
              <li class=\"active\"><a href=\"#control-sidebar-home-tab\" data-toggle=\"tab\"><i class=\"fa fa-home\"></i></a></li>
              <li><a href=\"#control-sidebar-settings-tab\" data-toggle=\"tab\"><i class=\"fa fa-gears\"></i></a></li>
            </ul>
            <!-- Tab panes -->
            <div class=\"tab-content\">
              <!-- Home tab content -->
              <div class=\"tab-pane active\" id=\"control-sidebar-home-tab\">
                <h3 class=\"control-sidebar-heading\">Backend Languages</h3>
                <ul class=\"control-sidebar-menu\">";
                if (!isset($_GET['page']) or (empty($_GET['page'])))
                {
                    $link_de = "index.php?&lang=de-DE";
                    $link_en = "index.php?&lang=en-EN";
                }
                else
                {
                    $link_de = "index.php?page=$_GET[page]&lang=de-DE";
                    $link_en = "index.php?page=$_GET[page]&lang=en-EN";
                }
            echo "<li>
                    <a href=\"$link_en\">
                      <i class=\"menu-icon\"><img class=\"img-circle\" src=\"flags/us.png\"></i>
                      <div class=\"menu-info\">
                        <h4 class=\"control-sidebar-subheading\">&nbsp;English (en-EN)</h4>
                        <p>&nbsp;switch to english</p>
                      </div>
                    </a>
                  </li>
                  <li>
                    <a href=\"$link_de\">
                     <!-- <i class=\"menu-icon fa fa-comment bg-yellow\"></i> -->
                      <i class=\"menu-icon\"><img class=\"img-circle\" src=\"flags/de.png\"></i>
                      <div class=\"menu-info\">
                        <h4 class=\"control-sidebar-subheading\">&nbsp;German (de-DE)</h4>
                        <p>&nbsp;switch to german</p>
                      </div>
                    </a>
                  </li>
                </ul><!-- /.control-sidebar-menu -->

                <h3 class=\"control-sidebar-heading\">Tasks Progress</h3>
                <ul class=\"control-sidebar-menu\">
                  <li>
                    <a href=\"javascript::;\">
                      <h4 class=\"control-sidebar-subheading\">
                        Custom Template Design
                        <span class=\"label label-danger pull-right\">70%</span>
                      </h4>
                      <div class=\"progress progress-xxs\">
                        <div class=\"progress-bar progress-bar-danger\" style=\"width: 70%\"></div>
                      </div>
                    </a>
                  </li>
                </ul><!-- /.control-sidebar-menu -->

              </div><!-- /.tab-pane -->
              <!-- Stats tab content -->
              <div class=\"tab-pane\" id=\"control-sidebar-stats-tab\">Stats Tab Content</div><!-- /.tab-pane -->
              <!-- Settings tab content -->
              <div class=\"tab-pane\" id=\"control-sidebar-settings-tab\">
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
                  </div><!-- /.form-group -->
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
         * Include needed JS files
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
        <script type=\"text/javascript\" src=\"../system/engines/bootstrap/dist/js/bootstrap.min.js\"></script>
        <!-- data table -->
        <script type=\"text/javascript\" src=\"../system/engines/jquery/jquery.dataTables.min.js\"></script>
        <!-- AdminLTE App -->
        <script type=\"text/javascript\" src=\"../system/engines/AdminLTE/js/app.min.js\"></script>";
            return null;
        }

        /**
         * SetUp Backend FX and end html body </body>
         * @param object $db Database
         * @return null
         */
        function drawHtmlEnd($db){
            global $loadingTime;
            /* SetUp backend effects */
            if(\YAWK\settings::getSetting($db, "backendFX") >= 1) { /* set time & type */
                \YAWK\backend::getFX($db, \YAWK\settings::getSetting($db, "backendFXtime"), \YAWK\settings::getSetting($db, "backendFXtype"));
            }
            /* display script running time */
            if (\YAWK\settings::getSetting($db, "loadingTime") === '1') {
                echo \YAWK\sys::getLoadingTime($loadingTime);
            }

            echo "
            </body>
            </html>";
            return null;
        }

    } // ./ class backend
} // ./ namespace