<?PHP
namespace YAWK {
    /**
     * <b>Get and set the backend language.</b>
     *
     * <p>Language Support for Backend</i></p>
     * The language files are located in<br>
     * admin/language/lang-en-EN.ini
     *
     * @category   CMS
     * @package    System
     * @global     $_SESSION
     * @global     $_COOKIE
     * @global     $_USER
     * @global     $lang
     * @author     Daniel Retzl <danielretzl@gmail.com>
     * @copyright  2009-2015 Daniel Retzl yawk.goodconnect.net
     * @license    http://www.gnu.org/licenses/gpl-2.0  GNU/GPL 2.0
     * @version    1.1.3
     * @link       http://yawk.goodconnect.net/
     * @since      File available since Release 0.0.9
     * @annotation The language class - support multilingual backend
     */
    class language
    {
        public $lang;

        public function init(){
            if (isset($_GET['lang'])) {
                self::setLanguage($_GET['lang']);
            }
            else {
                self::setLanguage("en-EN");
            }
            return $this->lang;
        }

        static function getClientLanguage()
        {
            $client_lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 5);
            return $client_lang;
        }

        public function setLanguage($lang)
        {
            global $_SESSION;
            global $_COOKIE;
            global $_GET;
            global $lang;

            /* LANGUAGE TASKS */
            /* is the language switched right now */
            if (isSet($_GET['lang'])) {
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
            else {
                $lang = 'en-EN';
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
