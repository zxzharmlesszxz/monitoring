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

echo <<<EOT
<div class='horizontal_line'>Заказать «Премиум место»</div>
<div class='cont'>
 <div class="msg greenbg">Приобрести данное место Вы можете <b>бесплатно</b>. Для заказа места обратитесь в Skype: <b>vengeanson</b></div>
  <table width="100%" height="150">
   <tr>
    <td align="center" style="font-size:16px;">
     <a href="/">Вернуться на главную страницу</a>
    </td>
   </tr>
  </table>
</div>
EOT;
