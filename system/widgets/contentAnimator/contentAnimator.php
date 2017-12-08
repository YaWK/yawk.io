<?php
// var declaration
    // how many pixels from object away should the animation start?
    $contentAnimatorScrollValue = '';
    // animate.css animation class
    $contentAnimatorClass = '';
    // infinite animation loop true|false
    $contentAnimatorInfinite = '';

if (isset($_GET['widgetID']))
{
	// widget ID
	$widgetID = $_GET['widgetID'];
	/* get widget settings from db */
	$res = $db->query("SELECT * FROM {widget_settings}
	                        WHERE widgetID = '".$widgetID."'
	                        AND activated = '1'");
	while($row = mysqli_fetch_assoc($res)){
		$w_property = $row['property'];
		$w_value = $row['value'];
		$w_widgetType = $row['widgetType'];
		$w_activated = $row['activated'];
		/* end of get widget settings */

		/* LOAD PROPERTIES */
		if (isset($w_property)){
			switch($w_property)
			{
				case 'contentAnimatorScrollValue';
					$contentAnimatorScrollValue = $w_value;
					break;
				case 'contentAnimatorClass';
					$contentAnimatorClass = $w_value;
					break;
                case 'contentAnimatorInfinite';
                    $contentAnimatorInfinite = $w_value;
                    break;
			}
		} /* END LOAD PROPERTIES */

	} // end while fetch row (fetch widget settings)
} // if no widget ID is given or settings could not be retrieved, use this as defaults:

// check if class is empty
if (!isset($contentAnimatorClass) || (empty($contentAnimatorClass)))
{	// default behavior:
	$contentAnimatorClass = "fadeIn";
}
// check if scroll value is empty
if (!isset($contentAnimatorScrollValue) || (empty($contentAnimatorScrollValue)))
{	// default value
    $contentAnimatorScrollValue = 600;
}
// check if infinite is set
if (!isset($contentAnimatorInfinite) || (empty($contentAnimatorInfinite)))
{	// default css value
    $contentAnimatorInfinite = "";
}
else
    {   // infinite is set to true
        if ($contentAnimatorInfinite === "true")
        {   // set the correct value
            $contentAnimatorInfinite = "infinite";
        }
        else
            {   // don't loop animation: leave infinite empty
                $contentAnimatorInfinite = "";
            }
    }
// load velocity.js
// echo "<script src=\"system/engines/velocityJS/velocity.min.js\"></script>";
// echo "<script src=\"system/engines/velocityJS/velocity-ui.min.js\"></script>";

// load css with animation definitions
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"system/widgets/contentAnimator/animate.min.css\">";
// echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"system/engines/animateCSS/animate.min.css\">";
// echo "<style type=\"text/css\">.animate {visibility:hidden;}</style>";
// output javsscript

echo"<script>
	$(document).ready(function(){

    // Slide in elements on scroll
    $(window).scroll(function() {
        $(\".animate\").each(function(){
            var pos = $(this).offset().top;
            var winTop = $(window).scrollTop();
            if (pos < winTop + $contentAnimatorScrollValue) {
                // $(this).velocity(\"transition.fadeIn\", {duration:1000, loop:false});
                $(this).addClass(\"$contentAnimatorClass\");
            }
    	});
    });
  });
</script>";
?>
