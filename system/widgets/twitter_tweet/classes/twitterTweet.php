<?php
namespace YAWK\WIDGETS\TWITTER\TWEET
{
    /**
     * @details<b>Twitter Tweet Widget - embed Twitter Tweet</b>
     *
     * <p>Embed Twitter Tweet. All you need is the URL of your tweet
     * and the amount of items you wish to embed. You will get
     * the latest tweets.</p>
     *
     *
     * @author     Daniel Retzl <danielretzl@gmail.com>
     * @copyright  2018 Daniel Retzl
     * @version    1.0.0
     * @brief Embed Twitter Tweet
     */
    class twitterTweet extends \YAWK\widget
    {
        /** @param object global widget object data */
        public $widget = '';
        /** @param string Title that will be shown above widget */
        public $twitterSingleTweetHeading = '';
        /** @param string Subtext will be displayed beside title */
        public $twitterSingleTweetSubtext = '';
        /** @param string URL of your twitter Tweet */
        public $twitterSingleTweetUrl = "https://twitter.com/danielretzl";
        /** @param string How many tweets (latest n) */
        public $twitterSingleTweetTweetLimit = "5";
        /** @param string Hide data cards */
        public $twitterSingleTweetHideDataCards = "0";
        /** @param string How many tweets (latest n) */
        public $twitterSingleTweetDataConversation = "0";

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
         * @brief Init Twitter Tweet Widget
         * @brief Embed a single tweet from twitter
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

echo "<blockquote class=\"twitter-tweet\" $this->twitterSingleTweetHideDataCards $this->twitterSingleTweetDataConversation><a href=\"$this->twitterSingleTweetUrl\"></a></blockquote>
<script async src=\"//platform.twitter.com/widgets.js\" charset=\"utf-8\"></script>";
        }
    }
}
