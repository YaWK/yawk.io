<?php
namespace YAWK {
    /**
     * @details <b>backend Interface Helper Functions</b>
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
     * @license    https://opensource.org/licenses/MIT/
     * @brief Backend class serves a few useful functions for the admin backend.
     */
    class backend
    {

        /**
         * @brief Return breadcrumbs for settings pages
         * @param array $lang Language Array
         * @return string html code
         */
        static function getSettingsBreadcrumbs($lang)
        {
            return "<ol class=\"breadcrumb\">
            <li><i class=\"fa fa-globe\"></i> &nbsp;<a href=\"index.php?page=settings-frontend\" title=\"$lang[EDIT]\"> $lang[FRONTEND]</a></li>
            <li><i class=\"fa fa-sign-in\"></i> &nbsp;<a href=\"index.php?page=settings-backend\" title=\"$lang[EDIT]\"> $lang[BACKEND]</a></li>
            <li><i class=\"fa fa-cogs\"></i> &nbsp;<a href=\"index.php?page=settings-system\" title=\"$lang[EDIT]\"> $lang[SYSTEM]</a></li>
            <li><i class=\"fa fa-envelope-o\"></i> &nbsp;<a href=\"index.php?page=settings-webmail\" title=\"$lang[WEBMAIL]\"> $lang[WEBMAIL]</a></li>
            <li><i class=\"fa fa-language\"></i> &nbsp;<a href=\"index.php?page=settings-language\" title=\"$lang[EDIT]\"> $lang[LANGUAGES]</a></li>
            <li><i class=\"fa fa-android\"></i> &nbsp;<a href=\"index.php?page=settings-robots\" title=\"$lang[EDIT]\"> $lang[ROBOTS_TXT]</a></li>
            <li><i class=\"fa fa-puzzle-piece\"></i> &nbsp;<a href=\"index.php?page=settings-assets\" title=\"$lang[EDIT]\"> $lang[ASSETS]</a></li>
            <li><i class=\"fa fa-font\"></i> &nbsp;<a href=\"index.php?page=settings-fonts\" title=\"$lang[EDIT]\"> $lang[FONTS]</a></li>
            <li><i class=\"fa fa-database\"></i> &nbsp;<a href=\"index.php?page=settings-database\" title=\"$lang[EDIT]\"> $lang[DATABASE]</a></li>
            <li><i class=\"fa fa-info-circle\"></i> &nbsp;<a href=\"index.php?page=settings-systeminfo\" title=\"$lang[EDIT]\"> $lang[SYSTEM] $lang[INFO]</a></li>
        </ol></section>";
        }

        /**
         * @brief Return breadcrumbs for template pages
         * @param array $lang Language Array
         * @return string html code
         */
        static function getTemplateBreadcrumbs($lang)
        {
            // <li><i class=\"fa fa-tint\"></i> &nbsp;<a href=\"index.php?page=template-theme\" title=\"$lang[EDIT]\"> $lang[THEME]</a></li>

            return "<ol class=\"breadcrumb\">
            <li><i class=\"fa fa-home\"></i> &nbsp;<a href=\"index.php?page=template-overview\" title=\"$lang[EDIT]\"> $lang[OVERVIEW]</a></li>
            <li><i class=\"fa fa-cube\"></i> &nbsp;<a href=\"index.php?page=template-positions\" title=\"$lang[EDIT]\"> $lang[POSITIONS]</a></li>
            <li><i class=\"fa fa-paint-brush\"></i> &nbsp;<a href=\"index.php?page=template-redesign\" title=\"$lang[EDIT]\"> $lang[DESIGN]</a></li>
            <li><i class=\"fa fa-text-height\"></i> &nbsp;<a href=\"index.php?page=template-typography\" title=\"$lang[EDIT]\"> $lang[TYPOGRAPHY]</a></li>
            <li><i class=\"fa fa-css3\"></i> &nbsp;<a href=\"index.php?page=template-customcss\" title=\"$lang[EDIT]\"> $lang[CUSTOM_CSS]</a></li>
            <li><i class=\"fa fa-code\"></i> &nbsp;<a href=\"index.php?page=template-customjs\" title=\"$lang[EDIT]\"> $lang[CUSTOM_JS]</a></li>
            <li><i class=\"fa fa-puzzle-piece\"></i> &nbsp;<a href=\"index.php?page=template-assets\" title=\"$lang[EDIT]\"> $lang[ASSETS]</a></li>
            <li><i class=\"fa fa-eye\"></i> &nbsp;<a href=\"index.php?page=template-preview\" title=\"$lang[WEBSITE] $lang[PREVIEW]\"> $lang[PREVIEW]</a></li>
        </ol></section>";
        }



        /**
         * @brief Header title on top of every page
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
         * @brief Set focus to any input field on pageload
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
         * @brief Include Javascript FX to apply on #content-FX DOM element
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
         * @brief Draw the AdminLTE Content Wrapper. Useful that view dont crash in situations where the DOM is not loaded or could not be loaded.
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
         * @brief Checks whether a user is allowed to login to backend or not. Logins will be stored.
         * @param object $db Database object
         * @return bool
         */
        static function checkLogin($db)
        {   /** @var $db \YAWK\db */
            /* check user login */
            $user = new \YAWK\user($db);
            if(isset($_POST['user']) && isset($_POST['password'])) {
                if($user->loginBackEnd($db, $_POST['user'],$_POST['password']))
                {   // create session var
                    $_SESSION['username'] = $_POST['user'];
                    $_SESSION['passwordFail'] = 0;
                    $user->storeLogin($db, 0, "backend", $_POST['user'], $_POST['password']);
                    return true;
                }
                else
                {   // if username or pwd is wrong
                    if (isset($_SESSION['passwordFail']))
                    {   // add password fail counter
                        $_SESSION['passwordFail']++;
                    }
                    else
                    {   // first wrong try
                        $_SESSION['passwordFail'] = 1;
                    }
                    // log this user login / store @ login db table
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
         * @brief Draw a SELECT field with all templates, current active template is selected
         * @version 1.0.0
         * @author Daniel Retzl <danielretzl@gmail.com>
         * @website http://yawk.website
         * @param object $db Database object
         */
        public static function drawTemplateSelectField($db, $description)
        {
            /* TEMPLATE SELECTOR */
            echo "<!-- TEMPLATE SELECT -->
                               <select class=\"form-control\" id=\"selectedTemplate\" name=\"selectedTemplate\">
                               <label for id=\"selectedTemplate\">$description</label>
                                 <option value=\""; echo \YAWK\template::getCurrentTemplateId($db); echo "\">";
            echo \YAWK\template::getCurrentTemplateName($db, "backend", 0);
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
         * @brief Draw a login form. If username and/or password was given, the form will be pre-filled with given values.
         * @param string $username The username
         * @param string $password The password
         * @return string Returns the complete html form.
         */
        static function drawLoginForm($username, $password, $lang)
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
            if (isset($_SESSION['passwordFail']) && ($_SESSION['passwordFail'] > 1))
            {
                // password wrong after user's 2nd try - display reset button
                $resetBtn = "<a class=\"btn btn-danger\" data-toggle=\"modal\" data-target=\"#myModal\"><i class=\"fa fa-question-circle\"></i> &nbsp;$lang[PASSWORD_FORGOTTEN]</a>";
            }
            else
            {   // password not wrong - no button needed
                $resetBtn = "&nbsp;";
            }

            // check if any page is requested
            if (isset($_GET['page']) && (!empty($_GET['page'])))
            {   // set redirect
                $redirect = "?page=".$_GET['page']."";
            }
            else
            {   // redirect requested
                $redirect = '';
            }

            $form = "<form role=\"form\" class=\"form-horizontal\" action=\"index.php".$redirect."\" method=\"post\">
            <input type=\"text\" class=\"form-control\" maxlength=\"128\" id=\"user\" value=\"".$username."\" name=\"user\" style=\"margin-bottom:4px;\" placeholder=\"Username\">
            <input type=\"password\" class=\"form-control\" id=\"password\" value=\"".$password."\" name=\"password\" placeholder=\"Password\"><br>
            <button type=\"submit\" class=\"btn btn-success\"><i class=\"fa fa-lock\"></i> &nbsp;".$lang['LOGIN']."</button>
            &nbsp;&nbsp;".$resetBtn."
            </form>";
            return $form;
        }

        /**
         * @brief Draw a login box. Basically it wraps the drawLoginForm function with an AdminLTE box.
         * @param object $db Database object
         * @param string $title Box title
         * @param string $username The username
         * @param string $password The password
         * @return string Returns the complete html form
         */
        static function drawLoginBox($db, $lang)
        { /**
         * draw login box
         */
            /* set focus on text field */
            \YAWK\backend::setFocus("user");
            /* get title and draw login box */
            $title = \YAWK\settings::getSetting($db, "title");
            $modalWindow = " <!-- Modal -->
              <form method=\"POST\" action=\"index.php\">
              <div class=\"modal fade\" id=\"myModal\" role=\"dialog\">
                <div class=\"modal-dialog\">
                
                  <!-- Modal content-->
                  <div class=\"modal-content\">
                    <div class=\"modal-header\">
                      <button type=\"button\" class=\"close\" data-dismiss=\"modal\">&times;</button>
                      <h4 class=\"modal-title\">$lang[PASSWORD_RESET]</h4>
                    </div>
                    <div class=\"modal-body\">
                      <label for=\"email\">$lang[EMAIL]</label>
                      <input type=\"text\" class=\"form-control\" id=\"email\" name=\"email\" placeholder=\"$lang[PASSWORD_RESET_HOWTO]\">
                      <div class=\"text-center\"><br><i>$lang[OR]</i><br></div>
                      <label for=\"username\">$lang[USERNAME]</label>
                      <input type=\"text\" class=\"form-control\" id=\"username\" name=\"username\" placeholder=\"$lang[USERNAME]\">
                      <input type=\"hidden\" name=\"resetPasswordRequest\" id=\"resetPasswordRequest\" value=\"true\">
                    </div>
                    <div class=\"modal-footer\">
                      <button type=\"submit\" class=\"btn btn-success\"><i class=\"fa fa-check\"></i> &nbsp;$lang[PASSWORD_RESET]</button>
                      <button type=\"button\" class=\"btn btn-default\" data-dismiss=\"modal\"><i class=\"fa fa-times\"></i>&nbsp; $lang[CANCEL]</button>
                      <hr>";
            $ip = $_SERVER['REMOTE_ADDR'];
            $hostname = gethostname();
            $network = gethostbyaddr($_SERVER['REMOTE_ADDR']);
            $modalWindow .= "<div class=\"text-left small\"><i><small>Access from IP: $ip @ $hostname from network: $network will be logged.</small></i></div>
                    </div>
                  </div>
                  
                </div>
              </div>
              </form>";
            // TEMPLATE WRAPPER - HEADER & breadcrumbs
            $loginBox = "
            <div class=\"row\" id=\"loginbox\"><br><br>
                    <div class=\"col-md-4\">&nbsp;</div>
                    <div class=\"col-md-4\">
                        <div class=\"box box-default\">
                            <div class=\"box-body\">
                            <h3>Login :: <small>" . $title . "</small></h3><br>";
            $loginBox .= \YAWK\backend::drawLoginForm("","", $lang);
            $loginBox .= "
                        </div>
                        <br><br>
                    </div>
                    <div class=\"col-md-4\">&nbsp;</div>
                </div>";
            return $modalWindow.$loginBox;
        }

        /**
         * @brief Clever function to return the username. Expects the user object as param to work correctly.
         * @param object $user User object is required.
         * @return null|string Return the proper string or null.
         */
        static function getFullUsername($user)
        {
            if (empty($user->firstname))
            {
                $currentUser = $user->username;
            }
            if (empty($user->lastname))
            {
                $currentUser = $user->username;
            }
            if (!empty($user->firstname) && (empty($user->lastname)))
            {
                $currentUser = $user->firstname;
            }
            if (empty($user->firstname) && (!empty($user->lastname)))
            {
                $currentUser = $user->lastname;
            }
            if (!empty($user->firstname) && (!empty($user->lastname)))
            {
                $currentUser = "$user->firstname"."&nbsp;"."$user->lastname";
            }
            if (isset($currentUser))
            {
                return $currentUser;
            }
            else
            {
                return null;
            }
        }


        /**
         * @brief Get pages and user groups into an array.
         * @param object $db Database object
         * @return array|string
         */
        public static function getPagesArray($db) // get all settings from db like property
        {
            /* @param $db \YAWK\db */
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
         * @brief Get Menu id name and published into an array.
         * @param object $db Database object
         * @return array
         */
        static function getMenusArray($db)
        {
            /* @param $db \YAWK\db */
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

        /**
         * @brief return all menu ids and names as array
         * @param $db
         * @return array
         */
        static function getMenuNamesArray($db)
        {
            /* @param $db \YAWK\db */
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

        /**
         * @brief Draw a list with all fonts. Expects fonts as array
         * @param array $fontArray array with font names
         * @param string $folder the folder where fonts are stored
         * @param array $lang language array
         */
        static function drawFontList($fontArray, $folder, $type, $lang)
        {
            // we need to check if its a custom font (ttf, otf, woff) or google font.
            // this determination is needed to flag the delete link - this ensures that
            // the delete function knows if it's a file to delete or an entry from the database.
            if ($type === "Google" || ($type === "google"))
            {   // flag get param as google font
                $flag = "&type=google";
            }
            else
            {   // font type unknown
                $flag = "&type=custom";
            }
            // folder is empty...
            if (!isset($folder) || (empty($folder)))
            {   // default folder
                $folder = '../system/fonts/';
            }
            // if array is empty - no fonts were found
            if (empty($fontArray))
            {   // throw a message
                echo $lang['FONTS_NOT_FOUND'];
                echo "<a href=\"#\" id=\"addFontBtn\" data-toggle=\"modal\" data-target=\"#myModal\" 
                         style=\"margin-top:2px;\"><i><small>&nbsp;&nbsp;&raquo; ".$lang['ADD']."</small></i></a>";
            }
            else
            {   // walk through folder
                foreach ($fontArray as $font)
                {   // draw list with fonts, delete and download icon
                    echo "<!-- draw font -->
                    <h4 style=\"font-family:'$font';\">$font<small>                    
                    <!-- delete font icon -->
                    <a role=\"dialog\" data-confirm=\"$lang[FONT] &laquo; ".$font." &raquo; $lang[DELETE_CONFIRM]\" 
                    title=\"".$lang['FONT_DEL']."\" href=\"index.php?page=settings-fonts&delete=true$flag&font=$font\">
                    <i class=\"fa fa-trash-o pull-right\" data-toggle=\"tooltip\" title=\"$lang[DELETE]\" style=\"margin-top:4px;\"></i></a>&nbsp;";

                    // if google fonts get drawn...
                    if ($type === "Google" || ($type === "google"))
                    {
                        // no download icon
                    }
                    else
                    {   // download font icon
                        echo "<a href=\"$folder$font\" title=\"$lang[DOWNLOAD] $font\"><i class=\"fa fa-arrow-circle-o-down pull-right\" 
                            data-toggle=\"tooltip\" title=\"$lang[TO_DOWNLOAD]\" style=\"margin-top:4px;\"></i></a>&nbsp;&nbsp;";
                    }
                    // close tags
                    echo "</small></h4><hr>";
                }
            }
        }


        /**
         * @brief Draw a box containing all widgets that are linked with given page.
         * Every Widget gets drawn as small bubble/button and is linked with the
         * corresponding Widget-edit page. This increased the workflow while editing
         * a page and their widgets.
         * @param object $db Database handle
         * @param object $page current page object
         * @param array $lang language array
         */
        static function drawWidgetsOnPageBox($db, $page, $lang)
        {
            // get widget list from database
            $widgetList = widget::loadWidgetsOfPage($db, $page);


            // Draw a list of widgets, what are bound to this given page->id
            echo'<!-- WIDGET OVERVIEW -->
                <div class="box box-default">
                  <div class="box-header with-border">
                      <h3 class="box-title"><i class="fa fa-tags"></i>&nbsp;&nbsp;'.$lang["WIDGETS"].' <small>'.$lang["WIDGETS_ON_THIS_PAGE"].'</small></h3>
                      <!-- box-tools -->
                      <div class="box-tools pull-right">
                          <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                          </button>
                      </div>
                  <!-- /.box-tools -->
                  </div>
                  <div class="box-body" style="display: block;">';
            if (isset($widgetList) && (is_array($widgetList)))
            {
                // loop through all found widgets
                foreach ($widgetList as $widget)
                {
                    // set color of widget depending on published state
                    if ($widget['published'] == 1){ $wTextColor = 'default'; } else { $wTextColor = 'danger'; }

                    // set widget info tag
                    if ($widget['pageID'] == 0){ $wPageInfo = 'all'; } else { $wPageInfo = 'this'; }

                    // draw widget bubble
                    echo '<p style="float:left; margin-right:5px;"><a href="index.php?page=widget-edit&widget='.$widget['id'].'" class="btn btn-xs btn-'.$wTextColor.'" title="'.$lang['EDIT'].': '.$widget['name'].' '.$lang['WIDGET'].'">
                        '.$widget['name'].' @<small> '.$wPageInfo.' | '.$widget['position'].'</small></a></p>';
                }
            }
            else {
                echo'<p>'.$lang['NO_WIDGET_CREATED'].' <small><i>(<a href="index.php?page=widget-new">'.$lang['CREATE'].'</a>)</small></p>';
            }
            echo'</div>
                </div>';

        } // eof drawWidgetsOnPageBox

        /**
         * @brief Draw a small question mark, enabling a tooltip on hover.
         * toolTipText must be a string and will usually come from any language file.
         * @param string $toolTipText text that will appear as tooltip on mouseover
         */
        public static function printTooltip($toolTipText)
        {
            if (!empty($toolTipText))
            {   // print out toolTip markup
                echo '<small><i class="fa fa-question-circle-o text-info" data-placement="auto right" data-toggle="tooltip" title="'.$toolTipText.'"></i></small>';
            }
            else {
                echo '<small><i class="fa fa-question-circle-o text-info" data-placement="auto right" data-toggle="tooltip" title="Tooltip fehlt leider :("></i></small>';
            }
        }

    } /* END class::backend */
}