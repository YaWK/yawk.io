<?php
/* check if email is already registered */
if (!empty($_POST['email']))
{
    include '../../../classes/db.php';
    $db = new \YAWK\db();
    $request = $db->quote($_POST['email']);
    $bookingTable = mysqli_query($db, "SELECT email FROM {plugin_booking} WHERE email = '".$request."' AND success = '1'");
    $userTable = mysqli_query($db, "SELECT email FROM {users] WHERE email = '".$request."'");
    $res = mysqli_fetch_row($bookingTable);
    if($res[0])
    {
        $res2 = mysqli_fetch_row($userTable);
        if (!$res2[0])
        {   // email not in use yet
            echo "true"; die;
        }
        else
        {   // email in use
            echo "false"; die;
        }
    }
    else
    {   // email adress is not a valid booking success entry
        echo "false"; die;
    }
}
else
{   // get var is invalid
    echo "false";
}