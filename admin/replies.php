<?php
/*
 * Reply operations
 * Made by starky
*/

/* Script security */
if (!defined("MONENGINE")) {
 header("Location: index.php");
 exit();
}

/* Other code */
$get_replies = db()->query("SELECT * FROM `".DB_COMMENTS."` WHERE `type` = '0' ORDER BY `id` ASC");
$replies_num = db()->num_rows($get_replies);

$replies = '';
if ($replies_num == 0) {
 $replies .= "
     <div class='row'>
      Нет непромодерированных отзывов.
     </div>
 ";
} else {
 $replies .= "
     <table cellspacing='0' cellpadding='0' width='100%'>
      <thead>
       <tr>
        <th>Текст комментария</th>
        <th>Подтвердить</th>
       </tr>
      </thead>
      <tbody>
 ";

 while($reply = db()->fetch_array($get_replies)) {
  $replies .= "
       <tr id='reply_{$reply['id']}'>
        <td>{$reply['text']}</td>
        <td>
         <button type='button' class='green' onClick=\"approveReply('{$reply['id']}', '1');\"><span>Позитивный</span></button>
         <button type='button' class='red' onClick=\"approveReply('{$reply['id']}', '2');\"><span>Негативный</span></button>
        </td>
       </tr>
  ";
 }

 $replies .= "
      </tbody>
     </table>
 ";
}

echo <<<EOT
"<div id='right'>
  <div class='section'>
   <div class='box'>
    <div class='title'>Неподтверждённые отзывы (<span id='not_approved'>$replies_num</span>)<span class='hide'></span></div>
    <div class='content'>
     {$replies}
    </div>
   </div>
  </div>
 </div>"
EOT;
