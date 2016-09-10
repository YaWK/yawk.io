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
                return \YAWK\user::drawLoginBox($db, "", "");
            }
        }

        public function drawProfile($db, $user){
            // get profile settings
            $changePassword = \YAWK\settings::getSetting($db, "userpage_changePassword");
            $changeEmail = \YAWK\settings::getSetting($db, "userpage_changeEmail");
            $changeFirstname = \YAWK\settings::getSetting($db, "userpage_changeFirstname");
            $changeLastname = \YAWK\settings::getSetting($db, "userpage_changeLastname");
            $changeStreet = \YAWK\settings::getSetting($db, "userpage_changeStreet");
            $changeZipcode = \YAWK\settings::getSetting($db, "userpage_changeZipcode");
            $changeCity = \YAWK\settings::getSetting($db, "userpage_changeCity");
            $changeCountry = \YAWK\settings::getSetting($db, "userpage_changeCountry");
            $changeUrl = \YAWK\settings::getSetting($db, "userpage_changeUrl");
            $changeTwitter = \YAWK\settings::getSetting($db, "userpage_changeTwitter");
            $changeFacebook = \YAWK\settings::getSetting($db, "userpage_changeFacebook");
            // form header
            $this->html .= "<form id=\"form\" class=\"form-inline\" action=\"welcome.html\" method=\"POST\">";
            $this->html .= "
                    <fieldset>
                    <legend><i class=\"fa fa-user\"></i> &nbsp;Profil Einstellungen <small>hier kannst Du Deine pers&ouml;nlichen Daten &auml;ndern.</small></legend>
                    <dl class=\"dl-horizontal\">";
            if ($changeEmail === '1'){
                $this->html .= "<dt><small><i class=\"fa fa-envelope-o\"></i></small> Email</dt>
                    <dd>
                        <input type=\"text\" class=\"form-control\" id=\"newEmail\" name=\"newEmail\" disabled aria-disabled='true' placeholder=\"$user->email\">
                        <label for=\"newEmail\"> &nbsp;die Emailadresse ist Teil deines Account und kann nicht ge&auml;ndert werden.</label><br><br>
                    </dd>";
            }
            if ($changePassword === '1'){
                $this->html .= "<dt><small><i class=\"fa fa-lock\"></i></small> Passwort</dt>
                    <dd>
                        <input type=\"password\" class=\"form-control\" id=\"newPassword1\" name=\"newPassword1\" placeholder=\"****\">
                        <label for=\"newPassword1\"> &nbsp;Passwort &auml;ndern </label> &nbsp;<br>
                        <input type=\"password\" class=\"form-control\" id=\"newPassword2\" name=\"newPassword2\" placeholder=\"****\">
                        <label for=\"newPassword2\"> &nbsp;Neues Passwort wiederholen </label> <br><br>
                    </dd>";
            }
            if ($changeFirstname === '1'){
                $this->html .= "<dt><small><i class=\"fa fa-user\"></i></small> Vorname*</dt>
                    <dd>
                        <input type=\"text\" class=\"form-control\" id=\"newFirstname\" name=\"newFirstname\" value=\"$user->firstname\" placeholder=\"set new firstname\">
                        <label for=\"newFirstname\"> &nbsp;*freiwillig </label> &nbsp;<br>
                    </dd>";
            }
            if ($changeLastname === '1'){
                $this->html .= "<dt><small><i class=\"fa fa-user\"></i></small> Lastname</dt>
                    <dd>
                        <input type=\"text\" class=\"form-control\" id=\"newLastname\" name=\"newLastname\" value=\"$user->lastname\" placeholder=\"set new lastname\">
                        <label for=\"newLastname\"> &nbsp;change your lastname </label> &nbsp;<br><br>
                    </dd>";
            }
            if ($changeStreet === '1'){
                $this->html .= "<dt><small><i class=\"fa fa-home\"></i></small> Street</dt>
                    <dd>
                        <input type=\"text\" class=\"form-control\" id=\"newStreet\" name=\"newStreet\" value=\"$user->street\" placeholder=\"set new street\">
                        <label for=\"newStreet\"> &nbsp;change your street </label> &nbsp;<br>
                    </dd>";
            }
            if ($changeZipcode === '1'){
                $this->html .= "<dt><small><i class=\"fa fa-home\"></i></small> Zipcode</dt>
                    <dd>
                        <input type=\"text\" class=\"form-control\" id=\"newZipcode\" name=\"newZipcode\" value=\"$user->zipcode\" placeholder=\"set new zipcode\">
                        <label for=\"newZipcode\"> &nbsp;change your zipcode </label> &nbsp;<br>
                    </dd>";
            }
            if ($changeCity === '1'){
                $this->html .= "<dt><small><i class=\"fa fa-home\"></i></small> City</dt>
                    <dd>
                        <input type=\"text\" class=\"form-control\" id=\"newCity\" name=\"newCity\" value=\"$user->city\" placeholder=\"set new city\">
                        <label for=\"newCity\"> &nbsp;change your city</label> &nbsp;<br>
                    </dd>";
            }
            if ($changeCountry === '1'){
                $this->html .= "<dt><small><i class=\"fa fa-home\"></i></small> Country</dt>
                    <dd>
                        <input type=\"text\" class=\"form-control\" id=\"newCountry\" name=\"newCountry\" value=\"$user->country\" placeholder=\"set new country\">
                        <label for=\"newCountry\"> &nbsp;change your country</label> &nbsp;
                    </dd>";
            }
            if ($changeUrl === '1'){
                $this->html .= "<br><dt><small><i class=\"fa fa-external-link\"></i></small> Website URL*</dt>
                    <dd>
                        <input type=\"text\" class=\"form-control\" id=\"newUrl\" name=\"newUrl\" size=\"42\" value=\"$user->url\" placeholder=\"set new website url\">
                        <label for=\"newUrl\"> &nbsp;*optional</label> &nbsp;<br>
                    </dd>";
            }
            if ($changeFacebook === '1'){
                $this->html .= "<dt><small><i class=\"fa fa-facebook-official\"></i></small> Facebook URL*</dt>
                    <dd>
                        <input type=\"text\" class=\"form-control\" id=\"newFacebook\" size=\"42\" value=\"$user->facebook\" name=\"newFacebook\" placeholder=\"set new facebook url\">
                        <label for=\"newFacebook\"> &nbsp;*optional</label> &nbsp;<br>
                    </dd>";
            }
            if ($changeTwitter === '1'){
                $this->html .= "<dt><small><i class=\"fa fa-twitter\"></i></small> Twitter URL*</dt>
                    <dd>
                        <input type=\"text\" class=\"form-control\" id=\"newTwitter\" size=\"42\" value=\"$user->twitter\" name=\"newTwitter\" placeholder=\"set new twitter url\">
                        <label for=\"newTwitter\"> &nbsp;*optional</label> &nbsp;<br><br>
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