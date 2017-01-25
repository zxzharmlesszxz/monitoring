<?php
if(isset($_GET['game']) and isset($_GET['map'])) {
	$game = $_GET['game'];
	$map = $_GET['map'];
	if(file_exists($game."/".$map.".jpg")) {
		header("Content-Type: image/jpg");
		readfile($game."/".$map.".jpg");
	} else {
		header("Content-Type: image/gif");
		readfile("no_map.gif");
	}
} else {

	$folder_level = "";
	$i = 0;
	while (!file_exists($folder_level."config.php")) {
		$folder_level .= "../";
		$i++;
	}
	
	define("BASEDIR", $folder_level);
	header("Location: ".BASEDIR."index.php");
}
?>