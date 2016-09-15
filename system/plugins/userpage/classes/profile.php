<?php
/** Signup Backend Class */
namespace YAWK\PLUGINS\USERPAGE {
    class profile
    {
        protected $form;
        protected $html;
        protected $settings;
        protected $properties;
        protected $username;
        protected $user;

        public function __construct(){
            $this->html = "";
        }

        public function init($db)
        {
            global $user;
            $this->username = $_SESSION['username'];
            $user = new \YAWK\user();
            $user->loadProperties($db, $this->username);
            if ($user->isLoggedIn($db, $user->username)) {
                // user is logged in, draw profile page
                $this->html .= self::drawProfile($db, $user);
                return $this->html;
              //  $this->html .= self::drawForm();
              //  return $this->html;
            } else {
                echo \YAWK\alert::draw("danger", "Error!", "Obviously you are not correctly logged in. Please re-login!","",6800);
                return \YAWK\user::drawLoginBox("", "");
            }
        }

        public function drawProfile($db, $user){
            // get profile settings
            $changeUsername = \YAWK\settings::getSetting($db, "userpage_changeUsername");
            $changePassword = \YAWK\settings::getSetting($db, "userpage_changePassword");
            $changeEmail = \YAWK\settings::getSetting($db, "userpage_changeEmail");
            $changeFirstname = \YAWK\settings::getSetting($db, "userpage_changeFirstname");
            $changeLastname = \YAWK\settings::getSetting($db, "userpage_changeLastname");
            $changeStreet = \YAWK\settings::getSetting($db, "userpage_changeStreet");
            $changeZipcode = \YAWK\settings::getSetting($db, "userpage_changeZipcode");
            $changeCity = \YAWK\settings::getSetting($db, "userpage_changeCity");
            $changeCountry = \YAWK\settings::getSetting($db, "userpage_changeCountry");
            $changeState = \YAWK\settings::getSetting($db, "userpage_changeState");
            $changeUrl = \YAWK\settings::getSetting($db, "userpage_changeUrl");
            $changeTwitter = \YAWK\settings::getSetting($db, "userpage_changeTwitter");
            $changeFacebook = \YAWK\settings::getSetting($db, "userpage_changeFacebook");
            // form header
            $this->html .= "<form id=\"form\" class=\"form-inline\" action=\"welcome.html\" method=\"POST\">";
            $this->html .= "
                    <fieldset>
                    <legend><i class=\"fa fa-user\"></i> &nbsp;Profile Settings <small>Change your personal data.</small></legend>
                    <dl class=\"dl-horizontal\">";
            /* USERNAME */
            if ($changeUsername === '1'){
                $this->html .= "<dt><small><i class=\"fa fa-user\"></i></small> Username</dt>
                    <dd>
                        <input type=\"text\" class=\"form-control\" id=\"newUsername\" name=\"newUsername\" value=\"$user->username\" placeholder=\"set new username\">
                        <label for=\"newUsername\" class=\"small\"> &nbsp;change your username</label> &nbsp;<br>
                    </dd>";
            }
            /* EMAIL */
            if ($changeEmail === '0') {
                $disabled = "disabled aria-disabled=\"true\"";
                $disabledLabel = "The email address is part of your account and cannot be changed.";
            }
            else {
                $disabled = '';
                $disabledLabel = "change email address";
                $this->html .= "<dt><small><i class=\"fa fa-envelope-o\"></i></small> Email</dt>
                    <dd>
                        <input type=\"text\" class=\"form-control\" value=\"$user->email\" id=\"newEmail\" name=\"newEmail\" $disabled placeholder=\"$user->email\">
                        <label for=\"newEmail\" class=\"small\"> &nbsp;$disabledLabel</label><br><br>
                    </dd>";
            }
            /* PASSWORD */
            if ($changePassword === '1'){
                $this->html .= "<dt><small><i class=\"fa fa-lock\"></i></small> Password</dt>
                    <dd>
                        <input type=\"password\" class=\"form-control\" id=\"newPassword1\" name=\"newPassword1\" placeholder=\"****\">
                        <label for=\"newPassword1\" class=\"small\"> &nbsp;new password</label> &nbsp;<br>
                        <input type=\"password\" class=\"form-control\" id=\"newPassword2\" name=\"newPassword2\" placeholder=\"****\">
                        <label for=\"newPassword2\" class=\"small\"> &nbsp;new password <small>(again)</small></label> <br><br>
                    </dd>";
            }
            /* FIRST NAME */
            if ($changeFirstname === '1'){
                $this->html .= "<dt><small><i class=\"fa fa-user\"></i></small> First Name</dt>
                    <dd>
                        <input type=\"text\" class=\"form-control\" id=\"newFirstname\" name=\"firstname\" value=\"$user->firstname\" placeholder=\"set new firstname\">
                        <label for=\"newFirstname\" class=\"small\"> &nbsp;change your first name</label> &nbsp;<br>
                    </dd>";
            }
            /* LAST NAME */
            if ($changeLastname === '1'){
                $this->html .= "<dt><small><i class=\"fa fa-user\"></i></small> Last Name</dt>
                    <dd>
                        <input type=\"text\" class=\"form-control\" id=\"newLastname\" name=\"lastname\" value=\"$user->lastname\" placeholder=\"set new lastname\">
                        <label for=\"newLastname\" class=\"small\"> &nbsp;change your last name</label> &nbsp;<br><br>
                    </dd>";
            }
            /* STREET */
            if ($changeStreet === '1'){
                $this->html .= "<dt><small><i class=\"fa fa-home\"></i></small> Street</dt>
                    <dd>
                        <input type=\"text\" class=\"form-control\" id=\"newStreet\" name=\"street\" value=\"$user->street\" placeholder=\"set new street\">
                        <label for=\"newStreet\" class=\"small\"> &nbsp;change your street</label> &nbsp;<br>
                    </dd>";
            }
            /* ZIPCODE */
            if ($changeZipcode === '1'){
                $this->html .= "<dt><small><i class=\"fa fa-home\"></i></small> Zipcode</dt>
                    <dd>
                        <input type=\"text\" class=\"form-control\" id=\"newZipcode\" name=\"zipcode\" value=\"$user->zipcode\" placeholder=\"set new zipcode\">
                        <label for=\"newZipcode\" class=\"small\"> &nbsp;change your zipcode</label> &nbsp;<br>
                    </dd>";
            }
            /* CITY */
            if ($changeCity === '1'){
                $this->html .= "<dt><small><i class=\"fa fa-home\"></i></small> City</dt>
                    <dd>
                        <input type=\"text\" class=\"form-control\" id=\"newCity\" name=\"city\" value=\"$user->city\" placeholder=\"set new city\">
                        <label for=\"newCity\" class=\"small\"> &nbsp;change your city</label> &nbsp;<br>
                    </dd>";
            }
            /* STATE */
            if ($changeState === '1'){
                $this->html .= "<dt><small><i class=\"fa fa-home\"></i></small> State</dt>
                    <dd>
                        <input type=\"text\" class=\"form-control\" id=\"newState\" name=\"state\" value=\"$user->country\" placeholder=\"set new state\">
                        <label for=\"newState\" class=\"small\"> &nbsp;change your state</label> &nbsp;
                    </dd>";
            }
            /* COUNTRY */
            if ($changeCountry === '1'){
                $this->html .= "<dt><small><i class=\"fa fa-home\"></i></small> Country</dt>
                    <dd>
                        <input type=\"text\" class=\"form-control\" id=\"newCountry\" name=\"country\" value=\"$user->country\" placeholder=\"set new country\">
                        <label for=\"newCountry\" class=\"small\"> &nbsp;change your country</label> &nbsp;
                    </dd>";
            }
            /* URL */
            if ($changeUrl === '1'){
                $this->html .= "<br><dt><small><i class=\"fa fa-external-link\"></i></small> Website URL*</dt>
                    <dd>
                        <input type=\"text\" class=\"form-control\" id=\"newUrl\" name=\"url\" size=\"42\" value=\"$user->url\" placeholder=\"set new website url\">
                        <label for=\"newUrl\" class=\"small\"> &nbsp;*optional</label> &nbsp;<br>
                    </dd>";
            }
            /* FACEBOOK */
            if ($changeFacebook === '1'){
                $this->html .= "<dt><small><i class=\"fa fa-facebook-official\"></i></small> Facebook URL*</dt>
                    <dd>
                        <input type=\"text\" class=\"form-control\" id=\"newFacebook\" size=\"42\" value=\"$user->facebook\" name=\"facebook\" placeholder=\"set new facebook url\">
                        <label for=\"newFacebook\" class=\"small\"> &nbsp;*optional</label> &nbsp;<br>
                    </dd>";
            }
            /* TWITTER */
            if ($changeTwitter === '1'){
                $this->html .= "<dt><small><i class=\"fa fa-twitter\"></i></small> Twitter URL*</dt>
                    <dd>
                        <input type=\"text\" class=\"form-control\" id=\"newTwitter\" size=\"42\" value=\"$user->twitter\" name=\"twitter\" placeholder=\"set new twitter url\">
                        <label for=\"newTwitter\" class=\"small\"> &nbsp;*optional</label> &nbsp;<br><br>
                    </dd>";
            }
                $this->html .= "
                    <dt>&nbsp;</dt>
                    <dd>&nbsp;</dd>
                    </dl>
                    </fieldset>";
            $this->html .= "<input type=\"submit\" name=\"submit\" value=\"Speichern\" class=\"btn btn-success\">";
            $this->html .= "<input type=\"hidden\" name=\"profile-update\" value=\"1\">";
            $this->html .= "<input type=\"hidden\" name=\"uid\" value=\"$user->id\">";
            $this->html .= "<br><br><br>";
        return null;
        }
    }
}