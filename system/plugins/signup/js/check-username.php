<?php
/* check if email is already registered */
if (!empty($_POST['newUsername']))
{
    include '../../../classes/db.php';
    $db = new \YAWK\db();
    $request = $db->quote($_POST['newUsername']);
    if ($res = $db->query("SELECT username FROM {users} WHERE username = '".$request."'"))
    {   // fetch data
        $res = mysqli_fetch_row($sql);
        if($res[0])
        {   // count result
            $i = count($res[0]);
            if ($i === 0)
            {   // username is free and not yet registered
                echo "false"; die;
            }
            else
            {   // username is already in database
                echo "true"; die;
            }
        }
        else
        {   // username is already in database
            echo "true"; die;
        }
    }
    else
    {   // q failed
        echo "true"; die;
    }
}
else
{   // get var is invalid
    echo "true";
}