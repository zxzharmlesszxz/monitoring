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
<div class='horizontal_line'>Беслатные услуги для серверов</div>
<div class='cont-pay'>
 <div style="padding:10px;background:#232323;line-height:200%;">
  <img src="/images/img/paid-services.png" style="float:left;width:237px;height:151px;padding-right:30px;padding-top:20px;opacity:0.7;" alt="Бесплатные услуги" />
  <style>.para_vip td {padding-left: 10px; height: 30px;}</style>
  <table cellpadding="0" cellspacing="0" class="para_vip" >
   <tr>
    <td valign="middle"><img src="/images/img/para-vip.gif" width="9" height="13" /></td>
    <td valign="middle">Верхние "VIP" места рейтинга серверов и "Премиум" сервера находящиеся в шапке мониторинга можно заказать.</td>
   </tr>
   <tr>
    <td valign="middle"><img src="/images/img/para-vip.gif" width="9" height="13" /></td>
    <td valign="middle">VIP сервера выделяются знаком VIP, и сортируются по дате заказа.</td>
   </tr>
   <tr>
    <td valign="middle"><img src="/images/img/para-vip.gif" width="9" height="13" /></td>
    <td valign="middle">VIP сервера видны в мониторинге и сверху нашего форума.</td>
   </tr>
   <tr>
    <td valign="middle"><img src="/images/img/para-vip.gif" width="9" height="13" /></td>
    <td valign="middle">Заказ осуществляется через Skype: vengeanson</td>
   </tr>
   <tr>
    <tr>
    <td valign="middle"><img src="/images/img/para-vip.gif" width="9" height="16" /></td>
    <td valign="middle">TOP видны сверху мониторинга и на нашем портале.
    </td>
   </tr>
   <tr>
    <td valign="middle"><img src="/images/img/para-vip.gif" width="9" height="16" /></td>
    <td valign="middle">У серверов имеющих Выделение цветом будет подсвечено название.
    </td>
   </tr>
  </table>
  <div style="clear:both;"></div>
 </div>
 <div style="padding:10px;border-top:1px solid #4F4F4F;">
  <span style="font-size:17px;">Серверам использующим наши услуги <b>запрещено:</b></span>
  <br />
  <div style="padding-top:10px;padding-left:20px;color:#EEE;">
   <ul>
    <li>Устанавливать плагины для ридиректа игроков на другие НЕ VIP сервера.</li>
    <li>Изменять игрокам какие либо клиентские файлы игры.</li>
    <li>Не рекомендуется ломать игрокам клиент игры, по возможности используйте бан по IP или подсети.</li>
    <li>Изменять игрокам конфиги игры.</li>
    <li>Вписывать игрокам в меню клиента игры или конфиг рекламу серверов.</li>
    <li>Автоматически, через Motd окна, устанавливать игрокам .exe приложения.</li>
    <li>Накручивать рейтинги в нашем мониторинге, при попытках сервер буден удален и забанен!</li>
   </ul>
  </div>
 </div>
 <div style="padding-top:5px;padding-left:10px;font-size:10px;">В случае не соблюдения данных правил - Администрация в праве онулировать услугу для сервера.</div>
 <div style="padding-top:10px;padding-left:10px;font-size:10px;">Все услуги устанавливаются в течении 3 минут.</div>
</div>
  </div>
 </div>
</div>
<center>
<div style="background:#232323;">
<div>
<script async src="http://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<!-- Сервера CS 1.6 -->
<ins class="adsbygoogle"
     style="display:inline-block;width:728px;height:90px"
     data-ad-client="ca-pub-0760255674877926"
     data-ad-slot="2271973623"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script>
</div>
</div>
</center>
<div style='padding:10px;background:#232323;line-height:17px;border-top:1px solid #4F4F4F;'>
 <div class='listingtop'><font size='4px'>Листинг премиум серверов</font>
  <ol>
EOT;

for ($itop = 1; $itop < 5 * LINES_NUM + 1; $itop++) {
    $rtop = db()->fetch_array(db()->query("SELECT * FROM `mon_servers` WHERE server_top=$itop"));
    if ($rtop['server_top']) {
        echo "<li><font size='2px'>Место занято сервером <a href='/server/{$rtop['server_id']}/'>{$servers[$rtop['server_id']]['info']['serverName']}</a>. Освободится через " . time2string($rtop['server_top_time'] - time(), true, false, false, false) . " (" . formatDate("d.m.Y H:i:s", $rtop['server_top_time']) . ")</li>";
    } else {
        echo "<li><font size='2px'>Место свободно!</li></font></font>";
    }
}

echo "</ol>
</div>
<div style='padding:5px;border-top:1px solid #4F4F4F;'></div>
<div class='listingvip'>
 <font size='4px'>Листинг VIP серверов:</font>
 <ol>";

$qvip = db()->query("SELECT * FROM `mon_servers` WHERE server_vip=1");

if (db()->num_rows($qvip) == 1) {
    echo "<font size='2px'><li>Все места свободны</li></font>";
}

while ($rvip = db()->fetch_array($qvip)) {
    echo "<font size='2px'><li>Место занято сервером <a href='/server/{$rvip['server_id']}/'>{$servers[$rvip['server_id']]['info']['serverName']}</a>. Освободится через " . time2string($rvip['server_vip_time'] - time(), true, false, false, false) . " (" . formatDate("d.m.Y H:i:s", $rvip['server_vip_time']) . ")</li>";
}

echo "
 </ol>
</font>
</div>
<div style='padding:5px;'></div>
<div class='listingcolor'><font size='4px'>Листинг серверов с цветом:</font>
 <ol>";

$qcolor = db()->query("SELECT * FROM `mon_servers` WHERE server_row_style RLIKE '_'");

if (db()->num_rows($qcolor) == 1) {
    echo "<li>Все места свободны</li>";
}

while ($rcolor = db()->fetch_array($qcolor)) {
    echo "<li>Место занято сервером <a href='/server/{$rcolor['server_id']}/'>{$servers[$rcolor['server_id']]['info']['serverName']}</a>. Освободится через " . time2string($rcolor['server_color_time'] - time(), true, false, false, false) . " (" . formatDate("d.m.Y H:i:s", $rcolor['server_color_time']) . ")</li>";
}

echo "</ol>
</div>";
