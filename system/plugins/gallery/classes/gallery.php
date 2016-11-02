<?php
namespace YAWK\PLUGINS\GALLERY {

    class gallery
    {
        public $id;
        public $itemID;
        public $action;
        public $folder;
        public $title;
        public $itemTitle;
        public $description;
        public $author;
        public $authorUrl;
        public $itemAuthor;
        public $itemAuthorUrl;
        public $filename;
        public $createThumbnails;
        public $thumbnailWidth;
        public $watermark;
        public $watermarkImage;
        public $watermarkPosition;
        public $offsetBottom;
        public $offsetRight;
        public $watermarkFont;
        public $watermarkTextSize;
        public $watermarkOpacity;
        public $watermarkColor;
        public $watermarkBorderColor;
        public $watermarkBorder;

        public function __construct()
        {
            echo "<script type=\"text/javascript\">
                function doImageAction(action, folder, filename, itemID, createThumbnails, thumbnailWidth, watermark, watermarkImage, watermarkOpacity, watermarkPosition, offsetRight, offsetBottom, watermarkFont, watermarkTextSize, watermarkColor, watermarkBorderColor, watermarkBorder) 
                {                    
                    $.ajax({
                        url:'../system/plugins/gallery/js/actions.php',
                        type:'post',
                        data:'action='+action+'&folder='+folder+'&filename='+filename+'&itemID='+itemID+'&createThumbnails='+createThumbnails+'&thumbnailWidth='+thumbnailWidth+'&watermark='+watermark+'&watermarkImage='+watermarkImage+'&watermarkOpacity='+watermarkOpacity+'&watermarkPosition='+watermarkPosition+'&offsetRight='+offsetRight+'&offsetBottom='+offsetBottom+'&watermarkFont='+watermarkFont+'&watermarkTextSize='+watermarkTextSize+'&watermarkColor='+watermarkColor+'&watermarkBorderColor='+watermarkBorderColor+'&watermarkBorder='+watermarkBorder,
                        success: function(data)
                        {   // check if data was sent
                            if(!data)
                            {   // something else has happened
                                $('#img-'+itemID).hide().removeAttr('src').attr('src', '../'+folder+'/'+filename+'?'+Math.random()).show();
                                return false;
                            }
                            else
                            {   // all good, reload image
                                alert('Sorry, there was an error executing this command. Maybe there is a problem with the image folders. Please check folder permissions first.');
                            }
                        }
                    });
                }
                </script>";
        }

        public function drawFolderSelect($path)
        {
            echo "<select name=\"folder\" class=\"form-control\" id=\"folder\">
                  <option value=\"Select Image Folder\">Select Image Folder</option>
                  ".self::scanImageDirectory($path)."
                  </select>";
        }

        public function drawFolderSelectFromGallery($path, $folder)
        {
            echo "<select name=\"folder\" class=\"form-control\" id=\"folder\">
                  <option value=\"$folder\">$folder</option>
                  ".self::scanImageDirectory($path)."
                  </select>";
        }

        public function checkDir($folder)
        {   // check if directory exists
            if (!is_dir("$folder/")) {
                mkdir("$folder/");
            }
        }


        public function scanFonts($path)
        {
            $html = '';
            if (!isset($path))
            {
                $path = "../system/fonts/"; // '.' for current
            }
            foreach (new \DirectoryIterator("$path") as $file) {
                if ($file->isDot()) continue;
                if ($file->isDir()) continue;
                if ($file->getExtension() === "ttf")
                {
                    // print $file->getFilename() . '<br>';
                    $html .= "<option value=\"$path".$file->getFilename()."\">system/fonts/".$file->getFilename()."</option>";
                }

            }
            return $html;
        }

        public function scanImageDirectory($path)
        {
            $html = '';
            if (!isset($path))
            {
                $path = "media/images/"; // '.' for current
            }
            foreach (new \DirectoryIterator("../$path") as $file) {
                if ($file->isDot()) continue;
                if ($file->isDir()) {
                    // print $file->getFilename() . '<br>';
                    $html .= "<option value=\"$path".$file->getFilename()."\">images/".$file->getFilename()."</option>";
                }
            }
            return $html;
        }

        public function delete($db)
        {   /** @var $db \YAWK\db **/
            // delete a gallery
            if (isset($_GET['id']) && (!empty($_GET['id']) && (is_numeric($_GET['id']))))
            {
                // gallery folder
                $folder = $this->getGalleryFolderByID($db, $_GET['id']);
                // DELETE FILES
                // check if thumbnail directory is here
                if (is_dir("../$folder/thumbnails/"))
                {   // try to delete it recursively
                    if (!\YAWK\sys::recurseRmdir("../$folder/thumbnails/"))
                    {   // did not work, throw notification
                        \YAWK\alert::draw("warning", "Could not delete thumbnails!", "$folder/thumbnails could not be deleted.", "", 5800);
                    }
                    else
                        {   // thumbnails deleted success msg
                            \YAWK\alert::draw("success", "Thumbnails deleted!", "$folder/thumbnails is removed.", "", 1200);
                        }
                }
                // check if edit directory is here
                if (is_dir("../$folder/edit/"))
                {   // try to delete it recursively
                    if (!\YAWK\sys::recurseRmdir("../$folder/edit/"))
                    {   // did not work, throw notification
                        \YAWK\alert::draw("warning", "Could not delete edit folder!", "$folder/edit could not be deleted.", "", 5800);
                    }
                    else
                    {   // delete edit (tmp) folder did not work, throw notify...
                        // \YAWK\alert::draw("success", "TMP folder deleted!", "$folder/edit is removed.", "", 1200);
                    }
                }

                // check if there are backup files to restore
                if (is_dir("../$folder/original/"))
                {
                    // delete images in root folder of this gallery
                    foreach (new \DirectoryIterator("../$folder/") as $fileInfo) {
                        if($fileInfo->isDir()) continue;
                        if($fileInfo->isDot()) continue;
                        $filename = $fileInfo->getFilename();
                        unlink("../$folder/$filename");
                    }
                    // copy images back from backup folder
                    foreach (new \DirectoryIterator("../$folder/original") as $fileInfo) {
                        if($fileInfo->isDir()) continue;
                        if($fileInfo->isDot()) continue;
                        $filename = $fileInfo->getFilename();
                        // copy files from backup folder back to root directory
                        if (!copy("../$folder/original/$filename", "../$folder/$filename"))
                        {   // could not copy file, throw notification
                            \YAWK\alert::draw("warning", "Could not restore file $filename", "This should not happen. We're sorry!", "", 800);
                        }
                    }

                    // delete backup folder
                    if (!\YAWK\sys::recurseRmdir("../$folder/original/"))
                    {   // did not work, throw notification
                        \YAWK\alert::draw("warning", "Could not delete backup folder!", "$folder/original could not be deleted.", "", 5800);
                    }
                }

                // delete gallery from database
                if ($res = $db->query("DELETE FROM {plugin_gallery} WHERE id = '$_GET[id]'"))
                {   // gallery deleted...
                    // now go ahead with the items
                    if (!$deleteItems = $db->query("DELETE FROM {plugin_gallery_items} 
                                                           WHERE galleryID = '$_GET[id]'"))
                    {   // could not delete items
                        \YAWK\alert::draw("warning", "Could not delete gallery items from database", "Please try again!", "", 5800);
                    }

                    // RESET AUTO INCREMENT
                    // ALTER table and set auto_increment value to prevent errors when deleting + adding new tpl
                    if ($alterTable = $db->query("SELECT MAX(id) FROM {plugin_gallery}"))
                    {   // get MAX ID
                        $row = mysqli_fetch_row($alterTable);
                        if ($row[0] >= 1)
                        {
                            if (!$alterTable = $db->query("ALTER TABLE {plugin_gallery} AUTO_INCREMENT=$row[0]"))
                            {   // could not delete plugin_gallery
                                return false;
                            }
                        }
                        else
                            {
                                // could not get maxID, maybe there is not entry - reset auto increment value to zero
                                if (!$alterTable = $db->query("ALTER TABLE {plugin_gallery} AUTO_INCREMENT=1"))
                                {   // could not select auto encrement
                                    return false;
                                }

                            }
                    }
                    // RESET AUTO INCREMENT
                    // ALTER table and set auto_increment value to prevent errors when deleting + adding new tpl
                    if ($alterItemsTable = $db->query("SELECT MAX(id) FROM {plugin_gallery_items}"))
                    {   // get MAX ID
                        $row = mysqli_fetch_row($alterItemsTable);
                        if ($row[0] >= 1)
                        {
                            if (!$alterItemsTable = $db->query("ALTER TABLE {plugin_gallery_items} AUTO_INCREMENT=$row[0]"))
                            {   // could not delete plugin_gallery
                                return false;
                            }
                        }
                        else
                        {
                            // could not get maxID, maybe there is not entry - reset auto increment value to zero
                            if (!$alterItemsTable = $db->query("ALTER TABLE {plugin_gallery_items} AUTO_INCREMENT=1"))
                            {   // could not select auto encrement
                                return false;
                            }

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
                $this->delete($db);
                $this->add($db);

            }
            return true;
        }

        public function add($db)
        {   /** @var $db \YAWK\db **/
            // add a new gallery
            // 1.) check vars
            // 2.) manipulate images corresponding to selected settings
            // 3.) insert into database

            // loading info...
            \YAWK\alert::draw("success", "Gallery will be created. . .", "<div class=\"text-center\"><i class=\"fa fa-spinner fa-spin\" style=\"font-size:24px\"></i><br>Please be patient, this should only take a few seconds.</div>", "", 3800);

            // include SimpleImage Class
            require_once 'SimpleImage.php';
            // create object
            $img = new \YAWK\SimpleImage();

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
            if (isset($_POST['createThumbnails']) && (!empty($_POST['createThumbnails'])))
            {   // thumbnails? 0|1
                $this->createThumbnails = $db->quote($_POST['createThumbnails']);
            }
            if (isset($_POST['thumbnailWidth']) && (!empty($_POST['thumbnailWidth'])))
            {   // thumbnail width in px
                $this->thumbnailWidth = $db->quote($_POST['thumbnailWidth']);
            }
            if (isset($_POST['watermark']) && (!empty($_POST['watermark'])))
            {   // any string can do the watermark job
                $this->watermark = $db->quote($_POST['watermark']);
            }
            if (isset($_POST['watermarkPosition']) && (!empty($_POST['watermarkPosition'])))
            {   // position of the watermark (bottom left, bottom right, top left, top right, bottom, center, top)
                $this->watermarkPosition = $db->quote($_POST['watermarkPosition']);
            }
            if (isset($_POST['author']) && (!empty($_POST['author'])))
            {   // name of the author, studio, photographer, originator
                $this->author = $db->quote($_POST['author']);
            }
            if (isset($_POST['authorUrl']) && (!empty($_POST['authorUrl'])))
            {   // url of the photographer (author, originator)
                $this->authorUrl = $db->quote($_POST['authorUrl']);
            }
            if (isset($_POST['watermarkImage']) && (!empty($_POST['watermarkImage'])))
            {   // any image used as watermark (preferably transparent png-24)
                $this->watermarkImage = $db->quote($_POST['watermarkImage']);
            }
            if (isset($_POST['offsetBottom']) && (!empty($_POST['offsetBottom'])))
            {   // offset bottom (from bottom)
                $this->offsetBottom = $db->quote($_POST['offsetBottom']);
            }
            if (isset($_POST['offsetRight']) && (!empty($_POST['offsetRight'])))
            {   // offset right (from right)
                $this->offsetRight = $db->quote($_POST['offsetRight']);
            }
            if (isset($_POST['watermarkFont']) && (!empty($_POST['watermarkFont'])))
            {   // true type font to use for watermarking (located in system/fonts/)
                // $this->watermarkFont = $db->quote($_POST['watermarkFont']);
                $this->watermarkFont = ($_POST['watermarkFont']);
            }
            if (isset($_POST['watermarkTextSize']) && (!empty($_POST['watermarkTextSize'])))
            {   // text size of your watermark
                $this->watermarkTextSize = $db->quote($_POST['watermarkTextSize']);
            }
            if (isset($_POST['watermarkOpacity']) && (!empty($_POST['watermarkOpacity'])))
            {   // opacity (this works only, when watermark is set to an image!)
                $this->watermarkOpacity = $db->quote($_POST['watermarkOpacity']);
            }
            if (isset($_POST['watermarkColor']) && (!empty($_POST['watermarkColor'])))
            {   // text color of your text-watermark
                $this->watermarkColor = $db->quote($_POST['watermarkColor']);
            }
            if (isset($_POST['watermarkBorderColor']) && (!empty($_POST['watermarkBorderColor'])))
            {   // border color of your text-watermark
                $this->watermarkBorderColor = $db->quote($_POST['watermarkBorderColor']);
            }
            if (isset($_POST['watermarkBorder']) && (!empty($_POST['watermarkBorder'])))
            {   // text-border in px
                $this->watermarkBorder = $db->quote($_POST['watermarkBorder']);
            }

            if ($this->watermarkPosition === "---")
            {
                $this->watermarkPosition = "bottom right";
            }
            if (empty($this->thumbnailWidth) || ($this->thumbnailWidth === "0"))
            {
                $this->thumbnailWidth = 200;
            }

            // add new gallery to database
            if ($res = $db->query("INSERT INTO {plugin_gallery} (folder, 
                                                                 title, 
                                                                 description, 
                                                                 createThumbnails,
                                                                 thumbnailWidth, 
                                                                 watermark, 
                                                                 watermarkPosition, 
                                                                 watermarkImage, 
                                                                 offsetBottom, 
                                                                 offsetRight, 
                                                                 watermarkFont, 
                                                                 watermarkTextSize,
                                                                 watermarkOpacity,
                                                                 watermarkColor,
                                                                 watermarkBorderColor,
                                                                 watermarkBorder)
                                    VALUES ('".$this->folder."',
                                            '".$this->title."',
                                            '".$this->description."',
                                            '".$this->createThumbnails."',
                                            '".$this->thumbnailWidth."',
                                            '".$this->watermark."',
                                            '".$this->watermarkPosition."',
                                            '".$this->watermarkImage."',
                                            '".$this->offsetBottom."',
                                            '".$this->offsetRight."',
                                            '".$this->watermarkFont."',
                                            '".$this->watermarkTextSize."',
                                            '".$this->watermarkOpacity."',
                                            '".$this->watermarkColor."',
                                            '".$this->watermarkBorderColor."',
                                            '".$this->watermarkBorder."')"))
            {   // all good
                // \YAWK\alert::draw("success", "Gallery created.", "Database entry success.", "", 800);
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

            // ITERATE THROUGH FOLDER
            // check settings, set them...
            // and save each file in a db row.
            foreach (new \DirectoryIterator("../$this->folder") as $fileInfo) {
                if($fileInfo->isDot()) continue;        // exclude dots
                if($fileInfo->isDir()) continue;        // exclude subdirectories
                // store filename in var for better handling
                $filename = $fileInfo->getFilename();
                // MANIPULATE IMAGES IN A ROW

                // check if a watermark should be set
                if (!empty($this->watermark) || (!empty($this->watermarkImage)))
                {   // check watermark position
                    if ($this->watermarkPosition === "---")
                    {   // default position, if no pos is set
                        $this->watermarkPosition = "bottom right";
                    }
                    // CREATE EDIT FOLDER
                    // images here are stored to keep settings while user is in edit preview
                    if (!is_dir("../$this->folder/edit"))
                    {   // if no edit folder is set
                        mkdir("../$this->folder/edit");
                        // copy original files to backup folder
                        // iterate through folder and write backup files
                        foreach (new \DirectoryIterator("../$this->folder") as $backupFile)
                        {   // exclude dots'n'dirs
                            if($fileInfo->isDot()) continue;        // exclude dots
                            if($fileInfo->isDir()) continue;        // exclude subdirectories
                            $copyFile = $backupFile->getFilename();
                            if (!@copy("../$this->folder/$copyFile", "../$this->folder/edit/$copyFile"))
                            {   // could not copy file, throw notification
                                \YAWK\alert::draw("warning", "Could not copy file $filename to edit folder", "This should not happen. We're sorry!", "", 800);
                            }
                        } // end backup copy original files
                    }

                    // BACKUP
                    // keep non-watermarked files in folder original
                    // check if backup folder exists
                    if (!is_dir("../$this->folder/original"))
                    {   // if not, create folder
                        mkdir("../$this->folder/original");
                        // copy original files to backup folder
                        // iterate through folder and write backup files
                        foreach (new \DirectoryIterator("../$this->folder") as $backupFile)
                        {   // exclude dots'n'dirs
                            if($fileInfo->isDot()) continue;        // exclude dots
                            if($fileInfo->isDir()) continue;        // exclude subdirectories
                            $copyFile = $backupFile->getFilename();
                            if (!@copy("../$this->folder/$copyFile", "../$this->folder/original/$copyFile"))
                            {   // could not copy file, throw notification
                                \YAWK\alert::draw("warning", "Could not backup file $filename", "This should not happen. We're sorry!", "", 800);
                            }
                        } // end backup copy original files
                    }
                    // add watermark with stroke to every image
                    if (!empty($this->watermarkImage))
                    {   // Overlay image watermark
                        $img->load("../$this->folder/$filename")
                            ->overlay("../$this->watermarkImage",
                                      "$this->watermarkPosition",
                                       $this->watermarkOpacity)
                            ->save("../$this->folder/$filename");
                    }
                    if (!empty($this->watermark))
                    {   // text watermark
                        $img->load("../$this->folder/$filename")
                            ->text("$this->watermark",
                                    "$this->watermarkFont",
                                    $this->watermarkTextSize,
                                    "#$this->watermarkColor",
                                    "$this->watermarkPosition",
                                    "$this->offsetRight",
                                    "$this->offsetBottom",
                                    "#$this->watermarkBorderColor",
                                    $this->watermarkBorder)
                            ->save("../$this->folder/$filename");
                    }

                    // check if thumbnails should be created
                    if ($this->createThumbnails === "1")
                    {   // check if tn width is set
                        if (empty($this->thumbnailWidth))
                        {   // if no default width is set, take this as default value
                            $this->thumbnailWidth = 200;
                        }
                        else
                            {   // remove all but numbers from thumbnail width
                                $this->thumbnailWidth = preg_replace("/[^0-9]/","",$this->thumbnailWidth);
                            }
                        // check if thumbnail folder exists
                        $this->checkDir("../$this->folder/thumbnails");
                        // add watermark with stroke to every thumbnail image
                        $img->load("../$this->folder/$filename")
                            ->text("$this->watermark",
                                   "$this->watermarkFont",
                                   $this->watermarkTextSize,
                                   "#$this->watermarkColor",
                                   "$this->watermarkPosition",
                                   "$this->offsetRight",
                                   "$this->offsetBottom",
                                   "#$this->watermarkBorderColor",
                                    $this->watermarkBorder)
                            ->fit_to_width($this->thumbnailWidth)
                            ->save("../$this->folder/thumbnails/$filename");
                    }
                }
                else
                    {   // no watermark required...

                        // BACKUP
                        // but to keep the usability of the edit function (pixlate, sharpen etc)
                        // we do a backup of original images here too. (in case no watermark is needed)
                        // keep non-watermarked files in folder original
                        // check if backup folder exists
                        if (!is_dir("../$this->folder/original"))
                        {   // if not, create folder
                            mkdir("../$this->folder/original");
                            // copy original files to backup folder
                            // iterate through folder and write backup files
                            foreach (new \DirectoryIterator("../$this->folder") as $backupFile)
                            {   // exclude dots'n'dirs
                                if($fileInfo->isDot()) continue;        // exclude dots
                                if($fileInfo->isDir()) continue;        // exclude subdirectories
                                $copyFile = $backupFile->getFilename();
                                if (!@copy("../$this->folder/$copyFile", "../$this->folder/original/$copyFile"))
                                {   // could not copy file, throw notification
                                    \YAWK\alert::draw("warning", "Could not backup file $filename", "This should not happen. We're sorry!", "", 800);
                                }
                            } // end backup copy original files
                        }

                        // CREATE EDIT FOLDER
                        // images here are stored to keep settings while user is in edit preview
                        if (!is_dir("../$this->folder/edit"))
                        {   // if no edit folder is set
                            mkdir("../$this->folder/edit");
                            // copy original files to backup folder
                            // iterate through folder and write backup files
                            foreach (new \DirectoryIterator("../$this->folder") as $backupFile)
                            {   // exclude dots'n'dirs
                                if($fileInfo->isDot()) continue;        // exclude dots
                                if($fileInfo->isDir()) continue;        // exclude subdirectories
                                $copyFile = $backupFile->getFilename();
                                if (!@copy("../$this->folder/$copyFile", "../$this->folder/edit/$copyFile"))
                                {   // could not copy file, throw notification
                                    \YAWK\alert::draw("warning", "Could not copy file $filename to edit folder", "This should not happen. We're sorry!", "", 800);
                                }
                            } // end backup copy original files
                        }

                        // check if thumbnails should be created
                        if ($this->createThumbnails === "1")
                        {   // check if tn width is set
                            if (empty($this->thumbnailWidth))
                            {   // if no default width is set, take this as default value
                                $this->thumbnailWidth = 200;
                            }
                            // check if thumbnail folder exits
                            $this->checkDir("../$this->folder/thumbnails");
                            // fit to width
                            $img->load("../$this->folder/$filename")
                                ->fit_to_width($this->thumbnailWidth)
                                ->save("../$this->folder/thumbnails/$filename");
                        }
                    }

                // TODO: this needs to be improved:
                // TODO: 1 db insert per file is NOT! ok - but how to implement implode() correctly to avoid that memory lack?
                if ($res = $db->query("INSERT INTO {plugin_gallery_items} (galleryID, filename, title, author, authorUrl)
                        VALUES ('".$galleryID."', '".$filename."', '".$this->title."', '".$this->author."', '".$this->authorUrl."')"))
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

        public function loadProperties($db, $galleryID)
        {   /** @var $db \YAWK\db * */
            // load all gallery properties
            if ($res = $db->query("SELECT * from {plugin_gallery} where id = $galleryID"))
            {
                while ($row = mysqli_fetch_assoc($res))
                {
                    $this->id = $galleryID;
                    $this->folder = $row['folder'];
                    $this->title = $row['title'];
                    $this->description = $row['description'];
                    $this->author = $row['author'];
                    $this->authorUrl = $row['authorUrl'];
                    $this->createThumbnails = $row['createThumbnails'];
                    $this->thumbnailWidth = $row['thumbnailWidth'];
                    $this->watermark = $row['watermark'];
                    $this->watermarkPosition = $row['watermarkPosition'];
                    $this->watermarkImage = $row['watermarkImage'];
                    $this->offsetBottom = $row['offsetBottom'];
                    $this->offsetRight = $row['offsetRight'];
                    $this->watermarkFont = $row['watermarkFont'];
                    $this->watermarkTextSize = $row['watermarkTextSize'];
                    $this->watermarkOpacity = $row['watermarkOpacity'];
                    $this->watermarkColor = $row['watermarkColor'];
                    $this->watermarkBorderColor = $row['watermarkBorderColor'];
                    $this->watermarkBorder = $row['watermarkBorder'];
                }
            }
        }

        public function edit($db, $galleryID)
        {   /** @var $db \YAWK\db * */
            // quote all POST vars
            $this->id = $galleryID;
            $this->folder = $db->quote($_POST['folder']);
            $this->title = $db->quote($_POST['title']);
            $this->description = $db->quote($_POST['description']);
            $this->author = $db->quote($_POST['author']);
            $this->authorUrl = $db->quote($_POST['authorUrl']);
            $this->createThumbnails = $db->quote($_POST['createThumbnails']);
            $this->thumbnailWidth = $db->quote($_POST['thumbnailWidth']);
            $this->watermark = $db->quote($_POST['watermark']);
            $this->watermarkPosition = $db->quote($_POST['watermarkPosition']);
            $this->watermarkImage = $db->quote($_POST['watermarkImage']);
            $this->offsetBottom = $db->quote($_POST['offsetBottom']);
            $this->offsetRight = $db->quote($_POST['offsetRight']);
            $this->watermarkFont = $db->quote($_POST['watermarkFont']);
            $this->watermarkTextSize = $db->quote($_POST['watermarkTextSize']);
            $this->watermarkOpacity = $db->quote($_POST['watermarkOpacity']);
            $this->watermarkColor = $db->quote($_POST['watermarkColor']);
            $this->watermarkBorderColor = $db->quote($_POST['watermarkBorderColor']);
            $this->watermarkBorder = $db->quote($_POST['watermarkBorder']);

            // check, if any itemIDs need to be updated, get get them and loop through items...
            if ($res = $db->query("SELECT id from {plugin_gallery_items} 
                                   WHERE galleryID = $this->id"))
            {   // foreach itemID
                while ($row = mysqli_fetch_assoc($res))
                {   // set itemID
                    $this->itemID = $row['id'];
                    // set vars to compare if they have changed...
                    // filename
                    $oldFile = $_POST['filename-'.$this->itemID.'-old'];
                    $newFile = $_POST['filename-'.$this->itemID.''];
                    // title
                    $oldTitle = $_POST['title-'.$this->itemID.'-old'];
                    $newTitle = $_POST['title-'.$this->itemID.''];
                    // author
                    $oldAuthor = $_POST['author-'.$this->itemID.'-old'];
                    $newAuthor = $_POST['author-'.$this->itemID.''];
                    // authorUrl
                    $oldAuthorUrl = $_POST['authorUrl-'.$this->itemID.'-old'];
                    $newAuthorUrl = $_POST['authorUrl-'.$this->itemID.''];
                    // ## CHECK IF IMAGE FILENAME HAS CHANGED...
                    if ($oldFile === $newFile)
                    {   // files MATCH, no rename required: save ressources + do nothing :)
                        // \YAWK\alert::draw("warning", "files match!", "no rename required.", "", 800);
                    }
                    else
                    {   // files DO NOT match - RENAME file
                        if (rename("../$this->folder/$oldFile", "../$this->folder/$newFile"))
                        {   // filename did change - notify user about that
                            \YAWK\alert::draw("success", "$oldFile renamed to $newFile", "$this->itemID", "", 800);
                            // update database: save new file name
                            if (!$saveItem = $db->query("UPDATE {plugin_gallery_items} 
                                                         SET filename = '$newFile' 
                                                         WHERE id = $this->itemID"))
                            {   // could not rename file in database, notify user
                                \YAWK\alert::draw("warning", "Could not save new filename $newFile in database!", "But... the file is already renamed. Expect errors.", "", 5800);
                            }

                            // check if there are any originals to rename...
                            if (is_dir("../$this->folder/original/"))
                            {   // thumbnail directory exist
                                if (!rename("../$this->folder/original/$oldFile", "../$this->folder/original/$newFile"))
                                {   // rename thumbnail failed, throw error
                                    \YAWK\alert::draw("warning", "Could not rename original/$oldFile to $newFile", "Please check folder permissions!", "", 5800);
                                }
                            }

                            // check if there are any originals to rename...
                            if (is_dir("../$this->folder/edit/"))
                            {   // thumbnail directory exist
                                if (!rename("../$this->folder/edit/$oldFile", "../$this->folder/edit/$newFile"))
                                {   // rename thumbnail failed, throw error
                                    \YAWK\alert::draw("warning", "Could not rename edit/$oldFile to $newFile", "Please check folder permissions!", "", 5800);
                                }
                            }

                            // check if there are thumbnails to rename...
                            if (is_dir("../$this->folder/thumbnails/"))
                            {   // thumbnail directory exist
                                if (!rename("../$this->folder/thumbnails/$oldFile", "../$this->folder/thumbnails/$newFile"))
                                {   // rename thumbnail failed, throw error
                                    \YAWK\alert::draw("warning", "Could not rename thumbnails/$oldFile to $newFile", "Please check folder permissions!", "", 5800);
                                }
                            }
                        }
                        else
                        {   // rename failed
                            \YAWK\alert::draw("danger", "Could not rename $oldFile to $newFile", "Please check folder permissions!", "", 5800);
                        }
                    }
                    // ## CHECK IF IMAGE TITLE HAS CHANGED...
                    if ($oldTitle === $newTitle)
                    {
                        // files MATCH, no action required: save ressources + do nothing :)
                    }
                    else
                    {   // change title for this image in database
                        if (!$saveItem = $db->query("UPDATE {plugin_gallery_items} 
                                                         SET title = '$newTitle' 
                                                         WHERE id = $this->itemID"))
                        {   // could not change title in db => notify user
                            \YAWK\alert::draw("warning", "Could not change title $newTitle", "Please check your data and try again!", "", 5800);
                        }
                        else
                        {   // change title success
                            \YAWK\alert::draw("success", "Changed $oldTitle to $newTitle", "affected image ID: $this->itemID", "", 800);
                        }
                    }
                    // ## CHECK IF IMAGE AUTHOR HAS CHANGED...
                    if ($oldAuthor === $newAuthor)
                    {
                        // authors MATCH, no action required: save ressources + do nothing :)
                    }
                    else
                    {   // change author for this image in database
                        if (!$saveItem = $db->query("UPDATE {plugin_gallery_items} 
                                                         SET author = '$newAuthor' 
                                                         WHERE id = $this->itemID"))
                        {   // could not change author => notify user
                            \YAWK\alert::draw("warning", "Could not change author $newAuthor", "Please check your data and try again!", "", 5800);
                        }
                        else
                        {   // change title success
                            \YAWK\alert::draw("success", "Changed $oldAuthor to $newAuthor", "affected image ID: $this->itemID", "", 800);
                        }
                    }
                    // ## CHECK IF IMAGE AUTHOR URL HAS CHANGED...
                    if ($oldAuthorUrl === $newAuthorUrl)
                    {
                        // authors MATCH, no action required: save ressources + do nothing :)
                    }
                    else
                    {   // change authorUrl for this image in database
                        if (!$saveItem = $db->query("UPDATE {plugin_gallery_items} 
                                                         SET authorUrl = '$newAuthorUrl' 
                                                         WHERE id = $this->itemID"))
                        {   // could not change author => notify user
                            \YAWK\alert::draw("warning", "Could not change author URL to $newAuthorUrl", "Please check your data and try again!", "", 5800);
                        }
                        else
                        {   // change title success
                            \YAWK\alert::draw("success", "Changed Author URL to $newAuthorUrl", "affected image ID: $this->itemID", "", 800);
                        }
                    }
                }
            }

            // update database: gallery settings
            if (!$res = $db->query("UPDATE {plugin_gallery} 
                                   SET folder='$this->folder',
                                       title='$this->title',
                                       description='$this->description',
                                       author='$this->author',
                                       authorUrl='$this->authorUrl',
                                       createThumbnails='$this->createThumbnails',
                                       thumbnailWidth='$this->thumbnailWidth',
                                       watermark='$this->watermark',
                                       watermarkPosition='$this->watermarkPosition',
                                       watermarkImage='$this->watermarkImage',
                                       offsetBottom='$this->offsetBottom',
                                       offsetRight='$this->offsetRight',
                                       watermarkFont='$this->watermarkFont',
                                       watermarkTextSize='$this->watermarkTextSize',
                                       watermarkOpacity='$this->watermarkOpacity',
                                       watermarkColor='$this->watermarkColor',
                                       watermarkBorderColor='$this->watermarkBorderColor',
                                       watermarkBorder='$this->watermarkBorder' WHERE id = '$this->id'"))
            {   // update gallery not worked, notify user
                \YAWK\alert::draw("warning", "Could not save gallery settings.", "Please check your input data and try again.", "", 5800);
            }
            else
                {   // all good,
                    return true;
                }
        // something above did not worked,
        return false;
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
                      <!-- &nbsp;<a href=\"index.php?plugin=gallery&refresh=1&id=$row[id]&folder=$row[folder]\" title=\"refresh\"><i class=\"fa fa-refresh\"></i></a> -->
                      &nbsp;<a href=\"index.php?plugin=gallery&pluginpage=edit&id=$row[id]&folder=$row[folder]\" title=\"edit\"><i class=\"fa fa-edit\"></i>
                      &nbsp;<b>".$row['title']."</b></a><br><small>".$row['description']."</small></div>
                    <div class=\"col-md-8\">";
                    if (isset($previewError))
                    {   // if files could not be loaded from db
                        echo $previewError;
                    }
                    else
                    {   // previewImage array is set, walk through it...
                        foreach ($getPreviewImages as $property => $image)
                        {   // display preview images
                            echo "<a href=\"index.php?plugin=gallery&pluginpage=edit&id=$row[id]&folder=$row[folder]\" title=\"edit gallery\">
                                  <img src=\"../$row[folder]/$image[filename]\" class=\"img-thumbnail\" width=\"100\"></a>";
                        }
                    }
                    echo"</div></div>
                    <hr>";
                }
            }
            return null;
        }


        public function getEditableImages($db, $lang, $galleryID)
        {   /** @var $db \YAWK\db **/
            // get gallery titles...

            if ($res = $db->query("SELECT * from {plugin_gallery} WHERE id = $galleryID"))
            {
                while ($row = mysqli_fetch_assoc($res))
                {
                    if (!$getPreviewImages = $db->query("SELECT id, galleryID, filename, title, author, authorUrl
                                                         from {plugin_gallery_items} 
                                                         WHERE galleryID = $galleryID ORDER BY filename, sort DESC"))
                    {   // store info msg, if files could not be retrieved
                        $previewError = "Sorry, no preview available.";
                    }
                    // preview without images
                    echo "<a class=\"fa fa-trash-o\" role=\"dialog\" data-confirm=\"Soll die Galerie &laquo;" . $row['id'] . " / " . $row['title'] . "&raquo; wirklich gel&ouml;scht werden?\"
                      title=\"" . $lang['DEL'] . "\" href=\"index.php?plugin=gallery&delete=1&id=" . $row['id'] . "\"></a>
                      &nbsp;<a href=\"index.php?plugin=gallery&refresh=1&id=$row[id]&folder=$row[folder]\" title=\"refresh\"><i class=\"fa fa-refresh\"></i></a>
                      &nbsp;<b>".$row['title']."</b><br><small>".$row['description']."</small><br>
                                    <div class=\"text-center\"><br>";
                    if (isset($previewError))
                    {   // if files could not be loaded from db
                        echo $previewError;
                    }
                    else
                    {   // previewImage array is set, walk through it...
                        $count = 3;
                        echo '
                                    <div class="row">
                                    ';
                        foreach ($getPreviewImages as $property => $image)
                        {   // display preview images
                            for ($i = 0; $i < count($property); $i++) {
                                $this->itemID = $image['id'];
                                $this->filename = $image['filename'];
                                $this->itemTitle = $image['title'];
                                $this->itemAuthor = $image['author'];
                                $this->itemAuthorUrl = $image['authorUrl'];
                                $rnd = uniqid();

                                if ($count % 3 == 0)
                                { // time to break line
                                    echo '
                                    </div>';
                                    echo '
                                    <div class="row"><div class="col-md-4">
                                    <a href="../' . $row['folder']."/".$this->filename . '?'.$rnd.'" data-lightbox="'.$this->title.'"><img class="img-thumbnail" id="img-'.$this->itemID.'" width="400" title="'.$this->itemTitle.'" src="../' . $row['folder']."/".$this->filename . '?'.$rnd.'"></a>
                                    <br>
                                         <div style="margin-top: 10px; margin-bottom:10px; cursor:pointer;">
                                         <i class="fa fa-arrows-h" 
                                            id="flipHorizontal" 
                                            onclick="doImageAction(\'flip-horizontal\', 
                                                \''.$this->folder.'\', 
                                                \''.$this->filename.'\', 
                                                \''.$this->itemID.'\', 
                                                \''.$this->createThumbnails.'\', 
                                                \''.$this->thumbnailWidth.'\', 
                                                \''.$this->watermark.'\', 
                                                \''.$this->watermarkImage.'\', 
                                                \''.$this->watermarkOpacity.'\', 
                                                \''.$this->watermarkPosition.'\', 
                                                \''.$this->offsetRight.'\', 
                                                \''.$this->offsetBottom.'\', 
                                                \''.$this->watermarkFont.'\', 
                                                \''.$this->watermarkTextSize.'\', 
                                                \''.$this->watermarkColor.'\', 
                                                \''.$this->watermarkBorderColor.'\', 
                                                \''.$this->watermarkBorder.'\'
                                                )"></i>&nbsp;
                                         <i class="fa fa-arrows-v" 
                                            id="flipVertical" 
                                            onclick="doImageAction(\'flip-vertical\', 
                                                \''.$this->folder.'\', 
                                                \''.$this->filename.'\', 
                                                \''.$this->itemID.'\', 
                                                \''.$this->createThumbnails.'\', 
                                                \''.$this->thumbnailWidth.'\', 
                                                \''.$this->watermark.'\', 
                                                \''.$this->watermarkImage.'\', 
                                                \''.$this->watermarkOpacity.'\', 
                                                \''.$this->watermarkPosition.'\', 
                                                \''.$this->offsetRight.'\', 
                                                \''.$this->offsetBottom.'\', 
                                                \''.$this->watermarkFont.'\', 
                                                \''.$this->watermarkTextSize.'\', 
                                                \''.$this->watermarkColor.'\', 
                                                \''.$this->watermarkBorderColor.'\', 
                                                \''.$this->watermarkBorder.'\'
                                                )"></i>&nbsp;
                                         <i class="fa fa-undo" 
                                            id="rotate-90"
                                            onclick="doImageAction(\'rotate-90\', 
                                                \''.$this->folder.'\', 
                                                \''.$this->filename.'\', 
                                                \''.$this->itemID.'\', 
                                                \''.$this->createThumbnails.'\', 
                                                \''.$this->thumbnailWidth.'\', 
                                                \''.$this->watermark.'\', 
                                                \''.$this->watermarkImage.'\', 
                                                \''.$this->watermarkOpacity.'\', 
                                                \''.$this->watermarkPosition.'\', 
                                                \''.$this->offsetRight.'\', 
                                                \''.$this->offsetBottom.'\', 
                                                \''.$this->watermarkFont.'\', 
                                                \''.$this->watermarkTextSize.'\', 
                                                \''.$this->watermarkColor.'\', 
                                                \''.$this->watermarkBorderColor.'\', 
                                                \''.$this->watermarkBorder.'\'
                                                )"></i>&nbsp;
                                         <i class="fa fa-adjust" 
                                            id="contrast-plus"
                                            onclick="doImageAction(\'contrast-plus\', 
                                                \''.$this->folder.'\', 
                                                \''.$this->filename.'\', 
                                                \''.$this->itemID.'\', 
                                                \''.$this->createThumbnails.'\', 
                                                \''.$this->thumbnailWidth.'\', 
                                                \''.$this->watermark.'\', 
                                                \''.$this->watermarkImage.'\', 
                                                \''.$this->watermarkOpacity.'\', 
                                                \''.$this->watermarkPosition.'\', 
                                                \''.$this->offsetRight.'\', 
                                                \''.$this->offsetBottom.'\', 
                                                \''.$this->watermarkFont.'\', 
                                                \''.$this->watermarkTextSize.'\', 
                                                \''.$this->watermarkColor.'\', 
                                                \''.$this->watermarkBorderColor.'\', 
                                                \''.$this->watermarkBorder.'\'
                                                )"></i>&nbsp;
                                         <i class="fa fa-adjust text-muted" style="color:#ccc;"
                                            id="contrast-minus"
                                            onclick="doImageAction(\'contrast-minus\', 
                                                \''.$this->folder.'\', 
                                                \''.$this->filename.'\', 
                                                \''.$this->itemID.'\', 
                                                \''.$this->createThumbnails.'\', 
                                                \''.$this->thumbnailWidth.'\', 
                                                \''.$this->watermark.'\', 
                                                \''.$this->watermarkImage.'\', 
                                                \''.$this->watermarkOpacity.'\', 
                                                \''.$this->watermarkPosition.'\', 
                                                \''.$this->offsetRight.'\', 
                                                \''.$this->offsetBottom.'\', 
                                                \''.$this->watermarkFont.'\', 
                                                \''.$this->watermarkTextSize.'\', 
                                                \''.$this->watermarkColor.'\', 
                                                \''.$this->watermarkBorderColor.'\', 
                                                \''.$this->watermarkBorder.'\'
                                                )"></i>&nbsp;
                                         <i class="fa fa-sun-o"
                                            id="brightness-plus"
                                            onclick="doImageAction(\'brightness-minus\', 
                                                \''.$this->folder.'\', 
                                                \''.$this->filename.'\', 
                                                \''.$this->itemID.'\', 
                                                \''.$this->createThumbnails.'\', 
                                                \''.$this->thumbnailWidth.'\', 
                                                \''.$this->watermark.'\', 
                                                \''.$this->watermarkImage.'\', 
                                                \''.$this->watermarkOpacity.'\', 
                                                \''.$this->watermarkPosition.'\', 
                                                \''.$this->offsetRight.'\', 
                                                \''.$this->offsetBottom.'\', 
                                                \''.$this->watermarkFont.'\', 
                                                \''.$this->watermarkTextSize.'\', 
                                                \''.$this->watermarkColor.'\', 
                                                \''.$this->watermarkBorderColor.'\', 
                                                \''.$this->watermarkBorder.'\'
                                                )"></i>&nbsp;
                                         <i class="fa fa-sun-o text-muted" style="color:#ccc;"
                                            id="brightness-minus"
                                            onclick="doImageAction(\'brightness-plus\', 
                                                \''.$this->folder.'\', 
                                                \''.$this->filename.'\', 
                                                \''.$this->itemID.'\', 
                                                \''.$this->createThumbnails.'\', 
                                                \''.$this->thumbnailWidth.'\', 
                                                \''.$this->watermark.'\', 
                                                \''.$this->watermarkImage.'\', 
                                                \''.$this->watermarkOpacity.'\', 
                                                \''.$this->watermarkPosition.'\', 
                                                \''.$this->offsetRight.'\', 
                                                \''.$this->offsetBottom.'\', 
                                                \''.$this->watermarkFont.'\', 
                                                \''.$this->watermarkTextSize.'\', 
                                                \''.$this->watermarkColor.'\', 
                                                \''.$this->watermarkBorderColor.'\', 
                                                \''.$this->watermarkBorder.'\'
                                                )"></i>&nbsp;
                                         <i class="fa fa-diamond"
                                            id="sharpen"
                                            onclick="doImageAction(\'sharpen\', 
                                                \''.$this->folder.'\', 
                                                \''.$this->filename.'\', 
                                                \''.$this->itemID.'\', 
                                                \''.$this->createThumbnails.'\', 
                                                \''.$this->thumbnailWidth.'\', 
                                                \''.$this->watermark.'\', 
                                                \''.$this->watermarkImage.'\', 
                                                \''.$this->watermarkOpacity.'\', 
                                                \''.$this->watermarkPosition.'\', 
                                                \''.$this->offsetRight.'\', 
                                                \''.$this->offsetBottom.'\', 
                                                \''.$this->watermarkFont.'\', 
                                                \''.$this->watermarkTextSize.'\', 
                                                \''.$this->watermarkColor.'\', 
                                                \''.$this->watermarkBorderColor.'\', 
                                                \''.$this->watermarkBorder.'\'
                                                )"></i>&nbsp;
                                         <i class="fa fa-magic"
                                            id="selective-blur"
                                            onclick="doImageAction(\'selective-blur\', 
                                                \''.$this->folder.'\', 
                                                \''.$this->filename.'\', 
                                                \''.$this->itemID.'\', 
                                                \''.$this->createThumbnails.'\', 
                                                \''.$this->thumbnailWidth.'\', 
                                                \''.$this->watermark.'\', 
                                                \''.$this->watermarkImage.'\', 
                                                \''.$this->watermarkOpacity.'\', 
                                                \''.$this->watermarkPosition.'\', 
                                                \''.$this->offsetRight.'\', 
                                                \''.$this->offsetBottom.'\', 
                                                \''.$this->watermarkFont.'\', 
                                                \''.$this->watermarkTextSize.'\', 
                                                \''.$this->watermarkColor.'\', 
                                                \''.$this->watermarkBorderColor.'\', 
                                                \''.$this->watermarkBorder.'\'
                                                )"></i>&nbsp;
                                         <i class="fa fa-tint text-muted"
                                            id="greyscale"
                                            onclick="doImageAction(\'greyscale\', 
                                                \''.$this->folder.'\', 
                                                \''.$this->filename.'\', 
                                                \''.$this->itemID.'\', 
                                                \''.$this->createThumbnails.'\', 
                                                \''.$this->thumbnailWidth.'\', 
                                                \''.$this->watermark.'\', 
                                                \''.$this->watermarkImage.'\', 
                                                \''.$this->watermarkOpacity.'\', 
                                                \''.$this->watermarkPosition.'\', 
                                                \''.$this->offsetRight.'\', 
                                                \''.$this->offsetBottom.'\', 
                                                \''.$this->watermarkFont.'\', 
                                                \''.$this->watermarkTextSize.'\', 
                                                \''.$this->watermarkColor.'\', 
                                                \''.$this->watermarkBorderColor.'\', 
                                                \''.$this->watermarkBorder.'\'
                                                )"></i>&nbsp;
                                         <i class="fa fa-tint"
                                            style="color:#9b5c1c;"
                                            id="sepia"
                                            onclick="doImageAction(\'sepia\', 
                                                \''.$this->folder.'\', 
                                                \''.$this->filename.'\', 
                                                \''.$this->itemID.'\', 
                                                \''.$this->createThumbnails.'\', 
                                                \''.$this->thumbnailWidth.'\', 
                                                \''.$this->watermark.'\', 
                                                \''.$this->watermarkImage.'\', 
                                                \''.$this->watermarkOpacity.'\', 
                                                \''.$this->watermarkPosition.'\', 
                                                \''.$this->offsetRight.'\', 
                                                \''.$this->offsetBottom.'\', 
                                                \''.$this->watermarkFont.'\', 
                                                \''.$this->watermarkTextSize.'\', 
                                                \''.$this->watermarkColor.'\', 
                                                \''.$this->watermarkBorderColor.'\', 
                                                \''.$this->watermarkBorder.'\'
                                                )"></i>&nbsp;
                                         <i class="fa fa-th text-muted"
                                            id="pixelate"
                                            onclick="doImageAction(\'pixelate\', 
                                                \''.$this->folder.'\', 
                                                \''.$this->filename.'\', 
                                                \''.$this->itemID.'\', 
                                                \''.$this->createThumbnails.'\', 
                                                \''.$this->thumbnailWidth.'\', 
                                                \''.$this->watermark.'\', 
                                                \''.$this->watermarkImage.'\', 
                                                \''.$this->watermarkOpacity.'\', 
                                                \''.$this->watermarkPosition.'\', 
                                                \''.$this->offsetRight.'\', 
                                                \''.$this->offsetBottom.'\', 
                                                \''.$this->watermarkFont.'\', 
                                                \''.$this->watermarkTextSize.'\', 
                                                \''.$this->watermarkColor.'\', 
                                                \''.$this->watermarkBorderColor.'\', 
                                                \''.$this->watermarkBorder.'\'
                                                )"></i>&nbsp;
                                         <i class="fa fa-refresh"
                                            id="reset-file"
                                            onclick="doImageAction(\'reset-file\', 
                                                \''.$this->folder.'\', 
                                                \''.$this->filename.'\', 
                                                \''.$this->itemID.'\', 
                                                \''.$this->createThumbnails.'\', 
                                                \''.$this->thumbnailWidth.'\', 
                                                \''.$this->watermark.'\', 
                                                \''.$this->watermarkImage.'\', 
                                                \''.$this->watermarkOpacity.'\', 
                                                \''.$this->watermarkPosition.'\', 
                                                \''.$this->offsetRight.'\', 
                                                \''.$this->offsetBottom.'\', 
                                                \''.$this->watermarkFont.'\', 
                                                \''.$this->watermarkTextSize.'\', 
                                                \''.$this->watermarkColor.'\', 
                                                \''.$this->watermarkBorderColor.'\', 
                                                \''.$this->watermarkBorder.'\'
                                                )"></i>&nbsp;
                                         <i class="fa fa-trash-o"
                                            id="delete-file"
                                            onclick="doImageAction(\'delete-file\', 
                                                \''.$this->folder.'\', 
                                                \''.$this->filename.'\', 
                                                \''.$this->itemID.'\', 
                                                \''.$this->createThumbnails.'\', 
                                                \''.$this->thumbnailWidth.'\', 
                                                \''.$this->watermark.'\', 
                                                \''.$this->watermarkImage.'\', 
                                                \''.$this->watermarkOpacity.'\', 
                                                \''.$this->watermarkPosition.'\', 
                                                \''.$this->offsetRight.'\', 
                                                \''.$this->offsetBottom.'\', 
                                                \''.$this->watermarkFont.'\', 
                                                \''.$this->watermarkTextSize.'\', 
                                                \''.$this->watermarkColor.'\', 
                                                \''.$this->watermarkBorderColor.'\', 
                                                \''.$this->watermarkBorder.'\'
                                                )"></i>&nbsp;<br>
                                         </div>
                                      <input type="hidden" name="filename-'.$this->itemID.'-old" value="'.$this->filename.'">
                                      <input type="hidden" name="title-'.$this->itemID.'-old" value="'.$this->itemTitle.'">
                                      <input type="hidden" name="author-'.$this->itemID.'-old" value="'.$this->itemAuthor.'">
                                      <input type="hidden" name="authorUrl-'.$this->itemID.'-old" value="'.$this->itemAuthorUrl.'">
                                      <input type="text" class="form-control" style="margin-bottom:2px;" name="filename-'.$this->itemID.'" id="filename-'.$this->itemID.'" placeholder="filename.jpg" value="'.$this->filename.'">
                                      <input type="text" class="form-control" style="margin-bottom:2px;" name="title-'.$this->itemID.'" id="title-'.$this->itemID.'" placeholder="File Title" value="'.$this->itemTitle.'">
                                      <input type="text" class="form-control" style="margin-bottom:2px;" name="author-'.$this->itemID.'" id="author-'.$this->itemID.'" placeholder="Copyright owner of this picture" value="'.$this->itemAuthor.'">
                                      <input type="text" class="form-control" style="margin-bottom:2px;" name="authorUrl-'.$this->itemID.'" id="authorUrl-'.$this->itemID.'" placeholder="URL" value="'.$this->itemAuthorUrl.'"><br>
                                      <br></div>';
                                }
                                else
                                    {  echo '  
                                      <div class="col-md-4">
                                    <a href="../' . $row['folder']."/".$this->filename . '?'.$rnd.'" data-lightbox="'.$this->title.'"><img class="img-thumbnail" id="img-'.$this->itemID.'" width="400" title="'.$this->itemTitle.'" src="../' . $row['folder']."/".$this->filename . '?'.$rnd.'"></a>
                                         
                                         <div style="margin-top: 10px; margin-bottom:10px; cursor:pointer;">
                                         <i class="fa fa-arrows-h" 
                                            id="flipHorizontal" 
                                            onclick="doImageAction(\'flip-horizontal\', 
                                                \''.$this->folder.'\', 
                                                \''.$this->filename.'\', 
                                                \''.$this->itemID.'\', 
                                                \''.$this->createThumbnails.'\', 
                                                \''.$this->thumbnailWidth.'\', 
                                                \''.$this->watermark.'\', 
                                                \''.$this->watermarkImage.'\', 
                                                \''.$this->watermarkOpacity.'\', 
                                                \''.$this->watermarkPosition.'\', 
                                                \''.$this->offsetRight.'\', 
                                                \''.$this->offsetBottom.'\', 
                                                \''.$this->watermarkFont.'\', 
                                                \''.$this->watermarkTextSize.'\', 
                                                \''.$this->watermarkColor.'\', 
                                                \''.$this->watermarkBorderColor.'\', 
                                                \''.$this->watermarkBorder.'\'
                                                )"></i>&nbsp;
                                         <i class="fa fa-arrows-v" 
                                            id="flipVertical" 
                                            onclick="doImageAction(\'flip-vertical\', 
                                                \''.$this->folder.'\', 
                                                \''.$this->filename.'\', 
                                                \''.$this->itemID.'\', 
                                                \''.$this->createThumbnails.'\', 
                                                \''.$this->thumbnailWidth.'\', 
                                                \''.$this->watermark.'\', 
                                                \''.$this->watermarkImage.'\', 
                                                \''.$this->watermarkOpacity.'\', 
                                                \''.$this->watermarkPosition.'\', 
                                                \''.$this->offsetRight.'\', 
                                                \''.$this->offsetBottom.'\', 
                                                \''.$this->watermarkFont.'\', 
                                                \''.$this->watermarkTextSize.'\', 
                                                \''.$this->watermarkColor.'\', 
                                                \''.$this->watermarkBorderColor.'\', 
                                                \''.$this->watermarkBorder.'\'
                                                )"></i>&nbsp;
                                         <i class="fa fa-undo" 
                                            id="rotate-90"
                                            onclick="doImageAction(\'rotate-90\', 
                                                \''.$this->folder.'\', 
                                                \''.$this->filename.'\', 
                                                \''.$this->itemID.'\', 
                                                \''.$this->createThumbnails.'\', 
                                                \''.$this->thumbnailWidth.'\', 
                                                \''.$this->watermark.'\', 
                                                \''.$this->watermarkImage.'\', 
                                                \''.$this->watermarkOpacity.'\', 
                                                \''.$this->watermarkPosition.'\', 
                                                \''.$this->offsetRight.'\', 
                                                \''.$this->offsetBottom.'\', 
                                                \''.$this->watermarkFont.'\', 
                                                \''.$this->watermarkTextSize.'\', 
                                                \''.$this->watermarkColor.'\', 
                                                \''.$this->watermarkBorderColor.'\', 
                                                \''.$this->watermarkBorder.'\'
                                                )"></i>&nbsp;
                                         <i class="fa fa-adjust" 
                                            id="contrast-plus"
                                            onclick="doImageAction(\'contrast-plus\', 
                                                \''.$this->folder.'\', 
                                                \''.$this->filename.'\', 
                                                \''.$this->itemID.'\', 
                                                \''.$this->createThumbnails.'\', 
                                                \''.$this->thumbnailWidth.'\', 
                                                \''.$this->watermark.'\', 
                                                \''.$this->watermarkImage.'\', 
                                                \''.$this->watermarkOpacity.'\', 
                                                \''.$this->watermarkPosition.'\', 
                                                \''.$this->offsetRight.'\', 
                                                \''.$this->offsetBottom.'\', 
                                                \''.$this->watermarkFont.'\', 
                                                \''.$this->watermarkTextSize.'\', 
                                                \''.$this->watermarkColor.'\', 
                                                \''.$this->watermarkBorderColor.'\', 
                                                \''.$this->watermarkBorder.'\'
                                                )"></i>&nbsp;
                                         <i class="fa fa-adjust text-muted" style="color:#ccc;"
                                            id="contrast-minus"
                                            onclick="doImageAction(\'contrast-minus\', 
                                                \''.$this->folder.'\', 
                                                \''.$this->filename.'\', 
                                                \''.$this->itemID.'\', 
                                                \''.$this->createThumbnails.'\', 
                                                \''.$this->thumbnailWidth.'\', 
                                                \''.$this->watermark.'\', 
                                                \''.$this->watermarkImage.'\', 
                                                \''.$this->watermarkOpacity.'\', 
                                                \''.$this->watermarkPosition.'\', 
                                                \''.$this->offsetRight.'\', 
                                                \''.$this->offsetBottom.'\', 
                                                \''.$this->watermarkFont.'\', 
                                                \''.$this->watermarkTextSize.'\', 
                                                \''.$this->watermarkColor.'\', 
                                                \''.$this->watermarkBorderColor.'\', 
                                                \''.$this->watermarkBorder.'\'
                                                )"></i>&nbsp;
                                         <i class="fa fa-sun-o"
                                            id="brightness-plus"
                                            onclick="doImageAction(\'brightness-minus\', 
                                                \''.$this->folder.'\', 
                                                \''.$this->filename.'\', 
                                                \''.$this->itemID.'\', 
                                                \''.$this->createThumbnails.'\', 
                                                \''.$this->thumbnailWidth.'\', 
                                                \''.$this->watermark.'\', 
                                                \''.$this->watermarkImage.'\', 
                                                \''.$this->watermarkOpacity.'\', 
                                                \''.$this->watermarkPosition.'\', 
                                                \''.$this->offsetRight.'\', 
                                                \''.$this->offsetBottom.'\', 
                                                \''.$this->watermarkFont.'\', 
                                                \''.$this->watermarkTextSize.'\', 
                                                \''.$this->watermarkColor.'\', 
                                                \''.$this->watermarkBorderColor.'\', 
                                                \''.$this->watermarkBorder.'\'
                                                )"></i>&nbsp;
                                         <i class="fa fa-sun-o text-muted" style="color:#ccc;"
                                            id="brightness-minus"
                                            onclick="doImageAction(\'brightness-plus\', 
                                                \''.$this->folder.'\', 
                                                \''.$this->filename.'\', 
                                                \''.$this->itemID.'\', 
                                                \''.$this->createThumbnails.'\', 
                                                \''.$this->thumbnailWidth.'\', 
                                                \''.$this->watermark.'\', 
                                                \''.$this->watermarkImage.'\', 
                                                \''.$this->watermarkOpacity.'\', 
                                                \''.$this->watermarkPosition.'\', 
                                                \''.$this->offsetRight.'\', 
                                                \''.$this->offsetBottom.'\', 
                                                \''.$this->watermarkFont.'\', 
                                                \''.$this->watermarkTextSize.'\', 
                                                \''.$this->watermarkColor.'\', 
                                                \''.$this->watermarkBorderColor.'\', 
                                                \''.$this->watermarkBorder.'\'
                                                )"></i>&nbsp;
                                         <i class="fa fa-diamond"
                                            id="sharpen"
                                            onclick="doImageAction(\'sharpen\', 
                                                \''.$this->folder.'\', 
                                                \''.$this->filename.'\', 
                                                \''.$this->itemID.'\', 
                                                \''.$this->createThumbnails.'\', 
                                                \''.$this->thumbnailWidth.'\', 
                                                \''.$this->watermark.'\', 
                                                \''.$this->watermarkImage.'\', 
                                                \''.$this->watermarkOpacity.'\', 
                                                \''.$this->watermarkPosition.'\', 
                                                \''.$this->offsetRight.'\', 
                                                \''.$this->offsetBottom.'\', 
                                                \''.$this->watermarkFont.'\', 
                                                \''.$this->watermarkTextSize.'\', 
                                                \''.$this->watermarkColor.'\', 
                                                \''.$this->watermarkBorderColor.'\', 
                                                \''.$this->watermarkBorder.'\'
                                                )"></i>&nbsp;
                                         <i class="fa fa-magic"
                                            id="selective-blur"
                                            onclick="doImageAction(\'selective-blur\', 
                                                \''.$this->folder.'\', 
                                                \''.$this->filename.'\', 
                                                \''.$this->itemID.'\', 
                                                \''.$this->createThumbnails.'\', 
                                                \''.$this->thumbnailWidth.'\', 
                                                \''.$this->watermark.'\', 
                                                \''.$this->watermarkImage.'\', 
                                                \''.$this->watermarkOpacity.'\', 
                                                \''.$this->watermarkPosition.'\', 
                                                \''.$this->offsetRight.'\', 
                                                \''.$this->offsetBottom.'\', 
                                                \''.$this->watermarkFont.'\', 
                                                \''.$this->watermarkTextSize.'\', 
                                                \''.$this->watermarkColor.'\', 
                                                \''.$this->watermarkBorderColor.'\', 
                                                \''.$this->watermarkBorder.'\'
                                                )"></i>&nbsp;
                                         <i class="fa fa-tint text-muted"
                                            id="greyscale"
                                            onclick="doImageAction(\'greyscale\', 
                                                \''.$this->folder.'\', 
                                                \''.$this->filename.'\', 
                                                \''.$this->itemID.'\', 
                                                \''.$this->createThumbnails.'\', 
                                                \''.$this->thumbnailWidth.'\', 
                                                \''.$this->watermark.'\', 
                                                \''.$this->watermarkImage.'\', 
                                                \''.$this->watermarkOpacity.'\', 
                                                \''.$this->watermarkPosition.'\', 
                                                \''.$this->offsetRight.'\', 
                                                \''.$this->offsetBottom.'\', 
                                                \''.$this->watermarkFont.'\', 
                                                \''.$this->watermarkTextSize.'\', 
                                                \''.$this->watermarkColor.'\', 
                                                \''.$this->watermarkBorderColor.'\', 
                                                \''.$this->watermarkBorder.'\'
                                                )"></i>&nbsp;
                                         <i class="fa fa-tint"
                                            style="color:#9b5c1c;"
                                            id="sepia"
                                            onclick="doImageAction(\'sepia\', 
                                                \''.$this->folder.'\', 
                                                \''.$this->filename.'\', 
                                                \''.$this->itemID.'\', 
                                                \''.$this->createThumbnails.'\', 
                                                \''.$this->thumbnailWidth.'\', 
                                                \''.$this->watermark.'\', 
                                                \''.$this->watermarkImage.'\', 
                                                \''.$this->watermarkOpacity.'\', 
                                                \''.$this->watermarkPosition.'\', 
                                                \''.$this->offsetRight.'\', 
                                                \''.$this->offsetBottom.'\', 
                                                \''.$this->watermarkFont.'\', 
                                                \''.$this->watermarkTextSize.'\', 
                                                \''.$this->watermarkColor.'\', 
                                                \''.$this->watermarkBorderColor.'\', 
                                                \''.$this->watermarkBorder.'\'
                                                )"></i>&nbsp;
                                         <i class="fa fa-th text-muted"
                                            id="pixelate"
                                            onclick="doImageAction(\'pixelate\', 
                                                \''.$this->folder.'\', 
                                                \''.$this->filename.'\', 
                                                \''.$this->itemID.'\', 
                                                \''.$this->createThumbnails.'\', 
                                                \''.$this->thumbnailWidth.'\', 
                                                \''.$this->watermark.'\', 
                                                \''.$this->watermarkImage.'\', 
                                                \''.$this->watermarkOpacity.'\', 
                                                \''.$this->watermarkPosition.'\', 
                                                \''.$this->offsetRight.'\', 
                                                \''.$this->offsetBottom.'\', 
                                                \''.$this->watermarkFont.'\', 
                                                \''.$this->watermarkTextSize.'\', 
                                                \''.$this->watermarkColor.'\', 
                                                \''.$this->watermarkBorderColor.'\', 
                                                \''.$this->watermarkBorder.'\'
                                                )"></i>&nbsp;
                                         <i class="fa fa-refresh"
                                            id="reset-file"
                                            onclick="doImageAction(\'reset-file\', 
                                                \''.$this->folder.'\', 
                                                \''.$this->filename.'\', 
                                                \''.$this->itemID.'\', 
                                                \''.$this->createThumbnails.'\', 
                                                \''.$this->thumbnailWidth.'\', 
                                                \''.$this->watermark.'\', 
                                                \''.$this->watermarkImage.'\', 
                                                \''.$this->watermarkOpacity.'\', 
                                                \''.$this->watermarkPosition.'\', 
                                                \''.$this->offsetRight.'\', 
                                                \''.$this->offsetBottom.'\', 
                                                \''.$this->watermarkFont.'\', 
                                                \''.$this->watermarkTextSize.'\', 
                                                \''.$this->watermarkColor.'\', 
                                                \''.$this->watermarkBorderColor.'\', 
                                                \''.$this->watermarkBorder.'\'
                                                )"></i>&nbsp;
                                         <i class="fa fa-trash-o"
                                            id="delete-file"
                                            onclick="doImageAction(\'delete-file\', 
                                                \''.$this->folder.'\', 
                                                \''.$this->filename.'\', 
                                                \''.$this->itemID.'\', 
                                                \''.$this->createThumbnails.'\', 
                                                \''.$this->thumbnailWidth.'\', 
                                                \''.$this->watermark.'\', 
                                                \''.$this->watermarkImage.'\', 
                                                \''.$this->watermarkOpacity.'\', 
                                                \''.$this->watermarkPosition.'\', 
                                                \''.$this->offsetRight.'\', 
                                                \''.$this->offsetBottom.'\', 
                                                \''.$this->watermarkFont.'\', 
                                                \''.$this->watermarkTextSize.'\', 
                                                \''.$this->watermarkColor.'\', 
                                                \''.$this->watermarkBorderColor.'\', 
                                                \''.$this->watermarkBorder.'\'
                                                )"></i>&nbsp;<br>
                                         </div>
                                      <input type="hidden" name="filename-'.$this->itemID.'-old" value="'.$this->filename.'">
                                      <input type="hidden" name="title-'.$this->itemID.'-old" value="'.$this->itemTitle.'">
                                      <input type="hidden" name="author-'.$this->itemID.'-old" value="'.$this->itemAuthor.'">
                                      <input type="hidden" name="authorUrl-'.$this->itemID.'-old" value="'.$this->itemAuthorUrl.'">
                                      <input type="text" class="form-control" style="margin-bottom:2px;" name="filename-'.$this->itemID.'" id="filename-'.$this->itemID.'" placeholder="filename.jpg" value="'.$this->filename.'">
                                      <input type="text" class="form-control" style="margin-bottom:2px;" name="title-'.$this->itemID.'" id="title-'.$this->itemID.'" placeholder="File Title" value="'.$this->itemTitle.'">
                                      <input type="text" class="form-control" style="margin-bottom:2px;" name="author-'.$this->itemID.'" id="author-'.$this->itemID.'" placeholder="Copyright owner of this picture" value="'.$this->itemAuthor.'">
                                      <input type="text" class="form-control" style="margin-bottom:2px;" name="authorUrl-'.$this->itemID.'" id="authorUrl-'.$this->itemID.'" placeholder="URL" value="'.$this->itemAuthorUrl.'"><br>
                                      <br></div>';
                                    }
                                $count++;
                            }
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