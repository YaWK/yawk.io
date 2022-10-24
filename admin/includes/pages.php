<?php
// IMPORT REQUIRED CLASSES
use YAWK\alert;
use YAWK\backend;
use YAWK\db;
use YAWK\language;

// CHECK REQUIRED OBJECTS
if (!isset($page)) // if no page object is set
{   // create new page object
    $page = new YAWK\page();
}
if (!isset($db))
{   // create database object
    $db = new db();
}
if (!isset($lang))
{   // create language object
    $lang = new language();
}

// TOGGLE PAGE
if (isset($_GET['toggle']) && ($_GET['toggle'] === "1"))
{   // check if vars are set
    if (isset($_GET['id']) && isset($_GET['published']) && isset($_GET['title']))
    {   // toggle page
        if(!$page->toggleOffline($db, $_GET['id'], $_GET['published'], $_GET['title']))
        {   // all good, notify msg
            alert::draw("danger", "$lang[ERROR]", "$lang[PAGE_TOGGLE_FAILED]", "", 5800);
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

        $color = '';
        if ($locked === '1') { $setLock = 0; $status = "$lang[UNLOCKED]"; $color="success"; }
        if ($locked === '0') { $setLock = 1; $status = "$lang[LOCKED]"; $color="danger"; }
        else { $setLock = 0; $status=''; }

        // execute page lock
        if ($page->toggleLock($db, $id, $setLock))
        {
            // successful, throw notification
            alert::draw("$color", "$lang[PAGE] $lang[IS] $status", "$lang[PAGE] $lang[IS] $status", "",800);
        }
        else
        {   // throw error msg
            alert::draw("danger", "$lang[ERROR]", "$lang[PAGE_LOCK_FAILED]","page=pages", 4300);
        }
    }
}

// DELETE PAGE
if (isset($_GET['del']) && ($_GET['del'] === "1"))
{
    if (isset($_GET['delete']) && ($_GET['delete'] == "true")){
        // if page obj != set
        if (isset($_GET['id']))
        {   // quote alias and load properties
            $_GET['id'] = $db->quote($_GET['id']);
            $page->loadPropertiesByID($db, $_GET['id']);
            $page->id = $_GET['id'];
        }
        // ok, delete page
        if ($page->delete($db))
        {   // success
            alert::draw("success", "Erfolg!", "$lang[PAGE] " . $_GET['alias'] . " $lang[PAGE_DEL_OK]","", 800);
           // \YAWK\backend::setTimeout("index.php?page=pages",1260);
        }
        else
        {   // failed
            alert::draw("danger", "Error!", "$lang[PAGE] " . $_GET['alias'] . " $lang[PAGE_DEL_FAILED]", "", 6800);
        }
    }
}

// COPY PAGE
if (isset($_GET['copy']) && ($_GET['copy'] === "true"))
{   // check if vars are set
    if (isset($_GET['alias']))
    {   // escape vars
        $_GET['alias'] = $db->quote($_GET['alias']);
        // load properties for given page
        $page->loadProperties($db, $_GET['alias']);

        echo "<pre>";
        print_r($_POST);
        echo "</pre>";

        // copy page as new language
        if (isset($_GET['newLanguage']) && ($_GET['newLanguage'] === "true"))
        {   // check, if new language was set in modal dialogue
            if (isset($_POST['language']) && (!empty($_POST['language'])))
            {   // set vars for copy page as new language
                $page->language = mb_substr($_POST['language'], 0,2);
                $page->title_new = $_POST['modalTitle'];
                $page->alias_new = $_POST['modalAlias'];
                $page->id = $_POST['pageID'];
                $page->newLanguage = true;
            }
        }
        else
        {   // simple copy file, no new language requested
            $page->title_new = $page->title."_copy";
            $page->alias_new = $page->alias."_copy";
            $page->id = $_GET['id'];
            $page->newLanguage = false;
        }

        // copy page
        if($page->copy($db))
        {   // all good.
            print alert::draw("success", "$lang[SUCCESS]", "$lang[PAGE] ".$_GET['alias']." $lang[PAGE_COPY_OK]", "", "1200");
        }
        else
            {   // copy failed, throw error
                print alert::draw("danger", "$lang[ERROR]", "$_GET[alias] $lang[PAGE_COPY_FAILED]", "", "6800");
            }
    }
}

?>
<script type="text/javascript">

$(document).ready(function() {

    // copy page as new language click handler (modal window send btn)
    $(document).on("click", "#languageCopyLink", function () {
        const pageID = $(this).data('id');
        const alias = $(this).data('alias');
        const title = $(this).data('title');

        // update form fields with values
        $("#pageID").val(pageID);
        $("#modalAlias").val(alias);
        $("#alias").val(alias);
        $("#modalTitle").val(title);
        // update modal form action (insert new alias)
        $('#modalForm').attr('action', 'index.php?page=pages&copy=1&newLanguage=true&copy=true&alias='+alias);

        // update
        $("#titlePageID").text("ID"+pageID+" "+alias+ " "+title);
    });

    $('#table-sort').dataTable( {
        "bPaginate": false,
        "bLengthChange": false,
        "bFilter": true,
        "bSort": true,
        "bInfo": true,
        "bAutoWidth": false
    } );
});
</script>

<!-- Modal --MOVE TO ARCHIVE-- -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModal2Label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form enctype="multipart/form-data" id="modalForm" action="index.php?page=pages&copy=1&newLanguage=true&copy=true" method="POST">
                <input type="hidden" id="pageID" name="pageID">
                <div class="modal-header">
                    <!-- modal header with close controls -->
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i> </button>
                    <br>
                    <div class="col-md-1"><h3 class="modal-title"><i class="fa fa-language"></i></h3></div>
                    <div class="col-md-11"><h3 class="modal-title"><?php echo $lang['COPY_PAGE_NEW_LANGUAGE']; ?> </h3>
                        <div id="titlePageID"></div>
                    </div>
                </div>

                <!-- modal body -->
                <div class="modal-body">
                    <label for="modalAlias"><?php echo $lang['FILENAME']; ?></label>
                    <input type="text" class="form-control" id="modalAlias" name="modalAlias" placeholder="<?php echo $lang['FILENAME']; ?>" readonly>

                    <label for="modalTitle"><?php echo $lang['NEW_PAGE_TITLE']; ?></label>
                    <input type="text" class="form-control" id="modalTitle" name="modalTitle" placeholder="<?php echo $lang['NEW_PAGE_TITLE']; ?>">

                    <label for="language"><?php echo $lang['ASSIGN_NEW_LANGUAGE']; ?></label>
                    <select id="language" name="language" class="form-control">
                        <?php echo language::drawLanguageSelectOptions(); ?>
                    </select>
                </div>

                <!-- modal footer /w submit btn -->
                <div class="modal-footer">
                    <input class="btn btn-large btn-default" data-dismiss="modal" aria-hidden="true" type="submit" value="<?php echo $lang['CANCEL']; ?>">
                    <button class="btn btn-large btn-success" type="submit"><i class="fa fa-check"></i>&nbsp; <?php echo $lang['PAGE_COPY']; ?></button>
                    <br><br>
                </div>
            </form>
        </div> <!-- modal content -->
    </div> <!-- modal dialog -->
</div> <!-- modal fade window -->

<?php
    // TEMPLATE WRAPPER - HEADER & breadcrumbs
echo "
    <!-- Content Wrapper. Contains page content -->
    <div class=\"content-wrapper\" id=\"content-FX\">
    <!-- Content Header (Page header) -->
    <section class=\"content-header\">";
    /* draw Title on top */
    echo backend::getTitle($lang['PAGES'], $lang['PAGES_SUBTEXT']);
    echo"<ol class=\"breadcrumb\">
            <li><a href=\"index.php\" title=\"$lang[DASHBOARD]\"><i class=\"fa fa-dashboard\"></i> $lang[DASHBOARD]</a></li>
            <li class=\"active\"><a href=\"index.php?page=pages\" title=\"$lang[PAGES]\"> $lang[PAGES]</a></li>
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

<table style="width: 100%; border-collapse: collapse;" class="table table-striped table-hover table-responsive" id="table-sort">
  <thead>
    <tr>
      <td style="width: 3%;"><b><?php echo $lang['STATUS']; ?> </b></td>
      <td style="width: 3%;"><b>&nbsp;</b></td>
      <td style="width: 3%;"><b><?php echo $lang['ID']; ?> </b></td>
      <td style="width: 30%;"><b><i class="fa fa-caret-down"></i> <?php print $lang['TITLE']; ?></b></td>
      <td style="width: 30%;"><b><i class="fa fa-caret-down"></i> <?php print $lang['FILENAME']; ?></b></td>
      <td style="width: 5%" class="text-center"><b><?php print $lang['TYPE']; ?></b></td>
      <td style="width: 5%" class="text-center"><b><?php print $lang['RIGHTS']; ?></b></td>
      <td style="width: 5%" class="text-center"><b><?php print $lang['LANGUAGE']; ?></b></td>
      <td style="width: 16%" class="text-center"><b><?php print $lang['ACTIONS']; ?></b></td>
    </tr>
  </thead>
  <tbody>

<?php
$i_pages = 0;
$i_pages_published = 0;
$i_pages_unpublished = 0;

    /* get all pages */
    $rows = backend::getPagesArray($db);
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
            $type = "<a href=\"index.php?plugin=".$row['plugin']."\">$lang[PLUGIN]</a>";
        }
        else {
            // is it a blog?
            if ($row['blogid'] !== '0')
            {
                $type = "<a href=\"index.php?plugin=blog&pluginpage=blog-entries&blogid=".$row['blogid']."\">$lang[BLOG]</a>";
            } else {
                // its surely a static page
                $type = "$lang[PAGE]";
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
            $lockLanguageCopyTitle = "title=\"".$lang['ASSIGN_NEW_LANGUAGE']."\"";
            $lockAction = "<a class=\"fa fa-unlock-alt\" ".$lockTitle." ".$lockLink."></a>&nbsp;";
            $lockEditLink = "href=\"index.php?page=pages&lock=1&id=".$row['id']."&locked=".$row['locked']."\"";
            $lockDeleteLink = "href = \"#\" ".$lockHover." ";
            $lockCopyLink = "".$lockHover." href=\"#\"";
            $lockLanguageCopyLink = "".$lockHover." href=\"#\"";
        }
        else
        {   // PAGE IS NOT LOCKED
            $lockIcon = '';
            $lockHover = '';
            $lockLink = "href=\"index.php?page=pages&lock=1&id=".$row['id']."&locked=".$row['locked']."\"";
            $lockHref = "href=\"index.php?page=page-edit&id=".$row['id']."\"";
            $lockTitle = "title=\"".$lang['PAGE_LOCK']."\"";
            $lockLinkTitle = "title=\"".$lang['EDIT']."\"";
            $lockLanguageCopyTitle = "title=\"".$lang['ASSIGN_NEW_LANGUAGE']."\"";
            $lockAction = "<a class=\"fa fa-lock\" ".$lockTitle." ".$lockLink."></a>&nbsp;";
            $lockCopyLink = "title=\"".$lang['PAGE_COPY']."\" href=\"index.php?page=pages&copy=1&title=".$row['title']."&id=".$row['id']."&alias=".$row['alias']."&copy=true\"";
            $lockDeleteLink = "role=\"dialog\" data-confirm=\"$lang[PAGE] &laquo;".$row['title']." / ".$row['alias'].".html&raquo; $lang[PAGE_DEL_CONFIRM]\"
            title=\"".$lang['PAGE_DELETE']."\" href=\"index.php?page=pages&del=1&alias=".$row['alias']."&id=".$row['id']."&delete=true\"";
            $lockLanguageCopyLink = "id=\"languageCopyLink\" data-toggle=\"modal\" data-target=\"#myModal\" data-title=\"".$row['title']."\" data-alias=\"".$row['alias']."\" data-id=\"".$row['id']."\" ";
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
          <td class=\"text-center\">".$row['lang']."</td>
          <td class=\"text-center\">
            ".$lockAction."
            <a class=\"fa fa-copy\" ".$lockCopyLink." ></a>&nbsp;
            <a class=\"fa fa-edit\" ".$lockHover." ".$lockLinkTitle." ".$lockHref."></a>&nbsp;
            <a class=\"fa fa-language\" style=\"cursor: pointer\" ".$lockLanguageCopyLink." ".$lockLanguageCopyTitle."></a>&nbsp;
            <a class=\"fa fa-trash-o\" ".$lockDeleteLink."></a>&nbsp;
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
        <h3 class="box-title"><i class="glyphicon glyphicon-stats"></i> &nbsp;<?php print $lang['PAGE_STATS']; ?></h3>
    </div>
    <div class="box-body">
        <?php
        $page = $lang['PAGE'];
        $pages = $lang['PAGES'];

        if ($i_pages > 1) { $seiten="$i_pages $pages $lang[OVERALL]"; }
        else if ($i_pages = 1) { $seiten="$i_pages $page"; }
        else { $seiten = "$lang[NO_PAGE_CREATED]"; }

        if ($i_pages_published > 1) { $pub="$i_pages_published $pages $lang[PUBLISHED]"; }
        else if ($i_pages_published == 1) { $pub="$i_pages_published $page $lang[PUBLISHED]."; }
        else { $pub = "$lang[NO_PAGE_PUBLISHED]"; }

        if ($i_pages_unpublished > 1) { $unpub="$i_pages_unpublished $pages $lang[OFFLINE]"; }
        else if ($i_pages_unpublished === '1') { $unpub="$i_pages_unpublished $page "; }
        else { $unpub = $lang['PAGES_ONLINE']; }

        // stats on bottom of page
        echo "$seiten<br>
          $pub<br>
          $unpub";
        ?>
    </div>
</div>