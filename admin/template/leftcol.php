<?php
  
$comments_num = db()->query("SELECT id FROM `".DB_COMMENTS."`");
$comments_num = db()->num_rows($comments_num);
$last_update = @date("d.m H:i", $settings['last_update']);
$servers_total = $settings['servers_total'];
$servers_online = $settings['servers_online'];

echo <<<EOT
  <div id="left">
   <div class="box statics">
    <div class="content">
     <ul>
      <li>
       <h2>Статистика</h2>
      </li>
      <li>Отзывов <div class="info blue"><span>{$comments_num}</span></div></li>
      <li>Серверов всего/online<div class="info black"><span>{$servers_total}</span></div>/<div class="info green"><span>{$servers_online}</span></div></li>
      <li>Обновление <div class="info black"><span>{$last_update}</span></div></li>
     </ul>
    </div>
   </div>
  </div>
EOT;
