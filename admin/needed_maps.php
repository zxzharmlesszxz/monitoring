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
    readfile($file);
}

echo <<<EOT
<div>
<b>Page was be here</b>
</div>
EOT;
