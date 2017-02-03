<?php

define('MONENGINE', 'Remake by starky');

Error_Reporting(E_ALL);

session_start();

require_once(__DIR__.'/include/core.php');

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
 'gm' => 'Сервера Garry\'s Mod',
 'garrysmod' => 'Сервера Garry\'s Mod',
);

$page_title_modes = array('classic' => 'Сервера с Classic модом',
 'csdm' => 'Сервера с CSDM модом',
 'diablomod' => 'Сервера с DiabloMod модом',
 'gungame' => 'Сервера с GunGame модом',
 'hns' => 'Сервера с Hide n seek модом',
 'jailbreak' => 'Сервера с JailBreak модом',
 'jump' => 'Сервера с Jump модом',
 'knife' => 'Сервера с Knife модом',
 'soccerjam' => 'Сервера с SoccerJam модом',
 'deathrun' => 'Сервера с DeathRun модом',
 'superhero' => 'Сервера с SuperHero модом',
 'warcraft' => 'Сервера с War3raft модом',
 'surf' => 'Сервера с Surf модом',
 'zombiemod' => 'Сервера с Zombie модом',
);

if (isset($_GET['page'])) $load = $_GET['page'];
 
switch ($load) {
 case 'add':
  $page_title = "Добавить сервер CS 1.6, CS:S, CS:GO";
  $load_file = __DIR__.'/templates/register.php';
  break;
 case 'pay':
  $page_title = "VIP услуги для серверов CS 1.6, CS:S, CS:GO";
  $load_file = __DIR__.'/templates/pay.php';
  break;
 case 'edit_server':
  $page_title = "Редактирование сервера CS 1.6, CS:S, CS:GO";
  $load_file = __DIR__.'/templates/edit_server.php';
  break;
 case 'paytop':
  $page_title = "Редактирование сервера CS 1.6, CS:S, CS:GO";
  $load_file = __DIR__.'/templates/paytop.php';
  break;
 case 'payserver':
  $page_title = "Редактирование сервера CS 1.6, CS:S, CS:GO";
  $load_file = __DIR__.'/templates/payserver.php';
  break;
 case 'links':
  $page_title = "Каталог ссылок : ";
  $load_file = __DIR__.'/templates/links.php';
  break;
 case 'chat':
  $page_title = "Чат мониторинга : ";
  $load_file = __DIR__.'/templates/chat.php';
  break;
 case 'monengine':
  $page_title = "Купить скрипт мониторинга CS 1.6, CS:S, CS:GO";
  $load_file = __DIR__.'/templates/monengine.php';
  break;
 case 'banned':
  $page_title = "Ваш сервер заблокирован!";
  $load_file = __DIR__.'/templates/banned.php';
  break;
 case 'feedback':
  $page_title = "Обратная связь";
  $load_file = __DIR__.'/templates/feedback.php';
  break;
 case 'mserv':
  $page_title = "Скачать мастер сервер для CS 1.6, CS:S, CS:GO";
  $load_file = __DIR__.'/templates/mserv.php';
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
  $filter = "AND server_game = '${load}'";
  $load_file = __DIR__.'/templates/servers.php';
  break;
 case 'classic':
 case 'csdm':
 case 'diablomod':
 case 'gungame':
 case 'hns':
 case 'jailbreak':
 case 'jump':
 case 'knife':
 case 'soccerjam':
 case 'deathrun':
 case 'superhero':
 case 'warcraft':
 case 'surf':
 case 'zombiemod':
  $page_title = $page_title_modes[$load];
  $filter = "AND server_mode = '${load}'";
  $load_file = __DIR__.'/templates/servers.php';
  break;
 case 'search':
  $page_title = "Поиск серверов CS 1.6, CS:S, CS:GO";
  $load_file = __DIR__.'/templates/search.php';
  break;
 case 'info':
  $take_server = dbquery("SELECT * FROM ".DB_SERVERS." WHERE server_id = ".$_GET['id']."");
  $server_data = dbarray_fetch($take_server);
  $page_title = "Сервер: $server_data[server_name]";
  $load_file = (!empty($_GET['id']) and is_numeric($_GET['id'])) ? 'server_info.php' : 'all_servers.php';
  break;
 case 'message':
  $msg_code = $_GET['code'];
  $load_file = __DIR__.'/templates/messages.php'; // File not found
  break;
 default:
  $filter = '';
  $load_file = __DIR__.'/templates/servers.php';
  break;
}
 
// Header block
require_once THEME."header.php";
 
// Main area
if (file_exists($load_file)) {
 require($load_file); // Loading main area
} else {
 $msg_code = 404;
 require('include/messages.php'); // File not found
}
 
// Footer block
require_once THEME."footer.php";

if (!defined('_SAPE_USER')) {
 define('_SAPE_USER', '189e973cb06bd7bc0997a7a64f78a648');
}

require_once($_SERVER['DOCUMENT_ROOT'].'/'._SAPE_USER.'/sape.php');
$sape_article = new SAPE_articles();
echo $sape_article->return_announcements();
