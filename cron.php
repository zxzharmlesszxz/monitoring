<html>
<head>
 <meta http-equiv="Refresh" content="300; URL=/cron.php">
</head>
<body>
<?php
require_once __DIR__."/include/core.php";

$servers = db()->query("SELECT * FROM ".DB_SERVERS);
$servers_total = 0;
$servers_online = 0;
while($r=db()->fetch_array($servers)) {
 $servers_total++;
 $serv=serverInfo($r['server_ip']);
 if($serv['status']=='off' || empty($serv['name'])){
  $result = db()->query("UPDATE ".DB_SERVERS."
   SET
    server_status = '0',
    server_map = '-',
    server_players = '-',
    server_maxplayers = '-'
    ".(($r['server_status'] == 1 or $r['status_change'] == 0) ? ", status_change = ".time() : ", status_change = 10")."
   WHERE server_id='".$r['server_id']."'");
  continue;
 }
 $servers_online++;
 $name=db()->escape_value($serv['name']);
 $result = db()->query("
  UPDATE ".DB_SERVERS."
   SET
    server_name = '".$name."',
    server_map = '".$serv['map']."',
    server_players = '".$serv['players']."',
    server_maxplayers = '".$serv['max_players']."',
    server_status = '1'
  ".(($r['server_status'] == 0 or $r['status_change'] == 0) ? ", status_change = ".time() : ", status_change = 10")."
  WHERE server_id='".$r['server_id']."'
 ");
 if ($result) {
  echo "<font color='green'>Даные сервера с порядковым ".$r['server_id']." внесены в базу данных</font>";} else {echo "<font color='red'><b>Ошибка</b>, данные сервера с порядковым ".$r['server_id']." не были внесены в БД</font>";
 }
 echo "<br>
 </body>
 </html>
 ";
}

$update_timestamp = time(); // запоминаем дату
$result = db()->query("UPDATE ".DB_SETTINGS." SET last_update='$update_timestamp', servers_total='$servers_total', servers_online='$servers_online'");
