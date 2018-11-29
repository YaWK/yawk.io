<?php
session_start();
if(isset($_SESSION)){
    if (isset($_SESSION['uid']) && (!empty($_SESSION['uid']))){
        // include db connection
        include '../../../classes/db.php';
        $db = new \YAWK\db();
        // escape var
        $request = $db->quote($_SESSION['uid']);
        // do update query: block user
        $sql = mysqli_query($db, "UPDATE {users} SET blocked = 1 WHERE id = '".$request."'");
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