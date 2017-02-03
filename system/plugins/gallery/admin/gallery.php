<?php
// check if language is set
if (!isset($language) || (!isset($lang)))
{   // inject (add) language tags to core $lang array
    $lang = \YAWK\language::inject(@$lang, "../system/plugins/gallery/language/");
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
            \YAWK\alert::draw("success", "Gallery deleted successfully.", "Files on disk are <i>not</i> affected.", "", 1200);
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
            \YAWK\alert::draw("success", "Refresh of $_GET[folder] successful.", "Gallery has been updated.", "", 2000);
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
            <li><a href=\"index.php\" title=\"Dashboard\"><i class=\"fa fa-dashboard\"></i> Dashboard</a></li>
            <li><a href=\"index.php?page=plugins\" title=\"Plugins\"> Plugins</a></li>
            <li class=\"active\"><a href=\"index.php?plugin=gallery\" title=\"Gallery\"> Gallery</a></li>
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
                <h3 class="box-title"><i class="fa fa-plus-circle text-muted"></i> &nbsp;Add a new gallery</h3>
            </div>
            <div class="box-body">
                <label for="folder">Select the folder where your images are located</label>
                <?php echo $gallery->drawFolderSelect("media/images/")?>
                <label for="customFolder">or set any different folder</label>
                <input id="customFolder"
                       name="customFolder"
                       type="text"
                       placeholder="media/images/your-images-folder"
                       class="form-control">
                <label for="title">Gallery Title</label>
                <input id="title"
                       name="title"
                       type="text"
                       placeholder="What is your gallery about?"
                       class="form-control">
                <label for="description">Gallery Description <small>(optional)</small></label>
                <input id="description"
                       name="description"
                       type="text"
                       placeholder="Description (can be displayed before the gallery)"
                       class="form-control"><br>
                <!-- SAVE BUTTON -->
                <button type="submit"
                        id="savebutton"
                        name="save"
                        class="btn btn-success pull-right">
                    <i id="savebuttonIcon" class="fa fa-check"></i>&nbsp; <?php print $lang['GALLERY_ADD']; ?>
                </button>
                <br><h4><i class="fa fa-wrench text-muted"></i>&nbsp; Additional settings</h4>
                <input type="hidden" value="0" name="createThumbnails">
                <input type="checkbox" value="1" id="createThumbnails" name="createThumbnails">
                <label for="createThumbnails">Create thumbnails from images?</label>
                <br>
                <label for="thumbnailWidth">Thumbnail width in px</label>
                <input type="text" id="thumbnailWidth" maxlength="12" name="thumbnailWidth" class="form-control" placeholder="200px">

                <h4><i class="fa fa-copyright text-muted"></i> Watermark Settings</h4>
                <label for="watermark">Watermark from custom text</label>
                <input type="text" id="watermark" name="watermark" class="form-control" placeholder="(C) <?php echo date("Y")." photographer"; ?>">
                <label for="watermarkImage">OR from any image</label>
                <input type="text" id="watermarkImage" name="watermarkImage" class="form-control" placeholder="media/images/yourfile.png">
                <label for="watermarkOpacity">Overlay opacity (only with watermark from image)</label>
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
                <label for="watermarkPosition">Watermark Position</label>
                <select id="watermarkPosition" name="watermarkPosition" class="form-control">
                    <option value="---">Where should the watermark be placed?</option>
                    <option value="bottom right">Bottom right</option>
                    <option value="bottom left">Bottom left</option>
                    <option value="top left">Top left</option>
                    <option value="top right">Top right</option>
                    <option value="bottom">Bottom</option>
                    <option value="center">Center</option>
                    <option value="top">Top</option>
                </select>
                <label for="offsetX">Offset X-axis</label>
                <input type="text" id="offsetX" name="offsetX" class="form-control" placeholder="-12" value="-12">
                <label for="offsetY">Offset Y-axis</label>
                <input type="text" id="offsetY" name="offsetY" class="form-control" placeholder="-12" value="-12">
                <label for="watermarkFont">Watermark Font</label>
                <select id="watermarkFont" name="watermarkFont" class="form-control">
                    <?php
                    echo $gallery->scanFonts("../system/fonts/");
                    ?>
                </select>


                <label for="watermarkTextSize">Watermark Text Size</label>
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
                <label for="watermarkColor">Watermark Text Color</label>
                <input type="text" id="watermarkColor" name="watermarkColor" class="form-control color" placeholder="pick a color or leave blank" value="e8e8e8">
                <label for="watermarkBorderColor">Watermark Border Color</label>
                <input type="text" id="watermarkBorderColor" name="watermarkBorderColor" class="form-control color" placeholder="pick a color or leave blank" value="424242">
                <label for="watermarkBorder">Watermark Border Thickness</label>
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

                <label for="author">Photographer</label>
                <input type="text" id="author" name="author" class="form-control" placeholder="Originator of this picture">
                <label for="author">Photographer URL</label>
                <input type="text" id="authorUrl" name="authorUrl" class="form-control" placeholder="http://">

            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="box box-default">
            <div class="box-header">
                <h3 class="box-title">Existing Galleries</h3>
            </div>
            <div class="box-body">
                <?php echo $gallery->getPreview($db, $lang); ?>
            </div>
        </div>
    </div>
</div>
</form>


