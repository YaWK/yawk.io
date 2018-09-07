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
                    // \YAWK\user::drawLogoutBtn();
                    // user is logged in
                    echo "
                	Hallo <a href=\"welcome.html\" target=\"_self\"> ".$this->currentUser." </a>";
                    echo"!&nbsp;&nbsp;<a href=\"welcome.html\" target=\"_self\"><i class=\"glyphicon glyphicon-home\"></i></a>&nbsp;&nbsp;
		            <a href=\"".\YAWK\sys::getHost($db)."logout\" id=\"logoutBtn\" class=\"btn btn-danger active\" target=\"_self\">Logout</a>";
                }
                else
                    {   // user is not logged in, draw loginbox
                        echo \YAWK\user::drawLoginBox($this->currentUser, "");
                    }
            }
            else
                {
                    // no user is there, draw loginbox
                    echo \YAWK\user::drawLoginBox("", "");
                }
        }

    }
}
?>