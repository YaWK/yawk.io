<?php
namespace YAWK
{
    use YAWK\db;
    use YAWK\sys;
    require_once 'sys.php';
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
         * @var string $currentVersion contains the current installed version (eg. 23.0.0)
         */
        public string $currentVersion = '';

        /**
         * @var string $updateVersion contains the version of current update (eg. 23.1.2)
         */
        public string $updateVersion = '';

        /**
         * @var string $localUpdateSystemPath the path to the local update system folder (eg. system/update/)
         */
        public string $localUpdateSystemPath = 'system/update/';

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
         * @var bool $migrationSuccessful true|false indicates if migration was successful, call fetchFiles() on true
         */
        public bool $migrationSuccessful = false;

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
         * @brief record migration in database
         * @details will be called from runMigrations() if migration was successful
         * @param $db
         * @param $successfulMigrations
         * @return void
         */
        public function recordMigration($db, $successfulMigrations): void
        {
            $output = '';
            // check if migrations array is set and got at least 1 entry
            if (is_array($successfulMigrations) && (count($successfulMigrations) > 0))
            {   // loop through all migrations
                foreach ($successfulMigrations as $migrationVersion) {
                    // record migration
                    if (!$db->query("INSERT INTO {migrations} (`version`, `executed_at`) VALUES ('$migrationVersion', NOW())"))
                    {   // error recording migration
                        sys::setSyslog($db, 53, 0, "Error recording migration for version $migrationVersion: " . $db->error . " ", 0, 0, 0, 0);
                        $output .= "Error recording migration for version $migrationVersion: " . $db->error . "<br>";
                    }
                    else
                    {   // migration recorded successfully
                        sys::setSyslog($db, 53, 0, "Migration record for version $migrationVersion successful.", 0, 0, 0, 0);
                        $output .= "Migration for version $migrationVersion executed successfully.<br>";
                    }
                }
            }
            else
            {   // no migrations to record
                sys::setSyslog($db, 54, 0, "No Migrations to record. Is there a logical error?", 0, 0, 0, 0);
                $output .= "No migrations to record.<br>";
            }
            echo $output;
        }

        /**
         * @brief Run the migration SQL files
         * @details If update.ini contains migration files between the current version and the update version, this function will be called
         * @param $db object the database object
         * @param $lang array the language array
         * @return void true|false if migrations were successful or not
         */
        function runMigrations(object $db, array $lang): void
        {
            require_once 'sys.php';
            /** @param $db db */
            ini_set('display_errors', 1);
            error_reporting(E_ALL);

            // init variables
            $output = '';
            $totalMigration = 0;
            $successfulMigrations = 0;
            $failedMigrations = 0;
            $successfulMigrationVersions = array();

            // log start of migration
            sys::setSyslog($db, 56, 0, "runMigrations initialized. Updating from $this->currentVersion to $this->updateVersion", 0, 0, 0, 0);

            // run migrations
            try
            {   // Start transaction, so we can roll back if something goes wrong
                $db->beginTransaction();

                // Determine which migrations need to be executed
                $migrationUrlBase = $this->updateServer . 'migration-';
                $currentVersionParts = explode('.', $this->currentVersion);
                $updateVersionParts = explode('.', $this->updateVersion);
                // Start at the next minor version after the current version
                $startIndex = (int)$currentVersionParts[2] + 1;
                // End at the minor version of the update version
                $endIndex = (int)$updateVersionParts[2];
                $output .= '<br><br><div class="panel-group animated fadeIn slow delay-2s" id="accordion" role="tablist" aria-multiselectable="true">
  <div class="panel panel-default">
    <div class="panel-heading" role="tab" id="headingMigration">
      <h4 class="panel-title">
        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseMigration" aria-expanded="true" aria-controls="collapseMigration">
          '.$lang['UPDATE_MIGRATIONS'].'<br>
          <small>(database updates)</small>
        </a>
      </h4>
    </div>
    <div id="collapseMigration" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingMigration">
      <div class="panel-body">';

                // Loop through the migration files
                for ($i = $startIndex; $i <= $endIndex; $i++)
                {
                    $totalMigration++;
                    // build migration version
                    $migrationVersion = $currentVersionParts[0] . '.' . $currentVersionParts[1] . '.' . $i;
                    // build migration filename
                    $migrationUrl = $migrationUrlBase . $migrationVersion . '.sql';

                    // check if migration was already executed
                    $migrationRecord = $db->query("SELECT version FROM {migrations} WHERE version = '$migrationVersion'")->fetch_assoc();

                    // check if migration was already executed
                    if ($migrationRecord !== null)
                    {   // migration was already executed
                        $output .= "$migrationVersion : ".$lang['UPDATE_MIGRATION_ALREADY_EXEC']."<br>";
                        sys::setSyslog($db, 53, 1, "Migration for build $migrationVersion was already executed.", 0, 0, 0, 0);
                        $failedMigrations++;
                        continue;
                    }
                    else {
                        // migration was not executed yet
                        // $output .= "Migration for build $migrationVersion was not executed yet.<br>";
                        // Fetch the migration file
                        $migrationSql = @file_get_contents($migrationUrl);
                    }

                    // Check if the migration file was fetched successfully
                    if ($migrationSql === false)
                    {   // Unable to fetch migration file
                        $output .= $lang["UPDATE_NO_MIGRATION_REQUIRED_FOR_BUILD"]." ".$migrationVersion."<br>";
                        sys::setSyslog($db, 53, 0, "No migration required for build $migrationVersion", 0, 0, 0, 0);
                        $failedMigrations++;
                        continue;
                    }
                    else
                    {   // Fetched migration file successfully
                        $output .= "<span style=\"text-success\"><b>".$lang['UPDATE_FETCHED_MIGRATION_FILE_FROM']."</b>".$migrationUrl."</span><br>";
                        sys::setSyslog($db, 54, 0, "<b>Fetched migration file</b> from $migrationUrl", 0, 0, 0, 0);
                        $successfulMigrations++;
                        $successfulMigrationVersions[] = $migrationVersion;
                    }

                    $output .= "Multi-query SQL: " . $migrationSql . "<br>";

                    // explode the migration file into individual queries (array)
                    $sqlStatements = explode(';', $migrationSql);
                    // to keep track of the statement number
                    $statementCounter = 0;
                    // loop through all sql queries of current migration file
                    foreach ($sqlStatements as $sqlStatement)
                    {   // increment statement counter
                        $statementCounter++;
                        // trim the sql statement
                        $sqlStatement = trim($sqlStatement);
                        // check if sql statement is not empty
                        if (!empty($sqlStatement))
                        {   // execute the sql statement
                            if (!$db->query($sqlStatement))
                            {   // migration failed
                                $output .= $migrationVersion." ".$lang['UPDATE_ERROR_EXEC_FAILED']." ".$statementCounter . $db->error . "<br>";
                                sys::setSyslog($db, 56, 2, "Error executing migration statement #$statementCounter for version (query failed) $migrationVersion: " . $db->error . " ", 0, 0, 0, 0);
                                $db->rollback(); // Rollback the transaction
                                return;
                            }
                            else
                            {   // migration successful
                                $output .= "<span style=\"text-success\">$migrationVersion ".$lang['UPDATE_ERROR_EXEC_SUCCESS']." $statementCounter</span><br>";
                                sys::setSyslog($db, 53, 0, "executed migration statement #$statementCounter : $migrationUrlBase$migrationVersion.sql ", 0, 0, 0, 0);
                            }
                        }
                    }
                } // end loop through migration files

                // Commit the transaction if all migrations executed successfully
                $db->commit();

                // if there was at least one successful migration
                if ($successfulMigrations > 0)
                {   // store migration version in database
                    $this->recordMigration($db, $successfulMigrationVersions);
                    foreach ($successfulMigrationVersions as $successfulMigrationVersion)
                    {   // output successful migration version
                        $output .= "<span style=\"text-success\">$successfulMigrationVersion ".$lang['UPDATE_MIGRATION_RECORDED']."</span><br>";
                    }
                    // log successful migration
                    sys::setSyslog($db, 54, 0, "<b>Migration complete</b>Migrations executed successfully.", 0, 0, 0, 0);
                    $this->migrationSuccessful = true;
                }
                // END migrations executed successfully
            }
            // TRANSACTION FAILED - ROLLBACK
            catch (\Exception $e)
            {   // An exception was thrown, rollback the transaction
                if ($db->rollback() === true)
                {   // rollback successful
                    sys::setSyslog($db, 56, 2, "<b>Rolled back transaction</b> because there was an error executing migrations: " . $e->getMessage() ." ", 0, 0, 0, 0);
                    $output .= $lang['UPDATE_MIGRATION_ROLLED_BACK'] . $e->getMessage() . "\n";
                }
                else
                {   // rollback failed
                    sys::setSyslog($db, 56, 2, "<b>Rollback FAILED!</b>, additionally there was an error during migrations: " . $e->getMessage() ." ", 0, 0, 0, 0);
                    $output .= $lang['UPDATE_MIGRATION_ROLLBACK_FAILED']  . $e->getMessage() . "\n";
                }
                $this->migrationSuccessful = false;
            }
            // close migration panel body+panel
            $output .= "</div></div></div>";

            // output ajax response
            if (!empty($output))
            {   // will be returned to ajax request
                echo $output;
            }
            else
            {   // no output was generated - this should not happen
                sys::setSyslog($db, 56, 2, "No migrations were executed. Output is empty. output was not filled with any value during runMigrations(). (this is not possible?!)", 0, 0, 0, 0);
                echo $lang['UPDATE_NO_MIGRATION_EXECUTED'];
            }
        }

        /**
         * @brief read system/update/updateFiles.ini and fetch files from remote (GitHub) server
         * @details will be called by xhr request from admin/js/update-fetchFiles.php
         * @param $db object database connection
         * @param $updateVersion string update version
         * @param $lang array language array
         */
        public function fetchFiles(object $db, string $currentVersion, string $updateVersion, array $lang): void
        {
            // init updateSucceed flag, will be set to true if update was successful
            $updateSucceed = false;

            // set update version
            $this->currentVersion = $currentVersion;
            $this->updateVersion = $updateVersion;

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
                {   // unable to read updateFiles.ini from local update folder
                    $response .= "<span class=\"text-warning\"><p><i class=\"fa fa-exclamation-triangle text-warning\"></i>".$lang['UPDATE_FAST_FORWARD_INFO']."
                    <a href=\"#fastForwardUpdate\" id=\"fastForwardUpdateBtn\" class=\"btn btn-warning\">".$lang['UPDATE_FAST_FORWARD_BTN']." &nbsp;<i class=\"fa fa-fast-forward\"></i></a></span><br>";
                }
                else
                {   // count elements of updateFiles array
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
                        // fetch next file to update
                        $file = file_get_contents($fileUrl);
                        if ($file === false)
                        {
                            // unable to fetch file
                            $response .= $lang['UPDATE_FETCH_FILE_FAILED'].$fileUrl."<br>";
                            $fetchFailed++;
                        }
                        else
                        {   // count successful fetches
                            $fetchSucceed++;

                            // Write file to local system
                            if (!file_put_contents($basedir.$value, $file))
                            {   // unable to write file to local system
                                $failedFiles++; // count failed files
                                $response .= "<b> class=\"text-danger\">".$lang['UPDATE_UNABLE_TO_WRITE_FILE']."</b> " .$basedir.$value . "<br>";
                            }
                            else
                            {   // file written successfully
                                $successFiles++; // count successful written files
                                $response .= "<b class=\"text-success animated fadeIn slow\">".$lang['UPDATE_FILE_WRITTEN']."</b> " . $basedir.$value . "<br>";
                            }
                        }
                    }
                    // check if all files were fetched successfully
                    if ($fetchFailed > 0)
                    {   // at least one file could not be fetched
                        $response .= "<b class=\"text-danger\">".$lang['UNABLE_TO_FETCH_FILES_FROM_REMOTE_SERVER']." $fetchFailed</b><br>";
                    }
                    else if ($fetchSucceed === $totalUpdateFiles)
                    {   // all files fetched successfully
                        $response .= "<b class=\"text-success\">$fetchSucceed ".$lang['UPDATE_SUCCESSFULLY_FETCHED']."</b><br>";
                    }
                    // check if all files were written successfully
                    if ($failedFiles > 0)
                    {   // at least one file could not be written
                        $response .= "<b class=\"text-danger\">$failedFiles ".$lang['UPDATE_FAILED_FILES']."</b><br>";
                    }
                    else if ($successFiles === $totalUpdateFiles)
                    {   // all files written successfully
                        $response .= "<b class=\"text-success\">".$lang['ALL']." ".$successFiles." ".$lang['UPDATE_ALL_FILES_SUCCESS']."</b><br>";
                    }
                    // check if all files were processed
                    if ($processedFiles === $totalUpdateFiles)
                    {   // all files processed
                        $response .= "<b class=\"text-success\">".$lang['ALL']." ".$processedFiles." ".$lang['UPDATE_FILES_PROCESSED']."</b><br>";
                    }
                    else
                    {   // not all files processed
                        $response .= "<b class=\"text-danger\">".$lang['UPDATE_NOT_ALL_FILES_PROCESSED']." ".$processedFiles." ".$lang['OF']." ".$totalUpdateFiles." ".$lang['UPDATE_FILES_PROCESSED'].".</b><br>";
                    }
                    // check if update was successful
                    if ($successFiles === $totalUpdateFiles)
                    {   // update was successful
                        $updateSucceed = true;
                    }
                    else
                    {   // update failed
                        $response .= "<h3 class=\"text-danger\">".$lang['UPDATE_FAILED']."</h3>";
                    }
                }
            }
            else
            {   // updateFiles.ini does not exist
                $response .= "<span class=\"text-danger\"><b>".$lang['ERROR'].":</b> ".$lang['UPDATE_FILES_INI_MISSING']." " .$basedir.$this->localUpdateSystemPath . $this->updateFilesFile . "</span>";
            }

            // check if update was successful
            if ($updateSucceed === true)
            {   // set new version in database
                settings::setSetting($db, "yawkversion", $updateVersion, $lang);

                // get version from database to check if it was updated correctly
                $version = settings::getSetting($db, "yawkversion");
                if ($version == $updateVersion && $updateSucceed === true)
                {   // system version was updated successfully
                    $response .= "<h3 class=\"text-success\">".$lang['UPDATE_TO']." $updateVersion ".$lang['COMPLETED_SUCCESSFULLY']."</b><h3>";
                    sys::setSyslog($db, 54, 0, "<b>UPDATE COMPLETE</b> Migration and Files updated to $updateVersion.", 0, 0, 0, 0);
                }
                else
                {   // failed to update version in database
                    $response .= "<h3 class=\"text-danger\">".$lang['UPDATE_FAILED_TO_WRITE_VERSION_NUMBER']." ($updateVersion)</h3>";
                }
            }
            else
            {   // update failed
                $response .= "<h3 class=\"text-danger\">".$lang['UPDATE_FAILED_FROM']." $this->currentVersion ".$lang['TO']." $updateVersion.</h3>";
            }
            // return xhr response
            echo $response;

            // close database connection
            $db->close();
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
                die("Failed to open file for writing: $output_file");
            }

            // Get the full path of the input folder
            $input_folder = realpath($input_folder);

            // Loop through all files in the input folder and its subfolders
            echo "<p>".$lang['UPDATE_BUILDING_LOCAL_FILEBASE']." <i><small>$input_folder</small></i></p>";
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
            echo '<p class="animated fadeIn slow delay-1s">'.$lang['UPDATE_INDEXING'].' <b>'.$totalFiles.'</b> '.$lang['FILES'].'. '.$lang['VERIFIED'].' <b>'.$totalFilesVerified.'</b> '.$lang['FILES'].'. '.$lang['FAILED'].' <b>'.$totalFilesFailed.'</b> '.$lang['FILES'].'.</p>';

            if (!is_file($output_file))
            {   // unable to write ini file
                $iniFileWritten = "<h4 class=\"text-danger\">".$iniFileName." ".$lang['COULD_NOT_BE_WRITTEN']."</h4>";
            }
            else
            {   // ini file written successfully
                $iniFileWritten = "<p class=\"animated fadeIn slow delay-5s\">".$lang['UPDATE_HASH_VALUES_WRITTEN_TO']." <b><a href=\"$updatePath$iniFileName\" target=\"_blank\">$updatePath$iniFileName</a></b></p>";
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
            <p class=\"animated fadeIn slow delay-2s$successColor\">$icon &nbsp;".$lang['UPDATE_GENERATED_HASH_VALUES']." <b>$totalFilesVerified / $totalFiles</b></p>";
            echo"<h4 class=\"animated fadeIn slow delay-4s\">$done</h4>
            $iniFileWritten";

            // check if any files failed
            if ($totalFilesFailed > 0)
            {   // show amount of failed files
                echo"<p class=\"animated fadeIn slow delay-3s$failedColor\">$iconFalse &nbsp;".$lang['UPDATE_FAILED_TO_VERIFY']." <b>$totalFilesFailed</b></p>";
            }

            // Close the output file
            if (!fclose($output_handle))
            {   // unable to close ini file
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
            if ($iniContent = file_get_contents($url)){
                if (!empty($iniContent)){
                    // Parse the INI content into an associative array
                    $filebase = parse_ini_string($iniContent);

                    // debug if ini file is not parsed correctly
                    /*
                    echo "<pre>";
                    print_r($iniContent);
                    echo "</pre>";
                    */

                    if (is_array($filebase) && (count($filebase) > 0))
                    {   // filebase.ini read successfully
                        // Print the contents of the array
                        foreach ($filebase as $key => $value)
                        {   // set update array
                            $updateFilebase[$key] = $value;
                        }
                    }
                    else
                    {   // unable to parse iniContent
                        echo "Error: filebase is not an array, unable to parse";
                        return false;
                    }
                }
                else
                {   // unable to read filebase from remote server
                    echo "Error: Unable to get content from remote server. Check if this file exists: $url";
                    return false;
                }

            }
            else
            {   // unable to read filebase from remote server
                echo "Error: Unable to read filebase from remote server. Check if this file exists: $url";
                return false;
            }

            // return array or false
            return $updateFilebase ?? false;
        }

    } // EOF class update
} // EOF namespace