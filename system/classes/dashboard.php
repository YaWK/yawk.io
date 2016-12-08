<?php
namespace YAWK
{
    /**
     * <b>Admin LTE Dashboard Class</b>
     *
     * This class serves a few methods that build the Admin LTE Dashboard view in the backend.<br>
     * <p>Methods are mostly draw functions that output html.</p>
     *
     * <p><i>Class covers backend template functionality.
     * See Methods Summary for Details!</i></p>
     *
     * @package    YAWK
     * @author     Daniel Retzl <danielretzl@gmail.com>
     * @copyright  2009-2016 Daniel Retzl http://yawk.io
     * @license    http://www.gnu.org/licenses/gpl-2.0  GNU/GPL 2.0
     * @version    1.0.0
     * @link       http://yawk.io/
     * @annotation Dashboard class serves a few useful functions for the admin backend.
     */
    class dashboard
    {

        /**
         * Draws a box containing the recently added static pages
         * @param object $db the database object
         * @param int $limit number for sql limitation
         */
        static function drawLatestPagesBox($db, $limit)
        {   // default latest pages
            if (!isset($limit) || (empty($limit))) { $limit = 4; }
            $latestPages = array();
            $latestPages = \YAWK\page::getLatest($db, $limit);
            // print_r($latestPages);

            echo "<!-- PRODUCT LIST -->
        <div class=\"box box-primary\">
            <div class=\"box-header with-border\">
                <h3 class=\"box-title\">Recently Added Static Pages</h3>

                <div class=\"box-tools pull-right\">
                    <button type=\"button\" class=\"btn btn-box-tool\" data-widget=\"collapse\"><i class=\"fa fa-minus\"></i>
                    </button>
                    <button type=\"button\" class=\"btn btn-box-tool\" data-widget=\"remove\"><i class=\"fa fa-times\"></i></button>
                </div>
            </div>
            <!-- /.box-header -->
            <div class=\"box-body\">
                <ul class=\"products-list product-list-in-box\">";

            foreach ($latestPages AS $page => $property)
            {
                if ($property['published'] === "1")
                {   // page is online
                    $color = "success"; $text = "online";
                }
                else
                    {   // page is offline
                        $color = "danger"; $text= "offline";
                    }
                $since = \YAWK\sys::time_ago($property['date_publish']);
                echo"<li class=\"item\">
                        <div class=\"product-img\">
                            <img src=\"../system/engines/AdminLTE/dist/img/default-50x50.gif\" alt=\"Product Image\">
                        </div>
                        <div class=\"product-info\">
                            <a href=\"index.php?page=page-edit&alias=$property[alias]&id=$property[id]\" class=\"product-title\">$property[title]
                                <span class=\"label label-$color pull-right\">$text</span></a>
                        <span class=\"product-description\">
                          <small>published: $since<br><small>$property[date_publish]</small></small>
                        </span>
                        </div>
                    </li>";
            }

                    echo"<!-- /.item -->
                </ul>
            </div>
            <!-- /.box-body -->
            <div class=\"box-footer text-center\">
                <a href=\"index.php?page=pages\" class=\"uppercase\">View All Pages</a>
            </div>
            <!-- /.box-footer -->
        </div>
        <!-- /.box -->";

        }

        /**
         * Draws a box containing the recently added users
         * @param object $db database
         * @param int $limit number for sql limitation
         */
        static function drawLatestUsers($db, $limit)
        {
            // set default value
            if (!isset($limit) && (empty($limit))) { $limit = 8; }
            // get latest users into array
            $latestUsers = \YAWK\user::getLatestUsers($db, $limit);
            // get n of members
            $members = count($latestUsers);
            echo "
                <!-- USERS LIST -->
                <div class=\"box box-danger\">
                    <div class=\"box-header with-border\">
                        <h3 class=\"box-title\">Latest Members</h3>

                        <div class=\"box-tools pull-right\">
                            <span class=\"label label-danger\">$members New Members</span>
                            <button type=\"button\" class=\"btn btn-box-tool\" data-widget=\"collapse\"><i class=\"fa fa-minus\"></i>
                            </button>
                            <button type=\"button\" class=\"btn btn-box-tool\" data-widget=\"remove\"><i class=\"fa fa-times\"></i>
                            </button>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class=\"box-body no-padding\">
                        <ul class=\"users-list clearfix\">";
                            foreach ($latestUsers AS $newUser)
                            {
                                $userpic = \YAWK\user::getUserImage("backend", $newUser['username'], "img-circle", 50, 50);
                                $timeAgo = \YAWK\sys::time_ago($newUser['date_created']);
                                echo "<li>
                                <a href=\"index.php?page=user-edit&user=$newUser[username]\">$userpic</a>
                                <br><a href=\"index.php?page=user-edit&user=$newUser[username]\">$newUser[username]</a>
                                <span class=\"users-list-date\">$timeAgo</span>
                            </li>";
                            }
                        echo "</ul>
                        <!-- /.users-list -->
                    </div>
                    <!-- /.box-body -->
                    <div class=\"box-footer text-center\">
                        <a href=\"index.php?page=users\" class=\"uppercase\">View All Users</a>
                    </div>
                    <!-- /.box-footer -->
                </div>
                <!--/.box -->";
        }
    }
}