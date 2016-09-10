<?php
/** SEDCARDS PLUGIN  */
include 'classes/frontend.php';

// generate new sedcard object
$helper = new \YAWK\PLUGINS\SEDCARD\helper();
$numbers = $helper->randomize(3, 1, 10);


echo "<h1>Welcome to {domainname}! <small>This is the sedcard frontend plugin!</small></h1>";

echo"<h2>The newest girls <small>in den letzten 24 Stunden hinzugekommen...</small></h2>";
echo "
<!-- Columns start at 50% wide on mobile and bump up to 33.3% wide on desktop -->
<div class=\"row\">
  <div class=\"col-xs-6 col-md-4\"><img src=\"media/images/girl$numbers[0].jpg\" height=\"400\" class=\"img-thumbnail animated zoomInUp\"> </div>
  <div class=\"col-xs-6 col-md-4\"><img src=\"media/images/girl$numbers[1].jpg\" height=\"400\" class=\"img-thumbnail animated zoomInUp\"> </div>
  <div class=\"col-xs-6 col-md-4\"><img src=\"media/images/girl$numbers[2].jpg\" height=\"400\" class=\"img-thumbnail animated zoomInUp\"> </div>
</div>";


echo"<br><br><h2>Check them out: <small>our random girls...</small></h2>";
echo '
<!-- Columns start at 50% wide on mobile and bump up to 33.3% wide on desktop -->
<div class="row">
  <div class="col-xs-6 col-md-4"><img src="media/images/girlx.jpg" height="400" class="img-thumbnail animated fadeIn"> </div>
  <div class="col-xs-6 col-md-4"><img src="media/images/girly.jpg" height="400" class="img-thumbnail animated fadeIn"> </div>
  <div class="col-xs-6 col-md-4"><img src="media/images/girlz.jpg" height="400" class="img-thumbnail animated fadeIn"> </div>
</div>';
