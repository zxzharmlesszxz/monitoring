<?php
define("MONENGINE", true);
error_reporting(E_ALL);

// вся процедура работает на сессиях. Именно в ней хранятся данные пользователя, пока он находится на сайте. Очень важно запустить их в самом начале странички!!!
// подключаемся к базе
include("../include/core.php");

session_start();
session_destroy();
$msg_color = 'blue';
$msg_text = "Вы успешно <b>вышли</b> из системы и будете перенаправлены через 3 секунды.";

echo <<<EOT
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
 <head>
  <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
  <title>Вход в систему</title>
  <meta http-equiv='Refresh' content='3; URL={$settings['site_url']}admin/login.php'>
  <style type="text/css">
   @import url("template/css/style.css");
   @import url("template/css/forms.css");
   @import url("template/css/forms-btn.css");
   @import url("template/css/menu.css");
   @import url('template/css/style_text.css');
   @import url("template/css/datatables.css");
   @import url("template/css/fullcalendar.css");
   @import url("template/css/pirebox.css");
   @import url("template/css/modalwindow.css");
   @import url("template/css/statics.css");
   @import url("template/css/tabs-toggle.css");
   @import url("template/css/system-message.css");
   @import url("template/css/tooltip.css");
   @import url("template/css/wizard.css");
   @import url("template/css/wysiwyg.css");
   @import url("template/css/wysiwyg.modal.css");
   @import url("template/css/wysiwyg-editor.css");
  </style>
  <!--[if lte IE 8]>
   <script type="text/javascript" src="template/js/excanvas.min.js"></script>
  <![endif]-->
  <script type="text/javascript" src="template/js/jquery-1.7.1.min.js"></script>
  <script type="text/javascript" src="template/js/jquery.backgroundPosition.js"></script>
  <script type="text/javascript" src="template/js/jquery.placeholder.min.js"></script>
  <script type="text/javascript" src="template/js/jquery.ui.1.8.17.js"></script>
  <script type="text/javascript" src="template/js/jquery.ui.select.js"></script>
  <script type="text/javascript" src="template/js/jquery.ui.spinner.js"></script>
  <script type="text/javascript" src="template/js/superfish.js"></script>
  <script type="text/javascript" src="template/js/supersubs.js"></script>
  <script type="text/javascript" src="template/js/jquery.datatables.js"></script>
  <script type="text/javascript" src="template/js/fullcalendar.min.js"></script>
  <script type="text/javascript" src="template/js/jquery.smartwizard-2.0.min.js"></script>
  <script type="text/javascript" src="template/js/pirobox.extended.min.js"></script>
  <script type="text/javascript" src="template/js/jquery.tipsy.js"></script>
  <script type="text/javascript" src="template/js/jquery.elastic.source.js"></script>
  <script type="text/javascript" src="template/js/jquery.customInput.js"></script>
  <script type="text/javascript" src="template/js/jquery.validate.min.js"></script>
  <script type="text/javascript" src="template/js/jquery.metadata.js"></script>
  <script type="text/javascript" src="template/js/jquery.filestyle.mini.js"></script>
  <script type="text/javascript" src="template/js/jquery.filter.input.js"></script>
  <script type="text/javascript" src="template/js/jquery.flot.js"></script>
  <script type="text/javascript" src="template/js/jquery.flot.pie.min.js"></script>
  <script type="text/javascript" src="template/js/jquery.flot.resize.min.js"></script>
  <script type="text/javascript" src="template/js/jquery.graphtable-0.2.js"></script>
  <script type="text/javascript" src="template/js/jquery.wysiwyg.js"></script>
  <script type="text/javascript" src="template/js/controls/wysiwyg.image.js"></script>
  <script type="text/javascript" src="template/js/controls/wysiwyg.link.js"></script>
  <script type="text/javascript" src="template/js/controls/wysiwyg.table.js"></script>
  <script type="text/javascript" src="template/js/plugins/wysiwyg.rmFormat.js"></script>
  <script type="text/javascript" src="template/js/costum.js"></script>
 </head>
 <body>
  <div id="wrapper" class="login">
   <div class="box">
    <div class="title">Выход из системы<span class="hide"></span></div>
    <div class="content">
     <div class="message inner {$msg_color}">
      <span>{$msg_text}</span>
     </div>
    </div>
   </div>
  </div>
 </body>
</html>
EOT;
