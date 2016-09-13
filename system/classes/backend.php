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
     * @category   CMS
     * @package    System
     * @global     $connection
     * @global     $dbprefix
     * @author     Daniel Retzl <danielretzl@gmail.com>
     * @copyright  2009-2015 Daniel Retzl yawk.goodconnect.net
     * @license    http://www.gnu.org/licenses/gpl-2.0  GNU/GPL 2.0
     * @version    1.1.3
     * @link       http://yawk.goodconnect.net/
     * @since      File available since Release 0.0.9
     * @annotation Backend class serves a few useful functions for the admin backend.
     */
    class backend
    {
        /* header title on top of every page */
        static function getTitle($title, $subtext)
        {
            if ($title && $subtext) {
                $html = "<h1>" . $title . "&nbsp;<small>" . $subtext . "</small></h1>";
            } else {
                $html = "<h1>" . $title . "</h1>";
            }
            return $html;
        }

        static function setFocus($field)
        {
            /**
             * setFocus :: textfield focus on pageload
             */
            print"<script type=\"text/javascript\" >
          $(document).ready(function() {
          $('#" . $field . "').focus(); });
          </script>";
        }

        static function setTimeout($location, $wait)
        {
            /**
             * setTimeout force page reload via JS
             */
            print"<script type=\"text/javascript\">
            setTimeout(\"self.location.href='" . $location . "'\"," . $wait . ");
            </script>
            <noscript>
		 	 <h1>Your Browser needs activated javascript, to render the site correctly.<br>
		 	 <small>Please click <a href=\"$location\">here</a> to go ahead.</small></h1>
			</noscript>";
        }

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

        static function drawHtmlFooter()
        {   $currentYear = date("Y");
            echo "</div></section>
            <!-- Main Footer -->
            <footer class=\"main-footer\">
              <!-- To the right -->
                <div class=\"pull-right hidden-xs\">
                  <small>Yet another Web Kit 1.0</small>
                </div>
                <!-- Default to the left -->
                <strong>Copyright &copy; 2009-$currentYear <a href=\"#\">YaWK CMS</a>.</strong> All rights reserved.";
            echo "</footer></div></section>";
            return null;
        }

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
            <div class=\"row\"><br><br>
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
         * @param $property
         * @return array
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
         * @param $property
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
    } /* END class::backend */
}