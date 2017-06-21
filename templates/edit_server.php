<?php
/*
 * Server editing script
 * Made by starky 123
*/

/* Script security */
if (!defined("MONENGINE")) {
 header("Location: index.php");
 exit();
}
/* Other code */

$stage = 1;
if (isset($_GET['page']) and $_GET['page'] == 'edit_server' and isset($_GET['secret_key'])) $stage = 2;

if ($stage == 1) {
 echo "
 <div class='horizontal_line'>Запрос на редактирование сервера</div>
 <div class='cont'>";

 if (isset($_POST['submit_edit_form'])) {
  require_once(INCLUDES."server_edit.class.php");
  $edit = new ServerEdit;
  $edit->SetServerId($_POST['id']);
  $edit->SetServerEmail($_POST['email']);
  if (!$edit->CheckData()) {
   echo "<div class='msg redbg'>{$edit->errors[0]}</div>";
  } else {
   if (count($edit->errors) != 0) {
    echo "<div class='msg redbg'>{$edit->errors[0]}</div>";
   } else {

    if ($edit->SetupKey()) {
     if (!isset($_SESSION['captcha_keystring']) or $_SESSION['captcha_keystring'] != $_POST['keystring']) {
      echo "<div class='msg redbg'>Вы неверно ввели текст с картинки.</div>";
     } else {
      if ($edit->SendMail()) echo "<div class='msg greenbg'>Сообщение с инструкциями было отправлено Вам на почту.</div>";
     }
    } else {
     
    }
   }
  }
 }

 $options = '';
 foreach ($servers as $id => $server)
 {
     $options .= "<option value='{$id}'>{$server['info']['serverName']}({$server['dbInfo']['server_ip']})</option>";
 }

 echo "
  <form action='' method='POST'>
  <table align='center' class='editform'>
   <tr>
    <td colspan='2'></td>
   </tr>
   <tr>
    <td align='right'>ID вашего сервера:</td>
    <td>
     <select name='id'>
        <option selected disabled value=''></option>
        {$options}
     </select>
    </td>
   </tr>
   <tr>
    <td align='right'>Ваш E-mail адрес:</td>
    <td>
     <input type='text' name='email' value='' size='30' />
    </td>
   </tr>
    <tr>
    <td align='right'>Код с картинки:</td>
    <td>
     <img src='/include/cap/index.php?".session_name()."=".session_id()."'>
    </td>
   </tr>
   <tr>
    <td align='right'></td>
    <td>
     <input type='text' style='width:160px;' name='keystring' />
    </td>
   </tr>
   <tr>
    <td colspan='2' align='center'>
     <input type='hidden' name='submit_edit_form' value='1'>
     <input type='submit' value='Отправить запрос' />
    </td>
   </tr>
  </table>
  </form>
 </div>";
} elseif ($stage == 2) {
 echo " <div class='horizontal_line'>Редактирование сервера</div>
   <div class='cont'>";

 $secret_key = $_GET['secret_key'];
 require_once(INCLUDES."server_edit.class.php");
 $edit = new ServerEdit;
 
 if ($edit->CheckKey($secret_key)) {
  $finish = false;
  if (isset($_POST['submit_edit_form'])) {
   if ($edit->SaveChanges($_POST['address'], $_POST['icq'], $_POST['site'], $_POST['about'], $_POST['server_game'], $_POST['server_mode'])) {
    echo "<div class='msg greenbg'>Изменения успешно сохранены.</div><br><center><a href='server/{$edit->server_data['server_id']}'>Перейти на страницу сервера</a></center><br>";
    $finish = true;
   } elseif (count($edit->save_errors) > 0) {
    echo "<div class='msg redbg'>{$edit->save_errors[0]}</div>";
   } else {
    echo "<div class='msg redbg'>Произошла неизвестная ошибка. Обратитесь к Администрации.</div>";
   }
  }

  if (!$finish) {
   echo "
<form action='' method='POST'>
 <table align='center' class='editform'>
  <tr>
   <td align='right'>Игра сервера:</td>
   <td>
    <select style='width:200px;' name='server_game' value='{$edit->server_data['server_game']}'>
     <option value='cs16'>Counter-Strike</option>
     <option value='css'>Counter-Strike: Source</option>
     <option value='cz'>Counter Strike: Condition zero</option>
     <option value='csgo'>Counter Strike: Global Offensive</option>
     <option value='hl2dm'>Half-Life 2</option>
     <option value='hl2dm'>Half-Life 2 DM</option>
     <option value='l4d'>Left 4 Dead</option>
     <option value='l4d2'>Left 4 Dead 2</option>
     <option value='tf2'>Team Fortress 2</option>
     <option value='gm'>Garry's Mod</option>
    </select>
   </td>
  </tr>
  <tr>
   <td align='right'>Мод сервера:</td>
   <td>
    <select style='width:200px;' name='server_mode' value='{$edit->server_data['server_mode']}'>
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
   </td>
  </tr>
  <tr>
   <td align='right'>IP:PORT сервера</td>
   <td>
    <input type='text' name='address' value='{$edit->server_data['server_ip']}' size='40'>
   </td>
  </tr>
  <tr>
   <td align='right'>ICQ:</td>
   <td>
    <input type='text' name='icq' value='{$edit->server_data['server_icq']}' size='20'>
   </td>
  </tr>
  <tr>
   <td align='right'>Сайт сервера:</td>
   <td>
    <input type='text' name='site' value='{$edit->server_data['server_site']}' size='40'>
   </td>
  </tr>
  <tr>
   <td align='right'>Информация о сервере:</td>
   <td>
    <textarea name='about' cols='50'>{$edit->server_data['about']}</textarea>
   </td>
  </tr>
  <tr>
   <td align='right'>Введите код с картинки:</td>
   <td>
    <img src='/include/cap/index.php?".session_name()."=".session_id()."'>
   </td>
  </tr>
  <tr>
   <td align='right'>&nbsp;</td>
   <td>
    <input type='text' style='width:160px;' name='keystring' />
   </td>
  </tr>
  <tr>
   <td colspan='2' align='center'>
    <input type='hidden' name='submit_edit_form' value='1'>
    <input type='submit' value='Сохранить изменения' />
   </td>
  </tr>
 </table>
</form>";
  }
 } else {
  echo "<div class='msg redbg'>Данный секретный ключ не существует.</div>
  <br>
  <center>
   <a href='index.php'>Вернуться на главную страницу</a>
  </center>
  <br>";
 }
}
