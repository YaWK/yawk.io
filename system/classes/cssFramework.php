<?php
namespace YAWK\FRAMEWORK {
use YAWK\language;

    /**
     * @details <b>Bootstrap CSS check version + return corresponding css</b>
     * <p>This is a helper function, used by admin/includes/template-save.php.
     * It generates the custom css code for the current loaded bootstrap version,
     * depending on the selection of the fields within the backend.</p>
     *
     * @author     Daniel Retzl <danielretzl@gmail.com>
     * @copyright  2018 Daniel Retzl yawk.io
     * @license    https://opensource.org/licenses/MIT
     * @version    1.0.0
     * @brief Helper function to output custom (overriden) bootstrap css (settings.css)
     */
    class cssFramework
    {
        /** @param int current loaded bootstrap version */
        public $version = '';
        /** @param array template settings array */
        public $tplSettings = '';
        /** @param string all the css as string */
        public $cssCode = '';

        // call constructor on object creation

        /**
         * cssFramework constructor.
         * @param $version string the current bootstrap version to work with
         * @param $tplSettings array the template settings array
         */
        public function __construct($version, $tplSettings)
        {
            /** @var $lang language */
            // check if bootstrap version is set
            if (isset($version) && (is_string($version) && (!empty($version))))
            {
                // set this bootstrap version
                $this->version = $version;
            }
            else
                {   // bootstrap version not set, try to query current active version
                    if (!isset($db))
                    {   // create new db object
                        $db = new \YAWK\db;
                    }
                    // check if template obj is set
                    if (!isset($template))
                    {   // if not, create new template object
                        $template = new \YAWK\template();
                    }
                    // get current template ID
                    $currentTemplateID = \YAWK\template::getCurrentTemplateId($db);
                    // check and set current bootstrap version
                    $this->version = $template->checkBootstrapVersion($db, $currentTemplateID, $lang);
                }

            // check and set this template settings array
            if (isset($tplSettings) && (is_array($tplSettings)) && (!empty($tplSettings)))
            {   // set this template settings array
                $this->tplSettings = $tplSettings;
            }
            else
                {   // tpl settings param not set, empty or wrong type - try to query array instead
                    if (!isset($db))
                    {   // create new db object
                        $db = new \YAWK\db;
                    }
                    // get current template ID
                    $currentTemplateID = \YAWK\template::getCurrentTemplateId($db);
                    // get template settings array
                    $this->tplSettings = \YAWK\template::getTemplateSettingsArray($db, $currentTemplateID);
                }
        }


        /**
         * @details Initialize and start check function
         * @return string|null the generated css code as (big) string
         * @brief Init calls setBootstrapComponents and return all css code as string on success or null on error
         */
        public function init()
        {
            // load required methods, depending on this bootstrap version
            if ($this->setBootstrapComponents() === true)
            {
                // ok, return css code
                return $this->cssCode;
            }
            else
                {   // unknown error
                    return null;
                }
        }

        /**
         * @details Check and return generated CSS Code as string
         * @return string|null the generated css code as (big) string
         * @brief Check CSS code and return it on success as string, otherwise return null
         */
        public function outputCssCode()
        {   // check if css code string is set and not empty
            if (isset($this->cssCode) && (is_string($this->cssCode) && (!empty($this->cssCode))))
            {   // ok, return css code
                return $this->cssCode;
            }
            else
                {   // do nothing
                    return null;
                }
        }

        /**
         * @brief  Check if Bootstrap is version 3 or 4 and load the required component methods
         * @return true|null the generated css code as (big) string
         * @details  Return true after executing component methods or false if Bootstrap version is unknown
         */
        public function setBootstrapComponents()
        {
            // if Bootstrap 3 is loaded
            if ($this->version == 3)
            {   // include bootstrap 3 class
                require_once 'bootstrap3.php';
                // generate new object
                $bootstrap3 = new \YAWK\FRAMEWORK\BOOTSTRAP3\bootstrap3($this->version, $this->tplSettings);
                // init bootstrap 3 class
                $this->cssCode = $bootstrap3->init();
                // check if bootstrap 3 css code is set
                if (isset($this->cssCode) && (is_string($this->cssCode) && (!empty($this->cssCode))))
                {   // bootstrap 3 css code is set
                    return true;
                }
                else
                    {   // css code not set properly
                        return null;
                    }
            }
            // if Bootstrap 4 is loaded
            if ($this->version == 4)
            {   // include bootstrap 4 class
                require_once 'bootstrap4.php';
                // generate new object
                $bootstrap4 = new \YAWK\FRAMEWORK\BOOTSTRAP4\bootstrap4($this->version, $this->tplSettings);
                // init bootstrap 4 class
                $this->cssCode = $bootstrap4->init();
                // check if bootstrap 4 css code is set
                if (isset($this->cssCode) && (is_string($this->cssCode) && (!empty($this->cssCode))))
                {   // bootstrap 4 css code is set
                    return true;
                }
                else
                {   // css code not set properly
                    return null;
                }
            }
            else
                {
                    // bootstrap version not supported
                    return null;
                }
        }
    }
}