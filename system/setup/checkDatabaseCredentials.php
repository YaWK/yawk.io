<?php


// Check if the request was made using the POST method
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the database credentials from the request body
    $host = $_POST['DB_HOST'];
    $username = $_POST['DB_USER'];
    $password = $_POST['DB_PASS'];
    $dbname = $_POST['DB_NAME'];

    try {
        // Try to connect to the database
        $db = new mysqli($host, $username, $password, $dbname);
        $response = array('success' => true, 'message' => 'connected!');

    } catch (Exception $e) {
            // Credentials are invalid, return an error message
            $response = array('error' => false, 'message' => 'Invalid database credentials');

    }


    // Send the response as JSON
    header('Content-Type: application/json');
    echo json_encode($response);
}



//if ($_POST['step'] == "3"){
//    if (isset($_POST['DB_HOST']) && isset($_POST['DB_USER']) && isset($_POST['DB_PASS']) && isset($_POST['DB_NAME'])){
//        try {
//            $db = new mysqli($_POST['DB_HOST'], $_POST['DB_USER'], $_POST['DB_PASS'], $_POST['DB_NAME']);
//            echo "Connected to MySQL";
//        } catch (Exception $e) {
//            echo "Failed to connect to MySQL: " . $e->getMessage();
//        }
//    }
//    else
//    {
//        echo "Some credentials were missing. Please fill in all the fields";
//    }
//}
//echo "<hr>";
//var_dump($_POST)."<br>";