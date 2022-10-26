<?php
namespace YAWK
{
    /**
     * @details The Controller Class.
     *
     * <p>Controller filter and return filename</p>
     *
     * @author     Daniel Retzl <danielretzl@gmail.com>
     * @copyright  2009-2016 Daniel Retzl yawk.io
     * @license    https://opensource.org/licenses/MIT
     * @version    1.0.0
     * @brief The controller function returns filtered filename as string (or null).
     */
    class controller
    {
        /**
         * @details  TODO: outdated try to outsource the frontend init from admin/index.php (failed)
         * @details this could be deleted.
         * @param $db db
         * @param $currentpage \YAWK\page
         * @brief INIT FRONTEND STARTS HERE
         */
        public static function frontEndInit($db, $currentpage, $user, $template)
        {

            // check whether the system is actually in maintenance mode

        }

        /** * @param string the filename to filter */
        public $filename;

        function __construct()
        {
        }


        /**
         * @brief Main filter controller: checks GET params and lead to corresponding actions
         * @param $db
         * @param $lang
         * @param $filename
         * @return false|string
         * @details This is used whether to detect that users wants to reset password, load a page or delegate any other action
         */
        public static function filterfilename($db, $lang, $filename)
        {
            // check if user wants to reset password
            if (isset($_GET['resetPassword']) && ($_GET['resetPassword']) == true)
            {
                if (isset($_GET['token']) && (is_string($_GET['token'])))
                {
                    // check if tokens match and returns the uid
                    $uid = user::checkResetToken($db, $_GET['token']);
                    // no uid
                    if ($uid == false)
                    {
                        // display password changing form...
                        echo "<div class=\"container-fluid\">
                    <div class=\"row text-center\">
                    <div class=\"col-md-12\"><b class=\"text-danger\"><br><br<b>$lang[PASSWORD_RESET_ERROR]</b>
                    <br><i>$lang[PASSWORD_RESET_ERROR_UID]</i>
                    <br><br></div></div>";
                        exit;
                    }
                    else
                    {
                        // display password changing form...
                        echo "<div class=\"container-fluid\">
                    <div class=\"row text-center\">
                    <div class=\"col-md-4\">&nbsp;</div>
                    <div class=\"col-md-4\"><br><br><h3>$lang[PASSWORD_RESET]<br>
                    <p class=\"small text-gray\">$lang[PASSWORD_REQUIREMENTS]</small></h3><hr>";
                        user::drawPasswordResetForm($db, $lang, $uid);
                        echo "<hr><br><br></div>
                    <div class=\"col-md-4\">&nbsp;</div></div>";
                        exit;
                    }
                }
                else
                {
                    die ($lang['PASSWORD_RESET_ERROR_TOKEN']);
                }
            }

            // check if new user password should be set
            if (isset($_GET['setNewPassword']) && ($_GET['setNewPassword'] == true))
            {
                // check if newPassword1 + newPassword2 are set, valid and equal...
                if (isset($_POST['newPassword1']) && (!empty($_POST['newPassword1']) && (is_string($_POST['newPassword1']))
                        && (isset($_POST['newPassword2']) && (!empty($_POST['newPassword2']) && (is_string($_POST['newPassword2']))
                                && ($_POST['newPassword1'] == $_POST['newPassword2'])))))
                {
                    // trim passwords
                    $_POST['newPassword1'] = trim($_POST['newPassword1']);
                    $_POST['newPassword2'] = trim($_POST['newPassword2']);
                    // strip html tags
                    $_POST['newPassword1'] = strip_tags($_POST['newPassword1']);
                    $_POST['newPassword2'] = strip_tags($_POST['newPassword2']);

                    // check if uid is set and valid
                    if (isset($_POST['uid']) && (!empty($_POST['uid']) && (is_numeric($_POST['uid']))))
                    {
                        // set new password
                        if (user::setNewPassword($db, $_POST['newPassword1'], $_POST['uid']) == true)
                        {   // password change successful...
                            // get username to pre-fill out the login form
                            $user = user::getUserNameFromID($db, $_POST['uid']);
                            // if username is NOT set correctly
                            if (!isset($user) || (empty($user)) || (!is_string($user)))
                            {   // no form pre-fill out
                                $user = '';
                            }

                            // display password changing form...
                            echo "<div class=\"container-fluid\">
                        <div class=\"row text-center\">
                        <div class=\"col-md-4\">&nbsp;</div>
                        <div class=\"col-md-4\"><br><br><h3>$lang[PASSWORD_CHANGED]<br>
                        <p class=\"small text-gray\">$lang[PASSWORD_CHANGED_LOGIN]</small></h3><hr></div></div>";
                            echo user::drawLoginBox("$user", $_POST['newPassword1']);
                            echo "<hr><br><br><br><br>";
                            exit;
                        }
                        else
                        {
                            // password could not be changed...
                            echo "<div class=\"container-fluid\">
                            <div class=\"row text-center\">
                            <div class=\"col-md-4\">&nbsp;</div>
                            <div class=\"col-md-4\"><br><br><h3>$lang[PASSWORD_CHANGED_ERROR]<br>
                            <p class=\"small text-gray\">$lang[PLEASE_TRY_AGAIN]</small></h3><hr>";
                            // draw reset form again
                            user::drawPasswordResetForm($db, $lang, $_POST['uid']);
                            echo "<br><br></div>
                            <div class=\"col-md-4\">&nbsp;</div></div>";
                            exit;
                        }
                    }
                    else
                    {   // user unknown, due this it is unable to handle this request
                        return false;
                    }
                }
                else
                {
                    // show reset form again if user enters no password
                    echo "<div class=\"container-fluid\">
                            <div class=\"row\">
                            <div class=\"col-md-4\">&nbsp;</div>
                            <div class=\"col-md-4 text-center\"><br><br><h3>$lang[PASSWORD_CHANGED_ERROR]<br>
                            <p class=\"small text-gray\">$lang[PLEASE_TRY_AGAIN]</small></h3><hr>
                            <br><br></div>
                            <div class=\"col-md-4\">&nbsp;</div></div>";
                    exit;
                }
            }

            // lower cases
            $filename = mb_strtolower($filename);
            // just numbers + chars are allowed, replace special chares,
            $filename = preg_replace("/[^.a-z0-9\-\/]/i", "", $filename);
            // trim filename and check if its empty
            if (trim($filename) === "")
            {   // if filename is empty, set index as default page
                $filename = "index";
            }
            if ($filename[0] === "/")
            {
                // remove prefix slash
                $filename = substr($filename, 1);
            }

            // append file extension
            $filename .= ".php";

            if ($filename == "content/pages/.php"){
                echo "<br><br><br><br>";
                die("Unable to display page - filename not set. output of \$filename: $filename");
            }

            // what if file not exists...
            if (!file_exists($filename))
            {
                // file does not exist, load 404 page
                $notfound = $filename." not found!";
                $filename = "content/errors/404.php";
                // check if call comes from frontend or backend
                if (file_exists($filename))
                {   // frontend success
                    return $filename;
                }
                else
                {
                    // call from backend, set path correctly
                    if (!isset($db)) { $db = new db(); }
                    sys::setSyslog($db, 4, 1, "404 ERROR $notfound", 0, 0, 0, 0);
                    return $filename;
                }
            }
            // return file
            return $filename;
        }
    } // ./ class controller
} // ./ namespace