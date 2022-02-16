<?php
namespace YAWK {
    /**
     * @details <b>Backend Search</b>
     *
     * handles the backend's core search functions. <br>
     * See Methods Summary for Details!</i></p>
     *
     * @author     Daniel Retzl <danielretzl@gmail.com>
     * @copyright  2017-2021 Daniel Retzl yawk.io
     * @license    https://opensource.org/licenses/MIT
     * @version    1.0.0
     * @brief Backend search class
     */
    class search
    {
        /** searchString string contains the search term */
        public $searchString;

        /**
         * @brief search pages and draw box
         * @param string $searchString
         * @param object $db database object
         */
        public function searchPages($db, $searchString, $lang)
        {
            $i = 0;
            $pagesResult = '';
            if (isset($searchString) && (!empty($searchString)))
            {
                if ($res = $db->query("SELECT id, alias, title FROM {pages} WHERE alias OR title LIKE '%".$searchString."%'"))
                {
                    while ($row = mysqli_fetch_assoc($res))
                    {
                        $i++;
                        $pagesResult .= "<a href=\"index.php?page=page-edit&id=$row[id]\" target=\"_self\"><i class=\"fa fa-edit\"></i> $row[alias].html</a><br>";
                    }
                }
            }

            if ($i > 0)
            {
            echo "
            <div class=\"box\">
                <div class=\"box-header with-border\">
                    <h3 class=\"box-title\">$lang[PAGES] <small>$lang[ALL_ELEMENTS]</small></h3>
                </div>
                <div class=\"box-body\">
                    <h4>$pagesResult</h4><b>$i</b> $lang[PAGE_ENTRIES_WITH_TAG] <i><b>&laquo;$searchString&raquo;</b></i>
                </div>
            </div>";
            }
        } /* end function searchPages(); */


        /**
         * @brief search menus
         * @param string $searchString
         * @param object $db database object
         */
        public function searchMenus($db, $searchString, $lang)
        {
            $i = 0;
            $menuResult = '';
            if (isset($searchString) && (!empty($searchString)))
            {
                if ($res = $db->query("SELECT menuID, text FROM {menu} WHERE text LIKE '%".$searchString."%'"))
                {
                    while ($row = mysqli_fetch_assoc($res))
                    {
                        $i++;
                        $menuResult .= "<a href=\"index.php?page=menu-edit&menu=$row[menuID]\" target=\"_self\"><i class=\"fa fa-edit\"></i> $row[text]</a><br>";
                    }
                }
            }
            if ($i > 0)
            {
            echo "
            <div class=\"box\">
                <div class=\"box-header with-border\">
                    <h3 class=\"box-title\">$lang[MENUS] <small>$lang[ALL_ELEMENTS]</small></h3>
                </div>
                <div class=\"box-body\">
                    <h4>$menuResult</h4><b>$i</b> $lang[MENU_ENTRIES_WITH_TAG] <i><b>&laquo;$searchString&raquo;</b></i>
                </div>
            </div>";
            }
        } /* end function searchPages(); */


        /**
         * @brief search users
         * @param string $searchString
         * @param object $db database object
         */
        public function searchUsers($db, $searchString, $lang)
        {
            $i = 0;
            $userResult = '';
            if (isset($searchString) && (!empty($searchString)))
            {
                if ($res = $db->query("SELECT id, username FROM {users} WHERE username LIKE '%".$searchString."%'"))
                {
                    while ($row = mysqli_fetch_assoc($res))
                    {
                        $i++;
                        $userResult .= "<a href=\"index.php?page=users&user=$row[id]\" target=\"_self\"><i class=\"fa fa-edit\"></i> $row[username]</a><br>";
                    }
                }
            }
            if ($i > 0)
            {
            echo "
            <div class=\"box\">
                <div class=\"box-header with-border\">
                    <h3 class=\"box-title\">$lang[USERS] <small>$lang[ALL_ELEMENTS]</small></h3>
                </div>
                <div class=\"box-body\">
                    <h4>$userResult</h4><b>$i</b> $lang[USER_ENTRIES_WITH_TAG] <i><b>&laquo;$searchString&raquo;</b></i>
                </div>
            </div>";
            }

        } /* end function searchPages(); */


        /**
         * @brief search widgets
         * @param string $searchString
         * @param object $db database object
         */
        public function searchWidgets($db, $searchString, $lang)
        {
            $i = 0;
            $widgetResult = '';
            if (isset($searchString) && (!empty($searchString)))
            {
                if ($res = $db->query("SELECT id, widgetTitle FROM {widgets} WHERE widgetTitle LIKE '%".$searchString."%'"))
                {
                    while ($row = mysqli_fetch_assoc($res))
                    {
                        $i++;
                        $widgetResult .= "<a href=\"index.php?page=widget-edit&widget=$row[id]\" target=\"_self\"><i class=\"fa fa-edit\"></i> $row[widgetTitle]</a><br>";
                    }
                }
            }
            if ($i > 0 )
            {
            echo "
            <div class=\"box\">
                <div class=\"box-header with-border\">
                    <h3 class=\"box-title\">$lang[WIDGETS] <small>$lang[ALL_ELEMENTS]</small></h3>
                </div>
                <div class=\"box-body\">
                    <h4>$widgetResult</h4><b>$i</b> $lang[WIDGETS_ENTRIES_WITH_TAG] <i><b>&laquo;$searchString&raquo;</b></i>
                </div>
            </div>";
            }
        } /* end function searchPages(); */


        /**
         * @brief search blogs
         * @param string $searchString
         * @param object $db database object
         */
        public function searchBlogs($db, $searchString, $lang)
        {
            $i = 0;
            $blogResults = '';
            if (isset($searchString) && (!empty($searchString)))
            {
                if ($res = $db->query("SELECT blogid, title, subtitle, teasertext FROM {blog_items} 
                                       WHERE title LIKE '%".$searchString."%' OR
                                       subtitle LIKE '%".$searchString."%' OR
                                       teasertext LIKE '%".$searchString."%'"))
                {
                    while ($row = mysqli_fetch_assoc($res))
                    {
                        $i++;
                        $blogResults .= "<a href=\"index.php?plugin=blog&pluginpage=blog-entries&blogid=$row[blogid]\" target=\"_self\"><i class=\"fa fa-edit\"></i> $row[title]</a><br>";
                    }
                }
            }
            if ($i > 0)
            {
            echo "
            <div class=\"box\">
                <div class=\"box-header with-border\">
                    <h3 class=\"box-title\">$lang[BLOG] <small>$lang[ALL_ELEMENTS]</small></h3>
                </div>
                <div class=\"box-body\">
                    <h4>$blogResults</h4><b>$i</b> $lang[BLOG_ENTRIES_WITH_TAG] <i><b>&laquo;$searchString&raquo;</b></i>
                </div>
            </div>";
            }
        } /* end function searchPages(); */


    } /* end class Search */
}
