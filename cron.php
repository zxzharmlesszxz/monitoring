<?php
require_once __DIR__ . "/include/core.php";

$query = db()->query("SELECT * FROM " . DB_SERVERS);
$servers = array();
$servers_online = 0;
$sql = array();

while ($r = db()->fetch_array($query)) {
    if ($r['server_status'] == 0 and ($r['status_change'] - time()) < 86400) {
        $sql[] = "DROP FROM " . DB_SERVERS . " WHERE server_id = {$r['server_id']}";
        continue;
    }
    $servers[] = array_merge($r, serverInfo($r['server_ip']));
}

foreach ($servers as $num => $server) {
    if ($server['status'] == 'off' || empty($server['name'])) {
        $sql[] = "UPDATE " . DB_SERVERS . " SET server_status = '0', server_map = '-', server_players = '-', server_maxplayers = '-' " . (($server['server_status'] == 1) ? ", status_change = " . time() : "") . " WHERE server_id='{$server['server_id']}'";
        continue;
    }
    $servers_online++;
    $name = db()->escape_value($server['name']);
    $sql[] = "UPDATE " . DB_SERVERS . " SET server_name = '{$name}'," . " server_map = '{$server['map']}', server_players = '{$server['players']}'," . " server_maxplayers = '{$server['max_players']}', server_status = '1' " . (($server['server_status'] == 0) ? ", status_change = " . time() : "") . " WHERE server_id='{$server['server_id']}'";
}

$topMap = topMap($servers);

$update_timestamp = time(); // запоминаем дату
$sql[] = "UPDATE " . DB_SETTINGS . " SET last_update='$update_timestamp', servers_total='" . count($servers) . "', servers_online='$servers_online', top_map='$topMap'";

foreach ($sql as $num => $query) {
    $result = db()->query($query);
}
