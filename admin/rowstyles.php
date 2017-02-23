<?php
/*
 * Different styles
 * Made by starky
*/

/* Script security */
if (!defined("MONENGINE")) {
 header("Location: index.php");
 exit();
}

/* Other code */
$message = '';

if (isset($_POST['submit'])) {
 $style_title = db()->escape_value($_POST['style_title']);
 $style_name = db()->escape_value($_POST['style_name']);
 $style_style = db()->escape_value($_POST['style_style']);
 $check_style = db()->query("SELECT * FROM `".DB_ROWSTYLES."` WHERE `name` = '$style_name'");
 if (db()->num_rows($check_style) == 0) {
  $add_style = db()->query("INSERT INTO `".DB_ROWSTYLES."` (`name`,`style`,`title`) VALUES ('$style_name', '$style_style', '$style_title')");
  if ($add_style) {
   $message = '<div class="message green"><span>Стиль успешно добавлен.</span></div>';
   $styles = Array(); // Refreshing data..
   $get_styles = db()->query("SELECT * FROM `".DB_ROWSTYLES."` ORDER BY `id` DESC");
   while ($style = db()->fetch_array($get_styles)) {
    $styles[$style['name']]['id'] = $style['id'];
    $styles[$style['name']]['title'] = $style['title'];
    $styles[$style['name']]['style'] = $style['style'];
    $styles[$style['name']]['name'] = $style['name'];
   }
  } else {
   $message = '<div class="message red"><span>Не удалось записать данные в БД.</span></div>';
  }
 } else {
  $message = '<div class="message orange"><span>Стиль с таким именем уже есть в базе.</span></div>';
 }
}

$styleses = '';
if (count($styles) != 0) {
 foreach ($styles as $style) {
  $styleses .= "
     <tr>
      <td>{$style['title']}</td>
      <td>{$style['name']}</td>
      <td>{$style['style']}</td>
     </tr>";
 }
} else {
 $styleses .= '
     <tr>
      <td colspan="3">
       <center>Нет ни одного стиля.</center>
      </td>
     </tr>';
}

echo <<<EOT
<div id="right">
 <div class="section">
  <div class="box">
   <div class="title">Существующие стили<span class="hide"></span></div>
   <div class="content">
    <table cellspacing="0" cellpadding="0" width="100%">
     <thead>
      <tr>
       <th>Название</th>
       <th>Идентификатор</th>
       <th>Код стиля</th>
      </tr>
     </thead>
    <tbody>
     {$styleses}
    </tbody>
   </table>
  </div>
 </div>
</div>
<div class="section">
  <div class="box">
   <div class="title">Добавление нового стиля<span class="hide"></span></div>
   <div class="content">
    {$message}
    <form action="" method="POST">
     <div class="row">
      <label>Название стиля</label>
      <div class="right">
       <input type="text" name="style_title">
      </div>
     </div>
     <div class="row">
      <label>Идентификатор</label>
      <div class="right">
       <input type="text" name="style_name">
      </div>
     </div>
     <div class="row">
      <label>Код стиля</label>
      <div class="right">
       <input type="text" name="style_style" placeholder="CSS код стиля">
      </div>
     </div>
     <div class="row">
      <div class="right">
       <button type="submit" name="submit" class="orange"><span>Добавить стиль</span></button> 
       <button type="button" name="submit" class="grey" onClick="window.location.href='index.php';"><span>Отмена</span></button>
      </div>
     </div>
    </form>
   </div>
  </div>
 </div>
</div>
EOT;
