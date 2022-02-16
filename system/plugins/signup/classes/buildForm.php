<?php
namespace YAWK\PLUGINS\SIGNUP {
    /**
     * <b>Class buildForm</b>
     * <p>serve all methods to draw the user signup form</p>
     * @author Daniel Retzl <danielretzl@gmail.com>
     * @version 1.0.0
     */
    class buildForm extends \YAWK\PLUGINS\SIGNUP\signup
    {
        /** * @param string html output */
        public $html = '';
        /** * @param string html form */
        public $form = '';

        /**
         * @brief initialize form (build it)
         * @param object $db database
         * @return string return html code
         */
        public function init($db){
            $this->form = $this->buildForm($db);
            return $this->html;
        }

        /**
         * @brief loads the header, layout and footer of the form
         * @param object $db database
         * @return string return html form
         */
        public function buildForm($db){
            $this->form .= $this->getHeader();
            $this->form .= $this->getLayout($db);
            $this->form .= $this->getFooter();
            return $this->form;
        }

        /**
         * @brief build the form
         * @param object $db database
         * @return string return html form
         */
        public function getForm($db){
            $this->form .= $this->getGroupSelect($db);
            $this->form .= $this->getMandatoryFields();
            $this->form .= $this->getAdditionalFields($db);
            $this->form .= $this->getTerms($db);
            $this->form .= $this->getSubmitButton($db);
            return $this->form;
        }

        /**
         * @brief get form header
         */
        public function getHeader()
        {
            // form header
            $this->html .= "<form id=\"form\" action=\"welcome.html\" method=\"POST\">";
        }

        /**
         * @brief get form title
         * @param object $db database
         */
        public function getTitle($db)
        {
            // form title
            $this->html .= \YAWK\settings::getSetting($db, "signup_title");
        }

        /**
         * @brief get form legend
         * @param object $db database
         */
        public function getLegend($db)
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

        /**
         * @brief build form on depending layout
         * @param object $db database
         */
        public function getLayout($db)
        {
            // get selected form layout (left, right, 1,2, or 3 cols...)
            $layout = \YAWK\settings::getSetting($db, "signup_layout");
            // layout row
            // switch case layout and load corresponding htmlcode
            switch ($layout) {
                case "left":
                    // form title
                    $this->html .= "<div class=\"col-md-6\">";
                    $this->html .= self::getLegend($db);
                    $this->html .= "</div>";
                    $this->html .= "<div class=\"col-md-6\">";
                    $this->html .= self::getTitle($db);
                    $this->html .= self::getForm($db);
                    $this->html .= "</div>";
                    break;
                case "right":
                    $this->html .= "<div class=\"col-md-6\">";
                    $this->html .= self::getTitle($db);
                    $this->html .= self::getForm($db);
                    $this->html .= "</div><div class=\"col-md-6\">";
                    $this->html .= self::getLegend($db);
                    $this->html .= "</div>";
                    break;
                case "plain":
                    $this->html .= "<div class=\"col-lg-12\">";
                    $this->html .= self::getTitle($db);
                    $this->html .= self::getForm($db);
                    $this->html .= "</div>";
                    break;
                case "center":
                    $this->html .= "<div class=\"col-md-4\">&nbsp;</div>";
                    $this->html .= "<div class=\"col-md-4\">";
                    $this->html .= self::getTitle($db);
                    $this->html .= self::getForm($db);
                    $this->html .= "</div>";
                    $this->html .= "<div class=\"col-md-4\">&nbsp;</div>";
                    break;
            }
        }

        /**
         * @brief html form footer (closing tag)
         */
        public function getFooter(){
            // form end
            $this->html .= "</form>";
        }

        /**
         * @brief get and return a select field with all groups as option values
         * @param object $db database
         */
        public function getGroupSelect($db)
        {   /** @var $db \YAWK\db */
            if (\YAWK\settings::getSetting($db, "signup_gid") === '1')
            {   // user group select field is allowed, fetch groups...
                if ($res = $db->query("SELECT * FROM {user_groups} WHERE signup_allowed = '1'"))
                {   // and build select field
                    $this->html.= "<label for=\"gid\">Signup as:</label>
                   <select id=\"gid\" name=\"gid\" class=\"form-control\">
                   <option value=\"\" disabled selected>please select</option>";
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

        /**
         * @brief draw html output: all mandatory fields
         */
        public function getMandatoryFields(){
            $this->html .= "<label for=\"username\">Username</label>
                            <input type=\"text\" id=\"username\" name=\"username\" class=\"form-control\" placeholder=\"Benutzername\">

                            <label for=\"email\">Email</label>
                            <input type=\"text\" id=\"email\" name=\"email\" class=\"form-control\" placeholder=\"your@email.com\">

                            <label for=\"password1\">Password</label>
                            <input type=\"password\" id=\"password1\" name=\"password1\" class=\"form-control\" placeholder=\"Passwort\">

                            <label for=\"password2\">Password (repeat)</label>
                            <input type=\"password\" id=\"password2\" name=\"password2\" class=\"form-control\" placeholder=\"Passwort wiederholen\">
                            <input type=\"hidden\" name=\"sent\" value=\"1\">";
        }

        /**
         * @brief draw html output: checkbox for terms of service
         * @param $db
         */
        public function getTerms($db){
            $this->html .= "<input type=\"checkbox\" id=\"checkTerms\" name=\"checkTerms\" class=\"form-control\" checked=\"checked\">
                             <div class=\"text-center\">
                               <label for=\"checkTerms\">
                               <a target=\"_blank\" style=\"color:#";$this->html .= \YAWK\settings::getSetting($db, "signup_toscolor");$this->html .= "\" href=\"";$this->html .= \YAWK\settings::getSetting($db, "signup_tospage");$this->html .= ".html\">";$this->html .= \YAWK\settings::getSetting($db, "signup_tostext"); $this->html .= "</a> akzeptieren</label>
                             </div>";
        }

        /**
         * @brief draw html output of all additional fields
         * @param object $db database
         */
        public function getAdditionalFields($db){
            // get additional field settings from db
            $firstname = \YAWK\settings::getSetting($db, "signup_firstname");
            $lastname = \YAWK\settings::getSetting($db, "signup_lastname");
            $street = \YAWK\settings::getSetting($db, "signup_street");
            $zipcode = \YAWK\settings::getSetting($db, "signup_zipcode");
            $city = \YAWK\settings::getSetting($db, "signup_city");
            $country = \YAWK\settings::getSetting($db, "signup_country");
            // check if fields are required
            if ($firstname ==='1'){
                $this->html .= "<label for=\"firstname\">Firstname</label>
                            <input type=\"text\" id=\"firstname\" name=\"firstname\" class=\"form-control\" placeholder=\"Vorname\">";
            }
            if ($lastname ==='1'){
                $this->html .= "<label for=\"lastname\">Lastname</label>
                            <input type=\"text\" id=\"lastname\" name=\"lastname\" class=\"form-control\" placeholder=\"Nachname\">";
            }
            if ($street ==='1'){
                $this->html .= "<label for=\"street\">Street</label>
                            <input type=\"text\" id=\"street\" name=\"street\" class=\"form-control\" placeholder=\"Stra&szlig;e\">";
            }
            if ($zipcode ==='1'){
                $this->html .= "<label for=\"zipcode\">ZIP Code</label>
                            <input type=\"text\" id=\"zipcode\" name=\"zipcode\" class=\"form-control\" placeholder=\"Postleitzahl\">";
            }
            if ($city ==='1'){
                $this->html .= "<label for=\"city\">City</label>
                            <input type=\"text\" id=\"city\" name=\"city\" class=\"form-control\" placeholder=\"Stadt\">";
            }
            if ($country ==='1'){
                $this->html .= "<label for=\"country\">Country</label>
                            <input type=\"text\" id=\"country\" name=\"country\" class=\"form-control\" placeholder=\"Land\">";
            }
        }

        /**
         * @brief draw the submit button
         * @param object $db database
         */
        public function getSubmitButton($db){
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
