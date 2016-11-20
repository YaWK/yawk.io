<?php

namespace YAWK {

    /**
     * Class installer
     * @package YAWK
     */
    class installer
    {
        /**
         * @var $config
         */
        private $config;

        /**
         * Check if installation is needed
         *
         */
        function checkForInstallation()
        {
            if (!is_file("install.ini"))
            {
                die ("Installer file not found.");
            }
            else
                {
                    // do installation...
                }
        }
    }
}
