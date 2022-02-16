<?php
/** Signup Class */
namespace YAWK\PLUGINS\SIGNUP {
    /**
     * <b>Let users signup to your website.</b>
     * <p>Allow your users to register and login to your website. You can choose, which group they
     * belong, or let them choose between a pre-defined list of groups for maximum flexibility.</p>
     * <p><i>This class covers frontend functionality. See Methods Summary for Details!</i></p>
     *
     * @author     Daniel Retzl <danielretzl@gmail.com>
     * @version    1.0.0
     * @brief Handles the Blog System.
     */
    class signup
    {
        /** * @param string username */
        protected $username;
        /** * @param string userpage */
        public $userpage;
        /** * @param string form */
        protected $form;
        /** * @param string html */
        protected $html;
        /** * @param string signup */
        protected $signup;

        /**
         * @brief signup constructor.
         */
        function __construct() {
            $this->html = "";
            $this->form = "";
        }

        /**
         * @brief check if the user is logged in and load userpage on demand
         * @param object $db database
         * @param array $lang language array
         * @return bool|null|string
         */
        public function sayHello($db, $lang)
        {   /** @var $db \YAWK\db */
            // greets user and load welcome page for given role(gid)
            if (\YAWK\user::isAnybodyThere($db))
            {   // load userpage for signed in user
                // if login session var is true, set username
                $this->username = $_SESSION['username'];
                if (!isset($user))
                {   // create new user object if it not exists
                    $user = new \YAWK\user($db);
                }
                // load properties for this user
                $user->loadProperties($db, $this->username);
                // check if user status in database is still logged in...
                if ($user->isLoggedIn($db, $user->username))
                {   // load userpage classes
                    require_once 'system/plugins/userpage/classes/userpage.php';
                    if (!isset($userpage))
                    {   // generate & return new userpage object
                        $userpage = new \YAWK\PLUGINS\USERPAGE\userpage($db, $user);
                    }
                    // load userpage for given user
                    return $userpage->init($db, $user, $lang);
                }
                else
                {   // user is not logged in
                    \YAWK\alert::draw("danger", "Error!", "Obviously you are not correctly logged in. Please re-login!","",5000);
                    return \YAWK\user::drawLoginBox("", "");
                }
            }
            else
                {   // not logged in
                    // load user signup function (form)
                    return self::signUp($db);
                }
        }

        /**
         * @brief draw html output adultcheck or form on demand
         * @param object $db database
         * @return string return html form
         */
        public static function signUp($db)
        {
            if (\YAWK\settings::getSetting($db, "signup_adultcheck") == '1')
            {
                echo"<script src=\"system/plugins/signup/js/adultCheck.js\"></script>";

                echo "<div id=\"adultCheck\" class=\"text-center\"><h2>Are you over 18 years old?</h2>
                        <h2><small id=\"yes\">yes</small></h2>
                        <h2><small id=\"no\">no</small></h2></div>";

                echo "<div id=\"alt\" class=\"text-center\"><h2>Are you an adult, depending on the age of your country laws?</h2>
                        <h2><small id=\"contact\">Yes</small></h2>
                        <h2><small id=\"home\">No</small></h2></div>";
            }

            // include formbuilder class
            include 'system/plugins/signup/classes/buildForm.php';
            // generate new html form object
            $form = new \YAWK\PLUGINS\SIGNUP\buildForm($db);
            // draw form
            return $form->init($db);
        }
    }
}