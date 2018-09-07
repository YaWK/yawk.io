<?php
// start a new session
session_start();
// include required classes
require_once '../../../classes/db.php';
require_once '../../../classes/alert.php';
require_once '../../../classes/sys.php';

// check if database is set
if (!isset($db) || (empty($db)))
{   // create new db object
    $db = new \YAWK\db();
}

// get current datetime
$now = \YAWK\sys::now();

// check name data
if (!isset($_POST['name']) || (empty($_POST['name'])))
{   // name is not set, leave empty
    $name = "";
}
//  name is set
else
{   // check if it is a string
    if (is_string($_POST['name']))
    {   // email seems to be valid
        $name = $_POST['name'];
        // remove html tags
        $name = strip_tags($name);
        // quote data
        $name = $db->quote($name);
    }
    else
        {
            $name = '';
        }
}

// check email data
 if (!isset($_POST['email']) || (empty($_POST['email'])))
{   // email is not set or empty
    echo "false";
}

//  email is set
else
    {   // validate it
        if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))
        {   // email seems to be valid
            $email = $_POST['email'];
            // remove html tags
            $email = strip_tags($email);
            // quote data
            $email = $db->quote($email);

            // insert data into database
            if ($db->query("INSERT INTO {newsletter} (date_created, name, email) VALUES('".$now."', '".$name."', '".$email."')"))
            {
                echo "true";
            }
            else
            {
                echo "false";
            }
        }
        else
            {
                echo "false";
            }
    }

