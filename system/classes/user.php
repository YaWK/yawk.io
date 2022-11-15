<?php
namespace YAWK {
    /**
     * @details The default user class. Provide all functions to handle the user object.
     *
     * All functions that are required to handle a user. Methods are: add, edit, delete, checklogin and many more.
     * <p><i>Class covers both, backend & frontend functionality.
     * See Methods Summary for Details!</i></p>
     *
     * @author     Daniel Retzl <danielretzl@gmail.com>
     * @copyright  2009-2015 Daniel Retzl
     * @license    https://opensource.org/licenses/MIT
     * @brief The default user class. Provide all functions to handle the user object.
     */

    class user
    {
        /** * @param string current user name */
        public $currentuser;
        /** * @param string username */
        public $username;
        /** * @param int 0|1 if 1, user is blocked and cannot login anymore */
        public $blocked;
        /** * @param int user ID */
        public $id;
        /** * @param int 0|1 if 1, user is published (active) */
        public $published;
        /** * @param int 0|1 if 1, user privacy needs to be respected */
        public $privacy;
        /** * @param int 0|1 if 1, user is currently online (or at least: not logged out) */
        public $online;
        /** * @param int group ID */
        public $gid;
        /** * @param string user password */
        public $password;
        /** * @param string datetime when user was created */
        public $date_created;
        /** * @param string datetime when user has changed */
        public $date_changed;
        /** * @param string datetime when user has last logged in */
        public $date_lastlogin;
        /** * @param string datetime when user account is about to expire */
        public $date_expired;
        /** * @param int how many times the user have logged in */
        public $login_count;
        /** * @param string user email address*/
        public $email;
        /** * @param string user URL */
        public $url;
        /** * @param string user twitter url */
        public $twitter;
        /** * @param string user facebook url */
        public $facebook;
        /** * @param string user firstname */
        public $firstname;
        /** * @param string user lastname */
        public $lastname;
        /** * @param string street */
        public $street;
        /** * @param string zip code */
        public $zipcode;
        /** * @param string city */
        public $city;
        /** * @param string country */
        public $country;
        /** * @param string job description - can held any string */
        public $job;
        /** * @param string datetime when user has last logged in */
        public $lastlogin;
        /** * @param int 0|1 1 means the email is public and can be shown on the website */
        public $public_email;
        /** * @param int 0|1 user is currently logged in - or at least: not logged out */
        public $logged_in;
        /** * @param int how many likes the user has achieved */
        public $likes;
        /** * @param int override the current template ID */
        public $overrideTemplate;
        /** * @param int current template ID */
        public $templateID;

        /**
         * @brief user constructor.
         */
        function __construct($db)
        {
            if (!isset($db)){ $db = new \YAWK\db(); }
            if (isset($_SESSION['username']))
            {
                $this->loadProperties($db, $_SESSION['username']);
            }
        }


        /**
         * @brief Generate a safe token for password reset
         * @param string $length the length of your token
         * @return string $token function returns the token
         */
        static function getToken($length)
        {
            $token = "";
            $code = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
            $code.= "abcdefghijklmnopqrstuvwxyz";
            $code.= "0123456789";
            $max = strlen($code); // edited

            for ($i=0; $i < $length; $i++)
            {
                $token .= $code[random_int(0, $max-1)];
            }
            // check if token is set
            if (is_string($token))
            {   // ok, return token
                return $token;
            }
            else
            {   // error generating token
                return false;
            }
        }


        /**
         * @brief Check if password reset token matches and return uid
         * @param object $db database obj
         * @param string $token token that was generated for this user
         * @return mixed returns the affected user id (or false)
         */
        static function checkResetToken($db, $token)
        {
            // check if token is set and in valid format
            if (isset($token) && (is_string($token)))
            {
                // strip tags for security reasons
                $token = strip_tags($token);

                // compare with stored token in database
                if ($res = $db->query("SELECT id FROM {users} WHERE hashValue = '".$token."'"))
                {
                    // token matches, get user ID
                    if ($row = mysqli_fetch_row($res))
                    {
                        // return user ID
                        return $row[0];
                    }
                    else
                    {   // no ID found
                        return false;
                    }
                }
                else
                {   // no user with this token hash value found
                    return false;
                }
            }
            else
            {   // user token not set or wrong type
                return false;
            }
        }

        /**
         * @brief Draw the form where users can reset their password.
         * @details The password reset email leads to this form.
         * @param object $db database obj
         * @param array $lang language array
         * @param int $uid user ID
         */
        static function drawPasswordResetForm($db, $lang, $uid)
        {
            echo "<form action=\"index.php?setNewPassword=true\" method=\"POST\" role=\"form\">";
            echo "<label for=\"newPassword1\">$lang[PASSWORD]</label>";
            echo "<input type=\"password\" class=\"form-control\" name=\"newPassword1\" id=\"newPassword1\">";
            echo "<label for=\"newPassword2\">$lang[PASSWORD_REPEAT]</label>";
            echo "<input type=\"password\" class=\"form-control\" name=\"newPassword2\" id=\"newPassword2\">";
            echo "<input type=\"hidden\" value=\"$uid\" class=\"form-control\" name=\"uid\" id=\"uid\">";
            echo "<button type=\"submit\" style=\"margin-top:5px;\" class=\"btn btn-success\">$lang[PASSWORD_SET_NEW]</button>";
            echo "</form>";
        }

        /**
         * @brief Set a new user password
         * @param string $newPassword The new password that will be stored in the database
         * @param int $uid The affected user id
         * @param object $db database obj
         */
        static function setNewPassword($db, $newPassword, $uid)
        {
            // check if new password is set and valid
            if (isset($newPassword) && (!empty($newPassword)) && (is_string($newPassword)))
            {   // check if uid is set and valid
                if (isset($uid) && (!empty($uid)) && (is_numeric($uid)))
                {
                    // hash password
                    $newPassword = md5($newPassword);

                    // update database - change password
                    if ($res = $db->query("UPDATE {users} SET password = '".$newPassword."' WHERE id = '".$uid."'"))
                    {   // password changed successfully
                        \YAWK\sys::setSyslog($db, 9, 0, "user $uid changed his password", $uid, 0, 0, 0);
                        return true;
                    }
                    else
                    {   // password cannot be changed
                        \YAWK\sys::setSyslog($db, 11, 1, "failed to update password of user $uid ", $uid, 0, 0, 0);
                        return false;
                    }
                }
                else
                {   // uid not set or not valid
                    \YAWK\sys::setSyslog($db, 11, 1, "uid not set, empty or wrong datatype", $uid, 0, 0, 0);
                    return false;
                }
            }
            else
            {   // new password not set or not valid
                \YAWK\sys::setSyslog($db, 11, 1, "failed to update user password: new password not set, empty or not valid", $uid, 0, 0, 0);
                return false;
            }
        }

        /**
         * @brief Send password change request email
         * @param object $db database obj
         * @param string $username username from pwd reset form
         * @param string $email email from pwd reset from
         * @param object $lang language obj
         * @return bool true|false
         */
        static function sendResetEmail($db, $username, $email, $lang)
        {
            // first of all we check if user entered a correct username or email string.
            // afterwards, we get the UID for this user and store a personal hash value
            // user will get an email, containing a link with the hash to the form where
            // he can set his new password. If hash matches, password change is possible.
            // Until this last step he can still login with his old credentials - password
            // in database will not be touched until he enters a new one.

            // get UID from username
            if (isset($username) && (!empty($username) && (is_string($username)))) {
                // user wants to reset with his username
                $username = trim($username);
                $username = strip_tags($username);
                // get user id from username
                $uid = self::getUserIdFromName($db, $username);
            }
            // or get UID from email
            else if (isset($email) && (!empty($email) && (is_string($email))))
            {
                // user wants to reset with his email
                $email = trim($email);
                $email = strip_tags($email);
                $uid = self::getUserIdFromEmail($db, $email);
            }
            else
            {
                \YAWK\alert::draw("warning", $lang['WARNING'], $lang['USERNAME_OR_EMAIL_NOT_SET'], "", 3800);
                return false;
            }

            // check if UID is valid
            if (empty($uid) || (!is_numeric($uid)))
            {   // throw error - UID is not valid
                \YAWK\alert::draw("danger", $lang['ERROR'], $lang['PASSWORD_RESET_UID_FAILED'], "", 3800);
                return false;
            }
            else
            {   // uid is valid, go ahead and generate hash value
                $token = self::getToken(196);

                // store token in database
                if ($res = $db->query("UPDATE {users} SET hashValue = '".$token."' WHERE id = '".$uid."'"))
                {
                    // get user email address
                    if (!isset($email) || (empty($email)))
                    {
                        // get email address of this user
                        $to = \YAWK\user::getUserEmail($db, $username);
                    }
                    else
                    {   // password recipient
                        $to = $email;
                        // get username
                        $username = self::getUserNameFromID($db, $uid);
                    }

                    // get admin email address
                    $from = \YAWK\settings::getSetting($db, "admin_email");

                    // check if $to is a valid email address
                    if (filter_var($to, FILTER_VALIDATE_EMAIL))
                    {
                        // get full url to build the link
                        $url = \YAWK\sys::getHost($db);
                        if (filter_var($url, FILTER_VALIDATE_URL))
                        {
                            // append token and generate complete url
                            $firstCharOfUrl = mb_substr($url, 0,-1);
                            if ($firstCharOfUrl === "/")
                            {   // url missing trailing slash, append it
                                $tokenLink = $url."/index.php?resetPassword=true&token=$token";
                            }
                            else
                            {   // url still got a slash
                                $tokenLink = $url."index.php?resetPassword=true&token=$token";
                            }

                            $mailBody = "$lang[HELLO] $username!\n\r$lang[PASSWORD_RESET_REQUESTED]\n\r$lang[PASSWORD_RESET_MAILBODY]\n\r".$tokenLink."\n\r$lang[PASSWORD_RESET_REQUEST_WARNING].";
                            if (\YAWK\email::sendEmail($from, $to, "", "$lang[PASSWORD_RESET] $url", $mailBody) === true)
                            {   // reset password email sent
                                \YAWK\sys::setSyslog($db, 9, 0, "reset password email requested from $username ($to)", $uid, 0, 0, 0);
                                $_SESSION['passwordFail'] = 0;
                                return true;
                            }
                            else
                            {   // FAILED to send password reset email
                                \YAWK\alert::draw("warning", $lang['ERROR'], "$lang[EMAIL_NOT_SENT] <br>(from: $from)<br>(to: $to)", "", 3800);
                                \YAWK\sys::setSyslog($db, 11, 1, "failed to send reset password email to $username ($to)", $uid, 0, 0, 0);
                                return false;
                            }
                        }
                        else
                        {   // URL seems to be invalid, unable to generate token URL
                            \YAWK\alert::draw("warning", $lang['ERROR'], "$lang[PASSWORD_RESET_URL_INVALID] (url: $url)", "", 3800);
                            \YAWK\sys::setSyslog($db, 12, 2, "failed to reset password due invalid token URL", $uid, 0, 0, 0);
                            return false;
                        }
                    }
                    else
                    {   // NOT VALID EMAIL ADDRESS (to:)
                        \YAWK\alert::draw("warning", $lang['ERROR'], $lang['EMAIL_ADD_INVALID'], "", 3800);
                        \YAWK\sys::setSyslog($db, 11, 1, "invalid email address $to", $uid, 0, 0, 0);
                        return false;
                    }
                }
                else
                {   // error: hash value could not be stored / updated in database
                    \YAWK\sys::setSyslog($db, 11, 1, "failed to update hash value in database", $uid, 0, 0, 0);
                    \YAWK\alert::draw("warning", "Hash Value", "could not be stored.", "", 3800);
                    return false;
                }
            }
        }

        /**
         * @brief return current username
         * @param object $lang language obj
         * @return string current username
         */
        static function getCurrentUserName($lang)
        {
            if (isset($_SESSION['username']))
            {
                return $_SESSION['username'];
            }
            else
            {
                return $lang['GUEST'];
            }
        }

        /**
         * @brief check, if a session username is set and if user is logged in
         * @param object $db database obj
         * @return string|bool return current username or false
         */
        static function isAnybodyThere($db)
        {
            // check if session is set
            if (isset($_SESSION))
            {
                // check if session username + uid is set
                if (isset($_SESSION['username']) && isset($_SESSION['uid']))
                {   // check if session logged_in status is true
                    if ($_SESSION['logged_in'] == true)
                    {   // session username is set, check if its a non-empty string
                        if (!empty($_SESSION['username']) && (is_string($_SESSION['username'])))
                        {   // username seems to be valid -
                            return $_SESSION['username'];
                        }
                        else
                        {   // username seems not to be valid
                            return false;
                        }
                    }
                    else
                    {   // user is there, but not logged in
                        return false;
                    }
                }
                else
                {   // session username is not set
                    return false;
                }
            }
            // no session - check if $_GET is set instead
            else if (isset($_GET))
            {   // check if user param is set
                if (isset($_GET['user']) && (!empty($_GET['user']) && (is_string($_GET['user']))))
                {   // check if database says user is logged in
                    if (self::isLoggedIn($db, $_GET['user']))
                    {   // user is logged in
                        return $_GET['user'];
                    }
                    else
                    {   // user is not logged in
                        return false;
                    }
                }
                else
                {   // $_GET user is not set, empty or not valid
                    return false;
                }
            }
            else
            {   // no user is there
                return false;
            }
        }

        /**
         * @brief template ID for given user ID
         * @param object $db database
         * @param int $uid user ID
         * @return string|bool return template ID to corresponding user ID
         */
        static function getUserTemplateID($db, $uid)
        {   /* @param $db \YAWK\db */
            if (!isset($uid) && (empty($uid)))
            {   // uid is missing
                return false;
            }
            if ($res = $db->query("SELECT templateID FROM {users} WHERE id = $uid"))
            {
                if ($row = mysqli_fetch_row($res))
                {   // return $userTemplateID
                    return $row[0];
                }
                else
                {
                    \YAWK\sys::setSyslog($db, 11, 1, "failed to get templateID from user db ", $uid, 0, 0, 0);
                    return false;
                }
            }
            else
            {
                \YAWK\sys::setSyslog($db, 11, 1, "failed to query templateID from user db ", $uid, 0, 0, 0);
                return false;
            }
        }

        /**
         * @brief check if user ID is allowed to override template
         * @param object $db database
         * @param int $uid user ID
         * @return bool
         */
        public function isAllowedToOverrideTemplate($db, $uid)
        {   /* @param $db \YAWK\db */
            if ($res = $db->query("SELECT overrideTemplate FROM {users} WHERE id = $uid"))
            {
                if ($row = mysqli_fetch_row($res))
                {
                    if ($row[0] === "1")
                    {
                        return true;
                    }
                    else
                    {
                        return false;
                    }
                }
                else
                {
                    \YAWK\sys::setSyslog($db, 11, 1, "failed to get overrideTemplate status from user db ", 0, 0, 0, 0);
                    return false;
                }
            }
            else
            {
                return false;
            }
        }

        /**
         * @brief set status and override template for this user ID
         * @param object $db database
         * @param int $overrideTemplate 0|1 1 if template could be overridden by this user
         * @param int $userTemplateID the template ID you wish to set for this user
         * @param int $uid user ID
         * @return bool
         */
        public function setUserTemplate($db, $overrideTemplate, $userTemplateID, $uid)
        {   /* @param $db \YAWK\db */
            if (!isset($overrideTemplate) && (!is_numeric($overrideTemplate)))
            {   // wrong param
                return false;
            }
            if (!isset($userTemplateID) && (!is_numeric($userTemplateID)))
            {   // wrong param
                return false;
            }
            if (!isset($uid) && (!is_numeric($uid)))
            {   // wrong param
                return false;
            }

            if ($res = $db->query("UPDATE {users} SET overrideTemplate = $overrideTemplate, templateID = $userTemplateID WHERE id = $uid"))
            {
                return true;
            }
            else
            {
                \YAWK\sys::setSyslog($db, 11, 1, "failed to update user template override - template ID: $userTemplateID", $uid, 0, 0, 0);
                return false;
            }
        }

        /**
         * @brief check if user template equals selected (active) template
         * @param object $db Database
         * @param int $userTemplateID the user template ID
         * @return bool
         */
        public function isTemplateEqual($db, $userTemplateID)
        {
            /* @param $db \YAWK\db */
            // check if userTemplateID param is set
            if (!isset($userTemplateID) && (empty($userTemplateID))) {   // missing templateID - cannot compare,
                return false;
            }
            $selectedTemplate = \YAWK\settings::getSetting($db, "selectedTemplate");
            if ($selectedTemplate === $userTemplateID) {   // user templateID and primary template (selectedTemplate) are equal
                return true;
            } else {   // user templateID and selected template do not match
                return false;
            }
        }

        /**
         * @brief return an array with all login data
         * @param object $db database
         * @param object $user
         * @return array|bool
         */
        static function getLoginData($db, $user)
        {   /* @param $db \YAWK\db */
            if (isset($user) && (!empty($user)))
            {   // check if user is registered
                if (self::hasLoggedIn($db, $user))
                {   // user is in list, extend sql string
                    $sqlStr = "WHERE username='$user'";
                    \YAWK\alert::draw("success", "showing login data for user: $user", " ", "",2400);
                }
                else
                {   // user not found in table, so draw an alert and show all logins...
                    $sqlStr = '';
                    \YAWK\alert::draw("warning", "Error!", "<h4>No login data available.</h4> Could not get data for user <b>$user</b>. Displaying all data instead.", "",5000);
                }
            }
            else
            {   // show all logins
                $sqlStr = '';
            }
            if ($res = $db->query("SELECT * FROM {logins} $sqlStr"))
            {   // fetch data in loop
                while ($row = $res->fetch_assoc())
                {   // store logins into array
                    $loginsArray[] = $row;
                }
                if (isset($loginsArray) && (!empty($loginsArray)))
                {   // if array is set and not empty
                    return $loginsArray;
                }
                else
                {   // something went wrong
                    return false;
                }
            }
            else
            {   // could not query login data...
                \YAWK\sys::setSyslog($db, 11, 1, "failed to query login data of $user ", 0, 0, 0, 0);
                return false;
            }
        }

        /**
         * @brief check if username is already registered
         * @param object $db database
         * @param string $user username to check
         * @return bool
         */
        static function isRegistered($db, $user)
        {   /** @var $db \YAWK\db */
            if ($res = $db->query("SELECT username FROM {users} WHERE username='$user'"))
            {
                if ($row = $res->fetch_assoc())
                {
                    return true;
                }
                else
                {
                    return false;
                }
            }
            else
            {
                return false;
            }
        }

        /**
         * @brief check if user already has logged in
         * @param object $db database
         * @param string $user username to check
         * @return bool
         */
        static function hasLoggedIn($db, $user)
        {   /** @var $db \YAWK\db */
            if ($res = $db->query("SELECT username FROM {logins} WHERE username='$user'"))
            {
                if ($row = $res->fetch_assoc())
                {
                    return true;
                }
                else
                {
                    return false;
                }
            }
            else
            {
                return false;
            }
        }


        /**
         * @brief check if backend is allowed for current session user group
         * @param object $db database
         * @return bool
         */
        static function isAdmin($db)
        {   /** @var $db \YAWK\db */
            // checks if backend login is allowed for this (logged in) Group ID
            if (isset($_SESSION))
            {   // check if there is a gid set
                if (isset($_SESSION['gid']) && (!empty($_SESSION['gid'])))
                {   // only if gid is bigger than zero
                    if ($_SESSION['gid'] > 0)
                    {   // check if backend login is allowed for this gid
                        if ($res = $db->query("SELECT backend_allowed FROM {user_groups} WHERE id ='".$_SESSION['gid']."'"))
                        {   // get data
                            if ($row = $res->fetch_row())
                            {   // if result is
                                if ($row[0] == 1)
                                {   // backend login allowed
                                    return true;
                                }
                                else
                                {   // backend login forbidden
                                    return false;
                                }
                            }
                            else
                            {   // could not fetch data
                                return false;
                            }
                        }
                        else
                        {   // could not query data
                            return false;
                        }
                    }
                    else
                    {   // session gid seems to be zero
                        return false;
                    }
                }
                else
                {   // gid is not set or empty
                    return false;
                }
            }
            else
            {   // session var is not set, user obviously not logged in
                return false;
            }
        }

        /**
         * @brief return user data as an array
         * @param object $db database
         * @return array|string
         */
        function getUserArray($db)
        {
            /* @param $db \YAWK\db */
            if ($result = $db->query("SELECT cu.*, cg.value as gid FROM {users} as cu
                                      JOIN {user_groups} as cg on cu.gid = cg.id ORDER BY id"))
            {
                $userDataArray = array();
                // cycle trough results
                while ($row = $result->fetch_assoc())
                {
                    $userDataArray[] = $row;
                }
                /* free result */
                $result->close();
            }
            else {
                $userDataArray = '';
                echo \YAWK\alert::draw("danger", "Error", "Sorry, database error: fetch getUserArray failed.","page=users","4800");
            }
            return $userDataArray;
        }

        /**
         * @brief get latest users and return as array
         * @param object $db database
         * @param int $count limit the query
         * @return array|string
         */
        static function getLatestUsers($db, $count)
        {
            if (isset($count))
            {   // param
                $limit = $count;
            }
            else
            {   // default value
                $limit = 8;
            }
            /* @param $db \YAWK\db */
            if ($result = $db->query("SELECT cu.*, cg.value as gid FROM {users} as cu
                                      JOIN {user_groups} as cg on cu.gid = cg.id ORDER BY id LIMIT $limit"))
            {
                $userDataArray = array();
                // cycle trough results
                while ($row = $result->fetch_assoc())
                {
                    $userDataArray[] = $row;
                }
                /* free result */
                $result->close();
            }
            else {
                $userDataArray = '';
                \YAWK\sys::setSyslog($db, 11, 1, "failed to fetch user list", 0, 0, 0, 0);
                echo \YAWK\alert::draw("danger", "Error", "Sorry, database error: fetch getLatestUsers failed.","page=users","4800");
            }
            return $userDataArray;
        }

        /**
         * @brief count and return all users
         * @param object $db database
         * @return string|bool
         */
        static function countUsers($db)
        {
            /* @param $db \YAWK\db */
            if ($result = $db->query("SELECT count(id) FROM {users}"))
            {
                $i = mysqli_fetch_row($result);
                return $i[0];
            }
            else
            {
                \YAWK\sys::setSyslog($db, 11, 1, "failed to count user db ", 0, 0, 0, 0);
                return false;
            }
        }


        /**
         * @brief load user properties into object
         * @param object $db database
         * @param string $username username to get the settings for
         * @return bool
         */
        function loadProperties($db, $username)
        {   /** @var $db \YAWK\db */
            if ($res = $db->query("SELECT * FROM {users}
                                   WHERE username = '" . $username . "'"))
            {   // fetch user properties
                if ($row = $res->fetch_assoc())
                {   // and set obj settings
                    $this->id = $row['id'];
                    $this->blocked = $row['blocked'];
                    $this->privacy = $row['privacy'];
                    $this->online = $row['online'];
                    $this->gid = $row['gid'];
                    $this->terms = $row['terms'];
                    $this->username = $row['username'];
                    $this->password = $row['password'];
                    $this->date_created = $row['date_created'];
                    $this->date_changed = $row['date_changed'];
                    $this->date_expired = $row['date_expired'];
                    $this->date_lastlogin = $row['date_lastlogin'];
                    $this->login_count = $row['login_count'];
                    $this->email = $row['email'];
                    $this->url = $row['url'];
                    $this->twitter = $row['twitter'];
                    $this->facebook = $row['facebook'];
                    $this->firstname = $row['firstname'];
                    $this->lastname = $row['lastname'];
                    $this->street = $row['street'];
                    $this->zipcode = $row['zipcode'];
                    $this->city = $row['city'];
                    $this->country = $row['country'];
                    $this->logged_in = $row['logged_in'];
                    $this->public_email = $row['public_email'];
                    $this->job = $row['job'];
                    $this->likes = $row['likes'];
                    $this->overrideTemplate = $row['overrideTemplate'];
                    $this->templateID = $row['templateID'];
                }
                else
                {   // fetch failed
                    \YAWK\sys::setSyslog($db, 11, 1, "failed to load settings of $username", $this->id, 0, 0, 0);
                    // \YAWK\alert::draw("warning","Warning!","Load settings for user <b>$username</b> failed.","","4800");
                    return false;
                }
            }
            else
            {   // q failed
                \YAWK\sys::setSyslog($db, 11, 1, "failed to query settings of $username", $this->id, 0, 0, 0);
                // \YAWK\alert::draw("danger","Error!","Could not select data for user <b>$username</b> from database...","","4800");
                return false;
            }
            return true;
        }

        /**
         * @brief get any user property
         * @param object $db database
         * @param string $property user property to get
         * @param int $uid affected user ID
         * @return string|bool
         */
        function getProperty($db, $property, $uid)
        {   /** @var $db \YAWK\db */
            if ($res = $db->query("SELECT $property FROM {users}
                                   WHERE id = '" . $uid . "'"))
            {
                $row = $res->fetch_row();
                return $row[0];
            }
            else
            {   // q failed
                \YAWK\sys::setSyslog($db, 11, 1, "Unable to get property <b>$property</b> of user ID <b>$uid</b> ", 0, 0, 0, 0);
                //  \YAWK\alert::draw("danger","Error!","Could not get property $property","","4800");
                return false;
            }
        }

        /**
         * @brief set any user property
         * @param object $db database
         * @param int $id affected user ID
         * @param string $property user property to set
         * @param string $value user value of this property
         * @return bool
         */
        static function setProperty($db, $id, $property, $value)
        {   /** @var $db \YAWK\db */
            if (isset($property) && isset($value) && isset($id) && is_numeric($id))
            {   // params are set, now escape strings
                $property = $db->quote($property);
                $value = $db->quote($value);
                $id = $db->quote($id);
                if ($res = $db->query("UPDATE {users}
                                        SET $property = '".$value."'
                                        WHERE id = '" . $id . "'"))
                {   // user property update success,
                    \YAWK\alert::draw("success","Success!","".$value." of property ".$property." set.","","4800");
                    return true;
                }
                else
                {   // q failed
                    \YAWK\sys::setSyslog($db, 11, 1, "failed to set value <b>$value</b> of property <b>$property</b>", 0, 0, 0, 0);
                    \YAWK\alert::draw("danger","Error!","Could not set value ".$value." of property ".$property.".","","4800");
                    return false;
                }
            }
            else
            {   // params failed or wrong type
                \YAWK\alert::draw("danger","Error!","Parameters failed or wrong type! You shall not manipulate vars, yoda said!","","4800");
                return false;
            }
        }

        /**
         * @brief get group name for given $gid (group ID)
         * @param object $db database
         * @param int $gid group ID
         * @return string|bool
         */
        static function getGroupNameFromID($db, $gid)
        {
            /** @var $db \YAWK\db */
            if ($res = $db->query("SELECT value
	                                FROM {user_groups}
	                                WHERE id = $gid"))
            {
                $row = $res->fetch_row();
                return $row[0];
            }
            // q failed
            return false;
        }

        /**
         * @brief get username from given $uid (user ID)
         * @param object $db database
         * @param int $uid user id to get the name for
         * @return string|bool
         */
        static function getUserNameFromID($db, $uid)
        {
            /** @var $db \YAWK\db */
            if ($res = $db->query("SELECT username
	                                FROM {users}
	                                WHERE id = $uid"))
            {
                $row = $res->fetch_row();
                if (isset($row[0])){
                    return $row[0];
                }
                else {
                    return false;
                }
            }
            // q failed
            return false;
        }

        /**
         * @brief get ID for given user
         * @param object $db database
         * @param string $user username to get the ID from
         * @return string|bool
         */
        static function getUserIdFromName($db, $user)
        {
            /** @var $db \YAWK\db */
            if ($res = $db->query("SELECT id
	                                FROM {users}
	                                WHERE username = '".$user."'"))
            {
                $row = $res->fetch_row();
                if (!empty($row[0])){
                    return $row[0];
                }
                else {
                    return false;
                }
            }
            // q failed
            return false;
        }

        /**
         * @brief get ID for given email address
         * @param object $db database
         * @param string $email email to get the ID from
         * @return string|bool
         */
        static function getUserIdFromEmail($db, $email)
        {
            /** @var $db \YAWK\db */
            if ($res = $db->query("SELECT id
	                                FROM {users}
	                                WHERE email = '".$email."'"))
            {
                $row = $res->fetch_row();
                return $row[0];
            }
            // q failed
            return false;
        }

        /**
         * @brief return all group IDs as an array
         * @param object $db database
         * @return array|bool
         */
        static function getAllGroupIDs($db)
        {   /** @var $db \YAWK\db */
            if ($res = $db->query("SELECT id, value FROM {user_groups}"))
            {   // fetch data in loop
                while ($row = mysqli_fetch_row($res))
                {   // fill array
                    $result[] = $row;
                }
                if (isset($result))
                {   // return array
                    return $result;
                }
                else
                {   // fetch failed, throw error
                    \YAWK\sys::setSyslog($db, 11, 1, "failed to fetch id from user_groups db", 0, 0, 0, 0);
                    \YAWK\alert::draw("warning","Warning","Could not fetch id and/or value from user groups database.","","4800");
                    return false;
                }
            }
            else
            {   // q failed, throw error
                \YAWK\sys::setSyslog($db, 11, 1, "failed to query id from user_groups db", 0, 0, 0, 0);
                \YAWK\alert::draw("warning","Warning","Could not select id and/or value from user groups database.","","4800");
                return false;
            }
        }

        /**
         * @brief check if a username is logged in
         * @param object $db database
         * @param string $username username
         * @return bool
         */
        static function isLoggedIn($db, $username)
        {   /** @var $db \YAWK\db */
            if ($res = $db->query("SELECT id, logged_in FROM {users} WHERE username = '" . $username . "'"))
            {   // fetch data
                $row = mysqli_fetch_row($res);
                // user is logged in
                if ($row[1] === '1') {
                    // check if session & db username match
                    if (isset($_SESSION['username']) == $username)
                    {   // check if session uid + db uid match
                        if (isset($_SESSION['uid']) == $row[0] && $_SESSION['logged_in'] == true)
                        {   // success
                            return true;
                        }
                        else
                        {   // session var not set and session uid does not match with db
                            return false;
                        }
                    }
                    else
                    {   // session username does not match with db
                        return false;
                    }
                }
                else
                {   // user is not logged in
                    return false;
                }
            }
            else
            {   // q failed
                return false;
            }
        }

        /**
         * @brief get group data for given group ID
         * @param object $db database
         * @return array|null|string
         */
        static function getGroup($db)
        {   /** @var $db \YAWK\db */
            if (isset($_SESSION['gid']))
            {   // prepare vars
                $gid = $_SESSION['gid'];
                $sql = $db->query("SELECT id,value,signup_allowed,backend_allowed FROM {user_groups} WHERE id = '".$gid."'");
                $row = mysqli_fetch_array($sql);
                return $row;
            }
            else {
                return "Group ID not set.";
            }
        }

        /**
         * @brief return and output user image
         * @param string $location frontend or backend
         * @param string $user username
         * @param string $cssClass image css class eg. img-circle
         * @param int $w width in pixel
         * @param int $h height in pixel
         * @return string
         */
        static function getUserImage($location, $user, $cssClass, $w, $h)
        {
            if (isset($w) && isset($h))
            {
                if ($w === 0)
                {
                    $width = 0;
                }
                else
                {
                    $width = "width=\"$w\" ";
                }
                if ($h === 0)
                {
                    $height = 0;
                }
                else
                {
                    $height = "height=\"$h\" ";
                }
            }
            else
            {
                $width = '';
                $height = '';
            }
            if (isset($cssClass))
            {
                $css = "class=\"$cssClass\"";
            }
            else
            {
                $css = '';
            }

            if (isset($location))
            {
                if ($location == "frontend"){
                    $imageJpg = "media/images/users/".$user.".jpg";
                    $imagePng = "media/images/users/".$user.".png";
                    $defaultPic = "<img src=\"media/images/users/avatar.png\" $width $height $css>";

                }
                else
                {
                    $imageJpg = '';
                    $imagePng = '';
                    $defaultPic = "<img src=\"media/images/users/avatar.png\" $width $height $css>";
                }
                if ($location == "backend"){
                    $imageJpg = "../media/images/users/".$user.".jpg";
                    $imagePng = "../media/images/users/".$user.".png";

                    if ($cssClass == "img-circle")
                    {
                        $defaultPic = "<img src=\"../media/images/users/avatar.png\" $width $height $css>";
                    }
                    elseif ($cssClass == "img-circle sidebar-toggle")
                    {
                        $defaultPic = "<img src=\"../media/images/users/avatar-light.png\" $width $height $css>";
                    }
                    if ($cssClass == "user-image")
                    {
                        $defaultPic = "<img src=\"../media/images/users/avatar.png\" $width $height $css>";
                    }
                    if ($cssClass == "profile-user-img img-responsive img-circle")
                    {
                        $defaultPic = "<img src=\"../media/images/users/avatar.png\" $width $height $css>";
                    }
                }
                else
                {
                    $imageJpg = '';
                    $imagePng = '';
                    $defaultPic = "<img src=\"media/images/users/avatar.png\" $width $height $css>";
                }
            }
            else
            {
                $imageJpg = '';
                $imagePng = '';
                $defaultPic = "<img src=\"media/images/users/avatar.png\" $width $height $css>";
            }


            if (file_exists($imageJpg)){
                return "<img src=\"".$imageJpg."\" $width $height $css>";
            }
            elseif (file_exists($imagePng)){
                return "<img src=\"".$imagePng."\" $width $height $css>";
            }
            else
            {
                return $defaultPic;
            }
        }

        /**
         * @brief save object properties
         * @param object $db database
         * @return bool
         */
        function save($db)
        {   /** @var $db \YAWK\db */
            $date_changed = date("Y-m-d G:i:s");
            // lowercase username
            $this->username = mb_strtolower($this->username);
            // store sql
            if ($res = $db->query("UPDATE {users} SET
                                        blocked = '" . $this->blocked . "',
                                        privacy = '" . $this->privacy . "',
                                        date_changed = '" . $date_changed . "',
                                        username = '" . $this->username . "',
                                        password = '" . $this->password . "',
                                        email = '" . $this->email . "',
                                        url = '" . $this->url . "',
                                        twitter = '" . $this->twitter . "',
                                        facebook = '" . $this->facebook . "',
                                        firstname = '" . $this->firstname . "',
                                        lastname = '" . $this->lastname . "',
                                        street = '" . $this->street . "',
                                        zipcode = '" . $this->zipcode . "',
                                        city = '" . $this->city . "',
                                        country = '" . $this->country . "',
                                        job = '" . $this->job . "',
                                        overrideTemplate = '" . $this->overrideTemplate . "',
                                        templateID = '" . $this->templateID . "',
                                        gid = '" . $this->gid . "'
                      WHERE id = '" . $this->id . "'"))
            {
                \YAWK\alert::draw("success", "Success!", "User $this->username updated.","","1200");
                return true;
            }
            else
            {   // q failed
                \YAWK\sys::setSyslog($db, 11, 1, "failed to update status of $this->username", 0, 0, 0, 0);
                \YAWK\alert::draw("warning", "Error!", "User status could not be saved, please try again.","","4800");
                return false;
            }
        }

        /**
         * @brief block or unblock a user
         * @param object $db database
         * @param int $id user ID to toggle
         * @param int $blocked 0|1 status: 1 is blocked, 0 is not blocked
         * @return bool
         */
        function toggleOffline($db, $id, $blocked)
        {   /** @var $db \YAWK\db */
            // TOGGLE PAGE STATUS
            if (isset($blocked)) {
                $status = \YAWK\sys::iStatusToString($blocked, "blocked", "unblocked");
            } else { $status = "undefined - \$blocked not set"; }
            if (!$res = $db->query("UPDATE {users}
                          SET blocked = '" . $blocked . "'
                          WHERE id = '" . $id . "'"))
            {
                // q failed
                \YAWK\sys::setSyslog($db, 11, 1, "failed to toggle user ID <b>$id</b> to status <b>$status</b> ", 0, 0, 0, 0);
                return false;
            }
            else
            {   // toggle successful
                \YAWK\sys::setSyslog($db, 9, 0, "toggled user id <b>#$id</b> to status <b>$status</b> ", 0, 0, 0, 0);
                return true;
            }
        }

        /**
         * @brief return email address of $user
         * @param object $db database
         * @param string $user username
         * @return bool the emailadress of this $user
         */
        static function getUserEmail($db, $user)
        {   /** @param $db \YAWK\db $res */
            if ($res = $db->query("SELECT email
                              FROM {users}
                              WHERE username = '" . $user. "'"))
            {   // fetch data
                $row = $res->fetch_row();
                return $row[0];
            }
            else
            {   // q failed
                \YAWK\sys::setSyslog($db, 11, 1, "failed to get email address of <b>$user</b> ", 0, 0, 0, 0);
                return false;
            }
        }

        /**
         * @brief create a new user
         * @param object $db database
         * @param string $username username
         * @param string $password1 password
         * @param string $password2 password (must be same as password1)
         * @param string $email email adress
         * @param string $url url
         * @param string $twitter user twitter url
         * @param string $facebook user facebook url
         * @param string $firstname user firstname
         * @param string $lastname user lastname
         * @param string $street street
         * @param string $zipcode zip code
         * @param string $city city
         * @param string $country country
         * @param int $blocked 0|1 1 sets user to blocked, 0 is not blocked
         * @param int $privacy we need to accept users privacy: do not show email public, do not show on users online list
         * @param string $job job description - can held any string
         * @param int $gid user group ID
         * @return bool
         */
        static function create($db, $username, $password1, $password2, $email, $url, $twitter, $facebook, $firstname, $lastname, $street, $zipcode, $city, $country, $blocked, $privacy, $job, $gid)
        {   /** @var $db \YAWK\db */
            $date_created = date("Y-m-d G:i:s");
            // select maxID
            if ($res = $db->query("SELECT MAX(id) FROM {users}"))
            {   // add 1 to ID
                $row = mysqli_fetch_row($res);
                $id = $row[0] + 1;
            }
            else
            {   // if ID could not be determined, set 1 as default
                $id = 1;
            }
            // lowercase username
            $username = mb_strtolower($username);

            if ($username === "administrator" xor $username === "admin" or $username === "root")
            {   // forbidden username, throw error
                if ($id > 1)
                {
                    \YAWK\sys::setSyslog($db, 11, 2,"somebody tried to register as <b>$username</b>", 0, 0, 0, 0);
                }
            }

            // prepare password
            $password1 = strip_tags($password1);
            $password2 = strip_tags($password2);
            // check password
            if ($password1 == $password2)
            {
                $password = $password1;
                $password = md5($password);
                // create user
                if ($res = $db->query("SELECT username FROM {users} WHERE username='" . $username . "'"))
                {
                    $row = mysqli_fetch_row($res); // username is already taken
                    if (!is_null($row[0]))
                    {
                        if ($row[0] === $username)
                        {
                            \YAWK\alert::draw("warning","Warning!","Please choose another username!","","4800");
                            // exit;
                            return false;
                        }
                    }
                }
                /* TODO: check if this can be deleted
                else {
                    \YAWK\sys::setSyslog($db, 5, "could not fetch username <b>$username</b> ", 0, 0, 0, 0);
                    // \YAWK\alert::draw("danger","Warning!","Could not fetch username! Database error?","page=user-new","4800");
                    // exit;
                    \YAWK\alert::draw("warning","Warning!","Could not fetch username! Database error?","","4800");
                    return false;
                }
                */
                // prepare vars
                if (isset($_POST['twitter']) && (!empty($_POST['twitter']))) { $twitter = htmlentities($_POST['twitter']); }
                if (isset($_POST['facebook']) && (!empty($_POST['facebook']))) { $facebook = htmlentities($_POST['facebook']); }
                if (isset($_POST['firstname']) && (!empty($_POST['firstname']))) { $firstname = htmlentities($_POST['firstname']); }
                if (isset($_POST['lastname']) && (!empty($_POST['lastname']))) { $lastname = htmlentities($_POST['lastname']); }
                if (isset($_POST['street']) && (!empty($_POST['street']))) { $street = htmlentities($_POST['street']); }
                if (isset($_POST['zipcode']) && (!empty($_POST['zipcode']))) { $zipcode = htmlentities($_POST['zipcode']); }
                if (isset($_POST['city']) && (!empty($_POST['city']))) { $city = htmlentities($_POST['city']); }
                if (isset($_POST['country']) && (!empty($_POST['country']))) { $country = htmlentities($_POST['country']); }
                if (isset($_POST['job']) && (!empty($_POST['job']))) { $job = htmlentities($_POST['job']); }
                // prepare url vars
                if ($url === "http://") $url = "";
                if ($twitter === "http://www.twitter.com/username") $twitter = "";
                if ($facebook === "http://www.facebook.com/username") $facebook = "";

                // do db insert
                if ($res = $db->query("INSERT INTO {users}
                (id,username,password,date_created,email,url,twitter,facebook,firstname,lastname,street,zipcode,city,country,blocked,privacy,job,gid)
                VALUES('" . $id . "',
                       '" . $username . "',
                       '" . $password . "',
                       '" . $date_created . "',
                       '" . $email . "',
                       '" . $url . "',
                       '" . $twitter . "',
                       '" . $facebook . "',
                       '" . $firstname . "',
                       '" . $lastname . "',
                       '" . $street . "',
                       '" . $zipcode . "',
                       '" . $city . "',
                       '" . $country . "',
                       '" . $blocked . "',
                       '" . $privacy . "',
                       '" . $job . "',
                       '" . $gid . "')"))
                {   // all good
                    return true;
                }
                else
                {   // q failed
                    return false;
                }
            }
            else
            {   // passwords do not match
                // \YAWK\alert::draw("warning", "Warning!", "Passwords do not match!", "page=user-new", "4800");
                // exit;
                \YAWK\alert::draw("warning", "Warning!", "Passwords do not match!", "", "4000");
                return false;
            }
        }

        /**
         * @brief create a user from frontend
         * @param object $db database
         * @param string $username username
         * @param string $password1 password
         * @param string $password2 password (must match w password1)
         * @param string $email user email address
         * @param int $gid user group ID
         * @return bool
         */
        static function createFromFrontend($db, $username, $password1, $password2, $email, $gid)
        {   /** @var $db \YAWK\db */
            if (empty($username) || (empty($password1) || (empty($password2) || (empty($email) || (empty($gid))))))
            {
                echo \YAWK\alert::draw("danger", "Error!", "Missing Data. Please fill out the complete form.","",4200);
                echo \YAWK\PLUGINS\SIGNUP\signup::signUp($db);
                echo "</div></div><div style=\"background-image: url(media/images/bottom.png); height: 150px;\"></div>";
                exit;
            }
            $date_created = date("Y-m-d G:i:s");
            // select maxID
            if ($res = $db->query("SELECT MAX(id) FROM {users}"))
            {
                $row = mysqli_fetch_row($res);
                $id = $row[0] + 1;
            }
            // prepare password
            $password1 = htmlentities($_POST['password1']);
            $password2 = htmlentities($_POST['password2']);
            $password1 = $db->quote($password1);
            $password2 = $db->quote($password2);
            // check if passwords match
            if ($password1 == $password2)
            {
                $password = $password1;
                $password = md5($password);
                // check if username is already in use
                if ($res = $db->query("SELECT username FROM {users} WHERE username='" . $username . "'"))
                {
                    $row = mysqli_fetch_row($res);
                    if ($row[0])
                    {   // username IS already in use
                        \YAWK\alert::draw("danger", "Error!", "Please choose another user name!", "","");
                        echo \YAWK\PLUGINS\SIGNUP\signup::signUp($db);
                        exit;
                    }
                }
                // check if email is already in use
                if ($res = $db->query("SELECT email FROM {users} WHERE email='" . $email . "'"))
                {
                    $row = mysqli_fetch_row($res);
                    if ($row[0])
                    {   // email IS already in use
                        \YAWK\alert::draw("danger", "Error!", "Email is already in use!", "","");
                        echo \YAWK\PLUGINS\SIGNUP\signup::signUp($db);
                        exit;
                    }
                }
                // filter forbidden usernames
                if ($username === "administrator" xor $username === "admin" or $username === "root") {
                    \YAWK\alert::draw("danger", "Error!", "Hey c'mon... those kind of names are not allowed! Please choose another username!","","");
                    echo \YAWK\PLUGINS\SIGNUP\signup::signUp($db);
                    exit;
                }
                // default values of blocked and privacy
                $blocked = 0;   // NOT BLOCKED
                $privacy = 0;   // NO PRIVACY

                if ($res = $db->query("INSERT INTO {users} (id,username,password,date_created,email,blocked,privacy,gid)
                                       VALUES('" . $id . "',
                                              '" . $username . "',
                                              '" . $password . "',
                                              '" . $date_created . "',
                                              '" . $email . "',
                                              '" . $blocked . "',
                                              '" . $privacy . "',
                                              '" . $gid . "')"))
                {   // user added,
                    return true;
                }
                else
                {   // q failed
                    \YAWK\sys::setSyslog($db, 12, 2, "failed to register user from frontend: signup of <b>$username</b> failed", $id, 0, 0, 0);
                    \YAWK\alert::draw("danger", "Error!", "Error registering username. Exit with empty result.","","");
                    echo \YAWK\PLUGINS\SIGNUP\signup::signUp($db);
                }
            }
            else
            {   // passwords do not match
                // in that case throw error & draw form again...
                \YAWK\sys::setSyslog($db, 11, 1, "failed to signup user: <b>$username</b> - passwords mismatch", 0, 0, 0, 0);
                \YAWK\alert::draw("danger", "Error!", "Passwords mismatch! Please try again.","","");
                echo \YAWK\PLUGINS\SIGNUP\signup::signUp($db);
                exit;
            }
            echo \YAWK\alert::draw("danger", "Error!", "Something strange has happend. Code (000)","","");
            return false;
        }

        /**
         * @brief delete a user from database
         * @param object $db database
         * @param string $user username
         * @return bool
         */
        static function delete($db, $user)
        {   /** @var $db \YAWK\db */
            if ($res = $db->query("DELETE FROM {users} WHERE username = '" . $user . "'"))
            {
                return true;
            }
            else
            {
                \YAWK\sys::setSyslog($db, 11, 2,"failed to delete <b>$user</b> ", 0, 0, 0, 0);
                return false;
            }
        }

        /**
         * @brief check if password is correct; check also if user is blocked or terminated.
         * @param object $db database
         * @param string $username username
         * @param string $password password
         * @return bool
         */
        static function checkPassword($db, $username, $password)
        {   /** @var $db \YAWK\db */
            $adminEmail = \YAWK\settings::getSetting($db, "admin_email");
            $host = \YAWK\settings::getSetting($db, "host");
            $password = $db->quote(trim($password));
            $username = $db->quote(trim($username));
            $username = mb_strtolower($username);
            $sql = $db->query("SELECT blocked, terminatedByUser FROM {users} WHERE
                               username='" . $username . "' AND password = '" . md5($password) . "'");
            $res = mysqli_fetch_assoc($sql);
            if (isset($res)){ // if there is a result, username + pwd match.
                if(isset($res['blocked'])){ // check if user is blocked.
                    if ($res['blocked']==='1')
                    {
                        // get user id of the blocked user who tried to login
                        $uid = \YAWK\user::getUserIdFromName($db, $username);
                        \YAWK\sys::setSyslog($db, 12, 2, "<b>blocked user $username</b> tried to login", $uid, 0, 0, 0);
                        echo "<div class=\"container bg-danger\"><br><h2>We're Sorry! <small>Your Account is blocked.</h2><b>If you think
                        this is a mistake, contact the admin via email: </b>(<a class=\"text-danger\" href=\"mailto:$adminEmail\">$adminEmail</a>)
                        <b>for further information.</b><br><small>You will be redirected to <a class=\"small\" href=\"$host\">$host</a> in 30 seconds.</small><br><br></div>";
                        \YAWK\sys::setTimeout("index.html", 30000);
                        return false;
                    }
                }
                if(isset($res['terminatedByUser'])){ // is user has canceled his account
                    if ($res['terminatedByUser']==='1'){ // check if user is
                        $uid = \YAWK\user::getUserIdFromName($db, $username);
                        \YAWK\sys::setSyslog($db, 11, 1, "failed to login <b>$username</b> user has deleted his account before - it does not exist anymore", $uid, 0, 0, 0);
                        echo "<div class=\"container bg-danger\"><br><h2>We're Sorry! <small>This account does not exist.</h2><b>If you think
                        this is a mistake, contact the admin via email: </b>(<a class=\"text-danger\" href=\"mailto:$adminEmail\">$adminEmail</a>)
                        <b>.</b><br><small>You will be redirected to <a class=\"small\" href=\"$host\">$host</a> in 30 seconds.</small><br><br></div>";
                        \YAWK\sys::setTimeout("index.html", 30000);
                        return false;
                    }
                }
                // username + pwd match, user is not blocked, not terminated...
                return true;
            }
            else
            {
                \YAWK\sys::setSyslog($db, 11, 1, "login failed due wrong credentials from <b>".$username."</b>", 0, 0, 0, 0);
                // checkPassword failed
                /* echo "<div class=\"container bg-danger\"><br><h2>Warning! <small>Login failed!</h2>
                <b>Please check your login credentials and try again in a few seconds.</b>
                <br><small>You will be redirected to <a class=\"small\" href=\"$host\">$host</a>.</small><br><br></div>";
                \YAWK\sys::setTimeout("index.html", 10000); */
                return false;
            }
        }

        /**
         * @brief check if group ID is allowed to login to backend
         * @param object $db database
         * @param int $gid group ID who needs to be checked
         * @return bool
         */
        function checkGroupId($db, $gid)
        {   /** @var $db \YAWK\db */
            // query data
            $sql = $db->query("SELECT backend_allowed FROM {user_groups} WHERE id='".$gid."'");
            $res = mysqli_fetch_row($sql);
            if ($res[0] === '1')
            {   // success
                return true;
            }
            else
            {   // login not allowed from that user group
                \YAWK\sys::setSyslog($db, 11, 1, "user group ID <b>$gid</b> is not allowed to login into backend", 0, 0, 0, 0);
                return false;
            }
        }

        /**
         * @brief check if user is allowed to login
         * @param object $db password
         * @return bool
         */
        static function checkLogin($db)
        {   /** @var $db \YAWK\db */
            /* check user login */
            $user = new \YAWK\user($db);
            if(isset($_POST['user']) && isset($_POST['password'])) {
                if($user->login($db, $_POST['user'],$_POST['password']))
                {   // create session var
                    $user->storeLogin($db, 0, "backend", $_POST['user'], $_POST['password']);
                    \YAWK\sys::setSyslog($db, 10, 0, "backend login <b>$_POST[user]</b> successful", 0, 0, 0, 0);
                    return true;
                }
                else
                {   // if username or pwd is wrong
                    $user->storeLogin($db, 1, "backend", $_POST['user'], $_POST['password']);
                    \YAWK\sys::setSyslog($db, 12, 2, "failed backend login <b>$_POST[user]</b> username or password wrong", 0, 0, 0, 0);
                    // \YAWK\alert::draw("warning","Warning:","<b>Login failed.</b> Please check login data and try again. Please wait, you will be redirected in 5 Seconds...","index.php","5000");
                    return false;
                }
            }
            else
            {   // username or password not set
                \YAWK\sys::setSyslog($db, 11, 1, "somebody $_POST[user] tried to login, but username or password was not set.", 0, 0, 0, 0);
                return false;
            }
        }

        public static function ajaxLogin($db, $user, $password)
        {
            // create new user class object
            $userClass = new \YAWK\user($db);

            // check user and password vars
            if (isset($user) && (!empty($user) && (is_string($user)
                        && (isset($password) && (!empty($password) && (is_string($password)))))))
            {
                // check if user is logged in
                if (self::isLoggedIn($db, $user) === false)
                {
                    // login successful
                    if(self::login($db, $user, $password) === true)
                    {   // login successful
                        $userClass->storeLogin($db, 0, "frontend", $user, $password);
                        // \YAWK\sys::setSyslog($db, "3", "ajax login successful", 0, 0, 0, 0);
                        return true;
                    }
                    else
                    {   // login failed
                        $userClass->storeLogin($db, 1, "frontend", $user, $password);
                        // \YAWK\sys::setSyslog($db, "5", "ajax login failed", 0, 0, 0, 0);
                        return false;
                    }
                }
                // in any other case
                return false;
            }
            else
            {   // login data wrong
                return false;
            }
        }

        /**
         * @brief login user
         * @param object $db database
         * @param string $username username
         * @param string $password password
         * @return bool
         */
        static function login($db, $username, $password)
        {
            /** @var $db \YAWK\db */
            if (empty($username && $password)){
                return false;
            }
            if (empty($username || $password)){
                return false;
            }
            // remove html tags from username
            $username = strip_tags($username);
            // remove html tags from password
            $password = strip_tags($password);
            // quote username
            $username = $db->quote(trim($username));
            // quote password
            $password = $db->quote(trim($password));
            // set session username
            $_SESSION['username'] = $username;

            // if given username + password are correct
            if (self::checkPassword($db, $username, $password))
            {
                // select login count
                $res = $db->query("SELECT id, login_count, gid FROM {users} WHERE username='" . $username . "'");
                $row = mysqli_fetch_row($res);
                // add session user ID
                $_SESSION['uid'] = $row[0];
                // add session group ID
                $_SESSION['gid'] = $row[2];
                // set login counter
                $login_count = $row[1] + 1;
                // get current datetime
                $date_now = date("Y-m-d G:i:s");
                // update login counter
                if (!$res = $db->query("UPDATE {users} SET
                                        date_lastlogin = '" . $date_now . "',
                                        login_count = '" . $login_count . "',
                                        online = '1',
                                        logged_in = '1'
                      WHERE username = '" . $username . "'"))
                {
                    \YAWK\sys::setSyslog($db, 11, 1, "failed to update login counter ($login_count) of <b>$username</b> .", $_SESSION['uid'], 0, 0, 0);
                    return false;
                }
                else
                {   // LOGIN SUCCESSFUL
                    // try to re-new session ID
                    @session_regenerate_id();
                    // set session username
                    $_SESSION['username'] = $username;
                    // set logged_in session status to true
                    $_SESSION['logged_in'] = true;
                    // store successful login
                    \YAWK\sys::setSyslog($db, 10, 0, "login <b>$username</b> successful", $_SESSION['uid'], 0, 0, 0);
                    // self::storeLogin($db, 0, "frontend", $username, $password);
                    return true;
                }
            }
            else
            {   // check password failed
                $uid = \YAWK\user::getUserIdFromName($db, $username);
                \YAWK\sys::setSyslog($db, 11, 1, "failed to login <b>$username</b>", $uid, 0, 0, 0);
                // return \YAWK\alert::draw("warning", "Login failed...", "Please try to re-login in a few seconds...", "",3000);
                return false;
                /*
                                if (!isset($_SESSION['failed'])){
                                    $_SESSION['failed']=1;
                                    $this->storeLogin($db, 1, "frontend", $username, $password);
                                    return false;
                                }
                                else {
                                    $_SESSION['failed']++;
                                    $this->storeLogin($db, 1, "frontend", $username, $password);
                                    // return false;
                                }
                                if ($_SESSION['failed'] == 2){
                                    echo "<div class=\"well\">";
                                    echo \YAWK\alert::draw("danger", "<h3><i class=\"fa fa-exclamation-triangle\"></i> ACHTUNG!", "2. Fehlversuch!</h3>
                                    <b>Du hast noch einen Versuch um deinen Benutzernamen und das Passwort korrekt einzugeben.</b>","", 6200);
                                    echo "</div>";
                                    $this->storeLogin($db, 1, "frontend", $username, $password);
                                    return false;
                                }
                                if ($_SESSION['failed'] == 3){
                                    echo "<div class=\"container\"><div class=\"well\">";
                                    echo \YAWK\alert::draw("danger", "<h3><i class=\"fa fa-exclamation-triangle\"></i> ACHTUNG!", "3. Fehlversuch!</h3>
                                    <b>Beim n&auml;chsten falschen Versuch wird die Prozedur geloggt und der Admin informiert.</b>","",6200);
                                    echo "</div></div>";
                                    $this->storeLogin($db, 1, "frontend", $username, $password);
                                    return false;
                                }
                                if ($_SESSION['failed'] >= 10){
                                    echo "<div class=\"container\"><div class=\"well\">";
                                    echo \YAWK\alert::draw("danger", "<h3><i class=\"fa fa-exclamation-triangle\"></i> ACHTUNG!", "$_SESSION[failed]. Fehlversuch!</h3>
                                    <b>Du wurdest gewarnt! Brute Force Attacken sind strafbar. Es wird Anzeige erstattet.</b><br>
                                    <b>Du bist nicht berechtigt Dich einzuloggen. Du wurdest gewarnt. Lass den Schwachsinn.</b><br>
                                    Datum: $date_now<br>
                                    Deine IP: $_SERVER[REMOTE_ADDR]<br>
                                    Agent: $_SERVER[HTTP_USER_AGENT]","",12200);
                                    echo "</div></div>";
                                    $domain = \YAWK\settings::getSetting($db, "domain");
                                    $to = \YAWK\settings::getSetting($db, "admin_email");
                                    $from = "script@".$domain."";
                                    $message = "FAILED LOGIN ATTEMPT!\n\r
                                        Date     : $date_now\n
                                        Message  : User tried a FrontEnd Login more than $_SESSION[failed] times!!!\n
                                        User     : $this->username\n
                                        Password : $this->password\n";
                                    \YAWK\email::sendEmail($from, $to, "","LOGIN WARNING! on $domain", $message);
                                    $this->storeLogin($db, 1, "frontend", $username, $password);
                                    return false;
                                }
                                if ($_SESSION['failed'] >= 4){
                                    echo "<div class=\"container\"><div class=\"well\">";
                                    echo \YAWK\alert::draw("danger", "<h3><i class=\"fa fa-exclamation-triangle\"></i> ACHTUNG!", "$_SESSION[failed]. Fehlversuch!</h3>
                                    <b>Offensichtlich bist Du nicht berechtigt, Dich hier einzuloggen.<br>
                                    </b><i>Deine wiederholten Zugriffe wurden aus Sicherheitsgr&uuml;nden geloggt. Admin ist informiert.</i>","",6200);
                                    echo "</div></div>";
                                    $domain = \YAWK\settings::getSetting($db, "domain");
                                    $to = \YAWK\settings::getSetting($db, "admin_email");
                                    $from = "script@".$domain."";
                                    $message = "FAILED LOGIN ATTEMPT!\n\r
                                        Date     : $date_now\n
                                        Message  : User tried a FrontEnd Login without sufficient right!\n
                                        User     : $this->username\n
                                        Password : $this->password\n";
                                    \YAWK\email::sendEmail($from, $to, "","LOGIN WARNING! on $domain", $message);
                                    $this->storeLogin($db, 1, "frontend", $username, $password);
                                    //\YAWK\backend::setTimeout("startseite.html", 6400);
                                    return false;
                                }

                                return false;
                */
            }
        }

        /**
         * @brief login user to backend
         * @param object $db database
         * @param string $username username
         * @param string $password password
         * @return bool
         */
        function loginBackEnd($db, $username, $password)
        {   /** @var $db \YAWK\db */
            $password = $db->quote(trim($password));
            $this->username = $db->quote(trim($username));
            // datum + login count aktualisieren
            $date_now = date("Y-m-d G:i:s");
            if ($this->checkPassword($db, $this->username, $password)) {
                /* select and add login_count */
                $res = $db->query("SELECT id, login_count, gid FROM {users} WHERE username='" . $username . "'");
                $row = mysqli_fetch_row($res);
                $_SESSION['uid'] = $row[0];
                $_SESSION['gid'] = $row[2];
                $i = $row[1];
                $login_count = $i + 1;
                $_SESSION['logins'] = $login_count;
                $this->username = $username;
                // check if user got sufficient rights for backend use
                if ($this->checkGroupId($db, $_SESSION['gid'])) {
                    if(!$res = $db->query("UPDATE {users} SET
                                        date_lastlogin = '" . $date_now . "',
                                        login_count = '" . $login_count . "',
                                        online = '1',
                                        logged_in = '1'
                      WHERE username = '" . $this->username . "'"))
                    {
                        $uid = \YAWK\user::getUserIdFromName($db, $username);
                        \YAWK\sys::setSyslog($db, 11, 1, "failed to login <b>$username</b>", $uid, 0, 0, 0);
                        echo \YAWK\alert::draw("warning", "Error!", "Could not log user into database. Expect some errors.","","3800");
                    }
                    else
                    {   // avoid fake session ID
                        @session_regenerate_id();
                        $_SESSION['logged_in'] = true;
                    }
                    return true;
                }
                else
                {
                    $uid = \YAWK\user::getUserIdFromName($db, $username);
                    // user aint got the rights to login to backend
                    \YAWK\sys::setSyslog($db, 12, 2, "failed to login <b>$username</b> user aint got sufficient rights to login. .", $uid, 0, 0, 0);
                    \YAWK\alert::draw("danger", "Login failed!", "You are not allowed to login here.", "", 10000);
                }
            } // wrong password given
            else { // kick it back
                /** LOG FAILED LOGIN ....*/
                if (!isset($_SESSION['failed']))
                {
                    $_SESSION['failed'] = 0;
                }
                else
                {
                    $_SESSION['failed']++;
                }
                echo "<script>
                            // RE-LOGIN TIMER
                                $('div *').prop('disabled', true);
                                var count = 8;
                                var counter = setInterval(timer, 1000); // 1000 will  run it every 1 second
                                function timer()
                                {
                                    count=count-1;
                                    if (count <= 0)
                                    {
                                        timer = '#timer';
                                        clearInterval(counter);
                                        //counter ended, do something here
                                        $('div *').prop('disabled', false);
                                        $(timer).empty();
                                        $(timer).append(\"a few\").fadeIn();
                                        return null;
                                    }
                                    //Do code for showing the number of seconds here
                                    document.getElementById(\"timer\").innerHTML=count; // watch for spelling
                                }
                            </script>";
                \YAWK\alert::draw("danger", "Login failed!", "Please check your login data and try to re-login in a few seconds!","","3500");
                $uid = \YAWK\user::getUserIdFromName($db, $username);
                $this->storeLogin($db, 0, "backend", $username, $password);
                \YAWK\sys::setSyslog($db, 11, 1, "failed to login <b>$username</b>", $uid, 0, 0, 0);
                // \YAWK\alert::draw("danger", "Login failed!", "Please check your login data and try again.", "", 6000);

                /**
                if ($_SESSION['failed'] == 2){
                echo \YAWK\alert::draw("danger", "<h3><i class=\"fa fa-exclamation-triangle\"></i> ATTENTION!", "2nd failed try!</h3>
                <b>Next failed login will be logged for security reasons.</b>","","3800");
                $this->storeLogin($db, 0, "backend", $username, $password);
                return false;
                }
                else if ($_SESSION['failed'] >= 4){
                echo \YAWK\alert::draw("danger", "<h3><i class=\"fa fa-exclamation-triangle\"></i> ATTENTION!", "$_SESSION[failed]. failed try!</h3>
                <b>You are not allowed to login here. You have been warned.<br>
                The Admin is informed. Remember: BruteForce Attacks are against the law. <i style=\"text-decoration: underline;\">
                Case of recurrence will be logged and prosecuted.</i></b><br><br>
                Date: $date_now<br>
                Your IP: $_SERVER[REMOTE_ADDR]<br>
                Browser: $_SERVER[HTTP_USER_AGENT]</b>","","6800");
                $domain = \YAWK\settings::getSetting($db, "domain");
                $to = \YAWK\settings::getSetting($db, "admin_email");
                $from = "script@".$domain."";
                $message = "FAILED LOGIN ATTEMPT!\n\r
                Date     : $date_now\n
                Message  : User tried a Backend Login more than 4 times!!!\n
                User     : $this->username\n
                Password : $this->password\n";
                \YAWK\email::sendEmail($from, $to, "", "LOGIN WARNING! on $domain", $message);
                $this->storeLogin($db, 0, "backend", $username, $password);
                return false;
                }

                else if ($_SESSION['failed'] >= 3) {
                echo \YAWK\alert::draw("danger", "<h3><i class=\"fa fa-exclamation-triangle\"></i> ATTENTION!", "$_SESSION[failed]. failed try!</h3>
                <b>You are not allowed to login here. You have been warned.<br>
                The Admin is informed. Remember: BruteForce Attacks are against the law. <i style=\"text-decoration: underline;\">
                Case of recurrence will be logged and prosecuted.</i></b><br><br>
                Date: $date_now<br>
                Your IP: $_SERVER[REMOTE_ADDR]<br>
                Browser: $_SERVER[HTTP_USER_AGENT]</b>","","6800");
                $domain = \YAWK\settings::getSetting($db, "domain");
                $to = \YAWK\settings::getSetting($db, "admin_email");
                $from = "script@" . $domain . "";
                $message = "FAILED LOGIN ATTEMPT!\n\r
                Date     : $date_now\n
                Message  : User tried a Backend Login without sufficient right!\n
                User     : $this->username\n
                Password : $this->password\n";
                \YAWK\email::sendEmail($from, $to, "", "LOGIN WARNING! on $domain", $message);
                $this->storeLogin($db, 0, "backend", $username, $password);
                return false;
                }
                 *  */
                return false;
            }
            // something else has happened
            echo \YAWK\alert::draw("danger", "Login failed!", "Something else has happened.", "", 6000);
            return false;
        }

        /**
         * @brief store user login in database
         * @param object $db database
         * @param int $failed 0|1 failed status: 1 means login failed, 0 means NOT failed
         * @param string $location frontend or backend
         * @param string $username username
         * @param string $password password
         * @return bool
         */
        static function storeLogin($db, $failed, $location, $username, $password)
        {   /** @var $db \YAWK\db */
            if (!isset($location)){
                $location = '';
            }

            // store failed login
            $atm = date("Y-m-d H:i:s");
            if (!isset($failed))
            {   //
                $failed = 1;
            }
            if (!isset($state) || (empty($state)))
            {
                $state = "login";
            }
            $ip = $_SERVER['REMOTE_ADDR'];
            $useragent = $_SERVER['HTTP_USER_AGENT'];
            $res = $db->query("INSERT INTO {logins}
                (datetime, location, failed, ip, useragent, username, password)
                VALUES ('".$atm."', '".$location."', '".$failed."', '".$ip."', '".$useragent."', '".$username."', '".$password."') ");
            if ($res){ return true; }
            else { return false; }
        }


        /**
         * @brief return the html for a default login box
         * @param string $username username, as option
         * @param string $password password, as option
         * @return string
         */
        static function drawLoginBox($username, $password)
        {
            $html = "
            <form name=\"login\" id=\"loginForm\" role=\"form\" method=\"POST\">
                <input type=\"text\" id=\"user\" name=\"user\" value=\"".$username."\" class=\"form-control animated fadeIn\" placeholder=\"Benutzername\">
                <input type=\"password\" id=\"password\" name=\"password\" value=\"".$password."\" class=\"form-control animated fadeIn\" placeholder=\"Passwort\">
                <input type=\"hidden\" name=\"login\" value=\"login\">
                <input type=\"submit\" id=\"submitBtn\" value=\"Login\" style=\"margin-top:5px;\" name=\"Login\" class=\"btn btn-success animated fadeIn\">
            </form>";
            return $html;
        }

        /**
         * @brief return the html for a menu login box
         * @param string $username username, as option
         * @param string $password password, as option
         * @param string $style menu styling: light or dark
         * @return string htmnl that draws the menu login box
         */
        static function drawMenuLoginBox($username, $password, $style)
        {
            if (!isset($style) || (empty($style)))
            {
                $style = "light";
                $input_style = '';
            }
            else
            {
                if ($style == "light")
                {
                    $input_style = '';
                }
                elseif ($style == "dark")
                {
                    $input_style = "style=\"color: #ccc; border-color: #000; background-color: #444;\"";
                }
                else
                {
                    $input_style = '';
                }
            }

            $html = "<form name=\"login\" class=\"navbar-form navbar-right\" role=\"form\" action=\"welcome.html\" method=\"POST\">
              <div class=\"form-group\">
                <input type=\"text\" id=\"user\" name=\"user\" value=\"".$username."\" class=\"form-control\" $input_style placeholder=\"Benutzername\">
                <input type=\"password\" id=\"password\" name=\"password\" value=\"".$password."\" class=\"form-control\" $input_style placeholder=\"Passwort\">
                <input type=\"hidden\" name=\"login\" value=\"login\">
                <input type=\"hidden\" name=\"LOCK\" value=\"1\">
                <input type=\"hidden\" name=\"include\" value=\"login\">
                <input type=\"submit\" value=\"Login\" name=\"Login\" class=\"btn btn-success\">
                </div>
            </form>";
            return $html;
        }

        /**
         * @brief logout user
         * @param object $db database
         * @return bool
         */
        public function logout($db)
        {   /** @var $db \YAWK\db */
            // set user offline in db
            if (isset($_SESSION['username']))
            {   // if username is set in session var, logout
                if (!$res = $db->query("UPDATE {users}
                                   SET online = '0'
                                   WHERE username = '".$_SESSION['username']."'"))
                {
                    \YAWK\sys::setSyslog($db, 11, 1, "failed to logout <b>$_SESSION[username]</b> .", 0, 0, 0, 0);
                    \YAWK\alert::draw("danger", "Error!", "Could not logout ".$_SESSION['username']." Please try again!","","3800");
                    // DELETE SESSION
                    $_SESSION['failed']=0;
                    $_SESSION['logged_in']=0;
                    session_destroy();
                    return false;
                }
                else
                {   // username is not set, delete session anyway
                    $_SESSION['failed']=0;
                    $_SESSION['logged_in']=0;
                    session_destroy();
                    \YAWK\sys::setSyslog($db, 9, 0, "logout <b>".$_SESSION['username']."</b>", 0, 0, 0, 0);
                    return true;
                }
            }
            else
            {   // if a username is sent via get param...
                if (isset($_GET['user'])
                    && (!empty($_GET['user'])
                        && (is_string($_GET['user']))))
                {
                    // logout user
                    if (!$res = $db->query("UPDATE {users}
                                   SET online = '0'
                                   WHERE username = '".$_GET['username']."'"))
                    {   // unable to logout
                        \YAWK\sys::setSyslog($db, 11, 1, "unable to logout <b>".$_GET['username']."</b>", 0, 0, 0, 0);
                        \YAWK\alert::draw("danger", "Error!", "Could not logout ".$_GET['username']." Please try again!","","3800");
                        // DELETE SESSION
                        $_SESSION['failed']=0;
                        $_SESSION['logged_in']=0;
                        session_destroy();
                        return false;
                    }
                    else
                    {   // user logged out from database, destroy session
                        $_SESSION['failed']=0;
                        $_SESSION['logged_in']=0;
                        session_destroy();
                        \YAWK\sys::setSyslog($db, 9, 0, "logout <b>".$_GET['username']."</b>", 0, 0, 0, 0);
                        return true;
                    }
                }
                // DELETE SESSION
                $_SESSION['failed']=0;
                $_SESSION['logged_in']=0;
                session_destroy();
                return true;
            }
        }


        /**
         * @brief output a list of all users (who have not activated privacy switch)
         * @param object $db database
         */
        static function getUserList($db)
        {   /* @param \YAWK\db $db */
            // show ALL users
            // get all users from db where privacy is set to zero
            // & just pick users who are set to online in database
            $res = $db->query("SELECT username, email, public_email, online FROM {users} WHERE privacy != 1");
            while ($row = mysqli_fetch_assoc($res)){
                // first char uppcerase
                $username = ucfirst($row['username']);
                // check if users email adress is public
                if ($row['email'] && $row['public_email'] === '0'){
                    $email = $row['email'];
                } else {
                    $email = "";
                } // if not, build an empty string
                if ($row['online'] === '0') {
                    $color = "text-danger";
                }
                else {
                    $color = "text-success";
                }
                echo "<ul class=\"list-group\">
            <li class=\"list-group-item\"><span class=\"".$color."\"><strong>".$username." &nbsp;&nbsp;<small>".$email."</strong></small></span></li>
            </ul>";
            }
        }


        /**
         * @brief check if a user follows another
         * @param object $db database
         * @param int $uid user ID of the user who wants to know
         * @param int $hunted user ID of the other user
         * @return bool true, if they follow each other, false if not
         */
        static function checkFollowStatus($db, $uid, $hunted)
        {   /** @var $db \YAWK\db */
            if ($sql = $db->query("SELECT id FROM {follower} WHERE follower='$uid' AND hunted = '".$hunted."'"))
            {
                if (mysqli_fetch_row($sql))
                {
                    return true;
                }
                else
                {
                    return false;
                }
            }
            else
            {   // q failed
                \YAWK\sys::setSyslog($db, 19, 1, "failed to get status from follower db", $uid, 0, 0, 0);
                return false;
            }
        }

        /**
         * @brief check if two users are friends
         * @param object $db database
         * @param int $uid user ID who want to know
         * @param int $hunted user ID of the other user
         * @return bool
         */
        static function isFriend($db, $uid, $hunted)
        {   /** @var $db \YAWK\db */
            if ($sql = $db->query("SELECT id FROM {friends}
                                   WHERE confirmed='1' AND friendA='$uid' AND friendB = '".$hunted."'
                                   OR confirmed='1' AND friendA='$hunted' AND friendB = '$uid'"))
            {
                if (mysqli_fetch_row($sql))
                {
                    return true;
                }
                else
                {
                    return false;
                }
            }
            else
            {   // q failed
                \YAWK\sys::setSyslog($db, 19, 1, "failed to query friendship status of user ID <b>$uid</b> .", 0, 0, 0, 0);
                return false;
            }
        }

        /**
         * @brief check if a friendship request was sent from a user to another
         * @param object $db database
         * @param int $uid user ID who wants to know
         * @param int $hunted user ID of the other user
         * @return array|bool
         */
        static function isFriendRequested($db, $uid, $hunted)
        {   /** @var $db \YAWK\db */
            if ($sql = $db->query("SELECT id, friendA, friendB, confirmed, aborted FROM {friends}
                                   WHERE confirmed='0' AND friendA='$uid' AND friendB = '".$hunted."'
                                   OR confirmed='0' AND friendA='$hunted' AND friendB = '$uid'"))
            {
                $friends = array();
                while ($row = mysqli_fetch_assoc($sql))
                {
                    $friends[] = $row;
                }
                return $friends;
            }
            else
            {   // q failed
                \YAWK\sys::setSyslog($db, 19, 1, "failed to query friendship request status of uid <b>#$uid</b> .", 0, 0, 0, 0);
                return false;
            }
        }

        /**
         * @brief count and return how many notifications are unseen
         * @param object $db database
         * @return int|bool the number of notifications or false
         */
        static function countNotifications($db)
        {   /** @var $db \YAWK\db */
            if ($sql = $db->query("SELECT count(log_id) FROM {syslog}
                                   WHERE seen = '0'"))
            {   // count + return syslog entries
                $row = mysqli_fetch_row($sql);
                return $row[0];
            }
            else
            {   // q failed
                \YAWK\sys::setSyslog($db, 3, 1, "failed to count admin notifications", 0, 0, 0, 0);
                return false;
            }
        }

        /**
         * @brief count and return notifications for user ID
         * @param object $db database
         * @param int $uid user ID
         * @return int|bool the number of personal notifications for user ID, or false
         */
        static function countMyNotifications($db, $uid)
        {   /** @var $db \YAWK\db */
            if ($sql = $db->query("SELECT count(toUID) FROM {notifications}
                                   WHERE toUID = '".$uid."' AND seen = '0'"))
            {   // count + return syslog entries
                $row = mysqli_fetch_row($sql);
                return $row[0];
            }
            else
            {   // q failed
                \YAWK\sys::setSyslog($db, 3, 1, "failed to count personal notifications of UID <b>$uid</b> .", 0, 0, 0, 0);
                return false;
            }
        }

        /**
         * @brief return an array with all notifications
         * @param object $db database
         * @return array|bool
         */
        static function getAllNotifications($db)
        {   /** @var $db \YAWK\db */

            if ($sql = $db->query("SELECT * FROM {syslog} AS log
                                       LEFT JOIN {syslog_categories} AS category ON log.log_category=category.id
                                       LEFT JOIN {users} AS u ON log.fromUID=u.id
                                       WHERE log.seen = '0'
                                       GROUP BY log.log_id
                                       ORDER BY log.log_date DESC"))
            {   // create array
                $all_notifications = array();
                while ($row = mysqli_fetch_assoc($sql))
                {   // fill w data in loop
                    $all_notifications[] = $row;
                }
                return $all_notifications;
            }
            else
            {   // q failed
                \YAWK\sys::setSyslog($db, 3, 1, "unable to get syslog entries", 0, 0, 0, 0);
                return false;
            }
        }

        /**
         * @brief get all personal notifications for given user ID
         * @param object $db database
         * @param int $uid affected user ID
         * @return array|bool returns an array with all entries or false
         */
        static function getMyNotifications($db, $uid)
        {   /** @var $db \YAWK\db */
            if ($sql = $db->query("SELECT * FROM {notifications} AS log
                                       LEFT JOIN {syslog_categories} AS category ON log.log_category=category.id
                                       LEFT JOIN {notifications_msg} AS msg ON log.msg_id=msg.id
                                       LEFT JOIN {users} AS u ON log.fromUID=u.id
                                       WHERE log.toUID = '".$uid."'
                                       AND log.seen = '0'
                                       GROUP BY log.log_id
                                       ORDER BY log.log_date DESC"))
            {   // create array
                $my_notifications = array();
                while ($row = mysqli_fetch_assoc($sql))
                {   // fill w data in loop
                    $my_notifications[] = $row;
                }
                return $my_notifications;
            }
            else
            {   // q failed
                \YAWK\sys::setSyslog($db, 3, 1, "failed to get notifications.", $uid, 0, 0, 0);
                return false;
            }
        }

        /**
         * @brief count followers of given user ID
         * @param object $db database
         * @param int $uid affected user ID
         * @return int|bool the number of followers for that user ID or false
         */
        static function countMyFollowers($db, $uid)
        {   /** @var $db \YAWK\db */
            if ($sql = $db->query("SELECT count(id) FROM {follower} WHERE hunted = '".$uid."'"))
            {   // count + return data
                $row = mysqli_fetch_row($sql);
                return $row[0];
            }
            else
            {   // q failed
                \YAWK\sys::setSyslog($db, 19,1, "failed to count followers of user ID<b>$uid</b>", 0, 0, 0, 0);
                return false;
            }
        }

        /**
         * @brief count friends of given user ID
         * @param object $db database
         * @param int $uid affected user ID
         * @return int|bool the number of friends for that user ID or false
         */
        static function countMyFriends($db, $uid)
        {   /** @var $db \YAWK\db */
            if ($sql = $db->query("SELECT count(id) FROM {friends}
                                   WHERE confirmed = '1' AND friendA = '".$uid."'
                                   OR friendB = '".$uid."' AND confirmed = '1'
                                   AND aborted NOT LIKE '1'"))
            {   // count + return data
                $row = mysqli_fetch_row($sql);
                return $row[0];
            }
            else
            {   // q failed
                \YAWK\sys::setSyslog($db, 19, 1, "failed to count friends of user ID <b>$uid</b>", 0, 0, 0, 0);
                return false;
            }
        }

        /**
         * @brief return an array with all confirmed friends for given user ID
         * @param object $db database
         * @param object $lang language
         * @param int $uid affected user ID
         * @param int $confirmed 0|1 1 is confirmed, 0 is not. therefore you can get all friends, confirmed and outstanding
         * @return array|bool
         */
        static function getMyFriends($db, $uid, $confirmed, $lang)
        {   /** @var $db \YAWK\db */
            // to just friend requests
            if (isset($confirmed) && $confirmed === 0)
            {   // param outstanding
                $confirmed = 0;
            }
            else
            {
                $confirmed = 1;
            }
            if ($sql = $db->query("SELECT * FROM {friends} AS friends
                                   WHERE confirmed = '".$confirmed."' AND friendA = '".$uid."'
                                   OR confirmed = '".$confirmed."' AND friendB = '".$uid."'
                                   AND aborted NOT LIKE '1'"))
            {   // create friends array
                $friends = array();
                while ($row = mysqli_fetch_assoc($sql))
                {   // fill w data in loop
                    $friends[] = $row;
                }
                return $friends;
            }
            else
            {   // q failed
                \YAWK\sys::setSyslog($db, 19, 1, "failed to get friends of user ID <b>$uid</b>", 0, 0, 0, 0);
                return false;
            }
        }

        /**
         * @brief get an array with all followers for given user ID
         * @param object $db database
         * @param int $uid user ID
         * @return array|bool
         */
        static function getMyFollower($db, $uid)
        {   /** @var $db \YAWK\db */
            // param UID is set
            if (isset($uid))
            {   //
                if ($uid == 0)
                {   // select followers of logged in user
                    $currentuser = $_SESSION['uid'];
                }
                else
                {   // select followers of given user ID
                    $currentuser = $uid;
                }
            }
            else
            {   // default: followers of logged in user
                $currentuser = $_SESSION['uid'];
            }
            if ($sql = $db->query("SELECT * FROM {follower} AS f
                                   LEFT JOIN {users} AS u ON f.follower=u.id
                                   WHERE hunted = '".$currentuser."'"))
            {   // create friends array
                $follower = array();
                while ($row = mysqli_fetch_assoc($sql))
                {   // fill w data in loop
                    $follower[] = $row;
                }
                return $follower;
            }
            else
            {   // q failed
                \YAWK\sys::setSyslog($db, 3, 1, "failed to get followers of user ID <b>$uid</b> .", 0, 0, 0, 0);
                return false;
            }
        }

        /**
         * @brief count and return number of messages for given user ID
         * @param object $db database
         * @param int $uid affected user ID
         * @return int|bool number of messages or false
         */
        static function countNewMessages($db, $uid)
        {   /** @var $db \YAWK\db */
            $i = 0;
            if ($sql = $db->query("SELECT msg_id FROM {plugin_msg} WHERE msg_read ='0' AND spam IS NOT NULL AND trash IS NOT NULL AND toUID = '".$uid."'"))
            {   // fetch data in loop
                while ($row = mysqli_fetch_assoc($sql))
                {   // count +1 for each loop
                    $i++;
                }
                return $i;
            }
            else
            {   // q failed
                \YAWK\sys::setSyslog($db, 3, 1, "failed to count new messages of user ID <b>$uid</b> .", 0, 0, 0, 0);
                return false;
            }
        }

        /**
         * @brief return array with all messages for given user ID
         * @param object $db database
         * @param int $uid affected user ID
         * @return array|bool
         */
        static function getNewMessages($db, $uid)
        {   /** @var $db \YAWK\db */

            if ($sql = $db->query("SELECT * FROM {plugin_msg} WHERE msg_read ='0' AND toUID = '".$uid."' ORDER by msg_date DESC"))
            {   // create array
                $newMessages = array();
                while ($row = mysqli_fetch_assoc($sql))
                {   // add every message as new entry
                    $newMessages[] = $row;
                }
                return $newMessages;
            }
            else
            {   // q failed
                \YAWK\sys::setSyslog($db, 3, 1, "failed to get new messages of user ID <b>#$uid</b> .", 0, 0, 0, 0);
                return false;
            }
        }

    } // ./ class user
} // ./ namespace