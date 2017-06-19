<?php
require_once(__DIR__ . '/../include/core.php');

echo <<<EOT
<html>
 <head>
  <link rel="stylesheet" type="text/css" href="/templates/css/byweb.css">
 </head>
 <body>
EOT;

if (isset($_GET["id"]) and $_GET["id"] >= 1) {
    $data = $servers[$_GET['id']];
    if (!empty($data)) {
        $infoInfo = $data['info'];
        $playersInfo = $data['players'];
        usort($playersInfo, 'sortByKills');
        $rulesInfo = $data['rules'];
        $dbInfo = $data['dbInfo'];

        $mapImg = MAPS . "{$dbInfo['server_game']}/{$infoInfo['mapName']}.png";
        $status = ((!empty($infoInfo['serverName'])) ? '<span style="color:#51F505;"><b>Online</b></span>' : '<span style="color:#f00;"><b>Offline</b></span>');
        $map = ((strlen($infoInfo["mapName"]) >= 12) ? mb_substr($infoInfo["mapName"], 0, 12, 'UTF-8') . '...' : $infoInfo["mapName"]);
        $name = html_entity_decode($infoInfo["serverName"]);
        $players = '<ol>';
        foreach ($playersInfo as $player) {
            $players .= "<li>{$player['name']}<span class='score'>{$player['score']}</span></li>\n";
        }
        $players .= '</ol>';

        echo <<<EOT
  <div id="frame">
    <div class="name">
      <a href="/server/{$_GET['id']}/" target="_blank">
       {$name}
      </a>
    </div>
    <div class="map" style="background-image: url('{$mapImg}')">
        <div class="block">
            <div class="mapName">Карта: {$map}</div>
            <div class="status">
                {$status}
            </div>
        </div>
    </div>
    <div class="players">Игроки: {$infoInfo["playerNumber"]} / {$infoInfo["maxPlayers"]}</div>
    <div class="address">
     <b>{$dbInfo["server_ip"]}</b>
    </div>
    <div class="steam">
     <a href="steam://connect/{$dbInfo["server_ip"]}/" title="Подключиться через Steam" target="_blank">
      <b>Подключиться</b>
     </a>
    </div>
    <div class="playersBlock">
    {$players}
    </div>
  </div>
EOT;
    }
} else {
    echo "Сервер не найден в базе!";
}

echo <<<EOT
 </body>
</html>
EOT;
