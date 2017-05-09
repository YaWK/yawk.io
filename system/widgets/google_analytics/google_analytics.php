<?php
// default settings
$trackingcode = '';
// $_GET['widgetID'] will be generated in \YAWK\widget\loadWidgets($db, $position)
if (isset($_GET['widgetID']))
{
	// widget ID
	$widgetID = $_GET['widgetID'];

	// get widget settings from db
	    $res = $db->query("SELECT * FROM {widget_settings}
	                        WHERE widgetID = '".$wID."'
	                        AND activated = '1'");
   while($row = mysqli_fetch_assoc($res)){
	      $w_property = $row['property'];
	      $w_value = $row['value'];
	      $w_widgetType = $row['widgetType'];
	      $w_activated = $row['activated'];

		/* LOAD PROPERTIES */
		/* TRACKING CODE */
		if (isset($w_property)){
			if ($w_property === "trackingcode") {
				$trackingcode = $w_value;
			}
		}
	}
}
else
	{
		$trackingcode = "UA-0000000-00";
	}
?>
<!-- google analytics -->
<script>
	(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
			(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
		m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
	})(window,document,'script','//www.google-analytics.com/analytics.js','ga');

	ga('create', '<?php echo $trackingcode; ?>', 'auto');
	ga('require', 'linkid');
	ga('send', 'pageview');
</script>