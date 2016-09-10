<?php

if (isset($wID)) {
/* get widget settings
 * ESSENTIAL TO GET WIDGETS TO WORK PROPERLY */
   $res = mysqli_query($connection, "SELECT * FROM ".$dbprefix."widget_settings 
	                        WHERE widgetID = '".$wID."'
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
		    case 'clockcolor';
		    $clockcolor = $w_value;
		    break;
		    
		    case 'float';
		    $float = $w_value;
		    break;
		    
		    case 'textstyle';
		    $textstyle = $w_value;
		    break;
		    
		  } // end switch  
		} // no more properties
	} // end while fetch array
} 
else
/*
 *  if no widget ID is given or settings could not be retrieved, use this as defaults:
 */
    { 	
	$clockcolor = "999"; 
	$float = "right"; 
	$textstyle = "bold"; 
}

?>

<body onload="clock();">
<script type="text/javascript">
function clock() {
   var now = new Date();
   var minute = now.getMinutes();
   var second= now.getSeconds();
   var hour = now.getHours();
    if(minute<10) minute = "0" + minute;
    if(second<10) second= "0" + second;
    if(hour<10) hour="0" + hour;
   var outStr = hour+':'+minute+':'+second;
/*   output string without leading zero int
 *   var outStr = now.getHours()+':'+now.getMinutes()+':'+now.getSeconds(); */
   document.getElementById('clockDiv').innerHTML=outStr;
   setTimeout('clock()',1000);
   
}
clock();
</script>  


<p id="clockDiv" style="<?php echo "float:$float; font-weight:$textstyle;"; ?> color:<?php echo "#"."$clockcolor;"; ?>"></p>