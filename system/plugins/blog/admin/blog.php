<?php
include '../system/plugins/blog/classes/blog.php';
YAWK\backend::getTitle($lang['BLOG'], $lang['BLOGS_SUBTEXT']);
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
echo \YAWK\backend::getTitle($lang['BLOG'], $lang['BLOGS_SUBTEXT']);
echo"<ol class=\"breadcrumb\">
            <li><a href=\"index.php\" title=\"Dashboard\"><i class=\"fa fa-dashboard\"></i> Dashboard</a></li>
            <li><a href=\"index.php?page=plugins\" title=\"Plugins\"> Plugins</a></li>
            <li class=\"active\"><a href=\"index.php?plugin=blog\" title=\"Blog\"> Blog</a></li>
         </ol>
    </section>
    <!-- Main content -->
    <section class=\"content\">";
/* page content start here */
?>
<a class="btn btn-success" href="index.php?plugin=blog&pluginpage=blog-new" style="float:right;">
    <i class="glyphicon glyphicon-plus"></i> &nbsp;<?php print $lang['BLOG_ADD']; ?></a>

<table width="100%" cellpadding="4" cellspacing="0" border="0" class="table table-hover" id="table-sort">
    <thead>
    <tr>
        <td width="3%"><strong>&nbsp;</strong></td>
        <td width="5%" style="text-align:center;"><strong>ID</strong></td>
        <td width="3%" style="text-align:center;"><strong>&nbsp;</strong></td>
        <td width="15%"><strong><?PHP echo $lang['BLOG']; ?></strong></td>
        <td width="57%"><strong><?PHP echo $lang['DESCRIPTION']; ?></strong></td>
        <td width="7%" style="text-align:center;"><strong><?PHP echo $lang['ENTRIES']; ?></strong></td>
        <td width="10%" style="text-align:center;"><strong><?PHP echo $lang['ACTIONS']; ?></strong></td>
    </tr>
    </thead>
    <tbody>
    <?PHP
    $blog = new \YAWK\PLUGINS\BLOG\blog();

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
            $pubtext = "On";
        } else {
            $pub = "danger";
            $pubtext = "Off";
        }
        // if comments are enabled, show 'edit comments' action icon
        if (isset($blog->comments) && ($blog->comments === '1')) {
            $commentIcon = "<a href=\"index.php?plugin=blog&pluginpage=blog-comments&blogid=".$blog->blogid."\"><i class=\"fa fa-comments-o\"></i></a>&nbsp;&nbsp;";
        } else {
            $commentIcon = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
        }
        // count item entries to view in blog overview table
        if ($res2 = $db->query("SELECT COUNT(id) FROM {blog_items} WHERE blogid = " . $blog->blogid . ""))
        {
        $item_count = mysqli_fetch_row($res2);
        $items = $item_count[0];

        echo "<tr>
                <td style=\"text-align:center;\">
                <a title=\"toggle&nbsp;status\" href=\"index.php?plugin=blog&pluginpage=blog-toggle&blog=" . $row['id'] . "&published=" . $row['published'] . "\">
            <span class=\"label label-$pub\">$pubtext</span></a>&nbsp;</td>
                <td style=\"text-align:center;\">" . $row['id'] . "</td>
                <td>" . $iconHtml . "</td>
                <td><a href=\"index.php?plugin=blog&pluginpage=blog-entries&blogid=" . $row['id'] . "\"><div style=\"width:100%\">" . $row['name'] . "</div></a></td>
                <td><a href=\"index.php?plugin=blog&pluginpage=blog-entries&blogid=" . $row['id'] . "\" style=\"color: #7A7376;\"><div style=\"width:100%\">" . $row['description'] . "</div></a></td>
                
            <td style=\"text-align:center;\">" . $items . "</td>
            <td style=\"text-align:center;\">
            " . $commentIcon . "
            <a href=\"index.php?plugin=blog&pluginpage=blog-setup&blogid=" . $row['id'] . "\" title=\"" . $row['name'] . "&nbsp;" . $lang['CONFIGURE'] . "\"><i class=\"fa fa-wrench\"></i></a>&nbsp;&nbsp;
            <a class=\"fa fa-trash-o\" role=\"dialog\" data-confirm=\"VORSICHT! &laquo;Blog #" . $row['id'] . " - " . $row['name'] . "&raquo; inklusive Inhalt l&ouml;schen?\" title=\"" . $lang['BLOG_DELETE'] . "&nbsp;" . $row['name'] . "\" href=\"index.php?plugin=blog&pluginpage=blog-delete&blog=" . $row['id'] . "&delete=true\">
            </a>
                </td>
              </tr>";
        }
        else
        {
            \YAWK\alert::draw("warning", "Warning: ", "Could not fetch blog items!","","3800");
        }
    }
    }
    else
    {
        \YAWK\alert::draw("warning", "Warning: ", "Could not fetch blog entries!","","3800");
    }
    ?>
    </tbody>
</table>


<?php
\YAWK\backend::drawHtmlFooter();
?>