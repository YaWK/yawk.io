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
        if ($gallery->reScanFolder($db, $_GET['id']))
        {   // deletion successfull
            \YAWK\alert::draw("success", "$lang[SUCCESS]", "$lang[GALLERY_REFRESH_OK] $_GET[folder] $lang[UPDATED]", "", 5800);
        }
        else
            {   // could not re-scan gallery
                \YAWK\alert::draw("danger", "$lang[ERROR]", "$lang[GALLERY_REFRESH_FAILED]", "", 5800);
            }
    }
}
?>
<link href="../system/engines/jquery/lightbox2/css/lightbox.min.css" rel="stylesheet">
<script src="../system/engines/jquery/lightbox2/js/lightbox.min.js"></script>
<script type="text/javascript">
    lightbox.option({
        'albumLabel': "<?php echo $lang['IMAGE']; ?> %1 <?php echo $lang['OF']; ?> %2 - <?php echo $lang['GALLERY_SAVE_INFO']; ?>",
        'wrapAround': true
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
            <li><a href=\"index.php?plugin=gallery\" title=\"$lang[GALLERY]\"> $lang[GALLERY]</a></li>
            <li class=\"active\"><a href=\"index.php?plugin=gallery&pluginpage=edit&id=$gallery->id\" title=\"$lang[REFRESH]\"> $lang[GALLERY_REFRESH]</a></li>
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
                    <h3 class="box-title"><?php echo $lang['GALLERY_EDIT']; ?></h3>
                </div>
                <div class="box-body">

                    <label for="folder"><?php echo $lang['SELECT_FOLDER']; ?></label>
                    <?php echo $gallery->drawFolderSelectFromGallery("media/images/", "$gallery->folder")?>
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
                           value="<?php echo $gallery->title; ?>"
                           class="form-control">
                    <label for="description"><?php echo $lang['GALLERY_DESC']; ?><small> <?php echo $lang['OPTIONAL']; ?></small></label>
                    <input id="description"
                           name="description"
                           type="text"
                           placeholder="<?php echo $lang['GALLERY_DESC_PLACEHOLDER']; ?>"
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
                    <h3 class="box-title"><i class="fa fa-wrench text-muted"></i>&nbsp; <?php echo $lang['THUMBNAILS']; ?> <small><?php echo $lang['GALLERY_IMG_RESIZE']; ?></small></h3>
                </div>
                <div class="box-body">
                    <input type="hidden" value="0" name="createThumbnails">
                    <?php
                    if ($gallery->createThumbnails === "1")
                    {
                        $createThumbnailsChecked = "checked";
                    }
                    else
                    {
                        $createThumbnailsChecked = "";
                    }

                    if ($gallery->resizeImages === '1')
                    {
                        $resizeImagesChecked = "checked";
                    }
                    else
                        {
                            $resizeImagesChecked = '';
                        }
                    ?>
                    <input type="checkbox" value="1" id="createThumbnails" name="createThumbnails" <?php echo $createThumbnailsChecked; ?>>
                    <label for="createThumbnails"><?php echo $lang['CREATE_THUMBNAILS']; ?></label>
                    <br>
                    <label for="thumbnailWidth"><?php echo $lang['THUMBNAIL_WIDTH_PX']; ?></label>
                    <input type="text" id="thumbnailWidth" maxlength="11" name="thumbnailWidth" class="form-control" placeholder="200px" value="<?php echo $gallery->thumbnailWidth; ?>">
                    <input type="hidden" id="thumbnailWidth-old" maxlength="11" name="thumbnailWidth-old" class="form-control" value="<?php echo $gallery->thumbnailWidth; ?>">

                    <br>
                    <input type="hidden" value="0" name="resizeImages">
                    <input type="checkbox" value="1" id="resizeImages" name="resizeImages" <?php echo $resizeImagesChecked; ?>>
                    <label for="resizeImages"><?php echo $lang['RESIZE_ALL_IMAGES']; ?></label>
                    <br>
                    <label for="imageWidth"><?php echo $lang['FULLSCREEN_WIDTH']; ?></label>
                    <?php if ($gallery->imageWidth === '0') $gallery->imageWidth = ''; ?>
                    <input type="text" id="imageWidth" maxlength="11" name="imageWidth" class="form-control" placeholder="eg. 1024px" value="<?php echo $gallery->imageWidth; ?>">
                    <input type="hidden" id="imageWidth-old" maxlength="11" name="imageWidth-old" class="form-control" value="<?php echo $gallery->imageWidth; ?>">

                    <label for="imageHeight"><?php echo $lang['FULLSCREEN_HEIGHT']; ?></label>
                    <?php if ($gallery->imageHeight === '0') $gallery->imageHeight = ''; ?>
                    <input type="text" id="imageHeight" maxlength="11" name="imageHeight" class="form-control" placeholder="eg. 1024px" value="<?php echo $gallery->imageHeight; ?>">
                    <input type="hidden" id="imageHeight-old" maxlength="11" name="imageHeight-old" class="form-control" value="<?php echo $gallery->imageHeight; ?>">

                    <label for="resizeType"><?php echo $lang['RESIZE_TYPE']; ?></label>
                    <select class="form-control" id="resizeType" name="resizeType">
                        <?php
                        $resizeTypes = array("fit_to_width", "fit_to_height", "thumbnail", "resize");
                        foreach ($resizeTypes as $type)
                        {   // if type is not set or empty
                            if (!isset($gallery->resizeType) && empty($gallery->resizeType))
                            {   // set default value
                                $gallery->resizeType = "fit_to_width";
                            }
                            if ($type === "$gallery->resizeType")
                            {   // selected value
                                echo "<option value=\"$type\" selected aria-selected=\"true\">$type</option>";
                            }
                            else
                                {   // all others
                                    echo "<option value=\"$type\">$type</option>";
                                }
                        }
                        ?>
                    </select>
                </div>
            </div>

            <div class="box box-default">
                <div class="box-header">
                    <h3 class="box-title"><i class="fa fa-copyright text-muted"></i> <?php echo "$lang[WATERMARK] <small>$lang[AND_COPYRIGHT_SETTINGS]</small>"; ?></h3>
                </div>
                <div class="box-body">
                    <input type="hidden" value="0" name="watermarkEnable">

                    <?php
                    if ($gallery->watermarkEnabled === '1')
                    {
                    $watermarkEnabledChecked = "checked";
                    }
                    else
                    {
                    $watermarkEnabledChecked = '';
                    }
                    ?>
                    <input type="hidden" value="0" name="watermarkEnabled">
                    <input type="checkbox" value="1" id="watermarkEnabled" name="watermarkEnabled" <?php echo $watermarkEnabledChecked; ?>>
                    <label for="watermarkEnabled"><?php echo $lang['WATERMARK_ENABLE']; ?></label>
                    <br>
                    <label for="watermark"><?php echo $lang['WATERMARK_FROM_CUSTOM_TEXT']; ?></label>
                    <input type="text" id="watermark" name="watermark" class="form-control" placeholder="(C) <?php echo date("Y")." photographer"; ?>" value="<?php echo $gallery->watermark; ?>">
                    <input type="hidden" id="watermark-old" name="watermark-old" class="form-control" value="<?php echo $gallery->watermark; ?>">
                    <label for="watermarkImage"><?php echo $lang['OR_FROM_ANY_IMG']; ?></label>
                    <input type="text" id="watermarkImage" name="watermarkImage" class="form-control" placeholder="media/images/yourfile.png" value="<?php echo $gallery->watermarkImage; ?>">
                    <input type="hidden" id="watermarkImage-old" name="watermarkImage-old" class="form-control" value="<?php echo $gallery->watermarkImage; ?>">
                    <label for="watermarkOpacity"><?php echo $lang['OVERLAY_OPACITY']; ?></label>
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
                    <label for="watermarkPosition"><?php echo $lang['WATERMARK_POSITION']; ?></label>
                    <select id="watermarkPosition" name="watermarkPosition" class="form-control">
                        <option value="<?php echo $gallery->watermarkPosition; ?>"><?php echo $gallery->watermarkPosition; ?></option>
                        <option value="bottom right"><?php echo $lang['BOTTOM_RIGHT']; ?></option>
                        <option value="bottom left"><?php echo $lang['BOTTOM_LEFT']; ?></option>
                        <option value="top left"><?php echo $lang['TOP_LEFT']; ?></option>
                        <option value="top right"><?php echo $lang['TOP_RIGHT']; ?></option>
                        <option value="bottom"><?php echo $lang['BOTTOM']; ?></option>
                        <option value="center"><?php echo $lang['CENTER']; ?></option>
                        <option value="top"><?php echo $lang['TOP']; ?></option>
                    </select>
                    <label for="offsetX"><?php echo $lang['OFFSET_X_AXIS']; ?></label>
                    <input type="text" id="offsetX" name="offsetX" class="form-control" placeholder="-12" value="<?php echo $gallery->offsetX; ?>">
                    <label for="offsetY"><?php echo $lang['OFFSET_Y_AXIS']; ?></label>
                    <input type="text" id="offsetY" name="offsetY" class="form-control" placeholder="-12" value="<?php echo $gallery->offsetY; ?>">
                    <label for="watermarkFont"><?php echo $lang['WATERMARK_FONT']; ?></label>
                    <select id="watermarkFont" name="watermarkFont" class="form-control">
                        <option value="<?php echo $gallery->watermarkFont; ?>"><?php echo $gallery->watermarkFont; ?></option>
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
                            if ($i == $gallery->watermarkTextSize) { $selected = "selected"; } else { $selected = ''; }
                            echo "<option value=\"$i\" $selected>$i px</option>";
                            $i++;
                        }

                        ?>
                    </select>
                    <label for="watermarkColor"><?php echo $lang['WATERMARK_TEXT_COLOR']; ?></label>
                    <input type="text" id="watermarkColor" name="watermarkColor" class="form-control color" placeholder="pick a color or leave blank" value="<?php echo $gallery->watermarkColor; ?>">
                    <label for="watermarkBorderColor"><?php echo $lang['WATERMARK_TEXT_BORDERCOLOR']; ?></label>
                    <input type="text" id="watermarkBorderColor" name="watermarkBorderColor" class="form-control color" placeholder="pick a color or leave blank" value="<?php echo $gallery->watermarkBorderColor; ?>">
                    <label for="watermarkBorder"><?php echo $lang['WATERMARK_BORDER_THICKNESS']; ?></label>
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

                    <label for="author"><?php echo $lang['PHOTOGRAPHER']; ?></label>
                    <input type="text" id="author" name="author" class="form-control" value="<?php echo $gallery->author; ?>" placeholder="<?php echo $lang['PHOTOGRAPHER_PLACEHOLDER']; ?>">
                    <label for="author"><?php echo $lang['PHOTOGRAPHER_URL']; ?></label>
                    <input type="text" id="authorUrl" name="authorUrl" class="form-control" value="<?php echo $gallery->authorUrl; ?>" placeholder="http://">

                </div>
            </div>
        </div>
    </div>
</form>


