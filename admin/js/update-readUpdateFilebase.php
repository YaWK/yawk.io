<?php
use YAWK\update;
include '../../system/classes/update.php';
// prepare vars

$localFilebase = parse_ini_file('../../system/update/filebase.current.ini');

$update = new update();
$updateFilebase = $update->readUpdateFilebaseFromServer();
ksort($localFilebase);
ksort($updateFilebase, SORT_NATURAL);

$differentFiles = array();

foreach ($localFilebase as $filePath => $localHash) {
    if (isset($updateFilebase[$filePath])) {
        $updateHash = $updateFilebase[$filePath];

        if ($localHash !== $updateHash) {
            $differentFiles[] = $filePath;
        }
    } else {
        echo '<br><b>not found:</b> '.$filePath.' <span class="text-muted">in update filebase</span>';
    }
}

if (empty($differentFiles)) {
    echo "<b>All files have the same hash values.</b><br>";
} else {
    echo "<br><br><b>Files with different hash values:</b><br>";
    foreach ($differentFiles as $file) {
        echo "- $file<br>";
    }
}


echo "<pre>";
echo "</pre>";
