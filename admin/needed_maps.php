<?php

/* Script security */
if (!defined("MONENGINE")) {
    header("Location: index.php");
    exit();
}

$file = __DIR__ . '/../data/needed_maps_icons.txt';

if (file_exists($file)) {
    $maos = array_unique(explode("\n", file_get_contents($file)));
    asort($maps);
    $files = scandir(__DIR__ . '/../images/maps/cs16/');

    foreach ($files as $f) {
        if ($f == '.' or $f == '..') continue;
        $a = explode('.', $f);

        $i = array_search($a[0], $maps);

        if ($i) {
            unset($maps[$i]);
        }
    }
    file_put_contents(__DIR__ . '/../data/needed_maps_icons.txt', implode("\n", $maps), LOCK_EX);
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
    if (empty($map)) continue;
    echo "<li><a target='_blank' href='https://www.google.com.ua/search?q={$map}.jpg&source=lnms'>{$map}</a></li>";
}
echo <<<EOT
  </ol>
 </div>
</div>
EOT;
