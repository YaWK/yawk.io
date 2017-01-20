<?PHP
$width="450";
$height="35";
$fblikeurl="http%3A%2F%2Fwww.facebook.com%2Fplatform";
$fbappID="100710516666226";
$colorscheme="light";

if (isset($widgetID))
{
	
	   /* get widget settings */    
		/* ESSENTIAL TO GET WIDGETS TO WORK PROPERLY */
	    $res = mysqli_query("SELECT * FROM {widget_settings}
	                        WHERE widgetID = '".$widgetID."'
	                        AND activated = '1'");
	    while($row = mysqli_fetch_row($res)){
	      $w_property = $row[1];   
	      $w_value = $row[2];
	      $w_widgetType = $row[3];
	      $w_activated = $row[4];

/* LOAD PROPERTIES */ 
		if (isset($w_property)){
		switch($w_property)
		  {
		    case 'width';
		     $width = $w_value;
		    break;
		    
		    case 'height';
		     $height = $w_value;
		    break;
		    
		    case 'fbappID';
		     $fbappID = $w_value;
		    break;
		    
		    case 'colorscheme';
		     $colorscheme = $w_value;
		    break;
		    
		    case 'fblikeurl';
		     $fblikeurl = $w_value;
		  	  $fblikeurl = rawurlencode($fblikeurl);
		    break;
		  }
		} /* END LOAD PROPERTIES */	    
	    
	   } // end while fetch row (end get widget settings)
} // if no widget ID is given or settings could not be retrieved, use this as defaults:

//	 if (empty($fblikeurl)) { $fblikeurl="http%3A%2F%2Fwww.facebook.com%2Fplatform"; }
?>
<br>
<iframe src="//www.facebook.com/plugins/like.php?href=<?PHP echo $fblikeurl; ?>&amp;send=false&amp;layout=standard&amp;width=<?PHP echo $width; ?>&amp;show_faces=false&amp;action=like&amp;colorscheme=<?php echo $colorscheme; ?>&amp;font&amp;height=<?php echo $height; ?>&amp;appId=<?php echo $fbappID; ?>" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:<?php echo $width; ?>px; height:<?php echo $height; ?>px;" allowTransparency="true"></iframe>