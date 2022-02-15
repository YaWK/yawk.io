<?php
namespace YAWK\WIDGETS\JPLAYER\AUDIO {
    class jPlayer
    {
        /** * @param string current user name */
        public $mediaFolder;        // path to media root folder usually media/audio
        public $folder;             // media subfolder where the files are stored
        public $playerSettings;     // player settings array

        public function getPlayerSettings($db, $widgetID)
        {
            // ... method call: \YAWK\widgets::getWidgetSettingsIntoArray($db, $widgetID)
            // return $playerSettingsArray();
        }

        public function getFiles($mediaFolder, $folder)
        {
            $this->mediaFolder = $mediaFolder;
            $this->folder = $folder;

            // optional: add files to array while processing
            // $filesArray = array();

            // media folder empty or missing
            if (!isset($this->mediaFolder) || (empty($this->mediaFolder)))
            {   // set default value
                $this->mediaFolder = "media/audio/";
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

                                // process .MP3 files
                                if (strpos($file, ".mp3") || (strpos($file, ".MP3")) !== false)
                                {   // encode filename
                                    $file = rawurlencode($file);
                                    // remove file extension from title string
                                    $title = rtrim($title, ".mp3");
                                    $title = rtrim($title, ".MP3");
                                    // output JSON data for MP3 files
                                    echo "{ name:\"$title\",mp3:\"$this->mediaFolder/$file\"},\n\r";
                                    // optional: add mp3 files to filesArray
                                    // $filesArray[] = array("title" => $title, "mp3" => $file);
                                }

                                // process .OGG files
                                else if (strpos($file, ".oga") || (strpos($file, ".OGA")) !== false)
                                {   // encode filename
                                    $file = rawurlencode($file);
                                    // remove file extension from title string
                                    $title = rtrim($title, ".oga");
                                    $title = rtrim($title, ".OGA");
                                    // output JSON data for OGG files
                                    echo "{ name:\"$title\",oga:\"$this->mediaFolder/$file\"},\n\r";
                                    // optional: add ogg files to filesArray
                                    // $filesArray[] = array("title" => $title, "oga" => $file);
                                }
                                // process .WAV files
                                else if (strpos($file, ".wav") || (strpos($file, ".WAV")) !== false)
                                {   // encode filename
                                    $file = rawurlencode($file);
                                    // remove file extension from title string
                                    $title = rtrim($title, ".wav");
                                    $title = rtrim($title, ".WAV");
                                    // output JSON data for OGG files
                                    echo "{ name:\"$title\",wav:\"$this->mediaFolder/$file\"},\n\r";
                                    // optional: add ogg files to filesArray
                                    // $filesArray[] = array("title" => $title, "oga" => $file);
                                }
                            }
                    }
                }
                else
                    {   // could not open directory, abort
                        die ("could not open directory $this->mediaFolder");
                    }
            }
            else
                {   // directory not exists, abort
                    die ("directory not exists $this->mediaFolder");
                }
        }   // end function getFiles
    }   // end class jPlayer
}   // end namespace