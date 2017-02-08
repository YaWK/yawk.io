<!-- iconpicker css + JS -->
<link href="../system/engines/iconpicker/css/fontawesome-iconpicker.min.css" rel="stylesheet">
<script src="../system/engines/iconpicker/js/fontawesome-iconpicker.min.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $('#icon').iconpicker();
    });
</script>
<?php
include '../system/plugins/blog/classes/blog.php';
// check if blog object is set
if (!isset($blog)) { $blog = new \YAWK\PLUGINS\BLOG\blog(); }
// check if language is set
if (!isset($language) || (!isset($lang)))
{   // inject (add) language tags to core $lang array
    $lang = \YAWK\language::inject(@$lang, "../system/plugins/blog/language/");
}

// TEMPLATE WRAPPER - HEADER & breadcrumbs
echo "
    <!-- Content Wrapper. Contains page content -->
    <div class=\"content-wrapper\" id=\"content-FX\">
    <!-- Content Header (Page header) -->
    <section class=\"content-header\">";
/* draw Title on top */
echo \YAWK\backend::getTitle($lang['BLOG'], $lang['BLOGS_SUBTEXT']);
echo"<ol class=\"breadcrumb\">
            <li><a href=\"index.php\" title=\"$lang[DASHBOARD]\"><i class=\"fa fa-dashboard\"></i> $lang[DASHBOARD]</a></li>
            <li><a href=\"index.php?page=plugins\" title=\"$lang[PLUGINS]\"> $lang[PLUGINS]</a></li>
            <li><a href=\"index.php?plugin=blog\" title=\"$lang[BLOG]\"> $lang[BLOG]</a></li>
            <li class=\"active\"><a href=\"index.php?plugin=blog&pluginpage=blog-new\" title=\"".$lang['BLOG_ADD']."\"> ".$lang['BLOG_ADD']."</a></li>
         </ol>
    </section>
    <!-- Main content -->
    <section class=\"content\">";
/* page content start here */
?>
<div class="box box-default">
    <div class="box-body">

<form action="index.php?plugin=blog&pluginpage=blog&addblog=1" class="form-inline" role="form" method="POST">
    <input name="create" value="blog-create" type="hidden"/>
    <input type="text" class="form-control" size="90" style="margin-bottom:5px;" placeholder="<?php echo $lang['BLOG_NAME']; ?>" name="name"><br>
    <input type="text" class="form-control" size="90" placeholder="<?php echo $lang['BLOG_DESCRIPTION']; ?>" name="description"><br>
    <input type="text" style="margin-top:5px; margin-bottom:5px;" size="45" class="form-control icp icp-auto iconpicker-element iconpicker-input" placeholder="<?php echo $lang['BLOG_ICON']; ?>" id="icon" name="icon"><br>
    <input id="savebutton" class="btn btn-success" type="submit" name="create" value="<?php echo $lang['BLOG_ADD']; ?>"><!-- MENU SELECTOR -->
    &nbsp;&nbsp;<label for="menuID" class="small">im Men&uuml;:</label>&nbsp; <select id="menuID" name="menuID" class="btn btn-default">
        <?php
        foreach (YAWK\sys::getMenus($db) as $menue) {
            echo "<option value=\"" . $menue['id'] . "\"";
            if (isset($_POST['menu'])) {
                if ($_POST['menu'] === $menue['id']) {
                    echo " selected=\"selected\"";
                } else if ($page->menu === $menue['id'] && !$_POST['menu']) {
                    echo " selected=\"selected\"";
                }
            }
            echo ">" . $menue['name'] . "</option>";
        }
        ?>
        <option value="empty"></option>
    </select>
</form>

    </div>
</div>
