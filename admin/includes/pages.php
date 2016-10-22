<?php
// CHECK PAGE OBJECT
if (!isset($page)) // if no page object is set
{   // create new page object
    $page = new YAWK\page();
}

// TOGGLE PAGE
if (isset($_GET['toggle']) && ($_GET['toggle'] === "1"))
{   // check if vars are set
    if (isset($_GET['id']) && isset($_GET['published']) && isset($_GET['title']))
    {   // toggle page
        if(!$page->toggleOffline($db, $_GET['id'], $_GET['published'], $_GET['title']))
        {   // all good, notify msg
            \YAWK\alert::draw("danger", "Could not toggle page item!", "Please try again.", "", 5800);
        }
    }
}

// LOCK PAGE
if (isset($_GET['lock']) && ($_GET['lock']) === "1")
{
    // check if vars are set
    if (isset($_GET['id']) && (isset($_GET['locked'])))
    {
        // escape vars
        $id = $db->quote($_GET['id']);
        $locked = $db->quote($_GET['locked']);

        if ($locked === '1') { $setLock = 0; $status = "unlocked"; $color="success"; }
        if ($locked === '0') { $setLock = 1; $status = "locked"; $color="danger"; }
        else { $setLock = 0; }

        // execute page lock
        if ($page->toggleLock($db, $id, $setLock))
        {
            // successful, throw notification
            \YAWK\alert::draw("$color", "Page is $status", "Page $status successfully.", "",800);
        }
        else
        {   // throw error msg
            \YAWK\alert::draw("danger", "Error", "Could not toggle page lock.","page=pages", 4300);
        }
    }
}

// DELETE PAGE
if (isset($_GET['del']) && ($_GET['del'] === "1"))
{
    if (isset($_GET['delete']) && ($_GET['delete'] == "true")){
        // if page obj != set
        if (isset($_GET['alias']))
        {   // quote alias and load properties
            $_GET['alias'] = $db->quote($_GET['alias']);
            $page->loadProperties($db, $_GET['alias']);
        }
        // ok, delete page
        if ($page->delete($db))
        {   // success
            \YAWK\alert::draw("success", "Erfolg!", "Die Seite " . $_GET['alias'] . " wurde gel&ouml;scht!","", 800);
           // \YAWK\backend::setTimeout("index.php?page=pages",1260);
        }
        else
        {   // failed
            \YAWK\alert::draw("danger", "Error!", "Die Seite " . $_GET['alias'] . " konnte nicht gel&ouml;scht werden!", "", 6800);
        }
    }
}

// COPY PAGE
if (isset($_GET['copy']) && ($_GET['copy'] === "true"))
{
    // check if vars are set
    if (isset($_GET['alias']))
    {   // escape vars
        $_GET['alias'] = $db->quote($_GET['alias']);
        // load properties for given page
        $page->loadProperties($db, $_GET['alias']);
        // copy page
        if($page->copy($db))
        {   // all good.
            print \YAWK\alert::draw("success", "Erfolg!", "Die Seite ".$_GET['alias']." wurde kopiert!", "", "1200");
        }
        else
            {   // copy failed, throw error
                print \YAWK\alert::draw("danger", "Could not copy page $_GET[alias]", "Please try again.", "", "6800");
            }
    }
}

?>
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


<!--
<div class="box box-default">
    <div class="box-body"> -->

<div class="box box-default">
    <div class="box-body">

        <a class="btn btn-success pull-right" href="index.php?page=page-new">
            <i class="glyphicon glyphicon-plus"></i> &nbsp;<?php print $lang['PAGE+']; ?></a>

<table width="100%" cellpadding="4" cellspacing="0" border="0" class="table table-striped table-hover" id="table-sort">
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

        if ($row['locked'] !== '0')
        {   // PAGE IS LOCKED
            $lockIcon = "<i class=\"fa fa-lock\"></i>";
            $lockHover = "style=\"cursor:not-allowed;\"";
            $lockHref = "href=\"#\"";
            $lockLink = "href=\"index.php?page=pages&lock=1&id=".$row['id']."&locked=".$row['locked']."\"";
            $lockTitle = "title=\"".$lang['PAGE_UNLOCK']."\"";
            $lockLinkTitle = "title=\"".$lang['PAGE_LOCKED']."\"";
            $lockAction = "<a class=\"fa fa-unlock-alt\" ".$lockTitle." ".$lockLink."></a>&nbsp;";
            $lockEditLink = "href=\"index.php?page=pages&lock=1&id=".$row['id']."&locked=".$row['locked']."\"";
            $lockDeleteLink = "href = \"#\" ".$lockHover." ";
            $lockCopyLink = "".$lockHover." href=\"#\"";
        }
        else
        {   // PAGE IS NOT LOCKED
            $lockIcon = '';
            $lockHover = '';
            $lockLink = "href=\"index.php?page=pages&lock=1&id=".$row['id']."&locked=".$row['locked']."\"";
            $lockHref = "href=\"index.php?page=page-edit&alias=".$row['alias']."&id=".$row['id']."\"";
            $lockTitle = "title=\"".$lang['PAGE_LOCK']."\"";
            $lockLinkTitle = "title=\"".$lang['EDIT']."\"";
            $lockAction = "<a class=\"fa fa-lock\" ".$lockTitle." ".$lockLink."></a>&nbsp;";
            $lockCopyLink = "title=\"".$lang['PAGE_COPY']."\" href=\"index.php?page=pages&copy=1&title=".$row['title']."&alias=".$row['alias']."&copy=true\"";
            $lockDeleteLink = "role=\"dialog\" data-confirm=\"Die Seite &laquo;".$row['title']." / ".$row['alias'].".html&raquo; wirklich l&ouml;schen?\"
            title=\"".$lang['PAGE_DELETE']."\" href=\"index.php?page=pages&del=1&alias=".$row['alias']."&delete=true\"";
        }

        echo "<tr>
          <td class=\"text-center\">
            <a title=\"toggle&nbsp;status\" href=\"index.php?page=pages&toggle=1&id=".$row['id']."&title=".$row['title']."&published=".$row['published']."\">
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
<br>


    </div>
</div>

<!-- Start FOOTER -->
<div class="box box-default">
    <div class="box-header with-border">
        <h3 class="box-title"><i class="glyphicon glyphicon-stats"></i> &nbsp;<?PHP print $lang['PAGE_STATS']; ?></h3>
    </div>
    <div class="box-body">
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