<?php
namespace YAWK {
    /**
     * @details <b>Basic File Manager (Backend)</b>
     *
     * This basic file manager class provides simple view, delete and upload methods.
     * <p><i>Class covers backend functionality.
     * See Methods Summary for details!</i></p>
     *
     * @author     Daniel Retzl <danielretzl@gmail.com>
     * @copyright  2009-2015 Daniel Retzl yawk.goodconnect.net
     * @license    https://opensource.org/licenses/MIT
     * @since      File available since Release 1.0.0
     * @brief Basic File Manager (Backend)
     */
    class filemanager
    {

        /**
         * @brief filemanager constructor.
         * check if all media subfolder exists, if not, try to create them
         */
        function __construct()
        {
            $folders = array('../media/images',
                            '../media/audio',
                            '../media/backup',
                            '../media/documents',
                            '../media/downloads',
                            '../media/mailbox',
                            '../media/uploads',
                            '../media/video');

            foreach ($folders as $folder)
            {
                if (!is_dir($folder))
                {
                    if (!mkdir($folder))
                    {
                        // todo: syslog: unable to create $folder
                        return false;
                    }
                }
            }
            return true;
        }

        /**
         * @brief draw the table header with labeling
         * @param array $lang language array
         * @param integer $i
         */
        static function drawTableHeader($lang, $i)
        {

            if (isset($_GET['path']) && (!empty($_GET['path'])))
            {
                $backBtn = "<a class=\"btn btn-success pull-right\" href=\"index.php?page=filemanager\" onclick=\"window.history.back();\"><i class=\"fa fa-level-up\"></i> &nbsp;$lang[BACK]</a>";
            }
            else
            {
                $backBtn = '';
            }

            print $backBtn;
            print "<table style=\"width:100%;\" class=\"table table-responsive table-hover\" id=\"table-sort$i\">
  <thead>
    <tr>
      <td style=\"width:10%;\" class=\"text-right\"><b>$lang[FILEMAN_SIZE]</b></td>
      <td style=\"width:70%;\" class=\"text-left\"><b>$lang[FILEMAN_FILENAME]</b></td>
      <td style=\"width:10%;\" class=\"text-center\"><b>$lang[FILEMAN_RIGHTS]</b></td>
      <td style=\"width:10%;\" class=\"text-center\"><b>$lang[ACTIONS]</b></td>
    </tr>
  </thead>
  <tbody>";
        }

        /**
         * @brief draw: output html end table body, end table
         */
        static function drawTableFooter()
        {
            print "</tbody></table><br><br>";
        }


        /**
         * @brief all folders in $path as select <option>...</option>
         * @param string $path rootpath that should be scanned and returned
         */
        static function subdirToOptions($path)
        {
            if (isset($path) && (!empty($path) && (is_dir($path))))
            {
                // init new iterator object
                $iter = new \RecursiveIteratorIterator(
                    new \RecursiveDirectoryIterator($path, \RecursiveDirectoryIterator::SKIP_DOTS),
                    \RecursiveIteratorIterator::SELF_FIRST,
                    \RecursiveIteratorIterator::CATCH_GET_CHILD // Ignore "Permission denied"
                );

                // if you wish to return an array, uncomment following line:
                // $paths = array($root);
                echo "<optgroup label=\"Subfolder\">";
                foreach ($iter as $path => $dir)
                {
                    if($dir->getFilename() === "audio") continue;
                    if($dir->getFilename() === "backup") continue;
                    if($dir->getFilename() === "documents") continue;
                    if($dir->getFilename() === "downloads") continue;
                    if($dir->getFilename() === "images") continue;
                    if($dir->getFilename() === "mailbox") continue;
                    if($dir->getFilename() === "uploads") continue;
                    if($dir->getFilename() === "video") continue;
                    if ($dir->isDir())
                    {
                        // if you wish to return an array, uncomment following line:
                        //  $paths[] = $path;
                        // you need subdir only in a var?- uncomment following line:
                        // $subdir = $dir->getFilename();

                    // adjust path
                    $subpath = ltrim($path, "..");          // remove dots
                    $subpath = ltrim($subpath, "/");        // remove pre slash
                    $subpath = ltrim($subpath, "media");    // remove not needed path
                    $subpath = ltrim($subpath, "/");        // remove trailing slash
                    $subpath = strtr($subpath,"\\","/");    // if run on win: backslashes2slashes
                    $label = ltrim($subpath, "/");          // remove trailing slash
                    $label = ucfirst($label);               // uppercase first char of label
                    echo "<option value=\"$subpath\">&nbsp;$label</option>";
                    }
                }

                // if you wish to return an array, uncomment following code block:
                /*
                if (isset($paths) && (is_array($paths)))
                {
                    return $paths;
                }
                else
                    {
                        return null;
                    }
                */
            }
        }

        /**
         * @brief returns a list of all files in given folder. expect $folder as string
         * @author     Daniel Retzl <danielretzl@gmail.com>
         * @copyright  2009-2015 Daniel Retzl yawk.goodconnect.net
         * @license    https://opensource.org/licenses/MIT
         * @param string $folder folder to look for files
         * @param string $path path to workout
         * @param array $lang current language array
         */
        static function getFilesFromFolder($folder, $lang)
        {
            global $file_value;

            // check if a path is requested via GET variable
            if (isset($_GET['path']) && (!empty($_GET['path'])))
            {   // set folder to given value
                $folder = $_GET['path'];
            }

            // if no folder is set
            if (!isset($folder)) {
                // show up any default folder
                $folder = "../media/images";
            }

            // if requested folder not exists, folder structure may be corrupt.
            // this can cause a crash if a system-needed folder was deleted.
            if (!is_dir($folder))
            {   // try to catch this - create missing folder
                if (!mkdir($folder))
                {   // could not create missing folder - bad exit, bad warning.
                    die ("$lang[FILEMAN_FOLDER_MISSING]");
                }
                // in any other case, everything is ok - go on...
            }
            // set path variable
            $path = "$folder";
            // walk through file structure...
            foreach (new \DirectoryIterator($path) as $file) {
                // fill files array
                if ($file->isFile()) {
                    // create files array
                    $files[] = htmlentities($file);
                    // get permissions
                    $file_perms[] = substr(sprintf('%o', fileperms($path . "/" . $file)), -4);
                    // get filesize
                    $file_size[] = filesize($path . "/" . $file);
                }
                // fill folders array
                if ($file->isDir() AND (!$file->isDot())) {
                    $folders[] = htmlentities($file);
                    $dir_perms[] = substr(sprintf('%o', fileperms($path . "/" . $file)), -4);
                }
            }
            // sort files asc/desc
            if (!empty($files)) {
                // insert sort here - if needed
            }
            // sort folders asc/desc
            if (!empty($folders)) {
                // sort($folders);
            }

            // if no files or folder was found
            if (empty($files) && (empty($folders)))
            {   // this directory is empty, show msg and draw back btn
                $errorMsg = "$lang[FILEMAN_THIS_EMPTY_DIR]<br>
                             <a href=\"index.php?page=filemanager\" onclick=\"window.history.back();\"> $lang[BACK]</a>";
            }
            else
                {   // no error message
                    $errorMsg = '';
                }

            /* OUTPUT:
             * list folders + files
             */
            // first of all, draw folders from array
            if (isset($folders))
            { // print folders
                $i = 0;
                $deleteIcon = "<i class=\"fa fa-trash-o\"></i>";
                foreach ($folders as $dir_value)
                {
                    // avoid warnings if no files or directories are found
                    if (!isset($file_perms[$i])){ $file_perms[$i] = ''; }
                    if (!isset($dir_perms[$i])){ $dir_perms[$i] = ''; }

                    // LIST FOLDERS
                    //    print "<strong>$dir_perms $dir_value</strong><br>";
                    echo "<tr>
          <td class=\"text-right\"><a href=\"?page=filemanager&path=$path" . "/$dir_value\"><div style=\"width:100%\"><i class=\"fa fa-folder\"></i></div></a></td>
          <td class=\"text-left\"><a href=\"?page=filemanager&path=$path" . "/$dir_value\"><div style=\"width:100%\">$dir_value</div></a></td>
          <td class=\"text-center\">$dir_perms[$i] <small><a class=\"fa fa-edit\" onclick=\"setChmodCode('$path/$file_value', '$file_perms[$i]');\" data-toggle=\"modal\" data-target=\"#chmodModal\" data-foldername=\"$file_perms[$i]\" title=\"$lang[FILEMAN_CHMOD]\" href=\"#myModal\"></a></small> </td>
          <td class=\"text-center\">
           <a class=\"fa fa-trash-o\" data-title=\"$lang[FILEMAN_REMOVE_FOLDER]\" data-itemtype=\"$lang[FOLDER]\" role=\"dialog\" data-confirm=\"$lang[FILEMAN_DELETE] &laquo;$dir_value&raquo;\"
            title=\"$lang[FILEMAN_REMOVE_FOLDER]\" data-target=\"#deleteModal\" data-toggle=\"modal\" href=\"index.php?page=filemanager&delete=1&path=$path&item=$dir_value&folder=$folder\"></a>
            &nbsp;
           <a class=\"fa fa-pencil\" id=\"renameToggle\" onclick=\"setRenameFieldState('$path', '$dir_value', '$lang[FILEMAN_RENAME_FOLDER]');\" data-toggle=\"modal\" data-target=\"#renameModal\" data-foldername=\"$dir_value\" title=\"$lang[RENAME]\" href=\"#myModal\"></a>
          </td>
        </tr>";
                    $i++;
                }
            }
            else
                {   // if directory is empty, display this info instead of data
                    echo "<tr>
                            <td></td>
                            <td>$errorMsg</td>
                            <td></td>
                            <td></td>
                          </tr>";
                }

            // secondly draw files from array
            if (isset($files))
            { // print files
                $i = 0;
                foreach ($files as $file_value) {

                    $fsize = \YAWK\filemanager::sizeFilter($file_size[$i], 1);
                    echo "<tr>
          <td class=\"text-right\">$fsize</td>
          <td class=\"text-left\"><a href='$path" . "/$file_value'><div style=\"width:100%\">$file_value</div></a></td>
          <td class=\"text-center\">$file_perms[$i] <small><a class=\"fa fa-edit\" onclick=\"setChmodCode('$path/$file_value', '$file_perms[$i]');\" data-toggle=\"modal\" data-target=\"#chmodModal\" data-foldername=\"$file_perms[$i]\" title=\"$lang[FILEMAN_CHMOD]\" href=\"#myModal\"></a></small></td>
          <td class=\"text-center\">

           <a class=\"fa fa-trash-o\" role=\"dialog\" data-confirm=\"$lang[FILEMAN_DELETE] &laquo;$file_value&raquo;\" 
            title=\"$lang[FILEMAN_REMOVE_FILE]\" data-target=\"#moveModal\" data-toggle=\"modal\" href='index.php?page=filemanager&delete=1&path=$path&item=$file_value&folder=$folder'></a>
            &nbsp;
           <a class=\"fa fa-pencil\" onclick=\"setRenameFieldState('$path', '$file_value', '$lang[FILEMAN_RENAME_FILE]');\" data-toggle=\"modal\" data-target=\"#renameModal\" data-foldername=\"$file_value\" title=\"$lang[RENAME]\" href=\"#myModal\"></a>
          </td>        
        </tr>";
                    $i++;
                }
            } else {
                //	print "<br><h4>There are no files in $folder.</h4>";

            }
        }

        /**
         * @brief Delete a directory recursive
         * @author     Daniel Retzl <danielretzl@gmail.com>
         * @copyright  2009-2017 Daniel Retzl
         * @license    https://opensource.org/licenses/MIT
         * @param string $directory folder to delete
         */
        static function recursiveRemoveDirectory($directory)
        {   // walk through directory
            foreach(glob("{$directory}/*") as $file)
            {   // if it's a directory
                if(is_dir($file))
                {   // call ourself
                    self::recursiveRemoveDirectory($file);
                }
                else
                    {   // delete folder
                        unlink($file);
                    }
            }
            // directory removed
            if (rmdir($directory))
            {   // successful
                return true;
            }
            else
                {   // remove folder failed
                    return false;
                }
        }

        /**
         * @brief delete file from folder
         * @author     Daniel Retzl <danielretzl@gmail.com>
         * @copyright  2009-2015 Daniel Retzl
         * @license    https://opensource.org/licenses/MIT
         * @param string $file file to delete
         * @param string $folder folder containing the file
         */
        static function deleteItem($file)
        {
            // check if it is a directory or a file and set relevant actions

            // FOLDER
            if (is_dir($file))
            {   // lets run recursive directory removal function...
                if (self::recursiveRemoveDirectory($file))
                {   // folder + its content deleted
                    return true;
                }
                else
                    {   // could not recursive delete folder
                        // die ("recursiveRemoveDirectory failed");
                        return false;
                    }
            }

            // FILE
            else if (is_file($file))
            {   // check if unlink worked
                if (@unlink($file))
                {   // all good
                    return true;
                }
                else
                {   // on error
                    return false;
                }
            }
            else
                {   // item is not a file nor a directory
                    // die ("item not found.");
                    return false;
                }
        }

        /**
         * @brief get and return post_max_size value from phpinfo()
         * @author     Daniel Retzl <danielretzl@gmail.com>
         * @copyright  2009-2016 Daniel Retzl
         * @license    https://opensource.org/licenses/MIT
         * @return     string|false
         */
        static function getPostMaxSize()
        {

            if ($postMaxSize = ini_get('post_max_size'))
            {   // return post max filesize
                return $postMaxSize;
            }
            else
            {   // ini_get failed
                if (!isset($db)) { $db = new \YAWK\db(); }
                \YAWK\sys::setSyslog($db, 27, 1, "failed to ini_get post_max_size", 0, 0, 0, 0);
                echo "Unable to get post_max_size";
                return false;
            }
        }

        /**
         * @brief get and return upload max filesize value from phpinfo()
         * @author     Daniel Retzl <danielretzl@gmail.com>
         * @copyright  2009-2016 Daniel Retzl
         * @license    https://opensource.org/licenses/MIT
         * @return     string|false
         */
        static function getUploadMaxFilesize()
        {

            if ($upload_max_filesize = ini_get('upload_max_filesize'))
            {   // upload_max_filesize
                return $upload_max_filesize;
            }
            else
            {   // ini_get failed
                if (!isset($db)) { $db = new \YAWK\db(); }
                \YAWK\sys::setSyslog($db, 27, 1, "failed to ini_get upload_max_filesize", 0, 0, 0, 0);
                return false;
            }
        }

        /**
         * @brief get and return PHP max file size setting
         * @author     Daniel Retzl <danielretzl@gmail.com>
         * @copyright  2009-2016 Daniel Retzl
         * @license    https://opensource.org/licenses/MIT
         * @return bool|string
         */
        static function getPhpMaxUploadSize()
        {
            $returnValue = '';

            if ($postMaxSize = ini_get('post_max_size'))
            {   // return post max filesize
                $returnValue = $postMaxSize;
            }
            if ($upload_max_filesize = ini_get('upload_max_filesize'))
            {   // upload_max_filesize
                $returnValue .= " (".$upload_max_filesize.")";
            }
            else
                {   // ini_get failed
                    if (!isset($db)) { $db = new \YAWK\db(); }
                    \YAWK\sys::setSyslog($db, 27, 1, "failed to ini_get post_max_size", 0, 0, 0, 0);
                    return false;
                }

            return $returnValue;
        }


        /**
         * @brief count files from folder
         * @author     Daniel Retzl <danielretzl@gmail.com>
         * @copyright  2009-2016 Daniel Retzl
         * @license    https://opensource.org/licenses/MIT
         * @param string $folder to search for files
         * @return int number of files in folder
         */
        static function countFilesFromFolder($folder)
        {
            $i = 0;
            foreach (new \DirectoryIterator($folder) as $fileInfo) {
                if($fileInfo->isDot()) continue;
                if($fileInfo->isDir()) continue;
                $i++;
            }
            return $i;
        }

        /**
         * @brief output a list showing only files from folder (no subfolders)
         * @author     Daniel Retzl <danielretzl@gmail.com>
         * @copyright  2009-2016 Daniel Retzl
         * @license    https://opensource.org/licenses/MIT
         * @param string $folder to get files from
         */
        static function getFilesOnlyFromFolder($folder)
        {
            foreach (new \DirectoryIterator($folder) as $fileInfo) {
                if($fileInfo->isDot()) continue;
                if($fileInfo->isDir()) continue;
                echo $fileInfo->getFilename() . "<br>\n";
            }
        }

        /**
         * @brief remove special chars as well as leading and trailing slashes from string
         * @author     Daniel Retzl <danielretzl@gmail.com>
         * @copyright  2017 Daniel Retzl
         * @license    https://opensource.org/licenses/MIT
         * @param string $string the affected string
         */
        static function removeSpecialChars($string)
        {
            if (isset($string) && (!empty($string)))
            {
                // $string = 'V!e§r$s%c&h/i(e)d=e?n`e² S³o{n[d]e]r}z\e´i+c*h~e#n';
                // remove special chars
                $string = preg_replace ('/[^a-z0-9-. ]/i', '', $string);
                // trim any whitespaces left or right
                $string = trim($string);
                // change any backslashes to regular slashes
                $string = strtr($string,"\\","/");
                // remove all leading slashes
                $string = ltrim($string, "/");
                // remove all trailing slashes
                $string = rtrim($string, "/");
                return $string;
            }
            else
                {
                    return null;
                }
        }

        /**
         * @brief returns an array containing only files from folder (no subfolders)
         * @author     Daniel Retzl <danielretzl@gmail.com>
         * @copyright  2009-2016 Daniel Retzl
         * @license    https://opensource.org/licenses/MIT
         * @param string $folder to get files from
         */
        static function getFilesFromFolderToArray($folder)
        {
            $files = array();
            foreach (new \DirectoryIterator($folder) as $fileInfo) {
                if($fileInfo->isDot()) continue;
                if($fileInfo->isDir()) continue;
                $files[] = $fileInfo->getFilename();
            }
            return $files;
        }

        /**
         * @brief returns an array containing only files from folder (no subfolders)
         * @author     Daniel Retzl <danielretzl@gmail.com>
         * @copyright  2009-2016 Daniel Retzl
         * @license    https://opensource.org/licenses/MIT
         * @param string $folder to get files from
         */
        static function getSubfoldersToArray($folder)
        {
            $subFolders = array();
            foreach (new \DirectoryIterator($folder) as $fileInfo) {
                if($fileInfo->isDot()) continue;
                if($fileInfo->isFile()) continue;
                if($fileInfo->isDir())
                $subFolders[] = $fileInfo->getFilename();
            }
            return $subFolders;
        }

        /**
         * @brief returns an multidimensional array containing subfolders + files of given folder
         * @param string $folder to get files from
         * @return array|null
         */
        static function ritit($folder)
        {
            if (isset($folder) && (!empty($folder) && (is_string($folder))))
            {
                $ritit = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($folder, \RecursiveDirectoryIterator::SKIP_DOTS), \RecursiveIteratorIterator::CHILD_FIRST);
                $r = array();
                foreach ($ritit as $splFileInfo) {

                    $path = $splFileInfo->isDir()
                        ? array($splFileInfo->getFilename() => array())
                        : array($splFileInfo->getFilename());

                    for ($depth = $ritit->getDepth() - 1; $depth >= 0; $depth--) {
                        $path = array($ritit->getSubIterator($depth)->current()->getFilename() => $path);

                    }
                    $r = array_merge_recursive($r, $path);
                }
                if (is_array($r))
                {
                    return $r;
                }
                else
                    {
                        return null;
                    }
            }
            else
                {
                    return null;
                }
        }

        /**
         * @brief calculate filesize from bytes
         * @author     Daniel Retzl <danielretzl@gmail.com>
         * @copyright  2009-2016 Daniel Retzl
         * @license    https://opensource.org/licenses/MIT
         * @param int|string $bytes
         * @param int|string $precision how many decimal places?
         * @return string rounded, human-readable bytes
         */
        static function sizeFilter($bytes, $precision)
        {
            // if no precision is set
            if (!isset($precision) || (empty($precision)))
            {   // set default: no decimal place
                $precision = 0;
            }
            // different sizes
            $label = array('B', 'KB', 'MB', 'GB', 'TB', 'PB');
            // calculate filesize
            for ($i = 0; $bytes >= 1024 && $i < (count($label) - 1); $bytes /= 1024, $i++) ;
            // return calculated filesize
            return (round($bytes, $precision) . " " . $label[$i]);
        } // end class filter


        /**
         * @brief Fast generation of a complete uptodate mime types list
         * @return bool|string
         */
        static function getCurrentMimeTypes()
        {
            $url = "http://svn.apache.org/repos/asf/httpd/httpd/trunk/docs/conf/mime.types";
            $s=array();
            foreach(@explode("\n",@file_get_contents($url))as $x)
                if(isset($x[0])&&$x[0]!=='#'&&preg_match_all('#([^\s]+)#',$x,$out)&&isset($out[1])&&($c=count($out[1]))>1)
                    for($i=1;$i<$c;$i++)
                        $s[]='&nbsp;&nbsp;&nbsp;\''.$out[1][$i].'\' => \''.$out[1][0].'\'';
            return @sort($s)?'$mime_types = array(<br />'.implode($s,',<br />').'<br />);':false;
        }
    }
}
