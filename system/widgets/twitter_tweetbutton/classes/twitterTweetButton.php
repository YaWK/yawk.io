<?php
namespace YAWK\WIDGETS\TWITTER\BUTTON
{
    /**
     * @details<b>Twitter TweetButton Widget - embed Twitter TweetButton</b>
     *
     * <p>Embed Twitter TweetButton. All you need is the URL of your TweetButton
     * and the amount of items you wish to embed. You will get
     * the latest TweetButtons.</p>
     *
     *
     * @author     Daniel Retzl <danielretzl@gmail.com>
     * @copyright  2018 Daniel Retzl
     * @version    1.0.0
     * @brief Embed Twitter TweetButton
     */
    class twitterTweetButton extends \YAWK\widget
    {
        /** @param object global widget object data */
        public $widget = '';
        /** @param string Title that will be shown above widget */
        public $twitterTweetButtonHeading = '';
        /** @param string Subtext will be displayed beside title */
        public $twitterTweetButtonSubtext = '';
        /** @param string Text */
        public $twitterTweetButtonText = "";

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
         * @brief Init Twitter TweetButton Widget
         * @brief Embed a single TweetButton from twitter
         */
        public function init()
        {   // display heading
            echo $this->getHeading($this->twitterTweetButtonHeading, $this->twitterTweetButtonSubtext);
            //
            $this->twitterTweetButtonText = rawurldecode($this->twitterTweetButtonText);

            echo "<a class=\"twitter-share-button btn btn-info\"
               href=\"https://twitter.com/intent/tweet?text=$this->twitterTweetButtonText\"
               data-size=\"large\">Tweet about that</a>";
        }
    }
}
