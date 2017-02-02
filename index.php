<?php

define('MONENGINE', 'Remake by starky');

Error_Reporting(E_ALL);

session_start();

require_once('core.php');


require_once(LOCALE.LOCALESET.'global.php');
require_once(LOCALE.LOCALESET.'serv.php');

if ($settings['site_closed'] == '1') {
 header('Location: closed.php'); // Site is closed
 exit();
}

// Body
 
$load = "";

$page_title_games = array('cs16' => 'Сервера CS 1.6',
 'css' => 'Сервера CS: Source',
 'cssource' => 'Сервера CS: Source',
 'csgo' => 'Сервера CS: Global Offensive',
 'cz' => 'Сервера CS: Condition Zero',
 'cszero' => 'Сервера CS: Condition Zero',
 'hl' => 'Сервера Half-Life',
 'hl2' => 'Сервера Half-Life 2',
 'l4d' => 'Сервера Left 4 Dead',
 'left4dead' => 'Сервера Left 4 Dead',
 'l4d2' => 'Сервера Left 4 Dead 2',
 'left4dead2' => 'Сервера Left 4 Dead 2',
 'tf2' => 'Сервера Team Fortess 2',
 'teamfortess' => 'Сервера Team Fortess 2',
 'gm' => 'Сервера Garry's Mod',
 'garrysmod' => 'Сервера Garry's Mod',
);
$page_title_modes = array();

if (isset($_GET['page'])) $load = $_GET['page'];
 
switch ($load) {
 case 'add':
  $page_title = "Добавить сервер CS 1.6, CS:S, CS:GO";
  $load_file = 'register.php';
  break;
 case 'pay':
  $page_title = "VIP услуги для серверов CS 1.6, CS:S, CS:GO";
  $load_file = 'pay.php';
  break;
 case 'edit_server':
  $page_title = "Редактирование сервера CS 1.6, CS:S, CS:GO";
  $load_file = 'edit_server.php';
  break;
 case 'paytop':
  $page_title = "Редактирование сервера CS 1.6, CS:S, CS:GO";
  $load_file = 'paytop.php';
  break;
 case 'payserver':
  $page_title = "Редактирование сервера CS 1.6, CS:S, CS:GO";
  $load_file = 'payserver.php';
  break;
 case 'links':
  $page_title = "Каталог ссылок : ";
  $load_file = 'links.php';
  break;
 case 'chat':
  $page_title = "Чат мониторинга : ";
  $load_file = 'chat.php';
  break;
 case 'monengine':
  $page_title = "Купить скрипт мониторинга CS 1.6, CS:S, CS:GO";
  $load_file = 'monengine.php';
  break;
 case 'banned':
  $page_title = "Ваш сервер заблокирован!";
  $load_file = 'banned.php';
  break;
 case 'feedback':
  $page_title = "Обратная связь";
  $load_file = 'feedback.php';
  break;
 case 'mserv':
  $page_title = "Скачать мастер сервер для CS 1.6, CS:S, CS:GO";
  $load_file = 'mserv.php';
  break;
 case 'cs16':
 case 'css':
 case 'cssource':
 case 'csgo':
 case 'cz':
 case 'cszero':
 case 'hl':
 case 'hl2':
 case 'l4d':
 case 'left4dead':
 case 'l4d2':
 case 'left4dead2':
 case 'teamfortess':
 case 'tf2':
 case 'garrysmod':
 case 'gm':
  $page_title = $page_title_games[$load];
  $load_file = 'gamesort.php';
  break;
 case 'classic':
  $page_title = "Сервера с Classic модом";
  $load_file = 'modesort.php';
  break;
 case 'csdm':
  $page_title = "Сервера с CSDM модом";
  $load_file = 'modesort.php';
  break;
 case 'diablomod':
  $page_title = "Сервера с DiabloMod модом";
  $load_file = 'modesort.php';
  break;
 case 'gungame':
  $page_title = "Сервера с GunGame модом";
  $load_file = 'modesort.php';
  break;
 case 'hns':
  $page_title = "Сервера с Hide n seek модом";
  $load_file = 'modesort.php';
  break;
 case 'jailbreak':
  $page_title = "Сервера с JailBreak модом";
  $load_file = 'modesort.php';
  break;
 case 'jump':
  $page_title = "Сервера с Jump модом";
  $load_file = 'modesort.php';
  break;
 case 'knife':
  $page_title = "Сервера с Knife модом";
  $load_file = 'modesort.php';
  break;
 case 'soccerjam':
  $page_title = "Сервера с SoccerJam модом";
  $load_file = 'modesort.php';
  break;
 case 'deathrun':
  $page_title = "Сервера с DeathRun модом";
  $load_file = 'modesort.php';
  break;
 case 'superhero':
  $page_title = "Сервера с SuperHero модом";
  $load_file = 'modesort.php';
  break;
 case 'warcraft':
  $page_title = "Сервера с War3raft модом";
  $load_file = 'modesort.php';
  break;
 case 'surf':
  $page_title = "Сервера с Surf модом";
  $load_file = 'modesort.php';
  break;
 case 'zombiemod':
  $page_title = "Сервера с Zombie модом";
  $load_file = 'modesort.php';
  break;
 case 'search':
  $page_title = "Поиск серверов CS 1.6, CS:S, CS:GO";
  $load_file = 'search.php';
  break;
 case 'all_servers':
  $load_file = 'all_servers.php';
  break;
 case 'info':
  $take_server = dbquery("SELECT * FROM ".DB_SERVERS." WHERE server_id = ".$_GET['id']."");
  $server_data = dbarray_fetch($take_server);
  $page_title = "Сервер: $server_data[server_name]";
  $load_file = (!empty($_GET['id']) and is_numeric($_GET['id'])) ? 'server_info.php' : 'all_servers.php';
  break;
 case 'message':
  $msg_code = $_GET['code'];
  $load_file = 'messages.php'; // File not found
  break;
 default:
  $load_file = 'servers.php';
  break;
}
 
// Header block
require_once THEME."header.php";
 
// Main area
if (file_exists($load_file)) {
 require($load_file); // Loading main area
} else {
 $msg_code = 404;
 require('messages.php'); // File not found
}
 
// Footer block
require_once THEME."footer.php";

if (!defined('_SAPE_USER')) {
 define('_SAPE_USER', '189e973cb06bd7bc0997a7a64f78a648');
}

require_once($_SERVER['DOCUMENT_ROOT'].'/'._SAPE_USER.'/sape.php');
$sape_article = new SAPE_articles();
echo $sape_article->return_announcements();
