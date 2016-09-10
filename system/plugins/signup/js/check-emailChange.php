<?php
/* check if email is already registered */
if (!empty($_POST['email']))
{
    include '../../../classes/db.php';
    $request = $db->quote($_POST['email']);
    if ($res = $db->query("SELECT email FROM {users} WHERE email = '".$request."'"))
    {   // fetch data
        $result = mysqli_fetch_row($res);
        if($result[0])
        {   // email found
            $emails_found = count($res[0]);
            if ($emails_found <= 2)
            {
                echo "false";
                die; // email just found 1 time, that appears to be users' email
                // so the email seems to be valid.
            }
            else
            {
                echo "true";
                die; // email not in use
            }
        }
        else
        {   // email is already in db
            echo "true"; die;
        }
    }
}
else
{   // get var is invalid
    echo "false";
}