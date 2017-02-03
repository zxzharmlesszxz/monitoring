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
<div class='horizontal_line'>Скачать наш мастер-сервер</div>
<div class='cont'>
 </br>
 <div style="padding:10px;line-height:19px;">
  <div style="padding:15px;background:#333333;">
   <b><font color="#ffffff">Мастерсервер</font> - это сервер, который передает список IP адресов и полную статистику по игровым серверам в Ваш клиент игры. Подключившись, Вы всегда сможете искать сервера CS 1.6 из нашего мониторинга у себя в игре. Для подключения необходимо заменить 1 файл, в нем прописан IP нашего мастерсервера. Также немаловажной деталью является то, что мастерсервер доступен всегда и работает 24/7.</b>
  </div>
 </div>
 <div style="padding:10px;line-height:19px;">
  <div style="padding:15px;background:#333333;">
   <div style="padding-bottom: 10px;" align="">
    <ol>
     <li>Скачайте <a href="https://monitoring.contra.net.ua/load/MasterServers.rar"><span>MASTERSERVER.vdf</span></a> (1 КБ) и разархивируйте!</li>
     <li>Скопируйте <font color="#999999">MasterServers.vdf</font> в папку <font color="#999999">config</font> с заменой старого на новый
      <ul>
       <li>в игре No-Steam: <font color="#999999">D:\Games\Counter-strike\platform\config\MasterServers.vdf</font></li>
       <li>в игре Steam: <font color="#999999">D:\Games\Steam\config\MasterServers.vdf</font></li>
       <li>Если файл <font color="#999999">masterserver2.vdf</font> находится в той же директории, его также следует заменить</li>
      </ul>
     </li>
     <li>Измените свойства файла <font color="#999999">MasterServers.vdf</font> на <font color="#999999">«Только для чтения»</font> (read-only file)
      <ul>
       <li>свойста изменить очень просто: наведите курсор на файл MasterServers.vdf и нажмите правую кнопку мыши,</li>
       <li>в появишемся списке выберите <font color="#999999">"Свойства"</font>, в открывшемся окне снизу Вы найдете <font color="#999999">"Атрибуты"</font>, отметьте <font color="#999999">"Только для чтения"</font>.</li>
      </ul>
      <img src="http://monitoring.contra.net.ua/imeges/img/screen.jpg">
     </li>
    </ol>
   </div>
   <u>
    <b>
     <font color="#ffffff">Готово! Теперь можете искать наши сервера прямо у себя с клиента игры Counter-Strike 1.6!</font>
    </b>
   </u>
  </div>
 </div>
EOT;
