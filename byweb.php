<?php
require_once('config.php');
mysql_connect($db_host,$db_user,$db_pass);
mysql_select_db($db_name);
mysql_query("SET NAMES UTF8");
 
echo '<html>
 <head>
  <link rel="stylesheet" type="text/css" href="/templates/css/style.css">
 </head>
 <body>
  <table>
   <tr>
    <td>';
if (isset($_GET["id"]) and $_GET["id"] >= 1) {
 if (mysql_num_rows(mysql_query("SELECT * FROM mon_servers WHERE server_id=" . $_GET["id"])) == 1) {
  $q = mysql_fetch_array(mysql_query("SELECT * FROM mon_servers WHERE server_id=" . $_GET["id"]));
  $img = '<img src="images/maps/no_map.gif" width="150" height="113" style="border:1px solid #898989;opacity:0.8;"/>';
  if (file_exists($_SERVER{'DOCUMENT_ROOT'}."/images/maps/".$q['server_game']."/".$q['server_map'].".jpg") && $q['server_status'] == 1) {
   $img = '<img src="images/maps/'.$q['server_game'].'/'.$q['server_map'].'.jpg" width="150" height="113" style="border:1px solid #898989;"/>';
  }
  echo '
  <div style="padding-top:0.1px;padding-left:6px;">
   <center>
    <div style="padding-bottom:1px;font-size:14px;">
     <strong>
      <a style="color:#aaa;" href="/server/'.$q["server_id"].'/" target="_blank">
       '.((strlen($q["server_name"]) >= 20)?mb_substr(htmlspecialchars($q["server_name"]), 0,20, 'UTF-8').'...':htmlspecialchars($q["server_name"])).'
      </a>
     </strong>
    </div>
    <a href="/server/'.$q["server_id"].'/" target="_blank">'.$img.'</a>
    <div style="padding:4px;color:#aaa;font-size:12px;">Карта: '.((strlen($q["server_map"]) >= 12) ? mb_substr($q["server_map"], 0,12, 'UTF-8').'...' : $q["server_map"]).'</div>
    <div style="padding:2px;color:#aaa;font-size:12px;">Игроки: '.$q["server_players"].' / '.$q["server_maxplayers"].'</div>
    <div style="padding:5px;color:#aaa;font-size:12px;">
     <b>'.$q["server_ip"].'</b>
    </div>
   </center>
   <center>
    <div style="padding:1px;color:#aaa;font-size:12">
     '.(($q['server_status']==1) ? '<span style="color:#51F505;"><b>Online</b></span>' : '<span style="color:#f00;"><b>Offline</b></span>').'
    </div>
   </center>
   <center>
    <div style="padding-bottom:5px; font-size:12px;">
     <a style="color:#aaa;" href="steam://connect/'.$q["server_ip"].'/" title="Подключиться через Steam" target="_blank">
      <b>Подключиться</b>
     </a>
    </div>
   </center>
  </div>
  ';
 }
} else {
 echo "Сервер не найден в базе";
}

echo "
    </td>
   </tr>
   <tr>
    <td>
    </td>
   </tr>
  </table>
 </body>
</html>";
 
mysql_close();
