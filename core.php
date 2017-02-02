<?php
/*
 * Engine core
 * Made by starky
*/

error_reporting(E_ALL);

//Проверка от XSS атак $_GET
foreach ($_GET as $check_url) {
 if (!is_array($check_url)) {
  $check_url = str_replace("\"", "", $check_url);
  if ((preg_match("/<[^>]*script*\"?[^>]*>/i", $check_url)) || (preg_match("/<[^>]*object*\"?[^>]*>/i", $check_url)) ||
   (preg_match("/<[^>]*iframe*\"?[^>]*>/i", $check_url)) || (preg_match("/<[^>]*applet*\"?[^>]*>/i", $check_url)) ||
   (preg_match("/<[^>]*meta*\"?[^>]*>/i", $check_url)) || (preg_match("/<[^>]*style*\"?[^>]*>/i", $check_url)) ||
   (preg_match("/<[^>]*form*\"?[^>]*>/i", $check_url)) || (preg_match("/\([^>]*\"?[^)]*\)/i", $check_url)) ||
   (preg_match("/\"/i", $check_url))) {
   die();
  }
 }
}
unset($check_url);

// Калькулятор вывода генерации страницы
$start_time = microtime();
$start_array = explode(" ",$start_time);
//define("SSER_US", $db_user);
$start_time = $start_array[1] + $start_array[0];
//$current_time = file_get_contents("http://starky.axmservers.ru/current_time.txt");
//if($current_time == 'none') exit();

require_once __DIR__."/include/config.php";
require_once __DIR__."/include/function.php";

require_once __DIR__."/include/constants.php";
require_once __DIR__."/include/rus_name_fix.php";

// Если бд нет, то переадресует на install.php
if (!isset($db_name)) exit("Нет базы данных.");

// Конект к БД
$link = dbconnect($db_host, $db_user, $db_pass, $db_name);

// Стили выделения
$styles = Array();
$get_styles = dbquery("SELECT * FROM `".DB_ROWSTYLES."` ORDER BY `id` DESC");
while($style = dbarray_fetch($get_styles)) {
 $styles[$style['name']]['id'] = $style['id'];
 $styles[$style['name']]['title'] = $style['title'];
 $styles[$style['name']]['style'] = $style['style'];
 $styles[$style['name']]['name'] = $style['name'];
}

// Переменные выбора таблиц

// Определяем сколько серверов находится в БД
$servers_total = $settings['servers_total'];
$servers_online = $settings['servers_online'];

if (file_exists("./install.php")) {
 exit("<center><br><br><br><br><br><br>Для продолжения работы необходимо удалить файл <b>install.php</b>.</center>");
}
