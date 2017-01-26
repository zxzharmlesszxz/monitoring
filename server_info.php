<?php

/*
 * Server info display script
 * Made by starky
*/

/* Script security */
if(!defined("MONENGINE")) {
 header("Location: index.php");
 exit();
}

/* Other code */
require_once LOCALE.LOCALESET."serv.php";

$server_id = $_GET['id'];
$take_server = dbquery("SELECT * FROM ".DB_SERVERS." WHERE server_id = ".mysql_real_escape_string($server_id)."");
$server_data = dbarray_fetch($take_server);

if (mysql_num_rows($take_server) == 0) {
 displayMessage('Выбранный сервер не существует, либо был удалён.', 'error');
} else if ($server_data['server_off'] == 1) {
 include("banned.php");
} else {
 $site = "";  

 if ($server_data['server_site'] !="") {
  $site = "<a href='//".$server_data['server_site']."' target='_blank'>".$server_data['server_site']." </a>";
 }

 $icq = "";

 if ($server_data['server_icq'] !="") {
  $icq = $server_data['server_icq']." <img src='//status.icq.com/online.gif?icq=".$server_data['server_icq']."&img=26'>";
 }

 $status="<font color='#B53333'><b>Offline</b></font>";

 if ($server_data['server_status'] == 1) $status = "<font color='#6e8d4c'><b>Online</b></font>";

 $last_update = $settings['last_update'];
 $time_diff = time() - $last_update;
  
 if($time_diff >= 60) {
  $time_lasted = floor($time_diff / 60)." минут";
 } else {
  $time_lasted = $time_diff." секунд";
 }

 echo "<div class='horizontal_line'>Сервер: <b>{$server_data['server_name']}</b></div><div class='cont'>";

 // Start of server page
 echo "<table cellspacing='0' cellpadding='0' width='100%' class='info_tbl'>";

 // Left col (info)
 echo "<td valign='top' width='250' style='padding-bottom:20px;'>";

 $percent_loaded = floor(($server_data['server_players'] / $server_data['server_maxplayers']) * 100);
  
 switch($percent_loaded) {
  case ($percent_loaded <= 40):
   $load_color = 'green';
   break;
  case ($percent_loaded <= 80):
   $load_color = 'yellow';
   break;
  case ($percent_loaded <= 100):
   $load_color = 'red';
   break;
  default:
   $load_color = 'green';
   break;
 }
 echo "<div style='padding: 5px;margin: 4px;line-height: 12px;background: #1E1E1E;border: 1px solid #444;'>";
 echo "<div style='padding-top:10px;'></div><center><img src='/images/maps/cs16/{$server_data['server_map']}.jpg' style='width:231px;height:174px;border:1px solid #7F7F7F;opacity:0.8;'></center><br>";
 echo "
      <div>
      
      </div>
      <div style='text-align:center;padding-right:50px;'>
        <table align='center' cellpadding='0' cellspacing='0' width='236' height='30'>
          <tr>
            <td class='load_bar load_$load_color' width='".(($percent_loaded == 0) ? "1" : "$percent_loaded")."%' valign='middle'>
              <div style='position:absolute;'>
                <nobr>Загруженность сервера $percent_loaded%</nobr>
              </div>&nbsp;
            </td>
            <td>&nbsp;</td>
          </tr>
        </table>
      </div>
      </div>
      <div class='block_line'>
        <div class='block address'>
          <div class='t'>Адрес сервера:</div>
          <div class='block_line_small'>{$server_data['server_ip']}</div>
        </div>
      </div>    

      <div class='block_line'>
        <div class='block mode'>
          <div class='t'>Мод сервера:</div>
          <div class='block_line_small'>{$server_data['server_mode']}</div>
        </div>
      </div>      

      <div class='block_line'>
        <div class='block map'>
          <div class='t'>Текущая карта:</div>
          <div class='block_line_small'>{$server_data['server_map']}</div>
        </div>
      </div>
      

      <div class='block_line'>
        <div class='block players'>
          <div class='t'>Игроки:</div>
          <div class='block_line_small'>{$server_data['server_players']}/{$server_data['server_maxplayers']}</div>
        </div>
      </div>

      <div class='block_line'>
        <div class='block votes'>
          <div class='t'>Голосов за сервер:</div>
          <div class='block_line_small'>
            <span class='votes_count' id='votes_count_{$server_data['server_id']}' >".$server_data['votes']."</span>
            <span class='vote_buttons' id='vote_buttons_{$server_data['server_id']}'>
            <a href='javascript://' onClick=\"rating({$server_data['server_id']}, 'up', '".md5("m0n3ng1ne.s4lt:P{]we{$server_data['server_id']}@._)%;")."');\" class='voteup' id='{$server_data['server_id']}'></a>
            <a href='javascript://' onClick=\"rating({$server_data['server_id']}, 'down', '".md5("m0n3ng1ne.s4lt:P{]we{$server_data['server_id']}@._)%;")."');\" class='votedown' id='{$server_data['server_id']}'></a>
            </span>
          </div>
        </div>
      </div>
      ";
  if(!empty($site)) {
    echo "
      <div class='block_line' style='margin-bottom:0;'>
        <div class='block site'>
          <div class='t'>Сайт сервера:</div>
          <small>".$server_data['server_site']."</small>
        </div>
      </div>
      ";
  }
 echo "</td>";
 echo "<td valign='top' style='padding-top: 5px;'><div style='padding:10px;background-color: #1E1E1E;border:1px solid #444444'>";

  echo "
  <b>Горизонтальный банер-мониторинг:</b>
    <div style='padding-top:4px;'></div>
  <img src='/banner/userbar.png?serv={$server_data['server_ip']}'>
  <div style='padding-top:8px;'></div>
  HTML-код:<br>
  <textarea rows='3' cols='76'><a href='/server/{$server_data['server_id']}'><img src='/banner/userbar.png?serv={$server_data['server_ip']}'></a></textarea></p>
  BB-код:<br>
  <textarea rows='3' cols='76'>[url=/server/{$server_data['server_id']}][img]/banner/userbar.png?serv={$server_data['server_ip']}[/img][/url]</textarea></p>";
          echo "</div>";
  
  echo "<div style='margin-bottom:5px;'></div>";
  
  // Center col /*(banners)*/ comments
echo "<div class='box_rounded'>";
  $com_error = '';
  $errors = Array();
  if(count($_POST)>0){
    $com_name = $_POST['com_name'];
    if(empty($com_name)) {
      $com_name = '';
      $errors[] = 'Вы не ввели своё имя.';
    } elseif(strlen($com_name) < 2 or strlen($com_name) > 12) {
      $com_name = '';
      $errors[] = 'Длина имени должна составлять от 2-х до 12-ти символов.';
    }
    
    $com_text = $_POST['com_text'];
    
    if(empty($com_text)) {
      $com_text = '';
      $errors[] = 'Вы не ввели текст комментария.';
    } elseif(strlen($com_text > 300)) {
      $com_text = '';
      $errors[] = 'Максимальная длина комментария 300 символов.';
    }
    
    if(!isset($_SESSION['captcha_keystring']) or $_SESSION['captcha_keystring'] != $_POST['com_captcha']){
      $errors[] = 'Вы неверно ввели текст с картинки.';
    }
    
    
    if(count($errors) != 0) {
      $com_error = "<div style='font-size: 13px;color:white;padding: 5px;margin-bottom:7px;border: 1px solid#BC2E2E;background:#522828;text-align: left;'>".$errors[0]."</div>";

      
    } else {
      $server_id = mysql_real_escape_string($server_id);
      $com_name = mysql_real_escape_string(htmlspecialchars($com_name));
      $com_text = mysql_real_escape_string(htmlspecialchars($com_text));
      $result = mysql_query("INSERT INTO ".DB_COMMENTS." (server_id, username, text, date) VALUES ('$server_id', '$com_name', '$com_text', '".time()."')");
        $message = "<div style='font-size: 13px;color:white;padding: 5px;margin-bottom:7px;border: 1px solid#108014;background:#3A4337;text-align: left;'>Спасибо! Ваш комментарий будет добавлен после модерации.</div>";
    }
  }


  echo "
  <div style='font-size: 15px;color:#EEEEEE;padding-bottom:5px;'>Оставить комментарий к серверу:</div>
  <form method='POST' class='comments'>"
.((!empty($message)) ? "$message" : "").((!empty($com_error)) ? "$com_error" : '')."
  <div style='padding-bottom:5px;'>Ваш ник: <input type='text' name='com_name'".((!empty($com_name)) ? " value='$com_name'" : '')."></div>
  <div style='padding-bottom:3px;'><textarea name='com_text' style='width:98%;height: 75px;'>".((!empty($com_text)) ? "$com_text" : '')."</textarea></div>

  <div class='clearfix'></div>

  <div style='padding-top:4px;'></div>
  <div style='padding-bottom:5px;opacity:0.7;'><img src='cap/index.php?".session_name()."=".session_id()."'></div>
          <div style='float:right;padding-bottom:10px;'><input type='submit' class='button' value='Добавить комментарий'></div>
  <div><input type='text' name='com_captcha' style='width:148px;'></div>
  </form>

  ";
  unset($_SESSION['captcha_keystring']);

  echo "</div>  <div style='margin-bottom:5px;'></div>";
  echo "<div class='box_rounded'>";
  echo "<div style='font-size: 15px;'>Комментарии к серверу ".$server_data['server_name']."</div>";
  $get_comments = mysql_query("SELECT * FROM ".DB_COMMENTS." WHERE server_id='$server_id' and type!='0'");
  echo "<div class='server_comments'>";
  if(mysql_num_rows($get_comments) != 0) {
    while($comments = mysql_fetch_assoc($get_comments)) {
      echo "
          <div class='comment'>
          <div class='comment_text'>
          Комментарий от:<span class='name'> {$comments['username']}</span><br> {$comments['text']}
          </div>
          <p class='posttime'>Дата добавления: ".@date("d.m.Y H:i", $comments['date'])."</p>
          <p class='".(($comments['type'] == 1) ? "positive" : "negative")."_post'>".(($comments['type'] == 1) ? "Позитивный" : "Негативный")." отзыв</p>
          <div class='clearfix'></div>
          </div>
        ";
    }
  } else {
    echo "<div class='comment'><div class='comment_text'>Этот сервер пока что не имеет комментариев. Может вы хотели бы добавить свой?</div></div>";
  }
  echo "</div>";
  echo "</td>";

 echo "<td valign='top' width='300' style='padding:4px;padding-top:5px;'>
 <div style='font-size: 12px;'>
    <div class='box_rounded'>
        <div class='box_title'>Доп. информация:</div>
        id сервера: <b>{$server_data['server_id']}</b> (/server/{$server_data['server_id']})<br />
        Статус сервера: $status<br />
        ".((!empty($icq)) ? "ICQ Администратора <b>ICQ#$icq</b><br />" : "")."
        Дата регистрации: <b>".@date("d.m.Y H:i", $server_data['server_regdata'])."</b><br />
        ".(($server_data['server_status'] == 1) ? "Работает" : "Не работает")." с <b>".@date("d.m.Y H:i", $server_data['status_change'])."</b><br />
        Информация о сервере загружена <b>$time_lasted</b> назад
        </div><div style='margin-bottom:4px;'></div></div>
      <div class='box_rounded'>
      <div style='padding-bottom:3px;'><div class='box_title'>Большой HTML-мониторинг:</div></div>
      <center><iframe style='border: 1px solid #7D7D7D;' src='https://monitoring.contra.net.ua/byweb.php?id={$server_data['server_id']}' frameborder='1' width='190' height='250' scrolling='no'></iframe><br><textarea rows='6' cols='24'><iframe src='https://monitoring.contra.net.ua/byweb.php?id={$server_data['server_id']}' frameborder='1' width='190' height='250' scrolling='no'></iframe></textarea></center>
      </div>
      </div><div style='margin-bottom:-11px;'></div>
      
      ".(!empty($server_data['about']) ? "
      <br><div class='box_rounded'>
      <div style='font-size: 10px;'><div style='padding-bottom:3px;'><div class='box_title'>Пару слов о сервере:</div></div></div></div>
      <span style='color:#999999;'>{$server_data['about']}</span>
      " : "")."
 ";
        
 echo "</div>";
 echo "</table>";
}
