<?php
namespace YAWK
{

class controller
{
    public $filename;

    function __construct()
    {
    }


    public static function frontEndInit($db, $currentpage, $user, $template)
    {
        /** @var $db \YAWK\db
         * @var $currentpage \YAWK\page
         *
         *  INIT FRONTEND STARTS HERE
         */
        // check whether the system is actually in maintenance mode

    }


    public static function filterfilename($filename)
    {
        // lower cases
        $filename = mb_strtolower($filename);
        // just numbers + chars are allowed, replace special chares,
        $filename = preg_replace("/[^.a-z0-9\-\/]/i", "", $filename);
        // trim filename and check if its empty
        if (trim($filename) === "")
        {   // if filename is empty, set index as default page
            $filename = "index";
        }
        if ($filename[0] === "/")
        {
            // remove prefix slash
            $filename = substr($filename, 1);
        }
        // append file extension
        $filename .= ".php";

        // what if file not exists...
        if (!file_exists($filename))
        {   // file does not exist, load 404 page
            $notfound = $filename;
            $filename = "content/errors/404.php";
            // check if call comes from frontend or backend
            if (file_exists($filename))
            {   // frontend success
                return $filename;
            }
            else
            {   // call from backend, set path correctly
                if (!isset($db)) { $db = new \YAWK\db(); }
                \YAWK\sys::setSyslog($db, 5, "404 ERROR $notfound", 0, 0, 0, 0);
                $filename = "../content/errors/404.php";
                return $filename;
            }
        }
        // return file
        return $filename;
    }

} // ./ class controller
} // ./ namespace