<?php
namespace YAWK\WIDGETS\NEWSLETTER\SUBSCRIBE
{
    /**
     * <b>Let your users subscribe to a newsletter database.</b>
     *
     * <p>With this widget, you are able to collect email addresses for your newsletter. The user can
     * enter his name and email address. Will be processed via ajax to avoid page reload. Data will be
     * entered in the newsletter database, which other plugins and widgets can access easily. </p>
     *
     * @package    YAWK
     * @author     Daniel Retzl <danielretzl@gmail.com>
     * @copyright  2018 Daniel Retzl
     * @license    https://opensource.org/licenses/MIT
     * @version    1.0.0
     * @link       http://yawk.io
     * @annotation Embed any YouTube Video on your pages.
     */
    class newsletter
    {
        /** @var object global widget object data */
        public $widget = '';
        /** @var string Title Text */
        public $newsletterTitle = 'Newsletter';
        /** @var string Thank You Subtext */
        public $newsletterSubtext = 'subscribe';
        /** @var string Thank You Title Text */
        public $newsletterThankYouTitle = 'Thank You';
        /** @var string Thank You SubText */
        public $newsletterThankYouSubtext = 'for subscribing to our newsletter!';
        /** @var string Button Text */
        public $newsletterBtnText = 'Subscribe Newsletter';
        /** @var string Button CSS Class */
        public $newsletterBtnClass = 'btn btn-success';
        /** @var string Name Field Placeholder */
        public $newsletterNamePlaceholder = 'Name';
        /** @var string Email Field Placeholder */
        public $newsletterEmailPlaceholder = 'Email';
        /** @var string Button Button Margin Top */
        public $newsletterBtnMarginTop = '5px';
        /** @var string Button Button Alignment */
        public $newsletterBtnAlign = 'text-center';
        /** @var string Hide Form Labels? */
        public $newsletterHideLabels = 'false';
        /** @var string Newsletter Icon (eg. font awesome or glyphicons) */
        public $newsletterIcon = 'fa fa-envelope-o';
        /** @var string Font size of icon, heading and subtext */
        public $newsletterFontSize = 'h2';
        /** @var string Btn Margin HTML Markup */
        public $markupBtnMarginTop = '';
        /** @var string Btn Class HTML Markup */
        public $markupBtnClass = '';
        /** @var string Btn Alignment HTML Markup */
        public $markupBtnAlign = '';
        /** @var string Name Label HTML Markup */
        public $markupNameLabel = '';
        /** @var string Email Label HTML Markup */
        public $markupEmailLabel = '';
        /** @var string Icon HTML Markup */
        public $markupIcon = '';
        /** @var string Font Size (H1-H6) HTML Markup Start */
        public $markupFontSizeStart = '<H2>';
        /** @var string Font Size (H1-H6) HTML Markup End */
        public $markupFontSizeEnd = '</H2>';

        /**
         * Load all widget settings from database and fill object params
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
         * Init Function: Loads the required JS, set properties and draw the form
         * @author Daniel Retzl <danielretzl@gmail.com>
         * @version 1.0.0
         * @link http://yawk.io
         * @annotation This method does the setup and embed job
         */
        public function init()
        {
            // load required javascript files
            $this->includeJS();
            // prepare properties and settings
            $this->setProperties();
            // lets start - draw newsletter form
            $this->drawForm();
        }

        /**
         * Load all required javascript files
         */
        public function includeJS()
        {
            // load validate js
            echo "<script type=\"text/javascript\" src=\"system/engines/jquery/jquery.validate.min.js\"></script>";
            // if current language is german
            if (\YAWK\language::getCurrentLanguageStatic() == "de-DE")
            {   // load german language file
                echo "<script type=\"text/javascript\" src=\"system/engines/jquery/messages_de.min.js\"></script>";
            }
            // load ajax file
            echo "<script type=\"text/javascript\" src=\"system/widgets/newsletter/js/nl.js\"></script>";
        }

        /**
         * Set all object properties and html markup codes depending on current widget settings
         */
        public function setProperties()
        {
            // check if btn margin top is set
            if (isset($this->newsletterBtnMarginTop) && (!empty($this->newsletterBtnMarginTop)))
            {   // set markup
                $this->markupBtnMarginTop = " style=\"margin-top:$this->newsletterBtnMarginTop\"";
            }
            else
            {   // no btn margin set, leave markup empty
                $this->markupBtnMarginTop = '';
            }

            // check btn class and alignment
            if (isset($this->newsletterBtnClass) && (!empty($this->newsletterBtnClass)))
            {   // set markup
                $this->markupBtnClass = "$this->newsletterBtnClass";
            }
            else
            {   // no btn margin set, leave markup empty
                $this->markupBtnClass = '';
            }

            // check button alignment
            if (isset($this->newsletterBtnAlign) && (!empty($this->newsletterBtnAlign)))
            {   // set btn align markup
                $this->markupBtnAlign = " class=\"$this->newsletterBtnAlign\"";
            }
            else
            {   // no markup needed, leave empty
                $this->markupBtnAlign = '';
            }

            // check if labels should be hidden
            if (isset($this->newsletterHideLabels) && ($this->newsletterHideLabels == "false"))
            {   // label html markup code
                $this->markupNameLabel = "<label for=\"name\">$this->newsletterNamePlaceholder</label>";
                $this->markupEmailLabel = "<label for=\"email\">$this->newsletterEmailPlaceholder</label>";
            }
            else
            {   // no labels
                $this->markupNameLabel = '';
                $this->markupEmailLabel = '';
            }

            // check if icon is set
            if (isset($this->newsletterIcon) && (!empty($this->newsletterIcon)))
            {   // icon html markup
                $this->markupIcon = "<i class=\"$this->newsletterIcon\"></i>&nbsp;";
            }
            else
            {   // no icon, no markup
                $this->markupIcon = '';
            }

            // check which font size is set
            if (isset($this->newsletterFontSize) && (!empty($this->newsletterFontSize)))
            {   // set markup for h tags
                $this->markupFontSizeStart = "<$this->newsletterFontSize>";
                $this->markupFontSizeEnd = "</$this->newsletterFontSize>";
            }
            else
            {   // if font size is not set, use default:
                $this->markupFontSizeStart = "<H2>";
                $this->markupFontSizeEnd = "</H2>";
            }
        }

        /**
         * Draw the newsletter html form
         *
         */
        public function drawForm()
        {
            echo"
            <div class=\"container-fluid\">
            <div class=\"row\">
            <div class=\"col-md-12\">
            <div id=\"formWrapper\">
            <div id=\"newsletterTitle\">$this->markupFontSizeStart$this->markupIcon$this->newsletterTitle <small>$this->newsletterSubtext</small>$this->markupFontSizeEnd</div>
            <form class=\"form-horizontal\" id=\"form\" method=\"post\">
                $this->markupNameLabel
                <input type=\"text\" name=\"name\" id=\"name\" class=\"form-control\" placeholder=\"$this->newsletterNamePlaceholder\">
                $this->markupEmailLabel
                <input type=\"text\" name=\"email\" id=\"email\" class=\"form-control\" placeholder=\"$this->newsletterEmailPlaceholder\">
                <input type=\"hidden\" name=\"thankYouTitle\" id=\"thankYouTitle\" value=\"$this->newsletterThankYouTitle\">
                <input type=\"hidden\" name=\"thankYouSubtext\" id=\"thankYouSubtext\" value=\"$this->newsletterThankYouSubtext\">
                <div$this->markupBtnAlign>
                    <input type=\"button\" class=\"$this->markupBtnClass\" id=\"submit\" name=\"submit\" value=\"$this->newsletterBtnText\"$this->markupBtnMarginTop>
                </div>
            </form>
            </div>
            <div id=\"thankYouMessage\"></div>
            </div>
            </div>
            </div>";
        }
    }
}
