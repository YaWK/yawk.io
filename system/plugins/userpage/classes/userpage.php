<?php
namespace YAWK\PLUGINS\USERPAGE {

    class userpage
    {
        protected $usergroup; // array
        protected $dashboard;
        protected $appendTab;
        protected $appendPanel;
        protected $userpage;
        protected $user;

        public function __construct(){
        }

        public function init($db, $user){
            $this->usergroup = \YAWK\user::getGroup($db);
            if ($this->usergroup['backend_allowed'] !== '1'){
                // backend access not allowed
                // check usergroup
                if ($this->usergroup['backend_allowed'] === '0') {
                    // load userpage
                    return $this->getUserPage($db, $user, $this->usergroup);
                }
                else {
                    return \YAWK\alert::draw("danger", "Error", "Could not load userpage. Something strange has happened.","",6800);
                }
            }
            else {
                // backend access granted, load root page
                return self::getRootPage($db, $user, $this->usergroup);
            }
        }

        public function getUserPage($db, $user, $usergroup) {
            return self::buildPage($db, $user, $usergroup, $this->appendTab, $this->appendPanel, $this->dashboard);
        }

        public function getRootPage($db, $user, $usergroup) {
            // check, if admin tab is enabled
            if (\YAWK\settings::getSetting($db, "userpage_admin") === '1'){
                // prepare dashboard
                $this->dashboard = "<h5 class=\"btn-danger\">*** ROOT MODE ***</h5>";
                // root mode notice
                $this->dashboard .= "Hello Admin! You are logged in with root access.";

                // append admin panel + tab
                $this->appendTab = "<li role=\"admin\"><a href=\"#admin\" aria-controls=\"admin\" role=\"tab\" data-toggle=\"tab\">
                                <i class=\"fa fa-wrench\"></i>&nbsp; Admin</a></li>";
                $this->appendPanel = "<div role=\"tabpanel\" class=\"tab-pane animated fadeIn\" id=\"admin\"><h4><i class=\"fa fa-lock fa-2x\"></i> &nbsp;Admin Stuff...</h4></div>";
            }
            else {
                $this->appendTab = "";
                $this->appendPanel = "";
            }
            return self::buildPage($db, $user, $usergroup, $this->appendTab, $this->appendPanel, $this->dashboard);
        }

        public static function buildPage($db, $user, $usergroup, $appendTab, $appendPanel, $dashboard)
        {   /** @var $db \YAWK\db */
            // ADDITIONAL CODE ------------------
            // IF ADMINs SHOULD GET THEIR OWN WELCOME-USERPAGE
          //  if ($usergroup['backend_allowed'] === '1') {
                // get soundblog artist button


                $dashboard .= "
                    <div class=\"row text-justify\">
                      <div class=\"col-md-4\">
                      MEMBERS CLUB<br>
                      col 1
                      </div>
                      <div class=\"col-md-8\">
                      col 2
                      </div>
                    </div>";
            // }

            // ADDITIONAL CODE ------------------
            // IF ADMINs SHOULD GET THEIR OWN WELCOME-USERPAGE
            // ELSE CODE FOR DEFAULT USERS....
            /*
            else  {
                $i = 42;
                $t = 89;
                $y = 136;
                $dashboard = "
                    <div class=\"row\">
                      <div class=\"col-md-4\"><h4><i class=\"fa fa-envelope-o fa-2x animated infinite pulse text-info\"></i> &nbsp;".$i." neue Nachrichten</h4></div>
                      <div class=\"col-md-4\"><h4><i class=\"fa fa-heart fa-2x animated infinite pulse text-danger\"></i> &nbsp;Du hast ".$t." Likes</h4></div>
                      <div class=\"col-md-4\"><h4><i class=\"fa fa-user fa-2x text-success\"></i> &nbsp;".$y." wurden heute auf dich aufmerksam</h4></div>
                    </div>";
            }
            */

            $html = "";
            $signup_hellotextsub = \YAWK\settings::getSetting($db, "userpage_hellotextsub");
            if ($signup_hellotextsub) {
                $subtext = "&nbsp;<small>$signup_hellotextsub</small>";
            }
            else {
                $subtext = "";
            }
            if (\YAWK\settings::getSetting($db, "userpage_hello") === '1'){
                $html .= "<h2>".\YAWK\settings::getSetting($db, "userpage_hellotext")."&nbsp;$_SESSION[username]!$subtext";
            }
            if (\YAWK\settings::getSetting($db, "userpage_hellogroup") === '1'){
                $html .= "<br><small>You are logged in as $usergroup[value]</small>";
            }
            $html .= "</h2><div>
            <!-- Nav tabs -->
          <ul class=\"nav nav-tabs\" role=\"tablist\">";
            // dashboard TAB
            if (\YAWK\settings::getSetting($db, "userpage_dashboard") === '1'){
               $html .= "<li role=\"presentation\" class=\"active\"><a href=\"#home\" aria-controls=\"home\" role=\"tab\" data-toggle=\"tab\">
                        <i class=\"fa fa-trophy\"></i>&nbsp; VIP Startseite</a></li>";
            }
            // profile TAB
            if (\YAWK\settings::getSetting($db, "userpage_profile") === '1') {
                $html .= "<li role=\"presentation\"><a href=\"#profile\" aria-controls=\"profile\" role=\"tab\" data-toggle=\"tab\">
                         <i class=\"fa fa-user\"></i>&nbsp; Profil bearbeiten</a></li>";
            }
            // messages TAB
            if (\YAWK\settings::getSetting($db, "userpage_msgplugin") === '1') {
                $html .="<li role = \"presentation\"><a href=\"#messages\" aria-controls=\"messages\" role=\"tab\" data-toggle=\"tab\">
                        <i class=\"fa fa-envelope\"></i>&nbsp; Inbox</a></li>";
            }
            // settings TAB
            if (\YAWK\settings::getSetting($db, "userpage_settings") === '1') {
                $html .= "<li role=\"presentation\"><a href=\"#settings\" aria-controls=\"settings\" role=\"tab\" data-toggle=\"tab\">
                <i class=\"fa fa-cog\"></i>&nbsp; Einstellungen</a></li>";
            }
            // stats TAB
            if (\YAWK\settings::getSetting($db, "userpage_stats") === '1') {
                $html .= "<li role=\"presentation\"><a href=\"#stats\" aria-controls=\"stats\" role=\"tab\" data-toggle=\"tab\">
                <i class=\"fa fa-line-chart\"></i>&nbsp; Stats</a></li>";
            }
            // help TAB
            if (\YAWK\settings::getSetting($db, "userpage_help") === '1') {
                $signup_help = 1;
                $html .= "<li role=\"presentation\"><a href=\"#help\" aria-controls=\"help\" role=\"tab\" data-toggle=\"tab\">
                <i class=\"fa fa-question-circle\"></i>&nbsp; Hilfe</a></li>";
            }
            // append TAB
            $html .= "$appendTab
          </ul>

          <!-- CONTENT -->
          <!-- Tab panes -->
          <div class=\"tab-content\">";
            // dashboard TAB CONTENT
            if (\YAWK\settings::getSetting($db, "userpage_dashboard") === '1'){
                $html .= "<div role=\"tabpanel\" class=\"tab-pane active\" id=\"home\">
                    <!-- ID HOME == user dashboard -->
                    ".$dashboard."
                    </div>";
            }
            // profile TAB CONTENT
            if (\YAWK\settings::getSetting($db, "userpage_profile") === '1') {
                $html .= "<div role=\"tabpanel\" class=\"tab-pane animated fadeIn\" id=\"profile\"><br>";
                // profile class include
                include 'system/plugins/userpage/classes/profile.php';
                $profile = new \YAWK\PLUGINS\USERPAGE\profile();
                $html .= $profile->init($db);
                $html .= "</div>";
            }
            // message plg TAB CONTENT
            if (\YAWK\settings::getSetting($db, "userpage_msgplugin") === '1'){
               $html .= "<div role=\"tabpanel\" class=\"tab-pane animated fadeIn\" id=\"messages\">";
                // message plugin include
                include 'system/plugins/messages/classes/messages.php';
                $messages = new \YAWK\PLUGINS\MESSAGES\messages($db);
                $html .= $messages->init($db);
                $html .= "</div>";
            }
            // settings TAB CONTENT
            if (\YAWK\settings::getSetting($db, "userpage_settings") === '1'){
                $html .= "<div role=\"tabpanel\" class=\"tab-pane animated fadeIn\" id=\"settings\"><br>";
                // settings class include
                include 'system/plugins/userpage/classes/settings.php';
                $settings = new \YAWK\PLUGINS\USERPAGE\settings();
                $html .= $settings->init($db);
                $html .= "</div>";

            }
            // stats TAB CONTENT
            if (\YAWK\settings::getSetting($db, "userpage_stats") === '1') {
                $html .="<div role=\"tabpanel\" class=\"tab-pane animated fadeIn\" id=\"stats\">";

                include 'system/plugins/userpage/classes/stats.php';
                $stats = new \YAWK\PLUGINS\USERPAGE\stats();
                $html .= $stats->init($db);
                $html .="</div>";
            }

            // help TAB CONTENT
            if (\YAWK\settings::getSetting($db, "userpage_help") === '1') {
               $html .="<div role=\"tabpanel\" class=\"tab-pane animated fadeIn\" id=\"help\">";$html .= \YAWK\settings::getLongSetting($db, "userpage_helptext");$html .="</div>";
            }
            // append panel TAB CONTENT
            $html .="$appendPanel
          </div>
        </div>";
            return $html;
        } // end buildpage
    } // end class
} // end namespace
