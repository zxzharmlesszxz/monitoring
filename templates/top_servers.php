<?php
/*
 * Top servers display script
 * Made by starky
*/

/* Script security */
if (!defined("MONENGINE")) {
    header("Location: index.php");
    exit();
}
/* Other code */

$top_servers = array();

foreach ($servers as $id => $server) {
    //$server = json_decode($server, true);
    if ($server['dbInfo']['server_top'] != '0') {
        $tops_array[$server['dbInfo']['server_top']] = $server;
    }

    if ($server['dbInfo']['server_top_time'] < time()) {
        unset($tops_array[$server['dbInfo']['server_top']]);
    }
}

if ($settings['top_rows'] > 0) {
    /*    $top_servers = db()->query("SELECT * FROM " . DB_SERVERS . " WHERE server_new = '0' AND server_top != '0'");
        while ($top_servers_array = db()->fetch_array($top_servers)) {
            $i = $top_servers_array['server_top'];
            foreach ($top_servers_array as $k => $v) {
                $tops_array[$i][$k] = $v;
            }
        }
    */
    // Шаблон занятого места
    $template_got = '
  <div class="unit">
   <div class="map_section">
    <div style="position:absolute;padding:0;margin:2px 2px 2px 80px;z-index:1;opacity:0.8;display:block;width:16px;"><img src="/images/icons/{game}.gif" ></div>
    <a title="Сервер {name}" href="server/{id}" rel="nofollow"><img width="100" height="75" src="' . MAPS . '{game}/{map}.png" style="align:texttop;" ></a>
   </div>
   <div class="info_section">
    <span class="title">Игроки:</span>
    {players}/{players_max}
    <span class="title">Карта:</span>
    {map}
   </div>
   <div class="clearfix"></div>
   <div class="adress_section">
    <a title="Перейти на страницу сервера" href="server/{id}" rel="nofollow">{name}</a>
    <br>
    <div style="padding-top:3px;">
     {address}
    </div>
   </div>
  </div>
 ';

    // Шаблон пустого места
    $template_free = '
  <div class="unit">
   <div class="map_section">
    <a title="Заказать место в шапке" href="/paytop" rel="nofollow"><img width="100" height="75" src="/images/img/top_free.png"></a>
   </div>
   <div class="info_section">
    <span class="title">Игроки:</span>
    Пока нет
    <span class="title">Карта:</span>
    Пока нет
   </div>
   <div class="clearfix"></div>
   <div class="adress_section">
    <a title="Заказать место в шапке" href="/paytop" rel="nofollow">«Премиум место» свободно!</a>
    <br>
    <div style="padding-top:3px;">
    0.0.0.0:00000
   </div>
  </div>
 </div>
 ';

    // Строим топовые места
    $line = 0;
    for ($i = 1; $i <= 5 * LINES_NUM; $i++) {
        if (@is_array($tops_array[$i])) {
            $server_id = $tops_array[$i]['dbInfo']['server_id'];
            $server_name = $tops_array[$i]['info']['serverName'];

            /*if (mb_strlen($server_name, 'UTF-8') > 24) {
                $server_name = mb_substr($server_name, 0, 24, 'UTF-8') . "...";
            }*/

            $server_name = html_entity_decode($server_name);
            $server_location = $tops_array[$i]['dbInfo']['server_location'];
            $server_address = $tops_array[$i]['dbInfo']['server_ip'];
            $server_players_num = $tops_array[$i]['info']['playerNumber'];
            $server_players_num_max = $tops_array[$i]['info']['maxPlayers'];
            $server_map = $tops_array[$i]['info']['mapName'];
            $server_game = $tops_array[$i]['dbInfo']['server_game'];

            if ($tops_array[$i]['dbInfo']['server_off'] == null)
                $server_address = "<span style='color:#789ABF;cursor:help;' title='Данный сервер заблокирован в мониторинге'>[Сервер заблокирован]</a>";

            if ($tops_array[$i]['dbInfo']['server_ipport_style']) {
                $grc = $styles[$tops_array[$i]['dbInfo']['server_ipport_style']];
                $server_address = "<span style='" . $grc['style'] . "'>$server_address</span>";
            }

            if ($tops_array[$i]['info']['serverName'] == null) {
                $server_address .= " <span style='color:#789ABF;cursor:help;' title='Данный сервер выключен'>[<span style='color:#AAAAAA; cursor:help;'>OFF</span>]</span>";
                $server_players_num = "N";
                $server_players_num_max = "A";
                $server_map = "no_image";
            }
            $place_free = false;
        } else {
            $place_free = true;
        }

        if (($i - 1) % 5 == 0 or $i == 1) {
            $line++;
            $class = ($line % 2 == 0) ? '2' : '1';
            echo "<div class='top_zebra_" . $class . "'>";
        }

        echo ($place_free) ? $template_free : use_top_tpl($template_got);

        if ($i % 5 == 0) {
            echo "<div class='clearfix'></div></div>";
        }
    }
}
