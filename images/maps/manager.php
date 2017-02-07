<?php
if (isset($_GET['game']) and isset($_GET['map'])) {
 $game = $_GET['game'];
 $map = $_GET['map'];
 if (file_exists($game."/".$map.".jpg")) {
  header("Content-Type: image/jpg");
  readfile($game."/".$map.".jpg");
 } elseif (file_exists($game."/".$map.".png")) {
  header("Content-Type: image/png");
  readfile($game."/".$map.".png");
 } else {
  header("Content-Type: image/gif");
  readfile("no_map.gif");
  file_put_contents(__DIR__.'/../../data/needed_maps_icons.txt', $map."\n");
 }
}
