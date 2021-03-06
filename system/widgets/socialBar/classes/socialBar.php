<?php
namespace YAWK\WIDGETS\SOCIALBAR\DISPLAY
{
    /**
     * <b>Social Bar - display icons with links to your social network accounts</b>
     *
     * <p>Embed Links to Twitter, Facebook, Instagram, Pinterest, YouTube and more.
     * You can set any font awesome icon (or any other icon set that you have loaded
     * in the assets section before). If a link is set, the corresponding icon will
     * be drawn.</p>
     *
     * @package    YAWK
     * @author     Daniel Retzl <danielretzl@gmail.com>
     * @copyright  2018 Daniel Retzl
     * @license    https://opensource.org/licenses/MIT
     * @version    1.0.0
     * @link       http://yawk.io
     * @annotation Social Bar display icons with links to your social network accounts
     */
    class socialBar extends \YAWK\widget
    {
        /** @var object global widget object data */
        public $widget = '';
        /** @var string Title that will be shown above widget */
        public $socialBarHeading = '';
        /** @var string Subtext will be displayed beside title */
        public $socialBarSubtext = '';
        /** @var string Facebook URL */
        public $socialBarFacebookUrl = '';
        /** @var string YouTube URL */
        public $socialBarYouTubeUrl = '';
        /** @var string Instagram URL */
        public $socialBarInstagramUrl = '';
        /** @var string Pinterest URL */
        public $socialBarPinterestUrl = '';
        /** @var string Twitter URL */
        public $socialBarTwitterUrl = '';
        /** @var string Tumblr URL */
        public $socialBarTumblrUrl = '';
        /** @var string LinkedIn URL */
        public $socialBarLinkedInUrl = '';
        /** @var string Xing URL */
        public $socialBarXingUrl = '';
        /** @var string Google Plus URL */
        public $socialBarGooglePlusUrl = '';
        /** @var string Facebook Icon */
        public $socialBarFacebookIcon = '';
        /** @var string YouTube Icon */
        public $socialBarYouTubeIcon = '';
        /** @var string Instagram Icon */
        public $socialBarInstagramIcon = '';
        /** @var string Pinterest Icon */
        public $socialBarPinterestIcon = '';
        /** @var string Twitter Icon */
        public $socialBarTwitterIcon = '';
        /** @var string Tumblr Icon */
        public $socialBarTumblrIcon = '';
        /** @var string LinkedIn Icon */
        public $socialBarLinkedInIcon = '';
        /** @var string Xing Icon */
        public $socialBarXingIcon = '';
        /** @var string Google Plus Icon */
        public $socialBarGooglePlusIcon = '';
        /** @var string Social Bar Html Markup */
        public $socialBarMarkup = '';
        /** @var string Social Bar Link Target */
        public $socialBarLinkTarget = '';
        /** @var string Social Bar Link Target */
        public $socialBarLinkTitle = '';
        /** @var string Social Bar Link Color */
        public $socialBarLinkColor = '';
        /** @var array Social Bar Elements */
        public $socialBarElements = '';
        /** @var string Social Bar Size */
        public $socialBarSize = 'H2';
        /** @var string Social Bar Alignment (horizontal or vertical */
        public $socialBarAlign = 'horizontal';
        /** @var string Social Bar CSS Class */
        public $socialBarClass = '';

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
         * Init example widget and call a function for demo purpose
         * @author Daniel Retzl <danielretzl@gmail.com>
         * @version 1.0.0
         * @link http://yawk.io
         * @annotation Example Widget Init
         */
        public function init()
        {   // call any function or method you have previously defined in this class
            echo $this->getHeading($this->socialBarHeading, $this->socialBarSubtext);
            $this->setSocialBarElements();
            $this->drawSocialBar();

        }

        /**
         * Set an array with all social button elements
         * @author Daniel Retzl <danielretzl@gmail.com>
         * @version 1.0.0
         * @link http://yawk.io
         * @annotation Helper function that set an array with all social elements. Need to be called before drawSocialBar();
         */
        public function setSocialBarElements()
        {   // for every widget data setting create an element with data
            foreach ($this->widget->data AS $element => $data)
            {   // if element is a URL
                if (strpos($element, 'Url'))
                {   // get name of this social element
                    $substring = substr("$element", 9);
                    $substring = substr("$substring", 0, -3);
                    // store url property in array
                    $this->socialBarElements[$substring]['url'] = $data;
                }
                // if element is an icon
                else if (strpos($element, 'Icon'))
                {   // get name of this social element
                    $substring = substr("$element", 9);
                    $substring = substr("$substring", 0, -4);
                    // store icon property in array
                    $this->socialBarElements[$substring]['icon'] = $data;
                }
                // if element is a color
                else if (strpos($element, 'Color'))
                {   // get name of this social element
                    $substring = substr("$element", 9);
                    $substring = substr("$substring", 0, -5);
                    // store icon property in array
                    $this->socialBarElements[$substring]['color'] = $data;
                }
            }
            // check if social array is set and not empty
            if (is_array($this->socialBarElements) && (!empty($this->socialBarElements)))
            {   // all good, return social bar data array
                return $this->socialBarElements;
            }
            else
                {   // no data here
                    return false;
                }
        }

        /**
         * Filter and sanitize any socialBar URL
         * @author Daniel Retzl <danielretzl@gmail.com>
         * @version 1.0.0
         * @link http://yawk.io
         * @annotation filter, sanitize and strip tags from URLs
         */
        public function filterUrl($url)
        {   // check if url is set and not empty
            if (isset($url) && (!empty($url)))
            {
                // remove illegal chars from url
                $url = filter_var($url, FILTER_SANITIZE_URL);
                // strip html tags
                $url = strip_tags($url);
                return $url;
            }
            else
                {   // nothing to return
                    return null;
                }
        }

        /**
         * Draw social bar
         * @author Daniel Retzl <danielretzl@gmail.com>
         * @version 1.0.0
         * @link http://yawk.io
         * @annotation Set settings and draw social bar
         */
        public function drawSocialBar()
        {
            // check if social bar elements array is set
            if (isset($this->socialBarElements) && (is_array($this->socialBarElements)))
            {   // walk through elements
                echo "<div class=\"row\">";
                echo "<div class=\"col-md-12\">";
                // markup <H2, H3, H4, P... start>
                echo "<".$this->socialBarSize.">";
                foreach ($this->socialBarElements AS $element => $data)
                {   // only if url is set...
                    if (!empty($data['url']))
                    {
                        // filter url before output
                        $data['url'] = $this->filterUrl($data['url']);

                        // check if color is set
                        if (isset($data['color']) && (!empty($data['color'])))
                        {   // set css style tag
                            $this->socialBarLinkColor = " style=\"color:#$data[color];\"";
                        }
                        else
                        {   // no link color - no css markup
                            $this->socialBarLinkColor = '';
                        }

                        // set title
                        if (isset($this->socialBarLinkTitle) && (!empty($this->socialBarLinkTitle)))
                        {
                            $title = " title=\"".$this->socialBarLinkTitle." $element\"";
                        }
                        else
                        {
                            $title = '';
                        }

                        // check alignment
                        if (isset($this->socialBarAlign) && (!empty($this->socialBarAlign)))
                        {   // if alignment is set to vertical
                            if ($this->socialBarAlign === 'vertical')
                            {   // generate linebreak markup
                                $lineBreak = "<br>";
                            }
                            else
                                {   // no linebreak, two blank spaces instead
                                    $lineBreak = '&nbsp;&nbsp;';
                                }
                        }
                        else
                            {   // no alignment set - two blank spaces are default
                                $lineBreak = '&nbsp;&nbsp;';
                            }

                        // check if icon is set
                        if (isset($data['icon']) && (!empty($data['icon'])))
                        {
                            // check social bar element class
                            if (isset($this->socialBarClass) && (!empty($this->socialBarClass)))
                            {   // set css class for this element
                                $cssClass = " ".$this->socialBarClass."";
                            }
                            else
                            {   // no class required, leave empty
                                $cssClass = '';
                            }

                            // draw social button
                            echo "<a href=\"$data[url]\"".$this->socialBarLinkColor."$title target=\"$this->socialBarLinkTarget\"><i class=\"$data[icon]".$cssClass."\"></i></a>".$lineBreak."";
                        }
                        else
                            {
                                // check social bar element class
                                if (isset($this->socialBarClass) && (!empty($this->socialBarClass)))
                                {   // set css class for this element
                                    $cssClass = " class=\"".$this->socialBarClass."\"";
                                }
                                else
                                {   // no class required, leave empty
                                    $cssClass = '';
                                }

                                // draw textlink
                                echo "<a href=\"$data[url]\" title=\"$this->socialBarLinkTitle\" target=\"$this->socialBarLinkTarget\"".$cssClass.">$data[url]</a>".$lineBreak."";
                            }
                    }
                }
                echo "</".$this->socialBarSize.">";
                echo "</div>";
                echo "</div>";
            }
        }
    }
}
?>