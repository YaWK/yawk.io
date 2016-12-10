<?php
/**
 * Copyright (C) Daniel Retzl
 */
require_once '../../../classes/email.php';
if (isset($_GET['email']))
{   // if no db object is set
    if (!isset($db))
    {   // include database
        require_once '../../../classes/db.php';
        $db = new \YAWK\db();
    }
    $email = $_GET['email'];
    if ($db->query("INSERT INTO {users} (username, email) VALUES('" . $email . "','" . $email . "'"))
    {
       echo "true";
    }
}