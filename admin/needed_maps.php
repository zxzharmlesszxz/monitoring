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
    file_put_contents(__DIR__.'/../data/needed_maps_icons.txt', implode("\n",$maps), LOCK_EX);
}

echo <<<EOT
<div id="right">
 <div class="section">
  <div class="box">
   <b>Needed images</b>
  </div>
  <ol>
EOT;

foreach ($maps as $map) {
 echo "<li><a href='https://www.google.com.ua/search?q={$map}&tbs=isz:m&tbm=isch'>{$map}/a></li>";
}
echo <<<EOT
  </ol>
 </div>
</div>
EOT;
