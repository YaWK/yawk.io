<?php
// defaults:
$width="450";
$height="65";
$fbpageurl="http%3A%2F%2Fwww.facebook.com%2Fplatform";
$fbappID="00000000000";		// 100710516666226
$tabs="timeline";
$smallHeader="false";
$hideCover="false";
$adaptContainerWidth="true";
$showFacepile="true";

if (isset($_GET['widgetID']))
{
	// widget ID
	$widgetID = $_GET['widgetID'];
	/* get widget settings from db */
	    $res = $db->query("SELECT * FROM {widget_settings}
	                        WHERE widgetID = '".$widgetID."'
	                        AND activated = '1'");
	    while($row = mysqli_fetch_row($res)){
	      $w_property = $row[1];   
	      $w_value = $row[2];
	      $w_widgetType = $row[3];
	      $w_activated = $row[4];
		/* end of get widget settings */ 

	/* LOAD PROPERTIES */ 
		if (isset($w_property)){
		switch($w_property)
		  {
			case 'fbPageUrl';
				$fbpageurl = $w_value;
				$fbpageurl = rawurlencode($fbpageurl);
				break;
			case 'fbPageWidth';
		     	$width = $w_value;
		    	break;
		    case 'fbPageHeight';
		     	$height = $w_value;
		    	break;
		    case 'fbPageAppID';
		     	$fbappID = $w_value;
		    	break;
		    case 'fbPageTabs';
		     	$tabs = $w_value;
		    	break;
			case 'fbPageSmallHeader';
			 	$smallHeader = $w_value;
				break;
			case 'fbPageAdaptContainerWidth';
				$adaptContainerWidth = $w_value;
				break;
			case 'fbPageHideCover';
				$hideCover = $w_value;
				break;
			case 'fbPageShowFacepile';
				$showFacepile = $w_value;
				break;
		  }
		} /* END LOAD PROPERTIES */
		
	   } // end while fetch row (fetch widget settings)
} // if no widget ID is given or settings could not be retrieved, use this as defaults:
?>
<iframe src="https://www.facebook.com/plugins/page.php?href=<?php echo $fbpageurl; ?>&tabs=<?php echo $tabs; ?>&width=<?php echo $width; ?>&height=<?php echo $height; ?>&small_header=<?php echo $smallHeader; ?>&adapt_container_width=<?php echo $adaptContainerWidth; ?>&hide_cover=<?php echo $hideCover; ?>&show_facepile=<?php echo $showFacepile; ?>&appId=<?php echo $fbappID; ?>" width="<?php echo $width; ?>" height="<?php echo $height; ?>" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowTransparency="true"></iframe>
