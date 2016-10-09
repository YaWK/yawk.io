<?php
include '../system/plugins/blog/classes/blog.php';
global $lang;
// generate new blog object
$blog = new \YAWK\PLUGINS\BLOG\blog();
if (isset($_GET['blogid'])) {
    $blog->id = $_GET['blogid'];
    if (isset($_GET['itemid'])){
        $blog->itemid = $_GET['itemid'];
        $sqlAddon = "AND itemid = ".$blog->itemid."";
        $refreshBtnAddon = "&itemid=".$blog->itemid."";
    } else {
        $sqlAddon = '';
        $refreshBtnAddon = '';
    }
} else {
    $blog->id = 1;
}
$blog->name = $blog->getBlogProperty($db, $blog->id, "name");
$blog->icon = $blog->getBlogProperty($db, $blog->id, "icon");

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
\YAWK\PLUGINS\BLOG\blog::getBlogTitle($lang['COMMENTS'], "$lang[IN_BLOG] $blog->name", $blog->icon);
echo"<ol class=\"breadcrumb\">
            <li><a href=\"index.php\" title=\"Dashboard\"><i class=\"fa fa-dashboard\"></i> Dashboard</a></li>
            <li><a href=\"index.php?page=plugins\" title=\"Plugins\"> Plugins</a></li>
            <li><a href=\"index.php?plugin=blog\" title=\"Blog\"> Blog</a></li>
            <li class=\"active\"><a href=\"index.php?plugin=&pluginpage=blog-comments\" title=\"Comments\"> Comments</a></li>
         </ol>
    </section>
    <!-- Main content -->
    <section class=\"content\">";
/* page content start here */
?>
<a class="btn btn-default" href="index.php?plugin=blog" style="float:right;">
    <i class="glyphicon glyphicon-backward"></i> &nbsp;<?php print $lang['BACK']; ?></a>
<a class="btn btn-success" href="index.php?plugin=blog&pluginpage=blog-comments<?PHP echo $refreshBtnAddon; ?>&blogid=<?php echo $blog->id; ?>" style="float:right;">
    <i class="glyphicon glyphicon-repeat"></i> &nbsp;<?php print $lang['REFRESH']; ?></a>

<table width="100%" cellpadding="4" cellspacing="0" border="0" class="table table-hover" id="table-sort">
    <thead>
    <tr>
        <td width="3%"><strong>&nbsp;</strong></td>
        <td width="13%" class="text-center";><strong>User</strong></td>
        <td width="14%" class="text-center";><strong>Date</strong></td>
        <td width="57%"><strong>Comment</strong></td>
        <td width="5%" class="text-center";><strong>ID</strong></td>
        <td width="3%" class="text-center";><strong>Group</strong></td>
        <td width="5%" class="text-center";><strong>Aktionen</strong></td>
    </tr>
    </thead>
    <tbody>
    <?php
/*
    $res = mysqli_query($connection, "SELECT ci.*, cu.username as username, cg.value as gid FROM " . $dbprefix . "blog_comments as ci
 INNER JOIN " . $dbprefix . "users as cu on ci.uid = cu.id
  INNER JOIN " . $dbprefix . "user_groups as cg on ci.gid = cg.id WHERE blogid = '" . $blog->id . "'".$sqlAddon." ORDER BY date_created DESC");
*/

    $res = $db->query("SELECT * FROM {blog_comments}
                       WHERE blogid = '".$blog->id."' ".$sqlAddon." ORDER BY date_created DESC");
    while ($row = mysqli_fetch_assoc($res)) {

        if ($row['uid'] === '0' && ($row['gid'] === '0')){
            $comment_user = $row['name'];
        }
        else {
            if (!isset($user))
            {
                $user = new \YAWK\user();
            }
            $comment_user = $user->getProperty($db, $row['uid'], "username");
        }

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
        switch ($row['gid']) {
            case "1":
                $color = "success";
                $label = "public";
                break;
            case "2":
                $color = "warning";
                $label = "user";
                break;
            case "3":
                $color = "info";
                $label = "author";
                break;
            case "4":
                $color = "info";
                $label = "admin";
                break;
            case "5":
                $color = "danger";
                $label = "root";
                break;
            default:
                $color = "success";
                $label = "public";
                break;
        }
        // draw table and badges
        echo "<tr>
                <td class="text-center";>
                <a href=\"index.php?plugin=blog&pluginpage=blog-togglecomment&published=" . $row['published'] . "&blogid=" . $blog->id . "&id=" . $row['id'] . "\">
                <span class=\"label label-$pub\">$pubtext</span></a>&nbsp;</td>
                <td class="text-center";>" . $comment_user . "</td>

                <td><a href=\"index.php?plugin=blog&pluginpage=blog-edit&itemid=" . $row['id'] . "&blogid=" . $blog->id . "\"><div style=\"width:100%\">" . $row['date_created'] . "</div></a></td>
                <td><a href=\"index.php?plugin=blog&pluginpage=blog-edit&itemid=" . $row['id'] . "&blogid=" . $blog->id . "\" style=\"color: #7A7376;\"><div style=\"width:100%\">" . $row['comment'] . "</div></a></td>


                <td class="text-center";>" . $row['id'] . "</td>

                <td class="text-center";>
                <a href=\"#\"><span class=\"label label-$color\">" . $label . "</span></a></td>

                <td class="text-center";> 

                  <a class=\"icon icon-trash\" data-confirm=\"Soll der Eintrag &laquo;" . $comment_user . " - " . $row['comment'] . "&raquo; wirklich gel&ouml;scht werden?\" title=\"DELETE " . $row['id'] . "\" href=\"index.php?plugin=blog&pluginpage=blog-deletecomment&item=kill&commentid=" . $row['id'] . "&blogid=" . $blog->id . "&itemid=" . $row['itemid'] . "&delete=true\">
                  </a>

                  <a class=\"fa fa-trash-o\" role=\"dialog\" data-confirm=\"Soll der Eintrag &laquo;" . $row['id'] . " / " . $row['comment'] . "&raquo; wirklich gel&ouml;scht werden?\"
                  title=\"" . $lang['DEL'] . "\" href=\"index.php?plugin=blog&pluginpage=blog-deletecomment&blogid=" . $blog->id . "&commentid=" . $row['id'] . "&itemid=" . $row['itemid'] . "&delete=true\">
                  </a>
                </td>
              </tr>";
    }
    ?>
    </tbody>
</table>