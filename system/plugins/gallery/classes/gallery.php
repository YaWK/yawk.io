<?php
namespace YAWK\PLUGINS\GALLERY {

    use YAWK\filemanager;

    class gallery
    {
        public $id;
        public $folder;
        public $title;
        public $description;
        public $images;


        public function __construct(){
        // include 'system/plugins/messages/classes/messages.php';
        }

        public function drawFolderSelect($path)
        {
            echo "<select name=\"folder\" class=\"form-control\" id=\"folder\">
                  <option value=\"Select Image Folder\">Select Image Folder</option>
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
                    $html .= "<option value=\"$path".$file->getFilename()."\">images/".$file->getFilename()."</option>";
                }
            }
            return $html;
        }


        public function init()
        {
            // do something...
        }

        public function delete($db)
        {   /** @var $db \YAWK\db **/
            // delete a gallery
            if (isset($_GET['id']) && (!empty($_GET['id']) && (is_numeric($_GET['id']))))
            {   // delete gallery from database
                if ($res = $db->query("DELETE FROM {plugin_gallery} WHERE id = '$_GET[id]'"))
                {   // gallery deleted...
                    // now go ahead with the items
                    if (!$deleteItems = $db->query("DELETE FROM {plugin_gallery_items} 
                                                           WHERE galleryID = '$_GET[id]'"))
                    {   // could not delete items
                        \YAWK\alert::draw("warning", "Could not delete gallery items from database", "Please try again!", "", 5800);
                    }

                    // ALTER table and set auto_increment value to prevent errors when deleting + adding new tpl
                    if ($res = $db->query("SELECT MAX(id) FROM {plugin_gallery}"))
                    {   // get MAX ID
                        $row = mysqli_fetch_row($res);
                        if (!$res = $db->query("ALTER TABLE {plugin_gallery} AUTO_INCREMENT $row[0]"))
                        {   // could not delete plugin_gallery
                            return false;
                        }
                    }
                    else
                        {   // could not get maxID, maybe there is not entry - reset auto increment value to zero
                            if (!$res = $db->query("ALTER TABLE {plugin_gallery} AUTO_INCREMENT 0"))
                            {   // could not select auto encrement
                                return false;
                            }
                        }
                }
                else
                    {   // delete failed, throw error
                        \YAWK\alert::draw("danger", "Could not delete this gallery", "Please try again!", "", 5800);
                    }
            }
            return true;
        }

        public function getGalleryFolderByID($db, $galleryID)
        {   /** @var $db \YAWK\db **/
            if ($res = $db->query("SELECT folder from {plugin_gallery} WHERE id='$galleryID'"))
            {   // fetch data
                $row = mysqli_fetch_row($res);
                return $row[0]; // return folder
            }
            else
                {   // error fetch data
                    return false;
                }
        }

        public function reScanFolder($db, $folder)
        {   /** @var $db \YAWK\db **/
            if (isset($_GET['id']) && (!empty($_GET['id']) && (is_numeric($_GET['id']))))
            {   // delete gallery items from db
                if (!$deleteItems = $db->query("DELETE FROM {plugin_gallery_items} WHERE galleryID = '$_GET[id]'"))
                {   // could not delete items
                    \YAWK\alert::draw("warning", "Could not delete gallery items from database", "Please try again!", "", 5800);
                }
                else
                {   // scan directory again
                    // iterate trough folder and save each file in a db row...
                    if (!isset($folder) && (empty($folder)))
                    {   // fetch folder if its not set
                        $this->folder = $this->getGalleryFolderByID($db, $_GET['id']);
                    }
                    foreach (new \DirectoryIterator($folder) as $fileInfo) {
                        if($fileInfo->isDot()) continue;
                        if($fileInfo->isDir()) continue;
                        $filename = $fileInfo->getFilename();
                        // TODO: this needs to be improved:
                        // TODO: 1 db insert per file is NOT! ok - but how to implement implode() correctly to avoid that memory lack?
                        if ($res = $db->query("INSERT INTO {plugin_gallery_items} (galleryID, filename, title, author, authorUrl)
                        VALUES ('" . $_GET['id'] . "','" . $filename . "','" . $filename . "','" . " " . "', '". " " ."')"))
                        {   // all good
                            // \YAWK\alert::draw("success", "Gallery created.", "Database entry success.", "", 800);
                        }
                        else
                        {   // error inserting data, throw notification
                            \YAWK\alert::draw("warning", "Could not insert $filename", "Database error. Please check folder and try again.", "", 1200);
                        }
                    }
                }
            }
            return true;
        }

        public function add($db)
        {   /** @var $db \YAWK\db **/
            // add a new gallery
            if (isset($_POST['folder']) && (!empty($_POST['folder'])))
            {   // gallery folder
                $this->folder = $db->quote($_POST['folder']);
            }
            if (isset($_POST['customFolder']) && (!empty($_POST['customFolder'])))
            {   // if a custom folder is set, overwrite gallery folder
                $this->folder = $_POST['customFolder'];
            }
            if (isset($_POST['title']) && (!empty($_POST['title'])))
            {   // gallery title
                $this->title = $db->quote($_POST['title']);
            }
            if (isset($_POST['description']) && (!empty($_POST['description'])))
            {   // gallery description
                $this->description = $db->quote($_POST['description']);
            }

            // add new gallery to database
            if ($res = $db->query("INSERT INTO {plugin_gallery} (folder, title, description)
                        VALUES ('" . $this->folder . "','" . $this->title . "','" . $this->description . "')"))
            {   // all good
                \YAWK\alert::draw("success", "Gallery created.", "Database entry success.", "", 800);
            }
            else
            {   // gallery could not be added - notify user
                \YAWK\alert::draw("danger", "Could not add the new gallery.", "Please check your data and try again.", "", 5800);
            }

            // get ID from current added gallery
            if ($res = $db->query("SELECT id from {plugin_gallery} WHERE folder = '$this->folder'"))
            {   // get last ID from db
                $row = mysqli_fetch_row($res);
                $galleryID = $row[0];
            }
            else
                {   // if ID cannot be found, use the gallery title as identifier
                    $galleryID = $this->title;
                }

            // iterate trough folder and save each file in a db row...
            foreach (new \DirectoryIterator($this->folder) as $fileInfo) {
                if($fileInfo->isDot()) continue;
                if($fileInfo->isDir()) continue;
                $filename = $fileInfo->getFilename();
                // TODO: this needs to be improved:
                // TODO: 1 db insert per file is NOT! ok - but how to implement implode() correctly to avoid that memory lack?
                if ($res = $db->query("INSERT INTO {plugin_gallery_items} (galleryID, filename, title, author, authorUrl)
                        VALUES ('" . $galleryID . "','" . $filename . "','" . $filename . "','" . " " . "', '". " " ."')"))
                {   // all good
                    // \YAWK\alert::draw("success", "Gallery created.", "Database entry success.", "", 800);
                }
                else
                    {   // error inserting data, throw notification
                        \YAWK\alert::draw("warning", "Could not insert $filename", "Database error. Please check folder and try again.", "", 1200);
                    }
            }
            return true;
        }

        public function getPreview($db, $lang)
        {   /** @var $db \YAWK\db **/
            // get gallery titles...
            if ($res = $db->query("SELECT * from {plugin_gallery}"))
            {
                while ($row = mysqli_fetch_assoc($res))
                {
                    if (!$getPreviewImages = $db->query("SELECT galleryID, filename from {plugin_gallery_items} WHERE galleryID = '$row[id]' LIMIT 5"))
                    {   // store info msg, if files could not be retrieved
                        $previewError = "Sorry, no preview available.";
                    }
                    // preview without images
                    echo "<div class=\"row\"><div class=\"col-md-4\"><a class=\"fa fa-trash-o\" role=\"dialog\" data-confirm=\"Soll die Galerie &laquo;" . $row['id'] . " / " . $row['title'] . "&raquo; wirklich gel&ouml;scht werden?\"
                      title=\"" . $lang['DEL'] . "\" href=\"index.php?plugin=gallery&delete=1&id=" . $row['id'] . "\"></a>
                      &nbsp;<a href=\"index.php?plugin=gallery&refresh=1&id=$row[id]&folder=$row[folder]\" title=\"refresh\"><i class=\"fa fa-refresh\"></i></a>
                      &nbsp;<b>".$row['title']."</b><br><small>".$row['description']."</small></div>
                    <div class=\"col-md-8\">";
                    if (isset($previewError))
                    {   // if files could not be loaded from db
                        echo $previewError;
                    }
                    else
                    {   // previewImage array is set, walk through it...
                        foreach ($getPreviewImages as $property => $image)
                        {   // display preview images
                            echo "<img src=\"$row[folder]/$image[filename]\" class=\"img-thumbnail\" width=\"100\">";
                        }
                    }
                    echo"</div></div>
                    <hr>";
                }
            }
            return null;
        }

    }
}