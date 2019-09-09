<?php
namespace YAWK\WIDGETS\BOOKING\FORM
{
    /**
     * <b>Booking Widget of Booking Plugin.</b>
     *
     * <p>The widget allows you to embed a booking form onto any page and position you need.
     * It is useful to collect bookings from your users. For further information see description
     * of the booking plugin.</p>
     *
     * @package    YAWK
     * @author     Daniel Retzl <danielretzl@gmail.com>
     * @copyright  2019 Daniel Retzl
     * @license    https://opensource.org/licenses/MIT
     * @version    1.0.0
     * @link       http://yawk.io
     * @annotation Embed booking plugin on your pages.
     */
    class bookingWidget
    {
        // BASIC WIDGET SETTINGS
        /** @var object global widget object data */
        public $widget = '';
        /** @var array Form Settings */
        public $formSettings = '';
        /** @var string Headline HTML Markup */
        public $bookingHeadline = '';

        // FORM SETTINGS
        /** @var string Heading */
        public $bookingHeading = '';
        /** @var string Subtext */
        public $bookingSubtext = '';
        /** @var string Headline Prepend Icon */
        public $bookingIcon = '';

        // FORM FIELDS (required[visible, mandatory] | true[visible, not mandatory] | false[invisible, not mandatory])
        /** @var string Booking Band Select Field required|true|false */
        public $bookingBand = '';
        /** @var string Event Date + Time required|true|false */
        public $bookingEventDatetime = '';
        /** @var string Soundcheck Time required|true|false*/
        public $bookingEventSoundcheck = '';
        /** @var string Showtime required|true|false*/
        public $bookingEventShowtime = '';
        /** @var string How long is the soundcheck time? required|true|false */
        public $bookingSoundcheckDuration = '';
        /** @var string How long is the showtime? required|true|false */
        public $bookingShowtimeDuration = '';
        /** @var string Booking Location (indoor / outdoor) required|true|false */
        public $bookingLocation = '';
        /** @var string Booking Location Type (party / wedding / private society) required|true|false */
        public $bookingLocationType = '';
        /** @var string How many people are invited? required|true|false */
        public $bookingCrowdAmount = '';
        /** @var string PA available? required|true|false */
        public $bookingPaAvailable = '';
        /** @var string Tech guy available? required|true|false */
        public $bookingTechAvailable = '';
        /** @var string Overnight possible? required|true|false */
        public $bookingHotelAvailable = '';
        /** @var string message / note required|true|false */
        public $bookingMessage = '';
        /** @var string email required|true|false */
        public $bookingEmail = '';
        /** @var string contact name required|true|false */
        public $bookingContactName = '';
        /** @var string contact phone number required|true|false */
        public $bookingPhone = '';
        /** @var string how many sets should be played? required|true|false */
        public $bookingSetAmount = '';
        /** @var string admin email address where booking will be sent to */
        public $bookingAdminEmail = '';
        /** @var string html email true|false */
        public $bookingHtmlEmail = '';


        /**
         * Load all widget settings from database and fill object
         * @author Daniel Retzl <danielretzl@gmail.com>
         * @version 1.0.0
         * @link http://yawk.io
         * @param object $db Database Object
         * @annotation Load all widget settings on object init.
         */
        public function __construct($db)
        {
            // load this widget settings from db
            $this->widget = new \YAWK\widget();
            $settings = $this->widget->getWidgetSettingsArray($db);
            foreach ($settings as $property => $value) {
                $this->$property = $value;
            }
        }

        /**
         * Print all object data
         * @author Daniel Retzl <danielretzl@gmail.com>
         * @version 1.0.0
         * @link http://yawk.io
         * @annotation (for development and testing purpose)
         */
        public function printObject()
        {
            echo "<pre>";
            print_r($this);
            echo "</pre>";
        }

        /**
         * Set widget properties from database and fill object params
         * @author Daniel Retzl <danielretzl@gmail.com>
         * @version 1.0.0
         * @link http://yawk.io
         * @annotation Load all widget settings.
         */
        public function setProperties()
        {
            // if a heading is set and not empty
            if (isset($this->bookingHeading) && (!empty($this->bookingHeading)))
            {
                // check if booking icon is set
                if (isset($this->bookingIcon) && (!empty($this->bookingIcon)))
                {   // add booking icon markup
                    $this->bookingIcon = "<i class=\"".$this->bookingIcon."\"></i>&nbsp;";
                }

                // if subtext is set, add <small> subtext to string
                if (isset($this->bookingSubtext) && (!empty($this->bookingSubtext)))
                {   // build a headline with heading and subtext
                    $this->bookingSubtext = "<small>$this->bookingSubtext</small>";
                    $this->bookingHeadline = "<div id=\"bookingHeading\" class=\"animated fadeIn speed2\"><h1>&nbsp;$this->bookingIcon"."$this->bookingHeading&nbsp;"."$this->bookingSubtext</h1></div>";
                }
                else
                {   // headline only - without subtext
                    $this->bookingHeadline = "<h1 class=\"animated fadeIn speed2\">$this->bookingHeading</h1>";    // draw just the heading
                }
            }
            else
            {   // leave empty if it's not set
                $this->bookingHeadline = '';
            }
        }

        /**
         * Embed any BubblUs mindmaps
         * @author Daniel Retzl <danielretzl@gmail.com>
         * @version 1.0.0
         * @link http://yawk.io
         * @annotation This method does the setup and embed job
         * @param object $db db object
         */
        public function init($db)
        {   /** @var \YAWK\db */

            // set widget obj properties
            $this->setProperties();

            // init JS code variable
            $validateJsCode = "";

            // check required fields and set validate JS code
            // name field
            if ($this->bookingContactName === "required")
            {
                $validateJsCode .= "
                            name: {
                            required: true,
                            minlength: 3
                            },";
            }
            else
                {
                    $validateJsCode .= "
                            name: {
                            required: false,
                            minlength: 3
                            },";
                }

            // email field
            if ($this->bookingEmail === "required")
            {
                $validateJsCode .= "
                            email: {
                            required: true,
                            email: true,
                            maxlength: 128
                            },";
            }
            else
                {
                    $validateJsCode .= "
                            email: {
                            required: false,
                            email: true,
                            maxlength: 128
                            },";
                }

            // phone field
            if ($this->bookingPhone === "required")
            {   $validateJsCode .= "
                            phone: {
                            required: true,
                            },";
            }

            // band select field
            if ($this->bookingBand === "required")
            {   $validateJsCode .= "
                            band: {
                            required: true,
                            },";
            }

            // event date + time
            if ($this->bookingEventDatetime === "required")
            {   $validateJsCode .= "
                            eventDateTime: {
                            required: true,
                            },";
            }

            // soundcheck time
            if ($this->bookingEventSoundcheck === "required")
            {   $validateJsCode .= "
                            eventSoundcheck: {
                            required: true,
                            },";
            }

            // showtime
            if ($this->bookingEventShowtime === "required")
            {   $validateJsCode .= "
                            eventShowtime: {
                            required: true,
                            },";
            }

            // soundcheck duration
            if ($this->bookingSoundcheckDuration === "required")
            {   $validateJsCode .= "
                            soundcheckDuration: {
                            required: true,
                            },";
            }

            // showtime duration
            if ($this->bookingShowtimeDuration === "required")
            {   $validateJsCode .= "
                            showtimeDuration: {
                            required: true,
                            },";
            }

            // location (indoor / outdoor)
            if ($this->bookingLocation === "required")
            {   $validateJsCode .= "
                            location: {
                            required: true,
                            },";
            }

            // location type (birthday, wedding, company event...)
            if ($this->bookingLocationType === "required")
            {   $validateJsCode .= "
                            locationType: {
                            required: true,
                            },";
            }

            // crowd amount (estimated)
            if ($this->bookingCrowdAmount === "required")
            {   $validateJsCode .= "
                            crowdAmount: {
                            required: true,
                            },";
            }

            // PA available?
            if ($this->bookingPaAvailable === "required")
            {   $validateJsCode .= "
                            paAvailable: {
                            required: true,
                            },";
            }

            // tech available?
            if ($this->bookingTechAvailable === "required")
            {   $validateJsCode .= "
                            techAvailable: {
                            required: true,
                            },";
            }

            // hotel / overnight
            if ($this->bookingHotelAvailable === "required")
            {   $validateJsCode .= "
                            hotelAvailable: {
                            required: true,
                            },";
            }

            // message / note
            if ($this->bookingMessage === "required")
            {   $validateJsCode .= "
                            message: {
                            required: true,
                            },";
            }

            // set amount (how many sets should be played)
            if ($this->bookingSetAmount === "required")
            {   $validateJsCode .= "
                            setAmount: {
                            required: true,
                            },";
            }


            // embed required javascripts
            echo "
            <!-- bootstrap date-timepicker -->
            <link type=\"text/css\" href=\"system/engines/datetimepicker/css/bootstrap-datetimepicker.min.css\" rel=\"stylesheet\">
            <script src=\"https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js\"></script>
            <script src=\"https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/locale/de.js\"></script>
            <script type=\"text/javascript\" src=\"system/engines/datetimepicker/js/bootstrap-datetimepicker.min.js\"></script>

            <script type=\"text/javascript\" src=\"system/engines/jquery/jquery.validate.min.js\"></script>
            <script type=\"text/javascript\" src=\"system/engines/jquery/messages_de.min.js\"></script>";

            // echo "<script type=\"text/javascript\" src=\"system/widgets/booking/js/booking.js\"></script>";
            echo "
<link rel=\"stylesheet\" href=\"system/engines/jquery/timepicker/jquery.timepicker.css\">
<script src=\"//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js\"></script>";

            echo "            
            <script type=\"text/javascript\">
                $(document).ready(function () {
                
                var bookingForm = $('#bookingForm');
                (bookingForm).validate({ 
                    // initialize the plugin
                        rules: {
                            $validateJsCode
                        },
                    submitHandler: function(){
                        //var data = $(form).serialize();
                        //do your ajax with the data here
                        
                        var type = 'POST';
                        var url = 'system/widgets/booking/js/process-booking-data.php';
                        var thankYouMessage = $('#thankYouMessage');
                    
                        $.ajax({
                            type: type,
                            url: url,
                            data: bookingForm.serialize(), // serializes the form's elements.
                            success: function(data)
                            {
                                // hide form
                                $(bookingForm).hide();
                                // display thank you message
                                thankYouMessage.removeClass('hidden d-none').addClass('animated fadeIn speed6');
                            },
                            error: function (request, status, error)
                            {
                                // error output
                                alert('error: '+data);
                                console.log('ERROR: ajax post failed with error '+data);
                    
                                // shake form
                                $(bookingForm).shake();
                            }
                        });
                    }
                 });
                    
                    $('#eventDateTime').datetimepicker({
                        format: 'YYYY-DD-MM HH:mm',
                        locale: 'de'  
                    });
                    
                    $('.timepicker').timepicker({
                    timeFormat: 'HH:mm',
                    interval: 30,
                    startTime: '18:00',
                    dynamic: false,
                    dropdown: true,
                    scrollbar: false
                });
                });
            </script>";

            // draw headline, if set
            echo "$this->bookingHeadline<hr>";

            // draw booking form
            echo $this->drawFrontendForm();

            // draw thank you message div (hidden until submit)
            echo $this->drawThankYouMessage();
        }

        /**
         * draw (output) thank you message
         * (will be displayed after successful submit)
         * @return string html code
         */
        public function drawThankYouMessage()
        {
            if (!isset($db))
            {
                $db = new \YAWK\db();
            }
            $hostname = \YAWK\settings::getSetting($db, "host");
            $html = "";
            $html .= "
            <div class=\"hidden d-none\" id=\"thankYouMessage\">
            <div class=\"col-md-2\">&nbsp;</div>
            <div class=\"col-md-8 text-center\"><h2>Danke f&uuml;r Ihre Buchungsanfrage!<br>
            <small>Ihre Anfrage wird so schnell als m&ouml;glich bearbeitet.</small><br><br>
            <i class=\"fa fa-handshake-o text-muted\"></i></h2>
            <br><hr><a href=\"".$hostname."\" target=\"_self\">Zur Startseite</a> 
            | <a href=\"booking.html\" target=\"_self\">Weitere Buchung</a></div>
            <div class=\"col-md-2\">&nbsp;</div>
            </div>
            ";
            // return html data
            return $html;
        }

        /**
         * draw (output) html of the frontend form. This is displayed to the user. He will use to place a booking
         * @return string
         */
        public function drawFrontendForm()
        {
            // init form html code markup variable
            $html = "";

            $html .= "
<form class=\"form\" id=\"bookingForm\" method=\"post\" action=\"\">

<!-- <div class=\"container-fluid\"> -->
<div class=\"row\">

    <div class=\"col-md-4 animated fadeIn speed3\">
    <input type=\"hidden\" name=\"bookingAdminEmail\" id=\"bookingAdminEmail\" value=\"".$this->bookingAdminEmail."\">
    <input type=\"hidden\" name=\"bookingHtmlEmail\" id=\"bookingHtmlEmail\" value=\"".$this->bookingHtmlEmail."\">";

            // NAME
            if ($this->bookingContactName !== "false")
            {
                if ($this->bookingContactName === "required")
                { $requiredMarkup = "*"; }
                else { $requiredMarkup = ""; }

                $html .= "
                <label for=\"name\">Name".$requiredMarkup."
                    <i class=\"fa fa-question-circle-o text-info\" data-placement=\"auto right\" data-toggle=\"tooltip\" title=\"Ihr Name (bzw. der Veranstalter)\"></i>
                </label>
                <input type=\"text\" name=\"name\" id=\"name\" class=\"form-control\" placeholder=\"Name / Veranstalter\" autocomplete=\"off\">
                <br>";
            }

            // EMAIL
            if ($this->bookingEmail !== "false")
            {
                if ($this->bookingEmail === "required")
                { $requiredMarkup = "*"; }
                else { $requiredMarkup = ""; }

                $html .= "
            <label for=\"email\">Email".$requiredMarkup."
                <i class=\"fa fa-question-circle-o text-info\" data-placement=\"auto right\" data-toggle=\"tooltip\" title=\"Bitte geben Sie hier Ihre Emailadresse ein. Sie wird nicht weitergegeben und nur f&uuml;r Fragen zu Ihrer Buchung verwendet.\"></i>
            </label>
            <input type=\"text\" name=\"email\" id=\"email\" class=\"form-control\" placeholder=\"you@email.com\" autocomplete=\"off\">
            <br>";
            }

            // PHONE
            if ($this->bookingPhone !== "false")
            {
                if ($this->bookingPhone === "required")
                { $requiredMarkup = "*"; }
                else { $requiredMarkup = ""; }

                $html .= "
        <label for=\"phone\">Phone".$requiredMarkup."
            <i class=\"fa fa-question-circle-o text-info\" data-placement=\"auto right\" data-toggle=\"tooltip\" title=\"Durchs reden kommen die Leut' zam - ein kurzes Telefonat ist oft effizienter als zahllose Emails zu senden. F&uuml;r R&uuml;ckfragen und Absprachen im Vorfeld ben&ouml;tigen wir Ihre Telefonnumer.\"></i>
        </label>
        <input type=\"text\" name=\"phone\" id=\"phone\" class=\"form-control\" placeholder=\"+43 123 1234567\" autocomplete=\"off\">
        <br>
        <div class=\"animated fadeIn speed4 delay-10s\">
            <h3>Booking - Ablauf<br></h3>
            <h4>1. Formular ausf&uuml;llen</h4>
                <p>Bitte f&uuml;llen Sie das Formular so umfangreich als m&ouml;glich aus.
                Je mehr Daten Sie bereits im Vorfeld &uuml;bermitteln, umso konkreter kann 
                auf Ihre Anfrage reagiert werden.</p>
            <h4>2. Emailbest&auml;tigung</h4>
                <p>Nach dem Absenden erhalten Sie eine automatische Best&uml;tigung,
                falls Sie das entsprechende H&auml;kchen nicht entfernt haben.</p>
            <h4>3. Wir melden uns bei Ihnen</h4>
                <p>Jede Booking Anfrage wird so schnell als m&ouml;glich bearbeitet.
                Wir checken unsere Terminkalender und pr&uuml;fen, ob ein Konzert an
                dem von Ihnen gew&uuml;nschten Zeitraum m&ouml;glich ist. Sie erhalten 
                innerhalb von 3 Tagen R&uuml;ckmeldung. Ihre Anfrage ist unverbindlich!</p>
        </div>";

            }
            $html .= "
<br><br>
     </div>
            <div class=\"col-md-8 animated fadeIn speed4 delay-6s\">
            <div class=\"row\">
            <div class=\"col-md-5\">
            <!-- left -->";

            // EVENT DATE TIME
            if ($this->bookingEventDatetime !== "false")
            {
                if ($this->bookingEventDatetime === "required")
                { $requiredMarkup = "*"; }
                else { $requiredMarkup = ""; }

                $html .= "
                    <label for=\"eventDateTime\">Veranstaltungszeitpunkt".$requiredMarkup."
                        <i class=\"fa fa-question-circle-o text-info\" data-placement=\"auto right\" data-toggle=\"tooltip\" title=\"Bitte geben Sie hier das Datum und die Uhrzeit der Veranstaltung ein.\"></i>
                    </label>
                    <input type=\"text\" name=\"eventDateTime\" autocomplete=\"off\" id=\"eventDateTime\" class=\"form-control\" placeholder=\"Datum und Uhrzeit\">
                    <br>";
            }

            // SHOWTIME Duration
            if ($this->bookingShowtimeDuration !== "false")
            {
                if ($this->bookingShowtimeDuration === "required")
                { $requiredMarkup = "*"; }
                else { $requiredMarkup = ""; }

                $html .= "
                    <label for=\"showtimeDuration\">Showtime Zeitrahmen".$requiredMarkup."
                        <i class=\"fa fa-question-circle-o text-info\" data-placement=\"auto right\" data-toggle=\"tooltip\" title=\"Bitte geben Sie hier an, welcher Zeitrahmen (Gesamtspieldauer) f&uuml;r das Konzert vorgesehen ist.\"></i>
                    </label>
                    <select name=\"showtimeDuration\" id=\"showtimeDuration\" class=\"form-control\">
                    <option value=\"\">bitte ausw&auml;hlen</option>
                    <option value=\"30 Minuten\">30 Minuten</option>
                    <option value=\"45 Minuten\">45 Minuten</option>
                    <option value=\"1 Stunde \">1 Stunde</option>
                    <option value=\"1,5 Stunden\">1,5 Stunden</option>
                    <option value=\"2 Stunden\">2 Stunden</option>
                    <option value=\"3 Stunden\">3 Stunden</option>
                    <option value=\"4 Stunden\">4 Stunden</option>
                    <option value=\"keine Angabe - nach Vereinbarung\">keine Angabe / nach Vereinbarung</option>
                    </select><br>";
            }

            // SOUNDCHECK TIME
            if ($this->bookingEventSoundcheck !== "false")
            {
                if ($this->bookingEventSoundcheck === "required")
                { $requiredMarkup = "*"; }
                else { $requiredMarkup = ""; }

                $html .= "
                    <label for=\"eventSoundcheck\">Soundcheck Uhrzeit".$requiredMarkup."
                        <i class=\"fa fa-question-circle-o text-info\" data-placement=\"auto right\" data-toggle=\"tooltip\" title=\"Bitte geben Sie hier an, zu welcher Uhrzeit der Soundcheck durchgef&uuml;hrt werden kann.\"></i>
                    </label>
                    <input type=\"text\" name=\"eventSoundcheck\" autocomplete=\"off\" id=\"eventSoundcheck\" class=\"form-control timepicker\" placeholder=\"Uhrzeit ausw&auml;hlen\">
                    <br>";
            }

            // SOUNDCHECK Duration
            if ($this->bookingSoundcheckDuration !== "false")
            {
                if ($this->bookingSoundcheckDuration === "required")
                { $requiredMarkup = "*"; }
                else { $requiredMarkup = ""; }

                $html .= "
                    <label for=\"soundcheckDuration\">Soundcheck Zeitrahmen".$requiredMarkup."
                        <i class=\"fa fa-question-circle-o text-info\" data-placement=\"auto right\" data-toggle=\"tooltip\" title=\"Bitte geben Sie hier an, welcher Zeitrahmen f&uuml;r den Soundcheck vorgesehen ist.\"></i>
                    </label>
                    <select name=\"soundcheckDuration\" id=\"soundcheckDuration\" class=\"form-control\">
                    <option value=\"\">bitte ausw&auml;hlen</option>
                    <option value=\"30 Minuten\">30 Minuten</option>
                    <option value=\"45 Minuten\">45 Minuten</option>
                    <option value=\"60 Minuten\">60 Minuten</option>
                    <option value=\"keine Angabe - nach Vereinbarung\">keine Angabe / nach Vereinbarung</option>
                    </select>
                    <br>";
            }

            // SHOWTIME Time
            if ($this->bookingEventShowtime !== "false")
            {
                if ($this->bookingEventShowtime === "required")
                { $requiredMarkup = "*"; }
                else { $requiredMarkup = ""; }

                $html .= "
                    <label for=\"eventShowtime\">Showtime Uhrzeit".$requiredMarkup."
                        <i class=\"fa fa-question-circle-o text-info\" data-placement=\"auto right\" data-toggle=\"tooltip\" title=\"Bitte geben Sie hier an, f&uuml;r welche Uhrzeit die Show (Beginn) angesetzt ist.\"></i>
                    </label>
                    <input type=\"text\" name=\"eventShowtime\" autocomplete=\"off\" id=\"eventShowtime\" class=\"form-control timepicker\" placeholder=\"Uhrzeit ausw&auml;hlen\">
                    <br>";
            }

            // SET AMOUNT
            if ($this->bookingSetAmount !== "false")
            {
                if ($this->bookingSetAmount === "required")
                { $requiredMarkup = "*"; }
                else { $requiredMarkup = ""; }

                $html .= "
                    <label for=\"setAmount\">Anzahl Sets".$requiredMarkup."
                        <i class=\"fa fa-question-circle-o text-info\" data-placement=\"auto right\" data-toggle=\"tooltip\" title=\"Bitte geben Sie hier an, wie viele Sets gespielt werden sollen.\"></i>
                    </label>
                    <select name=\"setAmount\" id=\"setAmount\" class=\"form-control\">
                    <option value=\"\">bitte ausw&auml;hlen</option>
                    <option value=\"1\">1</option>
                    <option value=\"2\">2</option>
                    <option value=\"3\">3</option>
                    <option value=\"4\">4</option>
                    <option value=\"keine Angabe - nach Vereinbarung\">keine Angabe / Nach Vereinbarung</option>
                    </select>";
            }

            $html .= "</div>
                <div class=\"col-md-7 animated fadeIn speed4 delay-8s\">
                <!-- right -->";

            // BAND SELECT FIELD
            if ($this->bookingBand !== "false")
            {
                if ($this->bookingBand === "required")
                { $requiredMarkup = "*"; }
                else { $requiredMarkup = ""; }

                $html .= "
                        <label for=\"band\">Band".$requiredMarkup."
                            <i class=\"fa fa-question-circle-o text-info\" data-placement=\"auto right\" data-toggle=\"tooltip\" title=\"Bitte geben Sie hier an, welche Band sie buchen m&ouml;chten.\"></i>
                        </label>
                        <select name=\"band\" id=\"band\" class=\"form-control\">
                        <option value=\"\">bitte ausw&auml;hlen</option>
                        <option value=\"Duo: Stephan Heiner &amp; B&ouml;rns Funkyfingers\">Duo: Stephan Heiner &amp; B&ouml;rns Funkyfingers</option>
                        <option value=\"Trio: BSB (B&ouml;rns, Stephan, Bertl)\">Trio: BSB (B&ouml;rns, Stephan, Bertl)</option>
                        <option value=\"Tommy Lee &amp; Glacestrizzis\">Tommy Lee &amp; Glacestrizzis</option>
                        <option value=\"WiR &amp; Jetzt\">WiR &amp; Jetzt</option>
                        <option value=\"keine Angabe / nach Vereinbarung\">keine Angabe / nach Vereinbarung</option>
                        </select>
                        <br>";
            }

            // EVENT TYPE
            if ($this->bookingLocationType !== "false")
            {
                if ($this->bookingLocationType === "required")
                { $requiredMarkup = "*"; }
                else { $requiredMarkup = ""; }

                $html .= "
                        <label for=\"locationType\">Art der Veranstaltung".$requiredMarkup."
                            <i class=\"fa fa-question-circle-o text-info\" data-placement=\"auto right\" data-toggle=\"tooltip\" title=\"Bitte w&auml;hlen Sie, um welche Art von Veranstaltung es sich handelt.\"></i>
                        </label>
                        <select name=\"locationType\" id=\"locationType\" class=\"form-control\">
                        <option value=\"\">bitte ausw&auml;hlen</option>
                        <option value=\"Private Veranstaltung\">Private Veranstaltung</option>
                        <option value=\"Firmen Veranstaltung\">Firmen Event</option>
                        <option value=\"Hochzeit\">Hochzeit</option>
                        <option value=\"Gro&szlig;veranstaltung\">Gro&szlig;veranstaltung</option>
                        <option value=\"keine Angabe / nach Vereinbarung\">keine Angabe / nach Vereinbarung</option>
                        </select>
                        <br>";
            }

            // LOCATION
            if ($this->bookingLocation !== "false")
            {
                if ($this->bookingLocation === "required")
                { $requiredMarkup = "*"; }
                else { $requiredMarkup = ""; }

                $html .= "
                        <label for=\"location\">Location".$requiredMarkup."
                            <i class=\"fa fa-question-circle-o text-info\" data-placement=\"auto right\" data-toggle=\"tooltip\" title=\"Bitte w&auml;hlen Sie, ob die Veranstaltung drinnen (Indoor) oder draussen (Outdoor) stattfindet.\"></i>
                        </label>
                        <select name=\"location\" id=\"location\" class=\"form-control\">
                        <option value=\"\">bitte ausw&auml;hlen</option>
                        <option value=\"Indoor\">Indoor</option>
                        <option value=\"Outdoor\">Outdoor</option>
                        <option value=\"keine Angabe / nach Vereinbarung\">keine Angabe / nach Vereinbarung</option>
                        </select>
                        <br>";
            }

            // SIZE (CROWD AMOUNT)
            if ($this->bookingCrowdAmount !== "false")
            {
                if ($this->bookingCrowdAmount === "required")
                { $requiredMarkup = "*"; }
                else { $requiredMarkup = ""; }

                $html .= "
                        <label for=\"crowdAmount\">Gr&ouml;&szlig;e".$requiredMarkup."
                            <i class=\"fa fa-question-circle-o text-info\" data-placement=\"auto right\" data-toggle=\"tooltip\" title=\"Wie gro&szlig; ist Ihre Veranstaltung? (Wie viele Menschen werden sch&auml;tzungsweise erwartet?) Diese Information ist wichtig f&uuml;r uns, um unser Equipment entsprechend abzustimmen.\"></i>
                        </label>
                        <select name=\"crowdAmount\" id=\"crowdAmount\" class=\"form-control\">
                        <option value=\"\">bitte ausw&auml;hlen</option>
                        <option value=\"0 - 50\">0 - 50 Personen</option>
                        <option value=\"50 - 100\">50 - 100 Personen</option>
                        <option value=\"100 - 200\">100 - 200 Personen</option>
                        <option value=\"300 - 500\">300 - 500 Personen</option>
                        <option value=\"500 - 1000\">500 - 1000 Personen</option>
                        <option value=\"> 1000\">> 1000 Personen</option>
                        </select>
                        <br>";
            }

            // PA AVAILABLE
            if ($this->bookingPaAvailable !== "false")
            {
                if ($this->bookingPaAvailable === "required")
                { $requiredMarkup = "*"; }
                else { $requiredMarkup = ""; }

                $html .= "
                        <div class=\"text-right\">
                        &nbsp;&nbsp;<i class=\"fa fa-question-circle-o text-info\" data-placement=\"auto right\" data-toggle=\"tooltip\" title=\"Bitte geben Sie an, ob eine entsprechende Ton- und Lichtanlage (PA / Beschallung, B&uuml;hnenmonitoring, Mischpult, Verkabelung) vorhanden ist, oder von uns mitgebracht werden soll.\"></i>
                        <label for=\"paAvailable\">Anlage vorhanden".$requiredMarkup."&nbsp;&nbsp;</label>
                        <input type=\"radio\" name=\"paAvailable\" value=\"Ja\"> Ja
                        &nbsp;&nbsp;<input type=\"radio\" name=\"paAvailable\" value=\"Nein\"> Nein
                        </div><hr>";
            }

            // Tech AVAILABLE
            if ($this->bookingTechAvailable !== "false")
            {
                if ($this->bookingTechAvailable === "required")
                { $requiredMarkup = "*"; }
                else { $requiredMarkup = ""; }

                $html .= "                        
                        <div class=\"text-right\">
                        &nbsp;&nbsp;<i class=\"fa fa-question-circle-o text-info\" data-placement=\"auto right\" data-toggle=\"tooltip\" title=\"Bitte geben Sie an, ob eine fachlich kompetenter Tontechniker vor Ort ist, der die Veranstaltung (inkl. Soundcheck) tontechnisch betreut oder ob ein Tontechniker von uns eingesetzt werden soll.\"></i>
                        <label for=\"techAvailable\">Techniker vor Ort".$requiredMarkup."&nbsp;&nbsp;</label>
                        <input type=\"radio\" name=\"techAvailable\" value=\"Ja\"> Ja
                        &nbsp;&nbsp;<input type=\"radio\" name=\"techAvailable\" value=\"Nein\"> Nein
                        </div><hr>";
            }

            // Hotel AVAILABLE
            if ($this->bookingHotelAvailable !== "false")
            {
                if ($this->bookingHotelAvailable === "required")
                { $requiredMarkup = "*"; }
                else { $requiredMarkup = ""; }

                $html .= "
                        <div class=\"text-right\">
                        &nbsp;&nbsp;<i class=\"fa fa-question-circle-o text-info\" data-placement=\"auto right\" data-toggle=\"tooltip\" title=\"Bitte geben Sie an, ob eine &Uuml;bernachtung m&ouml;glich ist (bei Veranstaltungen die sich &uuml;ber mehrere Tage erstrecken)\"></i>
                        <label for=\"hotelAvailable\">&Uuml;bernachtung".$requiredMarkup."&nbsp;&nbsp;</label>
                        <input type=\"radio\" name=\"hotelAvailable\" value=\"Ja\"> Ja
                        &nbsp;&nbsp;<input type=\"radio\" name=\"hotelAvailable\" value=\"Nein\"> Nein
                        </div>";
            }

            $html .="</div>
                </div>";

            // MESSAGE
            if ($this->bookingMessage !== "false")
            {
                if ($this->bookingMessage === "required")
                { $requiredMarkup = "*"; }
                else { $requiredMarkup = ""; }

                $html .= "
                    <i class=\"fa fa-question-circle-o text-info\" data-placement=\"auto right\" data-toggle=\"tooltip\" title=\"Bitte schreiben Sie weitere Informationen und die Adresse zu Ihrer Veranstaltung in dieses Textfeld. ACHTUNG: Bitte beachten Sie, dass f&uuml;r eine erfolgreiche Buchung die &Uuml;bermittlung der Adresse der Veranstaltung unbedingt n&ouml;tig ist.\"></i>
                    <label for=\"message\">Anmerkungen / Adresse".$requiredMarkup."
                    </label>
                    <textarea name=\"message\" id=\"message\" class=\"form-control\" rows=\"4\" autocomplete=\"off\"></textarea>
                    <br>";
            }

            $html .="
                <i class=\"fa fa-question-circle-o text-info\" data-placement=\"auto right\" data-toggle=\"tooltip\" title=\"Auf Wunsch erhalten Sie eine Kopie dieser Nachricht an Ihre Emailadresse zugestellt.\"></i>
                <label for=\"mailCopy\">Kopie dieser Nachricht an mich senden. &nbsp;
                <input type=\"checkbox\" name=\"mailCopy\" value=\"true\" id=\"mailCopy\" aria-checked=\"true\" checked></label>
                <button type=\"submit\" id=\"submitbutton\" class=\"btn btn-success pull-right hvr-grow\" style=\"margin-top:1%;\" contenteditable=\"false\"><i class=\"fa fa-paper-plane-o\"></i> &nbsp;Jetzt unverbindlich anfragen</button>
                <input type=\"hidden\" name=\"sent\" value=\"1\">";


            $html .= "</div></div>
    <!-- </div> -->
    </form>";
            return $html;
        } /* EOFunction getTable */
    }
}
