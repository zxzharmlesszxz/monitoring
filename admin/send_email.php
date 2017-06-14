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
     <form action='' method='POST'>
      <div class='row'>
       <label>Сообщение <span color='red'>*</span></label>
       <div class='right'>
        <textarea name='message'></textarea>
       </div>
      </div>
      <div class='row'>
       <div class='right'>
        <button type='submit' name='submit' class='blue'><span>Отправить</span></button>
        <button type='button' onClick='window.location.href='index.php'><span>Отмена</span></button>
       </div>
      </div>
     </form>
    </div>
   </div>
  </div>
 </div>
EOT;
