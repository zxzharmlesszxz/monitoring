<?php
/*
 * Server list
 * Made by starky
*/

/* Script security */
if(!defined("MONENGINE")) {
 header("Location: index.php");
 exit();
}

/* Other code */
//include(INCLUDES."pagination.class.php");
//$pagination = new pagination;
//$page_num = 1;

//$page_num = (isset($_GET['page_num'])) ? $_GET['page_num'] : 0;
//$needed_servers = dbquery("SELECT count(*) FROM ".DB_SERVERS." WHERE server_new != 1 AND server_status != 0 AND server_off != 1 {$filter}");
//$needed_servers = dbarray_fetch($needed_servers);
//$needed_servers = $needed_servers[0];
//$pg_info = $pagination->calculate_pages($needed_servers, $settings['servers_per_page'], $page_num);
//$query_limit = $pg_info['limit'];

// Uncomment the next line for pagination debug
//print_r($pg_info);

$select_query = "SELECT * FROM ".DB_SERVERS." WHERE server_new != 1 AND server_status != 0 AND server_off != 1 {$filter} ORDER BY server_vip DESC, votes DESC ";//.$query_limit;
$servers = dbquery($select_query);

if ($servers_total !=0 ) {
 $row = '';
 while ($r=dbarray_fetch($servers)) {
  $players = $r['server_players']."/".$r['server_maxplayers'];
  $server_location = $r['server_location'];

  if (empty($server_location))
   $server_location = 'undefined';
  
  if (array_key_exists($r['server_row_style'], $styles)) {
   $row .= "<tr style='{$styles[$r['server_row_style']]['style']}'>";
  } else {
   $row .= "<tr>";
  }

  if ($r['server_players'] == $r['server_maxplayers']) {
   $players = "<span style='color: #00FF00'>".$r['server_players']."/".$r['server_maxplayers']."</span>";
  }

  if ($r['server_status'] ==1) {
   $server_full=floor(($r['server_players'] / $r['server_maxplayers']) * 100);
  } else {
   $server_full="0";
  }
   
  if ($server_full=='0')
   $la = "la0";

  if ($server_full<='20' and $server_full>'0')
   $la = "la1";
   
  if ($server_full<='40' and $server_full>'20')
   $la = "la2";
   
  if ($server_full<='60' and $server_full>'40')
   $la = "la3";
   
  if ($server_full<='80' and $server_full>'60')
   $la = "la4";
   
  if ($server_full<='100' and $server_full>'80')
   $la = "la5";

  $row .= "<td align='left' style='padding-left:20px;'>";
  $row .= "<img src='/images/flags/$server_location.png' class='location' title='{$r['server_location']}' alt='{$r['server_location']}'>";
  $row .= "<a class='name' title='Перейти на страницу сервера {$r['server_name']}' href='".$settings['site_url']."server/{$r['server_id']}' rel='follow'>".htmlspecialchars($r['server_name'])."</a> ";
  $row .= (($r['server_steam'] == '1') ? '<img src=\'/images/img/icon_steam.png\'>' : '');
  $row .= "</td>";
  $row .= "<td><img src='/images/icons/{$r['server_game']}.gif' class='game' title='{$r['server_game']} сервер' alt='{$r['server_game']} сервер' />";
  $row .= "{$r['server_ip']}</td>";
  $row .= "<td class='mode'>{$r['server_mode']}</td>";
  $row .= "<td class='map'>{$r['server_map']}<span class='icon' data-icon='" . MAPS . "{$r['server_game']}/{$r['server_map']}.png'></span></td>";
  $row .= "<td class='players'><span class='la'><img src='/images/la_icons/{$la}.gif'></span>{$players}</td>";
  $row .= "<td class='votes'>";

  if ($r['server_vip'] == 1) {
   $row .= '<img src="/images/img/vip.png" align="texttop" style="opacity:0.6;">';
  } else {
   $row .= "<span class='votes_count' id='votes_count_{$r['server_id']}' >".intval($r['votes'])."</span>";
   $row .= "<span class='vote_buttons' id='vote_buttons_{$r['server_id']}'>";
   $row .= "<a href='javascript://' onClick=\"rating({$r['server_id']}, 'up', '".md5("m0n3ng1ne.s4lt:P{]we{$r['server_id']}@._)%;")."');\" class='voteup' id='{$r['server_id']}'></a>";
   $row .= "<a href='javascript://' onClick=\"rating({$r['server_id']}, 'down', '".md5("m0n3ng1ne.s4lt:P{]we{$r['server_id']}@._)%;")."');\" class='votedown' id='{$r['server_id']}'></a>";
   $row .= "</span>";
  }
  $row .= "</td>";
  $row .= "</tr>";
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
 {$row}
 </tbody>
</table>
EOT;
/* TABLE END */

/* PAGINATION */
/*
if (count($pg_info['pages']) > 1) {
 echo "<div class='pagination' align='center' style='margin-bottom:10px; margin-top:10px;'>";
 
 if ($pg_info['current'] == 1) {
  echo "<span>Назад</span><span>1</span>";
 } else {
  echo "<a href='/{$load}/{$pg_info['previous']}' rel='follow'>Назад</a><a href='/{$load}/1'>1</a>";
 }

 foreach($pg_info['pages'] as $k => $v) {
  if ($v == 1 or $v == $pg_info['last'])
   continue; 

  if ($v == $pg_info['current'] or $v == '...') {
   echo "<span>$v</span>";
  } else {
   echo "<a href='/{$load}/$v' rel='follow'>$v</a>";
  }
 }

 if ($pg_info['current'] == $pg_info['last']) {
  echo "<span>{$pg_info['last']}</span><span>Вперёд</span>";
 } else {
  echo "<a href='/{$load}/{$pg_info['last']}' rel='follow'>{$pg_info['last']}</a>";
  echo "<a href='/{$load}/{$pg_info['next']}' rel='follow'>Вперёд</a>";
  echo "<div style='float:left;'><a title='Прокрутить сайт ввверх' href='/#top' rel='follow'>Вверх сайта</a></div>";
  echo "<div style='float:right;'><a title='Прокрутить сайт ввверх' href='/#top' rel='follow'>Вверх сайта</a></div>";
 }
       
 echo "</div>";
}
*/
/* PAGINATION END */
