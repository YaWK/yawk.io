<?php
namespace YAWK {
    /**
     * <b>backend Interface Helper Functions</b>
     *
     * This class serves a few useful functions for the admin backend.<br>
     *
     * <code><?php YAWK\backend::getTitle("title", "subtext"); ?></code>
     * Brings up the title on every page in admin panel.
     *
     * <code><?php YAWK\backend::setTimeout("index.php?pages=dashboard", "200"); ?></code>
     * Set a javascript redirection url and $wait time in ms before redirecting
     *
     * <code><?php YAWK\backend::setFocus("$field"); ?></code>
     * Set focus to any form input field on document ready.
     *
     * More backend helper functions may come in future releases.
     * <p><i>Class covers backend functionality.
     * See Methods Summary for Details!</i></p>
     *
     * @author     Daniel Retzl <danielretzl@gmail.com>
     * @copyright  2009-2015 Daniel Retzl yawk.io
     * @license    http://www.gnu.org/licenses/gpl-2.0  GNU/GPL 2.0
     * @link       http://yawk.io/
     * @annotation Backend class serves a few useful functions for the admin backend.
     */
    class backend
    {
        /**
         * Header title on top of every page
         * @param string $title Title to display
         * @param string $subtext Subtitle as small-tag beneath Title
         * @return string
         */
        static function getTitle($title, $subtext)
        {
            if ($title && $subtext) {
                $html = "<h1>" . $title . "&nbsp;<small>" . $subtext . "</small></h1>";
            } else {
                $html = "<h1>" . $title . "</h1>";
            }
            return $html;
        }

        /**
         * Set focus to any input field on pageload
         * @param string $field Name of the html input form element who should be focused.
         */
        static function setFocus($field)
        {
            print"<script type=\"text/javascript\" >
            $(document).ready(function() {
            $('#" . $field . "').focus(); });
            </script>";
        }

        /**
         * Do a javascript redirect to $location after given delay time ($wait) in ms
         * @param string $location url to redirect
         * @param string $wait Time to wait in ms before redirect
         */
        static function setTimeout($location, $wait)
        {
            print"<script type=\"text/javascript\">
            setTimeout(\"self.location.href='" . $location . "'\"," . $wait . ");
            </script>
            <noscript>
		 	 <h1>Your Browser needs activated javascript, to render the site correctly.<br>
		 	 <small>Please click <a href=\"$location\">here</a> to go ahead.</small></h1>
			</noscript>";
        }

        /**
         * Include Javascript FX to apply on #content-FX DOM element
         * @param object $db Database object
         * @param string $time FX time in milliseconds
         * @param string $type FX type
         */
        static function getFX($db, $time, $type)
        {
            // set defaults
            if (!$time) {
                $time = 820;
            }
            if (!$type) {
                $type = "fadeIn";
            }
            // are FX enabled?
            if (\YAWK\settings::getSetting($db, "backendFX") >= 1) {
                echo "
        <!-- optional backend FX on -->
        <script>$(\"#content-FX\").hide(0).delay(0)." . $type . "(" . $time . ")</script>";
            }
        }

        /**
         * Draw the AdminLTE Content Wrapper. Useful that view dont crash in situations where the DOM is not loaded or could not be loaded.
         * @return null
         */
        static function drawContentWrapper(){
            echo "
            <!-- Content Wrapper. Contains page content -->
            <div class=\"content-wrapper\" id=\"content-FX\">
            <!-- Content Header (Page header) -->
            <section class=\"content-header\">
            </section>
            <!-- Main content -->
            <section class=\"content\">";
            return null;
        }


        /**
         * Checks whether a user is allowed to login to backend or not. Logins will be stored.
         * @param object $db Database object
         * @return bool
         */
        static function checkLogin($db)
        {   /** @var $db \YAWK\db */
            /* check user login */
            $user = new \YAWK\user();
            if(isset($_POST['user']) && isset($_POST['password'])) {
                if($user->loginBackEnd($db, $_POST['user'],$_POST['password']))
                {   // create session var
                    $_SESSION['username'] = $_POST['user'];
                    $user->storeLogin($db, 0, "backend", $_POST['user'], $_POST['password']);
                    return true;
                }
                else
                {   // if username or pwd is wrong
                    $user->storeLogin($db, 1, "backend", $_POST['user'], $_POST['password']);
                    return false;
                }
            }
            else
            {   // username or password not set
                return false;
            }
        }


        /**
         * Draw a SELECT field with all templates, current active template is selected
         * @version 1.0.0
         * @author Daniel Retzl <danielretzl@gmail.com>
         * @website http://yawk.website
         * @param object $db Database object
         */
        public static function drawTemplateSelectField($db)
        {
            /* TEMPLATE SELECTOR */
            echo "<!-- TEMPLATE SELECT -->
                               <select class=\"form-control\" name=\"selectedTemplate\">
                                 <option value=\""; echo \YAWK\template::getCurrentTemplateId($db); echo "\">";
            echo \YAWK\template::getCurrentTemplateName($db, "backend", "");
            echo"</option>";
            /* foreach to fetch template select fields */
            foreach(\YAWK\template::getTemplateIds($db) as $template)
            {
                echo "<option value=\"".$template['id']."\"";
                if (isset($_POST['template'])) {
                    if($_POST['template'] === $template['id']){
                        echo "selected=\"selected\"";
                    }
                }
                echo ">".$template['name']."</option>";
            }
            echo"</select>";
        }


        /**
         * Draw a login form. If username and/or password was given, the form will be pre-filled with given values.
         * @param string $username The username
         * @param string $password The password
         * @return string Returns the complete html form.
         */
        static function drawLoginForm($username, $password)
        { /**
         * draw login box
         */
            if (!isset($username) || (empty($username)))
            {   // set default username: empty
                $username = "";
            }
            if (!isset($password) || (empty($password)))
            {   // set default username: empty
                $password = "";
            }
            $form = "<form role=\"form\" class=\"form-horizontal\" action=\"index.php\" method=\"post\">
            <input type=\"text\" class=\"form-control\" maxlength=\"128\" id=\"user\" value=\"".$username."\" name=\"user\" style=\"margin-bottom:4px;\" placeholder=\"Username\">
            <input type=\"password\" class=\"form-control\" id=\"password\" value=\"".$password."\" name=\"password\" placeholder=\"Password\"><br>
            <button type=\"submit\" class=\"btn btn-success\"><i class=\"fa fa-lock\"></i> &nbsp;Login</button>
            </form><br>";
            return $form;
        }

        /**
         * Draw a login box. Basically it wraps the drawLoginForm function with an AdminLTE box.
         * @param object $db Database object
         * @param string $title Box title
         * @param string $username The username
         * @param string $password The password
         * @return string Returns the complete html form
         */
        static function drawLoginBox($db, $title, $username, $password)
        { /**
         * draw login box
         */
            if (!isset($username) || (empty($username)))
            {   // set default username: empty
                $username = "";
            }
            if (!isset($password) || (empty($password)))
            {   // set default username: empty
                $password = "";
            }
            if (!isset($title) || (empty($title)))
            {   // set default username: empty
                $password = "Backend";
            }
            /* set focus on text field */
            \YAWK\backend::setFocus("user");
            /* get title and draw login box */
            $title = \YAWK\settings::getSetting($db, "title");
            // TEMPLATE WRAPPER - HEADER & breadcrumbs
            $loginBox = "
            <div class=\"row\" id=\"loginbox\"><br><br>
                    <div class=\"col-md-4\">&nbsp;</div>
                    <div class=\"col-md-4\">
                        <div class=\"box box-default\">
                            <div class=\"box-body\">
                            <h3>Login :: <small>" . $title . "</small></h3><br>";
                        $loginBox .= \YAWK\backend::drawLoginForm("","");
                        $loginBox .= "</div>
                        </div>
                        <br><br>
                    </div>
                    <div class=\"col-md-4\">&nbsp;</div>
                </div>";
            return $loginBox;
        }

        /**
         * Clever function to return the username. Expects the user object as param to work correctly.
         * @param object $user User object is required.
         * @return null|string Return the proper string or null.
         */
        static function getFullUsername($user)
        {
            if (empty($user->firstname))
            {
                $currentuser = $user->username;
            }
            if (empty($user->lastname))
            {
                $currentuser = $user->username;
            }
            if (!empty($user->firstname) && (empty($user->lastname)))
            {
                $currentuser = $user->firstname;
            }
            if (empty($user->firstname) && (!empty($user->lastname)))
            {
                $currentuser = $user->lastname;
            }
            if (!empty($user->firstname) && (!empty($user->lastname)))
            {
                $currentuser = "$user->firstname"."&nbsp;"."$user->lastname";
            }
            if (isset($currentuser))
            {
                return $currentuser;
            }
            else
            {
                return null;
            }
        }


        /**
         * Get pages and user groups into an array.
         * @param object $db Database object
         * @return array|string
         */
        public static function getPagesArray($db) // get all settings from db like property
        {
            /* @var $db \YAWK\db */
            if ($res = $db->query("SELECT cp.*, cg.value as gid FROM {pages} as cp
            JOIN {user_groups} as cg on cp.gid = cg.id ORDER BY id DESC")) {
                $pagesArray = array();
                while ($row = $res->fetch_assoc()){
                    $pagesArray[] = $row;
                }
                /* free result set */
                $res->close();
            }
            else {
                $pagesArray = '';
            echo   \YAWK\alert::draw("danger", "Error!", "Sorry, fetch database error: getPagesArray failed.","",4200);
            // die ("Sorry, fetch database error: getPagesArray failed.");
            }
            return $pagesArray;
        }

        /**
         * Get Menu id name and published into an array.
         * @param object $db Database object
         * @return array
         */
        static function getMenusArray($db)
        {
            /* @var $db \YAWK\db */
            if ($res = $db->query("SELECT id, name, published, (
                             SELECT COUNT(*)
                             FROM {menu}
                             WHERE menuID = {menu_names}.id
                             ) count FROM {menu_names}")) {
                $menusArray = array();
                while ($rows = $res->fetch_assoc()) {
                    $menusArray[] = $rows;
                }
                /* free result set */
                $res->close();
            } else {
                die ("Sorry, fetch database error: getMenus failed.");
            }
            return $menusArray;
        }

        static function getMenuNamesArray($db)
        {
            /* @var $db \YAWK\db */
            if ($res = $db->query("SELECT id, name FROM {menu_names} WHERE published = '1'"))
            {
                $menusArray = array();
                while ($rows = $res->fetch_assoc()) {
                    $menusArray[] = $rows;
                }
                /* free result set */
                $res->close();
            } else {
                die ("Sorry, fetch database error: getMenus failed.");
            }
            return $menusArray;
        }
    } /* END class::backend */
}