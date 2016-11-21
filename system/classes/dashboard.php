<?php
namespace YAWK
{
    class dashboard
    {

        static function drawLatestPages($db, $count)
        {   // default latest pages
            if (!isset($count) || (empty($count))) { $count = 4; }
            $latestPages = array();
            $latestPages = \YAWK\page::getLatest($db, $count);
            // print_r($latestPages);

            echo "<!-- PRODUCT LIST -->
        <div class=\"box box-primary\">
            <div class=\"box-header with-border\">
                <h3 class=\"box-title\">Recently Added Pages</h3>

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
        static function drawLatestUsers($db, $count)
        {
            // set default value
            if (!isset($count) && (empty($count))) { $count = 8; }
            echo "
                <!-- USERS LIST -->
                <div class=\"box box-danger\">
                    <div class=\"box-header with-border\">
                        <h3 class=\"box-title\">Latest Members</h3>

                        <div class=\"box-tools pull-right\">
                            <span class=\"label label-danger\">$count New Members</span>
                            <button type=\"button\" class=\"btn btn-box-tool\" data-widget=\"collapse\"><i class=\"fa fa-minus\"></i>
                            </button>
                            <button type=\"button\" class=\"btn btn-box-tool\" data-widget=\"remove\"><i class=\"fa fa-times\"></i>
                            </button>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class=\"box-body no-padding\">
                        <ul class=\"users-list clearfix\">";
                            $latestUsers = \YAWK\user::getLatestUsers($db, $count);
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