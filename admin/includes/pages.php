<script type="text/javascript">
$(document).ready(function() {
    $('#table-sort').dataTable( {
        "bPaginate": false,
        "bLengthChange": false,
        "bFilter": true,
        "bSort": true,
        "bInfo": true,
        "bAutoWidth": false
    } );
} );
</script>
<?php
    // TEMPLATE WRAPPER - HEADER & breadcrumbs
echo "
    <!-- Content Wrapper. Contains page content -->
    <div class=\"content-wrapper\" id=\"content-FX\">
    <!-- Content Header (Page header) -->
    <section class=\"content-header\">";
    /* draw Title on top */
    echo \YAWK\backend::getTitle($lang['PAGES'], $lang['PAGES_SUBTEXT']);
    echo"<ol class=\"breadcrumb\">
            <li><a href=\"index.php\" title=\"Dashboard\"><i class=\"fa fa-dashboard\"></i> Dashboard</a></li>
            <li class=\"active\"><a href=\"index.php?page=pages\" title=\"Pages\"> Pages</a></li>
         </ol>
    </section>
    <!-- Main content -->
    <section class=\"content\">";
    /* page content start here */
?>

<a class="btn btn-success pull-right" href="index.php?page=page-new">
<i class="glyphicon glyphicon-plus"></i> &nbsp;<?php print $lang['PAGE+']; ?></a>

<table width="100%" cellpadding="4" cellspacing="0" border="0" class="table table-hover" id="table-sort">
  <thead>
    <tr>
      <td width="3%"><strong>Status</strong></td>
      <td width="3%"><strong>&nbsp;</strong></td>
      <td width="3%"><strong>ID</strong></td>
      <td width="30%"><strong><i class="fa fa-caret-down"></i> <?PHP print $lang['TITLE']; ?></strong></td>
      <td width="35%"><strong><i class="fa fa-caret-down"></i> <?PHP print $lang['FILENAME']; ?></strong></td>
      <td width="5%" class="text-center"><strong><?PHP print $lang['TYPE']; ?></strong></td>
      <td width="5%" class="text-center"><strong><?PHP print $lang['RIGHTS']; ?></strong></td>
      <td width="16%" class="text-center"><strong><?PHP print $lang['ACTIONS']; ?></strong></td>
    </tr>
  </thead>
  <tbody>

<?PHP
$i_pages = 0;
$i_pages_published = 0;
$i_pages_unpublished = 0;

    /* get all pages */
    $rows = \YAWK\backend::getPagesArray($db);
    foreach ($rows AS $row) {
        $i_pages++;
        if ($row['published']==='1')
        {
            $pub = "success"; $pubtext="On";
            $i_pages_published = $i_pages_published + 1;
        }
        else {
            $pub = "danger"; $pubtext = "Off";
            $i_pages_unpublished = $i_pages_unpublished +1;
        }
        // check type of page...
        // does it host a plugin?
        if ($row['plugin'] !== '0'){
            $type = "<a href=\"index.php?plugin=".$row['plugin']."\">plugin</a>";
        }
        else {
            // is it a blog?
            if ($row['blogid'] !== '0')
            {
                $type = "<a href=\"index.php?plugin=blog&pluginpage=blog-entries&blogid=".$row['blogid']."\">blog</a>";
            } else {
                // its surely a static page
                $type = "page";
            }
        }

        if ($row['locked'] !== '0') {
            $lockIcon = "<i class=\"fa fa-lock\"></i>";
            $lockHover = "style=\"cursor:not-allowed;\"";
            $lockHref = "href=\"#\"";
            $lockLink = "href=\"index.php?page=page-lock&id=".$row['id']."&locked=".$row['locked']."\"";
            $lockTitle = "title=\"".$lang['PAGE_UNLOCK']."\"";
            $lockLinkTitle = "title=\"".$lang['PAGE_LOCKED']."\"";
            $lockAction = "<a class=\"fa fa-unlock-alt\" ".$lockTitle." ".$lockLink."></a>&nbsp;";
            $lockEditLink = "href=\"index.php?page=page-lock&id=".$row['id']."&locked=".$row['locked']."\"";
            $lockDeleteLink = "href = \"#\" ".$lockHover." ";
            $lockCopyLink = "".$lockHover." href=\"#\"";
        } else {
            $lockIcon = '';
            $lockHover = '';
            $lockLink = "href=\"index.php?page=page-lock&id=".$row['id']."&locked=".$row['locked']."\"";
            $lockHref = "href=\"index.php?page=page-edit&alias=".$row['alias']."&id=".$row['id']."\"";
            $lockTitle = "title=\"".$lang['PAGE_LOCK']."\"";
            $lockLinkTitle = "title=\"".$lang['EDIT']."\"";
            $lockAction = "<a class=\"fa fa-lock\" ".$lockTitle." ".$lockLink."></a>&nbsp;";
            $lockCopyLink = "title=\"".$lang['PAGE_COPY']."\" href=\"index.php?page=page-copy&title=".$row['title']."&alias=".$row['alias']."&copy=true\"";
            $lockDeleteLink = "role=\"dialog\" data-confirm=\"Die Seite &laquo;".$row['title']." / ".$row['alias'].".html&raquo; wirklich l&ouml;schen?\"
            title=\"".$lang['PAGE_DELETE']."\" href=\"index.php?page=page-delete&alias=".$row['alias']."\"";
        }

        echo "<tr>
          <td class=\"text-center\">
            <a title=\"toggle&nbsp;status\" href=\"index.php?page=page-toggle&id=".$row['id']."&title=".$row['title']."&published=".$row['published']."\">
            <span class=\"label label-$pub\">$pubtext</span></a>&nbsp;</td>
          <td>".$lockIcon."</i></td>
          <td>".$row['id']."</td>
          <td><a ".$lockHover." ".$lockLinkTitle." ".$lockHref."><div style=\"width:100%\">".$row['title']."</div></a></td>
          <td><a ".$lockHover." ".$lockLinkTitle." ".$lockHref."><div style=\"width:100%\">".$row['alias'].".html</div></a></td>

          <td class=\"text-center\">".$type."</td>
          <td class=\"text-center\">".$row['gid']."</td>
          <td class=\"text-center\">

            ".$lockAction."
            <a class=\"fa fa-copy\" ".$lockCopyLink." ></a>&nbsp;
            <a class=\"fa fa-edit\" ".$lockHover." ".$lockLinkTitle." ".$lockHref."></a>&nbsp;
            <a class=\"fa fa-trash-o\" ".$lockDeleteLink.">
            </a>
          </td>
        </tr>";
    }
?>

  </tbody>
</table>

<!-- End of Page --> 
<br><br>
<!-- Start FOOTER -->
<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title"><i class="glyphicon glyphicon-stats"></i> &nbsp;<?PHP print $lang['PAGE_STATS']; ?></h3>
  </div>
  <div class="panel-body">
  <?PHP  $page = $lang['PAGE'];
    $pages = $lang['PAGES'];

    if ($i_pages > 1) { $seiten="$i_pages $pages $lang[OVERALL]"; }
    else if ($i_pages = 1) { $seiten="$i_pages $page angelegt"; }
    else { $seiten = "Es wurde noch keine $page angelegt"; }

    if ($i_pages_published > 1) { $pub="$i_pages_published $pages published"; }
    else if ($i_pages_published === '1') { $pub="$i_pages_published $page published"; }
    else { $pub = "Es wurde noch keine $page published"; }

    if ($i_pages_unpublished > 1) { $unpub="$i_pages_unpublished $pages sind offline"; }
    else if ($i_pages_unpublished === '1') { $unpub="$i_pages_unpublished $page ist offline"; }
    else { $unpub = $lang['PAGES_ONLINE']; }

    // stats on bottom of page
    echo "$seiten<br>
          $pub<br>
          $unpub";
  ?>
  </div>
</div>
