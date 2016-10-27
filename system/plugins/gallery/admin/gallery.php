<?php
require_once '../system/plugins/gallery/classes/gallery.php';
/** GALLERY PLUGIN  */
if (!isset($gallery))
{
    $gallery = new \YAWK\PLUGINS\GALLERY\gallery();
}
// ADD NEW GALLERY
if (isset($_POST))
{
    if (isset($_GET['delete']) && ($_GET['delete'] === "1"))
    {   // delete a gallery from database
        if ($gallery->delete($db) == true)
        {   // deletion successfull
            \YAWK\alert::draw("success", "Gallery deleted successfully.", "Files on disk are <i>not</i> affected.", "", 1200);
        }
    }
    if (isset($_GET['add']) && ($_GET['add'] === "1"))
    {   // add a new gallery to database
        $gallery->add($db);
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
                <h3 class="box-title">Add a new gallery</h3>
            </div>
            <div class="box-body">
                <label for="folder">Select the folder where your images are located</label>
                <?php echo $gallery->drawFolderSelect("../media/images/")?>
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
                    <i id="savebuttonIcon" class="fa fa-check"></i> &nbsp;<?php print $lang['GALLERY_ADD']; ?>
                </button>
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


