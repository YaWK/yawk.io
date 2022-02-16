<?php
namespace YAWK {
    /**
     * @details <b>Display the tip of the day. <i>(if enabled)</i></b>
     *
     * This class handles all tip of the day functions.
     * Tips are stored in cms_tips database.
     * <i>Example:</i>
     * <code><?php YAWK\tipOfDay::displayRandom($db); ?></code>
     * To show a random tip of the day.
     * <p><i>Class covers backend functionality.
     * See Methods Summary for Details!</i></p>
     *
     * @author     Daniel Retzl <danielretzl@gmail.com>
     * @copyright  2009-2015 Daniel Retzl yawk.io
     * @license    https://opensource.org/licenses/MIT
     * @version    1.0.0
     * @brief TipOfDay class serve functions to get and draw a tip of the day
     */
    class tipOfDay extends \YAWK\alert
    {
        public $id = 1;
        public $published = 1;
        public $sortation = 0;
        public $tipClass = "";
        public $tipHeading = "";
        public $tipText = "";
        public $tipLink = "";

        /**
         * @brief Draw a tip of the day
         * @return bool
         */
        public function setPublished($db, $id, $published)
        {
            /** @var $db \YAWK\db */
            // update database
            if ($db->query("UPDATE {tips} SET published = '".$published."' WHERE id = '".$id."'"))
            {   // all good
                return true;
            }
            else
            {   // failed to set publish status
                \YAWK\sys::setSyslog($db, 3, 1, "failed to set tip of the day ID #$this->id to published state 0",0, 0, 0, 0);
                return false;
            }
        }

        /**
         * @brief Store a new tip to database
         * @param object $db Database Object
         * @param int $published 1 = Tip is published (unseen) 0 = Tip is not published (already seen)
         * @param string $tipHeading Heading of the tip, up to 255 chars
         * @param string $tipText Text of the tip, up to 255 chars
         * @param string $tipLink Link of the tip, up to 255 chars
         *
         */
        public function setTip($db, $published, $tipHeading, $tipText, $tipLink)
        {
            /** @var $db \YAWK\db */
            // preprate data
            if (isset($published) && (!empty($published)))
            { $db->quote($published); }
            if (isset($tipHeading) && (!empty($tipHeading)))
            { $db->quote($tipHeading); }
            if (isset($tipText) && (!empty($tipText)))
            { $db->quote($tipText); }
            if (isset($tipLink) && (!empty($tipLink)))
            { $db->quote($tipLink); }
            // insert tip into database
            if ($db->query("INSERT INTO {tips} (published, tipClass, tipHeading, tipText, tipLink)
                                   VALUES 
                                   ('".$published."',
                                    '".$tipHeading."',
                                    '".$tipText."',
                                    '".$tipLink."'"))
            {   // all good
                return true;
            }
            else
                {   // failed to insert tip into database
                    return false;
                }
        }

        /**
         * @brief Get a random tip from database that is still unseen.
         * @param $db
         * @return bool
         */
        public function getRandomTipData($db)
        {
            /** @var $db \YAWK\db */
            if (\YAWK\settings::getSetting($db, "backendTipOfDayRepeat") == true)
            {
                $sql = "";
            }
            else
            {
                $sql = "WHERE published = 1";
            }

            if ($res = $db->query("SELECT * FROM {tips} $sql ORDER BY rand() LIMIT 1"))
            {
                // get tip data into array
                $row = mysqli_fetch_assoc($res);
                // check data before we return it
                if (is_array($row) && (!empty($row)))
                {   // walk through array
                    foreach ($row as $property => $value)
                    {   // set current object properties
                        $this->$property = $value;
                    }
                    // all done
                    return true;
                }
                else
                    {   // array is not set or empty
                        return false;
                    }
            }
            else
                {
                    // query failed
                    return false;
                }
        }

        /**
         * @brief Get a the next single tip which is not already seen (still published)
         * @details To get the order, ID and published fields will be used in the query.
         * @param object $db database object
         * @return bool
         */
        public function getNextTipData($db)
        {
            /** @var $db \YAWK\db */
            // query data: ordered ascending by ID, only entries that are unseen
            if ($res = $db->query("SELECT * FROM {tips} WHERE published = 1 ORDER BY id ASC LIMIT 1"))
            {
                // get tip data into array
                $row = mysqli_fetch_assoc($res);
                // check data before we return it
                if (is_array($row) && (!empty($row)))
                {   // all good, return data
                    foreach ($row as $property => $value)
                    {   // set object properties
                        $this->$property = $value;
                    }
                    // data set, all good -
                    return true;
                }
                else
                {
                    // array empty - check if repeat tips is enabled
                    if (\YAWK\settings::getSetting($db, "backendTipOfDayRepeat") == true)
                    {
                        if ($db->query("UPDATE {tips} SET published = 1"))
                        {
                            // call function again to show first tip
                            $this->getNextTipData($db);
                        }
                    }
                    // start again with 1st tip
                    return true;
                }
            }
            else
            {   // query failed
                return false;
            }
        }

        /**
         * @brief Draw tip of the day.
         * @param object $db database object
         * @param array $lang language array
         * @return string
        */
        public function drawTip($db, $lang)
        {
            // get next tip on load, ordered by ID
            $this->getNextTipData($db);
            // or get random tip on load
            // $this->getRandomTipData($db);

            if (isset($this->tipLink) && (!empty($this->tipLink)))
            {
                if (filter_var($this->tipLink, FILTER_VALIDATE_URL))
                {
                    $this->tipText .= "<br><a href=\"#\">$this->tipLink</a>";
                }
            }
            if (isset($this->tipHeading) && (empty($this->tipHeading)))
            {
                // todo: last message that tutorial is over?
                return false;
            }
            else if (isset($this->tipText) && (empty($this->tipText)))
            {
                // todo: last message that tutorial is over?
                return false;
            }
            else
                {
                    if($this->setPublished($db, $this->id, 0) == false)
                    {
                        return "failed to set tip to zero";
                    }
                    $this->tipHeading = $lang[$this->tipHeading];
                    $this->tipText = $lang[$this->tipText];
                    return alert::draw("tipofday", "Tip #$this->id - $this->tipHeading", "$this->tipText", '', 10000);
                }
        }

    } /* end class TipOfDay */
} /* end namespace */
