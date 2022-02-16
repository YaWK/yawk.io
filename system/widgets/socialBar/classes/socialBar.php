<?php
namespace YAWK\WIDGETS\SOCIALBAR\DISPLAY
{
    /**
     * @details<b>Social Bar - display icons with links to your social network accounts</b>
     *
     * <p>Embed Links to Twitter, Facebook, Instagram, Pinterest, YouTube and more.
     * You can set any font awesome icon (or any other icon set that you have loaded
     * in the assets section before). If a link is set, the corresponding icon will
     * be drawn.</p>
     *
     *
     * @author     Daniel Retzl <danielretzl@gmail.com>
     * @copyright  2018 Daniel Retzl
     * @version    1.0.0
     * @brief Social Bar display icons with links to your social network accounts
     */
    class socialBar extends \YAWK\widget
    {
        /** @param object global widget object data */
        public $widget = '';
        /** @param string Title that will be shown above widget */
        public $socialBarHeading = '';
        /** @param string Subtext will be displayed beside title */
        public $socialBarSubtext = '';
        /** @param string Facebook URL */
        public $socialBarFacebookUrl = '';
        /** @param string YouTube URL */
        public $socialBarYouTubeUrl = '';
        /** @param string Instagram URL */
        public $socialBarInstagramUrl = '';
        /** @param string Pinterest URL */
        public $socialBarPinterestUrl = '';
        /** @param string Twitter URL */
        public $socialBarTwitterUrl = '';
        /** @param string Tumblr URL */
        public $socialBarTumblrUrl = '';
        /** @param string LinkedIn URL */
        public $socialBarLinkedInUrl = '';
        /** @param string Xing URL */
        public $socialBarXingUrl = '';
        /** @param string Google Plus URL */
        public $socialBarGooglePlusUrl = '';
        /** @param string Facebook Icon */
        public $socialBarFacebookIcon = '';
        /** @param string YouTube Icon */
        public $socialBarYouTubeIcon = '';
        /** @param string Instagram Icon */
        public $socialBarInstagramIcon = '';
        /** @param string Pinterest Icon */
        public $socialBarPinterestIcon = '';
        /** @param string Twitter Icon */
        public $socialBarTwitterIcon = '';
        /** @param string Tumblr Icon */
        public $socialBarTumblrIcon = '';
        /** @param string LinkedIn Icon */
        public $socialBarLinkedInIcon = '';
        /** @param string Xing Icon */
        public $socialBarXingIcon = '';
        /** @param string Google Plus Icon */
        public $socialBarGooglePlusIcon = '';
        /** @param string Social Bar Html Markup */
        public $socialBarMarkup = '';
        /** @param string Social Bar Link Target */
        public $socialBarLinkTarget = '';
        /** @param string Social Bar Link Target */
        public $socialBarLinkTitle = '';
        /** @param string Social Bar Link Color */
        public $socialBarLinkColor = '';
        /** @param array Social Bar Elements */
        public $socialBarElements = '';
        /** @param string Social Bar Size */
        public $socialBarSize = 'H2';
        /** @param string Social Bar Alignment (horizontal or vertical */
        public $socialBarAlign = 'horizontal';
        /** @param string Social Bar CSS Class */
        public $socialBarClass = '';

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
         * @brief Init example widget and call a function for demo purpose
         * @brief Example Widget Init
         */
        public function init()
        {   // call any function or method you have previously defined in this class
            echo $this->getHeading($this->socialBarHeading, $this->socialBarSubtext);
            $this->setSocialBarElements();
            $this->drawSocialBar();

        }

        /**
         * @brief Set an array with all social button elements
         * @brief Helper function that set an array with all social elements. Need to be called before drawSocialBar();
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
         * @brief Filter and sanitize any socialBar URL
         * @brief filter, sanitize and strip tags from URLs
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
         * @brief Draw social bar
         * @brief Set settings and draw social bar
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