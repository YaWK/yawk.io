<?php
header('Content-Type: application/json'); // Set the header for the content type to JSON
include '../../system/classes/db.php'; // include the settings class
include '../../system/classes/settings.php'; // include the settings class
use YAWK\settings;
// database object
if (!isset($db))
{   // create new db obj if none exists
    $db = new YAWK\db();
}
    // Set the API key and the API URL
    $apiKey = settings::getSetting($db, "openAIApiKey");
    $apiUrl = 'https://api.openai.com/v1/chat/completions';

// Create a new cURL resource
$ch = curl_init($apiUrl);

// this is just a test request to see if it works.

// Get JSON as a string
$json_str = file_get_contents('php://input');

// Decode the JSON string into PHP array
$json_obj = json_decode($json_str, true);

// Now you can access your data
$content = $json_obj['prompt'];
$max_tokens = $json_obj['max_tokens'] ?? 60; // Use default if not set
$model = $json_obj['model'] ?? 'gpt-3.5-turbo'; // Use default if not set
$role = $json_obj['role'] ?? 'user'; // Use default if not set
$temperature = $json_obj['temperature'] ?? '0.8'; // Use default if not set

// Setup request to send json via POST
$payload = json_encode([
    'model' => $model,  // desired model
    'messages' => [
        ['role' => $role, 'content' => $content] // the prompt message
    ],
    // 'max_tokens' => 60 // desired max token amount per response
    'max_tokens' => (int)$max_tokens, // Use dynamic max tokens
    'temperature' => (float)$temperature, // Use dynamic temp
]);

// Attach encoded JSON string to the POST fields
curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);

// Set the content type to application/json
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Content-Type:application/json',
    'Authorization: Bearer ' . $apiKey // Your API key
));

// Return response instead of outputting
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// Execute the POST request
$result = curl_exec($ch);

// Close cURL resource
curl_close($ch);

    // If cURL returns an error
    if (curl_errno($ch))
    {   // print the curl error message
        echo 'cURL error: ' . curl_error($ch);
    }
    else
    {   // Decode the response to check for errors or malformed data
        $response = json_decode($result, true);

        // Check if the JSON decoding was successful
        if (json_last_error() === JSON_ERROR_NONE) {
            // print the JSON result coming from the API
            echo $result;
        }
        else // If JSON decoding fails for any reason during the API request e.g. invalid JSON
        {   // print the error message
            echo 'JSON decode error: ' . json_last_error_msg();
        }
    }


?>