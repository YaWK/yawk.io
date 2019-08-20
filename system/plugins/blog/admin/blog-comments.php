<?php
include '../system/plugins/blog/classes/blog.php';
// check if blog object is set
if (!isset($blog)) { $blog = new \YAWK\PLUGINS\BLOG\blog(); }
// check if language is set
if (!isset($language) || (!isset($lang)))
{   // inject (add) language tags to core $lang array
    $lang = \YAWK\language::inject(@$lang, "../system/plugins/blog/language/");
}

// TOGGLE COMMENT ON/OFF
if (isset($_GET['toggle']))
{   // check if published state and id are sent
    if (isset($_GET['published']) && (isset($_GET['id'])))
    {   // check and switch state
        if ($_GET['published'] === '1')
        {   $_GET['published'] = 0; $status = "offline"; }
        else
        {   $_GET['published'] = 1; $status = "online"; }
        // finally: toggle the comment state
        if ($blog->toggleCommentOffline($db, $_GET['id'], $_GET['published']))
        {   // success, notify user
            print \YAWK\alert::draw("success", "Comment is now $status.", "Comment is now $status", "", 800);
        }
        else
        {   // toggle did not work, throw error
            print \YAWK\alert::draw("danger", "Error: Could not toggle comment status.", "Comment is still $status", "", 5800);
        }
    }
}

// DELETE COMMENT
if (isset($_GET['deletecomment']))
{   // delete, if true
    if ($_GET['deletecomment'] === "true") {
        // check vars
        if (isset($_GET['commentid']) && (isset($_GET['itemid']) && (isset($_GET['blogid'])))) {
            // ok, do it...
            if ($blog->deleteComment($db, $_GET['blogid'], $_GET['itemid'], $_GET['commentid'])) {
                \YAWK\alert::draw("success", "Success! ", "Comment deleted.", "","800");
            }
            else
            {   // throw error
                \YAWK\alert::draw("danger", "Error: ", "Could not delete comment ID: " . $_GET['commentid'] . " from Blog: ".$_GET['blogid']." ", "","5800");
            }
        }
    }
}

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

// set blog object properties
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
            <li><a href=\"index.php\" title=\"$lang[DASHBOARD]\"><i class=\"fa fa-dashboard\"></i> $lang[DASHBOARD]</a></li>
            <li><a href=\"index.php?page=plugins\" title=\"$lang[PLUGINS]\"> $lang[PLUGINS]</a></li>
            <li><a href=\"index.php?plugin=blog\" title=\"$lang[BLOG]\"> $lang[BLOG]</a></li>
            <li class=\"active\"><a href=\"index.php?plugin=&pluginpage=blog-comments\" title=\"$lang[COMMENTS]\"> $lang[COMMENTS]</a></li>
         </ol>
    </section>
    <!-- Main content -->
    <section class=\"content\">";
/* page content start here */
?>
<div class="box box-default">
    <div class="box-body">

<a class="btn btn-success" href="index.php?plugin=blog&pluginpage=blog-comments<?php echo $refreshBtnAddon; ?>&blogid=<?php echo $blog->id; ?>" style="float:right;">
<i class="glyphicon glyphicon-repeat"></i> &nbsp;<?php print $lang['REFRESH']; ?></a>
<a class="btn btn-default" href="index.php?plugin=blog" style="float:right;">
<i class="glyphicon glyphicon-backward"></i> &nbsp;<?php print $lang['BACK']; ?></a>

<table width="100%" cellpadding="4" cellspacing="0" border="0" class="table table-hover" id="table-sort">
    <thead>
    <tr>
        <td width="3%"><strong>&nbsp;</strong></td>
        <td width="3%" class=\"text-left\"><strong><?php echo $lang['GROUP']; ?></strong></td>
        <td width="13%" class=\"text-left\"><strong><?php echo $lang['USER']; ?></strong></td>
        <td width="14%" class=\"text-center\"><strong><?php echo $lang['DATE']; ?></strong></td>
        <td width="57%"><strong><?php echo $lang['COMMENT']; ?></strong></td>
        <td width="5%" class=\"text-center\"><strong><?php echo $lang['ID']; ?></strong></td>
        <td width="5%" class=\"text-center\"><strong><?php echo $lang['ACTIONS']; ?></strong></td>
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
                $user = new \YAWK\user($db);
            }
            $comment_user = $user->getProperty($db, $row['uid'], "username");
        }

        // on / off badge logic
        switch ($row['published']) {
            case 0:
                $pub = "danger";
                $pubtext = "$lang[OFFLINE]";
                break;
            case 1:
                $pub = "success";
                $pubtext = "$lang[ONLINE]";
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
                <td class=\"text-left\">
                <a href=\"index.php?plugin=blog&pluginpage=blog-comments&toggle=1&published=" . $row['published'] . "&blogid=" . $blog->id . "&id=" . $row['id'] . "\">
                <span class=\"label label-$pub\">".$pubtext."</span></a>&nbsp;</td>
                
                <td class=\"text-leftcleft>
                <span class=\"label label-$color\">".$label."</span></td>
                
                <td class=\"text-center\">".$comment_user."</td>

                <td><a href=\"index.php?plugin=blog&pluginpage=blog-edit&itemid=" . $row['id'] . "&blogid=" . $blog->id . "\"><div style=\"width:100%\">" . $row['date_created'] . "</div></a></td>
                <td><a href=\"index.php?plugin=blog&pluginpage=blog-edit&itemid=" . $row['id'] . "&blogid=" . $blog->id . "\" style=\"color: #7A7376;\"><div style=\"width:100%\">" . $row['comment'] . "</div></a></td>

                <td>" . $row['id'] . "</td>

                <td class=\"text-center\"> 

                  <a class=\"icon icon-trash\" data-confirm=\"$lang[DEL_COMMENT] &laquo;" . $comment_user . " - " . $row['comment'] . "&raquo;\" title=\"DELETE " . $row['id'] . "\" href=\"index.php?plugin=blog&pluginpage=blog-deletecomment&item=kill&commentid=".$row['id']."&blogid=".$blog->id."&itemid=".$row['itemid']."&delete=true\">
                  </a>

                  <a class=\"fa fa-trash-o\" role=\"dialog\" data-confirm=\"$lang[DEL_ENTRY] &laquo;" . $row['id'] . " / " . $row['comment'] . "&raquo;\"
                  title=\"" . $lang['DEL'] . "\" href=\"index.php?plugin=blog&pluginpage=blog-comments&blogid=" . $blog->id . "&commentid=" . $row['id'] . "&itemid=" . $row['itemid'] . "&deletecomment=true\">
                  </a>
                </td>
              </tr>";
    }
    ?>
    </tbody>
</table>
    </div>
</div>