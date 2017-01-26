<?php
if (!isset($widget))
{ // create new widget object
  $widget = new \YAWK\widget();
}
// load widget properties
$widget->loadProperties($db, $_GET['widget']);
// user clicked on copy
if($_GET['copy'] === "true") {
  if ($widget->copy($db, $_GET['widget']))
  {   // widget copied
      print \YAWK\alert::draw("success", "$lang[SUCCESS]", "$lang[WIDGET] ".$_GET['widget']." $lang[COPIED]","page=widgets","1800");
  }
  else
  {   // throw error
  	  print \YAWK\alert::draw("danger", "$lang[ERROR]", "$lang[WIDGET] ".$_GET['widget']." <b>$lang[NOT] $lang[COPIED]</b>","page=widgets","4800");
  }
}