<?php
require_once(__DIR__ . '/../include/core.php');

$redis = new Redis();
$redis->connect($settings['redis_host']);
$redis->auth($settings['redis_password']);
$redis->select(1);

echo <<<EOT
<html style="overflow: hidden; max-width: 190px;">
 <head>
  <link rel="stylesheet" type="text/css" href="/templates/css/style.css">
 </head>
 <body style="overflow: hidden;">
  <table>
   <tr>
    <td>
EOT;

if (isset($_GET["id"]) and $_GET["id"] >= 1) {
    $data = unserialize($redis->hGet('servers', $_GET['id']));
    if (!empty($data)) {
        $infoInfo = $data['info'];
        $playersInfo = $data['players'];
        $rulesInfo = $data['rules'];
        $dbInfo = $data['dbInfo'];

        $img = '<img src="' . MAPS . $dbInfo['server_game'] . '/' . $infoInfo['mapName'] . '.png" width="150" height="113" style="border:1px solid #898989;"/>';
        $status = (($dbInfo['server_status'] == 1) ? '<span style="color:#51F505;"><b>Online</b></span>' : '<span style="color:#f00;"><b>Offline</b></span>');
        $map = ((strlen($infoInfo["mapName"]) >= 12) ? mb_substr($infoInfo["mapName"], 0, 12, 'UTF-8') . '...' : $infoInfo["mapName"]);
        $name = html_entity_decode($infoInfo["serverName"]);
        $players = '<ol style="padding-left: 10px; height: 100px; overflow: auto;">';
        foreach ($playersInfo as $player) {
            $players .= "<li>{$player['name']} - {$player['score']}</li>\n";
        }
        $players .= '</ol>';

        echo <<<EOT
  <div>
    <div style="font-size: 14px; font-weight: bold;">
      <a style="color: #aaa;" href="/server/{$_GET['id']}/" target="_blank">
       {$name}
      </a>
    </div>
    <a href="/server/{$_GET['id']}/" target="_blank">{$img}</a>
    <div style="color: #aaa; font-size: 12px;">Карта: {$map}</div>
    <div style="color: #aaa; font-size: 12px;">Игроки: {$infoInfo["playerNumber"]} / {$infoInfo["maxPlayers"]}</div>
    <div style="color: #aaa; font-size: 12px;">
     <b>{$dbInfo["server_ip"]}</b>
    </div>
    <div style="color: #aaa; font-size: 12px">
     {$status}
    </div>
    <div style="font-size:12px;">
     <a style="color: #aaa;" href="steam://connect/{$dbInfo["server_ip"]}/" title="Подключиться через Steam" target="_blank">
      <b>Подключиться</b>
     </a>
    </div>
    <div style="color: #aaa; font-size: 10px">
    {$players}
    </div>
  </div>
EOT;
    }
} else {
    echo "Сервер не найден в базе!";
}

echo <<<EOT
    </td>
   </tr>
   <tr>
    <td>
    </td>
   </tr>
  </table>
 </body>
</html>
EOT;
