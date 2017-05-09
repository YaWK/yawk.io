<?php
/* Widget: facebook like button
 * Folder: system/widgets/fb_like_button
 * Version: 1.2
 */

// default settings
$width="450";
$height="35";
$fblikeurl="http%3A%2F%2Fwww.facebook.com%2Fplatform";
$fbappID="";	// "100710516666226";
$colorscheme="light";
$layout="standard";
$action="like";
$size="small";
$showFaces="false";
$share="false";

if (isset($_GET['widgetID']))
{
	// widget ID
	$widgetID = $_GET['widgetID'];

	/* get widget settings from db */
	$res = $db->query("SELECT * FROM {widget_settings}
	                        WHERE widgetID = '".$widgetID."'
	                        AND activated = '1'");
	while ($row = mysqli_fetch_assoc($res))
	{
		$w_property = $row['property'];
		$w_value = $row['value'];
		$w_widgetType = $row['widgetType'];
		$w_activated = $row['activated'];

		/* LOAD PROPERTIES */
		if (isset($w_property)) {
			switch ($w_property) {
				case 'fbLikeButtonWidth';
					$width = $w_value;
					break;

				case 'fbLikeButtonHeight';
					$height = $w_value;
					break;

				case 'fbLikeButtonUrl';
					$fblikeurl = $w_value;
					$fblikeurl = rawurlencode($fblikeurl);
					break;

				case 'fbLikeButtonAppID';
					$fbappID = $w_value;
					break;

				case 'fbLikeButtonColorscheme';
					$colorscheme = $w_value;
					break;

				case 'fbLikeButtonLayout';
					$layout = $w_value;
					break;

				case 'fbLikeButtonAction';
					$action = $w_value;
					break;

				case 'fbLikeButtonSize';
					$size = $w_value;
					break;

				case 'fbLikeButtonShowFaces';
					$showFaces = $w_value;
					break;

				case 'fbLikeButtonShare';
					$share = $w_value;
					break;

			}
		} /* END LOAD PROPERTIES */

	} // end while fetch row (end get widget settings)
}
else
	{
		echo "unable to load widget settings from db<br>";
	}
?>
<iframe src="https://www.facebook.com/plugins/like.php?href=<?php echo $fblikeurl; ?>&width=<?php echo $width; ?>&layout=<?php echo $layout; ?>&action=<?php echo $action; ?>&size=<?php echo $size; ?>&show_faces=<?php echo $showFaces; ?>&share=<?php echo $share; ?>&height=<?php echo $height; ?>&appId=<?php echo $fbappID; ?>" width="<?php echo $width; ?>" height="<?php echo $height; ?>" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowTransparency="true"></iframe>
