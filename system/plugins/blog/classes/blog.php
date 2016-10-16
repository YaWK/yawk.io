<?php
namespace YAWK\PLUGINS\BLOG {
    /**
     * <b>Start blogging today! Very powerful app to create and manage any kind of blog.</b>
     *
     * The Blog Plugin is very useful if you want to build anything that is or acts actually like
     * blog. A bunch of pre-defined layouts are there to help you building a clean view to make
     * your articles good looking. A Blog got a title, subtitle, teaser text, longer text, an image
     * according left or right to the teaser text. It comes with a nice built in ajax-powered comment
     * feature. You can create many different blogs and much more entries. It is perfect to build up
     * a dynamic website. Blogs, articles, user comments and blog settings can be comfortably managed in
     * a beautiful Backend. It is part of YaWK and integrates seamless.<br><br>
     * There are four major layouts:<ul>
     * <li>1 col, default text blog</li>
     * <li>2 col, with preview image on the left</li>
     * <li>2 col, with preview image on the right</li>
     * <li>3 col, basic newspaper style</li></ul>
     * <br>
     * Create as many blogs as you want to, gain user rights to blogs and / or to any single item.
     * Let users write down comments on every item. Comments can be turned on and off. There are many
     * settings available to sort content, show up a title and subline (or not) and much more. It is a
     * perfect choice to present content and -if needed- interact with users. You can manage everything
     * in a beautiful Backend with the typically YaWK-styled performant table design. Be sure to check
     * out the Blog's Docs on our website or watch our blog screenscast for further information!
     *
     * <p><i>This class covers both, backend + frontend functionality.
     * See Methods Summary for Details!</i></p>
     *
     * @category   CMS
     * @package    System
     * @global     $connection
     * @global     $dbprefix
     * @author     Daniel Retzl <danielretzl@gmail.com>
     * @copyright  2009-2015 Daniel Retzl yawk.goodconnect.net
     * @license    http://www.gnu.org/licenses/gpl-2.0  GNU/GPL 2.0
     * @version    0.0.2
     * @link       http://yawk.goodconnect.net/
     * @since      File available since Release 0.1.8
     * @annotation Handles the Plugin System.
     */
    class blog
    {
        /* init vars
         * @set public
         * doc
         */
        public $id;
        public $html;
        public $html_ext;
        public $blogid;
        public $itemid;
        public $itemgid;
        public $category;
        public $title;
        public $filename;
        public $blogtitle;
        public $name;
        public $published;
        public $content;
        public $date_publish;
        public $date_changed;
        public $date_unpublish;
        public $description;
        public $subtitle;
        public $date_created;
        public $year_created;
        public $teasertext;
        public $blogtext;
        public $author;
        public $author_vis;
        public $comment_date;
        public $comment_author;
        public $comment_email;
        public $comment_text;
        public $showTitle;
        public $showDesc;
        public $showDate;
        public $showAuthor;
        public $sequence;
        public $sortation;
        public $icon;
        public $permaLink;
        public $layout;
        public $comments;
        public $thumbnail;
        public $alias;
        public $sort;
        public $gid;
        public $pageid;
        public $preview;
        public $voting;
        public $youtubeUrl;
        public $weblink;


        /**
         * Print blog title
         * @author Daniel Retzl <danielretzl@gmail.com>
         * @version 1.0.0
         * @link http://yawk.io
         * @param string $title Blog Title
         * @param string $subtext Blog SubTitle
         * @param string $icon Font Awesome Icon e.g. fa fa-globe
         * @return null
         */
        static function getBlogTitle($title, $subtext, $icon)
        {   // draw title
            if ($title && $subtext && $icon)
            {   // draw title with icon
                print "<h1><i class=\"fa " . $icon . "\"></i> " . $title . "&nbsp;<small>" . $subtext . "</small></h1>";
            }
            else if (empty($icon))
            {   // draw title without icon
                print "<h1>" . $title . "&nbsp;<small>" . $subtext . "</small></h1>";
            }
            return null;
        }


        /**
         * Print the latest blog subtitle from
         * @author Daniel Retzl <danielretzl@gmail.com>
         * @version 1.0.0
         * @link http://yawk.io
         * @param object $db Database Object
         * @param int $blogid The blog id of the subtitle to get
         * @return mixed mixed|bool
         */
        static function getLatestEntrySubtitle($db, $blogid)
        {   /** @var $db \YAWK\db */
            if ($res = $db->query("SELECT subtitle FROM {blog_items} WHERE blogid = " . $blogid . " ORDER BY id DESC LIMIT 1")) {   // fetch data
                if ($result = mysqli_fetch_row($res)) {   // success
                    return $res[0];
                } else {   // fetch failed
                    return false;
                }
            } else {   // q failed
                return false;
            }
        }

        /**
         * Get the blog title
         * @author Daniel Retzl <danielretzl@gmail.com>
         * @version 1.0.0
         * @link http://yawk.io
         * @param object $db Database Object
         * @param int $blogid The blog id of the title to get
         * @return null
         */
        static function getTitle($db, $blogid)
        {   /** @var $db \YAWK\db */
            // get blog title settings from database
            $showTitle = self::getBlogProperty($db, $blogid, "showtitle");
            $showDesc = self::getBlogProperty($db, $blogid, "showdesc");
            $description = self::getBlogProperty($db, $blogid, "description");
            $name = self::getBlogProperty($db, $blogid, "name");
            $icon = self::getBlogProperty($db, $blogid, "icon");

            if (!empty($icon)) {   // set font awesome icon
                $icon = "<i class=\"fa $icon\"\"></i>";
            } else {   // set no icon
                $icon = '';
            }

            if ($showTitle && $showDesc === '1') {   // show title AND description
                echo "<h1>$icon &nbsp;$name <small>$description</small></h1>";
            }
            else if ($showTitle === '1' && $showDesc === '0') {   // just title
                echo "<h1>$icon &nbsp;$name</h1>";
            }
            else if ($showTitle === '0' && $showDesc === '1') {   // just show description
                echo "<h1>$icon $description</h1>";
            }
            return null;
        }

        /**
         * Toggle a whole blog on/offline
         * @author Daniel Retzl <danielretzl@gmail.com>
         * @version 1.0.0
         * @link http://yawk.io
         * @param object $db Database Object
         * @param int $id The blog id of the blog to toggle
         * @param int $published The publish status 0|1
         * @return bool
         */
        function toggleOffline($db, $id, $published)
        {
            /** @var $db \YAWK\db */
            // TOGGLE BLOG STATUS
            if ($res = $db->query("UPDATE {blog}
                          SET published = '" . $published . "'
                          WHERE id = '" . $id . "'")
            ) {   // success
                return true;
            } else {   // q failed
                return true;
            }
        }

        /**
         * Toggle a single blog item (entry) on/offline
         * @author Daniel Retzl <danielretzl@gmail.com>
         * @version 1.0.0
         * @link http://yawk.io
         * @param object $db Database Object
         * @param int $id The id of the blog item to toggle
         * @param int $published The publish status 0|1
         * @return bool
         */
        function toggleItemOffline($db, $id, $published)
        {
            /** @var $db \YAWK\db */
            // TOGGLE ITEM STATUS
            if ($res = $db->query("UPDATE {blog_items}
                          SET published = '" . $published . "'
                          WHERE id = '" . $id . "'")
            ) {   // success
                return true;
            } else {   // q failed
                return false;
            }
        }

        /**
         * Toggle a blog comment on/offline
         * @author Daniel Retzl <danielretzl@gmail.com>
         * @version 1.0.0
         * @link http://yawk.io
         * @param object $db Database Object
         * @param int $id The id of the comment to toggle
         * @param int $published The publish status 0|1
         * @return bool
         */
        function toggleCommentOffline($db, $id, $published)
        {
            /** @var $db \YAWK\db */
            // TOGGLE ITEM STATUS
            if ($res = $db->query("UPDATE {blog_comments}
                          SET published = '" . $published . "'
                          WHERE id = '" . $id . "'")
            ) {   // success
                return true;
            } else {   // q failed
                return false;
            }
        }

        /**
         * Toggle a the group id (role) of blog item
         * @author Daniel Retzl <danielretzl@gmail.com>
         * @version 1.0.0
         * @link http://yawk.io
         * @param object $db Database Object
         * @param int $itemgid The new group id for the blog item
         * @param int $id The id of the blog item to set
         * @param int $bllgid ??
         * @return bool
         */
        function toggleRole($db, $itemgid, $id, $blogid)
        {
            /** @var $db \YAWK\db */
            // TOGGLE ITEM STATUS
            if ($res = $db->query("UPDATE {blog_items}
                          SET itemgid = '" . $itemgid . "'
                          WHERE id = '" . $id . "'")
            ) {   // success
                return true;
            } else {   // q failed
                return false;
            }
        }

        /**
         * This get all blog entries from database, prepare layout and draw them onscreen (frontend).
         * @author Daniel Retzl <danielretzl@gmail.com>
         * @version 1.0.0
         * @link http://yawk.io
         * @param object $db Database Object
         * @param int $blogid The id of the blog to get entries from
         * @param int $itemid The item id to get, if a single entry is wanted
         * @param int $full_view Should the blog be loaded without a preview, in full mode as default? 0|1
         * @param int $limit Number of entries to get from database.
         * @return null
         */
        function getFrontendEntries($db, $blogid, $itemid, $full_view, $limit)
        {
            /** @var $db \YAWK\db */
            // if no itemid is set, set the sql code for all items, vice versa.
            if ($itemid != 0) $sql = "AND id = '$itemid'"; else $sql = '';
            // get settings (frontend view)
            $frontendShowDate = self::getBlogProperty($db, $blogid, "showdate");
            $frontendShowAuthor = self::getBlogProperty($db, $blogid, "showauthor");
            $frontendSequence = self::getBlogProperty($db, $blogid, "sequence");
            $frontendSortation = self::getBlogProperty($db, $blogid, "sortation");
            $frontendPreview = self::getBlogProperty($db, $blogid, "preview");
            $frontendVoting = self::getBlogProperty($db, $blogid, "voting");
            $frontendIcon = self::getBlogProperty($db, $blogid, "icon");
            $blog_gid = self::getBlogProperty($db, $blogid, "gid");
            // ORDER BY
            if ($frontendSequence === '0') {
                $this->sequence = "date_publish";
            } else if ($frontendSequence === '1') {
                $this->sequence = "title";
            }
            // SORT
            if ($frontendSortation === '0') {
                $this->sortation = "ASC";
            } else if ($frontendSortation === '1') {
                $this->sortation = "DESC";
            }

            if ($limit != 0) {
                $limitSql = "LIMIT $limit";
            } else {
                $limitSql = '';
            }

            // select settings for given blog id
            $res = $db->query("SELECT * FROM {blog_items}
                                         WHERE blogid = '$blogid' " . $sql . "
                                         AND published = '1'
                                         ORDER BY " . $this->sequence . " " . $this->sortation . "
                                         $limitSql");
            // fetch data in loop
            while ($row = mysqli_fetch_array($res)) {   // set blog item properties
                $this->itemid = $row['id'];
                $this->uid = $row['uid'];
                $this->gid = $row['uid'];
                $this->pageid = $row['pageid'];
                $this->title = $row['title'];
                $this->subtitle = $row['subtitle'];
                $this->teasertext = $row['teasertext'];
                $this->blogtext = $row['blogtext'];
                $this->gid = $row['itemgid'];
                $this->date_publish = $row['date_publish'];
                $this->date_unpublish = $row['date_unpublish'];
                $this->date_created = $row['date_created'];
                $this->date_changed = $row['date_changed'];
                $this->author = $row['author'];
                $this->blogid = $row['blogid'];
                $this->thumbnail = $row['thumbnail'];
                $this->youtubeUrl = $row['youtubeUrl'];
                $this->weblink = $row['weblink'];
                $this->voteUp = $row['voteUp'];
                $this->voteDown = $row['voteDown'];
                // settings for blog_item are set,
                // now get properties of that BLOG (general blog settings)
                $this->permaLink = $this->getBlogProperty($db, $this->blogid, "permaLink");
                $this->layout = $this->getBlogProperty($db, $this->blogid, "layout");
                $this->comments = $this->getBlogProperty($db, $this->blogid, "comments");


                if ($frontendShowDate === '1') {   // show date of this entry
                    /* date string to array function */
                    $splitDate = \YAWK\sys::splitDate($this->date_publish);
                    /* set seperated vars */
                    $year = $splitDate['year'];
                    $day = $splitDate['day'];
                    $month = $splitDate['month'];
                    $time = $splitDate['time'];

                    // get weekday from datetime
                    $weekday = \YAWK\sys::getWeekday($this->date_publish);

                    // build a prettydate
                    $prettydate = "$weekday, $day. $month $year, $time";
                    $prettydate = trim($prettydate);
                } else {   // display no date
                    $prettydate = '';
                }

                if ($this->permaLink === '1') {   // show permalink of this entry
                    $host = \YAWK\settings::getSetting($db, "host");
                    $page = new \YAWK\page();
                    $alias = $page->getProperty($db, $this->pageid, "alias");
                    $this->permaLink = "share this URL: <a href=\"$host/$alias.html\">$host/$alias.html</a>";
                } else {   // no permalink
                    $page = new \YAWK\page();
                    $alias = $page->getProperty($db, $this->pageid, "alias");
                    $this->permaLink = '';
                }

                if ($frontendShowAuthor === '1') {   //  show author of this entry
                    $author = "by <strong>$this->author</strong>";
                } else {   // do not display author
                    $author = '';
                }

                if ($frontendVoting === '1') {   // show voting box
                    $voting = self::drawVotingBox($db, $this->voteUp, $this->voteDown);
                } else {   // no voting
                    $voting = '';
                }

                // current date + time
                $atm = date("Y-m-d G:i:s");

                // check publish date and show entry
                if ($atm < $this->date_publish) {
                    $this->html .= "";
                }
                if (isset($_SESSION['gid'])) {
                    $session_gid = $_SESSION['gid'];
                } else {
                    $session_gid = 1;
                }
                // check if content is outdated
                if ($this->date_unpublish < $atm XOR $this->date_unpublish === "0000-00-00 00:00:00") {
                    $this->html .= ""; // do nothing
                } // check publish date and show entry
                else if ($atm > $this->date_publish && $session_gid >= $this->gid && $session_gid >= $blog_gid) {
                    // publish datetime is behind us, so display the blog
                    // 1.) check & get settings, 2. check layouts, 3. draw

                    // check & build vars for single entry FULL view
                    if (isset($full_view) && ($full_view === 1)) {
                        $blogtextHtml = $this->blogtext;
                        $showAllButton = '';
                    } else {
                        if ($frontendPreview === '0') {
                            $showAllButton = "<a class='btn btn-default' role='button' href=\"$alias.html\"><i class='fa fa-bars'></i> &nbsp;alles anzeigen</a>";
                        } else {
                            $showAllButton = '';
                        }
                        $blogtextHtml = '';
                    }

                    // check & set the different layouts
                    // LAYOUT 0 = 1 col, TEXT BLOG
                    // LAYOUT 1 = 2 col, IMG PREVIEW LEFT
                    // LAYOUT 2 = 2 col, IMG PREVIEW RIGHT
                    // LAYOUT 3 = 1 col, NEWSPAPER STYLE
                    // LAYOUT 4 = 1 col, YOUTUBE RESPONSIVE BLOG

                    if ($this->layout === '0') {   // LAYOUT 0 = 1 col, default text blog
                        $this->html .= "<br><small class=\"pull-right\"><i>$this->permaLink$prettydate " . $author . "</i></small>";
                        $this->html .= "<h2>$this->title&nbsp;<small>$this->subtitle</small></h2>$this->teasertext" . $blogtextHtml . "";
                        // are comments enabled?
                        if ($this->comments !== '0') {
                            if (isset($full_view) && ($full_view === 1)) {   // full view, display comments
                                $this->html .= self::draw_commentbox($db);
                            } else {   // display btn with link to the full view
                                $this->html .= "<a class='btn btn-default' role='button' href=\"$alias.html\"><i class='fa fa-bars'></i> &nbsp;anzeigen</a><br><br><br>";
                            }
                        } else {   // no comments, show all button
                            $this->html .= $showAllButton;
                        }
                        $this->html .= "<hr>";
                    }

                    if ($this->layout === '1') {   // LAYOUT 1 = 2 cols, left thumbnail
                        if (!empty($this->thumbnail)) $imgHtml = "<img src=\"" . $this->thumbnail . "\" class=\"img-thumbnail img-lefty-less protected\">"; else $imgHtml = '';
                        $this->html .= "
                        <div class=\"row\">
                            <div class=\"col-md-4 text-center\">
                                <br>$imgHtml
                            </div>
                            <div class=\"col-md-8\">
                            <small class=\"pull-right\"><i>$this->permaLink$prettydate $author</i></small>
                            <h2>$this->title&nbsp;<small>$this->subtitle</small></h2>$this->teasertext" . $blogtextHtml . "";
                        // are comments enabled?
                        if ($this->comments !== '0') {
                            if (isset($full_view) && ($full_view === 1)) {  // full view, display comments
                                $this->html .= self::draw_commentbox($db);
                            } else {   // display btn with link to the full view
                                $this->html .= "<a class='btn btn-default' href=\"$alias.html\"><i class='fa fa-bars'></i> &nbsp;anzeigen</a><br><br><br>";
                            }
                        } else {   // no comments, show all button
                            $this->html .= $showAllButton;
                        }
                        $this->html .= "</div>
                        </div>";
                    }

                    if ($this->layout === '2') {   // LAYOUT 2 = 2 cols, right thumbnail
                        if (!empty($this->thumbnail)) $imgHtml = "<img src=\"" . $this->thumbnail . "\" class=\"thumbnail img-responsive\">"; else $imgHtml = '';
                        $this->html .= "
                    <div class=\"row\">
                      <div class=\"col-xs-12 col-md-8\">
                      <small class=\"pull-right\"><i>$this->permaLink$prettydate $author</i></small>
                       <h2>$this->title&nbsp;<small>$this->subtitle</small></h2>$this->teasertext" . $blogtextHtml . "";
                        // are comments enabled?
                        if ($this->comments !== '0') {
                            if (isset($full_view) && ($full_view === 1)) {
                                $this->html .= self::draw_commentbox($db);
                            } else {
                                $this->html .= "<a class='btn btn-info' href=\"$alias.html\"><i class='fa fa-bars'></i> &nbsp;anzeigen</a><br><br>";
                            }
                        } else {
                            $this->html .= $showAllButton;
                        }
                        $this->html .= "<hr></div>
                      <div class=\"col-xs-6 col-md-4\">
                      <br>$imgHtml </div>

                 </div>";
                    }
                    if ($this->layout === '3') {   // LAYOUT 3 = 3 cols, newspaper layout
                        if (!empty($this->thumbnail)) $imgHtml = "<img src=\"" . $this->thumbnail . "\" class=\"thumbnail img-responsive\">"; else $imgHtml = '';
                        $this->html .= "<div class=\"row\">
                  <div class=\"col-xs-6 col-md-4\"><br>advertising space</div>
                  <div class=\"col-xs-6 col-md-4\">
                   <small class=\"pull-right\"><i>$this->permaLink$prettydate $author</i></small>
                  <h2>$this->title&nbsp;<small>$this->subtitle</small></h2>$imgHtml $this->teasertext" . $blogtextHtml . "<hr>
                  ";
                        // are comments enabled?
                        if ($this->comments !== '0') {
                            if (isset($full_view) && ($full_view === 1)) {
                                $this->html .= self::draw_commentbox($db);
                            } else {
                                $this->html .= "<a href=\"$alias.html\"><i class='btn btn-info'>comments anzeigen</i></a>";
                            }
                        } else {
                            $this->html .= $showAllButton;
                        }
                        $this->html .= "</div>
                  <div class=\"col-xs-6 col-md-4\"><br>advertising space
                    </div>
                </div>";
                    }
                    if ($this->layout === '4') {   // LAYOUT 4 = 1 col, youtube responsive blog
                        // cut of time from prettydate
                        $prettydate = substr($prettydate, 0, -7);
                        if (!empty($this->youtubeUrl)) {
                            $this->html .= "<small class=\"pull-right\"><i>$this->permaLink$prettydate $author</i></small>";
                            $this->html .= "<h2>$this->title&nbsp;<small>$this->subtitle</small></h2>
                                            <div class=\"embed-container\">
                                              <iframe src=\"$this->youtubeUrl\" frameborder=\"0\" allowfullscreen></iframe>
                                            </div>";
                            $this->html .= "$this->teasertext";
                            $this->html .= "<br>$voting";
                            $this->html .= "$blogtextHtml";

                            // are comments enabled?
                            if ($this->comments !== '0') {
                                if (isset($full_view) && ($full_view === 1)) {
                                    $this->html .= self::draw_commentbox($db);
                                } else {
                                    $this->html .= "<a class='btn btn-default' role='button' href=\"$alias.html\"><i class='fa fa-bars'></i> &nbsp;anzeigen</a><br><br><br>";
                                }
                            } else {
                                $this->html .= $showAllButton;
                            }
                            $this->html .= "<hr>";
                        }
                    }
                }
            }
        }

    /**
    * +++ still in development +++ not for production use! - Draw a voting box (thumbs up/down)
    * @author Daniel Retzl <danielretzl@gmail.com>
    * @version 0.0.0
    * @link http://yawk.io
    * @param object $db Database Object
    * @param int $voteUp Vote up integer
    * @param int $voteDown Vote down integer
    * @return mixed Html voting box
    */
    function drawVotingBox($db, $voteUp, $voteDown)
    {
        /** @var $db \YAWK\db */
        $totalVotes = $voteUp + $voteDown;
        if ($totalVotes === 0) {
            $totalText = "<b>Noch keine Bewertungen. Sei der erste und vote!</b>";
        } else {
            $totalText = "<b>Votes insgesamt:</b> $totalVotes";
        }
        $votingBox = "<small>$totalText&nbsp;&nbsp;&nbsp;&nbsp;</small>
            <i class=\"fa fa-thumbs-o-up\" id=\"voteUp\" data-toggle=\"tooltip\" data-placement=\"top\" title=\"Gef&auml;llt mir\"></i>&nbsp;<small>($voteUp)</small>
            &nbsp; <i class=\"fa fa-thumbs-o-down\" id=\"voteDown\" data-toggle=\"tooltip\" data-placement=\"top\" title=\"Gef&auml;llt mir nicht\"></i>&nbsp;<small>($voteDown)</small><br>";
        return $votingBox;
    }

    /**
     * Get any blog property you want from given blogid.
     * Selection goes like this: "SELECT $property FROM {blog} WHERE id = $blogid
     *
     * @author Daniel Retzl <danielretzl@gmail.com>
     * @version 1.0.0
     * @link http://yawk.io
     * @param object $db Database Object
     * @param int $blogid The blog id of wich we want to get the settings
     * @param string $property The property to get
     * @return mixed|bool
    */
    function getBlogProperty($db, $blogid, $property)
    {
        /** @var $db \YAWK\db */
        if ($res = $db->query("SELECT $property FROM {blog} WHERE id = '" . $blogid . "'")) {   // fetch data
            if ($row = mysqli_fetch_row($res)) {   // success
                return $row['0'];
            } else {   // fetch failed
                return false;
            }
        } else {   // q failed
            return false;
        }
    }

    /**
     * Load properties for given blog id and store $this -> $blog properties
     *
     * @author Daniel Retzl <danielretzl@gmail.com>
     * @version 1.0.0
     * @link http://yawk.io
     * @param object $db Database Object
     * @param int $blogid The blog id of wich we want to load properties
     * @param string $property The property to get
     * @return bool
    */
    function loadBlogProperties($db, $blogid)
    {
        /** @var $db \YAWK\db */
        if ($res = $db->query("SELECT * FROM {blog} WHERE id = '" . $blogid . "'")) {   // fetch data
            if ($row = mysqli_fetch_array($res)) {   // set properties
                $this->id = $row['id'];
                $this->sort = $row['sort'];
                $this->published = $row['published'];
                $this->name = $row['name'];
                $this->description = $row['description'];
                $this->icon = $row['icon'];
                $this->showTitle = $row['showtitle'];
                $this->showDesc = $row['showdesc'];
                $this->showDate = $row['showdate'];
                $this->showAuthor = $row['showauthor'];
                $this->sequence = $row['sequence'];
                $this->sortation = $row['sortation'];
                $this->footer = $row['footer'];
                $this->comments = $row['commenta'];
                $this->gid = $row['gid'];
                $this->permaLink = $row['permalink'];
                $this->layout = $row['layout'];
                $this->preview = $row['preview'];
                $this->voting = $row['voting'];
                return true;
            } else {   // fetch failed
                return false;
            }
        } else {   // q failed
            return false;
        }
    }

    /**
     * Load properties for given blog item (entry) and store $this -> $blog properties
     *
     * @author Daniel Retzl <danielretzl@gmail.com>
     * @version 1.0.0
     * @link http://yawk.io
     * @param object $db Database Object
     * @param int $blogid The blog id of wich we want to load properties
     * @param int $itemid The item id of wich we want to load properties
     * @return bool
    */
    function loadItemProperties($db, $blogid, $itemid)
    {   /** @var $db \YAWK\db */
        if ($res = $db->query("SELECT * FROM {blog_items}
                        WHERE blogid = '" . $blogid . "'
                        AND id = '" . $itemid . "'"))
        {   // fetch data
            if ($row = mysqli_fetch_array($res)) {   // set blog ITEM properties
                $this->blogid = $row['blogid'];
                $this->itemid = $row['id'];
                $this->uid = $row['uid'];
                $this->pageid = $row['pageid'];
                $this->sort = $row['sort'];
                $this->published = $row['published'];
                $this->itemgid = $row['itemgid'];
                $this->blogtitle = $row['title'];
                $this->filename = $row['filename'];
                $this->subtitle = $row['subtitle'];
                $this->date_created = $row['date_created'];
                $this->date_changed = $row['date_changed'];
                $this->date_publish = $row['date_publish'];
                $this->date_unpublish = $row['date_unpublish'];
                $this->teasertext = $row['teasertext'];
                $this->blogtext = $row['blogtext'];
                $this->author = $row['author'];
                $this->thumbnail = $row['thumbnail'];
                $this->youtubeUrl = $row['youtubeUrl'];
                $this->weblink = $row['weblink'];
            }
            else
            {   // fetch failed
                return false;
            }
        }
        else
        {   // q failed
            return false;
        }
        return true;
    }

    /**
     * Save blog blog entry data. (See blog properties)
     *
     * @author Daniel Retzl <danielretzl@gmail.com>
     * @version 1.0.0
     * @link http://yawk.io
     * @param object $db Database Object
     * @return bool
    */
    function save($db)
    {
        /** @var $db \YAWK\db */
        $date_changed = date("Y-m-d G:i:s");
        $this->teasertext = stripslashes(str_replace('\r\n', '', $this->teasertext));
        /* alias string manipulation to generate a valid filename */
        $this->filename = mb_strtolower($this->filename); // lowercase
        $this->filename = str_replace(" ", "-", $this->filename); // replace all ' ' with -
        // special chars
        $umlaute = array("/ä/", "/ü/", "/ö/", "/Ä/", "/Ü/", "/Ö/", "/ß/"); // array of special chars
        $ersetze = array("ae", "ue", "oe", "ae", "ue", "oe", "ss"); // array of replacement chars
        $this->filename = preg_replace($umlaute, $ersetze, $this->filename);      // replace with preg
        $this->filename = preg_replace("/[^a-z0-9\-\/]/i", "", $this->filename); // final check: just numbers and chars are allowed

        // get filename from pages db
        $res = $db->query("SELECT alias FROM {pages} WHERE id = '" . $this->pageid . "'");
        $row = mysqli_fetch_row($res);
        $alias_old = $row[0];
        $filename_old = "../content/articles/" . $alias_old . ".php";
        $filename = "../content/articles/" . $this->filename . ".php";
        // set content of the plugin file
        $content = "<?php \$blog_id = $this->blogid; \$item_id = $this->itemid; \$full_view = 1; include 'system/plugins/blog/blog.php'; ?>";
        if (file_exists($filename_old)) {
            $handle = fopen($filename, "wr");
            $res = fwrite($handle, $content);
            fclose($handle);
            chmod($filename, 0777);
            if (!$res) {   // cannot write file, throw error
                \YAWK\alert::draw("danger", "Error", "could not write file: $filename", "", "4200");
            }
        } else {
            $handle = fopen($filename, "wr");
            $res = fwrite($handle, $content);
            fclose($handle);
            chmod($filename, 0777);
            if (!$res) {
                \YAWK\alert::draw("danger", "Error", "could not create file: $filename", "", "4200");
            }
        }
        // convert html special chars
        $this->teasertext = \YAWK\sys::encodeChars($this->teasertext);
        $this->blogtext = \YAWK\sys::encodeChars($this->blogtext);
        $this->title = htmlentities($this->title);
        $this->subtitle = htmlentities($this->subtitle);

        if ($res = $db->query("UPDATE {pages} SET
            alias = '" . $this->filename . "',
            title = '" . $this->blogtitle . "'
            WHERE id = '" . $this->pageid . "'"))
        {
            if ($res = $db->query("UPDATE {blog_items} SET
                    published = '" . $this->published . "',
                    sort = '" . $this->sort . "',
                    title = '" . $this->blogtitle . "',
                    filename = '" . $this->filename . "',
                    subtitle = '" . $this->subtitle . "',
                    date_changed = '" . $date_changed . "',
                    date_publish = '" . $this->date_publish . "',
                    date_unpublish = '" . $this->date_unpublish . "',
                    teasertext = '" . $this->teasertext . "',
                    blogtext = '" . $this->blogtext . "',
                    thumbnail = '" . $this->thumbnail . "',
                    youtubeUrl = '" . $this->youtubeUrl . "',
                    weblink = '" . $this->weblink . "'
                    WHERE id = '" . $this->itemid . "'
                    AND blogid = '" . $this->blogid . "'"))
            {   // success
                return true;
            }
            else
            {   // update blog items failed,
                return false;
            }
        }
        else
        {   // update pages failed, abort +
            return false;
        }
    }

    /**
     * Save blog settings data. (layout, general ettings, comment settings etc...)
     *
     * @author Daniel Retzl <danielretzl@gmail.com>
     * @version 1.0.0
     * @link http://yawk.io
     * @param object $db Database Object
     * @param int $blogid The blog id of wich we want to save properties
     * @param string $property The property to get
     * @return bool
    */
    function setup($db, $blogid)
    {
        /** @var $db \YAWK\db */
        // convert html special chars
        $this->name = htmlentities($this->name);
        $this->description = htmlentities($this->description);
        return $db->query("UPDATE {blog} SET
                    name = '" . $this->name . "',
                    description = '" . $this->description . "',
                    icon = '" . $this->icon . "',
                    showtitle = '" . $this->showTitle . "',
                    showdesc = '" . $this->showDesc . "',
                    showdate = '" . $this->showDate . "',
                    showauthor = '" . $this->showAuthor . "',
                    sequence = '" . $this->sequence . "',
                    sortation = '" . $this->sortation . "',
                    comments = '" . $this->comments . "',
                    permalink = '" . $this->permaLink . "',
                    preview = '" . $this->preview . "',
                    voting = '" . $this->voting . "',
                    layout = '" . $this->layout . "',
                    gid = '" . $this->gid . "'
                    WHERE id = '" . $blogid . "'");
    }

    /**
     * Return a copyright footer
     *
     * @author Daniel Retzl <danielretzl@gmail.com>
     * @version 1.0.0
     * @link http://yawk.io
     * @param object $db Database Object
     * @return mixed Html Code
    */
    function getFooter($db)
    {
        /** @var $db \YAWK\db */
        $this->year_created = date("Y"); // current year
        $hostURL = \YAWK\settings::getSetting($db, "host");
        return $this->html .= "<small><i class='pull-right'>Copyright (C) $this->year_created $hostURL</i></small>";
    }


    /**
     * Return the HTML code. To render the view, call this function with echo or print
     *
     * @author Daniel Retzl <danielretzl@gmail.com>
     * @version 1.0.0
     * @link http://yawk.io
     * @return mixed Html
    */
    function draw()
    {   // mixed HTML, built, filled and modified by several previews functions
        return $this->html;
    }

    /**
     * Get all comments for given blog + item id and stores it in $this->html
     *
     * @author Daniel Retzl <danielretzl@gmail.com>
     * @version 1.0.0
     * @link http://yawk.io
     * @param object $db Database Object
     * @param int $blogid The blog ID to get comments from
     * @param int $itemid The item ID to get comments from
     * @param array $row The current dataset
     * @return null
    */
    function getAllComments($db, $blogid, $itemid, $row)
    {
        /** @var $db \YAWK\db */
        $replies = 0;
        $replyForm = "";
        $replyCount = 1;
        // prepare vars + design
        // get the date and make it pretty
        $date = \YAWK\sys::splitDate($row['date_created']);
        $prettydate = "$date[day]. $date[month] $date[year] um $date[time]";

        // if emailadress is set
        if (isset($row['email']) && (!empty($row['email']))) {
            // draw mailto: link
            $emailUrl = "<a href=\"mailto:" . $row['email'] . "\" class=\"text-black\">" . $row['name'] . "</a>";
        } else { // draw the comment's author grey colored
            $emailUrl = "<span class=\"text-grey\">" . $row['name'] . "</span>";
        }

        // if user was NOT logged in, it was a public comment
        if ($row['uid'] === '0' || $row['gid'] === '0') {
            $VipStyle = 'h5'; // smaller size for not logged in users
        } else { // bigger tag if user was a VIP
            $VipStyle = "h4 style=\"color: #912F40;\" data-toggle=\"tooltip\" data-placement=\"left\" title=\"VIP User\"";
        }

        // build reply link based on $i replies
        // count comment replies from parent items
        if ($sql_replies = $db->query("SELECT id FROM {blog_comments} WHERE parentID = '" . $row['id'] . "' AND published = '1'")) {   // fetch data in loop
            while ($res = mysqli_fetch_assoc($sql_replies)) {   // add 1 for each loop cycle
                $replies++;
            }
        }
        // if there are replies
        if ($replies > 0) {   // draw "comments" link ($i replies)
            $replyLink = "<small class=\"pull-right\"><a href='#replyBox$row[id]' data-toggle=\"collapse\" aria-expanded=\"false\" aria-controls=\"replyBox\" id='" . $row['id'] . "'>Kommentare ($replies)</a></small>";
        } else {   // draw "reply" link
            $replyLink = "<small class=\"pull-right\"><a href='#form' data-toggle=\"collapse\" aria-expanded=\"false\" aria-controls=\"form\" id='" . $row['id'] . "'>antworten</a></small>";
        }
        // if comment ain't got a parent id
        if ($row['parentID'] == 0) {
            $replyForm = "";
        } else {   // display reply form
            if ($replyCount <= 2) {
                $replyForm = "<form role='form' method='post'>
                    <input type='text' name='name' class='form-control'>
                    <textarea class='form-control' name='comment'></textarea>
                    </form>";
            } else {   // no reply form
                $replyForm = "";
            }
        }

        $this->html .= "$replyForm";
        $this->html .= "<i><$VipStyle>" . $emailUrl . " <small>am $prettydate</small></i></h5>";
        $this->html .= "<p>" . $row['comment'] . "</p>$replyLink";
        //  $this->html .="<small class=\"pull-right\"><a href='#replyBox$row[id]' data-toggle=\"collapse\" aria-expanded=\"false\" aria-controls=\"replyBox\" id='".$row['id']."'>$btnText</a></small>";
        /* The following sql checks whether there's any reply for the comment */
        if ($res = $db->query("SELECT * FROM {blog_comments}
                               WHERE blogid='" . $blogid . "' AND itemid='" . $itemid . "' AND parentID = '" . $row['id'] . "'")
        ) {
            if (mysqli_num_rows($res) > 0) // there is at least reply
            {   // draw entry
                $this->html .= "<div class=\"collapse\" id=\"replyBox$row[id]\"><blockquote>";
                while ($row = mysqli_fetch_assoc($res)) {
                    //   self::draw_commentbox();
                    self::getAllComments($db, $blogid, $itemid, $row);
                }
                $this->html .= "</blockquote></div>";
            }
        }
        $this->html .= "<br>";
        return null;
    }

    function drawComments($db, $blogid, $itemid)
    {
        /** @var $db \YAWK\db */
        // build html
        $this->html .= "<div id=\comment_thread\">";

        // get parent items
        $res = $db->query("SELECT * FROM {blog_comments} WHERE blogid = '" . $blogid . "' AND itemid = '" . $itemid . "' ORDER BY date_created DESC");
        while ($row = mysqli_fetch_assoc($res)) {
            self::getComments($db, $blogid, $itemid, $row);
            //     self::getAllComments($blogid, $itemid, $row);
        }
        $this->html .= "</div>";
    }


    function getComments($db, $blogid, $itemid)
    {
        /** @var $db \YAWK\db */
        /* ADMIN ONLY */
        // ADMIN? - SHOW ALL COMMENTS:
        /*     if ($_SESSION['gid'] >=5) {
                 // GET COMMENTS
                 $sql = mysqli_query($connection, "SELECT * FROM ".$dbprefix."blog_comments WHERE blogid = ".$blogid."");
                 while($row = mysqli_fetch_row($sql)) {

                     $sql2 = mysqli_query($connection, "SELECT username FROM ".$dbprefix."users WHERE id = '".$row['0']."'");
                     while($row2 = mysqli_fetch_row($sql2)) {
                         // DRAW COMMENTS
                         $this->comments .= "<i>von: <strong>$row2[0]</i></strong><br> &nbsp;$row[1]<br><br>";
                     }
                 }
             } // end admin check */
        // GET COMMENTS

        // set var defaults
        $comment_replies = 0;
        $indent = "";
        $padding = "padding-left: 0.3em;";
        // build html...
        $this->html .= "<div id=\"comment_thread\">";
        if ($res = $db->query("SELECT * FROM {blog_comments}
                                   WHERE blogid = '" . $blogid . "'
                                   AND itemid = '" . $itemid . "'
                                   AND published = '1'
                                   ORDER BY date_created DESC")
        ) {
            while ($row = mysqli_fetch_assoc($res)) {
                $comment_id = $row['id'];
                $comment = $row['comment'];
                $uid = $row['uid'];
                $gid = $row['gid'];
                $name = $row['name'];
                $email = $row['email'];
                $date_created = $row['date_created'];
                $isParent = $row['isParent'];
                $isChild = $row['isChild'];
                $parentID = $row['parentID'];

                $date = \YAWK\sys::splitDate($date_created);
                $prettydate = "$date[day]. $date[month] $date[year] um $date[time]";

                // if zero, set text link "answer..."
                if ($isParent === '0') {
                    //
                    if ($isChild !== '1') {
                        $indent = "";
                        $padding = "padding-left: 0.3em;";
                        $collapse = "";
                        $collapseFooter = "";
                        // no child items available, because this is not a parent item
                        $reply_link = "<small><a href=\"#replyBox\" class=\"pull-right small\"><i>antworten... </i><i class=\"fa fa-chevron-down\"></i></a></small>";
                    } else {
                        $reply_link = "";
                        $indent = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                        $padding = "padding-left: 2.5em;";
                        $collapse = "<div class=\"collapse\" id=\"replyBox\"><blockquote>";
                        $collapseFooter = "</blockquote></div>";
                    }
                } else {
                    // get parent items from db
                    $sql_replies = $db->query("SELECT * FROM {blog_comments} WHERE parentID = '" . $comment_id . "' AND published = '1'");
                    while ($row = mysqli_fetch_assoc($sql_replies)) {
                        $comment_replies++;
                    }
                    $collapse = "<div class=\"collapse\" id=\"replyBox\"><blockquote>";
                    $collapseFooter = "</blockquote></div>";
                    // draw reply link with i comments
                    $reply_link = "<small><a href=\"#replyBox\" data-toggle=\"collapse\" aria-expanded=\"true\" aria-controls=\"replyBox\" class=\"pull-right small\"><i>Kommentare ($comment_replies) </i><i class=\"fa fa-chevron-down\"></i></a></small>";
                }

                // if there is no user id (uid) or group id (gid)...
                if ($uid === '0' || $gid === '0') {
                    // this is a GUEST COMMENT
                    // check if comment got an email adress and set link color
                    if (!empty($email)) {
                        $emailLink = "<a href=\"mailto:$email\" class=\"text-black\">$name</a>";
                    } else {
                        $emailLink = "<span class=\"text-grey\">$name</span>";
                    }

                    // draw guest comments
                    //  $this->html .= $collapse;
                    $this->html .= "<p><i><h5><strong>" . $emailLink . "</strong> <small>am " . $prettydate . "</small></h5></i>" . $comment . "
                    </p><hr>";
                    // $reply_link </p><hr></div>";
                    //     $this->html .= "<p><i><h5>".$indent."<strong>".$emailLink."</strong> <small>am " . $prettydate . "</small></h5></i><div style=\"$padding\">".$comment."</div>
                    //     $this->html .= "$reply_link</p><hr>";
                } else { // uid or gid value is not zero...
                    // wich means this is a USER COMMENT
                    // check if comment got an email and set link color
                    if (!empty($email)) {
                        $emailLink = "<a href=\"mailto:$email\">$name</a>";
                    } else {
                        $emailLink = "<span>$name</span>";
                    }
                    // get username for given uid
                    $sql2 = $db->query("SELECT username FROM {users} WHERE id = '" . $uid . "'");
                    while ($row2 = mysqli_fetch_row($sql2)) {
                        // draw user comments
                        // $this->html .= $collapse;
                        $this->html .= "<p<i><h4><strong style=\"color: #912F40;\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"VIP User\">" . $emailLink . "</strong> &nbsp;<small>am " . $prettydate . "</small></h4></i>" . $comment . "
                    </p><hr>";
                        //   $reply_link</p><hr>";
                    }
                }
            } // end while
        } //
        else {   // q failed
            $this->html = 'Failed to query comments database.';
        }
        $this->html .= "</div>";
    }

    static function countActiveComments($db, $blogid, $itemid)
    {
        /** @var $db \YAWK\db */
        if ($res = $db->query("SELECT COUNT(id) FROM {blog_comments}
                                   WHERE blogid = " . $blogid . "
                                   AND itemid=" . $itemid . " AND published = '1' ")
        ) {   // fetch data
            $result = mysqli_fetch_row($res);
            return $result[0];
        } else {
            return false;
        }
    }

        function draw_commentbox($db)
        {   /** @var $db \YAWK\db */
            // check if user is logged in
            if (isset($_SESSION['logged_in']) && ($_SESSION['logged_in'] == true)) {
                // check if uid and gid is set
                if (isset($_SESSION['uid']) && (isset($_SESSION['gid']))) {
                    if (isset($_SESSION['username'])) {
                        $username = $_SESSION['username'];
                    } else {
                        $username = "";
                    }
                    $hidden_uid = $_SESSION['uid'];
                    $hidden_gid = $_SESSION['gid'];
                    $i = self::countActiveComments($db, $this->blogid, $this->itemid);
                    $this->html .= "<a class=\"btn btn-info\" id=\"commentsBtn\" role=\"button\" data-toggle=\"collapse\" href=\"#comments" . $this->itemid . "\" aria-expanded=\"false\" aria-controls=\"comments\">
             <i class=\"fa fa-comments\"></i> &nbsp;Kommentare einblenden <small>(" . $i . ")</small></a>
             <div class=\"collapse\" id=\"comments\">
             <h4>Deine Meinung ist gefragt! <small>Gib Deinen Senf dazu :)</small></h4>
             <div class=\"form-group\">
                 <input class=\"form-control\" type=\"nameplaceholder\" id=\"nameplaceholder\" disabled title=\"Du bist als $username eingeloggt.\" placeholder=\"$username &nbsp;[Du bist eingeloggt]\">
                        <textarea class=\"form-control\" id=\"comment\" placeholder=\"Deine Nachricht \" rows=\"3\"></textarea>
                        <input type=\"button\" class=\"btn btn-success\" id=\"submit_post\" name=\"save_comment\" value=\"absenden\" style=\"\">
                          <input type=\"hidden\" id=\"uid\" name=\"uid\" value=\"" . $hidden_uid . "\">
                          <input type=\"hidden\" id=\"gid\" name=\"gid\" value=\"" . $hidden_gid . "\">
                          <input type=\"hidden\" id=\"itemid\" name=\"itemid\" value=\"" . $this->itemid . "\">
                          <input type=\"hidden\" id=\"blogid\" name=\"blogid\" value=\"" . $this->blogid . "\">
                          <input type=\"hidden\" id=\"name\" name=\"name\" value=\"$username\">
             </div>";
                } // session uid or gid is empty, user is not logged in correctly
                else {
                    echo \YAWK\alert::draw("danger", "Error!", "Cannot detect User Status. Obviously you are not correctly logged-in. Please try to re-login.", "", "4200");
                    exit;
                }
            } else { // user is not logged in
                $hidden_uid = 0;
                $hidden_gid = 0;
                $i = self::countActiveComments($db, $this->blogid, $this->itemid);
                $this->html .= "<a id=\"commentsBtn\" class=\"btn btn-info\" role=\"button\" data-toggle=\"collapse\" href=\"#comments" . $this->itemid . "\" aria-expanded=\"false\" aria-controls=\"comments\">
        <i class=\"fa fa-comments\"></i> &nbsp;Kommentare einblenden <small>(" . $i . ")</small></a>
        <div class=\"collapse\" id=\"comments\">
          <h4>Deine Meinung ist gefragt! <small>Gib Deinen Senf dazu :)</small></h4>
          <div class=\"form-group\">
                        <input type=\"text\" name=\"name\" id=\"name\" class=\"form-control\" placeholder=\"Dein Name\">
                        <input type=\"text\" name=\"email\" id=\"email\" class=\"form-control\" placeholder=\"Emailadresse &nbsp;[optional]\">
                        <textarea class=\"form-control\" id=\"comment\" placeholder=\"Deine Nachricht\" rows=\"3\"></textarea>
                        <input type=\"submit\" class=\"btn btn-success\" id=\"submit_post\" name=\"save_comment\" value=\"absenden\" style=\"\">
                          <input type=\"hidden\" id=\"uid\" name=\"uid\" value=\"" . $hidden_uid . "\">
                          <input type=\"hidden\" id=\"gid\" name=\"gid\" value=\"" . $hidden_gid . "\">
                          <input type=\"hidden\" id=\"itemid\" name=\"itemid\" value=\"" . $this->itemid . "\">
                          <input type=\"hidden\" id=\"blogid\" name=\"blogid\" value=\"" . $this->blogid . "\">
        </div>";
            }
            $row = '';
            $this->html .= self::getComments($db, $this->blogid, $this->itemid);
            // $this->html .= self::getComments($this->blogid, $this->itemid);
            $this->html .= "</div>";
        }

        function getItemProperty($db, $blogid, $itemid, $property)
        {
            /** @var $db \YAWK\db $sql */
            if ($res = $db->query("SELECT " . $property . " WHERE id = '" . $itemid . " AND blogid = '" . $blogid . "'")) {   // fetch data
                while ($row = mysqli_fetch_row($res)) {   // success
                    return $row[0];
                }
            } else {   // q failed
                return false;
            }
            return null;
        }

        function delete($db, $blogid)
        {
            /** @var $db \YAWK\db */
            if ($res = $db->query("SELECT alias FROM {pages} WHERE blogid = '" . $blogid . "'")) {   // get file alias from page table

                while ($row = mysqli_fetch_row($res)) {
                    // unlink file
                    $alias = $row[0];
                    $filename = "../content/articles/" . $alias . ".php";
                    if (file_exists($filename)) {   // delete file
                        if (unlink($filename)) {
                            \YAWK\alert::draw("success", "Success!", "Blog file $filename deleted.", "", 2800);
                        }
                        else
                        {
                            \YAWK\alert::draw("danger", "Could not delete file!", "Blog file $filename not deleted.", "", 6800);
                        }
                    }
                    else
                    {
                        \YAWK\alert::draw("warning", "Could not find file", "$filename", "", 12800);
                    }
                }
                if (!isset($filename)){ $filename = ''; }
                if ($db->query("DELETE FROM {pages} WHERE blogid = '" . $blogid . "'")) {
                    \YAWK\alert::draw("success", "Deleted Blog", "Blog $filename deleted successfully.", "", 2800);
                }
            }
            else
            {
                \YAWK\alert::draw("danger", "Could not get alias from pages!", "File could not be deleted.", "", 5800);
            }
            if ($res = $db->query("DELETE FROM {menu} WHERE blogid = '" . $blogid . "'")) {   // delete menu entry
                \YAWK\alert::draw("success", "Success!", "Menu Entry deleted.", "", "2000");
            }
            if ($res = $db->query("DELETE FROM {blog} WHERE id = '" . $blogid . "'")) {   // delete blog itself
                \YAWK\alert::draw("success", "Success!", "Blog deleted.", "", "2200");
            }
            if ($res = $db->query("DELETE FROM {blog_items} WHERE blogid = '" . $blogid . "'")) {   // delete blog items (entries)
                \YAWK\alert::draw("success", "Success!", "Blog Item deleted.", "", "2400");
            }
            if ($res = $db->query("DELETE FROM {blog_comments} WHERE blogid = '" . $blogid . "'")) {   // delete blog comments
                \YAWK\alert::draw("success", "Success!", "Blog Comments deleted.", "", "2600");
            }
            return true;
        }

        function deleteItem($db, $blogid, $itemid, $pageid)
        {
            /** @var $db \YAWK\db */
            if ($res = $db->query("SELECT alias FROM {pages} WHERE id = '" . $pageid . "'")) {   // GET ALIAS FROM PAGE ID TO GET THE FILENAME FOR UNLINK (see below)
                if ($row = mysqli_fetch_array($res)) {   // get page alias
                    $alias = $row['alias'];
                    // remove page data from db
                    if ($res = $db->query("DELETE FROM {pages} WHERE id = '" . $pageid . "'")) {   // build filename to delete
                        $filename = "../content/articles/" . $alias . ".php";
                        if (file_exists($filename)) {   // delete file
                            unlink($filename);
                            if ($res = $db->query("DELETE FROM {blog_items} WHERE blogid = '" . $blogid . "' AND id = '" . $itemid . "'")) {   // blog item deleted from database
                                \YAWK\alert::draw("success", "Blog item deleted ", "Blog item deleted from database!", "", "2200");
                            }
                            if ($res = $db->query("DELETE FROM {blog_comments} WHERE blogid = '" . $blogid . "' AND itemid = '" . $itemid . "'")) {   // blog comments removed from db
                                \YAWK\alert::draw("success", "Blog comments deleted", "Blog comments deleted from database!", "", "2200");
                            }
                        } else {   // could not delete file, throw error
                            // \YAWK\alert::draw("danger", "Error: ", "Could not delete $filename", "", "3800");
                            return false;
                        }
                    } else {   // delete failed, throw error
                       //  \YAWK\alert::draw("warning", "Error: ", "Could not delete item from database", "", "3800");
                        return false;
                    }
                } else {   // fetch failed, throw error
                   // \YAWK\alert::draw("danger", "Error: ", "Could not fetch alias from pages database.", "", "3800");
                    return false;
                }
            } else {   // q failed
                // \YAWK\alert::draw("danger", "Error: ", "Could not query alias from pages database.", "", "3800");
                return false;
            }
            return true;
        }

        function deleteComment($db, $blogid, $itemid, $commentid)
        {
            /** @var $db \YAWK\db */
            if ($res = $db->query("DELETE FROM {blog_comments} WHERE blogid = '" . $blogid . "' AND itemid = '" . $itemid . "' AND id = '" . $commentid . "'")) {   // single comment removed from database
                \YAWK\alert::draw("success", "Success!", "Comment deleted from database!", "", "2000");
                return true;
            } else {   // delete failed
                return false;
            }
        }

        function create($db, $name, $description, $menuID, $icon)
        {
            /** @var $db \YAWK\db */
            /* generate ID manually to prevent id holes    */
            if ($res_blog = $db->query("SELECT MAX(id), MAX(sort) FROM {blog}")) {   // fetch data
                $row = mysqli_fetch_row($res_blog);
                if (!isset($row[0])) {
                    $id = 1;
                } else {
                    $id = $row[0]++;
                }
                $sort = $row[1]++;
                $published = 1;
                $name = htmlentities($name);
                $description = htmlentities($description);
                $name = $db->quote($name);
                $description = $db->quote($description);
                $locked = 1;
                // insert into database
                if ($res_blog = $db->query("INSERT INTO {blog}
                                (id,sort,published,name,description,icon)
	                        VALUES('" . $id . "',
	                        '" . $sort . "',
	                        '" . $published . "',
	                        '" . $name . "',
	                        '" . $description . "',
	                        '" . $icon . "')"))
                {   // create blog page
                    if (!isset($page))
                    {   // create new page object
                        $page = new \YAWK\page();
                    }
                    if ($page->create($db, $name, $menuID, $locked, $id, 0))
                    {   // success
                        return true;
                    }
                    else
                    {   // create page failed, throw error...
                        \YAWK\alert::draw("danger", "Error: ", "Could not create blog page! Please enter all fields.", "", "2200");
                        return false;
                    }
                }
                else
                {   // q failed
                    \YAWK\alert::draw("danger", "Error: ", "Could not create blog page database entry - please try it again.", "", "3800");
                    return false;
                }
            }
            else
            {   // q getMAXid failed
                return false;
            }
        }


        function createItem($db, $blogid, $title, $subtitle, $published, $teasertext, $blogtext, $date_publish, $date_unpublish, $thumbnail, $youtubeUrl, $weblink)
        {
            /** @var $db \YAWK\db */
            $date_created = date("Y-m-d G:i:s");
            $alias = $title;
            /* alias string manipulation to generate a valid filename */
            $alias = mb_strtolower($alias); // lowercase
            $alias = str_replace(" ", "-", $alias); // replace all ' ' with -
            // special chars
            $umlaute = array("/ä/", "/ü/", "/ö/", "/Ä/", "/Ü/", "/Ö/", "/ß/"); // array of special chars
            $ersetze = array("ae", "ue", "oe", "ae", "ue", "oe", "ss"); // array of replacement chars
            $alias = preg_replace($umlaute, $ersetze, $alias);      // replace with preg
            $alias = preg_replace("/[^a-z0-9\-\/]/i", "", $alias); // final check: just numbers and chars are allowed

            // ## select max id from pages
            if ($res = $db->query("SELECT MAX(id) FROM {pages}")) {
                $row = mysqli_fetch_row($res);
                $page_id = $row[0] + 1;
                $locked = 1;
                // ## add new page to db pages
                // convert html special chars
                $title = htmlentities($title);
                if (!$res = $db->query("INSERT INTO {pages} (id,published,date_created,date_publish,alias,title,locked,blogid)
                        VALUES ('" . $page_id . "',
                                '" . $published . "',
                                '" . $date_created . "',
                                '" . $date_created . "',
                                '" . $alias . "',
                                '" . $title . "',
                                '" . $locked . "',
                                '" . $blogid . "')")
                ) {   // q insert page into database failed
                    \YAWK\alert::draw("danger", "Error: ", "Could not insert blog page into database.", "", "3800");
                    return false;
                } else {   // all good, go ahead...
                    // generate local meta tags
                    $desc = "description";
                    $keyw = "keywords";
                    $words = "";
                    $desc = htmlentities($desc);
                    $keyw = htmlentities($keyw);
                    // add local meta tags to db meta_local
                    if (!$res = $db->query("INSERT INTO {meta_local} (name,page,content)
                        VALUES ('" . $desc . "', '" . $page_id . "', '" . $title . "')")
                    ) {   // insert local meta description failed, throw error
                        \YAWK\alert::draw("warning", "Warning: ", "Could not store local meta description in database!", "", "3800");
                    }
                    if (!$res = $db->query("INSERT INTO {meta_local} (name,page,content)
                        VALUES ('" . $keyw . "','" . $page_id . "','" . $words . "')")
                    ) {   // insert local meta keywords failed, throw error
                        \YAWK\alert::draw("warning", "Warning: ", "Could not store local meta keywords in database!", "", "3800");
                    }

                    /* generate ID manually to prevent id holes    */
                    if ($res_blog = $db->query("SELECT MAX(id), MAX(sort) FROM {blog_items}")) {   // add ID
                        $row = mysqli_fetch_row($res_blog);
                        $id = $row[0] + 1;
                        $sort = $row[1] + 1;
                    }

                    // convert html special chars
                    $subtitle = htmlentities($subtitle);

                    // convert html special chars
                    $this->teasertext = \YAWK\sys::encodeChars($this->teasertext);
                    $this->blogtext = \YAWK\sys::encodeChars($this->blogtext);

                    if ($res = $db->query("INSERT INTO {blog_items}
                                (blogid,id,uid,pageid,sort,published,title,filename,subtitle,date_created,date_publish,date_unpublish,teasertext,blogtext,thumbnail,youtubeUrl,author,weblink)
                          VALUES('" . $blogid . "',
                          '" . $id . "',
                          '" . $_SESSION['uid'] . "',
                          '" . $page_id . "',
                          '" . $sort . "',
                          '" . $published . "',
                          '" . $title . "',
                          '" . $alias . "',
                          '" . $subtitle . "',
                          '" . $date_created . "',
                          '" . $date_publish . "',
                          '" . $date_unpublish . "',
                          '" . $teasertext . "',
                          '" . $blogtext . "',
                          '" . $thumbnail . "',
                          '" . $youtubeUrl . "',
                          '" . $weblink . "',
                          '" . $_SESSION['username'] . "')"))
                    {
                        // define content of file
                        $content = "<?php \$blog_id = $blogid; \$item_id = $id; \$full_view = 1; include 'system/plugins/blog/blog.php'; ?>";
                        // prepare file
                        $filename = "../content/articles/" . $alias . ".php";
                        if (!file_exists($filename)) {   // create file if not exist
                            $handle = fopen($filename, "wr");
                            $res = fwrite($handle, $content);
                            fclose($handle);
                            chmod($filename, 0777);
                        }
                    } // ./ end insert blog item
                    else {   // insert blog item failed
                        \YAWK\alert::draw("danger", "Error: ", "Could not insert blog item into database!", "", "3800");
                    }
                } // ./ end insert blog page
            } // ./ end select MAXid
            else {   // q failed (getMAX id)
                \YAWK\alert::draw("danger", "Error: ", "Could not get MAX id from pages database.", "", "3800");
                return false;
            }
            return true;
        }

        function copyItem($db)
        {
            /** @var $db \YAWK\db */
            $gid = "$this->itemgid";
            $alias = "$this->filename-kopie";
            $title_new = "$this->filename-kopie";
            $this->blogtitle = $this->blogtitle."-KOPIE";
            $date_created = date("Y-m-d G:i:s");

            if (!$this->alias)
            {   // if no page name is given
                \YAWK\alert::draw("warning", "Warning: ", "Alias not set. Please reload the page and try again.", "","5600");
            }
            // select max id from pages
            if (!$res = $db->query("SELECT MAX(id) FROM {pages}"))
            {   // q failed
                \YAWK\alert::draw("warning", "Warning: ", "Cannot get MAX id from pages database.", "","3600");
            }
            else
            {   // fetch data & prepare vars
                $row = mysqli_fetch_row($res);
                $pageid = $row[0] + 1;
                $locked = 1;
                $published = 1;
            }

            // ## add new page to db pages
            if ($res = $db->query("INSERT INTO {pages} (id,gid,published,date_created,date_publish,alias,title,locked,blogid)
                        VALUES ('" . $pageid . "',
                                '" . $gid . "',
                                '" . $published . "',
                                '" . $date_created . "',
                                '" . $date_created . "',
                                '" . $alias . "',
                                '" . $this->blogtitle . "',
                                '" . $locked . "',
                                '" . $this->blogid . "')"))
            {   // select max id from blog_items
                if ($res = $db->query("SELECT MAX(id) FROM {blog_items}"))
                {   // fetch data and prepare ID
                    $row = mysqli_fetch_row($res);
                    $id = $row[0] + 1;
                }
                // add new entry to db blog_items
                if ($res = $db->query("INSERT INTO {blog_items} (blogid,id,uid,pageid,sort,published,itemgid,title,filename,subtitle,date_created,date_changed,date_publish,date_unpublish,teasertext,blogtext,author,youtubeUrl,thumbnail, weblink)
                        VALUES ('" . $this->blogid . "',
                                '" . $id . "',
                                '" . $this->uid . "',
                                '" . $pageid . "',
                                '" . $this->sort . "',
                                '" . $this->published . "',
                                '" . $this->itemgid . "',
                                '" . $this->blogtitle . "',
                                '" . $alias . "',
                                '" . $this->subtitle . "',
                                '" . $this->date_created . "',
                                '" . $this->date_changed . "',
                                '" . $this->date_publish . "',
                                '" . $this->date_unpublish . "',
                                '" . $this->teasertext . "',
                                '" . $this->blogtext . "',
                                '" . $this->author . "',
                                '" . $this->youtubeUrl . "',
                                '" . $this->weblink . "',
                                '" . $this->thumbnail . "')"))
                {   // blog items inserted into database
                    // generate local meta tags
                    $desc = "description";
                    $keyw = "keywords";
                    $words = "";
                    // insert local meta description to db meta_local
                    if (!$res = $db->query("INSERT INTO {meta_local} (name,page,content)
                        VALUES ('" . $desc . "', '" . $id . "', '" . $this->blogtitle . "')"))
                    {   // inset local meta description failed
                       // \YAWK\alert::draw("warning", "Warning: ", "Could not store meta description.", "", "3800");
                    }
                    if (!$res = $db->query("INSERT INTO {meta_local} (name,page,content)
                        VALUES ('" . $keyw . "','" . $id . "','" . $words . "')"))
                    {   // insert local meta keywords
                        // \YAWK\alert::draw("warning", "Warning: ", "Could not store meta description.", "", "3800");
                    }
                    // prepare loading page content
                    $content = "<?php \$blog_id = $this->blogid; \$item_id = $id; \$full_view = 1; include 'system/plugins/blog/blog.php'; ?>";
                    // prepare file
                    $filename = "../content/articles/" . $alias . ".php";
                    $handle = fopen($filename, "wr");
                    if (fwrite($handle, $content))
                    {   // create file
                        fclose($handle);
                        chmod($filename, 0777);
                    }
                    else
                    {   // could not create file, throw error
                        \YAWK\alert::draw("error", "Error: ", "Could not create loading file $filename", "", "3800");
                    }
                }
                else
                {   // insert blog item failed,
                    \YAWK\alert::draw("danger", "Error: ", "Insert Blog item failed.", "","3600");
                    return false;
                }
            }
            else
            {   // insert item into pages db failed,
                \YAWK\alert::draw("danger", "Error: ", "Insert pages database failed.", "","3600");
                return false;
            }
        // all good,
        return true;
        } // ./ end function copy item

    } // ./ end class blog
} // ./ end namespace