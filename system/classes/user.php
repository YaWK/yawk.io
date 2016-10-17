<?php
namespace YAWK {
    /**
     * <b>The default user class. Provide all functions to handle the user object.</b>
     *
     * All functions that are required to handle a user. Methods are: add, edit, delete, checklogin and many more.
     * <p><i>Class covers both, backend & frontend functionality.
     * See Methods Summary for Details!</i></p>
     * @category   CMS
     * @package    System
     * @global     $connection
     * @global     $dbprefix
     * @author     Daniel Retzl <danielretzl@gmail.com>
     * @copyright  2009-2015 Daniel Retzl yawk.goodconnect.net
     * @license    http://www.gnu.org/licenses/gpl-2.0  GNU/GPL 2.0
     * @version    1.1.3
     * @link       http://yawk.io
     * @since      File available since Release 0.0.1
     * @annotation The default user class. Provide all functions to handle the user object.
     */

    class user
    {
        public $currentuser;
        public $username;
        public $blocked;
        public $id;
        public $published;
        public $privacy;
        public $online;
        public $gid;
        public $password;
        public $date_created;
        public $date_changed;
        public $date_lastlogin;
        public $date_expired;
        public $login_count;
        public $email;
        public $url;
        public $twitter;
        public $facebook;
        public $firstname;
        public $lastname;
        public $street;
        public $zipcode;
        public $city;
        public $country;
        public $job;
        public $lastlogin;
        public $public_email;
        public $logged_in;
        public $likes;
        public $overrideTemplate;
        public $templateID;

        function __construct()
        {
            if (!isset($db)){ $db = new \YAWK\db(); }
            if (isset($_SESSION['username']))
            {
                $this->loadProperties($db, $_SESSION['username']);
            }
        }

        static function getCurrentUserName()
        {
            if (isset($_SESSION['username']))
            {
                return $_SESSION['username'];
            }
            else
            {
                return "Gast";
            }
        }

        static function isAnybodyThere()
        {   // check if session username + uid is set
            if (isset($_SESSION['username']) && isset($_SESSION['uid']))
            {   // check if session logged_in status is true
                if ($_SESSION['logged_in'] == true)
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

        static function getUserTemplateID($db, $uid)
        {   /* @var $db \YAWK\db */
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
                        return false;
                    }
            }
            else
                {
                    return false;
                }
        }

        public function isAllowedToOverrideTemplate($db, $uid)
        {   /* @var $db \YAWK\db */
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
                        return false;
                    }
            }
            else
            {
                return false;
            }
        }

        public function setUserTemplate($db, $overrideTemplate, $userTemplateID, $uid)
        {   /* @var $db \YAWK\db */
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
                    return false;
                }
        }

        public function isTemplateEqual($db, $userTemplateID)
        {
            /* @var $db \YAWK\db */
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

        static function getLoginData($db, $user)
        {   /* @var $db \YAWK\db */
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
                    return false;
                }
        }

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

        function getUserArray($db)
        {
            /* @var $db \YAWK\db */
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
            /* @var $db \YAWK\db */
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
                echo \YAWK\alert::draw("danger", "Error", "Sorry, database error: fetch getLatestUsers failed.","page=users","4800");
            }
            return $userDataArray;
        }

        static function countUsers($db)
        {
            /* @var $db \YAWK\db */
            if ($result = $db->query("SELECT count(id) FROM {users}"))
            {
                $i = mysqli_fetch_row($result);
                return $i[0];
            }
            else
            {
                return false;
            }
        }

        function getAllUserData($db)
        {
        /* @var $db \YAWK\db */
        if ($result = $db->query("SELECT * FROM {users} LIMIT 3"))
        {
            $userDataArray = array();
            // cycle trough results
            while ($row = $result->fetch_assoc()){
                $userDataArray[] = $row;
            }
            /* free result set */
            $result->close();
        }
        else {
            $userDataArray = '';
            echo \YAWK\alert::draw("danger", "Error", "Sorry, database error: fetch getAllUserData failed.","page=users","4800");
        }
        return $userDataArray;
        } // ./getUserList

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
                    \YAWK\alert::draw("warning","Warning!","Load settings for user $username failed.","","4800");
                    return false;
                }
            }
            else
            {   // q failed
                \YAWK\alert::draw("danger","Error!","Could not select data for user $user from database...","","4800");
                return false;
            }
            return true;
        }

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
                \YAWK\alert::draw("danger","Error!","Could not get property $property","","4800");
                return false;
            }
        }

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

        static function getUserNameFromID($db, $uid)
        {
            /** @var $db \YAWK\db */
            if ($res = $db->query("SELECT username
	                                FROM {users}
	                                WHERE id = $uid"))
            {
                $row = $res->fetch_row();
                return $row[0];
            }
            // q failed
            return false;
        }

        static function getIdfromName($db, $user)
        {
            /** @var $db \YAWK\db */
            if ($res = $db->query("SELECT id
	                                FROM {users}
	                                WHERE username = '".$user."'"))
            {
                $row = $res->fetch_row();
                return $row[0];
            }
            // q failed
            return false;
        }

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
                    \YAWK\alert::draw("warning","Warning","Could not fetch id and/or value from user groups database.","","4800");
                    return false;
                }
            }
            else
            {   // q failed, throw error
                \YAWK\alert::draw("warning","Warning","Could not select id and/or value from user groups database.","","4800");
                return false;
            }
        }

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

        static function getUserImage($location, $user, $cssClass, $w, $h)
        {
            if (isset($w) && isset($h))
            {
                if ($w === 0)
                {
                    $width = '';
                }
                else
                {
                    $width = "width=\"$w\" ";
                }
                if ($h === 0)
                {
                    $height = '0';
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
                                        gid = '" . $this->gid . "'
                      WHERE id = '" . $this->id . "'"))
            {
                \YAWK\alert::draw("success", "Success!", "User $this->username updated.","","1200");
                return true;
            }
            else
            {   // q failed
                \YAWK\alert::draw("warning", "Error!", "User status could not be changed, please try again.","","4800");
                return false;
            }
        }

        function toggleOffline($db, $id, $blocked)
        {   /** @var $db \YAWK\db */
            // TOGGLE PAGE STATUS
            if (!$res = $db->query("UPDATE {users}
                          SET blocked = '" . $blocked . "'
                          WHERE id = '" . $id . "'"))
            {
                // q failed
                return false;
            }
            else
            {   // toggle successful
                return true;
            }
        }

        static function getUserEmail($db, $user)
        {   /** @var $db \YAWK\db $res */
            if ($res = $db->query("SELECT email
                              FROM {users}
                              WHERE username = '" . $user. "'"))
            {   // fetch data
                $row = $res->fetch_row();
                return $row[0];
            }
            else
            {
                // q failed
                return false;
            }
        }

        static function create($db, $username, $password1, $password2, $email, $url, $twitter, $facebook, $firstname, $lastname, $street, $zipcode, $city, $country, $blocked, $privacy, $job, $gid)
        {   /** @var $db \YAWK\db */
            $date_created = date("Y-m-d G:i:s");
            // select maxID
            if ($res = $db->query("SELECT MAX(id) FROM {users}"))
            {   // add 1 to ID
                $row = mysqli_fetch_row($res);
                $id = $row[0] + 1;
            }
            // lowercase username
            $username = mb_strtolower($username);

            if ($username === "administrator" xor $username === "admin" or $username === "root")
            {   // forbidden username, throw error
                \YAWK\alert::draw("danger","Warning!","This username is not allowed!","page=user-new","4800");
                exit;
            }

            // prepare password
            $password1 = htmlentities($password1);
            $password2 = htmlentities($password2);
            // check password
            if ($password1 == $password2)
            {
                $password = $password1;
                $password = md5($password);
                // vermeidung doppelter user
                if ($res = $db->query("SELECT username FROM {users} WHERE username='" . $username . "'"))
                {
                    $row = mysqli_fetch_row($res); // wenn pwd gleich wie db, dann db wert
                    if ($row[0]) {
                        \YAWK\alert::draw("danger","Warning!","Please choose another username!","page=user-new","4800");
                        exit;
                    }
                }
                else {
                    \YAWK\alert::draw("danger","Warning!","Could not fetch username! Database error?","page=user-new","4800");
                    exit;
                }
                // prepare vars
                $twitter = htmlentities($_POST['twitter']);
                $facebook = htmlentities($_POST['facebook']);
                $firstname = htmlentities($_POST['firstname']);
                $lastname = htmlentities($_POST['lastname']);
                $street = htmlentities($_POST['street']);
                $zipcode = htmlentities($_POST['zipcode']);
                $city = htmlentities($_POST['city']);
                $country = htmlentities($_POST['country']);
                $job = htmlentities($job);
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
            } // passwords do not match
            else
            {   //
                \YAWK\alert::draw("warning", "Warning!", "Passwords do not match!", "page=user-new", "4800");
                exit;
            }
        }

        static function createFromFrontend($db, $username, $password1, $password2, $email, $gid)
        {   /** @var $db \YAWK\db */
            if (empty($username) || (empty($password1) || (empty($password2) || (empty($email) || (empty($gid))))))
            {
                echo \YAWK\alert::draw("danger", "Fehler!", "Fehlende Daten. Bitte f&uuml;ll das Formular vollst&auml;ndig aus. ","",4200);
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
                    \YAWK\alert::draw("danger", "Error!", "Error registering username. Exit with empty result.","","");
                    echo \YAWK\PLUGINS\SIGNUP\signup::signUp($db);
                }
            }
            else
            {   // passwords do not match
                // in that case throw error & draw form again...
                \YAWK\alert::draw("danger", "Error!", "Passwords mismatch! Please try again.","","");
                echo \YAWK\PLUGINS\SIGNUP\signup::signUp($db);
                exit;
            }
            echo \YAWK\alert::draw("danger", "Error!", "Something strange has happend. Code (000)","","");
            return false;
        }

        static function delete($db, $user)
        {   /** @var $db \YAWK\db */
            if ($res = $db->query("DELETE FROM {users} WHERE username = '" . $user . "'"))
            {
                return true;
            }
            else
            {
                return false;
            }
        }

        function checkPassword($db, $username, $password)
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
                        echo "<div class=\"container bg-danger\"><br><h2>We're Sorry! <small>Your Account is blocked.</h2><b>If you think
                        this is a mistake, contact the admin via email: </b>(<a class=\"text-danger\" href=\"mailto:$adminEmail\">$adminEmail</a>)
                        <b>for further information.</b><br><small>You will be redirected to <a class=\"small\" href=\"$host\">$host</a> in a few seconds.</small><br><br></div>";
                        \YAWK\sys::setTimeout("index.html", 30000);
                        return false;
                    }
                }
                if(isset($res['terminatedByUser'])){ // is user has canceled his account
                    if ($res['terminatedByUser']==='1'){ // check if user is
                        echo "<div class=\"container bg-danger\"><br><h2>We're Sorry! <small>This account does not exist.</h2><b>If you think
                        this is a mistake, contact the admin via email: </b>(<a class=\"text-danger\" href=\"mailto:$adminEmail\">$adminEmail</a>)
                        <b>.</b><br><small>You will be redirected to <a class=\"small\" href=\"$host\">$host</a> in a few seconds.</small><br><br></div>";
                        \YAWK\sys::setTimeout("index.html", 30000);
                        return false;
                    }
                }
                // username + pwd match, user is not blocked, not terminated...
                return true;
            }
            else {
                // checkPassword failed
                echo "<div class=\"container bg-danger\"><br><h2>Warning! <small>Login failed!</h2>
                <b>Please check your login credentials and try again in a few seconds.</b>
                <br><small>You will be redirected to <a class=\"small\" href=\"$host\">$host</a>.</small><br><br></div>";
                \YAWK\sys::setTimeout("index.html", 10000);
                return false;
            }
        }

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
                return false;
            }
        }

        static function checkLogin($db)
        {   /** @var $db \YAWK\db */
            /* check user login */
            $user = new \YAWK\user();
            if(isset($_POST['user']) && isset($_POST['password'])) {
                if($user->login($db, $_POST['user'],$_POST['password']))
                {   // create session var
                    $user->storeLogin($db, 0, "backend", $_POST['user'], $_POST['password']);
                    return true;
                }
                else
                {   // if username or pwd is wrong
                    $user->storeLogin($db, 1, "backend", $_POST['user'], $_POST['password']);
                    // \YAWK\alert::draw("warning","Warning:","<b>Login failed.</b> Please check login data and try again. Please wait, you will be redirected in 5 Seconds...","index.php","5000");
                    return false;
                }
            }
            else
            {   // username or password not set
                return false;
            }
        }

        function login($db, $username, $password)
        {   /** @var $db \YAWK\db */
            if (empty($username && $password)){
                echo "<div class=\"container bg-danger\"><br><h2><i class=\"fa fa-refresh fa-spin fa-fw\"></i>
                  <span class=\"sr-only\">Loading...</span> Oops! <small>
                  Missing login data...</small></h2><b>Please enter username and password.</b><br><br></div>";
                return false;
            }
            if (empty($username || $password)){
                echo "<div class=\"container bg-danger\"><br><h2><i class=\"fa fa-refresh fa-spin fa-fw\"></i>
                  <span class=\"sr-only\">Loading...</span> Oops! <small>
                  Missing login data...</small></h2><b>Please enter username and password.</b><br><br></div>";
                return false;
            }

            $date_now = date("Y-m-d G:i:s");
            $this->username = strip_tags($username);
            $password = strip_tags($password);
            $password = $db->quote(trim($password));
            $this->username = $db->quote(trim($this->username));
            $_SESSION['username'] = $this->username;
            $username = $this->username;
            if ($this->checkPassword($db, $username, $password)) {
               // return true;
                /* select and add login_count */
                $res = $db->query("SELECT id, login_count, gid FROM {users} WHERE username='" . $username . "'");
                $row = mysqli_fetch_row($res);
                $_SESSION['uid'] = $row[0];
                $_SESSION['gid'] = $row[2];
                $login_count = $row[1] + 1;
                $this->username = $username;
                // datum + login count aktualisieren
                $date_now = date("Y-m-d G:i:s");
                if (!$res = $db->query("UPDATE {users} SET
                                        date_lastlogin = '" . $date_now . "',
                                        login_count = '" . $login_count . "',
                                        online = '1',
                                        logged_in = '1'
                      WHERE username = '" . $this->username . "'"))
                {
                    echo "<div class=\"container bg-danger\"><br><h2><i class=\"fa fa-refresh fa-spin fa-fw\"></i>
                          <span class=\"sr-only\">Warning!</span> <small>Database Error! Missing login data...</small></h2><br>
                          <b>Could not log user into database. Expect some errors.</b><br><br></div>";
                    return false;
                }
                else {
                   // session_regenerate_id();
                    $_SESSION['username'] = $this->username;
                    $_SESSION['logged_in'] = true;
                    $this->storeLogin($db, 0, "frontend", $username, $password);
                }
                return true;
            } else {
                \YAWK\alert::draw("warning", "Login failed...", "Please try to re-login in a few seconds...", "",3000);
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
                        echo \YAWK\alert::draw("warning", "Error!", "Could not log user into database. Expect some errors.","","3800");
                    }
                    else
                    {   // avoid fake session ID
                        session_regenerate_id();
                        $_SESSION['logged_in'] = true;
                    }
                    return true;
                }
                else
                {  // user aint got the rights to login to backend

                }
            } // wrong password given
            else { // kick it back
                /** LOG FAILED LOGIN ....*/
                if (!isset($_SESSION['failed'])){
                    $_SESSION['failed']++;
                    \YAWK\alert::draw("danger", "Login failed!", "Please check your login data and try to re-login in <span id=\"timer\"></span> seconds!","","6000");
                    // \YAWK\alert::draw("danger", "Login failed!", "Please check your login data and try again.", "", 6000);
                    $this->storeLogin($db, 0, "backend", $username, $password);
                }
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

        function storeLogin($db, $failed, $location, $username, $password)
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
            $ip = $_SERVER['REMOTE_ADDR'];
            $useragent = $_SERVER['HTTP_USER_AGENT'];
            $res = $db->query("INSERT INTO {logins}
                (datetime, location, failed, ip, useragent, username, password)
                VALUES ('".$atm."', '".$location."', '".$failed."', '".$ip."', '".$useragent."', '".$username."', '".$password."') ");
            if ($res){ return true; }
            else { return false; }
        }


        static function drawLoginBox($username, $password){
            $html = "<div class=\"row\">
            <div class=\"col-md-4\">&nbsp;</div>
            <div class=\"col-md-4\"><form name=\"login\" role=\"form\" action=\"welcome.html\" method=\"POST\">
                <input type=\"text\" id=\"user\" name=\"user\" value=\"".$username."\" class=\"form-control\" placeholder=\"Benutzername\">
                <input type=\"password\" id=\"password\" name=\"password\" value=\"".$password."\" class=\"form-control\" placeholder=\"Passwort\">
                <input type=\"hidden\" name=\"login\" value=\"login\">
                <input type=\"submit\" value=\"Sign&nbsp;in\" name=\"Login\" class=\"btn btn-success\" class=\"form-control\">
            </form></div>
            <div class=\"col-md-4\">&nbsp;</div>
            </div>";
            return $html;
        }

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

        public function logout($db)
        {   /** @var $db \YAWK\db */
            // set user offline in db
            if (isset($_SESSION['username']))
            {   // if username is set in session var, logout
                if (!$res = $db->query("UPDATE {users}
                                   SET online = '0'
                                   WHERE username = '".$_SESSION['username']."'"))
                {
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
                    return true;
                }
            }
            else
            {
                // DELETE SESSION
                $_SESSION['failed']=0;
                $_SESSION['logged_in']=0;
                session_destroy();
                return true;
            }
        }

        /** GET USER LIST */

        static function getUserList($db)
        {   /* @var \YAWK\db $db */
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


        /** +++++ NEW FUNCTIONS +++++ */

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
                return false;
            }
        }

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
                return false;
            }
        }

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
                return false;
            }
        }

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
                return false;
            }
        }

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
                return false;
            }
        }

        static function getAllNotifications($db)
        {   /** @var $db \YAWK\db */
            if (isset($_GET['page']) && ($_GET['page'] === "syslog"))
            {   // is call comes from syslog backend page,
                // empty where clause to select all data from db
                $where = '';
            }
            else
            {   // call comes from notification menum just select all unread data
                $where = "WHERE log.seen = '0'";
            }

            if ($sql = $db->query("SELECT * FROM {syslog} AS log
                                       LEFT JOIN {syslog_types} AS types ON log.log_type=types.id
                                       LEFT JOIN {users} AS u ON log.fromUID=u.id
                                       $where
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
                return false;
            }
        }

        static function getMyNotifications($db, $uid)
        {   /** @var $db \YAWK\db */
            if ($sql = $db->query("SELECT * FROM {notifications} AS log
                                       LEFT JOIN {syslog_types} AS types ON log.log_type=types.id
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
                return false;
            }
        }

        static function countMyFollowers($db, $uid)
        {   /** @var $db \YAWK\db */
            if ($sql = $db->query("SELECT count(id) FROM {follower} WHERE hunted = '".$uid."'"))
            {   // count + return data
                $row = mysqli_fetch_row($sql);
                return $row[0];
            }
            else
            {   // q failed
                return false;
            }
        }

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
                return false;
            }
        }

        static function getMyFriends($db, $uid, $confirmed)
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
                return false;
            }
        }

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
                return false;
            }
        }

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
                return false;
            }
        }

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
                return false;
            }
        }

    } // ./ class user
} // ./ namespace