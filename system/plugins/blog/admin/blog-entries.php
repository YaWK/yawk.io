<?php
include '../system/plugins/blog/classes/blog.php';
global $lang;
// generate new blog object
$blog = new \YAWK\PLUGINS\BLOG\blog();
if (isset($_GET['blogid'])) {
    $blog->id = $_GET['blogid'];
} else {
    $blog->id = 1;
}
$blog->name = $blog->getBlogProperty($db, $blog->id, "name");
$blog->icon = $blog->getBlogProperty($db, $blog->id, "icon");
$blog->comments = $blog->getBlogProperty($db, $blog->id, "comments");

/* draw Title on top */

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
        \YAWK\PLUGINS\BLOG\blog::getBlogTitle($blog->name, $lang['MANAGE'], $blog->icon);
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
<a class="btn btn-success" href="index.php?plugin=blog&pluginpage=blog-newitem&blogid=<?php echo $blog->id; ?>" style="float:right;">
    <i class="glyphicon glyphicon-plus"></i> &nbsp;<?php print $lang['BLOG+']; ?></a>

<a class="btn btn-default" href="index.php?plugin=blog" style="float:right;">
    <i class="glyphicon glyphicon-backward"></i> &nbsp;<?php print $lang['BACK']; ?></a>

<table width="100%" cellpadding="4" cellspacing="0" border="0" class="table table-hover" id="table-sort">
    <thead>
    <tr>
        <td width="3%"><strong>&nbsp;</strong></td>
        <td width="5%" style="text-align:center;"><strong>ID</strong></td>
        <td width="25%"><strong>Title</strong></td>
        <td width="30%"><strong>Subtitle</strong></td>
        <td width="5%" style="text-align:center;"><strong>User</strong></td>
        <td width="5%" style="text-align:center;"><strong>Group</strong></td>
        <td width="10%" style="text-align:center;"><strong>Publish</strong></td>
        <td width="7%" style="text-align:center;"><strong>Comments</strong></td>
        <td width="10%" style="text-align:center;"><strong>Aktionen</strong></td>
    </tr>
    </thead>
    <tbody>
    <?php

    if ($res = $db->query("SELECT ci.*, cu.username as username, cr.value as gid FROM {blog_items} as ci
                           INNER JOIN {users} as cu on ci.uid = cu.id
                           INNER JOIN {user_groups} as cr on ci.itemgid = cr.id
                           WHERE blogid = '" . $blog->id . "' ORDER BY date_publish"))
    {
        while ($row = mysqli_fetch_assoc($res))
        {
            $date_publish = $row['date_publish'];
            $date_unpublish = $row['date_unpublish'];
            $atm = date("Y-m-d H:i:s");

            // on / off badge logic
            switch ($row['published']) {
                case 0:
                    $pub = "danger";
                    $pubtext = "Off";
                    break;
                case 1:
                    $pub = "success";
                    $pubtext = "On";
                    break;
            }

            // group id badge logic
            switch ($row['itemgid']) {
                case 1:
                    $rcolor = "success";
                    break;
                case 2:
                    $rcolor = "warning";
                    break;
                default:
                    $rcolor = "danger";
                    break;
            }

          if ($atm < $date_publish) {
              $pub = "warning";
              $pubtext = "in queue";
          }
          if ($date_unpublish !== "0000-00-00 00:00:00"){
              if ($atm >= $date_unpublish) {
              $pub = "default";
              $pubtext = "xpired";
              }
          }

            // count comments
            $i_comments = \YAWK\PLUGINS\BLOG\blog::countActiveComments($db, $blog->id, $row['id']);
            if ($i_comments !== '0') {
                $commentIcon = "<a href=\"index.php?plugin=blog&pluginpage=blog-comments&itemid=".$row['id']."&blogid=".$blog->id."\"><i class=\"fa fa-comments-o\"></i></a>&nbsp;&nbsp;";
            }
            else {
                $commentIcon = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                $i_comments = '';
            }
            // draw table and badges
            echo "<tr>
                    <td style=\"text-align:center;\">
                    <a href=\"index.php?plugin=blog&pluginpage=blog-toggleitem&published=" . $row['published'] . "&blogid=" . $blog->id . "&id=" . $row['id'] . "\">
                    <span class=\"label label-$pub\">$pubtext</span></a>&nbsp;</td>
                    <td style=\"text-align:center;\">" . $row['id'] . "</td>
                    <td><a href=\"index.php?plugin=blog&pluginpage=blog-edit&itemid=" . $row['id'] . "&blogid=" . $blog->id . "\"><div style=\"width:100%\">" . $row['title'] . "</div></a></td>
                    <td><a href=\"index.php?plugin=blog&pluginpage=blog-edit&itemid=" . $row['id'] . "&blogid=" . $blog->id . "\" style=\"color: #7A7376;\"><div style=\"width:100%\">" . $row['subtitle'] . "</div></a></td>
                    <td style=\"text-align:center;\">" . $row['username'] . "</td>

                    <td style=\"text-align:center;\">
                    <a href=\"index.php?plugin=blog&pluginpage=blog-togglegroup&itemgid=" . $row['itemgid'] . "&blogid=" . $blog->id . "&itemid=" . $row['id'] . "\">
                    <span class=\"label label-$rcolor\">" . $row['gid'] . "</span></a></td>

                    <td style=\"text-align:center;\">" . $date_publish . "</td>
                    <td style=\"text-align:center;\">" . $i_comments . "</td>
                    <td style=\"text-align:center;\">

                       ".$commentIcon."
                      <a class=\"fa fa-copy\" title=\"" . $lang['COPY'] . ": " . $row['title'] . "\" href=\"index.php?plugin=blog&pluginpage=blog-copyitem&copy=true&itemgid=" . $row['itemgid'] . "&itemid=".$row['id']."&blogid=" . $blog->id . "\"></a>&nbsp;

                      <a class=\"fa fa-trash\" data-confirm=\"Soll der Eintrag &laquo;" . $row['title'] . " - " . $row['subtitle'] . "&raquo; wirklich gel&ouml;scht werden?\" title=\"DELETE " . $row['title'] . "\" href=\"index.php?plugin=blog&pluginpage=blog-delete&item=kill&pageid=" . $row['pageid'] . "&blogid=" . $blog->id . "&itemid=" . $row['id'] . "&delete=true\">
                      </a>

                      <a class=\"fa fa-edit\"title=\"" . $lang['EDIT'] . ": " . $row['title'] . "\" href=\"index.php?plugin=blog&pluginpage=blog-edit&itemid=" . $row['id'] . "&blogid=" . $blog->id . "\"></a>&nbsp;
                      <a class=\"fa fa-trash-o\" role=\"dialog\" data-confirm=\"Soll der Eintrag &laquo;" . $row['id'] . " / " . $row['title'] . "&raquo; wirklich gel&ouml;scht werden?\"
                      title=\"" . $lang['DEL'] . "\" href=\"index.php?plugin=blog&pluginpage=blog-delete&pageid=" . $row['pageid'] . "&itemid=" . $row['id'] . "&blogid=" . $blog->id . "&delete=true\">
                      </a>
                    </td>
                  </tr>";
        }
    }
    else
    {
        \YAWK\alert::draw("warning", "Warning: ", "Could not fetch blog entries from database", "","3800");
    }
    ?>
    </tbody>
</table>