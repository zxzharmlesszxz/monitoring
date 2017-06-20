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
 <div style="padding:10px;line-height:19px;">
  <div style="padding:15px;background:#333333;">
   <b><i>Мастерсервер</i> - это сервер, который передает список IP адресов и полную статистику по игровым серверам в Ваш клиент игры. Подключившись, Вы всегда сможете искать сервера CS 1.6 из нашего мониторинга у себя в игре. Для подключения необходимо заменить 1 файл, в нем прописан IP нашего мастерсервера. Также немаловажной деталью является то, что мастерсервер доступен всегда и работает 24/7.</b>
   <div>
    <img src="/images/img/screen.jpg">
   </div>
  </div>
 </div>
 <div style="padding:10px;line-height:19px;">
  <div style="padding:15px;background:#333333;">
   <div style="padding-bottom: 10px;" align="">
    <ol>
     <li>Скачайте <a href="https://monitoring.contra.net.ua/load/MasterServers.rar"><i>MASTERSERVER.vdf</i></a> (1 КБ) и разархивируйте!</li>
     <li>Скопируйте <i>MasterServers.vdf</i> в папку <i>config</i> с заменой старого на новый
      <ul>
       <li>в игре No-Steam: <i>D:\Games\Counter-strike\platform\config\MasterServers.vdf</i></li>
       <li>в игре Steam: <i>D:\Games\Steam\config\MasterServers.vdf</i></li>
       <li>Если файл <i>masterserver2.vdf</i> находится в той же директории, его также следует заменить</li>
      </ul>
     </li>
     <li>Измените свойства файла <i>MasterServers.vdf</i> на <i>«Только для чтения»</i> (read-only file)
      <ul>
       <li>свойста изменить очень просто: наведите курсор на файл MasterServers.vdf и нажмите правую кнопку мыши,</li>
       <li>в появишемся списке выберите <i>"Свойства"</i>, в открывшемся окне снизу Вы найдете <i>"Атрибуты"</i>, отметьте <i>"Только для чтения"</i>.</li>
      </ul>
     </li>
    </ol>
   </div>
   <u>
    <b>
     <i>Готово! Теперь можете искать наши сервера прямо у себя с клиента игры Counter-Strike 1.6!</i>
    </b>
   </u>
  </div>
 </div>
EOT;
