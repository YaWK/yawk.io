<?php
// Check if the request was made using the POST method
if ($_SERVER['REQUEST_METHOD'] === 'POST')
{   // prove given database credentials

    // check if DB_HOST is set
    if (!empty($_POST['DB_HOST']))
    {   // DB_HOST is set
        $host = $_POST['DB_HOST'];
    }
    else
    {   // DB_HOST is missing
        $response = array('error' => true, 'message' => 'DB_HOST is missing');
        $host = '';
    }

    // check if DB_USER is set
    if(!empty($_POST['DB_USER']))
    {   // DB_USER is set
        $username = $_POST['DB_USER'];
    }
    else
    {   // DB_USER is missing
        $response = array('error' => true, 'message' => 'DB_USER is missing');
        $username = '';
    }

    // check if DB_PASS is set
    if(!empty($_POST['DB_PASS']))
    {   // DB_PASS is set
        $password = $_POST['DB_PASS'];
    }
    else
    {   // DB_PASS is missing
        $response = array('error' => true, 'message' => 'DB_PASS is missing');
        $password = '';
    }

    // check if DB_NAME is set
    if (!empty($_POST['DB_NAME']))
    {   // DB_NAME is set
        $dbname = $_POST['DB_NAME'];
    }
    else
    {   // DB_NAME is missing
        $response = array('error' => true, 'message' => 'DB_NAME is missing');
        $dbname = '';
    }

    // check if DB_PORT is set
    if(!empty($_POST['DB_PORT']))
    {   // DB_PORT is set
        $port = $_POST['DB_PORT'];
    }
    else
    {   // DB_PORT is missing
        $response = array('error' => true, 'message' => 'DB_PORT is missing (default is 3306)');
        $port = 3306;
    }

    // try to successfully connect to the database
    try {
        // Create a new mysqli object with given database credentials
        $db = new \mysqli($host, $username, $password, $dbname, $port);
        $response = array('success' => true,
            'message' => ''.$_POST['DB_CHECK_TO'].' '.$dbname.' @ '.$host.' '.$_POST['DB_CHECK_EST'].'.',
            'subline' => $_POST['DB_CHECK_DATA'],
            'importmsg' => $_POST['DB_IMPORT_MSG'],
            'DB_IMPORT_BTN' => $_POST['DB_IMPORT_BTN']);
    }
    // failed to connect to the database
    catch (Exception $e)
    {       // Credentials are invalid, return an error message
            $response = array('error' => false,
                'message' => $_POST['DB_CHECK_FAILED'],
                'subline' => $e->getMessage(),
                'checkagain' => $_POST['DB_CHECK_AGAIN']);
    }

    // Send the response as JSON
    header('Content-Type: application/json');
    // Send the response
    echo json_encode($response);
}