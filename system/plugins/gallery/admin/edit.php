<?php
require_once '../system/plugins/gallery/classes/gallery.php';
/** GALLERY PLUGIN  */
if (!isset($gallery))
{
    $gallery = new \YAWK\PLUGINS\GALLERY\gallery();
}
if (isset($_POST))
{
    // EDIT GALLERY
    if (isset($_GET['id']) && (is_numeric($_GET['id']) && (!isset($_GET['edit']))))
        {   // load gallery properties
            $gallery->loadProperties($db, $_GET['id']);
        }
    if (isset($_GET['edit']) && ($_GET['edit'] === "1") && (isset($_GET['id']) && (is_numeric($_GET['id']))))
    {
        $gallery->edit($db, $_GET['id']);
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
<link href="../system/engines/jquery/lightbox2/css/lightbox.min.css" rel="stylesheet">
<script src="../system/engines/jquery/lightbox2/js/lightbox.min.js"></script>
<script type="text/javascript">
    lightbox.option({
        'albumLabel': "Image %1 of %2 - you may need to reload (strg-r or f5) to see changes take effect in fullscreen mode.",
        'wrapAround': true
    })
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
            <li><a href=\"index.php?plugin=gallery\" title=\"Gallery\"> Gallery</a></li>
            <li class=\"active\"><a href=\"index.php?plugin=gallery&pluginpage=edit&id=$gallery->id\" title=\"edit $gallery->title\"> edit gallery</a></li>
         </ol>
    </section>
    <!-- Main content -->
    <section class=\"content\">";
/* page content start here */
?>

<form action="index.php?plugin=gallery&pluginpage=edit&edit=1&id=<?php echo $gallery->id; ?>" role="form" method="POST">
    <div class="row">
        <div class="col-md-8">
            <div class="box box-default">
                <div class="box-header">
                    <h3 class="box-title"><i class="fa fa-edit text-muted"></i> &nbsp;edit <i><?php echo $gallery->title; ?></i></h3>
                </div>
                <div class="box-body">
                    <?php echo $gallery->getEditableImages($db, $lang, $gallery->id); ?>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="box box-default">
                <div class="box-header">
                    <h3 class="box-title">Edit this gallery</h3>
                </div>
                <div class="box-body">

                    <label for="folder">Select the folder where your images are located</label>
                    <?php echo $gallery->drawFolderSelectFromGallery("media/images/", "$gallery->folder")?>
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
                           value="<?php echo $gallery->title; ?>"
                           class="form-control">
                    <label for="description">Gallery Description <small>(optional)</small></label>
                    <input id="description"
                           name="description"
                           type="text"
                           placeholder="Description (can be displayed before the gallery)"
                           value="<?php echo $gallery->description; ?>"
                           class="form-control"><br>
                    <!-- SAVE BUTTON -->
                    <button type="submit"
                            id="savebutton"
                            name="save"
                            class="btn btn-success pull-right">
                        <i id="savebuttonIcon" class="fa fa-check"></i>&nbsp; <?php print $lang['GALLERY_EDIT']; ?>
                    </button>
                </div>
            </div>

            <div class="box box-default">
                <div class="box-header">
                    <h3 class="box-title"><i class="fa fa-wrench text-muted"></i>&nbsp; Additional settings</h3>
                </div>
                <div class="box-body">
                    <input type="hidden" value="0" name="createThumbnails">
                    <?php
                    if ($gallery->createThumbnails === "1")
                    {
                        $checked = "checked";
                    }
                    else
                    {
                        $checked = "";
                    }
                    ?>
                    <input type="checkbox" value="<?php echo $gallery->createThumbnails; ?>" id="createThumbnails" name="createThumbnails" <?php echo $checked; ?>>
                    <label for="createThumbnails">Create thumbnails from images?</label>
                    <br>
                    <label for="thumbnailWidth">Thumbnail width in px</label>
                    <input type="text" id="thumbnailWidth" maxlength="12" name="thumbnailWidth" class="form-control" placeholder="200px" value="<?php echo $gallery->thumbnailWidth; ?>">
                </div>
            </div>

            <div class="box box-default">
                <div class="box-header">
                    <h3 class="box-title"><i class="fa fa-copyright text-muted"></i> Watermark Settings</h3>
                </div>
                <div class="box-body">
                    <label for="watermark">Watermark from custom text</label>
                    <input type="text" id="watermark" name="watermark" class="form-control" placeholder="(C) <?php echo date("Y")." photographer"; ?>" value="<?php echo $gallery->watermark; ?>">
                    <label for="watermarkImage">OR from any image</label>
                    <input type="text" id="watermarkImage" name="watermarkImage" class="form-control" placeholder="media/images/yourfile.png" value="<?php echo $gallery->watermarkImage; ?>">
                    <label for="watermarkOpacity">Overlay opacity (only with watermark from image)</label>
                    <select id="watermarkOpacity" name="watermarkOpacity" class="form-control">

                        <option value="<?php echo $gallery->watermarkOpacity; ?>" aria-selected="true" selected><?php echo $gallery->watermarkOpacity; ?></option>
                        <option value=".1">10%</option>
                        <option value=".2">20%</option>
                        <option value=".3">30%</option>
                        <option value=".4">40%</option>
                        <option value=".5">50%</option>
                        <option value=".6">60%</option>
                        <option value=".7">70%</option>
                        <option value=".8">80%</option>
                        <option value=".9">90%</option>
                        <option value="1">100%</option>
                    </select>
                    <label for="watermarkPosition">Watermark Position</label>
                    <select id="watermarkPosition" name="watermarkPosition" class="form-control">
                        <option value="<?php echo $gallery->watermarkPosition; ?>"><?php echo $gallery->watermarkPosition; ?></option>
                        <option value="bottom right">Bottom right</option>
                        <option value="bottom left">Bottom left</option>
                        <option value="top left">Top left</option>
                        <option value="top right">Top right</option>
                        <option value="bottom">Bottom</option>
                        <option value="center">Center</option>
                        <option value="top">Top</option>
                    </select>
                    <label for="offsetRight">Offset from right</label>
                    <input type="text" id="offsetRight" name="offsetRight" class="form-control" placeholder="-12" value="<?php echo $gallery->offsetRight; ?>">
                    <label for="offsetBottom">Offset from bottom</label>
                    <input type="text" id="offsetBottom" name="offsetBottom" class="form-control" placeholder="-12" value="<?php echo $gallery->offsetBottom; ?>">
                    <label for="watermarkFont">Watermark Font</label>
                    <select id="watermarkFont" name="watermarkFont" class="form-control">
                        <option value="<?php echo $gallery->watermarkFont; ?>"><?php echo $gallery->watermarkFont; ?></option>
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
                            if ($i == $gallery->watermarkTextSize) { $selected = "selected"; } else { $selected = ''; }
                            echo "<option value=\"$i\" $selected>$i px</option>";
                            $i++;
                        }

                        ?>
                    </select>
                    <label for="watermarkColor">Watermark Text Color</label>
                    <input type="text" id="watermarkColor" name="watermarkColor" class="form-control color" placeholder="pick a color or leave blank" value="<?php echo $gallery->watermarkColor; ?>">
                    <label for="watermarkBorderColor">Watermark Border Color</label>
                    <input type="text" id="watermarkBorderColor" name="watermarkBorderColor" class="form-control color" placeholder="pick a color or leave blank" value="<?php echo $gallery->watermarkBorderColor; ?>">
                    <label for="watermarkBorder">Watermark Border Thickness</label>
                    <select id="watermarkBorder" name="watermarkBorder" class="form-control">
                        <?php
                        $i = 0;
                        while ($i < 201)
                        {   // get 120 option fields in while loop
                            if ($i == $gallery->watermarkBorder) { $selected = "selected"; } else { $selected = ''; }
                            echo "<option value=\"$i\" $selected>$i px</option>";
                            $i++;
                        }

                        ?>
                    </select>

                    <label for="author">Photographer</label>
                    <input type="text" id="author" name="author" class="form-control" value="<?php echo $gallery->author; ?>" placeholder="Originator of this picture">
                    <label for="author">Photographer URL</label>
                    <input type="text" id="authorUrl" name="authorUrl" class="form-control" value="<?php echo $gallery->authorUrl; ?>" placeholder="http://">

                </div>
            </div>
        </div>
    </div>
</form>


