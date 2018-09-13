<?php
namespace YAWK\WIDGETS\TWITTER\TWEET
{
    /**
     * <b>Twitter Tweet Widget - embed Twitter Tweet</b>
     *
     * <p>Embed Twitter Tweet. All you need is the URL of your tweet
     * and the amount of items you wish to embed. You will get
     * the latest tweets.</p>
     *
     * @package    YAWK
     * @author     Daniel Retzl <danielretzl@gmail.com>
     * @copyright  2018 Daniel Retzl
     * @license    https://opensource.org/licenses/MIT
     * @version    1.0.0
     * @link       http://yawk.io
     * @annotation Embed Twitter Tweet
     */
    class twitterTweet extends \YAWK\widget
    {
        /** @var object global widget object data */
        public $widget = '';
        /** @var string Title that will be shown above widget */
        public $twitterSingleTweetHeading = '';
        /** @var string Subtext will be displayed beside title */
        public $twitterSingleTweetSubtext = '';
        /** @var string URL of your twitter Tweet */
        public $twitterSingleTweetUrl = "https://twitter.com/danielretzl";
        /** @var string How many tweets (latest n) */
        public $twitterSingleTweetTweetLimit = "5";
        /** @var string Hide data cards */
        public $twitterSingleTweetHideDataCards = "0";
        /** @var string How many tweets (latest n) */
        public $twitterSingleTweetDataConversation = "0";

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
         * Init Twitter Tweet Widget
         * @author Daniel Retzl <danielretzl@gmail.com>
         * @version 1.0.0
         * @link http://yawk.io
         * @annotation Embed a single tweet from twitter
         */
        public function init()
        {   // display heading
            echo $this->getHeading($this->twitterSingleTweetHeading, $this->twitterSingleTweetSubtext);

        /* CHECK SETTINGS AND SET THEM CORRECTLY */
        /* DATA CONVERSATION */
        // if data conversation is set to 1, conversation will be shown in this tweet
        if ($this->twitterSingleTweetDataConversation === "1")
        {
            $this->twitterSingleTweetDataConversation = '';
        }
        else
        {   // conversation will be hidden from this tweet
            $this->twitterSingleTweetDataConversation = 'data-conversation="none"';
        }

        /* HIDE MEDIA */
        // if data-cards is set to 1, media files will be shown
        if ($this->twitterSingleTweetHideDataCards === "1")
        {
            $this->twitterSingleTweetHideDataCards = 'data-cards="hidden"';
        }
        else
        {   // otherwise, media will be hidden from this tweet
            $this->twitterSingleTweetHideDataCards = '';
        }

echo "<blockquote class=\"twitter-tweet\" $this->twitterSingleTweetHideDataCards $this->twitterSingleTweetDataConversation><a href=\"$twitterUrl\"></a></blockquote>
<script async src=\"//platform.twitter.com/widgets.js\" charset=\"utf-8\"></script>";
        }
    }
}
