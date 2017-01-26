<?php 

// Баннеры для by-isp
include "core.php";

$id=$_GET["id"];
$q = dbquery("SELECT * FROM ".DB_SERVERS." WHERE server_id = ".$id."");
$serv=dbarray_fetch($q);
header("Content-type: image/png");

$font_title = "templates/fonts/tahoma.ttf";
$font = "templates/fonts/arial.ttf";
$font_b = "templates/fonts/arialbd.ttf";
$font_map = "templates/fonts/visitor1.ttf";
$img = imagecreatetruecolor(340, 20); 
$gb = imagecreatefromgif("images/banersvote/userbar6.gif");
imagecopyresized($img, $gb, 0, 0, 0, 0, 500, 200, 500, 200); 
imagecopyresized($img, $gt, 5, 5, 0, 0, 16, 16, 16, 16); 
$text=htmlcolor($img,"ffffff"); 
$mapf=htmlcolor($img,"000000");
imagettftext($img, 8, 0, 3, 13, $text, $font_b, iconv('WINDOWS-1251', 'UTF-8', "Голосовать |  "));
imagettftext($img, 8, 0, 79, 13, $text, $font_b, $serv["server_name"]."" );
imagepng($img);
imagedestroy($img, $i); 
