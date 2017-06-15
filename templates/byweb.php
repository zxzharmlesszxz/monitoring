﻿<?php
require_once(__DIR__ . '/../include/core.php');

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
    if (db()->num_rows(db()->query("SELECT * FROM mon_servers WHERE server_id=" . $_GET["id"])) == 1) {
        $q = db()->fetch_array(db()->query("SELECT * FROM mon_servers WHERE server_id=" . $_GET["id"]));
        $img = '<img src="' . MAPS . $q['server_game'] . '/' . $q['server_map'] . '.png" width="150" height="113" style="border:1px solid #898989;"/>';
        $status = (($q['server_status'] == 1) ? '<span style="color:#51F505;"><b>Online</b></span>' : '<span style="color:#f00;"><b>Offline</b></span>');
        $map = ((strlen($q["server_map"]) >= 12) ? mb_substr($q["server_map"], 0, 12, 'UTF-8') . '...' : $q["server_map"]);
        $name = html_entity_decode($q["server_name"]);
        $sq = new SourceServerQueries();
        $address = explode(':', $q['server_ip']);
        $sq->connect($address[0], $address[1]);
        $players = '<ol style="padding-left: 10px; height: 100px; overflow: auto;">';
        foreach ($sq->getPlayers() as $player) {
            $players .= "<li>{$player['name']} - {$player['score']}</li>\n";
        }
        $players .= '</ol>';

        echo <<<EOT
  <div>
    <div style="font-size: 14px; font-weight: bold;">
      <a style="color: #aaa;" href="/server/{$q["server_id"]}/" target="_blank">
       {$name}
      </a>
    </div>
    <a href="/server/{$q["server_id"]}/" target="_blank">{$img}</a>
    <div style="color: #aaa; font-size: 12px;">Карта: {$map}</div>
    <div style="color: #aaa; font-size: 12px;">Игроки: {$q["server_players"]} / {$q["server_maxplayers"]}</div>
    <div style="color: #aaa; font-size: 12px;">
     <b>{$q["server_ip"]}</b>
    </div>
    <div style="color: #aaa; font-size: 12px">
     {$status}
    </div>
    <div style="font-size:12px;">
     <a style="color: #aaa;" href="steam://connect/{$q["server_ip"]}/" title="Подключиться через Steam" target="_blank">
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
