<?php
include '../classes/SimpleImage.php';
$img = new \YAWK\SimpleImage();

$prefix = "../../../../";
$file = $_POST['filename'];
$folder = $_POST['folder'];


// Flip horizontal
$img->load("$prefix$folder/$file")->flip("x")->save("$prefix$folder/$file");



