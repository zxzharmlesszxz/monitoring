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
require_once LOCALE . LOCALESET . "serv.php";


$site_link = SITE_URL;
$server_id = db()->escape_value($_GET['id']);
//$take_server = db()->query("SELECT * FROM " . DB_SERVERS . " WHERE server_id = " . db()->escape_value($server_id) . ";");
//$server_data = db()->fetch_array($take_server);

$redis = new Redis();
$redis->connect($settings['redis_host']);
$redis->auth($settings['redis_password']);
$redis->select(1);
$data = unserialize($redis->hGet('servers', $server_id));
$info = $data['info'];
$players = $data['players'];
$rules = $data['rules'];
$server_data = $data['dbInfo'];
var_dump($data);
if (db()->num_rows($take_server) == 0) {
    displayMessage('Выбранный сервер не существует, либо был удалён.', 'error');
} elseif ($server_data['server_off'] == 1) {
    include("banned.php");
} else {
    $site = ($server_data['server_site'] != "") ? "
  <div class='block_line' style='margin-bottom:0;'>
   <div class='block site'>
    <div class='t'>Сайт сервера:</div>
     <small>
      <a href='//{$server_data['server_site']}' target='_blank'>{$server_data['server_site']}</a>
     </small>
    </div>
   </div>" : "";

    $icq = (!empty($server_data['server_icq'])) ? "ICQ Администратора <b>ICQ#{$server_data['server_icq']} <img src='//status.icq.com/online.gif?icq={$server_data['server_icq']}&img=26'>" : "";
    $status = ($server_data['server_status'] == 1) ? "<span style='color: #6e8d4c'><b>Online</b></span>" : "<span style='color:#B53333'><b>Offline</b></span>";
    $work = (($server_data['server_status'] == 1) ? "Работает" : "Не работает") . " с <b>" . @date("d.m.Y H:i", $server_data['status_change']) . "</b>";
    $regdate = @date("d.m.Y H:i", $server_data['server_regdata']);
    $last_update = $settings['last_update'];
    $time_diff = time() - $last_update;
    $time_lasted = ($time_diff >= 60) ? floor($time_diff / 60) . " минут" : $time_diff . " секунд";
    $percent_loaded = @floor(($server_data['server_players'] / $server_data['server_maxplayers']) * 100);
    $vote_hash = md5("m0n3ng1ne.s4lt:P{]we{$server_data['server_id']}@._)%;");

    switch ($percent_loaded) {
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

    $about = !empty($server_data['about']) ? "
  <div class='box_rounded'>
   <div style='font-size: 10px;'>
    <div style='padding-bottom:3px;'>
     <div class='box_title'>Пару слов о сервере:</div>
     <span style='color:#999999;'>{$server_data['about']}</span>
    </div>
   </div>
  </div>" : "";

    $com_error = '';
    $errors = Array();

    $com_name = '';
    $com_text = '';

    if (count($_POST) > 0) {
        if (empty($_POST['com_name'])) {
            $errors[] = 'Вы не ввели своё имя.';
        } elseif (strlen($_POST['com_name']) < 2 or strlen($_POST['com_name']) > 12) {
            $errors[] = 'Длина имени должна составлять от 2-х до 12-ти символов.';
        } else {
            $com_name = $_POST['com_name'];
        }

        if (empty($_POST['com_text'])) {
            $errors[] = 'Вы не ввели текст комментария.';
        } elseif (strlen($_POST['com_text'] > 300)) {
            $errors[] = 'Максимальная длина комментария 300 символов.';
        } else {
            $com_text = $_POST['com_text'];
        }

        if (!isset($_SESSION['captcha_keystring']) or $_SESSION['captcha_keystring'] != $_POST['com_captcha']) {
            $errors[] = 'Вы неверно ввели текст с картинки.';
        }

        if (count($errors) != 0) {
            $com_error = "<div style='font-size: 13px;color:white;padding: 5px;margin-bottom:7px;border: 1px solid#BC2E2E;background:#522828;text-align: left;'>" . $errors[0] . "</div>";
        } else {
            $server_id = db()->escape_value($server_id);
            $com_name = db()->escape_value(htmlspecialchars($com_name));
            $com_text = db()->escape_value(htmlspecialchars($com_text));
            $result = db()->query("INSERT INTO " . DB_COMMENTS . " (server_id, username, text, date) VALUES ('$server_id', '$com_name', '$com_text', '" . time() . "')");
            $message = "<div style='font-size: 13px;color:white;padding: 5px;margin-bottom:7px;border: 1px solid#108014;background:#3A4337;text-align: left;'>Спасибо! Ваш комментарий будет добавлен после модерации.</div>";
        }
    }

    unset($_SESSION['captcha_keystring']);
    $get_comments = db()->query("SELECT * FROM " . DB_COMMENTS . " WHERE server_id='$server_id' and type!='0'");

    if (db()->num_rows($get_comments) != 0) {
        $comms = '';
        while ($comments = db()->fetch_array($get_comments)) {
            $comms .= "<div class='comment'>
           <div class='comment_text'>Комментарий от:<span class='name'>{$comments['username']}</span><br />{$comments['text']}</div>
           <p class='posttime'>Дата добавления: " . @date("d.m.Y H:i", $comments['date']) . "</p>
           <p class='" . (($comments['type'] == 1) ? "positive" : "negative") . "_post'>" . (($comments['type'] == 1) ? "Позитивный" : "Негативный") . " отзыв</p>
           <div class='clearfix'></div>
          </div>";
        }
    } else {
        $comms = "<div class='comment'>
           <div class='comment_text'>Этот сервер пока что не имеет комментариев. Может вы хотели бы добавить свой?</div>
          </div>";
    }

    $mess = ((!empty($message)) ? "$message" : "") . ((!empty($com_error)) ? "$com_error" : '');
    $captch = session_name() . "=" . session_id();

    echo <<<EOT
   <div class='horizontal_line'>Сервер: <b>{$server_data['server_name']}</b></div>
    <div class='cont'>
     <table cellspacing='0' cellpadding='0' width='100%' class='info_tbl'>
      <tr>
       <td valign='top' width='250' style='padding-bottom:20px;'>
        <div style='padding: 5px;margin: 4px;line-height: 12px;background: #1E1E1E;border: 1px solid #444;'>
          <img src='/images/maps/monitor.php?game={$server_data['server_game']}&map={$server_data['server_map']}' style='opacity:0.8;'>
        </div>
        <div class='block_line'>
         <div class='block load_bar'>
          <div class='t'>Загруженность сервера</div>
          <div class='block_line load_{$load_color}'>{$percent_loaded}%</div>
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
           <span class='votes_count' id='votes_count_{$server_data['server_id']}' >{$server_data['votes']}</span>
           <span class='vote_buttons' id='vote_buttons_{$server_data['server_id']}'>
            <a href='javascript://' onClick="rating({$server_data['server_id']}, 'up', '{$vote_hash}');" class='voteup' id='{$server_data['server_id']}'></a>
            <a href='javascript://' onClick="rating({$server_data['server_id']}, 'down', '{$vote_hash}');" class='votedown' id='{$server_data['server_id']}'></a>
           </span>
          </div>
         </div>
        </div>
        {$site}
      </td>
      <td valign='top' style='padding-top: 5px;'>
       <div style='padding:10px;background-color: #1E1E1E;border:1px solid #444444'>
        <b>Горизонтальный банер-мониторинг:</b>
        <div style='padding-top:4px;'></div>
        <img src='/banner/?serv={$server_data['server_ip']}'>
        <div style='padding-top:8px;'></div>
        HTML-код:
        <br>
        <textarea rows='3' cols='76'><a href='{$site_link}server/{$server_data['server_id']}'><img src='{$site_link}banner/?serv={$server_data['server_ip']}'></a></textarea>
        <br>
        BB-код:
        <br>
        <textarea rows='3' cols='76'>[url={$site_link}server/{$server_data['server_id']}][img]{$site_link}banner/?serv={$server_data['server_ip']}[/img][/url]</textarea>
       </div>
       <div style='margin-bottom:5px;'></div>
       <div class='box_rounded'>
        <div style='font-size: 15px;color:#EEEEEE;padding-bottom:5px;'>Оставить комментарий к серверу:</div>
        <form method='POST' class='comments'>
         {$mess}
         <div style='padding-bottom:5px;'>Ваш ник: <input type='text' name='com_name' value='{$com_name}'></div>
         <div style='padding-bottom:3px;'>
          <textarea name='com_text' style='width:98%;height: 75px;'>{$com_text}</textarea>
         </div>
         <div class='clearfix'></div>
         <div style='padding-top:4px;'></div>
         <div style='padding-bottom:5px;opacity:0.7;'>
          <img src='/include/cap/index.php?{$captch}'>
         </div>
         <div style='float:right;padding-bottom:10px;'>
          <input type='submit' class='button' value='Добавить комментарий'>
         </div>
         <div>
          <input type='text' name='com_captcha' style='width:148px;'>
         </div>
        </form>
        <div style='margin-bottom:5px;'></div>
        <div class='box_rounded'>
         <div style='font-size: 15px;'>Комментарии к серверу {$server_data['server_name']}</div>
         <div class='server_comments'>
          {$comms}
         </div>
        </div>
       </div>
      </td>
      <td valign='top' width='300' style='padding:4px;padding-top:5px;'>
       <div class='box_rounded'>
        <div class='box_title'>Доп. информация:</div>
        id сервера: <b>{$server_data['server_id']}</b> (/server/{$server_data['server_id']})
        <br />
        Статус сервера: {$status}
        <br />
        {$icq}
        <br />
        Дата регистрации: <b>{$regdate}</b>
        <br />
        {$work}
        <br />
        Информация о сервере загружена <b>$time_lasted</b> назад
       </div>
       <div style='margin-bottom:4px;'></div>
       <div class='box_rounded'>
        <div style='padding-bottom:3px;'>
         <div class='box_title'>Большой HTML-мониторинг:</div>
        </div>
         <iframe style='border: 1px solid #7D7D7D;' src='https://monitoring.contra.net.ua/byweb?id={$server_data['server_id']}' frameborder='1' width='190' height='400' scrolling='no'>
         </iframe>
         <br>
         <textarea rows='6' cols='24'><iframe src='https://monitoring.contra.net.ua/byweb?id={$server_data['server_id']}' frameborder='1' width='190' height='400' scrolling='no'></iframe></textarea>
       </div>
       {$about}
      </td>
     </tr>
    </table>
   </div>
EOT;
}
