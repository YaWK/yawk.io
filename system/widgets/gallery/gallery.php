<link href="system/engines/jquery/lightbox2/css/lightbox.min.css" rel="stylesheet">
<script src="system/engines/jquery/lightbox2/js/lightbox.min.js"></script>
<script type="text/javascript">
    lightbox.option({
     //   'albumLabel': "<?php echo $lang['IMAGES']; ?> %1 of %2",
      //  'albumLabel': "Image %1 of %2",
        'wrapAround': true
    });
</script>

<?php
// $_GET['widgetID'] will be generated in \YAWK\widget\loadWidgets($db, $position)
if (isset($_GET['widgetID']))
{
    $widgetID = $_GET['widgetID'];
    $res = $db->query("SELECT value FROM {widget_settings}
								WHERE widgetID = '".$widgetID."'
	                        	AND activated = '1'");
    $row = mysqli_fetch_array($res);
    $galleryID = $row[0];
}
else
    {
        $galleryID = 0;
    }
?>

<?php
/** GALLERY PLUGIN  */
if (!isset($gallery))
{
    require_once 'system/plugins/gallery/classes/gallery.php';
    $gallery = new \YAWK\PLUGINS\GALLERY\gallery();
}
if (!isset($db))
{
    require_once 'system/classes/db.php';
    $db = new \YAWK\db();
}
$gallery->drawImageGallery($db, $galleryID);