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
        /* @param string $base_dir */
        public string $base_dir = '';


        /** @return object global db object */
        public function __construct()
        {

        }

        /**
         * @brief Read all files of current YaWK installation and write each file with path + MD5 hash to ini file
         * to compare it later with the possible update files. This is used to verify the integrity of the files.
         * @param $db object global db object
         * @param $lang array global language array
         * @return void
         */
        public function readFilebase(object $db, array $lang): void
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

    }
}