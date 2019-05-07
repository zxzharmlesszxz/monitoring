<?php
/*
 * Server list
 * Made by starky
*/

/* Script security */
if (!defined("MONENGINE")) {
    header("Location: index.php");
    exit();
}

uasort($servers, "sortByVotes");

foreach ($servers as $id => $server) {
    print $server['server_ip'].PHP_EOL;
}
