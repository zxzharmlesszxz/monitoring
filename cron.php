<html>
<head>
    <meta http-equiv="Refresh" content="300; URL=/cron.php">
</head>
<body>
<?php
require_once __DIR__ . "/include/core.php";

$query = db()->query("SELECT * FROM " . DB_SERVERS);
$servers = array();
$servers_online = 0;

while ($r = db()->fetch_array($query)) {
    $servers[] = $r;
}

foreach ($servers as $num => $server) {
    $serv = serverInfo($server['server_ip']);
    if ($serv['status'] == 'off' || empty($serv['name'])) {
        $result = db()->query("UPDATE " . DB_SERVERS . "
   SET
    server_status = '0',
    server_map = '-',
    server_players = '-',
    server_maxplayers = '-'
    " . (($server['server_status'] == 1 or $server['status_change'] == 0) ? ", status_change = " . time() : ", status_change = 10") . "
   WHERE server_id='" . $server['server_id'] . "'");
        continue;
    }
    $servers_online++;
    $name = db()->escape_value($serv['name']);
    $result = db()->query("
  UPDATE " . DB_SERVERS . "
   SET
    server_name = '" . $name . "',
    server_map = '" . $serv['map'] . "',
    server_players = '" . $serv['players'] . "',
    server_maxplayers = '" . $serv['max_players'] . "',
    server_status = '1'
  " . (($server['server_status'] == 0 or $server['status_change'] == 0) ? ", status_change = " . time() : ", status_change = 10") . "
  WHERE server_id='" . $server['server_id'] . "'
 ");
    if ($result) {
        echo "<font color='green'>Даные сервера с порядковым " . $server['server_id'] . " внесены в базу данных</font>\n";
    } else {
        echo "<font color='red'><b>Ошибка</b>, данные сервера с порядковым " . $server['server_id'] . " не были внесены в БД</font>\n";
    }
}

$update_timestamp = time(); // запоминаем дату
$result = db()->query("UPDATE " . DB_SETTINGS . " SET last_update='$update_timestamp',
 servers_total='" . count($servers) . "', servers_online='$servers_online'");

?>
<br>
</body>
</html>
