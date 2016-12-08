<script type="text/javascript" src="system/engines/jquery/jquery.validate.min.js"></script>
<script type="text/javascript" src="system/engines/jquery/messages_en.min.js"></script>
<script type="text/javascript" src="system/engines/jquery/notify/bootstrap-notify.min.js"></script>
<!-- <script type="text/javascript" src="system/plugins/signup/js/signup.js"></script> !-->
<link rel="stylesheet" href="system/engines/animateCSS/animate.min.css">
<?php
/** SIGNUP PLUGIN */
require_once 'system/plugins/signup/classes/signup.php';
require_once 'system/classes/backend.php';
$signup = new \YAWK\PLUGINS\SIGNUP\signup();
// if settings update is sent from frontend
if (isset($_POST['settings-update']) && $_POST['settings-update'] === '1')
{   // check if user id is sent
    if (isset($_POST['uid']) && is_numeric($_POST['uid']))
    {   // user id is set, datatype seems to be correct,
        foreach ($_POST as $property => $value)
        {   // process every property in a loop
            $value = \YAWK\sys::encodeChars($value);    // encode chars (&Ouml, &Auml...)
            if ($property != "settings-update"
                && ($property != "sent")
                && ($property != "submit")
                && ($property != "newUsername")
                && ($property != "profile-update")
                && ($property != "newEmail")
                && ($property != "newPassword1")
                && ($property != "newPassword2")
                && (!empty($value)))
            {   // set new user property
               // echo "<h1>$property <small>$value</small></h1>";
                \YAWK\user::setProperty($db, $_POST['uid'], $property, $value);
            }
            // store new user password
            else if ($property = "newPassword2")
            {   // if a new paswword is set
                if (!empty($_POST['newPassword2']))
                {   // if it's not empty
                    $newPassword = $db->quote($_POST['newPassword2']);
                    // create a new md5'ed password
                    \YAWK\user::setProperty($db, $_POST['uid'], "password", md5($newPassword));
                }
            }
            // store new user password
            else if ($property = "newEmail")
            {   // if a new paswword is set
                if (!empty($_POST['newEmail']))
                {   // if it's not empty
                    $newEmail = $db->quote($_POST['newEmail']);
                    // create a new md5'ed password
                    \YAWK\user::setProperty($db, $_POST['uid'], "email", $newEmail);
                }
            }
            // store new user password
            else if ($property = "newUsername")
            {   // if a new paswword is set
                if (!empty($_POST['newUsername']))
                {   // if it's not empty
                    $newUsername = $db->quote($_POST['newUsername']);
                    // create a new md5'ed password
                    \YAWK\user::setProperty($db, $_POST['uid'], "username", $newUsername);
                }
            }
            // store privacy settings
            else if ($property = "privacy")
            {   // if a new paswword is set
                if (!empty($_POST['privacy']))
                {   // if it's not empty
                    $privacy = $db->quote($_POST['privacy']);
                    \YAWK\user::setProperty($db, $_POST['uid'], "privacy", $privacy);
                }
            }
            // store new user password
            else if ($property = "public_email")
            {   // if a new paswword is set
                if (!empty($_POST['public_email']))
                {   // if it's not empty
                    $publicEmail = $db->quote($_POST['public_email']);
                    \YAWK\user::setProperty($db, $_POST['uid'], "public_email", $publicEmail);
                }
            }
        }
    }
    else
    {   // user id is not set or type is not numeric...
        \YAWK\backend::drawContentWrapper();
        \YAWK\alert::draw("danger", "Error", "Could not update user settings because User ID is missing or wrong type.", "","");
        echo $signup->sayHello($db);
    }
} // ./ if settings-update === true

// if form is sent
if (isset($_POST['sent']) && $_POST['sent'] === '1')
{
    // prepare vars
    $username = $db->quote($_POST['username']);
    $password1 = $db->quote($_POST['password1']);
    $password2 = $db->quote($_POST['password2']);
    $email = $db->quote($_POST['email']);

    if (isset($_POST['gid']))
    {   // if user is allowed to select user group
        $gid = $_POST['gid'];
    }
    else
    {   // get default user group id from settings
        $gid = \YAWK\settings::getSetting($db, "signup_defaultgid");
        if (empty($gid))
        {   // could not fetch group id, throw error
            \YAWK\alert::draw("warning", "Warning!", "Error fetching group ID settings. Default Group set to 2","","");
            $gid = 2;
        }
    }
    // execute create user function
    if(\YAWK\user::createFromFrontend($db, $username, $password1, $password2, $email, $gid))
    {   // draw thank you page...
        // \YAWK\backend::drawContentWrapper();
        echo "<div style='text-align: center; margin-top: 20%; margin-bottom: 600px;'>
        <h1>Hello ".$username."!<br><small>Thank you for your registration.</small></h1>
        <p>Please, feel free to instant login! <br>";
        echo \YAWK\user::drawLoginBox($username, $password1);
    }
    else
    {   // create user failed, so throw error
        // YAWK\backend::drawContentWrapper();
        print \YAWK\alert::draw("danger", "Fehler!", "The User <strong>".$username."</strong> could not be registered!","","");
        // and display user registration form again...
        echo $signup->sayHello($db);
    }
}
else
{   // default view:
    // draw user signup form
    // \YAWK\backend::drawContentWrapper();
    echo $signup->sayHello($db);
}