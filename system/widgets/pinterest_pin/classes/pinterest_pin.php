<?php
namespace YAWK\WIDGETS\PINTEREST\PIN
{
    /**
     * <b>Pinterest Pin - embed a single pin on your page</b>
     *
     * <p>Use this widget to embed any single pin on your page. To get this widget to work,
     * enter any public pin url. Description can be shown or hidden, the size of your pin can
     * be changed and heading and subtext could be added as well. </p>
     *
     * @package    YAWK
     * @author     Daniel Retzl <danielretzl@gmail.com>
     * @copyright  2018 Daniel Retzl
     * @license    https://opensource.org/licenses/MIT
     * @version    1.0.0
     * @link       http://yawk.io
     * @annotation Pinterest Pin Widget
     */
    class pinterestPin extends \YAWK\widget
    {
        /** @var object global widget object data */
        public $widget = '';
        /** @var string Title that will be shown above widget */
        public $pinterestPinHeading = '';
        /** @var string Subtext will be displayed beside title */
        public $pinterestPinSubtext = '';
        /** @var string The URL of your pinterest channel */
        public $pinterestPinUrl="https://www.pinterest.com/pin/99360735500167749/";
        /** @var string The URL of your pinterest channel */
        public $pinterestPinSize="large";
        /** @var string The URL of your pinterest channel */
        public $pinterestPinHideDescription = 'data-pin-terse="true"';

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
         * Init pinterest pin widget and call embed method
         * @author Daniel Retzl <danielretzl@gmail.com>
         * @version 1.0.0
         * @link http://yawk.io
         * @annotation Embed any public Pinterest Pin
         */
        public function init()
        {   // draw headline on screen
            echo $this->getHeading($this->pinterestPinHeading, $this->pinterestPinSubtext);
            $this->embedPinterestPin();
        }

        /**
         * Embed Pinterest Pin
         * @author Daniel Retzl <danielretzl@gmail.com>
         * @version 1.0.0
         * @link http://yawk.io
         * @annotation Embed Pinterest Pin
         */
        public function embedPinterestPin()
        {   // check if url is set
            if (isset($this->pinterestPinUrl)
                && (!empty($this->pinterestPinUrl)
                && (is_string($this->pinterestPinUrl))))
            {   // embed pinterest follow button markup
                echo '
                <a data-pin-do="embedPin" data-pin-width="'.$this->pinterestPinSize.'" data-pin-terse="'.$this->pinterestPinHideDescription.'" href="'.$this->pinterestPinUrl.'"></a>
                <script async defer src="//assets.pinterest.com/js/pinit.js"></script>';
            }
            else
                {
                    echo "Here should be a pinterest pin, but no URL is set. Please enter your pinterest pin URL.";
                }
        }

    }
}
?>