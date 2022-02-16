<?php
namespace YAWK\WIDGETS\TWITTER\GRID
{
    /**
     * @details<b>Twitter Widget - embed Twitter Timeline as grid</b>
     *
     * <p>Twitter Timelines can be embeded as grid view. All you need is
     * the URL of your twitter timeline and the amount of items you wish
     * to embed. You will get the latest tweets.</p>
     *
     *
     * @author     Daniel Retzl <danielretzl@gmail.com>
     * @copyright  2018 Daniel Retzl
     * @version    1.0.0
     * @brief Embed Twitter Timeline as grid
     */
    class twitterGrid extends \YAWK\widget
    {
        /** @param object global widget object data */
        public $widget = '';
        /** @param string Title that will be shown above widget */
        public $twitterGridHeading = '';
        /** @param string Subtext will be displayed beside title */
        public $twitterGridSubtext = '';
        /** @param string URL of your twitter timeline */
        public $twitterGridUrl = "https://twitter.com/TwitterDev/timelines/539487832448843776";
        /** @param string How many tweets (latest n) */
        public $twitterGridTweetLimit = "5";

        /**
         * @brief Load all widget settings from database and fill object
         * @param object $db Database Object
         * @brief Load all widget settings on object init.
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
         * @brief Init Twitter widget
         * @brief Twitter Widget Init
         */
        public function init()
        {   // display heading
            echo $this->getHeading($this->twitterGridHeading, $this->twitterGridSubtext);

            // remove trailing slash from url
            $this->twitterGridUrl = rtrim($this->twitterGridUrl,"/");
            // explode user from URL
            $twitterUserArray = explode("/", $this->twitterGridUrl);
            $twitterUser = $twitterUserArray['3'];

echo "<a class=\"twitter-grid\" data-limit=\"$this->twitterGridTweetLimit\" href=\"$this->twitterGridUrl\">$twitterUser Tweets</a>
<script async src=\"//platform.twitter.com/widgets.js\" charset=\"utf-8\"></script>";

        }
    }
}
?>