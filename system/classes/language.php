<?php
namespace YAWK {
    /**
     * <b>Get and set the backend language.</b>
     *
     * <p>Language Support for Backend</i></p>
     * The language files are located in<br>
     * admin/language/lang-en-EN.ini
     *
     *
     * @author     Daniel Retzl <danielretzl@gmail.com>
     * @copyright  2009-2015 Daniel Retzl
     * @license    http://www.gnu.org/licenses/gpl-2.0  GNU/GPL 2.0
     * @version    1.0.0
     * @link       http://yawk.io
     * @annotation The language class - support multilingual backend
     */
    class language
    {
        /** * @var array $lang language array */
        public $lang;
        /** * @var string $currentLanguage current setted language in format: en-EN */
        public $currentLanguage;
        /** * @var string $httpAcceptedLanguage current $_SERVER['HTTP_ACCEPTED_LANGUAGE'] in format: en-EN */
        public $httpAcceptedLanguage;
        /** * @var string $pathToFile the path to the language file */
        public $pathToFile;

        /**
         * initialize and return current language
         * @author     Daniel Retzl <danielretzl@gmail.com>
         * @copyright  2009-2016 Daniel Retzl
         * @license    http://www.gnu.org/licenses/gpl-2.0  GNU/GPL 2.0
         * @link       http://yawk.io
         * @return string
         */
        public function init()
        {
            // set current language
            $this->httpAcceptedLanguage = $this->getClientLanguage();
            $this->currentLanguage = $this->getCurrentLanguage();
            return $this->lang = $this->setLanguage($this->currentLanguage);
        }

        /**
         * returns the currently set backend language
         * @author Daniel Retzl <danielretzl@gmail.com>
         * @copyright 2017 Daniel Retzl
         * @license    http://www.gnu.org/licenses/gpl-2.0  GNU/GPL 2.0
         * @link       http://yawk.io
         * @return string
         */
        public function getCurrentLanguage()
        {
            $currentLanguage = '';
            // check if a GET param is set
            if (isset($_GET['lang']) && (!empty($_GET['lang'])))
            {
                $currentLanguage = $_GET['lang'];     // sst GET param as current language
                // register and overwrite session var
                $_SESSION['lang'] = $currentLanguage;
                // and check if cookie is set
                if (!isset($_COOKIE['lang']) || (empty($_COOKIE['lang'])))
                {   // if not, try to set it - with error supressor to avoid notices if output started before
                    @setcookie('lang', $currentLanguage, time() + (60 * 60 * 24 * 1460));
                }
                /* language set, cookie set */
                return $currentLanguage;
            }
            else
            {
                // GET param not set, check if there is a $_SESSION[lang]
                if (isset($_SESSION['lang']) || (!empty($_SESSION['lang'])))
                {
                    // session var is set
                    $currentLanguage = $_SESSION['lang'];
                    return $currentLanguage;
                }
                // SESSION param not set, check if there is a $_COOKIE[lang]
                elseif (isset($_COOKIE['lang']) || (!empty($_COOKIE['lang'])))
                {
                    // cookie var is set
                    $currentLanguage = $_COOKIE['lang'];
                    return $currentLanguage;
                }
                else
                {
                    // get language setting from database
                    if (!isset($db))
                    {   // create new db object
                        $db = new \YAWK\db();
                    }
                    // get backend language setting and save string eg. (en-EN) in $this->current
                    if ($currentLanguage = (\YAWK\settings::getSetting($db, "backendLanguage")) === true)
                    {
                        // return current db-settings language
                        return $currentLanguage;
                    }
                    else
                    {   // failed to get backend language
                        $currentLanguage = "en-EN";   // default: en-EN
                        // return default value (en-EN)
                        return $currentLanguage;
                    }
                }
            }
        }

        /**
         * get and return client language
         * @author     Daniel Retzl <danielretzl@gmail.com>
         * @copyright  2009-2016 Daniel Retzl
         * @license    http://www.gnu.org/licenses/gpl-2.0  GNU/GPL 2.0
         * @link       http://yawk.io
         * @return string
         */
        public function getClientLanguage()
        {
            // check if browser tells any accepted language
            if(isset($_SERVER['HTTP_ACCEPT_LANGUAGE']) || (!empty($_SERVER['HTTP_ACCEPT_LANGUAGE'])))
            {   // format the string to eg: en-EN
                $this->httpAcceptedLanguage = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 5);
                return $this->httpAcceptedLanguage;
            }
            else
                {   // var empty - cannot detect -
                    return null;
                }
        }

        public function getPathToLanguageFile()
        {
            // check if call comes from frontend or backend
            if(stristr($_SERVER['PHP_SELF'], '/admin/') == TRUE)
            {
                // call seem to come from BACKEND
                // check if directory is reachable
                if (is_dir("language/"))
                {
                    // set path to backend
                    $this->pathToFile = "language/";
                }
                elseif (is_dir("admin/language/"))
                {
                    $this->pathToFile = "admin/language";
                }
                else
                {
                    $this->pathToFile = '';
                }
            }
            else
            {   // set path to frontend
                $this->pathToFile = "admin/language/";
            }
            return $this->pathToFile;
        }

        /**
         * set client language and parse corresponding ini file to array $lang
         * @param string $lang the language as string (eg en-US)
         * @return array|string $lang returns a language array
         */
        public function setLanguage($currentLanguage)
        {
            $this->pathToFile = $this->getPathToLanguageFile();
            if (is_file("$this->pathToFile"."lang-"."$currentLanguage".".ini"))
            {
                $this->lang = parse_ini_file("$this->pathToFile"."lang-"."$currentLanguage".".ini");
            }
            return $this->lang;
        } /* end setLanguage */


        /**
         * allow plugins to inject language tags to $lang array
         * @param array $lang the core language array
         * @param string $pathToFile absolute path to the injectable language file
         * @return array $lang returns pushed language array
         */
        static function inject($lang, $pathToFile)
        {
            // check if language is saved in session or cookie to prevent unneccessary db actions
            if (isset($_SESSION['lang']))
            {   // set from session setting
                $currentLanguage = $_SESSION['lang'];
            }
            elseif (isset($_COOKIE['lang']))
            {   // set from cookie setting
                $currentLanguage = $_COOKIE['lang'];
            }
            else
                {   // get current language from db
                    $currentLanguage = $this->getCurrentLanguage();
                }

            // get injectable tags from additional language file
            $additionalTags = parse_ini_file("$pathToFile"."$currentLanguage".".ini");
            // add every tag, once per row
            foreach ($additionalTags AS $tag => $value)
            {   // add data to $lang array
                $lang[$tag] = $value;
            }
            // fin -
            return $lang;
        } /* end setLanguage */
        
    } /* END CLASS */
}
