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
$galleryID = 1;
$heading = '';
$subtext = '';

// $_GET['widgetID'] will be generated in \YAWK\widget\loadWidgets($db, $position)
if (isset($_GET['widgetID'])) {
    $widgetID = $_GET['widgetID'];
    $res = $db->query("SELECT * FROM {widget_settings}
								WHERE widgetID = '" . $widgetID . "'
	                        	AND activated = '1'");
    while ($row = mysqli_fetch_assoc($res)) {   // set widget properties and values into vars
        $w_property = $row['property'];
        $w_value = $row['value'];
        $w_widgetType = $row['widgetType'];
        $w_activated = $row['activated'];
        /* end of get widget properties */

        /* filter and load those widget properties */
        if (isset($w_property)) {
            switch ($w_property) {
                /* url of the stream */
                case 'galleryID';
                    $galleryID = $w_value;
                    break;

                /* heading */
                case 'galleryHeading';
                    $heading = $w_value;
                    break;

                /* subtext */
                case 'gallerySubtext';
                    $subtext = $w_value;
                    break;
            }
        } /* END LOAD PROPERTIES */
    } // end while fetch row (fetch widget settings)

// if a heading is set and not empty
    if (isset($heading) && (!empty($heading))) {   // add a h1 tag to heading string
        $heading = "$heading";

        // if subtext is set, add <small> subtext to string
        if (isset($subtext) && (!empty($subtext))) {   // build a headline with heading and subtext
            $subtext = "<small>$subtext</small>";
            $headline = "<h1>$heading&nbsp;" . "$subtext</h1>";
        } else {   // build just a headline - without subtext
            $headline = "<h1>$heading</h1>";    // draw just the heading
        }
    } else {   // leave empty if it's not set
        $headline = '';
    }
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
echo $headline;
$gallery->drawImageGallery($db, $galleryID);