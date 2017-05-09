<?php
// defaults:
$preziHtml="";

if (isset($_GET['widgetID']))
{
	// widget ID
	$widgetID = $_GET['widgetID'];
	/* get widget settings from db */
	$res = $db->query("SELECT * FROM {widget_settings}
	                        WHERE widgetID = '".$widgetID."'
	                        AND activated = '1'");
	while($row = mysqli_fetch_assoc($res)){
		$w_property = $row['property'];
		$w_value = $row['value'];
		$w_widgetType = $row['widgetType'];
		$w_activated = $row['activated'];
		/* end of get widget settings */

		/* LOAD PROPERTIES */
		if (isset($w_property)){
			switch($w_property)
			{
				case 'preziHtml';
					$preziHtml = $w_value;
					break;
				case 'preziHeading';
					$heading = $w_value;
					break;
				case 'preziSubtext';
					$subtext = $w_value;
					break;
			}
		} /* END LOAD PROPERTIES */

	} // end while fetch row (fetch widget settings)
} // if no widget ID is given or settings could not be retrieved, use this as defaults:

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

// output prezi html
echo $headline;
echo $preziHtml;
?>
