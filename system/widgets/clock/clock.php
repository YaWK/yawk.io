<?php
$widget = new \YAWK\widget();
$data = $widget->getWidgetSettingsArray($db);
$color = $data['clockColor'];
$align = $data['clockAlign'];
$class = $data['clockClass'];
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
	<div id="clockDiv" class="<?php echo $class; ?>" style="color:<?php echo "#"."$color;"; ?>"></div>
</div>