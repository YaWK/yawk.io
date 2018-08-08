<?php
// default settings
// $_GET['widgetID'] will be generated in \YAWK\widget\loadWidgets($db, $position)
$trackingcode = '';
if (isset($_GET['widgetID']))
{
	// widget ID
	$widgetID = $_GET['widgetID'];

	// get widget settings from db
	    $res = $db->query("SELECT * FROM {widget_settings}
	                        WHERE widgetID = '".$widgetID."'
	                        AND activated = '1'");
   while($row = mysqli_fetch_assoc($res)){
	      $w_property = $row['property'];
	      $w_value = $row['value'];
	      $w_widgetType = $row['widgetType'];
	      $w_activated = $row['activated'];

		/* LOAD PROPERTIES */
		/* TRACKING CODE */
		if (isset($w_property)){
			if ($w_property === "gaTrackingcode") {
				$trackingcode = $w_value;
			}
			else
			    {
			        $trackingcode = "UA-0000000-00";
                }
		}
	}
}
else
	{
		$trackingcode = "UA-0000000-00";
	}


echo"<!-- google analytics -->
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src=\"https://www.googletagmanager.com/gtag/js?id=$trackingcode\"></script>
<script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', '$trackingcode');
</script>";

?>