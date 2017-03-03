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
                        return false;
                        // detected language is not supported, set en-EN as default
                        // $language->currentLanguage = "en-EN";
                        // $language->currentLanguageGlobal = "en";
                        // $language->setLanguage("en-EN");
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

        public function setDefault($defaultLanguage)
        {
            if (isset($defaultLanguage) && (!empty($defaultLanguage)))
            {
                // set default language
                $this->currentLanguage = $defaultLanguage;
                $this->setLanguage($defaultLanguage);
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
        public function inject($lang, $pathToFile)
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
