<?php
session_start();
if(isset($_SESSION)){
    if (isset($_SESSION['uid']) && (!empty($_SESSION['uid']))){
        // include db connection
        include '../../../dbconnect.php';
        // escape var
        $request = mysqli_real_escape_string($connection, $_SESSION['uid']);
        // do update query: block user
        $sql = mysqli_query($connection, "UPDATE ".$dbprefix."users SET blocked = 1 WHERE id = '".$request."'");
        if($sql)
        {
            echo "true"; die; // blocked user successfully
        }
        else
        {
            echo "false"; die; // something went wrong when updating db
        }
    }
    else {
        echo "Session is set, but user #id is missing or empty.";
    }
    echo "Session is set, but sorry, it looks like IF we got a problem here..."; die;
}
else {
    echo "Session not set, please re-login!"; die;
}