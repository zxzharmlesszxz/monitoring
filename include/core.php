<?php
/*
 * Engine core
 * Made by starky
*/
prof_flag("Including " . __FILE__);
error_reporting(E_ALL);
ini_set('display_errors', 1);
prof_flag("XSS");
//Проверка от XSS атак $_GET
foreach ($_GET as $check_url) {
    if (!is_array($check_url)) {
        $check_url = str_replace("\"", "", $check_url);
        if ((preg_match("/<[^>]*script*\"?[^>]*>/i", $check_url)) || (preg_match("/<[^>]*object*\"?[^>]*>/i", $check_url)) ||
            (preg_match("/<[^>]*iframe*\"?[^>]*>/i", $check_url)) || (preg_match("/<[^>]*applet*\"?[^>]*>/i", $check_url)) ||
            (preg_match("/<[^>]*meta*\"?[^>]*>/i", $check_url)) || (preg_match("/<[^>]*style*\"?[^>]*>/i", $check_url)) ||
            (preg_match("/<[^>]*form*\"?[^>]*>/i", $check_url)) || (preg_match("/\([^>]*\"?[^)]*\)/i", $check_url)) ||
            (preg_match("/\"/i", $check_url))
        ) {
            die();
        }
    }
}
unset($check_url);

// Калькулятор вывода генерации страницы
$start_time = microtime();
$start_array = explode(" ", $start_time);
$start_time = $start_array[1] + $start_array[0];

require_once __DIR__ . "/Registry.class.php";
require_once __DIR__ . "/Config.class.php";
require_once __DIR__ . "/Database.class.php";
require_once __DIR__ . "/MySQL_Database.class.php";
require_once __DIR__ . "/PHPMailer.class.php";
require_once __DIR__ . "/smtp.class.php";
require_once __DIR__ . "/ServerQueries.php";
require_once __DIR__ . "/SourceServerQueries.php";
require_once __DIR__ . "/function.php";
Registry::_set('config', Config::getInstance());
Registry::_set('database', new MySQL_Database);

require_once __DIR__ . "/constants.php";
require_once(LOCALE . LOCALESET . 'global.php');
require_once(LOCALE . LOCALESET . 'serv.php');
prof_flag("DB get settings");
$settings = db()->fetch_array(dbquery("SELECT * FROM " . DB_SETTINGS));
prof_flag("DB get styles");
// Стили выделения
$styles = Array();
$get_styles = db()->query("SELECT * FROM `" . DB_ROWSTYLES . "` ORDER BY `id` DESC");

while ($style = db()->fetch_array($get_styles)) {
    $styles[$style['name']]['id'] = $style['id'];
    $styles[$style['name']]['title'] = $style['title'];
    $styles[$style['name']]['style'] = $style['style'];
    $styles[$style['name']]['name'] = $style['name'];
}

// Переменные выбора таблиц

// Определяем сколько серверов находится в БД
$servers_total = $settings['servers_total'];
$servers_online = $settings['servers_online'];
$top_map = $settings['top_map'];

if (file_exists("./install.php")) {
    exit("Для продолжения работы необходимо удалить файл <b>install.php</b>.");
}
prof_flag("Start redis connection");
$redis = new Redis();
$redis->connect($settings['redis_host']);
$redis->auth($settings['redis_password']);
$redis->select(1);
prof_flag("Redis get server");
$servers = json_decode($redis->hGetAll('servers'));
/*prof_flag("Decode data");
foreach ($servers as $id => $item) {
    $servers[$id] = json_decode($item, true);
}*/
prof_flag("Sort data");
ksort($servers);
