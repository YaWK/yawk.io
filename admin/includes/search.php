<?php

use YAWK\backend;
use YAWK\db;
use YAWK\language;
use YAWK\search;

/** @var $db db */
/** @var $lang language */

// TEMPLATE WRAPPER - HEADER & breadcrumbs
echo "
    <!-- Content Wrapper. Contains page content -->
    <div class=\"content-wrapper\" id=\"content-FX\">
    <!-- Content Header (Page header) -->
    <section class=\"content-header\">";
/* draw Title on top */
echo backend::getTitle($lang['SEARCH_RESULT'], $lang['SEARCH_SUBTEXT']);
echo"<ol class=\"breadcrumb\">
            <li><a href=\"index.php\" title=\"$lang[DASHBOARD]\"><i class=\"fa fa-dashboard\"></i> $lang[DASHBOARD]</a></li>
            <li class=\"active\"><a href=\"index.php?page=search\" title=\"$lang[SEARCH]\"> $lang[SEARCH]</a></li>
         </ol>
    </section>
    <!-- Main content -->
    <section class=\"content\">";
/* page content start here */
?>

<?php
// include search class
require_once '../system/classes/search.php';
if (!isset($search) || (empty($search)))
{   // create search object
    $search = new search();
}
// check if search string is sent
if (isset($_POST['searchString']) && (!empty($_POST['searchString'])))
{   // strip html tags and assign obj property
    $search->searchString = strip_tags($_POST['searchString']);
}
else
{   // user sent form, but entered no search string
    // set focus on search field
    backend::setFocus("searchString");
    $search->searchString = '';
}
?>
<form method="post" action="index.php?page=search">
<div class="row">
    <div class="col-md-8">
        <!-- search box -->
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title"><?php echo $lang['SEARCH_STRING'] ?> <small><?php echo $lang['NEW_SEARCH']; ?></small></h3>
            </div>
            <div class="box-body">
                <label for="searchString"><?php echo $lang['SEARCH_STRING'] ?></label>
                <input id="searchString" name="searchString" type="text" value="<?php echo $search->searchString; ?>" class="form-control h3" placeholder="<?php echo $search->searchString; ?>">
            </div>
        </div>
        <!-- / search box -->
        <?php
        if (isset($_POST['all']) && ($_POST['all'] === "true"))
        {
            // display all search results
            echo $search->searchPages($db, $search->searchString, $lang);
            echo $search->searchBlogs($db, $search->searchString, $lang);
            echo $search->searchMenus($db, $search->searchString, $lang);
            echo $search->searchUsers($db, $search->searchString, $lang);
            echo $search->searchWidgets($db, $search->searchString, $lang);

            $pagesChecked = "checked";
            $blogsChecked = "checked";
            $menusChecked = "checked";
            $usersChecked = "checked";
            $widgetsChecked = "checked";
        }
        else
            {   // display results of selected categories only
                if (isset($_POST['pages']))
                {
                    echo $search->searchPages($db, $search->searchString, $lang);
                    $pagesChecked = "checked";
                }
                else
                    { $pagesChecked = ''; }

                if (isset($_POST['blogs']))
                {
                    echo $search->searchBlogs($db, $search->searchString, $lang);
                    $blogsChecked = "checked";
                }
                else
                    { $blogsChecked = ''; }

                if (isset($_POST['menus']))
                {
                    echo $search->searchMenus($db, $search->searchString, $lang);
                    $menusChecked = "checked";
                }
                else
                    { $menusChecked = ''; }

                if (isset($_POST['users']))
                {
                    echo $search->searchUsers($db, $search->searchString, $lang);
                    $usersChecked = "checked";
                }
                else
                    { $usersChecked = ''; }

                if (isset($_POST['widgets']))
                {
                    echo $search->searchWidgets($db, $search->searchString, $lang);
                    $widgetsChecked = "checked";
                }
                else
                    { $widgetsChecked = ''; }
            }

        ?>
    </div>
    <div class="col-md-4">
        <!-- box -->
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title"><?php echo $lang['FILTER'] ?> <small><?php echo $lang['LIMIT_SEARCH']; ?></small></h3>
            </div>
            <div class="box-body">
                    <div class="row">
                        <div class="col-md-6">
                            <input id="pages" name="pages" type="checkbox" <?php echo $pagesChecked; ?>>
                            <label for="pages"><?php echo $lang['PAGES']; ?></label>
                        </div>
                        <div class="col-md-6">
                            <input id="menus" name="menus" type="checkbox" <?php echo $menusChecked; ?>>
                            <label for="menus"><?php echo $lang['MENUS']; ?></label>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <input id="users" name="users" type="checkbox" <?php echo $usersChecked; ?>>
                            <label for="users"><?php echo $lang['USERS']; ?></label>
                        </div>
                        <div class="col-md-6">
                            <input id="widgets" name="widgets" type="checkbox" <?php echo $widgetsChecked; ?>>
                            <label for="widgets"><?php echo $lang['WIDGETS']; ?></label>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <input id="blogs" name="blogs" type="checkbox" <?php echo $blogsChecked; ?>>
                            <label for="blogs"><?php echo $lang['BLOG']; ?></label>
                        </div>
                        <div class="col-md-6">
                            <input id="files" name="files" type="checkbox" checked disabled aria-disabled="true">
                            <label for="files"><?php echo $lang['FILES']; ?></label>
                        </div>
                    </div>

                <br>
                <div class="pull-right">
                    <button class="btn btn-success" type="submit"><i class="fa fa-refresh"></i> &nbsp;<?php echo $lang['REFRESH']; ?></button>
                </div>
            </div>
        </div>
    </div>
</div>
</form>