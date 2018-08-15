<?php
$widget = new \YAWK\widget();
$data = $widget->getWidgetSettingsArray($db);
// how many pixels from object away should the animation start?
$contentAnimatorScrollValue = $data['contentAnimatorScrollValue'];
// animate.css animation class
$contentAnimatorClass = $data['contentAnimatorClass'];
// infinite animation loop true|false
$contentAnimatorInfinite = $data['contentAnimatorInfinite'];


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
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"system/widgets/contentAnimator/animate.css\">";
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
