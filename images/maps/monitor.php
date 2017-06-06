<?php
header('content-type: image/jpg');
$image = imagecreatetruecolor(297, 202);
if (!isset($q)) $q = 100;
$map = $_GET['map'];
$game = $_GET['game'];
$map_url = __DIR__ . "/$game/$map";
$background = imagecreatefrompng(__DIR__ . '/monitor.png');
$map_create = imagecreatefrompng($map_url);
$map_rotate = imagerotate($map_create, -20, 0);

imagecopyresampled($image, $map_rotate, 100, 26, 0, 0, 160, 140, 191, 165);
imagecopyresampled($image, $background, 0, 0, 0, 0, 297, 202, 297, 202);
imagejpeg($image,null,$q);
imagedestroy($image);
