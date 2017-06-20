<?php
$comms = '';
$comments = db()->query("SELECT * FROM `" . DB_COMMENTS . "` ORDER BY `id` DESC LIMIT 5");

if (db()->num_rows($comments) != 0) {
    while ($comment = db()->fetch_array($comments)) {
        $comms .= "
     <li class='comment' id='comment_{$comment['id']}'>
      <div class='hover'>
       <a href='javascript://' onClick='setReplyId({$comment['id']});' class='modalopen'>
       </a>
      </div>
      <a href='../server/{$comment['server_id']}'>
       <b>{$comment['username']}</b>
      </a>написал:<br />
      {$comment['text']}
     </li>
  ";
    }
} else {
    $comms = '<li class="comment"><center>Список отзывов пуст.</center></li>';
}

$servers_list_l = db()->query("SELECT * FROM `" . DB_SERVERS . "` ORDER BY `server_id` DESC LIMIT 5");
$servers_new = '';

$i = 0;
while ($server_l = db()->fetch_array($servers_list_l)) {
    if ($server_l['server_off'] == 1) {
        $status = "<font color='gray'>Забанен</font>";
    } elseif ($server_l['server_new'] == 1) {
        $status = "<font color='gray'><b>Не активирован</b></font>";
    } elseif ($server_l['server_status'] == 1) {
        $status = "<font color='green'>Онлайн</font>";
    } elseif ($server_l['server_status'] == 0) {
        $status = "<font color='red'>Оффлайн</font>";
    }
    $servers_new .= "
      <tr>
       <td>
        <a href='server/{$server_l['server_id']}'>{$servers[$server_l['server_id']]['info']['serverName']}</a>
       </td>
       <td>{$status}</td>
      </tr>
 ";
    $i++;
}

$servers_list = db()->query("SELECT * FROM `" . DB_SERVERS . "`");

$servers = '';

while ($server = db()->fetch_array($servers_list)) {
    if ($server['server_off'] == 1) {
        $status = "<font color='gray'>Забанен</font>";
    } elseif ($server['server_new'] == 1) {
        $status = "<font color='gray'><b>Не активирован</b></font>";
    } elseif ($server['server_status'] == 1) {
        $status = "<font color='green'>Онлайн</font>";
    } elseif ($server['server_status'] == 0) {
        $status = "<font color='red'>Оффлайн</font>";
    }

    $servers .= "
     <tr>
      <td>
       <a href='server/{$server['server_id']}'>{$servers[$server_l['server_id']]['info']['serverName']}</a>
      </td>
      <td>{$servers[$server_l['server_id']]['info']['playersNumber']} / {$servers[$server_l['server_id']]['info']['maxPlayers']}</td>
      <td>{$servers[$server_l['server_id']]['info']['mapName']}</td>
      <td>{$server['votes']}</td>
      <td>{$status}</td>
     </tr>
 ";
}

echo <<<EOT

<div id="right">
 <div class="section">
  <div class="half">
   <div class="box">
    <div class="title">Последние отзывы<span class="hide"></span>
    </div>
    <div class="content">
     <ul class="comments">
      {$comms}
     </ul>
     <div class="modal" style="height:100px !important; text-align:center !important;" title="Подтверждение действия">
       <p>Вы уверены что хотите удалить комментарий?</p>
       <button type="submit" onClick="delReply();" class="medium red"><span>Удалить</span></button>
       <button type="submit" onClick="dialogClose('.modal');" class="medium grey"><span>Отмена</span></button>
     </div>
    </div>
   </div>
  </div>
  <div class="half">
   <div class="box">
    <div class="title">Последние добавленные сервера<span class="hide"></span>
    </div>
    <div class="content">
     <table cellspacing="0" cellpadding="0">
      <thead>
       <tr>
        <th>Название</th>
        <th>Статус</th>
       </tr>
      </thead>
      <tbody>
       {$servers_new}
      </tbody>
     </table>
    </div>
   </div>
  </div>
 </div>
 <div class="section">
  <div class="box">
   <div class="title">Список серверов<span class="hide"></span>
   </div>
   <div class="content">
    <table cellspacing="0" cellpadding="0" border="0" class="all">
     <thead>
      <tr>
       <th>Название</th>
       <th>Онлайн</th>
       <th>Карта</th>
       <th>Рейтинг</th>
       <th>Статус</th>
      </tr>
     </thead>
     <tbody>
      {$servers}
     </tbody>
    </table>
   </div>
  </div>
 </div>
</div>
EOT;
