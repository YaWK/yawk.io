<?PHP
global $dbprefix, $connection;
if (isset($wID)) {
		/* get widget settings */    
		/* ESSENTIAL TO GET WIDGETS TO WORK PROPERLY */
	    $res = mysqli_query($connection, "SELECT * FROM ".$dbprefix."widget_settings
	                        WHERE widgetID = '".$wID."'
	                        AND activated = '1'");
   while($row = mysqli_fetch_row($res)){
	      $w_property = $row[2];
	      $w_value = $row[3];
	      $w_widgetType = $row[4];
	      $w_activated = $row[5];

		/* LOAD PROPERTIES */
		/* TRACKING CODE */
		if (isset($w_property)){
			if ($w_property === "trackingcode") {
				$trackingcode = $w_value;
			}
		}
	}
}
else { 	
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