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
        echo '<br><span class="animated fadeIn slow delay-2s"><b>not found:</b> '.$filePath.' <span class="text-muted">in update filebase</span></span>';
    }
}

if (empty($differentFiles)) {
    echo '<p><b class="animated fadeIn slow delay-2s">All files have the same hash values.</b></p>';
} else {
    echo '<p class="animated fadeIn slow delay-2s"><br><b>Files with different hash values:</b></p>';
    foreach ($differentFiles as $file) {
        echo '<span class="animated slideInDown delay-3s">- '.$file.'</span><br>';
    }
}
