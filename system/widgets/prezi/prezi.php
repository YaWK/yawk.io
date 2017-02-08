<?php
if (isset($wID)) {
	
	/* OPTIMIZE THIS SHIT!!! 
	like this:
	
	switch($beer)
{
    case 'tuborg';
    case 'carlsberg';
    case 'heineken';
        echo 'Good choice';
    break;
    default;
        echo 'Please make a new selection...';
    break;
}

*/
		/* get widget settings */    
		/* ESSENTIAL TO GET WIDGETS TO WORK PROPERLY */
	    $res = mysql_query("SELECT * FROM ".$dbpraefix."widget_settings 
	                        WHERE widgetID = '".$wID."'
	                        AND activated = '1'");
	    while($row = mysql_fetch_row($res)){
	      $w_property = $row[1];   
	      $w_value = $row[2];
	      $w_widgetType = $row[3];
	      $w_activated = $row[4];
	    

		/* LOAD PROPERTIES */
/* WIDTH */
		if (isset($w_property)){
			if ($w_property === "width") {
				$width = $w_value;	
			}
		} 
		
/* HEIGHT */
		if (isset($w_property)){
			if ($w_property === "height") {
				$height = $w_value;	
			}
		} 
		
/* PREZI ID */
		if (isset($w_property)){
			if ($w_property === "preziID") {
				$preziID = $w_value;	
				if (!$preziID) { $preziID="prezi_9777491244592bca711a38805a9010c969bb17ac"; }
				$preziNR = substr($preziID, 6);
			}
		}	
						
/* allow fullscreen  */
		if (isset($w_property)){
			if ($w_property === "allowfullscreen") {
				$allowfullscreen = $w_value;	
			}
		} 
						
/* bg color  */
		if (isset($w_property)){
			if ($w_property === "bgcolor") {
				$bgcolor = $w_value;	
			}
		} 
						
/* autoplay  */
		if (isset($w_property)){
			if ($w_property === "autoplay") {
				$autoplay = $w_value;	
			}
		}
						
/* autohide controlls  */
		if (isset($w_property)){
			if ($w_property === "autohidectrl") {
				$autohidectrl = $w_value;	
			}
		} 		
		 				
	   } // end while fetch array
}
else {
	
	$preziID="prezi_9777491244592bca711a38805a9010c969bb17ac";
	$preziNR = substr($preziID, 6);
	$width = "900";
	$height = "420";
	$allowfullscreen = "true";
	$bgcolor = "ffffff";
	$autoplay = "yes";
	$autohidectrl = "0";


	}
?>
<?php // echo $preziNR; exit; ?> 
<object id="<?php echo $preziID; ?>" name="<?php echo $preziID; ?>" classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" width="<?php echo $width; ?>" height="<?php echo $height; ?>">
<param name="movie" value="http://prezi.com/bin/preziloader.swf"/><param name="allowfullscreen" value="<?php echo $allowfullscreen; ?>"/>
<param name="allowscriptaccess" value="always"/>
<param name="bgcolor" value="#<?php echo $bgcolor; ?>"/>
<param name="flashvars" value="<?php echo $preziID; ?>&amp;lock_to_path=1&amp;color=<?php echo $bgcolor; ?>&amp;autoplay=<?php echo $autoplay; ?>&amp;autohide_ctrls=<?php echo $autohidectrl; ?>"/>
<embed id="preziEmbed_<?php echo $preziNR; ?>" name="preziEmbed_<?php echo $preziNR; ?>" src="http://prezi.com/bin/preziloader.swf" type="application/x-shockwave-flash" allowfullscreen="<?php echo $allowfullscreen; ?>" allowscriptaccess="always" width="<?php echo $width; ?>" height="<?php echo $height; ?>" bgcolor="#<?php echo $bgcolor; ?>" flashvars="prezi_id=<?php echo $preziNR; ?>&amp;lock_to_path=1&amp;color=<?php echo $bgcolor; ?>&amp;autoplay=<?php echo $autoplay; ?>&amp;autohide_ctrls=<?php echo $autohidectrl; ?>"></embed>
</object>

