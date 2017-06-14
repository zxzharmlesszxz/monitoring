<?php

/* Script security */
if (!defined("MONENGINE")) {
    header("Location: index.php");
    exit();
}

$header_text = "Доброго времени суток.
    Ваш сервер %s(%s), id=%s , зарегистрирован %s, находится в нашем мониторинге https://www.monitoring.contra.net.ua.
    Для улучшения Ваших позиций в рейтинге, предлагаем голосовать раз в сутки
     для поднятия Вашего сервера на главной странице нашего мониторинга, чем выше сервер, тем больше человек посещает Ваш сервер.";
$footer_text = 'С уважением администрация мониторинга https://www.monitoring.contra.net.ua';

$str = '';
$servers = db()->query("SELECT * FROM `" . DB_SERVERS . "` WHERE `server_email` != '';");

while ($server = db()->fetch_array($servers)) {
        $message = sprintf($header_text, $server['server_name'], $server['server_ip'], $server['server_id'], date("d.m.Y", $server['server_regdata']));
        //send_mail($server['server_email'], "{$message}\n\n{$_POST['message']}\n\n{$footer_text}");
        $str .= "<option value='{$server['server_email']}'>{$server['server_id']}-{$server['server_ip']}({$server['server_name']})</option>";
}


if (isset($_POST['submit'])) {
}

/* Other code */
echo <<<EOT
 <div id='right'>
  <div class='section'>
   <div class='box'>
    <div class='title'>Рассылка почты<span class='hide'></span></div>
    <div class='content'>
     <form action='' method='POST'>
      <div class='row'>
       <label>Сервер <span color='red'>*</span></label>
       <div class='right'>
        <select name="server" style="width: 70%;">
         {$str}
        </select>
       </div>
      </div>
      <div class='row'>
       <label>Сообщение <span color='red'>*</span></label>
       <div class='right'>
       <div>{$header_text}</div>
        <textarea name='message'></textarea>
       </div>
       <div>{$footer_text}</div>
      </div>
      <div class='row'>
       <div class='right'>
        <button type='submit' name='submit' class='blue'><span>Отправить</span></button>
        <button type='button' onClick='window.location.href='index.php'><span>Отмена</span></button>
       </div>
      </div>
     </form>
    </div>
   </div>
  </div>
 </div>
EOT;
