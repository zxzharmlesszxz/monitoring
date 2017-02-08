<?php
require_once(__DIR__.'/../../include/core.php');

if (isset($_GET['game']) and isset($_GET['map'])) {
 $game = $_GET['game'];
 $map = $_GET['map'];
 var_dump(check_map_image($map, $game));
 get_map_image($map, $game);
}
