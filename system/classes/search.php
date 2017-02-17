<?php
namespace YAWK {
    /**
     * <b>Backend Search</b>
     *
     * handles the backend's core search functions. <br>
     * See Methods Summary for Details!</i></p>
     *
     * @author     Daniel Retzl <danielretzl@gmail.com>
     * @copyright  2017 Daniel Retzl yawk.io
     * @license    http://www.gnu.org/licenses/gpl-2.0  GNU/GPL 2.0
     * @version    1.0.0
     * @link       http://yawk.io
     * @annotation Backend search class
     */
    class search
    {
        /** * @searchString string contains the search term */
        public $string;

        /**
         * search pages and draw box
         * @param string $searchString
         * @param object $db database object
         */
        public function searchPages($db, $string, $lang)
        {
            $i = 0;
            echo "
            <div class=\"box\">
                <div class=\"box-header with-border\">
                    <h3 class=\"box-title\">$lang[PAGES] <small>$lang[ALL_ELEMENTS]</small></h3>
                </div>
            <div class=\"box-body\">";
            echo "<h4>";
            if (isset($string) && (!empty($string)))
            {
                if ($res = $db->query("SELECT id, alias, title FROM {pages} WHERE alias OR title LIKE '%".$string."%'"))
                {
                    while ($row = mysqli_fetch_assoc($res))
                    {
                        $i++;
                        echo "<a href=\"index.php?page=page-edit&alias=$row[alias]&id=$row[id]\" target=\"_self\"><i class=\"fa fa-edit\"></i> $row[alias].html</a><br>";
                    }
                }
            }
            echo "</h4><b>$i</b> $lang[PAGE_ENTRIES_WITH_TAG] <i><b>&laquo;$string&raquo;</b></i></div>
                </div>";
        } /* end function searchPages(); */


        /**
         * search menus
         * @param string $searchString
         * @param object $db database object
         */
        public function searchMenus($db, $string, $lang)
        {
            $i = 0;
            echo "
            <div class=\"box\">
                <div class=\"box-header with-border\">
                    <h3 class=\"box-title\">$lang[MENUS] <small>$lang[ALL_ELEMENTS]</small></h3>
                </div>
            <div class=\"box-body\">";
            echo "<h4>";
            if (isset($string) && (!empty($string)))
            {
                if ($res = $db->query("SELECT menuID, text FROM {menu} WHERE text LIKE '%".$string."%'"))
                {
                    while ($row = mysqli_fetch_assoc($res))
                    {
                        $i++;
                        echo "<a href=\"index.php?page=menu-edit&menu=$row[menuID]\" target=\"_self\"><i class=\"fa fa-edit\"></i> $row[text]</a><br>";
                    }
                }
            }
            echo "</h4><b>$i</b> $lang[MENU_ENTRIES_WITH_TAG] <i><b>&laquo;$string&raquo;</b></i></div>
                </div>";
        } /* end function searchPages(); */


        /**
         * search users
         * @param string $searchString
         * @param object $db database object
         */
        public function searchUsers($db, $string, $lang)
        {
            $i = 0;
            echo "
            <div class=\"box\">
                <div class=\"box-header with-border\">
                    <h3 class=\"box-title\">$lang[USERS] <small>$lang[ALL_ELEMENTS]</small></h3>
                </div>
            <div class=\"box-body\">";
            echo "<h4>";
            if (isset($string) && (!empty($string)))
            {
                if ($res = $db->query("SELECT id, username FROM {users} WHERE username LIKE '%".$string."%'"))
                {
                    while ($row = mysqli_fetch_assoc($res))
                    {
                        $i++;
                        echo "<a href=\"index.php?page=users&user=$row[id]\" target=\"_self\"><i class=\"fa fa-edit\"></i> $row[username]</a><br>";
                    }
                }
            }
            echo "</h4><b>$i</b> $lang[USER_ENTRIES_WITH_TAG] <i><b>&laquo;$string&raquo;</b></i></div>
                </div>";
        } /* end function searchPages(); */


        /**
         * search users
         * @param string $searchString
         * @param object $db database object
         */
        public function searchWidgets($db, $string, $lang)
        {
            $i = 0;
            echo "
            <div class=\"box\">
                <div class=\"box-header with-border\">
                    <h3 class=\"box-title\">$lang[WIDGETS] <small>$lang[ALL_ELEMENTS]</small></h3>
                </div>
            <div class=\"box-body\">";
            echo "<h4>";
            if (isset($string) && (!empty($string)))
            {
                if ($res = $db->query("SELECT id, widgetTitle FROM {widgets} WHERE widgetTitle LIKE '%".$string."%'"))
                {
                    while ($row = mysqli_fetch_assoc($res))
                    {
                        $i++;
                        echo "<a href=\"index.php?page=widget-edit&widget=$row[id]\" target=\"_self\"><i class=\"fa fa-edit\"></i> $row[widgetTitle]</a><br>";
                    }
                }
            }
            echo "</h4><b>$i</b> $lang[WIDGETS_ENTRIES_WITH_TAG] <i><b>&laquo;$string&raquo;</b></i></div>
                </div>";
        } /* end function searchPages(); */


        /**
         * search blogs
         * @param string $searchString
         * @param object $db database object
         */
        public function searchBlogs($db, $string, $lang)
        {
            $i = 0;
            echo "
            <div class=\"box\">
                <div class=\"box-header with-border\">
                    <h3 class=\"box-title\">$lang[BLOG] <small>$lang[ALL_ELEMENTS]</small></h3>
                </div>
            <div class=\"box-body\">";
            echo "<h4>";
            if (isset($string) && (!empty($string)))
            {
                if ($res = $db->query("SELECT blogid, title, subtitle, teasertext FROM {blog_items} 
                                       WHERE title LIKE '%".$string."%' OR
                                       subtitle LIKE '%".$string."%' OR
                                       teasertext LIKE '%".$string."%'"))
                {
                    while ($row = mysqli_fetch_assoc($res))
                    {
                        $i++;
                        echo "<a href=\"index.php?plugin=blog&pluginpage=blog-entries&blogid=$row[blogid]\" target=\"_self\"><i class=\"fa fa-edit\"></i> $row[title]</a><br>";
                    }
                }
            }
            echo "</h4><b>$i</b> $lang[BLOG_ENTRIES_WITH_TAG] <i><b>&laquo;$string&raquo;</b></i></div>
                </div>";
        } /* end function searchPages(); */


    } /* end class Search */
}
