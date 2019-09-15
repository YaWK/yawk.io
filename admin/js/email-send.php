<?php
echo "hello!";
echo "<pre>";
print_r($_FILES);
echo "</pre>";
echo "world<br>";



$uploadDir = "../../media/mailbox";
if (!empty($_FILES)) {
    echo "if erfüllt<br>";
    foreach ($_FILES["files"]["tmp_name"] as $key => $error)
    {
        echo "attachment $key<br>";
        if ($error == UPLOAD_ERR_OK)
        {
            $tmp_name = $_FILES["files"]["tmp_name"][$key];
            // basename() kann Directory-Traversal-Angriffe verhindern;
            // weitere Validierung/Bereinigung des Dateinamens kann angebracht sein
            $name = basename($_FILES["files"]["name"][$key]);
            if (move_uploaded_file($tmp_name, "$uploadDir/$name") == true)
            {
                echo "YEP!";
            }
            else
                {
                    "NOPE";
                }
            echo "processed: ".$_FILES["files"]["name"]["$key"]."<br>";
        }
        else
            {
                echo "Unable to upload - errocode: ".$error;
            }
    }
}
else

    {
        echo "files array is empty...";
    }

/*
include '../../system/classes/db.php';
include '../../system/classes/sys.php';
include '../../system/classes/alert.php';
include '../../system/classes/settings.php';
*/
// get all webmail setting values into an array
// $webmailSettings = \YAWK\settings::getValueSettingsArray($db, "webmail_");

/*
echo "<pre>";
print_r($_POST);
print_r($_FILES);
echo "</pre>";
*/
