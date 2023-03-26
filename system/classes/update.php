<?php
namespace YAWK {
    /**
     * @details YaWK System Updater Class
     *
     * The YaWK System Updater Class provides methods to facilitate the updating process of the system.
     * It includes features such as checking for new versions, verifying and comparing files to ensure
     * a stable and reliable update. This class aims to simplify the update process and minimize the
     * risk of any errors or issues during the update.
     *
     * @author     Daniel Retzl <danielretzl@gmail.com>
     * @copyright  2009-2023 Daniel Retzl
     * @license    https://opensource.org/licenses/MIT
     * @version    1.0.0
     * @brief      The update class - handles yawk's system update functions.
     */
    class update
    {
        /** @var string $base_dir the base directory of the YaWK installation */
        public string $base_dir = '';

        /** @var string $updateServer the remote server to connect to */
        public string $updateServer = 'https://update.yawk.io/';

        /** @var string $githubServer the remote GitHub server to fetch from  */
        public string $githubServer = 'https://raw.githubusercontent.com/YaWK/yawk.io/master/';

        /** @var string $updateFile contains all update information like version, build time, build message, etc. */
        public string $updateFile = 'update.ini';

        /**
         * @var string $updateVersion contains the version of current update (eg. 23.0.0)
         */
        public string $updateVersion = '';

        /**
         * @var string $localUpdateSystemPath the path to the local update system folder (eg. system/update/)
         */
//        public string $localUpdateSystemPath = '../../system/update/';
        public string $localUpdateSystemPath = '/system/update/';

        /**
         * @var string $updateFilebase  the name of the remote filebase file (eg. filebase.ini)
         */
        public string $updateFilebase = 'filebase.ini';

        /**
         * @var array $updateSettings contains all update settings
         */
        public array $updateSettings = array();

        /**
         * @var string $updateFilesFile contains all files that need to be updated
         */
        public string $updateFilesFile = 'updateFiles.ini';

        /**
         * @var array $updateFiles array of files that need to be updated
         */
        public array $updateFiles = array();

        /**
         * @brief update constructor. Check if allow_url_fopen is enabled
         * @details will be called by xhr request from admin/js/update-generateLocalFilebase.php
         */
        public function __construct()
        {
            // Get the value of the allow_url_fopen setting
            $allowUrlFopen = ini_get('allow_url_fopen');
            // Check if allow_url_fopen is enabled
            if (!$allowUrlFopen)
            {   // allow_url_fopen is disabled, exit with error
                // todo: syslog entry
                echo "allow_url_fopen is disabled, but required to use the update methods. Please enable allow_url_fopen in your php.ini file or ask your admin / hoster for assistance.";
            }

            // check if update server is reachable
            if ($this->isServerReachable($this->updateServer.$this->updateFile) === false)
            {   // todo: syslog entry
                echo "Update server $this->updateServer not reachable. Update not possible at the moment - please try again later.<br>";
            }
        }

        /**
         * @brief check if update server is reachable
         * @details returns true if server is reachable, false if not
         * @param $url string url to check
         * @return bool true|false
         */
        public function isServerReachable(string $url): bool
        {
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_NOBODY, true);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
            curl_setopt($ch, CURLOPT_TIMEOUT, 30);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; UpdateClient/1.0)');

            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

            curl_close($ch);

            if ($httpCode >= 200 && $httpCode < 300) {
                return true;
            } else {
                return false;
            }
        }

        /**
         * @brief get update settings from local update folder (system/update/update.ini) and return array|false
         * @details will be called by xhr request from admin/js/update-generateLocalFilebase.php
         * @return array|false
         */
        public function getUpdateSettings(): array|false
        {
            // read update.ini from local update folder
            $this->updateSettings = parse_ini_file($this->localUpdateSystemPath.$this->updateFile);
            if (count($this->updateSettings) < 1)
            {   // unable to read update.ini from local update folder
                echo "Error: Unable to read update.ini from local update folder. Check if this file exists: ".$this->localUpdateSystemPath.$this->updateFile;
            }
            else {
                // update.ini read successfully
                // set update version
                $this->updateVersion = $this->updateSettings['version'];

                // return update settings array
                return $this->updateSettings;
            }
            // return false if something went wrong
            return false;
        }

        /**
         * @brief Run the migration SQL file
         * @details if update.ini contains a migration file, this function will be called
         * @param $db
         * @return void
         */
        function runMigration($db): void
        {
            // build migration SQL file string
            $migrationUrl = $this->updateServer.$this->updateVersion.'-migration.sql';

            // Fetch the migration SQL file
            $migrationSql = file_get_contents($migrationUrl);

            if ($migrationSql === false) {
                echo "Error: Unable to fetch migration file from $migrationUrl\n";
                return;
            }

            // Check if the migration has already been executed
            $checkMigration = $db->prepare("SELECT `version` FROM `migrations` WHERE `version` = ?");
            $checkMigration->bind_param('s', $this->updateVersion);
            $checkMigration->execute();
            $result = $checkMigration->get_result();

            if ($result->num_rows === 0) {
                // Execute the migration SQL
                if ($db->multi_query($migrationSql)) {
                    // Record the successful migration
                    $insertMigration = $db->prepare("INSERT INTO `migrations` (`version`, `executed_at`) VALUES (?, NOW())");
                    $insertMigration->bind_param('s', $this->updateVersion);

                    // execute update migration
                    if ($insertMigration->execute())
                    {   // migration executed successfully
                        // todo: syslog entry
                        echo "Migration for version $this->updateVersion executed successfully.\n";
                    }
                    else
                    {   // migration failed
                        // todo: syslog entry
                        echo "Error recording migration for version $this->updateVersion: " . $insertMigration->error . "\n";
                    }

                    // close insert migration connection
                    $insertMigration->close();
                }
                else
                {   // migration failed
                    // todo: syslog entry
                    echo "Error executing migration for version $this->updateVersion: " . $db->error . "\n";
                }
            }
            else
            {   // migration already executed
                // todo: syslog entry
                echo "Migration for version $this->updateVersion already executed.\n";
            }

            // close check migration connection
            $checkMigration->close();
        }

        /**
         * @brief read system/update/updateFiles.ini and fetch files from remote (GitHub) server
         * @details will be called by xhr request from admin/js/update-fetchFiles.php
         * @param $db object database connection
         * @param $updateVersion string update version
         * @param $lang array language array
         */
        public function fetchFiles(object $db, string $updateVersion, array $lang): void
        {
            $updateSucceed = false; // init updateSucceed flag, will be set to true if update was successful
            // override $this->updateServer with GitHub url
            $this->updateServer = $this->githubServer;

            // file fetched successfully
            $basedir = __DIR__;
            // remove last 15 chars from $basedir (system/update/)
            $basedir = substr($basedir, 0, -14);
            // $basedir = substr($basedir, 0, -8);

            $response = ''; // init output string, result of the update process, will be returned to the frontend
            // check if updateFiles.ini exists
            if (file_exists($basedir.$this->localUpdateSystemPath . $this->updateFilesFile))
            {
                // updateFiles.ini exists
                // parse updateFiles.ini into array
                $this->updateFiles = parse_ini_file($basedir.$this->localUpdateSystemPath . $this->updateFilesFile);
                if (count($this->updateFiles) < 1)
                {
                    // unable to read updateFiles.ini from local update folder
                    $response .= "Error: Unable to read updateFiles.ini from local update folder. Check if this file exists: " . $basedir.$this->localUpdateSystemPath . $this->updateFilesFile;
                }
                else
                {
                    // count elements of updateFiles array
                    $totalUpdateFiles = count($this->updateFiles);
                    $failedFiles = 0;
                    $successFiles = 0;
                    $fetchFailed = 0;
                    $fetchSucceed = 0;
                    $processedFiles = 0;

                    // updateFiles.ini read successfully
                    // fetch files from remote server
                    foreach ($this->updateFiles as $key => $value)
                    {
                        $processedFiles++;
                        // debug line can be removed $response .= "VALUE: $value <br>";

                        // build file url
                        $fileUrl = $this->updateServer . $value;
                        // fetch file
                        $file = file_get_contents($fileUrl);
                        if ($file === false)
                        {
                            // unable to fetch file
                            $response .= "Error: Unable to fetch file from $fileUrl<br>";
                            $fetchFailed++;
                        }
                        else
                        {
                            $fetchSucceed++;

                            // create path to tmp folder
//                            $tmpPath = $basedir.$this->localUpdateSystemPath;
//
//                            $tmpFilePath = $tmpPath . $value;
//                            // Create the directory structure if it doesn't exist
//                            $tmpFileDir = dirname($tmpFilePath);
//                            if (!is_dir($tmpFileDir)) {
//                                mkdir($tmpFileDir, 0755, true);
//                            }
//
//                            // debug, cen be removed $response .= "TMP Path: $tmpPath <br>";
//
//                            // Ensure tmp directory exists
//                            if (!is_dir($tmpPath) && !mkdir($tmpPath)) {
//                                $response .= "Error: Unable to create tmp directory: " . $tmpPath . "<br>";
//                                continue;
//                            }
//
//                            // Save the file to tmp folder
//                            if (!file_put_contents($tmpPath . $value, $file)) {
//                                $response .= "Error: Unable to write file to local system: " . $tmpPath . $value . "<br>";
//                                continue;
//                            }
//
//                            $response .= "File written successfully to tmp folder: " . $tmpPath . $value . "<br>";

                            // Check the md5 value of the fetched file with the one in updateFiles.ini
//                            $currentHashValue = md5_file($tmpPath . $value);
//                            if ($currentHashValue !== $key) {
//                                $response .= "Error: File hash value does not match: <br>FILE: " . $value . "<br> original hash: $key <br> current hash: $currentHashValue <br>";
//                                continue;
//                            }
//
//                            $response .= "<span class=\"text-success\">File hash value matches: " . $value . "</span><br>";

                            // Write file to local system
                            if (!file_put_contents($basedir.$value, $file))
                            {   // unable to write file to local system
                                $failedFiles++;
                                $response .= "<b> class=\"text-danger\">Error: Unable to write file to local system: " .$basedir.$value . "</b><br>";
                            }
                            else
                            {   // file written successfully
                                $successFiles++;
                                $response .= "<b class=\"text-success animated fadeIn slow\">File written successfully: " . $basedir.$value . "</b><br>";
                            }
                        }
                    }
                    // check if all files were fetched successfully
                    if ($fetchFailed > 0)
                    {
                        // at least one file could not be fetched
                        $response .= "<b class=\"text-danger\">Error: Unable to fetch $fetchFailed files from remote server.</b><br>";
                    }
                    else if ($fetchSucceed === $totalUpdateFiles)
                    {
                        // all files fetched successfully
                        $response .= "<b class=\"text-success\">All $fetchSucceed files fetched successfully from remote server.</b><br>";
                    }
                    // check if all files were written successfully
                    if ($failedFiles > 0)
                    {
                        // at least one file could not be written
                        $response .= "<b class=\"text-danger\">Error: Unable to write $failedFiles files to local system.</b><br>";
                    }
                    else if ($successFiles === $totalUpdateFiles)
                    {
                        // all files written successfully
                        $response .= "<b class=\"text-success\">All $successFiles files written successfully to local system.</b><br>";
                    }
                    // check if all files were processed
                    if ($processedFiles === $totalUpdateFiles)
                    {
                        // all files processed
                        $response .= "<b class=\"text-success\">All $processedFiles files processed.</b><br>";
                    }
                    else
                    {
                        // not all files processed
                        $response .= "<b class=\"text-danger\">Error: Not all files processed. $processedFiles of $totalUpdateFiles files processed.</b><br>";
                    }
                    // check if update was successful
                    if ($successFiles === $totalUpdateFiles)
                    {   // update was successful
                        $updateSucceed = true;
                        // update was successful
                        $response .= "<h3 class=\"text-success\">Update was successful.</b><h3>";
                    }
                    else
                    {   // update failed
                        $response .= "<h3 class=\"text-danger\">Update failed.</h3>";
                    }
                }
            } else {
                // updateFiles.ini does not exist
                $response .= "<span class=\"text-danger\"><b>Error:</b> updateFiles.ini does not exist. Check if this file exists: " .$basedir.$this->localUpdateSystemPath . $this->updateFilesFile . "</span>";
            }

            // check if update was successful
            if ($updateSucceed === true)
            {   // set new version in database
                settings::setSetting($db, "yawkversion", $updateVersion, $lang);

                // get version from database to check if it was updated correctly
                $version = settings::getSetting($db, "yawkversion");
                if ($version === $updateVersion)
                {
                    $response .= "<h3 class=\"text-success\">Update to $updateVersion successful.</b><h3>";
                }
                else
                {
                    $response .= "<h3 class=\"text-danger\">Update to $updateVersion failed.</h3>";
                }
            }
            // return xhr response
            echo $response;
        }

        /**
         * @brief read update.ini from update server (https://update.yawk.io/update.ini) and return array|false
         * @return false|array
         */
        public function readUpdateIniFromServer(): false|array
        {
            // URL of the remote INI file
            $url = $this->updateServer.$this->updateFile;

            // Get the content of the remote INI file
            $iniContent = file_get_contents($url);

            // Check if the content was retrieved successfully
            if ($iniContent !== false)
            {   // Parse the INI content into an associative array
                $config = parse_ini_string($iniContent);

                // Print the contents of the array
                foreach ($config as $key => $value)
                {   // set update array
                    $updateConfig['UPDATE'][$key] = $value;
                }
            }
            else
            {   // unable to read update.ini from remote server
                echo "Error: Unable to read the remote INI file.";
            }
            return $updateConfig ?? false;
        }

        /**
         * @brief Read all files of current YaWK installation and write each file with path + MD5 hash to ini file
         * to compare it later with the possible update files. This is used to verify the integrity of the files.
         * @param $db object global db object
         * @param $lang array global language array
         * @return void
         */
        public function generateLocalFilebase(object $db, array $lang): void
        {
            $this->base_dir = dirname(__FILE__);
            $this->base_dir = substr($this->base_dir, 0, -15); // remove last 15 chars
            // echo "<p>Base directory: $this->base_dir</p>";

            // set path and filename of the ini file
            $updatePath = '/system/update/';
            $updateFolder = $this->base_dir.$updatePath;

            if (!is_dir($updateFolder)){
                if (!mkdir($updateFolder, 0777, true) && !is_dir($updateFolder)) {
                    throw new \RuntimeException(sprintf('Unable to create "%s" - please check folder permissions or create folder by hand', $updateFolder));
                }
            }
            $iniFileName = 'filebase.current.ini';
            $input_folder = $this->base_dir;
            $output_file = $updateFolder.$iniFileName;
            $writeIniFile = true;

            // delete old file if exists
            if (is_file($output_file)){
                unlink($output_file);
            }

            // Open the output file for writing
            $output_handle = fopen($output_file, 'w');
            if (!$output_handle) {
                // handle the error (e.g. show an error message or log the error)
                die("Failed to open file");
            }

            // Get the full path of the input folder
            $input_folder = realpath($input_folder);

            // Loop through all files in the input folder and its subfolders
            echo "<p>Building filebase of: <i><small>$input_folder</small></i></p>";
            $root_files = array();
            $subfolder_files = array();
            foreach(new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($input_folder)) as $file_path)
            {
                // Skip some excluded directories and hidden files
                if ($file_path->isDir()
                    || $file_path->getFilename()[0] == '.'
                    || strpos($file_path, '/.git/') !== false
                    || strpos($file_path, '/.github/') !== false
                    || strpos($file_path, '/.idea/') !== false
                    || strpos($file_path, '/content/') !== false
                    || strpos($file_path, '/media/') !== false)
                {   // skip this file/folder
                    continue;
                }

                // Calculate the MD5 hash of the file
                $md5_hash = md5_file($file_path);

                // Get the full path of the file
                $full_path = realpath($file_path);

                // Remove the input folder path from the full path to get the relative path
                $relative_path = substr($full_path, strlen($input_folder) + 1);

                // Split the relative path into an array of path components
                $path_components = explode('/', $relative_path);

                // Check if the path has only one component (i.e. it's a file in the root folder)
                if (count($path_components) == 1) {
                    $root_files[$relative_path] = $md5_hash;
                } else {
                    $subfolder_files[$relative_path] = $md5_hash;
                }
            }

            // Sort the arrays alphabetically by key (the relative path)
            ksort($root_files);
            ksort($subfolder_files);

            // Merge the two arrays so that the root files are listed first
            $hashes = array_merge($root_files, $subfolder_files);

            // init counters
            $totalFiles = count($hashes);   // count total files
            $totalFilesVerified = 0;        // number of verified files
            $totalFilesFailed = 0;          // number of failed files

            // Write the sorted array to the output file in the .ini format
            foreach ($hashes as $relative_path => $md5_hash)
            {   // write each file with its md5 hash to ini file
                // echo "Writing $relative_path=$md5_hash to $output_file\n";
                // Write the relative path and MD5 hash to the output file
                if (file_put_contents($output_file, "$relative_path=$md5_hash\n", FILE_APPEND))
                {   // line written successfully
                    // echo '<p class="text-success">Verified '.$relative_path.' <small>'.$md5_hash.'</small></p>';
                    $totalFilesVerified++;
                }
                else
                {   // line failed
                    // echo '<p class="text-danger">Failed '.$relative_path.' <small>'.$md5_hash.'</small></p>';
                    $totalFilesFailed++;
                }
            }

            // Close the output file
            echo '<p class="animated fadeIn slow delay-1s">Indexing <b>'.$totalFiles.'</b> files. Verified <b>'.$totalFilesVerified.'</b> files. Failed <b>'.$totalFilesFailed.'</b> files.</p>';

            if (!is_file($output_file))
            {   // unable to write ini file
                $iniFileWritten = "<h4 class=\"text-danger\">".$iniFileName." could not be written</h4>";
            }
            else
            {   // ini file written successfully
                $iniFileWritten = "<p class=\"animated fadeIn slow delay-5s\">Hash values written to: <b><a href=\"$updatePath$iniFileName\" target=\"_blank\">$updatePath$iniFileName</a></b></p>";
            }

            // check if all files were verified
            if ($totalFiles == $totalFilesVerified)
            {   // set success icon, message and colors
                $icon = '<i class="fa fa-check-circle-o fa-2x text-success"></i>';
                $done = "<h4 class=\"text-success animated fadeIn slow delay-4s\">".$totalFiles."&nbsp;".$lang['UPDATE_VERIFICATION_SUCCESS']."</h4>";
                $iconFalse = '';
                $successColor = ' text-success';
                $failedColor = '';
            }
            else
            {   // set failure icon, message and colors
                $iconFalse = '<i class="fa fa-exclamation-triangle fa-2x text-danger"></i>';
                $done = "<h4 class=\"text-danger\"><b>".$totalFilesFailed." ".$lang['UPDATE_VERIFICATION_FAILED']."</b></h4>";
                $failedColor = ' text-danger';
                $successColor = '';
            }

            echo "
<p class=\"animated fadeIn slow delay-2s$successColor\">$icon &nbsp;Generated hash values: <b>$totalFilesVerified / $totalFiles</b></p>
<h4 class=\"animated fadeIn slow delay-3s\">$done</h4>
<p class=\"animated fadeIn slow delay-4s$failedColor\">$iconFalse &nbsp;Failed to verify: <b>$totalFilesFailed</b></p>
$iniFileWritten";

            // Close the output file
            if (!fclose($output_handle)){
                echo '<p class="animated fadeIn slow delay-5s">failed to close: '.$updateFolder.$iniFileName.'</p>';
            }
        }


        /**
         * @brief read filebase.ini from update server (https://update.yawk.io/filebase.ini) and return array|false
         * @details will be called by xhr request from admin/js/update-readUpdateFilebase.php
         * The filebase.ini contains a list of all files with their md5 hash.
         * This function returns the filebase as array. (to compare it later with the local filebase)
         * @return array|false
         */
        public function readUpdateFilebaseFromServer(): array|false
        {
            // URL of the remote INI file
            $url = $this->updateServer.'filebase.ini';

            // Get the content of the remote INI file
            $iniContent = file_get_contents($url);

            // Check if the content was retrieved successfully
            if ($iniContent !== false)
            {   // Parse the INI content into an associative array
                $filebase = parse_ini_string($iniContent);

                // Print the contents of the array
                foreach ($filebase as $key => $value)
                {   // set update array
                    $updateFilebase[$key] = $value;
                }
            }
            else
            {   // unable to read filebase from remote server
                echo "Error: Unable to read filebase from remote server. Check if this file exists: $url";
            }
            // return array or false
            return $updateFilebase ?? false;

        }
    } // EOF class update
} // EOF namespace