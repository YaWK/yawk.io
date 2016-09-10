<?PHP
global $dbprefix, $connection;
if (isset($wID)) {
	
		/* get widget settings */    
		/* ESSENTIAL TO GET WIDGETS TO WORK PROPERLY */
	    $res = mysqli_query($connection, "SELECT * FROM ".$dbprefix."widget_settings 
	                        WHERE widgetID = '".$wID."'
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
		    
		    case 'fbpageurl';
		     $fbpageurl = $w_value;
		  	 $fbpageurl = rawurlencode($fbpageurl);
		    break;	
		    
		    case 'float';
		     $float = $w_value;
		     if (!$float) $float_code=""; else $float_code="float:$float;";
		    break;	    
		    
		    case 'x_offset';
		     $x_offset = $w_value;
		     if (!$x_offset) $x_offset="0";
		    break;
		    		    
		    case 'y_offset';
		     $y_offset = $w_value;
		     if (!$y_offset) $y_offset="0";
		    break;
		  }
		} /* END LOAD PROPERTIES */
		
	   } // end while fetch row (fetch widget settings)
} // if no widget ID is given or settings could not be retrieved, use this as defaults:
else {
	$width="450";
	$height="65";
	$fbpageurl="http%3A%2F%2Fwww.facebook.com%2Fplatform";
	$fbappID="100710516666226";
	$x_offset="0";
	$y_offset="0";
	$float_code="";
	}
?> 
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/de_DE/sdk.js#xfbml=1&version=v2.4&appId=100710516666226";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>

<div class="fb-page" data-href="https://www.facebook.com/StephanHeinerMusic" data-width="500" data-height="300" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true" data-show-posts="true"><div class="fb-xfbml-parse-ignore"><blockquote cite="https://www.facebook.com/StephanHeinerMusic"><a href="https://www.facebook.com/StephanHeinerMusic">Stephan Heiner</a></blockquote></div></div>

<!--
<div style="padding-left:<?PHP echo $x_offset; ?>px; padding-top:<?PHP echo $y_offset; ?>px; <?PHP echo $float_code; ?>">
<iframe src="//www.facebook.com/plugins/likebox.php?href=<?PHP echo $fbpageurl; ?>&amp;width=<?PHP echo $width; ?>&amp;height=<?php echo $height; ?>&amp;colorscheme=<?php echo $colorscheme; ?>&amp;show_faces=true&amp;border_color=ffffff&amp;stream=false&amp;header=false&amp;appId=<?php echo $fbappID; ?>" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:<?php echo $width; ?>px; height:<?php echo $height; ?>px;" allowTransparency="true"></iframe>
</div>
-->
