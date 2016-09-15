<?php
/** Signup Backend Class */
namespace YAWK\PLUGINS\USERPAGE {
    class settings
    {
        protected $form;
        protected $html;
        protected $settings;
        protected $properties;
        protected $username;
        protected $user;

        public function init($db){
            global $user;
            $this->username = $_SESSION['username'];
            $user = new \YAWK\user();
            $user->loadProperties($db, $this->username);
            if ($user->isLoggedIn($db, $user->username)){
                $this->html .= self::drawForm();
                return $this->html;
            }
            else {
                echo \YAWK\alert::draw("danger", "Error!", "Obviously you are not correctly logged in. Please re-login!","",6800);
                return \YAWK\user::drawLoginBox("","");
            }
        }

        public function drawForm(){
            global $user;
            if ($user->privacy === '0'){
             $whoisonlineCheckedOn = "checked";
             $whoisonlineCheckedOff = "";
            } else {
                $whoisonlineCheckedOff = "checked";
                $whoisonlineCheckedOn = "";
            }
            if ($user->public_email === '0'){
                $EmailCheckedOn = "checked";
                $EmailCheckedOff = "";
            } else {
                $EmailCheckedOff = "checked";
                $EmailCheckedOn = "";
            }
            // form header
            $this->html .= "<form id=\"form\" class=\"form-inline\" action=\"welcome.html\" method=\"POST\">";
            $this->html .= "
                    <fieldset>
                    <legend><i class=\"fa fa-eye\"></i> &nbsp;Privatsph&auml;re Einstellungen <small> achte auf Deinen Datenschutz.</small></legend>
                    <dl class=\"dl-horizontal\">
                    <dt><small><i class=\"fa fa-lock\"></i></small> Who is online?</dt>
                    <dd>
                        <input type=\"radio\" id=\"whoisonline-on\" name=\"privacy\" value=\"0\" $whoisonlineCheckedOn>
                        <label class=\"radio-inline control-label\" for=\"whoisonline-on\"> &nbsp;sichtbar</label><br>

                        <input type=\"radio\" id=\"whoisonline-off\" name=\"privacy\" value=\"1\" $whoisonlineCheckedOff>
                        <label class=\"radio-inline control-label\" for=\"whoisonline-off\">  &nbsp;unsichtbar</label><br><br>
                        </dd>
                    <dt><small><i class=\"fa fa-envelope-o\"></i></small> Emailadresse</dt>
                    <dd>
                        <input type=\"radio\" id=\"email-on\" name=\"public_email\" value=\"0\" $EmailCheckedOn>
                        <label class=\"radio-inline control-label\" for=\"email-on\"> &nbsp;sichtbar f&uuml;r andere Benutzer</label><br>

                        <input type=\"radio\" id=\"email-off\" name=\"public_email\" value=\"1\" $EmailCheckedOff>
                        <label class=\"radio-inline control-label\" for=\"email-off\">  &nbsp;unsichtbar f&uuml;r andere Benutzer</label><br>
                        </dd>
                    </dl>
                    </fieldset>";
            $this->html .= "<input type=\"submit\" name=\"submit\" value=\"Speichern\" class=\"btn btn-success\">";
            $this->html .= "<input type=\"hidden\" name=\"settings-update\" value=\"1\">";
            $this->html .= "<input type=\"hidden\" name=\"uid\" value=\"$user->id\">";
            $this->html .= "<br><br><br>";
            $this->html .= "<legend><i class=\"fa fa-user-times\"></i> &nbsp;Mitgliedschaft beenden<small> - Zugang deaktivieren.</small></legend>
                        <dl class=\"dl-horizontal\">
                          <dt><small><i class=\"fa fa-ban\"></i></small> Account l&ouml;schen</dt>
                          <dd><a href=\"logout.html\" id=\"terminateUser\" class=\"btn btn-warning\"><i class=\"fa fa-ban\"></i> &nbsp;Account jetzt deaktivieren</a><br>
                          <label for=\"terminateUser\">Denk 2x nach. Das wird Deinen Account permanent deaktivieren.<br>
                          Achtung! Du kannst Dich danach <u>nicht mehr einloggen.</u></label></dd>
                        </dl><br>";
            $this->html .= "</form>";
        }

    }
}