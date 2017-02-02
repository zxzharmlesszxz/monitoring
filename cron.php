<html>
<head>
 <meta http-equiv="Refresh" content="300; URL=/cron.php">
</head>
<body>
<?php
require_once __DIR__."/include/core.php";

$link = dbconnect($db_host, $db_user, $db_pass, $db_name);
require_once "include/function.php";
$servers = dbquery("SELECT * FROM ".DB_SERVERS);
$servers_total = 0;
$servers_online = 0;
while($r=dbarray_fetch($servers)) {
 $servers_total++;
 $serv=serverInfo($r['server_ip']);
 if($serv['status']=='off' || empty($serv['name'])){
  $result = dbquery("UPDATE ".DB_SERVERS."
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
 $name=mysql_real_escape_string($serv['name']);
 $result = dbquery("
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
 echo "<br>";
}

$update_timestamp = time(); // запоминаем дату
$result = dbquery("UPDATE ".DB_SETTINGS." SET last_update='$update_timestamp', servers_total='$servers_total', servers_online='$servers_online'");

mysql_close();
?>
</body>
</html>
