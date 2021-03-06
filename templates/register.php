<?php
/*
 * Server registration script
 * Made by starky
*/

/* Script security */
if (!defined("MONENGINE")) {
 header("Location: index.php");
 exit();
}
/* Other code */

echo "<div class='horizontal_line'>Добавить сервер</div><div class='cont'>";

if ($settings['enable_registration'] == 0) {
 echo "<div class='cont' style='padding-top: 14px;'>";
 displayMessage('<br>Регистрация серверов временно приостановлена.<br><br>', 'error');
} else {
 require(INCLUDES."countries.class.php");
 $countries = new countries;
 $address = '';
 $steam = 0;
 $game = '';
 $mode = '';
 $message = '';
 $email = '';
 $site = '';
 $icq = '';
 $location = '';
 $about = '';

 if (isset($_POST['submit_registration'])) {
  $address = db()->escape_value($_POST['server_address']);
  $steam = 0;
  $errors = Array();
  if (isset($_POST['server_steam'])) $steam = 1;
  $game = db()->escape_value($_POST['server_game']);
  $mode = db()->escape_value($_POST['server_mode']);
  $email = db()->escape_value($_POST['server_email']);
  $site = db()->escape_value($_POST['server_site']);
  $icq = db()->escape_value($_POST['server_icq']);
  $location = db()->escape_value($_POST['server_location']);
  $about = db()->escape_value($_POST['server_about']);
  $regex_ipport = "[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\:[0-9]{1,5}";
  $regex_hostport = "[a-zA-Z0-9](-*[a-zA-Z0-9]+)*(\.[a-zA-Z0-9](-*[a-zA-Z0-9]+)*)+\:[0-9]{1,5}";

  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
   $errors[] = "Необходимо ввести корректный E-mail адрес.";
  } elseif (empty($about)) {
   $errors[] = "Не заполнено обязательное поле описание сервера.";
  } elseif (empty($address)) {
   $errors[] = "Не заполнено обязательное поле \"Адрес сервера\"";
  } elseif (!preg_match("/$regex_ipport/", $address) and !preg_match("/$regex_hostport/i", $address)) {
   $errors[] = "Неверный формат адреса сервера.";
  } else {
   $check_server = db()->query("SELECT * FROM `".DB_SERVERS."` WHERE `server_ip` = '{$address}'");
   if (db()->num_rows($check_server) != 0) $errors[] = "Данный сервер уже есть в базе.";
  }

  if (!array_key_exists($location, $countries->countries)) $errors[] = "Выбрана несуществующая локация $location.";
  
  if (!empty($icq) and !is_numeric($icq)) {
   $errors[] = "Введите корректный ICQ.";
  } else {
   if (strlen($icq) > 9) $errors[] = "Введите корректный ICQ.";
  }
  
  if (!empty($site) and !isValidURL($site)) $errors[] = "Введите корректный адрес сайта.";
  
  if (!parse_site($site)) $errors[] = "Введите корректный адрес сайта, где размещена наша ссылка.";
  
  if (!isset($_SESSION['captcha_keystring']) or $_SESSION['captcha_keystring'] != $_POST['keystring']){
   $errors[] = 'Вы неверно ввели текст с картинки.';
  }
  
  if (count($errors) == 0) {
   $add_server_query = "INSERT INTO `".DB_SERVERS."`
    (`server_game`, `server_mode`, `server_ip`, `server_location`, `server_steam`, `server_regdata`, `server_email`, `server_icq`, `server_new`, `server_site`, `about`)
    VALUES ('{$game}', '{$mode}', '{$address}', '{$location}', '{$steam}', '".time()."', '{$email}', '{$icq}', '0', '{$site}', '{$about}')";
   
   $add_server = db()->query($add_server_query);
  }

  if (count($errors) != 0) {
   $message = "<div class='msg redbg'>".implode('<br />',$errors)."</div>";
  } else {
   $message = "<div class='msg greenbg'>Спасибо. Сервер будет добавлен в течение 3 минут.</div>";
   $mess = "Вы успешно добавили свой сервер в наш мониторинг  https://monitoring.contra.net.ua
   \nID вашего сервера '".db()->insert_id()."', a посмотреть его можно по адресу
   \n https://monitoring.contra.net.ua/server/".db()->insert_id()."
   \n Сервер будет доступен через 3 минуты.
   \n Это письмо автоматическое и отвечать на него не нужно.
   \n Спасибо за пользование нашим сервисом! С уважением, администрация https://monitoring.contra.net.ua";
   send_mail($email, $mess);
  }
 }

 $countr = '';
 foreach($countries->countries as $country_code => $country_name) {
  $countr .= "<option value='{$country_code}'".(($country_code == $location) ? " selected='selected'" : "").">{$country_name}</option>";
 }

 $checked = ($steam == 1) ? " checked='checked'" : "";
 $captch = session_name()."=".session_id();

 $games = select_games();
 $modes = select_modes();

 echo <<<EOT
  {$message}
  <div style='padding-top:7px'></div>
  <div class='horizontal_line'>
   <span style='color: #789ABF'>Перед тем как добавить сервер разместите нашу ссылку на своём сайте (скопировать и вставить):</span>
  </div>
  <form action='' method='POST'>
   <table width='100%' class='regform'>
    <tr>
     <td colspan='2' align="center">
       <input size='65' onclick='this.select()' readonly='' value="<a href='https://contra.net.ua/' target='_blank'>Игровые сервера cs 1.6 Украина</a>" />
     </td>
    </tr>
    <tr>
     <td align='right'><b><span style="color: red;">*</span>Адрес сервера:</b></td>
     <td><input type='text' name='server_address' value='{$address}' size='30' /></td>
    </tr>
    <tr>
     <td align='right'>Игра сервера:</td>
     <td>
      <select style='width:200px;' name='server_game' value='{$game}'>
       {$games}
      </select>
     </td>
    </tr>
    <tr>
     <td align='right'>Мод сервера:</td>
     <td>
      <select style='width:200px;' name='server_mode' value='{$mode}'>
       {$modes}
      </select>
     </td>
    </tr>
    <tr>
     <td align='right'>
      <b>
       <span style="color: red;">*</span>Адрес нашей ссылки на Вашем сайте:
      </b>
     </td>
     <td>
      <input type='text' name='server_site' value='{$site}' size='30' />
     </td>
    </tr>
    <tr>
     <td align='right'>
      <b>
       <span style="color: red;">*</span>E-mail Админа:
      </b>
     </td>
     <td>
      <input type='text' name='server_email' value='{$email}' size='30' />
     </td>
    </tr>
    <tr>
     <td align='right'>ICQ Админа:</td>
     <td>
      <input type='text' name='server_icq' value='{$icq}' size='30' />
     </td>
    </tr>
    <tr>
     <td align='right'>
      <b><span style="color: red;">*</span>Описание сервера:</b>
     </td>
     <td>
      <textarea name='server_about' rows='2' cols='30'>{$about}</textarea>
     </td>
    </tr>
    <tr>
     <td align='right'>Локация сервера:</td>
     <td>
      <select style='width:200px;' name='server_location'>
       {$countr}
      </select>
     </td>
    </tr>
    <tr>
     <td align='right' style='height:30px;'>Сервер STEAM?</td>
     <td style='height:30px;'>
      <input type='checkbox' style='background:#FFF;' name='server_steam' value='1' class='checkbox' {$checked}>
     </td>
    </tr>
    <tr>
     <td align='right'>
      <b><span style="color: red;">*</span>Код безопасности:</b>
     </td>
     <td>
      <img src='/include/cap/index.php?{$captch}'>
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
      <input type='hidden' name='submit_registration' value='1'>
      <input type='submit' value='Добавить сервер!' />
      <div style='padding-top:15px;'>
       <div align='center' style='font-size:12px;color:#CCC;font-weight:bold;padding:10px;'>
        Посетите сайт игровых серверов <a href='http://contra.net.ua' target='_blank'>contra.net.ua</a>
       </div>
      </div>
     </td>
    </tr>
   </table>
  </form>
EOT;
  unset($_SESSION['captcha_keystring']);
 }

if (isset($_POST['step']) && $_POST['step'] == "2") {
 $error = "";
 $gametype = stripinput($_POST['server_game']);
 $server_ip = stripinput($_POST['server_ip']);
 $server_port = stripinput($_POST['server_port']);
 $email=stripinput($_POST['email']);
 $icq=stripinput($_POST['icq']);
 $www=stripinput($_POST['www']);
 $result="SELECT * FROM ".DB_SERVERS." WHERE server_ip = '".$server_ip.":".$server_port."'";
 $dbresult=db()->query($result);
 $n=db()->num_rows($dbresult);

 if ($n) {
  $error .=$locale['reg021']."<br><br>\n";
 }
}
