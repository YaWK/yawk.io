<?php
namespace YAWK\PLUGINS\SEDCARD {

    class userpage
    {
        public function __construct(){
        include 'system/plugins/messages/classes/messages.php';
        }

        public function init(){
            //
            $usergroup = \YAWK\user::getGroup();
            if ($usergroup[0] === '1') {
                // public user
                return $this->getUserPage($usergroup[0], $usergroup[1]);
            } else if ($usergroup[0] === '2') {
                // registered user (vip)
                return self::getUserPage($usergroup[0], $usergroup[1]);
            } else if ($usergroup[0] === '3') {
                // provider
                return self::getProviderPage($usergroup[0], $usergroup[1]);
            } else if ($usergroup[0] === '4') {
                // admin
                return self::getAdminPage($usergroup[0], $usergroup[1]);
            } else if ($usergroup[0] >= '5') {
                // root
                return self::getRootPage($usergroup[0], $usergroup[1]);
            }
            return null;
        }

        public function getUserPage($gid, $usergroup) {
            return self::drawMenu($gid, $usergroup);
        }

        public function getProviderPage($gid, $usergroup) {
            return self::drawMenu($gid, $usergroup);
        }

        public function getAdminPage($gid, $usergroup) {
            return self::drawMenu($gid, $usergroup);
        }

        public function getRootPage($gid, $usergroup) {
            echo "<h5 class=\"btn-danger\">*** ROOT MODE ***</h5>";
            return self::drawMenu($gid, $usergroup);
        }

        public static function drawMenu($gid, $usergroup){
            if ($gid >= '5') {
                // root
                $dashboard = "VERY SPECIAL ROOT STUFF HERE...";
            }
            else  {
                if ($gid === '3') $i = 42; else $i = 2;
                if ($gid === '3') $t = 89; else $t = 5;
                if ($gid === '3') $y = 136; else $y = 18;
                $dashboard = "
                    <div class=\"row\">
                      <div class=\"col-md-4\"><h4><i class=\"fa fa-envelope-o fa-2x animated infinite pulse text-info\"></i> &nbsp;".$i." neue Nachrichten</h4></div>
                      <div class=\"col-md-4\"><h4><i class=\"fa fa-heart fa-2x animated infinite pulse text-danger\"></i> &nbsp;Du hast ".$t." Likes</h4></div>
                      <div class=\"col-md-4\"><h4><i class=\"fa fa-user fa-2x text-success\"></i> &nbsp;".$y." wurden heute auf dich aufmerksam</h4></div>
                    </div>";

            }
            if ($gid === '3') {
                // provider
                $appendTab = "<li role=\"stats\"><a href=\"#stats\" aria-controls=\"stats\" role=\"tab\" data-toggle=\"tab\">
                                <i class=\"fa fa-line-chart\"></i>&nbsp; Statistik</a></li>";
                $appendPanel = "<div role=\"tabpanel\" class=\"tab-pane animated fadeIn\" id=\"stats\"><h4><i class=\"fa fa-line-chart fa-2x\"></i> &nbsp;Statistik</h4></div>";

            }
            else {
                $appendTab = "";
                $appendPanel = "";
            }
            $html = "<h2>Hallo $_SESSION[username] <br><small>Du bist als $usergroup eingeloggt.</small></h2><div>

          <!-- Nav tabs -->
          <ul class=\"nav nav-tabs\" role=\"tablist\">
            <li role=\"presentation\" class=\"active\"><a href=\"#home\" aria-controls=\"home\" role=\"tab\" data-toggle=\"tab\">
            <i class=\"fa fa-home\"></i>&nbsp; &Uuml;bersicht</a></li>
            <li role=\"presentation\"><a href=\"#profile\" aria-controls=\"profile\" role=\"tab\" data-toggle=\"tab\">
            <i class=\"fa fa-user\"></i>&nbsp; Profil</a></li>
            <li role=\"presentation\"><a href=\"#messages\" aria-controls=\"messages\" role=\"tab\" data-toggle=\"tab\">
            <i class=\"fa fa-envelope\"></i>&nbsp; Inbox</a></li>
            <li role=\"presentation\"><a href=\"#settings\" aria-controls=\"settings\" role=\"tab\" data-toggle=\"tab\">
            <i class=\"fa fa-cog\"></i>&nbsp; Einstellungen</a></li>
            <li role=\"presentation\"><a href=\"#help\" aria-controls=\"help\" role=\"tab\" data-toggle=\"tab\">
            <i class=\"fa fa-question-circle\"></i>&nbsp; Hilfe</a></li>
            ".$appendTab."
          </ul>

          <!-- Tab panes -->
          <div class=\"tab-content\">
            <div role=\"tabpanel\" class=\"tab-pane active\" id=\"home\">
                <!-- ID HOME == user dashboard -->
                ".$dashboard."
            </div>

            <div role=\"tabpanel\" class=\"tab-pane animated fadeIn\" id=\"profile\"><h4><i class=\"fa fa-user fa-2x\"></i> &nbsp;Profil</h4></div>
            <div role=\"tabpanel\" class=\"tab-pane animated fadeIn\" id=\"messages\">";
            $messages = new \YAWK\PLUGINS\MESSAGES\messages();
            $html .= $messages->init();
            $html .= "</div>

            <div role=\"tabpanel\" class=\"tab-pane animated fadeIn\" id=\"settings\"><h4><i class=\"fa fa-cog fa-2x\"></i> &nbsp;Einstellungen</h4></div>
            <div role=\"tabpanel\" class=\"tab-pane animated fadeIn\" id=\"help\"><h4><i class=\"fa fa-question-circle fa-2x\"></i> &nbsp;Hilfe</h4></div>
            ".$appendPanel."
          </div>
        </div>";
            return $html;
        }
    }
}