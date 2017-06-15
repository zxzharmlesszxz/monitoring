<?php

/* Script security */
if (!defined("MONENGINE")) {
    header("Location: index.php");
    exit();
}

$str = '';
$servers = db()->query("SELECT * FROM `" . DB_SERVERS . "` WHERE `server_email` != '';");

while ($server = db()->fetch_array($servers)) {
        $str .= "<option value='{$server['server_id']}'>{$server['server_id']}-{$server['server_ip']}({$server['server_name']})</option>";
}

if (isset($_POST['submit']) && isset($_POST['server'])) {
        $server = db()->fetch_array(db()->query("SELECT * FROM `" . DB_SERVERS . "` WHERE `server_id` = '" . intval($_POST['server']) . "';"));
        $message = sprintf($settings['mail_header'], $server['server_name'], $server['server_ip'], $server['server_id'], date("d.m.Y", $server['server_regdata']));
        send_mail($server['server_email'], "{$message}\n\n{$_POST['message']}\n\n{$settings['mail_footer']}");
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
         <option value="" selected disabled>Select</option>
         {$str}
        </select>
       </div>
      </div>
      <div class='row'>
       <label>Сообщение <span color='red'>*</span></label>
       <div class='right'>
        <div>{$settings['mail_header']}</div>
        <textarea name='message'></textarea>
        <div>{$settings['mail_footer']}</div>
       </div>
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
