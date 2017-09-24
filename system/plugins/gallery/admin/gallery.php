<?php
// check if language is set
if (!isset($language) || (!isset($lang)))
{   // inject (add) language tags to core $lang array
    $lang = \YAWK\language::inject($lang, "../system/plugins/gallery/language/");
}
require_once '../system/plugins/gallery/classes/gallery.php';
/** GALLERY PLUGIN  */
if (!isset($gallery))
{
    $gallery = new \YAWK\PLUGINS\GALLERY\gallery();
}
if (isset($_POST))
{
    // EDIT GALLERY
    if (isset($_GET['edit']) && ($_GET['edit'] === "1"))
    {
        // .... edit page....
    }
    // DELETE GALLERY
    if (isset($_GET['delete']) && ($_GET['delete'] === "1"))
    {   // delete a gallery from database
        if ($gallery->delete($db) == true)
        {   // deletion successfull
            \YAWK\alert::draw("success", "$lang[SUCCESS]", "$lang[GALLERY_DEL_OK] $lang[FILES_NOT_AFFECTED]", "", 1200);
        }
    }
    // ADD NEW GALLERY
    if (isset($_GET['add']) && ($_GET['add'] === "1"))
    {   // add a new gallery to database
        $gallery->add($db);
    }
    // RESCAN GALLERY
    if (isset($_GET['refresh']) && ($_GET['refresh'] === "1"))
    {   // re-scan folder an re-write database
        if ($gallery->reScanFolder($db, $_GET['folder']) == true)
        {   // deletion successfull
            \YAWK\alert::draw("success", "$lang[SUCCESS]", "$lang[REFRESH] $lang[OF] $_GET[folder] $lang[SUCCESSFUL]", "", 2000);
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
echo \YAWK\backend::getTitle($lang['GALLERY'], $lang['GALLERY_SUBTEXT']);
echo"<ol class=\"breadcrumb\">
            <li><a href=\"index.php\" title=\"$lang[DASHBOARD]\"><i class=\"fa fa-dashboard\"></i> $lang[DASHBOARD]</a></li>
            <li><a href=\"index.php?page=plugins\" title=\"$lang[PLUGINS]\"> $lang[PLUGINS]</a></li>
            <li class=\"active\"><a href=\"index.php?plugin=gallery\" title=\"$lang[GALLERY]\"> $lang[GALLERY]</a></li>
         </ol>
    </section>
    <!-- Main content -->
    <section class=\"content\">";
/* page content start here */
?>

<form action="index.php?plugin=gallery&pluginpage=gallery&add=1" role="form" method="POST">
<div class="row">
    <div class="col-md-6">
        <div class="box box-default">
            <div class="box-header">
                <h3 class="box-title"><i class="fa fa-plus-circle text-muted"></i> &nbsp;<?php echo $lang['GALLERY_ADD_NEW']; ?></h3>
            </div>
            <div class="box-body">
                <label for="folder"><?php echo $lang['SELECT_FOLDER_LABEL']; ?></label>
                <?php $gallery->drawFolderSelect($lang, "media/images/")?>
                <label for="customFolder"><?php echo $lang['OR_SET_DIFFERENT_FOLDER']; ?></label>
                <input id="customFolder"
                       name="customFolder"
                       type="text"
                       placeholder="media/images/your-images-folder"
                       class="form-control">
                <label for="title"><?php echo $lang['GALLERY_TITLE']; ?></label>
                <input id="title"
                       name="title"
                       type="text"
                       placeholder="<?php echo $lang['GALLERY_ABOUT']; ?>"
                       class="form-control">
                <label for="description"><?php echo $lang['GALLERY_DESC']; ?><small> <?php echo $lang['OPTIONAL']; ?></small></label>
                <input id="description"
                       name="description"
                       type="text"
                       placeholder="<?php echo $lang['GALLERY_DESC_PLACEHOLDER']; ?>"
                       class="form-control"><br>
                <!-- SAVE BUTTON -->
                <button type="submit"
                        id="savebutton"
                        name="save"
                        class="btn btn-success pull-right">
                    <i id="savebuttonIcon" class="fa fa-check"></i>&nbsp; <?php print $lang['GALLERY_ADD']; ?>
                </button>
                <br><h4><i class="fa fa-wrench text-muted"></i>&nbsp; <?php echo $lang['ADDITIONAL_SETTINGS']; ?></h4>
                <input type="hidden" value="0" name="createThumbnails">
                <input type="checkbox" value="1" id="createThumbnails" name="createThumbnails">
                <label for="createThumbnails"><?php echo $lang['CREATE_THUMBNAILS']; ?></label>
                <br>
                <label for="thumbnailWidth"><?php echo $lang['THUMBNAIL_WIDTH_PX']; ?></label>
                <input type="text" id="thumbnailWidth" maxlength="12" name="thumbnailWidth" class="form-control" placeholder="200px">

                <h4><i class="fa fa-copyright text-muted"></i> <?php echo $lang['WATERMARK_SETTINGS']; ?></h4>
                <label for="watermark"><?php echo $lang['WATERMARK_FROM_CUSTOM_TEXT']; ?></label>
                <input type="text" id="watermark" name="watermark" class="form-control" placeholder="<?php echo "$lang[COPYRIGHT_C] "; echo date("Y")." $lang[PHOTOGRAPHER]"; ?>">
                <label for="watermarkImage"><?php echo $lang['OR_FROM_ANY_IMG']; ?></label>
                <input type="text" id="watermarkImage" name="watermarkImage" class="form-control" placeholder="media/images/yourfile.png">
                <label for="watermarkOpacity"><?php echo $lang['OVERLAY_OPACITY']; ?></label>
                <select id="watermarkOpacity" name="watermarkOpacity" class="form-control">
                    <option value=".1">10%</option>
                    <option value=".2">20%</option>
                    <option value=".3">30%</option>
                    <option value=".4">40%</option>
                    <option value=".5" aria-selected="true" selected>50%</option>
                    <option value=".6">60%</option>
                    <option value=".7">70%</option>
                    <option value=".8">80%</option>
                    <option value=".9">90%</option>
                    <option value="1">100%</option>
                </select>
                <label for="watermarkPosition"><?php echo $lang['WATERMARK_POSITION']; ?></label>
                <select id="watermarkPosition" name="watermarkPosition" class="form-control">
                    <option value="---"><?php echo $lang['WATERMARK_POSITION_PLACEHOLDER']; ?></option>
                    <option value="bottom right"><?php echo $lang['BOTTOM_RIGHT']; ?></option>
                    <option value="bottom left"><?php echo $lang['BOTTOM_LEFT']; ?></option>
                    <option value="top left"><?php echo $lang['TOP_LEFT']; ?></option>
                    <option value="top right"><?php echo $lang['TOP_RIGHT']; ?></option>
                    <option value="bottom"><?php echo $lang['BOTTOM']; ?></option>
                    <option value="center"><?php echo $lang['CENTER']; ?></option>
                    <option value="top"><?php echo $lang['TOP']; ?></option>
                </select>
                <label for="offsetX"><?php echo $lang['OFFSET_X_AXIS']; ?></label>
                <input type="text" id="offsetX" name="offsetX" class="form-control" placeholder="-12" value="-12">
                <label for="offsetY"><?php echo $lang['OFFSET_Y_AXIS']; ?></label>
                <input type="text" id="offsetY" name="offsetY" class="form-control" placeholder="-12" value="-12">
                <label for="watermarkFont"><?php echo $lang['WATERMARK_FONT']; ?></label>
                <select id="watermarkFont" name="watermarkFont" class="form-control">
                    <?php
                    echo $gallery->scanFonts("../system/fonts/");
                    ?>
                </select>

                <label for="watermarkTextSize"><?php echo $lang['WATERMARK_TEXT_SIZE']; ?></label>
                <select id="watermarkTextSize" name="watermarkTextSize" class="form-control">
                    <?php
                    $i = 0;
                    while ($i < 201)
                    {   // get 120 option fields in while loop
                        if ($i == 24) { $selected = "selected"; } else { $selected = ''; }
                        echo "<option value=\"$i\" $selected>$i px</option>";
                        $i++;
                    }

                    ?>
                </select>
                <label for="watermarkColor"><?php echo $lang['WATERMARK_TEXT_COLOR']; ?></label>
                <input type="text" id="watermarkColor" name="watermarkColor" class="form-control color" placeholder="pick a color or leave blank" value="e8e8e8">
                <label for="watermarkBorderColor"><?php echo $lang['WATERMARK_TEXT_BORDERCOLOR']; ?></label>
                <input type="text" id="watermarkBorderColor" name="watermarkBorderColor" class="form-control color" placeholder="pick a color or leave blank" value="424242">
                <label for="watermarkBorder"><?php echo $lang['WATERMARK_BORDER_THICKNESS']; ?></label>
                <select id="watermarkBorder" name="watermarkBorder" class="form-control">
                    <?php
                    $i = 0;
                    while ($i < 201)
                    {   // get 120 option fields in while loop
                        if ($i == 1) { $selected = "selected"; } else { $selected = ''; }
                        echo "<option value=\"$i\" $selected>$i px</option>";
                        $i++;
                    }

                    ?>
                </select>

                <label for="author"><?php echo $lang['PHOTOGRAPHER']; ?></label>
                <input type="text" id="author" name="author" class="form-control" placeholder="<?php echo $lang['PHOTOGRAPHER_PLACEHOLDER']; ?>">
                <label for="author"><?php echo $lang['PHOTOGRAPHER_URL']; ?></label>
                <input type="text" id="authorUrl" name="authorUrl" class="form-control" placeholder="http://">

            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="box box-default">
            <div class="box-header">
                <h3 class="box-title"><?php echo $lang['EXISTING_GALLERIES']; ?></h3>
            </div>
            <div class="box-body">
                <?php echo $gallery->getPreview($db, $lang); ?>
            </div>
        </div>
    </div>
</div>
</form>


