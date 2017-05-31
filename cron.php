<html>
<head>
    <meta http-equiv="Refresh" content="300; URL=/cron.php">
</head>
<body>
<?php
require_once __DIR__ . "/include/core.php";

function topMap(array $servers)
{
    $max = "";
    $count = 0;
    $maps = array();
    foreach ($servers as $server) {
        if (!array_key_exists($server['map'], $maps))
            $maps[$server['map']] = 1;
        else
            $maps[$server['map']] += 1;
    }

    foreach ($maps as $map => $num) {
        if ($num > $count) {
            $count = $num;
            $max = $map;
        }
    }
    return $max;
}

$query = db()->query("SELECT * FROM " . DB_SERVERS);
$servers = array();
$servers_online = 0;

while ($r = db()->fetch_array($query)) {
    if ($r['server_status'] == 0 and ($r['status_change'] - time()) < 86400) {
        $sql .= "DROP FROM " . DB_SERVERS . " WHERE server_id = {$r['server_id']};";
        continue;
    }
    $servers[] = serverInfo($r['server_ip']);;
}

foreach ($servers as $num => $server) {
    if ($server['status'] == 'off' || empty($server['name'])) {
        $sql .= "UPDATE " . DB_SERVERS . " SET server_status = '0', server_map = '-', server_players = '-', server_maxplayers = '-' ";
        $sql .= (($server['server_status'] == 1) ? ", status_change = " . time() : "");
        $sql .= " WHERE server_id='{$server['server_id']}';";
        continue;
    }
    $servers_online++;
    $name = db()->escape_value($server['name']);
    $sql .= "UPDATE " . DB_SERVERS . " SET server_name = '{$name}',";
    $sql .= " server_map = '{$server['map']}', server_players = '{$server['players']}',";
    $sql .= " server_maxplayers = '{$server['max_players']}', server_status = '1' ";
    $sql .= (($server['server_status'] == 0) ? ", status_change = " . time() : "");
    $sql .= " WHERE server_id='{$server['server_id']}';";
}

$topMap = topMap($servers);

$update_timestamp = time(); // запоминаем дату
$sql .= "UPDATE " . DB_SETTINGS . " SET last_update='$update_timestamp', servers_total='" . count($servers) . "', servers_online='$servers_online', top_map='$topMap';";
$result = db()->query($sql);

?>
<br>
</body>
</html>
