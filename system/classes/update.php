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

        /** @var string $updateFile contains all update information like version, build time, build message, etc. */
        public string $updateFile = 'update.ini';


        /**
         * @brief update constructor. Check if allow_url_fopen is enabled
         * @details will be called by xhr request from admin/js/update-generateLocalFilebase.php
         */
        public function __construct()
        {
            // Get the value of the allow_url_fopen setting
            $allowUrlFopen = ini_get('allow_url_fopen');

            // Check if allow_url_fopen is enabled
            if ($allowUrlFopen)
            {   // allow_url_fopen is enabled, all good
                echo "allow_url_fopen is enabled.";
            }
            else
            {   // allow_url_fopen is disabled, exit with error
                echo "allow_url_fopen is disabled, but required to use the update methods.";
            }
        }

        /**
         * @brief read filebase.ini from update server (https://update.yawk.io/filebase.ini) and return array|false
         * @details will be called by xhr request from admin/js/update-readUpdateFilebase.php
         * @return array|false
         */
        public function readUpdateFilebaseFromServer(): false|array
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
            } else {
                // echo "<p>opened $updateFolder.$iniFileName</p>";
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
                    || strpos($file_path, '/.idea/') !== false)
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
            if (fclose($output_handle)){
                echo '<p class="animated fadeIn slow delay-5s">written: $updateFolder.$iniFileName</p>';
            }
        }
    } // EOF class update
} // EOF namespace