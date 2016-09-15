<?php
/* check if email is already registered */
if (!empty($_POST['email']))
{
    include '../../../classes/db.php';
    $db = new \YAWK\db();
    $request = $db->quote($_POST['email']);
    if ($res = $db->query("SELECT email FROM {users} WHERE email = '".$request."'"))
    {
        $result = mysqli_fetch_row($res);
        if($result[0])
        {
            echo "false"; die; // email not in use yet
        }
        else
        {
            echo "true"; die; // email is already in db
        }
    }
    else
    {   // q failed
        echo "true"; die;
    }
}
else
{
    echo "true"; // get var is invalid
}