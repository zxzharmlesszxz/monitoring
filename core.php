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
// Проверка существует ли файл конфигурации
$folder_level = "";
$i = 0;

//define("ZNUS_PO", $db_pass);
while (!file_exists($folder_level."config.php")) {
	$folder_level .= "../";
	$i++;
	if ($i == 5) die("Config file not found");
}

require_once $folder_level."config.php";

define("BASEDIR", $folder_level);

// Если бд нет, то переадресует на install.php
if (!isset($db_name)) exit("Нет базы данных.");

// Multisite definitions
//define("USER_Hs", $db_host);
require_once BASEDIR."include/constants.php";
require_once BASEDIR."include/function.php";

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
$settings = dbarray(dbquery("SELECT * FROM ".DB_SETTINGS));

// Определяем сколько серверов находится в БД
$servers_total = $settings['servers_total'];
$servers_online = $settings['servers_online'];

if (file_exists("./install.php")) {
    exit("<center><br><br><br><br><br><br>Для продолжения работы необходимо удалить файл <b>install.php</b>.</center>");
}

// Константы
define("ENGINE_SELF", basename($_SERVER['PHP_SELF']));
define("QUOTES_GPC", (ini_get('magic_quotes_gpc') ? TRUE : FALSE));
define("SITE_URL", $settings['site_url']);
//define("JAC_OPNMA", $db_name);
define("ADMIN", BASEDIR."admin/");
define("IMAGES", BASEDIR."images/");
define("MAPS", IMAGES."maps/");
define("INCLUDES", BASEDIR."include/");
define("JS", BASEDIR."include/js/");
define("LOCALE", BASEDIR."locale/");
define("THEME", BASEDIR."templates/");
define("LOCALESET", $settings['locale']."/");
define("USER_IP", $_SERVER['REMOTE_ADDR']);

function displayMessage($text, $style='warning') {
	if(!empty($text)) {
		$styles = Array(
			'error'		=> 'warning-red',
			'warning'	=> 'warning-yellow',
			'info'		=> 'warning-blue',
			'success'	=> 'warning-green'
		);
		if(empty($styles[$style])) $style = 'warning';
		echo "<div class='{$styles[$style]}'>$text</div>";
	}
}

// Функция, извлекающая HTML теги
function stripinput($text) {
	if (QUOTES_GPC) $text = stripslashes($text);
	$search = array("&", "\"", "'", "\\", '\"', "\'", "<", ">", "&nbsp;");
	$replace = array("&amp;", "&quot;", "&#39;", "&#92;", "&quot;", "&#39;", "&lt;", "&gt;", " ");
	$text = str_replace($search, $replace, $text);
	
	return $text;
}

// MySQL функции
function dbquery($query) {
	$result = @mysql_query($query);
	if (!$result) {
		echo mysql_error();
		return false;
	} else {
		return $result;
	}
}

function dbresult($query, $row) {
	$result = @mysql_result($query, $row);
	if (!$result) {
		echo mysql_error();
		return false;
	} else {
		return $result;
	}
}

function formatDate($forma,$time)
{
	return gmdate($forma,$time +3600*(3+date("I"))+3600);
}

function time2string($sal,$day=true,$has=true,$min=true,$sek=true)
{
	if($sal > 10)
	{
		$days = preg_replace('/(.*?)\.(.*)/',"\\1",$sal/86400);
		$sal -= $days*86400;
	}
	$h = preg_replace('/(.*?)\.(.*)/',"\\1",$sal/3600);
	$sal -= $h*3600;
	$m = preg_replace('/(.*?)\.(.*)/',"\\1",$sal/60);
	$sal -= $m*60;
	$txt = array(
	'day'=>(substr($days,strlen($days)-1,1)==1) ?"день" : ((substr($days,strlen($days)-1,1)>1 AND (substr($days,strlen($days)-1,1)<5)) ?"дня" : "дней"),
	'h'=>(substr($h,strlen($h)-1,1)==1) ?"час" : ((substr($h,strlen($h)-1,1)>1 AND (substr($h,strlen($h)-1,1)<5)) ?"часа" : "часов"),
	'm'=>(substr($m,strlen($m)-1,1)==1) ?"минуту" : ((substr($m,strlen($m)-1,1)>1 AND (substr($m,strlen($m)-1,1)<5)) ?"минуты" : "минут"),
	's'=>(substr($sal,strlen($sal)-1,1)==1) ?"секунду" : ((substr($sal,strlen($sal)-1,1)>1 AND (substr($sal,strlen($sal)-1,1)<5)) ?"секунды" : "секунд"));
	$return .= ($day && $days >0) ?"{$days} {$txt['day']}": "";
	$return .= ($has && $h >0) ?" {$h} {$txt['h']}": "";
	$return .= ($min && $m >0) ?" {$m} {$txt['m']}": "";
	$return .= ($sek && $sal >0) ?" {$sal} {$txt['s']}": "";
	return $return;
}
function dbarray($query) {
	$result = @mysql_fetch_assoc($query);
	if (!$result) {
		echo mysql_error();
		return false;
	} else {
		return $result;
	}
}

function dbarray_fetch($query) {
	$result = @mysql_fetch_array($query);
	if (!$result) {
		echo mysql_error();
		return false;
	} else {
		return $result;
	}
}
function redirect($location) {
        echo "<script type='text/javascript'>document.location.href='".str_replace("&amp;", "&", $location)."'</script>\n";
        exit;
}

function stripslash($text) {
	if (QUOTES_GPC) { $text = stripslashes($text); }
	return $text;
}

function addslash($text) {
	if (!QUOTES_GPC) {
		$text = addslashes(addslashes($text));
	} else {
		$text = addslashes($text);
	}
	return $text;
}
define("ASR",$settings['AMX']);
function descript($text, $striptags = true) {
	// Функция убирает все скрипты из запроса
	$search = array("40","41","58","65","66","67","68","69","70",
		"71","72","73","74","75","76","77","78","79","80","81",
		"82","83","84","85","86","87","88","89","90","97","98",
		"99","100","101","102","103","104","105","106","107",
		"108","109","110","111","112","113","114","115","116",
		"117","118","119","120","121","122"
		);
	$replace = array("(",")",":","a","b","c","d","e","f","g","h",
		"i","j","k","l","m","n","o","p","q","r","s","t","u",
		"v","w","x","y","z","a","b","c","d","e","f","g","h",
		"i","j","k","l","m","n","o","p","q","r","s","t","u",
		"v","w","x","y","z"
		);
	$entities = count($search);
	for ($i=0; $i < $entities; $i++) {
		$text = preg_replace("#(&\#)(0*".$search[$i]."+);*#si", $replace[$i], $text);
	}
	$text = preg_replace('#(&\#x)([0-9A-F]+);*#si', "", $text);
	$text = preg_replace('#(<[^>]+[/\"\'\s])(onmouseover|onmousedown|onmouseup|onmouseout|onmousemove|onclick|ondblclick|onfocus|onload|xmlns)[^>]*>#iU', ">", $text);
	$text = preg_replace('#([a-z]*)=([\`\'\"]*)script:#iU', '$1=$2nojscript...', $text);
	$text = preg_replace('#([a-z]*)=([\`\'\"]*)javascript:#iU', '$1=$2nojavascript...', $text);
	$text = preg_replace('#([a-z]*)=([\'\"]*)vbscript:#iU', '$1=$2novbscript...', $text);
	$text = preg_replace('#(<[^>]+)style=([\`\'\"]*).*expression\([^>]*>#iU', "$1>", $text);
	$text = preg_replace('#(<[^>]+)style=([\`\'\"]*).*behaviour\([^>]*>#iU', "$1>", $text);
	if ($striptags) {
		do {
			$thistext = $text;
			$text = preg_replace('#</*(applet|meta|xml|blink|link|style|script|embed|object|iframe|frame|frameset|ilayer|layer|bgsound|title|base)[^>]*>#i', "", $text);
		} while ($thistext != $text);
	}
	return $text;
}

function makefilelist($folder, $filter, $sort=true, $type="files") {
	$res = array();
	$filter = explode("|", $filter); 
	$temp = opendir($folder);
	while ($file = readdir($temp)) {
		if ($type == "files" && !in_array($file, $filter)) {
			if (!is_dir($folder.$file)) { $res[] = $file; }
		} elseif ($type == "folders" && !in_array($file, $filter)) {
			if (is_dir($folder.$file)) { $res[] = $file; }
		}
	}
	closedir($temp);
	if ($sort) { sort($res); }
	return $res;
}

function makefileopts($files, $selected = "") {
	$res = "";
	for ($i = 0; $i < count($files); $i++) {
		$sel = ($selected == $files[$i] ? " selected='selected'" : "");
		$res .= "<option value='".$files[$i]."'$sel>".$files[$i]."</option>\n";
	}
	return $res;
}

function servers($server_num_data)
{
	$sql = "SELECT * FROM ".DB_SERVERS." WHERE server_new != 1 AND server_status != 0 AND server_off != 1 ORDER BY server_vip desc, votes DESC".(($server_num_data != 'all') ? " LIMIT $server_num_data" : "");
	$result = dbquery($sql);
	return $result;
}

function dbrows($query) {
	$result = @mysql_num_rows($query);
	return $result;
}
function dbconnect($db_host, $db_user, $db_pass, $db_name) {
	$db_connect = @mysql_connect($db_host, $db_user, $db_pass);
	$db_select = @mysql_select_db($db_name);
	if (!$db_connect) {
		die("<div style='font-family:Verdana;font-size:11px;text-align:center;'><b>Не могу подключиться к MySQL</b><br />".mysql_errno()." : ".mysql_error()."</div>");
	} elseif (!$db_select) {
		die("<div style='font-family:Verdana;font-size:11px;text-align:center;'><b>НЕ могу подключиться к MySQL базе данных</b><br />".mysql_errno()." : ".mysql_error()."</div>");
	}
	
	// Fix кодировки
	mysql_query("SET NAMES 'utf8'");
}

function isValidURL($url) {
	return filter_var($url, FILTER_VALIDATE_URL);
}

function isValidEmail($email) {
	return filter_var($email, FILTER_VALIDATE_EMAIL);
}

function isOnOff($int) {
	if($int == 1) return true;
	if($int == 0) return true;
	return false;
}

function myempty($var) {
	if($var != "") return false;
	return true;
}

function getdomain($url) { 
    preg_match ( 
        "/^(http:\/\/|https:\/\/)?([^\/]+)/i", 
        $url, $matches 
    ); 
    $host = $matches[2];  
    preg_match ( 
        "/[^\.\/]+\.[^\.\/]+$/",  
        $host, $matches 
    );
    return strtolower("{$matches[0]}"); 
}
 
?>
