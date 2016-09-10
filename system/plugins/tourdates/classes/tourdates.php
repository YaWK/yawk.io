<?php
namespace YAWK\PLUGINS\TOURDATES {
    /**
     * <b>Manage & render a list for any kind of events or band tourdates</b>
     *
     * Tour Dates Plugin hands you a simple but nice, clean bootstraped &
     * sortable Data Table. You can use it to present Tour Dates or any
     * other different kind of Events. Perfect for a Band Website or if
     * you need to manage and display a tabluar list with fields like
     * date, time, artist, venue & facebook event url. Data can be easily
     * managed, added, edited, copied & deleted in the admin backend.
     * <p><i>Class covers both, backend & frontend functionality.
     * See Methods Summary for Details!</i></p>
     *
     * @category   CMS
     * @package    Plugins
     * @global     $connection
     * @global     $dbprefix
     * @author     Daniel Retzl <danielretzl@gmail.com>
     * @copyright  2009-2015 Daniel Retzl yawk.goodconnect.net
     * @license    http://www.gnu.org/licenses/gpl-2.0  GNU/GPL 2.0
     * @version    1.1.3
     * @link       http://yawk.goodconnect.net/
     * @since      File available since Release 1.1.2
     * @annotation Tour Dates Plugin hands you a simple but nice, clean
     * bootstraped & sortable Data Table. You can use it to present Tour
     * Dates. (Or any other different kind of Events...) Perfect for a Band Website.
     */
    class tourdates
    {
        public $id;
        public $day;
        public $month;
        public $time;
        public $date;
        public $band;
        public $venue;
        public $lang;
        public $fburl;
        public $published;

        public function getFrontendTable($db)
        {
            /**
             * Data Table for Frontend Rendering
             *
             * This function  fetch data & render the Table to be called in the frontend.
             *
             * @access public
             */
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
                    <td style=\"text-align:center;\">
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


        function toggleOffline($db, $id, $published)
        {   /** @var $db \YAWK\db */
            // TOGGLE GIG STATUS
            if (!$res = $db->query("UPDATE {plugin_tourdates}
              SET published = '" . $published . "'
              WHERE id = '" . $id . "'"))
            {   // q failed, throw error
                print \YAWK\alert::draw("danger", "Error", "TourDates Status could not be toggled.","","4200");
                return false;
            }
            else
            {   // success
                return true;
            }
        } /* EOFunction toggleOffline */


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