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
			}
		} /* END LOAD PROPERTIES */

	} // end while fetch row (fetch widget settings)
} // if no widget ID is given or settings could not be retrieved, use this as defaults:

// output prezi html
echo $preziHtml;
?>
