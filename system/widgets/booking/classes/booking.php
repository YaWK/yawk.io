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
        /** @var object global widget object data */
        public $widget = '';
        /** @var string Heading */
        public $bookingHeading = '';
        /** @var string Subtext */
        public $bookingSubtext = '';
        /** @var string Headline HTML Markup */
        public $bookingHeadline = '';
        /** @var string Headline Prepend Icon */
        public $bookingIcon = '';

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
                    $this->bookingHeadline = "<div id=\"bookingHeading\"><h1>$this->bookingIcon"."$this->bookingHeading&nbsp;"."$this->bookingSubtext</h1></div>";
                }
                else
                {   // headline only - without subtext
                    $this->bookingHeadline = "<h1>$this->bookingHeading</h1>";    // draw just the heading
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

            // embed required javascript
            echo "            
            <script type=\"text/javascript\">
                $(document).ready(function () {
                $('#form').validate({ // initialize the plugin
                    rules: {
                        name: {
                            required: true,
                            minlength: 3
                        },
                        message: {
                            required: true
                        },
                        email: {
                            required: true,
                            email: true,
                            maxlength: 128
                        },
                        phone: {
                            required: true
                        }
                    },
                    messages: {
                        name: {
                            required: \"Please enter your name (or pseudonym). &nbsp;\"
                        },
                        email: {
                            required: \"Please enter a valid email address. &nbsp;\"
                        },
                        phone: {
                            required: \"Please enter your phone number. &nbsp;\"
                        },
                        message: {
                            required: \"Please enter your message. &nbsp;\"
                        }
                    }
                });
            });
            </script>
            <script type=\"text/javascript\" src=\"system/engines/jquery/jquery.validate.min.js\"></script>
            <script type=\"text/javascript\" src=\"system/engines/jquery/messages_de.min.js\"></script>";


            // include booking plugin class
            include 'system/plugins/booking/classes/booking.php';

            // generate new booking obj
            $booking = new \YAWK\PLUGINS\BOOKING\booking();

            // check if form was sent
            if (isset($_POST['sent']) && $_POST['sent'] === '1')
            {
                // create new booking method
                $booking = $booking->create($db);
                // thank you page...
                echo "<div style=\"text-align: center; margin-top: 20%; margin-bottom: 600px;\"><h1>Thank you <small>for your booking...</small></h1>
                      <p>We will get in contact with you soon! <br>
                      <br><a href=\"index.html\">Back to Home Page</a></p></div>";
            }
            else
            {
                // draw headline, if set
                echo "$this->bookingHeadline<hr>";
                echo $booking = $booking->getFrontendForm();
            }
        }
    }
}
