<?php
namespace YAWK\WIDGETS\TWITTER\TIMELINE
{
    /**
     * @details<b>Twitter Timeline Widget - embed Twitter Timeline</b>
     *
     * <p>Embed Twitter Timeline. All you need is the URL of your twitter
     * timeline and the amount of items you wish to embed. You will get
     * the latest tweets.</p>
     *
     *
     * @author     Daniel Retzl <danielretzl@gmail.com>
     * @copyright  2018 Daniel Retzl
     * @version    1.0.0
     * @brief Embed Twitter Timeline
     */
    class twitterTimeline extends \YAWK\widget
    {
        /** @param object global widget object data */
        public $widget = '';
        /** @param string Title that will be shown above widget */
        public $twitterTimelineHeading = '';
        /** @param string Subtext will be displayed beside title */
        public $twitterTimelineSubtext = '';
        /** @param string URL of your twitter timeline */
        public $twitterTimelineUrl = "https://twitter.com/danielretzl";
        /** @param string How many tweets (latest n) */
        public $twitterTimelineTweetLimit = "5";

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
         * @brief Init Twitter Timeline Widget
         * @brief Twitter Timeline Widget Init
         */
        public function init()
        {   // display heading
            echo $this->getHeading($this->twitterTimelineHeading, $this->twitterTimelineSubtext);

            // remove trailing slash from url
            $this->twitterTimelineUrl = rtrim($this->twitterTimelineUrl,"/");
            // explode user from URL
            $twitterUserArray = explode("/", $this->twitterTimelineUrl);
            $twitterUser = $twitterUserArray['3'];

echo "<a class=\"twitter-timeline\" data-tweet-limit=\"$this->twitterTimelineTweetLimit\" href=\"$this->twitterTimelineUrl\">Tweets by $twitterUser</a>
<script async src=\"//platform.twitter.com/widgets.js\" charset=\"utf-8\"></script>";
        }
    }
}
