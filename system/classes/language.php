<?PHP
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
        /**
         * @var string $lang language string
         */
        public $lang;

        /**
         * @var string $lang current language string
         */
        public $current;

        /**
         * initialize and return current language
         * @author     Daniel Retzl <danielretzl@gmail.com>
         * @copyright  2009-2016 Daniel Retzl
         * @license    http://www.gnu.org/licenses/gpl-2.0  GNU/GPL 2.0
         * @link       http://yawk.io
         * @return string
         */
        public function init(){
            if (isset($_GET['lang']) && (!empty($_GET['lang']))) {
                self::setLanguage($_GET['lang']);
                    $this->current = $_GET['lang'];
            }
            else {
                self::setLanguage("en-EN");
                $this->current = "en-EN";
            }
            return $this->lang;
        }

        /**
         * get and return client language
         * @author     Daniel Retzl <danielretzl@gmail.com>
         * @copyright  2009-2016 Daniel Retzl
         * @license    http://www.gnu.org/licenses/gpl-2.0  GNU/GPL 2.0
         * @link       http://yawk.io
         * @return string
         */
        static function getClientLanguage()
        {
            $client_lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 5);
            return $client_lang;
        }

        /**
         * set client language and parse corresponding ini file to array $lang
         * @param string $lang the language as string (eg en-US)
         * @return array|string $lang returns a language array
         */
        public function setLanguage($lang)
        {
            global $lang;

            /* LANGUAGE TASKS */
            /* is the language switched right now */
            if (isset($_GET['lang'])) {
                $lang = $_GET['lang'];
                // register and overwrite session var
                $_SESSION['lang'] = $lang;
                // and set cookie
                setcookie('lang', $lang, time() + (60 * 60 * 24 * 1460));
            } /* language set, cookie set */
            else if (isSet($_SESSION['lang'])) {
                $lang = $_SESSION['lang'];
            } else if (isSet($_COOKIE['lang'])) {
                $lang = $_COOKIE['lang'];
            } /* if language cannot be set, set en as default */
            else
                {
                $lang = 'en-EN';
                $_SESSION['lang'] = $lang;
            }

            /* parse the language file */
            switch ($lang) {
                case 'en-EN':
                    $lang = parse_ini_file("language/lang-en-EN.ini");
                    break;

                case 'de-DE';
                    $lang = parse_ini_file("language/lang-de-DE.ini");
                    break;

                default:
                    $lang = parse_ini_file("language/lang-en-EN.ini");
            }

            return $lang;
        } /* end setLanguage */

    } /* END CLASS */
}
