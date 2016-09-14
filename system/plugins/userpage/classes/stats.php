<?php
/** Signup Backend Class */
namespace YAWK\PLUGINS\USERPAGE {
    class stats
    {
        protected $html;
        protected $user;

        public function __construct($db){
            global $user;
            $this->username = $_SESSION['username'];
            $user = new \YAWK\user();
            $user->loadProperties($db, $this->username);
        }

        public function init(){
            global $user;
            if($user->blocked === '0') { $blocked = "Alles ok. Dein Account ist in Ordnung."; $blockedHtml = "text-success"; }
            else { $blocked = "Dein Account wurde geblockt. Irgendetwas ist nicht in Ordnung."; $blockedHtml = "text-danger";
            }

            if($user->privacy === '0') { $privacy = "visible"; $privacyHtml = "text-success"; }
            else { $privacy = "hidden"; $privacyHtml="text-danger";
            }

            if($user->public_email === '0') { $public_email = "visible"; $emailHtml = "text-success"; }
            else { $public_email = "hidden"; $emailHtml = "text-danger";
            }

            if($user->date_expired === '0000-00-00 00:00:00') {
                $expiredHtml = "text-success";
                $expired = "never - lifetime account";
            }
            else {
                $expiredHtml = "text-warning";
                $expired = "$user->date_expired";
            }

            $this->html = "<br><legend><i class=\"fa fa-line-chart\"></i> &nbsp;Account Statistics <small> show details about your account</small></legend>
                        <dl class=\"dl-horizontal\">
                          <dt>Account Status:</dt>
                          <dd><small class=\"$blockedHtml\">$blocked</small></dd>
                          <dt>Active until:</dt>
                          <dd><small class=\"$expiredHtml\">$expired</small></dd>
                          <dt>Account created:</dt>
                          <dd><small>$user->date_created</small></dd>
                          <dt>Account changed:</dt>
                          <dd><small>$user->date_changed</small></dd>
                          <dt>&nbsp;</dt>
                          <dd>&nbsp;</dd>
                          <dt>Your last login:</dt>
                          <dd><small>$user->date_lastlogin</small></dd>
                          <dt>Logins:</dt>
                          <dd><small>$user->login_count</small></dd>
                          <dt>&nbsp;</dt>
                          <dd>&nbsp;</dd>
                          <dt>Online Status:</dt>
                          <dd><small class=\"$privacyHtml\">$privacy</small></dd>
                          <dt>Email adress:</dt>
                          <dd><small class=\"$emailHtml\">$public_email</small></dd>
                        </dl>";
            return $this->html;
        }
    }
}