<?php
namespace YAWK\PLUGINS\TOURDATES {
    /**
     * <b>Manage & render a list for any kind of events or band tourdates</b>
     * <p>Tour Dates Plugin hands you a simple but nice, clean bootstraped and
     * sortable Data Table. You can use it to present Tour Dates or any
     * other different kind of Events. Perfect for a Band Website or if
     * you need to manage and display a tabluar list with fields like
     * date, time, artist, venue & facebook event url. Data can be easily
     * managed, added, edited, copied & deleted in the admin backend.</p>
     * <p><i>Class covers both, backend & frontend functionality.
     * See Methods Summary for Details!</i></p>
     *
     * @author     Daniel Retzl <danielretzl@gmail.com>
     * @copyright  2009-2015 Daniel Retzl
     * @version    1.0.0
     * @brief Tour Dates Plugin hands you a simple but nice, clean
     * bootstraped & sortable Data Table. You can use it to present Tour
     * Dates. (Or any other different kind of Events...) Perfect for a Band Website.
     */
    class tourdates
    {
        /** * @param int tourdate/event ID  */
        public $id;
        /** * @param string event day */
        public $day;
        /** * @param string event month */
        public $month;
        /** * @param string event time */
        public $time;
        /** * @param string event date */
        public $date;
        /** * @param string event band name */
        public $band;
        /** * @param string event venue name */
        public $venue;
        /** * @param string facebook icon */
        public $fbicon;
        /** * @param string facebook event url */
        public $fburl;
        /** * @param int 0|1 1 means published, zero is not published */
        public $published;

        /**
         * @brief Inject Language Tags
         * @author Daniel Retzl <danielretzl@gmail.com>
         * @param array $lang language data array
         * @param object $language the language object
         * @return null
         */
        public function injectLanguageTags($lang, $language)
        {
            // #####################################################################################
            // prepare language tag injection
            // check if lang array is set
            if (!isset($lang) || (empty($lang) || (!is_array($lang) || (!isset($language) || (empty($language))))))
            {   // if no lang array is set
                // check if language object is set
                if (!isset($language))
                {   // if not, include language class
                    require_once '../system/classes/language.php';
                    // and create new language object
                    $language = new \YAWK\language();
                }
                // ok...
                $language->init();
                // convert lang object param to array
                $lang = (array) $language->lang;
            }
            // all should be set ok - finally: inject additional language tags
            return $lang = $language->inject($lang, "../system/plugins/tourdates/language/");
        }

        /**
         * @brief get data and draw html return table for frontend
         * @param object $db database
         * @return bool|string the html table, inclkuding data
         */
        public function getFrontendTable($db)
        {
            /** @var $db \YAWK\db */
            if (!$res = $db->query("SELECT * FROM {plugin_tourdates} WHERE published = '1' ORDER by date"))
            {   // q failed
                print \YAWK\alert::draw("warning", "Fehler:", "Es tut mir leid, die Tabelle konnte nicht abgerufen werden.","","4200");
                return false;
            }
            else
            {
                /* TABLE HEADER */
                $html = "<h3>" . date('Y') . "</h3>" . "<table border=\"0\" cellpadding=\"1\" cellspacing=\"1\" class=\"table table-responsive\">
                <tbody>";
                /* TABLE CONTENT */
                while ($row = mysqli_fetch_array($res)) {
                    $this->date = $row[1];
                    $this->band = $row[2];
                    $this->venue = $row[3];
                    $this->published = $row[4];
                    $this->fburl = $row[5];
                    if (!empty($this->fburl)) {
                        $this->fbicon = "<a href=\"$this->fburl\" target=\"_blank\"><img src=\"media/images/fbicon.png\"></a>";
                    } else {
                        $this->fbicon = "&nbsp;";
                    }

                    /* date string to array function */
                    $splitDate = \YAWK\sys::splitDate($this->date);
                    /* set seperated vars */
                    $year = $splitDate['year'];
                    $this->day = $splitDate['day'];
                    $this->month = $splitDate['month'];
                    $this->time = $splitDate['time'];

                    if ($this->published === '1') {
                        $pub = "success";
                        $pubtext = "On";
                    } else {
                        $pub = "danger";
                        $pubtext = "Off";
                    }
                    $html .= "<tr>
                <td>$this->day. $this->month</td>
                <td>$this->band</td>
                <td>$this->time</td>
                <td>$this->venue</td>
                <td>$this->fbicon</td>
              </tr>";

                }
                /* TABLE FOOTER */
                $html .= "</tbody>
            </table>";
                return $html;
            }
        } /* EOFunction getTable */

        /**
         * @brief get data and draw html return table for backend
         * @param object $db database
         * @param array $lang language array
         * @return bool|string the html table, including data
         */
        public function getBackendTable($db, $lang)
        {   /** @var $db \YAWK\db */
            if (!$res = $db->query("SELECT * FROM {plugin_tourdates} ORDER by date"))
            {   // q failed, throw error
                print \YAWK\alert::draw("warning", "Fehler:", "Es tut mir leid, die Tabelle konnte nicht abgerufen werden.","","4200");
                return false;
            }
            else
            {
                /* TABLE HEADER */
                $html = "";
                /* TABLE CONTENT */
                while ($row = mysqli_fetch_array($res)) {
                    $this->id = $row[0];
                    $this->date = $row[1];
                    $this->band = $row[2];
                    $this->venue = $row[3];
                    $this->published = $row[4];
                    $this->fburl = $row[5];

                    if (!empty($this->fburl)) {
                        $this->fbicon = "<a href=\"$this->fburl\" target=\"_blank\"><i class=\"fa fa-facebook-square\"></i></a>";
                    } else {
                        $this->fbicon = "&nbsp;";
                    }

                    /* date string to array function */
                    $splitDate = \YAWK\sys::splitDate($this->date);
                    /* set seperated vars */
                    $this->year = $splitDate['year'];
                    $this->day = $splitDate['day'];
                    $this->month = $splitDate['month'];
                    $this->time = $splitDate['time'];

                    if ($this->published === '1') {
                        $pub = "success";
                        $pubtext = "On";
                    } else {
                        $pub = "danger";
                        $pubtext = "Off";
                    }
                    $html .= "<tr>
                    <td class=\"text-center\">
                    <a title=\"toggle&nbsp;status\" href=\"index.php?plugin=tourdates&pluginpage=tourdates-toggle&id=" . $this->id . "\">
                    <span class=\"label label-$pub\">$pubtext</span></a></td>
                    <td>$this->day. $this->month</td>
                    <td><a href=\"index.php?plugin=tourdates&pluginpage=tourdates-edit&id=" . $this->id . "\"><div>$this->band</div></a></td>
                    <td>$this->time</td>
                    <td>$this->venue</td>
                    <td class=\"text-center\">$this->fbicon</td>
                    <td class=\"text-center\"><a class=\"fa fa-copy\" title=\"" . $lang['TOUR_COPY'] . "\" href=\"index.php?plugin=tourdates&pluginpage=tourdates-copy&id=" . $this->id . "&copy=true\"></a>&nbsp;
                        <a class=\"fa fa-edit\"title=\"" . $lang['TOUR_EDIT'] . "\" href=\"index.php?plugin=tourdates&pluginpage=tourdates-edit&id=" . $this->id . "\"></a>&nbsp;
                        <a class=\"fa fa-trash-o\" role=\"dialog\" data-confirm=\"Den Termin &laquo;" . $this->date . " @ " . $this->venue . "&raquo; wirklich l&ouml;schen?\"
                        title=\"" . $lang['TOUR_DELETE'] . "\" href=\"index.php?plugin=tourdates&pluginpage=tourdates-delete&id=" . $this->id . "&delete=1\">
                        </a>
                    </td>
                  </tr>";

                }
                return $html;
            }
        } /* EOFunction getAdminTable */


        /**
         * @brief toggle an entry online/offline, depending on published status
         * @param object $db database
         * @param int $id event ID to toggle
         * @param int $published 0|1 1 means published, zero is not published
         * @return bool
         */
        function toggleOffline($db, $id, $published)
        {   /** @var $db \YAWK\db */
            // TOGGLE GIG STATUS
            if (!$res = $db->query("UPDATE {plugin_tourdates}
              SET published = '" . $published . "'
              WHERE id = '" . $id . "'"))
            {   // q failed, throw error
                print \YAWK\alert::draw("danger", "Error", "Event status could not be toggled.","","4200");
                return false;
            }
            else
            {   // success
                return true;
            }
        } /* EOFunction toggleOffline */


        /**
         * @brief load settings into object properties
         * @param object $db database
         * @param int $id event ID
         */
        function loadProperties($db, $id)
        {   /** @var $db \YAWK\db */
            $res = $db->query("SELECT * FROM {plugin_tourdates}
                        WHERE id = '" . $id . "'");
            if ($row = mysqli_fetch_row($res)) {
                $this->id = $row[0];
                $this->date = $row[1];
                $this->band = $row[2];
                $this->venue = $row[3];
                $this->published = $row[4];
                $this->fburl = $row[5];
            }
        } /* EOFunction loadProperties */

        /**
         * @brief get highest ID from events (tourdates) database
         * @param object $db database
         * @return string|bool return highest ID or false
         */
        static function getMaxId($db)
        {    /** @var $db \YAWK\db */
            $tourdates = new tourdates();
            if ($res = $db->query("SELECT MAX(id) FROM {plugin_tourdates}"))
            {
                if ($row = mysqli_fetch_array($res)) {   // success
                    return $tourdates->maxID = $row[0];
                }
                else
                {   // fetch failed
                    return false;
                }
            }
            else
            {   // q failed
                return false;
            }
        }

        /**
         * @brief delete an entry
         * @param object $db database
         * @return bool
         */
        function delete($db)
        {    /** @var $db \YAWK\db */
            if (!$res = $db->query("DELETE FROM {plugin_tourdates} WHERE id = '" . $this->id . "'"))
            {   // q failed, throw error
                print \YAWK\alert::draw("danger", "Error", "Gig could not be deleted.", "plugin=tourdates","4200");
                return false;
            }
            else
            {   // success
                return true;
            }
        } /* EOFunction delete */


        /**
         * @brief copy an entry
         * @param object $db database
         * @param int $id event ID to copy
         * @return bool
         */
        function copy($db, $id)
        {
            /** @var $db \YAWK\db */
            if (!isset($tourdates))
            {   // create obj if its not set
                $tourdates = new \YAWK\PLUGINS\TOURDATES\tourdates();
            }
            /* load properties for given ID */
            $tourdates->loadProperties($db, $id);
            $tourdates->id = self::getMaxId($db) + 1;
            // # copy item to db tourdates
            if (!$res = $db->query("INSERT INTO {plugin_tourdates} (id,date,band,venue,published,fburl)
                        VALUES ('" . $tourdates->id . "',
                                '" . $tourdates->date . "',
                                '" . $tourdates->band . "',
                                '" . $tourdates->venue . "',
                                '" . $tourdates->published . "',
                                '" . $tourdates->fburl . "')"))
            {   // q failed, throw error
                print \YAWK\alert::draw("danger", "Error", "Gig could not be copied!","","4200");
                return false;
            }
            else
            {   // success
                return true;
            }
        } /* EOFunction copy($id);    */


        /**
         * @brief create a new event (tourdate)
         * @param object $db database
         * @param string $date datetime
         * @param string $band the band or artist
         * @param string $venue venue where the event happens
         * @param string $fburl URL to a facebook event (if any)
         * @return bool
         */
        function create($db, $date, $band, $venue, $fburl)
        {
            /** @var $db \YAWK\db */
            if (!isset($tourdates))
            {   // create obj if its not set
                $tourdates = new \YAWK\PLUGINS\TOURDATES\tourdates();
            }
            /* get max ID and add 1 */
            $id = self::getMaxId($db) + 1;
            $published = 1;

            $band = \YAWK\sys::encodeChars($band);
            $venue = \YAWK\sys::encodeChars($venue);

            // # create item in db tourdates
            if (!$res = $db->query("INSERT INTO {plugin_tourdates} (id,date,band,venue,published,fburl)
                        VALUES ('" . $id . "',
                                '" . $date . "',
                                '" . $band . "',
                                '" . $venue . "',
                                '" . $published . "',
                                '" . $fburl . "')"))
            {   // q failed
                return false;
            }
            else
            {   // success
                return true;
            }
        } /* EOFunction create();    */


        /**
         * @brief edit an entry
         * @param object $db database
         * @param int $id event ID
         * @param string $date event datetime
         * @param string $band band or artist
         * @param string $venue venue where the event happens
         * @param string $fburl URL to a facebook event (if any)
         * @return bool
         */
        function edit($db, $id, $date, $band, $venue, $fburl)
        {
            /** @var $db \YAWK\db */
            // # update item
            if (!$res = $db->query("UPDATE {plugin_tourdates}
  		        SET date = '" . $date . "',
                    band = '" . $band . "',
                    venue = '" . $venue . "',
                    fburl = '" . $fburl . "'
               WHERE id = '" . $id . "'"))
            {   // q failed
                print \YAWK\alert::draw("danger", "Error", "Termin konnte nicht bearbeitet werden.","","4800");
                return false;
            }
            else
            {   // success
                return true;
            }
        } /* EOFunction edit(id);    */
    }   // ./ class tourdates
} // ./namespace