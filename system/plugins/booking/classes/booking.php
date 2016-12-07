<?php
namespace YAWK\PLUGINS\BOOKING {
    /**
     * <b>Let users submit appointments from frontend. You can view & manage them in backend.</b>
     *
     * The Booking Plugin is a simple but nice, clean frontend form. Users
     * can submit appointments. The entries are managable in the backend.
     * Perfect for any kind of appointment requests. E.g. if you are a Hairdresser
     * your customers can submit their wished dates. You can manage them in the Backend,
     * and view data in a sortable, bootstraped table. You can set the Appointment to "done",
     * rate it, count how many times you've met that user, and many more.
     *
     * <p><i>Class covers both, backend & frontend functionality.
     * See Methods Summary for Details!</i></p>
     *
     * @package    YaWK
     * @author     Daniel Retzl <danielretzl@gmail.com>
     * @copyright  2009-2016 Daniel Retzl
     * @license    http://www.gnu.org/licenses/gpl-2.0  GNU/GPL 2.0
     * @version    1.0.0
     * @link       http://yawk.io
     * @annotation Booking Plugin is perfect if you want to let your customers submit
     * Appointments from Frontend. Entries can be viewed, setup and monitored in the Backend.
     */
    class booking
    {
        public $lang;
        public $day;
        public $month;
        public $time;
        public $id;
        public $uid;
        public $gid;
        public $date_created;
        public $date_wish;
        public $date_confirmed;
        public $name;
        public $email;
        public $phone;
        public $text;
        public $success;
        public $grade;
        public $visits;
        public $comment;
        public $ip;
        public $hostname;
        public $income;
        public $todo;
        public $confirmed;
        public $datewish_time;
        public $alternative_time;
        public $datewish_month;
        public $datewish_day;
        public $datewish_year;
        public $alternative_month;
        public $alternative_day;
        public $alternative_year;
        public $date_alternative;
        public $message;
        public $useragent;
        public $referer;
        public $outstanding_sum;
        public $outdated;
        public $ban;
        public $cut;
        public $invited;

        public function countVisits($db, $email)
        {   /** @var $db \YAWK\db */
            $i = 0;
            if ($res = $db->query("SELECT id FROM {plugin_booking}
                                                  WHERE email = '".$email."' AND success = '1'")) {
                while ($row = mysqli_fetch_array($res)){
                    $i++;
                }
            return $i;
            }
            else {
                return false;
            }
        }

        public function getStats($db)
        {   /** @var $db \YAWK\db */
            $income_sum = 0;
            $success_sum = 0;
            $grade_sum = 0;
            $i_dates = 0;
            $outstanding_sum = 0;
            $confirmed_outstanding_sum = 0;
            $i_date_waiting_sum = 0;
            $i_date_fix_sum = 0;
            $i_date_outdated = 0;
            $i_date_success = 0;
            if ($res = $db->query("SELECT success, income, grade, ban, confirmed, outdated FROM {plugin_booking}")) {
                while ($row = mysqli_fetch_assoc($res)) {
                    $this->success = $row['success'];
                    $this->income = $row['income'];
                    $this->grade = $row['grade'];
                    $this->ban = $row['ban'];
                    $this->confirmed = $row['confirmed'];
                    $this->outdated = $row['outdated'];

                    $i_dates++;
                    $success_sum += $this->success;
                    $grade_sum += $this->grade;

                    // add NOT confirmed money
                    if ($this->confirmed === '0' && $this->success !== '1' && $this->outdated !== '1'){
                        $outstanding_sum += $this->income;
                        $i_date_waiting_sum++;
                    }
                    // add confirmed money
                    if ($this->confirmed === '1' && $this->success !== '1' && $this->outdated !== '1'){
                        $confirmed_outstanding_sum += $this->income;
                        $i_date_fix_sum++;
                    }
                    // add outdated data
                    if ($this->outdated === '1'){
                        $i_date_outdated++;
                    }
                    // add succeeded money
                    if ($this->success === '1'){
                        $income_sum += $this->income;
                        $i_date_success++;
                    }
                }
                // calculate average grade
                if (isset($this->grade)) {
                    $avgGrade = $grade_sum / $i_date_success;
                    $avgGrade = substr("$avgGrade", 0, 3);
                } else { $avgGrade = 0; }


                echo "<ul class='list-group'>
                        <li class='list-group-item'><h4><i class='fa fa-money'></i> &nbsp;ausstehende, fixe Termine im Wert von:&nbsp; <b class='text-green'>&euro; ".$confirmed_outstanding_sum.",-</b></li></h4>
                        <li class='list-group-item'><h4><i class='fa fa-money'></i> &nbsp;neue, unbest&auml;tigte Termine im Wert von:&nbsp; <b class='text-orange'>&euro; ".$outstanding_sum.",- </b></li></h4>
                        <li class='list-group-item'><h4><i class='fa fa-money'></i> &nbsp;erfolgreich eingenommen, total:&nbsp; <b class='text-green'>&euro; ".$income_sum.",- </b></li></h4>
                        <li class='list-group-item'><h4><i class='fa fa-calendar'></i> &nbsp;insgesamt wurden <b>".$i_dates."</b> Termine angefragt. Davon sind <b class='text-green'>".$success_sum."</b> zustande gekommen. <b class='text-orange'>".$i_date_waiting_sum."</b> noch unbest&auml;tigt, <b class='text-green'>".$i_date_fix_sum."</b> sind fix. <b>".$i_date_outdated."</b> sind outdated.</li></h4>
                        <li class='list-group-item'><h4><i class='fa fa-calendar'></i> &nbsp;die Durchschnittsbewertung &uuml;ber alle Termine und User ist im Moment: <b>".$avgGrade."</b></li></h4>
                      </ul>";

            }
        }

        function toggleBan($db, $id, $email)
        {   /** @var $db \YAWK\db */
            if ($res = $db->query("SELECT ban FROM {plugin_booking}
                                                  WHERE id = '".$id."'"))
                if ($row = mysqli_fetch_row($res))
                {   // prepare vars
                    $ban = $row[0];
                    if ($ban === '0') { $ban = 1; } else { $ban = 0; }
                }
            // toggle ban status
            if (!$res = $db->query("UPDATE {plugin_booking}
              SET ban = '" . $ban . "'
              WHERE email = '".$email."'"))
            {
                print \YAWK\alert::draw("danger", "Error", "Ban status could not be toggled.", "",2000);
            }
            return true;
        }

        function toggleOutdated($db, $id)
        {   /** @var $db \YAWK\db */
            if ($res = $db->query("SELECT outdated FROM {plugin_booking}
                                                  WHERE id = '".$id."'"))
                $row = mysqli_fetch_row($res);
            $outdated = $row[0];
            if ($outdated === '0') { $outdated = 1; } else { $outdated = 0; }
            // toggle outdated status
            if (!$res = $db->query("UPDATE {plugin_booking}
              SET outdated = '" . $outdated . "'
              WHERE id = '".$id."'"))
            {
                print \YAWK\alert::draw("danger", "Error", "Outdated status could not be toggled.","",2000);
            }
            return true;
        }

        function inviteUser($db, $id, $email, $name)
        {   // get admin email adress from db
            $admin_email = \YAWK\settings::getSetting($db, "admin_email");
            // set invite status in user db
            if ($res = $db->query("UPDATE {plugin_booking} SET invited = '1' WHERE email='".$email."'"))
            {   // send email to invite user...
                $host = \YAWK\settings::getSetting($db, "host");
                $from = $admin_email;
                $to = $email;
                $cc = $admin_email;
                $subject = "VIP Club Invitation";
                $msg = "Hello $name!\n
            Your Access to our VIP Club is now activated!
            Please visit the following URL in your Browser:

            ".$host."/welcome.html

            There you can register with your Emailadress $to.
            Have fun!
            Regards,
            ".$host."";
                \YAWK\email::sendEmail($from, $to, "", $subject, $msg);
                \YAWK\email::sendEmail($to, $from, "", $subject, $msg);
                echo \YAWK\alert::draw("success", "Success", "Invitation Email sent to $to","index.php?plugin=booking","1800");
            }
            else {
                echo \YAWK\alert::draw("danger", "Error", "Could not invite user! Status cannot be changed. No email sent.","","3800");
            }
            return false;
        }

        public function getFrontendForm()
        {
            /**
             * Data Table for Frontend Rendering
             *
             * This function  fetch data & render the Table to be called in the frontend.
             *
             * @access public
             */

$html = "<form class=\"form\" id=\"form\" method=\"post\" action=\"hure-wien-buchen.html\">
        <div class=\"row\">
            <div class=\"col-md-4\">
                <p>Wie kann ich Dich kontaktieren?</p>
                <input type=\"\" name=\"name\" id=\"name\" class=\"form-control\" placeholder=\"Dein Name\">
                <label for=\"name\"><strong>Name</strong></label>
                <input type=\"\" name=\"email\" id=\"email\" class=\"form-control\" placeholder=\"you@email.com\">
                <label for=\"email\">Email</label>
                <input type=\"phone\" name=\"phone\" id=\"phone\" class=\"form-control\" placeholder=\"+43 664 / 1234567\">
                <label >Telefonnummer</label>
<br><br>
                <select id=\"todo\" name=\"todo\" class=\"form-control\">
                    <option value=\"0\" selected disabled>Was m&ouml;chtest Du tun?</option>
                    <option value=\"1\">Date zu zweit</option>
                    <option value=\"2\">Date zu zweit (Handjob)</option>
                    <option value=\"4\">Date zu zweit (Quickie)</option>
                    <option value=\"3\">Date zu dritt (FFM)</option>
                    <option value=\"0\">Ich habe eine andere Idee...</option>
                </select>

                <div id=\"1_hidden\" style=\"display: none;\"><br>Zu zweit ist es ganz besonders sch&ouml;n, romantisch, kuschelig.
                Eine Stunde, in der es nur um Deine Bed&uuml;rfnisse geht. Ich freue mich, wenn ich mich ausgiebig um Dich k&uuml;mmern kann.
                    <p class=\"small text-success\">Kosten: &euro; 160.- / Dauer ca. 60 Minuten.</p></div>
                    <div id=\"2_hidden\" style=\"display: none;\"><br>Ich nehme pjur light (Gleitgel) zur Hand und massiere Dein
                    bestes St&uuml;ck mit meinen H&auml;nden nach allen Regeln der Kunst. Ich liebe es, einen Schwanz
                    mit sanftem Druck abzuwichsen. Es wird Dir gefallen!
                    <p class=\"small text-success\">Kosten: &euro; 100.- / Dauer ca. 30 Minuten.</p></div>
                <div id=\"3_hidden\" style=\"display: none;\"><br>Welcher Mann tr&auml;umt nicht davon, mal mit 2 Frauen
                gleichzeitig zu spielen? Ist das auch eine Phantasie von Dir? Lass es mich wissen, damit ich meiner
                Freundin Bescheid geben kann! <i class='fa fa-smile-o'></i>
                     <p class=\"small text-success\">Kosten: &euro; 320.- / Dauer ca. 60 Minuten.</p></div>
                <div id=\"4_hidden\" style=\"display: none;\"><br>Wenn die Lust gro&szlig;, Deine freie Zeit aber knapp ist, bietet sich
                eine halbe Stunde an. In der Zeit k&ouml;nnen wir all das machen, was auch in einer Stunde m&ouml;glich
                ist. Ideal zur schnellen Entspannung.  <i class=\"fa fa-smile-o\"></i>
                    <p class=\"small text-success\">Kosten: &euro; 100.- / Dauer ca. 30 Minuten.</p> </div>
                <div id=\"5_hidden\" style=\"display: none;\"><br>Du m&ouml;chtest etwas anderes anstellen? Na dann, sei so lieb und
                    schreib es mir in die Box hier rechts. Vielen Dank!</div>
            </div>
            <div class=\"col-md-8\">
                <p>Dein Terminwunsch:</p>
                        <select name=\"datewish-month\" class=\"form-inline\">
                            <option value=\"00\" selected disabled>- Monat -</option>
                            <option value=\"01\">Januar</option>
                            <option value=\"02\">Februar</option>
                            <option value=\"03\">M&auml;rz</option>
                            <option value=\"04\">April</option>
                            <option value=\"05\">May</option>
                            <option value=\"06\">Juni</option>
                            <option value=\"07\">Juli</option>
                            <option value=\"08\">August</option>
                            <option value=\"09\">September</option>
                            <option value=\"10\">Oktober</option>
                            <option value=\"11\">November</option>
                            <option value=\"12\">Dezember</option>
                        </select>
                        <select name=\"datewish-day\" class=\"form-inline\">
                            <option value=\"00\" selected disabled>- Tag -</option>
                            <option value=\"01\">1</option>
                            <option value=\"02\">2</option>
                            <option value=\"03\">3</option>
                            <option value=\"04\">4</option>
                            <option value=\"05\">5</option>
                            <option value=\"06\">6</option>
                            <option value=\"07\">7</option>
                            <option value=\"08\">8</option>
                            <option value=\"09\">9</option>
                            <option value=\"10\">10</option>
                            <option value=\"11\">11</option>
                            <option value=\"12\">12</option>
                            <option value=\"13\">13</option>
                            <option value=\"14\">14</option>
                            <option value=\"15\">15</option>
                            <option value=\"16\">16</option>
                            <option value=\"17\">17</option>
                            <option value=\"18\">18</option>
                            <option value=\"19\">19</option>
                            <option value=\"20\">20</option>
                            <option value=\"21\">21</option>
                            <option value=\"22\">22</option>
                            <option value=\"23\">23</option>
                            <option value=\"24\">24</option>
                            <option value=\"25\">25</option>
                            <option value=\"26\">26</option>
                            <option value=\"27\">27</option>
                            <option value=\"28\">28</option>
                            <option value=\"29\">29</option>
                            <option value=\"30\">30</option>
                            <option value=\"31\">31</option>
                        </select>
                        <select name=\"datewish-time\" class=\"form-inline\">
                            <option value=\"00:00\" selected disabled>Uhrzeit</option>
                            <option value=\"08:30\">08:30</option>
                            <option value=\"09:00\">09:00</option>
                            <option value=\"09:30\">09:30</option>
                            <option value=\"10:00\">10:00</option>
                            <option value=\"10:30\">10:30</option>
                            <option value=\"11:00\">11:00</option>
                            <option value=\"11:30\">11:30</option>
                            <option value=\"12:00\">12:00</option>
                            <option value=\"12:30\">12:30</option>
                            <option value=\"13:00\">13:00</option>
                            <option value=\"13:30\">13:30</option>
                            <option value=\"14:00\">14:00</option>
                            <option value=\"14:30\">14:30</option>
                            <option value=\"15:00\">15:00</option>
                            <option value=\"15:30\">15:30</option>
                            <option value=\"16:00\">16:00</option> <!--
                            <option value=\"16:30\">16:30</option>
                            <option value=\"17:00\">17:00</option>
                            <option value=\"17:30\">17:30</option>
                            <option value=\"18:00\">18:00</option>
                            <option value=\"18:30\">18:30</option>
                            <option value=\"19:00\">19:00</option>
                            <option value=\"19:30\">19:30</option>
                            <option value=\"20:00\">20:00</option>
                            <option value=\"20:30\">20:30</option>
                            <option value=\"21:00\">21:00</option>
                            <option value=\"21:30\">21:30</option>
                            <option value=\"22:00\">22:00</option>
                            <option value=\"22:30\">22:30</option>
                            <option value=\"23:00\">23:00</option> -->
                        </select>
                <br><br>
                <p >Alternative?</p>
                        <select name=\"alternative-month\" class=\"form-inline\">
                            <option value=\"00\" selected disabled>- Monat -</option>
                            <option value=\"01\">Januar</option>
                            <option value=\"02\">Februar</option>
                            <option value=\"03\">M&auml;rz</option>
                            <option value=\"04\">April</option>
                            <option value=\"05\">May</option>
                            <option value=\"06\">Juni</option>
                            <option value=\"07\">Juli</option>
                            <option value=\"08\">August</option>
                            <option value=\"09\">September</option>
                            <option value=\"10\">Oktober</option>
                            <option value=\"11\">November</option>
                            <option value=\"12\">Dezember</option>
                        </select>
                        <select name=\"alternative-day\" class=\"form-inline\">
                            <option value=\"00\" selected disabled>- Tag -</option>
                            <option value=\"01\">1</option>
                            <option value=\"02\">2</option>
                            <option value=\"03\">3</option>
                            <option value=\"04\">4</option>
                            <option value=\"05\">5</option>
                            <option value=\"06\">6</option>
                            <option value=\"07\">7</option>
                            <option value=\"08\">8</option>
                            <option value=\"09\">9</option>
                            <option value=\"10\">10</option>
                            <option value=\"11\">11</option>
                            <option value=\"12\">12</option>
                            <option value=\"13\">13</option>
                            <option value=\"14\">14</option>
                            <option value=\"15\">15</option>
                            <option value=\"16\">16</option>
                            <option value=\"17\">17</option>
                            <option value=\"18\">18</option>
                            <option value=\"19\">19</option>
                            <option value=\"20\">20</option>
                            <option value=\"21\">21</option>
                            <option value=\"22\">22</option>
                            <option value=\"23\">23</option>
                            <option value=\"24\">24</option>
                            <option value=\"25\">25</option>
                            <option value=\"26\">26</option>
                            <option value=\"27\">27</option>
                            <option value=\"28\">28</option>
                            <option value=\"29\">29</option>
                            <option value=\"30\">30</option>
                            <option value=\"31\">31</option>
                        </select>
                        <select name=\"alternative-time\" class=\"form-inline\">
                            <option value=\"00:00\" selected disabled>Uhrzeit</option>
                            <option value=\"08:30\">08:30</option>
                            <option value=\"09:00\">09:00</option>
                            <option value=\"09:30\">09:30</option>
                            <option value=\"10:00\">10:00</option>
                            <option value=\"10:30\">10:30</option>
                            <option value=\"11:00\">11:00</option>
                            <option value=\"11:30\">11:30</option>
                            <option value=\"12:00\">12:00</option>
                            <option value=\"12:30\">12:30</option>
                            <option value=\"13:00\">13:00</option>
                            <option value=\"13:30\">13:30</option>
                            <option value=\"14:00\">14:00</option>
                            <option value=\"14:30\">14:30</option>
                            <option value=\"15:00\">15:00</option>
                            <option value=\"15:30\">15:30</option>
                            <option value=\"16:00\">16:00</option> <!--
                            <option value=\"16:30\">16:30</option>
                            <option value=\"17:00\">17:00</option>
                            <option value=\"17:30\">17:30</option>
                            <option value=\"18:00\">18:00</option>
                            <option value=\"18:30\">18:30</option>
                            <option value=\"19:00\">19:00</option>
                            <option value=\"19:30\">19:30</option>
                            <option value=\"20:00\">20:00</option>
                            <option value=\"20:30\">20:30</option>
                            <option value=\"21:00\">21:00</option>
                            <option value=\"21:30\">21:30</option>
                            <option value=\"22:00\">22:00</option>
                            <option value=\"22:30\">22:30</option>
                            <option value=\"23:00\">23:00</option> -->
                        </select>
                <br><br><br>
                <label>Deine Nachricht</label>
                <textarea name=\"message\" id=\"message\" class=\"form-control\" rows=\"10\" style=\"width: 96%\"></textarea>
                <label for=\"mailCopy\">Kopie dieser Nachricht an mich senden. &nbsp;
                <input type=\"checkbox\" name=\"mailCopy\" value=\"1\" checked aria-checked=\"true\" id=\"mailCopy\"></label>
                <button type=\"submit\" class=\"btn btn-success\" style=\"margin-top:1%;margin-left: 32%;\" contenteditable=\"false\"><i class=\"fa fa-envelope-o\"></i> &nbsp;Terminvorschlag absenden</button>
                <input type=\"hidden\" name=\"sent\" value=\"1\">
                </div>
                </div>
    </form>";
                return $html;
            } /* EOFunction getTable */

        public function getBackendTable($db, $i, $field, $value)
        {   /** @var $db \YAWK\db */
            global $lang;
            if (isset($field) && isset($value))
            {   // user clicked on email or ip adress
                if (!empty($field) && !empty($value))
                {   // select data
                    $sql = "SELECT * FROM {plugin_booking} WHERE $field = '".$value."' ORDER by $field DESC";
                }
                else
                {   // show default table: all
                    $sql = "SELECT * FROM {plugin_booking} ORDER by date_created DESC $i";
                }
            }
            else
            {   // show default table: all
                $sql = "SELECT * FROM {plugin_booking} ORDER by date_created DESC $i";
            }

            if (!$res = $db->query($sql)) {
                echo "<br><br>";
                print \YAWK\alert::draw("warning", "Fehler:", "Entschuldigung, die Tabelle konnte nicht abgerufen werden. Offenbar liegt ein Datenbankproblem vor.","",3800);
                exit;
            } else {
                /* TABLE HEADER */
                $html = "";
                /* TABLE CONTENT */
                while ($row = mysqli_fetch_assoc($res)) {
                    $this->id = $row['id'];
                    $this->uid = $row['uid'];
                    $this->gid = $row['gid'];
                    $this->date_created = $row['date_created'];
                    $this->date_wish = $row['date_wish'];
                    $this->date_alternative = $row['date_alternative'];
                    $this->confirmed = $row['confirmed'];
                    $this->name = $row['name'];
                    $this->email = $row['email'];
                    $this->phone = $row['phone'];
                    $this->text = $row['text'];
                    $this->todo = $row['todo'];
                    $this->success = $row['success'];
                    $this->grade = $row['grade'];
                    $this->visits = $row['visits'];
                    $this->comment = $row['comment'];
                    $this->ip = $row['ip'];
                    $this->useragent = $row['useragent'];
                    $this->ban = $row['ban'];
                    $this->outdated = $row['outdated'];
                    $this->cut = $row['cut'];
                    $this->invited = $row['invited'];

                    /* date string to array function */
                    $year = date('Y');
                    $splitDate_created = \YAWK\sys::splitDateShort($this->date_created);
                    $splitDate_wish = \YAWK\sys::splitDateShort($this->date_wish);
                    $splitDate_alternative = \YAWK\sys::splitDateShort($this->date_alternative);
                    // date created
                    $year_created = $splitDate_created['year'];
                    $day_created = $splitDate_created['day'];
                    $month_created = $splitDate_created['month'];
                    $time_created = $splitDate_created['time'];
                    // date wish
                    $year_wish = $splitDate_wish['year'];
                    $day_wish = $splitDate_wish['day'];
                    $month_wish = $splitDate_wish['month'];
                    $time_wish = $splitDate_wish['time'];
                    // date alternative
                    $year_alt = $splitDate_alternative['year'];
                    $day_alt = $splitDate_alternative['day'];
                    $month_alt = $splitDate_alternative['month'];
                    $time_alt = $splitDate_alternative['time'];
                    // make dates pretty
                    $prettydate_created = "$day_created.$month_created $year, $time_created";
                    $prettydate_wish = "$day_wish.$month_wish $time_wish";
                    $prettydate_alternative = "$day_alt.$month_alt $time_alt";

                    // if alternative is zero, make it empty for a better tbl view experience
                    if ($prettydate_alternative === "0.00. 00:00"){
                    $prettydate_alternative = '';
                    }
                    // set to_do integer to str
                    if ($this->todo === '0'){
                        $this->todo = '';
                    }
                    if ($this->todo === '1'){
                        $this->todo = "Solo";
                    }
                    if ($this->todo === '2'){
                        $this->todo = "Handjob";
                    }
                    if ($this->todo === '3'){
                        $this->todo = "FFM";
                    }
                    if ($this->todo === '4'){
                        $this->todo = "Quickie";
                    }
                    if ($this->todo === '5'){
                        $this->todo = '';
                    }
                    // check confirmed status
                    if ($this->confirmed === '1') {
                        $pub = "success";
                        $pubtext = "<i class=\"fa fa-check\"> 2 fix</i>";
                    }
                    else {
                        $pub = "warning";
                        $pubtext = "<i class=\"fa fa-times\"> 1 nicht best.</i>";
                    }
                    if ($this->success === '1'){
                        $pub = "info";
                        $pubtext = "<i class=\"fa fa-check-circle-o\" title='erledigt'> 3 erledigt</i>";
                    }
                    if ($this->ban === '1'){
                        $pub = "danger";
                        $pubtext = "<i class=\"fa fa-warning\" title='Vorsicht'> 4 vorsicht!</i>";
                    }
                    if ($this->outdated === '1'){
                        $pub = "inverse";
                        $pubtext = "<i title='Outdated'> 5 outdated</i>";
                        $msgstyle = "style=\"color:#707070;\"";
                    } else { $msgstyle = ""; }
                    // if visits are bigger than zero, change color
                    if ($this->visits > '0') {
                        $color = "text-info";
                        $visitHtml = "<span class=\"label label-success\">$this->visits</span>";
                    } else {
                        $color = "text-muted";
                        $visitHtml = "<span class=\"label label-danger\">$this->visits</span>";
                    }
                    $html .= "<tr>
                    <td class=\"text-center\">
                    <a title=\"toggle&nbsp;status\" href=\"index.php?plugin=booking&pluginpage=booking-toggle&toggle=1&id=" . $this->id . "\">
                    <span class=\"label label-$pub\">$pubtext</span></a></td>
                    <td><small>$prettydate_created</small></td>
                    <td><a href=\"index.php?plugin=booking&pluginpage=booking-edit&id=" . $this->id . "\"><div class=\"$color\">$this->name</a><p class=\"small\">
                    <a href=\"index.php?plugin=booking&pluginpage=booking&email=$this->email\" target=\"_blank\">$this->email</a><br>
                    <a href=\"index.php?plugin=booking&pluginpage=booking&phone=$this->phone\" target=\"_blank\">$this->phone</a></p>
                    </div></td>
                    <td class=\"text-center\">$prettydate_wish<p style=\"color:#707070;\">$prettydate_alternative</p></td>
                    <td class=\"text-center\">$this->todo</td>
                    <td ".$msgstyle.">$this->text</td>
                    <td class=\"text-center\">".self::countVisits($db, $this->email)."</td>
                    <td class=\"text-center\"><a href=\"index.php?plugin=booking&pluginpage=booking&ip=$this->ip\" target=\"_blank\">$this->ip</a></td>
                    <td class=\"text-center\">
                        <a class=\"fa fa-hourglass-end\" title=\"".$lang['OUTDATED']."\" href=\"index.php?plugin=booking&pluginpage=booking-toggle&outdated=1&id=".$this->id."\"></a>&nbsp;
                        <a class=\"fa fa-ban\" title=\"".$lang['BAN']."\" href=\"index.php?plugin=booking&pluginpage=booking-toggle&ban=1&id=".$this->id."\"></a>&nbsp;
                        <a class=\"fa fa-edit\" title=\"" . $lang['EDIT'] . "\" href=\"index.php?plugin=booking&pluginpage=booking-edit&id=" . $this->id . "\"></a>&nbsp;
                        <a class=\"fa fa-trash-o\" role=\"dialog\" data-confirm=\"Den Termin &laquo;" . $this->name . " @ " . $this->date_wish . "&raquo; wirklich l&ouml;schen?\"
                        title=\"" . $lang['DELETE'] . "\" href=\"index.php?plugin=booking&pluginpage=booking-delete&id=" . $this->id . "&delete=1\">
                        </a>
                    </td>
                  </tr>";

                }
                return $html;
            }
        } /* EOFunction getAdminTable */

        function save($db)
        {   /** @var $db \YAWK\db */
            if (!$res = $db->query("UPDATE {plugin_booking} SET
                income = '".$this->income."',
                grade = '".$this->grade."',
                comment = '".$this->comment."',
                date_wish = '".$this->date_wish."',
                date_alternative = '".$this->date_alternative."',
                comment = '".$this->comment."',
                confirmed = '1',
                cut = '".$this->cut."'
                WHERE id = '".$this->id."' "))
            {
                print \YAWK\alert::draw("danger", "Error", "Could not save booking details."."",3800);
            }
            return true;
        }

        function toggleOffline($db, $id, $confirmed, $success)
        {   /** @var $db \YAWK\db */
            // TOGGLE GIG STATUS
            if (!$res = $db->query("UPDATE {plugin_booking}
              SET confirmed = '" . $confirmed . "',
                  success = '".$success."'
              WHERE id = '" . $id . "'"))
            {
                print \YAWK\alert::draw("danger", "Error", "Booking status could not be toggled.","",3800);
            }
            return true;
        } /* EOFunction toggleOffline */


        function loadProperties($db, $id)
        {   /** @var $db \YAWK\db */
            $res = $db->query("SELECT * FROM {plugin_booking} WHERE id = '" . $id . "'");
            if ($row = mysqli_fetch_assoc($res)) {
                $this->id = $row['id'];
                $this->uid = $row['uid'];
                $this->gid = $row['gid'];
                $this->date_created = $row['date_created'];
                $this->date_wish = $row['date_wish'];
                $this->date_alternative = $row['date_alternative'];
                $this->confirmed = $row['confirmed'];
                $this->todo = $row['todo'];
                $this->name = $row['name'];
                $this->email = $row['email'];
                $this->phone = $row['phone'];
                $this->text = $row['text'];
                $this->success = $row['success'];
                $this->income = $row['income'];
                $this->grade = $row['grade'];
                $this->visits = $row['visits'];
                $this->comment = $row['comment'];
                $this->ip = $row['ip'];
                $this->useragent = $row['useragent'];
                $this->ban = $row['ban'];
                $this->outdated = $row['outdated'];
                $this->referer = $row['referer'];
                $this->cut = $row['cut'];
                $this->invited = $row['invited'];
            }
        } /* EOFunction loadProperties */

        static function getMaxId($db)
        {   /** @var $db \YAWK\db */
            $booking = new booking();
            $res = $db->query("SELECT MAX(id) FROM {plugin_booking}");
            if ($row = mysqli_fetch_array($res)) {
                return $booking->maxID = $row[0];
            }
            else
            {
                return false;
            }
        }

        function getProperty($db, $id, $property)
        {   /** @var $db \YAWK\db */
            $res = $db->query("SELECT " . $property . " FROM {plugin_booking}
                        WHERE id = '" . $id . "'");
            if ($row = mysqli_fetch_row($res)) {
                return $row[0];
            }
            else
            {
                return false;
            }
        }

        function delete($db)
        {   /** @var $db \YAWK\db */
            if (!$res = $db->query("DELETE FROM {plugin_booking} WHERE id = '" . $this->id . "'")) {
                print \YAWK\alert::draw("danger", "Error", "Appointment could not be deleted.","",3800);
            }
            return true;
        } /* EOFunction delete */

        function create($db)
        {   /** @var $db \YAWK\db */
            if (!isset($_POST['todo'])){
                $_POST['todo'] = 0;
            }
            // if user is logged in, build booking data from session vars (name, userid, groupid)
            if (isset($_SESSION['username']) && (isset($_SESSION['uid']) && (isset($_SESSION['gid'])))){
                $this->name = $_SESSION['username'];
                $this->uid = $_SESSION['uid'];
                $this->gid = $_SESSION['gid'];
                $this->email = $db->quote($_POST['email']);
                $this->phone = $db->quote($_POST['phone']);
                $this->todo = $db->quote($_POST['todo']);
                if (isset($_POST['datewish-month'])){
                    $this->datewish_month = $db->quote($_POST['datewish-month']);
                }
                else
                {
                    $this->datewish_month = '';
                }
                if (isset($_POST['datewish-day'])){
                    $this->datewish_day = $db->quote($_POST['datewish-day']);
                }
                else
                {
                    $this->datewish_day = '';
                }
                if (isset($_POST['datewish-time'])){
                    $this->datewish_time = $db->quote($_POST['datewish-time']);
                }
                else
                {
                    $this->datewish_time = '';
                }
                if (isset($_POST['alternative-month'])){
                    $this->alternative_month = $db->quote($_POST['alternative-month']);
                }
                else
                {
                    $this->alternative_month = '';
                }
                if (isset($_POST['alternative-day'])){
                    $this->alternative_day = $db->quote($_POST['alternative-day']);
                }
                else
                {
                    $this->alternative_day = '';
                }
                if (isset($_POST['alternative-time'])){
                    $this->alternative_time = $db->quote($_POST['alternative-time']);
                }
                else
                {
                    $this->alternative_time = '';
                }
                $this->message = $db->quote($_POST['message']);
            }
            else {
                // else get the POST vars escaped
                $this->name = $db->quote($_POST['name']);
                $this->email = $db->quote($_POST['email']);
                $this->phone = $db->quote($_POST['phone']);
                $this->todo = $db->quote($_POST['todo']);
                if (isset($_POST['datewish-month'])){
                    $this->datewish_month = $db->quote($_POST['datewish-month']);
                }
                else
                {
                    $this->datewish_month = '';
                }
                if (isset($_POST['datewish-day'])){
                    $this->datewish_day = $db->quote($_POST['datewish-day']);
                }
                else
                {
                    $this->datewish_day = '';
                }
                if (isset($_POST['datewish-time'])){
                    $this->datewish_time = $db->quote($_POST['datewish-time']);
                }
                else
                {
                    $this->datewish_time = '';
                }
                if (isset($_POST['alternative-month'])){
                    $this->alternative_month = $db->quote($_POST['alternative-month']);
                }
                else
                {
                    $this->alternative_month = '';
                }
                if (isset($_POST['alternative-day'])){
                    $this->alternative_day = $db->quote($_POST['alternative-day']);
                }
                else
                {
                    $this->alternative_day = '';
                }
                if (isset($_POST['alternative-time'])){
                    $this->alternative_time = $db->quote($_POST['alternative-time']);
                }
                else
                {
                    $this->alternative_time = '';
                }
                $this->message = $db->quote($_POST['message']);
            }

            /* generate ID manually to prevent id holes    */
            $res_blog = $db->query("SELECT MAX(id) FROM {plugin_booking}");
            $row = mysqli_fetch_row($res_blog);
            if (!isset($row[0])){
                $this->id = 1;
            } else {
                $this->id = $row[0] + 1;
            }
            // switch entities
            $this->name = htmlentities($this->name);
            $this->email = htmlentities($this->email);
            $this->phone = htmlentities($this->phone);
            $this->message = htmlentities($this->message);
            // strip tags
            $this->name = strip_tags($this->name);
            $this->email = strip_tags($this->email);
            $this->phone = strip_tags($this->phone);
            $this->message = strip_tags($this->message);
            // trim tags
            $this->name = trim($this->name);
            $this->email = trim($this->email);
            $this->phone = trim($this->phone);
            $this->message = trim($this->message);

            // nl2br message
            $this->message = nl2br($this->message);

            // set income automatically based on selected todofield

            if ($this->todo === '0'){
                // solo
                $this->income = "nach Vereinbarung";
                $todotext = "nach Vereinbarung";
                $duration = "nach Vereinbarung";
            }
            if ($this->todo === '1'){
                // solo
                $this->income = 160;
                $todotext = "Date zu zweit";
                $duration = "1 Stunde";
            }
            if ($this->todo === '2'){
                // MMF
                $this->income = 100;
                $todotext = "Date zu zweit (Handjob)";
                $duration = "1/2 Stunde";
            }
            if ($this->todo === '3'){
                // FFM
                $this->income = 320;
                $todotext = "Date zu dritt (FFM)";
                $duration = "1 Stunde";
            }
            if ($this->todo === '4'){
               // quickie
                $this->income = 100;
                $todotext = "Date zu zweit (Quickie)";
                $duration = "1/2 Stunde";
            }

            // build datetime string out of form vars
            $year = date('Y');
            $this->date_wish = "$year-$this->datewish_month-$this->datewish_day $this->datewish_time:00";
            $this->date_alternative = "$year-$this->alternative_month-$this->alternative_day $this->alternative_time:00";
            // set current datetime for field "date_created"
            $this->date_created = date("Y-m-d G:i:s");

            // get user data
            $this->ip = $_SERVER['REMOTE_ADDR'];
            $this->useragent = $_SERVER['HTTP_USER_AGENT'];
            $this->referer = $_SERVER['HTTP_REFERER'];

            // insert into db
            $res = $db->query("INSERT INTO {plugin_booking}
                            (id, uid, gid, date_created, date_wish, date_alternative, name, email, phone, text, todo, income, ip, useragent, referer)
	                        VALUES('" . $this->id . "',
	                        '" . $this->uid . "',
	                        '" . $this->gid . "',
	                        '" . $this->date_created . "',
	                        '" . $this->date_wish . "',
	                        '" . $this->date_alternative . "',
	                        '" . $this->name . "',
	                        '" . $this->email . "',
	                        '" . $this->phone . "',
	                        '" . $this->message . "',
	                        '" . $this->todo . "',
	                        '" . $this->income . "',
	                        '" . $this->ip . "',
	                        '" . $this->useragent . "',
	                        '" . $this->referer . "')");

            // prepare email data
            $email_message = "Danke ".$this->name."! Du hast mir am ".$this->date_created." einen Terminvorschlag geschickt!\n
            Ich werde mich so bald als moeglich bei Dir melden!\n\r
             Wunschtermin: ".$this->date_wish."\n
             Alternative : ".$this->date_alternative."\n
             Kosten      : EUR ".$this->income."\n
             Wunsch     : ".$todotext."\n
             Dauer       : ".$duration."\n
             Email       : ".$this->email."\n
             Telefon     : ".$this->phone."\n
             Nachricht   : ".$this->message."\n";

            $adminEmail = \YAWK\settings::getSetting($db, "admin_email");

            if (isset($_POST['mailCopy']) && ($_POST['mailCopy'] == '1')){
                // send email to user AND admin
                $sent_admin = \YAWK\email::sendEmail("$this->email", "$adminEmail", "", "Danke fuer Deinen Terminvorschlag!", "$email_message");
                $sent_user = \YAWK\email::sendEmail("$adminEmail", "$this->email", "", "Danke fuer Deinen Terminvorschlag!", "$email_message");
                $sent = '';
            } else {
                // send email to admin only
                $sent = \YAWK\email::sendEmail("$this->email", "$adminEmail", "", "Du hast einen neuen Terminvorschlag!", "$email_message");
                $sent_admin = '';
                $sent_user = '';
            }

            if ($res && $sent_admin && $sent_user || $sent) {
                \YAWK\alert::draw("success", "Erfolg", "Vielen Dank f�r Deinen Terminvorschlag! Ich werde mich so bald als m&ouml;glich bei Dir melden!","",4200);
            } else {
                \YAWK\alert::draw("warning", "Fehler", "Es tut mir leid, der Terminvorschlag konnte nicht abgeschickt werden! Bitte versuche es sp&auml;ter nochmal. Danke!","",4200);
            }

        }
    }
} /* CLASS booking */