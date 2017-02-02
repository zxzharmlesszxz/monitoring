<?php
/*
 * Server registration script
 * Made by starky
*/

$take_server = dbquery("SELECT * FROM ".DB_SERVERS." WHERE server_id = ".$_GET['id']."");
$server_data = dbarray_fetch($take_server);

/* Other code */
echo <<<EOT
<div class='horizontal_line'>Cервер заблокирован</div>
<div class='cont'>
 <div class='msg redbg'>Сервер <b>{$server_data['server_name']}</b> заблокирован. Для выяснения причины Skype: monservers или Icq: 162-622</div>
 <table width='100%' height='150'>
  <tr>
   <td valign='middle'>
   </td>
   <td align='center' style='font-size:16px;'>
    <a href='/'>Вернуться на главную страницу</a>
   </td>
  </tr>
 </table>
</div>
EOT;
