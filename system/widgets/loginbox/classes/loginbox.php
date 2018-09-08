<?php
namespace YAWK\WIDGETS\LOGINBOX\LOGIN
{
    /**
     * <b>Loginbox - draw a loginbox (or logout button)</b>
     *
     * <p>In case you need a user login form, use this widget. If the user is not logged in,
     * a form will be displayed, requesting username and password where users can login. In
     * case the user is already logged in, a hello {user}! message will be displayed, followed
     * by a logout button </p>
     *
     * @package    YAWK
     * @author     Daniel Retzl <danielretzl@gmail.com>
     * @copyright  2018 Daniel Retzl
     * @license    https://opensource.org/licenses/MIT
     * @version    1.0.0
     * @link       http://yawk.io
     * @annotation Loginbox Widget
     */
    class loginbox extends \YAWK\widget
    {
        /** @var object global widget object data */
        public $widget = '';
        /** @var string Title that will be shown above widget */
        public $loginboxHeading = '';
        /** @var string Subtext will be displayed beside title */
        public $loginboxSubtext = '';
        /** @var string Username */
        public $currentUser = '';
        /** @var string Login Button Text */
        public $loginboxLoginBtnText = "Login";
        /** @var string Logout Button Text */
        public $loginboxLogoutBtnText = "Logout";
        /** @var string Login Button CSS Class */
        public $loginboxLoginBtnClass = "btn btn-success";
        /** @var string Logout Button CSS Class */
        public $loginboxLogoutBtnClass = "btn btn-danger";
        /** @var string Login Button margin-top */
        public $loginboxLoginBtnMarginTop = "5px";
        /** @var string Login Button margin top css markup */
        public $loginboxLoginBtnMarginMarkup = '';
        /** @var string form width */
        public $loginboxWidth = '';
        /** @var string form width css markup */
        public $loginboxWidthMarkup = '';
        /** @var string form css class */
        public $loginboxFormClass = '';
        /** @var string form css class markup */
        public $loginboxFormClassMarkup = '';
        /** @var string ajax|html form processing mode */
        public $loginboxProcessingMode = 'html';
        /** @var string markup for html/ajax processing mode */
        public $loginboxProcessingModeFormMarkup = '';
        /** @var string submit button type, depending on processing mode */
        public $loginboxProcessingModeSubmitBtnType = 'submit';

        /**
         * Load all widget settings from database and fill object
         * @author Daniel Retzl <danielretzl@gmail.com>
         * @version 1.0.0
         * @link http://yawk.io
         * @param object $db Database Object
         * @annotation Load all widget settings on object init.
         */
        public function __construct($db)
        {
            // load this widget settings from db
            $this->widget = new \YAWK\widget();
            $settings = $this->widget->getWidgetSettingsArray($db);
            foreach ($settings as $property => $value) {
                $this->$property = $value;
            }
        }

        /**
         * Init loginbox widget and call a function for demo purpose
         * @author Daniel Retzl <danielretzl@gmail.com>
         * @version 1.0.0
         * @link http://yawk.io
         * @annotation loginbox Widget Init
         */
        public function init($db)
        {
            // draw heading above loginbox
            echo $this->getHeading($this->loginboxHeading, $this->loginboxSubtext);

            // check if a user is there
            if ($this->currentUser = \YAWK\user::isAnybodyThere($db))
            {   // check if currentUser is logged in
                if (\YAWK\user::isLoggedIn($db, $this->currentUser))
                {
                    // user is logged in...
                    $this->drawLogoutButton($db);
                }
                else
                    {   // user is not logged in, draw loginbox
                        $this->drawLoginBox($db, $this->currentUser, "");
                    }
            }
            else
                {   // no user is there, draw loginbox
                    $this->drawLoginBox($db, "", "");
                }
        }

        /**
         * Prepare Loginbox form settings
         * @author Daniel Retzl <danielretzl@gmail.com>
         * @version 1.0.0
         * @link http://yawk.io
         * @annotation Evaluate loginbox settings and prepare html markup
         */
        public function setProperties()
        {
            /** MARGIN TOP */
            // check if loginbox button margin top is set and not empty
            if (isset($this->loginboxLoginBtnMarginTop) && (!empty($this->loginboxLoginBtnMarginTop)))
            {   // check last 2 chars of string to see if user missed px afterwards
                if (substr($this->loginboxLoginBtnMarginTop, -2) != "px")
                {   // append px to value
                    $this->loginboxLoginBtnMarginTop = $this->loginboxLoginBtnMarginTop."px";
                }
                // generate css style markup
                $this->loginboxLoginBtnMarginMarkup = " style=\"margin-top:$this->loginboxLoginBtnMarginTop;\"";
            }
            else
            {   // no markup required
                $this->loginboxLoginBtnMarginMarkup = '';
            }

            /** FORM WIDTH */
            // check if form width is set and not empty
            if (isset($this->loginboxWidth) && (!empty($this->loginboxWidth)))
            {
                // check last char of string to see if user missed % sign
                if (substr($this->loginboxWidth, -1) != "%")
                {   // append percent sign
                    $this->loginboxWidth = $this->loginboxWidth."%";
                }
                // generate css style markup
                $this->loginboxWidthMarkup = " style=\"width:$this->loginboxWidth;\"";

                // check if width is set to 100%
                if ($this->loginboxWidth === "100%" || $this->loginboxWidth === "100" || ($this->loginboxWidth === "0"))
                {   // default behaviour, no markup needed
                    $this->loginboxWidthMarkup = '';
                }
            }
            else
            {   // no markup required
                $this->loginboxWidthMarkup = '';
            }

            /** FORM CLASS */
            // check form class
            if (isset($this->loginboxFormClass) && (!empty($this->loginboxFormClass)))
            {
                // generate form class markup
                $this->loginboxFormClassMarkup = " class=\"$this->loginboxFormClass\"";
            }
            else
            {   // no markup required
                $this->loginboxFormClassMarkup = '';
            }

            /** FORM PROCESSING MODE */
            // check form processing mode (ajax or html)
            if (isset($this->loginboxProcessingMode) && (!empty($this->loginboxProcessingMode)))
            {   // if form processing is html
                if ($this->loginboxProcessingMode === "html")
                {   // set form markup html action....
                    $this->loginboxProcessingModeFormMarkup = " action=\"index.html\" ";
                    $this->loginboxProcessingModeSubmitBtnType = "submit";
                }
                else
                {   // ajax request - load required js files
                    $this->includeJS();
                    // no additional form markup required
                    $this->loginboxProcessingModeFormMarkup = "";
                    // set submit btn type to prevent 'traditional' submit behavior
                    $this->loginboxProcessingModeSubmitBtnType = "button";
                }
            }
        }

        /**
         * Load required javascript file
         * @author Daniel Retzl <danielretzl@gmail.com>
         * @version 1.0.0
         * @link http://yawk.io
         * @annotation include required ajax js file
         */
        public function includeJS()
        {
            // load notify js
            echo "<script type=\"text/javascript\" src=\"system/engines/jquery/notify/bootstrap-notify.min.js\"></script>";
            echo "<link rel=\"stylesheet\" href=\"system/engines/jquery/notify/bootstrap-notify.min.css\">";
            // load validate js
            echo "<script type=\"text/javascript\" src=\"system/engines/jquery/jquery.validate.min.js\"></script>";
            // if current language is german
            if (\YAWK\language::getCurrentLanguageStatic() == "de-DE")
            {   // load german language file
                echo "<script type=\"text/javascript\" src=\"system/engines/jquery/messages_de.min.js\"></script>";
            }
            // load ajax file
            echo "<script type=\"text/javascript\" src=\"system/widgets/loginbox/js/loginbox.ajax.js\"></script>";
        }

        /**
         * returns the login box html markup
         * @author Daniel Retzl <danielretzl@gmail.com>
         * @version 1.0.0
         * @link http://yawk.io
         * @param object $db database object
         * @param string $username username, as option
         * @param string $password password, as option
         */
        public function drawLoginBox($db, $username, $password)
        {
            // first of all: get settings for this loginbox
            $this->setProperties();

            // output the loginbox form itself
            echo "
            <form name=\"login\"$this->loginboxProcessingModeFormMarkup$this->loginboxFormClassMarkup id=\"loginForm\" role=\"form\" method=\"POST\"$this->loginboxWidthMarkup>
                <input type=\"text\" id=\"user\" name=\"user\" value=\"".$username."\" class=\"form-control\" placeholder=\"Benutzername\">
                <input type=\"password\" id=\"password\" name=\"password\" value=\"".$password."\" class=\"form-control\" placeholder=\"Passwort\">
                <input type=\"hidden\" name=\"login\" value=\"login\">
                <input type=\"$this->loginboxProcessingModeSubmitBtnType\" name=\"submit\" id=\"submit\" class=\"$this->loginboxLoginBtnClass\" value=\"$this->loginboxLoginBtnText\"$this->loginboxLoginBtnMarginMarkup> 
            </form>
            <div id=\"thankYouMessage\"></div>";

        }

        /**
         * returns the logout btn html markup
         * @author Daniel Retzl <danielretzl@gmail.com>
         * @version 1.0.0
         * @link http://yawk.io
         */
        public function drawLogoutButton($db)
        {
            echo "<div id=\"logoutBtnWrapper\">Hallo <a href=\"welcome.html\" target=\"_self\"> ".$this->currentUser." </a>!&nbsp;&nbsp;
                    <a href=\"welcome.html\" target=\"_self\"><i class=\"glyphicon glyphicon-home\"></i></a>&nbsp;&nbsp;
		            <a href=\"".\YAWK\sys::getHost($db)."logout\" id=\"logoutBtn\" class=\"$this->loginboxLogoutBtnClass\" target=\"_self\">Logout</a></div>";
        }

    }
}
?>