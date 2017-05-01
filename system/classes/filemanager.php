<?php
namespace YAWK {
    /**
     * <b>Basic File Manager (Backend)</b>
     *
     * This basic file manager class provides simple view, delete and upload methods.
     * <p><i>Class covers backend functionality.
     * See Methods Summary for details!</i></p>
     *
     * @package    YAWK
     * @author     Daniel Retzl <danielretzl@gmail.com>
     * @copyright  2009-2015 Daniel Retzl yawk.goodconnect.net
     * @license    http://www.gnu.org/licenses/gpl-2.0  GNU/GPL 2.0
     * @link       http://yawk.io
     * @since      File available since Release 1.0.0
     * @annotation Basic File Manager (Backend)
     */
    class filemanager
    {

        /**
         * draws the table header with labeling
         * @param array $lang language array
         * @param integer $i
         */
        static function drawTableHeader($lang, $i)
        {
            print "<table width=\"100%\" cellpadding=\"4\" cellspacing=\"0\" border=\"0\" class=\"table table-responsive table-hover\" id=\"table-sort$i\">
  <thead>
    <tr>
      <td width=\"10%\" class=\"text-right\"><b>$lang[FILEMAN_SIZE]</b></td>
      <td width=\"70%\" class=\"text-left\"><b>$lang[FILEMAN_FILENAME]</b></td>
      <td width=\"10%\" class=\"text-center\"><b>$lang[FILEMAN_RIGHTS]</b></td>
      <td width=\"10%\" class=\"text-center\"><b>$lang[ACTIONS]</b></td>
    </tr>
  </thead>
  <tbody>";
        }

        /**
         * draw: output html end table body, end table
         */
        static function drawTableFooter()
        {
            print "</tbody></table><br><br>";
        }


        /**
         * all folders in $path as select <option>...</option>
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
                    $label = ltrim($subpath, "/");        // remove trailing slash
                    $label = ucfirst($label);             // uppercase first char of label
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
         * returns a list of all files in given folder. expect $folder as string
         * @author     Daniel Retzl <danielretzl@gmail.com>
         * @copyright  2009-2015 Daniel Retzl yawk.goodconnect.net
         * @license    http://www.gnu.org/licenses/gpl-2.0  GNU/GPL 2.0
         * @link       http://yawk.io
         * @param string $folder folder to look for files
         */
        static function getFilesFromFolder($folder)
        {
            global $file_value;

            /*	getFilesFromFolder
            *	returns a list of all files in given folder
            *	expect var $folder as string
            */
            if (!isset($folder)) {
                $folder = "../media/images";
            }
            $path = "$folder";
            foreach (new \DirectoryIterator($path) as $file) {
                if ($file->isFile()) {
                    // create files array
                    $files[] = htmlentities($file);
                    // get permissions
                    $file_perms[] = substr(sprintf('%o', fileperms($path . "/" . $file)), -4);
                    // get filesize
                    $file_size[] = filesize($path . "/" . $file);
                }
                if ($file->isDir() AND (!$file->isDot())) {
                    $folders[] = htmlentities($file);
                    $dir_perms = substr(sprintf('%o', fileperms($path . "/" . $file)), -4);
                } else {
                    $dir_perms = "";
                }
            }
            // sort ascending
            if (!empty($files)) {
                // insert sort here - if needed 
            }
            if (!empty($folders)) {
                // sort($folders); 
            }


            /* OUTPUT:
             * list folders + files
             */
            if (isset($folders)) { // print folder
                foreach ($folders as $dir_value) {
                    // LIST FOLDERS
                    //    print "<strong>$dir_perms $dir_value</strong><br>";
                    echo "<tr>
          <td class=\"text-right\"><a href=\"#\"><i class=\"fa fa-folder\"></i></a></td>
          <td class=\"text-left\"><a href='$path" . "/" . "$dir_value'>$dir_value</a></td>
          <td class=\"text-center\">$dir_perms</td>
          <td class=\"text-center\">
           <a class=\"fa fa-trash-o\" role=\"dialog\" data-confirm=\"Den Folder &laquo;$dir_value&raquo; wirklich l&ouml;schen?\"
            title=\"delete\" data-target=\"#moveModal\" data-toggle=\"modal\" href='index.php?page=filemanager&delete=1&path=$path&item=$dir_value&folder=$folder'></a>
          </td>
        </tr>";
                }
            }

            if (isset($files)) { // print files
                $i = 0;
                foreach ($files as $file_value) {

                    $fsize = \YAWK\filemanager::sizeFilter($file_size[$i]);
                    echo "<tr>
          <td class=\"text-right\">$fsize</td>
          <td class=\"text-left\"><a href='$path" . "/" . "$file_value'>$file_value</a></td>
          <td class=\"text-center\">$file_perms[$i]</td>
          <td class=\"text-center\">
          <!--
           <a data-toggle=\"modal\" data-target=\"#myModal2\" href=\"index.php?page=filemanager&move=1&path=$path&item=$file_value&folder=$folder#mymodal2\"><i class=\"fa fa-exchange\"></i></a>
            &nbsp; -->

           <a class=\"fa fa-trash-o\" role=\"dialog\" data-confirm=\"Die Datei &laquo;$file_value&raquo; wirklich l&ouml;schen?\" 
            title=\"delete\" data-target=\"#moveModal\" data-toggle=\"modal\" href='index.php?page=filemanager&delete=1&path=$path&item=$file_value&folder=$folder'></a>
          </td>        
        </tr>";
                    $i++;
                }
            } else {
                //	print "<br><h4>There are no files in $folder.</h4>";

            }
        }

        static function recursiveRemoveDirectory($directory)
        {
            foreach(glob("{$directory}/*") as $file)
            {
                if(is_dir($file))
                {
                    self::recursiveRemoveDirectory($file);
                }
                else
                    {
                        unlink($file);
                    }
            }
            if (rmdir($directory))
            {
                return true;
            }
            else
                {
                    return false;
                }
        }

        /**
         * delete file from folder
         * @author     Daniel Retzl <danielretzl@gmail.com>
         * @copyright  2009-2015 Daniel Retzl
         * @license    http://www.gnu.org/licenses/gpl-2.0  GNU/GPL 2.0
         * @link       http://yawk.io
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
         * get and return PHP max file size setting
         * @author     Daniel Retzl <danielretzl@gmail.com>
         * @copyright  2009-2016 Daniel Retzl
         * @license    http://www.gnu.org/licenses/gpl-2.0  GNU/GPL 2.0
         * @link       http://yawk.io
         * @return bool|string
         */
        static function getPhpMaxFileSize()
        {
            if ($postMaxSize = ini_get('post_max_size'))
            {   // return post max filesize
                return "$postMaxSize";
            }
            else
                {   // ini_get failed
                    if (!isset($db)) { $db = new \YAWK\db(); }
                    \YAWK\sys::setSyslog($db, 5, "failed to ini_get post_max_size", 0, 0, 0, 0);
                    return false;
                }
        }


        /**
         * count files from folder
         * @author     Daniel Retzl <danielretzl@gmail.com>
         * @copyright  2009-2016 Daniel Retzl
         * @license    http://www.gnu.org/licenses/gpl-2.0  GNU/GPL 2.0
         * @link       http://yawk.io
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
         * output a list showing only files from folder (no subfolders)
         * @author     Daniel Retzl <danielretzl@gmail.com>
         * @copyright  2009-2016 Daniel Retzl
         * @license    http://www.gnu.org/licenses/gpl-2.0  GNU/GPL 2.0
         * @link       http://yawk.io
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
         * returns an array containing only files from folder (no subfolders)
         * @author     Daniel Retzl <danielretzl@gmail.com>
         * @copyright  2009-2016 Daniel Retzl
         * @license    http://www.gnu.org/licenses/gpl-2.0  GNU/GPL 2.0
         * @link       http://yawk.io
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
         * returns an array containing only files from folder (no subfolders)
         * @author     Daniel Retzl <danielretzl@gmail.com>
         * @copyright  2009-2016 Daniel Retzl
         * @license    http://www.gnu.org/licenses/gpl-2.0  GNU/GPL 2.0
         * @link       http://yawk.io
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
         * calculate filesize from bytes
         * @author     Daniel Retzl <danielretzl@gmail.com>
         * @copyright  2009-2016 Daniel Retzl
         * @license    http://www.gnu.org/licenses/gpl-2.0  GNU/GPL 2.0
         * @link       http://yawk.io
         * @param int|string $bytes
         * @return string rounded, human-readable bytes
         */
        public function sizeFilter($bytes)
        {
            $label = array('B', 'KB', 'MB', 'GB', 'TB', 'PB');
            for ($i = 0; $bytes >= 1024 && $i < (count($label) - 1); $bytes /= 1024, $i++) ;
            return (round($bytes, 2) . " " . $label[$i]);
        } // end class filter
    }
}
