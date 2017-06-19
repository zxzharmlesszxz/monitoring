<?php
/*
 * Server list
 * Made by starky
*/

/* Script security */
if (!defined("MONENGINE")) {
    header("Location: index.php");
    exit();
}

if ($servers_total != 0) {
    $row = '';
    $vip = '';

    usort($servers, "sortByVotes");

    foreach ($servers as $id => $server) {
        $str = '';
        if ($server['info']['serverName'] == null)
            continue;
        $r = array_merge($server['info'], $server['dbInfo']);

        $players = $r['playerNumber'] . "/" . $r['maxPlayers'];
        $server_location = $r['server_location'];

        if (empty($server_location))
            $server_location = 'undefined';

        if (array_key_exists($r['server_row_style'], $styles)) {
            $str .= "<tr style='{$styles[$r['server_row_style']]['style']}'>";
        } else {
            $str .= "<tr>";
        }

        if ($r['playerNumber'] == $r['maxPlayers']) {
            $players = "<span style='color: #00FF00'>{$r['playerNumber']}/{$r['maxPlayers']}</span>";
        }

        if ($r['serverName'] !== null and $r['maxPlayers'] != 0) {
            $server_full = floor(($r['playerNumber'] / $r['maxPlayers']) * 100);
        } else {
            $server_full = "0";
        }

        if ($server_full == '0')
            $la = "la0";

        if ($server_full <= '20' and $server_full > '0')
            $la = "la1";

        if ($server_full <= '40' and $server_full > '20')
            $la = "la2";

        if ($server_full <= '60' and $server_full > '40')
            $la = "la3";

        if ($server_full <= '80' and $server_full > '60')
            $la = "la4";

        if ($server_full <= '100' and $server_full > '80')
            $la = "la5";

        $str .= "<td align='left' style='padding-left:20px;'>";
        $str .= "<img src='/images/flags/$server_location.png' class='location' title='{$server_location}' alt='{$server_location}'>";
        $str .= "<a class='name' title='Перейти на страницу сервера {$r['serverName']}' href='" . $settings['site_url'] . "server/{$id}' rel='follow'>" . htmlspecialchars($r['serverName']) . "</a> ";
        $str .= (($r['server_steam'] == '1') ? '<img src=\'/images/img/icon_steam.png\'>' : '');
        $str .= "</td>";
        $str .= "<td><img src='/images/icons/{$r['server_game']}.gif' class='game' title='{$r['server_game']} сервер' alt='{$r['server_game']} сервер' />";
        $str .= "{$r['server_ip']}</td>";
        $str .= "<td class='mode'>{$r['server_mode']}</td>";
        $str .= "<td class='map'>{$r['mapName']}<span class='icon' data-icon='" . MAPS . "{$r['server_game']}/{$r['mapName']}.png'></span></td>";
        $str .= "<td class='players'><span class='la'><img src='/images/la_icons/{$la}.gif'></span>{$players}</td>";
        $str .= "<td class='votes'>";

        if ($r['server_vip'] == 1) {
            $str .= '<img src="/images/img/vip.png" align="texttop" style="opacity:0.6;">';
        } else {
            $str .= "<span class='votes_count' id='votes_count_{$id}' >" . intval($r['votes']) . "</span>";
            $str .= "<span class='vote_buttons' id='vote_buttons_{$r['server_id']}'>";
            $str .= "<a href='javascript://' onClick=\"rating({$id}, 'up', '" . md5("m0n3ng1ne.s4lt:P{]we{$id}@._)%;") . "');\" class='voteup' id='{$id}'></a>";
            $str .= "<a href='javascript://' onClick=\"rating({$id}, 'down', '" . md5("m0n3ng1ne.s4lt:P{]we{$id}@._)%;") . "');\" class='votedown' id='{$id}'></a>";
            $str .= "</span>";
        }
        $str .= "</td>";
        $str .= "</tr>";
        $r['server_vip'] ? $vip .= $str : $row .= $str;
    }
}

echo <<<EOT
<table class='servers' cellspacing='0' border='0'>
 <thead>
  <tr>
   <th style='padding-left:45px;'>Название сервера</th>
   <th>Адрес сервера</th>
   <th>Мод</th>
   <th>Карта</th>
   <th>Игроки</th>
   <th>Голоса</th>
  </tr>
 </thead>
 <tbody>
 ${vip}
 {$row}
 </tbody>
</table>
EOT;
/* TABLE END */
