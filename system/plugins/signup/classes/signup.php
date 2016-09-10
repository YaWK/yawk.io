<?php
/** Signup Class */
namespace YAWK\PLUGINS\SIGNUP {
    class signup
    {
        protected $username;
        public $userpage;
        protected $form;
        protected $html;
        protected $signup;

        function __construct() {
            $this->html = "";
            $this->form = "";
        }

        public function sayHello($db)
        {   /** @var $db \YAWK\db */
            // greets user and load welcome page for given role(gid)
            if (isset($_SESSION['username']) && isset($_SESSION['uid']))
            {
                if ($_SESSION['logged_in'] == true)
                {   // if login session var is true, set username
                    $this->username = $_SESSION['username'];
                    if (!isset($user))
                    {   // create new user object if it not exists
                        $user = new \YAWK\user();
                    }
                    // load properties for this user
                    $user->loadProperties($db, $this->username);
                    // check if user status in database is still logged in...
                    if ($user->isLoggedIn($db, $user->username))
                    {   // load userpage classes
                        include 'system/plugins/userpage/classes/userpage.php';
                        if (!isset($userpage))
                        {   // generate & return new userpage object
                            $userpage = new \YAWK\PLUGINS\USERPAGE\userpage();
                        }
                        // load userpage for given user
                        return $userpage->init($db, $user);
                    }
                    else
                    {   // user is not logged in
                        \YAWK\alert::draw("danger", "Error!", "Obviously you are not correctly logged in. Please re-login!","",5000);
                        return \YAWK\user::drawLoginBox("", "");
                    }
                }

                else
                {   // error detecting user login status, maybe because of expired cookies
                    $username = "";
                    $password = "";
                    \YAWK\alert::draw("danger", "Warning!", "Unable to get your login status. Please try to re-login!","",4200);
                    return \YAWK\user::drawLoginBox($username, $password);
                }
            }
            else
            {   // not logged in
                // load user signup function (form)
                return self::signUp($db);
            }
            \YAWK\alert::draw("danger", "Warning", "Something strange has happened.","", 2000);
            return false;
        }

        public static function signUp($db)
        {
            if (\YAWK\settings::getSetting($db, "signup_adultcheck") == '1')
            {
                echo"<script src=\"system/plugins/signup/js/adultCheck.js\"></script>";

                echo "<div id=\"adultCheck\" class=\"text-center\"><h2>Kennen wir uns bereits pers&ouml;nlich?</h2>
                        <h2><small id=\"yes\">Ja</small></h2>
                        <h2><small id=\"no\">Nein</small></h2></div>";

                echo "<div id=\"alt\" class=\"text-center\"><h2>M&ouml;chtest Du mich kennenlernen?</h2>
                        <h2><small id=\"contact\">Ja</small></h2>
                        <h2><small id=\"home\">Nein</small></h2></div>";
            }

            // include formbuilder class
            include 'system/plugins/signup/classes/buildForm.php';
            // generate new html form object
            $form = new \YAWK\PLUGINS\SIGNUP\buildForm();
            // draw form
            return $form->init();
        }
    }
}