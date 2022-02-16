<?php
/** Signup Backend Class */
namespace YAWK\PLUGINS\USERPAGE {
    /**
     * <b>Settings class extends class userpage</b>
     * <p>SETTINGS TAB serve functions to where user can set his privacy
     * and email settings. Also he can hide from whoisonline (if activated).</p>
     * <p><i>Class covers frontend functionality.
     * See Methods Summary for Details!</i></p>
     *
     * @author     Daniel Retzl <danielretzl@gmail.com>
     * @copyright  2009-2015 Daniel Retzl
     * @version    1.0.0
     * @brief Userpage Profile Class
     */
    class settings
    {
        /** * @param string html output data */
        protected $html;
        /** * @param object settings object */
        protected $settings;
        /** * @param string username */
        protected $username;
        /** * @param object user object */
        protected $user;

        /**
         * @brief init check if user is logged in - otherwise draw loginbox
         * @param object $db database
         * @return string html output (or login box)
         */
        public function init($db){
            global $user;
            $this->username = $_SESSION['username'];
            $user = new \YAWK\user($db);
            $user->loadProperties($db, $this->username);
            if ($user->isLoggedIn($db, $user->username)){
                $this->html .= $this->drawForm();
                return $this->html;
            }
            else {
                echo \YAWK\alert::draw("danger", "Error!", "Obviously you are not correctly logged in. Please re-login!","",6800);
                return \YAWK\user::drawLoginBox("","");
            }
        }

        /**
         * @brief draw user settings page
         */
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
                    <legend><i class=\"fa fa-eye\"></i> &nbsp;Privacy Settings <small> take care of your data.</small></legend>
                    <dl class=\"dl-horizontal\">
                    <dt><small><i class=\"fa fa-lock\"></i></small> Who is online?</dt>
                    <dd>
                        <input type=\"radio\" id=\"whoisonline-on\" name=\"privacy\" value=\"0\" $whoisonlineCheckedOn>
                        <label class=\"radio-inline control-label\" for=\"whoisonline-on\"> &nbsp;visible</label><br>

                        <input type=\"radio\" id=\"whoisonline-off\" name=\"privacy\" value=\"1\" $whoisonlineCheckedOff>
                        <label class=\"radio-inline control-label\" for=\"whoisonline-off\">  &nbsp;not visible</label><br><br>
                        </dd>
                    <dt><small><i class=\"fa fa-envelope-o\"></i></small> Email</dt>
                    <dd>
                        <input type=\"radio\" id=\"email-on\" name=\"public_email\" value=\"0\" $EmailCheckedOn>
                        <label class=\"radio-inline control-label\" for=\"email-on\"> &nbsp;visible for other users</label><br>

                        <input type=\"radio\" id=\"email-off\" name=\"public_email\" value=\"1\" $EmailCheckedOff>
                        <label class=\"radio-inline control-label\" for=\"email-off\">  &nbsp;not visible for other users</label><br>
                        </dd>
                    </dl>
                    </fieldset>";
            $this->html .= "<input type=\"submit\" name=\"submit\" value=\"Speichern\" class=\"btn btn-success\">";
            $this->html .= "<input type=\"hidden\" name=\"settings-update\" value=\"1\">";
            $this->html .= "<input type=\"hidden\" name=\"uid\" value=\"$user->id\">";
            $this->html .= "<br><br><br>";
            $this->html .= "<legend><i class=\"fa fa-user-times\"></i> &nbsp;Terminate my account<small> - Delete my permanent.</small></legend>
                        <dl class=\"dl-horizontal\">
                          <dt><small><i class=\"fa fa-ban\"></i></small> Delete account</dt>
                          <dd><a href=\"logout.html\" id=\"terminateUser\" class=\"btn btn-warning\"><i class=\"fa fa-ban\"></i> &nbsp;De-activate my account</a><br>
                          <label for=\"terminateUser\">Think twice. This will de-activate your account permanently.<br>
                          Attention! <u>You are not able to login anymore afterwards.</u></label></dd>
                        </dl><br>";
            $this->html .= "</form>";
        }

    }
}