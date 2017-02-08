<?php
require_once(__DIR__.'/../../include/core.php');

if (isset($_GET['game']) and isset($_GET['map'])) {
 $game = $_GET['game'];
 $map = $_GET['map'];

 if (!check_map_image($map, $game)) {
  create_map_image($map, 'cs16');
 }
 get_map_image($map, $game);
}
