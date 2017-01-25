<?php
/*
 * Server info edit script
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
$max_tops = 5 * $settings['top_rows'];
$get_taken_tops = dbquery("SELECT * FROM `".DB_SERVERS."` WHERE `server_top` != '0'");
$taken_tops = Array();

while($s_arr = dbarray_fetch($get_taken_tops)) {
 $taken_tops[] = $s_arr['server_top'];
}

$message = '';

if (isset($_POST['save_changes']) and $_POST['save_changes'] == 1) {
 @$blocked = $_POST['server_blocked'];
 if (!isset($_POST['server_blocked'])) $blocked = 0;
 @$steam = $_POST['server_steam'];
 if (!isset($_POST['server_steam'])) $steam = 0;
 $top_place = $_POST['server_top_place'];
 @$vip = $_POST['server_vip_status'];
 if (!isset($_POST['server_vip_status'])) $vip = 0;
 $votes = $_POST['server_votes'];
 $site = mysql_real_escape_string($_POST['server_site']);
 $about = mysql_real_escape_string($_POST['server_about']);
 $game = mysql_real_escape_string($_POST['server_game']);
 $mode = mysql_real_escape_string($_POST['server_mode']);
 $new_style = mysql_real_escape_string($_POST['server_row_style']);
 $new_style_ip = mysql_real_escape_string($_POST['server_ipport_style']);
 $server_top_time = time() + (86400*$_POST['server_top_time']);
 $server_vip_time = time() + (86400*$_POST['server_vip_time']);
 $server_color_time = time() + (86400*$_POST['server_color_time']);

 // Set up a query
 $update_query = "UPDATE `".DB_SERVERS."` SET ";
 $update_query_params = Array();

 // If ban status changed
 if ($server['server_off'] != $blocked and is_numeric($blocked))
  $update_query_params[] = "`server_off` = '$blocked' ";

 // If steam status changed
 if ($server['server_steam'] != $steam and is_numeric($steam))
  $update_query_params[] = "`server_steam` = '$steam' ";

 // If top place changed, is free and not higher than maximum number of places
 if ($server['server_top'] != $top_place and is_numeric($top_place) and $top_place <= $max_tops and !in_array($top_place, $taken_tops))
  $update_query_params[] = "`server_top` = '$top_place' ";

 // If vip status changed
 if ($server['server_vip'] != $vip and is_numeric($vip))
  $update_query_params[] = "`server_vip` = '$vip' ";

 // If rating changed
 if ($server['votes'] != $votes and is_numeric($votes) and $votes >= 0)
  $update_query_params[] = "`votes` = '$votes' ";

 // If site changed
 if ($server['server_site'] != $site and (empty($site) or isValidUrl($site)))
  $update_query_params[] = "`server_site` = '$site' ";

 // If info about server changed
 if ($server['about'] != $about)
  $update_query_params[] = "`about` = '$about' ";

 // If info game server changed
 if ($server['game'] != $game)
  $update_query_params[] = "`server_game` = '$game' ";

 // If info game server changed
 if ($server['mode'] != $mode)
  $update_query_params[] = "`server_mode` = '$mode' ";

 // If style changed
 if ($server['server_row_style'] != $new_style and array_key_exists($new_style, $styles) or empty($new_style))
  $update_query_params[] = "`server_row_style` = '$new_style' ";

 // If style ipport
 if ($server['server_ipport_style'] != $new_style and array_key_exists($new_style, $styles) or empty($new_style))
  $update_query_params[] = "`server_ipport_style` = '$new_style_ip' ";

 // If time
 $update_query_params[] = "`server_top_time` = '$server_top_time' ";
 $update_query_params[] = "`server_vip_time` = '$server_vip_time' ";
 $update_query_params[] = "`server_color_time` = '$server_color_time' ";

 // Proceed
 if (count($update_query_params) == 0) {
  $message = "<div class='message blue'><span>Информация не была изменена.</span></div>";
 } else {
  foreach ($update_query_params as $key => $param) {
   if ($key == 0) {
    $update_query .= $param;
   } else {
    $update_query .= ",".$param;
   }
  }

  $update_query .= " WHERE `server_id` = '$id'";
  $update = dbquery($update_query);

  if ($update) {
   // Success
   $message = "<div class='message green'><span><b>Успех</b>: Информация была успешно обновлена. <a href='server/$id'>Вернуться на страницу сервера.</a></span></div>";
   // Refreshing information...
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
   $get_taken_tops = dbquery("SELECT * FROM `".DB_SERVERS."` WHERE `server_top` != '0'");
   $taken_tops = Array();

   while ($s_arr = dbarray_fetch($get_taken_tops)) {
    $taken_tops[] = $s_arr['server_top'];
   }
  } else {
   // Update query error :(
   $message = "<div class='message orange'><span><b>Какие-то проблемы</b>: не удалось обновить информацию.</span></div>";
  }
 }
}

$steam = ($server['server_steam'] == '1') ? "checked='checked'" : "";
$off = ($server['server_off'] == 1) ? "checked='checked'" : "";
$top = ($server['server_top'] == 0) ? "selected='selected'" : "";
$top_time = ($server['server_top_time'] != 0 || $server['server_top_time'] > time()) ? ceil(($server['server_top_time']-time())/86400) : "0";
$server_ipport_style = (empty($server['server_ipport_style'])) ? "selected='selected'" : "";
$server_vip_status = ($server['server_vip'] == 1) ? "checked='checked'" : "";
$vip_time = ($server['server_vip_time'] != 0 || $server['server_vip_time'] > time()) ? ceil(($server['server_vip_time']-time())/86400) : "0";
$color_time = ($server['server_color_time'] != 0 || $server['server_color_time'] > time()) ? ceil(($server['server_color_time']-time())/86400) : "0";
$row_style = (empty($server['server_row_style'])) ? "selected='selected'" : "";


$tops = '';
for ($i = 1; $i <= $max_tops; $i++) {
 if (!in_array($i, $taken_tops) or $server['server_top'] == $i)
  $tops .= "<option value='$i' ".(($server['server_top'] == $i) ? "selected='selected'>$i место (выбрано)" : ">$i место")."</option>";
}

$sstyle = '';
foreach ($styles as $style) {
 $sstyle .= "<option value='{$style['name']}'".(($server['server_ipport_style'] == $style['name']) ? " selected='selected'" : "").">{$style['title']}</option>";
}

$row_styles = '';
foreach ($styles as $style) {
 $row_styles .= "<option value='{$style['name']}'".(($server['server_row_style'] == $style['name']) ? " selected='selected'" : "").">{$style['title']}</option>";
}

echo <<<EOT
<script>
 $(document).ready( function() {
  var value = $('#server_votes').val(), new_value, differ;
  $('#server_votes').change(function() {
   new_value = $('#server_votes').val();
   differ = new_value - value;
   if (differ > 0) {
    $('#votes_differ').html('<font color="green"><b>+'+differ+'</b> голосов</font>');
   } else if (differ < 0) {
    $('#votes_differ').html('<font color="red"><b>'+differ+'</b> голосов</font>');
   } else {
    $('#votes_differ').html('');
   }
  });
 });
</script>
<div id='right'>
 <div class='section'>
  <div class='box'>
   <div class='title'>Редактирование сервера <b>{$server['server_name']}</b></div>
   <div class='content'>
    {$message}
    <form action='' method='POST'>
     <div class='row'>
      <label>Параметры</label>
      <div class='right'>
        <input type='checkbox' name='server_blocked' id='first-check' {$off} value='1'>
        <label for='first-check'>Сервер заблокирован</label>
        <input type='checkbox' name='server_steam' id='second-check' {$steam} value='1'>
        <label for='second-check'>Сервер Steam</label>
      </div>
     </div>
     <div class='row'>
      <label>Место в топе</label>
      <div class='right'>
       <select name='server_top_place'>
        <option value='0' {$top}>Сервер не в топе</option>
        {$tops}
       </select>
      </div>
     </div>
     <div class='row'>
      <label>Кол-во дней в топе</label>
       <div class='right'>
        <input name='server_top_time' value='{$top_time}'>
       </div>
      </div>
      <div class='row'>
       <label>Стиль в топе</label>
       <div class='right'>
        <select name='server_ipport_style'>
         <option value='' {$server_ipport_style}>Нет стиля</option>
         {$sstyle}
        </select>
       </div>
      </div>
      <div class='row'>
       <label>VIP статус</label>
       <div class='right'>
        <input type='checkbox' name='server_vip_status' id='server_vip' {$server_vip_status} value='1'>
        <label for='server_vip'>Активен</label>
       </div>
      </div>
      <div class='row'>
       <label>Кол-во дней VIP</label>
       <div class='right'>
        <input name='server_vip_time' value='{$vip_time}'>
       </div>
      </div>
      <div class='row'>
       <label>Стиль в списке</label>
       <div class='right'>
        <select name='server_row_style'>
         <option value='' {$row_style}>Нет стиля</option>
         {$row_styles}
        </select>
       </div>
      </div>
      <div class='row'>
       <label>Кол-во дней Стиля</label>
       <div class='right'>
        <input name='server_color_time' value='{$color_time}'>
       </div>
      </div>
      <div class='row'>
       <label>Игра сервера:</label>
       <div class='right'>
        <select name='server_game' id='server_game' value='{$server['game']}'>
         <option value='cs16'>Counter-Strike</option>
         <option value='css'>Counter-Strike: Source</option>
         <option value='cz'>Counter Strike: Condition zero</option>
         <option value='csgo'>Counter-Strike: Global Offensive</option>
         <option value='hl'>Half-Life</option>
         <option value='hl2'>Half-Life 2 DM</option>
         <option value='l4d'>Left 4 Dead</option>
         <option value='l4d2'>Left 4 Dead 2</option>
         <option value='tf2'>Team Fortress 2</option>
         <option value='gm'>Garry's Mod</option>
        </select>
       </div>
      </div>
      <div class='row'>
       <label>Мод сервера:</label>
       <div class='right'>
        <select name='server_mode' value='{$server['mode']}'>
         <option value='classic'>Classic</option>
         <option value='warcraft'>Warcraft</option>
         <option value='csdm'>CSDM</option>
         <option value='gungame'>GunGame</option>
         <option value='hns'>HNS</option>
         <option value='surf'>Surf</option>
         <option value='jump'>Jump</option>
         <option value='deathrun'>Deathrun</option>
         <option value='diablomod'>DiabloMod</option>
         <option value='superhero'>SuperHero</option>
         <option value='soccerjam'>Soccer Jam</option>
         <option value='jailbreak'>JailBreak</option>
         <option value='knife'>Knife</option>
         <option value='zombiemod'>Zombie Mod</option>
        </select>
       </div>
      </div>
      <div class='row'>
       <label>Рейтинг сервера</label>
       <div class='right'>
        <input type='text' name='server_votes' class='onlynum' id='server_votes' value='{$server['votes']}' style='width:50px;'>
        <span style='margin-left:10px;' id='votes_differ'></span>
       </div>
      </div>
      <div class='row'>
       <label>Описание сервера</label>
       <div class='right'>
        <input name='server_site' placeholder='Нет сайта' value='{$server['server_site']}'>
       </div>
      </div>
      <div class='row'>
       <label>Описание сервера</label>
       <div class='right'>
        <textarea name='server_about' placeholder='В описании пусто'>{$server['about']}</textarea>
       </div>
      </div>
      <div class='row'>
       <div class='right'>
        <input type='hidden' name='save_changes' value='1'>
        <button type='submit' class='green'>
         <span>Сохранить</span>
        </button>
        <button type='button' class='grey' onClick=\"window.location.href='server/$id/'\">
         <span>Отмена</span>
        </button>
       </div>
      </div>
     </form>
    </div>
   </div>
  </div>
 </div>
EOT;
