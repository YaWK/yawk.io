<?php
use YAWK\db;
use YAWK\update;
use YAWK\settings;
include '../../system/classes/db.php';
include '../../system/classes/language.php';
include '../../system/classes/settings.php';
include '../../system/classes/update.php';
/* set database object */
if (!isset($db))
{   // create new db object
    $db = new db();
}
if (!isset($lang))
{   // create new language object
    $language = new YAWK\language();
    // init language
    $language->init($db, "backend");
    // convert object param to array !important
    $lang = (array) $language->lang;
}

// prepare vars
// get local (installed) filebase
$localFilebase = parse_ini_file('../../system/update/filebase.current.ini');
$updateFilesPath = '../../system/update/updateFiles.ini';

// generate new update object
$update = new update();
// get update filebase from server
$updateFilebase = $update->readUpdateFilebaseFromServer();
if (!is_array($updateFilebase)){
    echo 'ERROR READING UPDATE FILEBASE FROM SERVER! This should be reachable: https://www.yawk.io/system/update/filebase.current.ini';
}
// sort arrays by key (file path)
ksort($localFilebase);
ksort($updateFilebase, SORT_NATURAL);
// compare filebase arrays
// if file hash is different, add file to differentFiles array
$differentFiles = array();  // files with different hash values (those will be updated)
$localOnlyFiles = array();  // files only found in local filebase (files that were added by page admin, those will NOT be touched)
$updateFiles = '';  // files that will be updated

// loop through local filebase array (parsed from filebase.current.ini)
foreach ($localFilebase as $filePath => $localHash)
{   // check if file exists in update filebase
    if (isset($updateFilebase[$filePath]))
    {   // get hash from update filebase
        $updateHash = $updateFilebase[$filePath];
        // compare hashes
        if ($localHash !== $updateHash)
        {   // if hashes are different, add file to differentFiles array
            $differentFiles[] = $filePath;

            // add file to updateFiles string, which will be written to updateFiles.ini
            $updateFiles .= "$localHash=\"$filePath\"\n";
        }
    }
    else
    {   // if file is not found in update filebase, store file path in localOnlyFiles array
        $localOnlyFiles[] = $filePath;
    }
}

// response string, used to echoed to ajax call
$response = '';

// Write the content to system/update/updateFiles.ini
file_put_contents($updateFilesPath, $updateFiles);
// if updateFilesPath is not found, throw error
if (!file_exists($updateFilesPath))
{   // if file is not found, throw error
    $response .= 'ERROR WRITING: '.$updateFilesPath;
}

if (empty($differentFiles))
{   // if no files with different hash values were found
    $response .= '<p class="text-success"><b class="animated fadeIn slow delay-2s">All files have the same hash values!</b></p>';
}
else
{   // if files with different hash values were found
    $response .= '<p class="animated fadeIn slow delay-3s"><br><b>Files with different hash values:</b></p>';
    foreach ($differentFiles as $file) {
        $response .= '<span class="animated fadeIn slow delay-4s">- '.$file.'</span><br>';
    }
}

if (empty($localOnlyFiles)){
    $response .= '<p><b class="animated fadeIn slow delay-2s">No files found that are not in the update filebase.</b></p>';
}
else
{   // if files with different hash values were found
    $response .= '<br><br><div class="panel-group animated fadeIn slow delay-3s" id="accordion" role="tablist" aria-multiselectable="true">
  <div class="panel panel-default">
    <div class="panel-heading" role="tab" id="headingOne">
      <h4 class="panel-title">
        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
          Files that are not in the update filebase:<br>
          <small>(those files will <u>not</u> be touched during update)</small>
        </a>
      </h4>
    </div>
    <div id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
      <div class="panel-body">';
    foreach ($localOnlyFiles as $file) {
        $response .= '<span class="animated fadeIn slow">- '.$file.'</span><br>';
    }
    $response .= '
      </div>
    </div>
  </div>';
}

if (!empty($response)){
    echo $response;
}
else {
    echo 'There was an error generating the view from no data...';
}
