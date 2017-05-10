<?php

$color = "999";
$align = "text-center";
$class = "text-success";

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
		if (isset($w_property)){
			switch($w_property)
		  {
		    case 'clockColor';
		    $color = $w_value;
		    break;
		    
		    case 'clockAlign';
		    $align = $w_value;
		    break;
		    
		    case 'clockClass';
		    $class = $w_value;
		    break;
		    
		  } // end switch  
		} // no more properties
	} // end while fetch array
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

<div class="<?php echo $align; ?>">
	<p id="clockDiv" class="<?php echo $class; ?>" style="color:<?php echo "#"."$color;"; ?>"></p>
</div>