<?php
namespace YAWK {
    /**
     * <b>Get and set the backend language.</b>
     *
     * <p>Language Support for Backend</i></p>
     * The language files are located in<br>
     * admin/language/lang-en-EN.ini
     *
     * @author     Daniel Retzl <danielretzl@gmail.com>
     * @copyright  2017 Daniel Retzl
     * @license    http://www.gnu.org/licenses/gpl-2.0  GNU/GPL 2.0
     * @version    1.0.0
     * @link       http://yawk.io
     * @annotation The language class - support multilingual backend
     */
    class language
    {
        /** * @var array $lang language array */
        public $lang;
        /** * @var string $defaultLanguage default language if no supported language can be detected */
        public $defaultLanguage;
        /** * @var string $currentLanguage current setted language in format: en-EN */
        public $currentLanguage;
        /** * @var string $currentLanguageGlobal current setted language in format: en */
        public $currentLanguageGlobal;
        /** * @var string $detectedLanguage current detected language in format: en-EN */
        public $detectedLanguage;
        /** * @var string $detectedLanguageGlobal current detected language in format: en */
        public $detectedLanguageGlobal;
        /** * @var string $httpAcceptedLanguage current $_SERVER['HTTP_ACCEPTED_LANGUAGE'] in format: en-EN */
        public $httpAcceptedLanguage;
        /** * @var string $pathToFile the path to the language file */
        public $pathToFile;
        /** * @var array $supportedLanguagesGlobal array that contains all supported languages, shortened to the first 2 chars eg. (en) */
        public $supportedLanguagesGlobal;
        /** * @var array $supportedLanguages array that contains all supported languages, but the full tag eg. (en-EN) */
        public $supportedLanguages;

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
                        require_once '../system/classes/db.php';
                        require_once '../system/classes/settings.php';
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
         * returns the currently set backend language, but is static callable
         * @author Daniel Retzl <danielretzl@gmail.com>
         * @copyright 2017 Daniel Retzl
         * @license    http://www.gnu.org/licenses/gpl-2.0  GNU/GPL 2.0
         * @link       http://yawk.io
         * @return string
         */
        static function getCurrentLanguageStatic()
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
                        require_once '../system/classes/db.php';
                        require_once '../system/classes/settings.php';
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
                $this->currentLanguageGlobal = substr($this->httpAcceptedLanguage, 0, 2);
                return $this->httpAcceptedLanguage;
            }
            else
                {   // var empty - cannot detect -
                    return null;
                }
        }

        /**
         * sets object supportedLanguages as array including all supported languages
         * @author     Daniel Retzl <danielretzl@gmail.com>
         * @copyright  2009-2016 Daniel Retzl
         * @license    http://www.gnu.org/licenses/gpl-2.0  GNU/GPL 2.0
         * @link       http://yawk.io
         * @return bool
         */
        public function getSupportedLanguages()
        {
            // walk /admin/language folder and get all language files into an array
            require_once ('system/classes/filemanager.php');
            $languageFiles = filemanager::getFilesFromFolderToArray('admin/language');
            foreach ($languageFiles AS $file)
            {
                if ($file === ".htaccess")
                {

                }
                else
                {
                    $globalLanguageTag = substr($file, 5, -7);
                    $this->supportedLanguagesGlobal[] = $globalLanguageTag;
                    $localLanguageTag = substr($file, 5, -4);
                    $this->supportedLanguages[] = $localLanguageTag;
                    // $this->supportedLanguages[] = $globalLanguageTag;
                }
            }
            if (is_array($this->supportedLanguagesGlobal) && (is_array($this->supportedLanguages)))
            {
                return true;
            }
            else
                {
                    return false;
                }
        }

        /**
         * Check if a language is supported. This functions expect currentLanguage string in format "en-EN" or "en"
         * @author Daniel Retzl <danielretzl@gmail.com>
         * @copyright 2017 Daniel Retzl
         * @param string $currentLanguage language in format: en-EN or en
         * @license    http://www.gnu.org/licenses/gpl-2.0  GNU/GPL 2.0
         * @link       http://yawk.io
         * @return string
         */
        public function isSupported($currentLanguage)
        {
            // create arrays with supported languages, one in format "en", the other one "en-EN"
            $this->getSupportedLanguages();

            // check if language is set and not empty
            if (isset($currentLanguage) && (!empty($currentLanguage)))
            {
                // if language is submitted as global language tag (short, like: en instead of en-EN)
                if (strlen($currentLanguage) <= 2)
                {
                    // check if supportedLanguages match with language
                    if (in_array($currentLanguage, $this->supportedLanguagesGlobal))
                    {
                        // language is supported
                        // $language->setLanguage($language->currentLanguageGlobal); // set language
                        return true;
                    }
                    else
                    {
                        // detected language is not supported, set en-EN as default
                        return false;
                    }
                } // end global language tag (en)
                else
                    {   // check supportedLanguagesLocal match with detected user language
                        if (in_array($currentLanguage, $this->supportedLanguages))
                        {   // language supported
                            return true;
                        }
                        else
                            {   // language not supported
                                return false;
                            }
                    }
            }
            else
                {   // language is not set
                    return false;
                }
        }

        /**
         * Set a language as default and load (set) it current language
         * @author Daniel Retzl <danielretzl@gmail.com>
         * @copyright 2017 Daniel Retzl
         * @param string $defaultLanguage language in format: en-EN or en
         * @license    http://www.gnu.org/licenses/gpl-2.0  GNU/GPL 2.0
         * @link       http://yawk.io
         */
        public function setDefault($defaultLanguage)
        {
            if (isset($defaultLanguage) && (!empty($defaultLanguage)))
            {
                // set default language
                $this->currentLanguage = $defaultLanguage;
                $this->setLanguage($defaultLanguage);
            }
        }

        /**
         * Returns the path to the language file
         * @author Daniel Retzl <danielretzl@gmail.com>
         * @copyright 2017 Daniel Retzl
         * @license    http://www.gnu.org/licenses/gpl-2.0  GNU/GPL 2.0
         * @link       http://yawk.io
         * return string
         */
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
         * set client language and parse corresponding ini file to an array called $lang
         * @param string $currentLanguage the current language as string (eg en-US)
         * @return array|bool $lang returns a language array
         */
        public function setLanguage($currentLanguage)
        {
            $this->pathToFile = $this->getPathToLanguageFile();

            //  short language identify string global (just 2 chars) sent
            if (strlen($currentLanguage) == 2)
            {   // build a proper currentLanguage string
                $global = $currentLanguage;
                $local = strtoupper($currentLanguage);
                $currentLanguage = "$global-$local";
            }
            // if language file exists...
            if (is_file("$this->pathToFile"."lang-"."$currentLanguage".".ini"))
            {   // parse language file into array
                if ($this->lang = parse_ini_file("$this->pathToFile"."lang-"."$currentLanguage".".ini"))
                {   // file loaded, return language array
                    return $this->lang;
                }
                else
                    {   // file could not be parsed into array - abort with error
                        die ("could not load language file: $this->pathToFile"."lang-"."$currentLanguage".".ini");
                    }
            }
            // language file does not exist - check if an en-EN file exists...
            elseif (is_file("$this->pathToFile"."lang-en-EN.ini"))
            {   // parse language file into array
                if ($this->lang = parse_ini_file("$this->pathToFile"."lang-en-EN.ini"))
                {   // file loaded, return language array
                    return $this->lang;
                }
                else
                    {   // file could not be parsed into array - abort with error
                        die ("ERROR: Could not load language file: $this->pathToFile"."lang-en-EN.ini");
                    }
            }
            else
                {   // language file not found
                    // english (default) language file not found
                    // abort with error
                    die ("CRITICAL ERROR: No language file found. It should be there, but it isn't. This is strange. Please check $this->pathToFile and install a language file.");
                }
        } /* end setLanguage */


        /**
         * allow plugins to inject language tags to $lang array
         * @param array $lang the language data array
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
                    $currentLanguage = \YAWK\language::getCurrentLanguageStatic();
                    if (isset($currentLanguage) && (!empty($currentLanguage)))
                    {   // set session var to save database ressources
                        $_SESSION['lang'] = $currentLanguage;
                    }
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
