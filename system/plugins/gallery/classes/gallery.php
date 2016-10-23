<?php
namespace YAWK\PLUGINS\GALLERY {

    class gallery
    {
        public function __construct(){
        // include 'system/plugins/messages/classes/messages.php';
        }

        public function drawFolderSelect($path)
        {
            echo "<select name=\"newFolder\" class=\"form-control\" id=\"newFolder\">
                  ".self::scanDir($path)."
                  </select>";
        }

        public function scanDir($path)
        {
            $html = '';
            if (!isset($path))
            {
                $path = "../media/images/"; // '.' for current
            }
            foreach (new \DirectoryIterator($path) as $file) {
                if ($file->isDot()) continue;

                if ($file->isDir()) {
                    // print $file->getFilename() . '<br>';
                    $html .= "<option value=\"".$file->getFilename()."\">".$file->getFilename()."</option>";
                }
            }
            return $html;
        }

        public function init()
        {
            // do something...
        }
    }
}