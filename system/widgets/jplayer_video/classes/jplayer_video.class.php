<?php
namespace YAWK\WIDGETS\JPLAYER\VIDEO {
    class jPlayerVideo
    {
        /** * @param string current user name */
        public $mediaFolder;        // path to media root folder usually media/audio
        public $folder;             // media subfolder where the files are stored
        public $poster;             // jpg or png to be displayed before playback is started
        public $posterJSON;         // contains the prepared json data (.jpg or .png image)
        public $download;           // allow to download?
        public $downloadJSON;       // contains the prepares json data (download link)
        public $playerSettings;     // player settings array

        public function getPlayerSettings($db, $widgetID)
        {
            // ... method call: \YAWK\widgets::getWidgetSettingsIntoArray($db, $widgetID)
            // return $playerSettingsArray();
        }

        public function getVideoFiles($mediaFolder, $folder, $poster, $download)
        {
            $this->mediaFolder = $mediaFolder;
            $this->folder = $folder;
            $this->poster = $poster;
            $this->download = $download;

            // optional: add files to array while processing
            // $filesArray = array();

            // media folder empty or missing
            if (!isset($this->mediaFolder) || (empty($this->mediaFolder)))
            {   // set default value
                $this->mediaFolder = "media/video/";
            }
            // user folder empty or missing
            if (!isset($this->folder) || (empty($this->folder)))
            {
                // if no user folder is set: do nothing
                // in that case, we expect the files to be in mediaFolder
            }
            else
                {   // mediafolder AND folder are set, build new mediaFolder string
                    $this->mediaFolder = $this->mediaFolder . $this->folder;
                }
            // if poster image is set
            if (isset($this->poster) && (!empty($this->poster)))
            {
                // prepare json poster output...
                $this->posterJSON = ",poster:\"$this->poster\"";
            }
            else
                {   // no poster was set - leave empty
                    $this->posterJSON = "";
                }

            // check if download is allowed
            if (isset($this->download) && (!empty($this->download)))
            {   // download is enabled
                if ($this->download === "true")
                {
                    // prepare download link JSON data
                    $this->downloadJSON = ",free:\"$this->download\"";
                }
                else
                    {   // download not allowed
                        $this->downloadJSON = "";
                    }
            }

            // OK, lets go with searching for files...
            // is it a directory?
            if (is_dir($this->mediaFolder))
            {
                // open media folder
                if ($dh = opendir($this->mediaFolder))
                {   // loop trough
                    while (($file = readdir($dh)) != false)
                    {   // check found element
                        if ($file == "." || $file == ".." || is_dir($file))
                        {
                            // if is dot or folder
                            // do nothing
                        }
                        else    // it is a file
                            {
                                // generate title string from filename
                                $title = $file;

                                // process .M4V files
                                if (strpos($file, ".m4v") || (strpos($file, ".M4V")) !== false)
                                {   // encode filename
                                    $file = rawurlencode($file);
                                    // remove file extension from title string
                                    $title = rtrim($title, ".m4v");
                                    $title = rtrim($title, ".M4V");
                                    // output JSON data for M4V files
                                    echo "{ name:\"$title\",m4v:\"$this->mediaFolder/$file\" $this->downloadJSON $this->posterJSON },\n\r";
                                    // optional: add m4v files to filesArray
                                    // $filesArray[] = array("title" => $title, "m4v" => $file);
                                }

                                // process .OGV files
                                else if (strpos($file, ".ogv") || (strpos($file, ".OGV")) !== false)
                                {   // encode filename
                                    $file = rawurlencode($file);
                                    // remove file extension from title string
                                    $title = rtrim($title, ".ogv");
                                    $title = rtrim($title, ".OGV");
                                    // output JSON data for OGV files
                                    echo "{ name:\"$title\",ogv:\"$this->mediaFolder/$file\" $this->downloadJSON $this->posterJSON },\n\r";
                                    // optional: add ogv files to filesArray
                                    // $filesArray[] = array("title" => $title, "ogv" => $file);
                                }
                                // process .FLV files
                                else if (strpos($file, ".flv") || (strpos($file, ".FLV")) !== false)
                                {   // encode filename
                                    $file = rawurlencode($file);
                                    // remove file extension from title string
                                    $title = rtrim($title, ".flv");
                                    $title = rtrim($title, ".FLV");
                                    // output JSON data for FLV files
                                    echo "{ name:\"$title\",flv:\"$this->mediaFolder/$file\" $this->downloadJSON $this->posterJSON },\n\r";
                                    // optional: add FLV files to filesArray
                                    // $filesArray[] = array("title" => $title, "flv" => $file);
                                }
                                // process .MPG files
                                else if (strpos($file, ".mpg") || (strpos($file, ".MPG")) !== false)
                                {   // encode filename
                                    $file = rawurlencode($file);
                                    // remove file extension from title string
                                    $title = rtrim($title, ".mpg");
                                    $title = rtrim($title, ".MPG");
                                    // output JSON data for MPG files
                                    echo "{ name:\"$title\",mpg:\"$this->mediaFolder/$file\" $this->downloadJSON $this->posterJSON },\n\r";
                                    // optional: add MPG files to filesArray
                                    // $filesArray[] = array("title" => $title, "mpg" => $file);
                                }
                                // process .MP4 files
                                else if (strpos($file, ".mp4") || (strpos($file, ".MP4")) !== false)
                                {   // encode filename
                                    $file = rawurlencode($file);
                                    // remove file extension from title string
                                    $title = rtrim($title, ".mp4");
                                    $title = rtrim($title, ".MP4");
                                    // output JSON data for MP4 files
                                    echo "{ name:\"$title\",mp4:\"$this->mediaFolder/$file\" $this->downloadJSON $this->posterJSON },\n\r";
                                    // optional: add MP4 files to filesArray
                                    // $filesArray[] = array("title" => $title, "mp4" => $file);
                                }
                            }
                    }
                }
                else
                    {   // could not open directory, abort
                        // die ("could not open directory $this->mediaFolder - check permissions!");
                        return false;
                        // \YAWK\alert::draw("danger", "ERROR: Could not open directory $this->mediaFolder", "Please check file and / or folder access permissions!", "", "");
                    }
            }
            else
                {   // directory not exists, abort
                    // return false; // die ("folder $this->mediaFolder does not exist!");
                    // \YAWK\alert::draw("danger", "ERROR: Could not open directory $this->mediaFolder", "Directory does not exist!", "", "");
                }
        }   // end function getFiles
    }   // end class jPlayer
}   // end namespace