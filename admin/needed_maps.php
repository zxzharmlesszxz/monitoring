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
<div style="clear: both;"></div>
<div>
<b>Needed images</b>
</div>
<div style="clear: both;"></div>
EOT;

foreach ($maps as $map) {
 echo "<div>{$map}</div>";
}