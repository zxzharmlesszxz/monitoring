<?php

define('MONENGINE', 'Remake by starky');

Error_Reporting(E_ALL);

session_start();

require_once(__DIR__ . '/include/core.php');

if ($settings['site_closed'] == '1') {
    header('Location: closed.php'); // Site is closed
    exit();
}

// Body

$load = "";

if (isset($_GET['page'])) $load = $_GET['page'];

switch ($load) {
    case 'banner':
         $load_file = __DIR__ . '/templates/banner.php';
         require($load_file);
         exit;
    case 'add':
        $page_title = "Добавить сервер CS 1.6, CS:S, CS:GO";
        $load_file = __DIR__ . '/templates/register.php';
        break;
    case 'pay':
        $page_title = "VIP услуги для серверов CS 1.6, CS:S, CS:GO";
        $load_file = __DIR__ . '/templates/pay.php';
        break;
    case 'edit_server':
        $page_title = "Редактирование сервера CS 1.6, CS:S, CS:GO";
        $load_file = __DIR__ . '/templates/edit_server.php';
        break;
    case 'paytop':
        $page_title = "Редактирование сервера CS 1.6, CS:S, CS:GO";
        $load_file = __DIR__ . '/templates/paytop.php';
        break;
    case 'payserver':
        $page_title = "Редактирование сервера CS 1.6, CS:S, CS:GO";
        $load_file = __DIR__ . '/templates/payserver.php';
        break;
    case 'links':
        $page_title = "Каталог ссылок : ";
        $load_file = __DIR__ . '/templates/links.php';
        break;
    case 'chat':
        $page_title = "Чат мониторинга : ";
        $load_file = __DIR__ . '/templates/chat.php';
        break;
    case 'monengine':
        $page_title = "Купить скрипт мониторинга CS 1.6, CS:S, CS:GO";
        $load_file = __DIR__ . '/templates/monengine.php';
        break;
    case 'banned':
        $page_title = "Ваш сервер заблокирован!";
        $load_file = __DIR__ . '/templates/banned.php';
        break;
    case 'feedback':
        $page_title = "Обратная связь";
        $load_file = __DIR__ . '/templates/feedback.php';
        break;
    case 'mserv':
        $page_title = "Скачать мастер сервер для CS 1.6, CS:S, CS:GO";
        $load_file = __DIR__ . '/templates/mserv.php';
        break;
    case 'search':
        $page_title = "Поиск серверов CS 1.6, CS:S, CS:GO";
        $load_file = __DIR__ . '/templates/search.php';
        break;
    case 'server':
        //$take_server = dbquery("SELECT * FROM " . DB_SERVERS . " WHERE server_id = '{$_GET['id']}';");
        //$server_data = dbarray_fetch($take_server);
        //$page_title = "Сервер: $server_data[server_name]";
        //$load_file = (!empty($_GET['id']) and is_numeric($_GET['id'])) ? __DIR__ . '/templates/server_info.php' : __DIR__ . '/templates/servers.php';
        $page_title = "Сервер: {$servers[$_GET['id']]['info']['serverName']}";
        $load_file = (!empty($servers[$_GET['id']])) ? __DIR__ . '/templates/server_info.php' : __DIR__ . '/templates/servers.php';
        break;
    case 'message':
        $msg_code = $_GET['code'];
        $load_file = __DIR__ . '/templates/messages.php'; // File not found
        break;
    case 'byweb':
        $load_file = __DIR__ . '/templates/byweb.php';
        require($load_file);
        exit;
        break;
    case 'cs16':
    case 'cssource':
    case 'csgo':
    case 'cz':
    case 'cszero':
    case 'hl':
    case 'hl2':
    case 'l4d':
    case 'l4d2':
    case 'teamfortess':
    case 'garrysmod':
        $page_title = "Сервера {$games[$load]}";
        $filter = "AND server_game = '${load}'";
        $load_file = __DIR__ . '/templates/servers.php';
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
        $page_title = "Сервера с {$modes[$load]} модом";
        $filter = "AND server_mode = '${load}'";
        $load_file = __DIR__ . '/templates/servers.php';
        break;
    case 'serversredis':
        $page_title = "Сервера из redis";
        $filter = '';
        $load_file = __DIR__ . '/templates/servers_from_redis.php';
        break;
    default:
        $filter = '';
        $load_file = __DIR__ . '/templates/servers.php';
        break;
}

// Header block
require_once(THEME . "header.php");

// Main area
if (file_exists($load_file)) {
    require($load_file); // Loading main area
} else {
    $msg_code = 404;
    require('include/messages.php'); // File not found
}

// Footer block
require_once THEME . "footer.php";

require_once(__DIR__ . '/' . _SAPE_USER . '/sape.php');
$sape_article = new SAPE_articles();
echo $sape_article->return_announcements();
