<?php
namespace YAWK {
    /**
     * @details <b>Get and set the backend language.</b>
     *
     * <p>Language Support for Backend</i></p>
     * The language files are located in<br>
     * admin/language/lang-en-EN.ini
     *
     * @author     Daniel Retzl <danielretzl@gmail.com>
     * @copyright  2017 Daniel Retzl
     * @license    https://opensource.org/licenses/MIT
     * @version    1.0.0
     * @brief The language class - support multilingual backend
     */
    class language
    {
        /** * @param array $lang language array */
        public $lang;
        /** * @param string $defaultLanguage default language if no supported language can be detected */
        public $defaultLanguage;
        /** * @param string $currentLanguage current setted language in format: en-EN */
        public $currentLanguage;
        /** * @param string $currentLanguage current setted language in format: en-EN */
        public $currentFrontendLanguage;
        /** * @param string $currentLanguageGlobal current setted language in format: en */
        public $currentLanguageGlobal;
        /** * @param string $detectedLanguage current detected language in format: en-EN */
        public $detectedLanguage;
        /** * @param string $detectedLanguageGlobal current detected language in format: en */
        public $detectedLanguageGlobal;
        /** * @param string $httpAcceptedLanguage current $_SERVER['HTTP_ACCEPTED_LANGUAGE'] in format: en-EN */
        public $httpAcceptedLanguage;
        /** * @param string $pathToFile the path to the language file */
        public $pathToFile;
        /** * @param array $supportedLanguagesGlobal array that contains all supported languages, shortened to the first 2 chars eg. (en) */
        public $supportedLanguagesGlobal;
        /** * @param array $supportedLanguages array that contains all supported languages, but the full tag eg. (en-EN) */
        public $supportedLanguages;

        /**
         * @brief initialize and return current language
         * @return array|bool
         * @copyright  2009-2016 Daniel Retzl
         */
        public function init($db, $referer)
        {
            // set current language
            $this->httpAcceptedLanguage = $this->getClientLanguage();
            $this->currentFrontendLanguage = settings::getSetting($db, "frontendLanguage");
            $this->currentLanguage = $this->getCurrentLanguage($db, $referer);
            return $this->setLanguage($this->currentLanguage);
        }

        /**
         * @brief returns the currently set language
         * @copyright 2017 Daniel Retzl
         * @param object $db database object
         * @param string $referer frontend|backend from where it the call referred?
         * @return string
         */
        public function getCurrentLanguage($db, $referer): string
        {

            if (isset($referer) && (is_string($referer)))
            {
                if ($referer == "frontend")
                {
                    if ($this->currentLanguage = settings::getSetting($db, "frontendLanguage"))
                    {
                        $_SESSION['lang'] = $this->currentLanguage;
                        // return current language from db-settings// if not, try to set it - with error supressor to avoid notices if output started before
                        @setcookie('lang', $this->currentLanguage, time() + (60 * 60 * 24 * 1460));
                        return $this->currentLanguage;
                    }
                    else
                    {   // failed to get language
                        $this->currentLanguage = "en-EN";   // default: en-EN
                        $_SESSION['lang'] = $this->currentLanguage;
                        // return default value (en-EN)
                        return $this->currentLanguage;
                    }
                }
                else if ($referer == "backend")
                {

                    if ($this->currentLanguage = settings::getSetting($db, "backendLanguage"))
                    {
                        $_SESSION['lang'] = $this->currentLanguage;
                        // return current language from db-settings// if not, try to set it - with error supressor to avoid notices if output started before
                        @setcookie('lang', $this->currentLanguage, time() + (60 * 60 * 24 * 1460));
                        return $this->currentLanguage;
                    }
                    else
                    {   // failed to get language
                        $this->currentLanguage = "en-EN";   // default: en-EN
                        $_SESSION['lang'] = $this->currentLanguage;
                        // return default value (en-EN)
                        return $this->currentLanguage;
                    }
                }
                else
                {
                    if ($this->currentLanguage = settings::getSetting($db, "backendLanguage"))
                    {
                        $_SESSION['lang'] = $this->currentLanguage;
                        // return current language from db-settings// if not, try to set it - with error supressor to avoid notices if output started before
                        @setcookie('lang', $this->currentLanguage, time() + (60 * 60 * 24 * 1460));
                        return $this->currentLanguage;
                    }
                    else
                    {   // failed to get language
                        $this->currentLanguage = "en-EN";   // default: en-EN
                        $_SESSION['lang'] = $this->currentLanguage;
                        // return default value (en-EN)
                        return $this->currentLanguage;
                    }
                }
            }
            else
            {
                if ($this->currentLanguage = settings::getSetting($db, "backendLanguage"))
                {
                    $_SESSION['lang'] = $this->currentLanguage;
                    // return current language from db-settings// if not, try to set it - with error supressor to avoid notices if output started before
                    @setcookie('lang', $this->currentLanguage, time() + (60 * 60 * 24 * 1460));
                    return $this->currentLanguage;
                }
                else
                {   // failed to get language
                    $this->currentLanguage = "en-EN";   // default: en-EN
                    $_SESSION['lang'] = $this->currentLanguage;
                    // return default value (en-EN)
                    return $this->currentLanguage;
                }
            }
        }

        /**
         * @brief returns the currently set backend language, but is static callable
         * @author Daniel Retzl <danielretzl@gmail.com>
         * @copyright 2017 Daniel Retzl
         * @license    https://opensource.org/licenses/MIT
         * @return string
         */
        static function getCurrentLanguageStatic()
        {
            $currentLanguage = '';
            // check if a GET param is set
            if (isset($_GET['lang']) && (!empty($_GET['lang'])))
            {
                $currentLanguage = $_GET['lang'];     // set GET param as current language
                // register and overwrite session var
                $_SESSION['lang'] = $currentLanguage;
                // and check if cookie is set
                if (empty($_COOKIE['lang']))
                {   // if not, try to set it - with error suppressor to avoid notices if output started before
                    @setcookie('lang', $currentLanguage, time() + (60 * 60 * 24 * 1460));
                }
                /* language set, cookie set */
                return $currentLanguage;
            }
            else
            {
                // GET param not set, check if there is a $_SESSION[lang]
                if (isset($_SESSION['lang']) && (!empty($_SESSION['lang'])))
                {
                    // session var is set
                    return $_SESSION['lang'];
                }
                // SESSION param not set, check if there is a $_COOKIE[lang]
                elseif (isset($_COOKIE['lang']) && (!empty($_COOKIE['lang'])))
                {
                    // cookie var is set
                    return $_COOKIE['lang'];
                }
                else
                {
                    // get language setting from database
                    if (!isset($db))
                    {   // create new db object
                        require_once '../system/classes/db.php';
                        require_once '../system/classes/settings.php';
                        $db = new db();
                    }
                    // get backend language setting and save string eg. (en-EN) in $this->current
                    if (!($currentLanguage = (settings::getSetting($db, "backendLanguage")) === true)) {   // failed to get backend language
                        $currentLanguage = "en-EN";   // default: en-EN
                        // return default value (en-EN)
                    }
                    return $currentLanguage;
                }
            }
        }


        /**
         * @brief get and return client language
         * @author     Daniel Retzl <danielretzl@gmail.com>
         * @copyright  2009-2016 Daniel Retzl
         * @license    https://opensource.org/licenses/MIT
         * @return string
         */
        public function getClientLanguage(): ?string
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
         * @brief sets object supportedLanguages as array including all supported languages
         * @author     Daniel Retzl <danielretzl@gmail.com>
         * @copyright  2009-2016 Daniel Retzl
         * @license    https://opensource.org/licenses/MIT
         * @return bool
         */
        public function getSupportedLanguages(): bool
        {
            // walk /admin/language folder and get all language files into an array
            require_once ('system/classes/filemanager.php');
            $languageFiles = filemanager::getFilesFromFolderToArray('admin/language');
            foreach ($languageFiles AS $file)
            {
                if ($file != ".htaccess")
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
         * @brief Check if a language is supported. This functions expect currentLanguage string in format "en-EN" or "en"
         * @param string $currentLanguage language in format: en-EN or en
         * @return bool
         * @license    https://opensource.org/licenses/MIT
         * @copyright 2017 Daniel Retzl
         */
        public function isSupported(string $currentLanguage): bool
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
         * @brief Set a language as default and load (set) it current language
         * @param string $defaultLanguage language in format: en-EN or en
         * @copyright 2017 Daniel Retzl
         * @license    https://opensource.org/licenses/MIT
         */
        public function setDefault(string $defaultLanguage)
        {
            if ((!empty($defaultLanguage)))
            {
                // set default language
                $this->currentLanguage = $defaultLanguage;
                $this->setLanguage($defaultLanguage);
            }
        }

        /**
         * @brief Returns the path to the language file
         * @copyright 2017 Daniel Retzl
         * @license    https://opensource.org/licenses/MIT
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

            // if setup is running
            else if (isset($_SESSION['SETUP']) && ($_SESSION['SETUP'] == TRUE))
            {       // load backend language files
                    $this->pathToFile = "admin/language/";
            }

            // in any other case load frontend language
            else
            {   // set path to FRONTEND
                if (is_dir("system/language/"))
                {   // set frontend language path
                    $this->pathToFile = "system/language/";
                }
                // if frontend language files are not reachable, check if backend language files exist
                else if (is_dir("admin/language"))
                {   // load backend files instead
                    $this->pathToFile = "admin/language/";
                }
                // if frontend language files are not reachable, check if backend language files exist
                else if (is_dir("../../../language"))
                {   // load backend files instead
                    $this->pathToFile = "../../../language/";
                }
                else
                    {   // no language files found (even no backend files)
                        die ("ERROR: Unable to load language files. Several conditions failed - files are missing or corrupt. Please inform the page administrator about this concern.");
                    }
            }
            return $this->pathToFile;
        }

        /**
         * @brief set client language and parse corresponding ini file to an array called $lang
         * @param string $currentLanguage the current language as string (e.g. en-US)
         * @return array|bool $lang returns a language array
         */
        public function setLanguage(string $currentLanguage)
        {
            $this->pathToFile = $this->getPathToLanguageFile();

            //  short language identify string global (just 2 chars) sent
            if (strlen($currentLanguage) == 2)
            {   // build a proper currentLanguage string
                $global = $currentLanguage;
                $local = strtoupper($currentLanguage);
                $currentLanguage = "$global-$local";
                $this->currentLanguage = $currentLanguage;
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
         * @brief allow plugins to inject language tags to $lang array
         * @param array $lang the language data array
         * @param string $pathToFile absolute path to the injectable language file
         * @return array $lang returns pushed language array
         */
        static function inject(array $lang, string $pathToFile): array
        {
            // check if language is saved in session or cookie to prevent unnecessary db actions
            if (isset($_SESSION['lang']))
            {   // set from session setting
                $currentLanguage = $_SESSION['lang'];
            }
            elseif (isset($_COOKIE['lang']))
            {   // set from cookie setting
                $currentLanguage = $_COOKIE['lang'];
            }
            elseif (isset($_GET['lang']))
            {   // set from cookie setting
                $currentLanguage = $_GET['lang'];
            }
            else
                {   // get current language from db
                    $currentLanguage = language::getCurrentLanguageStatic();
                    if (isset($currentLanguage) && (!empty($currentLanguage)))
                    {   // set session var to save database resources
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

        /**
         * @brief return options (inner html) for a language select field
         * @return string returns a string with all possible language options
         */
        static function drawLanguageSelectOptions(): string
        {
            return '<option value=""></option>
                      <option value="af">Afrikaans</option>
                      <option value="sq">Albanian - shqip</option>
                      <option value="am">Amharic - አማርኛ</option>
                      <option value="ar">Arabic - العربية</option>
                      <option value="an">Aragonese - aragonés</option>
                      <option value="hy">Armenian - հայերեն</option>
                      <option value="ast">Asturian - asturianu</option>
                      <option value="az">Azerbaijani - azərbaycan dili</option>
                      <option value="eu">Basque - euskara</option>
                      <option value="be">Belarusian - беларуская</option>
                      <option value="bn">Bengali - বাংলা</option>
                      <option value="bs">Bosnian - bosanski</option>
                      <option value="br">Breton - brezhoneg</option>
                      <option value="bg">Bulgarian - български</option>
                      <option value="ca">Catalan - català</option>
                      <option value="ckb">Central Kurdish - کوردی (دەستنوسی عەرەبی)</option>
                      <option value="zh">Chinese - 中文</option>
                      <option value="zh-HK">Chinese (Hong Kong) - 中文（香港）</option>
                      <option value="zh-CN">Chinese (Simplified) - 中文（简体）</option>
                      <option value="zh-TW">Chinese (Traditional) - 中文（繁體）</option>
                      <option value="co">Corsican</option>
                      <option value="hr">Croatian - hrvatski</option>
                      <option value="cs">Czech - čeština</option>
                      <option value="da">Danish - dansk</option>
                      <option value="nl">Dutch - Nederlands</option>
                      <option value="en">English</option>
                      <option value="en-AU">English (Australia)</option>
                      <option value="en-CA">English (Canada)</option>
                      <option value="en-IN">English (India)</option>
                      <option value="en-NZ">English (New Zealand)</option>
                      <option value="en-ZA">English (South Africa)</option>
                      <option value="en-GB">English (United Kingdom)</option>
                      <option value="en-US">English (United States)</option>
                      <option value="eo">Esperanto - esperanto</option>
                      <option value="et">Estonian - eesti</option>
                      <option value="fo">Faroese - føroyskt</option>
                      <option value="fil">Filipino</option>
                      <option value="fi">Finnish - suomi</option>
                      <option value="fr">French - français</option>
                      <option value="fr-CA">French (Canada) - français (Canada)</option>
                      <option value="fr-FR">French (France) - français (France)</option>
                      <option value="fr-CH">French (Switzerland) - français (Suisse)</option>
                      <option value="gl">Galician - galego</option>
                      <option value="ka">Georgian - ქართული</option>
                      <option value="de">German - Deutsch</option>
                      <option value="de-AT">German (Austria) - Deutsch (Österreich)</option>
                      <option value="de-DE">German (Germany) - Deutsch (Deutschland)</option>
                      <option value="de-LI">German (Liechtenstein) - Deutsch (Liechtenstein)</option>
                      <option value="de-CH">German (Switzerland) - Deutsch (Schweiz)</option>
                      <option value="el">Greek - Ελληνικά</option>
                      <option value="gn">Guarani</option>
                      <option value="gu">Gujarati - ગુજરાતી</option>
                      <option value="ha">Hausa</option>
                      <option value="haw">Hawaiian - ʻŌlelo Hawaiʻi</option>
                      <option value="he">Hebrew - עברית</option>
                      <option value="hi">Hindi - हिन्दी</option>
                      <option value="hu">Hungarian - magyar</option>
                      <option value="is">Icelandic - íslenska</option>
                      <option value="id">Indonesian - Indonesia</option>
                      <option value="ia">Interlingua</option>
                      <option value="ga">Irish - Gaeilge</option>
                      <option value="it">Italian - italiano</option>
                      <option value="it-IT">Italian (Italy) - italiano (Italia)</option>
                      <option value="it-CH">Italian (Switzerland) - italiano (Svizzera)</option>
                      <option value="ja">Japanese - 日本語</option>
                      <option value="kn">Kannada - ಕನ್ನಡ</option>
                      <option value="kk">Kazakh - қазақ тілі</option>
                      <option value="km">Khmer - ខ្មែរ</option>
                      <option value="ko">Korean - 한국어</option>
                      <option value="ku">Kurdish - Kurdî</option>
                      <option value="ky">Kyrgyz - кыргызча</option>
                      <option value="lo">Lao - ລາວ</option>
                      <option value="la">Latin</option>
                      <option value="lv">Latvian - latviešu</option>
                      <option value="ln">Lingala - lingála</option>
                      <option value="lt">Lithuanian - lietuvių</option>
                      <option value="mk">Macedonian - македонски</option>
                      <option value="ms">Malay - Bahasa Melayu</option>
                      <option value="ml">Malayalam - മലയാളം</option>
                      <option value="mt">Maltese - Malti</option>
                      <option value="mr">Marathi - मराठी</option>
                      <option value="mn">Mongolian - монгол</option>
                      <option value="ne">Nepali - नेपाली</option>
                      <option value="no">Norwegian - norsk</option>
                      <option value="nb">Norwegian Bokmål - norsk bokmål</option>
                      <option value="nn">Norwegian Nynorsk - nynorsk</option>
                      <option value="oc">Occitan</option>
                      <option value="or">Oriya - ଓଡ଼ିଆ</option>
                      <option value="om">Oromo - Oromoo</option>
                      <option value="ps">Pashto - پښتو</option>
                      <option value="fa">Persian - فارسی</option>
                      <option value="pl">Polish - polski</option>
                      <option value="pt">Portuguese - português</option>
                      <option value="pt-BR">Portuguese (Brazil) - português (Brasil)</option>
                      <option value="pt-PT">Portuguese (Portugal) - português (Portugal)</option>
                      <option value="pa">Punjabi - ਪੰਜਾਬੀ</option>
                      <option value="qu">Quechua</option>
                      <option value="ro">Romanian - română</option>
                      <option value="mo">Romanian (Moldova) - română (Moldova)</option>
                      <option value="rm">Romansh - rumantsch</option>
                      <option value="ru">Russian - русский</option>
                      <option value="gd">Scottish Gaelic</option>
                      <option value="sr">Serbian - српски</option>
                      <option value="sh">Serbo-Croatian - Srpskohrvatski</option>
                      <option value="sn">Shona - chiShona</option>
                      <option value="sd">Sindhi</option>
                      <option value="si">Sinhala - සිංහල</option>
                      <option value="sk">Slovak - slovenčina</option>
                      <option value="sl">Slovenian - slovenščina</option>
                      <option value="so">Somali - Soomaali</option>
                      <option value="st">Southern Sotho</option>
                      <option value="es">Spanish - español</option>
                      <option value="es-AR">Spanish (Argentina) - español (Argentina)</option>
                      <option value="es-419">Spanish (Latin America) - español (Latinoamérica)</option>
                      <option value="es-MX">Spanish (Mexico) - español (México)</option>
                      <option value="es-ES">Spanish (Spain) - español (España)</option>
                      <option value="es-US">Spanish (United States) - español (Estados Unidos)</option>
                      <option value="su">Sundanese</option>
                      <option value="sw">Swahili - Kiswahili</option>
                      <option value="sv">Swedish - svenska</option>
                      <option value="tg">Tajik - тоҷикӣ</option>
                      <option value="ta">Tamil - தமிழ்</option>
                      <option value="tt">Tatar</option>
                      <option value="te">Telugu - తెలుగు</option>
                      <option value="th">Thai - ไทย</option>
                      <option value="ti">Tigrinya - ትግርኛ</option>
                      <option value="to">Tongan - lea fakatonga</option>
                      <option value="tr">Turkish - Türkçe</option>
                      <option value="tk">Turkmen</option>
                      <option value="tw">Twi</option>
                      <option value="uk">Ukrainian - українська</option>
                      <option value="ur">Urdu - اردو</option>
                      <option value="ug">Uyghur</option>
                      <option value="uz">Uzbek - o‘zbek</option>
                      <option value="vi">Vietnamese - Tiếng Việt</option>
                      <option value="wa">Walloon - wa</option>
                      <option value="cy">Welsh - Cymraeg</option>
                      <option value="fy">Western Frisian</option>
                      <option value="xh">Xhosa</option>
                      <option value="yi">Yiddish</option>
                      <option value="yo">Yoruba - Èdè Yorùbá</option>
                      <option value="zu">Zulu - isiZulu</option>';
        }

    } /* END CLASS */
}
