<?php
define('MONENGINE', 'Remake by starky');

Error_Reporting(E_ALL & ~E_NOTICE);

require("../include/core.php");
require_once("includes/inc.php");

// If user is not logged in
if (!$logged_in) {
 header("Location: login.php");
 exit();
}
// If user is logged in
require_once("includes/menu.class.php");
$menu = new Menu;
$menu->add('main', 'index.php', 'Главная страница');
$menu->add('replies', 'replies', 'Подтверждение отзывов');
$menu->add('settings', 'settings', 'Настройки сайта');
$menu->add('rowstyles', 'rowstyles', 'Управление стилями');
$menu->add('add_server', 'add_server', 'Добавить сервер');
$menu->add('needed_maps', 'needed_maps', 'Недостающие картинки карт');
$menu->add('send_email', 'send_email', 'Рассылка почты');

$load = "";
$page = "";

if (isset($_GET['page'])) $page = $_GET['page'];
 
switch ($page) {
 case 'server_info':
  $page_title = "Панель управления | Информация о сервере";
  $load_file = "server.php";
  break;
 case 'server_edit':
  $page_title = "Панель управления | Редактирование сервера";
  $load_file = "server_edit.php";
  break;
 case 'replies':
  $menu->set('replies');
  $page_title = "Панель управления | Редактирование отзывов";
  $load_file = "replies.php";
  break;
 case 'settings':
  $menu->set('settings');
  $page_title = "Панель управления | Редактирование настроек";
  $load_file = "settings.php";
  break;
 case 'rowstyles':
  $menu->set('rowstyles');
  $page_title = "Панель управления | Управление стилями";
  $load_file = "rowstyles.php";
  break;
 case 'add_server':
  $menu->set('add_server');
  $page_title = "Панель управления | Добавление сервера";
  $load_file = "add_server.php";
  break;
 case 'needed_maps':
  $menu->set('needed_maps');
  $page_title = "Панель управления | Недостающие картинки карт";
  $load_file = "needed_maps.php";
  break;
 default:
  $menu->set('main');
  $page_title = $settings['site_name']." | Панель управления";
  $load_file = 'dashboard.php';
  break;
}
 
// Header block
require_once("template/header.php");
require_once("template/topmenu.php");
require_once("template/leftcol.php");

// Main area
if (file_exists($load_file)) {
 require($load_file); // Loading main area
} else {
 $msg_code = 404;
 require('../include/messages.php'); // File not found
}
 
// Footer block
require_once("template/footer.php");
