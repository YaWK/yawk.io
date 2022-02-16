<?php
/** Signup Backend Class */
namespace YAWK\PLUGINS\USERPAGE {
    /**
     * <b>Stats class for userpage</b>
     * <p>STATS TAB shows the user his account stats.</p>
     * <p><i>Class covers frontend functionality.
     * See Methods Summary for Details!</i></p>
     *
     * @author     Daniel Retzl <danielretzl@gmail.com>
     * @copyright  2009-2015 Daniel Retzl
     * @version    1.0.0
     * @brief Userpage Profile Class
     */
    class stats
    {
        /** * @param string html output */
        protected $html;
        /** * @param object user object */
        protected $user;

        /**
         * @brief stats constructor. load properties for username
         * @param object $db database
         */
        public function __construct($db){
            global $user;
            $this->username = $_SESSION['username'];
            $user = new \YAWK\user($db);
            $user->loadProperties($db, $this->username);
        }

        /**
         * @brief draw account stats.
         * @return string account stats
         */
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

            if($user->date_expired === NULL) {
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