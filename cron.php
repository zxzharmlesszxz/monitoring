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
    $maps = array();
    foreach ($servers as $server) {
        if (!array_key_exists($server['map'], $maps))
            $maps[$server['map']] = 1;
        else
            $maps[$server['map']] += 1;
    }
    print_r($maps);
    return $max;
}

$query = db()->query("SELECT * FROM " . DB_SERVERS);
$servers = array();
$servers_online = 0;

while ($r = db()->fetch_array($query)) {
    $servers[] = $r;
}

foreach ($servers as $num => $server) {
    $servers[$num] = serverInfo($server['server_ip']);
}

var_dump($servers);

foreach ($servers as $num => $server)
{
    if ($server['status'] == 'off' || empty($server['name'])) {
        $str = "UPDATE " . DB_SERVERS . " SET server_status = '0', server_map = '-', server_players = '-', server_maxplayers = '-' ";
        $str .= (($server['server_status'] == 1) ? ", status_change = " . time() : "");
        $str .= " WHERE server_id='{$server['server_id']}'";
        $result = db()->query($str);
        continue;
    }
    $servers_online++;
    $name = db()->escape_value($server['name']);
    $str = "UPDATE " . DB_SERVERS . " SET server_name = '{$name}',";
    $str .= " server_map = '{$server['map']}', server_players = '{$server['players']}',";
    $str .= " server_maxplayers = '{$server['max_players']}', server_status = '1' ";
    $str .= (($server['server_status'] == 0) ? ", status_change = " . time() : "");
    $str .= " WHERE server_id='{$server['server_id']}'";
    $result = db()->query($str);
    if ($result) {
        echo "<span style='color: green'>Даные сервера с порядковым " . $server['server_id'] . " внесены в базу данных</span>\n";
    } else {
        echo "<span style='color: red'><b>Ошибка</b>, данные сервера с порядковым " . $server['server_id'] . " не были внесены в БД</span>\n";
    }
}

$topMap = topMap($servers);

$update_timestamp = time(); // запоминаем дату
$result = db()->query("UPDATE " . DB_SETTINGS . " SET last_update='$update_timestamp',
 servers_total='" . count($servers) . "', servers_online='$servers_online'");

?>
<br>
</body>
</html>
