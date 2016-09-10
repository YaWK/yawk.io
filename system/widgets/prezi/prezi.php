<?PHP
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
<?PHP // echo $preziNR; exit; ?> 
<object id="<?PHP echo $preziID; ?>" name="<?PHP echo $preziID; ?>" classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" width="<?PHP echo $width; ?>" height="<?PHP echo $height; ?>">
<param name="movie" value="http://prezi.com/bin/preziloader.swf"/><param name="allowfullscreen" value="<?PHP echo $allowfullscreen; ?>"/>
<param name="allowscriptaccess" value="always"/>
<param name="bgcolor" value="#<?PHP echo $bgcolor; ?>"/>
<param name="flashvars" value="<?PHP echo $preziID; ?>&amp;lock_to_path=1&amp;color=<?PHP echo $bgcolor; ?>&amp;autoplay=<?PHP echo $autoplay; ?>&amp;autohide_ctrls=<?PHP echo $autohidectrl; ?>"/>
<embed id="preziEmbed_<?PHP echo $preziNR; ?>" name="preziEmbed_<?PHP echo $preziNR; ?>" src="http://prezi.com/bin/preziloader.swf" type="application/x-shockwave-flash" allowfullscreen="<?PHP echo $allowfullscreen; ?>" allowscriptaccess="always" width="<?PHP echo $width; ?>" height="<?PHP echo $height; ?>" bgcolor="#<?PHP echo $bgcolor; ?>" flashvars="prezi_id=<?PHP echo $preziNR; ?>&amp;lock_to_path=1&amp;color=<?PHP echo $bgcolor; ?>&amp;autoplay=<?PHP echo $autoplay; ?>&amp;autohide_ctrls=<?PHP echo $autohidectrl; ?>"></embed>
</object>

