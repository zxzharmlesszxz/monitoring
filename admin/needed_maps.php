<?php
/*
 * Server info display script
 * Made by starky
*/

/* Script security */
if (!defined("MONENGINE")) {
 header("Location: index.php");
 exit();
}

$file = __DIR__.'/../data/needed_maps_icons.txt';

if (file_exists($file)) {
    $maps = array_unique(file($file));
}

echo <<<EOT
<div id="right">
 <div class="section">
  <div class="box">
   <b>Needed images</b>
  </div>
EOT;

foreach ($maps as $map) {
 echo "<div>{$map}</div>";
}

echo <<<EOT
 </div>
</div>
EOT;
