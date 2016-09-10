<?php
namespace YAWK\PLUGINS\SIGNUP {
    class buildForm
    {
        public $html;
        public $form;
        function __construct()
        {
            $this->form = "";
            $this->html = "";
        }

        public function init(){
            $this->form = self::buildForm();
            return $this->html;
        }

        public function buildForm(){
            $this->form .= self::getHeader();
            $this->form .= self::getLayout();
            $this->form .= self::getFooter();
            return $this->form;
        }

        public function getForm(){
            $this->form .= self::getGroupSelect();
            $this->form .= self::getMandatoryFields();
            $this->form .= self::getAdditionalFields();
            $this->form .= self::getTerms();
            $this->form .= self::getSubmitButton();
            return $this->form;
        }

        public function getHeader()
        {
            // form header
            $this->html .= "<form id=\"form\" action=\"welcome.html\" method=\"POST\">";
        }

        public function getTitle()
        {
            // form title
            $this->html .= \YAWK\settings::getSetting($db, "signup_title");
        }

        public function getLegend()
        {
                // gid 0 form legend (public) -- default --
                $this->html .= "<div id=\"0_hidden\">";
                $this->html .= \YAWK\settings::getLongSetting($db, "signup_legend0");
                $this->html .= "</div>";
                // gid 1 form legend (guest)
                $this->html .= "<div id=\"1_hidden\">";
                $this->html .= \YAWK\settings::getLongSetting($db, "signup_legend1");
                $this->html .= "</div>";
                // gid 1 form legend (guest)
                $this->html .= "<div id=\"2_hidden\">";
                $this->html .= \YAWK\settings::getLongSetting($db, "signup_legend2");
                $this->html .= "</div>";
                // gid 1 form legend (guest)
                $this->html .= "<div id=\"3_hidden\">";
                $this->html .= \YAWK\settings::getLongSetting($db, "signup_legend3");
                $this->html .= "</div>";
                // gid 1 form legend (guest)
                $this->html .= "<div id=\"4_hidden\">";
                $this->html .= \YAWK\settings::getLongSetting($db, "signup_legend4");
                $this->html .= "</div>";
                // gid 1 form legend (guest)
                $this->html .= "<div id=\"5_hidden\">";
                $this->html .= \YAWK\settings::getLongSetting($db, "signup_legend5");
                $this->html .= "</div>";
        }

        public function getLayout()
        {
            // get selected form layout (left, right, 1,2, or 3 cols...)
            $layout = \YAWK\settings::getSetting($db, "signup_layout");
            // layout row
            $this->html .= "<div class=\"row\">";
            // switch case layout and load corresponding htmlcode
            switch ($layout) {
                case "left":
                    // form title
                    $this->html .= "<div class=\"col-md-6\">";
                    $this->html .= self::getLegend();
                    $this->html .= "</div>";
                    $this->html .= "<div class=\"col-md-6\">";
                    $this->html .= self::getTitle();
                    $this->html .= self::getForm();
                    $this->html .= "</div>";
                    break;
                case "right":
                    $this->html .= "<div class=\"col-md-6\">";
                    $this->html .= self::getTitle();
                    $this->html .= self::getForm();
                    $this->html .= "</div><div class=\"col-md-6\">";
                    $this->html .= self::getLegend();
                    $this->html .= "</div>";
                    break;
                case "plain":
                    $this->html .= "<div class=\"col-lg-12\">";
                    $this->html .= self::getTitle();
                    $this->html .= self::getForm();
                    $this->html .= "</div>";
                    break;
                case "center":
                    $this->html .= "<div class=\"col-md-4\">&nbsp;</div>";
                    $this->html .= "<div class=\"col-md-4\">";
                    $this->html .= self::getTitle();
                    $this->html .= self::getForm();
                    $this->html .= "</div>";
                    $this->html .= "<div class=\"col-md-4\">&nbsp;</div>";
                    break;
            }
            $this->html .= "</div>";
        }

        public function getFooter(){
            // form end
            $this->html .= "</form>";
        }

        public function getGroupSelect($db)
        {   /** @var $db \YAWK\db */
            if (\YAWK\settings::getSetting($db, "signup_gid") === '1')
            {   // user group select field is allowed, fetch groups...
                if ($res = $db->query("SELECT * FROM {user_groups} WHERE signup_allowed = '1'"))
                {   // and build select field
                    $this->html.= "<label for=\"gid\">Registriere Dich als:</label>
                   <select id=\"gid\" name=\"gid\" class=\"form-control\">
                   <option value=\"\" disabled selected>bitte w&auml;hle aus</option>";
                    while ($row = mysqli_fetch_assoc($res))
                    {   // loop items
                        $this->html .= "<option value=\"".$row['id']."\">".$row['value']."</option>";
                    }
                    $this->html .= "</select>";
                }
            }
            else
            {   // empty html, because signup group selector (signup_gid) is disabled
                $this->html .= "";
            }
        }

        public function getMandatoryFields(){
            $this->html .= "<label for=\"username\">Benutzername</label>
                            <input type=\"text\" id=\"username\" name=\"username\" class=\"form-control\" placeholder=\"Benutzername\">

                            <label for=\"email\">Emailadresse</label>
                            <input type=\"text\" id=\"email\" name=\"email\" class=\"form-control\" placeholder=\"your@email.com\">

                            <label for=\"password1\">Passwort</label>
                            <input type=\"password\" id=\"password1\" name=\"password1\" class=\"form-control\" placeholder=\"Passwort\">

                            <label for=\"password2\">Passwort wiederholen</label>
                            <input type=\"password\" id=\"password2\" name=\"password2\" class=\"form-control\" placeholder=\"Passwort wiederholen\">
                            <input type=\"hidden\" name=\"sent\" value=\"1\">";
        }

        public function getTerms(){
            $this->html .= "<input type=\"checkbox\" id=\"checkTerms\" name=\"checkTerms\" class=\"form-control\" checked=\"checked\">
                             <div class=\"text-center\">
                               <label for=\"checkTerms\">
                               <a target=\"_blank\" style=\"color:#";$this->html .= \YAWK\settings::getSetting($db, "signup_toscolor");$this->html .= "\" href=\"";$this->html .= \YAWK\settings::getSetting($db, "signup_tospage");$this->html .= ".html\">";$this->html .= \YAWK\settings::getSetting($db, "signup_tostext"); $this->html .= "</a> akzeptieren</label>
                             </div>";
        }

        public function getAdditionalFields(){
            // get additional field settings from db
            $firstname = \YAWK\settings::getSetting($db, "signup_firstname");
            $lastname = \YAWK\settings::getSetting($db, "signup_lastname");
            $street = \YAWK\settings::getSetting($db, "signup_street");
            $zipcode = \YAWK\settings::getSetting($db, "signup_zipcode");
            $city = \YAWK\settings::getSetting($db, "signup_city");
            $country = \YAWK\settings::getSetting($db, "signup_country");
            // check if fields are required
            if ($firstname ==='1'){
                $this->html .= "<label for=\"firstname\">Vorname</label>
                            <input type=\"text\" id=\"firstname\" name=\"firstname\" class=\"form-control\" placeholder=\"Vorname\">";
            }
            if ($lastname ==='1'){
                $this->html .= "<label for=\"lastname\">Nachname</label>
                            <input type=\"text\" id=\"lastname\" name=\"lastname\" class=\"form-control\" placeholder=\"Nachname\">";
            }
            if ($street ==='1'){
                $this->html .= "<label for=\"street\">Stra&szlig;e</label>
                            <input type=\"text\" id=\"street\" name=\"street\" class=\"form-control\" placeholder=\"Stra&szlig;e\">";
            }
            if ($zipcode ==='1'){
                $this->html .= "<label for=\"zipcode\">Postleitzahl</label>
                            <input type=\"text\" id=\"zipcode\" name=\"zipcode\" class=\"form-control\" placeholder=\"Postleitzahl\">";
            }
            if ($city ==='1'){
                $this->html .= "<label for=\"city\">Stadt</label>
                            <input type=\"text\" id=\"city\" name=\"city\" class=\"form-control\" placeholder=\"Stadt\">";
            }
            if ($country ==='1'){
                $this->html .= "<label for=\"country\">Land</label>
                            <input type=\"text\" id=\"country\" name=\"country\" class=\"form-control\" placeholder=\"Land\">";
            }
        }

        public function getSubmitButton(){
            // get selected form layout (left, right, 1,2, or 3 cols...)
            $layout = \YAWK\settings::getSetting($db, "signup_layout");
            $btnStyle = \YAWK\settings::getSetting($db, "signup_submitstyle");
            $btnText = \YAWK\settings::getSetting($db, "signup_submittext");
            if ($layout === 'center' or $layout === 'plain'){
                $this->html .= "<div class=\"text-center\"><input type=\"submit\" class=\"btn btn-$btnStyle\" value=\"$btnText\"></div>";
            } else {
                $this->html .= "<br><input type=\"submit\" class=\"btn btn-$btnStyle\" value=\"$btnText\">";
            }
        }

    }
}
