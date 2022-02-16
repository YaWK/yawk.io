<?php
namespace YAWK
{
    /**
     * @details Class licenses
     * This class serves methods to get any license returned as text
     * or write it as LICENSE to given target folder. This is mainly
     * used by the template system to add the correct license file
     * if a .zip gets made from any template.
     *
     * @author     Daniel Retzl <danielretzl@gmail.com>
     * @copyright  2018 Daniel Retzl
     * @license    https://opensource.org/licenses/MIT
     * @version    1.0.0
     * @brief License Generator Class
     */
    class licenses
    {
        /** @param string current license to work with */
        public $license = '';
        /** @param string package description */
        public $description = '';
        /** @param string copyright year */
        public $year = '';
        /** @param string license holder (name) */
        public $holder = '';
        /** @param string target folder to write the LICENSE file */
        public $target = '';
        /** @param string current license text */
        public $licenseText = '';
        /** @param string LICENSE filename (used by $this->writeLicenseFile) */
        public $licenseFilename = 'LICENSE';

        /**
         * @brief Licenses constructor create requested license for holder
         * @param $license string the license that should be generated
         * @param $description string one line to give the program's name and a brief idea of what it does.
         * @param $year string year when it was licensed
         * @param $holder string copyright holder this license belongs to
         * @param $target string folder where to write te template
         */
        public function __construct($license, $description, $year, $holder, $target)
        {
            // check if license is set
            if (isset($license) && (!empty($license) && (is_string($license))))
            {
                $this->license = $license;
            }

            // check if license description (software description) is set
            if (isset($description) && (!empty($description) && (is_string($description))))
            {
                $this->description = $description;
            }

            // check if license year is set
            if (isset($year) && (!empty($year) && (is_string($year))))
            {
                $this->year = $year;
            }
            
            // check if license holder is set
            if (isset($holder) && (!empty($holder) && (is_string($holder))))
            {
                $this->holder = $holder;
            }
            
            // check if target is set
            if (isset($target) && (!empty($target) && (is_string($target))))
            {
                $this->target = $target;
            }
        }

        /**
         * @brief Create license text and return it as string (or false)
         * @return string|false
         */
        public function getLicenseText()
        {
            // create and return license
            if ($this->createLicenseText() === false)
            {   // license text creation failed (this should be unable to happen...)
                return false;
            }

            // check if license text is set and not empty
            if (isset($this->licenseText) && (!empty($this->licenseText)))
            {   // license set, return as string
                return $this->licenseText;
            }
            else
                {   // license text not set or empty
                    return false;
                }
        }

        /**
         * @brief Create license text and write it as LICENSE file to $this->target folder
         * @return bool
         */
        public function writeLicenseFile()
        {
            // create and return license
            if ($this->createLicenseText() === false)
            {   // license text creation failed (this should be unable to happen...)
                return false;
            }

            if ($this->checkFolder() === false)
            {   // check folder not writeable!
                return false;
            }
            else
                {   // write license file to target
                    if (!file_put_contents($this->target.$this->licenseFilename, $this->licenseText))
                    {   // failed to write license file to target folder
                        // todo: add syslog - failed to write LICENSE to target folder
                        return false;
                    }
                    else
                        {   // LICENSE file successfully written to target folder
                            return true;
                        }
                }
        }

        /**
         * @brief Create license text and save string as obj property
         * @return bool
         */
        public function createLicenseText()
        {
            // check if required obj properties are set
            if (!isset($this->license) || (!isset($this->holder) || (!isset($this->year) ||(!isset($this->description)))
            || (empty($this->license) || (empty($this->holder) || (empty($this->year) || (empty($this->description)))))))
            {   // if not
                return false;
            }

            // ok, check which license should be generated
            switch ($this->license)
            {
                // MIT
                case "MIT":
                {
                    $this->licenseText = "
                    ".$this->description."
                    Copyright (C) ".$this->year." copyright ".$this->holder."
                    Permission is hereby granted, free of charge, to any person 
                    obtaining a copy of this software and associated documentation 
                    files (the \"Software\"), to deal in the Software without 
                    restriction, including without limitation the rights to use, 
                    copy, modify, merge, publish, distribute, sublicense, and/or 
                    sell copies of the software, and to permit persons to whom 
                    the software is furnished to do so, subject to the following 
                    conditions:
                    
                    The above copyright notice and this permission notice shall 
                    be included in all copies or substantial portions of the software.
                    
                    THE SOFTWARE IS PROVIDED \"AS IS\", WITHOUT WARRANTY OF ANY KIND, 
                    EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES 
                    OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND 
                    NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT 
                    HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, 
                    WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING 
                    FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE 
                    OR OTHER DEALINGS IN THE SOFTWARE.";
                    return true;
                }
                break;

                // APACHE
                case "APACHE2":
                {
                    $this->licenseText = "
                    ".$this->description."
                    Copyright ".$this->year." ".$this->holder."
                    
                    Licensed under the Apache License, Version 2.0 (the \"License\");
                    you may not use this file except in compliance with the License.
                    You may obtain a copy of the License at
                    
                       http://www.apache.org/licenses/LICENSE-2.0
                    
                    Unless required by applicable law or agreed to in writing, software
                    distributed under the License is distributed on an \"AS IS\" BASIS,
                    WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
                    See the License for the specific language governing permissions and
                    limitations under the License.";
                    return true;
                }
                break;

                // GPL 2
                case "GPL2":
                {
                    $this->licenseText = "
                    ".$this->description."
                    Copyright (C) ".$this->year."  ".$this->holder."
                    
                    This program is free software; you can redistribute it and/or
                    modify it under the terms of the GNU General Public License
                    as published by the Free Software Foundation; either version 2
                    of the License, or (at your option) any later version.
                    
                    This program is distributed in the hope that it will be useful,
                    but WITHOUT ANY WARRANTY; without even the implied warranty of
                    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
                    GNU General Public License for more details.
                    
                    You should have received a copy of the GNU General Public License
                    along with this program; if not, write to the Free Software
                    Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.";
                    return true;
                }
                break;

                // GPL 3
                case "GPL3":
                {
                    $this->licenseText = "
                    ".$this->description."
                    Copyright (C) ".$this->year."  ".$this->holder."
                    This program is free software: you can redistribute it and/or modify
                    it under the terms of the GNU General Public License as published by
                    the Free Software Foundation, either version 3 of the License, or
                    (at your option) any later version.
                    
                    This program is distributed in the hope that it will be useful,
                    but WITHOUT ANY WARRANTY; without even the implied warranty of
                    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
                    GNU General Public License for more details.
                    
                    You should have received a copy of the GNU General Public License
                    along with this program.  If not, see <https://www.gnu.org/licenses/>.
                    ";
                    return true;
                }
                break;

                // LGPL 2
                case "Lesser GPL 2.0":
                {
                    $this->licenseText = "
                    ".$this->description."
                    Copyright (C) ".$this->year."  ".$this->holder."

                    This library is free software; you can redistribute it and/or
                    modify it under the terms of the GNU Library General Public
                    License as published by the Free Software Foundation; either
                    version 2 of the License, or (at your option) any later version.
                    
                    This library is distributed in the hope that it will be useful,
                    but WITHOUT ANY WARRANTY; without even the implied warranty of
                    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
                    Library General Public License for more details.
                    
                    You should have received a copy of the GNU Library General Public
                    License along with this library; if not, write to the
                    Free Software Foundation, Inc., 51 Franklin St, Fifth Floor,
                    Boston, MA  02110-1301, USA.";
                    return true;
                }
                break;

                // LGPL 2.1
                case "Lesser GPL 2.1":
                {
                    $this->licenseText = "
                    ".$this->description."
                    Copyright (C) ".$this->year."  ".$this->holder."

                    This library is free software; you can redistribute it and/or
                    modify it under the terms of the GNU Lesser General Public
                    License as published by the Free Software Foundation; either
                    version 2.1 of the License, or (at your option) any later version.
                    
                    This library is distributed in the hope that it will be useful,
                    but WITHOUT ANY WARRANTY; without even the implied warranty of
                    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
                    Lesser General Public License for more details.
                    
                    You should have received a copy of the GNU Lesser General Public
                    License along with this library; if not, write to the Free Software
                    Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301  USA";
                    return true;
                }
                break;

                // DEFAULT: MIT
                default:
                {
                    $this->licenseText = "
                    ".$this->description."
                    Copyright (C) ".$this->year." copyright ".$this->holder."
                    Permission is hereby granted, free of charge, to any person 
                    obtaining a copy of this software and associated documentation 
                    files (the \"Software\"), to deal in the Software without 
                    restriction, including without limitation the rights to use, 
                    copy, modify, merge, publish, distribute, sublicense, and/or 
                    sell copies of the software, and to permit persons to whom 
                    the software is furnished to do so, subject to the following 
                    conditions:
                    
                    The above copyright notice and this permission notice shall 
                    be included in all copies or substantial portions of the software.
                    
                    THE SOFTWARE IS PROVIDED \"AS IS\", WITHOUT WARRANTY OF ANY KIND, 
                    EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES 
                    OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND 
                    NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT 
                    HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, 
                    WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING 
                    FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE 
                    OR OTHER DEALINGS IN THE SOFTWARE.";
                    return true;
                }
                break;
            }
        }

        /**
         * @brief Check if target folder exists and is writeable
         * @return bool true|false
         */
        public function checkFolder()
        {
            // check if target directory exists
            if (is_dir(dirname($this->target)))
            {   // ok, check if target folder is writeable
                if (is_writeable(dirname($this->target)))
                {   // all good,
                    return true;
                }
                else
                {   // todo: add syslog entry - target folder not writeable
                    return false;
                }
            }
            else
            {   // target directory does not exist, try to create it
                if (!mkdir(dirname($this->target)))
                {
                    // todo: add syslog - failed to create license target folder
                    return false;
                }
                else
                    {
                        // target folder created
                        return true;
                    }
            }
        }

    } // ./license class
} // ./namespace
