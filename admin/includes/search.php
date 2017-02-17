<?php
// TEMPLATE WRAPPER - HEADER & breadcrumbs
echo "
    <!-- Content Wrapper. Contains page content -->
    <div class=\"content-wrapper\" id=\"content-FX\">
    <!-- Content Header (Page header) -->
    <section class=\"content-header\">";
/* draw Title on top */
echo \YAWK\backend::getTitle($lang['SEARCH_RESULT'], $lang['SEARCH_SUBTEXT']);
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
{
    $search = new \YAWK\search();
}
if (!isset($db) || (empty($db)))
{
    require_once '../system/classes/db.php';
    $db = new \YAWK\db();
}

if (isset($_POST['searchString']) && (!empty($_POST['searchString'])))
{
    $search->string = strip_tags($_POST['searchString']);
}
else
{
    $search->string = '';
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
                <input id="searchString" name="searchString" type="text" value="<?php echo $search->string; ?>" class="form-control h3" placeholder="<?php echo $search->string; ?>">
            </div>
        </div>
        <!-- / search box -->

        <!-- pages results box -->
            <?php echo $search->searchPages($db, $search->string, $lang); ?>
        <!-- / pages results box -->

        <!-- menus results box -->
        <?php echo $search->searchMenus($db, $search->string, $lang); ?>
        <!-- / menus results box -->

        <!-- menus results box -->
        <?php echo $search->searchUsers($db, $search->string, $lang); ?>
        <!-- / menus results box -->

        <!-- widgets results box -->
        <?php echo $search->searchWidgets($db, $search->string, $lang); ?>
        <!-- / widgets results box -->
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
                            <input id="pages" name="pages" type="checkbox" checked>
                            <label for="pages"><?php echo $lang['PAGES']; ?></label>
                        </div>
                        <div class="col-md-6">
                            <input id="menus" name="menus" type="checkbox" checked>
                            <label for="menus"><?php echo $lang['MENUS']; ?></label>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <input id="users" name="users" type="checkbox" checked>
                            <label for="users"><?php echo $lang['USERS']; ?></label>
                        </div>
                        <div class="col-md-6">
                            <input id="widgets" name="widgets" type="checkbox" checked>
                            <label for="widgets"><?php echo $lang['WIDGETS']; ?></label>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <input id="blogs" name="blogs" type="checkbox" checked>
                            <label for="blogs"><?php echo $lang['BLOG']; ?></label>
                        </div>
                        <div class="col-md-6">
                            <input id="files" name="files" type="checkbox" checked>
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