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
$id = mysql_real_escape_string($_GET['id']);
$get_server = dbquery("SELECT * FROM `".DB_SERVERS."` WHERE `server_id` = '{$id}'");

if (mysql_num_rows($get_server) == 0) {
 exit("
  <div id='right'>
   <div class='section'>
    <div class='message red' onClick=\"location.href=''\"><span><b>Ошибка</b>: Сервер не существует, либо был удалён из базы данных.</span></div>
   </div>
  </div>
  ");
}

$server = dbarray_fetch($get_server);

if (file_exists("..".MAPS."{$server['server_game']}/{$server['server_map']}.jpg")) {
 $server_map_img = MAPS."{$server['server_game']}/{$server['server_map']}.jpg";
} else {
 $server_map_img = "template/gfx/nomap.jpg";
}

$server_map_img_style = " width: 160px;
       height: 120px;
       -moz-box-shadow: 0 0 3px #cacaca;
       -webkit-box-shadow: 0 0 3px #CACACA;
       box-shadow: 0 0 3px #CACACA;
       border: 5px solid #f5f5f5;
       ";

$percent = ($server['server_maxplayers'] != 0) ? floor($server['server_players'] / $server['server_maxplayers'] * 100) : 0;
$steam = ($server['server_steam'] == '1') ? 'Да' : 'Нет';
$site = $server['server_site'];
$site_link = (!empty($site)) ? "<a href='{$site}' title='Перейти на сайт сервера'>Сайт сервера</a>" : "Сайт сервера";
$game = $server['server_game'];
$mode = $server['server_mode'];
$reg_date = @date("d.m.Y H:i", $server['server_regdata']);
$top_place = ($server['server_top'] == 0 or empty($server['server_top'])) ? 'Не находится в топе' : $server['server_top'];

if ($server['server_off'] == 1) {
 $status = 'banned';
} elseif ($server['server_status'] == 1) {
 $status = 'online';
} elseif ($server['server_status'] == 0) {
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
if (!empty($server['server_row_style'])) {
 $cur_style = $server['server_row_style'];
 if (array_key_exists($cur_style, $styles)) {
  $cur_style = $styles[$cur_style]['title']." (".$cur_style.")";
 } else {
  $cur_style = "Неизвестный (".$cur_style.")";
 }
}

$tur_style = 'Нет стиля';
if (!empty($server['server_ipport_style'])) {
 $tur_style = $server['server_ipport_style'];
 if (array_key_exists($tur_style, $styles)) {
  $tur_style = $styles[$tur_style]['title']." (".$tur_style.")";
 } else {
  $tur_style = "Неизвестный (".$tur_style.")";
 }
}

$get_comments = dbquery("SELECT * FROM `".DB_COMMENTS."` WHERE `server_id` = '$id' ORDER BY `id` DESC");

$comms = '';

if (mysql_num_rows($get_comments) != 0) {
 while ($comment = dbarray_fetch($get_comments)) {
  $comms .= "<div class='row'>
    <div><h6><b>{$comment['username']}</b> написал:</h6></div>
    <div>{$comment['text']}</div>
   </div>";
 }
} else {
 $comms .= "<div class='row'><center>Нет отзывов о данном сервере</center></div>";
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
        <img src='$server_map_img' style='{$server_map_img_style}' title='{$server['server_map']}'>
       </center>
      </div>
     </div>
     <div class='row'>
      <label>Название сервера</label>
      <div class='right'><input type='text' readonly value='{$server['server_name']}'></div>
     </div>
     <div class='row'>
      <label>Игра сервера</label>
      <div class='right'><input type='text' readonly value='{$server['server_game']}'></div>
     </div>
     <div class='row'>
      <label>Мод сервера</label>
      <div class='right'><input type='text' readonly value='{$server['server_mode']}'></div>
     </div>
     <div class='row'>
      <label>Адрес сервера</label>
      <div class='right'><input type='text' readonly value='{$server['server_ip']}'></div>
     </div>
     <div class='row'>
      <label>Карта</label>
      <div class='right'><input type='text' readonly value='{$server['server_map']}'></div>
     </div>
     <div class='row'>
      <label>Количество игроков</label>
      <div class='right'><input type='text' readonly value='{$server['server_players']}/{$server['server_maxplayers']} ({$percent}%)'></div>
     </div>
     <div class='row'>
      <label>Сервер Steam?</label>
      <div class='right'><input type='text' readonly value='{$steam}'></div>
     </div>
     <div class='row'>
      <label>Кол-во голосов</label>
      <div class='right'><input type='text' readonly value='{$server['votes']}'></div>
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
      <label>Id сервера</label><div class='right'><input type='text' value='{$server['server_id']}' readonly></div>
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
