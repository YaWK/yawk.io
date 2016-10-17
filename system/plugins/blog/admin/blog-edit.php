<?php
// include blog class
include '../system/plugins/blog/classes/blog.php';
// create object if needed
if (!isset($blog)) { $blog = new \YAWK\PLUGINS\BLOG\blog(); }
// load blog properties
$blog->loadItemProperties($db, $_GET['blogid'], $_GET['itemid']);

// SAVE BLOG ENTRY
if (isset($_POST['save'])) {
    // check if blogtitle is set
    if (!isset($_POST['blogtitle']) || (empty($_POST['blogtitle'])))
    {   // blogtitle is empty, set unnamed as default value
        $_POST['blogtitle'] = "unnamed";
    }
    // check if filename is set
    if (!isset($_POST['filename']) || (empty($_POST['filename'])))
    {   // user entered no filename, take blogtitle as filename (processing will be done in save function)
        $_POST['filename'] = $_POST['blogtitle'];
    }
    // check if meta description is set
    if (!isset($_POST['metadescription']) || (empty($_POST['metadescription'])))
    {   // if not, take blogtitle as description
        $_POST['metadescription'] = $_POST['blogtitle'];
    }
    // check if meta keywords are set
    if (!isset($_POST['metakeywords']) || (empty($_POST['metakeywords'])))
    {   // if not, take blogtitle as description
        $_POST['metakeywords'] = "";
    }

    // quote post vars
    $blog->blogtitle = $db->quote($_POST['blogtitle']);
    $blog->filename = $db->quote($_POST['filename']);
    $blog->subtitle = $db->quote($_POST['subtitle']);
    $blog->published = $db->quote($_POST['published']);
    $blog->itemid = $db->quote($_POST['itemid']);
    $blog->itemgid = $db->quote($_POST['itemgid']);
    $blog->date_publish = $db->quote($_POST['date_publish']);
    $blog->date_unpublish = $db->quote($_POST['date_unpublish']);
    $blog->blogid = $db->quote($_POST['blogid']);
    $blog->teasertext = $db->quote($_POST['teasertext']);
    $blog->blogtext = $db->quote($_POST['blogtext']);
    $blog->pageid = $db->quote($_POST['pageid']);
    $blog->thumbnail = $db->quote($_POST['thumbnail']);
    $blog->youtubeUrl = $db->quote($_POST['youtubeUrl']);
    $blog->metakeywords = $db->quote($_POST['metakeywords']);
    $blog->metadescription = $db->quote($_POST['metadescription']);

    // increment sortation variable
    $blog->sort++;

    // tinyMCE \r\n bugfix
    // $blog->text = stripslashes(str_replace('\r\n', '', ($blog->blogtext)));
    if ($blog->save($db))
    {   // throw success notify
        YAWK\alert::draw("success", "Hooray!", "Der Eintrag wurde erfolgreich gespeichert!", "", "800");
    }
    else
    {   // saving failed, throw error
        YAWK\alert::draw("danger", "Fehler", "Das Blog ID " . $_GET['blogid'] . " " . $_POST['title'] . " - " . $_POST['subtitle'] . " konnte nicht gespeichert werden.","","3800");
    }
}
// path to cms
$dirprefix = YAWK\sys::getDirPrefix($db);
// get host URL
$host = YAWK\sys::getHost($db);

// TEMPLATE WRAPPER - HEADER & breadcrumbs
echo "
    <!-- Content Wrapper. Contains page content -->
    <div class=\"content-wrapper\" id=\"content-FX\">
    <!-- Content Header (Page header) -->
    <section class=\"content-header\">";
/* draw Title on top */
\YAWK\PLUGINS\BLOG\blog::getBlogTitle($blog->blogtitle, $lang['EDIT'], $blog->icon);
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
<link href="../system/engines/summernote/dist/summernote.css" rel="stylesheet">
<script src="../system/engines/summernote/dist/summernote.min.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $('#summernote').summernote({
            height: 120,                 // set editor height
            minHeight: null,             // set minimum height of editor
            maxHeight: null,             // set maximum height of editor
            focus: true,                 // set focus to editable area after initializing summernote
            codemirror: { // codemirror options
                theme: 'monokai'
            }

        });
        $('#summernote2').summernote({
            height: 360,                 // set editor height
            minHeight: null,             // set minimum height of editor
            maxHeight: null,             // set maximum height of editor
            focus: false,                 // set focus to editable area after initializing summernote
            codemirror: { // codemirror options
                theme: 'monokai'
            }

        });
    });
</script>

<!-- bootstrap date-timepicker -->
<link type="text/css" href="../system/engines/datetimepicker/css/datetimepicker.min.css" rel="stylesheet"/>
<script type="text/javascript" src="../system/engines/datetimepicker/js/bootstrap-datetimepicker.min.js"></script>
<script type="text/javascript">
    /* start own JS bootstrap function
     ...on document ready... letsego! */
    $(document).ready(function () {
        $('#datetimepicker1').datetimepicker({
            format: 'yyyy-mm-dd hh:ii'
        });
        $('#datetimepicker2').datetimepicker({
            format: 'yyyy-mm-dd hh:ii'
        });
    });//]]>  /* END document.ready */
    /* ...end admin jQ controlls  */
</script>
<!-- end datetimepicker -->

<?php
$blog->icon = $blog->getBlogProperty($db, $blog->blogid, "icon");
$blog->name = $blog->getBlogProperty($db, $blog->blogid, "name");
/* draw Title on top */

?>

<form name="form" role="form"
      action="index.php?plugin=blog&pluginpage=blog-edit&blogid=<?php print $blog->blogid; ?>&itemid=<?php print $blog->itemid; ?>"
      method="post">

<div class="row">
    <div class="col-md-9">
        <label for="blogtitle"><?php print $lang['TITLE']; ?></label>
        <input type="text"
               class="form-control"
               id="blogtitle"
               name="blogtitle"
               value="<?php print $blog->blogtitle; ?>">
        <br>
    <!-- EDITOR -->
    <?php if ($blog->layout !== "3")
    {
        echo "
        <label for=\"summernote\">Teaser Text</label>
        <textarea
            id=\"summernote\"
            class=\"form-control\"
            style=\"margin-top:10px;\"
            name=\"teasertext\"
            cols=\"50\"
            rows=\"18\">
            $blog->teasertext
        </textarea>
    <br>";
    }
        ?>
    <!-- EDITOR -->
    <label for="summernote2">Blog Text</label>
    <textarea
        id="summernote2"
        class="form-control"
        style="margin-top:10px;"
        name="blogtext"
        cols="50"
        rows="18">
        <?php print $blog->blogtext; ?>
    </textarea>
    </div> <!-- end left col -->

    <div class="col-md-3">
    <!-- right col -->
        <!-- SAVE BUTTON -->
        <button type="submit"
                id="savebutton"
                name="save"
                class="btn btn-success pull-right">
                <i id="savebuttonIcon" class="fa fa-check"></i> &nbsp;<?php print $lang['SAVE_CHANGES']; ?>
        </button>

        <!-- CANCEL BUTTON -->
        <a class="btn btn-default pull-right" href="index.php?plugin=blog&pluginpage=blog-entries&blogid=<?php echo $_GET['blogid']; ?>">
            <i id="cancelbuttonIcon" class="fa fa-backward"></i> &nbsp;<?php print $lang['BACK']; ?>
        </a>

        <br><br><br>

            <?php
            // SETTINGS: filename + subtitle
            $header = "<i class=\"fa fa-file-text-o\"></i>&nbsp; Einstellungen <small>Titel & Dateiname</small>";
            $content = "<label for=\"filename\">$lang[FILENAME]</label><br>
                    <input type=\"text\"
                               class=\"form-control\"
                               name=\"filename\"
                               id=\"filename\"
                               size=\"64\"
                               maxlength=\"255\"
                               value=\"$blog->filename\">
                    <label for=\"subtitle\">$lang[SUBTITLE]</label><br>
                    <input type=\"text\"
                               class=\"form-control\"
                               name=\"subtitle\"
                               id=\"subtitle\"
                               size=\"64\"
                               maxlength=\"255\"
                               value=\"$blog->subtitle\">";
            echo \YAWK\AdminLTE::drawCollapsableBox($header, $content);
            ?>

            <!-- PUBLISHING -->
            <div class="box box-default">
                <div class="box-header with-border">
                    <h3 class="box-title"><i class="fa fa-clock-o"></i>&nbsp;&nbsp;Ver&ouml;ffentlichung <small>Zeitpunkt & Privatsph&auml;re</small></h3>
                    <!-- box-tools -->
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                        </button>
                    </div>
                    <!-- /.box-tools -->
                </div>
                <!-- /.box-header -->
                <div class="box-body" style="display: block;">

                    <!-- start publish datetimepicker -->
                    <label for="datetimepicker1"><i class="fa fa-calendar"></i> <?php print $lang['START_PUBLISH']; ?></label><br>
                    <input
                        class="form-control"
                        id="datetimepicker1"
                        data-date-format="yyyy-mm-dd hh:mm:ss"
                        type="text"
                        name="date_publish"
                        maxlength="19"
                        value="<?php print $blog->date_publish; ?>">

                    <!-- end publish datetimepicker -->
                    <label for="datetimepicker2"><i class="fa fa-ban"></i> <?php print $lang['END_PUBLISH']; ?></label><br>
                    <input
                        type="text"
                        class="form-control"
                        id="datetimepicker2"
                        name="date_unpublish"
                        data-date-format="yyyy-MM-dd hh:mm:ss"
                        maxlength="19"
                        value="<?php print $blog->date_unpublish; ?>">

                    <!-- group id selector -->
                    <label for="gidselect"><i class="fa fa-users"></i> <?php print $lang['PAGE_VISIBLE']; ?></label>
                    <select id="gidselect" name="itemgid" class="form-control">
                        <option value="<?php print \YAWK\sys::getGroupId($db, $blog->pageid, "pages"); ?>" selected><?php print \YAWK\user::getGroupNameFromID($db, $blog->itemgid); ?></option>
                        <?php
                        foreach(YAWK\sys::getGroups($db, "pages") as $role) {
                            print "<option value=\"".$role['id']."\"";
                            if (isset($_POST['gid'])) {
                                if($_POST['gid'] === $role['id']) {
                                    print " selected=\"selected\"";
                                }
                                else if($blog->itemgid === $role['id'] && !$_POST['itemgid']) {
                                    print " selected=\"selected\"";
                                }
                            }
                            print ">".$role['value']."</option>";
                        }
                        ?>
                    </select>

                    <!-- PAGE ON / OFF STATUS -->
                    <label for="published"><i class="fa fa-eye"></i> <?php print $lang['ENTRY'];print"&nbsp;";print $lang['ONLINE']; ?></label><br>
                    <?php if($blog->published == 1){
                        $publishedHtml = "<option value=\"1\" selected=\"selected\">online</option>";
                        $publishedHtml .= "<option value=\"0\" >offline</option>";
                    } else {
                        $publishedHtml = "<option value=\"0\" selected=\"selected\">offline</option>";
                        $publishedHtml .= "<option value=\"1\" >online</option>";
                    } ?>
                    <select id="published" name="published" class="form-control">
                        <?php echo $publishedHtml; ?>
                    </select>
                </div>
                <!-- /.box-body -->
            </div>

            <!-- META TAGS -->
            <div class="box box-default">
                <div class="box-header with-border">
                    <h3 class="box-title"><i class="fa fa-google"></i>&nbsp;&nbsp;Meta Tags <small>Suchmaschinenoptimierung f&uuml;r diese Seite.</small></h3>
                    <!-- box-tools -->
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                        </button>
                    </div>
                    <!-- /.box-tools -->
                </div>
                <!-- /.box-header -->
                <div class="box-body" style="display: block;">
                    <!-- LOCAL META SITE DESCRIPTION -->
                    <label for="metadescription">Meta Description</label><br>
                    <textarea cols="64"
                              rows="2"
                              id="metadescription"
                              class="form-control"
                              maxlength="255"
                              placeholder="Page Description shown on Google"
                              name="metadescription"><?php $page = new \YAWK\page(); print $page->getMetaTags($db, $blog->pageid, "description"); ?>
                    </textarea>
                    <!-- LOCAL META SITE KEYWORDS -->
                    <label for="metakeywords">Meta Keywords</label>
                    <input type="text"
                           size="64"
                           id="metakeywords"
                           class="form-control"
                           placeholder="keyword1, keyword2, keyword3..."
                           name="metakeywords"
                           value="<?php print $page->getMetaTags($db, $blog->pageid, "keywords");  ?>">
                </div>
                <!-- /.box-body -->
            </div>

            <!-- blog thumbnail -->
            <div class="box box-default">
                <div class="box-header with-border">
                    <h3 class="box-title"><i class="fa fa-photo"></i>&nbsp;&nbsp;Vorschau <small>Foto im Teaser</small></h3>
                    <!-- box-tools -->
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                        </button>
                    </div>
                    <!-- /.box-tools -->
                </div>
                <!-- /.box-header -->
                <div class="box-body" style="display: block;">
                    <!-- THUMBNAIL IMAGE -->
                    <label for="thumbnail"><?php print $lang['THUMBNAIL']; ?>:&nbsp;</label><br>
                    <input
                        type="text"
                        class="form-control"
                        id="thumbnail"
                        name="thumbnail"
                        size="64"
                        maxlength="255"
                        placeholder="media/images/anyfile.jpg"
                        value="<?php print $blog->thumbnail; ?>">
                    <label for="thumbnail"><i class="fa fa-youtube"></i> &nbsp;<?php print $lang['YOUTUBEURL']; ?>:&nbsp;</label><br>
                    <!-- YouTube Link -->
                    <input
                        type="text"
                        class="form-control"
                        id="youtubeUrl"
                        name="youtubeUrl"
                        size="64"
                        maxlength="255"
                        placeholder="https://www.youtube.com/embed/1A2B3C4D5E6F"
                        value="<?php print $blog->youtubeUrl; ?>">
                </div>
                <!-- /.box-body -->
            </div>

            <!-- blog thumbnail -->
            <div class="box box-default">
                <div class="box-header with-border">
                    <h3 class="box-title"><i class="fa fa-bars"></i>&nbsp;&nbsp;SubMen&uuml; <small>zusätzliches Men&uuml; auf dieser Seite</small></h3>
                    <!-- box-tools -->
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                        </button>
                    </div>
                    <!-- /.box-tools -->
                </div>
                <!-- /.box-header -->
                <div class="box-body" style="display: block;">
                    <!-- SUB MENU SELECTOR -->
                    <label for="menu">SubMen&uuml;
                        <select name="menu" class="form-control">
                            <option value="<?php print \YAWK\sys::getSubMenu($db, $page->id); ?>"><?php print \YAWK\sys::getMenuItem($db, $page->id); ?></option>
                            <option value="0">-- Kein Men&uuml; --</option>
                            <?php
                            foreach(YAWK\sys::getMenus($db) as $menue){
                                print "<option value=\"".$menue['id']."\"";
                                if (isset($_POST['menu'])) {
                                    if($_POST['menu'] === $menue['id']){
                                        print " selected=\"selected\"";
                                    }
                                    else if($page->menu === $menue['id'] && !$_POST['menu']){
                                        print " selected=\"selected\"";
                                    }
                                }
                                print ">".$menue['name']."</option>";
                            }
                            ?>
                        </select>
                </div>
                <!-- /.box-body -->
            </div>

        <!-- /. ADDITIONAL BOXES-->

    <!-- HIDDEN FIELDS -->
    <input type="hidden" name="blogid" value="<?php print $blog->blogid; ?>"/>
    <input type="hidden" name="itemid" value="<?php print $blog->itemid; ?>"/>
    <input type="hidden" name="pageid" value="<?php print $blog->pageid; ?>"/>

    </div>
</div>
</form>