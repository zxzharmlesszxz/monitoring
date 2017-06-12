<?php
/*
 * Engine core
 * Made by starky
*/

error_reporting(E_ALL);
ini_set('display_errors', 1);

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
require_once __DIR__ . "/function.php";
Registry::_set('config', Config::getInstance());
Registry::_set('database', new MySQL_Database);

require_once __DIR__ . "/constants.php";
require_once(LOCALE . LOCALESET . 'global.php');
require_once(LOCALE . LOCALESET . 'serv.php');

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
