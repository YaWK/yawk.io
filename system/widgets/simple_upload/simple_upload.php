<?php
/** @var $db \YAWK\db */
/*
if (!isset($simpleUpload))
{   // load gallery widget class
    require_once 'classes/simpleUpload.php';
    // create new gallery widget object
    $simpleUpload = new \YAWK\WIDGETS\SIMPLEUPLOAD\UPLOAD\simpleUpload($db);
}
// init example widget
$simpleUpload->init();
exit;
*/

/* #######################
simple_upload.php
A SIMPLE UPLOAD WIDGET */

// init vars (widget defaults) 
$target_path = "/var/www/YaWK-dev/media/uploads/";
$max_file_size = 20000000; // max filesize 20 MBytes (2000000 = 2 | 20000000 = 20 | 200000000 = 200)
$host = \YAWK\settings::getSetting($db, "host");

if (isset($_POST['upload']) && $_POST['upload'] === "sent") {
// set full target path including filename 
$target_path = $target_path . basename( $_FILES['uploadedfile']['name']); 

if(move_uploaded_file($_FILES['uploadedfile']['tmp_name'], $target_path)) {
    echo "The file ".  basename( $_FILES['uploadedfile']['name']). 
    " has been uploaded: As you see...";
    	echo "<img src=/YaWK-dev/media/uploads/";echo basename( $_FILES['uploadedfile']['name']);echo">";
    	echo "<br><br><a href=\"$host\">back</a>";
    	exit;
    	// if file could not be uploaded...
} else{
    echo "There was an error uploading the file, please try again!";
	 echo "<br><br><a href=\"$host\">back</a>";
    exit;
    
}
// exit;
}


?>
<div>
<form enctype="multipart/form-data" action="system/widgets/simple_upload/simple_upload.php" method="POST">
<input type="hidden" name="MAX_FILE_SIZE" value="<? print $max_file_size; ?>" />
<input type="hidden" name="upload" value="sent" />
Choose a file to upload: <input name="uploadedfile" type="file" />
	
<input type="submit" value="Upload&nbsp;File" />
</form>
</div>