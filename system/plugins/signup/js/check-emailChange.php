<?php
/* check if email is already registered */
if (!empty($_POST['newEmail']))
{
    include '../../../classes/db.php';
    $db = new \YAWK\db();
    $request = $db->quote($_POST['newEmail']);
    if ($res = $db->query("SELECT email FROM {users} WHERE email = '".$request."'"))
    {   // fetch data
        $result = mysqli_fetch_row($res);
        if($result[0])
        {   // email found
            $address_found = count($res[0]);
            if ($address_found == 0)
            {
                echo "true";
                die; // email just found 1 time, that appears to be users' email
                // so the email seems to be valid.
            }
            else
            {
                echo "false";
                die; // email not in use
            }
        }
    }
}/*
else
{   // get var is invalid
    echo "false";
}
*/