<?php
namespace YAWK\PLUGINS\BOOKING {
    /**
     * <b>Let users submit appointments from frontend. You can view & manage them in backend.</b>
     *
     * The Booking Plugin is a simple but nice, clean frontend form. Users
     * can submit appointments. The entries are managable in the backend.
     * Perfect for any kind of appointment requests. E.g. if you are a Hairdresser
     * your customers can submit their wished dates. If you are a musician, this is perfect
     * to do your bookings. You can manage them in the Backend and view all bookings in a
     * sortable, clean table. You can set the Appointment to "done", rate it, count how many
     * times you've met that user, how many bookings were successful and many, many more.
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
     * appointments from frontend. Entries can be viewed, setup and monitored in the backend.
     */
    class booking
    {
        /** * @var string language */
        public $lang;
        /** * @var string booking day */
        public $day;
        /** * @var string booking month */
        public $month;
        /** * @var string booking time */
        public $time;
        /** * @var string booking ID */
        public $id;
        /** * @var string user ID who booked */
        public $uid;
        /** * @var string group ID */
        public $gid;
        /** * @var string date when the booking was created */
        public $date_created;
        /** * @var int 0|1 is this a confirmed booking? */
        public $date_confirmed;
        /** * @var string booking name */
        public $name;
        /** * @var string booking email address */
        public $email;
        /** * @var string booking phone number */
        public $phone;
        /** * @var string booking text */
        public $text;
        /** * @var int 0|1 was the booking successful? */
        public $success;
        /** * @var int internal voting for this booking (school grades) */
        public $grade;
        /** * @var int how often has this client (email adress) successful booked? */
        public $visits;
        /** * @var string internal comment for this booking (max 255 chars) */
        public $comment;
        /** * @var string IP Address of the user who booked */
        public $ip;
        /** * @var string users hostname  */
        public $hostname;
        /** * @var int how much is this booking worth? */
        public $income;
        /** * @var int 0|1 is this booking confirmed? */
        public $confirmed;
        /** * @var string user booking time */
        public $datewish_time;
        /** * @var string user booking month */
        public $datewish_month;
        /** * @var string user booking day */
        public $datewish_day;
        /** * @var string user booking year */
        public $datewish_year;
        /** * @var string user booking date wish (full) */
        public $date_wish;
        /** * @var string alternative user booking time */
        public $alternative_time;
        /** * @var string alternative user booking month */
        public $alternative_month;
        /** * @var string alternative user booking day */
        public $alternative_day;
        /** * @var string alternative user booking year */
        public $alternative_year;
        /** * @var string alternative user booking date (full) */
        public $date_alternative;
        /** * @var string user booking message */
        public $message;
        /** * @var string the complete useragent */
        public $useragent;
        /** * @var string referer: where did the user came from? (last url) */
        public $referer;
        /** * @var int expected money from outstanding bookings */
        public $outstanding_sum;
        /** * @var int 0|1 is this booking set to outdated? */
        public $outdated;
        /** * @var int 0|1 is this user (email adress) banned? */
        public $ban;
        /** * @var int 0|1 is this user invited? */
        public $invited;

        /**
         * count and return how many successful booking an email adress made
         * @param object $db database
         * @param string $email email adress you wish to check
         * @return int|bool
         */
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

        /**
         * get statistics from all bookings
         * @param object $db database
         */
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
                    if (isset($i_date_success) && (!empty($i_date_success)))
                    {
                        $avgGrade = $grade_sum / $i_date_success;
                    }
                    else
                        {
                            $avgGrade = 0;
                        }
                    $avgGrade = substr("$avgGrade", 0, 3);
                } else { $avgGrade = 0; }


                echo "<ul class='list-group'>
                        <li class='list-group-item'><h4><i class='fa fa-money'></i> &nbsp;outstanding, fixated bookings are worth:&nbsp; <b class='text-green'>&euro; ".$confirmed_outstanding_sum.",-</b></li></h4>
                        <li class='list-group-item'><h4><i class='fa fa-money'></i> &nbsp;new, not confirmed bookings are worth:&nbsp; <b class='text-orange'>&euro; ".$outstanding_sum.",- </b></li></h4>
                        <li class='list-group-item'><h4><i class='fa fa-money'></i> &nbsp;successful earned, total:&nbsp; <b class='text-green'>&euro; ".$income_sum.",- </b></li></h4>
                        <li class='list-group-item'><h4><i class='fa fa-calendar'></i> &nbsp;overall there were <b>".$i_dates."</b> booking inquires. Thereof were <b class='text-green'>".$success_sum."</b> successful bookings. <b class='text-orange'>".$i_date_waiting_sum."</b> are not confirmed, <b class='text-green'>".$i_date_fix_sum."</b> are confirmed. <b>".$i_date_outdated."</b> are outdated.</li></h4>
                        <li class='list-group-item'><h4><i class='fa fa-calendar'></i> &nbsp;the average voting overall bookings and users: <b>".$avgGrade."</b></li></h4>
                      </ul>";

            }
        }

        /**
         * set a booking to banned (to see clearly: nope, we dont want this)
         * this is useful to detect and handle fake bookings, fun bookings, nonsense entries...
         * @param object $db database
         * @param int $id the booking ID to ban
         * @param string $email the email address you wish to ban
         * @return bool
         */
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

        /**
         * toggle a booking to outdated.
         * @param object $db database
         * @param int $id the booking id to toggle
         * @return bool
         */
        function toggleOutdated($db, $id)
        {   /** @var $db \YAWK\db */
            if ($res = $db->query("SELECT outdated FROM {plugin_booking}
                                                  WHERE id = '".$id."'"))
                 if ($row = mysqli_fetch_row($res))
                 {
                     $this->outdated = $row[0];
                 }
            if ($this->outdated === '0') { $this->outdated = 1; } else { $this->outdated = 0; }
            // toggle outdated status
            if (!$res = $db->query("UPDATE {plugin_booking}
              SET outdated = '" . $this->outdated . "'
              WHERE id = '".$id."'"))
            {
                print \YAWK\alert::draw("danger", "Error", "Outdated status could not be toggled.","",2000);
            }
            return true;
        }

        /**
         * if you like, you can invite users to a private member area. allow users to register and become members
         * after they did a successful booking. Whatever you put in your members area (eg. vip club) is on your own.
         * @param object $db database
         * @param int $id booking ID (unused, yet)
         * @param string $email booking email address -> the user you wish to invite
         * @param string $name the name that the user have set in the course of booking.
         * @return bool
         */
        function inviteUser($db, $id, $email, $name)
        {   /** @var $db \YAWK\db */
            // get admin email adress from db
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

        /**
         * draw (output) html of the frontend form. This is displayed to the user. He will use it for booking.
         * @return string
         */
        public function getFrontendForm()
        {
$html = "<form class=\"form\" id=\"form\" method=\"post\" action=\"booking.html\">
        <div class=\"row\">
            <div class=\"col-md-4\">
                <p>How can we contact you?</p>
                <input type=\"text\" name=\"name\" id=\"name\" class=\"form-control\" placeholder=\"Your name\">
                <label for=\"name\"><strong>Name</strong></label>
                <input type=\"text\" name=\"email\" id=\"email\" class=\"form-control\" placeholder=\"you@email.com\">
                <label for=\"email\">Email</label>
                <input type=\"text\" name=\"phone\" id=\"phone\" class=\"form-control\" placeholder=\"+00 1234 / 1234567\">
                <label >Phone Number</label>
<br><br>
            </div>
            <div class=\"col-md-8\">
                <p>Select Date:</p>
                        <select name=\"datewish-month\" class=\"form-control\">
                            <option value=\"00\" selected disabled>- Month -</option>
                            <option value=\"01\">January</option>
                            <option value=\"02\">February</option>
                            <option value=\"03\">March</option>
                            <option value=\"04\">April</option>
                            <option value=\"05\">May</option>
                            <option value=\"06\">June</option>
                            <option value=\"07\">July</option>
                            <option value=\"08\">August</option>
                            <option value=\"09\">September</option>
                            <option value=\"10\">October</option>
                            <option value=\"11\">November</option>
                            <option value=\"12\">December</option>
                        </select>
                        <select name=\"datewish-day\" class=\"form-control\">
                            <option value=\"00\" selected disabled>- Day -</option>
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
                        <select name=\"datewish-time\" class=\"form-control\">
                            <option value=\"00:00\" selected disabled>Time</option>
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
                            <option value=\"16:00\">16:00</option>
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
                            <option value=\"23:00\">23:00</option>
                        </select>
                <br>
                <p>Alternative?</p>
                        <select name=\"alternative-month\" class=\"form-control\">
                            <option value=\"00\" selected disabled>- Month -</option>
                            <option value=\"01\">January</option>
                            <option value=\"02\">February</option>
                            <option value=\"03\">March</option>
                            <option value=\"04\">April</option>
                            <option value=\"05\">May</option>
                            <option value=\"06\">June</option>
                            <option value=\"07\">July</option>
                            <option value=\"08\">August</option>
                            <option value=\"09\">September</option>
                            <option value=\"10\">October</option>
                            <option value=\"11\">November</option>
                            <option value=\"12\">December</option>
                        </select>
                        <select name=\"alternative-day\" class=\"form-control\">
                            <option value=\"00\" selected disabled>- Day -</option>
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
                        <select name=\"alternative-time\" class=\"form-control\">
                            <option value=\"00:00\" selected disabled>Time</option>
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
                            <option value=\"16:00\">16:00</option>
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
                            <option value=\"23:00\">23:00</option>
                        </select>
                <br>
                <label>Your Message</label>
                <textarea name=\"message\" id=\"message\" class=\"form-control\" rows=\"10\"></textarea>
                <label for=\"mailCopy\">Send a copy of this message to myself. &nbsp;
                <input type=\"checkbox\" name=\"mailCopy\" value=\"1\" checked aria-checked=\"true\" id=\"mailCopy\"></label>
                <button type=\"submit\" class=\"btn btn-success pull-right\" style=\"margin-top:1%;\" contenteditable=\"false\"><i class=\"fa fa-envelope-o\"></i> &nbsp;Send Message</button>
                <input type=\"hidden\" name=\"sent\" value=\"1\">
                </div>
                </div>
    </form>";
                return $html;
            } /* EOFunction getTable */

        /**
         * get data and draw (output) html backend table of all bookings
         * @param object $db database
         * @param int $i sql limitation number
         * @param string $field database field
         * @param string $value value to get
         * @return string
         */
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
                print \YAWK\alert::draw("warning", "Could not get booking table data...", "Seems like there is a problem with the database.","",3800);
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
                    // check confirmed status
                    if ($this->confirmed === '1') {
                        $pub = "success";
                        $pubtext = "<i class=\"fa fa-check\"> 2 confirmed</i>";
                    }
                    else {
                        $pub = "warning";
                        $pubtext = "<i class=\"fa fa-times\"> 1 not confirmed</i>";
                    }
                    if ($this->success === '1'){
                        $pub = "info";
                        $pubtext = "<i class=\"fa fa-check-circle-o\" title='erledigt'> 3 successful</i>";
                    }
                    if ($this->ban === '1'){
                        $pub = "danger";
                        $pubtext = "<i class=\"fa fa-warning\" title='careful'> 4 careful!</i>";
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

        /**
         * save (update) booking data
         * @param object $db database
         * @return bool
         */
        function save($db)
        {   /** @var $db \YAWK\db */
            if (!$res = $db->query("UPDATE {plugin_booking} SET
                income = '".$this->income."',
                grade = '".$this->grade."',
                comment = '".$this->comment."',
                date_wish = '".$this->date_wish."',
                date_alternative = '".$this->date_alternative."',
                comment = '".$this->comment."',
                confirmed = '1'
                WHERE id = '".$this->id."' "))
            {
                print \YAWK\alert::draw("danger", "Error", "Unable to save booking details.", "",3800);
            }
            return true;
        }

        /**
         * toggle a booking online or offline
         * @param object $db database
         * @param int $id booking ID to toggle
         * @param int $confirmed 0|1 confirmed status
         * @param int $success 0|1 success status
         * @return bool
         */
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


        /**
         * load booking data into object properties
         * @param object $db database
         * @param string $id the booking id to load
         */
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

        /**
         * get highest ID from booking table
         * @param object $db database
         * @return string|bool the max ID or false
         */
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

        /**
         * return any booking property
         * @param object $db database
         * @param int $id affected booking ID
         * @param string $property the property to get
         * @return string|bool the selected booking property or false
         */
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


        /**
         * delete a single booking
         * @param object $db database
         * @return bool
         */
        function delete($db)
        {   /** @var $db \YAWK\db */
            if (!$res = $db->query("DELETE FROM {plugin_booking} WHERE id = '" . $this->id . "'")) {
                print \YAWK\alert::draw("danger", "Error", "Appointment could not be deleted.","",3800);
            }
            return true;
        } /* EOFunction delete */


        /**
         * create a new booking
         * @param object $db database
         */
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
                            (id, uid, gid, date_created, date_wish, date_alternative, name, email, phone, text, ip, useragent, referer)
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
	                        '" . $this->ip . "',
	                        '" . $this->useragent . "',
	                        '" . $this->referer . "')");

            // prepare email data
            $email_message = "Danke ".$this->name."! Du hast mir am ".$this->date_created." einen Terminvorschlag geschickt!\n
            Ich werde mich so bald als moeglich bei Dir melden!\n\r
             Wunschtermin: ".$this->date_wish."\n
             Alternative : ".$this->date_alternative."\n
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