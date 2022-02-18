<?php

use YAWK\alert;
use YAWK\backend;
use YAWK\db;
use YAWK\language;
use YAWK\PLUGINS\BLOG\blog;

include '../system/plugins/blog/classes/blog.php';
// check if blog object is set
if (!isset($blog)) { $blog = new blog(); }
// check if language is set
if (!isset($language) || (!isset($lang)))
{   // inject (add) language tags to core $lang array
    $lang = language::inject(@$lang, "../system/plugins/blog/language/");
}
if (!isset($db)){
    $db = new db();
}

// ADD BLOG
if (isset($_GET['addblog']))
{   // user comes from blog-new
    if ($_GET['addblog'] == "1")
    {   // check if vars are set
        if (!empty($_POST['name']) || (!empty($_POST['description'])))
        {   // escape vars
            $name = $db->quote($_POST['name']);
            $description = $db->quote($_POST['description']);
        }
        else
        {   // empty
            $name = '';
            $description = '';
        }
        // prepare rest of vars
        if (!empty($_POST['menuID'])) { $menuID = $db->quote($_POST['menuID']); } else { $menuID = ''; }
        if (!empty($_POST['icon'])) { $icon = $db->quote($_POST['icon']); } else { $icon = ''; }
        // create new blog
        if ($blog->create($db, $name, $description, $menuID, $icon) === true)
        {   // if the user did not set an icon, notify him that he should / can do that.
            if (empty($icon))
            {   // no icon is set, throw a info alert in users face
                alert::draw("info", "$lang[DID_YOU_KNOW]", "$lang[BLOG_TIP_ICONS]", "", 12400);
            }
            print alert::draw("success", "$lang[SUCCESS]", "$lang[BLOG_ADD_OK]", "", 800);
        }
        else
        {   // could not create blog, throw error
            print alert::draw("danger", "$lang[ERROR]", "$lang[BLOG_ADD_FAILED] $name","",3800);
        }
    }
}

// DELETE BLOG
if (isset($_GET['delete']) || ($_GET == "1"))
{
    // if all is set to 1, the full blog, including all items will be deleted
    if (isset($_GET['all']) && ($_GET['all'] === "true"))
    {   // check if a blogID is set
        if (isset($_GET['blog']))
        {   // delete full blog including whole content
            if (!$blog->delete($db, $_GET['blog']))
            {   // delete blog failed, throw error
                alert::draw("warning", "$lang[ERROR]", "$lang[BLOG_DEL_FAILED] " . $_GET['itemid'] . " ","plugin=blog", 5800);
            }
        }
    }
}
?>
<script type="text/javascript">
    $(document).ready(function () {
        $('#table-sort').dataTable({
            "bPaginate": false,
            "bLengthChange": false,
            "bFilter": true,
            "bSort": true,
            "bInfo": true,
            "bAutoWidth": false
        });
    });
</script>
<?php
// TEMPLATE WRAPPER - HEADER & breadcrumbs
echo "
    <!-- Content Wrapper. Contains page content -->
    <div class=\"content-wrapper\" id=\"content-FX\">
    <!-- Content Header (Page header) -->
    <section class=\"content-header\">";
/* draw Title on top */
echo backend::getTitle($lang['BLOG'], $lang['BLOGS_SUBTEXT']);
echo"<ol class=\"breadcrumb\">
            <li><a href=\"index.php\" title=\"$lang[DASHBOARD]\"><i class=\"fa fa-dashboard\"></i> $lang[DASHBOARD]</a></li>
            <li><a href=\"index.php?page=plugins\" title=\"$lang[PLUGINS]\"> $lang[PLUGINS]</a></li>
            <li class=\"active\"><a href=\"index.php?plugin=blog\" title=\"$lang[BLOG]\"> $lang[BLOG]</a></li>
         </ol>
    </section>
    <!-- Main content -->
    <section class=\"content\">";
/* page content start here */
?>
<div class="box box-default">
    <div class="box-body">

<a class="btn btn-success" href="index.php?plugin=blog&pluginpage=blog-new" style="float:right;">
    <i class="glyphicon glyphicon-plus"></i> &nbsp;<?php print $lang['BLOG_ADD']; ?></a>

<table width="100%" cellpadding="4" cellspacing="0" border="0" class="table table-hover" id="table-sort">
    <thead>
    <tr>
        <td width="3%"><strong>&nbsp;</strong></td>
        <td width="5%" class="text-center"><strong><?php echo $lang['ID']; ?></strong></td>
        <td width="3%" class="text-center"><strong>&nbsp;</strong></td>
        <td width="15%"><strong><?php echo $lang['BLOG']; ?></strong></td>
        <td width="57%"><strong><?php echo $lang['DESCRIPTION']; ?></strong></td>
        <td width="7%" class="text-center"><strong><?php echo $lang['ENTRIES']; ?></strong></td>
        <td width="10%" class="text-center"><strong><?php echo $lang['ACTIONS']; ?></strong></td>
    </tr>
    </thead>
    <tbody>
    <?php
    $blog = new blog();

    if ($res = $db->query("SELECT * FROM {blog} ORDER BY id"))
    {
    while ($row = mysqli_fetch_assoc($res)) {
        $blog->blogid = $row['id'];
        $blog->name = $row['name'];
        $blog->description = $row['description'];
        $blog->icon = $row['icon'];
        $blog->comments = $row['comments'];
        // get icon status
        if (!empty($blog->icon)) {
            $iconHtml = "<i class=\"fa " . $blog->icon . "\"></i>";
        } else {
            $iconHtml = "&nbsp;";
        }
        // get published status
        if ($row['published'] == 1) {
            $pub = "success";
            $pubtext = "$lang[ONLINE]";
        } else {
            $pub = "danger";
            $pubtext = "$lang[OFFLINE]";
        }
        // if comments are enabled, show 'edit comments' action icon
        if (isset($blog->comments) && ($blog->comments === '1')) {
            $commentIcon = "<a href=\"index.php?plugin=blog&pluginpage=blog-comments&blogid=".$blog->blogid."\"><i class=\"fa fa-comments-o\"></i></a>&nbsp;&nbsp;";
        } else {
            $commentIcon = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
        }
        // count item entries to view in blog overview table
        if ($res2 = $db->query("SELECT COUNT(id) FROM {blog_items} WHERE blogid = '".$blog->blogid."'"))
        {
        $item_count = mysqli_fetch_row($res2);
        $items = $item_count[0];

        echo "<tr>
                <td class=\"text-center\">
                <a title=\"toggle&nbsp;status\" href=\"index.php?plugin=blog&pluginpage=blog-toggle&blog=" . $row['id'] . "&published=" . $row['published'] . "\">
            <span class=\"label label-$pub\">$pubtext</span></a>&nbsp;</td>
                <td class=\"text-center\">" . $row['id'] . "</td>
                <td>" . $iconHtml . "</td>
                <td><a href=\"index.php?plugin=blog&pluginpage=blog-entries&blogid=" . $row['id'] . "\"><div style=\"width:100%\">" . $row['name'] . "</div></a></td>
                <td><a href=\"index.php?plugin=blog&pluginpage=blog-entries&blogid=" . $row['id'] . "\" style=\"color: #7A7376;\"><div style=\"width:100%\">" . $row['description'] . "</div></a></td>
                
            <td class=\"text-center\">" . $items . "</td>
            <td class=\"text-center\">
            " . $commentIcon . "
            
            <a href=\"index.php?plugin=blog&pluginpage=blog-setup&blogid=" . $row['id'] . "\" title=\"" . $row['name'] . "&nbsp;" . $lang['CONFIGURE'] . "\"><i class=\"fa fa-wrench\"></i></a>&nbsp;&nbsp;
            <a class=\"fa fa-trash-o\" role=\"dialog\" data-confirm=\"$lang[BLOG_DEL_REQUEST] $lang[BLOG] # &laquo;" . $row['id'] . " - " . $row['name'] . "&raquo;\" title=\"" . $lang['BLOG_DELETE'] . "&nbsp;" . $row['name'] . "\" href=\"index.php?plugin=blog&delete=1&blog=" . $row['id'] . "&all=true\">
            </a>
                </td>
              </tr>";
        }
        else
        {
            alert::draw("warning", "$lang[WARNING]", "$lang[BLOG_FETCH_FAILED]","","3800");
        }
    }
    }
    else
    {
        alert::draw("warning", "$lang[WARNING]", "$lang[BLOG_FETCH_FAILED]","","3800");
    }
    ?>
    </tbody>
</table>

    </div>
</div>