<?php

/* Script security */
if (!defined("MONENGINE")) {
 header("Location: index.php");
 exit();
}

/* Other code */
echo <<<EOT
 <div id='right'>
  <div class='section'>
   <div class='box'>
    <div class='title'>Рассылка почты<span class='hide'></span></div>
    <div class='content'>
     $message
     <form action='' method='POST'>
      <div class='row'>
       <label>Адрес сервера <span color='red'>*</span></label>
       <div class='right'>
        <input type='text' name='server_address' placeholder='127.0.0.1:27015' value='$address'>
       </div>
      </div>
      <div class='row'>
       <div class='right'>
        <button type='submit' name='submit_registration' class='blue'><span>Зарегистрировать</span></button>
        <button type='button' onClick='window.location.href='index.php'><span>Отмена</span></button>
       </div>
      </div>
     </form>
    </div>
   </div>
  </div>
 </div>
EOT;
