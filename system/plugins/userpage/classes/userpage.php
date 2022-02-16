<?php
namespace YAWK\PLUGINS\USERPAGE {
    /**
     * <b>Userpage Plugin </b>
     * <p>Userpage Class check and build the userpage.</p>
     * <p><i>Class covers frontend functionality.
     * See Methods Summary for Details!</i></p>
     *
     * @author     Daniel Retzl <danielretzl@gmail.com>
     * @copyright  2009-2015 Daniel Retzl
     * @version    1.0.0
     * @brief Userpage Profile Class
     */
    class userpage
    {
        /** * @param string dashboard */
        protected $dashboard;
        /** * @param string append tab */
        protected $appendTab;
        /** * @param string append panel */
        protected $appendPanel;

        /**
         * @brief userpage constructor.
         * @param object $db database
         * @param object $user user object
         */
        public function __construct($db, $user){
            /* property $user */
            if (isset($username) && (!empty($username)))
            {
                $this->user = $username;
            }
            $this->usergroup = \YAWK\user::getGroup($db);
        }

        /**
         * @brief init function check if backend is allowed and load userpage
         * @param object $db database
         * @param object $user user
         * @return bool|null|string
         */
        public function init($db, $user, $lang){
            if ($this->usergroup['backend_allowed'] !== '1'){
                // backend access not allowed
                // check usergroup
                if ($this->usergroup['backend_allowed'] === '0') {
                    // load userpage
                    return $this->getUserPage($db, $user, $lang);
                }
                else
                {   // throw error
                    return \YAWK\alert::draw("danger", "Error", "Could not load userpage. Something strange has happened.","",6800);
                }
            }
            else {
                // backend access granted, load root page
                if (\YAWK\user::isAdmin($db)){
                    return $this->getRootPage($db, $user);
                }
            }
            return null;
        }

        /**
         * @brief getUserPage is a wrapper for buildPage
         * @param object $db database
         * @param object $user object
         * @param object $lang language
         * @return string buildPage function
         */
        public function getUserPage($db, $user, $lang) {
            return $this->buildPage($db, $user->username, $user->gid, $this->appendTab, $this->appendPanel, $this->dashboard, $lang);
        }

        /**
         * @brief detect admin and build a special 'ROOT' page with admin functions... TODO: in development
         * @param object $db database
         * @param object $user object
         * @return string buildPage with admin functions
         */
        public function getRootPage($db, $user) {
            // check, if admin tab is enabled
            if (\YAWK\settings::getSetting($db, "userpage_admin") === '1'){
                // prepare dashboard
                $this->dashboard = "<h5 class=\"btn-danger\">*** ROOT MODE ***</h5>";
                // root mode notice
                $this->dashboard .= "Hello $user->username! You are logged in with root access.";

                // append admin panel + tab
                $this->appendTab = "<li class=\"nav-item\" role=\"admin\"><a href=\"#admin\" class=\"nav-link\" aria-controls=\"admin\" role=\"tab\" data-toggle=\"tab\">
                                <i class=\"fa fa-wrench\"></i>&nbsp; Admin</a></li>";
                $this->appendPanel = "<div role=\"tabpanel\" class=\"tab-pane animated fadeIn\" id=\"admin\"><h4>
                                      <i class=\"fa fa-lock fa-2x\"></i> &nbsp;Admin Stuff...</h4></div>";
            }
            else {
                $this->appendTab = "";
                $this->appendPanel = "";
            }
            return self::buildPage($db, $user->username, $user->gid, $this->appendTab, $this->appendPanel, $this->dashboard, $lang);
        }

        /**
         * @brief build the user page and draw html output
         * @param object $db database
         * @param object $user object
         * @param int $usergroup group ID
         * @param string $appendTab the tab to append, if
         * @param string $appendPanel the panel to append, if
         * @param string $dashboard some dashboard content
         * @return string draw html output
         */
        public static function buildPage($db, $user, $usergroup, $appendTab, $appendPanel, $dashboard, $lang)
        {   /** @var $db \YAWK\db */
            // ADDITIONAL CODE ------------------
            // IF ADMINs SHOULD GET THEIR OWN WELCOME-USERPAGE
          //  if ($usergroup['backend_allowed'] === '1') {
                // get soundblog artist button
            /* GET ACTIVE TABS */
            $activeTab = \YAWK\settings::getSetting($db, "userpage_activeTab");
            if ($activeTab == "Dashboard") {
                $activeDashboardTab = "class=\"active\"";
                $activeDashboardPane = "active";
            }
            else {
                $activeDashboardTab = "";
                $activeDashboardPane = "";
            }
            if ($activeTab == "Profile") {
                $activeProfileTab = "class=\"active\"";
                $activeProfilePane = "active";
            }
            else {
                $activeProfileTab = "";
                $activeProfilePane = "";
            }
            if ($activeTab == "Messages") {
                $activeMessagesTab = "class=\"active\"";
                $activeMessagesPane = "active";
            }
            else {
                $activeMessagesTab = "";
                $activeMessagesPane = "";
            }
            if ($activeTab == "Settings") {
                $activeSettingsTab = "class=\"active\"";
                $activeSettingsPane = "active";
            }
            else {
                $activeSettingsTab = "";
                $activeSettingsPane = "";
            }
            if ($activeTab == "Stats") {
                $activeStatsTab = "class=\"active\"";
                $activeStatsPane = "active";
            }
            else {
                $activeStatsTab = "";
                $activeStatsPane = "";
            }
            if ($activeTab == "Help") {
                $activeHelpTab = "class=\"active\"";
                $activeHelpPane = "active";
            }
            else {
                $activeHelpTab = "";
                $activeHelpPane = "";
            }
            if ($activeTab == "Admin") {
                $activeAdminTab = "class=\"active\"";
                $activeAdminPane = "active";
            }
            else {
                $activeAdminTab = "";
                $activeAdminPane = "";
            }

                $dashboard .= "
                      <div class=\"col-md-4\">
                      col 1
                      </div>
                      <div class=\"col-md-8\">
                      col 2
                      </div>";

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
                $userGroupName = \YAWK\user::getGroupNameFromID($db, $usergroup);
                $html .= "<br><small>You are logged in as $userGroupName</small>";
            }
            $html .= "</h2><div>
            <!-- Nav tabs -->
          <ul class=\"nav nav-tabs\" role=\"tablist\">";
            // dashboard TAB
            if (\YAWK\settings::getSetting($db, "userpage_dashboard") === '1'){
               $html .= "<li class=\"nav-item\" role=\"presentation\" $activeDashboardTab><a href=\"#home\" class=\"nav-link active\" aria-controls=\"home\" role=\"tab\" data-toggle=\"tab\">
                        <i class=\"fa fa-home\"></i>&nbsp; Userpage</a></li>";
            }
            // profile TAB
            if (\YAWK\settings::getSetting($db, "userpage_profile") === '1') {
                $html .= "<li class=\"nav-item\" role=\"presentation\" $activeProfileTab><a href=\"#profile\" class=\"nav-link\" aria-controls=\"profile\" role=\"tab\" data-toggle=\"tab\">
                         <i class=\"fa fa-user\"></i>&nbsp; Edit Profile</a></li>";
            }
            // messages TAB
            if (\YAWK\settings::getSetting($db, "userpage_msgplugin") === '1') {
                $html .="<li class=\"nav-item\" role = \"presentation\" $activeMessagesTab><a href=\"#messages\" class=\"nav-link\"  aria-controls=\"messages\" role=\"tab\" data-toggle=\"tab\">
                        <i class=\"fa fa-envelope\"></i>&nbsp; Messages</a></li>";
            }
            // settings TAB
            if (\YAWK\settings::getSetting($db, "userpage_settings") === '1') {
                $html .= "<li class=\"nav-item\" role=\"presentation\" $activeSettingsTab><a href=\"#settings\" class=\"nav-link\" aria-controls=\"settings\" role=\"tab\" data-toggle=\"tab\">
                <i class=\"fa fa-cog\"></i>&nbsp; Settings</a></li>";
            }
            // stats TAB
            if (\YAWK\settings::getSetting($db, "userpage_stats") === '1') {
                $html .= "<li class=\"nav-item\" role=\"presentation\" $activeStatsTab><a href=\"#stats\" class=\"nav-link\" aria-controls=\"stats\" role=\"tab\" data-toggle=\"tab\">
                <i class=\"fa fa-line-chart\"></i>&nbsp; Stats</a></li>";
            }
            // help TAB
            if (\YAWK\settings::getSetting($db, "userpage_help") === '1') {
                $signup_help = 1;
                $html .= "<li class=\"nav-item\" role=\"presentation\" $activeHelpTab><a href=\"#help\" class=\"nav-link\" aria-controls=\"help\" role=\"tab\" data-toggle=\"tab\">
                <i class=\"fa fa-question-circle\"></i>&nbsp; Help</a></li>";
            }
            // append TAB
            $html .= "$appendTab
          </ul>

          <!-- CONTENT -->
          <!-- Tab panes -->
          <div class=\"tab-content\">";
            // dashboard TAB CONTENT
            if (\YAWK\settings::getSetting($db, "userpage_dashboard") === '1'){
                $html .= "<div role=\"tabpanel\" class=\"tab-pane $activeDashboardPane animated fadeIn\" id=\"home\">
                    <!-- ID HOME == user dashboard -->
                    ".$dashboard."
                    </div>";
            }
            // profile TAB CONTENT
            if (\YAWK\settings::getSetting($db, "userpage_profile") === '1') {
                $html .= "<div role=\"tabpanel\" class=\"tab-pane $activeProfilePane animated fadeIn\" id=\"profile\"><br>";
                // profile class include
                include 'system/plugins/userpage/classes/profile.php';
                $profile = new \YAWK\PLUGINS\USERPAGE\profile();
                $html .= $profile->init($db);
                $html .= "</div>";
            }
            // message plg TAB CONTENT
            if (\YAWK\settings::getSetting($db, "userpage_msgplugin") === '1'){
               $html .= "<div role=\"tabpanel\" class=\"tab-pane $activeMessagesPane animated fadeIn\" id=\"messages\">";
                // message plugin include
                include 'system/plugins/messages/classes/messages.php';
                $messages = new \YAWK\PLUGINS\MESSAGES\messages($db, "frontend");
                $html .= $messages->init($db, $lang);
                $html .= "</div>";
            }
            // settings TAB CONTENT
            if (\YAWK\settings::getSetting($db, "userpage_settings") === '1'){
                $html .= "<div role=\"tabpanel\" class=\"tab-pane $activeSettingsPane animated fadeIn\" id=\"settings\"><br>";
                // settings class include
                include 'system/plugins/userpage/classes/settings.php';
                $settings = new \YAWK\PLUGINS\USERPAGE\settings();
                $html .= $settings->init($db);
                $html .= "</div>";

            }
            // stats TAB CONTENT
            if (\YAWK\settings::getSetting($db, "userpage_stats") === '1') {
                $html .="<div role=\"tabpanel\" class=\"tab-pane $activeStatsPane animated fadeIn\" id=\"stats\">";

                include 'system/plugins/userpage/classes/stats.php';
                $stats = new \YAWK\PLUGINS\USERPAGE\stats($db);
                $html .= $stats->init();
                $html .="</div>";
            }

            // help TAB CONTENT
            if (\YAWK\settings::getSetting($db, "userpage_help") === '1') {
               $html .="<div role=\"tabpanel\" class=\"tab-pane $activeHelpPane animated fadeIn\" id=\"help\">";$html .= \YAWK\settings::getLongSetting($db, "userpage_helptext");$html .="</div>";
            }
            // append panel TAB CONTENT
            $html .="$appendPanel
          </div>
        </div>";
            return $html;
        } // end buildpage
    } // end class
} // end namespace
