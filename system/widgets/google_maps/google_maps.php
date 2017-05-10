<?php
$googleMapsEmbedHtmlCode = '<iframe src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d50610.00379633263!2d16.383995803127625!3d48.190035894830174!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sde!2sat!4v1491417431207" width="100%" height="400" frameborder="0" style="border:0" allowfullscreen></iframe>';
if (!isset($db) || (empty($db)))
{
	@require_once '../../classes/db.php';
	$db = new \YAWK\db();
}
// $_GET['widgetID'] will be generated in \YAWK\widget\loadWidgets($db, $position)
if (isset($_GET['widgetID']))
{
	// widget ID
	$widgetID = $_GET['widgetID'];

	// get widget settings from db
	$res = $db->query("SELECT * FROM {widget_settings}
	                        WHERE widgetID = '".$widgetID."'
	                        AND activated = '1'");
	while($row = mysqli_fetch_assoc($res))
	{   // set widget properties and values into vars
		$w_property = $row['property'];
		$w_value = $row['value'];
		$w_widgetType = $row['widgetType'];
		$w_activated = $row['activated'];
		/* end of get widget properties */

		/* google maps embed html code <iframe>...</iframe> */
		if (isset($w_property)){
			if ($w_property === "googleMapsEmbedHtmlCode") {
				$googleMapsEmbedHtmlCode = $w_value;
			}
		}

		/* google maps embed html code <iframe>...</iframe> */
		if (isset($w_property)){
			if ($w_property === "googleMapsHeading") {
				$heading = $w_value;
			}
		}

		/* google maps embed html code <iframe>...</iframe> */
		if (isset($w_property)){
			if ($w_property === "googleMapsSubtext") {
				$subtext = $w_value;
			}
		}
	}
}

// if a heading is set and not empty
if (isset($heading) && (!empty($heading)))
{   // add a h1 tag to heading string
	$heading = "$heading";

	// if subtext is set, add <small> subtext to string
	if (isset($subtext) && (!empty($subtext)))
	{   // build a headline with heading and subtext
		$subtext = "<small>$subtext</small>";
		$headline = "<h1>$heading&nbsp;"."$subtext</h1>";
	}
	else
	{   // build just a headline - without subtext
		$headline = "<h1>$heading</h1>";    // draw just the heading
	}
}
else
{   // leave empty if it's not set
	$headline = '';
}
// display headline, if its set
echo $headline;

// GoogleMap: onScreen!
echo $googleMapsEmbedHtmlCode;
?>
