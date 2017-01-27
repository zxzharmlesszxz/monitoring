<?php
/*
 * Server search script
 * Made by starky
*/

/* Script security */
if (!defined("MONENGINE")) {
 header("Location: index.php");
 exit();
}
/* Other code */

var_dump($_POST);

/* Search form */
if (count($_POST) == 0) {
 $page = 'advanced_search';
} elseif (isset($_POST['advanced_search'])) {
 $page = 'adv_search_results';
} elseif (isset($_POST['quick_search'])) {
 $page = 'quick_search';
} else {
 $page = 'advanced_search';
}

if ($page == 'advanced_search') {
 include(INCLUDES."countries.class.php");
 $countries = new countries;
 $servers = dbquery("SELECT `server_location` FROM `".DB_SERVERS."` WHERE `server_location` != ''");

 echo "
 <div class='horizontal_line'>Поиск серверов</div>
 <div class='cont'>
  <div class='searchform'>
  <form method='POST'>
  <table cellspacing='0' cellpadding='0'>
   <tbody>
     <tr>
     <td>Поиск по адресу:</td>
     <td>
      <input type='text' name='ip' id='ip' value=''>
      <div class='hint'>
       Для проверки добавлен ли сервер в мониторинг впишите его <strong>IP:PORT</strong><br>
      </div>
     </td>
    </tr>
     </td>
    </tr>
    <tr>
     <td></td>
     <td><br><input type='submit' name='advanced_search' value='Найти' style='width:120px;'></td>
    </tr>
     </td>
     </tbody>
  </table>
  </form>
  </div>
 ";

} elseif ($page == 'adv_search_results') {
 $searchfield = mysql_real_escape_string(trim($_POST['searchfield']));
 $map = mysql_real_escape_string(trim($_POST['map']));
 $ip = mysql_real_escape_string(trim($_POST['ip']));
 $freeslots = trim($_POST['freeslots']);
 $country = mysql_real_escape_string(trim($_POST['country']));
 $query_params = Array();
 /* Search field */
 if (!empty($searchfield)) {
  if (mb_strpos($searchfield, '-steam', 0, "UTF-8") !== false) {
   $searchfield = mb_str_replace('-steam', '', $searchfield);
   $query_params[] = "`server_steam` == '0'";
  }
  if (!empty($searchfield)) {
   if (mb_strpos($searchfield, ' ', 0, 'UTF-8')) {
    $searchfield = explode(' ', $searchfield);
    foreach ($searchfield as $searchfield) {
     list($key, $value) = explode(':', $searchfield);
     $key = trim($key);
     $value = trim($value);
     if ($key == 'rating' and is_numeric($value)) {
      $query_params[] = "`votes` >= '$value'";
     }
    }
   } else {
    list($key, $value) = explode(':', $searchfield);
    $key = trim($key);
    $value = trim($value);
    if ($key == 'rating' and is_numeric($value)) {
     $query_params[] = "`votes` >= '$value'";
    }    
   }
  }
 }
 /* Maps */
 if (!empty($map) and $map != '*') {
  if (mb_strpos($map, ',', 0, 'UTF-8') !== false) {
   $explode_maps = explode(',', $map);
   $map_params = '';
   foreach ($explode_maps as $k => $map) {
    $map = trim($map);
    if ($k == 0) $map_params .= '(';
    $map_params .= "`server_map` = '$map'";
    if ($k != (count($explode_maps) - 1)) {
     $map_params .= ' OR ';
    } else {
     $map_params .= ')';
    }
   }
   $query_params[] = $map_params;
  } else {
   $map = trim($map);
   $query_params[]= "`server_map` = '$map'";
  }
 }
   
  /* IP adress */
 if (!empty($ip) and $ip != '*') {
  if (mb_strpos($ip, ',', 0, 'UTF-8') !== false) {
   $explode_maps = explode(',', $ip);
   $ip_params = '';
   foreach ($explode_ip as $k => $ip) {
    $ip = trim($ip);
    if ($k == 0) $ip_params .= '(';
    $ip_params .= "`server_ip` = '$ip'";
    if ($k != (count($explode_ip) - 1)) {
     $ip_params .= ' OR ';
    } else {
     $ip_params .= ')';
    }
   }
   $query_params[] = $ip_params;
  } else {
   $ip = trim($ip);
   $query_params[]= "`server_ip` = '$ip'";
  }
 }

 /* Site */
 if (!empty($site) and $site != '*') {
  if (mb_strpos($site, ',', 0, 'UTF-8') !== false) {
   $explode_maps = explode(',', $site);
   $site_params = '';
   foreach ($explode_site as $k => $site) {
    $site = trim($site);
    if ($k == 0) $site_params .= '(';
    $site_params .= "`server_site` = '$site'";
    if ($k != (count($explode_site) - 1)) {
     $site_params .= ' OR ';
    } else {
     $site_params .= ')';
    }
   }
   $query_params[] = $site_params;
  } else {
   $site = trim($site);
   $query_params[]= "`server_site` = '$site'";
  }
 }
 
 /* Free slots */
 $freeslots = preg_replace("/\D/", "", $freeslots);
 if (!empty($freeslots) and $freeslots != '*') $query_params[] = "`server_maxplayers` - `server_players` = '$freeslots'";
 /* Country */
 if (!empty($country) and $country != 'all') $query_params[] = "`server_location` = '$country'";
}

////////////////////////////////////////////////////
/// Search results  ////////////////////////////////
////////////////////////////////////////////////////

if ($page == 'adv_search_results' or $page == 'quick_search') {
 echo "<table class='servers1' cellpadding='0' cellspacing='0' border='0'>";

 /* TABLE HEAD */
 echo <<<EOT
 <thead>
  <tr>
   <th style='padding-left:45px;'>Название сервера</th>
   <th width=160>Адрес сервера</th>
   <th width=240>Мод</th>
   <th width=140>Карта</th>
   <th width=100>Игроки</th>
   <th width=60>Рейтинг</th>
   <th style='padding-right:20px;'>Статус</th>
  </tr>
 </thead>
EOT;

 /* TABLE BODY */
 echo "<tbody>";
 if (count($query_params) == 0) {
  echo "<tr><td colspan='8' class='noservincat'>Задан пустой поисковый запрос</td></tr>";
 } else {
  //print_r($query_params); // *Debug*
  /* Building the query */
  $search_query = "SELECT * FROM `".DB_SERVERS."` WHERE ";
  foreach ($query_params as $k => $v) {
   $search_query .= $v;
   if ($k != (count($query_params) - 1)) $search_query .= " AND ";
  }
  $search_query .= " ORDER BY `server_vip` DESC, `votes` DESC LIMIT 100";
  //echo $search_query; // *Debug*
  $servers = dbquery($search_query);
  
  if (mysql_num_rows($servers) != 0) {
   while ($r=dbarray_fetch($servers)) {
    $players = $r['server_players']."/".$r['server_maxplayers'];
    $server_location = $r['server_location'];
    if (empty($server_location)) $server_location = 'undefined';
    if ($r['server_off'] == 1) {
     $status = "<span class='banned'>Banned</span>";
    } elseif ($r['server_status'] == 1) {
     $status = "<span class='online'>Online</span>";
    } elseif ($r['server_status'] == 0) {
     $status = "<span class='offline'>Offline</span>";
    } else {
          $status = "<span class='offline'>N/A</span>";
    }
    
    echo "
    <tr>
     <td align='left' style='padding-left:20px;'>
      <a href='".$settings['site_url']."server/{$r['server_id']}'>
       <img src='images/flags/$server_location.png' style='width:16;height:11;opacity:0.7;' title='$r[server_location]' alt='$r[server_location]'>
      </a>
      <a href='".$settings['site_url']."server/{$r['server_id']}'>{$r['server_name']}</a>"
      .(($r['server_steam'] == '1') ? '<img src=\'images/icon_steam.png\'>' : '').
      "</a>
     </td>
     <td>
      <img src='/images/icons/$r[server_game].gif' style='width:16px;height:16px;vertical-align:middle;margin-bottom:2px;opacity:0.7;' title='$r[server_game] сервер'  alt='$r[server_game] сервер'  />
      {$r['server_ip']}
     </td>
     <td><center>$r[server_mode]</center></td>
     <td>{$r['server_map']}</center></td>
     <td><center>$players</center></td>
     <td><center>{$r['votes']}</center></td>
     <td style='padding-right:20px;'><center>$status</center></td>
    </tr>";
   }
  } else {
   echo "<tr><td colspan='8' width='100%' class='noservincat'>Ничего не найдено</td></tr>";
  }
 }
 /* TBODY END */
 echo "</tbody></table>";
 /* TABLE END */
}
