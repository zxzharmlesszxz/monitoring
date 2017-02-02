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

/* Other code */
include(INCLUDES."pagination.class.php");
$pagination = new pagination;
$page_num = 1;

if (isset($_GET['page_num'])) {
 $page_num = $_GET['page_num'];
}

$needed_servers = dbquery("SELECT count(*) FROM ".DB_SERVERS." WHERE server_new != 1 AND server_status != 0 AND server_game = '{$load}' AND server_off != 1");
$needed_servers = dbarray_fetch($needed_servers);
$needed_servers = $needed_servers[0];
$pg_info = $pagination->calculate_pages($needed_servers, $settings['servers_per_page'], $page_num);
$query_limit = $pg_info['limit'];

// Uncomment the next line for pagination debug
//print_r($pg_info);

$select_query = "SELECT * FROM ".DB_SERVERS." WHERE server_new != 1 AND server_status != 0 AND server_game = '{$load}' AND server_off != 1 ORDER BY server_vip DESC, votes DESC ".$query_limit;
$noserv = "<div style='padding:20px; font-weight:bold; text-align:center;'>Серверы не найдены!</div>";

if (mysql_num_rows(mysql_query($select_query)) >0) {
 $servers = dbquery($select_query);

 echo "<table class='servers' cellpadding='0' cellspacing='0' border='0'>";

 /*
  $locale['010'] Имя сервера
  $locale['011'] Адрес
  $locale['013'] Игроки
 */

 /* TABLE HEAD */
 echo "
 <thead>
  <tr>
   <th width='35%' style='padding-left:45px;'>Название сервера</th>
   <th width=200>Адрес сервера</th>
   <th width=80>Мод</th>
   <th width=130>Карта</th>
   <th width=100>Игроки</th>
   <th width=60>Голоса</th>
  </tr>
 </thead>";

 /* TABLE BODY */
 echo "<tbody>";

 if ($servers_total !=0 ) {
  while ($r=dbarray_fetch($servers)) {
   $players = $r['server_players']."/".$r['server_maxplayers'];
   $server_location = $r['server_location'];
   if (empty($server_location)) {
    $server_location = 'undefined';
   }

   if (array_key_exists($r['server_row_style'], $styles)) {
    $row = "<tr style='{$styles[$r['server_row_style']]['style']}'>";
   } else {
    if ($r['server_players'] == $r['server_maxplayers']) {
     $players = "<font color='#00FF00'>".$r['server_players']."/".$r['server_maxplayers']."</font>";
    }

    if ($r['server_players'] == 0) {
     $players = "<font color='#C11D29'>".$r['server_players']."/".$r['server_maxplayers']."</font>";
    }

    if ($r['server_status'] ==1) {
     $server_full=floor(($r['server_players'] / $r['server_maxplayers']) * 100);
    } else {
     $server_full="0";
    }

    if ($server_full=='0') $la = "la0";
    if ($server_full<='20' and $server_full>'0') $la = "la1";
    if ($server_full<='40' and $server_full>'20') $la = "la2";
    if ($server_full<='60' and $server_full>'40') $la = "la3";
    if ($server_full<='80' and $server_full>'60') $la = "la4";
    if ($server_full<='100' and $server_full>'80') $la = "la5";
  
    $row = "<tr>";
   }

   $row .= "<td align='left' style='padding-left:20px;'><a href='".$settings['site_url']."server/{$r['server_id']}'></a><img src='images/flags/$server_location.png' style='width:16;height:11;opacity:0.8;' title='$r[server_location]' alt='$r[server_game]'><a href='".$settings['site_url']."server/{$r['server_id']}'>".htmlspecialchars($r['server_name'])."</a>".(($r['server_steam'] == '1') ? '<img src=\'images/icon_steam.png\'>' : '')."</td>";
   $row .= "<td><img src='/images/icons/$r[server_game].gif' style='width:16px;height:16px;vertical-align:middle;margin-bottom:2px;opacity:0.8;' title='$r[server_game] сервер'  alt='$r[server_game] сервер'  />{$r['server_ip']}</td>";
   $row .= "<td>$r[server_mode]</td>";
   $row .= "<td><a href='/search' class='map'>{$r['server_map']}</a></td>";
   $row .= "<td>{$players}</td>";
   $row .= "<td>".(($r['server_vip'] == 1) ? '<img src="/images/vip.png" align="texttop" style="opacity:0.8;">' :
    "<span class='votes_count' id='votes_count_{$r['server_id']}' >".$r['votes']."</span>".
    "<span class='vote_buttons' id='vote_buttons_{$r['server_id']}'>".
    "<a href='javascript://' onClick=\"rating({$r['server_id']}, 'up', '".md5("m0n3ng1ne.s4lt:P{]we{$r['server_id']}@._)%;")."');\" class='voteup' id='{$r['server_id']}'></a>".
    "<a href='javascript://' onClick=\"rating({$r['server_id']}, 'down', '".md5("m0n3ng1ne.s4lt:P{]we{$r['server_id']}@._)%;")."');\" class='votedown' id='{$r['server_id']}'></a>".
    "</span>"
    )."</td>";

   $row .= "</tr>";

   echo $row;
  }
 } else {
  echo "<th><center> ".$locale['017']."</center></th>";
 }
 /* TBODY END */
 echo "</tbody></table>";
 /* TABLE END */

 /* PAGINATION */
 if (count($pg_info['pages']) > 1) {
  echo "<div class='pagination' align='center' style='margin-bottom:10px; margin-top:10px;'>";

  echo ($pg_info['current'] == 1) ?
   "<span>Назад</span><span>1</span>" :
   "<a href='/{$load}/{$pg_info['previous']}'>Назад</a><a href='/{$load}/1'>1</a>";

  foreach ($pg_info['pages'] as $k => $v) {
   if ($v == 1 or $v == $pg_info['last'])
    continue; 
   
   echo ($v == $pg_info['current'] or $v == '...') ?
    "<span>$v</span>" :
    "<a href='/{$load}/$v'>$v</a>";
  }

  echo ($pg_info['current'] == $pg_info['last']) ?
   "<span>{$pg_info['last']}</span><span>Вперёд</span>" :
   "<a href='/{$load}/{$pg_info['last']}'>{$pg_info['last']}</a><a href='/{$load}/{$pg_info['next']}'>Вперёд</a>
   <div style='float:left;'><a href='/#top'>Вверх сайта</a></div><div style='float:right;'><a href='/#top'>Вверх сайта</a>";

  echo "</div>";
 }
 /* PAGINATION END */

} else {
 echo $noserv;
}