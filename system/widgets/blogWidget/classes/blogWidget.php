<?php
namespace YAWK\WIDGETS\BLOG\WIDGET {
    /**
     * <b>Embed plugin: blog</b>
     *
     * <p>This is the widget to the blog plugin. With this widget you can embed any blog that you
     * you've created before using the blog plugin. Simply set the ID of the blog you would like
     * to embed, setup your settings, choose the position and page where you like to display your
     * blog and you're good to go. </p>
     *
     * @package    YAWK
     * @author     Daniel Retzl <danielretzl@gmail.com>
     * @copyright  2019 Daniel Retzl
     * @license    https://opensource.org/licenses/MIT
     * @version    1.0.0
     * @link       http://yawk.io
     * @annotation Embed a blog on your website.
     */
    class blogWidget extends \YAWK\widget
    {
        /** @var object global widget object data */
        public $widget = '';
        /** @var int Gallery ID */
        public $blogID = '';
        /** @var string Title that will be shown above widget */
        public $blogHeading = '';
        /** @var string Subtext will be displayed beside title */
        public $blogSubtext = '';
        /** @var int Limit Entries (if 0 all items will be displayed)
         * This can overrule the global blog setting and has only impact
         * to the specific blog widget */
        public $blogLimitEntries = '';

        // for more specific settings take a look at the blog plugin

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
         * Init Gallery and load methods
         * @author Daniel Retzl <danielretzl@gmail.com>
         * @version 1.0.0
         * @link http://yawk.io
         * @annotation load Javascript and draw image gallery
         */
        public function init($db)
        {
            // $this->printObject();
            $this->drawBlogWidget($db);
        }


        /**
         * Draw the blog
         * @author Daniel Retzl <danielretzl@gmail.com>
         * @version 1.0.0
         * @link http://yawk.io
         * @param db object Database object
         * @annotation (for development and testing purpose)
         */
        public function drawBlogWidget($db)
        {
            /** @var $db \YAWK\db * */
            error_reporting(1);
            if (!isset($this->blogID) || (empty($this->blogID)))
            {
                echo "Error: unable to load blog because there was no blog ID given.";
            }
            else
                {   // include blog plugin base class
                    require_once 'system/plugins/blog/classes/blog.php';

            // include required JS files
            /* echo "<script type=\"text/javascript\" src=\"../../../plugins/blog/js/comments.js\"></script>
                  <script type=\"text/javascript\" src=\"../../../plugins/blog/js/voting.js\"></script>";
            */


                /*
                 * FRONTEND BLOG PAGE
                 */
                // create new blog object
                $blog = new \YAWK\PLUGINS\BLOG\blog();

                /* a blog can be called by GET variable or via page include */
                // assign blog ID
                $blog->blogid = $this->blogID;

                // load global blog settings
                $blog->loadBlogProperties($db, $blog->blogid);

                // for debug purpose
                // print_r($blog);

                /* get templateID */
                $templateID = \YAWK\template::getCurrentTemplateId($db);

                // if blog is not offline, get entries from db + draw it on screen.
                if ($blog->published != 0) {
                    /** @var $widget \YAWK\widget */
                    // get headline
                    $this->headline = $this->getHeading($this->blogHeading, $this->blogSubtext);

                    if (!isset($blog->itemid)) {
                        $blog->itemid = 0;
                    }

                    // load blog title
                    $blog->getTitle($db, $blog->blogid);

                    // check if full view is set
                    if (!isset($full_view)) {
                        $full_view = 0;
                    }

                    // load the blog entries into blog object
                    $blog->getFrontendEntries($db, $blog->blogid, $blog->itemid, $full_view, $this->blogLimitEntries);
                    // check footer setting and load it on demand
                    // if ($blog->getBlogProperty($db, $blog->blogid, "footer")) {
                    //     $blog->getFooter($db);
                    // }
                    // finally: draw the blog
                    print $blog->draw();
                    print "</div>";
                }
                else
                    {   // blog is not published, draw message
                        echo \YAWK\alert::draw("warning", "Entschuldigung!", "Dieser Bereich ist im Moment offline, da gerade daran gearbeitet wird. Bitte komm sp&auml;ter wieder.", "", "4800");
                    }
            }
        }
    }
}
?>