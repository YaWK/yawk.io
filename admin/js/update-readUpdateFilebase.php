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
if (!is_array($updateFilebase) || empty($updateFilebase)){
    echo $lang['UPDATE_ERROR_READING_UPDATE_INI'].' https://'.$_SERVER['HTTP_HOST'].'/system/update/filebase.current.ini';
}
else if (is_array($localFilebase) && is_array($updateFilebase)) {
    // sort arrays by key (file path)
    ksort($localFilebase);
    ksort($updateFilebase, SORT_NATURAL);
// compare filebase arrays
// if file hash is different, add file to differentFiles array
    $differentFiles = array();  // files with different hash values (those will be updated)
    $localOnlyFiles = array();  // files only found in local filebase (files that were added by page admin, those will NOT be touched)
    $updateFiles = '';  // files that will be updated

// add files, that are in the update filebase, but not in the local filebase
    foreach($updateFilebase as $key => $value) {
        if (!array_key_exists($key, $localFilebase)) {
            // add file to updateFiles string, which will be written to updateFiles.ini
            $updateFiles .= "$value=\"$key\"\n";
            $differentFiles[] = $key;
        }
    }

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
        $response .= $lang['UPDATE_ERROR_WRITING'].' '.$updateFilesPath;
    }
}


if (empty($differentFiles))
{   // if no files with different hash values were found
    $response .= '<p class="text-success"><b class="animated fadeIn slow delay-2s">'.$lang['UPDATE_ALL_HASHES_SAME'].'</b></p>';
}
else
{   // if files with different hash values were found
    // draw panel
    $response .= '<div class="panel-group animated fadeIn slow delay-3s" id="accordion" role="tablist" aria-multiselectable="true">
  <div class="panel panel-default">
    <div class="panel-heading" role="tab" id="headingUpdateFilebase">
      <h4 class="panel-title">
        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseUpdateFilebase" aria-expanded="true" aria-controls="collapseUpdateFilebase">
          '.$lang['UPDATE_FILEBASE'].'<br>
          <small>'.$lang['UPDATE_FILEBASE_SUBTEXT'].'</small>
        </a>
      </h4>
    </div>
    <div id="collapseUpdateFilebase" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingUpdateFilebase">
      <div class="panel-body">';
    $response .= '<p class="animated fadeIn slow"><b>'.$lang['UPDATE_FILES_WITH_DIFFERENT_HASHES'].'</b></p>';
    foreach ($differentFiles as $file) {
        $response .= '<span class="animated fadeIn slow delay-1s">- '.$file.'</span><br>';
    }
    echo '</div></div></div></div>';
}

if (empty($localOnlyFiles)){
    $response .= '<p><b class="animated fadeIn slow delay-3s">'.$lang['UPDATE_NO_FILES_TO_UPDATE'].'</b></p>';
}
else
{   // if files with different hash values were found
    $response .= '<br><br><div class="panel-group animated fadeIn slow delay-3s" id="accordion2" role="tablist" aria-multiselectable="true">
  <div class="panel panel-default">
    <div class="panel-heading" role="tab" id="headingOne">
      <h4 class="panel-title">
        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion2" href="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
          '.$lang['UPDATE_FILES_NOT_IN_UPDATE_FILEBASE'].'<br>
          <small>'.$lang['UPDATE_FILES_WILL_NOT_BE_TOUCHED'].'</small>
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
