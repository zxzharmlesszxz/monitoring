<?php
/*
 * Server info display script
 * Made by starky
*/

/* Script security */
if (!defined("MONENGINE")) {
 header("Location: index.php");
 exit();
}

/* Other code */
$id = db()->escape_value($_GET['id']);
/*$get_server = db()->query("SELECT * FROM `".DB_SERVERS."` WHERE `server_id` = '{$id}'");

if (db()->num_rows($get_server) == 0) {
 exit("
  <div id='right'>
   <div class='section'>
    <div class='message red' onClick=\"location.href=''\"><span><b>Ошибка</b>: Сервер не существует, либо был удалён из базы данных.</span></div>
   </div>
  </div>
  ");
}

$server = db()->fetch_array($get_server);
*/
$server = $servers[$id];

//if (file_exists("..".MAPS."{$server['dbInfo']['server_game']}/{$server['info']['mapName']}.png")) {
 $server_map_img = MAPS."{$server['dbInfo']['server_game']}/{$server['info']['mapName']}.png";
//} else {
// $server_map_img = "template/gfx/nomap.jpg";
//}

$server_map_img_style = " width: 160px;
       height: 120px;
       -moz-box-shadow: 0 0 3px #cacaca;
       -webkit-box-shadow: 0 0 3px #CACACA;
       box-shadow: 0 0 3px #CACACA;
       border: 5px solid #f5f5f5;
       ";

$percent = ($server['info']['maxPlayers'] != 0) ? floor($server['info']['playerNumber'] / $server['info']['maxPlayers'] * 100) : 0;
$steam = ($server['dbInfo']['server_steam'] == '1') ? 'Да' : 'Нет';
$site = $server['dbInfo']['server_site'];
$site_link = (!empty($site)) ? "<a href='{$site}' title='Перейти на сайт сервера'>Сайт сервера</a>" : "Сайт сервера";
$game = $server['dbInfo']['server_game'];
$mode = $server['dbInfo']['server_mode'];
$reg_date = @date("d.m.Y H:i", $server['dbInfo']['server_regdata']);
$top_place = ($server['dbInfo']['server_top'] == 0 or empty($server['dbInfo']['server_top'])) ? 'Не находится в топе' : $server['dbInfo']['server_top'];

if ($server['dbInfo']['server_off'] == 1) {
 $status = 'banned';
} elseif (!empty($server['info']['serverName'])) {
 $status = 'online';
} else {
 $status = 'offline';
}

if ($status == 'banned') {
 $ban_img = 'check';
 $ban_text = 'разблокировать';
} else {
 $ban_img = 'cancel';
 $ban_text = 'заблокировать';
}

$cur_style = 'Нет стиля';
if (!empty($server['dbInfo']['server_row_style'])) {
 $cur_style = $server['dbInfo']['server_row_style'];
 if (array_key_exists($cur_style, $styles)) {
  $cur_style = $styles[$cur_style]['title']." (".$cur_style.")";
 } else {
  $cur_style = "Неизвестный (".$cur_style.")";
 }
}

$tur_style = 'Нет стиля';
if (!empty($server['dbInfo']['server_ipport_style'])) {
 $tur_style = $server['dbInfo']['server_ipport_style'];
 if (array_key_exists($tur_style, $styles)) {
  $tur_style = $styles[$tur_style]['title']." (".$tur_style.")";
 } else {
  $tur_style = "Неизвестный (".$tur_style.")";
 }
}

$get_comments = db()->query("SELECT * FROM `".DB_COMMENTS."` WHERE `server_id` = '$id' ORDER BY `id` DESC");

$comms = '';

if (db()->num_rows($get_comments) != 0) {
 while ($comment = db()->fetch_array($get_comments)) {
  $comms .= "<div class='row'>
    <div><h6><b>{$comment['username']}</b> написал:</h6></div>
    <div>{$comment['text']}</div>
   </div>";
 }
} else {
 $comms .= "<div class='row'>Нет отзывов о данном сервере</div>";
}

echo <<<EOT
<div id='right'>
 <div class='section'>
  <div class='half'>
   <div class='box'>
    <div class='title'><img src='template/gfx/status_$status.png'> Основная информация<span class='hide'></span></div>
    <div class='content'>
     <div id='server_info_leftcol'>
      <div>
       <center>
        <img src='$server_map_img' style='{$server_map_img_style}' title='{$server['info']['mapName']}'>
       </center>
      </div>
     </div>
     <div class='row'>
      <label>Название сервера</label>
      <div class='right'><input type='text' readonly value='{$server['info']['serverName']}'></div>
     </div>
     <div class='row'>
      <label>Игра сервера</label>
      <div class='right'><input type='text' readonly value='{$server['dbInfo']['server_game']}'></div>
     </div>
     <div class='row'>
      <label>Мод сервера</label>
      <div class='right'><input type='text' readonly value='{$server['dbInfo']['server_mode']}'></div>
     </div>
     <div class='row'>
      <label>Адрес сервера</label>
      <div class='right'><input type='text' readonly value='{$server['dbInfo']['server_ip']}'></div>
     </div>
     <div class='row'>
      <label>Карта</label>
      <div class='right'><input type='text' readonly value='{$server['info']['mapName']}'></div>
     </div>
     <div class='row'>
      <label>Количество игроков</label>
      <div class='right'><input type='text' readonly value='{$server['info']['playerNumber']}/{$server['info']['maxPlayers']} ({$percent}%)'></div>
     </div>
     <div class='row'>
      <label>Сервер Steam?</label>
      <div class='right'><input type='text' readonly value='{$steam}'></div>
     </div>
     <div class='row'>
      <label>Кол-во голосов</label>
      <div class='right'><input type='text' readonly value='{$server['dbInfo']['votes']}'></div>
     </div>
     <div class='row'>
      <label>{$site_link}</label>
      <div class='right'><input type='text' readonly value='{$site}'></div>
     </div>
    </div>
   </div>
  </div>
  <div class='half'>
   <div class='box'>
    <div class='title'>Дополнительная информация<span class='hide'></span></div>
    <div class='content'>
     <div class='row'>
      <label>Id сервера</label><div class='right'><input type='text' value='{$id}' readonly></div>
     </div>
    <div class='row'>
     <label>Дата регистрации</label><div class='right'><input type='text' value='{$reg_date}' readonly></div>
    </div>
    <div class='row'>
     <label>Место в топе</label><div class='right'><input type='text' value='{$top_place}' readonly></div>
    </div>
    <div class='row'>
     <label>Стиль в спике</label><div class='right'><input type='text' value='{$cur_style}' readonly></div>
    </div>
    <div class='row'>
     <label>Стиль в топе</label><div class='right'><input type='text' value='{$tur_style}' readonly></div>
    </div>
    <center>
     <a href='server/{$id}/edit' class='item'>
      <img src='template/gfx/icons/big/edit.png' alt='Edit'>
      <span>Редактировать сервер</span>
     </a>
     <a href='#' class='item modalopen' style='margin-right:0;'>
      <img src='template/gfx/icons/big/{$ban_img}.png' alt='{$ban_text}'>
      <span>{$ban_text} сервер</span>
     </a>
    </center>
   </div>
  </div>
 </div>
 <div style='clear:both;'></div>
</div>
<div class='modal' title='Изменение статуса сервера' style='height: 100px !important;'>
 <center>Вы уверены что хотите {$ban_text} сервер?<br><br>
 <button type='submit' class='blue' onClick="changeStatus({$id});"><span>Да</span></button>
 <button type='submit' class='grey' onClick="dialogClose('.modal');"><span>Нет</span></button>
</div>
<div class='section'>
 <div class='box'>
  <div class='title'>Отзывы о сервере<span class='hide'></span></div>
   <div class='content'>
    {$comms}
   </div>
  </div>
 </div>
</div>
EOT;
