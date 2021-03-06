<?php

define('MONENGINE', 'Remake by starky');

Error_Reporting(E_ALL);
ini_set('xdebug.profiler_enable_trigger', 1);

require_once(__DIR__ . '/include/profieler.php');

prof_flag("Start");

session_start();
prof_flag("Include core");
require_once(__DIR__ . '/include/core.php');

if ($settings['site_closed'] == '1') {
    header('Location: closed.php'); // Site is closed
    exit();
}

// Body
prof_flag("Determine page");
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
    case 'vote':
        $load_file = __DIR__ . '/templates/vote.php';
        break;
    case 'servers4ms':
        $load_file = __DIR__ . '/templates/servers4ms.php';
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
        require(__DIR__ . '/templates/byweb.php');
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
    default:
        $filter = '';
        $load_file = __DIR__ . '/templates/servers.php';
        break;
}

if ($load == 'vote' or $load == 'servers4ms') {
  include $load_file;
  exit();
}

prof_flag("Including header");
// Header block
require_once(THEME . "header.php");

prof_flag("Including page");

// Main area
if (file_exists($load_file)) {
    require($load_file); // Loading main area
} else {
    $msg_code = 404;
    require('include/messages.php'); // File not found
}

prof_flag("Including footer");

// Footer block
require_once THEME . "footer.php";
prof_flag("Init sape");
require_once(__DIR__ . '/' . _SAPE_USER . '/sape.php');
$sape_article = new SAPE_articles();
echo $sape_article->return_announcements();
prof_flag("Done");
//prof_print();
