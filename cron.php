<html>

<head>
	<meta http-equiv="Refresh" content="300; URL=/cron.php">
</head>

<body>
<?php
require_once "config.php";
require_once "include/rus_name_fix.php";
require_once "include/constants.php";
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
continue;}
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
if($result) {echo "<font color='green'>Даные сервера с порядковым ".$r['server_id']." внесены в базу данных</font>";} else {echo "<font color='red'><b>Ошибка</b>, данные сервера с порядковым ".$r['server_id']." не были внесены в БД</font>";}
echo "<br>";
}
$update_timestamp = time(); // запоминаем дату
$result = dbquery("UPDATE ".DB_SETTINGS." SET last_update='$update_timestamp', servers_total='$servers_total', servers_online='$servers_online'");
// MySQL функции
function dbquery($query) {
    $result = @mysql_query($query);
    if (!$result) {
        echo mysql_error();
        return false;
    } else {
        return $result;
    }
}
function dbarray_fetch($query) {
    $result = @mysql_fetch_array($query);
    if (!$result) {
        echo mysql_error();
        return false;
    } else {
        return $result;
    }
}
function dbconnect($db_host, $db_user, $db_pass, $db_name) {
	$db_connect = @mysql_connect($db_host, $db_user, $db_pass);
	$db_select = @mysql_select_db($db_name);
	@mysql_query("SET NAMES 'utf8'");
	if (!$db_connect) {
		die("<div style='font-family:Verdana;font-size:11px;text-align:center;'><b>Не могу подключиться к MySQL</b><br />".mysql_errno()." : ".mysql_error()."</div>");
	} elseif (!$db_select) {
		die("<div style='font-family:Verdana;font-size:11px;text-align:center;'><b>НЕ могу подключиться к MySQL базе данных</b><br />".mysql_errno()." : ".mysql_error()."</div>");
	}
}

mysql_close();
?>
</body>
</html>
