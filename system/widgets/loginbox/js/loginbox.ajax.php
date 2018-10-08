<?php
// start a new session
session_start();
// include required classes
require_once '../../../classes/db.php';
require_once '../../../classes/sys.php';
require_once '../../../classes/user.php';
require_once '../../../classes/settings.php';

// check if database is set
if (!isset($db) || (empty($db)))
{   // create new db object
    $db = new \YAWK\db();
}

// check if user is set
if (!isset($user) || (empty($user)))
{   // create new user object
    $user = new \YAWK\user($db);
}

// check username data
if (!isset($_POST['user']) || (empty($_POST['user'])))
{   // name is not set echo false
    echo "false";
}
//  user is set...
else
{   // check if it is a string
    if (is_string($_POST['user']))
    {   // email seems to be valid
        $user = $_POST['user'];
        // remove html tags
        $user = strip_tags($user);
        // quote data
        $user = $db->quote($user);
    }
    else
        {   // name seems to be an invalid data type
            $result = array('status' => false);
            header('Content-type: application/json; charset=UTF-8');
            echo json_encode($result);
        }
}

// check password data
if (!isset($_POST['password']) || (empty($_POST['password'])))
{   // email is not set or empty
    $result = array('status' => false);
    header('Content-type: application/json; charset=UTF-8');
    echo json_encode($result);
}

//  password is set
else
    {   // validate it
        if (is_string($_POST['password']))
        {   // password seems to be a string
            $password = $_POST['password'];
            // quote data
            $password = $db->quote($password);
            // login user and check if login was successful
            if (\YAWK\user::ajaxLogin($db, $user, $password) == true)
            {   // login successful
                $result = array('status' => true);
                header('Content-type: application/json; charset=UTF-8');
                echo json_encode($result);
            }
            else
                {   // login failed
                    $result = array('status' => false);
                    header('Content-type: application/json; charset=UTF-8');
                    echo json_encode($result);
                }
        }
        else
            {   // password is not a string - login failed
                $result = array('status' => false);
                header('Content-type: application/json; charset=UTF-8');
                echo json_encode($result);
            }
    }
