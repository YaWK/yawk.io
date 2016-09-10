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
      print \YAWK\alert::draw("success", "Erfolg!", "Das Widget ".$_GET['widget']." wurde dupliziert!","page=widgets","1800");
  }
  else
  {   // throw error
  	  print \YAWK\alert::draw("danger", "Fehler", "Das Widget ".$_GET['widget']." konnte nicht dupliziert werden.","page=widgets","4800");
  }
}