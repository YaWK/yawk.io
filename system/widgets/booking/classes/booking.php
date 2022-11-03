<?php
namespace YAWK\WIDGETS\BOOKING\FORM
{

    use YAWK\db;
    use YAWK\settings;

    /**
     * @details<b>Booking Widget of Booking Plugin.</b>
     *
     * <p>The widget allows you to embed a booking form onto any page and position you need.
     * It is useful to collect bookings from your users. For further information see description
     * of the booking plugin.</p>
     *
     *
     * @author     Daniel Retzl <danielretzl@gmail.com>
     * @copyright  2019 Daniel Retzl
     * @version    1.0.0
     * @brief Embed booking plugin on your pages.
     */
    class bookingWidget
    {
        // BASIC WIDGET SETTINGS
        /** @param object global widget object data */
        public $widget = '';
        /** @param array Form Settings */
        public $formSettings = '';
        /** @param string Headline HTML Markup */
        public $bookingHeadline = '';

        // FORM SETTINGS
        /** @param string Heading */
        public $bookingHeading = '';
        /** @param string Subtext */
        public $bookingSubtext = '';
        /** @param string Headline Prepend Icon */
        public $bookingIcon = '';
        /** @param string Email address that will be used as sender */
        public $bookingFromEmail = '';

        // FORM FIELDS (required[visible, mandatory] | true[visible, not mandatory] | false[invisible, not mandatory])
        /** @param string Booking Band Select Field required|true|false */
        public $bookingBand = '';
        /** @param string Event Date + Time required|true|false */
        public $bookingEventDatetime = '';
        /** @param string Soundcheck Time required|true|false*/
        public $bookingEventSoundcheck = '';
        /** @param string Showtime required|true|false*/
        public $bookingEventShowtime = '';
        /** @param string How long is the soundcheck time? required|true|false */
        public $bookingSoundcheckDuration = '';
        /** @param string How long is the showtime? required|true|false */
        public $bookingShowtimeDuration = '';
        /** @param string Booking Location (indoor / outdoor) required|true|false */
        public $bookingLocation = '';
        /** @param string Booking Location Type (party / wedding / private society) required|true|false */
        public $bookingLocationType = '';
        /** @param string How many people are invited? required|true|false */
        public $bookingCrowdAmount = '';
        /** @param string PA available? required|true|false */
        public $bookingPaAvailable = '';
        /** @param string Tech guy available? required|true|false */
        public $bookingTechAvailable = '';
        /** @param string Overnight possible? required|true|false */
        public $bookingHotelAvailable = '';
        /** @param string message / note required|true|false */
        public $bookingMessage = '';
        /** @param string email required|true|false */
        public $bookingEmail = '';
        /** @param string contact name required|true|false */
        public $bookingContactName = '';
        /** @param string contact phone number required|true|false */
        public $bookingPhone = '';
        /** @param string how many sets should be played? required|true|false */
        public $bookingSetAmount = '';
        /** @param string admin email address where booking will be sent to */
        public $bookingAdminEmail = '';
        /** @param string html email true|false */
        public $bookingHtmlEmail = '';


        /**
         * @brief Load all widget settings from database and fill object
         * @param object $db Database Object
         * @brief Load all widget settings on object init.
         */
        public function __construct(object $db)
        {
            // load this widget settings from db
            $this->widget = new \YAWK\widget();
            $settings = $this->widget->getWidgetSettingsArray($db);
            foreach ($settings as $property => $value) {
                $this->$property = $value;
            }
        }

        /**
         * @brief Print all object data
         * @brief (for development and testing purpose)
         */
        public function printObject()
        {
            echo "<pre>";
            print_r($this);
            echo "</pre>";
        }

        /**
         * @brief Init Booking Widget
         * @brief This method does the setup and embed job
         * @param object $db db object
         * @param array $lang language array
         */
        public function init($db, $lang)
        {
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
            <script src=\"https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js\"></script>";

            echo "<script type=\"text/javascript\" src=\"system/engines/datetimepicker/js/bootstrap-datetimepicker.min.js\"></script>
            <script type=\"text/javascript\" src=\"system/engines/jquery/jquery.validate.min.js\"></script>
            <script type=\"text/javascript\" src=\"system/widgets/booking/js/booking.js\"></script>
            <link rel=\"stylesheet\" href=\"system/engines/jquery/timepicker/jquery.timepicker.css\">
            <script src=\"//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js\"></script>";

            if (settings::getSetting($db, "frontendLanguage") === "de-DE")
            {
                echo "<script src=\"https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/locale/de.js\"></script>
                      <script type=\"text/javascript\" src=\"system/engines/jquery/messages_de.min.js\"></script>";
            }


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
            echo $this->drawFrontendForm($lang);

            // draw thank you message div (hidden until submit)
            echo $this->drawThankYouMessage($db, $lang);
        }

        /**
         * @brief Set widget properties from database and fill object params
         * @brief Load all widget settings.
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
         * @brief draw (output) thank you message
         * (will be displayed after successful submit)
         * @return string html code
         */
        public function drawThankYouMessage($db, $lang): string
        {
            $hostname = settings::getSetting($db, "host");
            $html = "";
            $html .= "
            <div class=\"hidden d-none\" id=\"thankYouMessage\">
            <div class=\"col-md-2\">&nbsp;</div>
            <div class=\"col-md-8 text-center\"><h2>".$lang['BOOKING_THANK_YOU_HEADING']."<br>
            <small>".$lang['BOOKING_THANK_YOU_SUBLINE']."</small><br><br>
            <i class=\"fa fa-handshake-o text-muted\"></i></h2>
            <br><hr><a href=\"".$hostname."\" target=\"_self\">".$lang['BOOKING_BACK']."</a> 
            | <a href=\"booking.html\" target=\"_self\">".$lang['BOOKING_AGAIN']."</a></div>
            <div class=\"col-md-2\">&nbsp;</div>
            </div>
            ";
            // return html data
            return $html;
        }

        /**
         * @brief draw (output) html of the frontend form. This is displayed to the user. He will use to place a booking
         * @return string
         */
        public function drawFrontendForm($lang): string
        {
            // init form html code markup variable
            $html = "";

            $html .= "
<form class=\"form\" id=\"bookingForm\" method=\"post\" action=\"\">

<div class=\"container-fluid\">
<div class=\"row\">
    <div class=\"col-md-4 animated fadeIn speed3\">
    <input type=\"hidden\" name=\"adminEmail\" id=\"adminEmail\" value=\"".$this->bookingAdminEmail."\">
    <input type=\"hidden\" name=\"bookingHtmlEmail\" id=\"bookingHtmlEmail\" value=\"".$this->bookingHtmlEmail."\">";

            // NAME
            if ($this->bookingContactName !== "false")
            {
                if ($this->bookingContactName === "required")
                { $requiredMarkup = "*"; }
                else { $requiredMarkup = ""; }

                $html .= "
                <label for=\"name\">".$lang['BOOKING_NAME'].$requiredMarkup."
                    <i class=\"fa fa-question-circle-o text-info\" data-toggle=\"tooltip\" title=\"".$lang['BOOKING_HELP_NAME']."\"></i>
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
            <label for=\"email\">".$lang['LABEL_BOOKING_EMAIL'].$requiredMarkup."
                <i class=\"fa fa-question-circle-o text-info\" data-toggle=\"tooltip\" title=\"".$lang['BOOKING_HELP_EMAIL']."\"></i>
            </label>
            <input type=\"text\" name=\"email\" id=\"email\" class=\"form-control\" placeholder=\"you@email.tld\" autocomplete=\"off\">
            <br>";
            }

            // PHONE
            if ($this->bookingPhone !== "false")
            {
                if ($this->bookingPhone === "required")
                { $requiredMarkup = "*"; }
                else { $requiredMarkup = ""; }

                $html .= "
        <label for=\"phone\">".$lang['LABEL_BOOKING_PHONE'].$requiredMarkup."
            <i class=\"fa fa-question-circle-o text-info\" data-toggle=\"tooltip\" title=\"".$lang['BOOKING_HELP_PHONE']."\"></i>
        </label>
        <input type=\"text\" name=\"phone\" id=\"phone\" class=\"form-control\" placeholder=\"+43 1234 12345678\" autocomplete=\"off\">
        <br>
        <div class=\"animated fadeIn speed4 delay-10s\">
            ".$lang['BOOKING_HELP_TEXT']."
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
                    <label for=\"eventDateTime\">".$lang['LABEL_BOOKING_EVENTDATETIME'].$requiredMarkup."
                        <i class=\"fa fa-question-circle-o text-info\" data-toggle=\"tooltip\" title=\"".$lang['BOOKING_HELP_DATETIME']."\"></i>
                    </label>
                    <input type=\"text\" name=\"eventDateTime\" autocomplete=\"off\" id=\"eventDateTime\" class=\"form-control\" placeholder=\"".$lang['BOOKING_HELP_DATE_AND_TIME']."\">
                    <br>";
            }

            // SHOWTIME Duration
            if ($this->bookingShowtimeDuration !== "false")
            {
                if ($this->bookingShowtimeDuration === "required")
                { $requiredMarkup = "*"; }
                else { $requiredMarkup = ""; }

                $html .= "
                    <label for=\"showtimeDuration\">".$lang['LABEL_BOOKING_SHOWTIME_DURATION'].$requiredMarkup."
                        <i class=\"fa fa-question-circle-o text-info\" data-toggle=\"tooltip\" title=\"".$lang['BOOKING_HELP_SHOWTIME_DURATION']."\"></i>
                    </label>
                    <select name=\"showtimeDuration\" id=\"showtimeDuration\" class=\"form-control\">
                    <option value=\"\">".$lang['BOOKING_PLEASE_SELECT']."</option>
                    <option value=\"".$lang['BOOKING_30MIN']."\">".$lang['BOOKING_30MIN']."</option>
                    <option value=\"".$lang['BOOKING_45MIN']."\">".$lang['BOOKING_45MIN']."</option>
                    <option value=\"".$lang['BOOKING_1H']."\">".$lang['BOOKING_1H']."</option>
                    <option value=\"".$lang['BOOKING_2H']."\">".$lang['BOOKING_2H']."</option>
                    <option value=\"".$lang['BOOKING_3H']."\">".$lang['BOOKING_3H']."</option>
                    <option value=\"".$lang['BOOKING_4H']."\">".$lang['BOOKING_4H']."</option>
                    <option value=\"".$lang['BOOKING_NOT_SPECIFIED']."\">".$lang['BOOKING_NOT_SPECIFIED']."</option>
                    </select><br>";
            }

            // SOUNDCHECK TIME
            if ($this->bookingEventSoundcheck !== "false")
            {
                if ($this->bookingEventSoundcheck === "required")
                { $requiredMarkup = "*"; }
                else { $requiredMarkup = ""; }

                $html .= "
                    <label for=\"eventSoundcheck\">".$lang['LABEL_BOOKING_SOUNDCHECK'].$requiredMarkup."
                        <i class=\"fa fa-question-circle-o text-info\" data-toggle=\"tooltip\" title=\"".$lang['BOOKING_HELP_SOUNDCHECK']."\"></i>
                    </label>
                    <input type=\"text\" name=\"eventSoundcheck\" autocomplete=\"off\" id=\"eventSoundcheck\" class=\"form-control timepicker\" placeholder=\"".$lang['BOOKING_HELP_SELECT_TIME']."\">
                    <br>";
            }

            // SOUNDCHECK Duration
            if ($this->bookingSoundcheckDuration !== "false")
            {
                if ($this->bookingSoundcheckDuration === "required")
                { $requiredMarkup = "*"; }
                else { $requiredMarkup = ""; }

                $html .= "
                    <label for=\"soundcheckDuration\">".$lang['LABEL_BOOKING_SOUNDCHECK_DURATION'].$requiredMarkup."
                        <i class=\"fa fa-question-circle-o text-info\" data-toggle=\"tooltip\" title=\"".$lang['BOOKING_HELP_SOUNDCHECK_DURATION']."\"></i>
                    </label>
                    <select name=\"soundcheckDuration\" id=\"soundcheckDuration\" class=\"form-control\">
                    <option value=\"\">".$lang['BOOKING_PLEASE_SELECT']."</option>
                    <option value=\"".$lang['BOOKING_30MIN']."\">".$lang['BOOKING_30MIN']."</option>
                    <option value=\"".$lang['BOOKING_45MIN']."\">".$lang['BOOKING_45MIN']."</option>
                    <option value=\"".$lang['BOOKING_60MIN']."\">".$lang['BOOKING_60MIN']."</option>
                    <option value=\"".$lang['BOOKING_NOT_SPECIFIED']."\">".$lang['BOOKING_NOT_SPECIFIED']."</option>
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
                    <label for=\"eventShowtime\">".$lang['LABEL_BOOKING_SHOWTIME'].$requiredMarkup."
                        <i class=\"fa fa-question-circle-o text-info\" data-toggle=\"tooltip\" title=\"".$lang['BOOKING_HELP_SHOWTIME']."\"></i>
                    </label>
                    <input type=\"text\" name=\"eventShowtime\" autocomplete=\"off\" id=\"eventShowtime\" class=\"form-control timepicker\" placeholder=\"".$lang['BOOKING_HELP_SELECT_TIME']."\">
                    <br>";
            }

            // SET AMOUNT
            if ($this->bookingSetAmount !== "false")
            {
                if ($this->bookingSetAmount === "required")
                { $requiredMarkup = "*"; }
                else { $requiredMarkup = ""; }

                $html .= "
                    <label for=\"setAmount\">".$lang['LABEL_BOOKING_SET_AMOUNT'].$requiredMarkup."
                        <i class=\"fa fa-question-circle-o text-info\" data-toggle=\"tooltip\" title=\"".$lang['BOOKING_HELP_SET_AMOUNT']."\"></i>
                    </label>
                    <select name=\"setAmount\" id=\"setAmount\" class=\"form-control\">
                    <option value=\"\">".$lang['BOOKING_PLEASE_SELECT']."</option>
                    <option value=\"1\">1</option>
                    <option value=\"2\">2</option>
                    <option value=\"3\">3</option>
                    <option value=\"4\">4</option>
                    <option value=\"".$lang['BOOKING_NOT_SPECIFIED']."\">".$lang['BOOKING_NOT_SPECIFIED']."</option>
                    </select>";
            }

            $html .= "</div>
                <div class=\"col-md-7 animated fadeIn speed4 delay-8s\">
                <!-- right -->";

            // BAND SELECT FIELD
            /*
            if ($this->bookingBand !== "false")
            {
                if ($this->bookingBand === "required")
                { $requiredMarkup = "*"; }
                else { $requiredMarkup = ""; }

                $html .= "
                        <label for=\"band\">".$lang['LABEL_BOOKING_BAND'].$requiredMarkup."
                            <i class=\"fa fa-question-circle-o text-info\" data-placement=\"auto right\" data-toggle=\"tooltip\" title=\"Bitte geben Sie hier an, welche Band sie buchen m&ouml;chten.\"></i>
                        </label>
                        <select name=\"band\" id=\"band\" class=\"form-control\">
                        <option value=\"\">".$lang['BOOKING_PLEASE_SELECT']."</option>
                        <option value=\"Your Band here\">Your Band here</option>
                        <option value=\"".$lang['BOOKING_NOT_SPECIFIED']."\">".$lang['BOOKING_NOT_SPECIFIED']."</option>
                        </select>
                        <br>";
            }
            */

            // EVENT TYPE
            if ($this->bookingLocationType !== "false")
            {
                if ($this->bookingLocationType === "required")
                { $requiredMarkup = "*"; }
                else { $requiredMarkup = ""; }

                $html .= "
                        <label for=\"locationType\">".$lang['LABEL_BOOKING_LOCATION_TYPE'].$requiredMarkup."
                            <i class=\"fa fa-question-circle-o text-info\" data-toggle=\"tooltip\" title=\"".$lang['BOOKING_HELP_LOCATION_TYPE']."\"></i>
                        </label>
                        <select name=\"locationType\" id=\"locationType\" class=\"form-control\">
                        <option value=\"\">".$lang['BOOKING_PLEASE_SELECT']."</option>
                        <option value=\"".$lang['BOOKING_PRIVATE_EVENT']."\">".$lang['BOOKING_PRIVATE_EVENT']."</option>
                        <option value=\"".$lang['BOOKING_COMPANY_EVENT']."\">".$lang['BOOKING_COMPANY_EVENT']."</option>
                        <option value=\"".$lang['BOOKING_MARRIAGE_EVENT']."\">".$lang['BOOKING_MARRIAGE_EVENT']."</option>
                        <option value=\"".$lang['BOOKING_BIG_EVENT']."\">".$lang['BOOKING_BIG_EVENT']."</option>
                        <option value=\"".$lang['BOOKING_FESTIVAL_EVENT']."\">".$lang['BOOKING_FESTIVAL_EVENT']."</option>
                        <option value=\"".$lang['BOOKING_BENEFIT_EVENT']."\">".$lang['BOOKING_BENEFIT_EVENT']."</option>
                        <option value=\"".$lang['BOOKING_NOT_SPECIFIED']."\">".$lang['BOOKING_NOT_SPECIFIED']."</option>
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
                        <label for=\"location\">".$lang['LABEL_BOOKING_LOCATION'].$requiredMarkup."
                            <i class=\"fa fa-question-circle-o text-info\" data-toggle=\"tooltip\" title=\"".$lang['BOOKING_HELP_LOCATION']."\"></i>
                        </label>
                        <select name=\"location\" id=\"location\" class=\"form-control\">
                            <option value=\"\">".$lang['BOOKING_PLEASE_SELECT']."</option>
                            <option value=\"".$lang['BOOKING_INDOOR']."\">".$lang['BOOKING_INDOOR']."</option>
                            <option value=\"".$lang['BOOKING_OUTDOOR']."\">".$lang['BOOKING_OUTDOOR']."</option>
                            <option value=\"".$lang['BOOKING_NOT_SPECIFIED']."\">".$lang['BOOKING_NOT_SPECIFIED']."</option>
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
                        <label for=\"crowdAmount\">".$lang['LABEL_BOOKING_CROWD_AMOUNT'].$requiredMarkup."
                            <i class=\"fa fa-question-circle-o text-info\" data-toggle=\"tooltip\" title=\"".$lang['BOOKING_HELP_CROWD_AMOUNT']."\"></i>
                        </label>
                        <select name=\"crowdAmount\" id=\"crowdAmount\" class=\"form-control\">
                            <option value=\"\">".$lang['BOOKING_PLEASE_SELECT']."</option>
                            <option value=\"".$lang['BOOKING_50']."\">".$lang['BOOKING_50']."</option>
                            <option value=\"".$lang['BOOKING_100']."\">".$lang['BOOKING_100']."</option>
                            <option value=\"".$lang['BOOKING_200']."\">".$lang['BOOKING_200']."</option>
                            <option value=\"".$lang['BOOKING_500']."\">".$lang['BOOKING_500']."</option>
                            <option value=\"".$lang['BOOKING_1000']."\">".$lang['BOOKING_1000']."</option>
                            <option value=\"".$lang['BOOKING_BIGGER_1000']."\">".$lang['BOOKING_BIGGER_1000']."</option>
                            <option value=\"".$lang['BOOKING_NOT_SPECIFIED']."\">".$lang['BOOKING_NOT_SPECIFIED']."</option>
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
                        &nbsp;&nbsp;<i class=\"fa fa-question-circle-o text-info\" data-toggle=\"tooltip\" title=\"".$lang['BOOKING_HELP_PA']."\"></i>
                        <label for=\"paAvailable\">".$lang['LABEL_BOOKING_PA_AVAILABLE'].$requiredMarkup."&nbsp;&nbsp;</label>
                        <input type=\"radio\" name=\"paAvailable\" value=\"".$lang['BOOKING_YES']."\"> ".$lang['BOOKING_YES']."
                        &nbsp;&nbsp;<input type=\"radio\" name=\"paAvailable\" value=\"".$lang['BOOKING_NO']."\"> ".$lang['BOOKING_NO']."
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
                        &nbsp;&nbsp;<i class=\"fa fa-question-circle-o text-info\" data-toggle=\"tooltip\" title=\"".$lang['BOOKING_HELP_TECH']."\"></i>
                        <label for=\"techAvailable\">".$lang['LABEL_BOOKING_TECH_AVAILABLE'].$requiredMarkup."&nbsp;&nbsp;</label>
                        <input type=\"radio\" name=\"techAvailable\" value=\"".$lang['BOOKING_YES']."\"> ".$lang['BOOKING_YES']."
                        &nbsp;&nbsp;<input type=\"radio\" name=\"techAvailable\" value=\"".$lang['BOOKING_NO']."\"> ".$lang['BOOKING_NO']."
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
                        &nbsp;&nbsp;<i class=\"fa fa-question-circle-o text-info\" data-toggle=\"tooltip\" title=\"".$lang['BOOKING_HELP_HOTEL']."\"></i>
                        <label for=\"hotelAvailable\">".$lang['LABEL_BOOKING_HOTEL_AVAILABLE'].$requiredMarkup."&nbsp;&nbsp;</label>
                        <input type=\"radio\" name=\"hotelAvailable\" value=\"".$lang['BOOKING_YES']."\"> ".$lang['BOOKING_YES']."
                        &nbsp;&nbsp;<input type=\"radio\" name=\"hotelAvailable\" value=\"".$lang['BOOKING_NO']."\"> ".$lang['BOOKING_NO']."
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
                    <i class=\"fa fa-question-circle-o text-info\" data-toggle=\"tooltip\" title=\"".$lang['BOOKING_HELP_MSG']."\"></i>
                    <label for=\"message\">".$lang['LABEL_BOOKING_MESSAGE'].$requiredMarkup."
                    </label>
                    <textarea name=\"message\" id=\"message\" class=\"form-control\" rows=\"4\" autocomplete=\"off\"></textarea>
                    <br>";
            }

            $html .="
                <i class=\"fa fa-question-circle-o text-info\" data-toggle=\"tooltip\" title=\"".$lang['BOOKING_HELP_MAILCOPY']."\"></i>
                <label for=\"mailCopy\">".$lang['BOOKING_COPY']." &nbsp;
                <input type=\"checkbox\" name=\"mailCopy\" value=\"true\" id=\"mailCopy\" aria-checked=\"true\" checked></label>
                <button type=\"submit\" id=\"submitbutton\" class=\"btn btn-success pull-right hvr-grow\" style=\"margin-top:1%;\" contenteditable=\"false\"><i class=\"fa fa-paper-plane-o\"></i> &nbsp;".$lang['BOOKING_SUBMIT_BTN']."</button>
                <input type=\"hidden\" name=\"sent\" value=\"1\">";


            $html .= "</div></div></div>
    <!-- </div> -->
    </form>";
            return $html;
        } /* EOFunction getTable */
    }
}
