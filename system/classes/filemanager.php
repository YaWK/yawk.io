<?php
namespace YAWK {
    /**
     * <b>Basic File Manager (Backend)</b>
     *
     * This basic file manager class provides simple view, delete and upload methods.
     * <p><i>Class covers backend functionality.
     * See Methods Summary for details!</i></p>
     *
     * @category   CMS
     * @package    System
     * @global     $connection
     * @global     $dbprefix
     * @author     Daniel Retzl <danielretzl@gmail.com>
     * @copyright  2009-2015 Daniel Retzl yawk.goodconnect.net
     * @license    http://www.gnu.org/licenses/gpl-2.0  GNU/GPL 2.0
     * @version    1.1.3
     * @link       http://yawk.io
     * @since      File available since Release 0.0.9
     * @annotation Basic File Manager (Backend)
     */
    class filemanager
    {

        static function drawTableHeader($lang, $i)
        {
            print "<table width=\"100%\" cellpadding=\"4\" cellspacing=\"0\" border=\"0\" class=\"table table-hover\" id=\"table-sort$i\">
  <thead>
    <tr>
      <td width=\"10%\" class=\"text-right;\"><strong>$lang[FILEMAN_SIZE]</strong></td>
      <td width=\"70%\"><strong><i class=\"fa fa-caret-down\"></i> $lang[FILEMAN_FILENAME]</strong></td>
      <td width=\"10%\" class=\"text-center;\"><strong>$lang[FILEMAN_RIGHTS]</strong></td>
      <td width=\"10%\" class=\"text-center;\"><strong>$lang[ACTIONS]</strong></td>
    </tr>
  </thead>
  <tbody>";
        }

        static function drawTableFooter()
        {
            print "</tbody></table><br><br>";
        }

        static function getFilesFromFolder($folder)
        {
            global $file_value;

            /*	getFilesFromFolder
            *	returns a list of all files in given folder
            *	expect var $folder as string
            */
            if (!isset($folder)) {
                $folder = "images";
            }
            $path = "../media/" . "$folder";
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
          <td style=\"text-align:right;\"><a href=\"#\"><i class=\"fa fa-folder\"></i></a></td>
          <td><a href='$path" . "/" . "$dir_value'>$dir_value</a></td>
          <td style=\"text-align:left;\">$dir_perms</td>
          <td style=\"text-align:left;\">
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
          <td style=\"text-align:right;\">$fsize</td>
          <td><a href='$path" . "/" . "$file_value'>$file_value</a></td>
          <td class=\"text-center;\">$file_perms[$i]</td>
          <td class=\"text-center;\">
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

        static function deleteItem($file, $folder)
        {
            $folder = mb_strtolower($folder);
            @fclose($file);
            if (unlink($file))
            {   // success
                if (!isset($db)) { $db = new \YAWK\db(); }
                \YAWK\sys::setSyslog($db, 8, "deleted $file", 0, 0, 0, 0);
                print \YAWK\alert::draw("success", "Erfolg!", "Datei $file wurde erfolgreich gel&ouml;scht.","page=filemanager#$folder","2000");
                exit;
            }
            else
            {   // throw error
                \YAWK\sys::setSyslog($db, 5, "failed to delete $file", 0, 0, 0, 0);
                print \YAWK\alert::draw("danger", "Fehler!", "Datei $file konnte nicht erfolgreich gel&ouml;scht werden.","page=filemanager","4800");
                exit;
            }
        }

        static function getPhpMaxFileSize()
        {
            if ($postMaxSize = ini_get('post_max_size'))
            {   // return post max filesize
                return "$postMaxSize B\n";
            }
            else
                {   // ini_get failed
                    if (!isset($db)) { $db = new \YAWK\db(); }
                    \YAWK\sys::setSyslog($db, 5, "failed to ini_get post_max_size", 0, 0, 0, 0);
                    return false;
                }
        }


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

        static function getFilesOnlyFromFolder($folder)
        {
            foreach (new \DirectoryIterator($folder) as $fileInfo) {
                if($fileInfo->isDot()) continue;
                if($fileInfo->isDir()) continue;
                echo $fileInfo->getFilename() . "<br>\n";
            }
        }

        public function sizeFilter($bytes)
        {
            $label = array('B', 'KB', 'MB', 'GB', 'TB', 'PB');
            for ($i = 0; $bytes >= 1024 && $i < (count($label) - 1); $bytes /= 1024, $i++) ;
            return (round($bytes, 2) . " " . $label[$i]);
        } // end class filter
    }
}
